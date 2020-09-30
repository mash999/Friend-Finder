-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2018 at 12:01 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `friend_finder`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `PRIMARY_ID` int(11) NOT NULL,
  `POST_ID` int(11) NOT NULL,
  `COMMENTED_BY` int(11) NOT NULL,
  `COMMENT` text NOT NULL,
  `ENTERED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`PRIMARY_ID`, `POST_ID`, `COMMENTED_BY`, `COMMENT`, `ENTERED_AT`) VALUES
(1, 14, 3, 'great  photos', '2018-10-05 14:20:54'),
(2, 14, 2, 'indeed. loved them', '2018-10-05 14:20:54'),
(3, 16, 4, 'what else is new', '2018-10-05 14:21:48'),
(4, 16, 2, 'maybe something he picked at gandhi vile', '2018-10-05 14:21:48'),
(5, 16, 3, 'how can you be so racist? ', '2018-10-05 14:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `PRIMARY_KEY` int(11) NOT NULL,
  `COUNTRY_CODE` varchar(4) NOT NULL,
  `COUNTRY_NAME` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`PRIMARY_KEY`, `COUNTRY_CODE`, `COUNTRY_NAME`) VALUES
(1, 'AFG', 'Afghanistan\r\n'),
(2, 'ALA', 'Aland Islands\r\n'),
(3, 'ALB', 'Albania\r\n'),
(4, 'DZA', 'Algeria\r\n'),
(5, 'ASM', 'American Samoa\r\n'),
(6, 'AND', 'Andorra\r\n'),
(7, 'AGO', 'Angola\r\n'),
(8, 'AIA', 'Anguilla\r\n'),
(9, 'ATA', 'Antarctica\r\n'),
(10, 'ATG', 'Antigua and Barbuda\r\n'),
(11, 'ARG', 'Argentina\r\n'),
(12, 'ARM', 'Armenia\r\n'),
(13, 'ABW', 'Aruba\r\n'),
(14, 'AUS', 'Australia\r\n'),
(15, 'AUT', 'Austria\r\n'),
(16, 'AZE', 'Azerbaijan\r\n'),
(17, 'BHS', 'Bahamas\r\n'),
(18, 'BHR', 'Bahrain\r\n'),
(19, 'BGD', 'Bangladesh\r\n'),
(20, 'BRB', 'Barbados\r\n'),
(21, 'BLR', 'Belarus\r\n'),
(22, 'BEL', 'Belgium\r\n'),
(23, 'BLZ', 'Belize\r\n'),
(24, 'BEN', 'Benin\r\n'),
(25, 'BMU', 'Bermuda\r\n'),
(26, 'BTN', 'Bhutan\r\n'),
(27, 'BOL', 'Bolivia, Plurinational State of\r\n'),
(28, 'BES', 'Bonaire, Sint Eustatius and Saba\r\n'),
(29, 'BIH', 'Bosnia and Herzegovina\r\n'),
(30, 'BWA', 'Botswana\r\n'),
(31, 'BVT', 'Bouvet Island\r\n'),
(32, 'BRA', 'Brazil\r\n'),
(33, 'IOT', 'British Indian Ocean Territory\r\n'),
(34, 'BRN', 'Brunei Darussalam\r\n'),
(35, 'BGR', 'Bulgaria\r\n'),
(36, 'BFA', 'Burkina Faso\r\n'),
(37, 'BDI', 'Burundi\r\n'),
(38, 'KHM', 'Cambodia\r\n'),
(39, 'CMR', 'Cameroon\r\n'),
(40, 'CAN', 'Canada\r\n'),
(41, 'CPV', 'Cape Verde\r\n'),
(42, 'CYM', 'Cayman Islands\r\n'),
(43, 'CAF', 'Central African Republic\r\n'),
(44, 'TCD', 'Chad\r\n'),
(45, 'CHL', 'Chile\r\n'),
(46, 'CHN', 'China\r\n'),
(47, 'CXR', 'Christmas Island\r\n'),
(48, 'CCK', 'Cocos (Keeling) Islands\r\n'),
(49, 'COL', 'Colombia\r\n'),
(50, 'COM', 'Comoros\r\n'),
(51, 'COG', 'Congo\r\n'),
(52, 'COD', 'Congo, the Democratic Republic of the\r\n'),
(53, 'COK', 'Cook Islands'),
(54, 'CRI', 'Costa Rica\r\n'),
(55, 'CIV', 'Cote d\'Ivoire'),
(56, 'HRV', 'Croatia\r\n'),
(57, 'CUB', 'Cuba\r\n'),
(58, 'CUW', 'Curacao\r\n'),
(59, 'CYP', 'Cyprus\r\n'),
(60, 'CZE', 'Czech Republic\r\n'),
(61, 'DNK', 'Denmark\r\n'),
(62, 'DJI', 'Djibouti\r\n'),
(63, 'DMA', 'Dominica\r\n'),
(64, 'DOM', 'Dominican Republic\r\n'),
(65, 'ECU', 'Ecuador\r\n'),
(66, 'EGY', 'Egypt\r\n'),
(67, 'SLV', 'El Salvador\r\n'),
(68, 'GNQ', 'Equatorial Guinea\r\n'),
(69, 'ERI', 'Eritrea\r\n'),
(70, 'EST', 'Estonia\r\n'),
(71, 'ETH', 'Ethiopia\r\n'),
(72, 'FLK', 'Falkland Islands (Malvinas)\r\n'),
(73, 'FRO', 'Faroe Islands\r\n'),
(74, 'FJI', 'Fiji\r\n'),
(75, 'FIN', 'Finland\r\n'),
(76, 'FRA', 'France\r\n'),
(77, 'GUF', 'French Guiana\r\n'),
(78, 'PYF', 'French Polynesia\r\n'),
(79, 'ATF', 'French Southern Territories\r\n'),
(80, 'GAB', 'Gabon\r\n'),
(81, 'GMB', 'Gambia\r\n'),
(82, 'GEO', 'Georgia\r\n'),
(83, 'DEU', 'Germany\r\n'),
(84, 'GHA', 'Ghana\r\n'),
(85, 'GIB', 'Gibraltar\r\n'),
(86, 'GRC', 'Greece\r\n'),
(87, 'GRL', 'Greenland\r\n'),
(88, 'GRD', 'Grenada\r\n'),
(89, 'GLP', 'Guadeloupe\r\n'),
(90, 'GUM', 'Guam\r\n'),
(91, 'GTM', 'Guatemala\r\n'),
(92, 'GGY', 'Guernsey\r\n'),
(93, 'GIN', 'Guinea\r\n'),
(94, 'GNB', 'Guinea-Bissau\r\n'),
(95, 'GUY', 'Guyana\r\n'),
(96, 'HTI', 'Haiti\r\n'),
(97, 'HMD', 'Heard Island and McDonald Islands\r\n'),
(98, 'VAT', 'Holy See (Vatican City State)\r\n'),
(99, 'HND', 'Honduras\r\n'),
(100, 'HKG', 'Hong Kong\r\n'),
(101, 'HUN', 'Hungary\r\n'),
(102, 'ISL', 'Iceland\r\n'),
(103, 'IND', 'India\r\n'),
(104, 'IDN', 'Indonesia\r\n'),
(105, 'IRN', 'Iran, Islamic Republic of\r\n'),
(106, 'IRQ', 'Iraq\r\n'),
(107, 'IRL', 'Ireland\r\n'),
(108, 'IMN', 'Isle of Man\r\n'),
(109, 'ISR', 'Israel\r\n'),
(110, 'ITA', 'Italy\r\n'),
(111, 'JAM', 'Jamaica\r\n'),
(112, 'JPN', 'Japan\r\n'),
(113, 'JEY', 'Jersey\r\n'),
(114, 'JOR', 'Jordan\r\n'),
(115, 'KAZ', 'Kazakhstan\r\n'),
(116, 'KEN', 'Kenya\r\n'),
(117, 'KIR', 'Kiribati\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `POST_ID` int(11) NOT NULL,
  `STATUS` text,
  `MEDIA_TYPE` tinyint(1) DEFAULT NULL,
  `MEDIA` text,
  `POSTED_BY` int(11) NOT NULL,
  `ENTERED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`POST_ID`, `STATUS`, `MEDIA_TYPE`, `MEDIA`, `POSTED_BY`, `ENTERED_AT`) VALUES
(14, '', 1, '\\{}/5bb3a95c746c342282167_310836663042326_7591095502993620992_n.jpg\\{}/5bb3a95c748fcimage.png', 1, '2018-10-02 17:53:13'),
(15, 'You gotta see this. ROFL. Hillarious man... ', 2, '\\{}/1.mp4', 1, '2018-10-02 17:53:13'),
(16, 'watching the big bang theory..  an rajesh koothrapali is being all male like (s)he always does and penny being penny.. :/ &lt;br /&gt;\r\n&lt;br /&gt;\r\n#season_5, #episode19', 0, NULL, 1, '2018-10-05 13:18:28'),
(17, 'weekend comes after a long long week.. don\'t know why i always waste one of the days sleeping from morning to night... sad little life.. &lt;br /&gt;\r\n&lt;br /&gt;\r\nPic for attention', 1, '\\{}/5bb7653373481bg.jpg\\{}/5bb3a95c746c342282167_310836663042326_7591095502993620992_n.jpg\\{}/5bb3a95c748fcimage.png\\{}/5bb3a95c746c342282167_310836663042326_7591095502993620992_n.jpg\\{}/5bb3a95c748fcimage.png', 1, '2018-10-05 13:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `PRIMARY_ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(30) NOT NULL,
  `LAST_NAME` varchar(30) NOT NULL,
  `E_MAIL` varchar(90) NOT NULL,
  `PASSWORD` text NOT NULL,
  `DOB` date NOT NULL,
  `PROFILE_PICTURE` text,
  `COVER_PICTURE` text NOT NULL,
  `BIO` text,
  `PROFESSION` varchar(150) DEFAULT NULL,
  `GENDER` varchar(10) NOT NULL,
  `CITY` varchar(50) NOT NULL,
  `COUNTRY` varchar(50) DEFAULT NULL,
  `ACCOUNT_STATUS` text,
  `FRIENDS_IDS` text,
  `ENTERED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`PRIMARY_ID`, `FIRST_NAME`, `LAST_NAME`, `E_MAIL`, `PASSWORD`, `DOB`, `PROFILE_PICTURE`, `COVER_PICTURE`, `BIO`, `PROFESSION`, `GENDER`, `CITY`, `COUNTRY`, `ACCOUNT_STATUS`, `FRIENDS_IDS`, `ENTERED_AT`) VALUES
(1, 'Ruhul', 'Mashbu', 'mashbu111@gmail.com', '751120ccf421ea22b6354ca08db5548a6a2937e9badf9f24ae37b02d39dcae228e0eb181e9b798198cbc748bd6156c5a4a2ca1c03b61512b9ddfb0939f8115f5', '1993-10-08', '5bb87330b53e8image.png', '5bb874f78f466face-map.png', 'Jack of all trades, master of none', 'Web developer', 'Male', 'Dhaka', 'BGD', 'verified', '3,2,4', '2018-09-23 14:46:04'),
(2, 'John', 'Doe', 'john@gmail.com', 'de2022009b6713b6ceeb924f7bb949d28cd90c855bcaca45da02898595a1c7ec77af47e47772ebb8361d1aedeaff9e974b89cc687b6ad30c0483ebb198167395', '1993-10-08', 'placeholder.jpg', 'cover-placeholder.jpg', NULL, NULL, 'Male', 'Dhaka', 'BGD', 'verified', NULL, '2018-09-23 14:46:04'),
(3, 'Jane', 'Doe', 'jane@gmail.com', 'de2022009b6713b6ceeb924f7bb949d28cd90c855bcaca45da02898595a1c7ec77af47e47772ebb8361d1aedeaff9e974b89cc687b6ad30c0483ebb198167395', '1993-10-08', 'placeholder.jpg', 'cover-placeholder.jpg', NULL, NULL, 'Female', 'Dhaka', 'BGD', 'verified', NULL, '2018-09-23 14:46:04'),
(4, 'Smith', 'Willson', 'smith@gmail.com', 'de2022009b6713b6ceeb924f7bb949d28cd90c855bcaca45da02898595a1c7ec77af47e47772ebb8361d1aedeaff9e974b89cc687b6ad30c0483ebb198167395', '1993-10-08', 'placeholder.jpg', 'cover-placeholder.jpg', NULL, NULL, 'Male', 'Dhaka', 'BGD', 'verified', NULL, '2018-09-23 14:46:04'),
(5, 'Peter', 'Pettigrew', 'peter@gmail.com', 'de2022009b6713b6ceeb924f7bb949d28cd90c855bcaca45da02898595a1c7ec77af47e47772ebb8361d1aedeaff9e974b89cc687b6ad30c0483ebb198167395', '1993-10-08', 'placeholder.jpg', 'cover-placeholder.jpg', NULL, NULL, 'Male', 'Dhaka', 'BGD', 'verified', NULL, '2018-09-23 14:46:04'),
(6, 'Remus', 'Lupin', 'lupin@gmail.com', 'de2022009b6713b6ceeb924f7bb949d28cd90c855bcaca45da02898595a1c7ec77af47e47772ebb8361d1aedeaff9e974b89cc687b6ad30c0483ebb198167395', '1993-10-08', 'placeholder.jpg', 'cover-placeholder.jpg', NULL, NULL, 'Male', 'Dhaka', 'BGD', 'verified', NULL, '2018-09-23 14:46:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`PRIMARY_ID`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`PRIMARY_KEY`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`POST_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`PRIMARY_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `PRIMARY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `PRIMARY_KEY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `POST_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `PRIMARY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
