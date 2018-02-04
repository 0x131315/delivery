-- MySQL dump 10.13  Distrib 5.7.21, for Win64 (x86_64)
--
-- Host: localhost    Database: delivery
-- ------------------------------------------------------
-- Server version	5.7.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `couriers`
--

DROP TABLE IF EXISTS `couriers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `couriers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext COMMENT 'имя курьера',
  `deacription` tinytext COMMENT 'описание курьера',
  `status` enum('0','1','-1') DEFAULT '0' COMMENT 'статус курьера 0-не работает, 1-работает, -1-уволен',
  `shedule_id` int(10) unsigned DEFAULT NULL COMMENT 'номер расписания работы',
  PRIMARY KEY (`id`),
  KEY `couriers_couriers_shedule_id_fk` (`shedule_id`),
  CONSTRAINT `couriers_couriers_shedule_id_fk` FOREIGN KEY (`shedule_id`) REFERENCES `couriers_shedule` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='список курьеров, insert/update';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `couriers`
--

LOCK TABLES `couriers` WRITE;
/*!40000 ALTER TABLE `couriers` DISABLE KEYS */;
/*!40000 ALTER TABLE `couriers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `couriers_shedule`
--

DROP TABLE IF EXISTS `couriers_shedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `couriers_shedule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'key',
  `Mo` bit(1) DEFAULT b'0',
  `Tu` bit(1) DEFAULT b'0',
  `We` bit(1) DEFAULT b'0',
  `Th` bit(1) DEFAULT b'0',
  `Fr` bit(1) DEFAULT b'0',
  `Sa` bit(1) DEFAULT b'0',
  `Su` bit(1) DEFAULT b'0',
  `Mo_start` tinyint(3) unsigned DEFAULT NULL,
  `Tu_start` tinyint(3) unsigned DEFAULT NULL,
  `We_start` tinyint(3) unsigned DEFAULT NULL,
  `Th_start` tinyint(3) unsigned DEFAULT NULL,
  `Fr_start` tinyint(3) unsigned DEFAULT NULL,
  `Sa_start` tinyint(3) unsigned DEFAULT NULL,
  `Su_start` tinyint(3) unsigned DEFAULT NULL,
  `Mo_end` tinyint(3) unsigned DEFAULT NULL,
  `Tu_end` tinyint(3) unsigned DEFAULT NULL,
  `We_end` tinyint(3) unsigned DEFAULT NULL,
  `Th_end` tinyint(3) unsigned DEFAULT NULL,
  `Fr_end` tinyint(3) unsigned DEFAULT NULL,
  `Sa_end` tinyint(3) unsigned DEFAULT NULL,
  `Su_end` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='расписание курьеров';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `couriers_shedule`
--

LOCK TABLES `couriers_shedule` WRITE;
/*!40000 ALTER TABLE `couriers_shedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `couriers_shedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_open`
--

DROP TABLE IF EXISTS `order_open`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_open` (
  `order_id` int(10) unsigned NOT NULL COMMENT 'id заказа в таблице orders',
  `time_way` smallint(5) unsigned DEFAULT NULL COMMENT 'время пути для курьера (null - самовывоз)',
  `courier_id` int(10) unsigned DEFAULT NULL COMMENT 'курьер, которому назначен заказ (null - самовывоз)',
  `date_es` datetime DEFAULT NULL COMMENT 'ожидаемая дата доставки',
  UNIQUE KEY `order_id` (`order_id`),
  CONSTRAINT `order_open_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='открытые заказы, добавление/удаление';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_open`
--

LOCK TABLES `order_open` WRITE;
/*!40000 ALTER TABLE `order_open` DISABLE KEYS */;
INSERT INTO `order_open` VALUES (1,60,NULL,NULL);
/*!40000 ALTER TABLE `order_open` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'key',
  `status` enum('0','1','2','3','-1') NOT NULL DEFAULT '0' COMMENT 'статус заказа',
  `cost` int(10) unsigned DEFAULT NULL COMMENT 'стоимость заказа',
  `date_start` datetime DEFAULT NULL COMMENT 'дата фактического открытия заказа',
  `date_end` datetime DEFAULT NULL COMMENT 'дата фактического закрытия заказа',
  `address` tinytext COMMENT 'адрес доставки',
  `description` text COMMENT 'описание заказа',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='архив заказов, только добавление';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'0',13,'2018-02-04 19:47:11',NULL,'fgdnhfghnfdghn','fgndgdhnedtfgdh');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `login` tinytext NOT NULL COMMENT 'Логин(32)',
  `pass` tinytext NOT NULL COMMENT 'хэш пароля',
  `cookie` tinytext COMMENT 'хэш куки',
  `cookie_time` datetime DEFAULT NULL COMMENT 'время, до которого валидна кука',
  `status` enum('0','1','2','-1') NOT NULL COMMENT 'статус учетки',
  UNIQUE KEY `login` (`login`(32)) USING BTREE,
  KEY `cookie` (`cookie`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='список учеток пользователей';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('operator','ab8b1c7132550701bb8a6a3916e5b8e4','x24aovy0n7vsB6uWNx9u6jQ37O0397yA','2018-02-11 00:00:00','2'),('user','1c41d0e1cf8bde34c81278e0bdc3437a','YEEM06moNNZoh9uuQRz7hu63ueOZL4TK','2018-02-11 00:00:00','0');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-04 21:53:40
