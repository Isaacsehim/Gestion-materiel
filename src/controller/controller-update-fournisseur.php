<?php
require_once(SRC_PATH . '/model/model-fournisseurs.php');

$erreur = '';
$success = '';
$id = (int)($_GET['id'] ?? 0);

if (!$id || !($fournisseur = getFournisseurById($id))) {
    die("Fournisseur introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Requête invalide – sécurité CSRF');
    }

    $nom        = trim($_POST['fournisseur_nom'] ?? '');
    $adresse    = trim($_POST['fournisseur_adresse'] ?? '');
    $telephone  = trim($_POST['fournisseur_telephone'] ?? '');
    $email      = trim($_POST['fournisseur_email'] ?? '');
    $site_web   = trim($_POST['fournisseur_site_web'] ?? '');
    $commentaire = trim($_POST['fournisseur_commentaire'] ?? '');
    $actif      = isset($_POST['fournisseur_est_actif']) ? 1 : 0;

    if (
        $nom === '' ||
        !preg_match('/^[a-zA-ZÀ-ÿ0-9\s\'\-]{2,100}$/u', $nom)
    ) {
        $erreur = "Nom du fournisseur invalide.";
    } elseif ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Email invalide.";
    } elseif ($site_web && !filter_var($site_web, FILTER_VALIDATE_URL)) {
        $erreur = "URL invalide.";
    } elseif ($telephone && !preg_match('/^[0-9+\s().-]{8,20}$/', $telephone)) {
        $erreur = "Numéro de téléphone invalide.";
    } else {
        $data = [
            'fournisseur_nom'         => $nom,
            'fournisseur_adresse'     => $adresse,
            'fournisseur_telephone'   => $telephone,
            'fournisseur_email'       => $email,
            'fournisseur_site_web'    => $site_web,
            'fournisseur_commentaire' => $commentaire,
            'fournisseur_est_actif'   => $actif
        ];

        if (updateFournisseur($id, $data)) {
            $success = "Fournisseur modifié avec succès.";
            $fournisseur = getFournisseurById($id);
        } else {
            $erreur = "Erreur lors de la mise à jour.";
        }
    }
}

require_once(SRC_PATH . '/view/view-update-fournisseur.php');
