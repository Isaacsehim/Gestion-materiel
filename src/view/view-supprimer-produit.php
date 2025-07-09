<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container-bento">
  <section class="card">
    <h1 class="titre-section">Suppression du produit</h1>

    <?php if (!empty($erreur)): ?>
      <div class="message-erreur">
        <?= htmlspecialchars($erreur) ?>
      </div>
    <?php else: ?>
      <p class="text-centre">
        Êtes-vous sûr de vouloir supprimer le produit <strong><?= htmlspecialchars($produit['produit_denomination']) ?></strong> ?
      </p>

      <div class="flex justify-between items-center">
        <a href="/?page=supprimer-produit&id=<?= $produit['id_produits'] ?>&confirm=oui" class="btn btn-danger" tabindex="0">
          <i class="fa fa-trash"></i> Oui, supprimer
        </a>
        <a href="/?page=produits" class="btn btn-secondaire" tabindex="0">
          <i class="fa fa-times"></i> Annuler
        </a>
      </div>
    <?php endif; ?>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>