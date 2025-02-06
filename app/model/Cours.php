<?php
namespace App\Model;
use App\Model\GetSet;
class Cours extends GetSet
{
    protected $titre;
    protected $description;
    protected $id_enseignant_fk;
    protected $image_url;
    protected $id_categorie_fk;

    public function __construct($titre, $description, $image_url, $id_enseignant_fk = null, $id_categorie_fk = null)
    {
        $this->titre = $titre;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->id_enseignant_fk = $id_enseignant_fk;
        $this->id_categorie_fk = $id_categorie_fk;
    }
}
