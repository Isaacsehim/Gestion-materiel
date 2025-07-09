<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container-bento section">
  <section class="card">
    <h1 class="titre-section">Mon profil</h1>

    <div class="user-card flex flex-row items-center">
      <?php if (!empty($utilisateur['utilisateur_photo'])): ?>
        <img class="user-photo" src="/<?= htmlspecialchars($utilisateur['utilisateur_photo']) ?>" alt="Photo de profil de <?= htmlspecialchars($utilisateur['utilisateur_pseudo']) ?>" loading="lazy">
      <?php else: ?>
        <div class="user-photo"></div>
      <?php endif; ?>

      <div class="user-info">
        <p class="user-name"><strong><?= htmlspecialchars($utilisateur['utilisateur_pseudo']) ?></strong></p>
        <p><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['utilisateur_nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($utilisateur['utilisateur_prenom']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($utilisateur['utilisateur_email']) ?></p>
        <p><strong>Notifications :</strong> <?= $utilisateur['utilisateur_notifications'] ? 'Activées' : 'Désactivées' ?></p>
      </div>
    </div>

    <div class="flex flex-row justify-between mt-4">
      <a href="/?page=update-utilisateur&id=<?= $utilisateur['id_utilisateurs'] ?>" class="btn btn-update" tabindex="0">
        <i class="fa fa-edit icone"></i> Modifier mon profil
      </a>
      <a href="/?page=supprimer-utilisateur&id=<?= $utilisateur['id_utilisateurs'] ?>" class="btn btn-delete" tabindex="0">
        <i class="fa fa-trash icone"></i> Supprimer mon compte
      </a>
    </div>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
