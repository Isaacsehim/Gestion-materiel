<?php
function getEtatsProduits(): array {
    global $pdo;
    $stmt = $pdo->query("SELECT id_etats, etat_libelle FROM etats_produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
