<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="section-formulaire container-bento">
  <section class="card">
    <h1 class="alert alerte-succes" role="status">Ajouter un fournisseur</h1>

    <?php if (!empty($erreur)): ?>
      <p class="message-erreur" role="alert">
        <?= htmlspecialchars($erreur) ?>
      </p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
      <p class="message-info" role="status">
        <?= htmlspecialchars($success) ?>
      </p>
    <?php endif; ?>

    <form method="POST" class="formulaire-ajout">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

      <div class="champ-formulaire">
        <label for="fournisseur_nom" class="label-formulaire">Nom *</label>
        <input type="text" id="fournisseur_nom" name="fournisseur_nom" required value="<?= htmlspecialchars($_POST['fournisseur_nom'] ?? '') ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_adresse" class="label-formulaire">Adresse</label>
        <input type="text" id="fournisseur_adresse" name="fournisseur_adresse" value="<?= htmlspecialchars($_POST['fournisseur_adresse'] ?? '') ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_telephone" class="label-formulaire">Téléphone</label>
        <input type="text" id="fournisseur_telephone" name="fournisseur_telephone" value="<?= htmlspecialchars($_POST['fournisseur_telephone'] ?? '') ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_email" class="label-formulaire">Email</label>
        <input type="email" id="fournisseur_email" name="fournisseur_email" value="<?= htmlspecialchars($_POST['fournisseur_email'] ?? '') ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_site_web" class="label-formulaire">Site Web</label>
        <input type="url" id="fournisseur_site_web" name="fournisseur_site_web" value="<?= htmlspecialchars($_POST['fournisseur_site_web'] ?? '') ?>">
      </div>

      <div class="champ-formulaire">
        <label for="fournisseur_commentaire" class="label-formulaire">Commentaires</label>
        <textarea id="fournisseur_commentaire" name="fournisseur_commentaire"><?= htmlspecialchars($_POST['fournisseur_commentaire'] ?? '') ?></textarea>
      </div>

      <button type="submit" class="btn btn-validation btn-submit" tabindex="0">Ajouter</button>
    </form>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>