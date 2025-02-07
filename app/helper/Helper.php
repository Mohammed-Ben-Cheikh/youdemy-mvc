<?php
namespace app\helper;
use Exception;
require_once __DIR__ . '/../core/config.php';
class Helper
{
    // Debugging function
    public static function dd($value)
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    }

    // CSRF Token Validation
    public static function validateCsrfToken()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        $csrfToken = $_POST['csrf_token'] ?? $data['csrf_token'] ?? "";

        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $csrfToken);
    }

    // Process content to replace line breaks
    public static function processContent($value)
    {
        return str_replace("\n", '&#10;', $value);
    }

    // Restore content from HTML line breaks
    public static function processBack($value)
    {
        return str_replace('&#10;', "<br>", $value);
    }

    // Redirect to a specific page
    public static function goToPage($page)
    {
        $url = URLROOT . $page;
        header("Location: {$url}");
        die();
    }

    // Example: Check if a user has a specific role
    public static function hasRole($role)
    {
        return isset($_SESSION['userRole']) && $_SESSION['userRole'] === $role;
    }

    // Check if a user is logged in
    public static function isLogged()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    // Image upload utility
    public static function uploadFile($file, $directory)
    {
        // Vérifier si le fichier a été uploadé sans erreur
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur lors de l'upload du fichier : Code d'erreur " . $file['error']);
        }

        // Définir les types MIME autorisés
        $allowed_types = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp', // Images
            'application/pdf', // PDF
            'video/mp4',
            'video/mpeg',
            'video/quicktime' // Vidéos
        ];

        // Vérifier le type MIME du fichier
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($file_mime, $allowed_types)) {
            throw new Exception("Type de fichier non autorisé : " . $file_mime);
        }

        // Générer un nom de fichier unique
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $file_extension;
        $target_file = $directory . $filename;

        // Déplacer le fichier uploadé vers le répertoire cible
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return $filename; // Retourne le nom du fichier uploadé
        } else {
            throw new Exception("Échec du déplacement du fichier uploadé.");
        }
    }

    // Example of adding a new utility method: Generate CSRF token
    public static function generateCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Example: Sanitize input to prevent XSS
    public static function sanitizeInput($value)
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    public static function getUserRole()
    {
        // Assuming user data is stored in session
        if (isset($_SESSION['user_role'])) {
            return $_SESSION['user_role'];
        }
        return null;
    }
}
