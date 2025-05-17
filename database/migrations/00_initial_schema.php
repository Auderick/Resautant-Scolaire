<?php

require_once __DIR__ . '/../../config/db.php';

try {
    $db->exec('DROP TABLE IF EXISTS `ventes`');
    $db->exec('DROP TABLE IF EXISTS `valeurs_stock_mensuel`');
    $db->exec('DROP TABLE IF EXISTS `utilisateurs`');
    $db->exec('DROP TABLE IF EXISTS `stocks`');
    $db->exec('DROP TABLE IF EXISTS `menus_semaines`');
    $db->exec('DROP TABLE IF EXISTS `menus_jours`');
    $db->exec('DROP TABLE IF EXISTS `lignes_commande`');
    $db->exec('DROP TABLE IF EXISTS `historique_stocks`');
    $db->exec('DROP TABLE IF EXISTS `haccp_documents`');
    $db->exec('DROP TABLE IF EXISTS `commandes`');
    $db->exec('DROP TABLE IF EXISTS `achats`');

    $db->exec("CREATE TABLE `achats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fournisseur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` decimal(10,2) DEFAULT NULL,
  `unite` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `date_achat` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `commande_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_commande_id` (`commande_id`),
  CONSTRAINT `fk_achat_commande` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $db->exec("CREATE TABLE `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fournisseur` varchar(255) NOT NULL,
  `date_commande` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_livraison_souhaitee` date DEFAULT NULL,
  `date_reception` date DEFAULT NULL,
  `statut` enum('brouillon','envoyee','recue','annulee') NOT NULL DEFAULT 'brouillon',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `convertie_en_achats` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8");

    $db->exec("CREATE TABLE `haccp_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `haccp_documents_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8");

    $db->exec("CREATE TABLE `historique_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` int(11) NOT NULL,
  `date_mouvement` datetime NOT NULL,
  `quantite_avant` decimal(10,2) NOT NULL,
  `quantite_apres` decimal(10,2) NOT NULL,
  `type_mouvement` enum('entrée','sortie') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mois_operation` varchar(7) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (date_format(`date_mouvement`,'%Y-%m')) STORED,
  PRIMARY KEY (`id`),
  KEY `idx_date_mouvement` (`date_mouvement`),
  KEY `idx_stock_id` (`stock_id`),
  CONSTRAINT `historique_stocks_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $db->exec("CREATE TABLE `lignes_commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commande_id` int(11) NOT NULL,
  `produit` varchar(255) NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  `is_ttc` tinyint(1) DEFAULT '1',
  `taux_tva` decimal(4,1) DEFAULT '20.0',
  `prix_ht` decimal(10,2) DEFAULT NULL,
  `prix_ttc` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  CONSTRAINT `lignes_commande_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8");

    $db->exec("CREATE TABLE `menus_jours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semaine_id` int(11) NOT NULL,
  `jour` enum('lundi','mardi','jeudi','vendredi') NOT NULL,
  `entree` varchar(255) DEFAULT NULL,
  `plat` varchar(255) NOT NULL,
  `accompagnement` varchar(255) DEFAULT NULL,
  `laitage` varchar(255) DEFAULT NULL,
  `dessert` varchar(255) DEFAULT NULL,
  `options` mediumtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `semaine_id` (`semaine_id`,`jour`),
  CONSTRAINT `menus_jours_ibfk_1` FOREIGN KEY (`semaine_id`) REFERENCES `menus_semaines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8");

    $db->exec("CREATE TABLE `menus_semaines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_semaine` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");

    $db->exec("CREATE TABLE `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unite` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_maj` datetime NOT NULL,
  `seuil_alerte` int(11) DEFAULT '10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_produit` (`produit`),
  KEY `idx_date_maj` (`date_maj`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $db->exec("CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");

    $db->exec("CREATE TABLE `valeurs_stock_mensuel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annee` int(11) NOT NULL,
  `mois` int(11) NOT NULL,
  `valeur_totale` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date_calcul` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mois_annee` (`annee`,`mois`)
) ENGINE=InnoDB AUTO_INCREMENT=606 DEFAULT CHARSET=utf8");

    $db->exec("CREATE TABLE `ventes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nb_repas` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `date_vente` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    echo "Base de données restaurée avec succès !\n";
} catch (PDOException $e) {
    echo "Erreur lors de la restauration : " . $e->getMessage() . "\n";
}
