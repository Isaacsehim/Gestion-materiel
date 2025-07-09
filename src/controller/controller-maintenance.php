<?php
require_once(SRC_PATH . '/model/model-maintenance.php');
require_once(SRC_PATH . '/model/model-produits.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signaler_maintenance'], $_SESSION['user_id'])) {
    $id_produits = (int) ($_POST['produit_id'] ?? 0);
    $probleme = trim($_POST['probleme'] ?? '');
    $id_utilisateur = (int) $_SESSION['user_id'];
    $photo_avant = null;

    if (!empty($_FILES['photo_avant']['tmp_name'])) {
        $mime = mime_content_type($_FILES['photo_avant']['tmp_name']);
        if (str_starts_with($mime, 'image/')) {
            $ext = pathinfo($_FILES['photo_avant']['name'], PATHINFO_EXTENSION);
            $nomFichier = 'maintenance_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $chemin = 'assets/images/maintenance/' . $nomFichier;
            move_uploaded_file($_FILES['photo_avant']['tmp_name'], PUBLIC_PATH . '/' . $chemin);
            $photo_avant = $chemin;
        }
    }

    signalerMaintenance([
        'id_produits' => $id_produits,
        'probleme' => $probleme,
        'id_etats_maintenance' => 1,
        'id_utilisateurs' => $id_utilisateur,
        'maintenance_photo_avant' => $photo_avant
    ]);

    header('Location: /?page=maintenance');
    exit;
}

$maintenances = getMaintenancesActives();
$maintenances_historique = getHistoriqueMaintenances();
$produits = getAllProduitsActifs();

require_once(SRC_PATH . '/view/view-maintenance.php');
