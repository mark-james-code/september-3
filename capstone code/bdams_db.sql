-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2024 at 02:21 AM
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
-- Database: `bdams_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cleanup_drive`
--

CREATE TABLE `cleanup_drive` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(3) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `zone` varchar(50) NOT NULL,
  `qr_code_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cleanup_drive`
--

INSERT INTO `cleanup_drive` (`id`, `name`, `age`, `sex`, `zone`, `qr_code_url`) VALUES
(2, 'mark james delos santos', 22, 'Male', 'zone 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20mark%20james%20delos%20santos%2C%20Zone%3A%20zone%201'),
(3, 'SANTOS, FATIMA', 24, 'Female', 'ZONE 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20SANTOS%2C%20FATIMA%2C%20Zone%3A%20ZONE%201'),
(4, 'mark james delos santos', 22, 'Male', 'zone 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20mark%20james%20delos%20santos%2C%20Zone%3A%20zone%201'),
(5, 'SANTOS, FATIMA', 24, 'Female', 'ZONE 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20SANTOS%2C%20FATIMA%2C%20Zone%3A%20ZONE%201'),
(6, 'mark james delos santos', 22, 'Male', 'zone 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20mark%20james%20delos%20santos%2C%20Zone%3A%20zone%201'),
(8, 'SANTOS, FATIMA', 24, 'Female', 'ZONE 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20SANTOS%2C%20FATIMA%2C%20Zone%3A%20ZONE%201'),
(11, 'mark james delos santos', 22, 'Male', 'zone 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20mark%20james%20delos%20santos%2C%20Zone%3A%20zone%201'),
(12, 'SANTOS, FATIMA', 24, 'Female', 'ZONE 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20SANTOS%2C%20FATIMA%2C%20Zone%3A%20ZONE%201');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `zone` varchar(50) NOT NULL,
  `qr_code_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `name`, `age`, `sex`, `zone`, `qr_code_url`) VALUES
(3, 'mark james delos santos', 22, 'Male', 'zone 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20mark%20james%20delos%20santos%2C%20Zone%3A%20zone%201'),
(4, 'SANTOS, FATIMA', 24, 'Female', 'ZONE 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20SANTOS%2C%20FATIMA%2C%20Zone%3A%20ZONE%201'),
(5, 'pogi', 22, 'Male', 'ZONE 1', 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Name%3A%20pogi%2C%20Zone%3A%20ZONE%201');

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`username`, `password`) VALUES
('DALLA', 'dalla');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cleanup_drive`
--
ALTER TABLE `cleanup_drive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cleanup_drive`
--
ALTER TABLE `cleanup_drive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
