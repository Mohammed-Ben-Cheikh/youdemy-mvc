<?php
use App\Model\Cours;
use App\Model\CoursDocument;
use App\Model\CoursVideo;
use App\Model\Crud;
use App\helper\Helper;

header('Content-Type: application/json');

try {
    // Répertoires de téléchargement
    $course_image_dir = "./uploads/courses/images/";
    $media_image_dir = "./uploads/media/images/";
    $media_files_dir = "./uploads/media/files/";

    // Créer les répertoires s'ils n'existent pas
    if (!file_exists($course_image_dir))
        mkdir($course_image_dir, 0777, true);
    if (!file_exists($media_image_dir))
        mkdir($media_image_dir, 0777, true);
    if (!file_exists($media_files_dir))
        mkdir($media_files_dir, 0777, true);

    // Télécharger l'image du cours
    $course_image = '';
    if (isset($_FILES['cour_image']) && $_FILES['cour_image']['error'] == UPLOAD_ERR_OK) {
        $course_image = Helper::uploadFile($_FILES['cour_image'], $course_image_dir);
    }

    // Créer une instance de Cours
    $titre = $_POST['cour_nom'];
    $id_enseignant_fk = 1; // Remplacez par l'ID de l'enseignant approprié
    $image_url = $course_image;
    $id_categorie_fk = $_POST['id_categorie'];
    $description = $_POST['cour_description'];

    $tags = $_POST['tags'];

    $cour = new Cours($titre, $description, $image_url, $id_enseignant_fk, $id_categorie_fk);

    // Insérer le cours dans la base de données
    $data = $cour->getAttributes(['titre', 'description', 'image_url', 'id_enseignant_fk', 'id_categorie_fk']);
    $id_cour = Crud::insertData('cours', $data);

    if (!$id_cour) {
        throw new Exception("Erreur lors de la création du cours.");
    }

    foreach ($tags as $tag) {
        $data = [
            'id_tag_fk' => $tag,
            'id_cour_fk'=> $id_cour
        ];
        Crud::insertData('tags_cours',$data);
    }

    // Traiter les médias
    if (isset($_POST['media_nom']) && is_array($_POST['media_nom'])) {
        foreach ($_POST['media_nom'] as $index => $mediaNom) {
            $titre = $_POST['media_nom'][$index];
            $description = $_POST['media_description'][$index];
            $image_url = '';

            // Télécharger l'image du média
            if (isset($_FILES['media_image']['tmp_name'][$index]) && $_FILES['media_image']['error'][$index] == UPLOAD_ERR_OK) {
                $media_image = [
                    'name' => $_FILES['media_image']['name'][$index],
                    'type' => $_FILES['media_image']['type'][$index],
                    'tmp_name' => $_FILES['media_image']['tmp_name'][$index],
                    'error' => $_FILES['media_image']['error'][$index],
                    'size' => $_FILES['media_image']['size'][$index]
                ];
                $image_url = Helper::uploadFile($media_image, $media_image_dir);
            }

            // Télécharger le fichier média (PDF ou vidéo)
            if (isset($_FILES['media_media']['tmp_name'][$index]) && $_FILES['media_media']['error'][$index] == UPLOAD_ERR_OK) {
                $media_file = [
                    'name' => $_FILES['media_media']['name'][$index],
                    'type' => $_FILES['media_media']['type'][$index],
                    'tmp_name' => $_FILES['media_media']['tmp_name'][$index],
                    'error' => $_FILES['media_media']['error'][$index],
                    'size' => $_FILES['media_media']['size'][$index]
                ];

                // Valider le type de fichier
                $allowed_types = ['video/mp4', 'video/mp4', 'application/pdf'];
                if (!in_array($media_file['type'], $allowed_types)) {
                    throw new Exception("Type de fichier non autorisé : " . $media_file['type']);
                }

                // Upload du fichier
                $file_path = Helper::uploadFile($media_file, $media_files_dir);
                if (!$file_path) {
                    throw new Exception("Erreur lors de l'upload du fichier média.");
                }

                // Vérifier le type MIME
                $typeMime = $media_file['type'];

                if ($typeMime == 'application/pdf') {

                    // Créer une instance de CoursDocument
                    $coursDoc = new CoursDocument($titre, $description, $image_url, $id_cour, $file_path);

                    // Récupérer les attributs pour l'insertion
                    $data = $coursDoc->getAttributes(['titre', 'description', 'image_url', 'id_cour_fk', 'taille', 'nombre_pages']);
                    $data['fichier'] = $file_path;
                    // Insérer les données dans la table `cours_documents`
                    $id_document = Crud::insertData('cours_documents', $data);

                    if (!$id_document) {
                        throw new Exception("Erreur lors de l'insertion du document dans la base de données.");
                    }
                } elseif ($typeMime == 'video/mp4' || $typeMime == 'video/mpeg') {
                    // Créer une instance de CoursVideo
                    $coursVideo = new CoursVideo($titre, $description, $image_url, $id_cour, $file_path);
                    // Récupérer les attributs pour l'insertion
                    $data = $coursVideo->getAttributes(['titre', 'description', 'image_url', 'id_cour_fk', 'duree', 'qualite']);
                    $data['fichier'] = $file_path;
                    // Insérer les données dans la table `cours_videos`
                    $id_video = Crud::insertData('cours_videos', $data);

                    if (!$id_video) {
                        throw new Exception("Erreur lors de l'insertion de la vidéo dans la base de données.");
                    }
                } else {
                    throw new Exception("Type de fichier non pris en charge : " . $typeMime);
                }
            } else {
                throw new Exception("Erreur lors du téléchargement du fichier média.");
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Cours ajouté avec succès']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}