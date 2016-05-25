-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 25 Mai 2016 à 14:01
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `flux`
--

-- --------------------------------------------------------

--
-- Structure de la table `archive_prob`
--

CREATE TABLE `archive_prob` (
  `id` int(11) NOT NULL,
  `id_liste_prob` int(100) NOT NULL,
  `id_type_prob` int(3) NOT NULL,
  `id_espace` int(3) NOT NULL,
  `heure` datetime NOT NULL,
  `gravite` int(1) NOT NULL COMMENT 'Gravité de la situation : OK = 0; moyen = 1; grave = 2.',
  `acteur` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'Personne en charge du problème'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Problèmes rencontrés';

-- --------------------------------------------------------

--
-- Structure de la table `cat_prob`
--

CREATE TABLE `cat_prob` (
  `id` int(3) NOT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nom des catégories de problèmes';

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

CREATE TABLE `chat` (
  `id` int(3) NOT NULL,
  `id_expediteur` int(3) NOT NULL,
  `id_destinataire` int(3) DEFAULT NULL,
  `id_droit` int(3) DEFAULT NULL COMMENT 'on peut aussi parler à tout un droit :)',
  `date` datetime NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `coin_transfers`
--

CREATE TABLE `coin_transfers` (
  `id` int(11) NOT NULL,
  `espace_id` int(11) NOT NULL,
  `transferredAt` datetime NOT NULL,
  `transferredBy` int(11) NOT NULL,
  `countedAt` datetime DEFAULT NULL,
  `countedBy` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `deletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `delestage`
--

CREATE TABLE `delestage` (
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

CREATE TABLE `droit` (
  `id` int(3) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT 'Admin = 1; Espace = 0',
  `liste` tinyint(1) NOT NULL COMMENT '1 = liste de discussion en +'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Info Droit';

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

CREATE TABLE `espace` (
  `id` int(3) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `id_type_espace` int(1) NOT NULL,
  `id_utilisateur` int(3) NOT NULL,
  `etat` tinyint(1) NOT NULL COMMENT '1 = ouvert ; 0 = fermé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Info Espace';

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
(14, 'Jeton Accueil', 'Accueil', 3, 24, 1),
(15, 'Bouffe Pizza', 'Coté chap', 1, 27, 0),
(16, 'Bouffe russe', 'Coté feu', 1, 27, 0),
(17, 'Bouffe sucré', 'coté feu', 1, 27, 0),
(18, 'Bouffe Thai', 'coté chap', 1, 27, 0);

-- --------------------------------------------------------

--
-- Structure de la table `liste_droit`
--

CREATE TABLE `liste_droit` (
  `id` int(3) NOT NULL,
  `id_utilisateur` int(3) NOT NULL,
  `id_droit` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='droit par utilisateur';

--
-- Contenu de la table `liste_droit`
--

INSERT INTO `liste_droit` (`id`, `id_utilisateur`, `id_droit`) VALUES
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
(16, 26, 3),
(17, 24, 3),
(18, 25, 3),
(19, 24, 2),
(20, 25, 2),
(21, 26, 2),
(22, 32, 1),
(23, 28, 1),
(24, 30, 1),
(25, 31, 1),
(26, 33, 1),
(27, 34, 1),
(28, 35, 1),
(29, 37, 1);

-- --------------------------------------------------------

--
-- Structure de la table `liste_prob`
--

CREATE TABLE `liste_prob` (
  `id` int(100) NOT NULL,
  `id_type_prob` int(3) NOT NULL,
  `id_espace` int(3) NOT NULL,
  `gravite` int(1) NOT NULL COMMENT 'Gravité de la situation : OK = 0; moyen = 1; grave = 2.',
  `auteur` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'Personne en charge du problème'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Problèmes en cours';

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `id` int(3) NOT NULL,
  `id_stock` int(3) NOT NULL,
  `id_espace` int(3) NOT NULL,
  `debut` datetime NOT NULL COMMENT 'Heure d''arrivée du produit dans l''espace',
  `fin` datetime NOT NULL COMMENT 'Heure de départ du produit dans l''espace',
  `quantite_debut` varchar(100) NOT NULL COMMENT 'Quantité à l''arrivée du produit dans l''espace'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Info sur le parcours d''un produit';

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `id` int(3) NOT NULL,
  `id_type_stock` int(3) NOT NULL,
  `identifiant` varchar(10) NOT NULL COMMENT 'La référence du stock plus un numéro',
  `entame` datetime NOT NULL COMMENT 'heure à laquelle on entame un produit',
  `fin` datetime NOT NULL COMMENT 'heure à laquel il est finit',
  `reste` varchar(100) NOT NULL COMMENT 'ce qu''il reste à la fermeture d''un espace'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `type_espace`
--

CREATE TABLE `type_espace` (
  `id` int(1) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Type d''espaces possible';

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

CREATE TABLE `type_prob` (
  `id` int(3) NOT NULL,
  `id_cat_prob` int(3) NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lien` int(3) NOT NULL COMMENT 'id_type_stock ou 0 si pas de lien'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Type de problème possible';

--
-- Contenu de la table `type_prob`
--

INSERT INTO `type_prob` (`id`, `id_cat_prob`, `nom`, `lien`) VALUES
(1, 1, 'Gobelets softs', 0),
(2, 1, 'Gobelets bières', 0),
(3, 1, 'Ingrédients cocktail', 0),
(4, 1, 'Sacs Poubelles', 0),
(6, 2, 'Au niveau d\'un fût', 0),
(7, 2, 'Au niveau de la tireuse', 0),
(8, 2, 'Son ou Lumière', 0),
(9, 2, 'Au niveau électricité', 0),
(10, 4, 'Alerte sécurité', 0),
(11, 3, 'Alerte santé', 0),
(13, 5, 'Demande délestage', 0),
(14, 0, 'Chouffe', 3),
(15, 0, 'Afflighem Triple', 10),
(16, 1, 'Flûte champagne', 0),
(17, 1, 'Champagne Classique', 0),
(18, 1, 'Champagne Millésimé', 0),
(19, 1, 'Champagne Rosé', 0),
(20, 0, 'Mutzig', 5),
(21, 0, 'Kriek', 6),
(22, 0, 'Cuvée des Trolls', 9),
(23, 0, 'Desperados', 12),
(24, 0, 'Barbar', 16),
(25, 0, 'Triple Karmeliett', 8),
(26, 0, 'Chouffe', 11),
(27, 0, 'Edelweiss', 7),
(28, 0, 'Cidre', 15),
(29, 0, 'Queue de Charrue', 14),
(30, 0, 'Orjy', 13);

-- --------------------------------------------------------

--
-- Structure de la table `type_stock`
--

CREATE TABLE `type_stock` (
  `id` int(3) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `reference` varchar(15) NOT NULL,
  `conditionnement` varchar(100) NOT NULL COMMENT 'Carton de 6 bouteilles; Fut de Fisher....',
  `volume` int(4) NOT NULL COMMENT '6; 50...',
  `valeur_achat` float NOT NULL,
  `valeur_vente` float NOT NULL,
  `unitaire` tinyint(1) NOT NULL COMMENT '0= fut ; 1 = bouteille'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Type de stock possible';

--
-- Contenu de la table `type_stock`
--

INSERT INTO `type_stock` (`id`, `nom`, `reference`, `conditionnement`, `volume`, `valeur_achat`, `valeur_vente`, `unitaire`) VALUES
(5, 'Mutzig', 'MUT', 'Conditionnement', 0, 0, 0, 0),
(6, 'Kriek', 'KR', 'Conditionnement', 0, 0, 0, 0),
(7, 'Edelweiss', 'ED', 'Conditionnement', 0, 0, 0, 0),
(8, 'Triple Karmeliett', 'TK', 'Conditionnement', 0, 0, 0, 0),
(9, 'Cuvée des Trolls', 'CT', 'Conditionnement', 0, 0, 0, 0),
(10, 'Afflighem Triple', 'AFT', 'Conditionnement', 0, 0, 0, 0),
(11, 'Chouffe', 'CH', 'Conditionnement', 0, 0, 0, 0),
(12, 'Desperados', 'DESPE', 'Conditionnement', 0, 0, 0, 0),
(13, 'Orjy', 'OJ', 'Conditionnement', 0, 0, 0, 0),
(14, 'Queue de Charrue', 'QC', 'Conditionnement', 0, 0, 0, 0),
(15, 'Cidre', 'CID', 'Conditionnement', 0, 0, 0, 0),
(16, 'Barbar', 'BAR', 'Conditionnement', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(3) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `derniere_connexion` datetime DEFAULT NULL COMMENT 'pour savoir qui est connecté...'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Info Utilisateur';

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `pass`, `derniere_connexion`) VALUES
(2, 'ung', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
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
(24, 'accueil', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(25, 'etu', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(26, 'entree', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(27, 'bouffe', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(28, 'logistique', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(30, 'respo-jeton-c', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(31, 'respo-jeton-h', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(32, 'coordinateur', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(33, 'securite', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(34, 'respo-flux', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(35, 'respo-informatique', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL),
(37, 'flan', 'ab35ba20c808c1119d00adb45bb55e31ae66ec59', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `archive_prob`
--
ALTER TABLE `archive_prob`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_liste_prob` (`id_liste_prob`),
  ADD KEY `id_type_prob` (`id_type_prob`),
  ADD KEY `id_espace` (`id_espace`);

--
-- Index pour la table `cat_prob`
--
ALTER TABLE `cat_prob`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_expediteur` (`id_expediteur`),
  ADD KEY `id_destinataire` (`id_destinataire`),
  ADD KEY `id_droit` (`id_droit`);

--
-- Index pour la table `coin_transfers`
--
ALTER TABLE `coin_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `espace_id` (`espace_id`),
  ADD KEY `transferredBy` (`transferredBy`),
  ADD KEY `countedBy` (`countedBy`);

--
-- Index pour la table `delestage`
--
ALTER TABLE `delestage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_espace` (`id_espace`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `droit`
--
ALTER TABLE `droit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `espace`
--
ALTER TABLE `espace`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_espace` (`id_type_espace`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `liste_droit`
--
ALTER TABLE `liste_droit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_droit` (`id_droit`);

--
-- Index pour la table `liste_prob`
--
ALTER TABLE `liste_prob`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_prob` (`id_type_prob`),
  ADD KEY `id_espace` (`id_espace`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_stock` (`id_stock`),
  ADD KEY `id_espace` (`id_espace`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifiant` (`identifiant`),
  ADD KEY `id_type_stock` (`id_type_stock`);

--
-- Index pour la table `type_espace`
--
ALTER TABLE `type_espace`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_prob`
--
ALTER TABLE `type_prob`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cat_prob` (`id_cat_prob`);

--
-- Index pour la table `type_stock`
--
ALTER TABLE `type_stock`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `archive_prob`
--
ALTER TABLE `archive_prob`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `cat_prob`
--
ALTER TABLE `cat_prob`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `coin_transfers`
--
ALTER TABLE `coin_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `delestage`
--
ALTER TABLE `delestage`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `droit`
--
ALTER TABLE `droit`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `espace`
--
ALTER TABLE `espace`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `liste_droit`
--
ALTER TABLE `liste_droit`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `liste_prob`
--
ALTER TABLE `liste_prob`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;
--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `type_espace`
--
ALTER TABLE `type_espace`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `type_prob`
--
ALTER TABLE `type_prob`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `type_stock`
--
ALTER TABLE `type_stock`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
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
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_expediteur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_destinataire`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_ibfk_3` FOREIGN KEY (`id_droit`) REFERENCES `droit` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `coin_transfers`
--
ALTER TABLE `coin_transfers`
  ADD CONSTRAINT `coin_transfers_ibfk_1` FOREIGN KEY (`espace_id`) REFERENCES `espace` (`id`),
  ADD CONSTRAINT `coin_transfers_ibfk_4` FOREIGN KEY (`transferredBy`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `coin_transfers_ibfk_5` FOREIGN KEY (`countedBy`) REFERENCES `utilisateur` (`id`);

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
  ADD CONSTRAINT `liste_droit_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liste_droit_ibfk_2` FOREIGN KEY (`id_droit`) REFERENCES `droit` (`id`) ON DELETE CASCADE;

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
