-- Création de la table des catégories
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion des catégories par défaut
INSERT INTO categories (nom, description) VALUES
    ('CM2', 'Classe de CM2'),
    ('CE2-CM1', 'Classe de CE2 et CM1'),
    ('Personnel', 'Personnel de l''établissement');

-- Création de la table des personnes
CREATE TABLE personnes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    categorie_id INT NOT NULL,
    actif BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
);

-- Création de la table des présences
CREATE TABLE presences (
    id INT PRIMARY KEY AUTO_INCREMENT,
    personne_id INT NOT NULL,
    date_presence DATE NOT NULL,
    present BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (personne_id) REFERENCES personnes(id),
    UNIQUE KEY unique_presence (personne_id, date_presence)
);
