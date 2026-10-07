<?php
require_once __DIR__ . '/../model/GrilleEval.php';

class GrilleEvalController {
    private $grilleEvalModel;
    
    public function __construct(){
        global $pdo;
        $this->grilleEvalModel = new GrilleEval($pdo);
    }

    public function show() {
        $idEval = $_GET["idEval"] ?? null;
        $typeEnseignant = $_GET["typeEnseignant"] ?? null;
        $cours = $_GET["cours"] ?? null;

        //SI ON A POSTE LE FORMULAIRE DE VALIDATION
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $notes = $_POST["notes"]; //IdCritere => VALUER CHOISIE

            //SI ENREGISTRE, SINON VALIDE
            if ($_POST["save"]){
                $this->grilleEvalModel->save($idEval, $cours, $typeEnseignant, $notes, "SAISIE");
            }else {
                $this->grilleEvalModel->save($idEval, $cours, $typeEnseignant, $notes, "VALIDEE");
            }
            
        }

        $critereseval = $this->grilleEvalModel->getTableauGrilleEval($idEval, $typeEnseignant, $cours);

        $modeleeval = $this->grilleEvalModel->getModeleGrilleEval($idEval, $typeEnseignant, $cours);
        $noteMaximale = $modeleeval["noteMaxGrille"];

        $resultatEval = $this->grilleEvalModel->getResultatEval($idEval, $typeEnseignant, $cours);
        
        $feedback = $resultatEval["commentaireJury"];
        $noteFinale = $resultatEval["note"];

        $etudiant = $this->grilleEvalModel->getEtudiantFromEval($idEval, $typeEnseignant, $cours);

        include 'view/grilleEval/show.php';
    }
}

?>