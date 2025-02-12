<?php
namespace app\controller\auth;

use app\helper\Helper;
use app\model\Crud;
use app\model\User;
use app\model\Admin;

class Auth
{
    private static $error = '';

    public static function login($email, $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::$error = 'Email invalide';
            return false;
        }

        $userTypes = [
            'etudiant' => ['table' => 'etudiants', 'id_field' => 'id_etudiant'],
            'admin' => ['table' => 'admins', 'id_field' => 'id_admin'],
            'enseignant' => ['table' => 'enseignants', 'id_field' => 'id_admin']
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

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::$error = 'Email invalide';
            return false;
        }

        if (self::isEmailUsed($email)) {
            self::$error = 'Cet email est déjà utilisé';
            return false;
        }

        if (self::isUsernameUsed($username)) {
            self::$error = 'Cet username est déjà utilisé';
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($id_role_fk == 2) {
            $person = new User($nom, $prenom, $username, $email, $telephone, $hashed_password, $adresse, $id_role_fk, 'inactive');
            $data = $person->getAttributes(['nom', 'username', 'prenom', 'email', 'telephone', 'mot_de_passe', 'adresse', 'id_role_fk']);
            if (Crud::insertData('enseignants', $data)) {
                Helper::goToPage('/login');
                exit();
            } else {
                self::$error = 'Erreur lors de l\'inscription dans la table sup_admins';
                return false;
            }
        } else if ($id_role_fk == 3) {
            $person = new User($nom, $prenom, $username, $email, $telephone, $hashed_password, $adresse, $id_role_fk, 'active');
            $data = $person->getAttributes(['nom', 'username', 'prenom', 'email', 'telephone', 'mot_de_passe', 'adresse', 'id_role_fk', 'statut']);
            if (Crud::insertData('etudiants', $data)) {
                Helper::goToPage('/login');
                exit();
            } else {
                self::$error = 'Erreur lors de l\'inscription dans la table users';
                return false;
            }
        } else {
            self::$error = 'Rôle non reconnu';
            return false;
        }
    }

    private static function isEmailUsed($email)
    {
        return Crud::getBy('etudiants', 'email', $email) || Crud::getBy('enseignants', 'email', $email) || Crud::getBy('admins', 'email', $email);
    }

    private static function isUsernameUsed($username)
    {
        return Crud::getBy('etudiants', 'username', $username) || Crud::getBy('enseignants', 'username', $username) || Crud::getBy('admins', 'username', $username);
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
        Helper::goToPage('');
        exit();
    }

    public static function isLogged()
    {
        return isset($_SESSION['user_id']);
    }

    public static function getError()
    {
        return self::$error;
    }
}