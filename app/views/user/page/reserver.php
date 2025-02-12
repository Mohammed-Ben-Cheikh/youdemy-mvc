<?php
require_once __DIR__ . '/../../../app/helper/function.php';
require_once __DIR__ . '/../../../app/Classes/classdao/Crud.php';
session_start();

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


$message = '';
$error = '';

// Vérifier si l'ID du cours est passé en paramètre
if (!isset($_GET['id_cour'])) {
    header('Location: catalogueEtCours.php');
    exit();
}

$id_cour = $_GET['id_cour'];
$user_id = $_SESSION['user_id'];

// Vérifier si le cours existe
$cours = Crud::getBy('cours', 'id_cour', $id_cour);
if (!$cours) {
    header('Location: catalogueEtCours.php');
    exit();
}

// Vérifier si l'utilisateur n'a pas déjà réservé ce cours
$existing_reservation = Crud::getBy('reservations', 'id_cour_fk', $id_cour);
if ($existing_reservation && $existing_reservation['id_user_fk'] == $user_id) {
    $error = "Vous avez déjà réservé ce cours";
} else {
    // Traiter la réservation
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $reservation_data = [
                'id_user_fk' => $user_id,
                'id_cour_fk' => $id_cour
            ];
            
            $result = Crud::insertData('reservations', $reservation_data);
            
            if ($result) {
                $message = "Réservation effectuée avec succès !";
                // Rediriger vers la page des cours après 2 secondes
                header("refresh:2;url=cours.php");
            } else {
                $error = "Erreur lors de la réservation";
            }
        } catch (Exception $e) {
            $error = "Une erreur est survenue : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un cours - YouDemy</title>
    <script src="http://localhost/youdemy/app/js/tailwindcss.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-900 to-blue-800 min-h-screen py-12">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-4xl w-full bg-white/10 backdrop-blur-xl rounded-xl shadow-2xl p-8 m-4 text-white border border-white/20">
            <h1 class="text-3xl font-bold text-center mb-8">Détails du Cours</h1>
            
            <?php if ($error): ?>
                <div class="bg-red-500/20 border-l-4 border-red-500 text-red-100 p-4 mb-6" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($message): ?>
                <div class="bg-green-500/20 border-l-4 border-green-500 text-green-100 p-4 mb-6" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if (!$error && !$message): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Image du cours -->
                    <div class="relative group">
                        <img src="../../../app/action/supadmin/cours/uploads/courses/images/<?php echo htmlspecialchars($cours['image_url'] ?: 'default-course.jpg'); ?>"
                             class="w-full h-64 object-cover rounded-xl shadow-lg"
                             alt="<?php echo htmlspecialchars($cours['titre']); ?>">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl"></div>
                    </div>

                    <!-- Informations du cours -->
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($cours['titre']); ?></h2>
                        
                        <div class="bg-blue-600/20 p-4 rounded-lg border border-blue-500/30">
                            <p class="text-blue-100"><?php echo htmlspecialchars($cours['description']); ?></p>
                        </div>

                        <!-- Détails supplémentaires -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                <span class="block text-sm text-blue-300">Date de création</span>
                                <span class="font-semibold">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <?php echo date('d/m/Y', strtotime($cours['created_at'])); ?>
                                </span>
                            </div>
                            <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                <span class="block text-sm text-blue-300">Statut</span>
                                <span class="font-semibold">
                                    <i class="fas fa-circle text-green-500 mr-2"></i>
                                    <?php echo ucfirst($cours['statut']); ?>
                                </span>
                            </div>
                        </div>

                        <?php 
                        // Récupérer les documents associés au cours
                        $documents = Crud::getAllBy('cours_documents', 'id_cour_fk', $cours['id_cour']);
                        if ($documents): ?>
                            <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                <h3 class="font-semibold mb-2"><i class="fas fa-file-alt mr-2"></i>Documents inclus</h3>
                                <ul class="space-y-2">
                                    <?php foreach ($documents as $doc): ?>
                                        <li class="flex items-center text-sm">
                                            <i class="fas fa-file-pdf mr-2 text-red-400"></i>
                                            <?php echo htmlspecialchars($doc['titre']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Formulaire de réservation -->
                <form method="POST" class="space-y-6">
                    <div class="flex items-center justify-between">
                        <a href="catalogueEtCours.php" 
                           class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-check mr-2"></i>Confirmer la réservation
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
