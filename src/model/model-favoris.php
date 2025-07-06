<?php

require_once(__DIR__ . '/db.php');

function isFavori(int $user_id, int $id_produit): bool {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM favoris WHERE id_utilisateurs = ? AND id_produits = ?");
    $stmt->execute([$user_id, $id_produit]);
    return $stmt->fetchColumn() > 0;
}

function addFavori(int $user_id, int $id_produit): bool {
    global $pdo;
    $stmt = $pdo->prepare("INSERT IGNORE INTO favoris (id_utilisateurs, id_produits) VALUES (?, ?)");
    return $stmt->execute([$user_id, $id_produit]);
}

function removeFavori(int $user_id, int $id_produit): bool {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM favoris WHERE id_utilisateurs = ? AND id_produits = ?");
    return $stmt->execute([$user_id, $id_produit]);
}

function getFavorisByUser(int $user_id): array {
    global $pdo;
    $sql = "
        SELECT 
            p.*, 
            c.categorie_nom
        FROM 
            favoris f
        JOIN 
            produits p ON f.id_produits = p.id_produits
        LEFT JOIN 
            categories_produits c ON p.id_categories = c.id_categories
        WHERE 
            f.id_utilisateurs = ? 
            AND p.produit_est_supprime = 0
        ORDER BY 
            f.date_ajout DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
