<?php
require_once(__DIR__ . '/db.php');

function getAllFournisseurs(): array {
    global $pdo;
    $sql = "SELECT * FROM fournisseurs WHERE fournisseur_est_supprime = 0";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFournisseurById(int $id): array|false {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM fournisseurs WHERE id_fournisseurs = :id AND fournisseur_est_supprime = 0");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateFournisseur(int $id, array $data): bool {
    global $pdo;
    $stmt = $pdo->prepare("
        UPDATE fournisseurs SET
            fournisseur_nom = :nom,
            fournisseur_adresse = :adresse,
            fournisseur_telephone = :telephone,
            fournisseur_email = :email,
            fournisseur_site_web = :site_web,
            fournisseur_commentaire = :commentaire,
            fournisseur_est_actif = :est_actif
        WHERE id_fournisseurs = :id AND fournisseur_est_supprime = 0
    ");
    return $stmt->execute([
        'id'          => $id,
        'nom'         => $data['fournisseur_nom'],
        'adresse'     => $data['fournisseur_adresse'] ?? null,
        'telephone'   => $data['fournisseur_telephone'] ?? null,
        'email'       => $data['fournisseur_email'] ?? null,
        'site_web'    => $data['fournisseur_site_web'] ?? null,
        'commentaire' => $data['fournisseur_commentaire'] ?? null,
        'est_actif'   => isset($data['fournisseur_est_actif']) ? (int)$data['fournisseur_est_actif'] : 1,
    ]);
}

function supprimerFournisseur(int $id): bool {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE fournisseurs SET fournisseur_est_supprime = 1 WHERE id_fournisseurs = :id");
    return $stmt->execute(['id' => $id]);
}

