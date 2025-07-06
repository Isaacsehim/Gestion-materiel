<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container">
  <section class="section">
    <h1>Historique des connexions</h1>

    <?php if (empty($notifications)): ?>
      <p>Aucune connexion enregistrée.</p>
    <?php else: ?>
      <table class="table-liste">
        <thead>
          <tr>
            <th>Utilisateur</th>
            <th>Date & Heure</th>
            <th>Adresse IP</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($notifications as $notif): ?>
            <tr>
              <td><?= htmlspecialchars($notif['utilisateur_pseudo'] . ' (' . $notif['utilisateur_nom'] . ' ' . $notif['utilisateur_prenom'] . ')') ?></td>
              <td><?= htmlspecialchars($notif['date_connexion']) ?></td>
              <td><?= htmlspecialchars($notif['adresse_ip']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php 
      $totalPages = ceil($total / $limit);
      $currentPage = $page;
      include(__DIR__ . '/../components/pagination.php'); 
      ?>
    <?php endif; ?>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>

