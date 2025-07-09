<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(__DIR__ . '/../template/sidebar.php'); ?>

<main class="section-formulaire container-bento">
  <section class="card">
    <h1 class="alert alerte-succes" role="status">Ajouter un produit</h1>

    <?php if (!empty($erreur)): ?>
      <div class="message-erreur" role="alert">
        <?= htmlspecialchars($erreur) ?>
      </div>
    <?php elseif (!empty($success)): ?>
      <div class="message-info" role="status">
        <?= htmlspecialchars($success) ?>
      </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="formulaire-ajout">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

      <div class="champ-formulaire">
        <label for="nom" class="label-formulaire">Nom du produit <span>*</span></label>
        <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
      </div>

      <div class="champ-formulaire">
        <label for="produit_code_barres" class="label-formulaire">Code-barres <span>*</span></label>
        <input type="text" id="produit_code_barres" name="produit_code_barres" required value="<?= htmlspecialchars($_POST['produit_code_barres'] ?? '') ?>">
      </div>

      <div class="champ-formulaire">
        <label for="description" class="label-formulaire">Description</label>
        <textarea id="description" name="description" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>

      <div class="champ-formulaire">
        <label for="categorie" class="label-formulaire">Catégorie <span>*</span></label>
        <select id="categorie" name="categorie" required>
          <option value="">Sélectionner…</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id_categories'] ?>" <?= (($_POST['categorie'] ?? '') == $cat['id_categories']) ? 'selected' : '' ?>>
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
            <option value="<?= $etat['id_etats'] ?>" <?= (($_POST['etat'] ?? '') == $etat['id_etats']) ? 'selected' : '' ?>>
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
            <option value="<?= $f['id_fournisseurs'] ?>" <?= (($_POST['fournisseur'] ?? '') == $f['id_fournisseurs']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($f['fournisseur_nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="champ-formulaire">
        <label for="image" class="label-formulaire">Photo</label>
        <input type="file" id="image" name="image" accept="image/*">
      </div>

      <div class="flex flex-row justify-between">
        <button type="submit" class="btn btn-validation btn-submit" tabindex="0">Ajouter</button>
        <a href="/?page=produits" class="btn btn-secondaire" tabindex="0">Annuler</a>
      </div>
    </form>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>