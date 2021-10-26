-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-10-2021 a las 11:40:03
-- Versión del servidor: 5.7.31
-- Versión de PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fichajes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

DROP TABLE IF EXISTS `calendario`;
CREATE TABLE IF NOT EXISTS `calendario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `curso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `calendario`
--

INSERT INTO `calendario` (`id`, `fecha_inicio`, `fecha_fin`, `curso`) VALUES
(2, '2021-09-13', '2022-07-29', '2021 - 2022'),
(3, '2018-05-04', '2019-05-04', '2018 - 2019'),
(4, '2016-01-01', '2016-12-01', '2016 - 2016'),
(5, '2017-09-12', '2019-07-26', '2017 - 2019');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210927092454', '2021-09-27 09:25:17', 398),
('DoctrineMigrations\\Version20210927095815', '2021-09-27 09:58:32', 916),
('DoctrineMigrations\\Version20210927100650', '2021-09-27 10:07:04', 292),
('DoctrineMigrations\\Version20210927100934', '2021-09-27 10:09:44', 166),
('DoctrineMigrations\\Version20210927101335', '2021-09-27 10:13:47', 241),
('DoctrineMigrations\\Version20210927101538', '2021-09-27 10:15:49', 187),
('DoctrineMigrations\\Version20210927101945', '2021-09-27 10:19:56', 439),
('DoctrineMigrations\\Version20210927102618', '2021-09-27 10:26:30', 287),
('DoctrineMigrations\\Version20210927103401', '2021-09-27 10:34:14', 223),
('DoctrineMigrations\\Version20210928063334', '2021-09-28 06:33:53', 286),
('DoctrineMigrations\\Version20210928064251', '2021-09-28 06:43:09', 417),
('DoctrineMigrations\\Version20210928064734', '2021-09-28 06:47:46', 242),
('DoctrineMigrations\\Version20210928065052', '2021-09-28 06:51:02', 137),
('DoctrineMigrations\\Version20210928065850', '2021-09-28 06:59:00', 237),
('DoctrineMigrations\\Version20210928070822', '2021-09-28 07:08:33', 116),
('DoctrineMigrations\\Version20210928074019', '2021-09-28 07:40:43', 341);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

DROP TABLE IF EXISTS `empleado`;
CREATE TABLE IF NOT EXISTS `empleado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `horario_id` int(11) DEFAULT NULL,
  `calendario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D9D9BF524959F1BA` (`horario_id`),
  KEY `IDX_D9D9BF52A7F6EA19` (`calendario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `dni`, `nombre`, `apellido`, `apellido2`, `horario_id`, `calendario_id`) VALUES
(1, '12468001R', 'Jorge', 'Angulo', 'Landa', 1, 2),
(2, '12121212A', 'Aritz', 'Aranda', 'Ávila', 2, 3),
(3, '12345679B', 'Brian', 'Blanco', 'Suarez', 1, 2),
(4, '12446688R', 'Miguel Angel', 'Murillo', 'Alvarez', NULL, NULL),
(5, '22446688A', 'Jose', 'Gutierrez', 'Olañeta', NULL, NULL),
(6, '87654321Z', 'Zigor', 'Iriondo', 'Alberdi', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

DROP TABLE IF EXISTS `horario`;
CREATE TABLE IF NOT EXISTS `horario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entrada` datetime NOT NULL,
  `salida` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id`, `entrada`, `salida`) VALUES
(1, '2021-09-27 08:00:00', '2021-09-27 14:00:00'),
(2, '2021-09-27 08:00:00', '2021-09-27 18:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
CREATE TABLE IF NOT EXISTS `incidencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `causa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entrada` datetime NOT NULL,
  `salida` datetime NOT NULL,
  `horario_trabajo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C7C6728C79F2C342` (`horario_trabajo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `incidencia`
--

INSERT INTO `incidencia` (`id`, `causa`, `entrada`, `salida`, `horario_trabajo_id`) VALUES
(1, 'cita medica', '2021-09-27 10:30:00', '2021-09-27 12:30:00', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `FK_D9D9BF524959F1BA` FOREIGN KEY (`horario_id`) REFERENCES `horario` (`id`),
  ADD CONSTRAINT `FK_D9D9BF52A7F6EA19` FOREIGN KEY (`calendario_id`) REFERENCES `calendario` (`id`);

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `FK_C7C6728C79F2C342` FOREIGN KEY (`horario_trabajo_id`) REFERENCES `horario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
