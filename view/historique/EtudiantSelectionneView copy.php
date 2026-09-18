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

<div class="historique-page">
    <div class="historique-entete">
        <h1><?= escape(historiqueValeur($dossiers[0], 'prenom', '')) ?> <?= escape(historiqueValeur($dossiers[0], 'nom', '')) ?></h1>
    </div>

    <?php foreach ($dossiers as $dossier): ?>
        <?php
            $estBut3 = (bool) $dossier['but3sinon2'];
            $formation = $estBut3 ? 'BUT3' : 'BUT2';
            $regime = $estBut3
                ? ($dossier['alternanceBUT3'] ? 'Alternance' : 'Formation initiale')
                : 'Formation initiale';
            $idSalle = historiqueValeur($dossier, 'idSalle', '');
            if ($idSalle === '') {
                $idSalle = 'Non renseignée';
            }
            $lieu = trim(implode(' ', array_filter([
                historiqueValeur($dossier, 'codePostal', ''),
                historiqueValeur($dossier, 'villeEntreprise', ''),
            ])));
            $actions = historiqueActions($dossier, $idEnseignant);
            $alertes = historiqueAlertes($dossier);
        ?>
        <div class="historique-dossier">
            <div class="historique-dossier-entete">
                <h2>Année universitaire <?= escape((string) $dossier['anneeDebut']) ?>–<?= escape((string) ((int) $dossier['anneeDebut'] + 1)) ?></h2>
                <div class="historique-pastilles">
                    <span><?= escape($formation) ?></span>
                    <span><?= escape($regime) ?></span>
                </div>
            </div>

            <div class="historique-grille">
                <div class="historique-carte historique-carte-large">
                    <h3>Stage</h3>
                    <dl>
                        <div class="historique-ligne">
                            <dt>Date et Durée</dt>
                            <dd><?= "Du " . escape(historiqueDate(historiqueValeur($dossier, 'dateDebut'), false)) . " au " . escape(historiqueDate(historiqueValeur($dossier, 'dateFin'), false)) . " (" . escape(historiqueValeur($dossier, 'dureeStage')) . " Semaines)" ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Entreprise</dt>
                            <dd><?= escape(historiqueValeur($dossier, 'entreprise')) ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Lieu</dt>
                            <dd><?= escape($lieu !== '' ? $lieu : 'Non renseigné') ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Tuteur de stage</dt>
                            <dd><?= escape(historiqueValeur($dossier, 'nomMaitreStageApp')) ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Sujet</dt>
                            <dd><?= escape(historiqueValeur($dossier, 'sujet')) ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Mission</dt>
                            <dd><?= escape(historiqueValeur($dossier, 'typeMission')) ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Cadre de la mission</dt>
                            <dd><?= escape(historiqueValeur($dossier, 'cadreMission')) ?></dd>
                        </div>
                    </dl>
                </div>

                <div class="historique-carte">
                    <h3>Soutenance</h3>
                    <dl>
                        <div class="historique-ligne">
                            <dt>Date et heure</dt>
                            <dd><?= escape(historiqueDate($dossier['dateSoutenance'])) ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Salle</dt>
                            <dd><?= escape($idSalle) ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Tuteur de stage présent</dt>
                            <dd><?= !empty($dossier['presenceMaitreStageApp']) ? 'Oui' : 'Non' ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Enseignant tuteur </dt>
                            <dd><?= escape(historiqueValeur($dossier, 'enseignantTuteur')) ?></dd>
                        </div>
                        <div class="historique-ligne">
                            <dt>Second enseignant</dt>
                            <dd><?= escape(historiqueValeur($dossier, 'enseignantSecond')) ?></dd>
                        </div>
                    </dl>
                </div>

                <div class="historique-carte">
                    <h3>État des évaluations</h3>
                    <ul class="historique-liste-statuts">
                        <?php
                            $isTuteur = historiqueValeur($dossier, 'IdEnseignantTuteur') === $idEnseignant;
                            $typeEnseignant = $isTuteur ? "ENSTUTEUR" : "ENSSECOND";

                            $idEvalStage = historiqueValeur($dossier, 'IdEvalStage');
                            $idEvalRapport = historiqueValeur($dossier, 'IdEvalRapport');
                            $idEvalPortfolio = historiqueValeur($dossier, 'IdEvalPortfolio');
                            $idEvalAnglais = historiqueValeur($dossier, 'IdEvalAnglais');
                        ?>
                        <li class="historique-statut">
                            <span><a href="/grille?typeEnseignant=<?= $typeEnseignant ?>&eval=<?= $idEvalStage ?>&cours=SOUTENANCE">Stage</a></span>
                            <span class="historique-badge <?= historiqueClasseStatut($dossier['statutStage']) ?>">
                                <?= escape(historiqueLibelleStatut($dossier['statutStage'])) ?>
                            </span>
                        </li>
                        <li class="historique-statut">
                            <span><a href="/grille?typeEnseignant=<?= $typeEnseignant ?>&eval=<?= $idEvalRapport ?>&cours=RAPPORT">Rapport</a></span>
                            <span class="historique-badge <?= historiqueClasseStatut($dossier['statutRapport']) ?>">
                                <?= escape(historiqueLibelleStatut($dossier['statutRapport'])) ?>
                            </span>
                        </li>
                        <li class="historique-statut">
                            <span><a href="/grille?typeEnseignant=<?= $typeEnseignant ?>&eval=<?= $idEvalPortfolio ?>&cours=PORTFOLIO">Portfolio</a></span>
                            <span class="historique-badge <?= historiqueClasseStatut($dossier['statutPortfolio']) ?>">
                                <?= escape(historiqueLibelleStatut($dossier['statutPortfolio'])) ?>
                            </span>
                        </li>
                        <?php if (($dossier['idEvaluateurAnglais'] ?? 0) === $idEnseignant): ?>
                            <li class="historique-statut">
                                <span><a href="/grille?typeEnseignant=<?= $typeEnseignant ?>&eval=<?= $idEvalAnglais ?>&cours=ANGLAIS">Anglais</a></span>
                                <span class="historique-badge <?= historiqueClasseStatut($dossier['statutAnglais']) ?>">
                                    <?= escape(historiqueLibelleStatut($dossier['statutAnglais'])) ?>
                                </span>
                            </li>
                        <?php endif; ?>
                        <?php if (($dossier['statutSoutenance'] ?? null) !== null): ?>
                            <li class="historique-statut">
                                <span>Grille de soutenance</span>
                                <span class="historique-badge <?= historiqueClasseStatut($dossier['statutSoutenance']) ?>">
                                    <?= escape(historiqueLibelleStatut($dossier['statutSoutenance'])) ?>
                                </span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="historique-carte">
                    <h3>Échéances</h3>
                    <ul class="historique-liste">
                        <?php if (!empty($dossier['dateSoutenance'])): ?>
                            <li><strong>Soutenance :</strong> <?= escape(historiqueDate($dossier['dateSoutenance'])) ?></li>
                        <?php endif; ?>
                        <?php if ((int) ($dossier['idEvaluateurAnglais'] ?? 0) === $idEnseignant && !empty($dossier['dateAnglais'])): ?>
                            <li><strong>Évaluation d’anglais :</strong> <?= escape(historiqueDate($dossier['dateAnglais'])) ?></li>
                        <?php endif; ?>
                        <?php if (empty($dossier['dateSoutenance']) && empty($dossier['dateAnglais'])): ?>
                            <li class="historique-vide">Aucune échéance planifiée.</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="historique-carte historique-carte-action">
                    <h3>Actions à réaliser</h3>
                    <?php if ($actions === []): ?>
                        <p class="historique-vide">Aucune action en attente.</p>
                    <?php else: ?>
                        <ul class="historique-liste historique-liste-actions">
                            <?php foreach ($actions as $action): ?>
                                <li><?= escape($action) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="historique-carte historique-carte-alerte">
                    <h3>Alertes</h3>
                    <?php if ($alertes === []): ?>
                        <p class="historique-vide">Aucune alerte détectée.</p>
                    <?php else: ?>
                        <ul class="historique-liste historique-liste-alertes">
                            <?php foreach ($alertes as $alerte): ?>
                                <li><?= escape($alerte) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
