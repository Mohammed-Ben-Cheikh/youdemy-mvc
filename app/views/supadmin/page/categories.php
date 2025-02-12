<?php
require_once __DIR__ . '/../../../app/helper/function.php';
require_once __DIR__ . '/../../../app/Classes/classdao/Crud.php';
session_start();

$user = Crud::getBy('sup_admins', 'id_admin', $_SESSION['supadmin_id']);

if (isset($_SESSION['admin_id']) && $_SESSION['admin_id']) {
    Helper::goToPage('/dashboard/admin');
} else if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    Helper::goToPage('/dashboard/user');
} else if (!isset($_SESSION['supadmin_id']) && !$user['supadmin_id']) {
    Helper::goToPage('/auth/login.php');
} else if ($user['statut'] == "inactive" || $user['statut'] == "blocked") {
    Helper::goToPage('/dashboard/supadmin');
}
?>
<?php
require_once __DIR__ . '/../../../app/Classes/classdao/Crud.php';

$date_filter = $_GET['date'] ?? '';
$search = $_GET['search'] ?? '';

$categories = Crud::getAll('categories');
;

if ($date_filter) {
    $categories = array_filter($categories, function ($r) use ($date_filter) {
        return date('Y-m-d', strtotime($r['created_at'])) === $date_filter;
    });
}

if ($search) {
    $categories = array_filter($categories, function ($r) use ($search) {
        return stripos($r['titre'], $search) !== false;
    });
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
                        class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-600/20">
                        <i class="fas fa-tags text-xl mr-3"></i>
                        <span>Categories et Tags</span>
                    </a>
                    <a href="cours.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fa-solid fa-book-open text-xl mr-3"></i>
                        <span>Ajout de nouveaux cours</span>
                    </a>
                    <a href="inscriptions.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-chart-bar text-xl mr-3"></i>
                        <span class="text-sm">Consultation des Statistiques</span>
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
                                <img src="https://ui-avatars.com/api/?name=Enseignant" class="w-8 h-8 rounded-lg"
                                    alt="Admin avatar">
                                <span>Enseignant</span>
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
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Explorez nos Tags et Catégories</h1>
                    <div class="flex justify-center items-center gap-4">
                        <button onclick="openAddTagModal()"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center"
                            aria-label="Ajouter un tag">
                            Explorez les Tags
                        </button>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Total Reservations -->
                    <div
                        class="bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl p-6 shadow-lg shadow-purple-600/20">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white/60 text-sm font-medium">Total Categorie</p>
                                <h3 class="text-3xl font-bold text-white mt-1">
                                    <?= Crud::countRecords('categories') ?>
                                </h3>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <i class="fas fa-calendar-check text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- En Attente -->
                    <div
                        class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-6 shadow-lg shadow-orange-500/20">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white/60 text-sm font-medium">Total Tags</p>
                                <h3 class="text-3xl font-bold text-white mt-1">
                                    <?= Crud::countRecords('tags') ?>
                                </h3>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <i class="fas fa-clock text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filters Section -->
                <div class="bg-blue-900/50 backdrop-blur-xl rounded-2xl p-6 mb-6 border border-blue-700/50">
                    <form class="grid grid-cols-1 md:grid-cols-3 gap-6" method="GET">
                        <div>
                            <label class="block text-sm font-medium text-blue-300 mb-2">Date</label>
                            <input type="date" name="date"
                                class="w-full bg-blue-800 text-white rounded-lg px-4 py-2.5 border border-blue-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-300 mb-2">Recherche</label>
                            <input type="text" name="search" placeholder="Titre de categorie"
                                class="w-full bg-blue-800 text-white rounded-lg px-4 py-2.5 border border-blue-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg transition-all duration-300 transform hover:scale-[1.02] focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-blue-900">
                                <i class="fas fa-filter mr-2"></i>Filtrer
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Categories Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if (empty($categories)): ?>
                        <div class="col-span-full text-center py-10">
                            <i class="fas fa-folder-open text-4xl text-white mb-3"></i>
                            <p class="text-white">Aucune catégorie trouvée</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($categories as $category): ?>
                            <div
                                class="bg-gray-700 rounded-xl overflow-hidden group hover:shadow-xl transition-all duration-300">
                                <div class="relative h-48">
                                    <img src="../../../app/action/admin/<?php echo htmlspecialchars($category['image_url'] ?: 'img/default-category.jpg'); ?>"
                                        class="w-full h-full object-cover"
                                        alt="<?php echo htmlspecialchars($category['titre']); ?>">
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($category['titre']); ?>
                                        </h3>
                                        <span class="bg-purple-600/20 text-purple-400 px-2 py-1 rounded-lg text-sm">
                                            Categorie N°: <?php echo $category['id_categorie']; ?>
                                        </span>
                                    </div>
                                    <p class="text-gray-400 text-sm mb-3">
                                        <?php echo htmlspecialchars($category['description']); ?>
                                    </p>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-400">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <?php echo date('d/m/Y', strtotime($category['created_at'])); ?>
                                        </span>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    <div id="addTagModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center flex-col justify-start z-50 p-3">
        <div id="message" class="rounded-lg h-16 m-1"></div>
        <div class="bg-white rounded-xl max-w-md w-full mx-4 shadow-2xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Ajouter des Tags</h3>
                    <button onclick="closeAddTagModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags Actuels</label>
                    <div id="tags-container"
                        class="flex flex-wrap items-center gap-2 max-h-44 min-h-[50px] overflow-y-auto p-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let tags = new Set();
        const maxChars = 200;

        // Charger les tags existants au chargement de la page
        document.addEventListener("DOMContentLoaded", () => {
            loadExistingTags();
            setupEventListeners();
        });

        async function loadExistingTags() {
            try {
                const response = await fetch('../../../app/action/admin/tag/TagApiHandler.php?action=get_tags');
                const data = await response.json();

                if (data.success && Array.isArray(data.data)) {
                    tags = new Set(data.data);  // Convert the array of tags to a Set
                    console.log(tags);           // Logs the Set object
                    updateTagsDisplay();         // Update the display with the tags
                } else {
                    showMessage("Aucune donnée de tags disponible", "warning");
                }
            } catch (error) {
                showMessage("Erreur lors du chargement des tags", "error");
            }
        }

        function updateTagsDisplay() {
            const tagsContainer = document.getElementById("tags-container");

            tagsContainer.innerHTML = Array.from(tags).map(tag => `
                <span class="flex items-center gap-2 bg-gradient-to-r from-blue-100 to-blue-300 text-blue-700 px-3 py-1 rounded-full shadow-sm hover:shadow-md transition">
                    <span class="font-bold">#${tag}</span>
                </span>
            `).join("");
        }

        function openAddTagModal() {
            const modal = document.getElementById('addTagModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAddTagModal() {
            const modal = document.getElementById('addTagModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.getElementById("tags-input").value = "";
            document.getElementById("char-limit-msg").classList.add("hidden");
        }

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