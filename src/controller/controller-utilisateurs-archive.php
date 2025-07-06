<?php
require_once(SRC_PATH . '/model/model-utilisateurs.php');

$utilisateurs = getAllUtilisateursArchives();
require_once(SRC_PATH . '/view/view-utilisateurs-archive.php');
