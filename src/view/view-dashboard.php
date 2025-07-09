<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="section container-bento">
  <h1 class="alert alerte-succes" role="status">Tableau de bord</h1>

  <div class="grille-2">
    <div class="flex flex-col">

      <section class="card">
        <h2 class="user-name">Bienvenue, <?= htmlspecialchars(($user['utilisateur_prenom'] ?? '') . ' ' . ($user['utilisateur_nom'] ?? '')) ?></h2>
        <p>Voici un aperçu des activités récentes et des statistiques :</p>
      </section>

      <section class="card">
        <h3 class="user-name">Statistiques générales</h3>
        <ul class="message-info">
          <li><strong><?= htmlspecialchars($nbProduits ?? 0) ?></strong> produits actifs</li>
          <li><strong><?= htmlspecialchars($nbMouvements ?? 0) ?></strong> mouvements enregistrés</li>
          <li><strong><?= htmlspecialchars($nbUtilisateurs ?? 0) ?></strong> utilisateurs actifs</li>
        </ul>
      </section>

      <section class="card">
        <h3 class="user-name">Derniers produits modifiés</h3>
        <?php if (empty($derniersProduits)): ?>
          <p class="message-info">Aucun produit récent.</p>
        <?php else: ?>
          <ul class="table-liste">
            <?php foreach ($derniersProduits as $prod): ?>
              <li class="produit-detail-grid">
                <a href="/?page=produit-detail&id=<?= $prod['id_produits'] ?>" tabindex="0">
                  <div class="produit-detail-photo">
                    <?php if (!empty($prod['produit_photo'])): ?>
                      <img src="/<?= htmlspecialchars($prod['produit_photo']) ?>" alt="photo produit" loading="lazy">
                    <?php else: ?>
                      <span class="icone">?</span>
                    <?php endif; ?>
                  </div>
                  <div class="produit-detail-infos">
                    <strong><?= htmlspecialchars($prod['produit_denomination'] ?? '') ?></strong><br>
                    modifié par <span><?= htmlspecialchars($prod['utilisateur_pseudo'] ?? 'inconnu') ?></span><br>
                    le <?= !empty($prod['produit_modifiee']) ? date('d/m/Y H:i', strtotime($prod['produit_modifiee'])) : 'date inconnue' ?>
                  </div>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </section>

    </div>

    <aside class="flex flex-col">
      <section class="card">
        <h3 class="user-name">Dernier mouvement produit</h3>
        <?php if (empty($dernierMouvement)): ?>
          <p class="message-info">Aucun mouvement enregistré.</p>
        <?php else: ?>
          <div class="produit-detail-grid">
            <?php if (!empty($prod['produit_photo'])): ?>
              <img src="<?= htmlspecialchars($prod['produit_photo']) ?>" alt="photo produit" loading="lazy">
            <?php else: ?>
              <span class="icone">?</span>
            <?php endif; ?>
            <div class="produit-detail-infos">
              Produit : <strong><?= htmlspecialchars($dernierMouvement['produit_denomination'] ?? '') ?></strong><br>
              Mouvement : <?= htmlspecialchars($dernierMouvement['type_mouvement'] ?? '') ?><br>
              Utilisateur : <?= htmlspecialchars($dernierMouvement['utilisateur_pseudo'] ?? 'inconnu') ?><br>
              Date : <?= !empty($dernierMouvement['date_mouvement']) ? date('d/m/Y H:i', strtotime($dernierMouvement['date_mouvement'])) : 'date inconnue' ?>
            </div>
          </div>
        <?php endif; ?>
      </section>

      <section class="card">
        <h3 class="user-name">Dernières connexions</h3>
        <?php if (empty($dernieresConnexions)): ?>
          <p class="message-info">Aucune connexion récente.</p>
        <?php else: ?>
          <ul class="table-liste">
            <?php foreach ($dernieresConnexions as $conn): ?>
              <li class="user-card flex items-center">
                <div class="user-photo">
                  <?php if (!empty($conn['utilisateur_photo'])): ?>
                    <img src="/<?= htmlspecialchars($conn['utilisateur_photo']) ?>" alt="profil utilisateur" loading="lazy">
                  <?php else: ?>
                    <span class="icone">?</span>
                  <?php endif; ?>
                </div>
                <div class="user-info">
                  <?= htmlspecialchars($conn['utilisateur_pseudo'] ?? '') ?> s'est connecté le
                  <?= !empty($conn['date_connexion']) ? date('d/m/Y H:i', strtotime($conn['date_connexion'])) : 'date inconnue' ?><br>
                  depuis <?= htmlspecialchars($conn['adresse_ip'] ?? 'IP inconnue') ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </section>
    </aside>
  </div>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>