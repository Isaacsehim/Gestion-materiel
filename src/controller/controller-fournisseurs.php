<?php
require_once(SRC_PATH . '/model/model-fournisseurs.php');

$fournisseurs = getAllFournisseurs();

require_once(SRC_PATH . '/view/view-fournisseurs.php');

