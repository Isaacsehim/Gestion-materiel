<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container-bento section">
  <section class="card">
    <h1 class="titre-section" tabindex="0">Archives Produits</h1>

    <section class="section-formulaire">
      <?php require(SRC_PATH . '/components/search-bar.php'); ?>
      <form method="get" class="formulaire-ajout">
        <div class="champ-formulaire">
          <label for="fournisseur" class="label-formulaire">Fournisseur :</label>
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
          <label for="tri" class="label-formulaire">Trier par :</label>
          <select name="tri" id="tri" class="champ-formulaire" onchange="this.form.submit()">
            <option value="nom" <?= ($_GET['tri'] ?? '') === 'nom' ? 'selected' : '' ?>>Nom</option>
            <option value="date" <?= ($_GET['tri'] ?? '') === 'date' ? 'selected' : '' ?>>Date d'ajout</option>
          </select>
        </div>
        <div class="champ-formulaire">
          <label for="ordre" class="label-formulaire">Ordre :</label>
          <select name="ordre" id="ordre" class="champ-formulaire" onchange="this.form.submit()">
            <option value="asc" <?= ($_GET['ordre'] ?? '') === 'asc' ? 'selected' : '' ?>>Croissant</option>
            <option value="desc" <?= ($_GET['ordre'] ?? '') === 'desc' ? 'selected' : '' ?>>Décroissant</option>
          </select>
        </div>
        <noscript><button type="submit" class="btn btn-validation">Filtrer</button></noscript>
      </form>
    </section>

    <a href="/?page=produits" class="btn btn-secondaire" tabindex="0">Retour aux produits actifs</a>

    <section class="section">
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
                    <img src="/<?= htmlspecialchars($prod['produit_photo']) ?>" alt="photo" loading="lazy">
                  <?php else: ?>
                    <span class="message-info">-</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($prod['produit_denomination'] ?? $prod['nom'] ?? '') ?></td>
                <td><?= htmlspecialchars($prod['id_categories'] ?? '-') ?></td>
                <td><?= htmlspecialchars($prod['fournisseur_nom'] ?? '-') ?></td>
                <td><?= htmlspecialchars($prod['produit_description'] ?? $prod['description'] ?? '') ?></td>
                <td><?= !empty($prod['produit_date_arrivee']) ? date('d/m/Y', strtotime($prod['produit_date_arrivee'])) : '-' ?></td>
                <td class="flex flex-row items-center justify-between">
                  <a href="/?page=modifier-produit&id=<?= htmlspecialchars($prod['id_produits'] ?? $prod['id_produit']) ?>" class="btn btn-update" tabindex="0">
                    Modifier
                  </a>
                  <a href="/?page=supprimer-produit&id=<?= htmlspecialchars($prod['id_produits'] ?? $prod['id_produit']) ?>" class="btn btn-delete btn-danger" tabindex="0" onclick="return confirm('Supprimer ce produit ?');">
                    Supprimer
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($produits)): ?>
              <tr>
                <td colspan="7" class="message-info" tabindex="0">Aucun produit trouvé.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>