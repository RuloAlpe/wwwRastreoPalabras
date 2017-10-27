-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.4-m14 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla template-yii2.mod_usuarios_cat_status_sesiones
CREATE TABLE IF NOT EXISTS `mod_usuarios_cat_status_sesiones` (
  `id_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `txt_nombre` varchar(50) NOT NULL COMMENT 'Estatus de la sesión',
  `txt_descripcion` varchar(500) DEFAULT NULL COMMENT 'Descripción del elemento',
  `b_habilitado` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Booleano para saber si el registro esta habilitado',
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-yii2.mod_usuarios_cat_status_sesiones: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_cat_status_sesiones` DISABLE KEYS */;
INSERT INTO `mod_usuarios_cat_status_sesiones` (`id_status`, `txt_nombre`, `txt_descripcion`, `b_habilitado`) VALUES
	(1, 'Sesión iniciada', 'Sesión se ha iniciado y se encuentra activa', 1),
	(2, 'Sesión finalizada', 'Sesión se ha finalizado correctamente', 1),
	(3, 'Sesión finalizada incorrectamente', 'Sesión se ha finalizado por tiempo de expiración u otro problema', 1);
/*!40000 ALTER TABLE `mod_usuarios_cat_status_sesiones` ENABLE KEYS */;


-- Volcando estructura para tabla template-yii2.mod_usuarios_cat_status_usuarios
CREATE TABLE IF NOT EXISTS `mod_usuarios_cat_status_usuarios` (
  `id_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `txt_nombre` varchar(50) NOT NULL COMMENT 'Estatus del usuario',
  `txt_descripcion` varchar(500) DEFAULT NULL COMMENT 'Descripción del elemento',
  `b_habilitado` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Booleano para saber si el registro esta habilitado',
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-yii2.mod_usuarios_cat_status_usuarios: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_cat_status_usuarios` DISABLE KEYS */;
INSERT INTO `mod_usuarios_cat_status_usuarios` (`id_status`, `txt_nombre`, `txt_descripcion`, `b_habilitado`) VALUES
	(1, 'Pendiente activacion', 'Usuario se ha registrado pero aún no activa su cuenta', 1),
	(2, 'Usuario activado', 'Usuario ha activado su cuenta', 1),
	(3, 'Usuario bloqueado', 'Usuario bloqueado', 1);
/*!40000 ALTER TABLE `mod_usuarios_cat_status_usuarios` ENABLE KEYS */;


-- Volcando estructura para tabla template-yii2.mod_usuarios_cat_tipos_usuarios
CREATE TABLE IF NOT EXISTS `mod_usuarios_cat_tipos_usuarios` (
  `id_tipo_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `txt_nombre` varchar(100) NOT NULL,
  `txt_descripcion` varchar(500) NOT NULL,
  `b_habiliado` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-yii2.mod_usuarios_cat_tipos_usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_cat_tipos_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_cat_tipos_usuarios` ENABLE KEYS */;


-- Volcando estructura para tabla template-yii2.mod_usuarios_ent_sesiones
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_sesiones` (
  `id_sesion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL COMMENT 'Id del usuario que inicio sesión',
  `id_status` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Status de la sesión',
  `fch_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el usuario inicio sesión',
  `fch_logout` timestamp NULL DEFAULT NULL COMMENT 'Fecha en la que el usuario finalizo la sesión',
  `num_minutos_sesion` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Minutos que duraro la sesión del usuario',
  `txt_ip` varchar(32) NOT NULL COMMENT 'Ip de donde se conecto el usuario',
  `txt_ip_logout` varchar(32) DEFAULT NULL COMMENT 'Ip de donde el usuario se desconecto',
  PRIMARY KEY (`id_sesion`),
  KEY `FK_ent_sesiones_cat_status_sesiones` (`id_status`),
  KEY `FK_ent_sesiones_ent_usuarios` (`id_usuario`),
  CONSTRAINT `FK_ent_sesiones_cat_status_sesiones` FOREIGN KEY (`id_status`) REFERENCES `mod_usuarios_cat_status_sesiones` (`id_status`),
  CONSTRAINT `FK_ent_sesiones_ent_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `mod_usuarios_ent_usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-yii2.mod_usuarios_ent_sesiones: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_sesiones` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_sesiones` ENABLE KEYS */;


-- Volcando estructura para tabla template-yii2.mod_usuarios_ent_usuarios
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_usuarios` (
  `id_usuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_usuario` int(11) unsigned NOT NULL,
  `txt_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `txt_imagen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txt_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txt_apellido_paterno` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txt_apellido_materno` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txt_auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `txt_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txt_password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txt_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fch_creacion` datetime DEFAULT NULL,
  `fch_actualizacion` datetime DEFAULT NULL,
  `id_status` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`txt_email`),
  UNIQUE KEY `txt_token` (`txt_token`),
  UNIQUE KEY `password_reset_token` (`txt_password_reset_token`),
  KEY `FK_ent_usuarios_cat_status_usuarios` (`id_status`),
  KEY `FK_mod_usuarios_ent_usuarios_mod_usuarios_cat_tipos_usuarios` (`id_tipo_usuario`),
  CONSTRAINT `FK_ent_usuarios_cat_status_usuarios` FOREIGN KEY (`id_status`) REFERENCES `mod_usuarios_cat_status_usuarios` (`id_status`) ON DELETE CASCADE,
  CONSTRAINT `FK_mod_usuarios_ent_usuarios_mod_usuarios_cat_tipos_usuarios` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `mod_usuarios_cat_tipos_usuarios` (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla template-yii2.mod_usuarios_ent_usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios` ENABLE KEYS */;


-- Volcando estructura para tabla template-yii2.mod_usuarios_ent_usuarios_activacion
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_usuarios_activacion` (
  `id_usuario_activacion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `txt_token` varchar(60) NOT NULL,
  `txt_ip_activacion` varchar(60) DEFAULT NULL,
  `fch_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fch_activacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario_activacion`),
  UNIQUE KEY `txt_token` (`txt_token`),
  KEY `FK_ent_usuarios_activacion_ent_usuarios` (`id_usuario`),
  CONSTRAINT `FK_ent_usuarios_activacion_ent_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `mod_usuarios_ent_usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-yii2.mod_usuarios_ent_usuarios_activacion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_activacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_activacion` ENABLE KEYS */;


-- Volcando estructura para tabla template-yii2.mod_usuarios_ent_usuarios_cambio_pass
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_usuarios_cambio_pass` (
  `id_usuario_cambio_pass` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `txt_token` varchar(60) NOT NULL COMMENT 'Token del registro',
  `txt_ip` varchar(20) NOT NULL COMMENT 'Ip del usuario donde pidio el cambio de pass',
  `txt_ip_cambio` varchar(20) DEFAULT NULL COMMENT 'Ip del usuario donde cambio el pass',
  `fch_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de registro',
  `fch_finalizacion` timestamp NULL DEFAULT NULL COMMENT 'Fecha de expiracion de la solicitud de cambio de pass',
  `fch_peticion_usada` timestamp NULL DEFAULT NULL COMMENT 'Fecha en la cual se utilizo la peticion',
  `b_usado` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Booleano para saber si el usuario ha usado la peticion',
  PRIMARY KEY (`id_usuario_cambio_pass`),
  KEY `FK_ent_usuarios_cambio_pass_ent_usuarios` (`id_usuario`),
  CONSTRAINT `FK_ent_usuarios_cambio_pass_ent_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `mod_usuarios_ent_usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-yii2.mod_usuarios_ent_usuarios_cambio_pass: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_cambio_pass` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_cambio_pass` ENABLE KEYS */;


-- Volcando estructura para tabla template-yii2.mod_usuarios_ent_usuarios_facebook
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_usuarios_facebook` (
  `id_usuario_facebook` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `id_facebook` bigint(20) NOT NULL,
  `txt_url_photo` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_usuario_facebook`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  UNIQUE KEY `id_facebook` (`id_facebook`),
  CONSTRAINT `FK_ent_usuarios_facebook_ent_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `mod_usuarios_ent_usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-yii2.mod_usuarios_ent_usuarios_facebook: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_facebook` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_facebook` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
