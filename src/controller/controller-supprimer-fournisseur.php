<?php
require_once(SRC_PATH . '/model/model-fournisseurs.php');

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    supprimerFournisseur($id);
}

header('Location: /?page=fournisseurs');
exit;
