-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 02:18 AM
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
-- Database: `nusuario`
--

-- --------------------------------------------------------

--
-- Table structure for table `recuperar`
--

CREATE TABLE `recuperar` (
  `EMAIL` varchar(50) NOT NULL,
  `CLAVE_NUEVA` int(8) NOT NULL,
  `TOKEN` varchar(60) NOT NULL,
  `FECHA_ALTA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registronuevo`
--

CREATE TABLE `registronuevo` (
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registronuevo`
--

INSERT INTO `registronuevo` (`nombre`, `apellido`, `email`, `user`, `pass`) VALUES
('Jose', 'Garcia', 'joseG@gmail.com', 'JoseG', '$2y$10$4tUF7TNP5mOHJ5BusaIoeOr/eXT28MxTczOz.Q7pqG40k6EFg6IuK'),
('Lucas', 'Carry', 'email@gmail.com', 'Energygy', '$2y$10$vM4XC0t70YbWniwLNwAL4OAZQoMId3PhWfKBhSnoIF1ZITOs37S3q'),
('l', 'c', 'lc@gmail.com', 'lc', '$2y$10$HtWoQ4a5gfDTu0fppyDPf.6m8S0ODSSWFNPE9K/4qXDDcj.XD/O5y');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
