<?php
require_once(SRC_PATH . '/model/model-notifications.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /?page=login');
    exit;
}

$userId = $_SESSION['user_id'];

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['csrf_token'], $_POST['notification_id']) &&
    $_POST['csrf_token'] === ($_SESSION['csrf_token'] ?? '')
) {
    $notificationId = (int)$_POST['notification_id'];

    if ($notificationId > 0) {
        $notifications = getNotificationsByUser($userId);
        $ids = array_column($notifications, 'id_notification');

        if (in_array($notificationId, $ids)) {
            markNotificationAsRead($notificationId);
        }
    }
}

header('Location: /?page=notifications-utilisateur');
exit;
