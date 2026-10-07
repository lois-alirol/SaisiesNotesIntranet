<!--AFFICHAGE DU TABLEAU DES CRITERES-->

<?php include "view/layout/header.php"; ?>
<link rel="stylesheet" type="text/css" href="public/css/grilleEval.css">

<div class="info-bar">
    <div>
        <div>
            <p>Cours : <?= $modeleeval["natureGrille"] ?></p>
            <p>Devoir : <?= $modeleeval["nomModuleGrilleEvaluation"]?></p>
        </div>
        <div>
            <p><?= $etudiant["nom"]?> <?= $etudiant["prenom"]?></p>
        </div>
    </div>
</div>

<form method="POST" action="/grille?idEval=<?= $idEval ?>&cours=<?= $cours ?>&typeEnseignant=<?= $typeEnseignant ?>">
    <div class="content">
        <div class="table-box">
            <h2>Notes :</h2>
            <input type="hidden" name="idEval" value="<?= htmlspecialchars($modeleeval["IdModeleEval"], ENT_QUOTES, "UTF-8") ?>">

            <table>
                <thead>
                    <tr>
                        <th>Critere</th>
                        <th>Description du critère</th>
                        <th>Note du critère</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($critereseval as $c): ?>
                        <tr>
                            <td><?= $c["descCourte"] ?></td>
                            <td><?= $c["descLongue"] ?></td>
                            <td class="slider-box">
                                <div>    
                                    <input type="range" name="notes[<?= $c["IdCritere"] ?>]" id="slider-<?= $c["IdCritere"] ?>" value="<?= $c["noteCritere"]?>" min="0" max="<?= $c["ValeurMaxCritereEVal"] ?>" step="0.1" />
                                </div>
                                <div>
                                    <span id="value-<?= $c["IdCritere"] ?>"></span>/<span class="max-value" id="max-value-<?= $c["IdCritere"] ?>"></span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- SUPPRR -->
        <h2 id="note-finale">Note finale : <?= $noteFinale ?> / <?= $noteMaximale ?></h2>

        <script>
            let noteFinale = document.getElementById("note-finale");
            let noteFinalCalcul = 0;
            let tabNotes = [];

            <?php foreach ($critereseval as $c): ?>
                let slider<?= $c["IdCritere"] ?> = document.getElementById("slider-<?= $c["IdCritere"] ?>");
                let output<?= $c["IdCritere"] ?> = document.getElementById("value-<?= $c["IdCritere"] ?>");
                let maxValue<?= $c["IdCritere"] ?> = document.getElementById("max-value-<?= $c["IdCritere"] ?>");

                maxValue<?= $c["IdCritere"] ?>.innerHTML = <?= $c["ValeurMaxCritereEVal"] ?>;
                output<?= $c["IdCritere"] ?>.innerHTML = slider<?= $c["IdCritere"] ?>.value;

                tabNotes[<?= $c["IdCritere"] - 1?>] = Number(slider<?= $c["IdCritere"] ?>.value);

                slider<?= $c["IdCritere"] ?>.oninput = function() {
                    output<?= $c["IdCritere"] ?>.innerHTML = this.value;
                    tabNotes[<?= $c["IdCritere"] - 1?>] = Number(this.value);

                    noteFinalCalcul = 0
                    tabNotes.forEach((el) => noteFinalCalcul += el);
                    noteFinale.textContent = "Note finale : " + noteFinalCalcul + "/" + <?= $noteMaximale ?>;
                };

            <?php endforeach; ?>
        </script>

        <div class="feedback-box">
            <h2>Feedback :</h2>
            <textarea name="feedback"><?= $feedback ?></textarea>
        </div>

        <div class="save-bar">
            <button type="submit" name="save" value="save">Enregistrer</button>
            <button type="submit">Valider</button>
        </div>
    </div>
</form>