<?php
require_once(SRC_PATH . '/model/db.php');

function getMaintenancesActives(): array {
    $db = getDB();
    $sql = "SELECT m.*, p.produit_denomination, e.etat_maintenance_libelle
            FROM maintenance m
            JOIN produits p ON m.id_produits = p.id_produits
            JOIN etats_maintenance e ON m.id_etats_maintenance = e.id_etats_maintenance
            WHERE e.etat_maintenance_libelle NOT IN ('Résolu', 'Abandonné', 'Non réparable')
            ORDER BY m.maintenance_date_declaration DESC";
    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getHistoriqueMaintenances(PDO $db): array {
    $sql = "SELECT m.*, p.produit_denomination, e.etat_maintenance_libelle
            FROM maintenance m
            JOIN produits p ON m.id_produits = p.id_produits
            JOIN etats_maintenance e ON m.id_etats_maintenance = e.id_etats_maintenance
            WHERE e.etat_maintenance_libelle IN ('Résolu', 'Abandonné', 'Non réparable')
            ORDER BY m.maintenance_date_declaration DESC";
    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function signalerMaintenance(PDO $db, array $data): bool {
    $stmt = $db->prepare("INSERT INTO maintenance (
        id_produits, maintenance_type_probleme, id_etats_maintenance,
        id_utilisateurs, maintenance_date_declaration, maintenance_photo_avant
    ) VALUES (
        :id_produits, :probleme, :etat, :id_utilisateurs, NOW(), :photo_avant
    )");
    return $stmt->execute([
        'id_produits' => $data['id_produits'],
        'probleme' => $data['probleme'],
        'etat' => $data['id_etats_maintenance'],
        'id_utilisateurs' => $data['id_utilisateurs'],
        'photo_avant' => $data['maintenance_photo_avant']
    ]);
}
