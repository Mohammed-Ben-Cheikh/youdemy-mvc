<?php
namespace app\controller;
use app\helper\Helper;
use app\controller\auth\Auth;

class AuthController
{
    public function loginIndex()
    {
        $error = null;
        require_once __DIR__ . "/../../app/views/auth/login.php";
    }

    public function signupIndex()
    {
        $error = null;
        require_once __DIR__ . "/../../app/views/auth/signup.php";
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (Helper::validateCsrfToken($_POST['csrf_token'])) {
                Helper::goToPage('/');
            }
            var_dump($_SESSION['csrf_token']);
            var_dump($_POST['csrf_token']);
            var_dump(Helper::validateCsrfToken($_POST['csrf_token']));
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            Auth::login($email, $password);
        }

        if (Auth::isLogged()) {
        } else {
            $error = Auth::getError();
            require_once __DIR__ . "/../../app/views/auth/login.php";
        }
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_SPECIAL_CHARS);
            $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_role_fk = filter_input(INPUT_POST, 'id_role_fk', FILTER_SANITIZE_NUMBER_INT);
        }
        if (Auth::register($nom, $prenom, $username, $email, $telephone, $password, $confirm_password, $adresse, $id_role_fk)) {
        } else {
            $error = Auth::getError();
            require_once __DIR__ . "/../../app/views/auth/signup.php";
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}