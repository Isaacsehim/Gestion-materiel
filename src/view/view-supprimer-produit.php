<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container section">
  <h1>Suppression du produit</h1>

  <?php if (!empty($erreur)): ?>
    <div class="message-erreur"><?= htmlspecialchars($erreur) ?></div>
  <?php else: ?>
    <p>Êtes-vous sûr de vouloir supprimer le produit <strong><?= htmlspecialchars($produit['produit_denomination']) ?></strong> ?</p>
    <p class="marge-haut">
      <a href="/?page=supprimer-produit&id=<?= $produit['id_produits'] ?>&confirm=oui" class="bouton bouton-danger">Oui, supprimer</a>
      <a href="/?page=produits" class="bouton bouton-secondaire">Annuler</a>
    </p>
  <?php endif; ?>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
