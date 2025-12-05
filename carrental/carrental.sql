-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2025 at 01:51 PM
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
-- Database: `carrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '5c428d8875d2948607f3e3fe134d71b4', '2024-05-01 12:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `tblbooking`
--

CREATE TABLE `tblbooking` (
  `id` int(11) NOT NULL,
  `BookingNumber` bigint(12) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `VehicleId` int(11) DEFAULT NULL,
  `FromDate` varchar(20) DEFAULT NULL,
  `ToDate` varchar(20) DEFAULT NULL,
  `PickupLocation` varchar(255) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `NationalIdPath` varchar(255) DEFAULT NULL,
  `DrivingLicensePath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblbooking`
--

INSERT INTO `tblbooking` (`id`, `BookingNumber`, `userEmail`, `VehicleId`, `FromDate`, `ToDate`, `PickupLocation`, `message`, `Status`, `PostingDate`, `LastUpdationDate`, `NationalIdPath`, `DrivingLicensePath`) VALUES
(1, 443108139, 'amikt12@gmail.com', 2, '2024-06-08', '2024-06-10', '', 'I want booking', 1, '2024-06-05 05:32:39', '2024-06-05 05:34:08', NULL, NULL),
(2, 962028078, 'garima132@gmail.com', 5, '2025-05-31', '2025-06-03', '', 'no', 0, '2025-05-30 17:38:53', NULL, NULL, NULL),
(3, 105888144, 'garima132@gmail.com', 4, '2025-06-02', '2025-06-06', '', 'i want quick response', 0, '2025-05-31 08:53:32', NULL, 'admin/uploads/683ac38c25155_img3.jpg', 'admin/uploads/683ac38c2515d_img4.jpg'),
(4, 824842734, 'garima132@gmail.com', 6, '2025-06-01', '2025-06-03', '', 'fast and furious', 0, '2025-05-31 08:55:58', NULL, 'admin/uploads/683ac41e5fba3_about_us_img2.jpg', 'admin/uploads/683ac41e5fbab_about_us_img3.jpg'),
(5, 174235208, 'garima132@gmail.com', 3, '2025-06-01', '2025-06-03', '', 'fairy bye bye', 0, '2025-05-31 09:24:52', NULL, 'admin/uploads/documents/683acae4b9691_about_us_img2.jpg', 'admin/uploads/documents/683acae4b969a_about_us_img3.jpg'),
(6, 729332353, 'max984103@gmail.com', 2, '2025-06-01', '2025-06-02', '', '', 0, '2025-05-31 10:50:30', NULL, 'admin/uploads/documents/683adef6da0e3_about_us_img1.jpg', 'admin/uploads/documents/683adef6da0eb_about_services_faq_bg.jpg'),
(7, 222443492, 'max984103@gmail.com', 6, '2025-06-05', '2025-06-07', '', 'please kam garde bro', 0, '2025-05-31 17:55:38', NULL, 'admin/uploads/documents/683b429a14f87_DALL·E 2024-08-31 18.09.17 - A modern, clean logo for a website called Bookworm. The logo features a stylized, friendly worm with glasses coiled around an open book, giving it a.png', 'admin/uploads/documents/683b429a14f90_Untitled Diagram.drawio.png'),
(8, 410584759, 'max984103@gmail.com', 4, '2025-06-07', '2025-06-07', '', 'work', 1, '2025-05-31 18:00:05', '2025-05-31 18:59:56', 'admin/uploads/documents/683b43a5a3e85_54ce8c55988406cb3fcd77e38ffc2385.jpg', 'admin/uploads/documents/683b43a5a3e8f_fcac5283-a49b-4290-999f-e1710eaa697f.jfif'),
(9, 443108139, 'amikt12@gmail.com', 2, '2025-05-05', '2025-05-12', '', 'I want booking', 1, '2025-05-04 23:47:39', '2025-05-05 10:25:32', NULL, NULL),
(10, 143905793, 'sujata23@gmail.com', 4, '2025-05-13', '2025-05-15', '', 'I want booking', 1, '2025-05-12 10:16:57', '2025-05-12 11:22:37', NULL, NULL),
(11, 440288054, 'sujata23@gmail.com', 1, '2025-05-30', '2025-06-06', '', 'nothing', 1, '2025-05-24 12:45:19', '2025-05-24 12:57:26', NULL, NULL),
(12, 790256163, 'garima23@gmail.com', 8, '2025-05-10', '2025-05-15', '', 'Booking\r\n', 1, '2025-05-08 05:30:08', '2025-05-15 05:31:37', 'admin/uploads/documents/683ae4bcb1528_494858020_2511884079149357_7312175754438137371_n.png', 'admin/uploads/documents/683ae4bcb16f3_494858020_2511884079149357_7312175754438137371_n.png'),
(13, 178034863, 'garima23@gmail.com', 5, '2025-05-07', '2025-05-12', '', 'Book', 1, '2025-05-06 06:44:37', '2025-05-31 05:54:16', 'admin/uploads/documents/683ae821a3df9_logo.png', 'admin/uploads/documents/683ae821a419a_logo.png'),
(14, 548443421, 'pranisha23@gmail.com', 7, '2025-05-14', '2025-05-25', '', 'Nothing', 1, '2025-05-12 20:58:11', '2025-05-31 06:00:08', 'admin/uploads/documents/683aeb4f7c11e_unnamed.jpg', 'admin/uploads/documents/683aeb4f7c12b_unnamed.jpg'),
(15, 634705556, 'kri23@gmail.com', 3, '2025-06-01', '2025-06-04', '', 'No', 1, '2025-05-31 09:51:50', '2025-05-31 11:32:55', 'admin/uploads/documents/683b2212ee1b3_hi.jpg', 'admin/uploads/documents/683b2212ee1c3_fg.jpg'),
(16, 580622132, 'ram123@gmail.com', 3, '2025-06-01', '2025-06-05', '', 'NO', 1, '2025-05-31 11:50:24', '2025-05-31 11:58:27', 'admin/uploads/documents/683b3ddce62e9_494858020_2511884079149357_7312175754438137371_n.png', 'admin/uploads/documents/683b3ddce62ed_494858020_2511884079149357_7312175754438137371_n.png'),
(17, 179216486, 'hari33@gmail.com', 7, '2025-05-15', '2025-05-20', '', 'No', 1, '2025-05-14 09:14:21', '2025-05-14 09:14:43', 'admin/uploads/documents/683b4379c6331_fg.jpg', 'admin/uploads/documents/683b4379c6579_de.jpg'),
(18, 624044079, 'max984103@gmail.com', 7, '2025-06-17', '2025-06-18', 'kalimati chowk', 'workwork', 0, '2025-05-31 19:23:47', NULL, 'admin/uploads/documents/683b57438f8a3_Gantt.drawio.png', 'admin/uploads/documents/683b57438f8ac_er_diagram.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblbrands`
--

CREATE TABLE `tblbrands` (
  `id` int(11) NOT NULL,
  `BrandName` varchar(120) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblbrands`
--

INSERT INTO `tblbrands` (`id`, `BrandName`, `CreationDate`, `UpdationDate`) VALUES
(1, 'Maruti', '2024-05-01 16:24:34', '2024-06-05 05:26:25'),
(2, 'BMW', '2024-05-01 16:24:34', '2024-06-05 05:26:34'),
(3, 'Audi', '2024-05-01 16:24:34', '2024-06-05 05:26:34'),
(4, 'Nissan', '2024-05-01 16:24:34', '2024-06-05 05:26:34'),
(5, 'Toyota', '2024-05-01 16:24:34', '2024-06-05 05:26:34'),
(7, 'Volkswagon', '2024-05-01 16:24:34', '2024-06-05 05:26:34'),
(8, 'Honda', '2025-05-20 15:45:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontactusinfo`
--

CREATE TABLE `tblcontactusinfo` (
  `id` int(11) NOT NULL,
  `Address` tinytext DEFAULT NULL,
  `EmailId` varchar(255) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcontactusinfo`
--

INSERT INTO `tblcontactusinfo` (`id`, `Address`, `EmailId`, `ContactNo`) VALUES
(1, 'J&K Block, Mahalaxmi Chowk', 'info@gmail.com', '9874561236');

-- --------------------------------------------------------

--
-- Table structure for table `tblcontactusquery`
--

CREATE TABLE `tblcontactusquery` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `ContactNumber` char(11) DEFAULT NULL,
  `Message` longtext DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcontactusquery`
--

INSERT INTO `tblcontactusquery` (`id`, `name`, `EmailId`, `ContactNumber`, `Message`, `PostingDate`, `status`) VALUES
(1, 'Kunal ', 'kunal@gmail.com', '7977779798', 'I want to know you brach in Chandigarh?', '2024-06-04 09:34:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `PageName` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `detail` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`id`, `PageName`, `type`, `detail`) VALUES
(1, 'Terms and Conditions', 'terms', '<P align=justify><FONT size=2><STRONG><FONT color=#990000>(1) ACCEPTANCE OF TERMS</FONT><BR><BR></STRONG>Welcome to Yahoo! India. 1Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: <A href=\"http://in.docs.yahoo.com/info/terms/\">http://in.docs.yahoo.com/info/terms/</A>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>\r\n<P align=justify><FONT size=2>Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: </FONT><A href=\"http://in.docs.yahoo.com/info/terms/\"><FONT size=2>http://in.docs.yahoo.com/info/terms/</FONT></A><FONT size=2>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>\r\n<P align=justify><FONT size=2>Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: </FONT><A href=\"http://in.docs.yahoo.com/info/terms/\"><FONT size=2>http://in.docs.yahoo.com/info/terms/</FONT></A><FONT size=2>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>'),
(2, 'Privacy Policy', 'privacy', '<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</span>'),
(3, 'About Us ', 'aboutus', '																																								<div><p class=\"MsoNormal\">Welcome to Drive Ease Nepal, Nepal’s largest self-drive\r\nvehicle rental service provider! With over a decade of experience and the\r\nlargest fleet of vehicles in the country, we are here to revolutionize your\r\ntravel experience. Whether you need a car for a day, a week, a month, or even a\r\nyear, we offer unparalleled flexibility, affordability, and quality to cater to\r\nall your vehicle rental needs.<o:p></o:p></p><p class=\"MsoNormal\"><span style=\"font-size: 1em;\">Our commitment to customer safety and satisfaction is at the\r\ncore of everything we do.</span><span style=\"font-size: 1em;\">&nbsp; </span><span style=\"font-size: 1em;\">We ensure the\r\nhighest safety, security, and technology standards. Our 24/7 support system\r\nguarantees peace of mind no matter where you are or when you need assistance.</span></p><p class=\"MsoNormal\"><span style=\"font-size: 1em;\">From daily commutes to long-term rentals, Car Rental Nepal\r\noffers flexible pricing plans tailored to your needs. Whether you\'re exploring\r\nNepal’s beautiful landscapes, attending business meetings, or running errands,\r\nwe ensure you have access to the best vehicles at the best rates.</span></p></div>\r\n										\r\n										\r\n										\r\n										\r\n										'),
(11, 'FAQs', 'faqs', '																														<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Address------Test &nbsp; &nbsp;dsfdsfds</span>');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubscribers`
--

CREATE TABLE `tblsubscribers` (
  `id` int(11) NOT NULL,
  `SubscriberEmail` varchar(120) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubscribers`
--

INSERT INTO `tblsubscribers` (`id`, `SubscriberEmail`, `PostingDate`) VALUES
(4, 'harish@gmail.com', '2024-06-01 09:26:21'),
(5, 'kunal@gmail.com', '2024-05-31 09:35:07'),
(6, 'test@gmail.com', '2025-05-20 16:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbltestimonial`
--

CREATE TABLE `tbltestimonial` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `Testimonial` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbltestimonial`
--

INSERT INTO `tbltestimonial` (`id`, `UserEmail`, `Testimonial`, `PostingDate`, `status`) VALUES
(1, 'garima132@gmail.com', 'had a great experience with this whole thing. good to go cars, easy booking process, proper per day rates', '2025-05-30 14:14:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `EmailId`, `Password`, `ContactNo`, `dob`, `Address`, `City`, `Country`, `RegDate`, `UpdationDate`) VALUES
(1, 'Test', 'test@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '6465465465', '', 'Khusibu, Kathmandu', 'Kathmandu', 'Nepal', '2024-05-01 14:00:49', '2025-05-20 15:42:31'),
(2, 'Amit', 'amikt12@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '1425365214', NULL, NULL, NULL, NULL, '2024-06-05 05:31:05', NULL),
(5, 'Garima Hamal', 'garima132@gmail.com', '202cb962ac59075b964b07152d234b70', '9800000000', NULL, NULL, NULL, NULL, '2025-05-30 14:08:29', NULL),
(8, 'Max momo', 'max984103@gmail.com', '202cb962ac59075b964b07152d234b70', '9800000000', NULL, NULL, NULL, NULL, '2025-05-31 10:40:04', NULL),
(9, 'Pranisha', 'pranisha23@gmail.com', '202cb962ac59075b964b07152d234b70', '9800000002', NULL, NULL, NULL, NULL, '2025-05-11 08:41:11', NULL),
(10, 'Sujata Timsina', 'sujata23@gmail.com', '202cb962ac59075b964b07152d234b70', '9800000000', NULL, NULL, NULL, NULL, '2025-05-10 09:49:38', NULL),
(11, 'Kriti', 'kri23@gmail.com', '202cb962ac59075b964b07152d234b70', '9800000003', NULL, NULL, NULL, NULL, '2025-05-30 10:48:03', NULL),
(12, 'Garima Hamal', 'garima23@gmail.com', '202cb962ac59075b964b07152d234b70', '9800000001', NULL, NULL, NULL, NULL, '2025-05-05 03:49:21', NULL),
(13, 'Sujata Timsina', 'sujata233@gmail.com', '202cb962ac59075b964b07152d234b70', '9800000006', NULL, NULL, NULL, NULL, '2025-05-30 11:11:39', NULL),
(14, 'Sujata Timsina', 'garimass23@gmail.com', '202cb962ac59075b964b07152d234b70', '9800000009', NULL, NULL, NULL, NULL, '2025-05-30 12:03:49', NULL),
(15, 'Ram Bahadur', 'ram123@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '9876543211', NULL, NULL, NULL, NULL, '2025-05-31 11:48:44', NULL),
(16, 'Hari Bahadur', 'hari33@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '9876543212', NULL, NULL, NULL, NULL, '2025-05-13 03:12:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblvehicles`
--

CREATE TABLE `tblvehicles` (
  `id` int(11) NOT NULL,
  `VehiclesTitle` varchar(150) DEFAULT NULL,
  `VehiclesBrand` int(11) DEFAULT NULL,
  `VehiclesOverview` longtext DEFAULT NULL,
  `PricePerDay` int(11) DEFAULT NULL,
  `FuelType` varchar(100) DEFAULT NULL,
  `ModelYear` int(6) DEFAULT NULL,
  `SeatingCapacity` int(11) DEFAULT NULL,
  `Vimage1` varchar(120) DEFAULT NULL,
  `Vimage2` varchar(120) DEFAULT NULL,
  `Vimage3` varchar(120) DEFAULT NULL,
  `Vimage4` varchar(120) DEFAULT NULL,
  `Vimage5` varchar(120) DEFAULT NULL,
  `AirConditioner` int(11) DEFAULT NULL,
  `PowerDoorLocks` int(11) DEFAULT NULL,
  `AntiLockBrakingSystem` int(11) DEFAULT NULL,
  `BrakeAssist` int(11) DEFAULT NULL,
  `PowerSteering` int(11) DEFAULT NULL,
  `DriverAirbag` int(11) DEFAULT NULL,
  `PassengerAirbag` int(11) DEFAULT NULL,
  `PowerWindows` int(11) DEFAULT NULL,
  `CDPlayer` int(11) DEFAULT NULL,
  `CentralLocking` int(11) DEFAULT NULL,
  `CrashSensor` int(11) DEFAULT NULL,
  `LeatherSeats` int(11) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblvehicles`
--

INSERT INTO `tblvehicles` (`id`, `VehiclesTitle`, `VehiclesBrand`, `VehiclesOverview`, `PricePerDay`, `FuelType`, `ModelYear`, `SeatingCapacity`, `Vimage1`, `Vimage2`, `Vimage3`, `Vimage4`, `Vimage5`, `AirConditioner`, `PowerDoorLocks`, `AntiLockBrakingSystem`, `BrakeAssist`, `PowerSteering`, `DriverAirbag`, `PassengerAirbag`, `PowerWindows`, `CDPlayer`, `CentralLocking`, `CrashSensor`, `LeatherSeats`, `RegDate`, `UpdationDate`) VALUES
(1, 'Maruti Suzuki Wagon R', 1, 'Maruti Wagon R Latest Updates\r\n\r\nMaruti Suzuki has launched the BS6 Wagon R S-CNG in India. The LXI CNG and LXI (O) CNG variants now cost Rs 5.25 lakh and Rs 5.32 lakh respectively, up by Rs 19,000. Maruti claims a fuel economy of 32.52km per kg. The CNG Wagon R’s continuation in the BS6 era is part of the carmaker’s ‘Mission Green Million’ initiative announced at Auto Expo 2020.\r\n\r\nPreviously, the carmaker had updated the 1.0-litre powertrain to meet BS6 emission norms. It develops 68PS of power and 90Nm of torque, same as the BS4 unit. However, the updated motor now returns 21.79 kmpl, which is a little less than the BS4 unit’s 22.5kmpl claimed figure. Barring the CNG variants, the prices of the Wagon R 1.0-litre have been hiked by Rs 8,000.', 500, 'Petrol', 2019, 5, 'rear-3-4-left-589823254_930x620.jpg', 'tail-lamp-1666712219_930x620.jpg', 'rear-3-4-right-520328200_930x620.jpg', 'steering-close-up-1288209207_930x620.jpg', 'boot-with-standard-luggage-202327489_930x620.jpg', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2024-05-10 07:04:35', '2024-06-05 05:30:19'),
(2, 'BMW 5 Series', 2, 'BMW 5 Series price starts at ? 55.4 Lakh and goes upto ? 68.39 Lakh. The price of Petrol version for 5 Series ranges between ? 55.4 Lakh - ? 60.89 Lakh and the price of Diesel version for 5 Series ranges between ? 60.89 Lakh - ? 68.39 Lakh.', 1000, 'Petrol', 2018, 5, 'BMW-5-Series-Exterior-102005.jpg', 'BMW-5-Series-New-Exterior-89729.jpg', 'BMW-5-Series-Exterior-102006.jpg', 'BMW-5-Series-Interior-102021.jpg', 'BMW-5-Series-Interior-102022.jpg', 1, 1, 1, 1, 1, 1, 1, 1, NULL, 1, 1, 1, '2024-05-10 07:04:35', '2024-06-05 05:30:33'),
(3, 'Audi Q8', 3, 'As per ARAI, the mileage of Q8 is 0 kmpl. Real mileage of the vehicle varies depending upon the driving habits. City and highway mileage figures also vary depending upon the road conditions.', 3000, 'Petrol', 2017, 5, 'audi-q8-front-view4.jpg', '1920x1080_MTC_XL_framed_Audi-Odessa-Armaturen_Spiegelung_CC_v05.jpg', 'audi1.jpg', '1audiq8.jpg', 'audi-q8-front-view4.jpeg', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2024-05-10 07:04:35', '2024-06-05 05:30:33'),
(4, 'Nissan Kicks', 4, 'Latest Update: Nissan has launched the Kicks 2020 with a new turbocharged petrol engine. You can read more about it here.\r\n\r\nNissan Kicks Price and Variants: The Kicks is available in four variants: XL, XV, XV Premium, and XV Premium(O).', 800, 'Petrol', 2020, 5, 'front-left-side-47.jpg', 'kicksmodelimage.jpg', 'download.jpg', 'kicksmodelimage.jpg', '', 1, NULL, NULL, 1, NULL, NULL, 1, 1, NULL, NULL, NULL, 1, '2024-05-10 07:04:35', '2024-06-05 05:30:33'),
(5, 'Nissan GT-R', 4, ' The GT-R packs a 3.8-litre V6 twin-turbocharged petrol, which puts out 570PS of max power at 6800rpm and 637Nm of peak torque. The engine is mated to a 6-speed dual-clutch transmission in an all-wheel-drive setup. The 2+2 seater GT-R sprints from 0-100kmph in less than 3', 2000, 'Petrol', 2019, 5, 'Nissan-GTR-Right-Front-Three-Quarter-84895.jpg', 'Best-Nissan-Cars-in-India-New-and-Used-1.jpg', '2bb3bc938e734f462e45ed83be05165d.jpg', '2020-nissan-gtr-rakuda-tan-semi-aniline-leather-interior.jpg', 'images.jpg', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2024-05-10 07:04:35', '2024-06-05 05:30:33'),
(6, 'Nissan Sunny 2020', 4, 'Value for money product and it was so good It is more spacious than other sedans It looks like a luxurious car.', 400, 'CNG', 2018, 5, 'Nissan-Sunny-Right-Front-Three-Quarter-48975_ol.jpg', 'images (1).jpg', 'Nissan-Sunny-Interior-114977.jpg', 'nissan-sunny-8a29f53-500x375.jpg', 'new-nissan-sunny-photo.jpg', 1, 1, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2024-05-10 07:04:35', '2024-06-05 05:30:33'),
(7, 'Toyota Fortuner', 5, 'Toyota Fortuner Features: It is a premium seven-seater SUV loaded with features such as LED projector headlamps with LED DRLs, LED fog lamp, and power-adjustable and foldable ORVMs. Inside, the Fortuner offers features such as power-adjustable driver seat, automatic climate control, push-button stop/start, and cruise control.\r\n\r\nToyota Fortuner Safety Features: The Toyota Fortuner gets seven airbags, hill assist control, vehicle stability control with brake assist, and ABS with EBD.', 3000, 'Petrol', 2020, 5, '2015_Toyota_Fortuner_(New_Zealand).jpg', 'toyota-fortuner-legender-rear-quarters-6e57.jpg', 'zw-toyota-fortuner-2020-2.jpg', 'download (1).jpg', '', NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 1, 1, 1, '2024-05-10 07:04:35', '2024-06-05 05:30:33'),
(8, 'Maruti Suzuki Vitara Brezza', 1, 'The new Vitara Brezza is a well-rounded package that is feature-loaded and offers good drivability. And it is backed by Maruti’s vast service network, which ensures a peace of mind to customers. The petrol motor could have been more refined and offered more pep.', 600, 'Petrol', 2018, 5, 'marutisuzuki-vitara-brezza-right-front-three-quarter3.jpg', 'marutisuzuki-vitara-brezza-rear-view37.jpg', 'marutisuzuki-vitara-brezza-dashboard10.jpg', 'marutisuzuki-vitara-brezza-boot-space59.jpg', 'marutisuzuki-vitara-brezza-boot-space28.jpg', NULL, 1, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, '2024-05-10 07:04:35', '2024-06-05 05:30:33'),
(9, 'Honda Odyssey', 8, 'The Honda Odyssey is a popular minivan known for its family-friendly features, comfortable ride, and reliable performance. It offers a spacious and flexible interior with clever seating configurations, including the Magic Slide second-row seats, and ample cargo space. The Odyssey also boasts a smooth and powerful V6 engine, a 10-speed automatic transmission, and various technology features, like a rear-seat entertainment system and Honda Sensing safety features. ', 1000, 'Petrol', 2025, 8, 'hOimg-1', 'hOimg-2', 'hOimg-3', 'hOimg-4', 'hOimg-5', 1, 1, NULL, 1, 1, 1, 1, 1, 1, NULL, NULL, 1, '2025-05-20 15:57:14', '2025-05-20 15:58:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbrands`
--
ALTER TABLE `tblbrands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcontactusinfo`
--
ALTER TABLE `tblcontactusinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsubscribers`
--
ALTER TABLE `tblsubscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltestimonial`
--
ALTER TABLE `tbltestimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailId` (`EmailId`);

--
-- Indexes for table `tblvehicles`
--
ALTER TABLE `tblvehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblbrands`
--
ALTER TABLE `tblbrands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblcontactusinfo`
--
ALTER TABLE `tblcontactusinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblsubscribers`
--
ALTER TABLE `tblsubscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbltestimonial`
--
ALTER TABLE `tbltestimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblvehicles`
--
ALTER TABLE `tblvehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
