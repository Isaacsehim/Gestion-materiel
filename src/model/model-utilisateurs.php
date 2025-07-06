<?php
require_once(__DIR__ . '/db.php');

function getUserById(int $id): array|false
{
    global $pdo;
    $sql = "
        SELECT u.*, n.niveau_libelle, e.etat_utilisateur_libelle
        FROM utilisateurs u
        LEFT JOIN niveaux n ON u.id_niveaux = n.id_niveaux
        LEFT JOIN etats_utilisateurs e ON u.id_etats_utilisateurs = e.id_etats_utilisateurs
        WHERE u.id_utilisateurs = :id
          AND u.utilisateur_est_supprime = 0
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserByPseudo(string $pseudo): array|false
{
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT u.*, n.niveau_libelle
        FROM utilisateurs u
        LEFT JOIN niveaux n ON u.id_niveaux = n.id_niveaux
        WHERE u.utilisateur_pseudo = :pseudo
            AND u.utilisateur_est_supprime = 0

    ");
    $stmt->execute(['pseudo' => $pseudo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function registerUser(array $data): bool
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM utilisateurs
        WHERE utilisateur_pseudo = :pseudo OR utilisateur_email = :email
    ");
    $stmt->execute([
        'pseudo' => $data['utilisateur_pseudo'],
        'email' => $data['utilisateur_email']
    ]);
    if ($stmt->fetchColumn() > 0) {
        return false;
    }

    $stmt = $pdo->prepare("
        INSERT INTO utilisateurs (
            utilisateur_nom,
            utilisateur_prenom,
            utilisateur_pseudo,
            utilisateur_email,
            utilisateur_motdepasse,
            utilisateur_photo,
            utilisateur_theme,
            utilisateur_notifications,
            id_niveaux,
            id_etats_utilisateurs,
            utilisateur_est_supprime
        ) VALUES (
            :nom, :prenom, :pseudo, :email, :motdepasse, :photo, :theme, :notifications, :niveau, :etat, 0
        )
    ");

    return $stmt->execute([
        'nom'           => $data['utilisateur_nom'],
        'prenom'        => $data['utilisateur_prenom'],
        'pseudo'        => $data['utilisateur_pseudo'],
        'email'         => $data['utilisateur_email'],
        'motdepasse'    => password_hash($data['utilisateur_motdepasse'], PASSWORD_DEFAULT),
        'photo'         => $data['utilisateur_photo'] ?? null,
        'theme'         => $data['utilisateur_theme'],
        'notifications' => $data['utilisateur_notifications'],
        'niveau'        => $data['id_niveaux'],
        'etat'          => $data['id_etats_utilisateurs']
    ]);
}

function updateUser(int $id, array $data, bool $modifierMDP = false): bool
{
    global $pdo;

    if ($modifierMDP) {
        $sql = "
            UPDATE utilisateurs SET
                utilisateur_nom = :nom,
                utilisateur_prenom = :prenom,
                utilisateur_pseudo = :pseudo,
                utilisateur_email = :email,
                utilisateur_theme = :theme,
                utilisateur_notifications = :notifications,
                id_niveaux = :niveau,
                id_etats_utilisateurs = :etat,
                utilisateur_motdepasse = :motdepasse,
                utilisateur_photo = :photo
            WHERE id_utilisateurs = :id AND utilisateur_est_supprime = 0
        ";
    } else {
        $sql = "
            UPDATE utilisateurs SET
                utilisateur_nom = :nom,
                utilisateur_prenom = :prenom,
                utilisateur_pseudo = :pseudo,
                utilisateur_email = :email,
                utilisateur_theme = :theme,
                utilisateur_notifications = :notifications,
                id_niveaux = :niveau,
                id_etats_utilisateurs = :etat,
                utilisateur_photo = :photo
            WHERE id_utilisateurs = :id AND utilisateur_est_supprime = 0
        ";
    }

    $stmt = $pdo->prepare($sql);

    $params = [
        'id' => $id,
        'nom' => $data['utilisateur_nom'],
        'prenom' => $data['utilisateur_prenom'],
        'pseudo' => $data['utilisateur_pseudo'],
        'email' => $data['utilisateur_email'],
        'theme' => $data['utilisateur_theme'],
        'notifications' => $data['utilisateur_notifications'],
        'niveau' => $data['id_niveaux'],
        'etat' => $data['id_etats_utilisateurs'],
        'photo' => $data['utilisateur_photo'] ?? null,
    ];

    if ($modifierMDP) {
        $params['motdepasse'] = $data['utilisateur_motdepasse'];
    }

    return $stmt->execute($params);
}

function supprimerUtilisateur(int $id): bool
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET utilisateur_est_supprime = 1 WHERE id_utilisateurs = :id");
        $result = $stmt->execute(['id' => $id]);
        if (!$result) {
            error_log(print_r($stmt->errorInfo(), true));
        }
        return $result;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function getNiveaux(): array
{
    global $pdo;
    return $pdo->query("SELECT id_niveaux, niveau_libelle FROM niveaux ORDER BY niveau_libelle ASC")->fetchAll(PDO::FETCH_ASSOC);
}

function getEtats(): array
{
    global $pdo;
    return $pdo->query("SELECT id_etats_utilisateurs, etat_utilisateur_libelle FROM etats_utilisateurs ORDER BY etat_utilisateur_libelle ASC")->fetchAll(PDO::FETCH_ASSOC);
}

function countUtilisateursActifs(): int
{
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE utilisateur_est_supprime = 0");
    return (int)$stmt->fetchColumn();
}

function getAllUtilisateursArchives(): array {
    global $pdo;
    $sql = "SELECT * FROM utilisateurs WHERE utilisateur_est_supprime = 1 ORDER BY utilisateur_nom ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserByIdAll(int $id): array|false
{
    global $pdo;
    $sql = "
        SELECT u.*, n.niveau_libelle, e.etat_utilisateur_libelle
        FROM utilisateurs u
        LEFT JOIN niveaux n ON u.id_niveaux = n.id_niveaux
        LEFT JOIN etats_utilisateurs e ON u.id_etats_utilisateurs = e.id_etats_utilisateurs
        WHERE u.id_utilisateurs = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllUsersWithDetails(): array {
    global $pdo;
    $sql = "SELECT u.*, n.niveau_libelle, e.etat_utilisateur_libelle
            FROM utilisateurs u
            LEFT JOIN niveaux n ON u.id_niveaux = n.id_niveaux
            LEFT JOIN etats_utilisateurs e ON u.id_etats_utilisateurs = e.id_etats_utilisateurs
            WHERE u.utilisateur_est_supprime = 0
            ORDER BY u.utilisateur_nom, u.utilisateur_prenom";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}