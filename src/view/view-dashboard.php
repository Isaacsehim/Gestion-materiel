<?php require_once(SRC_PATH . '/template/header.php'); ?>
<?php require_once(SRC_PATH . '/template/sidebar.php'); ?>

<main class="container">
    <h1>Tableau de bord</h1>

    <div class="dashboard-grid">
        <div class="dashboard-main">

            <section class="dashboard-block">
                <h2>Bienvenue, <?= htmlspecialchars(($user['utilisateur_prenom'] ?? '') . ' ' . ($user['utilisateur_nom'] ?? '')) ?></h2>
                <p>Voici un aperçu des activités récentes et des statistiques :</p>
            </section>

            <section class="dashboard-block">
                <h3>Statistiques générales</h3>
                <ul class="dashboard-stat-list">
                    <li><strong><?= htmlspecialchars($nbProduits ?? 0) ?></strong> produits actifs</li>
                    <li><strong><?= htmlspecialchars($nbMouvements ?? 0) ?></strong> mouvements enregistrés</li>
                    <li><strong><?= htmlspecialchars($nbUtilisateurs ?? 0) ?></strong> utilisateurs actifs</li>
                </ul>
            </section>

            <section class="dashboard-block">
                <h3>Derniers produits modifiés</h3>
                <?php if (empty($derniersProduits)): ?>
                    <p>Aucun produit récent.</p>
                <?php else: ?>
                    <ul class="dashboard-products-list">
                        <?php foreach ($derniersProduits as $prod): ?>
                            <li class="dashboard-product-item">
                                <a href="/?page=produit-detail&id=<?= $prod['id_produits'] ?>" >
                                    <?php if (!empty($prod['produit_photo'])): ?>
                                        <img class="dashboard-product-photo" src="/<?= htmlspecialchars($prod['produit_photo']) ?>" alt="photo produit">
                                    <?php else: ?>
                                        <span class="dashboard-product-photo">?</span>
                                    <?php endif; ?>
                                    <div class="dashboard-product-info">
                                        <strong><?= htmlspecialchars($prod['produit_denomination'] ?? '') ?></strong>
                                        modifié par <span><?= htmlspecialchars($prod['utilisateur_pseudo'] ?? 'inconnu') ?></span>
                                        le <?= !empty($prod['produit_modifiee']) ? date('d/m/Y H:i', strtotime($prod['produit_modifiee'])) : 'date inconnue' ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                <?php endif; ?>
            </section>

        </div>
        <aside class="dashboard-side">
            <section class="dashboard-block">
                <h3>Dernier mouvement produit</h3>
                <?php if (empty($dernierMouvement)): ?>
                    <p>Aucun mouvement enregistré.</p>
                <?php else: ?>
                    <div class="dashboard-product-item">
                        <?php if (!empty($dernierMouvement['produit_photo'])): ?>
                            <img class="dashboard-product-photo" src="/<?= htmlspecialchars($dernierMouvement['produit_photo']) ?>" alt="photo produit">
                        <?php endif; ?>
                        <div class="dashboard-product-info">
                            Produit : <strong><?= htmlspecialchars($dernierMouvement['produit_denomination'] ?? '') ?></strong><br>
                            Mouvement : <?= htmlspecialchars($dernierMouvement['type_mouvement'] ?? '') ?><br>
                            Utilisateur : <?= htmlspecialchars($dernierMouvement['utilisateur_pseudo'] ?? 'inconnu') ?><br>
                            Date : <?= !empty($dernierMouvement['date_mouvement']) ? date('d/m/Y H:i', strtotime($dernierMouvement['date_mouvement'])) : 'date inconnue' ?>
                        </div>
                    </div>
                <?php endif; ?>
            </section>

            <section class="dashboard-block">
                <h3>Dernières connexions</h3>
                <?php if (empty($dernieresConnexions)): ?>
                    <p>Aucune connexion récente.</p>
                <?php else: ?>
                    <ul class="dashboard-connections-list">
                        <?php foreach ($dernieresConnexions as $conn): ?>
                            <li class="dashboard-connection-item">
                                <?php if (!empty($conn['utilisateur_photo'])): ?>
                                    <img class="dashboard-user-avatar" src="/<?= htmlspecialchars($conn['utilisateur_photo']) ?>" alt="profil utilisateur">
                                <?php else: ?>
                                    <span class="dashboard-user-avatar">?</span>
                                <?php endif; ?>
                                <span>
                                    <?= htmlspecialchars($conn['utilisateur_pseudo'] ?? '') ?> s'est connecté le
                                    <?= !empty($conn['date_connexion']) ? date('d/m/Y H:i', strtotime($conn['date_connexion'])) : 'date inconnue' ?>
                                    depuis <?= htmlspecialchars($conn['adresse_ip'] ?? 'IP inconnue') ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
        </aside>
    </div>

</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>