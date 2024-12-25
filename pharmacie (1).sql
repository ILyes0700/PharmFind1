-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 20, 2024 at 10:26 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacie`
--

-- --------------------------------------------------------

--
-- Table structure for table `entreprise`
--

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `passworde` varchar(255) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `datee` date DEFAULT NULL,
  `address1` text,
  `address2` text,
  `statee` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `typee` varchar(50) DEFAULT NULL,
  `nom_de_entreprise` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_nom_de_entreprise` (`nom_de_entreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=9660192 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `entreprise`
--

INSERT INTO `entreprise` (`id`, `email`, `tel`, `passworde`, `nom`, `prenom`, `gender`, `datee`, `address1`, `address2`, `statee`, `zip`, `typee`, `nom_de_entreprise`) VALUES
(4919752, 'ilyesrejeb12@gmail.com', '27704669', '12345678', 'rejeb', 'ilyes', 'H', '2024-12-20', 'chenini', 'chenini 6041 rue farhed hached', 'Manouba', '6041', 'Livrire', 'rapido'),
(9660191, 'ilyesrejeb12@gmail.com', '27700069', '12345678', 'rejeb', 'ilyes', 'H', '2024-12-18', 'chenini', 'chenini 6041 rue farhed hached', 'Kairouan', '6041', 'Livreur', 'delivry');

-- --------------------------------------------------------

--
-- Table structure for table `med`
--

DROP TABLE IF EXISTS `med`;
CREATE TABLE IF NOT EXISTS `med` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `imagee` varchar(255) NOT NULL,
  `disce` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  KEY `fk_med_phar` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `med`
--

INSERT INTO `med` (`id`, `nom`, `imagee`, `disce`, `prix`) VALUES
(1, 'doliprane', 'uploads/dol1.jpg', 'hf snvbldsjv qjb ', 7.80),
(1, 'arct', 'uploads/act.webp', 'jbhd hjfhsq fbv djvnqd vj', 3.52),
(12, 'Doliprane', 'doliprane.jpg', 'Antidouleur couramment utilisé', 5.99),
(14, 'Aspirine', 'uploads/aspirine.jpg', 'Antidouleur, antipyrétique', 3.49),
(14, 'Ibuprofène', 'uploads/aspirine.jpg', 'Anti-inflammatoire non stéroïdien', 7.50),
(12, 'Paracétamol', 'paracetamol.jpg', 'Médicament contre la fièvre et la douleur', 2.99),
(11, 'Amoxicilline', 'amoxicilline.jpg', 'Antibiotique à large spectre', 10.00),
(17, 'Cafégène', 'cafegene.jpg', 'Médicament contre les maux de tête', 4.49),
(14, 'Lorazépam', 'uploads/aspirine.jpg', 'Anxiolytique, traitement de l\'anxiété', 15.00),
(14, 'Oméprazole', 'uploads/aspirine.jpg', 'Inhibiteur de la pompe à protons', 12.99),
(12, 'Cotrimoxazole', 'cotrimoxazole.jpg', 'Antibiotique utilisé pour traiter les infections bactériennes', 8.20),
(13, 'Loratadine', 'loratadine.jpg', 'Antihistaminique pour les allergies', 6.70),
(13, 'Metformine', 'metformine.jpg', 'Antidiabétique pour traiter le diabète de type 2', 13.50),
(12, 'Furosemide', 'furosemide.jpg', 'Diurétique utilisé pour traiter l\'hypertension', 4.80),
(13, 'Amlodipine', 'amlodipine.jpg', 'Médicament pour traiter l\'hypertension', 9.90),
(14, 'Benzodiazépine', 'uploads/aspirine.jpg', 'Médicament anxiolytique', 11.20),
(15, 'Ranitidine', 'ranitidine.jpg', 'Antiacide utilisé pour traiter les ulcères', 5.40),
(16, 'Prednisolone', 'prednisolone.jpg', 'Corticostéroïde utilisé pour traiter l\'inflammation', 14.30),
(17, 'Clopidogrel', 'clopidogrel.jpg', 'Médicament pour prévenir les AVC et les crises cardiaques', 22.99),
(14, 'Simvastatine', 'uploads/aspirine.jpg', 'Médicament pour abaisser le cholestérol', 18.90),
(19, 'Sertraline', 'sertraline.jpg', 'Antidépresseur utilisé pour traiter les troubles de l\'humeur', 25.00),
(12, 'Fluoxétine', 'fluoxetine.jpg', 'Antidépresseur utilisé pour traiter la dépression', 23.70),
(15, 'Salbutamol', 'salbutamol.jpg', 'Bronchodilatateur pour traiter l\'asthme', 4.00),
(17, 'Dexaméthasone', 'dexamethasone.jpg', 'Corticostéroïde pour traiter les inflammations graves', 11.50),
(13, 'Lévothyroxine', 'levothyroxine.jpg', 'Médicament pour traiter l\'hypothyroïdie', 15.70),
(13, 'Hydrochlorothiazide', 'hydrochlorothiazide.jpg', 'Diurétique pour traiter l\'hypertension', 8.50),
(17, 'Ciprofloxacine', 'ciprofloxacine.jpg', 'Antibiotique utilisé pour traiter diverses infections', 12.80);

-- --------------------------------------------------------

--
-- Table structure for table `passient`
--

DROP TABLE IF EXISTS `passient`;
CREATE TABLE IF NOT EXISTS `passient` (
  `email` varchar(50) NOT NULL,
  `tel` varchar(8) NOT NULL,
  `passworde` varchar(45) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `datee` varchar(45) DEFAULT NULL,
  `address1` varchar(45) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `statee` varchar(45) DEFAULT NULL,
  `zip` varchar(45) DEFAULT NULL,
  `typee` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `passient`
--

INSERT INTO `passient` (`email`, `tel`, `passworde`, `nom`, `prenom`, `gender`, `datee`, `address1`, `address2`, `statee`, `zip`, `typee`) VALUES
('rejeb424@gmail.com', '96325811', 'ilyes200', 'ilyes', 'rejeb', 'H', '2024-12-18', 'chenini 6041', 'chenini 6041 rue farhed hached', 'Cabes', '6041', 'Pasient');

-- --------------------------------------------------------

--
-- Table structure for table `phar`
--

DROP TABLE IF EXISTS `phar`;
CREATE TABLE IF NOT EXISTS `phar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `tel` varchar(8) NOT NULL,
  `passworde` varchar(45) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `gender` varchar(45) NOT NULL,
  `datee` date NOT NULL,
  `address1` varchar(45) NOT NULL,
  `address2` varchar(45) NOT NULL,
  `statee` varchar(45) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `typee` varchar(45) NOT NULL,
  `nomphar` varchar(30) NOT NULL,
  PRIMARY KEY (`id`,`tel`)
) ENGINE=InnoDB AUTO_INCREMENT=4393292 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `phar`
--

INSERT INTO `phar` (`id`, `email`, `tel`, `passworde`, `nom`, `prenom`, `gender`, `datee`, `address1`, `address2`, `statee`, `zip`, `typee`, `nomphar`) VALUES
(1, '', '27704669', '74125896', 'asma', 'ahmed', 'H', '2024-12-19', 'gabes center', 'beb bhar ', 'Gabes', '4784', 'Pharmacien', 'rejeb'),
(11, '', '28314730', 'azert123', 'Mohamed', 'Faleh', 'H', '2024-12-26', 'Rahab Chenin', 'Chenini Gabes', 'Gabes', '6041', 'Pharmacien', 'Chenin'),
(12, '', '69321658', 'azert123', 'Ahmed', 'Ahmed', 'H', '2009-07-24', 'Chenini 6041', 'Chenini 6041 Rue Farhed Hached', 'Manouba', '5621', 'Pharmacien', 'Farhed'),
(13, '', '27865934', 'sarah1234', 'Sarah', 'Meriem', 'F', '2022-08-15', 'Tunis Centre', 'Ariana Ville', 'Tunis', '1000', 'Pharmacien', 'Meriem'),
(14, '', '29176253', 'ali1234', 'Ali', 'Tounsi', 'H', '2023-05-11', 'Sousse Avenue', 'La Marsa', 'Tunis', '4020', 'Pharmacien', 'Tounsi'),
(15, '', '28164379', 'password123', 'Samia', 'Dhaoui', 'F', '2021-09-05', 'Bizerte', 'Rte du Lac', 'Gabes', '7000', 'Pharmacien', 'Dhaoui'),
(16, '', '29873462', 'hassan1234', 'Hassan', 'Boussaid', 'H', '2019-06-20', 'Kairouan', 'Rue Hadhra', 'Kairouan', '3120', 'Pharmacien', 'Boussaid'),
(17, '', '29034567', 'passwordMouna', 'Mouna', 'Ziani', 'F', '2023-02-10', 'Jendouba', 'Centre Ville', 'Jendouba', '8100', 'Pharmacien', 'Ziani'),
(18, '', '27644588', 'sami5678', 'Sami', 'Ben Hassen', 'H', '2018-03-25', 'Sfax', 'Sidi Mansour', 'Sfax', '3000', 'Pharmacien', 'Ben Hassen'),
(19, '', '29567891', 'khaled1234', 'Khaled', 'Mansouri', 'H', '2020-11-12', 'Nabeul', 'Hammamet', 'Nabeul', '8000', 'Pharmacien', 'Mansouri');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacie_livraison`
--

DROP TABLE IF EXISTS `pharmacie_livraison`;
CREATE TABLE IF NOT EXISTS `pharmacie_livraison` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email_patient` varchar(255) NOT NULL,
  `entreprise` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `medicament_nom` varchar(255) NOT NULL,
  `medicament_quantite` int NOT NULL,
  `medicament_prix` decimal(10,3) NOT NULL,
  `total` decimal(10,3) NOT NULL,
  `datee` date NOT NULL,
  `pharmacy_id` int DEFAULT NULL,
  `email_sent` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_medicaments`
--

DROP TABLE IF EXISTS `pharmacy_medicaments`;
CREATE TABLE IF NOT EXISTS `pharmacy_medicaments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_medicament` varchar(255) DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `prix` decimal(10,3) DEFAULT NULL,
  `pharmacy_id` int DEFAULT NULL,
  `datee` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `med`
--
ALTER TABLE `med`
  ADD CONSTRAINT `fk_med_phar` FOREIGN KEY (`id`) REFERENCES `phar` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
