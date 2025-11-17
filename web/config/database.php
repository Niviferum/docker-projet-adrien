<?php

function getDatabaseConnection() {
    $host = getenv('MYSQL_HOST') ?: 'database';
    $dbname = getenv('MYSQL_DATABASE') ?: 'bandnames';
    $user = getenv('MYSQL_USER') ?: 'banduser';
    $password = getenv('MYSQL_PASSWORD') ?: '';

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, $user, $password, $options);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        return null;
    }
}