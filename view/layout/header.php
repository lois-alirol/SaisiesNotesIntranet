<!DOCTYPE html>
<html>

<head>
    <title>SAISIES NOTES INTRANET</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <meta charset="UTF-8">
</head>

<body>
    <header>
        <img src="/public/images/uca-fond-transparent.png" width="256px" class="uca-logo" alt="UCA Logo">
        <nav class="navbar">
            <div class="navbar-container container">
                <div class="hamburger-lines">
                    <span class="line line1"></span>
                    <span class="line line2"></span>
                    <span class="line line3"></span>
                </div>
                <ul class="menu-items">
                    <li onclick="window.location.href='/'"><a href="/">Étudiants</a></li>
                    <li onclick="window.location.href='/planning'"><a href="/planning">Planning</a></li>
                    <li onclick="window.location.href='/logout'"><a href="/logout">Se déconnecter</a></li>
                </ul>
            </div>

            <div class="enseignant">
                <img src="/public/images/user-icon.svg" width="32px" height="32px" alt="Enseignant">
                <p>
                    <b><?= htmlspecialchars(EnseignantSession::getData()["nom"]) ?>
                        <?= htmlspecialchars(EnseignantSession::getData()["prenom"]) ?></b>
                </p>
            </div>
        </nav>
    </header>
    <main>