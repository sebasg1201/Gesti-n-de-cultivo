-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2026 a las 02:19:01
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_cultivos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_riegos`
--

CREATE TABLE `catalogo_riegos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `impacto_dias` int(11) NOT NULL DEFAULT 0,
  `descripcion_tecnica` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `catalogo_riegos`
--

INSERT INTO `catalogo_riegos` (`id`, `nombre`, `impacto_dias`, `descripcion_tecnica`, `created_at`, `updated_at`) VALUES
(1, 'Goteo', -3, 'Suministro lento y directo a las raíces, ahorro máximo de agua.', NULL, NULL),
(2, 'Aspersión', 0, 'Simulación de lluvia, ideal para grandes superficies.', NULL, NULL),
(3, 'Micro-aspersión', -1, 'Riego fino para cultivos delicados o invernaderos.', NULL, NULL),
(4, 'Gravedad (Surcos)', 2, 'Distribución por canales, uso tradicional en terrenos planos.', NULL, NULL),
(5, 'Manual (Manguera/Balde)', 3, 'Aplicación directa controlada por el operario, menos eficiente.', NULL, '2026-03-07 19:27:51'),
(6, 'Hidropónico', -7, 'Circulación de solución nutritiva en agua, crecimiento acelerado.', NULL, '2026-03-07 19:27:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_semillas`
--

CREATE TABLE `catalogo_semillas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tiempo_base_dias` int(11) NOT NULL,
  `rendimiento_promedio` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `catalogo_semillas`
--

INSERT INTO `catalogo_semillas` (`id`, `nombre`, `descripcion`, `tiempo_base_dias`, `rendimiento_promedio`, `created_at`, `updated_at`) VALUES
(1, 'Tomate Chonto', 'Variedad de tomate muy resistente, ideal para salsas.', 90, 12.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(2, 'Café Arábigo', 'Variedad premium de café con aroma intenso y acidez equilibrada.', 210, 1.50, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(3, 'Maíz Amarillo', 'Cereal básico para la alimentación, ciclo corto.', 120, 3.50, NULL, NULL),
(4, 'Papa Pastusa', 'Variedad de papa de textura harinosa, muy popular en Colombia.', 135, 25.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(5, 'Cacao', 'Cultivo de clima cálido, base para el chocolate.', 180, 0.80, NULL, NULL),
(6, 'Arroz', 'Cereal de inundación o secano, base de la dieta.', 130, 6.00, NULL, NULL),
(7, 'Maíz Dulce', 'Maíz de grano tierno y dulce, ideal para consumo humano directo.', 85, 4.50, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(8, 'Cebolla Cabezona', 'Bulbo de sabor fuerte, uso esencial en cocina.', 120, 15.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(9, 'Papa Criolla', 'Papa pequeña y amarilla, ciclo corto y sabor suave.', 110, 10.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(10, 'Zanahoria', 'Raíz naranja rica en carotenos, ciclo productivo estándar.', 110, 20.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(11, 'Fresa', 'Fruta roja pequeña, requiere suelos ácidos y buen riego.', 150, 0.80, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(12, 'Cacao Forastero', 'Variedad de cacao muy productiva y resistente.', 165, 1.20, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(13, 'Plátano Hartón', 'Plátano de gran tamaño usado principalmente para cocinar.', 360, 14.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(14, 'Aguacate Hass', 'Variedad de aguacate con piel rugosa y alto contenido de aceite.', 240, 8.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51'),
(15, 'Fríjol Cargamanto', 'Leguminosa de grano grande, muy apreciada en la región andina.', 140, 2.20, '2026-03-07 19:26:40', '2026-03-07 19:27:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_suelos`
--

CREATE TABLE `catalogo_suelos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `impacto_dias` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `catalogo_suelos`
--

INSERT INTO `catalogo_suelos` (`id`, `nombre`, `impacto_dias`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Arcilloso', 5, 'Suelo pesado con alta retención de humedad, pero drenaje lento.', NULL, '2026-03-07 19:27:51'),
(2, 'Arenoso', -3, 'Drenaje rápido, requiere riego frecuente, acelera ciclo en algunos cultivos.', NULL, '2026-03-07 19:27:51'),
(3, 'Franco-Arenoso', 0, NULL, NULL, NULL),
(4, 'Limoso', 0, 'Suelo fértil con buena retención de nutrientes y humedad equilibrada.', NULL, '2026-03-07 19:27:51'),
(5, 'Orgánico (Húmico)', -10, NULL, NULL, NULL),
(6, 'Franco', -1, 'Mezcla ideal de arena, limo y arcilla para la mayoría de cultivos.', '2026-03-07 19:27:51', '2026-03-07 19:27:51'),
(7, 'Salino', 10, 'Alta concentración de sales que retrasa el crecimiento vegetal.', '2026-03-07 19:27:51', '2026-03-07 19:27:51'),
(8, 'Turba / Orgánico', -2, 'Extremadamente fértil y rico en materia orgánica.', '2026-03-07 19:27:51', '2026-03-07 19:27:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cosecha`
--

CREATE TABLE `cosecha` (
  `id_cosecha` int(11) NOT NULL,
  `id_empresa` varchar(20) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `id_terreno` int(11) DEFAULT NULL,
  `id_semilla` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1,
  `fecha_siembra` date DEFAULT NULL,
  `fecha_estimada` date DEFAULT NULL,
  `produccion_estimada` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cultivo`
--

CREATE TABLE `cultivo` (
  `id_cultivo` int(11) NOT NULL,
  `fecha_recoleccion` date DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `documento` int(11) NOT NULL,
  `cantidad_producida` decimal(10,2) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cultivo`
--

CREATE TABLE `detalle_cultivo` (
  `id_detalle_cultivo` int(11) NOT NULL,
  `id_cultivo` int(11) DEFAULT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_fases_programadas`
--

CREATE TABLE `detalle_fases_programadas` (
  `id_detalle_fases` int(11) NOT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `id_riego` int(11) DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_fase` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producto_cultivo`
--

CREATE TABLE `detalle_producto_cultivo` (
  `id_detalle` int(11) NOT NULL,
  `id_cultivo` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `calidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` varchar(14) NOT NULL,
  `nombre_empresa` varchar(200) NOT NULL,
  `nombre_repre_legal` varchar(100) NOT NULL,
  `cedula_repre` int(11) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nombre_empresa`, `nombre_repre_legal`, `cedula_repre`, `telefono`, `correo`, `direccion`, `fecha_creacion`, `id_estado`) VALUES
('103455657789', 'Colombia', 'Sebas Alvarez', 1006511653, '3103524334', 'sombrahdepaz76@gmail.com', 'MzN Casa 1 El_Pedregal', '2026-02-25 23:20:02', 3),
('411234141412', 'Agro-Valle', 'didier reyes', 1004546565, '2123141434', 'juansuaza1528@gmail.com', 'MzN Casa 1 El_Pedregal', '2026-02-25 23:20:54', 3),
('834324234', 'Huila construye', 'Sebastian Rodriguez', 1034334234, '3203242424', 'david@gmail.com', 'Carrera 10 # 20-32', '2026-02-27 01:05:52', 3),
('876767657', 'Agro Huila', 'Sebas Martinez', 1032342344, '3223243434', 'sombrahdepaz@gmail.com', 'CALLE 23 # 34-32', '2026-03-01 19:50:43', 3),
('988091212', 'IBague medio', 'johan oeres', 1110495788, '3103527239', 'johsn@gmail.com', 'MzN Casa# 1 Picaleña', '2026-03-06 12:40:27', 3),
('989979777', 'Pereira Sas', 'Julio Profe', 32092123, '3021212212', 'Julio@gmail.com', 'vereda cipqui', '2026-03-03 13:41:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `nombre_estado`) VALUES
(1, 'pendiente'),
(2, 'bloqueada'),
(3, 'activa'),
(5, 'aprobada'),
(6, 'ocupado'),
(7, 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fases_programadas`
--

CREATE TABLE `fases_programadas` (
  `id_fase` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_programada` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `documento` int(11) DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `ID_insumo` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Calidad` varchar(50) DEFAULT NULL,
  `cantidad_stock` decimal(10,2) NOT NULL,
  `Fecha_ingreso` date DEFAULT NULL,
  `Fecha_vencimiento` date DEFAULT NULL,
  `descripcion` text NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo_cosecha`
--

CREATE TABLE `insumo_cosecha` (
  `id_insumo_cosecha` int(11) NOT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `cantidad_usada` decimal(10,2) DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_09_181957_create_tipo_licencias_table', 2),
(5, '2026_02_11_192209_add_id_tipo_licencia_to_solicitud_compra_table', 2),
(6, '2026_02_11_192642_add_foreign_key_to_solicitud_compra_table', 3),
(7, '2026_02_17_232000_add_nit_empresa_to_solicitud_compra_table', 4),
(8, '2026_02_19_000000_make_comprobante_pago_nullable_in_solicitud_compra', 4),
(9, '2026_02_23_212705_create_riegos_table', 4),
(10, '2026_02_27_191836_change_documento_to_bigint_in_usuario_table', 5),
(11, '2026_02_27_192702_fix_tipo_cosecha_riego_foreign_keycommunity', 6),
(12, '2026_03_06_000001_add_id_empresa_to_tipo_semilla', 6),
(13, '2026_03_06_000002_add_id_empresa_to_tipo_riego', 6),
(14, '2026_03_06_000003_add_id_empresa_to_tipo_cosecha', 6),
(15, '2026_03_06_000004_add_id_empresa_to_cosecha', 6),
(16, '2026_03_07_000000_add_id_empresa_to_multiple_tables', 7),
(17, '2026_03_07_000001_create_catalogs_tables', 8),
(18, '2026_03_07_000002_create_irrigation_catalog', 9),
(19, '2026_03_07_000003_add_impact_to_irrigation', 10),
(20, '2026_03_07_000004_add_description_to_soil_catalog', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `Codigo_Referencia` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `ID_insumo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `riego`
--

CREATE TABLE `riego` (
  `id_riego` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `cant_agua_apl` varchar(50) DEFAULT NULL,
  `observaciones` text NOT NULL,
  `id_tipo_riego` int(11) DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3YWbH1k6E1CB6CwANXxwy892hWECQgpU1oXaRq8K', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 OPR/127.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZmpWaHNNdmFha2FkQ1I1REN2NExRUmFHZjVlNXhSMkZzVEhHQ1VqYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90ZXJyZW5vcyI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4udGVycmVub3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU0OiJsb2dpbl91c3VhcmlvXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTEwNDkyMTIyMzt9', 1772932551),
('O2apUrLqH3VTWDUqTsRxbsM89RG3hnhroahQFrzy', 1110722345, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOFN3eXJpdmpCbk5ma3BGVUlkTGc1ZDVJQVk4eEt5SGd2a2xnWHBiViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb25maWd1cmFjaW9uIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5jb25maWd1cmFjaW9uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1NDoibG9naW5fdXN1YXJpb181OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjExMTA3MjIzNDU7fQ==', 1772926389);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_compra`
--

CREATE TABLE `solicitud_compra` (
  `id_solicitud` int(11) NOT NULL,
  `id_empresa` varchar(14) NOT NULL,
  `comprobante_pago` varchar(255) DEFAULT NULL,
  `id_tipo_licencia` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `fecha_revision` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_compra`
--

INSERT INTO `solicitud_compra` (`id_solicitud`, `id_empresa`, `comprobante_pago`, `id_tipo_licencia`, `id_estado`, `fecha_solicitud`, `fecha_revision`) VALUES
(23, '103455657789', 'comprobantes/1772079602.png', 2, 5, '2026-02-25 23:20:02', '2026-02-25 23:21:55'),
(24, '411234141412', 'comprobantes/1772079654.png', 1, 5, '2026-02-25 23:20:54', '2026-02-25 23:27:15'),
(25, '834324234', NULL, 3, 5, '2026-02-27 01:05:52', '2026-02-27 01:05:52'),
(26, '876767657', NULL, 2, 5, '2026-03-01 19:50:43', '2026-03-01 19:50:43'),
(27, '989979777', NULL, 1, 5, '2026-03-03 13:41:00', '2026-03-03 13:41:00'),
(28, '988091212', NULL, 2, 5, '2026-03-06 12:40:27', '2026-03-06 12:40:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `super_admin`
--

CREATE TABLE `super_admin` (
  `id_super_admin` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `super_admin`
--

INSERT INTO `super_admin` (`id_super_admin`, `nombre`, `usuario`, `correo`, `password_hash`, `id_estado`, `ultimo_login`, `fecha_creacion`, `fecha_actualizacion`, `remember_token`, `created_at`, `updated_at`) VALUES
(121121222, 'Sebastian Garcia', 'sebas', 'sebastiangarciaalvarez123@gmail.com', '$2y$12$YoWr9W3m9DTOdIq9lQl5v.UUywmt.V8dWL.E6.BS8jtcLy9xzzoPG', 3, NULL, '2026-02-17 02:13:13', '2026-02-17 02:13:13', NULL, NULL, NULL),
(1006511657, 'Brayan Basto', 'Stevan', 'bastobrayan246@gmail.com', '$2y$12$Qh0yFs6SfldIhbRSw2gfguC8OukaAtB1KnOBga5XY/dKXi.2070X.', 3, NULL, '2026-02-10 03:51:59', '2026-02-27 06:08:38', '0CqKzqc1RBu5ZsV0zQxXdhO0KXCywQsdg9CjSTg6YJtNAOrMw3P8ID8DgRa5', NULL, '2026-02-13 02:07:57'),
(1110495789, 'Didier Reyes', 'dires123', 'didierreyes003@gmail.com', '$2y$12$clokDFJH4WGM0yZX.78S3OjOSjWUpkLoM/YGC47PorfBCOiE/88vm', 3, NULL, '2026-02-09 19:43:33', '2026-03-06 17:47:16', 'hukS0m7pICMEA3EaqY0OeMIQkf0xjDEh6BR0R2L7NLVRuLT7snbUzEehA5cY', NULL, '2026-03-03 17:46:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terreno`
--

CREATE TABLE `terreno` (
  `id_terreno` int(11) NOT NULL,
  `id_empresa` varchar(20) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `Ancho` decimal(10,0) NOT NULL,
  `Alto` decimal(10,0) NOT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_tipo_suelo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `terreno`
--

INSERT INTO `terreno` (`id_terreno`, `id_empresa`, `nombre`, `ubicacion`, `Ancho`, `Alto`, `id_estado`, `id_tipo_suelo`) VALUES
(3, '834324234', 'Cascada', 'Cascada del potrero las tribunas', 123, 76, 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_licencia`
--

CREATE TABLE `tipo_licencia` (
  `id_tipo_licencia` int(14) NOT NULL,
  `nombre_licencia` varchar(50) NOT NULL,
  `tiempo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(15,2) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_licencia`
--

INSERT INTO `tipo_licencia` (`id_tipo_licencia`, `nombre_licencia`, `tiempo`, `descripcion`, `precio`, `id_estado`) VALUES
(1, 'Basico', '1 Mes', '24 Horas De Soporte', 50000.00, 1),
(2, 'Medium', '6 Meses', '24 Horas De Soporte', 300000.00, 1),
(3, 'Profesional', '1 Año', '24 Horas De Soporte', 600000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_riego`
--

CREATE TABLE `tipo_riego` (
  `id_tipo_riego` int(11) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_riego` varchar(50) DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_riego`
--

INSERT INTO `tipo_riego` (`id_tipo_riego`, `id_empresa`, `id_catalogo`, `tipo_riego`, `impacto_dias`) VALUES
(4, '988091212', 1, 'Goteo', -3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_semilla`
--

CREATE TABLE `tipo_semilla` (
  `id_semilla` int(11) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre_semilla` varchar(100) DEFAULT NULL,
  `tiempo_base_dias` int(11) DEFAULT NULL,
  `descripcion` varchar(250) NOT NULL,
  `rendimiento_promedio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_semilla`
--

INSERT INTO `tipo_semilla` (`id_semilla`, `id_empresa`, `id_catalogo`, `nombre_semilla`, `tiempo_base_dias`, `descripcion`, `rendimiento_promedio`) VALUES
(3, '988091212', 1, 'Tomate Chonto', 90, 'Variedad de tomate muy resistente, ideal para salsas.', 12.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_suelo`
--

CREATE TABLE `tipo_suelo` (
  `id_tipo_suelo` int(11) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_suelo`
--

INSERT INTO `tipo_suelo` (`id_tipo_suelo`, `id_empresa`, `id_catalogo`, `nombre`, `impacto_dias`) VALUES
(1, '988091212', 1, 'Arcilloso', 5),
(2, '834324234', 2, 'Arenoso', -3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `tipo_usuario`) VALUES
(1, 'administrador'),
(2, 'supervisor'),
(3, 'trabajador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `documento` int(11) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `id_tipo_usuario` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_empresa` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`documento`, `imagen`, `nombre`, `telefono`, `correo`, `contrasena`, `remember_token`, `id_tipo_usuario`, `id_estado`, `id_empresa`) VALUES
(1006511653, 'usuarios/TPn5OuzBFcUMBMTb27MDcG8KrMQg0nUiQau4ExxO.png', 'Sebas Alvarez', '3103524334', 'sombrahdepaz76@gmail.com', '$2y$12$ShO2KxmULq2i87gGWluCyeAy/C5fhUJt26ceeK7Nt/BKxRxQl/DRa', '', 1, 3, '103455657789'),
(1034345454, 'usuarios/ohtjEMXYnEtIKQV6uXFyhSx4giqPArWo1ABQmYEk.jpg', 'Javier Gonza', '3223243434', 'bastobrayan246@gmail.com', '$2y$12$IXfjWMnY6Ul6L6B0trEKK.6obRkullnh7zI5H/sAO3/nHgpsQWjqq', '', 1, 3, '876767657'),
(1104921223, 'usuarios/fxyI259nxaEdNx9meFLTLFkpNIRGXnj7nyy2Z8PX.png', 'julio profe', '3291231212', 'reyesz2803@gmail.com', '$2y$12$NcwOItyOjXK4jwD7js4ri.mghmiFTcxGEzjyPNbzJGOZ6lWJQ7Eou', 'L6ur0l8cTbySu6UszUtmUcokC1ulEVdseHMeNZvK2xhwpe4Ay1X84lfEgOHl', 1, 3, '834324234'),
(1110722331, 'usuarios/useOl4EMIIlIsP0f8X6vMaoWPIjhX5Ml9tCDJ2bC.jpg', 'Didier', '3103527239', 'johsn@gmail.com', '$2y$12$vxkHUv.QeZAo9aWiUSLcNuVRnX.siC2vPlL8S1QY6vt6m6WTme7vK', '', 3, 1, '834324234'),
(1110722345, 'usuarios/IEJRgrLlnPGGxJcaD5NFbzOnxj7DAVNxZXnoZjTr.jpg', 'Brayan Gutierez', '3029219231', 'sombrahdepaz@gmail.com', '$2y$12$ElMqaOG0Q30Gbt8q2RwPDudpzZPaIlhmEoA4Ldj0WQ6cW6zhcGAiK', 'ywIaTxfUUQbD4ST6rgeRbqS0R6ogTOcag8MDnlWwZYrJ2IRaPhpqCZgszcPy', 1, 3, '988091212');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_licencias`
--

CREATE TABLE `venta_licencias` (
  `id_key` varchar(14) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `observacione` text NOT NULL,
  `id_tipo_licencia` int(11) NOT NULL,
  `id_empresa` varchar(14) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta_licencias`
--

INSERT INTO `venta_licencias` (`id_key`, `fecha_inicio`, `observacione`, `id_tipo_licencia`, `id_empresa`, `id_estado`) VALUES
('9uTJGg3T0RG8l8', '2026-03-06 12:41:27', 'Asignada desde Dashboard', 2, '988091212', 3),
('CHscjT93rnsFdj', '2026-03-01 20:04:57', 'Asignada desde Dashboard', 2, '876767657', 3),
('DNPSVVPFfsJOUx', '2026-02-25 23:22:48', 'Asignada desde Dashboard', 2, '103455657789', 3),
('GTJ8xgFGPHkNZn', '2026-02-25 23:27:54', 'Asignada desde Dashboard', 1, '411234141412', 3),
('Q3zZJYBvH2PISC', '2026-03-01 20:29:45', 'Asignada desde Dashboard', 3, '834324234', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `catalogo_riegos`
--
ALTER TABLE `catalogo_riegos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catalogo_semillas`
--
ALTER TABLE `catalogo_semillas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catalogo_suelos`
--
ALTER TABLE `catalogo_suelos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cosecha`
--
ALTER TABLE `cosecha`
  ADD PRIMARY KEY (`id_cosecha`),
  ADD KEY `cosecha_terreno_fk` (`id_terreno`),
  ADD KEY `cosecha_semilla_fk` (`id_semilla`),
  ADD KEY `cosecha_estado_fk` (`id_estado`);

--
-- Indices de la tabla `cultivo`
--
ALTER TABLE `cultivo`
  ADD PRIMARY KEY (`id_cultivo`),
  ADD KEY `id_cosecha` (`id_cosecha`),
  ADD KEY `id_trabajador` (`documento`);

--
-- Indices de la tabla `detalle_cultivo`
--
ALTER TABLE `detalle_cultivo`
  ADD PRIMARY KEY (`id_detalle_cultivo`),
  ADD KEY `id_cultivo` (`id_cultivo`),
  ADD KEY `id_insumo` (`id_insumo`);

--
-- Indices de la tabla `detalle_fases_programadas`
--
ALTER TABLE `detalle_fases_programadas`
  ADD PRIMARY KEY (`id_detalle_fases`),
  ADD KEY `id_insumo` (`id_insumo`),
  ADD KEY `id_riego` (`id_riego`),
  ADD KEY `id_cosecha` (`id_cosecha`),
  ADD KEY `id_fase` (`id_fase`);

--
-- Indices de la tabla `detalle_producto_cultivo`
--
ALTER TABLE `detalle_producto_cultivo`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_cultivo` (`id_cultivo`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `fases_programadas`
--
ALTER TABLE `fases_programadas`
  ADD PRIMARY KEY (`id_fase`),
  ADD KEY `id_usuario` (`documento`),
  ADD KEY `id_cosecha` (`id_cosecha`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`ID_insumo`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `insumo_cosecha`
--
ALTER TABLE `insumo_cosecha`
  ADD PRIMARY KEY (`id_insumo_cosecha`),
  ADD KEY `fk_insumo_cosecha_c` (`id_cosecha`),
  ADD KEY `fk_insumo_cosecha_i` (`id_insumo`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `ID_insumo` (`ID_insumo`);

--
-- Indices de la tabla `riego`
--
ALTER TABLE `riego`
  ADD PRIMARY KEY (`id_riego`),
  ADD KEY `id_tipo_riego` (`id_tipo_riego`),
  ADD KEY `fk_riego_cosecha` (`id_cosecha`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `solicitud_compra`
--
ALTER TABLE `solicitud_compra`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `fk_solicitud_estado` (`id_estado`),
  ADD KEY `solicitud_compra_id_tipo_licencia_foreign` (`id_tipo_licencia`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id_super_admin`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `terreno`
--
ALTER TABLE `terreno`
  ADD PRIMARY KEY (`id_terreno`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `terreno_tipo_suelo_fk` (`id_tipo_suelo`);

--
-- Indices de la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  ADD PRIMARY KEY (`id_tipo_licencia`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  ADD PRIMARY KEY (`id_tipo_riego`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  ADD PRIMARY KEY (`id_semilla`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tipo_suelo`
--
ALTER TABLE `tipo_suelo`
  ADD PRIMARY KEY (`id_tipo_suelo`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `id_tipo_usuario` (`id_tipo_usuario`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `venta_licencias`
--
ALTER TABLE `venta_licencias`
  ADD PRIMARY KEY (`id_key`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_tipo_licencia` (`id_tipo_licencia`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo_riegos`
--
ALTER TABLE `catalogo_riegos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `catalogo_semillas`
--
ALTER TABLE `catalogo_semillas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `catalogo_suelos`
--
ALTER TABLE `catalogo_suelos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cosecha`
--
ALTER TABLE `cosecha`
  MODIFY `id_cosecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cultivo`
--
ALTER TABLE `cultivo`
  MODIFY `id_cultivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_cultivo`
--
ALTER TABLE `detalle_cultivo`
  MODIFY `id_detalle_cultivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_fases_programadas`
--
ALTER TABLE `detalle_fases_programadas`
  MODIFY `id_detalle_fases` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_producto_cultivo`
--
ALTER TABLE `detalle_producto_cultivo`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fases_programadas`
--
ALTER TABLE `fases_programadas`
  MODIFY `id_fase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `ID_insumo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `insumo_cosecha`
--
ALTER TABLE `insumo_cosecha`
  MODIFY `id_insumo_cosecha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `riego`
--
ALTER TABLE `riego`
  MODIFY `id_riego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitud_compra`
--
ALTER TABLE `solicitud_compra`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id_super_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1110495790;

--
-- AUTO_INCREMENT de la tabla `terreno`
--
ALTER TABLE `terreno`
  MODIFY `id_terreno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  MODIFY `id_tipo_licencia` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  MODIFY `id_tipo_riego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  MODIFY `id_semilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_suelo`
--
ALTER TABLE `tipo_suelo`
  MODIFY `id_tipo_suelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cosecha`
--
ALTER TABLE `cosecha`
  ADD CONSTRAINT `cosecha_estado_fk` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `cosecha_semilla_fk` FOREIGN KEY (`id_semilla`) REFERENCES `tipo_semilla` (`id_semilla`),
  ADD CONSTRAINT `cosecha_terreno_fk` FOREIGN KEY (`id_terreno`) REFERENCES `terreno` (`id_terreno`);

--
-- Filtros para la tabla `cultivo`
--
ALTER TABLE `cultivo`
  ADD CONSTRAINT `cultivo_ibfk_2` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `cultivo_ibfk_3` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `detalle_cultivo`
--
ALTER TABLE `detalle_cultivo`
  ADD CONSTRAINT `detalle_cultivo_ibfk_1` FOREIGN KEY (`id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  ADD CONSTRAINT `detalle_cultivo_ibfk_2` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`);

--
-- Filtros para la tabla `detalle_fases_programadas`
--
ALTER TABLE `detalle_fases_programadas`
  ADD CONSTRAINT `detalle_fases_programadas_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`),
  ADD CONSTRAINT `detalle_fases_programadas_ibfk_2` FOREIGN KEY (`id_riego`) REFERENCES `riego` (`id_riego`),
  ADD CONSTRAINT `detalle_fases_programadas_ibfk_3` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `detalle_fases_programadas_ibfk_4` FOREIGN KEY (`id_fase`) REFERENCES `fases_programadas` (`id_fase`);

--
-- Filtros para la tabla `detalle_producto_cultivo`
--
ALTER TABLE `detalle_producto_cultivo`
  ADD CONSTRAINT `detalle_producto_cultivo_ibfk_1` FOREIGN KEY (`id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  ADD CONSTRAINT `detalle_producto_cultivo_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `fases_programadas`
--
ALTER TABLE `fases_programadas`
  ADD CONSTRAINT `fases_programadas_ibfk_2` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `fases_programadas_ibfk_3` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD CONSTRAINT `insumo_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `insumo_cosecha`
--
ALTER TABLE `insumo_cosecha`
  ADD CONSTRAINT `fk_insumo_cosecha_c` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `fk_insumo_cosecha_i` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`ID_insumo`) REFERENCES `insumo` (`ID_insumo`);

--
-- Filtros para la tabla `riego`
--
ALTER TABLE `riego`
  ADD CONSTRAINT `fk_riego_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `riego_ibfk_1` FOREIGN KEY (`id_tipo_riego`) REFERENCES `tipo_riego` (`id_tipo_riego`);

--
-- Filtros para la tabla `solicitud_compra`
--
ALTER TABLE `solicitud_compra`
  ADD CONSTRAINT `fk_solicitud_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `solicitud_compra_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `solicitud_compra_id_tipo_licencia_foreign` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`) ON DELETE SET NULL;

--
-- Filtros para la tabla `super_admin`
--
ALTER TABLE `super_admin`
  ADD CONSTRAINT `super_admin_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `terreno`
--
ALTER TABLE `terreno`
  ADD CONSTRAINT `terreno_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `terreno_tipo_suelo_fk` FOREIGN KEY (`id_tipo_suelo`) REFERENCES `tipo_suelo` (`id_tipo_suelo`);

--
-- Filtros para la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  ADD CONSTRAINT `tipo_licencia_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  ADD CONSTRAINT `tipo_riego_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  ADD CONSTRAINT `tipo_semilla_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tipo_suelo`
--
ALTER TABLE `tipo_suelo`
  ADD CONSTRAINT `tipo_suelo_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `venta_licencias`
--
ALTER TABLE `venta_licencias`
  ADD CONSTRAINT `venta_licencias_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `venta_licencias_ibfk_3` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`),
  ADD CONSTRAINT `venta_licencias_ibfk_4` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
