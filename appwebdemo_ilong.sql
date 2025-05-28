-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2025 at 11:01 PM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appwebdemo_ilong`
--

-- --------------------------------------------------------

--
-- Table structure for table `availabilities`
--

CREATE TABLE `availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `time_slot` varchar(255) NOT NULL,
  `status` enum('available','booked') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `availabilities`
--

INSERT INTO `availabilities` (`id`, `user_id`, `date`, `time_slot`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, '2025-05-01 00:30:00.000000', 'booked', '2025-04-30 00:30:19', '2025-04-30 00:31:05'),
(2, 2, NULL, '2025-05-02 00:30:00.000000', 'booked', '2025-04-30 00:30:26', '2025-04-30 00:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `professional_id` bigint(20) UNSIGNED NOT NULL,
  `availability_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `time_slot` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'scheduled',
  `cancel_reason` varchar(1000) DEFAULT NULL,
  `cancel_details` varchar(1000) DEFAULT NULL,
  `cancel_by` varchar(1000) DEFAULT NULL,
  `reason_dispute` varchar(1000) DEFAULT NULL,
  `dispute_detail` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `professional_id`, `availability_id`, `date`, `time_slot`, `note`, `status`, `cancel_reason`, `cancel_details`, `cancel_by`, `reason_dispute`, `dispute_detail`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, NULL, '2025-05-01 00:30:00.000000', 'Therapist', 'dispute', NULL, NULL, NULL, 'Professional Misbehave', 'cheater', '2025-04-30 00:31:05', '2025-04-30 00:32:59'),
(2, 1, 2, 2, NULL, '2025-05-02 00:30:00.000000', 'lorem ipsum', 'completed', NULL, NULL, NULL, NULL, NULL, '2025-04-30 00:32:13', '2025-04-30 00:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `childrens`
--

CREATE TABLE `childrens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('male','female','other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `concern` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interests` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caregiver_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 5, 10, 'new testing', '2025-05-13 16:33:16', '2025-05-13 16:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'NJMF', 'We respect your privacy. All data shared on our platform is securely stored and never sold or shared with third parties without your consent. Your personal information is only used to provide and improve our services. By using this platform, you agree to our data practices as outlined here.', '2025-05-01 03:29:26', '2025-04-30 22:29:42'),
(2, 'ASaS', 'We respect your privacy. All data shared on our platform is securely stored and never sold or shared with third parties without your consent. Your personal information is only used to provide and improve our services. By using this platform, you agree to our data practices as outlined here.', NULL, '2025-04-30 22:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `content_post_comments`
--

CREATE TABLE `content_post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_post_comments`
--

INSERT INTO `content_post_comments` (`id`, `user_id`, `post_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'ok', '2025-04-30 17:52:15', '2025-04-30 17:52:15'),
(2, 6, 4, 'new tester', '2025-04-30 20:09:25', '2025-04-30 20:09:25'),
(3, 7, 9, 'testing this crap', '2025-05-01 00:00:18', '2025-05-01 00:00:18'),
(4, 1, 8, 'ok', '2025-05-05 03:25:43', '2025-05-05 03:25:43'),
(5, 1, 8, 'oo', '2025-05-05 03:25:52', '2025-05-05 03:25:52'),
(6, 1, 8, 'ok', '2025-05-05 03:25:54', '2025-05-05 03:25:54'),
(7, 1, 9, 'yes', '2025-05-05 03:26:12', '2025-05-05 03:26:12'),
(8, 10, 19, 'Nice shoe', '2025-05-14 00:35:55', '2025-05-14 00:35:55'),
(9, 7, 25, 'this app is cool man don\'t worry', '2025-05-14 23:36:49', '2025-05-14 23:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `content_post_likes`
--

CREATE TABLE `content_post_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_post_likes`
--

INSERT INTO `content_post_likes` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-04-30 16:25:49', '2025-04-30 16:25:49'),
(2, 6, 6, '2025-04-30 20:10:33', '2025-04-30 20:10:33'),
(4, 1, 8, '2025-05-05 03:25:49', '2025-05-05 03:25:49'),
(5, 10, 11, '2025-05-13 16:33:38', '2025-05-13 16:33:38'),
(6, 10, 14, '2025-05-13 16:33:41', '2025-05-13 16:33:41'),
(7, 11, 12, '2025-05-13 18:50:00', '2025-05-13 18:50:00'),
(9, 10, 16, '2025-05-13 19:07:35', '2025-05-13 19:07:35'),
(10, 10, 15, '2025-05-13 19:07:42', '2025-05-13 19:07:42'),
(11, 5, 16, '2025-05-13 19:21:31', '2025-05-13 19:21:31'),
(12, 5, 17, '2025-05-13 21:36:09', '2025-05-13 21:36:09'),
(13, 10, 19, '2025-05-14 00:34:25', '2025-05-14 00:34:25'),
(14, 10, 17, '2025-05-14 00:34:27', '2025-05-14 00:34:27'),
(16, 7, 25, '2025-05-14 23:37:01', '2025-05-14 23:37:01'),
(17, 5, 11, '2025-05-15 00:32:46', '2025-05-15 00:32:46'),
(18, 5, 11, '2025-05-15 00:32:46', '2025-05-15 00:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `job_title`, `company_name`, `from`, `to`, `created_at`, `updated_at`) VALUES
(1, 2, 'senior therapist', 'abc company', '2025-04-30', '2025-04-30', '2025-04-30 00:26:27', '2025-04-30 00:26:27'),
(2, 5, 'user', 'yser', '2025-05-24', '2025-05-23', '2025-04-30 20:40:34', '2025-04-30 20:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'How can I reset my password if I forget it?', 'Simply click on the “Forgot Password” link on the login page, enter your registered email, and follow the instructions in the email to reset your password.', 1, '2025-04-30 22:23:19', '2025-04-30 22:23:19'),
(2, 'How can I reset my password if I forget it?', 'Simply click on the “Forgot Password” link on the login page, enter your registered email, and follow the instructions in the email to reset your password.', 1, '2025-04-30 22:23:28', '2025-04-30 22:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `following_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `follower_id`, `following_id`, `created_at`, `updated_at`) VALUES
(2, 1, 1, NULL, NULL),
(3, 6, 1, NULL, NULL),
(4, 1, 6, NULL, NULL),
(5, 5, 6, NULL, NULL),
(7, 5, 7, NULL, NULL),
(8, 1, 5, NULL, NULL),
(9, 5, 10, NULL, NULL),
(10, 7, 11, NULL, NULL),
(11, 10, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `creator_id`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Pyrobytes', 'Lorem Ipsum', 1, '1745972529_1000021775.jpg', '2025-04-30 00:22:09', '2025-04-30 00:22:09'),
(3, 'Validation Group', 'snjshdhdhshshshqjwhehhd', 10, '1747248320_1000000022.jpg', '2025-05-14 18:45:20', '2025-05-14 18:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `group_posts`
--

CREATE TABLE `group_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hide` tinyint(1) DEFAULT 1,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `share` tinyint(4) DEFAULT 0,
  `share_count` tinyint(111) DEFAULT 0,
  `share_person` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `group_posts`
--

INSERT INTO `group_posts` (`id`, `hide`, `description`, `group_id`, `user_id`, `image`, `share`, `share_count`, `share_person`, `created_at`, `updated_at`) VALUES
(5, 1, 'Lorem Ipsum', 2, 1, '[\"68116d3ec4801_1000021772.jpg\"]', 0, 0, NULL, '2025-04-30 00:22:22', '2025-04-30 00:22:22'),
(6, 1, 'I been feeling terrible lately about my mental health', 2, 1, '[\"1746122595_6813b76332634.jpg\"]', 1, 0, 'john smith', '2025-05-05 03:27:06', '2025-05-05 03:27:06'),
(7, 1, 'posting a blog without testing', 2, 5, '[]', 0, 0, NULL, '2025-05-13 21:46:12', '2025-05-13 21:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `group_user`
--

CREATE TABLE `group_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_user`
--

INSERT INTO `group_user` (`id`, `group_id`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 2, 6, NULL, NULL),
(3, 2, 5, NULL, NULL),
(4, 2, 7, NULL, NULL),
(5, 2, 10, NULL, NULL),
(6, 2, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `post_id`, `image_path`, `created_at`, `updated_at`) VALUES
(5, 4, '1745972606_68116d7eeaf94.jpg', '2025-04-30 00:23:26', '2025-04-30 00:23:26'),
(6, 5, '1745975769_681179d97b1f5.jpg', '2025-04-30 01:16:09', '2025-04-30 01:16:09'),
(7, 6, '1746030379_68124f2bcdf19.jpg', '2025-04-30 16:26:19', '2025-04-30 16:26:19'),
(8, 7, '1745972606_68116d7eeaf94.jpg', '2025-04-30 20:10:41', '2025-04-30 20:10:41'),
(9, 8, '1746045387_681289cb2d8cc.jpg', '2025-04-30 20:36:27', '2025-04-30 20:36:27'),
(10, 9, '1746045768_68128b48973b3.jpg', '2025-04-30 20:42:48', '2025-04-30 20:42:48'),
(11, 10, '1746055576_6812b1980eeba.jpg', '2025-04-30 23:26:16', '2025-04-30 23:26:16'),
(12, 11, '1746122595_6813b76332634.jpg', '2025-05-01 18:03:15', '2025-05-01 18:03:15'),
(13, 12, '1746122595_6813b76332634.jpg', '2025-05-05 03:26:27', '2025-05-05 03:26:27'),
(14, 13, '1746423019_68184cebdd2c3.jpg', '2025-05-05 05:30:19', '2025-05-05 05:30:19'),
(15, 14, '1747092429_682283cd5f2dd.jpg', '2025-05-12 23:27:09', '2025-05-12 23:27:09'),
(16, 15, '1747162501_6823958571bf6.jpg', '2025-05-13 18:55:01', '2025-05-13 18:55:01'),
(17, 19, '1747181882_6823e13a96035.jpg', '2025-05-14 00:18:02', '2025-05-14 00:18:02'),
(18, 21, '1747184774_6823ec8661321.jpg', '2025-05-14 01:06:14', '2025-05-14 01:06:14'),
(19, 25, '1747265782_682528f66e663.jpg', '2025-05-14 23:36:22', '2025-05-14 23:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `seen` tinyint(4) DEFAULT 0,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `license_name` varchar(255) DEFAULT NULL,
  `license_id` varchar(255) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `license_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`id`, `user_id`, `license_name`, `license_id`, `from`, `to`, `license_image`, `created_at`, `updated_at`) VALUES
(1, 2, '1234', 'ebaggg', '2025-04-30', '2025-04-30', NULL, '2025-04-30 00:26:27', '2025-04-30 00:26:27'),
(2, 5, 'Therapist', 'user', '2025-05-16', '2025-05-08', NULL, '2025-04-30 20:40:34', '2025-04-30 20:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2025-04-30 00:22:31', '2025-04-30 00:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `last_message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_28_051629_create_profiles_table', 2),
(6, '2024_11_29_022437_create_posts_table', 3),
(7, '2024_11_29_022440_create_posts_table', 4),
(8, '2024_12_01_003824_create_roles_table', 5),
(9, '2024_12_01_003912_create_permissions_table', 6),
(10, '2024_12_01_003945_create_role_permissions_table', 7),
(11, '2024_12_01_004012_create_user_roles_table', 8),
(12, '2024_12_05_033951_alter_user_table', 9),
(13, '2024_12_05_234658_create_jobs_table', 10),
(14, '2024_12_11_163333_create_childrens_table', 11),
(15, '2024_12_11_173731_create_childrens_table', 12),
(16, '2024_12_12_030759_create_posts_table', 13),
(17, '2024_12_12_031135_create_images_table', 14),
(18, '2024_12_16_091456_create_groups_table', 15),
(19, '2024_12_16_091624_create_group_user_table', 16),
(20, '2024_12_18_170228_add_description_to_groups_table', 17),
(21, '2024_12_18_182210_create_group_posts_table', 18),
(22, '2024_12_18_200633_create_likes_table', 19),
(23, '2024_12_18_202730_create_comments_table', 20),
(24, '2024_12_19_153319_create_faqs_table', 21),
(25, '2024_12_19_160914_create_contents_table', 22),
(26, '2024_12_19_163322_create_inquiries_table', 23),
(27, '2024_12_19_190113_create_professional_profiles_table', 24),
(28, '2024_12_19_222005_create_availabilities_table', 25),
(29, '2024_12_20_175247_create_experiences_table', 26),
(30, '2024_12_20_175347_create_licenses_table', 26),
(31, '2024_12_23_101430_create_bookings_table', 27),
(32, '2024_12_31_124734_create_professional_earnings_table', 28),
(33, '2024_12_31_130106_create_user_videos_table', 29),
(34, '2024_12_31_162244_create_video_likes_table', 30),
(35, '2024_12_31_162517_create_video_comments_table', 31),
(36, '2025_01_01_171615_create_content_post_likes_table', 32),
(37, '2025_01_01_174355_create_content_post_comments_table', 32),
(38, '2025_01_02_231247_create_follows_table', 33),
(39, '2025_01_06_222052_create_zoom_meetings_table', 34),
(40, '2025_01_06_225001_create_zoom_meetings_table', 35),
(41, '2025_01_06_225418_alter_start_url_column_in_zoom_meetings_table', 36),
(42, '2025_01_07_202920_create_payments_table', 37),
(43, '2025_01_09_174449_create_messages_table', 38),
(44, '2025_01_09_174951_create_messages_table', 39),
(45, '2025_01_16_164826_create_notifications_table', 40),
(46, '2025_01_17_153748_add_user_id_to_inquiries_table', 41);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `notifyBy` varchar(255) NOT NULL,
  `seen` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `notifyBy`, `seen`, `created_at`, `updated_at`) VALUES
(1, 1, 'user has Like your Group Post.', 'Like Group Post', 1, '2025-04-30 00:22:31', '2025-04-30 00:34:18'),
(2, 1, 'User has liked your Video.', 'Like Video', 1, '2025-04-30 00:24:41', '2025-04-30 00:34:18'),
(3, 1, 'User has Commented your Video.', 'Commented Video', 1, '2025-04-30 00:24:46', '2025-04-30 00:34:18'),
(4, 2, 'Userhas Book your Slot ', 'Book Slot Added', 1, '2025-04-30 00:31:06', '2025-04-30 00:33:07'),
(5, 1, 'developer has Accept your Appoinment ', 'Appoinment Accepted', 1, '2025-04-30 00:31:24', '2025-04-30 00:34:18'),
(6, 2, 'Userhas Book your Slot ', 'Book Slot Added', 1, '2025-04-30 00:32:13', '2025-04-30 00:33:07'),
(7, 1, 'developer has Accept your Appoinment ', 'Appoinment Accepted', 1, '2025-04-30 00:32:24', '2025-04-30 00:34:18'),
(8, 2, 'Userhas Dispute Appointment ', 'Appointment Dispute', 1, '2025-04-30 00:32:59', '2025-04-30 00:33:07'),
(9, 2, 'Userhas Completed Appointment ', 'Appointment Completed', 0, '2025-04-30 00:33:22', '2025-04-30 00:33:22'),
(10, 1, 'User has liked your post.', 'Post Like', 1, '2025-04-30 16:25:49', '2025-04-30 17:52:30'),
(11, 1, 'Userhas Comment your post ok', 'Post Comment', 1, '2025-04-30 17:52:15', '2025-04-30 17:52:30'),
(12, 1, 'Websitehas Comment your post new tester', 'Post Comment', 1, '2025-04-30 20:09:25', '2025-05-02 21:01:47'),
(13, 1, 'Website has liked your post.', 'Post Like', 1, '2025-04-30 20:10:33', '2025-05-02 21:01:47'),
(14, 1, 'Website has Share your post ', 'Post Share To Profile', 1, '2025-04-30 20:10:41', '2025-05-02 21:01:47'),
(15, 1, 'Website has Joined your Group.', 'Group Joined', 1, '2025-04-30 20:10:52', '2025-05-02 21:01:47'),
(16, 1, 'Professional Therapist has Joined your Group.', 'Group Joined', 1, '2025-04-30 22:18:33', '2025-05-02 21:01:47'),
(17, 1, 'deez has Joined your Group.', 'Group Joined', 1, '2025-04-30 23:59:49', '2025-05-02 21:01:47'),
(18, 5, 'deezhas Comment your post testing this crap', 'Post Comment', 1, '2025-05-01 00:00:18', '2025-05-01 01:04:04'),
(19, 1, 'deez has liked your Video.', 'Like Video', 1, '2025-05-01 00:01:55', '2025-05-02 21:01:47'),
(20, 1, 'john has liked your Video.', 'Like Video', 1, '2025-05-01 17:56:07', '2025-05-02 21:01:47'),
(21, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 16:38:27', '2025-05-03 01:26:56'),
(22, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 16:38:27', '2025-05-03 01:26:56'),
(23, 5, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 17:06:15', '2025-05-05 03:28:05'),
(24, 5, 'User has Commented your Video.', 'Commented Video', 1, '2025-05-02 18:21:52', '2025-05-05 03:28:05'),
(25, 7, 'User has liked your Video.', 'Like Video', 1, '2025-05-02 18:34:27', '2025-05-03 01:26:56'),
(26, 7, 'User has liked your Video.', 'Like Video', 1, '2025-05-02 19:45:29', '2025-05-03 01:26:56'),
(27, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:17:22', '2025-05-03 01:26:56'),
(28, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:17:24', '2025-05-03 01:26:56'),
(29, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:17:25', '2025-05-03 01:26:56'),
(30, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:17:26', '2025-05-03 01:26:56'),
(31, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:17:27', '2025-05-03 01:26:56'),
(32, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:17:27', '2025-05-03 01:26:56'),
(33, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:17:31', '2025-05-03 01:26:56'),
(34, 7, 'Professional has Commented your Video.', 'Commented Video', 1, '2025-05-02 20:17:41', '2025-05-03 01:26:56'),
(35, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:17:48', '2025-05-03 01:26:56'),
(36, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:19:10', '2025-05-03 01:26:56'),
(37, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:19:10', '2025-05-03 01:26:56'),
(38, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:19:33', '2025-05-03 01:26:56'),
(39, 1, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:19:45', '2025-05-02 21:01:47'),
(40, 7, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:21:02', '2025-05-03 01:26:56'),
(41, 1, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:21:04', '2025-05-02 21:01:47'),
(42, 5, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-02 20:21:05', '2025-05-05 03:28:05'),
(43, 5, 'User has liked your Video.', 'Like Video', 1, '2025-05-03 03:35:25', '2025-05-05 03:28:05'),
(44, 1, 'User has Commented your Video.', 'Commented Video', 1, '2025-05-03 03:35:48', '2025-05-05 03:27:33'),
(45, 1, 'User has liked your Video.', 'Like Video', 1, '2025-05-03 03:37:20', '2025-05-05 03:27:33'),
(46, 1, 'User has liked your Video.', 'Like Video', 1, '2025-05-03 03:37:22', '2025-05-05 03:27:33'),
(47, 7, 'User has liked your Video.', 'Like Video', 1, '2025-05-05 03:23:20', '2025-05-13 17:07:38'),
(48, 1, 'User has liked your Video.', 'Like Video', 1, '2025-05-05 03:24:35', '2025-05-05 03:27:33'),
(49, 1, 'Userhas Comment your post ok', 'Post Comment', 1, '2025-05-05 03:25:43', '2025-05-05 03:27:33'),
(50, 1, 'User has liked your post.', 'Post Like', 1, '2025-05-05 03:25:48', '2025-05-05 03:27:33'),
(51, 1, 'User has liked your post.', 'Post Like', 1, '2025-05-05 03:25:49', '2025-05-05 03:27:33'),
(52, 1, 'Userhas Comment your post oo', 'Post Comment', 1, '2025-05-05 03:25:52', '2025-05-05 03:27:33'),
(53, 1, 'Userhas Comment your post ok', 'Post Comment', 1, '2025-05-05 03:25:54', '2025-05-05 03:27:33'),
(54, 5, 'Userhas Comment your post yes', 'Post Comment', 1, '2025-05-05 03:26:12', '2025-05-05 03:28:05'),
(55, 8, 'User has Share your post ', 'Post Share To Profile', 0, '2025-05-05 03:26:27', '2025-05-05 03:26:27'),
(56, 1, 'Pyro has Joined your Group.', 'Group Joined', 0, '2025-05-13 16:32:47', '2025-05-13 16:32:47'),
(57, 1, 'Pyro has Commented your Group Post.', 'Commented Group Post', 0, '2025-05-13 16:33:16', '2025-05-13 16:33:16'),
(58, 8, 'Pyro has liked your post.', 'Post Like', 0, '2025-05-13 16:33:38', '2025-05-13 16:33:38'),
(59, 7, 'Pyro has liked your post.', 'Post Like', 1, '2025-05-13 16:33:41', '2025-05-13 17:07:38'),
(60, 7, 'Pyro has liked your Video.', 'Like Video', 1, '2025-05-13 17:25:45', '2025-05-14 01:13:47'),
(61, 1, 'Thomas has liked your post.', 'Post Like', 0, '2025-05-13 18:50:00', '2025-05-13 18:50:00'),
(62, 1, 'Thomas has Joined your Group.', 'Group Joined', 0, '2025-05-13 18:52:08', '2025-05-13 18:52:08'),
(63, 10, 'Pyro has liked your post.', 'Post Like', 1, '2025-05-13 19:07:25', '2025-05-14 18:34:29'),
(64, 10, 'Pyro has liked your post.', 'Post Like', 1, '2025-05-13 19:07:35', '2025-05-14 18:34:29'),
(65, 11, 'Pyro has liked your post.', 'Post Like', 0, '2025-05-13 19:07:42', '2025-05-13 19:07:42'),
(66, 10, 'Professional has liked your post.', 'Post Like', 1, '2025-05-13 19:21:31', '2025-05-14 18:34:29'),
(67, 5, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-13 21:01:33', '2025-05-14 03:03:58'),
(68, 5, 'Professional has liked your post.', 'Post Like', 1, '2025-05-13 21:36:09', '2025-05-14 03:03:58'),
(69, 5, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-13 21:42:16', '2025-05-14 03:03:58'),
(70, 5, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-13 21:42:22', '2025-05-14 03:03:58'),
(71, 10, 'Professional has liked your Video.', 'Like Video', 1, '2025-05-13 21:42:24', '2025-05-14 18:34:29'),
(72, 1, 'Pyro has liked your post.', 'Post Like', 0, '2025-05-14 00:34:25', '2025-05-14 00:34:25'),
(73, 5, 'Pyro has liked your post.', 'Post Like', 1, '2025-05-14 00:34:27', '2025-05-14 03:03:58'),
(74, 1, 'Pyrohas Comment your post Nice shoe', 'Post Comment', 0, '2025-05-14 00:35:55', '2025-05-14 00:35:55'),
(75, 10, 'Pyro has liked your Video.', 'Like Video', 1, '2025-05-14 00:54:33', '2025-05-14 18:34:29'),
(76, 10, 'Pyro has liked your Video.', 'Like Video', 1, '2025-05-14 00:55:00', '2025-05-14 18:34:29'),
(77, 7, 'Professional has liked your post.', 'Post Like', 1, '2025-05-14 03:03:35', '2025-05-14 17:13:12'),
(78, 7, 'deezhas Comment your post this app is cool man don\'t worry', 'Post Comment', 0, '2025-05-14 23:36:49', '2025-05-14 23:36:49'),
(79, 7, 'deez has liked your post.', 'Post Like', 0, '2025-05-14 23:37:01', '2025-05-14 23:37:01'),
(80, 8, 'Professional has liked your post.', 'Post Like', 0, '2025-05-15 00:32:46', '2025-05-15 00:32:46'),
(81, 8, 'Professional has liked your post.', 'Post Like', 0, '2025-05-15 00:32:46', '2025-05-15 00:32:46'),
(82, 5, 'Pyro has liked your Video.', 'Like Video', 0, '2025-05-26 18:55:30', '2025-05-26 18:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `professional_id` bigint(20) UNSIGNED NOT NULL,
  `intent_id` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` enum('pending','completed','failed','canceled') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `user_id`, `professional_id`, `intent_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'pi_3RJOXtEVpIhD4Irw0mbJXMoC', 100.00, 'completed', '2025-04-30 00:31:05', '2025-04-30 00:31:05'),
(2, 2, 1, 2, 'pi_3RJOZ3EVpIhD4Irw1eezhiUJ', 100.00, 'completed', '2025-04-30 00:32:13', '2025-04-30 00:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'view_posts', 'abc', '2024-11-30 19:50:02', '2024-11-30 19:50:02'),
(2, 'edit_post', 'abc', '2024-11-30 19:50:02', '2024-11-30 19:50:02'),
(3, 'delete_post', 'abc', '2024-11-30 19:50:02', '2024-11-30 19:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'auth_token', '0c5f28ce500868b140a504bc7a0e00c0c23ba9da3c2c898a7e03f29546179fbe', '[\"*\"]', '2025-01-17 17:26:35', NULL, '2025-01-17 17:25:16', '2025-01-17 17:26:35'),
(2, 'App\\Models\\User', 5, 'auth_token', 'c0af6b79d004fc3c392e5bf19d4600080e3e05e333ba90fb735fa8d9b1fb62cd', '[\"*\"]', '2025-01-17 17:53:15', NULL, '2025-01-17 17:42:35', '2025-01-17 17:53:15'),
(3, 'App\\Models\\User', 5, 'auth_token', '70ef26c3097943ec1c54719538847dac8cecf4b408b2bb141d160f559c9c5924', '[\"*\"]', '2025-01-17 17:54:10', NULL, '2025-01-17 17:53:00', '2025-01-17 17:54:10'),
(4, 'App\\Models\\User', 5, 'auth_token', '4c0513fb1c4b6d4fde66e4cc88a90b34dc8991e962a8e8725b3bf71f7d7fb753', '[\"*\"]', NULL, NULL, '2025-01-17 17:53:31', '2025-01-17 17:53:31'),
(5, 'App\\Models\\User', 2, 'auth_token', 'f96bfa40a78816f97b22037ddeca48797c3bdca7dea6b62e9ce658b9d90b2871', '[\"*\"]', '2025-01-17 18:11:40', NULL, '2025-01-17 17:55:11', '2025-01-17 18:11:40'),
(6, 'App\\Models\\User', 6, 'auth_token', 'e01c7187b8a7e1f8a9f508b17ba092b4fbd39af1a0419fc6218850dd409f0ee3', '[\"*\"]', '2025-01-17 17:58:07', NULL, '2025-01-17 17:56:24', '2025-01-17 17:58:07'),
(7, 'App\\Models\\User', 7, 'auth_token', '3193a6c4caa21710f2953c0cd49822779ef43b060ae3db949aec29ab4b6e0487', '[\"*\"]', '2025-01-17 18:04:32', NULL, '2025-01-17 18:02:40', '2025-01-17 18:04:32'),
(8, 'App\\Models\\User', 7, 'auth_token', 'fd5b074bbc7bdf30275fe31e1fd6432f7fc04078804731e1276060afa4b8601a', '[\"*\"]', '2025-01-17 18:17:44', NULL, '2025-01-17 18:05:16', '2025-01-17 18:17:44'),
(9, 'App\\Models\\User', 6, 'auth_token', '992d901f3e61197ba1714a07cbc598e473adf07cae64361c902d2efbbb00ee70', '[\"*\"]', '2025-01-17 18:59:44', NULL, '2025-01-17 18:06:18', '2025-01-17 18:59:44'),
(10, 'App\\Models\\User', 6, 'auth_token', '0470ecb744ce9559bd2c74608368d6a3fe6c575af0835a3f4e544c8f9583551e', '[\"*\"]', '2025-01-17 20:25:25', NULL, '2025-01-17 18:08:47', '2025-01-17 20:25:25'),
(11, 'App\\Models\\User', 2, 'auth_token', 'd273dbdf3dfad62e39bea208e5cdefa9ca75b14524539cbdad6e51cad913d407', '[\"*\"]', '2025-01-17 18:22:03', NULL, '2025-01-17 18:18:21', '2025-01-17 18:22:03'),
(12, 'App\\Models\\User', 6, 'auth_token', 'e7bdbd5a905a834c51df01b45bd7a1d36e182ab0a560633bce197141629bfe51', '[\"*\"]', '2025-01-17 18:49:19', NULL, '2025-01-17 18:22:21', '2025-01-17 18:49:19'),
(13, 'App\\Models\\User', 2, 'auth_token', '0e5081b4286b90a7b49a9d5502a30e7c09e49719b06fc57a047c0ed2d1d38e8e', '[\"*\"]', '2025-01-17 18:28:41', NULL, '2025-01-17 18:22:37', '2025-01-17 18:28:41'),
(16, 'App\\Models\\User', 6, 'auth_token', 'df52c28bdb41fe9c4a078151e66d2a9d8a13a416a2a4cb217ee28e9321587d57', '[\"*\"]', '2025-01-17 19:47:27', NULL, '2025-01-17 18:50:09', '2025-01-17 19:47:27'),
(17, 'App\\Models\\User', 2, 'auth_token', '30862a4f550a4e5cb6f45a3dc9ee40889d74d26044aa2d96ccaaff64ebfae2fb', '[\"*\"]', '2025-01-17 19:26:51', NULL, '2025-01-17 18:55:50', '2025-01-17 19:26:51'),
(18, 'App\\Models\\User', 6, 'auth_token', '7cb163a8c7e92d023769b160001cf7094f6bdc49fb9788563ba92c65765a692c', '[\"*\"]', NULL, NULL, '2025-01-17 19:00:36', '2025-01-17 19:00:36'),
(19, 'App\\Models\\User', 6, 'auth_token', 'e740def8c263fd9e876e031a680f3ac03cac575ee636bf959771ce3ea3488483', '[\"*\"]', '2025-01-18 00:19:19', NULL, '2025-01-17 19:16:58', '2025-01-18 00:19:19'),
(21, 'App\\Models\\User', 6, 'auth_token', 'b4acd9ae841da2168f4ff04de4e51ba79764f76288b8e326fc7cda376ed7bf8a', '[\"*\"]', '2025-01-17 20:23:23', NULL, '2025-01-17 19:23:58', '2025-01-17 20:23:23'),
(22, 'App\\Models\\User', 6, 'auth_token', '1daffff7c36e02f3ff75920561e3f018e9d8bfeeec1694a532ffd1047b3b368d', '[\"*\"]', '2025-01-20 22:21:11', NULL, '2025-01-17 19:24:48', '2025-01-20 22:21:11'),
(23, 'App\\Models\\User', 6, 'auth_token', '4ac509ab9430b3109a9603a5337d7e37104868713295023bec69280321130bdf', '[\"*\"]', '2025-01-17 19:48:34', NULL, '2025-01-17 19:47:59', '2025-01-17 19:48:34'),
(24, 'App\\Models\\User', 2, 'auth_token', 'b9ca636dc6133c88db910917f8d5751cc5526bd1d59edd3dcfe94cde5f14907a', '[\"*\"]', '2025-01-17 19:51:29', NULL, '2025-01-17 19:48:58', '2025-01-17 19:51:29'),
(25, 'App\\Models\\User', 6, 'auth_token', '34ee412273e1a22fbe6a2cc21b8ac4d94428277b00b96d3e5e156afda4f29f17', '[\"*\"]', '2025-01-17 19:52:22', NULL, '2025-01-17 19:51:55', '2025-01-17 19:52:22'),
(26, 'App\\Models\\User', 2, 'auth_token', 'e79ad86b1f007a22a2853ffac22559909f4f77d98d96e35f7ab14dbd6a078cd8', '[\"*\"]', '2025-01-17 21:44:09', NULL, '2025-01-17 19:53:40', '2025-01-17 21:44:09'),
(28, 'App\\Models\\User', 8, 'auth_token', 'f355484105c39d98e06125f81bc8e6013effeed4b38ab10128b87eb1d9bef93c', '[\"*\"]', '2025-01-17 21:47:16', NULL, '2025-01-17 21:46:01', '2025-01-17 21:47:16'),
(29, 'App\\Models\\User', 8, 'auth_token', 'ead36cd030494748e8b2107921345a2b2cacb21385197b4297608a57c5cccdd4', '[\"*\"]', NULL, NULL, '2025-01-17 21:47:53', '2025-01-17 21:47:53'),
(111, 'App\\Models\\User', 3, 'auth_token', '56861f9076cbfdf348fae184594768a5a6b4d370a1ba490752c9c0133b50c1e3', '[\"*\"]', '2025-02-06 19:08:23', NULL, '2025-02-06 19:08:07', '2025-02-06 19:08:23'),
(112, 'App\\Models\\User', 8, 'auth_token', '27ffe4eb17c45d278ee82f8a66862065f526d3af83613088c309bfe3fc4f2ef1', '[\"*\"]', NULL, NULL, '2025-02-08 00:14:08', '2025-02-08 00:14:08'),
(113, 'App\\Models\\User', 3, 'auth_token', 'b199719975e091ba37a8c4ffcdf8b06f3247e4da1432a636bc00c592f452e497', '[\"*\"]', '2025-02-08 00:36:47', NULL, '2025-02-08 00:35:23', '2025-02-08 00:36:47'),
(114, 'App\\Models\\User', 8, 'auth_token', '6893c89857b0b3b3e16d4de517d091ae02cbf9107017a0f95c5d53e72f04df4e', '[\"*\"]', NULL, NULL, '2025-02-08 00:35:57', '2025-02-08 00:35:57'),
(115, 'App\\Models\\User', 8, 'auth_token', 'c4671955b669b998acfddda1fd15ae060b2171e46d3046404b685017ff1f5de6', '[\"*\"]', NULL, NULL, '2025-02-08 00:36:21', '2025-02-08 00:36:21'),
(116, 'App\\Models\\User', 8, 'auth_token', '22ab7b80ee53adac0145ec1ca009d8a1c513a6b2e58871737251d757a28ec1e2', '[\"*\"]', NULL, NULL, '2025-02-09 16:13:58', '2025-02-09 16:13:58'),
(117, 'App\\Models\\User', 3, 'auth_token', '5d7d11a009f01be00fc403f8ed1339b8b3288da041214445d3f37e7335be6fa7', '[\"*\"]', '2025-02-09 22:27:39', NULL, '2025-02-09 22:23:20', '2025-02-09 22:27:39'),
(118, 'App\\Models\\User', 3, 'auth_token', '22055b36470cbeec2a6a32d0d1ebe62fa046e2fe2b830e4da8a38ae1df725b0d', '[\"*\"]', '2025-02-09 22:28:00', NULL, '2025-02-09 22:27:57', '2025-02-09 22:28:00'),
(119, 'App\\Models\\User', 6, 'auth_token', 'afd947c3a29398d7214f34c10295c52c6016679bb5fefbe878ab8a27447ed45d', '[\"*\"]', '2025-02-11 23:55:43', NULL, '2025-02-11 21:16:31', '2025-02-11 23:55:43'),
(120, 'App\\Models\\User', 6, 'auth_token', 'cdc63940c38a1fbfea3b91c0e61ac1ed2b3032d244c5067d79ec784c39b747ec', '[\"*\"]', '2025-02-11 21:36:53', NULL, '2025-02-11 21:36:05', '2025-02-11 21:36:53'),
(121, 'App\\Models\\User', 9, 'auth_token', 'fe8607b4690ecb51772827c0d8ee83a076c3b2ffa516fcae97b3dccf78c27008', '[\"*\"]', '2025-02-11 23:59:57', NULL, '2025-02-11 23:57:44', '2025-02-11 23:59:57'),
(122, 'App\\Models\\User', 9, 'auth_token', '1d17f2444f2280b7cf423ee02d100f7631dad560fe0aef407fc59c77a52b67b8', '[\"*\"]', NULL, NULL, '2025-02-12 00:00:12', '2025-02-12 00:00:12'),
(123, 'App\\Models\\User', 6, 'auth_token', 'f564895993fd511da4150603c9384a44c3222b8d2f5354f69ee4513f071817ca', '[\"*\"]', '2025-02-16 07:47:08', NULL, '2025-02-12 00:04:02', '2025-02-16 07:47:08'),
(124, 'App\\Models\\User', 3, 'auth_token', '97946303a91229656f55dab8206debb54e06af21d8546e6e69585cc336ecce39', '[\"*\"]', '2025-02-25 22:28:38', NULL, '2025-02-16 15:50:05', '2025-02-25 22:28:38'),
(125, 'App\\Models\\User', 8, 'auth_token', 'd0d7d71106d4fa6055faec307fbadbfedb04388e7654159bf85c433a93404520', '[\"*\"]', NULL, NULL, '2025-02-24 07:29:25', '2025-02-24 07:29:25'),
(126, 'App\\Models\\User', 10, 'auth_token', 'f2a4c185b6700e687ead6f4fc9f50fa5a9bd9b083955a7581e4241aff589c346', '[\"*\"]', '2025-02-24 07:33:52', NULL, '2025-02-24 07:31:53', '2025-02-24 07:33:52'),
(127, 'App\\Models\\User', 6, 'auth_token', 'efb7d6445c2376b32a9081f6864438d9dbb15dd31a7785441cd07b08c4616e71', '[\"*\"]', '2025-02-26 21:07:02', NULL, '2025-02-25 22:31:52', '2025-02-26 21:07:02'),
(128, 'App\\Models\\User', 6, 'auth_token', 'f6fb3d394e283a80069894eb2c42d1d61148514b4540b9e0c1b394d06003bb7e', '[\"*\"]', '2025-02-26 23:18:05', NULL, '2025-02-26 22:56:23', '2025-02-26 23:18:05'),
(129, 'App\\Models\\User', 6, 'auth_token', 'c8591ae2501524aead0a1730f7acf313824c31bdba62ef507d623d843f95a5f9', '[\"*\"]', '2025-02-27 18:50:05', NULL, '2025-02-27 18:14:29', '2025-02-27 18:50:05'),
(130, 'App\\Models\\User', 6, 'auth_token', '55ad3fa2aefa09077bcb180e32e7b33f2b5e29c8aba029fad6d666a410ade059', '[\"*\"]', '2025-02-28 20:52:09', NULL, '2025-02-27 22:12:17', '2025-02-28 20:52:09'),
(131, 'App\\Models\\User', 6, 'auth_token', 'bbb87d6fcd09b1cbf223e8f4ac43346e5f27013850a32fd4c0e2c73875996b32', '[\"*\"]', '2025-02-27 22:54:42', NULL, '2025-02-27 22:54:39', '2025-02-27 22:54:42'),
(132, 'App\\Models\\User', 6, 'auth_token', 'be0db7ea4bd97bbde0be26ef313a200993b39da38450fddc2a16e94d9c239e22', '[\"*\"]', '2025-03-05 19:29:10', NULL, '2025-03-05 19:29:06', '2025-03-05 19:29:10'),
(133, 'App\\Models\\User', 6, 'auth_token', 'f4e5e7df4ae3203c76813de6d1334c500df33257333820eb44369bfede39e80e', '[\"*\"]', '2025-03-05 19:31:42', NULL, '2025-03-05 19:31:38', '2025-03-05 19:31:42'),
(134, 'App\\Models\\User', 6, 'auth_token', 'f2aab0e63be95099593871bb5af9d017bd2e000f9b2d0ecb97e2e3d98c232602', '[\"*\"]', '2025-03-05 19:47:29', NULL, '2025-03-05 19:34:11', '2025-03-05 19:47:29'),
(135, 'App\\Models\\User', 6, 'auth_token', 'af1a5ec3870ea067b2b3b3811b11a43929ecc82a62007ba3f8648023e45040ef', '[\"*\"]', '2025-03-05 22:48:25', NULL, '2025-03-05 22:46:40', '2025-03-05 22:48:25'),
(136, 'App\\Models\\User', 6, 'auth_token', 'fa14e0fe991e3af7fa4d11dbe2437ef580ee79cbcba0fbe8a53ab53fcd4946fa', '[\"*\"]', '2025-03-05 22:52:52', NULL, '2025-03-05 22:52:48', '2025-03-05 22:52:52'),
(137, 'App\\Models\\User', 6, 'auth_token', 'da0e92d02884bde61c5a3e34d26b7b22bb5824d46c813bea5a75be53b8074888', '[\"*\"]', '2025-03-05 22:53:46', NULL, '2025-03-05 22:53:42', '2025-03-05 22:53:46'),
(138, 'App\\Models\\User', 6, 'auth_token', '45f016e2bf1203c07ee0b539068748f66b0b1a17ecf8720fb329a52a5ee4f31d', '[\"*\"]', '2025-03-05 23:22:29', NULL, '2025-03-05 23:22:23', '2025-03-05 23:22:29'),
(139, 'App\\Models\\User', 6, 'auth_token', '8b2ac7c377ace8649453707e90bb35aa05f6e6b464e5467732c2a5db433d5d8d', '[\"*\"]', '2025-03-06 00:29:53', NULL, '2025-03-06 00:10:25', '2025-03-06 00:29:53'),
(140, 'App\\Models\\User', 6, 'auth_token', '5bdf2320b705afb6b562e5227cb379574888870bfa89a38797ad0a8d396ed068', '[\"*\"]', '2025-03-06 17:48:15', NULL, '2025-03-06 17:29:54', '2025-03-06 17:48:15'),
(141, 'App\\Models\\User', 6, 'auth_token', '1b9d41d008d8c06aa669eb3b7979b2af1db2481e83eae3701119aa6b14743185', '[\"*\"]', '2025-03-06 17:51:23', NULL, '2025-03-06 17:51:20', '2025-03-06 17:51:23'),
(142, 'App\\Models\\User', 6, 'auth_token', '6f917df93bb231c25292ec00c324cbed6f21d4c0f8627d6f33a4023b278d0173', '[\"*\"]', '2025-03-06 18:23:18', NULL, '2025-03-06 18:18:15', '2025-03-06 18:23:18'),
(143, 'App\\Models\\User', 3, 'auth_token', '0e3aae2cf621df17c518d8c87f23738d503616b163358b077b4f095777678cbf', '[\"*\"]', '2025-03-06 18:25:00', NULL, '2025-03-06 18:24:56', '2025-03-06 18:25:00'),
(144, 'App\\Models\\User', 3, 'auth_token', '9dac82cb0f302937b60fa95e0de43d8aef35498a10d3a290dae2b67a577b1942', '[\"*\"]', '2025-03-06 18:36:29', NULL, '2025-03-06 18:33:48', '2025-03-06 18:36:29'),
(145, 'App\\Models\\User', 3, 'auth_token', '4366e555931ce9ef616cf4162d4777a0d725f4a864e8d97a315d6b65a0bad5ea', '[\"*\"]', '2025-03-06 18:43:45', NULL, '2025-03-06 18:37:56', '2025-03-06 18:43:45'),
(146, 'App\\Models\\User', 6, 'auth_token', 'c4c11298d0828161c4fc6b87427d5d8031a676b79d3373d74079a5060fcb2a35', '[\"*\"]', '2025-03-06 18:45:26', NULL, '2025-03-06 18:44:21', '2025-03-06 18:45:26'),
(147, 'App\\Models\\User', 6, 'auth_token', '9e785eb62939358cd1251c7a75854c3c7b2f1c0f1d13c7d416f8effcaf41f1a3', '[\"*\"]', '2025-03-06 19:06:28', NULL, '2025-03-06 18:46:03', '2025-03-06 19:06:28'),
(148, 'App\\Models\\User', 3, 'auth_token', '2b7e2285c373e8741536ca2f42733332e85968dff256308f4ab8f09710021331', '[\"*\"]', '2025-03-06 20:20:31', NULL, '2025-03-06 20:20:27', '2025-03-06 20:20:31'),
(149, 'App\\Models\\User', 3, 'auth_token', '56cd3c67f3ffbb3cb7e4fd137c5b97aeb7e248bdf7b8b0fd7605e844c0caa3a8', '[\"*\"]', '2025-03-06 20:52:11', NULL, '2025-03-06 20:35:55', '2025-03-06 20:52:11'),
(150, 'App\\Models\\User', 6, 'auth_token', 'bf8183a913d158c2e7c096f2ad43a3a8633f3a9512875848b766419e0d6bfe76', '[\"*\"]', '2025-03-07 17:36:53', NULL, '2025-03-07 17:09:09', '2025-03-07 17:36:53'),
(151, 'App\\Models\\User', 6, 'auth_token', '2a59a75eccb9b351479e4741cd0cf164d877aceb7e4485c8afcf2913354a2c5a', '[\"*\"]', '2025-03-07 20:16:06', NULL, '2025-03-07 19:20:46', '2025-03-07 20:16:06'),
(152, 'App\\Models\\User', 3, 'auth_token', '87d9f16377cd3e537b558c6cd9a1cb82ee4823bd07b101c08b7aec006c713884', '[\"*\"]', '2025-03-07 20:24:34', NULL, '2025-03-07 20:16:36', '2025-03-07 20:24:34'),
(153, 'App\\Models\\User', 3, 'auth_token', '2c45395945b6c2a21651b565288405b2e65a0b20d0c9074d1710c16840be0bb4', '[\"*\"]', '2025-03-07 20:24:56', NULL, '2025-03-07 20:24:53', '2025-03-07 20:24:56'),
(154, 'App\\Models\\User', 3, 'auth_token', '9a5665b728ec645433f9638bd3b9e67ce5f3dc7887e1a7dc4bb556e8a42e0ae1', '[\"*\"]', '2025-03-07 20:25:39', NULL, '2025-03-07 20:25:08', '2025-03-07 20:25:39'),
(155, 'App\\Models\\User', 3, 'auth_token', '9ff6729bd5b1ecc7e69c42b2b1a9b136e5e22a9d62c1a041efe9866cbcfeb884', '[\"*\"]', '2025-03-07 20:26:41', NULL, '2025-03-07 20:26:09', '2025-03-07 20:26:41'),
(156, 'App\\Models\\User', 3, 'auth_token', '65907c13d3d728344a77872d8cb54c236b954575c541f9c45d6da69a1098c951', '[\"*\"]', '2025-03-07 20:30:57', NULL, '2025-03-07 20:30:19', '2025-03-07 20:30:57'),
(157, 'App\\Models\\User', 6, 'auth_token', '94a22b80451642abfb1792f782587aa0192a853fb4f873abbe6d6e6d05892499', '[\"*\"]', '2025-03-10 17:08:36', NULL, '2025-03-10 17:08:32', '2025-03-10 17:08:36'),
(158, 'App\\Models\\User', 6, 'auth_token', 'ece14b17e2ce32addfb323de9d72ff84eea59e283ae15cf4497e8bcd431d4fc9', '[\"*\"]', '2025-03-10 17:42:24', NULL, '2025-03-10 17:39:37', '2025-03-10 17:42:24'),
(159, 'App\\Models\\User', 3, 'auth_token', '4e0f1ad33d5f6a63aa856ddf8e2df437406be216c756136a9f82a54a215c5519', '[\"*\"]', NULL, NULL, '2025-03-10 18:01:21', '2025-03-10 18:01:21'),
(160, 'App\\Models\\User', 3, 'auth_token', '7418dac097c079b174aecb71e813f0f56209ac82a179f71a581aaa0bf2b8391a', '[\"*\"]', '2025-03-10 18:05:03', NULL, '2025-03-10 18:04:39', '2025-03-10 18:05:03'),
(161, 'App\\Models\\User', 6, 'auth_token', '8896205f450a18e559e892ce19f13fdcbc4953ad909f2e5b8e7d2d2c3516a8e9', '[\"*\"]', '2025-03-10 18:12:53', NULL, '2025-03-10 18:11:21', '2025-03-10 18:12:53'),
(162, 'App\\Models\\User', 6, 'auth_token', '6672750fc66d41b867e6f6f66b93236c8c0449102fc422a7134484887ed8c7f7', '[\"*\"]', '2025-03-10 18:30:34', NULL, '2025-03-10 18:13:36', '2025-03-10 18:30:34'),
(163, 'App\\Models\\User', 6, 'auth_token', 'e8d6aa8572d837b65d5c86c09d484c81fdaf17cb82915fb0dc8bc0be320eb9a7', '[\"*\"]', '2025-03-10 19:37:24', NULL, '2025-03-10 18:36:59', '2025-03-10 19:37:24'),
(164, 'App\\Models\\User', 6, 'auth_token', '918b23fe6c53f1e1ff29374b659faed40eda4472cc768f19ee27220f19e0682c', '[\"*\"]', '2025-03-11 02:39:08', NULL, '2025-03-10 20:58:31', '2025-03-11 02:39:08'),
(165, 'App\\Models\\User', 3, 'auth_token', '8f8154c6aa2c224a45c3e14a81fe95f741022f62c5946e3a6067cc5d460921cc', '[\"*\"]', '2025-03-11 17:07:17', NULL, '2025-03-11 16:52:29', '2025-03-11 17:07:17'),
(166, 'App\\Models\\User', 3, 'auth_token', '771cf767391f3d00b12c5e1deab14a0dd44c88cea16a5a1944403da943fc51fb', '[\"*\"]', '2025-03-11 17:11:40', NULL, '2025-03-11 17:10:28', '2025-03-11 17:11:40'),
(167, 'App\\Models\\User', 3, 'auth_token', 'ff77387883e00191da8a948f1941b8b95f24da0095bdc80ac25f39529b4feb06', '[\"*\"]', '2025-03-11 17:13:16', NULL, '2025-03-11 17:13:06', '2025-03-11 17:13:16'),
(168, 'App\\Models\\User', 3, 'auth_token', '481775ec3c0dd9e3c6dfa06a82e7b35a1e8df7791d1a3f4dc95af7de019e6206', '[\"*\"]', '2025-03-11 17:15:58', NULL, '2025-03-11 17:13:43', '2025-03-11 17:15:58'),
(169, 'App\\Models\\User', 3, 'auth_token', '2fdcd3335ccb04ec5be5cc003b8baa1ec1a24aedf70a8987c1b4456fd998b9f9', '[\"*\"]', '2025-03-11 17:17:02', NULL, '2025-03-11 17:16:41', '2025-03-11 17:17:02'),
(170, 'App\\Models\\User', 3, 'auth_token', 'e4d3d24d91369e48e13227c3757145b6191799c69cd4d2a99ab860b2cbb0695e', '[\"*\"]', '2025-03-11 17:18:31', NULL, '2025-03-11 17:18:20', '2025-03-11 17:18:31'),
(171, 'App\\Models\\User', 3, 'auth_token', '0138109bdd2a2681e9a1aadc2e0a4ad835588cef7de8706aca5224974d44bef2', '[\"*\"]', '2025-03-11 17:19:34', NULL, '2025-03-11 17:19:16', '2025-03-11 17:19:34'),
(172, 'App\\Models\\User', 3, 'auth_token', '0d0e713eceda1818db6253da3ebc18c35eadbc3585968e779a3de35984730798', '[\"*\"]', NULL, NULL, '2025-03-11 17:34:42', '2025-03-11 17:34:42'),
(173, 'App\\Models\\User', 3, 'auth_token', '3e3865ed63a9823fb7e16de7bfbd1d6c1a80d2ae2c6b8e5343824ffd9582b93e', '[\"*\"]', '2025-03-11 17:35:36', NULL, '2025-03-11 17:35:25', '2025-03-11 17:35:36'),
(174, 'App\\Models\\User', 3, 'auth_token', '3e9bf6bb3b75de6b60a32cfc9a4d81002ee3aba716ca5de2f9720bde7727eed6', '[\"*\"]', '2025-03-11 17:38:11', NULL, '2025-03-11 17:37:55', '2025-03-11 17:38:11'),
(175, 'App\\Models\\User', 6, 'auth_token', 'df0767ff79669a8e26b2e04f7c002c9009db8dc1af6ef0c75a3cc610d3c0a8eb', '[\"*\"]', '2025-03-11 18:03:59', NULL, '2025-03-11 17:51:23', '2025-03-11 18:03:59'),
(176, 'App\\Models\\User', 6, 'auth_token', '4358817ab5dd39049ecdab551ba54d9cfd21d00363806881e6a6c24e6d669c12', '[\"*\"]', '2025-03-14 20:14:53', NULL, '2025-03-14 20:10:28', '2025-03-14 20:14:53'),
(177, 'App\\Models\\User', 6, 'auth_token', 'e564082eda899a57d1b751cfb65a8f22a2f4e3acc1b78f348c4aa98c52eedac5', '[\"*\"]', '2025-03-14 20:20:50', NULL, '2025-03-14 20:20:49', '2025-03-14 20:20:50'),
(178, 'App\\Models\\User', 6, 'auth_token', 'ea9fe77e9feb81d0426fa718335c72cd614bb8e8ab1a208fc1805db5d380c4ef', '[\"*\"]', NULL, NULL, '2025-03-14 20:39:13', '2025-03-14 20:39:13'),
(179, 'App\\Models\\User', 6, 'auth_token', '5d393ec79601fae09ebe51c9e61aa06632ae2be6b0d11bf30e2cae1e07603549', '[\"*\"]', '2025-03-20 18:42:04', NULL, '2025-03-20 18:28:08', '2025-03-20 18:42:04'),
(180, 'App\\Models\\User', 6, 'auth_token', '0cb65988bfb44261af3dfc0a1984cdb1e37babf284d4778d5f56f36ab7c02379', '[\"*\"]', '2025-03-20 19:57:03', NULL, '2025-03-20 18:45:36', '2025-03-20 19:57:03'),
(181, 'App\\Models\\User', 6, 'auth_token', '63f147cf882a93548777bd5acba83351dde2721171eedddc3a9e5ccdafa6c06a', '[\"*\"]', '2025-03-24 22:49:28', NULL, '2025-03-20 19:11:17', '2025-03-24 22:49:28'),
(182, 'App\\Models\\User', 6, 'auth_token', '19bf6e090093357c5ab804414968eee7576fa2493779236636f8851617fb6862', '[\"*\"]', '2025-03-20 20:05:28', NULL, '2025-03-20 20:05:26', '2025-03-20 20:05:28'),
(183, 'App\\Models\\User', 3, 'auth_token', 'e5475039b44e495e16e62d58226c93bf63d537e8b95cb1a8611340cd0dd0e21e', '[\"*\"]', '2025-03-21 19:19:10', NULL, '2025-03-20 20:06:03', '2025-03-21 19:19:10'),
(184, 'App\\Models\\User', 16, 'auth_token', '7b9caebb7c0717a2598c272e9dd00e1efffa0cfb531af0e50905166b4644eddd', '[\"*\"]', '2025-03-21 16:48:16', NULL, '2025-03-21 16:45:11', '2025-03-21 16:48:16'),
(185, 'App\\Models\\User', 16, 'auth_token', '17bd65d2bb9dfa30ebebf47b6133ddc07f53e59f875a3616a06da432abd7293e', '[\"*\"]', '2025-03-21 19:06:09', NULL, '2025-03-21 19:02:43', '2025-03-21 19:06:09'),
(186, 'App\\Models\\User', 19, 'auth_token', 'aba6e6af54eb4548f173943fa159f90723a27b57a7454d42f79cb16d4759f327', '[\"*\"]', '2025-03-21 19:13:26', NULL, '2025-03-21 19:09:01', '2025-03-21 19:13:26'),
(187, 'App\\Models\\User', 16, 'auth_token', '8419e7a0cb4191637a60797a190eca961427866a661bc0127e19d47888553bff', '[\"*\"]', '2025-03-21 19:24:35', NULL, '2025-03-21 19:14:14', '2025-03-21 19:24:35'),
(188, 'App\\Models\\User', 6, 'auth_token', 'cfc2fb3c0d83a5a9b976154a41888e030c794085f788e2a4466a860a1b349dc9', '[\"*\"]', '2025-03-21 19:21:29', NULL, '2025-03-21 19:19:44', '2025-03-21 19:21:29'),
(189, 'App\\Models\\User', 16, 'auth_token', '57062b333aeed895619561a51865f6eb0fe8bd6830c148fc76360a25a0704ac5', '[\"*\"]', '2025-03-21 19:26:18', NULL, '2025-03-21 19:25:42', '2025-03-21 19:26:18'),
(190, 'App\\Models\\User', 6, 'auth_token', '707fb9fac00e96fed48f8bd90018c1231e7a469087e3e75e8ac31fa1b57eeaf0', '[\"*\"]', '2025-03-21 20:00:40', NULL, '2025-03-21 19:33:56', '2025-03-21 20:00:40'),
(191, 'App\\Models\\User', 3, 'auth_token', '3011453c97903fb4867758478e154ba1ded89a7d7f2af198e5dec09c6062e96b', '[\"*\"]', '2025-03-21 21:27:46', NULL, '2025-03-21 20:03:37', '2025-03-21 21:27:46'),
(192, 'App\\Models\\User', 6, 'auth_token', 'ffafcbef0313db6373fbfb3c4f9951a022e4cfa312b748dcda538f1fccd63974', '[\"*\"]', '2025-03-21 21:36:25', NULL, '2025-03-21 21:33:46', '2025-03-21 21:36:25'),
(193, 'App\\Models\\User', 3, 'auth_token', '3cd2821918963992e00cefe6d9cb2907ed29979a8bd2000f9b6e3ecd710cd28f', '[\"*\"]', '2025-03-21 21:48:12', NULL, '2025-03-21 21:36:48', '2025-03-21 21:48:12'),
(194, 'App\\Models\\User', 3, 'auth_token', '1a0f9e6bfecff8059eb42be8808717db784b0e1d2570e5fa508d391cec660b36', '[\"*\"]', '2025-03-21 21:49:14', NULL, '2025-03-21 21:48:23', '2025-03-21 21:49:14'),
(195, 'App\\Models\\User', 3, 'auth_token', '6e430a8d52db12dfc0fc564ce8d31562fbcf531d4edbdbd2d1db47ff60f93711', '[\"*\"]', '2025-03-21 21:56:40', NULL, '2025-03-21 21:50:05', '2025-03-21 21:56:40'),
(196, 'App\\Models\\User', 6, 'auth_token', '7eb51106320ad57ca672477ace1e7fe59aef5457fc4de690c99286e5d6bc8866', '[\"*\"]', '2025-03-21 22:08:41', NULL, '2025-03-21 21:57:18', '2025-03-21 22:08:41'),
(197, 'App\\Models\\User', 20, 'auth_token', 'b957fdac8c84a711d01fcd68a2d6131212748841d15383bd3ad70defbdf82859', '[\"*\"]', '2025-03-23 02:18:03', NULL, '2025-03-23 02:17:12', '2025-03-23 02:18:03'),
(198, 'App\\Models\\User', 21, 'auth_token', '8e92fa249de966426fb611ca0cfcbefde0617876a2a7f6ac1f8a5cd941bdf7e2', '[\"*\"]', '2025-03-23 16:53:31', NULL, '2025-03-23 16:50:59', '2025-03-23 16:53:31'),
(199, 'App\\Models\\User', 21, 'auth_token', 'abec20c23e287079b86a188a5b16686b91cc69a457dded7f5b15ae5ec283aa85', '[\"*\"]', '2025-03-23 22:57:15', NULL, '2025-03-23 22:55:03', '2025-03-23 22:57:15'),
(200, 'App\\Models\\User', 21, 'auth_token', '8191c1fd857053a186124d8514c722ae84095f6ffea389f155b65797c6652814', '[\"*\"]', '2025-03-24 01:14:09', NULL, '2025-03-24 01:14:08', '2025-03-24 01:14:09'),
(201, 'App\\Models\\User', 21, 'auth_token', 'b844ce28849eaeede0fb756c7ebaea0e3c02a1a768f1a57b732d4229c496f06e', '[\"*\"]', '2025-03-24 01:27:28', NULL, '2025-03-24 01:16:51', '2025-03-24 01:27:28'),
(202, 'App\\Models\\User', 3, 'auth_token', 'f6363b82d868102534a4d1e7e9082e8275728d30ed64823dec19a1bd76a40603', '[\"*\"]', '2025-03-24 18:13:10', NULL, '2025-03-24 18:04:47', '2025-03-24 18:13:10'),
(203, 'App\\Models\\User', 6, 'auth_token', '18275dd048bf096a566284a6a242287a1334a1d1dd5bf120c084804de4e5c0d6', '[\"*\"]', '2025-03-24 19:10:10', NULL, '2025-03-24 18:14:25', '2025-03-24 19:10:10'),
(204, 'App\\Models\\User', 3, 'auth_token', '5612e9a47300aaa61ce8f7be7b00e427b58d6d7309d2cf9b709f19ab0afafe80', '[\"*\"]', '2025-03-24 19:12:22', NULL, '2025-03-24 19:11:34', '2025-03-24 19:12:22'),
(205, 'App\\Models\\User', 6, 'auth_token', 'fc8f61d77f09f49f539b4e3539ef910711fccf36c9de716696c570c99793bb39', '[\"*\"]', '2025-03-24 19:13:15', NULL, '2025-03-24 19:12:57', '2025-03-24 19:13:15'),
(206, 'App\\Models\\User', 6, 'auth_token', 'bead819151333d87f1fa6a36daa9d046fe844a55223294be9b266125fb2984dd', '[\"*\"]', '2025-03-24 20:04:02', NULL, '2025-03-24 20:03:17', '2025-03-24 20:04:02'),
(207, 'App\\Models\\User', 6, 'auth_token', '2b4261f2726f419ff268b83b0cebe04bbd47c0d2d9b553efe7fee1979fdd498d', '[\"*\"]', '2025-03-24 23:10:26', NULL, '2025-03-24 20:07:46', '2025-03-24 23:10:26'),
(208, 'App\\Models\\User', 3, 'auth_token', 'a424c346e5b1136b2430fc099deaf03649a7de67e7980effc339546930811447', '[\"*\"]', '2025-03-25 00:01:35', NULL, '2025-03-24 23:11:12', '2025-03-25 00:01:35'),
(209, 'App\\Models\\User', 6, 'auth_token', 'cbddf97f519eb1ead2c361fe89e37a8b03ae8e932285dd96e6b3d9221364b680', '[\"*\"]', '2025-03-25 00:44:34', NULL, '2025-03-25 00:02:02', '2025-03-25 00:44:34'),
(210, 'App\\Models\\User', 3, 'auth_token', 'c1cdb2eb5a3b72dfb0e6c1eb487071d824c4f72e58d419f0c424c9f3533bbeae', '[\"*\"]', '2025-03-25 18:11:16', NULL, '2025-03-25 00:45:04', '2025-03-25 18:11:16'),
(211, 'App\\Models\\User', 3, 'auth_token', '893dc11235042b6716df84b70d87eab9455b0b66f7d9dc7f4759c1c94f69dba5', '[\"*\"]', '2025-03-26 00:42:14', NULL, '2025-03-25 18:24:27', '2025-03-26 00:42:14'),
(212, 'App\\Models\\User', 3, 'auth_token', 'caf1c5e324ffcce5ac887a5d89089680b31046bba327b8939ebfdb500d35f612', '[\"*\"]', '2025-03-26 00:30:30', NULL, '2025-03-25 20:34:42', '2025-03-26 00:30:30'),
(213, 'App\\Models\\User', 21, 'auth_token', '0dbd938668ad288ba411e01ee894f65f151a94ccfb464bb5a2cfef0abf1fc32e', '[\"*\"]', '2025-03-25 21:55:54', NULL, '2025-03-25 21:53:53', '2025-03-25 21:55:54'),
(214, 'App\\Models\\User', 6, 'auth_token', '8ab556e756a034b632b0324196e6f1a6cebfc608d577dccb62e39968cc2246b4', '[\"*\"]', '2025-03-26 20:11:46', NULL, '2025-03-26 00:43:12', '2025-03-26 20:11:46'),
(215, 'App\\Models\\User', 6, 'auth_token', '44d7d1305b0e366a560bf3d5ae74efb9047fc82331d76c92fd9c4aa170a886a3', '[\"*\"]', '2025-03-26 23:58:05', NULL, '2025-03-26 17:47:54', '2025-03-26 23:58:05'),
(216, 'App\\Models\\User', 21, 'auth_token', '76f0a376505e44850c607c165dfa0887d74453ecefeae040ff6425f311b2f376', '[\"*\"]', '2025-03-26 17:57:24', NULL, '2025-03-26 17:57:00', '2025-03-26 17:57:24'),
(217, 'App\\Models\\User', 4, 'auth_token', '7bb4160b39dd8ab5b39be6a240f5068e396e1b7ec91e1b0df0095e06f6934193', '[\"*\"]', '2025-03-26 20:19:07', NULL, '2025-03-26 20:18:10', '2025-03-26 20:19:07'),
(218, 'App\\Models\\User', 6, 'auth_token', 'e6a26e3ee8bdbd6a2af6229a9d3cc1a12ab290b6dd56292f5cbb6bed19487773', '[\"*\"]', '2025-03-26 21:51:39', NULL, '2025-03-26 20:20:28', '2025-03-26 21:51:39'),
(219, 'App\\Models\\User', 3, 'auth_token', '5b8f49db35589c9cdaea66e894bd331c5b5ce8c1cbdba310c263010ecf2d84d1', '[\"*\"]', '2025-03-26 22:13:36', NULL, '2025-03-26 21:52:01', '2025-03-26 22:13:36'),
(220, 'App\\Models\\User', 6, 'auth_token', '39fb7a803447b7d3f1e386773f15f24a869424d0f61d7f617b1526858de2f2a3', '[\"*\"]', '2025-03-26 22:35:07', NULL, '2025-03-26 22:35:06', '2025-03-26 22:35:07'),
(221, 'App\\Models\\User', 22, 'auth_token', 'a37588cd42fbf8630626589dc570ed5f1635dc242b78dc76e4a628ad61764d00', '[\"*\"]', '2025-04-22 23:23:25', NULL, '2025-03-26 23:01:01', '2025-04-22 23:23:25'),
(222, 'App\\Models\\User', 4, 'auth_token', '392ce9aa376a949ea3936b354a1a26a2ae336d2458284d5ac613803dd306bdd2', '[\"*\"]', NULL, NULL, '2025-03-26 23:02:07', '2025-03-26 23:02:07'),
(223, 'App\\Models\\User', 6, 'auth_token', 'e716aa034950eb5a9be0a7bc7d66a9edf6eb514cd4b9d49eb870d0fdd6ec5d5c', '[\"*\"]', '2025-03-26 23:58:33', NULL, '2025-03-26 23:03:25', '2025-03-26 23:58:33'),
(224, 'App\\Models\\User', 4, 'auth_token', '9a6afddc729bc90a15111756ad4c4bfbcc42a1f0e90f9c600b1fd60233fc78a4', '[\"*\"]', '2025-03-29 10:53:15', NULL, '2025-03-26 23:03:53', '2025-03-29 10:53:15'),
(225, 'App\\Models\\User', 6, 'auth_token', 'a6954998b892d12bc4beb300ac9a1abb02b0c40b96388764cc78026d34e6e6ff', '[\"*\"]', '2025-03-27 00:19:55', NULL, '2025-03-26 23:58:56', '2025-03-27 00:19:55'),
(226, 'App\\Models\\User', 23, 'auth_token', '2b52be7e841c74d4fda9db607c88c7168b0bbeb238c6fa926559ce2d3bcadc61', '[\"*\"]', '2025-03-27 00:26:55', NULL, '2025-03-27 00:23:49', '2025-03-27 00:26:55'),
(227, 'App\\Models\\User', 23, 'auth_token', 'c53962ce83ceb945852a43c53fbc9634de74ac3e4316c1aef43d290d687ffb3c', '[\"*\"]', NULL, NULL, '2025-03-27 00:29:06', '2025-03-27 00:29:06'),
(228, 'App\\Models\\User', 3, 'auth_token', '184878d1ea526c0e01988fa390aba261d9ae37da5d22a00b5ce6fbec7772b9e4', '[\"*\"]', '2025-03-27 03:33:26', NULL, '2025-03-27 00:29:26', '2025-03-27 03:33:26'),
(229, 'App\\Models\\User', 3, 'auth_token', '988acf7924adbefa0e519676d166477d05b93e23447c32355bc7903f4a02c25a', '[\"*\"]', '2025-03-27 18:05:33', NULL, '2025-03-27 03:34:56', '2025-03-27 18:05:33'),
(230, 'App\\Models\\User', 3, 'auth_token', '07d9cd6f105825b86c848b30a31e83b48e3263079690b44ef6e5a725aee8a177', '[\"*\"]', NULL, NULL, '2025-03-27 17:10:57', '2025-03-27 17:10:57'),
(231, 'App\\Models\\User', 3, 'auth_token', '9227cc15c1fcf0acb8253fbf2f032428840bf9382e17548bbf8a153a72ce5afb', '[\"*\"]', '2025-03-27 17:33:06', NULL, '2025-03-27 17:12:18', '2025-03-27 17:33:06'),
(232, 'App\\Models\\User', 6, 'auth_token', '158dd190259785e4961b6ea889fdc87a6de4f4caa4a6d785c33566f57fd70c8b', '[\"*\"]', '2025-03-27 18:07:01', NULL, '2025-03-27 18:06:12', '2025-03-27 18:07:01'),
(233, 'App\\Models\\User', 3, 'auth_token', '77f73876a70f7f464c592de13522254e0e930f2e352a9b8de1bdd2d9b147f908', '[\"*\"]', '2025-03-27 18:08:16', NULL, '2025-03-27 18:07:55', '2025-03-27 18:08:16'),
(234, 'App\\Models\\User', 6, 'auth_token', 'b450ea63d45c0170a34e0944e48b2c06521e4dcdb36e74765ab7da0608650b57', '[\"*\"]', '2025-03-27 18:44:59', NULL, '2025-03-27 18:08:35', '2025-03-27 18:44:59'),
(235, 'App\\Models\\User', 3, 'auth_token', 'a7bb4f13a1fc3a5917a78b69bd8fe4a731942d252611951e7e9375214295e275', '[\"*\"]', '2025-03-27 22:35:28', NULL, '2025-03-27 18:45:25', '2025-03-27 22:35:28'),
(236, 'App\\Models\\User', 3, 'auth_token', 'd88ef13c342d73c35b508f808065bffbfff8f013f6e8b022bb1a2adb48d685bc', '[\"*\"]', '2025-03-27 22:40:48', NULL, '2025-03-27 22:38:07', '2025-03-27 22:40:48'),
(237, 'App\\Models\\User', 24, 'auth_token', '37c0471b1320b2cc9a72e88fded6fca46630eac3746a2462a3ba9eb6497e8c7e', '[\"*\"]', '2025-03-27 22:48:19', NULL, '2025-03-27 22:42:05', '2025-03-27 22:48:19'),
(238, 'App\\Models\\User', 25, 'auth_token', '683dae633465ef88ad1e71c4182306661657595ef826621aa56881856397fde8', '[\"*\"]', '2025-03-27 23:26:35', NULL, '2025-03-27 23:25:04', '2025-03-27 23:26:35'),
(239, 'App\\Models\\User', 6, 'auth_token', 'cae84fd074bee520d86853170e33a08a6088042db093ef90b3b0c5a1f3c7d228', '[\"*\"]', '2025-03-27 23:28:20', NULL, '2025-03-27 23:27:11', '2025-03-27 23:28:20'),
(240, 'App\\Models\\User', 6, 'auth_token', '6191dd595e6c8bfe8c0d59e3baa77bacd8141e8ce13c6bfffd4a32552c6f977d', '[\"*\"]', '2025-04-04 16:41:37', NULL, '2025-03-28 18:28:03', '2025-04-04 16:41:37'),
(241, 'App\\Models\\User', 3, 'auth_token', 'c728940a8ce753641113ef0e72643c5d9f75a69f9401fef98f328e05d812bdd5', '[\"*\"]', NULL, NULL, '2025-03-29 10:48:04', '2025-03-29 10:48:04'),
(242, 'App\\Models\\User', 4, 'auth_token', '03a7d52a22c853ddbcc39adfcdf30ab329ea7c4e8804581a6692885a117ebb6a', '[\"*\"]', '2025-03-29 12:56:22', NULL, '2025-03-29 10:49:29', '2025-03-29 12:56:22'),
(243, 'App\\Models\\User', 4, 'auth_token', '0656d922ba19ae70d8ed8cdabd2b6f68adfaa816c9cbf122cf912dd2eb7e682c', '[\"*\"]', '2025-03-29 10:53:50', NULL, '2025-03-29 10:53:49', '2025-03-29 10:53:50'),
(244, 'App\\Models\\User', 6, 'auth_token', '793b6cac1faa86f6efe3adf8a6894479b147d8a2e3d6add88ad88a2d32cc0c51', '[\"*\"]', '2025-03-29 10:58:40', NULL, '2025-03-29 10:54:30', '2025-03-29 10:58:40'),
(245, 'App\\Models\\User', 4, 'auth_token', '572975aa0d59a3306c063cb399d104a570c37caf4354b643f0b7f3d9fbbcf921', '[\"*\"]', '2025-03-29 11:00:04', NULL, '2025-03-29 10:59:02', '2025-03-29 11:00:04'),
(246, 'App\\Models\\User', 6, 'auth_token', '42c3e523fb1f8aa3c30fbe34d38462739f726363e098c56c2d9d541ab5e07372', '[\"*\"]', '2025-03-29 12:56:28', NULL, '2025-03-29 11:00:26', '2025-03-29 12:56:28'),
(247, 'App\\Models\\User', 4, 'auth_token', 'dd79da087f7bd154d1040522d67596ac3c8a1438f84718404e5a174d38011f7f', '[\"*\"]', '2025-04-04 16:22:46', NULL, '2025-04-04 16:21:45', '2025-04-04 16:22:46'),
(248, 'App\\Models\\User', 3, 'auth_token', '6d9c119e5e24a731a1701a05a5da5f9666de93d6c72d0642f6369cf4e96e0129', '[\"*\"]', '2025-04-10 16:52:27', NULL, '2025-04-10 16:52:24', '2025-04-10 16:52:27'),
(249, 'App\\Models\\User', 6, 'auth_token', '73f2630dde482cf514d5de357f41a5f5c5ac9f468d71556a2ff21bbd10951c22', '[\"*\"]', '2025-04-10 16:56:37', NULL, '2025-04-10 16:56:24', '2025-04-10 16:56:37'),
(250, 'App\\Models\\User', 3, 'auth_token', '34aaac07be0a960ff17521a8e36ed723e165c396bfbdf6a4b6d7a41a9a66d421', '[\"*\"]', '2025-04-17 23:43:57', NULL, '2025-04-10 16:57:26', '2025-04-17 23:43:57'),
(251, 'App\\Models\\User', 6, 'auth_token', 'b59cb966abb3c070425f5e878cdc7eddfed99a9c0f443c8c5c79f3d69645d67d', '[\"*\"]', '2025-04-23 17:38:07', NULL, '2025-04-18 18:47:14', '2025-04-23 17:38:07'),
(252, 'App\\Models\\User', 6, 'auth_token', '5b0347e82252b9e039b9998575892fafb7ad3f1e10a53b606e3f29a253c8811d', '[\"*\"]', '2025-04-23 19:43:33', NULL, '2025-04-23 17:39:27', '2025-04-23 19:43:33'),
(253, 'App\\Models\\User', 6, 'auth_token', '1415139d143b0a4c1e41d91267d0d072ac458b4cde06bb9a3f20632c73c9fe58', '[\"*\"]', '2025-04-23 20:02:26', NULL, '2025-04-23 19:58:14', '2025-04-23 20:02:26'),
(254, 'App\\Models\\User', 3, 'auth_token', 'b0a0681d331fd27438094afa90099e5ba8f33e8d473a1c383e8e9842f1bb61ce', '[\"*\"]', '2025-04-23 20:28:05', NULL, '2025-04-23 20:28:02', '2025-04-23 20:28:05'),
(255, 'App\\Models\\User', 3, 'auth_token', '412980b12a0e590c414f25df5ed2cc3658062ce5cf243c7d8009e9b25d7b624a', '[\"*\"]', '2025-04-23 22:10:05', NULL, '2025-04-23 20:51:51', '2025-04-23 22:10:05'),
(256, 'App\\Models\\User', 6, 'auth_token', '51fd00eae5aee9f9c9e94387650e64ec87315d00055c55d26145c66dc0007900', '[\"*\"]', '2025-04-23 22:15:05', NULL, '2025-04-23 22:15:03', '2025-04-23 22:15:05'),
(257, 'App\\Models\\User', 6, 'auth_token', 'e98d29b8d9b3cb74345200a8e465e2116d97e8accb21e374f88fce7de937ba87', '[\"*\"]', '2025-04-23 22:28:12', NULL, '2025-04-23 22:27:35', '2025-04-23 22:28:12'),
(258, 'App\\Models\\User', 6, 'auth_token', 'b7c4c359b9eb6ec01b3dcab2169be675483605196bde739b62ddc3b1d817cdb6', '[\"*\"]', '2025-04-23 22:30:32', NULL, '2025-04-23 22:30:31', '2025-04-23 22:30:32'),
(259, 'App\\Models\\User', 6, 'auth_token', '17554dcda5804f1374cee9735ac37753e4213a963be59eb2685a22b3f75f857c', '[\"*\"]', '2025-04-23 22:32:28', NULL, '2025-04-23 22:32:27', '2025-04-23 22:32:28'),
(260, 'App\\Models\\User', 6, 'auth_token', 'ba5ea6612962f7f1907eb05c0badc13d21d7be03d4d26dd2746a1bffc32bc8d9', '[\"*\"]', '2025-04-25 16:30:41', NULL, '2025-04-23 22:33:55', '2025-04-25 16:30:41'),
(261, 'App\\Models\\User', 3, 'auth_token', '4d8076ef2f4c9497d31ff36c7a3404743aeacc43deb42f3e83416b3f139fbfff', '[\"*\"]', '2025-04-25 17:18:54', NULL, '2025-04-25 16:31:48', '2025-04-25 17:18:54'),
(262, 'App\\Models\\User', 4, 'auth_token', '21cb1943d5197f70c60d832dd4ef5cf2510a67612368844bda248525fe603d5b', '[\"*\"]', '2025-04-25 19:08:14', NULL, '2025-04-25 17:20:33', '2025-04-25 19:08:14'),
(263, 'App\\Models\\User', 4, 'auth_token', '9027c257a290cb7fc21fef2de84bc55d52ee4439cfb5fad111068bc9f719db6f', '[\"*\"]', '2025-04-25 19:56:25', NULL, '2025-04-25 19:15:54', '2025-04-25 19:56:25'),
(264, 'App\\Models\\User', 4, 'auth_token', 'aaa0880f94809464c716320208bdd1e05234e2ff12f751e813ea88eb42550174', '[\"*\"]', '2025-04-28 17:03:42', NULL, '2025-04-25 19:19:34', '2025-04-28 17:03:42'),
(265, 'App\\Models\\User', 3, 'auth_token', 'f9fa3649044b99f1a8f6aa126823efbeb06508fcc87ba718d782a847864bde48', '[\"*\"]', '2025-04-28 23:09:11', NULL, '2025-04-25 19:56:53', '2025-04-28 23:09:11'),
(266, 'App\\Models\\User', 3, 'auth_token', 'b326f890c8562a52ccfb4680d273aa9cca77d2f4e1a4f1806231eb40b10dda25', '[\"*\"]', '2025-04-28 17:11:54', NULL, '2025-04-28 16:58:24', '2025-04-28 17:11:54'),
(267, 'App\\Models\\User', 3, 'auth_token', '92dbc8bc3fd8bf391e3f2fb9b42e92ddf8b60696eee874a711ff61305f99647f', '[\"*\"]', '2025-04-28 17:04:21', NULL, '2025-04-28 17:03:58', '2025-04-28 17:04:21'),
(268, 'App\\Models\\User', 6, 'auth_token', '017103b5f8ed26d99edba5a36425f773ca368de7467688f6070390934843e3f9', '[\"*\"]', '2025-04-28 17:06:01', NULL, '2025-04-28 17:05:00', '2025-04-28 17:06:01'),
(269, 'App\\Models\\User', 3, 'auth_token', '8a98590001efba5e2aa813fc8694d562d65613759bf5d955ae99e3610bdd4117', '[\"*\"]', '2025-04-28 17:07:28', NULL, '2025-04-28 17:06:13', '2025-04-28 17:07:28'),
(270, 'App\\Models\\User', 6, 'auth_token', '04fc5906927b41f5d11707196236b7b4d338902ce842dbf4cebc1f2238431698', '[\"*\"]', '2025-04-28 17:09:58', NULL, '2025-04-28 17:08:05', '2025-04-28 17:09:58'),
(271, 'App\\Models\\User', 6, 'auth_token', '65ea42e8c7e7dd09cbc0f1ce3bfb3b912bd01bf48aee3ec8db4105c4fed59ff9', '[\"*\"]', '2025-04-28 17:11:57', NULL, '2025-04-28 17:10:17', '2025-04-28 17:11:57'),
(272, 'App\\Models\\User', 3, 'auth_token', '0be8c3ae2d830b6e408a4e4d5c550b3e232c0a4191434a98ce386fc2a987e8a2', '[\"*\"]', '2025-04-28 17:46:25', NULL, '2025-04-28 17:13:24', '2025-04-28 17:46:25'),
(273, 'App\\Models\\User', 6, 'auth_token', '306cdcc03320493d5d8d7050168d47e52998a47de771e782432897a1ea0487a4', '[\"*\"]', '2025-04-28 18:00:00', NULL, '2025-04-28 17:46:39', '2025-04-28 18:00:00'),
(274, 'App\\Models\\User', 3, 'auth_token', '1c2edc945cbc3fe135375fa949d10d0701de7f4e70825268cb4e978931e599b1', '[\"*\"]', '2025-04-28 18:29:37', NULL, '2025-04-28 18:11:09', '2025-04-28 18:29:37'),
(275, 'App\\Models\\User', 3, 'auth_token', 'a57efcfeeba60dd920c532ae8a004b0807892cc0cf8ff25f357554d3e5e79869', '[\"*\"]', '2025-04-28 18:30:07', NULL, '2025-04-28 18:29:58', '2025-04-28 18:30:07'),
(276, 'App\\Models\\User', 6, 'auth_token', 'af1a8c4c9bfd8036641a3d84a7c61f9531b5c4d0db8cf187418461308bdc5828', '[\"*\"]', '2025-04-28 20:07:29', NULL, '2025-04-28 18:30:24', '2025-04-28 20:07:29'),
(277, 'App\\Models\\User', 26, 'auth_token', '81c6fd86ae486dafd54fdf199397beffcd826682d88891eed7c311d20bfab340', '[\"*\"]', '2025-04-28 20:29:58', NULL, '2025-04-28 20:09:43', '2025-04-28 20:29:58'),
(278, 'App\\Models\\User', 26, 'auth_token', 'bb6a6c17ce046fde13e8a0e70f5003142fbace0dadfa1ccf394bdd584f3985dd', '[\"*\"]', NULL, NULL, '2025-04-28 20:30:18', '2025-04-28 20:30:18'),
(279, 'App\\Models\\User', 26, 'auth_token', '8720ca68ba327efb0e81372c7ff8e5a9e114280f9e75c189e8ae94691d0560ea', '[\"*\"]', NULL, NULL, '2025-04-28 20:30:25', '2025-04-28 20:30:25'),
(280, 'App\\Models\\User', 6, 'auth_token', '17b2f2f203859703634a756010ff9c822cecbff8bfa41fa0220ce76318766676', '[\"*\"]', '2025-04-28 20:49:08', NULL, '2025-04-28 20:32:45', '2025-04-28 20:49:08'),
(281, 'App\\Models\\User', 3, 'auth_token', '0051134e383d308829edbbbe0a1b9624fd0b63fced8d234963b6ec5cdffdabfc', '[\"*\"]', '2025-04-28 21:30:39', NULL, '2025-04-28 20:50:31', '2025-04-28 21:30:39'),
(282, 'App\\Models\\User', 6, 'auth_token', 'ee0b0124077964710f8a0270196a37d79d6663fea5ba5a0d38476ae8f83d6e23', '[\"*\"]', '2025-04-28 22:21:43', NULL, '2025-04-28 21:37:00', '2025-04-28 22:21:43'),
(283, 'App\\Models\\User', 3, 'auth_token', 'bb363b59f6f7cfeea398c5b667c2c89f593050e6c3ac0eeaa7745b8b33491fd7', '[\"*\"]', '2025-04-28 22:37:11', NULL, '2025-04-28 22:22:10', '2025-04-28 22:37:11'),
(284, 'App\\Models\\User', 27, 'auth_token', 'b37381fadf42efd8565de3bf72214154565ff841d6b24904e3f0e15c4f452a4d', '[\"*\"]', '2025-04-28 22:42:25', NULL, '2025-04-28 22:38:58', '2025-04-28 22:42:25'),
(285, 'App\\Models\\User', 6, 'auth_token', '334c3e1f73f793206a8940f0e3b715ba914c4109270cc1db0ec36e0ec7d86182', '[\"*\"]', '2025-04-28 23:22:16', NULL, '2025-04-28 23:09:57', '2025-04-28 23:22:16'),
(286, 'App\\Models\\User', 6, 'auth_token', '7e54ebd5f7af80636186ea5b9179d709732a44482fe542f94e6ff17f2ed3e0f7', '[\"*\"]', '2025-04-29 00:00:16', NULL, '2025-04-28 23:59:08', '2025-04-29 00:00:16'),
(287, 'App\\Models\\User', 6, 'auth_token', 'e6efac26cbc84d36ba4295f293426974dec28508c99d901d5847fba103358d8e', '[\"*\"]', '2025-04-29 00:11:49', NULL, '2025-04-29 00:03:09', '2025-04-29 00:11:49'),
(288, 'App\\Models\\User', 6, 'auth_token', '410f2e603bb7befa0e7cb4d1d03e7a1fa5da94c066223a20ab3dcb40d7719906', '[\"*\"]', '2025-04-29 00:25:46', NULL, '2025-04-29 00:15:29', '2025-04-29 00:25:46'),
(289, 'App\\Models\\User', 28, 'auth_token', '73f64426d09db3d7f7e2c1cddb7b4fe29a48e15f216950ab1984e228e4784afc', '[\"*\"]', NULL, NULL, '2025-04-29 00:31:52', '2025-04-29 00:31:52'),
(290, 'App\\Models\\User', 6, 'auth_token', '53eefa585165b4e7be04fa2e28b3e707c460a31f09f322598a22ddfb29897e64', '[\"*\"]', '2025-04-29 16:57:34', NULL, '2025-04-29 16:52:11', '2025-04-29 16:57:34'),
(291, 'App\\Models\\User', 6, 'auth_token', 'f84f9b61578d9a42160815dda337ecae3bb4476893503644e193d5c04216ffdf', '[\"*\"]', '2025-04-29 20:50:56', NULL, '2025-04-29 18:41:22', '2025-04-29 20:50:56'),
(292, 'App\\Models\\User', 4, 'auth_token', '43e5000c8c6c87f5badc486389f46cc7967eb80d77ae7523d0206b3eebc70ec2', '[\"*\"]', '2025-04-29 20:19:16', NULL, '2025-04-29 20:18:55', '2025-04-29 20:19:16'),
(293, 'App\\Models\\User', 3, 'auth_token', 'f1c4c2ede40ba1cea60138486f5ffd727936e423c2cdaafea2b51911bceaadfa', '[\"*\"]', '2025-04-30 00:11:53', NULL, '2025-04-29 20:51:10', '2025-04-30 00:11:53'),
(294, 'App\\Models\\User', 4, 'auth_token', 'b654ee88ea40155aee2e64bdbd0360a1dae042a95150c7d57f05c5b5f465d730', '[\"*\"]', NULL, NULL, '2025-04-29 21:05:33', '2025-04-29 21:05:33'),
(295, 'App\\Models\\User', 6, 'auth_token', '468c59b314e117a8369329676c9f6fc71cbafeec5716f4bedf89808b0096d142', '[\"*\"]', '2025-04-30 00:16:11', NULL, '2025-04-30 00:12:10', '2025-04-30 00:16:11'),
(296, 'App\\Models\\User', 1, 'auth_token', 'e768e84a612bb71b3bf40833292356288b02ec5173b32b696b7e2a4515804172', '[\"*\"]', '2025-04-30 00:28:13', NULL, '2025-04-30 00:18:50', '2025-04-30 00:28:13'),
(297, 'App\\Models\\User', 2, 'auth_token', '4b0e4e6379da5a34fe56a6cf86050db36623b354904be6541d6ad93680e4bec1', '[\"*\"]', '2025-04-30 00:26:29', NULL, '2025-04-30 00:23:41', '2025-04-30 00:26:29'),
(298, 'App\\Models\\User', 2, 'auth_token', '131a452c710deab22eb0e85980f7af19cb71f6ed5c088fab14dfeb403c6049df', '[\"*\"]', '2025-04-30 00:34:02', NULL, '2025-04-30 00:29:05', '2025-04-30 00:34:02'),
(299, 'App\\Models\\User', 1, 'auth_token', '185670a466b28dbda9edeb9137f4fd292c223052e497caa0e38aa32604105239', '[\"*\"]', '2025-04-30 17:53:42', NULL, '2025-04-30 00:29:49', '2025-04-30 17:53:42'),
(300, 'App\\Models\\User', 4, 'auth_token', '0ad8c6affaf58420f46fd72a5e17a6c8c9015ef5e5169d9c5021575ac2bc62a7', '[\"*\"]', '2025-04-30 17:56:38', NULL, '2025-04-30 17:55:52', '2025-04-30 17:56:38'),
(301, 'App\\Models\\User', 5, 'auth_token', 'ff9eef1b90282d06161c58eaec390fdaceaf08cfd41c572f5101d0768f9dea14', '[\"*\"]', NULL, NULL, '2025-04-30 17:57:31', '2025-04-30 17:57:31'),
(302, 'App\\Models\\User', 6, 'auth_token', 'e940b284b9b100ac311813c0aebffacd1c602878d997567d146e3f8a036603ab', '[\"*\"]', '2025-04-30 20:12:52', NULL, '2025-04-30 20:08:37', '2025-04-30 20:12:52'),
(303, 'App\\Models\\User', 5, 'auth_token', '293023ae969ca39163059e11daa85f7bef1ca5a020b35a6745f3c301cce54f8f', '[\"*\"]', NULL, NULL, '2025-04-30 20:13:22', '2025-04-30 20:13:22'),
(304, 'App\\Models\\User', 1, 'auth_token', '4e19e9ad8b31b2b580d3c8114f02ec0ac779c2e1f2038787ba7f2503e1283479', '[\"*\"]', '2025-04-30 20:36:46', NULL, '2025-04-30 20:17:21', '2025-04-30 20:36:46'),
(305, 'App\\Models\\User', 6, 'auth_token', '47fbc5913879e695f3c0ee1b87043eecbdf55b708ffc7128a831e70faeaf9d6f', '[\"*\"]', '2025-04-30 21:42:44', NULL, '2025-04-30 20:22:05', '2025-04-30 21:42:44'),
(306, 'App\\Models\\User', 5, 'auth_token', '9196123d4e5c8e8db4f0bf293ae8895b16490cc9a9eb274f45da212debd8d5f7', '[\"*\"]', '2025-04-30 20:40:36', NULL, '2025-04-30 20:37:45', '2025-04-30 20:40:36'),
(307, 'App\\Models\\User', 5, 'auth_token', '090c1605aea4a90a8e0fd9e3ca8b0f2acfca9b3b6ec2050e804522f66d5a49c9', '[\"*\"]', NULL, NULL, '2025-04-30 20:40:48', '2025-04-30 20:40:48'),
(308, 'App\\Models\\User', 5, 'auth_token', '2e1c7140a24e45af0206f101e2010c897cf3c2d0f993341d9251b0c1c2442da3', '[\"*\"]', '2025-05-02 17:17:10', NULL, '2025-04-30 20:42:22', '2025-05-02 17:17:10'),
(309, 'App\\Models\\User', 1, 'auth_token', '7dbaf0896ff4684f8ad793b67f60646e700b2d4563936793c1b0d3371afa01a8', '[\"*\"]', '2025-04-30 21:45:54', NULL, '2025-04-30 21:42:49', '2025-04-30 21:45:54'),
(310, 'App\\Models\\User', 1, 'auth_token', '66c136b4a7c504b28066fc3208e12e64d0a2d999881a4834ec5c5ac58535eccc', '[\"*\"]', '2025-05-14 00:18:03', NULL, '2025-04-30 21:59:54', '2025-05-14 00:18:03'),
(311, 'App\\Models\\User', 7, 'auth_token', '5f5376c0fdf2171786032f4ea6716f7238f21a2f2b7c12e95ac64ae0819a935d', '[\"*\"]', '2025-05-15 00:16:34', NULL, '2025-04-30 23:25:34', '2025-05-15 00:16:34'),
(312, 'App\\Models\\User', 8, 'auth_token', 'fd03609e9f110a7281c20c56368b8480a3ca57ddeba47ee98cfac2ecc5793614', '[\"*\"]', '2025-05-01 18:03:46', NULL, '2025-05-01 17:55:37', '2025-05-01 18:03:46'),
(313, 'App\\Models\\User', 5, 'auth_token', 'c9acee42d356cb78b5f3e8a1c14ef342c3b624a44766c5780627692e500234ca', '[\"*\"]', '2025-05-02 20:44:22', NULL, '2025-05-02 16:27:20', '2025-05-02 20:44:22'),
(314, 'App\\Models\\User', 1, 'auth_token', '27b0fede3a5807d218b38c130227dee0ad78feff761ae45603f1b238f09d1c00', '[\"*\"]', '2025-05-02 18:10:00', NULL, '2025-05-02 17:26:31', '2025-05-02 18:10:00'),
(315, 'App\\Models\\User', 1, 'auth_token', 'ac4fc2507448adc9bf61715b43e48138ce579cd7f9ccd8e40668741d0b9f2459', '[\"*\"]', '2025-05-02 19:46:53', NULL, '2025-05-02 18:09:45', '2025-05-02 19:46:53'),
(316, 'App\\Models\\User', 5, 'auth_token', '00f950b8b3d48a2a8bf9478476f9bf49239ce75958dba3977de9e30bfd9500f1', '[\"*\"]', '2025-05-02 20:22:27', NULL, '2025-05-02 19:47:08', '2025-05-02 20:22:27'),
(317, 'App\\Models\\User', 9, 'auth_token', '006304043e206c9f7fc291ae79d1078b397653ae67fa7f5023ea3d7826a3e98b', '[\"*\"]', NULL, NULL, '2025-05-02 20:23:43', '2025-05-02 20:23:43'),
(318, 'App\\Models\\User', 1, 'auth_token', '9c53a3713a4129f0afa511a3140f66ff265ef65983ea276e0263db15663d51d6', '[\"*\"]', '2025-05-02 20:40:09', NULL, '2025-05-02 20:25:51', '2025-05-02 20:40:09'),
(319, 'App\\Models\\User', 5, 'auth_token', '79a845ec539c070121685884168ef4dbc40ea1205a2341918060386b618179da', '[\"*\"]', '2025-05-02 20:53:50', NULL, '2025-05-02 20:40:28', '2025-05-02 20:53:50'),
(320, 'App\\Models\\User', 1, 'auth_token', '43ca5ede6840abcd15fbfc92f45ec656c048e746fd0ada72c5050e8a841a7b99', '[\"*\"]', '2025-05-05 03:27:45', NULL, '2025-05-02 21:00:57', '2025-05-05 03:27:45'),
(321, 'App\\Models\\User', 5, 'auth_token', 'a88de77e19b2a90952064a2d63c7c28c23eadaa310054017aa58e506153f8a5b', '[\"*\"]', '2025-05-13 04:40:51', NULL, '2025-05-05 03:27:58', '2025-05-13 04:40:51'),
(322, 'App\\Models\\User', 10, 'auth_token', '068c3b1404ad1f3284b0db38fa0883e724154156a5dc9e19cb64d0a378441422', '[\"*\"]', '2025-05-13 17:17:56', NULL, '2025-05-13 16:27:56', '2025-05-13 17:17:56'),
(323, 'App\\Models\\User', 5, 'auth_token', 'd104751e5cdf2e25dff85c4090944423aa703fe1c5562e6f73e0812cdfd49150', '[\"*\"]', '2025-05-13 21:49:55', NULL, '2025-05-13 16:42:18', '2025-05-13 21:49:55'),
(324, 'App\\Models\\User', 10, 'auth_token', '34e6761bd0f25ff92193b403d7289d016fb7d3d4717dc364f9bbf744545afdd3', '[\"*\"]', '2025-05-13 17:33:54', NULL, '2025-05-13 17:25:13', '2025-05-13 17:33:54'),
(325, 'App\\Models\\User', 10, 'auth_token', '078a7578d91c6af6f03de9955e8ad54b71c3b586c223e073992291ae5c236620', '[\"*\"]', '2025-05-13 18:06:38', NULL, '2025-05-13 17:44:50', '2025-05-13 18:06:38'),
(326, 'App\\Models\\User', 11, 'auth_token', '05933582edc4945cad65590875c445cf66fce70ae8b48aa0e9472680ae18bc20', '[\"*\"]', '2025-05-13 18:55:29', NULL, '2025-05-13 18:49:48', '2025-05-13 18:55:29'),
(327, 'App\\Models\\User', 10, 'auth_token', 'b61655a73d2f5c04664fd6d4a2ce2756ce43978acadab2484283f9a7901a2c45', '[\"*\"]', '2025-05-13 21:09:13', NULL, '2025-05-13 19:01:29', '2025-05-13 21:09:13'),
(328, 'App\\Models\\User', 5, 'auth_token', '99a34627ed417591cffd381e6107796c82af725fc2a1f7887c7c5f4ccef39ad3', '[\"*\"]', NULL, NULL, '2025-05-13 19:14:58', '2025-05-13 19:14:58'),
(329, 'App\\Models\\User', 5, 'auth_token', 'b3c8d2bead8a38a06d53e7f1384c2dfa371b0d1e84196fe9262dd1b59f49bc5c', '[\"*\"]', NULL, NULL, '2025-05-13 19:15:00', '2025-05-13 19:15:00'),
(330, 'App\\Models\\User', 5, 'auth_token', 'fb54eceba701b9273f9ad68e27c4755bf9afdbd19d31e1cb6853842b20403c0b', '[\"*\"]', NULL, NULL, '2025-05-13 19:15:02', '2025-05-13 19:15:02'),
(331, 'App\\Models\\User', 10, 'auth_token', '3acb25f4f5f7581dc547c5717c8bfd0a78caf9e061b125d06ae3187fc71a2101', '[\"*\"]', '2025-05-26 20:29:28', NULL, '2025-05-13 21:16:07', '2025-05-26 20:29:28'),
(332, 'App\\Models\\User', 5, 'auth_token', '66494e568c4448d47ce3181f1ede71f63962bf259c6f39d22b791dccee073f62', '[\"*\"]', '2025-05-20 17:14:06', NULL, '2025-05-14 00:37:20', '2025-05-20 17:14:06'),
(333, 'App\\Models\\User', 5, 'auth_token', '699f2fed2ee36fd0e60d651019bbc0484590f8e8fc8a2c31d1edf10eeeabc5f6', '[\"*\"]', '2025-05-26 20:15:11', NULL, '2025-05-26 18:51:19', '2025-05-26 20:15:11'),
(334, 'App\\Models\\User', 5, 'auth_token', '97a424260e3164973700ba2daef6ccede630182cca7dbd8ad74a1c80d3b9f704', '[\"*\"]', '2025-05-26 18:53:31', NULL, '2025-05-26 18:53:04', '2025-05-26 18:53:31'),
(335, 'App\\Models\\User', 5, 'auth_token', 'e6b2262c97a19f6d08b13493397b79499bb6f87d7481a3038ba18e7289f3e384', '[\"*\"]', NULL, NULL, '2025-05-26 19:11:40', '2025-05-26 19:11:40'),
(336, 'App\\Models\\User', 5, 'auth_token', 'e08795a9d4fbb95ccd1679653e4576370c633a7fc40b0abd791cd60fb363dd6b', '[\"*\"]', '2025-05-26 20:27:49', NULL, '2025-05-26 19:11:54', '2025-05-26 20:27:49'),
(337, 'App\\Models\\User', 5, 'auth_token', '31731aa1961fba3d714a41fb32dcf9234cc36c5bb111e68d1717c40ef0dadf70', '[\"*\"]', '2025-05-26 19:37:58', NULL, '2025-05-26 19:32:47', '2025-05-26 19:37:58'),
(338, 'App\\Models\\User', 10, 'auth_token', '7246f78a454b15bc135ae0f0440176ae86da9c8a526c3c784f124dbb6ccc45b7', '[\"*\"]', '2025-05-26 22:41:43', NULL, '2025-05-26 21:13:43', '2025-05-26 22:41:43'),
(339, 'App\\Models\\User', 10, 'auth_token', 'f6d4213d19c94547c288ce299b9ebbcc860bdcc5b9bc528a6ee853de1034357f', '[\"*\"]', '2025-05-26 21:35:58', NULL, '2025-05-26 21:35:49', '2025-05-26 21:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `share` tinyint(4) NOT NULL DEFAULT 0,
  `share_count` tinyint(4) NOT NULL DEFAULT 0,
  `share_person` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `hide`, `user_id`, `name`, `description`, `content`, `share`, `share_count`, `share_person`, `created_at`, `updated_at`) VALUES
(4, 1, 1, NULL, NULL, 'user testing', 0, 1, NULL, '2025-04-30 00:23:26', '2025-04-30 20:10:41'),
(5, 1, 1, NULL, NULL, 'visionaries', 0, 0, NULL, '2025-04-30 01:16:09', '2025-04-30 01:16:09'),
(6, 1, 1, NULL, NULL, 'New Therapist', 0, 0, NULL, '2025-04-30 16:26:19', '2025-04-30 16:26:19'),
(7, 1, 6, NULL, NULL, 'user testing', 1, 0, 'User Testing', '2025-04-30 20:10:41', '2025-04-30 20:10:41'),
(8, 1, 1, NULL, NULL, 'os 15', 0, 0, NULL, '2025-04-30 20:36:27', '2025-04-30 20:36:27'),
(9, 1, 5, NULL, NULL, 'New Tester', 0, 0, NULL, '2025-04-30 20:42:48', '2025-04-30 20:42:48'),
(10, 1, 7, NULL, NULL, 'this app sucks', 0, 0, NULL, '2025-04-30 23:26:16', '2025-04-30 23:26:16'),
(11, 0, 8, NULL, NULL, 'I been feeling terrible lately about my mental health', 0, 2, NULL, '2025-05-01 18:03:15', '2025-05-05 03:27:06'),
(12, 1, 1, NULL, NULL, 'I been feeling terrible lately about my mental health', 1, 0, 'john smith', '2025-05-05 03:26:27', '2025-05-05 03:26:27'),
(13, 1, 5, NULL, NULL, 'ok', 0, 0, NULL, '2025-05-05 05:30:19', '2025-05-05 05:30:19'),
(14, 1, 7, NULL, NULL, 'al is the man', 0, 0, NULL, '2025-05-12 23:27:09', '2025-05-12 23:27:09'),
(15, 1, 11, NULL, NULL, 'testing', 0, 0, NULL, '2025-05-13 18:55:01', '2025-05-13 18:55:01'),
(16, 1, 10, NULL, NULL, 'testing', 0, 0, NULL, '2025-05-13 19:07:14', '2025-05-13 19:07:14'),
(17, 1, 5, NULL, NULL, 'testing. without image', 0, 0, NULL, '2025-05-13 21:35:53', '2025-05-13 21:35:53'),
(18, 1, 1, NULL, NULL, 'test 1', 0, 0, NULL, '2025-05-14 00:17:34', '2025-05-14 00:17:34'),
(19, 1, 1, NULL, NULL, 'photo upload test', 0, 0, NULL, '2025-05-14 00:18:02', '2025-05-14 00:18:02'),
(20, 1, 7, NULL, NULL, 'let\'s make this a success', 0, 0, NULL, '2025-05-14 01:04:30', '2025-05-14 01:04:30'),
(21, 1, 7, NULL, NULL, 'where does this go?', 0, 0, NULL, '2025-05-14 01:06:14', '2025-05-14 01:06:14'),
(22, 1, 7, NULL, NULL, 'he wants chips', 0, 0, NULL, '2025-05-14 01:06:50', '2025-05-14 01:06:50'),
(23, 1, 7, NULL, NULL, 'if i post it deletes the next?', 0, 0, NULL, '2025-05-14 01:07:20', '2025-05-14 01:07:20'),
(24, 1, 5, NULL, NULL, 'test', 0, 0, NULL, '2025-05-14 03:05:02', '2025-05-14 03:05:02'),
(25, 1, 7, NULL, NULL, 'I feel like I through away a lot of money on this bullshit app.', 0, 0, NULL, '2025-05-14 23:36:22', '2025-05-14 23:36:22'),
(26, 1, 10, NULL, NULL, 'yxdyxhhxhxhxhhchchcpfypxhchchchchxxhxhxhoxhxhchchchkchchchchchchh hchchchchchchchchchchchchchchchclchchchcjcc', 0, 0, NULL, '2025-05-26 18:29:58', '2025-05-26 18:29:58'),
(27, 1, 10, NULL, NULL, 'hshshdhdhhdhshshsh', 0, 0, NULL, '2025-05-26 18:37:10', '2025-05-26 18:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `professional_earnings`
--

CREATE TABLE `professional_earnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `professional_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `earning_amount` decimal(8,2) NOT NULL,
  `earning_date` date NOT NULL,
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `professional_earnings`
--

INSERT INTO `professional_earnings` (`id`, `professional_id`, `user_id`, `booking_id`, `earning_amount`, `earning_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 2, 100.00, '2025-04-30', 'pending', '2025-04-30 00:33:22', '2025-04-30 00:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `professional_profiles`
--

CREATE TABLE `professional_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `professional_field` varchar(255) DEFAULT NULL,
  `education_degrees` varchar(255) DEFAULT NULL,
  `certifications` varchar(255) DEFAULT NULL,
  `credentials` varchar(255) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `practice` varchar(1000) DEFAULT NULL,
  `hour_rate` int(11) DEFAULT NULL,
  `languages` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `professional_profiles`
--

INSERT INTO `professional_profiles` (`id`, `user_id`, `professional_field`, `education_degrees`, `certifications`, `credentials`, `skills`, `practice`, `hour_rate`, `languages`, `website`, `about`, `created_at`, `updated_at`) VALUES
(1, 2, 'Therapist', 'PHD', 'nanny', '1745972789_2.jpg', '[\"child care\"]', '[\"child care\"]', 100, '[\"English\"]', 'https://jshs.com', 'lorem spum', '2025-04-30 00:26:27', '2025-04-30 00:26:29'),
(2, 5, 'Cartaker', 'Bachelors', 'Daycare', '1746045636_5.jpg', '[\"child care\"]', '[\"child care\"]', 58, '[\"Arabic\"]', 'https://gyhsg.com', 'poiyshsh', '2025-04-30 20:40:34', '2025-04-30 20:40:36');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator role', '2024-11-30 19:50:02', '2024-11-30 19:50:02'),
(2, 'seller', 'Seller role', '2024-11-30 19:50:02', '2024-11-30 19:50:02'),
(3, 'buyer', 'Buyer role', '2024-11-30 19:50:02', '2024-11-30 19:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(31, 2, 2, '2024-12-01 04:41:57', '2024-12-01 04:41:57'),
(32, 2, 3, '2024-12-01 04:41:57', '2024-12-01 04:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('caregiver','professional','admin') DEFAULT 'caregiver',
  `phone` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state_city` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `cover_image` text DEFAULT NULL,
  `login_status` enum('pending','approve','reject','block') NOT NULL DEFAULT 'pending',
  `fcm_token` varchar(1000) DEFAULT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `country`, `state_city`, `zip`, `age`, `image`, `cover_image`, `login_status`, `fcm_token`, `reset_password_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'User', 'Testing', 'user@gmail.com', NULL, '$2y$10$DI8w2oVXEYhClsKiSatvF.UJMHRqFukwH2htriiYKxEOOFbD.kTV.', 'caregiver', '+131214548', NULL, NULL, '12345', NULL, '1745972587_1_profile.jpg', NULL, 'approve', 'f46VelftQwOOnk0DDru3Dz:APA91bGlFlaaFjSE6pQXHWRd0CgupMIyZmh1lZY8rGzdxpuBwcruzUIn_B4Oq1fSWKWAGSHqsOca1IOXN19hhAN9HCjrFwiUD_Z28loHrn8BBQ_ofCB-kxQ', NULL, NULL, '2025-04-30 00:18:31', '2025-05-14 00:11:09'),
(2, 'developer', 'developer', 'therapist@gmail.com', NULL, '$2y$10$oAmL/k1FAjQ8Xxg8HSSljegiDi0wDHhbVvLcZz/MaMndflDkLNBtS', 'professional', '+11212121212', NULL, NULL, '12345', 24, '1745972789_2.jpg', NULL, 'approve', 'dAD7JZ1tSYuLxnQDtDOum-:APA91bGXUugknzCecQVbMkgiqaTcmw9xh06ycJPcwIlLtAe0IT7Lg83HxSAdaTNzksnaejqBE6R7O2rcvJ-bjZzAT112MH1S8bAB1DkcDRJ9Sq-UBDtRVkE', NULL, NULL, '2025-04-30 00:23:28', '2025-04-30 00:28:46'),
(3, 'Admin', 'ilong', 'admin@gmail.com', NULL, '$2y$10$mVGIGdxk9ryP7GobfAqAMOo4MN9.Bzs0QUFAByWzxdhwmkrX99Ez2', 'admin', '+11212121212', NULL, NULL, '12345', 24, '1745972789_2.jpg', NULL, 'pending', 'dAD7JZ1tSYuLxnQDtDOum-:APA91bGXUugknzCecQVbMkgiqaTcmw9xh06ycJPcwIlLtAe0IT7Lg83HxSAdaTNzksnaejqBE6R7O2rcvJ-bjZzAT112MH1S8bAB1DkcDRJ9Sq-UBDtRVkE', NULL, NULL, '2025-04-30 00:23:28', '2025-04-30 00:26:29'),
(5, 'Professional', 'Therapist', 'somer0801@gmail.com', NULL, '$2y$10$wbIvh0tijiRDbybYGLz.yeUyR7vVmijznHtN95q5hfES9UKGzKD9O', 'professional', NULL, NULL, NULL, NULL, 35, '1746045636_5.jpg', '1746051589_5_cover.jpg', 'approve', 'eULlR4hXhEizhnUb3mp_Kq:APA91bEyVOkVMyav4B-h5UZONizxbn0k64Y6-fO5TP4gnr3HiY9Z15apy9-9lnaiWALc9V8rReaJNhXJ77hvnplYuzfZnpJeQ0XnFdcOsT3C_-eVkOMHc1JimuZZXIoS0eU7h-VU1wTd', NULL, NULL, '2025-04-30 17:57:20', '2025-05-26 18:51:19'),
(6, 'Website', 'Visionaries', 'websitevisionaries.com@gmail.com', NULL, '$2y$10$CCHCjiViO7os9BjF7ppUGe7cvyfdRKqUdIeUSaGzUHNjDV1Jc8yZC', 'caregiver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'approve', 'eTKdzgNGQRC7w8DH6S3YWZ:APA91bEt8z5AK9Bk2_1OkIyuewMLIpcRr7AceqXXo_KezGhT9eOI-lYYb6g-irPKW31sj57nv3tkb_TSIQSwtWss2x-XyeXNawkzbIXPCSkur8IalaSRe-c', NULL, NULL, '2025-04-30 20:08:21', '2025-04-30 20:22:05'),
(7, 'deez', 'nuts', 'tornezing@gmail.com', NULL, '$2y$10$8ISJZkpqrwEl3LruybWbv.6JSZdRzWKEzpcZQUYgar53whht.yfM.', 'caregiver', '+17185012103', NULL, NULL, '07747', NULL, '1747266562_7_profile.jpg', '1747266562_7_cover.jpg', 'approve', 'c83snYqVQQqRoSwFD_ogud:APA91bEF9EXJehq5YtYLZdImtdPfhEC_b9-o8XuNU946AE3e3gijIajsYG6CG9lo0RVHcCKCPXvy6HmoXsg0wQIBImLSkrCFkzTB2y9cA-4b1ZnFIt3QIhk', NULL, NULL, '2025-04-30 23:24:59', '2025-05-14 23:49:22'),
(8, 'john', 'smith', 'johnsmith30397@gmail.com', NULL, '$2y$10$gy0MpHb8VRZf2Cgeh.NtUuMajeuNOPZ7oGrWkVeQNkj6GbsnqTYdK', 'caregiver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'approve', 'ceKMn8XyQNCxEePLFnZjX9:APA91bEOPEv9KG-VR-ENeSlHIyUxCj1ayHddTJvSCoG1gu94Dt_rDM0tCpR5I7LKkyKUNEf3xOZGOjq8tH3SfF5a2jOex4mS06cPFiCf_jYQDCHcfm1DqmM', NULL, NULL, '2025-05-01 17:54:50', '2025-05-01 17:55:37'),
(9, 'New', 'Professional', 'newprofessional@gmail.com', NULL, '$2y$10$tvlA3rgH09dus/IhoYHPZOgCljKaL4L5TCeOudRIYw0Z0r2y6EO6S', 'professional', '+132154678', NULL, NULL, '12345', NULL, NULL, NULL, 'pending', 'fR2Ec76wQ8eIScliT_PTf8:APA91bET3fkwbvXUog6v72Y4Lyk7wpXcL1POPzkB2ySp55K-n3Ai5hO-qp1uRGwILHzJXyIAe6f4BHqCPQ9jv15FV_h2BGnt2aWbreS6LKgnw3OLQN9_KDU', NULL, NULL, '2025-05-02 20:23:33', '2025-05-02 20:23:43'),
(10, 'Pyro', 'Bytes', 'pyrobytesdeveloper@gmail.com', NULL, '$2y$10$XUm/iIwmGDlyPmT0AfOEeuygp8fzM5PiTEd0yIg81a2c3cktvpipy', 'caregiver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'approve', 'eULlR4hXhEizhnUb3mp_Kq:APA91bEyVOkVMyav4B-h5UZONizxbn0k64Y6-fO5TP4gnr3HiY9Z15apy9-9lnaiWALc9V8rReaJNhXJ77hvnplYuzfZnpJeQ0XnFdcOsT3C_-eVkOMHc1JimuZZXIoS0eU7h-VU1wTd', NULL, NULL, '2025-05-13 16:27:43', '2025-05-26 21:35:49'),
(11, 'Thomas', 'Bendyk', 'Thomas.bendyk@pyrobytes.com', NULL, '$2y$10$t5.vzg/4CUZfE4SVQmBUee8D.F/LtpYDArYzDmiPr4f3j3gTzd59y', 'caregiver', '+12134845484', NULL, NULL, '80008', NULL, NULL, NULL, 'approve', 'fab1EJsIST2YrMUyV1ix0e:APA91bFR1S9t39me6GyeuQ4iLZ1sEEmf7n6F3IKd15hFXFaBXeoiONvhdX_hnr4vwDJXTKV0OUKRH_tYwKZCUnpqvBhs8AKCWwyD5jgfUJX6nNhLs8J7U_4', NULL, NULL, '2025-05-13 18:49:17', '2025-05-13 18:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_videos`
--

CREATE TABLE `user_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `video` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_videos`
--

INSERT INTO `user_videos` (`id`, `user_id`, `video`, `description`, `created_at`, `updated_at`) VALUES
(1, 10, '1747184040.mp4', 'dhduududuxux', '2025-05-14 00:54:00', '2025-05-14 00:54:00'),
(2, 5, '1747184088.mp4', 'somer0801@gmail.com', '2025-05-14 00:54:48', '2025-05-26 19:33:26'),
(4, 10, '1748295160.mp4', 'hccucucuch cucuc', '2025-05-26 21:32:40', '2025-05-26 21:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `video_comments`
--

CREATE TABLE `video_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `video_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_likes`
--

CREATE TABLE `video_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `video_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_likes`
--

INSERT INTO `video_likes` (`id`, `user_id`, `video_id`, `created_at`, `updated_at`) VALUES
(1, 10, 1, '2025-05-14 00:54:33', '2025-05-14 00:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `zoom_meetings`
--

CREATE TABLE `zoom_meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meeting_id` varchar(255) NOT NULL,
  `host_id` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duration` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `start_url` varchar(1024) NOT NULL,
  `join_url` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `professional_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `availability_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zoom_meetings`
--

INSERT INTO `zoom_meetings` (`id`, `meeting_id`, `host_id`, `topic`, `start_time`, `duration`, `password`, `start_url`, `join_url`, `status`, `professional_id`, `user_id`, `availability_id`, `created_at`, `updated_at`, `booking_id`) VALUES
(1, '86007308397', 'x1x103KiRjGSoh1uLiPyqQ', 'Topic -  Therapist', '2025-05-01 00:30:00', 60, 'dJBK6G', 'https://us05web.zoom.us/s/86007308397?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMiIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJpc3MiOiJ3ZWIiLCJjbHQiOjAsIm1udW0iOiI4NjAwNzMwODM5NyIsImF1ZCI6ImNsaWVudHNtIiwidWlkIjoieDF4MTAzS2lSakdTb2gxdUxpUHlxUSIsInppZCI6ImEyYTNiZmMyODE2MjRmZDI4YTcxNWFhYzIzMjM1NTA5Iiwic2siOiIwIiwic3R5IjoxLCJ3Y2QiOiJ1czA1IiwiZXhwIjoxNzQ1OTgwMjY1LCJpYXQiOjE3NDU5NzMwNjUsImFpZCI6ImxWT0FTb2N4VDJTTGdKVEsxZ2RaUFEiLCJjaWQiOiIifQ.IzQ_EzdgQSyNHavM6akUNCjD0Iy4_PJa88UzJt-3wlk', 'https://us05web.zoom.us/j/86007308397?pwd=aZLAtiW28tb2GVgSTleywJzY1bfOw0.1', 'waiting', 2, 1, 1, '2025-04-30 00:31:05', '2025-04-30 00:31:05', 1),
(2, '82897947291', 'x1x103KiRjGSoh1uLiPyqQ', 'Topic -  lorem ipsum', '2025-05-02 00:30:00', 60, 'Z859uy', 'https://us05web.zoom.us/s/82897947291?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMiIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJpc3MiOiJ3ZWIiLCJjbHQiOjAsIm1udW0iOiI4Mjg5Nzk0NzI5MSIsImF1ZCI6ImNsaWVudHNtIiwidWlkIjoieDF4MTAzS2lSakdTb2gxdUxpUHlxUSIsInppZCI6ImE5ZjFjMTk5ZDY0MTRmN2ZhMTE5MzhkYzA1YjIzZGQyIiwic2siOiIwIiwic3R5IjoxLCJ3Y2QiOiJ1czA1IiwiZXhwIjoxNzQ1OTgwMzMzLCJpYXQiOjE3NDU5NzMxMzMsImFpZCI6ImxWT0FTb2N4VDJTTGdKVEsxZ2RaUFEiLCJjaWQiOiIifQ.IX5kLYz-zO4h3CTx2lKG3ZWpqING2yNxgAB7FX1rueY', 'https://us05web.zoom.us/j/82897947291?pwd=Dzt5m0cfF7k6wB9cq4IRuYgKbREbPK.1', 'waiting', 2, 1, 2, '2025-04-30 00:32:13', '2025-04-30 00:32:13', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `availabilities`
--
ALTER TABLE `availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `availabilities_user_id_foreign` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `childrens`
--
ALTER TABLE `childrens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `childrens_caregiver_id_foreign` (`caregiver_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_post_comments`
--
ALTER TABLE `content_post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_post_comments_user_id_foreign` (`user_id`),
  ADD KEY `content_post_comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `content_post_likes`
--
ALTER TABLE `content_post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_post_likes_user_id_foreign` (`user_id`),
  ADD KEY `content_post_likes_post_id_foreign` (`post_id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiences_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `follows_follower_id_following_id_unique` (`follower_id`,`following_id`),
  ADD KEY `follows_following_id_foreign` (`following_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_creator_id_foreign` (`creator_id`);

--
-- Indexes for table `group_posts`
--
ALTER TABLE `group_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_posts_group_id_foreign` (`group_id`),
  ADD KEY `group_posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_user_group_id_foreign` (`group_id`),
  ADD KEY `group_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_post_id_foreign` (`post_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiries_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `licenses_user_id_foreign` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_post_id_foreign` (`post_id`),
  ADD KEY `likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_professional_id_foreign` (`professional_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `professional_earnings`
--
ALTER TABLE `professional_earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professional_earnings_professional_id_foreign` (`professional_id`);

--
-- Indexes for table `professional_profiles`
--
ALTER TABLE `professional_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professional_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_roles_user_id_role_id_unique` (`user_id`,`role_id`),
  ADD KEY `user_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_videos`
--
ALTER TABLE `user_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_videos_user_id_foreign` (`user_id`);

--
-- Indexes for table `video_comments`
--
ALTER TABLE `video_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_comments_user_id_foreign` (`user_id`),
  ADD KEY `video_comments_video_id_foreign` (`video_id`);

--
-- Indexes for table `video_likes`
--
ALTER TABLE `video_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `video_likes_user_id_video_id_unique` (`user_id`,`video_id`),
  ADD KEY `video_likes_video_id_foreign` (`video_id`);

--
-- Indexes for table `zoom_meetings`
--
ALTER TABLE `zoom_meetings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `zoom_meetings_meeting_id_unique` (`meeting_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `childrens`
--
ALTER TABLE `childrens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `content_post_comments`
--
ALTER TABLE `content_post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `content_post_likes`
--
ALTER TABLE `content_post_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group_posts`
--
ALTER TABLE `group_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `group_user`
--
ALTER TABLE `group_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=340;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `professional_earnings`
--
ALTER TABLE `professional_earnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `professional_profiles`
--
ALTER TABLE `professional_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_videos`
--
ALTER TABLE `user_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `video_comments`
--
ALTER TABLE `video_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_likes`
--
ALTER TABLE `video_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zoom_meetings`
--
ALTER TABLE `zoom_meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availabilities`
--
ALTER TABLE `availabilities`
  ADD CONSTRAINT `availabilities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `childrens`
--
ALTER TABLE `childrens`
  ADD CONSTRAINT `childrens_caregiver_id_foreign` FOREIGN KEY (`caregiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `group_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `content_post_comments`
--
ALTER TABLE `content_post_comments`
  ADD CONSTRAINT `content_post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `content_post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `content_post_likes`
--
ALTER TABLE `content_post_likes`
  ADD CONSTRAINT `content_post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `content_post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_posts`
--
ALTER TABLE `group_posts`
  ADD CONSTRAINT `group_posts_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `licenses`
--
ALTER TABLE `licenses`
  ADD CONSTRAINT `licenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `group_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_professional_id_foreign` FOREIGN KEY (`professional_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `professional_earnings`
--
ALTER TABLE `professional_earnings`
  ADD CONSTRAINT `professional_earnings_professional_id_foreign` FOREIGN KEY (`professional_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `professional_profiles`
--
ALTER TABLE `professional_profiles`
  ADD CONSTRAINT `professional_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_videos`
--
ALTER TABLE `user_videos`
  ADD CONSTRAINT `user_videos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_comments`
--
ALTER TABLE `video_comments`
  ADD CONSTRAINT `video_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `video_comments_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `user_videos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_likes`
--
ALTER TABLE `video_likes`
  ADD CONSTRAINT `video_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `video_likes_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `user_videos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
