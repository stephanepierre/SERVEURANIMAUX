<?php
require_once "./controllers/back/Securite.class.php";
require_once "./models/back/animaux.manager.php";
require_once "./models/back/familles.manager.php";
require_once "./models/back/continents.manager.php";


class AnimauxController{
    private $animauxManager;

    public function __construct(){
        $this->animauxManager = new AnimauxManager();
    }

    public function visualisation(){
        if(Securite::verifAccessSession()){
            $animaux = $this->animauxManager->getAnimaux();
            require_once "views/animauxVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function suppression(){
        if(Securite::verifAccessSession()){
            $idAnimal = (int)Securite::secureHTML($_POST['animal_id']);
            
            //attention a l'ordre, d'abord supprimer dans la table intermediaire!!!
            $this->animauxManager->deleteDBAnimalContinent($idAnimal);
            $this->animauxManager->deleteDBAnimal($idAnimal);
            $_SESSION['alert'] = [
                "message" => "L'animal est supprimé",
                "type" => "alert-success"
            ];
           
            header('Location: '.URL.'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function creation(){
        if(Securite::verifAccessSession()){
            $famillesManager = new FamillesManager();
            $familles = $famillesManager->getFamilles();
            $continentsManager = new ContinentsManager();
            $continents = $continentsManager->getContinents();
            require_once "views/animalCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }
}