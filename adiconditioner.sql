-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2025 at 04:49 PM
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
-- Database: `adiconditioner`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `emri_klientit` varchar(100) DEFAULT NULL,
  `produkti` varchar(100) DEFAULT NULL,
  `sasia` int(11) DEFAULT NULL,
  `cmimi_total` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `emri_klientit`, `produkti`, `sasia`, `cmimi_total`, `status`, `created_at`) VALUES
(2, 'Hana', 'BRUNO 18000 BTU', 1, 569.00, 'E paguar', '2025-07-19 21:51:17'),
(4, 'Ardian', 'BRUNO 18000 BTU', 2, 1138.00, 'E paguar', '2025-07-19 22:11:11'),
(5, 'Hana', 'BRUNO 24000 BTU', 3, 2187.00, 'E paguar', '2025-07-20 01:05:24'),
(13, 'hana', 'TCL 24000 BTU', 2, 1560.00, 'E papaguar', '2025-07-20 12:38:46');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `emri` varchar(255) NOT NULL,
  `pershkrimi` text NOT NULL,
  `kategoria` varchar(100) NOT NULL,
  `cmimi` decimal(10,2) NOT NULL,
  `sasia` int(11) NOT NULL,
  `prodhuesi` varchar(100) NOT NULL,
  `data_regjistrimit` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `emri`, `pershkrimi`, `kategoria`, `cmimi`, `sasia`, `prodhuesi`, `data_regjistrimit`) VALUES
(9, 'BRUNO 24000 BTU', 'Komoditet për çdo stinë.', 'Portable', 729.00, 2, 'Bruno', '2025-07-18'),
(11, 'MIDEA 18000 BTU', 'Ofron perfromance optiomale edhe në temperatura -25 °C.', 'Inverter', 669.00, 4, 'Midea', '2025-07-18'),
(12, 'LG 18000 BTU', 'KONDICIONER LG S12EQ.NSJ/UA3 INVERTER', 'Portable', 539.00, 2, 'LG', '2025-07-18'),
(15, 'TCL 24000 BTU', 'Smart Control with Wi-Fi, TCL Home App', 'Portable', 780.00, 2, 'TCL', '2025-07-18'),
(16, 'BRUNO 12000 BTU', 'Performon në:+53°C deri në -25°C', 'Split', 339.00, 6, 'Bruno', '2025-07-20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `emri` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fjalekalimi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emri`, `email`, `fjalekalimi`) VALUES
(1, 'hana', 'hana@gmail.com', '$2y$10$wfXb9ssWIXR5sij1v9sfW.6XIln8UfWYdXfZYzXa4legXA06kv90S'),
(3, 'ardi', 'ardi@gmail.com', '$2y$10$CQd54f2n9P4gQTz.xxqE4.Atq/QcL0WZ.sTavOyBvmcULKpe2T/Q2'),
(4, 'lona', 'lona1@gmail.com', '$2y$10$1.pSvTsARNb5dzJSMBNJn.cIlYiXqnoUj/Rdx3MJuNDplqMfb.Tku'),
(5, 'erda', 'erda@gmail.com', '$2y$10$hcheMwZFuKmprZkO2jLAbeouKRKbPHQkQ3hXg.k4coPyKlMB8nVwi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
