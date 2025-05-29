<?php

require_once __DIR__ . '/synthese.php';
require_once __DIR__ . '/../Utils/Logger.php';

class Stock
{
    private $db;
    private $lastQuery;

    public function __construct()
    {
        require_once __DIR__ . '/../../config/database.php';
        $config = require __DIR__ . '/../../config/database.php';

        try {
            $this->db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8;port={$config['port']}",
                $config['user'],
                $config['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }


    public function ajouter($produit, $quantite, $prix_unitaire, $unite, $seuil_alerte = 10, $date_mouvement = null)
    {
        error_log("Tentative d'ajout de stock - Produit: $produit, Quantité: $quantite");

        if ($date_mouvement === null) {
            $date_mouvement = date('Y-m-d H:i:s');
        }

        try {
            $this->db->beginTransaction();

            // On s'assure que la connection utilise utf8mb4
            $this->db->exec("SET NAMES utf8mb4");

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
            error_log("SQL préparé : " . $sql);
            error_log("Paramètres : " . print_r([
                $produit,
                $quantite,
                $prix_unitaire,
                $unite,
                $date_mouvement,
                $seuil_alerte,
                $date_mouvement,
                $date_mouvement
            ], true));

            $success = $stmt->execute([
                $produit,
                $quantite,
                $prix_unitaire,
                $unite,
                $date_mouvement,
                $seuil_alerte,
                $date_mouvement,
                $date_mouvement
            ]);

            if (!$success) {
                error_log("Erreur d'exécution SQL : " . print_r($stmt->errorInfo(), true));
                throw new Exception("Échec de l'insertion dans la table stocks");
            }

            $id = $this->db->lastInsertId();
            if (!$id) {
                error_log("Erreur: Impossible d'obtenir l'ID de la nouvelle entrée");
                throw new Exception("Impossible d'obtenir l'ID de la nouvelle entrée");
            }

            error_log("Stock inséré avec succès, ID: " . $id);            // Ajout dans l'historique avec la date du mouvement
            $sql = "INSERT INTO historique_stocks (
                stock_id, 
                date_mouvement, 
                quantite_avant, 
                quantite_apres, 
                type_mouvement,
                created_at,
                mois_operation
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $mois_operation = date('Y-m-01', strtotime($date_mouvement)); // Premier jour du mois
            $stmt = $this->db->prepare($sql);
            $success = $stmt->execute([
                $id,
                $date_mouvement,
                0,
                $quantite,
                'entrée',
                $date_mouvement,
                $mois_operation
            ]);

            if (!$success) {
                error_log("Erreur d'insertion dans l'historique : " . print_r($stmt->errorInfo(), true));
                throw new Exception("Échec de l'insertion dans l'historique");
            }

            // Mise à jour de la valeur du stock mensuel
            $mois = date('m', strtotime($date_mouvement));
            $annee = date('Y', strtotime($date_mouvement));

            $synthese = new Synthese($this->db);
            $synthese->updateValeurStockMensuel($mois, $annee);

            $this->db->commit();
            error_log("Transaction validée avec succès");
            return true;

        } catch (Exception $e) {
            error_log("Erreur lors de l'ajout de stock: " . $e->getMessage());
            $this->db->rollBack();
            throw $e;
        }
    }

    public function modifier($id, $produit, $quantite, $prix_unitaire, $unite, $seuil_alerte, $date_mouvement = null)
    {
        error_log("Tentative de modification de stock - ID: $id, Produit: $produit, Quantité: $quantite");

        if ($date_mouvement === null) {
            $date_mouvement = date('Y-m-d H:i:s');
        }

        try {
            $this->db->beginTransaction();

            // S'assurer que la connexion utilise utf8mb4
            $this->db->exec("SET NAMES utf8mb4");

            // Récupérer l'état actuel du stock
            $stock = $this->getById($id);
            if (!$stock) {
                throw new Exception("Stock non trouvé");
            }

            error_log("État actuel du stock : " . print_r($stock, true));

            // Mise à jour du stock
            $sql = "UPDATE stocks 
                   SET produit = ?, 
                       quantite = ?, 
                       prix_unitaire = ?, 
                       unite = ?, 
                       seuil_alerte = ?, 
                       date_maj = ?,
                       updated_at = ?
                   WHERE id = ?";

            $stmt = $this->db->prepare($sql);
            error_log("SQL préparé : " . $sql);

            $success = $stmt->execute([
                $produit,
                $quantite,
                $prix_unitaire,
                $unite,
                $seuil_alerte,
                $date_mouvement,
                $date_mouvement,
                $id
            ]);

            if (!$success) {
                error_log("Erreur d'exécution SQL : " . print_r($stmt->errorInfo(), true));
                throw new Exception("Échec de la mise à jour dans la table stocks");
            }

            // Ajouter dans l'historique
            $sql = "INSERT INTO historique_stocks (
                stock_id, 
                date_mouvement, 
                quantite_avant, 
                quantite_apres, 
                type_mouvement,
                created_at,
                mois_operation
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $mois_operation = date('Y-m-01', strtotime($date_mouvement)); // Premier jour du mois
            $stmt = $this->db->prepare($sql);
            $success = $stmt->execute([
                $id,
                $date_mouvement,
                $stock['quantite'],
                $quantite,
                $quantite >= $stock['quantite'] ? 'entrée' : 'sortie',
                $date_mouvement,
                $mois_operation
            ]);

            if (!$success) {
                error_log("Erreur d'insertion dans l'historique : " . print_r($stmt->errorInfo(), true));
                throw new Exception("Échec de l'insertion dans l'historique");
            }

            // Mise à jour de la valeur du stock mensuel
            $mois = date('m', strtotime($date_mouvement));
            $annee = date('Y', strtotime($date_mouvement));

            $synthese = new Synthese($this->db);
            $synthese->updateValeurStockMensuel($mois, $annee);

            $this->db->commit();
            error_log("Modification du stock validée avec succès");
            return true;

        } catch (Exception $e) {
            error_log("Erreur lors de la modification du stock: " . $e->getMessage());
            $this->db->rollBack();
            throw $e;
        }
    }

    public function supprimer($id)
    {
        error_log("Tentative de suppression du stock - ID: $id");

        try {
            $this->db->beginTransaction();

            // Récupérer le stock avant suppression pour le logging
            $stock = $this->getById($id);
            if (!$stock) {
                throw new Exception("Stock non trouvé");
            }
            error_log("Stock à supprimer : " . print_r($stock, true));

            // Supprimer d'abord les mouvements dans historique_stocks (la contrainte ON DELETE CASCADE s'en chargera)
            $sql = "DELETE FROM historique_stocks WHERE stock_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            error_log("Historique des mouvements supprimé");

            // Supprimer le stock
            $sql = "DELETE FROM stocks WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $success = $stmt->execute([$id]);

            if (!$success) {
                error_log("Erreur lors de la suppression : " . print_r($stmt->errorInfo(), true));
                throw new Exception("Échec de la suppression du stock");
            }

            error_log("Stock supprimé avec succès");

            // Mettre à jour les valeurs de stock pour le mois en cours
            $mois = date('m');
            $annee = date('Y');

            $synthese = new Synthese($this->db);
            $synthese->updateValeurStockMensuel($mois, $annee);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            error_log("Erreur lors de la suppression du stock: " . $e->getMessage());
            $this->db->rollBack();
            throw $e;
        }
    }    public function getListe($mois = null, $annee = null)
    {
        try {
            $sql = "SELECT s.*, s.quantite, s.produit, s.prix_unitaire, 
                        (s.quantite * s.prix_unitaire) as valeur_stock,
                        CASE 
                            WHEN s.quantite <= s.seuil_alerte THEN 'alert'
                            WHEN s.quantite <= (s.seuil_alerte * 2) THEN 'warning'
                            ELSE 'ok'
                        END as stock_status
                    FROM stocks s
                    WHERE 1=1";
            $params = array();            if ($mois !== null && $annee !== null) {
                $date_format = sprintf('%04d-%02d', $annee, $mois);
                $sql .= " AND DATE_FORMAT(s.date_maj, '%Y-%m') = :date_format";
                $params[':date_format'] = $date_format;
            }

            $sql .= " ORDER BY s.produit ASC";

            $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la liste des mouvements: " . $e->getMessage());
            return false;
        }
    }

    public function getById($id)
    {
        try {
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
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération du stock par ID: " . $e->getMessage());
            throw $e;
        }
    }

    public function enregistrerMouvement($quantite, $type_mouvement, $commentaire = '')
    {
        try {
            $date_mouvement = date('Y-m-d H:i:s');
            $mois_operation = date('Y-m-01'); // Premier jour du mois courant
            $sql = "INSERT INTO historique_stocks (stock_id, quantite, type_mouvement, date_mouvement, mois_operation, commentaire) 
                    VALUES (:stock_id, :quantite, :type_mouvement, :date_mouvement, :mois_operation, :commentaire)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':stock_id', $this->id, PDO::PARAM_INT);
            $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);
            $stmt->bindParam(':type_mouvement', $type_mouvement, PDO::PARAM_STR);
            $stmt->bindParam(':date_mouvement', $date_mouvement, PDO::PARAM_STR);
            $stmt->bindParam(':mois_operation', $mois_operation, PDO::PARAM_STR);
            $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur d'enregistrement du mouvement de stock: " . $e->getMessage());
            return false;
        }
    }
}
