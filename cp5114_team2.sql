-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 28, 2025 at 07:06 AM
-- Server version: 10.3.39-MariaDB-log
-- PHP Version: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cp5114_team2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
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
(1, '2025_03_19_201302_create_users_table', 1),
(2, '2025_03_19_201415_create_properties_table', 1),
(3, '2025_03_19_201431_create_property_images_table', 1),
(4, '2025_03_21_193915_create_sessions_table', 1),
(5, '2025_03_21_195714_create_cache_table', 1),
(6, '2025_03_27_041824_create_image_property', 2);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `propertyId` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postalCode` varchar(255) NOT NULL,
  `latitude` decimal(9,6) NOT NULL,
  `longitude` decimal(9,6) NOT NULL,
  `ownerId` bigint(20) UNSIGNED DEFAULT NULL,
  `agentId` bigint(20) UNSIGNED NOT NULL,
  `isSold` tinyint(1) NOT NULL DEFAULT 0,
  `propertyType` enum('House','Condo','Cottage','Multiplex') NOT NULL,
  `floors` int(11) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `squareFootage` decimal(10,2) NOT NULL,
  `yearBuilt` int(11) NOT NULL,
  `isGarage` tinyint(1) NOT NULL DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`propertyId`, `title`, `description`, `price`, `address`, `city`, `province`, `postalCode`, `latitude`, `longitude`, `ownerId`, `agentId`, `isSold`, `propertyType`, `floors`, `bedrooms`, `bathrooms`, `squareFootage`, `yearBuilt`, `isGarage`, `createdAt`) VALUES
(7, 'Bad house in Suburbs', 'This is the house I grew up in since I was a child. I only lived in this one house my whole life. It very big and spacious with lots of windows and situated in a nice suburban neighborhood.', 850000.50, '385 Av Cedar', 'Dorval', 'QC', 'J0D 3U2', 45.446847, -73.760302, 4, 34, 0, 'House', 3, 4, 3, 3000.00, 2002, 1, '2025-03-26 19:32:55'),
(14, 'Cottage at Tremblant', 'This is a nice cottage near Mont-Tremblant. In the forest.', 600000.00, '876 Tremblant Ave', 'Mt-Tremblant', 'QC', 'D1L 1E1', 46.118600, -74.596200, 4, 34, 0, 'Cottage', 3, 4, 3, 2000.00, 2015, 1, '2025-03-28 01:47:23'),
(15, 'Small house in lower Westmount', 'This is a nice small house in lower Westmount near Atwater. Perfect location for a young couple with one or two children.', 900000.00, '1336 Greene Ave', 'Westmount', 'QC', 'H3Z 2B1', 45.501900, -73.567400, 4, 34, 0, 'House', 2, 3, 2, 200.00, 2016, 1, '2025-03-28 02:13:54'),
(20, 'Spacious Condo', 'Located in the prestigious Golden Mile', 525000.00, '1280 Rue Sherbrooke Ouest', 'Montreal', 'QC', 'H3G 3K4', 45.498000, -73.579000, 40, 26, 0, 'Condo', 1, 1, 1, 1600.00, 2020, 1, '2025-03-28 02:41:09'),
(21, 'Roxboro Multiplex', 'Roxboro multiplex for sale', 1000000.00, '123 Roxboro Avenue', 'Roxboro', 'Quebec', 'H8Y 1A1', 45.515145, -73.815753, 21, 34, 0, 'Multiplex', 4, 8, 4, 4000.00, 1995, 1, '2025-03-28 02:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `imageId` bigint(20) UNSIGNED NOT NULL,
  `propertyId` bigint(20) UNSIGNED NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `isMain` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`imageId`, `propertyId`, `imagePath`, `isMain`) VALUES
(1, 7, 'property_images/1743049765_7.jpg', 0),
(4, 7, 'property_images/1743087195_7.jpg', 0),
(6, 7, 'property_images/1743088283_7.jpg', 0),
(7, 7, 'property_images/1743089137_7.jpg', 0),
(9, 7, 'property_images/1743114604_7.jpg', 0),
(11, 14, 'property_images/1743126469_14.png', 0),
(13, 15, 'property_images/1743128051_15.jpg', 0),
(14, 20, 'property_images/1743129757_20.jpg', 0),
(16, 21, 'property_images/1743130338_21.jpg', 0),
(17, 7, 'property_images/1743167302_7.jpg', 0),
(18, 7, 'property_images/1743167329_7.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0ny5hKXKo0QAmeXBkBkoCZZVotg5JNEnPE8NV7wD', NULL, '167.71.241.125', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkJHUloxMTVBSU1pUEZacWxzZGt0NzE2b0Y3MDM1MkhVZUJLd2tpYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly93d3cudGVhbTIuZnNkMTMuY2EiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1743165979),
('3CqjByRIv6MheL9qzOKRnF0Ri9Ci1cugjzyi6Miz', NULL, '24.202.240.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRUwyRmdqNW91U2Jhd2lzNnJsMWVKSkJ0bENlRFZXbHZQanBqZTc3SyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vdGVhbTIuZnNkMTMuY2EvbG9naW4iO319', 1743168039),
('453YFlwqCbdVWMqEuW1zeQqTkcyf8VF7KnQNVaGd', NULL, '24.202.240.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWW8wSU1hcmlrZjBPbmM2czFzQUhadnlmTEtpQ1FPWUxkcXB3c3g4TSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vdGVhbTIuZnNkMTMuY2EvbG9naW4iO319', 1743168664),
('hFILd55nITj4iKTwxV64e3YownfY50XQEB4rR5YN', NULL, '24.202.240.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieUliRzJLNlE2VDhwSzNzbWVIb1ZKZUJERnh4eWV2QXBKT0tJbUpoWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vdGVhbTIuZnNkMTMuY2EvbG9naW4iO319', 1743167929),
('i6H8pWxhGNk9reGop8c6JUVXtsHElJWRTT2uts8O', NULL, '167.71.241.125', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2Nsd1NkSXRJQm9mdkpENXk1eE5EQzIyQXZlVDVONHJBREdxVXgxYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vd3d3LnRlYW0yLmZzZDEzLmNhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1743165980),
('mMFd8CHd8tnyDcaVO2kJdwwxoFmvYUJFfIcO6H1c', NULL, '70.31.255.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkszd2E0SzYweUdCbmJ6U2FURXBJTXVQV09qRGJMWGhaaENmNTVtZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vdGVhbTIuZnNkMTMuY2EvbG9naW4iO319', 1743168598),
('NxdAqFbic4S5OlMpmu7cEdwgxScc5RaYcHlvaTbu', NULL, '70.31.255.116', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.1 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTE5XZDFYNDBJT1VjWVpZV1l6YVRSU3k3N0pTZzZON2FRY1ZNbWIwQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly90ZWFtMi5mc2QxMy5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1743164901),
('pwPIpK1TmIcxuMapMUUqok6MI33qzXoRwlvMJUxH', 40, '184.163.10.55', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS3o3eVdJZ1JFR2RFSnh6dWNGNk9qcmhBcTlkTmZLM2trWEp5NVVRdyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM4OiJodHRwczovL3RlYW0yLmZzZDEzLmNhL2NyZWF0ZS1wcm9wZXJ0eSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQwO30=', 1743162160),
('RU7UBHgZgyq2kKUw9xVDvrAyTvXDam8jPAJ93Ylh', NULL, '70.31.255.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 OPR/117.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibmhmcDhYS090bzYzTGdXY3R1ZFhUN2ZDT2piWHVsbThKOXo4RmNQUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1743169685),
('yJqoBpB53Tkeq2FOnx9CXeNdDDzqJPGNREXPDNEX', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRU1laUJvSmF0eVBjdlpyZ2htYjB2STR4YXNtUzNFSUxYRjBCeHFwMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9wZXJ0aWVzLzciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1743167335);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('agent','client') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `email`, `password`, `role`, `createdAt`) VALUES
(1, 'testuser1', 'testuser1@example.com', '$2y$12$oyVoBYuFfhqQL3AOoaqaJu1N0EDDQ8PLdtih9S4rERJLj8fmQcvYG', 'agent', '2025-03-24 13:36:26'),
(2, 'testuser2', 'testuser2@example.com', '$2y$12$.N8l6ty5CQyGyzl8fEJmred/7e2tA7phultTEyc4GvN1gq.tShrYu', 'agent', '2025-03-24 13:36:54'),
(3, 'testuser3', 'testuser3@example.com', '$2y$12$d..suP4p.hYtIZs9L3pIj.bHwJy9iw4P4y3SX.TYFpbjoFOGvEhx.', 'agent', '2025-03-24 13:37:11'),
(4, 'Tester123', 'tester123@gmail.com', '$2y$12$9KzWC6DXOiGO0wDoloz5BewTYjFrmIr4rIwkgBa6X5osw24jkgAcG', 'client', '2025-03-24 15:00:09'),
(5, 'Fake', 'Fake@gmail.com', '$2y$12$LbneIe9sOnPeT35dtOcmk.gPylDFYbw8dKIx/Ol4LX8qz4Igqs68C', 'client', '2025-03-24 16:20:23'),
(6, 'TesterAcc', 'TesterAcc@gmail.com', '$2y$12$/92IHnl.Ck/B4RZq1o6uIez25YYci0i.fdD8q8aBK4hu.ChcjdtYS', 'client', '2025-03-24 16:29:12'),
(7, 'Fake1', 'Fake1@gmail.com', '$2y$12$m6wGViE6ecXy5wNfMVB2nuaTBgInSKLatab6uFC7Qr0rrANB7OZ2e', 'client', '2025-03-24 16:43:03'),
(8, 'fake2', 'fake2@gmail.com', '$2y$12$FJ5X0fOLkGFXIORqGOQpkuTV3C6vpWZ4WdOteiotJVRjrNGwkGyAe', 'client', '2025-03-24 16:46:40'),
(9, 'Fake3', 'Fake3@gmail.com', '$2y$12$rMrTd2EDV6xlo3B5WVNPLud7pRFtz6JhiiJbVmMMUraN4oBqPr7RK', 'client', '2025-03-24 16:53:16'),
(10, 'Fake4', 'Fake4@gmail.com', '$2y$12$omq4C7FnptPH4Z2vJobJ1OD8NXtXIFipu1AgAWTmz/J9nH2wfM8o6', 'client', '2025-03-24 17:03:24'),
(11, 'Fake5', 'Fake5@gmail.com', '$2y$12$J2U.65Ptgt8vR2Hms1nmwOeYL2h9Tp/Lcnn56DA2Ydx3Uzn42yg5y', 'client', '2025-03-24 17:19:06'),
(12, 'Fake6', 'Fake6@gmail.com', '$2y$12$zKDJbWdfsLIr4mUPWanC2OWUTX.BWsBDVKwqsKyeOznZ6oJ3b1FHG', 'client', '2025-03-24 17:44:45'),
(13, 'Fake7', 'Fake7@gmail.com', '$2y$12$nMBc2AiYH7WgVvI0RP88dO/AiQIgCtIAAjG9te7pOC.SXpXXbhqPm', 'client', '2025-03-24 17:46:25'),
(14, 'Fake8', 'Fake8@gmail.com', '$2y$12$XI.FhzHX5NudL1RYtW0jtej.fywP1HRWOFJxPE8.Qj5whDGiLCpoC', 'client', '2025-03-24 17:54:06'),
(17, 'Fake12345', 'Fake12345@gmail.com', '$2y$12$pc6Z0U7EhBhlniKNPfQ3rOJnCQolBiP1nSxxtKjBu3HvAZlR3HO/.', 'client', '2025-03-24 18:08:35'),
(18, 'Login', 'Login@gmail.com', '$2y$12$Iv7f47yuTG3d7Z//tcid6OdoTKkrGZGG1r8ydZ2gPGyHiN1w1vbEO', 'client', '2025-03-24 18:31:14'),
(19, 'Fake9', 'Fake9@gmail.com', '$2y$12$Zz1B2Su7o5uGt7dyaVSp6.ISGKtrsm6.4/y2vOG1Z1y1.HPKdXLb6', 'client', '2025-03-24 18:49:07'),
(20, 'Fake10', 'Fake10@gmail.com', '$2y$12$DWuNM/TirVEqIR8hp3wPpuf9IBb4zxc59VGQl8qrZJhpU/ELEWJKe', 'client', '2025-03-24 18:49:57'),
(21, 'Louis Chartier', 'lchartier002@gmail.com', '$2y$12$jrA1feaRx6x0jyHqKYJIROqfo1nBtzR0rrN4yAeJilMOVfB2KM4me', 'client', '2025-03-25 23:48:19'),
(22, 'David Demers', 'daviddemeers92@gmail.com', '$2y$12$hSDCvNmDaHl19ZYDxUOcIOZDuIVzu.MkB7sDBboI9bLOCVfnSPWfK', 'client', '2025-03-26 14:30:40'),
(23, 'Tester1234', 'tester1234@gmail.com', '$2y$12$wmLiOd4iMn2kpDyJzfz8BeuQ2MjOpFmC2mCws6wsSLT5hBLx9xvCK', 'client', '2025-03-26 18:59:10'),
(24, 'newuser11', 'newuser11@newuser.com', '$2y$12$lcw/f3fXWe99uQ/COx2wa.fPIulYGfvUEWwTuWYK5pj2SFj88IRgW', 'client', '2025-03-26 19:17:50'),
(25, 'DavidDemers', 'daviddemers@gmail.com', '$2y$12$AyDj3MCgJPP1bxHZbRF6JOIqnEB9Ioz6opAy7BfqpqKuY148A.r7G', 'agent', '2025-03-27 17:14:24'),
(26, 'JohnDoe', 'johndoe@gmail.com', '$2y$12$8wCBj54gqYBpEAyu0/81/usURXJtpVtD/Zt0q/h/TOHDD0o1vtMy2', 'agent', '2025-03-27 17:16:52'),
(27, 'JohnDoe2', 'johndoe2@gmail.com', '$2y$12$2oJI4hM.7jmFssvO2YEimeA631ud4Tl1TbVoBcUWDvroptnkmd8be', 'agent', '2025-03-27 17:20:51'),
(28, 'Agent123', 'Agent123@gmail.com', '$2y$12$8CaczS8LvHm04rRAvwa/duPdNk5PYBGB1QKYYCkxlkGzxBZZfoGEO', 'agent', '2025-03-27 17:22:36'),
(29, 'Agent001', 'agent001@gmail.com', '$2y$12$jchiqfTN5r6LszkXE94Uw.kFOusytunIa./yQEjQQIlHMPrhFPTlS', 'agent', '2025-03-27 17:41:30'),
(30, 'Agent0001', 'agent0001@gmail.com', '$2y$12$epcTw/4uveAfY2JwXZFoae0DIUXhU7fPgKcYAJanhQJXMVf3HJR7K', 'agent', '2025-03-27 17:49:01'),
(31, 'Agent777', 'agent777@gmail.com', '$2y$12$rzW/dyJ9zUyjOdZGRlB6P.D5ZhOG8IsZH06nXmoCZyKPO4TvB5xR2', 'agent', '2025-03-27 17:53:22'),
(32, 'JohnDoe3', 'johndoe3@gmail.com', '$2y$12$l55kfPSNkTvNCEFySe6wAeN2Ug9ZcpTTs.mhnTwBg6.nWYJV6pDCS', 'client', '2025-03-27 17:53:27'),
(33, 'JohnDoe4', 'johndoe4@gmail.com', '$2y$12$Ct2rMfW8lmvb3LdxV.c.keW71ZO4CeQK.Ka/3qY5J8TatGF0PuPMG', 'client', '2025-03-27 17:56:46'),
(34, 'JohnDoe5', 'johndoe5@gmail.com', '$2y$12$IvVZy8Jst4Xl4mtdrujZ6uW5k9K2bFx545/CuZaquvReoPESeUUCu', 'agent', '2025-03-27 17:59:14'),
(35, 'Agent007', 'agent007@gmail.com', '$2y$12$ZtZnlnLtqMZBhvpaI.SVuOrAbnwbRrg09xFd8u0s2pBT7CRlMFOZ.', 'agent', '2025-03-27 18:21:49'),
(36, 'LouisAgent', 'louisagent@gmail.com', '$2y$12$REPUE/xgN9eOAzBoau.edOa0DBBjbF14BSNXu5GTLkpPrez8kdtda', 'agent', '2025-03-27 22:04:12'),
(37, 'Marisa Vandenengel', 'marisa.vandenengel@gmail.com', '$2y$12$HvEJ0lM.qDATnuGf5D1EteUU5SFJjukdV82aRuGVhA3uFgarPVzCm', 'client', '2025-03-28 02:26:48'),
(38, 'Jeremy Scott', 'jeremyscottbusiness@gmail.com', '$2y$12$h9vjTNy8ZwoFbN6f1EqupuxQajMDMNusE42CEAtrLzc/YQl2qlO4S', 'client', '2025-03-28 02:28:46'),
(39, 'JohnDoe6', 'johndoe6@gmail.com', '$2y$12$pDjyOko8uZdpbt6z2xgLIOjx4pGoBdU.7aF/bVUzn89seR4C.wRsS', 'client', '2025-03-28 02:33:08'),
(40, 'jane', 'jane@gmail.com', '$2y$12$nYJtA7v2H5wEDlFEo.vscuCJD8gchohVrX5zTNJGC8DXqb1REZ7qa', 'client', '2025-03-28 02:34:45'),
(44, 'LOuis chart', 'lchartier2002@gmail.com', '$2y$12$2IDa9HQ/7Mif6rDpo5mFve60F3ZX8quXJr361leq5qmcSvhu6h2h2', 'client', '2025-03-28 13:30:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`propertyId`),
  ADD KEY `properties_ownerid_index` (`ownerId`),
  ADD KEY `properties_agentid_index` (`agentId`),
  ADD KEY `properties_issold_index` (`isSold`),
  ADD KEY `properties_propertytype_index` (`propertyType`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`imageId`),
  ADD KEY `property_images_propertyid_foreign` (`propertyId`),
  ADD KEY `property_images_ismain_index` (`isMain`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `propertyId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `imageId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_agentid_foreign` FOREIGN KEY (`agentId`) REFERENCES `users` (`userId`) ON DELETE CASCADE,
  ADD CONSTRAINT `properties_ownerid_foreign` FOREIGN KEY (`ownerId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_propertyid_foreign` FOREIGN KEY (`propertyId`) REFERENCES `properties` (`propertyId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
