<?php
use Exception;
use App\Model\Cours;

class CoursDocument extends Cours
{
    protected $nombre_pages;
    protected $taille;
    protected $id_cour_fk;
    protected $fichier;

    public function __construct($titre, $description, $image_url, $id_cour_fk, $fichier)
    {
        parent::__construct($titre, $description, $image_url);
        $this->fichier = (__DIR__ . '/../action/supadmin/cours/uploads/media/files/' . $fichier);
        $this->id_cour_fk = $id_cour_fk;

        // Vérifier si le fichier existe
        if ($this->fichier && file_exists($this->fichier)) {
            // Convertir la taille en Mo
            $this->taille = round(filesize($this->fichier) / 1048576, 2) . ' Mo'; // Arrondi à 2 décimales
            // Extraction du nombre de pages
            $this->nombre_pages = self::getNumberOfPages($this->fichier);
        } else {
            throw new Exception("Le fichier spécifié n'existe pas.");
        }
    }

    public static function getNumberOfPages($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("Le fichier PDF n'existe pas.");
        }

        // Ouvrir le fichier en mode binaire
        $file = fopen($filePath, 'rb');
        if (!$file) {
            throw new Exception("Impossible d'ouvrir le fichier PDF.");
        }

        // Lire les premiers 10000 octets (cela contient généralement les métadonnées)
        $content = fread($file, 10000);
        fclose($file);

        // Rechercher la balise "/Count" dans le contenu
        if (preg_match('/\/Count\s+(\d+)/', $content, $matches)) {
            return (int) $matches[1]; // Retourne le nombre de pages
        }

        // Si la balise "/Count" n'est pas trouvée, essayer une autre méthode
        if (preg_match_all('/\/Type\s*\/Page\b/', $content, $matches)) {
            // Compter le nombre de pages en recherchant les balises "/Type /Page"
            return count($matches[0]);
        }

        // Si aucune méthode ne fonctionne, retourner 1 par défaut
        return 1;
    }
}