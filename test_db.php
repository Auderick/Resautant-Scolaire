<?php

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Charger la configuration
$config = require __DIR__ . '/config/database.php';

echo "Configuration :\n";
echo "Host: {$config['host']}\n";
echo "Port: {$config['port']}\n";
echo "Database: {$config['dbname']}\n";
echo "User: {$config['user']}\n";
echo "\n";

try {
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4";
    echo "DSN: $dsn\n\n";

    $db = new PDO($dsn, $config['user'], $config['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    echo "Connexion à la base de données réussie !\n";

    // Afficher la version de MySQL
    $version = $db->query('SELECT VERSION()')->fetchColumn();
    echo "Version MySQL : " . $version . "\n";

    // Lister les tables
    $tables = $db->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    echo "\nTables disponibles :\n";
    foreach ($tables as $table) {
        echo "- " . $table . "\n";
    }

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
