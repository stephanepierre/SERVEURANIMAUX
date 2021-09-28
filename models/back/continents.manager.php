<?php

require_once "models/Model.php";

class ContinentsManager extends Model{
    public function getContinents(){
        $req = "SELECT * from continent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $animaux;
    }
}