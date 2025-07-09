<?php

require_once(SRC_PATH . '/model/model-utilisateurs.php');

$success = $success ?? ($_GET['success'] ?? '');
$erreur = $erreur ?? ($_GET['error'] ?? '');
$id = (int)($_GET['id'] ?? 0);

$utilisateur = getUserById($id);
if (!$id || !$utilisateur) {
    die("Utilisateur introuvable.");
}

$niveaux = getNiveaux();
$etats = getEtats();

$nom            = $utilisateur['utilisateur_nom'];
$prenom         = $utilisateur['utilisateur_prenom'];
$pseudo         = $utilisateur['utilisateur_pseudo'];
$email          = $utilisateur['utilisateur_email'];
$theme          = $utilisateur['utilisateur_theme'];
$niveau         = $utilisateur['id_niveaux'];
$etat           = $utilisateur['id_etats_utilisateurs'];
$notifications  = $utilisateur['utilisateur_notifications'];
$photoActuelle  = $utilisateur['utilisateur_photo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Requête invalide – CSRF.');
    }

    $nom     = trim($_POST['nom'] ?? '');
    $prenom  = trim($_POST['prenom'] ?? '');
    $pseudo  = trim($_POST['pseudo'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $theme   = $_POST['theme'] ?? 'clair';
    $niveau  = (int)($_POST['niveau'] ?? 0);
    $etat    = (int)($_POST['etat'] ?? 0);
    $notifications = isset($_POST['notifications']) ? 1 : 0;
    $nouveauMDP = $_POST['motdepasse'] ?? '';

    if (!$nom || !$prenom || !$pseudo || !$email) {
        $erreur = "Tous les champs obligatoires doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $pseudo)) {
        $erreur = "Le pseudo doit contenir uniquement lettres, chiffres ou _ (3 à 20 caractères).";
    } elseif (!in_array($theme, ['clair', 'sombre'])) {
        $erreur = "Thème invalide.";
    } else {
        $photo = $photoActuelle;
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $type = mime_content_type($_FILES['photo']['tmp_name']);
            if (!in_array($type, $allowedTypes)) {
                $erreur = "Format image non autorisé (jpg, png, webp).";
            } else {
                $uploadDir = PUBLIC_PATH . '/assets/images/utilisateurs/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);

                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('profil_') . '.' . $ext;
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
                'utilisateur_photo'         => $photo
            ];

            $mdp_a_modifier = false;
            if (!empty($nouveauMDP)) {
                $data['utilisateur_motdepasse'] = password_hash($nouveauMDP, PASSWORD_DEFAULT);
                $mdp_a_modifier = true;
            }

            if (updateUser($id, $data, $mdp_a_modifier)) {
                header("Location: /?page=update-utilisateur&id=$id&success=" . urlencode("La modification a été effectuée avec succès."));
exit;

                $utilisateur = getUserById($id);
            } else {
                $erreur = "Erreur lors de la mise à jour.";
            }
        }
    }
}

require_once(SRC_PATH . '/view/view-update-utilisateur.php');
