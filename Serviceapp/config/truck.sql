-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 08:28 PM
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
-- Database: `truck`
--

-- --------------------------------------------------------

--
-- Table structure for table `mechanic`
--

CREATE TABLE `mechanic` (
  `mechanic_id` int(250) NOT NULL,
  `mechanic_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mechanic`
--

INSERT INTO `mechanic` (`mechanic_id`, `mechanic_name`) VALUES
(1, 'Royd Fungika');

-- --------------------------------------------------------

--
-- Table structure for table `service_records`
--

CREATE TABLE `service_records` (
  `service_id` int(11) NOT NULL,
  `truck_id` int(11) NOT NULL,
  `service_date` date NOT NULL,
  `service_kilometers` int(11) NOT NULL,
  `next_due_kilometers` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `jobcard_number` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_records`
--

INSERT INTO `service_records` (`service_id`, `truck_id`, `service_date`, `service_kilometers`, `next_due_kilometers`, `created_by`, `created_at`, `jobcard_number`) VALUES
(1, 1, '2024-01-15', 15000, 25000, 1, '2026-03-17 21:29:26', '');

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `truck_id` int(11) NOT NULL,
  `number_plate` varchar(20) NOT NULL,
  `model` varchar(100) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trucks`
--

INSERT INTO `trucks` (`truck_id`, `number_plate`, `model`, `driver_id`, `created_at`) VALUES
(1, 'KA01AB1234', 'Volvo FH16', 2, '2026-03-17 21:29:26'),
(2, 'BBC2020', 'sino', NULL, '2026-04-09 18:06:51'),
(3, 'BBA2010', 'faw', NULL, '2026-04-09 18:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` enum('admin','driver') DEFAULT 'driver',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `user_type`, `created_at`) VALUES
(1, 'admin', '$2y$10$h.ZzLYng3AKYlc7COmTd4OVD.lSRqhEvhXqlBqxagNVwvGkmz0ZJ2', 'admin@truckmgmt.com', 'admin', '2026-03-17 21:29:26'),
(2, 'john_doe', '$2y$10$YourHashedPasswordHere', 'john@example.com', 'driver', '2026-03-17 21:29:26'),
(3, 'Shadrick', '$2y$10$slMe8iVPHrFAjN.6F2UZYuhuGidFnfD.9kxhaKPyluTmpD7R8pTca', 'shad@gmail.com', 'driver', '2026-03-17 22:00:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mechanic`
--
ALTER TABLE `mechanic`
  ADD PRIMARY KEY (`mechanic_id`);

--
-- Indexes for table `service_records`
--
ALTER TABLE `service_records`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `truck_id` (`truck_id`),
  ADD KEY `fk_service_created_by` (`created_by`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`truck_id`),
  ADD UNIQUE KEY `truck_number` (`number_plate`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mechanic`
--
ALTER TABLE `mechanic`
  MODIFY `mechanic_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_records`
--
ALTER TABLE `service_records`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trucks`
--
ALTER TABLE `trucks`
  MODIFY `truck_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `service_records`
--
ALTER TABLE `service_records`
  ADD CONSTRAINT `fk_service_created_by` FOREIGN KEY (`created_by`) REFERENCES `mechanic` (`mechanic_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `service_records_ibfk_1` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`truck_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_records_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `trucks`
--
ALTER TABLE `trucks`
  ADD CONSTRAINT `trucks_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
