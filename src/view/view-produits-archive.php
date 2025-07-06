<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container">
	<h1>Archives Produits</h1>

	<section>
		<?php require(SRC_PATH . '/components/search-bar.php'); ?>
		<form method="get" class="row">
			<div>
				<label for="fournisseur">Fournisseur :</label>
				<select name="fournisseur" id="fournisseur" onchange="this.form.submit()">
					<option value="">Tous</option>
					<?php foreach ($fournisseurs as $f): ?>
						<option value="<?= htmlspecialchars($f['id_fournisseurs']) ?>"
							<?= (($_GET['fournisseur'] ?? '') == $f['id_fournisseurs']) ? 'selected' : '' ?>>
							<?= htmlspecialchars($f['fournisseur_nom']) ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="tri">Trier par :</label>
				<select name="tri" id="tri" onchange="this.form.submit()">
					<option value="nom" <?= ($_GET['tri'] ?? '') === 'nom' ? 'selected' : '' ?>>Nom</option>
					<option value="date" <?= ($_GET['tri'] ?? '') === 'date' ? 'selected' : '' ?>>Date d'ajout</option>
				</select>
			</div>
			<div>
				<label for="ordre">Ordre :</label>
				<select name="ordre" id="ordre" onchange="this.form.submit()">
					<option value="asc" <?= ($_GET['ordre'] ?? '') === 'asc' ? 'selected' : '' ?>>⬆️</option>
					<option value="desc" <?= ($_GET['ordre'] ?? '') === 'desc' ? 'selected' : '' ?>>⬇️</option>
				</select>
			</div>
			<noscript><button type="submit">Filtrer</button></noscript>
		</form>
	</section>

	<a href="/?page=produits" class="btn bouton-secondaire">Retour aux produits actifs</a>

	<section>
		<div class="table-responsive">
			<table class="table-liste">
				<thead>
					<tr>
						<th>Photo</th>
						<th>Nom</th>
						<th>Catégorie</th>
						<th>Fournisseur</th>
						<th>Description</th>
						<th>Date d'ajout</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($produits as $prod): ?>
						<tr>
							<td>
								<?php if (!empty($prod['produit_photo'])): ?>
									<img src="/<?= htmlspecialchars($prod['produit_photo']) ?>" alt="photo">
								<?php else: ?>
									<span style="color:#aaa;">–</span>
								<?php endif; ?>
							</td>
							<td>
								<?= htmlspecialchars($prod['produit_denomination'] ?? $prod['nom'] ?? '') ?>
							</td>
							<td>
								<?= htmlspecialchars($prod['id_categories'] ?? '-') ?>
							</td>
							<td>
								<?= htmlspecialchars($prod['fournisseur_nom'] ?? '-') ?>
							</td>
							<td>
								<?= htmlspecialchars($prod['produit_description'] ?? $prod['description'] ?? '') ?>
							</td>
							<td>
								<?= !empty($prod['produit_date_arrivee']) ? date('d/m/Y', strtotime($prod['produit_date_arrivee'])) : '-' ?>
							</td>
							<td>
								<a href="/?page=modifier-produit&id=<?= $prod['id_produits'] ?? $prod['id_produit'] ?>" class="btn-update" title="Modifier">✏️</a>
								<a href="/?page=supprimer-produit&id=<?= $prod['id_produits'] ?? $prod['id_produit'] ?>" class="btn-delete" title="Supprimer">🗑️</a>
							</td>
						</tr>
					<?php endforeach; ?>
					<?php if (empty($produits)): ?>
						<tr>
							<td colspan="7" class="text-centre">Aucun produit trouvé.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>