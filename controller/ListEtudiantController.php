<?php

require_once 'model/ListEtudiant.php';

class ListEtuController {
    
    public function afficherPage() {
        $idEnseignant = EnseignantSession::getData()["id"];

        $etudiants = getListEtudiants($idEnseignant);

        if ($etudiants === []) {
            $error = "Aucun étudiant n’a été trouvé.";
        }

        include 'view/layout/header.php';
        include 'view/Etudiants/EtudiantListView.php';
    }
}