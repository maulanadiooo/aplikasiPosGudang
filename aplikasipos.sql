-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2022 at 06:57 PM
-- Server version: 5.7.33
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasipos`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `qty` bigint(20) UNSIGNED NOT NULL,
  `price_supplier` double NOT NULL,
  `price_member` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `supplier_id`, `qty`, `price_supplier`, `price_member`, `created_at`, `updated_at`) VALUES
(1, 'Indomie Kuah', 1, 2, 3000, 3500, '2022-01-09 09:37:28', '2022-01-10 21:45:45'),
(3, 'Sosis', 2, 0, 15000, 17000, '2022-01-09 09:39:57', '2022-01-10 21:45:24'),
(4, 'Indomie Goreng', 1, 0, 3000, 3520, '2022-01-10 02:20:10', '2022-01-10 02:20:10'),
(5, 'asaas', 2, 10000, 11111, 11111, '2022-01-10 21:20:31', '2022-01-10 21:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `item_histories`
--

CREATE TABLE `item_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_histories`
--

INSERT INTO `item_histories` (`id`, `status`, `supplier_id`, `member_id`, `transaction_id`, `created_at`, `updated_at`) VALUES
(9, 'in', 2, NULL, 10, '2022-01-10 02:27:39', '2022-01-10 02:27:39'),
(10, 'out', NULL, 1, 11, '2022-01-10 02:28:08', '2022-01-10 02:28:08'),
(11, 'out', NULL, 1, 12, '2022-01-10 04:14:34', '2022-01-10 04:14:34'),
(13, 'in', 1, NULL, 14, '2022-01-10 21:20:13', '2022-01-10 21:20:13'),
(14, 'out', NULL, 1, 15, '2022-01-10 21:45:24', '2022-01-10 21:45:24'),
(15, 'in', 1, NULL, 16, '2022-01-10 21:45:45', '2022-01-10 21:45:45'),
(16, 'in', 2, NULL, 17, '2022-01-10 21:46:10', '2022-01-10 21:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `address`, `phone_number`, `email`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'Dindas', 'Medan', 6281275351256, 'dinda@gmail.com', 'P', '2022-01-09 09:34:12', '2022-01-10 21:18:42'),
(2, 'Fauzia', 'Padang', 6285668708552, 'fauzia@gmail.com', 'L', '2022-01-09 09:34:41', '2022-01-09 09:34:41'),
(3, 'Dio', 'Padang', 6281275351256, 'diomaulana25@gmail.com', 'L', '2022-01-10 04:20:58', '2022-01-10 04:20:58'),
(4, 'Dio Maulanas', 'asdasd', 628121212112, 'asdasd@mail.com', 'L', '2022-01-10 04:22:59', '2022-01-10 21:43:29'),
(6, 'asdasd', 'adsasd', 6281275351256, 'asdasd@mail.com', 'L', '2022-01-10 21:49:41', '2022-01-10 21:49:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(5, '2022_01_08_234214_create_members_table', 1),
(6, '2022_01_08_234418_create_suppliers_table', 1),
(7, '2022_01_08_234419_create_items_table', 1),
(8, '2022_01_08_234638_create_transactions_table', 1),
(9, '2022_01_08_234640_create_item_histories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `address`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'PT Indomie', 'indomie@gmail.com', 'Jl Medan Utara', 628123456789, '2022-01-09 09:35:05', '2022-01-09 09:35:05'),
(2, 'PT Jaya Sejahtera', 'jaya@gmail.com', 'Jalan Kemana', 6281219191911, '2022-01-09 09:35:24', '2022-01-09 09:35:24'),
(3, 'PT Makmur', 'makmur@gmail.com', 'Jalan Minang', 6281275351211, '2022-01-10 03:21:18', '2022-01-10 03:21:18'),
(4, 'asdasd', 'asdasd@mail.com', 'asdasd', 6281212121111, '2022-01-10 21:25:19', '2022-01-10 21:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `qty` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `item_id`, `qty`, `created_at`, `updated_at`) VALUES
(10, 3, 3, '2022-01-10 02:27:39', '2022-01-10 04:06:41'),
(11, 3, 1, '2022-01-10 02:28:08', '2022-01-10 02:28:08'),
(12, 3, 1, '2022-01-10 04:14:34', '2022-01-10 04:14:34'),
(14, 1, 1, '2022-01-10 21:20:13', '2022-01-10 21:20:13'),
(15, 3, 1, '2022-01-10 21:45:24', '2022-01-10 21:45:24'),
(16, 1, 1, '2022-01-10 21:45:45', '2022-01-10 21:45:45'),
(17, 5, 10000, '2022-01-10 21:46:10', '2022-01-10 21:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dio Maulana', 'admin@gmail.com', NULL, '$2y$10$NdJeXZw5o1ngpu4.KqVyTu0s7CZbO3VOK4h78lNwMJxHq4XNe.1Kq', 'YNRYorOpYreuHoNmqCbBLWhsRxmVlKQ55a6C0QOlz4rM7iqMcDdqqAErzXh7', '2022-01-09 09:33:53', '2022-01-09 09:33:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `item_histories`
--
ALTER TABLE `item_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_histories_supplier_id_foreign` (`supplier_id`),
  ADD KEY `item_histories_member_id_foreign` (`member_id`),
  ADD KEY `item_histories_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_item_id_foreign` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item_histories`
--
ALTER TABLE `item_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `item_histories`
--
ALTER TABLE `item_histories`
  ADD CONSTRAINT `item_histories_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `item_histories_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `item_histories_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
