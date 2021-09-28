<?php
require_once "./controllers/back/Securite.class.php";
require_once "./models/back/animaux.manager.php";

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
}