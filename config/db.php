<?php

// Charger la configuration depuis database.php
$config = require __DIR__ . '/database.php';
$config['charset'] = 'utf8mb4';

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
