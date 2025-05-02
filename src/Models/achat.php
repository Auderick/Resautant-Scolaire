<?php

class Achat
{
    private $db;

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

    public function ajouter($fournisseur, $description, $montant, $dateAchat = null)
    {
        $dateAchat = $dateAchat ?: date('Y-m-d H:i:s');
        $sql = "INSERT INTO achats (fournisseur, description, montant, date_achat) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$fournisseur, $description, $montant, $dateAchat]);
    }

    public function getListe($mois = null, $annee = null)
    {
        if ($mois === null) {
            $mois = date('m');
        }
        if ($annee === null) {
            $annee = date('Y');
        }

        $sql = "SELECT * FROM achats WHERE MONTH(date_achat) = ? AND YEAR(date_achat) = ? ORDER BY date_achat DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$mois, $annee]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function modifier($id, $fournisseur, $description, $montant, $dateAchat = null)
    {
        if ($dateAchat) {
            $sql = "UPDATE achats SET fournisseur = ?, description = ?, montant = ?, date_achat = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$fournisseur, $description, $montant, $dateAchat, $id]);
        } else {
            $sql = "UPDATE achats SET fournisseur = ?, description = ?, montant = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$fournisseur, $description, $montant, $id]);
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
