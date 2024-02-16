-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 07:17 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `locationId` int(11) NOT NULL,
  `locationName` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `rates` varchar(255) NOT NULL,
  `ratesLate` varchar(255) NOT NULL,
  `capacity` int(4) NOT NULL,
  `occupied` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`locationId`, `locationName`, `description`, `address`, `rates`, `ratesLate`, `capacity`, `occupied`) VALUES
(1, 'Ang Mo Kio', 'Its a parking location at Ang Mo Kio.', '701 Ang Mo Kio Ave 3, Singapore 5607013', '1', '3', 5, 5),
(2, 'Hougang', 'Its a parking location at Hougang.', 'Lor 2 Realty Park', '1', '3', 6, 0),
(3, '229 Hougang Street 21 Multistorey Car Park', 'Its a parking location at Hougang.', '229 Hougang St 21, Singapore 530229', '1', '3', 3, 0),
(4, 'HG36', 'Its a parking location at Serangoon.', 'Upper Serangoon Rd, Singapore 530705', '1', '3', 10, 0),
(5, 'Bishan-Ang Mo Kio Park Carpark A', 'Its a parking location at Ang Mo Kio, despite the name.', '1380 Ang Mo Kio Ave 1, Singapore 569930', '1', '3', 5, 0),
(6, 'Clementi Mall Car Park Entrance', 'Its a parking location at Clementi Mall!', '3150 Commonwealth Ave W, Singapore 129580', '1', '3', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `parkingslots`
--

CREATE TABLE `parkingslots` (
  `slotId` int(11) NOT NULL,
  `locationId` int(11) DEFAULT NULL,
  `availability` int(1) DEFAULT NULL,
  `slotNum` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parkingslots`
--

INSERT INTO `parkingslots` (`slotId`, `locationId`, `availability`, `slotNum`) VALUES
(1, 1, 0, 1),
(2, 1, 0, 2),
(3, 1, 0, 3),
(4, 1, 0, 4),
(5, 1, 0, 5),
(6, 2, 1, 1),
(7, 2, 1, 2),
(8, 2, 1, 3),
(9, 2, 1, 4),
(10, 2, 1, 5),
(11, 2, 1, 6),
(12, 3, 1, 1),
(13, 3, 1, 2),
(14, 3, 1, 3),
(15, 4, 1, 1),
(16, 4, 1, 2),
(17, 4, 1, 3),
(18, 4, 1, 4),
(19, 4, 1, 5),
(20, 4, 1, 6),
(21, 4, 1, 7),
(22, 4, 1, 8),
(23, 4, 1, 9),
(24, 4, 1, 10),
(25, 5, 1, 1),
(26, 5, 1, 2),
(27, 5, 1, 3),
(28, 5, 1, 4),
(29, 5, 1, 5),
(30, 6, 1, 1),
(31, 6, 1, 2),
(32, 6, 1, 3),
(33, 6, 1, 4),
(34, 6, 1, 5),
(35, 6, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `slotId` int(11) DEFAULT NULL,
  `startTime` varchar(255) DEFAULT NULL,
  `endTime` varchar(255) DEFAULT NULL,
  `totalCost` varchar(255) DEFAULT NULL,
  `actualDuration` int(3) DEFAULT NULL,
  `intendedDuration` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionId`, `userId`, `slotId`, `startTime`, `endTime`, `totalCost`, `actualDuration`, `intendedDuration`) VALUES
(1, 2, 1, '2024-02-20 23:23', NULL, NULL, 3, 1),
(2, 2, 30, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(3, 2, 2, '2024-02-19 23:23', NULL, NULL, 3, 1),
(4, 2, 3, '2024-02-20 23:23', NULL, NULL, 3, 1),
(5, 2, 4, '2024-02-19 23:23', NULL, NULL, 3, 1),
(6, 2, 5, '2024-02-20 23:23', NULL, NULL, 3, 1),
(7, 2, 6, '2024-02-21 23:23', '2024-02-22 00:23', '7', 3, 1),
(8, 2, 6, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(9, 2, 6, '2024-02-20 23:23', '2024-02-21 00:23', '7', 3, 1),
(10, 2, 6, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(11, 2, 6, '2024-02-20 23:23', '2024-02-21 00:23', '7', 3, 1),
(12, 2, 6, '2024-02-20 23:23', '2024-02-21 00:23', '7', 3, 1),
(13, 2, 6, '2024-02-20 23:23', '2024-02-21 00:23', '7', 3, 1),
(14, 2, 6, '2024-02-21 23:22', '2024-02-22 00:22', '7', 3, 1),
(15, 2, 6, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(16, 2, 6, '2024-02-19 23:23', '2024-02-20 02:23', '3', 3, 3),
(17, 2, 6, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(18, 2, 6, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(19, 2, 6, '2024-02-19 23:23', '2024-02-20 02:23', '3', 1, 3),
(20, 2, 6, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(21, 2, 6, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(22, 2, 6, '2024-02-19 23:23', '2024-02-20 00:23', '7', 3, 1),
(23, 2, 6, '2024-02-19 23:23', '2024-02-20 02:23', '3', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `profileId` int(11) NOT NULL,
  `profileName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`profileId`, `profileName`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phoneNum` int(8) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `userProfileId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `password`, `firstName`, `surname`, `phoneNum`, `emailAddress`, `userProfileId`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 90140928, 'admin@gmail.com', 1),
(2, 'user1', 'user1', 'Tom', 'Brady', 94861325, 'tom@gmail.com', 2),
(3, 'user2', 'user2', 'Oliver', 'Turner', 96543217, 'oliver@gmail.com', 2),
(4, 'user3', 'user3', 'Isabella', 'Rodriguez', 92047856, 'isabell@gmail.com', 2),
(5, 'user4', 'user4', 'Jackson', 'Foster', 98321456, 'jackson@gmail.com', 2),
(7, 'admin2', 'admin2', 'admin2', 'admin2', 93216754, 'admin2@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`locationId`);

--
-- Indexes for table `parkingslots`
--
ALTER TABLE `parkingslots`
  ADD PRIMARY KEY (`slotId`),
  ADD KEY `locationId` (`locationId`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `slotId` (`slotId`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`profileId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `userProfileId` (`userProfileId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `locationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `parkingslots`
--
ALTER TABLE `parkingslots`
  MODIFY `slotId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `userprofile`
--
ALTER TABLE `userprofile`
  MODIFY `profileId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parkingslots`
--
ALTER TABLE `parkingslots`
  ADD CONSTRAINT `parkingslots_ibfk_1` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`slotId`) REFERENCES `parkingslots` (`slotId`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`userProfileId`) REFERENCES `userprofile` (`profileId`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
