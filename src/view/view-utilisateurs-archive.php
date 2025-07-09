<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container-bento section">
  <section class="card">
    <h1 class="titre-section">Archives Utilisateurs</h1>

    <div class="grille-2">
      <a href="/?page=utilisateurs" class="btn btn-secondaire" tabindex="0">
        Retour aux utilisateurs actifs
      </a>
    </div>

    <?php if (empty($utilisateurs)): ?>
      <p class="message-info">Aucun utilisateur archivé trouvé.</p>
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
                <td><?= htmlspecialchars($user['utilisateur_nom']) ?></td>
                <td><?= htmlspecialchars($user['utilisateur_prenom']) ?></td>
                <td><?= htmlspecialchars($user['utilisateur_pseudo']) ?></td>
                <td><?= htmlspecialchars($user['utilisateur_email']) ?></td>
                <td><?= htmlspecialchars($user['niveau_libelle'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($user['etat_utilisateur_libelle'] ?? 'N/A') ?></td>
                <td>
                  <a href="/?page=restaurer-utilisateur&id=<?= $user['id_utilisateurs'] ?>" class="btn btn-update" tabindex="0">
                    Restaurer
                  </a>
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