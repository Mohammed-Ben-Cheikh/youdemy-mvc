<?php
use App\Model\Crud;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'update_status':
            updateCourseStatus();
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Action invalide']);
            break;
    }
}

function updateCourseStatus() {
    try {
        $courseId = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$courseId || !$status) {
            throw new Exception('Paramètres manquants');
        }

        $result = Crud::updateColumn('cours', 'statut', $status, 'id_cour', $courseId);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Statut mis à jour avec succès']);
        } else {
            throw new Exception('Erreur lors de la mise à jour du statut');
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
