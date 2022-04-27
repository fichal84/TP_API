-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour ceipi
CREATE DATABASE IF NOT EXISTS `ceipi` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ceipi`;

-- Listage de la structure de la table ceipi. comptes
CREATE TABLE IF NOT EXISTS `comptes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `solde` double(8,2) NOT NULL,
  `client` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Listage de la structure de la table ceipi. operations
CREATE TABLE IF NOT EXISTS `operations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_operation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_operation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `montant` double(8,2) NOT NULL,
  `id_compte` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

