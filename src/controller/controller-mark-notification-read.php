<?php
require_once(SRC_PATH . '/model/model-notifications.php');

$userId = $_SESSION['user_id'];
$notificationId = (int)($_GET['id'] ?? 0);

if ($notificationId > 0) {
    $notifications = getNotificationsByUser($userId);
    $ids = array_column($notifications, 'id_notification');
    if (in_array($notificationId, $ids)) {
        markNotificationAsRead($notificationId);
    }
}

header('Location: /?page=notifications-utilisateur');
exit;
