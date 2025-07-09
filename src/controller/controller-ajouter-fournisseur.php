<?php
require_once(SRC_PATH . '/model/model-utilisateurs.php');

$erreur = '';
$niveaux = getNiveaux();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Requête invalide – sécurité CSRF');
    }

    $nom        = trim($_POST['nom'] ?? '');
    $prenom     = trim($_POST['prenom'] ?? '');
    $pseudo     = trim($_POST['pseudo'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $motdepasse = $_POST['motdepasse'] ?? '';
    $theme      = $_POST['theme'] ?? 'clair';
    $niveau     = (int)($_POST['niveau'] ?? 0);
    $notifications = isset($_POST['notifications']) ? 1 : 0;
    $etat = 1;

    if (
        !$nom || !$prenom || !$pseudo || !$email || !$motdepasse || !$niveau ||
        !preg_match('/^[a-zA-ZÀ-ÿ\s\'-]{2,50}$/u', $nom) ||
        !preg_match('/^[a-zA-ZÀ-ÿ\s\'-]{2,50}$/u', $prenom) ||
        !preg_match('/^[a-zA-Z0-9_-]{3,30}$/', $pseudo)
    ) {
        $erreur = "Champs obligatoires invalides.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } elseif (!in_array($theme, ['clair', 'sombre'])) {
        $erreur = "Thème invalide.";
    } else {
        $photo = null;
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $fileType = mime_content_type($_FILES['photo']['tmp_name']);

            if (in_array($fileType, $allowedTypes)) {
                $uploadDir = PUBLIC_PATH . '/assets/images/utilisateurs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }

                $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('profil_', true) . '.' . $extension;
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                    $photo = 'assets/images/utilisateurs/' . $filename;
                } else {
                    $erreur = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $erreur = "Format d'image non autorisé.";
            }
        }

        if (!$erreur) {
            $utilisateur = [
                'nom'           => $nom,
                'prenom'        => $prenom,
                'pseudo'        => $pseudo,
                'email'         => $email,
                'motdepasse'    => password_hash($motdepasse, PASSWORD_DEFAULT),
                'theme'         => $theme,
                'niveau'        => $niveau,
                'etat'          => $etat,
                'photo'         => $photo,
                'notifications' => $notifications,
            ];

            if (registerUser($utilisateur)) {
                header('Location: /?page=login');
                exit;
            } else {
                $erreur = "Ce pseudo ou cet email existe déjà.";
            }
        }
    }
}

require_once(SRC_PATH . '/view/view-ajouter-utilisateur.php');
