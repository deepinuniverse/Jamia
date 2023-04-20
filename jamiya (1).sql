-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2023 at 06:11 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jamiya`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_categories_id` int(10) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hours` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `branch_categories_id`, `address`, `phone`, `hours`, `picture`, `location`, `created_at`, `updated_at`) VALUES
(1, 'vvs', 1, 'asas', 'ww', '12', '', 'https://stackoverflow.com/questions/5335528/how-to-rename-a-table-in-sql-server', '2023-03-31 18:04:02', '2023-04-09 16:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `branch_categories`
--

CREATE TABLE `branch_categories` (
  `id` int(10) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_categories`
--

INSERT INTO `branch_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Branch10', '2023-03-27 16:10:05', '2023-03-28 08:29:02'),
(2, 'Branch2', '2023-04-01 10:56:34', '2023-04-01 10:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(10) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `name`, `number`, `email`, `reason`, `notes`, `admin_note`, `created_at`, `updated_at`) VALUES
(1, 'Customer1', '7766554433', 'h@gmail.com', 'DONE', 'I hhf', 'adnnsdbs bbs b', '2023-04-01 11:01:40', '2023-04-14 18:10:36');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_offers`
--

CREATE TABLE `coupon_offers` (
  `id` int(10) NOT NULL,
  `offer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offer_categories_id` int(10) NOT NULL,
  `picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `from_dt` date DEFAULT NULL,
  `to_dt` date DEFAULT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_offers`
--

INSERT INTO `coupon_offers` (`id`, `offer_name`, `offer_categories_id`, `picture`, `description`, `from_dt`, `to_dt`, `contact_no`, `created_at`, `updated_at`) VALUES
(1, 'bbb b', 2, '', 'bbb', '2023-03-29', '2023-03-29', '123456', '2023-03-29 11:34:15', '2023-03-29 11:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_users`
--

CREATE TABLE `coupon_users` (
  `id` int(10) NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shareholder_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civil_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_reports` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_users`
--

INSERT INTO `coupon_users` (`id`, `username`, `email`, `phone`, `shareholder_no`, `civil_id`, `password`, `action`, `generate_reports`, `created_at`, `updated_at`) VALUES
(1, 'sdsdd', 'scc', '32434', '343434', '344', '$2y$10$RLbNcheTkLPsGNnf0DOdtuqAB4qUPq3gIBeqJtz.XfzIPiKPg0CfO', 'Block', 'Y', '2023-04-08 11:30:22', '2023-04-08 11:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `id` int(10) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `directors`
--

INSERT INTO `directors` (`id`, `name`, `position`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Sachin', 'Admin', 'http://127.0.0.1:8000/storage/directors/64219d9dc54d2.jpg', '2023-03-27 10:13:22', '2023-03-27 10:43:57'),
(2, 'Haritha', 'Software Developer', 'http://127.0.0.1:8000/storage/directors/6427df55cdbd1.webp', '2023-04-01 04:37:57', '2023-04-01 04:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `discard_reports`
--

CREATE TABLE `discard_reports` (
  `id` int(10) NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jamia_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_dt` date NOT NULL,
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) DEFAULT NULL,
  `send_dt` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discard_reports`
--

INSERT INTO `discard_reports` (`id`, `item_name`, `customer_contact`, `jamia_name`, `customer_note`, `item_photo`, `report_dt`, `admin_note`, `status`, `created_by`, `send_dt`, `created_at`, `updated_at`) VALUES
(1, 'itenbb', '56666', 'gcffxfx', 'gcgf', 'http://127.0.0.1:8000/storage/DiscardReport/64352fd1c8f60.jpeg', '2023-04-03', 'cancelled', 'RECEIVED', 3, '2023-04-11', '2023-04-03 15:24:20', '2023-04-11 07:00:49'),
(2, 'vcdvfb', 'fdbfnf', 'ngdndgn', 'gngngngngngn', '', '2023-04-11', NULL, 'RECEIVED', NULL, NULL, '2023-04-11 06:51:54', '2023-04-11 06:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `family_card_data`
--

CREATE TABLE `family_card_data` (
  `id` int(11) NOT NULL,
  `CARD_NO` varchar(50) DEFAULT NULL,
  `FCH_SHR_NAME` varchar(250) DEFAULT NULL,
  `SHR_NO` varchar(50) DEFAULT NULL,
  `CIVIL_ID` varchar(50) DEFAULT NULL,
  `CODE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `family_card_data`
--

INSERT INTO `family_card_data` (`id`, `CARD_NO`, `FCH_SHR_NAME`, `SHR_NO`, `CIVIL_ID`, `CODE`) VALUES
(2993, '1', 'عيسى مزيد مكنى المطيرى', '1', '244062800143', '4900101100011'),
(2994, '2', 'محمد خالد عايض راشد', '2', '277081500462', '4900103100026'),
(2995, '3', 'بدر مفرح جاعد المطيرى', '4', '270092100753', '4900105100031'),
(2996, '4', 'عبد الهادى على عبد الهادى العجمى', '5', '253051502559', '4900107100046'),
(2997, '5', 'ناصر عيد مرزوق الوعلان', '6', '271041900587', '4900109100051'),
(2998, '6', 'جاسر فريح زايد المطيرى', '7', '234062100236', '4900111100063'),
(2999, '7', 'ناصر خلف ناصر المطيرات', '9', '1', '4900113100078'),
(3000, '8', 'سالم بكر جايز الديحانى', '10', '239102500465', '4900115100083'),
(3001, '9', 'عايد فهد عايد المطيرى', '11', '270062800767', '4900117100098'),
(3002, '10', 'مهنا مسفر شريفه الحيانى', '13', '242050900105', '4900119100102'),
(3003, '11', 'سالم مشعل مزيد المطيرى', '15', '281052200788', '4900121100114');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(10) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `date`, `status`, `created_at`, `updated_at`) VALUES
(4, 'sdd', '2023-03-29', 'Active', '2023-03-29 16:00:27', '2023-03-29 16:00:27'),
(8, 'sdsd', '2023-03-29', 'Active', '2023-03-29 16:03:42', '2023-03-29 16:03:42'),
(9, 'sdsd', '2023-03-29', 'Active', '2023-03-29 16:05:36', '2023-04-01 09:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_photos`
--

CREATE TABLE `gallery_photos` (
  `id` int(10) NOT NULL,
  `galleries_id` int(191) NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_photos`
--

INSERT INTO `gallery_photos` (`id`, `galleries_id`, `photo`, `created_at`, `updated_at`) VALUES
(1, 9, 'http://127.0.0.1:8000/storage/Gallery/64248c0054434.jpg', '2023-03-29 16:05:36', '2023-03-29 16:05:36'),
(2, 9, 'http://127.0.0.1:8000/storage/Gallery/64248c0055507.jpg', '2023-03-29 16:05:36', '2023-03-29 16:05:36'),
(3, 4, 'http://127.0.0.1:8000/storage/Gallery/643d566603645.jpg', '2023-04-17 11:23:34', '2023-04-17 11:23:34'),
(4, 4, 'http://127.0.0.1:8000/storage/Gallery/643d566604539.jpg', '2023-04-17 11:23:34', '2023-04-17 11:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `id` int(10) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_07_12_102746_create_categories_table', 1),
(6, '2022_07_12_102823_create_brands_table', 1),
(7, '2022_07_12_102856_create_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news_details`
--

CREATE TABLE `news_details` (
  `id` int(10) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_details`
--

INSERT INTO `news_details` (`id`, `title`, `description`, `photo`, `date`, `created_at`, `updated_at`) VALUES
(1, 'sdsdd', '<p>sdsfsf</p>', 'http://127.0.0.1:8000/storage/news/6421b5b5b4fc2.webp', '2023-03-27', '2023-03-27 12:26:45', '2023-03-27 12:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_dt` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(10) NOT NULL,
  `topic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_dt` date DEFAULT NULL,
  `to_dt` date DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `topic`, `location`, `details`, `from_dt`, `to_dt`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Offer1', 'zcsc', 'scscc', '2023-03-27', '2023-03-31', 'http://127.0.0.1:8000/storage/offers/6421d91608adc.webp', '2023-03-27 14:57:42', '2023-03-27 15:11:29');

-- --------------------------------------------------------

--
-- Table structure for table `offer_categories`
--

CREATE TABLE `offer_categories` (
  `id` int(10) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offer_categories`
--

INSERT INTO `offer_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'offer', '2023-03-28 16:32:48', '2023-03-28 16:32:48'),
(3, 'offer12', '2023-04-01 10:59:29', '2023-04-01 10:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'Directors'),
(2, 'Customer Users'),
(3, 'Role'),
(4, 'News Details'),
(5, 'Offers and Festivals'),
(6, 'Branch Category'),
(7, 'Branch'),
(8, 'Discard Report'),
(9, 'Offer Catergory'),
(10, 'Coupon Offer'),
(11, 'Complaints'),
(12, 'Gallery'),
(13, 'Social Medias'),
(14, 'Employee'),
(15, 'Notification'),
(16, 'Slide Shows'),
(17, 'Informations');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(4, 'Admin', '2023-03-14 09:32:29', '2023-03-14 09:32:29'),
(6, 'Employee', '2023-04-01 10:54:16', '2023-04-01 10:54:16');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(10) NOT NULL,
  `roles_id` int(100) NOT NULL,
  `permissions_id` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `roles_id`, `permissions_id`, `created_at`, `updated_at`) VALUES
(21, 6, 4, '2023-04-01 10:54:16', '2023-04-01 10:54:16'),
(49, 6, 8, NULL, NULL),
(50, 4, 1, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(51, 4, 2, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(52, 4, 3, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(53, 4, 4, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(54, 4, 5, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(55, 4, 6, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(56, 4, 7, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(57, 4, 8, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(58, 4, 9, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(59, 4, 10, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(60, 4, 11, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(61, 4, 12, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(62, 4, 13, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(63, 4, 14, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(64, 4, 15, '2023-04-15 07:51:19', '2023-04-15 07:51:19'),
(65, 4, 16, '2023-04-15 07:51:19', '2023-04-15 07:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `slideshows`
--

CREATE TABLE `slideshows` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_dt` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slideshows`
--

INSERT INTO `slideshows` (`id`, `name`, `image`, `created_dt`, `created_at`, `updated_at`) VALUES
(1, NULL, 'http://127.0.0.1:8000/storage/Slideshow/6439b54eec996.jpg', '2023-04-14', '2023-04-14 17:19:26', '2023-04-14 17:19:26'),
(3, 'dsdsdsd', 'http://127.0.0.1:8000/storage/Slideshow/6439b786e6dff.jpg', '2023-04-15', '2023-04-14 17:28:54', '2023-04-14 17:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `socialmedia`
--

CREATE TABLE `socialmedia` (
  `id` int(10) NOT NULL,
  `instagram` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `socialmedia`
--

INSERT INTO `socialmedia` (`id`, `instagram`, `twitter`, `facebook`, `linkedin`, `created_at`, `updated_at`) VALUES
(1, 'www@', 'sff', 'gagg', 'ihihh', '2023-04-01 11:07:14', '2023-04-01 11:07:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Haritha', 'h@gmail.com', '67661149', 4, '$2y$10$dOmTcfig28UckKjaIlU1eeHBAtbMoyyGBA7J/raphkxhvpE5NpdTa', NULL, '2022-08-04 13:29:47', '2023-04-14 20:05:22'),
(2, 'Al Nasar', 'sales@alnasr.com', '123456', 4, '$2y$10$w.47cLDg8.sNmA6zi7uUB.F3VNmii5aOdHwQZp0wivWN9krgqC/5y', NULL, '2022-08-04 13:32:59', '2022-08-04 13:32:59'),
(3, 'haritha', 'ha@gmail.com', '456789', 6, '$2y$10$EAejyYmJzcpKdSNmpZWuyOS.rnpqkC39NV9IRfcdGk39S8WQ/BzWy', NULL, '2023-03-13 16:21:11', '2023-04-10 05:46:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_categories`
--
ALTER TABLE `branch_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_offers`
--
ALTER TABLE `coupon_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_users`
--
ALTER TABLE `coupon_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discard_reports`
--
ALTER TABLE `discard_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_card_data`
--
ALTER TABLE `family_card_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_photos`
--
ALTER TABLE `gallery_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_details`
--
ALTER TABLE `news_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_categories`
--
ALTER TABLE `offer_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slideshows`
--
ALTER TABLE `slideshows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socialmedia`
--
ALTER TABLE `socialmedia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branch_categories`
--
ALTER TABLE `branch_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_offers`
--
ALTER TABLE `coupon_offers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_users`
--
ALTER TABLE `coupon_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discard_reports`
--
ALTER TABLE `discard_reports`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `family_card_data`
--
ALTER TABLE `family_card_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3004;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gallery_photos`
--
ALTER TABLE `gallery_photos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news_details`
--
ALTER TABLE `news_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `offer_categories`
--
ALTER TABLE `offer_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `slideshows`
--
ALTER TABLE `slideshows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `socialmedia`
--
ALTER TABLE `socialmedia`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
