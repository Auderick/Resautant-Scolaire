-- Assurez-vous que la table utilisateurs existe d'abord
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insérer l'utilisateur admin s'il n'existe pas
INSERT IGNORE INTO `utilisateurs` (`id`, `username`, `password`, `nom`, `prenom`, `role`, `created_at`) 
VALUES (1, 'admin', '$2y$10$LdXE/pRyEZfKwaa3Qi/gzutck6qqg9DTlyyp04reIOqj9zD2BD09W', 'Guthoerl', 'Christophe', 'admin', '2025-05-01 07:32:32');

-- Supprimer la table haccp_documents si elle existe
DROP TABLE IF EXISTS `haccp_documents`;

-- Créer la table haccp_documents avec la bonne référence
CREATE TABLE `haccp_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `haccp_documents_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
