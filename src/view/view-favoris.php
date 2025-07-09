<?php

require_once(SRC_PATH . '/template/header.php');
require_once(SRC_PATH . '/template/sidebar.php');
?>

<main class="section container-bento">
  <section class="card">
    <h1 class="titre-section">Mes Favoris</h1>
    <p class="message-info text-centre" role="status" tabindex="0">Retrouvez ici vos produits ajoutés en favoris pour un accès rapide.</p>

    <?php if (empty($favoris)): ?>
      <div class="message-info" role="status" tabindex="0">
        <i class="icone"></i> Vous n’avez pas encore de favoris.<br>
        Ajoutez-en depuis la liste des produits !
      </div>
    <?php else: ?>
      <div class="grille-3">
        <?php foreach ($favoris as $produit): ?>
          <div class="card">
            <a href="/?page=produit-detail&id=<?= urlencode($produit['id_produits']) ?>" tabindex="0">
              <img class="produit-detail-photo" src="<?= htmlspecialchars($produit['produit_photo'] ?? '/assets/images/produits/default.jpg') ?>"
                   alt="Photo de <?= htmlspecialchars($produit['produit_denomination']) ?>" loading="lazy">
            </a>
            <div class="produit-detail-infos">
              <h3 class="user-name">
                <a href="/?page=produit-detail&id=<?= urlencode($produit['id_produits']) ?>" tabindex="0">
                  <?= htmlspecialchars($produit['produit_denomination']) ?>
                </a>
              </h3>
              <p class="user-info">
                <strong>Catégorie :</strong> <?= htmlspecialchars($produit['categorie_nom'] ?? '-') ?><br>
                <strong>Code-barres :</strong> <?= htmlspecialchars($produit['produit_code_barres'] ?? '-') ?>
              </p>
              <div class="flex justify-between items-center">
                <a class="btn btn-secondaire" href="/?page=produit-detail&id=<?= urlencode($produit['id_produits']) ?>" tabindex="0">
                  Voir le détail
                </a>
                <form method="post" action="/?page=favoris" class="formulaire-modif">
                  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                  <input type="hidden" name="id_produit" value="<?= htmlspecialchars($produit['id_produits']) ?>">
                  <button type="submit" name="action" value="remove" class="btn btn-delete" title="Retirer des favoris" tabindex="0">
                    <i class="icone"></i> Retirer
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
