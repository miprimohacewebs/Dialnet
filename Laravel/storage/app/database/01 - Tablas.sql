-- --------------------------------------------------------
-- Host:                         homestead.app
-- Versión del servidor:         5.7.18-0ubuntu0.16.04.1 - (Ubuntu)
-- SO del servidor:              Linux
-- HeidiSQL Versión:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para recursos_cibermov_net
CREATE DATABASE IF NOT EXISTS `recursos_cibermov_net` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `recursos_cibermov_net`;

-- Volcando estructura para tabla recursos_cibermov_net.autores
DROP TABLE IF EXISTS `autores`;
CREATE TABLE IF NOT EXISTS `autores` (
  `idAutor` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria de autores',
  `tx_autor` varchar(500) CHARACTER SET utf8 NOT NULL COMMENT 'Nombre del autor',
  `ta_x_idtipoautor` int(11) NOT NULL COMMENT 'Relación con la tabla tipo autores',
  PRIMARY KEY (`idAutor`),
  KEY `idtipoautor` (`ta_x_idtipoautor`),
  CONSTRAINT `autor_tipoautor` FOREIGN KEY (`ta_x_idtipoautor`) REFERENCES `tipoautor` (`x_idtipoautor`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla que contiene los autores, editores, etc.';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.autor_grupoautor
DROP TABLE IF EXISTS `autor_grupoautor`;
CREATE TABLE IF NOT EXISTS `autor_grupoautor` (
  `aut_x_idautor` int(11) NOT NULL COMMENT 'relación con id autor, parte de la clave primaria',
  `ga_x_idgrupoautor` int(11) NOT NULL COMMENT 'relación ficticia con grupo autor (no existe), parte de la clave primaria',
  PRIMARY KEY (`aut_x_idautor`,`ga_x_idgrupoautor`),
  KEY `idgrupoautor` (`ga_x_idgrupoautor`),
  CONSTRAINT `autorgrupoautor_autor` FOREIGN KEY (`aut_x_idautor`) REFERENCES `autores` (`idAutor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla intermedia entre autor y grupo autor';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.categorias
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `x_idcategoria` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria de la tabla',
  `tx_categoria` varchar(100) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Nombre de la categoría',
  PRIMARY KEY (`x_idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Almacena las categorías de las publicaciones';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.editor
DROP TABLE IF EXISTS `editor`;
CREATE TABLE IF NOT EXISTS `editor` (
  `x_ideditor` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria de la tabla',
  `tx_editor` varchar(500) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Nombre del editor',
  `te_x_idTipoEditor` int(11) NOT NULL COMMENT 'campo relacional con la tabla tipoEditor ',
  PRIMARY KEY (`x_ideditor`),
  KEY `idtipoeditor` (`te_x_idTipoEditor`),
  CONSTRAINT `editor_tipoEditor` FOREIGN KEY (`te_x_idTipoEditor`) REFERENCES `tipoeditor` (`x_idtipoeditor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla que contiene los editores o revistas';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.editor_grupoeditor
DROP TABLE IF EXISTS `editor_grupoeditor`;
CREATE TABLE IF NOT EXISTS `editor_grupoeditor` (
  `ge_x_idgrupoeditor` int(11) NOT NULL,
  `ed_x_ideditor` int(11) NOT NULL,
  PRIMARY KEY (`ge_x_idgrupoeditor`,`ed_x_ideditor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.perfil
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `x_idperfil` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria de la tabla',
  `tx_perfil` varchar(200) CHARACTER SET latin1 NOT NULL COMMENT 'Nombre del perfil',
  `tx_permisos` varchar(500) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Permisos del perfil',
  PRIMARY KEY (`x_idperfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Contiene los perfiles posibles de los usuarios';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.publicaciones
DROP TABLE IF EXISTS `publicaciones`;
CREATE TABLE IF NOT EXISTS `publicaciones` (
  `x_idpublicacion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Campo primario de publicaciones',
  `aga_x_idgrupoautor` int(11) DEFAULT NULL COMMENT 'Campo relacional con la intermedia entre autor y grupo autores',
  `cat_x_idcategoria` int(11) DEFAULT NULL COMMENT 'campo relacional con el id categoria',
  `ge_x_idgrupoeditor` int(11) DEFAULT NULL COMMENT 'campo relacional con autor_grupoautor para grupo de editores',
  `tx_titulo` varchar(300) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Titulo de la publicación',
  `tx_isbn` varchar(80) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'ISVN asignado a la obra',
  `nu_anno` year(4) DEFAULT NULL COMMENT 'Año de la publicación',
  `tx_paginas` varchar(16) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Páginas donde se encuentra la contribución dentro de la publicación',
  `tx_edicion` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Edición de la publicación',
  `tx_obra` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'descripción del tipo de obra',
  `tx_resumen` varchar(3000) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Sinopsis de la publicación',
  `tx_descriptores` varchar(500) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Etiquetas identificativas de la publicación',
  `tx_imagen` varchar(900) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Url a la imagen de la publicación',
  `tx_subtitulo` varchar(500) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Subtitulo de la publicación',
  `tx_genero` varchar(30) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Genero de la publicación',
  `tx_asunto` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Asunto de la publicación',
  `fh_fechapublicacion` date DEFAULT NULL COMMENT 'Fecha en la que se ha publicado la obra',
  `tx_pais` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'País de publicación',
  `tx_idioma` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'Idioma original de la publicación',
  `nu_numPaginas` int(8) DEFAULT NULL COMMENT 'Número total de páginas de la publicación',
  PRIMARY KEY (`x_idpublicacion`),
  KEY `idgrupoautor` (`aga_x_idgrupoautor`),
  KEY `idcategoria` (`cat_x_idcategoria`),
  KEY `idGrupoEditor` (`ge_x_idgrupoeditor`),
  CONSTRAINT `publicaciones_autorgrupoautor` FOREIGN KEY (`aga_x_idgrupoautor`) REFERENCES `autor_grupoautor` (`ga_x_idgrupoautor`),
  CONSTRAINT `publicaciones_categorias` FOREIGN KEY (`cat_x_idcategoria`) REFERENCES `categorias` (`x_idcategoria`),
  CONSTRAINT `publicaciones_grupoeditor` FOREIGN KEY (`ge_x_idgrupoeditor`) REFERENCES `editor_grupoeditor` (`ge_x_idgrupoeditor`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='En esta tabla se almacenan los trabajos publicados';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.tipoautor
DROP TABLE IF EXISTS `tipoautor`;
CREATE TABLE IF NOT EXISTS `tipoautor` (
  `x_idtipoautor` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria de la tabla',
  `tx_tipoautor` varchar(500) COLLATE latin1_spanish_ci NOT NULL COMMENT 'descripción corta del tipo de autor',
  PRIMARY KEY (`x_idtipoautor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Contiene los tipos de autor';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.tipoeditor
DROP TABLE IF EXISTS `tipoeditor`;
CREATE TABLE IF NOT EXISTS `tipoeditor` (
  `x_idtipoeditor` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria de la tabla',
  `tx_tipoeditor` varchar(50) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Tipo de editor',
  PRIMARY KEY (`x_idtipoeditor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Contiene los tipos de editor posibles';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla recursos_cibermov_net.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `x_idusuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria de la tabla',
  `p_x_idperfil` int(11) NOT NULL COMMENT 'Relación con la tabla perfiles',
  `tx_nombreusuario` varchar(50) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Nombre del usuario',
  `tx_password` varchar(50) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Password del usuario',
  `tx_email` varchar(200) COLLATE latin1_spanish_ci NOT NULL COMMENT 'email del usuario',
  PRIMARY KEY (`x_idusuario`),
  KEY `idperfil` (`p_x_idperfil`),
  CONSTRAINT `usuario_perfil` FOREIGN KEY (`p_x_idperfil`) REFERENCES `perfil` (`x_idperfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Contiene los usuarios que pueden acceder a la administración';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para vista recursos_cibermov_net.v_autores
DROP VIEW IF EXISTS `v_autores`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `v_autores` (
	`idGrupo` INT(11) NOT NULL COMMENT 'relación ficticia con grupo autor (no existe), parte de la clave primaria',
	`idAutor` INT(11) NULL COMMENT 'Clave primaria de autores',
	`tx_autor` VARCHAR(500) NULL COMMENT 'Nombre del autor' COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista recursos_cibermov_net.v_editores
DROP VIEW IF EXISTS `v_editores`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `v_editores` (
	`idGrupo` INT(11) NOT NULL,
	`x_ideditor` INT(11) NULL COMMENT 'Clave primaria de la tabla',
	`tx_editor` VARCHAR(500) NULL COMMENT 'Nombre del editor' COLLATE 'latin1_spanish_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista recursos_cibermov_net.v_publicaciones
DROP VIEW IF EXISTS `v_publicaciones`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `v_publicaciones` (
	`x_idpublicacion` INT(11) NOT NULL COMMENT 'Campo primario de publicaciones',
	`tx_titulo` VARCHAR(300) NULL COMMENT 'Titulo de la publicación' COLLATE 'latin1_spanish_ci',
	`tx_isbn` VARCHAR(80) NULL COMMENT 'ISVN asignado a la obra' COLLATE 'latin1_spanish_ci',
	`nu_anno` YEAR NULL COMMENT 'Año de la publicación',
	`tx_paginas` VARCHAR(16) NULL COMMENT 'Páginas donde se encuentra la contribución dentro de la publicación' COLLATE 'latin1_spanish_ci',
	`tx_edicion` VARCHAR(50) NULL COMMENT 'Edición de la publicación' COLLATE 'latin1_spanish_ci',
	`tx_obra` VARCHAR(200) NULL COMMENT 'descripción del tipo de obra' COLLATE 'latin1_spanish_ci',
	`tx_resumen` VARCHAR(3000) NULL COMMENT 'Sinopsis de la publicación' COLLATE 'latin1_spanish_ci',
	`tx_descriptores` VARCHAR(500) NULL COMMENT 'Etiquetas identificativas de la publicación' COLLATE 'latin1_spanish_ci',
	`tx_imagen` VARCHAR(900) NULL COMMENT 'Url a la imagen de la publicación' COLLATE 'latin1_spanish_ci',
	`tx_subtitulo` VARCHAR(500) NULL COMMENT 'Subtitulo de la publicación' COLLATE 'latin1_spanish_ci',
	`tx_genero` VARCHAR(30) NULL COMMENT 'Genero de la publicación' COLLATE 'latin1_spanish_ci',
	`tx_asunto` VARCHAR(200) NULL COMMENT 'Asunto de la publicación' COLLATE 'latin1_spanish_ci',
	`fh_fechapublicacion` DATE NULL COMMENT 'Fecha en la que se ha publicado la obra',
	`tx_pais` VARCHAR(50) NULL COMMENT 'País de publicación' COLLATE 'latin1_spanish_ci',
	`tx_idioma` VARCHAR(50) NULL COMMENT 'Idioma original de la publicación' COLLATE 'latin1_spanish_ci',
	`nu_numPaginas` INT(8) NULL COMMENT 'Número total de páginas de la publicación',
	`tx_categoria` VARCHAR(100) NULL COMMENT 'Nombre de la categoría' COLLATE 'latin1_spanish_ci',
	`autores` VARCHAR(341) NULL COLLATE 'utf8_general_ci',
	`editores` TEXT NULL COLLATE 'latin1_spanish_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista recursos_cibermov_net.v_autores
DROP VIEW IF EXISTS `v_autores`;
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `v_autores`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `v_autores` AS select `autor_grupoautor`.`ga_x_idgrupoautor` AS `idGrupo`,`autores`.`idAutor` AS `idAutor`,`autores`.`tx_autor` AS `tx_autor` from (`autor_grupoautor` left join `autores` on((`autor_grupoautor`.`aut_x_idautor` = `autores`.`idAutor`)));

-- Volcando estructura para vista recursos_cibermov_net.v_editores
DROP VIEW IF EXISTS `v_editores`;
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `v_editores`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `v_editores` AS select `editor_grupoeditor`.`ge_x_idgrupoeditor` AS `idGrupo`,`editor`.`x_ideditor` AS `x_ideditor`,`editor`.`tx_editor` AS `tx_editor` from (`editor_grupoeditor` left join `editor` on((`editor_grupoeditor`.`ed_x_ideditor` = `editor`.`x_ideditor`)));

-- Volcando estructura para vista recursos_cibermov_net.v_publicaciones
DROP VIEW IF EXISTS `v_publicaciones`;
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `v_publicaciones`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `v_publicaciones` AS select `publicaciones`.`x_idpublicacion` AS `x_idpublicacion`,`publicaciones`.`tx_titulo` AS `tx_titulo`,`publicaciones`.`tx_isbn` AS `tx_isbn`,`publicaciones`.`nu_anno` AS `nu_anno`,`publicaciones`.`tx_paginas` AS `tx_paginas`,`publicaciones`.`tx_edicion` AS `tx_edicion`,`publicaciones`.`tx_obra` AS `tx_obra`,`publicaciones`.`tx_resumen` AS `tx_resumen`,`publicaciones`.`tx_descriptores` AS `tx_descriptores`,`publicaciones`.`tx_imagen` AS `tx_imagen`,`publicaciones`.`tx_subtitulo` AS `tx_subtitulo`,`publicaciones`.`tx_genero` AS `tx_genero`,`publicaciones`.`tx_asunto` AS `tx_asunto`,`publicaciones`.`fh_fechapublicacion` AS `fh_fechapublicacion`,`publicaciones`.`tx_pais` AS `tx_pais`,`publicaciones`.`tx_idioma` AS `tx_idioma`,`publicaciones`.`nu_numPaginas` AS `nu_numPaginas`,`categorias`.`tx_categoria` AS `tx_categoria`,(select group_concat(`autores`.`tx_autor` separator ', ') from (`autor_grupoautor` left join `autores` on((`autores`.`idAutor` = `autor_grupoautor`.`aut_x_idautor`))) where (`publicaciones`.`aga_x_idgrupoautor` = `autor_grupoautor`.`ga_x_idgrupoautor`) group by `autor_grupoautor`.`ga_x_idgrupoautor`) AS `autores`,(select group_concat(`editor`.`tx_editor` separator ', ') from (`editor_grupoeditor` left join `editor` on((`editor_grupoeditor`.`ed_x_ideditor` = `editor`.`x_ideditor`))) where (`publicaciones`.`ge_x_idgrupoeditor` = `editor_grupoeditor`.`ge_x_idgrupoeditor`) group by `editor_grupoeditor`.`ge_x_idgrupoeditor`) AS `editores` from (`publicaciones` left join `categorias` on((`categorias`.`x_idcategoria` = `publicaciones`.`cat_x_idcategoria`)));

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
