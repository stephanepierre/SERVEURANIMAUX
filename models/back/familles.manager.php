<?php

require_once "models/Model.php";

class FamillesManager extends Model{
    public function getFamilles(){
        $req = "SELECT * from famille";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $familles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $familles;
    }

    public function deleteDBfamille($idFamille){
        $req ="Delete from famille where famille_id= :idFamille";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamille",$idFamille,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function compterAnimaux($idFamille){
        $req ="Select count(*) as 'nb'
        from famille f inner join animal a on a.famille_id = f.famille_id
        where f.famille_id = :idFamille";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamille",$idFamille,PDO::PARAM_INT);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat['nb'];
    }

    public function updateFamille($idFamille,$libelle,$description){
        $req ="Update famille set famille_libelle = :libelle, famille_description = :description
        where famille_id= :idFamille";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamille",$idFamille,PDO::PARAM_INT);
        $stmt->bindValue(":libelle",$libelle,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }
}