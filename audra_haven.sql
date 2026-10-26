-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 25, 2026 at 03:26 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `audra_haven`
--

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('tennis','gym','pool','cabana') COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_type` enum('hourly_slot','session_quota','daily_quota','unit_daily') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price_unit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'per jam',
  `quota` int UNSIGNED DEFAULT NULL,
  `open_time` time NOT NULL DEFAULT '06:00:00',
  `close_time` time NOT NULL DEFAULT '22:00:00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `slug`, `category`, `booking_type`, `description`, `price`, `price_unit`, `quota`, `open_time`, `close_time`, `is_active`, `created_at`) VALUES
(1, 'Lapangan Tenis 1', 'tennis-1', 'tennis', 'hourly_slot', 'Lapangan hard court standar turnamen dengan lampu malam.', '150000.00', 'per jam', NULL, '06:00:00', '22:00:00', 1, '2026-10-10 18:16:12'),
(2, 'Lapangan Tenis 2', 'tennis-2', 'tennis', 'hourly_slot', 'Lapangan hard court dengan tribun kecil.', '150000.00', 'per jam', NULL, '06:00:00', '22:00:00', 1, '2026-10-10 18:16:12'),
(3, 'Fitness Center', 'gym', 'gym', 'session_quota', 'Peralatan kardio dan beban lengkap, tersedia pelatih pribadi.', '75000.00', 'per sesi', 20, '06:00:00', '22:00:00', 1, '2026-10-10 18:16:12'),
(4, 'Kolam Renang Utama', 'pool', 'pool', 'daily_quota', 'Kolam renang outdoor dengan kolam anak dan area berjemur.', '100000.00', 'per orang', 60, '08:00:00', '18:00:00', 1, '2026-10-10 18:16:12'),
(5, 'Kabana A', 'cabana-a', 'cabana', 'unit_daily', 'Kabana tepi kolam untuk 4 orang, termasuk handuk dan welcome drink.', '450000.00', 'per hari', 1, '08:00:00', '18:00:00', 1, '2026-10-10 18:16:12'),
(6, 'Kabana B', 'cabana-b', 'cabana', 'unit_daily', 'Kabana tepi kolam untuk 4 orang, termasuk handuk dan welcome drink.', '450000.00', 'per hari', 1, '08:00:00', '18:00:00', 1, '2026-10-10 18:16:12'),
(7, 'Kabana C', 'cabana-c', 'cabana', 'unit_daily', 'Kabana keluarga untuk 6 orang dengan sofa dan kulkas mini.', '650000.00', 'per hari', 1, '08:00:00', '18:00:00', 1, '2026-10-10 18:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `facility_bookings`
--

CREATE TABLE `facility_bookings` (
  `id` int UNSIGNED NOT NULL,
  `booking_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `facility_id` int UNSIGNED NOT NULL,
  `slot_id` int UNSIGNED DEFAULT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL DEFAULT '1',
  `total_price` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','confirmed','checked_in','completed','cancelled','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facility_photos`
--

CREATE TABLE `facility_photos` (
  `id` int UNSIGNED NOT NULL,
  `facility_id` int UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_cover` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facility_slots`
--

CREATE TABLE `facility_slots` (
  `id` int UNSIGNED NOT NULL,
  `facility_id` int UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `quota` int UNSIGNED DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ;

--
-- Dumping data for table `facility_slots`
--

INSERT INTO `facility_slots` (`id`, `facility_id`, `name`, `start_time`, `end_time`, `quota`, `price`, `is_active`) VALUES
(1, 1, '06:00 - 07:00', '06:00:00', '07:00:00', NULL, NULL, 1),
(2, 1, '07:00 - 08:00', '07:00:00', '08:00:00', NULL, NULL, 1),
(3, 1, '08:00 - 09:00', '08:00:00', '09:00:00', NULL, NULL, 1),
(4, 1, '09:00 - 10:00', '09:00:00', '10:00:00', NULL, NULL, 1),
(5, 1, '10:00 - 11:00', '10:00:00', '11:00:00', NULL, NULL, 1),
(6, 1, '11:00 - 12:00', '11:00:00', '12:00:00', NULL, NULL, 1),
(7, 1, '12:00 - 13:00', '12:00:00', '13:00:00', NULL, NULL, 1),
(8, 1, '13:00 - 14:00', '13:00:00', '14:00:00', NULL, NULL, 1),
(9, 1, '14:00 - 15:00', '14:00:00', '15:00:00', NULL, NULL, 1),
(10, 1, '15:00 - 16:00', '15:00:00', '16:00:00', NULL, NULL, 1),
(11, 1, '16:00 - 17:00', '16:00:00', '17:00:00', NULL, NULL, 1),
(12, 1, '17:00 - 18:00', '17:00:00', '18:00:00', NULL, NULL, 1),
(13, 1, '18:00 - 19:00', '18:00:00', '19:00:00', NULL, NULL, 1),
(14, 1, '19:00 - 20:00', '19:00:00', '20:00:00', NULL, NULL, 1),
(15, 1, '20:00 - 21:00', '20:00:00', '21:00:00', NULL, NULL, 1),
(16, 1, '21:00 - 22:00', '21:00:00', '22:00:00', NULL, NULL, 1),
(17, 2, '06:00 - 07:00', '06:00:00', '07:00:00', NULL, NULL, 1),
(18, 2, '07:00 - 08:00', '07:00:00', '08:00:00', NULL, NULL, 1),
(19, 2, '08:00 - 09:00', '08:00:00', '09:00:00', NULL, NULL, 1),
(20, 2, '09:00 - 10:00', '09:00:00', '10:00:00', NULL, NULL, 1),
(21, 2, '10:00 - 11:00', '10:00:00', '11:00:00', NULL, NULL, 1),
(22, 2, '11:00 - 12:00', '11:00:00', '12:00:00', NULL, NULL, 1),
(23, 2, '12:00 - 13:00', '12:00:00', '13:00:00', NULL, NULL, 1),
(24, 2, '13:00 - 14:00', '13:00:00', '14:00:00', NULL, NULL, 1),
(25, 2, '14:00 - 15:00', '14:00:00', '15:00:00', NULL, NULL, 1),
(26, 2, '15:00 - 16:00', '15:00:00', '16:00:00', NULL, NULL, 1),
(27, 2, '16:00 - 17:00', '16:00:00', '17:00:00', NULL, NULL, 1),
(28, 2, '17:00 - 18:00', '17:00:00', '18:00:00', NULL, NULL, 1),
(29, 2, '18:00 - 19:00', '18:00:00', '19:00:00', NULL, NULL, 1),
(30, 2, '19:00 - 20:00', '19:00:00', '20:00:00', NULL, NULL, 1),
(31, 2, '20:00 - 21:00', '20:00:00', '21:00:00', NULL, NULL, 1),
(32, 2, '21:00 - 22:00', '21:00:00', '22:00:00', NULL, NULL, 1),
(33, 3, 'Sesi Pagi', '06:00:00', '09:00:00', 20, NULL, 1),
(34, 3, 'Sesi Siang', '12:00:00', '15:00:00', 20, NULL, 1),
(35, 3, 'Sesi Sore', '16:00:00', '19:00:00', 20, NULL, 1),
(36, 3, 'Sesi Malam', '19:00:00', '22:00:00', 20, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `capacity` int UNSIGNED NOT NULL,
  `size_m2` int UNSIGNED DEFAULT NULL,
  `price_per_session` decimal(14,2) NOT NULL,
  `full_day_price` decimal(14,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `name`, `slug`, `description`, `capacity`, `size_m2`, `price_per_session`, `full_day_price`, `is_active`) VALUES
(1, 'Grand Ballroom Cendana', 'grand-ballroom-cendana', 'Ballroom utama tanpa pilar dengan panggung dan lampu kristal, untuk pernikahan dan acara besar.', 800, 960, '25000000.00', '45000000.00', 1),
(2, 'Ballroom Kenanga', 'ballroom-kenanga', 'Ballroom sedang dengan akses langsung ke taman, untuk seminar dan resepsi.', 300, 380, '12000000.00', '21000000.00', 1),
(3, 'Paviliun Taman Anggrek', 'paviliun-taman-anggrek', 'Paviliun semi-terbuka di tengah taman untuk gathering dan pesta kebun.', 150, 220, '7500000.00', '13000000.00', 1),
(4, 'Ruang Rapat Melati', 'ruang-rapat-melati', 'Ruang rapat tertutup dengan layar dan perangkat video conference.', 60, 90, '2500000.00', '4500000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hall_addons`
--

CREATE TABLE `hall_addons` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` enum('set','pax','item') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'set',
  `price` decimal(12,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hall_addons`
--

INSERT INTO `hall_addons` (`id`, `name`, `unit`, `price`, `is_active`) VALUES
(1, 'Sound system profesional', 'set', '2500000.00', 1),
(2, 'Proyektor dan layar besar', 'set', '750000.00', 1),
(3, 'Katering tambahan per porsi', 'pax', '125000.00', 1),
(4, 'Welcome drink per orang', 'pax', '25000.00', 1),
(5, 'Dekorasi pelaminan', 'set', '15000000.00', 1),
(6, 'Live music (band)', 'set', '8000000.00', 1),
(7, 'MC dan koordinator acara', 'set', '2000000.00', 1),
(8, 'Dokumentasi foto dan video', 'set', '6500000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hall_bookings`
--

CREATE TABLE `hall_bookings` (
  `id` int UNSIGNED NOT NULL,
  `booking_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `hall_id` int UNSIGNED NOT NULL,
  `package_id` int UNSIGNED DEFAULT NULL,
  `event_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` date NOT NULL,
  `session` enum('morning','afternoon','evening','full_day') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pax` int UNSIGNED NOT NULL,
  `hall_price` decimal(14,2) NOT NULL,
  `package_price` decimal(14,2) NOT NULL DEFAULT '0.00',
  `addons_total` decimal(14,2) NOT NULL DEFAULT '0.00',
  `promo_id` int UNSIGNED DEFAULT NULL,
  `discount_amount` decimal(14,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(14,2) NOT NULL,
  `dp_amount` decimal(14,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','dp_paid','paid','confirmed','completed','cancelled','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hall_booking_addons`
--

CREATE TABLE `hall_booking_addons` (
  `id` int UNSIGNED NOT NULL,
  `hall_booking_id` int UNSIGNED NOT NULL,
  `addon_id` int UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `unit_price` decimal(12,2) NOT NULL,
  `subtotal` decimal(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hall_packages`
--

CREATE TABLE `hall_packages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `base_price` decimal(14,2) NOT NULL DEFAULT '0.00',
  `price_per_pax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_pax` int UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hall_packages`
--

INSERT INTO `hall_packages` (`id`, `name`, `description`, `base_price`, `price_per_pax`, `min_pax`, `is_active`) VALUES
(1, 'Paket Seminar', 'Coffee break 2x, makan siang prasmanan, air mineral, dan peralatan presentasi dasar.', '1500000.00', '185000.00', 30, 1),
(2, 'Paket Pernikahan', 'Makan prasmanan 3 menu utama, meja dan kursi tamu, serta tata lampu panggung.', '8000000.00', '275000.00', 100, 1),
(3, 'Paket Rapat Eksekutif', 'Coffee break, makan siang, notulen digital, dan perangkat video conference.', '500000.00', '165000.00', 10, 1),
(4, 'Paket Gathering', 'Makan prasmanan, welcome drink, dan area games outdoor.', '2500000.00', '195000.00', 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hall_photos`
--

CREATE TABLE `hall_photos` (
  `id` int UNSIGNED NOT NULL,
  `hall_id` int UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_cover` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int UNSIGNED NOT NULL,
  `invoice_number` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `booking_type` enum('room','facility','table','order','hall') COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_id` int UNSIGNED NOT NULL,
  `total_amount` decimal(14,2) NOT NULL,
  `qr_payload` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issued_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int UNSIGNED NOT NULL,
  `category` enum('appetizer','main','dessert','beverage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `category`, `name`, `description`, `price`, `image`, `is_available`) VALUES
(1, 'appetizer', 'Lumpia Semarang', 'Lumpia isi rebung dan ayam dengan saus manis.', '45000.00', NULL, 1),
(2, 'appetizer', 'Salad Kepiting', 'Selada segar, kepiting, dan dressing lemon.', '68000.00', NULL, 1),
(3, 'appetizer', 'Sup Asparagus Krim', 'Sup krim asparagus dengan crouton.', '52000.00', NULL, 1),
(4, 'main', 'Nasi Goreng Audra', 'Nasi goreng dengan ayam suwir, telur, dan kerupuk udang.', '75000.00', NULL, 1),
(5, 'main', 'Gurame Bakar Kecap', 'Ikan gurame bakar dengan sambal matah dan nasi hangat.', '125000.00', NULL, 1),
(6, 'main', 'Sirloin Steak 200 gr', 'Daging sapi panggang, kentang tumbuk, dan saus lada hitam.', '235000.00', NULL, 1),
(7, 'main', 'Spaghetti Aglio e Olio Udang', 'Pasta bawang putih dan cabai dengan udang.', '98000.00', NULL, 1),
(8, 'main', 'Soto Ayam Khas Semarang', 'Soto ayam kuah bening dengan nasi dan perkedel.', '62000.00', NULL, 1),
(9, 'dessert', 'Panna Cotta Vanila', 'Puding krim vanila dengan saus stroberi.', '48000.00', NULL, 1),
(10, 'dessert', 'Pisang Bakar Keju Cokelat', 'Pisang bakar dengan keju dan cokelat leleh.', '42000.00', NULL, 1),
(11, 'dessert', 'Es Teler Audra', 'Alpukat, kelapa muda, dan nangka dengan susu.', '38000.00', NULL, 1),
(12, 'beverage', 'Es Teh Tarik', NULL, '28000.00', NULL, 1),
(13, 'beverage', 'Jus Jeruk Segar', NULL, '35000.00', NULL, 1),
(14, 'beverage', 'Kopi Latte', NULL, '45000.00', NULL, 1),
(15, 'beverage', 'Teh Panas Pilihan', NULL, '30000.00', NULL, 1),
(16, 'beverage', 'Mocktail Sunset', 'Campuran jeruk, markisa, dan soda.', '52000.00', NULL, 1),
(17, 'appetizer', 'Nachos with Cheese', 'Keripik jagung dengan saus keju dan jalapeno.', '55000.00', NULL, 1),
(18, 'appetizer', 'French Fries', 'Kentang goreng renyah dengan bumbu rahasia.', '35000.00', NULL, 1),
(19, 'appetizer', 'Chicken Wings', 'Sayap ayam bakar dengan saus BBQ.', '65000.00', NULL, 1),
(20, 'main', 'Fish and Chips', 'Ikan dory goreng tepung dengan kentang dan tartar sauce.', '95000.00', NULL, 1),
(21, 'main', 'Club Sandwich', 'Roti lapis ayam, telur, keju, dan sayuran.', '85000.00', NULL, 1),
(22, 'main', 'Beef Burger Audra', 'Daging sapi premium 150gr dengan keju leleh dan saus khusus.', '110000.00', NULL, 1),
(23, 'main', 'Spaghetti Carbonara', 'Pasta dengan saus krim, beef bacon, dan keju parmesan.', '105000.00', NULL, 1),
(24, 'main', 'Nasi Goreng Seafood', 'Nasi goreng dengan cumi, udang, dan kerupuk.', '90000.00', NULL, 1),
(25, 'dessert', 'Cheesecake Slice', 'Kue keju lembut dengan saus blueberry.', '55000.00', NULL, 1),
(26, 'dessert', 'Chocolate Lava Cake', 'Kue cokelat hangat dengan es krim vanila.', '60000.00', NULL, 1),
(27, 'dessert', 'Fresh Fruit Platter', 'Potongan buah segar musiman.', '45000.00', NULL, 1),
(28, 'beverage', 'Es Jeruk Peras', 'Jeruk peras segar dengan es batu.', '30000.00', NULL, 1),
(29, 'beverage', 'Avocado Juice', 'Jus alpukat kental dengan susu cokelat.', '40000.00', NULL, 1),
(30, 'beverage', 'Mango Smoothie', 'Smoothie mangga segar dengan yogurt.', '42000.00', NULL, 1),
(31, 'beverage', 'Mojito Mocktail', 'Minuman segar dari daun mint, lemon, dan soda.', '45000.00', NULL, 1),
(32, 'beverage', 'Sunset Mocktail', 'Campuran jeruk, markisa, dan grenadine.', '50000.00', NULL, 1),
(33, 'beverage', 'Ice Americano', 'Kopi hitam dingin dari biji kopi pilihan.', '35000.00', NULL, 1),
(34, 'beverage', 'Cappuccino', 'Kopi susu dengan busa lembut.', '40000.00', NULL, 1),
(35, 'beverage', 'Hot Chocolate', 'Cokelat panas kental dengan marshmallow.', '38000.00', NULL, 1),
(36, 'beverage', 'Virgin Mojito', 'Mocktail segar dari daun mint, potongan lemon, dan soda.', '45000.00', NULL, 1),
(37, 'beverage', 'Blue Lagoon Mocktail', 'Perpaduan sirup blue curacao, lemon, dan soda.', '48000.00', NULL, 1),
(38, 'beverage', 'Strawberry Daiquiri', 'Minuman manis asam dari stroberi segar dan sirup gula.', '50000.00', NULL, 1),
(39, 'beverage', 'Margarita Classic', 'Minuman klasik dari tequila, triple sec, dan perasan lemon.', '85000.00', NULL, 1),
(40, 'beverage', 'Mojito Classic', 'Rum putih, daun mint, gula, dan soda.', '80000.00', NULL, 1),
(41, 'beverage', 'Aperol Spritz', 'Minuman Italia dari Aperol, prosecco, dan soda.', '90000.00', NULL, 1),
(42, 'beverage', 'Local Red Wine (Glass)', 'Anggur merah lokal pilihan, disajikan per gelas.', '95000.00', NULL, 1),
(43, 'beverage', 'Local White Wine (Glass)', 'Anggur putih lokal segar, disajikan per gelas.', '90000.00', NULL, 1),
(44, 'beverage', 'Draft Beer', 'Bir draft dingin yang menyegarkan.', '65000.00', NULL, 1),
(45, 'beverage', 'Lychee Tea', 'Teh dingin dengan sirup leci dan buah leci utuh.', '35000.00', NULL, 1),
(46, 'beverage', 'Matcha Latte', 'Kopi latte dengan campuran matcha premium.', '45000.00', NULL, 1),
(47, 'beverage', 'Affogato', 'Es krim vanila yang disiram dengan espresso panas.', '40000.00', NULL, 1),
(48, 'appetizer', 'Truffle Fries', 'Kentang goreng renyah dengan minyak truffle dan parmesan.', '65000.00', NULL, 1),
(49, 'appetizer', 'Calamari Rings', 'Cumi goreng tepung dengan saus tartar.', '75000.00', NULL, 1),
(50, 'appetizer', 'Nachos Supreme', 'Keripik tortilla dengan daging sapi, keju, dan salsa.', '85000.00', NULL, 1),
(51, 'appetizer', 'Chicken Quesadilla', 'Tortilla panggang isi ayam, keju, dan paprika.', '80000.00', NULL, 1),
(52, 'main', 'Beef Slider (3 pcs)', 'Tiga burger mini dengan daging sapi premium dan keju.', '95000.00', NULL, 1),
(53, 'main', 'Fish & Chips', 'Ikan dory goreng tepung dengan kentang dan saus tartar.', '110000.00', NULL, 1),
(54, 'main', 'Grilled Chicken Steak', 'Dada ayam panggang dengan saus jamur dan kentang.', '120000.00', NULL, 1),
(55, 'main', 'Wagyu Beef Burger', 'Burger dengan daging wagyu juicy, keju, dan saus khusus.', '185000.00', NULL, 1),
(123, 'appetizer', 'Classic Caesar Salad', 'Selada romaine, crouton, keju parmesan, dan saus Caesar creamy.', '85000.00', NULL, 1),
(124, 'appetizer', 'Smoked Salmon Carpaccio', 'Irisan salmon asap dengan capers, bawang merah, dan minyak zaitun lemon.', '145000.00', NULL, 1),
(125, 'appetizer', 'Foie Gras Terrine', 'Hati angsa premium yang diolah dengan bumbu khas Prancis, disajikan dengan brioche.', '250000.00', NULL, 1),
(126, 'appetizer', 'Crispy Soft Shell Crab', 'Kepiting cangkang lunak goreng tepung dengan saus mayo pedas.', '115000.00', NULL, 1),
(127, 'appetizer', 'Tuna Tartare', 'Potongan tuna segar dengan alpukat, wijen, dan saus ponzu.', '135000.00', NULL, 1),
(128, 'appetizer', 'Mushroom Soup Truffle', 'Sup krim jamur dengan aroma minyak truffle yang mewah.', '75000.00', NULL, 1),
(129, 'appetizer', 'Garlic Bread with Cheese', 'Roti panggang mentega bawang dengan lelehan keju mozzarella.', '45000.00', NULL, 1),
(130, 'main', 'Pan-Seared Salmon', 'Fillet salmon panggang dengan saus lemon dill dan asparagus.', '220000.00', NULL, 1),
(131, 'main', 'Australian Lamb Rack', 'Iga domba panggang dengan rosemary, kentang tumbuk, dan saus red wine.', '350000.00', NULL, 1),
(132, 'main', 'Beef Tenderloin Steak', 'Daging sapi tenderloin 200gr dengan saus mushroom atau blackpepper.', '280000.00', NULL, 1),
(133, 'main', 'Chicken Cordon Bleu', 'Dada ayam gulung isi keju dan smoked beef, disajikan dengan saus mustard.', '145000.00', NULL, 1),
(134, 'main', 'Duck Confit', 'Paha bebek yang dimasak perlahan hingga empuk, disajikan dengan kentang goreng.', '195000.00', NULL, 1),
(135, 'main', 'Seafood Marinara Fettuccine', 'Pasta pita dengan saus tomat seafood (udang, cumi, kerang).', '140000.00', NULL, 1),
(136, 'main', 'Risotto ai Funghi', 'Nasi Italia creamy dengan jamur porcini dan keju parmesan.', '125000.00', NULL, 1),
(137, 'main', 'Nasi Campur Bali Premium', 'Nasi putih dengan aneka lauk khas Bali (ayam betutu, sate lilit, lawar).', '110000.00', NULL, 1),
(138, 'main', 'Mie Goreng Seafood Spesial', 'Mie goreng dengan udang, cumi, telur, dan sayuran segar.', '95000.00', NULL, 1),
(139, 'main', 'Nasi Kebuli Kambing', 'Nasi rempah khas Timur Tengah dengan daging kambing empuk.', '135000.00', NULL, 1),
(140, 'dessert', 'Classic Tiramisu', 'Kue kopi Italia dengan lapisan mascarpone dan bubuk kakao.', '65000.00', NULL, 1),
(141, 'dessert', 'Creme Brulee', 'Puding vanila lembut dengan lapisan gula karamel renyah di atasnya.', '60000.00', NULL, 1),
(142, 'dessert', 'Apple Pie a la Mode', 'Pai apel hangat disajikan dengan es krim vanila.', '55000.00', NULL, 1),
(143, 'dessert', 'Mango Sticky Rice', 'Nasi ketan manis dengan saus santan dan potongan mangga segar.', '50000.00', NULL, 1),
(144, 'dessert', 'Dark Chocolate Mousse', 'Mousse cokelat hitam pekat dengan whipped cream.', '55000.00', NULL, 1),
(145, 'dessert', 'Mixed Berry Pavlova', 'Meringue renyah dengan krim kocok dan buah beri segar.', '65000.00', NULL, 1),
(184, 'beverage', 'Caramel Macchiato', 'Espresso dengan susu, vanila, dan saus karamel.', '48000.00', NULL, 1),
(185, 'beverage', 'Hazelnut Latte', 'Kopi latte dengan sirup hazelnut.', '45000.00', NULL, 1),
(186, 'beverage', 'V60 Manual Brew', 'Kopi seduh manual dengan biji kopi single origin pilihan.', '40000.00', NULL, 1),
(187, 'beverage', 'Jasmine Tea Hot', 'Teh melati wangi disajikan panas.', '25000.00', NULL, 1),
(188, 'beverage', 'Earl Grey Tea', 'Teh hitam dengan aroma bergamot.', '30000.00', NULL, 1),
(189, 'beverage', 'Chamomile Tea', 'Teh bunga chamomile, cocok untuk relaksasi.', '30000.00', NULL, 1),
(190, 'beverage', 'Watermelon Juice', 'Jus semangka segar tanpa pemanis buatan.', '35000.00', NULL, 1),
(191, 'beverage', 'Pineapple Juice', 'Jus nanas segar dengan sedikit perasan lemon.', '35000.00', NULL, 1),
(192, 'beverage', 'Tropical Smoothie', 'Smoothie campuran nanas, mangga, dan pisang.', '45000.00', NULL, 1),
(193, 'beverage', 'Berry Blast Smoothie', 'Smoothie stroberi, blueberry, dan yogurt.', '48000.00', NULL, 1),
(194, 'beverage', 'Green Detox Juice', 'Jus sehat dari apel hijau, seledri, dan lemon.', '40000.00', NULL, 1),
(195, 'beverage', 'Shirley Temple', 'Mocktail klasik dari ginger ale, grenadine, dan cherry.', '45000.00', NULL, 1),
(196, 'beverage', 'Passion Fruit Mojito', 'Mojito mocktail dengan tambahan markisa segar.', '50000.00', NULL, 1),
(197, 'beverage', 'Cucumber Cooler', 'Minuman segar dari mentimun, mint, dan soda lemon.', '45000.00', NULL, 1),
(198, 'beverage', 'Lychee Rose Spritzer', 'Soda leci dengan sirup mawar dan daun mint.', '50000.00', NULL, 1),
(199, 'beverage', 'Sunset Boulevard', 'Campuran jus jeruk, grenadine, dan soda.', '48000.00', NULL, 1),
(200, 'beverage', 'Coconut Water Fresh', 'Air kelapa muda asli langsung dari buahnya.', '35000.00', NULL, 1),
(201, 'beverage', 'Ginger Fizz', 'Soda dengan ekstrak jahe segar, menghangatkan tenggorokan.', '40000.00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int UNSIGNED NOT NULL,
  `order_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `reservation_id` int UNSIGNED DEFAULT NULL,
  `room_booking_id` int UNSIGNED DEFAULT NULL,
  `order_type` enum('dine_in','room_charge') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dine_in',
  `total_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','paid','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `reservation_id`, `room_booking_id`, `order_type`, `total_price`, `status`, `created_at`) VALUES
(1, 'ORD-XERGCY', 4, NULL, NULL, 'dine_in', '113000.00', 'pending', '2026-10-24 02:10:18'),
(2, 'ORD-SUYFHK', 8, NULL, NULL, 'dine_in', '313000.00', 'pending', '2026-10-24 21:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `menu_item_id` int UNSIGNED NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_item_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 1, 1, '45000.00', '45000.00'),
(2, 1, 2, 1, '68000.00', '68000.00'),
(3, 2, 1, 1, '45000.00', '45000.00'),
(4, 2, 2, 1, '68000.00', '68000.00'),
(5, 2, 4, 1, '75000.00', '75000.00'),
(6, 2, 5, 1, '125000.00', '125000.00');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int UNSIGNED NOT NULL,
  `payment_code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `booking_type` enum('room','facility','table','order','hall') COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_id` int UNSIGNED NOT NULL,
  `payment_type` enum('full','dp','balance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full',
  `amount` decimal(14,2) NOT NULL,
  `method` enum('midtrans','transfer','cash') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'midtrans',
  `payment_method_id` int UNSIGNED DEFAULT NULL,
  `status` enum('pending','success','failed','expired','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `proof_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_order_id` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_transaction_id` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_by` int UNSIGNED DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_code`, `user_id`, `booking_type`, `booking_id`, `payment_type`, `amount`, `method`, `payment_method_id`, `status`, `proof_file`, `reference_note`, `midtrans_order_id`, `midtrans_transaction_id`, `verified_by`, `paid_at`, `created_at`) VALUES
(1, 'PAY-261024-2T4Y9D', 4, 'room', 3, 'full', '12500000.00', 'transfer', 12, 'success', 'payments/proofs/NC3rgKLIrjXO5ioZwslWd78h8seVrSv2S7adPqDP.jpg', 'istt', NULL, NULL, 1, '2026-10-24 03:45:09', '2026-10-24 02:21:43'),
(2, 'PAY-261024-HHID9J', 6, 'room', 4, 'full', '105000000.00', 'transfer', 1, 'success', 'payments/proofs/ZWM76ZlN9iZqQFJvelK1i2HJu19wnfm2LS6s50et.png', 'Artha', NULL, NULL, 1, '2026-10-24 03:45:04', '2026-10-24 03:25:02'),
(3, 'PAY-261024-CABHCX', 7, 'room', 5, 'full', '37500000.00', 'transfer', 1, 'success', 'payments/proofs/o5G7EU0AJyYh92dh5DJhmfIgi8jjbh0UbZNNgNPn.jpg', 'Jenokarina', NULL, NULL, 5, '2026-10-24 07:02:23', '2026-10-24 07:01:01'),
(4, 'PAY-261025-G1V9KX', 9, 'room', 6, 'full', '7500000.00', 'transfer', 1, 'success', NULL, NULL, NULL, NULL, 5, '2026-10-25 12:17:25', '2026-10-25 12:16:42'),
(5, 'PAY-261025-BNMXYY', 1, 'room', 7, 'full', '2500000.00', 'transfer', 12, 'pending', 'payments/proofs/WricLN4Gbm0XiQmJDOdYVNdYNl2OhKfhv1T84N7t.jpg', 'istt', NULL, NULL, NULL, NULL, '2026-10-25 14:32:42'),
(6, 'PAY-261025-U4XO0F', 10, 'room', 8, 'full', '2500000.00', 'transfer', 12, 'success', 'payments/proofs/eJDwvb1pYty7AXFoKRXqoOaHdI4psZN32eM8PLMn.jpg', 'istt', NULL, NULL, 5, '2026-10-25 14:43:19', '2026-10-25 14:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('bank_transfer','ewallet','qris','cash') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `code`, `name`, `type`, `account_name`, `account_number`, `qr_image`, `instructions`, `sort_order`, `is_active`) VALUES
(1, 'bca', 'BCA', 'bank_transfer', 'Audra Haven Suites', '1234567890', NULL, 'Transfer ke rekening BCA.', 1, 1),
(2, 'mandiri', 'Mandiri', 'bank_transfer', 'Audra Haven Suites', '0987654321', NULL, 'Transfer ke rekening Mandiri.', 2, 1),
(3, 'bni', 'BNI', 'bank_transfer', 'Audra Haven Suites', '1122334455', NULL, 'Transfer ke rekening BNI.', 3, 1),
(4, 'bsi', 'BSI', 'bank_transfer', 'Audra Haven Suites', '5566778899', NULL, 'Transfer ke rekening BSI.', 4, 1),
(5, 'bri', 'BRI', 'bank_transfer', 'Audra Haven Suites', '9988776655', NULL, 'Transfer ke rekening BRI.', 5, 1),
(6, 'cimb', 'CIMB Niaga', 'bank_transfer', 'Audra Haven Suites', '0011223344', NULL, 'Transfer ke rekening CIMB Niaga.', 6, 1),
(7, 'permata', 'Permata', 'bank_transfer', 'Audra Haven Suites', '7788990011', NULL, 'Transfer ke rekening Permata.', 7, 1),
(8, 'gopay', 'GoPay', 'ewallet', NULL, NULL, NULL, 'Scan QR atau bayar via aplikasi Gojek.', 10, 1),
(9, 'ovo', 'OVO', 'ewallet', NULL, NULL, NULL, 'Scan QR atau bayar via aplikasi OVO.', 11, 1),
(10, 'dana', 'DANA', 'ewallet', NULL, NULL, NULL, 'Scan QR atau bayar via aplikasi DANA.', 12, 1),
(11, 'shopeepay', 'ShopeePay', 'ewallet', NULL, NULL, NULL, 'Scan QR atau bayar via aplikasi Shopee.', 13, 1),
(12, 'qris', 'QRIS (Semua Bank & E-Wallet)', 'qris', NULL, NULL, 'images/qris-audra.png', 'Scan kode QRIS menggunakan aplikasi bank atau e-wallet apa saja.', 20, 1),
(13, 'cash', 'Bayar di Hotel (Tunai)', 'cash', NULL, NULL, NULL, 'Pembayaran dilakukan saat check-in di resepsionis.', 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pricing_rules`
--

CREATE TABLE `pricing_rules` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rule_type` enum('weekend','high_season','holiday') COLLATE utf8mb4_unicode_ci NOT NULL,
  `days_of_week` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `markup_percent` decimal(5,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing_rules`
--

INSERT INTO `pricing_rules` (`id`, `name`, `rule_type`, `days_of_week`, `start_date`, `end_date`, `markup_percent`, `is_active`) VALUES
(1, 'Weekend (Jumat-Sabtu)', 'weekend', '5,6', NULL, NULL, '20.00', 1),
(2, 'Libur Natal dan Tahun Baru', 'high_season', NULL, '2026-12-20', '2027-01-03', '35.00', 1),
(3, 'Libur Lebaran 2027', 'holiday', NULL, '2027-03-05', '2027-03-14', '40.00', 1),
(4, 'Libur Sekolah Pertengahan 2027', 'high_season', NULL, '2027-06-26', '2027-07-11', '25.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `applies_to` enum('room','hall','all') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'room',
  `discount_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `max_discount` decimal(12,2) DEFAULT NULL,
  `min_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `quota` int UNSIGNED DEFAULT NULL,
  `used_count` int UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `title`, `description`, `applies_to`, `discount_percent`, `max_discount`, `min_amount`, `start_date`, `end_date`, `quota`, `used_count`, `is_active`) VALUES
(1, 'WELCOME10', 'Diskon Tamu Baru 10%', 'Potongan 10% untuk pemesanan kamar, maksimal Rp 500.000.', 'room', '10.00', '500000.00', '1000000.00', '2026-10-01', '2027-12-31', NULL, 0, 1),
(2, 'WEEKDAY15', 'Promo Weekday 15%', 'Potongan 15% untuk pemesanan kamar senilai minimal Rp 2.000.000.', 'room', '15.00', '750000.00', '2000000.00', '2026-10-01', '2027-06-30', 200, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_tables`
--

CREATE TABLE `restaurant_tables` (
  `id` int UNSIGNED NOT NULL,
  `table_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` tinyint UNSIGNED NOT NULL,
  `area` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indoor',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_tables`
--

INSERT INTO `restaurant_tables` (`id`, `table_number`, `capacity`, `area`, `is_active`) VALUES
(1, 'T01', 2, 'Indoor', 1),
(2, 'T02', 2, 'Indoor', 1),
(3, 'T03', 2, 'Indoor', 1),
(4, 'T04', 2, 'Indoor', 1),
(5, 'T05', 4, 'Indoor', 1),
(6, 'T06', 4, 'Indoor', 1),
(7, 'T07', 4, 'Indoor', 1),
(8, 'T08', 4, 'Indoor', 1),
(9, 'T09', 4, 'Teras', 1),
(10, 'T10', 6, 'Teras', 1),
(11, 'T11', 6, 'Teras', 1),
(12, 'T12', 8, 'Ruang Privat', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `target_type` enum('room_type','facility','hall','restaurant') COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` int UNSIGNED NOT NULL DEFAULT '0',
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`) VALUES
(1, 'guest', 'Tamu'),
(2, 'receptionist', 'Resepsionis'),
(3, 'manager', 'Manajer'),
(4, 'admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int UNSIGNED NOT NULL,
  `room_type_id` int UNSIGNED NOT NULL,
  `room_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` tinyint UNSIGNED NOT NULL,
  `status` enum('available','occupied','cleaning','maintenance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor`, `status`) VALUES
(1, 1, '101', 1, 'available'),
(2, 1, '201', 2, 'available'),
(3, 1, '102', 1, 'available'),
(4, 1, '202', 2, 'available'),
(5, 1, '103', 1, 'available'),
(6, 1, '203', 2, 'available'),
(7, 1, '104', 1, 'available'),
(8, 1, '204', 2, 'available'),
(9, 2, '301', 3, 'available'),
(10, 2, '302', 3, 'available'),
(11, 2, '303', 3, 'available'),
(12, 2, '304', 3, 'available'),
(13, 2, '305', 3, 'available'),
(14, 2, '306', 3, 'available'),
(15, 3, '401', 4, 'available'),
(16, 3, '402', 4, 'available'),
(17, 3, '403', 4, 'available'),
(18, 3, '404', 4, 'available'),
(19, 3, '405', 4, 'available'),
(20, 4, '501', 5, 'available'),
(21, 4, '502', 5, 'available'),
(22, 4, '503', 5, 'available'),
(23, 4, '504', 5, 'available'),
(24, 5, '601', 6, 'available'),
(25, 5, '602', 6, 'available'),
(26, 5, '709', 9, 'available'),
(27, 1, '700', 1, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `room_bookings`
--

CREATE TABLE `room_bookings` (
  `id` int UNSIGNED NOT NULL,
  `booking_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `room_id` int UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `nights` smallint UNSIGNED NOT NULL,
  `guests` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `subtotal` decimal(12,2) NOT NULL,
  `promo_id` int UNSIGNED DEFAULT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','confirmed','checked_in','completed','cancelled','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `special_request` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `checked_in_at` datetime DEFAULT NULL,
  `checked_out_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `room_bookings`
--

INSERT INTO `room_bookings` (`id`, `booking_code`, `user_id`, `room_id`, `check_in`, `check_out`, `nights`, `guests`, `subtotal`, `promo_id`, `discount_amount`, `total_price`, `status`, `special_request`, `expires_at`, `checked_in_at`, `checked_out_at`, `created_at`) VALUES
(1, 'BK-0BJHQ4', 4, 1, '2026-10-31', '2026-11-07', 7, 4, '8750000.00', NULL, '0.00', '8750000.00', 'pending', 'Double Bed', NULL, NULL, NULL, '2026-10-24 01:37:23'),
(3, 'RB-261024-SONLB', 4, 3, '2026-10-31', '2026-11-10', 10, 2, '12500000.00', NULL, '0.00', '12500000.00', 'paid', 'Double Bed', '2026-10-25 02:21:43', NULL, NULL, '2026-10-24 02:21:43'),
(4, 'RB-261024-YDTD8', 6, 24, '2026-10-31', '2026-11-14', 14, 4, '105000000.00', NULL, '0.00', '105000000.00', 'paid', 'Double bed', '2026-10-25 03:25:02', NULL, NULL, '2026-10-24 03:25:02'),
(5, 'RB-261024-UK3XB', 7, 25, '2026-10-30', '2026-11-04', 5, 2, '37500000.00', NULL, '0.00', '37500000.00', 'paid', NULL, '2026-10-25 07:01:01', NULL, NULL, '2026-10-24 07:01:01'),
(6, 'RB-261025-V5V3R', 9, 24, '2026-10-25', '2026-10-26', 1, 1, '7500000.00', NULL, '0.00', '7500000.00', 'paid', NULL, '2026-10-26 12:16:42', NULL, NULL, '2026-10-25 12:16:42'),
(7, 'RB-261025-PMVGH', 1, 15, '2026-10-25', '2026-10-26', 1, 3, '2500000.00', NULL, '0.00', '2500000.00', 'pending', NULL, '2026-10-26 14:32:42', NULL, NULL, '2026-10-25 14:32:42'),
(8, 'RB-261025-YX2SU', 10, 16, '2026-10-25', '2026-10-26', 1, 2, '2500000.00', NULL, '0.00', '2500000.00', 'paid', 'double bed', '2026-10-26 14:39:10', NULL, NULL, '2026-10-25 14:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `room_booking_nights`
--

CREATE TABLE `room_booking_nights` (
  `id` int UNSIGNED NOT NULL,
  `room_booking_id` int UNSIGNED NOT NULL,
  `stay_date` date NOT NULL,
  `base_price` decimal(12,2) NOT NULL,
  `markup_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `price` decimal(12,2) NOT NULL,
  `rule_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_booking_nights`
--

INSERT INTO `room_booking_nights` (`id`, `room_booking_id`, `stay_date`, `base_price`, `markup_percent`, `price`, `rule_name`) VALUES
(11, 3, '2026-10-31', '1250000.00', '0.00', '1250000.00', NULL),
(12, 3, '2026-11-01', '1250000.00', '0.00', '1250000.00', NULL),
(13, 3, '2026-11-02', '1250000.00', '0.00', '1250000.00', NULL),
(14, 3, '2026-11-03', '1250000.00', '0.00', '1250000.00', NULL),
(15, 3, '2026-11-04', '1250000.00', '0.00', '1250000.00', NULL),
(16, 3, '2026-11-05', '1250000.00', '0.00', '1250000.00', NULL),
(17, 3, '2026-11-06', '1250000.00', '0.00', '1250000.00', NULL),
(18, 3, '2026-11-07', '1250000.00', '0.00', '1250000.00', NULL),
(19, 3, '2026-11-08', '1250000.00', '0.00', '1250000.00', NULL),
(20, 3, '2026-11-09', '1250000.00', '0.00', '1250000.00', NULL),
(21, 4, '2026-10-31', '7500000.00', '0.00', '7500000.00', NULL),
(22, 4, '2026-11-01', '7500000.00', '0.00', '7500000.00', NULL),
(23, 4, '2026-11-02', '7500000.00', '0.00', '7500000.00', NULL),
(24, 4, '2026-11-03', '7500000.00', '0.00', '7500000.00', NULL),
(25, 4, '2026-11-04', '7500000.00', '0.00', '7500000.00', NULL),
(26, 4, '2026-11-05', '7500000.00', '0.00', '7500000.00', NULL),
(27, 4, '2026-11-06', '7500000.00', '0.00', '7500000.00', NULL),
(28, 4, '2026-11-07', '7500000.00', '0.00', '7500000.00', NULL),
(29, 4, '2026-11-08', '7500000.00', '0.00', '7500000.00', NULL),
(30, 4, '2026-11-09', '7500000.00', '0.00', '7500000.00', NULL),
(31, 4, '2026-11-10', '7500000.00', '0.00', '7500000.00', NULL),
(32, 4, '2026-11-11', '7500000.00', '0.00', '7500000.00', NULL),
(33, 4, '2026-11-12', '7500000.00', '0.00', '7500000.00', NULL),
(34, 4, '2026-11-13', '7500000.00', '0.00', '7500000.00', NULL),
(35, 5, '2026-10-30', '7500000.00', '0.00', '7500000.00', NULL),
(36, 5, '2026-10-31', '7500000.00', '0.00', '7500000.00', NULL),
(37, 5, '2026-11-01', '7500000.00', '0.00', '7500000.00', NULL),
(38, 5, '2026-11-02', '7500000.00', '0.00', '7500000.00', NULL),
(39, 5, '2026-11-03', '7500000.00', '0.00', '7500000.00', NULL),
(40, 6, '2026-10-25', '7500000.00', '0.00', '7500000.00', NULL),
(41, 7, '2026-10-25', '2500000.00', '0.00', '2500000.00', NULL),
(42, 8, '2026-10-25', '2500000.00', '0.00', '2500000.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room_photos`
--

CREATE TABLE `room_photos` (
  `id` int UNSIGNED NOT NULL,
  `room_type_id` int UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_cover` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `base_price` decimal(12,2) NOT NULL,
  `capacity` tinyint UNSIGNED NOT NULL DEFAULT '2',
  `size_m2` smallint UNSIGNED DEFAULT NULL,
  `bed_type` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amenities` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `slug`, `description`, `base_price`, `capacity`, `size_m2`, `bed_type`, `amenities`, `is_active`, `created_at`) VALUES
(1, 'Deluxe Room', 'deluxe-room', 'Kamar nyaman dengan pemandangan taman, cocok untuk pasangan atau perjalanan bisnis.', '1250000.00', 2, 32, '1 King atau 2 Twin', 'WiFi, AC, Smart TV, Minibar, Water heater, Safe box', 1, '2026-10-10 18:16:12'),
(2, 'Premier Room', 'premier-room', 'Kamar lebih luas dengan balkon pribadi menghadap kolam renang.', '1750000.00', 3, 40, '1 King + sofa bed', 'WiFi, AC, Smart TV, Balkon, Minibar, Mesin kopi, Safe box', 1, '2026-10-10 18:16:12'),
(3, 'Executive Suite', 'executive-suite', 'Suite dengan ruang tamu terpisah dan bathtub, untuk menginap lebih lama.', '2500000.00', 3, 58, '1 King', 'WiFi, AC, Smart TV, Ruang tamu, Bathtub, Minibar, Mesin kopi, Akses lounge', 1, '2026-10-10 18:16:12'),
(4, 'Family Suite', 'family-suite', 'Dua kamar tidur yang saling terhubung, ideal untuk keluarga.', '3200000.00', 5, 78, '1 King + 2 Twin', 'WiFi, AC, 2 Smart TV, Dapur kecil, Bathtub, Ruang makan, Safe box', 1, '2026-10-10 18:16:12'),
(5, 'Presidential Residence', 'presidential-residence', 'Hunian dua lantai dengan kolam pribadi, dapur, dan layanan butler.', '7500000.00', 6, 160, '2 King', 'WiFi, AC, Kolam pribadi, Dapur, Ruang makan, Butler, Bathtub, Akses lounge', 1, '2026-10-10 18:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `table_reservations`
--

CREATE TABLE `table_reservations` (
  `id` int UNSIGNED NOT NULL,
  `booking_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `table_id` int UNSIGNED NOT NULL,
  `reservation_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `guests` tinyint UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','confirmed','seated','completed','cancelled','no_show') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `role_id` tinyint UNSIGNED NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `full_name`, `email`, `phone`, `password`, `is_active`, `created_at`) VALUES
(1, 4, 'Admin', 'admin@audrahaven.com', '08123456789', '$2y$12$PxBKzmA4csiF3p.KrbtXrOxFMEfpGtLrOhiwWeMSi.MhBJkbgTNKW', 1, '2026-10-11 04:19:50'),
(3, 3, 'Manager', 'manager@audrahaven.com', '089823412526', '$2y$12$bP6SUVcqr2zVlTpqJo3vd.V6p.tpbP5gsZ5HPXoakA1LwRdf19dPW', 1, '2026-10-21 05:16:47'),
(4, 1, 'Tamu', 'tamu@audrahaven.com', '087623451290', '$2y$12$vpdzZDaDoITInS2yedyu..dxIyPyT/FlptwuwAuV/oAige7espSba', 1, '2026-10-21 05:39:18'),
(5, 2, 'Resepsionis', 'resepsionis@audrahaven.com', '087834918811', '$2y$12$4AFuxIspJh5B3gOIHzPmEe1Nr3OXYQ6kA5XAQfWr0I7kuDyFxsXu2', 1, '2026-10-21 05:55:28'),
(6, 1, 'arthelino', 'arthaelinoskf@uhuyy.com', '087834557721', '$2y$12$r0JEz5U3xlKH6fJ2T6gGfe3FjC8WujcM3fRImCmPm1LuRAoHT2l0K', 1, '2026-10-24 03:24:15'),
(7, 1, 'Jeno Lee', 'jenowithsna@gmail.com', '08253645566', '$2y$12$Dx0TnaTIEEr.T3u8EXR0ROeEjdgcI4b4LqeryiumcehDWfeo4tfjy', 1, '2026-10-24 07:00:05'),
(8, 1, 'ist', 'ist@com', '09878975567', '$2y$12$synSugEe2KYcNxP9tZMXT.6cx9CHMbDJUTXWli0iTpUxsBOKp6cFq', 1, '2026-10-25 04:35:51'),
(9, 1, 'istt', 'istt@com', '087824449898', '$2y$12$XGQIDJM7MBEkddUhUJ9fKOXbRlel9e2vNz2N1fWs9D.CS1JULAOoW', 1, '2026-10-25 12:16:06'),
(10, 1, 'Isti Fuji', 'IstiFuji@gmail.com', '087899993424', '$2y$12$QOqv2SfOuSWBPVBZwAZmje0QeAZGnpxgtYQKnhKgNdhOAanPeyOjW', 1, '2026-10-25 14:02:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `facility_bookings`
--
ALTER TABLE `facility_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `idx_fb_overlap` (`facility_id`,`booking_date`,`start_time`,`end_time`),
  ADD KEY `idx_fb_user` (`user_id`),
  ADD KEY `idx_fb_status` (`status`),
  ADD KEY `fk_fb_slot` (`slot_id`);

--
-- Indexes for table `facility_photos`
--
ALTER TABLE `facility_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fphotos_fac` (`facility_id`);

--
-- Indexes for table `facility_slots`
--
ALTER TABLE `facility_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_slot` (`facility_id`,`start_time`,`end_time`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `hall_addons`
--
ALTER TABLE `hall_addons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `hall_bookings`
--
ALTER TABLE `hall_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `idx_hb_overlap` (`hall_id`,`event_date`,`session`),
  ADD KEY `idx_hb_user` (`user_id`),
  ADD KEY `fk_hb_pkg` (`package_id`),
  ADD KEY `fk_hb_promo` (`promo_id`);

--
-- Indexes for table `hall_booking_addons`
--
ALTER TABLE `hall_booking_addons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hba_booking` (`hall_booking_id`),
  ADD KEY `fk_hba_addon` (`addon_id`);

--
-- Indexes for table `hall_packages`
--
ALTER TABLE `hall_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `hall_photos`
--
ALTER TABLE `hall_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hphotos_hall` (`hall_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `idx_inv_ref` (`booking_type`,`booking_id`),
  ADD KEY `fk_inv_user` (`user_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `fk_ord_user` (`user_id`),
  ADD KEY `fk_ord_res` (`reservation_id`),
  ADD KEY `fk_ord_room` (`room_booking_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_oi_order` (`order_id`),
  ADD KEY `fk_oi_menu` (`menu_item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_code` (`payment_code`),
  ADD KEY `idx_pay_ref` (`booking_type`,`booking_id`),
  ADD KEY `idx_pay_status` (`status`),
  ADD KEY `fk_pay_user` (`user_id`),
  ADD KEY `fk_pay_ver` (`verified_by`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `table_number` (`table_number`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rev_target` (`target_type`,`target_id`),
  ADD KEY `fk_rev_user` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_number` (`room_number`),
  ADD KEY `fk_rooms_type` (`room_type_id`);

--
-- Indexes for table `room_bookings`
--
ALTER TABLE `room_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `idx_rb_overlap` (`room_id`,`check_in`,`check_out`),
  ADD KEY `idx_rb_user` (`user_id`),
  ADD KEY `idx_rb_status` (`status`),
  ADD KEY `fk_rb_promo` (`promo_id`);

--
-- Indexes for table `room_booking_nights`
--
ALTER TABLE `room_booking_nights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_rbn` (`room_booking_id`,`stay_date`);

--
-- Indexes for table `room_photos`
--
ALTER TABLE `room_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_roomphotos_type` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `table_reservations`
--
ALTER TABLE `table_reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `idx_tr_overlap` (`table_id`,`reservation_date`,`start_time`,`end_time`),
  ADD KEY `fk_tr_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `facility_bookings`
--
ALTER TABLE `facility_bookings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facility_photos`
--
ALTER TABLE `facility_photos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facility_slots`
--
ALTER TABLE `facility_slots`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hall_addons`
--
ALTER TABLE `hall_addons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hall_bookings`
--
ALTER TABLE `hall_bookings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hall_booking_addons`
--
ALTER TABLE `hall_booking_addons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hall_packages`
--
ALTER TABLE `hall_packages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hall_photos`
--
ALTER TABLE `hall_photos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `room_bookings`
--
ALTER TABLE `room_bookings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_booking_nights`
--
ALTER TABLE `room_booking_nights`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `room_photos`
--
ALTER TABLE `room_photos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_reservations`
--
ALTER TABLE `table_reservations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facility_bookings`
--
ALTER TABLE `facility_bookings`
  ADD CONSTRAINT `fk_fb_fac` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`),
  ADD CONSTRAINT `fk_fb_slot` FOREIGN KEY (`slot_id`) REFERENCES `facility_slots` (`id`),
  ADD CONSTRAINT `fk_fb_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `facility_photos`
--
ALTER TABLE `facility_photos`
  ADD CONSTRAINT `fk_fphotos_fac` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facility_slots`
--
ALTER TABLE `facility_slots`
  ADD CONSTRAINT `fk_slots_fac` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hall_bookings`
--
ALTER TABLE `hall_bookings`
  ADD CONSTRAINT `fk_hb_hall` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`),
  ADD CONSTRAINT `fk_hb_pkg` FOREIGN KEY (`package_id`) REFERENCES `hall_packages` (`id`),
  ADD CONSTRAINT `fk_hb_promo` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`id`),
  ADD CONSTRAINT `fk_hb_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hall_booking_addons`
--
ALTER TABLE `hall_booking_addons`
  ADD CONSTRAINT `fk_hba_addon` FOREIGN KEY (`addon_id`) REFERENCES `hall_addons` (`id`),
  ADD CONSTRAINT `fk_hba_booking` FOREIGN KEY (`hall_booking_id`) REFERENCES `hall_bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hall_photos`
--
ALTER TABLE `hall_photos`
  ADD CONSTRAINT `fk_hphotos_hall` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_inv_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_ord_res` FOREIGN KEY (`reservation_id`) REFERENCES `table_reservations` (`id`),
  ADD CONSTRAINT `fk_ord_room` FOREIGN KEY (`room_booking_id`) REFERENCES `room_bookings` (`id`),
  ADD CONSTRAINT `fk_ord_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_oi_menu` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`),
  ADD CONSTRAINT `fk_oi_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_pay_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_pay_ver` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_rev_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_rooms_type` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`);

--
-- Constraints for table `room_bookings`
--
ALTER TABLE `room_bookings`
  ADD CONSTRAINT `fk_rb_promo` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`id`),
  ADD CONSTRAINT `fk_rb_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `fk_rb_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `room_booking_nights`
--
ALTER TABLE `room_booking_nights`
  ADD CONSTRAINT `fk_rbn_booking` FOREIGN KEY (`room_booking_id`) REFERENCES `room_bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_photos`
--
ALTER TABLE `room_photos`
  ADD CONSTRAINT `fk_roomphotos_type` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `table_reservations`
--
ALTER TABLE `table_reservations`
  ADD CONSTRAINT `fk_tr_table` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`id`),
  ADD CONSTRAINT `fk_tr_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
