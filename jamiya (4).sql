-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2023 at 05:59 PM
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

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `branch_categories_id`, `address`, `phone`, `hours`, `picture`, `location`, `created_at`, `updated_at`) VALUES
(1, 'vvs', 1, 'asas', 'ww', '12', '', 'https://stackoverflow.com/questions/5335528/how-to-rename-a-table-in-sql-server', '2023-03-31 18:04:02', '2023-04-09 16:00:09');

--
-- Dumping data for table `branch_categories`
--

INSERT INTO `branch_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Branch10', '2023-03-27 16:10:05', '2023-03-28 08:29:02'),
(2, 'Branch2', '2023-04-01 10:56:34', '2023-04-01 10:56:34');

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `name`, `number`, `email`, `reason`, `notes`, `admin_note`, `created_at`, `updated_at`) VALUES
(1, 'Customer1', '7766554433', 'h@gmail.com', 'UNDERPROCESS', 'I hhf', 'adnnsdbs bbs b', '2023-04-01 11:01:40', '2023-04-14 18:10:36');

--
-- Dumping data for table `coupon_offers`
--

INSERT INTO `coupon_offers` (`id`, `offer_name`, `offer_categories_id`, `picture`, `description`, `from_dt`, `to_dt`, `contact_no`, `created_at`, `updated_at`) VALUES
(1, 'bbb b', 2, '', 'bbb', '2023-03-29', '2023-03-29', '123456', '2023-03-29 11:34:15', '2023-03-29 11:36:26');

--
-- Dumping data for table `coupon_users`
--

INSERT INTO `coupon_users` (`id`, `username`, `email`, `phone`, `shareholder_no`, `civil_id`, `password`, `action`, `generate_reports`, `created_at`, `updated_at`) VALUES
(1, 'sdsdd', 'scc', '32434', '343434', '344', '$2y$10$RLbNcheTkLPsGNnf0DOdtuqAB4qUPq3gIBeqJtz.XfzIPiKPg0CfO', 'Block', 'Y', '2023-04-08 11:30:22', '2023-04-08 11:36:56');

--
-- Dumping data for table `customer_profit`
--

INSERT INTO `customer_profit` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'asdddsdsdd', '2023-04-23 12:11:30', '2023-04-23 12:14:59');

--
-- Dumping data for table `directors`
--

INSERT INTO `directors` (`id`, `name`, `position`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Sachin', 'Admin', 'http://127.0.0.1:8000/storage/directors/64219d9dc54d2.jpg', '2023-03-27 10:13:22', '2023-03-27 10:43:57'),
(2, 'Haritha', 'Software Developer', 'http://127.0.0.1:8000/storage/directors/6427df55cdbd1.webp', '2023-04-01 04:37:57', '2023-04-01 04:37:57');

--
-- Dumping data for table `discard_reports`
--

INSERT INTO `discard_reports` (`id`, `item_name`, `customer_contact`, `jamia_name`, `customer_note`, `item_photo`, `report_dt`, `admin_note`, `status`, `created_by`, `send_dt`, `created_at`, `updated_at`) VALUES
(1, 'itenbb', '56666', 'gcffxfx', 'gcgf', 'http://127.0.0.1:8000/storage/DiscardReport/64352fd1c8f60.jpeg', '2023-04-03', 'cancelled', 'RECEIVED', 3, '2023-04-11', '2023-04-03 15:24:20', '2023-04-11 07:00:49'),
(2, 'vcdvfb', 'fdbfnf', 'ngdndgn', 'gngngngngngn', '', '2023-04-11', 'sdsfsff', 'DONE', NULL, NULL, '2023-04-11 06:51:54', '2023-04-22 09:17:45');

--
-- Dumping data for table `family_card_data`
--

INSERT INTO `family_card_data` (`id`, `FCH_SHR_NAME`, `SHR_NO`, `CIVIL_ID`, `CODE`, `barcode`, `status`) VALUES
(2993, 'عيسى مزيد مكنى المطيرى', '1', '244062800143', '4900101100011', NULL, NULL),
(2994, 'محمد خالد عايض راشد', '2', '277081500462', '4900103100026', NULL, NULL),
(2995, 'بدر مفرح جاعد المطيرى', '4', '270092100753', '4900105100031', NULL, NULL),
(2996, 'عبد الهادى على عبد الهادى العجمى', '5', '253051502559', '4900107100046', NULL, NULL),
(2997, 'ناصر عيد مرزوق الوعلان', '6', '271041900587', '4900109100051', NULL, NULL),
(2998, 'جاسر فريح زايد المطيرى', '7', '234062100236', '4900111100063', NULL, NULL),
(2999, 'ناصر خلف ناصر المطيرات', '9', '1', '4900113100078', NULL, NULL),
(3000, 'سالم بكر جايز الديحانى', '10', '239102500465', '4900115100083', NULL, NULL),
(3001, 'عايد فهد عايد المطيرى', '11', '270062800767', '4900117100098', NULL, NULL),
(3002, 'مهنا مسفر شريفه الحيانى', '13', '242050900105', '4900119100102', NULL, NULL),
(3003, 'سالم مشعل مزيد المطيرى', '15', '281052200788', '4900121100114', NULL, NULL);

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `date`, `status`, `created_at`, `updated_at`) VALUES
(8, 'sdsd', '2023-03-29', 'Active', '2023-03-29 16:03:42', '2023-03-29 16:03:42'),
(9, 'sdsd', '2023-03-29', 'Active', '2023-03-29 16:05:36', '2023-04-01 09:01:13'),
(10, 'images1', '2023-04-22', 'Active', '2023-04-22 15:28:40', '2023-04-22 15:28:40');

--
-- Dumping data for table `gallery_photos`
--

INSERT INTO `gallery_photos` (`id`, `galleries_id`, `photo`, `created_at`, `updated_at`) VALUES
(1, 9, 'http://127.0.0.1:8000/storage/Gallery/64248c0054434.jpg', '2023-03-29 16:05:36', '2023-03-29 16:05:36'),
(2, 9, 'http://127.0.0.1:8000/storage/Gallery/64248c0055507.jpg', '2023-03-29 16:05:36', '2023-03-29 16:05:36');

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'info', '2023-04-22 09:21:49', '2023-04-22 09:21:49');

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

--
-- Dumping data for table `news_details`
--

INSERT INTO `news_details` (`id`, `title`, `description`, `photo`, `date`, `created_at`, `updated_at`) VALUES
(1, 'sdsdd', '<p>sdsfsf</p>', 'http://127.0.0.1:8000/storage/news/6421b5b5b4fc2.webp', '2023-03-27', '2023-03-27 12:26:45', '2023-03-27 12:31:47');

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notes`, `created_dt`, `created_at`, `updated_at`) VALUES
(1, 'Eid', '2023-04-23', '2023-04-23 11:11:38', '2023-04-23 11:11:38');

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `topic`, `location`, `details`, `from_dt`, `to_dt`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Offer1', 'zcsc', 'scscc', '2023-03-27', '2023-03-31', 'http://127.0.0.1:8000/storage/offers/6421d91608adc.webp', '2023-03-27 14:57:42', '2023-03-27 15:11:29');

--
-- Dumping data for table `offer_categories`
--

INSERT INTO `offer_categories` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(2, 'offer', NULL, '2023-03-28 16:32:48', '2023-03-28 16:32:48'),
(3, 'offer12', NULL, '2023-04-01 10:59:29', '2023-04-01 10:59:29'),
(4, 'Offer123', 'http://127.0.0.1:8000/storage/offerCat/6443cc7df34ec.jpg', '2023-04-22 09:01:01', '2023-04-22 09:01:01');

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
(17, 'Informations'),
(18, 'Customer Profit Title');

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(4, 'Admin', '2023-03-14 09:32:29', '2023-03-14 09:32:29'),
(6, 'Employee', '2023-04-01 10:54:16', '2023-04-01 10:54:16');

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `roles_id`, `permissions_id`, `created_at`, `updated_at`) VALUES
(21, 6, 4, '2023-04-01 10:54:16', '2023-04-01 10:54:16'),
(49, 6, 8, NULL, NULL),
(66, 4, 1, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(67, 4, 2, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(68, 4, 3, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(69, 4, 4, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(70, 4, 5, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(71, 4, 6, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(72, 4, 7, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(73, 4, 8, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(74, 4, 9, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(75, 4, 10, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(76, 4, 11, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(77, 4, 12, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(78, 4, 13, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(79, 4, 14, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(80, 4, 15, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(81, 4, 16, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(82, 4, 17, '2023-04-23 12:17:26', '2023-04-23 12:17:26'),
(83, 4, 18, '2023-04-23 12:17:26', '2023-04-23 12:17:26');

--
-- Dumping data for table `slideshows`
--

INSERT INTO `slideshows` (`id`, `name`, `image`, `created_dt`, `created_at`, `updated_at`) VALUES
(4, 'Slide12', 'http://127.0.0.1:8000/storage/Slideshow/6443d0dd5e81e.jpg', '2023-04-22', '2023-04-22 09:19:41', '2023-04-22 09:19:41');

--
-- Dumping data for table `socialmedia`
--

INSERT INTO `socialmedia` (`id`, `instagram`, `twitter`, `facebook`, `linkedin`, `created_at`, `updated_at`) VALUES
(1, 'www@', 'sff', 'gagg', 'ihihh', '2023-04-01 11:07:14', '2023-04-01 11:07:14');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Haritha', 'h@gmail.com', '67661149', 4, '$2y$10$dOmTcfig28UckKjaIlU1eeHBAtbMoyyGBA7J/raphkxhvpE5NpdTa', NULL, '2022-08-04 13:29:47', '2023-04-14 20:05:22'),
(2, 'Al Nasar', 'sales@alnasr.com', '123456', 4, '$2y$10$w.47cLDg8.sNmA6zi7uUB.F3VNmii5aOdHwQZp0wivWN9krgqC/5y', NULL, '2022-08-04 13:32:59', '2022-08-04 13:32:59'),
(3, 'haritha', 'ha@gmail.com', '456789', 6, '$2y$10$EAejyYmJzcpKdSNmpZWuyOS.rnpqkC39NV9IRfcdGk39S8WQ/BzWy', NULL, '2023-03-13 16:21:11', '2023-04-10 05:46:45');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
