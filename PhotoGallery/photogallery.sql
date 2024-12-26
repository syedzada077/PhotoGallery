-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 08:32 PM
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
-- Database: `photogallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `category`, `picture`, `full_name`, `profile_picture`, `created_at`) VALUES
(2, 1, 'Dieting', 'Dieting', 'photos/pexels-mikhail-nilov-6740517.jpg', 'Ali Raza', 'uploads/math_img.jpg', '2024-07-19 18:07:16'),
(3, 2, 'Meditation', 'Wellness', 'photos/pexels-felipe-borges-964530-2597205.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:13:11'),
(4, 2, 'Style', 'Fashion', 'photos/pexels-daniel-adesina-279287-833052.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:13:34'),
(5, 2, 'Mother Nature', 'Nature', 'photos/pexels-luisdelrio-15286.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:14:15'),
(6, 2, 'Cook ', 'Cooking', 'photos/pexels-conojeghuo-175753.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:14:41'),
(7, 2, 'Stars', 'Astronomy', 'photos/astrology.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:15:03'),
(8, 2, 'Ocean Travel', 'Travel', 'photos/travel-world.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:15:26'),
(9, 2, 'Modern Technology', 'Technology', 'photos/techno.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:15:51'),
(10, 2, 'A Nice House', 'Home', 'photos/home.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:16:16'),
(11, 2, 'Different Foods', 'Food', 'photos/food.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:16:38'),
(12, 2, 'Life Is Amazing', 'Lifestyle', 'photos/lf.jpg', 'Saif Ur Rehman', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `profile_picture`, `created_at`) VALUES
(2, 'Saif Ur Rehman', 'talha@gmail.com', '$2y$10$S4gFkkJoIwfdRgnedbQHVeH5ykS24O.hse9KkxmPy0wR7TiOMFwiu', 'uploads/_33d53c2d-9a7c-47f0-8ed4-ead4f65c526a.jpg', '2024-07-19 18:11:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
