<?php

require_once __DIR__ . '/../config/db.php';

// Vérifier si les colonnes existent
$checkColumnsQuery = "SELECT COLUMN_NAME 
                     FROM INFORMATION_SCHEMA.COLUMNS 
                     WHERE TABLE_SCHEMA = 'compte_restaurant_scolaire' 
                     AND TABLE_NAME = 'lignes_commande'";

$stmt = $db->query($checkColumnsQuery);
$existingColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);

$requiredColumns = [
    'is_ttc',
    'taux_tva',
    'prix_ht',
    'prix_ttc'
];

$missingColumns = array_diff($requiredColumns, $existingColumns);

if (!empty($missingColumns)) {
    echo "Colonnes manquantes trouvées : " . implode(', ', $missingColumns) . "\n";
    echo "Exécution du script de mise à jour...\n";
    
    try {
        $updateQuery = "ALTER TABLE lignes_commande 
                       ADD COLUMN is_ttc BOOLEAN DEFAULT TRUE,
                       ADD COLUMN taux_tva DECIMAL(4,1) DEFAULT 20.0,
                       ADD COLUMN prix_ht DECIMAL(10,2) NULL,
                       ADD COLUMN prix_ttc DECIMAL(10,2) NULL";
        
        $db->exec($updateQuery);
        
        // Mise à jour des données existantes
        $updateDataQuery = "UPDATE lignes_commande 
                          SET prix_ttc = prix,
                              prix_ht = ROUND(prix / 1.20, 2)
                          WHERE prix_ttc IS NULL";
        
        $db->exec($updateDataQuery);
        
        echo "Mise à jour effectuée avec succès !\n";
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage() . "\n";
    }
} else {
    echo "Toutes les colonnes nécessaires sont déjà présentes dans la table.\n";
}
