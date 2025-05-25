<?php

require_once __DIR__ . '/../../config/db.php';

try {
    // 1. Supprimer la clé primaire existante
    $db->exec("ALTER TABLE menus_jours DROP PRIMARY KEY");

    // 2. Modifier la colonne id pour être auto-incrémentée
    $db->exec("ALTER TABLE menus_jours MODIFY id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY");

    echo "La colonne id de la table menus_jours a été corrigée avec succès !\n";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
