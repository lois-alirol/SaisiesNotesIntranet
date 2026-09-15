<!--Affiche le planning-->
<h2>Planning</h2>
<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Horraire</th>
        <th>Salles</th>
        <th>Tuteur</th>
        <th>Professeur supléant</th>
        <th>Élève</th>
        <th>Entreprise</th> 
    </tr>
    </thead>
    <tbody>
    <?php foreach (($plannings) as $planning): ?>
        <tr>
            <td><?= $planning['date'] ?></td>
            <td><?= $planning['heure'] ?></td>
            <td><?= $planning['salle'] ?></td>
            <td><?= $planning['professeur_1'] ?></td>
            <td><?= $planning['professeur_2'] ?></td>
            <td><?= $planning['eleve'] ?></td>
            <td><?= $planning['entreprise'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!--Affiche le planning pour les evals d'Anglais-->
<h2>Planning Anglais</h2>
<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Horraire</th>
        <th>Salles</th>
        <th>Tuteur</th>
        <th>Élève</th>
        <th>Entreprise</th> 
    </tr>
    </thead>
    <tbody>
    <?php foreach ($planningsAnglais as $planningAnglais): ?>
        <tr>
            <td><?= $planningAnglais['date'] ?></td>
            <td><?= $planningAnglais['heure'] ?></td>
            <td><?= $planningAnglais['salle'] ?></td>
            <td><?= $planningAnglais['professeur_1'] ?></td>
            <td><?= $planningAnglais['eleve'] ?></td>
            <td><?= $planningAnglais['entreprise'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>