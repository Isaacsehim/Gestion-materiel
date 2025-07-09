<?php
require_once(SRC_PATH . '/model/model-mouvements.php');

$erreur = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Requête invalide – sécurité CSRF');
    }

    $produitId = (int)($_POST['produit_id'] ?? 0);
    $type      = $_POST['type'] ?? '';
    $quantite  = (int)($_POST['quantite'] ?? 0);
    $commentaire = trim($_POST['commentaire'] ?? '');

    $typesAutorises = ['entree', 'sortie', 'reparation'];
    if (!$produitId || !in_array($type, $typesAutorises, true) || $quantite <= 0) {
        $erreur = "Champs invalides.";
    } else {
        $mouvement = [
            'id_produits'         => $produitId,
            'mouvement_type'      => $type,
            'mouvement_quantite'  => $quantite,
            'mouvement_commentaire' => $commentaire,
            'id_utilisateurs'     => $_SESSION['user_id'] ?? null,
        ];

        if (ajouterMouvement($mouvement)) {
            $success = "Mouvement enregistré.";
        } else {
            $erreur = "Erreur lors de l'enregistrement.";
        }
    }
}

$mouvements = getAllMouvements();

require_once(SRC_PATH . '/view/view-mouvements.php');
