<?php

require_once(__DIR__ . '/db.php');

function getNotificationsByUser(int $userId, ?bool $nonLues = null, ?int $limit = null, ?int $offset = null): array {
    global $pdo;

    $sql = "
        SELECT n.*, tn.type_libelle 
        FROM notifications n
        JOIN types_notifications tn ON n.id_type_notification = tn.id_type_notification
        WHERE n.id_utilisateurs = :user_id
    ";

    if ($nonLues === true) {
        $sql .= " AND n.notification_lue = 0 ";
    } elseif ($nonLues === false) {
        $sql .= " AND n.notification_lue = 1 ";
    }

    $sql .= " ORDER BY n.notification_date DESC ";

    if ($limit !== null && $offset !== null) {
        $sql .= " LIMIT :limit OFFSET :offset ";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);

    if ($limit !== null && $offset !== null) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function addNotification(int $userId, int $typeId, string $message): bool {
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO notifications (id_utilisateurs, id_type_notification, notification_message)
        VALUES (:user_id, :type_id, :message)
    ");

    return $stmt->execute([
        'user_id' => $userId,
        'type_id' => $typeId,
        'message' => $message,
    ]);
}

function markNotificationAsRead(int $notificationId): bool {
    global $pdo;

    $stmt = $pdo->prepare("
        UPDATE notifications SET notification_lue = 1 WHERE id_notification = :id
    ");

    return $stmt->execute(['id' => $notificationId]);
}

function countUnreadNotifications(int $userId): int {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM notifications WHERE id_utilisateurs = :user_id AND notification_lue = 0
    ");

    $stmt->execute(['user_id' => $userId]);
    return (int)$stmt->fetchColumn();
}

function countNotificationsByUser(int $userId): int {
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE id_utilisateurs = :user_id");
    $stmt->execute(['user_id' => $userId]);
    return (int)$stmt->fetchColumn();
}
