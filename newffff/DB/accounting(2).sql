-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2023 at 11:43 AM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 8.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int UNSIGNED NOT NULL,
  `account_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `account_active` enum('1','2') COLLATE utf8mb4_persian_ci NOT NULL DEFAULT '1',
  `account_explanation` text COLLATE utf8mb4_persian_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buyfactor`
--

CREATE TABLE `buyfactor` (
  `buyfactor_id` int UNSIGNED NOT NULL,
  `buy_date` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `cust_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `warehouse_id` int UNSIGNED NOT NULL,
  `product_qty` int UNSIGNED NOT NULL,
  `factor_fi` int NOT NULL,
  `buy_off` int DEFAULT NULL,
  `buy_sum` int NOT NULL,
  `factor_explanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `credit_prod_after` bigint UNSIGNED NOT NULL,
  `factor_done` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_editfactor` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `buyfactor`
--

INSERT INTO `buyfactor` (`buyfactor_id`, `buy_date`, `cust_id`, `product_id`, `warehouse_id`, `product_qty`, `factor_fi`, `buy_off`, `buy_sum`, `factor_explanation`, `credit_prod_after`, `factor_done`, `created_at`, `updated_at`, `user_editfactor`) VALUES
(25, '1687331118', 1, 1, 1, 100, 10, 0, 1000, '', 100, '1', '2023-06-21 07:05:30', NULL, 1),
(26, '1687849543', 1, 1, 1, 50, 25, 0, 1250, '', 150, '1', '2023-06-21 07:06:13', NULL, 1),
(27, '1690874545', 1, 1, 1, 70, 700, 0, 49000, '', 200, '1', '2023-06-21 07:22:40', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int UNSIGNED NOT NULL,
  `category_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'خودکار', '2023-06-18 07:14:30', NULL),
(2, 'تکنولوژی', '2023-06-20 08:52:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `credit_id` int UNSIGNED NOT NULL,
  `personaccount_id` int UNSIGNED NOT NULL,
  `credit` bigint NOT NULL,
  `transfer_id` int UNSIGNED DEFAULT NULL,
  `buyfactor_id` int UNSIGNED DEFAULT NULL,
  `sellfactor_id` int UNSIGNED DEFAULT NULL,
  `created_at` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `edit_user` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `credits`
--

INSERT INTO `credits` (`credit_id`, `personaccount_id`, `credit`, `transfer_id`, `buyfactor_id`, `sellfactor_id`, `created_at`, `updated_at`, `edit_user`) VALUES
(1, 1, 1000, NULL, 25, NULL, '1687331118', NULL, 1),
(2, 2, -1000, NULL, 25, NULL, '1687331118', NULL, 1),
(3, 1, 1250, NULL, 26, NULL, '1687849543', NULL, 1),
(4, 2, -1250, NULL, 26, NULL, '1687849543', NULL, 1),
(5, 1, -400, NULL, NULL, 13, '1689146165', NULL, 1),
(6, 3, 400, NULL, NULL, 13, '1689146165', NULL, 1),
(7, 1, 49000, NULL, 27, NULL, '1690874545', NULL, 1),
(8, 2, -49000, NULL, 27, NULL, '1690874545', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int UNSIGNED NOT NULL,
  `menu_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `ordermenu` int UNSIGNED NOT NULL,
  `permition_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `url`, `ordermenu`, `permition_id`, `created_at`, `updated_at`) VALUES
(1, 'فاکتور خرید', './newffff/buyfactor.php', 1, 1, '2023-06-19 06:36:04', NULL),
(2, 'فاکتور خرید', './newffff/buyfactor.php', 1, 2, '2023-06-19 06:36:04', NULL),
(3, 'فاکتور خرید', './newffff/buyfactor.php', 1, 3, '2023-06-19 06:36:04', NULL),
(4, 'فاکتور فروش', './newffff/sellfactor.php', 2, 1, '2023-06-19 06:36:31', NULL),
(5, 'فاکتور فروش', './newffff/sellfactor.php', 2, 2, '2023-06-19 06:36:31', NULL),
(6, 'فاکتور فروش', './newffff/sellfactor.php', 2, 3, '2023-06-19 06:36:31', NULL),
(7, 'تعریف طرف حساب و حساب ها', '', 3, 1, '2023-06-19 06:38:08', NULL),
(8, 'تعریف طرف حساب و حساب ها', '', 3, 2, '2023-06-19 06:38:08', NULL),
(9, 'تعریف طرف حساب و حساب ها', '', 3, 3, '2023-06-19 06:38:08', NULL),
(10, 'تعریف کالای جدید', '', 4, 1, '2023-06-19 06:38:34', NULL),
(11, 'تعریف کالای جدید', '', 4, 2, '2023-06-19 06:38:34', NULL),
(12, 'تعریف کالای جدید', '', 4, 3, '2023-06-19 06:38:34', NULL),
(13, 'کاردکس اشخاص', '', 5, 1, '2023-06-19 06:39:07', NULL),
(14, 'کاردکس اشخاص', '', 5, 2, '2023-06-19 06:39:07', NULL),
(15, 'کاردکس کالا', './productlist.php', 6, 1, '2023-06-19 06:39:26', NULL),
(16, 'کاردکس کالا', 'productlist.php', 6, 2, '2023-06-19 06:39:26', NULL),
(17, 'تعریف کاربر جدید و لیست کاربران', '', 7, 1, '2023-06-19 06:39:46', NULL),
(18, 'اصلاح فاکتورها', '', 8, 1, '2023-06-19 06:41:10', NULL),
(19, 'ثبت حواله', '', 9, 1, '2023-06-19 06:41:10', NULL),
(20, 'ثبت حواله', '', 9, 2, '2023-06-19 06:41:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permitions`
--

CREATE TABLE `permitions` (
  `permition_id` int UNSIGNED NOT NULL,
  `permition_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `permitions`
--

INSERT INTO `permitions` (`permition_id`, `permition_name`, `created_at`, `updated_at`) VALUES
(1, 'مدیر', '2023-06-18 07:14:46', NULL),
(2, 'حسابدار', '2023-06-19 06:33:22', NULL),
(3, 'فاکتور زن', '2023-06-19 06:33:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personaccount`
--

CREATE TABLE `personaccount` (
  `cust_id` int UNSIGNED NOT NULL,
  `account_type` enum('1','2') COLLATE utf8mb4_persian_ci NOT NULL,
  `cust_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `cust_codemeli` int UNSIGNED DEFAULT NULL,
  `cust_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci,
  `cust_mobile` int DEFAULT NULL,
  `cust_active` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `personaccount`
--

INSERT INTO `personaccount` (`cust_id`, `account_type`, `cust_name`, `cust_codemeli`, `cust_address`, `cust_mobile`, `cust_active`, `created_at`, `updated_at`) VALUES
(1, '1', 'بهزاد', 123456, 'نارمک', 123, '1', '2023-06-18 07:15:30', NULL),
(2, '2', 'خرید', NULL, NULL, NULL, '1', '2023-06-20 04:01:50', NULL),
(3, '2', 'فروش', NULL, NULL, NULL, '1', '2023-06-20 04:01:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int UNSIGNED NOT NULL,
  `product_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `product_serial` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `unit_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_serial`, `category_id`, `unit_id`, `created_at`, `updated_at`) VALUES
(1, 'خودکار بیک', 123, 1, 1, '2023-06-18 07:16:47', NULL),
(2, 'لپتاپ', 100, 2, 1, '2023-06-20 08:54:25', NULL),
(3, 'موبایل', 784, 2, 1, '2023-06-20 08:54:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sellfactors`
--

CREATE TABLE `sellfactors` (
  `sellfactor_id` int UNSIGNED NOT NULL,
  `sell_date` bigint NOT NULL,
  `cust_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `product_qty` int NOT NULL,
  `factor_fi` bigint NOT NULL,
  `sell_off` bigint UNSIGNED DEFAULT NULL,
  `sell_sum` bigint NOT NULL,
  `factor_explanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `credit_after_sell` bigint UNSIGNED NOT NULL,
  `factor_done` enum('1','2') COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_editfactor` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `sellfactors`
--

INSERT INTO `sellfactors` (`sellfactor_id`, `sell_date`, `cust_id`, `product_id`, `product_qty`, `factor_fi`, `sell_off`, `sell_sum`, `factor_explanation`, `credit_after_sell`, `factor_done`, `created_at`, `updated_at`, `user_editfactor`) VALUES
(13, 1689146165, 1, 1, 20, 20, 0, 400, '', 130, '1', '2023-06-21 07:21:42', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int UNSIGNED NOT NULL,
  `stock_productid` int UNSIGNED NOT NULL,
  `stock_wearhouseid` int UNSIGNED NOT NULL,
  `stock` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_productid`, `stock_wearhouseid`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 200, '2023-06-21 07:05:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `transfersend_id` int UNSIGNED NOT NULL,
  `transfersend_date` timestamp NOT NULL,
  `transfersend_from` int UNSIGNED NOT NULL,
  `transfersend_to` int UNSIGNED NOT NULL,
  `transfersend_price` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `useredit_id` int UNSIGNED NOT NULL,
  `transfersend_explanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int UNSIGNED NOT NULL,
  `unit_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `created_at`, `updated_at`) VALUES
(1, 'عدد', '2023-06-18 07:15:51', NULL),
(2, 'کیلو', '2023-06-20 08:53:42', NULL),
(3, 'لیتر', '2023-06-20 08:53:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL,
  `user_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `user_firstName` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `user_email` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `user_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `permition_id` int UNSIGNED NOT NULL,
  `user_active` enum('1','2') COLLATE utf8mb4_persian_ci NOT NULL DEFAULT '2',
  `user_token` varchar(256) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_firstName`, `user_email`, `user_password`, `permition_id`, `user_active`, `user_token`, `created_at`, `updated_at`) VALUES
(1, 'behzad', 'behzad', 'behzad.kermanii@gmail.com', '$2y$10$RcxAXEPlaL33QQ.y0RKTeeNZwFr8uzasX2tRbSpNQ52SPAWqVLCIK', 1, '2', NULL, '2023-06-18 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wearhouses`
--

CREATE TABLE `wearhouses` (
  `wearhouse_id` int UNSIGNED NOT NULL,
  `wearhouse_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `wearhouses`
--

INSERT INTO `wearhouses` (`wearhouse_id`, `wearhouse_name`, `created_at`, `updated_at`) VALUES
(1, 'هزاره سوم', '2023-06-18 07:16:34', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `buyfactor`
--
ALTER TABLE `buyfactor`
  ADD PRIMARY KEY (`buyfactor_id`),
  ADD KEY `sup_id` (`cust_id`),
  ADD KEY `prod_id` (`product_id`),
  ADD KEY `ware_id` (`warehouse_id`),
  ADD KEY `usr_id` (`user_editfactor`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`credit_id`),
  ADD KEY `edituser` (`edit_user`),
  ADD KEY `transfers_id` (`transfer_id`),
  ADD KEY `cre_id` (`credit_id`) USING BTREE,
  ADD KEY `buyfactor_id` (`buyfactor_id`),
  ADD KEY `sellfactor_id` (`sellfactor_id`),
  ADD KEY `personaccount_id` (`personaccount_id`) USING BTREE;

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `permiti_id` (`permition_id`);

--
-- Indexes for table `permitions`
--
ALTER TABLE `permitions`
  ADD PRIMARY KEY (`permition_id`);

--
-- Indexes for table `personaccount`
--
ALTER TABLE `personaccount`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `cat_id` (`category_id`),
  ADD KEY `uni_id` (`unit_id`);

--
-- Indexes for table `sellfactors`
--
ALTER TABLE `sellfactors`
  ADD PRIMARY KEY (`sellfactor_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_editfactor`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `stock_product` (`stock_productid`),
  ADD KEY `stock_wear` (`stock_wearhouseid`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`transfersend_id`),
  ADD KEY `transfer_from_account` (`transfersend_from`),
  ADD KEY `transfer_to_user` (`transfersend_to`),
  ADD KEY `usersedit_id` (`useredit_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `permit_id` (`permition_id`);

--
-- Indexes for table `wearhouses`
--
ALTER TABLE `wearhouses`
  ADD PRIMARY KEY (`wearhouse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buyfactor`
--
ALTER TABLE `buyfactor`
  MODIFY `buyfactor_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `credit_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `permitions`
--
ALTER TABLE `permitions`
  MODIFY `permition_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personaccount`
--
ALTER TABLE `personaccount`
  MODIFY `cust_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sellfactors`
--
ALTER TABLE `sellfactors`
  MODIFY `sellfactor_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `transfersend_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wearhouses`
--
ALTER TABLE `wearhouses`
  MODIFY `wearhouse_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyfactor`
--
ALTER TABLE `buyfactor`
  ADD CONSTRAINT `prod_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sup_id` FOREIGN KEY (`cust_id`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usr_id` FOREIGN KEY (`user_editfactor`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ware_id` FOREIGN KEY (`warehouse_id`) REFERENCES `wearhouses` (`wearhouse_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `credits`
--
ALTER TABLE `credits`
  ADD CONSTRAINT ` personaccount_id` FOREIGN KEY (`personaccount_id`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buyfactor_id` FOREIGN KEY (`buyfactor_id`) REFERENCES `buyfactor` (`buyfactor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edituser` FOREIGN KEY (`edit_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sellfactor_id` FOREIGN KEY (`sellfactor_id`) REFERENCES `sellfactors` (`sellfactor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfers_id` FOREIGN KEY (`transfer_id`) REFERENCES `transfer` (`transfersend_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `permiti_id` FOREIGN KEY (`permition_id`) REFERENCES `permitions` (`permition_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `cat_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uni_id` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sellfactors`
--
ALTER TABLE `sellfactors`
  ADD CONSTRAINT `cust_id` FOREIGN KEY (`cust_id`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_editfactor`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stock_product` FOREIGN KEY (`stock_productid`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_wear` FOREIGN KEY (`stock_wearhouseid`) REFERENCES `wearhouses` (`wearhouse_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `transfer_from_user` FOREIGN KEY (`transfersend_from`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_to_user` FOREIGN KEY (`transfersend_to`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usersedit_id` FOREIGN KEY (`useredit_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `permit_id` FOREIGN KEY (`permition_id`) REFERENCES `permitions` (`permition_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
