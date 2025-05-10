-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10 مايو 2025 الساعة 21:14
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple_store`
--

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `orders`
--

INSERT INTO `orders` (`id`, `user`, `product_id`, `order_date`) VALUES
(1, 'nnn', 1, '2025-05-10 16:09:18'),
(2, 'nnn', 1, '2025-05-10 16:09:58'),
(3, 'nnn', 2, '2025-05-10 16:18:49'),
(4, 'nnn', 1, '2025-05-10 16:26:40'),
(5, 'nnn', 1, '2025-05-10 16:26:43'),
(6, 'nnn', 1, '2025-05-10 17:01:15'),
(7, 'giuu', 1, '2025-05-10 17:04:49'),
(8, 'giuu', 1, '2025-05-10 17:04:53'),
(9, 'giuu', 3, '2025-05-10 17:05:16'),
(10, 'giuu', 1, '2025-05-10 18:35:14'),
(11, 'giuu', 1, '2025-05-10 18:35:20'),
(12, 'giuu', 4, '2025-05-10 18:35:38');

-- --------------------------------------------------------

--
-- بنية الجدول `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `description`, `image`) VALUES
(1, 'cold+flu', 20.00, 'وصفات طبيعية لمحاربة البرد والأنفلونزا في الشتاء', '1.jpg'),
(2, 'Rhinathiol', 30.00, 'في العلاج والسيطرة والوقاية ، وتحسين الأمراض والظروف والأعراض التالية: توسع القصبات. اضطرابات الحساسية. العطس.', NULL),
(3, 'Claritine\r\n\r\n', 45.00, 'علاج فعال للتخلص من أعراض البرد والحساسية، مثل العطس، وسيلان الأنف، والحكة في العيون،\r\n\r\n', NULL),
(4, 'ريفا كريب', 15.00, 'لتخفف من أعراض مثل الحمى والسعال واحتقان الصدر وانسداد الأنف الناتجة عن الاصابة بنزلات البرد أو الأنفلونزا أو أمراض الجهاز التنفسي الأخرى', NULL),
(5, 'CETAMOL\r\n\r\n', 10.00, 'هو مسكن للألم وخافض للحرارة؛\r\n\r\n', NULL),
(6, 'Augmentin', 50.00, 'ن أشهر المضادات الحيوية واسعة الطيف، حيث يُستخدم لعلاج العديد من العدوى البكتيرية التي تصيب الجهاز التنفسي، البولي، والجلد.', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 't03978', 'muhammadmahdialyuosef@gmail.com', '$2y$10$Y0u46PAoMERSFLNzjFu4De5qgSXHcImLx/Mr0a1oVg6ubHMG1bkeW', 'user'),
(2, 'mmm', 'mohammedmahdicorse@gmail.com', '$2y$10$iSoEBdIyur2N6pwfx9Rx0.s3fZiiYlI2gbOTT.QNAaCiyTIjuWuRK', 'user'),
(3, 'nnn', 'mahdimhs04mhs@gmail.com', '$2y$10$bE2OWvzt8yydp0U64K4T4ej5ZLMCDAJiBqelu228lFm9vDQ7Yy5/C', 'user'),
(4, 'giuu', 'mnmn@gmail.com', '$2y$10$VeWTAbST4mweOqTwkDUH9OsAS2JIgYvzPAjxtmR6iADL/ebHFbf8O', 'user'),
(5, 'giuu', 'nnnn@gmail.com', '$2y$10$d3d5ZxDupWJQJMNcA1P8dOBNJyVIt3th/GP./iHCgxjnRYWn6kRWS', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
