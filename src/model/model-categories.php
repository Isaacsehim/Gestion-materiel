<?php
function getCategories(): array {
    global $pdo;
    $stmt = $pdo->query("SELECT id_categories, categorie_nom FROM categories_produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
