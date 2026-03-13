-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: prueba_cultivos
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_insumos`
--

LOCK TABLES `catalogo_insumos` WRITE;
/*!40000 ALTER TABLE `catalogo_insumos` DISABLE KEYS */;
INSERT INTO `catalogo_insumos` VALUES (2,'Fertilizante NPK 15-15-15','Fertilizante equilibrado para todo tipo de cultivos',5,6),(3,'Urea Agrícola 46%','Fuente concentrada de nitrógeno',3,6),(4,'Pala Punta Huevo','Herramienta resistente para trabajo de campo',0,8),(5,'Machete 22 Pulgadas','Acero al carbono, ideal para desmonte',0,8),(6,'Aceite Motor Diesel 15W40','Lubricante para tractores y maquinaria pesada',0,9);
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_semillas`
--

LOCK TABLES `catalogo_semillas` WRITE;
/*!40000 ALTER TABLE `catalogo_semillas` DISABLE KEYS */;
INSERT INTO `catalogo_semillas` VALUES (1,'Tomate Chonto','Variedad de tomate muy resistente, ideal para salsas.',90,12.00,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(2,'Café Arábigo','Variedad premium de café con aroma intenso y acidez equilibrada.',210,1.50,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(3,'Maíz Amarillo','Cereal básico para la alimentación, ciclo corto.',120,3.50,NULL,NULL,0.2500),(4,'Papa Pastusa','Variedad de papa de textura harinosa, muy popular en Colombia.',135,25.00,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(5,'Cacao','Cultivo de clima cálido, base para el chocolate.',180,0.80,NULL,NULL,0.2500),(6,'Arroz','Cereal de inundación o secano, base de la dieta.',130,6.00,NULL,NULL,0.2500),(7,'Maíz Dulce','Maíz de grano tierno y dulce, ideal para consumo humano directo.',85,4.50,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(8,'Cebolla Cabezona','Bulbo de sabor fuerte, uso esencial en cocina.',120,15.00,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(9,'Papa Criolla','Papa pequeña y amarilla, ciclo corto y sabor suave.',110,10.00,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(10,'Zanahoria','Raíz naranja rica en carotenos, ciclo productivo estándar.',110,20.00,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(11,'Fresa','Fruta roja pequeña, requiere suelos ácidos y buen riego.',150,0.80,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(12,'Cacao Forastero','Variedad de cacao muy productiva y resistente.',165,1.20,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(13,'Plátano Hartón','Plátano de gran tamaño usado principalmente para cocinar.',360,14.00,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(14,'Aguacate Hass','Variedad de aguacate con piel rugosa y alto contenido de aceite.',240,8.00,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500),(15,'Fríjol Cargamanto','Leguminosa de grano grande, muy apreciada en la región andina.',140,2.20,'2026-03-07 19:26:40','2026-03-07 19:27:51',0.2500);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cosecha`
--

LOCK TABLES `cosecha` WRITE;
/*!40000 ALTER TABLE `cosecha` DISABLE KEYS */;
INSERT INTO `cosecha` VALUES (15,'988091212',49,4,3,1,'2026-03-13',1,'2026-06-13','cosechas/W3pEMwZRN7gqamGKRFcwI5rz1de0FQVw1L4TnD8s.jpg',588.00,2.00),(16,'988091212',1,5,3,1,'2026-03-13',1,'2026-06-13','cosechas/IkCPJMFjZPJ23habJCTizs7klv3e0CkYuHKWXHNr.jpg',12.00,2.00);
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
  `documento` int(11) NOT NULL,
  `cantidad_producida` decimal(10,2) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id_cultivo`),
  KEY `id_cosecha` (`id_cosecha`),
  KEY `id_trabajador` (`documento`),
  CONSTRAINT `fk_cultivo_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  CONSTRAINT `fk_cultivo_usuario` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cultivo`
--

LOCK TABLES `cultivo` WRITE;
/*!40000 ALTER TABLE `cultivo` DISABLE KEYS */;
/*!40000 ALTER TABLE `cultivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_cultivo`
--

DROP TABLE IF EXISTS `detalle_cultivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_cultivo` (
  `id_detalle_cultivo` int(11) NOT NULL AUTO_INCREMENT,
  `id_cultivo` int(11) DEFAULT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id_detalle_cultivo`),
  KEY `id_cultivo` (`id_cultivo`),
  KEY `id_insumo` (`id_insumo`),
  CONSTRAINT `fk_detalle_cultivo_cultivo` FOREIGN KEY (`id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  CONSTRAINT `fk_detalle_cultivo_insumo` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_cultivo`
--

LOCK TABLES `detalle_cultivo` WRITE;
/*!40000 ALTER TABLE `detalle_cultivo` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_cultivo` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
INSERT INTO `empresa` VALUES ('103455657789','Colombia','Sebas Alvarez',1006511653,'3103524334','sombrahdepaz76@gmail.com','MzN Casa 1 El_Pedregal','2026-02-25 23:20:02',3),('411234141412','Agro-Valle','didier reyes',1004546565,'2123141434','juansuaza1528@gmail.com','MzN Casa 1 El_Pedregal','2026-02-25 23:20:54',3),('834324234','Huila construye','Sebastian Rodriguez',1034334234,'3203242424','david@gmail.com','Carrera 10 # 20-32','2026-02-27 01:05:52',3),('876767657','Agro Huila','Sebas Martinez',1032342344,'3223243434','sombrahdepaz@gmail.com','CALLE 23 # 34-32','2026-03-01 19:50:43',3),('988091212','IBague medio','johan oeres',1110495788,'3103527239','johsn@gmail.com','MzN Casa# 1 Picaleña','2026-03-06 12:40:27',3),('989979777','Pereira Sas','Julio Profe',32092123,'3021212212','Julio@gmail.com','vereda cipqui','2026-03-03 13:41:00',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrada_insumo`
--

LOCK TABLES `entrada_insumo` WRITE;
/*!40000 ALTER TABLE `entrada_insumo` DISABLE KEYS */;
INSERT INTO `entrada_insumo` VALUES (1,1,2,NULL,'834324234',NULL,NULL,NULL,10.00,'2026-03-10 22:13:45',400000.00),(2,1,NULL,5,'834324234',NULL,NULL,NULL,14.00,'2026-03-10 22:15:41',14000.00);
/*!40000 ALTER TABLE `entrada_insumo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_entrada_insumo` BEFORE INSERT ON `entrada_insumo` FOR EACH ROW BEGIN
    DECLARE stock_anterior DECIMAL(10,2);

    SELECT stock_actual
    INTO stock_anterior
    FROM insumo
    WHERE ID_insumo = NEW.id_insumo;

    INSERT INTO historial_insumo(
        id_insumo,
        stock_antes,
        cantidad_movimiento,
        stock_despues,
        tipo_movimiento,
        fecha
    )
    VALUES(
        NEW.id_insumo,
        stock_anterior,
        NEW.cantidad_recibida,
        stock_anterior + NEW.cantidad_recibida,
        'ENTRADA',
        NOW()
    );

    UPDATE insumo
    SET stock_actual = stock_anterior + NEW.cantidad_recibida
    WHERE ID_insumo = NEW.id_insumo;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'pendiente'),(2,'bloqueada'),(3,'activa'),(5,'aprobada'),(6,'ocupado'),(7,'disponible'),(8,'suspendido');
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
  `fecha_programada` date DEFAULT NULL,
  `documento_trabajador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `id_cosecha` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_fase`),
  KEY `id_usuario` (`documento_trabajador`),
  KEY `id_cosecha` (`id_cosecha`),
  KEY `fk_fases_estado` (`id_estado`),
  CONSTRAINT `fk_fases_programadas_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  CONSTRAINT `fk_fases_programadas_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_fases_programadas_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  PRIMARY KEY (`ID_insumo`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `fk_insumo_al_catalogo` (`id_catalogo_insumo`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `fk_insumo_catalogo_insumos` FOREIGN KEY (`id_catalogo_insumo`) REFERENCES `catalogo_insumos` (`id_catalogo_insumo`),
  CONSTRAINT `fk_insumo_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `fk_insumo_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  CONSTRAINT `insumo_ibfk_1` FOREIGN KEY (`id_catalogo_insumo`) REFERENCES `catalogo_insumos` (`id_catalogo_insumo`),
  CONSTRAINT `insumo_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumo`
--

LOCK TABLES `insumo` WRITE;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` VALUES (2,'834324234',3,0.00,'Urea Agrícola 46%',NULL,'Fuente concentrada de nitrógeno',0,NULL),(5,'834324234',NULL,0.00,'dfdfg',NULL,'ghffjhjh',0,NULL),(6,'988091212',NULL,0.00,'Fertilizante por 4k',NULL,'Super mega fertilizante',2,NULL);
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
  `impacto_dias` int(11) DEFAULT 0,
  `fecha_programada` date DEFAULT NULL,
  `fecha_realizacion` date DEFAULT NULL,
  PRIMARY KEY (`id_insumo_cosecha`),
  KEY `fk_insumo_cosecha_c` (`id_cosecha`),
  KEY `fk_insumo_cosecha_i` (`id_insumo`),
  KEY `fk_ins_cos_trabajador` (`documento_trabajador`),
  KEY `fk_ins_cos_estado_gral` (`id_estado`),
  CONSTRAINT `fk_insumo_cosecha_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  CONSTRAINT `fk_insumo_cosecha_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_insumo_cosecha_insumo` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`ID_insumo`),
  CONSTRAINT `fk_insumo_cosecha_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_02_09_181957_create_tipo_licencias_table',2),(5,'2026_02_11_192209_add_id_tipo_licencia_to_solicitud_compra_table',2),(6,'2026_02_11_192642_add_foreign_key_to_solicitud_compra_table',3),(7,'2026_02_17_232000_add_nit_empresa_to_solicitud_compra_table',4),(8,'2026_02_19_000000_make_comprobante_pago_nullable_in_solicitud_compra',4),(9,'2026_02_23_212705_create_riegos_table',4),(10,'2026_02_27_191836_change_documento_to_bigint_in_usuario_table',5),(11,'2026_02_27_192702_fix_tipo_cosecha_riego_foreign_keycommunity',6),(12,'2026_03_06_000001_add_id_empresa_to_tipo_semilla',6),(13,'2026_03_06_000002_add_id_empresa_to_tipo_riego',6),(14,'2026_03_06_000003_add_id_empresa_to_tipo_cosecha',6),(15,'2026_03_06_000004_add_id_empresa_to_cosecha',6),(16,'2026_03_07_000000_add_id_empresa_to_multiple_tables',7),(17,'2026_03_07_000001_create_catalogs_tables',8),(18,'2026_03_07_000002_create_irrigation_catalog',9),(19,'2026_03_07_000003_add_impact_to_irrigation',10),(20,'2026_03_07_000004_add_description_to_soil_catalog',11),(21,'2026_03_07_000005_add_formal_foreign_keys_to_catalogs',12),(22,'2026_03_10_145541_add_id_empresa_to_insumo_table',13),(23,'2026_03_09_000001_add_descripcion_to_tipo_suelo',14),(24,'2026_03_12_162911_add_hydration_fields_to_tables',15);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'Juan ortiz','Fertilizante','3103527239',NULL,'834324234'),(2,'Agro Ferti','Fetilizantes','3201123122',NULL,'988091212'),(3,'Agro Semi','Semillas','312121212',NULL,'988091212');
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
  `documento_trabajador` int(11) NOT NULL,
  `fecha_trabajada` date NOT NULL,
  `foto_evidencia` varchar(255) DEFAULT NULL,
  `estado_aprobacion` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_registro_trabajo`),
  UNIQUE KEY `unique_registro_trabajo` (`id_insumo_cosecha`,`documento_trabajador`,`fecha_trabajada`),
  KEY `fk_registro_trabajo_usuario` (`documento_trabajador`),
  CONSTRAINT `fk_registro_trabajo_insumo_cosecha` FOREIGN KEY (`id_insumo_cosecha`) REFERENCES `insumo_cosecha` (`id_insumo_cosecha`),
  CONSTRAINT `fk_registro_trabajo_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_trabajo`
--

LOCK TABLES `registro_trabajo` WRITE;
/*!40000 ALTER TABLE `registro_trabajo` DISABLE KEYS */;
INSERT INTO `registro_trabajo` VALUES (16,NULL,1105461467,'2026-03-19','evidencias/Quk6Vto5Dh48UZUvqvnHq7P9XlO1XbTyPora7Juu.png','pendiente','trabajo','2026-03-12 01:34:36'),(17,NULL,1105461467,'2026-03-13','evidencias/UoEiLyHQl9hj3oFtzxLr1nJdyA83AugvK2Oryja7.png','pendiente','9poikjuhygtrf','2026-03-12 19:08:34');
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
  `fecha_programada` date DEFAULT NULL,
  PRIMARY KEY (`id_riego`),
  KEY `id_tipo_riego` (`id_tipo_riego`),
  KEY `fk_riego_cosecha` (`id_cosecha`),
  KEY `fk_riego_trabajador` (`documento_trabajador`),
  KEY `fk_riego_estado_gral` (`id_estado`),
  CONSTRAINT `fk_riego_cosecha` FOREIGN KEY (`id_cosecha`) REFERENCES `cosecha` (`id_cosecha`),
  CONSTRAINT `fk_riego_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_riego_tipo_riego` FOREIGN KEY (`id_tipo_riego`) REFERENCES `tipo_riego` (`id_tipo_riego`),
  CONSTRAINT `fk_riego_usuario` FOREIGN KEY (`documento_trabajador`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  `descripcion_pago` varchar(255) DEFAULT NULL,
  `cantidad_pago` decimal(10,2) NOT NULL,
  `unidad_pago` varchar(50) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `id_tipo_salario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_salario`),
  KEY `id_tipo_salario` (`id_tipo_salario`),
  CONSTRAINT `fk_salario_tipo_salario` FOREIGN KEY (`id_tipo_salario`) REFERENCES `tipo_salario` (`id_tipo_salario`)
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
INSERT INTO `sessions` VALUES ('7e8xIbZ5A39CBiHpApxqL3TN5pGO4DehfKbZT3JI',1110722345,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMEdNWGRpM2FUYzE3WU40S2dwWW9nUmFlSlYwRG13eU5hVkF0TmtWRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb3NlY2hhcyI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4uY29zZWNoYXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU0OiJsb2dpbl91c3VhcmlvXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTExMDcyMjM0NTt9',1773435064),('GkdkpbpV4627uQOo18l8RtIrvjLxoIqbdddOYjLO',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZDNoSWJBSm1qd0V1NFpiUlZaNVpZbUNLUHB6UXRmWVQyMm1YdGZ2eCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMzoidXN1YXJpby5sb2dpbiI7fXM6NTQ6ImxvZ2luX3VzdWFyaW9fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTEwNzIyMzMxO30=',1773354883);
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
  CONSTRAINT `fk_solicitud_compra_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `fk_solicitud_compra_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_solicitud_compra_tipo_licencia` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`),
  CONSTRAINT `solicitud_compra_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `solicitud_compra_ibfk_2` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`),
  CONSTRAINT `solicitud_compra_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_compra`
--

LOCK TABLES `solicitud_compra` WRITE;
/*!40000 ALTER TABLE `solicitud_compra` DISABLE KEYS */;
INSERT INTO `solicitud_compra` VALUES (23,'103455657789','comprobantes/1772079602.png',2,5,'2026-02-25 23:20:02','2026-02-25 23:21:55'),(24,'411234141412','comprobantes/1772079654.png',1,5,'2026-02-25 23:20:54','2026-02-25 23:27:15'),(25,'834324234',NULL,3,5,'2026-02-27 01:05:52','2026-02-27 01:05:52'),(26,'876767657',NULL,2,5,'2026-03-01 19:50:43','2026-03-01 19:50:43'),(27,'989979777',NULL,1,5,'2026-03-03 13:41:00','2026-03-03 13:41:00'),(28,'988091212',NULL,2,5,'2026-03-06 12:40:27','2026-03-06 12:40:27');
/*!40000 ALTER TABLE `solicitud_compra` ENABLE KEYS */;
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
  CONSTRAINT `fk_super_admin_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=1110495790 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `super_admin`
--

LOCK TABLES `super_admin` WRITE;
/*!40000 ALTER TABLE `super_admin` DISABLE KEYS */;
INSERT INTO `super_admin` VALUES (121121222,'Sebastian Garcia','sebas','sebastiangarciaalvarez123@gmail.com','$2y$12$YoWr9W3m9DTOdIq9lQl5v.UUywmt.V8dWL.E6.BS8jtcLy9xzzoPG',3,NULL,'2026-02-17 02:13:13','2026-02-17 02:13:13',NULL,NULL,NULL),(1006511657,'Brayan Basto','Stevan','bastobrayan246@gmail.com','$2y$12$Qh0yFs6SfldIhbRSw2gfguC8OukaAtB1KnOBga5XY/dKXi.2070X.',3,NULL,'2026-02-10 03:51:59','2026-02-27 06:08:38','0CqKzqc1RBu5ZsV0zQxXdhO0KXCywQsdg9CjSTg6YJtNAOrMw3P8ID8DgRa5',NULL,'2026-02-13 02:07:57'),(1110495789,'Didier Reyes','dires123','didierreyes003@gmail.com','$2y$12$clokDFJH4WGM0yZX.78S3OjOSjWUpkLoM/YGC47PorfBCOiE/88vm',3,NULL,'2026-02-09 19:43:33','2026-03-06 17:47:16','hukS0m7pICMEA3EaqY0OeMIQkf0xjDEh6BR0R2L7NLVRuLT7snbUzEehA5cY',NULL,'2026-03-03 17:46:06');
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
  `area_m2` decimal(8,2) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_tipo_suelo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_terreno`),
  KEY `id_estado` (`id_estado`),
  KEY `terreno_tipo_suelo_fk` (`id_tipo_suelo`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `fk_terreno_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `fk_terreno_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_terreno_tipo_suelo` FOREIGN KEY (`id_tipo_suelo`) REFERENCES `tipo_suelo` (`id_tipo_suelo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terreno`
--

LOCK TABLES `terreno` WRITE;
/*!40000 ALTER TABLE `terreno` DISABLE KEYS */;
INSERT INTO `terreno` VALUES (3,'834324234','Cascada','Cascada del potrero las tribunas',NULL,NULL,123,76,NULL,7,2),(4,'988091212','Parcela Norte','Verdecito',NULL,NULL,123,76,NULL,7,1),(5,'988091212','Parcela Sur','Verdecito',NULL,NULL,123,76,NULL,7,1),(6,'834324234','sebas',NULL,7.56072491,-73.06678310,400,500,NULL,7,2);
/*!40000 ALTER TABLE `terreno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_insumo`
--

DROP TABLE IF EXISTS `tipo_insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_insumo` (
  `id_tipo_insumo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tipo_insumo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_insumo`
--

LOCK TABLES `tipo_insumo` WRITE;
/*!40000 ALTER TABLE `tipo_insumo` DISABLE KEYS */;
INSERT INTO `tipo_insumo` VALUES (1,'Fertilizante'),(2,'Abono'),(3,'Fungicida'),(4,'Herbicida'),(6,'Fertilizantes'),(7,'Agroquímicos'),(8,'Herramientas'),(9,'Lubricantes');
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
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `fk_tipo_licencia_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_licencia`
--

LOCK TABLES `tipo_licencia` WRITE;
/*!40000 ALTER TABLE `tipo_licencia` DISABLE KEYS */;
INSERT INTO `tipo_licencia` VALUES (1,'Basico','1 Mes','24 Horas De Soporte',50000.00,1),(2,'Medium','6 Meses','24 Horas De Soporte',300000.00,1),(3,'Profesional','1 Año','24 Horas De Soporte',600000.00,1);
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
  CONSTRAINT `fk_tipo_riego_catalogo_riegos` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_riegos` (`id`),
  CONSTRAINT `fk_tipo_riego_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `tipo_riego_ibfk_1` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_riegos` (`id`),
  CONSTRAINT `tipo_riego_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_riego`
--

LOCK TABLES `tipo_riego` WRITE;
/*!40000 ALTER TABLE `tipo_riego` DISABLE KEYS */;
INSERT INTO `tipo_riego` VALUES (4,'988091212',1,'Goteo',-3),(5,'988091212',2,'Aspersión',0),(6,'834324234',2,'Aspersión',0),(8,'834324234',NULL,'ghghgh',2);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_salario`
--

LOCK TABLES `tipo_salario` WRITE;
/*!40000 ALTER TABLE `tipo_salario` DISABLE KEYS */;
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
  CONSTRAINT `fk_tipo_semilla_catalogo_semillas` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_semillas` (`id`),
  CONSTRAINT `fk_tipo_semilla_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `tipo_semilla_ibfk_1` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_semillas` (`id`),
  CONSTRAINT `tipo_semilla_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_semilla`
--

LOCK TABLES `tipo_semilla` WRITE;
/*!40000 ALTER TABLE `tipo_semilla` DISABLE KEYS */;
INSERT INTO `tipo_semilla` VALUES (3,'988091212',1,'Tomate Chonto',90,'Variedad de tomate muy resistente, ideal para salsas.',12.00,0.00,0.2500),(4,'988091212',3,'Maíz Amarillo',120,'Cereal básico para la alimentación, ciclo corto.',3.50,0.00,0.2500),(5,'834324234',2,'Café Arábigo',210,'Variedad premium de café con aroma intenso y acidez equilibrada.',1.50,0.00,0.2500),(6,'834324234',NULL,'fiojsdjkofa',210,'dkoaskdas',1.20,0.00,0.2500);
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
  `consumo_agua_ideal` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_suelo`),
  KEY `id_empresa` (`id_empresa`),
  KEY `tipo_suelo_id_catalogo_foreign` (`id_catalogo`),
  CONSTRAINT `fk_tipo_suelo_catalogo_suelos` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_suelos` (`id`),
  CONSTRAINT `fk_tipo_suelo_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `tipo_suelo_ibfk_1` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo_suelos` (`id`),
  CONSTRAINT `tipo_suelo_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_suelo`
--

LOCK TABLES `tipo_suelo` WRITE;
/*!40000 ALTER TABLE `tipo_suelo` DISABLE KEYS */;
INSERT INTO `tipo_suelo` VALUES (1,'988091212',1,'Arcilloso',NULL,5,NULL),(2,'834324234',2,'Arenoso',NULL,-3,NULL),(3,'834324234',NULL,'ghgh','ojhjhjhil',3,5.50);
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
  CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `fk_usuario_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_usuario_estado_trabajador` FOREIGN KEY (`id_estado_trabajador`) REFERENCES `estado_trabajador` (`id_estado_trabajador`),
  CONSTRAINT `fk_usuario_tipo_usuario` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1006511653,'usuarios/TPn5OuzBFcUMBMTb27MDcG8KrMQg0nUiQau4ExxO.png','Sebas Alvarez','3103524334','sombrahdepaz76@gmail.com','$2y$12$ShO2KxmULq2i87gGWluCyeAy/C5fhUJt26ceeK7Nt/BKxRxQl/DRa','',1,3,'103455657789',1),(1034345454,'usuarios/ohtjEMXYnEtIKQV6uXFyhSx4giqPArWo1ABQmYEk.jpg','Javier Gonza','3223243434','bastobrayan246@gmail.com','$2y$12$IXfjWMnY6Ul6L6B0trEKK.6obRkullnh7zI5H/sAO3/nHgpsQWjqq','',1,3,'876767657',1),(1039253243,'usuarios/6DbIrTZ3euiLErVZDzRTjao6nJEXJkhLXQTrjUvt.jpg','JORGE EL CURIOSO','3201434344','dos1234@gmail.com','$2y$12$b4ZvycvWA7M4KLYwj7uEKuIZnXA4z1OFt9QbRINpu52bwF/Xd1SAi',NULL,3,1,'988091212',1),(1104921223,'usuarios/fxyI259nxaEdNx9meFLTLFkpNIRGXnj7nyy2Z8PX.png','julio profe','3291231212','reyesz2803@gmail.com','$2y$12$NcwOItyOjXK4jwD7js4ri.mghmiFTcxGEzjyPNbzJGOZ6lWJQ7Eou','ugZieEAYrJPCWdRGu1SNvK3oxuBnFMDTgYLvlzfxWrUEKLPNSGX7dt0pTz7w',1,3,'834324234',1),(1105461467,'usuarios/DKOC3w5ZmiayRnVTgSMffJcI6AQhq9EdKtgtelwj.png','sebas','3176060850','gasrciasebastian019@gmail.com','$2y$12$vrnlIhSsriy/9tEB6L95eOc3SbwfjQhH6/DSuEM6tEPLe.glEsM1.',NULL,3,3,'834324234',1),(1110722331,'usuarios/useOl4EMIIlIsP0f8X6vMaoWPIjhX5Ml9tCDJ2bC.jpg','Didier','3103527239','johsn@gmail.com','$2y$12$4lNRhcjuBmkF25LyFWMLL.k5LlWvmOTnosiRabQoEgyG4ojfgk9am','',3,3,'834324234',1),(1110722345,'usuarios/IEJRgrLlnPGGxJcaD5NFbzOnxj7DAVNxZXnoZjTr.jpg','Brayan Gutierez','3029219231','sombrahdepaz@gmail.com','$2y$12$ElMqaOG0Q30Gbt8q2RwPDudpzZPaIlhmEoA4Ldj0WQ6cW6zhcGAiK','ZvNG62UWZAdnu1aCOus0E5kcsylRs6ExJmHDCOQNuZ6MqstDveVTUCa1XJJg',1,3,'988091212',1);
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
  CONSTRAINT `fk_venta_licencias_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  CONSTRAINT `fk_venta_licencias_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `fk_venta_licencias_tipo_licencia` FOREIGN KEY (`id_tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo_licencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_licencias`
--

LOCK TABLES `venta_licencias` WRITE;
/*!40000 ALTER TABLE `venta_licencias` DISABLE KEYS */;
INSERT INTO `venta_licencias` VALUES ('9uTJGg3T0RG8l8','2026-03-06 12:41:27','Asignada desde Dashboard',2,'988091212',3),('CHscjT93rnsFdj','2026-03-01 20:04:57','Asignada desde Dashboard',2,'876767657',3),('DNPSVVPFfsJOUx','2026-02-25 23:22:48','Asignada desde Dashboard',2,'103455657789',3),('GTJ8xgFGPHkNZn','2026-02-25 23:27:54','Asignada desde Dashboard',1,'411234141412',3),('Q3zZJYBvH2PISC','2026-03-01 20:29:45','Asignada desde Dashboard',3,'834324234',3);
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

-- Dump completed on 2026-03-13 16:06:29
