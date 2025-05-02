<?php

require_once __DIR__ . '/../Utils/Logger.php';

class Synthese
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function updateValeurStockMensuel($mois, $annee)
    {
        $mois = intval($mois);
        $annee = intval($annee);
        $mois_operation = sprintf('%04d-%02d', $annee, $mois);
        $date_fin = date('Y-m-t 23:59:59', strtotime("$annee-$mois-01"));

        try {
            // 1. Suppression valeur existante
            $delete = "DELETE FROM valeurs_stock_mensuel WHERE annee = ? AND mois = ?";
            $stmt = $this->db->prepare($delete);
            $stmt->execute([$annee, $mois]);

            // 2. Nouvelle requête qui prend en compte le dernier mouvement réel
            $sql = "SELECT 
            s.id,
            s.prix_unitaire,
            COALESCE(
                (SELECT h.quantite_apres 
                FROM historique_stocks h 
                WHERE h.stock_id = s.id 
                AND DATE_FORMAT(h.date_mouvement, '%Y-%m') = ?
                AND h.id = (
                    SELECT MAX(h2.id)
                    FROM historique_stocks h2
                    WHERE h2.stock_id = s.id
                    AND DATE_FORMAT(h2.date_mouvement, '%Y-%m') = ?
                )
                ),
                0
            ) as quantite_apres
        FROM stocks s
        WHERE EXISTS (
            SELECT 1 
            FROM historique_stocks h 
            WHERE h.stock_id = s.id 
            AND DATE_FORMAT(h.date_mouvement, '%Y-%m') = ?
        )";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$mois_operation, $mois_operation, $mois_operation]);
            $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            Logger::log('Stocks trouvés', [
                'nombre_stocks' => count($stocks),
                'mois' => $mois,
                'annee' => $annee,
                'mois_operation' => $mois_operation,
                'stocks' => $stocks
            ]);

            // 3. Calcul de la valeur totale
            $valeur_totale = 0;
            foreach ($stocks as $stock) {
                $valeur_totale += $stock['prix_unitaire'] * $stock['quantite_apres'];
            }

            // 4. Insertion
            $insert = "INSERT INTO valeurs_stock_mensuel (annee, mois, valeur_totale, date_calcul)
                  VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($insert);
            $stmt->execute([$annee, $mois, $valeur_totale, $date_fin]);

            Logger::log('Fin mise à jour valeur stock mensuel', [
                'mois_traite' => $mois,
                'annee_traitee' => $annee,
                'valeur_inseree' => $valeur_totale,
                'date_calcul' => $date_fin
            ]);

        } catch (Exception $e) {
            Logger::log('Erreur mise à jour valeur stock mensuel', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function getSyntheseMensuelle($mois, $annee)
    {
        $date_format = sprintf('%04d-%02d', $annee, $mois);
        $date_fin_mois = date('Y-m-t', strtotime($date_format . '-01'));
        $sql = "SELECT 
    COALESCE(SUM(v.nb_repas * v.prix_unitaire), 0) as total_ventes,
    SUM(v.nb_repas) as nombre_couverts,
    (
        SELECT COALESCE(SUM(a.montant), 0)
        FROM achats a
        WHERE DATE_FORMAT(a.date_achat, '%Y-%m') = ?
    ) as total_achats,
    (
        SELECT valeur_totale 
        FROM valeurs_stock_mensuel
        WHERE annee = ? AND mois = ?
    ) as valeur_stock_mensuelle
    FROM ventes v
    WHERE DATE_FORMAT(v.date_vente, '%Y-%m') = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $date_format,
            $annee,
            $mois,
            $date_format
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Debug détaillé amélioré
        error_log("=== Debug getSyntheseMensuelle ===");
        error_log("Mois: " . $mois);
        error_log("Date format: " . $date_format);
        error_log("Date fin mois: " . $date_fin_mois);

        // Ajout d'une requête de debug pour voir les mouvements de stock
        $debug_sql = "SELECT h.*, s.prix_unitaire, s.quantite 
                 FROM historique_stocks h
                 JOIN stocks s ON s.id = h.stock_id
                 WHERE DATE_FORMAT(h.date_mouvement, '%Y-%m') = ?
                 ORDER BY h.date_mouvement";
        $debug_stmt = $this->db->prepare($debug_sql);
        $debug_stmt->execute([$date_format]);
        $debug_stocks = $debug_stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Mouvements de stock du mois:");
        error_log(print_r($debug_stocks, true));

        error_log("Résultat requête finale:");
        error_log(print_r($result, true));


        // Calculs
        $result['cout_par_couvert'] = $result['nombre_couverts'] > 0
            ? ($result['total_achats'] - $result['valeur_stock_mensuelle']) / $result['nombre_couverts']
            : 0;

        $result['resultat'] = $result['total_ventes'] - $result['total_achats'];
        $result['resultat_total'] = $result['resultat'] + $result['valeur_stock_mensuelle'];

        return $result;
    }

    public function getSyntheseAnnuelle($annee)
    {
        $results = [];

        // Pour chaque mois de l'année
        for ($mois = 1; $mois <= 12; $mois++) {
            // Ne changeons pas getSyntheseMensuelle qui fonctionne bien
            $synthese_mensuelle = $this->getSyntheseMensuelle($mois, $annee);

            // Utilisons directement les valeurs retournées par getSyntheseMensuelle
            $results[] = [
                'n' => $mois,
                'mois' => sprintf('%02d', $mois),
                'total_ventes' => $synthese_mensuelle['total_ventes'],
                'nombre_couverts' => $synthese_mensuelle['nombre_couverts'],
                'total_achats' => $synthese_mensuelle['total_achats'],
                'valeur_stock' => $synthese_mensuelle['valeur_stock_mensuelle'],
                'cout_par_couvert' => $synthese_mensuelle['cout_par_couvert'],
                'resultat' => $synthese_mensuelle['resultat'],
                'resultat_total' => $synthese_mensuelle['resultat_total']
            ];
        }


        // Calculer la moyenne pondérée du coût par couvert
        $total_cout_pondere = 0;
        $total_couverts_non_nuls = 0;

        foreach ($results as $mois) {
            if ($mois['nombre_couverts'] > 0) {
                $total_cout_pondere += $mois['cout_par_couvert'] * $mois['nombre_couverts'];
                $total_couverts_non_nuls += $mois['nombre_couverts'];
            }
        }
        // Calculer le total annuel
        $valeurs_stock = array_filter(array_column($results, 'valeur_stock'));
        $total_annuel = [
            'mois' => 'Total',
            'total_ventes' => array_sum(array_column($results, 'total_ventes')),
            'total_achats' => array_sum(array_column($results, 'total_achats')),
            'valeur_stock' => !empty($valeurs_stock) ? end($valeurs_stock) : 0,
            'nombre_couverts' => array_sum(array_column($results, 'nombre_couverts'))
        ];
        // Utiliser la moyenne pondérée pour le coût par couvert
        $total_annuel['cout_par_couvert'] = $total_couverts_non_nuls > 0
            ? $total_cout_pondere / $total_couverts_non_nuls
            : 0;

        $total_annuel['resultat'] = $total_annuel['total_ventes'] - $total_annuel['total_achats'];
        $total_annuel['resultat_total'] = $total_annuel['resultat'] + $total_annuel['valeur_stock'];


        $results[] = $total_annuel;

        return $results;
    }

}
