<?php

class Utilisateur
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT id, username, nom, prenom, role, created_at FROM utilisateurs ORDER BY username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT id, username, nom, prenom, role FROM utilisateurs WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouter($username, $password, $nom, $prenom, $role = 'user')
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateurs (username, password, nom, prenom, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $password_hash, $nom, $prenom, $role]);
    }

    public function modifier($id, $nom, $prenom, $role)
    {
        $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, role = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nom, $prenom, $role, $id]);
    }

    public function changerMotDePasse($id, $password)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE utilisateurs SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$password_hash, $id]);
    }

    public function supprimer($id)
    {
        // Vérifier qu'on ne supprime pas le dernier admin
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE role = 'admin' AND id != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            return false; // Empêcher la suppression du dernier admin
        }

        $sql = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function usernameExiste($username, $id = null)
    {
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE username = ?";
        $params = [$username];

        if ($id !== null) {
            $sql .= " AND id != ?";
            $params[] = $id;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
