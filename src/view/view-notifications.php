<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container-bento section">
  <section class="card">
    <h1 class="titre-section" tabindex="0">Historique des connexions</h1>

    <form method="POST" action="/?page=mark-notification-read" class="formulaire-modif">
      <input type="hidden" name="notification_id" value="<?= (int)$notification['id_notification'] ?>">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
      <button type="submit" class="btn btn-validation" tabindex="0">Marquer comme lue</button>
    </form>

    <?php if (empty($notifications)): ?>
      <p class="message-info" tabindex="0">Aucune connexion enregistrée.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table-liste">
          <thead>
            <tr>
              <th scope="col">Utilisateur</th>
              <th scope="col">Date & Heure</th>
              <th scope="col">Adresse IP</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($notifications as $notif): ?>
              <tr>
                <td tabindex="0">
                  <?= htmlspecialchars($notif['utilisateur_pseudo'] . ' (' . $notif['utilisateur_nom'] . ' ' . $notif['utilisateur_prenom'] . ')') ?>
                </td>
                <td tabindex="0">
                  <?= htmlspecialchars($notif['date_connexion']) ?>
                </td>
                <td tabindex="0">
                  <?= htmlspecialchars($notif['adresse_ip']) ?>
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