-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 08:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `ID_account` int(11) NOT NULL,
  `username` varchar(55) DEFAULT NULL,
  `password` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`ID_account`, `username`, `password`) VALUES
(1, 'Miage', '123'),
(2, 'abdo', '2025');

-- --------------------------------------------------------

--
-- Table structure for table `db_client`
--

CREATE TABLE `db_client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(55) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `poste` varchar(45) DEFAULT NULL,
  `marternelle` varchar(45) DEFAULT NULL,
  `primaire` varchar(45) DEFAULT NULL,
  `college` varchar(45) DEFAULT NULL,
  `lycee` varchar(45) DEFAULT NULL,
  `ville` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `gmail` varchar(55) DEFAULT NULL,
  `status` tinytext NOT NULL DEFAULT '0',
  `dateCreated` date NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `db_client`
--

INSERT INTO `db_client` (`id_client`, `nom`, `prenom`, `categorie`, `poste`, `marternelle`, `primaire`, `college`, `lycee`, `ville`, `phone`, `gmail`, `status`, `dateCreated`, `created_by`) VALUES
(14, 'bentaleb', 'mehdi', 'Ecole', 'student', '0', '0', '0', '1', 'tanger', '06363696958', 'mehdi@gamil.com', '0', '2025-03-19', 'Miage'),
(15, 'ouellou', 'mohamed', 'Ecole superieure', 'developer full-stack', '0', '0', '1', '0', 'rabat', '0630829654', 'mohamed@gmail.com', '1', '2025-03-19', 'Miage'),
(16, 'aguid', 'abdo', 'Enseignment', 'developer java', '0', '0', '0', '1', 'tetouan', '07141425252', 'abdo@gmail.com', '0', '2025-03-19', 'Miage'),
(17, 'bouayad', 'ayoub', 'Persone', 'developer full-stack', '0', '0', '1', '0', 'oujda', '0714585263', 'ayoub@gmail.com', '1', '2025-03-19', 'Miage'),
(18, 'hamdy', 'chourouk', 'Persone', 'student', '0', '0', '0', '1', 'tanger', '0630829654', 'chourouk@gmail.com', '1', '2025-03-19', 'abdo'),
(19, 'stito', 'imad', 'Persone', 'developer full-stack', '0', '0', '0', '1', 'jedida', '0630829654', 'imad@gmail.com', '2', '2025-03-19', 'abdo'),
(20, 'ahmda', 'ahmad', 'Ecole', 'developer full-stack', '0', '0', '1', '0', 'agadir', '0714253636', 'abdo@gmail.com', '1', '2025-03-19', 'abdo');

-- --------------------------------------------------------

--
-- Table structure for table `gestion_entreprise`
--

CREATE TABLE `gestion_entreprise` (
  `id_client` int(50) NOT NULL,
  `matricule` int(150) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `categorie` enum('option1','option2','','') NOT NULL,
  `poste` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `gmail` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `dateCreated` date NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(50) NOT NULL,
  `zone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gestion_entreprise`
--

INSERT INTO `gestion_entreprise` (`id_client`, `matricule`, `nom`, `prenom`, `categorie`, `poste`, `ville`, `phone`, `gmail`, `status`, `dateCreated`, `created_by`, `zone`) VALUES
(30, 202501, 'mehdy', 'bentaleb', 'option1', 'student', 'Tanger', '0630829654', 'mohamedbentaleb@gmail.com', 0, '2025-04-13', 'Miage', 'Zone tanger'),
(31, 2002525, 'bentaleb', 'mohamed', 'option1', 'student', 'Rabat', '0714252536', 'mohamedbentaleb@gmail.com', 0, '2025-04-13', 'Miage', 'Zone Rabat'),
(32, 203252563, 'ahmady', 'ahmad', 'option1', 'developer java', 'Agadir', '0635253625', 'ahmad@gmail.com', 0, '2025-04-13', 'Miage', 'zone agarir 3');

-- --------------------------------------------------------

--
-- Table structure for table `setting_villes`
--

CREATE TABLE `setting_villes` (
  `id` int(11) NOT NULL,
  `ville` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting_villes`
--

INSERT INTO `setting_villes` (`id`, `ville`) VALUES
(17, 'Tanger'),
(18, 'Casablanca'),
(19, 'Rabat'),
(20, 'oujda'),
(21, 'Agadir');

-- --------------------------------------------------------

--
-- Table structure for table `setting_zones`
--

CREATE TABLE `setting_zones` (
  `id` int(11) NOT NULL,
  `zone_name` varchar(100) NOT NULL,
  `ville_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting_zones`
--

INSERT INTO `setting_zones` (`id`, `zone_name`, `ville_id`) VALUES
(1, 'casabarata', 9),
(2, 'casabarata', 1),
(3, 'cdo', 8),
(4, 'ww2', 8),
(5, 'Zone tanger', 17),
(6, 'Zone Casablanca', 18),
(7, 'Zone Rabat', 19),
(8, 'zone oujda 1', 20),
(9, 'zone oujda 2', 20),
(10, 'zone oujda 3', 20),
(11, 'zone agadir 1', 21),
(12, 'zone agarir 3', 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID_account`);

--
-- Indexes for table `db_client`
--
ALTER TABLE `db_client`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `gestion_entreprise`
--
ALTER TABLE `gestion_entreprise`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `setting_villes`
--
ALTER TABLE `setting_villes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_zones`
--
ALTER TABLE `setting_zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ID_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `db_client`
--
ALTER TABLE `db_client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gestion_entreprise`
--
ALTER TABLE `gestion_entreprise`
  MODIFY `id_client` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `setting_villes`
--
ALTER TABLE `setting_villes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `setting_zones`
--
ALTER TABLE `setting_zones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
