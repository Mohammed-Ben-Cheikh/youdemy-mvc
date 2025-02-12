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
                        class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-600/20">
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
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Total Reservations -->
                    <div
                        class="bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl p-6 shadow-lg shadow-purple-600/20">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white/60 text-sm font-medium">Total Utilisateurs</p>
                                <h3 class="text-3xl font-bold text-white mt-1"><?= Crud::countRecords('users')+Crud::countRecords('sup_admins')  ?></h3>
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
                                <p class="text-white/60 text-sm font-medium">Enseignant</p>
                                <h3 class="text-3xl font-bold text-white mt-1"><?= Crud::countRecords('sup_admins') ?></h3>
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
                                <p class="text-white/60 text-sm font-medium">Étudiant</p>
                                <h3 class="text-3xl font-bold text-white mt-1"><?= Crud::countRecords('users')?></h3>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <i class="fas fa-check text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Users Management -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b border-gray-200">
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                            <div>
                                <h1 class="text-2xl font-bold">Gestion des Utilisateurs</h1>
                                <p class="text-gray-600">Gérez les utilisateurs de votre plateforme</p>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 space-x-3">
                            <div class="flex-1 max-w-md relative border-4 border-gray-950 p-2 rounded-lg">
                                <input type="text" id="searchInput" placeholder="Rechercher par nom, email..."
                                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <div class="flex items-center space-x-4 mb-6 border-4 border-gray-950 p-2 rounded-lg">
                                <!-- Filtre de rôle -->
                                <select id="roleFilter" aria-label="Filtrer par rôle"
                                    class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Tous les rôles</option>
                                    <option value="User">Utilisateur</option>
                                    <option value="Moderator">Modérateur</option>
                                </select>

                                <!-- Filtre de statut -->
                                <select id="statusFilter" aria-label="Filtrer par statut"
                                    class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Tous les statuts</option>
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                    <option value="blocked">Bloqué</option>
                                </select>

                                <!-- Bouton pour appliquer les filtres -->
                                <button id="applyFilters"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Appliquer les filtres
                                </button>

                                <!-- Bouton pour réinitialiser les filtres -->
                                <button id="resetFilters"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    Réinitialiser
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Utilisateur
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rôle
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dernière connexion
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Table rows will be inserted here by JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-600 text-sm">
                                <span>Afficher</span>
                                <select id="perPage" onchange="perPage()"
                                    class="mx-2 rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span>entrées par page</span>
                            </div>
                            <div id="pagination" class="flex items-center space-x-2">
                                <!-- Pagination buttons will be inserted here by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Modal -->
                <div id="successModal"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-lg w-full max-w-md p-6">
                        <div class="text-center">
                            <div
                                class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                                <i class="fas fa-check text-green-600 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Utilisateur ajouté avec succès!</h3>
                            <p class="text-sm text-gray-500 mb-6">L'utilisateur a été créé et notifié par email.</p>
                            <button onclick="closeModal('successModal')"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="../js/utilisateurs.js"></script>
    <script src="../js/sidebar.js"></script>
</body>

</html>