<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Excellence en Formation</title>
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
                        <img src="/img/logo.png" alt="logo" class="h-14 rounded-xl">
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-6">
                    <a href="/"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-full shadow-lg shadow-black scale-105 transition-all">Accueil</a>
                    <a href="/categories"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-full hover:shadow-lg hover:scale-105 transition-all">Catégories</a>
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
                <a href="index.php"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all">Accueil</a>
                <a href="./public/page/Catégories.php"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all">Catégories</a>
                <a href="./public/page/cours.php"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all">Cours</a>
                <div class="flex flex-col space-y-3 mt-4">
                    <a href="./app/auth/login.php"
                        class="bg-white text-blue-600 px-6 py-2 text-sm rounded-lg hover:bg-gray-100 transition-all text-center">Login</a>
                    <a href="./app/auth/signup.php"
                        class="bg-blue-700 text-white px-6 py-2 text-sm rounded-lg hover:bg-blue-800 transition-all text-center">Sign
                        Up</a>
                </div>
            </nav>
        </div>
    </header>
    <!-- Hero Section Premium -->
    <section class="custom-shape gradient-bg pt-32 pb-24 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row justify-around items-center">
                <!-- Left Column: Text Content -->
                <div class="lg:w-1/2 text-white" data-aos="fade-right">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
                        Transformez votre carrière avec l'excellence
                    </h1>
                    <p class="text-xl mb-8 text-blue-100 opacity-90">
                        Accédez à plus de 15,000 cours d'experts, des projets réels et des certifications reconnues
                        mondialement.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#"
                            class="px-8 py-4 bg-white text-indigo-600 rounded-full font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-transform duration-300 text-center">
                            Démarrer Gratuitement
                        </a>
                        <a href="#"
                            class="px-8 py-4 border-2 border-white text-white rounded-full font-semibold shadow-lg hover:bg-white hover:text-indigo-600 hover:scale-105 transition-transform duration-300 text-center">
                            Solutions Enterprise
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
                        <p class="text-sm opacity-80">Rejoint par <span class="font-semibold">+50K professionnels</span>
                            ce mois</p>
                    </div>
                </div>

                <!-- Right Column: Image Content -->
                <div class="lg:w-1/2 mt-12 lg:mt-0" data-aos="fade-left">
                    <div class="relative">
                        <img src="/img/Student.jpg" class="rounded-xl shadow-2xl animate-float"
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
                                    <h3 class="font-semibold text-indigo-900">Apprentissage accéléré</h3>
                                    <p class="text-sm text-gray-600">2x plus rapide qu'en présentiel</p>
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

    <!-- Section Partenaires -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <p class="text-center text-gray-600 mb-8">Ils nous font confiance</p>
            <div class="flex flex-wrap justify-center items-center gap-12">
                <img src="https://www.ocpgroup.ma/themes/custom/ocp_child/img/logo.svg"
                    class=" grayscale hover:grayscale-0 transition-all" alt="Partner" />
                <img src="https://um6p.ma/sites/default/files/logo%20(4)_1.png"
                    class="h-8 grayscale hover:grayscale-0 transition-all" alt="Partner" />
                <img src="https://www.simplon.ma/theme/medias/youcode.png"
                    class="h-8 grayscale hover:grayscale-0 transition-all" alt="Partner" />
                <img src="https://www.youcode.ma/images/logos/simplon_logo.svg"
                    class="h-8 grayscale hover:grayscale-0 transition-all" alt="Partner" />
            </div>
        </div>
    </section>

    <!-- Section Parcours Personnalisés -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold mb-6 gradient-text">Parcours d'Excellence Personnalisés</h2>
                <p class="text-gray-600">Choisissez parmi nos parcours conçus par des experts de l'industrie et adaptés
                    à votre niveau.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Parcours 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up">
                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Développement Web Full-Stack</h3>
                    <p class="text-gray-600 mb-6">Du HTML aux frameworks modernes, maîtrisez le développement web de A à
                        Z.</p>
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Progression moyenne</span>
                            <span class="text-sm font-semibold">85%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full progress-bar" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">56 heures de contenu</span>
                        <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">Commencer →</a>
                    </div>
                </div>

                <!-- Parcours 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Intelligence Artificielle & ML</h3>
                    <p class="text-gray-600 mb-6">Explorez le machine learning et créez des modèles d'IA performants.
                    </p>
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Progression moyenne</span>
                            <span class="text-sm font-semibold">92%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full progress-bar" style="width: 92%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">72 heures de contenu</span>
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-700">Commencer →</a>
                    </div>
                </div>

                <!-- Parcours 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v4m6 0a2 2 0 100-4m0 4a2 2 0 110-4m0 4v4m6-12a2 2 0 100-4m0 4a2 2 0 110-4m0 4v4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Cloud & DevOps</h3>
                    <p class="text-gray-600 mb-6">Maîtrisez les outils cloud et l'automatisation DevOps.</p>
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Progression moyenne</span>
                            <span class="text-sm font-semibold">78%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full progress-bar" style="width: 78%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">64 heures de contenu</span>
                        <a href="#" class="text-purple-600 font-semibold hover:text-purple-700">Commencer →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Success Stories -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-6 gradient-text">Success Stories</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Découvrez comment nos apprenants ont transformé leur carrière
                    grâce à YouDemy.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Story Card 1 -->
                <div class="bg-gray-50 rounded-2xl p-8 card-hover" data-aos="fade-up">
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="/api/placeholder/60/60" alt="Success Story" class="w-16 h-16 rounded-full" />
                        <div>
                            <h4 class="font-bold">Marie Laurent</h4>
                            <p class="text-gray-600">Data Scientist @ Google</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">"Grâce à la formation en Data Science de YouDemy, j'ai pu
                        décrocher mon poste de rêve chez Google. Le mentorat personnalisé a fait toute la différence."
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-1">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-500">Il y a 2 mois</span>
                    </div>
                </div>

                <!-- Story Card 2 -->
                <div class="bg-gray-50 rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="/api/placeholder/60/60" alt="Success Story" class="w-16 h-16 rounded-full" />
                        <div>
                            <h4 class="font-bold">Thomas Martin</h4>
                            <p class="text-gray-600">Full-Stack Dev @ Apple</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">"La qualité des cours et le suivi personnalisé m'ont permis de passer
                        de débutant à développeur professionnel en seulement 6 mois."</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-1">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <!-- Répéter les étoiles 4 autres fois -->
                        </div>
                        <span class="text-sm text-gray-500">Il y a 1 mois</span>
                    </div>
                </div>

                <!-- Story Card 3 -->
                <div class="bg-gray-50 rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="/api/placeholder/60/60" alt="Success Story" class="w-16 h-16 rounded-full" />
                        <div>
                            <h4 class="font-bold">Sophie Bernard</h4>
                            <p class="text-gray-600">UX Designer @ Amazon</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">"Les projets pratiques et le feedback des experts m'ont permis
                        d'acquérir une expérience concrète. Maintenant, je dirige une équipe UX chez Amazon."</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-1">
                            <!-- Étoiles de notation -->
                            <div class="flex space-x-1">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <!-- Répéter 4 fois pour 5 étoiles -->
                            </div>
                        </div>
                        <span class="text-sm text-gray-500">Il y a 3 mois</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Premium Features avec Animation -->
    <section class="py-20 bg-gray-900 text-white overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-6">Fonctionnalités Premium</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Découvrez nos outils exclusifs pour accélérer votre
                    apprentissage</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Card 1 - AI Learning Assistant -->
                <div class="relative group" data-aos="fade-up">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl opacity-75 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative bg-gray-800 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div
                            class="w-16 h-16 bg-blue-500 bg-opacity-20 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4">AI Learning Assistant</h3>
                        <p class="text-gray-400">Un assistant virtuel personnalisé qui adapte votre parcours
                            d'apprentissage en temps réel.</p>
                        <ul class="mt-6 space-y-3 text-sm">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Recommandations personnalisées
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Analyse de progression
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Feature Card 2 - Live Mentoring -->
                <div class="relative group" data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl opacity-75 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative bg-gray-800 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div
                            class="w-16 h-16 bg-purple-500 bg-opacity-20 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Mentorat en Direct</h3>
                        <p class="text-gray-400">Accès illimité à nos experts pour des sessions de mentorat
                            personnalisées.</p>
                        <ul class="mt-6 space-y-3 text-sm">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Sessions individuelles
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Feedback en temps réel
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Feature Card 3 - Project Portfolio -->
                <div class="relative group" data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl opacity-75 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative bg-gray-800 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div
                            class="w-16 h-16 bg-green-500 bg-opacity-20 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Portfolio de Projets</h3>
                        <p class="text-gray-400">Créez et présentez vos projets dans un portfolio professionnel
                            personnalisé.</p>
                        <ul class="mt-6 space-y-3 text-sm">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Projets réels
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Showcase interactif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nouvelle Section - Learning Path Timeline -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-16 gradient-text">Votre Parcours vers l'Excellence</h2>

            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-blue-200"></div>

                <!-- Timeline Items -->
                <div class="space-y-20">
                    <!-- Step 1 -->
                    <div class="relative" data-aos="fade-right">
                        <div class="flex items-center justify-center space-x-8">
                            <div class="w-1/2 text-right pr-8">
                                <h3 class="text-xl font-bold mb-2">Évaluation Personnalisée</h3>
                                <p class="text-gray-600">Découvrez votre niveau actuel et définissez vos objectifs
                                    d'apprentissage.</p>
                            </div>
                            <div class="relative">
                                <div
                                    class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold z-10 relative">
                                    1
                                </div>
                            </div>
                            <div class="w-1/2"></div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative" data-aos="fade-left">
                        <div class="flex items-center justify-center space-x-8">
                            <div class="w-1/2"></div>
                            <div class="relative">
                                <div
                                    class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold z-10 relative">
                                    2
                                </div>
                            </div>
                            <div class="w-1/2 pl-8">
                                <h3 class="text-xl font-bold mb-2">Parcours Sur Mesure</h3>
                                <p class="text-gray-600">Un programme adapté à vos besoins et votre rythme
                                    d'apprentissage.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative" data-aos="fade-right">
                        <div class="flex items-center justify-center space-x-8">
                            <div class="w-1/2 text-right pr-8">
                                <h3 class="text-xl font-bold mb-2">Pratique Intensive</h3>
                                <p class="text-gray-600">Travaillez sur des projets réels avec le soutien de nos
                                    mentors.</p>
                            </div>
                            <div class="relative">
                                <div
                                    class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold z-10 relative">
                                    3
                                </div>
                            </div>
                            <div class="w-1/2"></div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative" data-aos="fade-left">
                        <div class="flex items-center justify-center space-x-8">
                            <div class="w-1/2"></div>
                            <div class="relative">
                                <div
                                    class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold z-10 relative">
                                    4
                                </div>
                            </div>
                            <div class="w-1/2 pl-8">
                                <h3 class="text-xl font-bold mb-2">Certification & Portfolio</h3>
                                <p class="text-gray-600">Validez vos compétences et présentez vos réalisations au monde.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section FAQ -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-6 gradient-text">Foire Aux Questions</h2>
                <p class="text-gray-600">Trouvez des réponses aux questions les plus fréquentes.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Question 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up">
                    <h3 class="text-xl font-bold mb-4">Comment puis-je commencer ?</h3>
                    <p class="text-gray-600">Il vous suffit de créer un compte gratuitement et de choisir un parcours
                        qui correspond à vos objectifs.</p>
                </div>

                <!-- Question 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-xl font-bold mb-4">Les cours sont-ils accessibles à vie ?</h3>
                    <p class="text-gray-600">Oui, une fois que vous avez acheté un cours, vous y avez accès à vie, y
                        compris aux mises à jour futures.</p>
                </div>

                <!-- Question 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-xl font-bold mb-4">Y a-t-il des certifications ?</h3>
                    <p class="text-gray-600">Oui, nous offrons des certifications reconnues pour chaque parcours que
                        vous terminez avec succès.</p>
                </div>

                <!-- Question 4 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-xl font-bold mb-4">Puis-je obtenir un remboursement ?</h3>
                    <p class="text-gray-600">Nous offrons une garantie de remboursement de 30 jours si vous n'êtes pas
                        satisfait de votre achat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Blog -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-6 gradient-text">Dernières Actualités</h2>
                <p class="text-gray-600">Découvrez nos articles et conseils pour booster votre carrière.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Article 1 -->
                <div class="bg-gray-50 rounded-2xl p-8 card-hover" data-aos="fade-up">
                    <img src="/api/placeholder/400/200" alt="Article 1" class="rounded-xl mb-6" />
                    <h3 class="text-xl font-bold mb-4">Les tendances de l'IA en 2024</h3>
                    <p class="text-gray-600 mb-6">Découvrez les dernières tendances en intelligence artificielle et
                        comment elles impactent l'industrie.</p>
                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">Lire plus →</a>
                </div>

                <!-- Article 2 -->
                <div class="bg-gray-50 rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <img src="/api/placeholder/400/200" alt="Article 2" class="rounded-xl mb-6" />
                    <h3 class="text-xl font-bold mb-4">Comment devenir développeur Full-Stack</h3>
                    <p class="text-gray-600 mb-6">Un guide complet pour devenir développeur Full-Stack en 2024.</p>
                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">Lire plus →</a>
                </div>

                <!-- Article 3 -->
                <div class="bg-gray-50 rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <img src="/api/placeholder/400/200" alt="Article 3" class="rounded-xl mb-6" />
                    <h3 class="text-xl font-bold mb-4">Les meilleurs outils DevOps</h3>
                    <p class="text-gray-600 mb-6">Découvrez les outils DevOps les plus populaires en 2024.</p>
                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">Lire plus →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Contact -->
    <section class="py-20 bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-6">Contactez-nous</h2>
                <p class="text-gray-400">Nous sommes là pour répondre à vos questions et vous aider à démarrer.</p>
            </div>

            <div class="max-w-2xl mx-auto">
                <form action="public/page/send_email.php" method="post" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Nom</label>
                        <input type="text" id="name" name="name"
                            class="mt-1 block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white"
                            required />
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white"
                            required />
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-300">Sujet</label>
                        <input type="subject" id="subject" name="subject"
                            class="mt-1 block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white"
                            required />
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-300">Message</label>
                        <textarea id="message" name="message" rows="4"
                            class="mt-1 block w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white"
                            required></textarea>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Section Newsletter -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold mb-6">Restez Informé</h2>
                <p class="text-blue-100">Inscrivez-vous à notre newsletter pour recevoir les dernières actualités et
                    offres spéciales.</p>
            </div>

            <div class="max-w-2xl mx-auto">
                <form class="flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Votre email" class="flex-1 px-6 py-3 rounded-full text-gray-900"
                        required />
                    <button type="submit"
                        class="px-8 py-3 bg-white text-indigo-600 rounded-full font-semibold hover:bg-opacity-90 transition-colors">
                        S'inscrire
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Section Tarifs -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-6 gradient-text">Nos Tarifs</h2>
                <p class="text-gray-600">Choisissez le plan qui correspond à vos besoins.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Plan 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up">
                    <h3 class="text-xl font-bold mb-4">Basique</h3>
                    <p class="text-gray-600 mb-6">Parfait pour les débutants.</p>
                    <p class="text-4xl font-bold mb-6">19€<span class="text-lg text-gray-500">/mois</span></p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Accès à tous les cours
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Certifications
                        </li>
                    </ul>
                    <a href="#"
                        class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-center">
                        Choisir ce plan
                    </a>
                </div>

                <!-- Plan 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-xl font-bold mb-4">Pro</h3>
                    <p class="text-gray-600 mb-6">Pour les professionnels.</p>
                    <p class="text-4xl font-bold mb-6">49€<span class="text-lg text-gray-500">/mois</span></p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Accès à tous les cours
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Certifications
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Mentorat en direct
                        </li>
                    </ul>
                    <a href="#"
                        class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-center">
                        Choisir ce plan
                    </a>
                </div>

                <!-- Plan 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-xl font-bold mb-4">Enterprise</h3>
                    <p class="text-gray-600 mb-6">Pour les entreprises.</p>
                    <p class="text-4xl font-bold mb-6">99€<span class="text-lg text-gray-500">/mois</span></p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Accès à tous les cours
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Certifications
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Mentorat en direct
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Gestion d'équipe
                        </li>
                    </ul>
                    <a href="#"
                        class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-center">
                        Choisir ce plan
                    </a>
                </div>
            </div>
        </div>
    </section>

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
                        <li class="text-gray-400">Email: contact@youdemy.com</li>
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