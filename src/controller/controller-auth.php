<?php
require_once(SRC_PATH . '/model/model-utilisateurs.php');
require_once(SRC_PATH . '/model/model-journal.php');

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = getUserByPseudo($username);

        if ($user) {
            if (password_verify($password, $user['utilisateur_motdepasse'])) {
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
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE utilisateur_pseudo = :pseudo");
            $stmt->execute(['pseudo' => $username]);
            $existe = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($existe && $existe['utilisateur_est_supprime'] == 1) {
                $erreur = "Ce compte a été supprimé ou archivé.";
            } else {
                $erreur = "Utilisateur introuvable.";
            }
        }
    }
}

require_once(SRC_PATH . '/view/view-login.php');
