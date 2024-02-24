-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2024 at 06:32 AM
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
-- Database: `onlinevotingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `user_role` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `contact_no`, `password`, `user_role`) VALUES
(1, 'Keertha', '0909', '5b48d88a19941e3f151d49ecd72b30b650ea917a', 'Admin'),
(2, 'meethu', '1111', '011c945f30ce2cbafc452f39840f025693339c42', 'Voter'),
(3, 'gagan', '2724', 'd6385a5e54213bf645222ecd6b74244e0db3e995', 'Voter'),
(4, '12345', '1234', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Voter'),
(6, 'shanka', '956', '5b0e281496c19db095942ec9983d904312de50bc', 'Voter'),
(7, 'bavi', '9501', '2561762b913707db89577b4681662bce109d947e', 'Voter'),
(8, 'Keerthan', '1234567', 'ca8032a4ce311bf7f776f1e97ae3bb06bf3fc461', 'Voter'),
(9, 'ammu', '1234556', 'ca8032a4ce311bf7f776f1e97ae3bb06bf3fc461', 'Voter'),
(10, 'ashi', '56789', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'Voter'),
(11, 'ashi', '111', '011c945f30ce2cbafc452f39840f025693339c42', 'Voter'),
(12, 'mani', '7890', 'ca8032a4ce311bf7f776f1e97ae3bb06bf3fc461', 'Voter');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
