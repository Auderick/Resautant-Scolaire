<?php

require_once __DIR__ . '/../../config/db.php';

try {
    // Créer une table temporaire avec la bonne structure
    $db->exec("CREATE TABLE menus_jours_temp (
        id INT(11) NOT NULL AUTO_INCREMENT,
        semaine_id INT(11) NOT NULL,
        jour ENUM('lundi','mardi','jeudi','vendredi') NOT NULL,
        entree VARCHAR(255) DEFAULT NULL,
        plat VARCHAR(255) NOT NULL,
        accompagnement VARCHAR(255) DEFAULT NULL,
        laitage VARCHAR(255) DEFAULT NULL,
        dessert VARCHAR(255) DEFAULT NULL,
        options MEDIUMTEXT,
        PRIMARY KEY (id),
        UNIQUE KEY semaine_id (semaine_id,jour)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

    // Copier les données existantes
    $db->exec("INSERT INTO menus_jours_temp (semaine_id, jour, entree, plat, accompagnement, laitage, dessert, options) 
               SELECT semaine_id, jour, entree, plat, accompagnement, laitage, dessert, options FROM menus_jours");

    // Supprimer l'ancienne table
    $db->exec("DROP TABLE menus_jours");

    // Renommer la nouvelle table
    $db->exec("RENAME TABLE menus_jours_temp TO menus_jours");

    echo "La structure de la table menus_jours a été corrigée avec succès !\n";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";

    // En cas d'erreur, essayer de restaurer la table originale
    try {
        $db->exec("DROP TABLE IF EXISTS menus_jours");
        $db->exec("RENAME TABLE menus_jours_temp TO menus_jours");
    } catch (Exception $e2) {
        echo "Erreur lors de la restauration : " . $e2->getMessage() . "\n";
    }
}
