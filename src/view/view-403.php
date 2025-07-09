<?php require_once(SRC_PATH . '/template/header.php'); ?>

<main class="section container">
  <div class="card flex flex-col items-center justify-between">
    <h1 class="alert alerte-erreur" role="alert">403 - Accès refusé</h1>
    <p class="message-erreur">
      <?= htmlspecialchars($message) ?>
    </p>
    <a href="/?page=accueil" class="btn btn-secondaire" tabindex="0">
      <i class="fas fa-arrow-left"></i> Retour à l'accueil
    </a>
  </div>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
