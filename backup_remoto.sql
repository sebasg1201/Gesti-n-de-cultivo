-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 212.85.3.219    Database: u716029766_agro
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogo_insumos`
--

DROP TABLE IF EXISTS `catalogo_insumos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogo_insumos` (
  `id_catalogo_insumo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_comercial` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `id_tipo_insumo` int(11) NOT NULL,
  PRIMARY KEY (`id_catalogo_insumo`),
  KEY `fk_cat_tipo` (`id_tipo_insumo`),
  CONSTRAINT `fk_catalogo_insumos_tipo_insumo` FOREIGN KEY (`id_tipo_insumo`) REFERENCES `tipo_insumo` (`id_tipo_insumo`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_insumos`
--

LOCK TABLES `catalogo_insumos` WRITE;
/*!40000 ALTER TABLE `catalogo_insumos` DISABLE KEYS */;
INSERT INTO `catalogo_insumos` VALUES (2,'Fertilizante NPK 15-15-15','Fertilizante equilibrado para todo tipo de cultivos',5,6),(3,'Urea Agrícola 46%','Fuente concentrada de nitrógeno',3,6),(4,'Pala Punta Huevo','Herramienta resistente para trabajo de campo',0,8),(5,'Machete 22 Pulgadas','Acero al carbono, ideal para desmonte',0,8),(6,'Aceite Motor Diesel 15W40','Lubricante para tractores y maquinaria pesada',0,9),(8,'Fertilizante Triple 15','Fertilizante granulado balanceado',6,6),(9,'DAP Fosfato Diamónico','Fuente de fósforo para raíces',7,6),(10,'Cloruro de Potasio','Aporte de potasio para fructificación',6,6),(11,'Abono Orgánico Compost','Materia orgánica para mejorar el suelo',10,2),(12,'Humus de Lombriz','Fertilizante natural rico en nutrientes',9,2),(13,'Glifosato 480 SL','Herbicida sistémico no selectivo',-5,4),(14,'Paraquat','Herbicida de contacto',-4,4),(15,'2,4-D Amina','Control de malezas hoja ancha',-3,4),(16,'Mancozeb','Fungicida preventivo',-2,3),(17,'Carbendazim','Fungicida sistémico',-2,3),(18,'Oxicloruro de Cobre','Control de enfermedades bacterianas',-1,3),(19,'Imidacloprid','Insecticida sistémico',-3,10),(20,'Clorpirifos','Insecticida organofosforado',-4,10),(21,'Lambda Cihalotrina','Control de insectos masticadores',-3,10),(22,'Azufre Agrícola','Control de hongos y ácaros',-1,7),(23,'Cal Agrícola','Corrector de pH del suelo',8,7),(24,'Yeso Agrícola','Mejora estructura del suelo',7,7),(25,'Bioestimulante Algas Marinas','Estimula crecimiento vegetal',6,7),(26,'Melaza Agrícola','Estimula microorganismos del suelo',5,7),(27,'Azadón Profesional','Herramienta para labranza',0,8),(28,'Rastrillo Metálico','Nivelación de terreno',0,8),(29,'Carretilla Agrícola','Transporte de materiales',0,8),(30,'Guadaña Manual','Corte de maleza',0,8),(31,'Tijeras de Poda','Poda de cultivos',0,8),(32,'Grasa Multipropósito','Lubricante para maquinaria',0,9),(33,'Aceite Hidráulico','Para sistemas hidráulicos',0,9),(34,'Diesel Agrícola','Combustible maquinaria',0,9),(35,'Micorrizas','Mejora absorción de nutrientes',9,7),(36,'Trichoderma','Control biológico de hongos',7,7),(37,'Bacillus Thuringiensis','Control biológico de insectos',-1,7),(38,'Nitrato de Calcio','Fuente de calcio y nitrógeno',6,6),(39,'Sulfato de Magnesio','Aporte de magnesio',5,6),(40,'Quelato de Hierro','Corrige clorosis férrica',4,6),(41,'Silicato de Potasio','Fortalece resistencia vegetal',6,6),(42,'Extracto de Neem','Insecticida natural',-2,10),(43,'Fosfato Monoamónico MAP','Fuente de fósforo y nitrógeno',6,6),(44,'Nitrato de Potasio','Estimula floración y fructificación',5,6),(45,'Ácido Húmico Líquido','Mejora estructura del suelo',8,2),(46,'Ácido Fúlvico','Favorece absorción de nutrientes',7,2),(47,'Spinosad','Insecticida biológico',-2,10),(48,'Abamectina','Control de ácaros e insectos',-3,10),(49,'Metalaxil','Fungicida sistémico',-2,3),(50,'Atrazina','Herbicida preemergente',-4,4),(51,'Pulverizador Manual 20L','Equipo para aplicación de insumos',0,8),(52,'Aceite 2T','Lubricante para guadaña',0,9);
/*!40000 ALTER TABLE `catalogo_insumos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogo_riegos`
--

DROP TABLE IF EXISTS `catalogo_riegos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogo_riegos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `impacto_dias` int(11) NOT NULL DEFAULT 0,
  `descripcion_tecnica` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_riegos`
--

LOCK TABLES `catalogo_riegos` WRITE;
/*!40000 ALTER TABLE `catalogo_riegos` DISABLE KEYS */;
INSERT INTO `catalogo_riegos` VALUES (1,'Goteo',-3,'Suministro lento y directo a las raíces, ahorro máximo de agua.',NULL,NULL),(2,'Aspersión',0,'Simulación de lluvia, ideal para grandes superficies.',NULL,NULL),(3,'Micro-aspersión',-1,'Riego fino para cultivos delicados o invernaderos.',NULL,NULL),(4,'Gravedad (Surcos)',2,'Distribución por canales, uso tradicional en terrenos planos.',NULL,NULL),(5,'Manual (Manguera/Balde)',3,'Aplicación directa controlada por el operario, menos eficiente.',NULL,'2026-03-07 19:27:51'),(6,'Hidropónico',-7,'Circulación de solución nutritiva en agua, crecimiento acelerado.',NULL,'2026-03-07 19:27:51');
/*!40000 ALTER TABLE `catalogo_riegos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogo_semillas`
--

DROP TABLE IF EXISTS `catalogo_semillas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogo_semillas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tiempo_base_dias` int(11) NOT NULL,
  `rendimiento_promedio` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `espacio_por_planta_m2` decimal(10,4) NOT NULL DEFAULT 0.2500,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_semillas`
--

LOCK TABLES `catalogo_semillas` WRITE;
/*!40000 ALTER TABLE `catalogo_semillas` DISABLE KEYS */;
INSERT INTO `catalogo_semillas` VALUES (1,'Tomate Chonto','Variedad de tomate muy resistente, ideal para salsas.',90,12.00,'2026-03-07 19:26:40','2026-03-25 21:42:35',0.4000),(2,'Café Arábigo','Variedad premium de café con aroma intenso y acidez equilibrada.',720,1.50,'2026-03-07 19:26:40','2026-03-25 21:42:35',2.0000),(3,'Maíz Amarillo','Cereal básico para la alimentación, ciclo corto.',120,3.50,NULL,NULL,0.5000),(4,'Papa Pastusa','Variedad de papa de textura harinosa, muy popular en Colombia.',120,25.00,'2026-03-07 19:26:40','2026-03-25 21:42:35',0.3500),(5,'Cacao','Cultivo de clima cálido, base para el chocolate.',180,0.80,NULL,NULL,0.5000),(6,'Arroz','Cereal de inundación o secano, base de la dieta.',130,6.00,NULL,NULL,0.5000),(7,'Maíz Dulce','Maíz de grano tierno y dulce, ideal para consumo humano directo.',85,4.50,'2026-03-07 19:26:40','2026-03-25 21:42:35',0.3000),(8,'Cebolla Cabezona','Bulbo de sabor fuerte, uso esencial en cocina.',120,15.00,'2026-03-07 19:26:40','2026-03-25 21:42:35',0.0800),(9,'Papa Criolla','Papa pequeña y amarilla, ciclo corto y sabor suave.',100,10.00,'2026-03-07 19:26:40','2026-03-25 21:42:35',0.3000),(10,'Zanahoria','Raíz naranja rica en carotenos, ciclo productivo estándar.',100,20.00,'2026-03-07 19:26:40','2026-03-25 21:42:35',0.0500),(11,'Fresa','Fruta roja pequeña, requiere suelos ácidos y buen riego.',120,0.80,'2026-03-07 19:26:40','2026-03-25 21:42:35',0.2500),(12,'Cacao Forastero','Variedad de cacao muy productiva y resistente.',1095,1.20,'2026-03-07 19:26:40','2026-03-25 21:42:35',9.0000),(13,'Plátano Hartón','Plátano de gran tamaño usado principalmente para cocinar.',300,14.00,'2026-03-07 19:26:40','2026-03-25 21:42:35',6.0000),(14,'Aguacate Hass','Variedad de aguacate con piel rugosa y alto contenido de aceite.',1460,8.00,'2026-03-07 19:26:40','2026-03-25 21:42:35',25.0000),(15,'Fríjol Cargamanto','Leguminosa de grano grande, muy apreciada en la región andina.',120,2.20,'2026-03-07 19:26:40','2026-03-25 21:42:35',0.2000),(16,'Lechuga Romana','Hortaliza de hojas alargadas, muy usada en ensaladas.',60,3.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.1000),(17,'Espinaca','Hortaliza de hojas verdes rica en hierro.',45,2.50,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.0800),(18,'Pepino','Fruto alargado y refrescante, de rápido crecimiento.',75,8.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.5000),(19,'Pimentón','Fruto dulce de colores variados.',100,6.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.4000),(20,'Ajo','Bulbo aromático usado como condimento.',150,5.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.1000),(21,'Brócoli','Hortaliza rica en nutrientes, tipo col.',90,4.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.4000),(22,'Coliflor','Hortaliza de inflorescencia blanca.',100,3.50,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.4000),(23,'Repollo','Hortaliza de hojas compactas en forma de bola.',110,4.50,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.5000),(24,'Yuca','Raíz tropical rica en carbohidratos.',300,20.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',1.0000),(25,'Batata','Tubérculo dulce también conocido como camote.',120,18.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.5000),(26,'Sandía','Fruta grande y jugosa, de clima cálido.',100,10.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',2.0000),(27,'Melón','Fruta dulce de pulpa aromática.',90,8.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',1.5000),(28,'Calabacín','Variedad de calabaza de fruto tierno.',60,6.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.6000),(29,'Calabaza','Fruto grande utilizado en múltiples preparaciones.',120,12.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',2.5000),(30,'Apio','Hortaliza de tallos largos y crujientes.',130,4.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.3000),(31,'Cilantro','Hierba aromática muy usada en cocina.',40,1.50,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.0500),(32,'Perejil','Hierba aromática de uso culinario.',70,1.20,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.0500),(33,'Albahaca','Hierba aromática muy usada en cocina italiana.',60,1.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.0800),(34,'Orégano','Planta aromática resistente.',80,0.80,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.1000),(35,'Lenteja','Leguminosa rica en proteínas.',110,1.80,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.1500),(36,'Garbanzo','Leguminosa muy nutritiva.',120,2.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.2000),(37,'Sorgo','Cereal resistente a sequía.',110,3.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.2500),(38,'Avena','Cereal usado en alimentación humana y animal.',120,2.50,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.2000),(39,'Trigo','Cereal base para harina.',130,3.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.2000),(40,'Uva','Fruta cultivada en vides, usada para consumo y vino.',365,10.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',3.0000),(41,'Mango','Fruta tropical dulce y jugosa.',1095,15.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',25.0000),(42,'Piña','Fruta tropical de sabor ácido-dulce.',540,2.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.6000),(43,'Papaya','Fruta tropical de rápido crecimiento.',300,20.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',4.0000),(44,'Guayaba','Fruta tropical rica en vitamina C.',720,18.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',9.0000),(45,'Maracuyá','Fruta ácida usada en jugos.',300,12.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',4.0000),(46,'Granadilla','Fruta dulce de cáscara dura.',270,10.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',4.0000),(47,'Arveja','Leguminosa de grano verde.',90,2.50,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.2000),(48,'Habichuela','Vaina verde comestible.',70,3.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.2000),(49,'Rábano','Raíz de crecimiento muy rápido.',30,1.50,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.0500),(50,'Remolacha','Raíz roja rica en nutrientes.',90,6.00,'2026-03-25 21:06:32','2026-03-25 21:42:35',0.1000);
/*!40000 ALTER TABLE `catalogo_semillas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogo_suelos`
--

DROP TABLE IF EXISTS `catalogo_suelos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogo_suelos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `impacto_dias` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `capacidad_retencion_litros_m2` decimal(10,2) NOT NULL DEFAULT 5.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_suelos`
--

LOCK TABLES `catalogo_suelos` WRITE;
/*!40000 ALTER TABLE `catalogo_suelos` DISABLE KEYS */;
INSERT INTO `catalogo_suelos` VALUES (1,'Arcilloso',5,'Suelo pesado con alta retención de humedad, pero drenaje lento.',NULL,'2026-03-07 19:27:51',5.00),(2,'Arenoso',-3,'Drenaje rápido, requiere riego frecuente, acelera ciclo en algunos cultivos.',NULL,'2026-03-07 19:27:51',5.00),(3,'Franco-Arenoso',0,NULL,NULL,NULL,5.00),(4,'Limoso',0,'Suelo fértil con buena retención de nutrientes y humedad equilibrada.',NULL,'2026-03-07 19:27:51',5.00),(5,'Orgánico (Húmico)',-10,NULL,NULL,NULL,5.00),(6,'Franco',-1,'Mezcla ideal de arena, limo y arcilla para la mayoría de cultivos.','2026-03-07 19:27:51','2026-03-07 19:27:51',5.00),(7,'Salino',10,'Alta concentración de sales que retrasa el crecimiento vegetal.','2026-03-07 19:27:51','2026-03-07 19:27:51',5.00),(8,'Turba / Orgánico',-2,'Extremadamente fértil y rico en materia orgánica.','2026-03-07 19:27:51','2026-03-07 19:27:51',5.00);
/*!40000 ALTER TABLE `catalogo_suelos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cosecha`
--

DROP TABLE IF EXISTS `cosecha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cosecha` (
  `id_cosecha` int(11) NOT NULL AUTO_INCREMENT,
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
  `litros_por_riego` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_cosecha`),
  KEY `cosecha_terreno_fk` (`id_terreno`),
  KEY `cosecha_semilla_fk` (`id_semilla`),
  KEY `cosecha_estado_fk` (`id_estado`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `cosecha_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `cosecha_ibfk_2` FOREIGN KEY (`id_terreno`) REFERENCES `terreno` (`id_terreno`),
  CONSTRAINT `cosecha_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `cosecha_ibfk_4` FOREIGN KEY (`id_semilla`) REFERENCES `tipo_semilla` (`id_semilla`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cosecha`
--

LOCK TABLES `cosecha` WRITE;
/*!40000 ALTER TABLE `cosecha` DISABLE KEYS */;
/*!40000 ALTER TABLE `cosecha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cultivo`
--

DROP TABLE IF EXISTS `cultivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cultivo` (
  `id_cultivo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_recoleccion` date DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `documento_trabajador` int(11) NOT NULL,
  `descripcion_recoleccion` text NOT NULL,
  PRIMARY KEY (`id_cultivo`),
  KEY `id_cosecha` (`id_cosecha`),
  KEY `id_trabajador` (`documento_trabajador`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `cultivo_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_cultivo_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  CONSTRAINT `fk_cultivo_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cultivo`
--

LOCK TABLES `cultivo` WRITE;
/*!40000 ALTER TABLE `cultivo` DISABLE KEYS */;
/*!40000 ALTER TABLE `cultivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_producto_cultivo`
--

DROP TABLE IF EXISTS `detalle_producto_cultivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_producto_cultivo` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_cultivo` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `calidad` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_cultivo` (`id_cultivo`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `fk_detalle_producto_cultivo_cultivo` FOREIGN KEY (`id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  CONSTRAINT `fk_detalle_producto_cultivo_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_producto_cultivo`
--

LOCK TABLES `detalle_producto_cultivo` WRITE;
/*!40000 ALTER TABLE `detalle_producto_cultivo` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_producto_cultivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `id_empresa` varchar(14) NOT NULL,
  `nombre_empresa` varchar(200) NOT NULL,
  `nombre_repre_legal` varchar(100) NOT NULL,
  `cedula_repre` int(11) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_empresa`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `fk_empresa_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES ('986577464','Pruebas SAS','Juan gomez',88756512,'3103527221','r93281703@gmail.com','Vereda El Silon Cajamarca','2026-04-01 11:03:30',1);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrada_insumo`
--

DROP TABLE IF EXISTS `entrada_insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entrada_insumo` (
  `id_entrada` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `id_semilla` int(11) DEFAULT NULL,
  `id_empresa` varchar(14) NOT NULL,
  `stock_antes` decimal(10,2) DEFAULT NULL,
  `stock_despues` decimal(10,2) DEFAULT NULL,
  `tipo_movimiento` varchar(20) DEFAULT NULL,
  `cantidad_recibida` decimal(10,2) NOT NULL,
  `fecha_entrada` timestamp NOT NULL DEFAULT current_timestamp(),
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_entrada`),
  KEY `fk_entrada_proveedor` (`id_proveedor`),
  KEY `fk_entrada_insumo` (`id_insumo`),
  KEY `id_semilla` (`id_semilla`),
  KEY `fk_entrada_insumo_empresa` (`id_empresa`),
  CONSTRAINT `fk_entrada_insumo_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `fk_entrada_insumo_insumo` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`),
  CONSTRAINT `fk_entrada_insumo_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  CONSTRAINT `fk_entrada_insumo_semilla` FOREIGN KEY (`id_semilla`) REFERENCES `tipo_semilla` (`id_semilla`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrada_insumo`
--

LOCK TABLES `entrada_insumo` WRITE;
/*!40000 ALTER TABLE `entrada_insumo` DISABLE KEYS */;
/*!40000 ALTER TABLE `entrada_insumo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`u716029766_rootagro`@`%`*/ /*!50003 TRIGGER `trg_entrada_insumo` BEFORE INSERT ON `entrada_insumo` FOR EACH ROW BEGIN
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

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'pendiente'),(2,'bloqueada'),(3,'activa'),(5,'aprobada'),(6,'ocupado'),(7,'disponible'),(8,'suspendido'),(10,'Siembra'),(11,'Vegetativo'),(12,'Floración'),(13,'Llenado'),(14,'Cosecha'),(15,'Realizado'),(16,'Perdida'),(17,'En Proceso'),(18,'Perdida Oculta'),(19,'Retrasó');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_trabajador`
--

DROP TABLE IF EXISTS `estado_trabajador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_trabajador` (
  `id_estado_trabajador` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado_trabajador`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_trabajador`
--

LOCK TABLES `estado_trabajador` WRITE;
/*!40000 ALTER TABLE `estado_trabajador` DISABLE KEYS */;
INSERT INTO `estado_trabajador` VALUES (1,'Disponible'),(2,'Ocupado'),(3,'En Proceso'),(4,'Fuera de Servicio');
/*!40000 ALTER TABLE `estado_trabajador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fases_programadas`
--

DROP TABLE IF EXISTS `fases_programadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fases_programadas` (
  `id_fase` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  `fecha_programada` datetime DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `id_terreno` int(11) NOT NULL,
  PRIMARY KEY (`id_fase`),
  KEY `id_usuario` (`documento_trabajador`),
  KEY `id_cosecha` (`id_terreno`),
  KEY `fk_fases_estado` (`id_estado`),
  CONSTRAINT `fases_programadas_ibfk_1` FOREIGN KEY (`id_terreno`) REFERENCES `terreno` (`id_terreno`),
  CONSTRAINT `fk_fases_programadas_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_fases_programadas_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fases_programadas`
--

LOCK TABLES `fases_programadas` WRITE;
/*!40000 ALTER TABLE `fases_programadas` DISABLE KEYS */;
/*!40000 ALTER TABLE `fases_programadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insumo`
--

DROP TABLE IF EXISTS `insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insumo` (
  `ID_insumo` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` varchar(20) DEFAULT NULL,
  `id_catalogo_insumo` int(11) DEFAULT NULL,
  `stock_actual` decimal(10,2) DEFAULT 0.00,
  `Nombre` varchar(100) DEFAULT NULL,
  `Fecha_vencimiento` date DEFAULT NULL,
  `descripcion` text NOT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `id_proveedor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID_insumo`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `fk_insumo_al_catalogo` (`id_catalogo_insumo`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `fk_insumo_catalogo_insumos` FOREIGN KEY (`id_catalogo_insumo`) REFERENCES `catalogo_insumos` (`id_catalogo_insumo`),
  CONSTRAINT `fk_insumo_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `fk_insumo_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  CONSTRAINT `insumo_ibfk_1` FOREIGN KEY (`id_catalogo_insumo`) REFERENCES `catalogo_insumos` (`id_catalogo_insumo`),
  CONSTRAINT `insumo_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumo`
--

LOCK TABLES `insumo` WRITE;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` VALUES (10,'986577464',11,0.00,'Abono Orgánico Compost',NULL,'Materia orgánica para mejorar el suelo',10,NULL,'2026-04-01 04:22:31','2026-04-01 04:22:31');
/*!40000 ALTER TABLE `insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insumo_cosecha`
--

DROP TABLE IF EXISTS `insumo_cosecha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insumo_cosecha` (
  `id_insumo_cosecha` int(11) NOT NULL AUTO_INCREMENT,
  `id_cosecha` int(11) DEFAULT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `cantidad_usada` decimal(10,2) DEFAULT NULL,
  `observaciones` text NOT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `fecha_programada` datetime DEFAULT NULL,
  PRIMARY KEY (`id_insumo_cosecha`),
  KEY `fk_insumo_cosecha_c` (`id_cosecha`),
  KEY `fk_insumo_cosecha_i` (`id_insumo`),
  KEY `fk_ins_cos_trabajador` (`documento_trabajador`),
  KEY `fk_ins_cos_estado_gral` (`id_estado`),
  CONSTRAINT `fk_insumo_cosecha_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  CONSTRAINT `fk_insumo_cosecha_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_insumo_cosecha_insumo` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`),
  CONSTRAINT `fk_insumo_cosecha_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumo_cosecha`
--

LOCK TABLES `insumo_cosecha` WRITE;
/*!40000 ALTER TABLE `insumo_cosecha` DISABLE KEYS */;
/*!40000 ALTER TABLE `insumo_cosecha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_02_09_181957_create_tipo_licencias_table',2),(5,'2026_02_11_192209_add_id_tipo_licencia_to_solicitud_compra_table',2),(6,'2026_02_11_192642_add_foreign_key_to_solicitud_compra_table',3),(7,'2026_02_17_232000_add_nit_empresa_to_solicitud_compra_table',4),(8,'2026_02_19_000000_make_comprobante_pago_nullable_in_solicitud_compra',4),(9,'2026_02_23_212705_create_riegos_table',4),(10,'2026_02_27_191836_change_documento_to_bigint_in_usuario_table',5),(11,'2026_02_27_192702_fix_tipo_cosecha_riego_foreign_keycommunity',6),(12,'2026_03_06_000001_add_id_empresa_to_tipo_semilla',6),(13,'2026_03_06_000002_add_id_empresa_to_tipo_riego',6),(14,'2026_03_06_000003_add_id_empresa_to_tipo_cosecha',6),(15,'2026_03_06_000004_add_id_empresa_to_cosecha',6),(16,'2026_03_07_000000_add_id_empresa_to_multiple_tables',7),(17,'2026_03_07_000001_create_catalogs_tables',8),(18,'2026_03_07_000002_create_irrigation_catalog',9),(19,'2026_03_07_000003_add_impact_to_irrigation',10),(20,'2026_03_07_000004_add_description_to_soil_catalog',11),(21,'2026_03_07_000005_add_formal_foreign_keys_to_catalogs',12),(22,'2026_03_10_145541_add_id_empresa_to_insumo_table',13),(23,'2026_03_09_000001_add_descripcion_to_tipo_suelo',14),(24,'2026_03_12_162911_add_hydration_fields_to_tables',15),(25,'2026_03_15_120413_insert_estados_fases_cosecha',16),(26,'2026_03_16_145658_add_evidencia_foto_to_fases_programadas_table',17),(27,'2026_03_16_145708_add_evidencia_foto_to_riego_table',17),(28,'2026_03_16_145712_add_evidencia_foto_to_insumos_cosechas_table',17),(29,'2026_03_17_000001_insert_en_proceso_estado',17),(30,'2026_03_19_141013_add_timestamps_to_insumo_and_terreno',18),(31,'2026_03_25_170000_add_ids_to_registro_trabajo_table',19),(32,'2026_03_27_162735_add_task_fields_to_cultivo_and_registro_trabajo',20),(33,'2026_03_27_150000_drop_redundant_columns',21),(34,'2026_03_27_171743_add_descripcion_to_producto_table',22),(35,'2026_03_25_103434_fix_terreno_area_precision',23),(36,'2026_03_25_162551_add_id_terreno_to_fases_programadas_table',24),(37,'2026_03_27_140000_fix_registro_trabajo_nullability',24),(38,'2026_03_29_001608_fix_registro_trabajo_foreign_keys_and_data',24);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `Codigo_Referencia` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `ID_insumo` int(11) DEFAULT NULL,
  `id_empresa` varchar(14) NOT NULL,
  PRIMARY KEY (`id_proveedor`),
  KEY `ID_insumo` (`ID_insumo`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `fk_proveedor_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (4,'David Reyes','Semillas','3120821321',NULL,'986577464');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_trabajo`
--

DROP TABLE IF EXISTS `registro_trabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_trabajo` (
  `id_registro_trabajo` int(11) NOT NULL AUTO_INCREMENT,
  `id_insumo_cosecha` int(11) DEFAULT NULL,
  `id_cultivo` int(11) DEFAULT NULL,
  `id_fase` int(11) DEFAULT NULL,
  `id_riego` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `fecha_trabajada` date NOT NULL,
  `foto_evidencia` varchar(255) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_registro_trabajo`),
  UNIQUE KEY `unique_registro_trabajo` (`id_insumo_cosecha`,`documento_trabajador`,`fecha_trabajada`),
  KEY `fk_registro_trabajo_usuario` (`documento_trabajador`),
  KEY `id_fase` (`id_fase`),
  KEY `id_riego` (`id_riego`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `registro_trabajo_documento_trabajador_foreign` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`),
  CONSTRAINT `registro_trabajo_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `registro_trabajo_id_fase_foreign` FOREIGN KEY (`id_fase`) REFERENCES `fases_programadas` (`id_fase`) ON DELETE SET NULL,
  CONSTRAINT `registro_trabajo_id_insumo_cosecha_foreign` FOREIGN KEY (`id_insumo_cosecha`) REFERENCES `insumo_cosecha` (`id_insumo_cosecha`) ON DELETE SET NULL,
  CONSTRAINT `registro_trabajo_id_riego_foreign` FOREIGN KEY (`id_riego`) REFERENCES `riego` (`id_riego`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_trabajo`
--

LOCK TABLES `registro_trabajo` WRITE;
/*!40000 ALTER TABLE `registro_trabajo` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_trabajo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riego`
--

DROP TABLE IF EXISTS `riego`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `riego` (
  `id_riego` int(11) NOT NULL AUTO_INCREMENT,
  `cant_agua_apl` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `id_tipo_riego` int(11) DEFAULT NULL,
  `id_cosecha` int(11) DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `fecha_programada` datetime DEFAULT NULL,
  PRIMARY KEY (`id_riego`),
  KEY `id_tipo_riego` (`id_tipo_riego`),
  KEY `fk_riego_cosecha` (`id_cosecha`),
  KEY `fk_riego_trabajador` (`documento_trabajador`),
  KEY `fk_riego_estado_gral` (`id_estado`),
  CONSTRAINT `fk_riego_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  CONSTRAINT `fk_riego_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_riego_tipo_riego` FOREIGN KEY (`id_tipo_riego`) REFERENCES `tipo_riego` (`id_tipo_riego`),
  CONSTRAINT `fk_riego_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riego`
--

LOCK TABLES `riego` WRITE;
/*!40000 ALTER TABLE `riego` DISABLE KEYS */;
/*!40000 ALTER TABLE `riego` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salario`
--

DROP TABLE IF EXISTS `salario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salario` (
  `id_salario` int(11) NOT NULL AUTO_INCREMENT,
  `documento_trabajador` int(11) NOT NULL,
  `descripcion_pago` varchar(255) DEFAULT NULL,
  `cantidad_pago` decimal(10,2) NOT NULL,
  `unidad_pago` varchar(50) DEFAULT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `id_tipo_salario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_salario`),
  KEY `id_tipo_salario` (`id_tipo_salario`),
  KEY `documento_trabajador` (`documento_trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salario`
--

LOCK TABLES `salario` WRITE;
/*!40000 ALTER TABLE `salario` DISABLE KEYS */;
/*!40000 ALTER TABLE `salario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6XJCjJF3gWdxuZKLpKN99QqPSlWkVihjG9vj9l88',1105461467,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTHh4b1dsYWVGODJjOVZXekNzR09QRlVSbTk5eWlWWURpclJYQWhDYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFiYWphZG9yL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoyMDoidHJhYmFqYWRvci5kYXNoYm9hcmQiO31zOjU0OiJsb2dpbl91c3VhcmlvXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTEwNTQ2MTQ2Nzt9',1775180491),('lpJrHMiLnK60qVEExGKNaXLDk7qksGFeDnIHKLeD',1039253243,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQnlNRGowRjBQS0dPcmdzUXozTTI3M1JMYkg5bVhWNVZDN1R0OWp5QSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFiYWphZG9yL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoyMDoidHJhYmFqYWRvci5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU0OiJsb2dpbl91c3VhcmlvXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzOTI1MzI0Mzt9',1775005300),('PCrGg0iytEmhjbTaaZWoXPXp1CttCs1kA3mqccW3',1110722345,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRzRteDR2blNDNklJNmZ3eGRFSW1IdUpVMUMzMW5Mbzd1cEJSWDdVOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTQ6ImxvZ2luX3VzdWFyaW9fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTEwNzIyMzQ1O30=',1775005353),('wweMghpq9QGZVMk4ehnbR0rbaTX93ycujE2GaQ0Z',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ0trV0RGTUlzUUhvbnFmZTlvNDV4cEJqNTB6cEJDN090QWxST0E4OSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3RyYWJhamFkb3IvY2FsZW5kYXJpbyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO3M6NToicm91dGUiO3M6MTM6InVzdWFyaW8ubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1775180300);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud_compra`
--

DROP TABLE IF EXISTS `solicitud_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitud_compra` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` varchar(14) NOT NULL,
  `comprobante_pago` varchar(255) DEFAULT NULL,
  `id_tipo_licencia` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `fecha_revision` datetime DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`),
  KEY `fk_solicitud_estado` (`id_estado`),
  KEY `solicitud_compra_id_tipo_licencia_foreign` (`id_tipo_licencia`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `solicitud_compra_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `solicitud_compra_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `solicitud_compra_id_tipo_licencia_foreign` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_compra`
--

LOCK TABLES `solicitud_compra` WRITE;
/*!40000 ALTER TABLE `solicitud_compra` DISABLE KEYS */;
INSERT INTO `solicitud_compra` VALUES (34,'986577464','comprobantes/1775059410.jpeg',2,1,'2026-04-01 11:03:30',NULL);
/*!40000 ALTER TABLE `solicitud_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soporte`
--

DROP TABLE IF EXISTS `soporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soporte` (
  `id_soporte` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `documento_trabajador` int(11) NOT NULL,
  `id_empresa` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `respuesta` text DEFAULT NULL,
  `estado` varchar(255) DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_soporte`),
  KEY `documento_trabajador` (`documento_trabajador`),
  KEY `id_empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soporte`
--

LOCK TABLES `soporte` WRITE;
/*!40000 ALTER TABLE `soporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `soporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `super_admin`
--

DROP TABLE IF EXISTS `super_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `super_admin` (
  `id_super_admin` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_super_admin`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `correo` (`correo`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `super_admin_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=1110495790 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `super_admin`
--

LOCK TABLES `super_admin` WRITE;
/*!40000 ALTER TABLE `super_admin` DISABLE KEYS */;
INSERT INTO `super_admin` VALUES (121121222,'Sebastian Garcia','sebas','sebastiangarciaalvarez123@gmail.com','$2y$12$wxkiFbavbM02DPokAhMCZuCrHOadp.IGAdu.gNHsNMwx2r7MegS.O',3,NULL,'2026-02-17 02:13:13','2026-04-01 13:55:24','L1p7Xl1fPkixGMruJlpTqQJQwcapiWgGAROURB9Si1QAAw5Wu4f5fbNXeKa1',NULL,'2026-04-01 08:37:17'),(1006511657,'Brayan Basto','Stevan','bastobrayan246@gmail.com','$2y$12$Qh0yFs6SfldIhbRSw2gfguC8OukaAtB1KnOBga5XY/dKXi.2070X.',3,NULL,'2026-02-10 03:51:59','2026-04-01 09:28:44','rA9Y8AAJ0MOymURHR2izU5nVWGA1tHGBhuwKN8zwRSGF77mgJadJy9qmMzoX',NULL,'2026-02-13 02:07:57'),(1110495789,'Didier Reyes','dires123','didierreyes003@gmail.com','$2y$12$C.1.zfPi1fc6iwv.4HY37uaNPqDjle.6usU8KUFTpkyDnfOOwW2ji',3,NULL,'2026-02-09 19:43:33','2026-04-01 16:18:19','i71HLMMDok9bpDH4AGGp8B4DFpU6oydu04kHkKnVs20aFkI6rYdsmiw0Tp4u',NULL,'2026-04-01 09:32:59');
/*!40000 ALTER TABLE `super_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terreno`
--

DROP TABLE IF EXISTS `terreno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `terreno` (
  `id_terreno` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_terreno`),
  KEY `id_estado` (`id_estado`),
  KEY `terreno_tipo_suelo_fk` (`id_tipo_suelo`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `terreno_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `terreno_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terreno`
--

LOCK TABLES `terreno` WRITE;
/*!40000 ALTER TABLE `terreno` DISABLE KEYS */;
INSERT INTO `terreno` VALUES (15,'986577464','lote 1','Finca la plata',4.17091666,-74.64364162,100,50,5000.00,'Tolima','Melgar',734001,7,7,'2026-04-01 04:23:14','2026-04-01 04:23:14');
/*!40000 ALTER TABLE `terreno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_insumo`
--

DROP TABLE IF EXISTS `tipo_insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_insumo` (
  `id_tipo_insumo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `id_empresa` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_insumo`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `tipo_insumo_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_insumo`
--

LOCK TABLES `tipo_insumo` WRITE;
/*!40000 ALTER TABLE `tipo_insumo` DISABLE KEYS */;
INSERT INTO `tipo_insumo` VALUES (1,'Fertilizante',NULL),(2,'Abono',NULL),(3,'Fungicida',NULL),(4,'Herbicida',NULL),(6,'Fertilizantes',NULL),(7,'Agroquímicos',NULL),(8,'Herramientas',NULL),(9,'Lubricantes',NULL),(10,'Pesticida',NULL);
/*!40000 ALTER TABLE `tipo_insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_licencia`
--

DROP TABLE IF EXISTS `tipo_licencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_licencia` (
  `id_tipo_licencia` int(14) NOT NULL,
  `nombre_licencia` varchar(50) NOT NULL,
  `tiempo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(15,2) NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo_licencia`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_licencia`
--

LOCK TABLES `tipo_licencia` WRITE;
/*!40000 ALTER TABLE `tipo_licencia` DISABLE KEYS */;
INSERT INTO `tipo_licencia` VALUES (1,'Basico','1 Mes','24 Horas De Soporte',100000.00,1),(2,'Medium','6 Meses','24 Horas De Soporte',600000.00,1),(3,'Profesional','1 Año','24 Horas De Soporte',1200000.00,1);
/*!40000 ALTER TABLE `tipo_licencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_riego`
--

DROP TABLE IF EXISTS `tipo_riego`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_riego` (
  `id_tipo_riego` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) unsigned DEFAULT NULL,
  `tipo_riego` varchar(50) DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  PRIMARY KEY (`id_tipo_riego`),
  KEY `id_empresa` (`id_empresa`),
  KEY `tipo_riego_id_catalogo_foreign` (`id_catalogo`),
  CONSTRAINT `tipo_riego_id_catalogo_foreign` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_riegos` (`id`),
  CONSTRAINT `tipo_riego_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_riego`
--

LOCK TABLES `tipo_riego` WRITE;
/*!40000 ALTER TABLE `tipo_riego` DISABLE KEYS */;
INSERT INTO `tipo_riego` VALUES (12,'986577464',2,'Aspersión',0);
/*!40000 ALTER TABLE `tipo_riego` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_salario`
--

DROP TABLE IF EXISTS `tipo_salario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_salario` (
  `id_tipo_salario` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_salario` varchar(100) NOT NULL,
  PRIMARY KEY (`id_tipo_salario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_salario`
--

LOCK TABLES `tipo_salario` WRITE;
/*!40000 ALTER TABLE `tipo_salario` DISABLE KEYS */;
INSERT INTO `tipo_salario` VALUES (1,'Diario'),(2,'Semanal'),(3,'Quincenal'),(4,'Mensual'),(5,'Por Obra/Labor');
/*!40000 ALTER TABLE `tipo_salario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_semilla`
--

DROP TABLE IF EXISTS `tipo_semilla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_semilla` (
  `id_semilla` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) unsigned DEFAULT NULL,
  `nombre_semilla` varchar(100) DEFAULT NULL,
  `tiempo_base_dias` int(11) DEFAULT NULL,
  `descripcion` varchar(250) NOT NULL,
  `rendimiento_promedio` decimal(10,2) DEFAULT NULL,
  `stock_actual` decimal(10,2) DEFAULT 0.00,
  `espacio_por_planta_m2` decimal(10,4) DEFAULT 0.2500,
  PRIMARY KEY (`id_semilla`),
  KEY `id_empresa` (`id_empresa`),
  KEY `tipo_semilla_id_catalogo_foreign` (`id_catalogo`),
  CONSTRAINT `tipo_semilla_id_catalogo_foreign` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_semillas` (`id`),
  CONSTRAINT `tipo_semilla_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_semilla`
--

LOCK TABLES `tipo_semilla` WRITE;
/*!40000 ALTER TABLE `tipo_semilla` DISABLE KEYS */;
INSERT INTO `tipo_semilla` VALUES (9,'986577464',42,'Piña',540,'Fruta tropical de sabor ácido-dulce.',2.00,0.00,0.6000);
/*!40000 ALTER TABLE `tipo_semilla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_suelo`
--

DROP TABLE IF EXISTS `tipo_suelo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_suelo` (
  `id_tipo_suelo` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` varchar(14) DEFAULT NULL,
  `id_catalogo` bigint(20) unsigned DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `impacto_dias` int(11) DEFAULT 0,
  `capacidad_retencion_litros_m2` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_suelo`),
  KEY `id_empresa` (`id_empresa`),
  KEY `tipo_suelo_id_catalogo_foreign` (`id_catalogo`),
  CONSTRAINT `tipo_suelo_id_catalogo_foreign` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_suelos` (`id`),
  CONSTRAINT `tipo_suelo_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_suelo`
--

LOCK TABLES `tipo_suelo` WRITE;
/*!40000 ALTER TABLE `tipo_suelo` DISABLE KEYS */;
INSERT INTO `tipo_suelo` VALUES (7,'986577464',2,'Arenoso','Drenaje rápido, requiere riego frecuente, acelera ciclo en algunos cultivos.',-3,5.00);
/*!40000 ALTER TABLE `tipo_suelo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'administrador'),(2,'supervisor'),(3,'trabajador');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `id_estado_trabajador` int(11) DEFAULT 1,
  PRIMARY KEY (`documento`),
  KEY `id_tipo_usuario` (`id_tipo_usuario`),
  KEY `id_estado` (`id_estado`),
  KEY `id_empresa` (`id_empresa`),
  KEY `fk_usuario_estado_trabajador` (`id_estado_trabajador`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`id_estado_trabajador`) REFERENCES `estado_trabajador` (`id_estado_trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_licencias`
--

DROP TABLE IF EXISTS `venta_licencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta_licencias` (
  `id_key` varchar(14) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `observacione` text NOT NULL,
  `id_tipo_licencia` int(11) NOT NULL,
  `id_empresa` varchar(14) NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_key`),
  KEY `id_estado` (`id_estado`),
  KEY `id_tipo_licencia` (`id_tipo_licencia`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `venta_licencias_ibfk_1` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`),
  CONSTRAINT `venta_licencias_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `venta_licencias_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_licencias`
--

LOCK TABLES `venta_licencias` WRITE;
/*!40000 ALTER TABLE `venta_licencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_licencias` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-01 11:27:09
