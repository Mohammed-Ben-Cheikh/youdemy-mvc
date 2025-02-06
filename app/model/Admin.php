<?PHP
use App\Model\GetSet;
abstract class Admin extends GetSet
{
    protected $nom;
    protected $prenom;
    protected $username;
    protected $email;
    protected $telephone;
    protected $mot_de_passe;
    protected $adresse;
    protected $id_role_fk;

    public function __construct($nom, $prenom, $username, $email, $telephone, $mot_de_passe, $adresse, $id_role_fk)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->username = $username;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->mot_de_passe = $mot_de_passe;
        $this->adresse = $adresse;
        $this->id_role_fk = $id_role_fk;
    }
    
}



