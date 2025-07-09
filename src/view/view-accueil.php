<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="section container-bento">

  <section class="section">
    <div class="card flex flex-col items-center">
      <h1 class="alert alerte-succes" role="status">Bienvenue sur Orchi</h1>
      <p class="message-info">
        Orchi est une plateforme de gestion de matériel conçue pour faciliter le suivi, la maintenance
        et l’organisation de vos équipements.
      </p>
      <div class="flex flex-row justify-between">
        <a href="/?page=login" class="btn btn-principal" tabindex="0">Se connecter</a>
        <a href="/?page=ajouter-utilisateur" class="btn btn-secondaire" tabindex="0">Créer un compte</a>
      </div>
    </div>
  </section>

  <section class="section">
    <h2 class="alert alerte-succes" role="status">Nos fonctionnalités</h2>

    <div class="grille-3">
      <div class="card">
        <h3>Suivi des produits</h3>
        <p>Gérez les informations et l’état de vos équipements facilement.</p>
      </div>
      <div class="card">
        <h3>Maintenance</h3>
        <p>Signalez les problèmes et suivez les interventions rapidement.</p>
      </div>
      <div class="card">
        <h3>Organisation</h3>
        <p>Visualisez les lieux, étages et affectations de votre matériel.</p>
      </div>
    </div>
  </section>

  <section class="section">
    <h2 class="alert alerte-succes" role="status">Quelques produits en vitrine</h2>
    <?php if (!empty($produitsVitrine) && is_array($produitsVitrine)): ?>
      <div class="grille-3">
        <?php foreach ($produitsVitrine as $produit): ?>
          <div class="card produit-detail-grid">
            <div class="produit-detail-photo">
              <img src="<?= htmlspecialchars($produit['image_url'] ?? '/assets/images/default-product.jpg') ?>"
                   alt="<?= htmlspecialchars($produit['nom']) ?>"
                   loading="lazy">
            </div>
            <div class="produit-detail-infos">
              <h4 class="user-name"><?= htmlspecialchars($produit['nom']) ?></h4>
              <p class="user-role">Etat : <?= htmlspecialchars($produit['etat'] ?? 'Non spécifié') ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="message-info">Aucun produit à afficher pour le moment.</p>
    <?php endif; ?>
  </section>

</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
