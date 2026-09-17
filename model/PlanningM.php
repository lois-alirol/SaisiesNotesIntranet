<?php

class planning
{
    private PDO $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    //Requete du planning
    public function getPlanningEnseignants($idEnseignant)
    { 
    $sql = "SELECT
    DATE(es.date_h) AS date,
    TIME(es.date_h) AS heure,
    es.IdSalle AS salle,
    CONCAT(e1.prenom, ' ', e1.nom) AS professeur_1,
    CONCAT(e2.prenom, ' ', e2.nom) AS professeur_2,
    et.IdEtudiant AS idEtudiant,
    CONCAT(et.prenom, ' ', et.nom) AS eleve,
	ast.but3sinon2,
	ast.alternanceBUT3,
    ent.nom AS entreprise,
    es.date_h
    FROM EvalStage es
    JOIN Enseignants e1
    ON es.IdEnseignantTuteur = e1.IdEnseignant
    LEFT JOIN Enseignants e2
    ON es.IdEnseignantSecond = e2.IdEnseignant
    JOIN EtudiantsBUT2ou3 et
    ON es.IdEtudiant = et.IdEtudiant
    LEFT JOIN AnneeStage ast
    ON ast.IdEtudiant = es.IdEtudiant
    AND ast.anneeDebut = es.anneeDebut
    LEFT JOIN Entreprises ent
    ON ast.IdEntreprise = ent.IdEntreprise
    WHERE es.anneeDebut = YEAR(CURDATE()) - 1
    AND (e1.IdEnseignant = :idEns OR e2.IdEnseignant = :idEns)
    ORDER BY es.date_h, es.IdSalle;
    ";

        try {
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(":idEns", $idEnseignant);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    //Requete du planning Anglais
    public function getPlanningEnseignantsAnglais($idEnseignant) 
    {
    $sql = "SELECT
    DATE(ea.dateS) AS date,
    TIME(ea.dateS) AS heure,
    ea.IdSalle AS salle,
    CONCAT(e1.prenom, ' ', e1.nom) AS professeur_1,
    CONCAT(et.prenom, ' ', et.nom) AS eleve,
    ast.but3sinon2,
    ast.alternanceBUT3,
    es.dateS,
    et.IdEtudiant AS idEtudiant
    FROM evalanglais ea
    JOIN Enseignants e1
    ON ea.IdEnseignant = e1.IdEnseignant
    JOIN EtudiantsBUT2ou3 et
    ON ea.IdEtudiant = et.IdEtudiant
    LEFT JOIN AnneeStage ast
    ON ast.IdEtudiant = ea.IdEtudiant
    AND ast.anneeDebut = ea.anneeDebut
    WHERE ea.anneeDebut = YEAR(CURDATE()) - 1
    AND (e1.IdEnseignant = :idEns)
    ORDER BY ea.dateS, ea.IdSalle;
    ";
        try 
        {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":idEns", $idEnseignant);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        catch (PDOException $e) 
        {
            return false;
        }
    }

    public function getSalles(){
            $sql = "SELECT idSalle FROM `salles`";

        try 
        {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        catch (PDOException $e) 
        {
            return false;
        }
    }
}
