-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for medi_db
CREATE DATABASE IF NOT EXISTS `medi_db` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `medi_db`;

-- Dumping structure for table medi_db.drug
CREATE TABLE IF NOT EXISTS `drug` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table medi_db.drug: ~7 rows (approximately)
INSERT INTO `drug` (`id`, `name`, `price`) VALUES
	(1, 'Aciclovir 200 mg', 5),
	(2, 'Amitriptyline 25 mg', 6),
	(3, 'Amoxicillin 250 mg', 7),
	(4, 'Atenolol 50 mg', 8),
	(5, 'Carbamazepine 200 mg', 4),
	(6, 'Diazepam 5 mg', 2),
	(7, 'Enalapril 5 mg', 7);

-- Dumping structure for table medi_db.image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Prescription_id` int NOT NULL,
  `path` text,
  PRIMARY KEY (`id`),
  KEY `fk_images_Prescription1_idx` (`Prescription_id`),
  CONSTRAINT `fk_images_Prescription1` FOREIGN KEY (`Prescription_id`) REFERENCES `prescription` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table medi_db.image: ~14 rows (approximately)
INSERT INTO `image` (`id`, `Prescription_id`, `path`) VALUES
	(11, 18, 'uploads/1755578745_email.png'),
	(12, 18, 'uploads/1755578745_github.png'),
	(13, 18, 'uploads/1755578745_linkedin-logo.png'),
	(14, 18, 'uploads/1755578745_phone-call.png'),
	(15, 18, 'uploads/1755578745_pin.png'),
	(16, 19, 'uploads/1755578925_email.png'),
	(17, 19, 'uploads/1755578925_github.png'),
	(25, 22, 'uploads/1755580819_email.png'),
	(26, 22, 'uploads/1755580819_github.png'),
	(27, 22, 'uploads/1755580819_linkedin-logo.png'),
	(28, 22, 'uploads/1755580819_phone-call.png'),
	(29, 22, 'uploads/1755580819_pin.png'),
	(30, 23, 'uploads/1755580957_github.png'),
	(31, 23, 'uploads/1755580957_email.png');

-- Dumping structure for table medi_db.prescription
CREATE TABLE IF NOT EXISTS `prescription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Prescription_user_idx` (`user_id`),
  KEY `fk_Prescription_status1_idx` (`status_id`),
  CONSTRAINT `fk_Prescription_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_Prescription_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table medi_db.prescription: ~4 rows (approximately)
INSERT INTO `prescription` (`id`, `user_id`, `status_id`) VALUES
	(18, 3, 3),
	(19, 3, 3),
	(22, 5, 1),
	(23, 5, 2);

-- Dumping structure for table medi_db.quotation
CREATE TABLE IF NOT EXISTS `quotation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Prescription_id` int NOT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quotation_Prescription1_idx` (`Prescription_id`),
  CONSTRAINT `fk_quotation_Prescription1` FOREIGN KEY (`Prescription_id`) REFERENCES `prescription` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table medi_db.quotation: ~2 rows (approximately)
INSERT INTO `quotation` (`id`, `Prescription_id`, `total`) VALUES
	(7, 18, 68),
	(8, 19, 8),
	(11, 22, 58),
	(12, 23, 82);

-- Dumping structure for table medi_db.quotation_has_drug
CREATE TABLE IF NOT EXISTS `quotation_has_drug` (
  `quotation_id` int NOT NULL,
  `drug_id` int NOT NULL,
  `qty` int DEFAULT NULL,
  PRIMARY KEY (`quotation_id`,`drug_id`),
  KEY `fk_quotation_has_drug_drug1_idx` (`drug_id`),
  KEY `fk_quotation_has_drug_quotation1_idx` (`quotation_id`),
  CONSTRAINT `fk_quotation_has_drug_drug1` FOREIGN KEY (`drug_id`) REFERENCES `drug` (`id`),
  CONSTRAINT `fk_quotation_has_drug_quotation1` FOREIGN KEY (`quotation_id`) REFERENCES `quotation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table medi_db.quotation_has_drug: ~9 rows (approximately)
INSERT INTO `quotation_has_drug` (`quotation_id`, `drug_id`, `qty`) VALUES
	(7, 3, 4),
	(7, 5, 10),
	(8, 5, 2),
	(11, 2, 5),
	(11, 4, 1),
	(11, 6, 10),
	(12, 1, 5),
	(12, 5, 2),
	(12, 7, 7);

-- Dumping structure for table medi_db.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table medi_db.status: ~4 rows (approximately)
INSERT INTO `status` (`id`, `status`) VALUES
	(0, 'Pending'),
	(1, 'Accept'),
	(2, 'Reject'),
	(3, 'submit');

-- Dumping structure for table medi_db.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table medi_db.user: ~2 rows (approximately)
INSERT INTO `user` (`id`, `name`, `email`, `address`, `contact_no`, `dob`, `password`) VALUES
	(3, 'Gimhan Deshapriya', 'gimhan@gmail.com', 'Ratnapura', '0702514369', '2025-07-31', '12345'),
	(5, 'test', 'test@gmail.com', 'Colombo', '0712453692', '2025-08-07', '123456');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
