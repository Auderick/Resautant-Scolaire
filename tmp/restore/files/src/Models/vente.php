<?php

class Vente
{
    private $db;

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


    public function ajouter($nbRepas, $prixUnitaire, $dateVente = null)
    {
        $dateVente = $dateVente ?: date('Y-m-d H:i:s');
        $sql = "INSERT INTO ventes (nb_repas, prix_unitaire, date_vente) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nbRepas, $prixUnitaire, $dateVente]);
    }

    public function getListe($mois = null, $annee = null) {
    if ($mois === null) {
        $mois = date('m');
    }
    if ($annee === null) {
        $annee = date('Y');
    }
    
    $sql = "SELECT * FROM ventes WHERE MONTH(date_vente) = ? AND YEAR(date_vente) = ? ORDER BY date_vente DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$mois, $annee]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function getById($id) {
        $sql = "SELECT * FROM ventes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function modifier($id, $nbRepas, $prixUnitaire, $dateVente = null)
    {
        if ($dateVente) {
            $sql = "UPDATE ventes SET nb_repas = ?, prix_unitaire = ?, date_vente = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nbRepas, $prixUnitaire, $dateVente, $id]);
        } else {
            $sql = "UPDATE ventes SET nb_repas = ?, prix_unitaire = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nbRepas, $prixUnitaire, $id]);
        }
    }

    public function supprimer($id) {
        $sql = "DELETE FROM ventes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
