-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2025 a las 18:34:01
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
(62, '$2y$10$JGoeeOwMR7MXGliwsgoBWO10cGQUZMuPkLWZH8YhDXP67U7rWvxDa', 24000000, 'Alejandro', 'González', '1996-10-15', 'Masculino', 'La Beatriz', '04265875234', 'profesor@correo.com');

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
(341, 62, 12, 8);

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
(9, 8, '$2y$10$HX8l79LPRogbuEUx8g4MdO4K299abPr/oNplkMIegqAbkxHUjw/zC', 11000000, 'José', 'Pérez', '2010-06-15', 'Masculino', 'Colina la Concepción', '0426000000', '04261111111', 'estudiante@correo.com');

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
(101, 9, 3, 8),
(97, 9, 4, 8),
(95, 9, 7, 8),
(93, 9, 9, 8),
(92, 9, 12, 8);

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
(23, '2025-2026', 11.00, NULL, NULL, NULL, NULL, NULL, 92);

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
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `docente_asignatura_anio_seccion`
--
ALTER TABLE `docente_asignatura_anio_seccion`
  MODIFY `id_docente_asignatura_anio_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `estudiante_asignatura_anio_seccion`
--
ALTER TABLE `estudiante_asignatura_anio_seccion`
  MODIFY `id_estudiante_asignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `periodo_escolar`
--
ALTER TABLE `periodo_escolar`
  MODIFY `id_periodo_escolar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
