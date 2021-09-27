<?php
require_once "models/front/API.manager.php";
require_once "models/Model.php";

class APIController
{
    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new APIManager();
    }
 
    public function getAnimaux($idFamille, $idContinent)
    {
        $animaux = $this->apiManager->getDBAnimaux($idFamille, $idContinent);
        $tabResultat = $this->formatDataLignesAnimaux($animaux);
        //partie à décommenter pour debugger et avoir un tableau plus compréhensible des données
        /* echo "<pre>";
        print_r($tabResultat);
        echo "</pre>"; */
        Model::sendJSON($tabResultat);
    }

    public function getAnimal($idAnimal)
    {
        $lignesAnimal = $this->apiManager->getDBAnimal($idAnimal);
        $tabResultat = $this->formatDataLignesAnimaux($lignesAnimal);
        //partie à décommenter pour debugger et avoir un tableau plus compréhensible des données
        /* echo "<pre>";
        print_r($tabResultat);
        echo "</pre>"; */
        Model::sendJSON($tabResultat);
    }

    //transforme les données en tableau imbriqués
    private function formatDataLignesAnimaux($lignes)
    {
        $tab = [];

        foreach ($lignes as $ligne) {
            if (!array_key_exists($ligne['animal_id'], $tab)) {       //vérifie que l'id de l'animal est pas déjà existant
                $tab[$ligne['animal_id']] = [                     //se sert de l'id de l'animal comme n° de tableau (id=1 tableau =1)
                    "id" => $ligne['animal_id'],
                    "nom" => $ligne['animal_nom'],
                    "description" => $ligne['animal_description'],
                    "image" => URL."/public/images/".$ligne['animal_image'],
                    "famille" => [                      //dans le tableau à la ligne famille on crée un deuxieme tableau de famille
                        "idFamille" => $ligne['famille_id'],
                        "libelleFamille" => $ligne['famille_libelle'],
                        "descriptionFamille" => $ligne['famille_description']
                    ]
                ];
            }

            //donne les infos sur le ou les continents dans l'animal recherché
            $tab[$ligne['animal_id']]['continents'][] = [
                "idContinent" => $ligne['continent_id'],
                "libelleContinent" => $ligne['continent_libele']
            ];
        }
        return $tab;
    }

    public function getContinents()
    {
        $continents = $this->apiManager->getDBContinents();
        Model::sendJSON($continents);
    }

    public function getFamilles()
    {
        $familles = $this->apiManager->getDBFamilles();
        Model::sendJSON($familles);
    }

    public function sendMessage()
    {
        header("Access-Control-Allow-Origin: *");   //permet de mettre à dispo uniquement par mon site, sinon mettre * apres origin:
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");   //permet de dire quelles méthodes sont acceptées par le serveur
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");    //vérifie ce qui est reçu dans le header
        
        $obj = json_decode(file_get_contents('php://input'));
        
        // $to = "stephane_pierre@hotmail.fr";
        // $subject = "Message du site MyZoo de : ".$obj->nom;
        // $message = $obj->contenu;
        // $headers = "From : ".$obj->email;
        // mail($to, $subject, $message, $headers);

        $messageRetour = [
            'from' => $obj->email,
            'to' => "stephane_pierre@hotmail.fr"
        ];

        echo json_encode($messageRetour);
    }
}
