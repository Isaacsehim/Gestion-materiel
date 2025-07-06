<?php require_once(__DIR__ . '/../template/header.php'); ?>
<?php require_once(__DIR__ . '/../template/sidebar.php'); ?>

<main class="container section">
    <h1>Ajouter un produit</h1>

    <?php if (!empty($erreur)): ?>
        <div class="message-erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php elseif (!empty($success)): ?>
        <div class="message-info"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="form-produit">
    <div>
        <label for="nom">Nom du produit <span>*</span></label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
    </div>

    <div>
        <label for="produit_code_barres">Code-barres <span>*</span></label>
        <input type="text" id="produit_code_barres" name="produit_code_barres" value="<?= htmlspecialchars($_POST['produit_code_barres'] ?? '') ?>" required>
    </div>

    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    </div>

        <div>
            <label for="categorie">Catégorie <span>*</span></label>
            <select id="categorie" name="categorie" required>
                <option value="">Sélectionner…</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id_categories'] ?>" <?= (($_POST['categorie'] ?? '') == $cat['id_categories']) ? 'selected' : '' ?>>
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
                    <option value="<?= $etat['id_etats'] ?>" <?= (($_POST['etat'] ?? '') == $etat['id_etats']) ? 'selected' : '' ?>>
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
                    <option value="<?= $f['id_fournisseurs'] ?>" <?= (($_POST['fournisseur'] ?? '') == $f['id_fournisseurs']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['fournisseur_nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="image">Photo</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div>
            <button type="submit" class="bouton bouton-primaire">Ajouter</button>
            <a href="/?page=produits" class="bouton bouton-secondaire">Annuler</a>
        </div>
    </form>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>
