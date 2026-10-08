<?php
require_once 'util/Helper.php';
?>

<link rel="stylesheet" href="/public/css/listEtu.css">

<input type="text" id="searchInput" placeholder="Rechercher un étudiant..." onkeyup="filterEtudiants()">

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


<script>
function filterEtudiants() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase().trim();

    const cartes = document.querySelectorAll('.list-etu-carte');

    cartes.forEach(carte => {
        const nomPrenom = carte.textContent.toLowerCase();
        if (nomPrenom.includes(filter)) {
            carte.style.display = "";
        } else {
            carte.style.display = "none";
        }
    });
}
</script>