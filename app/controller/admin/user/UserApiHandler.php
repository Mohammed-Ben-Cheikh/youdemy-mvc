<?php
use App\Model\Crud;


header('Content-Type: application/json');

class UserApiHandler
{
    public function handleRequest()
    {
        $action = $_REQUEST['action'] ?? 'get_users';

        try {
            switch ($action) {
                case 'get_users':
                    $this->getUsers();
                    break;

                case 'update_sup_admin':
                    if (!isset($_POST['statut']) || !isset($_POST['id'])) {
                        $this->sendResponse(false, "data non spécifié");
                        return;
                    }
                    $this->supAdminStatut($_POST['statut'], $_POST['id']);
                    break;

                case 'update_user':
                    if (!isset($_POST['statut']) || !isset($_POST['id'])) {
                        $this->sendResponse(false, "data non spécifié");
                        return;
                    }
                    $this->userStatut($_POST['statut'], $_POST['id']);
                    break;

                default:
                    $this->sendResponse(false, "Action non valide");
            }
        } catch (Exception $e) {
            $this->sendResponse(false, $e->getMessage());
        }
    }
    private function getUsers()
    {
        // Récupérer les données des deux tables
        $supAdmins = Crud::getAll('sup_admins');
        $users = Crud::getAll('users');

        // Ajouter un préfixe aux ID pour éviter les conflits
        foreach ($supAdmins as &$admin) {
            // $admin['id_admin'] = 'sup_admin_' . $admin['id_admin']; // Préfixe pour les super admins
            $admin['role'] = 'Moderator'; // Ajouter un champ 'role'
        }

        foreach ($users as &$user) {
            // $user['id_user'] = 'user_' . $user['id_user']; // Préfixe pour les utilisateurs normaux
            $user['role'] = 'User'; // Ajouter un champ 'role'
        }

        // Combiner les deux tableaux
        $combinedUsers = array_merge($supAdmins, $users);
        $this->sendResponse(true, "Users récupérés avec succès", $combinedUsers);
    }
    private function supAdminStatut($Statut, $id)
    {
        try {
            // if (strpos($id, 'sup_admin_') === 0) {
            //     $id = (int) substr($id, strlen('sup_admin_'));
            // } else {
            //     throw new InvalidArgumentException("Format de l'ID invalide.");
            // }
            Crud::updateStatut('sup_admins', $Statut, 'id_admin', $id);
            $this->sendResponse(true, "Statut mis à jour avec succès");
        } catch (InvalidArgumentException $e) {
            $this->sendResponse(false, "Erreur : " . $e->getMessage());
        } catch (Exception $e) {
            $this->sendResponse(false, "Erreur inconnue : " . $e->getMessage());
        }
    }


    private function userStatut($Statut, $id)
    {
        try {
            // if (strpos($id, 'user_') === 0) {
            //     $id = (int) substr($id, strlen('user_'));
            // } else {
            //     throw new InvalidArgumentException("Format de l'ID invalide.");
            // }
            Crud::updateStatut('users', $Statut, 'id_user', $id);
            $this->sendResponse(true, "Statut mis à jour avec succès");
        } catch (InvalidArgumentException $e) {
            $this->sendResponse(false, "Erreur : " . $e->getMessage());
        } catch (Exception $e) {
            $this->sendResponse(false, "Erreur inconnue : " . $e->getMessage());
        }
    }

    private function sendResponse($success, $message, $data = [])
    {
        echo json_encode(array_merge(
            [
                'success' => $success,
                'message' => $message
            ],
            $data
        ));
        exit;
    }
}

// Initialisation et exécution
$handler = new UserApiHandler();
$handler->handleRequest();