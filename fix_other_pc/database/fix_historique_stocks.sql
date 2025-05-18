-- Modification de la table historique_stocks pour ajouter AUTO_INCREMENT
ALTER TABLE `historique_stocks` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- S'assurer que toutes les tables utilisent le bon encodage
ALTER TABLE `stocks` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `historique_stocks` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `valeurs_stock_mensuel` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
