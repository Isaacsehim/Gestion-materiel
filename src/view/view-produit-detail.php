<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once(SRC_PATH . '/template/header.php');
require_once(SRC_PATH . '/template/sidebar.php');

if (empty($produit)) : ?>
    <main class="container">
        <h1>Détail produit</h1>
        <div class="message-erreur text-centre">
            <i class="fas fa-times-circle"></i> Produit introuvable ou supprimé.
        </div>
    </main>
<?php else: ?>
<main class="container">
    <h1><?= htmlspecialchars($produit['produit_denomination']) ?></h1>

    <div class="produit-detail-grid">
        <div class="produit-detail-photo">
            <?php if (!empty($produit['produit_photo'])): ?>
                <img src="/<?= htmlspecialchars($produit['produit_photo']) ?>"
                     alt="photo produit">
            <?php else: ?>
                <span>–</span>
            <?php endif; ?>
        </div>
        <div class="produit-detail-infos">
            <ul class="table-liste">
                <li><strong>Catégorie :</strong> <?= htmlspecialchars($produit['categorie_nom'] ?? '-') ?></li>
                <li><strong>Code-barres :</strong> <?= htmlspecialchars($produit['produit_code_barres']) ?></li>
                <li><strong>Marque / Modèle :</strong> <?= htmlspecialchars($produit['produit_marque_modele'] ?? '-') ?></li>
                <li><strong>Numéro de série :</strong> <?= htmlspecialchars($produit['produit_numero_serie'] ?? '-') ?></li>
                <li><strong>Description :</strong> <?= nl2br(htmlspecialchars($produit['produit_description'] ?? '-')) ?></li>
                <li><strong>Date d’arrivée :</strong> <?= !empty($produit['produit_date_arrivee']) ? date('d/m/Y', strtotime($produit['produit_date_arrivee'])) : '-' ?></li>
                <li><strong>Fournisseur :</strong> <?= htmlspecialchars($produit['fournisseur_nom'] ?? '-') ?></li>
                <li><strong>Quantité :</strong> <?= htmlspecialchars($produit['produit_quantite'] ?? 1) ?></li>
                <li><strong>Valeur estimée :</strong> <?= isset($produit['produit_valeur_estimee']) ? number_format($produit['produit_valeur_estimee'], 2, ',', ' ') . ' €' : '-' ?></li>
                <li><strong>Garantie jusqu’au :</strong> <?= !empty($produit['produit_garantie_fin']) ? date('d/m/Y', strtotime($produit['produit_garantie_fin'])) : '-' ?></li>
            </ul>
        </div>
    </div>

    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php
                require_once(SRC_PATH . '/model/model-favoris.php');
                $isFav = isFavori($_SESSION['user_id'], $produit['id_produits']);
            ?>
            <form method="post" action="">
                <input type="hidden" name="id_produit" value="<?= $produit['id_produits'] ?>">
                <?php if (!$isFav): ?>
                    <button type="submit" name="fav_action" value="add" class="btn" title="Ajouter aux favoris">
                        <i class="fas fa-star" style="color: #aaa;"></i> Ajouter aux favoris
                    </button>
                <?php else: ?>
                    <button type="submit" name="fav_action" value="remove" class="btn bouton-secondaire" title="Retirer des favoris">
                        <i class="fas fa-star" style="color: #ffd700;"></i> Retirer des favoris
                    </button>
                <?php endif; ?>
            </form>
        <?php endif; ?>

        <?php if (isset($_SESSION['niveau']) && in_array($_SESSION['niveau'], ['admin', 'user'])): ?>
            <a href="/?page=modifier-produit&id=<?= $produit['id_produits'] ?>" class="btn btn-update" title="Modifier le produit">
                <i class="fa fa-pen"></i> Modifier
            </a>
            <a href="/?page=supprimer-produit&id=<?= $produit['id_produits'] ?>" class="btn btn-delete" title="Supprimer le produit" onclick="return confirm('Supprimer ce produit ? Cette action est irréversible.');">
                <i class="fa fa-trash"></i> Supprimer
            </a>
        <?php endif; ?>
    </div>

    <div>
        <a href="/?page=produits" class="btn bouton-secondaire"><i class="fa fa-arrow-left"></i> Retour à la liste</a>
    </div>
</main>
<?php endif; ?>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
