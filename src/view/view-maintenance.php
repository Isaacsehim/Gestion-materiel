
<div class="container-bento">

  <section class="section">
    <h2 class="user-name"><i class="fas fa-tools" aria-hidden="true"></i> Maintenances en cours</h2>

    <?php if (!empty($maintenances)): ?>
      <div class="table-responsive">
        <table class="table-liste">
          <thead>
            <tr>
              <th>Produit</th>
              <th>Problème</th>
              <th>Déclaré le</th>
              <th>État</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($maintenances as $m): ?>
              <tr>
                <td><?= htmlspecialchars($m['produit_denomination']) ?></td>
                <td><?= htmlspecialchars($m['maintenance_type_probleme']) ?></td>
                <td><?= date('d/m/Y', strtotime($m['maintenance_date_declaration'])) ?></td>
                <td><?= htmlspecialchars($m['etat_maintenance_libelle']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="message-info"><i class="fas fa-info-circle" aria-hidden="true"></i> Aucune maintenance en cours.</p>
    <?php endif; ?>
  </section>

  <!-- Formulaire de signalement -->
  <section class="section-formulaire">
    <h2 class="user-name"><i class="fas fa-plus-circle" aria-hidden="true"></i> Signaler une maintenance</h2>

    <form class="formulaire-ajout" method="post" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

      <div class="champ-formulaire">
        <label for="produit_id" class="label-formulaire">Produit concerné</label>
        <select name="produit_id" id="produit_id" required>
          <?php foreach ($produits as $produit): ?>
            <option value="<?= htmlspecialchars($produit['id_produits']) ?>"><?= htmlspecialchars($produit['produit_denomination']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="champ-formulaire">
        <label for="probleme" class="label-formulaire">Type de problème</label>
        <input type="text" name="probleme" id="probleme" required>
      </div>

      <div class="champ-formulaire">
        <label for="photo_avant" class="label-formulaire">Photo avant (optionnelle)</label>
        <input type="file" name="photo_avant" id="photo_avant" accept="image/*">
      </div>

      <button type="submit" name="signaler_maintenance" class="btn btn-submit btn-principal" tabindex="0">
        <i class="fas fa-wrench" aria-hidden="true"></i> Signaler
      </button>
    </form>
  </section>

  <!-- Historique des maintenances -->
  <section class="section">
    <h2 class="user-name"><i class="fas fa-history" aria-hidden="true"></i> Historique des maintenances</h2>

    <?php if (!empty($maintenances_historique)): ?>
      <div class="table-responsive">
        <table class="table-liste">
          <thead>
            <tr>
              <th>Produit</th>
              <th>Problème</th>
              <th>Date</th>
              <th>État</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($maintenances_historique as $mh): ?>
              <tr>
                <td><?= htmlspecialchars($mh['produit_denomination']) ?></td>
                <td><?= htmlspecialchars($mh['maintenance_type_probleme']) ?></td>
                <td><?= date('d/m/Y', strtotime($mh['maintenance_date_declaration'])) ?></td>
                <td><?= htmlspecialchars($mh['etat_maintenance_libelle']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="message-info"><i class="fas fa-info-circle" aria-hidden="true"></i> Aucun historique disponible.</p>
    <?php endif; ?>
  </section>

</div>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
