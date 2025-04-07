-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 07 avr. 2025 à 22:31
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `netflix`
--

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `texte_alternatif` varchar(255) DEFAULT NULL,
  `categorie` varchar(50) NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `nom_fichier`, `chemin`, `texte_alternatif`, `categorie`, `date_ajout`) VALUES
(1, 'inception.jpg', 'images/inception.jpg', 'Affiche Inception', 'Populaires', '2025-04-07 18:31:30'),
(2, 'stranger-things.jpg', 'images/stranger-things.jpg', 'Affiche Stranger Things', 'Populaires', '2025-04-07 18:31:30'),
(3, 'mandalorian.jpg', 'images/mandalorian.jpg', 'Affiche The Mandalorian', 'Top Séries', '2025-04-07 18:31:30'),
(4, 'got.jpg', 'images/got.jpg', 'Affiche Game of Thrones', 'Les plus regardés', '2025-04-07 18:31:30');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `sexe` enum('masculin','feminin','autre') DEFAULT NULL,
  `admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `motdepasse`, `nom`, `prenom`, `date_naissance`, `email`, `telephone`, `sexe`, `admin`) VALUES
(1, 'elie', '$2y$10$6npFLtY.YLfwV2ifZRLreu/tmxoiHI76nZsR/JCQt1Yfu3JjOPzD.', 'shyti', 'elie', '2006-06-09', 'shytielie@yahoo.com', '0781598744', 'masculin', 0),
(4, 'elie1', '$2y$10$tgTcaabC/WW6Bjw9cGVVE.LKc5hdp00pM05GwWQ5iSwW2epGmgG6C', 'shyti', 'elie', '2006-06-09', 'gamin42820@gmail.com', '0781598794', 'masculin', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
