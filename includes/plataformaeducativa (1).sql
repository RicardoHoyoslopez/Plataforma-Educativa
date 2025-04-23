-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2025 a las 20:34:48
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `bonificaciones_estudiantes` (
  `id_bonificacion` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `clases_completadas` int(11) DEFAULT NULL,
  `bonificacion` decimal(10,2) DEFAULT NULL,
  `fecha_asignacion` datetime DEFAULT NULL,
  `estado` enum('Activa','Inactiva') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `clases` (
  `id_clase` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `profesor_id` int(11) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `estado` enum('Activa','Inactiva','Finalizada') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `clases` (`id_clase`, `titulo`, `descripcion`, `profesor_id`, `precio`, `fecha_creacion`, `estado`) VALUES
(14, 'Fisica', 'fisica abanzada', 32, NULL, '2025-04-09 21:51:00', 'Activa'),
(15, 'Matematicas', 'Matematicas basicas', 30, NULL, '2025-04-09 20:52:00', 'Activa'),
(16, 'Matematicas', 'sad', 44, NULL, '2025-04-10 15:41:00', 'Activa');



CREATE TABLE `documentos_docente` (
  `id_documento` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `tipo_documento` enum('CV','Certificado','Otro') NOT NULL,
  `url_documento` varchar(255) NOT NULL,
  `fecha_subida` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `horarios` (
  `id_horario` int(11) NOT NULL,
  `id_clase` int(11) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `horarios` (`id_horario`, `id_clase`, `dia`, `hora_inicio`, `hora_fin`) VALUES
(5, 14, 'Lunes', '20:00:00', '22:00:00'),
(6, 15, 'Martes', '18:00:00', '20:00:00'),
(7, 16, 'Miércoles', '16:40:00', '17:40:00');



CREATE TABLE `inscripciones` (
  `id_inscripcion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_clase` int(11) NOT NULL,
  `fecha_inscripcion` datetime DEFAULT NULL,
  `estado` enum('Pendiente','Aprobada','Rechazada') DEFAULT NULL,
  `puntos_obtenidos` int(11) DEFAULT NULL,
  `calificacion_docente` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `pqrs` (
  `id_pqrs` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` enum('Petición','Queja','Reclamo','Sugerencia') NOT NULL,
  `asunto` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `estado` enum('Abierto','En proceso','Cerrado') DEFAULT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `fecha_resolucion` datetime DEFAULT NULL,
  `solucion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Admin'),
(2, 'Cliente'),
(3, 'Docente');



CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Clave` varchar(255) NOT NULL,
  `Nombre_Completo` varchar(255) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `experiencia_laboral` text DEFAULT NULL,
  `hoja_vida_path` varchar(255) DEFAULT NULL,
  `titulo_profesional` varchar(100) DEFAULT NULL,
  `estado_verificacion` enum('Pendiente','Verificado','Rechazado') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `usuarios` (`id`, `Usuario`, `Clave`, `Nombre_Completo`, `Telefono`, `Direccion`, `Email`, `rol_id`, `activo`, `experiencia_laboral`, `hoja_vida_path`, `titulo_profesional`, `estado_verificacion`) VALUES
(27, 'yuanw5', '$2y$10$EiR7hiF5sEX3fjC8xNUSTOFbxc99qcHdF5uzgPiKGIoTiE2jhwPOK', 'Juan Manuel Rodriguez', '13133', 'callw2e3', 'yuanw5@akdsksk', 2, 1, NULL, NULL, NULL, 'Pendiente'),
(30, 'Ricardo002', '$2y$10$3KyQS3RjtTE2WTTWq8U17ONeyqGMQVjUjzgH3OJI7CTMonJvRpWy.', 'Ricardo Hoyos', '234141', 'calle 35', 'Ricardo0@gmail.com', 3, 1, NULL, NULL, NULL, 'Pendiente'),
(32, 'Hugoro19', '$2y$10$WKRVPqB1xDxiVoQ3J90qbusMpLfB.fs8c4DS1iFgHBMSfuUndgW1S', 'Hugo Rodriguez', '133212', 'calle 24', 'Hugoro19@gmail.com', 3, 1, NULL, NULL, NULL, 'Pendiente'),
(42, 'juano', '$2y$10$WyXOE.3hpLzyWfVYO9RS8eWRiyMTSx.XVuxnDhpLFxobq33Su9mLu', 'juano', '1312', 'juano', 'juano@kqw', 3, 1, NULL, NULL, NULL, 'Pendiente'),
(43, 'asdaf', '$2y$10$OGM7MUe4n40/O8em9brVLeigdyTRCQhCKvSv8nYhAlIUMRBLb7JIO', 'asdaf', '231234', 'asdaf', 'asdaf@kwrf', 3, 1, 'asdaf', NULL, 'asdaf', 'Pendiente'),
(44, 'woz de dominic tuiz', '$2y$10$2IehYku6cph9melDCCFtteOebABKGP7NkkA7tQGiT.mhok9uqOR4q', 'woz de dominic tuiz', '123414', 'iero', 'woz@gmail.com', 3, 1, 'woz de dominic tuiz', 'uploads/hoja_vida_path/67f82c310ab4d_cvJuanupdated.pdf', 'woz de dominic tuiz', 'Pendiente'),
(45, '02juanrs', '$2y$10$6.zasNveGOcLIm2yUlRlIuC.03NufnjI9Gqy8tbrQifLU7wKvlaua', 'Juan Manuel Rodriguez Silva', '3137325545', 'calle 27', '02juanrs@gmail.com', 3, 1, 'Desarrollador de software', 'uploads/hoja_vida_path/67f8492143b34_FOTOlibreta.pdf', 'Ingeniero de sistemas', 'Pendiente'),
(46, 'Juan Villa222', '$2y$10$wPyqvgN0zIeY/qaeP4tUtugn.d0v0oIVPQsDmHHecJKZcCjzrow9C', 'Juan Villa', '1323', 'JuancalleVilla', 'JuanVilla@gmail.com', 3, 1, 'smdafm', 'uploads/hoja_vida_path/680931dbd55bd_Taller2corteDocumentoTecnicoMGAProyectos2025Abril.pdf', 'asdk', 'Pendiente');


ALTER TABLE `bonificaciones_estudiantes`
  ADD PRIMARY KEY (`id_bonificacion`),
  ADD KEY `fk_estudiante_bonificacion` (`id_estudiante`);


ALTER TABLE `clases`
  ADD PRIMARY KEY (`id_clase`),
  ADD KEY `fk_profesor_clase` (`profesor_id`);


ALTER TABLE `documentos_docente`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `fk_docente_documento` (`id_docente`);


ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_clase` (`id_clase`);


ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `fk_usuario_inscripcion` (`id_usuario`),
  ADD KEY `fk_clase_inscripcion` (`id_clase`);


ALTER TABLE `pqrs`
  ADD PRIMARY KEY (`id_pqrs`),
  ADD KEY `fk_usuario_pqrs` (`id_usuario`),
  ADD KEY `fk_admin_pqrs` (`id_administrador`);


ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`);



ALTER TABLE `bonificaciones_estudiantes`
  MODIFY `id_bonificacion` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `clases`
  MODIFY `id_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `documentos_docente`
--
ALTER TABLE `documentos_docente`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pqrs`
--
ALTER TABLE `pqrs`
  MODIFY `id_pqrs` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bonificaciones_estudiantes`
--
ALTER TABLE `bonificaciones_estudiantes`
  ADD CONSTRAINT `fk_estudiante_bonificacion` FOREIGN KEY (`id_estudiante`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clases`
--
ALTER TABLE `clases`
  ADD CONSTRAINT `fk_profesor_clase` FOREIGN KEY (`profesor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documentos_docente`
--
ALTER TABLE `documentos_docente`
  ADD CONSTRAINT `fk_docente_documento` FOREIGN KEY (`id_docente`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`id_clase`) REFERENCES `clases` (`id_clase`);

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `fk_clase_inscripcion` FOREIGN KEY (`id_clase`) REFERENCES `clases` (`id_clase`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_inscripcion` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pqrs`
--
ALTER TABLE `pqrs`
  ADD CONSTRAINT `fk_admin_pqrs` FOREIGN KEY (`id_administrador`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_usuario_pqrs` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
