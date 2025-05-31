<?php

class Achat
{
    private $db;    public function __construct()
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

    // Méthode ajouter modifiée pour inclure les nouveaux champs
    public function ajouter($fournisseur, $description, $quantite, $unite, $prix_unitaire, $montant_total, $dateAchat = null, $commande_id = null)
    {
        $dateAchat = $dateAchat ?: date('Y-m-d H:i:s');
        $sql = "INSERT INTO achats (fournisseur, description, quantite, unite, prix_unitaire, montant_total, date_achat, commande_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$fournisseur, $description, $quantite, $unite, $prix_unitaire, $montant_total, $dateAchat, $commande_id]);
    }


    // Méthode pour récupérer tous les achats d'une commande
    public function getListe($mois = null, $annee = null, $commande_id = null)
    {
        if ($mois === null) {
            $mois = date('m');
        }
        if ($annee === null) {
            $annee = date('Y');
        }

        // Construction de la requête SQL de base
        $sql = "SELECT a.*, c.fournisseur as commande_fournisseur 
            FROM achats a 
            LEFT JOIN commandes c ON a.commande_id = c.id 
            WHERE MONTH(a.date_achat) = ? AND YEAR(a.date_achat) = ?";

        $params = [$mois, $annee];

        // Ajout du filtre par commande si spécifié
        if ($commande_id !== null) {
            $sql .= " AND a.commande_id = ?";
            $params[] = $commande_id;
        }

        // Tri par commande puis par date
        $sql .= " ORDER BY a.commande_id IS NULL, a.commande_id, a.date_achat DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode modifier modifiée pour inclure les nouveaux champs
    public function modifier($id, $fournisseur, $description, $quantite, $unite, $prix_unitaire, $montant_total, $dateAchat = null)
    {
        if ($dateAchat) {
            $sql = "UPDATE achats SET 
                    fournisseur = ?, 
                    description = ?, 
                    quantite = ?, 
                    unite = ?, 
                    prix_unitaire = ?, 
                    montant_total = ?, 
                    date_achat = ? 
                    WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$fournisseur, $description, $quantite, $unite, $prix_unitaire, $montant_total, $dateAchat, $id]);
        } else {
            $sql = "UPDATE achats SET 
                    fournisseur = ?, 
                    description = ?, 
                    quantite = ?, 
                    unite = ?, 
                    prix_unitaire = ?, 
                    montant_total = ? 
                    WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$fournisseur, $description, $quantite, $unite, $prix_unitaire, $montant_total, $id]);
        }
    }

    public function supprimer($id)
    {
        $sql = "DELETE FROM achats WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM achats WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
