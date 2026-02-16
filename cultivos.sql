-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-02-2026 a las 17:08:18
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
-- Base de datos: `cultivos`
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

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-password_reset_code_bastobrayan246@gmail.com', 'i:342369;', 1771258013),
('laravel-cache-password_reset_code_reyesz2803@gmail.com', 'i:728743;', 1770953137);

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
-- Estructura de tabla para la tabla `cosecha`
--

CREATE TABLE `cosecha` (
  `id_cosecha` int(11) NOT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cultivo`
--

CREATE TABLE `cultivo` (
  `id_cultivo` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_terreno` int(11) DEFAULT NULL,
  `id_trabajador` int(11) NOT NULL
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
-- Estructura de tabla para la tabla `detalle_producto_cosecha`
--

CREATE TABLE `detalle_producto_cosecha` (
  `id_detalle` int(11) NOT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `calidad` varchar(50) DEFAULT NULL,
  `fecha_cosecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` varchar(14) NOT NULL,
  `nombre_empresa` varchar(200) NOT NULL,
  `nombre_repre_legal` varchar(100) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nombre_empresa`, `nombre_repre_legal`, `telefono`, `correo`, `direccion`, `fecha_creacion`, `id_estado`) VALUES
('8600050669', 'Finca La Florida', 'Dairo Moreno', '3103527239', 'dairo003@gmail.com', 'MzN Casa 1 Villa_cindy', '2026-02-11', 3);

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
(5, 'visto');

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
  `id_usuario` int(11) DEFAULT NULL,
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
  `Fecha_ingreso` date DEFAULT NULL,
  `Fecha_vencimiento` date DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
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
(6, '2026_02_11_192642_add_foreign_key_to_solicitud_compra_table', 3);

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
  `id_tipo_riego` int(11) DEFAULT NULL
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
('AmAS6xkv1WsCgdRzBgl9W1yYMkrIc8CGFyFkzP9w', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3podHlhdW1HQkJ1a2VGMlpPeWgyMW5lZVdWMXdzYzJkWU1MT0U0YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1771257551),
('pivUslQ1yWfIhZbltIQf3R0R1PKylTqQ1T47gw9m', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibENBQVNxSkVaOWFDVkxnZWlkWk1HMDVxNlQwa0lLcEpMTEhhQ1VpQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1771258000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_compra`
--

CREATE TABLE `solicitud_compra` (
  `id_solicitud` int(11) NOT NULL,
  `nit_empresa` varchar(20) NOT NULL,
  `nombre_empresa` varchar(200) NOT NULL,
  `nombre_repre_legal` varchar(150) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `comprobante_pago` varchar(500) NOT NULL,
  `id_super_admin` int(11) NOT NULL,
  `id_tipo_licencia` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `fecha_revision` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_compra`
--

INSERT INTO `solicitud_compra` (`id_solicitud`, `nit_empresa`, `nombre_empresa`, `nombre_repre_legal`, `telefono`, `correo`, `direccion`, `comprobante_pago`, `id_super_admin`, `id_tipo_licencia`, `id_estado`, `fecha_solicitud`, `fecha_revision`) VALUES
(3, '24234235', 'SENA', 'Jose Luis Rodriguez', '3204526843', 'samueltxl201@gmail.com', 'carrera 11a sur #15-48 e 12-4', 'comprobantes/1770838133.png', 1006511657, 2, 1, '2026-02-11 19:28:53', NULL);

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
(1006511657, 'Brayan', 'Stevan', 'bastobrayan246@gmail.com', '$2y$12$Qh0yFs6SfldIhbRSw2gfguC8OukaAtB1KnOBga5XY/dKXi.2070X.', 3, NULL, '2026-02-10 03:51:59', '2026-02-16 15:55:49', 'aegJSp6QIMpg95egR7NJXAnaE5njCRkax1I5ss63F6MT9YHZs4Q3cINlIMw9', NULL, '2026-02-13 02:07:57'),
(1110495789, 'Didier Reyes', 'dires123', 'didierreyes003@gmail.com', '$2y$12$wmB4kxXaFlmdPaBoh2udXuqkB1L6iPFzrISuCIEoVOLOlTOEgO8wa', 3, NULL, '2026-02-09 19:43:33', '2026-02-16 16:04:46', '75wAEHbAZ2DHmlMOPncWAw4MeYBfUL4VkgWvMX1jeqWD4KhPDeLZLrSxi1gG', NULL, '2026-02-16 21:04:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terreno`
--

CREATE TABLE `terreno` (
  `id_terreno` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `Ancho` decimal(10,0) NOT NULL,
  `Alto` decimal(10,0) NOT NULL,
  `id_estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cosecha`
--

CREATE TABLE `tipo_cosecha` (
  `id_tipo_cosecha` int(11) NOT NULL,
  `tiempo` int(11) DEFAULT NULL,
  `terreno` varchar(100) DEFAULT NULL,
  `id_semilla` int(11) DEFAULT NULL,
  `id_riego` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `tipo_licencias`
--

CREATE TABLE `tipo_licencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_riego`
--

CREATE TABLE `tipo_riego` (
  `id_tipo_riego` int(11) NOT NULL,
  `tipo_riego` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_semilla`
--

CREATE TABLE `tipo_semilla` (
  `id_semilla` int(11) NOT NULL,
  `Tipo_semilla` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `trabajador`
--

CREATE TABLE `trabajador` (
  `id_trabajador` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `pin` int(8) NOT NULL,
  `trabajo_realizado` text NOT NULL,
  `sueldo` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `id_tipo_usuario` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_empresa` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`documento`, `imagen`, `nombre`, `telefono`, `correo`, `contrasena`, `id_tipo_usuario`, `id_estado`, `id_empresa`) VALUES
(43211222, 'usuarios/bSbGFNQXLSvkTZAd0arvomtqqIbMSZhXZwP4No2S.png', 'Edinson Cavani', '3102102122', 'edinson03@gmail.com', '$2y$12$Drb3yPwds9eZ.DQsxhRtFeKtDfTlbOsl4ZoXyOTB2gpnih.E57FoG', 1, 3, '8600050669');

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
('nxRnZ1rZV4kzhL', '2026-02-11 15:23:37', 'Asignada desde Dashboard', 2, '8600050669', 3);

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
-- Indices de la tabla `cosecha`
--
ALTER TABLE `cosecha`
  ADD PRIMARY KEY (`id_cosecha`);

--
-- Indices de la tabla `cultivo`
--
ALTER TABLE `cultivo`
  ADD PRIMARY KEY (`id_cultivo`),
  ADD KEY `id_terreno` (`id_terreno`),
  ADD KEY `id_cosecha` (`id_cosecha`),
  ADD KEY `id_trabajador` (`id_trabajador`);

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
-- Indices de la tabla `detalle_producto_cosecha`
--
ALTER TABLE `detalle_producto_cosecha`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_cosecha` (`id_cosecha`),
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
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cosecha` (`id_cosecha`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`ID_insumo`);

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
  ADD KEY `id_tipo_riego` (`id_tipo_riego`);

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
  ADD KEY `fk_solicitud_superadmin` (`id_super_admin`),
  ADD KEY `fk_solicitud_estado` (`id_estado`),
  ADD KEY `solicitud_compra_id_tipo_licencia_foreign` (`id_tipo_licencia`);

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
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `tipo_cosecha`
--
ALTER TABLE `tipo_cosecha`
  ADD PRIMARY KEY (`id_tipo_cosecha`),
  ADD KEY `id_semilla` (`id_semilla`),
  ADD KEY `id_riego` (`id_riego`);

--
-- Indices de la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  ADD PRIMARY KEY (`id_tipo_licencia`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `tipo_licencias`
--
ALTER TABLE `tipo_licencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  ADD PRIMARY KEY (`id_tipo_riego`);

--
-- Indices de la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  ADD PRIMARY KEY (`id_semilla`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD PRIMARY KEY (`id_trabajador`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
-- AUTO_INCREMENT de la tabla `cosecha`
--
ALTER TABLE `cosecha`
  MODIFY `id_cosecha` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `detalle_producto_cosecha`
--
ALTER TABLE `detalle_producto_cosecha`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fases_programadas`
--
ALTER TABLE `fases_programadas`
  MODIFY `id_fase` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `ID_insumo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id_riego` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_compra`
--
ALTER TABLE `solicitud_compra`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id_super_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1110495790;

--
-- AUTO_INCREMENT de la tabla `terreno`
--
ALTER TABLE `terreno`
  MODIFY `id_terreno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_cosecha`
--
ALTER TABLE `tipo_cosecha`
  MODIFY `id_tipo_cosecha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  MODIFY `id_tipo_licencia` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_licencias`
--
ALTER TABLE `tipo_licencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  MODIFY `id_tipo_riego` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  MODIFY `id_semilla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cultivo`
--
ALTER TABLE `cultivo`
  ADD CONSTRAINT `cultivo_ibfk_1` FOREIGN KEY (`id_terreno`) REFERENCES `terreno` (`id_terreno`),
  ADD CONSTRAINT `cultivo_ibfk_2` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `cultivo_ibfk_3` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajador` (`id_trabajador`);

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
-- Filtros para la tabla `detalle_producto_cosecha`
--
ALTER TABLE `detalle_producto_cosecha`
  ADD CONSTRAINT `detalle_producto_cosecha_ibfk_1` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `detalle_producto_cosecha_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `fases_programadas`
--
ALTER TABLE `fases_programadas`
  ADD CONSTRAINT `fases_programadas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`documento`),
  ADD CONSTRAINT `fases_programadas_ibfk_2` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`ID_insumo`) REFERENCES `insumo` (`ID_insumo`);

--
-- Filtros para la tabla `riego`
--
ALTER TABLE `riego`
  ADD CONSTRAINT `riego_ibfk_1` FOREIGN KEY (`id_tipo_riego`) REFERENCES `tipo_riego` (`id_tipo_riego`);

--
-- Filtros para la tabla `solicitud_compra`
--
ALTER TABLE `solicitud_compra`
  ADD CONSTRAINT `fk_solicitud_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_solicitud_superadmin` FOREIGN KEY (`id_super_admin`) REFERENCES `super_admin` (`id_super_admin`),
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
  ADD CONSTRAINT `terreno_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `tipo_cosecha`
--
ALTER TABLE `tipo_cosecha`
  ADD CONSTRAINT `tipo_cosecha_ibfk_1` FOREIGN KEY (`id_semilla`) REFERENCES `tipo_semilla` (`id_semilla`),
  ADD CONSTRAINT `tipo_cosecha_ibfk_2` FOREIGN KEY (`id_riego`) REFERENCES `riego` (`id_riego`);

--
-- Filtros para la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  ADD CONSTRAINT `tipo_licencia_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

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
