-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 18 Mai 2016 à 00:39
-- Version du serveur :  10.0.23-MariaDB-0+deb8u1-log
-- Version de PHP :  5.6.20-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `flux`
--

-- --------------------------------------------------------

--
-- Structure de la table `archive_prob`
--

CREATE TABLE IF NOT EXISTS `archive_prob` (
`id` int(11) NOT NULL,
  `id_liste_prob` int(100) NOT NULL,
  `id_type_prob` int(3) NOT NULL,
  `id_espace` int(3) NOT NULL,
  `heure` datetime NOT NULL,
  `gravite` int(1) NOT NULL COMMENT 'Gravité de la situation : OK = 0; moyen = 1; grave = 2.',
  `acteur` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'Personne en charge du problème'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='Problèmes rencontrés';

--
-- Contenu de la table `archive_prob`
--

INSERT INTO `archive_prob` (`id`, `id_liste_prob`, `id_type_prob`, `id_espace`, `heure`, `gravite`, `acteur`) VALUES
(7, 21, 1, 3, '2016-05-16 00:36:08', 1, NULL),
(8, 21, 1, 3, '2016-05-16 01:49:15', 2, NULL),
(9, 21, 1, 3, '2016-05-16 01:49:20', 0, NULL),
(10, 21, 1, 3, '2016-05-16 01:49:21', 1, NULL),
(11, 22, 2, 3, '2016-05-16 01:53:21', 1, NULL),
(12, 22, 2, 3, '2016-05-16 01:53:23', 0, NULL),
(13, 123, 14, 3, '2016-05-16 02:45:23', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `cat_prob`
--

CREATE TABLE IF NOT EXISTS `cat_prob` (
`id` int(3) NOT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nom des catégories de problèmes';

--
-- Contenu de la table `cat_prob`
--

INSERT INTO `cat_prob` (`id`, `nom`) VALUES
(0, 'Manques AUTO'),
(1, 'Manques'),
(2, 'Techniques'),
(3, 'Santé'),
(4, 'Sécurité'),
(5, 'Délestage');

-- --------------------------------------------------------

--
-- Structure de la table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
`id` int(3) NOT NULL,
  `id_expediteur` int(3) NOT NULL,
  `id_destinataire` int(3) DEFAULT NULL,
  `id_droit` int(3) DEFAULT NULL COMMENT 'on peut aussi parler à tout un droit :)',
  `date` datetime NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `chat`
--

INSERT INTO `chat` (`id`, `id_expediteur`, `id_destinataire`, `id_droit`, `date`, `message`) VALUES
(1, 2, NULL, NULL, '2016-05-16 02:45:39', 'Hello depuis l''UNG !'),
(2, 1, 2, NULL, '2016-05-16 02:46:04', 'Hello l''UNG (seulement)'),
(4, 1, NULL, 1, '2016-05-16 02:47:03', 'Hello les admins'),
(5, 1, NULL, 2, '2016-05-16 02:47:09', 'Hello général !'),
(6, 1, NULL, 3, '2016-05-18 00:39:16', 'Bonjour les vendeurs d''UTs !');

-- --------------------------------------------------------

--
-- Structure de la table `delestage`
--

CREATE TABLE IF NOT EXISTS `delestage` (
`id` int(3) NOT NULL,
  `id_espace` int(3) NOT NULL,
  `somme` int(11) NOT NULL,
  `heure` datetime NOT NULL,
  `id_utilisateur` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Info Délestage des EAT et des Ventes UT';

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE IF NOT EXISTS `droit` (
`id` int(3) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT 'Admin = 1; Espace = 0',
  `liste` tinyint(1) NOT NULL COMMENT '1 = liste de discussion en +'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Info Droit';

--
-- Contenu de la table `droit`
--

INSERT INTO `droit` (`id`, `nom`, `type`, `liste`) VALUES
(1, 'Admin', 1, 1),
(2, 'Bar', 0, 1),
(3, 'Jeton', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `espace`
--

CREATE TABLE IF NOT EXISTS `espace` (
`id` int(3) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `id_type_espace` int(1) NOT NULL,
  `id_utilisateur` int(3) NOT NULL,
  `etat` tinyint(1) NOT NULL COMMENT '1 = ouvert ; 0 = fermé'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Info Espace';

--
-- Contenu de la table `espace`
--

INSERT INTO `espace` (`id`, `nom`, `lieu`, `id_type_espace`, `id_utilisateur`, `etat`) VALUES
(1, 'Marine/Interlink', 'Chapiteau', 1, 10, 1),
(2, 'ISM', 'Amphi ext', 1, 11, 1),
(3, 'UNG', 'Hall N', 1, 2, 1),
(4, 'RUTT', 'C105', 1, 12, 1),
(5, 'EPF', 'B101', 1, 13, 1),
(6, 'PMOM', 'B106', 1, 14, 1),
(7, 'Falutt', 'C104', 1, 15, 1),
(8, 'Amical/ASANUTT', 'M104', 1, 16, 1),
(9, 'Revivre', 'A002', 1, 17, 1),
(10, 'Puls/C-Biere', 'B105', 1, 18, 1),
(11, 'MACC', 'C102', 1, 19, 1),
(12, 'Jeton Etu', 'Hall Etu', 3, 25, 1),
(13, 'Jeton Entrée', 'Entrée', 3, 26, 1),
(14, 'Jeton Accueil', 'Accueil', 3, 24, 1);

-- --------------------------------------------------------

--
-- Structure de la table `liste_droit`
--

CREATE TABLE IF NOT EXISTS `liste_droit` (
`id` int(3) NOT NULL,
  `id_utilisateur` int(3) NOT NULL,
  `id_droit` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='droit par utilisateur';

--
-- Contenu de la table `liste_droit`
--

INSERT INTO `liste_droit` (`id`, `id_utilisateur`, `id_droit`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 16, 2),
(4, 13, 2),
(5, 15, 2),
(6, 10, 2),
(7, 11, 2),
(8, 19, 2),
(9, 14, 2),
(10, 18, 2),
(11, 17, 2),
(12, 12, 2),
(13, 21, 1),
(14, 23, 1),
(15, 22, 1),
(16, 26, 3),
(17, 24, 3),
(18, 25, 3);

-- --------------------------------------------------------

--
-- Structure de la table `liste_prob`
--

CREATE TABLE IF NOT EXISTS `liste_prob` (
`id` int(100) NOT NULL,
  `id_type_prob` int(3) NOT NULL,
  `id_espace` int(3) NOT NULL,
  `gravite` int(1) NOT NULL COMMENT 'Gravité de la situation : OK = 0; moyen = 1; grave = 2.',
  `auteur` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'Personne en charge du problème'
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 COMMENT='Problèmes en cours';

--
-- Contenu de la table `liste_prob`
--

INSERT INTO `liste_prob` (`id`, `id_type_prob`, `id_espace`, `gravite`, `auteur`) VALUES
(1, 1, 1, 0, NULL),
(2, 2, 1, 0, NULL),
(3, 3, 1, 0, NULL),
(4, 4, 1, 0, NULL),
(5, 6, 1, 0, NULL),
(6, 7, 1, 0, NULL),
(7, 8, 1, 0, NULL),
(8, 9, 1, 0, NULL),
(9, 10, 1, 0, NULL),
(10, 11, 1, 0, NULL),
(11, 1, 2, 0, NULL),
(12, 2, 2, 0, NULL),
(13, 3, 2, 0, NULL),
(14, 4, 2, 0, NULL),
(15, 6, 2, 0, NULL),
(16, 7, 2, 0, NULL),
(17, 8, 2, 0, NULL),
(18, 9, 2, 0, NULL),
(19, 10, 2, 0, NULL),
(20, 11, 2, 0, NULL),
(21, 1, 3, 1, NULL),
(22, 2, 3, 0, NULL),
(23, 3, 3, 0, NULL),
(24, 4, 3, 0, NULL),
(25, 6, 3, 0, NULL),
(26, 7, 3, 0, NULL),
(27, 8, 3, 0, NULL),
(28, 9, 3, 0, NULL),
(29, 10, 3, 0, NULL),
(30, 11, 3, 0, NULL),
(31, 1, 4, 0, NULL),
(32, 2, 4, 0, NULL),
(33, 3, 4, 0, NULL),
(34, 4, 4, 0, NULL),
(35, 6, 4, 0, NULL),
(36, 7, 4, 0, NULL),
(37, 8, 4, 0, NULL),
(38, 9, 4, 0, NULL),
(39, 10, 4, 0, NULL),
(40, 11, 4, 0, NULL),
(41, 1, 5, 0, NULL),
(42, 2, 5, 0, NULL),
(43, 3, 5, 0, NULL),
(44, 4, 5, 0, NULL),
(45, 6, 5, 0, NULL),
(46, 7, 5, 0, NULL),
(47, 8, 5, 0, NULL),
(48, 9, 5, 0, NULL),
(49, 10, 5, 0, NULL),
(50, 11, 5, 0, NULL),
(51, 1, 6, 0, NULL),
(52, 2, 6, 0, NULL),
(53, 3, 6, 0, NULL),
(54, 4, 6, 0, NULL),
(55, 6, 6, 0, NULL),
(56, 7, 6, 0, NULL),
(57, 8, 6, 0, NULL),
(58, 9, 6, 0, NULL),
(59, 10, 6, 0, NULL),
(60, 11, 6, 0, NULL),
(61, 1, 7, 0, NULL),
(62, 2, 7, 0, NULL),
(63, 3, 7, 0, NULL),
(64, 4, 7, 0, NULL),
(65, 6, 7, 0, NULL),
(66, 7, 7, 0, NULL),
(67, 8, 7, 0, NULL),
(68, 9, 7, 0, NULL),
(69, 10, 7, 0, NULL),
(70, 11, 7, 0, NULL),
(71, 1, 8, 0, NULL),
(72, 2, 8, 0, NULL),
(73, 3, 8, 0, NULL),
(74, 4, 8, 0, NULL),
(75, 6, 8, 0, NULL),
(76, 7, 8, 0, NULL),
(77, 8, 8, 0, NULL),
(78, 9, 8, 0, NULL),
(79, 10, 8, 0, NULL),
(80, 11, 8, 0, NULL),
(81, 1, 9, 0, NULL),
(82, 2, 9, 0, NULL),
(83, 3, 9, 0, NULL),
(84, 4, 9, 0, NULL),
(85, 6, 9, 0, NULL),
(86, 7, 9, 0, NULL),
(87, 8, 9, 0, NULL),
(88, 9, 9, 0, NULL),
(89, 10, 9, 0, NULL),
(90, 11, 9, 0, NULL),
(91, 1, 10, 0, NULL),
(92, 2, 10, 0, NULL),
(93, 3, 10, 0, NULL),
(94, 4, 10, 0, NULL),
(95, 6, 10, 0, NULL),
(96, 7, 10, 0, NULL),
(97, 8, 10, 0, NULL),
(98, 9, 10, 0, NULL),
(99, 10, 10, 0, NULL),
(100, 11, 10, 0, NULL),
(101, 1, 11, 0, NULL),
(102, 2, 11, 0, NULL),
(103, 3, 11, 0, NULL),
(104, 4, 11, 0, NULL),
(105, 6, 11, 0, NULL),
(106, 7, 11, 0, NULL),
(107, 8, 11, 0, NULL),
(108, 9, 11, 0, NULL),
(109, 10, 11, 0, NULL),
(110, 11, 11, 0, NULL),
(112, 13, 1, 0, NULL),
(113, 13, 2, 0, NULL),
(114, 13, 3, 0, NULL),
(115, 13, 4, 0, NULL),
(116, 13, 5, 0, NULL),
(117, 13, 6, 0, NULL),
(118, 13, 7, 0, NULL),
(119, 13, 8, 0, NULL),
(120, 13, 9, 0, NULL),
(121, 13, 10, 0, NULL),
(122, 13, 11, 0, NULL),
(123, 14, 3, 1, NULL),
(124, 1, 12, 0, NULL),
(125, 2, 12, 0, NULL),
(126, 3, 12, 0, NULL),
(127, 4, 12, 0, NULL),
(128, 6, 12, 0, NULL),
(129, 7, 12, 0, NULL),
(130, 8, 12, 0, NULL),
(131, 9, 12, 0, NULL),
(132, 10, 12, 0, NULL),
(133, 11, 12, 0, NULL),
(134, 13, 12, 0, NULL),
(135, 1, 13, 0, NULL),
(136, 2, 13, 0, NULL),
(137, 3, 13, 0, NULL),
(138, 4, 13, 0, NULL),
(139, 6, 13, 0, NULL),
(140, 7, 13, 0, NULL),
(141, 8, 13, 0, NULL),
(142, 9, 13, 0, NULL),
(143, 10, 13, 0, NULL),
(144, 11, 13, 0, NULL),
(145, 13, 13, 0, NULL),
(146, 1, 14, 0, NULL),
(147, 2, 14, 0, NULL),
(148, 3, 14, 0, NULL),
(149, 4, 14, 0, NULL),
(150, 6, 14, 0, NULL),
(151, 7, 14, 0, NULL),
(152, 8, 14, 0, NULL),
(153, 9, 14, 0, NULL),
(154, 10, 14, 0, NULL),
(155, 11, 14, 0, NULL),
(156, 13, 14, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE IF NOT EXISTS `parcours` (
`id` int(3) NOT NULL,
  `id_stock` int(3) NOT NULL,
  `id_espace` int(3) NOT NULL,
  `debut` datetime NOT NULL COMMENT 'Heure d''arrivée du produit dans l''espace',
  `fin` datetime NOT NULL COMMENT 'Heure de départ du produit dans l''espace',
  `quantite_debut` varchar(100) NOT NULL COMMENT 'Quantité à l''arrivée du produit dans l''espace'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Info sur le parcours d''un produit';

--
-- Contenu de la table `parcours`
--

INSERT INTO `parcours` (`id`, `id_stock`, `id_espace`, `debut`, `fin`, `quantite_debut`) VALUES
(5, 202, 3, '2016-05-16 01:35:44', '0000-00-00 00:00:00', ''),
(6, 203, 3, '2016-05-16 01:35:44', '0000-00-00 00:00:00', ''),
(7, 204, 3, '2016-05-16 01:35:44', '0000-00-00 00:00:00', ''),
(8, 205, 3, '2016-05-16 01:35:44', '0000-00-00 00:00:00', ''),
(9, 206, 3, '2016-05-16 01:35:44', '0000-00-00 00:00:00', ''),
(10, 207, 3, '2016-05-16 01:35:45', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
`id` int(3) NOT NULL,
  `id_type_stock` int(3) NOT NULL,
  `identifiant` varchar(10) NOT NULL COMMENT 'La référence du stock plus un numéro',
  `entame` datetime NOT NULL COMMENT 'heure à laquelle on entame un produit',
  `fin` datetime NOT NULL COMMENT 'heure à laquel il est finit',
  `reste` varchar(100) NOT NULL COMMENT 'ce qu''il reste à la fermeture d''un espace'
) ENGINE=InnoDB AUTO_INCREMENT=402 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `stock`
--

INSERT INTO `stock` (`id`, `id_type_stock`, `identifiant`, `entame`, `fin`, `reste`) VALUES
(202, 3, 'CHO01', '2016-05-16 02:45:15', '2016-05-16 02:45:16', ''),
(203, 3, 'CHO02', '2016-05-16 02:45:19', '2016-05-16 02:45:20', ''),
(204, 3, 'CHO03', '2016-05-16 02:45:17', '2016-05-16 02:45:21', ''),
(205, 3, 'CHO04', '2016-05-16 02:45:22', '2016-05-16 02:45:22', ''),
(206, 3, 'CHO05', '2016-05-16 02:45:23', '0000-00-00 00:00:00', ''),
(207, 3, 'CHO06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(208, 3, 'CHO07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(209, 3, 'CHO08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(210, 3, 'CHO09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(211, 3, 'CHO10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(212, 3, 'CHO11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(213, 3, 'CHO12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(214, 3, 'CHO13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(215, 3, 'CHO14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(216, 3, 'CHO15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(217, 3, 'CHO16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(218, 3, 'CHO17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(219, 3, 'CHO18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(220, 3, 'CHO19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(221, 3, 'CHO20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(222, 3, 'CHO21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(223, 3, 'CHO22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(224, 3, 'CHO23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(225, 3, 'CHO24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(226, 3, 'CHO25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(227, 3, 'CHO26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(228, 3, 'CHO27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(229, 3, 'CHO28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(230, 3, 'CHO29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(231, 3, 'CHO30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(232, 3, 'CHO31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(233, 3, 'CHO32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(234, 3, 'CHO33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(235, 3, 'CHO34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(236, 3, 'CHO35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(237, 3, 'CHO36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(238, 3, 'CHO37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(239, 3, 'CHO38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(240, 3, 'CHO39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(241, 3, 'CHO40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(242, 3, 'CHO41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(243, 3, 'CHO42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(244, 3, 'CHO43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(245, 3, 'CHO44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(246, 3, 'CHO45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(247, 3, 'CHO46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(248, 3, 'CHO47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(249, 3, 'CHO48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(250, 3, 'CHO49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(251, 3, 'CHO50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(252, 3, 'CHO51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(253, 3, 'CHO52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(254, 3, 'CHO53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(255, 3, 'CHO54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(256, 3, 'CHO55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(257, 3, 'CHO56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(258, 3, 'CHO57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(259, 3, 'CHO58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(260, 3, 'CHO59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(261, 3, 'CHO60', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(262, 3, 'CHO61', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(263, 3, 'CHO62', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(264, 3, 'CHO63', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(265, 3, 'CHO64', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(266, 3, 'CHO65', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(267, 3, 'CHO66', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(268, 3, 'CHO67', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(269, 3, 'CHO68', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(270, 3, 'CHO69', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(271, 3, 'CHO70', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(272, 3, 'CHO71', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(273, 3, 'CHO72', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(274, 3, 'CHO73', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(275, 3, 'CHO74', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(276, 3, 'CHO75', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(277, 3, 'CHO76', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(278, 3, 'CHO77', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(279, 3, 'CHO78', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(280, 3, 'CHO79', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(281, 3, 'CHO80', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(282, 3, 'CHO81', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(283, 3, 'CHO82', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(284, 3, 'CHO83', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(285, 3, 'CHO84', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(286, 3, 'CHO85', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(287, 3, 'CHO86', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(288, 3, 'CHO87', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(289, 3, 'CHO88', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(290, 3, 'CHO89', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(291, 3, 'CHO90', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(292, 3, 'CHO91', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(293, 3, 'CHO92', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(294, 3, 'CHO93', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(295, 3, 'CHO94', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(296, 3, 'CHO95', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(297, 3, 'CHO96', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(298, 3, 'CHO97', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(299, 3, 'CHO98', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(300, 3, 'CHO99', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(301, 3, 'CHO100', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(302, 3, 'CHO101', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(303, 3, 'CHO102', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(304, 3, 'CHO103', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(305, 3, 'CHO104', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(306, 3, 'CHO105', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(307, 3, 'CHO106', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(308, 3, 'CHO107', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(309, 3, 'CHO108', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(310, 3, 'CHO109', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(311, 3, 'CHO110', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(312, 3, 'CHO111', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(313, 3, 'CHO112', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(314, 3, 'CHO113', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(315, 3, 'CHO114', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(316, 3, 'CHO115', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(317, 3, 'CHO116', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(318, 3, 'CHO117', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(319, 3, 'CHO118', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(320, 3, 'CHO119', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(321, 3, 'CHO120', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(322, 3, 'CHO121', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(323, 3, 'CHO122', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(324, 3, 'CHO123', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(325, 3, 'CHO124', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(326, 3, 'CHO125', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(327, 3, 'CHO126', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(328, 3, 'CHO127', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(329, 3, 'CHO128', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(330, 3, 'CHO129', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(331, 3, 'CHO130', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(332, 3, 'CHO131', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(333, 3, 'CHO132', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(334, 3, 'CHO133', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(335, 3, 'CHO134', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(336, 3, 'CHO135', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(337, 3, 'CHO136', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(338, 3, 'CHO137', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(339, 3, 'CHO138', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(340, 3, 'CHO139', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(341, 3, 'CHO140', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(342, 3, 'CHO141', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(343, 3, 'CHO142', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(344, 3, 'CHO143', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(345, 3, 'CHO144', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(346, 3, 'CHO145', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(347, 3, 'CHO146', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(348, 3, 'CHO147', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(349, 3, 'CHO148', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(350, 3, 'CHO149', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(351, 3, 'CHO150', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(352, 3, 'CHO151', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(353, 3, 'CHO152', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(354, 3, 'CHO153', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(355, 3, 'CHO154', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(356, 3, 'CHO155', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(357, 3, 'CHO156', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(358, 3, 'CHO157', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(359, 3, 'CHO158', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(360, 3, 'CHO159', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(361, 3, 'CHO160', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(362, 3, 'CHO161', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(363, 3, 'CHO162', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(364, 3, 'CHO163', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(365, 3, 'CHO164', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(366, 3, 'CHO165', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(367, 3, 'CHO166', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(368, 3, 'CHO167', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(369, 3, 'CHO168', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(370, 3, 'CHO169', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(371, 3, 'CHO170', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(372, 3, 'CHO171', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(373, 3, 'CHO172', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(374, 3, 'CHO173', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(375, 3, 'CHO174', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(376, 3, 'CHO175', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(377, 3, 'CHO176', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(378, 3, 'CHO177', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(379, 3, 'CHO178', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(380, 3, 'CHO179', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(381, 3, 'CHO180', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(382, 3, 'CHO181', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(383, 3, 'CHO182', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(384, 3, 'CHO183', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(385, 3, 'CHO184', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(386, 3, 'CHO185', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(387, 3, 'CHO186', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(388, 3, 'CHO187', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(389, 3, 'CHO188', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(390, 3, 'CHO189', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(391, 3, 'CHO190', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(392, 3, 'CHO191', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(393, 3, 'CHO192', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(394, 3, 'CHO193', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(395, 3, 'CHO194', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(396, 3, 'CHO195', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(397, 3, 'CHO196', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(398, 3, 'CHO197', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(399, 3, 'CHO198', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(400, 3, 'CHO199', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(401, 3, 'CHO200', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Structure de la table `type_espace`
--

CREATE TABLE IF NOT EXISTS `type_espace` (
`id` int(1) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Type d''espaces possible';

--
-- Contenu de la table `type_espace`
--

INSERT INTO `type_espace` (`id`, `nom`) VALUES
(1, 'Espace à thème'),
(2, 'SecUTT'),
(3, 'Point de Vente UT');

-- --------------------------------------------------------

--
-- Structure de la table `type_prob`
--

CREATE TABLE IF NOT EXISTS `type_prob` (
`id` int(3) NOT NULL,
  `id_cat_prob` int(3) NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lien` int(3) NOT NULL COMMENT 'id_type_stock ou 0 si pas de lien'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Type de problème possible';

--
-- Contenu de la table `type_prob`
--

INSERT INTO `type_prob` (`id`, `id_cat_prob`, `nom`, `lien`) VALUES
(1, 1, 'Gobelets softs', 0),
(2, 1, 'Gobelets bières', 0),
(3, 1, 'Ingrédients cocktail', 0),
(4, 1, 'Sacs Poubelles', 0),
(6, 2, 'Au niveau d''un fût', 0),
(7, 2, 'Au niveau de la tireuse', 0),
(8, 2, 'Son ou Lumière', 0),
(9, 2, 'Au niveau électricité', 0),
(10, 4, 'Alerte sécurité', 0),
(11, 3, 'Alerte santé', 0),
(13, 5, 'Demande délestage', 0),
(14, 0, 'Chouffe', 3);

-- --------------------------------------------------------

--
-- Structure de la table `type_stock`
--

CREATE TABLE IF NOT EXISTS `type_stock` (
`id` int(3) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `reference` varchar(15) NOT NULL,
  `conditionnement` varchar(100) NOT NULL COMMENT 'Carton de 6 bouteilles; Fut de Fisher....',
  `volume` int(4) NOT NULL COMMENT '6; 50...',
  `valeur_achat` float NOT NULL,
  `valeur_vente` float NOT NULL,
  `unitaire` tinyint(1) NOT NULL COMMENT '0= fut ; 1 = bouteille'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Type de stock possible';

--
-- Contenu de la table `type_stock`
--

INSERT INTO `type_stock` (`id`, `nom`, `reference`, `conditionnement`, `volume`, `valeur_achat`, `valeur_vente`, `unitaire`) VALUES
(3, 'Chouffe', 'CHO', 'Conditionnement', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
`id` int(3) NOT NULL,
  `login` varchar(10) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `derniere_connexion` datetime DEFAULT NULL COMMENT 'pour savoir qui est connecté...'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='Info Utilisateur';

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `pass`, `derniere_connexion`) VALUES
(1, 'admin', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', '2016-05-18 00:39:43'),
(2, 'ung', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', '2016-05-16 02:47:17'),
(10, 'interlink', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(11, 'ism', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(12, 'rutt', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(13, 'epf', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(14, 'pmom', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(15, 'falutt', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(16, 'asanutt', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(17, 'revivre', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(18, 'puls', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(19, 'macc', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(21, 'coord', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(22, 'log', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(23, 'tech', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(24, 'accueil', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(25, 'etu', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(26, 'entree', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `archive_prob`
--
ALTER TABLE `archive_prob`
 ADD PRIMARY KEY (`id`), ADD KEY `id_liste_prob` (`id_liste_prob`), ADD KEY `id_type_prob` (`id_type_prob`), ADD KEY `id_espace` (`id_espace`);

--
-- Index pour la table `cat_prob`
--
ALTER TABLE `cat_prob`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chat`
--
ALTER TABLE `chat`
 ADD PRIMARY KEY (`id`), ADD KEY `id_expediteur` (`id_expediteur`), ADD KEY `id_destinataire` (`id_destinataire`), ADD KEY `id_droit` (`id_droit`);

--
-- Index pour la table `delestage`
--
ALTER TABLE `delestage`
 ADD PRIMARY KEY (`id`), ADD KEY `id_espace` (`id_espace`), ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `droit`
--
ALTER TABLE `droit`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `espace`
--
ALTER TABLE `espace`
 ADD PRIMARY KEY (`id`), ADD KEY `id_type_espace` (`id_type_espace`), ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `liste_droit`
--
ALTER TABLE `liste_droit`
 ADD PRIMARY KEY (`id`), ADD KEY `id_utilisateur` (`id_utilisateur`), ADD KEY `id_droit` (`id_droit`);

--
-- Index pour la table `liste_prob`
--
ALTER TABLE `liste_prob`
 ADD PRIMARY KEY (`id`), ADD KEY `id_type_prob` (`id_type_prob`), ADD KEY `id_espace` (`id_espace`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
 ADD PRIMARY KEY (`id`), ADD KEY `id_stock` (`id_stock`), ADD KEY `id_espace` (`id_espace`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `identifiant` (`identifiant`), ADD KEY `id_type_stock` (`id_type_stock`);

--
-- Index pour la table `type_espace`
--
ALTER TABLE `type_espace`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_prob`
--
ALTER TABLE `type_prob`
 ADD PRIMARY KEY (`id`), ADD KEY `id_cat_prob` (`id_cat_prob`);

--
-- Index pour la table `type_stock`
--
ALTER TABLE `type_stock`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `archive_prob`
--
ALTER TABLE `archive_prob`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `cat_prob`
--
ALTER TABLE `cat_prob`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `chat`
--
ALTER TABLE `chat`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `delestage`
--
ALTER TABLE `delestage`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `droit`
--
ALTER TABLE `droit`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `espace`
--
ALTER TABLE `espace`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `liste_droit`
--
ALTER TABLE `liste_droit`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `liste_prob`
--
ALTER TABLE `liste_prob`
MODIFY `id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=157;
--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=402;
--
-- AUTO_INCREMENT pour la table `type_espace`
--
ALTER TABLE `type_espace`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `type_prob`
--
ALTER TABLE `type_prob`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `type_stock`
--
ALTER TABLE `type_stock`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `archive_prob`
--
ALTER TABLE `archive_prob`
ADD CONSTRAINT `archive_prob_ibfk_1` FOREIGN KEY (`id_liste_prob`) REFERENCES `liste_prob` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `archive_prob_ibfk_2` FOREIGN KEY (`id_type_prob`) REFERENCES `type_prob` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `archive_prob_ibfk_3` FOREIGN KEY (`id_espace`) REFERENCES `espace` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `chat`
--
ALTER TABLE `chat`
ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_expediteur`) REFERENCES `utilisateur` (`id`),
ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_destinataire`) REFERENCES `utilisateur` (`id`),
ADD CONSTRAINT `chat_ibfk_3` FOREIGN KEY (`id_droit`) REFERENCES `droit` (`id`);

--
-- Contraintes pour la table `delestage`
--
ALTER TABLE `delestage`
ADD CONSTRAINT `delestage_ibfk_1` FOREIGN KEY (`id_espace`) REFERENCES `espace` (`id`),
ADD CONSTRAINT `delestage_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `espace`
--
ALTER TABLE `espace`
ADD CONSTRAINT `espace_ibfk_1` FOREIGN KEY (`id_type_espace`) REFERENCES `type_espace` (`id`),
ADD CONSTRAINT `espace_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `liste_droit`
--
ALTER TABLE `liste_droit`
ADD CONSTRAINT `liste_droit_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
ADD CONSTRAINT `liste_droit_ibfk_2` FOREIGN KEY (`id_droit`) REFERENCES `droit` (`id`);

--
-- Contraintes pour la table `liste_prob`
--
ALTER TABLE `liste_prob`
ADD CONSTRAINT `liste_prob_ibfk_1` FOREIGN KEY (`id_type_prob`) REFERENCES `type_prob` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `liste_prob_ibfk_2` FOREIGN KEY (`id_espace`) REFERENCES `espace` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `parcours`
--
ALTER TABLE `parcours`
ADD CONSTRAINT `parcours_ibfk_1` FOREIGN KEY (`id_stock`) REFERENCES `stock` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `parcours_ibfk_2` FOREIGN KEY (`id_espace`) REFERENCES `espace` (`id`);

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_type_stock`) REFERENCES `type_stock` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `type_prob`
--
ALTER TABLE `type_prob`
ADD CONSTRAINT `type_prob_ibfk_1` FOREIGN KEY (`id_cat_prob`) REFERENCES `cat_prob` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
