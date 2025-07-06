<?php require_once(SRC_PATH . '/template/header.php'); ?>

<main class="container">
  <section class="section text-centre">
    <h1>Connexion</h1>

    <?php if (!empty($erreur)) : ?>
      <p class="message-erreur"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="post" action="/?page=login" class="formulaire-auth col-6">
      <input type="hidden" name="action" value="login">
      <input type="text" name="username" placeholder="Pseudo" required>
      <input type="password" name="password" placeholder="Mot de passe" required>
      <button type="submit" class="bouton bouton-principal">Se connecter</button>
    </form>

    <div class="marge-haut">
      <p>Vous n’avez pas encore de compte ?</p>
      <a href="/?page=ajouter-utilisateur" class="bouton bouton-secondaire">Créer un compte</a>
    </div>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
