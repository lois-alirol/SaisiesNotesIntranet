<?php
require_once 'model\mdl_Eleve_Selctionne.php';
require_once 'vue\view_Eleve_Selectionne.php';

function afficherPageEtudiant($idUser, $idEtudiant) {
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
    //$role     = getRoleUtilisateur($idUser, $idEtudiant);

    afficherEtudiantAvecLiens($infoTutor, $infoSecondary, $infoEnglish, $idUser, $isTutor, $isSecondary, $isEnglishEvaluator);
}