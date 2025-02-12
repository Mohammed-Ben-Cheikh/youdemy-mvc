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
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-full hover:shadow-lg hover:scale-105 transition-all">Catégories</a>
                    <a href="/cours"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-full shadow-lg scale-105 shadow-black transition-all">Cours</a>
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
                        Découvrez nos cours et boostez vos compétences
                    </h1>
                    <p class="text-xl mb-8 text-blue-100 opacity-90">
                        Explorez notre catalogue de plus de 15,000 cours conçus par des experts, avec des projets
                        pratiques et des certifications reconnues.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#"
                            class="px-8 py-4 bg-white text-indigo-600 rounded-full font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-transform duration-300 text-center">
                            Parcourir les cours
                        </a>
                        <a href="#"
                            class="px-8 py-4 border-2 border-white text-white rounded-full font-semibold shadow-lg hover:bg-white hover:text-indigo-600 hover:scale-105 transition-transform duration-300 text-center">
                            Voir les certifications
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
                        <p class="text-sm opacity-80">Rejoint par <span class="font-semibold">+50K
                                apprenants</span>
                            ce mois</p>
                    </div>
                </div>

                <!-- Right Column: Image Content -->
                <div class="lg:w-1/2 mt-12 lg:mt-0" data-aos="fade-left">
                    <div class="relative">
                        <img src="../img/OnlineLearning.jpg" class="rounded-xl shadow-2xl animate-float"
                            alt="Platform Preview" />
                        <!-- Floating Card -->
                        <div
                            class="absolute -bottom-6 -left-6 bg-white p-6 rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-indigo-900">Apprentissage flexible</h3>
                                    <p class="text-sm text-gray-600">Apprenez à votre rythme</p>
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
    <!-- Main Content -->
    <main class="p-6 space-y-8">
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

        <!-- Course Grid -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="courseGrid">
            <?php if (empty($courses)): ?>
                <div class="col-span-full text-center py-12">
                    <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/20">
                        <i class="fas fa-books text-4xl text-blue-400 mb-4"></i>
                        <h3 class="text-xl font-bold text-white mb-2">Aucun cours disponible</h3>
                        <p class="text-blue-200">Aucun cours ne correspond à vos critères de recherche.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($courses as $course):
                    $teacher = Crud::getBy('sup_admins', 'id_admin', $course['id_enseignant_fk']);
                    $category = Crud::getBy('categories', 'id_categorie', $course['id_categorie_fk']);
                    ?>
                    <article
                        class="group bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="relative h-48">
                            <img src="http://localhost/youdemy/app/action/supadmin/cours/uploads/courses/images/<?php echo htmlspecialchars($course['image_url']); ?>"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                alt="<?php echo htmlspecialchars($course['titre']); ?>">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent">
                                <div class="absolute bottom-4 left-4 right-4">
                                    <span class="px-3 py-1 bg-indigo-500 text-white text-sm rounded-full">
                                        <?php echo htmlspecialchars($category['titre'] ?? 'Non catégorisé'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition-colors">
                                <?php echo htmlspecialchars($course['titre']); ?>
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-2">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>

                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($teacher['nom'] . ' ' . $teacher['prenom']); ?>"
                                        class="w-8 h-8 rounded-full"
                                        alt="<?php echo htmlspecialchars($teacher['nom'] . ' ' . $teacher['prenom']); ?>">
                                    <span class="text-sm text-gray-600">
                                        <?php echo htmlspecialchars($teacher['nom'] . ' ' . $teacher['prenom']); ?>
                                    </span>
                                </div>
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span class="text-gray-600">4.8</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <a href="course_details.php?id=<?php echo $course['id_cour']; ?>"
                                    class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-center">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="mt-12 flex justify-center">
                <div class="flex space-x-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo ($page - 1); ?><?php echo $category ? '&category=' . $category : ''; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-chevron-left mr-2"></i> Précédent
                        </a>
                    <?php endif; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo ($page + 1); ?><?php echo $category ? '&category=' . $category : ''; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Suivant <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
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