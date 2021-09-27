<?php

abstract class Model {
    private static $pdo;

    //liaison securisée avec la BD
    private static function setBdd(){           
        self::$pdo = new PDO("mysql:host=localhost;dbname=dbanimaux;charset=utf8","root","");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    protected function getBdd(){
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }

    //convertie les infos au format JSON
    public static function sendJSON($info){
        header("Access-Control-Allow-Origin: *");   //permet de mettre à dispo uniquement par mon site, sinon mettre * apres origin:
        header("Content-Type: application/json");   //permet de définir que le contenu sera au format JSON pour eviter les erreur de front
        echo json_encode($info);
    }
}