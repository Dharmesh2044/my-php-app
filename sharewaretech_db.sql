-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2026 at 06:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sharewaretech_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `otp_code`, `otp_expiry`) VALUES
(1, 'sharewaretech@gmail.com', '$2y$10$kKb5lzLg/HxuXEdz7A8AYesZgeG9q.z3G3Og8nqXWgUZz5J9fYqSS', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `plan` enum('Basic','Premium') DEFAULT 'Basic',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `email`, `company`, `plan`, `status`, `created_at`) VALUES
(6, 'dharmesh', '990222233', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-21 04:55:36'),
(9, 'dimondd', '99011', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 07:54:27'),
(10, 'dimondd', '99011', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 07:56:55'),
(12, 'dimondd', '99011', 'dim@gmail.comm', NULL, 'Basic', 'Active', '2026-04-23 07:59:12'),
(13, 'kanoo', '990112', 'd5@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 08:03:07'),
(14, 'dimondd', '99011', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 08:05:13'),
(15, 'dimondd', '9902222', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 08:05:28'),
(16, 'dimondd', '9902222', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 08:05:34'),
(17, 'dharmesh', '9902222', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 08:05:39'),
(18, 'dharmesh', '99022220', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 08:09:22'),
(19, 'dimondd', '9902222', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 10:26:07'),
(20, 'ramedev bhai', '9902222', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 10:27:23'),
(21, 'ramedev bhai', '9902222', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-23 10:39:25'),
(22, 'kanoo', '1234', 'd@gmail.com', NULL, 'Basic', 'Active', '2026-04-24 10:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `message`, `status`, `created_at`) VALUES
(2, 'dharmesh', 'd@gmail.com', '9904802044', 'ok', 'read', '2026-04-20 13:05:51'),
(3, 'dharmesh', 'd@gmail.com', '9904802044', 'ok', 'read', '2026-04-20 13:37:19'),
(5, 'ram', 'ram@gmail.com', '9920442044', 'i want to demo \r\n', 'read', '2026-04-21 13:09:03'),
(6, 'ram', 'ram@gmail.com', '9920442044', 'i want to demo \r\n', 'read', '2026-04-22 04:21:59'),
(7, 'ram', 'ram@gmail.com', '9920442044', 'i want to demo \r\n', 'read', '2026-04-22 06:52:54'),
(8, 'ram', 'ram@gmail.com', '9920442044', 'i want to demo \r\n', 'read', '2026-04-22 06:53:05'),
(10, 'dharmesh', 'd@gmail.com', '9904802044', 'y', 'read', '2026-04-23 09:10:40'),
(11, 'dharmesh', 'd@gmail.com', '9904802044', 'y', 'read', '2026-04-23 09:10:58'),
(12, 'dharmesh', 'd@gmail.com', '9904802044', 'y', 'read', '2026-04-23 09:14:10'),
(13, 'dharmesh', 'ramdev@gmail.com', '9904802044', 'ok', 'read', '2026-04-23 09:14:34'),
(14, 'dharmesh', 'ramdev@gmail.com', '9904802044', 'ok', 'read', '2026-04-23 09:14:49'),
(15, 'ramdev bhai', 'd@gmail.com', '9904802044', 'tt', 'read', '2026-04-23 09:17:26'),
(16, 'ram', '', '9904802044', '', 'read', '2026-04-23 09:18:27'),
(17, 'ram', 'd@gmail.com', '9904802044', 'www', 'read', '2026-04-23 09:30:52'),
(18, 'dharmesh dharmesh', 'dharmesh@gmail.com', '9904802044', 'demo', 'read', '2026-04-24 14:20:05'),
(19, 'dharmesh dharmesh', 'dharmesh@gmail.com', '9904802044', 'Agar aapne pehle se hi ek .NET project upload kiya hua hai, toh Ubuntu VPS par PHP aur HTML chalane ke liye aapko thoda dhyaan dena hoga, kyunki .NET aur PHP dono alag tarike se kaam karte hain.', 'read', '2026-04-24 14:23:17'),
(20, 'ramdev bhai', 'ramdev@gmail.com', '9904802044', 'seen messages\r\n', 'read', '2026-04-25 04:08:48'),
(21, 'ramshi', 'ramshi@gmail.com', '8530', 'Our expert team provides seamless technology integration for your jewelry business.', 'read', '2026-04-25 04:10:06'),
(22, 'ramdev bhai', 'ramdev@gmail.com', '9920442044', 'demo', 'read', '2026-04-25 10:59:20'),
(23, 'dharmesh dharmesh', 'ramdev@gmail.com', '9904802044', '', 'read', '2026-04-25 11:10:37'),
(24, 'khamshi', 'ramdev@gmail.com', '8530', '', 'new', '2026-04-25 11:30:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
