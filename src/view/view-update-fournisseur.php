<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container-bento section-formulaire">
  <section class="card">
    <h1 class="titre-formulaire">Modifier le fournisseur</h1>

    <?php if (!empty($erreur)): ?>
      <p class="message-erreur"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
      <p class="message-info"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" class="formulaire-modif">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

      <div class="champ-formulaire">
        <label for="fournisseur_nom" class="label-formulaire">Nom *</label>
        <input type="text" id="fournisseur_nom" name="fournisseur_nom" required value="<?= htmlspecialchars($fournisseur['fournisseur_nom']) ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_adresse" class="label-formulaire">Adresse</label>
        <input type="text" id="fournisseur_adresse" name="fournisseur_adresse" value="<?= htmlspecialchars($fournisseur['fournisseur_adresse']) ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_telephone" class="label-formulaire">Téléphone</label>
        <input type="text" id="fournisseur_telephone" name="fournisseur_telephone" value="<?= htmlspecialchars($fournisseur['fournisseur_telephone']) ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_email" class="label-formulaire">Email</label>
        <input type="email" id="fournisseur_email" name="fournisseur_email" value="<?= htmlspecialchars($fournisseur['fournisseur_email']) ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_site_web" class="label-formulaire">Site Web</label>
        <input type="url" id="fournisseur_site_web" name="fournisseur_site_web" value="<?= htmlspecialchars($fournisseur['fournisseur_site_web']) ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_commentaire" class="label-formulaire">Commentaires</label>
        <textarea id="fournisseur_commentaire" name="fournisseur_commentaire"><?= htmlspecialchars($fournisseur['fournisseur_commentaire']) ?></textarea>
      </div>

      <div class="champ-formulaire">
        <label class="label-formulaire">
          <input type="checkbox" name="fournisseur_est_actif" value="1" <?= $fournisseur['fournisseur_est_actif'] ? 'checked' : '' ?>>
          Fournisseur actif
        </label>
      </div>

      <div class="champ-formulaire">
        <button type="submit" class="btn btn-validation">Enregistrer</button>
      </div>
    </form>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>