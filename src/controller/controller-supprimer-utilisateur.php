<?php
require_once(SRC_PATH . '/model/model-utilisateurs.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /?page=login');
    exit;
}

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$utilisateur = getUserByIdAll($id);

if (!$id || !$utilisateur) {
    die("Utilisateur introuvable.");
}

$isSelfDelete = ($_SESSION['user_id'] === $id);
$isAdmin = ($_SESSION['niveau'] ?? '') === 'admin';

if (!$isAdmin && !$isSelfDelete) {
    die('Accès refusé : seuls les administrateurs ou l’utilisateur concerné peuvent supprimer ce compte.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Requête invalide (CSRF).');
    }

    if (supprimerUtilisateur($id)) {
        if ($isSelfDelete) {
            session_destroy();
            require_once(SRC_PATH . '/view/view-deconnexion-supprimer-utilisateur.php');
        } else {
            header('Location: /?page=utilisateurs&delete=success');
        }
        exit;
    } else {
        $erreur = "Erreur lors de la suppression.";
        require_once(SRC_PATH . '/view/view-supprimer-utilisateur.php');
        exit;
    }
}

require_once(SRC_PATH . '/view/view-supprimer-utilisateur.php');
