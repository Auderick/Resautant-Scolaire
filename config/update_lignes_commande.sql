-- Ajout des colonnes pour la gestion des prix HT/TTC
ALTER TABLE lignes_commande 
ADD COLUMN is_ttc BOOLEAN DEFAULT TRUE,
ADD COLUMN taux_tva DECIMAL(4,1) DEFAULT 20.0,
ADD COLUMN prix_ht DECIMAL(10,2) NULL,
ADD COLUMN prix_ttc DECIMAL(10,2) NULL;

-- Mettre à jour les prix HT et TTC pour les lignes existantes
UPDATE lignes_commande
SET 
    prix_ttc = prix_unitaire,
    prix_ht = prix_unitaire / 1.2
WHERE prix_unitaire IS NOT NULL;
