<?php 

require_once(SRC_PATH . '/template/header.php'); 
?>

<main class="container">
  <h1 class="text-centre">Créer un compte</h1>

  <?php if (!empty($erreur)) : ?>
    <p class="message-erreur"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>

  <form method="post" action="/?page=ajouter-utilisateur" enctype="multipart/form-data" class="formulaire-inscription" autocomplete="off">

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <div class="row">
      <div class="col-6">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required value="<?= htmlspecialchars($nom ?? '') ?>">
      </div>
      <div class="col-6">
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" required value="<?= htmlspecialchars($prenom ?? '') ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-6">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" required value="<?= htmlspecialchars($pseudo ?? '') ?>">
      </div>
      <div class="col-6">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email ?? '') ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-6">
        <label for="motdepasse">Mot de passe</label>
        <input type="password" name="motdepasse" id="motdepasse" autocomplete="new-password" required value="">
      </div>
      <div class="col-6">
        <label for="photo">Photo de profil (facultatif)</label>
        <input type="file" name="photo" id="photo" accept="image/*">
      </div>
    </div>

      <div class="col-6">
        <label for="niveau">Choix du niveau</label>
        <select name="niveau" id="niveau" required>
          <?php foreach ($niveaux as $n) : ?>
            <option value="<?= $n['id_niveaux'] ?>" <?= (isset($niveau) && $niveau == $n['id_niveaux']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($n['niveau_libelle']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label>
          <input type="checkbox" name="notifications" value="1" <?= (!isset($notifications) || $notifications) ? 'checked' : '' ?>>
          Recevoir les notifications
        </label>
      </div>
    </div>

    <div class="row">
      <div class="col text-centre">
        <button type="submit" class="bouton">S'inscrire</button>
      </div>
    </div>

  </form>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
