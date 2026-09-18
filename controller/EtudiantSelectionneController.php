<?php

require_once 'model/Etudiant.php';

class EtudiantSelectionneController {
    public function afficherPage() {
        $idEnseignant = EnseignantSession::getData()["id"];


        $dossiers = getProfEtudiant($idEnseignant);

        if ($dossiers === []) {
            $error = 'Aucun dossier de stage accessible n’a été trouvé pour cet étudiant.';
        }

        include 'view/layout/header.php';
        include 'view/historique/EtudiantSelectionneView.php';
    }
}
