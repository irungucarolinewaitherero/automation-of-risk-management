-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2024 at 06:59 PM
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
-- Database: `risk`
--

-- --------------------------------------------------------

--
-- Table structure for table `risk_register`
--

CREATE TABLE `risk_register` (
  `id` int(11) NOT NULL,
  `risk_name` varchar(255) NOT NULL,
  `risk_description` text DEFAULT NULL,
  `risk_impact` varchar(255) DEFAULT NULL,
  `risk_likelihood` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `risk_score` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `Controls` varchar(255) DEFAULT NULL,
  `Inherent_Risk` varchar(255) DEFAULT NULL,
  `Owner` varchar(255) DEFAULT NULL,
  `Inherent_Impact` int(11) DEFAULT NULL,
  `inherent_Likelihood` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `risk_register`
--

INSERT INTO `risk_register` (`id`, `risk_name`, `risk_description`, `risk_impact`, `risk_likelihood`, `created_at`, `risk_score`, `status`, `Controls`, `Inherent_Risk`, `Owner`, `Inherent_Impact`, `inherent_Likelihood`) VALUES
(203, 'Spill info', 'sdnsjndsj', '1', '4', '2024-01-29 19:49:30', 4, 'Pending', 'vvvvvv', '25', 'vvvvvvvvv', 5, 5),
(208, 'ijei', 'erokfepkf', '1', '4', '2024-02-19 08:44:16', 4, 'Pending', 'ekmvek', '2', 'ekfek', 1, 2),
(209, 'oopkpko', 'fdkpokg', '1', '3', '2024-02-19 17:44:04', 3, 'Pending', 'epfep', '8', '4', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `FName` varchar(100) NOT NULL,
  `LName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `FName`, `LName`, `Email`, `username`, `password`) VALUES
(1, 'dsiofoe', 'mcpemoc', 'emrf@gmail.com', 'wenfiwo', '$2y$10$DKoDVSVjIVju/TlkLd9AN.Nixpas.zmw7jvHv3Z58Yck.RxxtO3gi'),
(2, 'nfjdnfkv', 'erielmkler', 'mombtrmo@gmail.com', 'ereiejiorj', '$2y$10$oVqLcwQS9SRSmjyeK7/NReZqb1mieLR310DFV5w3XBHNn9dIhff4i'),
(3, 'vmimbmf', 'momfmeo', 'mmvrie@gmail.com', 'eroeo', '$2y$10$9QyuUR74.DBg2TnYMlZcaOne6lDJqy0aSZy1OCfXu4Hj.V0BmIv3C'),
(4, 'Caroline', 'nceionc', 'caroline@gmail.com', 'Caroline', '$2y$10$AdVv9sd3E0Vvtg3Q4FQOE.CfOBHWnyK/x7mmj7e/6UzmhGNhkIuVC'),
(5, 'Sam', 'djid', 'sam@gmail.com', 'Sam', '$2y$10$GMX5KKoaZceFap4hlUB91eUYyXJhxfESmf0sWFJ7.VAzcu55GD63a'),
(6, 'felix', 'mkd', 'felix@gmail.com', 'felixm', '$2y$10$S.MHTTolcpU8rB/JgvWwJOi5FQWZT78wm82khAA4qpOaKsqnjaWoW'),
(7, 'mdokfmoee', 'erjivjeor', 'vneorn@gmail.com', 'neorn', '$2y$10$0SzkSubKoZf3hWviOBdGZerYYCQphfgTAGbujq90YgwEYaHqoFc8a'),
(8, 'lalal', 'kck', 'sdcjcn@gmail.com', 'nwof', '$2y$10$5y.Vv/QndSTxtevAtUjgw.4OizN2CGqfW9BmyhoQbuFZ4E7QE15RO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `risk_register`
--
ALTER TABLE `risk_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `risk_register`
--
ALTER TABLE `risk_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
