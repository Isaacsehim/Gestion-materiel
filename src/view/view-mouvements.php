<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container-bento section">
  <section class="card">
    <h1 class="titre-section" tabindex="0">Gestion des mouvements</h1>

    <p class="message-info">
      Cette section vous permet de consulter les mouvements de produits : sorties, retours et réservations.
    </p>

    <div class="grille-2">
      <a href="/?page=ajouter-mouvement" class="btn btn-validation" tabindex="0">
        Enregistrer un mouvement
      </a>
      <a href="/?page=historique-mouvements" class="btn btn-secondaire" tabindex="0">
        Historique des mouvements
      </a>
    </div>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>