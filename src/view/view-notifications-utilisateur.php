<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container">
  <section class="section">
    <h1>Mes notifications</h1>

    <?php if (empty($notifications)): ?>
      <p>Aucune notification pour le moment.</p>
    <?php else: ?>
      <ul class="notifications-list">
        <?php foreach ($notifications as $notif): ?>
          <li class="<?= $notif['notification_lue'] == 0 ? 'non-lue' : 'lue' ?>">
            <strong><?= htmlspecialchars($notif['type_libelle']) ?> :</strong>
            <?= nl2br(htmlspecialchars($notif['notification_message'])) ?>
            <br>
            <small><?= htmlspecialchars($notif['notification_date']) ?></small>
            <?php if ($notif['notification_lue'] == 0): ?>
              <a href="/?page=mark-notification-read&id=<?= $notif['id_notification'] ?>" class="btn btn-update">
                Marquer comme lu
              </a>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <?php 
      $totalPages = ceil($total / $limit);
      $currentPage = $page;
      include(__DIR__ . '/../components/pagination.php'); 
      ?>
    <?php endif; ?>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
