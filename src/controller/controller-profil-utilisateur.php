<?php

require_once(SRC_PATH . '/model/model-utilisateurs.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /?page=login');
    exit;
}

$id = (int)$_SESSION['user_id'];
$utilisateur = getUserById($id);

if (!$utilisateur) {
    die("Utilisateur introuvable.");
}

require_once(SRC_PATH . '/view/view-profil-utilisateur.php');
