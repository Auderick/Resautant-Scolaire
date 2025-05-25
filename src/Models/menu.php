<?php

class Menu
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

    // Récupérer toutes les semaines de menu
    public function getSemaines()
    {
        $query = "SELECT * FROM menus_semaines ORDER BY annee DESC, numero_semaine DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Récupérer une semaine spécifique
    public function getSemaine($id)
    {
        $query = "SELECT * FROM menus_semaines WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Récupérer la semaine active ou la plus récente
    public function getSemaineActive()
    {
        $query = "SELECT * FROM menus_semaines WHERE active = 1 ORDER BY annee DESC, numero_semaine DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $semaine = $stmt->fetch();

        // Si aucune semaine active, prendre la plus récente
        if (!$semaine) {
            $query = "SELECT * FROM menus_semaines ORDER BY annee DESC, numero_semaine DESC LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $semaine = $stmt->fetch();
        }

        return $semaine;
    }    // Créer ou mettre à jour une semaine
    public function saveSemaine($data)
    {
        try {
            $this->db->beginTransaction();

            if (!empty($data['id'])) {
                // Mise à jour
                $query = "UPDATE menus_semaines SET numero_semaine = ?, annee = ?, date_debut = ?, date_fin = ?, active = ? WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $result = $stmt->execute([
                    $data['numero_semaine'],
                    $data['annee'],
                    $data['date_debut'],
                    $data['date_fin'],
                    isset($data['active']) ? 1 : 0,
                    $data['id']
                ]);

                if (!$result) {
                    throw new Exception("Échec de la mise à jour de la semaine");
                }

                $semaine_id = $data['id'];
            } else {
                // Création
                $query = "INSERT INTO menus_semaines (numero_semaine, annee, date_debut, date_fin, active) 
                         VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $result = $stmt->execute([
                    $data['numero_semaine'],
                    $data['annee'],
                    $data['date_debut'],
                    $data['date_fin'],
                    isset($data['active']) ? 1 : 0
                ]);

                if (!$result) {
                    throw new Exception("Échec de la création de la semaine");
                }

                $semaine_id = $this->db->lastInsertId();
            }

            // Sauvegarder les jours si présents
            if (!empty($data['jours'])) {
                foreach ($data['jours'] as $jour) {
                    $this->saveJour($semaine_id, $jour);
                }
            }

            $this->db->commit();
            return $semaine_id;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Si une semaine est marquée comme active, désactiver les autres
    public function setActive($id)
    {
        $this->db->beginTransaction();
        try {
            // Désactiver toutes les semaines
            $stmt = $this->db->prepare("UPDATE menus_semaines SET active = 0");
            $stmt->execute();

            // Activer la semaine spécifiée
            $stmt = $this->db->prepare("UPDATE menus_semaines SET active = 1 WHERE id = ?");
            $stmt->execute([$id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Supprimer une semaine
    public function deleteSemaine($id)
    {
        $query = "DELETE FROM menus_semaines WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    // Récupérer les menus d'une semaine
    public function getMenusSemaine($semaineId)
    {
        $sql = "SELECT * FROM menus_jours WHERE semaine_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$semaineId]);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debug pour suivre les données brutes
        error_log("getMenusSemaine - Données brutes récupérées : " . print_r($resultats, true));

        foreach ($resultats as &$menu) {
            if (!empty($menu['options'])) {
                $optionsData = json_decode($menu['options'], true);

                // Debug de la structure JSON décodée
                error_log("getMenusSemaine - Options JSON décodées : " . print_r($optionsData, true));

                // Initialiser les structures pour options et allergènes
                $menu['options'] = [];
                $menu['allergenes'] = [];

                // Éléments du menu
                $elements = ['entree', 'plat', 'accompagnement', 'laitage', 'dessert'];

                // Pour chaque élément, récupérer séparément les options et les allergènes
                foreach ($elements as $element) {
                    if (isset($optionsData[$element])) {
                        // Récupérer les options
                        $menu['options'][$element] = $optionsData[$element]['options'] ?? [];

                        // Récupérer les allergènes séparément
                        if (isset($optionsData[$element]['allergenes'])) {
                            $menu['allergenes'][$element] = $optionsData[$element]['allergenes'];
                        } else {
                            $menu['allergenes'][$element] = []; // Initialiser comme tableau vide
                        }
                    } else {
                        // Initialiser avec des valeurs par défaut
                        $menu['options'][$element] = [];
                        $menu['allergenes'][$element] = [];
                    }

                    // Debug des données extraites par élément
                    error_log("getMenusSemaine - Données pour $element : options=" .
                        print_r($menu['options'][$element], true) . ", allergènes=" .
                        print_r($menu['allergenes'][$element], true));
                }
            } else {
                // Initialiser avec des structures vides
                $menu['options'] = [
                    'entree' => [],
                    'plat' => [],
                    'accompagnement' => [],
                    'laitage' => [],
                    'dessert' => []
                ];
                $menu['allergenes'] = [
                    'entree' => [],
                    'plat' => [],
                    'accompagnement' => [],
                    'laitage' => [],
                    'dessert' => []
                ];
            }
        }

        return $resultats;
    }

    // Récupérer un menu spécifique
    public function getMenu($id)
    {
        $query = "SELECT * FROM menus_jours WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Créer ou mettre à jour un menu
    public function saveMenu($data)
    {
        // Debug pour voir les données reçues
        error_log("saveMenu - données reçues: " . print_r($data, true));

        // Structure unique pour stocker à la fois les options et les allergènes
        $combinedData = [];

        // Éléments du menu
        $elements = ['entree', 'plat', 'accompagnement', 'laitage', 'dessert'];

        // Traiter les options et allergènes pour chaque élément
        foreach ($elements as $element) {
            // Récupérer les options
            $options = isset($data['options'][$element]) ? $data['options'][$element] : [];

            // Récupérer les allergènes seulement s'ils sont activés pour cet élément
            $allergenes = [];
            if (isset($options) && in_array('allergenes', $options) && isset($data['allergenes'][$element])) {
                $allergenes = $data['allergenes'][$element];
            }

            // Stocker séparément dans la structure
            $combinedData[$element] = [
                'options' => $options,
                'allergenes' => $allergenes
            ];
        }

        // Debug pour voir la structure finale
        error_log("saveMenu - structure combinée: " . print_r($combinedData, true));

        // Conversion en JSON pour stockage
        $optionsJson = json_encode($combinedData);

        // Préparation de la requête SQL
        if (empty($data['id'])) {
            // Insertion
            $sql = "INSERT INTO menus_jours (semaine_id, jour, entree, plat, accompagnement, laitage, dessert, options) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['semaine_id'],
                $data['jour'],
                $data['entree'],
                $data['plat'],
                $data['accompagnement'],
                $data['laitage'],
                $data['dessert'],
                $optionsJson
            ]);
            return $this->db->lastInsertId();
        } else {
            // Mise à jour
            $sql = "UPDATE menus_jours SET 
                semaine_id = ?, jour = ?, entree = ?, plat = ?, accompagnement = ?, laitage = ?, dessert = ?, options = ? 
                WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['semaine_id'],
                $data['jour'],
                $data['entree'],
                $data['plat'],
                $data['accompagnement'],
                $data['laitage'],
                $data['dessert'],
                $optionsJson,
                $data['id']
            ]);
            return $data['id'];
        }
    }
}
