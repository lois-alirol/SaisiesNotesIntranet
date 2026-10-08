<?php

function getListEtudiants($idEnseignant)
{
    global $pdo;

    $sql = "
    SELECT IdEtudiant, nom, prenom, mail
    FROM etudiantsbut2ou3
    WHERE IdEtudiant IN (
        SELECT DISTINCT IdEtudiant
        FROM evalstage
        WHERE IdEnseignant = :idEnseignant OR IdEnseignant_1 = :idEnseignant
    ) 
    OR IdEtudiant IN (
        SELECT DISTINCT IdEtudiant
        FROM evalanglais
        WHERE IdEnseignant = :idEnseignant
    )
";

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'idEnseignant' => $idEnseignant,
    ]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
