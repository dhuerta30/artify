-- Simple Backup SQL Dump
-- Version 1.0.3
-- https://www.github.com/coderatio/simple-backup/
--
-- Host: localhost:3306
-- Generation Time: Jul 30, 2024 at 11:01 AM
-- MYSQL Server Version: 5.5.5-10.4.24-MariaDB
-- PHP Version: 7.4.29
-- Developer: Josiah O. Yahaya
-- Copyright: Coderatio

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00"

--
-- Database: `sistema_apa`
-- Total Tables: 19
--

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backup`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `archivo` varchar(300) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `backup` VALUES (61,'admin','procedimiento1709047088.sql','2024-02-27','12:18:08'),(62,'admin','procedimiento1709047233.sql','2024-02-27','12:20:33'),(63,'admin','procedimiento1709047314.sql','2024-02-27','12:21:54'),(64,'admin','procedimiento1722354537.sql','2024-07-30','11:48:57');
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `backup` with 4 row(s)
--

--
-- Table structure for table `campos`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campos` (
  `id_campos` int(11) NOT NULL AUTO_INCREMENT,
  `id_modulos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_de_campo` varchar(100) NOT NULL,
  `nulo` varchar(100) NOT NULL,
  `visibilidad_formulario` varchar(100) NOT NULL,
  `visibilidad_busqueda` varchar(100) NOT NULL,
  `visibilidad_de_filtro_busqueda` varchar(100) NOT NULL,
  `visibilidad_grilla` varchar(100) NOT NULL,
  `indice` varchar(100) DEFAULT NULL,
  `autoincrementable` varchar(100) DEFAULT NULL,
  `tipo` varchar(100) NOT NULL,
  `longitud` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_campos`)
) ENGINE=InnoDB AUTO_INCREMENT=709 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campos`
--

LOCK TABLES `campos` WRITE;
/*!40000 ALTER TABLE `campos` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `campos` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `campos` with 0 row(s)
--

--
-- Table structure for table `centroderivacion`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centroderivacion` (
  `Idcentroderivacion` int(20) NOT NULL AUTO_INCREMENT,
  `centroderivacion` varchar(20) NOT NULL,
  PRIMARY KEY (`Idcentroderivacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centroderivacion`
--

LOCK TABLES `centroderivacion` WRITE;
/*!40000 ALTER TABLE `centroderivacion` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `centroderivacion` VALUES (1,'HSJDD'),(2,'Citolab'),(3,'CEMESI');
/*!40000 ALTER TABLE `centroderivacion` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `centroderivacion` with 3 row(s)
--

--
-- Table structure for table `configuracion_general`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion_general` (
  `id_configuracion` int(11) NOT NULL AUTO_INCREMENT,
  `logo_login` varchar(300) DEFAULT NULL,
  `imagen_de_fondo_login` varchar(300) DEFAULT NULL,
  `color_fondo_login` varchar(100) DEFAULT NULL,
  `imagen_de_carga` varchar(300) NOT NULL,
  PRIMARY KEY (`id_configuracion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion_general`
--

LOCK TABLES `configuracion_general` WRITE;
/*!40000 ALTER TABLE `configuracion_general` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `configuracion_general` VALUES (1,'1712676458_1710180276_hospital.jpg','1712677091_1712676037_Eyes_medicine_Glance_547947_1920x1080.png','','1712681386_03-19-26-213_512.gif');
/*!40000 ALTER TABLE `configuracion_general` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `configuracion_general` with 1 row(s)
--

--
-- Table structure for table `criticosapa`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criticosapa` (
  `Idregistro` int(20) NOT NULL AUTO_INCREMENT,
  `Idsolicitud` int(20) DEFAULT NULL,
  `rut` varchar(20) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apaterno` varchar(100) DEFAULT NULL,
  `amaterno` varchar(100) DEFAULT NULL,
  `fecharesultado` datetime DEFAULT NULL,
  `hipotesisdiagnostica` varchar(100) DEFAULT NULL,
  `resultadocritico` varchar(100) DEFAULT NULL,
  `nmedico` int(20) DEFAULT NULL,
  `fechaentrega` datetime DEFAULT NULL,
  `funcionarioentrega` varchar(100) DEFAULT NULL,
  `funcionariorecibe` varchar(100) DEFAULT NULL,
  `servicio` varchar(10) DEFAULT NULL,
  `notificado` varchar(10) DEFAULT 'No',
  `medionotificacion` varchar(10) DEFAULT NULL,
  `fecharegistro` timestamp NULL DEFAULT NULL,
  `observaciones` varchar(10) DEFAULT NULL,
  `documento` varchar(10) DEFAULT NULL,
  `usuario` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Idregistro`),
  KEY `Idsolicitud` (`Idsolicitud`),
  CONSTRAINT `criticosapa_ibfk_1` FOREIGN KEY (`Idsolicitud`) REFERENCES `solicitudesapa` (`Idsolicitud`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criticosapa`
--

LOCK TABLES `criticosapa` WRITE;
/*!40000 ALTER TABLE `criticosapa` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `criticosapa` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `criticosapa` with 0 row(s)
--

--
-- Table structure for table `estado`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `Idestado` int(20) NOT NULL AUTO_INCREMENT,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`Idestado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `estado` VALUES (1,'Solicitado'),(2,'Recepcionado'),(3,'Derivado'),(4,'Resultado');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `estado` with 4 row(s)
--

--
-- Table structure for table `generador_pdf`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generador_pdf` (
  `id_generador_pdf` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(300) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `area` varchar(100) NOT NULL,
  PRIMARY KEY (`id_generador_pdf`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generador_pdf`
--

LOCK TABLES `generador_pdf` WRITE;
/*!40000 ALTER TABLE `generador_pdf` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `generador_pdf` VALUES (4,'1712938269_logo.jpg','Solicitud de Muestra de Anatomia Patologica	','asdsad','solicitudesapa');
/*!40000 ALTER TABLE `generador_pdf` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `generador_pdf` with 1 row(s)
--

--
-- Table structure for table `menu`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_menu` varchar(100) NOT NULL,
  `url_menu` varchar(300) NOT NULL,
  `icono_menu` varchar(100) NOT NULL,
  `submenu` varchar(100) NOT NULL,
  `orden_menu` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `menu` VALUES (5,'Perfil','/home/perfil','far fa-user','No',13),(6,'Respalda tus Datos','/home/respaldos','fas fa-database','No',9),(7,'Salir','/login/salir','fas fa-sign-out-alt','No',14),(10,'Mantenedor Menu','/home/menu','fas fa-bars','No',10),(12,'Acceso Menus','/home/acceso_menus','fas fa-outdent','No',11),(19,'Configuración','/Configuracion/index','fas fa-cogs','No',12),(20,'Panel Principal','/panel/index','fas fa-tachometer-alt','No',1),(21,'Solicitudes','#','fas fa-plus-circle','Si',2),(22,'criticos','/criticos/index','fab fa-accusoft','No',5),(23,'Mantenedores','#','fab fa-wpforms','Si',6),(24,'Generador de Módulos','/home/modulos','far fa-list-alt','No',7),(25,'Generador PDF','/Generar_pdf/index','far fa-file-pdf','No',8),(26,'Recepción','/recepcion/index','far fa-circle','No',3),(28,'Derivación','/derivacion/index','far fa-circle','No',4);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `menu` with 14 row(s)
--

--
-- Table structure for table `modulos`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulos` (
  `id_modulos` int(11) NOT NULL AUTO_INCREMENT,
  `tabla` varchar(100) NOT NULL,
  `activar_filtro_de_busqueda` varchar(100) NOT NULL,
  `botones_de_accion` varchar(100) NOT NULL,
  `activar_buscador` varchar(100) NOT NULL,
  `botones_de_exportacion` varchar(100) NOT NULL,
  `activar_eliminacion_multiple` varchar(100) NOT NULL,
  `activar_modo_popup` varchar(100) NOT NULL,
  `seleccionar_skin` varchar(100) NOT NULL,
  `seleccionar_template` varchar(100) NOT NULL,
  `nombre_funcion_antes_de_insertar` varchar(100) NOT NULL,
  `nombre_funcion_despues_de_insertar` varchar(100) NOT NULL,
  `nombre_funcion_antes_de_actualizar` varchar(100) NOT NULL,
  `nombre_funcion_despues_de_actualizar` varchar(100) NOT NULL,
  `nombre_funcion_antes_de_eliminar` varchar(100) NOT NULL,
  `nombre_funcion_despues_de_eliminar` varchar(100) NOT NULL,
  `nombre_funcion_antes_de_actualizar_gatillo` varchar(100) NOT NULL,
  `nombre_funcion_despues_de_actualizar_gatillo` varchar(100) NOT NULL,
  `script_js` varchar(100) NOT NULL,
  PRIMARY KEY (`id_modulos`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `modulos` with 0 row(s)
--

--
-- Table structure for table `muestra`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `muestra` (
  `Idmuestra` int(20) NOT NULL AUTO_INCREMENT,
  `Idsolicitud` int(20) NOT NULL,
  `cantmuestra` int(20) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`Idmuestra`),
  KEY `Idsolicitud` (`Idsolicitud`),
  CONSTRAINT `muestra_ibfk_1` FOREIGN KEY (`Idsolicitud`) REFERENCES `solicitudesapa` (`Idsolicitud`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `muestra`
--

LOCK TABLES `muestra` WRITE;
/*!40000 ALTER TABLE `muestra` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `muestra` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `muestra` with 0 row(s)
--

--
-- Table structure for table `nmedico`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nmedico` (
  `Idmedico` int(20) NOT NULL AUTO_INCREMENT,
  `rutmedico` varchar(20) NOT NULL,
  `nmedico` varchar(50) NOT NULL,
  `especialidad` varchar(20) NOT NULL,
  PRIMARY KEY (`Idmedico`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nmedico`
--

LOCK TABLES `nmedico` WRITE;
/*!40000 ALTER TABLE `nmedico` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `nmedico` VALUES (1,'1111111-1','dr chapatin','cx'),(2,'','cx',''),(3,'','loco','cx'),(4,'2132321','213123','cx');
/*!40000 ALTER TABLE `nmedico` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `nmedico` with 4 row(s)
--

--
-- Table structure for table `rol`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(100) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `rol` VALUES (1,'Médico'),(2,'Enfermera pabellón'),(3,'Enfermera calidad'),(23,'Super usuario'),(24,'Tens apa');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `rol` with 5 row(s)
--

--
-- Table structure for table `servicio`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicio` (
  `Idservicio` int(20) NOT NULL AUTO_INCREMENT,
  `servicio` varchar(100) NOT NULL,
  PRIMARY KEY (`Idservicio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `servicio` VALUES (1,'Pabellon'),(2,'Procedimientos endoscopicos'),(3,'Procedimientos urológicos'),(4,'Medicina');
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `servicio` with 4 row(s)
--

--
-- Table structure for table `solicitudesapa`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitudesapa` (
  `Idsolicitud` int(20) NOT NULL AUTO_INCREMENT,
  `identificador` varchar(20) DEFAULT NULL,
  `rut` varchar(20) DEFAULT NULL,
  `ficha` int(20) DEFAULT NULL,
  `nombres` varchar(100) NOT NULL,
  `apaterno` varchar(100) NOT NULL,
  `amaterno` varchar(100) DEFAULT NULL,
  `fechanacimiento` date NOT NULL,
  `sexo` varchar(6) NOT NULL,
  `telefono` int(20) NOT NULL,
  `tipomuestra` int(20) NOT NULL,
  `servicio` int(20) NOT NULL,
  `dgclinico` varchar(50) NOT NULL,
  `ges` varchar(2) NOT NULL,
  `fechatoma` date NOT NULL,
  `antecedentes` text NOT NULL,
  `procedimiento` varchar(50) NOT NULL,
  `organo` varchar(20) NOT NULL,
  `nenvases` int(20) NOT NULL,
  `nmuestras` int(20) NOT NULL,
  `nmedico` int(20) NOT NULL,
  `centroderivacion` int(20) DEFAULT NULL,
  `critico` varchar(2) DEFAULT NULL,
  `estado` int(20) NOT NULL DEFAULT 1,
  `fecharecepcion` datetime DEFAULT NULL,
  `fechaderivacion` date DEFAULT NULL,
  `fecharesultado` datetime DEFAULT NULL,
  `fecharegistro` date NOT NULL DEFAULT current_timestamp(),
  `resultado` varchar(100) NOT NULL,
  PRIMARY KEY (`Idsolicitud`),
  CONSTRAINT `solicitudesapa_ibfk_1` FOREIGN KEY (`nmedico`) REFERENCES `nmedico` (`Idmedico`),
  CONSTRAINT `solicitudesapa_ibfk_2` FOREIGN KEY (`centroderivacion`) REFERENCES `centroderivacion` (`Idcentroderivacion`),
  CONSTRAINT `solicitudesapa_ibfk_3` FOREIGN KEY (`tipomuestra`) REFERENCES `tipomuestra` (`Idtipomuestra`),
  CONSTRAINT `solicitudesapa_ibfk_4` FOREIGN KEY (`estado`) REFERENCES `estado` (`Idestado`),
  CONSTRAINT `solicitudesapa_ibfk_5` FOREIGN KEY (`servicio`) REFERENCES `servicio` (`Idservicio`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudesapa`
--

LOCK TABLES `solicitudesapa` WRITE;
/*!40000 ALTER TABLE `solicitudesapa` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `solicitudesapa` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `solicitudesapa` with 0 row(s)
--

--
-- Table structure for table `submenu`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `submenu` (
  `id_submenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `nombre_submenu` varchar(100) NOT NULL,
  `url_submenu` varchar(300) NOT NULL,
  `icono_submenu` varchar(100) NOT NULL,
  `orden_submenu` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_submenu`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submenu`
--

LOCK TABLES `submenu` WRITE;
/*!40000 ALTER TABLE `submenu` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `submenu` VALUES (12,21,'Todas las Solicitudes','/solicitudes/index','far fa-list-alt',2),(13,23,'Servicios','/servicios/index','fab fa-gg-circle',3),(14,23,'Médicos','/medicos/index','fab fa-gg-circle',3),(15,23,'Centro de derivación','/derivacion/centroderivacion','fab fa-gg-circle',3),(16,23,'Usuarios','/home/usuarios','fas fa-users',4);
/*!40000 ALTER TABLE `submenu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `submenu` with 5 row(s)
--

--
-- Table structure for table `tipomuestra`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipomuestra` (
  `Idtipomuestra` int(20) NOT NULL AUTO_INCREMENT,
  `tipomuestra` varchar(20) NOT NULL,
  PRIMARY KEY (`Idtipomuestra`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipomuestra`
--

LOCK TABLES `tipomuestra` WRITE;
/*!40000 ALTER TABLE `tipomuestra` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `tipomuestra` VALUES (1,'Biopsia');
/*!40000 ALTER TABLE `tipomuestra` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `tipomuestra` with 1 row(s)
--

--
-- Table structure for table `usuario`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `rut` varchar(16) NOT NULL,
  `email` varchar(200) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `token` longtext NOT NULL,
  `token_api` longtext NOT NULL,
  `expiration_token` int(11) DEFAULT NULL,
  `idrol` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `avatar` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `usuario` VALUES (1,'admin','11111111-1','admin@admin.com','admin','$2y$10$WV/igZh7IZOc4TEHS3gEBuvRh1Mn4bWy3zQtlquiMrUFuSHqm.S0S','$2y$10$SoqoncJ6IU7TX16UrG5DAOobkQ5mkcl7dfuxLoCgjjPwnwWAH0h4m','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJkYW5pZWwudGVsZW1hdGljb0BnbWFpbC5jb20iLCJ0aW1lc3RhbXAiOjE3MDc5MTcwMDl9.AQTR_e_k_0TZ0VCdjbZtBUWQsV5OgCw62_8pgv0LbDk',0,1,1,'1707312535_1707234514_1668021806_2.png'),(23,'Flavia Romero Herrera','17804560-1','demo@demo.cl','flavia','$2y$10$Cmzrq8u52SVL7.unE0Zb2u4Uy8glxVNVpU9YWnaBEgdTm6KuPNS5W','$2y$10$YQ/GPZfruUrGT4rGuUg0ZeiVWUW8UnfScvqZGv.JbLV2uST3wSR7u','',0,1,1,'1710162578_user.png');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `usuario` with 2 row(s)
--

--
-- Table structure for table `usuario_menu`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_menu` (
  `id_usuario_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `visibilidad_menu` varchar(100) NOT NULL,
  PRIMARY KEY (`id_usuario_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=1201 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_menu`
--

LOCK TABLES `usuario_menu` WRITE;
/*!40000 ALTER TABLE `usuario_menu` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `usuario_menu` VALUES (1156,1,1,'Mostrar'),(1160,1,5,'Mostrar'),(1161,1,6,'Mostrar'),(1162,1,7,'Mostrar'),(1165,1,10,'Mostrar'),(1166,20,1,'Mostrar'),(1169,20,4,'Mostrar'),(1170,20,5,'Mostrar'),(1171,20,6,'Mostrar'),(1172,20,7,'Mostrar'),(1175,20,10,'Mostrar'),(1176,1,12,'Mostrar'),(1179,1,19,'Ocultar'),(1180,1,20,'Mostrar'),(1181,1,21,'Mostrar'),(1182,1,22,'Mostrar'),(1183,1,23,'Mostrar'),(1184,1,24,'Ocultar'),(1185,1,25,'Ocultar'),(1186,1,26,'Mostrar'),(1188,1,28,'Mostrar'),(1189,23,5,'Mostrar'),(1190,23,6,'Mostrar'),(1191,23,7,'Mostrar'),(1192,23,10,'Mostrar'),(1193,23,12,'Ocultar'),(1194,23,19,'Mostrar'),(1195,23,20,'Mostrar'),(1196,23,21,'Mostrar'),(1197,23,22,'Mostrar'),(1198,23,23,'Mostrar'),(1199,23,26,'Mostrar'),(1200,23,28,'Mostrar');
/*!40000 ALTER TABLE `usuario_menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `usuario_menu` with 33 row(s)
--

--
-- Table structure for table `usuario_submenu`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_submenu` (
  `id_usuario_submenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_submenu` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `visibilidad_submenu` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario_submenu`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_submenu`
--

LOCK TABLES `usuario_submenu` WRITE;
/*!40000 ALTER TABLE `usuario_submenu` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `usuario_submenu` VALUES (10,12,21,'Mostrar',1),(11,13,23,'Mostrar',1),(12,14,23,'Mostrar',1),(13,15,23,'Mostrar',1),(14,16,23,'Mostrar',1),(15,12,21,'Mostrar',23),(16,13,23,'Mostrar',23),(17,14,23,'Mostrar',23),(18,15,23,'Mostrar',23),(19,16,23,'Mostrar',23);
/*!40000 ALTER TABLE `usuario_submenu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `usuario_submenu` with 10 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Tue, 30 Jul 2024 11:49:01 -0400
