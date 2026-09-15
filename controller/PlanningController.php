<?php

require_once 'model/PlanningM.php';

class PlanningController {
    
private $PlanningModel;

    public function __construct() {
        global $pdo;
        $this->PlanningModel = new planning($pdo);
    }
    //Controller du planning
    public function Planning() {
        $idEnseignant = $_GET['enseignant'];
        $plannings = $this->PlanningModel->getPlanningEnseignants($idEnseignant);
        $planningsAnglais = $this->PlanningModel->getPlanningEnseignantsAnglais($idEnseignant);

        include 'view/layout/header.php';
        include 'view/planning/PlanningView.php';
    }

}