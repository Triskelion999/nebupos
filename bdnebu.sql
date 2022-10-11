-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2022 a las 02:09:13
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdnebu`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `rut_administrador` varchar(9) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `contrasena` varchar(15) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`rut_administrador`, `nombre`, `contrasena`) VALUES
('195290857', 'Maximiliano Ariel Galvez Arraño', 'miau'),
('204843848', 'Khrisna Ignacia Gonzalez Mendez', 'miau');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `rut_cliente` varchar(9) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `correo` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`rut_cliente`, `nombre`, `direccion`, `telefono`, `estado`, `correo`) VALUES
('101525815', 'Guillermo', 'usm', '983728372', 1, 'guille.usm@usm.cl'),
('128465669', 'Roberto Garcia', 'Entrelomas 1790 depto 13', '964143823', 1, 'rogarcia@gmail.cl'),
('162319329', 'Josefa Diaz', 'Magallanes 1256, depto 13', '965437612', 0, 'josefa.diaz@gmail.com'),
('195290857', 'Maximiliano Galvez', 'Gaston Ossa 477 casa B', '997748290', 1, 'maximiliano.galvez@usm.cl');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo` int(9) NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` int(6) DEFAULT NULL,
  `costo` int(6) NOT NULL,
  `stock` smallint(4) DEFAULT 1,
  `stock_min` smallint(4) DEFAULT 0,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `descripcion` varchar(150) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `tipo`, `nombre`, `precio`, `costo`, `stock`, `stock_min`, `estado`, `descripcion`) VALUES
(16, 0, 'Peineta', 1990, 90, 20, 0, 1, 'Peine, que consta de un cuerpo convexo y un conjunto de púas que se encajan sobre el moño'),
(27, 0, 'Barro termal', 10990, 990, 1, 0, 1, 'barro termal para mascarillas faciales.'),
(28, 0, 'Shampoo', 4990, 1500, 9999, 10, 1, 'Shampoo a la venta (variedades).'),
(29, 1, 'Shampoo', 7880, 1500, 4, 2, 1, 'Esencia caléndula.'),
(30, 1, 'Shampoo', 3990, 988, 1, 0, 0, 'Variedad.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`rut_administrador`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`rut_cliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codigo` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
