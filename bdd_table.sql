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
CREATE TABLE IF NOT EXISTS `medecin` (
  `id_medecin` int NOT NULL,
  `Civilité` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Nom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Prénom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_medecin`),
  UNIQUE KEY `Id_utilisateur` (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id_patient` int NOT NULL AUTO_INCREMENT,
  `NumSecu` char(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Civilité` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Prénom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Adresse` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DateNaissance` date DEFAULT NULL,
  `LieuNaissance` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_patient`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

DROP TABLE IF EXISTS `rendezvous`;
CREATE TABLE IF NOT EXISTS `rendezvous` (
  `id_patient` int NOT NULL,
  `id_Rendezvous` int NOT NULL,
  `dateHeureRDV` datetime NOT NULL,
  `DureeRDV` time DEFAULT NULL,
  `id_medecin` int NOT NULL,
  PRIMARY KEY (`id_patient`,`id_Rendezvous`),
  KEY `id_medecin` (`id_medecin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rôle`
--

DROP TABLE IF EXISTS `rôle`;
CREATE TABLE IF NOT EXISTS `rôle` (
  `Id_Rôle` int NOT NULL AUTO_INCREMENT,
  `Description` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Rôle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mdp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Id_Rôle` int NOT NULL,
  PRIMARY KEY (`Id_utilisateur`),
  KEY `Id_Rôle` (`Id_Rôle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
