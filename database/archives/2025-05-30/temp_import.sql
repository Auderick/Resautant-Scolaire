-- Configuration
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Tables
CREATE TABLE `achats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fournisseur` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `quantite` decimal(10,2) DEFAULT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `date_achat` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `commande_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `commandes` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `haccp_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `haccp_documents_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `historique_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` int(11) NOT NULL,
  `date_mouvement` datetime NOT NULL,
  `quantite_avant` decimal(10,2) NOT NULL,
  `quantite_apres` decimal(10,2) NOT NULL,
  `type_mouvement` enum('entrée','sortie') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `stock_id` (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `lignes_commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commande_id` int(11) NOT NULL,
  `produit` varchar(255) NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  `taux_tva` decimal(4,1) DEFAULT '20.0',
  `prix_ht` decimal(10,2) DEFAULT NULL,
  `prix_ttc` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  CONSTRAINT `lignes_commande_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `menus_jours` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `menus_semaines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_semaine` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `personnes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `classe` varchar(50) DEFAULT NULL,
  `actif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `categorie_id` (`categorie_id`),
  CONSTRAINT `personnes_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `presences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personne_id` int(11) NOT NULL,
  `date_presence` date NOT NULL,
  `present` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_presence` (`personne_id`,`date_presence`),
  CONSTRAINT `presences_ibfk_1` FOREIGN KEY (`personne_id`) REFERENCES `personnes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unite` varchar(50) NOT NULL,
  `date_maj` datetime NOT NULL,
  `seuil_alerte` int(11) DEFAULT '10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `valeurs_stock_mensuel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annee` int(11) NOT NULL,
  `mois` int(11) NOT NULL,
  `valeur_totale` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date_calcul` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mois_annee` (`annee`,`mois`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ventes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nb_repas` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `date_vente` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ajout des contraintes étrangères
ALTER TABLE `historique_stocks`
  ADD CONSTRAINT `historique_stocks_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

-- Insertions des données de base
INSERT INTO `categories` (`nom`) VALUES
('Maternelle'),
('Primaire'),
('Personnel');

COMMIT;
