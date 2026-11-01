SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `appointment_services`;
CREATE TABLE `appointment_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `price` decimal(14,2) NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointment_id` (`appointment_id`),
  KEY `service_id` (`service_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `appointment_services_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointment_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  CONSTRAINT `appointment_services_ibfk_3` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('1','1','7','45000.00','150',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('2','1','18','8000.00','20',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('3','2','7','45000.00','150',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('4','2','18','8000.00','20',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('5','3','7','45000.00','150',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('6','3','18','8000.00','20',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('7','4','7','45000.00','150',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('8','4','18','8000.00','20',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('9','5','2','10000.00','30',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('10','5','4','60000.00','120',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('11','5','6','50000.00','180',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('12','5','11','25000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('13','5','16','45000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('14','5','22','25000.00','45',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('15','6','2','10000.00','30',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('16','6','4','60000.00','120',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('17','6','6','50000.00','180',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('18','6','11','25000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('19','6','16','45000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('20','6','22','25000.00','45',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('21','7','1','10000.00','30',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('22','8','1','10000.00','30',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('23','9','1','10000.00','30',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('24','10','5','30000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('25','11','5','30000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('26','12','5','30000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('27','13','1','10000.00','30',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('28','13','4','60000.00','120',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('29','14','1','10000.00','30',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('30','14','4','60000.00','120',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('31','15','13','40000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('32','16','13','40000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('33','17','13','40000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('34','18','13','40000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('35','19','13','40000.00','60',NULL);
INSERT INTO `appointment_services` (`id`,`appointment_id`,`service_id`,`price`,`duration_minutes`,`staff_id`) VALUES('36','20','13','40000.00','60',NULL);

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `appointment_no` varchar(40) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `status` enum('booked','confirmed','checked_in','in_progress','completed','cancelled','no_show') DEFAULT 'booked',
  `source` enum('phone','walk_in','whatsapp','website','other') DEFAULT 'phone',
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `appointment_no` (`appointment_no`),
  KEY `appointment_lookup` (`branch_id`,`appointment_date`,`staff_id`),
  KEY `customer_id` (`customer_id`),
  KEY `staff_id` (`staff_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('1','1','1','APT-260804-0001','2026-08-04','09:00:00','11:50:00',NULL,'confirmed','website','',NULL,'2026-08-04 15:48:18');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('2','1','1','APT-260804-0002','2026-08-04','09:00:00','11:50:00',NULL,'cancelled','website','',NULL,'2026-08-04 15:49:03');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('3','1','1','APT-260804-0003','2026-08-04','09:00:00','11:50:00',NULL,'cancelled','website','',NULL,'2026-08-04 15:49:22');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('4','1','1','APT-260804-0004','2026-08-04','09:00:00','11:50:00',NULL,'cancelled','website','',NULL,'2026-08-04 15:49:32');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('5','1','2','APT-260804-0005','2026-08-13','15:00:00','23:15:00',NULL,'booked','website','',NULL,'2026-08-04 16:22:00');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('6','1','2','APT-260804-0006','2026-08-13','15:00:00','23:15:00',NULL,'cancelled','website','',NULL,'2026-08-04 16:23:29');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('7','1','3','APT-260804-0007','2026-08-18','20:00:00','20:30:00',NULL,'booked','website','',NULL,'2026-08-04 16:32:21');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('8','1','3','APT-260804-0008','2026-08-18','20:00:00','20:30:00',NULL,'booked','website','',NULL,'2026-08-04 16:32:52');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('9','1','3','APT-260804-0009','2026-08-18','20:00:00','20:30:00',NULL,'booked','website','',NULL,'2026-08-04 16:33:00');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('10','1','3','APT-260804-0010','2026-08-05','11:00:00','12:00:00',NULL,'no_show','website','',NULL,'2026-08-04 16:40:04');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('11','1','3','APT-260804-0011','2026-08-05','11:00:00','12:00:00',NULL,'cancelled','website','',NULL,'2026-08-04 16:40:23');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('12','1','3','APT-260804-0012','2026-08-05','11:00:00','12:00:00',NULL,'cancelled','website','',NULL,'2026-08-04 16:40:28');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('13','1','3','APT-260804-0013','2026-08-06','15:00:00','17:30:00',NULL,'booked','website','',NULL,'2026-08-04 16:49:35');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('14','1','3','APT-260804-0014','2026-08-06','15:00:00','17:30:00',NULL,'cancelled','website','',NULL,'2026-08-04 16:49:50');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('15','1','3','APT-260804-0015','2026-08-07','11:00:00','12:00:00',NULL,'cancelled','website','',NULL,'2026-08-04 16:54:45');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('16','1','3','APT-260804-0016','2026-08-07','11:00:00','12:00:00',NULL,'booked','website','',NULL,'2026-08-04 16:55:27');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('17','1','3','APT-260804-0017','2026-08-07','11:00:00','12:00:00',NULL,'booked','website','',NULL,'2026-08-04 16:58:54');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('18','1','3','APT-260804-0018','2026-08-07','11:00:00','12:00:00',NULL,'booked','website','',NULL,'2026-08-04 16:58:57');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('19','1','3','APT-260804-0019','2026-08-08','10:00:00','11:00:00',NULL,'booked','website','',NULL,'2026-08-04 17:00:08');
INSERT INTO `appointments` (`id`,`branch_id`,`customer_id`,`appointment_no`,`appointment_date`,`start_time`,`end_time`,`staff_id`,`status`,`source`,`notes`,`created_by`,`created_at`) VALUES('20','1','3','APT-260804-0020','2026-08-08','10:00:00','11:00:00',NULL,'cancelled','website','',NULL,'2026-08-04 17:00:32');

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `clock_in` datetime DEFAULT NULL,
  `clock_out` datetime DEFAULT NULL,
  `status` enum('present','late','absent','leave','off') DEFAULT 'present',
  `notes` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_staff_date` (`staff_id`,`attendance_date`),
  KEY `branch_id` (`branch_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE `audit_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(80) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `audit_date` (`created_at`),
  KEY `user_id` (`user_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `audit_logs_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('1','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:12:38');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('2','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:41:27');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('3','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:41:28');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('4','1','1','update','appointments','1','{\"status\":\"confirmed\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:48:55');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('5','1','1','update','appointments','1','{\"status\":\"confirmed\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:48:59');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('6','1','1','update','appointments','1','{\"status\":\"confirmed\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:49:42');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('7','1','1','update','appointments','2','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:50:18');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('8','1','1','update','appointments','3','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:50:20');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('9','1','1','update','appointments','4','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:50:22');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('10','1','1','update','notifications','4','{\"customer_id\":\"1\",\"type\":\"whatsapp\",\"recipient\":\"255712675431\",\"subject\":null,\"message\":\"Hello Dorothy, your appointment request APT-260804-0004 is booked for 2026-08-04 at 09:00\",\"status\":\"queued\",\"scheduled_at\":\"2026-08-04T15:49:32\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:55:32');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('11','1','1','update','notifications','4','{\"customer_id\":\"1\",\"type\":\"whatsapp\",\"recipient\":\"255712675431\",\"subject\":null,\"message\":\"Hello Dorothy, your appointment request APT-260804-0004 is booked for 2026-08-04 at 09:00\",\"status\":\"queued\",\"scheduled_at\":\"2026-08-04T15:49:32\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 15:57:47');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('12','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:11:43');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('13','1','1','whatsapp_booking_link_opened','customer',NULL,'{\"phone\":\"0712903883\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:17:25');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('14','1','1','whatsapp_booking_link_opened','customer',NULL,'{\"phone\":\"0712903883\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:24:54');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('15','1','1','update','appointments','6','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:27:20');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('16','1','1','whatsapp_booking_link_opened','customer',NULL,'{\"phone\":\"5068376973\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:29:29');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('17','1','1','whatsapp_booking_link_opened','customer','3','{\"phone\":\"5068376973\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:39:11');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('18','1','1','update','appointments','12','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:41:04');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('19','1','1','update','appointments','11','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:41:10');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('20','1','1','whatsapp_booking_link_opened','customer','3','{\"phone\":\"5068376973\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:47:59');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('21','1','1','update','appointments','14','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:51:06');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('22','1','1','whatsapp_booking_link_opened','customer','3','{\"phone\":\"5068376973\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:53:37');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('23','1','1','whatsapp_booking_link_opened','customer','3','{\"phone\":\"5068376973\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 16:59:06');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('24','1','1','update','appointments','20','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:00:45');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('25','1','1','update','appointments','14','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:00:55');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('26','1','1','update','appointments','15','{\"status\":\"cancelled\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:01:03');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('27','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:01:45');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('28','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:08:55');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('29','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:09:04');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('30','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:09:05');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('31','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:09:07');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('32','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:09:08');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('33','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:09:18');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('34','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:09:43');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('35','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-04 17:09:50');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('36','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 19:43:52');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('37','1','1','whatsapp_booking_link_opened','customer','3','{\"phone\":\"5068376973\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 19:44:17');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('38','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 19:48:53');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('39','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 19:48:54');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('40','1','1','create','customers','4','{\"quick\":true}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:07:28');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('41','1','1','create','queues','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:07:28');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('42','1','1','update','queues','1','{\"status\":\"in_service\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:07:54');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('43','1','1','create','sales','1','{\"invoice\":\"INV-260805-0001\",\"total\":50000}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:08:29');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('44','1','1','payment','sales','1','{\"amount\":50000}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:10:14');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('45','1','1','create','customers','5','{\"quick\":true}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:10:46');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('46','1','1','create','queues','2','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:10:46');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('47','1','1','update','queues','2','{\"status\":\"in_service\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:10:55');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('48','1','1','update','queues','2','{\"status\":\"no_show\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:10:58');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('49','1','1','create','sales','2','{\"invoice\":\"INV-260805-0002\",\"total\":50000}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:14:16');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('50','1','1','update','appointments','10','{\"status\":\"no_show\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:16:14');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('51','1','1','update','staff','1','{\"employee_no\":\"EMP-001\",\"full_name\":\"tester.developer\",\"phone\":\"0712345678\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":null,\"address\":null,\"role_title\":\"Owner\",\"salary\":\"0.00\",\"default_commission_type\":\"percentage\",\"default_commission_value\":\"20\",\"employment_date\":\"2026-08-04\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:21:08\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:21:08');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('52','1','1','update','staff','1','{\"employee_no\":\"EMP-001\",\"full_name\":\"tester.developer\",\"phone\":\"0712345678\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":null,\"address\":null,\"role_title\":\"Owner\",\"salary\":\"0.00\",\"default_commission_type\":\"percentage\",\"default_commission_value\":\"20\",\"employment_date\":\"2026-08-04\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:21:16\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:21:16');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('53','1','1','update','staff','1','{\"employee_no\":\"EMP-001\",\"full_name\":\"tester.developer\",\"phone\":\"0712345678\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":null,\"address\":null,\"role_title\":\"Owner\",\"salary\":\"0.00\",\"default_commission_type\":\"percentage\",\"default_commission_value\":\"20.00\",\"employment_date\":\"2026-08-04\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:21:45\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:21:45');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('54','1','1','update','staff','1','{\"employee_no\":\"EMP-001\",\"full_name\":\"tester.developer\",\"phone\":\"0712345678\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":null,\"address\":null,\"role_title\":\"Owner\",\"salary\":\"0.00\",\"default_commission_type\":\"percentage\",\"default_commission_value\":\"20.00\",\"employment_date\":\"2026-08-04\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:23:08\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:23:08');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('55','1','1','create','customers','6','{\"quick\":true}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:24:53');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('56','1','1','create','queues','3','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:24:53');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('57','1','1','update','queues','3','{\"status\":\"in_service\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:24:58');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('58','1','1','create','sales','3','{\"invoice\":\"INV-260805-0003\",\"total\":150000}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:25:18');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('59','1','1','payment','sales','3','{\"amount\":150000}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:25:27');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('60','1','1','update','staff','1','{\"employee_no\":\"EMP-001\",\"full_name\":\"tester.developer\",\"phone\":\"0712345678\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":null,\"address\":null,\"role_title\":\"Owner\",\"salary\":\"0.00\",\"default_commission_type\":\"percentage\",\"default_commission_value\":\"18\",\"employment_date\":\"2026-08-04\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:28:42\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:28:42');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('61','1','1','create','staff','2','{\"employee_no\":\"EMP-002\",\"full_name\":\"nustahiya jamal\",\"phone\":\"0765123456\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":\"2005-10-12\",\"address\":null,\"role_title\":\"staff\",\"salary\":null,\"default_commission_type\":\"percentage\",\"default_commission_value\":\"16\",\"employment_date\":\"2026-08-05\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:30:13\",\"branch_id\":1}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:30:13');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('62','1','1','update','staff','2','{\"employee_no\":\"EMP-002\",\"full_name\":\"nustahiya jamal\",\"phone\":\"0765123456\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":\"2005-10-12\",\"address\":null,\"role_title\":\"staff\",\"salary\":null,\"default_commission_type\":\"percentage\",\"default_commission_value\":\"17.00\",\"employment_date\":\"2026-08-05\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:37:05\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:37:05');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('63','1','1','update','staff','2','{\"employee_no\":\"EMP-002\",\"full_name\":\"nustahiya jamal\",\"phone\":\"0765123456\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":\"2005-10-12\",\"address\":null,\"role_title\":\"staff\",\"salary\":null,\"default_commission_type\":\"percentage\",\"default_commission_value\":\"17.00\",\"employment_date\":\"2026-08-05\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:37:41\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:37:41');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('64','1','1','update','staff','2','{\"employee_no\":\"EMP-002\",\"full_name\":\"nustahiya jamal\",\"phone\":\"0765123456\",\"email\":null,\"gender\":\"Female\",\"date_of_birth\":\"2005-10-12\",\"address\":null,\"role_title\":\"staff\",\"salary\":0,\"default_commission_type\":\"percentage\",\"default_commission_value\":19,\"employment_date\":\"2026-08-05\",\"emergency_contact\":null,\"status\":\"active\",\"updated_at\":\"2026-08-05 20:42:10\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:42:10');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('65','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 20:56:03');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('66','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 21:03:02');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('67','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 21:03:04');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('68','1','1','update','branches','1','{\"name\":\"Main Branch\",\"code\":\"MAIN\",\"phone\":\"0712345678\",\"email\":null,\"address\":\"Der es salaam, Tanzania\",\"opening_time\":\"08:00:00\",\"closing_time\":\"20:00:00\",\"status\":\"active\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 21:25:13');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('69','1','1','update','branches','1','{\"name\":\"Main Branch\",\"code\":\"MAIN\",\"phone\":\"0712345678\",\"email\":null,\"address\":\"Dar-es-salaam, Tanzania\",\"opening_time\":\"08:00:00\",\"closing_time\":\"20:00:00\",\"status\":\"active\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 21:25:45');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('70','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 21:31:31');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('71','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 21:31:44');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('72','1','1','whatsapp_booking_link_opened','customer',NULL,'{\"phone\":\"0712903883\",\"booking_link\":\"https:\\/\\/departed-unplug-spiny.ngrok-free.dev\\/salon_spa_management_system\\/public_booking.php?branch=1\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 21:32:44');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('73','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 22:35:16');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('74','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 23:22:08');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('75','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 10:53:13');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('76','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 11:01:46');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('77','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 11:23:21');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('78','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 12:08:31');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('79','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 17:29:15');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('80','1','1','update','products','2','{\"category_id\":\"1\",\"supplier_id\":\"1\",\"barcode\":\"100002\",\"name\":\"Conditioner\",\"brand\":\"Uzuri\",\"unit\":\"bottle\",\"buying_price\":\"13000.00\",\"selling_price\":\"20000.00\",\"minimum_stock\":\"8.00\",\"expiry_date\":\"2028-08-04\",\"track_stock\":1,\"status\":\"active\"}','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 17:44:25');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('81','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 17:59:29');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('82','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 18:08:07');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('83','1','1','create','stock_adjustments','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 18:13:01');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('84','1','1','create','stock_adjustments','2','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 18:13:46');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('85','1','1','create','stock_adjustments','3','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 18:14:18');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('86','1','1','create','stock_adjustments','4','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 18:15:07');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('87','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 20:27:26');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('88','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 20:59:17');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('89','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 21:17:57');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('90','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 21:30:24');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('91','1','1','logout','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-06 21:31:00');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('92','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-07 11:25:03');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('93','1','1','login','user','1','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-07 15:52:34');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('94','1','1','update','packages','3','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-07 15:58:09');
INSERT INTO `audit_logs` (`id`,`user_id`,`branch_id`,`action`,`entity_type`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES('95','1','1','update','packages','3','[]','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-07 15:58:33');

DROP TABLE IF EXISTS `backups`;
CREATE TABLE `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_size` bigint(20) DEFAULT 0,
  `backup_type` enum('manual','automatic') DEFAULT 'manual',
  `status` enum('completed','failed') DEFAULT 'completed',
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `backups_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `backups` (`id`,`file_name`,`file_size`,`backup_type`,`status`,`notes`,`created_by`,`created_at`) VALUES('1','backup_20260804_151759.sql','88451','manual','completed','Manual backup','1','2026-08-04 15:18:00');
INSERT INTO `backups` (`id`,`file_name`,`file_size`,`backup_type`,`status`,`notes`,`created_by`,`created_at`) VALUES('2','backup_20260805_210051.sql','158698','manual','completed','Manual backup','1','2026-08-05 21:00:51');

DROP TABLE IF EXISTS `branches`;
CREATE TABLE `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `code` varchar(20) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `opening_time` time DEFAULT '08:00:00',
  `closing_time` time DEFAULT '20:00:00',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `business_id` (`business_id`),
  CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `branches` (`id`,`business_id`,`name`,`code`,`phone`,`email`,`address`,`opening_time`,`closing_time`,`status`,`created_at`) VALUES('1','1','Main Branch','MAIN','0712345678',NULL,'Dar-es-salaam, Tanzania','08:00:00','20:00:00','active','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `businesses`;
CREATE TABLE `businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `vrn` varchar(50) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'TZS',
  `timezone` varchar(60) DEFAULT 'Africa/Dar_es_Salaam',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `businesses` (`id`,`name`,`phone`,`email`,`address`,`tin`,`vrn`,`logo`,`currency`,`timezone`,`created_at`) VALUES('1','Eden Salon & Spa','0712345678','info@example.co.tz','Dar-Es-Salaam, Tanzania',NULL,NULL,NULL,'TZS','Africa/Dar_es_Salaam','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `cash_sessions`;
CREATE TABLE `cash_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `opened_at` datetime NOT NULL,
  `opening_float` decimal(14,2) DEFAULT 0.00,
  `closed_at` datetime DEFAULT NULL,
  `expected_cash` decimal(14,2) DEFAULT 0.00,
  `actual_cash` decimal(14,2) DEFAULT 0.00,
  `variance` decimal(14,2) DEFAULT 0.00,
  `status` enum('open','closed') DEFAULT 'open',
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `cash_sessions_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `cash_sessions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `commission_rules`;
CREATE TABLE `commission_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `commission_type` enum('percentage','fixed') NOT NULL,
  `commission_value` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `staff_id` (`staff_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `commission_rules_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `commission_rules_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commission_rules_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `commissions`;
CREATE TABLE `commissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `sale_item_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `base_amount` decimal(14,2) NOT NULL,
  `commission_type` enum('percentage','fixed') NOT NULL,
  `commission_value` decimal(10,2) NOT NULL,
  `commission_amount` decimal(14,2) NOT NULL,
  `status` enum('unpaid','included','paid','reversed') DEFAULT 'unpaid',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `sale_id` (`sale_id`),
  KEY `sale_item_id` (`sale_item_id`),
  KEY `staff_id` (`staff_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `commissions_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `commissions_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  CONSTRAINT `commissions_ibfk_3` FOREIGN KEY (`sale_item_id`) REFERENCES `sale_items` (`id`),
  CONSTRAINT `commissions_ibfk_4` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  CONSTRAINT `commissions_ibfk_5` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `commissions` (`id`,`branch_id`,`sale_id`,`sale_item_id`,`staff_id`,`service_id`,`base_amount`,`commission_type`,`commission_value`,`commission_amount`,`status`,`created_at`) VALUES('1','1','1','1','1','21','25000.00','percentage','15.00','3750.00','unpaid','2026-08-05 20:08:29');
INSERT INTO `commissions` (`id`,`branch_id`,`sale_id`,`sale_item_id`,`staff_id`,`service_id`,`base_amount`,`commission_type`,`commission_value`,`commission_amount`,`status`,`created_at`) VALUES('2','1','1','2','1','21','25000.00','percentage','15.00','3750.00','unpaid','2026-08-05 20:08:29');
INSERT INTO `commissions` (`id`,`branch_id`,`sale_id`,`sale_item_id`,`staff_id`,`service_id`,`base_amount`,`commission_type`,`commission_value`,`commission_amount`,`status`,`created_at`) VALUES('3','1','2','3','1','6','50000.00','percentage','15.00','7500.00','unpaid','2026-08-05 20:14:16');
INSERT INTO `commissions` (`id`,`branch_id`,`sale_id`,`sale_item_id`,`staff_id`,`service_id`,`base_amount`,`commission_type`,`commission_value`,`commission_amount`,`status`,`created_at`) VALUES('4','1','3','4','1','16','45000.00','percentage','15.00','6750.00','unpaid','2026-08-05 20:25:18');
INSERT INTO `commissions` (`id`,`branch_id`,`sale_id`,`sale_item_id`,`staff_id`,`service_id`,`base_amount`,`commission_type`,`commission_value`,`commission_amount`,`status`,`created_at`) VALUES('5','1','3','5','1','6','50000.00','percentage','15.00','7500.00','unpaid','2026-08-05 20:25:18');
INSERT INTO `commissions` (`id`,`branch_id`,`sale_id`,`sale_item_id`,`staff_id`,`service_id`,`base_amount`,`commission_type`,`commission_value`,`commission_amount`,`status`,`created_at`) VALUES('6','1','3','6','1','22','25000.00','percentage','15.00','3750.00','unpaid','2026-08-05 20:25:18');
INSERT INTO `commissions` (`id`,`branch_id`,`sale_id`,`sale_item_id`,`staff_id`,`service_id`,`base_amount`,`commission_type`,`commission_value`,`commission_amount`,`status`,`created_at`) VALUES('7','1','3','7','1','10','30000.00','percentage','20.00','6000.00','unpaid','2026-08-05 20:25:18');

DROP TABLE IF EXISTS `customer_memberships`;
CREATE TABLE `customer_memberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `amount_paid` decimal(14,2) DEFAULT 0.00,
  `status` enum('active','expired','cancelled') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `membership_id` (`membership_id`),
  CONSTRAINT `customer_memberships_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_memberships_ibfk_2` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `customer_notes`;
CREATE TABLE `customer_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `customer_notes_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customer_notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `customer_ratings`;
CREATE TABLE `customer_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  `comments` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `customer_id` (`customer_id`),
  KEY `sale_id` (`sale_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `customer_ratings_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `customer_ratings_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `customer_ratings_ibfk_3` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `customer_ratings_ibfk_4` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `customer_service_continuations`;
CREATE TABLE `customer_service_continuations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `sale_item_id` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `continuation_service_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `original_service_date` date NOT NULL,
  `due_date` date NOT NULL,
  `preferred_time` time DEFAULT NULL,
  `status` enum('planned','reminded','booked','completed','cancelled','missed') DEFAULT 'planned',
  `appointment_id` int(11) DEFAULT NULL,
  `reminder_sent_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_continuation_sale_service` (`sale_item_id`,`service_id`),
  KEY `continuation_due_idx` (`branch_id`,`due_date`,`status`),
  KEY `continuation_customer_idx` (`customer_id`,`due_date`),
  KEY `sale_id` (`sale_id`),
  KEY `service_id` (`service_id`),
  KEY `continuation_service_id` (`continuation_service_id`),
  KEY `staff_id` (`staff_id`),
  KEY `appointment_id` (`appointment_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `customer_service_continuations_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `customer_service_continuations_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customer_service_continuations_ibfk_3` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `customer_service_continuations_ibfk_4` FOREIGN KEY (`sale_item_id`) REFERENCES `sale_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `customer_service_continuations_ibfk_5` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  CONSTRAINT `customer_service_continuations_ibfk_6` FOREIGN KEY (`continuation_service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  CONSTRAINT `customer_service_continuations_ibfk_7` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL,
  CONSTRAINT `customer_service_continuations_ibfk_8` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `customer_service_continuations_ibfk_9` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `customer_no` varchar(30) DEFAULT NULL,
  `full_name` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(120) DEFAULT NULL,
  `preferences` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_no` (`customer_no`),
  KEY `phone` (`phone`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `customers` (`id`,`branch_id`,`customer_no`,`full_name`,`phone`,`gender`,`date_of_birth`,`email`,`address`,`emergency_contact`,`preferences`,`status`,`created_at`,`updated_at`) VALUES('1','1','CUS-260804-0001','Dorothy','255712675431',NULL,NULL,NULL,NULL,NULL,NULL,'active','2026-08-04 15:48:18','2026-08-04 15:49:32');
INSERT INTO `customers` (`id`,`branch_id`,`customer_no`,`full_name`,`phone`,`gender`,`date_of_birth`,`email`,`address`,`emergency_contact`,`preferences`,`status`,`created_at`,`updated_at`) VALUES('2','1','CUS-260804-0002','rose','255712345678',NULL,NULL,NULL,NULL,NULL,NULL,'active','2026-08-04 16:22:00','2026-08-04 16:23:29');
INSERT INTO `customers` (`id`,`branch_id`,`customer_no`,`full_name`,`phone`,`gender`,`date_of_birth`,`email`,`address`,`emergency_contact`,`preferences`,`status`,`created_at`,`updated_at`) VALUES('3','1','CUS-260804-0003','John','5068376973',NULL,NULL,NULL,NULL,NULL,NULL,'active','2026-08-04 16:32:21','2026-08-04 17:00:32');
INSERT INTO `customers` (`id`,`branch_id`,`customer_no`,`full_name`,`phone`,`gender`,`date_of_birth`,`email`,`address`,`emergency_contact`,`preferences`,`status`,`created_at`,`updated_at`) VALUES('4','1','CUS-260805-0004','nifat','255623456789',NULL,NULL,NULL,NULL,NULL,NULL,'active','2026-08-05 20:07:28',NULL);
INSERT INTO `customers` (`id`,`branch_id`,`customer_no`,`full_name`,`phone`,`gender`,`date_of_birth`,`email`,`address`,`emergency_contact`,`preferences`,`status`,`created_at`,`updated_at`) VALUES('5','1','CUS-260805-0005','nasha','255634567890',NULL,NULL,NULL,NULL,NULL,NULL,'active','2026-08-05 20:10:46',NULL);
INSERT INTO `customers` (`id`,`branch_id`,`customer_no`,`full_name`,`phone`,`gender`,`date_of_birth`,`email`,`address`,`emergency_contact`,`preferences`,`status`,`created_at`,`updated_at`) VALUES('6','1','CUS-260805-0006','kiesha','255765123456',NULL,NULL,NULL,NULL,NULL,NULL,'active','2026-08-05 20:24:53',NULL);

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `entity_type` enum('staff','supplier','equipment','purchase','expense','customer','other') NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `title` varchar(180) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `asset_no` varchar(40) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(14,2) DEFAULT 0.00,
  `warranty_expiry` date DEFAULT NULL,
  `next_maintenance_date` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` enum('working','maintenance','broken','retired') DEFAULT 'working',
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_no` (`asset_no`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `gift_card_transactions`;
CREATE TABLE `gift_card_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gift_card_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL,
  `type` enum('issue','redeem','refund','adjustment') NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `gift_card_id` (`gift_card_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `gift_card_transactions_ibfk_1` FOREIGN KEY (`gift_card_id`) REFERENCES `gift_cards` (`id`),
  CONSTRAINT `gift_card_transactions_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `gift_cards`;
CREATE TABLE `gift_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `code` varchar(40) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `initial_balance` decimal(14,2) NOT NULL,
  `current_balance` decimal(14,2) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` enum('active','used','expired','cancelled') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `branch_id` (`branch_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `gift_cards_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `gift_cards_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `leave_requests`;
CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `leave_type` varchar(60) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `staff_id` (`staff_id`),
  KEY `approved_by` (`approved_by`),
  CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `leave_requests_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  CONSTRAINT `leave_requests_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `loyalty_accounts`;
CREATE TABLE `loyalty_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `points_balance` int(11) DEFAULT 0,
  `lifetime_points` int(11) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`),
  CONSTRAINT `loyalty_accounts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `loyalty_accounts` (`id`,`customer_id`,`points_balance`,`lifetime_points`,`updated_at`) VALUES('1','1','0','0','2026-08-04 15:48:18');
INSERT INTO `loyalty_accounts` (`id`,`customer_id`,`points_balance`,`lifetime_points`,`updated_at`) VALUES('2','2','0','0','2026-08-04 16:22:00');
INSERT INTO `loyalty_accounts` (`id`,`customer_id`,`points_balance`,`lifetime_points`,`updated_at`) VALUES('3','3','0','0','2026-08-04 16:32:21');
INSERT INTO `loyalty_accounts` (`id`,`customer_id`,`points_balance`,`lifetime_points`,`updated_at`) VALUES('4','4','50','50','2026-08-05 20:08:29');
INSERT INTO `loyalty_accounts` (`id`,`customer_id`,`points_balance`,`lifetime_points`,`updated_at`) VALUES('5','5','50','50','2026-08-05 20:14:16');
INSERT INTO `loyalty_accounts` (`id`,`customer_id`,`points_balance`,`lifetime_points`,`updated_at`) VALUES('6','6','150','150','2026-08-05 20:25:18');

DROP TABLE IF EXISTS `loyalty_transactions`;
CREATE TABLE `loyalty_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `transaction_type` enum('earn','redeem','adjustment','refund') NOT NULL,
  `points` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `loyalty_transactions_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `loyalty_accounts` (`id`),
  CONSTRAINT `loyalty_transactions_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `loyalty_transactions` (`id`,`account_id`,`sale_id`,`transaction_type`,`points`,`description`,`created_by`,`created_at`) VALUES('1','4','1','earn','50','Earned from invoice INV-260805-0001','1','2026-08-05 20:08:29');
INSERT INTO `loyalty_transactions` (`id`,`account_id`,`sale_id`,`transaction_type`,`points`,`description`,`created_by`,`created_at`) VALUES('2','5','2','earn','50','Earned from invoice INV-260805-0002','1','2026-08-05 20:14:16');
INSERT INTO `loyalty_transactions` (`id`,`account_id`,`sale_id`,`transaction_type`,`points`,`description`,`created_by`,`created_at`) VALUES('3','6','3','earn','150','Earned from invoice INV-260805-0003','1','2026-08-05 20:25:18');

DROP TABLE IF EXISTS `maintenance_logs`;
CREATE TABLE `maintenance_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `issue` text NOT NULL,
  `technician` varchar(150) DEFAULT NULL,
  `cost` decimal(14,2) DEFAULT 0.00,
  `reported_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `next_due_date` date DEFAULT NULL,
  `status` enum('reported','in_progress','completed') DEFAULT 'reported',
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `maintenance_logs_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `maintenance_logs_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`),
  CONSTRAINT `maintenance_logs_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `memberships`;
CREATE TABLE `memberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(14,2) DEFAULT 0.00,
  `duration_days` int(11) DEFAULT 365,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `priority_booking` tinyint(1) DEFAULT 0,
  `free_services_text` text DEFAULT NULL,
  `birthday_gift` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `memberships` (`id`,`branch_id`,`name`,`price`,`duration_days`,`discount_percent`,`priority_booking`,`free_services_text`,`birthday_gift`,`status`) VALUES('1','1','Silver','50000.00','365','5.00','0',NULL,'Birthday discount','active');
INSERT INTO `memberships` (`id`,`branch_id`,`name`,`price`,`duration_days`,`discount_percent`,`priority_booking`,`free_services_text`,`birthday_gift`,`status`) VALUES('2','1','Gold','100000.00','365','10.00','1',NULL,'Free manicure','active');
INSERT INTO `memberships` (`id`,`branch_id`,`name`,`price`,`duration_days`,`discount_percent`,`priority_booking`,`free_services_text`,`birthday_gift`,`status`) VALUES('3','1','VIP','200000.00','365','15.00','1',NULL,'Free facial','active');

DROP TABLE IF EXISTS `message_templates`;
CREATE TABLE `message_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `event_key` varchar(80) DEFAULT NULL,
  `channel` enum('sms','whatsapp','email') DEFAULT 'sms',
  `subject` varchar(180) DEFAULT NULL,
  `body` text NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `message_templates_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `message_templates` (`id`,`branch_id`,`name`,`event_key`,`channel`,`subject`,`body`,`status`) VALUES('1','1','Appointment Confirmation','appointment_confirmed','sms',NULL,'Hello {customer}, your appointment is confirmed for {date} at {time}.','active');
INSERT INTO `message_templates` (`id`,`branch_id`,`name`,`event_key`,`channel`,`subject`,`body`,`status`) VALUES('2','1','Appointment Reminder','appointment_reminder','sms',NULL,'Reminder: your appointment is on {date} at {time}.','active');
INSERT INTO `message_templates` (`id`,`branch_id`,`name`,`event_key`,`channel`,`subject`,`body`,`status`) VALUES('3','1','Birthday Wish','birthday','sms',NULL,'Happy birthday {customer}! We wish you a beautiful day.','active');
INSERT INTO `message_templates` (`id`,`branch_id`,`name`,`event_key`,`channel`,`subject`,`body`,`status`) VALUES('4','1','Payment Confirmation','payment','sms',NULL,'Payment of TZS {amount} received. Thank you.','active');

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `type` enum('sms','whatsapp','email','system') DEFAULT 'system',
  `recipient` varchar(150) DEFAULT NULL,
  `subject` varchar(180) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('queued','sent','failed','cancelled') DEFAULT 'queued',
  `scheduled_at` datetime DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `provider_response` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('1','1','1','sms','255712675431',NULL,'Hello Dorothy, your appointment request APT-260804-0001 is booked for 2026-08-04 at 09:00','queued','2026-08-04 15:48:18',NULL,NULL,'2026-08-04 15:48:18');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('2','1','1','sms','255712675431',NULL,'Hello Dorothy, your appointment request APT-260804-0002 is booked for 2026-08-04 at 09:00','queued','2026-08-04 15:49:03',NULL,NULL,'2026-08-04 15:49:03');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('3','1','1','sms','255712675431',NULL,'Hello Dorothy, your appointment request APT-260804-0003 is booked for 2026-08-04 at 09:00','queued','2026-08-04 15:49:22',NULL,NULL,'2026-08-04 15:49:22');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('4','1','1','whatsapp','255712675431',NULL,'Hello Dorothy, your appointment request APT-260804-0004 is booked for 2026-08-04 at 09:00','queued','2026-08-04 15:49:32',NULL,NULL,'2026-08-04 15:49:32');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('5','1',NULL,'whatsapp','0712903883',NULL,'Hello dorothy, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-04 16:17:25',NULL,NULL,'2026-08-04 16:17:25');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('6','1','2','whatsapp','255712345678',NULL,'Hello rose, your appointment request APT-260804-0005 is booked for 2026-08-13 at 15:00','queued','2026-08-04 16:22:00',NULL,NULL,'2026-08-04 16:22:00');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('7','1','2','whatsapp','255712345678',NULL,'Hello rose, your appointment request APT-260804-0006 is booked for 2026-08-13 at 15:00','queued','2026-08-04 16:23:29',NULL,NULL,'2026-08-04 16:23:29');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('8','1',NULL,'whatsapp','0712903883',NULL,'Hello, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-04 16:24:54',NULL,NULL,'2026-08-04 16:24:54');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('9','1',NULL,'whatsapp','5068376973',NULL,'Hello, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-04 16:29:29',NULL,NULL,'2026-08-04 16:29:29');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('10','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0007 is booked for 2026-08-18 at 20:00','queued','2026-08-04 16:32:21',NULL,NULL,'2026-08-04 16:32:21');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('11','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0008 is booked for 2026-08-18 at 20:00','queued','2026-08-04 16:32:52',NULL,NULL,'2026-08-04 16:32:52');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('12','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0009 is booked for 2026-08-18 at 20:00','queued','2026-08-04 16:33:00',NULL,NULL,'2026-08-04 16:33:00');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('13','1','3','whatsapp','5068376973',NULL,'Hello John, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-04 16:39:11',NULL,NULL,'2026-08-04 16:39:11');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('14','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0010 is booked for 2026-08-05 at 11:00','queued','2026-08-04 16:40:04',NULL,NULL,'2026-08-04 16:40:04');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('15','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0011 is booked for 2026-08-05 at 11:00','queued','2026-08-04 16:40:23',NULL,NULL,'2026-08-04 16:40:23');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('16','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0012 is booked for 2026-08-05 at 11:00','queued','2026-08-04 16:40:28',NULL,NULL,'2026-08-04 16:40:28');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('17','1','3','whatsapp','5068376973',NULL,'Hello John, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-04 16:47:59',NULL,NULL,'2026-08-04 16:47:59');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('18','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0013 is booked for 2026-08-06 at 15:00','queued','2026-08-04 16:49:35',NULL,NULL,'2026-08-04 16:49:35');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('19','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0014 is booked for 2026-08-06 at 15:00','queued','2026-08-04 16:49:50',NULL,NULL,'2026-08-04 16:49:50');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('20','1','3','whatsapp','5068376973',NULL,'Hello John, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-04 16:53:37',NULL,NULL,'2026-08-04 16:53:37');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('21','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0015 is booked for 2026-08-07 at 11:00','queued','2026-08-04 16:54:45',NULL,NULL,'2026-08-04 16:54:45');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('22','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0016 is booked for 2026-08-07 at 11:00','queued','2026-08-04 16:55:27',NULL,NULL,'2026-08-04 16:55:27');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('23','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0017 is booked for 2026-08-07 at 11:00','queued','2026-08-04 16:58:54',NULL,NULL,'2026-08-04 16:58:54');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('24','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0018 is booked for 2026-08-07 at 11:00','queued','2026-08-04 16:58:57',NULL,NULL,'2026-08-04 16:58:57');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('25','1','3','whatsapp','5068376973',NULL,'Hello John, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-04 16:59:06',NULL,NULL,'2026-08-04 16:59:06');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('26','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0019 is booked for 2026-08-08 at 10:00','queued','2026-08-04 17:00:08',NULL,NULL,'2026-08-04 17:00:08');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('27','1','3','whatsapp','5068376973',NULL,'Hello John, your appointment request APT-260804-0020 is booked for 2026-08-08 at 10:00','queued','2026-08-04 17:00:32',NULL,NULL,'2026-08-04 17:00:32');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('28','1','3','whatsapp','5068376973',NULL,'Hello John, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-05 19:44:17',NULL,NULL,'2026-08-05 19:44:17');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('29','1','4','sms','255623456789',NULL,'Payment of TZS 0 received for invoice INV-260805-0001','queued','2026-08-05 20:08:29',NULL,NULL,'2026-08-05 20:08:29');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('30','1','5','sms','255634567890',NULL,'Payment of TZS 50,000 received for invoice INV-260805-0002','queued','2026-08-05 20:14:16',NULL,NULL,'2026-08-05 20:14:16');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('31','1','6','sms','255765123456',NULL,'Payment of TZS 0 received for invoice INV-260805-0003','queued','2026-08-05 20:25:18',NULL,NULL,'2026-08-05 20:25:18');
INSERT INTO `notifications` (`id`,`branch_id`,`customer_id`,`type`,`recipient`,`subject`,`message`,`status`,`scheduled_at`,`sent_at`,`provider_response`,`created_at`) VALUES('32','1',NULL,'whatsapp','0712903883',NULL,'Hello dorothy, you can book your salon/spa appointment with Uzuri Salon & Spa - Main Branch using this link: https://departed-unplug-spiny.ngrok-free.dev/salon_spa_management_system/public_booking.php?branch=1','queued','2026-08-05 21:32:44',NULL,NULL,'2026-08-05 21:32:44');

DROP TABLE IF EXISTS `package_services`;
CREATE TABLE `package_services` (
  `package_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  PRIMARY KEY (`package_id`,`service_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `package_services_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `package_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `package_services` (`package_id`,`service_id`,`quantity`) VALUES('1','6','1');
INSERT INTO `package_services` (`package_id`,`service_id`,`quantity`) VALUES('1','12','1');
INSERT INTO `package_services` (`package_id`,`service_id`,`quantity`) VALUES('1','20','1');
INSERT INTO `package_services` (`package_id`,`service_id`,`quantity`) VALUES('2','11','1');
INSERT INTO `package_services` (`package_id`,`service_id`,`quantity`) VALUES('2','13','1');
INSERT INTO `package_services` (`package_id`,`service_id`,`quantity`) VALUES('2','14','1');

DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `regular_price` decimal(14,2) DEFAULT 0.00,
  `package_price` decimal(14,2) NOT NULL,
  `validity_days` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `packages` (`id`,`branch_id`,`name`,`description`,`regular_price`,`package_price`,`validity_days`,`status`,`created_at`) VALUES('1','1','Bridal Package','Hair + bridal makeup + nails','230000.00','200000.00','0','active','2026-08-04 15:12:27');
INSERT INTO `packages` (`id`,`branch_id`,`name`,`description`,`regular_price`,`package_price`,`validity_days`,`status`,`created_at`) VALUES('2','1','Spa Day Package','Massage + facial + pedicure','115000.00','100000.00','0','active','2026-08-04 15:12:27');
INSERT INTO `packages` (`id`,`branch_id`,`name`,`description`,`regular_price`,`package_price`,`validity_days`,`status`,`created_at`) VALUES('3','1','Birthday Package','Hair treatment + makeup + manicure','90000.00','80000.00','0','active','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `payment_method` enum('cash','mpesa','airtel_money','tigo_pesa','halopesa','bank','card','gift_card','other') NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `gift_card_id` int(11) DEFAULT NULL,
  `received_by` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `sale_id` (`sale_id`),
  KEY `gift_card_id` (`gift_card_id`),
  KEY `received_by` (`received_by`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`gift_card_id`) REFERENCES `gift_cards` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_ibfk_4` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `payments` (`id`,`branch_id`,`sale_id`,`payment_method`,`amount`,`reference_no`,`gift_card_id`,`received_by`,`payment_date`,`notes`) VALUES('1','1','1','cash','50000.00','',NULL,'1','2026-08-05 20:10:14','Balance payment');
INSERT INTO `payments` (`id`,`branch_id`,`sale_id`,`payment_method`,`amount`,`reference_no`,`gift_card_id`,`received_by`,`payment_date`,`notes`) VALUES('2','1','2','cash','50000.00','',NULL,'1','2026-08-05 20:14:16',NULL);
INSERT INTO `payments` (`id`,`branch_id`,`sale_id`,`payment_method`,`amount`,`reference_no`,`gift_card_id`,`received_by`,`payment_date`,`notes`) VALUES('3','1','3','cash','150000.00','',NULL,'1','2026-08-05 20:25:27','Balance payment');

DROP TABLE IF EXISTS `payroll_items`;
CREATE TABLE `payroll_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payroll_run_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `basic_salary` decimal(14,2) DEFAULT 0.00,
  `commission_amount` decimal(14,2) DEFAULT 0.00,
  `bonus` decimal(14,2) DEFAULT 0.00,
  `deductions` decimal(14,2) DEFAULT 0.00,
  `advance_amount` decimal(14,2) DEFAULT 0.00,
  `net_salary` decimal(14,2) DEFAULT 0.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_reference` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payroll_run_id` (`payroll_run_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `payroll_items_ibfk_1` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payroll_items_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `payroll_runs`;
CREATE TABLE `payroll_runs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `status` enum('draft','approved','paid') DEFAULT 'draft',
  `approved_by` int(11) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `approved_by` (`approved_by`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `payroll_runs_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `payroll_runs_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payroll_runs_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `name` varchar(120) NOT NULL,
  `module` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('1','dashboard.view','View dashboard','Dashboard');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('2','appointments.view','View appointments','Appointments');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('3','appointments.manage','Manage appointments','Appointments');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('4','queue.manage','Manage walk-ins and queue','Queue');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('5','sales.view','View sales','Sales');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('6','sales.create','Create sales','Sales');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('7','sales.refund','Request refunds','Sales');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('8','customers.view','View customers','Customers');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('9','customers.manage','Manage customers','Customers');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('10','services.manage','Manage services and packages','Services');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('11','inventory.view','View inventory','Inventory');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('12','inventory.manage','Manage inventory','Inventory');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('13','purchases.manage','Manage purchases','Inventory');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('14','suppliers.manage','Manage suppliers','Inventory');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('15','expenses.manage','Manage expenses','Finance');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('16','staff.view','View staff','Staff');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('17','staff.manage','Manage staff','Staff');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('18','attendance.manage','Manage attendance','Staff');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('19','commissions.view','View commissions','Payroll');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('20','payroll.manage','Manage payroll','Payroll');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('21','loyalty.manage','Manage loyalty','Customers');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('22','giftcards.manage','Manage gift cards','Customers');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('23','promotions.manage','Manage promotions','Marketing');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('24','memberships.manage','Manage memberships','Marketing');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('25','equipment.manage','Manage equipment','Equipment');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('26','refunds.manage','Manage refunds','Finance');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('27','reports.view','View reports','Reports');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('28','notifications.manage','Manage notifications','Marketing');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('29','documents.manage','Manage documents','Documents');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('30','audit.view','View audit logs','Security');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('31','settings.manage','Manage settings','Settings');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('32','users.manage','Manage users and roles','Security');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('33','branches.manage','Manage branches','Branches');
INSERT INTO `permissions` (`id`,`code`,`name`,`module`) VALUES('34','branches.view_all','View all branches','Branches');

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `product_categories` (`id`,`branch_id`,`name`,`description`,`status`) VALUES('1','1','Hair Care',NULL,'active');
INSERT INTO `product_categories` (`id`,`branch_id`,`name`,`description`,`status`) VALUES('2','1','Nail Care',NULL,'active');
INSERT INTO `product_categories` (`id`,`branch_id`,`name`,`description`,`status`) VALUES('3','1','Skin Care',NULL,'active');
INSERT INTO `product_categories` (`id`,`branch_id`,`name`,`description`,`status`) VALUES('4','1','Massage & Spa',NULL,'active');
INSERT INTO `product_categories` (`id`,`branch_id`,`name`,`description`,`status`) VALUES('5','1','Consumables',NULL,'active');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `barcode` varchar(80) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `unit` varchar(30) DEFAULT 'piece',
  `buying_price` decimal(14,2) DEFAULT 0.00,
  `selling_price` decimal(14,2) DEFAULT 0.00,
  `minimum_stock` decimal(12,2) DEFAULT 0.00,
  `expiry_date` date DEFAULT NULL,
  `track_stock` tinyint(1) DEFAULT 1,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_branch_barcode` (`branch_id`,`barcode`),
  KEY `category_id` (`category_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `products` (`id`,`branch_id`,`category_id`,`supplier_id`,`barcode`,`name`,`brand`,`unit`,`buying_price`,`selling_price`,`minimum_stock`,`expiry_date`,`track_stock`,`status`,`created_at`) VALUES('1','1','1','1','100001','Professional Shampoo','Uzuri','bottle','12000.00','18000.00','5.00','2028-08-04','1','active','2026-08-04 15:12:27');
INSERT INTO `products` (`id`,`branch_id`,`category_id`,`supplier_id`,`barcode`,`name`,`brand`,`unit`,`buying_price`,`selling_price`,`minimum_stock`,`expiry_date`,`track_stock`,`status`,`created_at`) VALUES('2','1','1','1','100002','Conditioner','Uzuri','bottle','13000.00','20000.00','8.00','2028-08-04','1','active','2026-08-04 15:12:27');
INSERT INTO `products` (`id`,`branch_id`,`category_id`,`supplier_id`,`barcode`,`name`,`brand`,`unit`,`buying_price`,`selling_price`,`minimum_stock`,`expiry_date`,`track_stock`,`status`,`created_at`) VALUES('3','1','1','1','100003','Hair Oil','Natural Glow','bottle','8000.00','15000.00','5.00','2028-08-04','1','active','2026-08-04 15:12:27');
INSERT INTO `products` (`id`,`branch_id`,`category_id`,`supplier_id`,`barcode`,`name`,`brand`,`unit`,`buying_price`,`selling_price`,`minimum_stock`,`expiry_date`,`track_stock`,`status`,`created_at`) VALUES('4','1','1','2','100004','Hair Dye Black','Color Pro','pack','7000.00','12000.00','8.00','2028-02-04','1','active','2026-08-04 15:12:27');
INSERT INTO `products` (`id`,`branch_id`,`category_id`,`supplier_id`,`barcode`,`name`,`brand`,`unit`,`buying_price`,`selling_price`,`minimum_stock`,`expiry_date`,`track_stock`,`status`,`created_at`) VALUES('5','1','2','2','200001','Gel Nail Polish','Nail Pro','bottle','5000.00','10000.00','10.00','2028-08-04','1','active','2026-08-04 15:12:27');
INSERT INTO `products` (`id`,`branch_id`,`category_id`,`supplier_id`,`barcode`,`name`,`brand`,`unit`,`buying_price`,`selling_price`,`minimum_stock`,`expiry_date`,`track_stock`,`status`,`created_at`) VALUES('6','1','3','2','300001','Facial Cream','Skin Glow','jar','15000.00','25000.00','4.00','2028-02-04','1','active','2026-08-04 15:12:27');
INSERT INTO `products` (`id`,`branch_id`,`category_id`,`supplier_id`,`barcode`,`name`,`brand`,`unit`,`buying_price`,`selling_price`,`minimum_stock`,`expiry_date`,`track_stock`,`status`,`created_at`) VALUES('7','1','4','1','400001','Massage Oil','Relax','bottle','12000.00','22000.00','4.00','2028-08-04','1','active','2026-08-04 15:12:27');
INSERT INTO `products` (`id`,`branch_id`,`category_id`,`supplier_id`,`barcode`,`name`,`brand`,`unit`,`buying_price`,`selling_price`,`minimum_stock`,`expiry_date`,`track_stock`,`status`,`created_at`) VALUES('8','1','5','1','500001','Disposable Gloves','SafeHands','box','15000.00','25000.00','3.00','2029-08-04','1','active','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `promotion_customers`;
CREATE TABLE `promotion_customers` (
  `promotion_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`promotion_id`,`customer_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `promotion_customers_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotion_customers_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `promotion_services`;
CREATE TABLE `promotion_services` (
  `promotion_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`promotion_id`,`service_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `promotion_services_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotion_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(40) DEFAULT NULL,
  `discount_type` enum('percentage','fixed','bogo') DEFAULT 'percentage',
  `discount_value` decimal(14,2) DEFAULT 0.00,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `day_of_week` varchar(50) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `min_spend` decimal(14,2) DEFAULT 0.00,
  `customer_scope` enum('all','specific','members','new','returning') DEFAULT 'all',
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `promotions_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `purchase_items`;
CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(12,2) NOT NULL,
  `unit_cost` decimal(14,2) NOT NULL,
  `line_total` decimal(14,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `purchase_items_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `purchase_no` varchar(40) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `invoice_number` varchar(80) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `subtotal` decimal(14,2) DEFAULT 0.00,
  `paid_amount` decimal(14,2) DEFAULT 0.00,
  `payment_status` enum('unpaid','partial','paid') DEFAULT 'unpaid',
  `status` enum('draft','received','cancelled') DEFAULT 'received',
  `received_by` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_no` (`purchase_no`),
  KEY `branch_id` (`branch_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `received_by` (`received_by`),
  CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `purchases_ibfk_3` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `queues`;
CREATE TABLE `queues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `queue_date` date NOT NULL,
  `queue_number` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `status` enum('waiting','called','in_service','completed','cancelled','no_show') DEFAULT 'waiting',
  `checked_in_at` datetime DEFAULT current_timestamp(),
  `called_at` datetime DEFAULT NULL,
  `service_started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_queue` (`branch_id`,`queue_date`,`queue_number`),
  KEY `visit_id` (`visit_id`),
  KEY `customer_id` (`customer_id`),
  KEY `staff_id` (`staff_id`),
  KEY `idx_queues_appointment` (`appointment_id`),
  KEY `idx_queues_service` (`service_id`),
  CONSTRAINT `queues_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `queues_ibfk_2` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE SET NULL,
  CONSTRAINT `queues_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `queues_ibfk_4` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `queues` (`id`,`branch_id`,`visit_id`,`appointment_id`,`customer_id`,`queue_date`,`queue_number`,`service_id`,`staff_id`,`status`,`checked_in_at`,`called_at`,`service_started_at`,`completed_at`,`notes`) VALUES('1','1',NULL,NULL,'4','2026-08-05','1','21','1','completed','2026-08-05 20:07:28',NULL,'2026-08-05 20:07:54','2026-08-05 20:08:29','');
INSERT INTO `queues` (`id`,`branch_id`,`visit_id`,`appointment_id`,`customer_id`,`queue_date`,`queue_number`,`service_id`,`staff_id`,`status`,`checked_in_at`,`called_at`,`service_started_at`,`completed_at`,`notes`) VALUES('2','1',NULL,NULL,'5','2026-08-05','2',NULL,'1','completed','2026-08-05 20:10:46',NULL,'2026-08-05 20:10:55','2026-08-05 20:14:16','');
INSERT INTO `queues` (`id`,`branch_id`,`visit_id`,`appointment_id`,`customer_id`,`queue_date`,`queue_number`,`service_id`,`staff_id`,`status`,`checked_in_at`,`called_at`,`service_started_at`,`completed_at`,`notes`) VALUES('3','1',NULL,NULL,'6','2026-08-05','3',NULL,'1','completed','2026-08-05 20:24:53',NULL,'2026-08-05 20:24:58','2026-08-05 20:25:18','');

DROP TABLE IF EXISTS `refund_items`;
CREATE TABLE `refund_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_id` int(11) NOT NULL,
  `sale_item_id` int(11) NOT NULL,
  `quantity` decimal(12,2) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `restock` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `refund_id` (`refund_id`),
  KEY `sale_item_id` (`sale_item_id`),
  CONSTRAINT `refund_items_ibfk_1` FOREIGN KEY (`refund_id`) REFERENCES `refunds` (`id`) ON DELETE CASCADE,
  CONSTRAINT `refund_items_ibfk_2` FOREIGN KEY (`sale_item_id`) REFERENCES `sale_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `refunds`;
CREATE TABLE `refunds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `refund_no` varchar(40) DEFAULT NULL,
  `sale_id` int(11) NOT NULL,
  `refund_type` enum('partial','full') DEFAULT 'partial',
  `requested_amount` decimal(14,2) NOT NULL,
  `approved_amount` decimal(14,2) DEFAULT 0.00,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `requested_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `refund_no` (`refund_no`),
  KEY `branch_id` (`branch_id`),
  KEY `sale_id` (`sale_id`),
  KEY `approved_by` (`approved_by`),
  KEY `requested_by` (`requested_by`),
  CONSTRAINT `refunds_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `refunds_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  CONSTRAINT `refunds_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `refunds_ibfk_4` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','1');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','2');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','3');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','4');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','5');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','6');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','7');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','8');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','9');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','10');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','11');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','12');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','13');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','14');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','15');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','16');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','17');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','18');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','19');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','20');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','21');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','22');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','23');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','24');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','25');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','26');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','27');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','28');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','29');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','30');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','31');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','32');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','33');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('1','34');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','1');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','2');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','3');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','4');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','5');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','6');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','7');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','8');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','9');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','10');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','11');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','12');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','13');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','14');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','15');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','16');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','17');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','18');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','19');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','20');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','21');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','22');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','23');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','24');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','25');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','26');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','27');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','28');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','29');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','30');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','31');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','33');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('2','34');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','1');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','2');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','3');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','4');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','5');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','6');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','8');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','9');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('3','28');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('4','1');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('4','5');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('4','6');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('4','8');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('4','22');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('4','27');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('5','1');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('5','11');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('5','12');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('5','13');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('5','14');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('5','25');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('5','29');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('6','1');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('6','2');
INSERT INTO `role_permissions` (`role_id`,`permission_id`) VALUES('6','8');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `roles` (`id`,`name`,`description`,`is_system`,`created_at`) VALUES('1','Owner','Full system access','1','2026-08-04 15:12:27');
INSERT INTO `roles` (`id`,`name`,`description`,`is_system`,`created_at`) VALUES('2','Manager','Business operations and reports','1','2026-08-04 15:12:27');
INSERT INTO `roles` (`id`,`name`,`description`,`is_system`,`created_at`) VALUES('3','Receptionist','Customers, queue and appointments','1','2026-08-04 15:12:27');
INSERT INTO `roles` (`id`,`name`,`description`,`is_system`,`created_at`) VALUES('4','Cashier','POS and payments','1','2026-08-04 15:12:27');
INSERT INTO `roles` (`id`,`name`,`description`,`is_system`,`created_at`) VALUES('5','Storekeeper','Inventory and purchases','1','2026-08-04 15:12:27');
INSERT INTO `roles` (`id`,`name`,`description`,`is_system`,`created_at`) VALUES('6','Staff','Own appointments and limited access','1','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `sale_items`;
CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `item_type` enum('service','product','package') NOT NULL,
  `item_id` int(11) NOT NULL,
  `description` varchar(180) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT 1.00,
  `unit_price` decimal(14,2) NOT NULL,
  `discount_amount` decimal(14,2) DEFAULT 0.00,
  `line_total` decimal(14,2) NOT NULL,
  `refunded_quantity` decimal(12,2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `sale_items` (`id`,`sale_id`,`item_type`,`item_id`,`description`,`staff_id`,`quantity`,`unit_price`,`discount_amount`,`line_total`,`refunded_quantity`) VALUES('1','1','service','21','Henna','1','1.00','25000.00','0.00','25000.00','0.00');
INSERT INTO `sale_items` (`id`,`sale_id`,`item_type`,`item_id`,`description`,`staff_id`,`quantity`,`unit_price`,`discount_amount`,`line_total`,`refunded_quantity`) VALUES('2','1','service','21','Henna','1','1.00','25000.00','0.00','25000.00','0.00');
INSERT INTO `sale_items` (`id`,`sale_id`,`item_type`,`item_id`,`description`,`staff_id`,`quantity`,`unit_price`,`discount_amount`,`line_total`,`refunded_quantity`) VALUES('3','2','service','6','Braiding','1','1.00','50000.00','0.00','50000.00','0.00');
INSERT INTO `sale_items` (`id`,`sale_id`,`item_type`,`item_id`,`description`,`staff_id`,`quantity`,`unit_price`,`discount_amount`,`line_total`,`refunded_quantity`) VALUES('4','3','service','16','Body Scrub','1','1.00','45000.00','0.00','45000.00','0.00');
INSERT INTO `sale_items` (`id`,`sale_id`,`item_type`,`item_id`,`description`,`staff_id`,`quantity`,`unit_price`,`discount_amount`,`line_total`,`refunded_quantity`) VALUES('5','3','service','6','Braiding','1','1.00','50000.00','0.00','50000.00','0.00');
INSERT INTO `sale_items` (`id`,`sale_id`,`item_type`,`item_id`,`description`,`staff_id`,`quantity`,`unit_price`,`discount_amount`,`line_total`,`refunded_quantity`) VALUES('6','3','service','22','Eyelashes','1','1.00','25000.00','0.00','25000.00','0.00');
INSERT INTO `sale_items` (`id`,`sale_id`,`item_type`,`item_id`,`description`,`staff_id`,`quantity`,`unit_price`,`discount_amount`,`line_total`,`refunded_quantity`) VALUES('7','3','service','10','Gel Nails','1','1.00','30000.00','0.00','30000.00','0.00');

DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `invoice_no` varchar(40) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `queue_id` int(11) DEFAULT NULL,
  `sale_date` datetime DEFAULT current_timestamp(),
  `subtotal` decimal(14,2) DEFAULT 0.00,
  `discount_amount` decimal(14,2) DEFAULT 0.00,
  `tax_amount` decimal(14,2) DEFAULT 0.00,
  `total_amount` decimal(14,2) DEFAULT 0.00,
  `paid_amount` decimal(14,2) DEFAULT 0.00,
  `balance_amount` decimal(14,2) DEFAULT 0.00,
  `status` enum('draft','partial','paid','refunded','partially_refunded','cancelled') DEFAULT 'paid',
  `promotion_id` int(11) DEFAULT NULL,
  `membership_discount` decimal(14,2) DEFAULT 0.00,
  `loyalty_points_redeemed` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`invoice_no`),
  KEY `sale_date_idx` (`branch_id`,`sale_date`),
  KEY `customer_id` (`customer_id`),
  KEY `appointment_id` (`appointment_id`),
  KEY `queue_id` (`queue_id`),
  KEY `promotion_id` (`promotion_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_ibfk_4` FOREIGN KEY (`queue_id`) REFERENCES `queues` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_ibfk_5` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_ibfk_6` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `sales` (`id`,`branch_id`,`invoice_no`,`customer_id`,`appointment_id`,`queue_id`,`sale_date`,`subtotal`,`discount_amount`,`tax_amount`,`total_amount`,`paid_amount`,`balance_amount`,`status`,`promotion_id`,`membership_discount`,`loyalty_points_redeemed`,`notes`,`created_by`,`created_at`) VALUES('1','1','INV-260805-0001','4',NULL,'1','2026-08-05 20:08:29','50000.00','0.00','0.00','50000.00','50000.00','0.00','paid',NULL,'0.00','0','','1','2026-08-05 20:08:29');
INSERT INTO `sales` (`id`,`branch_id`,`invoice_no`,`customer_id`,`appointment_id`,`queue_id`,`sale_date`,`subtotal`,`discount_amount`,`tax_amount`,`total_amount`,`paid_amount`,`balance_amount`,`status`,`promotion_id`,`membership_discount`,`loyalty_points_redeemed`,`notes`,`created_by`,`created_at`) VALUES('2','1','INV-260805-0002','5',NULL,'2','2026-08-05 20:14:16','50000.00','0.00','0.00','50000.00','50000.00','0.00','paid',NULL,'0.00','0','','1','2026-08-05 20:14:16');
INSERT INTO `sales` (`id`,`branch_id`,`invoice_no`,`customer_id`,`appointment_id`,`queue_id`,`sale_date`,`subtotal`,`discount_amount`,`tax_amount`,`total_amount`,`paid_amount`,`balance_amount`,`status`,`promotion_id`,`membership_discount`,`loyalty_points_redeemed`,`notes`,`created_by`,`created_at`) VALUES('3','1','INV-260805-0003','6',NULL,'3','2026-08-05 20:25:18','150000.00','0.00','0.00','150000.00','150000.00','0.00','paid',NULL,'0.00','0','','1','2026-08-05 20:25:18');

DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `service_categories_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `service_categories` (`id`,`branch_id`,`name`,`description`,`status`,`created_at`) VALUES('1','1','Hair',NULL,'active','2026-08-04 15:12:27');
INSERT INTO `service_categories` (`id`,`branch_id`,`name`,`description`,`status`,`created_at`) VALUES('2','1','Nails',NULL,'active','2026-08-04 15:12:27');
INSERT INTO `service_categories` (`id`,`branch_id`,`name`,`description`,`status`,`created_at`) VALUES('3','1','Spa',NULL,'active','2026-08-04 15:12:27');
INSERT INTO `service_categories` (`id`,`branch_id`,`name`,`description`,`status`,`created_at`) VALUES('4','1','Massage',NULL,'active','2026-08-04 15:12:27');
INSERT INTO `service_categories` (`id`,`branch_id`,`name`,`description`,`status`,`created_at`) VALUES('5','1','Beauty',NULL,'active','2026-08-04 15:12:27');
INSERT INTO `service_categories` (`id`,`branch_id`,`name`,`description`,`status`,`created_at`) VALUES('6','1','Makeup',NULL,'active','2026-08-04 15:12:27');
INSERT INTO `service_categories` (`id`,`branch_id`,`name`,`description`,`status`,`created_at`) VALUES('7','1','Waxing',NULL,'active','2026-08-04 15:12:27');
INSERT INTO `service_categories` (`id`,`branch_id`,`name`,`description`,`status`,`created_at`) VALUES('8','1','Bridal',NULL,'active','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `service_products`;
CREATE TABLE `service_products` (
  `service_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_used` decimal(12,3) NOT NULL DEFAULT 1.000,
  PRIMARY KEY (`service_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `service_products_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `service_products` (`service_id`,`product_id`,`quantity_used`) VALUES('2','1','0.100');
INSERT INTO `service_products` (`service_id`,`product_id`,`quantity_used`) VALUES('2','2','0.080');
INSERT INTO `service_products` (`service_id`,`product_id`,`quantity_used`) VALUES('4','4','1.000');
INSERT INTO `service_products` (`service_id`,`product_id`,`quantity_used`) VALUES('4','8','0.020');
INSERT INTO `service_products` (`service_id`,`product_id`,`quantity_used`) VALUES('13','6','0.050');
INSERT INTO `service_products` (`service_id`,`product_id`,`quantity_used`) VALUES('14','7','0.100');

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT 30,
  `price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `commission_type` enum('none','percentage','fixed') DEFAULT 'percentage',
  `commission_value` decimal(10,2) DEFAULT 0.00,
  `status` enum('active','inactive') DEFAULT 'active',
  `continuation_required` tinyint(1) NOT NULL DEFAULT 0,
  `continuation_after_days` int(11) NOT NULL DEFAULT 0,
  `continuation_service_id` int(11) DEFAULT NULL,
  `continuation_message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `services_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `services_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('1','1','1','Hair Cut',NULL,'30','10000.00','percentage','10.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('2','1','1','Hair Wash',NULL,'30','10000.00','percentage','10.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('3','1','1','Hair Relaxing',NULL,'90','35000.00','percentage','12.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('4','1','1','Hair Coloring',NULL,'120','60000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('5','1','1','Hair Treatment',NULL,'60','30000.00','percentage','12.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('6','1','1','Braiding',NULL,'180','50000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('7','1','1','Weaving',NULL,'150','45000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('8','1','1','Wig Installation',NULL,'120','50000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('9','1','2','Nail Polish',NULL,'30','10000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('10','1','2','Gel Nails',NULL,'60','30000.00','percentage','20.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('11','1','2','Pedicure',NULL,'60','25000.00','percentage','20.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('12','1','2','Manicure',NULL,'45','20000.00','percentage','20.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('13','1','3','Facial',NULL,'60','40000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('14','1','4','Full Body Massage',NULL,'60','50000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('15','1','3','Steam Bath',NULL,'45','30000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('16','1','3','Body Scrub',NULL,'60','45000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('17','1','7','Waxing',NULL,'45','30000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('18','1','5','Eyebrow Threading',NULL,'20','8000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('19','1','6','Makeup',NULL,'60','40000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('20','1','8','Bridal Makeup',NULL,'120','150000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('21','1','5','Henna',NULL,'45','25000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);
INSERT INTO `services` (`id`,`branch_id`,`category_id`,`name`,`description`,`duration_minutes`,`price`,`commission_type`,`commission_value`,`status`,`continuation_required`,`continuation_after_days`,`continuation_service_id`,`continuation_message`,`created_at`,`updated_at`) VALUES('22','1','5','Eyelashes',NULL,'45','25000.00','percentage','15.00','active','0','0',NULL,NULL,'2026-08-04 15:12:27',NULL);

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_group` varchar(80) DEFAULT 'general',
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_setting` (`branch_id`,`setting_key`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `settings_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('1','1','business_name','Eden Salon & Spa','business','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('2','1','business_phone','0712345678','business','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('3','1','business_address','Dar-Es-Salaam, Tanzania','business','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('4','1','receipt_footer','Asante kwa kutuchagua. Karibu tena!','receipt','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('5','1','loyalty_spend_per_point','1000','loyalty','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('6','1','loyalty_point_value','100','loyalty','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('7','1','tax_percent','0','finance','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('8','1','appointment_reminder_hours','24','notifications','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('9','1','auto_logout_minutes','5','security','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('13','1','business_email','','business','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('14','1','tin','','business','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('15','1','vrn','','business','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('20','1','working_hours','','business','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('23','1','whatsapp_country_code','','business','1','2026-08-05 20:56:12');
INSERT INTO `settings` (`id`,`branch_id`,`setting_key`,`setting_value`,`setting_group`,`updated_by`,`updated_at`) VALUES('24','1','public_booking_base_url','','business','1','2026-08-05 20:56:12');

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `employee_no` varchar(30) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `full_name` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT 'Female',
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role_title` varchar(100) DEFAULT NULL,
  `salary` decimal(14,2) DEFAULT 0.00,
  `default_commission_type` enum('percentage','fixed') DEFAULT 'percentage',
  `default_commission_value` decimal(10,2) DEFAULT 0.00,
  `employment_date` date DEFAULT NULL,
  `emergency_contact` varchar(120) DEFAULT NULL,
  `status` enum('active','inactive','terminated') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_no` (`employee_no`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `staff` (`id`,`branch_id`,`employee_no`,`photo`,`full_name`,`phone`,`email`,`gender`,`date_of_birth`,`address`,`role_title`,`salary`,`default_commission_type`,`default_commission_value`,`employment_date`,`emergency_contact`,`status`,`created_at`,`updated_at`) VALUES('1','1','EMP-001',NULL,'tester.developer','0712345678',NULL,'Female',NULL,NULL,'Owner','0.00','percentage','18.00','2026-08-04',NULL,'active','2026-08-04 15:12:27','2026-08-05 20:28:42');
INSERT INTO `staff` (`id`,`branch_id`,`employee_no`,`photo`,`full_name`,`phone`,`email`,`gender`,`date_of_birth`,`address`,`role_title`,`salary`,`default_commission_type`,`default_commission_value`,`employment_date`,`emergency_contact`,`status`,`created_at`,`updated_at`) VALUES('2','1','EMP-002',NULL,'nustahiya jamal','0765123456',NULL,'Female','2005-10-12',NULL,'staff','0.00','percentage','19.00','2026-08-05',NULL,'active','2026-08-05 20:30:13','2026-08-05 20:42:10');

DROP TABLE IF EXISTS `stock_adjustment_items`;
CREATE TABLE `stock_adjustment_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adjustment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_change` decimal(12,3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `adjustment_id` (`adjustment_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_adjustment_items_ibfk_1` FOREIGN KEY (`adjustment_id`) REFERENCES `stock_adjustments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_adjustment_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `stock_adjustment_items` (`id`,`adjustment_id`,`product_id`,`quantity_change`) VALUES('1','1','7','1.000');
INSERT INTO `stock_adjustment_items` (`id`,`adjustment_id`,`product_id`,`quantity_change`) VALUES('2','4','7','-3.001');

DROP TABLE IF EXISTS `stock_adjustments`;
CREATE TABLE `stock_adjustments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `adjustment_no` varchar(40) DEFAULT NULL,
  `reason` enum('damage','expired','lost','correction','internal_use','opening') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `adjustment_no` (`adjustment_no`),
  KEY `branch_id` (`branch_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `stock_adjustments_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `stock_adjustments_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `stock_adjustments` (`id`,`branch_id`,`adjustment_no`,`reason`,`notes`,`created_by`,`created_at`) VALUES('1','1','ADJ-260806-0001','correction','','1','2026-08-06 18:13:01');
INSERT INTO `stock_adjustments` (`id`,`branch_id`,`adjustment_no`,`reason`,`notes`,`created_by`,`created_at`) VALUES('2','1','ADJ-260806-0002','damage','','1','2026-08-06 18:13:46');
INSERT INTO `stock_adjustments` (`id`,`branch_id`,`adjustment_no`,`reason`,`notes`,`created_by`,`created_at`) VALUES('3','1','ADJ-260806-0003','damage','','1','2026-08-06 18:14:18');
INSERT INTO `stock_adjustments` (`id`,`branch_id`,`adjustment_no`,`reason`,`notes`,`created_by`,`created_at`) VALUES('4','1','ADJ-260806-0004','correction','','1','2026-08-06 18:15:07');

DROP TABLE IF EXISTS `stock_count_items`;
CREATE TABLE `stock_count_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_count_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `system_quantity` decimal(12,3) DEFAULT 0.000,
  `counted_quantity` decimal(12,3) DEFAULT 0.000,
  `variance` decimal(12,3) DEFAULT 0.000,
  PRIMARY KEY (`id`),
  KEY `stock_count_id` (`stock_count_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_count_items_ibfk_1` FOREIGN KEY (`stock_count_id`) REFERENCES `stock_counts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_count_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `stock_counts`;
CREATE TABLE `stock_counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `count_no` varchar(40) DEFAULT NULL,
  `count_date` date NOT NULL,
  `status` enum('draft','completed') DEFAULT 'draft',
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `count_no` (`count_no`),
  KEY `branch_id` (`branch_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `stock_counts_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `stock_counts_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `stock_levels`;
CREATE TABLE `stock_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(12,2) DEFAULT 0.00,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_branch_product` (`branch_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_levels_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `stock_levels_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `stock_levels` (`id`,`branch_id`,`product_id`,`quantity`,`updated_at`) VALUES('1','1','1','20.00','2026-08-04 15:12:27');
INSERT INTO `stock_levels` (`id`,`branch_id`,`product_id`,`quantity`,`updated_at`) VALUES('2','1','2','20.00','2026-08-04 15:12:27');
INSERT INTO `stock_levels` (`id`,`branch_id`,`product_id`,`quantity`,`updated_at`) VALUES('3','1','3','20.00','2026-08-04 15:12:27');
INSERT INTO `stock_levels` (`id`,`branch_id`,`product_id`,`quantity`,`updated_at`) VALUES('4','1','4','20.00','2026-08-04 15:12:27');
INSERT INTO `stock_levels` (`id`,`branch_id`,`product_id`,`quantity`,`updated_at`) VALUES('5','1','5','20.00','2026-08-04 15:12:27');
INSERT INTO `stock_levels` (`id`,`branch_id`,`product_id`,`quantity`,`updated_at`) VALUES('6','1','6','20.00','2026-08-04 15:12:27');
INSERT INTO `stock_levels` (`id`,`branch_id`,`product_id`,`quantity`,`updated_at`) VALUES('7','1','7','18.00','2026-08-06 18:15:07');
INSERT INTO `stock_levels` (`id`,`branch_id`,`product_id`,`quantity`,`updated_at`) VALUES('8','1','8','20.00','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `stock_movements`;
CREATE TABLE `stock_movements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `movement_type` enum('opening','purchase','sale','service_use','adjustment','transfer_in','transfer_out','refund','internal_use') NOT NULL,
  `quantity` decimal(12,3) NOT NULL,
  `balance_after` decimal(12,3) NOT NULL,
  `reference_type` varchar(50) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `product_id` (`product_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `stock_movements_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `stock_movements_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `stock_movements_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('1','1','1','opening','20.000','20.000','installation',NULL,'Sample opening stock',NULL,'2026-08-04 15:12:27');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('2','1','2','opening','20.000','20.000','installation',NULL,'Sample opening stock',NULL,'2026-08-04 15:12:27');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('3','1','3','opening','20.000','20.000','installation',NULL,'Sample opening stock',NULL,'2026-08-04 15:12:27');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('4','1','4','opening','20.000','20.000','installation',NULL,'Sample opening stock',NULL,'2026-08-04 15:12:27');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('5','1','5','opening','20.000','20.000','installation',NULL,'Sample opening stock',NULL,'2026-08-04 15:12:27');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('6','1','6','opening','20.000','20.000','installation',NULL,'Sample opening stock',NULL,'2026-08-04 15:12:27');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('7','1','7','opening','20.000','20.000','installation',NULL,'Sample opening stock',NULL,'2026-08-04 15:12:27');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('8','1','8','opening','20.000','20.000','installation',NULL,'Sample opening stock',NULL,'2026-08-04 15:12:27');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('9','1','7','adjustment','1.000','21.000','adjustment','1','correction','1','2026-08-06 18:13:01');
INSERT INTO `stock_movements` (`id`,`branch_id`,`product_id`,`movement_type`,`quantity`,`balance_after`,`reference_type`,`reference_id`,`notes`,`created_by`,`created_at`) VALUES('10','1','7','adjustment','-3.001','18.000','adjustment','4','correction','1','2026-08-06 18:15:07');

DROP TABLE IF EXISTS `stock_transfer_items`;
CREATE TABLE `stock_transfer_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(12,3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_id` (`transfer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_transfer_items_ibfk_1` FOREIGN KEY (`transfer_id`) REFERENCES `stock_transfers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_transfer_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `stock_transfers`;
CREATE TABLE `stock_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_no` varchar(40) DEFAULT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `status` enum('draft','sent','received','cancelled') DEFAULT 'received',
  `transfer_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `received_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `transfer_no` (`transfer_no`),
  KEY `from_branch_id` (`from_branch_id`),
  KEY `to_branch_id` (`to_branch_id`),
  KEY `created_by` (`created_by`),
  KEY `received_by` (`received_by`),
  CONSTRAINT `stock_transfers_ibfk_1` FOREIGN KEY (`from_branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `stock_transfers_ibfk_2` FOREIGN KEY (`to_branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `stock_transfers_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_transfers_ibfk_4` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `supplier_payments`;
CREATE TABLE `supplier_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `supplier_payments_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `supplier_payments_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `supplier_payments_ibfk_3` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE SET NULL,
  CONSTRAINT `supplier_payments_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `opening_balance` decimal(14,2) DEFAULT 0.00,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `suppliers` (`id`,`branch_id`,`name`,`phone`,`email`,`address`,`opening_balance`,`status`,`created_at`) VALUES('1','1','Mwanza Beauty Supplies','+255 754 000 100',NULL,'Mwanza','0.00','active','2026-08-04 15:12:27');
INSERT INTO `suppliers` (`id`,`branch_id`,`name`,`phone`,`email`,`address`,`opening_balance`,`status`,`created_at`) VALUES('2','1','Dar Cosmetics Wholesale','+255 713 000 200',NULL,'Dar es Salaam','0.00','active','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `system_activities`;
CREATE TABLE `system_activities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity_type` varchar(50) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `activity_date` (`branch_id`,`created_at`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `system_activities_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `system_activities_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('1','1',NULL,'appointment','Public booking created: APT-260804-0001','2026-08-04 15:48:18');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('2','1',NULL,'appointment','Public booking created: APT-260804-0002','2026-08-04 15:49:03');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('3','1',NULL,'appointment','Public booking created: APT-260804-0003','2026-08-04 15:49:22');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('4','1',NULL,'appointment','Public booking created: APT-260804-0004','2026-08-04 15:49:32');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('5','1',NULL,'appointment','Public booking created: APT-260804-0005','2026-08-04 16:22:00');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('6','1',NULL,'appointment','Public booking created: APT-260804-0006','2026-08-04 16:23:29');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('7','1',NULL,'appointment','Public booking created: APT-260804-0007','2026-08-04 16:32:21');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('8','1',NULL,'appointment','Public booking created: APT-260804-0008','2026-08-04 16:32:52');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('9','1',NULL,'appointment','Public booking created: APT-260804-0009','2026-08-04 16:33:00');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('10','1',NULL,'appointment','Public booking created: APT-260804-0010','2026-08-04 16:40:04');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('11','1',NULL,'appointment','Public booking created: APT-260804-0011','2026-08-04 16:40:23');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('12','1',NULL,'appointment','Public booking created: APT-260804-0012','2026-08-04 16:40:28');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('13','1',NULL,'appointment','Public booking created: APT-260804-0013','2026-08-04 16:49:35');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('14','1',NULL,'appointment','Public booking created: APT-260804-0014','2026-08-04 16:49:50');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('15','1',NULL,'appointment','Public booking created: APT-260804-0015','2026-08-04 16:54:45');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('16','1',NULL,'appointment','Public booking created: APT-260804-0016','2026-08-04 16:55:27');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('17','1',NULL,'appointment','Public booking created: APT-260804-0017','2026-08-04 16:58:54');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('18','1',NULL,'appointment','Public booking created: APT-260804-0018','2026-08-04 16:58:57');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('19','1',NULL,'appointment','Public booking created: APT-260804-0019','2026-08-04 17:00:08');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('20','1',NULL,'appointment','Public booking created: APT-260804-0020','2026-08-04 17:00:32');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('21','1','1','queue','Walk-in customer added to queue #1','2026-08-05 20:07:28');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('22','1','1','queue','Queue #1 marked in_service','2026-08-05 20:07:54');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('23','1','1','sale','Payment received for INV-260805-0001 (TZS 0)','2026-08-05 20:08:29');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('24','1','1','queue','Walk-in customer added to queue #2','2026-08-05 20:10:46');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('25','1','1','queue','Queue #2 marked in_service','2026-08-05 20:10:55');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('26','1','1','queue','Queue #2 marked no_show','2026-08-05 20:10:58');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('27','1','1','sale','Payment received for INV-260805-0002 (TZS 50,000)','2026-08-05 20:14:16');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('28','1','1','queue','Walk-in customer added to queue #3','2026-08-05 20:24:54');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('29','1','1','queue','Queue #3 marked in_service','2026-08-05 20:24:58');
INSERT INTO `system_activities` (`id`,`branch_id`,`user_id`,`activity_type`,`message`,`created_at`) VALUES('30','1','1','sale','Payment received for INV-260805-0003 (TZS 0)','2026-08-05 20:25:18');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('active','inactive','locked') DEFAULT 'active',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `branch_id` (`branch_id`),
  KEY `staff_id` (`staff_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `users` (`id`,`branch_id`,`staff_id`,`role_id`,`username`,`password_hash`,`status`,`last_login_at`,`created_at`) VALUES('1','1','1','1','admin.tester','$2y$10$ISdUui0adKdf5hldXEOfA.Pt0pPYMC7GWkwcKvpurd24mgorydrli','active','2026-08-07 15:52:34','2026-08-04 15:12:27');

DROP TABLE IF EXISTS `visits`;
CREATE TABLE `visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `visit_date` datetime DEFAULT current_timestamp(),
  `visit_type` enum('appointment','walk_in') DEFAULT 'walk_in',
  `status` enum('waiting','in_service','completed','cancelled') DEFAULT 'waiting',
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SET FOREIGN_KEY_CHECKS=1;
