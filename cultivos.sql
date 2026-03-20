-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2026 a las 22:59:25
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
-- Estructura de tabla para la tabla `catalogo_insumos`
--

CREATE TABLE `catalogo_insumos` (
  `id_catalogo_insumo` int(11) NOT NULL,
  `nombre_comercial` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `id_tipo_insumo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_insumos`
--

INSERT INTO `catalogo_insumos` (`id_catalogo_insumo`, `nombre_comercial`, `descripcion`, `impacto_dias`, `id_tipo_insumo`) VALUES
(2, 'Fertilizante NPK 15-15-15', 'Fertilizante equilibrado para todo tipo de cultivos', 5, 6),
(3, 'Urea Agrícola 46%', 'Fuente concentrada de nitrógeno', 3, 6),
(4, 'Pala Punta Huevo', 'Herramienta resistente para trabajo de campo', 0, 8),
(5, 'Machete 22 Pulgadas', 'Acero al carbono, ideal para desmonte', 0, 8),
(6, 'Aceite Motor Diesel 15W40', 'Lubricante para tractores y maquinaria pesada', 0, 9);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `espacio_por_planta_m2` decimal(10,4) NOT NULL DEFAULT 0.2500
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `catalogo_semillas`
--

INSERT INTO `catalogo_semillas` (`id`, `nombre`, `descripcion`, `tiempo_base_dias`, `rendimiento_promedio`, `created_at`, `updated_at`, `espacio_por_planta_m2`) VALUES
(1, 'Tomate Chonto', 'Variedad de tomate muy resistente, ideal para salsas.', 90, 12.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(2, 'Café Arábigo', 'Variedad premium de café con aroma intenso y acidez equilibrada.', 210, 1.50, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(3, 'Maíz Amarillo', 'Cereal básico para la alimentación, ciclo corto.', 120, 3.50, NULL, NULL, 0.2500),
(4, 'Papa Pastusa', 'Variedad de papa de textura harinosa, muy popular en Colombia.', 135, 25.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(5, 'Cacao', 'Cultivo de clima cálido, base para el chocolate.', 180, 0.80, NULL, NULL, 0.2500),
(6, 'Arroz', 'Cereal de inundación o secano, base de la dieta.', 130, 6.00, NULL, NULL, 0.2500),
(7, 'Maíz Dulce', 'Maíz de grano tierno y dulce, ideal para consumo humano directo.', 85, 4.50, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(8, 'Cebolla Cabezona', 'Bulbo de sabor fuerte, uso esencial en cocina.', 120, 15.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(9, 'Papa Criolla', 'Papa pequeña y amarilla, ciclo corto y sabor suave.', 110, 10.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(10, 'Zanahoria', 'Raíz naranja rica en carotenos, ciclo productivo estándar.', 110, 20.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(11, 'Fresa', 'Fruta roja pequeña, requiere suelos ácidos y buen riego.', 150, 0.80, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(12, 'Cacao Forastero', 'Variedad de cacao muy productiva y resistente.', 165, 1.20, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(13, 'Plátano Hartón', 'Plátano de gran tamaño usado principalmente para cocinar.', 360, 14.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(14, 'Aguacate Hass', 'Variedad de aguacate con piel rugosa y alto contenido de aceite.', 240, 8.00, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500),
(15, 'Fríjol Cargamanto', 'Leguminosa de grano grande, muy apreciada en la región andina.', 140, 2.20, '2026-03-07 19:26:40', '2026-03-07 19:27:51', 0.2500);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `capacidad_retencion_litros_m2` decimal(10,2) NOT NULL DEFAULT 5.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `catalogo_suelos`
--

INSERT INTO `catalogo_suelos` (`id`, `nombre`, `impacto_dias`, `descripcion`, `created_at`, `updated_at`, `capacidad_retencion_litros_m2`) VALUES
(1, 'Arcilloso', 5, 'Suelo pesado con alta retención de humedad, pero drenaje lento.', NULL, '2026-03-07 19:27:51', 5.00),
(2, 'Arenoso', -3, 'Drenaje rápido, requiere riego frecuente, acelera ciclo en algunos cultivos.', NULL, '2026-03-07 19:27:51', 5.00),
(3, 'Franco-Arenoso', 0, NULL, NULL, NULL, 5.00),
(4, 'Limoso', 0, 'Suelo fértil con buena retención de nutrientes y humedad equilibrada.', NULL, '2026-03-07 19:27:51', 5.00),
(5, 'Orgánico (Húmico)', -10, NULL, NULL, NULL, 5.00),
(6, 'Franco', -1, 'Mezcla ideal de arena, limo y arcilla para la mayoría de cultivos.', '2026-03-07 19:27:51', '2026-03-07 19:27:51', 5.00),
(7, 'Salino', 10, 'Alta concentración de sales que retrasa el crecimiento vegetal.', '2026-03-07 19:27:51', '2026-03-07 19:27:51', 5.00),
(8, 'Turba / Orgánico', -2, 'Extremadamente fértil y rico en materia orgánica.', '2026-03-07 19:27:51', '2026-03-07 19:27:51', 5.00);

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
  `frecuencia_riego_dias` int(11) DEFAULT NULL,
  `fecha_estimada` date DEFAULT NULL,
  `imagenes` varchar(255) NOT NULL,
  `produccion_estimada` decimal(10,2) DEFAULT NULL,
  `litros_por_riego` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cosecha`
--

INSERT INTO `cosecha` (`id_cosecha`, `id_empresa`, `Cantidad`, `id_terreno`, `id_semilla`, `id_estado`, `fecha_siembra`, `frecuencia_riego_dias`, `fecha_estimada`, `imagenes`, `produccion_estimada`, `litros_por_riego`) VALUES
(22, '988091212', 50, 8, 3, 1, '2026-03-17', 1, '2026-06-19', 'cosechas/yT1SnFb6U20J6ZroWINQnQXFcBjdSil9uQUw3Wjz.jpg', 600.00, 2.00),
(23, '988091212', 250, 11, 4, 1, '2026-03-20', 2, '2026-07-23', 'cosechas/zx7sZfGEn2EtGJ766ge44kqstCAzEy3noa57jIdX.jpg', 875.00, 50.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cultivo`
--

CREATE TABLE `cultivo` (
  `id_cultivo` int(11) NOT NULL,
  `fecha_recoleccion` date DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `observaciones` text DEFAULT NULL
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
('899765544', 'Sena Soft', 'Luiz Gomez', 1110432123, '3153524586', 'luisgomez@gmial.com', 'Vereda Purificación', '2026-03-20 15:17:10', 1),
('988091212', 'IBague medio', 'johan oeres', 1110495788, '3103527239', 'johsn@gmail.com', 'MzN Casa# 1 Picaleña', '2026-03-06 12:40:27', 3),
('989979777', 'Pereira Sas', 'Julio Profe', 32092123, '3021212212', 'Julio@gmail.com', 'vereda cipqui', '2026-03-03 13:41:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_insumo`
--

CREATE TABLE `entrada_insumo` (
  `id_entrada` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `id_semilla` int(11) DEFAULT NULL,
  `id_empresa` varchar(14) NOT NULL,
  `stock_antes` decimal(10,2) DEFAULT NULL,
  `stock_despues` decimal(10,2) DEFAULT NULL,
  `tipo_movimiento` varchar(20) DEFAULT NULL,
  `cantidad_recibida` decimal(10,2) NOT NULL,
  `fecha_entrada` timestamp NOT NULL DEFAULT current_timestamp(),
  `precio_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrada_insumo`
--

INSERT INTO `entrada_insumo` (`id_entrada`, `id_proveedor`, `id_insumo`, `id_semilla`, `id_empresa`, `stock_antes`, `stock_despues`, `tipo_movimiento`, `cantidad_recibida`, `fecha_entrada`, `precio_unitario`) VALUES
(1, 1, 2, NULL, '834324234', NULL, NULL, NULL, 10.00, '2026-03-10 22:13:45', 400000.00),
(2, 1, NULL, 5, '834324234', NULL, NULL, NULL, 14.00, '2026-03-10 22:15:41', 14000.00),
(3, 1, NULL, 5, '834324234', 0.00, 20.00, 'ENTRADA', 20.00, '2026-03-15 16:58:46', 10000.00),
(4, 1, NULL, 7, '834324234', 0.00, 50.00, 'ENTRADA', 50.00, '2026-03-17 14:15:56', 25000.00),
(5, 3, NULL, 3, '988091212', 5.00, 1005.00, 'ENTRADA', 1000.00, '2026-03-17 18:25:11', 2000.00),
(6, 3, NULL, 4, '988091212', 0.00, 300.00, 'ENTRADA', 300.00, '2026-03-20 19:40:11', 1000.00),
(7, 3, NULL, 4, '988091212', 50.00, 200.00, 'ENTRADA', 150.00, '2026-03-20 21:30:17', 3000.00);

--
-- Disparadores `entrada_insumo`
--
DELIMITER $$
CREATE TRIGGER `trg_entrada_insumo` BEFORE INSERT ON `entrada_insumo` FOR EACH ROW BEGIN
    DECLARE stock_anterior DECIMAL(10,2);

    IF NEW.id_insumo IS NOT NULL THEN
        
        SELECT stock_actual 
        INTO stock_anterior
        FROM insumo
        WHERE id_insumo = NEW.id_insumo;

        SET NEW.stock_antes = stock_anterior;
        SET NEW.stock_despues = stock_anterior + NEW.cantidad_recibida;
        SET NEW.tipo_movimiento = 'ENTRADA';

        UPDATE insumo
        SET stock_actual = stock_anterior + NEW.cantidad_recibida
        WHERE id_insumo = NEW.id_insumo;

    ELSEIF NEW.id_semilla IS NOT NULL THEN
        
        SELECT stock_actual 
        INTO stock_anterior
        FROM tipo_semilla
        WHERE id_semilla = NEW.id_semilla;

        SET NEW.stock_antes = stock_anterior;
        SET NEW.stock_despues = stock_anterior + NEW.cantidad_recibida;
        SET NEW.tipo_movimiento = 'ENTRADA';

        UPDATE tipo_semilla
        SET stock_actual = stock_anterior + NEW.cantidad_recibida
        WHERE id_semilla = NEW.id_semilla;

    END IF;

END
$$
DELIMITER ;

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
(7, 'disponible'),
(8, 'suspendido'),
(10, 'Siembra'),
(11, 'Vegetativo'),
(12, 'Floración'),
(13, 'Llenado'),
(14, 'Cosecha'),
(15, 'Realizado'),
(16, 'Perdida'),
(17, 'En Proceso'),
(18, 'Perdida Oculta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_trabajador`
--

CREATE TABLE `estado_trabajador` (
  `id_estado_trabajador` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_trabajador`
--

INSERT INTO `estado_trabajador` (`id_estado_trabajador`, `nombre_estado`) VALUES
(1, 'Disponible'),
(2, 'Ocupado'),
(3, 'En Proceso'),
(4, 'Fuera de Servicio');

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
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `evidencia_foto` varchar(255) DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `ID_insumo` int(11) NOT NULL,
  `id_empresa` varchar(20) DEFAULT NULL,
  `id_catalogo_insumo` int(11) DEFAULT NULL,
  `stock_actual` decimal(10,2) DEFAULT 0.00,
  `Nombre` varchar(100) DEFAULT NULL,
  `Fecha_vencimiento` date DEFAULT NULL,
  `descripcion` text NOT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `id_proveedor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`ID_insumo`, `id_empresa`, `id_catalogo_insumo`, `stock_actual`, `Nombre`, `Fecha_vencimiento`, `descripcion`, `impacto_dias`, `id_proveedor`, `created_at`, `updated_at`) VALUES
(2, '834324234', 3, 0.00, 'Urea Agrícola 46%', NULL, 'Fuente concentrada de nitrógeno', 0, NULL, NULL, NULL),
(5, '834324234', NULL, 0.00, 'dfdfg', NULL, 'ghffjhjh', 0, NULL, NULL, NULL),
(6, '988091212', NULL, 0.00, 'Fertilizante por 4k', NULL, 'Super mega fertilizante', 2, NULL, NULL, NULL),
(7, '834324234', NULL, 0.00, 'sad', NULL, 'dsa', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo_cosecha`
--

CREATE TABLE `insumo_cosecha` (
  `id_insumo_cosecha` int(11) NOT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `evidencia_foto` varchar(255) DEFAULT NULL,
  `cantidad_usada` decimal(10,2) DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `fecha_programada` date DEFAULT NULL,
  `fecha_realizacion` date DEFAULT NULL
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
(20, '2026_03_07_000004_add_description_to_soil_catalog', 11),
(21, '2026_03_07_000005_add_formal_foreign_keys_to_catalogs', 12),
(22, '2026_03_10_145541_add_id_empresa_to_insumo_table', 13),
(23, '2026_03_09_000001_add_descripcion_to_tipo_suelo', 14),
(24, '2026_03_12_162911_add_hydration_fields_to_tables', 15),
(25, '2026_03_15_120413_insert_estados_fases_cosecha', 16),
(26, '2026_03_16_145658_add_evidencia_foto_to_fases_programadas_table', 17),
(27, '2026_03_16_145708_add_evidencia_foto_to_riego_table', 17),
(28, '2026_03_16_145712_add_evidencia_foto_to_insumos_cosechas_table', 17),
(29, '2026_03_17_000001_insert_en_proceso_estado', 17);

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
  `contacto` varchar(50) DEFAULT NULL,
  `ID_insumo` int(11) DEFAULT NULL,
  `id_empresa` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `producto`, `contacto`, `ID_insumo`, `id_empresa`) VALUES
(1, 'Juan ortiz', 'Fertilizante', '3103527239', NULL, '834324234'),
(2, 'Agro Ferti', 'Fetilizantes', '3201123122', NULL, '988091212'),
(3, 'Agro Semi', 'Semillas', '312121212', NULL, '988091212');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_trabajo`
--

CREATE TABLE `registro_trabajo` (
  `id_registro_trabajo` int(11) NOT NULL,
  `id_insumo_cosecha` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `fecha_trabajada` date NOT NULL,
  `foto_evidencia` varchar(255) DEFAULT NULL,
  `estado_aprobacion` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_trabajo`
--

INSERT INTO `registro_trabajo` (`id_registro_trabajo`, `id_insumo_cosecha`, `documento_trabajador`, `fecha_trabajada`, `foto_evidencia`, `estado_aprobacion`, `observacion`, `created_at`) VALUES
(16, NULL, 1105461467, '2026-03-19', 'evidencias/Quk6Vto5Dh48UZUvqvnHq7P9XlO1XbTyPora7Juu.png', 'pendiente', 'trabajo', '2026-03-12 01:34:36'),
(17, NULL, 1105461467, '2026-03-13', 'evidencias/UoEiLyHQl9hj3oFtzxLr1nJdyA83AugvK2Oryja7.png', 'pendiente', '9poikjuhygtrf', '2026-03-12 19:08:34'),
(18, NULL, 1039253243, '2026-03-17', 'evidencias/ur4ABrNWTSkMZiqXeb8LizM4n4LKdfhWx9VcpbG2.jpg', 'pendiente', 'Realice el riego no jodan mas y paguen ya', '2026-03-17 18:30:41'),
(19, NULL, 1039253243, '2026-03-19', NULL, 'pendiente', 'Tarea perdida ocultada por el trabajador.', '2026-03-19 20:21:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `riego`
--

CREATE TABLE `riego` (
  `id_riego` int(11) NOT NULL,
  `cant_agua_apl` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `id_tipo_riego` int(11) DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `evidencia_foto` varchar(255) DEFAULT NULL,
  `fecha_programada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `riego`
--

INSERT INTO `riego` (`id_riego`, `cant_agua_apl`, `observaciones`, `id_tipo_riego`, `id_cosecha`, `documento_trabajador`, `id_estado`, `evidencia_foto`, `fecha_programada`) VALUES
(8, '2', 'Aplicar 2L en Parcela Sur al cultivo de Tomate Chonto.', 4, 22, 1039253243, 15, NULL, '2026-03-17 13:26:38'),
(9, '2.00', 'Aplicar 2.00L - Riego programado automáticamente.', 4, 22, 1039253243, 18, NULL, '2026-03-18 14:12:44'),
(10, '2.00', 'Aplicar 2.00L - Riego programado automáticamente.', 4, 22, 1039253243, 16, NULL, '2026-03-19 14:12:44'),
(11, '2.00', 'Aplicar 2.00L - Riego programado automáticamente.', 4, 22, 1039253243, 17, NULL, '2026-03-20 12:58:04'),
(12, '50', 'Aplicar 50L en Parcela Oeste al cultivo de Maíz Amarillo.', 5, 23, 1039253243, 1, NULL, '2026-03-20 14:40:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salario`
--

CREATE TABLE `salario` (
  `id_salario` int(11) NOT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `descripcion_pago` varchar(255) DEFAULT NULL,
  `cantidad_pago` decimal(10,2) NOT NULL,
  `unidad_pago` varchar(50) DEFAULT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `id_tipo_salario` int(11) DEFAULT NULL
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
('fvjZt8AmmdbXT5s747hdag5vHPVypTIJxLAPsSpL', 1104921223, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV3FxSUhjdEgzc2ZHQ1RoMGFhNW5iSlAxb3R6eEVsVk1Nc3Q4ajhPWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTQ6ImxvZ2luX3VzdWFyaW9fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTA0OTIxMjIzO30=', 1774043884),
('pMGcgRVpATPpdHfHm4n9rNe0cQ7xVSDselo8Ky2M', 1110722345, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOW5kRDZ5WDh6RExJRzNoc0J2WnVsQTdxMXdMVzlSV2lZUk8xMFA1QSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90YXJlYXMiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLnRhcmVhcy5pbmRleCI7fXM6NTQ6ImxvZ2luX3VzdWFyaW9fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTEwNzIyMzQ1O30=', 1774042388),
('REKqHFIENvR1WpGHSwteWrDR6X3LHFu2aq5bDkFZ', 1039253243, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3VQdTBVZWM0aFZIRWRrVHU0TzZmVUtnZ0plbmRmZmQ1MWtQbUNuTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTI1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdHJhYmFqYWRvci9jYWxlbmRhcmlvL2V2ZW50b3M/ZW5kPTIwMjYtMDQtMDZUMDAlM0EwMCUzQTAwLTA1JTNBMDAmc3RhcnQ9MjAyNi0wMi0yM1QwMCUzQTAwJTNBMDAtMDUlM0EwMCI7czo1OiJyb3V0ZSI7czoyOToidHJhYmFqYWRvci5jYWxlbmRhcmlvLmV2ZW50b3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU0OiJsb2dpbl91c3VhcmlvXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzOTI1MzI0Mzt9', 1774042840);

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
(28, '988091212', NULL, 2, 5, '2026-03-06 12:40:27', '2026-03-06 12:40:27'),
(29, '899765544', 'comprobantes/1774037830.png', 3, 1, '2026-03-20 15:17:10', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte`
--

CREATE TABLE `soporte` (
  `id_soporte` bigint(20) UNSIGNED NOT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_empresa` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `respuesta` text DEFAULT NULL,
  `estado` varchar(255) DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `soporte`
--

INSERT INTO `soporte` (`id_soporte`, `documento_trabajador`, `id_empresa`, `asunto`, `mensaje`, `respuesta`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1105461467, '834324234', 'pago', 'ijdshfjaslkdjasjk', 'dkjhsajkshdjfjkshad', 'Respondido', '2026-03-13 19:29:09', '2026-03-13 19:30:03');

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
(1006511657, 'Brayan Basto', 'Stevan', 'bastobrayan246@gmail.com', '$2y$12$Qh0yFs6SfldIhbRSw2gfguC8OukaAtB1KnOBga5XY/dKXi.2070X.', 3, NULL, '2026-02-10 03:51:59', '2026-03-20 21:26:35', '7b6hu4a2jpGDooBlFCr2LeiMV6ykWsPcD7azdscbYEqMZBsoRXW9rJkbP8Ou', NULL, '2026-02-13 02:07:57'),
(1110495789, 'Didier Reyes', 'dires123', 'didierreyes003@gmail.com', '$2y$12$clokDFJH4WGM0yZX.78S3OjOSjWUpkLoM/YGC47PorfBCOiE/88vm', 3, NULL, '2026-02-09 19:43:33', '2026-03-20 21:57:24', 'DFrPMzZATvXnH9cII7iP6enLJ3LYHp6ehskQH8JjplQIRXuAqePgpqxawlaw', NULL, '2026-03-03 17:46:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terreno`
--

CREATE TABLE `terreno` (
  `id_terreno` int(11) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `Ancho` decimal(10,0) NOT NULL,
  `Alto` decimal(10,0) NOT NULL,
  `area_m2` decimal(8,2) DEFAULT NULL,
  `departamento` text NOT NULL,
  `ciudad` text NOT NULL,
  `codigo_postal` int(250) NOT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_tipo_suelo` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `terreno`
--

INSERT INTO `terreno` (`id_terreno`, `id_empresa`, `nombre`, `ubicacion`, `latitud`, `longitud`, `Ancho`, `Alto`, `area_m2`, `departamento`, `ciudad`, `codigo_postal`, `id_estado`, `id_tipo_suelo`, `created_at`, `updated_at`) VALUES
(3, '834324234', 'Cascada', 'Cascada del potrero las tribunas', NULL, NULL, 123, 76, NULL, '', '', 0, 7, 2, '2026-03-20 18:34:26', '0000-00-00 00:00:00'),
(6, '834324234', 'sebas', NULL, 7.56072491, -73.06678310, 400, 500, NULL, '', '', 0, 1, 2, '2026-03-20 18:34:26', '0000-00-00 00:00:00'),
(7, '834324234', 'Playa', 'Verda la cima', 4.32039334, -75.37376404, 500, 90, NULL, '', '', 0, 6, 2, '2026-03-20 18:34:26', '0000-00-00 00:00:00'),
(8, '988091212', 'Parcela Sur', 'Verdecito', 4.64751778, -74.69061985, 123, 76, NULL, '', '', 0, 6, 1, '2026-03-20 18:34:26', '0000-00-00 00:00:00'),
(9, '834324234', 'didier', 'kasdjs', 4.43537750, -75.20574426, 567, 3442, NULL, 'Tolima', '', 730002, 7, 3, '2026-03-20 18:34:26', '0000-00-00 00:00:00'),
(10, '988091212', 'Parcela Norte', 'Vereda Via Cajamarca', 4.26935049, -74.79529904, 150, 75, NULL, 'Tolima', 'Flandes', 252432, 7, 1, '2026-03-20 18:34:26', '0000-00-00 00:00:00'),
(11, '988091212', 'Parcela Oeste', 'Vereda San Cristobal', 4.44011019, -75.21533432, 123, 70, NULL, 'Tolima', 'Ibagué', 730002, 6, 1, '2026-03-20 18:56:20', '2026-03-20 19:40:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_insumo`
--

CREATE TABLE `tipo_insumo` (
  `id_tipo_insumo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_insumo`
--

INSERT INTO `tipo_insumo` (`id_tipo_insumo`, `nombre`, `id_empresa`) VALUES
(1, 'Fertilizante', NULL),
(2, 'Abono', NULL),
(3, 'Fungicida', NULL),
(4, 'Herbicida', NULL),
(6, 'Fertilizantes', NULL),
(7, 'Agroquímicos', NULL),
(8, 'Herramientas', NULL),
(9, 'Lubricantes', NULL),
(10, 'Pesticida', '988091212');

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
(4, '988091212', 1, 'Goteo', -3),
(5, '988091212', 2, 'Aspersión', 0),
(6, '834324234', 2, 'Aspersión', 0),
(8, '834324234', NULL, 'ghghgh', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_salario`
--

CREATE TABLE `tipo_salario` (
  `id_tipo_salario` int(11) NOT NULL,
  `tipo_salario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_salario`
--

INSERT INTO `tipo_salario` (`id_tipo_salario`, `tipo_salario`) VALUES
(1, 'Diario'),
(2, 'Semanal'),
(3, 'Quincenal'),
(4, 'Mensual'),
(5, 'Por Obra/Labor');

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
  `rendimiento_promedio` decimal(10,2) DEFAULT NULL,
  `stock_actual` decimal(10,2) DEFAULT 0.00,
  `espacio_por_planta_m2` decimal(10,4) DEFAULT 0.2500
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_semilla`
--

INSERT INTO `tipo_semilla` (`id_semilla`, `id_empresa`, `id_catalogo`, `nombre_semilla`, `tiempo_base_dias`, `descripcion`, `rendimiento_promedio`, `stock_actual`, `espacio_por_planta_m2`) VALUES
(3, '988091212', 1, 'Tomate Chonto', 90, 'Variedad de tomate muy resistente, ideal para salsas.', 12.00, 955.00, 0.2500),
(4, '988091212', 3, 'Maíz Amarillo', 120, 'Cereal básico para la alimentación, ciclo corto.', 3.50, 200.00, 0.2500),
(5, '834324234', 2, 'Café Arábigo', 210, 'Variedad premium de café con aroma intenso y acidez equilibrada.', 1.50, 5.00, 0.2500),
(6, '834324234', NULL, 'fiojsdjkofa', 210, 'dkoaskdas', 1.20, 2.00, 0.2500),
(7, '834324234', 12, 'Cacao Forastero', 165, 'Variedad de cacao muy productiva y resistente.', 1.20, 9.00, 0.2500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_suelo`
--

CREATE TABLE `tipo_suelo` (
  `id_tipo_suelo` int(11) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `consumo_agua_ideal` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_suelo`
--

INSERT INTO `tipo_suelo` (`id_tipo_suelo`, `id_empresa`, `id_catalogo`, `nombre`, `descripcion`, `impacto_dias`, `consumo_agua_ideal`) VALUES
(1, '988091212', 1, 'Arcilloso', NULL, 5, NULL),
(2, '834324234', 2, 'Arenoso', NULL, -3, NULL),
(3, '834324234', NULL, 'ghgh', 'ojhjhjhil', 3, 5.50);

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
  `id_empresa` varchar(14) NOT NULL,
  `id_estado_trabajador` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`documento`, `imagen`, `nombre`, `telefono`, `correo`, `contrasena`, `remember_token`, `id_tipo_usuario`, `id_estado`, `id_empresa`, `id_estado_trabajador`) VALUES
(1006511653, 'usuarios/TPn5OuzBFcUMBMTb27MDcG8KrMQg0nUiQau4ExxO.png', 'Sebas Alvarez', '3103524334', 'sombrahdepaz76@gmail.com', '$2y$12$ShO2KxmULq2i87gGWluCyeAy/C5fhUJt26ceeK7Nt/BKxRxQl/DRa', '', 1, 3, '103455657789', 1),
(1034345454, 'usuarios/ohtjEMXYnEtIKQV6uXFyhSx4giqPArWo1ABQmYEk.jpg', 'Javier Gonza', '3223243434', 'bastobrayan246@gmail.com', '$2y$12$IXfjWMnY6Ul6L6B0trEKK.6obRkullnh7zI5H/sAO3/nHgpsQWjqq', '', 1, 3, '876767657', 1),
(1039253243, 'usuarios/6DbIrTZ3euiLErVZDzRTjao6nJEXJkhLXQTrjUvt.jpg', 'JORGE EL CURIOSO', '3201434344', 'dos1234@gmail.com', '$2y$12$lpj3Lk3wm9lYHUhtI5YN1eMFAfgTiW8E8aPJxTuIGQxvyt1/QSNM2', NULL, 3, 3, '988091212', 1),
(1104921223, 'usuarios/fxyI259nxaEdNx9meFLTLFkpNIRGXnj7nyy2Z8PX.png', 'julio profe', '3291231212', 'reyesz2803@gmail.com', '$2y$12$NcwOItyOjXK4jwD7js4ri.mghmiFTcxGEzjyPNbzJGOZ6lWJQ7Eou', 'CO4tvqUzjXfoaH4JzVrNbCx1fppx8aG6X8CEU0IrymLOIJwSWcQ8b3BC8zAZ', 1, 3, '834324234', 1),
(1105461467, 'usuarios/DKOC3w5ZmiayRnVTgSMffJcI6AQhq9EdKtgtelwj.png', 'sebas', '3176060850', 'gasrciasebastian019@gmail.com', '$2y$12$vrnlIhSsriy/9tEB6L95eOc3SbwfjQhH6/DSuEM6tEPLe.glEsM1.', NULL, 3, 3, '834324234', 1),
(1110722331, 'usuarios/useOl4EMIIlIsP0f8X6vMaoWPIjhX5Ml9tCDJ2bC.jpg', 'Didier', '3103527239', 'johsn@gmail.com', '$2y$12$4lNRhcjuBmkF25LyFWMLL.k5LlWvmOTnosiRabQoEgyG4ojfgk9am', '', 3, 3, '834324234', 1),
(1110722345, 'usuarios/IEJRgrLlnPGGxJcaD5NFbzOnxj7DAVNxZXnoZjTr.jpg', 'Brayan Gutierez', '3029219231', 'sombrahdepaz@gmail.com', '$2y$12$ElMqaOG0Q30Gbt8q2RwPDudpzZPaIlhmEoA4Ldj0WQ6cW6zhcGAiK', 'wIorrQl01xbj4CFJKKFDdfC0Euvz7Y8e3rHuyDlyYg8n9EIvaQ5zWx65R92g', 1, 3, '988091212', 1);

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
-- Indices de la tabla `catalogo_insumos`
--
ALTER TABLE `catalogo_insumos`
  ADD PRIMARY KEY (`id_catalogo_insumo`),
  ADD KEY `fk_cat_tipo` (`id_tipo_insumo`);

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
  ADD KEY `cosecha_estado_fk` (`id_estado`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `cultivo`
--
ALTER TABLE `cultivo`
  ADD PRIMARY KEY (`id_cultivo`),
  ADD KEY `id_cosecha` (`id_cosecha`),
  ADD KEY `id_trabajador` (`documento_trabajador`);

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
-- Indices de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  ADD PRIMARY KEY (`id_entrada`),
  ADD KEY `fk_entrada_proveedor` (`id_proveedor`),
  ADD KEY `fk_entrada_insumo` (`id_insumo`),
  ADD KEY `id_semilla` (`id_semilla`),
  ADD KEY `fk_entrada_insumo_empresa` (`id_empresa`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estado_trabajador`
--
ALTER TABLE `estado_trabajador`
  ADD PRIMARY KEY (`id_estado_trabajador`);

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
  ADD KEY `id_usuario` (`documento_trabajador`),
  ADD KEY `id_cosecha` (`id_cosecha`),
  ADD KEY `fk_fases_estado` (`id_estado`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`ID_insumo`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `fk_insumo_al_catalogo` (`id_catalogo_insumo`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `insumo_cosecha`
--
ALTER TABLE `insumo_cosecha`
  ADD PRIMARY KEY (`id_insumo_cosecha`),
  ADD KEY `fk_insumo_cosecha_c` (`id_cosecha`),
  ADD KEY `fk_insumo_cosecha_i` (`id_insumo`),
  ADD KEY `fk_ins_cos_trabajador` (`documento_trabajador`),
  ADD KEY `fk_ins_cos_estado_gral` (`id_estado`);

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
  ADD KEY `ID_insumo` (`ID_insumo`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `registro_trabajo`
--
ALTER TABLE `registro_trabajo`
  ADD PRIMARY KEY (`id_registro_trabajo`),
  ADD UNIQUE KEY `unique_registro_trabajo` (`id_insumo_cosecha`,`documento_trabajador`,`fecha_trabajada`),
  ADD KEY `fk_registro_trabajo_usuario` (`documento_trabajador`);

--
-- Indices de la tabla `riego`
--
ALTER TABLE `riego`
  ADD PRIMARY KEY (`id_riego`),
  ADD KEY `id_tipo_riego` (`id_tipo_riego`),
  ADD KEY `fk_riego_cosecha` (`id_cosecha`),
  ADD KEY `fk_riego_trabajador` (`documento_trabajador`),
  ADD KEY `fk_riego_estado_gral` (`id_estado`);

--
-- Indices de la tabla `salario`
--
ALTER TABLE `salario`
  ADD PRIMARY KEY (`id_salario`),
  ADD KEY `id_tipo_salario` (`id_tipo_salario`),
  ADD KEY `documento_trabajador` (`documento_trabajador`);

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
-- Indices de la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD PRIMARY KEY (`id_soporte`),
  ADD KEY `documento_trabajador` (`documento_trabajador`),
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
  ADD KEY `terreno_tipo_suelo_fk` (`id_tipo_suelo`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tipo_insumo`
--
ALTER TABLE `tipo_insumo`
  ADD PRIMARY KEY (`id_tipo_insumo`),
  ADD KEY `id_empresa` (`id_empresa`);

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
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `tipo_riego_id_catalogo_foreign` (`id_catalogo`);

--
-- Indices de la tabla `tipo_salario`
--
ALTER TABLE `tipo_salario`
  ADD PRIMARY KEY (`id_tipo_salario`);

--
-- Indices de la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  ADD PRIMARY KEY (`id_semilla`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `tipo_semilla_id_catalogo_foreign` (`id_catalogo`);

--
-- Indices de la tabla `tipo_suelo`
--
ALTER TABLE `tipo_suelo`
  ADD PRIMARY KEY (`id_tipo_suelo`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `tipo_suelo_id_catalogo_foreign` (`id_catalogo`);

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
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `fk_usuario_estado_trabajador` (`id_estado_trabajador`);

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
-- AUTO_INCREMENT de la tabla `catalogo_insumos`
--
ALTER TABLE `catalogo_insumos`
  MODIFY `id_catalogo_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id_cosecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `cultivo`
--
ALTER TABLE `cultivo`
  MODIFY `id_cultivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_producto_cultivo`
--
ALTER TABLE `detalle_producto_cultivo`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `estado_trabajador`
--
ALTER TABLE `estado_trabajador`
  MODIFY `id_estado_trabajador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fases_programadas`
--
ALTER TABLE `fases_programadas`
  MODIFY `id_fase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `ID_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `insumo_cosecha`
--
ALTER TABLE `insumo_cosecha`
  MODIFY `id_insumo_cosecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `registro_trabajo`
--
ALTER TABLE `registro_trabajo`
  MODIFY `id_registro_trabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `riego`
--
ALTER TABLE `riego`
  MODIFY `id_riego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `salario`
--
ALTER TABLE `salario`
  MODIFY `id_salario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_compra`
--
ALTER TABLE `solicitud_compra`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `soporte`
--
ALTER TABLE `soporte`
  MODIFY `id_soporte` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id_super_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1110495790;

--
-- AUTO_INCREMENT de la tabla `terreno`
--
ALTER TABLE `terreno`
  MODIFY `id_terreno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipo_insumo`
--
ALTER TABLE `tipo_insumo`
  MODIFY `id_tipo_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  MODIFY `id_tipo_riego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipo_salario`
--
ALTER TABLE `tipo_salario`
  MODIFY `id_tipo_salario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  MODIFY `id_semilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_suelo`
--
ALTER TABLE `tipo_suelo`
  MODIFY `id_tipo_suelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `catalogo_insumos`
--
ALTER TABLE `catalogo_insumos`
  ADD CONSTRAINT `fk_catalogo_insumos_tipo_insumo` FOREIGN KEY (`id_tipo_insumo`) REFERENCES `tipo_insumo` (`id_tipo_insumo`);

--
-- Filtros para la tabla `cosecha`
--
ALTER TABLE `cosecha`
  ADD CONSTRAINT `cosecha_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `cosecha_ibfk_2` FOREIGN KEY (`id_terreno`) REFERENCES `terreno` (`id_terreno`),
  ADD CONSTRAINT `cosecha_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `cosecha_ibfk_4` FOREIGN KEY (`id_semilla`) REFERENCES `tipo_semilla` (`id_semilla`);

--
-- Filtros para la tabla `cultivo`
--
ALTER TABLE `cultivo`
  ADD CONSTRAINT `fk_cultivo_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `fk_cultivo_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `detalle_producto_cultivo`
--
ALTER TABLE `detalle_producto_cultivo`
  ADD CONSTRAINT `fk_detalle_producto_cultivo_cultivo` FOREIGN KEY (`id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  ADD CONSTRAINT `fk_detalle_producto_cultivo_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresa_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  ADD CONSTRAINT `fk_entrada_insumo_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `fk_entrada_insumo_insumo` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`),
  ADD CONSTRAINT `fk_entrada_insumo_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  ADD CONSTRAINT `fk_entrada_insumo_semilla` FOREIGN KEY (`id_semilla`) REFERENCES `tipo_semilla` (`id_semilla`);

--
-- Filtros para la tabla `fases_programadas`
--
ALTER TABLE `fases_programadas`
  ADD CONSTRAINT `fk_fases_programadas_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `fk_fases_programadas_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_fases_programadas_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD CONSTRAINT `fk_insumo_catalogo_insumos` FOREIGN KEY (`id_catalogo_insumo`) REFERENCES `catalogo_insumos` (`id_catalogo_insumo`),
  ADD CONSTRAINT `fk_insumo_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `fk_insumo_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  ADD CONSTRAINT `insumo_ibfk_1` FOREIGN KEY (`id_catalogo_insumo`) REFERENCES `catalogo_insumos` (`id_catalogo_insumo`),
  ADD CONSTRAINT `insumo_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `insumo_cosecha`
--
ALTER TABLE `insumo_cosecha`
  ADD CONSTRAINT `fk_insumo_cosecha_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `fk_insumo_cosecha_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_insumo_cosecha_insumo` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`),
  ADD CONSTRAINT `fk_insumo_cosecha_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_proveedor_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `registro_trabajo`
--
ALTER TABLE `registro_trabajo`
  ADD CONSTRAINT `fk_registro_trabajo_insumo_cosecha` FOREIGN KEY (`id_insumo_cosecha`) REFERENCES `insumo_cosecha` (`id_insumo_cosecha`),
  ADD CONSTRAINT `fk_registro_trabajo_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `riego`
--
ALTER TABLE `riego`
  ADD CONSTRAINT `fk_riego_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  ADD CONSTRAINT `fk_riego_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_riego_tipo_riego` FOREIGN KEY (`id_tipo_riego`) REFERENCES `tipo_riego` (`id_tipo_riego`),
  ADD CONSTRAINT `fk_riego_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `salario`
--
ALTER TABLE `salario`
  ADD CONSTRAINT `fk_salario_tipo_salario` FOREIGN KEY (`id_tipo_salario`) REFERENCES `tipo_salario` (`id_tipo_salario`),
  ADD CONSTRAINT `salario_ibfk_1` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `solicitud_compra`
--
ALTER TABLE `solicitud_compra`
  ADD CONSTRAINT `fk_solicitud_compra_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `fk_solicitud_compra_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_solicitud_compra_tipo_licencia` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`),
  ADD CONSTRAINT `solicitud_compra_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `solicitud_compra_ibfk_2` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`),
  ADD CONSTRAINT `solicitud_compra_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD CONSTRAINT `soporte_ibfk_1` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`),
  ADD CONSTRAINT `soporte_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `super_admin`
--
ALTER TABLE `super_admin`
  ADD CONSTRAINT `fk_super_admin_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `terreno`
--
ALTER TABLE `terreno`
  ADD CONSTRAINT `fk_terreno_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `fk_terreno_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_terreno_tipo_suelo` FOREIGN KEY (`id_tipo_suelo`) REFERENCES `tipo_suelo` (`id_tipo_suelo`);

--
-- Filtros para la tabla `tipo_insumo`
--
ALTER TABLE `tipo_insumo`
  ADD CONSTRAINT `tipo_insumo_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  ADD CONSTRAINT `fk_tipo_licencia_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  ADD CONSTRAINT `fk_tipo_riego_catalogo_riegos` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_riegos` (`id`),
  ADD CONSTRAINT `fk_tipo_riego_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `tipo_riego_ibfk_1` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_riegos` (`id`),
  ADD CONSTRAINT `tipo_riego_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  ADD CONSTRAINT `fk_tipo_semilla_catalogo_semillas` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_semillas` (`id`),
  ADD CONSTRAINT `fk_tipo_semilla_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `tipo_semilla_ibfk_1` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_semillas` (`id`),
  ADD CONSTRAINT `tipo_semilla_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tipo_suelo`
--
ALTER TABLE `tipo_suelo`
  ADD CONSTRAINT `fk_tipo_suelo_catalogo_suelos` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_suelos` (`id`),
  ADD CONSTRAINT `fk_tipo_suelo_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `tipo_suelo_ibfk_1` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_suelos` (`id`),
  ADD CONSTRAINT `tipo_suelo_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `fk_usuario_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_usuario_estado_trabajador` FOREIGN KEY (`id_estado_trabajador`) REFERENCES `estado_trabajador` (`id_estado_trabajador`),
  ADD CONSTRAINT `fk_usuario_tipo_usuario` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`);

--
-- Filtros para la tabla `venta_licencias`
--
ALTER TABLE `venta_licencias`
  ADD CONSTRAINT `fk_venta_licencias_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `fk_venta_licencias_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_venta_licencias_tipo_licencia` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
