<?php
require_once(SRC_PATH . '/model/model-favoris.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /?page=login');
    exit;
}

$user_id = $_SESSION['user_id'];
$erreur = '';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'], $_POST['csrf_token'])
    && $_POST['action'] === 'remove'
) {
    if ($_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Requête invalide – sécurité CSRF');
    }

    $id_produit = (int)($_POST['id_produit'] ?? 0);
    if ($id_produit > 0) {
        removeFavori($user_id, $id_produit);
        header('Location: /?page=favoris');
        exit;
    } else {
        $erreur = "ID produit invalide.";
    }
}

$favoris = getFavorisByUser($user_id);

require_once(SRC_PATH . '/view/view-favoris.php');
