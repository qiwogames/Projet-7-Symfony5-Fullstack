-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 13 avr. 2021 à 13:36
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `olfp_sf5`
--

-- --------------------------------------------------------

--
-- Structure de la table `distributeur`
--

DROP TABLE IF EXISTS `distributeur`;
CREATE TABLE IF NOT EXISTS `distributeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_distributeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `distributeur`
--

INSERT INTO `distributeur` (`id`, `nom_distributeur`) VALUES
(1, 'Auchan'),
(2, 'Amazon'),
(3, 'AliBaba'),
(4, 'Carrefour'),
(5, 'Casino'),
(6, 'Fnac'),
(7, 'Cdiscount'),
(8, 'La vie claire'),
(9, 'Leclerc'),
(10, 'LIDL'),
(14, 'Boulanger'),
(15, 'Gémo');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210408095057', '2021-04-08 09:51:23', 244),
('DoctrineMigrations\\Version20210409083438', '2021-04-09 08:34:48', 107),
('DoctrineMigrations\\Version20210409101145', '2021-04-09 10:11:51', 48),
('DoctrineMigrations\\Version20210409102445', '2021-04-09 10:25:17', 208),
('DoctrineMigrations\\Version20210409105326', '2021-04-09 10:53:44', 52),
('DoctrineMigrations\\Version20210409110044', '2021-04-09 11:00:52', 181),
('DoctrineMigrations\\Version20210413090130', '2021-04-13 09:01:58', 142);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_produit` double NOT NULL,
  `quantite_produit` int(11) NOT NULL,
  `rupture` tinyint(1) NOT NULL,
  `photo_produit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_29A5EC271645DEA9` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom_produit`, `prix_produit`, `quantite_produit`, `rupture`, `photo_produit`, `reference_id`) VALUES
(41, 'Imprimantes Canon', 700.25, 15, 1, 'imp.jpg', 30),
(42, 'Mario Bros', 80.55, 11, 0, 'mario.jpg', 31),
(43, 'I-phone 5', 1200.75, 5, 1, 'phone.jpg', 32),
(45, 'Souris Logitech', 20.25, 7, 1, 'souris.jpg', 34),
(50, 'Velo fille', 50.25, 4, 0, 'velo.jpg', 35),
(51, 'Casque Moto', 120.35, 25, 0, 'casque.jpg', 36),
(52, 'Gallerie Camion', 700.25, 65, 0, 'cam.jpg', 37),
(53, 'Logiciel Reason', 122.25, 6, 1, 'reason2.jpg', 40),
(54, 'Cubase 11', 500.25, 20, 1, 'cubase.png', 39),
(55, 'yoyo high tech', 25.35, 150, 1, 'yoyo.webp', 38),
(57, 'Vase', 412.25, 60, 1, 'vase.jpg', 41),
(58, 'Passoire en fer', 141.25, 68, 1, 'passoire.jfif', 42),
(60, 'Table à repasser', 250.35, 40, 1, 'tablerepase.jpg', 45),
(61, 'Balancoire', 122.25, 20, 1, 'val.jfif', 50),
(62, 'Stylo plume', 15.25, 250, 1, 'bic.jpg', 51);

-- --------------------------------------------------------

--
-- Structure de la table `produit_distributeur`
--

DROP TABLE IF EXISTS `produit_distributeur`;
CREATE TABLE IF NOT EXISTS `produit_distributeur` (
  `produit_id` int(11) NOT NULL,
  `distributeur_id` int(11) NOT NULL,
  PRIMARY KEY (`produit_id`,`distributeur_id`),
  KEY `IDX_E3D5370CF347EFB` (`produit_id`),
  KEY `IDX_E3D5370C29EB7ACA` (`distributeur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit_distributeur`
--

INSERT INTO `produit_distributeur` (`produit_id`, `distributeur_id`) VALUES
(61, 1),
(62, 14);

-- --------------------------------------------------------

--
-- Structure de la table `reference`
--

DROP TABLE IF EXISTS `reference`;
CREATE TABLE IF NOT EXISTS `reference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reference`
--

INSERT INTO `reference` (`id`, `numero`) VALUES
(21, 460750134),
(22, 121580743),
(23, 1640732011),
(24, 853589584),
(25, 45055329),
(26, 7458548),
(27, 8451254),
(28, 7448574),
(29, 9966),
(30, 132571272),
(31, 1691141367),
(32, 306460886),
(33, 476279422),
(34, 793055052),
(35, 665948071),
(36, 635834082),
(37, 484880691),
(38, 414),
(39, 74512),
(40, 7485896),
(41, 4145),
(42, 41478),
(44, 414),
(45, 74142),
(50, 41474),
(51, 414858);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(2, 'utilisateur@gmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$bUZxM25EU1A1TzMzWjNJbA$AkKu0ca/lyIFuBMQnKlFIQCS6jl/nB10eAFRrPqjHPE'),
(3, 'admin@admin.fr', '[\"ROLE_ADMIN\", \"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$NmN2STJ4ZFZjYnVGTTZSWA$G6I75qztnxEvhnfGyC5OSQPzC2GSIn69GUmj7rhQ5/8'),
(4, 'superadmin@super.com', '[\"ROLE_SUPER_ADMIN\", \"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$RUZVZlBrYnVxVFJrWkcwNw$U01j0UuCLaPxzxhtb0p7/arh6/JOGK2FmykLT3qnXgg');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC271645DEA9` FOREIGN KEY (`reference_id`) REFERENCES `reference` (`id`);

--
-- Contraintes pour la table `produit_distributeur`
--
ALTER TABLE `produit_distributeur`
  ADD CONSTRAINT `FK_E3D5370C29EB7ACA` FOREIGN KEY (`distributeur_id`) REFERENCES `distributeur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E3D5370CF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
