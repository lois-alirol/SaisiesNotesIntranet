<?php

$dates = array_unique(array_column($plannings, 'date'));
sort($dates);

$datesAnglais = array_unique(array_column($planningsAnglais, 'date'));
sort($datesAnglais);

sort($salles);
?>



<link rel="stylesheet" href="/public/css/planning.css">

<!--Dropdown pour selection la date a afficher-->
<label for="dateSlct">Date :</label>
<select name="dateSlct" id="dateSlct">
    <option value="">Toutes</option>
    <?php foreach ($dates as $date): ?>
        <option value="<?= htmlspecialchars($date) ?>"> 
            <?= htmlspecialchars($date) ?>
        </option>
    <?php endforeach; ?>
    <?php foreach ($datesAnglais as $date): ?>
        <option value="<?= htmlspecialchars($date) ?>">
            <?= htmlspecialchars($date) ?>
        </option>
    <?php endforeach; ?>
</select>

<!--Check Box pour afficher ou non le planning d'anglais-->
<?php if (!empty($planningsAnglais)): ?>
    <input type="checkbox" id="anglaisToggle" />
    <label for="anglaisToggle" id="texte">Planning Anglais</label>
<?php endif; ?>
<!--Planning pour les Soutenances-->
<div id="planning-general">

<h2>Planning Soutenance</h2>

<?php foreach ($dates as $curdate): ?>

    <?php
    $heures = [];

    foreach ($plannings as $planning) {
        if ($planning['date'] === $curdate) {
            $heures[] = $planning['heure'];
        }
    }

    $heures = array_unique($heures);


    sort($heures);

    ?>

    <table class="planning" data-date="<?= htmlspecialchars($curdate) ?>">
        <thead>
            <tr class="planning-date">
                <th colspan="<?= count($salles) + 1 ?>">
                    <?php if (!empty($plannings)): ?>
                        <?= date('d/m/Y', strtotime($curdate)) ?>
                    <?php endif; ?>
                </th>
            </tr>
            <tr class="planning-header">
                <th class="colonne-heure">
                    Heures de passage
                </th>
                <?php foreach ($salles as $salle): ?>
                    <th>
                        <?= htmlspecialchars($salle) ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($heures as $heure): ?>
                <tr>
                    <td class="heure">
                        <?= date('H:i', strtotime($heure)) ?>
                    </td>
                    <?php foreach ($salles as $salle): ?>
                        <td class="planning-cell">
                            <?php foreach ($plannings as $planning): ?>
                                <?php if (
                                    $planning['heure'] === $heure &&
                                    $planning['salle'] === $salle &&
                                    $planning['date'] === $curdate
                                ): ?>
                                    <div class="passage">
                                        <strong>
                                            <?= htmlspecialchars($planning['eleve']) ?>
                                        </strong>
                                        <br>
                                        <?= htmlspecialchars($planning['professeur_1']) ?>
                                        <?php if (!empty($planning['professeur_2'])): ?>
                                            <br>
                                            <?= htmlspecialchars($planning['professeur_2']) ?>
                                        <?php endif; ?>
                                        <?php if (!empty($planning['entreprise'])): ?>
                                            <br>
                                            <em>
                                                <?= htmlspecialchars($planning['entreprise']) ?>
                                            </em>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endforeach ?>

</div>

<!--Planning pour les evals d'Anglais-->
<div id="planning-anglais">
<?php if (!empty($planningsAnglais)): ?>

    <h2>Planning Anglais</h2>
    <?php



    foreach ($datesAnglais as $curdate):
    ?>

        <?php
        $heures = [];

        foreach ($planningsAnglais as $planning) {
            if ($planning['date'] === $curdate) {
                $heures[] = $planning['heure'];
            }
        }

        $heures = array_unique($heures);

        sort($heures);
        ?>

        <table class="planning" data-date="<?= htmlspecialchars($curdate) ?>">
            <thead>
                <tr class="planning-date">
                    <th colspan="<?= count($salles) + 1 ?>">
                        <?php if (!empty($planningsAnglais)): ?>
                            <?= date('d/m/Y', strtotime($curdate)) ?>
                        <?php endif; ?>
                    </th>
                </tr>
                <tr class="planning-header">
                    <th class="colonne-heure">
                        Heures de passage
                    </th>
                    <?php foreach ($salles as $salle): ?>
                        <th>
                            <?= htmlspecialchars($salle) ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($heures as $heure): ?>
                    <tr>
                        <td class="heure">
                            <?= date('H:i', strtotime($heure)) ?>
                        </td>
                        <?php foreach ($salles as $salle): ?>
                            <td class="planning-cell">
                                <?php foreach ($planningsAnglais as $planning): ?>
                                    <?php if (
                                        $planning['heure'] === $heure &&
                                        $planning['salle'] === $salle &&
                                        $planning['date'] === $curdate
                                    ): ?>
                                        <div class="passage">
                                            <strong>
                                                <?= htmlspecialchars($planning['eleve']) ?>
                                            </strong>
                                            <br>
                                            <?= htmlspecialchars($planning['professeur_1']) ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach ?>
<?php endif; ?>

</div>


<script>    
    const selectDate = document.getElementById('dateSlct');

    selectDate.addEventListener('change', function() {
        const dateSelectionnee = this.value;

        console.log(dateSelectionnee);
    });

    const plannings = document.querySelectorAll('.planning');

    selectDate.addEventListener('change', function() {
        const dateSelectionnee = this.value;

        plannings.forEach(function(planning) {
            const datePlanning = planning.dataset.date;

            if (dateSelectionnee === "" || datePlanning === dateSelectionnee)
            {
                planning.style.display = "";
            } 
            else 
            {
                planning.style.display = "none";
            }
        });
    });

    <?php if (!empty($planningsAnglais)): ?>
    const anglaisToggle = document.getElementById('anglaisToggle');
    const divGeneral = document.getElementById('planning-general');
    const divAnglais = document.getElementById('planning-anglais');
    divAnglais.style.display = "none";


    anglaisToggle.addEventListener('change', function() {

        if (this.checked) 
        {
            divGeneral.style.display = "none";
            divAnglais.style.display = "";
        } 
        else
        {
            divGeneral.style.display = "";
            divAnglais.style.display = "none";
        }
    });

    <?php endif; ?>

</script>
