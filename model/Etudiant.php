<?php

function getDossiersStageEtudiant($idEtudiant, $idEnseignant) {
    global $pdo;

    $sql = "SELECT
                e.IdEtudiant,
                e.nom,
                e.prenom,
                a.anneeDebut,
                a.DateDebutStage as dateDebutStage,
                a.DateFinStage as dateFinStage,
                ROUND(DATEDIFF(a.DateFinStage, a.DateDebutStage) / 7,0) AS dureeStage,
                a.but3sinon2,
                a.alternanceBUT3,
                a.sujet,
                a.nomMaitreStageApp,
                a.typeMission,
                a.cadreMission,
                ent.nom AS entreprise,
                ent.villeE AS villeEntreprise,
                ent.codePostal,
                es.IdEvalStage,
                es.date_h AS dateSoutenance,
                es.presenceMaitreStageApp,
                es.confidentiel,
                es.Statut AS statutStage,
                es.IdSalle AS idSalle,
                salle.description AS descriptionSalle,
                enseignant.IdEnseignant AS IdEnseignantTuteur,
                enseignant_1.IdEnseignant AS IdEnseignantSecond,
                soutenanceTuteur.IdEvalSoutenanceEnsTut AS IdEvalSoutenanceTuteur,
                soutenanceSecond.IdEvalSoutenanceEnsSecond AS IdEvalSoutenanceSecond,
                CONCAT(enseignant.prenom, ' ', enseignant.nom) AS enseignantTuteur,
                CONCAT(enseignant_1.prenom, ' ', enseignant_1.nom) AS enseignantSecond,
                er.IdEvalRapport,
                er.Statut AS statutRapport,
                ep.IdEvalPortfolio,
                ep.Statut AS statutPortfolio,
                ea.IdEvalAnglais,
                ea.dateS AS dateAnglais,
                ea.Statut AS statutAnglais,
                ea.IdEnseignant AS idEvaluateurAnglais,
                COALESCE(soutenanceTuteur.Statut, soutenanceSecond.Statut) AS statutSoutenance
            FROM EtudiantsBUT2ou3 e
            INNER JOIN AnneeStage a ON a.IdEtudiant = e.IdEtudiant
            LEFT JOIN Entreprises ent ON ent.IdEntreprise = a.IdEntreprise
            LEFT JOIN EvalStage es ON es.IdEtudiant = a.IdEtudiant AND es.anneeDebut = a.anneeDebut
            LEFT JOIN Salles salle ON salle.IdSalle = es.IdSalle
            LEFT JOIN Enseignants enseignant ON enseignant.IdEnseignant = es.IdEnseignant
            LEFT JOIN Enseignants enseignant_1 ON enseignant_1.IdEnseignant = es.IdEnseignant_1
            LEFT JOIN EvalRapport er ON er.IdEtudiant = a.IdEtudiant AND er.anneeDebut = a.anneeDebut
            LEFT JOIN EvalPortfolio ep ON ep.IdEtudiant = a.IdEtudiant AND ep.anneeDebut = a.anneeDebut
            LEFT JOIN EvalAnglais ea ON ea.IdEtudiant = a.IdEtudiant AND ea.anneeDebut = a.anneeDebut
            LEFT JOIN EvalSoutenanceEnsTuteur soutenanceTuteur
            ON soutenanceTuteur.IdEtudiant = a.IdEtudiant
            AND soutenanceTuteur.anneeDebut = a.anneeDebut
            AND soutenanceTuteur.IdEnseignant = :idEnseignantSoutenanceTuteur
            LEFT JOIN EvalSoutenanceEnsSecond soutenanceSecond
            ON soutenanceSecond.IdEtudiant = a.IdEtudiant
            AND soutenanceSecond.anneeDebut = a.anneeDebut
            AND soutenanceSecond.IdEnseignant = :idEnseignantSoutenanceSecond
            WHERE e.IdEtudiant = :idEtudiant
                AND (
                    es.IdEnseignant = :idEnseignantTuteur
                    OR es.IdEnseignant_1 = :idEnseignantSecond
                    OR ea.IdEnseignant = :idEnseignantAnglais
                )
            ORDER BY a.anneeDebut DESC";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'idEtudiant' => $idEtudiant,
        'idEnseignantSoutenanceTuteur' => $idEnseignant,
        'idEnseignantSoutenanceSecond' => $idEnseignant,
        'idEnseignantTuteur' => $idEnseignant,
        'idEnseignantSecond' => $idEnseignant,
        'idEnseignantAnglais' => $idEnseignant,
    ]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}