<?php

// Configuration par défaut
$config = [
    'host' => 'localhost',
    'dbname' => 'gestion_restaurant_scolaire',
    'charset' => 'utf8',
    'user' => 'root',
    'password' => 'root'
];

// Détection de l'environnement d'exécution
if (isset($_GET['app']) && $_GET['app'] === 'electron') {
    // Configuration pour l'application desktop Electron
    $config['port'] = '3307';
} else {
    // Configuration pour l'environnement web (MAMP)
    $config['port'] = '3306';
}

try {
    $db = new PDO(
        "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}",
        $config['user'],
        $config['password'],
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Rendre la configuration disponible globalement
return $config;
