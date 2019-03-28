-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2016 a las 21:32:21
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gn`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `contador` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `nombre`, `contador`) VALUES
(1, 'Dirección Contable', 0),
(2, 'Dirección Administrativa', 3),
(3, 'Contable', 1),
(4, 'Facturación', 1),
(5, 'Informática', 0),
(6, 'Mesa de Entrada', 0),
(7, 'Internación', 0),
(8, 'Farmacia', 0),
(9, 'Municipalidad de Patagones', 4),
(10, 'Secretaría de Hacienda', 2),
(11, 'Gerencia de Recursos Humanos', 1),
(12, 'Tesorería', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('administrador', '1', NULL, 'N;'),
('administrador', '2', NULL, 'N;'),
('administrador_usuarios', '16', NULL, 'N;'),
('administrador_usuarios', '9', NULL, 'N;'),
('crear_notas', '10', NULL, 'N;'),
('crear_notas', '11', NULL, 'N;'),
('crear_notas', '12', NULL, 'N;'),
('crear_notas', '13', NULL, 'N;'),
('crear_notas', '15', NULL, 'N;'),
('crear_notas', '3', NULL, 'N;'),
('crear_notas', '4', NULL, 'N;'),
('crear_notas', '5', NULL, 'N;'),
('crear_notas', '6', NULL, 'N;'),
('crear_notas', '7', NULL, 'N;'),
('crear_notas', '8', NULL, 'N;'),
('ver_areas', '3', NULL, 'N;');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('administrador', 2, 'Todos los permisos', NULL, 'N;'),
('administrador_areas', 1, 'Crea, modifica y elimina áreas', NULL, 'N;'),
('administrador_usuarios', 1, 'Crea, modifica y elimina usuarios', NULL, 'N;'),
('crear_notas', 0, 'Accede a: modificar contraseña, crear nota, seguimiento, inbox, outbox', NULL, 'N;'),
('ver_areas', 0, 'Ver lista de áreas', NULL, 'N;'),
('ver_usuarios', 0, 'Ver lista de usuarios', NULL, 'N;');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('administrador', 'administrador_areas'),
('administrador', 'administrador_usuarios'),
('administrador', 'crear_notas'),
('administrador', 'ver_areas'),
('administrador_areas', 'ver_areas'),
('administrador', 'ver_usuarios'),
('administrador_usuarios', 'ver_usuarios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacionesadjuntas`
--

CREATE TABLE IF NOT EXISTS `documentacionesadjuntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) DEFAULT NULL,
  `descripcion` varchar(450) DEFAULT NULL,
  `idnota` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_documentacionesadjuntas_notas1_idx` (`idnota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE IF NOT EXISTS `notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nronota` int(11) NOT NULL,
  `fecharealizacion` datetime NOT NULL,
  `fechaenvio` datetime DEFAULT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `descripcion` varchar(10000) NOT NULL,
  `observaciones` varchar(5000) DEFAULT NULL,
  `idusuario` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notas_usuarios1_idx` (`idusuario`),
  KEY `fk_notas_areas1_idx` (`destino`),
  KEY `fk_notas_areas2_idx` (`origen`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id`, `nronota`, `fecharealizacion`, `fechaenvio`, `origen`, `destino`, `descripcion`, `observaciones`, `idusuario`, `status`) VALUES
(1, 1, '2016-11-28 18:27:07', '2016-11-28 18:28:24', 10, 9, 'Test 01', '', 6, 1),
(2, 1, '2016-11-28 18:29:13', '2016-11-28 18:29:42', 9, 2, 'Test 02', '', 11, 1),
(3, 2, '2016-11-28 22:39:57', '2016-11-28 22:40:29', 9, 10, 'Respuesta a Test 01', '', 11, 0),
(4, 1, '2016-11-28 23:06:25', '2016-11-28 23:06:25', 2, 11, 'Reenvío Test 02', NULL, 4, 0),
(5, 1, '2016-11-29 18:56:00', '2016-11-29 18:57:15', 4, 9, 'Test 03', '', 4, 0),
(6, 1, '2016-11-29 19:00:41', '2016-12-03 00:18:00', 2, 9, 'test', '', 4, 0),
(7, 3, '2016-12-02 23:34:44', '2016-12-02 23:35:16', 9, 2, 'Pedido de rendición de viáticos de Ejemplo Nombre Apellido.', '', 11, 0),
(8, 1, '2016-12-02 23:35:31', '2016-12-02 23:36:58', 3, 7, 'Se solicita historia clínica del paciente Ejemplo Nombre Apellido, para poder evaluar el estado del trámite de prótesis Ejemplo.', '', 3, 0),
(9, 4, '2016-12-02 23:37:12', '2016-12-02 23:37:46', 9, 2, 'Pedido de rendición de viáticos totales para el mes 11/16', '', 11, 0),
(10, 2, '2016-12-02 23:38:35', '2016-12-02 23:39:30', 10, 7, 'Texto de ejemplo', '', 6, 1),
(11, 1, '2016-12-02 23:41:06', '2016-12-02 23:41:48', 11, 7, 'Respuesta a pedido de ampliación del personal del área.', '', 2, 0),
(12, 2, '2016-12-02 23:47:20', '2016-12-02 23:48:44', 2, 9, 'Detalle viáticos Nombre Apellido para mes Noviembre/16', '', 13, 0),
(13, 3, '2016-12-02 23:48:53', '2016-12-02 23:50:22', 2, 9, 'Rendición pago factura 76542 de Librería, por compra de insumos de oficina detallados en la factura.', '', 13, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_proveedores`
--

CREATE TABLE IF NOT EXISTS `notas_proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idnota` int(11) DEFAULT NULL,
  `idproveedor` int(11) DEFAULT NULL,
  `importe` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notas_proveedores_notas_idx` (`idnota`),
  KEY `fk_notas_proveedores_proveedores1_idx` (`idproveedor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `notas_proveedores`
--

INSERT INTO `notas_proveedores` (`id`, `idnota`, `idproveedor`, `importe`) VALUES
(1, 12, 46, 5000),
(2, 13, 50, 562.8),
(3, 10, 9, 520.5),
(4, 2, 23, 7000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `direccion`, `telefono`, `email`) VALUES
(1, 'Empresas  y Proveedores de Ejemplo', NULL, NULL, NULL),
(2, 'Green Pure', NULL, NULL, NULL),
(3, 'HCS', NULL, NULL, NULL),
(4, 'Instalaciones ABC', NULL, NULL, NULL),
(5, 'Alfonso Richard', NULL, NULL, NULL),
(6, 'Arcos Rosa', NULL, NULL, NULL),
(7, 'Archivo Municipal', NULL, NULL, NULL),
(8, 'Abduscan S&M', NULL, NULL, NULL),
(9, 'ARM', NULL, NULL, NULL),
(10, 'Aberica Jorge M.', NULL, NULL, NULL),
(11, 'Asertiva', NULL, NULL, NULL),
(12, 'Asociación Anestesiología', NULL, NULL, NULL),
(13, 'R Metalúrgica', NULL, NULL, NULL),
(14, 'Pedido Presupuesto', NULL, NULL, NULL),
(15, 'Intendente', NULL, NULL, NULL),
(16, 'Electromedicina', NULL, NULL, NULL),
(17, 'Correo Argentino', NULL, NULL, NULL),
(18, 'Tapicería', NULL, NULL, NULL),
(19, 'Tesorería', NULL, NULL, NULL),
(20, 'Proveedor Comida', NULL, NULL, NULL),
(21, 'Martínez Jubón Susana', NULL, NULL, NULL),
(22, 'Hospital Garrahan', NULL, NULL, NULL),
(23, 'Hospital Penna', NULL, NULL, NULL),
(24, 'Instalaciones Termomecánicas', NULL, NULL, NULL),
(25, 'NDF', NULL, NULL, NULL),
(26, 'Carrocería N', NULL, NULL, NULL),
(27, 'RRHH', NULL, NULL, NULL),
(28, 'Servicio Automotor', NULL, NULL, NULL),
(29, 'AADEE', NULL, NULL, NULL),
(30, 'Empresa Transporte', NULL, NULL, NULL),
(31, 'Centro Renal', NULL, NULL, NULL),
(32, 'Comisaría', NULL, NULL, NULL),
(33, 'Empresa Bahía SA', NULL, NULL, NULL),
(34, 'Clínica', NULL, NULL, NULL),
(35, 'Consultoría en radiaciones', NULL, NULL, NULL),
(36, 'Consultorio Audiológico', NULL, NULL, NULL),
(37, 'Contaduría', NULL, NULL, NULL),
(38, 'Cooperadora Hospital P', NULL, NULL, NULL),
(39, 'Dispromed', NULL, NULL, NULL),
(40, 'Distribuidora B', NULL, NULL, NULL),
(41, 'Reemplazo', NULL, NULL, NULL),
(42, 'Reintegro', NULL, NULL, NULL),
(43, 'Rendición de Viáticos', NULL, NULL, NULL),
(44, 'Sala San Blas', NULL, NULL, NULL),
(45, 'Sala Pradere', NULL, NULL, NULL),
(46, 'Sala Villalonga', NULL, NULL, NULL),
(47, 'Sala Stroeder', NULL, NULL, NULL),
(48, 'Secretaría de Salud', NULL, NULL, NULL),
(49, 'Rectificadora JKL', NULL, NULL, NULL),
(50, 'Artículos Hogar', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos`
--

CREATE TABLE IF NOT EXISTS `seguimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idnota` int(11) NOT NULL,
  `asunto` varchar(10000) NOT NULL,
  `idnota_referencia` int(11) NOT NULL,
  `adestino` int(11) NOT NULL,
  `aorigen` int(11) NOT NULL,
  `frealizacion` datetime NOT NULL,
  `fenvio` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nota_idx` (`idnota`),
  KEY `fk_areao1_idx` (`aorigen`),
  KEY `fk_aread1_idx` (`adestino`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `seguimientos`
--

INSERT INTO `seguimientos` (`id`, `idnota`, `asunto`, `idnota_referencia`, `adestino`, `aorigen`, `frealizacion`, `fenvio`) VALUES
(1, 1, 'Test 01', 1, 9, 10, '2016-11-28 18:27:07', '2016-11-28 18:28:24'),
(2, 2, 'Test 02', 2, 2, 9, '2016-11-28 18:29:13', '2016-11-28 18:29:42'),
(3, 3, 'Respuesta a Test 01', 1, 10, 9, '2016-11-28 22:39:57', '2016-11-28 22:40:29'),
(4, 4, 'Reenvío Test 02', 2, 11, 2, '2016-11-28 23:06:25', '2016-11-28 23:06:25'),
(5, 5, 'Test 03', 5, 9, 4, '2016-11-29 18:56:00', '2016-11-29 18:57:15'),
(6, 6, 'test', 6, 9, 2, '2016-11-29 19:00:41', '2016-12-03 00:18:00'),
(7, 7, 'Pedido de rendición de viáticos de Ejemplo Nombre Apellido.', 7, 2, 9, '2016-12-02 23:34:44', '2016-12-02 23:35:16'),
(8, 8, 'Se solicita historia clínica del paciente Ejemplo Nombre Apellido, para poder evaluar el estado del trámite de prótesis Ejemplo.', 8, 7, 3, '2016-12-02 23:35:31', '2016-12-02 23:36:58'),
(9, 9, 'Pedido de rendición de viáticos totales para el mes 11/16', 9, 2, 9, '2016-12-02 23:37:12', '2016-12-02 23:37:46'),
(10, 10, 'Texto de ejemplo', 10, 7, 10, '2016-12-02 23:38:35', '2016-12-02 23:39:30'),
(11, 11, 'Respuesta a pedido de ampliación del personal del área.', 11, 7, 11, '2016-12-02 23:41:06', '2016-12-02 23:41:48'),
(12, 12, 'Detalle viáticos Micieli Emilia para mes Noviembre/16', 12, 9, 2, '2016-12-02 23:47:20', '2016-12-02 23:48:44'),
(13, 13, 'Rendición pago factura F N1234 de ROT, por arreglo y mantenimiento de ambulancias.', 13, 9, 2, '2016-12-02 23:48:53', '2016-12-02 23:50:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `contrasenia` varchar(128) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasenia`, `nombre`, `apellido`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'Ejemplo'),
(2, 'administrador', '9dbf7c1488382487931d10235fc84a74bff5d2f4', 'Administrador', 'Administrador Apellido'),
(3, 'arcrosa', '6ddd493008769a27987ba374053b2f17d22b5718', 'Rosa', 'Arcos'),
(4, 'ghernandez', '71e003ad1ae25e5a5db27ffedd06abd65ced6bd7', 'Gabriela', 'Hernández'),
(5, 'asteimberg', '3cfe46128f1b02f0d60337f83ac14e619455acca', 'Alicia', 'Steimberg'),
(6, 'astorni', 'cd4f7532c4ed57d4d5aa0cb242f3196a360ba07a', 'Alfonsina', 'Storni'),
(7, 'jcortazar', '44c4b1a8b2b04b65b68995e5563d63a8b0026833', 'Jorge', 'Cortázar'),
(8, 'ablue', '0b37440b95d8e4996d97d21a16f11017466179f3', 'Automatic', 'Blue'),
(10, 'otrotest', '9eaa83304ad7709a5b0e5562205f18481019a3dc', 'Otro', 'Test'),
(11, 'muni', 'ae857c657de0f692f668138b3ef093f0ae9423f8', 'Municipalidad', 'Municipalidad'),
(13, 'user', '12dea96fec20593566ab75692c9949596833adc9', 'Usuario de', 'prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_areas`
--

CREATE TABLE IF NOT EXISTS `usuarios_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `idarea` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuarios_areas_usuarios1_idx` (`idusuario`),
  KEY `fk_usuarios_areas_areas1_idx` (`idarea`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `usuarios_areas`
--

INSERT INTO `usuarios_areas` (`id`, `idusuario`, `idarea`) VALUES
(1, 1, 5),
(2, 2, 5),
(3, 3, 3),
(4, 4, 2),
(5, 5, 1),
(7, 7, 2),
(10, 11, 9),
(13, 4, 3),
(14, 4, 4),
(18, 8, 9),
(20, 2, 11),
(23, 13, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `authassignment`
--
ALTER TABLE `authassignment`
  ADD CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `authitemchild`
--
ALTER TABLE `authitemchild`
  ADD CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentacionesadjuntas`
--
ALTER TABLE `documentacionesadjuntas`
  ADD CONSTRAINT `fk_documentacionesadjuntas_notas1` FOREIGN KEY (`idnota`) REFERENCES `notas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `fk_notas_areas1` FOREIGN KEY (`destino`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notas_areas2` FOREIGN KEY (`origen`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notas_usuarios1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notas_proveedores`
--
ALTER TABLE `notas_proveedores`
  ADD CONSTRAINT `fk_notas_proveedores_notas` FOREIGN KEY (`idnota`) REFERENCES `notas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notas_proveedores_proveedores1` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `fk_a_destino` FOREIGN KEY (`adestino`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_a_origen` FOREIGN KEY (`aorigen`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota` FOREIGN KEY (`idnota`) REFERENCES `notas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios_areas`
--
ALTER TABLE `usuarios_areas`
  ADD CONSTRAINT `fk_usuarios_areas_areas1` FOREIGN KEY (`idarea`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_areas_usuarios1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
