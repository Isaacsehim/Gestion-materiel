<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container-bento">
  <section class="card">
    <h1 class="titre-section">Liste des rapports</h1>

    <?php if (empty($rapports)) : ?>
      <p class="message-info">Aucun rapport disponible.</p>
    <?php else : ?>
      <div class="table-responsive">
        <table class="table-liste">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Type</th>
              <th>Format</th>
              <th>Date de création</th>
              <th>Téléchargement</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rapports as $rapport) : ?>
              <tr>
                <td><?= htmlspecialchars($rapport['rapport_nom']) ?></td>
                <td><?= htmlspecialchars($rapport['rapport_type']) ?></td>
                <td><?= htmlspecialchars($rapport['rapport_format']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($rapport['rapport_date_creation']))) ?></td>
                <td>
                  <a href="/<?= htmlspecialchars($rapport['rapport_fichier_path']) ?>" class="btn btn-secondaire" tabindex="0">
                    <i class="fa fa-download"></i> Télécharger
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

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
