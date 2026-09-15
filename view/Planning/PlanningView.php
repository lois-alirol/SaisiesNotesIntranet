<?php

$dates = array_unique(array_column($plannings, 'date'));
sort($dates);
?>

<link rel="stylesheet" href="/public/css/planning.css">

<h2>Planning</h2>

<?php foreach ($dates as $curdate): ?>

    <?php
    $salles = [];
    $heures = [];

    foreach ($plannings as $planning) {
        if ($planning['date'] === $curdate) {
            $salles[] = $planning['salle'];
            $heures[] = $planning['heure'];
        }
    }

    $salles = array_unique($salles);
    $heures = array_unique($heures);

    sort($salles);
    sort($heures);

    ?>

    <table class="planning">
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


<!--Affiche le planning pour les evals d'Anglais-->


<h2>Planning Anglais</h2>

<?php

$dates = array_unique(array_column($planningsAnglais, 'date'));
sort($dates);

foreach ($dates as $curdate):
?>

    <?php
    $salles = [];
    $heures = [];

    foreach ($planningsAnglais as $planning) {
        if ($planning['date'] === $curdate) {
            $salles[] = $planning['salle'];
            $heures[] = $planning['heure'];
        }
    }

    $salles = array_unique($salles);
    $heures = array_unique($heures);

    sort($salles);
    sort($heures);
    ?>

    <table class="planning">
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