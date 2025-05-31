-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 24 mai 2025 à 17:50
-- Version du serveur : 5.7.24
-- Version de PHP : 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_restaurant_scolaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `achats`
--

CREATE TABLE `achats` (
  `id` int(11) NOT NULL,
  `fournisseur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` decimal(10,2) DEFAULT NULL,
  `unite` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `date_achat` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `commande_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `achats`
--

INSERT INTO `achats` (`id`, `fournisseur`, `description`, `quantite`, `unite`, `prix_unitaire`, `montant_total`, `date_achat`, `created_at`, `updated_at`, `commande_id`) VALUES
(11, 'Leclerc', 'mini babibel *12', '2.00', 'barquette', '4.24', '8.48', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(12, 'Leclerc', 'kiri portion *24', '1.00', 'boîte', '5.14', '5.14', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(13, 'Leclerc', 'yaourts fruits *12', '2.00', 'carton', '3.40', '6.80', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(14, 'Leclerc', 'creme fluide *3', '2.00', 'unité', '2.55', '5.10', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(15, 'Leclerc', 'fromage frais *8', '2.00', 'carton', '1.79', '3.58', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(16, 'Leclerc', 'coulommier', '2.00', 'pièce', '2.11', '4.22', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(17, 'Leclerc', 'petit filou *12', '2.00', 'carton', '1.67', '3.34', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(18, 'Leclerc', 'beurre doux', '2.00', 'pièce', '1.83', '3.66', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(19, 'Leclerc', 'oeufs frais *12', '2.00', 'carton', '2.64', '5.28', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(20, 'Leclerc', 'veau', '1.00', 'pièce', '79.82', '79.82', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(21, 'Leclerc', 'eau de source', '1.00', 'carton', '1.14', '1.14', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(22, 'Leclerc', 'petit louis', '2.00', 'sachet', '2.76', '5.52', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(23, 'Leclerc', 'banane', '1.00', 'sachet', '6.54', '6.54', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(24, 'Leclerc', 'carotte', '1.00', 'sachet', '4.57', '4.57', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(25, 'Leclerc', 'poire', '1.00', 'sachet', '6.10', '6.10', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(26, 'Leclerc', 'tomate', '1.00', 'sachet', '5.50', '5.50', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(27, 'Leclerc', 'kiwi', '10.00', 'pièce', '0.59', '5.90', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(28, 'Leclerc', 'batavia', '1.00', 'pièce', '1.29', '1.29', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(29, 'Leclerc', 'céleri rave', '1.00', 'pièce', '1.99', '1.99', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(30, 'Leclerc', 'filet poulet', '3.00', 'kg', '7.29', '21.87', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(31, 'Leclerc', 'filet poulet jaune', '1.00', 'kg', '5.99', '5.99', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(32, 'Leclerc', 'pomme fruit *2kg', '1.00', 'sachet', '2.99', '2.99', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(33, 'Leclerc', 'PDT', '2.00', 'sachet', '4.78', '9.56', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(34, 'Leclerc', 'concombre', '9.00', 'pièce', '1.29', '11.61', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(35, 'Leclerc', 'sucre poudre', '1.00', 'kg', '1.39', '1.39', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(36, 'Leclerc', 'haricots verts', '4.00', 'boîte', '1.15', '4.60', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(37, 'Leclerc', 'plaquette chocolat', '3.00', 'unité', '1.82', '5.46', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(38, 'Leclerc', 'riz', '2.00', 'unité', '1.69', '3.38', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(39, 'Leclerc', 'fond de veau ', '1.00', 'boîte', '2.12', '2.12', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(40, 'Leclerc', 'vien rouge cubi', '1.00', 'carton', '9.49', '9.49', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(41, 'Leclerc', 'fumet poisson', '1.00', 'boîte', '2.01', '2.01', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(42, 'Leclerc', 'jus citron', '1.00', 'bouteille', '1.69', '1.69', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(43, 'Leclerc', 'vin blanc cubi', '1.00', 'carton', '8.99', '8.99', '2025-05-07 00:00:00', '2025-05-07 11:00:54', '2025-05-07 18:20:58', 18),
(45, 'Sirf DS', 'terrine légumes', '3.20', 'kg', '8.29', '26.53', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(46, 'Sirf DS', 'escaloppe de dinde', '4.99', 'kg', '9.81', '48.95', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(47, 'Sirf DS', 'pommes duchesse', '5.00', 'kg', '4.74', '23.70', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(48, 'Sirf DS', 'poellée 4 légumes', '5.00', 'kg', '5.04', '25.20', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(49, 'Sirf DS', 'salade de fruits saison', '3.00', 'kg', '5.91', '17.73', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(50, 'Sirf DS', 'céleri rémoulade', '2.00', 'kg', '4.38', '8.76', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(51, 'Sirf DS', 'egréné pur boeuf 15%', '3.00', 'kg', '20.50', '61.50', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(52, 'Sirf DS', 'paté de campagne suppérieur', '2.95', 'kg', '6.30', '18.59', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(53, 'Sirf DS', 'poisson blanc meuniere', '6.00', 'kg', '9.96', '59.76', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(54, 'Sirf DS', 'ail hachée', '1.00', 'unité', '4.31', '4.31', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(55, 'Sirf DS', 'persil émincé', '1.00', 'unité', '3.54', '3.54', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(56, 'Sirf DS', 'oignon émincé', '2.50', 'kg', '3.43', '8.58', '2025-05-10 00:00:00', '2025-05-10 10:05:12', '2025-05-10 10:05:12', 14),
(57, 'Leclerc', 'lait demi écrémé', '2.00', 'L', '5.61', '11.22', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(58, 'Leclerc', 'riz rond sachet 1kg éco+', '1.00', 'kg', '1.79', '1.79', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(59, 'Leclerc', 'arome vanille 200ml', '1.00', 'bouteille', '2.38', '2.38', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(60, 'Leclerc', 'sucre blanc poudre éco', '1.00', 'kg', '1.39', '1.39', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(61, 'Leclerc', 'lasagne boite carton 500gr', '3.00', 'carton', '1.39', '4.17', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(62, 'Leclerc', 'origan flacon 11gr', '1.00', 'unité', '1.62', '1.62', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(63, 'Leclerc', 'thym sélectionné flacon 14gr rustica', '1.00', 'unité', '0.40', '0.40', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(64, 'Leclerc', 'sel fin de table 750gr éco+', '1.00', 'unité', '0.54', '0.54', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(65, 'Leclerc', 'fond de veau 110gr rustica', '2.00', 'pièce', '2.12', '4.24', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(66, 'Leclerc', 'muscade moulue flacon 32gr rustica', '1.00', 'unité', '1.37', '1.37', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(67, 'Leclerc', 'yaourts aromatisésaux fruits délisse *16', '3.00', 'carton', '2.50', '7.50', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(68, 'Leclerc', 'yaourt à la grecque nature  delisse *8', '3.00', 'carton', '2.15', '6.45', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(69, 'Leclerc', 'petits suisse aux fruits', '1.00', 'pièce', '5.02', '5.02', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(70, 'Leclerc', 'mimolette 23.7% Mat gr 250gr', '2.00', 'unité', '2.97', '5.94', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(71, 'Leclerc', 'kiri *12', '4.00', 'pièce', '2.74', '10.96', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(72, 'Leclerc', 'mini babibel', '4.00', 'pièce', '4.24', '16.96', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(73, 'Leclerc', 'banane petit calibre', '1.00', 'kg', '6.28', '6.28', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(74, 'Leclerc', 'créme fluide entière 30% *3', '2.00', 'carton', '2.55', '5.10', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(75, 'Leclerc', 'moutarde de dijon 370gr', '1.00', 'pot', '0.79', '0.79', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(76, 'Leclerc', 'huile de tournesol 1l rustica', '1.00', 'L', '1.99', '1.99', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(77, 'Leclerc', 'oeuf frais *12', '2.00', 'carton', '3.49', '6.98', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(78, 'Leclerc', 'beurre de bretagne doux 500gr les croisés', '2.00', 'pièce', '4.80', '9.60', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(79, 'Leclerc', 'polenta 500gr ', '3.00', 'pièce', '1.42', '4.26', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(80, 'Leclerc', 'double concentré de tomates Turini *3', '1.00', 'barquette', '2.15', '2.15', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(81, 'Leclerc', 'purée de tomates fraiche *3', '1.00', 'carton', '1.19', '1.19', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(82, 'Leclerc', 'cornichons pasteurisés au vinaigre éco ', '3.00', 'pot', '0.90', '2.70', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(83, 'Leclerc', 'olives vertes dénoyautées éco', '1.00', 'pot', '2.55', '2.55', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(84, 'Leclerc', 'rapé 3 from', '5.00', '', '1.80', '9.00', '2025-05-12 00:00:00', '2025-05-12 08:52:48', '2025-05-12 08:52:48', 15),
(85, 'Leclerc', 'mois entier', '1.00', '1', '405.98', '405.98', '2025-02-28 11:14:00', '2025-05-12 09:15:00', '2025-05-12 09:15:00', NULL),
(86, 'boulangerie', 'pain mois', '1.00', '1', '137.60', '137.60', '2025-02-28 11:16:00', '2025-05-12 09:16:32', '2025-05-12 09:16:32', NULL),
(87, 'Sirf', 'mois entier', '1.00', '1', '370.71', '370.71', '2025-02-28 11:16:00', '2025-05-12 09:17:01', '2025-05-12 09:17:01', NULL),
(88, 'gaec la pradelle', 'mois entier', '1.00', '1', '82.53', '82.53', '2025-02-28 11:17:00', '2025-05-12 09:17:40', '2025-05-12 09:17:40', NULL),
(89, 'la molle', 'mois entier', '1.00', '1', '58.76', '58.76', '2025-02-28 11:18:00', '2025-05-12 09:18:12', '2025-05-12 09:18:12', NULL),
(90, 'Leclerc', 'mois entier', '1.00', '1', '722.32', '722.32', '2025-01-31 11:20:00', '2025-05-12 09:20:12', '2025-05-12 09:20:12', NULL),
(91, 'boulangerie', 'pain mois', '1.00', '1', '174.80', '174.80', '2025-01-31 11:20:00', '2025-05-12 09:20:37', '2025-05-12 09:20:37', NULL),
(92, 'Sirf', 'mois entier', '1.00', '1', '203.53', '203.53', '2025-01-31 11:20:00', '2025-05-12 09:21:04', '2025-05-12 09:21:04', NULL),
(93, 'Leclerc', 'mois entier', '1.00', '1', '604.72', '604.72', '2025-03-31 09:31:00', '2025-05-13 09:31:08', '2025-05-13 09:32:15', NULL),
(94, 'boulangerie', 'pain mois', '1.00', '1', '174.00', '174.00', '2025-03-31 11:32:00', '2025-05-13 09:32:50', '2025-05-13 09:32:50', NULL),
(95, 'Sirf', 'mois entier', '1.00', '1', '159.34', '159.34', '2025-03-31 11:33:00', '2025-05-13 09:33:19', '2025-05-13 09:33:19', NULL),
(96, 'gaec la pradelle', 'mois entier', '1.00', '1', '82.53', '82.53', '2025-03-31 11:33:00', '2025-05-13 09:33:50', '2025-05-13 09:33:50', NULL),
(97, 'Leclerc', 'mois entier', '1.00', '1', '351.76', '351.76', '2025-04-30 11:34:00', '2025-05-13 09:34:39', '2025-05-13 09:34:39', NULL),
(98, 'Sirf', 'Terrine forestière champignons Réf. 02507', '1.60', 'kg', '10.92', '17.47', '2025-05-16 18:00:00', '2025-05-16 07:45:35', '2025-05-16 08:05:45', 19),
(99, 'Sirf', 'Steak haché pur boeuf 100gr Réf. 02788', '6.00', 'kg', '14.24', '85.44', '2025-05-16 18:00:00', '2025-05-16 07:45:35', '2025-05-16 08:11:42', 19),
(100, 'Sirf', 'Pommes paillasson 1.5kg Réf. 00903', '4.50', 'kg', '6.82', '30.69', '2025-05-16 20:00:00', '2025-05-16 07:45:35', '2025-05-16 08:03:56', 19),
(101, 'Sirf', 'Petits pois 2.5kg Réf. 00265', '2.50', 'kg', '4.08', '10.20', '2025-05-16 22:00:00', '2025-05-16 07:45:35', '2025-05-16 08:06:36', 19),
(102, 'Sirf', 'Taboulé Réf. 01550 2kg', '2.00', 'kg', '6.01', '12.02', '2025-05-16 18:00:00', '2025-05-16 07:45:35', '2025-05-16 08:08:14', 19),
(103, 'Sirf', 'Roti de porc longe ', '3.01', 'kg', '7.81', '23.51', '2025-05-16 16:00:00', '2025-05-16 07:45:35', '2025-05-16 08:18:56', 19),
(104, 'Sirf', 'estragon 250gr', '1.00', 'sachet', '4.54', '4.54', '2025-05-16 22:00:00', '2025-05-16 07:45:35', '2025-05-16 08:08:58', 19),
(105, 'Sirf', 'Pommes sutées 2.5kg', '5.00', 'kg', '3.96', '19.80', '2025-05-16 22:00:00', '2025-05-16 07:45:35', '2025-05-16 08:09:33', 19),
(106, 'Sirf', 'Dos de colin lieu Réf. 02229', '5.00', 'kg', '11.92', '59.60', '2025-05-16 00:00:00', '2025-05-16 07:45:35', '2025-05-16 07:45:35', 19),
(107, 'Sirf', 'Haricots beurre Réf. 09867', '2.50', 'kg', '3.27', '8.18', '2025-05-16 22:00:00', '2025-05-16 07:45:35', '2025-05-16 08:10:10', 19),
(108, 'Sirf', 'Fond de tarte sucrée Réf. 12388', '1.00', 'carton', '14.97', '14.97', '2025-05-16 00:00:00', '2025-05-16 07:45:35', '2025-05-16 07:45:35', 19),
(109, 'Sirf', 'Cocktail de fruits rouges', '3.00', 'kg', '6.17', '18.51', '2025-05-16 00:00:00', '2025-05-16 07:45:35', '2025-05-16 07:45:35', 19),
(110, 'Sirf', 'Echalotes cubes 0.250kg Réf. 00825', '1.00', 'sachet', '3.09', '3.09', '2025-05-15 22:00:00', '2025-05-16 07:45:35', '2025-05-16 08:11:01', 19),
(124, 'boulangerie', 'pain mois', '1.00', '1', '170.30', '170.30', '2025-04-30 10:22:00', '2025-05-16 08:22:51', '2025-05-16 08:22:51', NULL),
(125, 'Leclerc', 'Carottes', '1.00', 'carton', '4.71', '4.71', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(126, 'Leclerc', 'lait demi écrémé ', '1.00', 'carton', '6.30', '6.30', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(127, 'Leclerc', 'oeuf frais', '1.00', 'boîte', '1.49', '1.49', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(128, 'Leclerc', 'farine eco', '1.00', 'kg', '0.63', '0.63', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(129, 'Leclerc', 'cumin', '1.00', 'pièce', '0.59', '0.59', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(130, 'Leclerc', 'poivre moulu', '1.00', 'pièce', '1.99', '1.99', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(131, 'Leclerc', 'lentilles blondes 500gr eco', '3.00', 'boîte', '1.03', '3.09', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(132, 'Leclerc', 'pommes de terre ', '1.00', 'carton', '3.79', '3.79', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(133, 'Leclerc', 'beurre doux 500gr', '1.00', 'pièce', '4.79', '4.79', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(134, 'Leclerc', 'champignons paris', '2.00', 'kg', '5.98', '11.96', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(135, 'Leclerc', 'crème fluide 30% lot de 3pièces', '2.00', 'unité', '1.84', '3.68', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(136, 'Leclerc', 'huile tournesol', '1.00', 'L', '1.99', '1.99', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(137, 'Leclerc', 'poireaux', '5.00', 'kg', '3.50', '17.50', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(138, 'Leclerc', 'vin blanc cuisine cubi 3l', '1.00', 'pièce', '8.48', '8.48', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(139, 'Leclerc', 'bleu 31% 250gr les croisés', '4.00', 'pièce', '2.21', '8.84', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(140, 'Leclerc', 'petits louis sachet', '3.00', 'sachet', '3.54', '10.62', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(141, 'Leclerc', 'saint moret portion', '3.00', 'boîte', '2.00', '6.00', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(142, 'Leclerc', 'yaourt nature', '2.00', 'boîte', '2.25', '4.50', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(143, 'Leclerc', 'fromage blanc', '5.00', 'boîte', '1.79', '8.95', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(144, 'Leclerc', 'riz indica', '2.00', 'kg', '2.48', '4.96', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(145, 'Leclerc', 'banane petit calibre', '8.00', 'kg', '0.79', '6.32', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(146, 'Leclerc', 'semoule moyenne couscous', '1.00', 'unité', '0.95', '0.95', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(147, 'Leclerc', 'tomate grappe', '1.00', 'carton', '5.44', '5.44', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(148, 'Leclerc', 'batavia', '2.00', 'pièce', '1.29', '2.58', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(149, 'Leclerc', 'yaourt Nat', '1.00', 'pièce', '0.65', '0.65', '2025-05-19 00:00:00', '2025-05-19 07:54:56', '2025-05-19 07:54:56', 20),
(150, 'Sirf', 'haricot vert extra fin Réf. 71600', '2.50', 'kg', '3.78', '9.45', '2025-05-23 00:00:00', '2025-05-23 09:19:42', '2025-05-23 09:19:42', 21),
(151, 'Sirf', 'saucisse toulouse 125gr*10 Réf. 00948', '3.83', 'kg', '9.98', '38.22', '2025-05-23 00:00:00', '2025-05-23 09:19:42', '2025-05-23 09:19:42', 21),
(152, 'Sirf', 'tomate cube Réf. 05369', '2.50', 'kg', '3.01', '7.53', '2025-05-23 00:00:00', '2025-05-23 09:19:42', '2025-05-23 09:19:42', 21),
(153, 'Sirf', 'piémontaise Réf. 01551', '2.00', 'kg', '6.69', '13.38', '2025-05-23 00:00:00', '2025-05-23 09:19:42', '2025-05-23 09:19:42', 21),
(154, 'Sirf', 'jambon grill 140gr*10 Réf. 03454', '1.45', 'kg', '12.34', '17.89', '2025-05-23 00:00:00', '2025-05-23 09:19:42', '2025-05-23 09:19:42', 21),
(155, 'Sirf', 'jambon grill 100gr*10', '2.02', 'kg', '11.08', '22.38', '2025-05-23 00:00:00', '2025-05-23 09:19:42', '2025-05-23 09:19:42', 21);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `description`, `created_at`) VALUES
(1, 'CM2', 'Classe de CM2', '2025-05-20 17:30:18'),
(2, 'CE2-CM1', 'Classe de CE2 et CM1', '2025-05-20 17:30:18'),
(3, 'Personnel', 'Personnel de l\'├®tablissement', '2025-05-20 17:30:18');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `fournisseur` varchar(255) NOT NULL,
  `date_commande` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_livraison_souhaitee` date DEFAULT NULL,
  `date_reception` date DEFAULT NULL,
  `statut` enum('brouillon','envoyee','recue','annulee') NOT NULL DEFAULT 'brouillon',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `convertie_en_achats` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `fournisseur`, `date_commande`, `date_livraison_souhaitee`, `date_reception`, `statut`, `notes`, `created_at`, `updated_at`, `convertie_en_achats`) VALUES
(14, 'Sirf DS', '2025-05-07 10:25:48', '2025-05-09', '2025-05-10', 'recue', NULL, '2025-05-07 08:25:48', '2025-05-10 10:05:12', 1),
(15, 'Leclerc', '2025-05-07 11:53:48', '2025-05-12', '2025-05-12', 'recue', 'pouvez-vous me livrer pour 8h00. Merci', '2025-05-07 09:53:48', '2025-05-12 08:52:48', 1),
(16, 'La Molle', '2025-05-07 12:03:35', '2025-05-09', NULL, 'envoyee', NULL, '2025-05-07 10:03:35', '2025-05-07 10:08:02', 0),
(18, 'Leclerc', '2025-05-07 13:00:22', '2025-05-05', '2025-05-07', 'recue', NULL, '2025-05-07 11:00:22', '2025-05-07 11:00:54', 1),
(19, 'Sirf', '2025-05-14 11:33:52', '2025-05-16', '2025-05-16', 'recue', NULL, '2025-05-14 09:33:52', '2025-05-16 07:51:37', 1),
(20, 'Leclerc', '2025-05-14 12:15:40', '2025-05-19', '2025-05-19', 'recue', 'si pas de petits louis ne pas remplacer', '2025-05-14 10:15:40', '2025-05-19 07:54:56', 1),
(21, 'Sirf', '2025-05-21 18:32:05', '2025-05-23', '2025-05-23', 'recue', 'pourquoi certains prix qui me sont facturés sont plus chère que les prix indiqués sur le site?', '2025-05-21 16:32:05', '2025-05-23 09:19:42', 1),
(22, 'Leclerc', '2025-05-21 18:58:40', '2025-05-26', NULL, 'envoyee', 'Livraison à partir de 8h00. Merci', '2025-05-21 16:58:40', '2025-05-21 16:58:51', 0),
(23, 'Leclerc', '2025-05-22 09:35:45', '2025-05-26', NULL, 'brouillon', NULL, '2025-05-22 07:35:45', '2025-05-22 07:35:45', 0);

-- --------------------------------------------------------

--
-- Structure de la table `haccp_documents`
--

CREATE TABLE `haccp_documents` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique_stocks`
--

CREATE TABLE `historique_stocks` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `date_mouvement` datetime NOT NULL,
  `mois_operation` date NOT NULL,
  `quantite_avant` decimal(10,2) NOT NULL,
  `quantite_apres` decimal(10,2) NOT NULL,
  `type_mouvement` enum('entrée','sortie') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique_stocks`
--

INSERT INTO `historique_stocks` (`id`, `stock_id`, `date_mouvement`, `mois_operation`, `quantite_avant`, `quantite_apres`, `type_mouvement`, `created_at`) VALUES
(4, 151, '2025-05-18 12:11:00', '2025-05-01', '0.00', '1.00', 'entrée', '2025-05-18 10:11:00'),
(7, 151, '2025-05-18 12:11:00', '2025-05-01', '1.00', '4.00', 'entrée', '2025-05-18 10:11:00'),
(11, 151, '2025-05-18 12:11:00', '2025-05-01', '4.00', '4.00', 'entrée', '2025-05-18 10:11:00'),
(12, 151, '2025-05-18 12:11:00', '2025-05-01', '4.00', '4.00', 'entrée', '2025-05-18 10:11:00');

-- --------------------------------------------------------

--
-- Structure de la table `lignes_commande`
--

CREATE TABLE `lignes_commande` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `produit` varchar(255) NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  `is_ttc` tinyint(1) DEFAULT '1',
  `taux_tva` decimal(4,1) DEFAULT '20.0',
  `prix_ht` decimal(10,2) DEFAULT NULL,
  `prix_ttc` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lignes_commande`
--

INSERT INTO `lignes_commande` (`id`, `commande_id`, `produit`, `quantite`, `unite`, `prix_unitaire`, `is_ttc`, `taux_tva`, `prix_ht`, `prix_ttc`) VALUES
(59, 16, 'pommes fruit', '2.00', 'kg', NULL, 1, '20.0', NULL, NULL),
(60, 16, 'poires', '5.00', 'kg', NULL, 1, '20.0', NULL, NULL),
(61, 16, 'oranges', '3.00', 'kg', NULL, 1, '20.0', NULL, NULL),
(62, 16, 'tomates', '6.00', 'kg', NULL, 1, '20.0', NULL, NULL),
(63, 16, 'batavia', '2.00', 'pièce', NULL, 1, '20.0', NULL, NULL),
(64, 16, 'radis', '3.00', 'kg', NULL, 1, '20.0', NULL, NULL),
(65, 16, 'pommes de terre ', '5.00', 'kg', NULL, 1, '20.0', NULL, NULL),
(66, 16, 'courgettes', '3.00', 'kg', NULL, 1, '20.0', NULL, NULL),
(67, 16, 'ail frais', '0.50', 'kg', NULL, 1, '20.0', NULL, NULL),
(68, 16, 'endives', '2.00', 'kg', NULL, 1, '20.0', NULL, NULL),
(164, 18, 'mini babibel *12', '2.00', 'barquette', '4.24', 1, '5.5', '4.02', '4.24'),
(165, 18, 'kiri portion *24', '1.00', 'boîte', '5.14', 1, '5.5', '4.87', '5.14'),
(166, 18, 'yaourts fruits *12', '2.00', 'carton', '3.40', 1, '5.5', '3.22', '3.40'),
(167, 18, 'creme fluide *3', '2.00', 'unité', '2.55', 1, '5.5', '2.42', '2.55'),
(168, 18, 'fromage frais *8', '2.00', 'carton', '1.79', 1, '5.5', '1.70', '1.79'),
(169, 18, 'coulommier', '2.00', 'pièce', '2.11', 1, '5.5', '2.00', '2.11'),
(170, 18, 'petit filou *12', '2.00', 'carton', '1.67', 1, '5.5', '1.58', '1.67'),
(171, 18, 'beurre doux', '2.00', 'pièce', '1.83', 1, '5.5', '1.73', '1.83'),
(172, 18, 'oeufs frais *12', '2.00', 'carton', '2.64', 1, '5.5', '2.50', '2.64'),
(173, 18, 'veau', '1.00', 'pièce', '79.82', 1, '5.5', '75.66', '79.82'),
(174, 18, 'eau de source', '1.00', 'carton', '1.14', 1, '5.5', '1.08', '1.14'),
(175, 18, 'petit louis', '2.00', 'sachet', '2.76', 1, '5.5', '2.62', '2.76'),
(176, 18, 'banane', '1.00', 'sachet', '6.54', 1, '5.5', '6.20', '6.54'),
(177, 18, 'carotte', '1.00', 'sachet', '4.57', 1, '5.5', '4.33', '4.57'),
(178, 18, 'poire', '1.00', 'sachet', '6.10', 1, '5.5', '5.78', '6.10'),
(179, 18, 'tomate', '1.00', 'sachet', '5.50', 1, '5.5', '5.21', '5.50'),
(180, 18, 'kiwi', '10.00', 'pièce', '0.59', 1, '5.5', '0.56', '0.59'),
(181, 18, 'batavia', '1.00', 'pièce', '1.29', 1, '5.5', '1.22', '1.29'),
(182, 18, 'céleri rave', '1.00', 'pièce', '1.99', 1, '5.5', '1.89', '1.99'),
(183, 18, 'filet poulet', '3.00', 'kg', '7.29', 1, '5.5', '6.91', '7.29'),
(184, 18, 'filet poulet jaune', '1.00', 'kg', '5.99', 1, '5.5', '5.68', '5.99'),
(185, 18, 'pomme fruit *2kg', '1.00', 'sachet', '2.99', 1, '5.5', '2.83', '2.99'),
(186, 18, 'PDT', '2.00', 'sachet', '4.78', 1, '5.5', '4.53', '4.78'),
(187, 18, 'concombre', '9.00', 'pièce', '1.29', 1, '5.5', '1.22', '1.29'),
(188, 18, 'sucre poudre', '1.00', 'kg', '1.39', 1, '5.5', '1.32', '1.39'),
(189, 18, 'haricots verts', '4.00', 'boîte', '1.15', 1, '5.5', '1.09', '1.15'),
(190, 18, 'plaquette chocolat', '3.00', 'unité', '1.82', 1, '5.5', '1.73', '1.82'),
(191, 18, 'riz', '2.00', 'unité', '1.69', 1, '5.5', '1.60', '1.69'),
(192, 18, 'fond de veau ', '1.00', 'boîte', '2.12', 1, '5.5', '2.01', '2.12'),
(193, 18, 'vien rouge cubi', '1.00', 'carton', '9.49', 1, '20.0', '7.91', '9.49'),
(194, 18, 'fumet poisson', '1.00', 'boîte', '2.01', 1, '5.5', '1.91', '2.01'),
(195, 18, 'jus citron', '1.00', 'bouteille', '1.69', 1, '5.5', '1.60', '1.69'),
(196, 18, 'vin blanc cubi', '1.00', 'carton', '8.99', 1, '20.0', '7.49', '8.99'),
(210, 14, 'terrine légumes', '3.20', 'kg', '7.86', 0, '5.5', '7.86', '8.29'),
(211, 14, 'escaloppe de dinde', '4.99', 'kg', '9.30', 0, '5.5', '9.30', '9.81'),
(212, 14, 'pommes duchesse', '5.00', 'kg', '4.49', 0, '5.5', '4.49', '4.74'),
(213, 14, 'poellée 4 légumes', '5.00', 'kg', '4.78', 0, '5.5', '4.78', '5.04'),
(214, 14, 'salade de fruits saison', '3.00', 'kg', '5.60', 0, '5.5', '5.60', '5.91'),
(215, 14, 'céleri rémoulade', '2.00', 'kg', '4.15', 0, '5.5', '4.15', '4.38'),
(216, 14, 'egréné pur boeuf 15%', '3.00', 'kg', '19.43', 0, '5.5', '19.43', '20.50'),
(217, 14, 'paté de campagne suppérieur', '2.95', 'kg', '5.97', 0, '5.5', '5.97', '6.30'),
(218, 14, 'poisson blanc meuniere', '6.00', 'kg', '9.44', 0, '5.5', '9.44', '9.96'),
(219, 14, 'ail hachée', '1.00', 'unité', '4.09', 0, '5.5', '4.09', '4.31'),
(220, 14, 'persil émincé', '1.00', 'unité', '3.36', 0, '5.5', '3.36', '3.54'),
(221, 14, 'oignon émincé', '2.50', 'kg', '3.25', 0, '5.5', '3.25', '3.43'),
(222, 15, 'lait demi écrémé', '2.00', 'L', '5.61', 1, '5.5', '5.32', '5.61'),
(223, 15, 'riz rond sachet 1kg éco+', '1.00', 'kg', '1.79', 1, '5.5', '1.70', '1.79'),
(224, 15, 'arome vanille 200ml', '1.00', 'bouteille', '2.38', 1, '5.5', '2.26', '2.38'),
(225, 15, 'sucre blanc poudre éco', '1.00', 'kg', '1.39', 1, '5.5', '1.32', '1.39'),
(226, 15, 'lasagne boite carton 500gr', '3.00', 'carton', '1.39', 1, '5.5', '1.32', '1.39'),
(227, 15, 'origan flacon 11gr', '1.00', 'unité', '1.62', 1, '5.5', '1.54', '1.62'),
(228, 15, 'thym sélectionné flacon 14gr rustica', '1.00', 'unité', '0.40', 1, '5.5', '0.38', '0.40'),
(229, 15, 'sel fin de table 750gr éco+', '1.00', 'unité', '0.54', 1, '5.5', '0.51', '0.54'),
(230, 15, 'fond de veau 110gr rustica', '2.00', 'pièce', '2.12', 1, '5.5', '2.01', '2.12'),
(231, 15, 'muscade moulue flacon 32gr rustica', '1.00', 'unité', '1.37', 1, '5.5', '1.30', '1.37'),
(232, 15, 'yaourts aromatisésaux fruits délisse *16', '3.00', 'carton', '2.50', 1, '5.5', '2.37', '2.50'),
(233, 15, 'yaourt à la grecque nature  delisse *8', '3.00', 'carton', '2.15', 1, '5.5', '2.04', '2.15'),
(234, 15, 'petits suisse aux fruits', '1.00', 'pièce', '5.02', 1, '5.5', '4.76', '5.02'),
(235, 15, 'mimolette 23.7% Mat gr 250gr', '2.00', 'unité', '2.97', 1, '5.5', '2.82', '2.97'),
(236, 15, 'kiri *12', '4.00', 'pièce', '2.74', 1, '5.5', '2.60', '2.74'),
(237, 15, 'mini babibel', '4.00', 'pièce', '4.24', 1, '5.5', '4.02', '4.24'),
(238, 15, 'banane petit calibre', '1.00', 'kg', '6.28', 1, '5.5', '5.95', '6.28'),
(239, 15, 'créme fluide entière 30% *3', '2.00', 'carton', '2.55', 1, '5.5', '2.42', '2.55'),
(240, 15, 'moutarde de dijon 370gr', '1.00', 'pot', '0.79', 1, '5.5', '0.75', '0.79'),
(241, 15, 'huile de tournesol 1l rustica', '1.00', 'L', '1.99', 1, '5.5', '1.89', '1.99'),
(242, 15, 'oeuf frais *12', '2.00', 'carton', '3.49', 1, '5.5', '3.31', '3.49'),
(243, 15, 'beurre de bretagne doux 500gr les croisés', '2.00', 'pièce', '4.80', 1, '5.5', '4.55', '4.80'),
(244, 15, 'polenta 500gr ', '3.00', 'pièce', '1.42', 1, '5.5', '1.35', '1.42'),
(245, 15, 'double concentré de tomates Turini *3', '1.00', 'barquette', '2.15', 1, '5.5', '2.04', '2.15'),
(246, 15, 'purée de tomates fraiche *3', '1.00', 'carton', '1.19', 1, '5.5', '1.13', '1.19'),
(247, 15, 'cornichons pasteurisés au vinaigre éco ', '3.00', 'pot', '0.90', 1, '5.5', '0.85', '0.90'),
(248, 15, 'olives vertes dénoyautées éco', '1.00', 'pot', '2.55', 1, '5.5', '2.42', '2.55'),
(249, 15, 'rapé 3 from', '5.00', '', '1.80', 1, '5.5', '1.71', '1.80'),
(313, 19, 'Terrine forestière champignons Réf. 02507', '1.60', 'kg', '10.35', 0, '5.5', '10.35', '10.92'),
(314, 19, 'Steak haché pur boeuf 100gr Réf. 02788', '6.00', 'kg', '13.50', 0, '5.5', '13.50', '14.24'),
(315, 19, 'Pommes paillasson 1.5kg Réf. 00903', '4.50', 'kg', '6.46', 0, '5.5', '6.46', '6.82'),
(316, 19, 'Petits pois 2.5kg Réf. 00265', '2.50', 'kg', '3.87', 0, '5.5', '3.87', '4.08'),
(317, 19, 'Taboulé Réf. 01550 2kg', '2.00', 'kg', '5.70', 0, '5.5', '5.70', '6.01'),
(318, 19, 'Roti de porc longe ', '3.06', 'kg', '7.40', 0, '5.5', '7.40', '7.81'),
(319, 19, 'estragon 250gr', '1.00', 'sachet', '4.30', 0, '5.5', '4.30', '4.54'),
(320, 19, 'Pommes sutées 2.5kg', '5.00', 'kg', '3.75', 0, '5.5', '3.75', '3.96'),
(321, 19, 'Dos de colin lieu Réf. 02229', '5.00', 'kg', '11.30', 0, '5.5', '11.30', '11.92'),
(322, 19, 'Haricots beurre Réf. 09867', '2.50', 'kg', '3.10', 0, '5.5', '3.10', '3.27'),
(323, 19, 'Fond de tarte sucrée Réf. 12388', '1.00', 'carton', '14.19', 0, '5.5', '14.19', '14.97'),
(324, 19, 'Cocktail de fruits rouges', '3.00', 'kg', '5.85', 0, '5.5', '5.85', '6.17'),
(325, 19, 'Echalotes cubes 0.250kg Réf. 00825', '1.00', '', '2.93', 0, '5.5', '2.93', '3.09'),
(351, 20, 'Carottes', '1.00', 'carton', '4.71', 1, '5.5', '4.46', '4.71'),
(352, 20, 'lait demi écrémé ', '1.00', 'carton', '6.30', 1, '5.5', '5.97', '6.30'),
(353, 20, 'oeuf frais', '1.00', 'boîte', '1.49', 1, '5.5', '1.41', '1.49'),
(354, 20, 'farine eco', '1.00', 'kg', '0.63', 1, '5.5', '0.60', '0.63'),
(355, 20, 'cumin', '1.00', 'pièce', '0.59', 1, '5.5', '0.56', '0.59'),
(356, 20, 'poivre moulu', '1.00', 'pièce', '1.99', 1, '5.5', '1.89', '1.99'),
(357, 20, 'lentilles blondes 500gr eco', '3.00', 'boîte', '1.03', 1, '5.5', '0.98', '1.03'),
(358, 20, 'pommes de terre ', '1.00', 'carton', '3.79', 1, '5.5', '3.59', '3.79'),
(359, 20, 'beurre doux 500gr', '1.00', 'pièce', '4.79', 1, '5.5', '4.54', '4.79'),
(360, 20, 'champignons paris', '2.00', 'kg', '5.98', 1, '5.5', '5.67', '5.98'),
(361, 20, 'crème fluide 30% lot de 3pièces', '2.00', 'unité', '1.84', 1, '5.5', '1.74', '1.84'),
(362, 20, 'huile tournesol', '1.00', 'L', '1.99', 1, '5.5', '1.89', '1.99'),
(363, 20, 'poireaux', '5.00', 'kg', '3.50', 1, '5.5', '3.32', '3.50'),
(364, 20, 'vin blanc cuisine cubi 3l', '1.00', 'pièce', '8.48', 1, '20.0', '7.07', '8.48'),
(365, 20, 'bleu 31% 250gr les croisés', '4.00', 'pièce', '2.21', 1, '5.5', '2.09', '2.21'),
(366, 20, 'petits louis sachet', '3.00', 'sachet', '3.54', 1, '5.5', '3.36', '3.54'),
(367, 20, 'saint moret portion', '3.00', 'boîte', '2.00', 1, '5.5', '1.90', '2.00'),
(368, 20, 'yaourt nature', '2.00', 'boîte', '2.25', 1, '5.5', '2.13', '2.25'),
(369, 20, 'fromage blanc', '5.00', 'boîte', '1.79', 1, '5.5', '1.70', '1.79'),
(370, 20, 'riz indica', '2.00', 'kg', '2.48', 1, '5.5', '2.35', '2.48'),
(371, 20, 'banane petit calibre', '8.00', 'kg', '0.79', 1, '5.5', '0.75', '0.79'),
(372, 20, 'semoule moyenne couscous', '1.00', 'unité', '0.95', 1, '5.5', '0.90', '0.95'),
(373, 20, 'tomate grappe', '1.00', 'carton', '5.44', 1, '5.5', '5.16', '5.44'),
(374, 20, 'batavia', '2.00', 'pièce', '1.29', 1, '5.5', '1.22', '1.29'),
(375, 20, 'yaourt Nat', '1.00', 'pièce', '0.65', 1, '5.5', '0.62', '0.65'),
(382, 22, 'huile d\'olive rustica 1.5l', '1.00', 'bouteille', '12.90', 1, '5.5', '12.23', '12.90'),
(383, 22, 'huile de tournesol rustica', '1.00', 'L', '1.99', 1, '5.5', '1.89', '1.99'),
(384, 22, 'sucre blanc poudre eco', '1.00', 'kg', '1.37', 1, '5.5', '1.30', '1.37'),
(385, 22, 'aubergine', '1.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(386, 22, 'poivron vert', '1.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(387, 22, 'courgette', '1.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(388, 22, 'tomate', '1.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(389, 22, 'tomates entières pelées au jus 240gr notre jardin', '3.00', 'boîte', '0.85', 1, '5.5', '0.81', '0.85'),
(390, 22, 'double contré de tomates lot 3 turini', '1.00', 'unité', '2.15', 1, '5.5', '2.04', '2.15'),
(391, 22, 'porto tawny 18% eco', '1.00', 'bouteille', '5.38', 1, '20.0', '4.48', '5.38'),
(392, 22, 'creme fluide entière uht 30% lot*3 delisse', '1.00', 'unité', '2.55', 1, '5.5', '2.42', '2.55'),
(393, 22, 'céleri rave (boule)', '4.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(394, 22, 'beurre bretagne 1/2 sel les croisés 500gr', '2.00', 'pièce', '4.79', 1, '5.5', '4.54', '4.79'),
(395, 22, 'babibel individuel filet', '2.00', 'sachet', NULL, 1, '5.5', NULL, NULL),
(396, 22, 'tagliatelles 600gr turini', '3.00', 'pièce', '1.85', 1, '5.5', '1.75', '1.85'),
(397, 22, 'fond de colaille déshydraté rustica', '1.00', 'boîte', '2.21', 1, '5.5', '2.09', '2.21'),
(398, 22, 'lait demi écrémé brique *6l', '1.00', 'carton', '5.94', 1, '5.5', '5.63', '5.94'),
(418, 23, 'banane petit calibre', '2.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(419, 23, 'cocacolas 1.5l', '3.00', 'bouteille', NULL, 1, '20.0', NULL, NULL),
(420, 23, 'orangina 1.5', '3.00', 'bouteille', NULL, 1, '20.0', NULL, NULL),
(421, 23, 'poire', '2.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(422, 21, 'haricot vert extra fin Réf. 71600', '2.50', 'kg', '3.58', 0, '5.5', '3.58', '3.78'),
(423, 21, 'saucisse toulouse 125gr*10 Réf. 00948', '3.83', 'kg', '9.46', 0, '5.5', '9.46', '9.98'),
(424, 21, 'tomate cube Réf. 05369', '2.50', 'kg', '2.85', 0, '5.5', '2.85', '3.01'),
(425, 21, 'piémontaise Réf. 01551', '2.00', 'kg', '6.34', 0, '5.5', '6.34', '6.69'),
(426, 21, 'jambon grill 140gr*10 Réf. 03454', '1.45', 'kg', '11.70', 0, '5.5', '11.70', '12.34'),
(427, 21, 'jambon grill 100gr*10', '2.02', 'kg', '10.50', 0, '5.5', '10.50', '11.08');

-- --------------------------------------------------------

--
-- Structure de la table `menus_jours`
--

CREATE TABLE `menus_jours` (
  `id` int(11) NOT NULL,
  `semaine_id` int(11) NOT NULL,
  `jour` enum('lundi','mardi','jeudi','vendredi') NOT NULL,
  `entree` varchar(255) DEFAULT NULL,
  `plat` varchar(255) NOT NULL,
  `accompagnement` varchar(255) DEFAULT NULL,
  `laitage` varchar(255) DEFAULT NULL,
  `dessert` varchar(255) DEFAULT NULL,
  `options` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `menus_jours`
--

INSERT INTO `menus_jours` (`id`, `semaine_id`, `jour`, `entree`, `plat`, `accompagnement`, `laitage`, `dessert`, `options`) VALUES
(1, 1, 'lundi', 'Tomte vinaigrette', 'Filet de poulet', 'Riz et petits pois', 'Fromage ou Yaourt', 'Fruit de saison', '{\"entree\":{\"options\":[],\"allergenes\":[]},\"plat\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[],\"allergenes\":[]}}'),
(2, 1, 'mardi', 'Concombres à la crème', 'Sauté de veau aux pommes', 'Purée au céleri rave', 'Fromage ou yaourt', 'Mousse au chocolat', '{\"entree\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"plat\":{\"options\":[],\"allergenes\":[]},\"accompagnement\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"allergenes\"],\"allergenes\":[\"oeufs\"]}}'),
(3, 1, 'vendredi', 'Carottes rârées', 'Cabillaud sauce citronnée', 'Pommes vapeur et haricots verts', 'Fromage ou Yaourt', 'Fruit de saison', '{\"entree\":{\"options\":[],\"allergenes\":[]},\"plat\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\",\"poisson\"]},\"accompagnement\":{\"options\":[],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[],\"allergenes\":[]}}'),
(4, 2, 'lundi', 'Terrine de légumes', 'Escalope de dinde ', 'Pommes duchesse et Poêllée de légumes', 'Fromage ou Yaourt', 'Fruit de saison', '{\"entree\":{\"options\":[\"allergenes\"],\"allergenes\":[\"oeufs\"]},\"plat\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]}}'),
(5, 2, 'mardi', 'Céleri rémoulade', 'Gratin de courgettes et pommes de terre au fromage', '', 'Fromage ou yaourt', 'Riz au lait', '{\"entree\":{\"options\":[\"allergenes\"],\"allergenes\":[\"celeri\",\"moutarde\"]},\"plat\":{\"options\":[\"vegetarien\",\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]}}'),
(6, 2, 'jeudi', 'Radis et endives vinaigrette', 'Lasagnes bolognaise', 'Salade', 'Fromage ou Yaourt', 'Fruit de saison', '{\"entree\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]},\"plat\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]}}'),
(7, 2, 'vendredi', 'Paté de campagne', 'Filet de poisson meunière', 'Tomate provençale et riz', 'Fromage ou Yaourt', 'Poire pochée au sirop', '{\"entree\":{\"options\":[],\"allergenes\":[]},\"plat\":{\"options\":[],\"allergenes\":[]},\"accompagnement\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]}}'),
(8, 3, 'lundi', 'Terrine forestière', 'Steak haché sauce au bleu', 'Pommes paillasson Petits pois', 'Fromage ou Yaourt', 'Fruit de saison', '{\"entree\":{\"options\":[],\"allergenes\":[]},\"plat\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]}}'),
(9, 3, 'mardi', 'Taboulé', 'Longe de porc à l\'estragon', 'Carottes et pommes de terre sautées', 'Fromage ou yaourt', 'Oeufs au lait', '{\"entree\":{\"options\":[],\"allergenes\":[]},\"plat\":{\"options\":[],\"allergenes\":[]},\"accompagnement\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]},\"laitage\":{\"options\":[],\"allergenes\":[]},\"dessert\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\",\"oeufs\"]}}'),
(10, 3, 'jeudi', 'Champignons à la crème', 'Parmentier de lentilles', 'Salade', 'Fromage ou Yaourt', 'Fruit de saison', '{\"entree\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"plat\":{\"options\":[\"vegetarien\",\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]}}'),
(11, 3, 'vendredi', 'Poireau vinaigrette', 'filet de lieu', 'Riz et haricots beurre', 'Fromage ou Yaourt', 'Tarte fruits', '{\"entree\":{\"options\":[],\"allergenes\":[]},\"plat\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[],\"allergenes\":[]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"allergenes\",\"local\",\"bio\"],\"allergenes\":[\"lait\",\"oeufs\",\"gluten\"]}}'),
(12, 4, 'lundi', 'Piémontaise', 'Rougail de saucisses', 'Pâtes Ratatouille', 'Fromage ou Yaourt', 'Fruit de saison', '{\"entree\":{\"options\":[\"allergenes\"],\"allergenes\":[\"oeufs\"]},\"plat\":{\"options\":[],\"allergenes\":[]},\"accompagnement\":{\"options\":[\"allergenes\"],\"allergenes\":[\"gluten\"]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]}}'),
(13, 4, 'mardi', 'Haricots vert en salade', 'Jambon grill sauce porto', 'Purée de pommes de terre Céleri poêlé', 'Fromage ou yaourt', 'Pâtisserie', '{\"entree\":{\"options\":[],\"allergenes\":[]},\"plat\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\",\"celeri\"]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"allergenes\",\"local\",\"bio\"],\"allergenes\":[\"lait\",\"oeufs\",\"gluten\"]}}');

-- --------------------------------------------------------

--
-- Structure de la table `menus_semaines`
--

CREATE TABLE `menus_semaines` (
  `id` int(11) NOT NULL,
  `numero_semaine` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `menus_semaines`
--

INSERT INTO `menus_semaines` (`id`, `numero_semaine`, `annee`, `date_debut`, `date_fin`, `active`, `created_at`) VALUES
(1, 19, 2025, '2025-05-05', '2025-05-09', 0, '2025-05-03 06:32:49'),
(2, 20, 2025, '2025-05-12', '2025-05-16', 0, '2025-05-05 04:45:17'),
(3, 21, 2025, '2025-05-19', '2025-05-23', 0, '2025-05-07 10:29:46'),
(4, 22, 2025, '2025-05-26', '2025-05-30', 1, '2025-05-11 10:50:34');

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

CREATE TABLE `personnes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `actif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnes`
--

INSERT INTO `personnes` (`id`, `nom`, `prenom`, `categorie_id`, `actif`, `created_at`) VALUES
(6, 'AUSSEURS FREMONT', 'Baptiste', 2, 1, '2025-05-21 05:34:03'),
(7, 'BODIN', 'Théa', 2, 1, '2025-05-21 05:34:24'),
(8, 'BOUVET', 'Ema', 2, 1, '2025-05-21 05:34:39'),
(9, 'FAULCON', 'Nolan', 2, 1, '2025-05-21 05:35:48'),
(10, 'KOENING', 'Victor', 2, 1, '2025-05-21 05:36:16'),
(11, 'LEOMAND', 'Kayson', 2, 1, '2025-05-21 05:36:42'),
(12, 'RIGAUD', 'Shaïly', 2, 1, '2025-05-21 05:39:11'),
(13, 'BERTHELIN', 'Owen', 2, 1, '2025-05-21 05:39:33'),
(14, 'BOURGOIN', 'Cassandra', 2, 1, '2025-05-21 05:39:59'),
(15, 'BREGEAUD', 'Lyssanna', 2, 1, '2025-05-21 05:40:38'),
(16, 'CALLEC', 'Gwenaëlle', 2, 1, '2025-05-21 05:41:58'),
(17, 'DECRA', 'Zoé', 2, 1, '2025-05-21 05:42:16'),
(18, 'DURAND', 'Enrique', 2, 1, '2025-05-21 05:42:40'),
(19, 'LAGARDE', 'Lana', 2, 1, '2025-05-21 05:42:59'),
(20, 'PINEAULT', 'Remy', 2, 1, '2025-05-21 05:43:18'),
(21, 'RIGAUD', 'Shanna', 2, 1, '2025-05-21 05:43:41'),
(22, 'SOUIL                            ', 'Faustine                            ', 2, 1, '2025-05-21 05:44:06'),
(23, 'SOUIL PROUST', 'Raphaël', 2, 1, '2025-05-21 05:44:58'),
(24, 'VIGIER', 'Chloé', 2, 1, '2025-05-21 05:45:24'),
(25, 'AUDIDIER', 'Meline', 2, 1, '2025-05-21 05:45:55'),
(26, 'SICARD', 'Théotyme', 2, 1, '2025-05-21 05:46:31'),
(27, 'PAYET', 'Valentin', 2, 1, '2025-05-21 05:46:47'),
(28, 'ARTAUD', 'Mathys', 1, 1, '2025-05-21 06:01:51'),
(29, 'BOIZARD', 'Lucas', 1, 1, '2025-05-21 06:02:18'),
(30, 'BOUHIER', 'Océane', 1, 1, '2025-05-21 06:03:15'),
(31, 'BOUVET', 'Lina', 1, 1, '2025-05-21 06:03:31'),
(32, 'BUSVETRE', 'Lucie', 1, 1, '2025-05-21 06:03:55'),
(33, 'CAILLAUD', 'Sasha', 1, 1, '2025-05-21 06:04:23'),
(34, 'CARAMIGEAS', 'Léona', 1, 1, '2025-05-21 06:04:52'),
(35, 'CHAGNON JOUBERT', 'Isaac', 1, 1, '2025-05-21 06:05:29'),
(36, 'CHARRE', 'Robin', 1, 1, '2025-05-21 06:05:50'),
(37, 'DESERBAIS', 'Lucas', 1, 1, '2025-05-21 06:06:41'),
(38, 'DIOT', 'Kalvin', 1, 1, '2025-05-21 06:06:58'),
(39, 'HUBERT', 'Louis', 1, 1, '2025-05-21 06:07:23'),
(40, 'NOUHAILHAGUET', 'Laure', 1, 1, '2025-05-21 06:08:09'),
(41, 'PEROT', 'Théo', 1, 1, '2025-05-21 06:08:35'),
(42, 'THERMEAU', 'Evan', 1, 1, '2025-05-21 06:08:56'),
(43, 'TURCAUD MICHAUD', 'Marius', 1, 1, '2025-05-21 06:09:25'),
(44, 'TURCAUD MICHAUD', 'Stanislas', 1, 1, '2025-05-21 06:09:51'),
(45, 'KOENING                        ', 'Angélique                            ', 3, 1, '2025-05-21 06:22:08'),
(46, 'BROCHARD                    ', 'Lydia                            ', 3, 1, '2025-05-21 06:22:24'),
(47, 'DEJEAN', 'Patricia', 3, 1, '2025-05-21 06:22:42'),
(48, 'SERVANT', 'Camille', 3, 1, '2025-05-21 06:23:17');

-- --------------------------------------------------------

--
-- Structure de la table `presences`
--

CREATE TABLE `presences` (
  `id` int(11) NOT NULL,
  `personne_id` int(11) NOT NULL,
  `date_presence` date NOT NULL,
  `present` tinyint(1) DEFAULT '0',
  `absent` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `presences`
--

INSERT INTO `presences` (`id`, `personne_id`, `date_presence`, `present`, `absent`, `created_at`, `modified_at`) VALUES
(21, 6, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(22, 7, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(23, 8, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(24, 9, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(25, 10, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(26, 11, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(27, 12, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(28, 13, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(29, 14, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(30, 15, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(31, 16, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(32, 17, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(33, 18, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(34, 19, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(35, 20, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:32:18'),
(36, 21, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(37, 22, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(38, 23, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(39, 24, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(40, 25, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(41, 26, '2025-05-05', 1, 0, '2025-05-21 05:48:42', '2025-05-21 06:25:31'),
(42, 27, '2025-05-05', 0, 1, '2025-05-21 05:48:42', '2025-05-21 06:32:18'),
(43, 6, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(44, 7, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(45, 8, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(46, 9, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(47, 10, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(48, 11, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(49, 12, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(50, 13, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(51, 14, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(52, 15, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(53, 16, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(54, 17, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(55, 18, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(56, 19, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(57, 20, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(58, 21, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(59, 22, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(60, 23, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(61, 24, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(62, 25, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(63, 26, '2025-05-06', 1, 0, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(64, 27, '2025-05-06', 0, 1, '2025-05-21 05:49:27', '2025-05-21 06:32:58'),
(65, 6, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(66, 7, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(67, 8, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(68, 9, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(69, 10, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(70, 11, '2025-05-09', 0, 1, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(71, 12, '2025-05-09', 0, 1, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(72, 13, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(73, 14, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(74, 15, '2025-05-09', 0, 1, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(75, 16, '2025-05-09', 0, 1, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(76, 17, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(77, 18, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(78, 19, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(79, 20, '2025-05-09', 0, 1, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(80, 21, '2025-05-09', 0, 1, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(81, 22, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(82, 23, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(83, 24, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(84, 25, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(85, 26, '2025-05-09', 1, 0, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(86, 27, '2025-05-09', 0, 1, '2025-05-21 05:55:18', '2025-05-21 06:34:42'),
(87, 6, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(88, 7, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(89, 8, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(90, 9, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(91, 10, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(92, 11, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(93, 12, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(94, 13, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(95, 14, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(96, 15, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(97, 16, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(98, 17, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(99, 18, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(100, 19, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(101, 20, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(102, 21, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(103, 22, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(104, 23, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(105, 24, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(106, 25, '2025-05-12', 0, 1, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(107, 26, '2025-05-12', 1, 0, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(108, 27, '2025-05-12', 0, 1, '2025-05-21 05:56:05', '2025-05-21 06:35:50'),
(109, 6, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(110, 7, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(111, 8, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(112, 9, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(113, 10, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(114, 11, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(115, 12, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(116, 13, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(117, 14, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(118, 15, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(119, 16, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(120, 17, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(121, 18, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(122, 19, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(123, 20, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(124, 21, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(125, 22, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(126, 23, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(127, 24, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(128, 25, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(129, 26, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(130, 27, '2025-05-13', 1, 0, '2025-05-21 05:56:27', '2025-05-21 06:36:23'),
(131, 6, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(132, 7, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(133, 8, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(134, 9, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(135, 10, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(136, 11, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(137, 12, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(138, 13, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(139, 14, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(140, 15, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(141, 16, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(142, 17, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(143, 18, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(144, 19, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(145, 20, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(146, 21, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(147, 22, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(148, 23, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(149, 24, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(150, 25, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(151, 26, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(152, 27, '2025-05-15', 1, 0, '2025-05-21 05:57:17', '2025-05-21 06:37:06'),
(153, 6, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(154, 7, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(155, 8, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(156, 9, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(157, 10, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(158, 11, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(159, 12, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(160, 13, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(161, 14, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(162, 15, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(163, 16, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(164, 17, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(165, 18, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(166, 19, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(167, 20, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(168, 21, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(169, 22, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(170, 23, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(171, 24, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(172, 25, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(173, 26, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(174, 27, '2025-05-16', 1, 0, '2025-05-21 05:57:43', '2025-05-21 06:37:46'),
(175, 6, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(176, 7, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(177, 8, '2025-05-19', 0, 1, '2025-05-21 05:58:36', '2025-05-21 06:39:16'),
(178, 9, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(179, 10, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(180, 11, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(181, 12, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(182, 13, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(183, 14, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(184, 15, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(185, 16, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(186, 17, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(187, 18, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(188, 19, '2025-05-19', 0, 1, '2025-05-21 05:58:36', '2025-05-21 06:39:16'),
(189, 20, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(190, 21, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(191, 22, '2025-05-19', 0, 1, '2025-05-21 05:58:36', '2025-05-21 06:39:16'),
(192, 23, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(193, 24, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(194, 25, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(195, 26, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(196, 27, '2025-05-19', 1, 0, '2025-05-21 05:58:36', '2025-05-21 06:39:38'),
(197, 6, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(198, 7, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(199, 8, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(200, 9, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(201, 10, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(202, 11, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(203, 12, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(204, 13, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(205, 14, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(206, 15, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(207, 16, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(208, 17, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(209, 18, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(210, 19, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(211, 20, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(212, 21, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(213, 22, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(214, 23, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(215, 24, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(216, 25, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(217, 26, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(218, 27, '2025-05-20', 1, 0, '2025-05-21 05:58:59', '2025-05-21 06:42:34'),
(241, 28, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(242, 29, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(243, 30, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(244, 31, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(245, 32, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(246, 33, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(247, 34, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(248, 35, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(249, 36, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(250, 37, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(251, 38, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(252, 39, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(253, 40, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(254, 41, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(255, 42, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(256, 43, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(257, 44, '2025-05-05', 1, 0, '2025-05-21 06:10:18', '2025-05-21 06:30:50'),
(280, 28, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(281, 29, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(282, 30, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(283, 31, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(284, 32, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(285, 33, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(286, 34, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(287, 35, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(288, 36, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(289, 37, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(290, 38, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(291, 39, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(292, 40, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(293, 41, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(294, 42, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(295, 43, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(296, 44, '2025-05-06', 1, 0, '2025-05-21 06:10:36', '2025-05-21 06:10:36'),
(319, 28, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(320, 29, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(321, 30, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(322, 31, '2025-05-09', 0, 1, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(323, 32, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(324, 33, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(325, 34, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(326, 35, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(327, 36, '2025-05-09', 0, 1, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(328, 37, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(329, 38, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(330, 39, '2025-05-09', 0, 1, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(331, 40, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(332, 41, '2025-05-09', 1, 0, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(333, 42, '2025-05-09', 0, 1, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(334, 43, '2025-05-09', 0, 1, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(335, 44, '2025-05-09', 0, 1, '2025-05-21 06:11:42', '2025-05-21 06:11:42'),
(358, 28, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(359, 29, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(360, 30, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(361, 31, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(362, 32, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(363, 33, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(364, 34, '2025-05-12', 0, 1, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(365, 35, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(366, 36, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(367, 37, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(368, 38, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(369, 39, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(370, 40, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(371, 41, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(372, 42, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(373, 43, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(374, 44, '2025-05-12', 1, 0, '2025-05-21 06:12:13', '2025-05-21 06:12:13'),
(397, 28, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(398, 29, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(399, 30, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(400, 31, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(401, 32, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(402, 33, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(403, 34, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(404, 35, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(405, 36, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(406, 37, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(407, 38, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(408, 39, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(409, 40, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(410, 41, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(411, 42, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(412, 43, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(413, 44, '2025-05-13', 1, 0, '2025-05-21 06:12:34', '2025-05-21 06:12:34'),
(436, 28, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(437, 29, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(438, 30, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(439, 31, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(440, 32, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(441, 33, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(442, 34, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(443, 35, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(444, 36, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(445, 37, '2025-05-15', 0, 1, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(446, 38, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(447, 39, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(448, 40, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(449, 41, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(450, 42, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(451, 43, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(452, 44, '2025-05-15', 1, 0, '2025-05-21 06:14:43', '2025-05-21 06:40:29'),
(475, 28, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(476, 29, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(477, 30, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(478, 31, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(479, 32, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(480, 33, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(481, 34, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(482, 35, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(483, 36, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(484, 37, '2025-05-16', 0, 1, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(485, 38, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(486, 39, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(487, 40, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(488, 41, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(489, 42, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(490, 43, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(491, 44, '2025-05-16', 1, 0, '2025-05-21 06:15:15', '2025-05-21 06:40:59'),
(514, 28, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(515, 29, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(516, 30, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(517, 31, '2025-05-19', 0, 1, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(518, 32, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(519, 33, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(520, 34, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(521, 35, '2025-05-19', 0, 1, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(522, 36, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(523, 37, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(524, 38, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(525, 39, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(526, 40, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(527, 41, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(528, 42, '2025-05-19', 0, 1, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(529, 43, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(530, 44, '2025-05-19', 1, 0, '2025-05-21 06:16:04', '2025-05-21 06:41:56'),
(553, 28, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(554, 29, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(555, 30, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(556, 31, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(557, 32, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(558, 33, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(559, 34, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(560, 35, '2025-05-20', 0, 1, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(561, 36, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(562, 37, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(563, 38, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(564, 39, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(565, 40, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(566, 41, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(567, 42, '2025-05-20', 0, 1, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(568, 43, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(569, 44, '2025-05-20', 1, 0, '2025-05-21 06:16:34', '2025-05-21 06:16:34'),
(609, 45, '2025-05-15', 1, 0, '2025-05-21 06:23:44', '2025-05-21 06:23:44'),
(610, 46, '2025-05-15', 1, 0, '2025-05-21 06:23:44', '2025-05-21 06:23:44'),
(611, 47, '2025-05-15', 0, 0, '2025-05-21 06:23:44', '2025-05-21 06:23:44'),
(612, 48, '2025-05-15', 0, 0, '2025-05-21 06:23:44', '2025-05-21 06:23:44'),
(652, 45, '2025-05-16', 0, 0, '2025-05-21 06:23:55', '2025-05-21 06:23:55'),
(653, 46, '2025-05-16', 0, 0, '2025-05-21 06:23:55', '2025-05-21 06:23:55'),
(654, 47, '2025-05-16', 1, 0, '2025-05-21 06:23:55', '2025-05-21 06:23:55'),
(655, 48, '2025-05-16', 0, 0, '2025-05-21 06:23:55', '2025-05-21 06:23:55'),
(695, 45, '2025-05-19', 0, 0, '2025-05-21 06:24:02', '2025-05-21 06:24:02'),
(696, 46, '2025-05-19', 0, 0, '2025-05-21 06:24:02', '2025-05-21 06:24:02'),
(697, 47, '2025-05-19', 0, 0, '2025-05-21 06:24:02', '2025-05-21 06:24:02'),
(698, 48, '2025-05-19', 1, 0, '2025-05-21 06:24:02', '2025-05-21 06:24:02'),
(738, 45, '2025-05-05', 0, 0, '2025-05-21 06:25:31', '2025-05-21 06:25:31'),
(739, 46, '2025-05-05', 0, 0, '2025-05-21 06:25:31', '2025-05-21 06:25:31'),
(740, 47, '2025-05-05', 0, 0, '2025-05-21 06:25:31', '2025-05-21 06:25:31'),
(741, 48, '2025-05-05', 0, 0, '2025-05-21 06:25:31', '2025-05-21 06:25:31'),
(1030, 28, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:50'),
(1031, 29, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:50'),
(1032, 30, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:50'),
(1033, 31, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:50'),
(1034, 32, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:50'),
(1035, 33, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1036, 34, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1037, 35, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1038, 36, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1039, 37, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1040, 38, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1041, 39, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1042, 40, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1043, 41, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1044, 42, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1045, 43, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1046, 44, '2025-05-21', 0, 0, '2025-05-21 17:34:30', '2025-05-21 17:34:30'),
(1047, 45, '2025-05-22', 0, 0, '2025-05-22 06:21:21', '2025-05-22 06:21:21'),
(1048, 46, '2025-05-22', 1, 0, '2025-05-22 06:21:21', '2025-05-22 08:29:37'),
(1049, 47, '2025-05-22', 1, 0, '2025-05-22 06:21:21', '2025-05-22 06:21:21'),
(1050, 48, '2025-05-22', 0, 0, '2025-05-22 06:21:21', '2025-05-22 06:21:21'),
(1051, 28, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1052, 29, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1053, 30, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1054, 31, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1055, 32, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1056, 33, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1057, 34, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1058, 35, '2025-05-22', 0, 1, '2025-05-22 07:30:10', '2025-05-22 07:30:10'),
(1059, 36, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1060, 37, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1061, 38, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1062, 39, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1063, 40, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1064, 41, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1065, 42, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1066, 43, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1067, 44, '2025-05-22', 1, 0, '2025-05-22 07:30:10', '2025-05-22 08:32:08'),
(1072, 6, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1073, 7, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1074, 8, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1075, 9, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1076, 10, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1077, 11, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1078, 12, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1079, 13, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1080, 14, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1081, 15, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1082, 16, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1083, 17, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1084, 18, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1085, 19, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1086, 20, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1087, 21, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1088, 22, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1089, 23, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1090, 24, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1091, 25, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1092, 26, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1093, 27, '2025-05-22', 1, 0, '2025-05-22 08:31:48', '2025-05-22 08:31:48'),
(1111, 28, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1112, 29, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1113, 30, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1114, 31, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1115, 32, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1116, 33, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1117, 34, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1118, 35, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1119, 36, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1120, 37, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1121, 38, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1122, 39, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1123, 40, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1124, 41, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1125, 42, '2025-05-23', 0, 1, '2025-05-23 06:06:48', '2025-05-23 06:49:28'),
(1126, 43, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1127, 44, '2025-05-23', 1, 0, '2025-05-23 06:06:48', '2025-05-23 06:06:48'),
(1128, 6, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1129, 7, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1130, 8, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1131, 9, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1132, 10, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1133, 11, '2025-05-23', 0, 1, '2025-05-23 06:07:09', '2025-05-23 06:49:47'),
(1134, 12, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1135, 13, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1136, 14, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1137, 15, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1138, 16, '2025-05-23', 0, 1, '2025-05-23 06:07:09', '2025-05-23 06:49:47'),
(1139, 17, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1140, 18, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1141, 19, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1142, 20, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1143, 21, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1144, 22, '2025-05-23', 0, 1, '2025-05-23 06:07:09', '2025-05-23 06:46:38'),
(1145, 23, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1146, 24, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1147, 25, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1148, 26, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09'),
(1149, 27, '2025-05-23', 1, 0, '2025-05-23 06:07:09', '2025-05-23 06:07:09');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `produit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unite` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_maj` datetime NOT NULL,
  `seuil_alerte` int(11) DEFAULT '10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id`, `produit`, `quantite`, `prix_unitaire`, `unite`, `date_maj`, `seuil_alerte`, `created_at`, `updated_at`) VALUES
(151, 'carotte', 4, '20.00', 'kg', '2025-05-18 12:11:00', 10, '2025-05-18 10:11:00', '2025-05-18 10:11:00');

--
-- Déclencheurs `stocks`
--
DELIMITER $$
CREATE TRIGGER `after_stock_delete` AFTER DELETE ON `stocks` FOR EACH ROW BEGIN
    SET @annee = YEAR(NOW());
    SET @mois = MONTH(NOW());
    INSERT INTO valeurs_stock_mensuel (annee, mois, valeur_totale, date_calcul)
    SELECT @annee, @mois, COALESCE(SUM(prix_unitaire * quantite), 0), NOW()
    FROM stocks
    ON DUPLICATE KEY UPDATE 
    valeur_totale = VALUES(valeur_totale),
    date_calcul = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_stock_insert` AFTER INSERT ON `stocks` FOR EACH ROW BEGIN
    SET @annee = YEAR(NOW());
    SET @mois = MONTH(NOW());
    INSERT INTO valeurs_stock_mensuel (annee, mois, valeur_totale, date_calcul)
    SELECT @annee, @mois, COALESCE(SUM(prix_unitaire * quantite), 0), NOW()
    FROM stocks
    ON DUPLICATE KEY UPDATE 
    valeur_totale = VALUES(valeur_totale),
    date_calcul = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_stock_update` AFTER UPDATE ON `stocks` FOR EACH ROW BEGIN
    SET @annee = YEAR(NOW());
    SET @mois = MONTH(NOW());
    INSERT INTO valeurs_stock_mensuel (annee, mois, valeur_totale, date_calcul)
    SELECT @annee, @mois, COALESCE(SUM(prix_unitaire * quantite), 0), NOW()
    FROM stocks
    ON DUPLICATE KEY UPDATE 
    valeur_totale = VALUES(valeur_totale),
    date_calcul = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `nom`, `prenom`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$LdXE/pRyEZfKwaa3Qi/gzutck6qqg9DTlyyp04reIOqj9zD2BD09W', 'Guthoerl', 'Christophe', 'admin', '2025-05-01 07:32:32'),
(2, 'maire', '$2y$10$II4peGnXNuVBwsUqWWvf/ODqtfL3S.5emJzDzn54ClzAhUmKXM402', 'durand', 'paul', 'user', '2025-05-01 08:24:22');

-- --------------------------------------------------------

--
-- Structure de la table `valeurs_stock_mensuel`
--

CREATE TABLE `valeurs_stock_mensuel` (
  `id` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `mois` int(11) NOT NULL,
  `valeur_totale` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date_calcul` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `valeurs_stock_mensuel`
--

INSERT INTO `valeurs_stock_mensuel` (`id`, `annee`, `mois`, `valeur_totale`, `date_calcul`) VALUES
(597, 2025, 3, '0.00', '2025-03-31 23:59:59'),
(605, 2025, 4, '0.00', '2025-04-30 23:59:59'),
(658, 2025, 5, '80.00', '2025-05-31 23:59:59');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` int(11) NOT NULL,
  `nb_repas` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `date_vente` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id`, `nb_repas`, `prix_unitaire`, `date_vente`, `created_at`, `updated_at`) VALUES
(6, 38, '2.60', '2025-05-05 06:56:00', '2025-05-06 04:59:55', '2025-05-06 04:59:55'),
(7, 38, '2.60', '2025-05-06 07:01:00', '2025-05-06 05:02:03', '2025-05-06 05:02:03'),
(8, 30, '2.60', '2025-05-09 07:02:00', '2025-05-06 05:02:39', '2025-05-07 18:37:47'),
(9, 38, '2.60', '2025-05-12 14:03:00', '2025-05-10 12:03:17', '2025-05-13 07:40:09'),
(10, 39, '2.60', '2025-05-13 14:03:00', '2025-05-10 12:03:27', '2025-05-12 08:54:17'),
(11, 39, '2.60', '2025-05-15 14:03:00', '2025-05-10 12:03:38', '2025-05-12 08:54:26'),
(12, 38, '2.60', '2025-05-16 14:03:00', '2025-05-10 12:03:48', '2025-05-19 07:57:19'),
(13, 2, '5.00', '2025-05-15 10:54:00', '2025-05-12 08:54:52', '2025-05-13 09:51:52'),
(14, 435, '2.60', '2025-02-28 11:13:00', '2025-05-12 09:13:32', '2025-05-12 09:13:32'),
(15, 6, '5.00', '2025-02-28 11:13:00', '2025-05-12 09:13:57', '2025-05-12 09:13:57'),
(16, 515, '2.60', '2025-01-31 11:19:00', '2025-05-12 09:19:14', '2025-05-12 09:19:14'),
(17, 8, '5.00', '2025-01-31 11:19:00', '2025-05-12 09:19:29', '2025-05-12 09:19:29'),
(18, 477, '2.60', '2025-03-31 10:49:00', '2025-05-13 08:49:37', '2025-05-13 08:49:37'),
(19, 8, '5.00', '2025-03-31 10:50:00', '2025-05-13 08:50:23', '2025-05-13 08:50:23'),
(20, 415, '2.60', '2025-04-30 10:51:00', '2025-05-13 08:51:35', '2025-05-13 08:51:35'),
(21, 6, '5.00', '2025-04-30 10:51:00', '2025-05-13 08:51:51', '2025-05-13 08:51:51'),
(22, 1, '5.00', '2025-05-16 09:12:00', '2025-05-15 07:13:02', '2025-05-15 07:13:02'),
(23, 34, '2.60', '2025-05-19 10:23:00', '2025-05-16 08:23:28', '2025-05-19 07:57:27'),
(24, 1, '5.00', '2025-05-19 10:23:00', '2025-05-16 08:23:38', '2025-05-16 08:23:38'),
(25, 37, '2.60', '2025-05-20 10:23:00', '2025-05-16 08:23:53', '2025-05-20 08:23:14'),
(26, 38, '2.60', '2025-05-22 10:24:00', '2025-05-16 08:24:26', '2025-05-22 08:32:28'),
(27, 35, '2.60', '2025-05-23 19:17:00', '2025-05-19 17:25:11', '2025-05-23 06:49:55'),
(28, 2, '5.00', '2025-05-22 10:32:00', '2025-05-22 08:32:40', '2025-05-22 08:32:40'),
(29, 30, '2.60', '2025-05-26 11:26:00', '2025-05-23 09:26:19', '2025-05-24 17:14:15');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achats`
--
ALTER TABLE `achats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_commande_id` (`commande_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `haccp_documents`
--
ALTER TABLE `haccp_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Index pour la table `historique_stocks`
--
ALTER TABLE `historique_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_id` (`stock_id`);

--
-- Index pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`);

--
-- Index pour la table `menus_jours`
--
ALTER TABLE `menus_jours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `semaine_id` (`semaine_id`,`jour`);

--
-- Index pour la table `menus_semaines`
--
ALTER TABLE `menus_semaines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `presences`
--
ALTER TABLE `presences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_presence` (`personne_id`,`date_presence`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_produit` (`produit`),
  ADD KEY `idx_date_maj` (`date_maj`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `valeurs_stock_mensuel`
--
ALTER TABLE `valeurs_stock_mensuel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_mois_annee` (`annee`,`mois`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achats`
--
ALTER TABLE `achats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `haccp_documents`
--
ALTER TABLE `haccp_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historique_stocks`
--
ALTER TABLE `historique_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=428;

--
-- AUTO_INCREMENT pour la table `menus_jours`
--
ALTER TABLE `menus_jours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `menus_semaines`
--
ALTER TABLE `menus_semaines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `presences`
--
ALTER TABLE `presences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1150;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT pour la table `valeurs_stock_mensuel`
--
ALTER TABLE `valeurs_stock_mensuel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=659;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `haccp_documents`
--
ALTER TABLE `haccp_documents`
  ADD CONSTRAINT `haccp_documents_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `historique_stocks`
--
ALTER TABLE `historique_stocks`
  ADD CONSTRAINT `historique_stocks_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD CONSTRAINT `personnes_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `presences`
--
ALTER TABLE `presences`
  ADD CONSTRAINT `presences_ibfk_1` FOREIGN KEY (`personne_id`) REFERENCES `personnes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
