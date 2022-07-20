-- MySQL dump 10.13  Distrib 5.7.18, for macos10.12 (x86_64)
--
-- Host: localhost    Database: utmapi
-- ------------------------------------------------------
-- Server version	5.7.18

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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user`
(
    `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
    `is_active`     int(10) unsigned NOT NULL DEFAULT '1',
    `is_defaulter`  int(10) unsigned DEFAULT '0',
    `phone`         varchar(45) CHARACTER SET utf8mb4 NOT NULL,
    `email`         varchar(45) CHARACTER SET utf8mb4 NOT NULL,
    `password_hash` varchar(60) CHARACTER SET utf8mb4 NOT NULL,
    `auth_key`      varchar(32) CHARACTER SET utf8mb4 NOT NULL,
    `first_name`    varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
    `last_name`     varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
    `balance_prev`  decimal(10, 2)                    DEFAULT '0.00',
    `balance`       decimal(10, 2)                    DEFAULT '0.00',
    `marker_id`     int(10) unsigned DEFAULT NULL,
    `customer_id`   int(10) unsigned DEFAULT NULL,
    `created_at`    int(10) unsigned NOT NULL,
    `updated_at`    int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log`
(
    `id`       bigint NOT NULL AUTO_INCREMENT,
    `level`    int                                DEFAULT NULL,
    `category` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
    `log_time` double                             DEFAULT NULL,
    `prefix`   text CHARACTER SET utf8mb4,
    `message`  text CHARACTER SET utf8mb4,
    PRIMARY KEY (`id`),
    KEY        `idx_log_level` (`level`),
    KEY        `idx_log_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-11 23:31:51