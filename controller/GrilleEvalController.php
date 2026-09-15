<?php
require_once __DIR__ . '/../model/GrilleEval.php';

class GrilleEvalController {
    private $grilleEvalModel;
    
    public function __construct(){
        global $pdo;
        $this->grilleEvalModel = new GrilleEval($pdo);
    }

    public function show($idGrille, $idEval, $typeEnseignant, $cours) {
        $critereseval = $this->grilleEvalModel->getTableauGrilleEval($idEval, $typeEnseignant, $cours);
        $modeleeval = $this->grilleEvalModel->getModeleGrilleEval($idGrille);
        $feedback = $this->grilleEvalModel->getFeedback($idEval, $typeEnseignant, $cours);

        include 'view/grilleEval/show.php';
    }
}

?>