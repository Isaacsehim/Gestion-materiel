<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once(SRC_PATH . '/model/model-produits.php');
require_once(SRC_PATH . '/model/model-favoris.php');
require_once(SRC_PATH . '/model/model-fournisseurs.php');

require_once(SRC_PATH . '/model/model-categories.php');
$fournisseurs = getAllFournisseurs();
$marques = getMarquesDisponibles();
$lieux = getLieuxDisponibles();

$filtres = [
    'fournisseur' => $_GET['fournisseur'] ?? '',
    'lieu'        => $_GET['lieu'] ?? '',
    'marque'      => $_GET['marque'] ?? '',
    'dispo'       => $_GET['dispo'] ?? '',
    'tri'         => $_GET['tri'] ?? 'date',
    'ordre'       => $_GET['ordre'] ?? 'desc',
];

$produits = getProduitsFiltrés($filtres);

$user_id = $_SESSION['user_id'] ?? null;
if ($user_id && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fav_action'], $_POST['id_produit'])) {
    $id_produit = (int)$_POST['id_produit'];
    if ($_POST['fav_action'] === 'add') {
        addFavori($user_id, $id_produit);
    } elseif ($_POST['fav_action'] === 'remove') {
        removeFavori($user_id, $id_produit);
    }
    $url = '/?page=produits' . (!empty($_SERVER['QUERY_STRING']) ? '&'.$_SERVER['QUERY_STRING'] : '');
    header("Location: $url");
    exit;
}

require_once(SRC_PATH . '/view/view-produits.php');

