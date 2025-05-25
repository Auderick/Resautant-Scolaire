-- Vérification et mise à jour de la structure de la table historique_stocks
ALTER TABLE historique_stocks 
ADD COLUMN IF NOT EXISTS mois_operation DATE AFTER date_mouvement,
MODIFY COLUMN type_mouvement ENUM('entrée', 'sortie') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Mise à jour des enregistrements existants sans mois_operation
UPDATE historique_stocks 
SET mois_operation = DATE_FORMAT(date_mouvement, '%Y-%m-01')
WHERE mois_operation IS NULL;
