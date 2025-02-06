<?php
require_once __DIR__ . '/../helper/function.php';
require_once __DIR__ . '/../Classes/classdao/Crud.php';
require_once __DIR__ . '/../Classes/User.php';
require_once __DIR__ . '/../Classes/SupAdmin.php';
require_once __DIR__ . '/../Classes/Cours.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $adresse = $_POST['adresse'];
    $id_role_fk = $_POST['id_role']  ;

    if ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas';
    } else if (Crud::getBy('users', 'email', $email) || Crud::getBy('sup_admins', 'email', $email) || Crud::getBy('admins', 'email', $email)) {
        $error = 'Cet email est déjà utilisé';
    } else if (Crud::getBy('users', 'username', $username) || Crud::getBy('sup_admins', 'email', $email) || Crud::getBy('admins', 'username', $username)) {
        $error = 'Cet username est déjà utilisé';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($id_role_fk == 1) {
            $person = new SupAdmin(
                $nom,
                $prenom,
                $username,
                $email,
                $telephone,
                $hashed_password,
                $adresse,
                $id_role_fk,
                'inactive'
            );

            $data = $person->getAttributes(['nom', 'username', 'prenom', 'email', 'telephone', 'mot_de_passe', 'adresse', 'id_role_fk']);

            if (Crud::insertData('sup_admins', $data)) {
                Helper::goToPage('/app/auth/login.php');
                exit();
            }
        } else if ($id_role_fk == 3) {
            $person = new User(
                $nom,
                $prenom,
                $username,
                $email,
                $telephone,
                $hashed_password,
                $adresse,
                $id_role_fk,
                'active'
            );
            $data = $person->getAttributes(['nom', 'username', 'prenom', 'email', 'telephone', 'mot_de_passe', 'adresse', 'id_role_fk', 'statut']);

            if (Crud::insertData('users', $data)) {
                Helper::goToPage('/app/auth/login.php');
                exit();
            }
        }
    }
}
