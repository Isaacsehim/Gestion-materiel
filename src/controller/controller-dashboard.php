<?php

require_once(SRC_PATH . '/model/model-utilisateurs.php');
require_once(SRC_PATH . '/model/model-produits.php');
require_once(SRC_PATH . '/model/model-mouvements.php');
require_once(SRC_PATH . '/model/model-journal.php');

$user = getUserById((int)$_SESSION['user_id']);

if (!$user) {
    session_destroy();
    header('Location: /?page=login');
    exit;
}

$dernierMouvement = getDernierMouvement();
$derniersProduits = getDerniersProduits(5);
$dernieresConnexions = getDernieresConnexions(5);

$nbProduits = countProduits();
$nbMouvements = countMouvements();
$nbUtilisateurs = countUtilisateursActifs();

require_once(SRC_PATH . '/view/view-dashboard.php');
