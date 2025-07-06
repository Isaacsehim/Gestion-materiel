<?php
require_once(SRC_PATH . '/model/model-notifications.php');

$userId = $_SESSION['user_id'];

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$total = countNotificationsByUser($userId);

$notifications = getNotificationsByUser($userId, null, $limit, $offset);

require_once(SRC_PATH . '/view/view-notifications-utilisateur.php');
