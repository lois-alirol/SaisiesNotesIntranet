<?php
function escape($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function historiqueValeur($dossier, $cle) {
    $valeur = $dossier[$cle] ?? null;
    return $valeur === null || $valeur === '' ? 'Non renseigné' : $valeur;
}

function historiqueDate($date, $heure = true) {
    if ($date === null || $date === '') {
        return 'Non planifiée';
    }

    if ($heure)
        return (new DateTime($date))->format('d/m/Y à H:i');
    else
        return (new DateTime($date))->format('d/m/Y');
}

function historiqueLibelleStatut($statut) {
    return match ($statut) {
        'SAISIE' => 'En cours de saisie',
        'BLOQUEE' => 'Bloquée',
        'REMONTEE' => 'À valider',
        'VALIDEE' => 'Validée',
        'DIFFUSEE' => 'Diffusée',
        default => 'Non créée',
    };
}

function historiqueClasseStatut($statut) {
    return match ($statut) {
        'SAISIE' => 'statut-saisie',
        'BLOQUEE' => 'statut-bloquee',
        'REMONTEE' => 'statut-remontee',
        'VALIDEE', 'DIFFUSEE' => 'statut-validee',
        default => 'statut-inconnu',
    };
}

function historiqueEstFinalise($statut) {
    return in_array($statut, ['VALIDEE', 'DIFFUSEE'], true);
}

function historiqueActions($dossier, $idEnseignant) {
    $actions = [];
    $evaluations = [
        ['Évaluation de stage', $dossier['statutStage'] ?? null, $dossier['IdEvalStage'] ?? null],
        ['Évaluation du rapport', $dossier['statutRapport'] ?? null, $dossier['IdEvalRapport'] ?? null],
        ['Évaluation du portfolio', $dossier['statutPortfolio'] ?? null, $dossier['IdEvalPortfolio'] ?? null],
    ];

    if ((int) ($dossier['idEvaluateurAnglais'] ?? 0) === $idEnseignant) {
        $evaluations[] = ['Évaluation d’anglais', $dossier['statutAnglais'] ?? null, $dossier['IdEvalAnglais'] ?? null];
    }
    if (($dossier['statutSoutenance'] ?? null) !== null) {
        $evaluations[] = ['Grille de soutenance', $dossier['statutSoutenance'], true];
    }

    foreach ($evaluations as [$libelle, $statut, $idEvaluation]) {
        if ($idEvaluation === null) {
            $actions[] = "Créer $libelle.";
        } elseif ($statut === 'SAISIE') {
            $actions[] = "Finaliser la saisie : $libelle.";
        } elseif ($statut === 'REMONTEE') {
            $actions[] = "Valider $libelle.";
        }
    }

    return $actions;
}

function historiqueAlertes($dossier) {
    $alertes = [];

    if (empty($dossier['entreprise'])) {
        $alertes[] = 'Entreprise non renseignée.';
    }
    if (empty($dossier['nomMaitreStageApp'])) {
        $alertes[] = 'Tuteur de stage non renseigné.';
    }
    if (empty($dossier['dateSoutenance'])) {
        $alertes[] = 'Soutenance non planifiée.';
    }
    if (!empty($dossier['confidentiel'])) {
        $alertes[] = 'Ce dossier de stage est confidentiel.';
    }
    if (!empty($dossier['dateSoutenance']) && !historiqueEstFinalise($dossier['statutStage'] ?? null)) {
        try {
            $dateSoutenance = new DateTime($dossier['dateSoutenance']);
            if ($dateSoutenance < new DateTime('now')) {
                $alertes[] = 'La soutenance est passée, mais l’évaluation de stage n’est pas finalisée.';
            }
        } catch (Exception $exception) {
        }
    }

    return $alertes;
}