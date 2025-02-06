<?php
session_start();
require_once __DIR__ . '/../Classes/classdao/Crud.php';
require_once __DIR__ . '/../Classes/User.php';
require_once __DIR__ . '/../Classes/Admin.php';
require_once __DIR__ . '/../Classes/SupAdmin.php';
require_once __DIR__ . '/../Classes/Cours.php';
require_once __DIR__ . '/../helper/function.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $admin = Crud::getBy('admins', 'email', $email);
    $supAdmin = Crud::getBy('sup_admins', 'email', $email);
    $user = Crud::getBy('users', 'email', $email);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $current_time = date('Y-m-d H:i:s');
        Crud::updateColumn('users','last_login',$current_time,'id_user',$user['id_user']);
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['id_role_fk'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];
        $_SESSION['user_adresse'] = $user['adresse'];
        Helper::goToPage('/dashboard/user');
        exit();
    } else if ($admin && password_verify($password, $admin['mot_de_passe'])) {
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_role'] = $admin['id_role_fk'];
        $_SESSION['admin_nom'] = $admin['nom'];
        $_SESSION['admin_prenom'] = $admin['prenom'];
        Helper::goToPage('/dashboard/admin');
        exit();
    } else if ($supAdmin && password_verify($password, $supAdmin['mot_de_passe'])) {
        $current_time = date('Y-m-d H:i:s');
        Crud::updateColumn('sup_admins','last_login',$current_time,'id_admin',$supAdmin['id_admin']);
        $_SESSION['supadmin_id'] = $supAdmin['id_admin'];
        $_SESSION['admin_email'] = $supAdmin['email'];
        $_SESSION['admin_role'] = $supAdmin['id_role_fk'];
        $_SESSION['admin_nom'] = $supAdmin['nom'];
        $_SESSION['admin_prenom'] = $supAdmin['prenom'];
        $_SESSION['status'] = $supAdmin['statut'];
        Helper::goToPage('/dashboard/supadmin');
        exit();
    } else {
        $error = 'Email ou mot de passe incorrect';
    }
}