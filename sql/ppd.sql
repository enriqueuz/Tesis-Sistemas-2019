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
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_mencion` INT(11) NOT NULL,
	`nombre` varchar(40) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chequeo_pagos`
--
CREATE TABLE `chequeo_pagos` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_estudiante` INT(11) NOT NULL,
	`pago_inscripcion` BOOLEAN NOT NULL DEFAULT false,
	`pago_t1` BOOLEAN NOT NULL DEFAULT false,
	`pago_t2` BOOLEAN NOT NULL DEFAULT false,
	`pago_t3` BOOLEAN NOT NULL DEFAULT false,
	`pago_t4` BOOLEAN NOT NULL DEFAULT false,
	`pago_mg` BOOLEAN NOT NULL DEFAULT false,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_estudiantes`
--
CREATE TABLE `documentos_estudiantes` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_estudiante` INT(11) NOT NULL,
	`constancia_trabajo` BOOLEAN NOT NULL,
	`curriculum` BOOLEAN NOT NULL,
	`foto_carnet` BOOLEAN NOT NULL,
	`copia_cedula` BOOLEAN NOT NULL,
	`copia_partida_nacimiento` BOOLEAN NOT NULL,
	`notas` BOOLEAN NOT NULL,
	`fondo_negro` BOOLEAN NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--
CREATE TABLE `estudiantes` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_carrera` INT(11) NOT NULL,
	`cedula` varchar(10) NOT NULL,
	`nombre` varchar(30) NOT NULL,
	`apellido` varchar(30) NOT NULL,
	`sexo` varchar(1) NOT NULL,
	`telefono` varchar(14) NOT NULL,
	`correo` varchar(255) NOT NULL,
	`fecha_nacimiento` DATE NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menciones`
--
CREATE TABLE `menciones` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(45) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--
CREATE TABLE `pagos` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_estudiante` INT(11) NOT NULL,
	`referencia` INT(15) NOT NULL,
	`monto` DECIMAL NOT NULL,
	`fecha` DATE NOT NULL,
	`tipo` varchar(30) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
CREATE TABLE `usuarios` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(45) NOT NULL UNIQUE,
	`clave` varchar(255) NOT NULL,
	`rol` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `carreras_fk0` FOREIGN KEY (`id_mencion`) REFERENCES `menciones`(`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `chequeo_pagos`
--
ALTER TABLE `chequeo_pagos`
  ADD CONSTRAINT `chequeo_pagos_fk0` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_estudiantes`
--
ALTER TABLE `documentos_estudiantes`
  ADD CONSTRAINT `documentos_estudiantes_fk0` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_fk0` FOREIGN KEY (`id_carrera`) REFERENCES `carreras`(`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_fk0` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes`(`id`);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
