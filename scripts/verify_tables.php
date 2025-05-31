<?php
require_once __DIR__ . '/../config/db.php';

try {
    $pdo = getPDO();
    
    // Afficher toutes les tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables présentes dans la base de données :\n";
    print_r($tables);

    // Liste des tables attendues
    $required_tables = [
        'achats',
        'commandes',
        'lignes_commande',
        'ventes',
        'stocks',
        'mouvements_stock',
        'presences',
        'categories',
        'personnes',
        'syntheses',
        'utilisateurs'
    ];

    // Vérifier les tables manquantes
    $missing_tables = array_diff($required_tables, $tables);
    
    if (!empty($missing_tables)) {
        echo "\nTables manquantes :\n";
        print_r($missing_tables);
    } else {
        echo "\nToutes les tables requises sont présentes.\n";
    }

    // Vérifier la structure de chaque table existante
    foreach ($tables as $table) {
        $result = $pdo->query("SHOW CREATE TABLE `$table`");
        echo "\nStructure de la table $table :\n";
        $create = $result->fetch(PDO::FETCH_ASSOC);
        echo $create['Create Table'] . "\n";
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
