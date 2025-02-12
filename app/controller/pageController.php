<?php
namespace app\controller;
use app\helper\Helper;
use app\model\Crud; // corrected namespace casing

class PageController
{
    public function homeIndex()
    {
        include_once __DIR__ . "/../views/visiteur/index.php";
    }

    public function categoriesIndex()
    {
        session_start();

if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    Helper::goToPage('/dashboard/user');
} else if (isset($_SESSION['admin_id']) && $_SESSION['admin_id']) {
    Helper::goToPage('/dashboard/admin');
} else if (isset($_SESSION['supadmin_id']) && $_SESSION['supadmin_id']) {
    Helper::goToPage('/dashboard/supadmin');
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

$totalRows = Crud::countRecords('categories');
$rowsPerPage = 4;
$totalPages = ceil($totalRows / $rowsPerPage);


$categories = Crud::getPaginated('categories', $rowsPerPage, $page);

if (isset($_GET['date']) || isset($_GET['search'])) {
    $date_filter = $_GET['date'] ?? '';
    $search = $_GET['search'] ?? '';

    $categories = Crud::getAll('categories');

    if ($date_filter) {
        $categories = array_filter($categories, function ($r) use ($date_filter) {
            return date('Y-m-d', strtotime($r['created_at'])) === $date_filter;
        });
    }

    if ($search) {
        $categories = array_filter($categories, function ($r) use ($search) {
            return stripos($r['titre'], $search) !== false;
        });
    }
}
        include_once __DIR__ . "/../views/visiteur/page/catégories.php";
    }

    public function coursIndex()
    {
        session_start();

        if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
            Helper::goToPage('/dashboard/user');
        } else if (isset($_SESSION['admin_id']) && $_SESSION['admin_id']) {
            Helper::goToPage('/dashboard/admin');
        } else if (isset($_SESSION['supadmin_id']) && $_SESSION['supadmin_id']) {
            Helper::goToPage('/dashboard/supadmin');
        }

        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

        $totalRows = Crud::countRecords('categories');
        $rowsPerPage = 4;
        $totalPages = ceil($totalRows / $rowsPerPage);

        $categories = Crud::getPaginated('categories', $rowsPerPage, $page);

        if (isset($_GET['date']) || isset($_GET['search'])) {
            $date_filter = $_GET['date'] ?? '';
            $search = $_GET['search'] ?? '';

            $categories = Crud::getAll('categories');

            if ($date_filter) {
                $categories = array_filter($categories, function ($r) use ($date_filter) {
                    return date('Y-m-d', strtotime($r['created_at'])) === $date_filter;
                });
            }

            if ($search) {
                $categories = array_filter($categories, function ($r) use ($search) {
                    return stripos($r['titre'], $search) !== false;
                });
            }
        }

        include_once __DIR__ . "/../views/visiteur/page/Cours.php";
    }

    public function adminIndex() {
        include_once __DIR__ . "/../views/admin/index.php";
    }

    public function adminUtilisateurs() {
        include_once __DIR__ . "/../views/admin/page/utilisateurs.php";
    }

    public function adminCours() {
        include_once __DIR__ . "/../views/admin/page/cours.php";
    }

    public function adminCategories() {
        include_once __DIR__ . "/../views/admin/page/categories.php";
    }
}