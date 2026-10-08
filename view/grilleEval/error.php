<div class="div-error">
    <h2>Il y a un problème !</h2>
    <?php $result = "Erreur " . substr($result, 36, -1)?>
    <p><?= htmlspecialchars($result) ?></p>
</div>