-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sistema_disciplinario
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `contrasenas`
--

DROP TABLE IF EXISTS `contrasenas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrasenas` (
  `contrasena_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `contrasena_hash` varchar(255) NOT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`contrasena_id`),
  UNIQUE KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `fk_contrasena_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrasenas`
--

LOCK TABLES `contrasenas` WRITE;
/*!40000 ALTER TABLE `contrasenas` DISABLE KEYS */;
INSERT INTO `contrasenas` VALUES (1,1,'$2y$10$Wx/XGYHBpLlaj2JrXgdgBeNctsZc2/PLPLQn4yGbz.ns6t/Hh6xyS','2026-11-04 03:13:39'),(2,2,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','2026-10-21 01:57:19'),(3,3,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','2026-10-21 01:57:19'),(4,4,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','2026-10-21 01:57:19'),(5,5,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','2026-10-21 01:57:19'),(6,6,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','2026-10-21 01:57:19'),(7,7,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','2026-10-21 01:57:19'),(8,8,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','2026-10-21 01:57:19'),(9,9,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','2026-10-21 01:57:19'),(10,10,'$2y$10$TVWf8K4jtQGIkfbuEZ3NjOhwty2NnZqYOl/Qg7tkqzDRz6FUi0lpK','2026-11-04 03:09:32');
/*!40000 ALTER TABLE `contrasenas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docentes`
--

DROP TABLE IF EXISTS `docentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docentes` (
  `docente_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `grado_encargado` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`docente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docentes`
--

LOCK TABLES `docentes` WRITE;
/*!40000 ALTER TABLE `docentes` DISABLE KEYS */;
INSERT INTO `docentes` VALUES (1,'Carmen','López','Primero Primaria'),(2,'Jorge','Ramírez','Segundo Primaria'),(3,'Andrea','Castillo','Tercero Primaria'),(4,'Mario','Gómez','Cuarto Primaria'),(5,'Elena','Pérez','Quinto Primaria'),(6,'David','Morales','Sexto Primaria'),(7,'Paola','Díaz','Primero Básico'),(8,'Daniel','Suhul','Segundo Básico'),(9,'Marta Patricia','Soto Alvarado','Primero Primaria');
/*!40000 ALTER TABLE `docentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encargado`
--

DROP TABLE IF EXISTS `encargado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encargado` (
  `encargado_id` int(11) NOT NULL AUTO_INCREMENT,
  `parentesco` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  PRIMARY KEY (`encargado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encargado`
--

LOCK TABLES `encargado` WRITE;
/*!40000 ALTER TABLE `encargado` DISABLE KEYS */;
INSERT INTO `encargado` VALUES (1,'Madre','Rosa','García López','55551005'),(2,'Padre','Miguel','Torres Díaz','55551006'),(3,'Madre','Claudia','Morales Ruiz','55551007'),(4,'Padre','Francisco','Díaz Pérez','55551008'),(5,'Madre','Patricia','López Méndez','55551009'),(6,'Padre','Antonio','Ruiz Castillo','55551010');
/*!40000 ALTER TABLE `encargado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_reporte`
--

DROP TABLE IF EXISTS `estado_reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_reporte` (
  `estado_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`estado_id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_reporte`
--

LOCK TABLES `estado_reporte` WRITE;
/*!40000 ALTER TABLE `estado_reporte` DISABLE KEYS */;
INSERT INTO `estado_reporte` VALUES (1,'Pendiente','Reporte registrado y en espera de revisión'),(2,'En Proceso','En seguimiento, citación de padres o mediación'),(3,'Resuelto','Falta atendida y compromiso o sanción cumplida'),(4,'Archivado','Caso cerrado y archivado en el expediente');
/*!40000 ALTER TABLE `estado_reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudiantes` (
  `estudiantes_id` int(11) NOT NULL AUTO_INCREMENT,
  `grado_seccion_id` int(11) NOT NULL,
  `encargado_id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`estudiantes_id`),
  KEY `fk_est_grado_seccion` (`grado_seccion_id`),
  KEY `fk_est_encargado` (`encargado_id`),
  CONSTRAINT `fk_est_encargado` FOREIGN KEY (`encargado_id`) REFERENCES `encargado` (`encargado_id`),
  CONSTRAINT `fk_est_grado_seccion` FOREIGN KEY (`grado_seccion_id`) REFERENCES `grados_secciones` (`grado_seccion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiantes`
--

LOCK TABLES `estudiantes` WRITE;
/*!40000 ALTER TABLE `estudiantes` DISABLE KEYS */;
INSERT INTO `estudiantes` VALUES (13,1,1,'Carlos Eduardo','López García','2014-03-15','Masculino'),(14,1,2,'Sofía Valeria','Torres Mendoza','2014-07-22','Femenino'),(15,2,3,'Diego Alejandro','Morales Morales','2013-05-10','Masculino'),(16,2,4,'Jose maria','Díaz Pérez','2013-11-04','Femenino'),(17,3,5,'José Gabriel','López Méndez','2012-02-18','Masculino'),(18,3,6,'Valentina Isabella','Ruiz Castillo','2012-08-30','Femenino'),(19,4,1,'Mateo Sebastián','García Ruiz','2011-09-14','Masculino'),(20,4,2,'Lucía Camila','Torres Pérez','2011-12-01','Femenino'),(21,1,1,'Pedro Alexander','Castillo Morales','2015-06-12','Masculino'),(22,5,1,'Ana Lucia','Mendez Gomez','2010-04-18','Femenino');
/*!40000 ALTER TABLE `estudiantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grados`
--

DROP TABLE IF EXISTS `grados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grados` (
  `grado_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_grado` varchar(100) NOT NULL,
  PRIMARY KEY (`grado_id`),
  UNIQUE KEY `nombre_grado` (`nombre_grado`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grados`
--

LOCK TABLES `grados` WRITE;
/*!40000 ALTER TABLE `grados` DISABLE KEYS */;
INSERT INTO `grados` VALUES (5,'Cuarto Primaria'),(1,'Preprimaria'),(8,'Primero Basico'),(2,'Primero Primaria'),(6,'Quinto Primaria'),(3,'Segundo Primaria'),(7,'Sexto Primaria'),(4,'Tercero Primaria');
/*!40000 ALTER TABLE `grados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grados_secciones`
--

DROP TABLE IF EXISTS `grados_secciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grados_secciones` (
  `grado_seccion_id` int(11) NOT NULL AUTO_INCREMENT,
  `grado_id` int(11) NOT NULL,
  `seccion_id` int(11) NOT NULL,
  `ciclo_lectivo` year(4) NOT NULL,
  PRIMARY KEY (`grado_seccion_id`),
  UNIQUE KEY `uq_grado_seccion_ciclo` (`grado_id`,`seccion_id`,`ciclo_lectivo`),
  KEY `fk_gs_seccion` (`seccion_id`),
  CONSTRAINT `fk_gs_grado` FOREIGN KEY (`grado_id`) REFERENCES `grados` (`grado_id`),
  CONSTRAINT `fk_gs_seccion` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`seccion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grados_secciones`
--

LOCK TABLES `grados_secciones` WRITE;
/*!40000 ALTER TABLE `grados_secciones` DISABLE KEYS */;
INSERT INTO `grados_secciones` VALUES (1,4,1,2026),(2,5,1,2026),(3,6,1,2026),(4,7,1,2026),(5,8,1,2026),(6,8,2,2026);
/*!40000 ALTER TABLE `grados_secciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificaciones` (
  `notificacion_id` int(11) NOT NULL AUTO_INCREMENT,
  `reporte_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_envio` datetime NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_lectura` datetime DEFAULT NULL,
  PRIMARY KEY (`notificacion_id`),
  KEY `fk_notificacion_reporte` (`reporte_id`),
  KEY `fk_notificacion_usuario` (`usuario_id`),
  CONSTRAINT `fk_notificacion_reporte` FOREIGN KEY (`reporte_id`) REFERENCES `reportes_disciplinarios` (`reporte_id`),
  CONSTRAINT `fk_notificacion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuarios_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reportes_disciplinarios`
--

DROP TABLE IF EXISTS `reportes_disciplinarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reportes_disciplinarios` (
  `reporte_id` int(11) NOT NULL AUTO_INCREMENT,
  `estudiante_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `tipo_falta_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `descripcion_falta` text NOT NULL,
  `acciones_tomadas` text DEFAULT NULL,
  PRIMARY KEY (`reporte_id`),
  KEY `fk_reporte_docente` (`docente_id`),
  KEY `fk_reporte_tipo_falta` (`tipo_falta_id`),
  KEY `fk_reporte_estado` (`estado_id`),
  KEY `fk_reporte_estudiante` (`estudiante_id`),
  CONSTRAINT `fk_reporte_docente` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`docente_id`),
  CONSTRAINT `fk_reporte_estado` FOREIGN KEY (`estado_id`) REFERENCES `estado_reporte` (`estado_id`),
  CONSTRAINT `fk_reporte_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`estudiantes_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reporte_tipo_falta` FOREIGN KEY (`tipo_falta_id`) REFERENCES `tipos_de_falta` (`tipo_falta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportes_disciplinarios`
--

LOCK TABLES `reportes_disciplinarios` WRITE;
/*!40000 ALTER TABLE `reportes_disciplinarios` DISABLE KEYS */;
INSERT INTO `reportes_disciplinarios` VALUES (9,13,3,1,1,'2026-10-21','08:30:00','No presentó tarea de Matemáticas','El estudiante no entregó el cuaderno de ejercicios programado para el día de hoy sin justificación previa.','Se notificó al estudiante y se le dio prórroga de 24 horas con constancia en el sistema.'),(10,14,4,2,2,'2026-10-21','10:15:00','Interrupción constante y lenguaje inapropiado','Durante la clase de Ciencias, interrumpió repetidamente la explicación del profesor e insultó a un compañero de aula.','Se dialogó con el estudiante y se citó al encargado para el día de mañana.'),(11,13,1,2,1,'2026-10-21','10:30:00','Uso indebido de celular en clase','El estudiante utilizo el telefono celular durante la sesion de clase tras varias advertencias.','Se retuvo el dispositivo hasta la salida y se notifico a la madre de familia.'),(12,13,9,1,1,'2026-11-03','09:15:00','Falta de entrega de tarea de lectura','El estudiante no presento la lectura asignada y el resumen correspondiente.','Se le solicito entregar la actividad manana con firma de la madre.');
/*!40000 ALTER TABLE `reportes_disciplinarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','Administra el sistema'),(2,'Docente','Registra y consulta reportes'),(3,'Encargado','Consulta reportes de sus estudiantes');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secciones`
--

DROP TABLE IF EXISTS `secciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `secciones` (
  `seccion_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_seccion` varchar(50) NOT NULL,
  PRIMARY KEY (`seccion_id`),
  UNIQUE KEY `nombre_seccion` (`nombre_seccion`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secciones`
--

LOCK TABLES `secciones` WRITE;
/*!40000 ALTER TABLE `secciones` DISABLE KEYS */;
INSERT INTO `secciones` VALUES (1,'C'),(2,'D'),(3,'E'),(4,'F'),(5,'G'),(6,'H'),(7,'I'),(8,'J');
/*!40000 ALTER TABLE `secciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_de_falta`
--

DROP TABLE IF EXISTS `tipos_de_falta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_de_falta` (
  `tipo_falta_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `gravedad` enum('Leve','Moderada','Grave','Muy grave') NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`tipo_falta_id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_de_falta`
--

LOCK TABLES `tipos_de_falta` WRITE;
/*!40000 ALTER TABLE `tipos_de_falta` DISABLE KEYS */;
INSERT INTO `tipos_de_falta` VALUES (1,'Incumplimiento de tareas','Leve','El estudiante no presenta una tarea asignada'),(2,'Falta de respeto','Moderada','Conducta irrespetuosa hacia otra persona'),(3,'Agresion fisica','Grave','Conducta que implica agresion fisica'),(4,'Dano a instalaciones','Moderada','Dano a bienes del centro educativo');
/*!40000 ALTER TABLE `tipos_de_falta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `usuarios_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo_electronico` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`usuarios_id`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`),
  KEY `fk_usuarios_rol` (`rol_id`),
  CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,2,'Carmen','López','carmen@escuela.com','55552004','$2y$10$Wx/XGYHBpLlaj2JrXgdgBeNctsZc2/PLPLQn4yGbz.ns6t/Hh6xyS','Activo'),(2,2,'Jorge','Ramírez','jorge@escuela.com','55552005','$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','Activo'),(3,2,'Andrea','Castillo','andrea@escuela.com','55552006','$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','Activo'),(4,2,'Mario','Gómez','mario@escuela.com','55552007','$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','Activo'),(5,2,'Elena','Pérez','elena@escuela.com','55552008','$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','Activo'),(6,2,'David','Morales','david@escuela.com','55552009','$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','Activo'),(7,2,'Paola','Díaz','paola@escuela.com','55552010','$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','Activo'),(8,1,'Brenda','Rodriguez','brendavas20022332@gmail.com',NULL,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','Activo'),(9,2,'Daniel','Suhul','danielsuhulsandoval@gmail.com',NULL,'$2y$10$Xlc4w4lGT8yIMAr/JCxryeXByEUtpha91hob.lNlvuXeqJ4iPo/.G','Activo'),(10,2,'Marta Patricia','Soto Alvarado','marta@escuela.com','55553001','$2y$10$TVWf8K4jtQGIkfbuEZ3NjOhwty2NnZqYOl/Qg7tkqzDRz6FUi0lpK','Activo');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-03 21:59:04
