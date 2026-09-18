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
            <p>Nom de l'élève</p>
        </div>
    </div>
</div>

<div class="content">
    <div class="table-box">
        <h2>Notes :</h2>
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
                        <input type="range" id="slider-<?= $c['IdCritere'] ?>" value="0" min="0" max="<?= $c["noteCritere"] ?>" step='0.1' />
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
        <textarea><?=$feedback["commentaireJury"]?></textarea>
    </div>
</div>

<div class="save-bar">
    <button>Enregistrer</button>
    <button>Valider</button>
</div>

<!-- http://localhost/SaisiesNotesIntranet/view/grilleEval/show.php -->