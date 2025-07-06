<?php
require_once(SRC_PATH . '/model/model-produits.php');

if (($_SESSION['niveau'] ?? '') !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    die("Accès refusé : droits administrateur requis.");
}

$id = (int)($_GET['id'] ?? 0);
$confirmation = $_GET['confirm'] ?? 'non';

if (!$id || !($produit = getProduitById($id))) {
    die("Produit introuvable.");
}

$erreur = '';
$success = '';

if ($confirmation === 'oui') {
    if (supprimerProduit($id)) {
        header('Location: /?page=produits&delete=success');
        exit;
    } else {
        $erreur = "Erreur lors de la suppression du produit.";
    }
}

// Charger la vue de confirmation de suppression
require_once(SRC_PATH . '/view/view-supprimer-produit.php');
