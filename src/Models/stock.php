<?php

require_once __DIR__ . '/synthese.php';
require_once __DIR__ . '/../Utils/Logger.php';

class Stock
{
    private $db;
    private $lastQuery;

    public function __construct()
    {
        $config = require_once __DIR__ . '/../../config/database.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']}",
                $config['user'],
                $config['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function ajouter($produit, $quantite, $prix_unitaire, $unite, $seuil_alerte = 10, $date_mouvement = null)
    {
        if ($date_mouvement === null) {
            $date_mouvement = date('Y-m-d H:i:s');
        }

        try {
            $this->db->beginTransaction();

            // Formatage de la date
            if ($date_mouvement !== null) {
                $date_mouvement = date('Y-m-d H:i:s', strtotime($date_mouvement));
            } else {
                $date_mouvement = date('Y-m-d H:i:s');
            }

            // Ajout du stock avec la date du mouvement pour created_at et updated_at
            $sql = "INSERT INTO stocks (
            produit, 
            quantite, 
            prix_unitaire, 
            unite, 
            date_maj, 
            seuil_alerte,
            created_at,
            updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $produit,
                $quantite,
                $prix_unitaire,
                $unite,
                $date_mouvement,
                $seuil_alerte,
                $date_mouvement, // created_at avec la date du mouvement
                $date_mouvement  // updated_at avec la date du mouvement
            ]);

            $id = $this->db->lastInsertId();

            // Ajout dans l'historique avec la date du mouvement
            $sql = "INSERT INTO historique_stocks (
            stock_id, 
            date_mouvement, 
            quantite_avant, 
            quantite_apres, 
            type_mouvement,
            created_at
        ) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $id,
                $date_mouvement,
                0,
                $quantite,
                'entrée',
                $date_mouvement
            ]);

            // Calcul de la période pour le mouvement
            $mois = date('m', strtotime($date_mouvement));
            $annee = date('Y', strtotime($date_mouvement));

            // Mise à jour de la valeur du stock mensuel
            $synthese = new Synthese($this->db);
            $synthese->updateValeurStockMensuel($mois, $annee);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function modifier($id, $produit, $quantite, $prix_unitaire, $unite, $seuil_alerte, $date_mouvement = null)
    {
        if ($date_mouvement === null) {
            $date_mouvement = date('Y-m-d H:i:s');
        }

        $this->db->beginTransaction();
        try {
            // Calcul de la période pour le mouvement
            $mois = date('m', strtotime($date_mouvement));
            $annee = date('Y', strtotime($date_mouvement));

            // Définition du mois et année actuels
            $mois_actuel = date('m');
            $annee_actuelle = date('Y');

            // Récupération des périodes à mettre à jour
            $periodes_a_maj = [];

            // Si le mouvement n'est pas dans le mois courant
            if ($mois != $mois_actuel || $annee != $annee_actuelle) {
                // Si le mouvement est antérieur au mois courant
                if (strtotime("$annee-$mois-01") < strtotime("$annee_actuelle-$mois_actuel-01")) {
                    Logger::log('Mouvement antérieur, pas de mise à jour du mois courant');
                    // On ne met à jour que le mois du mouvement
                    $periodes_a_maj[] = ['mois' => $mois, 'annee' => $annee];
                }
            } else {
                // Si on est dans le mois courant, on met à jour ce mois
                $periodes_a_maj[] = ['mois' => $mois_actuel, 'annee' => $annee_actuelle];
                Logger::log('Mouvement dans le mois courant');
            }

            // Récupérer l'état actuel du stock
            $stock = $this->getById($id);
            if (!$stock) {
                throw new Exception("Stock non trouvé");
            }

            // Mise à jour du stock
            $sql = "UPDATE stocks 
            SET produit = ?, 
                quantite = ?, 
                prix_unitaire = ?, 
                unite = ?, 
                seuil_alerte = ?, 
                date_maj = ? 
            WHERE id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $produit,
                $quantite,
                $prix_unitaire,
                $unite,
                $seuil_alerte,
                $date_mouvement,
                $id
            ]);

            // Ajouter dans l'historique
            $sql = "INSERT INTO historique_stocks (
            stock_id, 
            date_mouvement, 
            quantite_avant, 
            quantite_apres, 
            type_mouvement
        ) VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $id,
                $date_mouvement,
                $stock['quantite'],
                $quantite,
                $quantite >= $stock['quantite'] ? 'entrée' : 'sortie'
            ]);

            // Mise à jour des synthèses pour les périodes concernées
            $synthese = new Synthese($this->db);
            foreach ($periodes_a_maj as $periode) {
                $synthese->updateValeurStockMensuel($periode['mois'], $periode['annee']);
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    public function supprimer($id)
    {
        $this->db->beginTransaction();
        try {
            // Récupérer tous les mois où ce stock a eu des mouvements
            $sql = "SELECT DISTINCT 
            YEAR(date_mouvement) as annee,
            MONTH(date_mouvement) as mois
        FROM historique_stocks 
        WHERE stock_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $periodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Supprimer d'abord les mouvements dans historique_stocks
            $sql = "DELETE FROM historique_stocks WHERE stock_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            // Supprimer le stock
            $sql = "DELETE FROM stocks WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            // Mettre à jour les valeurs de stock pour chaque mois concerné
            $synthese = new Synthese($this->db);
            foreach ($periodes as $periode) {
                $synthese->updateValeurStockMensuel($periode['mois'], $periode['annee']);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getListe($mois = null, $annee = null)
    {
        if ($mois === null) {
            $mois = date('m');
        }
        if ($annee === null) {
            $annee = date('Y');
        }

        $date_format = sprintf('%04d-%02d', $annee, $mois);

        $sql = "SELECT 
        s.*,
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
            s.quantite
        ) as quantite_actuelle
    FROM stocks s
    WHERE EXISTS (
        SELECT 1 
        FROM historique_stocks h 
        WHERE h.stock_id = s.id 
        AND DATE_FORMAT(h.date_mouvement, '%Y-%m') = ?
    )
    ORDER BY s.produit ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$date_format, $date_format, $date_format]);
        $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Logger::log('getListe - Stocks récupérés', [
            'mois' => $mois,
            'annee' => $annee,
            'nombre_stocks' => count($stocks),
            'stocks' => array_map(function ($s) {
                return [
                    'id' => $s['id'],
                    'quantite' => $s['quantite_actuelle']
                ];
            }, $stocks)
        ]);

        foreach ($stocks as &$stock) {
            $stock['valeur_stock'] = $stock['quantite_actuelle'] * $stock['prix_unitaire'];
            $stock['stock_status'] =
                $stock['quantite_actuelle'] <= $stock['seuil_alerte'] ? 'alert' :
                ($stock['quantite_actuelle'] <= $stock['seuil_alerte'] * 2 ? 'warning' : 'ok');
        }

        return $stocks;
    }

    public function ajusterStock($id, $quantite, $date_mouvement = null)
    {
        Logger::log('Début ajusterStock', [
        'id' => $id,
        'quantite' => $quantite,
        'date_mouvement' => $date_mouvement
    ]);

        try {
            $this->db->beginTransaction();

            // Formatage de la date
            if ($date_mouvement !== null) {
                $date_mouvement = date('Y-m-d H:i:s', strtotime($date_mouvement));
            } else {
                $date_mouvement = date('Y-m-d H:i:s');
            }
            Logger::log('Date formatée', ['date_mouvement' => $date_mouvement]);

            // Calcul de la période pour le mouvement
            $mois = date('m', strtotime($date_mouvement));
            $annee = date('Y', strtotime($date_mouvement));

            // Récupération des périodes à mettre à jour
            $periodes_a_maj = [];

            // Définition du mois et année actuels
            $mois_actuel = date('m');
            $annee_actuelle = date('Y');

            // Si le mouvement n'est pas dans le mois courant
            if ($mois != $mois_actuel || $annee != $annee_actuelle) {
                // Si le mouvement est antérieur au mois courant
                if (strtotime("$annee-$mois-01") < strtotime("$annee_actuelle-$mois_actuel-01")) {
                    Logger::log('Mouvement antérieur, mise à jour du mois du mouvement uniquement');
                    $periodes_a_maj[] = ['mois' => $mois, 'annee' => $annee];
                } else {
                    Logger::log('Mouvement postérieur, mise à jour du mois du mouvement');
                    $periodes_a_maj[] = ['mois' => $mois, 'annee' => $annee];
                }
            } else {
                Logger::log('Mouvement dans le mois courant');
                $periodes_a_maj[] = ['mois' => $mois, 'annee' => $annee];
            }
            // Définition de la requête SQL pour récupérer le dernier mouvement
            $sql = "SELECT quantite_apres as quantite 
                FROM historique_stocks 
                WHERE stock_id = ? 
                ORDER BY date_mouvement DESC, id DESC 
                LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $dernier_mouvement = $stmt->fetch(PDO::FETCH_ASSOC);
            Logger::log('Dernier mouvement trouvé', $dernier_mouvement);

            // Récupérer les informations du stock
            $stock = $this->getById($id);
            Logger::log('Stock récupéré', $stock);

            // Calcul des quantités
            $quantiteAvant = $dernier_mouvement ? $dernier_mouvement['quantite'] : $stock['quantite'];
            $quantiteApres = $quantiteAvant + $quantite;

            Logger::log('Calcul des quantités', [
                'quantiteAvant' => $quantiteAvant,
                'quantiteApres' => $quantiteApres,
                'difference' => $quantite
            ]);

            // Insertion dans l'historique sans mois_operation (colonne générée)
            $sql = "INSERT INTO historique_stocks (
            stock_id, 
            date_mouvement, 
            quantite_avant, 
            quantite_apres, 
            type_mouvement
        ) VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $id,
                $date_mouvement,
                $quantiteAvant,
                $quantiteApres,
                $quantite >= 0 ? 'entrée' : 'sortie'
            ]);

            // Mise à jour du stock
            $sql = "UPDATE stocks SET quantite = ?, date_maj = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$quantiteApres, $date_mouvement, $id]);

            // Mise à jour des synthèses pour les périodes concernées
            $synthese = new Synthese($this->db);
            foreach ($periodes_a_maj as $periode) {
                Logger::log('Mise à jour synthèse pour période', $periode);
                $synthese->updateValeurStockMensuel($periode['mois'], $periode['annee']);
            }

            $this->db->commit();
            Logger::log('AjusterStock terminé avec succès');
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            Logger::log('Erreur dans ajusterStock', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function getHistoriqueMouvements($mois, $annee)
    {
        $sql = "SELECT 
                s.produit,
                s.unite,
                h.date_mouvement,
                h.quantite_avant,
                h.quantite_apres,
                h.type_mouvement,
                (h.quantite_apres - h.quantite_avant) as difference
            FROM historique_stocks h
            JOIN stocks s ON h.stock_id = s.id
            WHERE MONTH(h.date_mouvement) = ? 
            AND YEAR(h.date_mouvement) = ?
            ORDER BY h.date_mouvement DESC";

        $this->logQuery($sql, [$mois, $annee]);
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$mois, $annee]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function logQuery($sql, $params = [])
    {
        $this->lastQuery = [
            'sql' => $sql,
            'params' => $params,
            'time' => date('Y-m-d H:i:s')
        ];
    }

    public function getLastQuery()
    {
        return $this->lastQuery;
    }

    public function getById($id)
    {
        $sql = "SELECT s.*, 
            h.date_mouvement
        FROM stocks s
        LEFT JOIN (
            SELECT stock_id, date_mouvement
            FROM historique_stocks
            WHERE date_mouvement = (
                SELECT MAX(date_mouvement)
                FROM historique_stocks
                WHERE stock_id = ?
            )
        ) h ON s.id = h.stock_id
        WHERE s.id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id, $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
