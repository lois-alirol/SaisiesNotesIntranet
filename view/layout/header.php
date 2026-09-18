<!DOCTYPE html>
<html>

<head>
    <title>SAISIES NOTES INTRANET</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>

<body>
    <header>
        <img src="/public/images/uca-fond-transparent.png" width="256px" class="uca-logo" alt="UCA Logo">
        <h3><?= htmlspecialchars(EnseignantSession::getData()["nom"]) ?> <?= htmlspecialchars(EnseignantSession::getData()["prenom"]) ?></h3>
        <nav class="navbar">
            <div class="navbar-container container">
                <input type="checkbox" name="" id="">
                <div class="hamburger-lines">
                    <span class="line line1"></span>
                    <span class="line line2"></span>
                    <span class="line line3"></span>
                </div>
                <ul class="menu-items">
                    <li><a href="/planning">Planning</a></li>
                    <li><a href="/historique">Etudiants</a></li>
                    <li><a href="/grille">Grille</a></li>
                    <li><a href="/logout">Logout</a></li>
                </ul>
                <h1 class="logo">Navbar</h1>
            </div>
        </nav>
    </header>
    <main>