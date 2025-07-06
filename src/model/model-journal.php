<?php
require_once(__DIR__ . '/db.php');

function logConnexion(int $userId): bool {
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO journal_connexions (id_utilisateurs, date_connexion, adresse_ip)
        VALUES (:user_id, NOW(), :ip)
    ");

    return $stmt->execute([
        'user_id' => $userId,
        'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ]);
}

function logDeconnexion(int $userId): bool {
    global $pdo;

    $stmt = $pdo->prepare("
        UPDATE journal_connexions 
        SET date_deconnexion = NOW()
        WHERE id_utilisateurs = :user_id
        AND date_deconnexion IS NULL
        ORDER BY date_connexion DESC
        LIMIT 1
    ");

    return $stmt->execute(['user_id' => $userId]);
}

function getJournalConnexionsCount(): int {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM journal_connexions");
    return (int)$stmt->fetchColumn();
}

function getJournalConnexionsWithUsersLimit(int $limit, int $offset): array {
    global $pdo;
    $sql = "
        SELECT jc.*, u.utilisateur_pseudo, u.utilisateur_nom, u.utilisateur_prenom
        FROM journal_connexions jc
        JOIN utilisateurs u ON jc.id_utilisateurs = u.id_utilisateur
        ORDER BY jc.date_connexion DESC
        LIMIT :limit OFFSET :offset
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDernieresConnexions(int $limit = 5): array {
    global $pdo;
    $sql = "SELECT jc.*, u.utilisateur_pseudo, u.utilisateur_photo
            FROM journal_connexions jc
            JOIN utilisateurs u ON jc.id_utilisateurs = u.id_utilisateurs
            ORDER BY jc.date_connexion DESC
            LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
