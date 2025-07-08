<?php
require_once __DIR__ . '/../config/config.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "<h2 style='color:green'>✅ Connexion réussie à la base de données !</h2>";
} catch (PDOException $e) {
    echo "<h2 style='color:red'>❌ Erreur de connexion :</h2>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}

// Test : http://localhost/test-db.php
// Test : http://localhost