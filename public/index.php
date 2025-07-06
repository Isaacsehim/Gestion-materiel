<?php
require_once(__DIR__ . '/../config/config.php');

session_start();

$page = $_GET['page'] ?? 'accueil';

$pagesPubliques = [
    'login',
    'error',
    'accueil',
    'contact',
    'ajouter-utilisateur',
    'ajouter-utilisateur-success',
    'mentions-legales',
    'confidentialite',
    'deconnexion',
    'deconnexion-supprimer-utilisateur'
];

if (!isset($_SESSION['user_id']) && !in_array($page, $pagesPubliques, true)) {
    header('Location: /?page=login');
    exit;
}

function checkAccess(array $allowedRoles): bool
{
    if (!isset($_SESSION['niveau'])) {
        return false;
    }
    return in_array($_SESSION['niveau'], $allowedRoles, true);
}

switch ($page) {
    case 'login':
        require_once(SRC_PATH . '/controller/controller-auth.php');
        break;

    case 'deconnexion':
        require_once(SRC_PATH . '/controller/controller-deconnexion.php');
        break;

    case 'ajouter-utilisateur':
        require_once(SRC_PATH . '/controller/controller-ajouter-utilisateur.php');
        break;

    case 'ajouter-utilisateur-success':
        require_once(SRC_PATH . '/view/view-ajouter-utilisateur-success.php');
        break;

    case 'utilisateurs':
    case 'update-utilisateur':
    case 'supprimer-utilisateur':
        if (!checkAccess(['admin'])) {
            header('Location: /?page=error&code=403');
            exit;
        }
        require_once(SRC_PATH . "/controller/controller-{$page}.php");
        break;

    case 'profil-utilisateur':
        if (!checkAccess(['admin', 'user'])) {
            header('Location: /?page=login');
            exit;
        }
        require_once(SRC_PATH . '/controller/controller-profil-utilisateur.php');
        break;

    case 'produits':
    case 'ajouter-produit':
    case 'update-produit':
    case 'supprimer-produit':
        if (!checkAccess(['admin', 'user'])) {
            header('Location: /?page=error&code=403');
            exit;
        }
        require_once(SRC_PATH . "/controller/controller-{$page}.php");
        break;

    case 'fournisseurs':
    case 'ajouter-fournisseur':
    case 'update-fournisseur':
    case 'supprimer-fournisseur':
        if (!checkAccess(['admin'])) {
            header('Location: /?page=error&code=403');
            exit;
        }
        require_once(SRC_PATH . "/controller/controller-{$page}.php");
        break;

    case 'produit-detail':
        require_once(SRC_PATH . '/controller/controller-produit-detail.php');
        break;

    case 'etablissements':
    case 'favoris':
    case 'maintenance':
    case 'notifications-utilisateur':
    case 'notifications':
    case 'rapports':
    case 'mouvements':
    case 'mark-notification-read':
    case 'tags':
        if (!checkAccess(['admin', 'user'])) {
            header('Location: /?page=login');
            exit;
        }
        require_once(SRC_PATH . "/controller/controller-{$page}.php");
        break;

    case 'accueil':
        require_once(SRC_PATH . '/view/view-accueil.php');
        break;

    case 'error':
        require_once(SRC_PATH . '/controller/controller-error.php');
        break;

    case 'dashboard':
        require_once(SRC_PATH . '/controller/controller-dashboard.php');
        break;

    case 'produits-archive':
        require_once(SRC_PATH . '/controller/controller-produits-archive.php');
        break;

    case 'utilisateurs-archive':
        require_once(SRC_PATH . '/controller/controller-utilisateurs-archive.php');
        break;

    case 'contact':
        require_once(SRC_PATH . '/view/view-contact.php');
        break;

    case 'mentions-legales':
        require_once(SRC_PATH . '/view/view-mentions-legales.php');
        break;

    case 'confidentialite':
        require_once(SRC_PATH . '/view/view-confidentialite.php');
        break;

    default:
        http_response_code(404);
        require_once(SRC_PATH . '/view/view-404.php');
        exit;
}
