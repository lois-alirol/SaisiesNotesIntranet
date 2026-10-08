<?php

require_once 'util/Helper.php';
?>

<div>
    <?php foreach ($etudiants as $etudiant): ?>
        <p><?php echo $etudiant['nom'] . ' ' . $etudiant['prenom']; ?></p>
    <?php endforeach; ?>
</div>