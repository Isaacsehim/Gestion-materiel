<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(__DIR__ . '/../template/sidebar.php'); ?>

<main class="container-bento section-formulaire">
  <section class="card">
    <h1 class="titre-formulaire">Modifier le produit</h1>

    <?php if (!empty($erreur)): ?>
      <div class="message-erreur text-centre"><?= htmlspecialchars($erreur) ?></div>
    <?php elseif (!empty($success)): ?>
      <div class="message-info text-centre"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($produit): ?>
    <form method="POST" enctype="multipart/form-data" class="formulaire-modif">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

      <div class="champ-formulaire">
        <label for="nom" class="label-formulaire">Nom du produit <span>*</span></label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($produit['produit_denomination']) ?>" required>
      </div>

      <div class="champ-formulaire">
        <label for="description" class="label-formulaire">Description</label>
        <textarea id="description" name="description" rows="3"><?= htmlspecialchars($produit['produit_description']) ?></textarea>
      </div>

      <div class="champ-formulaire">
        <label for="categorie" class="label-formulaire">Catégorie <span>*</span></label>
        <select id="categorie" name="categorie" required>
          <option value="">Sélectionner…</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id_categories'] ?>" <?= ($produit['id_categories'] == $cat['id_categories']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['categorie_nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="champ-formulaire">
        <label for="etat" class="label-formulaire">État <span>*</span></label>
        <select id="etat" name="etat" required>
          <option value="">Sélectionner…</option>
          <?php foreach ($etats as $etat): ?>
            <option value="<?= $etat['id_etats'] ?>" <?= ($produit['id_etats'] == $etat['id_etats']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($etat['etat_libelle']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur" class="label-formulaire">Fournisseur</label>
        <select id="fournisseur" name="fournisseur">
          <option value="">Aucun</option>
          <?php foreach ($fournisseurs as $f): ?>
            <option value="<?= $f['id_fournisseurs'] ?>" <?= ($produit['id_fournisseurs'] == $f['id_fournisseurs']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($f['fournisseur_nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="champ-formulaire">
        <label for="image" class="label-formulaire">Photo</label>
        <?php if (!empty($produit['produit_photo'])): ?>
          <div class="produit-detail-photo">
            <img src="/<?= htmlspecialchars($produit['produit_photo']) ?>" alt="photo actuelle" loading="lazy">
          </div>
        <?php endif; ?>
        <input type="file" id="image" name="image" accept="image/*">
      </div>

      <div class="champ-formulaire flex justify-between">
        <button type="submit" class="btn btn-validation" tabindex="0">Enregistrer</button>
        <a href="/?page=produits" class="btn btn-secondaire" tabindex="0">Annuler</a>
      </div>
    </form>
    <?php endif; ?>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>