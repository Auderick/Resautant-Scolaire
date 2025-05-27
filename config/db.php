<?php

try {
    $db = new PDO(
        'mysql:host=localhost;port=3307;dbname=gestion_restaurant_scolaire;charset=utf8',
        'root',
        'root',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
