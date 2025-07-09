<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container-bento section">
  <h1 class="titre-section">Produits</h1>

  <section class="section-formulaire card">
    <?php require(SRC_PATH . '/components/search-bar.php'); ?>

    <form method="get" class="formulaire-ajout">
      <input type="hidden" name="page" value="produits">

      <div class="champ-formulaire">
        <label class="label-formulaire" for="fournisseur">Fournisseur :</label>
        <select name="fournisseur" id="fournisseur" class="champ-formulaire" onchange="this.form.submit()">
          <option value="">Tous</option>
          <?php foreach ($fournisseurs as $f): ?>
            <option value="<?= htmlspecialchars($f['id_fournisseurs']) ?>"
              <?= (($_GET['fournisseur'] ?? '') == $f['id_fournisseurs']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($f['fournisseur_nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="champ-formulaire">
        <label class="label-formulaire" for="lieu">Lieu :</label>
        <select name="lieu" id="lieu" class="champ-formulaire" onchange="this.form.submit()">
          <option value="">Tous</option>
          <?php foreach ($lieux as $l): ?>
            <option value="<?= htmlspecialchars($l['id_lieux']) ?>"
              <?= (($_GET['lieu'] ?? '') == $l['id_lieux']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($l['lieu_nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="champ-formulaire">
        <label class="label-formulaire" for="tri">Trier par :</label>
        <select name="tri" id="tri" class="champ-formulaire" onchange="this.form.submit()">
          <option value="date" <?= ($_GET['tri'] ?? 'date') === 'date' ? 'selected' : '' ?>>Date d'ajout</option>
          <option value="nom" <?= ($_GET['tri'] ?? '') === 'nom' ? 'selected' : '' ?>>Nom</option>
        </select>
      </div>

      <div class="champ-formulaire">
        <label class="label-formulaire" for="ordre">Ordre :</label>
        <select name="ordre" id="ordre" class="champ-formulaire" onchange="this.form.submit()">
          <option value="desc" <?= ($_GET['ordre'] ?? 'desc') === 'desc' ? 'selected' : '' ?>>▼</option>
          <option value="asc" <?= ($_GET['ordre'] ?? '') === 'asc' ? 'selected' : '' ?>>▲</option>
        </select>
      </div>

      <div class="champ-formulaire">
        <label class="label-formulaire" for="dispo">
          <input type="checkbox" name="dispo" value="1" id="dispo" onchange="this.form.submit()"
            <?= !empty($_GET['dispo']) ? 'checked' : '' ?>>
          Uniquement disponibles
        </label>
      </div>

      <noscript><button type="submit" class="btn btn-validation">Filtrer</button></noscript>
      <div class="champ-formulaire">
        <a href="/?page=produits" class="btn btn-secondaire" tabindex="0">Réinitialiser les filtres</a>
      </div>
    </form>
  </section>

  <div class="flex justify-between items-center card">
    <a href="/?page=ajouter-produit" class="btn btn-validation" tabindex="0">
      <i class="fa fa-plus"></i> Nouveau produit
    </a>
    <a href="/?page=produits-archive" class="btn btn-secondaire" tabindex="0">Voir les archives produits</a>
  </div>

  <section class="card table-responsive">
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
                <img src="/<?= htmlspecialchars($prod['produit_photo']) ?>" alt="photo" loading="lazy">
              <?php else: ?>
                <span class="visuellement-cache">–</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="/?page=produit-detail&id=<?= $prod['id_produits'] ?>" tabindex="0">
                <?= htmlspecialchars($prod['produit_denomination'] ?? $prod['nom'] ?? '') ?>
              </a>
            </td>
            <td><?= htmlspecialchars($prod['categorie_nom'] ?? '-') ?></td>
            <td><?= htmlspecialchars($prod['fournisseur_nom'] ?? '-') ?></td>
            <td><?= htmlspecialchars($prod['produit_description'] ?? $prod['description'] ?? '') ?></td>
            <td><?= !empty($prod['produit_date_arrivee']) ? date('d/m/Y', strtotime($prod['produit_date_arrivee'])) : '-' ?></td>
            <td class="flex flex-row items-center">
              <a href="/?page=update-produit&id=<?= $prod['id_produits'] ?>" class="btn btn-update" title="Modifier" tabindex="0">
                <i class="fa fa-pen"></i>
              </a>
              <a href="/?page=supprimer-produit&id=<?= $prod['id_produits'] ?>" class="btn btn-delete btn-danger" title="Supprimer" tabindex="0">
                <i class="fa fa-trash"></i>
              </a>
              <?php if (isset($_SESSION['user_id'])): ?>
                <?php
                require_once(SRC_PATH . '/model/model-favoris.php');
                $isFav = isFavori($_SESSION['user_id'], $prod['id_produits']);
                ?>
                <form method="post" action="">
                  <input type="hidden" name="id_produit" value="<?= $prod['id_produits'] ?>">
                  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                  <?php if (!$isFav): ?>
                    <button type="submit" name="fav_action" value="add" class="btn" title="Ajouter aux favoris" tabindex="0">
                      <i class="fas fa-star"></i>
                    </button>
                  <?php else: ?>
                    <button type="submit" name="fav_action" value="remove" class="btn btn-danger" title="Retirer des favoris" tabindex="0">
                      <i class="fas fa-star" style="color: gold;"></i>
                    </button>
                  <?php endif; ?>
                </form>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($produits)): ?>
          <tr>
            <td colspan="7" class="message-info">Aucun produit trouvé.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>