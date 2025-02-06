<?php
require_once __DIR__ . '/../../../../app/Classes/classdao/Crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $id = $_POST['id'];
        $result = Crud::deleteData('cours', 'id_cour',$id);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Catégorie supprimée avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}