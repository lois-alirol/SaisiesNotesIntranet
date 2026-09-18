<?php

require_once 'util/Helper.php';

if (isset($error)): ?>
    <link rel="stylesheet" href="/public/css/historique.css">
    <div class="historique-page historique-page-erreur">
        <div class="historique-message-vide">
            <h1>Historique de stage</h1>
            <p><?= escape($error) ?></p>
        </div>
    </div>
    <?php exit; ?>
<?php endif; ?>

<link rel="stylesheet" href="/public/css/historique.css">



<?php foreach ($dossiers as $dossier): ?>
    <?php
    $estBut3 = (bool) $dossier['but3sinon2'];
    $formation = $estBut3 ? 'BUT3' : 'BUT2';
    $regime = $estBut3
    ?>
    <div class="historique-page">
        <div class="historique-entete">
            <h1><?= escape(historiqueValeur($dossier, 'prenom', '')) ?> <?= escape(historiqueValeur($dossier, 'nom', '')) ?></h1>
        </div>

        <li class="historique-statut">
            <span><a href="/grille?eval=<?= $dossier['IdEvalStage'] ?>&cours=SOUTENANCE">Stage</a></span>
        </li>
        <li class="historique-statut">
            <span><a href="/grille?eval=<?= $dossier['IdEvalPortfolio'] ?>&cours=RAPPORT">Rapport</a></span>
        </li>
        <li class="historique-statut">
            <span><a href="/grille?eval=<?= $dossier['IdEvalPortfolio'] ?>&cours=PORTFOLIO">Portfolio</a></span>
        </li>
        <li class="historique-statut">
            <span><a href="/grille?eval=<?= $dossier['IdEvalAnglais']?>&cours=ANGLAIS">Anglais</a></span>
        </li>
    </div>
<?php endforeach; ?>