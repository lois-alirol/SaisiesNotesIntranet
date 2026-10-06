<?php

//CLASSE CULTURE QUI PERMET DE MANIPULER LA GRILLE D"EVAL. AVEC DES METHODES QUI UTILISENT DES REQUETES SQL
class GrilleEval {
    private $pdo;

    //CONSTRUCTEUR QUI INITIALISE LA DONNEE MEMBRE PDO AU PDO DE LA BDD
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //RECUPERE UN ARRAY AVEC ID, NOM, PRENOM DE L"ETUDIANT A PARTIR DE l"ID EVAL ET DU COURS
    public function getEtudiantFromEval($idEval, $typeEnseignant, $cours) {
        $req = "";
        switch ($cours) {
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
                switch ($typeEnseignant) {
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

    //METHODE QUI PERMET D"OBTENIR UN ARRAY DES CRITERES D"EVALUATION
    public function getTableauGrilleEval($idEval, $typeEnseignant, $cours) {
        $req = "";

        switch ($cours) {
            case "PORTFOLIO":
                $req = "SELECT evalportfolio.IdEvalPortfolio, critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotesportfolio.noteCritere, modelecontenircriteres.ValeurMaxCritereEVal
                        FROM evalportfolio
                        JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalportfolio.IdModeleEval
                        JOIN modelecontenircriteres ON modelecontenircriteres.IdModeleEval = modelesgrilleeval.IdModeleEval
                        JOIN critereseval ON critereseval.IdCritere = modelecontenircriteres.IdCritere
                        LEFT JOIN lescriteresnotesportfolio ON lescriteresnotesportfolio.idCritere = critereseval.idCritere 
                        AND lescriteresnotesportfolio.IdEvalPortfolio = evalportfolio.IdEvalPortfolio
                        WHERE modelesgrilleeval.natureGrille = 'PORTFOLIO'
                        AND evalportfolio.IdEvalPortfolio = :idEval";
                break;

            case "RAPPORT":
                $req = "SELECT evalrapport.IdEvalRapport, critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotesrapport.noteCritere, modelecontenircriteres.ValeurMaxCritereEVal
                        FROM evalrapport
                        JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalrapport.IdModeleEval
                        JOIN modelecontenircriteres ON modelecontenircriteres.IdModeleEval = modelesgrilleeval.IdModeleEval
                        JOIN critereseval ON critereseval.IdCritere = modelecontenircriteres.IdCritere
                        LEFT JOIN lescriteresnotesrapport ON lescriteresnotesrapport.idCritere = critereseval.idCritere 
                        AND lescriteresnotesrapport.IdEvalRapport = evalrapport.IdEvalRapport
                        WHERE modelesgrilleeval.natureGrille = 'RAPPORT'
                        AND evalrapport.IdEvalRapport = :idEval";
                break;

            case "ANGLAIS":
                $req = "SELECT evalanglais.IdEvalAnglais, critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotesanglais.noteCritere, modelecontenircriteres.ValeurMaxCritereEVal
                        FROM evalanglais
                        JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalanglais.IdModeleEval
                        JOIN modelecontenircriteres ON modelecontenircriteres.IdModeleEval = modelesgrilleeval.IdModeleEval
                        JOIN critereseval ON critereseval.IdCritere = modelecontenircriteres.IdCritere
                        LEFT JOIN lescriteresnotesanglais ON lescriteresnotesanglais.idCritere = critereseval.idCritere 
                        AND lescriteresnotesanglais.IdEvalAnglais = evalanglais.IdEvalAnglais
                        WHERE modelesgrilleeval.natureGrille = 'ANGLAIS'
                        AND evalanglais.IdEvalAnglais = :idEval";
                break;

            case "SOUTENANCE":
                switch ($typeEnseignant) {
                    case "ENSSECOND":
                        $req = "SELECT evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond, critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotessoutenanceenssecond.noteCritere, modelecontenircriteres.ValeurMaxCritereEVal
                                FROM evalsoutenanceenssecond
                                JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalsoutenanceenssecond.IdModeleEval
                                JOIN modelecontenircriteres ON modelecontenircriteres.IdModeleEval = modelesgrilleeval.IdModeleEval
                                JOIN critereseval ON critereseval.IdCritere = modelecontenircriteres.IdCritere
                                LEFT JOIN lescriteresnotessoutenanceenssecond ON lescriteresnotessoutenanceenssecond.idCritere = critereseval.idCritere 
                                AND lescriteresnotessoutenanceenssecond.IdEvalSoutenanceEnsSecond = evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond
                                WHERE modelesgrilleeval.natureGrille = 'SOUTENANCE'
                                AND evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond = :idEval";
                        break;

                    case "ENSTUTEUR":
                        $req = "SELECT evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut, critereseval.IdCritere, critereseval.descCourte, critereseval.descLongue, lescriteresnotessoutenanceenstut.noteCritere, modelecontenircriteres.ValeurMaxCritereEVal
                                FROM evalsoutenanceenstuteur
                                JOIN modelesgrilleeval ON modelesgrilleeval.IdModeleEval = evalsoutenanceenstuteur.IdModeleEval
                                JOIN modelecontenircriteres ON modelecontenircriteres.IdModeleEval = modelesgrilleeval.IdModeleEval
                                JOIN critereseval ON critereseval.IdCritere = modelecontenircriteres.IdCritere
                                LEFT JOIN lescriteresnotessoutenanceenstut ON lescriteresnotessoutenanceenstut.idCritere = critereseval.idCritere 
                                AND lescriteresnotessoutenanceenstut.IdEvalSoutenanceEnsTut = evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut
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

    //METHODE QUI PERMET D"OBTENIR LES INFORMATIONS SUR LA GRILLE D"EVALUATION EN QUESTION
    public function getModeleGrilleEval($idEval, $cours) {
        $req = "";
        switch ($cours) {
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
                switch ($typeEnseignant) {
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

    public function getResultatEval($idEval, $typeEnseignant, $cours) {
        $req = "";
        switch ($cours) {
            case "PORTFOLIO":
                $req = "SELECT * FROM evalportfolio WHERE evalportfolio.IdEvalPortfolio = :idEval";
                break;
            case "RAPPORT":
                $req = "SELECT * FROM evalrapport WHERE evalrapport.IdEvalRapport = :idEval";
                break;
            case "ANGLAIS":
                $req = "SELECT * FROM evalanglais WHERE evalanglais.IdEvalAnglais = :idEval";
                break;
            case "SOUTENANCE":
                switch ($typeEnseignant) {
                    case "ENSSECOND":
                        $req = "SELECT * AS commentaireJury FROM evalsoutenanceenssecond WHERE evalsoutenanceenssecond.IdEvalSoutenanceEnsSecond = :idEval";
                        break;
                    case "ENSTUTEUR":
                        $req = "SELECT * AS commentaireJury FROM evalsoutenanceenstuteur WHERE evalsoutenanceenstuteur.IdEvalSoutenanceEnsTut = :idEval";
                        break;
                }
                break;
        }

        $stmt = $this->pdo->prepare($req);
        $stmt->bindParam(":idEval", $idEval);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    //SUPPR :  il faut : changer le statut en validé OU enregistré selon la validation ET update chaque notes. 
    public function save($idEval, $cours, $typeEnseignant, $notes, $statut) {
        $tableNotes = "";
        $tableEval = "";
        $cleEval = "";
        $colNote = "note";

        switch ($cours) {
            case "PORTFOLIO":
                $tableNotes = "lescriteresnotesportfolio";
                $tableEval = "evalportfolio";
                $cleEval = "IdEvalPortfolio";
                break;
            case "RAPPORT":
                $tableNotes = "lescriteresnotesrapport";
                $tableEval = "evalrapport";
                $cleEval = "IdEvalRapport";
                break;
            case "ANGLAIS":
                $tableNotes = "lescriteresnotesanglais";
                $tableEval = "evalanglais";
                $cleEval = "IdEvalAnglais";
                break;
            case "SOUTENANCE":
                if ($typeEnseignant === "ENSSECOND") {
                    $tableNotes = "lescriteresnotessoutenanceenssecond";
                    $tableEval  = "evalsoutenanceenssecond";
                    $cleEval = "IdEvalSoutenanceEnsSecond";
                    $colNote = "noteEnsSecond";
                } else {
                    $tableNotes = "lescriteresnotessoutenanceenstut";
                    $tableEval = "evalsoutenanceenstuteur";
                    $cleEval = "IdEvalSoutenanceEnsTut";
                    $colNote = "noteEnsTut";
                }
                break;
        }
        
        //REQUETE POUR SAUVEGARDER CHAQUE NOTE DE CRITERE        
        $reqCritere = "INSERT INTO $tableNotes ($cleEval, idCritere, noteCritere) VALUES (:idEval, :idCritere, :noteCritere) ON DUPLICATE KEY UPDATE noteCritere = :noteCritere";
        
        $stmtCritere = $this->pdo->prepare($reqCritere);
        $stmtCritere->bindParam(":idEval", $idEval);
        $stmtCritere->bindParam(":idCritere", $currentIdCritere);
        $stmtCritere->bindParam(":noteCritere", $currentNote);

        $noteTotale = 0;

        foreach ($notes as $idCritere => $n){
            $currentIdCritere = $idCritere;
            $currentNote = $n;
            $noteTotale += $currentNote;

            $stmtCritere->execute();
        }
        
        //REQUETE POUR METTRE A JOUE LA NOTE GLOBALE & LE STATUT
        $reqEval = "UPDATE $tableEval SET $colNote = :noteTotale, Statut = :statut WHERE $cleEval = :idEval";
        
        $stmtEval = $this->pdo->prepare($reqEval);
        $stmtEval->bindParam(":noteTotale", $noteTotale);
        $stmtEval->bindParam(":statut", $statut);
        $stmtEval->bindParam(":idEval", $idEval);

        return $stmtEval->execute();
    }

    // public function updateNotes($data, $idEvalAnglais) {
    //     $stmt = $this->pdo->prepare("UPDATE evalanglais SET Statut = 'VALIDEE' WHERE IdEvalAnglais = :idEvalAnglais");
    //     $stmt->bindParam(":idEvalAnglais", $idEvalAnglais);
    //     $stmt->execute();
    // }

    // public function modifierStatut(int $idEval){
    //     $stmt = $this->pdo->prepare("UPDATE evalanglais SET Statut = 'VALIDEE' WHERE IdEvalAnglais = :idEval");
    //     $stmt->bindParam(":idEval", $idEval, PDO::PARAM_INT);
    //     $stmt->execute();
    // }
}

?>