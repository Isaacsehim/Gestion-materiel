<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container">
  <h1>Utilisateurs</h1>

  <a href="/?page=utilisateurs-archive" class="btn bouton-secondaire">Voir les archives utilisateurs</a>

  <?php if (empty($utilisateurs)): ?>
    <p>Aucun utilisateur trouvé.</p>
  <?php else: ?>
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
              <a href="/?page=update-utilisateur&id=<?= $user['id_utilisateurs'] ?>" class="btn btn-update">Modifier</a>
              <a href="/?page=supprimer-utilisateur&id=<?= $user['id_utilisateurs'] ?>" class="btn btn-delete">Supprimer</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>