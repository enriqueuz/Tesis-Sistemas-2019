-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2019 a las 01:27:43
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ppd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(11) NOT NULL,
  `id_mencion` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chequeo_pagos`
--

CREATE TABLE `chequeo_pagos` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `pago_inscripcion` tinyint(1) NOT NULL DEFAULT '0',
  `pago_t1` tinyint(1) NOT NULL DEFAULT '0',
  `pago_t2` tinyint(1) NOT NULL DEFAULT '0',
  `pago_t3` tinyint(1) NOT NULL DEFAULT '0',
  `pago_t4` tinyint(1) NOT NULL DEFAULT '0',
  `pago_mg` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_estudiantes`
--

CREATE TABLE `documentos_estudiantes` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `constancia_trabajo` tinyint(1) NOT NULL,
  `curriculum` tinyint(1) NOT NULL,
  `foto_carnet` tinyint(1) NOT NULL,
  `copia_cedula` tinyint(1) NOT NULL,
  `copia_partida_nacimiento` tinyint(1) NOT NULL,
  `notas` tinyint(1) NOT NULL,
  `fondo_negro` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menciones`
--

CREATE TABLE `menciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `referencia` int(15) NOT NULL,
  `monto` decimal(10,0) NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carreras_fk0` (`id_mencion`);

--
-- Indices de la tabla `chequeo_pagos`
--
ALTER TABLE `chequeo_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chequeo_pagos_fk0` (`id_estudiante`);

--
-- Indices de la tabla `documentos_estudiantes`
--
ALTER TABLE `documentos_estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documentos_estudiantes_fk0` (`id_estudiante`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiantes_fk0` (`id_carrera`);

--
-- Indices de la tabla `menciones`
--
ALTER TABLE `menciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagos_fk0` (`id_estudiante`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chequeo_pagos`
--
ALTER TABLE `chequeo_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos_estudiantes`
--
ALTER TABLE `documentos_estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menciones`
--
ALTER TABLE `menciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `carreras_fk0` FOREIGN KEY (`id_mencion`) REFERENCES `menciones` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `chequeo_pagos`
--
ALTER TABLE `chequeo_pagos`
  ADD CONSTRAINT `chequeo_pagos_fk0` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_estudiantes`
--
ALTER TABLE `documentos_estudiantes`
  ADD CONSTRAINT `documentos_estudiantes_fk0` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_fk0` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_fk0` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
