<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container">

  <section class="section text-centre">
    <h1>Bienvenue sur Orchi</h1>
    <p>
      Orchi est une plateforme de gestion de matériel conçue pour faciliter le suivi, la maintenance
      et l’organisation de vos équipements.
    </p>
    <div class="boutons-auth marge-haut">
      <a href="/?page=login" class="bouton">Se connecter</a>
      <a href="/?page=ajouter-utilisateur" class="bouton bouton-secondaire">Créer un compte</a>
    </div>
  </section>

  <section class="section">
    <h2>Nos fonctionnalités</h2>

    <div class="row">
      <div class="col-3 zone-interaction">
        <h3>Suivi des produits</h3>
        <p>Gérez les informations et l’état de vos équipements facilement.</p>
      </div>
      <div class="col-3 zone-interaction">
        <h3>Maintenance</h3>
        <p>Signalez les problèmes et suivez les interventions rapidement.</p>
      </div>
      <div class="col-3 zone-interaction">
        <h3>Organisation</h3>
        <p>Visualisez les lieux, étages et affectations de votre matériel.</p>
      </div>
    </div>
  </section>

  <section class="section">
    <h2>Quelques produits en vitrine</h2>
    <?php if (!empty($produitsVitrine) && is_array($produitsVitrine)): ?>
      <div class="row">
        <?php foreach ($produitsVitrine as $produit): ?>
          <div class="col-3">
            <div class="zone-interaction">
              <img src="<?= htmlspecialchars($produit['image_url'] ?? '/assets/images/default-product.jpg') ?>"
                   alt="<?= htmlspecialchars($produit['nom']) ?>"
              <h4><?= htmlspecialchars($produit['nom']) ?></h4>
              <p>État : <?= htmlspecialchars($produit['etat'] ?? 'Non spécifié') ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>Aucun produit à afficher pour le moment.</p>
    <?php endif; ?>
  </section>

</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
