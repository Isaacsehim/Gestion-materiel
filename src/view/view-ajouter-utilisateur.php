<?php 
require_once(SRC_PATH . '/template/header.php'); 
?>

<main class="section-formulaire container-bento">
  <section class="card">
    <h1 class="alert alerte-succes text-centre" role="status">Créer un compte</h1>

    <?php if (!empty($erreur)) : ?>
      <p class="message-erreur" role="alert"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="post" action="/?page=ajouter-utilisateur" enctype="multipart/form-data" class="formulaire-ajout" autocomplete="off">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <div class="grille-2">
        <div class="champ-formulaire">
          <label for="nom" class="label-formulaire">Nom</label>
          <input type="text" name="nom" id="nom" required value="<?= htmlspecialchars($nom ?? '') ?>">
        </div>
        <div class="champ-formulaire">
          <label for="prenom" class="label-formulaire">Prénom</label>
          <input type="text" name="prenom" id="prenom" required value="<?= htmlspecialchars($prenom ?? '') ?>">
        </div>
      </div>

      <div class="grille-2">
        <div class="champ-formulaire">
          <label for="pseudo" class="label-formulaire">Pseudo</label>
          <input type="text" name="pseudo" id="pseudo" required value="<?= htmlspecialchars($pseudo ?? '') ?>">
        </div>
        <div class="champ-formulaire">
          <label for="email" class="label-formulaire">Email</label>
          <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email ?? '') ?>">
        </div>
      </div>

      <div class="grille-2">
        <div class="champ-formulaire">
          <label for="motdepasse" class="label-formulaire">Mot de passe</label>
          <input type="password" name="motdepasse" id="motdepasse" autocomplete="new-password" required>
        </div>
        <div class="champ-formulaire">
          <label for="photo" class="label-formulaire">Photo de profil (facultatif, en png, svg et webp uniquement)</label>
          <input type="file" name="photo" id="photo" accept="image/*">
        </div>
      </div>

      <div class="champ-formulaire">
        <label for="niveau" class="label-formulaire">Choix du niveau</label>
        <select name="niveau" id="niveau" required>
          <?php foreach ($niveaux as $n) : ?>
            <option value="<?= $n['id_niveaux'] ?>" <?= (isset($niveau) && $niveau == $n['id_niveaux']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($n['niveau_libelle']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="champ-formulaire">
        <label class="label-formulaire">
          <input type="checkbox" name="notifications" value="1" <?= (!isset($notifications) || $notifications) ? 'checked' : '' ?>>
          Recevoir les notifications
        </label>
      </div>

      <div class="flex flex-row justify-between items-center">
        <button type="submit" class="btn btn-validation btn-submit" tabindex="0">S'inscrire</button>
      </div>

    </form>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>