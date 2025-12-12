-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 12, 2025 at 07:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `duan1_n1`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `id` int NOT NULL,
  `booking_id` int DEFAULT NULL,
  `tour_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sdt` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`id`, `booking_id`, `tour_id`, `name`, `sdt`, `address`, `type`, `created_at`, `updated_at`) VALUES
(2, 2, 8, 'Marina Bay Sands', '0987654321', '10 Bayfront Ave, Singapore', 'Hotel', '2025-11-13 15:48:24', '2025-12-12 09:15:00'),
(19, 39, 11, 'Hạ Long Bay Resort ', '0987654321', 'Bãi Cháy, Quảng Ninh ', 'Resort', '2025-12-05 09:07:33', '2025-12-12 09:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int NOT NULL,
  `booking_people_id` int NOT NULL,
  `attendance_date` date NOT NULL,
  `session` enum('morning','afternoon','evening') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'morning',
  `checkin_time` datetime DEFAULT NULL,
  `status` enum('not_checked','present','absent','late') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'not_checked',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `booking_people_id`, `attendance_date`, `session`, `checkin_time`, `status`, `note`, `created_at`, `updated_at`) VALUES
(27, 13, '2025-12-09', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(28, 14, '2025-12-09', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(29, 15, '2025-12-09', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(30, 16, '2025-12-09', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(31, 17, '2025-12-09', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(32, 18, '2025-12-09', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(33, 19, '2025-12-09', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(34, 11, '2025-12-09', 'morning', NULL, 'absent', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(35, 12, '2025-12-09', 'morning', NULL, 'absent', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(37, 53, '2025-12-09', 'morning', NULL, 'present', '', '2025-12-09 16:09:05', '2025-12-09 16:09:05'),
(38, 52, '2025-12-09', 'morning', NULL, 'absent', '', '2025-12-09 16:09:05', '2025-12-09 16:09:05'),
(39, 13, '2025-12-08', 'morning', NULL, 'absent', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(40, 14, '2025-12-08', 'morning', NULL, 'absent', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(41, 15, '2025-12-08', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(42, 16, '2025-12-08', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(43, 17, '2025-12-08', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(44, 18, '2025-12-08', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(45, 19, '2025-12-08', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(46, 11, '2025-12-08', 'morning', NULL, 'present', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(47, 12, '2025-12-08', 'morning', NULL, 'absent', '', '2025-12-09 16:06:58', '2025-12-09 16:06:58'),
(48, 53, '2025-12-08', 'morning', NULL, 'present', '', '2025-12-09 16:09:05', '2025-12-09 16:09:05'),
(49, 52, '2025-12-08', 'morning', NULL, 'present', '', '2025-12-09 16:09:05', '2025-12-09 16:09:05');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_dates`
--

CREATE TABLE `attendance_dates` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `date` date NOT NULL,
  `is_locked` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_dates`
--

INSERT INTO `attendance_dates` (`id`, `booking_id`, `date`, `is_locked`, `created_at`) VALUES
(239, 39, '2025-12-01', 0, '2025-12-05 02:07:33'),
(240, 39, '2025-12-02', 0, '2025-12-05 02:07:33'),
(241, 39, '2025-12-03', 0, '2025-12-05 02:07:33'),
(242, 39, '2025-12-04', 0, '2025-12-05 02:07:33'),
(243, 2, '2025-12-06', 0, '2025-12-12 03:06:43'),
(244, 2, '2025-12-07', 0, '2025-12-12 03:06:43'),
(245, 2, '2025-12-08', 0, '2025-12-12 03:06:43'),
(246, 2, '2025-12-09', 0, '2025-12-12 03:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  `payment_status` enum('unpaid','paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'unpaid',
  `status` enum('pending','confirmed','cancelled','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `special_request` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `max_people` int DEFAULT '30',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `tour_id`, `guide_id`, `payment_status`, `status`, `special_request`, `start_date`, `end_date`, `max_people`, `created_at`, `updated_at`) VALUES
(2, 8, 1, 'paid', 'pending', 'Xe riêng đưa đón sân bay', '2025-12-06', '2025-12-09', 30, '2025-11-13 15:48:24', '2025-12-08 17:36:50'),
(39, 11, 2, 'paid', 'confirmed', 'dcawd', '2025-12-01', '2025-12-04', 10, '2025-12-05 09:07:33', '2025-12-08 16:54:36');

--
-- Triggers `bookings`
--
DELIMITER $$
CREATE TRIGGER `create_attendance_dates` AFTER INSERT ON `bookings` FOR EACH ROW BEGIN
    DECLARE current_day DATE;

    SET current_day = NEW.start_date;

    WHILE current_day <= NEW.end_date DO
        INSERT INTO attendance_dates (booking_id, date)
        VALUES (NEW.id, current_day);

        SET current_day = DATE_ADD(current_day, INTERVAL 1 DAY);
    END WHILE;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bookings_people`
--

CREATE TABLE `bookings_people` (
  `id` int NOT NULL,
  `fullname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date` date DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cccd` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `booking_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings_people`
--

INSERT INTO `bookings_people` (`id`, `fullname`, `date`, `phone`, `cccd`, `note`, `created_at`, `updated_at`, `booking_id`) VALUES
(11, 'Nguyen Van L', '2025-01-05', '911234567', '12060819', 'Dễ say xe', '2025-12-08 16:35:36', '2025-12-08 16:35:36', 2),
(12, 'Tran Thi M', '2025-01-06', '912234567', '12060820', NULL, '2025-12-03 10:21:28', '2025-12-03 10:21:28', 2),
(13, 'Le Van N', '2025-01-07', '913234567', '12060821', NULL, '2025-12-03 10:21:28', '2025-12-03 10:21:28', 2),
(14, 'Pham Thi O', '2025-01-08', '914234567', '12060822', NULL, '2025-12-03 10:21:28', '2025-12-03 10:21:28', 2),
(15, 'Hoang Van P', '2025-01-09', '915234567', '12060823', NULL, '2025-12-03 10:21:28', '2025-12-03 10:21:28', 2),
(16, 'Vo Thi Q', '2025-01-10', '916234567', '12060824', NULL, '2025-12-03 10:21:28', '2025-12-03 10:21:28', 2),
(17, 'Dang Van R', '2025-01-11', '917234567', '12060825', NULL, '2025-12-03 10:21:28', '2025-12-03 10:21:28', 2),
(18, 'Do Thi S', '2025-01-12', '918234567', '12060826', NULL, '2025-12-03 10:22:06', '2025-12-03 10:22:06', 2),
(19, 'Phan Van T', '2025-01-13', '919234567', '12060827', NULL, '2025-12-03 10:21:28', '2025-12-03 10:21:28', 2),
(52, 'Do Thi S', '2025-01-12', '918234567', '12060826', '', '2025-12-08 16:49:11', '2025-12-08 16:49:11', 39),
(53, 'Tran Thi M', '2025-01-06', '912234567', '12060820', 'Dễ say xe', '2025-12-08 16:54:37', '2025-12-08 16:54:37', 39);

--
-- Triggers `bookings_people`
--
DELIMITER $$
CREATE TRIGGER `trg_after_insert_people` AFTER INSERT ON `bookings_people` FOR EACH ROW BEGIN
    UPDATE bookings 
    SET number_of_people = (
        SELECT COUNT(*) 
        FROM bookings_people 
        WHERE booking_id = NEW.booking_id
    )
    WHERE id = NEW.booking_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `description`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Hạ Long', 'Vịnh Hạ Long – kỳ quan thiên nhiên thế giới', 'Quảng Ninh', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(2, 'Singapore', 'Thành phố hiện đại và sạch đẹp bậc nhất châu Á', 'Singapore', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(3, 'cà mau', '	fdfawd', 'cà mau', '2025-11-28 13:58:04', '2025-11-28 13:58:04'),
(4, 'HCM', 'miền nam', 'HCM', '2025-12-07 16:42:41', '2025-12-07 16:42:41'),
(5, 'Vietnam', 'Điểm đến hấp dẫn tại Việt Nam', 'Hà Nội, TP. Hồ Chí Minh, Đà Nẵng', '2025-12-07 17:46:58', '2025-12-07 17:46:58'),
(6, 'Thailand', 'Xứ sở chùa vàng', 'Bangkok, Phuket, Chiang Mai', '2025-12-07 17:46:58', '2025-12-07 17:46:58'),
(7, 'Japan', 'Đất nước mặt trời mọc', 'Tokyo, Osaka, Kyoto', '2025-12-07 17:46:58', '2025-12-07 17:46:58'),
(8, 'Singapore', 'Quốc đảo sư tử', 'Singapore City', '2025-12-07 17:46:58', '2025-12-07 17:46:58'),
(9, 'China', 'Lịch sử 5000 năm', 'Beijing, Shanghai', '2025-12-07 17:46:58', '2025-12-07 17:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

CREATE TABLE `guides` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `full_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_years` int DEFAULT NULL,
  `certificates` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `languages` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`id`, `user_id`, `full_name`, `specialization`, `experience_years`, `certificates`, `languages`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Trần Văn Hướng', 'Hướng dẫn du lịch miền Bắc', 5, 'Chứng chỉ nghiệp vụ du lịch', 'Tiếng Việt, Tiếng Anh', 'available', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(2, 3, 'Nguyễn Thị Thảo', 'Hướng dẫn viên du lịch miền Bắc', 2, 'Chứng chỉ nghiệp vụ du lịch', 'Tiếng anh', 'active', '2025-12-05 05:28:16', '2025-12-05 05:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  `day_number` int DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('planned','in_progress','done') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'planned',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `tour_id`, `guide_id`, `day_number`, `location`, `activities`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(19, 8, 1, 1, 'Hạ Long - Hà Nội1', 'vbyft', 'planned', 'Kiểm tra hành lý trước khi rời khách sạn.', '2025-12-02 17:46:49', '2025-12-12 09:14:42'),
(24, 2, NULL, 1, '22', '22', 'planned', '22', '2025-12-03 06:52:56', '2025-12-03 06:52:56'),
(25, 1, NULL, 1, 'Hạ Long - Hà Nội1', '11', 'planned', 'Kiểm tra hành lý trước khi rời khách sạn.', '2025-12-03 06:53:31', '2025-12-03 06:53:31'),
(26, 1, NULL, 2, 'Hạ Long2', '222', 'planned', '212', '2025-12-03 09:59:24', '2025-12-03 09:59:24'),
(27, 11, 2, 1, 'Hạ Long - Hà Nội1', 'scagy', 'planned', 'àawf', '2025-12-07 16:53:29', '2025-12-12 09:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(12,2) DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `name`, `category_id`, `destination_id`, `description`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Khám phá Hà Nội 3N2Đ', 1, 1, 'Tham quan Vịnh Hà Nội ', '5000000.00', 'open', '2025-11-13 15:48:24', '2025-12-02 17:36:25'),
(2, 'Du lịch Singapore 4N3Đ', 2, 2, 'Khám phá Marina Bay, Sentosa, Garden by the Bay.', '12500000.00', 'open', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(8, 'cà mau', 1, 3, 'dfawdffawfd', '800000.00', 'open', '2025-11-28 13:58:42', '2025-11-29 22:35:18'),
(11, 'Du lịch Hồ Chí Minh 4N3', 2, 6, 'ưe', '3454354.00', 'open', '2025-12-07 16:53:29', '2025-12-07 17:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `tour_assignments`
--

CREATE TABLE `tour_assignments` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `booking_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_assignments`
--

INSERT INTO `tour_assignments` (`id`, `tour_id`, `guide_id`, `assigned_date`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `booking_id`) VALUES
(2, 2, 1, '2025-11-16', '2025-12-05', '2025-12-08', 'assigned', '2025-11-13 15:48:24', '2025-11-22 15:35:09', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tour_assignments_reports`
--

CREATE TABLE `tour_assignments_reports` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `guide_id` int NOT NULL,
  `tour_summary` text,
  `customer_situation` text,
  `incidents` text,
  `suggestions` text,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tour_assignments_reports`
--

INSERT INTO `tour_assignments_reports` (`id`, `booking_id`, `guide_id`, `tour_summary`, `customer_situation`, `incidents`, `suggestions`, `description`, `created_at`) VALUES
(3, 2, 2, 'ư', 'ư', 'ư', 'ư', NULL, '2025-12-06 21:38:35');

-- --------------------------------------------------------

--
-- Table structure for table `tour_categories`
--

CREATE TABLE `tour_categories` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_categories`
--

INSERT INTO `tour_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Tour trong nước', 'Một hội pháp sư nổi tiếng với những nhiệm vụ nguy hiểm và tình bạn khăng khít giữa các thành viên.', '2025-11-13 15:48:24', '2025-11-20 15:45:14'),
(2, 'Tour quốc tế', 'Trải nghiệm du lịch ở nước ngoài', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(3, 'Tour theo yêu cầu', 'Tùy chỉnh theo nhu cầu khách hàng', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `tour_report_images`
--

CREATE TABLE `tour_report_images` (
  `id` int NOT NULL,
  `report_id` int NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tour_report_images`
--

INSERT INTO `tour_report_images` (`id`, `report_id`, `image_path`, `created_at`) VALUES
(2, 3, 'uploads/reports/1765031915_69343feb5ae71_3.jpg', '2025-12-06 21:38:35');

-- --------------------------------------------------------

--
-- Table structure for table `transports`
--

CREATE TABLE `transports` (
  `id` int NOT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seats` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `driver_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_cccd` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_birthdate` date DEFAULT NULL,
  `license_plate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Điểm đón khách',
  `pickup_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Địa chỉ điểm đón',
  `pickup_time` time DEFAULT NULL COMMENT 'Giờ đón',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `booking_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transports`
--

INSERT INTO `transports` (`id`, `type`, `company`, `seats`, `driver_name`, `driver_cccd`, `driver_phone`, `driver_birthdate`, `license_plate`, `pickup_location`, `pickup_address`, `pickup_time`, `created_at`, `updated_at`, `booking_id`) VALUES
(40, 'Máy bay', 'Vietnam Airlines', '180', 'Nguyễn Văn Lâm', '036987654322', '0321456987', '1980-05-13', '51B-123.46', 'bến xe', 'cổng 3', '07:00:00', '2025-12-03 08:49:29', '2025-12-07 16:29:26', 2),
(69, 'Xe du lịch 45 chỗ', 'hoafpt', '45', 'Nguyễn Văn Hùng', '00120454608', '01234656458', '1980-12-11', '29A-2548', 'bến xe', 'cổng 3', '07:00:00', '2025-12-05 09:07:33', '2025-12-05 09:07:33', 39);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `email`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$VCDC8oQYf//wXXVQpBmrieuIhVkXQxJo.4zGOb8E23aq6Db6RMWIK', 'admin', 'Nguyễn Văn Admin', 'admin@tour.vn', '0901234567', 'active', '2025-11-13 15:48:24', '2025-11-13 16:23:08'),
(2, 'guide01', '$2y$10$VCDC8oQYf//wXXVQpBmrieuIhVkXQxJo.4zGOb8E23aq6Db6RMWIK', 'guide', 'Trần Văn Hướng', 'guide01@example.com', '0907654321', 'active', '2025-11-13 15:48:24', '2025-12-12 09:13:05'),
(3, 'guide2', '$2y$10$VCDC8oQYf//wXXVQpBmrieuIhVkXQxJo.4zGOb8E23aq6Db6RMWIK', 'guide', 'Nguyễn Thị Thảo', 'guide02@example.com', '0910234567', 'active', '2025-12-05 05:37:47', '2025-12-12 09:13:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accommodations_ibfk_2` (`booking_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_person_date_session` (`booking_people_id`,`attendance_date`,`session`),
  ADD KEY `booking_people_id` (`booking_people_id`);

--
-- Indexes for table `attendance_dates`
--
ALTER TABLE `attendance_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `bookings_ibfk_6` (`guide_id`);

--
-- Indexes for table `bookings_people`
--
ALTER TABLE `bookings_people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_booking_people` (`booking_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `tour_assignments`
--
ALTER TABLE `tour_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `tour_assignments_ibfk_3` (`booking_id`);

--
-- Indexes for table `tour_assignments_reports`
--
ALTER TABLE `tour_assignments_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_booking` (`booking_id`),
  ADD KEY `idx_guide` (`guide_id`);

--
-- Indexes for table `tour_categories`
--
ALTER TABLE `tour_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tour_report_images`
--
ALTER TABLE `tour_report_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_report` (`report_id`);

--
-- Indexes for table `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transports_ibfk_2` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `attendance_dates`
--
ALTER TABLE `attendance_dates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `bookings_people`
--
ALTER TABLE `bookings_people`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tour_assignments`
--
ALTER TABLE `tour_assignments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tour_assignments_reports`
--
ALTER TABLE `tour_assignments_reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tour_categories`
--
ALTER TABLE `tour_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tour_report_images`
--
ALTER TABLE `tour_report_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transports`
--
ALTER TABLE `transports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD CONSTRAINT `accommodations_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`booking_people_id`) REFERENCES `bookings_people` (`id`);

--
-- Constraints for table `attendance_dates`
--
ALTER TABLE `attendance_dates`
  ADD CONSTRAINT `attendance_dates_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_6` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `bookings_people`
--
ALTER TABLE `bookings_people`
  ADD CONSTRAINT `fk_booking_people` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guides`
--
ALTER TABLE `guides`
  ADD CONSTRAINT `guides_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tour_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tours_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tour_assignments`
--
ALTER TABLE `tour_assignments`
  ADD CONSTRAINT `tour_assignments_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_assignments_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tour_assignments_ibfk_3` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `tour_assignments_reports`
--
ALTER TABLE `tour_assignments_reports`
  ADD CONSTRAINT `fk_report_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_report_guide` FOREIGN KEY (`guide_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `tour_report_images`
--
ALTER TABLE `tour_report_images`
  ADD CONSTRAINT `fk_image_report` FOREIGN KEY (`report_id`) REFERENCES `tour_assignments_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transports`
--
ALTER TABLE `transports`
  ADD CONSTRAINT `transports_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
