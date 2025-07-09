<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(__DIR__ . '/../template/sidebar.php'); ?>

<main class="container-bento section">
  <section class="card">
    <h1 class="titre-section" tabindex="0">Historique des connexions</h1>

    <?php if (empty($notifications)): ?>
      <p class="message-info">Aucune connexion enregistrée.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table-liste">
          <thead>
            <tr>
              <th>Utilisateur</th>
              <th>Date & Heure</th>
              <th>Adresse IP</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($notifications as $notif): ?>
              <tr>
                <td><?= htmlspecialchars($notif['utilisateur_pseudo'] . ' (' . $notif['utilisateur_nom'] . ' ' . $notif['utilisateur_prenom'] . ')') ?></td>
                <td><?= htmlspecialchars($notif['date_connexion']) ?></td>
                <td><?= htmlspecialchars($notif['adresse_ip']) ?></td>
                <td>
                  <form method="post" action="/?page=mark-notification-read">
                    <input type="hidden" name="notification_id" value="<?= (int)$notif['id_notification'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                    <button type="submit" class="btn btn-validation" tabindex="0">
                      <i class="fas fa-check icone" aria-hidden="true"></i> Marquer comme lue
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php 
      $totalPages = ceil($total / $limit);
      $currentPage = $page;
      include(__DIR__ . '/../components/pagination.php'); 
      ?>
    <?php endif; ?>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>