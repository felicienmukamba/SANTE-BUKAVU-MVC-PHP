-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2026 at 05:00 AM
-- Server version: 8.0.46
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sante`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `providerAccountId` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refresh_token` text COLLATE utf8mb4_unicode_ci,
  `access_token` text COLLATE utf8mb4_unicode_ci,
  `expires_at` int DEFAULT NULL,
  `token_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope` text COLLATE utf8mb4_unicode_ci,
  `id_token` text COLLATE utf8mb4_unicode_ci,
  `session_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_provider_account` (`provider`,`providerAccountId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alertes_sanitaires`
--

DROP TABLE IF EXISTS `alertes_sanitaires`;
CREATE TABLE IF NOT EXISTS `alertes_sanitaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Information',
  `statut` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `dateDebut` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateFin` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alertes_sanitaires`
--

INSERT INTO `alertes_sanitaires` (`id`, `titre`, `description`, `niveau`, `statut`, `dateDebut`, `dateFin`, `createdAt`) VALUES
(1, 'Mise à jour des politiques RH', 'dsds', 'Information', 'Active', '2026-08-27 12:25:09', '2026-08-27 12:25:00', '2026-08-27 12:25:09');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

DROP TABLE IF EXISTS `consultations`;
CREATE TABLE IF NOT EXISTS `consultations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `medecinId` int NOT NULL,
  `patientId` int NOT NULL,
  `dateConsultation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `motif` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnostique` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `prix` decimal(10,2) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `medecinId` (`medecinId`),
  KEY `patientId` (`patientId`),
  KEY `idx_consultations_date` (`dateConsultation`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `medecinId`, `patientId`, `dateConsultation`, `motif`, `diagnostique`, `notes`, `prix`, `createdAt`) VALUES
(1, 2, 1, '2026-08-27 14:13:47', 'Conujuj-ht', 'dos', 'ujyèyhth', 23.00, '2026-08-27 14:13:47');

-- --------------------------------------------------------

--
-- Table structure for table `delivrances`
--

DROP TABLE IF EXISTS `delivrances`;
CREATE TABLE IF NOT EXISTS `delivrances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prescriptionId` int NOT NULL,
  `medicamentId` int NOT NULL,
  `quantite` int NOT NULL,
  `dateDelivrance` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivrePar` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prescriptionId` (`prescriptionId`),
  KEY `medicamentId` (`medicamentId`),
  KEY `delivrePar` (`delivrePar`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivrances`
--

INSERT INTO `delivrances` (`id`, `prescriptionId`, `medicamentId`, `quantite`, `dateDelivrance`, `delivrePar`) VALUES
(1, 1, 5, 12, '2026-08-28 06:47:11', 'admin-seed');

-- --------------------------------------------------------

--
-- Table structure for table `examens_medicaux`
--

DROP TABLE IF EXISTS `examens_medicaux`;
CREATE TABLE IF NOT EXISTS `examens_medicaux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `consultationId` int NOT NULL,
  `typeExamen` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resultat` text COLLATE utf8mb4_unicode_ci,
  `dateExamen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'demand??',
  `prix` decimal(10,2) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `consultationId` (`consultationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hopitaux`
--

DROP TABLE IF EXISTS `hopitaux`;
CREATE TABLE IF NOT EXISTS `hopitaux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lits` int NOT NULL DEFAULT '0',
  `litsOccupes` int NOT NULL DEFAULT '0',
  `services` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hopitaux`
--

INSERT INTO `hopitaux` (`id`, `nom`, `adresse`, `telephone`, `email`, `lits`, `litsOccupes`, `services`, `latitude`, `longitude`, `createdAt`) VALUES
(1, 'H??pital Central', '12 avenue de la Sant??', '+221 33 000 00 00', 'contact@hopital.local', 0, 0, NULL, NULL, NULL, '2026-08-27 11:55:02'),
(2, 'H??pital G??n??ral de Bukavu', 'Bukavu, Sud-Kivu', '+243 123 456 789', 'contact@hgb.cd', 0, 0, NULL, NULL, NULL, '2026-08-27 11:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `interactions_medicamenteuses`
--

DROP TABLE IF EXISTS `interactions_medicamenteuses`;
CREATE TABLE IF NOT EXISTS `interactions_medicamenteuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `medicamentId` int NOT NULL,
  `medicamentAssocieId` int NOT NULL,
  `niveau` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Vigilance',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_interaction` (`medicamentId`,`medicamentAssocieId`),
  KEY `medicamentAssocieId` (`medicamentAssocieId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laboratoires`
--

DROP TABLE IF EXISTS `laboratoires`;
CREATE TABLE IF NOT EXISTS `laboratoires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratoires`
--

INSERT INTO `laboratoires` (`id`, `nom`, `adresse`, `telephone`, `email`, `actif`) VALUES
(1, 'Laboratoire Central', '8 rue des Analyses', '+221 33 111 11 11', 'lab@hopital.local', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medecins`
--

DROP TABLE IF EXISTS `medecins`;
CREATE TABLE IF NOT EXISTS `medecins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialite` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `licence` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hopitalId` int NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userId` (`userId`),
  KEY `hopitalId` (`hopitalId`),
  KEY `idx_medecins_specialite` (`specialite`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medecins`
--

INSERT INTO `medecins` (`id`, `userId`, `specialite`, `licence`, `hopitalId`, `createdAt`) VALUES
(1, 'doctor-demo', 'M??decine g??n??rale', 'MED-2026-001', 1, '2026-08-27 11:55:02'),
(2, 'medecin-seed', 'M??decine G??n??rale', 'MED-2024-001', 2, '2026-08-27 11:55:02'),
(3, 'a9d9ddf355cf6c6adf3d7877', 'fdfdfdew', '3232232', 1, '2026-08-27 12:09:33'),
(4, '7e5b16d71be08863a607fd8c', 'dsdsds', 'DSDSDDSDS', 1, '2026-08-28 06:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `medicaments`
--

DROP TABLE IF EXISTS `medicaments`;
CREATE TABLE IF NOT EXISTS `medicaments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomCommercial` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomGenerique` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosage` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `formePharmaceutique` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voieAdministration` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quantiteEnStock` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicaments`
--

INSERT INTO `medicaments` (`id`, `nomCommercial`, `nomGenerique`, `dosage`, `formePharmaceutique`, `voieAdministration`, `prix`, `description`, `quantiteEnStock`) VALUES
(1, 'Parac??tamol 500', 'Parac??tamol', '500 mg', 'Comprim??', 'Orale', 100.00, NULL, 250),
(2, 'Amoxicilline 500', 'Amoxicilline', '500 mg', 'G??lule', 'Orale', 250.00, NULL, 120),
(3, 'Paracetamol', 'Parac??tamol', '500mg', 'Comprim??', 'Orale', 500.00, NULL, 100),
(4, 'Amoxicilline', 'Amoxicilline', '500mg', 'G??lule', 'Orale', 1500.00, NULL, 100),
(5, 'Ibuprof??ne', 'Ibuprof??ne', '400mg', 'Comprim??', 'Orale', 800.00, NULL, 88);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_national` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `situation_matrimoniale` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userId` (`userId`),
  UNIQUE KEY `numero_national` (`numero_national`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `userId`, `numero_national`, `nom`, `prenom`, `date_naissance`, `lieu_naissance`, `sexe`, `situation_matrimoniale`, `createdAt`) VALUES
(1, 'patient-seed', '123456789', 'Mutombo', 'Jean', '1990-01-01', 'Bukavu', 'M', 'C??libataire', '2026-08-27 11:55:02'),
(2, 'ee5ec852cac21df1fe839517', 'FS-4243224', 'mukamba', 'felicien', '2026-08-20', 'Mazozo', 'F', 'Célibataire', '2026-08-27 12:09:03'),
(3, 'ab110ef34f0d5779a915f75b', 'rerer', 'rerer', 'g', '2026-08-04', 'rererere', 'F', 'Célibataire', '2026-08-28 06:40:52'),
(4, '97db85ce555eb8cbda625564', 'etet5454644646464', 'fdfdgetet', 'fdfd', '2026-08-03', '64768797979', 'F', 'Célibataire', '2026-08-28 06:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions_medicales`
--

DROP TABLE IF EXISTS `prescriptions_medicales`;
CREATE TABLE IF NOT EXISTS `prescriptions_medicales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `consultationId` int NOT NULL,
  `datePrescription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `posologie` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dureeTraitement` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instruction` text COLLATE utf8mb4_unicode_ci,
  `statut` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `consultationId` (`consultationId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescriptions_medicales`
--

INSERT INTO `prescriptions_medicales` (`id`, `consultationId`, `datePrescription`, `posologie`, `dureeTraitement`, `quantite`, `instruction`, `statut`, `createdAt`) VALUES
(1, 1, '2026-08-28 06:46:48', 'ffgf', 'gfg', 'fgf', 'gfgfg', 'active', '2026-08-28 06:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_medicaments`
--

DROP TABLE IF EXISTS `prescription_medicaments`;
CREATE TABLE IF NOT EXISTS `prescription_medicaments` (
  `prescriptionId` int NOT NULL,
  `medicamentId` int NOT NULL,
  PRIMARY KEY (`prescriptionId`,`medicamentId`),
  KEY `medicamentId` (`medicamentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rendez_vous`
--

DROP TABLE IF EXISTS `rendez_vous`;
CREATE TABLE IF NOT EXISTS `rendez_vous` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patientId` int NOT NULL,
  `medecinId` int NOT NULL,
  `date` datetime NOT NULL,
  `statut` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Planifi??',
  `motif` text COLLATE utf8mb4_unicode_ci,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `patientId` (`patientId`),
  KEY `medecinId` (`medecinId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rendez_vous`
--

INSERT INTO `rendez_vous` (`id`, `patientId`, `medecinId`, `date`, `statut`, `motif`, `createdAt`, `updatedAt`) VALUES
(1, 2, 1, '2026-08-27 12:25:00', 'Planifi??', 'vdfdfd', '2026-08-27 12:25:35', '2026-08-27 12:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `resultats_laboratoire`
--

DROP TABLE IF EXISTS `resultats_laboratoire`;
CREATE TABLE IF NOT EXISTS `resultats_laboratoire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `examenId` int NOT NULL,
  `laboratoireId` int NOT NULL,
  `referenceExterne` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultat` text COLLATE utf8mb4_unicode_ci,
  `dateReception` datetime DEFAULT NULL,
  `statut` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'En attente',
  PRIMARY KEY (`id`),
  KEY `examenId` (`examenId`),
  KEY `laboratoireId` (`laboratoireId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sessionToken` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionToken` (`sessionToken`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailVerified` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'patient',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mustChangePassword` tinyint(1) NOT NULL DEFAULT '1',
  `failedLoginAttempts` int NOT NULL DEFAULT '0',
  `lockedUntil` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `emailVerified`, `image`, `role`, `password`, `mustChangePassword`, `failedLoginAttempts`, `lockedUntil`, `createdAt`, `updatedAt`) VALUES
('7e5b16d71be08863a607fd8c', 'DSSDS', 'admain@sante.cd', NULL, NULL, 'medecin', '$2y$10$rl7eTHeL6Bk3iGdb7tMmf.cLDxHMsoS2yuF2YuYKO9ZesApGO4Eay', 1, 0, NULL, '2026-08-28 06:36:04', '2026-08-28 06:36:04'),
('97db85ce555eb8cbda625564', 'fdfd fdfdgetet', 'admifdfn@sante.cd', NULL, NULL, 'patient', '$2y$10$1l3v5UUmHGwGVZXDvR5iZeF1NGVWAIYkkRygJYTqOFan31lGrzUh2', 1, 0, NULL, '2026-08-28 06:54:15', '2026-08-28 06:54:15'),
('a9d9ddf355cf6c6adf3d7877', 'misau benye', 'david@gmail.com', NULL, NULL, 'medecin', '$2y$12$.rKHo2hnXrjPFFJFauwJNudFpnKhUPweKJ1pG2QCcD3dwimZ2XbxW', 1, 0, NULL, '2026-08-27 12:09:33', '2026-08-28 03:42:41'),
('ab110ef34f0d5779a915f75b', 'g rerer', 'adremin@sante.cd', NULL, NULL, 'patient', '$2y$10$L2RT4Ds75mWOGTKBPuJ6UulfL71OG1zGuqLaupJGuqkENNZboYOLO', 1, 0, NULL, '2026-08-28 06:40:52', '2026-08-28 06:54:44'),
('admin-demo', 'Administrateur', 'admin@sante.local', NULL, NULL, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCw5nYj1E0gQn1xv4v7u', 0, 0, NULL, '2026-08-27 11:55:02', '2026-08-27 11:55:02'),
('admin-seed', 'Administrateur', 'admin@sante.cd', NULL, NULL, 'admin', '$2y$12$q3ZRfg3tLNv9TphUY3IatOyNcv/RsjwfIRnrbPJH4wV/HoWi7tBoi', 0, 0, NULL, '2026-08-27 11:55:02', '2026-08-27 11:55:02'),
('doctor-demo', 'Dr. Amina Diop', 'amina@sante.local', NULL, NULL, 'medecin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCw5nYj1E0gQn1xv4v7u', 0, 0, NULL, '2026-08-27 11:55:02', '2026-08-27 11:55:02'),
('ee5ec852cac21df1fe839517', 'phelix david', 'doctor.cd@gmail.com', NULL, NULL, 'patient', '$2y$12$P4EKzAayh57rUr5AwOSNJ.VNZdQXz6NsAM33pvOkLGx7aMayfbn4u', 1, 0, NULL, '2026-08-27 12:09:03', '2026-08-28 03:42:08'),
('medecin-seed', 'Dr. Kabila', 'medecin@sante.cd', NULL, NULL, 'medecin', '$2y$12$wQ39WdF0CJEoZI9TJJ.cOeAR4hgInOOdkaGtLU4DZ3XbUlZEXZx6W', 0, 0, NULL, '2026-08-27 11:55:02', '2026-08-27 11:55:02'),
('patient-seed', 'Jean Mutombo', 'patient@sante.cd', NULL, NULL, 'patient', '$2y$12$WYRsODMoA0jVyhd/aBazM.yR4ObjBOUfnV3gDqnjtevKIjwTHmP/u', 0, 0, NULL, '2026-08-27 11:55:02', '2026-08-27 11:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `verification_tokens`
--

DROP TABLE IF EXISTS `verification_tokens`;
CREATE TABLE IF NOT EXISTS `verification_tokens` (
  `identifier` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires` datetime NOT NULL,
  UNIQUE KEY `token` (`token`),
  UNIQUE KEY `uq_identifier_token` (`identifier`,`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_1` FOREIGN KEY (`medecinId`) REFERENCES `medecins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultations_ibfk_2` FOREIGN KEY (`patientId`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `delivrances`
--
ALTER TABLE `delivrances`
  ADD CONSTRAINT `delivrances_ibfk_1` FOREIGN KEY (`prescriptionId`) REFERENCES `prescriptions_medicales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `delivrances_ibfk_2` FOREIGN KEY (`medicamentId`) REFERENCES `medicaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `delivrances_ibfk_3` FOREIGN KEY (`delivrePar`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `examens_medicaux`
--
ALTER TABLE `examens_medicaux`
  ADD CONSTRAINT `examens_medicaux_ibfk_1` FOREIGN KEY (`consultationId`) REFERENCES `consultations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interactions_medicamenteuses`
--
ALTER TABLE `interactions_medicamenteuses`
  ADD CONSTRAINT `interactions_medicamenteuses_ibfk_1` FOREIGN KEY (`medicamentId`) REFERENCES `medicaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interactions_medicamenteuses_ibfk_2` FOREIGN KEY (`medicamentAssocieId`) REFERENCES `medicaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medecins`
--
ALTER TABLE `medecins`
  ADD CONSTRAINT `medecins_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medecins_ibfk_2` FOREIGN KEY (`hopitalId`) REFERENCES `hopitaux` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prescriptions_medicales`
--
ALTER TABLE `prescriptions_medicales`
  ADD CONSTRAINT `prescriptions_medicales_ibfk_1` FOREIGN KEY (`consultationId`) REFERENCES `consultations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prescription_medicaments`
--
ALTER TABLE `prescription_medicaments`
  ADD CONSTRAINT `prescription_medicaments_ibfk_1` FOREIGN KEY (`prescriptionId`) REFERENCES `prescriptions_medicales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prescription_medicaments_ibfk_2` FOREIGN KEY (`medicamentId`) REFERENCES `medicaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD CONSTRAINT `rendez_vous_ibfk_1` FOREIGN KEY (`patientId`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rendez_vous_ibfk_2` FOREIGN KEY (`medecinId`) REFERENCES `medecins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resultats_laboratoire`
--
ALTER TABLE `resultats_laboratoire`
  ADD CONSTRAINT `resultats_laboratoire_ibfk_1` FOREIGN KEY (`examenId`) REFERENCES `examens_medicaux` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resultats_laboratoire_ibfk_2` FOREIGN KEY (`laboratoireId`) REFERENCES `laboratoires` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
