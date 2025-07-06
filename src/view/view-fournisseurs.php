<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container">
  <section class="section">
    <h1>Liste des fournisseurs</h1>

    <a href="/?page=ajouter-fournisseur" class="btn btn-submit">Ajouter un fournisseur</a>

    <?php if (empty($fournisseurs)): ?>
      <p>Aucun fournisseur trouvé.</p>
    <?php else: ?>
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
                <a href="<?= htmlspecialchars($f['fournisseur_site_web']) ?>" target="_blank" rel="noopener noreferrer">Lien</a>
              <?php endif; ?>
            </td>
            <td><?= $f['fournisseur_est_actif'] ? 'Oui' : 'Non' ?></td>
            <td>
              <a href="/?page=update-fournisseur&id=<?= $f['id_fournisseurs'] ?>" class="btn btn-update">Modifier</a>
              <a href="/?page=supprimer-fournisseur&id=<?= $f['id_fournisseurs'] ?>" class="btn btn-delete" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
