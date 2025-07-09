<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="section container-bento">
  <section class="card">
    <div class="flex justify-between items-center">
      <h1 class="titre-section">Liste des fournisseurs</h1>
      <a href="/?page=ajouter-fournisseur" class="btn btn-validation" tabindex="0">Ajouter un fournisseur</a>
    </div>

    <?php if (empty($fournisseurs)): ?>
      <p class="message-info" role="status">Aucun fournisseur trouvé.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table-liste">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Adresse</th>
              <th>Téléphone</th>
              <th>Email</th>
              <th>Site Web</th>
              <th>Actif</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($fournisseurs as $f): ?>
              <tr>
                <td><?= htmlspecialchars($f['fournisseur_nom']) ?></td>
                <td><?= htmlspecialchars($f['fournisseur_adresse']) ?></td>
                <td><?= htmlspecialchars($f['fournisseur_telephone']) ?></td>
                <td><?= htmlspecialchars($f['fournisseur_email']) ?></td>
                <td>
                  <?php if (!empty($f['fournisseur_site_web'])): ?>
                    <a href="<?= htmlspecialchars($f['fournisseur_site_web']) ?>" target="_blank" rel="noopener noreferrer" tabindex="0">Lien</a>
                  <?php endif; ?>
                </td>
                <td><?= $f['fournisseur_est_actif'] ? 'Oui' : 'Non' ?></td>
                <td class="flex flex-row justify-between">
                  <a href="/?page=update-fournisseur&id=<?= urlencode($f['id_fournisseurs']) ?>" class="btn btn-update" tabindex="0">Modifier</a>
                  <a href="/?page=supprimer-fournisseur&id=<?= urlencode($f['id_fournisseurs']) ?>" class="btn btn-delete btn-danger" onclick="return confirm('Confirmer la suppression ?')" tabindex="0">Supprimer</a>
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