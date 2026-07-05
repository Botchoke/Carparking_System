-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2026 at 10:40 AM
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
-- Database: `hypercar_parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `plate_number` varchar(20) DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `slot_number` int(11) DEFAULT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `total_fee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `plate_number`, `owner_name`, `slot_number`, `time_in`, `time_out`, `total_fee`) VALUES
(26, 'asda', 'asdasd', 333, '2026-07-05 16:05:09', '2026-07-05 10:18:06', 20),
(27, 'ABC-124', 'asdasd', 34, '2026-07-05 16:18:16', '2026-07-05 10:27:29', 20),
(28, 'ABC-124', 'asdasd', 34, '2026-07-05 16:22:56', '2026-07-05 10:27:30', 20),
(29, 'asda', 'asdasd', 22, '2026-07-05 16:26:27', '2026-07-05 10:27:31', 20),
(30, 'ABC-124', 'asdasd', 22, '2026-07-05 16:28:22', '2026-07-05 10:30:18', 50),
(31, 'adasd', 'jacob besni with lambo', 22, '2026-07-05 16:28:32', '2026-07-05 10:30:19', 50),
(32, 'asda', 'jacob besni with lambo', 22, '2026-07-05 16:28:45', '2026-07-05 10:30:20', 50),
(33, 'ABC-124', 'asdasd', 22, '2026-07-05 16:29:20', '2026-07-05 10:30:23', 50),
(34, 'asda', 'jacob besni with lambo', 22, '2026-07-05 16:30:16', '2026-07-05 10:30:24', 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(11, 'freddylol_2sc', '1256'),
(12, 'charles', '2356'),
(13, 'buburt', '2356'),
(14, 'charles', '5623'),
(15, 'buburt', '123456'),
(16, 'freddylol_2sc', '123456'),
(17, 'buburt', '1256'),
(18, 'buburt', '1256'),
(19, 'freddylol_2sc', '123456'),
(20, 'freddylol_2sc', '123456'),
(21, 'joli', '0956'),
(22, 'buburt', '123456'),
(23, 'bu', '256'),
(24, 'noo', '256'),
(25, 'jacobwithlambo', '123456'),
(26, 'freddylol_2sc', '1234'),
(27, 'buburt', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `plate_number` varchar(20) DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `slot_number` int(11) DEFAULT NULL,
  `time_in` datetime DEFAULT current_timestamp(),
  `fee` int(11) DEFAULT 25
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `plate_number`, `owner_name`, `slot_number`, `time_in`, `fee`) VALUES
(35, 'ABC-124', 'jacob', 22, '2026-07-05 16:30:28', 25),
(36, 'asda', 'asdasd', 22, '2026-07-05 16:34:55', 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
