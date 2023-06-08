-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2023 at 08:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rc4`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id_files` tinyint(4) NOT NULL,
  `username` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `encryption_key` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id_files`, `username`, `file_name`, `encryption_key`, `created_at`) VALUES
(1, 'sadmin', '1BINTS2.pdf', '12345678', '2023-05-25 10:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` tinyint(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'sadmin', 'sadmin', 'c5edac1b8c1d58bad90a246d8f08f53b', 'superadmin', '2023-05-25 06:05:53'),
(2, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2023-05-25 06:07:50'),
(3, 'user', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', '2023-05-25 06:08:23'),
(100, 'user1', 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 'user', '2023-05-25 09:55:51'),
(101, 'user2', 'user2', '7e58d63b60197ceb55a1c487989a3720', 'user', '2023-05-25 09:56:16'),
(102, 'user3', 'user3', 'user3', 'user', '2023-05-25 09:56:50'),
(103, 'admin1', 'admin1', 'e00cf25ad42683b3df678c61f42c6bda', 'admin', '2023-05-25 09:57:29'),
(104, 'admin2', 'admin2', 'c84258e9c39059a89ab77d846ddab909', 'admin', '2023-05-25 09:57:50'),
(105, 'admin3', 'admin3', '32cacb2f994f6b42183a1300d9a3e8d6', 'admin', '2023-05-25 09:58:09'),
(106, 'sadmin1', 'sadmin1', '2d6af13ea904dc8bfc0543e8c28868a5', 'superadmin', '2023-05-25 09:58:50');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `prevent_delete_users` BEFORE DELETE ON `users` FOR EACH ROW BEGIN
    -- Memeriksa nilai ID yang akan dihapus
    IF OLD.id_user IN (1, 2, 3) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tidak diizinkan menghapus data dengan ID 1, 2, dan 3';
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id_files`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id_files` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` tinyint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
