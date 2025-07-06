<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container">
    <h1>Produits</h1>

    <section>
        <?php require(SRC_PATH . '/components/search-bar.php'); ?>

        <form method="get" class="row">
            <input type="hidden" name="page" value="produits">

            <div>
                <label for="fournisseur">Fournisseur :</label>
                <select name="fournisseur" id="fournisseur" onchange="this.form.submit()">
                    <option value="">Tous</option>
                    <?php foreach ($fournisseurs as $f): ?>
                        <option value="<?= htmlspecialchars($f['id_fournisseurs']) ?>"
                            <?= (($_GET['fournisseur'] ?? '') == $f['id_fournisseurs']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($f['fournisseur_nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="lieu">Lieu :</label>
                <select name="lieu" id="lieu" onchange="this.form.submit()">
                    <option value="">Tous</option>
                    <?php foreach ($lieux as $l): ?>
                        <option value="<?= htmlspecialchars($l['id_lieux']) ?>"
                            <?= (($_GET['lieu'] ?? '') == $l['id_lieux']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($l['lieu_nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="tri">Trier par :</label>
                <select name="tri" id="tri" onchange="this.form.submit()">
                    <option value="date" <?= ($_GET['tri'] ?? 'date') === 'date' ? 'selected' : '' ?>>Date d'ajout</option>
                    <option value="nom" <?= ($_GET['tri'] ?? '') === 'nom' ? 'selected' : '' ?>>Nom</option>
                </select>
            </div>
            <div>
                <label for="ordre">Ordre :</label>
                <select name="ordre" id="ordre" onchange="this.form.submit()">
                    <option value="desc" <?= ($_GET['ordre'] ?? 'desc') === 'desc' ? 'selected' : '' ?>>⬇️</option>
                    <option value="asc" <?= ($_GET['ordre'] ?? '') === 'asc' ? 'selected' : '' ?>>⬆️</option>
                </select>
            </div>
            <div>
                <label for="dispo">
                    <input type="checkbox" name="dispo" value="1" id="dispo" onchange="this.form.submit()"
                        <?= !empty($_GET['dispo']) ? 'checked' : '' ?>>
                    Uniquement disponibles
                </label>
            </div>
            <noscript><button type="submit">Filtrer</button></noscript>
            <div>
                <a href="/?page=produits" class="btn bouton-secondaire">
                    Réinitialiser les filtres
                </a>
            </div>
        </form>
    </section>

    <div>
        <a href="/?page=ajouter-produit" class="bouton btn-update">
            <i class="fa fa-plus"></i> Nouveau produit
        </a>
    </div>
    <a href="/?page=produits-archive" class="btn bouton-secondaire">Voir les archives produits</a>

    <section>
        <div class="table-responsive">
            <table class="table-liste">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Fournisseur</th>
                        <th>Description</th>
                        <th>Date d'ajout</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $prod): ?>
                        <tr>
                            <td>
                                <?php if (!empty($prod['produit_photo'])): ?>
                                    <img src="/<?= htmlspecialchars($prod['produit_photo']) ?>" alt="photo">
                                <?php else: ?>
                                    <span>–</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/?page=produit-detail&id=<?= $prod['id_produits'] ?>">
                                    <?= htmlspecialchars($prod['produit_denomination'] ?? $prod['nom'] ?? '') ?>
                                </a>
                            </td>
                            <td>
                                <?= htmlspecialchars($prod['categorie_nom'] ?? '-') ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($prod['fournisseur_nom'] ?? '-') ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($prod['produit_description'] ?? $prod['description'] ?? '') ?>
                            </td>
                            <td>
                                <?= !empty($prod['produit_date_arrivee']) ? date('d/m/Y', strtotime($prod['produit_date_arrivee'])) : '-' ?>
                            </td>
                            <td>
                                <a href="/?page=update-produit&id=<?= $prod['id_produits'] ?>" class="btn-update" title="Modifier">✏️</a>
                                <a href="/?page=supprimer-produit&id=<?= $prod['id_produits'] ?>" class="btn-delete" title="Supprimer">🗑️</a>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <?php
                                    require_once(SRC_PATH . '/model/model-favoris.php');
                                    $isFav = isFavori($_SESSION['user_id'], $prod['id_produits']);
                                    ?>
                                    <form method="post" action="">
                                        <input type="hidden" name="id_produit" value="<?= $prod['id_produits'] ?>">
                                        <?php if (!$isFav): ?>
                                            <button type="submit" name="fav_action" value="add" title="Ajouter aux favoris">
                                                <i class="fas fa-star" style="color: #aaa;"></i>
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" name="fav_action" value="remove" title="Retirer des favoris">
                                                <i class="fas fa-star" style="color: #ffd700;"></i>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($produits)): ?>
                        <tr>
                            <td colspan="7" class="text-centre">Aucun produit trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>