<!--AFFICHAGE DU TABLEAU DES CRITERES-->

<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" type="text/css" href="public/css/grilleEval.css">

<div class="info-bar">
    <div>
        <div>
            <p>Cours : <?= $modeleeval["natureGrille"]?></p>
            <p>Devoir : <?= $modeleeval["nomModuleGrilleEvaluation"]?></p>
        </div>
        <div>
            <p><?= $etudiant["nom"]?> <?=$etudiant["prenom"]?></p>
        </div>
    </div>
</div>

<div class="content">
    <div class="table-box">
        <h2>Notes :</h2>
        <form method="POST" action="">
            <input type="hidden" name="idEval" value="<?= htmlspecialchars($modeleeval['IdModeleEval'], ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="noteCritere" value="<?= htmlspecialchars($modeleeval['typeEnseignant'], ENT_QUOTES, 'UTF-8') ?>">
<table>

        <th>Critere</th>
            <th>Description</th>
            <th>Note</th>
        </th>
        <?php foreach ($critereseval as $c): ?>
            <tr>
                <td><?= $c['descCourte'] ?></td>
                <td><?= $c['descLongue'] ?></td>
                <td class="slider-box">
                    <div>    
                        <input type="range" name="notes[<?= $c['IdCritere'] ?>]" id="slider-<?= $c['IdCritere'] ?>" value="0" min="0" max="<?= $c["noteCritere"] ?>" step='0.25' />
                    </div>
                    <div>
                        <span id="value-<?= $c['IdCritere'] ?>"></span>/<span class="max-value" id="max-value-<?= $c['IdCritere'] ?>"></span></td>
                    </div>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>

    <label for="">Note calculée</label>
    <label for="" class>0.0 / 0.0</label>

    <script>
        <?php foreach ($critereseval as $c): ?>
            var slider<?= $c['IdCritere'] ?> = document.getElementById("slider-<?= $c['IdCritere'] ?>");
            var output<?= $c['IdCritere'] ?> = document.getElementById("value-<?= $c['IdCritere'] ?>");
            var maxValue<?= $c['IdCritere'] ?> = document.getElementById("max-value-<?= $c['IdCritere'] ?>");

            maxValue<?= $c['IdCritere'] ?>.innerHTML = <?= $c['noteCritere']?>;
            output<?= $c['IdCritere'] ?>.innerHTML = slider<?= $c['IdCritere'] ?>.value;
            slider<?= $c['IdCritere'] ?>.oninput = function() {
                output<?= $c['IdCritere'] ?>.innerHTML = this.value;
            };
        <?php endforeach; ?>
    </script>

    <div class="feedback-box">
        <h2>Feedback :</h2>
        <textarea name="feedback"><?=$feedback["commentaireJury"]?></textarea>
    </div>
</div>

<div class="save-bar">
        <button type="submit" name="Enregistrer" value="Enregistrer">Enregistrer</button>
        <button type="submit" name="validate" value="validate">Valider</button>
</div>
</form>

<!-- http://localhost/SaisiesNotesIntranet/view/grilleEval/show.php -->
