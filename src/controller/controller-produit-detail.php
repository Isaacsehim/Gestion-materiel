<?php
require_once(SRC_PATH . '/model/model-produits.php');
require_once(SRC_PATH . '/model/model-favoris.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fav_action'], $_POST['id_produit'])) {
    $id_produit = (int)$_POST['id_produit'];
    if ($_POST['fav_action'] === 'add') {
        addFavori($user_id, $id_produit);
    } elseif ($_POST['fav_action'] === 'remove') {
        removeFavori($user_id, $id_produit);
    }
    header('Location: /?page=produit-detail&id=' . $id_produit);
    exit;
}

if (!$id) {
    require SRC_PATH . '/view/view-404.php';
    exit;
}
$produit = getProduitById($id);
if (!$produit) {
    require SRC_PATH . '/view/view-404.php';
    exit;
}
require SRC_PATH . '/view/view-produit-detail.php';
