<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(__DIR__ . '/../template/sidebar.php'); ?>

<main class="section container-bento">
  <section class="card">
    <h1 class="titre-section">Liste des établissements</h1>

    <?php if (!empty($etablissements) && is_array($etablissements)) : ?>
      <div class="table-responsive">
        <table class="table-liste">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Adresse</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($etablissements as $etab) : ?>
              <tr>
                <td><?= htmlspecialchars($etab['etablissement_nom']) ?></td>
                <td><?= htmlspecialchars($etab['etablissement_adresse']) ?></td>
                <td>
                  <a href="/?page=etablissement-detail&id=<?= urlencode($etab['id_etablissement']) ?>" class="btn btn-secondaire" tabindex="0">
                    Voir</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else : ?>
      <p class="message-info">Aucun établissement trouvé.</p>
    <?php endif; ?>

    <div class="groupe-boutons flex justify-between mt-4">
      <a href="/?page=ajouter-etablissement" class="btn btn-validation" tabindex="0">Ajouter un établissement</a>
    </div>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
