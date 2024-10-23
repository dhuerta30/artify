-- Simple Backup SQL Dump
-- Version 1.0.3
-- https://www.github.com/coderatio/simple-backup/
--
-- Host: localhost:3306
-- Generation Time: Oct 23, 2024 at 04:53 PM
-- MYSQL Server Version: 5.5.5-10.4.24-MariaDB
-- PHP Version: 7.4.29
-- Developer: Josiah O. Yahaya
-- Copyright: Coderatio

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00"

--
-- Database: `artify`
-- Total Tables: 18
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
-- Table structure for table `anidada`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anidada` (
  `id_tabla_anidada` int(11) NOT NULL AUTO_INCREMENT,
  `id_modulos` int(11) DEFAULT NULL,
  `nivel_db` varchar(100) DEFAULT NULL,
  `tabla_db` varchar(100) DEFAULT NULL,
  `consulta_crear_tabla` text DEFAULT NULL,
  `template_fields_db` varchar(100) NOT NULL,
  `active_filter_db` varchar(100) NOT NULL,
  `clone_row_db` varchar(100) NOT NULL,
  `active_popup_db` varchar(100) NOT NULL,
  `active_search_db` varchar(100) NOT NULL,
  `activate_deleteMultipleBtn_db` varchar(100) NOT NULL,
  `button_add_db` varchar(100) NOT NULL,
  `actions_buttons_grid_db` varchar(100) NOT NULL,
  `activate_nested_table_db` varchar(100) NOT NULL,
  `buttons_actions_db` varchar(100) NOT NULL,
  PRIMARY KEY (`id_tabla_anidada`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anidada`
--

LOCK TABLES `anidada` WRITE;
/*!40000 ALTER TABLE `anidada` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `anidada` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `anidada` with 0 row(s)
--

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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `backup` VALUES (61,'admin','procedimiento1709047088.sql','2024-02-27','12:18:08'),(62,'admin','procedimiento1709047233.sql','2024-02-27','12:20:33'),(63,'admin','procedimiento1709047314.sql','2024-02-27','12:21:54');
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `backup` with 3 row(s)
--

--
-- Table structure for table `configuraciones_api`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuraciones_api` (
  `id_configuraciones_api` int(11) NOT NULL AUTO_INCREMENT,
  `generar_jwt_token` varchar(100) NOT NULL,
  `autenticar_jwt_token` varchar(100) DEFAULT NULL,
  `tiempo_caducidad_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_configuraciones_api`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones_api`
--

LOCK TABLES `configuraciones_api` WRITE;
/*!40000 ALTER TABLE `configuraciones_api` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `configuraciones_api` VALUES (1,'No',NULL,NULL);
/*!40000 ALTER TABLE `configuraciones_api` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `configuraciones_api` with 1 row(s)
--

--
-- Table structure for table `configuraciones_pdf`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuraciones_pdf` (
  `id_configuraciones_pdf` int(11) NOT NULL AUTO_INCREMENT,
  `logo_pdf` varchar(300) DEFAULT NULL,
  `marca_agua_pdf` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_configuraciones_pdf`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones_pdf`
--

LOCK TABLES `configuraciones_pdf` WRITE;
/*!40000 ALTER TABLE `configuraciones_pdf` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `configuraciones_pdf` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `configuraciones_pdf` with 0 row(s)
--

--
-- Table structure for table `creador_de_panel`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `creador_de_panel` (
  `id_creador_de_panel` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_columnas` int(11) NOT NULL,
  PRIMARY KEY (`id_creador_de_panel`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creador_de_panel`
--

LOCK TABLES `creador_de_panel` WRITE;
/*!40000 ALTER TABLE `creador_de_panel` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `creador_de_panel` VALUES (5,9);
/*!40000 ALTER TABLE `creador_de_panel` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `creador_de_panel` with 1 row(s)
--

--
-- Table structure for table `crear_tablas`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crear_tablas` (
  `id_crear_tablas` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tabla` varchar(100) NOT NULL,
  `query_tabla` text NOT NULL,
  `modificar_tabla` text DEFAULT NULL,
  `tabla_modificada` varchar(100) NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id_crear_tablas`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crear_tablas`
--

LOCK TABLES `crear_tablas` WRITE;
/*!40000 ALTER TABLE `crear_tablas` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `crear_tablas` VALUES (21,'personas','id_personas INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,\r\nnombre VARCHAR(200)  NOT NULL,\r\napellido VARCHAR(200)  NOT NULL,\r\nfecha_nacimiento DATE  NOT NULL,\r\ndescripcion TEXT  NOT NULL','CHANGE name nombre VARCHAR(200) NOT NULL','Si'),(26,'empleados','id_empleados INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,\r\nid_personas INT(11)  NOT NULL,\r\nnombres VARCHAR(100)  NOT NULL,\r\napellidos VARCHAR(100)  NOT NULL',NULL,'No');
/*!40000 ALTER TABLE `crear_tablas` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `crear_tablas` with 2 row(s)
--

--
-- Table structure for table `custom_panel`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_panel` (
  `id_custom_panel` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `icono` varchar(100) NOT NULL,
  `url` varchar(300) NOT NULL,
  `id_creador_de_panel` int(11) NOT NULL,
  PRIMARY KEY (`id_custom_panel`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_panel`
--

LOCK TABLES `custom_panel` WRITE;
/*!40000 ALTER TABLE `custom_panel` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `custom_panel` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `custom_panel` with 0 row(s)
--

--
-- Table structure for table `empleados`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empleados` (
  `id_empleados` int(11) NOT NULL AUTO_INCREMENT,
  `id_personas` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  PRIMARY KEY (`id_empleados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `empleados` with 0 row(s)
--

--
-- Table structure for table `estructura_tabla`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estructura_tabla` (
  `id_estructura_tabla` int(11) NOT NULL AUTO_INCREMENT,
  `id_crear_tablas` int(11) NOT NULL,
  `nombre_campo` varchar(200) NOT NULL,
  `campo_anterior` varchar(100) DEFAULT NULL,
  `nombre_nuevo_campo` varchar(200) DEFAULT NULL,
  `tipo` varchar(100) NOT NULL,
  `caracteres` varchar(100) DEFAULT NULL,
  `autoincremental` varchar(100) NOT NULL,
  `indice` varchar(100) NOT NULL,
  `valor_nulo` varchar(100) DEFAULT NULL,
  `modificar_campo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_estructura_tabla`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estructura_tabla`
--

LOCK TABLES `estructura_tabla` WRITE;
/*!40000 ALTER TABLE `estructura_tabla` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `estructura_tabla` VALUES (134,21,'','id_personas','','Entero','11','Si','Primario','No',''),(135,21,'','name','','Caracteres','200','No','Sin Indice','No',''),(136,21,'','apellido','','Caracteres','200','No','Sin Indice','No',''),(137,21,'','fecha_nacimiento','','Fecha','','No','Sin Indice','No',''),(138,21,'','descripcion','','Texto','','No','Sin Indice','No',''),(150,26,'id_empleados',NULL,NULL,'Entero','11','Si','Primario','No',NULL),(151,26,'id_personas',NULL,NULL,'Entero','11','No','Sin Indice','No',NULL),(152,26,'nombres',NULL,NULL,'Caracteres','100','No','Sin Indice','No',NULL),(153,26,'apellidos',NULL,NULL,'Caracteres','100','No','Sin Indice','No',NULL);
/*!40000 ALTER TABLE `estructura_tabla` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `estructura_tabla` with 9 row(s)
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
  `area_protegida_menu` varchar(100) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `menu` VALUES (4,'usuarios','/home/usuarios','fas fa-users','No',3,'Si'),(5,'Perfil','/home/perfil','far fa-user','No',4,'Si'),(6,'Respalda tus Datos','/home/respaldos','fas fa-database','No',5,'Si'),(7,'Salir','/login/salir','fas fa-sign-out-alt','No',9,'Si'),(10,'Mantenedor Menu','/home/menu','fas fa-bars','No',6,'Si'),(12,'Acceso Menus','/home/acceso_menus','fas fa-outdent','No',7,'Si'),(19,'Generador de Módulos','/home/modulos','fas fa-table','No',1,'Si'),(141,'Documentación','/Documentacion/index','fas fa-book','No',8,'Si');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `menu` with 8 row(s)
--

--
-- Table structure for table `modulos`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulos` (
  `id_modulos` int(11) NOT NULL AUTO_INCREMENT,
  `tabla` varchar(100) NOT NULL,
  `id_tabla` varchar(100) DEFAULT NULL,
  `crud_type` varchar(100) NOT NULL,
  `query` text DEFAULT NULL,
  `controller_name` varchar(100) NOT NULL,
  `columns_table` text DEFAULT NULL,
  `name_view` varchar(100) NOT NULL,
  `add_menu` varchar(100) NOT NULL,
  `template_fields` varchar(100) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `active_filter` varchar(100) NOT NULL,
  `clone_row` varchar(100) NOT NULL,
  `active_popup` varchar(100) NOT NULL,
  `active_search` varchar(100) NOT NULL,
  `activate_deleteMultipleBtn` varchar(100) NOT NULL,
  `button_add` varchar(100) NOT NULL,
  `actions_buttons_grid` varchar(100) DEFAULT NULL,
  `modify_query` text DEFAULT NULL,
  `activate_nested_table` varchar(100) NOT NULL,
  `buttons_actions` varchar(100) DEFAULT NULL,
  `logo_pdf` varchar(300) DEFAULT NULL,
  `marca_de_agua_pdf` varchar(300) DEFAULT NULL,
  `activate_pdf` varchar(100) NOT NULL,
  `refrescar_grilla` varchar(100) NOT NULL,
  `consulta_pdf` text DEFAULT NULL,
  `id_campos_insertar` varchar(100) DEFAULT NULL,
  `encryption` varchar(100) DEFAULT NULL,
  `mostrar_campos_busqueda` varchar(300) NOT NULL,
  `mostrar_columnas_grilla` varchar(300) DEFAULT NULL,
  `mostrar_campos_formulario` varchar(300) DEFAULT NULL,
  `activar_recaptcha` varchar(100) NOT NULL,
  `sitekey_recaptcha` varchar(500) DEFAULT NULL,
  `sitesecret_repatcha` varchar(500) DEFAULT NULL,
  `mostrar_campos_filtro` varchar(300) DEFAULT NULL,
  `tipo_de_filtro` text DEFAULT NULL,
  `function_filter_and_search` varchar(100) DEFAULT NULL,
  `activar_union_interna` varchar(100) NOT NULL,
  `mostrar_campos_formulario_editar` varchar(300) DEFAULT NULL,
  `posicion_botones_accion_grilla` varchar(100) NOT NULL,
  `campos_requeridos` varchar(100) NOT NULL,
  `mostrar_columna_acciones_grilla` varchar(100) NOT NULL,
  `mostrar_paginacion` varchar(100) NOT NULL,
  `activar_numeracion_columnas` varchar(100) NOT NULL,
  `activar_registros_por_pagina` varchar(100) NOT NULL,
  `cantidad_de_registros_por_pagina` varchar(100) NOT NULL,
  `activar_edicion_en_linea` varchar(100) NOT NULL,
  `nombre_modulo` varchar(100) DEFAULT NULL,
  `ordenar_grilla_por` varchar(500) DEFAULT NULL,
  `tipo_orden` varchar(100) DEFAULT NULL,
  `posicionarse_en_la_pagina` varchar(100) DEFAULT NULL,
  `nombre_columnas` text DEFAULT NULL,
  `nuevo_nombre_columnas` text DEFAULT NULL,
  `ocultar_id_tabla` varchar(100) NOT NULL,
  `nombre_campos` text DEFAULT NULL,
  `nuevo_nombre_campos` text DEFAULT NULL,
  `totalRecordsInfo` varchar(100) NOT NULL,
  `area_protegida_por_login` varchar(100) NOT NULL,
  `tabla_principal_union` varchar(500) DEFAULT NULL,
  `tabla_secundaria_union` varchar(500) DEFAULT NULL,
  `campos_relacion_union_tabla_principal` text DEFAULT NULL,
  `campos_relacion_union_tabla_secundaria` text DEFAULT NULL,
  `posicion_filtro` varchar(100) DEFAULT NULL,
  `file_callback` varchar(100) DEFAULT NULL,
  `type_callback` text DEFAULT NULL,
  `type_fields` text NOT NULL,
  PRIMARY KEY (`id_modulos`)
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=utf8;
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
-- Table structure for table `personas`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personas` (
  `id_personas` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id_personas`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personas`
--

LOCK TABLES `personas` WRITE;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `personas` VALUES (1,'pedro','rojas','2024-10-09','asdsadsadas'),(2,'juan','olmedo','2024-10-04','sasadadad');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `personas` with 2 row(s)
--

--
-- Table structure for table `renombrar_campos_grilla`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `renombrar_campos_grilla` (
  `id_renombrar_campos_grilla` int(11) NOT NULL AUTO_INCREMENT,
  `id_modulos` int(11) NOT NULL,
  `campo` varchar(100) NOT NULL,
  `nuevo_nombre_campo` varchar(100) NOT NULL,
  PRIMARY KEY (`id_renombrar_campos_grilla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `renombrar_campos_grilla`
--

LOCK TABLES `renombrar_campos_grilla` WRITE;
/*!40000 ALTER TABLE `renombrar_campos_grilla` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `renombrar_campos_grilla` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `renombrar_campos_grilla` with 0 row(s)
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `rol` VALUES (1,'Administrador'),(2,'Supervisor');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `rol` with 2 row(s)
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
  `area_protegida_submenu` varchar(100) NOT NULL,
  PRIMARY KEY (`id_submenu`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submenu`
--

LOCK TABLES `submenu` WRITE;
/*!40000 ALTER TABLE `submenu` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `submenu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `submenu` with 0 row(s)
--

--
-- Table structure for table `usuario`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
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
INSERT INTO `usuario` VALUES (1,'Daniel','daniel.telematico@gmail.com','admin','$2y$10$2BrYaf/9dFNYyZ9ywg4xXeicVrZqrp5HhcpcLykept50WhY242J9m','$2y$10$sUHfVgHv92C8XLnqJL0HEOwUBD0BGzKJJp2S9hPD6eDYbmpbuqAPm','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEiLCJlbWFpbCI6ImRhbmllbC50ZWxlbWF0aWNvQGdtYWlsLmNvbSIsInRpbWVzdGFtcCI6MTcyOTcxMTY2OCwiZXhwIjoxNzI5NzE1MjY4fQ.1K31_e2FQH5aSpaJrviCT1Ob8kwgwCUANn3680xYQVc',0,1,1,'1707312535_1707234514_1668021806_2.png'),(20,'juan','juan@demo.cl','juan','$2y$10$d9A4UE4FqYMjAXWJeZS9DuJPWv9Mx3DIiecejdj0yuSO8.yidg9UO','$2y$10$MTDoBbuAz67mR9ZfxzI4JO4vCDoYh4nAASWnlTR3heLV2Y8I3dLhq','',0,1,1,'1707246310_1704914375_avatar.jpg');
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
) ENGINE=InnoDB AUTO_INCREMENT=1413 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_menu`
--

LOCK TABLES `usuario_menu` WRITE;
/*!40000 ALTER TABLE `usuario_menu` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `usuario_menu` VALUES (1156,1,1,'Mostrar'),(1159,1,4,'Mostrar'),(1160,1,5,'Mostrar'),(1161,1,6,'Mostrar'),(1162,1,7,'Mostrar'),(1165,1,10,'Mostrar'),(1166,20,1,'Mostrar'),(1169,20,4,'Mostrar'),(1170,20,5,'Mostrar'),(1171,20,6,'Mostrar'),(1172,20,7,'Mostrar'),(1175,20,10,'Mostrar'),(1176,1,12,'Mostrar'),(1179,1,19,'Mostrar'),(1299,1,141,'Mostrar');
/*!40000 ALTER TABLE `usuario_menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `usuario_menu` with 15 row(s)
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_submenu`
--

LOCK TABLES `usuario_submenu` WRITE;
/*!40000 ALTER TABLE `usuario_submenu` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `usuario_submenu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `usuario_submenu` with 0 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Wed, 23 Oct 2024 16:41:53 -0300
