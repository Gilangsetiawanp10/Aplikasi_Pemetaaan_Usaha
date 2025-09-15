-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 14, 2025 at 02:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemetaan_usaha`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `village` varchar(100) DEFAULT NULL,
  `latitude` decimal(11,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `province`, `city`, `district`, `village`, `latitude`, `longitude`) VALUES
(1, 'Jawa Barat', 'Bandung', 'Andir', 'Garuda', '-6.91174100', '107.57802600'),
(2, 'Jawa Barat', 'Bandung', 'Antapani', 'Antapani Wetan', '-6.91056000', '107.66472000'),
(3, 'Jawa Barat', 'Bandung', 'Antapani', 'Antapani Tengah', '-6.91692700', '107.66199000'),
(4, 'Jawa Barat', 'Bandung', 'Arcamanik', 'Cisaranten Kulon', '-6.92666400', '107.68281600'),
(5, 'Jawa Barat', 'Bandung', 'Arcamanik', 'Sukamiskin', '-6.91888400', '107.67419400'),
(6, 'Jawa Barat', 'Bandung', 'Arjasari', 'Baros', '-7.05228900', '107.61973600'),
(7, 'Jawa Barat', 'Bandung', 'Arjasari', 'Lebakwangi', '-7.04647500', '107.60566000'),
(8, 'Jawa Barat', 'Bandung', 'Babakan Ciparay', 'Margasuka', '-6.95805400', '107.58138000'),
(9, 'Jawa Barat', 'Bandung', 'Babakan Ciparay', 'Cirangrang', '-6.95960700', '107.58246000'),
(10, 'Jawa Barat', 'Bandung', 'Babakan Ciparay', 'Margahayu Utara', '-6.94881400', '107.57978000'),
(11, 'Jawa Barat', 'Bandung', 'Baleendah', 'Manggahang', '-7.01507100', '107.64551000'),
(12, 'Jawa Barat', 'Bandung', 'Baleendah', 'Bojongmalaka', '-6.98314200', '107.60598000'),
(13, 'Jawa Barat', 'Bandung', 'Bandung Wetan', 'Citarum', '-6.90616600', '107.61669000'),
(14, 'Jawa Barat', 'Bandung', 'Batujajar', 'Galanggang', '-6.91326400', '107.49922000'),
(15, 'Jawa Barat', 'Bandung', 'Batujajar', 'Cangkorah', '-6.89896700', '107.48104000'),
(16, 'Jawa Barat', 'Bandung', 'Batujajar', 'Batujajar Barat', '-6.91902200', '107.49141000'),
(17, 'Jawa Barat', 'Bandung', 'Batununggal', 'Binong', '-6.93664200', '107.64239000'),
(18, 'Jawa Barat', 'Bandung', 'Batununggal', 'Maleer', '-6.92742000', '107.63962000'),
(19, 'Jawa Barat', 'Bandung', 'Batununggal', 'Samoja', '-6.92289900', '107.62879000'),
(20, 'Jawa Barat', 'Bandung', 'Batununggal', 'Kacapiring', '-6.91612200', '107.63442000'),
(21, 'Jawa Barat', 'Bandung', 'Bojongloa Kaler', 'Jamika', '-6.92219900', '107.58856000'),
(22, 'Jawa Barat', 'Bandung', 'Bojongloa Kidul', 'Cibaduyut', '-6.95214200', '107.59346000'),
(23, 'Jawa Barat', 'Bandung', 'Bojongsoang', 'Cipagalo', '-6.97429500', '107.65008000'),
(24, 'Jawa Barat', 'Bandung', 'Buahbatu', 'Sekejati', '-6.94375700', '107.65938000'),
(25, 'Jawa Barat', 'Bandung', 'Cangkuang', 'Jatisari', '-7.06576600', '107.54668000'),
(26, 'Jawa Barat', 'Bandung', 'Cibeunying Kaler', 'Cihaurgeulis', '-6.89973300', '107.62989000'),
(27, 'Jawa Barat', 'Bandung', 'Cibeunying Kaler', 'Cigadung', '-6.88532300', '107.62958500'),
(28, 'Jawa Barat', 'Bandung', 'Cibeunying Kidul', 'Pasirlayung', '-6.90191300', '107.65357000'),
(29, 'Jawa Barat', 'Bandung', 'Cibiru', 'Cipadung', '-6.91877100', '107.72277000'),
(30, 'Jawa Barat', 'Bandung', 'Cicendo', 'Husen Sastranegara', '-6.90759100', '107.58345000'),
(31, 'Jawa Barat', 'Bandung', 'Cidadap', 'Ciumbuleuit', '-6.86591600', '107.60608000'),
(32, 'Jawa Barat', 'Bandung', 'Cikancung', 'Mandalasari', '-7.03899600', '107.82576000'),
(33, 'Jawa Barat', 'Bandung', 'Cikancung', 'Hegarmanah', '-6.99991400', '107.83396000'),
(34, 'Jawa Barat', 'Bandung', 'Cileunyi', 'Cinunuk', '-6.93758600', '107.73209000'),
(35, 'Jawa Barat', 'Bandung', 'Cileunyi', 'Cimekar', '-6.93953500', '107.73905000'),
(36, 'Jawa Barat', 'Bandung', 'Cililin', 'Karangtanjung', '-6.94538600', '107.46712500'),
(37, 'Jawa Barat', 'Bandung', 'Cimahi Selatan', 'Melong', '-6.92170600', '107.55741000'),
(38, 'Jawa Barat', 'Bandung', 'Cimahi Tengah', 'Cigugur Tengah', '-6.88967200', '107.55402000'),
(39, 'Jawa Barat', 'Bandung', 'Cimahi Utara', 'Cibabat', '-6.87312000', '107.55534000'),
(40, 'Jawa Barat', 'Bandung', 'Cimaung', 'Sukamaju', '-7.09545800', '107.54813000'),
(41, 'Jawa Barat', 'Bandung', 'Cimenyan', 'Mekarsaluyu', '-6.86481000', '107.65342000'),
(42, 'Jawa Barat', 'Bandung', 'Ciparay', 'Gunungleutik', '-7.03660700', '107.70470400'),
(43, 'Jawa Barat', 'Bandung', 'Ciparay', 'Pakutandang', '-7.03751100', '107.71252000'),
(44, 'Jawa Barat', 'Bandung', 'Ciparay', 'Manggungharja', '-7.03753700', '107.72051000'),
(45, 'Jawa Barat', 'Bandung', 'Cipeundeuy', 'Sukahaji', '-6.73508900', '107.37744000'),
(46, 'Jawa Barat', 'Bandung', 'Ciwidey', 'Ciwidey', '-7.10376400', '107.46510000'),
(47, 'Jawa Barat', 'Bandung', 'Coblong', 'Lebak Gede', '-6.89239200', '107.61782000'),
(48, 'Jawa Barat', 'Bandung', 'Coblong', 'Dago', '-6.87671800', '107.61790000'),
(49, 'Jawa Barat', 'Bandung', 'Coblong', 'Sadang Serang', '-6.89720200', '107.62023000'),
(50, 'Jawa Barat', 'Bandung', 'Coblong', 'Sekeloa', '-6.88506700', '107.61856000'),
(51, 'Jawa Barat', 'Bandung', 'Coblong', 'Lebak Siliwangi', '-6.89508300', '107.60895500'),
(52, 'Jawa Barat', 'Bandung', 'Dayeuhkolot', 'Cangkuang Kulon', '-6.97279500', '107.59084000'),
(53, 'Jawa Barat', 'Bandung', 'Dayeuhkolot', 'Citeureup', '-6.98250200', '107.62898000'),
(54, 'Jawa Barat', 'Bandung', 'Gedebage', 'Rancabolang', '-6.96213900', '107.68676000'),
(55, 'Jawa Barat', 'Bandung', 'Gedebage', 'Cisaranten Kidul', '-6.94442300', '107.68491000'),
(56, 'Jawa Barat', 'Bandung', 'Gedebage', 'Cimincrang', '-6.95071000', '107.70610000'),
(57, 'Jawa Barat', 'Bandung', 'Gununghalu', 'Sindangjaya', '-7.03611000', '107.21486000'),
(58, 'Jawa Barat', 'Bandung', 'Katapang', 'Gandasari', '-7.02113600', '107.54949000'),
(59, 'Jawa Barat', 'Bandung', 'Katapang', 'Cilampeni', '-6.99162000', '107.55273000'),
(60, 'Jawa Barat', 'Bandung', 'Kertasari', 'Sukapura', '-7.16253900', '107.69049000'),
(61, 'Jawa Barat', 'Bandung', 'Kertasari', 'Cibeureum', '-7.19675100', '107.67055500'),
(62, 'Jawa Barat', 'Bandung', 'Kutawaringin', 'Padasuka', '-7.01398300', '107.52569600'),
(63, 'Jawa Barat', 'Bandung', 'Kutawaringin', 'Kopo', '-6.98867000', '107.53292000'),
(64, 'Jawa Barat', 'Bandung', 'Mandalajati', 'Jatihandap', '-6.89856100', '107.66110000'),
(65, 'Jawa Barat', 'Bandung', 'Margahayu', 'Sukamenak', '-6.97175400', '107.58388000'),
(66, 'Jawa Barat', 'Bandung', 'Ngamprah', 'Gadobangkong', '-6.86845100', '107.52208000'),
(67, 'Jawa Barat', 'Bandung', 'Ngamprah', 'Bojongkoneng', '-6.83126600', '107.48622000'),
(68, 'Jawa Barat', 'Bandung', 'Pacet', 'Mekarjaya', '-7.09930400', '107.70006000'),
(69, 'Jawa Barat', 'Bandung', 'Pacet', 'Tanjungwangi', '-7.08838300', '107.72012000'),
(70, 'Jawa Barat', 'Bandung', 'Padalarang', 'Laksanamekar', '-6.88021900', '107.50431000'),
(71, 'Jawa Barat', 'Bandung', 'Padalarang', 'Ciburuy', '-6.83513700', '107.46978000'),
(72, 'Jawa Barat', 'Bandung', 'Pangalengan', 'Sukaluyu', '-7.22151800', '107.52309400'),
(73, 'Jawa Barat', 'Bandung', 'Pangalengan', 'Sukamanah', '-7.20547500', '107.59084000'),
(74, 'Jawa Barat', 'Bandung', 'Panyileukan', 'Cipadung Kidul', '-6.94119500', '107.71346000'),
(75, 'Jawa Barat', 'Bandung', 'Panyileukan', 'Cipadung Wetan', '-6.93176900', '107.71407000'),
(76, 'Jawa Barat', 'Bandung', 'Parongpong', 'Sariwangi', '-6.84187000', '107.57619500'),
(77, 'Jawa Barat', 'Bandung', 'Pasirjambu', 'Mekarsari', '-7.14406300', '107.50608000'),
(78, 'Jawa Barat', 'Bandung', 'Rancasari', 'Manjahlega', '-6.94284200', '107.66682000'),
(79, 'Jawa Barat', 'Bandung', 'Sindangkerta', 'Wangunsari', '-7.02464100', '107.41527600'),
(80, 'Jawa Barat', 'Bandung', 'Soreang', 'Cingcin', '-7.02606900', '107.54296000'),
(81, 'Jawa Barat', 'Bandung', 'Sukajadi', 'Pasteur', '-6.89006400', '107.59989000'),
(82, 'Jawa Barat', 'Bandung', 'Sukasari', 'Gegerkalong', '-6.86658400', '107.59167000'),
(83, 'Jawa Barat', 'Bandung', 'Sukasari', 'Isola', '-6.85809200', '107.59136000'),
(84, 'Jawa Barat', 'Bandung', 'Sukasari', 'Sarijadi', '-6.87871900', '107.57715600'),
(85, 'Jawa Barat', 'Bandung', 'Sumur Bandung', 'Braga', '-6.91970900', '107.60998000'),
(86, 'Jawa Barat', 'Bandung', 'Sumur Bandung', 'Kebon Pisang', '-6.92043000', '107.61783600'),
(87, 'Jawa Barat', 'Bandung', 'Sumur Bandung', 'Babakan Ciamis', '-6.91055100', '107.60905000'),
(88, 'Jawa Barat', 'Bandung', 'Ujung Berung', 'Pasanggrahan', '-6.90962300', '107.71373000'),
(89, 'Jawa Barat', 'Bandung', 'Lengkong', NULL, '-6.92242300', '107.61760000'),
(90, 'Jawa Barat', 'Bandung', 'Bandung Kulon', NULL, '-6.92740300', '107.57701000'),
(91, 'Jawa Barat', 'Bandung', 'Cipatat', NULL, '-6.91361100', '107.61036000'),
(92, 'Jawa Barat', 'Bandung', 'Lembang', NULL, '-6.81196300', '107.61720000'),
(93, 'Jawa Barat', 'Bandung', 'Cicalengka', NULL, '-6.99804000', '107.85567000'),
(94, 'Jawa Barat', 'Bandung', 'Kiaracondong', NULL, '-6.94513000', '107.64255500'),
(95, 'Jawa Barat', 'Bandung', 'Astanaanyar', NULL, '-6.92955000', '107.60352800'),
(96, 'Jawa Barat', 'Bandung', 'Majalaya', NULL, '-7.04907200', '107.76257000'),
(97, 'Jawa Barat', 'Bandung', 'Rancaekek', NULL, '-6.95896100', '107.76420600'),
(98, 'Jawa Barat', 'Bandung', 'Cilengkrang', NULL, '-6.89652700', '107.73684000'),
(99, 'Jawa Barat', 'Bandung', 'Regol', NULL, '-6.94369900', '107.61831000'),
(100, 'Jawa Barat', 'Bandung', 'Cihampelas', NULL, '-6.92684900', '107.47803000'),
(101, 'Jawa Barat', 'Bandung', 'Cisarua', NULL, '-6.84864900', '107.55819000'),
(102, 'Jawa Barat', 'Bandung', 'Banjaran', NULL, '-7.05571800', '107.59074000'),
(103, 'Jawa Barat', 'Bandung', 'Bandung Kidul', NULL, '-6.95787100', '107.63314000'),
(104, 'Jawa Barat', 'Bandung', 'Nagreg', NULL, '-7.01973600', '107.88698000'),
(105, 'Jawa Barat', 'Bandung', 'Margaasih', NULL, '-6.94336800', '107.55603000'),
(106, 'Jawa Barat', 'Bandung', 'Pameungpeuk', NULL, '-7.02796300', '107.60058600'),
(107, 'Jawa Barat', 'Bandung', 'Solokan Jeruk', NULL, '-7.01147100', '107.73471000'),
(108, 'Jawa Barat', 'Bandung', 'Rongga', NULL, '-6.91361100', '107.61036000'),
(109, 'Jawa Barat', 'Bandung', 'Cinambo', NULL, '-6.94013000', '107.69206000'),
(110, 'Jawa Barat', 'Bandung', 'Cikalong Wetan', NULL, '-7.11768500', '107.55407000');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_30_073430_create_locations_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5VLWepMb5FYBwe3ANs31mkYdGDsTZnXlja59FaSr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVJ6eVlOakR5QWxobWFIYVNnRnV0cWR1QkVBQmU3RUNlekpUNmRSTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9YWMzMjk2ZjUtZTYxYS00YTY4LWJmMTEtZjY4YTAxNWI3NmY2JnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2NzE0OTI3NzUxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756714934),
('fzZzlbEBitnvi6VgsJ5qMeXRKIPHf6h9quwbWDep', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnhDTjJqTUYybnpUWWlWekdPRjlFOXNSMm9VT3haTWhNaWl4a01oTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC8/aWQ9MWNmODZlMGMtZGU5OC00NjRlLWE1NzktYzZjZjE3NjBlYWQ5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2NzI0NzYwNDU2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756724764),
('HvyTWl1wfMHhYuPFQ7b9QbiTzcYHlOYmnlcSw65M', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3dSWEt6dERlaEFrZUU3OFVLNW9FMHJ6MmZROGQ5aTdMa0daaVRJQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1757817608),
('jRjy37ivsnPQUCBgi27FSLNQdOrOMq5BEwNhJ115', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUjFKdkF1N1J0MTBTQnpZbG1FUlhvb0lTa25vdGtxSjNrOThyQzl6OSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC8/aWQ9Y2I3NGQ1NjYtZTA4Ni00MGM0LTgyYzQtYWY5MjUwNDU0ZDAwJnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2NzE1MDI4Mjc1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756715032),
('NiZEGPWwutTpJKKU7DFYPmHppPGEiJlX1xvK5ufy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFVBMWVVdUdGWGplb3BpQmlMeWVxVnlwWXZzS0R3VkpnbFVMYVV4dCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9Nzk5MzVlOGEtOTMyYi00YWQ5LTgxNjItNjQ3NjI0MjIzOTAxJnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2NzEzODMzMzg2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756713838),
('Y1Gp1clI2ALW4HYsufTd4NjHwSnawiE2s10sSvI8', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzlWMmdqb2tSZmJXaTRXaUhzamFtS0VkaWFNSUtiMk9BRVZiZkZxSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756725734),
('yGPHmd2OPYtWP4UjlOFwm3ecbxawNaMr6lOs19Mo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVFWalZUVmJmalVrNlZ2RHplMEk2alhyY2ZpbmY2cXlQeDlQSGpkbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC8/aWQ9MWNmODZlMGMtZGU5OC00NjRlLWE1NzktYzZjZjE3NjBlYWQ5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2NzI0NjkyNDYyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756724696);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_district_village_city_province_unique` (`district`,`village`,`city`,`province`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
