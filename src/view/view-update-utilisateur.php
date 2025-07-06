<?php 

require_once(SRC_PATH . '/template/header.php');
require_once(SRC_PATH . '/template/sidebar.php');
?>

<main class="container">
  <h1>Modifier l'utilisateur</h1>

  <?php if (!empty($success)) : ?>
    <script>
      window.addEventListener('DOMContentLoaded', () => {
        showToast(<?= json_encode($success) ?>, 'success');
      });
    </script>
  <?php endif; ?>

  <?php if (!empty($erreur)) : ?>
    <p class="message-erreur"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>

  <form method="post" class="formulaire-modif" novalidate enctype="multipart/form-data">

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>" required><br>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>" required><br>

    <label for="pseudo">Pseudo :</label>
    <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($pseudo ?? '') ?>" required><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required><br>

    <label for="niveau">Niveau :</label>
    <select id="niveau" name="niveau">
      <?php foreach ($niveaux as $n) : ?>
        <option value="<?= $n['id_niveaux'] ?>" <?= (isset($niveau) && $niveau == $n['id_niveaux']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($n['niveau_libelle']) ?>
        </option>
      <?php endforeach; ?>
    </select><br>

    <label for="etat">État :</label>
    <select id="etat" name="etat">
      <?php foreach ($etats as $e) : ?>
        <option value="<?= $e['id_etats_utilisateurs'] ?>" <?= (isset($etat) && $etat == $e['id_etats_utilisateurs']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($e['etat_utilisateur_libelle']) ?>
        </option>
      <?php endforeach; ?>
    </select><br>

    <label for="motdepasse">Mot de passe (laisser vide pour ne pas changer) :</label>
    <input type="password" id="motdepasse" name="motdepasse" autocomplete="new-password" value=""><br>

    <label for="photo">Photo de profil (jpg, png, webp) :</label>
    <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"><br>

    <label for="notifications">
      <input type="checkbox" id="notifications" name="notifications" <?= (!isset($notifications) || $notifications) ? 'checked' : '' ?>>
      Notifications activées
    </label><br>

    <button type="submit" class="button">Mettre à jour</button>
  </form>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
