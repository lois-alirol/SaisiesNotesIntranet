<!DOCTYPE html>
<html>
<head>
    <title>SAISIES NOTES INTRANET</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
    <header>
        <img src="/public/images/uca-fond-transparent.png" width="256px" class="uca-logo" alt="UCA Logo">
        <h3><?=  htmlspecialchars(EnseignantSession::getData()["nom"]) ?>  <?=  htmlspecialchars(EnseignantSession::getData()["prenom"]) ?></h3>
    </header>
    <main>