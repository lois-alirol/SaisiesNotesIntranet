<!--AFFICHAGE DU TABLEAU DES CRITERES-->

<?php include "view/layout/header.php"; ?>
<link rel="stylesheet" type="text/css" href="public/css/grilleEval.css">

<form method="POST" action="/grille?idEval=<?= $idEval ?>&cours=<?= $cours ?>&typeEnseignant=<?= $typeEnseignant ?>">
    <div class="content">
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
                            <td><?= htmlspecialchars($c["descCourte"]) ?></td>
                            <td><?= htmlspecialchars($c["descLongue"]) ?></td>
                            <td class="slider-box">
                                <div>
                                    <input type="range" name="notes[<?= $c["IdCritere"] ?>]" id="slider-<?= $c["IdCritere"] ?>" value="<?= $c["noteCritere"]?>" min="0" max="<?= $c["ValeurMaxCritereEVal"] ?>" step="0.1" <?php if ($resultatEval["Statut"] == "BLOQUEE") echo "disabled" ?> />
                                </div>
                                <div>
                                    <span class="note-value" id="value-<?= $c["IdCritere"] ?>"></span> / <span id="max-value-<?= $c["IdCritere"] ?>" disabled></span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

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

                    updateColor(slider<?= $c["IdCritere"] ?>, output<?= $c["IdCritere"] ?>, <?= $c["ValeurMaxCritereEVal"]?>);

                    noteFinalCalcul = 0
                    tabNotes.forEach((el) => noteFinalCalcul += el);
                    noteFinale.textContent = "Note finale : " + noteFinalCalcul + " / " + <?= $noteMaximale ?>;
                };
                
                updateColor( slider<?= $c["IdCritere"] ?>, output<?= $c["IdCritere"] ?>, <?= $c["ValeurMaxCritereEVal"] ?>);
            <?php endforeach; ?>

            function updateColor(slider, text, max){
                let p = slider.value / max //0 = COLOR MIN, 1 = COLOR MAX
                let c = colorInterpolate("#2A7B9B", "#B3C959", p)

                slider.style.setProperty('--thumb-color', c);
                text.style.color = c;
            }

            //RENDRE A CESAR CE QUI APPARTIENT A JULES :
            // Source - https://stackoverflow.com/a/76126221
            // Posted by zfj3ub94rf576hc4eegm
            // Retrieved 2026-10-11, License - CC BY-SA 4.0
            function colorInterpolate(color1, color2, p) {
                //HEX -> RGB
                const r1 = parseInt(color1.substring(1, 3), 16);
                const g1 = parseInt(color1.substring(3, 5), 16);
                const b1 = parseInt(color1.substring(5, 7), 16);

                const r2 = parseInt(color2.substring(1, 3), 16);
                const g2 = parseInt(color2.substring(3, 5), 16);
                const b2 = parseInt(color2.substring(5, 7), 16);

                //INTERPOLATION
                const r = Math.round(r1 + (r2 - r1) * p);
                const g = Math.round(g1 + (g2 - g1) * p);
                const b = Math.round(b1 + (b2 - b1) * p);

                //RGB -> HEX
                return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
            }

        </script>

        <div class="feedback-box">
            <h2>Feedback :</h2>
            <textarea name="feedback"><?= htmlspecialchars($feedback) ?></textarea>
        </div>

        <?php
        
        if (isset($result)){
            //TRIGGER (RESULT DIFFERENT DE 1 == ERREUR)
            if ($result != 1) {
                include "view/grilleEval/error.php";
            }
        }
            
        ?>

        <div class="save-bar">
            <button type="submit" name="save" value="save" <?php if ($resultatEval["Statut"] === "BLOQUEE") echo "disabled" ?>>Enregistrer</button>
            <button type="submit" <?php if ($resultatEval["Statut"] === "BLOQUEE") echo "disabled" ?>>Valider</button>
        </div>
    </div>
</form>