<?php

class Presence
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


    public function getCategories()
    {
        $query = "SELECT * FROM categories ORDER BY id";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPersonnesByCategorie($categorieId)
    {
        $query = "SELECT * FROM personnes WHERE categorie_id = ? AND actif = true ORDER BY nom, prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categorieId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    public function getPresences($date, $categorieId)
    {
        $query = "SELECT p.*, pe.nom, pe.prenom 
                 FROM presences p 
                 JOIN personnes pe ON p.personne_id = pe.id 
                 WHERE pe.categorie_id = ? AND p.date_presence = ? AND pe.actif = true
                 ORDER BY pe.nom, pe.prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categorieId, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    public function enregistrerPresences($date, $presences, $absences = [], $categorieId = null)
    {
        $this->db->beginTransaction();
        try {
            // Récupérer toutes les personnes actives de la catégorie spécifiée
            $query = "SELECT id FROM personnes WHERE actif = true";
            if ($categorieId !== null) {
                $query .= " AND categorie_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$categorieId]);
            } else {
                $stmt = $this->db->query($query);
            }
            $personnes = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($personnes as $personneId) {
                $present = isset($presences[$personneId]) ? 1 : 0;
                $absent = isset($absences[$personneId]) ? 1 : 0;

                $query = "INSERT INTO presences (personne_id, date_presence, present, absent) 
                         VALUES (?, ?, ?, ?)
                         ON DUPLICATE KEY UPDATE present = ?, absent = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$personneId, $date, $present, $absent, $present, $absent]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function ajouterPersonne($nom, $prenom, $categorieId)
    {
        $query = "INSERT INTO personnes (nom, prenom, categorie_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$nom, $prenom, $categorieId]);
    }

    public function getStatistiquesPresence($debut, $fin, $categorieId)
    {
        $query = "SELECT pe.nom, pe.prenom, COUNT(p.id) as total_presences
                 FROM personnes pe
                 LEFT JOIN presences p ON pe.id = p.personne_id 
                    AND p.date_presence BETWEEN ? AND ?
                    AND p.present = true
                 WHERE pe.categorie_id = ? AND pe.actif = true
                 GROUP BY pe.id
                 ORDER BY pe.nom, pe.prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$debut, $fin, $categorieId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPersonneById($id)
    {
        $query = "SELECT * FROM personnes WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function modifierPersonne($id, $nom, $prenom, $categorieId)
    {
        $query = "UPDATE personnes SET nom = ?, prenom = ?, categorie_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$nom, $prenom, $categorieId, $id]);
    }

    public function supprimerPersonne($id)
    {
        // On désactive la personne au lieu de la supprimer
        $query = "UPDATE personnes SET actif = false WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }    public function getRecapitulatifMensuel($mois, $annee, $categorieId)
    {
        $debut = "$annee-$mois-01";
        $fin = date('Y-m-t', strtotime($debut));

        $query = "SELECT 
                    pe.id,
                    pe.nom,
                    pe.prenom,
                    GROUP_CONCAT(
                        CASE 
                            WHEN p.present = 1 THEN DAY(p.date_presence)
                            ELSE NULL 
                        END
                        ORDER BY p.date_presence
                    ) as jours_present,
                    GROUP_CONCAT(
                        CASE 
                            WHEN p.absent = 1 THEN DAY(p.date_presence)
                            ELSE NULL 
                        END
                        ORDER BY p.date_presence
                    ) as jours_absent,
                    COUNT(CASE WHEN p.present = 1 THEN 1 END) as total_presences,
                    COUNT(CASE WHEN p.absent = 1 THEN 1 END) as total_absences
                FROM personnes pe
                LEFT JOIN presences p ON pe.id = p.personne_id 
                    AND p.date_presence BETWEEN ? AND ?
                WHERE pe.categorie_id = ? AND pe.actif = true
                GROUP BY pe.id
                ORDER BY pe.nom, pe.prenom";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$debut, $fin, $categorieId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
