<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Connexion</title>
    <script src="http://localhost/youdemy/app/js/tailwindcss.js"></script>
    <style>
        .fade-in-left {
            animation: fadeInLeft 1s ease-out;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-[url('../public/img/herocar.jpg')] bg-cover bg-center bg-fixed min-h-screen">
    <div class="flex min-h-screen">
        <!-- Zone gauche avec contenu -->
        <div
            class="hidden md:flex md:w-1/2 bg-gradient-to-r from-black/80 to-transparent p-8 flex-col justify-center items-start">
            <div class="max-w-lg fade-in-left">
                <h1 class="text-5xl font-bold text-white mb-6">Connectez-vous à YouDemy</h1>
                <p class="text-xl text-white/90 mb-8">Accédez à votre espace personnel pour gérer vos réservations et
                    profiter de nos services premium.</p>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span class="text-white">Gérez vos réservations</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span class="text-white">Accès à des offres exclusives</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span class="text-white">Service personnalisé</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone droite (formulaire) -->
        <div class="w-full md:w-1/2 bg-gradient-to-t from-blue-500/30 to-black/80 border-l border-white/20">
            <div class="h-screen flex items-center justify-center">
                <div class="w-full max-w-md p-8">
                    <h2 class="text-center text-3xl font-bold text-white mb-8">Connexion</h2>

                    <?php if ($error): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-6">

                        <input type="hidden" name="csrf_token" id="csrf_token" value="<?php use App\helper\Helper;
                        echo Helper::generateCsrfToken() ?>">

                        <div>
                            <label class="block text-sm font-medium text-white">Email :</label>
                            <input type="email" name="email" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white">Mot de passe :</label>
                            <input type="password" name="password" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                            <div class="flex justify-end mt-2">
                                <a href="forgot-password.php"
                                    class="text-sm text-indigo-400 hover:text-indigo-300 transition duration-150">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Se connecter
                        </button>
                    </form>

                    <p class="mt-4 text-center text-sm text-white">
                        Pas encore de compte ?
                        <a href="/signup"
                            class="font-medium text-indigo-400 hover:text-indigo-300 transition duration-150">S'inscrire</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>