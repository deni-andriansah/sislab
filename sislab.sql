-- MySQL dump 10.13  Distrib 5.7.42, for Linux (x86_64)
--
-- Host: localhost    Database: sislab
-- ------------------------------------------------------
-- Server version	5.7.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anggotas`
--

DROP TABLE IF EXISTS `anggotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anggotas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_peminjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi_lembaga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `anggotas_nim_unique` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggotas`
--

LOCK TABLES `anggotas` WRITE;
/*!40000 ALTER TABLE `anggotas` DISABLE KEYS */;
/*!40000 ALTER TABLE `anggotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barangs`
--

DROP TABLE IF EXISTS `barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` bigint(20) unsigned NOT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barangs`
--

LOCK TABLES `barangs` WRITE;
/*!40000 ALTER TABLE `barangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_ruangans`
--

DROP TABLE IF EXISTS `detail_ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_maintenance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_barang` bigint(20) unsigned NOT NULL,
  `id_ruangan` bigint(20) unsigned NOT NULL,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_ruangans_id_barang_foreign` (`id_barang`),
  KEY `detail_ruangans_id_ruangan_foreign` (`id_ruangan`),
  CONSTRAINT `detail_ruangans_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barangs` (`id`),
  CONSTRAINT `detail_ruangans_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_ruangans`
--

LOCK TABLES `detail_ruangans` WRITE;
/*!40000 ALTER TABLE `detail_ruangans` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategoris`
--

DROP TABLE IF EXISTS `kategoris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategoris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategoris`
--

LOCK TABLES `kategoris` WRITE;
/*!40000 ALTER TABLE `kategoris` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategoris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kondisis`
--

DROP TABLE IF EXISTS `kondisis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kondisis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kondisis`
--

LOCK TABLES `kondisis` WRITE;
/*!40000 ALTER TABLE `kondisis` DISABLE KEYS */;
/*!40000 ALTER TABLE `kondisis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `l__barangs`
--

DROP TABLE IF EXISTS `l__barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `l__barangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pm_barang` bigint(20) unsigned NOT NULL,
  `id_kondisi` bigint(20) unsigned NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `l__barangs_id_pm_barang_foreign` (`id_pm_barang`),
  KEY `l__barangs_id_kondisi_foreign` (`id_kondisi`),
  CONSTRAINT `l__barangs_id_kondisi_foreign` FOREIGN KEY (`id_kondisi`) REFERENCES `kondisis` (`id`),
  CONSTRAINT `l__barangs_id_pm_barang_foreign` FOREIGN KEY (`id_pm_barang`) REFERENCES `pm__barangs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `l__barangs`
--

LOCK TABLES `l__barangs` WRITE;
/*!40000 ALTER TABLE `l__barangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `l__barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `l__ruangans`
--

DROP TABLE IF EXISTS `l__ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `l__ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pm_ruangan` bigint(20) unsigned NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `l__ruangans_id_pm_ruangan_foreign` (`id_pm_ruangan`),
  CONSTRAINT `l__ruangans_id_pm_ruangan_foreign` FOREIGN KEY (`id_pm_ruangan`) REFERENCES `pm__ruangans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `l__ruangans`
--

LOCK TABLES `l__ruangans` WRITE;
/*!40000 ALTER TABLE `l__ruangans` DISABLE KEYS */;
/*!40000 ALTER TABLE `l__ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lm__barangs`
--

DROP TABLE IF EXISTS `lm__barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lm__barangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_m_barang` bigint(20) unsigned NOT NULL,
  `tanggal_selesai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lm__barangs_id_m_barang_foreign` (`id_m_barang`),
  CONSTRAINT `lm__barangs_id_m_barang_foreign` FOREIGN KEY (`id_m_barang`) REFERENCES `m__barangs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lm__barangs`
--

LOCK TABLES `lm__barangs` WRITE;
/*!40000 ALTER TABLE `lm__barangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm__barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lm__ruangans`
--

DROP TABLE IF EXISTS `lm__ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lm__ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_m_ruangan` bigint(20) unsigned NOT NULL,
  `tanggal_selesai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lm__ruangans_id_m_ruangan_foreign` (`id_m_ruangan`),
  CONSTRAINT `lm__ruangans_id_m_ruangan_foreign` FOREIGN KEY (`id_m_ruangan`) REFERENCES `m__ruangans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lm__ruangans`
--

LOCK TABLES `lm__ruangans` WRITE;
/*!40000 ALTER TABLE `lm__ruangans` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm__ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m__barangs`
--

DROP TABLE IF EXISTS `m__barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m__barangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_maintenance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_barang` bigint(20) unsigned NOT NULL,
  `id_ruangan` bigint(20) unsigned NOT NULL,
  `tanggal_maintenance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_pengerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m__barangs_id_barang_foreign` (`id_barang`),
  KEY `m__barangs_id_ruangan_foreign` (`id_ruangan`),
  CONSTRAINT `m__barangs_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barangs` (`id`),
  CONSTRAINT `m__barangs_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m__barangs`
--

LOCK TABLES `m__barangs` WRITE;
/*!40000 ALTER TABLE `m__barangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `m__barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m__ruangans`
--

DROP TABLE IF EXISTS `m__ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m__ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_maintenance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ruangan` bigint(20) unsigned NOT NULL,
  `tanggal_maintenance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_pengerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m__ruangans_id_ruangan_foreign` (`id_ruangan`),
  CONSTRAINT `m__ruangans_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m__ruangans`
--

LOCK TABLES `m__ruangans` WRITE;
/*!40000 ALTER TABLE `m__ruangans` DISABLE KEYS */;
/*!40000 ALTER TABLE `m__ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2024_09_09_020630_create_ruangans_table',1),(7,'2024_09_09_032718_create_kondisis_table',1),(8,'2024_09_09_061257_create_barangs_table',1),(9,'2024_09_10_012731_create_m__barangs_table',1),(10,'2024_09_10_053918_create_lm__barangs_table',1),(11,'2024_09_12_012002_create_pm__barangs_table',1),(12,'2024_09_12_021916_create_pm__ruangans_table',1),(13,'2024_09_12_070832_create_m__ruangans_table',1),(14,'2024_09_12_073208_create_lm__ruangans_table',1),(15,'2024_09_13_042033_create_l__barangs_table',1),(16,'2024_09_13_062939_create_l__ruangans_table',1),(17,'2024_10_22_031159_create_detail_ruangans_table',1),(18,'2024_10_22_031210_create_kategoris_table',1),(19,'2025_01_09_062142_create_p_barangs_table',1),(20,'2025_01_09_062152_create_p_ruangans_table',1),(21,'2025_01_09_064647_create_anggotas_table',1),(22,'2025_03_17_070522_create_peminjaman_details_table',1),(23,'2025_04_09_195427_create_peminjaman_detail_ruangans_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p_barangs`
--

DROP TABLE IF EXISTS `p_barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p_barangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pm_barang` bigint(20) unsigned NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p_barangs`
--

LOCK TABLES `p_barangs` WRITE;
/*!40000 ALTER TABLE `p_barangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `p_barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p_ruangans`
--

DROP TABLE IF EXISTS `p_ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p_ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pm_ruangan` bigint(20) unsigned NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `p_ruangans_id_pm_ruangan_foreign` (`id_pm_ruangan`),
  CONSTRAINT `p_ruangans_id_pm_ruangan_foreign` FOREIGN KEY (`id_pm_ruangan`) REFERENCES `pm__ruangans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p_ruangans`
--

LOCK TABLES `p_ruangans` WRITE;
/*!40000 ALTER TABLE `p_ruangans` DISABLE KEYS */;
/*!40000 ALTER TABLE `p_ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman_detail_ruangans`
--

DROP TABLE IF EXISTS `peminjaman_detail_ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman_detail_ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pm_ruangan` bigint(20) unsigned NOT NULL,
  `id_ruangan` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman_detail_ruangans`
--

LOCK TABLES `peminjaman_detail_ruangans` WRITE;
/*!40000 ALTER TABLE `peminjaman_detail_ruangans` DISABLE KEYS */;
/*!40000 ALTER TABLE `peminjaman_detail_ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman_details`
--

DROP TABLE IF EXISTS `peminjaman_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pm_barang` bigint(20) unsigned NOT NULL,
  `id_barang` bigint(20) unsigned DEFAULT NULL,
  `jumlah_pinjam` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman_details`
--

LOCK TABLES `peminjaman_details` WRITE;
/*!40000 ALTER TABLE `peminjaman_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `peminjaman_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pm__barangs`
--

DROP TABLE IF EXISTS `pm__barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pm__barangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_peminjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_anggota` bigint(20) unsigned NOT NULL,
  `jenis_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ruangan` bigint(20) unsigned NOT NULL,
  `tanggal_peminjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pengembalian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_peminjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pm__barangs_id_ruangan_foreign` (`id_ruangan`),
  CONSTRAINT `pm__barangs_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pm__barangs`
--

LOCK TABLES `pm__barangs` WRITE;
/*!40000 ALTER TABLE `pm__barangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pm__barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pm__ruangans`
--

DROP TABLE IF EXISTS `pm__ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pm__ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_peminjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_anggota` bigint(20) unsigned NOT NULL,
  `tanggal_peminjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pengembalian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_peminjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pm__ruangans`
--

LOCK TABLES `pm__ruangans` WRITE;
/*!40000 ALTER TABLE `pm__ruangans` DISABLE KEYS */;
/*!40000 ALTER TABLE `pm__ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ruangans`
--

DROP TABLE IF EXISTS `ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posisi_ruangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ruangans`
--

LOCK TABLES `ruangans` WRITE;
/*!40000 ALTER TABLE `ruangans` DISABLE KEYS */;
/*!40000 ALTER TABLE `ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@email.com',NULL,'$2y$10$AyXJPJIBqHoJtkyEjAGU/.1jbMntVwYrldlV51U4l96iXUj7znbKm',NULL,'2025-07-21 02:53:35','2025-07-21 02:53:38');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sislab'
--

--
-- Dumping routines for database 'sislab'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-02 12:46:14
