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
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Gestion des Catégories</h1>
                    <div class="flex justify-center items-center gap-4">
                        <button onclick="openAddModal()"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Nouvelle Catégorie
                        </button>
                        <button onclick="openAddTagModal()"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Gère Les Tags
                        </button>
                    </div>
                </div>
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Total Reservations -->
                    <div
                        class="bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl p-6 shadow-lg shadow-purple-600/20">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white/60 text-sm font-medium">Total Catégories</p>
                                <h3 class="text-3xl font-bold text-white mt-1"><?= Crud::countRecords('categories') ?></h3>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <i class="fas fa-calendar-check text-2xl text-white"></i>
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
                                    <div
                                        class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div class="flex space-x-2">
                                            <button class="p-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors"
                                                onclick="editCategory(<?php echo $category['id_categorie']; ?>)">
                                                <i class="fas fa-edit text-white"></i>
                                            </button>
                                            <button class="p-2 bg-red-600 rounded-lg hover:bg-red-700 transition-colors"
                                                onclick="deleteCategory(<?php echo $category['id_categorie']; ?>)">
                                                <i class="fas fa-trash text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($category['titre']); ?>
                                        </h3>
                                        <span class="bg-purple-600/20 text-purple-400 px-2 py-1 rounded-lg text-sm">
                                            <?= 1
                                                // require_once '../../app/controller/vehicules.php';
                                                // $vehicleCount = Vehicule::countByCategory($category['id_categorie']);
                                                // echo $vehicleCount . ' véhicule' . ($vehicleCount > 1 ? 's' : '');
                                                ?>
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
    <div id="addTagModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center flex-col justify-start z-50 p-3">
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
                    <p id="tag-input-help" class="mt-2 text-sm text-gray-500">Appuyez sur Entrée pour ajouter un tag.
                    </p>
                </div>
                <form id="addTagForm" class="space-y-4" onsubmit="handleSubmit(event)">
                    <div>
                        <label for="tags-input" class="block text-sm font-medium text-gray-700 mb-2">
                            Ajouter un tag et ajouter ',' pour Insertion en masse de tags (max 200 caractères)
                        </label>
                        <input type="text" id="tags-input" maxlength="200"
                            class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Tapez un tag et appuyez sur Entrée">
                        <p id="char-limit-msg" class="text-sm text-red-500 hidden">Limite de 200 caractères atteinte</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-gray-900 rounded-xl max-w-md w-full mx-4 shadow-2xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Ajouter une Catégorie</h3>
                    <button onclick="closeAddModal()" class="text-gray-400 hover:text-white transition-colors"
                        aria-label="Fermer">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="addCategoryForm" class="space-y-4" onsubmit="handleSubmit(event)"
                    enctype="multipart/form-data">
                    <div>
                        <label for="categoryName" class="block text-sm font-medium text-gray-400 mb-2">Nom de la
                            catégorie *</label>
                        <input type="text" id="categoryName" name="categoryName" required
                            class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 transition-all border border-gray-700"
                            placeholder="Entrez le nom de la catégorie">
                        <div class="text-red-500 text-xs mt-1 hidden" id="categoryNameError"></div>
                    </div>

                    <div>
                        <label for="categoryDesc" class="block text-sm font-medium text-gray-400 mb-2">Description
                            *</label>
                        <textarea id="categoryDesc" name="categoryDesc" required
                            class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 transition-all border border-gray-700"
                            rows="3" placeholder="Décrivez la catégorie"></textarea>
                        <div class="text-red-500 text-xs mt-1 hidden" id="categoryDescError"></div>
                    </div>

                    <div class="relative">
                        <div class="flex items-center justify-center w-full">
                            <label for="categoryImage"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-700 bg-gray-800 border-gray-600 hover:border-purple-600 group transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-400 group-hover:text-purple-500"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Cliquez
                                            pour télécharger</span> ou glissez et déposez</p>
                                    <p class="text-xs text-gray-400">PNG, JPG or WEBP (MAX. 2Mo)</p>
                                </div>
                                <div id="fileInfo"
                                    class="hidden absolute bottom-3 left-3 right-3 text-sm text-gray-400">
                                    <span id="fileName"></span>
                                </div>
                                <div id="imagePreview"
                                    class="hidden absolute top-2 right-2 w-16 h-16 rounded-lg overflow-hidden bg-gray-700">
                                    <img src="" alt="Aperçu" class="w-full h-full object-cover">
                                </div>
                            </label>
                            <input type="file" id="categoryImage" name="categoryImage" required accept="image/*"
                                class="hidden" onchange="handleFileSelect(event)">
                        </div>
                        <div class="text-red-500 text-xs mt-1 hidden" id="categoryImageError"></div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeAddModal()"
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" id="submitBtn"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center">
                            <span>Ajouter</span>
                            <div id="loadingSpinner" class="hidden ml-2">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-gray-900 rounded-xl max-w-md w-full mx-4 shadow-2xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Modifier la Catégorie</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="editCategoryForm" class="space-y-4" onsubmit="handleEditSubmit(event)"
                    enctype="multipart/form-data">
                    <input type="hidden" id="editCategoryId" name="categoryId">
                    <div>
                        <label for="editCategoryName" class="block text-sm font-medium text-gray-400 mb-2">Nom
                            de la catégorie *</label>
                        <input type="text" id="editCategoryName" name="categoryName" required
                            class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 transition-all border border-gray-700"
                            placeholder="Entrez le nom de la catégorie">
                        <div class="text-red-500 text-xs mt-1 hidden" id="editCategoryNameError"></div>
                    </div>

                    <div>
                        <label for="editCategoryDesc" class="block text-sm font-medium text-gray-400 mb-2">Description
                            *</label>
                        <textarea id="editCategoryDesc" name="categoryDesc" required
                            class="w-full bg-gray-800 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 transition-all border border-gray-700"
                            rows="3" placeholder="Décrivez la catégorie"></textarea>
                        <div class="text-red-500 text-xs mt-1 hidden" id="editCategoryDescError"></div>
                    </div>

                    <div class="relative">
                        <div class="flex items-center justify-center w-full">
                            <label for="editCategoryImage"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-700 bg-gray-800 border-gray-600 hover:border-purple-600 group transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-400 group-hover:text-purple-500"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Cliquez
                                            pour télécharger</span> ou glissez et déposez</p>
                                    <p class="text-xs text-gray-400">PNG, JPG or WEBP (MAX. 2Mo)</p>
                                </div>
                                <div id="fileInfoEdit"
                                    class="hidden absolute bottom-3 left-3 right-3 text-sm text-gray-400">
                                    <span id="fileNameEdit"></span>
                                </div>
                                <div id="currentImage"
                                    class="absolute top-2 right-2 w-16 h-16 rounded-lg overflow-hidden bg-gray-700">
                                    <img src="" alt="Aperçu" class="w-full h-full object-cover">
                                </div>
                            </label>
                            <input type="file" id="editCategoryImage" name="categoryImage" accept="image/*"
                                class="hidden" onchange="handleFileSelectEdit(event)">
                        </div>
                        <div class="text-red-500 text-xs mt-1 hidden" id="editCategoryImageError"></div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" id="submitEditBtn"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center">
                            <span>Mettre à jour</span>
                            <div id="loadingEditSpinner" class="hidden ml-2">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/categories.js"></script>
    <script src="../js/sidebar.js"></script>
</body>
</html>