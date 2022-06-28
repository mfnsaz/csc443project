-- phpMyAdmin SQL Dump
-- version 5.1.4deb1+focal1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2022 at 07:41 AM
-- Server version: 10.4.25-MariaDB-1:10.4.25+maria~focal-log
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cscproj`
--
CREATE DATABASE IF NOT EXISTS `cscproj` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `cscproj`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(7) NOT NULL,
  `admin_name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_telno` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int(7) NOT NULL,
  `app_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_startDate` date NOT NULL,
  `app_endDate` date NOT NULL,
  `app_time` time NOT NULL,
  `app_files_link` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` int(7) NOT NULL,
  `officer_id` int(7) DEFAULT NULL,
  `admin_id` int(7) DEFAULT NULL,
  `forwarded` tinyint(1) DEFAULT NULL,
  `approved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `club_id` int(7) NOT NULL,
  `club_name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club_type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `officer_id` int(7) NOT NULL,
  `officer_name` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `officer_telno` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(7) NOT NULL,
  `student_name` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_telno` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club_id` int(7) DEFAULT NULL,
  `user_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trackings`
--

CREATE TABLE `trackings` (
  `tracking_id` int(7) NOT NULL,
  `tracking_status` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_date` date NOT NULL,
  `tracking_time` time NOT NULL,
  `application_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(7) NOT NULL,
  `user_email` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pass` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `student_id_applications_fk` (`student_id`),
  ADD KEY `admin_id_applications_fk` (`admin_id`),
  ADD KEY `officer_id_applications_fk` (`officer_id`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`club_id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`officer_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `club_id_students_fk` (`club_id`);

--
-- Indexes for table `trackings`
--
ALTER TABLE `trackings`
  ADD PRIMARY KEY (`tracking_id`),
  ADD KEY `application_id_trackings_fk` (`application_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `club_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `officer_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trackings`
--
ALTER TABLE `trackings`
  MODIFY `tracking_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `user_id_admins_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `admin_id_applications_fk` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`),
  ADD CONSTRAINT `officer_id_applications_fk` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`officer_id`),
  ADD CONSTRAINT `student_id_applications_fk` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `officers`
--
ALTER TABLE `officers`
  ADD CONSTRAINT `user_id_officer_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `club_id_students_fk` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`),
  ADD CONSTRAINT `user_id_students_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `trackings`
--
ALTER TABLE `trackings`
  ADD CONSTRAINT `application_id_trackings_fk` FOREIGN KEY (`application_id`) REFERENCES `applications` (`application_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
