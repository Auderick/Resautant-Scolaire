-- Vérifier et corriger la structure des tables liées aux stocks

-- Table stocks
ALTER TABLE `stocks` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `stocks` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Table historique_stocks
-- D'abord, créer une sauvegarde
CREATE TABLE `historique_stocks_backup` LIKE `historique_stocks`;
INSERT INTO `historique_stocks_backup` SELECT * FROM `historique_stocks`;

-- Supprimer et recréer la table historique_stocks avec la bonne structure
DROP TABLE IF EXISTS `historique_stocks`;
CREATE TABLE `historique_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` int(11) NOT NULL,
  `date_mouvement` datetime NOT NULL,
  `quantite_avant` decimal(10,2) NOT NULL,
  `quantite_apres` decimal(10,2) NOT NULL,
  `type_mouvement` enum('entrée','sortie') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `stock_id` (`stock_id`),
  CONSTRAINT `historique_stocks_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Restaurer les données depuis la sauvegarde
INSERT INTO `historique_stocks` (
  `stock_id`,
  `date_mouvement`,
  `quantite_avant`,
  `quantite_apres`,
  `type_mouvement`,
  `created_at`
) SELECT 
  `stock_id`,
  `date_mouvement`,
  `quantite_avant`,
  `quantite_apres`,
  `type_mouvement`,
  `created_at`
FROM `historique_stocks_backup`;

-- Supprimer la table de sauvegarde
DROP TABLE `historique_stocks_backup`;

-- Table valeurs_stock_mensuel
ALTER TABLE `valeurs_stock_mensuel` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `valeurs_stock_mensuel` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- S'assurer que toutes les contraintes sont en place
ALTER TABLE `historique_stocks` ADD CONSTRAINT `historique_stocks_ibfk_1` 
FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

-- Vérifier et réparer les tables
REPAIR TABLE `stocks`, `historique_stocks`, `valeurs_stock_mensuel`;
ANALYZE TABLE `stocks`, `historique_stocks`, `valeurs_stock_mensuel`;
