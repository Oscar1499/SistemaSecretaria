/*
 Navicat Premium Data Transfer

 Source Server         : SIMERCO
 Source Server Type    : MySQL
 Source Server Version : 100619
 Source Host           : cloud-949526.managed-vps.net:3306
 Source Schema         : a1c4lu5v_actas

 Target Server Type    : MySQL
 Target Server Version : 100619
 File Encoding         : 65001

 Date: 31/01/2025 08:50:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for Actas
-- ----------------------------
DROP TABLE IF EXISTS `Actas`;
CREATE TABLE `Actas`  (
  `id_Actas` int NOT NULL AUTO_INCREMENT,
  `id_libros` int NOT NULL,
  `id_Personal` int NULL DEFAULT NULL,
  `estado` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha` date NOT NULL,
  `contenido_elaboracion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `presentes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ausentes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipo_sesion` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `correlativo` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `motivo_ausencia` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_Actas`) USING BTREE,
  INDEX `id_libros`(`id_libros`) USING BTREE,
  INDEX `id_Personal`(`id_Personal`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of Actas
-- ----------------------------

-- ----------------------------
-- Table structure for Acuerdos
-- ----------------------------
DROP TABLE IF EXISTS `Acuerdos`;
CREATE TABLE `Acuerdos`  (
  `id_Acuerdo` int NOT NULL AUTO_INCREMENT,
  `id_Actas` int NOT NULL,
  `id_Personal` int NOT NULL,
  `fecha_Acuerdos` date NOT NULL,
  `motivo_Votacion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion_Acuerdos` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `resultado_votacion` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_Acuerdo`) USING BTREE,
  INDEX `id_Actas`(`id_Actas`) USING BTREE,
  INDEX `id_Personal`(`id_Personal`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of Acuerdos
-- ----------------------------

-- ----------------------------
-- Table structure for acta_personal
-- ----------------------------
DROP TABLE IF EXISTS `acta_personal`;
CREATE TABLE `acta_personal`  (
  `acta_id` int NOT NULL,
  `personal_id` int NOT NULL,
  `motivo_ausencia` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`acta_id`, `personal_id`) USING BTREE,
  INDEX `personal_id`(`personal_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of acta_personal
-- ----------------------------

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------
INSERT INTO `cache` VALUES ('example@example|127.0.0.1:timer', 'i:1738247585;', 1738247585);
INSERT INTO `cache` VALUES ('example@example|127.0.0.1', 'i:1;', 1738247586);
INSERT INTO `cache` VALUES ('example@example.com|127.0.0.1:timer', 'i:1738247595;', 1738247595);
INSERT INTO `cache` VALUES ('example@example.com|127.0.0.1', 'i:1;', 1738247596);
INSERT INTO `cache` VALUES ('oscaralexispalacios9@gmail.com|127.0.0.1:timer', 'i:1738248351;', 1738248351);
INSERT INTO `cache` VALUES ('oscaralexispalacios9@gmail.com|127.0.0.1', 'i:3;', 1738248351);

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for certificacion
-- ----------------------------
DROP TABLE IF EXISTS `certificacion`;
CREATE TABLE `certificacion`  (
  `id_Certificacion` int NOT NULL AUTO_INCREMENT,
  `fecha_Certificacion` date NOT NULL,
  `contenido_Certificacion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_Certificacion`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of certificacion
-- ----------------------------
INSERT INTO `certificacion` VALUES (5, '2025-01-30', '<p style=\"text-align: justify; line-height: 1.5; font-family: Arial, sans-serif; text-justify: inter-word;\">\r\n    La Suscrita secretaria Municipal, previa autorización de la Alcaldesa Municipal CERTIFICA. Que en el \r\n    Libro de Actas y Acuerdos Municipales que el Concejo Municipal Plural de La Unión Sur, lleva en el año\r\n    dos mil veinticinco, se encuentra el acta número VEINTICINCO de Sesión Ordinaria, celebrada lugar a \r\n    las veintiuno horas con cincuenta minutos del día treinta de enero del año dos mil veinticinco, se encuentra \r\n    el acuerdo Municipal número UNO, que literalmente dice:\r\n    ////////////////////////////////////////////////////////////////////////////</p>\r\n    <p style=\"text-align: justify; line-height: 1.5; font-family: Arial, sans-serif; text-justify: inter-word;\">No se pudo obtener la descripción del acuerdo</p>\r\n    <br><br><p style=\"text-align: justify; line-height: 1.5; font-family: Arial, sans-serif; text-justify: inter-word;\">CERTIFÍQUESE Y COMUNÍQUESE.-//////////////////////////////////////\r\n////////////////////////////////////////. Es conforme con su original, con el cu\r\nal fue debidamente confrontada, y para los efectos de Ley se expide la presente \r\n    en el Distrito de La Unión, Municipio de La Unión Sur, Departamento de La Unión,\r\n    a los cinco días del mes de diciembre de dos mil veinticuatro.-\r\n</p>');
INSERT INTO `certificacion` VALUES (4, '2025-01-11', '<p style=\"text-align: justify; line-height: 1.2; font-family: Arial, sans-serif;\">\r\n    La Suscrita secretaria Municipal, previa autorización de la Alcaldesa Municipal CERTIFICA. Que en el \r\n    Libro de Actas y Acuerdos Municipales que el Concejo Municipal Plural de La Unión Sur, lleva en el año\r\n    dos mil veinticinco, se encuentra el acta número VEINTICINCO de Sesión Ordinaria, celebrada lugar a \r\n    las dieciséis horas con diecinueve minutos del día once de enero del año dos mil veinticinco, se encuentra \r\n    el acuerdo Municipal número UNO, que literalmente dice:\r\n    ////////////////////////////////////////////////////////////////////////////</p>\r\n    No se pudo obtener la descripción del acuerdoxd<br><br><p></p> CERTIFÍQUESE Y COMUNÍQUESE.-//////////////////////////////////////\r\n////////////////////////////////////////. Es conforme con su original, con el cu\r\nal fue debidamente confrontada, y para los efectos de Ley se expide la presente \r\nen el Distrito de La Unión, Municipio de La Unión Sur, Departamento de La Unión,\r\n a los cinco días del mes de diciembre de dos mil veinticuatro.-');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING HASH
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue`(250)) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for libros
-- ----------------------------
DROP TABLE IF EXISTS `libros`;
CREATE TABLE `libros`  (
  `id_Libros` int NOT NULL AUTO_INCREMENT,
  `fechainicio_Libro` date NOT NULL,
  `fechafinal_Libro` date NOT NULL,
  `descripcion_Libro` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `apertura_Libro` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_Libros`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of libros
-- ----------------------------
INSERT INTO `libros` VALUES (2, '2025-01-05', '2025-12-27', '1', '<p style=\"text-align: justify; line-height: 1.5; margin: 0;\"><strong>ALCALDÍA MUNICIPAL DE LA UNIÓN SUR, DEPARTAMENTO DE LA UNIÓN,</strong>\r\n            a las diez horas y cincuenta y seis minutos del día cinco de enero del año dos mil veinticinco, EL PRIMER CONSEJO MUNICIPAL PLURAL,\r\n            juramentado constitucionalmente para el periodo 2024-2027, AUTORIZA Y HABILITA el presente Libro de Actas de Sesiones,\r\n            debidamente foliado y sellado para que en él se asienten las actas de sesiones que celebre el primer Concejo Municipal Plural de\r\n            La Unión Sur, del departamento de La Unión, durante el periodo de enero a diciembre del año dos mil veinticinco.</p>\r\n\r\n\r\n        <p style=\"display: none;\" class=\"invisible-line\"></p>\r\n        <p style=\"display: none;\" class=\"invisible-line\"></p>\r\n        <p style=\"text-align: center; line-height: 1.5; margin: 0;\"><strong>______________________________________</strong></p>\r\n        <p style=\"text-align: center; line-height: 1.5; margin: 0;\" id=\"alcaldeSeleccionado\"><strong>Juan alvarado gonzales salmerón1</strong></p>\r\n        <p style=\"text-align: center; line-height: 1.5; margin: 0;\" id=\"alcalde\"><strong>Alcalde Municipal</strong></p>\r\n        <p style=\"display: none;\" class=\"invisible-line\"></p>\r\n        <p style=\"display: none;\" class=\"invisible-line\"></p>\r\n        <p style=\"text-align: center; line-height: 1.5; margin: 0;\"><strong>______________________________________</strong></p>\r\n        <p style=\"text-align: center; line-height: 1.5; margin: 0;\" id=\"sindicoSeleccionado\"><strong>Antonio de jesus rodriguez</strong></p>\r\n        <p style=\"text-align: center; line-height: 1.5; margin: 0;\" id=\"sindico\"><strong>Síndico Municipal</strong></p>', 'Abierto', NULL, NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (5, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (6, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (7, '0001_01_01_000002_create_jobs_table', 1);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal
-- ----------------------------
DROP TABLE IF EXISTS `personal`;
CREATE TABLE `personal`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `propietario` tinyint(1) NOT NULL,
  `rubricas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal
-- ----------------------------
INSERT INTO `personal` VALUES (1, 'Juan alvarado', 'gonzales salmerón1', 'Alcalde', 1, '121', NULL, NULL);
INSERT INTO `personal` VALUES (2, 'Antonio de jesus', 'rodriguez', 'Síndico', 1, 'hg', NULL, NULL);
INSERT INTO `personal` VALUES (3, 'Mariana lopez', 'perez gonzales', 'Secretaria', 1, 'sss', NULL, NULL);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id`) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('7U9SrCoCu7lyng3AP1eF50pw9eUC9qt5IRdTAdDf', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWnZlVEl4SUY1TGhyYVR0QTNEWFQ1c0lZSmp2dUpCaGtSM21JMm5pTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hY3Rhcy9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTczODMzNjc2OTt9fQ==', 1738338462);
INSERT INTO `sessions` VALUES ('W5t8XCKWdCvkWYlxaLV9LDwT7AStQE8LlPTjIQX2', NULL, '146.190.98.16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0JtSnVid2pxYVZPUmFzS1p2Y0M0aVhmREw5R2RNcW85OURCb0xveiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9zZWNyZXRhcmlhLmFsY2FsZGlhbGF1bmlvbi5nb2Iuc3YvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1738333681);
INSERT INTO `sessions` VALUES ('miNMTuyQqfoo4VUMvpeWRqzO4ucQfCF0y6R4iDkI', NULL, '64.226.65.143', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0xXM2xOZ3Q1dnZNZU1BcHU0TkJXOVM0c2ZVWE4xTDl5dFNrNHRlUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vc2VjcmV0YXJpYS5hbGNhbGRpYWxhdW5pb24uZ29iLnN2L2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1738325497);
INSERT INTO `sessions` VALUES ('beAgdJGFyq8OFg4zpyxErdG1fEjB3KBPA5VNARpD', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicmtPeGxFSHdHVnR2YnNla3BNTkJUM290UjlaYnIyV3E1N1V3WDNTeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jZXJ0aWZpY2FjaW9uLzUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTczODI5MDkxMDt9fQ==', 1738299757);
INSERT INTO `sessions` VALUES ('E8w7pbjVmXTBd61JMTjQM15cBBIJyrWV04nY9ynw', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibEJEUnZrN0wyQW9TWndVNnJlUXJvUzBoYzFvMEI5dEVIQWR6cjN3MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738298332);
INSERT INTO `sessions` VALUES ('gf1eWOfBU04j4JqQVSQ5NaMm4MzqiC7dqvfSeaU6', NULL, '64.226.65.143', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXh6dnh6WEFaYWY0VmZON3AyWk41cGVpY2tLOGYzOUMyY3Rjb2ZvYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9zZWNyZXRhcmlhLmFsY2FsZGlhbGF1bmlvbi5nb2Iuc3YiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1738325492);
INSERT INTO `sessions` VALUES ('xSDSrKhm0N3s7FOjNqgRdTrAuKorTCejFjPv64id', NULL, '64.226.65.143', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMERvTzZRQ3hpRkM1WkRBN2FZcmc0dFN0N3FzUjV2ZVVQWUhTVHJsTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9zZWNyZXRhcmlhLmFsY2FsZGlhbGF1bmlvbi5nb2Iuc3YvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1738325493);
INSERT INTO `sessions` VALUES ('m5oZu2OQ3iwfQJXTPKX3WGPCfORY3UA9sQA8sWpQ', NULL, '64.226.65.143', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEVVVTIzRE15d0k3bk8xODlaaUJwUXl1R2pRV3VocHBMaGVuNnkzTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vc2VjcmV0YXJpYS5hbGNhbGRpYWxhdW5pb24uZ29iLnN2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1738325494);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING HASH
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'admin@admin', NULL, '$2y$12$xV4eNFCdb2dvX4KfuGx0wOJNnRT9MmaJiymWRXJAAnzFQ4ItwHXai', NULL, '2025-01-30 08:32:41', '2025-01-30 08:32:41');
INSERT INTO `users` VALUES (2, 'Oscar Alexis Palacios Flores', 'oscaralexispalacios9@gmail.com', NULL, '$2y$12$h6bAA/oyQNUR0EF28jdQTOxG9molPVYDKiuwQFQBEKBELpFrm9HvO', NULL, '2025-01-30 08:45:32', '2025-01-30 08:45:32');

SET FOREIGN_KEY_CHECKS = 1;
