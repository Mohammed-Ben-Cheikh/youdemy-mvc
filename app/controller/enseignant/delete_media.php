<?php
require_once __DIR__ . '/../../../../app/Classes/classdao/Crud.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $mediaId = $data['id'];
    
    // Supprimer le média de la base de données
    Crud::deleteData('cours_videos', 'id_video', $mediaId);
    Crud::deleteData('cours_documents', 'id_document', $mediaId);
    
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}