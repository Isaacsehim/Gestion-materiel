<?php require_once(SRC_PATH . '/template/header.php'); ?>

<main class="container text-centre">
  <h1>403 - Accès refusé</h1>
  <p><?= htmlspecialchars($message) ?></p>
  <a href="/?page=accueil" class="bouton bouton-secondaire">Retour à l'accueil</a>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
