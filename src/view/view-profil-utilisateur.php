<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container">
  <h1>Mon profil</h1>

  <div class="user-card">
    <?php if (!empty($utilisateur['utilisateur_photo'])): ?>
      <img src="/<?= htmlspecialchars($utilisateur['utilisateur_photo']) ?>" alt="Photo de profil de <?= htmlspecialchars($utilisateur['utilisateur_pseudo']) ?>">
    <?php else: ?>
      <div></div>
    <?php endif; ?>

    <div class="user-info">
      <h3><?= htmlspecialchars($utilisateur['utilisateur_pseudo']) ?></h3>
      <p><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['utilisateur_nom']) ?></p>
      <p><strong>Prénom :</strong> <?= htmlspecialchars($utilisateur['utilisateur_prenom']) ?></p>
      <p><strong>Email :</strong> <?= htmlspecialchars($utilisateur['utilisateur_email']) ?></p>
      <p><strong>Notifications :</strong> <?= $utilisateur['utilisateur_notifications'] ? 'Activées' : 'Désactivées' ?></p>
    </div>
  </div>

  <div>
    <a href="/?page=update-utilisateur&id=<?= $utilisateur['id_utilisateurs'] ?>" class="btn btn-update">Modifier mon profil</a>
    <a href="/?page=supprimer-utilisateur&id=<?= $utilisateur['id_utilisateurs'] ?>" class="btn btn-delete">Supprimer mon compte</a>
  </div>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
