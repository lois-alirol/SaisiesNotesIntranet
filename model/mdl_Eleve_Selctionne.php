<?php
function getInfosTutor($idEtudiant, $idUser) {
    global $pdo;
    $sql = "SELECT e.IdEtudiant, e.nom, e.prenom, a.sujet, ent.nom As entreprise, es.date_h,
            s.description AS salle, er.note AS ernote, er.commentaireJury AS ercomm, er.Statut AS erstat, er.anneeDebut AS eryr,
            ep.note AS epnote, ep.commentaireJury AS epcomm, ep.Statut AS epstat, ep.anneeDebut AS epyr
            FROM EtudiantsBUT2ou3 e
            JOIN AnneeStage a ON a.IdEtudiant = e.IdEtudiant
            JOIN Entreprises ent ON ent.IdEntreprise = a.IdEntreprise
            JOIN EvalStage es ON es.IdEtudiant = e.IdEtudiant
            JOIN Evalrapport er ON er.IdEtudiant = e.IdEtudiant
            JOIN EvalPortfolio ep ON ep.IdEtudiant = e.IdEtudiant
            JOIN Salles s ON s.IdSalle = es.IdSalle
            WHERE e.IdEtudiant = ? AND es.IdEnseignantTuteur = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idEtudiant, $idUser]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getInfosSecondary($idEtudiant, $idUser) {
    global $pdo;
    $sql = "SELECT e.IdEtudiant, e.nom, e.prenom, a.sujet, ent.nom As entreprise, es.date_h,
            s.description AS salle
            FROM EtudiantsBUT2ou3 e
            JOIN AnneeStage a ON a.IdEtudiant = e.IdEtudiant
            JOIN Entreprises ent ON ent.IdEntreprise = a.IdEntreprise
            JOIN EvalStage es ON es.IdEtudiant = e.IdEtudiant
            JOIN Salles s ON s.IdSalle = es.IdSalle
            WHERE e.IdEtudiant = ? AND es.IdEnseignantSecond = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idEtudiant, $idUser]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getInfosEnglishEvaluator($idEtudiant, $idUser) {
    global $pdo;
    $sql = "SELECT e.IdEtudiant, e.nom, e.prenom, a.sujet, ea.note AS eanote, ea.dateS AS eadate, ea.commentaireJury AS eacomm, ea.IdSalle AS easalle, ea.Statut AS eastat
            FROM EtudiantsBUT2ou3 e
            JOIN AnneeStage a ON a.IdEtudiant = e.IdEtudiant
            JOIN EvalAnglais ea ON ea.IdEtudiant = e.IdEtudiant
            WHERE e.IdEtudiant = ? AND (ea.IdEnseignant = ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idEtudiant, $idUser]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRoleUtilisateur($idUser, $idEtudiant) {
    global $pdo;
    // Cas 1 : professeur tuteur
    $sql = "SELECT 1 FROM EvalStage WHERE IdEnseignantTuteur = ? AND IdEtudiant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idUser, $idEtudiant]);
    if ($stmt->fetch()) return "TUTEUR";

    // Cas 2 : professeur secondaire
    $sql = "SELECT 1 FROM EvalStage WHERE IdSecondEnseignant = ? AND IdEtudiant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idUser, $idEtudiant]);
    if ($stmt->fetch()) return "SECONDAIRE";

    // Cas 3 : secrétaire (pas lié aux tables EvalStage)
    return "SECRETAIRE";
}

function getIsTutor ($idUser, $idEtudiant) {
    global $pdo;
    $sql = "SELECT 1 FROM EvalStage WHERE IdEnseignantTuteur = ? AND IdEtudiant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idUser, $idEtudiant]);
    if($stmt->fetch()) {
        return true;
    } else {
        return false;
    }
}

function getIsSecondary ($idUser, $idEtudiant) {
    global $pdo;
    $sql = "SELECT 1 FROM EvalStage WHERE IdEnseignantSecond = ? AND IdEtudiant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idUser, $idEtudiant]);
    if($stmt->fetch()) {
        return true;
    } else {
        return false;
    }
}

function getIsEnglishEvaluator ($idUser, $idEtudiant) {
    global $pdo;
    $sql = "SELECT 1 FROM EvalAnglais WHERE IdEnseignant = ? AND IdEtudiant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idUser, $idEtudiant]);
    if($stmt->fetch()) {
        return true;
    } else {
        return false;
    }
}