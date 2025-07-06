<?php

require_once(SRC_PATH . '/model/model-utilisateurs.php');

$erreur = '';
$niveaux = getNiveaux();
$etats = getEtats();

$etatEnLigneId = null;
foreach ($etats as $etat) {
    if ($etat['etat_utilisateur_libelle'] === 'En ligne') {
        $etatEnLigneId = (int)$etat['id_etats_utilisateurs'];
        break;
    }
}
if ($etatEnLigneId === null) {
    $etatEnLigneId = 1;
}

$nom = '';
$prenom = '';
$pseudo = '';
$email = '';
$theme = 'clair';
$niveau = 0;
$notifications = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Requête invalide (CSRF).');
    }

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $pseudo = trim($_POST['pseudo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $motdepasse = $_POST['motdepasse'] ?? '';
    $theme = $_POST['theme'] ?? 'clair';
    $niveau = (int) ($_POST['niveau'] ?? 0);
    $notifications = isset($_POST['notifications']) ? 1 : 0;

    if (empty($nom) || empty($prenom) || empty($pseudo) || empty($email) || empty($motdepasse)) {
        $erreur = "Tous les champs obligatoires doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } elseif (!in_array($theme, ['clair', 'sombre'])) {
        $erreur = "Thème invalide.";
    } else {
        $photo = null;
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
            $utilisateur = [
                'utilisateur_nom'            => $nom,
                'utilisateur_prenom'         => $prenom,
                'utilisateur_pseudo'         => $pseudo,
                'utilisateur_email'          => $email,
                'utilisateur_motdepasse'     => $motdepasse,
                'utilisateur_theme'          => $theme,
                'id_niveaux'                 => $niveau,
                'id_etats_utilisateurs'      => $etatEnLigneId,
                'utilisateur_photo'          => $photo,
                'utilisateur_notifications' => $notifications,
            ];

            if (registerUser($utilisateur)) {
                header('Location: /?page=ajouter-utilisateur-success');
                exit;
            } else {
                $erreur = "Ce pseudo ou cet email existe déjà.";
            }
        }
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once(SRC_PATH . '/view/view-ajouter-utilisateur.php');
