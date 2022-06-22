-- MariaDB dump 10.19  Distrib 10.4.25-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: cscproj
-- ------------------------------------------------------
-- Server version	10.4.25-MariaDB-1:10.4.25+maria~focal-log

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
-- Current Database: `cscproj`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `cscproj` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `cscproj`;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `admin_id` int(7) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_telno` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(7) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `user_id_admins_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Megat Admin','0135950960',4),(3,'Megat Test','0135950960',14),(4,'Admin','0135950960',25);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applications` (
  `application_id` int(7) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_startDate` date NOT NULL,
  `app_endDate` date NOT NULL,
  `app_time` time NOT NULL,
  `app_files_link` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` int(7) NOT NULL,
  `officer_id` int(7) DEFAULT NULL,
  `admin_id` int(7) DEFAULT NULL,
  `forwarded` tinyint(1) DEFAULT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`application_id`),
  KEY `student_id_applications_fk` (`student_id`),
  KEY `admin_id_applications_fk` (`admin_id`),
  KEY `officer_id_applications_fk` (`officer_id`),
  CONSTRAINT `admin_id_applications_fk` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`),
  CONSTRAINT `officer_id_applications_fk` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`officer_id`),
  CONSTRAINT `student_id_applications_fk` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` VALUES (2,'Welcome test','2022-06-21','2022-06-22','17:30:00','https://www.alzhahir.com',1,NULL,NULL,NULL,NULL),(3,'Test 2','2022-06-22','2022-06-30','12:00:00','https://drive.google.com',1,NULL,NULL,NULL,NULL),(4,'student got talent ','2022-07-01','2022-07-31','09:00:00','https://drive.google.com/file/d/1X6XF0MhyUoNkPxjqwyLr_A7-7aUmGBIp/view',9,NULL,NULL,NULL,NULL),(5,'Dota 2 e-Sports Tournament','2022-06-24','2022-06-25','09:00:00','https://drive.google.com',10,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clubs`
--

DROP TABLE IF EXISTS `clubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clubs` (
  `club_id` int(7) NOT NULL AUTO_INCREMENT,
  `club_name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club_type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clubs`
--

LOCK TABLES `clubs` WRITE;
/*!40000 ALTER TABLE `clubs` DISABLE KEYS */;
INSERT INTO `clubs` VALUES (1,'EACC','Communication'),(2,'ELLiTS','Communication');
/*!40000 ALTER TABLE `clubs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `officers`
--

DROP TABLE IF EXISTS `officers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `officers` (
  `officer_id` int(7) NOT NULL AUTO_INCREMENT,
  `officer_name` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `officer_telno` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(7) NOT NULL,
  PRIMARY KEY (`officer_id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `user_id_officer_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officers`
--

LOCK TABLES `officers` WRITE;
/*!40000 ALTER TABLE `officers` DISABLE KEYS */;
INSERT INTO `officers` VALUES (1,'Megat Officer','0135950960',6);
/*!40000 ALTER TABLE `officers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `student_id` int(7) NOT NULL AUTO_INCREMENT,
  `student_name` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_telno` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club_id` int(7) DEFAULT NULL,
  `user_id` int(7) NOT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `club_id_students_fk` (`club_id`),
  CONSTRAINT `club_id_students_fk` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `user_id_students_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'Megat Al Zhahir Daniel Bin Megat Nor Mazlan','0135950960',2,2),(4,'Megat Al Zhahir Daniel Bin Megat Nor Mazlan','0135950960',1,11),(7,'Test User','01234',1,17),(8,'iFARAH','01825614917',1,18),(9,'farah','0172694015',2,19),(10,'Adib','0123456789',1,20),(11,'test2','0123456789',2,21),(12,'test3','0123456789',1,22),(13,'TestUser22','0135950960',1,23),(14,'testuser33','0134445556',2,24);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trackings`
--

DROP TABLE IF EXISTS `trackings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trackings` (
  `tracking_id` int(7) NOT NULL AUTO_INCREMENT,
  `tracking_status` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_date` date NOT NULL,
  `tracking_time` time NOT NULL,
  `application_id` int(7) NOT NULL,
  PRIMARY KEY (`tracking_id`),
  KEY `application_id_trackings_fk` (`application_id`),
  CONSTRAINT `application_id_trackings_fk` FOREIGN KEY (`application_id`) REFERENCES `applications` (`application_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trackings`
--

LOCK TABLES `trackings` WRITE;
/*!40000 ALTER TABLE `trackings` DISABLE KEYS */;
INSERT INTO `trackings` VALUES (1,'Application received by System','2022-06-17','02:32:53',2),(2,'Application received by System','2022-06-17','12:43:50',2),(3,'Application received by System','2022-06-17','13:10:38',4),(4,'Application received by System','2022-06-22','18:57:55',5);
/*!40000 ALTER TABLE `trackings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(7) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pass` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(5) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'megatalzhahir@gmail.com','$2y$10$F0LtLzA9pNxo5vpR1vLBGuFgRTI8wR2tBiuOQtOL8SG59xKQZvF9.',0),(4,'megatalzhahirdaniel@gmail.com','$2y$10$M4YYY8JO0joRaP8muxoa3OiMcZrNUAAQ4ubf0qXoeEUIU3aen6EP6',1),(6,'megat@alzhahir.com','$2y$10$e6FNAPbN16VkDCLUsyA/NeWI8dP/3WysRHwMtrKlrvJ1CUYy4CR2e',2),(11,'2020878518@student.uitm.edu.my','$2y$10$ir9A73W11DmCV9yIIBeaXul./ok0nuO4q4DQzXNYnAM8xRVjyQlyW',0),(14,'megat@xtrstge.com','$2y$10$IwBQbyqlOPYlkcvXKW29IuEFOzWjSaaOPZ5uAObYBthYTgZnQv1Be',1),(17,'test@example.com','$2y$10$DKgiFlXet2GotCWbZIRAZerl/.H5PZKoNEQPRjEat3lo9y8aNQ5yW',0),(18,'farah@gmail.com','$2y$10$86nnnsINMhS.125nx1hD/.5sTyym1mYnlQBq4oPK/HK9ZkM6sPw1O',0),(19,'farahnatasha3105@gmail.com','$2y$10$1GAVSCkeT3oQRc3vGQvhfO.gIqAvdkRZB/dqFf9dha82LHXL1FgrC',0),(20,'adib@gmail.com','$2y$10$Ru8J1znQcypjYJZvC3uYBeguuwQO7LJdvZuPYDdBWzzEO.Y7oAI4K',0),(21,'test2@example2.com','$2y$10$UliyvOrs8pAoy68L6K4RoOFm9Sb6trzDW80lifX3Y0GZ4HgDjElea',0),(22,'test3@example3.com','$2y$10$eFufhJFe6U2w02bdfiYHY.TWzIsVAiGy5XXbc0TjW6JpexGA2.852',0),(23,'testuser22@gm.com','$2y$10$6rFVRNKDwTB9K2Uad3tcLOavSgHvms07BPIQ2iFJl0SK.0qXdNUFi',0),(24,'testuser33@gm.com','$2y$10$yVfzbk.53/OzpMe.qq3uYuZ5dUkCEMRWN08yirWCrjSoSEem11o2q',0),(25,'admin@alz.moe','$2y$10$rFJ8gtxZ7tljx8vdx8nN7./hSy.3ppXoAOsHQfmfkmceV5SHKzWrK',1);
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

-- Dump completed on 2022-06-22 12:11:13
