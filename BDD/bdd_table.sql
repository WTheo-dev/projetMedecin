-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 17 nov. 2023 à 11:20
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `medecin`
--

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
CREATE TABLE IF NOT EXISTS `medecin`(
   `id_medecin` INT AUTO_INCREMENT,
   `civilite` VARCHAR(8) NOT NULL,
   `nom` VARCHAR(50) NOT NULL,
   `prenom` VARCHAR(50) NOT NULL,
   `id_utilisateur` int NOT NULL,
   CONSTRAINT PK_medecin PRIMARY KEY(`id_medecin`),
   KEY `unique_id_utilisateur` (`id_utilisateur`)
);
-- --------------------------------------------------------

--
-- Structure de la table `usager`
--

DROP TABLE IF EXISTS `usager`;
CREATE TABLE IF NOT EXISTS `usager`(
   `id_usager` INT AUTO_INCREMENT,
   `civilite` VARCHAR(50) NOT NULL,
   `nom` VARCHAR(50) NOT NULL,
   `prenom` VARCHAR(50) NOT NULL,
   `sexe` CHAR(1) NOT NULL,
   `adresse` VARCHAR(50) NOT NULL,
   `code_postal` CHAR(5) NOT NULL,
   `ville` VARCHAR(50) NOT NULL,
   `date_nais` DATE NOT NULL,
   `lieu_nais` VARCHAR(50) NOT NULL,
   `num_secu` CHAR(15) NOT NULL,
   CONSTRAINT PK_usager PRIMARY KEY(`id_usager`),
   CONSTRAINT AK_usager UNIQUE(`num_secu`)
);
-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

DROP TABLE IF EXISTS `consultation`;

CREATE TABLE IF NOT EXISTS `consultation`(
   `id_consult` INT AUTO_INCREMENT,
   `date_consult` DATE NOT NULL,
   `heure_consult` TIME NOT NULL,
   `duree_consult` TIME NOT NULL,
   `id_medecin` INT NOT NULL,
   `id_usager` INT NOT NULL,
   CONSTRAINT PK_consultation PRIMARY KEY(`id_consult`),
   CONSTRAINT AK_consultation_idx2 UNIQUE(`id_medecin`, `date_consult`, `heure_consult`),
   CONSTRAINT AK_consultation_idx1 UNIQUE(`id_usager`, `date_consult`, `heure_consult`),
   CONSTRAINT FK_consultation_medecin FOREIGN KEY(`id_medecin`) REFERENCES medecin(`id_medecin`),
   CONSTRAINT FK_consultation_usager FOREIGN KEY(`id_usager`) REFERENCES usager(`id_usager`)
);

-- --------------------------------------------------------

--
-- Structure de la table `rôle`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int AUTO_INCREMENT,
  `nom_utilisateur` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mdp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_utilisateur`),
  KEY `id_role` (`id_role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
