<?php
require_once(__DIR__ . '/db.php');

function getDernierMouvement() {
    global $pdo;
    $sql = "
        SELECT 
            m.*,
            p.produit_denomination AS produit_denomination,
            u.utilisateur_pseudo,
            m.mouvement_type AS type_mouvement,
            m.mouvement_date_sortie AS date_mouvement
        FROM mouvements m
        JOIN produits p ON p.id_produits = m.id_produits
        LEFT JOIN utilisateurs u ON u.id_utilisateurs = m.id_utilisateurs
        ORDER BY m.mouvement_date_sortie DESC
        LIMIT 1
    ";
    $stmt = $pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function countMouvements(): int {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM mouvements");
    return (int)$stmt->fetchColumn();
}

