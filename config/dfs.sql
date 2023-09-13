-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 13, 2023 at 10:41 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dfs`
--

-- --------------------------------------------------------

--
-- Table structure for table `business_proof_documents`
--

DROP TABLE IF EXISTS `business_proof_documents`;
CREATE TABLE IF NOT EXISTS `business_proof_documents` (
  `License_ID` int NOT NULL AUTO_INCREMENT,
  `document` varchar(200) NOT NULL,
  `User_ID` int NOT NULL,
  `upload_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(30) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`License_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `business_proof_documents`
--

INSERT INTO `business_proof_documents` (`License_ID`, `document`, `User_ID`, `upload_date`, `status`) VALUES
(1, 'uploads_license/LicenceAli.jpeg', 5, '2023-09-08 17:17:30', 'Reject'),
(2, 'uploads_license/LicenseAbu.jpeg', 2, '2023-09-08 18:00:00', 'Reject'),
(3, 'uploads_license/LicenseAkau.png', 3, '2023-09-08 22:36:04', 'Pending'),
(6, 'uploads_license/certofcompletion.jpg', 12, '2023-09-13 18:09:02', 'Pending'),
(5, 'uploads_license/wushucert.jpeg', 11, '2023-09-13 17:58:50', 'Pending'),
(7, 'uploads_license/certofcompletion.jpg', 13, '2023-09-13 18:22:27', 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `document_details`
--

DROP TABLE IF EXISTS `document_details`;
CREATE TABLE IF NOT EXISTS `document_details` (
  `Document_ID` int NOT NULL AUTO_INCREMENT,
  `document` varchar(200) NOT NULL,
  `document_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Normal',
  `Sender_ID` int NOT NULL,
  `Receiver_ID` int NOT NULL,
  `upload_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Document_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `document_details`
--

INSERT INTO `document_details` (`Document_ID`, `document`, `document_type`, `status`, `Sender_ID`, `Receiver_ID`, `upload_date`) VALUES
(1, 'uploads/cert.jpeg', 'Verified Document', 'Normal', 1, 1, '2023-09-01 17:26:16'),
(2, 'uploads/cert.jpeg', 'Unverified Document', 'Normal', 2, 2, '2023-09-01 17:26:16'),
(4, 'uploads/certofcompletion.jpg', 'Unverified Document', 'Normal', 2, 2, '2023-09-02 17:26:16'),
(5, 'uploads/cert2.jpg', 'Unverified Document', 'Normal', 2, 2, '2023-09-02 17:26:16'),
(13, 'uploads/CertificateNEUC.jpg', 'Unverified Document', 'Normal', 2, 2, '2023-09-02 17:26:16'),
(26, 'uploads/wushucert.jpeg', 'Unverified Document', 'Normal', 2, 2, '2023-09-13 18:24:12'),
(18, 'uploads/CertificateNEUC.jpg', 'Verified Document', 'Normal', 7, 7, '2023-09-08 17:57:18'),
(19, 'uploads/cert2.jpg', 'Verified Document', 'Normal', 7, 4, '2023-09-08 18:34:50'),
(21, 'uploads/wushucert.jpeg', 'Unverified Document', 'Normal', 9, 9, '2023-09-13 17:52:00'),
(27, 'uploads/wushucert.jpeg', 'Verified Document', 'Normal', 7, 13, '2023-09-13 18:26:57'),
(20, 'uploads/cert2.jpg', 'Unverified Document', 'Normal', 3, 3, '2023-09-08 22:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `User_ID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `linked_email_1` varchar(100) NOT NULL,
  `linked_email_2` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Recipient',
  `bio` varchar(100) NOT NULL,
  `profile_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'No profile',
  PRIMARY KEY (`User_ID`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `username`, `email`, `linked_email_1`, `linked_email_2`, `phone_number`, `password`, `role`, `bio`, `profile_image`) VALUES
(5, 'mohammadali', 'mohammadali@gmail.com', '', '', '011-43532545', '$2y$10$gDEdrXDkSEeMr3Lf5U2ObuKXdM.1XMU6bAdKgZjHjDJi0bkuI71qW', 'Issuer', '', 'profile/64f2f11ce3705_colgate.jpg'),
(2, 'mohammadabu', 'mohammadabu@gmail.com', 'testing@gmail.com', '', '011-11232433', '$2y$10$vXqfLLkKgPzp7DDEd.kA.O3.49DkQavdVzyZkykxxYGuEOGqVZgey', 'Recipient', 'Hi, nice to meet you all. ', 'No profile'),
(3, 'akau1', 'akau@gmail.com', '', '', '018-433433131', '$2y$10$HrfBlgmR/jaw4KnCYbf6aug2OuFBgJVO4YgKrN00IEz1POiiDzZWW', 'Recipient', '', 'No profile'),
(4, 'jesuslim', 'jesuslim@gmail.com', '', '', '018-76576661', '$2y$10$NFkOrp/Y8NTdpSf120wNweBsrpJhSZ7xQI.ONIAqK5wN2ZlXcp1VO', 'Recipient', '', 'No profile'),
(1, 'Admin', 'admin@gmail.com', '', '', '011-1234897', '$2y$10$lZtWfEX8jxC7iv5/G0/qD.IaECz4E9K1KM7hipW4ys7rgMhKvSMN.', 'Admin', '', 'No profile'),
(7, 'benjaminlim', 'benjaminlim@gmail.com', '', '', '011-12398743', '$2y$10$DGKUrXJehaVADmdfCh8dqOzv.K09igVIgnNmlngZvus9baNF3UKry', 'Issuer', '', 'No profile'),
(11, 'kienming916', 'tankienming0916@e.newera.edu.my', 'tankienming916@gmail.com', '', '011-69611730', '$2y$10$7c2m9pxmM3a7NMLspDeI..ZaibCtC8glr08p.0ptWCXs8Q9TJ.1jO', 'Issuer', 'Hi, nice to meet you all.', 'profile/6501880a5c9e7_cat.jpg'),
(12, 'alisonlim0511', 'alisonlim@gmail.com', 'alisonlim0511@gmail.com', '', '011-69611731', '$2y$10$ahhYm15jgK9qeryDbKKhceNAZVRZzZ2OUJ.0NrmLmOJ4VZCkt6n/q', 'Recipient', 'Hi, nice to meet you all.', 'profile/65018a6fd4434_cat.jpg'),
(13, 'yeezheng', 'yeezheng@gmail.com', 'limyeezheng@gmail.com', '', '011-69611731', '$2y$10$a9M1Lbm18uLLWf8Ms/jSD.xmpoeAHtHml1s4Ow95N9Fvqd5Uc0zki', 'Issuer', 'Hi, nice to meet you all.', 'profile/65018d8d5b539_cat.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
