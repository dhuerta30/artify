-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2024 a las 21:57:39
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `artify`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anidada`
--

CREATE TABLE `anidada` (
  `id_tabla_anidada` int(11) NOT NULL,
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
  `buttons_actions_db` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backup`
--

CREATE TABLE `backup` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `archivo` varchar(300) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `backup`
--

INSERT INTO `backup` (`id`, `usuario`, `archivo`, `fecha`, `hora`) VALUES
(61, 'admin', 'procedimiento1709047088.sql', '2024-02-27', '12:18:08'),
(62, 'admin', 'procedimiento1709047233.sql', '2024-02-27', '12:20:33'),
(63, 'admin', 'procedimiento1709047314.sql', '2024-02-27', '12:21:54'),
(64, 'admin', 'procedimiento1729712513.sql', '2024-10-23', '16:41:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones_api`
--

CREATE TABLE `configuraciones_api` (
  `id_configuraciones_api` int(11) NOT NULL,
  `generar_jwt_token` varchar(100) NOT NULL,
  `autenticar_jwt_token` varchar(100) DEFAULT NULL,
  `tiempo_caducidad_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuraciones_api`
--

INSERT INTO `configuraciones_api` (`id_configuraciones_api`, `generar_jwt_token`, `autenticar_jwt_token`, `tiempo_caducidad_token`) VALUES
(1, 'No', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones_pdf`
--

CREATE TABLE `configuraciones_pdf` (
  `id_configuraciones_pdf` int(11) NOT NULL,
  `logo_pdf` varchar(300) DEFAULT NULL,
  `marca_agua_pdf` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creador_de_panel`
--

CREATE TABLE `creador_de_panel` (
  `id_creador_de_panel` int(11) NOT NULL,
  `cantidad_columnas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `creador_de_panel`
--

INSERT INTO `creador_de_panel` (`id_creador_de_panel`, `cantidad_columnas`) VALUES
(5, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crear_tablas`
--

CREATE TABLE `crear_tablas` (
  `id_crear_tablas` int(11) NOT NULL,
  `nombre_tabla` varchar(100) NOT NULL,
  `query_tabla` text NOT NULL,
  `modificar_tabla` text DEFAULT NULL,
  `tabla_modificada` varchar(100) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `crear_tablas`
--

INSERT INTO `crear_tablas` (`id_crear_tablas`, `nombre_tabla`, `query_tabla`, `modificar_tabla`, `tabla_modificada`) VALUES
(28, 'personas', 'id_personas INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,\r\nnombre VARCHAR(100)  NOT NULL,\r\napellido VARCHAR(100)  NOT NULL,\r\nfecha_nacimiento DATE  NOT NULL,\r\nadjunto VARCHAR(300)  NOT NULL', NULL, 'No'),
(29, 'empleados', 'id_empleados INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,\r\nid_personas INT(11)  NOT NULL,\r\nnombre_empleado VARCHAR(100)  NOT NULL,\r\napellido_empleado VARCHAR(100)  NOT NULL', NULL, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_panel`
--

CREATE TABLE `custom_panel` (
  `id_custom_panel` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `icono` varchar(100) NOT NULL,
  `url` varchar(300) NOT NULL,
  `id_creador_de_panel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleados` int(11) NOT NULL,
  `id_personas` int(11) NOT NULL,
  `nombre_empleado` varchar(100) NOT NULL,
  `apellido_empleado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estructura_tabla`
--

CREATE TABLE `estructura_tabla` (
  `id_estructura_tabla` int(11) NOT NULL,
  `id_crear_tablas` int(11) NOT NULL,
  `nombre_campo` varchar(200) NOT NULL,
  `nombre_nuevo_campo` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `caracteres` varchar(100) DEFAULT NULL,
  `autoincremental` varchar(100) NOT NULL,
  `indice` varchar(100) NOT NULL,
  `valor_nulo` varchar(100) DEFAULT NULL,
  `modificar_campo` varchar(100) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estructura_tabla`
--

INSERT INTO `estructura_tabla` (`id_estructura_tabla`, `id_crear_tablas`, `nombre_campo`, `nombre_nuevo_campo`, `tipo`, `caracteres`, `autoincremental`, `indice`, `valor_nulo`, `modificar_campo`) VALUES
(154, 28, 'id_personas', '', 'Entero', '11', 'Si', 'Primario', 'No', 'No'),
(155, 28, 'nombre', '', 'Caracteres', '100', 'No', 'Sin Indice', 'No', 'No'),
(156, 28, 'apellido', '', 'Caracteres', '100', 'No', 'Sin Indice', 'No', 'No'),
(157, 28, 'fecha_nacimiento', '', 'Fecha', '', 'No', 'Sin Indice', 'No', 'No'),
(158, 28, 'adjunto', '', 'Caracteres', '300', 'No', 'Sin Indice', 'No', 'No'),
(159, 29, 'id_empleados', '', 'Entero', '11', 'Si', 'Primario', 'No', 'No'),
(160, 29, 'id_personas', '', 'Entero', '11', 'No', 'Sin Indice', 'No', 'No'),
(161, 29, 'nombre_empleado', '', 'Caracteres', '100', 'No', 'Sin Indice', 'No', 'No'),
(162, 29, 'apellido_empleado', '', 'Caracteres', '100', 'No', 'Sin Indice', 'No', 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nombre_menu` varchar(100) NOT NULL,
  `url_menu` varchar(300) NOT NULL,
  `icono_menu` varchar(100) NOT NULL,
  `submenu` varchar(100) NOT NULL,
  `orden_menu` tinyint(4) NOT NULL,
  `area_protegida_menu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `nombre_menu`, `url_menu`, `icono_menu`, `submenu`, `orden_menu`, `area_protegida_menu`) VALUES
(4, 'usuarios', '/home/usuarios', 'fas fa-users', 'No', 3, 'Si'),
(5, 'Perfil', '/home/perfil', 'far fa-user', 'No', 4, 'Si'),
(6, 'Respalda tus Datos', '/home/respaldos', 'fas fa-database', 'No', 5, 'Si'),
(7, 'Salir', '/login/salir', 'fas fa-sign-out-alt', 'No', 9, 'Si'),
(10, 'Mantenedor Menu', '/home/menu', 'fas fa-bars', 'No', 6, 'Si'),
(12, 'Acceso Menus', '/home/acceso_menus', 'fas fa-outdent', 'No', 7, 'Si'),
(19, 'Generador de Módulos', '/home/modulos', 'fas fa-table', 'No', 1, 'Si'),
(141, 'Documentación', '/Documentacion/index', 'fas fa-book', 'No', 8, 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulos` int(11) NOT NULL,
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
  `text_no_data` varchar(100) DEFAULT NULL,
  `type_union` varchar(100) DEFAULT NULL,
  `send_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_personas` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `adjunto` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `renombrar_campos_grilla`
--

CREATE TABLE `renombrar_campos_grilla` (
  `id_renombrar_campos_grilla` int(11) NOT NULL,
  `id_modulos` int(11) NOT NULL,
  `campo` varchar(100) NOT NULL,
  `nuevo_nombre_campo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `nombre_rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submenu`
--

CREATE TABLE `submenu` (
  `id_submenu` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nombre_submenu` varchar(100) NOT NULL,
  `url_submenu` varchar(300) NOT NULL,
  `icono_submenu` varchar(100) NOT NULL,
  `orden_submenu` tinyint(4) NOT NULL,
  `area_protegida_submenu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `token` longtext NOT NULL,
  `token_api` longtext NOT NULL,
  `expiration_token` int(11) DEFAULT NULL,
  `idrol` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `avatar` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `usuario`, `password`, `token`, `token_api`, `expiration_token`, `idrol`, `estatus`, `avatar`) VALUES
(1, 'Daniel', 'daniel.telematico@gmail.com', 'admin', '$2y$10$2BrYaf/9dFNYyZ9ywg4xXeicVrZqrp5HhcpcLykept50WhY242J9m', '$2y$10$sUHfVgHv92C8XLnqJL0HEOwUBD0BGzKJJp2S9hPD6eDYbmpbuqAPm', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEiLCJlbWFpbCI6ImRhbmllbC50ZWxlbWF0aWNvQGdtYWlsLmNvbSIsInRpbWVzdGFtcCI6MTcyOTc5OTMzNiwiZXhwIjoxNzI5ODAyOTM2fQ.pcDWKLPnxNmwcncVs9XeBlTEmYfwJ6w8zNUB2_BK5Wc', 0, 1, 1, '1707312535_1707234514_1668021806_2.png'),
(20, 'juan', 'juan@demo.cl', 'juan', '$2y$10$d9A4UE4FqYMjAXWJeZS9DuJPWv9Mx3DIiecejdj0yuSO8.yidg9UO', '$2y$10$MTDoBbuAz67mR9ZfxzI4JO4vCDoYh4nAASWnlTR3heLV2Y8I3dLhq', '', 0, 1, 1, '1707246310_1704914375_avatar.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_menu`
--

CREATE TABLE `usuario_menu` (
  `id_usuario_menu` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `visibilidad_menu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_menu`
--

INSERT INTO `usuario_menu` (`id_usuario_menu`, `id_usuario`, `id_menu`, `visibilidad_menu`) VALUES
(1156, 1, 1, 'Mostrar'),
(1159, 1, 4, 'Mostrar'),
(1160, 1, 5, 'Mostrar'),
(1161, 1, 6, 'Mostrar'),
(1162, 1, 7, 'Mostrar'),
(1165, 1, 10, 'Mostrar'),
(1166, 20, 1, 'Mostrar'),
(1169, 20, 4, 'Mostrar'),
(1170, 20, 5, 'Mostrar'),
(1171, 20, 6, 'Mostrar'),
(1172, 20, 7, 'Mostrar'),
(1175, 20, 10, 'Mostrar'),
(1176, 1, 12, 'Mostrar'),
(1179, 1, 19, 'Mostrar'),
(1299, 1, 141, 'Mostrar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_submenu`
--

CREATE TABLE `usuario_submenu` (
  `id_usuario_submenu` int(11) NOT NULL,
  `id_submenu` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `visibilidad_submenu` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anidada`
--
ALTER TABLE `anidada`
  ADD PRIMARY KEY (`id_tabla_anidada`);

--
-- Indices de la tabla `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuraciones_api`
--
ALTER TABLE `configuraciones_api`
  ADD PRIMARY KEY (`id_configuraciones_api`);

--
-- Indices de la tabla `configuraciones_pdf`
--
ALTER TABLE `configuraciones_pdf`
  ADD PRIMARY KEY (`id_configuraciones_pdf`);

--
-- Indices de la tabla `creador_de_panel`
--
ALTER TABLE `creador_de_panel`
  ADD PRIMARY KEY (`id_creador_de_panel`);

--
-- Indices de la tabla `crear_tablas`
--
ALTER TABLE `crear_tablas`
  ADD PRIMARY KEY (`id_crear_tablas`);

--
-- Indices de la tabla `custom_panel`
--
ALTER TABLE `custom_panel`
  ADD PRIMARY KEY (`id_custom_panel`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleados`);

--
-- Indices de la tabla `estructura_tabla`
--
ALTER TABLE `estructura_tabla`
  ADD PRIMARY KEY (`id_estructura_tabla`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulos`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_personas`);

--
-- Indices de la tabla `renombrar_campos_grilla`
--
ALTER TABLE `renombrar_campos_grilla`
  ADD PRIMARY KEY (`id_renombrar_campos_grilla`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`id_submenu`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_menu`
--
ALTER TABLE `usuario_menu`
  ADD PRIMARY KEY (`id_usuario_menu`);

--
-- Indices de la tabla `usuario_submenu`
--
ALTER TABLE `usuario_submenu`
  ADD PRIMARY KEY (`id_usuario_submenu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anidada`
--
ALTER TABLE `anidada`
  MODIFY `id_tabla_anidada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `backup`
--
ALTER TABLE `backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `configuraciones_api`
--
ALTER TABLE `configuraciones_api`
  MODIFY `id_configuraciones_api` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `configuraciones_pdf`
--
ALTER TABLE `configuraciones_pdf`
  MODIFY `id_configuraciones_pdf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `creador_de_panel`
--
ALTER TABLE `creador_de_panel`
  MODIFY `id_creador_de_panel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `crear_tablas`
--
ALTER TABLE `crear_tablas`
  MODIFY `id_crear_tablas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `custom_panel`
--
ALTER TABLE `custom_panel`
  MODIFY `id_custom_panel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleados` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estructura_tabla`
--
ALTER TABLE `estructura_tabla`
  MODIFY `id_estructura_tabla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_personas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `renombrar_campos_grilla`
--
ALTER TABLE `renombrar_campos_grilla`
  MODIFY `id_renombrar_campos_grilla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `submenu`
--
ALTER TABLE `submenu`
  MODIFY `id_submenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuario_menu`
--
ALTER TABLE `usuario_menu`
  MODIFY `id_usuario_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1426;

--
-- AUTO_INCREMENT de la tabla `usuario_submenu`
--
ALTER TABLE `usuario_submenu`
  MODIFY `id_usuario_submenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
