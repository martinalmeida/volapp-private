-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2022 at 06:49 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `volapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `modulo`
--

CREATE TABLE `modulo` (
  `id` bigint(20) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `page` varchar(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `titulo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `icono` varchar(25) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_spanish_ci DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `modulo`
--

INSERT INTO `modulo` (`id`, `menu_id`, `page`, `titulo`, `icono`, `descripcion`, `status`) VALUES
(1, NULL, NULL, 'INICIO', 'fal fa-home', 'PAGINA PRINCIPAL', '1'),
(2, 1, 'Dashboard', 'Home', NULL, 'PAGINA PRINCIPAL DE LA INTERFAZ', '1');

-- --------------------------------------------------------

--
-- Table structure for table `permisos`
--

CREATE TABLE `permisos` (
  `id` bigint(20) NOT NULL,
  `rolid` bigint(20) DEFAULT NULL,
  `moduloid` bigint(20) DEFAULT NULL,
  `r` int(11) DEFAULT 0,
  `w` int(11) DEFAULT 0,
  `u` int(11) DEFAULT 0,
  `d` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `permisos`
--

INSERT INTO `permisos` (`id`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(1, 1, 1, 0, 0, 0, 0),
(2, 1, 2, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `id` bigint(20) NOT NULL,
  `identificacion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombres` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `a_paterno` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `a_materno` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `email_user` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `pswd` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `ruc` varchar(20) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nombrefiscal` varchar(81) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `direccionfiscal` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `content_type` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `base_64` longtext COLLATE utf8mb4_spanish_ci NOT NULL,
  `rolid` bigint(20) DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` char(1) COLLATE utf8mb4_spanish_ci DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`id`, `identificacion`, `nombres`, `a_paterno`, `a_materno`, `telefono`, `email_user`, `pswd`, `ruc`, `nombrefiscal`, `direccionfiscal`, `content_type`, `base_64`, `rolid`, `datecreated`, `status`) VALUES
(1, '', 'Martin', 'Almeida', 'Cavanzo', 3107698290, 'martinalmeida56@gmail.com', 'admin123', NULL, NULL, NULL, '', '', 1, '2022-09-08 01:36:11', '1'),
(2, '1096241229', 'Martin', 'Almeida', 'Cavanzo', 3107698290, 'martinalmeida56@gmail.ad', 'admin123', NULL, NULL, NULL, '', '', 1, '2022-09-08 01:37:45', '1');

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id` bigint(20) NOT NULL,
  `nombrerol` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_spanish_ci DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'ADMINISTRADOR', 'Perfi que tiene acceso completo al sistema', '1');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'activo'),
(2, 'inactivo'),
(3, 'eliminado'),
(4, 'restaurado');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permisos_ibfk_1` (`rolid`),
  ADD KEY `permisos_ibfk_2` (`moduloid`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_ibfk_1` (`rolid`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`moduloid`) REFERENCES `modulo` (`id`);

--
-- Constraints for table `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
