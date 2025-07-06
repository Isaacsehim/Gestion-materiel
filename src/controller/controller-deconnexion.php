<?php

require_once(SRC_PATH . '/model/model-journal.php');

if (isset($_SESSION['user_id'])) {
    logDeconnexion($_SESSION['user_id']);
}

session_unset();
session_destroy();

require_once(SRC_PATH . '/view/view-deconnexion-utilisateur.php');
exit;
