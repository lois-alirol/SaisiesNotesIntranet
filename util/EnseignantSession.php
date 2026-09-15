<?php

class EnseignantSession {
    public static function isAuthenticated(): bool {
        return (
            isset($_SESSION["id"]) && isset($_SESSION["nom"]) &&
            isset($_SESSION["prenom"]) && isset($_SESSION["mail"])
        );
    }

    public static function getData(): array {
        if (!EnseignantSession::isAuthenticated()) {
            return [];
        }

        return [
            "id" => $_SESSION["id"],
            "nom" => $_SESSION["nom"],
            "prenom" => $_SESSION["prenom"],
            "mail" => $_SESSION["mail"]
        ];
    }
}