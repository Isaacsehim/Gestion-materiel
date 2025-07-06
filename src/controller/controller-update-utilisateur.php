<?php

require_once(SRC_PATH . '/model/model-utilisateurs.php');

$erreur = '';
$success = '';
$id = (int)($_GET['id'] ?? 0);

if (!$id || !($utilisateur = getUserById($id))) {
    die("Utilisateur introuvable.");
}

$niveaux = getNiveaux();
$etats = getEtats();

$nom = $utilisateur['utilisateur_nom'];
$prenom = $utilisateur['utilisateur_prenom'];
$pseudo = $utilisateur['utilisateur_pseudo'];
$email = $utilisateur['utilisateur_email'];
$theme = $utilisateur['utilisateur_theme'];
$niveau = $utilisateur['id_niveaux'];
$etat = $utilisateur['id_etats_utilisateurs'];
$notifications = $utilisateur['utilisateur_notifications'];
$photoActuelle = $utilisateur['utilisateur_photo'];

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Requête invalide (CSRF).');
    }

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $pseudo = trim($_POST['pseudo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $theme = $_POST['theme'] ?? 'clair';
    $niveau = (int)($_POST['niveau'] ?? 0);
    $etat = (int)($_POST['etat'] ?? 0);
    $notifications = isset($_POST['notifications']) ? 1 : 0;

    $nouveauMDP = $_POST['motdepasse'] ?? '';

    if (empty($nom) || empty($prenom) || empty($pseudo) || empty($email)) {
        $erreur = "Tous les champs obligatoires doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } elseif (!in_array($theme, ['clair', 'sombre'])) {
        $erreur = "Thème invalide.";
    } else {
        $photo = $photoActuelle;
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $fileType = mime_content_type($_FILES['photo']['tmp_name']);
            if (!in_array($fileType, $allowedTypes)) {
                $erreur = "Format d'image non autorisé (jpg, png, webp seulement).";
            } else {
                $uploadDir = PUBLIC_PATH . '/assets/images/utilisateurs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }
                $filename = uniqid('profil_') . '_' . basename($_FILES['photo']['name']);
                $targetPath = $uploadDir . $filename;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                    $photo = 'assets/images/utilisateurs/' . $filename;
                } else {
                    $erreur = "Erreur lors de l'upload de l'image.";
                }
            }
        }

        if (!$erreur) {
            $data = [
                'utilisateur_nom'           => $nom,
                'utilisateur_prenom'        => $prenom,
                'utilisateur_pseudo'        => $pseudo,
                'utilisateur_email'         => $email,
                'utilisateur_theme'         => $theme,
                'utilisateur_notifications' => $notifications,
                'id_niveaux'                => $niveau,
                'id_etats_utilisateurs'     => $etat,
                'utilisateur_photo'         => $photo,
            ];

            $mdp_a_modifier = false;
            if (!empty($nouveauMDP)) {
                $data['utilisateur_motdepasse'] = password_hash($nouveauMDP, PASSWORD_DEFAULT);
                $mdp_a_modifier = true;
            }

            if (updateUser($id, $data, $mdp_a_modifier)) {
                $success = "L'utilisateur a bien été modifié.";
                $utilisateur = getUserById($id);
            } else {
                $erreur = "Erreur lors de la mise à jour.";
            }
        }
    }
}

require_once(SRC_PATH . '/view/view-update-utilisateur.php');
