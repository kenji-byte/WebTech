-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 04:30 PM
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
-- Database: `aqi`
--

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `Id` int(50) NOT NULL,
  `City` text NOT NULL,
  `Country` text NOT NULL,
  `Aqi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`Id`, `City`, `Country`, `Aqi`) VALUES
(1, 'Dhaka', 'Bangladesh', '35'),
(2, 'Delhi', 'India', '220'),
(3, 'Beijing', 'China', '180'),
(4, 'Los Angeles', 'USA', '90'),
(5, 'London', 'UK', '55'),
(6, 'Paris', 'France', '60'),
(7, 'Tokyo', 'Japan', '45'),
(8, 'Karachi', 'Pakistan', '160'),
(9, 'Cairo', 'Egypt', '120'),
(10, 'Jakarta', 'Indonesia', '130'),
(11, 'Moscow', 'Russia', '75'),
(12, 'Madrid', 'Spain', '50'),
(13, 'Rome', 'Italy', '65'),
(14, 'Bangkok', 'Thailand', '140'),
(15, 'Istanbul', 'Turkey', '95'),
(16, 'Lagos', 'Nigeria', '110'),
(17, 'Nairobi', 'Kenya', '85'),
(18, 'Santiago', 'Chile', '100'),
(19, 'Seoul', 'South Korea', '70'),
(20, 'Kuala Lumpur', 'Malaysia', '90');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Full_Name` text NOT NULL,
  `Email` text NOT NULL,
  `Password` text NOT NULL,
  `Date_of_Birth` text NOT NULL,
  `Country` text NOT NULL,
  `Gender` text NOT NULL,
  `Favourite_color` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `Full_Name`, `Email`, `Password`, `Date_of_Birth`, `Country`, `Gender`, `Favourite_color`) VALUES
(1, 'Md. Rezwan Mujahid Rudro', 'rezwanrudro0570@gmail.com', '123456', '2001-12-24', 'Bangladesh', 'male', '#1f77d6'),
(2, 'nuzhat', 'nuzhattabassum71@gmail.com', '123456', '2001-02-11', 'Bangladesh', 'female', '#de1717');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
