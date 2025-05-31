<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_error.log');

$config = require __DIR__ . '/../config/database.php';

try {
    echo "Tentative de connexion à MySQL...\n";
    // Connexion à MySQL sans sélectionner de base de données
    $pdo = new PDO(
        "mysql:host={$config['host']};port={$config['port']}",
        $config['user'],
        $config['password'],
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    echo "Connexion réussie!\n";
    
    // Créer la base de données si elle n'existe pas
    echo "Création de la base de données {$config['dbname']}...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$config['dbname']}");
    echo "Base de données créée ou déjà existante.\n";
    
    // Sélectionner la base de données
    echo "Sélection de la base de données...\n";
    $pdo->exec("USE {$config['dbname']}");
      // Importer init_database.sql
    echo "Importation du schéma de base de données...\n";
    $sqlFile = __DIR__ . '/../gestion_restaurant_desktop/init_database.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("Le fichier init_database.sql n'existe pas à l'emplacement : $sqlFile");
    }
    $sql = file_get_contents($sqlFile);
    
    // Exécuter chaque instruction SQL séparément
    $queries = explode(';', $sql);
    foreach($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            try {
                $pdo->exec($query);
                echo ".";
            } catch (PDOException $e) {
                echo "\nErreur SQL : " . $e->getMessage() . "\nRequête : " . $query . "\n";
            }
        }
    }
    echo "\n";
    echo "Schéma de base de données importé.\n";
      // Importer init_user.sql
    echo "Importation des données utilisateur...\n";
    $sqlFile = __DIR__ . '/../gestion_restaurant_desktop/init_user.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("Le fichier init_user.sql n'existe pas à l'emplacement : $sqlFile");
    }
    $sql = file_get_contents($sqlFile);
    
    // Exécuter chaque instruction SQL séparément
    $queries = explode(';', $sql);
    foreach($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            try {
                $pdo->exec($query);
                echo ".";
            } catch (PDOException $e) {
                echo "\nErreur SQL : " . $e->getMessage() . "\nRequête : " . $query . "\n";
            }
        }
    }
    echo "\n";
    
    echo "Base de données initialisée avec succès!\n";
    
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage() . "\n");
}
