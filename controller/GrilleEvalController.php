<?php
require_once __DIR__ . '/../model/GrilleEval.php';

class GrilleEvalController {
    private $grilleEvalModel;
    
    public function __construct(){
        global $pdo;
        $this->grilleEvalModel = new GrilleEval($pdo);
    }

    public function show() {
        $idEval = $_GET["eval"] ?? 1; //SUPPR : METTRE NULL
        $typeEnseignant = $_GET["typeEnseignant"] ?? 4;
        $cours = $_GET["cours"] ?? "ANGLAIS";

        $critereseval = $this->grilleEvalModel->getTableauGrilleEval($idEval, $typeEnseignant, $cours);
        $modeleeval = $this->grilleEvalModel->getModeleGrilleEval($idEval);
        $feedback = $this->grilleEvalModel->getFeedback($idEval, $typeEnseignant, $cours);

        include 'view/grilleEval/show.php';
    }

    public function validerEvaluation($idEval, $notes, $critaireId, $tableName) { 
        $this->grilleEvalModel->modifierStatut($idEval); 

        $this->grilleEvalModel->updateNotes($notes, $idEval, $critaireId, $tableName);
    }   
}