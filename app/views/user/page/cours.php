<?php
session_start();
require_once __DIR__ . '/../../../app/helper/function.php';
require_once __DIR__ . '/../../../app/Classes/classdao/Crud.php';


$user = Crud::getBy('users', 'id_user', $_SESSION['user_id']);

if (isset($_SESSION['admin_id']) && $_SESSION['admin_id']) {
    Helper::goToPage('/dashboard/admin');
} else if (isset($_SESSION['supadmin_id']) && $_SESSION['supadmin_id']) {
    Helper::goToPage('/dashboard/supadmin');
} else if (!isset($_SESSION['user_id']) && !$_SESSION['user_id']) {
    Helper::goToPage('/auth/login.php');
} else if ($user['statut'] == "inactive" || $user['statut'] == "blocked") {
    Helper::goToPage('/dashboard/user');
}
if (!isset($_SESSION['user_id'])) {
    Helper::goToPage('/auth/login.php');
}


// Récupérer les cours réservés par l'utilisateur
$user_id = $_SESSION['user_id'];
$reservations = Crud::getAllBy('reservations', 'id_user_fk', $user_id);

$courses = [];
if ($reservations) {
    foreach ($reservations as $reservation) {
        $course = Crud::getBy('cours', 'id_cour', $reservation['id_cour_fk']);
        if ($course) {
            $courses[] = $course;
        }
    }
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
                    <a href="catalogueEtCours.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-tags text-xl mr-3"></i>
                        <span>Catalogue et Cours</span>
                    </a>
                    <a href="cours.php"
                        class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-600/20">
                        <i class="fa-solid fa-book-open text-xl mr-3"></i>
                        <span>Mes cours</span>
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
                                <img src="https://ui-avatars.com/api/?name=Étudiant" class="w-8 h-8 rounded-lg"
                                    alt="Admin avatar">
                                <span>Étudiant</span>
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
                    <h1 class="text-2xl font-bold text-white">Mes Cours</h1>
                </div>

                <!-- Courses Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if (empty($courses)): ?>
                        <div class="col-span-full text-center py-10">
                            <i class="fas fa-book-open text-4xl text-white mb-3"></i>
                            <p class="text-white">Vous n'avez pas encore de cours réservés</p>
                            <a href="catalogueEtCours.php" 
                               class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Découvrir les cours
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                                <div class="relative h-48">
                                    <img src="../../../app/action/supadmin/cours/uploads/courses/images/<?php echo htmlspecialchars($course['image_url'] ?: 'default-course.jpg'); ?>"
                                         class="w-full h-full object-cover"
                                         alt="<?php echo htmlspecialchars($course['titre']); ?>">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                </div>
                                
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-white mb-2">
                                        <?php echo htmlspecialchars($course['titre']); ?>
                                    </h3>
                                    <p class="text-gray-300 text-sm mb-4">
                                        <?php echo substr(htmlspecialchars($course['description']), 0, 100) . '...'; ?>
                                    </p>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-blue-300 text-sm">
                                            <i class="fas fa-clock mr-2"></i>
                                            <?php echo date('d/m/Y', strtotime($course['created_at'])); ?>
                                        </span>
                                        <a href="cours-details.php?id=<?php echo $course['id_cour']; ?>" 
                                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            Accéder au cours
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
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