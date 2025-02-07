<?php
namespace App\Model;
require_once __DIR__ . '/../getid3/getid3.php';
use InvalidArgumentException;
use App\Model\Cours;
use Exception;
use getID3;

// Classe pour les cours Video
class CoursVideo extends Cours
{
    protected $duree;
    protected $qualite;
    protected $id_cour_fk;
    protected $fichier;

    public function __construct($titre, $description, $image_url, $id_cour_fk, $fichier)
    {
        parent::__construct($titre, $description, $image_url);
        $this->fichier = (__DIR__ . '/../action/supadmin/cours/uploads/media/files/' . $fichier);
        $this->id_cour_fk = $id_cour_fk;

        if ($this->fichier && file_exists($this->fichier)) {
            $this->analyserVideo();
        } else {
            throw new Exception("Le fichier vidéo spécifié n'existe pas.");
        }
    }

    private function analyserVideo()
    {
        try {
            // Initialisation de getID3
            $getID3 = new getID3();

            // Analyse du fichier
            $videoInfo = $getID3->analyze($this->fichier);

            // Extraction de la durée
            if (isset($videoInfo['playtime_seconds'])) {
                $this->duree = $this->formatDuree($videoInfo['playtime_seconds']);
            } else {
                throw new Exception("Impossible d'extraire la durée de la vidéo.");
            }

            // Détection de la qualité
            if (isset($videoInfo['video']['resolution_x']) && isset($videoInfo['video']['resolution_y'])) {
                $this->qualite = $this->determinerQualiteVideo(
                    $videoInfo['video']['resolution_x'],
                    $videoInfo['video']['resolution_y']
                );
            } else {
                throw new Exception("Impossible d'extraire la résolution de la vidéo.");
            }
        } catch (Exception $e) {
            error_log("Erreur d'analyse vidéo avec getID3: " . $e->getMessage());
            throw new Exception("Erreur lors de l'analyse de la vidéo.");
        }
    }

    private function formatDuree($seconds)
    {
        // First round the input to avoid floating point precision issues
        $seconds = round($seconds);

        // Calculate hours, minutes, and seconds with explicit integer operations
        $hours = (int) ($seconds / 3600);
        $minutes = (int) (($seconds % 3600) / 60);
        $seconds = (int) ($seconds % 60);

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    private function determinerQualiteVideo($largeur, $hauteur)
    {
        // Vérifier que les valeurs sont numériques
        if (!is_numeric($largeur) || !is_numeric($hauteur)) {
            throw new InvalidArgumentException("Les valeurs de largeur et hauteur doivent être numériques.");
        }

        // Convertir explicitement en entiers
        $largeur = (int) $largeur;
        $hauteur = (int) $hauteur;

        $resolution = $largeur * $hauteur;

        if ($resolution >= 8294400) { // 4K (3840×2160)
            return '4K';
        } elseif ($resolution >= 2073600) { // 1080p (1920×1080)
            return 'Full HD';
        } elseif ($resolution >= 921600) { // 720p (1280×720)
            return 'HD';
        } else {
            return 'SD';
        }
    }

    public function afficherDetails()
    {
        return [
            'titre' => $this->titre,
            'type' => 'video',
            'id_cour_fk' => $this->id_cour_fk,
            'description' => $this->description,
            'fichier' => $this->fichier,
            'duree' => $this->duree,
            'qualite' => $this->qualite,
        ];
    }
}