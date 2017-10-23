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

-- Volcando datos para la tabla recursos_cibermov_net.autores: ~30 rows (aproximadamente)
DELETE FROM `autores`;
/*!40000 ALTER TABLE `autores` DISABLE KEYS */;
INSERT INTO `autores` (`idAutor`, `tx_autor`, `ta_x_idtipoautor`) VALUES
	(11, 'Felix Stalder', 1),
	(12, 'Carmen Beatriz Fernández', 1),
	(13, 'Varios', 1),
	(14, 'Sonia Núñez Puente', 1),
	(15, 'Diana Fernández Romero', 1),
	(16, 'Palma Peña Jiménez', 1),
	(17, 'Saleta de Salvador Agra', 1),
	(18, 'Jaume Vallverdú Vallverdú', 1),
	(19, 'Marta González San Ruperto', 1),
	(20, 'Alba Sánchez Serradilla', 1),
	(21, 'Helena Martínez Martínez', 1),
	(22, 'Inmaculada Aguilar Nacher', 1),
	(23, 'Valeria Betancourt', 1),
	(24, 'Juan Sebastián Fernández Prados', 1),
	(25, 'María Guadalupe González', 1),
	(26, 'María Teresa Becerra Traver', 1),
	(27, 'Mireya Berenice Yanez Díaz', 1),
	(28, 'Beatriz Cruz Márquez', 1),
	(29, 'Marta Pérez Escolar', 1),
	(30, 'Carmen Costa-Sánchez', 1),
	(31, 'Teresa Piñeiro-Otero', 1),
	(32, 'María del Mar Soria Ibáñez', 1),
	(33, 'Naief Yehya', 1),
	(34, 'Antonio Castillo Esparcia', 1),
	(35, 'Gemma Luengo Chávez', 1),
	(36, 'Omar Rincón', 1),
	(37, 'Marián Alonso González', 1),
	(38, 'Hernán P. Nadal', 1),
	(39, 'Daniel Rodrigo Cano', 1),
	(40, 'Marcela Iglesias Onofrio', 1);
/*!40000 ALTER TABLE `autores` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.autor_grupoautor: ~50 rows (aproximadamente)
DELETE FROM `autor_grupoautor`;
/*!40000 ALTER TABLE `autor_grupoautor` DISABLE KEYS */;
INSERT INTO `autor_grupoautor` (`aut_x_idautor`, `ga_x_idgrupoautor`) VALUES
	(14, 1),
	(15, 1),
	(16, 1),
	(25, 2),
	(26, 2),
	(27, 2),
	(30, 3),
	(31, 3),
	(39, 4),
	(40, 4),
	(11, 5),
	(12, 6),
	(13, 7),
	(17, 8),
	(18, 9),
	(19, 10),
	(20, 11),
	(21, 12),
	(22, 13),
	(23, 14),
	(24, 15),
	(28, 16),
	(29, 17),
	(32, 18),
	(33, 19),
	(34, 20),
	(35, 21),
	(36, 22),
	(37, 23),
	(38, 24);
/*!40000 ALTER TABLE `autor_grupoautor` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.categorias: ~4 rows (aproximadamente)
DELETE FROM `categorias`;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`x_idcategoria`, `tx_categoria`) VALUES
	(1, 'Artículo'),
	(2, 'Capítulo'),
	(3, 'Comunicación'),
	(4, 'Libro');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.editor: ~1 rows (aproximadamente)
DELETE FROM `editor`;
/*!40000 ALTER TABLE `editor` DISABLE KEYS */;
INSERT INTO `editor` (`x_ideditor`, `tx_editor`, `te_x_idTipoEditor`) VALUES
	(5, 'Virus', 1);
/*!40000 ALTER TABLE `editor` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.editor_grupoeditor: ~7 rows (aproximadamente)
DELETE FROM `editor_grupoeditor`;
/*!40000 ALTER TABLE `editor_grupoeditor` DISABLE KEYS */;
INSERT INTO `editor_grupoeditor` (`ge_x_idgrupoeditor`, `ed_x_ideditor`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1);
/*!40000 ALTER TABLE `editor_grupoeditor` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.migrations: ~2 rows (aproximadamente)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('2014_10_12_000000_create_users_table', 1),
	('2014_10_12_100000_create_password_resets_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.password_resets: ~0 rows (aproximadamente)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.perfil: ~0 rows (aproximadamente)
DELETE FROM `perfil`;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.publicaciones: ~38 rows (aproximadamente)
DELETE FROM `publicaciones`;
/*!40000 ALTER TABLE `publicaciones` DISABLE KEYS */;
INSERT INTO `publicaciones` (`x_idpublicacion`, `aga_x_idgrupoautor`, `cat_x_idcategoria`, `ge_x_idgrupoeditor`, `tx_titulo`, `tx_isbn`, `nu_anno`, `tx_paginas`, `tx_edicion`, `tx_obra`, `tx_resumen`, `tx_descriptores`, `tx_imagen`, `tx_subtitulo`, `tx_genero`, `tx_asunto`, `fh_fechapublicacion`, `tx_pais`, `tx_idioma`, `nu_numPaginas`) VALUES
	(4, 5, 1, 1, 'Anonymous, del humor colegial a la acción política: ciberactivismo, una nueva cuerda del arco contestatario', 'ISSN 1888-6434', '2012', '22-23', 'Nº. 197', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 6, 2, 1, 'Ciberactivismo', 'ISBN 978-84-9035-141-3', '2014', '77-106', NULL, 'Comunicación en campaña: dirección de campañas electorales y marketing político', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 7, 4, 1, 'Ciberactivismo : sobre usos políticos y sociales de la red', 'ISBN 84-96044-72-6', '2006', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(7, 1, 1, 1, 'Ciberactivismo contra la violencia de género: fetichismo tecnológico e interactividad', 'ISSN 1696-8166', '2016', '177-195', 'Nº. 27', 'Comunicación y relaciones de género: prácticas, estructuras, discursos y consumo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(8, 8, 1, 1, 'Ciberactivismo ecofeminista', 'ISSN 2171-6080', '2010', '27-41', 'Nº. 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(9, 9, 1, 1, 'Ciberactivismo político transnacional: el caso del MST de Brasil', 'ISSN 1138-347X', '2011', '159-174', 'Nº 15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(10, 10, 2, 1, 'Ciberactivismo social de las ONG: los casos de Amnistía Internacional, Intermón Oxfam y Greenpeace.', 'ISBN 978-84-88365-21-7', '2007', '128-134', 'CD-ROM Vol. 2', 'Comunicación alternativa, ciudadanía y cultura', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(11, 11, 1, 1, 'Ciberactivismo y ciberactividad en los medios de comunicación comunitarios', 'ISSN-e 2255-3401', '2016', '38-64', 'Vol. 5, Nº. 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(12, 12, 3, 1, 'Ciberactivismo y movimientos sociales urbanos contemporáneos: Revisión sobre el', 'ISBN 978-84-616-4124-6', '2013', '447-458', 'Vol. 2 (COMUNICACIONES 2)', 'Investigar la Comunicación hoy. Revisión de políticas científicas y aportaciones metodológicas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(13, 13, 2, 1, 'Ciberactivismo y parlamento: movimientos sociales e iniciativas ciudadanas por la transparencia y la participación', 'ISBN 978-84-7943-470-0', '2014', '323-362', NULL, 'Parlamentos abiertos: tecnología y redes para la democracia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(14, 14, 1, 1, 'Ciberactivismo: ¿Utopía o posibilidad de resistencia y transformación en la era de la sociedad desinformada de la información?', 'ISSN 1390-1079, ISSN-e 1390-924X', '2011', '94-97', 'Nº. 116', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(15, 15, 1, 1, 'Ciberactivismo: conceptualización, hipótesis y medida', 'ISSN 0210-1963', '2012', '631-639', 'Nº 756', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(16, 2, 1, 1, 'Ciberactivismo: nueva forma de participación para estudiantes universitarios', 'ISSN 1134-3478', '2016', '47-54', 'Nº 46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(17, 16, 1, 1, 'Consideraciones político criminales en torno a los límites penales del ciberactivismo', 'ISSN 1132-9955', '2014', '435-468', 'Nº 11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(18, 17, 3, 1, 'Cuando la ciudadanía recupera el poder. Deliberación teórica sobre el ciberactivismo, la desobediencia civil y la cultura hacker.', 'ISBN 9788494524325', '2016', '1026-1045', NULL, 'Comunicracia y Desarrollo Social', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(19, 3, 3, 1, 'De la inteligencia al empoderamiento colectivo. Ciberactivismo político y 15-m', 'ISBN 978-84-8408-665-9', '2011', NULL, '', 'El papel de la literatura, el cine y la prensa (TV/internet/mav) en la configuración y promoción de los criterios, valores y actitudes sociales', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(20, 18, 1, 1, 'El ciberactivismo: nuevo modelo de Relaciones Públicas en las ONGs', 'ISSN-e 1697-8293', '2010', '288-302', 'Vol. 8, Nº. 3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(21, 19, 1, 1, 'Internet. Ciberactivismo y coalición de voluntades', 'ISSN 1578-4312', '2003', '80-81', 'Nº 20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(22, 20, 1, 1, 'La comunicación de los lobbies en Internet: el ciberactivismo de los Think Tanks', 'ISSN-e 1697-8293', '2010', '193-206', 'Vol. 8, Nº. 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(23, 21, 3, 1, 'La movilización social en Internet. Eventos organizados a través de la red: ¿fenómeno lúdico o ciberactivismo?', 'ISBN 978-84-613-7299-7', '2010', NULL, '', 'Crisis analógica, futuro digital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(24, 22, 1, 1, 'Mucho ciberactivismo... pocos votos. Antans Mockus y el Partido Verde colombiano', 'ISSN 0251-3552', '2011', '74-89', 'Nº. 235', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(25, 23, 2, 1, 'Redes Sociales y Ciberactivismo: el poder de las plataformas antidesahucio', 'ISBN 9788469713358', '2015', '85-106', NULL, 'Derechos humanos emergentes y periodismo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(26, 24, 1, 1, 'Testimonio: ciberactivismo y medio ambiente. El caso de Greenpace Argentina', 'ISSN 0251-3552', '2011', '122-130', 'Nº. 235', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(27, 4, 1, 1, 'Trabajo en red y ciberactivismo. Los casos de Democracia Real Ya y Equo', 'ISSN 0213-084X', '2015', '126-137', 'Nº. 101 (Junio-septiembre)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `publicaciones` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.tipoautor: ~0 rows (aproximadamente)
DELETE FROM `tipoautor`;
/*!40000 ALTER TABLE `tipoautor` DISABLE KEYS */;
INSERT INTO `tipoautor` (`x_idtipoautor`, `tx_tipoautor`) VALUES
	(1, 'Sin definir');
/*!40000 ALTER TABLE `tipoautor` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.tipoeditor: ~0 rows (aproximadamente)
DELETE FROM `tipoeditor`;
/*!40000 ALTER TABLE `tipoeditor` DISABLE KEYS */;
INSERT INTO `tipoeditor` (`x_idtipoeditor`, `tx_tipoeditor`) VALUES
	(1, 'Sin definir');
/*!40000 ALTER TABLE `tipoeditor` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.users: ~0 rows (aproximadamente)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Volcando datos para la tabla recursos_cibermov_net.usuario: ~0 rows (aproximadamente)
DELETE FROM `usuario`;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
