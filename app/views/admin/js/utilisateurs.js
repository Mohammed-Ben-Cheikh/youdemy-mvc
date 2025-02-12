var users = [];
var filteredUsers = [];
var currentPage = 1;
var itemsPerPage = 10;

// Add loading state handler
function setLoading(isLoading) {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (isLoading) {
        if (!loadingOverlay) {
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50';
            overlay.innerHTML = `
                <div class="bg-white rounded-lg p-4 flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
                    <span class="text-gray-700">Chargement...</span>
                </div>
            `;
            document.body.appendChild(overlay);
        }
    } else if (loadingOverlay) {
        loadingOverlay.remove();
    }
}

// Fetch users from the API
async function fetchUsers() {
    setLoading(true);
    const url = '../../../app/action/admin/user/UserApiHandler.php?action=get_users';
    try {
        const response = await fetch(url);
        const data = await response.json();
        if (data.success) {
            users = [];
            for (const key in data) {
                if (data.hasOwnProperty(key) && typeof data[key] === 'object') {
                    const user = data[key];
                    user.id = user.id_admin || user.id_user; // Standardize ID property
                    users.push(user);
                }
            }
            applyFilters(); // Apply initial filters
            updateTable(filteredUsers, currentPage, itemsPerPage);
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error fetching users:', error);
        showNotification('Erreur lors de la récupération des utilisateurs.', 'error');
    } finally {
        setLoading(false);
    }
}

// Apply filters to users
function applyFilters() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    filteredUsers = users.filter(user =>
        user.nom.toLowerCase().includes(searchTerm) ||
        user.prenom.toLowerCase().includes(searchTerm) ||
        user.email.toLowerCase().includes(searchTerm) 
    );
    updateTable(filteredUsers, currentPage, itemsPerPage);
}

function filter() {
    const roleFilter = document.getElementById('roleFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;

    let filteredUsers = users;

    // Appliquer les filtres selon les conditions
    if (roleFilter) {
        filteredUsers = filteredUsers.filter(user => user.role === roleFilter);
        updateTable(filteredUsers, currentPage, itemsPerPage)
    }
    if (statusFilter) {
        filteredUsers = filteredUsers.filter(user => user.statut === statusFilter);
        updateTable(filteredUsers, currentPage, itemsPerPage)
    }

    // Mettre à jour la table si des filtres sont appliqués
    if (roleFilter || statusFilter) {
        updateTable(filteredUsers, currentPage, itemsPerPage);
    } else {
        // Recharger tous les utilisateurs si aucun filtre n'est appliqué
        fetchUsers();
    }
}

// Gestion du bouton "Appliquer les filtres"
document.getElementById('applyFilters').addEventListener('click', filter);

// Gestion du bouton "Réinitialiser les filtres"
document.getElementById('resetFilters').addEventListener('click', () => {
    document.getElementById('roleFilter').value = '';
    document.getElementById('statusFilter').value = '';
    fetchUsers(); // Recharger tous les utilisateurs
});

// Update table display
function updateTable(filteredUsers, currentPage, itemsPerPage) {
    const tableBody = document.getElementById('usersTableBody');
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedUsers = filteredUsers.slice(start, end);
    tableBody.innerHTML = paginatedUsers.map(user => `
<tr class="hover:bg-gray-50">
    <td class="px-6 py-4">
        <div class="flex items-center space-x-3">
            <img src="/api/placeholder/40/40" class="h-10 w-10 rounded-full" alt="${user.nom} ${user.prenom}">
            <div>
                <div class="font-medium">${user.nom} ${user.prenom}</div>
                <div class="text-sm text-gray-500">${user.email}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <span class="px-2 py-1 text-sm rounded-full ${getRoleBadgeClass(user.role)}">
            ${user.role}
        </span>
    </td>
    <td class="px-6 py-4">
        <span class="px-2 py-1 text-sm rounded-full ${getStatusBadgeClass(user.statut)}">
            ${capitalizeFirstLetter(user.statut)}
        </span>
    </td>
    <td class="px-6 py-4 text-sm text-gray-500">
        ${formatDate(user.lastLogin)}
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center space-x-3">
            <button data-action="toggle-status" data-user-id="${user.id}" data-new-status="${user.statut === 'active' ? 'inactive' : 'active'}" data-user-type="${user.role}" class="text-yellow-600 hover:text-yellow-800">
                ${user.statut === 'active' ? 'désactiver' : 'activer'}
            </button>
            <button data-action="delete-user" data-user-id="${user.id}" data-user-type="${user.role}" class="text-red-600 hover:text-red-800">
                ${user.statut === 'blocked' ? '' : 'bloquer'}
            </button>
        </div>
    </td>
</tr>
`).join('');
    updatePagination(currentPage, Math.ceil(filteredUsers.length / itemsPerPage));
}

// Toggle user status
async function toggleUserStatus(userId, newStatus, userType) {

    const action = userType === 'Moderator' ? 'update_sup_admin' : 'update_user';
    const response = await fetch('../../../app/action/admin/user/UserApiHandler.php?action=' + action, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            statut: newStatus,
            id: userId
        })
    });
    const data = await response.json();
    if (data.success) {
        showNotification('Statut mis à jour avec succès.', 'success');
        fetchUsers();
    } else {
        showNotification('Erreur lors de la mise à jour du statut.', 'error');
    }
}

// Delete user
async function deleteUser(userId, userType) {
    const statut = 'blocked';
    const action = userType === 'Moderator' ? 'update_sup_admin' : 'update_user';
    const response = await fetch('../../../app/action/admin/user/UserApiHandler.php?action=' + action, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            statut: statut,
            id: userId
        })
    });
    const data = await response.json();
    if (data.success) {
        showNotification('Utilisateur bloquer avec succès.', 'success');
        fetchUsers();
    } else {
        showNotification('Erreur lors de bloquer de l\'utilisateur.', 'error');
    }
}

// Update table display
function updateTable(filteredUsers, currentPage, itemsPerPage) {
    const tableBody = document.getElementById('usersTableBody');
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedUsers = filteredUsers.slice(start, end);
    tableBody.innerHTML = paginatedUsers.map(user => `
<tr class="hover:bg-gray-50">
    <td class="px-6 py-4">
        <div class="flex items-center space-x-3">
            <img src="https://ui-avatars.com/api/?name=${user.nom}" class="h-10 w-10 rounded-full" alt="${user.nom}">
            <div>
                <div class="font-medium">${user.nom + ' ' + user.prenom}</div>
                <div class="text-sm text-gray-500">${user.email}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <span class="px-2 py-1 text-sm rounded-full ${getRoleBadgeClass(user.role)}">
            ${user.role}
        </span>
    </td>
    <td class="px-6 py-4">
        <span class="px-2 py-1 text-sm rounded-full ${getStatusBadgeClass(user.status)}">
            ${capitalizeFirstLetter(user.statut)}
        </span>
    </td>
    <td class="px-6 py-4 text-sm text-gray-500">
        ${formatDate(user.last_login)}
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center space-x-3">
            <button data-action="toggle-status" data-user-id="${user.id}" data-new-status="${user.statut === 'active' ? 'inactive' : 'active'}" data-user-type="${user.role}" class="text-yellow-600 hover:text-yellow-800">
                ${user.statut === 'active' ? 'désactiver' : 'activer'}
            </button>
            <button data-action="delete-user" data-user-id="${user.id}" data-user-type="${user.role}" class="text-red-600 hover:text-red-800">
                ${user.statut === 'blocked' ? '' : 'bloquer'}
            </button>
        </div>
    </td>
</tr>
`).join('');
    updatePagination(currentPage, Math.ceil(filteredUsers.length / itemsPerPage));
}

// Update pagination
function updatePagination(currentPage, totalPages) {
    const pagination = document.getElementById('pagination');
    let paginationHTML = '';
    // Previous button
    paginationHTML += `
<button onclick="changePage(${currentPage - 1})" 
        class="px-3 py-1 rounded-md ${currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100'}"
        ${currentPage === 1 ? 'disabled' : ''}>
    <i class="fas fa-chevron-left"></i>
</button>
`;
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `
    <button onclick="changePage(${i})" 
            class="px-3 py-1 rounded-md ${currentPage === i ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100'}">
        ${i}
    </button>
`;
    }
    // Next button
    paginationHTML += `
<button onclick="changePage(${currentPage + 1})" 
        class="px-3 py-1 rounded-md ${currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100'}"
        ${currentPage === totalPages ? 'disabled' : ''}>
    <i class="fas fa-chevron-right"></i>
</button>
`;
    pagination.innerHTML = paginationHTML;
}

// Get role badge class
function getRoleBadgeClass(role) {
    const classes = {
        'Moderator': 'bg-blue-100 text-blue-800',
        'User': 'bg-gray-100 text-gray-800'
    };
    return classes[role] || 'bg-gray-100 text-gray-800';
}

// Get status badge class
function getStatusBadgeClass(status) {
    const classes = {
        'Active': 'bg-green-100 text-green-800',
        'Inactive': 'bg-yellow-100 text-yellow-800',
        'Blocked': 'bg-red-100 text-red-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
}

// Capitalize first letter
function capitalizeFirstLetter(string) {
    if (typeof string === 'string' && string.length > 0) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    return string; // Return as is if not a string or empty
}

// Format date
function formatDate(dateString) {
    return new Date(dateString).toLocaleString('fr-FR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Enhanced notification system
function showNotification(message, type = 'success') {
    const notificationId = 'notification-' + Date.now();
    const notification = document.createElement('div');
    notification.id = notificationId;
    notification.className = `notification fixed top-4 right-4 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full z-50 
        ${type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 
          type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' : 
          'bg-blue-100 text-blue-800 border border-blue-200'}`;
    
    notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 
                           type === 'error' ? 'exclamation-circle' : 
                           'information-circle'} text-xl"></i>
            <p class="flex-1">${message}</p>
            <button onclick="this.parentElement.parentElement.remove()" 
                    class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="h-1 bg-${type === 'success' ? 'green' : 
                              type === 'error' ? 'red' : 
                              'blue'}-200 mt-2 notification-progress"></div>
    `;

    document.body.appendChild(notification);
    
    // Animate entrance
    requestAnimationFrame(() => {
        notification.classList.remove('translate-x-full');
    });

    // Progress bar animation
    const progress = notification.querySelector('.notification-progress');
    progress.style.animation = 'notification-progress 5s linear forwards';

    // Remove after timeout
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Change page
function changePage(page) {
    if (page >= 1 && page <= Math.ceil(filteredUsers.length / itemsPerPage)) {
        currentPage = page;
        updateTable(filteredUsers, currentPage, itemsPerPage);
    }
}

function perPage() {
    const perPage = document.getElementById('perPage').value;
    itemsPerPage = perPage;
    updateTable(filteredUsers, currentPage, itemsPerPage);
}

// Set up event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Fetch initial users
    fetchUsers()
        .catch(error => console.error('Error initializing users:', error));

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', applyFilters);

    // Pagination event listener
    document.getElementById('pagination').addEventListener('click', (e) => {
        if (e.target.tagName === 'BUTTON' && !e.target.disabled) {
            const page = parseInt(e.target.textContent);
            if (!isNaN(page)) {
                changePage(page);
            }
        }
    });
});

// Add event delegation for better performance
document.addEventListener('click', (e) => {
    const target = e.target;
    
    // Handle status toggle buttons
    if (target.matches('[data-action="toggle-status"]')) {
        e.preventDefault();
        const userId = target.dataset.userId;
        const newStatus = target.dataset.newStatus;
        const userType = target.dataset.userType;
        toggleUserStatus(userId, newStatus, userType);
    }
    
    // Handle delete buttons
    if (target.matches('[data-action="delete-user"]')) {
        e.preventDefault();
        const userId = target.dataset.userId;
        const userType = target.dataset.userType;
        if (confirm('Êtes-vous sûr de vouloir bloquer cet utilisateur ?')) {
            deleteUser(userId, userType);
        }
    }
});