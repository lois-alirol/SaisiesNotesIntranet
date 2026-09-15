<?php

// A CHANGER POUR SE CONNECTER A VOTRE DB
$host = "localhost";
$port = "3306";
$dbName = "evaluationstages";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=" . $host . ":" . $port . ";dbname=" . $dbName . ";charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}