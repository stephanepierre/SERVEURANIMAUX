<?php
require_once "models/Model.php";

class APIManager extends Model
{
    public function getDBAnimaux($idFamille, $idContinent)      //liaison securisée avec la BD
    {          
        $whereClause = "";
        //on vérifie qu'on recoit pas -1 dans $idFamille et $idContinent qui se trouve dans index.php
        if($idFamille !== -1 || $idContinent !== -1) $whereClause .= "WHERE ";   // si on recoit pas, on utilise $whereClause qui envoir WHERE en mySQL
        if($idFamille !== -1) $whereClause .= "f.famille_id = :idFamille";
        if ($idFamille !== -1 && $idContinent !== -1) $whereClause .= " AND ";
        if($idContinent !== -1) $whereClause .= "a.animal_id IN (
            select animal_id from animal_continent where continent_id = :idContinent
        )";
        $req = "SELECT a.animal_id, animal_nom, animal_description, animal_image, f.famille_id, famille_libelle, famille_description, c.continent_id, continent_libele
        from animal a inner join famille f on f.famille_id = a.famille_id
        left join animal_continent ac on ac.animal_id = a.animal_id
        left join continent c on c.continent_id = ac.continent_id ".$whereClause;
        $stmt= $this->getBdd()->prepare($req);
        if($idFamille !== -1) $stmt->bindValue(":idFamille", $idFamille,PDO::PARAM_INT);
        if($idContinent !== -1) $stmt->bindValue(":idContinent", $idContinent,PDO::PARAM_INT);
        $stmt->execute();
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $animaux;
    }

    public function getDBAnimal($idAnimal)      //liaison securisée avec la BD
    {          
        $req = "SELECT * 
        from animal a inner join famille f on f.famille_id = a.famille_id
        inner join animal_continent ac on ac.animal_id = a.animal_id
        inner join continent c on c.continent_id = ac.continent_id
        WHERE a.animal_id = :idAnimal
        ";
        $stmt= $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $lignesAnimal = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesAnimal;
    }

    public function getDBFamilles()      //liaison securisée avec la BD
    {          
        $req = "SELECT * 
        from famille
        ";
        $stmt= $this->getBdd()->prepare($req);
        $stmt->execute();
        $familles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $familles;
    }

    public function getDBContinents()      //liaison securisée avec la BD
    {          
        $req = "SELECT * 
        from continent
        ";
        $stmt= $this->getBdd()->prepare($req);
        $stmt->execute();
        $continents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $continents;
    }

}
