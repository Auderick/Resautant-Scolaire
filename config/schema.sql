CREATE DATABASE IF NOT EXISTS compte_restaurant_scolaire;
USE compte_restaurant_scolaire;

CREATE TABLE ventes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nb_repas INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    date_vente DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);