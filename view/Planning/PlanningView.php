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