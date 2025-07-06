<?php
require_once(__DIR__ . '/../../config/config.php');

$errorCode = $_GET['code'] ?? '404';

http_response_code((int)$errorCode);

switch ($errorCode) {
    case '403':
        $message = "Accès refusé : vous n'avez pas les droits nécessaires.";
        require_once(SRC_PATH . '/view/view-403.php');
        break;

    case '404':
    default:
        $message = "Page non trouvée.";
        require_once(SRC_PATH . '/view/view-404.php');
        break;
}
