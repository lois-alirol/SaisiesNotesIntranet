<?php

require_once 'model/Enseignant.php';
require_once 'util/EnseignantSession.php';
require_once 'util/Helper.php';

class AuthController {
    public Enseignant $enseignantModel;

    public function __construct() {
        global $pdo;
        $this->enseignantModel = new Enseignant($pdo);
    }

    public function handle(): void {
        $method = $_SERVER["REQUEST_METHOD"];

        if (EnseignantSession::isAuthenticated()) {
            header("Location: /");
            exit;
        }

        if ($method === "GET") {
            include "view/login/form.php";
            exit;
        }

        if ($method === "POST")  {
            $this->login($_POST);
            exit;
        }
    }

    public function login($data): void {
        $email = $data["email"];
        $password = $data["password"];

        if (!isset($email) || !isset($password) ||!validateEmail($email)) {
            $error = "L'email n'est pas valide";
            include "view/login/form.php";
            return;
        }

        $teacher = $this->enseignantModel->login($email, $password);

        if (!$teacher) {
            $error = "L'email ou mot de passe est incorrect";
            include "view/login/form.php";
            return;
        }

        session_regenerate_id(true);

        $_SESSION["id"] = $teacher["IdEnseignant"];
        $_SESSION["nom"] = $teacher["nom"];
        $_SESSION["prenom"] = $teacher["prenom"];
        $_SESSION["mail"] = $teacher["mail"];

        header("Location: /planning");
    }

    public function logout(): void {
        session_unset();
        session_destroy();

        header("Location: /login");
    }
}