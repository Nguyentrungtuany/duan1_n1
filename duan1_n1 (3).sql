-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 24, 2025 lúc 07:41 AM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duan1_n1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accommodations`
--

CREATE TABLE `accommodations` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `booking_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `accommodations`
--

INSERT INTO `accommodations` (`id`, `tour_id`, `booking_id`, `name`, `address`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Khách sạn', 'dưa', 'Hotel', '2025-11-13 15:48:24', '2025-11-22 16:42:28'),
(2, 2, 2, 'Marina Bay Sands', '10 Bayfront Ave, Singapore', 'Hotel', '2025-11-13 15:48:24', '2025-11-22 16:42:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `number_of_people` int DEFAULT NULL,
  `payment_status` enum('unpaid','paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'unpaid',
  `status` enum('pending','confirmed','cancelled','completed') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `special_request` text COLLATE utf8mb4_unicode_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `tour_id`, `customer_id`, `category_id`, `destination_id`, `number_of_people`, `payment_status`, `status`, `special_request`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 1, 10, 'unpaid', 'pending', ' 11', '2025-12-01', '2025-12-03', '2025-11-13 15:48:24', '2025-11-24 02:41:02'),
(2, 2, 2, 2, 2, 10, 'paid', 'pending', 'Xe riêng đưa đón sân bay', '2025-12-05', '2025-12-08', '2025-11-13 15:48:24', '2025-11-24 00:04:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings_people`
--

CREATE TABLE `bookings_people` (
  `id` int NOT NULL,
  `tuor_id` int DEFAULT NULL,
  `fullname` text COLLATE utf8mb4_unicode_ci,
  `date` date DEFAULT NULL,
  `phone` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `booking_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings_people`
--

INSERT INTO `bookings_people` (`id`, `tuor_id`, `fullname`, `date`, `phone`, `created_at`, `updated_at`, `booking_id`) VALUES
(1, 1, 'Nguyen Van A', '2025-01-05', 901234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(2, 1, 'Tran Thi B', '2025-01-06', 902234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(3, 1, 'Le Van C', '2025-01-07', 903234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(4, 1, 'Pham Thi D', '2025-01-08', 904234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(5, 1, 'Hoang Van E', '2025-01-09', 905234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(6, 1, 'Vo Thi F', '2025-01-10', 906234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(7, 1, 'Dang Van G', '2025-01-11', 907234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(8, 1, 'Do Thi H', '2025-01-12', 908234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(9, 1, 'Phan Van I', '2025-01-13', 909234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(10, 1, 'Bui Thi K', '2025-01-14', 910234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 1),
(11, 2, 'Nguyen Van L', '2025-01-05', 911234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2),
(12, 2, 'Tran Thi M', '2025-01-06', 912234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2),
(13, 2, 'Le Van N', '2025-01-07', 913234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2),
(14, 2, 'Pham Thi O', '2025-01-08', 914234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2),
(15, 2, 'Hoang Van P', '2025-01-09', 915234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2),
(16, 2, 'Vo Thi Q', '2025-01-10', 916234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2),
(17, 2, 'Dang Van R', '2025-01-11', 917234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2),
(18, 2, 'Do Thi S', '2025-01-12', 918234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2),
(19, 2, 'Phan Van T', '2025-01-13', 919234567, '2025-11-23 14:58:47', '2025-11-23 14:58:47', 2);

--
-- Bẫy `bookings_people`
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
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `phone`, `email`, `address`, `type`, `note`, `created_at`, `updated_at`) VALUES
(1, 'Lê Minh Tuấn', '0912345678', 'tuanle@example.com', 'Hà Nội', 'individual', 'Yêu cầu phòng view biển', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(2, 'Ngọc Anh Group', '0987654321', 'groupna@example.com', 'TP.HCM', 'group', 'Đi đoàn 5 người', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_support`
--

CREATE TABLE `customer_support` (
  `id` int NOT NULL,
  `booking_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_support`
--

INSERT INTO `customer_support` (`id`, `booking_id`, `customer_id`, `guide_id`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Tôi muốn xác nhận lại lịch trình ngày thứ 2.', 'resolved', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `destinations`
--

CREATE TABLE `destinations` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `description`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Hạ Long', 'Vịnh Hạ Long – kỳ quan thiên nhiên thế giới', 'Quảng Ninh', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(2, 'Singapore', 'Thành phố hiện đại và sạch đẹp bậc nhất châu Á', 'Singapore', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Đang đổ dữ liệu cho bảng `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `tour_id`, `guide_id`, `customer_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 5, 'Hướng dẫn viên nhiệt tình, chuyến đi tuyệt vời!', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(2, 2, 1, 2, 4, 'Tour tổ chức chuyên nghiệp, nhưng ăn sáng hơi ít món.', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guides`
--

CREATE TABLE `guides` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_years` int DEFAULT NULL,
  `certificates` text COLLATE utf8mb4_unicode_ci,
  `languages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `guides`
--

INSERT INTO `guides` (`id`, `user_id`, `full_name`, `specialization`, `experience_years`, `certificates`, `languages`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Trần Văn Hướng', 'Hướng dẫn du lịch miền Bắc', 5, 'Chứng chỉ nghiệp vụ du lịch', 'Tiếng Việt, Tiếng Anh', 'available', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `booking_id` int DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `payment_method`, `payment_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3500000.00, 'bank_transfer', '2025-11-10 10:00:00', 'success', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(2, 2, 62500000.00, 'card', '2025-11-11 12:00:00', 'success', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_tour_reports`
--

CREATE TABLE `post_tour_reports` (
  `id` int NOT NULL,
  `assignment_id` int DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  `tour_id` int DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `incidents` text COLLATE utf8mb4_unicode_ci,
  `recommendations` text COLLATE utf8mb4_unicode_ci,
  `report_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedules`
--

CREATE TABLE `schedules` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `booking_id` int NOT NULL,
  `day_number` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activities` text COLLATE utf8mb4_unicode_ci,
  `guide_id` int DEFAULT NULL,
  `status` enum('planned','in_progress','done') COLLATE utf8mb4_unicode_ci DEFAULT 'planned',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `schedules`
--

INSERT INTO `schedules` (`id`, `tour_id`, `booking_id`, `day_number`, `date`, `location`, `activities`, `guide_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 1, '2025-11-21', 'Vịnh Hạ Long', 'Tham quan hang Sửng Sốt, chèo kayak quanh đảo Titop, tắm biển, thưởng thức hải sản buổi tối.', 1, 'planned', 'Chuẩn bị đồ tắm và kem chống nắng.', '2025-11-13 15:51:27', '2025-11-22 21:20:31'),
(3, 1, 1, 1, '2025-11-22', 'Hạ Long - Hà Nội1', 'Ăn sáng tại khách sạn, mua quà lưu niệm, khởi hành về Hà Nội lúc 11h trưa. Kết thúc tour vào buổi chiều.', NULL, 'planned', 'Kiểm tra hành lý trước khi rời khách sạn.', '2025-11-13 15:51:27', '2025-11-22 15:38:19'),
(15, 1, 1, 2, '2025-11-20', 'Cà mau', 'thăm quan', NULL, 'planned', 'Mang theo phao', '2025-11-16 16:12:19', '2025-11-22 21:20:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `statistics_reports`
--

CREATE TABLE `statistics_reports` (
  `id` int NOT NULL,
  `report_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_start` date DEFAULT NULL,
  `period_end` date DEFAULT NULL,
  `data_summary` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `statistics_reports`
--

INSERT INTO `statistics_reports` (`id`, `report_name`, `report_type`, `period_start`, `period_end`, `data_summary`, `created_at`, `updated_at`) VALUES
(1, 'Doanh thu tháng 11', 'revenue', '2025-11-01', '2025-11-30', 'Tổng doanh thu đạt 69,000,000 VNĐ', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `name`, `category_id`, `destination_id`, `description`, `start_date`, `end_date`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Khám phá Hà Nội 3N2Đ', 1, 1, 'Tham quan Vịnh Hà Nội ', '2025-11-18', '2025-11-19', 500000.00, 'inactive', '2025-11-13 15:48:24', '2025-11-14 21:52:25'),
(2, 'Du lịch Singapore 4N3Đ', 2, 2, 'Khám phá Marina Bay, Sentosa, Garden by the Bay.', '2025-12-05', '2025-12-08', 12500000.00, 'open', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_assignments`
--

CREATE TABLE `tour_assignments` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `booking_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_assignments`
--

INSERT INTO `tour_assignments` (`id`, `tour_id`, `guide_id`, `assigned_date`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `booking_id`) VALUES
(1, 1, 1, '2025-11-15', '2025-12-01', '2025-12-03', 'assigned', '2025-11-13 15:48:24', '2025-11-22 15:35:07', 1),
(2, 2, 1, '2025-11-16', '2025-12-05', '2025-12-08', 'assigned', '2025-11-13 15:48:24', '2025-11-22 15:35:09', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_categories`
--

CREATE TABLE `tour_categories` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_categories`
--

INSERT INTO `tour_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Tour trong nước', 'Một hội pháp sư nổi tiếng với những nhiệm vụ nguy hiểm và tình bạn khăng khít giữa các thành viên.', '2025-11-13 15:48:24', '2025-11-20 15:45:14'),
(2, 'Tour quốc tế', 'Trải nghiệm du lịch ở nước ngoài', '2025-11-13 15:48:24', '2025-11-13 15:48:24'),
(3, 'Tour theo yêu cầu', 'Tùy chỉnh theo nhu cầu khách hàng', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transports`
--

CREATE TABLE `transports` (
  `id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seats` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `booking_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transports`
--

INSERT INTO `transports` (`id`, `tour_id`, `type`, `company`, `seats`, `created_at`, `updated_at`, `booking_id`) VALUES
(1, 2, 'Máy bay', 'Vietnam Airlines', '180', '2025-11-13 15:48:24', '2025-11-22 15:02:00', 2),
(13, 1, '785', '757857', '47', '2025-11-24 01:04:58', '2025-11-24 01:04:58', NULL),
(16, NULL, 'Xe du lịch 45 chỗ', '755', '75', '2025-11-24 01:16:54', '2025-11-24 01:16:54', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `email`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$VCDC8oQYf//wXXVQpBmrieuIhVkXQxJo.4zGOb8E23aq6Db6RMWIK', 'admin', 'Nguyễn Văn Admin', 'admin@tour.vn', '0901234567', 'active', '2025-11-13 15:48:24', '2025-11-13 16:23:08'),
(2, 'guide01', '123456', 'guide', 'Trần Văn Hướng', 'guide01@example.com', '0907654321', 'active', '2025-11-13 15:48:24', '2025-11-13 15:48:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `accommodations_ibfk_2` (`booking_id`);

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `bookings_ibfk_3` (`category_id`),
  ADD KEY `bookings_ibfk_4` (`destination_id`),
  ADD KEY `bookings_ibfk_5` (`number_of_people`);

--
-- Chỉ mục cho bảng `bookings_people`
--
ALTER TABLE `bookings_people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_booking_people` (`booking_id`),
  ADD KEY `fk_tour_id` (`tuor_id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer_support`
--
ALTER TABLE `customer_support`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `guide_id` (`guide_id`);

--
-- Chỉ mục cho bảng `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `post_tour_reports`
--
ALTER TABLE `post_tour_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `fk_schedules_guide` (`guide_id`),
  ADD KEY `schedules_ibfk_2` (`booking_id`);

--
-- Chỉ mục cho bảng `statistics_reports`
--
ALTER TABLE `statistics_reports`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Chỉ mục cho bảng `tour_assignments`
--
ALTER TABLE `tour_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `tour_assignments_ibfk_3` (`booking_id`);

--
-- Chỉ mục cho bảng `tour_categories`
--
ALTER TABLE `tour_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `transports_ibfk_2` (`booking_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `bookings_people`
--
ALTER TABLE `bookings_people`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `customer_support`
--
ALTER TABLE `customer_support`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `post_tour_reports`
--
ALTER TABLE `post_tour_reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `statistics_reports`
--
ALTER TABLE `statistics_reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tour_assignments`
--
ALTER TABLE `tour_assignments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tour_categories`
--
ALTER TABLE `tour_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `transports`
--
ALTER TABLE `transports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `accommodations`
--
ALTER TABLE `accommodations`
  ADD CONSTRAINT `accommodations_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accommodations_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `tour_categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `bookings_ibfk_5` FOREIGN KEY (`number_of_people`) REFERENCES `bookings_people` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ràng buộc cho bảng `bookings_people`
--
ALTER TABLE `bookings_people`
  ADD CONSTRAINT `fk_booking_people` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tour_id` FOREIGN KEY (`tuor_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ràng buộc cho bảng `customer_support`
--
ALTER TABLE `customer_support`
  ADD CONSTRAINT `customer_support_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_support_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_support_ibfk_3` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedbacks_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `feedbacks_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `guides`
--
ALTER TABLE `guides`
  ADD CONSTRAINT `guides_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `post_tour_reports`
--
ALTER TABLE `post_tour_reports`
  ADD CONSTRAINT `post_tour_reports_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `tour_assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tour_reports_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `post_tour_reports_ibfk_3` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `fk_schedules_guide` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`),
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ràng buộc cho bảng `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tour_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tours_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `tour_assignments`
--
ALTER TABLE `tour_assignments`
  ADD CONSTRAINT `tour_assignments_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_assignments_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tour_assignments_ibfk_3` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ràng buộc cho bảng `transports`
--
ALTER TABLE `transports`
  ADD CONSTRAINT `transports_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transports_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
