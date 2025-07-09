<?php require_once(SRC_PATH . '/template/header.php'); ?>

<main class="section-formulaire container">
  <section class="card formulaire-auth text-centre">
    <h1 class="titre-formulaire">Connexion</h1>

    <?php if (!empty($erreur)) : ?>
      <p class="message-erreur" role="alert">
        <?= htmlspecialchars($erreur) ?>
      </p>
    <?php endif; ?>

    <form method="post" action="/?page=login" class="formulaire-auth" autocomplete="off">
      <input type="hidden" name="action" value="login">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

      <div class="champ-formulaire">
        <label for="username" class="label-formulaire">Pseudo</label>
        <input type="text" name="username" id="username" class="champ-identifiant" required tabindex="0">
      </div>

      <div class="champ-formulaire">
        <label for="password" class="label-formulaire">Mot de passe</label>
        <input type="password" name="password" id="password" class="champ-mdp" required tabindex="0">
      </div>

      <div class="champ-formulaire text-centre">
        <button type="submit" class="btn btn-validation" tabindex="0">Se connecter</button>
      </div>
    </form>

    <div class="champ-formulaire text-centre">
      <p>Vous n’avez pas encore de compte ?</p>
      <a href="/?page=ajouter-utilisateur" class="btn btn-secondaire" tabindex="0">Créer un compte</a>
    </div>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>