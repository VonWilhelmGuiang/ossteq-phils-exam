-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 02:21 PM
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
-- Database: `dbuser0`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbuser0_form`
--

CREATE TABLE `dbuser0_form` (
  `dbuser0_id` int(11) NOT NULL,
  `dbuser0_text` varchar(100) NOT NULL,
  `dbuser0_radio` varchar(50) NOT NULL,
  `dbuser0_checkbox` varchar(50) NOT NULL,
  `dbuser0_filename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbuser0_form`
--

INSERT INTO `dbuser0_form` (`dbuser0_id`, `dbuser0_text`, `dbuser0_radio`, `dbuser0_checkbox`, `dbuser0_filename`) VALUES
(8, 'This is a test. Please ignore.', 'Hello', 'World!,Web!', 'wallpaper1706880073.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbuser0_form`
--
ALTER TABLE `dbuser0_form`
  ADD PRIMARY KEY (`dbuser0_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbuser0_form`
--
ALTER TABLE `dbuser0_form`
  MODIFY `dbuser0_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
