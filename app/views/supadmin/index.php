<?php
require_once __DIR__ . '/../../app/helper/function.php';
session_start();

if (isset($_SESSION['admin_id']) && $_SESSION['admin_id']) {
    Helper::goToPage('/dashboard/admin');
} else if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    Helper::goToPage('/dashboard/user');
} else if (!isset($_SESSION['supadmin_id']) && !$_SESSION['supadmin_id']) {
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
                    <img src="./img/logo.png" alt="logo" class="h-auto rounded-xl mx-auto">
                </div>
            </div>
            <!-- Navigation Links -->
            <div class="px-3">
                <div class="space-y-1">
                    <a href="index.php"
                        class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-600/20">
                        <i class="fas fa-tachometer-alt text-xl mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="./page/categories.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-tags text-xl mr-3"></i>
                        <span>Categories et Tags</span>
                    </a>
                    <a href="./page/cours.php"
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fa-solid fa-book-open text-xl mr-3"></i>
                        <span>Ajout de nouveaux cours</span>
                    </a>
                    <a href="./page/inscriptions.php"
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
                                <a href="../../auth/logout.php"
                                    class="flex items-center px-4 py-2 text-red-400 hover:bg-blue-800 hover:text-red-300">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-blue-900 to-blue-800 p-8">
                <div class="container mx-auto max-w-7xl">
                    <!-- Status Section -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-white mb-6 flex items-center">
                            <i class="fas fa-chart-line mr-3"></i>
                            État du Compte
                        </h2>
                        <div id="accountStatus" class="grid md:grid-cols-1 lg:grid-cols-1 gap-8">
                            <?php
                            require '../../app/classes/classdao/Crud.php';
                            if ($_SESSION['admin_role'] == 2) {
                                $sup_admin = Crud::getBy('sup_admins', 'id_admin', $_SESSION['supadmin_id']);
                                $status = $sup_admin['statut'];

                                $statusCards = [
                                    'inactive' => [
                                        'icon' => 'hourglass-half',
                                        'color' => 'yellow',
                                        'title' => 'En Attente de Validation',
                                        'message' => 'Votre compte est en cours de traitement. Notre équipe examine actuellement votre demande.',
                                        'details' => [
                                            'Délai estimé' => '24-48 heures',
                                            'Étape actuelle' => 'Vérification des informations',
                                            'Prochaine étape' => 'Activation du compte'
                                        ]
                                    ],
                                    'active' => [
                                        'icon' => 'check-circle',
                                        'color' => 'green',
                                        'title' => 'Compte Actif',
                                        'message' => 'Votre compte est pleinement opérationnel. Profitez de toutes les fonctionnalités.',
                                        'details' => [
                                            'Statut' => 'Vérifié et Approuvé',
                                            'Accès' => 'Complet',
                                            'Support' => 'Premium'
                                        ]
                                    ],
                                    'blocked' => [
                                        'icon' => 'ban',
                                        'color' => 'red',
                                        'title' => 'Compte Bloqué',
                                        'message' => 'Votre compte a été suspendu. Veuillez contacter notre équipe support.',
                                        'details' => [
                                            'Raison' => 'À déterminer',
                                            'Support' => 'Prioritaire',
                                            'Résolution' => 'En attente'
                                        ]
                                    ]
                                ];

                                if (isset($statusCards[$status])) {
                                    $card = $statusCards[$status];
                                    ?>
                                    <div
                                        class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl p-8 border border-white/20 transform hover:scale-[1.02] transition-all duration-300">
                                        <div class="flex items-start justify-between mb-6">
                                            <div class="flex-1">
                                                <div class="text-4xl text-<?php echo $card['color']; ?>-500 mb-4">
                                                    <i class="fas fa-<?php echo $card['icon']; ?>"></i>
                                                </div>
                                                <h3 class="text-2xl font-bold text-white mb-3"><?php echo $card['title']; ?>
                                                </h3>
                                                <p class="text-blue-200 text-lg leading-relaxed mb-6">
                                                    <?php echo $card['message']; ?></p>
                                            </div>
                                            <span
                                                class="px-4 py-2 rounded-full text-sm font-medium bg-<?php echo $card['color']; ?>-500/20 text-<?php echo $card['color']; ?>-300 border border-<?php echo $card['color']; ?>-500/30">
                                                <?php echo ucfirst($status); ?>
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-3 gap-6 mt-6">
                                            <?php foreach ($card['details'] as $label => $value): ?>
                                                <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                                                    <h4 class="text-blue-300 text-sm mb-2"><?php echo $label; ?></h4>
                                                    <p class="text-white font-semibold"><?php echo $value; ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <div class="mt-8 flex gap-4">
                                            <a href="#"
                                                class="flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                                <i class="fas fa-headset mr-2"></i>
                                                Contacter le Support
                                            </a>
                                            <a href="#"
                                                class="flex items-center justify-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors">
                                                <i class="fas fa-book mr-2"></i>
                                                Guide d'utilisation
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                        <p class="font-bold">Accès Refusé</p>
                                        <p>Vous n\'avez pas les droits nécessaires pour accéder à cette page.</p>
                                      </div>';
                            }
                            ?>
                        </div>
                    </div>
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