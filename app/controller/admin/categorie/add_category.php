<?php
use App\Model\Crud;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $titre = $_POST['categoryName'];
        $description = $_POST['categoryDesc'];
        $image_url = '';

        // Handle file upload
        if (isset($_FILES['categoryImage']) && $_FILES['categoryImage']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $filename = $_FILES['categoryImage']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);

            if (in_array(strtolower($filetype), $allowed)) {
                $newname = uniqid() . '.' . $filetype;
                $upload_path = '../uploads/categories/' . $newname;

                if (!is_dir('../uploads/categories/')) {
                    mkdir('../uploads/categories/', 0777, true);
                }

                if (move_uploaded_file($_FILES['categoryImage']['tmp_name'], $upload_path)) {
                    $image_url = 'uploads/categories/' . $newname;
                }
            }
        }

        $categorie = new Categories($titre, $description, $image_url);
        $data = $categorie->getAttributes(['titre', 'description', 'image_url']);
        if (Crud::insertData('categories', $data)){
            echo json_encode(['success' => true, 'message' => 'Catégorie ajoutée avec succès']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }

}