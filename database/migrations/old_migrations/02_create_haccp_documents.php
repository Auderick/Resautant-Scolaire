<?php

require_once __DIR__ . '/../../config/db.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS haccp_documents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(50) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        upload_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        uploaded_by INT,
        FOREIGN KEY (uploaded_by) REFERENCES utilisateurs(id)
    )";
    $db->exec($sql);
    echo "Table haccp_documents créée avec succès.\n";
} catch (PDOException $e) {
    echo "Erreur lors de la création de la table: " . $e->getMessage() . "\n";
}
