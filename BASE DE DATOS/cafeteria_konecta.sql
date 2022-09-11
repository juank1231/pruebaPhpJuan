-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-09-2022 a las 15:31:13
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cafeteria_konecta`
--
CREATE DATABASE IF NOT EXISTS `cafeteria_konecta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cafeteria_konecta`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `referencia` varchar(40) NOT NULL,
  `precio` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `categoria` varchar(60) NOT NULL,
  `stock` int(12) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `usuario_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre_producto`, `referencia`, `precio`, `peso`, `categoria`, `stock`, `fecha_creacion`, `usuario_id`) VALUES
(3, 'chocolate', 'sADS23', 9000, 1000, 'insumos', 23, '2022-09-11', 1),
(5, 'Cafe', '52665', 20000, 2000, 'insumos', 5, '2022-09-11', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(50) NOT NULL,
  `usuario_apellido` varchar(40) NOT NULL,
  `usuario_usuario` varchar(60) NOT NULL,
  `usuario_clave` varchar(120) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_usuario`, `usuario_clave`, `email`) VALUES
(1, 'Juan Carlos', 'Velasquez', 'juanvelasquez', '$2y$10$Y3wTvop31L9rgG7w15FbUOpOZ90RhT8fGPsPZWBpW7w2BfQD39t5O', 'juan.velasquez@pi.edu.co'),
(2, 'Prueba', 'Konecta', 'konecta', '$2y$10$09HEqBdtoh43luZ0tU/ALu6H7itZKl/Od732CkMPVFINbi3MfBREm', ''),
(3, 'Juan Carlos', 'Velasquez Hernandez', 'juanv', '$2y$10$1H5EPePfm8af3piEPve6oO0i8VoJqApLXz8iD5gOjcKCN0EP7Wl8i', 'juann.01040@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_producto`
--

CREATE TABLE `ventas_producto` (
  `id_venta` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_total` int(15) NOT NULL,
  `usuario_venta` int(10) NOT NULL,
  `fecha_venta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas_producto`
--

INSERT INTO `ventas_producto` (`id_venta`, `id_producto`, `cantidad`, `precio_total`, `usuario_venta`, `fecha_venta`) VALUES
(1, 3, 4, 36000, 1, '2022-09-11'),
(2, 3, 3, 27000, 1, '2022-09-11'),
(4, 3, 6, 54000, 1, '2022-09-11'),
(5, 3, 6, 54000, 1, '2022-09-11'),
(6, 3, 6, 54000, 1, '2022-09-11'),
(7, 3, 50, 450000, 1, '2022-09-11'),
(8, 3, 5, 45000, 1, '2022-09-11'),
(9, 3, 1, 9000, 1, '2022-09-11'),
(10, 5, 10, 200000, 2, '2022-09-11'),
(11, 5, 10, 200000, 2, '2022-09-11'),
(12, 5, 25, 500000, 2, '2022-09-11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `usuario_id_2` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `ventas_producto`
--
ALTER TABLE `ventas_producto`
  ADD PRIMARY KEY (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas_producto`
--
ALTER TABLE `ventas_producto`
  MODIFY `id_venta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
