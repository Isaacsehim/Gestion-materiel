<?php

require_once(__DIR__ . '/../model/model-utilisateurs.php');

$utilisateurs = getAllUsersWithDetails();

require_once(__DIR__ . '/../view/view-utilisateurs.php');
