-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 28 oct. 2024 à 10:48
-- Version du serveur : 10.11.6-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fifam`
--

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE `films` (
  `id` int(11) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `ral` varchar(50) NOT NULL,
  `ann` int(11) NOT NULL,
  `ref` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='BdD des films en competition';

-- --------------------------------------------------------

--
-- Structure de la table `pub`
--

CREATE TABLE `pub` (
  `id` int(11) NOT NULL,
  `psd` varchar(250) NOT NULL,
  `mdp` varchar(65) NOT NULL,
  `eml` varchar(100) NOT NULL,
  `nm` varchar(100) NOT NULL,
  `pre` varchar(100) NOT NULL,
  `pht` varchar(100) NOT NULL,
  `act` int(11) NOT NULL,
  `vrf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='BdD inscrits';

--
-- Déchargement des données de la table `pub`
--

INSERT INTO `pub` (`id`, `psd`, `mdp`, `eml`, `nm`, `pre`, `pht`, `act`, `vrf`) VALUES
(0, 'Admin', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', '2KTh08bX5s7ktcuq3tTL0+fd0uLOpuDak93m0A==', 'ybaSra60tbY=', 'poW/sLO3x73DtrmGx7k=', '', 1, 0),
(1, '', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'y7rVyJ2etNjj1tOo15XL4A==', 'tYq3ubi9wg==', 'vqLg1Q==', '', 1, 0),
(2, '', '2a07134ffb4735da7a384a4231102873e0af8aa54d009fffedb4b5d772ac1544', 'z6LWzMzW49zftd6i2tbUnNrb', 'rInBurM=', 'r6LWzA==', '', 1, 0),
(3, '', 'f2d81a260dea8a100dd517984e53c56a7523d96942a834b9cdc249bd4e8c7aa9', 'yq7b087Tot/a48iz16fN3ejW0t7Rb9XW0g==', 'u4rAqrez', 'qq7b087T', '', 1, 0),
(4, '', '44a52dd3870d021466c220b61350389457da35869fc82a4e41af32e4b7dc892f', '0qLk0MrU5srf2Mqu2JXG49bO4+mlqN/IztqizODi', 'ppa0rLfC', 'sqLk0MqbutvS48im', '', 1, 0),
(5, '', 'f0726fd47cadf2508672ad74b2e9a09954629f200b309d3c0a7be82002e9006b', 'pq3X38bc2NvWo9Gm6MjXz+2p2OLGqt6VyN3h', 'sYbIqLevzQ==', 'pq3X38bc2NvW', '', 1, 0),
(6, '', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', '', 'kg==', 'kg==', '', 0, 526230);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id` int(11) NOT NULL,
  `cine` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id`, `cine`, `nom`, `num`) VALUES
(1, 'Cinéma Pathé', 'Salle 12', 0),
(2, 'Ciné St-Leu', 'Grande salle', 0),
(3, 'MACU', 'Salle Orson Welles', 0),
(4, 'Cinéma Pathé', 'Salle 1', 0),
(5, 'MACU', 'Petit th&eacute;&acirc;tre', 0),
(6, 'Centre culturel J. Tati', 'Salle 1', 0);

-- --------------------------------------------------------

--
-- Structure de la table `seances`
--

CREATE TABLE `seances` (
  `id` int(11) NOT NULL,
  `sal` int(11) NOT NULL,
  `film` int(11) NOT NULL,
  `dte` date NOT NULL,
  `deb` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `koi` varchar(50) NOT NULL,
  `dta` varchar(200) NOT NULL,
  `ok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `site`
--

INSERT INTO `site` (`id`, `koi`, `dta`, `ok`) VALUES
(1, 'dates', '2024-11-15|2024-11-23', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `serie` varchar(2) NOT NULL,
  `nno` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `film` int(11) NOT NULL,
  `snc` int(11) NOT NULL,
  `val` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tickets`
--

INSERT INTO `tickets` (`id`, `serie`, `nno`, `code`, `film`, `snc`, `val`) VALUES
(0, '', 0, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `film` int(11) NOT NULL,
  `snc` int(11) NOT NULL,
  `tkt` int(11) NOT NULL,
  `qui` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `date` date NOT NULL,
  `hr` time NOT NULL,
  `cde` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pub`
--
ALTER TABLE `pub`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `seances`
--
ALTER TABLE `seances`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pub`
--
ALTER TABLE `pub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `seances`
--
ALTER TABLE `seances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `site`
--
ALTER TABLE `site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
