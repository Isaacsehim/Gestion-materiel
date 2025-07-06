<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container">
  <section class="section">
    <h1>Modifier le fournisseur</h1>

    <?php if (!empty($erreur)): ?>
      <p class="message-erreur"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
      <p class="message-info"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" class="form-produit">
      <label for="fournisseur_nom">Nom *</label>
      <input type="text" id="fournisseur_nom" name="fournisseur_nom" required value="<?= htmlspecialchars($fournisseur['fournisseur_nom']) ?>">

      <label for="fournisseur_adresse">Adresse</label>
      <input type="text" id="fournisseur_adresse" name="fournisseur_adresse" value="<?= htmlspecialchars($fournisseur['fournisseur_adresse']) ?>">

      <label for="fournisseur_telephone">Téléphone</label>
      <input type="text" id="fournisseur_telephone" name="fournisseur_telephone" value="<?= htmlspecialchars($fournisseur['fournisseur_telephone']) ?>">

      <label for="fournisseur_email">Email</label>
      <input type="email" id="fournisseur_email" name="fournisseur_email" value="<?= htmlspecialchars($fournisseur['fournisseur_email']) ?>">

      <label for="fournisseur_site_web">Site Web</label>
      <input type="url" id="fournisseur_site_web" name="fournisseur_site_web" value="<?= htmlspecialchars($fournisseur['fournisseur_site_web']) ?>">

      <label for="fournisseur_commentaire">Commentaires</label>
      <textarea id="fournisseur_commentaire" name="fournisseur_commentaire"><?= htmlspecialchars($fournisseur['fournisseur_commentaire']) ?></textarea>

      <label>
        <input type="checkbox" name="fournisseur_est_actif" value="1" <?= $fournisseur['fournisseur_est_actif'] ? 'checked' : '' ?>>
        Fournisseur actif
      </label>

      <button type="submit" class="btn btn-update">Enregistrer</button>
    </form>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
