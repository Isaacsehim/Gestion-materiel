<?php
require_once(SRC_PATH . '/model/model-utilisateurs.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /?page=login');
    exit;
}

$isSelfDelete = ($_SESSION['user_id'] == ($_GET['id'] ?? 0));

if (!isset($_SESSION['niveau']) || ($_SESSION['niveau'] !== 'admin' && !$isSelfDelete)) {
    die('Accès refusé : droits administrateur requis.');
}

$id = (int)($_GET['id'] ?? 0);
$confirmation = $_GET['confirm'] ?? null;

$utilisateur = getUserByIdAll($id);

if (!$id || !$utilisateur) {
    die("Utilisateur introuvable.");
}

if ($confirmation !== 'oui') {
    require_once(SRC_PATH . '/view/view-supprimer-utilisateur.php');
    exit;
}

if (supprimerUtilisateur($id)) {
    if ($_SESSION['user_id'] == $id) {
        session_destroy();
        require_once(SRC_PATH . '/view/view-deconnexion-supprimer-utilisateur.php');
        exit;
    } else {
        header('Location: /?page=utilisateurs&delete=success');
        exit;
    }
} else {
    $erreur = "Erreur lors de la suppression.";
    require_once(SRC_PATH . '/view/view-supprimer-utilisateur.php');
    exit;
}
