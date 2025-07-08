<?php

if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_contains(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

define('DB_HOST', $_ENV['MYSQL_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['MYSQL_DATABASE'] ?? 'gestion');
define('DB_USER', $_ENV['MYSQL_USER'] ?? 'user');
define('DB_PASS', $_ENV['MYSQL_PASSWORD'] ?? 'pass');

define('BASE_PATH', realpath(__DIR__ . '/..'));
define('SRC_PATH', BASE_PATH . '/src');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('ASSETS_PATH', PUBLIC_PATH . '/assets');
define('LOGS_PATH', BASE_PATH . '/logs');

ini_set('log_errors', 1);
ini_set('error_log', LOGS_PATH . '/error.log');
error_reporting(E_ALL);