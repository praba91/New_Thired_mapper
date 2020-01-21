-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2020 at 11:53 AM
-- Server version: 8.0.17
-- PHP Version: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parthiban_sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_master`
--

CREATE TABLE `account_master` (
  `idAccount` int(11) NOT NULL,
  `personName` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `accountMobileNo1` varchar(15) NOT NULL COMMENT 'Made changes',
  `accountMobileNo2` varchar(15) NOT NULL,
  `accountEmail` varchar(50) NOT NULL,
  `companyAddress` text NOT NULL,
  `companyPincode` int(11) NOT NULL,
  `companyLandmark` text NOT NULL,
  `g1` int(11) NOT NULL,
  `g2` int(11) NOT NULL,
  `g3` int(11) NOT NULL,
  `g4` int(11) NOT NULL,
  `g5` int(11) NOT NULL,
  `g6` int(11) NOT NULL,
  `g7` int(11) NOT NULL,
  `g8` int(11) NOT NULL,
  `g9` int(11) NOT NULL,
  `g10` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agency_master`
--

CREATE TABLE `agency_master` (
  `idAgency` int(11) NOT NULL,
  `agencyName` varchar(50) NOT NULL,
  `agencyEmail` varchar(50) NOT NULL,
  `agencyMobileNo` varchar(15) NOT NULL,
  `agencyFile` text,
  `agencyFile_path` varchar(250) DEFAULT NULL,
  `t1` int(11) NOT NULL,
  `t2` int(11) NOT NULL,
  `t3` int(11) NOT NULL,
  `t4` int(11) NOT NULL,
  `t5` int(11) NOT NULL,
  `t6` int(11) NOT NULL,
  `t7` int(11) NOT NULL,
  `t8` int(11) NOT NULL,
  `t9` int(11) NOT NULL,
  `t10` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active,2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agency_master`
--

INSERT INTO `agency_master` (`idAgency`, `agencyName`, `agencyEmail`, `agencyMobileNo`, `agencyFile`, `agencyFile_path`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Agency one', 'agencyone@gmail.com', '9874563112', '', '', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, '2019-12-04 11:26:28', 1, '2020-01-20 11:16:04', 1),
(2, 'Agency two', 'agency@gmail.com', '9586574754', '', '', 1, 5, 7, 12, 0, 0, 0, 0, 0, 0, 1, '2019-12-07 15:39:39', 1, '2019-12-10 11:26:56', 1),
(3, 'agency three', 'three@gmail.com', '9797787784', 'agency_1401201144.xls', 'uploads/agency/agency_1401201144.xls', 1, 4, 6, 10, 0, 0, 0, 0, 0, 0, 2, '2019-12-27 15:32:47', 1, '2020-01-14 11:44:33', 1),
(5, 'agency four', 'abcg@gmail.com', '9878787878', '', '', 1, 15, 7, 12, 0, 0, 0, 0, 0, 0, 1, '2020-01-13 12:06:37', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `answares`
--

CREATE TABLE `answares` (
  `idAnsware` int(11) NOT NULL,
  `idQuestion` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL DEFAULT '1',
  `updated_at` datetime DEFAULT NULL,
  `answare` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `answares`
--

INSERT INTO `answares` (`idAnsware`, `idQuestion`, `idCustomer`, `created_by`, `updated_by`, `updated_at`, `answare`) VALUES
(1, 1, 1, 1, 1, '2020-01-20 12:34:00', 'Yes'),
(2, 2, 1, 1, 1, '2020-01-20 12:34:00', 'test notification setting flower'),
(3, 1, 2, 1, 1, '2020-01-10 14:50:32', 'Yes'),
(4, 2, 2, 1, 1, '2020-01-10 14:50:32', 'all the beast info');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `idBank` int(11) NOT NULL,
  `bankName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bankIFSC` varchar(30) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active, 2=Inactive',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`idBank`, `bankName`, `bankIFSC`, `status`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'SBI', 'SBI10001', 1, 1, NULL, NULL),
(2, 'IND', 'IND10001', 1, 1, NULL, NULL),
(3, 'KVB', 'KVB10001', 1, 1, NULL, NULL),
(4, 'CANARA', 'CNRB1330007', 1, 1, '2020-01-04 15:18:13', 1),
(5, 'CANARA', 'CNRB133000', 1, 1, '2020-01-04 15:22:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `card_type`
--

CREATE TABLE `card_type` (
  `idCardtype` int(11) NOT NULL,
  `cardtypeName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active, 2=Inactive',
  `created_by` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `card_type`
--

INSERT INTO `card_type` (`idCardtype`, `cardtypeName`, `status`, `created_by`, `updated_by`, `updated_at`) VALUES
(1, 'MasterCard', 1, 1, NULL, '2019-12-04 10:04:57'),
(2, 'Visa', 1, 1, NULL, NULL),
(3, 'Credit card', 1, 1, 1, '2020-01-04 15:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `idCategory` int(11) NOT NULL,
  `category` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active,2-Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`idCategory`, `category`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Personal care', 1, '2019-12-04 10:02:15', 1, '2019-12-04 11:32:50', 1),
(2, 'Home care', 1, '2019-12-05 11:03:37', 1, '2019-12-10 18:47:26', 1),
(3, 'Beauty products', 2, '2020-01-04 10:37:59', 1, '2020-01-04 10:38:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

CREATE TABLE `channel` (
  `idChannel` int(11) NOT NULL,
  `Channel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`idChannel`, `Channel`) VALUES
(1, 'General Trade'),
(2, 'Modern Trade'),
(3, 'Online'),
(4, 'B2C Direct'),
(5, 'B2B'),
(6, 'Government'),
(7, 'Institutions'),
(8, 'Franchisee'),
(9, 'Own');

-- --------------------------------------------------------

--
-- Table structure for table `company_leave`
--

CREATE TABLE `company_leave` (
  `IdCompanyleave` int(11) NOT NULL,
  `IdState` int(11) NOT NULL,
  `leave_date` date NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` int(1) NOT NULL COMMENT '	1=Active;2=Inactive	',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `company_leave`
--

INSERT INTO `company_leave` (`IdCompanyleave`, `IdState`, `leave_date`, `remarks`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 2, '2019-12-13', 'Test', 1, 1, '2019-12-05 12:12:36', 1, '2019-12-05 12:12:36'),
(2, 2, '2019-12-14', 'Pongal holydays', 1, 1, '2019-12-13 17:22:12', 1, '2019-12-13 17:22:12'),
(3, 2, '2019-12-26', 'test', 1, 1, '2019-12-26 17:00:25', 1, '2019-12-26 17:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `creditrating`
--

CREATE TABLE `creditrating` (
  `idCreditRating` int(11) NOT NULL,
  `creditType` varchar(15) NOT NULL COMMENT '1=High;2=Normal;3=Low;4=Risk',
  `days` int(3) NOT NULL,
  `amount` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `creditrating`
--

INSERT INTO `creditrating` (`idCreditRating`, `creditType`, `days`, `amount`) VALUES
(1, '1', 25, 500.00),
(2, '2', 50, 1000.00),
(3, '3', 75, 1500.00),
(4, '4', 10, 2000.00);

-- --------------------------------------------------------

--
-- Table structure for table `credit_details`
--

CREATE TABLE `credit_details` (
  `idCredit` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `creditId` int(11) NOT NULL,
  `c_no` varchar(15) NOT NULL,
  `c_date` date NOT NULL,
  `c_amnt` varchar(15) NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes_all_types`
--

CREATE TABLE `credit_notes_all_types` (
  `idCredit` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `credit_note` varchar(35) NOT NULL,
  `credit_amnt` decimal(10,2) NOT NULL,
  `credit_date` date NOT NULL,
  `type` int(1) NOT NULL COMMENT 'trans_c=1,handling_c=2,incent_c=3,retn_c=4,dmg_c=5,replc=6,msng_c=7,invoice_c=8',
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_notes_all_types`
--

INSERT INTO `credit_notes_all_types` (`idCredit`, `idCustomer`, `credit_note`, `credit_amnt`, `credit_date`, `type`, `status`) VALUES
(1, 1, 'Ragu/TRNS/01', '1.00', '2020-01-07', 1, 0),
(2, 1, 'Ragu/HCC/11', '100.00', '2020-01-07', 2, 0),
(3, 1, 'Ragu/TRNS/21', '1.00', '2020-01-10', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `idCurrency` int(11) NOT NULL,
  `code` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `currencyName` varchar(58) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `countries` varchar(644) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`idCurrency`, `code`, `currencyName`, `countries`) VALUES
(1, 'AED', 'United Arab Emirates dirham', 'United Arab Emirates'),
(2, 'AFN', 'Afghan afghani', 'Afghanistan'),
(3, 'ALL', 'Albanian lek', 'Albania'),
(4, 'AMD', 'Armenian dram', 'Armenia'),
(5, 'ANG', 'Netherlands Antillean guilder', 'Curaçao (CW), Sint Maarten (SX)'),
(6, 'AOA', 'Angolan kwanza', 'Angola'),
(7, 'ARS', 'Argentine peso', 'Argentina'),
(8, 'AUD', '[[Australian dollar]ln]', 'Australia, Christmas Island (CX), Cocos (Keeling) Islands (CC), Heard Island and McDonald Islands (HM), Kiribati (KI), Nauru (NR), Norfolk Island (NF), Tuvalu (TV)'),
(9, 'AWG', 'Aruban florin', 'Aruba'),
(10, 'AZN', 'Azerbaijani manat', 'Azerbaijan'),
(11, 'BAM', 'Bosnia and Herzegovina convertible mark', 'Bosnia and Herzegovina'),
(12, 'BBD', 'Barbados dollar', 'Barbados'),
(13, 'BDT', 'Bangladeshi taka', 'Bangladesh'),
(14, 'BGN', 'Bulgarian lev', 'Bulgaria'),
(15, 'BHD', 'Bahraini dinar', 'Bahrain'),
(16, 'BIF', 'Burundian franc', 'Burundi'),
(17, 'BMD', 'Bermudian dollar', 'Bermuda'),
(18, 'BND', 'Brunei dollar', 'Brunei'),
(19, 'BOB', 'Boliviano', 'Bolivia'),
(20, 'BOV', 'Bolivian Mvdol (funds code)', 'Bolivia'),
(21, 'BRL', 'Brazilian real', 'Brazil'),
(22, 'BSD', 'Bahamian dollar', 'Bahamas'),
(23, 'BTN', 'Bhutanese ngultrum', 'Bhutan'),
(24, 'BWP', 'Botswana pula', 'Botswana'),
(25, 'BYN', 'Belarusian ruble', 'Belarus'),
(26, 'BZD', 'Belize dollar', 'Belize'),
(27, 'CAD', 'Canadian dollar', 'Canada'),
(28, 'CDF', 'Congolese franc', 'Democratic Republic of the Congo'),
(29, 'CHE', 'WIR Euro (complementary currency)', 'Switzerland'),
(30, 'CHF', 'Swiss franc', 'Switzerland, Liechtenstein (LI)'),
(31, 'CHW', 'WIR Franc (complementary currency)', 'Switzerland'),
(32, 'CLF', 'Unidad de Fomento (funds code)', 'Chile'),
(33, 'CLP', 'Chilean peso', 'Chile'),
(34, 'CNY', 'Renminbi (Chinese) yuan[7]', 'China'),
(35, 'COP', 'Colombian peso', 'Colombia'),
(36, 'COU', 'Unidad de Valor Real (UVR) (funds code)[8]', 'Colombia'),
(37, 'CRC', 'Costa Rican colon', 'Costa Rica'),
(38, 'CUC', 'Cuban convertible peso', 'Cuba'),
(39, 'CUP', 'Cuban peso', 'Cuba'),
(40, 'CVE', 'Cape Verdean escudo', 'Cabo Verde'),
(41, 'CZK', 'Czech koruna', 'Czechia [9]'),
(42, 'DJF', 'Djiboutian franc', 'Djibouti'),
(43, 'DKK', 'Danish krone', 'Denmark, Faroe Islands (FO), Greenland (GL)'),
(44, 'DOP', 'Dominican peso', 'Dominican Republic'),
(45, 'DZD', 'Algerian dinar', 'Algeria'),
(46, 'EGP', 'Egyptian pound', 'Egypt'),
(47, 'ERN', 'Eritrean nakfa', 'Eritrea'),
(48, 'ETB', 'Ethiopian birr', 'Ethiopia'),
(49, 'EUR', 'Euro', 'Åland Islands (AX), European Union (EU), Andorra (AD), Austria (AT), Belgium (BE), Cyprus (CY), Estonia (EE), Finland (FI), France (FR), French Southern and Antarctic Lands (TF), Germany (DE), Greece (GR), Guadeloupe (GP), Ireland (IE), Italy (IT), Latvia (LV), Lithuania (LT), Luxembourg (LU), Malta (MT), French Guiana (GF), Martinique (MQ), Mayotte (YT), Monaco (MC), Montenegro (ME), Netherlands (NL), Portugal (PT), Réunion (RE), Saint Barthélemy (BL), Saint Martin (MF), Saint Pierre and Miquelon (PM), San Marino (SM), Slovakia (SK), Slovenia (SI), Spain (ES), Holy See (VA)'),
(50, 'FJD', 'Fiji dollar', 'Fiji'),
(51, 'FKP', 'Falkland Islands pound', 'Falkland Islands (pegged to GBP 1:1)'),
(52, 'GBP', 'Pound sterling', 'United Kingdom, British Indian Ocean Territory (IO) (also uses USD), the Isle of Man (IM, see Manx pound), Jersey (JE, see Jersey pound), and Guernsey (GG, see Guernsey pound)'),
(53, 'GEL', 'Georgian lari', 'Georgia'),
(54, 'GHS', 'Ghanaian cedi', 'Ghana'),
(55, 'GIP', 'Gibraltar pound', 'Gibraltar (pegged to GBP 1:1)'),
(56, 'GMD', 'Gambian dalasi', 'Gambia'),
(57, 'GNF', 'Guinean franc', 'Guinea'),
(58, 'GTQ', 'Guatemalan quetzal', 'Guatemala'),
(59, 'GYD', 'Guyanese dollar', 'Guyana'),
(60, 'HKD', 'Hong Kong dollar', 'Hong Kong'),
(61, 'HNL', 'Honduran lempira', 'Honduras'),
(62, 'HRK', 'Croatian kuna', 'Croatia'),
(63, 'HTG', 'Haitian gourde', 'Haiti'),
(64, 'HUF', 'Hungarian forint', 'Hungary'),
(65, 'IDR', 'Indonesian rupiah', 'Indonesia'),
(66, 'ILS', 'Israeli new shekel', 'Israel, Palestinian Authority[10]'),
(67, 'INR', 'Indian rupee', 'India, Bhutan'),
(68, 'IQD', 'Iraqi dinar', 'Iraq'),
(69, 'IRR', 'Iranian rial', 'Iran'),
(70, 'ISK', 'Icelandic króna', 'Iceland'),
(71, 'JMD', 'Jamaican dollar', 'Jamaica'),
(72, 'JOD', 'Jordanian dinar', 'Jordan'),
(73, 'JPY', 'Japanese yen', 'Japan'),
(74, 'KES', 'Kenyan shilling', 'Kenya'),
(75, 'KGS', 'Kyrgyzstani som', 'Kyrgyzstan'),
(76, 'KHR', 'Cambodian riel', 'Cambodia'),
(77, 'KMF', 'Comoro franc', 'Comoros'),
(78, 'KPW', 'North Korean won', 'North Korea'),
(79, 'KRW', 'South Korean won', 'South Korea'),
(80, 'KWD', 'Kuwaiti dinar', 'Kuwait'),
(81, 'KYD', 'Cayman Islands dollar', 'Cayman Islands'),
(82, 'KZT', 'Kazakhstani tenge', 'Kazakhstan'),
(83, 'LAK', 'Lao kip', 'Laos'),
(84, 'LBP', 'Lebanese pound', 'Lebanon'),
(85, 'LKR', 'Sri Lankan rupee', 'Sri Lanka'),
(86, 'LRD', 'Liberian dollar', 'Liberia'),
(87, 'LSL', 'Lesotho loti', 'Lesotho'),
(88, 'LYD', 'Libyan dinar', 'Libya'),
(89, 'MAD', 'Moroccan dirham', 'Morocco, Western Sahara'),
(90, 'MDL', 'Moldovan leu', 'Moldova'),
(91, 'MGA', 'Malagasy ariary', 'Madagascar'),
(92, 'MKD', 'Macedonian denar', 'North Macedonia'),
(93, 'MMK', 'Myanmar kyat', 'Myanmar'),
(94, 'MNT', 'Mongolian tögrög', 'Mongolia'),
(95, 'MOP', 'Macanese pataca', 'Macau'),
(96, 'MRU[12]', 'Mauritanian ouguiya', 'Mauritania'),
(97, 'MUR', 'Mauritian rupee', 'Mauritius'),
(98, 'MVR', 'Maldivian rufiyaa', 'Maldives'),
(99, 'MWK', 'Malawian kwacha', 'Malawi'),
(100, 'MXN', 'Mexican peso', 'Mexico'),
(101, 'MXV', 'Mexican Unidad de Inversion (UDI) (funds code)', 'Mexico'),
(102, 'MYR', 'Malaysian ringgit', 'Malaysia'),
(103, 'MZN', 'Mozambican metical', 'Mozambique'),
(104, 'NAD', 'Namibian dollar', 'Namibia'),
(105, 'NGN', 'Nigerian naira', 'Nigeria'),
(106, 'NIO', 'Nicaraguan córdoba', 'Nicaragua'),
(107, 'NOK', 'Norwegian krone', 'Norway, Svalbard and Jan Mayen (SJ), Bouvet Island (BV)'),
(108, 'NPR', 'Nepalese rupee', 'Nepal'),
(109, 'NZD', 'New Zealand dollar', 'New Zealand, Cook Islands (CK), Niue (NU), Pitcairn Islands (PN; see also Pitcairn Islands dollar), Tokelau (TK)'),
(110, 'OMR', 'Omani rial', 'Oman'),
(111, 'PAB', 'Panamanian balboa', 'Panama'),
(112, 'PEN', 'Peruvian sol', 'Peru'),
(113, 'PGK', 'Papua New Guinean kina', 'Papua New Guinea'),
(114, 'PHP', 'Philippine peso[13]', 'Philippines'),
(115, 'PKR', 'Pakistani rupee', 'Pakistan'),
(116, 'PLN', 'Polish złoty', 'Poland'),
(117, 'PYG', 'Paraguayan guaraní', 'Paraguay'),
(118, 'QAR', 'Qatari riyal', 'Qatar'),
(119, 'RON', 'Romanian leu', 'Romania'),
(120, 'RSD', 'Serbian dinar', 'Serbia'),
(121, 'RUB', 'Russian ruble', 'Russia'),
(122, 'RWF', 'Rwandan franc', 'Rwanda'),
(123, 'SAR', 'Saudi riyal', 'Saudi Arabia'),
(124, 'SBD', 'Solomon Islands dollar', 'Solomon Islands'),
(125, 'SCR', 'Seychelles rupee', 'Seychelles'),
(126, 'SDG', 'Sudanese pound', 'Sudan'),
(127, 'SEK', 'Swedish krona/kronor', 'Sweden'),
(128, 'SGD', 'Singapore dollar', 'Singapore'),
(129, 'SHP', 'Saint Helena pound', 'Saint Helena (SH-SH), Ascension Island (SH-AC), Tristan da Cunha'),
(130, 'SLL', 'Sierra Leonean leone', 'Sierra Leone'),
(131, 'SOS', 'Somali shilling', 'Somalia'),
(132, 'SRD', 'Surinamese dollar', 'Suriname'),
(133, 'SSP', 'South Sudanese pound', 'South Sudan'),
(134, 'STN[14]', 'São Tomé and Príncipe dobra', 'São Tomé and Príncipe'),
(135, 'SVC', 'Salvadoran colón', 'El Salvador'),
(136, 'SYP', 'Syrian pound', 'Syria'),
(137, 'SZL', 'Swazi lilangeni', 'Eswatini[13]'),
(138, 'THB', 'Thai baht', 'Thailand'),
(139, 'TJS', 'Tajikistani somoni', 'Tajikistan'),
(140, 'TMT', 'Turkmenistan manat', 'Turkmenistan'),
(141, 'TND', 'Tunisian dinar', 'Tunisia'),
(142, 'TOP', 'Tongan paʻanga', 'Tonga'),
(143, 'TRY', 'Turkish lira', 'Turkey, Northern Cyprus'),
(144, 'TTD', 'Trinidad and Tobago dollar', 'Trinidad and Tobago'),
(145, 'TWD', 'New Taiwan dollar', 'Taiwan'),
(146, 'TZS', 'Tanzanian shilling', 'Tanzania'),
(147, 'UAH', 'Ukrainian hryvnia', 'Ukraine'),
(148, 'UGX', 'Ugandan shilling', 'Uganda'),
(149, 'USD', 'United States dollar', 'United States, American Samoa (AS), Barbados (BB) (as well as Barbados Dollar), Bermuda (BM) (as well as Bermudian Dollar), British Indian Ocean Territory (IO) (also uses GBP), British Virgin Islands (VG), Caribbean Netherlands (BQ – Bonaire, Sint Eustatius and Saba), Ecuador (EC), El Salvador (SV), Guam (GU), Haiti (HT), Marshall Islands (MH), Federated States of Micronesia (FM), Northern Mariana Islands (MP), Palau (PW), Panama (PA) (as well as Panamanian Balboa), Puerto Rico (PR), Timor-Leste (TL), Turks and Caicos Islands (TC), U.S. Virgin Islands (VI), United States Minor Outlying Islands (UM) Cambodia also uses the USD officially.'),
(150, 'USN', 'United States dollar (next day) (funds code)', 'United States'),
(151, 'UYI', 'Uruguay Peso en Unidades Indexadas (URUIURUI) (funds code)', 'Uruguay'),
(152, 'UYU', 'Uruguayan peso', 'Uruguay'),
(153, 'UYW', 'Unidad previsional[15]', 'Uruguay'),
(154, 'UZS', 'Uzbekistan som', 'Uzbekistan'),
(155, 'VES', 'Venezuelan bolívar soberano[13]', 'Venezuela'),
(156, 'VND', 'Vietnamese đồng', 'Vietnam'),
(157, 'VUV', 'Vanuatu vatu', 'Vanuatu'),
(158, 'WST', 'Samoan tala', 'Samoa'),
(159, 'XAF', 'CFA franc BEAC', 'Cameroon (CM), Central African Republic (CF), Republic of the Congo (CG), Chad (TD), Equatorial Guinea (GQ), Gabon (GA)'),
(160, 'XAG', 'Silver (one troy ounce)', NULL),
(161, 'XAU', 'Gold (one troy ounce)', NULL),
(162, 'XBA', 'European Composite Unit (EURCO) (bond market unit)', NULL),
(163, 'XBB', 'European Monetary Unit (E.M.U.-6) (bond market unit)', NULL),
(164, 'XBC', 'European Unit of Account 9 (E.U.A.-9) (bond market unit)', NULL),
(165, 'XBD', 'European Unit of Account 17 (E.U.A.-17) (bond market unit)', NULL),
(166, 'XCD', 'East Caribbean dollar', 'Anguilla (AI), Antigua and Barbuda (AG), Dominica (DM), Grenada (GD), Montserrat (MS), Saint Kitts and Nevis (KN), Saint Lucia (LC), Saint Vincent and the Grenadines (VC)'),
(167, 'XDR', 'Special drawing rights', 'International Monetary Fund'),
(168, 'XOF', 'CFA franc BCEAO', 'Benin (BJ), Burkina Faso (BF), Côte d\'Ivoire (CI), Guinea-Bissau (GW), Mali (ML), Niger (NE), Senegal (SN), Togo (TG)'),
(169, 'XPD', 'Palladium (one troy ounce)', NULL),
(170, 'XPF', 'CFP franc (franc Pacifique)', 'French territories of the Pacific Ocean: French Polynesia (PF), New Caledonia (NC), Wallis and Futuna (WF)'),
(171, 'XPT', 'Platinum (one troy ounce)', NULL),
(172, 'XSU', 'SUCRE', 'Unified System for Regional Compensation (SUCRE)[16]'),
(173, 'XTS', 'Code reserved for testing', NULL),
(174, 'XUA', 'ADB Unit of Account', 'African Development Bank[17]'),
(175, 'XXX', 'No currency', NULL),
(176, 'YER', 'Yemeni rial', 'Yemen'),
(177, 'ZAR', 'South African rand', 'Lesotho, Namibia, South Africa'),
(178, 'ZMW', 'Zambian kwacha', 'Zambia'),
(179, 'ZWL', 'Zimbabwean dollar', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `idCustomer` int(11) NOT NULL,
  `G1` int(10) DEFAULT NULL,
  `G2` int(10) DEFAULT NULL,
  `G3` int(10) DEFAULT NULL,
  `G4` int(10) DEFAULT NULL,
  `G5` int(10) DEFAULT NULL,
  `G6` int(10) DEFAULT NULL,
  `G7` int(10) DEFAULT NULL,
  `G8` int(10) DEFAULT NULL,
  `G9` int(10) DEFAULT NULL,
  `G10` int(10) DEFAULT NULL,
  `customer_code` varchar(60) DEFAULT NULL,
  `idCustClass` int(11) NOT NULL DEFAULT '0',
  `idCustRetailerCat` int(11) NOT NULL DEFAULT '0',
  `cs_name` varchar(120) NOT NULL,
  `cs_mail` varchar(50) NOT NULL,
  `cs_serviceby` int(11) NOT NULL DEFAULT '0',
  `cs_type` int(11) NOT NULL,
  `cs_status` int(11) NOT NULL,
  `cs_mobno` varchar(13) NOT NULL,
  `cs_dob` date NOT NULL,
  `cs_martialStatus` int(1) NOT NULL,
  `cs_payment_type` int(10) DEFAULT NULL,
  `part_paymentPercent` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cs_credit_ratingstatus` int(10) DEFAULT NULL,
  `cs_credit_types` int(10) DEFAULT NULL,
  `cs_date_enrollment` date NOT NULL,
  `cs_creditAmount` varchar(100) DEFAULT '0.00',
  `cs_long_bsns` varchar(25) NOT NULL,
  `cs_a_stores` varchar(10) NOT NULL DEFAULT '0',
  `idPreferredwarehouse` int(11) NOT NULL,
  `cs_supermarkets` varchar(25) NOT NULL DEFAULT '0',
  `cs_tinno` varchar(20) NOT NULL,
  `cs_tindate` date NOT NULL,
  `cs_cmsn_type` int(1) DEFAULT NULL COMMENT 'standard=1,special=2',
  `cs_transport_type` int(1) NOT NULL DEFAULT '0',
  `cs_transport_amt` varchar(100) NOT NULL DEFAULT '0.00',
  `cs_population` varchar(35) NOT NULL,
  `cs_potential_value` varchar(100) NOT NULL DEFAULT '0.00',
  `cs_segment_type` int(10) NOT NULL DEFAULT '0',
  `cs_customer_group` int(10) NOT NULL DEFAULT '0',
  `cs_raising_rights` int(10) DEFAULT NULL,
  `cs_stock_payment_type` int(10) NOT NULL DEFAULT '0',
  `idSalesHierarchy` int(11) NOT NULL,
  `sales_hrchy_name` int(11) NOT NULL COMMENT 'team_menber_id or employee_id',
  `customer_logo` varchar(100) DEFAULT NULL,
  `idStocktransfer` int(11) NOT NULL DEFAULT '0' COMMENT '	1=Full Stock transfer, 2=Part Stock transfer',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`idCustomer`, `G1`, `G2`, `G3`, `G4`, `G5`, `G6`, `G7`, `G8`, `G9`, `G10`, `customer_code`, `idCustClass`, `idCustRetailerCat`, `cs_name`, `cs_mail`, `cs_serviceby`, `cs_type`, `cs_status`, `cs_mobno`, `cs_dob`, `cs_martialStatus`, `cs_payment_type`, `part_paymentPercent`, `cs_credit_ratingstatus`, `cs_credit_types`, `cs_date_enrollment`, `cs_creditAmount`, `cs_long_bsns`, `cs_a_stores`, `idPreferredwarehouse`, `cs_supermarkets`, `cs_tinno`, `cs_tindate`, `cs_cmsn_type`, `cs_transport_type`, `cs_transport_amt`, `cs_population`, `cs_potential_value`, `cs_segment_type`, `cs_customer_group`, `cs_raising_rights`, `cs_stock_payment_type`, `idSalesHierarchy`, `sales_hrchy_name`, `customer_logo`, `idStocktransfer`, `created_by`) VALUES
(1, 1, 2, 3, 8, NULL, NULL, NULL, NULL, NULL, NULL, '101', 0, 0, 'Ragu', 'ragu@gmail.com', 0, 1, 1, '8098861238', '1995-09-25', 2, 1, '0', 0, 1, '2019-12-25', '1000', '20', '0', 1, '0', '56851333', '2019-12-31', NULL, 2, '12.5', '10', '10', 1, 0, 1, 1, 1, 1, NULL, 0, 1),
(2, 1, 4, 7, 10, NULL, NULL, NULL, NULL, NULL, NULL, '102', 0, 0, 'Vaithi', 'vaithi@gmail.com', 3, 2, 1, '9698222689', '1995-05-30', 1, 1, '0', 0, 1, '2019-12-26', '1500', '25', '0', 2, '0', '123658954', '2019-12-31', NULL, 1, '0', '10', '15', 1, 1, 1, 2, 1, 1, NULL, 0, 1),
(3, 1, 5, 6, 12, NULL, NULL, NULL, NULL, NULL, NULL, '103', 0, 0, 'Paul', 'paul@gmail.com', 0, 1, 1, '9874465656', '0947-08-14', 2, 2, '0', 1, 1, '2019-12-24', '100', '10', '0', 2, '0', '8556623', '2019-12-27', NULL, 1, '0', '10', '10', 1, 2, 1, 3, 1, 1, NULL, 0, 1),
(4, 1, 2, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL, '104', 0, 0, 'Yuvarai', 'yuva@gmail.com', 0, 2, 1, '9874455156', '1922-06-07', 2, 3, '0', 0, 1, '2019-12-31', '10', '10', '0', 1, '0', '123987456', '2020-01-31', NULL, 1, '0', '10', '20', 1, 1, 2, 4, 1, 1, NULL, 0, 39),
(5, 1, 2, 3, 0, NULL, NULL, NULL, NULL, NULL, NULL, '1012', 0, 0, 'mari', 'm@gmail.com', 0, 1, 1, '4545454546', '2019-12-03', 1, 1, '0', 0, 1, '2019-12-03', '10', '10', '0', 2, '0', '546549878484', '2019-12-04', NULL, 1, '0', '10', '12', 1, 1, 1, 1, 1, 1, NULL, 1, 1),
(6, 1, 2, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL, '110', 0, 0, 'Rakesh', 'rakesh@gmail.com', 3, 5, 1, '9798949465', '1998-02-03', 1, 1, '0', 0, 1, '2013-05-15', '50000', '5', '0', 5, '0', 'TIN1230', '2024-05-07', NULL, 2, '2', '50000', '250', 2, 3, 1, 4, 1, 2, NULL, 1, 1),
(7, 1, 5, 6, 12, NULL, NULL, NULL, NULL, NULL, NULL, '123', 0, 0, 'Raja', 'raja@gmail.com', 1, 2, 1, '9865321456', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(8, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '1234', 0, 0, 'Kumar', '15raja@gmail.com', 1, 2, 1, '9865321472', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(9, 1, 4, 7, 10, NULL, NULL, NULL, NULL, NULL, NULL, '1235', 0, 0, 'prem', '13raja@gmail.com', 1, 2, 1, '9865321473', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(10, 1, 2, 3, 8, NULL, NULL, NULL, NULL, NULL, NULL, '1236', 0, 0, 'Raman', '12raja@gmail.com', 1, 2, 1, '9865321474', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(11, 1, 2, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL, '1237', 0, 0, 'Ravi', '11raja@gmail.com', 1, 2, 1, '9865321475', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(12, 1, 2, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL, '1238', 0, 0, 'Kannan', '10raja@gmail.com', 1, 2, 1, '9865321476', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(13, 1, 4, 7, 13, NULL, NULL, NULL, NULL, NULL, NULL, '1239', 0, 0, 'Vijay', '9raja@gmail.com', 1, 2, 1, '9865321477', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(14, 1, 5, 6, 12, NULL, NULL, NULL, NULL, NULL, NULL, '12310', 0, 0, 'Rajini', '8raja@gmail.com', 1, 2, 1, '9865321479', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(15, 1, 2, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL, '12311', 0, 0, 'Antony', '4raja@gmail.com', 0, 1, 1, '9865321555', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '12312', 0, 0, 'Albert', '3raja@gmail.com', 0, 1, 1, '9865321444', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', 0, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(17, 1, 2, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL, '12313', 0, 0, 'Ashok', '2raja@gmail.com', 0, 1, 1, '9865321433', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '12314', 0, 0, 'Alex', '1raja@gmail.com', 0, 1, 1, '9865321422', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', 0, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(19, 1, 4, 7, 13, NULL, NULL, NULL, NULL, NULL, NULL, '12315', 0, 0, 'Pandian', 'Pandianraja@gmail.com', 1, 2, 1, '9865321411', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(20, 1, 5, 6, 12, NULL, NULL, NULL, NULL, NULL, NULL, '12316', 0, 0, 'Ruban', 'Rubanraja@gmail.com', 0, 1, 1, '9865321400', '2019-01-01', 1, 1, NULL, 1, 1, '1995-01-01', '500', '5', '0', 1, '0', 'TIN123', '2023-02-01', NULL, 1, '0', '500', '500', 2, 0, 1, 1, 1, 1, '', 0, 1),
(21, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '10112', 0, 0, 'manoj', 'manoj@gmail.com', 0, 1, 1, '9887874545', '1996-05-12', 1, 1, NULL, 1, 1, '2019-12-26', '1000', '100', '0', 1, '0', '1236', '2020-03-26', 0, 1, '0', '15', '10', 2, 0, 1, 4, 1, 2, '', 0, 1),
(22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '10152', 0, 0, 'kathir', 'kathir@gmail.com', 1, 2, 1, '5498465455', '1996-05-12', 1, 1, NULL, 1, 1, '2019-12-26', '1000', '100', '0', 1, '0', '1236', '2020-03-26', 0, 1, '0', '15', '10', 2, 0, 1, 4, 1, 2, '', 0, 1),
(23, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '789', 0, 0, 'kathir1', 'kathi11r@gmail.com', 1, 2, 1, '5654767667', '1996-05-12', 1, 1, NULL, 1, 1, '2019-12-26', '1000', '100', '0', 1, '0', '1236', '2020-03-26', NULL, 1, '0', '15', '10', 2, 0, 1, 4, 1, 2, '', 0, 39),
(24, 1, 5, 6, 12, NULL, NULL, NULL, NULL, NULL, NULL, 'CUS1023', 0, 0, 'Ramanan', 'ramanan@gmail.com', 0, 1, 2, '8665265652', '1995-05-01', 1, 2, NULL, 1, 1, '1998-05-01', '5000', '5', '0', 1, '0', '5645', '2028-05-01', NULL, 1, '0', '5', '252', 2, 0, 1, 1, 1, 1, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customertype`
--

CREATE TABLE `customertype` (
  `idCustomerType` int(11) NOT NULL,
  `custType` varchar(50) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customertype`
--

INSERT INTO `customertype` (`idCustomerType`, `custType`, `level`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Super mega stockist', 1, 1, '2019-12-04 09:34:39', 1, '2020-01-20 14:55:44', 1),
(2, 'Mega Stockist', 2, 1, '2019-12-04 09:34:58', 1, '2020-01-14 16:03:53', 1),
(3, 'Super stockist', 3, 1, '2019-12-04 09:35:13', 1, '2020-01-14 16:05:46', 1),
(4, 'Distributor', 4, 1, '2019-12-04 09:35:30', 1, '2020-01-14 16:07:18', 1),
(5, 'Retailer', 5, 1, '2019-12-04 09:35:42', 1, '2020-01-14 16:07:25', 1),
(6, 'test', 6, 2, '2020-01-04 10:35:26', 1, '2020-01-14 16:20:14', 1),
(7, 'customertype', 7, 2, '2020-01-14 16:16:55', 1, '2020-01-14 16:19:38', 1),
(8, 'test1', 8, 2, '2020-01-14 16:19:59', 1, '2020-01-14 16:20:03', 1),
(9, 'Test type', 9, 2, '2020-01-14 16:58:28', 1, '2020-01-14 16:58:28', 1),
(10, 'Super Mega stockist1', 11, 2, '2020-01-21 09:39:55', 1, '2020-01-21 09:39:55', 1),
(11, 'Mega stockist1', 12, 2, '2020-01-21 09:39:55', 1, '2020-01-21 09:39:55', 1),
(12, 'Super Stockist1', 13, 2, '2020-01-21 09:39:56', 1, '2020-01-21 09:39:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_allocation`
--

CREATE TABLE `customer_allocation` (
  `cus_allocate_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `idStockrule` int(11) NOT NULL DEFAULT '0' COMMENT '1=Stock Transfer on Full advance Payment, 2=Stock transfer on part advance payment,3=Stock transfer on Credit,4=Payment on delivery',
  `idStocktransfer` int(11) NOT NULL DEFAULT '0' COMMENT '1=Full Stock transfer, 2=Part Stock transfer',
  `idTerritorytitle` int(11) NOT NULL,
  `territory_ids` text NOT NULL,
  `category_ids` text NOT NULL,
  `warehouse_ids` text NOT NULL,
  `channel_ids` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(10) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_allocation`
--

INSERT INTO `customer_allocation` (`cus_allocate_id`, `customer_id`, `idStockrule`, `idStocktransfer`, `idTerritorytitle`, `territory_ids`, `category_ids`, `warehouse_ids`, `channel_ids`, `created_by`, `updated_by`) VALUES
(1, 1, 0, 0, 4, 'a:6:{i:0;s:1:\"8\";i:1;s:2:\"12\";i:2;s:1:\"9\";i:3;s:2:\"10\";i:4;s:2:\"11\";i:5;s:2:\"13\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"2\";i:4;s:1:\"7\";}', NULL, 1, 1),
(2, 3, 0, 0, 4, 'a:1:{i:0;s:2:\"12\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:1:{i:0;s:1:\"1\";}', NULL, 1, 0),
(3, 2, 0, 0, 4, 'a:1:{i:0;s:1:\"8\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:3:{i:0;s:1:\"4\";i:1;s:1:\"4\";i:2;s:1:\"4\";}', NULL, 34, 1),
(4, 4, 0, 0, 4, 'a:2:{i:0;s:1:\"8\";i:1;s:2:\"13\";}', 'a:1:{i:0;s:1:\"1\";}', 'a:6:{i:0;s:1:\"2\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:1:\"2\";i:4;s:1:\"3\";i:5;s:1:\"4\";}', NULL, 1, 1),
(5, 5, 0, 0, 4, 'a:6:{i:0;s:1:\"8\";i:1;s:1:\"9\";i:2;s:2:\"10\";i:3;s:2:\"11\";i:4;s:2:\"12\";i:5;s:2:\"13\";}', 'a:1:{i:0;s:1:\"1\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', NULL, 1, 0),
(6, 9, 0, 0, 1, 'a:1:{i:0;s:1:\"1\";}', 'a:1:{i:0;s:1:\"1\";}', 'a:1:{i:0;s:1:\"1\";}', NULL, 1, 1),
(7, 8, 0, 0, 4, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"8\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"1\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"1\";}', NULL, 1, 0),
(8, 20, 0, 0, 1, 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"8\";i:2;s:1:\"1\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";}', NULL, 1, 0),
(9, 11, 0, 0, 4, 'a:1:{i:0;s:1:\"8\";}', 'a:1:{i:0;s:1:\"1\";}', 'a:1:{i:0;s:1:\"2\";}', NULL, 1, 0),
(10, 7, 0, 0, 4, 'a:1:{i:0;s:1:\"8\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"1\";}', 'a:12:{i:0;s:1:\"2\";i:1;s:1:\"2\";i:2;s:1:\"2\";i:3;s:1:\"2\";i:4;s:1:\"2\";i:5;s:1:\"2\";i:6;s:1:\"2\";i:7;s:1:\"3\";i:8;s:1:\"2\";i:9;s:1:\"2\";i:10;s:1:\"2\";i:11;s:1:\"2\";}', NULL, 1, 1),
(11, 22, 0, 0, 4, 'a:1:{i:0;s:1:\"8\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:2:{i:0;s:1:\"2\";i:1;s:1:\"3\";}', NULL, 39, 0),
(12, 23, 0, 0, 4, 'a:2:{i:0;s:1:\"8\";i:1;s:1:\"8\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"1\";}', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"3\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";}', NULL, 39, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_billing_price`
--

CREATE TABLE `customer_billing_price` (
  `idBillingprice` int(11) NOT NULL,
  `idTerritory` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProductsize` int(11) NOT NULL,
  `idCustomertype` int(11) NOT NULL,
  `b_biilingprice` decimal(65,2) NOT NULL,
  `priceMRP` decimal(65,2) NOT NULL DEFAULT '0.00',
  `price` decimal(65,2) NOT NULL DEFAULT '0.00',
  `taxPercentage` decimal(65,2) NOT NULL DEFAULT '0.00',
  `a_billingprice` decimal(65,2) NOT NULL,
  `margin_value` decimal(65,2) NOT NULL DEFAULT '0.00',
  `commissionMode` int(11) NOT NULL,
  `companyCost` decimal(65,2) NOT NULL DEFAULT '0.00',
  `commissionPercentage` decimal(65,2) NOT NULL DEFAULT '0.00',
  `billingDate` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_billing_price`
--

INSERT INTO `customer_billing_price` (`idBillingprice`, `idTerritory`, `idProduct`, `idProductsize`, `idCustomertype`, `b_biilingprice`, `priceMRP`, `price`, `taxPercentage`, `a_billingprice`, `margin_value`, `commissionMode`, `companyCost`, `commissionPercentage`, `billingDate`, `created_by`) VALUES
(1, 14, 1, 1, 5, '48.50', '56.00', '50.00', '12.00', '54.32', '14.00', 1, '30.00', '1.50', '2020-01-14', 1),
(2, 14, 1, 2, 5, '58.50', '67.20', '60.00', '12.00', '65.52', '24.00', 1, '30.00', '1.50', '2020-01-14', 1),
(3, 14, 1, 1, 4, '47.00', '56.00', '50.00', '12.00', '52.64', '14.00', 1, '30.00', '1.50', '2020-01-14', 1),
(4, 14, 1, 2, 4, '57.00', '67.20', '60.00', '12.00', '63.84', '24.00', 1, '30.00', '1.50', '2020-01-14', 1),
(5, 14, 1, 1, 3, '45.50', '56.00', '50.00', '12.00', '50.96', '14.00', 1, '30.00', '1.50', '2020-01-14', 1),
(6, 14, 1, 2, 3, '55.50', '67.20', '60.00', '12.00', '62.16', '24.00', 1, '30.00', '1.50', '2020-01-14', 1),
(7, 14, 1, 1, 2, '44.00', '56.00', '50.00', '12.00', '49.28', '14.00', 1, '30.00', '1.50', '2020-01-14', 1),
(8, 14, 1, 2, 2, '54.00', '67.20', '60.00', '12.00', '60.48', '24.00', 1, '30.00', '1.50', '2020-01-14', 1),
(9, 8, 1, 1, 5, '59.00', '67.20', '60.00', '12.00', '66.08', '25.00', 1, '30.00', '1.00', '2020-01-01', 1),
(10, 8, 1, 2, 5, '79.00', '89.60', '80.00', '12.00', '88.48', '35.00', 1, '40.00', '1.00', '2020-01-01', 1),
(11, 8, 2, 3, 5, '14.00', '16.80', '15.00', '12.00', '15.68', '5.00', 1, '5.00', '1.00', '2020-01-01', 1),
(12, 8, 3, 5, 5, '29999.00', '31500.00', '30000.00', '5.00', '31498.95', '14995.00', 1, '15000.00', '1.00', '2020-01-01', 1),
(13, 8, 4, 7, 5, '41.00', '47.04', '42.00', '12.00', '45.92', '15.00', 1, '22.00', '1.00', '2020-01-01', 1),
(14, 8, 1, 1, 4, '58.00', '67.20', '60.00', '12.00', '64.96', '25.00', 1, '30.00', '1.00', '2020-01-01', 1),
(15, 8, 1, 2, 4, '78.00', '89.60', '80.00', '12.00', '87.36', '35.00', 1, '40.00', '1.00', '2020-01-01', 1),
(16, 8, 2, 3, 4, '13.00', '16.80', '15.00', '12.00', '14.56', '5.00', 1, '5.00', '1.00', '2020-01-01', 1),
(17, 8, 3, 5, 4, '29998.00', '31500.00', '30000.00', '5.00', '31497.90', '14995.00', 1, '15000.00', '1.00', '2020-01-01', 1),
(18, 8, 4, 7, 4, '40.00', '47.04', '42.00', '12.00', '44.80', '15.00', 1, '22.00', '1.00', '2020-01-01', 1),
(19, 8, 1, 1, 3, '57.00', '67.20', '60.00', '12.00', '63.84', '25.00', 1, '30.00', '1.00', '2020-01-01', 1),
(20, 8, 1, 2, 3, '77.00', '89.60', '80.00', '12.00', '86.24', '35.00', 1, '40.00', '1.00', '2020-01-01', 1),
(21, 8, 2, 3, 3, '12.00', '16.80', '15.00', '12.00', '13.44', '5.00', 1, '5.00', '1.00', '2020-01-01', 1),
(22, 8, 3, 5, 3, '29997.00', '31500.00', '30000.00', '5.00', '31496.85', '14995.00', 1, '15000.00', '1.00', '2020-01-01', 1),
(23, 8, 4, 7, 3, '39.00', '47.04', '42.00', '12.00', '43.68', '15.00', 1, '22.00', '1.00', '2020-01-01', 1),
(24, 8, 1, 1, 2, '56.00', '67.20', '60.00', '12.00', '62.72', '25.00', 1, '30.00', '1.00', '2020-01-01', 1),
(25, 8, 1, 2, 2, '76.00', '89.60', '80.00', '12.00', '85.12', '35.00', 1, '40.00', '1.00', '2020-01-01', 1),
(26, 8, 2, 3, 2, '11.00', '16.80', '15.00', '12.00', '12.32', '5.00', 1, '5.00', '1.00', '2020-01-01', 1),
(27, 8, 3, 5, 2, '29996.00', '31500.00', '30000.00', '5.00', '31495.80', '14995.00', 1, '15000.00', '1.00', '2020-01-01', 1),
(28, 8, 4, 7, 2, '38.00', '47.04', '42.00', '12.00', '42.56', '15.00', 1, '22.00', '1.00', '2020-01-01', 1),
(29, 8, 1, 1, 1, '55.00', '67.20', '60.00', '12.00', '61.60', '25.00', 1, '30.00', '1.00', '2020-01-01', 1),
(30, 8, 1, 2, 1, '75.00', '89.60', '80.00', '12.00', '84.00', '35.00', 1, '40.00', '1.00', '2020-01-01', 1),
(31, 8, 2, 3, 1, '10.00', '16.80', '15.00', '12.00', '11.20', '5.00', 1, '5.00', '1.00', '2020-01-01', 1),
(32, 8, 3, 5, 1, '29995.00', '31500.00', '30000.00', '5.00', '31494.75', '14995.00', 1, '15000.00', '1.00', '2020-01-01', 1),
(33, 8, 4, 7, 1, '37.00', '47.04', '42.00', '12.00', '41.44', '15.00', 1, '22.00', '1.00', '2020-01-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_channel`
--

CREATE TABLE `customer_channel` (
  `idCustomerChannel` int(11) NOT NULL,
  `idCustomerType` varchar(50) NOT NULL,
  `idChannel` int(11) NOT NULL,
  `idSubsidaryGroup` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_channel`
--

INSERT INTO `customer_channel` (`idCustomerChannel`, `idCustomerType`, `idChannel`, `idSubsidaryGroup`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, '1', 1, NULL, 1, '2019-12-04 09:36:21', 1, NULL, NULL),
(2, '2', 2, NULL, 1, '2019-12-04 09:36:28', 1, NULL, NULL),
(3, '3', 3, NULL, 1, '2019-12-04 09:36:35', 1, NULL, NULL),
(4, '4', 4, NULL, 1, '2019-12-04 09:36:46', 1, NULL, NULL),
(5, '3', 5, NULL, 2, '2020-01-04 10:35:50', 1, '2020-01-04 10:35:54', 1),
(6, '4', 3, NULL, 1, '2020-01-07 11:20:56', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_damage_credit_status`
--

CREATE TABLE `customer_order_damage_credit_status` (
  `idCreditstatusdamage` int(11) NOT NULL,
  `idLevel` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `credit_date` date NOT NULL,
  `credit_note_no` varchar(30) NOT NULL,
  `credit_amount` decimal(11,2) NOT NULL,
  `wo_tax_credit_amount` decimal(11,2) NOT NULL,
  `approval_amount` decimal(11,2) NOT NULL,
  `credit_status` int(11) NOT NULL,
  `tax_status` int(1) NOT NULL COMMENT 'Avail=1,Notavail=2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_damges`
--

CREATE TABLE `customer_order_damges` (
  `idCustOrderDmgsRtn` int(11) NOT NULL,
  `idDispatchcustomer` int(11) NOT NULL,
  `idDispatchProductBatch` int(11) NOT NULL,
  `credit_note_no` varchar(20) NOT NULL,
  `dmgRtnDate` date NOT NULL,
  `dmgQty` int(11) NOT NULL,
  `dmgUnit` int(11) NOT NULL,
  `prdctReturnStatus` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `dmg_cmnts` text NOT NULL,
  `idSerialno` text CHARACTER SET latin1 COLLATE latin1_swedish_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_order_damges`
--

INSERT INTO `customer_order_damges` (`idCustOrderDmgsRtn`, `idDispatchcustomer`, `idDispatchProductBatch`, `credit_note_no`, `dmgRtnDate`, `dmgQty`, `dmgUnit`, `prdctReturnStatus`, `status`, `dmg_cmnts`, `idSerialno`) VALUES
(1, 1, 1, 'D070120120244M700G', '2020-01-07', 2, 0, 1, 1, '', '1,2'),
(2, 1, 2, 'D210120100541M579G', '2020-01-21', 2, 0, 1, 1, '', '51,52'),
(3, 10, 18, 'D210120110706M894G', '2020-01-21', 2, 0, 1, 1, '', '568,569');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_missing`
--

CREATE TABLE `customer_order_missing` (
  `idCustMissing` int(11) NOT NULL,
  `idDispatchcustomer` int(11) NOT NULL,
  `idDispatchProductBatch` int(11) NOT NULL,
  `credit_note_no` varchar(20) NOT NULL,
  `missing_entry_date` date NOT NULL,
  `missing_qty` int(11) NOT NULL,
  `missing_status` int(11) NOT NULL,
  `missing_cmnts` text NOT NULL,
  `idSrialno` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_order_missing`
--

INSERT INTO `customer_order_missing` (`idCustMissing`, `idDispatchcustomer`, `idDispatchProductBatch`, `credit_note_no`, `missing_entry_date`, `missing_qty`, `missing_status`, `missing_cmnts`, `idSrialno`) VALUES
(1, 1, 1, 'M200120065729S997G', '2020-01-20', 1, 1, '', '13|14|15|16|17'),
(2, 10, 18, 'M210120114736S855G', '2020-01-21', 1, 1, '', '570|571|572|573|574');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_missing_credit_status`
--

CREATE TABLE `customer_order_missing_credit_status` (
  `idCreditstatusmissing` int(11) NOT NULL,
  `idLevel` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `credit_date` date NOT NULL,
  `credit_note_no` varchar(30) NOT NULL,
  `credit_amount` decimal(11,2) NOT NULL,
  `wo_tax_credit_amount` decimal(11,2) NOT NULL,
  `approval_amount` decimal(11,2) NOT NULL,
  `credit_status` int(11) NOT NULL,
  `tax_status` int(1) NOT NULL COMMENT 'Avail=1,Notavail=2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_replacement`
--

CREATE TABLE `customer_order_replacement` (
  `idCustReplacement` int(11) NOT NULL,
  `idDispatchcustomer` int(11) NOT NULL,
  `idDispatchProductBatch` int(11) NOT NULL,
  `credit_note_no` varchar(20) NOT NULL,
  `replaceDate` date NOT NULL,
  `replaceQty` int(11) NOT NULL,
  `replaceStatus` int(11) NOT NULL,
  `replaceCmnts` text NOT NULL,
  `idSrialno` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_order_replacement`
--

INSERT INTO `customer_order_replacement` (`idCustReplacement`, `idDispatchcustomer`, `idDispatchProductBatch`, `credit_note_no`, `replaceDate`, `replaceQty`, `replaceStatus`, `replaceCmnts`, `idSrialno`) VALUES
(1, 1, 1, 'R200120050054P730C', '2020-01-20', 1, 1, '', '8|9|10|11|12'),
(2, 1, 2, 'R210120113737P583C', '2020-01-21', 1, 1, '', '53|54|55|56|57');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_replace_credit_status`
--

CREATE TABLE `customer_order_replace_credit_status` (
  `idCreditstatusreplace` int(11) NOT NULL,
  `idLevel` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `credit_date` date NOT NULL,
  `credit_note_no` varchar(20) NOT NULL,
  `credit_amount` decimal(11,2) NOT NULL,
  `wo_tax_credit_amount` decimal(11,2) NOT NULL,
  `approval_amount` decimal(11,2) NOT NULL,
  `credit_status` int(1) NOT NULL,
  `tax_status` int(1) NOT NULL COMMENT 'Avail=1,Notavail=2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_return`
--

CREATE TABLE `customer_order_return` (
  `idCustOrderRtn` int(11) NOT NULL,
  `idDispatchcustomer` int(11) NOT NULL,
  `idDispatchProductBatch` int(11) NOT NULL,
  `credit_note_no` varchar(20) NOT NULL,
  `rtnDate` date NOT NULL,
  `rtnQty` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `rntCmnts` text NOT NULL,
  `idSrialno` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_order_return`
--

INSERT INTO `customer_order_return` (`idCustOrderRtn`, `idDispatchcustomer`, `idDispatchProductBatch`, `credit_note_no`, `rtnDate`, `rtnQty`, `status`, `rntCmnts`, `idSrialno`) VALUES
(1, 1, 1, 'R070120120348T826N', '2020-01-07', 1, 1, '', '3|4|5|6|7'),
(2, 10, 18, 'R210120114808T520N', '2020-01-21', 1, 1, '', '575|576|577|578|579');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_return_credit_status`
--

CREATE TABLE `customer_order_return_credit_status` (
  `idCreditstatusreturn` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `credit_date` date NOT NULL,
  `credit_note_no` varchar(30) NOT NULL,
  `credit_amount` decimal(11,2) NOT NULL,
  `wo_tax_credit_amount` decimal(11,2) NOT NULL,
  `approval_amount` decimal(11,2) NOT NULL,
  `credit_status` int(1) NOT NULL,
  `tax_status` int(1) NOT NULL COMMENT 'Avail=1,Notavail=2',
  `idLevel` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dcsequence_items`
--

CREATE TABLE `dcsequence_items` (
  `idDCsequenceitems` int(11) NOT NULL,
  `idDCsequence` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `Sequenceno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dcsequence_items`
--

INSERT INTO `dcsequence_items` (`idDCsequenceitems`, `idDCsequence`, `idOrder`, `Sequenceno`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 3, 1),
(4, 3, 4, 2),
(5, 4, 5, 6),
(6, 4, 12, 5),
(7, 4, 13, 4),
(8, 4, 17, 3),
(9, 4, 7, 2),
(10, 4, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dc_sequence`
--

CREATE TABLE `dc_sequence` (
  `idDCsequence` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dc_sequence`
--

INSERT INTO `dc_sequence` (`idDCsequence`, `created_by`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `idDesignation` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`idDesignation`, `name`, `status`, `created_by`, `updated_by`) VALUES
(1, 'Sales manager', 1, 1, NULL),
(2, 'Sales executive', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_customer`
--

CREATE TABLE `dispatch_customer` (
  `idDispatchcustomer` int(11) NOT NULL,
  `idDispatchVehicle` int(11) NOT NULL,
  `idWarehouse` int(11) NOT NULL,
  `idOrderallocate` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `idLevel` int(11) NOT NULL,
  `deliveryAddress` text NOT NULL,
  `delivery_date` date NOT NULL,
  `dcNo` varchar(25) NOT NULL,
  `invoiceNo` varchar(25) NOT NULL,
  `invoice_amt` decimal(11,2) NOT NULL,
  `delivry_sequence` int(11) NOT NULL,
  `totalWeight` decimal(11,2) NOT NULL,
  `rplc_misg_refrence` int(1) NOT NULL,
  `tax_status` int(1) NOT NULL COMMENT '1=With CForm , 2=Without CForm',
  `cform_file` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dispatch_customer`
--

INSERT INTO `dispatch_customer` (`idDispatchcustomer`, `idDispatchVehicle`, `idWarehouse`, `idOrderallocate`, `idOrder`, `idCustomer`, `idLevel`, `deliveryAddress`, `delivery_date`, `dcNo`, `invoiceNo`, `invoice_amt`, `delivry_sequence`, `totalWeight`, `rplc_misg_refrence`, `tax_status`, `cform_file`) VALUES
(1, 1, 1, 1, 1, 1, 0, 'India,TamilnaduChennai600018', '2020-01-04', 'DCNO20200104134505', 'INVC20200104134505', '196.00', 1, '1000.00', 0, 0, '0'),
(2, 2, 1, 2, 2, 3, 0, 'India,PondicherryKaraikkal609601', '2020-01-04', 'DCNO20200104134615', 'INVC20200104134615', '78.40', 1, '1000.00', 0, 0, '0'),
(3, 3, 1, 3, 3, 1, 0, 'India,TamilnaduChennai600018', '2020-01-04', 'DCNO20200104140211', 'INVC20200104140211', '157669.76', 1, '1000.00', 0, 0, '0'),
(4, 4, 1, 4, 4, 3, 0, 'India,PondicherryKaraikkal609601', '2020-01-04', 'DCNO20200104140211', 'INVC20200104140211', '63067.90', 2, '1000.00', 0, 0, '0'),
(5, 5, 1, 10, 9, 5, 0, 'India,TamilnaduChennai', '2020-01-07', 'DCNO20200107175049', 'INVC20200107175049', '1820.00', 1, '1000.00', 0, 0, '0'),
(6, 6, 1, 7, 7, 5, 0, 'India,TamilnaduChennai', '2020-01-07', 'DCNO20200107175049', 'INVC20200107175049', '196.00', 2, '1000.00', 0, 0, '0'),
(7, 7, 1, 9, 17, 5, 0, 'India,TamilnaduChennai', '2020-01-07', 'DCNO20200107175049', 'INVC20200107175049', '22.40', 3, '1000.00', 0, 0, '0'),
(8, 8, 1, 8, 13, 1, 0, 'India,TamilnaduChennai600018', '2020-01-07', 'DCNO20200107175049', 'INVC20200107175049', '448.00', 4, '1000.00', 0, 0, '0'),
(9, 9, 1, 6, 12, 1, 0, 'India,TamilnaduChennai600018', '2020-01-07', 'DCNO20200107175050', 'INVC20200107175050', '442.40', 5, '1000.00', 0, 0, '0'),
(10, 10, 1, 5, 5, 1, 0, 'India,TamilnaduChennai600018', '2020-01-07', 'DCNO20200107175050', 'INVC20200107175050', '896.00', 6, '1000.00', 0, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_product`
--

CREATE TABLE `dispatch_product` (
  `idDispatchProduct` int(11) NOT NULL,
  `idDispatchcustomer` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProdSize` int(11) NOT NULL,
  `offer_flog` int(11) NOT NULL DEFAULT '0',
  `idOffer` int(11) NOT NULL DEFAULT '0',
  `idOrderItem` int(11) NOT NULL,
  `dis_Qty` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dispatch_product`
--

INSERT INTO `dispatch_product` (`idDispatchProduct`, `idDispatchcustomer`, `idProduct`, `idProdSize`, `offer_flog`, `idOffer`, `idOrderItem`, `dis_Qty`) VALUES
(1, 1, 1, 1, 1, 0, 1, 5),
(2, 1, 1, 2, 1, 0, 2, 5),
(3, 2, 1, 1, 1, 0, 3, 2),
(4, 2, 1, 2, 1, 0, 4, 2),
(5, 3, 3, 5, 1, 0, 7, 5),
(6, 3, 4, 7, 1, 0, 5, 5),
(7, 3, 4, 8, 1, 0, 6, 5),
(8, 4, 3, 5, 1, 0, 10, 2),
(9, 4, 4, 7, 1, 0, 8, 2),
(10, 4, 4, 8, 1, 0, 9, 2),
(11, 5, 4, 7, 1, 0, 17, 45),
(12, 5, 4, 8, 1, 0, 18, 50),
(13, 6, 2, 3, 1, 0, 14, 5),
(14, 7, 4, 8, 1, 0, 30, 2),
(15, 8, 4, 7, 1, 0, 24, 16),
(16, 9, 1, 1, 1, 0, 22, 11),
(17, 9, 1, 2, 1, 0, 23, 12),
(18, 10, 1, 1, 1, 0, 11, 20),
(19, 10, 1, 2, 1, 0, 12, 30);

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_product_batch`
--

CREATE TABLE `dispatch_product_batch` (
  `idDispatchProductBatch` int(11) NOT NULL,
  `idDispatchProduct` int(11) NOT NULL,
  `idWhStockItem` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dispatch_product_batch`
--

INSERT INTO `dispatch_product_batch` (`idDispatchProductBatch`, `idDispatchProduct`, `idWhStockItem`, `qty`) VALUES
(1, 1, 1, 5),
(2, 2, 5, 5),
(3, 3, 1, 2),
(4, 4, 5, 2),
(5, 5, 6, 5),
(6, 6, 3, 5),
(7, 7, 4, 5),
(8, 8, 6, 2),
(9, 9, 3, 2),
(10, 10, 4, 2),
(11, 11, 25, 45),
(12, 12, 26, 50),
(13, 13, 24, 5),
(14, 14, 4, 2),
(15, 15, 25, 16),
(16, 16, 23, 11),
(17, 17, 27, 12),
(18, 18, 23, 20),
(19, 19, 27, 30);

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_route`
--

CREATE TABLE `dispatch_route` (
  `idSelectRoute` int(11) NOT NULL,
  `idDispatchRoute` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `idLevel` int(11) NOT NULL,
  `vech` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_vehicle`
--

CREATE TABLE `dispatch_vehicle` (
  `idDispatchVehicle` int(11) NOT NULL,
  `idVechileType` int(11) NOT NULL,
  `idTransport` int(11) NOT NULL,
  `idLevel` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `idServiceBy` int(11) NOT NULL,
  `vehicleNo` varchar(25) NOT NULL,
  `vehicleCapacity` int(11) NOT NULL,
  `totalKM` varchar(15) NOT NULL,
  `perKMamount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `totalAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `other_charges` decimal(11,2) NOT NULL DEFAULT '0.00',
  `dc_no` varchar(35) NOT NULL,
  `reimburse_amount` decimal(11,2) NOT NULL,
  `creditnote_status` int(1) NOT NULL,
  `deliveryNo` varchar(25) NOT NULL,
  `deliveryDate` date NOT NULL,
  `handling_charges` decimal(11,2) NOT NULL,
  `handling_status` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dispatch_vehicle`
--

INSERT INTO `dispatch_vehicle` (`idDispatchVehicle`, `idVechileType`, `idTransport`, `idLevel`, `idCustomer`, `idServiceBy`, `vehicleNo`, `vehicleCapacity`, `totalKM`, `perKMamount`, `totalAmount`, `other_charges`, `dc_no`, `reimburse_amount`, `creditnote_status`, `deliveryNo`, `deliveryDate`, `handling_charges`, `handling_status`, `status`) VALUES
(1, 1, 1, 0, 1, 0, 'VH1230', 1000, '50', '0.67', '33.33', '100.00', 'DCNO20200104134505', '24.50', 2, 'DLVRY20200104134505', '2020-01-04', '100.00', 2, 0),
(2, 1, 1, 0, 3, 0, 'VH5432', 1000, '200', '0.67', '133.33', '100.00', 'DCNO20200104134615', '0.00', 0, 'DLVRY20200104134615', '2020-01-04', '0.00', 0, 0),
(3, 1, 1, 0, 1, 0, 'VH1234', 1000, '100', '0.67', '66.67', '200.00', 'DCNO20200104140211', '0.00', 0, 'DLVRY20200104140211', '2020-01-04', '0.00', 0, 0),
(4, 1, 1, 0, 3, 0, 'VH1234', 1000, '100', '0.67', '66.67', '200.00', 'DCNO20200104140211', '0.00', 0, 'DLVRY20200104140211', '2020-01-04', '0.00', 0, 0),
(5, 1, 1, 0, 5, 0, 'VH5423', 1000, '100', '0.67', '66.67', '100.00', 'DCNO20200107175048', '0.00', 0, 'DLVRY20200107175048', '2020-01-07', '0.00', 0, 0),
(6, 1, 1, 0, 5, 0, 'VH5423', 1000, '100', '0.67', '66.67', '100.00', 'DCNO20200107175048', '0.00', 0, 'DLVRY20200107175048', '2020-01-07', '0.00', 0, 0),
(7, 1, 1, 0, 5, 0, 'VH5423', 1000, '100', '0.67', '66.67', '100.00', 'DCNO20200107175048', '0.00', 0, 'DLVRY20200107175048', '2020-01-07', '0.00', 0, 0),
(8, 1, 1, 0, 1, 0, 'VH5423', 1000, '100', '0.67', '66.67', '100.00', 'DCNO20200107175049', '56.00', 2, 'DLVRY20200107175049', '2020-01-07', '0.00', 0, 0),
(9, 1, 1, 0, 1, 0, 'VH5423', 1000, '100', '0.67', '66.67', '100.00', 'DCNO20200107175049', '0.00', 0, 'DLVRY20200107175049', '2020-01-07', '0.00', 0, 0),
(10, 1, 1, 0, 1, 0, 'VH5423', 1000, '100', '0.67', '66.67', '100.00', 'DCNO20200107175049', '0.00', 0, 'DLVRY20200107175049', '2020-01-07', '0.00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `distribution_margin`
--

CREATE TABLE `distribution_margin` (
  `idDistributionMargin` int(11) NOT NULL,
  `idProduct` int(11) DEFAULT NULL,
  `idProductsize` int(11) DEFAULT NULL,
  `idPrimaryPackaging` int(11) DEFAULT NULL,
  `idTerritory` int(11) DEFAULT NULL,
  `idTerritoryTitle` int(11) DEFAULT NULL,
  `idCustomerType` int(11) DEFAULT NULL,
  `distributn_type` int(11) DEFAULT NULL COMMENT 'unit=1,percent=2',
  `idGst` int(11) DEFAULT NULL,
  `distributn_unit` decimal(11,2) DEFAULT NULL,
  `distributn_percent` decimal(11,2) DEFAULT NULL,
  `distributn_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distribution_margin`
--

INSERT INTO `distribution_margin` (`idDistributionMargin`, `idProduct`, `idProductsize`, `idPrimaryPackaging`, `idTerritory`, `idTerritoryTitle`, `idCustomerType`, `distributn_type`, `idGst`, `distributn_unit`, `distributn_percent`, `distributn_date`) VALUES
(1, 1, 1, 1, 14, 4, 5, 1, 1, '1.50', NULL, '2020-01-14'),
(2, 1, 2, 2, 14, 4, 5, 1, 1, '1.50', NULL, '2020-01-14'),
(3, 1, 1, 1, 14, 4, 4, 1, 1, '1.50', NULL, '2020-01-14'),
(4, 1, 2, 2, 14, 4, 4, 1, 1, '1.50', NULL, '2020-01-14'),
(5, 1, 1, 1, 14, 4, 3, 1, 1, '1.50', NULL, '2020-01-14'),
(6, 1, 2, 2, 14, 4, 3, 1, 1, '1.50', NULL, '2020-01-14'),
(7, 1, 1, 1, 14, 4, 2, 1, 1, '1.50', NULL, '2020-01-14'),
(8, 1, 2, 2, 14, 4, 2, 1, 1, '1.50', NULL, '2020-01-14'),
(9, 1, 1, 1, 8, 4, 5, 1, 1, '1.00', NULL, '2020-01-01'),
(10, 1, 2, 2, 8, 4, 5, 1, 1, '1.00', NULL, '2020-01-01'),
(11, 2, 3, 1, 8, 4, 5, 1, 1, '1.00', NULL, '2020-01-01'),
(12, 3, 5, 2, 8, 4, 5, 1, 3, '1.00', NULL, '2020-01-01'),
(13, 4, 7, 1, 8, 4, 5, 1, 1, '1.50', NULL, '2020-01-01'),
(14, 1, 1, 1, 8, 4, 4, 1, 1, '1.00', NULL, '2020-01-01'),
(15, 1, 2, 2, 8, 4, 4, 1, 1, '1.00', NULL, '2020-01-01'),
(16, 2, 3, 1, 8, 4, 4, 1, 1, '1.00', NULL, '2020-01-01'),
(17, 3, 5, 2, 8, 4, 4, 1, 3, '1.00', NULL, '2020-01-01'),
(18, 4, 7, 1, 8, 4, 4, 1, 1, '1.00', NULL, '2020-01-01'),
(19, 1, 1, 1, 8, 4, 3, 1, 1, '1.00', NULL, '2020-01-01'),
(20, 1, 2, 2, 8, 4, 3, 1, 1, '1.00', NULL, '2020-01-01'),
(21, 2, 3, 1, 8, 4, 3, 1, 1, '1.00', NULL, '2020-01-01'),
(22, 3, 5, 2, 8, 4, 3, 1, 3, '1.00', NULL, '2020-01-01'),
(23, 4, 7, 1, 8, 4, 3, 1, 1, '1.00', NULL, '2020-01-01'),
(24, 1, 1, 1, 8, 4, 2, 1, 1, '1.00', NULL, '2020-01-01'),
(25, 1, 2, 2, 8, 4, 2, 1, 1, '1.00', NULL, '2020-01-01'),
(26, 2, 3, 1, 8, 4, 2, 1, 1, '1.00', NULL, '2020-01-01'),
(27, 3, 5, 2, 8, 4, 2, 1, 3, '1.00', NULL, '2020-01-01'),
(28, 4, 7, 1, 8, 4, 2, 1, 1, '1.00', NULL, '2020-01-01'),
(29, 1, 1, 1, 8, 4, 1, 1, 1, '1.00', NULL, '2020-01-01'),
(30, 1, 2, 2, 8, 4, 1, 1, 1, '1.00', NULL, '2020-01-01'),
(31, 2, 3, 1, 8, 4, 1, 1, 1, '1.00', NULL, '2020-01-01'),
(32, 3, 5, 2, 8, 4, 1, 1, 3, '1.00', NULL, '2020-01-01'),
(33, 4, 7, 1, 8, 4, 1, 1, 1, '1.00', NULL, '2020-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `empAddcart`
--

CREATE TABLE `empAddcart` (
  `idAddcart` int(11) NOT NULL,
  `idTerritory` int(11) NOT NULL DEFAULT '0',
  `idProduct` int(11) NOT NULL,
  `idProductsize` int(11) NOT NULL,
  `orderQty` int(11) NOT NULL,
  `idTeammember` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=not ordered, 2=Ordered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `empAddcart`
--

INSERT INTO `empAddcart` (`idAddcart`, `idTerritory`, `idProduct`, `idProductsize`, `orderQty`, `idTeammember`, `idCustomer`, `created_by`, `status`) VALUES
(1, 8, 1, 1, 20, 1, 1, 1, 2),
(2, 8, 1, 2, 30, 1, 1, 1, 2),
(3, 8, 2, 3, 5, 1, 5, 1, 2),
(7, 12, 1, 2, 30, 1, 3, 1, 2),
(8, 12, 4, 7, 20, 1, 3, 1, 2),
(9, 8, 4, 7, 45, 1, 5, 1, 2),
(10, 8, 4, 8, 50, 1, 5, 1, 2),
(11, 11, 2, 3, 25, 1, 5, 1, 2),
(12, 12, 4, 7, 10, 1, 3, 1, 2),
(13, 12, 1, 1, 30, 1, 3, 1, 2),
(14, 11, 1, 2, 12, 1, 1, 1, 2),
(15, 11, 1, 1, 11, 1, 1, 1, 2),
(16, 13, 4, 7, 16, 1, 1, 1, 2),
(17, 8, 3, 5, 5, 1, 1, 1, 1),
(18, 8, 2, 3, 30, 1, 2, 1, 2),
(19, 8, 1, 2, 100, 1, 2, 1, 2),
(20, 13, 4, 8, 25, 1, 4, 1, 2),
(21, 13, 4, 7, 30, 1, 4, 1, 2),
(22, 9, 4, 7, 20, 1, 5, 1, 2),
(23, 11, 4, 8, 2, 1, 5, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave`
--

CREATE TABLE `employee_leave` (
  `IdEmployeeLeave` int(11) NOT NULL,
  `idTeamMember` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `remarks` text NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee_leave`
--

INSERT INTO `employee_leave` (`IdEmployeeLeave`, `idTeamMember`, `from_date`, `to_date`, `remarks`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 6, '2020-01-20', '2020-01-20', 'TEST', 1, 1, '2020-01-13 12:11:48', 1, '2020-01-20 11:19:30'),
(2, 1, '2020-01-21', '2020-01-21', 'pongal', 1, 1, '2020-01-20 11:19:52', NULL, NULL),
(3, 1, '2020-01-20', '2020-01-20', 'fever', 1, 1, '2020-01-20 15:21:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `factory_master`
--

CREATE TABLE `factory_master` (
  `idFactory` int(11) NOT NULL,
  `factoryName` varchar(50) NOT NULL,
  `factoryMobileno` varchar(11) NOT NULL,
  `factoryEmail` varchar(50) NOT NULL,
  `t1` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t2` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t3` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t4` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t5` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t6` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t7` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t8` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t9` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `t10` int(11) NOT NULL DEFAULT '0' COMMENT 'idTerritory',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'userId',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL COMMENT 'userId',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `factory_master`
--

INSERT INTO `factory_master` (`idFactory`, `factoryName`, `factoryMobileno`, `factoryEmail`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Factory one', '7887878787', 'factoryone@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, '2019-12-04 10:40:34', 1, '2019-12-16 11:03:54', 1, 1),
(2, 'factory two', '8978787878', 'factorytwo@gmail.com', 1, 2, 3, 9, 0, 0, 0, 0, 0, 0, '2019-12-04 10:41:57', 1, '2019-12-16 11:04:00', 1, 1),
(3, 'Factory three', '9878784542', 'email@gmail.com', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-14 10:34:17', 1, '2020-01-14 10:34:17', 1, 1),
(4, 'Factory four', '9586472563', 'fac4@gmail.com', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-20 09:52:44', 39, '2020-01-20 09:52:44', 39, 1),
(5, 'Factory five', '9586472564', 'fact5@gmail.com', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-20 09:52:44', 39, '2020-01-20 09:52:44', 39, 1),
(6, 'Factory six', '9586472565', 'fact7@gmail.com', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-20 09:52:44', 39, '2020-01-20 09:52:44', 39, 1);

-- --------------------------------------------------------

--
-- Table structure for table `factory_order`
--

CREATE TABLE `factory_order` (
  `idFactoryOrder` int(11) NOT NULL,
  `idFactory` int(11) DEFAULT NULL,
  `idWarehouse` int(11) DEFAULT NULL,
  `po_number` varchar(20) DEFAULT NULL,
  `po_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `factory_order`
--

INSERT INTO `factory_order` (`idFactoryOrder`, `idFactory`, `idWarehouse`, `po_number`, `po_date`) VALUES
(1, 2, 1, 'TCC130120035658', '2020-01-13'),
(2, 2, 1, 'TCC130120040546', '2020-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `factory_order_items`
--

CREATE TABLE `factory_order_items` (
  `idFactryOrdItem` int(11) NOT NULL,
  `idFactoryOrder` int(11) DEFAULT NULL,
  `idProduct` int(11) DEFAULT NULL,
  `idProdSize` int(11) DEFAULT NULL,
  `item_qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `factory_order_items`
--

INSERT INTO `factory_order_items` (`idFactryOrdItem`, `idFactoryOrder`, `idProduct`, `idProdSize`, `item_qty`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 2, 1),
(3, 1, 2, 3, 1),
(4, 1, 4, 7, 1),
(5, 1, 4, 8, 1),
(6, 2, 1, 1, 1),
(7, 2, 1, 2, 1),
(8, 2, 2, 3, 1),
(9, 2, 4, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `factory_products`
--

CREATE TABLE `factory_products` (
  `idFactoryProduct` int(11) NOT NULL,
  `idFactory` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  `idSubCategory` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `factory_products`
--

INSERT INTO `factory_products` (`idFactoryProduct`, `idFactory`, `idCategory`, `idSubCategory`, `idProduct`) VALUES
(18, 1, 1, 1, 1),
(19, 1, 1, 1, 2),
(20, 1, 2, 2, 3),
(21, 1, 1, 1, 4),
(22, 2, 1, 1, 1),
(23, 2, 1, 1, 2),
(24, 2, 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `followup_detail_list`
--

CREATE TABLE `followup_detail_list` (
  `id_followup_detail_list` int(11) NOT NULL,
  `idpjpList` int(11) NOT NULL,
  `idSalesHirchyEmployee` varchar(15) NOT NULL,
  `idVisit` int(11) NOT NULL,
  `payee_text` varchar(250) NOT NULL,
  `payee_mail` varchar(100) NOT NULL,
  `payee_mobile` varchar(25) NOT NULL,
  `lattitude_value` varchar(25) NOT NULL,
  `longitude_value` varchar(25) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_location` varchar(250) NOT NULL,
  `followUpDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `follwoup`
--

CREATE TABLE `follwoup` (
  `id_follow_up` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `idpjpList` int(11) NOT NULL DEFAULT '0',
  `date_add` date NOT NULL,
  `idVisit` int(11) NOT NULL DEFAULT '0',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `mobile_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `remark` text NOT NULL,
  `followup_status` int(1) NOT NULL COMMENT '1=pending,2=Completed',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `follwoup`
--

INSERT INTO `follwoup` (`id_follow_up`, `id_customer`, `idpjpList`, `date_add`, `idVisit`, `start_time`, `end_time`, `mobile_no`, `email_id`, `remark`, `followup_status`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 1, 0, '2019-11-26', 0, '17:00:00', '18:00:00', '7896541230', 'ragu@gmail.com', 'pm ragu@gmail.com7896541230 7896541230', 1, 1, '2019-12-19 16:49:52', NULL, NULL),
(2, 1, 0, '2019-11-27', 1, '17:00:00', '18:00:00', '7896541230', 'ragu@gmail.com', 'pm ragu@gmail.com7896541230 7896541230', 1, 1, '2019-12-19 18:04:56', NULL, NULL),
(3, 1, 0, '2019-11-28', 1, '17:00:00', '18:00:00', '7896541230', 'ragu@gmail.com', 'pm ragu@gmail.com7896541230 7896541230', 1, 1, '2019-12-19 18:10:22', NULL, NULL),
(4, 2, 0, '2019-12-20', 3, '11:00:00', '12:00:00', '9698222689', 'vaithi@gmail.com', 'bcmn', 1, 1, '2019-12-20 11:00:51', NULL, NULL),
(5, 1, 0, '2019-12-20', 2, '14:44:00', '14:45:00', '8098861238', 'ragu@gmail.com', 'cbbcbk', 1, 1, '2019-12-20 14:45:11', 1, '2019-12-20 14:46:09'),
(6, 1, 2, '2019-12-21', 3, '17:00:00', '17:35:00', '8098861238', 'test@gmail.com', 'xggjjk', 1, 1, '2019-12-21 17:00:37', NULL, NULL),
(7, 1, 0, '2019-12-24', 1, '12:36:00', '12:50:00', '8080800080', 'testapp@gmail.com', 'test. app tuoo', 1, 1, '2019-12-24 11:28:55', 1, '2019-12-24 12:37:34'),
(8, 1, 0, '2019-12-26', 1, '14:00:00', '15:00:00', '8098861238', 'ragghu@gmail.com', 'add some', 1, 1, '2019-12-26 14:00:26', 1, '2019-12-26 14:00:34'),
(9, 1, 0, '2019-12-30', 1, '15:38:00', '15:50:00', '8098861238', '', 'test follow ip', 1, 1, '2019-12-30 15:39:09', NULL, NULL),
(10, 3, 0, '2019-12-30', 2, '15:41:00', '16:00:00', '9874465656', 'test@hmail.com', 'dvdn', 1, 1, '2019-12-30 15:42:14', NULL, NULL),
(11, 1, 0, '2020-01-08', 1, '15:42:00', '16:55:00', '8098861238', 'yuvammd94@gmail.com', 'test app', 1, 1, '2020-01-08 15:42:29', NULL, NULL),
(12, 15, 0, '2020-01-20', 1, '12:31:00', '13:15:00', '9865321555', 'antony@gmail.com', 'test follow up 20/1/2020', 1, 1, '2020-01-20 12:31:32', 1, '2020-01-20 12:32:15'),
(13, 1, 0, '2020-01-25', 2, '10:38:00', '11:38:00', '8098861238', '', 'dfh', 1, 1, '2020-01-21 10:38:59', NULL, NULL),
(14, 5, 0, '2020-01-21', 1, '10:40:00', '11:45:00', '4545454546', 'tedt@gmail.com', 'fhhjkj', 1, 1, '2020-01-21 10:40:51', NULL, NULL),
(15, 3, 0, '2020-01-21', 1, '10:44:00', '11:50:00', '9874465656', '', 'test follo paul', 1, 1, '2020-01-21 10:44:38', NULL, NULL),
(16, 1, 0, '2020-01-21', 1, '10:45:00', '11:45:00', '8098861238', '', 'bfnhmj', 1, 1, '2020-01-21 10:45:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fulfillment_master`
--

CREATE TABLE `fulfillment_master` (
  `idFulfillment` int(11) NOT NULL,
  `fulfillmentName` varchar(50) NOT NULL,
  `fulfillmentMobileno` varchar(50) NOT NULL,
  `fulfillmentEmail` varchar(50) NOT NULL,
  `t1` int(11) NOT NULL,
  `t2` int(11) NOT NULL,
  `t3` int(11) NOT NULL,
  `t4` int(11) NOT NULL,
  `t5` int(11) NOT NULL,
  `t6` int(11) NOT NULL,
  `t7` int(11) NOT NULL,
  `t8` int(11) NOT NULL,
  `t9` int(11) NOT NULL,
  `t10` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fulfillment_master`
--

INSERT INTO `fulfillment_master` (`idFulfillment`, `fulfillmentName`, `fulfillmentMobileno`, `fulfillmentEmail`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Fulfillment one', '8798787878', 'one@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, '2019-12-04 13:49:35', 1, NULL, NULL),
(2, 'Fulfillment  two', '9897979797', 'two@gmail.com', 1, 4, 6, 10, 0, 0, 0, 0, 0, 0, 1, '2019-12-04 13:50:29', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `geography`
--

CREATE TABLE `geography` (
  `idGeography` int(11) NOT NULL,
  `idGeographyTitle` int(11) NOT NULL,
  `geoCode` varchar(15) NOT NULL,
  `geoValue` varchar(25) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geography`
--

INSERT INTO `geography` (`idGeography`, `idGeographyTitle`, `geoCode`, `geoValue`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'IND101', 'India', 1, '2020-01-04 10:36:31', 1, '2020-01-04 10:36:31', 1),
(2, 2, 'TN102', 'Tamilnadu', 1, '2019-12-04 09:40:40', 1, '2019-12-04 09:40:40', 1),
(3, 3, 'CHN103', 'Chennai', 1, '2019-12-04 09:41:03', 1, '2019-12-04 09:41:03', 1),
(4, 2, 'KRN104', 'karnataka', 1, '2019-12-04 09:42:35', 1, '2019-12-04 09:42:35', 1),
(5, 2, 'PND105', 'Pondicherry', 1, '2020-01-04 10:36:19', 1, '2020-01-04 10:36:19', 1),
(6, 3, 'KRL106', 'Karaikkal', 1, '2019-12-04 09:43:43', 1, '2019-12-04 09:43:43', 1),
(7, 3, 'BNG107', 'Bangalore', 1, '2019-12-04 09:44:03', 1, '2019-12-04 09:44:03', 1),
(8, 4, 'PIN109', '600018', 1, '2019-12-04 09:44:29', 1, '2019-12-04 09:44:29', 1),
(9, 4, 'PIN110', '609602', 1, '2019-12-04 09:44:57', 1, '2019-12-04 09:44:57', 1),
(10, 4, 'PIN111', '500501', 1, '2019-12-04 09:45:12', 1, '2019-12-04 09:45:12', 1),
(11, 4, 'PIN112', '600024', 1, '2019-12-04 09:45:50', 1, '2019-12-04 09:45:50', 1),
(12, 4, 'PIN113', '609601', 1, '2019-12-04 09:46:17', 1, '2019-12-04 09:46:17', 1),
(13, 4, 'PIN114', '500502', 1, '2019-12-04 09:46:41', 1, '2019-12-04 09:46:41', 1),
(14, 4, 'PIN574', '608704', 1, '2020-01-07 11:22:17', 1, '2020-01-07 11:22:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `geographymapping_master`
--

CREATE TABLE `geographymapping_master` (
  `idGeographyMapping` int(11) NOT NULL,
  `g1` int(11) NOT NULL,
  `g2` int(11) NOT NULL,
  `g3` int(11) NOT NULL,
  `g4` int(11) NOT NULL,
  `g5` int(11) NOT NULL,
  `g6` int(11) NOT NULL,
  `g7` int(11) NOT NULL,
  `g8` int(11) NOT NULL,
  `g9` int(11) NOT NULL,
  `g10` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geographymapping_master`
--

INSERT INTO `geographymapping_master` (`idGeographyMapping`, `g1`, `g2`, `g3`, `g4`, `g5`, `g6`, `g7`, `g8`, `g9`, `g10`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, '2019-12-04 09:47:03', 1, '2019-12-04 09:47:03', 1),
(2, 1, 4, 7, 10, 0, 0, 0, 0, 0, 0, '2019-12-04 09:47:39', 1, '2019-12-04 09:47:39', 1),
(3, 1, 5, 6, 12, 0, 0, 0, 0, 0, 0, '2019-12-04 09:48:09', 1, '2019-12-04 09:48:09', 1),
(4, 1, 2, 3, 11, 0, 0, 0, 0, 0, 0, '2019-12-04 09:48:36', 1, '2019-12-04 09:48:36', 1),
(5, 1, 4, 7, 13, 0, 0, 0, 0, 0, 0, '2019-12-04 09:49:01', 1, '2019-12-04 09:49:01', 1),
(6, 1, 2, 3, 13, 0, 0, 0, 0, 0, 0, '2019-12-09 10:50:51', 1, '2020-01-07 11:22:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `geographytitle`
--

CREATE TABLE `geographytitle` (
  `idGeographyTitle` int(11) NOT NULL,
  `h1` varchar(25) NOT NULL,
  `h2` varchar(25) NOT NULL,
  `h3` varchar(25) NOT NULL,
  `h4` varchar(25) NOT NULL,
  `h5` varchar(25) NOT NULL,
  `h6` varchar(25) NOT NULL,
  `h7` varchar(25) NOT NULL,
  `h8` varchar(25) NOT NULL,
  `h9` varchar(25) NOT NULL,
  `h10` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `geographytitle_master`
--

CREATE TABLE `geographytitle_master` (
  `idGeographyTitle` int(11) NOT NULL,
  `geography` varchar(10) DEFAULT NULL COMMENT 'H1,H2,..H10',
  `title` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geographytitle_master`
--

INSERT INTO `geographytitle_master` (`idGeographyTitle`, `geography`, `title`) VALUES
(1, 'H1', 'Country'),
(2, 'H2', 'State'),
(3, 'H3', 'City'),
(4, 'H4', 'Pincode'),
(5, 'H5', ''),
(6, 'H6', ''),
(7, 'H7', NULL),
(8, 'H8', NULL),
(9, 'H9', NULL),
(10, 'H10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gst_master`
--

CREATE TABLE `gst_master` (
  `idGst` int(11) NOT NULL,
  `idHsncode` int(11) NOT NULL,
  `gstValue` varchar(20) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst_master`
--

INSERT INTO `gst_master` (`idGst`, `idHsncode`, `gstValue`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, '12', 1, '2019-12-04 10:27:41', 1, '2019-12-04 10:27:41', 1),
(2, 2, '12', 1, '2019-12-04 10:27:46', 1, '2019-12-04 10:27:46', 1),
(3, 3, '5', 1, '2019-12-05 11:04:54', 1, '2019-12-05 11:04:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `handling_charges_master`
--

CREATE TABLE `handling_charges_master` (
  `idHandlingCharges` int(11) NOT NULL,
  `idAgency` int(11) NOT NULL,
  `packaging_type` int(1) NOT NULL COMMENT '1=Primary;2=Secondary',
  `PackageCount` varchar(250) NOT NULL,
  `idPackaging` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'userId',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL COMMENT 'userId'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `handling_charges_master`
--

INSERT INTO `handling_charges_master` (`idHandlingCharges`, `idAgency`, `packaging_type`, `PackageCount`, `idPackaging`, `created_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, '10', 1, '2019-12-04 11:26:47', 1, NULL),
(2, 1, 1, '10', 2, '2019-12-04 11:26:47', 1, NULL),
(3, 1, 2, '100', 1, '2019-12-04 11:26:47', 1, NULL),
(4, 2, 1, '20', 1, '2019-12-09 18:29:23', 1, NULL),
(5, 2, 1, '30', 2, '2019-12-09 18:29:23', 1, NULL),
(6, 2, 2, '100', 1, '2019-12-09 18:29:24', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hsn_details`
--

CREATE TABLE `hsn_details` (
  `idHsncode` int(11) NOT NULL,
  `hsn_code` int(11) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hsn_details`
--

INSERT INTO `hsn_details` (`idHsncode`, `hsn_code`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 101, 'Soap', 1, '2019-12-04 10:27:16', 1, '2019-12-04 10:27:16', 1),
(2, 102, 'Food', 1, '2019-12-04 10:27:28', 1, '2019-12-04 10:27:28', 1),
(3, 103, 'Electranics', 1, '2019-12-05 11:04:45', 1, '2019-12-05 11:04:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventorynorms`
--

CREATE TABLE `inventorynorms` (
  `idInventoryNorms` int(11) NOT NULL,
  `idCustomer` int(11) DEFAULT NULL,
  `idWarehouse` int(11) NOT NULL,
  `idLevel` int(11) DEFAULT NULL,
  `idPackage` int(11) NOT NULL,
  `idProdSize` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `re_level` varchar(35) NOT NULL,
  `re_qty` varchar(35) NOT NULL,
  `re_max_stock` varchar(35) NOT NULL,
  `re_min_stock` varchar(35) NOT NULL,
  `re_days` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventorynorms`
--

INSERT INTO `inventorynorms` (`idInventoryNorms`, `idCustomer`, `idWarehouse`, `idLevel`, `idPackage`, `idProdSize`, `idProduct`, `re_level`, `re_qty`, `re_max_stock`, `re_min_stock`, `re_days`) VALUES
(6, 0, 1, 0, 1, 1, 1, '1', '1', '1', '1', ''),
(7, 0, 1, 0, 2, 2, 1, '', '', '', '', ''),
(8, 0, 1, 0, 1, 3, 2, '', '1', '', '', ''),
(9, 0, 1, 0, 2, 5, 3, '', '', '', '', ''),
(10, 0, 1, 0, 1, 7, 4, '', '', '', '', ''),
(11, 0, 2, 0, 1, 1, 1, '', '', '', '', ''),
(12, 0, 2, 0, 2, 2, 1, '', '1', '', '', ''),
(13, 0, 2, 0, 1, 3, 2, '', '', '', '', ''),
(14, 0, 2, 0, 2, 5, 3, '', '1', '', '', ''),
(15, 0, 2, 0, 1, 7, 4, '', '', '', '', ''),
(21, 1, 3, 1, 1, 1, 1, '', '', '', '', ''),
(22, 1, 3, 1, 2, 2, 1, '', '', '', '', ''),
(23, 1, 3, 1, 2, 5, 3, '', '', '', '', ''),
(24, 1, 3, 1, 1, 7, 4, '', '', '', '', ''),
(25, 1, 3, 1, 1, 9, 4, '5', '5', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `idInvoice` int(11) NOT NULL,
  `uploadDate` date NOT NULL,
  `invoiceDate` date NOT NULL,
  `idCustomer` varchar(10) NOT NULL,
  `idLevel` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL DEFAULT '0',
  `invoiceNo` varchar(25) NOT NULL,
  `invoiceAmt` decimal(11,2) NOT NULL,
  `invoiceTxt` varchar(30) DEFAULT NULL,
  `rplc_misg_refrence` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`idInvoice`, `uploadDate`, `invoiceDate`, `idCustomer`, `idLevel`, `idOrder`, `invoiceNo`, `invoiceAmt`, `invoiceTxt`, `rplc_misg_refrence`) VALUES
(1, '2020-01-04', '2020-01-04', '1', 0, 1, 'INVC20200104134505', '196.00', NULL, 0),
(2, '2020-01-04', '2020-01-04', '3', 0, 2, 'INVC20200104134615', '78.40', NULL, 0),
(3, '2020-01-04', '2020-01-04', '1', 0, 3, 'INVC20200104140211', '157669.76', NULL, 0),
(4, '2020-01-04', '2020-01-04', '3', 0, 4, 'INVC20200104140212', '63067.90', NULL, 0),
(5, '2020-01-07', '2020-01-07', '5', 0, 9, 'INVC20200107175050', '1820.00', NULL, 0),
(6, '2020-01-07', '2020-01-07', '5', 0, 7, 'INVC20200107175050', '196.00', NULL, 0),
(7, '2020-01-07', '2020-01-07', '5', 0, 17, 'INVC20200107175050', '22.40', NULL, 0),
(8, '2020-01-07', '2020-01-07', '1', 0, 13, 'INVC20200107175050', '448.00', NULL, 0),
(9, '2020-01-07', '2020-01-07', '1', 0, 12, 'INVC20200107175050', '442.40', NULL, 0),
(10, '2020-01-07', '2020-01-07', '1', 0, 5, 'INVC20200107175050', '896.00', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payment`
--

CREATE TABLE `invoice_payment` (
  `idPayment` int(11) NOT NULL,
  `idInvoice` int(11) NOT NULL DEFAULT '0',
  `collMemCode` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `idCustomer` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `idLedger` int(11) NOT NULL DEFAULT '0',
  `reciptNo` text NOT NULL,
  `payAmt` varchar(100) NOT NULL DEFAULT '0.00',
  `paidAmount` varchar(100) NOT NULL DEFAULT '0.00',
  `pay_date` date DEFAULT NULL,
  `payType` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `payMode` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `idCredit` int(11) NOT NULL DEFAULT '0',
  `chequeNo` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `chequeDate` date DEFAULT NULL,
  `idBank` int(11) DEFAULT NULL,
  `cardNo` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cardType` int(11) DEFAULT NULL,
  `referenceNo` varchar(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `payee_mobile` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `payee_mail` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `payee_text` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `entryDateTime` datetime DEFAULT NULL,
  `lattitude_value` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `longitude_value` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `latlan_location` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_payment`
--

INSERT INTO `invoice_payment` (`idPayment`, `idInvoice`, `collMemCode`, `idCustomer`, `idLedger`, `reciptNo`, `payAmt`, `paidAmount`, `pay_date`, `payType`, `payMode`, `idCredit`, `chequeNo`, `chequeDate`, `idBank`, `cardNo`, `cardType`, `referenceNo`, `payee_mobile`, `payee_mail`, `payee_text`, `entryDateTime`, `lattitude_value`, `longitude_value`, `latlan_location`) VALUES
(1, 0, '1', '1', 1, '1', '200000', '196', NULL, 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-07 11:45:25', NULL, NULL, NULL),
(2, 1, '1', '1', 1, '1', '196', '0.00', '2020-01-07', 'On Bill', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 0, '1', '5', 1, '2', '500', '0', '2020-01-07', 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, '4545454546', 'm@gmail.com', 'cbj', '2020-01-07 17:35:15', '13.0366424', '80.2539035', NULL),
(4, 0, '1', '3', 1, '3', '10000', '0', '2020-01-07', 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, '9874465656', 'paul@gmail.com', '', '2020-01-07 17:36:01', '13.0365993', '80.2538931', NULL),
(5, 0, '1', '2', 1, '4', '50000', '0', '2020-01-07', 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, '9698222689', 'vaithi@gmail.com', '', '2020-01-07 17:36:46', '13.0366058', '80.2539036', NULL),
(6, 0, '1', '4', 1, '6', '10000', '0', '2020-01-07', 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, '9874455156', 'yuva@gmail.com', '', '2020-01-07 17:37:08', '13.0366133', '80.2538999', NULL),
(7, 0, '1', '3', 1, '7', '20000', '0', '2020-01-07', 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, '9874465656', 'paul@gmail.com', 'ch', '2020-01-07 17:37:32', '13.0366135', '80.2538997', NULL),
(8, 0, '1', '3', 1, '20', '20000', '0', '2020-01-07', 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, '9874465656', 'paul@gmail.com', '', '2020-01-07 17:38:14', '13.0366135', '80.2538997', NULL),
(9, 0, '1', '3', 1, '10', '100000', '0', '2020-01-07', 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, '9874465656', 'paul@gmail.com', '', '2020-01-07 17:39:00', '13.0366135', '80.2538997', NULL),
(10, 0, '1', '5', 1, '24', '50000', '0.00', NULL, 'On Account', 'Cash', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 3, '1', '1', 1, '8', '600', '0.00', '2020-01-08', 'On Bill', 'RTGS', 0, NULL, NULL, NULL, NULL, NULL, 'hjj', '8098861238', 'ragu@gmail.com', 'hjk', '2020-01-08 11:28:45', '13.0366191', '80.2538975', NULL),
(12, 8, '1', '1', 1, '8', '48', '0.00', '2020-01-08', 'On Bill', 'RTGS', 0, NULL, NULL, NULL, NULL, NULL, 'hjj', '8098861238', 'ragu@gmail.com', 'hjk', '2020-01-08 11:28:45', '13.0366191', '80.2538975', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_status`
--

CREATE TABLE `invoice_status` (
  `idInvoice` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `idLevel` int(11) NOT NULL DEFAULT '0',
  `invoice` varchar(35) NOT NULL,
  `credit_amt` decimal(11,2) NOT NULL DEFAULT '0.00',
  `credit_status` int(11) NOT NULL DEFAULT '0',
  `credit_date` date DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `error_list` varchar(20) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_status_list`
--

CREATE TABLE `invoice_status_list` (
  `idIncCom` int(11) NOT NULL,
  `idInvoice` int(11) NOT NULL,
  `idDispatchProduct` int(11) NOT NULL,
  `b_qty` int(11) NOT NULL,
  `a_qty` int(11) NOT NULL,
  `b_price` decimal(11,2) NOT NULL,
  `a_price` decimal(11,2) NOT NULL,
  `b_tax` decimal(11,2) NOT NULL,
  `a_tax` decimal(11,2) NOT NULL,
  `b_tax_amnt` decimal(11,2) NOT NULL,
  `a_tax_amnt` decimal(11,2) NOT NULL,
  `b_tot_amnt` decimal(11,2) NOT NULL,
  `a_tot_amnt` decimal(11,2) NOT NULL,
  `b_dis_amnt` decimal(11,2) NOT NULL,
  `a_dis_amnt` decimal(11,2) NOT NULL,
  `b_net_amnt` decimal(11,2) NOT NULL,
  `a_net_amnt` decimal(11,2) NOT NULL,
  `change_price` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ledger_book`
--

CREATE TABLE `ledger_book` (
  `idLedgerBook` int(11) NOT NULL,
  `ledgerNo` varchar(11) NOT NULL,
  `recieptFromNo` int(11) NOT NULL,
  `recieptToNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ledger_book`
--

INSERT INTO `ledger_book` (`idLedgerBook`, `ledgerNo`, `recieptFromNo`, `recieptToNo`) VALUES
(1, '1', 1, 50),
(16, '123', 10, 60);

-- --------------------------------------------------------

--
-- Table structure for table `ledger_cancel`
--

CREATE TABLE `ledger_cancel` (
  `idLedgerCancel` int(11) NOT NULL,
  `idColEmp` int(11) NOT NULL,
  `idLedger` int(11) NOT NULL,
  `recptNo` int(11) NOT NULL,
  `reason` text NOT NULL,
  `cancelDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ledger_cancel`
--

INSERT INTO `ledger_cancel` (`idLedgerCancel`, `idColEmp`, `idLedger`, `recptNo`, `reason`, `cancelDate`) VALUES
(7, 1, 1, 16, 'test', '2020-01-20');

-- --------------------------------------------------------

--
-- Table structure for table `ledger_details`
--

CREATE TABLE `ledger_details` (
  `idLedger` int(11) NOT NULL,
  `ledgerNo` varchar(15) NOT NULL,
  `recieptFromNo` int(11) NOT NULL,
  `recieptToNo` int(11) NOT NULL,
  `recieptNos` text NOT NULL,
  `totalReciept` int(5) NOT NULL,
  `usedReciept` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `t1` int(11) NOT NULL DEFAULT '0',
  `t2` int(11) NOT NULL DEFAULT '0',
  `t3` int(11) NOT NULL DEFAULT '0',
  `t4` int(11) NOT NULL DEFAULT '0',
  `t5` int(11) NOT NULL DEFAULT '0',
  `t6` int(11) DEFAULT '0',
  `t7` int(11) NOT NULL DEFAULT '0',
  `t8` int(11) NOT NULL DEFAULT '0',
  `t9` int(11) NOT NULL DEFAULT '0',
  `t10` int(11) NOT NULL DEFAULT '0',
  `idColEmp` int(11) NOT NULL,
  `entryDate` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ledger_details`
--

INSERT INTO `ledger_details` (`idLedger`, `ledgerNo`, `recieptFromNo`, `recieptToNo`, `recieptNos`, `totalReciept`, `usedReciept`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `idColEmp`, `entryDate`, `created_by`) VALUES
(1, '1', 1, 50, '5,9,11,12,13,14,15,16,17,18,19,21,22,23,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50', 50, ',1,2,3,4,6,7,20,10,24,8', 1, 5, 7, 13, 0, 0, 0, 0, 0, 0, 1, '2020-01-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `maingroup_master`
--

CREATE TABLE `maingroup_master` (
  `idMainGroup` int(11) NOT NULL,
  `mainGroupName` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'userId',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0' COMMENT 'userId',
  `status` int(11) NOT NULL COMMENT '1=Active,2=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maingroup_master`
--

INSERT INTO `maingroup_master` (`idMainGroup`, `mainGroupName`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'safe harvest', '2019-12-03 18:51:21', 1, '2020-01-04 10:33:11', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `idOrder` int(11) NOT NULL,
  `salesCode` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `poNumber` varchar(100) NOT NULL,
  `poDate` date NOT NULL,
  `idCustthierarchy` int(11) NOT NULL,
  `supply_by` int(11) NOT NULL DEFAULT '0' COMMENT '1=self,2=higher level,3=company emp,4=higher level emp',
  `totalAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `totalCGST` decimal(65,2) NOT NULL DEFAULT '0.00',
  `totalSGST` decimal(65,2) NOT NULL DEFAULT '0.00',
  `totalIGST` decimal(65,2) NOT NULL DEFAULT '0.00',
  `totalUTGST` decimal(65,2) NOT NULL DEFAULT '0.00',
  `total` decimal(65,2) NOT NULL DEFAULT '0.00',
  `totalTax` decimal(65,2) NOT NULL DEFAULT '0.00',
  `grandtotalAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `billingAddress` text,
  `idOrderfullfillment` int(11) NOT NULL DEFAULT '0',
  `order_cancel` int(11) NOT NULL DEFAULT '0' COMMENT '1=Delete, 2=Partially delete',
  `orderFrom` int(11) NOT NULL DEFAULT '1' COMMENT '1=Company or customer, 2=employee',
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `update_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`idOrder`, `salesCode`, `idCustomer`, `poNumber`, `poDate`, `idCustthierarchy`, `supply_by`, `totalAmount`, `totalCGST`, `totalSGST`, `totalIGST`, `totalUTGST`, `total`, `totalTax`, `grandtotalAmount`, `billingAddress`, `idOrderfullfillment`, `order_cancel`, `orderFrom`, `created_by`, `created_at`, `update_by`, `updated_at`, `status`) VALUES
(1, 'SLC101', 1, 'Ragu/ORD/1', '2020-01-04', 8, 0, '175.00', '0.00', '10.50', '0.00', '10.50', '0.00', '21.00', '196.00', 'India,Tamilnadu,Chennai,600018', 1, 0, 1, 1, '2020-01-04 13:43:06', 1, '2020-01-04 13:43:06', 1),
(2, 'SLC103', 3, 'Paul/ORD/1', '2020-01-04', 12, 0, '70.00', '0.00', '4.20', '4.20', '0.00', '0.00', '8.40', '78.40', 'India,Pondicherry,Karaikkal,609601', 2, 0, 1, 1, '2020-01-04 13:43:39', 1, '2020-01-04 13:43:39', 1),
(3, 'SLC1012', 1, 'Ragu/ORD/2', '2020-01-04', 8, 0, '150150.00', '0.00', '3759.88', '0.00', '3759.88', '0.00', '7519.75', '157669.75', 'India,Tamilnadu,Chennai,600018', 1, 0, 1, 1, '2020-01-04 13:52:10', 1, '2020-01-04 13:52:10', 1),
(4, 'SLC1032', 3, 'Paul/ORD/2', '2020-01-04', 12, 0, '60060.00', '0.00', '1503.95', '1503.95', '0.00', '0.00', '3007.90', '63067.90', 'India,Pondicherry,Karaikkal,609601', 2, 0, 1, 1, '2020-01-04 13:53:16', 1, '2020-01-04 13:53:16', 1),
(5, '101', 1, 'Ragu/ORD/3', '2020-01-07', 8, 0, '800.00', '0.00', '48.00', '0.00', '48.00', '0.00', '96.00', '896.00', 'India,Tamilnadu,Chennai,600018', 1, 0, 2, 1, '2020-01-07 16:46:58', 1, '2020-01-07 16:46:58', 1),
(7, 'dg', 5, 'mari/ORD/1', '2020-01-07', 8, 0, '175.00', '6.30', '4.20', '4.20', '6.30', '0.00', '21.00', '196.00', 'India,Tamilnadu,Chennai', 2, 0, 2, 1, '2020-01-07 16:48:31', 1, '2020-01-07 16:48:31', 1),
(8, 'vdbf', 3, 'Paul/ORD/3', '2020-01-07', 12, 0, '800.00', '0.00', '48.00', '48.00', '0.00', '0.00', '96.00', '896.00', 'India,Pondicherry,Karaikkal,609601', 2, 0, 2, 1, '2020-01-07 16:57:33', 1, '2020-01-07 16:57:33', 1),
(9, 'bdjdk', 5, 'mari/ORD/2', '2020-01-07', 8, 0, '1625.00', '58.50', '39.00', '39.00', '58.50', '0.00', '195.00', '1820.00', 'India,Tamilnadu,Chennai', 2, 0, 2, 1, '2020-01-07 16:58:22', 1, '2020-01-07 16:58:22', 1),
(10, 'dvhd', 5, 'mari/ORD/3', '2020-01-07', 11, 0, '875.00', '52.50', '0.00', '52.50', '0.00', '0.00', '105.00', '980.00', 'India,Tamilnadu,Chennai', 2, 0, 2, 1, '2020-01-07 16:58:54', 1, '2020-01-07 16:58:54', 1),
(11, 'dvbd', 3, 'Paul/ORD/4', '2020-01-07', 12, 0, '1000.00', '0.00', '60.00', '60.00', '0.00', '0.00', '120.00', '1120.00', 'India,Pondicherry,Karaikkal,609601', 1, 0, 2, 1, '2020-01-07 16:59:21', 1, '2020-01-07 16:59:21', 1),
(12, 'dvhd', 1, 'Ragu/ORD/4', '2020-01-07', 11, 0, '395.00', '0.00', '23.70', '0.00', '23.70', '0.00', '47.40', '442.40', 'India,Tamilnadu,Chennai,600018', 1, 0, 2, 1, '2020-01-07 16:59:55', 1, '2020-01-07 16:59:55', 1),
(13, 'dbbd', 1, 'Ragu/ORD/5', '2020-01-07', 13, 0, '400.00', '0.00', '24.00', '24.00', '0.00', '0.00', '48.00', '448.00', 'India,Tamilnadu,Chennai,600018', 1, 0, 2, 1, '2020-01-07 17:00:17', 1, '2020-01-07 17:00:17', 1),
(14, 'rfgr', 2, 'Vaithi/ORD/1', '2020-01-07', 8, 0, '2180.00', '78.48', '52.32', '52.32', '78.48', '0.00', '261.60', '2441.60', 'India,Karnataka,Bangalore,500501', 1, 0, 2, 1, '2020-01-07 17:06:03', 1, '2020-01-07 17:06:03', 1),
(15, 'gddy', 4, 'Yuvarai/ORD/1', '2020-01-07', 13, 0, '1055.00', '0.00', '63.30', '63.30', '0.00', '0.00', '126.60', '1181.60', 'India,Tamilnadu,Chennai,600024', 1, 0, 2, 1, '2020-01-07 17:06:25', 1, '2020-01-07 17:06:25', 1),
(16, 'gui', 5, 'mari/ORD/4', '2020-01-07', 9, 0, '500.00', '18.00', '12.00', '12.00', '18.00', '0.00', '60.00', '560.00', 'India,Tamilnadu,Chennai', 1, 0, 2, 1, '2020-01-07 17:10:07', 1, '2020-01-07 17:10:07', 1),
(17, 'gjkjlkklkl', 5, 'mari/ORD/5', '2020-01-07', 11, 0, '20.00', '1.20', '0.00', '1.20', '0.00', '0.00', '2.40', '22.40', 'India,Tamilnadu,Chennai', 1, 0, 2, 1, '2020-01-07 17:10:50', 1, '2020-01-07 17:10:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_allocated`
--

CREATE TABLE `orders_allocated` (
  `idOrderallocate` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `idWarehouse` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=Allocated, 2=Cancel, 3=Dispatch, 4=Partially Dispatch, 5=Delivered, 6=Partially Delivered',
  `reallocate` int(11) NOT NULL DEFAULT '0' COMMENT 'reallocate=1',
  `rplc_misg_status` int(11) NOT NULL DEFAULT '0' COMMENT 'replace=1,missing=2',
  `rplc_misg_reference` int(11) NOT NULL DEFAULT '0',
  `c_note_number` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_allocated`
--

INSERT INTO `orders_allocated` (`idOrderallocate`, `idOrder`, `idWarehouse`, `status`, `reallocate`, `rplc_misg_status`, `rplc_misg_reference`, `c_note_number`, `created_by`) VALUES
(1, 1, 1, 5, 0, 0, 0, 0, 1),
(2, 2, 1, 5, 0, 0, 0, 0, 1),
(3, 3, 1, 5, 0, 0, 0, 0, 1),
(4, 4, 1, 5, 0, 0, 0, 0, 1),
(5, 5, 1, 5, 0, 0, 0, 0, 1),
(6, 12, 1, 5, 0, 0, 0, 0, 1),
(7, 7, 1, 5, 0, 0, 0, 0, 1),
(8, 13, 1, 5, 0, 0, 0, 0, 1),
(9, 17, 1, 5, 0, 0, 0, 0, 1),
(10, 9, 1, 5, 0, 0, 0, 0, 1),
(11, 10, 1, 1, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_allocated_items`
--

CREATE TABLE `orders_allocated_items` (
  `idOrderallocateditems` int(11) NOT NULL,
  `idOrderallocated` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProductsize` int(11) NOT NULL,
  `idScheme` int(11) NOT NULL DEFAULT '0',
  `offer_flog` int(11) NOT NULL DEFAULT '1' COMMENT '1=Order, 2=Offer',
  `approveQty` int(11) NOT NULL,
  `rejectQty` int(11) NOT NULL,
  `picklistQty` int(11) NOT NULL,
  `pickqty` int(11) NOT NULL DEFAULT '0',
  `dispatchQty` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_allocated_items`
--

INSERT INTO `orders_allocated_items` (`idOrderallocateditems`, `idOrderallocated`, `idProduct`, `idProductsize`, `idScheme`, `offer_flog`, `approveQty`, `rejectQty`, `picklistQty`, `pickqty`, `dispatchQty`) VALUES
(1, 1, 1, 1, 0, 1, 5, 0, 5, 0, 5),
(2, 1, 1, 2, 0, 1, 5, 0, 5, 0, 5),
(3, 2, 1, 1, 0, 1, 2, 0, 2, 0, 2),
(4, 2, 1, 2, 0, 1, 2, 0, 2, 0, 2),
(5, 3, 3, 5, 0, 1, 5, 0, 5, 0, 5),
(6, 3, 4, 7, 0, 1, 5, 0, 5, 0, 5),
(7, 3, 4, 8, 0, 1, 5, 0, 5, 0, 5),
(8, 4, 3, 5, 0, 1, 2, 0, 2, 0, 2),
(9, 4, 4, 7, 0, 1, 2, 0, 2, 0, 2),
(10, 4, 4, 8, 0, 1, 2, 0, 2, 0, 2),
(11, 5, 1, 1, 0, 1, 20, 0, 20, 0, 20),
(12, 5, 1, 2, 0, 1, 30, 0, 30, 0, 30),
(13, 6, 1, 1, 0, 1, 11, 0, 11, 0, 11),
(14, 6, 1, 2, 0, 1, 12, 0, 12, 0, 12),
(15, 7, 2, 3, 0, 1, 5, 0, 5, 0, 5),
(16, 8, 4, 7, 0, 1, 16, 0, 16, 0, 16),
(17, 9, 4, 8, 0, 1, 2, 0, 2, 0, 2),
(18, 10, 4, 7, 0, 1, 45, 0, 45, 0, 45),
(19, 10, 4, 8, 0, 1, 50, 0, 50, 0, 50),
(20, 11, 2, 3, 0, 1, 25, 0, 25, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_cancel_reason`
--

CREATE TABLE `order_cancel_reason` (
  `idOrdercancel` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `idOrderallocate` int(11) NOT NULL DEFAULT '0',
  `reason` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `idOrderitem` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProductsize` int(11) NOT NULL,
  `orderQty` int(11) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `totalAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `cgstAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `sgstAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `igstAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `cgstPercent` decimal(65,2) NOT NULL DEFAULT '0.00',
  `sgstPercent` decimal(65,2) NOT NULL DEFAULT '0.00',
  `igstPercent` decimal(65,2) NOT NULL DEFAULT '0.00',
  `utgstPercent` decimal(65,2) NOT NULL DEFAULT '0.00',
  `utgstAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `discountAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `NetAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `idScheme` int(11) NOT NULL DEFAULT '0',
  `discountQty` int(11) NOT NULL DEFAULT '0',
  `discountJoinid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`idOrderitem`, `idOrder`, `idProduct`, `idProductsize`, `orderQty`, `price`, `totalAmount`, `cgstAmount`, `sgstAmount`, `igstAmount`, `cgstPercent`, `sgstPercent`, `igstPercent`, `utgstPercent`, `utgstAmount`, `discountAmount`, `NetAmount`, `idScheme`, `discountQty`, `discountJoinid`) VALUES
(1, 1, 1, 1, 5, '25.00', '125.00', '0.00', '7.50', '0.00', '0.00', '6.00', '0.00', '6.00', '7.50', '0.00', '125.00', 0, 0, 0),
(2, 1, 1, 2, 5, '10.00', '50.00', '0.00', '3.00', '0.00', '0.00', '6.00', '0.00', '6.00', '3.00', '0.00', '50.00', 0, 0, 0),
(3, 2, 1, 1, 2, '25.00', '50.00', '0.00', '3.00', '3.00', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '50.00', 0, 0, 0),
(4, 2, 1, 2, 2, '10.00', '20.00', '0.00', '1.20', '1.20', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '20.00', 0, 0, 0),
(5, 3, 4, 7, 5, '25.00', '125.00', '0.00', '7.50', '0.00', '0.00', '2.50', '0.00', '2.50', '7.50', '0.00', '125.00', 0, 0, 0),
(6, 3, 4, 8, 5, '10.00', '50.00', '0.00', '3.00', '0.00', '0.00', '2.50', '0.00', '2.50', '3.00', '0.00', '50.00', 0, 0, 0),
(7, 3, 3, 5, 5, '29995.00', '149975.00', '0.00', '3749.38', '0.00', '0.00', '2.50', '0.00', '2.50', '3749.38', '0.00', '149975.00', 0, 0, 0),
(8, 4, 4, 7, 2, '25.00', '50.00', '0.00', '3.00', '3.00', '0.00', '2.50', '2.50', '0.00', '0.00', '0.00', '50.00', 0, 0, 0),
(9, 4, 4, 8, 2, '10.00', '20.00', '0.00', '1.20', '1.20', '0.00', '2.50', '2.50', '0.00', '0.00', '0.00', '20.00', 0, 0, 0),
(10, 4, 3, 5, 2, '29995.00', '59990.00', '0.00', '1499.75', '1499.75', '0.00', '2.50', '2.50', '0.00', '0.00', '0.00', '59990.00', 0, 0, 0),
(11, 5, 1, 1, 20, '25.00', '500.00', '0.00', '30.00', '0.00', '0.00', '6.00', '0.00', '6.00', '30.00', '0.00', '500.00', 0, 0, 0),
(12, 5, 1, 2, 30, '10.00', '300.00', '0.00', '18.00', '0.00', '0.00', '6.00', '0.00', '6.00', '18.00', '0.00', '300.00', 0, 0, 0),
(14, 7, 2, 3, 5, '35.00', '175.00', '6.30', '4.20', '4.20', '3.60', '2.40', '2.40', '3.60', '6.30', '0.00', '175.00', 0, 0, 0),
(15, 8, 1, 2, 30, '10.00', '300.00', '0.00', '18.00', '18.00', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '300.00', 0, 0, 0),
(16, 8, 4, 7, 20, '25.00', '500.00', '0.00', '30.00', '30.00', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '500.00', 0, 0, 0),
(17, 9, 4, 7, 45, '25.00', '1125.00', '40.50', '27.00', '27.00', '3.60', '2.40', '2.40', '3.60', '40.50', '0.00', '1125.00', 0, 0, 0),
(18, 9, 4, 8, 50, '10.00', '500.00', '18.00', '12.00', '12.00', '3.60', '2.40', '2.40', '3.60', '18.00', '0.00', '500.00', 0, 0, 0),
(19, 10, 2, 3, 25, '35.00', '875.00', '52.50', '0.00', '52.50', '6.00', '0.00', '6.00', '0.00', '0.00', '0.00', '875.00', 0, 0, 0),
(20, 11, 1, 1, 30, '25.00', '750.00', '0.00', '45.00', '45.00', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '750.00', 0, 0, 0),
(21, 11, 4, 7, 10, '25.00', '250.00', '0.00', '15.00', '15.00', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '250.00', 0, 0, 0),
(22, 12, 1, 1, 11, '25.00', '275.00', '0.00', '16.50', '0.00', '0.00', '6.00', '0.00', '6.00', '16.50', '0.00', '275.00', 0, 0, 0),
(23, 12, 1, 2, 12, '10.00', '120.00', '0.00', '7.20', '0.00', '0.00', '6.00', '0.00', '6.00', '7.20', '0.00', '120.00', 0, 0, 0),
(24, 13, 4, 7, 16, '25.00', '400.00', '0.00', '24.00', '24.00', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '400.00', 0, 0, 0),
(25, 14, 1, 2, 100, '11.00', '1100.00', '39.60', '26.40', '26.40', '3.60', '2.40', '2.40', '3.60', '39.60', '0.00', '1100.00', 0, 0, 0),
(26, 14, 2, 3, 30, '36.00', '1080.00', '38.88', '25.92', '25.92', '3.60', '2.40', '2.40', '3.60', '38.88', '0.00', '1080.00', 0, 0, 0),
(27, 15, 4, 7, 30, '26.00', '780.00', '0.00', '46.80', '46.80', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '780.00', 0, 0, 0),
(28, 15, 4, 8, 25, '11.00', '275.00', '0.00', '16.50', '16.50', '0.00', '6.00', '6.00', '0.00', '0.00', '0.00', '275.00', 0, 0, 0),
(29, 16, 4, 7, 20, '25.00', '500.00', '18.00', '12.00', '12.00', '3.60', '2.40', '2.40', '3.60', '18.00', '0.00', '500.00', 0, 0, 0),
(30, 17, 4, 8, 2, '10.00', '20.00', '1.20', '0.00', '1.20', '6.00', '0.00', '6.00', '0.00', '0.00', '0.00', '20.00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_picklist_items`
--

CREATE TABLE `order_picklist_items` (
  `idOrdPickList` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `idAllocateOrder` int(11) NOT NULL,
  `idAllocateItem` int(11) NOT NULL,
  `idWarehouse` int(11) NOT NULL,
  `idWhStockItem` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProdSize` int(11) NOT NULL,
  `offer` int(11) NOT NULL DEFAULT '0',
  `pickQty` int(11) NOT NULL,
  `offerPickQty` int(11) NOT NULL DEFAULT '0',
  `idSerialno` text,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0=SendTodispatch, 1=not sendTodispatch'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_picklist_items`
--

INSERT INTO `order_picklist_items` (`idOrdPickList`, `idOrder`, `idAllocateOrder`, `idAllocateItem`, `idWarehouse`, `idWhStockItem`, `idProduct`, `idProdSize`, `offer`, `pickQty`, `offerPickQty`, `idSerialno`, `status`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 0, 5, 0, '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25', 0),
(2, 1, 1, 2, 1, 5, 1, 2, 0, 5, 0, '51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75', 0),
(3, 2, 2, 3, 1, 1, 1, 1, 0, 2, 0, '26|27|28|29|30|31|32|33|34|35', 0),
(4, 2, 2, 4, 1, 5, 1, 2, 0, 2, 0, '76|77|78|79|80|81|82|83|84|85', 0),
(5, 3, 3, 5, 1, 6, 3, 5, 0, 5, 0, '201|202|203|204|205', 0),
(6, 3, 3, 6, 1, 3, 4, 7, 0, 5, 0, '101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125', 0),
(7, 3, 3, 7, 1, 4, 4, 8, 0, 5, 0, '151|152|153|154|155|156|157|158|159|160|161|162|163|164|165|166|167|168|169|170|171|172|173|174|175', 0),
(8, 4, 4, 8, 1, 6, 3, 5, 0, 2, 0, '206|207', 0),
(9, 4, 4, 9, 1, 3, 4, 7, 0, 2, 0, '126|127|128|129|130|131|132|133|134|135', 0),
(10, 4, 4, 10, 1, 4, 4, 8, 0, 2, 0, '176|177|178|179|180|181|182|183|184|185', 0),
(11, 5, 5, 11, 1, 23, 1, 1, 0, 20, 0, '568|569|570|571|572|573|574|575|576|577|578|579|580|581|582|583|584|585|586|587|588|589|590|591|592|593|594|595|596|597|598|599|600|601|602|603|604|605|606|607|608|609|610|611|612|613|614|615|616|617|618|619|620|621|622|623|624|625|626|627|628|629|630|631|632|633|634|635|636|637|638|639|640|641|642|643|644|645|646|647|648|649|650|651|652|653|654|655|656|657|658|659|660|661|662|663|664|665|666|667', 0),
(12, 5, 5, 12, 1, 27, 1, 2, 0, 30, 0, '1068|1069|1070|1071|1072|1073|1074|1075|1076|1077|1078|1079|1080|1081|1082|1083|1084|1085|1086|1087|1088|1089|1090|1091|1092|1093|1094|1095|1096|1097|1098|1099|1100|1101|1102|1103|1104|1105|1106|1107|1108|1109|1110|1111|1112|1113|1114|1115|1116|1117|1118|1119|1120|1121|1122|1123|1124|1125|1126|1127|1128|1129|1130|1131|1132|1133|1134|1135|1136|1137|1138|1139|1140|1141|1142|1143|1144|1145|1146|1147|1148|1149|1150|1151|1152|1153|1154|1155|1156|1157|1158|1159|1160|1161|1162|1163|1164|1165|1166|1167|1168|1169|1170|1171|1172|1173|1174|1175|1176|1177|1178|1179|1180|1181|1182|1183|1184|1185|1186|1187|1188|1189|1190|1191|1192|1193|1194|1195|1196|1197|1198|1199|1200|1201|1202|1203|1204|1205|1206|1207|1208|1209|1210|1211|1212|1213|1214|1215|1216|1217', 0),
(13, 12, 6, 13, 1, 23, 1, 1, 0, 11, 0, '668|669|670|671|672|673|674|675|676|677|678|679|680|681|682|683|684|685|686|687|688|689|690|691|692|693|694|695|696|697|698|699|700|701|702|703|704|705|706|707|708|709|710|711|712|713|714|715|716|717|718|719|720|721|722', 0),
(14, 12, 6, 14, 1, 27, 1, 2, 0, 12, 0, '1218|1219|1220|1221|1222|1223|1224|1225|1226|1227|1228|1229|1230|1231|1232|1233|1234|1235|1236|1237|1238|1239|1240|1241|1242|1243|1244|1245|1246|1247|1248|1249|1250|1251|1252|1253|1254|1255|1256|1257|1258|1259|1260|1261|1262|1263|1264|1265|1266|1267|1268|1269|1270|1271|1272|1273|1274|1275|1276|1277', 0),
(15, 13, 8, 16, 1, 25, 4, 7, 0, 16, 0, '2068|2069|2070|2071|2072|2073|2074|2075|2076|2077|2078|2079|2080|2081|2082|2083|2084|2085|2086|2087|2088|2089|2090|2091|2092|2093|2094|2095|2096|2097|2098|2099|2100|2101|2102|2103|2104|2105|2106|2107|2108|2109|2110|2111|2112|2113|2114|2115|2116|2117|2118|2119|2120|2121|2122|2123|2124|2125|2126|2127|2128|2129|2130|2131|2132|2133|2134|2135|2136|2137|2138|2139|2140|2141|2142|2143|2144|2145|2146|2147', 0),
(16, 17, 9, 17, 1, 4, 4, 8, 0, 2, 0, '186|187|188|189|190|191|192|193|194|195', 0),
(17, 7, 7, 15, 1, 24, 2, 3, 0, 5, 0, '', 0),
(18, 9, 10, 18, 1, 25, 4, 7, 0, 45, 0, '2148|2149|2150|2151|2152|2153|2154|2155|2156|2157|2158|2159|2160|2161|2162|2163|2164|2165|2166|2167|2168|2169|2170|2171|2172|2173|2174|2175|2176|2177|2178|2179|2180|2181|2182|2183|2184|2185|2186|2187|2188|2189|2190|2191|2192|2193|2194|2195|2196|2197|2198|2199|2200|2201|2202|2203|2204|2205|2206|2207|2208|2209|2210|2211|2212|2213|2214|2215|2216|2217|2218|2219|2220|2221|2222|2223|2224|2225|2226|2227|2228|2229|2230|2231|2232|2233|2234|2235|2236|2237|2238|2239|2240|2241|2242|2243|2244|2245|2246|2247|2248|2249|2250|2251|2252|2253|2254|2255|2256|2257|2258|2259|2260|2261|2262|2263|2264|2265|2266|2267|2268|2269|2270|2271|2272|2273|2274|2275|2276|2277|2278|2279|2280|2281|2282|2283|2284|2285|2286|2287|2288|2289|2290|2291|2292|2293|2294|2295|2296|2297|2298|2299|2300|2301|2302|2303|2304|2305|2306|2307|2308|2309|2310|2311|2312|2313|2314|2315|2316|2317|2318|2319|2320|2321|2322|2323|2324|2325|2326|2327|2328|2329|2330|2331|2332|2333|2334|2335|2336|2337|2338|2339|2340|2341|2342|2343|2344|2345|2346|2347|2348|2349|2350|2351|2352|2353|2354|2355|2356|2357|2358|2359|2360|2361|2362|2363|2364|2365|2366|2367|2368|2369|2370|2371|2372', 0),
(19, 9, 10, 19, 1, 26, 4, 8, 0, 50, 0, '1568|1569|1570|1571|1572|1573|1574|1575|1576|1577|1578|1579|1580|1581|1582|1583|1584|1585|1586|1587|1588|1589|1590|1591|1592|1593|1594|1595|1596|1597|1598|1599|1600|1601|1602|1603|1604|1605|1606|1607|1608|1609|1610|1611|1612|1613|1614|1615|1616|1617|1618|1619|1620|1621|1622|1623|1624|1625|1626|1627|1628|1629|1630|1631|1632|1633|1634|1635|1636|1637|1638|1639|1640|1641|1642|1643|1644|1645|1646|1647|1648|1649|1650|1651|1652|1653|1654|1655|1656|1657|1658|1659|1660|1661|1662|1663|1664|1665|1666|1667|1668|1669|1670|1671|1672|1673|1674|1675|1676|1677|1678|1679|1680|1681|1682|1683|1684|1685|1686|1687|1688|1689|1690|1691|1692|1693|1694|1695|1696|1697|1698|1699|1700|1701|1702|1703|1704|1705|1706|1707|1708|1709|1710|1711|1712|1713|1714|1715|1716|1717|1718|1719|1720|1721|1722|1723|1724|1725|1726|1727|1728|1729|1730|1731|1732|1733|1734|1735|1736|1737|1738|1739|1740|1741|1742|1743|1744|1745|1746|1747|1748|1749|1750|1751|1752|1753|1754|1755|1756|1757|1758|1759|1760|1761|1762|1763|1764|1765|1766|1767|1768|1769|1770|1771|1772|1773|1774|1775|1776|1777|1778|1779|1780|1781|1782|1783|1784|1785|1786|1787|1788|1789|1790|1791|1792|1793|1794|1795|1796|1797|1798|1799|1800|1801|1802|1803|1804|1805|1806|1807|1808|1809|1810|1811|1812|1813|1814|1815|1816|1817', 0);

-- --------------------------------------------------------

--
-- Table structure for table `packaging`
--

CREATE TABLE `packaging` (
  `idPackaging` int(11) NOT NULL,
  `packtype` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pjp_detail`
--

CREATE TABLE `pjp_detail` (
  `idpjpdetail` int(11) NOT NULL,
  `idSalesHierarchy` int(11) NOT NULL,
  `idTeamMember` int(11) NOT NULL,
  `idLevel` int(11) NOT NULL,
  `cycle_days` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `idCustomer` int(11) NOT NULL DEFAULT '0',
  `idLevel_cs` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pjp_detail`
--

INSERT INTO `pjp_detail` (`idpjpdetail`, `idSalesHierarchy`, `idTeamMember`, `idLevel`, `cycle_days`, `start_date`, `idCustomer`, `idLevel_cs`) VALUES
(1, 1, 1, 1, 5, '2020-01-01', 0, 0),
(2, 1, 1, 1, 50, '2020-01-16', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pjp_detail_list`
--

CREATE TABLE `pjp_detail_list` (
  `idpjpList` int(11) NOT NULL,
  `idpjpdetail` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `cycle_day` date NOT NULL,
  `idVisit` int(11) DEFAULT '0',
  `idTeamMember` int(11) NOT NULL,
  `visit_date` datetime DEFAULT NULL,
  `visit_location` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `payee_mail` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `payee_text` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `payee_mobile` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `lattitude_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `longitude_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `followUpDateTime` datetime DEFAULT NULL,
  `follow_status` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pjp_detail_list`
--

INSERT INTO `pjp_detail_list` (`idpjpList`, `idpjpdetail`, `idCustomer`, `cycle_day`, `idVisit`, `idTeamMember`, `visit_date`, `visit_location`, `payee_mail`, `payee_text`, `payee_mobile`, `lattitude_value`, `longitude_value`, `followUpDateTime`, `follow_status`) VALUES
(1, 1, 1, '2020-01-02', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(2, 1, 1, '2020-01-03', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, 1, 1, '2020-01-04', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 1, 1, '2020-01-06', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 1, 1, '2020-01-07', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(6, 1, 3, '2020-01-02', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 1, 3, '2020-01-03', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(8, 1, 3, '2020-01-04', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(9, 1, 3, '2020-01-06', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(10, 1, 3, '2020-01-07', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(11, 1, 5, '2020-01-02', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(12, 1, 5, '2020-01-03', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(13, 1, 5, '2020-01-04', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(14, 1, 5, '2020-01-06', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(15, 1, 5, '2020-01-07', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(16, 1, 2, '2020-01-02', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(17, 1, 2, '2020-01-03', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(18, 1, 2, '2020-01-06', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(19, 1, 2, '2020-01-07', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(20, 1, 4, '2020-01-02', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(21, 1, 4, '2020-01-04', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(22, 1, 4, '2020-01-06', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(23, 1, 4, '2020-01-07', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(24, 2, 1, '2020-01-18', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(25, 2, 1, '2020-01-20', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(26, 2, 3, '2020-01-17', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(27, 2, 5, '2020-01-17', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(28, 2, 5, '2020-01-18', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(29, 2, 2, '2020-01-17', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(30, 2, 2, '2020-01-20', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(31, 2, 4, '2020-01-17', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(32, 2, 4, '2020-01-20', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(33, 2, 6, '2020-01-17', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(34, 2, 6, '2020-01-18', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pjp_visit_status`
--

CREATE TABLE `pjp_visit_status` (
  `idVisit` int(11) NOT NULL,
  `pjp_category` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pjp_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pjp_visit_status`
--

INSERT INTO `pjp_visit_status` (`idVisit`, `pjp_category`, `pjp_status`, `created_by`, `updated_by`, `updated_at`) VALUES
(1, 'available', 1, 1, 0, NULL),
(2, 'door closed', 1, 1, 0, NULL),
(3, 'not available', 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `price_fixing`
--

CREATE TABLE `price_fixing` (
  `idPricefixing` int(11) NOT NULL,
  `idTerritoryTitle` int(11) NOT NULL,
  `idTerritory` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProductsize` int(11) NOT NULL,
  `priceDate` date NOT NULL,
  `priceAmount` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `companyCost` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active, 2=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `price_fixing`
--

INSERT INTO `price_fixing` (`idPricefixing`, `idTerritoryTitle`, `idTerritory`, `idCategory`, `idProduct`, `idProductsize`, `priceDate`, `priceAmount`, `companyCost`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 4, 8, 1, 1, 1, '2020-01-14', '50', '30', '2020-01-14 09:41:40', 1, '2020-01-14 09:41:40', 1, 1),
(2, 4, 8, 1, 1, 2, '2020-01-14', '30', '15', '2020-01-14 09:41:40', 1, '2020-01-14 09:41:40', 1, 1),
(3, 4, 9, 1, 1, 1, '2020-01-14', '45', '30', '2020-01-14 09:42:56', 1, '2020-01-14 09:42:56', 1, 1),
(4, 4, 9, 1, 1, 2, '2020-01-14', '30', '15', '2020-01-14 09:42:56', 1, '2020-01-14 09:42:56', 1, 1),
(5, 4, 10, 1, 1, 1, '2020-01-14', '30', '15', '2020-01-14 09:44:00', 1, '2020-01-14 09:44:00', 1, 1),
(6, 4, 10, 1, 1, 2, '2020-01-14', '20', '10', '2020-01-14 09:44:00', 1, '2020-01-14 09:44:00', 1, 1),
(7, 4, 11, 1, 1, 1, '2020-01-14', '35', '15', '2020-01-14 09:44:51', 1, '2020-01-14 09:44:51', 1, 1),
(8, 4, 11, 1, 1, 2, '2020-01-14', '25', '10', '2020-01-14 09:44:51', 1, '2020-01-14 09:44:51', 1, 1),
(9, 4, 12, 1, 1, 1, '2020-01-14', '50', '30', '2020-01-14 09:45:47', 1, '2020-01-14 09:45:47', 1, 1),
(10, 4, 12, 1, 1, 2, '2020-01-14', '30', '20', '2020-01-14 09:45:47', 1, '2020-01-14 09:45:47', 1, 1),
(11, 4, 13, 1, 1, 1, '2020-01-14', '50', '40', '2020-01-14 09:47:05', 1, '2020-01-14 09:47:05', 1, 1),
(12, 4, 13, 1, 1, 2, '2020-01-14', '30', '20', '2020-01-14 09:47:05', 1, '2020-01-14 09:47:05', 1, 1),
(13, 4, 8, 1, 4, 7, '2020-01-14', '42', '22', '2020-01-14 09:50:44', 1, '2020-01-14 09:50:44', 1, 1),
(14, 4, 9, 1, 4, 7, '2020-01-14', '38', '28', '2020-01-14 09:51:08', 1, '2020-01-14 09:51:08', 1, 1),
(15, 4, 10, 1, 4, 7, '2020-01-14', '40', '30', '2020-01-14 09:51:32', 1, '2020-01-14 09:51:32', 1, 1),
(16, 4, 11, 1, 4, 7, '2020-01-14', '35', '25', '2020-01-14 09:52:07', 1, '2020-01-14 09:52:07', 1, 1),
(17, 4, 12, 1, 4, 7, '2020-01-14', '35', '20', '2020-01-14 09:52:47', 1, '2020-01-14 09:52:47', 1, 1),
(18, 4, 13, 1, 4, 7, '2020-01-14', '35', '20', '2020-01-14 09:53:13', 1, '2020-01-14 09:53:13', 1, 1),
(19, 4, 14, 1, 4, 7, '2020-01-14', '30', '15', '2020-01-14 09:53:51', 1, '2020-01-14 09:53:51', 1, 1),
(20, 4, 8, 1, 2, 3, '2020-01-14', '15', '5', '2020-01-14 09:54:31', 1, '2020-01-14 09:54:31', 1, 1),
(21, 4, 9, 1, 2, 3, '2020-01-14', '20', '10', '2020-01-14 09:54:53', 1, '2020-01-14 09:54:53', 1, 1),
(22, 4, 10, 1, 2, 3, '2020-01-14', '20', '10', '2020-01-14 09:55:12', 1, '2020-01-14 09:55:12', 1, 1),
(23, 4, 11, 1, 2, 3, '2020-01-14', '20', '10', '2020-01-14 09:55:48', 1, '2020-01-14 09:55:48', 1, 1),
(24, 4, 12, 1, 2, 3, '2020-01-14', '20', '10', '2020-01-14 09:56:15', 1, '2020-01-14 09:56:15', 1, 1),
(25, 4, 13, 1, 2, 3, '2020-01-14', '20', '10', '2020-01-14 09:56:41', 1, '2020-01-14 09:56:41', 1, 1),
(26, 4, 14, 1, 2, 3, '2020-01-14', '20', '10', '2020-01-14 09:57:26', 1, '2020-01-14 09:57:26', 1, 1),
(27, 4, 8, 2, 3, 5, '2020-01-14', '30000', '15000', '2020-01-14 09:58:10', 1, '2020-01-14 09:58:10', 1, 1),
(28, 4, 9, 2, 3, 5, '2020-01-14', '30000', '15000', '2020-01-14 09:58:38', 1, '2020-01-14 09:58:38', 1, 1),
(29, 4, 10, 2, 3, 5, '2020-01-14', '35000', '20000', '2020-01-14 09:59:13', 1, '2020-01-14 09:59:13', 1, 1),
(30, 4, 11, 2, 3, 5, '2020-01-14', '40000', '25000', '2020-01-14 09:59:55', 1, '2020-01-14 09:59:55', 1, 1),
(31, 4, 12, 2, 3, 5, '2020-01-14', '30000', '15000', '2020-01-14 10:00:44', 1, '2020-01-14 10:00:44', 1, 1),
(32, 4, 13, 2, 3, 5, '2020-01-14', '42000', '22000', '2020-01-14 10:01:38', 1, '2020-01-14 10:01:38', 1, 1),
(33, 4, 14, 2, 3, 5, '2020-01-14', '45000', '23000', '2020-01-14 10:07:39', 1, '2020-01-14 10:07:39', 1, 1),
(34, 4, 8, 1, 1, 1, '2020-01-14', '50', '30', '2020-01-14 10:20:52', 1, '2020-01-14 10:20:52', 1, 1),
(35, 4, 8, 1, 1, 2, '2020-01-14', '30', '15', '2020-01-14 10:20:52', 1, '2020-01-14 10:20:52', 1, 1),
(36, 4, 8, 1, 1, 1, '2020-01-14', '55', '30', '2020-01-14 10:32:40', 1, '2020-01-14 10:32:40', 1, 1),
(37, 4, 8, 1, 1, 2, '2020-01-14', '35', '20', '2020-01-14 10:32:40', 1, '2020-01-14 10:32:40', 1, 1),
(38, 4, 8, 1, 1, 1, '2020-01-14', '50', '30', '2020-01-14 10:53:45', 1, '2020-01-14 10:53:45', 1, 1),
(39, 4, 8, 1, 1, 2, '2020-01-14', '60', '30', '2020-01-14 10:53:45', 1, '2020-01-14 10:53:45', 1, 1),
(40, 4, 8, 1, 1, 1, '2020-01-15', '60', '30', '2020-01-14 14:52:10', 1, '2020-01-14 14:52:10', 1, 1),
(41, 4, 8, 1, 1, 2, '2020-01-15', '80', '40', '2020-01-14 14:52:10', 1, '2020-01-14 14:52:10', 1, 1),
(42, 4, 14, 1, 1, 1, '2020-01-14', '50', '30', '2020-01-14 17:22:32', 1, '2020-01-14 17:22:32', 1, 1),
(43, 4, 14, 1, 1, 2, '2020-01-14', '60', '30', '2020-01-14 17:22:32', 1, '2020-01-14 17:22:32', 1, 1),
(44, 4, 8, 1, 1, 1, '2020-01-20', '80', '40', '2020-01-20 11:32:10', 39, '2020-01-20 11:32:10', 39, 2),
(45, 4, 8, 1, 1, 2, '2020-01-20', '100', '50', '2020-01-20 11:32:10', 39, '2020-01-20 11:32:10', 39, 2);

-- --------------------------------------------------------

--
-- Table structure for table `primary_packaging`
--

CREATE TABLE `primary_packaging` (
  `idPrimaryPackaging` int(11) NOT NULL,
  `primarypackname` varchar(50) NOT NULL,
  `idSubPackaging` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `primary_packaging`
--

INSERT INTO `primary_packaging` (`idPrimaryPackaging`, `primarypackname`, `idSubPackaging`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Cases', 1, 1, '2019-12-04 10:24:42', 1, NULL, 0),
(2, 'Units', 2, 1, '2019-12-04 10:24:52', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_content`
--

CREATE TABLE `product_content` (
  `idProductContent` int(11) NOT NULL,
  `productContent` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active,2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'Userid',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0' COMMENT 'UserId'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_content`
--

INSERT INTO `product_content` (`idProductContent`, `productContent`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Perishables', 1, '2019-12-04 10:25:47', 1, NULL, 0),
(2, 'Consumable', 1, '2019-12-04 10:26:01', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `idProduct` int(11) NOT NULL,
  `productCode` varchar(15) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `idHsncode` int(11) NOT NULL,
  `productSubName` varchar(50) DEFAULT NULL,
  `idCategory` int(11) NOT NULL,
  `idSubCategory` int(11) NOT NULL,
  `productVariant1` varchar(30) DEFAULT NULL,
  `productVariant2` varchar(30) DEFAULT NULL,
  `productBrand` varchar(50) NOT NULL,
  `expireDate` int(11) NOT NULL DEFAULT '0' COMMENT '1=Yes, 2=No',
  `productShelflife` int(1) NOT NULL COMMENT '1=days;2=months;3=years',
  `productShelf` varchar(10) NOT NULL DEFAULT '0',
  `productReturn` int(1) NOT NULL COMMENT '1=Yes;2=No',
  `productReturnDays` int(3) DEFAULT '0',
  `productReturnOption` int(1) NOT NULL COMMENT '1=Alert;2=Stop',
  `dispatchControl` int(11) NOT NULL,
  `productserialNo` int(1) NOT NULL COMMENT '1=Required, 2=Not required',
  `productserialnoNumeric` int(1) NOT NULL COMMENT '1=Numeric, 2=Alphanumeric',
  `productserialnoAuto` int(1) NOT NULL COMMENT '1=Automatic, 2=Manual',
  `idProductContent` int(11) NOT NULL,
  `idProductStatus` int(11) NOT NULL,
  `idPrimaryPackaging` int(11) NOT NULL DEFAULT '0',
  `idSecondaryPackaging` int(11) NOT NULL DEFAULT '0',
  `productUnit` int(1) NOT NULL COMMENT '1=Units;2=Weight;3=Area',
  `productCount` int(2) NOT NULL COMMENT '1=Units;2=Kg;3=gm;4=mgm;5=mts;6=cmts;7=inches;8=foot;9=litre;10=ml ',
  `productSize` int(5) NOT NULL DEFAULT '0',
  `productPrimaryCount` int(5) NOT NULL DEFAULT '0' COMMENT 'no of units in package',
  `productSecondaryCount` int(5) NOT NULL DEFAULT '0' COMMENT 'no of units in package',
  `productImageLeft` text,
  `productImageRight` text,
  `productImageTop` text,
  `productImageBottom` text,
  `productImageLeftSide` text,
  `productImageRightSide` text,
  `idTerritoryTitle` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'userId',
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL COMMENT 'userId'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`idProduct`, `productCode`, `productName`, `idHsncode`, `productSubName`, `idCategory`, `idSubCategory`, `productVariant1`, `productVariant2`, `productBrand`, `expireDate`, `productShelflife`, `productShelf`, `productReturn`, `productReturnDays`, `productReturnOption`, `dispatchControl`, `productserialNo`, `productserialnoNumeric`, `productserialnoAuto`, `idProductContent`, `idProductStatus`, `idPrimaryPackaging`, `idSecondaryPackaging`, `productUnit`, `productCount`, `productSize`, `productPrimaryCount`, `productSecondaryCount`, `productImageLeft`, `productImageRight`, `productImageTop`, `productImageBottom`, `productImageLeftSide`, `productImageRightSide`, `idTerritoryTitle`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'PRD101', 'Hamam', 1, NULL, 1, 1, NULL, NULL, 'Hamam', 1, 1, '75', 1, 100, 1, 15, 1, 2, 1, 1, 1, 0, 0, 2, 3, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '2019-12-04 10:29:17', 1, '2020-01-21 10:25:37', 1),
(2, 'PRD102', 'Lux Fairness creams and soaps ', 1, NULL, 1, 1, NULL, NULL, 'Lux', 1, 1, '12', 1, 5, 1, 20, 2, 2, 2, 1, 1, 0, 0, 2, 3, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '2019-12-04 10:32:03', 1, '2020-01-10 15:37:22', 1),
(3, 'PRD103', 'Sony TV', 3, NULL, 2, 2, NULL, NULL, 'Sony', 2, 0, '0', 1, 30, 1, 20, 1, 1, 1, 2, 1, 0, 0, 1, 7, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '2019-12-05 11:10:17', 1, '2019-12-05 11:10:17', 1),
(4, 'PRD105', 'Cinthol', 1, NULL, 1, 1, NULL, NULL, 'Cinthol', 1, 2, '5', 1, 5, 2, 30, 1, 1, 1, 1, 1, 0, 0, 2, 3, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '2019-12-16 11:03:00', 34, '2020-01-20 10:56:36', 39);

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `idProductsize` int(11) NOT NULL,
  `productSize` int(5) NOT NULL,
  `idPrimaryPackaging` int(11) NOT NULL,
  `idSecondaryPackaging` int(11) NOT NULL,
  `productPrimaryCount` int(11) NOT NULL DEFAULT '0',
  `productSecondaryCount` int(5) NOT NULL COMMENT 'no of units in package',
  `idProduct` int(11) NOT NULL,
  `productImageLeft` text NOT NULL,
  `productImageRight` text NOT NULL,
  `productImageTop` text NOT NULL,
  `productImageBottom` text NOT NULL,
  `productImageLeftSide` text NOT NULL,
  `productImageRightSide` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'userId',
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL COMMENT 'userId',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`idProductsize`, `productSize`, `idPrimaryPackaging`, `idSecondaryPackaging`, `productPrimaryCount`, `productSecondaryCount`, `idProduct`, `productImageLeft`, `productImageRight`, `productImageTop`, `productImageBottom`, `productImageLeftSide`, `productImageRightSide`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 50, 1, 1, 5, 100, 1, '', '', '', '', '', '', '2019-12-04 10:29:17', 1, '2020-01-21 10:25:37', 1, 1),
(2, 100, 2, 1, 5, 100, 1, '', '', '', '', '', '', '2019-12-04 10:29:17', 1, '2020-01-21 10:25:37', 1, 1),
(3, 50, 1, 1, 5, 100, 2, 'leftimage_0_1001201537.png', 'rightimage_0_1001201537.png', 'topimage_0_1001201537.png', 'bottomimage_0_1001201537.png', 'sideleftimage_0_1001201537.png', 'siderightimage_0_1001201537.png', '2019-12-04 10:32:03', 1, '2020-01-10 15:37:23', 1, 1),
(4, 100, 2, 1, 5, 100, 2, '', '', '', '', '', '', '2019-12-04 10:32:03', 1, '2019-12-07 17:23:27', 1, 2),
(5, 65, 2, 1, 1, 100, 3, '', '', '', '', '', '', '2019-12-05 11:10:17', 1, '2019-12-05 11:10:17', 1, 1),
(6, 150, 1, 1, 2, 100, 1, '', '', '', '', '', '', '2019-12-07 17:26:53', 1, '2019-12-07 17:27:29', 1, 2),
(7, 50, 1, 1, 5, 100, 4, '', '', '', '', '', '', '2019-12-16 11:03:00', 34, '2020-01-20 10:56:36', 39, 1),
(8, 100, 1, 1, 5, 100, 4, '', '', '', '', '', '', '2019-12-16 11:03:00', 34, '2020-01-13 16:16:45', 1, 2),
(9, 100, 1, 0, 5, 0, 4, '', '', '', '', '', '', '2020-01-20 10:55:02', 39, '2020-01-20 10:56:35', 39, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_status`
--

CREATE TABLE `product_status` (
  `idProductStatus` int(11) NOT NULL,
  `productStatus` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'userId',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0' COMMENT 'userId'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_status`
--

INSERT INTO `product_status` (`idProductStatus`, `productStatus`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Star', 1, '2019-12-04 10:25:57', 1, NULL, 0),
(2, 'Standard', 1, '2019-12-04 10:26:03', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_serialno`
--

CREATE TABLE `product_stock_serialno` (
  `idProductserialno` int(11) NOT NULL,
  `idWhStock` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL DEFAULT '0',
  `idLevel` int(11) NOT NULL DEFAULT '0',
  `idProduct` int(11) NOT NULL,
  `idProductsize` int(11) NOT NULL,
  `serialno` text NOT NULL,
  `idWhStockItem` int(11) DEFAULT '0',
  `idOrderallocateditems` int(11) NOT NULL DEFAULT '0',
  `idOrder` int(11) NOT NULL DEFAULT '0',
  `offer_flog` int(11) NOT NULL DEFAULT '0' COMMENT '1=Order, 2=Free',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '2' COMMENT '1=Allocated, 2=Not allocated,3=return,4=damage,5=warehouseDamage,6=returncustomer,7=replace,8=missing'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_stock_serialno`
--

INSERT INTO `product_stock_serialno` (`idProductserialno`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProductsize`, `serialno`, `idWhStockItem`, `idOrderallocateditems`, `idOrder`, `offer_flog`, `created_by`, `created_at`, `status`) VALUES
(1, 1, 0, 0, 1, 1, 'SNO20201412424311', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 4),
(2, 1, 0, 0, 1, 1, 'SNO20201412424312', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 4),
(3, 1, 0, 0, 1, 1, 'SNO20201412424313', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 3),
(4, 1, 0, 0, 1, 1, 'SNO20201412424314', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 3),
(5, 1, 0, 0, 1, 1, 'SNO20201412424315', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 3),
(6, 1, 0, 0, 1, 1, 'SNO20201412424316', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 3),
(7, 1, 0, 0, 1, 1, 'SNO20201412424317', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 3),
(8, 1, 0, 0, 1, 1, 'SNO20201412424318', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 7),
(9, 1, 0, 0, 1, 1, 'SNO20201412424319', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 7),
(10, 1, 0, 0, 1, 1, 'SNO202014124243110', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 7),
(11, 1, 0, 0, 1, 1, 'SNO202014124243111', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 7),
(12, 1, 0, 0, 1, 1, 'SNO202014124243112', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 7),
(13, 1, 0, 0, 1, 1, 'SNO202014124243113', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 8),
(14, 1, 0, 0, 1, 1, 'SNO202014124243114', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 8),
(15, 1, 0, 0, 1, 1, 'SNO202014124243115', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 8),
(16, 1, 0, 0, 1, 1, 'SNO202014124243116', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 8),
(17, 1, 0, 0, 1, 1, 'SNO202014124243117', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 8),
(18, 1, 0, 0, 1, 1, 'SNO202014124243118', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 1),
(19, 1, 0, 0, 1, 1, 'SNO202014124243119', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 1),
(20, 1, 0, 0, 1, 1, 'SNO202014124243120', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 1),
(21, 1, 0, 0, 1, 1, 'SNO202014124243121', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 1),
(22, 1, 0, 0, 1, 1, 'SNO202014124243122', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 1),
(23, 1, 0, 0, 1, 1, 'SNO202014124243123', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 1),
(24, 1, 0, 0, 1, 1, 'SNO202014124243124', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 1),
(25, 1, 0, 0, 1, 1, 'SNO202014124243125', 1, 1, 1, 0, 1, '2020-01-04 12:42:47', 1),
(26, 1, 0, 0, 1, 1, 'SNO202014124243126', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(27, 1, 0, 0, 1, 1, 'SNO202014124243127', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(28, 1, 0, 0, 1, 1, 'SNO202014124243128', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(29, 1, 0, 0, 1, 1, 'SNO202014124243129', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(30, 1, 0, 0, 1, 1, 'SNO202014124243130', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(31, 1, 0, 0, 1, 1, 'SNO202014124243131', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(32, 1, 0, 0, 1, 1, 'SNO202014124243132', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(33, 1, 0, 0, 1, 1, 'SNO202014124243133', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(34, 1, 0, 0, 1, 1, 'SNO202014124243134', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(35, 1, 0, 0, 1, 1, 'SNO202014124243135', 1, 3, 2, 0, 1, '2020-01-04 12:42:47', 1),
(36, 1, 0, 0, 1, 1, 'SNO202014124243136', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(37, 1, 0, 0, 1, 1, 'SNO202014124243137', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(38, 1, 0, 0, 1, 1, 'SNO202014124243138', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(39, 1, 0, 0, 1, 1, 'SNO202014124243139', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(40, 1, 0, 0, 1, 1, 'SNO202014124243140', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(41, 1, 0, 0, 1, 1, 'SNO202014124243141', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(42, 1, 0, 0, 1, 1, 'SNO202014124243142', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(43, 1, 0, 0, 1, 1, 'SNO202014124243143', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(44, 1, 0, 0, 1, 1, 'SNO202014124243144', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(45, 1, 0, 0, 1, 1, 'SNO202014124243145', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(46, 1, 0, 0, 1, 1, 'SNO202014124243146', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(47, 1, 0, 0, 1, 1, 'SNO202014124243147', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(48, 1, 0, 0, 1, 1, 'SNO202014124243148', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(49, 1, 0, 0, 1, 1, 'SNO202014124243149', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(50, 1, 0, 0, 1, 1, 'SNO202014124243150', 1, 0, 0, 0, 1, '2020-01-04 12:42:47', 2),
(51, 1, 0, 0, 1, 2, 'SNO20201412425921', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 4),
(52, 1, 0, 0, 1, 2, 'SNO20201412425922', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 4),
(53, 1, 0, 0, 1, 2, 'SNO20201412425923', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 7),
(54, 1, 0, 0, 1, 2, 'SNO20201412425924', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 7),
(55, 1, 0, 0, 1, 2, 'SNO20201412425925', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 7),
(56, 1, 0, 0, 1, 2, 'SNO20201412425926', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 7),
(57, 1, 0, 0, 1, 2, 'SNO20201412425927', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 7),
(58, 1, 0, 0, 1, 2, 'SNO20201412425928', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(59, 1, 0, 0, 1, 2, 'SNO20201412425929', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(60, 1, 0, 0, 1, 2, 'SNO202014124259210', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(61, 1, 0, 0, 1, 2, 'SNO202014124259211', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(62, 1, 0, 0, 1, 2, 'SNO202014124259212', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(63, 1, 0, 0, 1, 2, 'SNO202014124259213', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(64, 1, 0, 0, 1, 2, 'SNO202014124259214', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(65, 1, 0, 0, 1, 2, 'SNO202014124259215', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(66, 1, 0, 0, 1, 2, 'SNO202014124259216', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(67, 1, 0, 0, 1, 2, 'SNO202014124259217', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(68, 1, 0, 0, 1, 2, 'SNO202014124259218', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(69, 1, 0, 0, 1, 2, 'SNO202014124259219', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(70, 1, 0, 0, 1, 2, 'SNO202014124259220', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(71, 1, 0, 0, 1, 2, 'SNO202014124259221', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(72, 1, 0, 0, 1, 2, 'SNO202014124259222', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(73, 1, 0, 0, 1, 2, 'SNO202014124259223', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(74, 1, 0, 0, 1, 2, 'SNO202014124259224', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(75, 1, 0, 0, 1, 2, 'SNO202014124259225', 5, 2, 1, 0, 1, '2020-01-04 12:43:01', 1),
(76, 1, 0, 0, 1, 2, 'SNO202014124259226', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(77, 1, 0, 0, 1, 2, 'SNO202014124259227', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(78, 1, 0, 0, 1, 2, 'SNO202014124259228', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(79, 1, 0, 0, 1, 2, 'SNO202014124259229', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(80, 1, 0, 0, 1, 2, 'SNO202014124259230', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(81, 1, 0, 0, 1, 2, 'SNO202014124259231', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(82, 1, 0, 0, 1, 2, 'SNO202014124259232', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(83, 1, 0, 0, 1, 2, 'SNO202014124259233', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(84, 1, 0, 0, 1, 2, 'SNO202014124259234', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(85, 1, 0, 0, 1, 2, 'SNO202014124259235', 5, 4, 2, 0, 1, '2020-01-04 12:43:01', 1),
(86, 1, 0, 0, 1, 2, 'SNO202014124259236', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(87, 1, 0, 0, 1, 2, 'SNO202014124259237', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(88, 1, 0, 0, 1, 2, 'SNO202014124259238', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(89, 1, 0, 0, 1, 2, 'SNO202014124259239', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(90, 1, 0, 0, 1, 2, 'SNO202014124259240', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(91, 1, 0, 0, 1, 2, 'SNO202014124259241', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(92, 1, 0, 0, 1, 2, 'SNO202014124259242', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(93, 1, 0, 0, 1, 2, 'SNO202014124259243', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(94, 1, 0, 0, 1, 2, 'SNO202014124259244', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(95, 1, 0, 0, 1, 2, 'SNO202014124259245', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(96, 1, 0, 0, 1, 2, 'SNO202014124259246', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(97, 1, 0, 0, 1, 2, 'SNO202014124259247', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(98, 1, 0, 0, 1, 2, 'SNO202014124259248', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(99, 1, 0, 0, 1, 2, 'SNO202014124259249', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(100, 1, 0, 0, 1, 2, 'SNO202014124259250', 5, 0, 0, 0, 1, '2020-01-04 12:43:01', 2),
(101, 1, 0, 0, 4, 7, '20201412431271', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(102, 1, 0, 0, 4, 7, '20201412431272', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(103, 1, 0, 0, 4, 7, '20201412431273', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(104, 1, 0, 0, 4, 7, '20201412431274', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(105, 1, 0, 0, 4, 7, '20201412431275', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(106, 1, 0, 0, 4, 7, '20201412431276', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(107, 1, 0, 0, 4, 7, '20201412431277', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(108, 1, 0, 0, 4, 7, '20201412431278', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(109, 1, 0, 0, 4, 7, '20201412431279', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(110, 1, 0, 0, 4, 7, '202014124312710', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(111, 1, 0, 0, 4, 7, '202014124312711', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(112, 1, 0, 0, 4, 7, '202014124312712', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(113, 1, 0, 0, 4, 7, '202014124312713', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(114, 1, 0, 0, 4, 7, '202014124312714', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(115, 1, 0, 0, 4, 7, '202014124312715', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(116, 1, 0, 0, 4, 7, '202014124312716', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(117, 1, 0, 0, 4, 7, '202014124312717', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(118, 1, 0, 0, 4, 7, '202014124312718', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(119, 1, 0, 0, 4, 7, '202014124312719', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(120, 1, 0, 0, 4, 7, '202014124312720', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(121, 1, 0, 0, 4, 7, '202014124312721', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(122, 1, 0, 0, 4, 7, '202014124312722', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(123, 1, 0, 0, 4, 7, '202014124312723', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(124, 1, 0, 0, 4, 7, '202014124312724', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(125, 1, 0, 0, 4, 7, '202014124312725', 3, 6, 3, 0, 1, '2020-01-04 12:43:14', 1),
(126, 1, 0, 0, 4, 7, '202014124312726', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(127, 1, 0, 0, 4, 7, '202014124312727', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(128, 1, 0, 0, 4, 7, '202014124312728', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(129, 1, 0, 0, 4, 7, '202014124312729', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(130, 1, 0, 0, 4, 7, '202014124312730', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(131, 1, 0, 0, 4, 7, '202014124312731', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(132, 1, 0, 0, 4, 7, '202014124312732', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(133, 1, 0, 0, 4, 7, '202014124312733', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(134, 1, 0, 0, 4, 7, '202014124312734', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(135, 1, 0, 0, 4, 7, '202014124312735', 3, 9, 4, 0, 1, '2020-01-04 12:43:14', 1),
(136, 1, 0, 0, 4, 7, '202014124312736', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(137, 1, 0, 0, 4, 7, '202014124312737', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(138, 1, 0, 0, 4, 7, '202014124312738', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(139, 1, 0, 0, 4, 7, '202014124312739', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(140, 1, 0, 0, 4, 7, '202014124312740', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(141, 1, 0, 0, 4, 7, '202014124312741', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(142, 1, 0, 0, 4, 7, '202014124312742', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(143, 1, 0, 0, 4, 7, '202014124312743', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(144, 1, 0, 0, 4, 7, '202014124312744', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(145, 1, 0, 0, 4, 7, '202014124312745', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(146, 1, 0, 0, 4, 7, '202014124312746', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(147, 1, 0, 0, 4, 7, '202014124312747', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(148, 1, 0, 0, 4, 7, '202014124312748', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(149, 1, 0, 0, 4, 7, '202014124312749', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(150, 1, 0, 0, 4, 7, '202014124312750', 3, 0, 0, 0, 1, '2020-01-04 12:43:14', 2),
(151, 1, 0, 0, 4, 8, '20201412432381', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(152, 1, 0, 0, 4, 8, '20201412432382', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(153, 1, 0, 0, 4, 8, '20201412432383', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(154, 1, 0, 0, 4, 8, '20201412432384', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(155, 1, 0, 0, 4, 8, '20201412432385', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(156, 1, 0, 0, 4, 8, '20201412432386', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(157, 1, 0, 0, 4, 8, '20201412432387', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(158, 1, 0, 0, 4, 8, '20201412432388', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(159, 1, 0, 0, 4, 8, '20201412432389', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(160, 1, 0, 0, 4, 8, '202014124323810', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(161, 1, 0, 0, 4, 8, '202014124323811', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(162, 1, 0, 0, 4, 8, '202014124323812', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(163, 1, 0, 0, 4, 8, '202014124323813', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(164, 1, 0, 0, 4, 8, '202014124323814', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(165, 1, 0, 0, 4, 8, '202014124323815', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(166, 1, 0, 0, 4, 8, '202014124323816', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(167, 1, 0, 0, 4, 8, '202014124323817', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(168, 1, 0, 0, 4, 8, '202014124323818', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(169, 1, 0, 0, 4, 8, '202014124323819', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(170, 1, 0, 0, 4, 8, '202014124323820', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(171, 1, 0, 0, 4, 8, '202014124323821', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(172, 1, 0, 0, 4, 8, '202014124323822', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(173, 1, 0, 0, 4, 8, '202014124323823', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(174, 1, 0, 0, 4, 8, '202014124323824', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(175, 1, 0, 0, 4, 8, '202014124323825', 4, 7, 3, 0, 1, '2020-01-04 12:43:28', 1),
(176, 1, 0, 0, 4, 8, '202014124323826', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(177, 1, 0, 0, 4, 8, '202014124323827', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(178, 1, 0, 0, 4, 8, '202014124323828', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(179, 1, 0, 0, 4, 8, '202014124323829', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(180, 1, 0, 0, 4, 8, '202014124323830', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(181, 1, 0, 0, 4, 8, '202014124323831', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(182, 1, 0, 0, 4, 8, '202014124323832', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(183, 1, 0, 0, 4, 8, '202014124323833', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(184, 1, 0, 0, 4, 8, '202014124323834', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(185, 1, 0, 0, 4, 8, '202014124323835', 4, 10, 4, 0, 1, '2020-01-04 12:43:28', 1),
(186, 1, 0, 0, 4, 8, '202014124323836', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(187, 1, 0, 0, 4, 8, '202014124323837', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(188, 1, 0, 0, 4, 8, '202014124323838', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(189, 1, 0, 0, 4, 8, '202014124323839', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(190, 1, 0, 0, 4, 8, '202014124323840', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(191, 1, 0, 0, 4, 8, '202014124323841', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(192, 1, 0, 0, 4, 8, '202014124323842', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(193, 1, 0, 0, 4, 8, '202014124323843', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(194, 1, 0, 0, 4, 8, '202014124323844', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(195, 1, 0, 0, 4, 8, '202014124323845', 4, 17, 17, 0, 1, '2020-01-04 12:43:28', 1),
(196, 1, 0, 0, 4, 8, '202014124323846', 4, 0, 0, 0, 1, '2020-01-04 12:43:28', 2),
(197, 1, 0, 0, 4, 8, '202014124323847', 4, 0, 0, 0, 1, '2020-01-04 12:43:28', 2),
(198, 1, 0, 0, 4, 8, '202014124323848', 4, 0, 0, 0, 1, '2020-01-04 12:43:28', 2),
(199, 1, 0, 0, 4, 8, '202014124323849', 4, 0, 0, 0, 1, '2020-01-04 12:43:28', 2),
(200, 1, 0, 0, 4, 8, '202014124323850', 4, 0, 0, 0, 1, '2020-01-04 12:43:28', 2),
(201, 1, 0, 0, 3, 5, '20201412434351', 6, 5, 3, 0, 1, '2020-01-04 12:43:44', 1),
(202, 1, 0, 0, 3, 5, '20201412434352', 6, 5, 3, 0, 1, '2020-01-04 12:43:44', 1),
(203, 1, 0, 0, 3, 5, '20201412434353', 6, 5, 3, 0, 1, '2020-01-04 12:43:44', 1),
(204, 1, 0, 0, 3, 5, '20201412434354', 6, 5, 3, 0, 1, '2020-01-04 12:43:44', 1),
(205, 1, 0, 0, 3, 5, '20201412434355', 6, 5, 3, 0, 1, '2020-01-04 12:43:44', 1),
(206, 1, 0, 0, 3, 5, '20201412434356', 6, 8, 4, 0, 1, '2020-01-04 12:43:44', 1),
(207, 1, 0, 0, 3, 5, '20201412434357', 6, 8, 4, 0, 1, '2020-01-04 12:43:44', 1),
(208, 1, 0, 0, 3, 5, '20201412434358', 6, 0, 0, 0, 1, '2020-01-04 12:43:44', 2),
(209, 1, 0, 0, 3, 5, '20201412434359', 6, 0, 0, 0, 1, '2020-01-04 12:43:44', 2),
(210, 1, 0, 0, 3, 5, '202014124343510', 6, 0, 0, 0, 1, '2020-01-04 12:43:44', 2),
(211, 2, 0, 0, 1, 1, 'SNO202014141111', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 5),
(212, 2, 0, 0, 1, 1, 'SNO202014141112', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 5),
(213, 2, 0, 0, 1, 1, 'SNO202014141113', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(214, 2, 0, 0, 1, 1, 'SNO202014141114', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(215, 2, 0, 0, 1, 1, 'SNO202014141115', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(216, 2, 0, 0, 1, 1, 'SNO202014141116', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(217, 2, 0, 0, 1, 1, 'SNO202014141117', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(218, 2, 0, 0, 1, 1, 'SNO202014141118', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(219, 2, 0, 0, 1, 1, 'SNO202014141119', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(220, 2, 0, 0, 1, 1, 'SNO2020141411110', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(221, 2, 0, 0, 1, 1, 'SNO2020141411111', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(222, 2, 0, 0, 1, 1, 'SNO2020141411112', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(223, 2, 0, 0, 1, 1, 'SNO2020141411113', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(224, 2, 0, 0, 1, 1, 'SNO2020141411114', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(225, 2, 0, 0, 1, 1, 'SNO2020141411115', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(226, 2, 0, 0, 1, 1, 'SNO2020141411116', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(227, 2, 0, 0, 1, 1, 'SNO2020141411117', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(228, 2, 0, 0, 1, 1, 'SNO2020141411118', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(229, 2, 0, 0, 1, 1, 'SNO2020141411119', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(230, 2, 0, 0, 1, 1, 'SNO2020141411120', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(231, 2, 0, 0, 1, 1, 'SNO2020141411121', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(232, 2, 0, 0, 1, 1, 'SNO2020141411122', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(233, 2, 0, 0, 1, 1, 'SNO2020141411123', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(234, 2, 0, 0, 1, 1, 'SNO2020141411124', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(235, 2, 0, 0, 1, 1, 'SNO2020141411125', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(236, 2, 0, 0, 1, 1, 'SNO2020141411126', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(237, 2, 0, 0, 1, 1, 'SNO2020141411127', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(238, 2, 0, 0, 1, 1, 'SNO2020141411128', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(239, 2, 0, 0, 1, 1, 'SNO2020141411129', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(240, 2, 0, 0, 1, 1, 'SNO2020141411130', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(241, 2, 0, 0, 1, 1, 'SNO2020141411131', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(242, 2, 0, 0, 1, 1, 'SNO2020141411132', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(243, 2, 0, 0, 1, 1, 'SNO2020141411133', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(244, 2, 0, 0, 1, 1, 'SNO2020141411134', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(245, 2, 0, 0, 1, 1, 'SNO2020141411135', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(246, 2, 0, 0, 1, 1, 'SNO2020141411136', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(247, 2, 0, 0, 1, 1, 'SNO2020141411137', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(248, 2, 0, 0, 1, 1, 'SNO2020141411138', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(249, 2, 0, 0, 1, 1, 'SNO2020141411139', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(250, 2, 0, 0, 1, 1, 'SNO2020141411140', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(251, 2, 0, 0, 1, 1, 'SNO2020141411141', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(252, 2, 0, 0, 1, 1, 'SNO2020141411142', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(253, 2, 0, 0, 1, 1, 'SNO2020141411143', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(254, 2, 0, 0, 1, 1, 'SNO2020141411144', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(255, 2, 0, 0, 1, 1, 'SNO2020141411145', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(256, 2, 0, 0, 1, 1, 'SNO2020141411146', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(257, 2, 0, 0, 1, 1, 'SNO2020141411147', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(258, 2, 0, 0, 1, 1, 'SNO2020141411148', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(259, 2, 0, 0, 1, 1, 'SNO2020141411149', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(260, 2, 0, 0, 1, 1, 'SNO2020141411150', 7, 0, 0, 0, 1, '2020-01-04 13:41:04', 2),
(261, 2, 0, 0, 1, 2, 'SNO2020141411921', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(262, 2, 0, 0, 1, 2, 'SNO2020141411922', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(263, 2, 0, 0, 1, 2, 'SNO2020141411923', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(264, 2, 0, 0, 1, 2, 'SNO2020141411924', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(265, 2, 0, 0, 1, 2, 'SNO2020141411925', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(266, 2, 0, 0, 1, 2, 'SNO2020141411926', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(267, 2, 0, 0, 1, 2, 'SNO2020141411927', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(268, 2, 0, 0, 1, 2, 'SNO2020141411928', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(269, 2, 0, 0, 1, 2, 'SNO2020141411929', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(270, 2, 0, 0, 1, 2, 'SNO20201414119210', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(271, 2, 0, 0, 1, 2, 'SNO20201414119211', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(272, 2, 0, 0, 1, 2, 'SNO20201414119212', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(273, 2, 0, 0, 1, 2, 'SNO20201414119213', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(274, 2, 0, 0, 1, 2, 'SNO20201414119214', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(275, 2, 0, 0, 1, 2, 'SNO20201414119215', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(276, 2, 0, 0, 1, 2, 'SNO20201414119216', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(277, 2, 0, 0, 1, 2, 'SNO20201414119217', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(278, 2, 0, 0, 1, 2, 'SNO20201414119218', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(279, 2, 0, 0, 1, 2, 'SNO20201414119219', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(280, 2, 0, 0, 1, 2, 'SNO20201414119220', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(281, 2, 0, 0, 1, 2, 'SNO20201414119221', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(282, 2, 0, 0, 1, 2, 'SNO20201414119222', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(283, 2, 0, 0, 1, 2, 'SNO20201414119223', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(284, 2, 0, 0, 1, 2, 'SNO20201414119224', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(285, 2, 0, 0, 1, 2, 'SNO20201414119225', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(286, 2, 0, 0, 1, 2, 'SNO20201414119226', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(287, 2, 0, 0, 1, 2, 'SNO20201414119227', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(288, 2, 0, 0, 1, 2, 'SNO20201414119228', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(289, 2, 0, 0, 1, 2, 'SNO20201414119229', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(290, 2, 0, 0, 1, 2, 'SNO20201414119230', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(291, 2, 0, 0, 1, 2, 'SNO20201414119231', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(292, 2, 0, 0, 1, 2, 'SNO20201414119232', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(293, 2, 0, 0, 1, 2, 'SNO20201414119233', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(294, 2, 0, 0, 1, 2, 'SNO20201414119234', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(295, 2, 0, 0, 1, 2, 'SNO20201414119235', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(296, 2, 0, 0, 1, 2, 'SNO20201414119236', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(297, 2, 0, 0, 1, 2, 'SNO20201414119237', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(298, 2, 0, 0, 1, 2, 'SNO20201414119238', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(299, 2, 0, 0, 1, 2, 'SNO20201414119239', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(300, 2, 0, 0, 1, 2, 'SNO20201414119240', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(301, 2, 0, 0, 1, 2, 'SNO20201414119241', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(302, 2, 0, 0, 1, 2, 'SNO20201414119242', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(303, 2, 0, 0, 1, 2, 'SNO20201414119243', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(304, 2, 0, 0, 1, 2, 'SNO20201414119244', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(305, 2, 0, 0, 1, 2, 'SNO20201414119245', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(306, 2, 0, 0, 1, 2, 'SNO20201414119246', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(307, 2, 0, 0, 1, 2, 'SNO20201414119247', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(308, 2, 0, 0, 1, 2, 'SNO20201414119248', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(309, 2, 0, 0, 1, 2, 'SNO20201414119249', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(310, 2, 0, 0, 1, 2, 'SNO20201414119250', 11, 0, 0, 0, 1, '2020-01-04 13:41:21', 2),
(311, 2, 0, 0, 4, 7, '2020141413571', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(312, 2, 0, 0, 4, 7, '2020141413572', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(313, 2, 0, 0, 4, 7, '2020141413573', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(314, 2, 0, 0, 4, 7, '2020141413574', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(315, 2, 0, 0, 4, 7, '2020141413575', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(316, 2, 0, 0, 4, 7, '2020141413576', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(317, 2, 0, 0, 4, 7, '2020141413577', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(318, 2, 0, 0, 4, 7, '2020141413578', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(319, 2, 0, 0, 4, 7, '2020141413579', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(320, 2, 0, 0, 4, 7, '20201414135710', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(321, 2, 0, 0, 4, 7, '20201414135711', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(322, 2, 0, 0, 4, 7, '20201414135712', 9, 0, 0, 0, 1, '2020-01-04 13:41:37', 2),
(323, 2, 0, 0, 4, 7, '20201414135713', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(324, 2, 0, 0, 4, 7, '20201414135714', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(325, 2, 0, 0, 4, 7, '20201414135715', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(326, 2, 0, 0, 4, 7, '20201414135716', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(327, 2, 0, 0, 4, 7, '20201414135717', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(328, 2, 0, 0, 4, 7, '20201414135718', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(329, 2, 0, 0, 4, 7, '20201414135719', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(330, 2, 0, 0, 4, 7, '20201414135720', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(331, 2, 0, 0, 4, 7, '20201414135721', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(332, 2, 0, 0, 4, 7, '20201414135722', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(333, 2, 0, 0, 4, 7, '20201414135723', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(334, 2, 0, 0, 4, 7, '20201414135724', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(335, 2, 0, 0, 4, 7, '20201414135725', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(336, 2, 0, 0, 4, 7, '20201414135726', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(337, 2, 0, 0, 4, 7, '20201414135727', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(338, 2, 0, 0, 4, 7, '20201414135728', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(339, 2, 0, 0, 4, 7, '20201414135729', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(340, 2, 0, 0, 4, 7, '20201414135730', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(341, 2, 0, 0, 4, 7, '20201414135731', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(342, 2, 0, 0, 4, 7, '20201414135732', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(343, 2, 0, 0, 4, 7, '20201414135733', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(344, 2, 0, 0, 4, 7, '20201414135734', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(345, 2, 0, 0, 4, 7, '20201414135735', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(346, 2, 0, 0, 4, 7, '20201414135736', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(347, 2, 0, 0, 4, 7, '20201414135737', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(348, 2, 0, 0, 4, 7, '20201414135738', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(349, 2, 0, 0, 4, 7, '20201414135739', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(350, 2, 0, 0, 4, 7, '20201414135740', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(351, 2, 0, 0, 4, 7, '20201414135741', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(352, 2, 0, 0, 4, 7, '20201414135742', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(353, 2, 0, 0, 4, 7, '20201414135743', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(354, 2, 0, 0, 4, 7, '20201414135744', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(355, 2, 0, 0, 4, 7, '20201414135745', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(356, 2, 0, 0, 4, 7, '20201414135746', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(357, 2, 0, 0, 4, 7, '20201414135747', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(358, 2, 0, 0, 4, 7, '20201414135748', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(359, 2, 0, 0, 4, 7, '20201414135749', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(360, 2, 0, 0, 4, 7, '20201414135750', 9, 0, 0, 0, 1, '2020-01-04 13:41:38', 2),
(361, 2, 0, 0, 4, 8, '2020141414781', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(362, 2, 0, 0, 4, 8, '2020141414782', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(363, 2, 0, 0, 4, 8, '2020141414783', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(364, 2, 0, 0, 4, 8, '2020141414784', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(365, 2, 0, 0, 4, 8, '2020141414785', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(366, 2, 0, 0, 4, 8, '2020141414786', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(367, 2, 0, 0, 4, 8, '2020141414787', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(368, 2, 0, 0, 4, 8, '2020141414788', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(369, 2, 0, 0, 4, 8, '2020141414789', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(370, 2, 0, 0, 4, 8, '20201414147810', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(371, 2, 0, 0, 4, 8, '20201414147811', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(372, 2, 0, 0, 4, 8, '20201414147812', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(373, 2, 0, 0, 4, 8, '20201414147813', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(374, 2, 0, 0, 4, 8, '20201414147814', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(375, 2, 0, 0, 4, 8, '20201414147815', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(376, 2, 0, 0, 4, 8, '20201414147816', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(377, 2, 0, 0, 4, 8, '20201414147817', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(378, 2, 0, 0, 4, 8, '20201414147818', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(379, 2, 0, 0, 4, 8, '20201414147819', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(380, 2, 0, 0, 4, 8, '20201414147820', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(381, 2, 0, 0, 4, 8, '20201414147821', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(382, 2, 0, 0, 4, 8, '20201414147822', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(383, 2, 0, 0, 4, 8, '20201414147823', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(384, 2, 0, 0, 4, 8, '20201414147824', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(385, 2, 0, 0, 4, 8, '20201414147825', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(386, 2, 0, 0, 4, 8, '20201414147826', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(387, 2, 0, 0, 4, 8, '20201414147827', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(388, 2, 0, 0, 4, 8, '20201414147828', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(389, 2, 0, 0, 4, 8, '20201414147829', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(390, 2, 0, 0, 4, 8, '20201414147830', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(391, 2, 0, 0, 4, 8, '20201414147831', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(392, 2, 0, 0, 4, 8, '20201414147832', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(393, 2, 0, 0, 4, 8, '20201414147833', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(394, 2, 0, 0, 4, 8, '20201414147834', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(395, 2, 0, 0, 4, 8, '20201414147835', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(396, 2, 0, 0, 4, 8, '20201414147836', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(397, 2, 0, 0, 4, 8, '20201414147837', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(398, 2, 0, 0, 4, 8, '20201414147838', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(399, 2, 0, 0, 4, 8, '20201414147839', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(400, 2, 0, 0, 4, 8, '20201414147840', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(401, 2, 0, 0, 4, 8, '20201414147841', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(402, 2, 0, 0, 4, 8, '20201414147842', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(403, 2, 0, 0, 4, 8, '20201414147843', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(404, 2, 0, 0, 4, 8, '20201414147844', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(405, 2, 0, 0, 4, 8, '20201414147845', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(406, 2, 0, 0, 4, 8, '20201414147846', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(407, 2, 0, 0, 4, 8, '20201414147847', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(408, 2, 0, 0, 4, 8, '20201414147848', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(409, 2, 0, 0, 4, 8, '20201414147849', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(410, 2, 0, 0, 4, 8, '20201414147850', 10, 0, 0, 0, 1, '2020-01-04 13:41:49', 2),
(411, 2, 0, 0, 3, 5, '202014142451', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(412, 2, 0, 0, 3, 5, '202014142452', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(413, 2, 0, 0, 3, 5, '202014142453', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(414, 2, 0, 0, 3, 5, '202014142454', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(415, 2, 0, 0, 3, 5, '202014142455', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(416, 2, 0, 0, 3, 5, '202014142456', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(417, 2, 0, 0, 3, 5, '202014142457', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(418, 2, 0, 0, 3, 5, '202014142458', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(419, 2, 0, 0, 3, 5, '202014142459', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(420, 2, 0, 0, 3, 5, '2020141424510', 12, 0, 0, 0, 1, '2020-01-04 13:42:06', 2),
(421, 3, 1, 1, 1, 1, 'SNO20201412424311', 13, 0, 0, 0, 39, '2020-01-04 13:49:52', 4),
(422, 3, 1, 1, 1, 1, 'SNO20201412424312', 13, 0, 0, 0, 39, '2020-01-04 13:49:52', 4),
(423, 3, 1, 1, 1, 1, 'SNO20201412424313', 13, 0, 0, 0, 39, '2020-01-04 13:49:52', 6),
(424, 3, 1, 1, 1, 1, 'SNO20201412424314', 13, 0, 0, 0, 39, '2020-01-04 13:49:53', 6),
(425, 3, 1, 1, 1, 1, 'SNO20201412424315', 13, 0, 0, 0, 39, '2020-01-04 13:49:53', 6),
(426, 3, 1, 1, 1, 1, 'SNO20201412424316', 13, 0, 0, 0, 39, '2020-01-04 13:49:53', 6),
(427, 3, 1, 1, 1, 1, 'SNO20201412424317', 13, 0, 0, 0, 39, '2020-01-04 13:49:53', 6),
(428, 3, 1, 1, 1, 1, 'SNO20201412424318', 13, 0, 0, 0, 39, '2020-01-04 13:49:53', 5),
(429, 3, 1, 1, 1, 1, 'SNO20201412424319', 13, 0, 0, 0, 39, '2020-01-04 13:49:54', 5),
(430, 3, 1, 1, 1, 1, 'SNO202014124243110', 13, 0, 0, 0, 39, '2020-01-04 13:49:54', 2),
(431, 3, 1, 1, 1, 1, 'SNO202014124243111', 13, 0, 0, 0, 39, '2020-01-04 13:49:54', 2),
(432, 3, 1, 1, 1, 1, 'SNO202014124243112', 13, 0, 0, 0, 39, '2020-01-04 13:49:54', 2),
(433, 3, 1, 1, 1, 1, 'SNO202014124243113', 13, 0, 0, 0, 39, '2020-01-04 13:49:54', 2),
(434, 3, 1, 1, 1, 1, 'SNO202014124243114', 13, 0, 0, 0, 39, '2020-01-04 13:49:55', 2),
(435, 3, 1, 1, 1, 1, 'SNO202014124243115', 13, 0, 0, 0, 39, '2020-01-04 13:49:55', 2),
(436, 3, 1, 1, 1, 1, 'SNO202014124243116', 13, 0, 0, 0, 39, '2020-01-04 13:49:55', 2),
(437, 3, 1, 1, 1, 1, 'SNO202014124243117', 13, 0, 0, 0, 39, '2020-01-04 13:49:55', 2),
(438, 3, 1, 1, 1, 1, 'SNO202014124243118', 13, 0, 0, 0, 39, '2020-01-04 13:49:55', 2),
(439, 3, 1, 1, 1, 1, 'SNO202014124243119', 13, 0, 0, 0, 39, '2020-01-04 13:49:55', 2),
(440, 3, 1, 1, 1, 1, 'SNO202014124243120', 13, 0, 0, 0, 39, '2020-01-04 13:49:55', 2),
(441, 3, 1, 1, 1, 1, 'SNO202014124243121', 13, 0, 0, 0, 39, '2020-01-04 13:49:56', 2),
(442, 3, 1, 1, 1, 1, 'SNO202014124243122', 13, 0, 0, 0, 39, '2020-01-04 13:49:56', 2),
(443, 3, 1, 1, 1, 1, 'SNO202014124243123', 13, 0, 0, 0, 39, '2020-01-04 13:49:56', 2),
(444, 3, 1, 1, 1, 1, 'SNO202014124243124', 13, 0, 0, 0, 39, '2020-01-04 13:49:56', 2),
(445, 3, 1, 1, 1, 1, 'SNO202014124243125', 13, 0, 0, 0, 39, '2020-01-04 13:49:56', 2),
(446, 3, 1, 1, 1, 2, 'SNO20201412425921', 14, 0, 0, 0, 39, '2020-01-04 13:49:56', 4),
(447, 3, 1, 1, 1, 2, 'SNO20201412425922', 14, 0, 0, 0, 39, '2020-01-04 13:49:56', 4),
(448, 3, 1, 1, 1, 2, 'SNO20201412425923', 14, 0, 0, 0, 39, '2020-01-04 13:49:56', 2),
(449, 3, 1, 1, 1, 2, 'SNO20201412425924', 14, 0, 0, 0, 39, '2020-01-04 13:49:57', 2),
(450, 3, 1, 1, 1, 2, 'SNO20201412425925', 14, 0, 0, 0, 39, '2020-01-04 13:49:57', 2),
(451, 3, 1, 1, 1, 2, 'SNO20201412425926', 14, 0, 0, 0, 39, '2020-01-04 13:49:57', 2),
(452, 3, 1, 1, 1, 2, 'SNO20201412425927', 14, 0, 0, 0, 39, '2020-01-04 13:49:57', 2),
(453, 3, 1, 1, 1, 2, 'SNO20201412425928', 14, 0, 0, 0, 39, '2020-01-04 13:49:57', 2),
(454, 3, 1, 1, 1, 2, 'SNO20201412425929', 14, 0, 0, 0, 39, '2020-01-04 13:49:57', 2),
(455, 3, 1, 1, 1, 2, 'SNO202014124259210', 14, 0, 0, 0, 39, '2020-01-04 13:49:58', 2),
(456, 3, 1, 1, 1, 2, 'SNO202014124259211', 14, 0, 0, 0, 39, '2020-01-04 13:49:58', 2),
(457, 3, 1, 1, 1, 2, 'SNO202014124259212', 14, 0, 0, 0, 39, '2020-01-04 13:49:58', 2),
(458, 3, 1, 1, 1, 2, 'SNO202014124259213', 14, 0, 0, 0, 39, '2020-01-04 13:49:58', 2),
(459, 3, 1, 1, 1, 2, 'SNO202014124259214', 14, 0, 0, 0, 39, '2020-01-04 13:49:58', 2),
(460, 3, 1, 1, 1, 2, 'SNO202014124259215', 14, 0, 0, 0, 39, '2020-01-04 13:49:58', 2),
(461, 3, 1, 1, 1, 2, 'SNO202014124259216', 14, 0, 0, 0, 39, '2020-01-04 13:49:59', 2),
(462, 3, 1, 1, 1, 2, 'SNO202014124259217', 14, 0, 0, 0, 39, '2020-01-04 13:49:59', 2),
(463, 3, 1, 1, 1, 2, 'SNO202014124259218', 14, 0, 0, 0, 39, '2020-01-04 13:49:59', 2),
(464, 3, 1, 1, 1, 2, 'SNO202014124259219', 14, 0, 0, 0, 39, '2020-01-04 13:49:59', 2),
(465, 3, 1, 1, 1, 2, 'SNO202014124259220', 14, 0, 0, 0, 39, '2020-01-04 13:49:59', 2),
(466, 3, 1, 1, 1, 2, 'SNO202014124259221', 14, 0, 0, 0, 39, '2020-01-04 13:49:59', 2),
(467, 3, 1, 1, 1, 2, 'SNO202014124259222', 14, 0, 0, 0, 39, '2020-01-04 13:49:59', 2),
(468, 3, 1, 1, 1, 2, 'SNO202014124259223', 14, 0, 0, 0, 39, '2020-01-04 13:50:00', 2),
(469, 3, 1, 1, 1, 2, 'SNO202014124259224', 14, 0, 0, 0, 39, '2020-01-04 13:50:00', 2),
(470, 3, 1, 1, 1, 2, 'SNO202014124259225', 14, 0, 0, 0, 39, '2020-01-04 13:50:00', 2),
(471, 4, 1, 1, 4, 7, '20201412431271', 16, 0, 0, 0, 39, '2020-01-04 14:03:13', 2),
(472, 4, 1, 1, 4, 7, '20201412431272', 16, 0, 0, 0, 39, '2020-01-04 14:03:13', 2),
(473, 4, 1, 1, 4, 7, '20201412431273', 16, 0, 0, 0, 39, '2020-01-04 14:03:14', 2),
(474, 4, 1, 1, 4, 7, '20201412431274', 16, 0, 0, 0, 39, '2020-01-04 14:03:14', 2),
(475, 4, 1, 1, 4, 7, '20201412431275', 16, 0, 0, 0, 39, '2020-01-04 14:03:14', 2),
(476, 4, 1, 1, 4, 7, '20201412431276', 16, 0, 0, 0, 39, '2020-01-04 14:03:14', 2),
(477, 4, 1, 1, 4, 7, '20201412431277', 16, 0, 0, 0, 39, '2020-01-04 14:03:14', 2),
(478, 4, 1, 1, 4, 7, '20201412431278', 16, 0, 0, 0, 39, '2020-01-04 14:03:15', 2),
(479, 4, 1, 1, 4, 7, '20201412431279', 16, 0, 0, 0, 39, '2020-01-04 14:03:15', 2),
(480, 4, 1, 1, 4, 7, '202014124312710', 16, 0, 0, 0, 39, '2020-01-04 14:03:15', 2),
(481, 4, 1, 1, 4, 7, '202014124312711', 16, 0, 0, 0, 39, '2020-01-04 14:03:15', 2),
(482, 4, 1, 1, 4, 7, '202014124312712', 16, 0, 0, 0, 39, '2020-01-04 14:03:15', 2),
(483, 4, 1, 1, 4, 7, '202014124312713', 16, 0, 0, 0, 39, '2020-01-04 14:03:15', 2),
(484, 4, 1, 1, 4, 7, '202014124312714', 16, 0, 0, 0, 39, '2020-01-04 14:03:15', 2),
(485, 4, 1, 1, 4, 7, '202014124312715', 16, 0, 0, 0, 39, '2020-01-04 14:03:16', 2),
(486, 4, 1, 1, 4, 7, '202014124312716', 16, 0, 0, 0, 39, '2020-01-04 14:03:16', 2),
(487, 4, 1, 1, 4, 7, '202014124312717', 16, 0, 0, 0, 39, '2020-01-04 14:03:16', 2),
(488, 4, 1, 1, 4, 7, '202014124312718', 16, 0, 0, 0, 39, '2020-01-04 14:03:16', 2),
(489, 4, 1, 1, 4, 7, '202014124312719', 16, 0, 0, 0, 39, '2020-01-04 14:03:16', 2),
(490, 4, 1, 1, 4, 7, '202014124312720', 16, 0, 0, 0, 39, '2020-01-04 14:03:16', 2),
(491, 4, 1, 1, 4, 7, '202014124312721', 16, 0, 0, 0, 39, '2020-01-04 14:03:17', 2),
(492, 4, 1, 1, 4, 7, '202014124312722', 16, 0, 0, 0, 39, '2020-01-04 14:03:17', 2),
(493, 4, 1, 1, 4, 7, '202014124312723', 16, 0, 0, 0, 39, '2020-01-04 14:03:17', 2),
(494, 4, 1, 1, 4, 7, '202014124312724', 16, 0, 0, 0, 39, '2020-01-04 14:03:17', 2),
(495, 4, 1, 1, 4, 7, '202014124312725', 16, 0, 0, 0, 39, '2020-01-04 14:03:17', 2),
(496, 4, 1, 1, 4, 8, '20201412432381', 17, 0, 0, 0, 39, '2020-01-04 14:03:17', 2),
(497, 4, 1, 1, 4, 8, '20201412432382', 17, 0, 0, 0, 39, '2020-01-04 14:03:17', 2),
(498, 4, 1, 1, 4, 8, '20201412432383', 17, 0, 0, 0, 39, '2020-01-04 14:03:17', 2),
(499, 4, 1, 1, 4, 8, '20201412432384', 17, 0, 0, 0, 39, '2020-01-04 14:03:18', 2),
(500, 4, 1, 1, 4, 8, '20201412432385', 17, 0, 0, 0, 39, '2020-01-04 14:03:18', 2),
(501, 4, 1, 1, 4, 8, '20201412432386', 17, 0, 0, 0, 39, '2020-01-04 14:03:18', 2),
(502, 4, 1, 1, 4, 8, '20201412432387', 17, 0, 0, 0, 39, '2020-01-04 14:03:18', 2),
(503, 4, 1, 1, 4, 8, '20201412432388', 17, 0, 0, 0, 39, '2020-01-04 14:03:18', 2),
(504, 4, 1, 1, 4, 8, '20201412432389', 17, 0, 0, 0, 39, '2020-01-04 14:03:18', 2),
(505, 4, 1, 1, 4, 8, '202014124323810', 17, 0, 0, 0, 39, '2020-01-04 14:03:18', 2),
(506, 4, 1, 1, 4, 8, '202014124323811', 17, 0, 0, 0, 39, '2020-01-04 14:03:19', 2),
(507, 4, 1, 1, 4, 8, '202014124323812', 17, 0, 0, 0, 39, '2020-01-04 14:03:19', 2),
(508, 4, 1, 1, 4, 8, '202014124323813', 17, 0, 0, 0, 39, '2020-01-04 14:03:19', 2),
(509, 4, 1, 1, 4, 8, '202014124323814', 17, 0, 0, 0, 39, '2020-01-04 14:03:19', 2),
(510, 4, 1, 1, 4, 8, '202014124323815', 17, 0, 0, 0, 39, '2020-01-04 14:03:19', 2),
(511, 4, 1, 1, 4, 8, '202014124323816', 17, 0, 0, 0, 39, '2020-01-04 14:03:20', 2),
(512, 4, 1, 1, 4, 8, '202014124323817', 17, 0, 0, 0, 39, '2020-01-04 14:03:20', 2),
(513, 4, 1, 1, 4, 8, '202014124323818', 17, 0, 0, 0, 39, '2020-01-04 14:03:20', 2),
(514, 4, 1, 1, 4, 8, '202014124323819', 17, 0, 0, 0, 39, '2020-01-04 14:03:20', 2),
(515, 4, 1, 1, 4, 8, '202014124323820', 17, 0, 0, 0, 39, '2020-01-04 14:03:20', 2),
(516, 4, 1, 1, 4, 8, '202014124323821', 17, 0, 0, 0, 39, '2020-01-04 14:03:20', 2),
(517, 4, 1, 1, 4, 8, '202014124323822', 17, 0, 0, 0, 39, '2020-01-04 14:03:21', 2),
(518, 4, 1, 1, 4, 8, '202014124323823', 17, 0, 0, 0, 39, '2020-01-04 14:03:21', 2),
(519, 4, 1, 1, 4, 8, '202014124323824', 17, 0, 0, 0, 39, '2020-01-04 14:03:21', 2),
(520, 4, 1, 1, 4, 8, '202014124323825', 17, 0, 0, 0, 39, '2020-01-04 14:03:21', 2),
(521, 4, 1, 1, 3, 5, '20201412434351', 15, 0, 0, 0, 39, '2020-01-04 14:03:21', 2),
(522, 4, 1, 1, 3, 5, '20201412434352', 15, 0, 0, 0, 39, '2020-01-04 14:03:21', 2),
(523, 4, 1, 1, 3, 5, '20201412434353', 15, 0, 0, 0, 39, '2020-01-04 14:03:22', 2),
(524, 4, 1, 1, 3, 5, '20201412434354', 15, 0, 0, 0, 39, '2020-01-04 14:03:22', 2),
(525, 4, 1, 1, 3, 5, '20201412434355', 15, 0, 0, 0, 39, '2020-01-04 14:03:22', 2),
(526, 5, 3, 1, 1, 1, 'SNO202014124243126', 18, 0, 0, 0, 40, '2020-01-04 14:15:15', 2),
(527, 5, 3, 1, 1, 1, 'SNO202014124243127', 18, 0, 0, 0, 40, '2020-01-04 14:15:16', 2),
(528, 5, 3, 1, 1, 1, 'SNO202014124243128', 18, 0, 0, 0, 40, '2020-01-04 14:15:16', 2),
(529, 5, 3, 1, 1, 1, 'SNO202014124243129', 18, 0, 0, 0, 40, '2020-01-04 14:15:16', 2),
(530, 5, 3, 1, 1, 1, 'SNO202014124243130', 18, 0, 0, 0, 40, '2020-01-04 14:15:16', 2),
(531, 5, 3, 1, 1, 1, 'SNO202014124243131', 18, 0, 0, 0, 40, '2020-01-04 14:15:16', 2),
(532, 5, 3, 1, 1, 1, 'SNO202014124243132', 18, 0, 0, 0, 40, '2020-01-04 14:15:16', 2),
(533, 5, 3, 1, 1, 1, 'SNO202014124243133', 18, 0, 0, 0, 40, '2020-01-04 14:15:17', 2),
(534, 5, 3, 1, 1, 1, 'SNO202014124243134', 18, 0, 0, 0, 40, '2020-01-04 14:15:17', 2),
(535, 5, 3, 1, 1, 1, 'SNO202014124243135', 18, 0, 0, 0, 40, '2020-01-04 14:15:17', 2),
(536, 5, 3, 1, 1, 2, 'SNO202014124259226', 19, 0, 0, 0, 40, '2020-01-04 14:15:17', 2),
(537, 5, 3, 1, 1, 2, 'SNO202014124259227', 19, 0, 0, 0, 40, '2020-01-04 14:15:17', 2),
(538, 5, 3, 1, 1, 2, 'SNO202014124259228', 19, 0, 0, 0, 40, '2020-01-04 14:15:17', 2),
(539, 5, 3, 1, 1, 2, 'SNO202014124259229', 19, 0, 0, 0, 40, '2020-01-04 14:15:18', 2),
(540, 5, 3, 1, 1, 2, 'SNO202014124259230', 19, 0, 0, 0, 40, '2020-01-04 14:15:18', 2),
(541, 5, 3, 1, 1, 2, 'SNO202014124259231', 19, 0, 0, 0, 40, '2020-01-04 14:15:18', 2),
(542, 5, 3, 1, 1, 2, 'SNO202014124259232', 19, 0, 0, 0, 40, '2020-01-04 14:15:18', 2),
(543, 5, 3, 1, 1, 2, 'SNO202014124259233', 19, 0, 0, 0, 40, '2020-01-04 14:15:18', 2),
(544, 5, 3, 1, 1, 2, 'SNO202014124259234', 19, 0, 0, 0, 40, '2020-01-04 14:15:18', 2),
(545, 5, 3, 1, 1, 2, 'SNO202014124259235', 19, 0, 0, 0, 40, '2020-01-04 14:15:19', 2),
(546, 6, 3, 1, 4, 7, '202014124312726', 21, 0, 0, 0, 40, '2020-01-04 14:15:38', 2),
(547, 6, 3, 1, 4, 7, '202014124312727', 21, 0, 0, 0, 40, '2020-01-04 14:15:38', 2),
(548, 6, 3, 1, 4, 7, '202014124312728', 21, 0, 0, 0, 40, '2020-01-04 14:15:39', 2),
(549, 6, 3, 1, 4, 7, '202014124312729', 21, 0, 0, 0, 40, '2020-01-04 14:15:39', 2),
(550, 6, 3, 1, 4, 7, '202014124312730', 21, 0, 0, 0, 40, '2020-01-04 14:15:39', 2),
(551, 6, 3, 1, 4, 7, '202014124312731', 21, 0, 0, 0, 40, '2020-01-04 14:15:39', 2),
(552, 6, 3, 1, 4, 7, '202014124312732', 21, 0, 0, 0, 40, '2020-01-04 14:15:39', 2),
(553, 6, 3, 1, 4, 7, '202014124312733', 21, 0, 0, 0, 40, '2020-01-04 14:15:39', 2),
(554, 6, 3, 1, 4, 7, '202014124312734', 21, 0, 0, 0, 40, '2020-01-04 14:15:39', 2),
(555, 6, 3, 1, 4, 7, '202014124312735', 21, 0, 0, 0, 40, '2020-01-04 14:15:40', 2),
(556, 6, 3, 1, 4, 8, '202014124323826', 22, 0, 0, 0, 40, '2020-01-04 14:15:40', 2),
(557, 6, 3, 1, 4, 8, '202014124323827', 22, 0, 0, 0, 40, '2020-01-04 14:15:40', 2),
(558, 6, 3, 1, 4, 8, '202014124323828', 22, 0, 0, 0, 40, '2020-01-04 14:15:40', 2),
(559, 6, 3, 1, 4, 8, '202014124323829', 22, 0, 0, 0, 40, '2020-01-04 14:15:40', 2),
(560, 6, 3, 1, 4, 8, '202014124323830', 22, 0, 0, 0, 40, '2020-01-04 14:15:40', 2),
(561, 6, 3, 1, 4, 8, '202014124323831', 22, 0, 0, 0, 40, '2020-01-04 14:15:40', 2),
(562, 6, 3, 1, 4, 8, '202014124323832', 22, 0, 0, 0, 40, '2020-01-04 14:15:41', 2),
(563, 6, 3, 1, 4, 8, '202014124323833', 22, 0, 0, 0, 40, '2020-01-04 14:15:41', 2),
(564, 6, 3, 1, 4, 8, '202014124323834', 22, 0, 0, 0, 40, '2020-01-04 14:15:41', 2),
(565, 6, 3, 1, 4, 8, '202014124323835', 22, 0, 0, 0, 40, '2020-01-04 14:15:41', 2),
(566, 6, 3, 1, 3, 5, '20201412434356', 20, 0, 0, 0, 40, '2020-01-04 14:15:41', 2),
(567, 6, 3, 1, 3, 5, '20201412434357', 20, 0, 0, 0, 40, '2020-01-04 14:15:41', 2),
(568, 7, 0, 0, 1, 1, 'SNO2020175301011', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 4),
(569, 7, 0, 0, 1, 1, 'SNO2020175301012', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 4),
(570, 7, 0, 0, 1, 1, 'SNO2020175301013', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 8),
(571, 7, 0, 0, 1, 1, 'SNO2020175301014', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 8),
(572, 7, 0, 0, 1, 1, 'SNO2020175301015', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 8),
(573, 7, 0, 0, 1, 1, 'SNO2020175301016', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 8),
(574, 7, 0, 0, 1, 1, 'SNO2020175301017', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 8),
(575, 7, 0, 0, 1, 1, 'SNO2020175301018', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 6),
(576, 7, 0, 0, 1, 1, 'SNO2020175301019', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 6),
(577, 7, 0, 0, 1, 1, 'SNO20201753010110', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 6),
(578, 7, 0, 0, 1, 1, 'SNO20201753010111', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 6),
(579, 7, 0, 0, 1, 1, 'SNO20201753010112', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 6),
(580, 7, 0, 0, 1, 1, 'SNO20201753010113', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 4),
(581, 7, 0, 0, 1, 1, 'SNO20201753010114', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(582, 7, 0, 0, 1, 1, 'SNO20201753010115', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(583, 7, 0, 0, 1, 1, 'SNO20201753010116', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(584, 7, 0, 0, 1, 1, 'SNO20201753010117', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(585, 7, 0, 0, 1, 1, 'SNO20201753010118', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(586, 7, 0, 0, 1, 1, 'SNO20201753010119', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(587, 7, 0, 0, 1, 1, 'SNO20201753010120', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(588, 7, 0, 0, 1, 1, 'SNO20201753010121', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(589, 7, 0, 0, 1, 1, 'SNO20201753010122', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(590, 7, 0, 0, 1, 1, 'SNO20201753010123', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(591, 7, 0, 0, 1, 1, 'SNO20201753010124', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(592, 7, 0, 0, 1, 1, 'SNO20201753010125', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(593, 7, 0, 0, 1, 1, 'SNO20201753010126', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(594, 7, 0, 0, 1, 1, 'SNO20201753010127', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(595, 7, 0, 0, 1, 1, 'SNO20201753010128', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(596, 7, 0, 0, 1, 1, 'SNO20201753010129', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(597, 7, 0, 0, 1, 1, 'SNO20201753010130', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(598, 7, 0, 0, 1, 1, 'SNO20201753010131', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(599, 7, 0, 0, 1, 1, 'SNO20201753010132', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(600, 7, 0, 0, 1, 1, 'SNO20201753010133', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(601, 7, 0, 0, 1, 1, 'SNO20201753010134', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(602, 7, 0, 0, 1, 1, 'SNO20201753010135', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(603, 7, 0, 0, 1, 1, 'SNO20201753010136', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(604, 7, 0, 0, 1, 1, 'SNO20201753010137', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(605, 7, 0, 0, 1, 1, 'SNO20201753010138', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(606, 7, 0, 0, 1, 1, 'SNO20201753010139', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(607, 7, 0, 0, 1, 1, 'SNO20201753010140', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(608, 7, 0, 0, 1, 1, 'SNO20201753010141', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(609, 7, 0, 0, 1, 1, 'SNO20201753010142', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(610, 7, 0, 0, 1, 1, 'SNO20201753010143', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1);
INSERT INTO `product_stock_serialno` (`idProductserialno`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProductsize`, `serialno`, `idWhStockItem`, `idOrderallocateditems`, `idOrder`, `offer_flog`, `created_by`, `created_at`, `status`) VALUES
(611, 7, 0, 0, 1, 1, 'SNO20201753010144', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(612, 7, 0, 0, 1, 1, 'SNO20201753010145', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(613, 7, 0, 0, 1, 1, 'SNO20201753010146', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(614, 7, 0, 0, 1, 1, 'SNO20201753010147', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(615, 7, 0, 0, 1, 1, 'SNO20201753010148', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(616, 7, 0, 0, 1, 1, 'SNO20201753010149', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(617, 7, 0, 0, 1, 1, 'SNO20201753010150', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(618, 7, 0, 0, 1, 1, 'SNO20201753010151', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(619, 7, 0, 0, 1, 1, 'SNO20201753010152', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(620, 7, 0, 0, 1, 1, 'SNO20201753010153', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(621, 7, 0, 0, 1, 1, 'SNO20201753010154', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(622, 7, 0, 0, 1, 1, 'SNO20201753010155', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(623, 7, 0, 0, 1, 1, 'SNO20201753010156', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(624, 7, 0, 0, 1, 1, 'SNO20201753010157', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(625, 7, 0, 0, 1, 1, 'SNO20201753010158', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(626, 7, 0, 0, 1, 1, 'SNO20201753010159', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(627, 7, 0, 0, 1, 1, 'SNO20201753010160', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(628, 7, 0, 0, 1, 1, 'SNO20201753010161', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(629, 7, 0, 0, 1, 1, 'SNO20201753010162', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(630, 7, 0, 0, 1, 1, 'SNO20201753010163', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(631, 7, 0, 0, 1, 1, 'SNO20201753010164', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(632, 7, 0, 0, 1, 1, 'SNO20201753010165', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(633, 7, 0, 0, 1, 1, 'SNO20201753010166', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(634, 7, 0, 0, 1, 1, 'SNO20201753010167', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(635, 7, 0, 0, 1, 1, 'SNO20201753010168', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(636, 7, 0, 0, 1, 1, 'SNO20201753010169', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(637, 7, 0, 0, 1, 1, 'SNO20201753010170', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(638, 7, 0, 0, 1, 1, 'SNO20201753010171', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(639, 7, 0, 0, 1, 1, 'SNO20201753010172', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(640, 7, 0, 0, 1, 1, 'SNO20201753010173', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(641, 7, 0, 0, 1, 1, 'SNO20201753010174', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(642, 7, 0, 0, 1, 1, 'SNO20201753010175', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(643, 7, 0, 0, 1, 1, 'SNO20201753010176', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(644, 7, 0, 0, 1, 1, 'SNO20201753010177', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(645, 7, 0, 0, 1, 1, 'SNO20201753010178', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(646, 7, 0, 0, 1, 1, 'SNO20201753010179', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(647, 7, 0, 0, 1, 1, 'SNO20201753010180', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(648, 7, 0, 0, 1, 1, 'SNO20201753010181', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(649, 7, 0, 0, 1, 1, 'SNO20201753010182', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(650, 7, 0, 0, 1, 1, 'SNO20201753010183', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(651, 7, 0, 0, 1, 1, 'SNO20201753010184', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(652, 7, 0, 0, 1, 1, 'SNO20201753010185', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(653, 7, 0, 0, 1, 1, 'SNO20201753010186', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(654, 7, 0, 0, 1, 1, 'SNO20201753010187', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(655, 7, 0, 0, 1, 1, 'SNO20201753010188', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(656, 7, 0, 0, 1, 1, 'SNO20201753010189', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(657, 7, 0, 0, 1, 1, 'SNO20201753010190', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(658, 7, 0, 0, 1, 1, 'SNO20201753010191', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(659, 7, 0, 0, 1, 1, 'SNO20201753010192', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(660, 7, 0, 0, 1, 1, 'SNO20201753010193', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(661, 7, 0, 0, 1, 1, 'SNO20201753010194', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(662, 7, 0, 0, 1, 1, 'SNO20201753010195', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(663, 7, 0, 0, 1, 1, 'SNO20201753010196', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(664, 7, 0, 0, 1, 1, 'SNO20201753010197', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(665, 7, 0, 0, 1, 1, 'SNO20201753010198', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(666, 7, 0, 0, 1, 1, 'SNO20201753010199', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(667, 7, 0, 0, 1, 1, 'SNO202017530101100', 23, 11, 5, 0, 1, '2020-01-07 17:30:16', 1),
(668, 7, 0, 0, 1, 1, 'SNO202017530101101', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(669, 7, 0, 0, 1, 1, 'SNO202017530101102', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(670, 7, 0, 0, 1, 1, 'SNO202017530101103', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(671, 7, 0, 0, 1, 1, 'SNO202017530101104', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(672, 7, 0, 0, 1, 1, 'SNO202017530101105', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(673, 7, 0, 0, 1, 1, 'SNO202017530101106', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(674, 7, 0, 0, 1, 1, 'SNO202017530101107', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(675, 7, 0, 0, 1, 1, 'SNO202017530101108', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(676, 7, 0, 0, 1, 1, 'SNO202017530101109', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(677, 7, 0, 0, 1, 1, 'SNO202017530101110', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(678, 7, 0, 0, 1, 1, 'SNO202017530101111', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(679, 7, 0, 0, 1, 1, 'SNO202017530101112', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(680, 7, 0, 0, 1, 1, 'SNO202017530101113', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(681, 7, 0, 0, 1, 1, 'SNO202017530101114', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(682, 7, 0, 0, 1, 1, 'SNO202017530101115', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(683, 7, 0, 0, 1, 1, 'SNO202017530101116', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(684, 7, 0, 0, 1, 1, 'SNO202017530101117', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(685, 7, 0, 0, 1, 1, 'SNO202017530101118', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(686, 7, 0, 0, 1, 1, 'SNO202017530101119', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(687, 7, 0, 0, 1, 1, 'SNO202017530101120', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(688, 7, 0, 0, 1, 1, 'SNO202017530101121', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(689, 7, 0, 0, 1, 1, 'SNO202017530101122', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(690, 7, 0, 0, 1, 1, 'SNO202017530101123', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(691, 7, 0, 0, 1, 1, 'SNO202017530101124', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(692, 7, 0, 0, 1, 1, 'SNO202017530101125', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(693, 7, 0, 0, 1, 1, 'SNO202017530101126', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(694, 7, 0, 0, 1, 1, 'SNO202017530101127', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(695, 7, 0, 0, 1, 1, 'SNO202017530101128', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(696, 7, 0, 0, 1, 1, 'SNO202017530101129', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(697, 7, 0, 0, 1, 1, 'SNO202017530101130', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(698, 7, 0, 0, 1, 1, 'SNO202017530101131', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(699, 7, 0, 0, 1, 1, 'SNO202017530101132', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(700, 7, 0, 0, 1, 1, 'SNO202017530101133', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(701, 7, 0, 0, 1, 1, 'SNO202017530101134', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(702, 7, 0, 0, 1, 1, 'SNO202017530101135', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(703, 7, 0, 0, 1, 1, 'SNO202017530101136', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(704, 7, 0, 0, 1, 1, 'SNO202017530101137', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(705, 7, 0, 0, 1, 1, 'SNO202017530101138', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(706, 7, 0, 0, 1, 1, 'SNO202017530101139', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(707, 7, 0, 0, 1, 1, 'SNO202017530101140', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(708, 7, 0, 0, 1, 1, 'SNO202017530101141', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(709, 7, 0, 0, 1, 1, 'SNO202017530101142', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(710, 7, 0, 0, 1, 1, 'SNO202017530101143', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(711, 7, 0, 0, 1, 1, 'SNO202017530101144', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(712, 7, 0, 0, 1, 1, 'SNO202017530101145', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(713, 7, 0, 0, 1, 1, 'SNO202017530101146', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(714, 7, 0, 0, 1, 1, 'SNO202017530101147', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(715, 7, 0, 0, 1, 1, 'SNO202017530101148', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(716, 7, 0, 0, 1, 1, 'SNO202017530101149', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(717, 7, 0, 0, 1, 1, 'SNO202017530101150', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(718, 7, 0, 0, 1, 1, 'SNO202017530101151', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(719, 7, 0, 0, 1, 1, 'SNO202017530101152', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(720, 7, 0, 0, 1, 1, 'SNO202017530101153', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(721, 7, 0, 0, 1, 1, 'SNO202017530101154', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(722, 7, 0, 0, 1, 1, 'SNO202017530101155', 23, 13, 12, 0, 1, '2020-01-07 17:30:16', 1),
(723, 7, 0, 0, 1, 1, 'SNO202017530101156', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(724, 7, 0, 0, 1, 1, 'SNO202017530101157', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(725, 7, 0, 0, 1, 1, 'SNO202017530101158', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(726, 7, 0, 0, 1, 1, 'SNO202017530101159', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(727, 7, 0, 0, 1, 1, 'SNO202017530101160', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(728, 7, 0, 0, 1, 1, 'SNO202017530101161', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(729, 7, 0, 0, 1, 1, 'SNO202017530101162', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(730, 7, 0, 0, 1, 1, 'SNO202017530101163', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(731, 7, 0, 0, 1, 1, 'SNO202017530101164', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(732, 7, 0, 0, 1, 1, 'SNO202017530101165', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(733, 7, 0, 0, 1, 1, 'SNO202017530101166', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(734, 7, 0, 0, 1, 1, 'SNO202017530101167', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(735, 7, 0, 0, 1, 1, 'SNO202017530101168', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(736, 7, 0, 0, 1, 1, 'SNO202017530101169', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(737, 7, 0, 0, 1, 1, 'SNO202017530101170', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(738, 7, 0, 0, 1, 1, 'SNO202017530101171', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(739, 7, 0, 0, 1, 1, 'SNO202017530101172', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(740, 7, 0, 0, 1, 1, 'SNO202017530101173', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(741, 7, 0, 0, 1, 1, 'SNO202017530101174', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(742, 7, 0, 0, 1, 1, 'SNO202017530101175', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(743, 7, 0, 0, 1, 1, 'SNO202017530101176', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(744, 7, 0, 0, 1, 1, 'SNO202017530101177', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(745, 7, 0, 0, 1, 1, 'SNO202017530101178', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(746, 7, 0, 0, 1, 1, 'SNO202017530101179', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(747, 7, 0, 0, 1, 1, 'SNO202017530101180', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(748, 7, 0, 0, 1, 1, 'SNO202017530101181', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(749, 7, 0, 0, 1, 1, 'SNO202017530101182', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(750, 7, 0, 0, 1, 1, 'SNO202017530101183', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(751, 7, 0, 0, 1, 1, 'SNO202017530101184', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(752, 7, 0, 0, 1, 1, 'SNO202017530101185', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(753, 7, 0, 0, 1, 1, 'SNO202017530101186', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(754, 7, 0, 0, 1, 1, 'SNO202017530101187', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(755, 7, 0, 0, 1, 1, 'SNO202017530101188', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(756, 7, 0, 0, 1, 1, 'SNO202017530101189', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(757, 7, 0, 0, 1, 1, 'SNO202017530101190', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(758, 7, 0, 0, 1, 1, 'SNO202017530101191', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(759, 7, 0, 0, 1, 1, 'SNO202017530101192', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(760, 7, 0, 0, 1, 1, 'SNO202017530101193', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(761, 7, 0, 0, 1, 1, 'SNO202017530101194', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(762, 7, 0, 0, 1, 1, 'SNO202017530101195', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(763, 7, 0, 0, 1, 1, 'SNO202017530101196', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(764, 7, 0, 0, 1, 1, 'SNO202017530101197', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(765, 7, 0, 0, 1, 1, 'SNO202017530101198', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(766, 7, 0, 0, 1, 1, 'SNO202017530101199', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(767, 7, 0, 0, 1, 1, 'SNO202017530101200', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(768, 7, 0, 0, 1, 1, 'SNO202017530101201', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(769, 7, 0, 0, 1, 1, 'SNO202017530101202', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(770, 7, 0, 0, 1, 1, 'SNO202017530101203', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(771, 7, 0, 0, 1, 1, 'SNO202017530101204', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(772, 7, 0, 0, 1, 1, 'SNO202017530101205', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(773, 7, 0, 0, 1, 1, 'SNO202017530101206', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(774, 7, 0, 0, 1, 1, 'SNO202017530101207', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(775, 7, 0, 0, 1, 1, 'SNO202017530101208', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(776, 7, 0, 0, 1, 1, 'SNO202017530101209', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(777, 7, 0, 0, 1, 1, 'SNO202017530101210', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(778, 7, 0, 0, 1, 1, 'SNO202017530101211', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(779, 7, 0, 0, 1, 1, 'SNO202017530101212', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(780, 7, 0, 0, 1, 1, 'SNO202017530101213', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(781, 7, 0, 0, 1, 1, 'SNO202017530101214', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(782, 7, 0, 0, 1, 1, 'SNO202017530101215', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(783, 7, 0, 0, 1, 1, 'SNO202017530101216', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(784, 7, 0, 0, 1, 1, 'SNO202017530101217', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(785, 7, 0, 0, 1, 1, 'SNO202017530101218', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(786, 7, 0, 0, 1, 1, 'SNO202017530101219', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(787, 7, 0, 0, 1, 1, 'SNO202017530101220', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(788, 7, 0, 0, 1, 1, 'SNO202017530101221', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(789, 7, 0, 0, 1, 1, 'SNO202017530101222', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(790, 7, 0, 0, 1, 1, 'SNO202017530101223', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(791, 7, 0, 0, 1, 1, 'SNO202017530101224', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(792, 7, 0, 0, 1, 1, 'SNO202017530101225', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(793, 7, 0, 0, 1, 1, 'SNO202017530101226', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(794, 7, 0, 0, 1, 1, 'SNO202017530101227', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(795, 7, 0, 0, 1, 1, 'SNO202017530101228', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(796, 7, 0, 0, 1, 1, 'SNO202017530101229', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(797, 7, 0, 0, 1, 1, 'SNO202017530101230', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(798, 7, 0, 0, 1, 1, 'SNO202017530101231', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(799, 7, 0, 0, 1, 1, 'SNO202017530101232', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(800, 7, 0, 0, 1, 1, 'SNO202017530101233', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(801, 7, 0, 0, 1, 1, 'SNO202017530101234', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(802, 7, 0, 0, 1, 1, 'SNO202017530101235', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(803, 7, 0, 0, 1, 1, 'SNO202017530101236', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(804, 7, 0, 0, 1, 1, 'SNO202017530101237', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(805, 7, 0, 0, 1, 1, 'SNO202017530101238', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(806, 7, 0, 0, 1, 1, 'SNO202017530101239', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(807, 7, 0, 0, 1, 1, 'SNO202017530101240', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(808, 7, 0, 0, 1, 1, 'SNO202017530101241', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(809, 7, 0, 0, 1, 1, 'SNO202017530101242', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(810, 7, 0, 0, 1, 1, 'SNO202017530101243', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(811, 7, 0, 0, 1, 1, 'SNO202017530101244', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(812, 7, 0, 0, 1, 1, 'SNO202017530101245', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(813, 7, 0, 0, 1, 1, 'SNO202017530101246', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(814, 7, 0, 0, 1, 1, 'SNO202017530101247', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(815, 7, 0, 0, 1, 1, 'SNO202017530101248', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(816, 7, 0, 0, 1, 1, 'SNO202017530101249', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(817, 7, 0, 0, 1, 1, 'SNO202017530101250', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(818, 7, 0, 0, 1, 1, 'SNO202017530101251', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(819, 7, 0, 0, 1, 1, 'SNO202017530101252', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(820, 7, 0, 0, 1, 1, 'SNO202017530101253', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(821, 7, 0, 0, 1, 1, 'SNO202017530101254', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(822, 7, 0, 0, 1, 1, 'SNO202017530101255', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(823, 7, 0, 0, 1, 1, 'SNO202017530101256', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(824, 7, 0, 0, 1, 1, 'SNO202017530101257', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(825, 7, 0, 0, 1, 1, 'SNO202017530101258', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(826, 7, 0, 0, 1, 1, 'SNO202017530101259', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(827, 7, 0, 0, 1, 1, 'SNO202017530101260', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(828, 7, 0, 0, 1, 1, 'SNO202017530101261', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(829, 7, 0, 0, 1, 1, 'SNO202017530101262', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(830, 7, 0, 0, 1, 1, 'SNO202017530101263', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(831, 7, 0, 0, 1, 1, 'SNO202017530101264', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(832, 7, 0, 0, 1, 1, 'SNO202017530101265', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(833, 7, 0, 0, 1, 1, 'SNO202017530101266', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(834, 7, 0, 0, 1, 1, 'SNO202017530101267', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(835, 7, 0, 0, 1, 1, 'SNO202017530101268', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(836, 7, 0, 0, 1, 1, 'SNO202017530101269', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(837, 7, 0, 0, 1, 1, 'SNO202017530101270', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(838, 7, 0, 0, 1, 1, 'SNO202017530101271', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(839, 7, 0, 0, 1, 1, 'SNO202017530101272', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(840, 7, 0, 0, 1, 1, 'SNO202017530101273', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(841, 7, 0, 0, 1, 1, 'SNO202017530101274', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(842, 7, 0, 0, 1, 1, 'SNO202017530101275', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(843, 7, 0, 0, 1, 1, 'SNO202017530101276', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(844, 7, 0, 0, 1, 1, 'SNO202017530101277', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(845, 7, 0, 0, 1, 1, 'SNO202017530101278', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(846, 7, 0, 0, 1, 1, 'SNO202017530101279', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(847, 7, 0, 0, 1, 1, 'SNO202017530101280', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(848, 7, 0, 0, 1, 1, 'SNO202017530101281', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(849, 7, 0, 0, 1, 1, 'SNO202017530101282', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(850, 7, 0, 0, 1, 1, 'SNO202017530101283', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(851, 7, 0, 0, 1, 1, 'SNO202017530101284', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(852, 7, 0, 0, 1, 1, 'SNO202017530101285', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(853, 7, 0, 0, 1, 1, 'SNO202017530101286', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(854, 7, 0, 0, 1, 1, 'SNO202017530101287', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(855, 7, 0, 0, 1, 1, 'SNO202017530101288', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(856, 7, 0, 0, 1, 1, 'SNO202017530101289', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(857, 7, 0, 0, 1, 1, 'SNO202017530101290', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(858, 7, 0, 0, 1, 1, 'SNO202017530101291', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(859, 7, 0, 0, 1, 1, 'SNO202017530101292', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(860, 7, 0, 0, 1, 1, 'SNO202017530101293', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(861, 7, 0, 0, 1, 1, 'SNO202017530101294', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(862, 7, 0, 0, 1, 1, 'SNO202017530101295', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(863, 7, 0, 0, 1, 1, 'SNO202017530101296', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(864, 7, 0, 0, 1, 1, 'SNO202017530101297', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(865, 7, 0, 0, 1, 1, 'SNO202017530101298', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(866, 7, 0, 0, 1, 1, 'SNO202017530101299', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(867, 7, 0, 0, 1, 1, 'SNO202017530101300', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(868, 7, 0, 0, 1, 1, 'SNO202017530101301', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(869, 7, 0, 0, 1, 1, 'SNO202017530101302', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(870, 7, 0, 0, 1, 1, 'SNO202017530101303', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(871, 7, 0, 0, 1, 1, 'SNO202017530101304', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(872, 7, 0, 0, 1, 1, 'SNO202017530101305', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(873, 7, 0, 0, 1, 1, 'SNO202017530101306', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(874, 7, 0, 0, 1, 1, 'SNO202017530101307', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(875, 7, 0, 0, 1, 1, 'SNO202017530101308', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(876, 7, 0, 0, 1, 1, 'SNO202017530101309', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(877, 7, 0, 0, 1, 1, 'SNO202017530101310', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(878, 7, 0, 0, 1, 1, 'SNO202017530101311', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(879, 7, 0, 0, 1, 1, 'SNO202017530101312', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(880, 7, 0, 0, 1, 1, 'SNO202017530101313', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(881, 7, 0, 0, 1, 1, 'SNO202017530101314', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(882, 7, 0, 0, 1, 1, 'SNO202017530101315', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(883, 7, 0, 0, 1, 1, 'SNO202017530101316', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(884, 7, 0, 0, 1, 1, 'SNO202017530101317', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(885, 7, 0, 0, 1, 1, 'SNO202017530101318', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(886, 7, 0, 0, 1, 1, 'SNO202017530101319', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(887, 7, 0, 0, 1, 1, 'SNO202017530101320', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(888, 7, 0, 0, 1, 1, 'SNO202017530101321', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(889, 7, 0, 0, 1, 1, 'SNO202017530101322', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(890, 7, 0, 0, 1, 1, 'SNO202017530101323', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(891, 7, 0, 0, 1, 1, 'SNO202017530101324', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(892, 7, 0, 0, 1, 1, 'SNO202017530101325', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(893, 7, 0, 0, 1, 1, 'SNO202017530101326', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(894, 7, 0, 0, 1, 1, 'SNO202017530101327', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(895, 7, 0, 0, 1, 1, 'SNO202017530101328', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(896, 7, 0, 0, 1, 1, 'SNO202017530101329', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(897, 7, 0, 0, 1, 1, 'SNO202017530101330', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(898, 7, 0, 0, 1, 1, 'SNO202017530101331', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(899, 7, 0, 0, 1, 1, 'SNO202017530101332', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(900, 7, 0, 0, 1, 1, 'SNO202017530101333', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(901, 7, 0, 0, 1, 1, 'SNO202017530101334', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(902, 7, 0, 0, 1, 1, 'SNO202017530101335', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(903, 7, 0, 0, 1, 1, 'SNO202017530101336', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(904, 7, 0, 0, 1, 1, 'SNO202017530101337', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(905, 7, 0, 0, 1, 1, 'SNO202017530101338', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(906, 7, 0, 0, 1, 1, 'SNO202017530101339', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(907, 7, 0, 0, 1, 1, 'SNO202017530101340', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(908, 7, 0, 0, 1, 1, 'SNO202017530101341', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(909, 7, 0, 0, 1, 1, 'SNO202017530101342', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(910, 7, 0, 0, 1, 1, 'SNO202017530101343', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(911, 7, 0, 0, 1, 1, 'SNO202017530101344', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(912, 7, 0, 0, 1, 1, 'SNO202017530101345', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(913, 7, 0, 0, 1, 1, 'SNO202017530101346', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(914, 7, 0, 0, 1, 1, 'SNO202017530101347', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(915, 7, 0, 0, 1, 1, 'SNO202017530101348', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(916, 7, 0, 0, 1, 1, 'SNO202017530101349', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(917, 7, 0, 0, 1, 1, 'SNO202017530101350', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(918, 7, 0, 0, 1, 1, 'SNO202017530101351', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(919, 7, 0, 0, 1, 1, 'SNO202017530101352', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(920, 7, 0, 0, 1, 1, 'SNO202017530101353', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(921, 7, 0, 0, 1, 1, 'SNO202017530101354', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(922, 7, 0, 0, 1, 1, 'SNO202017530101355', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(923, 7, 0, 0, 1, 1, 'SNO202017530101356', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(924, 7, 0, 0, 1, 1, 'SNO202017530101357', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(925, 7, 0, 0, 1, 1, 'SNO202017530101358', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(926, 7, 0, 0, 1, 1, 'SNO202017530101359', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(927, 7, 0, 0, 1, 1, 'SNO202017530101360', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(928, 7, 0, 0, 1, 1, 'SNO202017530101361', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(929, 7, 0, 0, 1, 1, 'SNO202017530101362', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(930, 7, 0, 0, 1, 1, 'SNO202017530101363', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(931, 7, 0, 0, 1, 1, 'SNO202017530101364', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(932, 7, 0, 0, 1, 1, 'SNO202017530101365', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(933, 7, 0, 0, 1, 1, 'SNO202017530101366', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(934, 7, 0, 0, 1, 1, 'SNO202017530101367', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(935, 7, 0, 0, 1, 1, 'SNO202017530101368', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(936, 7, 0, 0, 1, 1, 'SNO202017530101369', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(937, 7, 0, 0, 1, 1, 'SNO202017530101370', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(938, 7, 0, 0, 1, 1, 'SNO202017530101371', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(939, 7, 0, 0, 1, 1, 'SNO202017530101372', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(940, 7, 0, 0, 1, 1, 'SNO202017530101373', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(941, 7, 0, 0, 1, 1, 'SNO202017530101374', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(942, 7, 0, 0, 1, 1, 'SNO202017530101375', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(943, 7, 0, 0, 1, 1, 'SNO202017530101376', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(944, 7, 0, 0, 1, 1, 'SNO202017530101377', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(945, 7, 0, 0, 1, 1, 'SNO202017530101378', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(946, 7, 0, 0, 1, 1, 'SNO202017530101379', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(947, 7, 0, 0, 1, 1, 'SNO202017530101380', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(948, 7, 0, 0, 1, 1, 'SNO202017530101381', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(949, 7, 0, 0, 1, 1, 'SNO202017530101382', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(950, 7, 0, 0, 1, 1, 'SNO202017530101383', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(951, 7, 0, 0, 1, 1, 'SNO202017530101384', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(952, 7, 0, 0, 1, 1, 'SNO202017530101385', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(953, 7, 0, 0, 1, 1, 'SNO202017530101386', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(954, 7, 0, 0, 1, 1, 'SNO202017530101387', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(955, 7, 0, 0, 1, 1, 'SNO202017530101388', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(956, 7, 0, 0, 1, 1, 'SNO202017530101389', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(957, 7, 0, 0, 1, 1, 'SNO202017530101390', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(958, 7, 0, 0, 1, 1, 'SNO202017530101391', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(959, 7, 0, 0, 1, 1, 'SNO202017530101392', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(960, 7, 0, 0, 1, 1, 'SNO202017530101393', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(961, 7, 0, 0, 1, 1, 'SNO202017530101394', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(962, 7, 0, 0, 1, 1, 'SNO202017530101395', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(963, 7, 0, 0, 1, 1, 'SNO202017530101396', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(964, 7, 0, 0, 1, 1, 'SNO202017530101397', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(965, 7, 0, 0, 1, 1, 'SNO202017530101398', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(966, 7, 0, 0, 1, 1, 'SNO202017530101399', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(967, 7, 0, 0, 1, 1, 'SNO202017530101400', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(968, 7, 0, 0, 1, 1, 'SNO202017530101401', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(969, 7, 0, 0, 1, 1, 'SNO202017530101402', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(970, 7, 0, 0, 1, 1, 'SNO202017530101403', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(971, 7, 0, 0, 1, 1, 'SNO202017530101404', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(972, 7, 0, 0, 1, 1, 'SNO202017530101405', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(973, 7, 0, 0, 1, 1, 'SNO202017530101406', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(974, 7, 0, 0, 1, 1, 'SNO202017530101407', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(975, 7, 0, 0, 1, 1, 'SNO202017530101408', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(976, 7, 0, 0, 1, 1, 'SNO202017530101409', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(977, 7, 0, 0, 1, 1, 'SNO202017530101410', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(978, 7, 0, 0, 1, 1, 'SNO202017530101411', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(979, 7, 0, 0, 1, 1, 'SNO202017530101412', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(980, 7, 0, 0, 1, 1, 'SNO202017530101413', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(981, 7, 0, 0, 1, 1, 'SNO202017530101414', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(982, 7, 0, 0, 1, 1, 'SNO202017530101415', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(983, 7, 0, 0, 1, 1, 'SNO202017530101416', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(984, 7, 0, 0, 1, 1, 'SNO202017530101417', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(985, 7, 0, 0, 1, 1, 'SNO202017530101418', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(986, 7, 0, 0, 1, 1, 'SNO202017530101419', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(987, 7, 0, 0, 1, 1, 'SNO202017530101420', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(988, 7, 0, 0, 1, 1, 'SNO202017530101421', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(989, 7, 0, 0, 1, 1, 'SNO202017530101422', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(990, 7, 0, 0, 1, 1, 'SNO202017530101423', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(991, 7, 0, 0, 1, 1, 'SNO202017530101424', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(992, 7, 0, 0, 1, 1, 'SNO202017530101425', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(993, 7, 0, 0, 1, 1, 'SNO202017530101426', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(994, 7, 0, 0, 1, 1, 'SNO202017530101427', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(995, 7, 0, 0, 1, 1, 'SNO202017530101428', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(996, 7, 0, 0, 1, 1, 'SNO202017530101429', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(997, 7, 0, 0, 1, 1, 'SNO202017530101430', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(998, 7, 0, 0, 1, 1, 'SNO202017530101431', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(999, 7, 0, 0, 1, 1, 'SNO202017530101432', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1000, 7, 0, 0, 1, 1, 'SNO202017530101433', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1001, 7, 0, 0, 1, 1, 'SNO202017530101434', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1002, 7, 0, 0, 1, 1, 'SNO202017530101435', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1003, 7, 0, 0, 1, 1, 'SNO202017530101436', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1004, 7, 0, 0, 1, 1, 'SNO202017530101437', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1005, 7, 0, 0, 1, 1, 'SNO202017530101438', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1006, 7, 0, 0, 1, 1, 'SNO202017530101439', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1007, 7, 0, 0, 1, 1, 'SNO202017530101440', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1008, 7, 0, 0, 1, 1, 'SNO202017530101441', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1009, 7, 0, 0, 1, 1, 'SNO202017530101442', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1010, 7, 0, 0, 1, 1, 'SNO202017530101443', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1011, 7, 0, 0, 1, 1, 'SNO202017530101444', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1012, 7, 0, 0, 1, 1, 'SNO202017530101445', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1013, 7, 0, 0, 1, 1, 'SNO202017530101446', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1014, 7, 0, 0, 1, 1, 'SNO202017530101447', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1015, 7, 0, 0, 1, 1, 'SNO202017530101448', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1016, 7, 0, 0, 1, 1, 'SNO202017530101449', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1017, 7, 0, 0, 1, 1, 'SNO202017530101450', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1018, 7, 0, 0, 1, 1, 'SNO202017530101451', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1019, 7, 0, 0, 1, 1, 'SNO202017530101452', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1020, 7, 0, 0, 1, 1, 'SNO202017530101453', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1021, 7, 0, 0, 1, 1, 'SNO202017530101454', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1022, 7, 0, 0, 1, 1, 'SNO202017530101455', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1023, 7, 0, 0, 1, 1, 'SNO202017530101456', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1024, 7, 0, 0, 1, 1, 'SNO202017530101457', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1025, 7, 0, 0, 1, 1, 'SNO202017530101458', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1026, 7, 0, 0, 1, 1, 'SNO202017530101459', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1027, 7, 0, 0, 1, 1, 'SNO202017530101460', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1028, 7, 0, 0, 1, 1, 'SNO202017530101461', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1029, 7, 0, 0, 1, 1, 'SNO202017530101462', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1030, 7, 0, 0, 1, 1, 'SNO202017530101463', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1031, 7, 0, 0, 1, 1, 'SNO202017530101464', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1032, 7, 0, 0, 1, 1, 'SNO202017530101465', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1033, 7, 0, 0, 1, 1, 'SNO202017530101466', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1034, 7, 0, 0, 1, 1, 'SNO202017530101467', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1035, 7, 0, 0, 1, 1, 'SNO202017530101468', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1036, 7, 0, 0, 1, 1, 'SNO202017530101469', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1037, 7, 0, 0, 1, 1, 'SNO202017530101470', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1038, 7, 0, 0, 1, 1, 'SNO202017530101471', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1039, 7, 0, 0, 1, 1, 'SNO202017530101472', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1040, 7, 0, 0, 1, 1, 'SNO202017530101473', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1041, 7, 0, 0, 1, 1, 'SNO202017530101474', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1042, 7, 0, 0, 1, 1, 'SNO202017530101475', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1043, 7, 0, 0, 1, 1, 'SNO202017530101476', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1044, 7, 0, 0, 1, 1, 'SNO202017530101477', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1045, 7, 0, 0, 1, 1, 'SNO202017530101478', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1046, 7, 0, 0, 1, 1, 'SNO202017530101479', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1047, 7, 0, 0, 1, 1, 'SNO202017530101480', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1048, 7, 0, 0, 1, 1, 'SNO202017530101481', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1049, 7, 0, 0, 1, 1, 'SNO202017530101482', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1050, 7, 0, 0, 1, 1, 'SNO202017530101483', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1051, 7, 0, 0, 1, 1, 'SNO202017530101484', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1052, 7, 0, 0, 1, 1, 'SNO202017530101485', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1053, 7, 0, 0, 1, 1, 'SNO202017530101486', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1054, 7, 0, 0, 1, 1, 'SNO202017530101487', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1055, 7, 0, 0, 1, 1, 'SNO202017530101488', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1056, 7, 0, 0, 1, 1, 'SNO202017530101489', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1057, 7, 0, 0, 1, 1, 'SNO202017530101490', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1058, 7, 0, 0, 1, 1, 'SNO202017530101491', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1059, 7, 0, 0, 1, 1, 'SNO202017530101492', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1060, 7, 0, 0, 1, 1, 'SNO202017530101493', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1061, 7, 0, 0, 1, 1, 'SNO202017530101494', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1062, 7, 0, 0, 1, 1, 'SNO202017530101495', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1063, 7, 0, 0, 1, 1, 'SNO202017530101496', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1064, 7, 0, 0, 1, 1, 'SNO202017530101497', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1065, 7, 0, 0, 1, 1, 'SNO202017530101498', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1066, 7, 0, 0, 1, 1, 'SNO202017530101499', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1067, 7, 0, 0, 1, 1, 'SNO202017530101500', 23, 0, 0, 0, 1, '2020-01-07 17:30:16', 2),
(1068, 7, 0, 0, 1, 2, 'SNO2020175302521', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1069, 7, 0, 0, 1, 2, 'SNO2020175302522', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1070, 7, 0, 0, 1, 2, 'SNO2020175302523', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1071, 7, 0, 0, 1, 2, 'SNO2020175302524', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1072, 7, 0, 0, 1, 2, 'SNO2020175302525', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1073, 7, 0, 0, 1, 2, 'SNO2020175302526', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1074, 7, 0, 0, 1, 2, 'SNO2020175302527', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1075, 7, 0, 0, 1, 2, 'SNO2020175302528', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1076, 7, 0, 0, 1, 2, 'SNO2020175302529', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1077, 7, 0, 0, 1, 2, 'SNO20201753025210', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1078, 7, 0, 0, 1, 2, 'SNO20201753025211', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1079, 7, 0, 0, 1, 2, 'SNO20201753025212', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1080, 7, 0, 0, 1, 2, 'SNO20201753025213', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1081, 7, 0, 0, 1, 2, 'SNO20201753025214', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1082, 7, 0, 0, 1, 2, 'SNO20201753025215', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1083, 7, 0, 0, 1, 2, 'SNO20201753025216', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1084, 7, 0, 0, 1, 2, 'SNO20201753025217', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1085, 7, 0, 0, 1, 2, 'SNO20201753025218', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1086, 7, 0, 0, 1, 2, 'SNO20201753025219', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1087, 7, 0, 0, 1, 2, 'SNO20201753025220', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1088, 7, 0, 0, 1, 2, 'SNO20201753025221', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1089, 7, 0, 0, 1, 2, 'SNO20201753025222', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1090, 7, 0, 0, 1, 2, 'SNO20201753025223', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1091, 7, 0, 0, 1, 2, 'SNO20201753025224', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1092, 7, 0, 0, 1, 2, 'SNO20201753025225', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1093, 7, 0, 0, 1, 2, 'SNO20201753025226', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1094, 7, 0, 0, 1, 2, 'SNO20201753025227', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1095, 7, 0, 0, 1, 2, 'SNO20201753025228', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1096, 7, 0, 0, 1, 2, 'SNO20201753025229', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1097, 7, 0, 0, 1, 2, 'SNO20201753025230', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1098, 7, 0, 0, 1, 2, 'SNO20201753025231', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1099, 7, 0, 0, 1, 2, 'SNO20201753025232', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1100, 7, 0, 0, 1, 2, 'SNO20201753025233', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1101, 7, 0, 0, 1, 2, 'SNO20201753025234', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1102, 7, 0, 0, 1, 2, 'SNO20201753025235', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1103, 7, 0, 0, 1, 2, 'SNO20201753025236', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1104, 7, 0, 0, 1, 2, 'SNO20201753025237', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1105, 7, 0, 0, 1, 2, 'SNO20201753025238', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1106, 7, 0, 0, 1, 2, 'SNO20201753025239', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1107, 7, 0, 0, 1, 2, 'SNO20201753025240', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1108, 7, 0, 0, 1, 2, 'SNO20201753025241', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1109, 7, 0, 0, 1, 2, 'SNO20201753025242', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1110, 7, 0, 0, 1, 2, 'SNO20201753025243', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1111, 7, 0, 0, 1, 2, 'SNO20201753025244', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1112, 7, 0, 0, 1, 2, 'SNO20201753025245', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1113, 7, 0, 0, 1, 2, 'SNO20201753025246', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1114, 7, 0, 0, 1, 2, 'SNO20201753025247', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1115, 7, 0, 0, 1, 2, 'SNO20201753025248', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1116, 7, 0, 0, 1, 2, 'SNO20201753025249', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1117, 7, 0, 0, 1, 2, 'SNO20201753025250', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1118, 7, 0, 0, 1, 2, 'SNO20201753025251', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1119, 7, 0, 0, 1, 2, 'SNO20201753025252', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1120, 7, 0, 0, 1, 2, 'SNO20201753025253', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1121, 7, 0, 0, 1, 2, 'SNO20201753025254', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1122, 7, 0, 0, 1, 2, 'SNO20201753025255', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1123, 7, 0, 0, 1, 2, 'SNO20201753025256', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1124, 7, 0, 0, 1, 2, 'SNO20201753025257', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1125, 7, 0, 0, 1, 2, 'SNO20201753025258', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1126, 7, 0, 0, 1, 2, 'SNO20201753025259', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1127, 7, 0, 0, 1, 2, 'SNO20201753025260', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1128, 7, 0, 0, 1, 2, 'SNO20201753025261', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1129, 7, 0, 0, 1, 2, 'SNO20201753025262', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1130, 7, 0, 0, 1, 2, 'SNO20201753025263', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1131, 7, 0, 0, 1, 2, 'SNO20201753025264', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1132, 7, 0, 0, 1, 2, 'SNO20201753025265', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1133, 7, 0, 0, 1, 2, 'SNO20201753025266', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1134, 7, 0, 0, 1, 2, 'SNO20201753025267', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1135, 7, 0, 0, 1, 2, 'SNO20201753025268', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1136, 7, 0, 0, 1, 2, 'SNO20201753025269', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1137, 7, 0, 0, 1, 2, 'SNO20201753025270', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1138, 7, 0, 0, 1, 2, 'SNO20201753025271', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1139, 7, 0, 0, 1, 2, 'SNO20201753025272', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1140, 7, 0, 0, 1, 2, 'SNO20201753025273', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1141, 7, 0, 0, 1, 2, 'SNO20201753025274', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1142, 7, 0, 0, 1, 2, 'SNO20201753025275', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1143, 7, 0, 0, 1, 2, 'SNO20201753025276', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1144, 7, 0, 0, 1, 2, 'SNO20201753025277', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1145, 7, 0, 0, 1, 2, 'SNO20201753025278', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1146, 7, 0, 0, 1, 2, 'SNO20201753025279', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1147, 7, 0, 0, 1, 2, 'SNO20201753025280', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1148, 7, 0, 0, 1, 2, 'SNO20201753025281', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1149, 7, 0, 0, 1, 2, 'SNO20201753025282', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1150, 7, 0, 0, 1, 2, 'SNO20201753025283', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1151, 7, 0, 0, 1, 2, 'SNO20201753025284', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1152, 7, 0, 0, 1, 2, 'SNO20201753025285', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1153, 7, 0, 0, 1, 2, 'SNO20201753025286', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1154, 7, 0, 0, 1, 2, 'SNO20201753025287', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1155, 7, 0, 0, 1, 2, 'SNO20201753025288', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1156, 7, 0, 0, 1, 2, 'SNO20201753025289', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1157, 7, 0, 0, 1, 2, 'SNO20201753025290', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1158, 7, 0, 0, 1, 2, 'SNO20201753025291', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1159, 7, 0, 0, 1, 2, 'SNO20201753025292', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1160, 7, 0, 0, 1, 2, 'SNO20201753025293', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1161, 7, 0, 0, 1, 2, 'SNO20201753025294', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1162, 7, 0, 0, 1, 2, 'SNO20201753025295', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1163, 7, 0, 0, 1, 2, 'SNO20201753025296', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1164, 7, 0, 0, 1, 2, 'SNO20201753025297', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1165, 7, 0, 0, 1, 2, 'SNO20201753025298', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1166, 7, 0, 0, 1, 2, 'SNO20201753025299', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1167, 7, 0, 0, 1, 2, 'SNO202017530252100', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1168, 7, 0, 0, 1, 2, 'SNO202017530252101', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1169, 7, 0, 0, 1, 2, 'SNO202017530252102', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1170, 7, 0, 0, 1, 2, 'SNO202017530252103', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1171, 7, 0, 0, 1, 2, 'SNO202017530252104', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1172, 7, 0, 0, 1, 2, 'SNO202017530252105', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1173, 7, 0, 0, 1, 2, 'SNO202017530252106', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1174, 7, 0, 0, 1, 2, 'SNO202017530252107', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1175, 7, 0, 0, 1, 2, 'SNO202017530252108', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1176, 7, 0, 0, 1, 2, 'SNO202017530252109', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1177, 7, 0, 0, 1, 2, 'SNO202017530252110', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1178, 7, 0, 0, 1, 2, 'SNO202017530252111', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1179, 7, 0, 0, 1, 2, 'SNO202017530252112', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1180, 7, 0, 0, 1, 2, 'SNO202017530252113', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1181, 7, 0, 0, 1, 2, 'SNO202017530252114', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1182, 7, 0, 0, 1, 2, 'SNO202017530252115', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1183, 7, 0, 0, 1, 2, 'SNO202017530252116', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1184, 7, 0, 0, 1, 2, 'SNO202017530252117', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1185, 7, 0, 0, 1, 2, 'SNO202017530252118', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1186, 7, 0, 0, 1, 2, 'SNO202017530252119', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1187, 7, 0, 0, 1, 2, 'SNO202017530252120', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1188, 7, 0, 0, 1, 2, 'SNO202017530252121', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1189, 7, 0, 0, 1, 2, 'SNO202017530252122', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1190, 7, 0, 0, 1, 2, 'SNO202017530252123', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1191, 7, 0, 0, 1, 2, 'SNO202017530252124', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1192, 7, 0, 0, 1, 2, 'SNO202017530252125', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1193, 7, 0, 0, 1, 2, 'SNO202017530252126', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1194, 7, 0, 0, 1, 2, 'SNO202017530252127', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1195, 7, 0, 0, 1, 2, 'SNO202017530252128', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1196, 7, 0, 0, 1, 2, 'SNO202017530252129', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1197, 7, 0, 0, 1, 2, 'SNO202017530252130', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1198, 7, 0, 0, 1, 2, 'SNO202017530252131', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1);
INSERT INTO `product_stock_serialno` (`idProductserialno`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProductsize`, `serialno`, `idWhStockItem`, `idOrderallocateditems`, `idOrder`, `offer_flog`, `created_by`, `created_at`, `status`) VALUES
(1199, 7, 0, 0, 1, 2, 'SNO202017530252132', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1200, 7, 0, 0, 1, 2, 'SNO202017530252133', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1201, 7, 0, 0, 1, 2, 'SNO202017530252134', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1202, 7, 0, 0, 1, 2, 'SNO202017530252135', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1203, 7, 0, 0, 1, 2, 'SNO202017530252136', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1204, 7, 0, 0, 1, 2, 'SNO202017530252137', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1205, 7, 0, 0, 1, 2, 'SNO202017530252138', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1206, 7, 0, 0, 1, 2, 'SNO202017530252139', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1207, 7, 0, 0, 1, 2, 'SNO202017530252140', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1208, 7, 0, 0, 1, 2, 'SNO202017530252141', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1209, 7, 0, 0, 1, 2, 'SNO202017530252142', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1210, 7, 0, 0, 1, 2, 'SNO202017530252143', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1211, 7, 0, 0, 1, 2, 'SNO202017530252144', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1212, 7, 0, 0, 1, 2, 'SNO202017530252145', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1213, 7, 0, 0, 1, 2, 'SNO202017530252146', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1214, 7, 0, 0, 1, 2, 'SNO202017530252147', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1215, 7, 0, 0, 1, 2, 'SNO202017530252148', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1216, 7, 0, 0, 1, 2, 'SNO202017530252149', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1217, 7, 0, 0, 1, 2, 'SNO202017530252150', 27, 12, 5, 0, 1, '2020-01-07 17:30:32', 1),
(1218, 7, 0, 0, 1, 2, 'SNO202017530252151', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1219, 7, 0, 0, 1, 2, 'SNO202017530252152', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1220, 7, 0, 0, 1, 2, 'SNO202017530252153', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1221, 7, 0, 0, 1, 2, 'SNO202017530252154', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1222, 7, 0, 0, 1, 2, 'SNO202017530252155', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1223, 7, 0, 0, 1, 2, 'SNO202017530252156', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1224, 7, 0, 0, 1, 2, 'SNO202017530252157', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1225, 7, 0, 0, 1, 2, 'SNO202017530252158', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1226, 7, 0, 0, 1, 2, 'SNO202017530252159', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1227, 7, 0, 0, 1, 2, 'SNO202017530252160', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1228, 7, 0, 0, 1, 2, 'SNO202017530252161', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1229, 7, 0, 0, 1, 2, 'SNO202017530252162', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1230, 7, 0, 0, 1, 2, 'SNO202017530252163', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1231, 7, 0, 0, 1, 2, 'SNO202017530252164', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1232, 7, 0, 0, 1, 2, 'SNO202017530252165', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1233, 7, 0, 0, 1, 2, 'SNO202017530252166', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1234, 7, 0, 0, 1, 2, 'SNO202017530252167', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1235, 7, 0, 0, 1, 2, 'SNO202017530252168', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1236, 7, 0, 0, 1, 2, 'SNO202017530252169', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1237, 7, 0, 0, 1, 2, 'SNO202017530252170', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1238, 7, 0, 0, 1, 2, 'SNO202017530252171', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1239, 7, 0, 0, 1, 2, 'SNO202017530252172', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1240, 7, 0, 0, 1, 2, 'SNO202017530252173', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1241, 7, 0, 0, 1, 2, 'SNO202017530252174', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1242, 7, 0, 0, 1, 2, 'SNO202017530252175', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1243, 7, 0, 0, 1, 2, 'SNO202017530252176', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1244, 7, 0, 0, 1, 2, 'SNO202017530252177', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1245, 7, 0, 0, 1, 2, 'SNO202017530252178', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1246, 7, 0, 0, 1, 2, 'SNO202017530252179', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1247, 7, 0, 0, 1, 2, 'SNO202017530252180', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1248, 7, 0, 0, 1, 2, 'SNO202017530252181', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1249, 7, 0, 0, 1, 2, 'SNO202017530252182', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1250, 7, 0, 0, 1, 2, 'SNO202017530252183', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1251, 7, 0, 0, 1, 2, 'SNO202017530252184', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1252, 7, 0, 0, 1, 2, 'SNO202017530252185', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1253, 7, 0, 0, 1, 2, 'SNO202017530252186', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1254, 7, 0, 0, 1, 2, 'SNO202017530252187', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1255, 7, 0, 0, 1, 2, 'SNO202017530252188', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1256, 7, 0, 0, 1, 2, 'SNO202017530252189', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1257, 7, 0, 0, 1, 2, 'SNO202017530252190', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1258, 7, 0, 0, 1, 2, 'SNO202017530252191', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1259, 7, 0, 0, 1, 2, 'SNO202017530252192', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1260, 7, 0, 0, 1, 2, 'SNO202017530252193', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1261, 7, 0, 0, 1, 2, 'SNO202017530252194', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1262, 7, 0, 0, 1, 2, 'SNO202017530252195', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1263, 7, 0, 0, 1, 2, 'SNO202017530252196', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1264, 7, 0, 0, 1, 2, 'SNO202017530252197', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1265, 7, 0, 0, 1, 2, 'SNO202017530252198', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1266, 7, 0, 0, 1, 2, 'SNO202017530252199', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1267, 7, 0, 0, 1, 2, 'SNO202017530252200', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1268, 7, 0, 0, 1, 2, 'SNO202017530252201', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1269, 7, 0, 0, 1, 2, 'SNO202017530252202', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1270, 7, 0, 0, 1, 2, 'SNO202017530252203', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1271, 7, 0, 0, 1, 2, 'SNO202017530252204', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1272, 7, 0, 0, 1, 2, 'SNO202017530252205', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1273, 7, 0, 0, 1, 2, 'SNO202017530252206', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1274, 7, 0, 0, 1, 2, 'SNO202017530252207', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1275, 7, 0, 0, 1, 2, 'SNO202017530252208', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1276, 7, 0, 0, 1, 2, 'SNO202017530252209', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1277, 7, 0, 0, 1, 2, 'SNO202017530252210', 27, 14, 12, 0, 1, '2020-01-07 17:30:32', 1),
(1278, 7, 0, 0, 1, 2, 'SNO202017530252211', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1279, 7, 0, 0, 1, 2, 'SNO202017530252212', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1280, 7, 0, 0, 1, 2, 'SNO202017530252213', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1281, 7, 0, 0, 1, 2, 'SNO202017530252214', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1282, 7, 0, 0, 1, 2, 'SNO202017530252215', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1283, 7, 0, 0, 1, 2, 'SNO202017530252216', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1284, 7, 0, 0, 1, 2, 'SNO202017530252217', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1285, 7, 0, 0, 1, 2, 'SNO202017530252218', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1286, 7, 0, 0, 1, 2, 'SNO202017530252219', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1287, 7, 0, 0, 1, 2, 'SNO202017530252220', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1288, 7, 0, 0, 1, 2, 'SNO202017530252221', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1289, 7, 0, 0, 1, 2, 'SNO202017530252222', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1290, 7, 0, 0, 1, 2, 'SNO202017530252223', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1291, 7, 0, 0, 1, 2, 'SNO202017530252224', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1292, 7, 0, 0, 1, 2, 'SNO202017530252225', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1293, 7, 0, 0, 1, 2, 'SNO202017530252226', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1294, 7, 0, 0, 1, 2, 'SNO202017530252227', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1295, 7, 0, 0, 1, 2, 'SNO202017530252228', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1296, 7, 0, 0, 1, 2, 'SNO202017530252229', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1297, 7, 0, 0, 1, 2, 'SNO202017530252230', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1298, 7, 0, 0, 1, 2, 'SNO202017530252231', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1299, 7, 0, 0, 1, 2, 'SNO202017530252232', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1300, 7, 0, 0, 1, 2, 'SNO202017530252233', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1301, 7, 0, 0, 1, 2, 'SNO202017530252234', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1302, 7, 0, 0, 1, 2, 'SNO202017530252235', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1303, 7, 0, 0, 1, 2, 'SNO202017530252236', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1304, 7, 0, 0, 1, 2, 'SNO202017530252237', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1305, 7, 0, 0, 1, 2, 'SNO202017530252238', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1306, 7, 0, 0, 1, 2, 'SNO202017530252239', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1307, 7, 0, 0, 1, 2, 'SNO202017530252240', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1308, 7, 0, 0, 1, 2, 'SNO202017530252241', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1309, 7, 0, 0, 1, 2, 'SNO202017530252242', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1310, 7, 0, 0, 1, 2, 'SNO202017530252243', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1311, 7, 0, 0, 1, 2, 'SNO202017530252244', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1312, 7, 0, 0, 1, 2, 'SNO202017530252245', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1313, 7, 0, 0, 1, 2, 'SNO202017530252246', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1314, 7, 0, 0, 1, 2, 'SNO202017530252247', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1315, 7, 0, 0, 1, 2, 'SNO202017530252248', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1316, 7, 0, 0, 1, 2, 'SNO202017530252249', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1317, 7, 0, 0, 1, 2, 'SNO202017530252250', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1318, 7, 0, 0, 1, 2, 'SNO202017530252251', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1319, 7, 0, 0, 1, 2, 'SNO202017530252252', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1320, 7, 0, 0, 1, 2, 'SNO202017530252253', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1321, 7, 0, 0, 1, 2, 'SNO202017530252254', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1322, 7, 0, 0, 1, 2, 'SNO202017530252255', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1323, 7, 0, 0, 1, 2, 'SNO202017530252256', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1324, 7, 0, 0, 1, 2, 'SNO202017530252257', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1325, 7, 0, 0, 1, 2, 'SNO202017530252258', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1326, 7, 0, 0, 1, 2, 'SNO202017530252259', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1327, 7, 0, 0, 1, 2, 'SNO202017530252260', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1328, 7, 0, 0, 1, 2, 'SNO202017530252261', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1329, 7, 0, 0, 1, 2, 'SNO202017530252262', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1330, 7, 0, 0, 1, 2, 'SNO202017530252263', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1331, 7, 0, 0, 1, 2, 'SNO202017530252264', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1332, 7, 0, 0, 1, 2, 'SNO202017530252265', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1333, 7, 0, 0, 1, 2, 'SNO202017530252266', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1334, 7, 0, 0, 1, 2, 'SNO202017530252267', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1335, 7, 0, 0, 1, 2, 'SNO202017530252268', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1336, 7, 0, 0, 1, 2, 'SNO202017530252269', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1337, 7, 0, 0, 1, 2, 'SNO202017530252270', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1338, 7, 0, 0, 1, 2, 'SNO202017530252271', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1339, 7, 0, 0, 1, 2, 'SNO202017530252272', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1340, 7, 0, 0, 1, 2, 'SNO202017530252273', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1341, 7, 0, 0, 1, 2, 'SNO202017530252274', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1342, 7, 0, 0, 1, 2, 'SNO202017530252275', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1343, 7, 0, 0, 1, 2, 'SNO202017530252276', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1344, 7, 0, 0, 1, 2, 'SNO202017530252277', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1345, 7, 0, 0, 1, 2, 'SNO202017530252278', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1346, 7, 0, 0, 1, 2, 'SNO202017530252279', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1347, 7, 0, 0, 1, 2, 'SNO202017530252280', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1348, 7, 0, 0, 1, 2, 'SNO202017530252281', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1349, 7, 0, 0, 1, 2, 'SNO202017530252282', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1350, 7, 0, 0, 1, 2, 'SNO202017530252283', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1351, 7, 0, 0, 1, 2, 'SNO202017530252284', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1352, 7, 0, 0, 1, 2, 'SNO202017530252285', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1353, 7, 0, 0, 1, 2, 'SNO202017530252286', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1354, 7, 0, 0, 1, 2, 'SNO202017530252287', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1355, 7, 0, 0, 1, 2, 'SNO202017530252288', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1356, 7, 0, 0, 1, 2, 'SNO202017530252289', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1357, 7, 0, 0, 1, 2, 'SNO202017530252290', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1358, 7, 0, 0, 1, 2, 'SNO202017530252291', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1359, 7, 0, 0, 1, 2, 'SNO202017530252292', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1360, 7, 0, 0, 1, 2, 'SNO202017530252293', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1361, 7, 0, 0, 1, 2, 'SNO202017530252294', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1362, 7, 0, 0, 1, 2, 'SNO202017530252295', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1363, 7, 0, 0, 1, 2, 'SNO202017530252296', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1364, 7, 0, 0, 1, 2, 'SNO202017530252297', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1365, 7, 0, 0, 1, 2, 'SNO202017530252298', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1366, 7, 0, 0, 1, 2, 'SNO202017530252299', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1367, 7, 0, 0, 1, 2, 'SNO202017530252300', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1368, 7, 0, 0, 1, 2, 'SNO202017530252301', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1369, 7, 0, 0, 1, 2, 'SNO202017530252302', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1370, 7, 0, 0, 1, 2, 'SNO202017530252303', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1371, 7, 0, 0, 1, 2, 'SNO202017530252304', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1372, 7, 0, 0, 1, 2, 'SNO202017530252305', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1373, 7, 0, 0, 1, 2, 'SNO202017530252306', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1374, 7, 0, 0, 1, 2, 'SNO202017530252307', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1375, 7, 0, 0, 1, 2, 'SNO202017530252308', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1376, 7, 0, 0, 1, 2, 'SNO202017530252309', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1377, 7, 0, 0, 1, 2, 'SNO202017530252310', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1378, 7, 0, 0, 1, 2, 'SNO202017530252311', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1379, 7, 0, 0, 1, 2, 'SNO202017530252312', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1380, 7, 0, 0, 1, 2, 'SNO202017530252313', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1381, 7, 0, 0, 1, 2, 'SNO202017530252314', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1382, 7, 0, 0, 1, 2, 'SNO202017530252315', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1383, 7, 0, 0, 1, 2, 'SNO202017530252316', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1384, 7, 0, 0, 1, 2, 'SNO202017530252317', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1385, 7, 0, 0, 1, 2, 'SNO202017530252318', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1386, 7, 0, 0, 1, 2, 'SNO202017530252319', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1387, 7, 0, 0, 1, 2, 'SNO202017530252320', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1388, 7, 0, 0, 1, 2, 'SNO202017530252321', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1389, 7, 0, 0, 1, 2, 'SNO202017530252322', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1390, 7, 0, 0, 1, 2, 'SNO202017530252323', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1391, 7, 0, 0, 1, 2, 'SNO202017530252324', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1392, 7, 0, 0, 1, 2, 'SNO202017530252325', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1393, 7, 0, 0, 1, 2, 'SNO202017530252326', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1394, 7, 0, 0, 1, 2, 'SNO202017530252327', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1395, 7, 0, 0, 1, 2, 'SNO202017530252328', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1396, 7, 0, 0, 1, 2, 'SNO202017530252329', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1397, 7, 0, 0, 1, 2, 'SNO202017530252330', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1398, 7, 0, 0, 1, 2, 'SNO202017530252331', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1399, 7, 0, 0, 1, 2, 'SNO202017530252332', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1400, 7, 0, 0, 1, 2, 'SNO202017530252333', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1401, 7, 0, 0, 1, 2, 'SNO202017530252334', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1402, 7, 0, 0, 1, 2, 'SNO202017530252335', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1403, 7, 0, 0, 1, 2, 'SNO202017530252336', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1404, 7, 0, 0, 1, 2, 'SNO202017530252337', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1405, 7, 0, 0, 1, 2, 'SNO202017530252338', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1406, 7, 0, 0, 1, 2, 'SNO202017530252339', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1407, 7, 0, 0, 1, 2, 'SNO202017530252340', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1408, 7, 0, 0, 1, 2, 'SNO202017530252341', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1409, 7, 0, 0, 1, 2, 'SNO202017530252342', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1410, 7, 0, 0, 1, 2, 'SNO202017530252343', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1411, 7, 0, 0, 1, 2, 'SNO202017530252344', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1412, 7, 0, 0, 1, 2, 'SNO202017530252345', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1413, 7, 0, 0, 1, 2, 'SNO202017530252346', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1414, 7, 0, 0, 1, 2, 'SNO202017530252347', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1415, 7, 0, 0, 1, 2, 'SNO202017530252348', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1416, 7, 0, 0, 1, 2, 'SNO202017530252349', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1417, 7, 0, 0, 1, 2, 'SNO202017530252350', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1418, 7, 0, 0, 1, 2, 'SNO202017530252351', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1419, 7, 0, 0, 1, 2, 'SNO202017530252352', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1420, 7, 0, 0, 1, 2, 'SNO202017530252353', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1421, 7, 0, 0, 1, 2, 'SNO202017530252354', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1422, 7, 0, 0, 1, 2, 'SNO202017530252355', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1423, 7, 0, 0, 1, 2, 'SNO202017530252356', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1424, 7, 0, 0, 1, 2, 'SNO202017530252357', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1425, 7, 0, 0, 1, 2, 'SNO202017530252358', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1426, 7, 0, 0, 1, 2, 'SNO202017530252359', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1427, 7, 0, 0, 1, 2, 'SNO202017530252360', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1428, 7, 0, 0, 1, 2, 'SNO202017530252361', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1429, 7, 0, 0, 1, 2, 'SNO202017530252362', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1430, 7, 0, 0, 1, 2, 'SNO202017530252363', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1431, 7, 0, 0, 1, 2, 'SNO202017530252364', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1432, 7, 0, 0, 1, 2, 'SNO202017530252365', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1433, 7, 0, 0, 1, 2, 'SNO202017530252366', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1434, 7, 0, 0, 1, 2, 'SNO202017530252367', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1435, 7, 0, 0, 1, 2, 'SNO202017530252368', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1436, 7, 0, 0, 1, 2, 'SNO202017530252369', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1437, 7, 0, 0, 1, 2, 'SNO202017530252370', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1438, 7, 0, 0, 1, 2, 'SNO202017530252371', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1439, 7, 0, 0, 1, 2, 'SNO202017530252372', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1440, 7, 0, 0, 1, 2, 'SNO202017530252373', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1441, 7, 0, 0, 1, 2, 'SNO202017530252374', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1442, 7, 0, 0, 1, 2, 'SNO202017530252375', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1443, 7, 0, 0, 1, 2, 'SNO202017530252376', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1444, 7, 0, 0, 1, 2, 'SNO202017530252377', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1445, 7, 0, 0, 1, 2, 'SNO202017530252378', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1446, 7, 0, 0, 1, 2, 'SNO202017530252379', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1447, 7, 0, 0, 1, 2, 'SNO202017530252380', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1448, 7, 0, 0, 1, 2, 'SNO202017530252381', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1449, 7, 0, 0, 1, 2, 'SNO202017530252382', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1450, 7, 0, 0, 1, 2, 'SNO202017530252383', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1451, 7, 0, 0, 1, 2, 'SNO202017530252384', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1452, 7, 0, 0, 1, 2, 'SNO202017530252385', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1453, 7, 0, 0, 1, 2, 'SNO202017530252386', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1454, 7, 0, 0, 1, 2, 'SNO202017530252387', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1455, 7, 0, 0, 1, 2, 'SNO202017530252388', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1456, 7, 0, 0, 1, 2, 'SNO202017530252389', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1457, 7, 0, 0, 1, 2, 'SNO202017530252390', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1458, 7, 0, 0, 1, 2, 'SNO202017530252391', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1459, 7, 0, 0, 1, 2, 'SNO202017530252392', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1460, 7, 0, 0, 1, 2, 'SNO202017530252393', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1461, 7, 0, 0, 1, 2, 'SNO202017530252394', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1462, 7, 0, 0, 1, 2, 'SNO202017530252395', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1463, 7, 0, 0, 1, 2, 'SNO202017530252396', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1464, 7, 0, 0, 1, 2, 'SNO202017530252397', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1465, 7, 0, 0, 1, 2, 'SNO202017530252398', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1466, 7, 0, 0, 1, 2, 'SNO202017530252399', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1467, 7, 0, 0, 1, 2, 'SNO202017530252400', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1468, 7, 0, 0, 1, 2, 'SNO202017530252401', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1469, 7, 0, 0, 1, 2, 'SNO202017530252402', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1470, 7, 0, 0, 1, 2, 'SNO202017530252403', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1471, 7, 0, 0, 1, 2, 'SNO202017530252404', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1472, 7, 0, 0, 1, 2, 'SNO202017530252405', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1473, 7, 0, 0, 1, 2, 'SNO202017530252406', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1474, 7, 0, 0, 1, 2, 'SNO202017530252407', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1475, 7, 0, 0, 1, 2, 'SNO202017530252408', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1476, 7, 0, 0, 1, 2, 'SNO202017530252409', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1477, 7, 0, 0, 1, 2, 'SNO202017530252410', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1478, 7, 0, 0, 1, 2, 'SNO202017530252411', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1479, 7, 0, 0, 1, 2, 'SNO202017530252412', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1480, 7, 0, 0, 1, 2, 'SNO202017530252413', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1481, 7, 0, 0, 1, 2, 'SNO202017530252414', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1482, 7, 0, 0, 1, 2, 'SNO202017530252415', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1483, 7, 0, 0, 1, 2, 'SNO202017530252416', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1484, 7, 0, 0, 1, 2, 'SNO202017530252417', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1485, 7, 0, 0, 1, 2, 'SNO202017530252418', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1486, 7, 0, 0, 1, 2, 'SNO202017530252419', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1487, 7, 0, 0, 1, 2, 'SNO202017530252420', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1488, 7, 0, 0, 1, 2, 'SNO202017530252421', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1489, 7, 0, 0, 1, 2, 'SNO202017530252422', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1490, 7, 0, 0, 1, 2, 'SNO202017530252423', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1491, 7, 0, 0, 1, 2, 'SNO202017530252424', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1492, 7, 0, 0, 1, 2, 'SNO202017530252425', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1493, 7, 0, 0, 1, 2, 'SNO202017530252426', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1494, 7, 0, 0, 1, 2, 'SNO202017530252427', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1495, 7, 0, 0, 1, 2, 'SNO202017530252428', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1496, 7, 0, 0, 1, 2, 'SNO202017530252429', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1497, 7, 0, 0, 1, 2, 'SNO202017530252430', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1498, 7, 0, 0, 1, 2, 'SNO202017530252431', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1499, 7, 0, 0, 1, 2, 'SNO202017530252432', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1500, 7, 0, 0, 1, 2, 'SNO202017530252433', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1501, 7, 0, 0, 1, 2, 'SNO202017530252434', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1502, 7, 0, 0, 1, 2, 'SNO202017530252435', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1503, 7, 0, 0, 1, 2, 'SNO202017530252436', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1504, 7, 0, 0, 1, 2, 'SNO202017530252437', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1505, 7, 0, 0, 1, 2, 'SNO202017530252438', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1506, 7, 0, 0, 1, 2, 'SNO202017530252439', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1507, 7, 0, 0, 1, 2, 'SNO202017530252440', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1508, 7, 0, 0, 1, 2, 'SNO202017530252441', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1509, 7, 0, 0, 1, 2, 'SNO202017530252442', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1510, 7, 0, 0, 1, 2, 'SNO202017530252443', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1511, 7, 0, 0, 1, 2, 'SNO202017530252444', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1512, 7, 0, 0, 1, 2, 'SNO202017530252445', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1513, 7, 0, 0, 1, 2, 'SNO202017530252446', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1514, 7, 0, 0, 1, 2, 'SNO202017530252447', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1515, 7, 0, 0, 1, 2, 'SNO202017530252448', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1516, 7, 0, 0, 1, 2, 'SNO202017530252449', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1517, 7, 0, 0, 1, 2, 'SNO202017530252450', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1518, 7, 0, 0, 1, 2, 'SNO202017530252451', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1519, 7, 0, 0, 1, 2, 'SNO202017530252452', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1520, 7, 0, 0, 1, 2, 'SNO202017530252453', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1521, 7, 0, 0, 1, 2, 'SNO202017530252454', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1522, 7, 0, 0, 1, 2, 'SNO202017530252455', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1523, 7, 0, 0, 1, 2, 'SNO202017530252456', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1524, 7, 0, 0, 1, 2, 'SNO202017530252457', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1525, 7, 0, 0, 1, 2, 'SNO202017530252458', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1526, 7, 0, 0, 1, 2, 'SNO202017530252459', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1527, 7, 0, 0, 1, 2, 'SNO202017530252460', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1528, 7, 0, 0, 1, 2, 'SNO202017530252461', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1529, 7, 0, 0, 1, 2, 'SNO202017530252462', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1530, 7, 0, 0, 1, 2, 'SNO202017530252463', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1531, 7, 0, 0, 1, 2, 'SNO202017530252464', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1532, 7, 0, 0, 1, 2, 'SNO202017530252465', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1533, 7, 0, 0, 1, 2, 'SNO202017530252466', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1534, 7, 0, 0, 1, 2, 'SNO202017530252467', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1535, 7, 0, 0, 1, 2, 'SNO202017530252468', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1536, 7, 0, 0, 1, 2, 'SNO202017530252469', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1537, 7, 0, 0, 1, 2, 'SNO202017530252470', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1538, 7, 0, 0, 1, 2, 'SNO202017530252471', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1539, 7, 0, 0, 1, 2, 'SNO202017530252472', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1540, 7, 0, 0, 1, 2, 'SNO202017530252473', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1541, 7, 0, 0, 1, 2, 'SNO202017530252474', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1542, 7, 0, 0, 1, 2, 'SNO202017530252475', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1543, 7, 0, 0, 1, 2, 'SNO202017530252476', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1544, 7, 0, 0, 1, 2, 'SNO202017530252477', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1545, 7, 0, 0, 1, 2, 'SNO202017530252478', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1546, 7, 0, 0, 1, 2, 'SNO202017530252479', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1547, 7, 0, 0, 1, 2, 'SNO202017530252480', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1548, 7, 0, 0, 1, 2, 'SNO202017530252481', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1549, 7, 0, 0, 1, 2, 'SNO202017530252482', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1550, 7, 0, 0, 1, 2, 'SNO202017530252483', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1551, 7, 0, 0, 1, 2, 'SNO202017530252484', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1552, 7, 0, 0, 1, 2, 'SNO202017530252485', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1553, 7, 0, 0, 1, 2, 'SNO202017530252486', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1554, 7, 0, 0, 1, 2, 'SNO202017530252487', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1555, 7, 0, 0, 1, 2, 'SNO202017530252488', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1556, 7, 0, 0, 1, 2, 'SNO202017530252489', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1557, 7, 0, 0, 1, 2, 'SNO202017530252490', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1558, 7, 0, 0, 1, 2, 'SNO202017530252491', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1559, 7, 0, 0, 1, 2, 'SNO202017530252492', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1560, 7, 0, 0, 1, 2, 'SNO202017530252493', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1561, 7, 0, 0, 1, 2, 'SNO202017530252494', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1562, 7, 0, 0, 1, 2, 'SNO202017530252495', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1563, 7, 0, 0, 1, 2, 'SNO202017530252496', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1564, 7, 0, 0, 1, 2, 'SNO202017530252497', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1565, 7, 0, 0, 1, 2, 'SNO202017530252498', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1566, 7, 0, 0, 1, 2, 'SNO202017530252499', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1567, 7, 0, 0, 1, 2, 'SNO202017530252500', 27, 0, 0, 0, 1, '2020-01-07 17:30:32', 2),
(1568, 7, 0, 0, 4, 8, '2020175304281', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1569, 7, 0, 0, 4, 8, '2020175304282', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1570, 7, 0, 0, 4, 8, '2020175304283', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1571, 7, 0, 0, 4, 8, '2020175304284', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1572, 7, 0, 0, 4, 8, '2020175304285', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1573, 7, 0, 0, 4, 8, '2020175304286', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1574, 7, 0, 0, 4, 8, '2020175304287', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1575, 7, 0, 0, 4, 8, '2020175304288', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1576, 7, 0, 0, 4, 8, '2020175304289', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1577, 7, 0, 0, 4, 8, '20201753042810', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1578, 7, 0, 0, 4, 8, '20201753042811', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1579, 7, 0, 0, 4, 8, '20201753042812', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1580, 7, 0, 0, 4, 8, '20201753042813', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1581, 7, 0, 0, 4, 8, '20201753042814', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1582, 7, 0, 0, 4, 8, '20201753042815', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1583, 7, 0, 0, 4, 8, '20201753042816', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1584, 7, 0, 0, 4, 8, '20201753042817', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1585, 7, 0, 0, 4, 8, '20201753042818', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1586, 7, 0, 0, 4, 8, '20201753042819', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1587, 7, 0, 0, 4, 8, '20201753042820', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1588, 7, 0, 0, 4, 8, '20201753042821', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1589, 7, 0, 0, 4, 8, '20201753042822', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1590, 7, 0, 0, 4, 8, '20201753042823', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1591, 7, 0, 0, 4, 8, '20201753042824', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1592, 7, 0, 0, 4, 8, '20201753042825', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1593, 7, 0, 0, 4, 8, '20201753042826', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1594, 7, 0, 0, 4, 8, '20201753042827', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1595, 7, 0, 0, 4, 8, '20201753042828', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1596, 7, 0, 0, 4, 8, '20201753042829', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1597, 7, 0, 0, 4, 8, '20201753042830', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1598, 7, 0, 0, 4, 8, '20201753042831', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1599, 7, 0, 0, 4, 8, '20201753042832', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1600, 7, 0, 0, 4, 8, '20201753042833', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1601, 7, 0, 0, 4, 8, '20201753042834', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1602, 7, 0, 0, 4, 8, '20201753042835', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1603, 7, 0, 0, 4, 8, '20201753042836', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1604, 7, 0, 0, 4, 8, '20201753042837', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1605, 7, 0, 0, 4, 8, '20201753042838', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1606, 7, 0, 0, 4, 8, '20201753042839', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1607, 7, 0, 0, 4, 8, '20201753042840', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1608, 7, 0, 0, 4, 8, '20201753042841', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1609, 7, 0, 0, 4, 8, '20201753042842', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1610, 7, 0, 0, 4, 8, '20201753042843', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1611, 7, 0, 0, 4, 8, '20201753042844', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1612, 7, 0, 0, 4, 8, '20201753042845', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1613, 7, 0, 0, 4, 8, '20201753042846', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1614, 7, 0, 0, 4, 8, '20201753042847', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1615, 7, 0, 0, 4, 8, '20201753042848', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1616, 7, 0, 0, 4, 8, '20201753042849', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1617, 7, 0, 0, 4, 8, '20201753042850', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1618, 7, 0, 0, 4, 8, '20201753042851', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1619, 7, 0, 0, 4, 8, '20201753042852', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1620, 7, 0, 0, 4, 8, '20201753042853', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1621, 7, 0, 0, 4, 8, '20201753042854', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1622, 7, 0, 0, 4, 8, '20201753042855', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1623, 7, 0, 0, 4, 8, '20201753042856', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1624, 7, 0, 0, 4, 8, '20201753042857', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1625, 7, 0, 0, 4, 8, '20201753042858', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1626, 7, 0, 0, 4, 8, '20201753042859', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1627, 7, 0, 0, 4, 8, '20201753042860', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1628, 7, 0, 0, 4, 8, '20201753042861', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1629, 7, 0, 0, 4, 8, '20201753042862', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1630, 7, 0, 0, 4, 8, '20201753042863', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1631, 7, 0, 0, 4, 8, '20201753042864', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1632, 7, 0, 0, 4, 8, '20201753042865', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1633, 7, 0, 0, 4, 8, '20201753042866', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1634, 7, 0, 0, 4, 8, '20201753042867', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1635, 7, 0, 0, 4, 8, '20201753042868', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1636, 7, 0, 0, 4, 8, '20201753042869', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1637, 7, 0, 0, 4, 8, '20201753042870', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1638, 7, 0, 0, 4, 8, '20201753042871', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1639, 7, 0, 0, 4, 8, '20201753042872', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1640, 7, 0, 0, 4, 8, '20201753042873', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1641, 7, 0, 0, 4, 8, '20201753042874', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1642, 7, 0, 0, 4, 8, '20201753042875', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1643, 7, 0, 0, 4, 8, '20201753042876', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1644, 7, 0, 0, 4, 8, '20201753042877', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1645, 7, 0, 0, 4, 8, '20201753042878', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1646, 7, 0, 0, 4, 8, '20201753042879', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1647, 7, 0, 0, 4, 8, '20201753042880', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1648, 7, 0, 0, 4, 8, '20201753042881', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1649, 7, 0, 0, 4, 8, '20201753042882', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1650, 7, 0, 0, 4, 8, '20201753042883', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1651, 7, 0, 0, 4, 8, '20201753042884', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1652, 7, 0, 0, 4, 8, '20201753042885', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1653, 7, 0, 0, 4, 8, '20201753042886', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1654, 7, 0, 0, 4, 8, '20201753042887', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1655, 7, 0, 0, 4, 8, '20201753042888', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1656, 7, 0, 0, 4, 8, '20201753042889', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1657, 7, 0, 0, 4, 8, '20201753042890', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1658, 7, 0, 0, 4, 8, '20201753042891', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1659, 7, 0, 0, 4, 8, '20201753042892', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1660, 7, 0, 0, 4, 8, '20201753042893', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1661, 7, 0, 0, 4, 8, '20201753042894', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1662, 7, 0, 0, 4, 8, '20201753042895', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1663, 7, 0, 0, 4, 8, '20201753042896', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1664, 7, 0, 0, 4, 8, '20201753042897', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1665, 7, 0, 0, 4, 8, '20201753042898', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1666, 7, 0, 0, 4, 8, '20201753042899', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1667, 7, 0, 0, 4, 8, '202017530428100', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1668, 7, 0, 0, 4, 8, '202017530428101', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1669, 7, 0, 0, 4, 8, '202017530428102', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1670, 7, 0, 0, 4, 8, '202017530428103', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1671, 7, 0, 0, 4, 8, '202017530428104', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1672, 7, 0, 0, 4, 8, '202017530428105', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1673, 7, 0, 0, 4, 8, '202017530428106', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1674, 7, 0, 0, 4, 8, '202017530428107', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1675, 7, 0, 0, 4, 8, '202017530428108', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1676, 7, 0, 0, 4, 8, '202017530428109', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1677, 7, 0, 0, 4, 8, '202017530428110', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1678, 7, 0, 0, 4, 8, '202017530428111', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1679, 7, 0, 0, 4, 8, '202017530428112', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1680, 7, 0, 0, 4, 8, '202017530428113', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1681, 7, 0, 0, 4, 8, '202017530428114', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1682, 7, 0, 0, 4, 8, '202017530428115', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1683, 7, 0, 0, 4, 8, '202017530428116', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1684, 7, 0, 0, 4, 8, '202017530428117', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1685, 7, 0, 0, 4, 8, '202017530428118', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1686, 7, 0, 0, 4, 8, '202017530428119', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1687, 7, 0, 0, 4, 8, '202017530428120', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1688, 7, 0, 0, 4, 8, '202017530428121', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1689, 7, 0, 0, 4, 8, '202017530428122', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1690, 7, 0, 0, 4, 8, '202017530428123', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1691, 7, 0, 0, 4, 8, '202017530428124', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1692, 7, 0, 0, 4, 8, '202017530428125', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1693, 7, 0, 0, 4, 8, '202017530428126', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1694, 7, 0, 0, 4, 8, '202017530428127', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1695, 7, 0, 0, 4, 8, '202017530428128', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1696, 7, 0, 0, 4, 8, '202017530428129', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1697, 7, 0, 0, 4, 8, '202017530428130', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1698, 7, 0, 0, 4, 8, '202017530428131', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1699, 7, 0, 0, 4, 8, '202017530428132', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1700, 7, 0, 0, 4, 8, '202017530428133', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1701, 7, 0, 0, 4, 8, '202017530428134', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1702, 7, 0, 0, 4, 8, '202017530428135', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1703, 7, 0, 0, 4, 8, '202017530428136', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1704, 7, 0, 0, 4, 8, '202017530428137', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1705, 7, 0, 0, 4, 8, '202017530428138', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1706, 7, 0, 0, 4, 8, '202017530428139', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1707, 7, 0, 0, 4, 8, '202017530428140', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1708, 7, 0, 0, 4, 8, '202017530428141', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1709, 7, 0, 0, 4, 8, '202017530428142', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1710, 7, 0, 0, 4, 8, '202017530428143', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1711, 7, 0, 0, 4, 8, '202017530428144', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1712, 7, 0, 0, 4, 8, '202017530428145', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1713, 7, 0, 0, 4, 8, '202017530428146', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1714, 7, 0, 0, 4, 8, '202017530428147', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1715, 7, 0, 0, 4, 8, '202017530428148', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1716, 7, 0, 0, 4, 8, '202017530428149', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1717, 7, 0, 0, 4, 8, '202017530428150', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1718, 7, 0, 0, 4, 8, '202017530428151', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1719, 7, 0, 0, 4, 8, '202017530428152', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1720, 7, 0, 0, 4, 8, '202017530428153', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1721, 7, 0, 0, 4, 8, '202017530428154', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1722, 7, 0, 0, 4, 8, '202017530428155', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1723, 7, 0, 0, 4, 8, '202017530428156', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1724, 7, 0, 0, 4, 8, '202017530428157', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1725, 7, 0, 0, 4, 8, '202017530428158', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1726, 7, 0, 0, 4, 8, '202017530428159', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1727, 7, 0, 0, 4, 8, '202017530428160', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1728, 7, 0, 0, 4, 8, '202017530428161', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1729, 7, 0, 0, 4, 8, '202017530428162', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1730, 7, 0, 0, 4, 8, '202017530428163', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1731, 7, 0, 0, 4, 8, '202017530428164', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1732, 7, 0, 0, 4, 8, '202017530428165', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1733, 7, 0, 0, 4, 8, '202017530428166', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1734, 7, 0, 0, 4, 8, '202017530428167', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1735, 7, 0, 0, 4, 8, '202017530428168', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1736, 7, 0, 0, 4, 8, '202017530428169', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1737, 7, 0, 0, 4, 8, '202017530428170', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1738, 7, 0, 0, 4, 8, '202017530428171', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1739, 7, 0, 0, 4, 8, '202017530428172', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1740, 7, 0, 0, 4, 8, '202017530428173', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1741, 7, 0, 0, 4, 8, '202017530428174', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1742, 7, 0, 0, 4, 8, '202017530428175', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1743, 7, 0, 0, 4, 8, '202017530428176', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1744, 7, 0, 0, 4, 8, '202017530428177', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1745, 7, 0, 0, 4, 8, '202017530428178', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1746, 7, 0, 0, 4, 8, '202017530428179', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1747, 7, 0, 0, 4, 8, '202017530428180', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1748, 7, 0, 0, 4, 8, '202017530428181', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1749, 7, 0, 0, 4, 8, '202017530428182', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1750, 7, 0, 0, 4, 8, '202017530428183', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1751, 7, 0, 0, 4, 8, '202017530428184', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1752, 7, 0, 0, 4, 8, '202017530428185', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1753, 7, 0, 0, 4, 8, '202017530428186', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1754, 7, 0, 0, 4, 8, '202017530428187', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1755, 7, 0, 0, 4, 8, '202017530428188', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1756, 7, 0, 0, 4, 8, '202017530428189', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1757, 7, 0, 0, 4, 8, '202017530428190', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1758, 7, 0, 0, 4, 8, '202017530428191', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1759, 7, 0, 0, 4, 8, '202017530428192', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1760, 7, 0, 0, 4, 8, '202017530428193', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1761, 7, 0, 0, 4, 8, '202017530428194', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1762, 7, 0, 0, 4, 8, '202017530428195', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1763, 7, 0, 0, 4, 8, '202017530428196', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1764, 7, 0, 0, 4, 8, '202017530428197', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1765, 7, 0, 0, 4, 8, '202017530428198', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1766, 7, 0, 0, 4, 8, '202017530428199', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1767, 7, 0, 0, 4, 8, '202017530428200', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1768, 7, 0, 0, 4, 8, '202017530428201', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1769, 7, 0, 0, 4, 8, '202017530428202', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1770, 7, 0, 0, 4, 8, '202017530428203', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1771, 7, 0, 0, 4, 8, '202017530428204', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1772, 7, 0, 0, 4, 8, '202017530428205', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1773, 7, 0, 0, 4, 8, '202017530428206', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1774, 7, 0, 0, 4, 8, '202017530428207', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1775, 7, 0, 0, 4, 8, '202017530428208', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1776, 7, 0, 0, 4, 8, '202017530428209', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1777, 7, 0, 0, 4, 8, '202017530428210', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1778, 7, 0, 0, 4, 8, '202017530428211', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1779, 7, 0, 0, 4, 8, '202017530428212', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1780, 7, 0, 0, 4, 8, '202017530428213', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1781, 7, 0, 0, 4, 8, '202017530428214', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1782, 7, 0, 0, 4, 8, '202017530428215', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1783, 7, 0, 0, 4, 8, '202017530428216', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1784, 7, 0, 0, 4, 8, '202017530428217', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1785, 7, 0, 0, 4, 8, '202017530428218', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1786, 7, 0, 0, 4, 8, '202017530428219', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1787, 7, 0, 0, 4, 8, '202017530428220', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1788, 7, 0, 0, 4, 8, '202017530428221', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1);
INSERT INTO `product_stock_serialno` (`idProductserialno`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProductsize`, `serialno`, `idWhStockItem`, `idOrderallocateditems`, `idOrder`, `offer_flog`, `created_by`, `created_at`, `status`) VALUES
(1789, 7, 0, 0, 4, 8, '202017530428222', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1790, 7, 0, 0, 4, 8, '202017530428223', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1791, 7, 0, 0, 4, 8, '202017530428224', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1792, 7, 0, 0, 4, 8, '202017530428225', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1793, 7, 0, 0, 4, 8, '202017530428226', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1794, 7, 0, 0, 4, 8, '202017530428227', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1795, 7, 0, 0, 4, 8, '202017530428228', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1796, 7, 0, 0, 4, 8, '202017530428229', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1797, 7, 0, 0, 4, 8, '202017530428230', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1798, 7, 0, 0, 4, 8, '202017530428231', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1799, 7, 0, 0, 4, 8, '202017530428232', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1800, 7, 0, 0, 4, 8, '202017530428233', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1801, 7, 0, 0, 4, 8, '202017530428234', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1802, 7, 0, 0, 4, 8, '202017530428235', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1803, 7, 0, 0, 4, 8, '202017530428236', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1804, 7, 0, 0, 4, 8, '202017530428237', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1805, 7, 0, 0, 4, 8, '202017530428238', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1806, 7, 0, 0, 4, 8, '202017530428239', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1807, 7, 0, 0, 4, 8, '202017530428240', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1808, 7, 0, 0, 4, 8, '202017530428241', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1809, 7, 0, 0, 4, 8, '202017530428242', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1810, 7, 0, 0, 4, 8, '202017530428243', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1811, 7, 0, 0, 4, 8, '202017530428244', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1812, 7, 0, 0, 4, 8, '202017530428245', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1813, 7, 0, 0, 4, 8, '202017530428246', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1814, 7, 0, 0, 4, 8, '202017530428247', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1815, 7, 0, 0, 4, 8, '202017530428248', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1816, 7, 0, 0, 4, 8, '202017530428249', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1817, 7, 0, 0, 4, 8, '202017530428250', 26, 19, 9, 0, 1, '2020-01-07 17:30:47', 1),
(1818, 7, 0, 0, 4, 8, '202017530428251', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1819, 7, 0, 0, 4, 8, '202017530428252', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1820, 7, 0, 0, 4, 8, '202017530428253', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1821, 7, 0, 0, 4, 8, '202017530428254', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1822, 7, 0, 0, 4, 8, '202017530428255', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1823, 7, 0, 0, 4, 8, '202017530428256', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1824, 7, 0, 0, 4, 8, '202017530428257', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1825, 7, 0, 0, 4, 8, '202017530428258', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1826, 7, 0, 0, 4, 8, '202017530428259', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1827, 7, 0, 0, 4, 8, '202017530428260', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1828, 7, 0, 0, 4, 8, '202017530428261', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1829, 7, 0, 0, 4, 8, '202017530428262', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1830, 7, 0, 0, 4, 8, '202017530428263', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1831, 7, 0, 0, 4, 8, '202017530428264', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1832, 7, 0, 0, 4, 8, '202017530428265', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1833, 7, 0, 0, 4, 8, '202017530428266', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1834, 7, 0, 0, 4, 8, '202017530428267', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1835, 7, 0, 0, 4, 8, '202017530428268', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1836, 7, 0, 0, 4, 8, '202017530428269', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1837, 7, 0, 0, 4, 8, '202017530428270', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1838, 7, 0, 0, 4, 8, '202017530428271', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1839, 7, 0, 0, 4, 8, '202017530428272', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1840, 7, 0, 0, 4, 8, '202017530428273', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1841, 7, 0, 0, 4, 8, '202017530428274', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1842, 7, 0, 0, 4, 8, '202017530428275', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1843, 7, 0, 0, 4, 8, '202017530428276', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1844, 7, 0, 0, 4, 8, '202017530428277', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1845, 7, 0, 0, 4, 8, '202017530428278', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1846, 7, 0, 0, 4, 8, '202017530428279', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1847, 7, 0, 0, 4, 8, '202017530428280', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1848, 7, 0, 0, 4, 8, '202017530428281', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1849, 7, 0, 0, 4, 8, '202017530428282', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1850, 7, 0, 0, 4, 8, '202017530428283', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1851, 7, 0, 0, 4, 8, '202017530428284', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1852, 7, 0, 0, 4, 8, '202017530428285', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1853, 7, 0, 0, 4, 8, '202017530428286', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1854, 7, 0, 0, 4, 8, '202017530428287', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1855, 7, 0, 0, 4, 8, '202017530428288', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1856, 7, 0, 0, 4, 8, '202017530428289', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1857, 7, 0, 0, 4, 8, '202017530428290', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1858, 7, 0, 0, 4, 8, '202017530428291', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1859, 7, 0, 0, 4, 8, '202017530428292', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1860, 7, 0, 0, 4, 8, '202017530428293', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1861, 7, 0, 0, 4, 8, '202017530428294', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1862, 7, 0, 0, 4, 8, '202017530428295', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1863, 7, 0, 0, 4, 8, '202017530428296', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1864, 7, 0, 0, 4, 8, '202017530428297', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1865, 7, 0, 0, 4, 8, '202017530428298', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1866, 7, 0, 0, 4, 8, '202017530428299', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1867, 7, 0, 0, 4, 8, '202017530428300', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1868, 7, 0, 0, 4, 8, '202017530428301', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1869, 7, 0, 0, 4, 8, '202017530428302', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1870, 7, 0, 0, 4, 8, '202017530428303', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1871, 7, 0, 0, 4, 8, '202017530428304', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1872, 7, 0, 0, 4, 8, '202017530428305', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1873, 7, 0, 0, 4, 8, '202017530428306', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1874, 7, 0, 0, 4, 8, '202017530428307', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1875, 7, 0, 0, 4, 8, '202017530428308', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1876, 7, 0, 0, 4, 8, '202017530428309', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1877, 7, 0, 0, 4, 8, '202017530428310', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1878, 7, 0, 0, 4, 8, '202017530428311', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1879, 7, 0, 0, 4, 8, '202017530428312', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1880, 7, 0, 0, 4, 8, '202017530428313', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1881, 7, 0, 0, 4, 8, '202017530428314', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1882, 7, 0, 0, 4, 8, '202017530428315', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1883, 7, 0, 0, 4, 8, '202017530428316', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1884, 7, 0, 0, 4, 8, '202017530428317', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1885, 7, 0, 0, 4, 8, '202017530428318', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1886, 7, 0, 0, 4, 8, '202017530428319', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1887, 7, 0, 0, 4, 8, '202017530428320', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1888, 7, 0, 0, 4, 8, '202017530428321', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1889, 7, 0, 0, 4, 8, '202017530428322', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1890, 7, 0, 0, 4, 8, '202017530428323', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1891, 7, 0, 0, 4, 8, '202017530428324', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1892, 7, 0, 0, 4, 8, '202017530428325', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1893, 7, 0, 0, 4, 8, '202017530428326', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1894, 7, 0, 0, 4, 8, '202017530428327', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1895, 7, 0, 0, 4, 8, '202017530428328', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1896, 7, 0, 0, 4, 8, '202017530428329', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1897, 7, 0, 0, 4, 8, '202017530428330', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1898, 7, 0, 0, 4, 8, '202017530428331', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1899, 7, 0, 0, 4, 8, '202017530428332', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1900, 7, 0, 0, 4, 8, '202017530428333', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1901, 7, 0, 0, 4, 8, '202017530428334', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1902, 7, 0, 0, 4, 8, '202017530428335', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1903, 7, 0, 0, 4, 8, '202017530428336', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1904, 7, 0, 0, 4, 8, '202017530428337', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1905, 7, 0, 0, 4, 8, '202017530428338', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1906, 7, 0, 0, 4, 8, '202017530428339', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1907, 7, 0, 0, 4, 8, '202017530428340', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1908, 7, 0, 0, 4, 8, '202017530428341', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1909, 7, 0, 0, 4, 8, '202017530428342', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1910, 7, 0, 0, 4, 8, '202017530428343', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1911, 7, 0, 0, 4, 8, '202017530428344', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1912, 7, 0, 0, 4, 8, '202017530428345', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1913, 7, 0, 0, 4, 8, '202017530428346', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1914, 7, 0, 0, 4, 8, '202017530428347', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1915, 7, 0, 0, 4, 8, '202017530428348', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1916, 7, 0, 0, 4, 8, '202017530428349', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1917, 7, 0, 0, 4, 8, '202017530428350', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1918, 7, 0, 0, 4, 8, '202017530428351', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1919, 7, 0, 0, 4, 8, '202017530428352', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1920, 7, 0, 0, 4, 8, '202017530428353', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1921, 7, 0, 0, 4, 8, '202017530428354', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1922, 7, 0, 0, 4, 8, '202017530428355', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1923, 7, 0, 0, 4, 8, '202017530428356', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1924, 7, 0, 0, 4, 8, '202017530428357', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1925, 7, 0, 0, 4, 8, '202017530428358', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1926, 7, 0, 0, 4, 8, '202017530428359', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1927, 7, 0, 0, 4, 8, '202017530428360', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1928, 7, 0, 0, 4, 8, '202017530428361', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1929, 7, 0, 0, 4, 8, '202017530428362', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1930, 7, 0, 0, 4, 8, '202017530428363', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1931, 7, 0, 0, 4, 8, '202017530428364', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1932, 7, 0, 0, 4, 8, '202017530428365', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1933, 7, 0, 0, 4, 8, '202017530428366', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1934, 7, 0, 0, 4, 8, '202017530428367', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1935, 7, 0, 0, 4, 8, '202017530428368', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1936, 7, 0, 0, 4, 8, '202017530428369', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1937, 7, 0, 0, 4, 8, '202017530428370', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1938, 7, 0, 0, 4, 8, '202017530428371', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1939, 7, 0, 0, 4, 8, '202017530428372', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1940, 7, 0, 0, 4, 8, '202017530428373', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1941, 7, 0, 0, 4, 8, '202017530428374', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1942, 7, 0, 0, 4, 8, '202017530428375', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1943, 7, 0, 0, 4, 8, '202017530428376', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1944, 7, 0, 0, 4, 8, '202017530428377', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1945, 7, 0, 0, 4, 8, '202017530428378', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1946, 7, 0, 0, 4, 8, '202017530428379', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1947, 7, 0, 0, 4, 8, '202017530428380', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1948, 7, 0, 0, 4, 8, '202017530428381', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1949, 7, 0, 0, 4, 8, '202017530428382', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1950, 7, 0, 0, 4, 8, '202017530428383', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1951, 7, 0, 0, 4, 8, '202017530428384', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1952, 7, 0, 0, 4, 8, '202017530428385', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1953, 7, 0, 0, 4, 8, '202017530428386', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1954, 7, 0, 0, 4, 8, '202017530428387', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1955, 7, 0, 0, 4, 8, '202017530428388', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1956, 7, 0, 0, 4, 8, '202017530428389', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1957, 7, 0, 0, 4, 8, '202017530428390', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1958, 7, 0, 0, 4, 8, '202017530428391', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1959, 7, 0, 0, 4, 8, '202017530428392', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1960, 7, 0, 0, 4, 8, '202017530428393', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1961, 7, 0, 0, 4, 8, '202017530428394', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1962, 7, 0, 0, 4, 8, '202017530428395', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1963, 7, 0, 0, 4, 8, '202017530428396', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1964, 7, 0, 0, 4, 8, '202017530428397', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1965, 7, 0, 0, 4, 8, '202017530428398', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1966, 7, 0, 0, 4, 8, '202017530428399', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1967, 7, 0, 0, 4, 8, '202017530428400', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1968, 7, 0, 0, 4, 8, '202017530428401', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1969, 7, 0, 0, 4, 8, '202017530428402', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1970, 7, 0, 0, 4, 8, '202017530428403', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1971, 7, 0, 0, 4, 8, '202017530428404', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1972, 7, 0, 0, 4, 8, '202017530428405', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1973, 7, 0, 0, 4, 8, '202017530428406', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1974, 7, 0, 0, 4, 8, '202017530428407', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1975, 7, 0, 0, 4, 8, '202017530428408', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1976, 7, 0, 0, 4, 8, '202017530428409', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1977, 7, 0, 0, 4, 8, '202017530428410', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1978, 7, 0, 0, 4, 8, '202017530428411', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1979, 7, 0, 0, 4, 8, '202017530428412', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1980, 7, 0, 0, 4, 8, '202017530428413', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1981, 7, 0, 0, 4, 8, '202017530428414', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1982, 7, 0, 0, 4, 8, '202017530428415', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1983, 7, 0, 0, 4, 8, '202017530428416', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1984, 7, 0, 0, 4, 8, '202017530428417', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1985, 7, 0, 0, 4, 8, '202017530428418', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1986, 7, 0, 0, 4, 8, '202017530428419', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1987, 7, 0, 0, 4, 8, '202017530428420', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1988, 7, 0, 0, 4, 8, '202017530428421', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1989, 7, 0, 0, 4, 8, '202017530428422', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1990, 7, 0, 0, 4, 8, '202017530428423', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1991, 7, 0, 0, 4, 8, '202017530428424', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1992, 7, 0, 0, 4, 8, '202017530428425', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1993, 7, 0, 0, 4, 8, '202017530428426', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1994, 7, 0, 0, 4, 8, '202017530428427', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1995, 7, 0, 0, 4, 8, '202017530428428', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1996, 7, 0, 0, 4, 8, '202017530428429', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1997, 7, 0, 0, 4, 8, '202017530428430', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1998, 7, 0, 0, 4, 8, '202017530428431', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(1999, 7, 0, 0, 4, 8, '202017530428432', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2000, 7, 0, 0, 4, 8, '202017530428433', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2001, 7, 0, 0, 4, 8, '202017530428434', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2002, 7, 0, 0, 4, 8, '202017530428435', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2003, 7, 0, 0, 4, 8, '202017530428436', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2004, 7, 0, 0, 4, 8, '202017530428437', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2005, 7, 0, 0, 4, 8, '202017530428438', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2006, 7, 0, 0, 4, 8, '202017530428439', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2007, 7, 0, 0, 4, 8, '202017530428440', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2008, 7, 0, 0, 4, 8, '202017530428441', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2009, 7, 0, 0, 4, 8, '202017530428442', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2010, 7, 0, 0, 4, 8, '202017530428443', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2011, 7, 0, 0, 4, 8, '202017530428444', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2012, 7, 0, 0, 4, 8, '202017530428445', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2013, 7, 0, 0, 4, 8, '202017530428446', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2014, 7, 0, 0, 4, 8, '202017530428447', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2015, 7, 0, 0, 4, 8, '202017530428448', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2016, 7, 0, 0, 4, 8, '202017530428449', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2017, 7, 0, 0, 4, 8, '202017530428450', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2018, 7, 0, 0, 4, 8, '202017530428451', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2019, 7, 0, 0, 4, 8, '202017530428452', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2020, 7, 0, 0, 4, 8, '202017530428453', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2021, 7, 0, 0, 4, 8, '202017530428454', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2022, 7, 0, 0, 4, 8, '202017530428455', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2023, 7, 0, 0, 4, 8, '202017530428456', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2024, 7, 0, 0, 4, 8, '202017530428457', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2025, 7, 0, 0, 4, 8, '202017530428458', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2026, 7, 0, 0, 4, 8, '202017530428459', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2027, 7, 0, 0, 4, 8, '202017530428460', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2028, 7, 0, 0, 4, 8, '202017530428461', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2029, 7, 0, 0, 4, 8, '202017530428462', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2030, 7, 0, 0, 4, 8, '202017530428463', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2031, 7, 0, 0, 4, 8, '202017530428464', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2032, 7, 0, 0, 4, 8, '202017530428465', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2033, 7, 0, 0, 4, 8, '202017530428466', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2034, 7, 0, 0, 4, 8, '202017530428467', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2035, 7, 0, 0, 4, 8, '202017530428468', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2036, 7, 0, 0, 4, 8, '202017530428469', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2037, 7, 0, 0, 4, 8, '202017530428470', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2038, 7, 0, 0, 4, 8, '202017530428471', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2039, 7, 0, 0, 4, 8, '202017530428472', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2040, 7, 0, 0, 4, 8, '202017530428473', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2041, 7, 0, 0, 4, 8, '202017530428474', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2042, 7, 0, 0, 4, 8, '202017530428475', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2043, 7, 0, 0, 4, 8, '202017530428476', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2044, 7, 0, 0, 4, 8, '202017530428477', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2045, 7, 0, 0, 4, 8, '202017530428478', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2046, 7, 0, 0, 4, 8, '202017530428479', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2047, 7, 0, 0, 4, 8, '202017530428480', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2048, 7, 0, 0, 4, 8, '202017530428481', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2049, 7, 0, 0, 4, 8, '202017530428482', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2050, 7, 0, 0, 4, 8, '202017530428483', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2051, 7, 0, 0, 4, 8, '202017530428484', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2052, 7, 0, 0, 4, 8, '202017530428485', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2053, 7, 0, 0, 4, 8, '202017530428486', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2054, 7, 0, 0, 4, 8, '202017530428487', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2055, 7, 0, 0, 4, 8, '202017530428488', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2056, 7, 0, 0, 4, 8, '202017530428489', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2057, 7, 0, 0, 4, 8, '202017530428490', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2058, 7, 0, 0, 4, 8, '202017530428491', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2059, 7, 0, 0, 4, 8, '202017530428492', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2060, 7, 0, 0, 4, 8, '202017530428493', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2061, 7, 0, 0, 4, 8, '202017530428494', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2062, 7, 0, 0, 4, 8, '202017530428495', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2063, 7, 0, 0, 4, 8, '202017530428496', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2064, 7, 0, 0, 4, 8, '202017530428497', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2065, 7, 0, 0, 4, 8, '202017530428498', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2066, 7, 0, 0, 4, 8, '202017530428499', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2067, 7, 0, 0, 4, 8, '202017530428500', 26, 0, 0, 0, 1, '2020-01-07 17:30:47', 2),
(2068, 7, 0, 0, 4, 7, '2020175305271', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2069, 7, 0, 0, 4, 7, '2020175305272', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2070, 7, 0, 0, 4, 7, '2020175305273', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2071, 7, 0, 0, 4, 7, '2020175305274', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2072, 7, 0, 0, 4, 7, '2020175305275', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2073, 7, 0, 0, 4, 7, '2020175305276', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2074, 7, 0, 0, 4, 7, '2020175305277', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2075, 7, 0, 0, 4, 7, '2020175305278', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2076, 7, 0, 0, 4, 7, '2020175305279', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2077, 7, 0, 0, 4, 7, '20201753052710', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2078, 7, 0, 0, 4, 7, '20201753052711', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2079, 7, 0, 0, 4, 7, '20201753052712', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2080, 7, 0, 0, 4, 7, '20201753052713', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2081, 7, 0, 0, 4, 7, '20201753052714', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2082, 7, 0, 0, 4, 7, '20201753052715', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2083, 7, 0, 0, 4, 7, '20201753052716', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2084, 7, 0, 0, 4, 7, '20201753052717', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2085, 7, 0, 0, 4, 7, '20201753052718', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2086, 7, 0, 0, 4, 7, '20201753052719', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2087, 7, 0, 0, 4, 7, '20201753052720', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2088, 7, 0, 0, 4, 7, '20201753052721', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2089, 7, 0, 0, 4, 7, '20201753052722', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2090, 7, 0, 0, 4, 7, '20201753052723', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2091, 7, 0, 0, 4, 7, '20201753052724', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2092, 7, 0, 0, 4, 7, '20201753052725', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2093, 7, 0, 0, 4, 7, '20201753052726', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2094, 7, 0, 0, 4, 7, '20201753052727', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2095, 7, 0, 0, 4, 7, '20201753052728', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2096, 7, 0, 0, 4, 7, '20201753052729', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2097, 7, 0, 0, 4, 7, '20201753052730', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2098, 7, 0, 0, 4, 7, '20201753052731', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2099, 7, 0, 0, 4, 7, '20201753052732', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2100, 7, 0, 0, 4, 7, '20201753052733', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2101, 7, 0, 0, 4, 7, '20201753052734', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2102, 7, 0, 0, 4, 7, '20201753052735', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2103, 7, 0, 0, 4, 7, '20201753052736', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2104, 7, 0, 0, 4, 7, '20201753052737', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2105, 7, 0, 0, 4, 7, '20201753052738', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2106, 7, 0, 0, 4, 7, '20201753052739', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2107, 7, 0, 0, 4, 7, '20201753052740', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2108, 7, 0, 0, 4, 7, '20201753052741', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2109, 7, 0, 0, 4, 7, '20201753052742', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2110, 7, 0, 0, 4, 7, '20201753052743', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2111, 7, 0, 0, 4, 7, '20201753052744', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2112, 7, 0, 0, 4, 7, '20201753052745', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2113, 7, 0, 0, 4, 7, '20201753052746', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2114, 7, 0, 0, 4, 7, '20201753052747', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2115, 7, 0, 0, 4, 7, '20201753052748', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2116, 7, 0, 0, 4, 7, '20201753052749', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2117, 7, 0, 0, 4, 7, '20201753052750', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2118, 7, 0, 0, 4, 7, '20201753052751', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2119, 7, 0, 0, 4, 7, '20201753052752', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2120, 7, 0, 0, 4, 7, '20201753052753', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2121, 7, 0, 0, 4, 7, '20201753052754', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2122, 7, 0, 0, 4, 7, '20201753052755', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2123, 7, 0, 0, 4, 7, '20201753052756', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2124, 7, 0, 0, 4, 7, '20201753052757', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2125, 7, 0, 0, 4, 7, '20201753052758', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2126, 7, 0, 0, 4, 7, '20201753052759', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2127, 7, 0, 0, 4, 7, '20201753052760', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2128, 7, 0, 0, 4, 7, '20201753052761', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2129, 7, 0, 0, 4, 7, '20201753052762', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2130, 7, 0, 0, 4, 7, '20201753052763', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2131, 7, 0, 0, 4, 7, '20201753052764', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2132, 7, 0, 0, 4, 7, '20201753052765', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2133, 7, 0, 0, 4, 7, '20201753052766', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2134, 7, 0, 0, 4, 7, '20201753052767', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2135, 7, 0, 0, 4, 7, '20201753052768', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2136, 7, 0, 0, 4, 7, '20201753052769', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2137, 7, 0, 0, 4, 7, '20201753052770', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2138, 7, 0, 0, 4, 7, '20201753052771', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2139, 7, 0, 0, 4, 7, '20201753052772', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2140, 7, 0, 0, 4, 7, '20201753052773', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2141, 7, 0, 0, 4, 7, '20201753052774', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2142, 7, 0, 0, 4, 7, '20201753052775', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2143, 7, 0, 0, 4, 7, '20201753052776', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2144, 7, 0, 0, 4, 7, '20201753052777', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2145, 7, 0, 0, 4, 7, '20201753052778', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2146, 7, 0, 0, 4, 7, '20201753052779', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2147, 7, 0, 0, 4, 7, '20201753052780', 25, 16, 13, 0, 1, '2020-01-07 17:30:58', 1),
(2148, 7, 0, 0, 4, 7, '20201753052781', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2149, 7, 0, 0, 4, 7, '20201753052782', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2150, 7, 0, 0, 4, 7, '20201753052783', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2151, 7, 0, 0, 4, 7, '20201753052784', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2152, 7, 0, 0, 4, 7, '20201753052785', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2153, 7, 0, 0, 4, 7, '20201753052786', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2154, 7, 0, 0, 4, 7, '20201753052787', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2155, 7, 0, 0, 4, 7, '20201753052788', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2156, 7, 0, 0, 4, 7, '20201753052789', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2157, 7, 0, 0, 4, 7, '20201753052790', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2158, 7, 0, 0, 4, 7, '20201753052791', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2159, 7, 0, 0, 4, 7, '20201753052792', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2160, 7, 0, 0, 4, 7, '20201753052793', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2161, 7, 0, 0, 4, 7, '20201753052794', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2162, 7, 0, 0, 4, 7, '20201753052795', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2163, 7, 0, 0, 4, 7, '20201753052796', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2164, 7, 0, 0, 4, 7, '20201753052797', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2165, 7, 0, 0, 4, 7, '20201753052798', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2166, 7, 0, 0, 4, 7, '20201753052799', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2167, 7, 0, 0, 4, 7, '202017530527100', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2168, 7, 0, 0, 4, 7, '202017530527101', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2169, 7, 0, 0, 4, 7, '202017530527102', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2170, 7, 0, 0, 4, 7, '202017530527103', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2171, 7, 0, 0, 4, 7, '202017530527104', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2172, 7, 0, 0, 4, 7, '202017530527105', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2173, 7, 0, 0, 4, 7, '202017530527106', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2174, 7, 0, 0, 4, 7, '202017530527107', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2175, 7, 0, 0, 4, 7, '202017530527108', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2176, 7, 0, 0, 4, 7, '202017530527109', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2177, 7, 0, 0, 4, 7, '202017530527110', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2178, 7, 0, 0, 4, 7, '202017530527111', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2179, 7, 0, 0, 4, 7, '202017530527112', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2180, 7, 0, 0, 4, 7, '202017530527113', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2181, 7, 0, 0, 4, 7, '202017530527114', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2182, 7, 0, 0, 4, 7, '202017530527115', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2183, 7, 0, 0, 4, 7, '202017530527116', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2184, 7, 0, 0, 4, 7, '202017530527117', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2185, 7, 0, 0, 4, 7, '202017530527118', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2186, 7, 0, 0, 4, 7, '202017530527119', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2187, 7, 0, 0, 4, 7, '202017530527120', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2188, 7, 0, 0, 4, 7, '202017530527121', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2189, 7, 0, 0, 4, 7, '202017530527122', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2190, 7, 0, 0, 4, 7, '202017530527123', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2191, 7, 0, 0, 4, 7, '202017530527124', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2192, 7, 0, 0, 4, 7, '202017530527125', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2193, 7, 0, 0, 4, 7, '202017530527126', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2194, 7, 0, 0, 4, 7, '202017530527127', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2195, 7, 0, 0, 4, 7, '202017530527128', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2196, 7, 0, 0, 4, 7, '202017530527129', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2197, 7, 0, 0, 4, 7, '202017530527130', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2198, 7, 0, 0, 4, 7, '202017530527131', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2199, 7, 0, 0, 4, 7, '202017530527132', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2200, 7, 0, 0, 4, 7, '202017530527133', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2201, 7, 0, 0, 4, 7, '202017530527134', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2202, 7, 0, 0, 4, 7, '202017530527135', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2203, 7, 0, 0, 4, 7, '202017530527136', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2204, 7, 0, 0, 4, 7, '202017530527137', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2205, 7, 0, 0, 4, 7, '202017530527138', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2206, 7, 0, 0, 4, 7, '202017530527139', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2207, 7, 0, 0, 4, 7, '202017530527140', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2208, 7, 0, 0, 4, 7, '202017530527141', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2209, 7, 0, 0, 4, 7, '202017530527142', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2210, 7, 0, 0, 4, 7, '202017530527143', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2211, 7, 0, 0, 4, 7, '202017530527144', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2212, 7, 0, 0, 4, 7, '202017530527145', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2213, 7, 0, 0, 4, 7, '202017530527146', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2214, 7, 0, 0, 4, 7, '202017530527147', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2215, 7, 0, 0, 4, 7, '202017530527148', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2216, 7, 0, 0, 4, 7, '202017530527149', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2217, 7, 0, 0, 4, 7, '202017530527150', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2218, 7, 0, 0, 4, 7, '202017530527151', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2219, 7, 0, 0, 4, 7, '202017530527152', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2220, 7, 0, 0, 4, 7, '202017530527153', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2221, 7, 0, 0, 4, 7, '202017530527154', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2222, 7, 0, 0, 4, 7, '202017530527155', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2223, 7, 0, 0, 4, 7, '202017530527156', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2224, 7, 0, 0, 4, 7, '202017530527157', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2225, 7, 0, 0, 4, 7, '202017530527158', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2226, 7, 0, 0, 4, 7, '202017530527159', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2227, 7, 0, 0, 4, 7, '202017530527160', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2228, 7, 0, 0, 4, 7, '202017530527161', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2229, 7, 0, 0, 4, 7, '202017530527162', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2230, 7, 0, 0, 4, 7, '202017530527163', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2231, 7, 0, 0, 4, 7, '202017530527164', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2232, 7, 0, 0, 4, 7, '202017530527165', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2233, 7, 0, 0, 4, 7, '202017530527166', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2234, 7, 0, 0, 4, 7, '202017530527167', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2235, 7, 0, 0, 4, 7, '202017530527168', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2236, 7, 0, 0, 4, 7, '202017530527169', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2237, 7, 0, 0, 4, 7, '202017530527170', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2238, 7, 0, 0, 4, 7, '202017530527171', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2239, 7, 0, 0, 4, 7, '202017530527172', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2240, 7, 0, 0, 4, 7, '202017530527173', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2241, 7, 0, 0, 4, 7, '202017530527174', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2242, 7, 0, 0, 4, 7, '202017530527175', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2243, 7, 0, 0, 4, 7, '202017530527176', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2244, 7, 0, 0, 4, 7, '202017530527177', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2245, 7, 0, 0, 4, 7, '202017530527178', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2246, 7, 0, 0, 4, 7, '202017530527179', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2247, 7, 0, 0, 4, 7, '202017530527180', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2248, 7, 0, 0, 4, 7, '202017530527181', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2249, 7, 0, 0, 4, 7, '202017530527182', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2250, 7, 0, 0, 4, 7, '202017530527183', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2251, 7, 0, 0, 4, 7, '202017530527184', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2252, 7, 0, 0, 4, 7, '202017530527185', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2253, 7, 0, 0, 4, 7, '202017530527186', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2254, 7, 0, 0, 4, 7, '202017530527187', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2255, 7, 0, 0, 4, 7, '202017530527188', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2256, 7, 0, 0, 4, 7, '202017530527189', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2257, 7, 0, 0, 4, 7, '202017530527190', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2258, 7, 0, 0, 4, 7, '202017530527191', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2259, 7, 0, 0, 4, 7, '202017530527192', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2260, 7, 0, 0, 4, 7, '202017530527193', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2261, 7, 0, 0, 4, 7, '202017530527194', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2262, 7, 0, 0, 4, 7, '202017530527195', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2263, 7, 0, 0, 4, 7, '202017530527196', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2264, 7, 0, 0, 4, 7, '202017530527197', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2265, 7, 0, 0, 4, 7, '202017530527198', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2266, 7, 0, 0, 4, 7, '202017530527199', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2267, 7, 0, 0, 4, 7, '202017530527200', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2268, 7, 0, 0, 4, 7, '202017530527201', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2269, 7, 0, 0, 4, 7, '202017530527202', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2270, 7, 0, 0, 4, 7, '202017530527203', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2271, 7, 0, 0, 4, 7, '202017530527204', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2272, 7, 0, 0, 4, 7, '202017530527205', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2273, 7, 0, 0, 4, 7, '202017530527206', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2274, 7, 0, 0, 4, 7, '202017530527207', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2275, 7, 0, 0, 4, 7, '202017530527208', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2276, 7, 0, 0, 4, 7, '202017530527209', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2277, 7, 0, 0, 4, 7, '202017530527210', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2278, 7, 0, 0, 4, 7, '202017530527211', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2279, 7, 0, 0, 4, 7, '202017530527212', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2280, 7, 0, 0, 4, 7, '202017530527213', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2281, 7, 0, 0, 4, 7, '202017530527214', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2282, 7, 0, 0, 4, 7, '202017530527215', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2283, 7, 0, 0, 4, 7, '202017530527216', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2284, 7, 0, 0, 4, 7, '202017530527217', 25, 18, 9, 0, 1, '2020-01-07 17:30:58', 1),
(2285, 7, 0, 0, 4, 7, '202017530527218', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2286, 7, 0, 0, 4, 7, '202017530527219', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2287, 7, 0, 0, 4, 7, '202017530527220', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2288, 7, 0, 0, 4, 7, '202017530527221', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2289, 7, 0, 0, 4, 7, '202017530527222', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2290, 7, 0, 0, 4, 7, '202017530527223', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2291, 7, 0, 0, 4, 7, '202017530527224', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2292, 7, 0, 0, 4, 7, '202017530527225', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2293, 7, 0, 0, 4, 7, '202017530527226', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2294, 7, 0, 0, 4, 7, '202017530527227', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2295, 7, 0, 0, 4, 7, '202017530527228', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2296, 7, 0, 0, 4, 7, '202017530527229', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2297, 7, 0, 0, 4, 7, '202017530527230', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2298, 7, 0, 0, 4, 7, '202017530527231', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2299, 7, 0, 0, 4, 7, '202017530527232', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2300, 7, 0, 0, 4, 7, '202017530527233', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2301, 7, 0, 0, 4, 7, '202017530527234', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2302, 7, 0, 0, 4, 7, '202017530527235', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2303, 7, 0, 0, 4, 7, '202017530527236', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2304, 7, 0, 0, 4, 7, '202017530527237', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2305, 7, 0, 0, 4, 7, '202017530527238', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2306, 7, 0, 0, 4, 7, '202017530527239', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2307, 7, 0, 0, 4, 7, '202017530527240', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2308, 7, 0, 0, 4, 7, '202017530527241', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2309, 7, 0, 0, 4, 7, '202017530527242', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2310, 7, 0, 0, 4, 7, '202017530527243', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2311, 7, 0, 0, 4, 7, '202017530527244', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2312, 7, 0, 0, 4, 7, '202017530527245', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2313, 7, 0, 0, 4, 7, '202017530527246', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2314, 7, 0, 0, 4, 7, '202017530527247', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2315, 7, 0, 0, 4, 7, '202017530527248', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2316, 7, 0, 0, 4, 7, '202017530527249', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2317, 7, 0, 0, 4, 7, '202017530527250', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2318, 7, 0, 0, 4, 7, '202017530527251', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2319, 7, 0, 0, 4, 7, '202017530527252', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2320, 7, 0, 0, 4, 7, '202017530527253', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2321, 7, 0, 0, 4, 7, '202017530527254', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2322, 7, 0, 0, 4, 7, '202017530527255', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2323, 7, 0, 0, 4, 7, '202017530527256', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2324, 7, 0, 0, 4, 7, '202017530527257', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2325, 7, 0, 0, 4, 7, '202017530527258', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2326, 7, 0, 0, 4, 7, '202017530527259', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2327, 7, 0, 0, 4, 7, '202017530527260', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2328, 7, 0, 0, 4, 7, '202017530527261', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2329, 7, 0, 0, 4, 7, '202017530527262', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2330, 7, 0, 0, 4, 7, '202017530527263', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2331, 7, 0, 0, 4, 7, '202017530527264', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2332, 7, 0, 0, 4, 7, '202017530527265', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2333, 7, 0, 0, 4, 7, '202017530527266', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2334, 7, 0, 0, 4, 7, '202017530527267', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2335, 7, 0, 0, 4, 7, '202017530527268', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2336, 7, 0, 0, 4, 7, '202017530527269', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2337, 7, 0, 0, 4, 7, '202017530527270', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2338, 7, 0, 0, 4, 7, '202017530527271', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2339, 7, 0, 0, 4, 7, '202017530527272', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2340, 7, 0, 0, 4, 7, '202017530527273', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2341, 7, 0, 0, 4, 7, '202017530527274', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2342, 7, 0, 0, 4, 7, '202017530527275', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2343, 7, 0, 0, 4, 7, '202017530527276', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2344, 7, 0, 0, 4, 7, '202017530527277', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2345, 7, 0, 0, 4, 7, '202017530527278', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2346, 7, 0, 0, 4, 7, '202017530527279', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2347, 7, 0, 0, 4, 7, '202017530527280', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2348, 7, 0, 0, 4, 7, '202017530527281', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2349, 7, 0, 0, 4, 7, '202017530527282', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2350, 7, 0, 0, 4, 7, '202017530527283', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2351, 7, 0, 0, 4, 7, '202017530527284', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2352, 7, 0, 0, 4, 7, '202017530527285', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2353, 7, 0, 0, 4, 7, '202017530527286', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2354, 7, 0, 0, 4, 7, '202017530527287', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2355, 7, 0, 0, 4, 7, '202017530527288', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2356, 7, 0, 0, 4, 7, '202017530527289', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2357, 7, 0, 0, 4, 7, '202017530527290', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2358, 7, 0, 0, 4, 7, '202017530527291', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2359, 7, 0, 0, 4, 7, '202017530527292', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2360, 7, 0, 0, 4, 7, '202017530527293', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2361, 7, 0, 0, 4, 7, '202017530527294', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2362, 7, 0, 0, 4, 7, '202017530527295', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2363, 7, 0, 0, 4, 7, '202017530527296', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2364, 7, 0, 0, 4, 7, '202017530527297', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2365, 7, 0, 0, 4, 7, '202017530527298', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2366, 7, 0, 0, 4, 7, '202017530527299', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2367, 7, 0, 0, 4, 7, '202017530527300', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2368, 7, 0, 0, 4, 7, '202017530527301', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2369, 7, 0, 0, 4, 7, '202017530527302', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2370, 7, 0, 0, 4, 7, '202017530527303', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2371, 7, 0, 0, 4, 7, '202017530527304', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2372, 7, 0, 0, 4, 7, '202017530527305', 25, 18, 9, 0, 1, '2020-01-07 17:30:59', 1),
(2373, 7, 0, 0, 4, 7, '202017530527306', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2374, 7, 0, 0, 4, 7, '202017530527307', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2375, 7, 0, 0, 4, 7, '202017530527308', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2376, 7, 0, 0, 4, 7, '202017530527309', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2377, 7, 0, 0, 4, 7, '202017530527310', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2378, 7, 0, 0, 4, 7, '202017530527311', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2379, 7, 0, 0, 4, 7, '202017530527312', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2380, 7, 0, 0, 4, 7, '202017530527313', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2381, 7, 0, 0, 4, 7, '202017530527314', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2382, 7, 0, 0, 4, 7, '202017530527315', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2383, 7, 0, 0, 4, 7, '202017530527316', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2384, 7, 0, 0, 4, 7, '202017530527317', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2385, 7, 0, 0, 4, 7, '202017530527318', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2386, 7, 0, 0, 4, 7, '202017530527319', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2387, 7, 0, 0, 4, 7, '202017530527320', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2388, 7, 0, 0, 4, 7, '202017530527321', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2389, 7, 0, 0, 4, 7, '202017530527322', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2390, 7, 0, 0, 4, 7, '202017530527323', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2);
INSERT INTO `product_stock_serialno` (`idProductserialno`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProductsize`, `serialno`, `idWhStockItem`, `idOrderallocateditems`, `idOrder`, `offer_flog`, `created_by`, `created_at`, `status`) VALUES
(2391, 7, 0, 0, 4, 7, '202017530527324', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2392, 7, 0, 0, 4, 7, '202017530527325', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2393, 7, 0, 0, 4, 7, '202017530527326', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2394, 7, 0, 0, 4, 7, '202017530527327', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2395, 7, 0, 0, 4, 7, '202017530527328', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2396, 7, 0, 0, 4, 7, '202017530527329', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2397, 7, 0, 0, 4, 7, '202017530527330', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2398, 7, 0, 0, 4, 7, '202017530527331', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2399, 7, 0, 0, 4, 7, '202017530527332', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2400, 7, 0, 0, 4, 7, '202017530527333', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2401, 7, 0, 0, 4, 7, '202017530527334', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2402, 7, 0, 0, 4, 7, '202017530527335', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2403, 7, 0, 0, 4, 7, '202017530527336', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2404, 7, 0, 0, 4, 7, '202017530527337', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2405, 7, 0, 0, 4, 7, '202017530527338', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2406, 7, 0, 0, 4, 7, '202017530527339', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2407, 7, 0, 0, 4, 7, '202017530527340', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2408, 7, 0, 0, 4, 7, '202017530527341', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2409, 7, 0, 0, 4, 7, '202017530527342', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2410, 7, 0, 0, 4, 7, '202017530527343', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2411, 7, 0, 0, 4, 7, '202017530527344', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2412, 7, 0, 0, 4, 7, '202017530527345', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2413, 7, 0, 0, 4, 7, '202017530527346', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2414, 7, 0, 0, 4, 7, '202017530527347', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2415, 7, 0, 0, 4, 7, '202017530527348', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2416, 7, 0, 0, 4, 7, '202017530527349', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2417, 7, 0, 0, 4, 7, '202017530527350', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2418, 7, 0, 0, 4, 7, '202017530527351', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2419, 7, 0, 0, 4, 7, '202017530527352', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2420, 7, 0, 0, 4, 7, '202017530527353', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2421, 7, 0, 0, 4, 7, '202017530527354', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2422, 7, 0, 0, 4, 7, '202017530527355', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2423, 7, 0, 0, 4, 7, '202017530527356', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2424, 7, 0, 0, 4, 7, '202017530527357', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2425, 7, 0, 0, 4, 7, '202017530527358', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2426, 7, 0, 0, 4, 7, '202017530527359', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2427, 7, 0, 0, 4, 7, '202017530527360', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2428, 7, 0, 0, 4, 7, '202017530527361', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2429, 7, 0, 0, 4, 7, '202017530527362', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2430, 7, 0, 0, 4, 7, '202017530527363', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2431, 7, 0, 0, 4, 7, '202017530527364', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2432, 7, 0, 0, 4, 7, '202017530527365', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2433, 7, 0, 0, 4, 7, '202017530527366', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2434, 7, 0, 0, 4, 7, '202017530527367', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2435, 7, 0, 0, 4, 7, '202017530527368', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2436, 7, 0, 0, 4, 7, '202017530527369', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2437, 7, 0, 0, 4, 7, '202017530527370', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2438, 7, 0, 0, 4, 7, '202017530527371', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2439, 7, 0, 0, 4, 7, '202017530527372', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2440, 7, 0, 0, 4, 7, '202017530527373', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2441, 7, 0, 0, 4, 7, '202017530527374', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2442, 7, 0, 0, 4, 7, '202017530527375', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2443, 7, 0, 0, 4, 7, '202017530527376', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2444, 7, 0, 0, 4, 7, '202017530527377', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2445, 7, 0, 0, 4, 7, '202017530527378', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2446, 7, 0, 0, 4, 7, '202017530527379', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2447, 7, 0, 0, 4, 7, '202017530527380', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2448, 7, 0, 0, 4, 7, '202017530527381', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2449, 7, 0, 0, 4, 7, '202017530527382', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2450, 7, 0, 0, 4, 7, '202017530527383', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2451, 7, 0, 0, 4, 7, '202017530527384', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2452, 7, 0, 0, 4, 7, '202017530527385', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2453, 7, 0, 0, 4, 7, '202017530527386', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2454, 7, 0, 0, 4, 7, '202017530527387', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2455, 7, 0, 0, 4, 7, '202017530527388', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2456, 7, 0, 0, 4, 7, '202017530527389', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2457, 7, 0, 0, 4, 7, '202017530527390', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2458, 7, 0, 0, 4, 7, '202017530527391', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2459, 7, 0, 0, 4, 7, '202017530527392', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2460, 7, 0, 0, 4, 7, '202017530527393', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2461, 7, 0, 0, 4, 7, '202017530527394', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2462, 7, 0, 0, 4, 7, '202017530527395', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2463, 7, 0, 0, 4, 7, '202017530527396', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2464, 7, 0, 0, 4, 7, '202017530527397', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2465, 7, 0, 0, 4, 7, '202017530527398', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2466, 7, 0, 0, 4, 7, '202017530527399', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2467, 7, 0, 0, 4, 7, '202017530527400', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2468, 7, 0, 0, 4, 7, '202017530527401', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2469, 7, 0, 0, 4, 7, '202017530527402', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2470, 7, 0, 0, 4, 7, '202017530527403', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2471, 7, 0, 0, 4, 7, '202017530527404', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2472, 7, 0, 0, 4, 7, '202017530527405', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2473, 7, 0, 0, 4, 7, '202017530527406', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2474, 7, 0, 0, 4, 7, '202017530527407', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2475, 7, 0, 0, 4, 7, '202017530527408', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2476, 7, 0, 0, 4, 7, '202017530527409', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2477, 7, 0, 0, 4, 7, '202017530527410', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2478, 7, 0, 0, 4, 7, '202017530527411', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2479, 7, 0, 0, 4, 7, '202017530527412', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2480, 7, 0, 0, 4, 7, '202017530527413', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2481, 7, 0, 0, 4, 7, '202017530527414', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2482, 7, 0, 0, 4, 7, '202017530527415', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2483, 7, 0, 0, 4, 7, '202017530527416', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2484, 7, 0, 0, 4, 7, '202017530527417', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2485, 7, 0, 0, 4, 7, '202017530527418', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2486, 7, 0, 0, 4, 7, '202017530527419', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2487, 7, 0, 0, 4, 7, '202017530527420', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2488, 7, 0, 0, 4, 7, '202017530527421', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2489, 7, 0, 0, 4, 7, '202017530527422', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2490, 7, 0, 0, 4, 7, '202017530527423', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2491, 7, 0, 0, 4, 7, '202017530527424', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2492, 7, 0, 0, 4, 7, '202017530527425', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2493, 7, 0, 0, 4, 7, '202017530527426', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2494, 7, 0, 0, 4, 7, '202017530527427', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2495, 7, 0, 0, 4, 7, '202017530527428', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2496, 7, 0, 0, 4, 7, '202017530527429', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2497, 7, 0, 0, 4, 7, '202017530527430', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2498, 7, 0, 0, 4, 7, '202017530527431', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2499, 7, 0, 0, 4, 7, '202017530527432', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2500, 7, 0, 0, 4, 7, '202017530527433', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2501, 7, 0, 0, 4, 7, '202017530527434', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2502, 7, 0, 0, 4, 7, '202017530527435', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2503, 7, 0, 0, 4, 7, '202017530527436', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2504, 7, 0, 0, 4, 7, '202017530527437', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2505, 7, 0, 0, 4, 7, '202017530527438', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2506, 7, 0, 0, 4, 7, '202017530527439', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2507, 7, 0, 0, 4, 7, '202017530527440', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2508, 7, 0, 0, 4, 7, '202017530527441', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2509, 7, 0, 0, 4, 7, '202017530527442', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2510, 7, 0, 0, 4, 7, '202017530527443', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2511, 7, 0, 0, 4, 7, '202017530527444', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2512, 7, 0, 0, 4, 7, '202017530527445', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2513, 7, 0, 0, 4, 7, '202017530527446', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2514, 7, 0, 0, 4, 7, '202017530527447', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2515, 7, 0, 0, 4, 7, '202017530527448', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2516, 7, 0, 0, 4, 7, '202017530527449', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2517, 7, 0, 0, 4, 7, '202017530527450', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2518, 7, 0, 0, 4, 7, '202017530527451', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2519, 7, 0, 0, 4, 7, '202017530527452', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2520, 7, 0, 0, 4, 7, '202017530527453', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2521, 7, 0, 0, 4, 7, '202017530527454', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2522, 7, 0, 0, 4, 7, '202017530527455', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2523, 7, 0, 0, 4, 7, '202017530527456', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2524, 7, 0, 0, 4, 7, '202017530527457', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2525, 7, 0, 0, 4, 7, '202017530527458', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2526, 7, 0, 0, 4, 7, '202017530527459', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2527, 7, 0, 0, 4, 7, '202017530527460', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2528, 7, 0, 0, 4, 7, '202017530527461', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2529, 7, 0, 0, 4, 7, '202017530527462', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2530, 7, 0, 0, 4, 7, '202017530527463', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2531, 7, 0, 0, 4, 7, '202017530527464', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2532, 7, 0, 0, 4, 7, '202017530527465', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2533, 7, 0, 0, 4, 7, '202017530527466', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2534, 7, 0, 0, 4, 7, '202017530527467', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2535, 7, 0, 0, 4, 7, '202017530527468', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2536, 7, 0, 0, 4, 7, '202017530527469', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2537, 7, 0, 0, 4, 7, '202017530527470', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2538, 7, 0, 0, 4, 7, '202017530527471', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2539, 7, 0, 0, 4, 7, '202017530527472', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2540, 7, 0, 0, 4, 7, '202017530527473', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2541, 7, 0, 0, 4, 7, '202017530527474', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2542, 7, 0, 0, 4, 7, '202017530527475', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2543, 7, 0, 0, 4, 7, '202017530527476', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2544, 7, 0, 0, 4, 7, '202017530527477', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2545, 7, 0, 0, 4, 7, '202017530527478', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2546, 7, 0, 0, 4, 7, '202017530527479', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2547, 7, 0, 0, 4, 7, '202017530527480', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2548, 7, 0, 0, 4, 7, '202017530527481', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2549, 7, 0, 0, 4, 7, '202017530527482', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2550, 7, 0, 0, 4, 7, '202017530527483', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2551, 7, 0, 0, 4, 7, '202017530527484', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2552, 7, 0, 0, 4, 7, '202017530527485', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2553, 7, 0, 0, 4, 7, '202017530527486', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2554, 7, 0, 0, 4, 7, '202017530527487', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2555, 7, 0, 0, 4, 7, '202017530527488', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2556, 7, 0, 0, 4, 7, '202017530527489', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2557, 7, 0, 0, 4, 7, '202017530527490', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2558, 7, 0, 0, 4, 7, '202017530527491', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2559, 7, 0, 0, 4, 7, '202017530527492', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2560, 7, 0, 0, 4, 7, '202017530527493', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2561, 7, 0, 0, 4, 7, '202017530527494', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2562, 7, 0, 0, 4, 7, '202017530527495', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2563, 7, 0, 0, 4, 7, '202017530527496', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2564, 7, 0, 0, 4, 7, '202017530527497', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2565, 7, 0, 0, 4, 7, '202017530527498', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2566, 7, 0, 0, 4, 7, '202017530527499', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2567, 7, 0, 0, 4, 7, '202017530527500', 25, 0, 0, 0, 1, '2020-01-07 17:30:59', 2),
(2568, 8, 0, 0, 1, 1, 'SNO202017540611', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2569, 8, 0, 0, 1, 1, 'SNO202017540612', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2570, 8, 0, 0, 1, 1, 'SNO202017540613', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2571, 8, 0, 0, 1, 1, 'SNO202017540614', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2572, 8, 0, 0, 1, 1, 'SNO202017540615', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2573, 8, 0, 0, 1, 1, 'SNO202017540616', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2574, 8, 0, 0, 1, 1, 'SNO202017540617', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2575, 8, 0, 0, 1, 1, 'SNO202017540618', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2576, 8, 0, 0, 1, 1, 'SNO202017540619', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2577, 8, 0, 0, 1, 1, 'SNO2020175406110', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2578, 8, 0, 0, 1, 1, 'SNO2020175406111', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2579, 8, 0, 0, 1, 1, 'SNO2020175406112', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2580, 8, 0, 0, 1, 1, 'SNO2020175406113', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2581, 8, 0, 0, 1, 1, 'SNO2020175406114', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2582, 8, 0, 0, 1, 1, 'SNO2020175406115', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2583, 8, 0, 0, 1, 1, 'SNO2020175406116', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2584, 8, 0, 0, 1, 1, 'SNO2020175406117', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2585, 8, 0, 0, 1, 1, 'SNO2020175406118', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2586, 8, 0, 0, 1, 1, 'SNO2020175406119', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2587, 8, 0, 0, 1, 1, 'SNO2020175406120', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2588, 8, 0, 0, 1, 1, 'SNO2020175406121', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2589, 8, 0, 0, 1, 1, 'SNO2020175406122', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2590, 8, 0, 0, 1, 1, 'SNO2020175406123', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2591, 8, 0, 0, 1, 1, 'SNO2020175406124', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2592, 8, 0, 0, 1, 1, 'SNO2020175406125', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2593, 8, 0, 0, 1, 1, 'SNO2020175406126', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2594, 8, 0, 0, 1, 1, 'SNO2020175406127', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2595, 8, 0, 0, 1, 1, 'SNO2020175406128', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2596, 8, 0, 0, 1, 1, 'SNO2020175406129', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2597, 8, 0, 0, 1, 1, 'SNO2020175406130', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2598, 8, 0, 0, 1, 1, 'SNO2020175406131', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2599, 8, 0, 0, 1, 1, 'SNO2020175406132', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2600, 8, 0, 0, 1, 1, 'SNO2020175406133', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2601, 8, 0, 0, 1, 1, 'SNO2020175406134', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2602, 8, 0, 0, 1, 1, 'SNO2020175406135', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2603, 8, 0, 0, 1, 1, 'SNO2020175406136', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2604, 8, 0, 0, 1, 1, 'SNO2020175406137', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2605, 8, 0, 0, 1, 1, 'SNO2020175406138', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2606, 8, 0, 0, 1, 1, 'SNO2020175406139', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2607, 8, 0, 0, 1, 1, 'SNO2020175406140', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2608, 8, 0, 0, 1, 1, 'SNO2020175406141', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2609, 8, 0, 0, 1, 1, 'SNO2020175406142', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2610, 8, 0, 0, 1, 1, 'SNO2020175406143', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2611, 8, 0, 0, 1, 1, 'SNO2020175406144', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2612, 8, 0, 0, 1, 1, 'SNO2020175406145', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2613, 8, 0, 0, 1, 1, 'SNO2020175406146', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2614, 8, 0, 0, 1, 1, 'SNO2020175406147', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2615, 8, 0, 0, 1, 1, 'SNO2020175406148', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2616, 8, 0, 0, 1, 1, 'SNO2020175406149', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2617, 8, 0, 0, 1, 1, 'SNO2020175406150', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2618, 8, 0, 0, 1, 1, 'SNO2020175406151', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2619, 8, 0, 0, 1, 1, 'SNO2020175406152', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2620, 8, 0, 0, 1, 1, 'SNO2020175406153', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2621, 8, 0, 0, 1, 1, 'SNO2020175406154', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2622, 8, 0, 0, 1, 1, 'SNO2020175406155', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2623, 8, 0, 0, 1, 1, 'SNO2020175406156', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2624, 8, 0, 0, 1, 1, 'SNO2020175406157', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2625, 8, 0, 0, 1, 1, 'SNO2020175406158', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2626, 8, 0, 0, 1, 1, 'SNO2020175406159', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2627, 8, 0, 0, 1, 1, 'SNO2020175406160', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2628, 8, 0, 0, 1, 1, 'SNO2020175406161', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2629, 8, 0, 0, 1, 1, 'SNO2020175406162', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2630, 8, 0, 0, 1, 1, 'SNO2020175406163', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2631, 8, 0, 0, 1, 1, 'SNO2020175406164', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2632, 8, 0, 0, 1, 1, 'SNO2020175406165', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2633, 8, 0, 0, 1, 1, 'SNO2020175406166', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2634, 8, 0, 0, 1, 1, 'SNO2020175406167', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2635, 8, 0, 0, 1, 1, 'SNO2020175406168', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2636, 8, 0, 0, 1, 1, 'SNO2020175406169', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2637, 8, 0, 0, 1, 1, 'SNO2020175406170', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2638, 8, 0, 0, 1, 1, 'SNO2020175406171', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2639, 8, 0, 0, 1, 1, 'SNO2020175406172', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2640, 8, 0, 0, 1, 1, 'SNO2020175406173', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2641, 8, 0, 0, 1, 1, 'SNO2020175406174', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2642, 8, 0, 0, 1, 1, 'SNO2020175406175', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2643, 8, 0, 0, 1, 1, 'SNO2020175406176', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2644, 8, 0, 0, 1, 1, 'SNO2020175406177', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2645, 8, 0, 0, 1, 1, 'SNO2020175406178', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2646, 8, 0, 0, 1, 1, 'SNO2020175406179', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2647, 8, 0, 0, 1, 1, 'SNO2020175406180', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2648, 8, 0, 0, 1, 1, 'SNO2020175406181', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2649, 8, 0, 0, 1, 1, 'SNO2020175406182', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2650, 8, 0, 0, 1, 1, 'SNO2020175406183', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2651, 8, 0, 0, 1, 1, 'SNO2020175406184', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2652, 8, 0, 0, 1, 1, 'SNO2020175406185', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2653, 8, 0, 0, 1, 1, 'SNO2020175406186', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2654, 8, 0, 0, 1, 1, 'SNO2020175406187', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2655, 8, 0, 0, 1, 1, 'SNO2020175406188', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2656, 8, 0, 0, 1, 1, 'SNO2020175406189', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2657, 8, 0, 0, 1, 1, 'SNO2020175406190', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2658, 8, 0, 0, 1, 1, 'SNO2020175406191', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2659, 8, 0, 0, 1, 1, 'SNO2020175406192', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2660, 8, 0, 0, 1, 1, 'SNO2020175406193', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2661, 8, 0, 0, 1, 1, 'SNO2020175406194', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2662, 8, 0, 0, 1, 1, 'SNO2020175406195', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2663, 8, 0, 0, 1, 1, 'SNO2020175406196', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2664, 8, 0, 0, 1, 1, 'SNO2020175406197', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2665, 8, 0, 0, 1, 1, 'SNO2020175406198', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2666, 8, 0, 0, 1, 1, 'SNO2020175406199', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2667, 8, 0, 0, 1, 1, 'SNO20201754061100', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2668, 8, 0, 0, 1, 1, 'SNO20201754061101', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2669, 8, 0, 0, 1, 1, 'SNO20201754061102', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2670, 8, 0, 0, 1, 1, 'SNO20201754061103', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2671, 8, 0, 0, 1, 1, 'SNO20201754061104', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2672, 8, 0, 0, 1, 1, 'SNO20201754061105', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2673, 8, 0, 0, 1, 1, 'SNO20201754061106', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2674, 8, 0, 0, 1, 1, 'SNO20201754061107', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2675, 8, 0, 0, 1, 1, 'SNO20201754061108', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2676, 8, 0, 0, 1, 1, 'SNO20201754061109', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2677, 8, 0, 0, 1, 1, 'SNO20201754061110', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2678, 8, 0, 0, 1, 1, 'SNO20201754061111', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2679, 8, 0, 0, 1, 1, 'SNO20201754061112', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2680, 8, 0, 0, 1, 1, 'SNO20201754061113', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2681, 8, 0, 0, 1, 1, 'SNO20201754061114', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2682, 8, 0, 0, 1, 1, 'SNO20201754061115', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2683, 8, 0, 0, 1, 1, 'SNO20201754061116', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2684, 8, 0, 0, 1, 1, 'SNO20201754061117', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2685, 8, 0, 0, 1, 1, 'SNO20201754061118', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2686, 8, 0, 0, 1, 1, 'SNO20201754061119', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2687, 8, 0, 0, 1, 1, 'SNO20201754061120', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2688, 8, 0, 0, 1, 1, 'SNO20201754061121', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2689, 8, 0, 0, 1, 1, 'SNO20201754061122', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2690, 8, 0, 0, 1, 1, 'SNO20201754061123', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2691, 8, 0, 0, 1, 1, 'SNO20201754061124', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2692, 8, 0, 0, 1, 1, 'SNO20201754061125', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2693, 8, 0, 0, 1, 1, 'SNO20201754061126', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2694, 8, 0, 0, 1, 1, 'SNO20201754061127', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2695, 8, 0, 0, 1, 1, 'SNO20201754061128', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2696, 8, 0, 0, 1, 1, 'SNO20201754061129', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2697, 8, 0, 0, 1, 1, 'SNO20201754061130', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2698, 8, 0, 0, 1, 1, 'SNO20201754061131', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2699, 8, 0, 0, 1, 1, 'SNO20201754061132', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2700, 8, 0, 0, 1, 1, 'SNO20201754061133', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2701, 8, 0, 0, 1, 1, 'SNO20201754061134', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2702, 8, 0, 0, 1, 1, 'SNO20201754061135', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2703, 8, 0, 0, 1, 1, 'SNO20201754061136', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2704, 8, 0, 0, 1, 1, 'SNO20201754061137', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2705, 8, 0, 0, 1, 1, 'SNO20201754061138', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2706, 8, 0, 0, 1, 1, 'SNO20201754061139', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2707, 8, 0, 0, 1, 1, 'SNO20201754061140', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2708, 8, 0, 0, 1, 1, 'SNO20201754061141', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2709, 8, 0, 0, 1, 1, 'SNO20201754061142', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2710, 8, 0, 0, 1, 1, 'SNO20201754061143', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2711, 8, 0, 0, 1, 1, 'SNO20201754061144', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2712, 8, 0, 0, 1, 1, 'SNO20201754061145', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2713, 8, 0, 0, 1, 1, 'SNO20201754061146', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2714, 8, 0, 0, 1, 1, 'SNO20201754061147', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2715, 8, 0, 0, 1, 1, 'SNO20201754061148', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2716, 8, 0, 0, 1, 1, 'SNO20201754061149', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2717, 8, 0, 0, 1, 1, 'SNO20201754061150', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2718, 8, 0, 0, 1, 1, 'SNO20201754061151', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2719, 8, 0, 0, 1, 1, 'SNO20201754061152', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2720, 8, 0, 0, 1, 1, 'SNO20201754061153', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2721, 8, 0, 0, 1, 1, 'SNO20201754061154', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2722, 8, 0, 0, 1, 1, 'SNO20201754061155', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2723, 8, 0, 0, 1, 1, 'SNO20201754061156', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2724, 8, 0, 0, 1, 1, 'SNO20201754061157', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2725, 8, 0, 0, 1, 1, 'SNO20201754061158', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2726, 8, 0, 0, 1, 1, 'SNO20201754061159', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2727, 8, 0, 0, 1, 1, 'SNO20201754061160', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2728, 8, 0, 0, 1, 1, 'SNO20201754061161', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2729, 8, 0, 0, 1, 1, 'SNO20201754061162', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2730, 8, 0, 0, 1, 1, 'SNO20201754061163', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2731, 8, 0, 0, 1, 1, 'SNO20201754061164', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2732, 8, 0, 0, 1, 1, 'SNO20201754061165', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2733, 8, 0, 0, 1, 1, 'SNO20201754061166', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2734, 8, 0, 0, 1, 1, 'SNO20201754061167', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2735, 8, 0, 0, 1, 1, 'SNO20201754061168', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2736, 8, 0, 0, 1, 1, 'SNO20201754061169', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2737, 8, 0, 0, 1, 1, 'SNO20201754061170', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2738, 8, 0, 0, 1, 1, 'SNO20201754061171', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2739, 8, 0, 0, 1, 1, 'SNO20201754061172', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2740, 8, 0, 0, 1, 1, 'SNO20201754061173', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2741, 8, 0, 0, 1, 1, 'SNO20201754061174', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2742, 8, 0, 0, 1, 1, 'SNO20201754061175', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2743, 8, 0, 0, 1, 1, 'SNO20201754061176', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2744, 8, 0, 0, 1, 1, 'SNO20201754061177', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2745, 8, 0, 0, 1, 1, 'SNO20201754061178', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2746, 8, 0, 0, 1, 1, 'SNO20201754061179', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2747, 8, 0, 0, 1, 1, 'SNO20201754061180', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2748, 8, 0, 0, 1, 1, 'SNO20201754061181', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2749, 8, 0, 0, 1, 1, 'SNO20201754061182', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2750, 8, 0, 0, 1, 1, 'SNO20201754061183', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2751, 8, 0, 0, 1, 1, 'SNO20201754061184', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2752, 8, 0, 0, 1, 1, 'SNO20201754061185', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2753, 8, 0, 0, 1, 1, 'SNO20201754061186', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2754, 8, 0, 0, 1, 1, 'SNO20201754061187', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2755, 8, 0, 0, 1, 1, 'SNO20201754061188', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2756, 8, 0, 0, 1, 1, 'SNO20201754061189', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2757, 8, 0, 0, 1, 1, 'SNO20201754061190', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2758, 8, 0, 0, 1, 1, 'SNO20201754061191', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2759, 8, 0, 0, 1, 1, 'SNO20201754061192', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2760, 8, 0, 0, 1, 1, 'SNO20201754061193', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2761, 8, 0, 0, 1, 1, 'SNO20201754061194', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2762, 8, 0, 0, 1, 1, 'SNO20201754061195', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2763, 8, 0, 0, 1, 1, 'SNO20201754061196', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2764, 8, 0, 0, 1, 1, 'SNO20201754061197', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2765, 8, 0, 0, 1, 1, 'SNO20201754061198', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2766, 8, 0, 0, 1, 1, 'SNO20201754061199', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2767, 8, 0, 0, 1, 1, 'SNO20201754061200', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2768, 8, 0, 0, 1, 1, 'SNO20201754061201', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2769, 8, 0, 0, 1, 1, 'SNO20201754061202', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2770, 8, 0, 0, 1, 1, 'SNO20201754061203', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2771, 8, 0, 0, 1, 1, 'SNO20201754061204', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2772, 8, 0, 0, 1, 1, 'SNO20201754061205', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2773, 8, 0, 0, 1, 1, 'SNO20201754061206', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2774, 8, 0, 0, 1, 1, 'SNO20201754061207', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2775, 8, 0, 0, 1, 1, 'SNO20201754061208', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2776, 8, 0, 0, 1, 1, 'SNO20201754061209', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2777, 8, 0, 0, 1, 1, 'SNO20201754061210', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2778, 8, 0, 0, 1, 1, 'SNO20201754061211', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2779, 8, 0, 0, 1, 1, 'SNO20201754061212', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2780, 8, 0, 0, 1, 1, 'SNO20201754061213', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2781, 8, 0, 0, 1, 1, 'SNO20201754061214', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2782, 8, 0, 0, 1, 1, 'SNO20201754061215', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2783, 8, 0, 0, 1, 1, 'SNO20201754061216', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2784, 8, 0, 0, 1, 1, 'SNO20201754061217', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2785, 8, 0, 0, 1, 1, 'SNO20201754061218', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2786, 8, 0, 0, 1, 1, 'SNO20201754061219', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2787, 8, 0, 0, 1, 1, 'SNO20201754061220', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2788, 8, 0, 0, 1, 1, 'SNO20201754061221', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2789, 8, 0, 0, 1, 1, 'SNO20201754061222', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2790, 8, 0, 0, 1, 1, 'SNO20201754061223', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2791, 8, 0, 0, 1, 1, 'SNO20201754061224', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2792, 8, 0, 0, 1, 1, 'SNO20201754061225', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2793, 8, 0, 0, 1, 1, 'SNO20201754061226', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2794, 8, 0, 0, 1, 1, 'SNO20201754061227', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2795, 8, 0, 0, 1, 1, 'SNO20201754061228', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2796, 8, 0, 0, 1, 1, 'SNO20201754061229', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2797, 8, 0, 0, 1, 1, 'SNO20201754061230', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2798, 8, 0, 0, 1, 1, 'SNO20201754061231', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2799, 8, 0, 0, 1, 1, 'SNO20201754061232', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2800, 8, 0, 0, 1, 1, 'SNO20201754061233', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2801, 8, 0, 0, 1, 1, 'SNO20201754061234', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2802, 8, 0, 0, 1, 1, 'SNO20201754061235', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2803, 8, 0, 0, 1, 1, 'SNO20201754061236', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2804, 8, 0, 0, 1, 1, 'SNO20201754061237', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2805, 8, 0, 0, 1, 1, 'SNO20201754061238', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2806, 8, 0, 0, 1, 1, 'SNO20201754061239', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2807, 8, 0, 0, 1, 1, 'SNO20201754061240', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2808, 8, 0, 0, 1, 1, 'SNO20201754061241', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2809, 8, 0, 0, 1, 1, 'SNO20201754061242', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2810, 8, 0, 0, 1, 1, 'SNO20201754061243', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2811, 8, 0, 0, 1, 1, 'SNO20201754061244', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2812, 8, 0, 0, 1, 1, 'SNO20201754061245', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2813, 8, 0, 0, 1, 1, 'SNO20201754061246', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2814, 8, 0, 0, 1, 1, 'SNO20201754061247', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2815, 8, 0, 0, 1, 1, 'SNO20201754061248', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2816, 8, 0, 0, 1, 1, 'SNO20201754061249', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2817, 8, 0, 0, 1, 1, 'SNO20201754061250', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2818, 8, 0, 0, 1, 1, 'SNO20201754061251', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2819, 8, 0, 0, 1, 1, 'SNO20201754061252', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2820, 8, 0, 0, 1, 1, 'SNO20201754061253', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2821, 8, 0, 0, 1, 1, 'SNO20201754061254', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2822, 8, 0, 0, 1, 1, 'SNO20201754061255', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2823, 8, 0, 0, 1, 1, 'SNO20201754061256', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2824, 8, 0, 0, 1, 1, 'SNO20201754061257', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2825, 8, 0, 0, 1, 1, 'SNO20201754061258', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2826, 8, 0, 0, 1, 1, 'SNO20201754061259', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2827, 8, 0, 0, 1, 1, 'SNO20201754061260', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2828, 8, 0, 0, 1, 1, 'SNO20201754061261', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2829, 8, 0, 0, 1, 1, 'SNO20201754061262', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2830, 8, 0, 0, 1, 1, 'SNO20201754061263', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2831, 8, 0, 0, 1, 1, 'SNO20201754061264', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2832, 8, 0, 0, 1, 1, 'SNO20201754061265', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2833, 8, 0, 0, 1, 1, 'SNO20201754061266', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2834, 8, 0, 0, 1, 1, 'SNO20201754061267', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2835, 8, 0, 0, 1, 1, 'SNO20201754061268', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2836, 8, 0, 0, 1, 1, 'SNO20201754061269', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2837, 8, 0, 0, 1, 1, 'SNO20201754061270', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2838, 8, 0, 0, 1, 1, 'SNO20201754061271', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2839, 8, 0, 0, 1, 1, 'SNO20201754061272', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2840, 8, 0, 0, 1, 1, 'SNO20201754061273', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2841, 8, 0, 0, 1, 1, 'SNO20201754061274', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2842, 8, 0, 0, 1, 1, 'SNO20201754061275', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2843, 8, 0, 0, 1, 1, 'SNO20201754061276', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2844, 8, 0, 0, 1, 1, 'SNO20201754061277', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2845, 8, 0, 0, 1, 1, 'SNO20201754061278', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2846, 8, 0, 0, 1, 1, 'SNO20201754061279', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2847, 8, 0, 0, 1, 1, 'SNO20201754061280', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2848, 8, 0, 0, 1, 1, 'SNO20201754061281', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2849, 8, 0, 0, 1, 1, 'SNO20201754061282', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2850, 8, 0, 0, 1, 1, 'SNO20201754061283', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2851, 8, 0, 0, 1, 1, 'SNO20201754061284', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2852, 8, 0, 0, 1, 1, 'SNO20201754061285', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2853, 8, 0, 0, 1, 1, 'SNO20201754061286', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2854, 8, 0, 0, 1, 1, 'SNO20201754061287', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2855, 8, 0, 0, 1, 1, 'SNO20201754061288', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2856, 8, 0, 0, 1, 1, 'SNO20201754061289', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2857, 8, 0, 0, 1, 1, 'SNO20201754061290', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2858, 8, 0, 0, 1, 1, 'SNO20201754061291', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2859, 8, 0, 0, 1, 1, 'SNO20201754061292', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2860, 8, 0, 0, 1, 1, 'SNO20201754061293', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2861, 8, 0, 0, 1, 1, 'SNO20201754061294', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2862, 8, 0, 0, 1, 1, 'SNO20201754061295', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2863, 8, 0, 0, 1, 1, 'SNO20201754061296', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2864, 8, 0, 0, 1, 1, 'SNO20201754061297', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2865, 8, 0, 0, 1, 1, 'SNO20201754061298', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2866, 8, 0, 0, 1, 1, 'SNO20201754061299', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2867, 8, 0, 0, 1, 1, 'SNO20201754061300', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2868, 8, 0, 0, 1, 1, 'SNO20201754061301', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2869, 8, 0, 0, 1, 1, 'SNO20201754061302', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2870, 8, 0, 0, 1, 1, 'SNO20201754061303', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2871, 8, 0, 0, 1, 1, 'SNO20201754061304', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2872, 8, 0, 0, 1, 1, 'SNO20201754061305', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2873, 8, 0, 0, 1, 1, 'SNO20201754061306', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2874, 8, 0, 0, 1, 1, 'SNO20201754061307', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2875, 8, 0, 0, 1, 1, 'SNO20201754061308', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2876, 8, 0, 0, 1, 1, 'SNO20201754061309', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2877, 8, 0, 0, 1, 1, 'SNO20201754061310', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2878, 8, 0, 0, 1, 1, 'SNO20201754061311', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2879, 8, 0, 0, 1, 1, 'SNO20201754061312', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2880, 8, 0, 0, 1, 1, 'SNO20201754061313', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2881, 8, 0, 0, 1, 1, 'SNO20201754061314', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2882, 8, 0, 0, 1, 1, 'SNO20201754061315', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2883, 8, 0, 0, 1, 1, 'SNO20201754061316', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2884, 8, 0, 0, 1, 1, 'SNO20201754061317', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2885, 8, 0, 0, 1, 1, 'SNO20201754061318', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2886, 8, 0, 0, 1, 1, 'SNO20201754061319', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2887, 8, 0, 0, 1, 1, 'SNO20201754061320', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2888, 8, 0, 0, 1, 1, 'SNO20201754061321', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2889, 8, 0, 0, 1, 1, 'SNO20201754061322', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2890, 8, 0, 0, 1, 1, 'SNO20201754061323', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2891, 8, 0, 0, 1, 1, 'SNO20201754061324', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2892, 8, 0, 0, 1, 1, 'SNO20201754061325', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2893, 8, 0, 0, 1, 1, 'SNO20201754061326', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2894, 8, 0, 0, 1, 1, 'SNO20201754061327', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2895, 8, 0, 0, 1, 1, 'SNO20201754061328', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2896, 8, 0, 0, 1, 1, 'SNO20201754061329', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2897, 8, 0, 0, 1, 1, 'SNO20201754061330', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2898, 8, 0, 0, 1, 1, 'SNO20201754061331', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2899, 8, 0, 0, 1, 1, 'SNO20201754061332', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2900, 8, 0, 0, 1, 1, 'SNO20201754061333', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2901, 8, 0, 0, 1, 1, 'SNO20201754061334', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2902, 8, 0, 0, 1, 1, 'SNO20201754061335', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2903, 8, 0, 0, 1, 1, 'SNO20201754061336', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2904, 8, 0, 0, 1, 1, 'SNO20201754061337', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2905, 8, 0, 0, 1, 1, 'SNO20201754061338', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2906, 8, 0, 0, 1, 1, 'SNO20201754061339', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2907, 8, 0, 0, 1, 1, 'SNO20201754061340', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2908, 8, 0, 0, 1, 1, 'SNO20201754061341', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2909, 8, 0, 0, 1, 1, 'SNO20201754061342', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2910, 8, 0, 0, 1, 1, 'SNO20201754061343', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2911, 8, 0, 0, 1, 1, 'SNO20201754061344', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2912, 8, 0, 0, 1, 1, 'SNO20201754061345', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2913, 8, 0, 0, 1, 1, 'SNO20201754061346', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2914, 8, 0, 0, 1, 1, 'SNO20201754061347', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2915, 8, 0, 0, 1, 1, 'SNO20201754061348', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2916, 8, 0, 0, 1, 1, 'SNO20201754061349', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2917, 8, 0, 0, 1, 1, 'SNO20201754061350', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2918, 8, 0, 0, 1, 1, 'SNO20201754061351', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2919, 8, 0, 0, 1, 1, 'SNO20201754061352', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2920, 8, 0, 0, 1, 1, 'SNO20201754061353', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2921, 8, 0, 0, 1, 1, 'SNO20201754061354', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2922, 8, 0, 0, 1, 1, 'SNO20201754061355', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2923, 8, 0, 0, 1, 1, 'SNO20201754061356', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2924, 8, 0, 0, 1, 1, 'SNO20201754061357', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2925, 8, 0, 0, 1, 1, 'SNO20201754061358', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2926, 8, 0, 0, 1, 1, 'SNO20201754061359', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2927, 8, 0, 0, 1, 1, 'SNO20201754061360', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2928, 8, 0, 0, 1, 1, 'SNO20201754061361', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2929, 8, 0, 0, 1, 1, 'SNO20201754061362', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2930, 8, 0, 0, 1, 1, 'SNO20201754061363', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2931, 8, 0, 0, 1, 1, 'SNO20201754061364', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2932, 8, 0, 0, 1, 1, 'SNO20201754061365', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2933, 8, 0, 0, 1, 1, 'SNO20201754061366', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2934, 8, 0, 0, 1, 1, 'SNO20201754061367', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2935, 8, 0, 0, 1, 1, 'SNO20201754061368', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2936, 8, 0, 0, 1, 1, 'SNO20201754061369', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2937, 8, 0, 0, 1, 1, 'SNO20201754061370', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2938, 8, 0, 0, 1, 1, 'SNO20201754061371', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2939, 8, 0, 0, 1, 1, 'SNO20201754061372', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2940, 8, 0, 0, 1, 1, 'SNO20201754061373', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2941, 8, 0, 0, 1, 1, 'SNO20201754061374', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2942, 8, 0, 0, 1, 1, 'SNO20201754061375', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2943, 8, 0, 0, 1, 1, 'SNO20201754061376', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2944, 8, 0, 0, 1, 1, 'SNO20201754061377', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2945, 8, 0, 0, 1, 1, 'SNO20201754061378', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2946, 8, 0, 0, 1, 1, 'SNO20201754061379', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2947, 8, 0, 0, 1, 1, 'SNO20201754061380', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2948, 8, 0, 0, 1, 1, 'SNO20201754061381', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2949, 8, 0, 0, 1, 1, 'SNO20201754061382', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2950, 8, 0, 0, 1, 1, 'SNO20201754061383', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2951, 8, 0, 0, 1, 1, 'SNO20201754061384', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2952, 8, 0, 0, 1, 1, 'SNO20201754061385', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2953, 8, 0, 0, 1, 1, 'SNO20201754061386', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2954, 8, 0, 0, 1, 1, 'SNO20201754061387', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2955, 8, 0, 0, 1, 1, 'SNO20201754061388', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2956, 8, 0, 0, 1, 1, 'SNO20201754061389', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2957, 8, 0, 0, 1, 1, 'SNO20201754061390', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2958, 8, 0, 0, 1, 1, 'SNO20201754061391', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2959, 8, 0, 0, 1, 1, 'SNO20201754061392', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2960, 8, 0, 0, 1, 1, 'SNO20201754061393', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2961, 8, 0, 0, 1, 1, 'SNO20201754061394', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2962, 8, 0, 0, 1, 1, 'SNO20201754061395', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2963, 8, 0, 0, 1, 1, 'SNO20201754061396', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2964, 8, 0, 0, 1, 1, 'SNO20201754061397', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2965, 8, 0, 0, 1, 1, 'SNO20201754061398', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2966, 8, 0, 0, 1, 1, 'SNO20201754061399', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2967, 8, 0, 0, 1, 1, 'SNO20201754061400', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2968, 8, 0, 0, 1, 1, 'SNO20201754061401', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2969, 8, 0, 0, 1, 1, 'SNO20201754061402', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2970, 8, 0, 0, 1, 1, 'SNO20201754061403', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2971, 8, 0, 0, 1, 1, 'SNO20201754061404', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2972, 8, 0, 0, 1, 1, 'SNO20201754061405', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2973, 8, 0, 0, 1, 1, 'SNO20201754061406', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2974, 8, 0, 0, 1, 1, 'SNO20201754061407', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2975, 8, 0, 0, 1, 1, 'SNO20201754061408', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2976, 8, 0, 0, 1, 1, 'SNO20201754061409', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2977, 8, 0, 0, 1, 1, 'SNO20201754061410', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2978, 8, 0, 0, 1, 1, 'SNO20201754061411', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2979, 8, 0, 0, 1, 1, 'SNO20201754061412', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2980, 8, 0, 0, 1, 1, 'SNO20201754061413', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2981, 8, 0, 0, 1, 1, 'SNO20201754061414', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2982, 8, 0, 0, 1, 1, 'SNO20201754061415', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2983, 8, 0, 0, 1, 1, 'SNO20201754061416', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2984, 8, 0, 0, 1, 1, 'SNO20201754061417', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2985, 8, 0, 0, 1, 1, 'SNO20201754061418', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2986, 8, 0, 0, 1, 1, 'SNO20201754061419', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2987, 8, 0, 0, 1, 1, 'SNO20201754061420', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2);
INSERT INTO `product_stock_serialno` (`idProductserialno`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProductsize`, `serialno`, `idWhStockItem`, `idOrderallocateditems`, `idOrder`, `offer_flog`, `created_by`, `created_at`, `status`) VALUES
(2988, 8, 0, 0, 1, 1, 'SNO20201754061421', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2989, 8, 0, 0, 1, 1, 'SNO20201754061422', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2990, 8, 0, 0, 1, 1, 'SNO20201754061423', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2991, 8, 0, 0, 1, 1, 'SNO20201754061424', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2992, 8, 0, 0, 1, 1, 'SNO20201754061425', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2993, 8, 0, 0, 1, 1, 'SNO20201754061426', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2994, 8, 0, 0, 1, 1, 'SNO20201754061427', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2995, 8, 0, 0, 1, 1, 'SNO20201754061428', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2996, 8, 0, 0, 1, 1, 'SNO20201754061429', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2997, 8, 0, 0, 1, 1, 'SNO20201754061430', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2998, 8, 0, 0, 1, 1, 'SNO20201754061431', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(2999, 8, 0, 0, 1, 1, 'SNO20201754061432', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3000, 8, 0, 0, 1, 1, 'SNO20201754061433', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3001, 8, 0, 0, 1, 1, 'SNO20201754061434', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3002, 8, 0, 0, 1, 1, 'SNO20201754061435', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3003, 8, 0, 0, 1, 1, 'SNO20201754061436', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3004, 8, 0, 0, 1, 1, 'SNO20201754061437', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3005, 8, 0, 0, 1, 1, 'SNO20201754061438', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3006, 8, 0, 0, 1, 1, 'SNO20201754061439', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3007, 8, 0, 0, 1, 1, 'SNO20201754061440', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3008, 8, 0, 0, 1, 1, 'SNO20201754061441', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3009, 8, 0, 0, 1, 1, 'SNO20201754061442', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3010, 8, 0, 0, 1, 1, 'SNO20201754061443', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3011, 8, 0, 0, 1, 1, 'SNO20201754061444', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3012, 8, 0, 0, 1, 1, 'SNO20201754061445', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3013, 8, 0, 0, 1, 1, 'SNO20201754061446', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3014, 8, 0, 0, 1, 1, 'SNO20201754061447', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3015, 8, 0, 0, 1, 1, 'SNO20201754061448', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3016, 8, 0, 0, 1, 1, 'SNO20201754061449', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3017, 8, 0, 0, 1, 1, 'SNO20201754061450', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3018, 8, 0, 0, 1, 1, 'SNO20201754061451', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3019, 8, 0, 0, 1, 1, 'SNO20201754061452', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3020, 8, 0, 0, 1, 1, 'SNO20201754061453', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3021, 8, 0, 0, 1, 1, 'SNO20201754061454', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3022, 8, 0, 0, 1, 1, 'SNO20201754061455', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3023, 8, 0, 0, 1, 1, 'SNO20201754061456', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3024, 8, 0, 0, 1, 1, 'SNO20201754061457', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3025, 8, 0, 0, 1, 1, 'SNO20201754061458', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3026, 8, 0, 0, 1, 1, 'SNO20201754061459', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3027, 8, 0, 0, 1, 1, 'SNO20201754061460', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3028, 8, 0, 0, 1, 1, 'SNO20201754061461', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3029, 8, 0, 0, 1, 1, 'SNO20201754061462', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3030, 8, 0, 0, 1, 1, 'SNO20201754061463', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3031, 8, 0, 0, 1, 1, 'SNO20201754061464', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3032, 8, 0, 0, 1, 1, 'SNO20201754061465', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3033, 8, 0, 0, 1, 1, 'SNO20201754061466', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3034, 8, 0, 0, 1, 1, 'SNO20201754061467', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3035, 8, 0, 0, 1, 1, 'SNO20201754061468', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3036, 8, 0, 0, 1, 1, 'SNO20201754061469', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3037, 8, 0, 0, 1, 1, 'SNO20201754061470', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3038, 8, 0, 0, 1, 1, 'SNO20201754061471', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3039, 8, 0, 0, 1, 1, 'SNO20201754061472', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3040, 8, 0, 0, 1, 1, 'SNO20201754061473', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3041, 8, 0, 0, 1, 1, 'SNO20201754061474', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3042, 8, 0, 0, 1, 1, 'SNO20201754061475', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3043, 8, 0, 0, 1, 1, 'SNO20201754061476', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3044, 8, 0, 0, 1, 1, 'SNO20201754061477', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3045, 8, 0, 0, 1, 1, 'SNO20201754061478', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3046, 8, 0, 0, 1, 1, 'SNO20201754061479', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3047, 8, 0, 0, 1, 1, 'SNO20201754061480', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3048, 8, 0, 0, 1, 1, 'SNO20201754061481', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3049, 8, 0, 0, 1, 1, 'SNO20201754061482', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3050, 8, 0, 0, 1, 1, 'SNO20201754061483', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3051, 8, 0, 0, 1, 1, 'SNO20201754061484', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3052, 8, 0, 0, 1, 1, 'SNO20201754061485', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3053, 8, 0, 0, 1, 1, 'SNO20201754061486', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3054, 8, 0, 0, 1, 1, 'SNO20201754061487', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3055, 8, 0, 0, 1, 1, 'SNO20201754061488', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3056, 8, 0, 0, 1, 1, 'SNO20201754061489', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3057, 8, 0, 0, 1, 1, 'SNO20201754061490', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3058, 8, 0, 0, 1, 1, 'SNO20201754061491', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3059, 8, 0, 0, 1, 1, 'SNO20201754061492', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3060, 8, 0, 0, 1, 1, 'SNO20201754061493', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3061, 8, 0, 0, 1, 1, 'SNO20201754061494', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3062, 8, 0, 0, 1, 1, 'SNO20201754061495', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3063, 8, 0, 0, 1, 1, 'SNO20201754061496', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3064, 8, 0, 0, 1, 1, 'SNO20201754061497', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3065, 8, 0, 0, 1, 1, 'SNO20201754061498', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3066, 8, 0, 0, 1, 1, 'SNO20201754061499', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3067, 8, 0, 0, 1, 1, 'SNO20201754061500', 28, 0, 0, 0, 1, '2020-01-07 17:40:15', 2),
(3068, 8, 0, 0, 1, 2, 'SNO2020175402221', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3069, 8, 0, 0, 1, 2, 'SNO2020175402222', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3070, 8, 0, 0, 1, 2, 'SNO2020175402223', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3071, 8, 0, 0, 1, 2, 'SNO2020175402224', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3072, 8, 0, 0, 1, 2, 'SNO2020175402225', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3073, 8, 0, 0, 1, 2, 'SNO2020175402226', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3074, 8, 0, 0, 1, 2, 'SNO2020175402227', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3075, 8, 0, 0, 1, 2, 'SNO2020175402228', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3076, 8, 0, 0, 1, 2, 'SNO2020175402229', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3077, 8, 0, 0, 1, 2, 'SNO20201754022210', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3078, 8, 0, 0, 1, 2, 'SNO20201754022211', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3079, 8, 0, 0, 1, 2, 'SNO20201754022212', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3080, 8, 0, 0, 1, 2, 'SNO20201754022213', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3081, 8, 0, 0, 1, 2, 'SNO20201754022214', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3082, 8, 0, 0, 1, 2, 'SNO20201754022215', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3083, 8, 0, 0, 1, 2, 'SNO20201754022216', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3084, 8, 0, 0, 1, 2, 'SNO20201754022217', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3085, 8, 0, 0, 1, 2, 'SNO20201754022218', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3086, 8, 0, 0, 1, 2, 'SNO20201754022219', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3087, 8, 0, 0, 1, 2, 'SNO20201754022220', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3088, 8, 0, 0, 1, 2, 'SNO20201754022221', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3089, 8, 0, 0, 1, 2, 'SNO20201754022222', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3090, 8, 0, 0, 1, 2, 'SNO20201754022223', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3091, 8, 0, 0, 1, 2, 'SNO20201754022224', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3092, 8, 0, 0, 1, 2, 'SNO20201754022225', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3093, 8, 0, 0, 1, 2, 'SNO20201754022226', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3094, 8, 0, 0, 1, 2, 'SNO20201754022227', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3095, 8, 0, 0, 1, 2, 'SNO20201754022228', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3096, 8, 0, 0, 1, 2, 'SNO20201754022229', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3097, 8, 0, 0, 1, 2, 'SNO20201754022230', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3098, 8, 0, 0, 1, 2, 'SNO20201754022231', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3099, 8, 0, 0, 1, 2, 'SNO20201754022232', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3100, 8, 0, 0, 1, 2, 'SNO20201754022233', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3101, 8, 0, 0, 1, 2, 'SNO20201754022234', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3102, 8, 0, 0, 1, 2, 'SNO20201754022235', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3103, 8, 0, 0, 1, 2, 'SNO20201754022236', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3104, 8, 0, 0, 1, 2, 'SNO20201754022237', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3105, 8, 0, 0, 1, 2, 'SNO20201754022238', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3106, 8, 0, 0, 1, 2, 'SNO20201754022239', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3107, 8, 0, 0, 1, 2, 'SNO20201754022240', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3108, 8, 0, 0, 1, 2, 'SNO20201754022241', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3109, 8, 0, 0, 1, 2, 'SNO20201754022242', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3110, 8, 0, 0, 1, 2, 'SNO20201754022243', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3111, 8, 0, 0, 1, 2, 'SNO20201754022244', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3112, 8, 0, 0, 1, 2, 'SNO20201754022245', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3113, 8, 0, 0, 1, 2, 'SNO20201754022246', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3114, 8, 0, 0, 1, 2, 'SNO20201754022247', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3115, 8, 0, 0, 1, 2, 'SNO20201754022248', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3116, 8, 0, 0, 1, 2, 'SNO20201754022249', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3117, 8, 0, 0, 1, 2, 'SNO20201754022250', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3118, 8, 0, 0, 1, 2, 'SNO20201754022251', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3119, 8, 0, 0, 1, 2, 'SNO20201754022252', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3120, 8, 0, 0, 1, 2, 'SNO20201754022253', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3121, 8, 0, 0, 1, 2, 'SNO20201754022254', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3122, 8, 0, 0, 1, 2, 'SNO20201754022255', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3123, 8, 0, 0, 1, 2, 'SNO20201754022256', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3124, 8, 0, 0, 1, 2, 'SNO20201754022257', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3125, 8, 0, 0, 1, 2, 'SNO20201754022258', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3126, 8, 0, 0, 1, 2, 'SNO20201754022259', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3127, 8, 0, 0, 1, 2, 'SNO20201754022260', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3128, 8, 0, 0, 1, 2, 'SNO20201754022261', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3129, 8, 0, 0, 1, 2, 'SNO20201754022262', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3130, 8, 0, 0, 1, 2, 'SNO20201754022263', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3131, 8, 0, 0, 1, 2, 'SNO20201754022264', 32, 0, 0, 0, 1, '2020-01-07 17:40:30', 2),
(3132, 8, 0, 0, 1, 2, 'SNO20201754022265', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3133, 8, 0, 0, 1, 2, 'SNO20201754022266', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3134, 8, 0, 0, 1, 2, 'SNO20201754022267', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3135, 8, 0, 0, 1, 2, 'SNO20201754022268', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3136, 8, 0, 0, 1, 2, 'SNO20201754022269', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3137, 8, 0, 0, 1, 2, 'SNO20201754022270', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3138, 8, 0, 0, 1, 2, 'SNO20201754022271', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3139, 8, 0, 0, 1, 2, 'SNO20201754022272', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3140, 8, 0, 0, 1, 2, 'SNO20201754022273', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3141, 8, 0, 0, 1, 2, 'SNO20201754022274', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3142, 8, 0, 0, 1, 2, 'SNO20201754022275', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3143, 8, 0, 0, 1, 2, 'SNO20201754022276', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3144, 8, 0, 0, 1, 2, 'SNO20201754022277', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3145, 8, 0, 0, 1, 2, 'SNO20201754022278', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3146, 8, 0, 0, 1, 2, 'SNO20201754022279', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3147, 8, 0, 0, 1, 2, 'SNO20201754022280', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3148, 8, 0, 0, 1, 2, 'SNO20201754022281', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3149, 8, 0, 0, 1, 2, 'SNO20201754022282', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3150, 8, 0, 0, 1, 2, 'SNO20201754022283', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3151, 8, 0, 0, 1, 2, 'SNO20201754022284', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3152, 8, 0, 0, 1, 2, 'SNO20201754022285', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3153, 8, 0, 0, 1, 2, 'SNO20201754022286', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3154, 8, 0, 0, 1, 2, 'SNO20201754022287', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3155, 8, 0, 0, 1, 2, 'SNO20201754022288', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3156, 8, 0, 0, 1, 2, 'SNO20201754022289', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3157, 8, 0, 0, 1, 2, 'SNO20201754022290', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3158, 8, 0, 0, 1, 2, 'SNO20201754022291', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3159, 8, 0, 0, 1, 2, 'SNO20201754022292', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3160, 8, 0, 0, 1, 2, 'SNO20201754022293', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3161, 8, 0, 0, 1, 2, 'SNO20201754022294', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3162, 8, 0, 0, 1, 2, 'SNO20201754022295', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3163, 8, 0, 0, 1, 2, 'SNO20201754022296', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3164, 8, 0, 0, 1, 2, 'SNO20201754022297', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3165, 8, 0, 0, 1, 2, 'SNO20201754022298', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3166, 8, 0, 0, 1, 2, 'SNO20201754022299', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3167, 8, 0, 0, 1, 2, 'SNO202017540222100', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3168, 8, 0, 0, 1, 2, 'SNO202017540222101', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3169, 8, 0, 0, 1, 2, 'SNO202017540222102', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3170, 8, 0, 0, 1, 2, 'SNO202017540222103', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3171, 8, 0, 0, 1, 2, 'SNO202017540222104', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3172, 8, 0, 0, 1, 2, 'SNO202017540222105', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3173, 8, 0, 0, 1, 2, 'SNO202017540222106', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3174, 8, 0, 0, 1, 2, 'SNO202017540222107', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3175, 8, 0, 0, 1, 2, 'SNO202017540222108', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3176, 8, 0, 0, 1, 2, 'SNO202017540222109', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3177, 8, 0, 0, 1, 2, 'SNO202017540222110', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3178, 8, 0, 0, 1, 2, 'SNO202017540222111', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3179, 8, 0, 0, 1, 2, 'SNO202017540222112', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3180, 8, 0, 0, 1, 2, 'SNO202017540222113', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3181, 8, 0, 0, 1, 2, 'SNO202017540222114', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3182, 8, 0, 0, 1, 2, 'SNO202017540222115', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3183, 8, 0, 0, 1, 2, 'SNO202017540222116', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3184, 8, 0, 0, 1, 2, 'SNO202017540222117', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3185, 8, 0, 0, 1, 2, 'SNO202017540222118', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3186, 8, 0, 0, 1, 2, 'SNO202017540222119', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3187, 8, 0, 0, 1, 2, 'SNO202017540222120', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3188, 8, 0, 0, 1, 2, 'SNO202017540222121', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3189, 8, 0, 0, 1, 2, 'SNO202017540222122', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3190, 8, 0, 0, 1, 2, 'SNO202017540222123', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3191, 8, 0, 0, 1, 2, 'SNO202017540222124', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3192, 8, 0, 0, 1, 2, 'SNO202017540222125', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3193, 8, 0, 0, 1, 2, 'SNO202017540222126', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3194, 8, 0, 0, 1, 2, 'SNO202017540222127', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3195, 8, 0, 0, 1, 2, 'SNO202017540222128', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3196, 8, 0, 0, 1, 2, 'SNO202017540222129', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3197, 8, 0, 0, 1, 2, 'SNO202017540222130', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3198, 8, 0, 0, 1, 2, 'SNO202017540222131', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3199, 8, 0, 0, 1, 2, 'SNO202017540222132', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3200, 8, 0, 0, 1, 2, 'SNO202017540222133', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3201, 8, 0, 0, 1, 2, 'SNO202017540222134', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3202, 8, 0, 0, 1, 2, 'SNO202017540222135', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3203, 8, 0, 0, 1, 2, 'SNO202017540222136', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3204, 8, 0, 0, 1, 2, 'SNO202017540222137', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3205, 8, 0, 0, 1, 2, 'SNO202017540222138', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3206, 8, 0, 0, 1, 2, 'SNO202017540222139', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3207, 8, 0, 0, 1, 2, 'SNO202017540222140', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3208, 8, 0, 0, 1, 2, 'SNO202017540222141', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3209, 8, 0, 0, 1, 2, 'SNO202017540222142', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3210, 8, 0, 0, 1, 2, 'SNO202017540222143', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3211, 8, 0, 0, 1, 2, 'SNO202017540222144', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3212, 8, 0, 0, 1, 2, 'SNO202017540222145', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3213, 8, 0, 0, 1, 2, 'SNO202017540222146', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3214, 8, 0, 0, 1, 2, 'SNO202017540222147', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3215, 8, 0, 0, 1, 2, 'SNO202017540222148', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3216, 8, 0, 0, 1, 2, 'SNO202017540222149', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3217, 8, 0, 0, 1, 2, 'SNO202017540222150', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3218, 8, 0, 0, 1, 2, 'SNO202017540222151', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3219, 8, 0, 0, 1, 2, 'SNO202017540222152', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3220, 8, 0, 0, 1, 2, 'SNO202017540222153', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3221, 8, 0, 0, 1, 2, 'SNO202017540222154', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3222, 8, 0, 0, 1, 2, 'SNO202017540222155', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3223, 8, 0, 0, 1, 2, 'SNO202017540222156', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3224, 8, 0, 0, 1, 2, 'SNO202017540222157', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3225, 8, 0, 0, 1, 2, 'SNO202017540222158', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3226, 8, 0, 0, 1, 2, 'SNO202017540222159', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3227, 8, 0, 0, 1, 2, 'SNO202017540222160', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3228, 8, 0, 0, 1, 2, 'SNO202017540222161', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3229, 8, 0, 0, 1, 2, 'SNO202017540222162', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3230, 8, 0, 0, 1, 2, 'SNO202017540222163', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3231, 8, 0, 0, 1, 2, 'SNO202017540222164', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3232, 8, 0, 0, 1, 2, 'SNO202017540222165', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3233, 8, 0, 0, 1, 2, 'SNO202017540222166', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3234, 8, 0, 0, 1, 2, 'SNO202017540222167', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3235, 8, 0, 0, 1, 2, 'SNO202017540222168', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3236, 8, 0, 0, 1, 2, 'SNO202017540222169', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3237, 8, 0, 0, 1, 2, 'SNO202017540222170', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3238, 8, 0, 0, 1, 2, 'SNO202017540222171', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3239, 8, 0, 0, 1, 2, 'SNO202017540222172', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3240, 8, 0, 0, 1, 2, 'SNO202017540222173', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3241, 8, 0, 0, 1, 2, 'SNO202017540222174', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3242, 8, 0, 0, 1, 2, 'SNO202017540222175', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3243, 8, 0, 0, 1, 2, 'SNO202017540222176', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3244, 8, 0, 0, 1, 2, 'SNO202017540222177', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3245, 8, 0, 0, 1, 2, 'SNO202017540222178', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3246, 8, 0, 0, 1, 2, 'SNO202017540222179', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3247, 8, 0, 0, 1, 2, 'SNO202017540222180', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3248, 8, 0, 0, 1, 2, 'SNO202017540222181', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3249, 8, 0, 0, 1, 2, 'SNO202017540222182', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3250, 8, 0, 0, 1, 2, 'SNO202017540222183', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3251, 8, 0, 0, 1, 2, 'SNO202017540222184', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3252, 8, 0, 0, 1, 2, 'SNO202017540222185', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3253, 8, 0, 0, 1, 2, 'SNO202017540222186', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3254, 8, 0, 0, 1, 2, 'SNO202017540222187', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3255, 8, 0, 0, 1, 2, 'SNO202017540222188', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3256, 8, 0, 0, 1, 2, 'SNO202017540222189', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3257, 8, 0, 0, 1, 2, 'SNO202017540222190', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3258, 8, 0, 0, 1, 2, 'SNO202017540222191', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3259, 8, 0, 0, 1, 2, 'SNO202017540222192', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3260, 8, 0, 0, 1, 2, 'SNO202017540222193', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3261, 8, 0, 0, 1, 2, 'SNO202017540222194', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3262, 8, 0, 0, 1, 2, 'SNO202017540222195', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3263, 8, 0, 0, 1, 2, 'SNO202017540222196', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3264, 8, 0, 0, 1, 2, 'SNO202017540222197', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3265, 8, 0, 0, 1, 2, 'SNO202017540222198', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3266, 8, 0, 0, 1, 2, 'SNO202017540222199', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3267, 8, 0, 0, 1, 2, 'SNO202017540222200', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3268, 8, 0, 0, 1, 2, 'SNO202017540222201', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3269, 8, 0, 0, 1, 2, 'SNO202017540222202', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3270, 8, 0, 0, 1, 2, 'SNO202017540222203', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3271, 8, 0, 0, 1, 2, 'SNO202017540222204', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3272, 8, 0, 0, 1, 2, 'SNO202017540222205', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3273, 8, 0, 0, 1, 2, 'SNO202017540222206', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3274, 8, 0, 0, 1, 2, 'SNO202017540222207', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3275, 8, 0, 0, 1, 2, 'SNO202017540222208', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3276, 8, 0, 0, 1, 2, 'SNO202017540222209', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3277, 8, 0, 0, 1, 2, 'SNO202017540222210', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3278, 8, 0, 0, 1, 2, 'SNO202017540222211', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3279, 8, 0, 0, 1, 2, 'SNO202017540222212', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3280, 8, 0, 0, 1, 2, 'SNO202017540222213', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3281, 8, 0, 0, 1, 2, 'SNO202017540222214', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3282, 8, 0, 0, 1, 2, 'SNO202017540222215', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3283, 8, 0, 0, 1, 2, 'SNO202017540222216', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3284, 8, 0, 0, 1, 2, 'SNO202017540222217', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3285, 8, 0, 0, 1, 2, 'SNO202017540222218', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3286, 8, 0, 0, 1, 2, 'SNO202017540222219', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3287, 8, 0, 0, 1, 2, 'SNO202017540222220', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3288, 8, 0, 0, 1, 2, 'SNO202017540222221', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3289, 8, 0, 0, 1, 2, 'SNO202017540222222', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3290, 8, 0, 0, 1, 2, 'SNO202017540222223', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3291, 8, 0, 0, 1, 2, 'SNO202017540222224', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3292, 8, 0, 0, 1, 2, 'SNO202017540222225', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3293, 8, 0, 0, 1, 2, 'SNO202017540222226', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3294, 8, 0, 0, 1, 2, 'SNO202017540222227', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3295, 8, 0, 0, 1, 2, 'SNO202017540222228', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3296, 8, 0, 0, 1, 2, 'SNO202017540222229', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3297, 8, 0, 0, 1, 2, 'SNO202017540222230', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3298, 8, 0, 0, 1, 2, 'SNO202017540222231', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3299, 8, 0, 0, 1, 2, 'SNO202017540222232', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3300, 8, 0, 0, 1, 2, 'SNO202017540222233', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3301, 8, 0, 0, 1, 2, 'SNO202017540222234', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3302, 8, 0, 0, 1, 2, 'SNO202017540222235', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3303, 8, 0, 0, 1, 2, 'SNO202017540222236', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3304, 8, 0, 0, 1, 2, 'SNO202017540222237', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3305, 8, 0, 0, 1, 2, 'SNO202017540222238', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3306, 8, 0, 0, 1, 2, 'SNO202017540222239', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3307, 8, 0, 0, 1, 2, 'SNO202017540222240', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3308, 8, 0, 0, 1, 2, 'SNO202017540222241', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3309, 8, 0, 0, 1, 2, 'SNO202017540222242', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3310, 8, 0, 0, 1, 2, 'SNO202017540222243', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3311, 8, 0, 0, 1, 2, 'SNO202017540222244', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3312, 8, 0, 0, 1, 2, 'SNO202017540222245', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3313, 8, 0, 0, 1, 2, 'SNO202017540222246', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3314, 8, 0, 0, 1, 2, 'SNO202017540222247', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3315, 8, 0, 0, 1, 2, 'SNO202017540222248', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3316, 8, 0, 0, 1, 2, 'SNO202017540222249', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3317, 8, 0, 0, 1, 2, 'SNO202017540222250', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3318, 8, 0, 0, 1, 2, 'SNO202017540222251', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3319, 8, 0, 0, 1, 2, 'SNO202017540222252', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3320, 8, 0, 0, 1, 2, 'SNO202017540222253', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3321, 8, 0, 0, 1, 2, 'SNO202017540222254', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3322, 8, 0, 0, 1, 2, 'SNO202017540222255', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3323, 8, 0, 0, 1, 2, 'SNO202017540222256', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3324, 8, 0, 0, 1, 2, 'SNO202017540222257', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3325, 8, 0, 0, 1, 2, 'SNO202017540222258', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3326, 8, 0, 0, 1, 2, 'SNO202017540222259', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3327, 8, 0, 0, 1, 2, 'SNO202017540222260', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3328, 8, 0, 0, 1, 2, 'SNO202017540222261', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3329, 8, 0, 0, 1, 2, 'SNO202017540222262', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3330, 8, 0, 0, 1, 2, 'SNO202017540222263', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3331, 8, 0, 0, 1, 2, 'SNO202017540222264', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3332, 8, 0, 0, 1, 2, 'SNO202017540222265', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3333, 8, 0, 0, 1, 2, 'SNO202017540222266', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3334, 8, 0, 0, 1, 2, 'SNO202017540222267', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3335, 8, 0, 0, 1, 2, 'SNO202017540222268', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3336, 8, 0, 0, 1, 2, 'SNO202017540222269', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3337, 8, 0, 0, 1, 2, 'SNO202017540222270', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3338, 8, 0, 0, 1, 2, 'SNO202017540222271', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3339, 8, 0, 0, 1, 2, 'SNO202017540222272', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3340, 8, 0, 0, 1, 2, 'SNO202017540222273', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3341, 8, 0, 0, 1, 2, 'SNO202017540222274', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3342, 8, 0, 0, 1, 2, 'SNO202017540222275', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3343, 8, 0, 0, 1, 2, 'SNO202017540222276', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3344, 8, 0, 0, 1, 2, 'SNO202017540222277', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3345, 8, 0, 0, 1, 2, 'SNO202017540222278', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3346, 8, 0, 0, 1, 2, 'SNO202017540222279', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3347, 8, 0, 0, 1, 2, 'SNO202017540222280', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3348, 8, 0, 0, 1, 2, 'SNO202017540222281', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3349, 8, 0, 0, 1, 2, 'SNO202017540222282', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3350, 8, 0, 0, 1, 2, 'SNO202017540222283', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3351, 8, 0, 0, 1, 2, 'SNO202017540222284', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3352, 8, 0, 0, 1, 2, 'SNO202017540222285', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3353, 8, 0, 0, 1, 2, 'SNO202017540222286', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3354, 8, 0, 0, 1, 2, 'SNO202017540222287', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3355, 8, 0, 0, 1, 2, 'SNO202017540222288', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3356, 8, 0, 0, 1, 2, 'SNO202017540222289', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3357, 8, 0, 0, 1, 2, 'SNO202017540222290', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3358, 8, 0, 0, 1, 2, 'SNO202017540222291', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3359, 8, 0, 0, 1, 2, 'SNO202017540222292', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3360, 8, 0, 0, 1, 2, 'SNO202017540222293', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3361, 8, 0, 0, 1, 2, 'SNO202017540222294', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3362, 8, 0, 0, 1, 2, 'SNO202017540222295', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3363, 8, 0, 0, 1, 2, 'SNO202017540222296', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3364, 8, 0, 0, 1, 2, 'SNO202017540222297', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3365, 8, 0, 0, 1, 2, 'SNO202017540222298', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3366, 8, 0, 0, 1, 2, 'SNO202017540222299', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3367, 8, 0, 0, 1, 2, 'SNO202017540222300', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3368, 8, 0, 0, 1, 2, 'SNO202017540222301', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3369, 8, 0, 0, 1, 2, 'SNO202017540222302', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3370, 8, 0, 0, 1, 2, 'SNO202017540222303', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3371, 8, 0, 0, 1, 2, 'SNO202017540222304', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3372, 8, 0, 0, 1, 2, 'SNO202017540222305', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3373, 8, 0, 0, 1, 2, 'SNO202017540222306', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3374, 8, 0, 0, 1, 2, 'SNO202017540222307', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3375, 8, 0, 0, 1, 2, 'SNO202017540222308', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3376, 8, 0, 0, 1, 2, 'SNO202017540222309', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3377, 8, 0, 0, 1, 2, 'SNO202017540222310', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3378, 8, 0, 0, 1, 2, 'SNO202017540222311', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3379, 8, 0, 0, 1, 2, 'SNO202017540222312', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3380, 8, 0, 0, 1, 2, 'SNO202017540222313', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3381, 8, 0, 0, 1, 2, 'SNO202017540222314', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3382, 8, 0, 0, 1, 2, 'SNO202017540222315', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3383, 8, 0, 0, 1, 2, 'SNO202017540222316', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3384, 8, 0, 0, 1, 2, 'SNO202017540222317', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3385, 8, 0, 0, 1, 2, 'SNO202017540222318', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3386, 8, 0, 0, 1, 2, 'SNO202017540222319', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3387, 8, 0, 0, 1, 2, 'SNO202017540222320', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3388, 8, 0, 0, 1, 2, 'SNO202017540222321', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3389, 8, 0, 0, 1, 2, 'SNO202017540222322', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3390, 8, 0, 0, 1, 2, 'SNO202017540222323', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3391, 8, 0, 0, 1, 2, 'SNO202017540222324', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3392, 8, 0, 0, 1, 2, 'SNO202017540222325', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3393, 8, 0, 0, 1, 2, 'SNO202017540222326', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3394, 8, 0, 0, 1, 2, 'SNO202017540222327', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3395, 8, 0, 0, 1, 2, 'SNO202017540222328', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3396, 8, 0, 0, 1, 2, 'SNO202017540222329', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3397, 8, 0, 0, 1, 2, 'SNO202017540222330', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3398, 8, 0, 0, 1, 2, 'SNO202017540222331', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3399, 8, 0, 0, 1, 2, 'SNO202017540222332', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3400, 8, 0, 0, 1, 2, 'SNO202017540222333', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3401, 8, 0, 0, 1, 2, 'SNO202017540222334', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3402, 8, 0, 0, 1, 2, 'SNO202017540222335', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3403, 8, 0, 0, 1, 2, 'SNO202017540222336', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3404, 8, 0, 0, 1, 2, 'SNO202017540222337', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3405, 8, 0, 0, 1, 2, 'SNO202017540222338', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3406, 8, 0, 0, 1, 2, 'SNO202017540222339', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3407, 8, 0, 0, 1, 2, 'SNO202017540222340', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3408, 8, 0, 0, 1, 2, 'SNO202017540222341', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3409, 8, 0, 0, 1, 2, 'SNO202017540222342', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3410, 8, 0, 0, 1, 2, 'SNO202017540222343', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3411, 8, 0, 0, 1, 2, 'SNO202017540222344', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3412, 8, 0, 0, 1, 2, 'SNO202017540222345', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3413, 8, 0, 0, 1, 2, 'SNO202017540222346', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3414, 8, 0, 0, 1, 2, 'SNO202017540222347', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3415, 8, 0, 0, 1, 2, 'SNO202017540222348', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3416, 8, 0, 0, 1, 2, 'SNO202017540222349', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3417, 8, 0, 0, 1, 2, 'SNO202017540222350', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3418, 8, 0, 0, 1, 2, 'SNO202017540222351', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3419, 8, 0, 0, 1, 2, 'SNO202017540222352', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3420, 8, 0, 0, 1, 2, 'SNO202017540222353', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3421, 8, 0, 0, 1, 2, 'SNO202017540222354', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3422, 8, 0, 0, 1, 2, 'SNO202017540222355', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3423, 8, 0, 0, 1, 2, 'SNO202017540222356', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3424, 8, 0, 0, 1, 2, 'SNO202017540222357', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3425, 8, 0, 0, 1, 2, 'SNO202017540222358', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3426, 8, 0, 0, 1, 2, 'SNO202017540222359', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3427, 8, 0, 0, 1, 2, 'SNO202017540222360', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3428, 8, 0, 0, 1, 2, 'SNO202017540222361', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3429, 8, 0, 0, 1, 2, 'SNO202017540222362', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3430, 8, 0, 0, 1, 2, 'SNO202017540222363', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3431, 8, 0, 0, 1, 2, 'SNO202017540222364', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3432, 8, 0, 0, 1, 2, 'SNO202017540222365', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3433, 8, 0, 0, 1, 2, 'SNO202017540222366', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3434, 8, 0, 0, 1, 2, 'SNO202017540222367', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3435, 8, 0, 0, 1, 2, 'SNO202017540222368', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3436, 8, 0, 0, 1, 2, 'SNO202017540222369', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3437, 8, 0, 0, 1, 2, 'SNO202017540222370', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3438, 8, 0, 0, 1, 2, 'SNO202017540222371', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3439, 8, 0, 0, 1, 2, 'SNO202017540222372', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3440, 8, 0, 0, 1, 2, 'SNO202017540222373', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3441, 8, 0, 0, 1, 2, 'SNO202017540222374', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3442, 8, 0, 0, 1, 2, 'SNO202017540222375', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3443, 8, 0, 0, 1, 2, 'SNO202017540222376', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3444, 8, 0, 0, 1, 2, 'SNO202017540222377', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3445, 8, 0, 0, 1, 2, 'SNO202017540222378', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3446, 8, 0, 0, 1, 2, 'SNO202017540222379', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3447, 8, 0, 0, 1, 2, 'SNO202017540222380', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3448, 8, 0, 0, 1, 2, 'SNO202017540222381', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3449, 8, 0, 0, 1, 2, 'SNO202017540222382', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3450, 8, 0, 0, 1, 2, 'SNO202017540222383', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3451, 8, 0, 0, 1, 2, 'SNO202017540222384', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3452, 8, 0, 0, 1, 2, 'SNO202017540222385', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3453, 8, 0, 0, 1, 2, 'SNO202017540222386', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3454, 8, 0, 0, 1, 2, 'SNO202017540222387', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3455, 8, 0, 0, 1, 2, 'SNO202017540222388', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3456, 8, 0, 0, 1, 2, 'SNO202017540222389', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3457, 8, 0, 0, 1, 2, 'SNO202017540222390', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3458, 8, 0, 0, 1, 2, 'SNO202017540222391', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3459, 8, 0, 0, 1, 2, 'SNO202017540222392', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3460, 8, 0, 0, 1, 2, 'SNO202017540222393', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3461, 8, 0, 0, 1, 2, 'SNO202017540222394', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3462, 8, 0, 0, 1, 2, 'SNO202017540222395', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3463, 8, 0, 0, 1, 2, 'SNO202017540222396', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3464, 8, 0, 0, 1, 2, 'SNO202017540222397', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3465, 8, 0, 0, 1, 2, 'SNO202017540222398', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3466, 8, 0, 0, 1, 2, 'SNO202017540222399', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3467, 8, 0, 0, 1, 2, 'SNO202017540222400', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3468, 8, 0, 0, 1, 2, 'SNO202017540222401', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3469, 8, 0, 0, 1, 2, 'SNO202017540222402', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3470, 8, 0, 0, 1, 2, 'SNO202017540222403', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3471, 8, 0, 0, 1, 2, 'SNO202017540222404', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3472, 8, 0, 0, 1, 2, 'SNO202017540222405', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3473, 8, 0, 0, 1, 2, 'SNO202017540222406', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3474, 8, 0, 0, 1, 2, 'SNO202017540222407', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3475, 8, 0, 0, 1, 2, 'SNO202017540222408', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3476, 8, 0, 0, 1, 2, 'SNO202017540222409', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3477, 8, 0, 0, 1, 2, 'SNO202017540222410', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3478, 8, 0, 0, 1, 2, 'SNO202017540222411', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3479, 8, 0, 0, 1, 2, 'SNO202017540222412', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3480, 8, 0, 0, 1, 2, 'SNO202017540222413', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3481, 8, 0, 0, 1, 2, 'SNO202017540222414', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3482, 8, 0, 0, 1, 2, 'SNO202017540222415', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3483, 8, 0, 0, 1, 2, 'SNO202017540222416', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3484, 8, 0, 0, 1, 2, 'SNO202017540222417', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3485, 8, 0, 0, 1, 2, 'SNO202017540222418', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3486, 8, 0, 0, 1, 2, 'SNO202017540222419', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3487, 8, 0, 0, 1, 2, 'SNO202017540222420', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3488, 8, 0, 0, 1, 2, 'SNO202017540222421', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3489, 8, 0, 0, 1, 2, 'SNO202017540222422', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3490, 8, 0, 0, 1, 2, 'SNO202017540222423', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3491, 8, 0, 0, 1, 2, 'SNO202017540222424', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3492, 8, 0, 0, 1, 2, 'SNO202017540222425', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3493, 8, 0, 0, 1, 2, 'SNO202017540222426', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3494, 8, 0, 0, 1, 2, 'SNO202017540222427', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3495, 8, 0, 0, 1, 2, 'SNO202017540222428', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3496, 8, 0, 0, 1, 2, 'SNO202017540222429', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3497, 8, 0, 0, 1, 2, 'SNO202017540222430', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3498, 8, 0, 0, 1, 2, 'SNO202017540222431', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3499, 8, 0, 0, 1, 2, 'SNO202017540222432', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3500, 8, 0, 0, 1, 2, 'SNO202017540222433', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3501, 8, 0, 0, 1, 2, 'SNO202017540222434', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3502, 8, 0, 0, 1, 2, 'SNO202017540222435', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3503, 8, 0, 0, 1, 2, 'SNO202017540222436', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3504, 8, 0, 0, 1, 2, 'SNO202017540222437', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3505, 8, 0, 0, 1, 2, 'SNO202017540222438', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3506, 8, 0, 0, 1, 2, 'SNO202017540222439', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3507, 8, 0, 0, 1, 2, 'SNO202017540222440', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3508, 8, 0, 0, 1, 2, 'SNO202017540222441', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3509, 8, 0, 0, 1, 2, 'SNO202017540222442', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3510, 8, 0, 0, 1, 2, 'SNO202017540222443', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3511, 8, 0, 0, 1, 2, 'SNO202017540222444', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3512, 8, 0, 0, 1, 2, 'SNO202017540222445', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3513, 8, 0, 0, 1, 2, 'SNO202017540222446', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3514, 8, 0, 0, 1, 2, 'SNO202017540222447', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3515, 8, 0, 0, 1, 2, 'SNO202017540222448', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3516, 8, 0, 0, 1, 2, 'SNO202017540222449', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3517, 8, 0, 0, 1, 2, 'SNO202017540222450', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3518, 8, 0, 0, 1, 2, 'SNO202017540222451', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3519, 8, 0, 0, 1, 2, 'SNO202017540222452', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3520, 8, 0, 0, 1, 2, 'SNO202017540222453', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3521, 8, 0, 0, 1, 2, 'SNO202017540222454', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3522, 8, 0, 0, 1, 2, 'SNO202017540222455', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3523, 8, 0, 0, 1, 2, 'SNO202017540222456', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3524, 8, 0, 0, 1, 2, 'SNO202017540222457', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3525, 8, 0, 0, 1, 2, 'SNO202017540222458', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3526, 8, 0, 0, 1, 2, 'SNO202017540222459', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3527, 8, 0, 0, 1, 2, 'SNO202017540222460', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3528, 8, 0, 0, 1, 2, 'SNO202017540222461', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3529, 8, 0, 0, 1, 2, 'SNO202017540222462', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3530, 8, 0, 0, 1, 2, 'SNO202017540222463', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3531, 8, 0, 0, 1, 2, 'SNO202017540222464', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3532, 8, 0, 0, 1, 2, 'SNO202017540222465', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3533, 8, 0, 0, 1, 2, 'SNO202017540222466', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3534, 8, 0, 0, 1, 2, 'SNO202017540222467', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3535, 8, 0, 0, 1, 2, 'SNO202017540222468', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3536, 8, 0, 0, 1, 2, 'SNO202017540222469', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3537, 8, 0, 0, 1, 2, 'SNO202017540222470', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3538, 8, 0, 0, 1, 2, 'SNO202017540222471', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3539, 8, 0, 0, 1, 2, 'SNO202017540222472', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3540, 8, 0, 0, 1, 2, 'SNO202017540222473', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3541, 8, 0, 0, 1, 2, 'SNO202017540222474', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3542, 8, 0, 0, 1, 2, 'SNO202017540222475', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3543, 8, 0, 0, 1, 2, 'SNO202017540222476', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3544, 8, 0, 0, 1, 2, 'SNO202017540222477', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3545, 8, 0, 0, 1, 2, 'SNO202017540222478', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3546, 8, 0, 0, 1, 2, 'SNO202017540222479', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3547, 8, 0, 0, 1, 2, 'SNO202017540222480', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3548, 8, 0, 0, 1, 2, 'SNO202017540222481', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3549, 8, 0, 0, 1, 2, 'SNO202017540222482', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3550, 8, 0, 0, 1, 2, 'SNO202017540222483', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3551, 8, 0, 0, 1, 2, 'SNO202017540222484', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3552, 8, 0, 0, 1, 2, 'SNO202017540222485', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3553, 8, 0, 0, 1, 2, 'SNO202017540222486', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3554, 8, 0, 0, 1, 2, 'SNO202017540222487', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3555, 8, 0, 0, 1, 2, 'SNO202017540222488', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3556, 8, 0, 0, 1, 2, 'SNO202017540222489', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3557, 8, 0, 0, 1, 2, 'SNO202017540222490', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3558, 8, 0, 0, 1, 2, 'SNO202017540222491', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3559, 8, 0, 0, 1, 2, 'SNO202017540222492', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3560, 8, 0, 0, 1, 2, 'SNO202017540222493', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3561, 8, 0, 0, 1, 2, 'SNO202017540222494', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3562, 8, 0, 0, 1, 2, 'SNO202017540222495', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3563, 8, 0, 0, 1, 2, 'SNO202017540222496', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3564, 8, 0, 0, 1, 2, 'SNO202017540222497', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3565, 8, 0, 0, 1, 2, 'SNO202017540222498', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3566, 8, 0, 0, 1, 2, 'SNO202017540222499', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3567, 8, 0, 0, 1, 2, 'SNO202017540222500', 32, 0, 0, 0, 1, '2020-01-07 17:40:31', 2),
(3568, 8, 0, 0, 4, 7, '2020175403971', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3569, 8, 0, 0, 4, 7, '2020175403972', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3570, 8, 0, 0, 4, 7, '2020175403973', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3571, 8, 0, 0, 4, 7, '2020175403974', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3572, 8, 0, 0, 4, 7, '2020175403975', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3573, 8, 0, 0, 4, 7, '2020175403976', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3574, 8, 0, 0, 4, 7, '2020175403977', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2);
INSERT INTO `product_stock_serialno` (`idProductserialno`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProductsize`, `serialno`, `idWhStockItem`, `idOrderallocateditems`, `idOrder`, `offer_flog`, `created_by`, `created_at`, `status`) VALUES
(3575, 8, 0, 0, 4, 7, '2020175403978', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3576, 8, 0, 0, 4, 7, '2020175403979', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3577, 8, 0, 0, 4, 7, '20201754039710', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3578, 8, 0, 0, 4, 7, '20201754039711', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3579, 8, 0, 0, 4, 7, '20201754039712', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3580, 8, 0, 0, 4, 7, '20201754039713', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3581, 8, 0, 0, 4, 7, '20201754039714', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3582, 8, 0, 0, 4, 7, '20201754039715', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3583, 8, 0, 0, 4, 7, '20201754039716', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3584, 8, 0, 0, 4, 7, '20201754039717', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3585, 8, 0, 0, 4, 7, '20201754039718', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3586, 8, 0, 0, 4, 7, '20201754039719', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3587, 8, 0, 0, 4, 7, '20201754039720', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3588, 8, 0, 0, 4, 7, '20201754039721', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3589, 8, 0, 0, 4, 7, '20201754039722', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3590, 8, 0, 0, 4, 7, '20201754039723', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3591, 8, 0, 0, 4, 7, '20201754039724', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3592, 8, 0, 0, 4, 7, '20201754039725', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3593, 8, 0, 0, 4, 7, '20201754039726', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3594, 8, 0, 0, 4, 7, '20201754039727', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3595, 8, 0, 0, 4, 7, '20201754039728', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3596, 8, 0, 0, 4, 7, '20201754039729', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3597, 8, 0, 0, 4, 7, '20201754039730', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3598, 8, 0, 0, 4, 7, '20201754039731', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3599, 8, 0, 0, 4, 7, '20201754039732', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3600, 8, 0, 0, 4, 7, '20201754039733', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3601, 8, 0, 0, 4, 7, '20201754039734', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3602, 8, 0, 0, 4, 7, '20201754039735', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3603, 8, 0, 0, 4, 7, '20201754039736', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3604, 8, 0, 0, 4, 7, '20201754039737', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3605, 8, 0, 0, 4, 7, '20201754039738', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3606, 8, 0, 0, 4, 7, '20201754039739', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3607, 8, 0, 0, 4, 7, '20201754039740', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3608, 8, 0, 0, 4, 7, '20201754039741', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3609, 8, 0, 0, 4, 7, '20201754039742', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3610, 8, 0, 0, 4, 7, '20201754039743', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3611, 8, 0, 0, 4, 7, '20201754039744', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3612, 8, 0, 0, 4, 7, '20201754039745', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3613, 8, 0, 0, 4, 7, '20201754039746', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3614, 8, 0, 0, 4, 7, '20201754039747', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3615, 8, 0, 0, 4, 7, '20201754039748', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3616, 8, 0, 0, 4, 7, '20201754039749', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3617, 8, 0, 0, 4, 7, '20201754039750', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3618, 8, 0, 0, 4, 7, '20201754039751', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3619, 8, 0, 0, 4, 7, '20201754039752', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3620, 8, 0, 0, 4, 7, '20201754039753', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3621, 8, 0, 0, 4, 7, '20201754039754', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3622, 8, 0, 0, 4, 7, '20201754039755', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3623, 8, 0, 0, 4, 7, '20201754039756', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3624, 8, 0, 0, 4, 7, '20201754039757', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3625, 8, 0, 0, 4, 7, '20201754039758', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3626, 8, 0, 0, 4, 7, '20201754039759', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3627, 8, 0, 0, 4, 7, '20201754039760', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3628, 8, 0, 0, 4, 7, '20201754039761', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3629, 8, 0, 0, 4, 7, '20201754039762', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3630, 8, 0, 0, 4, 7, '20201754039763', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3631, 8, 0, 0, 4, 7, '20201754039764', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3632, 8, 0, 0, 4, 7, '20201754039765', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3633, 8, 0, 0, 4, 7, '20201754039766', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3634, 8, 0, 0, 4, 7, '20201754039767', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3635, 8, 0, 0, 4, 7, '20201754039768', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3636, 8, 0, 0, 4, 7, '20201754039769', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3637, 8, 0, 0, 4, 7, '20201754039770', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3638, 8, 0, 0, 4, 7, '20201754039771', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3639, 8, 0, 0, 4, 7, '20201754039772', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3640, 8, 0, 0, 4, 7, '20201754039773', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3641, 8, 0, 0, 4, 7, '20201754039774', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3642, 8, 0, 0, 4, 7, '20201754039775', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3643, 8, 0, 0, 4, 7, '20201754039776', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3644, 8, 0, 0, 4, 7, '20201754039777', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3645, 8, 0, 0, 4, 7, '20201754039778', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3646, 8, 0, 0, 4, 7, '20201754039779', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3647, 8, 0, 0, 4, 7, '20201754039780', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3648, 8, 0, 0, 4, 7, '20201754039781', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3649, 8, 0, 0, 4, 7, '20201754039782', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3650, 8, 0, 0, 4, 7, '20201754039783', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3651, 8, 0, 0, 4, 7, '20201754039784', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3652, 8, 0, 0, 4, 7, '20201754039785', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3653, 8, 0, 0, 4, 7, '20201754039786', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3654, 8, 0, 0, 4, 7, '20201754039787', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3655, 8, 0, 0, 4, 7, '20201754039788', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3656, 8, 0, 0, 4, 7, '20201754039789', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3657, 8, 0, 0, 4, 7, '20201754039790', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3658, 8, 0, 0, 4, 7, '20201754039791', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3659, 8, 0, 0, 4, 7, '20201754039792', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3660, 8, 0, 0, 4, 7, '20201754039793', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3661, 8, 0, 0, 4, 7, '20201754039794', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3662, 8, 0, 0, 4, 7, '20201754039795', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3663, 8, 0, 0, 4, 7, '20201754039796', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3664, 8, 0, 0, 4, 7, '20201754039797', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3665, 8, 0, 0, 4, 7, '20201754039798', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3666, 8, 0, 0, 4, 7, '20201754039799', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3667, 8, 0, 0, 4, 7, '202017540397100', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3668, 8, 0, 0, 4, 7, '202017540397101', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3669, 8, 0, 0, 4, 7, '202017540397102', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3670, 8, 0, 0, 4, 7, '202017540397103', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3671, 8, 0, 0, 4, 7, '202017540397104', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3672, 8, 0, 0, 4, 7, '202017540397105', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3673, 8, 0, 0, 4, 7, '202017540397106', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3674, 8, 0, 0, 4, 7, '202017540397107', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3675, 8, 0, 0, 4, 7, '202017540397108', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3676, 8, 0, 0, 4, 7, '202017540397109', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3677, 8, 0, 0, 4, 7, '202017540397110', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3678, 8, 0, 0, 4, 7, '202017540397111', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3679, 8, 0, 0, 4, 7, '202017540397112', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3680, 8, 0, 0, 4, 7, '202017540397113', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3681, 8, 0, 0, 4, 7, '202017540397114', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3682, 8, 0, 0, 4, 7, '202017540397115', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3683, 8, 0, 0, 4, 7, '202017540397116', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3684, 8, 0, 0, 4, 7, '202017540397117', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3685, 8, 0, 0, 4, 7, '202017540397118', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3686, 8, 0, 0, 4, 7, '202017540397119', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3687, 8, 0, 0, 4, 7, '202017540397120', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3688, 8, 0, 0, 4, 7, '202017540397121', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3689, 8, 0, 0, 4, 7, '202017540397122', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3690, 8, 0, 0, 4, 7, '202017540397123', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3691, 8, 0, 0, 4, 7, '202017540397124', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3692, 8, 0, 0, 4, 7, '202017540397125', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3693, 8, 0, 0, 4, 7, '202017540397126', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3694, 8, 0, 0, 4, 7, '202017540397127', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3695, 8, 0, 0, 4, 7, '202017540397128', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3696, 8, 0, 0, 4, 7, '202017540397129', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3697, 8, 0, 0, 4, 7, '202017540397130', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3698, 8, 0, 0, 4, 7, '202017540397131', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3699, 8, 0, 0, 4, 7, '202017540397132', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3700, 8, 0, 0, 4, 7, '202017540397133', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3701, 8, 0, 0, 4, 7, '202017540397134', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3702, 8, 0, 0, 4, 7, '202017540397135', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3703, 8, 0, 0, 4, 7, '202017540397136', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3704, 8, 0, 0, 4, 7, '202017540397137', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3705, 8, 0, 0, 4, 7, '202017540397138', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3706, 8, 0, 0, 4, 7, '202017540397139', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3707, 8, 0, 0, 4, 7, '202017540397140', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3708, 8, 0, 0, 4, 7, '202017540397141', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3709, 8, 0, 0, 4, 7, '202017540397142', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3710, 8, 0, 0, 4, 7, '202017540397143', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3711, 8, 0, 0, 4, 7, '202017540397144', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3712, 8, 0, 0, 4, 7, '202017540397145', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3713, 8, 0, 0, 4, 7, '202017540397146', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3714, 8, 0, 0, 4, 7, '202017540397147', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3715, 8, 0, 0, 4, 7, '202017540397148', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3716, 8, 0, 0, 4, 7, '202017540397149', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3717, 8, 0, 0, 4, 7, '202017540397150', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3718, 8, 0, 0, 4, 7, '202017540397151', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3719, 8, 0, 0, 4, 7, '202017540397152', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3720, 8, 0, 0, 4, 7, '202017540397153', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3721, 8, 0, 0, 4, 7, '202017540397154', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3722, 8, 0, 0, 4, 7, '202017540397155', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3723, 8, 0, 0, 4, 7, '202017540397156', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3724, 8, 0, 0, 4, 7, '202017540397157', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3725, 8, 0, 0, 4, 7, '202017540397158', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3726, 8, 0, 0, 4, 7, '202017540397159', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3727, 8, 0, 0, 4, 7, '202017540397160', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3728, 8, 0, 0, 4, 7, '202017540397161', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3729, 8, 0, 0, 4, 7, '202017540397162', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3730, 8, 0, 0, 4, 7, '202017540397163', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3731, 8, 0, 0, 4, 7, '202017540397164', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3732, 8, 0, 0, 4, 7, '202017540397165', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3733, 8, 0, 0, 4, 7, '202017540397166', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3734, 8, 0, 0, 4, 7, '202017540397167', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3735, 8, 0, 0, 4, 7, '202017540397168', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3736, 8, 0, 0, 4, 7, '202017540397169', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3737, 8, 0, 0, 4, 7, '202017540397170', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3738, 8, 0, 0, 4, 7, '202017540397171', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3739, 8, 0, 0, 4, 7, '202017540397172', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3740, 8, 0, 0, 4, 7, '202017540397173', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3741, 8, 0, 0, 4, 7, '202017540397174', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3742, 8, 0, 0, 4, 7, '202017540397175', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3743, 8, 0, 0, 4, 7, '202017540397176', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3744, 8, 0, 0, 4, 7, '202017540397177', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3745, 8, 0, 0, 4, 7, '202017540397178', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3746, 8, 0, 0, 4, 7, '202017540397179', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3747, 8, 0, 0, 4, 7, '202017540397180', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3748, 8, 0, 0, 4, 7, '202017540397181', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3749, 8, 0, 0, 4, 7, '202017540397182', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3750, 8, 0, 0, 4, 7, '202017540397183', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3751, 8, 0, 0, 4, 7, '202017540397184', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3752, 8, 0, 0, 4, 7, '202017540397185', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3753, 8, 0, 0, 4, 7, '202017540397186', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3754, 8, 0, 0, 4, 7, '202017540397187', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3755, 8, 0, 0, 4, 7, '202017540397188', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3756, 8, 0, 0, 4, 7, '202017540397189', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3757, 8, 0, 0, 4, 7, '202017540397190', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3758, 8, 0, 0, 4, 7, '202017540397191', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3759, 8, 0, 0, 4, 7, '202017540397192', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3760, 8, 0, 0, 4, 7, '202017540397193', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3761, 8, 0, 0, 4, 7, '202017540397194', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3762, 8, 0, 0, 4, 7, '202017540397195', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3763, 8, 0, 0, 4, 7, '202017540397196', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3764, 8, 0, 0, 4, 7, '202017540397197', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3765, 8, 0, 0, 4, 7, '202017540397198', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3766, 8, 0, 0, 4, 7, '202017540397199', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3767, 8, 0, 0, 4, 7, '202017540397200', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3768, 8, 0, 0, 4, 7, '202017540397201', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3769, 8, 0, 0, 4, 7, '202017540397202', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3770, 8, 0, 0, 4, 7, '202017540397203', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3771, 8, 0, 0, 4, 7, '202017540397204', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3772, 8, 0, 0, 4, 7, '202017540397205', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3773, 8, 0, 0, 4, 7, '202017540397206', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3774, 8, 0, 0, 4, 7, '202017540397207', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3775, 8, 0, 0, 4, 7, '202017540397208', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3776, 8, 0, 0, 4, 7, '202017540397209', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3777, 8, 0, 0, 4, 7, '202017540397210', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3778, 8, 0, 0, 4, 7, '202017540397211', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3779, 8, 0, 0, 4, 7, '202017540397212', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3780, 8, 0, 0, 4, 7, '202017540397213', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3781, 8, 0, 0, 4, 7, '202017540397214', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3782, 8, 0, 0, 4, 7, '202017540397215', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3783, 8, 0, 0, 4, 7, '202017540397216', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3784, 8, 0, 0, 4, 7, '202017540397217', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3785, 8, 0, 0, 4, 7, '202017540397218', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3786, 8, 0, 0, 4, 7, '202017540397219', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3787, 8, 0, 0, 4, 7, '202017540397220', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3788, 8, 0, 0, 4, 7, '202017540397221', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3789, 8, 0, 0, 4, 7, '202017540397222', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3790, 8, 0, 0, 4, 7, '202017540397223', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3791, 8, 0, 0, 4, 7, '202017540397224', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3792, 8, 0, 0, 4, 7, '202017540397225', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3793, 8, 0, 0, 4, 7, '202017540397226', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3794, 8, 0, 0, 4, 7, '202017540397227', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3795, 8, 0, 0, 4, 7, '202017540397228', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3796, 8, 0, 0, 4, 7, '202017540397229', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3797, 8, 0, 0, 4, 7, '202017540397230', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3798, 8, 0, 0, 4, 7, '202017540397231', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3799, 8, 0, 0, 4, 7, '202017540397232', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3800, 8, 0, 0, 4, 7, '202017540397233', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3801, 8, 0, 0, 4, 7, '202017540397234', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3802, 8, 0, 0, 4, 7, '202017540397235', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3803, 8, 0, 0, 4, 7, '202017540397236', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3804, 8, 0, 0, 4, 7, '202017540397237', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3805, 8, 0, 0, 4, 7, '202017540397238', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3806, 8, 0, 0, 4, 7, '202017540397239', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3807, 8, 0, 0, 4, 7, '202017540397240', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3808, 8, 0, 0, 4, 7, '202017540397241', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3809, 8, 0, 0, 4, 7, '202017540397242', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3810, 8, 0, 0, 4, 7, '202017540397243', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3811, 8, 0, 0, 4, 7, '202017540397244', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3812, 8, 0, 0, 4, 7, '202017540397245', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3813, 8, 0, 0, 4, 7, '202017540397246', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3814, 8, 0, 0, 4, 7, '202017540397247', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3815, 8, 0, 0, 4, 7, '202017540397248', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3816, 8, 0, 0, 4, 7, '202017540397249', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3817, 8, 0, 0, 4, 7, '202017540397250', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3818, 8, 0, 0, 4, 7, '202017540397251', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3819, 8, 0, 0, 4, 7, '202017540397252', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3820, 8, 0, 0, 4, 7, '202017540397253', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3821, 8, 0, 0, 4, 7, '202017540397254', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3822, 8, 0, 0, 4, 7, '202017540397255', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3823, 8, 0, 0, 4, 7, '202017540397256', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3824, 8, 0, 0, 4, 7, '202017540397257', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3825, 8, 0, 0, 4, 7, '202017540397258', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3826, 8, 0, 0, 4, 7, '202017540397259', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3827, 8, 0, 0, 4, 7, '202017540397260', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3828, 8, 0, 0, 4, 7, '202017540397261', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3829, 8, 0, 0, 4, 7, '202017540397262', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3830, 8, 0, 0, 4, 7, '202017540397263', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3831, 8, 0, 0, 4, 7, '202017540397264', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3832, 8, 0, 0, 4, 7, '202017540397265', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3833, 8, 0, 0, 4, 7, '202017540397266', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3834, 8, 0, 0, 4, 7, '202017540397267', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3835, 8, 0, 0, 4, 7, '202017540397268', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3836, 8, 0, 0, 4, 7, '202017540397269', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3837, 8, 0, 0, 4, 7, '202017540397270', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3838, 8, 0, 0, 4, 7, '202017540397271', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3839, 8, 0, 0, 4, 7, '202017540397272', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3840, 8, 0, 0, 4, 7, '202017540397273', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3841, 8, 0, 0, 4, 7, '202017540397274', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3842, 8, 0, 0, 4, 7, '202017540397275', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3843, 8, 0, 0, 4, 7, '202017540397276', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3844, 8, 0, 0, 4, 7, '202017540397277', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3845, 8, 0, 0, 4, 7, '202017540397278', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3846, 8, 0, 0, 4, 7, '202017540397279', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3847, 8, 0, 0, 4, 7, '202017540397280', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3848, 8, 0, 0, 4, 7, '202017540397281', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3849, 8, 0, 0, 4, 7, '202017540397282', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3850, 8, 0, 0, 4, 7, '202017540397283', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3851, 8, 0, 0, 4, 7, '202017540397284', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3852, 8, 0, 0, 4, 7, '202017540397285', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3853, 8, 0, 0, 4, 7, '202017540397286', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3854, 8, 0, 0, 4, 7, '202017540397287', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3855, 8, 0, 0, 4, 7, '202017540397288', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3856, 8, 0, 0, 4, 7, '202017540397289', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3857, 8, 0, 0, 4, 7, '202017540397290', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3858, 8, 0, 0, 4, 7, '202017540397291', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3859, 8, 0, 0, 4, 7, '202017540397292', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3860, 8, 0, 0, 4, 7, '202017540397293', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3861, 8, 0, 0, 4, 7, '202017540397294', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3862, 8, 0, 0, 4, 7, '202017540397295', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3863, 8, 0, 0, 4, 7, '202017540397296', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3864, 8, 0, 0, 4, 7, '202017540397297', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3865, 8, 0, 0, 4, 7, '202017540397298', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3866, 8, 0, 0, 4, 7, '202017540397299', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3867, 8, 0, 0, 4, 7, '202017540397300', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3868, 8, 0, 0, 4, 7, '202017540397301', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3869, 8, 0, 0, 4, 7, '202017540397302', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3870, 8, 0, 0, 4, 7, '202017540397303', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3871, 8, 0, 0, 4, 7, '202017540397304', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3872, 8, 0, 0, 4, 7, '202017540397305', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3873, 8, 0, 0, 4, 7, '202017540397306', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3874, 8, 0, 0, 4, 7, '202017540397307', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3875, 8, 0, 0, 4, 7, '202017540397308', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3876, 8, 0, 0, 4, 7, '202017540397309', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3877, 8, 0, 0, 4, 7, '202017540397310', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3878, 8, 0, 0, 4, 7, '202017540397311', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3879, 8, 0, 0, 4, 7, '202017540397312', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3880, 8, 0, 0, 4, 7, '202017540397313', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3881, 8, 0, 0, 4, 7, '202017540397314', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3882, 8, 0, 0, 4, 7, '202017540397315', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3883, 8, 0, 0, 4, 7, '202017540397316', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3884, 8, 0, 0, 4, 7, '202017540397317', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3885, 8, 0, 0, 4, 7, '202017540397318', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3886, 8, 0, 0, 4, 7, '202017540397319', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3887, 8, 0, 0, 4, 7, '202017540397320', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3888, 8, 0, 0, 4, 7, '202017540397321', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3889, 8, 0, 0, 4, 7, '202017540397322', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3890, 8, 0, 0, 4, 7, '202017540397323', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3891, 8, 0, 0, 4, 7, '202017540397324', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3892, 8, 0, 0, 4, 7, '202017540397325', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3893, 8, 0, 0, 4, 7, '202017540397326', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3894, 8, 0, 0, 4, 7, '202017540397327', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3895, 8, 0, 0, 4, 7, '202017540397328', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3896, 8, 0, 0, 4, 7, '202017540397329', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3897, 8, 0, 0, 4, 7, '202017540397330', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3898, 8, 0, 0, 4, 7, '202017540397331', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3899, 8, 0, 0, 4, 7, '202017540397332', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3900, 8, 0, 0, 4, 7, '202017540397333', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3901, 8, 0, 0, 4, 7, '202017540397334', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3902, 8, 0, 0, 4, 7, '202017540397335', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3903, 8, 0, 0, 4, 7, '202017540397336', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3904, 8, 0, 0, 4, 7, '202017540397337', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3905, 8, 0, 0, 4, 7, '202017540397338', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3906, 8, 0, 0, 4, 7, '202017540397339', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3907, 8, 0, 0, 4, 7, '202017540397340', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3908, 8, 0, 0, 4, 7, '202017540397341', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3909, 8, 0, 0, 4, 7, '202017540397342', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3910, 8, 0, 0, 4, 7, '202017540397343', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3911, 8, 0, 0, 4, 7, '202017540397344', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3912, 8, 0, 0, 4, 7, '202017540397345', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3913, 8, 0, 0, 4, 7, '202017540397346', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3914, 8, 0, 0, 4, 7, '202017540397347', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3915, 8, 0, 0, 4, 7, '202017540397348', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3916, 8, 0, 0, 4, 7, '202017540397349', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3917, 8, 0, 0, 4, 7, '202017540397350', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3918, 8, 0, 0, 4, 7, '202017540397351', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3919, 8, 0, 0, 4, 7, '202017540397352', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3920, 8, 0, 0, 4, 7, '202017540397353', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3921, 8, 0, 0, 4, 7, '202017540397354', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3922, 8, 0, 0, 4, 7, '202017540397355', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3923, 8, 0, 0, 4, 7, '202017540397356', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3924, 8, 0, 0, 4, 7, '202017540397357', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3925, 8, 0, 0, 4, 7, '202017540397358', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3926, 8, 0, 0, 4, 7, '202017540397359', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3927, 8, 0, 0, 4, 7, '202017540397360', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3928, 8, 0, 0, 4, 7, '202017540397361', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3929, 8, 0, 0, 4, 7, '202017540397362', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3930, 8, 0, 0, 4, 7, '202017540397363', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3931, 8, 0, 0, 4, 7, '202017540397364', 30, 0, 0, 0, 1, '2020-01-07 17:40:45', 2),
(3932, 8, 0, 0, 4, 7, '202017540397365', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3933, 8, 0, 0, 4, 7, '202017540397366', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3934, 8, 0, 0, 4, 7, '202017540397367', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3935, 8, 0, 0, 4, 7, '202017540397368', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3936, 8, 0, 0, 4, 7, '202017540397369', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3937, 8, 0, 0, 4, 7, '202017540397370', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3938, 8, 0, 0, 4, 7, '202017540397371', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3939, 8, 0, 0, 4, 7, '202017540397372', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3940, 8, 0, 0, 4, 7, '202017540397373', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3941, 8, 0, 0, 4, 7, '202017540397374', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3942, 8, 0, 0, 4, 7, '202017540397375', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3943, 8, 0, 0, 4, 7, '202017540397376', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3944, 8, 0, 0, 4, 7, '202017540397377', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3945, 8, 0, 0, 4, 7, '202017540397378', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3946, 8, 0, 0, 4, 7, '202017540397379', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3947, 8, 0, 0, 4, 7, '202017540397380', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3948, 8, 0, 0, 4, 7, '202017540397381', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3949, 8, 0, 0, 4, 7, '202017540397382', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3950, 8, 0, 0, 4, 7, '202017540397383', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3951, 8, 0, 0, 4, 7, '202017540397384', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3952, 8, 0, 0, 4, 7, '202017540397385', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3953, 8, 0, 0, 4, 7, '202017540397386', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3954, 8, 0, 0, 4, 7, '202017540397387', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3955, 8, 0, 0, 4, 7, '202017540397388', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3956, 8, 0, 0, 4, 7, '202017540397389', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3957, 8, 0, 0, 4, 7, '202017540397390', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3958, 8, 0, 0, 4, 7, '202017540397391', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3959, 8, 0, 0, 4, 7, '202017540397392', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3960, 8, 0, 0, 4, 7, '202017540397393', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3961, 8, 0, 0, 4, 7, '202017540397394', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3962, 8, 0, 0, 4, 7, '202017540397395', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3963, 8, 0, 0, 4, 7, '202017540397396', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3964, 8, 0, 0, 4, 7, '202017540397397', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3965, 8, 0, 0, 4, 7, '202017540397398', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3966, 8, 0, 0, 4, 7, '202017540397399', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3967, 8, 0, 0, 4, 7, '202017540397400', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3968, 8, 0, 0, 4, 7, '202017540397401', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3969, 8, 0, 0, 4, 7, '202017540397402', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3970, 8, 0, 0, 4, 7, '202017540397403', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3971, 8, 0, 0, 4, 7, '202017540397404', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3972, 8, 0, 0, 4, 7, '202017540397405', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3973, 8, 0, 0, 4, 7, '202017540397406', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3974, 8, 0, 0, 4, 7, '202017540397407', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3975, 8, 0, 0, 4, 7, '202017540397408', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3976, 8, 0, 0, 4, 7, '202017540397409', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3977, 8, 0, 0, 4, 7, '202017540397410', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3978, 8, 0, 0, 4, 7, '202017540397411', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3979, 8, 0, 0, 4, 7, '202017540397412', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3980, 8, 0, 0, 4, 7, '202017540397413', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3981, 8, 0, 0, 4, 7, '202017540397414', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3982, 8, 0, 0, 4, 7, '202017540397415', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3983, 8, 0, 0, 4, 7, '202017540397416', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3984, 8, 0, 0, 4, 7, '202017540397417', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3985, 8, 0, 0, 4, 7, '202017540397418', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3986, 8, 0, 0, 4, 7, '202017540397419', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3987, 8, 0, 0, 4, 7, '202017540397420', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3988, 8, 0, 0, 4, 7, '202017540397421', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3989, 8, 0, 0, 4, 7, '202017540397422', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3990, 8, 0, 0, 4, 7, '202017540397423', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3991, 8, 0, 0, 4, 7, '202017540397424', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3992, 8, 0, 0, 4, 7, '202017540397425', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3993, 8, 0, 0, 4, 7, '202017540397426', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3994, 8, 0, 0, 4, 7, '202017540397427', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3995, 8, 0, 0, 4, 7, '202017540397428', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3996, 8, 0, 0, 4, 7, '202017540397429', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3997, 8, 0, 0, 4, 7, '202017540397430', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3998, 8, 0, 0, 4, 7, '202017540397431', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(3999, 8, 0, 0, 4, 7, '202017540397432', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4000, 8, 0, 0, 4, 7, '202017540397433', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4001, 8, 0, 0, 4, 7, '202017540397434', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4002, 8, 0, 0, 4, 7, '202017540397435', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4003, 8, 0, 0, 4, 7, '202017540397436', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4004, 8, 0, 0, 4, 7, '202017540397437', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4005, 8, 0, 0, 4, 7, '202017540397438', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4006, 8, 0, 0, 4, 7, '202017540397439', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4007, 8, 0, 0, 4, 7, '202017540397440', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4008, 8, 0, 0, 4, 7, '202017540397441', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4009, 8, 0, 0, 4, 7, '202017540397442', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4010, 8, 0, 0, 4, 7, '202017540397443', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4011, 8, 0, 0, 4, 7, '202017540397444', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4012, 8, 0, 0, 4, 7, '202017540397445', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4013, 8, 0, 0, 4, 7, '202017540397446', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4014, 8, 0, 0, 4, 7, '202017540397447', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4015, 8, 0, 0, 4, 7, '202017540397448', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4016, 8, 0, 0, 4, 7, '202017540397449', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4017, 8, 0, 0, 4, 7, '202017540397450', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4018, 8, 0, 0, 4, 7, '202017540397451', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4019, 8, 0, 0, 4, 7, '202017540397452', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4020, 8, 0, 0, 4, 7, '202017540397453', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4021, 8, 0, 0, 4, 7, '202017540397454', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4022, 8, 0, 0, 4, 7, '202017540397455', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4023, 8, 0, 0, 4, 7, '202017540397456', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4024, 8, 0, 0, 4, 7, '202017540397457', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4025, 8, 0, 0, 4, 7, '202017540397458', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4026, 8, 0, 0, 4, 7, '202017540397459', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4027, 8, 0, 0, 4, 7, '202017540397460', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4028, 8, 0, 0, 4, 7, '202017540397461', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4029, 8, 0, 0, 4, 7, '202017540397462', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4030, 8, 0, 0, 4, 7, '202017540397463', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4031, 8, 0, 0, 4, 7, '202017540397464', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4032, 8, 0, 0, 4, 7, '202017540397465', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4033, 8, 0, 0, 4, 7, '202017540397466', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4034, 8, 0, 0, 4, 7, '202017540397467', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4035, 8, 0, 0, 4, 7, '202017540397468', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4036, 8, 0, 0, 4, 7, '202017540397469', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4037, 8, 0, 0, 4, 7, '202017540397470', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4038, 8, 0, 0, 4, 7, '202017540397471', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4039, 8, 0, 0, 4, 7, '202017540397472', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4040, 8, 0, 0, 4, 7, '202017540397473', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4041, 8, 0, 0, 4, 7, '202017540397474', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4042, 8, 0, 0, 4, 7, '202017540397475', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4043, 8, 0, 0, 4, 7, '202017540397476', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4044, 8, 0, 0, 4, 7, '202017540397477', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4045, 8, 0, 0, 4, 7, '202017540397478', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4046, 8, 0, 0, 4, 7, '202017540397479', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4047, 8, 0, 0, 4, 7, '202017540397480', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4048, 8, 0, 0, 4, 7, '202017540397481', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4049, 8, 0, 0, 4, 7, '202017540397482', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4050, 8, 0, 0, 4, 7, '202017540397483', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4051, 8, 0, 0, 4, 7, '202017540397484', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4052, 8, 0, 0, 4, 7, '202017540397485', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4053, 8, 0, 0, 4, 7, '202017540397486', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4054, 8, 0, 0, 4, 7, '202017540397487', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4055, 8, 0, 0, 4, 7, '202017540397488', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4056, 8, 0, 0, 4, 7, '202017540397489', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4057, 8, 0, 0, 4, 7, '202017540397490', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4058, 8, 0, 0, 4, 7, '202017540397491', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4059, 8, 0, 0, 4, 7, '202017540397492', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4060, 8, 0, 0, 4, 7, '202017540397493', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4061, 8, 0, 0, 4, 7, '202017540397494', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4062, 8, 0, 0, 4, 7, '202017540397495', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4063, 8, 0, 0, 4, 7, '202017540397496', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4064, 8, 0, 0, 4, 7, '202017540397497', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4065, 8, 0, 0, 4, 7, '202017540397498', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4066, 8, 0, 0, 4, 7, '202017540397499', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4067, 8, 0, 0, 4, 7, '202017540397500', 30, 0, 0, 0, 1, '2020-01-07 17:40:46', 2),
(4068, 8, 0, 0, 4, 8, '2020175405081', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4069, 8, 0, 0, 4, 8, '2020175405082', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4070, 8, 0, 0, 4, 8, '2020175405083', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4071, 8, 0, 0, 4, 8, '2020175405084', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4072, 8, 0, 0, 4, 8, '2020175405085', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4073, 8, 0, 0, 4, 8, '2020175405086', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4074, 8, 0, 0, 4, 8, '2020175405087', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4075, 8, 0, 0, 4, 8, '2020175405088', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4076, 8, 0, 0, 4, 8, '2020175405089', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4077, 8, 0, 0, 4, 8, '20201754050810', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4078, 8, 0, 0, 4, 8, '20201754050811', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4079, 8, 0, 0, 4, 8, '20201754050812', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4080, 8, 0, 0, 4, 8, '20201754050813', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4081, 8, 0, 0, 4, 8, '20201754050814', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4082, 8, 0, 0, 4, 8, '20201754050815', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4083, 8, 0, 0, 4, 8, '20201754050816', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4084, 8, 0, 0, 4, 8, '20201754050817', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4085, 8, 0, 0, 4, 8, '20201754050818', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4086, 8, 0, 0, 4, 8, '20201754050819', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4087, 8, 0, 0, 4, 8, '20201754050820', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4088, 8, 0, 0, 4, 8, '20201754050821', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4089, 8, 0, 0, 4, 8, '20201754050822', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4090, 8, 0, 0, 4, 8, '20201754050823', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4091, 8, 0, 0, 4, 8, '20201754050824', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4092, 8, 0, 0, 4, 8, '20201754050825', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4093, 8, 0, 0, 4, 8, '20201754050826', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4094, 8, 0, 0, 4, 8, '20201754050827', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4095, 8, 0, 0, 4, 8, '20201754050828', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4096, 8, 0, 0, 4, 8, '20201754050829', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4097, 8, 0, 0, 4, 8, '20201754050830', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4098, 8, 0, 0, 4, 8, '20201754050831', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4099, 8, 0, 0, 4, 8, '20201754050832', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4100, 8, 0, 0, 4, 8, '20201754050833', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4101, 8, 0, 0, 4, 8, '20201754050834', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4102, 8, 0, 0, 4, 8, '20201754050835', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4103, 8, 0, 0, 4, 8, '20201754050836', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4104, 8, 0, 0, 4, 8, '20201754050837', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4105, 8, 0, 0, 4, 8, '20201754050838', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4106, 8, 0, 0, 4, 8, '20201754050839', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4107, 8, 0, 0, 4, 8, '20201754050840', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4108, 8, 0, 0, 4, 8, '20201754050841', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4109, 8, 0, 0, 4, 8, '20201754050842', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4110, 8, 0, 0, 4, 8, '20201754050843', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4111, 8, 0, 0, 4, 8, '20201754050844', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4112, 8, 0, 0, 4, 8, '20201754050845', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4113, 8, 0, 0, 4, 8, '20201754050846', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4114, 8, 0, 0, 4, 8, '20201754050847', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4115, 8, 0, 0, 4, 8, '20201754050848', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4116, 8, 0, 0, 4, 8, '20201754050849', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4117, 8, 0, 0, 4, 8, '20201754050850', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4118, 8, 0, 0, 4, 8, '20201754050851', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4119, 8, 0, 0, 4, 8, '20201754050852', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4120, 8, 0, 0, 4, 8, '20201754050853', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4121, 8, 0, 0, 4, 8, '20201754050854', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4122, 8, 0, 0, 4, 8, '20201754050855', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4123, 8, 0, 0, 4, 8, '20201754050856', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4124, 8, 0, 0, 4, 8, '20201754050857', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4125, 8, 0, 0, 4, 8, '20201754050858', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4126, 8, 0, 0, 4, 8, '20201754050859', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4127, 8, 0, 0, 4, 8, '20201754050860', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4128, 8, 0, 0, 4, 8, '20201754050861', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4129, 8, 0, 0, 4, 8, '20201754050862', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4130, 8, 0, 0, 4, 8, '20201754050863', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4131, 8, 0, 0, 4, 8, '20201754050864', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4132, 8, 0, 0, 4, 8, '20201754050865', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4133, 8, 0, 0, 4, 8, '20201754050866', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4134, 8, 0, 0, 4, 8, '20201754050867', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4135, 8, 0, 0, 4, 8, '20201754050868', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4136, 8, 0, 0, 4, 8, '20201754050869', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4137, 8, 0, 0, 4, 8, '20201754050870', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4138, 8, 0, 0, 4, 8, '20201754050871', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4139, 8, 0, 0, 4, 8, '20201754050872', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4140, 8, 0, 0, 4, 8, '20201754050873', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4141, 8, 0, 0, 4, 8, '20201754050874', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4142, 8, 0, 0, 4, 8, '20201754050875', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4143, 8, 0, 0, 4, 8, '20201754050876', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4144, 8, 0, 0, 4, 8, '20201754050877', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4145, 8, 0, 0, 4, 8, '20201754050878', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4146, 8, 0, 0, 4, 8, '20201754050879', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4147, 8, 0, 0, 4, 8, '20201754050880', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4148, 8, 0, 0, 4, 8, '20201754050881', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4149, 8, 0, 0, 4, 8, '20201754050882', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4150, 8, 0, 0, 4, 8, '20201754050883', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4151, 8, 0, 0, 4, 8, '20201754050884', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4152, 8, 0, 0, 4, 8, '20201754050885', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4153, 8, 0, 0, 4, 8, '20201754050886', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4154, 8, 0, 0, 4, 8, '20201754050887', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4155, 8, 0, 0, 4, 8, '20201754050888', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4156, 8, 0, 0, 4, 8, '20201754050889', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4157, 8, 0, 0, 4, 8, '20201754050890', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4158, 8, 0, 0, 4, 8, '20201754050891', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4159, 8, 0, 0, 4, 8, '20201754050892', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4160, 8, 0, 0, 4, 8, '20201754050893', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4161, 8, 0, 0, 4, 8, '20201754050894', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4162, 8, 0, 0, 4, 8, '20201754050895', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4163, 8, 0, 0, 4, 8, '20201754050896', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4164, 8, 0, 0, 4, 8, '20201754050897', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4165, 8, 0, 0, 4, 8, '20201754050898', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4166, 8, 0, 0, 4, 8, '20201754050899', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4167, 8, 0, 0, 4, 8, '202017540508100', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4168, 8, 0, 0, 4, 8, '202017540508101', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4169, 8, 0, 0, 4, 8, '202017540508102', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4170, 8, 0, 0, 4, 8, '202017540508103', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4171, 8, 0, 0, 4, 8, '202017540508104', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4172, 8, 0, 0, 4, 8, '202017540508105', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4173, 8, 0, 0, 4, 8, '202017540508106', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4174, 8, 0, 0, 4, 8, '202017540508107', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4175, 8, 0, 0, 4, 8, '202017540508108', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4176, 8, 0, 0, 4, 8, '202017540508109', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4177, 8, 0, 0, 4, 8, '202017540508110', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4178, 8, 0, 0, 4, 8, '202017540508111', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4179, 8, 0, 0, 4, 8, '202017540508112', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4180, 8, 0, 0, 4, 8, '202017540508113', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4181, 8, 0, 0, 4, 8, '202017540508114', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4182, 8, 0, 0, 4, 8, '202017540508115', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4183, 8, 0, 0, 4, 8, '202017540508116', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2);
INSERT INTO `product_stock_serialno` (`idProductserialno`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProductsize`, `serialno`, `idWhStockItem`, `idOrderallocateditems`, `idOrder`, `offer_flog`, `created_by`, `created_at`, `status`) VALUES
(4184, 8, 0, 0, 4, 8, '202017540508117', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4185, 8, 0, 0, 4, 8, '202017540508118', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4186, 8, 0, 0, 4, 8, '202017540508119', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4187, 8, 0, 0, 4, 8, '202017540508120', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4188, 8, 0, 0, 4, 8, '202017540508121', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4189, 8, 0, 0, 4, 8, '202017540508122', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4190, 8, 0, 0, 4, 8, '202017540508123', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4191, 8, 0, 0, 4, 8, '202017540508124', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4192, 8, 0, 0, 4, 8, '202017540508125', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4193, 8, 0, 0, 4, 8, '202017540508126', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4194, 8, 0, 0, 4, 8, '202017540508127', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4195, 8, 0, 0, 4, 8, '202017540508128', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4196, 8, 0, 0, 4, 8, '202017540508129', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4197, 8, 0, 0, 4, 8, '202017540508130', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4198, 8, 0, 0, 4, 8, '202017540508131', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4199, 8, 0, 0, 4, 8, '202017540508132', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4200, 8, 0, 0, 4, 8, '202017540508133', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4201, 8, 0, 0, 4, 8, '202017540508134', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4202, 8, 0, 0, 4, 8, '202017540508135', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4203, 8, 0, 0, 4, 8, '202017540508136', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4204, 8, 0, 0, 4, 8, '202017540508137', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4205, 8, 0, 0, 4, 8, '202017540508138', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4206, 8, 0, 0, 4, 8, '202017540508139', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4207, 8, 0, 0, 4, 8, '202017540508140', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4208, 8, 0, 0, 4, 8, '202017540508141', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4209, 8, 0, 0, 4, 8, '202017540508142', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4210, 8, 0, 0, 4, 8, '202017540508143', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4211, 8, 0, 0, 4, 8, '202017540508144', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4212, 8, 0, 0, 4, 8, '202017540508145', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4213, 8, 0, 0, 4, 8, '202017540508146', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4214, 8, 0, 0, 4, 8, '202017540508147', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4215, 8, 0, 0, 4, 8, '202017540508148', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4216, 8, 0, 0, 4, 8, '202017540508149', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4217, 8, 0, 0, 4, 8, '202017540508150', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4218, 8, 0, 0, 4, 8, '202017540508151', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4219, 8, 0, 0, 4, 8, '202017540508152', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4220, 8, 0, 0, 4, 8, '202017540508153', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4221, 8, 0, 0, 4, 8, '202017540508154', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4222, 8, 0, 0, 4, 8, '202017540508155', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4223, 8, 0, 0, 4, 8, '202017540508156', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4224, 8, 0, 0, 4, 8, '202017540508157', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4225, 8, 0, 0, 4, 8, '202017540508158', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4226, 8, 0, 0, 4, 8, '202017540508159', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4227, 8, 0, 0, 4, 8, '202017540508160', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4228, 8, 0, 0, 4, 8, '202017540508161', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4229, 8, 0, 0, 4, 8, '202017540508162', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4230, 8, 0, 0, 4, 8, '202017540508163', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4231, 8, 0, 0, 4, 8, '202017540508164', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4232, 8, 0, 0, 4, 8, '202017540508165', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4233, 8, 0, 0, 4, 8, '202017540508166', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4234, 8, 0, 0, 4, 8, '202017540508167', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4235, 8, 0, 0, 4, 8, '202017540508168', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4236, 8, 0, 0, 4, 8, '202017540508169', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4237, 8, 0, 0, 4, 8, '202017540508170', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4238, 8, 0, 0, 4, 8, '202017540508171', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4239, 8, 0, 0, 4, 8, '202017540508172', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4240, 8, 0, 0, 4, 8, '202017540508173', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4241, 8, 0, 0, 4, 8, '202017540508174', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4242, 8, 0, 0, 4, 8, '202017540508175', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4243, 8, 0, 0, 4, 8, '202017540508176', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4244, 8, 0, 0, 4, 8, '202017540508177', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4245, 8, 0, 0, 4, 8, '202017540508178', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4246, 8, 0, 0, 4, 8, '202017540508179', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4247, 8, 0, 0, 4, 8, '202017540508180', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4248, 8, 0, 0, 4, 8, '202017540508181', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4249, 8, 0, 0, 4, 8, '202017540508182', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4250, 8, 0, 0, 4, 8, '202017540508183', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4251, 8, 0, 0, 4, 8, '202017540508184', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4252, 8, 0, 0, 4, 8, '202017540508185', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4253, 8, 0, 0, 4, 8, '202017540508186', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4254, 8, 0, 0, 4, 8, '202017540508187', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4255, 8, 0, 0, 4, 8, '202017540508188', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4256, 8, 0, 0, 4, 8, '202017540508189', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4257, 8, 0, 0, 4, 8, '202017540508190', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4258, 8, 0, 0, 4, 8, '202017540508191', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4259, 8, 0, 0, 4, 8, '202017540508192', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4260, 8, 0, 0, 4, 8, '202017540508193', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4261, 8, 0, 0, 4, 8, '202017540508194', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4262, 8, 0, 0, 4, 8, '202017540508195', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4263, 8, 0, 0, 4, 8, '202017540508196', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4264, 8, 0, 0, 4, 8, '202017540508197', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4265, 8, 0, 0, 4, 8, '202017540508198', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4266, 8, 0, 0, 4, 8, '202017540508199', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4267, 8, 0, 0, 4, 8, '202017540508200', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4268, 8, 0, 0, 4, 8, '202017540508201', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4269, 8, 0, 0, 4, 8, '202017540508202', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4270, 8, 0, 0, 4, 8, '202017540508203', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4271, 8, 0, 0, 4, 8, '202017540508204', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4272, 8, 0, 0, 4, 8, '202017540508205', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4273, 8, 0, 0, 4, 8, '202017540508206', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4274, 8, 0, 0, 4, 8, '202017540508207', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4275, 8, 0, 0, 4, 8, '202017540508208', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4276, 8, 0, 0, 4, 8, '202017540508209', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4277, 8, 0, 0, 4, 8, '202017540508210', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4278, 8, 0, 0, 4, 8, '202017540508211', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4279, 8, 0, 0, 4, 8, '202017540508212', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4280, 8, 0, 0, 4, 8, '202017540508213', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4281, 8, 0, 0, 4, 8, '202017540508214', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4282, 8, 0, 0, 4, 8, '202017540508215', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4283, 8, 0, 0, 4, 8, '202017540508216', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4284, 8, 0, 0, 4, 8, '202017540508217', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4285, 8, 0, 0, 4, 8, '202017540508218', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4286, 8, 0, 0, 4, 8, '202017540508219', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4287, 8, 0, 0, 4, 8, '202017540508220', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4288, 8, 0, 0, 4, 8, '202017540508221', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4289, 8, 0, 0, 4, 8, '202017540508222', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4290, 8, 0, 0, 4, 8, '202017540508223', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4291, 8, 0, 0, 4, 8, '202017540508224', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4292, 8, 0, 0, 4, 8, '202017540508225', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4293, 8, 0, 0, 4, 8, '202017540508226', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4294, 8, 0, 0, 4, 8, '202017540508227', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4295, 8, 0, 0, 4, 8, '202017540508228', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4296, 8, 0, 0, 4, 8, '202017540508229', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4297, 8, 0, 0, 4, 8, '202017540508230', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4298, 8, 0, 0, 4, 8, '202017540508231', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4299, 8, 0, 0, 4, 8, '202017540508232', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4300, 8, 0, 0, 4, 8, '202017540508233', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4301, 8, 0, 0, 4, 8, '202017540508234', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4302, 8, 0, 0, 4, 8, '202017540508235', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4303, 8, 0, 0, 4, 8, '202017540508236', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4304, 8, 0, 0, 4, 8, '202017540508237', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4305, 8, 0, 0, 4, 8, '202017540508238', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4306, 8, 0, 0, 4, 8, '202017540508239', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4307, 8, 0, 0, 4, 8, '202017540508240', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4308, 8, 0, 0, 4, 8, '202017540508241', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4309, 8, 0, 0, 4, 8, '202017540508242', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4310, 8, 0, 0, 4, 8, '202017540508243', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4311, 8, 0, 0, 4, 8, '202017540508244', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4312, 8, 0, 0, 4, 8, '202017540508245', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4313, 8, 0, 0, 4, 8, '202017540508246', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4314, 8, 0, 0, 4, 8, '202017540508247', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4315, 8, 0, 0, 4, 8, '202017540508248', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4316, 8, 0, 0, 4, 8, '202017540508249', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4317, 8, 0, 0, 4, 8, '202017540508250', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4318, 8, 0, 0, 4, 8, '202017540508251', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4319, 8, 0, 0, 4, 8, '202017540508252', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4320, 8, 0, 0, 4, 8, '202017540508253', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4321, 8, 0, 0, 4, 8, '202017540508254', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4322, 8, 0, 0, 4, 8, '202017540508255', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4323, 8, 0, 0, 4, 8, '202017540508256', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4324, 8, 0, 0, 4, 8, '202017540508257', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4325, 8, 0, 0, 4, 8, '202017540508258', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4326, 8, 0, 0, 4, 8, '202017540508259', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4327, 8, 0, 0, 4, 8, '202017540508260', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4328, 8, 0, 0, 4, 8, '202017540508261', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4329, 8, 0, 0, 4, 8, '202017540508262', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4330, 8, 0, 0, 4, 8, '202017540508263', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4331, 8, 0, 0, 4, 8, '202017540508264', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4332, 8, 0, 0, 4, 8, '202017540508265', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4333, 8, 0, 0, 4, 8, '202017540508266', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4334, 8, 0, 0, 4, 8, '202017540508267', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4335, 8, 0, 0, 4, 8, '202017540508268', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4336, 8, 0, 0, 4, 8, '202017540508269', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4337, 8, 0, 0, 4, 8, '202017540508270', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4338, 8, 0, 0, 4, 8, '202017540508271', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4339, 8, 0, 0, 4, 8, '202017540508272', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4340, 8, 0, 0, 4, 8, '202017540508273', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4341, 8, 0, 0, 4, 8, '202017540508274', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4342, 8, 0, 0, 4, 8, '202017540508275', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4343, 8, 0, 0, 4, 8, '202017540508276', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4344, 8, 0, 0, 4, 8, '202017540508277', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4345, 8, 0, 0, 4, 8, '202017540508278', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4346, 8, 0, 0, 4, 8, '202017540508279', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4347, 8, 0, 0, 4, 8, '202017540508280', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4348, 8, 0, 0, 4, 8, '202017540508281', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4349, 8, 0, 0, 4, 8, '202017540508282', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4350, 8, 0, 0, 4, 8, '202017540508283', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4351, 8, 0, 0, 4, 8, '202017540508284', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4352, 8, 0, 0, 4, 8, '202017540508285', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4353, 8, 0, 0, 4, 8, '202017540508286', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4354, 8, 0, 0, 4, 8, '202017540508287', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4355, 8, 0, 0, 4, 8, '202017540508288', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4356, 8, 0, 0, 4, 8, '202017540508289', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4357, 8, 0, 0, 4, 8, '202017540508290', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4358, 8, 0, 0, 4, 8, '202017540508291', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4359, 8, 0, 0, 4, 8, '202017540508292', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4360, 8, 0, 0, 4, 8, '202017540508293', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4361, 8, 0, 0, 4, 8, '202017540508294', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4362, 8, 0, 0, 4, 8, '202017540508295', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4363, 8, 0, 0, 4, 8, '202017540508296', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4364, 8, 0, 0, 4, 8, '202017540508297', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4365, 8, 0, 0, 4, 8, '202017540508298', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4366, 8, 0, 0, 4, 8, '202017540508299', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4367, 8, 0, 0, 4, 8, '202017540508300', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4368, 8, 0, 0, 4, 8, '202017540508301', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4369, 8, 0, 0, 4, 8, '202017540508302', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4370, 8, 0, 0, 4, 8, '202017540508303', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4371, 8, 0, 0, 4, 8, '202017540508304', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4372, 8, 0, 0, 4, 8, '202017540508305', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4373, 8, 0, 0, 4, 8, '202017540508306', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4374, 8, 0, 0, 4, 8, '202017540508307', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4375, 8, 0, 0, 4, 8, '202017540508308', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4376, 8, 0, 0, 4, 8, '202017540508309', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4377, 8, 0, 0, 4, 8, '202017540508310', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4378, 8, 0, 0, 4, 8, '202017540508311', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4379, 8, 0, 0, 4, 8, '202017540508312', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4380, 8, 0, 0, 4, 8, '202017540508313', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4381, 8, 0, 0, 4, 8, '202017540508314', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4382, 8, 0, 0, 4, 8, '202017540508315', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4383, 8, 0, 0, 4, 8, '202017540508316', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4384, 8, 0, 0, 4, 8, '202017540508317', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4385, 8, 0, 0, 4, 8, '202017540508318', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4386, 8, 0, 0, 4, 8, '202017540508319', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4387, 8, 0, 0, 4, 8, '202017540508320', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4388, 8, 0, 0, 4, 8, '202017540508321', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4389, 8, 0, 0, 4, 8, '202017540508322', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4390, 8, 0, 0, 4, 8, '202017540508323', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4391, 8, 0, 0, 4, 8, '202017540508324', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4392, 8, 0, 0, 4, 8, '202017540508325', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4393, 8, 0, 0, 4, 8, '202017540508326', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4394, 8, 0, 0, 4, 8, '202017540508327', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4395, 8, 0, 0, 4, 8, '202017540508328', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4396, 8, 0, 0, 4, 8, '202017540508329', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4397, 8, 0, 0, 4, 8, '202017540508330', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4398, 8, 0, 0, 4, 8, '202017540508331', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4399, 8, 0, 0, 4, 8, '202017540508332', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4400, 8, 0, 0, 4, 8, '202017540508333', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4401, 8, 0, 0, 4, 8, '202017540508334', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4402, 8, 0, 0, 4, 8, '202017540508335', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4403, 8, 0, 0, 4, 8, '202017540508336', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4404, 8, 0, 0, 4, 8, '202017540508337', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4405, 8, 0, 0, 4, 8, '202017540508338', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4406, 8, 0, 0, 4, 8, '202017540508339', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4407, 8, 0, 0, 4, 8, '202017540508340', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4408, 8, 0, 0, 4, 8, '202017540508341', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4409, 8, 0, 0, 4, 8, '202017540508342', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4410, 8, 0, 0, 4, 8, '202017540508343', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4411, 8, 0, 0, 4, 8, '202017540508344', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4412, 8, 0, 0, 4, 8, '202017540508345', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4413, 8, 0, 0, 4, 8, '202017540508346', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4414, 8, 0, 0, 4, 8, '202017540508347', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4415, 8, 0, 0, 4, 8, '202017540508348', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4416, 8, 0, 0, 4, 8, '202017540508349', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4417, 8, 0, 0, 4, 8, '202017540508350', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4418, 8, 0, 0, 4, 8, '202017540508351', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4419, 8, 0, 0, 4, 8, '202017540508352', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4420, 8, 0, 0, 4, 8, '202017540508353', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4421, 8, 0, 0, 4, 8, '202017540508354', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4422, 8, 0, 0, 4, 8, '202017540508355', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4423, 8, 0, 0, 4, 8, '202017540508356', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4424, 8, 0, 0, 4, 8, '202017540508357', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4425, 8, 0, 0, 4, 8, '202017540508358', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4426, 8, 0, 0, 4, 8, '202017540508359', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4427, 8, 0, 0, 4, 8, '202017540508360', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4428, 8, 0, 0, 4, 8, '202017540508361', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4429, 8, 0, 0, 4, 8, '202017540508362', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4430, 8, 0, 0, 4, 8, '202017540508363', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4431, 8, 0, 0, 4, 8, '202017540508364', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4432, 8, 0, 0, 4, 8, '202017540508365', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4433, 8, 0, 0, 4, 8, '202017540508366', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4434, 8, 0, 0, 4, 8, '202017540508367', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4435, 8, 0, 0, 4, 8, '202017540508368', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4436, 8, 0, 0, 4, 8, '202017540508369', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4437, 8, 0, 0, 4, 8, '202017540508370', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4438, 8, 0, 0, 4, 8, '202017540508371', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4439, 8, 0, 0, 4, 8, '202017540508372', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4440, 8, 0, 0, 4, 8, '202017540508373', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4441, 8, 0, 0, 4, 8, '202017540508374', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4442, 8, 0, 0, 4, 8, '202017540508375', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4443, 8, 0, 0, 4, 8, '202017540508376', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4444, 8, 0, 0, 4, 8, '202017540508377', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4445, 8, 0, 0, 4, 8, '202017540508378', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4446, 8, 0, 0, 4, 8, '202017540508379', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4447, 8, 0, 0, 4, 8, '202017540508380', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4448, 8, 0, 0, 4, 8, '202017540508381', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4449, 8, 0, 0, 4, 8, '202017540508382', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4450, 8, 0, 0, 4, 8, '202017540508383', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4451, 8, 0, 0, 4, 8, '202017540508384', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4452, 8, 0, 0, 4, 8, '202017540508385', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4453, 8, 0, 0, 4, 8, '202017540508386', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4454, 8, 0, 0, 4, 8, '202017540508387', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4455, 8, 0, 0, 4, 8, '202017540508388', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4456, 8, 0, 0, 4, 8, '202017540508389', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4457, 8, 0, 0, 4, 8, '202017540508390', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4458, 8, 0, 0, 4, 8, '202017540508391', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4459, 8, 0, 0, 4, 8, '202017540508392', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4460, 8, 0, 0, 4, 8, '202017540508393', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4461, 8, 0, 0, 4, 8, '202017540508394', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4462, 8, 0, 0, 4, 8, '202017540508395', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4463, 8, 0, 0, 4, 8, '202017540508396', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4464, 8, 0, 0, 4, 8, '202017540508397', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4465, 8, 0, 0, 4, 8, '202017540508398', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4466, 8, 0, 0, 4, 8, '202017540508399', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4467, 8, 0, 0, 4, 8, '202017540508400', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4468, 8, 0, 0, 4, 8, '202017540508401', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4469, 8, 0, 0, 4, 8, '202017540508402', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4470, 8, 0, 0, 4, 8, '202017540508403', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4471, 8, 0, 0, 4, 8, '202017540508404', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4472, 8, 0, 0, 4, 8, '202017540508405', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4473, 8, 0, 0, 4, 8, '202017540508406', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4474, 8, 0, 0, 4, 8, '202017540508407', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4475, 8, 0, 0, 4, 8, '202017540508408', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4476, 8, 0, 0, 4, 8, '202017540508409', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4477, 8, 0, 0, 4, 8, '202017540508410', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4478, 8, 0, 0, 4, 8, '202017540508411', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4479, 8, 0, 0, 4, 8, '202017540508412', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4480, 8, 0, 0, 4, 8, '202017540508413', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4481, 8, 0, 0, 4, 8, '202017540508414', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4482, 8, 0, 0, 4, 8, '202017540508415', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4483, 8, 0, 0, 4, 8, '202017540508416', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4484, 8, 0, 0, 4, 8, '202017540508417', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4485, 8, 0, 0, 4, 8, '202017540508418', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4486, 8, 0, 0, 4, 8, '202017540508419', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4487, 8, 0, 0, 4, 8, '202017540508420', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4488, 8, 0, 0, 4, 8, '202017540508421', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4489, 8, 0, 0, 4, 8, '202017540508422', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4490, 8, 0, 0, 4, 8, '202017540508423', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4491, 8, 0, 0, 4, 8, '202017540508424', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4492, 8, 0, 0, 4, 8, '202017540508425', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4493, 8, 0, 0, 4, 8, '202017540508426', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4494, 8, 0, 0, 4, 8, '202017540508427', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4495, 8, 0, 0, 4, 8, '202017540508428', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4496, 8, 0, 0, 4, 8, '202017540508429', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4497, 8, 0, 0, 4, 8, '202017540508430', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4498, 8, 0, 0, 4, 8, '202017540508431', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4499, 8, 0, 0, 4, 8, '202017540508432', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4500, 8, 0, 0, 4, 8, '202017540508433', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4501, 8, 0, 0, 4, 8, '202017540508434', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4502, 8, 0, 0, 4, 8, '202017540508435', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4503, 8, 0, 0, 4, 8, '202017540508436', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4504, 8, 0, 0, 4, 8, '202017540508437', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4505, 8, 0, 0, 4, 8, '202017540508438', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4506, 8, 0, 0, 4, 8, '202017540508439', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4507, 8, 0, 0, 4, 8, '202017540508440', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4508, 8, 0, 0, 4, 8, '202017540508441', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4509, 8, 0, 0, 4, 8, '202017540508442', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4510, 8, 0, 0, 4, 8, '202017540508443', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4511, 8, 0, 0, 4, 8, '202017540508444', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4512, 8, 0, 0, 4, 8, '202017540508445', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4513, 8, 0, 0, 4, 8, '202017540508446', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4514, 8, 0, 0, 4, 8, '202017540508447', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4515, 8, 0, 0, 4, 8, '202017540508448', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4516, 8, 0, 0, 4, 8, '202017540508449', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4517, 8, 0, 0, 4, 8, '202017540508450', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4518, 8, 0, 0, 4, 8, '202017540508451', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4519, 8, 0, 0, 4, 8, '202017540508452', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4520, 8, 0, 0, 4, 8, '202017540508453', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4521, 8, 0, 0, 4, 8, '202017540508454', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4522, 8, 0, 0, 4, 8, '202017540508455', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4523, 8, 0, 0, 4, 8, '202017540508456', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4524, 8, 0, 0, 4, 8, '202017540508457', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4525, 8, 0, 0, 4, 8, '202017540508458', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4526, 8, 0, 0, 4, 8, '202017540508459', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4527, 8, 0, 0, 4, 8, '202017540508460', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4528, 8, 0, 0, 4, 8, '202017540508461', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4529, 8, 0, 0, 4, 8, '202017540508462', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4530, 8, 0, 0, 4, 8, '202017540508463', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4531, 8, 0, 0, 4, 8, '202017540508464', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4532, 8, 0, 0, 4, 8, '202017540508465', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4533, 8, 0, 0, 4, 8, '202017540508466', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4534, 8, 0, 0, 4, 8, '202017540508467', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4535, 8, 0, 0, 4, 8, '202017540508468', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4536, 8, 0, 0, 4, 8, '202017540508469', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4537, 8, 0, 0, 4, 8, '202017540508470', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4538, 8, 0, 0, 4, 8, '202017540508471', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4539, 8, 0, 0, 4, 8, '202017540508472', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4540, 8, 0, 0, 4, 8, '202017540508473', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4541, 8, 0, 0, 4, 8, '202017540508474', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4542, 8, 0, 0, 4, 8, '202017540508475', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4543, 8, 0, 0, 4, 8, '202017540508476', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4544, 8, 0, 0, 4, 8, '202017540508477', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4545, 8, 0, 0, 4, 8, '202017540508478', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4546, 8, 0, 0, 4, 8, '202017540508479', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4547, 8, 0, 0, 4, 8, '202017540508480', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4548, 8, 0, 0, 4, 8, '202017540508481', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4549, 8, 0, 0, 4, 8, '202017540508482', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4550, 8, 0, 0, 4, 8, '202017540508483', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4551, 8, 0, 0, 4, 8, '202017540508484', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4552, 8, 0, 0, 4, 8, '202017540508485', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4553, 8, 0, 0, 4, 8, '202017540508486', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4554, 8, 0, 0, 4, 8, '202017540508487', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4555, 8, 0, 0, 4, 8, '202017540508488', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4556, 8, 0, 0, 4, 8, '202017540508489', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4557, 8, 0, 0, 4, 8, '202017540508490', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4558, 8, 0, 0, 4, 8, '202017540508491', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4559, 8, 0, 0, 4, 8, '202017540508492', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4560, 8, 0, 0, 4, 8, '202017540508493', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4561, 8, 0, 0, 4, 8, '202017540508494', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4562, 8, 0, 0, 4, 8, '202017540508495', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4563, 8, 0, 0, 4, 8, '202017540508496', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4564, 8, 0, 0, 4, 8, '202017540508497', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4565, 8, 0, 0, 4, 8, '202017540508498', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4566, 8, 0, 0, 4, 8, '202017540508499', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2),
(4567, 8, 0, 0, 4, 8, '202017540508500', 31, 0, 0, 0, 1, '2020-01-07 17:40:58', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_territory_details`
--

CREATE TABLE `product_territory_details` (
  `idProductTerritory` int(11) NOT NULL,
  `idProduct` int(11) DEFAULT NULL,
  `idTerritory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_territory_details`
--

INSERT INTO `product_territory_details` (`idProductTerritory`, `idProduct`, `idTerritory`) VALUES
(25, 3, 8),
(26, 3, 9),
(27, 3, 10),
(28, 3, 11),
(29, 3, 12),
(30, 3, 13),
(85, 2, 8),
(86, 2, 9),
(87, 2, 10),
(88, 2, 11),
(89, 2, 12),
(90, 2, 13),
(104, 4, 8),
(105, 4, 9),
(106, 4, 10),
(107, 4, 11),
(108, 4, 12),
(109, 4, 13),
(117, 1, 8),
(118, 1, 9),
(119, 1, 10),
(120, 1, 11),
(121, 1, 12),
(122, 1, 13),
(123, 1, 14);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `idQuestion` int(11) NOT NULL,
  `questionType` int(11) NOT NULL COMMENT '1=theory, 2=Options',
  `question` varchar(500) NOT NULL,
  `option1` varchar(500) NOT NULL DEFAULT '0',
  `option2` varchar(500) NOT NULL DEFAULT '0',
  `option3` varchar(500) NOT NULL DEFAULT '0',
  `option4` varchar(500) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL COMMENT '1=Active, 2=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`idQuestion`, `questionType`, `question`, `option1`, `option2`, `option3`, `option4`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 2, 'Is your product delivered on time?', 'Yes', 'No', '0', '0', 1, NULL, 1, 1),
(2, 1, 'what are the  benefits  of this product?', '0', '0', '0', '0', 1, '2019-12-31 10:30:35', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_hierarchy`
--

CREATE TABLE `sales_hierarchy` (
  `idSaleshierarchy` int(11) NOT NULL,
  `saleshierarchyType` varchar(100) DEFAULT NULL,
  `saleshierarchyName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales_hierarchy`
--

INSERT INTO `sales_hierarchy` (`idSaleshierarchy`, `saleshierarchyType`, `saleshierarchyName`) VALUES
(1, 'S1', 'S1'),
(2, 'S2', 'S2'),
(3, 'S3', 'S3'),
(4, 'S4', NULL),
(5, 'S5', NULL),
(6, 'S6', NULL),
(7, 'S7', NULL),
(8, 'S8', NULL),
(9, 'S9', NULL),
(10, 'S10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scheme`
--

CREATE TABLE `scheme` (
  `idScheme` int(11) NOT NULL,
  `schemeType` int(11) NOT NULL,
  `idCustomerType` int(11) NOT NULL,
  `schemeStartdate` date NOT NULL,
  `schemeEnddate` date NOT NULL,
  `idCategory` int(11) NOT NULL,
  `idCustomer` int(11) DEFAULT NULL,
  `schemeApplicable` int(1) DEFAULT NULL COMMENT '1-Standard,2-customized',
  `idSubCategory` int(11) NOT NULL,
  `idTerritory` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `scheme_product_size` int(11) NOT NULL,
  `scheme_product_qty` int(11) NOT NULL,
  `free_product_size` int(11) DEFAULT NULL,
  `free_product_qty` int(11) DEFAULT NULL,
  `free_product` int(11) DEFAULT NULL,
  `discount_type` int(1) DEFAULT NULL COMMENT '1-Flat,2-Percentage',
  `scheme_flat_discount` varchar(10) DEFAULT NULL,
  `scheme_note` varchar(255) DEFAULT NULL,
  `scheme_terms_conditions` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scheme`
--

INSERT INTO `scheme` (`idScheme`, `schemeType`, `idCustomerType`, `schemeStartdate`, `schemeEnddate`, `idCategory`, `idCustomer`, `schemeApplicable`, `idSubCategory`, `idTerritory`, `idProduct`, `scheme_product_size`, `scheme_product_qty`, `free_product_size`, `free_product_qty`, `free_product`, `discount_type`, `scheme_flat_discount`, `scheme_note`, `scheme_terms_conditions`, `created_by`, `created_at`) VALUES
(1, 1, 1, '2019-12-26', '2019-12-31', 1, 0, 1, 1, 8, 1, 1, 10, 0, 0, 0, 2, '10', '', '', 1, '2019-12-26 16:28:25'),
(2, 1, 1, '2019-12-26', '2019-12-31', 1, 0, 1, 1, 8, 1, 2, 10, 0, 0, 0, 2, '10.5', '', '', 1, '2019-12-26 16:28:25'),
(3, 1, 1, '2019-12-26', '2019-12-31', 1, 0, 1, 1, 8, 4, 1, 10, 0, 0, 0, 2, '12', '', '', 1, '2019-12-26 16:28:25'),
(4, 1, 1, '2019-12-26', '2019-12-31', 1, 0, 1, 1, 8, 4, 2, 10, 0, 0, 0, 2, '20', '', '', 1, '2019-12-26 16:28:25'),
(5, 1, 1, '2019-12-26', '2019-12-31', 1, 0, 1, 1, 8, 2, 1, 10, 0, 0, 0, 2, '20.5', '', '', 1, '2019-12-26 16:28:25'),
(6, 1, 1, '2019-12-26', '2019-12-31', 2, 0, 1, 2, 8, 3, 5, 10, 0, 0, 0, 2, '21.5', '', '', 1, '2019-12-26 16:28:26'),
(7, 1, 2, '2020-01-01', '2020-01-30', 1, 12, 2, 1, 8, 4, 7, 5, NULL, NULL, NULL, 1, '5', NULL, NULL, 1, '2020-01-14 10:19:50'),
(8, 1, 1, '2020-01-01', '2020-01-30', 1, 5, 2, 1, 8, 2, 3, 5, NULL, NULL, NULL, 1, '5', NULL, NULL, 1, '2020-01-14 10:24:47'),
(9, 1, 1, '2020-01-01', '2020-01-22', 2, 7, 2, 2, 8, 3, 5, 10, NULL, NULL, NULL, 1, '3', 'discount', 'discount', 1, '2020-01-20 10:53:01');

-- --------------------------------------------------------

--
-- Table structure for table `secondary_packaging`
--

CREATE TABLE `secondary_packaging` (
  `idSecondaryPackaging` int(11) NOT NULL,
  `idPrimaryPackaging` int(11) NOT NULL,
  `secondarypackname` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idSubPackaging` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secondary_packaging`
--

INSERT INTO `secondary_packaging` (`idSecondaryPackaging`, `idPrimaryPackaging`, `secondarypackname`, `idSubPackaging`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'Containers', 1, 1, '2019-12-04 10:25:10', 1, '2019-12-04 10:25:10', 1),
(2, 1, 'Test', 1, 2, '2020-01-13 12:20:30', 1, '2020-01-13 12:20:30', 1),
(3, 1, 'SP1', 1, 1, '2020-01-20 11:20:36', 1, '2020-01-20 11:20:36', 1),
(4, 1, 'SP2', 1, 2, '2020-01-20 11:22:42', 1, '2020-01-20 11:22:42', 1),
(5, 1, 'SP3', 1, 2, '2020-01-20 11:22:42', 1, '2020-01-20 11:22:42', 1),
(6, 1, 'SP4', 1, 2, '2020-01-20 11:22:42', 1, '2020-01-20 11:22:42', 1),
(7, 1, 'SP5', 1, 2, '2020-01-20 11:22:42', 1, '2020-01-20 11:22:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `segment_type`
--

CREATE TABLE `segment_type` (
  `idsegmentType` int(11) NOT NULL,
  `segmentName` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `segment_type`
--

INSERT INTO `segment_type` (`idsegmentType`, `segmentName`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Premium', 1, '2019-12-04 10:19:09', 1, '2019-12-04 10:19:09', 1),
(2, 'VIP', 1, '2019-12-07 18:16:08', 1, '2019-12-07 18:16:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `serialno_picklist`
--

CREATE TABLE `serialno_picklist` (
  `idSerialnopicklist` int(11) NOT NULL,
  `idOrderallocated` int(11) NOT NULL,
  `idOrderallocateitem` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProductsize` int(11) NOT NULL,
  `pickQty` int(11) NOT NULL,
  `pickSerialno` text,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_class`
--

CREATE TABLE `service_class` (
  `idServiceClass` int(11) NOT NULL,
  `serviceClass` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active,2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_master`
--

CREATE TABLE `service_master` (
  `idService` int(11) NOT NULL,
  `serviceCat` int(11) DEFAULT NULL,
  `serviceSubcat` int(11) DEFAULT NULL,
  `serviceName` varchar(50) DEFAULT NULL,
  `serviceUnit` int(11) DEFAULT NULL,
  `serviceNature` int(11) DEFAULT NULL,
  `serviceFrequecy` int(11) DEFAULT NULL,
  `serviceSeason` int(11) DEFAULT NULL,
  `serviceClass` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_partner`
--

CREATE TABLE `service_partner` (
  `idServicePartner` int(11) NOT NULL,
  `ContactName` varchar(64) NOT NULL,
  `ContactEmail` varchar(64) NOT NULL,
  `ContactMobile` varchar(16) NOT NULL,
  `g1` int(11) NOT NULL,
  `g2` int(11) NOT NULL,
  `g3` int(11) NOT NULL,
  `g4` int(11) NOT NULL,
  `g5` int(11) NOT NULL,
  `g6` int(11) NOT NULL,
  `g7` int(11) NOT NULL,
  `g8` int(11) NOT NULL,
  `g9` int(11) NOT NULL,
  `g10` int(11) NOT NULL,
  `t1` int(11) NOT NULL,
  `t2` int(11) NOT NULL,
  `t3` int(11) NOT NULL,
  `t4` int(11) NOT NULL,
  `t5` int(11) NOT NULL,
  `t6` int(11) NOT NULL,
  `t7` int(11) NOT NULL,
  `t8` int(11) NOT NULL,
  `t9` int(11) NOT NULL,
  `t10` int(11) NOT NULL,
  `ServiceRendered` varchar(50) NOT NULL,
  `ServicePartner` varchar(50) NOT NULL,
  `ServiceCategory` text NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `idSubCategory` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  `subcategory` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active,2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`idSubCategory`, `idCategory`, `subcategory`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'Soap', 1, '2019-12-04 10:02:34', 1, NULL, NULL),
(2, 2, 'Electronics', 1, '2019-12-05 11:03:55', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subsidarygroup_master`
--

CREATE TABLE `subsidarygroup_master` (
  `idSubsidaryGroup` int(11) NOT NULL,
  `idMainGroup` int(11) NOT NULL,
  `idSubsidiariestype` int(11) NOT NULL COMMENT '1=sub-companies, 2=Subsidiaries,3=Divisions',
  `subsidaryName` varchar(50) NOT NULL,
  `proposition` int(1) NOT NULL COMMENT '1=Product;2=Service;3=Product and service',
  `segment` int(1) NOT NULL COMMENT '1=Consumer;2=Business;3=Consumer and business',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'userId',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0' COMMENT 'userId',
  `status` int(1) NOT NULL COMMENT '1=Active,2=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subsidarygroup_master`
--

INSERT INTO `subsidarygroup_master` (`idSubsidaryGroup`, `idMainGroup`, `idSubsidiariestype`, `subsidaryName`, `proposition`, `segment`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, 1, 'BB One', 1, 2, '2019-12-04 09:31:18', 1, NULL, 0, 1),
(2, 1, 2, 'BB two', 1, 2, '2019-12-12 12:55:59', 1, NULL, 0, 1),
(3, 1, 1, 'BB 3', 1, 1, '2019-12-18 11:36:20', 1, '2019-12-18 11:36:20', 1, 1),
(4, 1, 1, 'BB 4', 1, 1, '2019-12-18 11:40:16', 1, '2019-12-20 18:59:28', 1, 2),
(5, 1, 3, 'BB FIVE', 1, 2, '2019-12-26 17:03:40', 1, '2019-12-26 17:04:12', 1, 1),
(6, 1, 2, 'test one', 1, 1, '2020-01-04 10:34:49', 1, '2020-01-04 10:34:58', 1, 1),
(7, 1, 2, 'BB 88', 3, 3, '2020-01-07 11:20:16', 1, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_packaging`
--

CREATE TABLE `sub_packaging` (
  `idSubPackaging` int(11) NOT NULL,
  `subpackname` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_packaging`
--

INSERT INTO `sub_packaging` (`idSubPackaging`, `subpackname`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Plastic', 1, '2019-12-04 10:23:24', 1, NULL, NULL),
(2, 'Covers', 1, '2019-12-04 10:23:34', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sys_config`
--

CREATE TABLE `sys_config` (
  `idSysconfig` int(11) NOT NULL,
  `companyLogo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `currencyName` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `companyName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `companyLandline` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `companyAddress` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `companyWebsite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sys_config`
--

INSERT INTO `sys_config` (`idSysconfig`, `companyLogo`, `currencyName`, `companyName`, `companyLandline`, `companyAddress`, `companyWebsite`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'logo_2312191043.jpg', 'INR', 'safe harvest', '0807777777777', '90/91, Ganesh Temple Rd, Sarakki Gate, Gangadhar Nagar, 1st Phase, J. P. Nagar, Bengaluru, Karnataka 560078', 'www.safeharvest.co.in', 1, '2020-01-08 12:34:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `taxheads_details`
--

CREATE TABLE `taxheads_details` (
  `idTaxheads` int(11) NOT NULL,
  `taxheadsName` varchar(50) DEFAULT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tax_split`
--

CREATE TABLE `tax_split` (
  `idTaxSplit` int(11) NOT NULL,
  `taxtype` varchar(35) NOT NULL,
  `cgst` varchar(35) NOT NULL,
  `sgst` varchar(35) NOT NULL,
  `igst` varchar(35) NOT NULL,
  `utgst` varchar(35) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax_split`
--

INSERT INTO `tax_split` (`idTaxSplit`, `taxtype`, `cgst`, `sgst`, `igst`, `utgst`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, '1', '30', '20', '20', '30', '2019-12-04 10:28:23', 1, NULL, NULL),
(2, '2', '0', '50', '50', '0', '2019-12-04 10:28:23', 1, NULL, NULL),
(3, '3', '50', '0', '50', '0', '2019-12-04 10:28:23', 1, NULL, NULL),
(4, '4', '0', '50', '0', '50', '2019-12-04 10:28:23', 1, NULL, NULL),
(5, '5', '0', '50', '50', '0', '2019-12-04 10:28:23', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_member_allocation`
--

CREATE TABLE `team_member_allocation` (
  `allocation_id` int(11) NOT NULL,
  `team_member_id` int(10) NOT NULL,
  `territory_id` int(10) NOT NULL,
  `subterritory_ids` text NOT NULL,
  `channel_id` text NOT NULL COMMENT '1-General Trade 2-Modern Trade 3-Online 4-B2C Direct 5-B2B 6-Government 7-Institutions 8-Franchisee 9-Own',
  `category_id` text NOT NULL,
  `customer_ids` text NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_member_allocation`
--

INSERT INTO `team_member_allocation` (`allocation_id`, `team_member_id`, `territory_id`, `subterritory_ids`, `channel_id`, `category_id`, `customer_ids`, `created_by`, `created_at`) VALUES
(1, 2, 4, '8,9,10,11,12,13', '1,2,3,4', '1,2', '2,4', 1, '2019-12-13 14:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `team_member_groups`
--

CREATE TABLE `team_member_groups` (
  `tm_group_id` int(11) NOT NULL,
  `tm_group_name` varchar(255) NOT NULL,
  `created_by` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `team_member_master`
--

CREATE TABLE `team_member_master` (
  `idTeamMember` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mobileno` varchar(10) NOT NULL,
  `landline` varchar(15) NOT NULL,
  `emailId` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `designation` varchar(50) NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `imsi_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `imsi_reset` int(1) NOT NULL DEFAULT '0' COMMENT '1=Yes | 0=No',
  `photo` text,
  `isRepManager` int(1) NOT NULL COMMENT '1=Yes;2=No',
  `reportingTo` int(11) DEFAULT '0',
  `reportingTo2` int(11) DEFAULT '0',
  `reportingTo3` int(11) DEFAULT '0',
  `idMainGroup` int(1) NOT NULL,
  `idSubsidaryGroup` int(11) NOT NULL,
  `proposition` int(1) NOT NULL COMMENT '1=Product;2=Service;3=Product and service',
  `segment` int(1) NOT NULL COMMENT '1=Consumer;2=Business;3=Consumer and business',
  `t1` int(11) NOT NULL DEFAULT '0',
  `t2` int(11) NOT NULL DEFAULT '0',
  `t3` int(11) NOT NULL DEFAULT '0',
  `t4` int(11) NOT NULL DEFAULT '0',
  `t5` int(11) NOT NULL DEFAULT '0',
  `t6` int(11) NOT NULL DEFAULT '0',
  `t7` int(11) NOT NULL DEFAULT '0',
  `t8` int(11) NOT NULL DEFAULT '0',
  `t9` int(11) NOT NULL DEFAULT '0',
  `t10` int(11) NOT NULL DEFAULT '0',
  `idSaleshierarchy` int(11) NOT NULL DEFAULT '0',
  `idLevel` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_member_master`
--

INSERT INTO `team_member_master` (`idTeamMember`, `code`, `name`, `mobileno`, `landline`, `emailId`, `address`, `designation`, `username`, `password`, `imsi_number`, `imsi_reset`, `photo`, `isRepManager`, `reportingTo`, `reportingTo2`, `reportingTo3`, `idMainGroup`, `idSubsidaryGroup`, `proposition`, `segment`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `idSaleshierarchy`, `idLevel`, `created_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 'EMP101', 'Kiran kumar NS', '6565464658', '9655465464454', 'kiran@gmail.com', 'north usman road, t nagar', '1', 'priya', '$2y$10$2WSc5.WYW/fi2/.zh8Z14OP2IszMptCm5u3KTPtaPTEY0UJi9n4X2', '405869005204967', 0, 'employee_1201219142129.jpg', 1, 0, 0, 0, 1, 1, 1, 2, 1, 5, 7, 13, 0, 0, 0, 0, 0, 0, 1, 1, '2019-12-04 10:15:53', 1, 1, 1),
(2, 'EMP102', 'Priya', '5454564654', '5445646544644', 'priya@gmail.com', 'north street ', '1', 'sathiya', '$2y$10$2WSc5.WYW/fi2/.zh8Z14OP2IszMptCm5u3KTPtaPTEY0UJi9n4X2', NULL, 0, 'employee_2191219182125.jpg', 1, 1, 0, 0, 1, 1, 1, 2, 1, 4, 6, 11, 0, 0, 0, 0, 0, 0, 1, 1, '2019-12-13 11:43:35', 1, 1, 1),
(3, 'EMP103', 'Raja', '8569742365', '5449781348415', 'ram@gmail.com', 'north street', '1', 'raja', '$2y$10$rHu.36NCJPE7POMcGa5Xeu2CayE2kbK0qQ3PkAtVclG5PIfYIcKeu', NULL, 0, NULL, 1, 1, 0, 0, 1, 1, 1, 2, 1, 5, 7, 13, 0, 0, 0, 0, 0, 0, 1, 1, '2019-12-19 18:23:17', 1, 1, 1),
(4, 'EMP107', 'Kumaran', '9889898456', '9856351654435', 'mail2rahul7@gmail.com', 'dfgdfgd', '2', 'kumaran', '$2y$10$LbXR.KxE./GWakqBu9mHseBEEpQrR0pLzQxMXiA10LepfMrF/r9Su', NULL, 0, NULL, 1, 2, 0, 0, 1, 2, 1, 2, 1, 4, 6, 11, 0, 0, 0, 0, 0, 0, 1, 1, '2019-12-19 18:24:16', 1, 1, 1),
(5, 'EMP104', 'Kannan', '4635636346', '5436345634643', 'kannan@gmail.com', 'north st', '1', 'kannan', '$2y$10$c8GJEkuuZ6kS.7IMscK.deva6XQDOxl4/B.r3j3s1hpoU2sYdjIQm', NULL, 0, NULL, 2, 2, 0, 0, 1, 1, 1, 2, 1, 2, 3, 9, 0, 0, 0, 0, 0, 0, 1, 1, '2019-12-21 16:17:39', 1, 1, 1),
(6, 'EMP105', 'vijay', '5676353223', '7745634548586', 'vijay@gmail.com', 'north st', '1', 'vijay123', '$2y$10$3E/hDicpbZ2X1SZDzKP8EeEEgOGUNUa81kRaX8hhtj17FClqNCnPu', NULL, 0, NULL, 1, 4, 0, 0, 1, 1, 1, 2, 1, 4, 6, 10, 0, 0, 0, 0, 0, 0, 1, 1, '2019-12-21 17:59:01', 1, 1, 1),
(7, 'EMP106', 'Ragul', '8784553132', '2312313246545', 'Ragul@gmail.com', 'north st', '1', NULL, NULL, NULL, 0, NULL, 1, 1, 0, 0, 1, 2, 1, 2, 1, 5, 7, 13, 0, 0, 0, 0, 0, 0, 1, 1, '2019-12-24 09:31:41', 1, 1, 1),
(8, 'EMP108', 'Prabha', '9996565455', '9845612369285', 'abc@gmail.com', 'Chennai', '2', NULL, NULL, NULL, 0, '0', 2, 0, 0, 0, 1, 5, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2019-12-26 17:42:36', 1, 1, 1),
(9, 'EMP109', 'Nivi', '9878786456', '5456465456452', 'nivi@gmail.com', 'Chennai', '1', 'nivi', '$2y$10$7LKoa7kpIYRu714QldNGIO4qMFm8929f2bfuu9QB2R8os72QydeSO', NULL, 0, '0', 1, 0, 0, 0, 1, 5, 1, 2, 1, 4, 6, 11, 0, 0, 0, 0, 0, 0, 1, 1, '2019-12-26 18:13:32', 1, 1, 1),
(10, 'EMP110', 'muthu', '9878546565', '9856465456454', 'muthu@gmail.com', 'chennai', '1', 'vijay', '$2y$10$fgB80PEG5ndCJCOJDsARsuVPO7exXvvI07ZVFrj2ZxUZD.4F7nwC6', NULL, 0, NULL, 1, 0, 0, 0, 1, 2, 1, 2, 1, 5, 7, 12, 0, 0, 0, 0, 0, 0, 2, 1, '2019-12-26 18:28:20', 1, 1, 1),
(11, 'EMP444', 'Ragunath', '9871516464', '2145645646546', 'ragunath@gmail.com', 'north street', '1', NULL, NULL, NULL, 0, NULL, 1, 10, 3, 6, 1, 1, 1, 2, 1, 4, 6, 11, 0, 0, 0, 0, 0, 0, 1, 1, '2020-01-10 16:53:39', 1, 1, 1),
(12, 'EMP445', 'Ranjith', '2116848465', '3453464654546', 'ranjith@gmail.com', 'youth street', '1', NULL, NULL, NULL, 0, NULL, 2, 6, 4, 7, 1, 1, 1, 2, 1, 5, 7, 13, 0, 0, 0, 0, 0, 0, 2, 1, '2020-01-10 16:56:13', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `territorymapping_master`
--

CREATE TABLE `territorymapping_master` (
  `idTerritoryMapping` int(11) NOT NULL,
  `t1` int(11) DEFAULT NULL,
  `t2` int(11) DEFAULT NULL,
  `t3` int(11) DEFAULT NULL,
  `t4` int(11) DEFAULT NULL,
  `t5` int(11) DEFAULT NULL,
  `t6` int(11) DEFAULT NULL,
  `t7` int(11) DEFAULT NULL,
  `t8` int(11) DEFAULT NULL,
  `t9` int(11) DEFAULT NULL,
  `t10` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `territorymapping_master`
--

INSERT INTO `territorymapping_master` (`idTerritoryMapping`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 2, 3, 8, 16, 17, 0, 0, 0, 0, '2019-12-03 18:50:01', 1, '2020-01-20 11:26:29', 1),
(2, 1, 4, 6, 10, 0, 0, 0, 0, 0, 0, '2019-12-04 10:00:38', 1, '2019-12-04 10:00:38', 1),
(3, 1, 5, 7, 12, 0, 0, 0, 0, 0, 0, '2019-12-04 10:00:52', 1, '2019-12-04 10:00:52', 1),
(4, 1, 2, 3, 9, 0, 0, 0, 0, 0, 0, '2019-12-04 10:01:02', 1, '2019-12-04 10:01:02', 1),
(5, 1, 4, 6, 11, 0, 0, 0, 0, 0, 0, '2019-12-04 10:01:17', 1, '2019-12-04 10:01:17', 1),
(6, 1, 5, 7, 13, 0, 0, 0, 0, 0, 0, '2019-12-04 10:01:41', 1, '2019-12-04 10:01:41', 1),
(7, 1, 2, 3, 13, 0, 0, 0, 0, 0, 0, '2019-12-09 10:36:41', 1, '2019-12-09 10:36:41', 1),
(8, 1, 15, 7, 9, 0, 0, 0, 0, 0, 0, '2020-01-13 11:42:32', 1, '2020-01-13 11:42:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `territorytitle_master`
--

CREATE TABLE `territorytitle_master` (
  `idTerritoryTitle` int(11) NOT NULL,
  `hierarchy` varchar(10) DEFAULT NULL COMMENT 'H1,H2,...H10',
  `title` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `territorytitle_master`
--

INSERT INTO `territorytitle_master` (`idTerritoryTitle`, `hierarchy`, `title`) VALUES
(1, 'H1', 'Country'),
(2, 'H2', 'State'),
(3, 'H3', 'City'),
(4, 'H4', 'Pincode'),
(5, 'H5', 'Area'),
(6, 'H6', 'Street'),
(7, 'H7', NULL),
(8, 'H8', NULL),
(9, 'H9', NULL),
(10, 'H10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `territory_master`
--

CREATE TABLE `territory_master` (
  `idTerritory` int(11) NOT NULL,
  `idTerritoryTitle` int(11) NOT NULL,
  `territoryCode` varchar(15) NOT NULL,
  `territoryValue` varchar(30) NOT NULL,
  `territoryUnion` int(11) DEFAULT NULL,
  `status` int(50) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `territory_master`
--

INSERT INTO `territory_master` (`idTerritory`, `idTerritoryTitle`, `territoryCode`, `territoryValue`, `territoryUnion`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'IND101', 'India', 2, 1, '2020-01-04 10:37:15', 1, '2020-01-04 10:37:15', 1),
(2, 2, 'TN102', 'Tamilnadu', 2, 1, '2019-12-04 09:49:40', 1, '2019-12-04 09:49:40', 1),
(3, 3, 'CHN103', 'Chennai', 2, 1, '2019-12-04 09:49:48', 1, '2019-12-04 09:49:48', 1),
(4, 2, 'KRN104', 'Karnataka', 2, 1, '2019-12-04 09:50:19', 1, '2019-12-04 09:50:19', 1),
(5, 2, 'PND105', 'Pondicherry', 1, 1, '2019-12-04 09:50:40', 1, '2019-12-04 09:50:40', 1),
(6, 3, 'BNG106', 'Bangalore', 2, 1, '2019-12-04 09:55:47', 1, '2019-12-04 09:55:47', 1),
(7, 3, 'KRL107', 'Karaikkal', 2, 1, '2019-12-04 09:56:09', 1, '2019-12-04 09:56:09', 1),
(8, 4, 'PIN109', '600018', 2, 1, '2019-12-04 09:56:52', 1, '2019-12-04 09:56:52', 1),
(9, 4, 'PIN110', '600024', 2, 1, '2019-12-04 09:58:27', 1, '2019-12-04 09:58:27', 1),
(10, 4, 'PIN111', '500501', 2, 1, '2019-12-04 09:58:50', 1, '2019-12-04 09:58:50', 1),
(11, 4, 'PIN112', '500502', 2, 1, '2019-12-04 09:59:05', 1, '2019-12-04 09:59:05', 1),
(12, 4, 'PIN113', '609601', 2, 1, '2019-12-04 09:59:31', 1, '2019-12-04 09:59:31', 1),
(13, 4, 'PIN114', '609602', 2, 1, '2019-12-04 09:59:54', 1, '2019-12-04 09:59:54', 1),
(14, 4, 'PIN574', '608704', 2, 1, '2020-01-07 11:22:55', 1, '2020-01-07 11:22:55', 1),
(15, 2, '12356', 'Andra', 2, 1, '2020-01-13 11:42:19', 1, '2020-01-13 11:42:19', 1),
(16, 5, 'AR101', 'Ram nagar', 2, 1, '2020-01-20 11:25:20', 1, '2020-01-20 11:25:20', 1),
(17, 6, 'ST101', 'Seethammal colony', 2, 1, '2020-01-20 11:26:20', 1, '2020-01-20 11:26:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transporter_master`
--

CREATE TABLE `transporter_master` (
  `idTransporter` int(11) NOT NULL,
  `transporterName` varchar(30) NOT NULL,
  `transporterMobileNo` varchar(15) NOT NULL,
  `t1` int(11) DEFAULT NULL,
  `t2` int(11) DEFAULT NULL,
  `t3` int(11) DEFAULT NULL,
  `t4` int(11) DEFAULT NULL,
  `t5` int(11) DEFAULT NULL,
  `t6` int(11) DEFAULT NULL,
  `t7` int(11) DEFAULT NULL,
  `t8` int(11) DEFAULT NULL,
  `t9` int(11) DEFAULT NULL,
  `t10` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active;2=Inactive',
  `transporterName1` varchar(50) DEFAULT NULL,
  `transporterMobile1` varchar(15) DEFAULT NULL,
  `transporterMail1` varchar(50) DEFAULT NULL,
  `transporterName2` varchar(50) DEFAULT NULL,
  `transporterMobile2` varchar(15) DEFAULT NULL,
  `transporterMail2` varchar(50) DEFAULT NULL,
  `contractPDFFromDate` date DEFAULT NULL,
  `contractPDFToDate` date DEFAULT NULL,
  `contractPDF` text,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transporter_master`
--

INSERT INTO `transporter_master` (`idTransporter`, `transporterName`, `transporterMobileNo`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `status`, `transporterName1`, `transporterMobile1`, `transporterMail1`, `transporterName2`, `transporterMobile2`, `transporterMail2`, `contractPDFFromDate`, `contractPDFToDate`, `contractPDF`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'KPN travels', '9874565565', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-04', '2019-12-26', 'contract_2101200946.csv', '2020-01-21 09:46:59', 1, '2020-01-21 09:46:59', 1),
(2, 'test', '7897987878', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-31', '2020-01-17', '', '2019-12-09 17:30:21', 1, '2019-12-31 12:40:28', 1),
(3, 'test', '7878787878', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-14', '2020-01-15', '', '2019-12-09 17:29:56', 1, '2020-01-11 10:06:46', 1),
(4, 'fgfdh', '4534636456', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-28', '2019-12-31', '', '2019-12-09 17:30:43', 1, '2019-12-26 18:54:06', 1),
(5, 'test transport', '7878787878', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-04', '2019-12-27', 'contract_0712191112.pdf', '2019-12-09 17:31:09', 1, '2019-12-09 17:31:09', 1),
(6, 'ragu', '9898989898', 1, 2, 3, 0, 0, 0, 0, 0, 0, 0, 2, 'Ragupathi ', '8988861238', 'ragu@gmail.com', 'ramkumar', '9098765422', 'ram@gmai.com', '2019-12-07', '2019-12-20', '', '2020-01-20 15:32:25', 1, '2020-01-20 15:33:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transporter_vehicle_master`
--

CREATE TABLE `transporter_vehicle_master` (
  `idTransporterVehicle` int(11) NOT NULL,
  `idTransporter` int(11) DEFAULT NULL,
  `idVehicle` int(11) DEFAULT NULL,
  `vehicleCount` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transporter_vehicle_master`
--

INSERT INTO `transporter_vehicle_master` (`idTransporterVehicle`, `idTransporter`, `idVehicle`, `vehicleCount`) VALUES
(1, 1, 1, '10'),
(2, 2, 1, '3'),
(3, 3, 1, '5'),
(4, 4, 1, '6'),
(5, 5, 1, '20'),
(6, 6, 1, '6');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `idLogin` int(11) NOT NULL,
  `idCustomer` int(10) NOT NULL,
  `idCustomerType` int(10) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `imsi_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `imsi_reset` int(1) DEFAULT NULL COMMENT '1=YES | 0=NO',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`idLogin`, `idCustomer`, `idCustomerType`, `customer_name`, `customer_password`, `imsi_number`, `imsi_reset`, `status`, `created_by`, `updated_by`) VALUES
(1, 0, 0, 'test', '$2y$10$2WSc5.WYW/fi2/.zh8Z14OP2IszMptCm5u3KTPtaPTEY0UJi9n4X2', NULL, 0, 1, 0, 0),
(35, 2, 2, 'vaithi', '$2y$10$Z8pEcZYfkgOc5n5ZyDf46eaAoWpGKLnCTq1DNE49Z9QAbgWExX/JW', NULL, NULL, 1, 2, 0),
(37, 4, 2, 'yuvarani', '$2y$10$ME1/exIavpbKmfK9kUvaLeBzap9S1FtyH56pbmOL2Dun0S.FjaW32', NULL, NULL, 1, 4, 0),
(38, 5, 1, 'mari123', '$2y$10$9CdOUaT5EJftUC0c4dci8.2bGBKFwSVfllHkL633gzHz2K8nQ1XMi', NULL, NULL, 1, 5, 0),
(39, 1, 1, 'ragu', '$2y$10$EI1lkIOAmY/9ofy/h9vUNO4jDjnvujOFzLqmxySkgSv3FYcu/1JQe', NULL, NULL, 1, 1, 0),
(40, 3, 1, 'paul', '$2y$10$ol6QW3.lEX51Z9PGA5pdIersfn96SnbjtHHszsCYahpdfKHCHHzce', NULL, NULL, 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_master`
--

CREATE TABLE `vehicle_master` (
  `idVehicle` int(11) NOT NULL,
  `vehicleName` varchar(30) NOT NULL,
  `vehicleCapacity` varchar(10) NOT NULL,
  `vehiclePerKm` decimal(15,2) NOT NULL,
  `vehicleMinCharge` decimal(15,2) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=Active,2=Inactive',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_master`
--

INSERT INTO `vehicle_master` (`idVehicle`, `vehicleName`, `vehicleCapacity`, `vehiclePerKm`, `vehicleMinCharge`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Lorry', '1000', '150.00', '100.00', 1, '2019-12-04 11:13:00', 1, NULL, NULL),
(2, 'Mini Lorry', '12000', '120.00', '2000.00', 1, '2019-12-07 17:59:29', 1, NULL, NULL),
(3, 'Mini lorry2', '23000', '203.00', '20300.00', 1, '2019-12-07 18:04:29', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_master`
--

CREATE TABLE `warehouse_master` (
  `idWarehouse` int(11) NOT NULL,
  `warehouseName` varchar(50) DEFAULT NULL,
  `warehouseMobileno` varchar(11) DEFAULT NULL,
  `warehouseEmail` varchar(50) DEFAULT NULL,
  `t1` int(11) DEFAULT '0',
  `t2` int(11) DEFAULT '0',
  `t3` int(11) DEFAULT '0',
  `t4` int(11) DEFAULT '0',
  `t5` int(11) DEFAULT '0',
  `t6` int(11) DEFAULT '0',
  `t7` int(11) DEFAULT '0',
  `t8` int(11) DEFAULT '0',
  `t9` int(11) DEFAULT '0',
  `t10` int(11) DEFAULT '0',
  `idWarehousetype` int(11) DEFAULT '0' COMMENT '1=Customer,2=Company',
  `idCustomer` int(11) NOT NULL DEFAULT '0',
  `idLevel` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse_master`
--

INSERT INTO `warehouse_master` (`idWarehouse`, `warehouseName`, `warehouseMobileno`, `warehouseEmail`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `idWarehousetype`, `idCustomer`, `idLevel`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'warehouse one', '8764545454', 'war1@gmail.com', 1, 5, 7, 12, 0, 0, 0, 0, 0, 0, 2, 0, 0, '2019-12-04 10:45:01', 1, '2020-01-20 14:58:36', 1, 1),
(2, 'warehouse two', '7978787999', 'warehousetwo@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 2, 0, 0, '2019-12-04 10:46:04', 1, '2020-01-21 10:18:08', 1, 1),
(3, 'SMS warehouse two', '9876566464', 'abc@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, 1, 1, '2019-12-10 11:51:48', 34, '2020-01-20 14:58:43', 1, 1),
(4, 'SMS warehouse one', '9884465622', 'a@b.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, 1, 1, '2019-12-12 10:53:47', 1, '2020-01-20 14:58:47', 1, 1),
(5, 'MS warehouse one', '9888454454', 'abd@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, 2, 2, '2019-12-16 10:30:18', 35, '2020-01-20 14:58:53', 1, 1),
(6, 'wh sms', '6865868848', '57@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, 5, 1, '2019-12-21 16:30:46', 1, '2020-01-20 14:58:56', 1, 1),
(7, 'wh test', '5747467475', 'whtest@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 2, 0, 0, '2019-12-21 16:38:45', 1, '2020-01-20 14:59:00', 1, 1),
(8, 'WH457', '1231654987', 'wh457@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, 5, 1, '2019-12-24 09:39:10', 1, '2020-01-20 14:59:05', 1, 1),
(9, 'Ragu warehouse', '9596494894', 'ragWH@gmail.com', 1, 2, 3, 8, 0, 0, 0, 0, 0, 0, 1, 1, 1, '2020-01-10 18:25:53', 39, '2020-01-20 14:59:09', 1, 1),
(10, 'WHasa', '1548489465', 'wh@gmail.com', 1, 15, 7, 9, 0, 0, 0, 0, 0, 0, 1, 3, 1, '2020-01-20 15:37:20', 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_products`
--

CREATE TABLE `warehouse_products` (
  `idWarehouseProduct` int(11) NOT NULL,
  `idWarehouse` int(11) NOT NULL,
  `idFactory` int(11) DEFAULT NULL,
  `idCategory` int(11) DEFAULT NULL,
  `idSubCategory` int(11) DEFAULT NULL,
  `idProduct` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse_products`
--

INSERT INTO `warehouse_products` (`idWarehouseProduct`, `idWarehouse`, `idFactory`, `idCategory`, `idSubCategory`, `idProduct`) VALUES
(37, 1, 2, NULL, NULL, NULL),
(38, 1, 1, NULL, NULL, NULL),
(40, 7, 2, NULL, NULL, NULL),
(41, 2, 1, NULL, NULL, NULL),
(42, 2, 2, NULL, NULL, NULL),
(43, 2, 3, NULL, NULL, NULL),
(44, 2, 4, NULL, NULL, NULL),
(45, 2, 5, NULL, NULL, NULL),
(46, 2, 6, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `whouse_stock`
--

CREATE TABLE `whouse_stock` (
  `idWhStock` int(11) NOT NULL,
  `idWarehouse` int(11) NOT NULL,
  `idFactory` int(11) NOT NULL,
  `idTpVechile` varchar(35) NOT NULL,
  `grn_no` varchar(20) NOT NULL,
  `dc_no` varchar(20) NOT NULL,
  `po_no` varchar(20) NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `po_date` date NOT NULL,
  `entry_date` date NOT NULL,
  `idCustomer` int(11) DEFAULT '0',
  `idLevel` int(11) DEFAULT NULL,
  `handling_charges` decimal(11,2) DEFAULT NULL,
  `handling_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `whouse_stock`
--

INSERT INTO `whouse_stock` (`idWhStock`, `idWarehouse`, `idFactory`, `idTpVechile`, `grn_no`, `dc_no`, `po_no`, `invoice_no`, `po_date`, `entry_date`, `idCustomer`, `idLevel`, `handling_charges`, `handling_status`) VALUES
(1, 1, 1, 'VH1230', 'G040120124140RN', 'DC1230', 'TCC030120120726', 'INVC1230', '2020-01-03', '2020-01-04', 0, 0, NULL, NULL),
(2, 2, 1, 'VH543', 'G040120014003RN', 'DC543', 'TCC030120120726', 'INVC543', '2020-01-03', '2020-01-04', 0, 0, NULL, NULL),
(3, 4, 1, 'VH1230', 'G040120014921RN', 'DCNO20200104134505', 'Ragu/ORD/1', 'INVC20200104134505', '2020-01-04', '2020-01-04', 1, 1, '0.00', 0),
(4, 4, 1, 'VH1234', 'G040120020250RN', 'DCNO20200104140211', 'Ragu/ORD/2', 'INVC20200104140211', '2020-01-04', '2020-01-04', 1, 1, '0.00', 0),
(5, 3, 1, 'VH5432', 'G040120021502RN', 'DCNO20200104134615', 'Paul/ORD/1', 'INVC20200104134615', '2020-01-04', '2020-01-04', 3, 1, '0.00', 0),
(6, 3, 1, 'VH1234', 'G040120021521RN', 'DCNO20200104140211', 'Paul/ORD/2', 'INVC20200104140211', '2020-01-04', '2020-01-04', 3, 1, '0.00', 0),
(7, 1, 1, 'VH355', 'G070120052919RN', 'DC5455', 'TCC070120052707', 'INVC2344', '2020-01-07', '2020-01-07', 0, 0, NULL, NULL),
(8, 2, 1, 'VH454554', 'G070120053911RN', 'DC4566545', 'TCC070120052707', 'INVC34567', '2020-01-07', '2020-01-07', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `whouse_stock_damge`
--

CREATE TABLE `whouse_stock_damge` (
  `idDamage` int(11) NOT NULL,
  `idWarehouse` int(11) NOT NULL,
  `idLevel` int(11) DEFAULT NULL,
  `idCustomer` int(11) DEFAULT NULL,
  `idProduct` int(11) NOT NULL,
  `idProdSize` int(11) DEFAULT NULL,
  `dmg_prod_unit` int(11) NOT NULL,
  `dmg_prod_qty` varchar(50) DEFAULT NULL,
  `dmg_prod_pieces` int(11) DEFAULT NULL,
  `dmg_batch_no` varchar(100) NOT NULL,
  `dmg_mf_date` date NOT NULL,
  `idWhStockItem` int(11) DEFAULT NULL,
  `idProductserialno` text NOT NULL,
  `dmg_reason` text,
  `dmg_remarks` text,
  `dmg_entry_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `whouse_stock_damge`
--

INSERT INTO `whouse_stock_damge` (`idDamage`, `idWarehouse`, `idLevel`, `idCustomer`, `idProduct`, `idProdSize`, `dmg_prod_unit`, `dmg_prod_qty`, `dmg_prod_pieces`, `dmg_batch_no`, `dmg_mf_date`, `idWhStockItem`, `idProductserialno`, `dmg_reason`, `dmg_remarks`, `dmg_entry_date`, `created_by`) VALUES
(1, 4, NULL, NULL, 1, 1, 1, '2', NULL, 'BT040120124147H841N', '2020-01-01', 13, '428,429', '', '', '2020-01-07 12:06:24', 39),
(2, 2, NULL, NULL, 1, 1, 1, '2', NULL, 'BT040120014007H672N', '2020-01-03', 7, '211,212', '', '', '2020-01-07 12:08:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `whouse_stock_items`
--

CREATE TABLE `whouse_stock_items` (
  `idWhStockItem` int(11) NOT NULL,
  `idWhStock` int(11) DEFAULT NULL,
  `idCustomer` int(11) DEFAULT '0',
  `idLevel` int(11) DEFAULT NULL,
  `idProduct` int(11) DEFAULT NULL,
  `idProdSize` int(11) DEFAULT NULL,
  `offer` int(11) DEFAULT NULL,
  `offer_join_id` int(11) DEFAULT NULL,
  `idWarehouse` int(11) DEFAULT NULL,
  `idFactryOrdItem` int(11) DEFAULT NULL,
  `sku_current_supply` int(11) DEFAULT '0',
  `sku_reject_qty` int(11) DEFAULT '0',
  `sku_accept_qty` int(11) DEFAULT '0',
  `sku_pending_qty` int(11) DEFAULT '0',
  `sku_mf_date` varchar(100) DEFAULT '0',
  `sku_expiry_date` varchar(100) DEFAULT '0',
  `sku_batch_no` varchar(20) DEFAULT NULL,
  `sku_comments` text,
  `sku_entry_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `whouse_stock_items`
--

INSERT INTO `whouse_stock_items` (`idWhStockItem`, `idWhStock`, `idCustomer`, `idLevel`, `idProduct`, `idProdSize`, `offer`, `offer_join_id`, `idWarehouse`, `idFactryOrdItem`, `sku_current_supply`, `sku_reject_qty`, `sku_accept_qty`, `sku_pending_qty`, `sku_mf_date`, `sku_expiry_date`, `sku_batch_no`, `sku_comments`, `sku_entry_date`) VALUES
(1, 1, 0, 0, 1, 1, NULL, NULL, 1, 1, 10, NULL, 10, 0, '2020-01-01', '2020-03-16', 'BT040120124147H841N', NULL, '2020-01-04 12:42:36'),
(2, 1, 0, 0, 2, 3, NULL, NULL, 1, 7, 10, NULL, 10, 0, '2020-01-01', '2020-01-13', 'BT040120124147H958N', NULL, '2020-01-04 12:42:37'),
(3, 1, 0, 0, 4, 7, NULL, NULL, 1, 13, 10, NULL, 10, 0, '2020-01-01', '2020-06-01', 'BT040120124147H624N', NULL, '2020-01-04 12:42:37'),
(4, 1, 0, 0, 4, 8, NULL, NULL, 1, 16, 10, NULL, 10, 0, '2020-01-01', '2020-06-01', 'BT040120124147H863N', NULL, '2020-01-04 12:42:37'),
(5, 1, 0, 0, 1, 2, NULL, NULL, 1, 4, 10, NULL, 10, 0, '2020-01-01', '2020-03-16', 'BT040120124147H646N', NULL, '2020-01-04 12:42:37'),
(6, 1, 0, 0, 3, 5, NULL, NULL, 1, 10, 10, NULL, 10, 0, '2020-01-01', '0', 'BT040120124147H921N', NULL, '2020-01-04 12:42:37'),
(7, 2, 0, 0, 1, 1, NULL, NULL, 2, 2, 10, NULL, 10, 0, '2020-01-03', '2020-03-18', 'BT040120014007H672N', NULL, '2020-01-04 13:40:57'),
(8, 2, 0, 0, 2, 3, NULL, NULL, 2, 8, 10, NULL, 10, 0, '2020-01-03', '2020-01-15', 'BT040120014007H705N', NULL, '2020-01-04 13:40:57'),
(9, 2, 0, 0, 4, 7, NULL, NULL, 2, 14, 10, NULL, 10, 0, '2020-01-03', '2020-06-03', 'BT040120014007H792N', NULL, '2020-01-04 13:40:57'),
(10, 2, 0, 0, 4, 8, NULL, NULL, 2, 17, 10, NULL, 10, 0, '2020-01-03', '2020-06-03', 'BT040120014007H988N', NULL, '2020-01-04 13:40:57'),
(11, 2, 0, 0, 1, 2, NULL, NULL, 2, 5, 10, NULL, 10, 0, '2020-01-03', '2020-03-18', 'BT040120014007H683N', NULL, '2020-01-04 13:40:57'),
(12, 2, 0, 0, 3, 5, NULL, NULL, 2, 11, 10, NULL, 10, 0, '2020-01-03', '0', 'BT040120014007H760N', NULL, '2020-01-04 13:40:57'),
(13, 3, 1, 1, 1, 1, 0, 0, 4, 1, 5, 0, 5, 0, '2020-01-01', '2020-03-16', 'BT040120124147H841N', '', '2020-01-04 00:00:00'),
(14, 3, 1, 1, 1, 2, 0, 0, 4, 4, 5, 0, 5, 0, '2020-01-01', '2020-03-16', 'BT040120124147H646N', '', '2020-01-04 00:00:00'),
(15, 4, 1, 1, 3, 5, 0, 0, 4, 10, 5, 0, 5, 0, '2020-01-01', '0', 'BT040120124147H921N', '', '2020-01-04 00:00:00'),
(16, 4, 1, 1, 4, 7, 0, 0, 4, 13, 5, 0, 5, 0, '2020-01-01', '2020-06-01', 'BT040120124147H624N', '', '2020-01-04 00:00:00'),
(17, 4, 1, 1, 4, 8, 0, 0, 4, 16, 5, 0, 5, 0, '2020-01-01', '2020-06-01', 'BT040120124147H863N', '', '2020-01-04 00:00:00'),
(18, 5, 3, 1, 1, 1, 0, 0, 3, 1, 2, 0, 2, 0, '2020-01-01', '2020-03-16', 'BT040120124147H841N', '', '2020-01-04 00:00:00'),
(19, 5, 3, 1, 1, 2, 0, 0, 3, 4, 2, 0, 2, 0, '2020-01-01', '2020-03-16', 'BT040120124147H646N', '', '2020-01-04 00:00:00'),
(20, 6, 3, 1, 3, 5, 0, 0, 3, 10, 2, 0, 2, 0, '2020-01-01', '0', 'BT040120124147H921N', '', '2020-01-04 00:00:00'),
(21, 6, 3, 1, 4, 7, 0, 0, 3, 13, 2, 0, 2, 0, '2020-01-01', '2020-06-01', 'BT040120124147H624N', '', '2020-01-04 00:00:00'),
(22, 6, 3, 1, 4, 8, 0, 0, 3, 16, 2, 0, 2, 0, '2020-01-01', '2020-06-01', 'BT040120124147H863N', '', '2020-01-04 00:00:00'),
(23, 7, 0, 0, 1, 1, NULL, NULL, 1, 37, 100, NULL, 100, 0, '2020-01-03', '2020-03-18', 'BT070120052924H885N', NULL, '2020-01-07 17:30:05'),
(24, 7, 0, 0, 2, 3, NULL, NULL, 1, 41, 100, NULL, 100, 0, '2020-01-03', '2020-01-15', 'BT070120052924H704N', NULL, '2020-01-07 17:30:05'),
(25, 7, 0, 0, 4, 7, NULL, NULL, 1, 43, 100, NULL, 100, 0, '2020-01-03', '2020-06-03', 'BT070120052924H550N', NULL, '2020-01-07 17:30:05'),
(26, 7, 0, 0, 4, 8, NULL, NULL, 1, 45, 100, NULL, 100, 0, '2020-01-03', '2020-06-03', 'BT070120052924H733N', NULL, '2020-01-07 17:30:05'),
(27, 7, 0, 0, 1, 2, NULL, NULL, 1, 39, 100, NULL, 100, 0, '2020-01-03', '2020-03-18', 'BT070120052924H633N', NULL, '2020-01-07 17:30:05'),
(28, 8, 0, 0, 1, 1, NULL, NULL, 2, 38, 100, NULL, 100, 0, '2020-01-04', '2020-03-19', 'BT070120053915H686N', NULL, '2020-01-07 17:39:55'),
(29, 8, 0, 0, 2, 3, NULL, NULL, 2, 42, 100, NULL, 100, 0, '2020-01-04', '2020-01-16', 'BT070120053915H661N', NULL, '2020-01-07 17:39:55'),
(30, 8, 0, 0, 4, 7, NULL, NULL, 2, 44, 100, NULL, 100, 0, '2020-01-04', '2020-06-04', 'BT070120053915H578N', NULL, '2020-01-07 17:39:55'),
(31, 8, 0, 0, 4, 8, NULL, NULL, 2, 46, 100, NULL, 100, 0, '2020-01-04', '2020-06-04', 'BT070120053915H825N', NULL, '2020-01-07 17:39:55'),
(32, 8, 0, 0, 1, 2, NULL, NULL, 2, 40, 100, NULL, 100, 0, '2020-01-04', '2020-03-19', 'BT070120053915H638N', NULL, '2020-01-07 17:39:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_master`
--
ALTER TABLE `account_master`
  ADD PRIMARY KEY (`idAccount`);

--
-- Indexes for table `agency_master`
--
ALTER TABLE `agency_master`
  ADD PRIMARY KEY (`idAgency`);

--
-- Indexes for table `answares`
--
ALTER TABLE `answares`
  ADD PRIMARY KEY (`idAnsware`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`idBank`);

--
-- Indexes for table `card_type`
--
ALTER TABLE `card_type`
  ADD PRIMARY KEY (`idCardtype`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indexes for table `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`idChannel`);

--
-- Indexes for table `company_leave`
--
ALTER TABLE `company_leave`
  ADD PRIMARY KEY (`IdCompanyleave`);

--
-- Indexes for table `creditrating`
--
ALTER TABLE `creditrating`
  ADD PRIMARY KEY (`idCreditRating`);

--
-- Indexes for table `credit_details`
--
ALTER TABLE `credit_details`
  ADD PRIMARY KEY (`idCredit`);

--
-- Indexes for table `credit_notes_all_types`
--
ALTER TABLE `credit_notes_all_types`
  ADD PRIMARY KEY (`idCredit`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`idCurrency`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`idCustomer`);

--
-- Indexes for table `customertype`
--
ALTER TABLE `customertype`
  ADD PRIMARY KEY (`idCustomerType`);

--
-- Indexes for table `customer_allocation`
--
ALTER TABLE `customer_allocation`
  ADD PRIMARY KEY (`cus_allocate_id`);

--
-- Indexes for table `customer_billing_price`
--
ALTER TABLE `customer_billing_price`
  ADD PRIMARY KEY (`idBillingprice`);

--
-- Indexes for table `customer_channel`
--
ALTER TABLE `customer_channel`
  ADD PRIMARY KEY (`idCustomerChannel`);

--
-- Indexes for table `customer_order_damage_credit_status`
--
ALTER TABLE `customer_order_damage_credit_status`
  ADD PRIMARY KEY (`idCreditstatusdamage`);

--
-- Indexes for table `customer_order_damges`
--
ALTER TABLE `customer_order_damges`
  ADD PRIMARY KEY (`idCustOrderDmgsRtn`);

--
-- Indexes for table `customer_order_missing`
--
ALTER TABLE `customer_order_missing`
  ADD PRIMARY KEY (`idCustMissing`);

--
-- Indexes for table `customer_order_missing_credit_status`
--
ALTER TABLE `customer_order_missing_credit_status`
  ADD PRIMARY KEY (`idCreditstatusmissing`);

--
-- Indexes for table `customer_order_replacement`
--
ALTER TABLE `customer_order_replacement`
  ADD PRIMARY KEY (`idCustReplacement`);

--
-- Indexes for table `customer_order_replace_credit_status`
--
ALTER TABLE `customer_order_replace_credit_status`
  ADD PRIMARY KEY (`idCreditstatusreplace`);

--
-- Indexes for table `customer_order_return`
--
ALTER TABLE `customer_order_return`
  ADD PRIMARY KEY (`idCustOrderRtn`);

--
-- Indexes for table `customer_order_return_credit_status`
--
ALTER TABLE `customer_order_return_credit_status`
  ADD PRIMARY KEY (`idCreditstatusreturn`);

--
-- Indexes for table `dcsequence_items`
--
ALTER TABLE `dcsequence_items`
  ADD PRIMARY KEY (`idDCsequenceitems`);

--
-- Indexes for table `dc_sequence`
--
ALTER TABLE `dc_sequence`
  ADD PRIMARY KEY (`idDCsequence`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`idDesignation`);

--
-- Indexes for table `dispatch_customer`
--
ALTER TABLE `dispatch_customer`
  ADD PRIMARY KEY (`idDispatchcustomer`);

--
-- Indexes for table `dispatch_product`
--
ALTER TABLE `dispatch_product`
  ADD PRIMARY KEY (`idDispatchProduct`);

--
-- Indexes for table `dispatch_product_batch`
--
ALTER TABLE `dispatch_product_batch`
  ADD PRIMARY KEY (`idDispatchProductBatch`);

--
-- Indexes for table `dispatch_route`
--
ALTER TABLE `dispatch_route`
  ADD PRIMARY KEY (`idSelectRoute`);

--
-- Indexes for table `dispatch_vehicle`
--
ALTER TABLE `dispatch_vehicle`
  ADD PRIMARY KEY (`idDispatchVehicle`);

--
-- Indexes for table `distribution_margin`
--
ALTER TABLE `distribution_margin`
  ADD PRIMARY KEY (`idDistributionMargin`);

--
-- Indexes for table `empAddcart`
--
ALTER TABLE `empAddcart`
  ADD PRIMARY KEY (`idAddcart`);

--
-- Indexes for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD PRIMARY KEY (`IdEmployeeLeave`);

--
-- Indexes for table `factory_master`
--
ALTER TABLE `factory_master`
  ADD PRIMARY KEY (`idFactory`);

--
-- Indexes for table `factory_order`
--
ALTER TABLE `factory_order`
  ADD PRIMARY KEY (`idFactoryOrder`);

--
-- Indexes for table `factory_order_items`
--
ALTER TABLE `factory_order_items`
  ADD PRIMARY KEY (`idFactryOrdItem`);

--
-- Indexes for table `factory_products`
--
ALTER TABLE `factory_products`
  ADD PRIMARY KEY (`idFactoryProduct`);

--
-- Indexes for table `follwoup`
--
ALTER TABLE `follwoup`
  ADD PRIMARY KEY (`id_follow_up`);

--
-- Indexes for table `fulfillment_master`
--
ALTER TABLE `fulfillment_master`
  ADD PRIMARY KEY (`idFulfillment`);

--
-- Indexes for table `geography`
--
ALTER TABLE `geography`
  ADD PRIMARY KEY (`idGeography`);

--
-- Indexes for table `geographymapping_master`
--
ALTER TABLE `geographymapping_master`
  ADD PRIMARY KEY (`idGeographyMapping`);

--
-- Indexes for table `geographytitle`
--
ALTER TABLE `geographytitle`
  ADD PRIMARY KEY (`idGeographyTitle`);

--
-- Indexes for table `geographytitle_master`
--
ALTER TABLE `geographytitle_master`
  ADD PRIMARY KEY (`idGeographyTitle`);

--
-- Indexes for table `gst_master`
--
ALTER TABLE `gst_master`
  ADD PRIMARY KEY (`idGst`);

--
-- Indexes for table `handling_charges_master`
--
ALTER TABLE `handling_charges_master`
  ADD PRIMARY KEY (`idHandlingCharges`);

--
-- Indexes for table `hsn_details`
--
ALTER TABLE `hsn_details`
  ADD PRIMARY KEY (`idHsncode`);

--
-- Indexes for table `inventorynorms`
--
ALTER TABLE `inventorynorms`
  ADD PRIMARY KEY (`idInventoryNorms`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`idInvoice`);

--
-- Indexes for table `invoice_payment`
--
ALTER TABLE `invoice_payment`
  ADD PRIMARY KEY (`idPayment`);

--
-- Indexes for table `invoice_status`
--
ALTER TABLE `invoice_status`
  ADD PRIMARY KEY (`idInvoice`);

--
-- Indexes for table `invoice_status_list`
--
ALTER TABLE `invoice_status_list`
  ADD PRIMARY KEY (`idIncCom`);

--
-- Indexes for table `ledger_book`
--
ALTER TABLE `ledger_book`
  ADD PRIMARY KEY (`idLedgerBook`);

--
-- Indexes for table `ledger_cancel`
--
ALTER TABLE `ledger_cancel`
  ADD PRIMARY KEY (`idLedgerCancel`);

--
-- Indexes for table `ledger_details`
--
ALTER TABLE `ledger_details`
  ADD PRIMARY KEY (`idLedger`);

--
-- Indexes for table `maingroup_master`
--
ALTER TABLE `maingroup_master`
  ADD PRIMARY KEY (`idMainGroup`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`idOrder`);

--
-- Indexes for table `orders_allocated`
--
ALTER TABLE `orders_allocated`
  ADD PRIMARY KEY (`idOrderallocate`);

--
-- Indexes for table `orders_allocated_items`
--
ALTER TABLE `orders_allocated_items`
  ADD PRIMARY KEY (`idOrderallocateditems`);

--
-- Indexes for table `order_cancel_reason`
--
ALTER TABLE `order_cancel_reason`
  ADD PRIMARY KEY (`idOrdercancel`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`idOrderitem`);

--
-- Indexes for table `order_picklist_items`
--
ALTER TABLE `order_picklist_items`
  ADD PRIMARY KEY (`idOrdPickList`);

--
-- Indexes for table `packaging`
--
ALTER TABLE `packaging`
  ADD PRIMARY KEY (`idPackaging`);

--
-- Indexes for table `pjp_detail`
--
ALTER TABLE `pjp_detail`
  ADD PRIMARY KEY (`idpjpdetail`);

--
-- Indexes for table `pjp_detail_list`
--
ALTER TABLE `pjp_detail_list`
  ADD PRIMARY KEY (`idpjpList`);

--
-- Indexes for table `pjp_visit_status`
--
ALTER TABLE `pjp_visit_status`
  ADD PRIMARY KEY (`idVisit`);

--
-- Indexes for table `price_fixing`
--
ALTER TABLE `price_fixing`
  ADD PRIMARY KEY (`idPricefixing`);

--
-- Indexes for table `primary_packaging`
--
ALTER TABLE `primary_packaging`
  ADD PRIMARY KEY (`idPrimaryPackaging`);

--
-- Indexes for table `product_content`
--
ALTER TABLE `product_content`
  ADD PRIMARY KEY (`idProductContent`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`idProduct`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`idProductsize`);

--
-- Indexes for table `product_status`
--
ALTER TABLE `product_status`
  ADD PRIMARY KEY (`idProductStatus`);

--
-- Indexes for table `product_stock_serialno`
--
ALTER TABLE `product_stock_serialno`
  ADD PRIMARY KEY (`idProductserialno`);

--
-- Indexes for table `product_territory_details`
--
ALTER TABLE `product_territory_details`
  ADD PRIMARY KEY (`idProductTerritory`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`idQuestion`);

--
-- Indexes for table `sales_hierarchy`
--
ALTER TABLE `sales_hierarchy`
  ADD PRIMARY KEY (`idSaleshierarchy`);

--
-- Indexes for table `scheme`
--
ALTER TABLE `scheme`
  ADD PRIMARY KEY (`idScheme`);

--
-- Indexes for table `secondary_packaging`
--
ALTER TABLE `secondary_packaging`
  ADD PRIMARY KEY (`idSecondaryPackaging`);

--
-- Indexes for table `segment_type`
--
ALTER TABLE `segment_type`
  ADD PRIMARY KEY (`idsegmentType`);

--
-- Indexes for table `serialno_picklist`
--
ALTER TABLE `serialno_picklist`
  ADD PRIMARY KEY (`idSerialnopicklist`);

--
-- Indexes for table `service_class`
--
ALTER TABLE `service_class`
  ADD PRIMARY KEY (`idServiceClass`);

--
-- Indexes for table `service_master`
--
ALTER TABLE `service_master`
  ADD PRIMARY KEY (`idService`);

--
-- Indexes for table `service_partner`
--
ALTER TABLE `service_partner`
  ADD PRIMARY KEY (`idServicePartner`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`idSubCategory`);

--
-- Indexes for table `subsidarygroup_master`
--
ALTER TABLE `subsidarygroup_master`
  ADD PRIMARY KEY (`idSubsidaryGroup`);

--
-- Indexes for table `sub_packaging`
--
ALTER TABLE `sub_packaging`
  ADD PRIMARY KEY (`idSubPackaging`);

--
-- Indexes for table `sys_config`
--
ALTER TABLE `sys_config`
  ADD PRIMARY KEY (`idSysconfig`);

--
-- Indexes for table `taxheads_details`
--
ALTER TABLE `taxheads_details`
  ADD PRIMARY KEY (`idTaxheads`);

--
-- Indexes for table `tax_split`
--
ALTER TABLE `tax_split`
  ADD PRIMARY KEY (`idTaxSplit`);

--
-- Indexes for table `team_member_allocation`
--
ALTER TABLE `team_member_allocation`
  ADD PRIMARY KEY (`allocation_id`);

--
-- Indexes for table `team_member_groups`
--
ALTER TABLE `team_member_groups`
  ADD PRIMARY KEY (`tm_group_id`);

--
-- Indexes for table `team_member_master`
--
ALTER TABLE `team_member_master`
  ADD PRIMARY KEY (`idTeamMember`);

--
-- Indexes for table `territorymapping_master`
--
ALTER TABLE `territorymapping_master`
  ADD PRIMARY KEY (`idTerritoryMapping`);

--
-- Indexes for table `territorytitle_master`
--
ALTER TABLE `territorytitle_master`
  ADD PRIMARY KEY (`idTerritoryTitle`);

--
-- Indexes for table `territory_master`
--
ALTER TABLE `territory_master`
  ADD PRIMARY KEY (`idTerritory`);

--
-- Indexes for table `transporter_master`
--
ALTER TABLE `transporter_master`
  ADD PRIMARY KEY (`idTransporter`);

--
-- Indexes for table `transporter_vehicle_master`
--
ALTER TABLE `transporter_vehicle_master`
  ADD PRIMARY KEY (`idTransporterVehicle`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`idLogin`);

--
-- Indexes for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
  ADD PRIMARY KEY (`idVehicle`);

--
-- Indexes for table `warehouse_master`
--
ALTER TABLE `warehouse_master`
  ADD PRIMARY KEY (`idWarehouse`);

--
-- Indexes for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  ADD PRIMARY KEY (`idWarehouseProduct`);

--
-- Indexes for table `whouse_stock`
--
ALTER TABLE `whouse_stock`
  ADD PRIMARY KEY (`idWhStock`);

--
-- Indexes for table `whouse_stock_damge`
--
ALTER TABLE `whouse_stock_damge`
  ADD PRIMARY KEY (`idDamage`);

--
-- Indexes for table `whouse_stock_items`
--
ALTER TABLE `whouse_stock_items`
  ADD PRIMARY KEY (`idWhStockItem`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_master`
--
ALTER TABLE `account_master`
  MODIFY `idAccount` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agency_master`
--
ALTER TABLE `agency_master`
  MODIFY `idAgency` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `answares`
--
ALTER TABLE `answares`
  MODIFY `idAnsware` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `idBank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `card_type`
--
ALTER TABLE `card_type`
  MODIFY `idCardtype` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `idChannel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `company_leave`
--
ALTER TABLE `company_leave`
  MODIFY `IdCompanyleave` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `creditrating`
--
ALTER TABLE `creditrating`
  MODIFY `idCreditRating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `credit_details`
--
ALTER TABLE `credit_details`
  MODIFY `idCredit` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `credit_notes_all_types`
--
ALTER TABLE `credit_notes_all_types`
  MODIFY `idCredit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `idCurrency` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `idCustomer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `customertype`
--
ALTER TABLE `customertype`
  MODIFY `idCustomerType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `customer_allocation`
--
ALTER TABLE `customer_allocation`
  MODIFY `cus_allocate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `customer_billing_price`
--
ALTER TABLE `customer_billing_price`
  MODIFY `idBillingprice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `customer_channel`
--
ALTER TABLE `customer_channel`
  MODIFY `idCustomerChannel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `customer_order_damage_credit_status`
--
ALTER TABLE `customer_order_damage_credit_status`
  MODIFY `idCreditstatusdamage` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_order_damges`
--
ALTER TABLE `customer_order_damges`
  MODIFY `idCustOrderDmgsRtn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer_order_missing`
--
ALTER TABLE `customer_order_missing`
  MODIFY `idCustMissing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_order_missing_credit_status`
--
ALTER TABLE `customer_order_missing_credit_status`
  MODIFY `idCreditstatusmissing` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_order_replacement`
--
ALTER TABLE `customer_order_replacement`
  MODIFY `idCustReplacement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_order_replace_credit_status`
--
ALTER TABLE `customer_order_replace_credit_status`
  MODIFY `idCreditstatusreplace` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_order_return`
--
ALTER TABLE `customer_order_return`
  MODIFY `idCustOrderRtn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_order_return_credit_status`
--
ALTER TABLE `customer_order_return_credit_status`
  MODIFY `idCreditstatusreturn` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dcsequence_items`
--
ALTER TABLE `dcsequence_items`
  MODIFY `idDCsequenceitems` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dc_sequence`
--
ALTER TABLE `dc_sequence`
  MODIFY `idDCsequence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `idDesignation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dispatch_customer`
--
ALTER TABLE `dispatch_customer`
  MODIFY `idDispatchcustomer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dispatch_product`
--
ALTER TABLE `dispatch_product`
  MODIFY `idDispatchProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `dispatch_product_batch`
--
ALTER TABLE `dispatch_product_batch`
  MODIFY `idDispatchProductBatch` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `dispatch_route`
--
ALTER TABLE `dispatch_route`
  MODIFY `idSelectRoute` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dispatch_vehicle`
--
ALTER TABLE `dispatch_vehicle`
  MODIFY `idDispatchVehicle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `distribution_margin`
--
ALTER TABLE `distribution_margin`
  MODIFY `idDistributionMargin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `empAddcart`
--
ALTER TABLE `empAddcart`
  MODIFY `idAddcart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `employee_leave`
--
ALTER TABLE `employee_leave`
  MODIFY `IdEmployeeLeave` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `factory_master`
--
ALTER TABLE `factory_master`
  MODIFY `idFactory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `factory_order`
--
ALTER TABLE `factory_order`
  MODIFY `idFactoryOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `factory_order_items`
--
ALTER TABLE `factory_order_items`
  MODIFY `idFactryOrdItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `factory_products`
--
ALTER TABLE `factory_products`
  MODIFY `idFactoryProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `follwoup`
--
ALTER TABLE `follwoup`
  MODIFY `id_follow_up` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `fulfillment_master`
--
ALTER TABLE `fulfillment_master`
  MODIFY `idFulfillment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `geography`
--
ALTER TABLE `geography`
  MODIFY `idGeography` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `geographymapping_master`
--
ALTER TABLE `geographymapping_master`
  MODIFY `idGeographyMapping` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `geographytitle`
--
ALTER TABLE `geographytitle`
  MODIFY `idGeographyTitle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `geographytitle_master`
--
ALTER TABLE `geographytitle_master`
  MODIFY `idGeographyTitle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `gst_master`
--
ALTER TABLE `gst_master`
  MODIFY `idGst` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `handling_charges_master`
--
ALTER TABLE `handling_charges_master`
  MODIFY `idHandlingCharges` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `hsn_details`
--
ALTER TABLE `hsn_details`
  MODIFY `idHsncode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `inventorynorms`
--
ALTER TABLE `inventorynorms`
  MODIFY `idInventoryNorms` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `idInvoice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `invoice_payment`
--
ALTER TABLE `invoice_payment`
  MODIFY `idPayment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `invoice_status`
--
ALTER TABLE `invoice_status`
  MODIFY `idInvoice` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice_status_list`
--
ALTER TABLE `invoice_status_list`
  MODIFY `idIncCom` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ledger_book`
--
ALTER TABLE `ledger_book`
  MODIFY `idLedgerBook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `ledger_cancel`
--
ALTER TABLE `ledger_cancel`
  MODIFY `idLedgerCancel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ledger_details`
--
ALTER TABLE `ledger_details`
  MODIFY `idLedger` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `maingroup_master`
--
ALTER TABLE `maingroup_master`
  MODIFY `idMainGroup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `idOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `orders_allocated`
--
ALTER TABLE `orders_allocated`
  MODIFY `idOrderallocate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `orders_allocated_items`
--
ALTER TABLE `orders_allocated_items`
  MODIFY `idOrderallocateditems` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `order_cancel_reason`
--
ALTER TABLE `order_cancel_reason`
  MODIFY `idOrdercancel` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `idOrderitem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `order_picklist_items`
--
ALTER TABLE `order_picklist_items`
  MODIFY `idOrdPickList` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `packaging`
--
ALTER TABLE `packaging`
  MODIFY `idPackaging` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pjp_detail`
--
ALTER TABLE `pjp_detail`
  MODIFY `idpjpdetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pjp_detail_list`
--
ALTER TABLE `pjp_detail_list`
  MODIFY `idpjpList` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `pjp_visit_status`
--
ALTER TABLE `pjp_visit_status`
  MODIFY `idVisit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `price_fixing`
--
ALTER TABLE `price_fixing`
  MODIFY `idPricefixing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `primary_packaging`
--
ALTER TABLE `primary_packaging`
  MODIFY `idPrimaryPackaging` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `product_content`
--
ALTER TABLE `product_content`
  MODIFY `idProductContent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `idProductsize` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product_status`
--
ALTER TABLE `product_status`
  MODIFY `idProductStatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `product_stock_serialno`
--
ALTER TABLE `product_stock_serialno`
  MODIFY `idProductserialno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4568;
--
-- AUTO_INCREMENT for table `product_territory_details`
--
ALTER TABLE `product_territory_details`
  MODIFY `idProductTerritory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `idQuestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sales_hierarchy`
--
ALTER TABLE `sales_hierarchy`
  MODIFY `idSaleshierarchy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `scheme`
--
ALTER TABLE `scheme`
  MODIFY `idScheme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `secondary_packaging`
--
ALTER TABLE `secondary_packaging`
  MODIFY `idSecondaryPackaging` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `segment_type`
--
ALTER TABLE `segment_type`
  MODIFY `idsegmentType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `serialno_picklist`
--
ALTER TABLE `serialno_picklist`
  MODIFY `idSerialnopicklist` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service_class`
--
ALTER TABLE `service_class`
  MODIFY `idServiceClass` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service_master`
--
ALTER TABLE `service_master`
  MODIFY `idService` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service_partner`
--
ALTER TABLE `service_partner`
  MODIFY `idServicePartner` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `idSubCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `subsidarygroup_master`
--
ALTER TABLE `subsidarygroup_master`
  MODIFY `idSubsidaryGroup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `sub_packaging`
--
ALTER TABLE `sub_packaging`
  MODIFY `idSubPackaging` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sys_config`
--
ALTER TABLE `sys_config`
  MODIFY `idSysconfig` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `taxheads_details`
--
ALTER TABLE `taxheads_details`
  MODIFY `idTaxheads` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tax_split`
--
ALTER TABLE `tax_split`
  MODIFY `idTaxSplit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `team_member_allocation`
--
ALTER TABLE `team_member_allocation`
  MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `team_member_groups`
--
ALTER TABLE `team_member_groups`
  MODIFY `tm_group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_member_master`
--
ALTER TABLE `team_member_master`
  MODIFY `idTeamMember` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `territorymapping_master`
--
ALTER TABLE `territorymapping_master`
  MODIFY `idTerritoryMapping` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `territorytitle_master`
--
ALTER TABLE `territorytitle_master`
  MODIFY `idTerritoryTitle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `territory_master`
--
ALTER TABLE `territory_master`
  MODIFY `idTerritory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `transporter_master`
--
ALTER TABLE `transporter_master`
  MODIFY `idTransporter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `transporter_vehicle_master`
--
ALTER TABLE `transporter_vehicle_master`
  MODIFY `idTransporterVehicle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `idLogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
  MODIFY `idVehicle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `warehouse_master`
--
ALTER TABLE `warehouse_master`
  MODIFY `idWarehouse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  MODIFY `idWarehouseProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `whouse_stock`
--
ALTER TABLE `whouse_stock`
  MODIFY `idWhStock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `whouse_stock_damge`
--
ALTER TABLE `whouse_stock_damge`
  MODIFY `idDamage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `whouse_stock_items`
--
ALTER TABLE `whouse_stock_items`
  MODIFY `idWhStockItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
