<?php

require_once __DIR__ . "/../vendor/autoload.php";
use app\core\Router;
use app\core\Request;
use app\controller\AuthController;
use app\controller\PageController;

// Define the routes
$router = new Router();
$request = new Request();

$router->get('/', [PageController::class, 'homeIndex']);
$router->get('/categories', [PageController::class, 'categoriesIndex']);
$router->get('/cours', [PageController::class, 'coursIndex']);
////////////////////////////////////////////////////////////////////////////////////////////////
$router->get('/dashboard/admin', [PageController::class, 'adminIndex']);
$router->get('/dashboard/admin/categories', [PageController::class, 'adminCategories']);
$router->get('/dashboard/admin/cours', [PageController::class, 'adminCours']);
$router->get('/dashboard/admin/utilisateurs', [PageController::class, 'adminUtilisateurs']);
////////////////////////////////////////////////////////////////////////////////////////////////
$router->get('/dashboard/enseignant', [PageController::class, 'loginIndex']);
$router->get('/dashboard/enseignant/inscriptions', [PageController::class, 'login']);
$router->get('/dashboard/enseignant/cours', [PageController::class, 'signupIndex']);
$router->get('/dashboard/enseignant/categories', [PageController::class, 'signup']);
////////////////////////////////////////////////////////////////////////////////////////////////
$router->get('/dashboard/etudiant', [PageController::class, 'loginIndex']);
$router->get('/dashboard/etudiant/catalogueEtCours', [PageController::class, 'loginIndex']);
$router->get('/dashboard/etudiant/cours', [PageController::class, 'login']);
$router->get('/dashboard/etudiant/cours-details', [PageController::class, 'signupIndex']);
$router->get('/dashboard/etudiant/reserver', [PageController::class, 'signup']);
////////////////////////////////////////////////////////////////////////////////////////////////
$router->get('/login', [AuthController::class, 'loginIndex']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/signup', [AuthController::class, 'signupIndex']);
$router->post('/signup', [AuthController::class, 'signup']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->dispatch($request->getPath(), $request->getMethod());