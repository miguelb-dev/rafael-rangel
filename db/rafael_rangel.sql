-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2025 a las 00:18:31
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
-- Base de datos: `rafael_rangel`
--
CREATE DATABASE IF NOT EXISTS `rafael_rangel` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `rafael_rangel`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_administrador` int(11) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` enum('Masculino','Femenino') NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono_personal` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_administrador`, `contrasena`, `cedula`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `direccion`, `telefono_personal`, `email`) VALUES
(2, '$2y$10$AkNWUbyQUUsmafcL9iUMru6QP72WAuUXRd3BDoWMTH6LLnVfibAcO', 0, 'Rafael', 'Rangel', '1980-05-12', '', 'Avenida 6, con calle Río de Janeiro, sector La Plata.\r\nParroquia Juan Ignacio Montilla, municipio Valera, estado Trujillo.\r\n', '0412-1234567', 'admin@correo.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anio_seccion`
--

CREATE TABLE `anio_seccion` (
  `id_anio_seccion` int(11) NOT NULL,
  `anio` varchar(20) NOT NULL,
  `seccion` varchar(10) NOT NULL,
  `horario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `anio_seccion`
--

INSERT INTO `anio_seccion` (`id_anio_seccion`, `anio`, `seccion`, `horario`) VALUES
(1, '1', 'A', NULL),
(2, '1', 'B', NULL),
(3, '1', 'C', NULL),
(4, '2', 'A', NULL),
(5, '2', 'B', NULL),
(6, '2', 'C', NULL),
(7, '3', 'A', NULL),
(8, '3', 'B', NULL),
(9, '3', 'C', NULL),
(10, '4', 'A', NULL),
(11, '4', 'B', NULL),
(12, '4', 'C', NULL),
(13, '5', 'A', NULL),
(14, '5', 'B', NULL),
(15, '5', 'C', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_adjunto`
--

CREATE TABLE `archivo_adjunto` (
  `id_archivo_adjunto` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `tipo` enum('imagen','documento') NOT NULL,
  `nombre_archivo` varchar(100) NOT NULL,
  `orden` int(11) DEFAULT 0 COMMENT 'Para ordenar archivos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `archivo_adjunto`
--

INSERT INTO `archivo_adjunto` (`id_archivo_adjunto`, `id_publicacion`, `tipo`, `nombre_archivo`, `orden`) VALUES
(128, 32, 'imagen', 'festival.jpg', 1),
(129, 32, 'imagen', 'students.jpg', 0),
(134, 35, 'imagen', 'first-day.png', 1),
(135, 36, 'imagen', 'EIpeFLUXsAAUdcb.jpg', 1),
(136, 36, 'imagen', 'EIpeEsSXsAAekIS.jfif', 0),
(137, 37, 'imagen', 'IMG-20211211-WA0000.jpg', 1),
(138, 37, 'imagen', 'IMG-20211211-WA0001.jpg', 0),
(139, 38, 'imagen', 'meeting.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `id_asignatura` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`id_asignatura`, `nombre`) VALUES
(1, 'Matemática'),
(2, 'Física'),
(3, 'Inglés'),
(4, 'Biología'),
(5, 'Arte y Patrimonio'),
(6, 'Química'),
(7, 'Orientación y Convivencia'),
(8, 'Formación para la Ciudadanía'),
(9, 'Historia y Geografía'),
(10, 'Grupo de Interés'),
(11, 'Castellano y Literatura'),
(12, 'Educación Física');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_escolar`
--

CREATE TABLE `calendario_escolar` (
  `id_calendario` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `titulo_evento` varchar(100) DEFAULT NULL,
  `descripcion_evento` text DEFAULT NULL,
  `laborable` enum('Si','No') NOT NULL DEFAULT 'Si',
  `fecha_evento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `calendario_escolar`
--

INSERT INTO `calendario_escolar` (`id_calendario`, `id_docente`, `id_administrador`, `titulo_evento`, `descripcion_evento`, `laborable`, `fecha_evento`) VALUES
(3, NULL, 2, 'Inicio del año escolar', 'El día 15 de septiembre se realizarán las inscripciones para todos los estudiantes', 'Si', '2025-09-15'),
(15, NULL, NULL, 'Suspensión de las actividades por fumigación', 'El día viernes 16 de mayo, se suspenden las actividades académicas por motivo de fumigación en la institución', 'No', '2025-05-16'),
(16, NULL, 2, 'Suspensión de clases por el natalicio del Dr. José Gregorio Hernández', 'El día lunes 27 de octubre por motivo del natalicio del Dr. José Gregorio Hernández, se cancelan todas las actividades administrativas y académicas.', 'No', '2025-10-27'),
(17, NULL, 2, 'Vacaciones', 'Las actividades académicas para todos los estudiantes, quedan suspendidas por las vacaciones de verano a partir del 11 de julio', 'No', '2025-07-11'),
(18, NULL, 2, 'Vacaciones navideñas', 'Las actividades académicas para todos los niveles quedan suspendidas a partir del 5 de diciembre por motivos de vacaciones navideñas. El personal del Complejo Educativo Rafael Rangel les desea a todos sus estudiantes unas felices navidades', 'No', '2025-12-05'),
(19, NULL, 2, 'Entrega de notas del segundo lapso', 'El día lunes 20 de abril se realizará la entrega de los boletines académicos pertinentes al segundo lapso del periodo escolar 2024-2025.\r\n\r\nSe realizará una reunión de padres y representantes a las 2:00pm en la cancha techada de la institución.', 'Si', '2026-04-20'),
(20, NULL, 2, 'Entrega de notas del tercer lapso', 'El día miércoles 16 de julio se realizará la entrega de los boletines académicos pertinentes al tercer lapso del periodo escolar 2024-2025.\r\n\r\nSe realizará una reunión de padres y representantes a las 2:00pm en la cancha techada de la institución.', 'No', '2025-07-16'),
(21, NULL, 2, 'Inicio de las actividades escolares del año 2025', 'A partir del día martes 7 de enero, arrancan todas las actividades escolares en la institución', 'Si', '2025-01-07'),
(22, NULL, 2, 'Festividades por el día del amor y la amistad', 'El día viernes 14 de febrero se celebrarán diferentes actividades por motivo de la celebración del día del amor y la amistad.\r\n\r\nTambién se realizará entrega de refrigerios en el comedor a partir de las 10:00 am.', 'Si', '2025-02-14'),
(23, NULL, 2, 'Suspensión de las actividades por carnaval', 'El día 3 y 4 de marzo quedan suspendidas todas las actividades académicas por motivo de la celebración del carnaval.', 'No', '2025-03-03'),
(24, NULL, 2, 'Suspensión de las actividades por carnaval', 'El día 3 y 4 de marzo quedan suspendidas todas las actividades académicas por motivo de la celebración del carnaval.', 'No', '2025-03-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` int(11) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` enum('Masculino','Femenino') NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono_personal` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `contrasena`, `cedula`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `direccion`, `telefono_personal`, `email`) VALUES
(62, '$2y$10$JGoeeOwMR7MXGliwsgoBWO10cGQUZMuPkLWZH8YhDXP67U7rWvxDa', 24000000, 'Alejandro', 'González', '1996-10-15', 'Masculino', 'La Beatriz', '04265875234', 'profesor@correo.com'),
(75, '$2y$10$15ZbZk1NzRZ3.9R3rlkUGebjMcvjnwJ4q7AUSwjdfg.eBf1jPZngG', 12345678, 'José Antonio', 'Pérez Ramírez', '1980-05-12', 'Masculino', 'Av. Bolívar, Valera', '04121234567', 'jose.perez@example.com'),
(76, '$2y$10$l8GwSynIEg2.Z4Mv4DGvKeqZGT4pfLwqzXRLxZsUcj0CFu3YBKMY2', 23456789, 'María Fernanda	', 'López García	', '1985-09-20', 'Femenino', 'Calle Principal, Trujillo	', '04149876543', 'maria.lopez@example.com'),
(77, '$2y$10$Tnx6DP3FeB5fPzcVGp3eWen/YJ.izdT/RKzX4WUJFxYiBSYay4CTy', 34567890, 'Luis Alberto	', 'Rodríguez Torres	', '1978-03-08', 'Masculino', 'Urb. La Floresta, Valera	', '04165556677', 'luis.rodriguez@example.com'),
(78, '$2y$10$62ymDmT5jGHnASGiey4OPOcw/j3JflSe75ysHwcn/R.RX2iW3OGO6', 45678901, 'Ana Carolina	', 'Mendoza Rivas	', '1990-11-15', 'Femenino', 'Sector La Plata, Valera	', '04242233445', 'ana.mendoza@example.com'),
(79, '$2y$10$SMxsY6a54GOEA2iYkVE1ZOnditdNkX4aGckATp6jlAgTW47qmD.Vy', 56789012, 'Pedro Enrique	', 'Salazar Díaz	', '1982-07-25', 'Masculino', 'Av. 6, Trujillo	', '04123344556', 'pedro.salazar@example.com'),
(80, '$2y$10$PGGuCd.5/QpP9PX4SeQ/UOSzHZagQ2LwuTyYAzNbB/4Wa4SMKKi/a', 67890123, 'Carmen Julia	', 'Ramírez Peña	', '1987-01-30', 'Femenino', 'Barrio San Luis, Valera	', '04167788990', 'carmen.ramirez@example.com'),
(81, '$2y$10$rkHJ37CmDBgHxh0EeXJq8uVWg9TYprPnuC64EFZVEmGRNXIkmmOou', 78901234, 'Rafael Eduardo	', 'Torres Pacheco	', '1975-04-18', 'Masculino', 'Av. Los Ilustres, Trujillo	', '04261122334', 'rafael.torres@example.com'),
(82, '$2y$10$5QQUWCRB.NUKu545IuR1NuP8MM51Gsol1.9ktqXVFJuO2Nbi7XMkm', 89012345, 'Daniela Sofía	', 'Gutiérrez Morales	', '1992-12-02', 'Femenino', 'Sector La Vega, Valera	', '04129988776', 'daniela.gutierrez@example.com'),
(83, '$2y$10$JOtI0lfTT06ppMxuAdnYPeS3zVgaQZJzbb1TUgE1laLkyy1FRDN52', 90123456, 'Jorge Luis	', 'Castillo Herrera	', '1984-06-10', 'Femenino', 'Av. 7, Trujillo	', '04145566778', 'jorge.castillo@example.com'),
(84, '$2y$10$wuXsWU8Ug2vTBpjjs.Ix8eZMkHNqvpqIA6Yr7HBjswgSyZNMatifa', 11223344, 'Patricia Elena	', 'Suárez Villalobos	', '1989-08-22', 'Femenino', 'Urb. El Prado, Valera	', '04246677889', 'patricia.suarez@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_asignatura_anio_seccion`
--

CREATE TABLE `docente_asignatura_anio_seccion` (
  `id_docente_asignatura_anio_seccion` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `id_anio_seccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `docente_asignatura_anio_seccion`
--

INSERT INTO `docente_asignatura_anio_seccion` (`id_docente_asignatura_anio_seccion`, `id_docente`, `id_asignatura`, `id_anio_seccion`) VALUES
(344, 62, 3, 8),
(340, 62, 4, 8),
(343, 62, 7, 8),
(342, 62, 9, 8),
(341, 62, 12, 8),
(345, 75, 1, 1),
(346, 75, 1, 5),
(347, 75, 2, 7),
(348, 76, 3, 2),
(349, 76, 3, 13),
(350, 76, 4, 6),
(351, 77, 6, 11),
(352, 77, 12, 15),
(355, 78, 9, 8),
(353, 78, 11, 3),
(354, 78, 11, 5),
(356, 79, 1, 10),
(357, 79, 7, 4),
(358, 79, 7, 9),
(359, 80, 5, 13),
(360, 80, 8, 4),
(361, 80, 8, 7),
(362, 81, 3, 5),
(363, 81, 12, 7),
(364, 81, 12, 14),
(366, 82, 1, 8),
(365, 82, 6, 6),
(368, 83, 7, 15),
(367, 83, 9, 11),
(370, 84, 5, 9),
(369, 84, 11, 4),
(371, 84, 12, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL,
  `id_anio_seccion` int(11) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` enum('Masculino','Femenino') NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono_personal` varchar(15) DEFAULT NULL,
  `telefono_representante` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `id_anio_seccion`, `contrasena`, `cedula`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `direccion`, `telefono_personal`, `telefono_representante`, `email`) VALUES
(9, 8, '$2y$10$HX8l79LPRogbuEUx8g4MdO4K299abPr/oNplkMIegqAbkxHUjw/zC', 11000000, 'José', 'Pérez', '2010-06-15', 'Masculino', 'Colina la Concepción', '0426000000', '04261111111', 'estudiante@correo.com'),
(13, 1, '$2y$10$.wycSQaL9DoBt5kGn6r6qOVUVGne1o06.STQppILj74cH5rVRPE9G', 30111222, 'Andrés Miguel	', 'Ramírez López	', '2008-04-15', 'Masculino', ' Av. Bolívar, Valera', '04121112233', '04145556677', 'andres.ramirez@example.com'),
(14, 5, '$2y$10$RghUpod3a/te1gb/g2VrGOxKEQBkcQKqWzDsfHHCrVXFHjcfpilYu', 30222333, 'Valeria Sofía	', 'Torres García	', '2007-09-20', 'Femenino', ' Urb. La Floresta, Trujillo', '04162223344', '04247788990', 'valeria.torres@example.com'),
(15, 9, '$2y$10$g7Jl4Wm2s84ZSQtR.C6C6eAjaCzvQx/QL7YQl90dSXD5G3RRIOCOi', 30333444, 'Carlos Eduardo	', 'Pérez Mendoza	', '2006-02-10', 'Masculino', ' Sector La Vega, Valera', '04143334455', '04129988776', 'carlos.perez@example.com'),
(16, 10, '$2y$10$O.lWVue0Q4L1H0ui6OY0muQUIV08e6jqJkDK7Tp2WuJ0H6S4VUBqm', 30444555, 'Mariana Elena	', 'Gutiérrez Rivas	', '2005-07-25', 'Femenino', ' Av. Los Ilustres, Trujillo', '04264445566', '04162233445', 'mariana.gutierrez@example.com'),
(17, 14, '$2y$10$jdZw7qnGJb72.ShyUbjLTuH7/f1A.Z7fXE81O8AvnN/UsXFa.KHMi', 30555666, 'José Alejandro	', 'Castillo Peña	', '2004-11-12', 'Masculino', ' Urb. El Prado, Valera', '04125556677', '04246677889', 'jose.castillo@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_asignatura_anio_seccion`
--

CREATE TABLE `estudiante_asignatura_anio_seccion` (
  `id_estudiante_asignatura` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `id_anio_seccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiante_asignatura_anio_seccion`
--

INSERT INTO `estudiante_asignatura_anio_seccion` (`id_estudiante_asignatura`, `id_estudiante`, `id_asignatura`, `id_anio_seccion`) VALUES
(102, 9, 1, 8),
(101, 9, 3, 8),
(97, 9, 4, 8),
(95, 9, 7, 8),
(93, 9, 9, 8),
(92, 9, 12, 8),
(103, 13, 1, 1),
(104, 14, 1, 5),
(106, 14, 3, 5),
(105, 14, 11, 5),
(108, 15, 5, 9),
(107, 15, 7, 9),
(109, 16, 1, 10),
(110, 17, 12, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_escolar`
--

CREATE TABLE `periodo_escolar` (
  `id_periodo_escolar` int(11) NOT NULL,
  `ciclo_escolar` varchar(9) DEFAULT NULL,
  `nota_lapso1` decimal(4,2) DEFAULT NULL,
  `nota_lapso2` decimal(4,2) DEFAULT NULL,
  `nota_lapso3` decimal(4,2) DEFAULT NULL,
  `inasistencia_lapso1` int(11) DEFAULT NULL,
  `inasistencia_lapso2` int(11) DEFAULT NULL,
  `inasistencia_lapso3` int(11) DEFAULT NULL,
  `id_estudiante_asignatura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `periodo_escolar`
--

INSERT INTO `periodo_escolar` (`id_periodo_escolar`, `ciclo_escolar`, `nota_lapso1`, `nota_lapso2`, `nota_lapso3`, `inasistencia_lapso1`, `inasistencia_lapso2`, `inasistencia_lapso3`, `id_estudiante_asignatura`) VALUES
(23, '2025-2026', 11.00, 13.00, 16.00, 7, 2, 2, 92),
(27, '2025-2026', 15.00, 18.00, 20.00, 2, 1, 0, 103),
(28, '2025-2026', 12.00, 16.00, 17.00, 2, 2, 2, 105),
(29, '2025-2026', 14.00, 12.00, 20.00, 5, 4, 0, 106),
(30, '2025-2026', 19.00, 19.00, 19.00, 0, 0, 0, 104),
(31, '2025-2026', 20.00, 20.00, 20.00, 1, 1, 1, 97),
(32, '2025-2026', 18.00, 19.00, 17.00, 4, 3, 7, 93),
(33, '2025-2026', 16.00, 16.00, 16.00, 1, 2, 2, 101),
(34, '2025-2026', 12.00, 12.00, 12.00, 12, 12, 12, 102),
(35, '2025-2026', 20.00, 19.00, 20.00, 2, 2, 1, 95),
(36, '2025-2026', 15.00, 14.00, 3.00, 5, 5, 17, 108),
(37, '2025-2026', 13.00, 17.00, 15.00, 3, 2, 1, 107),
(38, '2025-2026', 19.00, 17.00, 17.00, 4, 3, 3, 109),
(39, '2025-2026', 18.00, 18.00, 18.00, 2, 2, 2, 110);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `id_publicacion` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `titulo_publicacion` varchar(100) NOT NULL,
  `descripcion_publicacion` text NOT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`id_publicacion`, `id_docente`, `id_administrador`, `titulo_publicacion`, `descripcion_publicacion`, `fecha_publicacion`) VALUES
(32, NULL, NULL, 'Juegos de Inter-curso 2025', 'Desde el lunes 13 de octubre hasta el viernes 17, se realizarán los juegos de Inter-curso en la institución, destacando el baloncesto, fútbol, ping pong, ajedrez y el voleibol.\r\n\r\nTodos los estudiantes que quieran participar, estarán exentos de inasistencias de sus clases siempre y cuando se confirme su participación.', '2025-10-10 18:28:49'),
(35, NULL, NULL, 'Inscripciones del año escolar 2024-2025', 'El día lunes 8 de septiembre se realizarán las inscripciones de los estudiantes regulares y de nuevo ingreso para todos los niveles.\r\n\r\nSi es estudiante de nuevo ingreso, el representante deberá llevar los siguientes requisitos: una copia de cédula de identidad del estudiante y una de un representante, copia de la partida de nacimiento y dos fotografías tipo carnet del estudiante.\r\n\r\nSi es estudiante regular, el representante solo deberá llevar una copia de cédula del estudiante', '2025-09-05 17:06:48'),
(36, NULL, NULL, 'Feria de ciencias', 'Los días 15 y 16 de mayo se celebrarán en el pasillo principal, diferentes exposiciones y demostraciones de experimentos científicos en el pasillo principal de la institución.', '2025-05-02 17:16:29'),
(37, NULL, NULL, 'Mantenimiento a nuestra amada casa de estudio', 'El día 18 y 19 de Abril, con la colaboración de la Alcaldía de Valera y los padres y representantes de nuestros estudiantes, se realizarán actividades de mantenimiento y recuperación de espacios en nuestra amada casa de estudio.', '2025-04-10 17:19:42'),
(38, NULL, NULL, 'Reunión de padres y representantes', 'El día lunes 31 de marzo, se realizará una reunión de padres y representantes para socializar sobre las actividades de mantenimiento y recuperación de espacios en el complejo educativo. La hora de la reunión será a las 2:00pm', '2025-03-24 17:30:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_administrador`);

--
-- Indices de la tabla `anio_seccion`
--
ALTER TABLE `anio_seccion`
  ADD PRIMARY KEY (`id_anio_seccion`),
  ADD UNIQUE KEY `uk_anio_seccion` (`anio`,`seccion`);

--
-- Indices de la tabla `archivo_adjunto`
--
ALTER TABLE `archivo_adjunto`
  ADD PRIMARY KEY (`id_archivo_adjunto`),
  ADD KEY `fk_archivo_adjunto_publicacion` (`id_publicacion`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`id_asignatura`);

--
-- Indices de la tabla `calendario_escolar`
--
ALTER TABLE `calendario_escolar`
  ADD PRIMARY KEY (`id_calendario`),
  ADD KEY `fk_calendario_escolar_docente` (`id_docente`),
  ADD KEY `fk_calendario_administrador` (`id_administrador`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id_docente`);

--
-- Indices de la tabla `docente_asignatura_anio_seccion`
--
ALTER TABLE `docente_asignatura_anio_seccion`
  ADD PRIMARY KEY (`id_docente_asignatura_anio_seccion`),
  ADD UNIQUE KEY `uk_docente_asignatura_anio_seccion_unique` (`id_docente`,`id_asignatura`,`id_anio_seccion`),
  ADD KEY `fk_docente_asignatura_asignatura` (`id_asignatura`),
  ADD KEY `fk_docente_asignatura_anio_seccion` (`id_anio_seccion`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_estudiante_anio_seccion` (`id_anio_seccion`);

--
-- Indices de la tabla `estudiante_asignatura_anio_seccion`
--
ALTER TABLE `estudiante_asignatura_anio_seccion`
  ADD PRIMARY KEY (`id_estudiante_asignatura`),
  ADD UNIQUE KEY `uk_estudiante_asignatura_unique` (`id_estudiante`,`id_asignatura`),
  ADD UNIQUE KEY `uk_estudiante_asignatura_anio_seccion` (`id_estudiante`,`id_asignatura`,`id_anio_seccion`),
  ADD KEY `fk_estudiante_asignatura_asignatura` (`id_asignatura`),
  ADD KEY `id_anio_seccion` (`id_anio_seccion`);

--
-- Indices de la tabla `periodo_escolar`
--
ALTER TABLE `periodo_escolar`
  ADD PRIMARY KEY (`id_periodo_escolar`),
  ADD KEY `id_estudiante_asignatura_anio_seccion` (`id_estudiante_asignatura`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `fk_publicacion_docente` (`id_docente`),
  ADD KEY `fk_publicacion_administrador` (`id_administrador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `anio_seccion`
--
ALTER TABLE `anio_seccion`
  MODIFY `id_anio_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `archivo_adjunto`
--
ALTER TABLE `archivo_adjunto`
  MODIFY `id_archivo_adjunto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id_asignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `calendario_escolar`
--
ALTER TABLE `calendario_escolar`
  MODIFY `id_calendario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `docente_asignatura_anio_seccion`
--
ALTER TABLE `docente_asignatura_anio_seccion`
  MODIFY `id_docente_asignatura_anio_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `estudiante_asignatura_anio_seccion`
--
ALTER TABLE `estudiante_asignatura_anio_seccion`
  MODIFY `id_estudiante_asignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `periodo_escolar`
--
ALTER TABLE `periodo_escolar`
  MODIFY `id_periodo_escolar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivo_adjunto`
--
ALTER TABLE `archivo_adjunto`
  ADD CONSTRAINT `fk_archivo_adjunto_publicacion` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id_publicacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `calendario_escolar`
--
ALTER TABLE `calendario_escolar`
  ADD CONSTRAINT `fk_calendario_escolar_administrador` FOREIGN KEY (`id_administrador`) REFERENCES `administrador` (`id_administrador`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_calendario_escolar_docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE SET NULL;

--
-- Filtros para la tabla `docente_asignatura_anio_seccion`
--
ALTER TABLE `docente_asignatura_anio_seccion`
  ADD CONSTRAINT `fk_docente_asignatura_anio_seccion` FOREIGN KEY (`id_anio_seccion`) REFERENCES `anio_seccion` (`id_anio_seccion`),
  ADD CONSTRAINT `fk_docente_asignatura_asignatura` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`),
  ADD CONSTRAINT `fk_docente_asignatura_docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudiante_anio_seccion` FOREIGN KEY (`id_anio_seccion`) REFERENCES `anio_seccion` (`id_anio_seccion`);

--
-- Filtros para la tabla `estudiante_asignatura_anio_seccion`
--
ALTER TABLE `estudiante_asignatura_anio_seccion`
  ADD CONSTRAINT `estudiante_asignatura_anio_seccion_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`),
  ADD CONSTRAINT `estudiante_asignatura_anio_seccion_ibfk_2` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`),
  ADD CONSTRAINT `estudiante_asignatura_anio_seccion_ibfk_3` FOREIGN KEY (`id_anio_seccion`) REFERENCES `anio_seccion` (`id_anio_seccion`),
  ADD CONSTRAINT `fk_estudiante_asignatura_asignatura` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`),
  ADD CONSTRAINT `fk_estudiante_asignatura_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`);

--
-- Filtros para la tabla `periodo_escolar`
--
ALTER TABLE `periodo_escolar`
  ADD CONSTRAINT `periodo_escolar_ibfk_1` FOREIGN KEY (`id_estudiante_asignatura`) REFERENCES `estudiante_asignatura_anio_seccion` (`id_estudiante_asignatura`);

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `fk_publicacion_administrador` FOREIGN KEY (`id_administrador`) REFERENCES `administrador` (`id_administrador`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_publicacion_docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
