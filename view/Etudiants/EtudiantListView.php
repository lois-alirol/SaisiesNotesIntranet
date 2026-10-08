<?php
require_once 'util/Helper.php';
?>

<link rel="stylesheet" href="/public/css/listEtu.css">

<div class="list-etu-container">
    <?php foreach ($etudiants as $etudiant): ?>
        <div class="list-etu-carte">
            <a href="/historique?etudiant=<?php echo $etudiant['IdEtudiant']; ?>" class="list-etu-lien">
                <span><?php echo htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']); ?></span>
                <span class="etu-fleche">→</span>
            </a>
        </div>
    <?php endforeach; ?>
</div>