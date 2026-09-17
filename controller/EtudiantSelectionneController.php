<?php

require_once 'model/Etudiant.php';

class EtudiantSelectionneController {
    public function afficherPage() {
        $idEtudiant = $_GET["etudiant"] ?? null;
        $idEnseignant = EnseignantSession::getData()["id"];

        if ($idEtudiant === false || $idEtudiant === null) {
            $error = "Aucun étudiant n’a été sélectionné.";
        }

        $dossiers = getDossiersStageEtudiant($idEtudiant, $idEnseignant);

        if ($dossiers === []) {
            $error = 'Aucun dossier de stage accessible n’a été trouvé pour cet étudiant.';
        }

        include 'view/layout/header.php';
        include 'view/historique/EtudiantSelectionneView.php';
    }
}
