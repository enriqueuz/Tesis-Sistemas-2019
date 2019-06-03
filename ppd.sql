-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-06-2019 a las 22:40:11
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `id_carrera` int(10) NOT NULL,
  `nombre_carrera` varchar(40) NOT NULL,
  `cod_mencion_ca` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chequeo_pagos`
--

CREATE TABLE `chequeo_pagos` (
  `id_chequeo_pagos` int(10) NOT NULL,
  `pago_ins` tinyint(1) DEFAULT NULL,
  `pago_t1` tinyint(1) DEFAULT NULL,
  `pago_t2` tinyint(1) DEFAULT NULL,
  `pago_t3` tinyint(1) DEFAULT NULL,
  `pago_t4` tinyint(1) DEFAULT NULL,
  `pago_mg` tinyint(1) DEFAULT NULL,
  `cedula_doc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_estudiantes`
--

CREATE TABLE `documentos_estudiantes` (
  `id_documentos_estudiantes` int(1) NOT NULL,
  `const_tra` tinyint(1) DEFAULT NULL,
  `curriculum` tinyint(1) DEFAULT NULL,
  `foto_car` tinyint(1) DEFAULT NULL,
  `copia_ced` tinyint(1) DEFAULT NULL,
  `copia_part` tinyint(1) DEFAULT NULL,
  `notas` tinyint(1) DEFAULT NULL,
  `fondo_n` tinyint(1) DEFAULT NULL,
  `cedula_doc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `sexo` char(1) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `fecha_n` date NOT NULL,
  `id_carrera_es` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menciones`
--

CREATE TABLE `menciones` (
  `cod_mencion` int(3) NOT NULL,
  `nombre_mencion` char(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `referencia` int(15) NOT NULL,
  `cedula_es` int(11) NOT NULL,
  `monto` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `tipo` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`),
  ADD KEY `cod_mencion` (`cod_mencion_ca`);

--
-- Indices de la tabla `chequeo_pagos`
--
ALTER TABLE `chequeo_pagos`
  ADD PRIMARY KEY (`id_chequeo_pagos`),
  ADD KEY `cedula_doc` (`cedula_doc`);

--
-- Indices de la tabla `documentos_estudiantes`
--
ALTER TABLE `documentos_estudiantes`
  ADD PRIMARY KEY (`id_documentos_estudiantes`),
  ADD KEY `cedula_doc` (`cedula_doc`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`cedula`),
  ADD KEY `id_carrera_es` (`id_carrera_es`);

--
-- Indices de la tabla `menciones`
--
ALTER TABLE `menciones`
  ADD PRIMARY KEY (`cod_mencion`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`referencia`),
  ADD KEY `cedula_es` (`cedula_es`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id_carrera` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `chequeo_pagos`
--
ALTER TABLE `chequeo_pagos`
  MODIFY `id_chequeo_pagos` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `documentos_estudiantes`
--
ALTER TABLE `documentos_estudiantes`
  MODIFY `id_documentos_estudiantes` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `carreras_ibfk_1` FOREIGN KEY (`cod_mencion_ca`) REFERENCES `menciones` (`cod_mencion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `chequeo_pagos`
--
ALTER TABLE `chequeo_pagos`
  ADD CONSTRAINT `chequeo_pagos_ibfk_1` FOREIGN KEY (`cedula_doc`) REFERENCES `estudiantes` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_estudiantes`
--
ALTER TABLE `documentos_estudiantes`
  ADD CONSTRAINT `documentos_estudiantes_ibfk_1` FOREIGN KEY (`cedula_doc`) REFERENCES `estudiantes` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `pagos` (`cedula_es`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`id_carrera_es`) REFERENCES `carreras` (`id_carrera`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
