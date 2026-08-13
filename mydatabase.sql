-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bsis3a
CREATE DATABASE IF NOT EXISTS `bsis3a` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bsis3a`;

-- Dumping structure for table bsis3a.course
CREATE TABLE IF NOT EXISTS `course` (
  `CourseID` int NOT NULL,
  `CourseName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bsis3a.course: ~5 rows (approximately)
INSERT INTO `course` (`CourseID`, `CourseName`) VALUES
	(1, 'BS in Secondary Education'),
	(2, 'BS in Secondary Education'),
	(3, 'BS in Secondary Education'),
	(4, 'BS in  Elementary Education\r\n'),
	(5, 'BS in  Elementary Education');

-- Dumping structure for table bsis3a.department
CREATE TABLE IF NOT EXISTS `department` (
  `DepartmentID` int NOT NULL,
  `DepartmentName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`DepartmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bsis3a.department: ~5 rows (approximately)
INSERT INTO `department` (`DepartmentID`, `DepartmentName`) VALUES
	(1, 'Bachelor of Science in Information Systems'),
	(2, 'Bachelor of Science in Information Systems'),
	(3, 'Bachelor of Science in Information Systems'),
	(4, 'Bachelor of Science in Information Systems'),
	(5, 'Bachelor of Science in Information Systems');

-- Dumping structure for table bsis3a.room
CREATE TABLE IF NOT EXISTS `room` (
  `DepartmentID` int NOT NULL,
  `RoomName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`DepartmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bsis3a.room: ~5 rows (approximately)
INSERT INTO `room` (`DepartmentID`, `RoomName`) VALUES
	(1, 'ACTLAB'),
	(2, 'ACTLAB'),
	(3, 'ACTLAB'),
	(4, 'ACTLAB'),
	(5, 'ACTLAB');

-- Dumping structure for table bsis3a.section
CREATE TABLE IF NOT EXISTS `section` (
  `SectionID` varchar(20) NOT NULL,
  `SectionName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`SectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bsis3a.section: ~5 rows (approximately)
INSERT INTO `section` (`SectionID`, `SectionName`) VALUES
	(BSIS1, '3A'),
	(BSIS2, '3B'),
	(BSIS3, '3C'),
	(BSIS4, '3D'),
	(BSIS5, '3E');

-- Dumping structure for table bsis3a.student
CREATE TABLE IF NOT EXISTS `student` (
  `StudentID` int NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `Course` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bsis3a.student: ~0 rows (approximately)
INSERT INTO `student` (`StudentID`, `FirstName`, `Course`) VALUES
	(280, 'Faith', 'BSIS'),
	(281, 'Arlet', 'BSIS'),
	(282, 'Vjyne', 'BSIS'),
	(283, 'Kristine', 'BSIS'),
	(284, 'Fatima', 'BSIS');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
