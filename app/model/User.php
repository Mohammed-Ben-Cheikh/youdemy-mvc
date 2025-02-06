<?php 

require_once 'Person.php';

class User extends Admin {
    protected $statut;
    public function __construct($nom, $prenom, $username, $email, $telephone, $mot_de_passe, $adresse, $id_role_fk, $statut){
        parent::__construct($nom, $prenom, $username, $email, $telephone, $mot_de_passe, $adresse, $id_role_fk);
        $this->statut = $statut;
    }
}