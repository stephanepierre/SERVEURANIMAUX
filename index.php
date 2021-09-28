<?php

//sert à definir le systeme de routage avec http(s)://le nom du site/la page/la page...

session_start();

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http").
"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/front/API.controller.php";
require_once "controllers/back/Admin.controller.php";
require_once "controllers/back/familles.controller.php";
require_once "controllers/back/animaux.controller.php";

$apiController = new APIController();
$adminController = new AdminController();
$famillesController = new FamillesController();
$animauxController = new AnimauxController();


try {
    if (empty($_GET['page'])) {             //si derriere localhost il n'y a rien, message erreur
        throw new Exception("La page n'existe pas");
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));       //ajoute le nom des 2 pages suivante derriere localhost sinon erreur
        if (empty($url[0]) || empty($url[1])) {
            throw new Exception("La page n'existe pas");
        }
        switch ($url[0]) {
            case "front":                       //http://localhost/front/...
                switch ($url[1]) {
                    case "animaux": 
                        //si $url n'est pas présent on envoie -1 qui sera géré dans API manager comme une erreur............................
                        if(!isset($url[2]) || !isset($url[3])){
                            $apiController -> getAnimaux(-1,-1);
                        } else {
                            $apiController -> getAnimaux((int)$url[2], (int)$url[3]);
                        };     //http://localhost/front/animaux
                    break;
                    case "animal": 
                        if(empty($url[2])) throw new Exception("id animal manquant");       //message d'erreur si il manque l'id de animal
                        $apiController -> getAnimal($url[2]);       //http://localhost/front/animal/l'id de l'animal
                    break;
                    case "continents": $apiController -> getContinents();        //http://localhost/front/continents
                    break;
                    case "familles": $apiController -> getfamilles();        //http://localhost/front/familles
                    break;
                    case "sendMessage": $apiController -> sendMessage();        //permet d'envoyer le formulaire de contact 
                    break;
                    default: throw new Exception("La page n'existe pas");
                }
            break;
            case "back": 
                switch($url[1]){
                    case "login" : $adminController -> getPageLogin();         //http://localhost/back/...
                    break;
                    case "connexion" : $adminController -> connexion();
                    break;
                    case "admin" : $adminController -> getAccueilAdmin();
                    break;
                    case "deconnexion" : $adminController -> deconnexion();
                    break;
                    case "familles" :
                        switch($url[2]){
                            case "visualisation" : $famillesController->visualisation();
                            break;
                            case "validationSuppression" : $famillesController-> suppression();    //supprime les données dans la BD
                            break;
                            case "validationModification" : $famillesController->modification();
                            break;
                            case "creation" : $famillesController->creationTemplate();
                            break;
                            case "creationValidation" : $famillesController->creationValidation();
                            break;
                            default : throw new Exception ("La page n'existe pas");
                        }
                    break;
                    case "animaux" :
                        switch($url[2]){
                            case "visualisation" : $animauxController->visualisation();
                            break;
                            case "validationSuppression" : $animauxController->suppression();
                            break;
                            default : throw new Exception ("La page n'existe pas");
                        }
                    break;
                    default : throw new Exception ("La page n'existe pas");
                }
            break;
            default: throw new Exception("La page n'existe pas");
        }
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    echo $msg;
    echo "<a href='".URL."back/login'>login</a>";
}
