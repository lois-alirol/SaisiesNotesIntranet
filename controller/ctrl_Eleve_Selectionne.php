<?php
require_once __DIR__ . '/model/mdl_Eleve_Selectionne.php';
//require_once __DIR__ . '/view/HistoriqueEleveSelect/view_Eleve_Selectionne.php';

class HistoriqueEleveSelectController {
    public function afficherPage($idUser, $idEtudiant) {
        afficherPageEtudiant($idUser, $idEtudiant);
    }

    public function afficherPageEtudiant($idUser, $idEtudiant) {
        $isTutor = getIsTutor($idUser, $idEtudiant);
        $isSecondary = getIsSecondary($idUser, $idEtudiant);
        $isEnglishEvaluator = getIsEnglishEvaluator($idUser, $idEtudiant);
        $infoTutor = null;
        $infoSecondary = null;
        $infoEnglish = null;
        if($isTutor) {
            $infoTutor = getInfosTutor($idEtudiant, $idUser);
        }
        if($isSecondary) {
            $infoSecondary = getInfosSecondary($idEtudiant, $idUser);
        }
        if($isEnglishEvaluator) {
            $infoEnglish = getInfosEnglishEvaluator($idEtudiant, $idUser);
        }

        //afficherEtudiantAvecLiens($infoTutor, $infoSecondary, $infoEnglish, $idUser, $isTutor, $isSecondary, $isEnglishEvaluator);
        include 'view/HistoriqueEleveSelect/view_Eleve_Selectionne.php';
    }
}
