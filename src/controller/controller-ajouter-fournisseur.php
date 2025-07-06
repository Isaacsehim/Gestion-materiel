<?php
require_once(SRC_PATH . '/model/model-utilisateurs.php');

$erreur = '';
$niveaux = getNiveaux();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom        = trim($_POST['nom'] ?? '');
    $prenom     = trim($_POST['prenom'] ?? '');
    $pseudo     = trim($_POST['pseudo'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $motdepasse = $_POST['motdepasse'] ?? '';
    $theme      = $_POST['theme'] ?? 'clair';
    $niveau     = (int)($_POST['niveau'] ?? 0);
    $notifications = isset($_POST['notifications']) ? 1 : 0;

    $etat = 1;

    if (!$nom || !$prenom || !$pseudo || !$email || !$motdepasse || !$niveau) {
        $erreur = "Veuillez remplir tous les champs obligatoires.";
    } else {
        $photo = null;
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = PUBLIC_PATH . '/assets/images/utilisateurs/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }

            $filename = uniqid('profil_') . '_' . basename($_FILES['photo']['name']);
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                $photo = 'assets/images/utilisateurs/' . $filename;
            }
        }

        $utilisateur = [
            'nom'           => $nom,
            'prenom'        => $prenom,
            'pseudo'        => $pseudo,
            'email'         => $email,
            'motdepasse'    => $motdepasse,
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

require_once(SRC_PATH . '/view/view-ajouter-utilisateur.php');
