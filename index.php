<?php

require_once __DIR__ . '/database/DatabaseConnection.php';
require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/controller/GrilleEvalController.php';
require_once __DIR__ . '/controller/PlanningController.php';
require_once __DIR__ . '/controller/EtudiantSelectionneController.php';
session_start();

$authController = new AuthController();
$grilleEvalController = new GrilleEvalController();
$planningController = new planningController();
$historiqueController = new EtudiantSelectionneController();


$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . $url;

if ($url !== "/" && is_file($file)) {
    return;
}

if (!EnseignantSession::isAuthenticated() && $url !== "/login") {
    include __DIR__ . '/view/error/403.php';
    return;
}

// Interception de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['validate'])) {
        if (!isset($_POST['idEval'])) {
            echo "Erreur : idEval manquant.";
            exit();
        }
    if (!isset($_POST['notes'])) {
            echo "Erreur : noteCritaire manquant.";
            exit();
    }
    if (!isset($_POST['critaireId'])) {
            echo "Erreur : critaireId manquant.";
            exit();
    }
    if (!isset($_POST['tableName'])) {
            echo "Erreur : coursType tableName manquant.";
            exit();
    }
    $grilleEvalController->validerEvaluation($_POST['idEval'], $_POST['notes'], $_POST['critaireId'], $_POST['tableName']);
        
    // Optionnel : Redirection pour éviter de renvoyer le formulaire en rafraîchissant
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
    
if (isset($_POST['Enregistrer'])) {
    echo "OUI";
        exit();
}
}




switch ($url) {
    case "/login": {
        $authController->handle();
        break;
    }
    case "/logout": {
        $authController->logout();
        break;
    }
    case "/grille": {
        $grilleEvalController->show();
        break;
    }
    case "/planning": {
        $planningController->Planning();
        break;
    }
    case "/historique": {
        $historiqueController->afficherPage();
        break;
    }
    default: {
        include __DIR__ . '/view/error/404.php';
        break;
    }
}