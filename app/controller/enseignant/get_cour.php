<?php
use App\Model\Crud;

header('Content-Type: application/json');

try {
    // Vérifier si l'ID du cours est fourni
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception("ID du cours non spécifié ou invalide");
    }

    $id = (int)$_GET['id'];

    // Récupérer les inCatégories du cours
    $cours = Crud::getBy('cours','id_cour', $id);
    if (!$cours || !is_array($cours)) {
        throw new Exception("Cours non trouvé");
    }

    // Récupérer les médias associés
    $medias = [];

    // Documents
    $documents = Crud::getAllBy('cours_documents', 'id_cour_fk', $id);
    // print_r($documents);
    if (is_array($documents)) {
        foreach ($documents as $doc) {
            if (is_array($doc)) {
                $medias[] = [
                    'type' => 'document',
                    'id' => $doc['id_document'] ?? null,
                    'titre' => $doc['titre'] ?? '',
                    'description' => $doc['description'] ?? '',
                    'fichier' => $doc['fichier'] ?? '',
                    'image_url' => $doc['image_url'] ?? ''
                ];
            }
        }
    }

    // Vidéos
    $videos = Crud::getAllBy('cours_videos', 'id_cour_fk', $id);
    if (is_array($videos)) {
        foreach ($videos as $vid) {
            if (is_array($vid)) {
                $medias[] = [
                    'type' => 'video',
                    'id' => $vid['id_video'] ?? null,
                    'titre' => $vid['titre'] ?? '',
                    'description' => $vid['description'] ?? '',
                    'fichier' => $vid['fichier'] ?? '',
                    'image_url' => $vid['image_url'] ?? ''
                ];
            }
        }
    }

    // Retourner les données
    echo json_encode([
        'success' => true,
        'data' => [
            'cours' => $cours,
            'medias' => $medias
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}