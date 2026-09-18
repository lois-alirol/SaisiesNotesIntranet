<?php

//CLASSE CULTURE QUI PERMET DE MANIPULER LA GRILLE D'EVAL. AVEC DES METHODES QUI UTILISENT DES REQUETES SQL
class GrilleEval {
    private $pdo;

    //CONSTRUCTEUR QUI INITIALISE LA DONNEE MEMBRE PDO AU PDO DE LA BDD
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    //RECUPERE UN ARRAY AVEC ID, NOM, PRENOM DE L'ETUDIANT A PARTIR DE l'ID EVAL ET DU COURS
    public function getEtudiantFromEval($idEval, $cours){
        $req = "";
        switch ($cours){
            case "PORTFOLIO":
                $req = "SELECT etudiantsbut2ou3.nom, etudiantsbut2ou3.prenom, etudiantsbut2ou3.IdEtudiant
                        FROM etudiantsbut2ou3
                        JOIN evalportfolio ON evalportfolio.IdEtudiant = etudiantsbut2ou3.IdEtudiant
                        WHERE evalportfolio.IdEvalPortfolio = :idEval";
                break;
            case "RAPPORT":
                $req = "SELECT etudiantsbut2ou3.nom, etudiantsbut2ou3.prenom, etudiantsbut2ou3.IdEtudiant
                        FROM etudiantsbut2ou3
                        JOIN evalrapport ON evalrapport.IdEtudiant = etudiantsbut2ou3.IdEtudiant
                        WHERE evalrapport.IdEvalRapport = :idEval";
                break;
            case "ANGLAIS":
                $req = "SELECT etudiantsbut2ou3.nom, etudiantsbut2ou3.prenom, etudiantsbut2ou3.IdEtudiant
                        FROM etudiantsbut2ou3
                        JOIN evalanglais ON evalanglais.IdEtudiant = etudiantsbut2ou3.IdEtudiant
                        WHERE evalanglais.IdEvalAnglais = :idEval";
                break;
            case "SOUTENANCE":
                switch ($typeEnseignant){
                    case "ENSSECOND":
                        $req = "SELECT etudiantsbut2ou3.nom, etudiantsbut2ou3.prenom, etudiantsbut2ou3.IdEtudiant
                                FROM etudiantsbut2ou3
                                JOIN evalsoutenanceenssecond ON evalsoutenanceenssecond.IdEnseignant = etudiantsbut2ou3.IdEtudiant
                                WHERE evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond = :idEval";
                        break;
                    case "ENSTUTEUR":
                        $req = "SELECT etudiantsbut2ou3.nom, etudiantsbut2ou3.prenom, etudiantsbut2ou3.IdEtudiant
                                FROM etudiantsbut2ou3
                                JOIN evalsoutenanceenstuteur ON evalsoutenanceenstuteur.IdEnseignant = etudiantsbut2ou3.IdEtudiant
                                WHERE evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut = :idEval";
                        break;
                }
            break;
        }

        $stmt = $this->pdo->prepare($req);
        $stmt->bindParam(":idEval", $idEval);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    //METHODE QUI PERMET D'OBTENIR UN ARRAY DES CRITERES D'EVALUATION
    public function getTableauGrilleEval($idEval, $typeEnseignant, $cours){
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
            case "SOUTENANCE":
                switch ($typeEnseignant){
                    case "ENSSECOND":
                        $req = "SELECT modelesgrilleeval.IdModeleEval, modelesgrilleeval.natureGrille, modelesgrilleeval.noteMaxGrille, modelesgrilleeval.nomModuleGrilleEvaluation, modelesgrilleeval.anneeDebut  
                        FROM evalsoutenanceenssecond
                        JOIN modelesgrilleeval
                        ON modelesgrilleeval.IdModeleEval = evalsoutenanceenssecond.IdModeleEval
                        WHERE evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond = :idEval";
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
    public function getModeleGrilleEval($idEval, $cours){
        $req = "";
        switch ($cours){
            case "PORTFOLIO":
                $req = "SELECT modelesgrilleeval.IdModeleEval, modelesgrilleeval.natureGrille, modelesgrilleeval.noteMaxGrille, modelesgrilleeval.nomModuleGrilleEvaluation, modelesgrilleeval.anneeDebut  
                        FROM evalportfolio
                        JOIN modelesgrilleeval
                        ON modelesgrilleeval.IdModeleEval = evalportfolio.IdModeleEval
                        WHERE evalportfolio.IdEvalPortfolio = :idEval";
                break;
            case "RAPPORT":
                $req = "SELECT modelesgrilleeval.IdModeleEval, modelesgrilleeval.natureGrille, modelesgrilleeval.noteMaxGrille, modelesgrilleeval.nomModuleGrilleEvaluation, modelesgrilleeval.anneeDebut  
                        FROM evalrapport
                        JOIN modelesgrilleeval
                        ON modelesgrilleeval.IdModeleEval = evalrapport.IdModeleEval
                        WHERE evalrapport.IdEvalRapport = :idEval";
                break;
            case "ANGLAIS":
                $req = "SELECT modelesgrilleeval.IdModeleEval, modelesgrilleeval.natureGrille, modelesgrilleeval.noteMaxGrille, modelesgrilleeval.nomModuleGrilleEvaluation, modelesgrilleeval.anneeDebut  
                        FROM evalanglais
                        JOIN modelesgrilleeval
                        ON modelesgrilleeval.IdModeleEval = evalanglais.IdModeleEval
                        WHERE evalanglais.IdEvalanglais = :idEval";
                break;
            case "SOUTENANCE":
                switch ($typeEnseignant){
                    case "ENSSECOND":
                        $req = "SELECT modelesgrilleeval.IdModeleEval, modelesgrilleeval.natureGrille, modelesgrilleeval.noteMaxGrille, modelesgrilleeval.nomModuleGrilleEvaluation, modelesgrilleeval.anneeDebut  
                        FROM evalsoutenanceenstuteur
                        JOIN modelesgrilleeval
                        ON modelesgrilleeval.IdModeleEval = evalsoutenanceenstuteur.IdModeleEval
                        WHERE evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut = :idEval";
                        break;
                    case "ENSTUTEUR":
                        $req = "SELECT modelesgrilleeval.IdModeleEval, modelesgrilleeval.natureGrille, modelesgrilleeval.noteMaxGrille, modelesgrilleeval.nomModuleGrilleEvaluation, modelesgrilleeval.anneeDebut  
                        FROM evalsoutenanceenstuteur
                        JOIN modelesgrilleeval
                        ON modelesgrilleeval.IdModeleEval = evalsoutenanceenstuteur.IdModeleEval
                        WHERE evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut = :idEval";
                        break;
                }
            break;
        }

        $stmt = $this->pdo->prepare($req);
        $stmt->bindParam(":idEval", $idEval);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    public function getFeedback($idEval, $typeEnseignant, $cours){
        $req = "";   
        switch ($cours){
            case "PORTFOLIO":
                $req = "SELECT evalportfolio.commentaireJury FROM evalportfolio WHERE evalportfolio.IdEvalPortfolio = :idEval";
                break;
            case "RAPPORT":
                $req = "SELECT evalrapport.commentaireJury FROM evalrapport WHERE evalrapport.IdEvalRapport = :idEval";
                break;
            case "ANGLAIS":
                $req = "SELECT evalanglais.commentaireJury FROM evalanglais WHERE evalanglais.IdEvalAnglais = :idEval";
                break;
            case "SOUTENANCE":
                switch ($typeEnseignant){
                    case "ENSSECOND":
                        $req = "SELECT evalsoutenanceenssecond.commentaireEnsSecond AS commentaireJury FROM evalsoutenanceenssecond WHERE evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond = :idEval";
                        break;
                    case "ENSTUTEUR":
                        $req = "SELECT evalsoutenanceenstuteur.commentaireEnsTut AS commentaireJury FROM evalsoutenanceenstuteur WHERE evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut = :idEval";
                        break;
                }
                break;
        }

        $stmt = $this->pdo->prepare($req);
        $stmt->bindParam(":idEval", $idEval);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

        

    public function updateNotes($data, $idEvalAnglais) {
        
        // Assuming $data contains the updated notes for each criterion
            $stmt = $this->pdo->prepare(
            "UPDATE evalanglais 
            SET Statut = 'VALIDEE' 
            WHERE IdEvalAnglais = :idEvalAnglais");
            $stmt->bindParam(":idEvalAnglais", $idEvalAnglais);
            $stmt->execute();
    }
    public function modifierStatut(int $idEval) {
         $stmt = $this->pdo->prepare("UPDATE evalanglais SET Statut = 'VALIDEE' WHERE IdEvalAnglais = :idEval"); 
         $stmt->bindParam(":idEval", $idEval, PDO::PARAM_INT);
         $stmt->execute(); 
    }
}

?>  
