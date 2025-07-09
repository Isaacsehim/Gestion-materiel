<?php
require_once(SRC_PATH . '/model/model-utilisateurs.php');
require_once(SRC_PATH . '/model/model-journal.php');

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ✅ Sécurité CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Requête invalide – sécurité CSRF');
    }

    // Récupération et nettoyage
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';


    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $erreur = "Identifiant invalide. Lettres, chiffres et _ uniquement.";
    } else {
        $user = getUserByPseudo($username);

        if ($user) {

            if (!empty($user['utilisateur_est_supprime'])) {
                $erreur = "Ce compte a été supprimé ou archivé.";
            }

            elseif (password_verify($password, $user['utilisateur_motdepasse'])) {

                $_SESSION['user_id'] = $user['id_utilisateurs'];
                $_SESSION['user'] = $user['utilisateur_pseudo'];
                $_SESSION['niveau'] = strtolower($user['niveau_libelle']);
                $_SESSION['utilisateur_nom'] = $user['utilisateur_nom'];
                $_SESSION['utilisateur_prenom'] = $user['utilisateur_prenom'];
                $_SESSION['utilisateur_photo'] = $user['utilisateur_photo'];
                $_SESSION['utilisateur_role'] = $user['niveau_libelle'];

                logConnexion($user['id_utilisateurs']);

                header('Location: /?page=dashboard');
                exit;
            } else {
                $erreur = "Mot de passe incorrect.";
            }
        } else {
            $erreur = "Utilisateur introuvable.";
        }
    }
}

require_once(SRC_PATH . '/view/view-login.php');
