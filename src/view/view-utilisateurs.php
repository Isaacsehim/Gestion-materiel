<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container-bento section">
  <section class="card">
    <h1 class="titre-section">Utilisateurs</h1>

    <div class="flex justify-between items-center">
      <a href="/?page=utilisateurs-archive" class="btn btn-secondaire" tabindex="0">Voir les archives utilisateurs</a>
    </div>

    <?php if (empty($utilisateurs)): ?>
      <p class="message-info">Aucun utilisateur trouvé.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table-liste">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Pseudo</th>
              <th>Email</th>
              <th>Niveau</th>
              <th>État</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($utilisateurs as $user): ?>
              <tr>
                <td class="champ-nom"><?= htmlspecialchars($user['utilisateur_nom']) ?></td>
                <td class="champ-prenom"><?= htmlspecialchars($user['utilisateur_prenom']) ?></td>
                <td class="champ-pseudo"><?= htmlspecialchars($user['utilisateur_pseudo']) ?></td>
                <td class="champ-email"><?= htmlspecialchars($user['utilisateur_email']) ?></td>
                <td class="champ-niveau"><?= htmlspecialchars($user['niveau_libelle'] ?? 'N/A') ?></td>
                <td class="champ-etat"><?= htmlspecialchars($user['etat_utilisateur_libelle'] ?? 'N/A') ?></td>
                <td class="champ-actions">
                  <a href="/?page=update-utilisateur&id=<?= $user['id_utilisateurs'] ?>" class="btn btn-update" tabindex="0">Modifier</a>
                  <a href="/?page=supprimer-utilisateur&id=<?= $user['id_utilisateurs'] ?>" class="btn btn-delete" tabindex="0">Supprimer</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>