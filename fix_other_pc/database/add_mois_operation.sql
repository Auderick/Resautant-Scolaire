-- Ajout du champ mois_operation à la table historique_stocks
ALTER TABLE `historique_stocks` 
ADD COLUMN `mois_operation` DATE NULL AFTER `date_mouvement`;

-- Mettre à jour les valeurs existantes basées sur date_mouvement
UPDATE `historique_stocks` 
SET `mois_operation` = DATE_FORMAT(date_mouvement, '%Y-%m-01');

-- Rendre le champ obligatoire après la mise à jour des données existantes
ALTER TABLE `historique_stocks` 
MODIFY COLUMN `mois_operation` DATE NOT NULL;
