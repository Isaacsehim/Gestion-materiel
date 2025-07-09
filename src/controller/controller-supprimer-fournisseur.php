<?php
require_once(SRC_PATH . '/model/model-fournisseurs.php');

$erreur = '';
$id = (int)($_GET['id'] ?? 0);
$confirmation = $_GET['confirm'] ?? '';

if (!$id || !getFournisseurById($id)) {
    die("Fournisseur introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Requête invalide – sécurité CSRF');
    }

    if (supprimerFournisseur($id)) {
        header('Location: /?page=fournisseurs&delete=success');
        exit;
    } else {
        $erreur = "Erreur lors de la suppression.";
    }
}

require_once(SRC_PATH . '/view/view-supprimer-fournisseur.php');
