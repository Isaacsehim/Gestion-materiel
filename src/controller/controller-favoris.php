<?php

require_once(SRC_PATH . '/model/model-favoris.php');

$user_id = $_SESSION['user_id'];

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'])
    && $_POST['action'] === 'remove'
    && !empty($_POST['id_produit'])
) {
    removeFavori($user_id, (int)$_POST['id_produit']);
    header('Location: /?page=favoris');
    exit;
}

$favoris = getFavorisByUser($user_id);

require_once(SRC_PATH . '/view/view-favoris.php');
