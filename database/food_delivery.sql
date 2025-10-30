
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2025 at 05:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', '', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFxEbl/4xK3SL86u6xnwB.7rj2nA72.e'),
(2, 'khachuk', 'khachuk@gmail.com', '$2y$10$i6xFhQNqG44IA6zuT4Lnzu/6f6V5WG5zL5OMh8kMlVC6OtZOkQPoC');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `restaurant_name` varchar(100) NOT NULL,
  `food_name` varchar(100) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `availability` enum('Available','Unavailable') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `restaurant_name`, `food_name`, `weight`, `description`, `price`, `image`, `category`, `availability`, `created_at`) VALUES
(3, 'Joy Dev Hotel ', 'Pork', '250gm', 'Delicious Food Pork meals', 80.00, '1745601895_pork.jpg', 'meat', 'Available', '2025-04-25 17:24:55'),
(5, 'Joy Dev Hotel ', 'Chicken', '250gm', 'Chicken Curry', 60.00, '1745601997_chicken.jpg', 'meat', 'Available', '2025-04-25 17:26:37'),
(6, 'Joy Dev Hotel ', 'Egg', '4pices', 'Egg Curry', 50.00, '1745637702_kmc_20230205_231723-2.jpg', 'food', 'Available', '2025-04-26 03:21:42'),
(7, 'Joy Dev Hotel ', 'Pulse Mixed Curry', '1bigcup', 'Pulse Mixed with soyaben', 40.00, '1745637769_Tomato-Chutney-Thumbnail.jpg', 'food', 'Available', '2025-04-26 03:22:49'),
(8, 'Joy Dev Hotel ', 'Brinjal', '1plate', 'Fresh Brinjal Curry', 30.00, '1745637923_images (3).jpg', 'food', 'Available', '2025-04-26 03:25:23'),
(9, 'Joy Dev Hotel ', 'Potato', '1plate', 'Potato', 30.00, '1745638013_hq720.jpg', 'food', 'Available', '2025-04-26 03:26:53'),
(10, 'TARUNI HOTEL', 'CAT FISH', '250gm', 'My Cat fish Very Delicious', 50.00, '1745743543_images (6).jpg', 'food', 'Available', '2025-04-27 08:45:44'),
(11, 'TARUNI HOTEL', 'Eels Fish', '250gm', '\"Tender chicken pieces slow-cooked in a rich, aromatic gravy with freshly ground spices. A perfect blend of flavor and warmth in every bite.', 60.00, '1745744429_eelfihs.jpg', 'food', 'Available', '2025-04-27 09:00:29'),
(12, 'TARUNI HOTEL', 'Snake Fish', '250gm', 'Snake fish with spices', 50.00, '1745767994_sankefish.jpg', 'food', 'Available', '2025-04-27 15:33:14'),
(13, 'TARUNI HOTEL', 'Long Bean ', '250gm', 'Long bean Curry with spices', 30.00, '1745770127_hq720 (1).jpg', 'Vegetable', 'Available', '2025-04-27 16:08:47'),
(14, 'TARUNI HOTEL', 'Local Chicken', '250gm', 'Local Chicken with spices or none spice boil', 70.00, '1745770194_Local-Chicken-Curry.jpg', 'meat', 'Available', '2025-04-27 16:09:54'),
(15, 'FreshFood Restaurant', 'Wak Bahan chakhwi', '250gm', '', 50.00, '1761796361_anita.jpg', 'meat', 'Available', '2025-10-30 03:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `restaurant_name` varchar(100) NOT NULL,
  `items` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `address` text NOT NULL,
  `status` enum('Pending','Accepted','Preparing','Out for Delivery','Delivered','Cancelled') DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `restaurant_name`, `items`, `total_amount`, `address`, `status`, `order_date`) VALUES
(46, 1, 'TARUNI HOTEL', '[{\"name\":\"Local Chicken\",\"weight\":\"\",\"price\":70,\"quantity\":2}]', 140.00, 'Vill - Mahim chowdhury para, PO - Ujan ghania mara, PS - Takarjala', 'Delivered', '2025-04-28 14:28:19'),
(48, 1, 'Joy Dev Hotel ', '[{\"name\":\"Pork\",\"weight\":\"\",\"price\":80,\"quantity\":1},{\"name\":\"Chicken\",\"weight\":\"\",\"price\":60,\"quantity\":3}]', 260.00, 'Vill - Mahim chowdhury para, PO - Ujan ghania mara, PS - Takarjala', 'Delivered', '2025-05-15 14:09:46'),
(49, 1, 'TARUNI HOTEL', '[{\"name\":\"Snake Fish\",\"weight\":\"\",\"price\":50,\"quantity\":1},{\"name\":\"Local Chicken\",\"weight\":\"\",\"price\":70,\"quantity\":1},{\"name\":\"Brinjal\",\"weight\":\"\",\"price\":30,\"quantity\":1}]', 150.00, 'Vill - Mahim chowdhury para, PO - Ujan ghania mara, PS - Takarjala', 'Delivered', '2025-10-28 17:22:06'),
(50, 3, 'TARUNI HOTEL', '[{\"name\":\"Local Chicken\",\"weight\":\"\",\"price\":70,\"quantity\":2}]', 140.00, 'Vill - Mahim chowdhury para, PO - Ujan ghania mara, PS - Takarjala', 'Pending', '2025-10-29 14:11:35'),
(51, 1, 'TARUNI HOTEL', '[{\"name\":\"Eels Fish\",\"weight\":\"\",\"price\":60,\"quantity\":1}]', 60.00, 'Vill - Mahim chowdhury para, PO - Ujan ghania mara, PS - Takarjala', 'Pending', '2025-10-30 03:48:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `food_id`, `weight`, `price`) VALUES
(14, 46, 14, '250gm', 70.00),
(16, 48, 3, '250gm', 80.00),
(17, 48, 5, '250gm', 60.00),
(18, 49, 12, '250gm', 50.00),
(19, 49, 14, '250gm', 70.00),
(20, 49, 8, '1plate', 30.00),
(21, 50, 14, '250gm', 70.00),
(22, 51, 11, '250gm', 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `address`, `password`, `photo`) VALUES
(1, 'Waitala Debbarma', '8415059363', 'waitai@gmail.com', 'Vill - Mahim chowdhury para, PO - Ujan ghania mara, PS - Takarjala', '$2y$10$FKvTPw7dXyTYvO0wNPs4YORd5et5hXECOWb561Sf68wSWnMspLih2', 'user_1.jpg'),
(3, 'Rupa Debbarma', '8415059362', 'rupa@gmail.com', 'Vill - Mahim chowdhury para, PO - Ujan ghania mara, PS - Takarjala', '$2y$10$WkGlxLMzu11tBHtKZdM/be/Zkeaa0xlSk2/Oz4rokv.y6UR9JNJI.', 'user_3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;