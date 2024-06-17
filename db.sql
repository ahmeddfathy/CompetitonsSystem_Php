-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2024 at 07:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aml`
--

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE `competitions` (
  `competitionName` varchar(255) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`competitionName`, `score`, `type`, `description`) VALUES
('football', 30, 'team', 'klkk');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `competitionName` varchar(255) DEFAULT NULL,
  `teamName` varchar(255) DEFAULT NULL,
  `memberName` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`competitionName`, `teamName`, `memberName`, `type`) VALUES
('football', 'webers10', 'b,c,d,e', 'team '),
('football', 'magic3', 'a,b,c,d,e', 'team '),
('football', 'weber', 'k,m,l,p,r', 'team ');

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `competitionName` varchar(255) DEFAULT NULL,
  `teamName` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `completed` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`competitionName`, `teamName`, `score`, `type`, `completed`) VALUES
('football', 'webers10', 8, 'team', 'sllss');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `username`, `password`, `type`) VALUES
('ahmeddfathy087@gmail.com', 'ahmed fathi', '$2y$10$nh4YfUyBCrOXBasniPUPOOSO8K13K0HM4EcrNRJhZ07LR2rMP6k7K', 'team'),
('ahmeddfathy0871@gmail.com', 'fathii', '$2y$10$xk/dOirgioAMumu5whlHpuC2BRh44X9y/ASnibnmvz3nDWXqV3RY6', 'alone');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`competitionName`),
  ADD KEY `idx_competitionName` (`competitionName`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD KEY `idx_teamName` (`teamName`),
  ADD KEY `fk_competition` (`competitionName`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD KEY `competitionName` (`competitionName`),
  ADD KEY `score_ibfk_2` (`teamName`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `fk_competition` FOREIGN KEY (`competitionName`) REFERENCES `competitions` (`competitionName`) ON DELETE CASCADE,
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`competitionName`) REFERENCES `competitions` (`competitionName`);

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`competitionName`) REFERENCES `competitions` (`competitionName`),
  ADD CONSTRAINT `score_ibfk_2` FOREIGN KEY (`teamName`) REFERENCES `participants` (`teamName`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
