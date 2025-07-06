<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once(SRC_PATH . '/template/header.php');
require_once(SRC_PATH . '/template/sidebar.php');
?>

<div class="container marge-haut marge-bas">
    <h1>Mes Favoris</h1>
    <p class="text-centre">Retrouvez ici vos produits ajoutés en favoris pour un accès rapide.</p>

    <?php if (empty($favoris)): ?>
        <div class="message-info text-centre marge-haut">
            <i class="fas fa-info-circle"></i> Vous n’avez pas encore de favoris.<br>
            Ajoutez-en depuis la liste des produits !
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($favoris as $produit): ?>
                <div class="col col-4">
                    <div class="user-card">
                        <a href="/?page=produit-detail&id=<?= urlencode($produit['id_produits']) ?>">
                            <img src="<?= htmlspecialchars($produit['produit_photo'] ?? '/assets/images/produits/default.jpg') ?>"
                                 alt="<?= htmlspecialchars($produit['produit_denomination']) ?>">
                        </a>
                        <div class="user-info">
                            <h3>
                                <a href="/?page=produit-detail&id=<?= urlencode($produit['id_produits']) ?>">
                                    <?= htmlspecialchars($produit['produit_denomination']) ?>
                                </a>
                            </h3>
                            <p>
                                <strong>Catégorie :</strong> <?= htmlspecialchars($produit['categorie_nom'] ?? '-') ?><br>
                                <strong>Code-barres :</strong> <?= htmlspecialchars($produit['produit_code_barres'] ?? '-') ?>
                            </p>
                            <a class="btn" href="/?page=produit-detail&id=<?= urlencode($produit['id_produits']) ?>">
                                Voir le détail
                            </a>
                            <form method="post" action="/?page=favoris">
                                <input type="hidden" name="id_produit" value="<?= htmlspecialchars($produit['id_produits']) ?>">
                                <button type="submit" name="action" value="remove" class="btn-delete" title="Retirer des favoris">
                                    <i class="fas fa-star"></i> Retirer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
