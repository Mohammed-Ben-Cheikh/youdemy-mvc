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

$error = '';
$course = null;
$documents = [];
$videos = [];

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur a réservé ce cours
    $reservation = Crud::getBy('reservations', 'id_cour_fk', $course_id);
    if (!$reservation || $reservation['id_user_fk'] != $user_id) {
        Helper::goToPage('/dashboard/user/page/cours.php');
    }

    // Récupérer les détails du cours
    $course = Crud::getBy('cours', 'id_cour', $course_id);
    if ($course) {
        $documents = Crud::getAllBy('cours_documents', 'id_cour_fk', $course_id) ?? [];
        $videos = Crud::getAllBy('cours_videos', 'id_cour_fk', $course_id) ?? [];
    }
}

// Pour la section des statistiques dans le template
$documentsCount = is_array($documents) ? count($documents) : 0;
$videosCount = is_array($videos) ? count($videos) : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $course ? htmlspecialchars($course['titre']) : 'Cours'; ?> - YouDemy</title>
    <script src="http://localhost/youdemy/app/js/tailwindcss.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-blue-900 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-white/10 backdrop-blur-xl border-b border-white/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="cours.php" class="flex items-center text-white hover:text-blue-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux cours
                </a>
                <div class="text-white font-semibold"><?php echo $course ? htmlspecialchars($course['titre']) : ''; ?></div>
                <div class="flex items-center space-x-4">
                    <button class="text-white hover:text-blue-300" title="Partager">
                        <i class="fas fa-share-alt"></i>
                    </button>
                    <button class="text-white hover:text-blue-300" title="Favoris">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contenu Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Lecteur Vidéo Principal -->
                <?php if (!empty($videos)): ?>
                    <div class="bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden">
                        <div class="video-container">
                            <video id="mainVideo" controls poster="../../../app/action/supadmin/cours/uploads/media/images/<?php echo $videos[0]['image_url'] ?: 'default-thumbnail.jpg'; ?>" class="w-full">
                                <source src="/youdemy/app/action/supadmin/cours/uploads/media/files/<?php echo $videos[0]['fichier']; ?>" type="video/mp4">
                                Votre navigateur ne supporte pas la lecture de vidéos.
                            </video>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Informations du Cours -->
                <div class="bg-white/10 backdrop-blur-xl rounded-xl p-6 border border-white/20">
                    <h1 class="text-2xl font-bold text-white mb-4"><?php echo htmlspecialchars($course['titre']); ?></h1>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                            <span class="block text-sm text-blue-300">Date de création</span>
                            <span class="font-semibold">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <?php echo date('d/m/Y', strtotime($course['created_at'])); ?>
                            </span>
                        </div>
                        <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                            <span class="block text-sm text-blue-300">Contenu</span>
                            <span class="font-semibold">
                                <i class="fas fa-file text-blue-400 mr-2"></i>
                                <?php echo $documentsCount; ?> documents
                                <i class="fas fa-video text-blue-400 ml-2 mr-2"></i>
                                <?php echo $videosCount; ?> vidéos
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-300 mt-4"><?php echo htmlspecialchars($course['description']); ?></p>
                </div>

                <!-- Section Documents -->
                <?php if (!empty($documents)): ?>
                <div class="bg-white/10 backdrop-blur-xl rounded-xl p-6 border border-white/20">
                    <h2 class="text-xl font-bold text-white mb-4">Documents du Cours</h2>
                    <div class="grid gap-4">
                        <?php foreach ($documents as $doc): ?>
                            <div class="flex items-center justify-between bg-white/5 p-4 rounded-lg hover:bg-white/10 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-400 text-2xl"></i>
                                    <div>
                                        <h3 class="text-white font-medium"><?php echo htmlspecialchars($doc['titre']); ?></h3>
                                        <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($doc['description']); ?></p>
                                    </div>
                                </div>
                                <a href="/youdemy/app/action/supadmin/cours/uploads/media/files/<?php echo htmlspecialchars($doc['fichier']); ?>" 
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center"
                                   target="_blank" download>
                                    <i class="fas fa-download mr-2"></i>
                                    Télécharger
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar - Liste des Vidéos -->
            <div class="lg:col-span-1">
                <div class="bg-white/10 backdrop-blur-xl rounded-xl p-6 border border-white/20 sticky top-24">
                    <h2 class="text-xl font-bold text-white mb-4">Contenu du Cours</h2>
                    <?php if (!empty($videos)): ?>
                        <div class="space-y-2">
                            <?php foreach ($videos as $index => $video): ?>
                                <button onclick="changeVideo('<?php echo htmlspecialchars($video['fichier']); ?>', '<?php echo htmlspecialchars($video['image_url']); ?>', this)" 
                                        class="w-full flex items-center p-3 rounded-lg hover:bg-white/10 transition-colors text-left group <?php echo $index === 0 ? 'bg-blue-600/20' : 'text-gray-300'; ?>">
                                    <div class="w-24 h-16 mr-3 relative rounded overflow-hidden">
                                        <img src="../../../app/action/supadmin/cours/uploads/media/images/<?php echo $video['image_url'] ?: 'default-thumbnail.jpg'; ?>" 
                                             class="w-full h-full object-cover"
                                             alt="<?php echo htmlspecialchars($video['titre']); ?>">
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-play text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium group-hover:text-white transition-colors line-clamp-2">
                                            <?php echo htmlspecialchars($video['titre']); ?>
                                        </h3>
                                        <p class="text-sm text-gray-400">
                                            <?php echo $video['duree'] ? $video['duree'] : 'Durée non spécifiée'; ?>
                                        </p>
                                    </div>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-400 text-center">Aucune vidéo disponible</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainVideo = document.getElementById('mainVideo');
            if (mainVideo) {
                // Charger la dernière position
                const savedTime = localStorage.getItem(`video-${mainVideo.src}`);
                if (savedTime) {
                    mainVideo.currentTime = parseFloat(savedTime);
                }
                // Démarrer la lecture automatiquement
                mainVideo.play().catch(function(error) {
                    console.log("La lecture automatique a été empêchée:", error);
                });

                // Sauvegarder la position périodiquement
                mainVideo.addEventListener('timeupdate', () => {
                    localStorage.setItem(`video-${mainVideo.src}`, mainVideo.currentTime);
                });
            }
        });

        function changeVideo(videoFile, thumbnailFile, button) {
            const mainVideo = document.getElementById('mainVideo');
            const videoButtons = document.querySelectorAll('button[onclick^="changeVideo"]');
            
            // Sauvegarder la position actuelle avant de changer
            localStorage.setItem(`video-${mainVideo.src}`, mainVideo.currentTime);
            
            // Mettre à jour la source de la vidéo et la miniature
            mainVideo.poster = `../../../app/action/supadmin/cours/uploads/media/images/${thumbnailFile}`;
            mainVideo.src = `/youdemy/app/action/supadmin/cours/uploads/media/files/${videoFile}`;
            
            // Charger la position sauvegardée pour la nouvelle vidéo
            const savedTime = localStorage.getItem(`video-${mainVideo.src}`);
            if (savedTime) {
                mainVideo.currentTime = parseFloat(savedTime);
            }
            
            // Démarrer la lecture
            mainVideo.play().catch(function(error) {
                console.log("La lecture automatique a été empêchée:", error);
            });
            
            // Mettre à jour les styles des boutons
            videoButtons.forEach(btn => btn.classList.remove('bg-blue-600/20'));
            button.classList.add('bg-blue-600/20');
        }
    </script>
</body>
</html>
