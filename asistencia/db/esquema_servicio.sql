-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-07-2012 a las 05:51:59
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `servicio_social`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `id_alumno` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `apellido_paterno` varchar(200) NOT NULL,
  `apellido_materno` varchar(200) NOT NULL,
  `matricula` varchar(50) DEFAULT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `e_mail` varchar(200) NOT NULL,
  `escolaridad` varchar(30) NOT NULL,
  `id_colegio` int(10) NOT NULL,
  `carrera` varchar(200) NOT NULL,
  `semestre` int(10) DEFAULT NULL,
  `documentos` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY (`id_alumno`),
  KEY `id_colegio` (`id_colegio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1001;

--
-- RELACIONES PARA LA TABLA `alumno`:
--   `id_colegio`
--       `colegios` -> `id_colegio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_password`
--

CREATE TABLE IF NOT EXISTS `alumno_password` (
  `id_alumno` int(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  KEY `id_alumno` (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `alumno_password`:
--   `id_alumno`
--       `alumno` -> `id_alumno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_servicio`
--

CREATE TABLE IF NOT EXISTS `alumno_servicio` (
  `id_proyecto` int(10) NOT NULL,
  `id_alumno` int(10) NOT NULL,
  `jefe_directo` varchar(200) DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL,
  `no_horas` int(10) NOT NULL,
  `tipo_horas` int(10) NOT NULL,
  `tipo_servicio` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  KEY `id_proyecto` (`id_proyecto`),
  KEY `id_alumno` (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `alumno_servicio`:
--   `id_alumno`
--       `alumno` -> `id_alumno`
--   `id_proyecto`
--       `proyecto` -> `id_proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE IF NOT EXISTS `asistencia` (
  `id_alumno` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `horas` time NOT NULL,
  `horas_reales` time NOT NULL,
  `retardo` varchar(1) DEFAULT NULL,
  KEY `id_alumno` (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `asistencia`:
--   `id_alumno`
--       `alumno` -> `id_alumno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colegio`
--

CREATE TABLE IF NOT EXISTS `colegio` (
  `id_colegio` int(10) NOT NULL AUTO_INCREMENT,
  `colegios` varchar(200) NOT NULL,
  `responsable` varchar(200) DEFAULT NULL,
  `cargo_responsable` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_colegio`),
  UNIQUE KEY `colegios` (`colegios`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Dumping data for table `colegio`
--

LOCK TABLES `colegio` WRITE;
/*!40000 ALTER TABLE `colegio` DISABLE KEYS */;
INSERT INTO `colegio` VALUES (1,'Instituto Tecnológico de Querétaro','','');
/*!40000 ALTER TABLE `colegio` ENABLE KEYS */;
UNLOCK TABLES;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE IF NOT EXISTS `horario` (
  `id_alumno` int(11) NOT NULL,
  `e0` time DEFAULT NULL,
  `e1` time DEFAULT NULL,
  `e2` time DEFAULT NULL,
  `e3` time DEFAULT NULL,
  `e4` time DEFAULT NULL,
  `e5` time DEFAULT NULL,
  `e6` time DEFAULT NULL,
  `s0` time DEFAULT NULL,
  `s1` time DEFAULT NULL,
  `s2` time DEFAULT NULL,
  `s3` time DEFAULT NULL,
  `s4` time DEFAULT NULL,
  `s5` time DEFAULT NULL,
  `s6` time DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  KEY `id_alumno` (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `horario`:
--   `id_alumno`
--       `alumno` -> `id_alumno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `id_alumno` int(10) NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `fecha` datetime NOT NULL,
  KEY `id_alumno` (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `comentarios`:
--   `id_alumno`
--       `alumno` -> `id_alumno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE IF NOT EXISTS `proyecto` (
  `id_proyecto` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_proyecto` varchar(200) NOT NULL,
  `descripcion` varchar(400),
  `area` varchar(30) NOT NULL,
  `lugares_requeridos` int(10) NOT NULL,
  `lugares_asignados` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_termino` date NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id_proyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(30) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `password` varchar(30) NOT NULL,
  `privilegios` varchar(32) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'sysadmin','sysadmin','sysadmin','11111111111111111111111111111111','Activo');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`id_colegio`) REFERENCES `colegio` (`id_colegio`);

--
-- Filtros para la tabla `alumno_password`
--
ALTER TABLE `alumno_password`
  ADD CONSTRAINT `alumno_password_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);

--
-- Filtros para la tabla `alumno_servicio`
--
ALTER TABLE `alumno_servicio`
  ADD CONSTRAINT `alumno_servicio_ibfk_4` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `alumno_servicio_ibfk_5` FOREIGN KEY (`id_proyecto`) REFERENCES `proyecto` (`id_proyecto`);

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);
  
--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);

 
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
