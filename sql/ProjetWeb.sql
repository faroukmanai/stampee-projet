-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 26 avr. 2023 à 03:13
-- Version du serveur : 5.7.34
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ProjetWeb`
--

-- --------------------------------------------------------

--
-- Structure de la table `enchere`
--

CREATE TABLE `enchere` (
  `enchere_id` int(11) NOT NULL,
  `Timbre_id` int(11) NOT NULL,
  `Date_debut` datetime NOT NULL,
  `Date_fin` datetime NOT NULL,
  `Prix_plancher` decimal(10,2) NOT NULL,
  `statuts` varchar(100) DEFAULT NULL,
  `enchere_lord_favoris` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `enchere`
--

INSERT INTO `enchere` (`enchere_id`, `Timbre_id`, `Date_debut`, `Date_fin`, `Prix_plancher`, `statuts`, `enchere_lord_favoris`) VALUES
(25, 46, '2023-04-13 00:00:00', '2023-04-29 00:00:00', '1.00', NULL, 0),
(26, 47, '2023-04-22 00:00:00', '2023-04-30 00:00:00', '50.00', NULL, 0),
(27, 48, '2023-04-26 00:00:00', '2023-04-30 00:00:00', '450.00', NULL, 0),
(28, 49, '2023-05-10 00:00:00', '2023-05-28 00:00:00', '115.00', NULL, 0),
(29, 50, '2023-05-18 00:00:00', '2023-05-26 00:00:00', '530.00', NULL, 0),
(30, 52, '2023-06-15 00:00:00', '2023-07-21 00:00:00', '15.00', NULL, 0),
(31, 54, '2023-04-29 00:00:00', '2023-05-27 00:00:00', '29.00', NULL, 0),
(33, 55, '2023-04-21 00:00:00', '2023-06-16 00:00:00', '35.00', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `favori`
--

CREATE TABLE `favori` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `enchere_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL,
  `image_url` varchar(250) NOT NULL,
  `Timbre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mise`
--

CREATE TABLE `mise` (
  `mise_id` int(11) NOT NULL,
  `enchere_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `Montant` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `utilisateur_profil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_id`, `utilisateur_profil`) VALUES
(1, 'administrateur'),
(2, 'membre');

-- --------------------------------------------------------

--
-- Structure de la table `timbre`
--

CREATE TABLE `timbre` (
  `timbre_id` int(11) NOT NULL,
  `timbre_Titre` varchar(250) NOT NULL,
  `timbre_Description` varchar(250) NOT NULL,
  `timbre_Affiche` varchar(250) DEFAULT 'stampee/img/timbre2.jpg',
  `timbre_Annee` int(11) NOT NULL,
  `timbre_Pays` varchar(250) NOT NULL,
  `timbre_Etat` varchar(250) NOT NULL,
  `timbre_lord_favoris` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `timbre`
--

INSERT INTO `timbre` (`timbre_id`, `timbre_Titre`, `timbre_Description`, `timbre_Affiche`, `timbre_Annee`, `timbre_Pays`, `timbre_Etat`, `timbre_lord_favoris`, `utilisateur_id`) VALUES
(46, '19478AC - LA REINE ELISABETH', 'description du timbre: La reine Elisabeth', 'timbre12.jpeg', 1976, 'United_kingdom', 'Parfait', 0, 17),
(47, '89370 - TIMBRE TEST', 'Description du timbre 89370 - Timbre Test', 'timbre4.jpeg', 1994, 'Canada', 'Endommagé', 0, 17),
(48, '637849 - UN NOUVEAU TIMBRE', 'Description de 637849 - Un nouveau Timbre', 'timbre2.jpg', 2012, 'Canada', 'Parfait', 0, 17),
(49, 'DE29103# - TIMBRE ROYAL', 'Description de DE29103# - Timbre Royal', 'timbre1.jpg', 1987, 'Canada', 'Moyen', 0, 17),
(50, '122# - TIMBRE USA', 'Descritpion du timbre 122# - Timbre USA', 'timbre3.jpeg', 2006, 'USA', 'Endommagé', 0, 17),
(51, '2314# - TIMBRE MONDIAL', 'Description de 2314# - Timbre Mondial', 'timbre10.jpeg', 1970, 'United_kingdom', 'Parfait', 0, 17),
(52, 'ZZX1234# - NIGARA FALLS', 'Descriotion du timbre ZZX1234# - Nigara Falls', 'timbre5.jpeg', 2003, 'Canada', 'Endommagé', 0, 21),
(53, '#3424 - FALKLAND ISLAND', 'Desctrption du timbre #3424 - Falkland island', 'timbre9.jpeg', 1999, 'USA', 'Parfait', 0, 21),
(54, '#12 -USA MARINES', '#12 - USA Marines Stampee', 'timbre6.jpeg', 1983, 'USA', 'Moyen', 0, 21),
(55, '1234# - TIMBRE D\'AFRIQUE', 'Description du timbre d\'Afrique .', 'timbre8.jpeg', 2006, 'United_kingdom', 'Endommagé', 0, 23);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `utilisateur_id` int(11) NOT NULL,
  `utilisateur_nom` varchar(255) NOT NULL,
  `utilisateur_prenom` varchar(255) NOT NULL,
  `utilisateur_courriel` varchar(255) NOT NULL,
  `utilisateur_mdp` varchar(255) NOT NULL,
  `utilisateur_renouveler_mdp` char(3) NOT NULL DEFAULT 'oui',
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateur_id`, `utilisateur_nom`, `utilisateur_prenom`, `utilisateur_courriel`, `utilisateur_mdp`, `utilisateur_renouveler_mdp`, `role_id`) VALUES
(17, 'manai', 'farouk', 'faroukmanai@hotmail.fr', '59812f368260f638fa4cf62abe974d7579f7fe6753134426cce2db815deb5cea4824943d49da02249854b8994e22c8c34b12dc9ed542e74a362d000e45e468e0', 'oui', 1),
(21, 'manai', 'hedi', 'hedimanai@hotmail.fr', '59812f368260f638fa4cf62abe974d7579f7fe6753134426cce2db815deb5cea4824943d49da02249854b8994e22c8c34b12dc9ed542e74a362d000e45e468e0', 'oui', 1),
(22, 'manai', 'mehdi', 'mehdimanai@hotmail.fr', '59812f368260f638fa4cf62abe974d7579f7fe6753134426cce2db815deb5cea4824943d49da02249854b8994e22c8c34b12dc9ed542e74a362d000e45e468e0', 'oui', 1),
(23, 'chaouachii', 'aicha', 'aichachaouachi@hotmail.fr', '59812f368260f638fa4cf62abe974d7579f7fe6753134426cce2db815deb5cea4824943d49da02249854b8994e22c8c34b12dc9ed542e74a362d000e45e468e0', 'oui', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD PRIMARY KEY (`enchere_id`),
  ADD KEY `Timbre_id` (`Timbre_id`);

--
-- Index pour la table `favori`
--
ALTER TABLE `favori`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `Timbre_id` (`Timbre_id`);

--
-- Index pour la table `mise`
--
ALTER TABLE `mise`
  ADD PRIMARY KEY (`mise_id`),
  ADD KEY `enchere_id` (`enchere_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Index pour la table `timbre`
--
ALTER TABLE `timbre`
  ADD PRIMARY KEY (`timbre_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`utilisateur_id`),
  ADD UNIQUE KEY `utilisateur_courriel` (`utilisateur_courriel`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `enchere`
--
ALTER TABLE `enchere`
  MODIFY `enchere_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `favori`
--
ALTER TABLE `favori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `timbre`
--
ALTER TABLE `timbre`
  MODIFY `timbre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD CONSTRAINT `enchere_ibfk_1` FOREIGN KEY (`Timbre_id`) REFERENCES `timbre` (`timbre_id`);

--
-- Contraintes pour la table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `favori_ibfk_1` FOREIGN KEY (`id`) REFERENCES `utilisateur` (`utilisateur_id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_timbre_image` FOREIGN KEY (`Timbre_id`) REFERENCES `timbre` (`timbre_id`);

--
-- Contraintes pour la table `mise`
--
ALTER TABLE `mise`
  ADD CONSTRAINT `fk_enchere_id` FOREIGN KEY (`enchere_id`) REFERENCES `enchere` (`enchere_id`);

--
-- Contraintes pour la table `timbre`
--
ALTER TABLE `timbre`
  ADD CONSTRAINT `fk_utilisateur_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`utilisateur_id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
