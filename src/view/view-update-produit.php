<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(__DIR__ . '/../template/sidebar.php'); ?>

<main class="container section">
    <h1>Modifier le produit</h1>

    <?php if (!empty($erreur)): ?>
        <div class="message-erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php elseif (!empty($success)): ?>
        <div class="message-info"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($produit): ?>
    <form method="POST" enctype="multipart/form-data" class="form-produit">
        <div>
            <label for="nom">Nom du produit <span>*</span></label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($produit['produit_denomination']) ?>" required>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($produit['produit_description']) ?></textarea>
        </div>

        <div>
            <label for="categorie">Catégorie <span>*</span></label>
            <select id="categorie" name="categorie" required>
                <option value="">Sélectionner…</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id_categories'] ?>" <?= ($produit['id_categories'] == $cat['id_categories']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['categorie_nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="etat">État <span>*</span></label>
            <select id="etat" name="etat" required>
                <option value="">Sélectionner…</option>
                <?php foreach ($etats as $etat): ?>
                    <option value="<?= $etat['id_etats'] ?>" <?= ($produit['id_etats'] == $etat['id_etats']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($etat['etat_libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="fournisseur">Fournisseur</label>
            <select id="fournisseur" name="fournisseur">
                <option value="">Aucun</option>
                <?php foreach ($fournisseurs as $f): ?>
                    <option value="<?= $f['id_fournisseurs'] ?>" <?= ($produit['id_fournisseurs'] == $f['id_fournisseurs']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['fournisseur_nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="image">Photo</label><br>
            <?php if (!empty($produit['produit_photo'])): ?>
                <img src="/<?= htmlspecialchars($produit['produit_photo']) ?>" alt="photo actuelle">
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div>
            <button type="submit" class="bouton bouton-primaire">Enregistrer</button>
            <a href="/?page=produits" class="bouton bouton-secondaire">Annuler</a>
        </div>
    </form>
    <?php endif; ?>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
