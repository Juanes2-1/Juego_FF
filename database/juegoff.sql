-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-02-2025 a las 21:32:47
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

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
  `ID_arma` int NOT NULL,
  `tipo` enum('francotirador','ametralladora','pistola','puño') NOT NULL,
  `danio` int DEFAULT NULL,
  `municion_max` int DEFAULT NULL,
  `imagen_armas` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE `avatar` (
  `ID_avatar` int NOT NULL,
  `avatar` enum('Alvaro','Alok','Moco','Crono','A124') NOT NULL,
  `imagen` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_partidas`
--

CREATE TABLE `detalles_partidas` (
  `ID_det_partida` int NOT NULL,
  `ID_partida` int DEFAULT NULL,
  `ID_mapas` int DEFAULT NULL,
  `ID_usuario` int DEFAULT NULL,
  `ID_nivel` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_historial`
--

CREATE TABLE `detalle_historial` (
  `ID_usuario` int DEFAULT NULL,
  `ID_avatar` int DEFAULT NULL,
  `ID_nivel` int DEFAULT NULL,
  `ID_estado` int DEFAULT NULL,
  `ID_fecha` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `ID_estado` int NOT NULL,
  `estado` enum('desbloqueado','bloqueado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha`
--

CREATE TABLE `fecha` (
  `ID_fecha` int NOT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `ID_inventario` int NOT NULL,
  `cantidad` int DEFAULT NULL,
  `ID_usuario` int DEFAULT NULL,
  `ID_arma` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapas`
--

CREATE TABLE `mapas` (
  `ID_mapas` int NOT NULL,
  `mapas` enum('BR-clasificatoria','DE-clasificatoria') NOT NULL,
  `imagen_mapas` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `ID_nivel` int NOT NULL,
  `nivel` enum('nivel1','nivel2') NOT NULL,
  `imagen_nivel` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `ID_partida` int NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `ID_usuario` int DEFAULT NULL,
  `ID_sala` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuaciones`
--

CREATE TABLE `puntuaciones` (
  `ID_puntuacion` int NOT NULL,
  `puntos` int DEFAULT NULL,
  `ID_usuario` int DEFAULT NULL,
  `ID_mapas` int DEFAULT NULL,
  `ID_arma` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_rol` int NOT NULL,
  `rol` enum('jugador','administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `ID_sala` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `jugadores_max` int DEFAULT NULL,
  `ID_usuario` int DEFAULT NULL,
  `ID_mapas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_usuario` int NOT NULL,
  `Username` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `ID_rol` int DEFAULT NULL,
  `ID_avatar` int DEFAULT NULL,
  `ID_estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`ID_arma`);

--
-- Indices de la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`ID_avatar`);

--
-- Indices de la tabla `detalles_partidas`
--
ALTER TABLE `detalles_partidas`
  ADD PRIMARY KEY (`ID_det_partida`),
  ADD KEY `ID_partida` (`ID_partida`),
  ADD KEY `ID_mapas` (`ID_mapas`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_nivel` (`ID_nivel`);

--
-- Indices de la tabla `detalle_historial`
--
ALTER TABLE `detalle_historial`
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_avatar` (`ID_avatar`),
  ADD KEY `ID_nivel` (`ID_nivel`),
  ADD KEY `ID_estado` (`ID_estado`),
  ADD KEY `ID_fecha` (`ID_fecha`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`ID_estado`);

--
-- Indices de la tabla `fecha`
--
ALTER TABLE `fecha`
  ADD PRIMARY KEY (`ID_fecha`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`ID_inventario`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_arma` (`ID_arma`);

--
-- Indices de la tabla `mapas`
--
ALTER TABLE `mapas`
  ADD PRIMARY KEY (`ID_mapas`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`ID_nivel`);

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`ID_partida`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_sala` (`ID_sala`);

--
-- Indices de la tabla `puntuaciones`
--
ALTER TABLE `puntuaciones`
  ADD PRIMARY KEY (`ID_puntuacion`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_mapas` (`ID_mapas`),
  ADD KEY `ID_arma` (`ID_arma`);

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
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_mapas` (`ID_mapas`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_usuario`),
  ADD KEY `ID_rol` (`ID_rol`),
  ADD KEY `ID_avatar` (`ID_avatar`),
  ADD KEY `ID_estado` (`ID_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avatar`
--
ALTER TABLE `avatar`
  MODIFY `ID_avatar` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_partidas`
--
ALTER TABLE `detalles_partidas`
  MODIFY `ID_det_partida` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `ID_inventario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partidas`
--
ALTER TABLE `partidas`
  MODIFY `ID_partida` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puntuaciones`
--
ALTER TABLE `puntuaciones`
  MODIFY `ID_puntuacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `ID_sala` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_usuario` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_partidas`
--
ALTER TABLE `detalles_partidas`
  ADD CONSTRAINT `detalles_partidas_ibfk_1` FOREIGN KEY (`ID_partida`) REFERENCES `partidas` (`ID_partida`),
  ADD CONSTRAINT `detalles_partidas_ibfk_2` FOREIGN KEY (`ID_mapas`) REFERENCES `mapas` (`ID_mapas`),
  ADD CONSTRAINT `detalles_partidas_ibfk_3` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`),
  ADD CONSTRAINT `detalles_partidas_ibfk_4` FOREIGN KEY (`ID_nivel`) REFERENCES `niveles` (`ID_nivel`);

--
-- Filtros para la tabla `detalle_historial`
--
ALTER TABLE `detalle_historial`
  ADD CONSTRAINT `detalle_historial_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`),
  ADD CONSTRAINT `detalle_historial_ibfk_2` FOREIGN KEY (`ID_avatar`) REFERENCES `avatar` (`ID_avatar`),
  ADD CONSTRAINT `detalle_historial_ibfk_3` FOREIGN KEY (`ID_nivel`) REFERENCES `niveles` (`ID_nivel`),
  ADD CONSTRAINT `detalle_historial_ibfk_4` FOREIGN KEY (`ID_estado`) REFERENCES `estado` (`ID_estado`),
  ADD CONSTRAINT `detalle_historial_ibfk_5` FOREIGN KEY (`ID_fecha`) REFERENCES `fecha` (`ID_fecha`);

--
-- Filtros para la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `inventarios_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`),
  ADD CONSTRAINT `inventarios_ibfk_2` FOREIGN KEY (`ID_arma`) REFERENCES `armas` (`ID_arma`);

--
-- Filtros para la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`),
  ADD CONSTRAINT `partidas_ibfk_2` FOREIGN KEY (`ID_sala`) REFERENCES `salas` (`ID_sala`);

--
-- Filtros para la tabla `puntuaciones`
--
ALTER TABLE `puntuaciones`
  ADD CONSTRAINT `puntuaciones_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`),
  ADD CONSTRAINT `puntuaciones_ibfk_2` FOREIGN KEY (`ID_mapas`) REFERENCES `mapas` (`ID_mapas`),
  ADD CONSTRAINT `puntuaciones_ibfk_3` FOREIGN KEY (`ID_arma`) REFERENCES `armas` (`ID_arma`);

--
-- Filtros para la tabla `salas`
--
ALTER TABLE `salas`
  ADD CONSTRAINT `salas_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`),
  ADD CONSTRAINT `salas_ibfk_2` FOREIGN KEY (`ID_mapas`) REFERENCES `mapas` (`ID_mapas`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`ID_rol`) REFERENCES `roles` (`ID_rol`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`ID_avatar`) REFERENCES `avatar` (`ID_avatar`),
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`ID_estado`) REFERENCES `estado` (`ID_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
