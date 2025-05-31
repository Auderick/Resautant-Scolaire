<?php
require_once __DIR__ . '/../config/db.php';

try {
    $pdo = getPDO();
    
    // Table stocks
    $pdo->exec("CREATE TABLE IF NOT EXISTS stocks (
        id int(11) NOT NULL AUTO_INCREMENT,
        produit varchar(255) NOT NULL,
        quantite decimal(10,2) NOT NULL DEFAULT '0.00',
        unite varchar(50) DEFAULT NULL,
        prix_unitaire decimal(10,2) DEFAULT NULL,
        seuil_alerte decimal(10,2) DEFAULT '10.00',
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY produit (produit)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table stocks créée.\n";

    // Table mouvements_stock
    $pdo->exec("CREATE TABLE IF NOT EXISTS mouvements_stock (
        id int(11) NOT NULL AUTO_INCREMENT,
        stock_id int(11) NOT NULL,
        type_mouvement enum('entree','sortie') NOT NULL,
        quantite decimal(10,2) NOT NULL,
        prix_unitaire decimal(10,2) DEFAULT NULL,
        date_mouvement datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        commentaire text,
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY stock_id (stock_id),
        CONSTRAINT mouvements_stock_ibfk_1 FOREIGN KEY (stock_id) REFERENCES stocks (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table mouvements_stock créée.\n";

    // Table categories
    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
        id int(11) NOT NULL AUTO_INCREMENT,
        nom varchar(100) NOT NULL,
        description text,
        PRIMARY KEY (id),
        UNIQUE KEY nom (nom)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table categories créée.\n";

    // Table personnes
    $pdo->exec("CREATE TABLE IF NOT EXISTS personnes (
        id int(11) NOT NULL AUTO_INCREMENT,
        nom varchar(100) NOT NULL,
        prenom varchar(100) NOT NULL,
        categorie_id int(11) NOT NULL,
        actif tinyint(1) DEFAULT '1',
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY categorie_id (categorie_id),
        CONSTRAINT personnes_ibfk_1 FOREIGN KEY (categorie_id) REFERENCES categories (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table personnes créée.\n";

    // Table presences
    $pdo->exec("CREATE TABLE IF NOT EXISTS presences (
        id int(11) NOT NULL AUTO_INCREMENT,
        personne_id int(11) NOT NULL,
        date_presence date NOT NULL,
        present tinyint(1) DEFAULT '1',
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY personne_date (personne_id, date_presence),
        KEY personne_id (personne_id),
        CONSTRAINT presences_ibfk_1 FOREIGN KEY (personne_id) REFERENCES personnes (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table presences créée.\n";

    // Table syntheses
    $pdo->exec("CREATE TABLE IF NOT EXISTS syntheses (
        id int(11) NOT NULL AUTO_INCREMENT,
        mois int(2) NOT NULL,
        annee int(4) NOT NULL,
        nb_repas_total int(11) DEFAULT '0',
        montant_achats decimal(10,2) DEFAULT '0.00',
        montant_ventes decimal(10,2) DEFAULT '0.00',
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY mois_annee (mois, annee)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table syntheses créée.\n";

    echo "\nToutes les tables manquantes ont été créées avec succès.\n";

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
