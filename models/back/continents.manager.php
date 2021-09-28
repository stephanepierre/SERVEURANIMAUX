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

    public function addContinentAnimal($idAnimal,$idContinent){
        $req ="Insert into animal_continent (animal_id,continent_id)
        values (:idAnimal,:idContinent)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
        $stmt->bindValue(":idContinent",$idContinent,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteDBContinentAnimal($idAnimal,$idContinent){
        $req = "Delete from animal_continent 
        where animal_id = :idAnimal and continent_id = :idContinent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
        $stmt->bindValue(":idContinent",$idContinent,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function verificationExisteAnimalContinent($idAnimal,$idContinent){
        $req = "Select count(*) as 'nb'
        from animal_continent ac
        where ac.animal_id = :idAnimal and ac.continent_id = :idContinent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
        $stmt->bindValue(":idContinent",$idContinent,PDO::PARAM_INT);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if($resultat['nb'] >=1) return true;
        return false;
    }
}