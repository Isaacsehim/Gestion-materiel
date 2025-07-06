<?php
require_once(SRC_PATH . '/model/model-fournisseurs.php');

$erreur = '';
$success = '';
$id = (int)($_GET['id'] ?? 0);

if (!$id || !($fournisseur = getFournisseurById($id))) {
    die("Fournisseur introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'fournisseur_nom'          => trim($_POST['fournisseur_nom'] ?? ''),
        'fournisseur_adresse'      => trim($_POST['fournisseur_adresse'] ?? ''),
        'fournisseur_telephone'    => trim($_POST['fournisseur_telephone'] ?? ''),
        'fournisseur_email'        => trim($_POST['fournisseur_email'] ?? ''),
        'fournisseur_site_web'     => trim($_POST['fournisseur_site_web'] ?? ''),
        'fournisseur_commentaire'  => trim($_POST['fournisseur_commentaire'] ?? ''),
        'fournisseur_est_actif'    => isset($_POST['fournisseur_est_actif']) ? 1 : 0,
    ];

    if (empty($data['fournisseur_nom'])) {
        $erreur = "Le nom du fournisseur est obligatoire.";
    } else {
        if (updateFournisseur($id, $data)) {
            $success = "Fournisseur modifié avec succès.";
            $fournisseur = getFournisseurById($id);
        } else {
            $erreur = "Erreur lors de la mise à jour.";
        }
    }
}

require_once(SRC_PATH . '/view/view-update-fournisseur.php');
