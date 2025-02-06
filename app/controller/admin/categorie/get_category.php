<?php
use App\Model\Crud;

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $category = Crud::getBy('categories', 'id_categorie', $categoryId);
    
    if ($category) {
        header('Content-Type: application/json');
        echo json_encode($category);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Category not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No category ID provided']);
}
