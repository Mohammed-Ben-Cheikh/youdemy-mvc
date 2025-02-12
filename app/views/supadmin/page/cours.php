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

$cours = Crud::getAll('cours');

if ($date_filter) {
    $cours = array_filter($cours, function ($r) use ($date_filter) {
        return date('Y-m-d', strtotime($r['created_at'])) === $date_filter;
    });
}

if ($search) {
    $cours = array_filter($cours, function ($r) use ($search) {
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
                        class="group flex items-center px-4 py-3 text-blue-300 hover:bg-blue-800/50 rounded-lg transition-all duration-200">
                        <i class="fas fa-tags text-xl mr-3"></i>
                        <span>Categories et Tags</span>
                    </a>
                    <a href="cours.php"
                        class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-600/20">
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
                            <div id="dropdowncour"
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
                    <h1 class="text-2xl font-bold">Gestion des Cours</h1>
                    <button onclick="openModal()"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> Nouvelle Cour
                    </button>
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
                    <?php if (empty($cours)): ?>
                        <div class="col-span-full text-center py-10">
                            <i class="fas fa-folder-open text-4xl text-white mb-3"></i>
                            <p class="text-white">Aucune Cour trouvée</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($cours as $cour): ?>
                            <div
                                class="bg-gray-700 rounded-xl overflow-hidden group hover:shadow-xl transition-all duration-300">
                                <div class="relative h-48">
                                    <img src="../../../app/action/supadmin/cours/uploads/courses/images/<?php echo htmlspecialchars($cour['image_url'] ?: 'img/default-cour.jpg'); ?>"
                                        class="w-full h-full object-cover"
                                        alt="<?php echo htmlspecialchars($cour['titre']); ?>">
                                    <div
                                        class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div class="flex space-x-2">
                                            <button class="p-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors"
                                                onclick="openEditModal(<?php echo $cour['id_cour']; ?>)">
                                                <i class="fas fa-edit text-white"></i>
                                            </button>
                                            <button class="p-2 bg-red-600 rounded-lg hover:bg-red-700 transition-colors"
                                                onclick="deletecour(<?php echo $cour['id_cour']; ?>)">
                                                <i class="fas fa-trash text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($cour['titre']); ?>
                                        </h3>
                                        <span class="bg-purple-600/20 text-purple-400 px-2 py-1 rounded-lg text-sm">
                                            Cour N°: <?php echo $cour['id_cour']; ?>
                                        </span>
                                    </div>
                                    <p class="text-gray-400 text-sm mb-3">
                                        <?php
                                        echo strlen(htmlspecialchars($cour['description'])) > 20 ? substr(htmlspecialchars($cour['description']), 0, 100) . '...' : htmlspecialchars($cour['description']); ?>

                                    </p>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-400">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <?php echo date('d/m/Y', strtotime($cour['created_at'])); ?>
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

    <!-- Add cour Modal -->
    <div id="courModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden z-50 overflow-y-auto">
        <div
            class="bg-gradient-to-b from-blue-600 to-black text-white rounded-xl max-w-4xl mx-auto mt-10 p-6 m-4 border-4 border-black">
            <div
                class="flex justify-between items-center mb-6 bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-lg">
                <h2 class="text-2xl font-bold">Ajouter un nouveau cour</h2>
                <button onclick="closeModal()" class="text-white hover:text-blue-200 text-2xl">&times;</button>
            </div>

            <form id="courForm" onsubmit="handleSubmit(event)" enctype="multipart/form-data" class="space-y-6">
                <!-- cour Info -->
                <div class="space-y-4 bg-white/5 p-4 rounded-lg backdrop-blur-sm">
                    <div>
                        <label class="block text-white text-sm font-bold mb-2">Nom du cour</label>
                        <input type="text" name="cour_nom" required
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="block text-white text-sm font-bold mb-2">Image du cour</label>
                        <input type="file" name="cour_image" accept="image/*" required
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-white text-sm font-bold mb-2">Catégorie :</label>
                        <select name="id_categorie" required
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300">
                            <?php
                            require_once __DIR__ . '/../../../app/Classes/classdao/Crud.php';
                            foreach (Crud::getAll('categories') as $categorie): ?>
                                <option class="text-black" value="<?php echo $categorie['id_categorie']; ?>">
                                    <?php echo $categorie['titre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Ajout d'une section pour sélectionner les tags -->
                    <div>
                        <label class="block text-white text-sm font-bold mb-2">Tags :</label>
                        <select name="tags[]" multiple required
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300">
                            <?php
                            // Récupérer tous les tags depuis la base de données
                            require_once __DIR__ . '/../../../app/Classes/classdao/Crud.php';
                            foreach (Crud::getAll('tags') as $tag): ?>
                                <option class="text-black" value="<?php echo $tag['id_tag']; ?>">
                                    #<?php echo $tag['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-sm text-gray-300 mt-2">Ctrl+click pour Sélectionnez les tags à associer au cours.
                            Vous pouvez en
                            choisir plusieurs.</p>
                    </div>
                    <div>
                        <label class="block text-white text-sm font-bold mb-2">Description</label>
                        <textarea name="cour_description" rows="3"
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <!-- Medias -->
                <div id="MediasContainer" class="space-y-6">
                    <h3 class="text-xl font-bold text-blue-400">Medias</h3>
                    <div
                        class="media-group bg-white/5 p-6 rounded-lg backdrop-blur-sm border border-white/10 space-y-4">
                        <h1 class='text-xl font-extrabold'>Media #1</h1>
                        <input type="text" name="media_nom[]" placeholder="Nom du media" required
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <textarea name="media_description[]" placeholder="Description"
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-medium text-gray-300">Image du media</label>
                            <input type="file" name="media_image[]" accept="image/*" required
                                class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-medium text-gray-300">Contenu Vidéo ou PDF</label>
                            <input type="file" name="media_media[]" accept="video/*,application/pdf"
                                class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div class="flex justify-between pt-6 border-t border-white/20">
                    <button type="button" onclick="addmedia()"
                        class="bg-blue-500/50 hover:bg-blue-500 px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajouter un media
                    </button>
                    <div id="loadingSpinner" class="hidden ml-2">
                        <i class="fas fa-spinner fa-spin text-5xl"></i>
                    </div>
                    <button type="submit" id="okBtn"
                        class="bg-blue-500/50 hover:bg-blue-500 px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <div id="okBtn" class="ml-2">
                            <svg class=" w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Sauvegarder le cour</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Cour Modal -->
    <div id="editCourModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden z-50 overflow-y-auto">
        <div
            class="bg-gradient-to-b from-blue-600 to-black text-white rounded-xl max-w-4xl mx-auto mt-10 p-6 m-4 border-4 border-black">
            <!-- Modal Header -->
            <div
                class="flex justify-between items-center mb-6 bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-lg">
                <h2 class="text-2xl font-bold">Modifier le cours</h2>
                <button onclick="closeEditModal()" class="text-white hover:text-blue-200 text-2xl">&times;</button>
            </div>

            <!-- Form for Editing Course -->
            <form id="editCourForm" onsubmit="handleEditSubmit(event)" enctype="multipart/form-data" class="space-y-6">
                <!-- Hidden Input for Course ID -->
                <input type="hidden" name="cour_id" id="edit_cour_id">

                <!-- Course Info -->
                <div class="space-y-4 bg-white/5 p-4 rounded-lg backdrop-blur-sm">
                    <!-- Course Name -->
                    <div>
                        <label class="block text-white text-sm font-bold mb-2">Nom du cours</label>
                        <input type="text" name="cour_nom" id="edit_cour_nom" required
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Course Image -->
                    <div class="flex flex-col gap-2">
                        <label class="block text-white text-sm font-bold mb-2">Image du cours</label>
                        <input type="file" name="cour_image" id="edit_cour_image" accept="image/*"
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <!-- Image Preview -->
                        <div id="edit_cour_image_preview" class="mt-2">
                            <img src="" alt="Preview" class="max-w-full h-32 object-cover rounded-lg hidden">
                        </div>
                    </div>

                    <!-- Course Category -->
                    <div>
                        <label class="block text-white text-sm font-bold mb-2">Catégorie :</label>
                        <select name="id_categorie" id="edit_id_categorie" required
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300">
                            <?php
                            require_once __DIR__ . '/../../../app/Classes/classdao/Crud.php';
                            foreach (Crud::getAll('categories') as $categorie): ?>
                                <option class="text-black" value="<?php echo $categorie['id_categorie']; ?>">
                                    <?php echo $categorie['titre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Course Description -->
                    <div>
                        <label class="block text-white text-sm font-bold mb-2">Description</label>
                        <textarea name="cour_description" id="edit_cour_description" rows="3"
                            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <!-- Medias Section -->
                <div id="editMediasContainer" class="space-y-6">
                    <h3 class="text-xl font-bold text-blue-400">Medias</h3>
                    <!-- Media Groups will be dynamically added here -->
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-between pt-6 border-t border-white/20">
                    <!-- Add Media Button -->
                    <button type="button" onclick="addEditMedia()"
                        class="bg-blue-500/50 hover:bg-blue-500 px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajouter un media
                    </button>

                    <!-- Save Button -->
                    <button type="submit" id="editOkBtn"
                        class="bg-blue-500/50 hover:bg-blue-500 px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Sauvegarder les modifications</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add JavaScript before closing body tag -->
    <script>
        function openModal() {
            document.getElementById('courModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('courModal').classList.add('hidden');
        }

        function removeIngredient(btn) {
            btn.closest('.media-group').remove();
        }
        let a = 1;
        function addmedia() {
            const container = document.getElementById('MediasContainer');
            const mediaTemplate = document.querySelector('.media-group').cloneNode(true);
            mediaTemplate.innerHTML = `
        <h1 class='text-xl font-extrabold'>Media #${++a}</h1>
        <div class="flex gap-4 items-center">
            <input type="text" name="media_nom[]" placeholder="Nom du media" required
                class="flex-1 p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="button" onclick="removeIngredient(this.parentElement)"
                class="bg-red-500/80 hover:bg-red-600 px-4 py-2 rounded-lg text-white transition-colors flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Supprimer
            </button>
        </div>
        <textarea name="media_description[]" placeholder="Description"
            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-gray-300">Image du media</label>
            <input type="file" name="media_image[]" accept="image/*" required
                class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-gray-300">Contenu Vidéo ou PDF</label>
            <input type="file" name="media_media[]" accept="video/*,application/pdf"
                class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    `;
            mediaTemplate.classList.add('animate-fadeIn');
            container.appendChild(mediaTemplate);
        }

        async function handleSubmit(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(event.target);
            const spinner = form.querySelector('#loadingSpinner');
            const ok = form.querySelector('#okBtn');

            try {
                spinner.classList.remove('hidden');
                ok.classList.add('hidden');
                const response = await fetch('../../../app/action/supadmin/cours/add.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    alert(data.message);
                    closeModal();
                    window.location.reload();
                } else {
                    console.log(data);
                    throw new Error(data.message || "Une erreur inconnue s'est produite.");
                }
            } catch (error) {
                alert('Erreur: ' + error.message);
                console.error(error);
            }
        }

        async function deletecour(id) {
            if (confirm('Are you sure you want to delete this cour?')) {
                try {
                    const response = await fetch(`../../../app/action/supadmin/cours/delete.php`, {
                        method: 'POST',  // Ensure POST is capitalized
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            id: id
                        })
                    });

                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                } catch (error) {
                    console.error(error);
                    alert('Erreur lors de la suppression');
                }
            }
        }


        // Open Edit Modal
        function openEditModal(courseId) {
            fetch(`../../../app/action/supadmin/cours/get_cour.php?id=${courseId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message);
                    }

                    const cours = data.data.cours;
                    const medias = data.data.medias;

                    // Fill Course Info
                    document.getElementById('edit_cour_id').value = cours.id_cour;
                    document.getElementById('edit_cour_nom').value = cours.titre;
                    document.getElementById('edit_id_categorie').value = cours.id_categorie_fk;
                    document.getElementById('edit_cour_description').value = cours.description;

                    // Set Image Preview
                    const imagePreview = document.getElementById('edit_cour_image_preview').querySelector('img');
                    if (cours.image_url) {
                        imagePreview.src = '../../../app/action/supadmin/cours/uploads/courses/images/' + cours.image_url;
                        imagePreview.classList.remove('hidden');
                    } else {
                        imagePreview.classList.add('hidden');
                    }

                    // Clear Existing Medias
                    const mediasContainer = document.getElementById('editMediasContainer');
                    mediasContainer.innerHTML = '';

                    // Add Medias
                    medias.forEach((media, index) => {
                        const mediaGroup = document.createElement('div');
                        mediaGroup.className = 'media-group bg-white/5 p-6 rounded-lg backdrop-blur-sm border border-white/10 space-y-4';
                        mediaGroup.innerHTML = `
<h1 class="text-xl font-extrabold">Media #${index + 1}</h1>
<input type="hidden" name="media_id[]" value="${media.id}">

<div class="flex gap-4 items-center">
    <input type="text" name="media_nom[]" value="${media.titre}" placeholder="Nom du media" required
        class="flex-1 p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500">
    
    <button type="button" onclick="deleteEditMedia(this, ${media.id})"
        class="bg-red-500/80 hover:bg-red-600 px-4 py-2 rounded-lg text-white transition-colors flex items-center gap-1">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Supprimer
    </button>
</div>

<textarea name="media_description[]" placeholder="Description"
    class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500">${media.description}</textarea>

<div class="flex flex-col gap-2">
    <label class="block text-white text-sm font-bold mb-2">Image du media</label>
    <input type="file" name="media_image[]" accept="image/*"
        class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    
    <!-- Image Preview -->
    <div class="mt-2">
        <img src="../../../app/action/supadmin/cours/uploads/media/images/${media.image_url}" alt="Preview" class="max-w-full h-32 object-cover rounded-lg ${media.image_url ? '' : 'hidden'}">
    </div>
</div>

<div class="flex flex-col gap-2">
    <label class="text-sm font-medium text-gray-300">Contenu ${media.type === 'video' ? 'vidéo' : 'PDF'}</label>
    <input type="file" name="media_media[]" accept="${media.type === 'video' ? 'video/*' : 'application/pdf'}"
        class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    
    <span class="text-sm text-gray-300">Fichier actuel: ${media.fichier.split('/').pop()}</span>

    <!-- Afficher le média (vidéo ou PDF) -->
    ${media.type === 'video' ? `
        <div class="mt-2">
            <video controls class="w-full max-w-full rounded-lg">
                <source src="/youdemy/app/action/supadmin/cours/uploads/media/files/${media.fichier}" type="video/mp4">
                Votre navigateur ne supporte pas la lecture de vidéos.
            </video>
        </div>
    ` : `
        <div class="mt-2">
            <iframe src="/youdemy/app/action/supadmin/cours/uploads/media/files/${media.fichier}" class="w-full h-96 rounded-lg" frameborder="0"></iframe>
        </div>
    `}
</div>
                `;
                        mediasContainer.appendChild(mediaGroup);
                    });

                    // Show Modal
                    document.getElementById('editCourModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors du chargement du cours');
                });
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById('editCourModal').classList.add('hidden');
        }

        // Handle Edit Form Submission
        async function handleEditSubmit(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            try {
                const response = await fetch('../../../app/action/supadmin/cours/update_cour.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    closeEditModal();
                    window.location.reload();
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                alert('Erreur: ' + error.message);
                console.error(error);
            }
        }

        // Add Media to Edit Form
        function addEditMedia() {
            const container = document.getElementById('editMediasContainer');
            const mediaTemplate = document.createElement('div');
            mediaTemplate.className = 'media-group bg-white/5 p-6 rounded-lg backdrop-blur-sm border border-white/10 space-y-4';
            const mediaIndex = container.children.length + 1;

            mediaTemplate.innerHTML = `
        <h1 class="text-xl font-extrabold">Media #${mediaIndex}</h1>
        
        <!-- Nom du média -->
        <label for="media_nom_${mediaIndex}" class="text-sm font-medium text-gray-300">Nom du média</label>
        <div class='flex gap-4 items-center'>
        <input type="text" id="media_nom_${mediaIndex}" name="media_nom[]" placeholder="Nom du média" required
            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <!-- Bouton de suppression -->
        <button type="button" onclick="removeEditMedia(this)" 
            class="bg-red-500/80 hover:bg-red-600 px-4 py-2 rounded-lg text-white transition-colors">
            Supprimer
        </button>
        </div>
        <!-- Description du média -->
        <label for="media_description_${mediaIndex}" class="text-sm font-medium text-gray-300">Description</label>
        <textarea id="media_description_${mediaIndex}" name="media_description[]" placeholder="Description"
            class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        
        <!-- Image du média -->
        <div class="flex flex-col gap-2">
            <label for="media_image_${mediaIndex}" class="text-sm font-medium text-gray-300">Image du média</label>
            <input type="file" id="media_image_${mediaIndex}" name="media_image[]" accept="image/*"
                class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                onchange="previewImage(this)">
            
            <!-- Aperçu de l'image -->
            <div id="media_image_preview_${mediaIndex}" class="mt-2 hidden">
                <p class="text-sm text-gray-300">Aperçu de l'image :</p>
                <img id="media_image_preview_content_${mediaIndex}" class="max-w-full h-32 object-cover rounded-lg">
            </div>
        </div>
        
        <!-- Sélection du fichier (vidéo ou PDF) -->
        <div class="flex flex-col gap-2">
            <label for="media_media_${mediaIndex}" class="text-sm font-medium text-gray-300">Contenu Vidéo ou PDF</label>
            <input type="file" id="media_media_${mediaIndex}" name="media_media[]" accept="video/*,application/pdf"
                class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                onchange="previewMedia(this)">
        </div>
        
        <!-- Aperçu du média -->
        <div id="media_preview_${mediaIndex}" class="mt-2 hidden">
            <p class="text-sm text-gray-300">Aperçu :</p>
            <div id="media_preview_content_${mediaIndex}" class="mt-2"></div>
        </div>
    `;

            container.appendChild(mediaTemplate);
        }

        // Aperçu de l'image sélectionnée
        function previewImage(input) {
            const previewContainer = input.parentElement.querySelector('div');
            const previewImage = previewContainer.querySelector('img');
            const file = input.files[0];

            if (file) {
                previewContainer.classList.remove('hidden');
                previewImage.src = URL.createObjectURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        // Aperçu du média sélectionné (vidéo ou PDF)
        function previewMedia(input) {
            const previewContainer = input.parentElement.nextElementSibling;
            const previewContent = previewContainer.querySelector('div');
            const file = input.files[0];

            if (file) {
                previewContainer.classList.remove('hidden');
                previewContent.innerHTML = '';

                if (file.type.startsWith('video/')) {
                    // Aperçu pour les vidéos
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.classList.add('w-full', 'max-w-full', 'rounded-lg');
                    previewContent.appendChild(video);
                } else if (file.type === 'application/pdf') {
                    // Aperçu pour les PDF
                    const iframe = document.createElement('iframe');
                    iframe.src = URL.createObjectURL(file);
                    iframe.classList.add('w-full', 'h-96', 'rounded-lg');
                    previewContent.appendChild(iframe);
                } else {
                    previewContent.textContent = 'Type de fichier non supporté.';
                }
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        // Supprimer un média
        function removeEditMedia(button) {
            const mediaGroup = button.closest('.media-group');
            if (mediaGroup) {
                mediaGroup.remove();
                updateMediaIndexes(); // Mettre à jour les numéros des médias restants
            }
        }

        // Mettre à jour les numéros des médias
        function updateMediaIndexes() {
            const container = document.getElementById('editMediasContainer');
            Array.from(container.children).forEach((mediaGroup, index) => {
                const title = mediaGroup.querySelector('h1');
                if (title) {
                    title.textContent = `#${index + 1}`;
                }
            });
        }

        // Remove Media from Edit Form
        function removeEditMedia(button) {
            button.closest('.media-group').remove();
        }

        // Delete Media from Database
        async function deleteEditMedia(button, mediaId) {
            if (confirm('Supprimer ce média ?')) {
                try {
                    const response = await fetch('../../../app/action/supadmin/cours/delete_media.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: mediaId }),
                    });
                    const data = await response.json();

                    if (data.success) {
                        button.closest('.media-group').remove();
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    alert('Erreur: ' + error.message);
                }
            }
        }
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
            const dropdowncour = document.getElementById('dropdowncour');
            const chevronIcon = dropdownButton.querySelector('.fa-chevron-down');
            let isOpen = false;

            // Function to toggle dropdown
            const toggleDropdown = () => {
                isOpen = !isOpen;
                dropdowncour.classList.toggle('hidden');
                chevronIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0)';
            };

            // Toggle on button click
            dropdownButton.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleDropdown();
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!dropdownButton.contains(e.target) && !dropdowncour.contains(e.target)) {
                    isOpen = false;
                    dropdowncour.classList.add('hidden');
                    chevronIcon.style.transform = 'rotate(0)';
                }
            });

            // Close on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !dropdowncour.classList.contains('hidden')) {
                    isOpen = false;
                    dropdowncour.classList.add('hidden');
                    chevronIcon.style.transform = 'rotate(0)';
                }
            });

            // Prevent cour from closing when clicking inside it
            dropdowncour.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    </script>
</body>

</html>