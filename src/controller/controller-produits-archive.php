<?php
require_once(SRC_PATH . '/model/model-produits.php');
require_once(SRC_PATH . '/model/model-fournisseurs.php');

$produits = getAllProduitsArchives();
$fournisseurs = getAllFournisseurs();

require_once(SRC_PATH . '/view/view-produits-archive.php');
