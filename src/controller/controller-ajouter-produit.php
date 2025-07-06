<?php
require_once(SRC_PATH . '/model/model-produits.php');
require_once(SRC_PATH . '/model/model-categories.php');
require_once(SRC_PATH . '/model/model-etats-produits.php');
require_once(SRC_PATH . '/model/model-fournisseurs.php');

$erreur = '';
$success = '';

$categories   = getCategories();
$etats        = getEtatsProduits();
$fournisseurs = getAllFournisseurs();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom         = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $categorie   = (int)($_POST['categorie'] ?? 0);
    $etat        = (int)($_POST['etat'] ?? 0);
    $fournisseur = (int)($_POST['fournisseur'] ?? 0);

    if ($nom === '' || $categorie === 0 || $etat === 0) {
        $erreur = "Veuillez remplir tous les champs obligatoires.";
    } else {
        $image = null;
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = PUBLIC_PATH . '/assets/images/produits/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }

            $filename = uniqid('produit_') . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image = 'assets/images/produits/' . $filename;
            } else {
                $erreur = "Erreur lors de l'upload de l'image.";
            }
        }

        if (!$erreur) {
            $data = [
                'produit_denomination'   => $nom,
                'produit_code_barres'    => $_POST['produit_code_barres'] ?? '',
                'produit_description'    => $description,
                'id_categories'          => $categorie,
                'id_etats'               => $etat,
                'id_fournisseurs'        => $fournisseur > 0 ? $fournisseur : null,
                'produit_photo'          => $image
            ];

            if (ajouterProduit($data)) {
                $success = "Produit ajouté avec succès.";
                $_POST = [];
            } else {
                $erreur = "Erreur lors de l'ajout du produit.";
            }
        }
    }
}

require_once(SRC_PATH . '/view/view-ajouter-produit.php');
