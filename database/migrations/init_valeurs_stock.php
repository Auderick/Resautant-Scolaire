<?php

require_once 'C:/Users/chris/Desktop/gestion_restaurant_scolaire/config/db.php';
require_once 'C:/Users/chris/Desktop/gestion_restaurant_scolaire/src/Models/synthese.php';

try {
    $db = getPDO();
    
    // Récupérer tous les mois uniques où il y a eu des mouvements de stock
    $sql = "SELECT DISTINCT 
            YEAR(date_mouvement) as annee,
            MONTH(date_mouvement) as mois
            FROM historique_stocks
            ORDER BY date_mouvement";
    
    $stmt = $db->query($sql);
    $periodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $synthese = new Synthese();
    
    foreach ($periodes as $periode) {
        echo "Traitement de la période {$periode['annee']}-{$periode['mois']}...\n";
        try {
            $synthese->updateValeurStockMensuel($periode['mois'], $periode['annee']);
            echo "OK\n";
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage() . "\n";
        }
    }

    echo "Initialisation des valeurs de stock terminée\n";

} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
    exit(1);
}
