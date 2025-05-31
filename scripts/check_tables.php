<?php
require_once __DIR__ . '/../config/db.php';

try {
    $pdo = getPDO();
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables présentes dans la base de données :\n";
    print_r($tables);
    
    // Vérifier spécifiquement la table commandes
    $result = $db->query("SHOW CREATE TABLE commandes");
    echo "\nStructure de la table commandes :\n";
    print_r($result->fetch(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
