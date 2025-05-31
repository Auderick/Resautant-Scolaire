<?php

require_once 'C:/Users/chris/Desktop/gestion_restaurant_scolaire/config/db.php';

try {
    $db = getPDO();
    
    // Création de la table valeurs_stock_mensuel si elle n'existe pas déjà
    $sql = "CREATE TABLE IF NOT EXISTS `valeurs_stock_mensuel` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `annee` int(11) NOT NULL,
        `mois` int(11) NOT NULL,
        `valeur_totale` decimal(10,2) NOT NULL DEFAULT '0.00',
        `date_calcul` datetime NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_mois_annee` (`annee`,`mois`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    $db->exec($sql);
    echo "Table valeurs_stock_mensuel créée avec succès\n";

} catch (PDOException $e) {
    echo "Erreur lors de la création de la table: " . $e->getMessage() . "\n";
    exit(1);
}
