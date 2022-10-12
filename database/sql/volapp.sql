-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-10-2022 a las 00:48:39
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `volapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
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
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id`, `menu_id`, `page`, `titulo`, `icono`, `descripcion`, `status`) VALUES
(1, NULL, NULL, 'Inicio', 'fal fa-home', 'PAGINA PRINCIPAL', '1'),
(2, 1, 'home', 'Home', NULL, 'PAGINA PRINCIPAL DE LA INTERFAZ', '1'),
(3, NULL, NULL, 'Usuarios', 'fa-light fa-users', 'PAGINA DE ADMINISTRACION DE USUARIOS', '1'),
(4, 3, 'usuarios', 'Admon Usuarios', NULL, 'ADMINISTRACION DE USUARIOS MODULOS ROLES Y PERMISOS', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
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
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(1, 1, 1, 0, 0, 0, 0),
(2, 1, 2, 1, 0, 0, 0),
(3, 1, 3, 0, 0, 0, 0),
(4, 1, 4, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
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
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `identificacion`, `nombres`, `a_paterno`, `a_materno`, `telefono`, `email_user`, `pswd`, `ruc`, `nombrefiscal`, `direccionfiscal`, `content_type`, `base_64`, `rolid`, `datecreated`, `status`) VALUES
(1, '', 'Martin', 'Almeida', 'Cavanzo', 3107698290, 'martinalmeida56@gmail.com', 'admin123', NULL, NULL, NULL, '', '', 1, '2022-09-08 01:36:11', '1'),
(2, '1096241229', 'Martin', 'Almeida', 'Cavanzo', 3107698290, 'martinalmeida56@gmail.ad', 'admin123', NULL, NULL, NULL, '', '', 1, '2022-09-08 01:37:45', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` bigint(20) NOT NULL,
  `nombrerol` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_spanish_ci DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'ADMINISTRADOR', 'Perfi que tiene acceso completo al sistema', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'activo'),
(2, 'inactivo'),
(3, 'eliminado'),
(4, 'restaurado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permisos_ibfk_1` (`rolid`),
  ADD KEY `permisos_ibfk_2` (`moduloid`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_ibfk_1` (`rolid`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`moduloid`) REFERENCES `modulo` (`id`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
