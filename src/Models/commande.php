<?php

class Commande
{
    public $db;

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

    public function ajouterLigneCommande($commandeId, $produit, $quantite, $unite = null, $prixUnitaire = null)
    {
        $sql = "INSERT INTO lignes_commande (commande_id, produit, quantite, unite, prix_unitaire) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$commandeId, $produit, $quantite, $unite, $prixUnitaire]);
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

    public function updateStatut($id, $statut)
    {
        $sql = "UPDATE commandes SET statut = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$statut, $id]);
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

    public function modifierLigneCommande($id, $produit, $quantite, $unite, $prixUnitaire)
    {
        $sql = "UPDATE lignes_commande SET produit = ?, quantite = ?, unite = ?, prix_unitaire = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$produit, $quantite, $unite, $prixUnitaire, $id]);
    }

    public function getFournisseurs()
    {
        // Récupérer la liste des fournisseurs uniques depuis les achats précédents
        $sql = "SELECT DISTINCT fournisseur FROM achats ORDER BY fournisseur ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
