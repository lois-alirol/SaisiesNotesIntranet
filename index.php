<?php

require_once __DIR__ . '/database/DatabaseConnection.php';
require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/controller/GrilleEvalController.php';
require_once __DIR__ . '/controller/PlanningController.php';

session_start();

$authController = new AuthController($pdo);
$grilleEvalController = new GrilleEvalController();
$planningController = new planningController();

$grilleEvalController->show(1, 2, "ENSTUTEUR", "PORTFOLIO");

// //SI IL N'Y A PAS D'ACTION, ON AFFICHE LA LISTE
// $action = $_GET['action'] ?? 'list';

// //SWITCH DES ACTIONS, PAR DEFAUT AFFICHE LA LISTE
// switch ($action) {
//     case 'list':
//         $controller->list();
//         break;
//     case 'add':
//         $controller->add();
//         break;
//     case 'delete':
//         $controller->delete($_GET['id']);
//         break;
//     case 'recoltes':
//         $controller->showRecoltes($_GET['id']);
//         break;
//     case 'addrecoltes':
//         $controller->addRecoltes($_GET['culture_id'], $_GET['dateRecolte'], $_GET['quantite']);
//         break;
//     default:
//         echo "Action inconnue.";
// }
// ?>