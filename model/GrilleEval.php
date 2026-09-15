<?php

//CLASSE CULTURE QUI PERMET DE MANIPULER LA GRILLE D'EVAL. AVEC DES METHODES QUI UTILISENT DES REQUETES SQL
class GrilleEval {
    private $pdo;

    //CONSTRUCTEUR QUI INITIALISE LA DONNEE MEMBRE PDO AU PDO DE LA BDD
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    //METHODE QUI PERMET D'OBTENIR UN ARRAY DES CRITERES D'EVALUATION
    public function getTableauGrilleEval($idGrille, $idEval, $typeEnseignant, $cours){
        $req = "";   
        switch ($cours){
            case "PORTFOLIO":
                $req = "SELECT evalportfolio.IdEvalPortfolio,  critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotesportfolio.noteCritere
                FROM critereseval
                JOIN lescriteresnotesportfolio ON lescriteresnotesportfolio.idCritere = critereseval.idCritere
                JOIN evalportfolio ON evalportfolio.IdEvalPortfolio = lescriteresnotesportfolio.IdEvalPortfolio
                JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalportfolio.IdModeleEval
                WHERE modelesgrilleeval.natureGrille = 'PORTFOLIO'
                AND evalportfolio.IdEvalPortfolio = :idEval";
                break;
            case "RAPPORT":
                $req = "SELECT evalrapport.IdEvalRapport,  critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotesrapport.noteCritere
                FROM critereseval
                JOIN lescriteresnotesrapport ON lescriteresnotesrapport.idCritere = critereseval.idCritere
                JOIN evalrapport ON evalrapport.IdEvalrapport = lescriteresnotesrapport.IdEvalrapport
                JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalrapport.IdModeleEval
                WHERE modelesgrilleeval.natureGrille = 'RAPPORT'
                AND evalrapport.IdEvalrapport = :idEval";
                break;
            case "ANGLAIS":
                $req = "SELECT evalanglais.IdEvalanglais,  critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotesanglais.noteCritere
                FROM critereseval
                JOIN lescriteresnotesanglais ON lescriteresnotesanglais.idCritere = critereseval.idCritere
                JOIN evalanglais ON evalanglais.IdEvalanglais = lescriteresnotesanglais.IdEvalanglais
                JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalanglais.IdModeleEval
                WHERE modelesgrilleeval.natureGrille = 'ANGLAIS'
                AND evalanglais.IdEvalanglais = :idEval";
                break;
            case "SOUTENANCES":
                switch ($typeEnseignant){
                    case "ENSSECOND":
                        $req = "SELECT evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond,  critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotessoutenanceenssecond.noteCritere
                        FROM critereseval
                        JOIN lescriteresnotessoutenanceenssecond ON lescriteresnotessoutenanceenssecond.idCritere = critereseval.idCritere
                        JOIN evalsoutenanceenssecond ON evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond = lescriteresnotessoutenanceenssecond.IdEvalSoutenanceEnsSecond
                        JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalsoutenanceenssecond.IdModeleEval
                        WHERE modelesgrilleeval.natureGrille = 'SOUTENANCE'
                        AND evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond = :idEval";
                        break;
                    case "ENSTUTEUR":
                        $req = "SELECT evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut,  critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotessoutenanceenstut.noteCritere
                        FROM critereseval
                        JOIN lescriteresnotessoutenanceenstut ON lescriteresnotessoutenanceenstut.idCritere = critereseval.idCritere
                        JOIN evalsoutenanceenstuteur ON evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut = lescriteresnotessoutenanceenstut.IdEvalSoutenanceEnsTut
                        JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalsoutenanceenstuteur.IdModeleEval
                        WHERE modelesgrilleeval.natureGrille = 'SOUTENANCE'
                        AND evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut = :idEval";
                        break;
                }
            break;
        }

        $stmt = $this->pdo->prepare($req);
        $stmt->bindParam(":idEval", $idEval);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //METHODE QUI PERMET D'OBTENIR LES INFORMATIONS SUR LA GRILLE D'EVALUATION EN QUESTION
    public function getModeleGrilleEval($idGrille){
        $stmt = $this->pdo->prepare("SELECT * FROM modelesgrilleeval WHERE IdModeleEval = :idGrille");
        $stmt->bindParam(":idGrille", $idGrille);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function getFeedback($idGrille){
         $stmt = $this->pdo->prepare("SELECT commentaireJur")
    }
}

?>  
