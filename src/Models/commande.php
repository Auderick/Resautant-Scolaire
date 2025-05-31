<?php

class Commande
{
    public $db;    public function __construct()
    {        
        try {
            require_once __DIR__ . '/../../config/db.php';
            $this->db = getPDO();
            
            if (!$this->db) {
                throw new \RuntimeException("La connexion à la base de données n'a pas été initialisée");
            }
            
            // Vérifier la connexion
            $this->db->query("SELECT 1");
        } catch (PDOException $e) {
            error_log("Erreur de connexion à la base de données : " . $e->getMessage());
            throw new PDOException("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function creerCommande($fournisseur, $dateLivraisonSouhaitee = null, $notes = null)
    {
        $this->db->beginTransaction();

        try {
            $sql = "INSERT INTO commandes (fournisseur, date_livraison_souhaitee, notes) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$fournisseur, $dateLivraisonSouhaitee, $notes]);

            $commandeId = $this->db->lastInsertId();
            $this->db->commit();
            return $commandeId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function ajouterLigneCommande($commandeId, $produit, $quantite, $unite = null, $prixUnitaire = null, $isTTC = true, $tauxTVA = 20)
    {
        // Calcul des prix HT et TTC
        if ($prixUnitaire !== null) {
            if ($isTTC) {
                $prixTTC = $prixUnitaire;
                $prixHT = $prixUnitaire / (1 + ($tauxTVA / 100));
            } else {
                $prixHT = $prixUnitaire;
                $prixTTC = $prixUnitaire * (1 + ($tauxTVA / 100));
            }
        } else {
            $prixHT = null;
            $prixTTC = null;
        }

        $sql = "INSERT INTO lignes_commande (commande_id, produit, quantite, unite, prix_unitaire, prix_ht, prix_ttc, taux_tva, is_ttc) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $commandeId,
            $produit,
            $quantite,
            $unite,
            $prixUnitaire,
            $prixHT,
            $prixTTC,
            $tauxTVA,
            $isTTC ? 1 : 0
        ]);
    }

    public function getCommande($id)
    {
        $sql = "SELECT * FROM commandes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLignesCommande($commandeId)
    {
        $sql = "SELECT * FROM lignes_commande WHERE commande_id = ? ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$commandeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListeCommandes($mois = null, $annee = null)
    {
        if ($mois === null) {
            $mois = date('m');
        }
        if ($annee === null) {
            $annee = date('Y');
        }

        $sql = "SELECT * FROM commandes WHERE MONTH(date_commande) = ? AND YEAR(date_commande) = ? 
                ORDER BY date_commande DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$mois, $annee]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Met à jour le statut d'une commande
 * @param int $id ID de la commande
 * @param string $statut Nouveau statut
 * @param string|null $dateReception Date de réception (si statut = reçue)
 * @return bool Succès de l'opération
 */
    public function updateStatut($id, $statut, $dateReception = null)
    {
        try {
            // Récupérer l'ancien statut pour comparaison
            $ancienStatut = $this->getStatutCommande($id);

            // Préparer la mise à jour
            $query = "UPDATE commandes SET statut = ?";
            $params = [$statut];

            // Si le statut est "reçue", ajouter la date de réception
            if ($statut === 'reçue' || $statut === 'recue') {
                $query .= ", date_reception = ?";
                $params[] = $dateReception ?: date('Y-m-d');
            }

            $query .= " WHERE id = ?";
            $params[] = $id;

            // Exécuter la mise à jour
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            error_log("Tentative de mise à jour du statut - ID: $id, Nouveau: $statut, Ancien: $ancienStatut");
            if ($result && ($statut === 'reçue' || $statut === 'recue') &&
                ($ancienStatut !== 'reçue' && $ancienStatut !== 'recue')) {
                error_log("Conversion de la commande $id en achats");
                $achatsConvertis = $this->convertirEnAchats($id);
                error_log("Résultat de la conversion: " . ($achatsConvertis ? count($achatsConvertis) . " achats créés" : "échec"));
            }

            return $result;
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour du statut: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère le statut actuel d'une commande
     * @param int $id ID de la commande
     * @return string|null Le statut ou null si la commande n'existe pas
     */
    private function getStatutCommande($id)
    {
        $query = "SELECT statut FROM commandes WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['statut'] : null;
    }

    public function supprimerCommande($id)
    {
        $this->db->beginTransaction();

        try {
            // Les lignes de commande seront supprimées automatiquement grâce à ON DELETE CASCADE
            $sql = "DELETE FROM commandes WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$id]);

            $this->db->commit();
            return $result;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function supprimerLigneCommande($id)
    {
        $sql = "DELETE FROM lignes_commande WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function modifierLigneCommande($id, $produit, $quantite, $unite, $prixUnitaire, $isTTC = true, $tauxTVA = 20)
    {
        // Calcul des prix HT et TTC
        if ($prixUnitaire !== null) {
            if ($isTTC) {
                $prixTTC = $prixUnitaire;
                $prixHT = $prixUnitaire / (1 + ($tauxTVA / 100));
            } else {
                $prixHT = $prixUnitaire;
                $prixTTC = $prixUnitaire * (1 + ($tauxTVA / 100));
            }
        } else {
            $prixHT = null;
            $prixTTC = null;
        }

        $sql = "UPDATE lignes_commande 
                SET produit = ?, quantite = ?, unite = ?, prix_unitaire = ?, prix_ht = ?, prix_ttc = ?, taux_tva = ?, is_ttc = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $produit,
            $quantite,
            $unite,
            $prixUnitaire,
            $prixHT,
            $prixTTC,
            $tauxTVA,
            $isTTC ? 1 : 0,
            $id
        ]);
    }

    public function getFournisseurs()
    {
        // Récupérer la liste des fournisseurs uniques depuis les achats précédents
        $sql = "SELECT DISTINCT fournisseur FROM achats ORDER BY fournisseur ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
 * Convertit une commande reçue en achats
 * @param int $commandeId ID de la commande à convertir
 * @return bool|array Retourne false en cas d'échec ou un tableau avec les IDs des achats créés
 */
    public function convertirEnAchats($commandeId)
    {
        try {
            // Récupérer les informations de la commande
            $commande = $this->getCommande($commandeId);

            if (!$commande || !($commande['statut'] === 'reçue' || $commande['statut'] === 'recue')) {
                error_log("Conversion impossible: commande $commandeId inexistante ou statut incorrect");
                return false; // La commande n'existe pas ou n'est pas reçue
            }

            // Récupérer les lignes de la commande
            $lignes = $this->getLignesCommande($commandeId);
            if (empty($lignes)) {
                error_log("Conversion impossible: aucune ligne pour la commande $commandeId");
                return false; // Aucune ligne à convertir
            }

            // Ajoutez ces deux lignes de logs ici
            error_log("Données de commande pour conversion: " . json_encode($commande));
            error_log("Lignes de commande pour conversion: " . json_encode($lignes));

            // Date de l'achat = date de réception de la commande
            $dateAchat = date('Y-m-d'); // Aujourd'hui par défaut

            // Si la commande a une date de réception, l'utiliser
            if (!empty($commande['date_reception'])) {
                $dateAchat = $commande['date_reception'];
            }

            // Préparer la requête d'insertion des achats
            $query = "INSERT INTO achats (description, quantite, unite, prix_unitaire, montant_total, date_achat, fournisseur, commande_id) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);

            $achatsIds = [];

            // Convertir chaque ligne en achat
            foreach ($lignes as $ligne) {
                // Utiliser le prix TTC pour l'insertion dans les achats
                $prixUnitaire = $ligne['prix_ttc'] ?? $ligne['prix_unitaire'];
                $montantTotal = $ligne['quantite'] * $prixUnitaire;

                $stmt->execute([
                    $ligne['produit'],
                    $ligne['quantite'],
                    $ligne['unite'],
                    $prixUnitaire,
                    $montantTotal,
                    $dateAchat,
                    $commande['fournisseur'],
                    $commandeId
                ]);

                $achatsIds[] = $this->db->lastInsertId();
            }

            // Marquer la commande comme convertie en achats
            $this->marquerCommandeConvertie($commandeId);

            return $achatsIds;
        } catch (Exception $e) {
            error_log("Erreur lors de la conversion de la commande en achats: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Marque une commande comme convertie en achats
     * @param int $commandeId ID de la commande
     * @return bool Succès de l'opération
     */
    private function marquerCommandeConvertie($commandeId)
    {
        $query = "UPDATE commandes SET convertie_en_achats = 1 WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$commandeId]);
    }
}
