<?php

require_once(SRC_PATH . '/template/header.php');
require_once(SRC_PATH . '/template/sidebar.php');
?>

<main class="container-bento section-formulaire">
  <section class="card">
    <h1 class="titre-formulaire">Modifier l'utilisateur</h1>

    <?php if (!empty($success)): ?>
      <script>
        window.addEventListener('DOMContentLoaded', () => {
          showToast("<?= htmlspecialchars($success, ENT_QUOTES) ?>", 'success');
        });
      </script>
    <?php endif; ?>

    <?php if (!empty($erreur)): ?>
      <script>
        window.addEventListener('DOMContentLoaded', () => {
          showToast("<?= htmlspecialchars($erreur, ENT_QUOTES) ?>", 'error');
        });
      </script>
    <?php endif; ?>

    <form method="post" class="formulaire-modif" novalidate enctype="multipart/form-data">

      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <div class="grille-2">
        <div class="champ-formulaire">
          <label class="label-formulaire" for="nom">Nom :</label>
          <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>" required>
        </div>

        <div class="champ-formulaire">
          <label class="label-formulaire" for="prenom">Prénom :</label>
          <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>" required>
        </div>
      </div>

      <div class="grille-2">
        <div class="champ-formulaire">
          <label class="label-formulaire" for="pseudo">Pseudo :</label>
          <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($pseudo ?? '') ?>" required>
        </div>

        <div class="champ-formulaire">
          <label class="label-formulaire" for="email">Email :</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        </div>
      </div>

      <div class="grille-2">
        <div class="champ-formulaire">
          <label class="label-formulaire" for="niveau">Niveau :</label>
          <select id="niveau" name="niveau">
            <?php foreach ($niveaux as $n) : ?>
              <option value="<?= $n['id_niveaux'] ?>" <?= (isset($niveau) && $niveau == $n['id_niveaux']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($n['niveau_libelle']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="champ-formulaire">
          <label class="label-formulaire" for="etat">État :</label>
          <select id="etat" name="etat">
            <?php foreach ($etats as $e) : ?>
              <option value="<?= $e['id_etats_utilisateurs'] ?>" <?= (isset($etat) && $etat == $e['id_etats_utilisateurs']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($e['etat_utilisateur_libelle']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="grille-2">
        <div class="champ-formulaire">
          <label class="label-formulaire" for="motdepasse">Mot de passe (laisser vide pour ne pas changer) :</label>
          <input type="password" id="motdepasse" name="motdepasse" autocomplete="new-password" value="">
        </div>

        <div class="champ-formulaire">
          <label class="label-formulaire" for="photo">Photo de profil (jpg, png, webp) :</label>
          <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp">
        </div>
      </div>

      <div class="champ-formulaire champ-checkbox">
        <label>
          <input type="checkbox" id="notifications" name="notifications" <?= (!isset($notifications) || $notifications) ? 'checked' : '' ?>>
          Notifications activées
        </label>
      </div>

      <div class="groupe-boutons text-centre">
        <button type="submit" class="btn btn-validation">Mettre à jour</button>
      </div>
    </form>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
