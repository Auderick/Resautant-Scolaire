<?php

// Charger la configuration depuis database.php
$config = require __DIR__ . '/database.php';
$config['charset'] = 'utf8mb4';

// Fonction de journalisation
function db_log($message) {
    $log_file = __DIR__ . '/../logs/db.log';
    $date = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$date] $message\n", FILE_APPEND);
}

try {
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
    db_log("Configuration de connexion :");
    db_log("Host: {$config['host']}");
    db_log("Port: {$config['port']}");
    db_log("Database: {$config['dbname']}");
    db_log("Tentative de connexion MySQL avec DSN: $dsn");
    
    $db = new PDO(
        $dsn,
        $config['user'],
        $config['password'],
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 3
        )
    );
    db_log("Connexion MySQL réussie");
} catch (Exception $e) {
    db_log("ERREUR de connexion MySQL: " . $e->getMessage());
    die('Erreur de connexion : ' . $e->getMessage());
}

// Rendre la configuration disponible globalement
return $config;
