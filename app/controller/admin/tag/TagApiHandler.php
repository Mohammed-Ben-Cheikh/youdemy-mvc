<?php
use App\Model\Crud;
use App\Model\GetSet;

header('Content-Type: application/json');

class Tag extends GetSet
{
    protected $id;
    protected $name;
    protected $createdAt;

    public function __construct($name, $id = null, $createdAt = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->createdAt = $createdAt;
    }
}

class TagApiHandler
{
    public function handleRequest()
    {
        $action = $_REQUEST['action'] ?? 'get_tags';

        try {
            switch ($action) {
                case 'get_tags':
                    $this->getTags();
                    break;

                case 'add_tag':
                    if (!isset($_POST['tag'])) {
                        $this->sendResponse(false, "Tag non spécifié");
                        return;
                    }
                    $this->addTag($_POST['tag']);
                    break;

                case 'remove_tag':
                    if (!isset($_POST['tag'])) {
                        $this->sendResponse(false, "Tag non spécifié");
                        return;
                    }
                    $this->removeTag($_POST['tag']);
                    break;

                default:
                    $this->sendResponse(false, "Action non valide");
            }
        } catch (Exception $e) {
            $this->sendResponse(false, $e->getMessage());
        }
    }

    private function getTags()
    {
        $tags = [];
        $row = Crud::getAll('tags');
        foreach ($row as $r) {
            $tags[] = new Tag($r['name'], $r['id_tag'], $r['created_at']);
        }

        $tagNames = array_map(function ($tag) {
            return $tag->getAttributes('name');
        }, $tags);

        // Corrected syntax for the response
        $this->sendResponse(true, "Tags récupérés avec succès", ['data' => $tagNames]);
    }


    private function addTag($tagName)
    {
        try {
            $tags = explode(',', $tagName);
            foreach ($tags as $tag) {
                $insertTag = new Tag($tag);
                $name = $insertTag->getAttributes(['name']);
                Crud::insertData('tags', ['name' => $name]);
            }
            $this->sendResponse(true, "Tag ajouté avec succès");
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                throw new Exception("Ce tag existe déjà");
            }
            throw new Exception("Erreur lors de l'ajout du tag : " . $e->getMessage());
        }
    }

    private function removeTag($tagName)
    {
        if ($tagName)
            Crud::deleteData('tags', 'name', $tagName);
        $this->sendResponse(true, "Tag supprimé avec succès");
    }

    private function sendResponse($success, $message, $data = [])
    {
        echo json_encode(array_merge(
            [
                'success' => $success,
                'message' => $message
            ],
            $data
        ));
        exit;
    }
}

// Initialisation et exécution
$handler = new TagApiHandler();
$handler->handleRequest();