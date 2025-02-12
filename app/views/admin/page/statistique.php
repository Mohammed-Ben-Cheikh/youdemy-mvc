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
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
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
                        class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-600/20">
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
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
                    <!-- Total Reservations -->
                    <div
                        class="bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl p-6 shadow-lg shadow-purple-600/20">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white/60 text-sm font-medium">Total Réservations</p>
                                <h3 class="text-3xl font-bold text-white mt-1">0</h3>
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
                                <p class="text-white/60 text-sm font-medium">En Attente</p>
                                <h3 class="text-3xl font-bold text-white mt-1">0</h3>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <i class="fas fa-clock text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Approuvées -->
                    <div
                        class="bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl p-6 shadow-lg shadow-green-500/20">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white/60 text-sm font-medium">Approuvées</p>
                                <h3 class="text-3xl font-bold text-white mt-1">0</h3>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <i class="fas fa-check text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Refusées -->
                    <div
                        class="bg-gradient-to-br from-red-500 to-rose-500 rounded-2xl p-6 shadow-lg shadow-rose-500/20">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white/60 text-sm font-medium">Refusées</p>
                                <h3 class="text-3xl font-bold text-white mt-1">0</h3>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <i class="fas fa-ban text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Terminées -->
                    <div
                        class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 shadow-lg shadow-blue-500/20">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white/60 text-sm font-medium">Terminées</p>
                                <h3 class="text-3xl font-bold text-white mt-1">0</h3>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <i class="fas fa-flag-checkered text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="bg-blue-900/50 backdrop-blur-xl rounded-2xl p-6 mb-6 border border-blue-700/50">
                    <form class="grid grid-cols-1 md:grid-cols-4 gap-6" method="GET">
                        <div>
                            <label class="block text-sm font-medium text-blue-300 mb-2">Statut</label>
                            <select name="status"
                                class="w-full bg-blue-800 text-white rounded-lg px-4 py-2.5 border border-blue-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Tous les statuts</option>
                                <option value="en attente">En attente</option>
                                <option value="approuvée">Approuvée</option>
                                <option value="refusée">Refusée</option>
                                <option value="terminée">Terminée</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-300 mb-2">Date</label>
                            <input type="date" name="date"
                                class="w-full bg-blue-800 text-white rounded-lg px-4 py-2.5 border border-blue-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-300 mb-2">Recherche</label>
                            <input type="text" name="search" placeholder="Client, véhicule ou lieu..."
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

                <!-- Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Content will be dynamically added here -->
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