-- Ajout des colonnes manquantes à la table categories
ALTER TABLE `categories`
ADD COLUMN `description` TEXT COLLATE utf8mb4_unicode_ci AFTER `nom`,
ADD COLUMN `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `description`;
