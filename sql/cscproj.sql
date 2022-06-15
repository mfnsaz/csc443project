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
  KEY `user_id_admins_fk` (`user_id`),
  CONSTRAINT `user_id_admins_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
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
  `app_name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_startDate` date NOT NULL,
  `app_endDate` date NOT NULL,
  `app_time` time NOT NULL,
  `app_files_link` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` int(7) NOT NULL,
  `officer_id` int(7) DEFAULT NULL,
  `admin_id` int(7) DEFAULT NULL,
  PRIMARY KEY (`application_id`),
  KEY `student_id_applications_fk` (`student_id`),
  KEY `admin_id_applications_fk` (`admin_id`),
  KEY `officer_id_applications_fk` (`officer_id`),
  CONSTRAINT `admin_id_applications_fk` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`),
  CONSTRAINT `officer_id_applications_fk` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`officer_id`),
  CONSTRAINT `student_id_applications_fk` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
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
  `officer_name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `officer_telno` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(7) NOT NULL,
  PRIMARY KEY (`officer_id`),
  KEY `user_id_officer_fk` (`user_id`),
  CONSTRAINT `user_id_officer_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officers`
--

LOCK TABLES `officers` WRITE;
/*!40000 ALTER TABLE `officers` DISABLE KEYS */;
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
  `student_name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_telno` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club_id` int(7) NOT NULL,
  `user_id` int(7) NOT NULL,
  PRIMARY KEY (`student_id`),
  KEY `club_id_students_fk` (`club_id`),
  KEY `user_id_students_fk` (`user_id`),
  CONSTRAINT `club_id_students_fk` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`),
  CONSTRAINT `user_id_students_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
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
  `tracking_status` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_date` date NOT NULL,
  `tracking_time` time NOT NULL,
  `application_id` int(7) NOT NULL,
  PRIMARY KEY (`tracking_id`),
  KEY `application_id_trackings_fk` (`application_id`),
  CONSTRAINT `application_id_trackings_fk` FOREIGN KEY (`application_id`) REFERENCES `applications` (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trackings`
--

LOCK TABLES `trackings` WRITE;
/*!40000 ALTER TABLE `trackings` DISABLE KEYS */;
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
  `user_email` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pass` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(5) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2022-06-14 11:00:01
