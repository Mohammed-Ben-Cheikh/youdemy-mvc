<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../src/output.css">
    <script src="http://localhost/youdemy/app/js/tailwindcss.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #4F46E5, #0EA5E9);
        }

        .gradient-text {
            background: linear-gradient(135deg, #4F46E5, #0EA5E9);
            -webkit-background-clip: text;
            /* For WebKit browsers (Chrome, Safari) */
            background-clip: text;
            /* Standard property for modern browsers */
            -webkit-text-fill-color: transparent;
            /* For WebKit browsers */
            color: transparent;
            /* Fallback for non-WebKit browsers */
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .custom-shape {
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .progress-bar {
            transition: width 1s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header Premium -->
    <header class="fixed w-full z-50 transition-all duration-500 bg-white/10 backdrop-blur-md" id="header">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <div
                        class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl p-1 shadow-lg transform hover:scale-105 transition-all">
                        <img src="../img/logo.png" alt="logo" class="h-14 rounded-xl">
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-6">
                    <a href="/"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-full hover:shadow-lg hover:scale-105 transition-all">Accueil</a>
                    <a href="/categories"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-full shadow-lg scale-105 shadow-black transition-all">Catégories</a>
                    <a href="/cours"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-full hover:shadow-lg hover:scale-105 transition-all">Cours</a>
                </nav>

                <!-- Login/Signup Buttons -->
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="/login"
                        class="bg-white text-blue-600 px-6 py-2 text-sm rounded-lg hover:bg-gray-100 transition-all">Login</a>
                    <a href="/signup"
                        class="bg-blue-700 text-white px-6 py-2 text-sm rounded-lg hover:bg-blue-800 transition-all">Sign
                        Up</a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-all" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl mx-4 p-4 shadow-lg absolute top-20 left-0 right-0 z-40"
            id="mobile-menu">
            <nav class="flex flex-col space-y-3">
                <a href="../../index.php"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all">Accueil</a>
                <a href="Catégories.php"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all">Catégories</a>
                <a href="cours.php"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all">Cours</a>
                <a href="certification.php"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all">Certification</a>
                <div class="flex flex-col space-y-3 mt-4">
                    <a href="../../app/auth/login.php"
                        class="bg-white text-blue-600 px-6 py-2 text-sm rounded-lg hover:bg-gray-100 transition-all text-center">Login</a>
                    <a href="../../app/auth/signup.php"
                        class="bg-blue-700 text-white px-6 py-2 text-sm rounded-lg hover:bg-blue-800 transition-all text-center">Sign
                        Up</a>
                </div>
            </nav>
        </div>
    </header>
    <section class="custom-shape gradient-bg pt-32 pb-24 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row justify-around items-center">
                <!-- Left Column: Text Content -->
                <div class="lg:w-1/2 text-white" data-aos="fade-right">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
                        Formez-vous aux compétences de demain
                    </h1>
                    <p class="text-xl mb-8 text-blue-100 opacity-90">
                        Suivez des parcours de formation complets, conçus par des experts, et obtenez des certifications
                        valorisées sur le marché.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#section"
                            class="px-8 py-4 bg-white text-indigo-600 rounded-full font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-transform duration-300 text-center">
                            Explorer les Catégories
                        </a>
                        <a href="#"
                            class="px-8 py-4 border-2 border-white text-white rounded-full font-semibold shadow-lg hover:bg-white hover:text-indigo-600 hover:scale-105 transition-transform duration-300 text-center">
                            Témoignages d'apprenants
                        </a>
                    </div>
                    <div class="mt-12 flex items-center space-x-8">
                        <div class="flex -space-x-4">
                            <img src="/api/placeholder/40/40"
                                class="w-10 h-10 rounded-full border-2 border-white shadow" alt="User 1" />
                            <img src="/api/placeholder/40/40"
                                class="w-10 h-10 rounded-full border-2 border-white shadow" alt="User 2" />
                            <img src="/api/placeholder/40/40"
                                class="w-10 h-10 rounded-full border-2 border-white shadow" alt="User 3" />
                        </div>
                        <p class="text-sm opacity-80">Déjà <span class="font-semibold">+100K apprenants</span> formés
                        </p>
                    </div>
                </div>

                <!-- Right Column: Image Content -->
                <div class="lg:w-1/2 mt-12 lg:mt-0" data-aos="fade-left">
                    <div class="relative">
                        <img src="../img/FormationOnline.png" class="rounded-xl shadow-2xl animate-float"
                            alt="Formation en ligne" />
                        <!-- Floating Card -->
                        <div
                            class="absolute -bottom-6 -left-6 bg-white p-6 rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-indigo-900">Certifications reconnues</h3>
                                    <p class="text-sm text-gray-600">Valorisez votre CV</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Circles -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -translate-y-1/2 translate-x-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500 opacity-10 rounded-full translate-y-1/2 -translate-x-1/2">
        </div>
    </section>
    <main id="section" class="p-6">
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
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 overflow-hidden rounded-[2rem] bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900 backdrop-blur-sm border-4 border-white shadow-2xl p-8 mt-8">
            <?php if (empty($categories)): ?>
                <div
                    class="col-span-full flex flex-col items-center justify-center p-12 bg-gray-900/50 rounded-[2rem] backdrop-blur-sm">
                    <i class="fas fa-folder-open text-6xl text-blue-500 mb-4"></i>
                    <p class="text-gray-400 text-xl">Aucune catégorie trouvée</p>
                </div>
            <?php else: ?>
                <?php foreach ($categories as $category): ?>
                    <div
                        class="group relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-gray-900 to-gray-800 shadow-2xl transition-all duration-300 hover:scale-[1.02] hover:shadow-blue-500/25">
                        <div class="relative h-64">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-gray-900 transform group-hover:scale-110 transition-transform duration-700 via-transparent to-transparent z-10">
                            </div>
                            <img src="http://localhost/youdemy/app/action/admin/<?php echo htmlspecialchars($category['image_url'] ?: 'img/default-category.jpg'); ?>"
                                class="absolute w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                alt="<?php echo htmlspecialchars($category['titre']); ?>">
                        </div>
                        <div class="relative z-50 p-6 -mt-20">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-2xl font-bold text-white group-hover:text-blue-400 transition-colors">
                                    <?php echo htmlspecialchars($category['titre']); ?>
                                </h3>
                                <span
                                    class="flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600/20 text-blue-400 backdrop-blur-sm">
                                    <i class="fas fa-car text-sm"></i>
                                    <?php
                                    // $vehicleCount = Vehicule::countByCategory($category['id_categorie']);
                                    // echo $vehicleCount . ' véhicule' . ($vehicleCount > 1 ? 's' : '');
                                    ?>
                                </span>
                            </div>
                            <p class="text-gray-400 mb-6 line-clamp-2"><?php echo htmlspecialchars($category['description']); ?>
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo date('d/m/Y', strtotime($category['created_at'])); ?>
                                </span>
                                <a href="vehicule.php?category=<?php echo $category['id_categorie']; ?>"
                                    class="group/btn inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-blue-500/50">
                                    Voir articles
                                    <i
                                        class="fas fa-arrow-right transform group-hover/btn:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <nav aria-label="Page navigation" class="mt-8">
            <ul class="flex justify-center space-x-2">
                <!-- Bouton "Précédent" -->
                <li>
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            &laquo; Précédent
                        </a>
                    <?php else: ?>
                        <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
                            &laquo; Précédent
                        </span>
                    <?php endif; ?>
                </li>

                <!-- Numéros de page -->
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);

                // Afficher "..." si nécessaire avant la première page
                if ($startPage > 1) {
                    echo '<li><a href="?page=1" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-blue-600 hover:text-white">1</a></li>';
                    if ($startPage > 2) {
                        echo '<li><span class="px-4 py-2">...</span></li>';
                    }
                }

                // Afficher les numéros de page
                for ($i = $startPage; $i <= $endPage; $i++) {
                    if ($i == $page) {
                        echo '<li>
                        <span class="px-4 py-2 bg-blue-600 text-white rounded-lg">' . $i . '</span>
                      </li>';
                    } else {
                        echo '<li>
                        <a href="?page=' . $i . '" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-blue-600 hover:text-white">' . $i . '</a>
                      </li>';
                    }
                }

                // Afficher "..." si nécessaire après la dernière page
                if ($endPage < $totalPages) {
                    if ($endPage < $totalPages - 1) {
                        echo '<li><span class="px-4 py-2">...</span></li>';
                    }
                    echo '<li><a href="?page=' . $totalPages . '" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-blue-600 hover:text-white">' . $totalPages . '</a></li>';
                }
                ?>

                <!-- Bouton "Suivant" -->
                <li>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Suivant &raquo;
                        </a>
                    <?php else: ?>
                        <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
                            Suivant &raquo;
                        </span>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </main>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Colonne 1 -->
                <div>
                    <h3 class="text-lg font-bold mb-4">YouDemy</h3>
                    <p class="text-gray-400">Excellence en formation depuis 2024.</p>
                </div>

                <!-- Colonne 2 -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Liens Utiles</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Accueil</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Catégories</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Enterprise</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Certifications</a></li>
                    </ul>
                </div>

                <!-- Colonne 3 -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400">Email: contact@youdemypro.com</li>
                        <li class="text-gray-400">Téléphone: +33 1 23 45 67 89</li>
                    </ul>
                </div>

                <!-- Colonne 4 -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Réseaux Sociaux</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                <p class="text-gray-400">&copy; 2024 YouDemy. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });

            // Close the mobile menu when a link is clicked
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function () {
                    mobileMenu.classList.add('hidden');
                });
            });

            // Close the mobile menu when clicking outside of it
            document.addEventListener('click', function (event) {
                if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>