<?php
namespace app\auth;

use app\helper\Helper;
use app\Model\Crud;
use app\Model\User;
use app\Model\Admin;

class Auth
{
    private static $error = '';

    public static function login($email, $password, $userTypes)
    {
        $userTypes = [
            'etudiant' => ['table' => 'etudiants', 'id_field' => 'id_etudiant'],
            'admin' => ['table' => 'admins', 'id_field' => 'id_admin'],
            'enseignant' => ['table' => 'sup_admins', 'id_field' => 'id_admin']
        ];

        foreach ($userTypes as $role => $info) {
            $user = Crud::getBy($info['table'], 'email', $email);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                self::setSession($user, $role === 'enseignant');
                Crud::updateColumn($info['table'], 'last_login', date('Y-m-d H:i:s'), $info['id_field'], $user[$info['id_field']]);
                Helper::goToPage("/dashboard/$role");
                exit();
            }
        }

        self::$error = 'Email ou mot de passe incorrect';
        return false;
    }

    public static function register($nom, $prenom, $username, $email, $telephone, $password, $confirm_password, $adresse, $id_role_fk)
    {
        if ($password !== $confirm_password) {
            self::$error = 'Les mots de passe ne correspondent pas';
            return false;
        }

        if (Crud::getBy('users', 'email', $email) || Crud::getBy('sup_admins', 'email', $email) || Crud::getBy('admins', 'email', $email)) {
            self::$error = 'Cet email est déjà utilisé';
            return false;
        }

        if (Crud::getBy('users', 'username', $username) || Crud::getBy('sup_admins', 'username', $username) || Crud::getBy('admins', 'username', $username)) {
            self::$error = 'Cet username est déjà utilisé';
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($id_role_fk == 1) {
            $person = new User($nom, $prenom, $username, $email, $telephone, $hashed_password, $adresse, $id_role_fk, 'inactive');
            $data = $person->getAttributes(['nom', 'username', 'prenom', 'email', 'telephone', 'mot_de_passe', 'adresse', 'id_role_fk']);
            if (Crud::insertData('sup_admins', $data)) {
                Helper::goToPage('/app/auth/login.php');
                exit();
            }
        } else if ($id_role_fk == 3) {
            $person = new User($nom, $prenom, $username, $email, $telephone, $hashed_password, $adresse, $id_role_fk, 'active');
            $data = $person->getAttributes(['nom', 'username', 'prenom', 'email', 'telephone', 'mot_de_passe', 'adresse', 'id_role_fk', 'statut']);
            if (Crud::insertData('users', $data)) {
                Helper::goToPage('/app/auth/login.php');
                exit();
            }
        }

        return false;
    }

    private static function setSession($user, $isEnseignant = false)
    {
        $_SESSION['user_id'] = $user['id_' . ($isEnseignant ? 'admin' : 'etudiant')];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['id_role_fk'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];

        if ($isEnseignant) {
            $_SESSION['status'] = $user['statut'];
        }
    }

    public static function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        Helper::goToPage('/login');
        exit();
    }

    public static function getError()
    {
        return self::$error;
    }
}
