-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2025 at 08:07 PM
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
-- Database: `studyhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `time_plan` int(11) NOT NULL,
  `study_table` varchar(50) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `st_status` varchar(20) DEFAULT 'in_use'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `username`, `time_plan`, `study_table`, `start_time`, `end_time`, `st_status`) VALUES
(8, 'dan', 30, 'S1', '2025-08-04 20:35:04', NULL, 'ended'),
(9, 'dan', 30, 'S2', '2025-08-04 20:43:45', NULL, 'ended'),
(10, 'dan', 30, 'S2', '2025-08-04 20:44:37', NULL, 'ended'),
(11, 'dan', 30, 'S1', '2025-08-04 20:45:29', '2025-08-05 02:47:01', 'ended'),
(12, 'dan', 30, 'S1', '2025-08-04 20:47:18', '2025-08-05 02:47:32', 'ended'),
(13, 'ry', 30, 'S2', '2025-08-06 19:42:05', '2025-08-07 01:42:11', 'ended'),
(14, 'dan', 30, 'S1', '2025-08-06 19:42:46', '2025-08-06 19:42:53', 'ended'),
(15, 'dan', 30, 'S2', '2025-08-06 19:42:59', '2025-08-06 19:43:49', 'ended'),
(16, 'dan', 60, 'S1', '2025-08-06 19:46:42', '2025-08-06 19:46:50', 'ended'),
(17, 'dan', 30, 'S1', '2025-08-06 19:48:07', '2025-08-06 19:48:16', 'ended'),
(18, 'dan', 60, 'S1', '2025-08-06 19:52:01', '2025-08-06 19:52:04', 'ended'),
(19, 'dan', 60, 'S1', '2025-08-06 19:59:38', '2025-08-06 20:05:54', 'ended'),
(20, 'ry', 30, 'S1', '2025-08-06 20:06:03', '2025-08-07 02:15:05', 'ended'),
(21, 'ry', 30, 'S1', '2025-08-06 20:15:11', '2025-08-06 20:15:29', 'ended'),
(22, 'ry', 30, 'S1', '2025-08-06 20:23:15', '2025-08-06 20:23:18', 'ended'),
(23, 'dan', 30, 'S2', '2025-08-06 20:23:31', '2025-08-06 20:23:35', 'ended'),
(24, 'dan', 30, 'S1', '2025-08-06 20:31:22', '2025-08-06 20:31:39', 'ended'),
(25, 'dan', 30, 'S1', '2025-08-06 20:31:54', '2025-08-06 20:32:27', 'ended'),
(26, 'dan', 30, 'S1', '2025-08-06 20:35:20', '2025-08-06 20:35:54', 'ended'),
(27, 'dan', 30, 'S1', '2025-08-06 20:37:08', '2025-08-06 20:37:36', 'ended'),
(28, 'dan', 30, 'S1', '2025-08-06 20:38:22', '2025-08-06 20:38:27', 'ended'),
(29, 'dan', 30, 'S1', '2025-08-07 06:08:23', '2025-08-07 06:10:20', 'ended'),
(30, 'ry', 60, 'S1', '2025-08-07 06:10:56', '2025-08-07 06:16:39', 'ended'),
(31, 'dan', 30, 'S1', '2025-08-07 06:17:48', '2025-08-07 06:17:53', 'ended'),
(32, 'dan', 30, 'S1', '2025-08-07 06:18:00', '2025-08-07 06:18:04', 'ended'),
(33, 'ry', 30, 'S1', '2025-08-07 06:23:00', '2025-08-07 06:23:24', 'ended'),
(34, 'ry', 30, 'S1', '2025-08-07 06:26:41', '2025-08-07 06:26:42', 'ended'),
(35, 'dan', 30, 'S1', '2025-08-07 06:26:48', '2025-08-07 06:27:00', 'ended'),
(36, 'dan', 30, 'S1', '2025-08-07 06:31:16', '2025-08-07 06:31:17', 'ended'),
(37, 'dan', 30, 'S1', '2025-08-07 06:31:22', '2025-08-07 06:32:54', 'ended'),
(38, 'ry', 60, 'S1', '2025-08-07 06:33:02', '2025-08-07 06:36:05', 'ended'),
(39, 'ry', 60, 'S1', '2025-08-07 06:36:14', '2025-08-07 06:36:15', 'ended'),
(40, 'dan', 30, 'S1', '2025-08-07 06:36:20', '2025-08-07 06:36:37', 'ended'),
(41, 'dan', 30, 'S1', '2025-08-07 08:08:41', '2025-08-07 08:09:24', 'ended'),
(42, 'ry', 30, 'S3', '2025-08-07 08:11:16', '2025-08-07 08:11:31', 'ended'),
(43, 'ry', 60, 'S1', '2025-08-07 08:12:34', '2025-08-07 08:13:00', 'ended'),
(44, 'ry', 30, 'S1', '2025-08-07 08:51:31', '2025-08-08 20:00:06', 'ended');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `type` varchar(20) DEFAULT 'basic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `type`) VALUES
(12, 'dan', 'basic'),
(19, 'ry', 'basic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
