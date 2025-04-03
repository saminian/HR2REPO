-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 04:16 PM
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
-- Database: `hr2`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `trainee_id` int(11) DEFAULT NULL,
  `workshop_id` int(11) DEFAULT NULL,
  `status` enum('Present','Absent') DEFAULT 'Absent',
  `date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `trainee_id`, `workshop_id`, `status`, `date`) VALUES
(36, 88, 42, 'Present', '2025-03-08'),
(37, 89, 43, 'Present', '2025-03-08');

--
-- Triggers `attendance`
--
DELIMITER $$
CREATE TRIGGER `update_attendance_rate` AFTER INSERT ON `attendance` FOR EACH ROW BEGIN
    DECLARE total INT;
    DECLARE present INT;
    
    -- Count total workshops attended by trainee
    SELECT COUNT(*) INTO total FROM attendance WHERE trainee_id = NEW.trainee_id;
    SELECT COUNT(*) INTO present FROM attendance WHERE trainee_id = NEW.trainee_id AND status = 'Present';
    
    -- Update attendance rate in performance_statistics
    UPDATE performance_statistics
    SET attendance_rate = (present / total) * 100
    WHERE trainee_id = NEW.trainee_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(35, 'Company Introduction & Culture', '2025-03-08 03:21:23'),
(36, 'Customer & Communication', '2025-03-08 06:02:41'),
(38, 'Networking', '2025-03-12 06:06:46'),
(39, 'HAHAHAH', '2025-03-17 15:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `employeeseval`
--

CREATE TABLE `employeeseval` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `final_score` decimal(5,2) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeeseval`
--

INSERT INTO `employeeseval` (`id`, `first_name`, `last_name`, `final_score`, `updated_at`, `status`) VALUES
(1, 'Momo', 'Hirai', 89.30, '2025-03-08 02:36:40', 'Pass'),
(2, 'Jihyo', 'Park', 79.80, '2025-03-08 05:38:58', 'Pass'),
(3, 'Nayeon', 'Im', 76.50, '2025-03-08 05:39:13', 'Pass'),
(4, 'Dahyun', 'Kim', 79.30, '2025-03-11 10:56:50', 'Pass'),
(5, 'Chaeyoung', 'Son', 82.30, '2025-03-11 10:56:59', 'Pass'),
(6, 'Sana', 'Minatozaki', 73.90, '2025-03-11 11:08:28', 'Fail'),
(7, 'Mina', 'Myoui', 86.10, '2025-03-12 04:40:49', 'Pass'),
(8, 'Jeongyeon', 'Yoo', 85.10, '2025-03-12 04:40:56', 'Pass'),
(186, 'Michael', 'Johnson', 72.30, '2025-03-12 04:41:01', 'Fail');

-- --------------------------------------------------------

--
-- Table structure for table `new_hired_employees`
--

CREATE TABLE `new_hired_employees` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `birth_date` date NOT NULL,
  `contact` varchar(20) NOT NULL,
  `job_position` varchar(255) NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `department` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `new_hired_employees`
--

INSERT INTO `new_hired_employees` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `gender`, `birth_date`, `contact`, `job_position`, `salary`, `department`, `created_at`, `updated_at`) VALUES
(429, 'CHRISTIAN', 'S.', 'NOORA', 'abaloswarlitojr16@gmail.com', 'Male', '2002-06-10', '09691213125', 'Web Developer', 30000.00, 'IT Department', '2025-03-06 21:58:37', '2025-03-06 21:58:37'),
(430, 'julius', 'b. ', 'dela torre', 'delatorrejuliuservin8@gmail.com', 'Male', '2003-08-20', '09876786789', 'Web Developer', 30000.00, 'IT Department', '2025-03-06 21:58:37', '2025-03-06 21:58:37'),
(431, 'CAMO', 'S.', 'CAMO', 'lhyks.alvarez@gmail.com', 'Male', '2004-02-08', '09123456789', 'Web Developer', 30000.00, 'IT Department', '2025-03-06 21:58:37', '2025-03-06 21:58:37'),
(432, 'camo', 'b', 'camo', 'jaynoora06@gmail.com', 'Female', '2025-03-07', '09459788091', 'N/A', 0.00, 'N/A', '2025-03-06 21:58:37', '2025-03-06 21:58:37'),
(504, 'Bor', 'D\'', 'Gol', 'bogart1248@gmail.com', 'Male', '2025-03-20', '09565432152', 'Web Developer', 30000.00, 'IT Department', '2025-03-07 08:03:46', '2025-03-07 08:03:46'),
(546, 'QWEQWE', 'Q', 'RTYRTY', 'ASDAD@GMAIL.COM', 'Female', '2003-02-20', '09123456789', 'N/A', 0.00, 'N/A', '2025-03-07 11:40:05', '2025-03-07 11:40:05'),
(569, 'Rosa', 'T.', 'Namran', 'roselynrosariobsit1163@gmail.com', 'Female', '1999-02-04', '09876786789', 'Sales', 30000.00, 'IT Department', '2025-03-07 13:24:35', '2025-03-07 13:24:35'),
(621, 'Rose', 'Rusi', 'Lyn', 'roselynrosario6@gmail.com', 'Female', '1997-03-07', '09986531643', 'Software Engineer', 30000.00, 'IT Department', '2025-03-07 17:35:33', '2025-03-07 17:35:33'),
(623, 'Argie', ' O', 'Tapalla ', 'whoaminothingnew546@gmail.com', 'Male', '2001-02-07', '09345234512', 'IT Support Specialist', 10000.00, 'IT Department', '2025-03-07 17:35:33', '2025-03-07 17:35:33'),
(624, 'Jobert', 'Huit', 'Camo', 'jobertcamo@gmail.com', 'Male', '2025-03-13', '09565432152', 'webdev', 5000.00, 'IT Department', '2025-03-07 17:35:33', '2025-03-07 17:35:33'),
(632, 'Jorish', '', 'Catacutan', 'delatorrejuliuservin9@gmail.com', 'Male', '2003-08-09', '09234145123', 'Promodiser', 10000.00, 'Sales Department', '2025-03-07 17:40:34', '2025-03-07 17:40:34'),
(666, 'lhyks', '', 'motto', 'lhykslync@gmail.com', 'Male', '2002-02-09', '09123451231', 'Software Engineer', 30000.00, 'IT Department', '2025-03-07 23:10:40', '2025-03-07 23:10:40'),
(667, 'Carlos', '', 'Aggasi', 'delatorrejulieann60@gmail.com', 'Male', '2001-09-09', '09123451231', 'webdev', 5000.00, 'IT Department', '2025-03-07 23:10:40', '2025-03-07 23:10:40'),
(981, 'John Lloyd ', '', 'Picson ', 'delatorrejuliuservin10@gmail.com', 'Male', '2001-02-07', '09345226351', 'Software Engineer', 30000.00, 'IT Department', '2025-03-10 07:56:43', '2025-03-10 07:56:43');

-- --------------------------------------------------------

--
-- Table structure for table `performance_evaluations`
--

CREATE TABLE `performance_evaluations` (
  `id` int(11) NOT NULL,
  `trainee_id` int(11) DEFAULT NULL,
  `workshop_id` int(11) DEFAULT NULL,
  `evaluation_score` decimal(5,2) DEFAULT NULL CHECK (`evaluation_score` between 0 and 100),
  `feedback` text DEFAULT NULL,
  `evaluation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `performance_evaluations`
--
DELIMITER $$
CREATE TRIGGER `update_avg_score` AFTER INSERT ON `performance_evaluations` FOR EACH ROW BEGIN
    DECLARE total_score DECIMAL(5,2);
    DECLARE workshop_count INT;

    -- Get the total score and number of evaluations
    SELECT SUM(evaluation_score), COUNT(*) INTO total_score, workshop_count 
    FROM performance_evaluations WHERE trainee_id = NEW.trainee_id;

    -- Update the average score in performance_statistics
    UPDATE performance_statistics
    SET avg_score = total_score / workshop_count,
        last_evaluation = NOW()
    WHERE trainee_id = NEW.trainee_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `performance_statistics`
--

CREATE TABLE `performance_statistics` (
  `id` int(11) NOT NULL,
  `trainee_id` int(11) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `avg_score` decimal(5,2) DEFAULT 0.00,
  `attendance_rate` decimal(5,2) DEFAULT 0.00,
  `evaluation_status` enum('Pass','Fail') DEFAULT 'Fail',
  `last_evaluation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regular_employees`
--

CREATE TABLE `regular_employees` (
  `id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `marital_status` enum('Single','Married','Divorced','Widowed') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `employment_status` enum('Active','Inactive','Terminated') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `profile_picture` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `regular_employees`
--

INSERT INTO `regular_employees` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `email`, `department`, `position`, `phone`, `address`, `date_of_birth`, `gender`, `nationality`, `marital_status`, `start_date`, `end_date`, `employment_status`, `status`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, '00004', 'Momo', 'B', 'Hirai', 'emp3@gmail.com', 'Human Resources', 'Procurement Specialist', '0977655451', '123 Main St', '1990-01-01', 'Female', 'Japanese', 'Single', '2023-01-01', NULL, 'Active', 'approved', NULL, '2025-03-06 21:56:11', '2025-03-06 21:56:11'),
(2, '00003', 'Jihyo', 'B', 'Park', 'emp2@gmail.com', 'Sales', 'Key Account Manager', '9876543210', '456 Elm St', '1985-05-15', 'Female', 'Korean', 'Married', '2020-06-15', NULL, 'Active', 'approved', NULL, '2025-03-06 21:56:11', '2025-03-06 21:56:11'),
(3, '00005', 'Nayeon', 'C', 'Im', 'emp4@gmail.com', 'Finance', 'Sales Associate', '1234567890', '789 Pine St', '1995-09-22', 'Female', 'Korean', 'Single', '2023-02-01', NULL, 'Active', 'approved', NULL, '2025-03-06 21:56:11', '2025-03-06 21:56:11'),
(4, '00008', 'Dahyun', '', 'Kim', 'emp7@gmail.com', 'Purchasing', 'Account Executive', '4561230987', '101 Birch St', '1998-05-28', 'Female', 'Korean', 'Single', '2022-07-01', NULL, 'Active', 'approved', NULL, '2025-03-06 21:56:11', '2025-03-06 21:56:11'),
(5, '00009', 'Chaeyoung', 'G', 'Son', 'emp8@gmail.com', 'Inventory Management', 'Vendor Relations Coordinator', '9870123456', '202 Cedar St', '1999-08-23', 'Female', 'Korean', 'Single', '2021-09-12', NULL, 'Active', 'approved', NULL, '2025-03-06 21:56:11', '2025-03-06 21:56:11'),
(6, '00002', 'Sana', 'A', 'Minatozaki', 'emp1@gmail.com', 'Inventory Management', 'Product Manager', '1234567890', '123 Main St', '1990-01-01', 'Female', 'Japanese', 'Single', '2023-01-01', NULL, 'Active', 'approved', NULL, '2025-03-06 21:56:11', '2025-03-06 21:56:11'),
(7, '00007', 'Mina', 'E', 'Myoui', 'emp6@gmail.com', 'Customer Service', 'Product Manager', '1230987654', '789 Oak St', '1996-03-24', 'Female', 'Japanese', 'Single', '2023-05-01', NULL, 'Active', 'approved', NULL, '2025-03-06 21:56:11', '2025-03-06 21:56:11'),
(8, '00006', 'Jeongyeon', 'D', 'Yoo', 'emp5@gmail.com', 'Human Resources', 'Brand Manager', '0987654321', '456 Maple St', '1996-11-01', 'Female', 'Korean', 'Single', '2022-03-15', NULL, 'Active', 'approved', NULL, '2025-03-06 21:56:11', '2025-03-06 21:56:11'),
(186, '9', 'Michael', 'J.', 'Johnson', 'michael@example.com', 'Finance', 'Accountant', '0987654321', '789 Street, CA', '1988-07-22', 'Male', 'American', 'Married', '2022-05-01', NULL, 'Active', 'approved', 'michael.jpg', '2025-03-09 08:13:00', '2025-03-09 08:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `trainees`
--

CREATE TABLE `trainees` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainees`
--

INSERT INTO `trainees` (`id`, `full_name`, `email`, `department`, `workshop_id`, `created_at`) VALUES
(88, 'Jorish  Catacutan', 'delatorrejuliuservin9@gmail.com', 'Sales Department', 35, '2025-03-08 03:24:46'),
(89, 'Julius Ervin B Dela Torre', 'delatorrejuliuservin8@gmail.com', 'IT Department', 35, '2025-03-08 06:13:20'),
(90, 'Calimlim Charles   Kevin', 'bogart1248@gmail.com', 'IT Department', 35, '2025-03-08 06:15:13'),
(91, 'Christian Jay b Noora', 'jaynoora06@gmail.com', 'N/A', 36, '2025-03-08 06:15:28'),
(92, 'Argie  O Tapalla', 'whoaminothingnew546@gmail.com', 'IT Department', 39, '2025-03-17 15:15:34');

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `mentor` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `venue` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`id`, `title`, `mentor`, `category_id`, `description`, `date`, `time`, `created_at`, `venue`) VALUES
(42, 'Company Orientation Training', 'HR Manager', 35, 'Introduces employees to the company’s mission, vision, values, policies, and benefits. Provides an overview of the organizational structure and key personnel', '2025-03-10', '08:00:00', '2025-03-08 03:23:15', 'TRAINING ROOM1'),
(43, 'Customer Service Training', 'HR Head', 36, 'Provides employees with techniques for handling customer inquiries, complaints, and service excellence. Improves client interaction and problem-solving skills.', '2024-01-10', '02:00:00', '2025-03-08 06:04:34', 'PICC'),
(44, 'Network', 'Jorish', 38, 'For Computer parts', '2024-12-31', '15:22:00', '2025-03-12 06:08:00', 'PICC'),
(45, 'HEHEHEHE', 'ajdhushuf', 39, 'siufhidhiofd', '2025-03-07', '11:18:00', '2025-03-17 15:14:50', 'sjdhsdh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainee_id` (`trainee_id`),
  ADD KEY `workshop_id` (`workshop_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `employeeseval`
--
ALTER TABLE `employeeseval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_hired_employees`
--
ALTER TABLE `new_hired_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `performance_evaluations`
--
ALTER TABLE `performance_evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainee_id` (`trainee_id`),
  ADD KEY `workshop_id` (`workshop_id`);

--
-- Indexes for table `performance_statistics`
--
ALTER TABLE `performance_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trainee_id` (`trainee_id`);

--
-- Indexes for table `regular_employees`
--
ALTER TABLE `regular_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- Indexes for table `trainees`
--
ALTER TABLE `trainees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `workshop_id` (`workshop_id`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `employeeseval`
--
ALTER TABLE `employeeseval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `new_hired_employees`
--
ALTER TABLE `new_hired_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1075;

--
-- AUTO_INCREMENT for table `performance_evaluations`
--
ALTER TABLE `performance_evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `performance_statistics`
--
ALTER TABLE `performance_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regular_employees`
--
ALTER TABLE `regular_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `trainees`
--
ALTER TABLE `trainees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`trainee_id`) REFERENCES `trainees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `performance_evaluations`
--
ALTER TABLE `performance_evaluations`
  ADD CONSTRAINT `performance_evaluations_ibfk_1` FOREIGN KEY (`trainee_id`) REFERENCES `trainees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `performance_evaluations_ibfk_2` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `performance_statistics`
--
ALTER TABLE `performance_statistics`
  ADD CONSTRAINT `performance_statistics_ibfk_1` FOREIGN KEY (`trainee_id`) REFERENCES `trainees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trainees`
--
ALTER TABLE `trainees`
  ADD CONSTRAINT `trainees_ibfk_1` FOREIGN KEY (`workshop_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `workshops`
--
ALTER TABLE `workshops`
  ADD CONSTRAINT `workshops_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
