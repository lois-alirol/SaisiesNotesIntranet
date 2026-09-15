<!--AFFICHAGE DU TABLEAU DES CRITERES-->

<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" type="text/css" href="public/css/grilleEval.css">

<h2>Grille d'évaluation</h2>

<p>Cours : <?= $modeleeval["natureGrille"]?></p>
<p>Devoir : <?= $modeleeval["nomModuleGrilleEvaluation"]?></p>

<table>
<!--AJOUT D'UNE LIGNE POUR CHAQUE $c DANS LE TABLEAU $critereseval-->

<th>Critere</th>
    <th>Description</th>
    <th>Commentaire</th>
</th>
<?php foreach ($critereseval as $c): ?>
    <tr>
        <td><?= $c['descCourte'] ?></td>
        <td><?= $c['descLongue'] ?><br><span id="value-<?= $c['IdCritere'] ?>"></span><br><input type="range" id="slider-<?= $c['IdCritere'] ?>" value="0" min="0" max="<?= $c["noteCritere"] ?>" step='0.25' /></td>
        <td><textarea></textarea></td>
    </tr>
<?php endforeach; ?>
</table>

<script>
    <?php foreach ($critereseval as $c): ?>
        var slider<?= $c['IdCritere'] ?> = document.getElementById("slider-<?= $c['IdCritere'] ?>");
        var output<?= $c['IdCritere'] ?> = document.getElementById("value-<?= $c['IdCritere'] ?>");
        output<?= $c['IdCritere'] ?>.innerHTML = slider<?= $c['IdCritere'] ?>.value;
        slider<?= $c['IdCritere'] ?>.oninput = function() {
            output<?= $c['IdCritere'] ?>.innerHTML = this.value;
        };
    <?php endforeach; ?>
</script>

<!-- http://localhost/SaisiesNotesIntranet/view/grilleEval/show.php -->