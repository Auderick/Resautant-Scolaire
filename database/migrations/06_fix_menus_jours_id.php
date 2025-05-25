<?php

require_once __DIR__ . '/../../config/db.php';

try {
    // 1. Vérifier si la table existe
    $tableCheck = $db->query("SHOW TABLES LIKE 'menus_jours'");
    if ($tableCheck->rowCount() == 0) {
        echo "La table menus_jours n'existe pas.\n";
        exit;
    }

    // 2. Créer une sauvegarde temporaire
    $db->exec("CREATE TABLE menus_jours_backup LIKE menus_jours");
    $db->exec("INSERT INTO menus_jours_backup SELECT * FROM menus_jours");

    // 3. Recréer la table avec la bonne structure
    $db->exec("DROP TABLE menus_jours");
    $db->exec("CREATE TABLE menus_jours (
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
        UNIQUE KEY semaine_id (semaine_id,jour),
        CONSTRAINT menus_jours_ibfk_1 FOREIGN KEY (semaine_id) REFERENCES menus_semaines (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

    // 4. Restaurer les données
    $db->exec("INSERT INTO menus_jours (semaine_id, jour, entree, plat, accompagnement, laitage, dessert, options)
              SELECT semaine_id, jour, entree, plat, accompagnement, laitage, dessert, options FROM menus_jours_backup");

    // 5. Supprimer la table de sauvegarde
    $db->exec("DROP TABLE menus_jours_backup");

    echo "La structure de la table menus_jours a été corrigée avec succès !\n";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
    // En cas d'erreur, tenter de restaurer la sauvegarde
    if ($db->query("SHOW TABLES LIKE 'menus_jours_backup'")->rowCount() > 0) {
        $db->exec("DROP TABLE IF EXISTS menus_jours");
        $db->exec("RENAME TABLE menus_jours_backup TO menus_jours");
        echo "La sauvegarde a été restaurée.\n";
    }
}
