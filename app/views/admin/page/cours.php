<?php
require_once __DIR__ . '/../../../app/helper/function.php';
require_once __DIR__ . '/../../../app/Classes/classdao/Crud.php';
session_start();

$user = Crud::getBy('admins', 'id_admin', $_SESSION['admin_id']);

if (isset($_SESSION['supadmin_id']) && $_SESSION['supadmin_id']) {
    Helper::goToPage('/dashboard/supadmin');
} else if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    Helper::goToPage('/dashboard/user');
} else if (!isset($_SESSION['admin_id']) && !$_SESSION['admin_id']) {
    Helper::goToPage('/app/auth/login.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy-Dashboard</title>
    <script src="http://localhost/youdemy/app/js/tailwindcss.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-blue-900 to-blue-800 min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <nav id="sidebar"
            class="transform -translate-x-full md:translate-x-0 fixed md:relative w-72 min-h-screen bg-blue-900/95 backdrop-blur-xl border-r border-blue-700/50 transition-transform duration-300 ease-in-out z-50">
            <!-- Logo Section -->
            <div class="p-4">
                <div
                    class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl p-1 shadow-lg transform hover:scale-105 transition-all">
                    <img src="../img/logo.png" alt="logo" class="h-auto rounded-xl mx-auto">
                </div>
            </div>
            <!-- Navigation Links -->
            <div class="px-3">
                <div class="space-y-1">
                    <a href="../index.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-tachometer-alt text-xl mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="categories.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-tags text-xl mr-3"></i>
                        <span>Categories et Tags</span>
                    </a>
                    <a href="cours.php"
                        class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-600/20">
                        <i class="fa-solid fa-book-open text-xl mr-3"></i>
                        <span>Cours</span>
                    </a>

                    <a href="utilisateurs.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-users text-xl mr-3"></i>
                        <span>Gestion des utilisateurs</span>
                    </a>
                </div>

                <div class="mt-4 pt-4 border-t border-blue-700/50">
                    <a href="statistique.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-chart-pie text-xl mr-3"></i>
                        <span>Statistique</span>
                    </a>
                    <a href="avis.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-star text-xl mr-3"></i>
                        <span>Avis</span>
                    </a>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col max-h-screen overflow-hidden">
            <!-- Top Navbar -->
            <nav class="bg-blue-900/95 backdrop-blur-xl border-b border-blue-700/50">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center flex-1">
                            <button id="sidebarToggle"
                                class="p-2 rounded-lg bg-blue-800 text-white hover:bg-blue-700 md:hidden">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="hidden md:block ml-4 flex-1 max-w-xl">
                                <div class="relative">
                                    <input type="search"
                                        class="w-full bg-blue-800 text-white rounded-lg pl-10 pr-4 py-2 border border-blue-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Search...">
                                    <div class="absolute left-3 top-2.5 text-blue-400">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative" id="userDropdown">
                            <button id="dropdownButton"
                                class="flex items-center gap-3 p-2 rounded-lg bg-blue-800 text-white hover:bg-blue-700 transition-colors">
                                <img src="https://ui-avatars.com/api/?name=Admin" class="w-8 h-8 rounded-lg"
                                    alt="Admin avatar">
                                <span>Admin</span>
                                <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                            </button>
                            <div id="dropdownMenu"
                                class="absolute right-0 w-48 mt-2 py-2 bg-blue-900 rounded-lg shadow-xl hidden border border-blue-700/50">
                                <a href="#"
                                    class="flex items-center px-4 py-2 text-blue-300 hover:bg-blue-800 hover:text-white">
                                    <i class="fas fa-user-circle mr-2"></i> Profile
                                </a>

                                <hr class="my-2 border-blue-700">
                                <a href="../../authentification/logout.php"
                                    class="flex items-center px-4 py-2 text-red-400 hover:bg-blue-800 hover:text-red-300">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-blue-900 to-blue-800 p-6">
                <!-- Table Section -->
                <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/20">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-white">Gestion des Cours</h2>
                        <div class="flex gap-4">
                            <select id="statusFilter"
                                class="bg-blue-800 text-white rounded-lg px-4 py-2 border border-blue-700">
                                <option value="">Tous les statuts</option>
                                <option value="active">Actif</option>
                                <option value="inactive">En attente</option>
                                <option value="blocked">Bloqué</option>
                            </select>
                            <input type="text" id="searchCourse" placeholder="Rechercher un cours..."
                                class="bg-blue-800 text-white rounded-lg px-4 py-2 border border-blue-700">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-white/60 border-b border-white/10">
                                    <th class="px-6 py-3 text-left">Cours</th>
                                    <th class="px-6 py-3 text-left">Catégorie</th>
                                    <th class="px-6 py-3 text-left">Enseignant</th>
                                    <th class="px-6 py-3 text-left">Statut</th>
                                    <th class="px-6 py-3 text-left">Date</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-white" id="coursesTableBody">
                                <?php
                                require_once '../../../app/Classes/classdao/Crud.php';
                                $courses = Crud::getAll('cours');

                                foreach ($courses as $course):
                                    $category = Crud::getBy('categories', 'id_categorie', $course['id_categorie_fk']);
                                    $teacher = Crud::getBy('sup_admins', 'id_admin', $course['id_enseignant_fk']);
                                    ?>
                                    <tr class="border-b border-white/10 hover:bg-white/5">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <img src="http://localhost/youdemy/app/action/supadmin/cours/uploads/courses/images/<?php echo htmlspecialchars($course['image_url']); ?>"
                                                    class="h-12 w-12 rounded-lg object-cover"
                                                    alt="<?php echo htmlspecialchars($course['titre']); ?>">
                                                <div>
                                                    <div class="font-medium"><?php echo htmlspecialchars($course['titre']); ?></div>
                                                    <div class="text-sm text-white/60 line-clamp-1">
                                                        <?php echo htmlspecialchars($course['description']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4"><?php echo htmlspecialchars($category['titre'] ?? 'N/A'); ?></td>
                                        <td class="px-6 py-4"><?php echo htmlspecialchars($teacher['nom'] ?? 'N/A') . ' ' . htmlspecialchars($teacher['prenom'] ?? ''); ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-sm <?php echo getStatusClass($course['statut']); ?>">
                                                <?php echo ucfirst($course['statut']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-white/60">
                                            <?php echo date('d/m/Y', strtotime($course['created_at'])); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end space-x-3">
                                                <?php if ($course['statut'] !== 'active'): ?>
                                                    <button onclick="updateCourseStatus(<?php echo $course['id_cour']; ?>, 'active')"
                                                        class="text-green-400 hover:text-green-300">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($course['statut'] !== 'inactive'): ?>
                                                    <button onclick="updateCourseStatus(<?php echo $course['id_cour']; ?>, 'inactive')"
                                                        class="text-yellow-400 hover:text-yellow-300">
                                                        <i class="fas fa-pause"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($course['statut'] !== 'blocked'): ?>
                                                    <button onclick="updateCourseStatus(<?php echo $course['id_cour']; ?>, 'blocked')"
                                                        class="text-red-400 hover:text-red-300">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php
    function getStatusClass($status) {
        return match (strtolower($status)) {
            'active' => 'bg-green-500/20 text-green-500 border border-green-500/30',
            'inactive' => 'bg-amber-500/20 text-amber-500 border border-amber-500/30',
            'blocked' => 'bg-rose-500/20 text-rose-500 border border-rose-500/30',
            default => 'bg-gray-500/20 text-gray-500 border border-gray-500/30'
        };
    }
    ?>

    <script>
        // AJAX function to update course status
        async function updateCourseStatus(courseId, status) {
            try {
                const response = await fetch('../../../app/action/admin/course/CourseApiHandler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=update_status&id=${courseId}&status=${status}`
                });

                const data = await response.json();

                if (data.success) {
                    showNotification('Statut du cours mis à jour avec succès', 'success');
                    // Refresh the table
                    location.reload();
                } else {
                    throw new Error(data.message || 'Erreur lors de la mise à jour');
                }
            } catch (error) {
                showNotification(error.message, 'error');
            }
        }

        // Show notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg transform transition-all duration-300 z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } text-white`;

            notification.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-${type === 'success' ? 'check' : 'times'}-circle"></i>
                        <p>${message}</p>
                    </div>
                `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Filter functionality
        document.getElementById('statusFilter').addEventListener('change', function (e) {
            const status = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#coursesTableBody tr');

            rows.forEach(row => {
                const statusCell = row.querySelector('td:nth-child(4)');
                const rowStatus = statusCell.textContent.trim().toLowerCase();

                row.style.display = !status || rowStatus === status ? '' : 'none';
            });
        });

        document.getElementById('searchCourse').addEventListener('input', function (e) {
            const search = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#coursesTableBody tr');

            rows.forEach(row => {
                const title = row.querySelector('td:first-child').textContent.toLowerCase();
                const category = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const teacher = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                const matches = title.includes(search) ||
                    category.includes(search) ||
                    teacher.includes(search);

                row.style.display = matches ? '' : 'none';
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get DOM elements
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const content = document.querySelector('.flex-1');

            // Toggle sidebar on mobile
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('-translate-x-full');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 768 &&
                    !sidebar.contains(e.target) &&
                    !sidebarToggle.contains(e.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Handle resize events
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    if (window.innerWidth >= 768) {
                        sidebar.classList.remove('-translate-x-full');
                    }
                }, 250);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const chevronIcon = dropdownButton.querySelector('.fa-chevron-down');
            let isOpen = false;

            // Function to toggle dropdown
            const toggleDropdown = () => {
                isOpen = !isOpen;
                dropdownMenu.classList.toggle('hidden');
                chevronIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0)';
            };

            // Toggle on button click
            dropdownButton.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleDropdown();
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    isOpen = false;
                    dropdownMenu.classList.add('hidden');
                    chevronIcon.style.transform = 'rotate(0)';
                }
            });

            // Close on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !dropdownMenu.classList.contains('hidden')) {
                    isOpen = false;
                    dropdownMenu.classList.add('hidden');
                    chevronIcon.style.transform = 'rotate(0)';
                }
            });

            // Prevent menu from closing when clicking inside it
            dropdownMenu.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    </script>
</body>

</html>