-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2026 at 08:02 AM
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
  `plate_number` varchar(50) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `slot_number` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime NOT NULL,
  `total_fee` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT 'Cash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `plate_number`, `owner_name`, `slot_number`, `time_in`, `time_out`, `total_fee`, `created_at`, `payment_method`) VALUES
(1, '1231', '123', 2, '2026-07-26 13:27:46', '2026-07-26 07:27:55', 50.00, '2026-07-26 05:27:55', 'Cash'),
(2, '12312', '3123', 4, '2026-07-26 13:28:11', '2026-07-26 07:28:36', 50.00, '2026-07-26 05:28:36', 'Cash'),
(3, '213', '123', 32, '2026-07-26 13:28:14', '2026-07-26 07:28:37', 50.00, '2026-07-26 05:28:37', 'Cash'),
(4, '231', '231', 312, '2026-07-26 13:28:17', '2026-07-26 07:28:38', 50.00, '2026-07-26 05:28:38', 'Cash'),
(5, '213', '34', 4, '2026-07-26 13:28:21', '2026-07-26 07:28:38', 50.00, '2026-07-26 05:28:38', 'Cash'),
(6, '3213', '34', 4, '2026-07-26 13:28:25', '2026-07-26 07:28:39', 50.00, '2026-07-26 05:28:39', 'Cash'),
(7, '213', '4324', 36, '2026-07-26 13:29:26', '2026-07-26 07:29:33', 50.00, '2026-07-26 05:29:33', 'Cash'),
(8, 'r', 'we', 3, '2026-07-26 13:34:26', '2026-07-26 07:34:35', 50.00, '2026-07-26 05:34:35', 'Cash'),
(9, 'QWS-123', 'Aldiano', 85, '2026-07-26 13:45:21', '2026-07-26 07:45:33', 50.00, '2026-07-26 05:45:33', 'Cash');

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
(2, 'Buburt22', '$2y$10$ERN/sGR2UuYApBhpS//5durwog2HcsSdunijuDH0kb7ZHGJdFQwMC'),
(3, 'Aldiano', '$2y$10$m9WZoNBo0vx7lB./c8AQxuxFVxaOoRvCCvFiV0Y6q0asTpo1Om/Yy');

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
  `fee` int(11) DEFAULT 25,
  `total_fee` decimal(10,2) DEFAULT 0.00,
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `plate_number`, `owner_name`, `slot_number`, `time_in`, `fee`, `total_fee`, `time_out`) VALUES
(48, 'RWD-123', 'Charles', 2, '2026-07-26 13:51:27', 25, 0.00, NULL),
(49, 'LAMBO-2226', 'Jully Bert', 3, '2026-07-26 13:51:56', 25, 0.00, NULL),
(50, 'BMW-2354', 'Jacob', 4, '2026-07-26 13:52:14', 25, 0.00, NULL),
(51, '23', 'titoy', 8, '2026-07-26 13:55:23', 25, 0.00, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
