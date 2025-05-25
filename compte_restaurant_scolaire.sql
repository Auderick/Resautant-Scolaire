-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 17 mai 2025 à 17:54
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
-- Base de données : `compte_restaurant_scolaire`
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
(124, 'boulangerie', 'pain mois', '1.00', '1', '170.30', '170.30', '2025-04-30 10:22:00', '2025-05-16 08:22:51', '2025-05-16 08:22:51', NULL);

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
(20, 'Leclerc', '2025-05-14 12:15:40', '2025-05-19', NULL, 'envoyee', 'si pas de petits louis ne pas remplacer', '2025-05-14 10:15:40', '2025-05-14 10:23:17', 0);

-- --------------------------------------------------------

--
-- Structure de la table `historique_stocks`
--

CREATE TABLE `historique_stocks` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `date_mouvement` datetime NOT NULL,
  `quantite_avant` decimal(10,2) NOT NULL,
  `quantite_apres` decimal(10,2) NOT NULL,
  `type_mouvement` enum('entrée','sortie') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mois_operation` varchar(7) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (date_format(`date_mouvement`,'%Y-%m')) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique_stocks`
--

INSERT INTO `historique_stocks` (`id`, `stock_id`, `date_mouvement`, `quantite_avant`, `quantite_apres`, `type_mouvement`, `created_at`) VALUES
(230, 137, '2025-05-01 08:33:00', '0.00', '2.00', 'entrée', '2025-05-01 06:33:00'),
(231, 137, '2025-05-01 06:34:00', '2.00', '3.00', 'entrée', '2025-05-01 06:34:12'),
(232, 137, '2025-05-01 08:33:00', '3.00', '4.00', 'entrée', '2025-05-01 10:48:22'),
(233, 137, '2025-05-01 08:33:00', '4.00', '1.00', 'sortie', '2025-05-14 10:39:42'),
(234, 137, '2025-05-01 08:33:00', '1.00', '20.00', 'entrée', '2025-05-14 10:40:26');

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
(263, 20, 'Carottes', '3.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(264, 20, 'lait demi écrémé ', '6.00', 'L', NULL, 1, '5.5', NULL, NULL),
(265, 20, 'oeuf frais', '6.00', 'pièce', NULL, 1, '5.5', NULL, NULL),
(266, 20, 'farine eco', '1.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(267, 20, 'cumin', '1.00', 'pièce', NULL, 1, '5.5', NULL, NULL),
(268, 20, 'poivre moulu', '1.00', 'pièce', NULL, 1, '5.5', NULL, NULL),
(269, 20, 'lentilles blondes 500gr eco', '3.00', 'boîte', NULL, 1, '5.5', NULL, NULL),
(270, 20, 'pommes de terre ', '5.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(271, 20, 'beurre doux 500gr', '1.00', 'pièce', NULL, 1, '5.5', NULL, NULL),
(272, 20, 'champignons paris', '2.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(273, 20, 'crème fluide 30% lot de 3pièces', '2.00', 'unité', NULL, 1, '5.5', NULL, NULL),
(274, 20, 'huile tournesol', '1.00', 'L', NULL, 1, '5.5', NULL, NULL),
(275, 20, 'poireaux', '5.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(276, 20, 'vin blanc cuisine cubi 3l', '1.00', 'pièce', NULL, 1, '20.0', NULL, NULL),
(277, 20, 'bleu 31% 250gr les croisés', '4.00', 'pièce', NULL, 1, '5.5', NULL, NULL),
(278, 20, 'petits louis sachet', '3.00', 'sachet', NULL, 1, '5.5', NULL, NULL),
(279, 20, 'saint moret portion', '36.00', 'unité', NULL, 1, '5.5', NULL, NULL),
(280, 20, 'yaourt nature', '36.00', 'unité', NULL, 1, '5.5', NULL, NULL),
(281, 20, 'fromage blanc', '36.00', 'unité', NULL, 1, '5.5', NULL, NULL),
(282, 20, 'riz indica', '1.50', 'kg', NULL, 1, '5.5', NULL, NULL),
(283, 20, 'banane petit calibre', '4.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(284, 20, 'semoule moyenne couscous', '0.50', 'kg', NULL, 1, '5.5', NULL, NULL),
(285, 20, 'tomate grappe', '2.00', 'kg', NULL, 1, '5.5', NULL, NULL),
(286, 20, 'batavia', '2.00', 'pièce', NULL, 1, '5.5', NULL, NULL),
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
(325, 19, 'Echalotes cubes 0.250kg Réf. 00825', '1.00', '', '2.93', 0, '5.5', '2.93', '3.09');

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
(12, 4, 'lundi', 'Salade verte parisienne (jambon, emmental)', 'Rougail de saucisse', 'Pâtes Ratatouille', 'Fromage ou Yaourt', 'Fruit de saison', '{\"entree\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"plat\":{\"options\":[],\"allergenes\":[]},\"accompagnement\":{\"options\":[\"allergenes\"],\"allergenes\":[\"gluten\"]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"local\",\"bio\"],\"allergenes\":[]}}'),
(13, 4, 'mardi', 'Duo de saucissons', 'Jambon grill sauce porto', 'Purée de pommes de terre Céleri poêlé', 'Fromage ou yaourt', 'Gâteau', '{\"entree\":{\"options\":[],\"allergenes\":[]},\"plat\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"accompagnement\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\",\"celeri\"]},\"laitage\":{\"options\":[\"allergenes\"],\"allergenes\":[\"lait\"]},\"dessert\":{\"options\":[\"allergenes\",\"local\",\"bio\"],\"allergenes\":[\"lait\",\"oeufs\",\"gluten\"]}}');

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
(3, 21, 2025, '2025-05-19', '2025-05-23', 1, '2025-05-07 10:29:46'),
(4, 22, 2025, '2025-05-26', '2025-05-30', 0, '2025-05-11 10:50:34');

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
(137, 'tututurlkj', 20, '2.00', 'kg', '2025-05-01 08:33:00', 10, '2025-05-01 06:33:00', '2025-05-14 10:40:26');

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
-- Structure de la table `haccp_documents`
--

CREATE TABLE `haccp_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `haccp_documents_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Triggers de la table `stocks`
--

DELIMITER //

CREATE TRIGGER after_stock_insert 
AFTER INSERT ON stocks
FOR EACH ROW
BEGIN
    SET @annee = YEAR(NOW());
    SET @mois = MONTH(NOW());
    INSERT INTO valeurs_stock_mensuel (annee, mois, valeur_totale, date_calcul)
    SELECT @annee, @mois, COALESCE(SUM(prix_unitaire * quantite), 0), NOW()
    FROM stocks
    ON DUPLICATE KEY UPDATE 
    valeur_totale = VALUES(valeur_totale),
    date_calcul = NOW();
END //

CREATE TRIGGER after_stock_update 
AFTER UPDATE ON stocks
FOR EACH ROW
BEGIN
    SET @annee = YEAR(NOW());
    SET @mois = MONTH(NOW());
    INSERT INTO valeurs_stock_mensuel (annee, mois, valeur_totale, date_calcul)
    SELECT @annee, @mois, COALESCE(SUM(prix_unitaire * quantite), 0), NOW()
    FROM stocks
    ON DUPLICATE KEY UPDATE 
    valeur_totale = VALUES(valeur_totale),
    date_calcul = NOW();
END //

CREATE TRIGGER after_stock_delete 
AFTER DELETE ON stocks
FOR EACH ROW
BEGIN
    SET @annee = YEAR(NOW());
    SET @mois = MONTH(NOW());
    INSERT INTO valeurs_stock_mensuel (annee, mois, valeur_totale, date_calcul)
    SELECT @annee, @mois, COALESCE(SUM(prix_unitaire * quantite), 0), NOW()
    FROM stocks
    ON DUPLICATE KEY UPDATE 
    valeur_totale = VALUES(valeur_totale),
    date_calcul = NOW();
END //

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `valeurs_stock_mensuel`
--

INSERT INTO `valeurs_stock_mensuel` (`id`, `annee`, `mois`, `valeur_totale`, `date_calcul`) VALUES
(597, 2025, 3, '0.00', '2025-03-31 23:59:59'),
(605, 2025, 4, '0.00', '2025-04-30 23:59:59'),
(609, 2025, 5, '40.00', '2025-05-31 23:59:59');

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
(12, 38, '2.60', '2025-05-16 14:03:00', '2025-05-10 12:03:48', '2025-05-15 07:13:16'),
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
(23, 38, '2.60', '2025-05-19 10:23:00', '2025-05-16 08:23:28', '2025-05-16 08:23:28'),
(24, 1, '5.00', '2025-05-19 10:23:00', '2025-05-16 08:23:38', '2025-05-16 08:23:38'),
(25, 39, '2.60', '2025-05-20 10:23:00', '2025-05-16 08:23:53', '2025-05-16 08:23:53'),
(26, 39, '2.60', '2025-05-22 10:24:00', '2025-05-16 08:24:26', '2025-05-16 08:24:26');

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
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `historique_stocks`
--
ALTER TABLE `historique_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_date_mouvement` (`date_mouvement`),
  ADD KEY `idx_stock_id` (`stock_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `historique_stocks`
--
ALTER TABLE `historique_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

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
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `valeurs_stock_mensuel`
--
ALTER TABLE `valeurs_stock_mensuel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=610;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achats`
--
ALTER TABLE `achats`
  ADD CONSTRAINT `fk_achat_commande` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`);

--
-- Contraintes pour la table `historique_stocks`
--
ALTER TABLE `historique_stocks`
  ADD CONSTRAINT `historique_stocks_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
  ADD CONSTRAINT `lignes_commande_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `menus_jours`
--
ALTER TABLE `menus_jours`
  ADD CONSTRAINT `menus_jours_ibfk_1` FOREIGN KEY (`semaine_id`) REFERENCES `menus_semaines` (`id`) ON DELETE CASCADE;

--
-- Mise à jour des charsets des tables
--

ALTER TABLE `commandes` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `historique_stocks` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `lignes_commande` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `menus_jours` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `menus_semaines` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `stocks` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `utilisateurs` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `valeurs_stock_mensuel` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `ventes` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
