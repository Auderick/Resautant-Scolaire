<?php
require_once __DIR__ . '/../config/db.php';

try {
    echo "Création des tables manquantes...\n";
      // Table commandes
    $pdo->exec("CREATE TABLE IF NOT EXISTS commandes (
        id int(11) NOT NULL AUTO_INCREMENT,
        fournisseur varchar(255) NOT NULL,
        date_commande datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        date_livraison_souhaitee date DEFAULT NULL,
        date_reception date DEFAULT NULL,
        statut enum('brouillon','envoyee','recue','annulee') NOT NULL DEFAULT 'brouillon',
        notes text,
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        convertie_en_achats tinyint(1) DEFAULT '0',
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table commandes créée.\n";

    // Table lignes_commande
    $pdo->exec("CREATE TABLE IF NOT EXISTS lignes_commande (
        id int(11) NOT NULL AUTO_INCREMENT,
        commande_id int(11) NOT NULL,
        produit varchar(255) NOT NULL,
        quantite decimal(10,2) NOT NULL,
        unite varchar(50) DEFAULT NULL,
        prix_unitaire decimal(10,2) DEFAULT NULL,
        is_ttc tinyint(1) DEFAULT '1',
        taux_tva decimal(4,1) DEFAULT '20.0',
        prix_ht decimal(10,2) DEFAULT NULL,
        prix_ttc decimal(10,2) DEFAULT NULL,
        PRIMARY KEY (id),
        KEY commande_id (commande_id),
        CONSTRAINT lignes_commande_ibfk_1 FOREIGN KEY (commande_id) 
        REFERENCES commandes (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table lignes_commande créée.\n";    // Table achats
    $pdo->exec("CREATE TABLE IF NOT EXISTS achats (
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
        CONSTRAINT fk_achat_commande FOREIGN KEY (commande_id) 
        REFERENCES commandes (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");    echo "Table achats créée.\n";

    // Table ventes
    $pdo->exec("CREATE TABLE IF NOT EXISTS ventes (
        id int(11) NOT NULL AUTO_INCREMENT,
        nb_repas int(11) NOT NULL,
        prix_unitaire decimal(10,2) NOT NULL,
        date_vente datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo "Table ventes créée.\n";

    echo "Toutes les tables ont été créées avec succès.\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
