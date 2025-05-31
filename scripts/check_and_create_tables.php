<?php
require_once __DIR__ . '/../config/db.php';

try {
    $pdo = getPDO();
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables existantes :\n";
    print_r($tables);

    // Liste des tables requises et leurs définitions
    $requiredTables = [
        'ventes' => "
            CREATE TABLE IF NOT EXISTS ventes (
                id int(11) NOT NULL AUTO_INCREMENT,
                nb_repas int(11) NOT NULL,
                prix_unitaire decimal(10,2) NOT NULL,
                date_vente datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        'achats' => "
            CREATE TABLE IF NOT EXISTS achats (
                id int(11) NOT NULL AUTO_INCREMENT,
                fournisseur varchar(255) NOT NULL,
                description text NOT NULL,
                quantite decimal(10,2) DEFAULT NULL,
                unite varchar(50) DEFAULT NULL,
                prix_unitaire decimal(10,2) DEFAULT NULL,
                montant_total decimal(10,2) NOT NULL,
                date_achat datetime NOT NULL,
                created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                commande_id int(11) DEFAULT NULL,
                PRIMARY KEY (id),
                KEY idx_commande_id (commande_id),
                CONSTRAINT fk_achat_commande FOREIGN KEY (commande_id) REFERENCES commandes (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        'stocks' => "
            CREATE TABLE IF NOT EXISTS stocks (
                id int(11) NOT NULL AUTO_INCREMENT,
                produit varchar(255) NOT NULL,
                quantite decimal(10,2) NOT NULL DEFAULT '0.00',
                unite varchar(50) DEFAULT NULL,
                prix_unitaire decimal(10,2) DEFAULT NULL,
                seuil_alerte int(11) DEFAULT '10',
                created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                UNIQUE KEY produit (produit)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        'mouvements_stock' => "
            CREATE TABLE IF NOT EXISTS mouvements_stock (
                id int(11) NOT NULL AUTO_INCREMENT,
                stock_id int(11) NOT NULL,
                type_mouvement enum('entree','sortie') NOT NULL,
                quantite decimal(10,2) NOT NULL,
                date_mouvement datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                commentaire text,
                created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                KEY stock_id (stock_id),
                CONSTRAINT mouvements_stock_ibfk_1 FOREIGN KEY (stock_id) REFERENCES stocks (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        'presences' => "
            CREATE TABLE IF NOT EXISTS presences (
                id int(11) NOT NULL AUTO_INCREMENT,
                personne_id int(11) NOT NULL,
                date_presence date NOT NULL,
                present tinyint(1) NOT NULL DEFAULT '0',
                created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                KEY personne_id (personne_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        'categories' => "
            CREATE TABLE IF NOT EXISTS categories (
                id int(11) NOT NULL AUTO_INCREMENT,
                nom varchar(255) NOT NULL,
                description text,
                ordre int(11) DEFAULT '0',
                PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    ];

    // Créer les tables manquantes
    foreach ($requiredTables as $table => $sql) {
        if (!in_array($table, $tables)) {
            echo "Création de la table {$table}...\n";
            $pdo->exec($sql);
            echo "Table {$table} créée avec succès.\n";
        } else {
            echo "La table {$table} existe déjà.\n";
        }
    }

    echo "\nVérification finale des tables :\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    print_r($tables);

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
    exit(1);
}
