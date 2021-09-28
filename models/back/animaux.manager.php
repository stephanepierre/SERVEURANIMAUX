<?php

require_once "models/Model.php";

class AnimauxManager extends Model{
    public function getAnimaux(){
        $req = "SELECT * from animal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $animaux;
    }

    public function deleteDBAnimalContinent($idAnimal){
        $req ="Delete from animal_continent where animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteDBAnimal($idAnimal){
        $req ="Delete from animal where animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    // public function updateFamille($idFamille,$libelle,$description){
    //     $req ="Update famille set famille_libelle = :libelle, famille_description = :description
    //     where famille_id= :idFamille";
    //     $stmt = $this->getBdd()->prepare($req);
    //     $stmt->bindValue(":idFamille",$idFamille,PDO::PARAM_INT);
    //     $stmt->bindValue(":libelle",$libelle,PDO::PARAM_STR);
    //     $stmt->bindValue(":description",$description,PDO::PARAM_STR);
    //     $stmt->execute();
    //     $stmt->closeCursor();
    // }

    public function createAnimal($libelle,$description,$image,$famille){
        $req ="Insert into animal (animal_nom,animal_description,animal_image,famille_id)
            values (:libelle,:description,:image,:famille)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":libelle",$libelle,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":famille",$famille,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }
}