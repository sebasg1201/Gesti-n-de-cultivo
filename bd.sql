SET FOREIGN_KEY_CHECKS = 0;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2026 a las 18:31:28
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

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('agrotech-cache-2fa_code_1110722345', 'i:264599;', 1774985949);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_insumos`
--

DROP TABLE IF EXISTS `catalogo_insumos`;
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
(6, 'Aceite Motor Diesel 15W40', 'Lubricante para tractores y maquinaria pesada', 0, 9),
(8, 'Fertilizante Triple 15', 'Fertilizante granulado balanceado', 6, 6),
(9, 'DAP Fosfato Diamónico', 'Fuente de fósforo para raíces', 7, 6),
(10, 'Cloruro de Potasio', 'Aporte de potasio para fructificación', 6, 6),
(11, 'Abono Orgánico Compost', 'Materia orgánica para mejorar el suelo', 10, 2),
(12, 'Humus de Lombriz', 'Fertilizante natural rico en nutrientes', 9, 2),
(13, 'Glifosato 480 SL', 'Herbicida sistémico no selectivo', -5, 4),
(14, 'Paraquat', 'Herbicida de contacto', -4, 4),
(15, '2,4-D Amina', 'Control de malezas hoja ancha', -3, 4),
(16, 'Mancozeb', 'Fungicida preventivo', -2, 3),
(17, 'Carbendazim', 'Fungicida sistémico', -2, 3),
(18, 'Oxicloruro de Cobre', 'Control de enfermedades bacterianas', -1, 3),
(19, 'Imidacloprid', 'Insecticida sistémico', -3, 10),
(20, 'Clorpirifos', 'Insecticida organofosforado', -4, 10),
(21, 'Lambda Cihalotrina', 'Control de insectos masticadores', -3, 10),
(22, 'Azufre Agrícola', 'Control de hongos y ácaros', -1, 7),
(23, 'Cal Agrícola', 'Corrector de pH del suelo', 8, 7),
(24, 'Yeso Agrícola', 'Mejora estructura del suelo', 7, 7),
(25, 'Bioestimulante Algas Marinas', 'Estimula crecimiento vegetal', 6, 7),
(26, 'Melaza Agrícola', 'Estimula microorganismos del suelo', 5, 7),
(27, 'Azadón Profesional', 'Herramienta para labranza', 0, 8),
(28, 'Rastrillo Metálico', 'Nivelación de terreno', 0, 8),
(29, 'Carretilla Agrícola', 'Transporte de materiales', 0, 8),
(30, 'Guadaña Manual', 'Corte de maleza', 0, 8),
(31, 'Tijeras de Poda', 'Poda de cultivos', 0, 8),
(32, 'Grasa Multipropósito', 'Lubricante para maquinaria', 0, 9),
(33, 'Aceite Hidráulico', 'Para sistemas hidráulicos', 0, 9),
(34, 'Diesel Agrícola', 'Combustible maquinaria', 0, 9),
(35, 'Micorrizas', 'Mejora absorción de nutrientes', 9, 7),
(36, 'Trichoderma', 'Control biológico de hongos', 7, 7),
(37, 'Bacillus Thuringiensis', 'Control biológico de insectos', -1, 7),
(38, 'Nitrato de Calcio', 'Fuente de calcio y nitrógeno', 6, 6),
(39, 'Sulfato de Magnesio', 'Aporte de magnesio', 5, 6),
(40, 'Quelato de Hierro', 'Corrige clorosis férrica', 4, 6),
(41, 'Silicato de Potasio', 'Fortalece resistencia vegetal', 6, 6),
(42, 'Extracto de Neem', 'Insecticida natural', -2, 10),
(43, 'Fosfato Monoamónico MAP', 'Fuente de fósforo y nitrógeno', 6, 6),
(44, 'Nitrato de Potasio', 'Estimula floración y fructificación', 5, 6),
(45, 'Ácido Húmico Líquido', 'Mejora estructura del suelo', 8, 2),
(46, 'Ácido Fúlvico', 'Favorece absorción de nutrientes', 7, 2),
(47, 'Spinosad', 'Insecticida biológico', -2, 10),
(48, 'Abamectina', 'Control de ácaros e insectos', -3, 10),
(49, 'Metalaxil', 'Fungicida sistémico', -2, 3),
(50, 'Atrazina', 'Herbicida preemergente', -4, 4),
(51, 'Pulverizador Manual 20L', 'Equipo para aplicación de insumos', 0, 8),
(52, 'Aceite 2T', 'Lubricante para guadaña', 0, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_riegos`
--

DROP TABLE IF EXISTS `catalogo_riegos`;
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

DROP TABLE IF EXISTS `catalogo_semillas`;
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
(1, 'Tomate Chonto', 'Variedad de tomate muy resistente, ideal para salsas.', 90, 12.00, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 0.4000),
(2, 'Café Arábigo', 'Variedad premium de café con aroma intenso y acidez equilibrada.', 720, 1.50, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 2.0000),
(3, 'Maíz Amarillo', 'Cereal básico para la alimentación, ciclo corto.', 120, 3.50, NULL, NULL, 0.5000),
(4, 'Papa Pastusa', 'Variedad de papa de textura harinosa, muy popular en Colombia.', 120, 25.00, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 0.3500),
(5, 'Cacao', 'Cultivo de clima cálido, base para el chocolate.', 180, 0.80, NULL, NULL, 0.5000),
(6, 'Arroz', 'Cereal de inundación o secano, base de la dieta.', 130, 6.00, NULL, NULL, 0.5000),
(7, 'Maíz Dulce', 'Maíz de grano tierno y dulce, ideal para consumo humano directo.', 85, 4.50, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 0.3000),
(8, 'Cebolla Cabezona', 'Bulbo de sabor fuerte, uso esencial en cocina.', 120, 15.00, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 0.0800),
(9, 'Papa Criolla', 'Papa pequeña y amarilla, ciclo corto y sabor suave.', 100, 10.00, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 0.3000),
(10, 'Zanahoria', 'Raíz naranja rica en carotenos, ciclo productivo estándar.', 100, 20.00, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 0.0500),
(11, 'Fresa', 'Fruta roja pequeña, requiere suelos ácidos y buen riego.', 120, 0.80, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 0.2500),
(12, 'Cacao Forastero', 'Variedad de cacao muy productiva y resistente.', 1095, 1.20, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 9.0000),
(13, 'Plátano Hartón', 'Plátano de gran tamaño usado principalmente para cocinar.', 300, 14.00, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 6.0000),
(14, 'Aguacate Hass', 'Variedad de aguacate con piel rugosa y alto contenido de aceite.', 1460, 8.00, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 25.0000),
(15, 'Fríjol Cargamanto', 'Leguminosa de grano grande, muy apreciada en la región andina.', 120, 2.20, '2026-03-07 19:26:40', '2026-03-25 21:42:35', 0.2000),
(16, 'Lechuga Romana', 'Hortaliza de hojas alargadas, muy usada en ensaladas.', 60, 3.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.1000),
(17, 'Espinaca', 'Hortaliza de hojas verdes rica en hierro.', 45, 2.50, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.0800),
(18, 'Pepino', 'Fruto alargado y refrescante, de rápido crecimiento.', 75, 8.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.5000),
(19, 'Pimentón', 'Fruto dulce de colores variados.', 100, 6.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.4000),
(20, 'Ajo', 'Bulbo aromático usado como condimento.', 150, 5.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.1000),
(21, 'Brócoli', 'Hortaliza rica en nutrientes, tipo col.', 90, 4.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.4000),
(22, 'Coliflor', 'Hortaliza de inflorescencia blanca.', 100, 3.50, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.4000),
(23, 'Repollo', 'Hortaliza de hojas compactas en forma de bola.', 110, 4.50, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.5000),
(24, 'Yuca', 'Raíz tropical rica en carbohidratos.', 300, 20.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 1.0000),
(25, 'Batata', 'Tubérculo dulce también conocido como camote.', 120, 18.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.5000),
(26, 'Sandía', 'Fruta grande y jugosa, de clima cálido.', 100, 10.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 2.0000),
(27, 'Melón', 'Fruta dulce de pulpa aromática.', 90, 8.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 1.5000),
(28, 'Calabacín', 'Variedad de calabaza de fruto tierno.', 60, 6.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.6000),
(29, 'Calabaza', 'Fruto grande utilizado en múltiples preparaciones.', 120, 12.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 2.5000),
(30, 'Apio', 'Hortaliza de tallos largos y crujientes.', 130, 4.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.3000),
(31, 'Cilantro', 'Hierba aromática muy usada en cocina.', 40, 1.50, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.0500),
(32, 'Perejil', 'Hierba aromática de uso culinario.', 70, 1.20, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.0500),
(33, 'Albahaca', 'Hierba aromática muy usada en cocina italiana.', 60, 1.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.0800),
(34, 'Orégano', 'Planta aromática resistente.', 80, 0.80, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.1000),
(35, 'Lenteja', 'Leguminosa rica en proteínas.', 110, 1.80, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.1500),
(36, 'Garbanzo', 'Leguminosa muy nutritiva.', 120, 2.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.2000),
(37, 'Sorgo', 'Cereal resistente a sequía.', 110, 3.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.2500),
(38, 'Avena', 'Cereal usado en alimentación humana y animal.', 120, 2.50, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.2000),
(39, 'Trigo', 'Cereal base para harina.', 130, 3.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.2000),
(40, 'Uva', 'Fruta cultivada en vides, usada para consumo y vino.', 365, 10.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 3.0000),
(41, 'Mango', 'Fruta tropical dulce y jugosa.', 1095, 15.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 25.0000),
(42, 'Piña', 'Fruta tropical de sabor ácido-dulce.', 540, 2.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.6000),
(43, 'Papaya', 'Fruta tropical de rápido crecimiento.', 300, 20.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 4.0000),
(44, 'Guayaba', 'Fruta tropical rica en vitamina C.', 720, 18.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 9.0000),
(45, 'Maracuyá', 'Fruta ácida usada en jugos.', 300, 12.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 4.0000),
(46, 'Granadilla', 'Fruta dulce de cáscara dura.', 270, 10.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 4.0000),
(47, 'Arveja', 'Leguminosa de grano verde.', 90, 2.50, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.2000),
(48, 'Habichuela', 'Vaina verde comestible.', 70, 3.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.2000),
(49, 'Rábano', 'Raíz de crecimiento muy rápido.', 30, 1.50, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.0500),
(50, 'Remolacha', 'Raíz roja rica en nutrientes.', 90, 6.00, '2026-03-25 21:06:32', '2026-03-25 21:42:35', 0.1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_suelos`
--

DROP TABLE IF EXISTS `catalogo_suelos`;
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

DROP TABLE IF EXISTS `cosecha`;
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cultivo`
--

DROP TABLE IF EXISTS `cultivo`;
CREATE TABLE `cultivo` (
  `id_cultivo` int(11) NOT NULL,
  `fecha_recoleccion` date DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `documento_trabajador` int(11) NOT NULL,
  `descripcion_recoleccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producto_cultivo`
--

DROP TABLE IF EXISTS `detalle_producto_cultivo`;
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

DROP TABLE IF EXISTS `empresa`;
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_insumo`
--

DROP TABLE IF EXISTS `entrada_insumo`;
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

DROP TABLE IF EXISTS `estado`;
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
(18, 'Perdida Oculta'),
(19, 'Retrasó');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_trabajador`
--

DROP TABLE IF EXISTS `estado_trabajador`;
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

DROP TABLE IF EXISTS `failed_jobs`;
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

DROP TABLE IF EXISTS `fases_programadas`;
CREATE TABLE `fases_programadas` (
  `id_fase` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_programada` datetime DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `id_terreno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

DROP TABLE IF EXISTS `insumo`;
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo_cosecha`
--

DROP TABLE IF EXISTS `insumo_cosecha`;
CREATE TABLE `insumo_cosecha` (
  `id_insumo_cosecha` int(11) NOT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `cantidad_usada` decimal(10,2) DEFAULT NULL,
  `observaciones` text NOT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `fecha_programada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

DROP TABLE IF EXISTS `jobs`;
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

DROP TABLE IF EXISTS `job_batches`;
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

DROP TABLE IF EXISTS `migrations`;
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
(29, '2026_03_17_000001_insert_en_proceso_estado', 17),
(30, '2026_03_19_141013_add_timestamps_to_insumo_and_terreno', 18),
(31, '2026_03_25_170000_add_ids_to_registro_trabajo_table', 19),
(32, '2026_03_27_162735_add_task_fields_to_cultivo_and_registro_trabajo', 20),
(33, '2026_03_27_150000_drop_redundant_columns', 21),
(34, '2026_03_27_171743_add_descripcion_to_producto_table', 22),
(35, '2026_03_25_103434_fix_terreno_area_precision', 23),
(36, '2026_03_25_162551_add_id_terreno_to_fases_programadas_table', 24),
(37, '2026_03_27_140000_fix_registro_trabajo_nullability', 24),
(38, '2026_03_29_001608_fix_registro_trabajo_foreign_keys_and_data', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
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

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `ID_insumo` int(11) DEFAULT NULL,
  `id_empresa` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_trabajo`
--

DROP TABLE IF EXISTS `registro_trabajo`;
CREATE TABLE `registro_trabajo` (
  `id_registro_trabajo` int(11) NOT NULL,
  `id_insumo_cosecha` int(11) DEFAULT NULL,
  `id_cultivo` int(11) DEFAULT NULL,
  `id_fase` int(11) DEFAULT NULL,
  `id_riego` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `fecha_trabajada` date NOT NULL,
  `foto_evidencia` varchar(255) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `riego`
--

DROP TABLE IF EXISTS `riego`;
CREATE TABLE `riego` (
  `id_riego` int(11) NOT NULL,
  `cant_agua_apl` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `id_tipo_riego` int(11) DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `fecha_programada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salario`
--

DROP TABLE IF EXISTS `salario`;
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

DROP TABLE IF EXISTS `sessions`;
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
('6XJCjJF3gWdxuZKLpKN99QqPSlWkVihjG9vj9l88', 1105461467, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTHh4b1dsYWVGODJjOVZXekNzR09QRlVSbTk5eWlWWURpclJYQWhDYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFiYWphZG9yL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoyMDoidHJhYmFqYWRvci5kYXNoYm9hcmQiO31zOjU0OiJsb2dpbl91c3VhcmlvXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTEwNTQ2MTQ2Nzt9', 1775180491),
('qJHe3vhArx2WCxVI3S3vfMV8EChRArIHIgFf1Ifm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibkZyYjJTdVR4Q1JLNzV2NzFFZVBvdmZTN2hPblhQUHhoMG1VdnVvZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zb2xpY2l0dWQtY29tcHJhLzIiO3M6NToicm91dGUiO3M6MTY6InNvbGljaXR1ZC5jcmVhdGUiO319', 1775057597),
('wweMghpq9QGZVMk4ehnbR0rbaTX93ycujE2GaQ0Z', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ0trV0RGTUlzUUhvbnFmZTlvNDV4cEJqNTB6cEJDN090QWxST0E4OSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3RyYWJhamFkb3IvY2FsZW5kYXJpbyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO3M6NToicm91dGUiO3M6MTM6InVzdWFyaW8ubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1775180300);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_compra`
--

DROP TABLE IF EXISTS `solicitud_compra`;
CREATE TABLE `solicitud_compra` (
  `id_solicitud` int(11) NOT NULL,
  `id_empresa` varchar(14) NOT NULL,
  `comprobante_pago` varchar(255) DEFAULT NULL,
  `id_tipo_licencia` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `fecha_revision` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte`
--

DROP TABLE IF EXISTS `soporte`;
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `super_admin`
--

DROP TABLE IF EXISTS `super_admin`;
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
(1110433912, 'Cesar Esquivel', 'Cesar', 'esquivel7809@gmail.com', '$2y$12$ULn8lXCcdpgeMtkJte97geykXJtxOG5ouXmB1BO0q9muH/prungM2', 3, NULL, '2026-04-01 15:01:44', '2026-04-01 15:07:31', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terreno`
--

DROP TABLE IF EXISTS `terreno`;
CREATE TABLE `terreno` (
  `id_terreno` int(11) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `Ancho` decimal(10,0) NOT NULL,
  `Alto` decimal(10,0) NOT NULL,
  `area_m2` decimal(15,2) DEFAULT NULL,
  `departamento` text NOT NULL,
  `ciudad` text NOT NULL,
  `codigo_postal` int(250) NOT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_tipo_suelo` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_insumo`
--

DROP TABLE IF EXISTS `tipo_insumo`;
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
(10, 'Pesticida', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_licencia`
--

DROP TABLE IF EXISTS `tipo_licencia`;
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
(1, 'Basico', '1 Mes', '24 Horas De Soporte', 100000.00, 1),
(2, 'Medium', '6 Meses', '24 Horas De Soporte', 600000.00, 1),
(3, 'Profesional', '1 Año', '24 Horas De Soporte', 1200000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_riego`
--

DROP TABLE IF EXISTS `tipo_riego`;
CREATE TABLE `tipo_riego` (
  `id_tipo_riego` int(11) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_riego` varchar(50) DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_salario`
--

DROP TABLE IF EXISTS `tipo_salario`;
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

DROP TABLE IF EXISTS `tipo_semilla`;
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_suelo`
--

DROP TABLE IF EXISTS `tipo_suelo`;
CREATE TABLE `tipo_suelo` (
  `id_tipo_suelo` int(11) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `capacidad_retencion_litros_m2` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
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

DROP TABLE IF EXISTS `usuario`;
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_licencias`
--

DROP TABLE IF EXISTS `venta_licencias`;
CREATE TABLE `venta_licencias` (
  `id_key` varchar(14) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `observacione` text NOT NULL,
  `id_tipo_licencia` int(11) NOT NULL,
  `id_empresa` varchar(14) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `id_trabajador` (`documento_trabajador`),
  ADD KEY `id_estado` (`id_estado`);

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
  ADD KEY `id_cosecha` (`id_terreno`),
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
  ADD KEY `fk_registro_trabajo_usuario` (`documento_trabajador`),
  ADD KEY `id_fase` (`id_fase`),
  ADD KEY `id_riego` (`id_riego`),
  ADD KEY `id_estado` (`id_estado`);

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
  MODIFY `id_catalogo_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `catalogo_riegos`
--
ALTER TABLE `catalogo_riegos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `catalogo_semillas`
--
ALTER TABLE `catalogo_semillas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `catalogo_suelos`
--
ALTER TABLE `catalogo_suelos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cosecha`
--
ALTER TABLE `cosecha`
  MODIFY `id_cosecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `cultivo`
--
ALTER TABLE `cultivo`
  MODIFY `id_cultivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_producto_cultivo`
--
ALTER TABLE `detalle_producto_cultivo`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id_fase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `ID_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `insumo_cosecha`
--
ALTER TABLE `insumo_cosecha`
  MODIFY `id_insumo_cosecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `registro_trabajo`
--
ALTER TABLE `registro_trabajo`
  MODIFY `id_registro_trabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `riego`
--
ALTER TABLE `riego`
  MODIFY `id_riego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `id_terreno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipo_insumo`
--
ALTER TABLE `tipo_insumo`
  MODIFY `id_tipo_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  MODIFY `id_tipo_riego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipo_salario`
--
ALTER TABLE `tipo_salario`
  MODIFY `id_tipo_salario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  MODIFY `id_semilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipo_suelo`
--
ALTER TABLE `tipo_suelo`
  MODIFY `id_tipo_suelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `cultivo_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
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
  ADD CONSTRAINT `fases_programadas_ibfk_1` FOREIGN KEY (`id_terreno`) REFERENCES `terreno` (`id_terreno`),
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
  ADD CONSTRAINT `registro_trabajo_documento_trabajador_foreign` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`),
  ADD CONSTRAINT `registro_trabajo_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `registro_trabajo_id_fase_foreign` FOREIGN KEY (`id_fase`) REFERENCES `fases_programadas` (`id_fase`) ON DELETE SET NULL,
  ADD CONSTRAINT `registro_trabajo_id_insumo_cosecha_foreign` FOREIGN KEY (`id_insumo_cosecha`) REFERENCES `insumo_cosecha` (`id_insumo_cosecha`) ON DELETE SET NULL,
  ADD CONSTRAINT `registro_trabajo_id_riego_foreign` FOREIGN KEY (`id_riego`) REFERENCES `riego` (`id_riego`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `salario_ibfk_1` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`),
  ADD CONSTRAINT `salario_ibfk_2` FOREIGN KEY (`id_tipo_salario`) REFERENCES `tipo_salario` (`id_tipo_salario`);

--
-- Filtros para la tabla `solicitud_compra`
--
ALTER TABLE `solicitud_compra`
  ADD CONSTRAINT `solicitud_compra_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `solicitud_compra_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `solicitud_compra_id_tipo_licencia_foreign` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`);

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
  ADD CONSTRAINT `super_admin_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `terreno`
--
ALTER TABLE `terreno`
  ADD CONSTRAINT `terreno_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `terreno_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `tipo_insumo`
--
ALTER TABLE `tipo_insumo`
  ADD CONSTRAINT `tipo_insumo_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tipo_riego`
--
ALTER TABLE `tipo_riego`
  ADD CONSTRAINT `tipo_riego_id_catalogo_foreign` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_riegos` (`id`),
  ADD CONSTRAINT `tipo_riego_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tipo_semilla`
--
ALTER TABLE `tipo_semilla`
  ADD CONSTRAINT `tipo_semilla_id_catalogo_foreign` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_semillas` (`id`),
  ADD CONSTRAINT `tipo_semilla_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tipo_suelo`
--
ALTER TABLE `tipo_suelo`
  ADD CONSTRAINT `tipo_suelo_id_catalogo_foreign` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_suelos` (`id`),
  ADD CONSTRAINT `tipo_suelo_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`id_estado_trabajador`) REFERENCES `estado_trabajador` (`id_estado_trabajador`);

--
-- Filtros para la tabla `venta_licencias`
--
ALTER TABLE `venta_licencias`
  ADD CONSTRAINT `venta_licencias_ibfk_1` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`),
  ADD CONSTRAINT `venta_licencias_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `venta_licencias_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

SET FOREIGN_KEY_CHECKS = 1;