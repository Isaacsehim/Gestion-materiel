<?php
// model-produits.php

require_once(__DIR__ . '/db.php');

function ajouterProduit(array $data): bool {
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO produits (
            produit_denomination,
            produit_description,
            id_categories,
            id_etats,
            produit_photo,
            produit_code_barres,
            id_fournisseurs,  -- AJOUTE ICI
            produit_est_supprime
        ) VALUES (
            :denomination, :description, :categorie, :etat, :photo, :code_barres, :fournisseur, 0
        )
    ");

    return $stmt->execute([
        'denomination' => $data['produit_denomination'],
        'description'  => $data['produit_description'],
        'categorie'    => $data['id_categories'],
        'etat'         => $data['id_etats'],
        'photo'        => $data['produit_photo'] ?? null,
        'code_barres'  => $data['produit_code_barres'],
        'fournisseur'  => $data['id_fournisseurs'] > 0 ? $data['id_fournisseurs'] : null,
    ]);
}

function getProduitById(int $id): array|false {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produits = :id AND produit_est_supprime = 0");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateProduit(int $id, array $data): bool {
    global $pdo;

    $stmt = $pdo->prepare("
        UPDATE produits SET
            produit_denomination = :denomination,
            produit_description = :description,
            id_categories = :categorie,
            id_etats = :etat,
            produit_photo = :photo
        WHERE id_produits = :id AND produit_est_supprime = 0
    ");

    return $stmt->execute([
        'id'          => $id,
        'denomination'=> $data['produit_denomination'],
        'description' => $data['produit_description'],
        'categorie'   => $data['id_categories'],
        'etat'        => $data['id_etats'],
        'photo'       => $data['produit_photo'] ?? null,
    ]);
}

function supprimerProduit(int $id): bool {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE produits SET produit_est_supprime = 1 WHERE id_produits = :id");
    return $stmt->execute(['id' => $id]);
}

function getProduitsVitrine(int $limit = 4): array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE produit_est_supprime = 0 ORDER BY RAND() LIMIT :limit");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDerniersProduits(int $limit = 5): array {
    global $pdo;
    $sql = "SELECT p.*, u.utilisateur_pseudo
            FROM produits p
            LEFT JOIN utilisateurs u ON p.id_utilisateurs = u.id_utilisateurs
            WHERE p.produit_est_supprime = 0
            ORDER BY p.produit_modifiee DESC
            LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countProduits(): int {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM produits WHERE produit_est_supprime = 0");
    return (int)$stmt->fetchColumn();
}

function getAllProduitsArchives(): array {
    global $pdo;
    $sql = "
        SELECT p.*, f.fournisseur_nom
        FROM produits p
        LEFT JOIN fournisseurs f ON p.id_fournisseurs = f.id_fournisseurs
        WHERE p.produit_est_supprime = 1
        ORDER BY p.produit_denomination ASC
    ";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProduitsFiltrés(array $filtres = []): array {
    global $pdo;
    $where = ["p.produit_est_supprime = 0"];
    $params = [];

    if (!empty($filtres['fournisseur'])) {
        $where[] = "p.id_fournisseurs = :fournisseur";
        $params['fournisseur'] = $filtres['fournisseur'];
    }

    if (!empty($filtres['lieu'])) {
        $where[] = "p.id_lieux = :lieu";
        $params['lieu'] = $filtres['lieu'];
    }

    if (!empty($filtres['marque'])) {
        $where[] = "p.produit_marque_modele = :marque";
        $params['marque'] = $filtres['marque'];
    }

    $tri = "p.produit_date_arrivee";
    if (!empty($filtres['tri'])) {
        if ($filtres['tri'] === 'nom') $tri = "p.produit_denomination";
    }
    $ordre = (isset($filtres['ordre']) && strtolower($filtres['ordre']) === 'asc') ? "ASC" : "DESC";

    $sql = "
        SELECT p.*, f.fournisseur_nom, c.categorie_nom, l.lieu_nom
        FROM produits p
        LEFT JOIN fournisseurs f ON p.id_fournisseurs = f.id_fournisseurs
        LEFT JOIN categories_produits c ON p.id_categories = c.id_categories
        LEFT JOIN lieux l ON p.id_lieux = l.id_lieux
        WHERE " . implode(' AND ', $where) . "
        ORDER BY $tri $ordre
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMarquesDisponibles(): array {
    global $pdo;
    $stmt = $pdo->query("SELECT DISTINCT produit_marque_modele FROM produits WHERE produit_marque_modele IS NOT NULL AND produit_marque_modele != ''");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
function getLieuxDisponibles(): array {
    global $pdo;
    $stmt = $pdo->query("SELECT l.id_lieux, l.lieu_nom FROM lieux l ORDER BY l.lieu_nom");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
