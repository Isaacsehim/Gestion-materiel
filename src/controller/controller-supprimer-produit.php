<?php
require_once(SRC_PATH . '/model/model-produits.php');

if (($_SESSION['niveau'] ?? '') !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    die("Accès refusé : droits administrateur requis.");
}

$id = (int)($_GET['id'] ?? 0);
$confirmation = $_GET['confirm'] ?? null;

$erreur = '';
$success = '';

if (!$id || !($produit = getProduitById($id))) {
    die("Produit introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Requête invalide (CSRF).');
    }

    if (supprimerProduit($id)) {
        header('Location: /?page=produits&delete=success');
        exit;
    } else {
        $erreur = "Erreur lors de la suppression du produit.";
    }
}

require_once(SRC_PATH . '/view/view-supprimer-produit.php');
