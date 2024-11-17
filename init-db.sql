/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `gsventas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `gsventas`;

CREATE TABLE IF NOT EXISTS `almacenes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `idusuario_encargado` bigint(20) unsigned NOT NULL,
  `capacidad_m3` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `almacenes_name_unique` (`name`),
  UNIQUE KEY `almacenes_direccion_unique` (`direccion`),
  KEY `almacenes_idusuario_encargado_foreign` (`idusuario_encargado`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `almacenes` DISABLE KEYS */;
INSERT INTO `almacenes` (`id`, `name`, `direccion`, `idusuario_encargado`, `capacidad_m3`, `created_at`, `updated_at`) VALUES
	(1, 'Almacen1', 'Calz. Independencia Norte 4221', 10, 1500, '2024-05-19 14:00:43', '2024-05-19 14:08:28'),
	(2, 'Principal', 'Calle Antonio Bravo 151', 1, 30, '2024-05-23 05:23:34', '2024-05-23 05:23:34'),
	(3, 'Secundario', 'direccion prueba', 1, 100, '2024-05-23 05:24:59', '2024-05-23 05:27:08');
/*!40000 ALTER TABLE `almacenes` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `almacen_productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idproducto` bigint(20) unsigned NOT NULL,
  `idalmacen` bigint(20) unsigned NOT NULL,
  `existencia` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `almacen_productos_idproducto_foreign` (`idproducto`),
  KEY `almacen_productos_idalmacen_foreign` (`idalmacen`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `almacen_productos` DISABLE KEYS */;
INSERT INTO `almacen_productos` (`id`, `idproducto`, `idalmacen`, `existencia`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 99, '2024-05-19 14:00:43', '2024-05-19 14:00:43'),
	(2, 3, 1, 120, '2024-05-23 05:20:01', '2024-05-23 05:20:01'),
	(3, 2, 1, 109, '2024-05-23 05:22:59', '2024-05-23 05:22:59'),
	(4, 7, 1, 130, '2024-05-23 05:22:59', '2024-05-23 05:22:59'),
	(5, 6, 2, 136, '2024-05-23 05:23:34', '2024-05-23 05:23:34'),
	(6, 7, 2, 348, '2024-05-23 05:23:34', '2024-05-23 05:23:34'),
	(7, 2, 2, 299, '2024-05-23 05:24:08', '2024-05-23 05:24:08'),
	(8, 3, 2, 498, '2024-05-23 05:24:08', '2024-05-23 05:24:08'),
	(9, 5, 3, 108, '2024-05-23 05:24:59', '2024-05-23 05:24:59'),
	(10, 6, 3, 0, '2024-05-23 05:24:59', '2024-05-23 05:24:59'),
	(11, 7, 3, 6, '2024-05-23 05:24:59', '2024-05-23 05:24:59'),
	(12, 6, 3, 0, '2024-05-23 05:27:08', '2024-05-23 05:27:08');
/*!40000 ALTER TABLE `almacen_productos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `entregas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) unsigned NOT NULL,
  `idpunto_entrega` bigint(20) unsigned NOT NULL,
  `idsocio` bigint(20) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `status` set('Por contactar','Contactado','Confirmado','Entregado','Cancelado - Sin respuesta','Cancelado - Con respuesta','Cancelado - No recibio') DEFAULT NULL,
  `cobrar_cliente` double(8,2) DEFAULT NULL,
  `costo_entrega` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entregas_idusuario_foreign` (`idusuario`),
  KEY `entregas_idpunto_entrega_foreign` (`idpunto_entrega`),
  KEY `entregas_idsocio_foreign` (`idsocio`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `entregas` DISABLE KEYS */;
INSERT INTO `entregas` (`id`, `idusuario`, `idpunto_entrega`, `idsocio`, `fecha`, `hora`, `referencia`, `notas`, `status`, `cobrar_cliente`, `costo_entrega`, `created_at`, `updated_at`) VALUES
	(1, 10, 68, 1, '2024-05-19', '08:12:00', NULL, '', NULL, 1220.00, 20.00, '2024-05-19 14:14:15', '2024-05-19 14:14:15'),
	(2, 10, 68, 1, '2024-05-19', '08:12:00', NULL, '', NULL, 1220.00, 20.00, '2024-05-19 14:14:48', '2024-05-19 14:14:48'),
	(3, 1, 68, 1, '2024-05-19', '08:12:00', NULL, '', NULL, 1220.00, 20.00, '2024-05-19 14:15:13', '2024-05-19 14:15:13'),
	(4, 10, 68, 1, '2024-05-19', '23:00:00', NULL, '', NULL, 1520.00, 20.00, '2024-05-20 04:28:27', '2024-05-20 04:28:27'),
	(5, 10, 68, 1, '2024-05-19', '23:00:00', NULL, NULL, 'Entregado', 1520.00, 20.00, '2024-05-20 04:33:15', '2024-05-23 05:31:52'),
	(6, 10, 27, 3, '2024-05-23', '22:13:00', NULL, '', NULL, 320.00, 20.00, '2024-05-23 04:14:54', '2024-05-23 04:14:54'),
	(7, 10, 27, 3, '2024-05-23', '22:13:00', NULL, '', NULL, 320.00, 20.00, '2024-05-23 04:15:43', '2024-05-23 04:15:43'),
	(8, 1, 27, 3, '2024-05-23', '20:38:00', NULL, '', NULL, 1020.00, 20.00, '2024-05-23 05:39:33', '2024-05-23 05:39:33'),
	(9, 1, 31, 5, '2024-05-22', '18:40:00', NULL, '', NULL, 1030.00, 30.00, '2024-05-23 05:40:08', '2024-05-23 05:40:08'),
	(10, 1, 27, 3, '2024-05-23', '20:38:00', NULL, '', NULL, 1020.00, 20.00, '2024-05-23 05:40:40', '2024-05-23 05:40:40'),
	(11, 1, 14, 6, '2024-05-22', '20:41:00', NULL, '', NULL, 4510.00, 10.00, '2024-05-23 05:43:44', '2024-05-23 05:43:44'),
	(12, 1, 1, 3, '2024-05-22', '23:43:00', NULL, '', NULL, 22500.00, 0.00, '2024-05-23 05:44:01', '2024-05-23 05:44:01'),
	(13, 1, 1, 3, '2024-05-22', '23:43:00', NULL, '', NULL, 22500.00, 0.00, '2024-05-23 05:44:18', '2024-05-23 05:44:18'),
	(14, 1, 31, 7, '2024-05-23', '00:14:00', NULL, NULL, 'Entregado', 700.00, 100.00, '2024-05-23 06:15:41', '2024-05-23 06:17:04');
/*!40000 ALTER TABLE `entregas` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(200) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=239 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(213, '2014_10_12_000000_create_users_table', 1),
	(214, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(215, '2014_10_12_100000_create_password_resets_table', 1),
	(216, '2019_08_19_000000_create_failed_jobs_table', 1),
	(217, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(218, '2024_03_06_061842_create_socios_table', 1),
	(219, '2024_03_06_061843_create_ventas_table', 1),
	(220, '2024_03_06_061845_create_recepciones_table', 1),
	(221, '2024_03_06_061846_create_usuarios_table', 1),
	(222, '2024_03_06_061848_create_puntos_entregas_table', 1),
	(223, '2024_03_06_061849_create_entregas_table', 1),
	(224, '2024_03_06_061850_create_productos_table', 2),
	(225, '2024_03_06_061852_create_almacenes_table', 2),
	(226, '2024_03_06_061853_create_movimientos_table', 2),
	(227, '2024_03_06_061854_create_categorias_table', 2),
	(228, '2024_03_06_061856_create_variantes_table', 2),
	(229, '2024_03_06_061857_create_variantes_categorias_table', 2),
	(230, '2024_03_06_061858_create_productos_variantes_table', 2),
	(231, '2024_03_06_061859_create_proveedores_productos_table', 2),
	(232, '2024_03_06_061901_create_almacen_productos_table', 2),
	(233, '2024_03_06_061902_create_tipos_movimientos_table', 2),
	(234, '2024_03_06_061903_create_movimientos_productos_table', 2),
	(235, '2024_03_06_061904_create_ventas_productos_table', 2),
	(236, '2024_03_06_061906_create_recepciones_productos_table', 2),
	(237, '2024_03_06_061907_create_recepciones_guias_table', 2),
	(238, '2024_03_10_042714_create_roles_table', 2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `movimientos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idsocio` bigint(20) unsigned DEFAULT NULL,
  `idalmacen` bigint(20) unsigned NOT NULL,
  `idusuario` bigint(20) unsigned NOT NULL,
  `idtipo` bigint(20) unsigned NOT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movimientos_idsocio_foreign` (`idsocio`),
  KEY `movimientos_idalmacen_foreign` (`idalmacen`),
  KEY `movimientos_idusuario_foreign` (`idusuario`),
  KEY `movimientos_idtipo_foreign` (`idtipo`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `movimientos` DISABLE KEYS */;
INSERT INTO `movimientos` (`id`, `idsocio`, `idalmacen`, `idusuario`, `idtipo`, `referencia`, `notas`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 10, 2, '', NULL, '2024-05-20 04:33:15', '2024-05-20 04:33:15'),
	(2, 4, 2, 10, 1, '234333443243', '', '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(3, 2, 1, 1, 1, 'ref1', '', '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(4, 4, 3, 10, 1, NULL, '', '2024-05-23 05:35:28', '2024-05-23 05:35:28'),
	(5, 4, 3, 10, 1, NULL, '', '2024-05-23 05:36:34', '2024-05-23 05:36:34'),
	(6, 4, 3, 10, 1, NULL, '', '2024-05-23 05:37:34', '2024-05-23 05:37:34'),
	(7, 5, 2, 1, 2, '', NULL, '2024-05-23 05:40:08', '2024-05-23 05:40:08'),
	(8, 3, 2, 1, 2, '', NULL, '2024-05-23 05:40:40', '2024-05-23 05:40:40'),
	(9, 6, 2, 1, 2, '', NULL, '2024-05-23 05:43:45', '2024-05-23 05:43:45'),
	(10, 3, 3, 10, 2, '', NULL, '2024-05-23 05:44:18', '2024-05-23 05:44:18'),
	(11, 7, 1, 10, 2, '', NULL, '2024-05-23 06:15:41', '2024-05-23 06:15:41');
/*!40000 ALTER TABLE `movimientos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `movimientos_productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idmovimiento` bigint(20) unsigned NOT NULL,
  `idproducto` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tabla_ref` varchar(50) DEFAULT NULL,
  `idtabla_ref` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movimientos_productos_idmovimiento_foreign` (`idmovimiento`),
  KEY `movimientos_productos_idproducto_foreign` (`idproducto`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `movimientos_productos` DISABLE KEYS */;
INSERT INTO `movimientos_productos` (`id`, `idmovimiento`, `idproducto`, `cantidad`, `tabla_ref`, `idtabla_ref`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 5, 'ventas_productos', 1, '2024-05-20 04:33:15', '2024-05-20 04:33:15'),
	(2, 2, 2, 300, 'recepciones_productos', 1, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(3, 2, 3, 500, 'recepciones_productos', 2, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(4, 2, 6, 139, 'recepciones_productos', 3, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(5, 2, 7, 350, 'recepciones_productos', 4, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(6, 3, 1, 100, 'recepciones_productos', 5, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(7, 3, 2, 110, 'recepciones_productos', 6, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(8, 3, 3, 120, 'recepciones_productos', 7, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(9, 3, 7, 130, 'recepciones_productos', 8, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(10, 4, 5, 100, 'recepciones_productos', 9, '2024-05-23 05:35:28', '2024-05-23 05:35:28'),
	(11, 5, 5, 8, 'recepciones_productos', 10, '2024-05-23 05:36:34', '2024-05-23 05:36:34'),
	(12, 6, 6, 15, 'recepciones_productos', 11, '2024-05-23 05:37:34', '2024-05-23 05:37:34'),
	(13, 6, 7, 6, 'recepciones_productos', 12, '2024-05-23 05:37:34', '2024-05-23 05:37:34'),
	(14, 7, 2, 1, 'ventas_productos', 2, '2024-05-23 05:40:08', '2024-05-23 05:40:08'),
	(15, 7, 3, 2, 'ventas_productos', 3, '2024-05-23 05:40:08', '2024-05-23 05:40:08'),
	(16, 8, 7, 2, 'ventas_productos', 4, '2024-05-23 05:40:41', '2024-05-23 05:40:41'),
	(17, 9, 6, 3, 'ventas_productos', 5, '2024-05-23 05:43:45', '2024-05-23 05:43:45'),
	(18, 10, 6, 15, 'ventas_productos', 6, '2024-05-23 05:44:18', '2024-05-23 05:44:18'),
	(19, 11, 1, 1, 'ventas_productos', 7, '2024-05-23 06:15:41', '2024-05-23 06:15:41'),
	(20, 11, 2, 1, 'ventas_productos', 8, '2024-05-23 06:15:41', '2024-05-23 06:15:41');
/*!40000 ALTER TABLE `movimientos_productos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(200) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catalogo` varchar(40) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `precio` double(8,2) NOT NULL DEFAULT 0.00,
  `costo` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id`, `catalogo`, `descripcion`, `precio`, `costo`, `created_at`, `updated_at`) VALUES
	(1, 'Protector Samsung S24', 'Protector duro con seguro para cinturón para teléfono móvil Samsung Galaxy S24', 300.00, 250.00, '2024-05-18 12:11:29', '2024-05-18 12:17:52'),
	(2, 'T500 Plus', 'Smartwatch', 300.00, 200.00, '2024-05-23 04:01:29', '2024-05-23 04:01:29'),
	(3, 'T900 2 Ultra', 'Smartwatch', 350.00, 240.00, '2024-05-23 04:01:57', '2024-05-23 04:04:27'),
	(4, 'T900 Ultra Four', 'Smartwatch', 400.00, 280.00, '2024-05-23 04:02:55', '2024-05-23 04:02:55'),
	(5, 'T800 Ultra', 'Smartwatch', 350.00, 250.00, '2024-05-23 04:03:56', '2024-05-23 04:03:56'),
	(6, 'Dron 19002', 'Dron comercial para entretenimiento', 1500.00, 1350.00, '2024-05-23 04:09:15', '2024-05-23 04:09:15'),
	(7, 'Teclado XPG Summoner Mini', 'Teclado Mecánico 60% switches blue', 500.00, 370.00, '2024-05-23 04:10:13', '2024-05-23 04:10:13');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `puntos_entregas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `clasificacion` varchar(200) DEFAULT NULL,
  `linea` varchar(200) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `puntos_entregas_nombre_unique` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `puntos_entregas` DISABLE KEYS */;
INSERT INTO `puntos_entregas` (`id`, `name`, `clasificacion`, `linea`, `latitud`, `longitud`, `created_at`, `updated_at`) VALUES
	(1, 'Fray Angélico', 'Macrobus', 'Calzada', 20.60881000, -103.34267000, '2024-05-15 10:09:53', '2024-05-15 10:11:02'),
	(2, 'Esculturas', 'Macrobus', 'Calzada', 20.60999000, -103.34234000, '2024-05-15 10:24:35', '2024-05-15 10:24:35'),
	(3, 'Artes Plásticas', 'Macrobus', 'Calzada', 20.61631000, -103.34345000, '2024-05-15 10:25:38', '2024-05-15 10:25:38'),
	(4, 'Clemente Orozco', 'Macrobus', 'Calzada', 20.62240000, -103.34668000, '2024-05-15 10:27:49', '2024-05-15 10:27:49'),
	(5, 'López de Legazpi', 'Macrobus', 'Calzada', 20.62732000, -103.34838000, '2024-05-15 10:29:03', '2024-05-15 10:29:03'),
	(6, 'Zona Industrial', 'Macrobus', 'Calzada', 20.63325000, -103.35072000, '2024-05-15 10:33:43', '2024-05-15 10:33:43'),
	(7, 'El Dean', 'Macrobus', 'Calzada', 20.63752000, -103.35143000, '2024-05-15 10:38:29', '2024-05-15 10:38:29'),
	(8, 'Lázaro Cárdenas', 'Macrobus', 'Calzada', 20.64084000, -103.35192000, '2024-05-15 10:40:11', '2024-05-15 10:40:11'),
	(9, 'Héroe de Nacozari', 'Macrobus', 'Calzada', 20.64667000, -103.35276000, '2024-05-15 10:43:28', '2024-05-15 10:43:28'),
	(10, 'Ciprés', 'Macrobus', 'Calzada', 20.65320000, -103.35329000, '2024-05-15 11:17:46', '2024-05-15 11:17:46'),
	(11, 'Agua Azul', 'Macrobus', 'Calzada', 20.65783000, -103.30990000, '2024-05-15 11:18:25', '2024-05-15 11:18:25'),
	(12, 'Niños Héroes', 'Macrobus', 'Calzada', 20.66389000, -103.34798000, '2024-05-15 11:19:00', '2024-05-15 11:19:00'),
	(13, 'La Paz', 'Macrobus', 'Calzada', 20.66662000, -103.33465000, '2024-05-15 11:19:33', '2024-05-15 11:19:33'),
	(14, 'Bicentenario', 'Macrobus', 'Calzada', 20.67011000, -103.34462000, '2024-05-15 11:20:09', '2024-05-15 11:20:09'),
	(15, 'San Juan De Dios', 'Macrobus', 'Calzada', 20.67553000, -103.34168000, '2024-05-15 11:22:23', '2024-05-15 11:22:23'),
	(16, 'Alameda', 'Macrobus', 'Calzada', 20.68023000, -103.33918000, '2024-05-15 11:23:33', '2024-05-15 11:23:33'),
	(17, 'Juan Álvarez', 'Macrobus', 'Calzada', 20.68534000, -103.33634000, '2024-05-15 11:24:06', '2024-05-15 11:24:06'),
	(18, 'Ciencias de la Salud', 'Macrobus', 'Calzada', 20.68954000, -103.33413000, '2024-05-15 11:28:31', '2024-05-15 11:28:31'),
	(19, 'Circunvalación', 'Macrobus', 'Calzada', 20.69670000, -103.33021000, '2024-05-15 11:29:10', '2024-05-15 11:29:10'),
	(20, 'Monte Olivete', 'Macrobus', 'Calzada', 20.69941000, -103.32873000, '2024-05-15 11:29:46', '2024-05-15 11:29:46'),
	(21, 'Monumental', 'Macrobus', 'Calzada', 20.70393000, -103.32629000, '2024-05-15 11:30:20', '2024-05-15 11:30:20'),
	(22, 'Igualdad', 'Macrobus', 'Calzada', 20.71178000, -103.32205000, '2024-05-15 11:30:54', '2024-05-15 11:30:54'),
	(23, 'San Patricio', 'Macrobus', 'Calzada', 20.71579000, -103.31990000, '2024-05-15 11:33:13', '2024-05-15 11:33:13'),
	(24, 'Independencia Norte', 'Macrobus', 'Calzada', 20.71986000, -103.31767000, '2024-05-15 11:33:59', '2024-05-15 11:33:59'),
	(25, 'Zoológico', 'Macrobus', 'Calzada', 20.72629000, -103.31540000, '2024-05-15 11:35:21', '2024-05-15 11:35:21'),
	(26, 'Huentitán', 'Macrobus', 'Calzada', 20.73213000, -103.31371000, '2024-05-15 11:36:04', '2024-05-15 11:36:04'),
	(27, 'Mirador', 'Macrobus', 'Calzada', 20.73749000, -103.31209000, '2024-05-15 11:36:50', '2024-05-15 11:36:50'),
	(28, 'Carretera a Chapala', 'Macrobus', 'Periferico', 20.59222000, -103.31940000, '2024-05-16 09:31:39', '2024-05-16 09:31:39'),
	(29, 'Las Pintas', 'Macrobus', 'Periferico', 20.58761000, -103.32689000, '2024-05-16 09:32:29', '2024-05-16 09:32:29'),
	(30, 'Artesanos', 'Macrobus', 'Periferico', 20.58247000, -103.33633000, '2024-05-16 09:33:03', '2024-05-16 09:33:03'),
	(31, 'Adolf Horn', 'Macrobus', 'Periferico', 20.57718000, -103.36070000, '2024-05-16 09:33:39', '2024-05-16 09:33:39'),
	(32, 'Toluquilla', 'Macrobus', 'Periferico', 20.57952000, -103.36919000, '2024-05-16 09:34:20', '2024-05-16 09:34:20'),
	(33, '8 de Julio', 'Macrobus', 'Periferico', 20.58673000, -103.38260000, '2024-05-16 09:35:21', '2024-05-16 09:35:21'),
	(34, 'San Sebastianito', 'Macrobus', 'Periferico', 20.59070000, -103.38588000, '2024-05-16 09:35:59', '2024-05-16 09:35:59'),
	(35, 'Periférico Sur', 'Macrobus', 'Periferico', 20.60552000, -103.40017000, '2024-05-16 09:36:40', '2024-05-16 09:36:40'),
	(36, 'Terminal Sur de Autobuses', 'Macrobus', 'Periferico', 20.60852000, -103.40752000, '2024-05-16 09:37:19', '2024-05-16 09:37:19'),
	(37, 'Iteso', 'Macrobus', 'Periferico', 20.61036000, -103.41510000, '2024-05-16 09:37:48', '2024-05-16 09:37:48'),
	(38, 'López Mateos', 'Macrobus', 'Periferico', 20.61282000, -103.42379000, '2024-05-16 09:39:00', '2024-05-16 09:39:00'),
	(39, 'Agrícola', 'Macrobus', 'Periferico', 20.61680000, -103.42904000, '2024-05-16 09:39:40', '2024-05-16 09:39:40'),
	(40, 'El Briseño', 'Macrobus', 'Periferico', 20.62524000, -103.43360000, '2024-05-16 09:56:34', '2024-05-16 09:56:34'),
	(41, 'Mariano Otero', 'Macrobus', 'Periferico', 20.63253000, -103.43677000, '2024-05-16 09:57:58', '2024-05-16 09:57:58'),
	(42, 'Miramar', 'Macrobus', 'Periferico', 20.63592000, -103.43820000, '2024-05-16 09:58:31', '2024-05-16 09:58:31'),
	(43, 'Felipe Ruvalcaba', 'Macrobus', 'Periferico', 20.64296000, -103.44115000, '2024-05-16 10:04:30', '2024-05-16 10:04:30'),
	(44, 'El Colli', 'Macrobus', 'Periferico', 20.64898000, -103.44368000, '2024-05-16 10:06:28', '2024-05-16 10:06:28'),
	(45, 'Chapalita Inn', 'Macrobus', 'Periferico', 20.65489000, -103.44612000, '2024-05-16 10:07:29', '2024-05-16 10:07:29'),
	(46, 'Parque Metropolitano', 'Macrobus', 'Periferico', 20.66163000, -103.44891000, '2024-05-16 10:09:02', '2024-05-16 10:09:02'),
	(47, 'Ciudad Granja', 'Macrobus', 'Periferico', 20.67515000, -103.45520000, '2024-05-16 10:10:15', '2024-05-16 10:10:15'),
	(48, 'Ciudad Judicial', 'Macrobus', 'Periferico', 20.68071000, -103.45521000, '2024-05-16 10:12:19', '2024-05-16 10:12:19'),
	(49, 'Estadio Chivas', 'Macrobus', 'Periferico', 20.68825000, -103.45534000, '2024-05-16 10:13:26', '2024-05-16 10:13:26'),
	(50, 'Vallarta', 'Macrobus', 'Periferico', 20.69640000, -103.45459000, '2024-05-16 10:16:31', '2024-05-16 10:16:31'),
	(51, 'San Juan De Ocotán', 'Macrobus', 'Periferico', 20.70646000, -103.44651000, '2024-05-16 10:17:29', '2024-05-16 10:17:29'),
	(52, '5 de Mayo', 'Macrobus', 'Periferico', 20.71044000, -103.43947000, '2024-05-16 10:20:53', '2024-05-16 10:20:53'),
	(53, 'Acueducto', 'Macrobus', 'Periferico', 20.72272000, -103.42112000, '2024-05-16 10:21:32', '2024-05-16 10:21:32'),
	(54, 'Santa Margarita', 'Macrobus', 'Periferico', 20.73013000, -103.41296000, '2024-05-16 10:22:12', '2024-05-16 10:22:12'),
	(55, 'La Tuzanía', 'Macrobus', 'Periferico', 20.73365000, -103.40948000, '2024-05-16 10:23:42', '2024-05-16 10:23:42'),
	(56, 'Periférico Belenes', 'Macrobus', 'Periferico', 20.73906000, -103.40314000, '2024-05-16 10:25:00', '2024-05-16 10:25:00'),
	(57, 'San Isidro', 'Macrobus', 'Periferico', 20.74041000, -103.38824000, '2024-05-16 10:25:31', '2024-05-16 10:25:31'),
	(58, 'Centro Cultural Universitario', 'Macrobus', 'Periferico', 20.73932000, -103.38216000, '2024-05-16 10:40:15', '2024-05-16 10:40:15'),
	(59, 'Constitución', 'Macrobus', 'Periferico', 20.73778000, -103.37636000, '2024-05-16 10:41:05', '2024-05-16 10:41:05'),
	(60, 'Tabachines', 'Macrobus', 'Periferico', 20.73421000, -103.36310000, '2024-05-16 10:41:59', '2024-05-16 10:41:59'),
	(61, 'La Cantera', 'Macrobus', 'Periferico', 20.73232000, -103.35612000, '2024-05-16 10:43:05', '2024-05-16 10:43:05'),
	(62, 'Periférico Norte', 'Macrobus', 'Periferico', 20.73075000, -103.35117000, '2024-05-16 10:43:46', '2024-05-16 10:43:46'),
	(63, 'El Batán', 'Macrobus', 'Periferico', 20.72828000, -103.34457000, '2024-05-16 10:48:56', '2024-05-16 10:48:56'),
	(64, 'La Experiencia', 'Macrobus', 'Periferico', 20.72575000, -103.33761000, '2024-05-16 10:49:34', '2024-05-16 10:49:34'),
	(65, 'Rancho Nuevo', 'Macrobus', 'Periferico', 20.72303000, -103.33035000, '2024-05-16 10:51:01', '2024-05-16 10:51:01'),
	(66, 'Lomas del Paraíso', 'Macrobus', 'Periferico', 20.72149000, -103.32624000, '2024-05-16 10:53:41', '2024-05-16 10:53:41'),
	(67, 'Independencia Norte MP', 'Macrobus', 'Periferico', 20.72045000, -103.31598000, '2024-05-16 10:55:24', '2024-05-16 10:55:24'),
	(68, 'Zoológico Guadalajara', 'Macrobus', 'Periferico', 20.71798000, -103.31092000, '2024-05-16 10:56:19', '2024-05-16 10:56:19'),
	(69, 'Barranca de Huentitán', 'Macrobus', 'Periferico', 20.71319000, -103.30095000, '2024-05-16 10:57:00', '2024-05-16 10:57:00'),
	(70, 'Arcos de Zapopan', 'Tren', '3', 20.74106300, -103.40725700, '2024-05-17 06:15:31', '2024-05-17 06:54:24');
/*!40000 ALTER TABLE `puntos_entregas` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `recepciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idsocio` bigint(20) unsigned NOT NULL,
  `idalmacen` bigint(20) unsigned NOT NULL,
  `forma_pago` set('Deposito bancario','Tranferencia','SPEI','Efectivo','Pago en plataforma') NOT NULL DEFAULT '',
  `cuenta_pago` varchar(30) DEFAULT NULL,
  `fecha_recepcion` date NOT NULL,
  `guia` varchar(50) DEFAULT NULL,
  `idusuario` bigint(20) unsigned NOT NULL,
  `referencia` varchar(20) DEFAULT NULL,
  `costos_extras` float NOT NULL DEFAULT 0,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recepciones_idalmacen_foreign` (`idalmacen`),
  KEY `recepciones_idusuario_foreign` (`idusuario`),
  KEY `recepciones_idsocio_foreign` (`idsocio`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `recepciones` DISABLE KEYS */;
INSERT INTO `recepciones` (`id`, `idsocio`, `idalmacen`, `forma_pago`, `cuenta_pago`, `fecha_recepcion`, `guia`, `idusuario`, `referencia`, `costos_extras`, `total`, `created_at`, `updated_at`) VALUES
	(1, 4, 2, 'Deposito bancario', '2837192839923', '2024-05-22', 'Fedex', 10, '234333443243', 150, 497300.00, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(2, 2, 1, 'Efectivo', '526035', '2024-05-22', 'guia1234', 1, 'ref1', 450, 124350.00, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(3, 4, 3, 'Efectivo', NULL, '2024-05-22', NULL, 10, NULL, 0, 25000.00, '2024-05-23 05:35:28', '2024-05-23 05:35:28'),
	(4, 4, 3, 'Efectivo', NULL, '2024-05-22', NULL, 10, NULL, 0, 2000.00, '2024-05-23 05:36:34', '2024-05-23 05:36:34'),
	(5, 4, 3, 'Efectivo', NULL, '2024-05-22', NULL, 10, NULL, 0, 22470.00, '2024-05-23 05:37:34', '2024-05-23 05:37:34');
/*!40000 ALTER TABLE `recepciones` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `recepciones_guias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idrecepcion` bigint(20) unsigned NOT NULL,
  `paqueteria` varchar(200) DEFAULT NULL,
  `numero_guia` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recepciones_guias_idrecepcion_foreign` (`idrecepcion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `recepciones_guias` DISABLE KEYS */;
/*!40000 ALTER TABLE `recepciones_guias` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `recepciones_productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idrecepcion` bigint(20) unsigned NOT NULL,
  `costo` double(8,2) NOT NULL,
  `idproducto` bigint(20) unsigned NOT NULL,
  `cantidad` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recepciones_productos_idrecepcion_foreign` (`idrecepcion`),
  KEY `recepciones_productos_idproducto_foreign` (`idproducto`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `recepciones_productos` DISABLE KEYS */;
INSERT INTO `recepciones_productos` (`id`, `idrecepcion`, `costo`, `idproducto`, `cantidad`, `created_at`, `updated_at`) VALUES
	(1, 1, 200.00, 2, 300, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(2, 1, 240.00, 3, 500, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(3, 1, 1350.00, 6, 139, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(4, 1, 370.00, 7, 350, '2024-05-23 05:27:33', '2024-05-23 05:27:33'),
	(5, 2, 250.00, 1, 100, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(6, 2, 200.00, 2, 110, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(7, 2, 240.00, 3, 120, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(8, 2, 370.00, 7, 130, '2024-05-23 05:28:41', '2024-05-23 05:28:41'),
	(9, 3, 250.00, 5, 100, '2024-05-23 05:35:28', '2024-05-23 05:35:28'),
	(10, 4, 250.00, 5, 8, '2024-05-23 05:36:34', '2024-05-23 05:36:34'),
	(11, 5, 1350.00, 6, 15, '2024-05-23 05:37:34', '2024-05-23 05:37:34'),
	(12, 5, 370.00, 7, 6, '2024-05-23 05:37:34', '2024-05-23 05:37:34');
/*!40000 ALTER TABLE `recepciones_productos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `socios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` bigint(20) NOT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `sexo` set('Hombre','Mujer','Indefinido') DEFAULT 'Indefinido',
  `dias_entrega` int(11) DEFAULT NULL,
  `plataforma` varchar(100) DEFAULT NULL,
  `rfc` varchar(25) DEFAULT NULL,
  `tipo` set('cliente','proveedor','ambos') NOT NULL DEFAULT 'cliente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `socios_name_unique` (`name`),
  UNIQUE KEY `socios_telefono_unique` (`telefono`),
  UNIQUE KEY `socios_rfc_unique` (`rfc`),
  KEY `socios_name_email_index` (`name`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `socios` DISABLE KEYS */;
INSERT INTO `socios` (`id`, `name`, `email`, `telefono`, `domicilio`, `sexo`, `dias_entrega`, `plataforma`, `rfc`, `tipo`, `created_at`, `updated_at`) VALUES
	(1, 'prueba1', 'correoprueba@hotmail.com', 1234567891, 'DOMICILIO1', 'Hombre', 1, 'Facebook', 'PRUEBA1234', 'cliente', '2024-05-19 13:33:59', '2024-05-19 13:33:59'),
	(2, 'PROVEEDOR1', 'proveedor@hotmail.com', 1234567899, 'domicilio1', 'Mujer', 2, 'Facebook', 'PRUEBA12341', 'proveedor', '2024-05-19 15:10:13', '2024-05-19 15:10:13'),
	(3, 'cesar', 'cesar@hotmail.com', 1234567890, 'Domicilio 2', 'Hombre', 2, 'Facebook', 'CESA1253772', 'cliente', '2024-05-23 04:11:19', '2024-05-23 04:11:19'),
	(4, 'yoel', 'yoel@outlook.com', 7482947261, 'Domicilio 1', 'Hombre', 2, 'Facebook', 'YOEL2738926', 'proveedor', '2024-05-23 04:12:37', '2024-05-23 04:12:37'),
	(5, 'Ivan Ramirez', NULL, 3311587462, NULL, 'Indefinido', NULL, NULL, NULL, 'cliente', '2024-05-23 05:40:08', '2024-05-23 05:40:08'),
	(6, 'José Jose', NULL, 4390849200, NULL, 'Indefinido', NULL, NULL, NULL, 'cliente', '2024-05-23 05:43:44', '2024-05-23 05:43:44'),
	(7, 'lolo', NULL, 1212121212, NULL, 'Indefinido', NULL, NULL, NULL, 'cliente', '2024-05-23 06:15:41', '2024-05-23 06:15:41');
/*!40000 ALTER TABLE `socios` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `tipos_movimientos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `concepto` varchar(200) NOT NULL,
  `tipo` set('Entrada','Salida') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipos_movimientos_concepto_unique` (`concepto`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `tipos_movimientos` DISABLE KEYS */;
INSERT INTO `tipos_movimientos` (`id`, `concepto`, `tipo`, `created_at`, `updated_at`) VALUES
	(1, 'Entrada por recepcion', 'Entrada', '2024-04-16 11:05:52', '2024-04-16 11:05:53'),
	(2, 'Salida por venta', 'Salida', '2024-04-29 01:12:46', '2024-04-29 01:12:48');
/*!40000 ALTER TABLE `tipos_movimientos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `telefono` bigint(20) NOT NULL DEFAULT 0,
  `ine` varchar(20) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `rfc` varchar(25) DEFAULT NULL,
  `idrol` bigint(20) unsigned NOT NULL DEFAULT 1,
  `password` varchar(200) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_telefono_unique` (`telefono`),
  UNIQUE KEY `users_ine_unique` (`ine`),
  UNIQUE KEY `users_rfc_unique` (`rfc`),
  KEY `users_idrol_foreign` (`idrol`),
  KEY `users_name_email_index` (`name`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `telefono`, `ine`, `domicilio`, `rfc`, `idrol`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Administrador', 'admin@redgq.uk', NULL, 3311535744, 'INE2034', 'DOMICILIO 1', 'qucg003jfg', 1, '$2y$12$NJauf/r5oXPPcLO6OD5M3uiUbTR9yueDKroXKtQL4Icee8.9uBnC2', NULL, '2024-03-10 21:14:58', '2024-05-08 10:18:23'),
	(10, 'prueba', 'prueba@redgq.uk', NULL, 1122334455, 'INEPRUEBA12', 'DOMICILIO 2', 'PRUE123454', 1, '$2y$12$LytWjzJoa1G4CQQs/UXWQeO3sz53fwCjwHIyr0pcbyk4hHfvYflMC', NULL, '2024-05-17 14:30:28', '2024-05-17 14:30:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idsocio` bigint(20) unsigned NOT NULL,
  `idalmacen` bigint(20) unsigned NOT NULL,
  `identrega` bigint(20) unsigned NOT NULL,
  `idusuario` bigint(20) unsigned NOT NULL,
  `forma_pago` set('Deposito bancario','Tranferencia','SPEI','Efectivo','Pago en plataforma') NOT NULL DEFAULT '',
  `referencia` varchar(20) DEFAULT NULL,
  `cuenta_pago` varchar(30) DEFAULT NULL,
  `total` varchar(200) NOT NULL,
  `notas` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ventas_idsocio_foreign` (`idsocio`),
  KEY `ventas_idalmacen_foreign` (`idalmacen`),
  KEY `ventas_identrega_foreign` (`identrega`),
  KEY `ventas_idusuario_foreign` (`idusuario`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` (`id`, `idsocio`, `idalmacen`, `identrega`, `idusuario`, `forma_pago`, `referencia`, `cuenta_pago`, `total`, `notas`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 5, 10, 'Efectivo', NULL, '123456789456123456', '1520.00', 'Vernos en la estacion de macrobus', '2024-05-20 04:33:15', '2024-05-20 04:33:15'),
	(2, 5, 2, 9, 1, 'Efectivo', NULL, NULL, '1030.00', 'afuera de la estacion', '2024-05-23 05:40:08', '2024-05-23 05:40:08'),
	(3, 3, 2, 10, 1, 'Deposito bancario', NULL, '3948209348003', '1020.00', 'Llego 5 min antes', '2024-05-23 05:40:40', '2024-05-23 05:40:40'),
	(4, 6, 2, 11, 1, 'Tranferencia', NULL, '2837555567093', '4510.00', 'Espero en la entrada de la estacion', '2024-05-23 05:43:45', '2024-05-23 05:43:45'),
	(5, 3, 3, 13, 10, 'Efectivo', NULL, NULL, '22500.00', 'marcar', '2024-05-23 05:44:18', '2024-05-23 05:44:18'),
	(6, 7, 1, 14, 10, 'Efectivo', NULL, '1', '700.00', '.', '2024-05-23 06:15:41', '2024-05-23 06:15:41');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `ventas_productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idproducto` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idventa` bigint(20) unsigned NOT NULL,
  `preciou` double(8,2) NOT NULL,
  `desc_porcentaje` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ventas_productos_idproducto_foreign` (`idproducto`),
  KEY `ventas_productos_idventa_foreign` (`idventa`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `ventas_productos` DISABLE KEYS */;
INSERT INTO `ventas_productos` (`id`, `idproducto`, `cantidad`, `idventa`, `preciou`, `desc_porcentaje`, `created_at`, `updated_at`) VALUES
	(1, 1, 5, 1, 300.00, 0.00, '2024-05-20 04:33:15', '2024-05-20 04:33:15'),
	(2, 2, 1, 2, 300.00, 0.00, '2024-05-23 05:40:08', '2024-05-23 05:40:08'),
	(3, 3, 2, 2, 350.00, 0.00, '2024-05-23 05:40:08', '2024-05-23 05:40:08'),
	(4, 7, 2, 3, 500.00, 0.00, '2024-05-23 05:40:41', '2024-05-23 05:40:41'),
	(5, 6, 3, 4, 1500.00, 0.00, '2024-05-23 05:43:45', '2024-05-23 05:43:45'),
	(6, 6, 15, 5, 1500.00, 0.00, '2024-05-23 05:44:18', '2024-05-23 05:44:18'),
	(7, 1, 1, 6, 300.00, 0.00, '2024-05-23 06:15:41', '2024-05-23 06:15:41'),
	(8, 2, 1, 6, 300.00, 0.00, '2024-05-23 06:15:41', '2024-05-23 06:15:41');
/*!40000 ALTER TABLE `ventas_productos` ENABLE KEYS */;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE DEFINER=`root`@`%` TRIGGER movimientos_actualizar_existencia AFTER INSERT ON movimientos_productos
FOR EACH ROW
BEGIN
    DECLARE tipo_movimiento VARCHAR(50);
    DECLARE factor INT;
    
    -- Obtener el tipo de movimiento (entrada o salida)
    SELECT tipo INTO tipo_movimiento
    FROM tipos_movimientos
    WHERE id = (SELECT idtipo FROM movimientos WHERE id = NEW.idmovimiento);
    
    -- Determinar el factor según el tipo de movimiento
    IF tipo_movimiento = 'Entrada' THEN
        SET factor = 1;
    ELSE
        SET factor = -1;
    END IF;
    
    -- Actualizar la existencia en almacen_productos
    UPDATE almacen_productos
    SET existencia = existencia + (NEW.cantidad * factor)
    WHERE idproducto = NEW.idproducto
    AND idalmacen = (SELECT idalmacen FROM movimientos WHERE id = NEW.idmovimiento);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
