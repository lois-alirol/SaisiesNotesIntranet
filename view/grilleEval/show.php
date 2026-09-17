<!--AFFICHAGE DU TABLEAU DES CRITERES-->

<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" type="text/css" href="public/css/grilleEval.css">

<h2>Grille d'évaluation</h2>

<p>Cours : <?= $modeleeval["natureGrille"]?></p>
<p>Devoir : <?= $modeleeval["nomModuleGrilleEvaluation"]?></p>

<form method="POST" action="">
    <input type="hidden" name="idEval" value="<?= htmlspecialchars($modeleeval['IdModeleEval'], ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="noteCritaire" value="<?= htmlspecialchars($modeleeval['typeEnseignant'], ENT_QUOTES, 'UTF-8') ?>">
<table>
<!--AJOUT D'UNE LIGNE POUR CHAQUE $c DANS LE TABLEAU $critereseval-->

<th>Critere</th>
    <th>Description</th>
    <th>Note max</th>
    <th>Note</th>
</th>
<?php foreach ($critereseval as $c): ?>
    <tr>
        <td><?= $c['descCourte'] ?></td>
        <td><?= $c['descLongue'] ?></td>
        <td><span id="max-value-<?= $c['IdCritere'] ?>"></span></td>
        <td><input type="range" name="notes[<?= $c['IdCritere'] ?>]" id="slider-<?= $c['IdCritere'] ?>" value="0" min="0" max="<?= $c["noteCritere"] ?>" step='0.25' /><br><span id="value-<?= $c['IdCritere'] ?>"></td>
    </tr>
<?php endforeach; ?>
</table>

<label for="statusEvaluation">Statut du flux d'évaluation</label>
<select name="statusEvaluation" id="statusEvaluation">
  <option value="published">Saisi</option>
  <option value="published">Validé</option>
  <option value="published">Bloqué</option>
  <option value="published">Diffusé</option>
</select> 

<br> <!-- JE METTRAIS EN DISPLAY FLEX APRES -->

<label for="">Évaluateur attribué</label>
<select name="" id="">
</select>

<br> <!-- JE METTRAIS EN DISPLAY FLEX APRES -->

<label for="note">Note actuelle dans le carnet de notes</label>
<br>
<label name="note">0.0</label>

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

<div>
    <textarea name="feedback"><?=$feedback?></textarea>
</div>

<div>
        <button type="submit" name="Enregistrer" value="Enregistrer">Enregistrer</button>
        <button type="submit" name="validate" value="validate">Valider</button>
</div>
</form>

<!-- http://localhost/SaisiesNotesIntranet/view/grilleEval/show.php -->
