<?php

// Configuration par défaut
$config = [
    'host' => '127.0.0.1',
    'dbname' => 'gestion_restaurant_scolaire',
    'charset' => 'utf8',
    'user' => 'root',
    'password' => 'root',
    'port' => '3307'
];

try {
    $db = new PDO(
        "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}",
        $config['user'],
        $config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}