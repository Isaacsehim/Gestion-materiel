<?php
require_once(SRC_PATH . '/model/model-produits.php');
require_once(SRC_PATH . '/model/model-categories.php');
require_once(SRC_PATH . '/model/model-etats-produits.php');
require_once(SRC_PATH . '/model/model-fournisseurs.php');

$erreur = '';
$success = '';
$id = (int)($_GET['id'] ?? 0);

$produit = getProduitById($id);
if (!$id || !$produit) {
    die("Produit introuvable.");
}

$categories = getCategories();
$etats = getEtatsProduits();
$fournisseurs = getAllFournisseurs();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Requête invalide (CSRF).');
    }

    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $categorie = (int)($_POST['categorie'] ?? 0);
    $etat = (int)($_POST['etat'] ?? 0);
    $fournisseur = (int)($_POST['fournisseur'] ?? 0);

    if (empty($nom) || $categorie === 0 || $etat === 0) {
        $erreur = "Tous les champs obligatoires doivent être remplis.";
    } elseif (!preg_match('/^[\w\s\-]{3,50}$/u', $nom)) {
        $erreur = "Nom invalide (3 à 50 caractères alphanumériques).";
    } else {
        $image = $produit['produit_photo'] ?? null;

        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            if (!in_array($fileType, $allowedTypes)) {
                $erreur = "Format d'image non autorisé (jpg, png, webp).";
            } else {
                $uploadDir = PUBLIC_PATH . '/assets/images/produits/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }
                $filename = uniqid('produit_') . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $targetPath = $uploadDir . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $image = 'assets/images/produits/' . $filename;
                } else {
                    $erreur = "Erreur lors de l'upload de l'image.";
                }
            }
        }

        if (!$erreur) {
            $data = [
                'produit_denomination' => $nom,
                'produit_description' => $description,
                'id_categories' => $categorie,
                'id_etats' => $etat,
                'id_fournisseurs' => $fournisseur > 0 ? $fournisseur : null,
                'produit_photo' => $image
            ];

            if (updateProduit($id, $data)) {
                $success = "Produit mis à jour avec succès.";
                $produit = getProduitById($id);
            } else {
                $erreur = "Erreur lors de la mise à jour.";
            }
        }
    }
}

require_once(SRC_PATH . '/view/view-update-produit.php');
