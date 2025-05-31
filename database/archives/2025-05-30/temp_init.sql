-- Structure de la table utilisateurs
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Insertion de l'utilisateur admin par défaut
-- Mot de passe: admin123
INSERT INTO `utilisateurs` (`username`, `password`, `nom`, `prenom`, `role`, `created_at`) 
VALUES ('admin', '$2y$10$LdXE/pRyEZfKwaa3Qi/gzutck6qqg9DTlyyp04reIOqj9zD2BD09W', 'Admin', 'Admin', 'admin', CURRENT_TIMESTAMP);
