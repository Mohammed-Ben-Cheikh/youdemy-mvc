<?php
require_once __DIR__ . '/../../../../app/helper/function.php';
require_once __DIR__ . '/../../../../app/Classes/classdao/Crud.php';
require_once __DIR__ . '/../../../../app/Classes/CoursVideo.php';
require_once __DIR__ . '/../../../../app/Classes/CoursDocument.php';
require_once __DIR__ . '/../../../../app/Classes/Cours.php';

header('Content-Type: application/json');

try {
    // Récupérer l'ID du cours
    $cour_id = $_POST['cour_id'];

    // Mise à jour des inCatégories de base du cours
    $coursData = [
        'titre' => $_POST['cour_nom'],
        'description' => $_POST['cour_description'],
        'id_categorie_fk' => $_POST['id_categorie']
    ];

    // Gestion de l'image
    if (isset($_FILES['cour_image']) && $_FILES['cour_image']['error'] == UPLOAD_ERR_OK) {
        $course_image_dir = "./uploads/courses/images/";
        $coursData['image_url'] = Helper::uploadFile($_FILES['cour_image'], $course_image_dir);
    }

    Crud::updateData('cours', $coursData, 'id_cour', $cour_id);

    // Gestion des médias
    $media_ids = $_POST['media_id'] ?? [];

    foreach ($media_ids as $index => $media_id) {
        $mediaData = [
            'titre' => $_POST['media_nom'][$index],
            'description' => $_POST['media_description'][$index]
        ];

        // Gestion des fichiers
        if (!empty($_FILES['media_media']['name'][$index])) {
            $file = [
                'name' => $_FILES['media_media']['name'][$index],
                'type' => $_FILES['media_media']['type'][$index],
                'tmp_name' => $_FILES['media_media']['tmp_name'][$index],
                'error' => $_FILES['media_media']['error'][$index],
                'size' => $_FILES['media_media']['size'][$index]
            ];

            $media_files_dir = "./uploads/media/files/";
            $mediaData['fichier'] = Helper::uploadFile($file, $media_files_dir);
        }

        // Déterminer la table
        $table = (strpos($_FILES['media_media']['type'][$index], 'video') !== false)
            ? 'cours_videos'
            : 'cours_documents';

        // Supprimer le 's' à la fin pour obtenir 'id_video' ou 'id_document'
        $id_column = 'id_' . rtrim(explode('_', $table)[1], 's');

        Crud::updateData($table, $mediaData, $id_column, $media_id);
    }

    echo json_encode(['success' => true, 'message' => 'Cours mis à jour avec succès']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}