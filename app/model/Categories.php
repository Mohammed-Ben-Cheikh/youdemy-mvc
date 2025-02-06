<?php
use App\Model\GetSet;
class Categories extends GetSet {
    protected $id;
    protected $titre;
    protected $description;
    protected $image_url;

    public function __construct($titre, $description, $image_url, $id = null,) {
        $this->titre = $titre;
        $this->image_url = $image_url;
        $this->description = $description;
        $this->id = $id;
    }
}