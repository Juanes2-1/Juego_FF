-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2025 a las 21:56:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `juegoff`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `armas`
--

CREATE TABLE `armas` (
  `ID_arma` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `danio` int(11) NOT NULL,
  `municion_max` int(11) DEFAULT NULL,
  `imagen_armas` varchar(500) NOT NULL,
  `ID_tipo` int(11) DEFAULT NULL,
  `nivel_ar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `armas`
--

INSERT INTO `armas` (`ID_arma`, `nombre`, `danio`, `municion_max`, `imagen_armas`, `ID_tipo`, `nivel_ar`) VALUES
(1, 'Puño', 1, NULL, 'puño.jpg', 1, 1),
(2, 'Pistola', 2, 12, 'pistola.jpg', 2, 1),
(3, 'Ametralladora', 10, 30, 'ametralladora.jpg', 4, 2),
(4, 'francotirador.jpg', 20, 4, 'francotirador.jpg', 3, 2),
(5, 'Usp', 2, 10, 'usp.jpg', 2, 1),
(6, 'Revolver', 2, 6, 'revolver.jpg', 2, 1),
(7, 'Xm8', 11, 30, 'xm8.jpg', 4, 2),
(8, 'Mp 40', 10, 30, 'mp40.jpg', 4, 2),
(11, 'SVD', 20, 6, 'svd.jpg', 3, 2),
(12, 'M82B', 20, 2, 'm82b.jpg', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE `avatar` (
  `ID_avatar` int(11) NOT NULL,
  `avatar` varchar(500) NOT NULL,
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `avatar`
--

INSERT INTO `avatar` (`ID_avatar`, `avatar`, `imagen`) VALUES
(1, 'Alok', 'alokff.png'),
(2, 'Alvaro', 'alvaroff.png'),
(3, 'Chrono', 'chronoff.png'),
(4, 'Kapella', 'kapellaff.png'),
(5, 'Moco', 'mocoff.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `ID_estado` int(11) NOT NULL,
  `estado` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`ID_estado`, `estado`) VALUES
(1, 'Desbloqueado'),
(2, 'Bloqueado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapas`
--

CREATE TABLE `mapas` (
  `ID_mapas` int(11) NOT NULL,
  `mapas` varchar(100) NOT NULL,
  `imagen_mapas` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mapas`
--

INSERT INTO `mapas` (`ID_mapas`, `mapas`, `imagen_mapas`) VALUES
(1, 'BR-CLASIFICATORIA', 'BR-CLASIFICATORIA.png'),
(2, 'DE-CLASIFICATORIA', 'DE-CLASIFICATORIA.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `ID_partida` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `ID_usuario` int(11) DEFAULT NULL,
  `ID_sala` int(11) DEFAULT NULL,
  `puntos_partida` int(11) DEFAULT 0,
  `dano_total` int(11) DEFAULT 0,
  `headshots` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidas`
--

INSERT INTO `partidas` (`ID_partida`, `fecha_inicio`, `fecha_fin`, `ID_usuario`, `ID_sala`, `puntos_partida`, `dano_total`, `headshots`) VALUES
(94, '2025-03-08 21:47:27', '0000-00-00 00:00:00', 4, 24, 3, 3, 0),
(95, '2025-03-08 21:47:28', '0000-00-00 00:00:00', 9, 24, 22, 22, 0),
(96, '2025-03-08 21:47:30', '0000-00-00 00:00:00', 9, 24, 22, 22, 0),
(97, '2025-03-08 21:47:31', '0000-00-00 00:00:00', 4, 24, 3, 3, 0),
(98, '2025-03-08 21:47:33', '0000-00-00 00:00:00', 9, 24, 22, 22, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_rol` int(11) NOT NULL,
  `rol` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID_rol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Jugador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `ID_sala` int(11) NOT NULL,
  `nombre_sala` varchar(100) NOT NULL,
  `jugadores` int(11) NOT NULL,
  `nivel_requerido` int(11) NOT NULL,
  `ID_mapas` int(11) DEFAULT NULL,
  `ID_estado` int(11) NOT NULL,
  `tiempo_inicio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`ID_sala`, `nombre_sala`, `jugadores`, `nivel_requerido`, `ID_mapas`, `ID_estado`, `tiempo_inicio`) VALUES
(2, 'sala_prueba', 5, 0, 2, 0, '2025-03-08 00:00:56'),
(3, 'PRUEBA_SALA_F', 5, 1, 1, 0, '2025-03-08 00:00:56'),
(4, 'PRUEBA_SALA_F', 4, 1, 1, 0, '2025-03-08 00:00:56'),
(9, 'PRUEBA_SALA_F', 4, 1, 1, 0, '2025-03-08 00:00:56'),
(18, 'Sala 2', 5, 0, 2, 0, '2025-03-08 03:48:59'),
(19, 'Sala 3', 5, 0, 2, 0, '2025-03-08 04:24:33'),
(20, 'Sala 4', 5, 0, 2, 0, '2025-03-08 04:25:10'),
(21, 'Sala 5', 5, 0, 2, 0, '2025-03-08 18:53:00'),
(22, 'Sala 6', 5, 0, 2, 0, '2025-03-08 20:16:32'),
(23, 'Sala 7', 5, 0, 2, 0, '2025-03-08 20:27:27'),
(24, 'Sala 8', 5, 0, 2, 0, '2025-03-08 20:45:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `ID_tipo` int(11) NOT NULL,
  `tipo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`ID_tipo`, `tipo`) VALUES
(1, 'Cuerpo a Cuerpo'),
(2, 'Pistolas'),
(3, 'Francotirador'),
(4, 'Subfusiles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_usuario` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `Puntos` int(11) DEFAULT 0,
  `vida` int(11) DEFAULT 100,
  `Ultimo_ingreso` datetime DEFAULT NULL,
  `ID_rol` int(11) DEFAULT NULL,
  `ID_estado` int(11) DEFAULT NULL,
  `ID_avatar` int(11) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `partidas_ganadas` int(11) DEFAULT 0,
  `partidas_perdidas` int(11) DEFAULT 0,
  `dano_total` int(11) DEFAULT 0,
  `headshots` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_usuario`, `username`, `email`, `password`, `Puntos`, `vida`, `Ultimo_ingreso`, `ID_rol`, `ID_estado`, `ID_avatar`, `nivel`, `partidas_ganadas`, `partidas_perdidas`, `dano_total`, `headshots`) VALUES
(1, 'KANT', 'kantarboles@example.com', '$2y$10$t0ZmOIERSDozKaRvM92zdelRJcXc/RP2Iv7SDGbPOBvnCPxduaubW', 8, 100, NULL, 2, 1, 4, 1, 0, 0, 0, 0),
(4, 'lolup', 'l@gmail.com', '$2y$10$1gpog//uclj2OH3Pb9Qi/.SkMe5YmqX8DN6UcKfyYsx.yECq4lW6y', 38, 38, NULL, 2, 1, 2, 1, 1, 2, 53, 0),
(5, 'prueba1', 'prueba1@gmail.com', '123456', 0, 100, NULL, 2, 1, 2, 1, 0, 0, 0, 0),
(8, 'waos', 'waos@gmail.com', '$2y$10$k88PSMYEgDAhj91rZH4fHOlAdx/IYHq84TXKY1LuXyzMpxanV0syu', 100, 100, NULL, 2, 1, 3, 1, 0, 0, 0, 0),
(9, 'jugador dos', 'jugador2@gmail.com', '$2y$10$SDWL.iD9mnskQ.Y397B8v.0UMB.hZCbiXJBwMZmjednEyDJ/UmKxm', 644, 97, NULL, 2, 1, 1, 2, 4, 0, 278, 0),
(10, 'tilin', 'tilin@gmail.com', '$2y$10$RPeWNQydkZvpXHusDlYyHO73Cn3SaIydDocKhPMyJedxZyzV.uQZe', 0, 100, NULL, 2, 2, 1, 1, 0, 0, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`ID_arma`),
  ADD KEY `ID_tipo` (`ID_tipo`);

--
-- Indices de la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`ID_avatar`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`ID_estado`);

--
-- Indices de la tabla `mapas`
--
ALTER TABLE `mapas`
  ADD PRIMARY KEY (`ID_mapas`);

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`ID_partida`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_sala` (`ID_sala`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_rol`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`ID_sala`),
  ADD KEY `ID_mapas` (`ID_mapas`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`ID_tipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_usuario`),
  ADD KEY `ID_rol` (`ID_rol`),
  ADD KEY `ID_avatar` (`ID_avatar`),
  ADD KEY `ID_estado` (`ID_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `armas`
--
ALTER TABLE `armas`
  MODIFY `ID_arma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `avatar`
--
ALTER TABLE `avatar`
  MODIFY `ID_avatar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `ID_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mapas`
--
ALTER TABLE `mapas`
  MODIFY `ID_mapas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `partidas`
--
ALTER TABLE `partidas`
  MODIFY `ID_partida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `ID_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `ID_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `armas`
--
ALTER TABLE `armas`
  ADD CONSTRAINT `armas_ibfk_1` FOREIGN KEY (`ID_tipo`) REFERENCES `tipo` (`ID_tipo`);

--
-- Filtros para la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuario` (`ID_usuario`),
  ADD CONSTRAINT `partidas_ibfk_2` FOREIGN KEY (`ID_sala`) REFERENCES `salas` (`ID_sala`);

--
-- Filtros para la tabla `salas`
--
ALTER TABLE `salas`
  ADD CONSTRAINT `salas_ibfk_1` FOREIGN KEY (`ID_mapas`) REFERENCES `mapas` (`ID_mapas`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ID_rol`) REFERENCES `roles` (`ID_rol`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`ID_avatar`) REFERENCES `avatar` (`ID_avatar`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`ID_estado`) REFERENCES `estado` (`ID_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
