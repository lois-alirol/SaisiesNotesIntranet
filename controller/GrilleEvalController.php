<?php
require_once __DIR__ . '/../model/GrilleEval.php';

class GrilleEvalController {
    private $grilleEvalModel;
    
    public function __construct(){
        global $pdo;
        $this->grilleEvalModel = new GrilleEval($pdo);
    }

    public function show() {
        $idEval = $_GET["eval"] ?? null;
        $typeEnseignant = $_GET["typeEnseignant"] ?? null;
        $cours = $_GET["cours"] ?? null;

        $critereseval = $this->grilleEvalModel->getTableauGrilleEval($idEval, $typeEnseignant, $cours);
        $modeleeval = $this->grilleEvalModel->getModeleGrilleEval($idEval, $cours);
        $feedback = $this->grilleEvalModel->getFeedback($idEval, $typeEnseignant, $cours);
        $etudiant = $this->grilleEvalModel->getEtudiantFromEval($idEval, $cours);

        include 'view/grilleEval/show.php';
    }

    public function validerEvaluation($idEval) { 
        //$this->grilleEvalModel->updateNote(1);
        $this->grilleEvalModel->modifierStatut($idEval); 
    }   
}