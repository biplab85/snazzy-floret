-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2026 at 11:09 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sklentr_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `sk_commentmeta`
--

DROP TABLE IF EXISTS `sk_commentmeta`;
CREATE TABLE IF NOT EXISTS `sk_commentmeta` (
  `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_comments`
--

DROP TABLE IF EXISTS `sk_comments`;
CREATE TABLE IF NOT EXISTS `sk_comments` (
  `comment_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint UNSIGNED NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_karma` int NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_e_events`
--

DROP TABLE IF EXISTS `sk_e_events`;
CREATE TABLE IF NOT EXISTS `sk_e_events` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_data` text COLLATE utf8mb4_unicode_520_ci,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_at_index` (`created_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_links`
--

DROP TABLE IF EXISTS `sk_links`;
CREATE TABLE IF NOT EXISTS `sk_links` (
  `link_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint UNSIGNED NOT NULL DEFAULT '1',
  `link_rating` int NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_options`
--

DROP TABLE IF EXISTS `sk_options`;
CREATE TABLE IF NOT EXISTS `sk_options` (
  `option_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`),
  KEY `autoload` (`autoload`)
) ENGINE=MyISAM AUTO_INCREMENT=782 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `sk_options`
--

INSERT INTO `sk_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'cron', 'a:11:{i:1785133740;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1785151740;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1785151895;a:1:{s:28:\"elementor/tracker/send_event\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1785152214;a:3:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:21:\"wp_update_user_counts\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1785152216;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1785155339;a:1:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1785157139;a:1:{s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1785158939;a:1:{s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1785324558;a:1:{s:30:\"wp_delete_temp_updater_backups\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1785410940;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'on'),
(2, 'siteurl', 'http://localhost/sklentr/sklentr-v2', 'on'),
(3, 'home', 'http://localhost/sklentr/sklentr-v2', 'on'),
(4, 'blogname', 'SKL Entr — Launch-Ready MVPs', 'on'),
(5, 'blogdescription', '', 'on'),
(6, 'users_can_register', '0', 'on'),
(7, 'admin_email', 'rishad@sklentr.com', 'on'),
(8, 'start_of_week', '1', 'on'),
(9, 'use_balanceTags', '0', 'on'),
(10, 'use_smilies', '1', 'on'),
(11, 'require_name_email', '1', 'on'),
(12, 'comments_notify', '1', 'on'),
(13, 'posts_per_rss', '10', 'on'),
(14, 'rss_use_excerpt', '0', 'on'),
(15, 'mailserver_url', 'mail.example.com', 'on'),
(16, 'mailserver_login', 'login@example.com', 'on'),
(17, 'mailserver_pass', '', 'on'),
(18, 'mailserver_port', '110', 'on'),
(19, 'default_category', '1', 'on'),
(20, 'default_comment_status', 'open', 'on'),
(21, 'default_ping_status', 'open', 'on'),
(22, 'default_pingback_flag', '1', 'on'),
(23, 'posts_per_page', '10', 'on'),
(24, 'date_format', 'F j, Y', 'on'),
(25, 'time_format', 'g:i a', 'on'),
(26, 'links_updated_date_format', 'F j, Y g:i a', 'on'),
(27, 'comment_moderation', '0', 'on'),
(28, 'moderation_notify', '1', 'on'),
(29, 'permalink_structure', '/blog/%postname%/', 'on'),
(30, 'rewrite_rules', 'a:92:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:39:\"index.php?&page_id=14&cpage=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:52:\"blog/author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:47:\"blog/author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:28:\"blog/author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:40:\"blog/author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:22:\"blog/author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:74:\"blog/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:69:\"blog/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:50:\"blog/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:62:\"blog/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:44:\"blog/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:61:\"blog/([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:56:\"blog/([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:37:\"blog/([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:49:\"blog/([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:31:\"blog/([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:48:\"blog/([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:43:\"blog/([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:24:\"blog/([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:36:\"blog/([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:18:\"blog/([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:32:\"blog/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:42:\"blog/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:62:\"blog/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:57:\"blog/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:57:\"blog/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:38:\"blog/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:21:\"blog/([^/]+)/embed/?$\";s:37:\"index.php?name=$matches[1]&embed=true\";s:25:\"blog/([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:45:\"blog/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:40:\"blog/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:33:\"blog/([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:40:\"blog/([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:29:\"blog/([^/]+)(?:/([0-9]+))?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:21:\"blog/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:31:\"blog/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:51:\"blog/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:46:\"blog/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:46:\"blog/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:27:\"blog/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";}', 'on'),
(31, 'hack_file', '0', 'on'),
(32, 'blog_charset', 'UTF-8', 'on'),
(33, 'moderation_keys', '', 'off'),
(34, 'active_plugins', 'a:0:{}', 'on'),
(35, 'category_base', '', 'on'),
(36, 'ping_sites', 'https://rpc.pingomatic.com/', 'on'),
(37, 'comment_max_links', '2', 'on'),
(38, 'gmt_offset', '0', 'on'),
(39, 'default_email_category', '1', 'on'),
(40, 'recently_edited', '', 'off'),
(41, 'template', 'sklentr', 'on'),
(42, 'stylesheet', 'sklentr', 'on'),
(43, 'comment_registration', '0', 'on'),
(44, 'html_type', 'text/html', 'on'),
(45, 'use_trackback', '0', 'on'),
(46, 'default_role', 'subscriber', 'on'),
(47, 'db_version', '61833', 'on'),
(48, 'uploads_use_yearmonth_folders', '1', 'on'),
(49, 'upload_path', '', 'on'),
(50, 'blog_public', '1', 'on'),
(51, 'default_link_category', '2', 'on'),
(52, 'show_on_front', 'page', 'on'),
(53, 'tag_base', '', 'on'),
(54, 'show_avatars', '1', 'on'),
(55, 'avatar_rating', 'G', 'on'),
(56, 'upload_url_path', '', 'on'),
(57, 'thumbnail_size_w', '150', 'on'),
(58, 'thumbnail_size_h', '150', 'on'),
(59, 'thumbnail_crop', '1', 'on'),
(60, 'medium_size_w', '300', 'on'),
(61, 'medium_size_h', '300', 'on'),
(62, 'avatar_default', 'mystery', 'on'),
(63, 'large_size_w', '1024', 'on'),
(64, 'large_size_h', '1024', 'on'),
(65, 'image_default_link_type', 'none', 'on'),
(66, 'image_default_size', '', 'on'),
(67, 'image_default_align', '', 'on'),
(68, 'close_comments_for_old_posts', '0', 'on'),
(69, 'close_comments_days_old', '14', 'on'),
(70, 'thread_comments', '1', 'on'),
(71, 'thread_comments_depth', '5', 'on'),
(72, 'page_comments', '0', 'on'),
(73, 'comments_per_page', '50', 'on'),
(74, 'default_comments_page', 'newest', 'on'),
(75, 'comment_order', 'asc', 'on'),
(76, 'sticky_posts', 'a:0:{}', 'on'),
(77, 'widget_categories', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'auto'),
(78, 'widget_text', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'auto'),
(79, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'auto'),
(80, 'uninstall_plugins', 'a:1:{s:23:\"elementor/elementor.php\";a:2:{i:0;s:21:\"Elementor\\Maintenance\";i:1;s:9:\"uninstall\";}}', 'off'),
(81, 'timezone_string', '', 'on'),
(82, 'page_for_posts', '0', 'on'),
(83, 'page_on_front', '14', 'on'),
(84, 'default_post_format', '0', 'on'),
(85, 'link_manager_enabled', '0', 'on'),
(86, 'finished_splitting_shared_terms', '1', 'on'),
(87, 'site_icon', '0', 'on'),
(88, 'medium_large_size_w', '768', 'on'),
(89, 'medium_large_size_h', '0', 'on'),
(90, 'wp_page_for_privacy_policy', '3', 'on'),
(91, 'show_comments_cookies_opt_in', '1', 'on'),
(92, 'admin_email_lifespan', '1799666939', 'on'),
(93, 'disallowed_keys', '', 'off'),
(94, 'comment_previously_approved', '1', 'on'),
(95, 'auto_plugin_theme_update_emails', 'a:0:{}', 'off'),
(96, 'auto_update_core_dev', 'enabled', 'on'),
(97, 'auto_update_core_minor', 'enabled', 'on'),
(98, 'auto_update_core_major', 'enabled', 'on'),
(99, 'wp_force_deactivated_plugins', 'a:0:{}', 'on'),
(100, 'wp_attachment_pages_enabled', '0', 'on'),
(101, 'wp_notes_notify', '1', 'on'),
(102, 'initial_db_version', '61833', 'on'),
(103, 'sk_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:66:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:42:\"elementor_atomic_widgets_access_styles_tab\";b:1;s:45:\"elementor_atomic_widgets_edit_local_css_class\";b:1;s:37:\"elementor_global_classes_update_class\";b:1;s:37:\"elementor_global_classes_remove_class\";b:1;s:36:\"elementor_global_classes_apply_class\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:38:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:42:\"elementor_atomic_widgets_access_styles_tab\";b:1;s:45:\"elementor_atomic_widgets_edit_local_css_class\";b:1;s:37:\"elementor_global_classes_remove_class\";b:1;s:36:\"elementor_global_classes_apply_class\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:14:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:42:\"elementor_atomic_widgets_access_styles_tab\";b:1;s:45:\"elementor_atomic_widgets_edit_local_css_class\";b:1;s:37:\"elementor_global_classes_remove_class\";b:1;s:36:\"elementor_global_classes_apply_class\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:9:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:42:\"elementor_atomic_widgets_access_styles_tab\";b:1;s:45:\"elementor_atomic_widgets_edit_local_css_class\";b:1;s:37:\"elementor_global_classes_remove_class\";b:1;s:36:\"elementor_global_classes_apply_class\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'on'),
(104, 'fresh_site', '0', 'off'),
(105, 'user_count', '1', 'off'),
(106, 'widget_block', 'a:6:{i:2;a:1:{s:7:\"content\";s:19:\"<!-- wp:search /-->\";}i:3;a:1:{s:7:\"content\";s:154:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Recent Posts</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->\";}i:4;a:1:{s:7:\"content\";s:227:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Recent Comments</h2><!-- /wp:heading --><!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div><!-- /wp:group -->\";}i:5;a:1:{s:7:\"content\";s:146:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Archives</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:6;a:1:{s:7:\"content\";s:150:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Categories</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}s:12:\"_multiwidget\";i:1;}', 'auto'),
(107, 'sidebars_widgets', 'a:2:{s:19:\"wp_inactive_widgets\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:13:\"array_version\";i:3;}', 'auto'),
(108, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(109, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(110, 'widget_archives', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(111, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(112, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(113, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(114, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(115, 'widget_meta', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(116, 'widget_search', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(117, 'widget_recent-posts', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(118, 'widget_recent-comments', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(119, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(120, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(121, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'auto'),
(122, '_transient_wp_core_block_css_files', 'a:2:{s:7:\"version\";s:5:\"7.0.1\";s:5:\"files\";a:596:{i:0;s:31:\"accordion-heading/style-rtl.css\";i:1;s:35:\"accordion-heading/style-rtl.min.css\";i:2;s:27:\"accordion-heading/style.css\";i:3;s:31:\"accordion-heading/style.min.css\";i:4;s:28:\"accordion-item/style-rtl.css\";i:5;s:32:\"accordion-item/style-rtl.min.css\";i:6;s:24:\"accordion-item/style.css\";i:7;s:28:\"accordion-item/style.min.css\";i:8;s:29:\"accordion-panel/style-rtl.css\";i:9;s:33:\"accordion-panel/style-rtl.min.css\";i:10;s:25:\"accordion-panel/style.css\";i:11;s:29:\"accordion-panel/style.min.css\";i:12;s:23:\"accordion/style-rtl.css\";i:13;s:27:\"accordion/style-rtl.min.css\";i:14;s:19:\"accordion/style.css\";i:15;s:23:\"accordion/style.min.css\";i:16;s:22:\"archives/style-rtl.css\";i:17;s:26:\"archives/style-rtl.min.css\";i:18;s:18:\"archives/style.css\";i:19;s:22:\"archives/style.min.css\";i:20;s:20:\"audio/editor-rtl.css\";i:21;s:24:\"audio/editor-rtl.min.css\";i:22;s:16:\"audio/editor.css\";i:23;s:20:\"audio/editor.min.css\";i:24;s:19:\"audio/style-rtl.css\";i:25;s:23:\"audio/style-rtl.min.css\";i:26;s:15:\"audio/style.css\";i:27;s:19:\"audio/style.min.css\";i:28;s:19:\"audio/theme-rtl.css\";i:29;s:23:\"audio/theme-rtl.min.css\";i:30;s:15:\"audio/theme.css\";i:31;s:19:\"audio/theme.min.css\";i:32;s:21:\"avatar/editor-rtl.css\";i:33;s:25:\"avatar/editor-rtl.min.css\";i:34;s:17:\"avatar/editor.css\";i:35;s:21:\"avatar/editor.min.css\";i:36;s:20:\"avatar/style-rtl.css\";i:37;s:24:\"avatar/style-rtl.min.css\";i:38;s:16:\"avatar/style.css\";i:39;s:20:\"avatar/style.min.css\";i:40;s:25:\"breadcrumbs/style-rtl.css\";i:41;s:29:\"breadcrumbs/style-rtl.min.css\";i:42;s:21:\"breadcrumbs/style.css\";i:43;s:25:\"breadcrumbs/style.min.css\";i:44;s:21:\"button/editor-rtl.css\";i:45;s:25:\"button/editor-rtl.min.css\";i:46;s:17:\"button/editor.css\";i:47;s:21:\"button/editor.min.css\";i:48;s:20:\"button/style-rtl.css\";i:49;s:24:\"button/style-rtl.min.css\";i:50;s:16:\"button/style.css\";i:51;s:20:\"button/style.min.css\";i:52;s:22:\"buttons/editor-rtl.css\";i:53;s:26:\"buttons/editor-rtl.min.css\";i:54;s:18:\"buttons/editor.css\";i:55;s:22:\"buttons/editor.min.css\";i:56;s:21:\"buttons/style-rtl.css\";i:57;s:25:\"buttons/style-rtl.min.css\";i:58;s:17:\"buttons/style.css\";i:59;s:21:\"buttons/style.min.css\";i:60;s:22:\"calendar/style-rtl.css\";i:61;s:26:\"calendar/style-rtl.min.css\";i:62;s:18:\"calendar/style.css\";i:63;s:22:\"calendar/style.min.css\";i:64;s:25:\"categories/editor-rtl.css\";i:65;s:29:\"categories/editor-rtl.min.css\";i:66;s:21:\"categories/editor.css\";i:67;s:25:\"categories/editor.min.css\";i:68;s:24:\"categories/style-rtl.css\";i:69;s:28:\"categories/style-rtl.min.css\";i:70;s:20:\"categories/style.css\";i:71;s:24:\"categories/style.min.css\";i:72;s:19:\"code/editor-rtl.css\";i:73;s:23:\"code/editor-rtl.min.css\";i:74;s:15:\"code/editor.css\";i:75;s:19:\"code/editor.min.css\";i:76;s:18:\"code/style-rtl.css\";i:77;s:22:\"code/style-rtl.min.css\";i:78;s:14:\"code/style.css\";i:79;s:18:\"code/style.min.css\";i:80;s:18:\"code/theme-rtl.css\";i:81;s:22:\"code/theme-rtl.min.css\";i:82;s:14:\"code/theme.css\";i:83;s:18:\"code/theme.min.css\";i:84;s:22:\"columns/editor-rtl.css\";i:85;s:26:\"columns/editor-rtl.min.css\";i:86;s:18:\"columns/editor.css\";i:87;s:22:\"columns/editor.min.css\";i:88;s:21:\"columns/style-rtl.css\";i:89;s:25:\"columns/style-rtl.min.css\";i:90;s:17:\"columns/style.css\";i:91;s:21:\"columns/style.min.css\";i:92;s:33:\"comment-author-name/style-rtl.css\";i:93;s:37:\"comment-author-name/style-rtl.min.css\";i:94;s:29:\"comment-author-name/style.css\";i:95;s:33:\"comment-author-name/style.min.css\";i:96;s:29:\"comment-content/style-rtl.css\";i:97;s:33:\"comment-content/style-rtl.min.css\";i:98;s:25:\"comment-content/style.css\";i:99;s:29:\"comment-content/style.min.css\";i:100;s:26:\"comment-date/style-rtl.css\";i:101;s:30:\"comment-date/style-rtl.min.css\";i:102;s:22:\"comment-date/style.css\";i:103;s:26:\"comment-date/style.min.css\";i:104;s:31:\"comment-edit-link/style-rtl.css\";i:105;s:35:\"comment-edit-link/style-rtl.min.css\";i:106;s:27:\"comment-edit-link/style.css\";i:107;s:31:\"comment-edit-link/style.min.css\";i:108;s:32:\"comment-reply-link/style-rtl.css\";i:109;s:36:\"comment-reply-link/style-rtl.min.css\";i:110;s:28:\"comment-reply-link/style.css\";i:111;s:32:\"comment-reply-link/style.min.css\";i:112;s:30:\"comment-template/style-rtl.css\";i:113;s:34:\"comment-template/style-rtl.min.css\";i:114;s:26:\"comment-template/style.css\";i:115;s:30:\"comment-template/style.min.css\";i:116;s:42:\"comments-pagination-numbers/editor-rtl.css\";i:117;s:46:\"comments-pagination-numbers/editor-rtl.min.css\";i:118;s:38:\"comments-pagination-numbers/editor.css\";i:119;s:42:\"comments-pagination-numbers/editor.min.css\";i:120;s:34:\"comments-pagination/editor-rtl.css\";i:121;s:38:\"comments-pagination/editor-rtl.min.css\";i:122;s:30:\"comments-pagination/editor.css\";i:123;s:34:\"comments-pagination/editor.min.css\";i:124;s:33:\"comments-pagination/style-rtl.css\";i:125;s:37:\"comments-pagination/style-rtl.min.css\";i:126;s:29:\"comments-pagination/style.css\";i:127;s:33:\"comments-pagination/style.min.css\";i:128;s:29:\"comments-title/editor-rtl.css\";i:129;s:33:\"comments-title/editor-rtl.min.css\";i:130;s:25:\"comments-title/editor.css\";i:131;s:29:\"comments-title/editor.min.css\";i:132;s:23:\"comments/editor-rtl.css\";i:133;s:27:\"comments/editor-rtl.min.css\";i:134;s:19:\"comments/editor.css\";i:135;s:23:\"comments/editor.min.css\";i:136;s:22:\"comments/style-rtl.css\";i:137;s:26:\"comments/style-rtl.min.css\";i:138;s:18:\"comments/style.css\";i:139;s:22:\"comments/style.min.css\";i:140;s:20:\"cover/editor-rtl.css\";i:141;s:24:\"cover/editor-rtl.min.css\";i:142;s:16:\"cover/editor.css\";i:143;s:20:\"cover/editor.min.css\";i:144;s:19:\"cover/style-rtl.css\";i:145;s:23:\"cover/style-rtl.min.css\";i:146;s:15:\"cover/style.css\";i:147;s:19:\"cover/style.min.css\";i:148;s:22:\"details/editor-rtl.css\";i:149;s:26:\"details/editor-rtl.min.css\";i:150;s:18:\"details/editor.css\";i:151;s:22:\"details/editor.min.css\";i:152;s:21:\"details/style-rtl.css\";i:153;s:25:\"details/style-rtl.min.css\";i:154;s:17:\"details/style.css\";i:155;s:21:\"details/style.min.css\";i:156;s:20:\"embed/editor-rtl.css\";i:157;s:24:\"embed/editor-rtl.min.css\";i:158;s:16:\"embed/editor.css\";i:159;s:20:\"embed/editor.min.css\";i:160;s:19:\"embed/style-rtl.css\";i:161;s:23:\"embed/style-rtl.min.css\";i:162;s:15:\"embed/style.css\";i:163;s:19:\"embed/style.min.css\";i:164;s:19:\"embed/theme-rtl.css\";i:165;s:23:\"embed/theme-rtl.min.css\";i:166;s:15:\"embed/theme.css\";i:167;s:19:\"embed/theme.min.css\";i:168;s:19:\"file/editor-rtl.css\";i:169;s:23:\"file/editor-rtl.min.css\";i:170;s:15:\"file/editor.css\";i:171;s:19:\"file/editor.min.css\";i:172;s:18:\"file/style-rtl.css\";i:173;s:22:\"file/style-rtl.min.css\";i:174;s:14:\"file/style.css\";i:175;s:18:\"file/style.min.css\";i:176;s:23:\"footnotes/style-rtl.css\";i:177;s:27:\"footnotes/style-rtl.min.css\";i:178;s:19:\"footnotes/style.css\";i:179;s:23:\"footnotes/style.min.css\";i:180;s:23:\"freeform/editor-rtl.css\";i:181;s:27:\"freeform/editor-rtl.min.css\";i:182;s:19:\"freeform/editor.css\";i:183;s:23:\"freeform/editor.min.css\";i:184;s:22:\"gallery/editor-rtl.css\";i:185;s:26:\"gallery/editor-rtl.min.css\";i:186;s:18:\"gallery/editor.css\";i:187;s:22:\"gallery/editor.min.css\";i:188;s:21:\"gallery/style-rtl.css\";i:189;s:25:\"gallery/style-rtl.min.css\";i:190;s:17:\"gallery/style.css\";i:191;s:21:\"gallery/style.min.css\";i:192;s:21:\"gallery/theme-rtl.css\";i:193;s:25:\"gallery/theme-rtl.min.css\";i:194;s:17:\"gallery/theme.css\";i:195;s:21:\"gallery/theme.min.css\";i:196;s:20:\"group/editor-rtl.css\";i:197;s:24:\"group/editor-rtl.min.css\";i:198;s:16:\"group/editor.css\";i:199;s:20:\"group/editor.min.css\";i:200;s:19:\"group/style-rtl.css\";i:201;s:23:\"group/style-rtl.min.css\";i:202;s:15:\"group/style.css\";i:203;s:19:\"group/style.min.css\";i:204;s:19:\"group/theme-rtl.css\";i:205;s:23:\"group/theme-rtl.min.css\";i:206;s:15:\"group/theme.css\";i:207;s:19:\"group/theme.min.css\";i:208;s:21:\"heading/style-rtl.css\";i:209;s:25:\"heading/style-rtl.min.css\";i:210;s:17:\"heading/style.css\";i:211;s:21:\"heading/style.min.css\";i:212;s:19:\"html/editor-rtl.css\";i:213;s:23:\"html/editor-rtl.min.css\";i:214;s:15:\"html/editor.css\";i:215;s:19:\"html/editor.min.css\";i:216;s:19:\"icon/editor-rtl.css\";i:217;s:23:\"icon/editor-rtl.min.css\";i:218;s:15:\"icon/editor.css\";i:219;s:19:\"icon/editor.min.css\";i:220;s:18:\"icon/style-rtl.css\";i:221;s:22:\"icon/style-rtl.min.css\";i:222;s:14:\"icon/style.css\";i:223;s:18:\"icon/style.min.css\";i:224;s:20:\"image/editor-rtl.css\";i:225;s:24:\"image/editor-rtl.min.css\";i:226;s:16:\"image/editor.css\";i:227;s:20:\"image/editor.min.css\";i:228;s:19:\"image/style-rtl.css\";i:229;s:23:\"image/style-rtl.min.css\";i:230;s:15:\"image/style.css\";i:231;s:19:\"image/style.min.css\";i:232;s:19:\"image/theme-rtl.css\";i:233;s:23:\"image/theme-rtl.min.css\";i:234;s:15:\"image/theme.css\";i:235;s:19:\"image/theme.min.css\";i:236;s:29:\"latest-comments/style-rtl.css\";i:237;s:33:\"latest-comments/style-rtl.min.css\";i:238;s:25:\"latest-comments/style.css\";i:239;s:29:\"latest-comments/style.min.css\";i:240;s:27:\"latest-posts/editor-rtl.css\";i:241;s:31:\"latest-posts/editor-rtl.min.css\";i:242;s:23:\"latest-posts/editor.css\";i:243;s:27:\"latest-posts/editor.min.css\";i:244;s:26:\"latest-posts/style-rtl.css\";i:245;s:30:\"latest-posts/style-rtl.min.css\";i:246;s:22:\"latest-posts/style.css\";i:247;s:26:\"latest-posts/style.min.css\";i:248;s:18:\"list/style-rtl.css\";i:249;s:22:\"list/style-rtl.min.css\";i:250;s:14:\"list/style.css\";i:251;s:18:\"list/style.min.css\";i:252;s:22:\"loginout/style-rtl.css\";i:253;s:26:\"loginout/style-rtl.min.css\";i:254;s:18:\"loginout/style.css\";i:255;s:22:\"loginout/style.min.css\";i:256;s:19:\"math/editor-rtl.css\";i:257;s:23:\"math/editor-rtl.min.css\";i:258;s:15:\"math/editor.css\";i:259;s:19:\"math/editor.min.css\";i:260;s:18:\"math/style-rtl.css\";i:261;s:22:\"math/style-rtl.min.css\";i:262;s:14:\"math/style.css\";i:263;s:18:\"math/style.min.css\";i:264;s:25:\"media-text/editor-rtl.css\";i:265;s:29:\"media-text/editor-rtl.min.css\";i:266;s:21:\"media-text/editor.css\";i:267;s:25:\"media-text/editor.min.css\";i:268;s:24:\"media-text/style-rtl.css\";i:269;s:28:\"media-text/style-rtl.min.css\";i:270;s:20:\"media-text/style.css\";i:271;s:24:\"media-text/style.min.css\";i:272;s:19:\"more/editor-rtl.css\";i:273;s:23:\"more/editor-rtl.min.css\";i:274;s:15:\"more/editor.css\";i:275;s:19:\"more/editor.min.css\";i:276;s:30:\"navigation-link/editor-rtl.css\";i:277;s:34:\"navigation-link/editor-rtl.min.css\";i:278;s:26:\"navigation-link/editor.css\";i:279;s:30:\"navigation-link/editor.min.css\";i:280;s:29:\"navigation-link/style-rtl.css\";i:281;s:33:\"navigation-link/style-rtl.min.css\";i:282;s:25:\"navigation-link/style.css\";i:283;s:29:\"navigation-link/style.min.css\";i:284;s:38:\"navigation-overlay-close/style-rtl.css\";i:285;s:42:\"navigation-overlay-close/style-rtl.min.css\";i:286;s:34:\"navigation-overlay-close/style.css\";i:287;s:38:\"navigation-overlay-close/style.min.css\";i:288;s:33:\"navigation-submenu/editor-rtl.css\";i:289;s:37:\"navigation-submenu/editor-rtl.min.css\";i:290;s:29:\"navigation-submenu/editor.css\";i:291;s:33:\"navigation-submenu/editor.min.css\";i:292;s:25:\"navigation/editor-rtl.css\";i:293;s:29:\"navigation/editor-rtl.min.css\";i:294;s:21:\"navigation/editor.css\";i:295;s:25:\"navigation/editor.min.css\";i:296;s:24:\"navigation/style-rtl.css\";i:297;s:28:\"navigation/style-rtl.min.css\";i:298;s:20:\"navigation/style.css\";i:299;s:24:\"navigation/style.min.css\";i:300;s:23:\"nextpage/editor-rtl.css\";i:301;s:27:\"nextpage/editor-rtl.min.css\";i:302;s:19:\"nextpage/editor.css\";i:303;s:23:\"nextpage/editor.min.css\";i:304;s:24:\"page-list/editor-rtl.css\";i:305;s:28:\"page-list/editor-rtl.min.css\";i:306;s:20:\"page-list/editor.css\";i:307;s:24:\"page-list/editor.min.css\";i:308;s:23:\"page-list/style-rtl.css\";i:309;s:27:\"page-list/style-rtl.min.css\";i:310;s:19:\"page-list/style.css\";i:311;s:23:\"page-list/style.min.css\";i:312;s:24:\"paragraph/editor-rtl.css\";i:313;s:28:\"paragraph/editor-rtl.min.css\";i:314;s:20:\"paragraph/editor.css\";i:315;s:24:\"paragraph/editor.min.css\";i:316;s:23:\"paragraph/style-rtl.css\";i:317;s:27:\"paragraph/style-rtl.min.css\";i:318;s:19:\"paragraph/style.css\";i:319;s:23:\"paragraph/style.min.css\";i:320;s:35:\"post-author-biography/style-rtl.css\";i:321;s:39:\"post-author-biography/style-rtl.min.css\";i:322;s:31:\"post-author-biography/style.css\";i:323;s:35:\"post-author-biography/style.min.css\";i:324;s:30:\"post-author-name/style-rtl.css\";i:325;s:34:\"post-author-name/style-rtl.min.css\";i:326;s:26:\"post-author-name/style.css\";i:327;s:30:\"post-author-name/style.min.css\";i:328;s:26:\"post-author/editor-rtl.css\";i:329;s:30:\"post-author/editor-rtl.min.css\";i:330;s:22:\"post-author/editor.css\";i:331;s:26:\"post-author/editor.min.css\";i:332;s:25:\"post-author/style-rtl.css\";i:333;s:29:\"post-author/style-rtl.min.css\";i:334;s:21:\"post-author/style.css\";i:335;s:25:\"post-author/style.min.css\";i:336;s:33:\"post-comments-count/style-rtl.css\";i:337;s:37:\"post-comments-count/style-rtl.min.css\";i:338;s:29:\"post-comments-count/style.css\";i:339;s:33:\"post-comments-count/style.min.css\";i:340;s:33:\"post-comments-form/editor-rtl.css\";i:341;s:37:\"post-comments-form/editor-rtl.min.css\";i:342;s:29:\"post-comments-form/editor.css\";i:343;s:33:\"post-comments-form/editor.min.css\";i:344;s:32:\"post-comments-form/style-rtl.css\";i:345;s:36:\"post-comments-form/style-rtl.min.css\";i:346;s:28:\"post-comments-form/style.css\";i:347;s:32:\"post-comments-form/style.min.css\";i:348;s:32:\"post-comments-link/style-rtl.css\";i:349;s:36:\"post-comments-link/style-rtl.min.css\";i:350;s:28:\"post-comments-link/style.css\";i:351;s:32:\"post-comments-link/style.min.css\";i:352;s:26:\"post-content/style-rtl.css\";i:353;s:30:\"post-content/style-rtl.min.css\";i:354;s:22:\"post-content/style.css\";i:355;s:26:\"post-content/style.min.css\";i:356;s:23:\"post-date/style-rtl.css\";i:357;s:27:\"post-date/style-rtl.min.css\";i:358;s:19:\"post-date/style.css\";i:359;s:23:\"post-date/style.min.css\";i:360;s:27:\"post-excerpt/editor-rtl.css\";i:361;s:31:\"post-excerpt/editor-rtl.min.css\";i:362;s:23:\"post-excerpt/editor.css\";i:363;s:27:\"post-excerpt/editor.min.css\";i:364;s:26:\"post-excerpt/style-rtl.css\";i:365;s:30:\"post-excerpt/style-rtl.min.css\";i:366;s:22:\"post-excerpt/style.css\";i:367;s:26:\"post-excerpt/style.min.css\";i:368;s:34:\"post-featured-image/editor-rtl.css\";i:369;s:38:\"post-featured-image/editor-rtl.min.css\";i:370;s:30:\"post-featured-image/editor.css\";i:371;s:34:\"post-featured-image/editor.min.css\";i:372;s:33:\"post-featured-image/style-rtl.css\";i:373;s:37:\"post-featured-image/style-rtl.min.css\";i:374;s:29:\"post-featured-image/style.css\";i:375;s:33:\"post-featured-image/style.min.css\";i:376;s:34:\"post-navigation-link/style-rtl.css\";i:377;s:38:\"post-navigation-link/style-rtl.min.css\";i:378;s:30:\"post-navigation-link/style.css\";i:379;s:34:\"post-navigation-link/style.min.css\";i:380;s:27:\"post-template/style-rtl.css\";i:381;s:31:\"post-template/style-rtl.min.css\";i:382;s:23:\"post-template/style.css\";i:383;s:27:\"post-template/style.min.css\";i:384;s:24:\"post-terms/style-rtl.css\";i:385;s:28:\"post-terms/style-rtl.min.css\";i:386;s:20:\"post-terms/style.css\";i:387;s:24:\"post-terms/style.min.css\";i:388;s:31:\"post-time-to-read/style-rtl.css\";i:389;s:35:\"post-time-to-read/style-rtl.min.css\";i:390;s:27:\"post-time-to-read/style.css\";i:391;s:31:\"post-time-to-read/style.min.css\";i:392;s:24:\"post-title/style-rtl.css\";i:393;s:28:\"post-title/style-rtl.min.css\";i:394;s:20:\"post-title/style.css\";i:395;s:24:\"post-title/style.min.css\";i:396;s:26:\"preformatted/style-rtl.css\";i:397;s:30:\"preformatted/style-rtl.min.css\";i:398;s:22:\"preformatted/style.css\";i:399;s:26:\"preformatted/style.min.css\";i:400;s:24:\"pullquote/editor-rtl.css\";i:401;s:28:\"pullquote/editor-rtl.min.css\";i:402;s:20:\"pullquote/editor.css\";i:403;s:24:\"pullquote/editor.min.css\";i:404;s:23:\"pullquote/style-rtl.css\";i:405;s:27:\"pullquote/style-rtl.min.css\";i:406;s:19:\"pullquote/style.css\";i:407;s:23:\"pullquote/style.min.css\";i:408;s:23:\"pullquote/theme-rtl.css\";i:409;s:27:\"pullquote/theme-rtl.min.css\";i:410;s:19:\"pullquote/theme.css\";i:411;s:23:\"pullquote/theme.min.css\";i:412;s:39:\"query-pagination-numbers/editor-rtl.css\";i:413;s:43:\"query-pagination-numbers/editor-rtl.min.css\";i:414;s:35:\"query-pagination-numbers/editor.css\";i:415;s:39:\"query-pagination-numbers/editor.min.css\";i:416;s:31:\"query-pagination/editor-rtl.css\";i:417;s:35:\"query-pagination/editor-rtl.min.css\";i:418;s:27:\"query-pagination/editor.css\";i:419;s:31:\"query-pagination/editor.min.css\";i:420;s:30:\"query-pagination/style-rtl.css\";i:421;s:34:\"query-pagination/style-rtl.min.css\";i:422;s:26:\"query-pagination/style.css\";i:423;s:30:\"query-pagination/style.min.css\";i:424;s:25:\"query-title/style-rtl.css\";i:425;s:29:\"query-title/style-rtl.min.css\";i:426;s:21:\"query-title/style.css\";i:427;s:25:\"query-title/style.min.css\";i:428;s:25:\"query-total/style-rtl.css\";i:429;s:29:\"query-total/style-rtl.min.css\";i:430;s:21:\"query-total/style.css\";i:431;s:25:\"query-total/style.min.css\";i:432;s:20:\"query/editor-rtl.css\";i:433;s:24:\"query/editor-rtl.min.css\";i:434;s:16:\"query/editor.css\";i:435;s:20:\"query/editor.min.css\";i:436;s:19:\"quote/style-rtl.css\";i:437;s:23:\"quote/style-rtl.min.css\";i:438;s:15:\"quote/style.css\";i:439;s:19:\"quote/style.min.css\";i:440;s:19:\"quote/theme-rtl.css\";i:441;s:23:\"quote/theme-rtl.min.css\";i:442;s:15:\"quote/theme.css\";i:443;s:19:\"quote/theme.min.css\";i:444;s:23:\"read-more/style-rtl.css\";i:445;s:27:\"read-more/style-rtl.min.css\";i:446;s:19:\"read-more/style.css\";i:447;s:23:\"read-more/style.min.css\";i:448;s:18:\"rss/editor-rtl.css\";i:449;s:22:\"rss/editor-rtl.min.css\";i:450;s:14:\"rss/editor.css\";i:451;s:18:\"rss/editor.min.css\";i:452;s:17:\"rss/style-rtl.css\";i:453;s:21:\"rss/style-rtl.min.css\";i:454;s:13:\"rss/style.css\";i:455;s:17:\"rss/style.min.css\";i:456;s:21:\"search/editor-rtl.css\";i:457;s:25:\"search/editor-rtl.min.css\";i:458;s:17:\"search/editor.css\";i:459;s:21:\"search/editor.min.css\";i:460;s:20:\"search/style-rtl.css\";i:461;s:24:\"search/style-rtl.min.css\";i:462;s:16:\"search/style.css\";i:463;s:20:\"search/style.min.css\";i:464;s:20:\"search/theme-rtl.css\";i:465;s:24:\"search/theme-rtl.min.css\";i:466;s:16:\"search/theme.css\";i:467;s:20:\"search/theme.min.css\";i:468;s:24:\"separator/editor-rtl.css\";i:469;s:28:\"separator/editor-rtl.min.css\";i:470;s:20:\"separator/editor.css\";i:471;s:24:\"separator/editor.min.css\";i:472;s:23:\"separator/style-rtl.css\";i:473;s:27:\"separator/style-rtl.min.css\";i:474;s:19:\"separator/style.css\";i:475;s:23:\"separator/style.min.css\";i:476;s:23:\"separator/theme-rtl.css\";i:477;s:27:\"separator/theme-rtl.min.css\";i:478;s:19:\"separator/theme.css\";i:479;s:23:\"separator/theme.min.css\";i:480;s:24:\"shortcode/editor-rtl.css\";i:481;s:28:\"shortcode/editor-rtl.min.css\";i:482;s:20:\"shortcode/editor.css\";i:483;s:24:\"shortcode/editor.min.css\";i:484;s:24:\"site-logo/editor-rtl.css\";i:485;s:28:\"site-logo/editor-rtl.min.css\";i:486;s:20:\"site-logo/editor.css\";i:487;s:24:\"site-logo/editor.min.css\";i:488;s:23:\"site-logo/style-rtl.css\";i:489;s:27:\"site-logo/style-rtl.min.css\";i:490;s:19:\"site-logo/style.css\";i:491;s:23:\"site-logo/style.min.css\";i:492;s:27:\"site-tagline/editor-rtl.css\";i:493;s:31:\"site-tagline/editor-rtl.min.css\";i:494;s:23:\"site-tagline/editor.css\";i:495;s:27:\"site-tagline/editor.min.css\";i:496;s:26:\"site-tagline/style-rtl.css\";i:497;s:30:\"site-tagline/style-rtl.min.css\";i:498;s:22:\"site-tagline/style.css\";i:499;s:26:\"site-tagline/style.min.css\";i:500;s:25:\"site-title/editor-rtl.css\";i:501;s:29:\"site-title/editor-rtl.min.css\";i:502;s:21:\"site-title/editor.css\";i:503;s:25:\"site-title/editor.min.css\";i:504;s:24:\"site-title/style-rtl.css\";i:505;s:28:\"site-title/style-rtl.min.css\";i:506;s:20:\"site-title/style.css\";i:507;s:24:\"site-title/style.min.css\";i:508;s:26:\"social-link/editor-rtl.css\";i:509;s:30:\"social-link/editor-rtl.min.css\";i:510;s:22:\"social-link/editor.css\";i:511;s:26:\"social-link/editor.min.css\";i:512;s:27:\"social-links/editor-rtl.css\";i:513;s:31:\"social-links/editor-rtl.min.css\";i:514;s:23:\"social-links/editor.css\";i:515;s:27:\"social-links/editor.min.css\";i:516;s:26:\"social-links/style-rtl.css\";i:517;s:30:\"social-links/style-rtl.min.css\";i:518;s:22:\"social-links/style.css\";i:519;s:26:\"social-links/style.min.css\";i:520;s:21:\"spacer/editor-rtl.css\";i:521;s:25:\"spacer/editor-rtl.min.css\";i:522;s:17:\"spacer/editor.css\";i:523;s:21:\"spacer/editor.min.css\";i:524;s:20:\"spacer/style-rtl.css\";i:525;s:24:\"spacer/style-rtl.min.css\";i:526;s:16:\"spacer/style.css\";i:527;s:20:\"spacer/style.min.css\";i:528;s:20:\"table/editor-rtl.css\";i:529;s:24:\"table/editor-rtl.min.css\";i:530;s:16:\"table/editor.css\";i:531;s:20:\"table/editor.min.css\";i:532;s:19:\"table/style-rtl.css\";i:533;s:23:\"table/style-rtl.min.css\";i:534;s:15:\"table/style.css\";i:535;s:19:\"table/style.min.css\";i:536;s:19:\"table/theme-rtl.css\";i:537;s:23:\"table/theme-rtl.min.css\";i:538;s:15:\"table/theme.css\";i:539;s:19:\"table/theme.min.css\";i:540;s:23:\"tag-cloud/style-rtl.css\";i:541;s:27:\"tag-cloud/style-rtl.min.css\";i:542;s:19:\"tag-cloud/style.css\";i:543;s:23:\"tag-cloud/style.min.css\";i:544;s:28:\"template-part/editor-rtl.css\";i:545;s:32:\"template-part/editor-rtl.min.css\";i:546;s:24:\"template-part/editor.css\";i:547;s:28:\"template-part/editor.min.css\";i:548;s:27:\"template-part/theme-rtl.css\";i:549;s:31:\"template-part/theme-rtl.min.css\";i:550;s:23:\"template-part/theme.css\";i:551;s:27:\"template-part/theme.min.css\";i:552;s:24:\"term-count/style-rtl.css\";i:553;s:28:\"term-count/style-rtl.min.css\";i:554;s:20:\"term-count/style.css\";i:555;s:24:\"term-count/style.min.css\";i:556;s:30:\"term-description/style-rtl.css\";i:557;s:34:\"term-description/style-rtl.min.css\";i:558;s:26:\"term-description/style.css\";i:559;s:30:\"term-description/style.min.css\";i:560;s:23:\"term-name/style-rtl.css\";i:561;s:27:\"term-name/style-rtl.min.css\";i:562;s:19:\"term-name/style.css\";i:563;s:23:\"term-name/style.min.css\";i:564;s:28:\"term-template/editor-rtl.css\";i:565;s:32:\"term-template/editor-rtl.min.css\";i:566;s:24:\"term-template/editor.css\";i:567;s:28:\"term-template/editor.min.css\";i:568;s:27:\"term-template/style-rtl.css\";i:569;s:31:\"term-template/style-rtl.min.css\";i:570;s:23:\"term-template/style.css\";i:571;s:27:\"term-template/style.min.css\";i:572;s:27:\"text-columns/editor-rtl.css\";i:573;s:31:\"text-columns/editor-rtl.min.css\";i:574;s:23:\"text-columns/editor.css\";i:575;s:27:\"text-columns/editor.min.css\";i:576;s:26:\"text-columns/style-rtl.css\";i:577;s:30:\"text-columns/style-rtl.min.css\";i:578;s:22:\"text-columns/style.css\";i:579;s:26:\"text-columns/style.min.css\";i:580;s:19:\"verse/style-rtl.css\";i:581;s:23:\"verse/style-rtl.min.css\";i:582;s:15:\"verse/style.css\";i:583;s:19:\"verse/style.min.css\";i:584;s:20:\"video/editor-rtl.css\";i:585;s:24:\"video/editor-rtl.min.css\";i:586;s:16:\"video/editor.css\";i:587;s:20:\"video/editor.min.css\";i:588;s:19:\"video/style-rtl.css\";i:589;s:23:\"video/style-rtl.min.css\";i:590;s:15:\"video/style.css\";i:591;s:19:\"video/style.min.css\";i:592;s:19:\"video/theme-rtl.css\";i:593;s:23:\"video/theme-rtl.min.css\";i:594;s:15:\"video/theme.css\";i:595;s:19:\"video/theme.min.css\";}}', 'on'),
(360, 'sklentr_svc_refreshed', '1', 'auto'),
(356, 'sklentr_seeded_v6', '1', 'auto'),
(361, 'sklentr_seeded_v7', '1', 'auto'),
(375, 'sklentr_visa_refreshed', '1', 'auto'),
(376, 'sklentr_seeded_v9', '1', 'auto'),
(402, 'sklentr_seeded_v10', '1', 'auto'),
(373, 'sklentr_seeded_v8', '1', 'auto'),
(418, 'sklentr_seeded_v11', '1', 'auto'),
(426, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-7.0.2.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-7.0.2.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-7.0.2-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-7.0.2-new-bundled.zip\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"7.0.2\";s:7:\"version\";s:5:\"7.0.2\";s:11:\"php_version\";s:3:\"7.4\";s:13:\"mysql_version\";s:5:\"5.5.5\";s:11:\"new_bundled\";s:3:\"6.7\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1785119308;s:15:\"version_checked\";s:5:\"7.0.2\";s:12:\"translations\";a:0:{}}', 'off'),
(427, 'auto_core_update_notified', 'a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:18:\"rishad@sklentr.com\";s:7:\"version\";s:5:\"7.0.2\";s:9:\"timestamp\";i:1784514792;}', 'off'),
(702, 'category_children', 'a:0:{}', 'auto'),
(463, 'wp_calendar_block_has_published_posts', '1', 'auto'),
(466, 'sklentr_blog_seeded', '1', 'auto'),
(467, 'sklentr_seeded_v16', '1', 'auto'),
(469, 'sklentr_seeded_v17', '1', 'auto'),
(492, 'sklentr_svcpage_v1', '1', 'auto'),
(472, 'sklentr_seeded_v18', '1', 'auto'),
(125, 'theme_mods_twentytwentyfive', 'a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1784115094;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:3:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";}s:9:\"sidebar-2\";a:2:{i:0;s:7:\"block-5\";i:1;s:7:\"block-6\";}}}}', 'off'),
(126, '_transient_wp_styles_for_blocks', 'a:2:{s:4:\"hash\";s:32:\"d4c194055311dd6a9e111c5556cddc2a\";s:6:\"blocks\";a:7:{s:32:\"0368537a03d4b05ed11f802c802c5153\";s:0:\"\";s:32:\"500888137eafa12a508de2c588d9ffdd\";s:46:\":root :where(.wp-block-icon svg){width: 24px;}\";s:32:\"a6036e6eb2ad2df7ed8860b807868647\";s:0:\"\";s:32:\"3b46efc0a10c1dae38f584ad199c3544\";s:120:\":where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}\";s:32:\"ab4df16c9e454bfed8a404309545590d\";s:120:\":where(.wp-block-term-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-term-template.is-layout-grid){gap: 1.25em;}\";s:32:\"68ec5cad52d993402775a7503ba9efb7\";s:102:\":where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}\";s:32:\"b8b4aa19e69b9b2de0f5c27097467bd6\";s:69:\":root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}\";}}', 'on'),
(171, 'hello_theme_version', '3.4.9', 'auto');
INSERT INTO `sk_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(174, '_hello-elementor_notifications', 'a:2:{s:7:\"timeout\";i:1784219991;s:5:\"value\";s:8690:\"[{\"id\":\"hello-theme-3.4.9\",\"title\":\"3.4.9 - 2026-05-20\",\"description\":\"\\n            <ul>\\n                <li>Fix: CSS improvements for Elementor widgets<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.4.8\",\"title\":\"3.4.8 - 2026-05-20\",\"description\":\"\\n            <ul>\\n                <li>Fix: CSS improvements for Elementor widgets<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.4.7\",\"title\":\"3.4.7 - 2026-03-16\",\"description\":\"\\n            <ul>\\n                <li>Tweak: Updated theme home page<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.4.6\",\"title\":\"3.4.6 - 2026-01-21\",\"description\":\"\\n            <ul>\\n                <li>Tweak: Updated Elementor assets<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.4.5\",\"title\":\"3.4.5 - 2025-10-27\",\"description\":\"\\n            <ul>\\n\\t\\t\\t\\t<li>New: Add theme home to Finder<\\/li>\\n\\t\\t\\t\\t<li>Tweak: Improve banner behavior after clicking on action button<\\/li>\\n\\t\\t\\t\\t<li>Fix: Load styles correctly in Gutenberg pages<\\/li>\\n\\t\\t\\t\\t<li>Fix: Do not change menu name after Elementor activation<\\/li>\\n\\t\\t\\t\\t<li>Fix: Ensure quicklinks works correctly from home page<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.4.4\",\"title\":\"3.4.4 - 2025-06-08\",\"description\":\"\\n            <ul>\\n\\t\\t\\t\\t<li>Tweak: Improve Header\\/Footer edit access from theme Home<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.4.3\",\"title\":\"3.4.3 - 2025-05-26\",\"description\":\"\\n            <ul>\\n\\t\\t\\t\\t<li>Fix: Settings page empty after 3.4.0 in translated sites<\\/li>\\n\\t\\t\\t\\t<li>Fix: PHP 8.4 deprecation notice<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.4.2\",\"title\":\"3.4.2 - 2025-05-19\",\"description\":\"\\n            <ul>\\n\\t\\t\\t\\t<li>Tweak: Set Home links font weight to regular<\\/li>\\n  \\t\\t        <li>Tweak: Dart SASS 3.0.0 - resolve scss deprecated warnings<\\/li>\\n    \\t\\t    <li>Fix: Settings page empty after 3.4.0<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.4.0\",\"title\":\"3.4.0 - 2025-05-05\",\"description\":\"\\n            <ul>\\n                <li>New: Added Theme Home<\\/li>\\n\\t\\t\\t\\t<li>Tweak: Update theme settings page style<\\/li>\\n\\t\\t\\t\\t<li>Tweak: Update tested up to version 6.8<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.3.0\",\"title\":\"3.3.0 - 2025-01-21\",\"description\":\"\\n            <ul>\\n                <li>Tweak: Added changelog link in theme settings<\\/li>\\n\\t\\t\\t\\t<li>Tweak: Updated minimum required Safari version to 15.5<\\/li>\\n  \\t\\t        <li>Tweak: Update autoprefixer to latest versions<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.2.1\",\"title\":\"3.2.1 - 2024-12-16\",\"description\":\"\\n            <ul>\\n                <li>\\n                    Fix: Gutenberg editor expanded disproportionately after adding support for <code>theme.json<\\/code>\\n                    (<a href=\\\"https:\\/\\/github.com\\/elementor\\/hello-theme\\/issues\\/430\\\" target=\\\"_blank\\\">#430<\\/a>)\\n                <\\/li>\\n                <li>Fix: Use CSS logical properties in the theme<\\/li>\\n                <li>Fix: Add ARIA attributes to header nav menu<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.2.0\",\"title\":\"3.2.0 - 2024-12-15\",\"description\":\"\\n            <ul>\\n                <li>Tweak: Convert classic to hybrid theme with block-editor support<\\/li>\\n                <li>Tweak: Added new design options to header\\/footer<\\/li>\\n                <li>Tweak: Update <code>Tested up to 6.7<\\/code><\\/li>\\n                <li>\\n                    Fix: Minify JS files\\n                    (<a href=\\\"https:\\/\\/github.com\\/elementor\\/hello-theme\\/issues\\/419\\\" target=\\\"_blank\\\">#419<\\/a>)\\n                <\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.1.1\",\"title\":\"3.1.1 - 2024-07-30\",\"description\":\"\\n            <ul>\\n                <li>Fix: Use consistent <code>&lt;h2&gt;<\\/code> for comments title and comment form<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.1.0\",\"title\":\"3.1.0 - 2024-06-19\",\"description\":\"\\n            <ul>\\n                <li>Tweak: Update <code>Requires PHP 7.4<\\/code><\\/li>\\n                <li>Tweak: Update <code>Tested up to 6.5<\\/code><\\/li>\\n                <li>Tweak: Add the ability to style the brand layout<\\/li>\\n                <li>Tweak: Remove deprecated Elementor code<\\/li>\\n                <li>Tweak: Restore default focus styling inside the theme<\\/li>\\n                <li>Tweak: Add <code>aria-label<\\/code> attribute to various <code>&lt;nav&gt;<\\/code> elements<\\/li>\\n                <li>Tweak: Improve mobile menu keyboard accessibility<\\/li>\\n                <li>Tweak: Semantic mobile menu toggle button<\\/li>\\n                <li>Fix: The header renders redundant <code>&lt;p&gt;<\\/code> when tagline is empty<\\/li>\\n                <li>Fix: Single post renders redundant wrapping <code>&lt;div&gt;<\\/code> when it has no tags<\\/li>\\n                <li>Fix: Remove redundant wrapping <code>&lt;div&gt;<\\/code> from <code>wp_nav_menu()<\\/code> output<\\/li>\\n                <li>Fix: Wrap page <code>&lt;h1&gt;<\\/code> with <code>&lt;div&gt;<\\/code>, not <code>&lt;header&gt;<\\/code><\\/li>\\n                <li>Fix: Use consistent <code>&lt;h3&gt;<\\/code> for comments title and comment form<\\/li>\\n                <li>Fix: Remove heading tags from dynamic header\\/footer<\\/li>\\n                <li>\\n                    Fix: Mobile Menu hamburger is not visible for logged-out users in some cases\\n                    (<a href=\\\"https:\\/\\/github.com\\/elementor\\/hello-theme\\/issues\\/369\\\" target=\\\"_blank\\\">#369<\\/a>)\\n                <\\/li>\\n                <li>Fix: Remove duplicate ID attributes in the header mobile menu<\\/li>\\n                <li>\\n                    Fix: Remove redundant table styles\\n                    (<a href=\\\"https:\\/\\/github.com\\/elementor\\/hello-theme\\/issues\\/311\\\" target=\\\"_blank\\\">#311<\\/a>)\\n                <\\/li>\\n                <li>Fix: Remove redundant space below Site Logo in the header\\/footer<\\/li>\\n                <li>Fix: Remove redundant CSS from dynamic header\\/footer layout<\\/li>\\n                <li>\\n                    Fix: Separate post tags in single post\\n                    (<a href=\\\"https:\\/\\/github.com\\/elementor\\/hello-theme\\/issues\\/304\\\" target=\\\"_blank\\\">#304<\\/a>)\\n                <\\/li>\\n                <li>Fix: Display <code>the_tags()<\\/code> after <code>wp_link_pages()<\\/code><\\/li>\\n                <li>Fix: Remove page break navigation from archives when using <code>&lt;!--nextpage--&gt;<\\/code><\\/li>\\n                <li>Fix: Style posts pagination component layout<\\/li>\\n                <li>Fix: Add RTL support to pagination arrows in archive pages<\\/li>\\n                <li>\\n                    Fix: Update pagination prev\\/next labels and positions\\n                    (<a href=\\\"https:\\/\\/github.com\\/elementor\\/hello-theme\\/issues\\/404\\\" target=\\\"_blank\\\">#404<\\/a>)\\n                <\\/li>\\n                <li>Fix: Check if Elementor is loaded when using dynamic header & footer<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.0.2\",\"title\":\"3.0.2 - 2024-05-28\",\"description\":\"\\n            <ul>\\n                <li>Internal: Version bump release to refresh WordPress repository<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.0.1\",\"title\":\"3.0.1 - 2024-01-24\",\"description\":\"\\n            <ul>\\n                <li>Fix: Harden security for admin notice dismiss button<\\/li>\\n                <li>Fix: Add <code>alt<\\/code> attribute to all the images in the dashboard<\\/li>\\n            <\\/ul>\"},{\"id\":\"hello-theme-3.0.0\",\"title\":\"3.0.0 - 2023-12-26\",\"description\":\"\\n            <ul>\\n                <li>New: Option to disable cross-site header & footer<\\/li>\\n                <li>Tweak: Update <code>Requires PHP 7.3<\\/code><\\/li>\\n                <li>Tweak: Update <code>Tested up to 6.4<\\/code><\\/li>\\n                <li>Tweak: Move cross-site header & footer styles to a separate CSS file<\\/li>\\n                <li>Tweak: Don\'t load <code>header-footer.min.css<\\/code> when disabling header & footer<\\/li>\\n                <li>Tweak: Don\'t load <code>hello-frontend.min.js<\\/code> when disabling header & footer<\\/li>\\n                <li>Tweak: Replace jQuery code with vanilla JS in the frontend<\\/li>\\n                <li>Tweak: Replace jQuery code with vanilla JS in WordPress admin<\\/li>\\n                <li>Tweak: Remove unused JS code from the frontend<\\/li>\\n                <li>Tweak: Remove unused CSS code from the editor<\\/li>\\n                <li>Tweak: Remove unnecessary <code>role<\\/code> attributes from HTML landmark elements<\\/li>\\n                <li>Tweak: Link from Elementor Site Settings to Hello Theme Settings<\\/li>\\n                <li>Fix: Dynamic script version for better caching<\\/li>\\n            <\\/ul>\"}]\";}', 'off'),
(128, 'recovery_keys', 'a:0:{}', 'off'),
(147, 'theme_mods_hello-elementor-child', 'a:4:{s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;s:11:\"custom_logo\";s:2:\"11\";s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1784176790;s:4:\"data\";a:1:{s:19:\"wp_inactive_widgets\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}}}}', 'off'),
(301, 'elementor_connect_site_key', '361f094a3ead506f37d5fdef772e211d', 'auto'),
(780, '_site_transient_timeout_wp_theme_files_patterns-c1821dc297a134251549eff8b9e1c122', '1785133416', 'off'),
(781, '_site_transient_wp_theme_files_patterns-c1821dc297a134251549eff8b9e1c122', 'a:2:{s:7:\"version\";s:5:\"1.0.0\";s:8:\"patterns\";a:0:{}}', 'off'),
(295, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1785119309;s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:2:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:3:\"5.7\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:54:\"https://downloads.wordpress.org/plugin/akismet.5.7.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:60:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=2818463\";s:2:\"1x\";s:60:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=2818463\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/akismet/assets/banner-1544x500.png?rev=2900731\";s:2:\"1x\";s:62:\"https://ps.w.org/akismet/assets/banner-772x250.png?rev=2900731\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.8\";}s:9:\"hello.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/hello-dolly/assets/banner-1544x500.jpg?rev=2645582\";s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}}s:7:\"checked\";a:2:{s:19:\"akismet/akismet.php\";s:3:\"5.7\";s:9:\"hello.php\";s:5:\"1.7.2\";}}', 'off'),
(305, 'theme_mods_sklentr', 'a:2:{s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;}', 'auto'),
(324, 'sklentr_settings', 'a:192:{s:15:\"problem_eyebrow\";s:23:\"Why founders come to us\";s:13:\"problem_title\";s:62:\"Building an MVP shouldn’t take months — or cost a fortune.\";s:13:\"problem_intro\";s:118:\"Most founders reach us already burned by an agency. Here’s what usually goes wrong — and how we do it differently.\";s:16:\"problem_cta_text\";s:15:\"See how we work\";s:16:\"problem_cta_link\";s:12:\"#how-we-work\";s:12:\"hero_eyebrow\";s:24:\"Toronto-based MVP Studio\";s:15:\"hero_title_main\";s:17:\"Launch-ready MVPs\";s:20:\"hero_title_highlight\";s:9:\"in weeks,\";s:17:\"hero_title_strike\";s:11:\"not months.\";s:8:\"hero_sub\";s:69:\"We build MVPs that get you funded, validated, and to market — fast.\";s:14:\"hero_cta1_text\";s:24:\"Book a Free Consultation\";s:14:\"hero_cta1_link\";s:8:\"#contact\";s:14:\"hero_cta2_text\";s:12:\"See our work\";s:14:\"hero_cta2_link\";s:5:\"#work\";s:9:\"hero_note\";s:52:\"Canadian expertise. Competitive pricing. No excuses.\";s:11:\"hero_chip_1\";s:5:\"Figma\";s:11:\"hero_chip_2\";s:5:\"React\";s:11:\"hero_chip_3\";s:10:\"Funded ✓\";s:11:\"hero_chip_4\";s:8:\"Ship →\";s:16:\"hero_panel_title\";s:15:\"MVP Launch Plan\";s:18:\"hero_badge_loading\";s:11:\"Building…\";s:13:\"hero_badge_ok\";s:8:\"On track\";s:13:\"trust_heading\";s:22:\"Sklentr by the numbers\";s:17:\"trust_proof_label\";s:28:\"Trusted by founders building\";s:14:\"pillar_eyebrow\";s:11:\"Why Sklentr\";s:12:\"pillar_title\";s:31:\"Built different — on purpose.\";s:12:\"pillar_intro\";s:79:\"Four reasons founders trust us with their first product — and their next one.\";s:15:\"pillar_cta_text\";s:13:\"Meet the team\";s:15:\"pillar_cta_link\";s:6:\"/about\";s:16:\"services_eyebrow\";s:8:\"Services\";s:14:\"services_title\";s:22:\"Everything you need to\";s:21:\"services_title_accent\";s:7:\"launch.\";s:14:\"services_intro\";s:0:\"\";s:17:\"services_cta_text\";s:16:\"See Our Services\";s:17:\"services_cta_link\";s:9:\"/services\";s:12:\"visa_eyebrow\";s:34:\"For Canada Startup Visa Applicants\";s:10:\"visa_title\";s:34:\"Need an MVP for your Startup Visa?\";s:17:\"visa_title_accent\";s:16:\"We’ve got you.\";s:9:\"visa_body\";s:156:\"Tight deadline. Limited budget. High stakes. We help startup visa applicants build working products that prove business viability — on time and on budget.\";s:13:\"visa_cta_text\";s:10:\"Learn More\";s:13:\"visa_cta_link\";s:13:\"/startup-visa\";s:12:\"work_eyebrow\";s:13:\"Featured Work\";s:10:\"work_title\";s:29:\"Real products, real outcomes.\";s:10:\"work_intro\";s:79:\"A few of the MVPs we’ve shipped for founders — live, funded, and in market.\";s:13:\"work_cta_text\";s:13:\"View All Work\";s:13:\"work_cta_link\";s:10:\"/portfolio\";s:15:\"process_eyebrow\";s:11:\"How We Work\";s:13:\"process_title\";s:33:\"A clear path from idea to launch.\";s:13:\"process_intro\";s:63:\"No black boxes — four simple steps, predictable from day one.\";s:16:\"process_cta_text\";s:32:\"Start With a Free Discovery Call\";s:16:\"process_cta_link\";s:8:\"#contact\";s:15:\"pricing_eyebrow\";s:7:\"Pricing\";s:13:\"pricing_title\";s:20:\"Transparent pricing.\";s:20:\"pricing_title_accent\";s:13:\"No surprises.\";s:13:\"pricing_intro\";s:0:\"\";s:12:\"pricing_note\";s:113:\"Every project starts with a free 30-minute consultation. We’ll scope your idea and recommend the right package.\";s:16:\"pricing_cta_text\";s:17:\"View Full Pricing\";s:16:\"pricing_cta_link\";s:8:\"/pricing\";s:12:\"tech_eyebrow\";s:15:\"Technology & AI\";s:10:\"tech_title\";s:13:\"Modern stack.\";s:17:\"tech_title_accent\";s:17:\"AI-native builds.\";s:10:\"tech_intro\";s:68:\"A consistent, modern toolchain — built to scale, and shipped fast.\";s:13:\"tech_ai_title\";s:25:\"AI-native, not bolted on.\";s:12:\"tech_ai_note\";s:112:\"We weave Gemini, OpenAI, and Claude into real product workflows — powering features that matter, not gimmicks.\";s:13:\"tech_cta_text\";s:20:\"Explore Our Services\";s:13:\"tech_cta_link\";s:9:\"/services\";s:13:\"about_eyebrow\";s:13:\"About Sklentr\";s:11:\"about_title\";s:20:\"Canadian management,\";s:18:\"about_title_accent\";s:26:\"world-class global talent.\";s:11:\"about_story\";s:211:\"Founded in 2023 out of frustration with slow, overpriced agencies, Sklentr pairs Toronto-based project leadership with an expert global team — so founders get premium quality, fast, without the premium markup.\";s:12:\"founder_name\";s:12:\"Rishad Wahid\";s:12:\"founder_role\";s:13:\"Founder & CEO\";s:11:\"founder_bio\";s:71:\"10+ years building digital products, from first MVP to funded scale-up.\";s:15:\"about_stat1_num\";s:4:\"2023\";s:17:\"about_stat1_label\";s:7:\"Founded\";s:15:\"about_stat2_num\";s:3:\"50+\";s:17:\"about_stat2_label\";s:16:\"Projects shipped\";s:15:\"about_stat3_num\";s:3:\"15+\";s:17:\"about_stat3_label\";s:17:\"Startup Visa MVPs\";s:14:\"about_cta_text\";s:18:\"Meet the Full Team\";s:14:\"about_cta_link\";s:6:\"/about\";s:13:\"founder_quote\";s:110:\"We started Sklentr to give founders what agencies wouldn’t: speed, transparency, and code they actually own.\";s:13:\"founder_photo\";s:0:\"\";s:12:\"about_hl_num\";s:2:\"01\";s:14:\"about_hl_title\";s:28:\"Founder-led, start to finish\";s:13:\"about_hl_desc\";s:105:\"Toronto strategy paired with an expert global team — one accountable partner from first call to launch.\";s:18:\"about_follow_label\";s:9:\"Follow Us\";s:15:\"social_linkedin\";s:40:\"https://www.linkedin.com/company/sklentr\";s:8:\"social_x\";s:21:\"https://x.com/sklentr\";s:15:\"social_facebook\";s:32:\"https://www.facebook.com/sklentr\";s:16:\"social_instagram\";s:33:\"https://www.instagram.com/sklentr\";s:16:\"insights_eyebrow\";s:8:\"Insights\";s:14:\"insights_title\";s:23:\"Playbooks for founders,\";s:21:\"insights_title_accent\";s:10:\"not fluff.\";s:14:\"insights_intro\";s:97:\"Practical takes on validation, MVPs, and the Canada Startup Visa — from the team shipping them.\";s:17:\"insights_cta_text\";s:17:\"Read All Insights\";s:17:\"insights_cta_link\";s:5:\"/blog\";s:10:\"news_title\";s:28:\"Get the founder’s playbook\";s:9:\"news_text\";s:66:\"Practical MVP and Startup Visa insights — once a month, no spam.\";s:16:\"news_placeholder\";s:15:\"you@company.com\";s:11:\"news_button\";s:9:\"Subscribe\";s:12:\"news_success\";s:36:\"Thanks! Check your inbox to confirm.\";s:11:\"faq_eyebrow\";s:3:\"FAQ\";s:9:\"faq_title\";s:10:\"Questions?\";s:16:\"faq_title_accent\";s:9:\"Answered.\";s:9:\"faq_intro\";s:58:\"The things founders ask us most — before the first call.\";s:14:\"faq_help_title\";s:21:\"Still have questions?\";s:13:\"faq_help_text\";s:75:\"Book a free 30-minute call — no pressure, just a clear plan and timeline.\";s:17:\"faq_help_cta_text\";s:16:\"Book a Free Call\";s:17:\"faq_help_cta_link\";s:8:\"#contact\";s:11:\"cta_eyebrow\";s:13:\"Let’s build\";s:9:\"cta_title\";s:24:\"Ready to launch your MVP\";s:16:\"cta_title_accent\";s:9:\"in weeks?\";s:12:\"cta_subtitle\";s:0:\"\";s:10:\"cta_points\";s:50:\"Free discovery call\nFixed pricing\nYou own the code\";s:16:\"cta_primary_text\";s:24:\"Book a Free Consultation\";s:16:\"cta_primary_link\";s:28:\"https://calendly.com/sklentr\";s:9:\"cta_email\";s:16:\"info@sklentr.com\";s:9:\"cta_phone\";s:15:\"+1 647-997-0557\";s:12:\"cta_whatsapp\";s:25:\"https://wa.me/16479970557\";s:12:\"sv_faq_title\";s:16:\"Common Questions\";s:12:\"sv_faq_items\";s:1322:\"How long does it take to build my MVP? | Four weeks, start to finish. We agree the scope up front, build in weekly sprints with visible progress, and deliver before your visa deadline.\nWhat if I don’t have technical specifications? | That’s normal — most founders don’t. Our free discovery call turns your idea into a clear, scoped MVP plan; you don’t need to write a single line of spec.\nDo I own the source code? | Yes — 100%. You receive full source-code ownership and IP rights on delivery. No lock-in, no licensing games.\nWhat tech stack do you use? | A modern, proven stack — Next.js, React, React Native, Flutter, Laravel, PostgreSQL — with AI (Gemini, OpenAI, Claude) woven in where it adds real value.\nWhat happens after launch? | Every package includes one month of post-launch support for fixes and tweaks. We’re a partner, not a vendor — many founders stay on for the next build.\nCan you help with my pitch deck? | Yes. Your package includes pitch-deck assets — product screenshots, a demo video, and presentation materials — ready to show designated organizations and investors.\nWhat if the SUV program stays paused? | A working product is an asset either way: it validates your business, attracts investors and customers now, and puts you first in line the moment the program resumes.\";s:15:\"pr_hero_eyebrow\";s:19:\"Transparent Pricing\";s:13:\"pr_hero_title\";s:15:\"Simple pricing.\";s:14:\"pr_hero_accent\";s:13:\"No surprises.\";s:11:\"pr_hero_sub\";s:143:\"Every project starts with a free 30-minute consultation. We’ll scope your idea and recommend the right package. No hidden fees, no surprises.\";s:17:\"pr_hero_cta1_text\";s:24:\"Book a Free Consultation\";s:17:\"pr_hero_cta2_text\";s:9:\"See Plans\";s:13:\"pr_hero_chips\";s:107:\"On-time or you get a discount\nYou own 100% of the code\nMilestone-based payments\nFree 30-minute consultation\";s:16:\"pr_plans_eyebrow\";s:8:\"Packages\";s:14:\"pr_plans_title\";s:38:\"Pick the package that fits your stage.\";s:14:\"pr_plans_intro\";s:92:\"Fixed scope, fixed price. Prices in CAD — final quote confirmed on your free consultation.\";s:8:\"pr_plans\";s:1089:\"Starter MVP | $5,000 | $5,000 – $10,000 | 2 weeks |  | Perfect for validating your idea quickly | Get Started | https://calendly.com/sklentr | Core Features: 1–3 features;Template-based design;Up to 5 pages / screens;Standard tech stack;2 rounds of revisions;Basic SEO setup;2 weeks post-launch support;Social media setup;!Video production;!Custom UI/UX design\nGrowth MVP | $15,000 | $15,000 – $25,000 | 4 weeks | Most Popular | Most popular for serious founders | Get Started | https://calendly.com/sklentr | Core Features: 5–7 features;Custom UI design;Up to 15 pages / screens;Standard tech stack;3 rounds of revisions;Full SEO setup;1 month post-launch support;Technical documentation;Admin dashboard;Social media setup\nFull-Service | $30,000 | $30,000 – $60,000+ | 8+ weeks |  | Complete product + marketing package | Go Full-Service | https://calendly.com/sklentr | Full product build;Custom UI/UX design;Unlimited pages / screens;Custom tech stack;Unlimited revisions;Full SEO & marketing;3 months post-launch support;Social media management;1 promo video;Priority support\";s:15:\"pr_guar_eyebrow\";s:19:\"Every Plan Includes\";s:13:\"pr_guar_title\";s:27:\"Guarantees, not fine print.\";s:13:\"pr_guar_items\";s:309:\"On-Time Delivery | We guarantee our timelines. If we’re late, you get a discount.\nCode Ownership | You own everything. No licensing, no strings attached.\nFlexible Payments | Split payments across milestones. No full amount upfront.\nFree Consultation | A 30-minute call to scope your project. No obligations.\";s:12:\"pr_faq_title\";s:16:\"Common Questions\";s:12:\"pr_faq_items\";s:1715:\"How do I know which package is right for me? | Book a free 30-minute consultation. We’ll discuss your idea, timeline, and budget, then recommend the best package. Most founders validating an idea start with Starter; those building for investors or visa applications go with Growth; established businesses needing the full package choose Full-Service.\nWhat’s included in the price? | Everything needed to launch: design, development, the agreed feature set, deployment, and post-launch support — plus full source-code ownership. Each package’s inclusions are listed above; we confirm the exact scope on your free consultation.\nDo you offer payment plans? | Yes. Payments are split across project milestones — no full amount upfront. We map the schedule to your build on the consultation call.\nWhat if I need features not listed? | No problem. Every build is scoped to your idea. If you need something beyond a package, we quote it transparently on the free consultation and fold it into your roadmap.\nHow fast can you really deliver? | Starter ships in about 2 weeks, Growth in about 4 weeks, and Full-Service in 8+ weeks. We guarantee our timelines — if we’re late, you get a discount.\nWhat happens after launch? | Every package includes post-launch support (2 weeks to 3 months depending on the tier) for fixes and tweaks. Many founders stay on for the next build.\nDo I own the code? | Yes — 100%. You receive full source-code ownership and IP rights on delivery. No licensing, no lock-in, no strings attached.\nWhat tech stack do you use? | A modern, proven stack — Next.js, React, React Native, Flutter, Laravel, PostgreSQL — with AI (Gemini, OpenAI, Claude) woven in where it adds real value.\";s:17:\"pr_hero_cta1_link\";s:28:\"https://calendly.com/sklentr\";s:17:\"pr_hero_cta2_link\";s:9:\"#pr-plans\";s:14:\"pr_faq_eyebrow\";s:3:\"FAQ\";s:17:\"pr_faq_help_title\";s:15:\"Still deciding?\";s:16:\"pr_faq_help_text\";s:87:\"Book a free 30-minute call — we’ll scope your idea and recommend the right package.\";s:20:\"pr_faq_help_cta_text\";s:25:\"Book My Free Consultation\";s:20:\"pr_faq_help_cta_link\";s:28:\"https://calendly.com/sklentr\";s:12:\"pf_hero_lead\";s:24:\"Ideas we’ve brought to\";s:14:\"pf_hero_accent\";s:4:\"life\";s:11:\"pf_hero_sub\";s:139:\"From healthcare AI to blockchain fintech, we’ve helped founders across industries launch products that matter. Here’s proof we deliver.\";s:17:\"pf_hero_cta1_text\";s:15:\"Start a Project\";s:17:\"pf_hero_cta1_link\";s:8:\"#contact\";s:17:\"pf_hero_cta2_text\";s:12:\"See the Work\";s:17:\"pf_hero_cta2_link\";s:12:\"#pf-featured\";s:15:\"pf_hero_collage\";s:123:\"horizontrials | Horizon Trials | Healthcare / AI\nkindredcare | KindredCare | Elderly Care\ngaindata | GAinData | Data / SaaS\";s:9:\"pf_man_l1\";s:32:\"We build meaningful products and\";s:9:\"pf_man_l2\";s:41:\"intuitive digital experiences — through\";s:9:\"pf_man_l3\";s:40:\"strategy, craft & technology that ships.\";s:13:\"pf_man_accent\";s:5:\"ships\";s:16:\"pf_man_link_text\";s:11:\"How We Work\";s:13:\"pf_man_photos\";s:44:\"horizontrials\naifarming\nkindredcare\ngaindata\";s:15:\"pf_feat_eyebrow\";s:12:\"Case Studies\";s:13:\"pf_feat_title\";s:14:\"Featured Works\";s:20:\"pf_feat_viewall_text\";s:13:\"View all work\";s:20:\"pf_feat_viewall_link\";s:8:\"#contact\";s:23:\"pf_feat_challenge_label\";s:9:\"Challenge\";s:22:\"pf_feat_solution_label\";s:8:\"Solution\";s:15:\"ab_hero_eyebrow\";s:13:\"About Sklentr\";s:12:\"ab_hero_lead\";s:7:\"We’re\";s:14:\"ab_hero_accent\";s:7:\"Sklentr\";s:11:\"ab_hero_sub\";s:146:\"A Toronto-based MVP studio that helps founders launch faster. Canadian management, global talent, and a relentless focus on getting you to market.\";s:17:\"ab_hero_cta1_text\";s:24:\"Book a Free Consultation\";s:17:\"ab_hero_cta1_link\";s:28:\"https://calendly.com/sklentr\";s:17:\"ab_hero_cta2_text\";s:12:\"See Our Work\";s:17:\"ab_hero_cta2_link\";s:46:\"http://localhost/sklentr/sklentr-v2/portfolio/\";s:12:\"ab_hero_pin1\";s:7:\"Toronto\";s:12:\"ab_hero_pin2\";s:5:\"Dhaka\";s:18:\"ab_hero_viz_kicker\";s:9:\"Est. 2023\";s:16:\"ab_hero_viz_note\";s:36:\"Canadian management · Global talent\";s:13:\"ab_hero_stats\";s:94:\"50+ | Projects Delivered\n15+ | SUV MVPs Built\n2 | Offices Worldwide\n100% | Client Satisfaction\";s:16:\"ab_story_eyebrow\";s:9:\"Our Story\";s:14:\"ab_story_title\";s:31:\"Built by Founders, for Founders\";s:14:\"ab_story_badge\";s:20:\"Est. 2023 · Toronto\";s:13:\"ab_story_body\";s:530:\"We started Sklentr because we lived the pain. As founders ourselves, we knew how hard it was to find reliable development partners who understood startup realities.\nMost agencies charge a fortune and take forever. Freelancers disappear or deliver broken code. We built Sklentr to be different — fast, transparent, and genuinely invested in your success.\nToday, we’ve helped 50+ founders launch their products. From healthcare AI to blockchain fintech, from Startup Visa applicants to funded startups — we build what matters.\";s:14:\"ab_val_eyebrow\";s:10:\"Our Values\";s:12:\"ab_val_title\";s:17:\"What We Stand For\";s:12:\"ab_val_items\";s:445:\"Speed Without Sacrifice | We move fast, but never at the expense of quality. Every line of code is built to last.\nFounder-First Mentality | We’ve been in your shoes. We build what you need to succeed, not what pads our invoice.\nRadical Transparency | No hidden fees. No surprises. You know exactly what you’re getting and when.\nOwnership & Accountability | Your success is our success. We don’t disappear after launch — we’re partners.\";s:15:\"ab_team_eyebrow\";s:8:\"The Team\";s:13:\"ab_team_title\";s:15:\"Meet the People\";s:15:\"ab_team_members\";s:665:\"Rishad Wahid | Founder & CEO | Toronto, Canada | Serial entrepreneur with 10+ years building digital products. Passionate about helping founders bring their visions to life.\nDevelopment Team | Engineering | Dhaka, Bangladesh | World-class engineers specializing in React, Next.js, Laravel, and mobile development. Fast, reliable, and detail-oriented.\nDesign Team | UI/UX Design | Global | Creative designers who understand that great UX is invisible. We make complex simple and beautiful functional.\nMarketing Team | Growth & SEO | Toronto & Dhaka | Data-driven marketers who’ve helped startups rank #1 for competitive keywords. We don’t just build — we grow.\";s:14:\"ab_off_eyebrow\";s:11:\"Our Offices\";s:12:\"ab_off_title\";s:15:\"Global Presence\";s:14:\"ab_off_tagline\";s:60:\"Canadian management. Global talent. The best of both worlds.\";s:12:\"ab_off_items\";s:178:\"Toronto, Canada | Headquarters | Client relationships, strategy, and project management\nDhaka, Bangladesh | Development Center | Engineering, design, and technical implementation\";}', 'auto'),
(325, 'sklentr_seeded_v1', '1', 'auto'),
(327, 'sklentr_seeded_v2', '1', 'auto'),
(710, '_site_transient_timeout_php_check_9ab7d1d0aab5d0d9977e61657de2d018', '1785410961', 'off'),
(711, '_site_transient_php_check_9ab7d1d0aab5d0d9977e61657de2d018', 'a:5:{s:19:\"recommended_version\";s:3:\"8.3\";s:15:\"minimum_version\";s:3:\"7.4\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}', 'off'),
(203, 'e_editor_counter', '1', 'auto'),
(201, 'finished_updating_comment_type', '1', 'auto'),
(183, 'can_compress_scripts', '1', 'on'),
(186, '_site_transient_wp_plugin_dependencies_plugin_data', 'a:0:{}', 'off'),
(187, 'recently_activated', 'a:1:{s:23:\"elementor/elementor.php\";i:1784127024;}', 'off'),
(141, 'current_theme', 'Sklentr', 'auto'),
(142, 'theme_switched', '', 'auto'),
(162, '_site_transient_update_themes', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1785119310;s:7:\"checked\";a:6:{s:21:\"hello-elementor-child\";s:5:\"1.0.0\";s:15:\"hello-elementor\";s:5:\"3.4.9\";s:7:\"sklentr\";s:5:\"1.0.0\";s:16:\"twentytwentyfive\";s:3:\"1.5\";s:16:\"twentytwentyfour\";s:3:\"1.5\";s:17:\"twentytwentythree\";s:3:\"1.6\";}s:8:\"response\";a:0:{}s:9:\"no_update\";a:4:{s:15:\"hello-elementor\";a:6:{s:5:\"theme\";s:15:\"hello-elementor\";s:11:\"new_version\";s:5:\"3.4.9\";s:3:\"url\";s:45:\"https://wordpress.org/themes/hello-elementor/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/theme/hello-elementor.3.4.9.zip\";s:8:\"requires\";s:3:\"6.0\";s:12:\"requires_php\";s:3:\"7.4\";}s:16:\"twentytwentyfive\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfive\";s:11:\"new_version\";s:3:\"1.5\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfive/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfive.1.5.zip\";s:8:\"requires\";s:3:\"6.7\";s:12:\"requires_php\";s:3:\"7.2\";}s:16:\"twentytwentyfour\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfour\";s:11:\"new_version\";s:3:\"1.5\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfour/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfour.1.5.zip\";s:8:\"requires\";s:3:\"6.4\";s:12:\"requires_php\";s:3:\"7.0\";}s:17:\"twentytwentythree\";a:6:{s:5:\"theme\";s:17:\"twentytwentythree\";s:11:\"new_version\";s:3:\"1.6\";s:3:\"url\";s:47:\"https://wordpress.org/themes/twentytwentythree/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/theme/twentytwentythree.1.6.zip\";s:8:\"requires\";s:3:\"6.1\";s:12:\"requires_php\";s:3:\"5.6\";}}s:12:\"translations\";a:0:{}}', 'off'),
(457, 'sklentr_seeded_v14', '1', 'auto'),
(459, 'sklentr_seeded_v15', '1', 'auto'),
(438, 'sklentr_seeded_v12', '1', 'auto'),
(440, 'sklentr_seeded_v13', '1', 'auto'),
(220, 'site_logo', '11', 'auto'),
(337, 'sklentr_seeded_v4', '1', 'auto'),
(334, 'sklentr_seeded_v3', '1', 'auto'),
(341, 'sklentr_seeded_v5', '1', 'auto'),
(347, '_transient_health-check-site-status-result', '{\"good\":20,\"recommended\":6,\"critical\":0}', 'on'),
(600, 'sklentr_about_seed_v1', '1', 'auto'),
(764, '_site_transient_timeout_theme_roots', '1785121109', 'off'),
(765, '_site_transient_theme_roots', 'a:6:{s:21:\"hello-elementor-child\";s:7:\"/themes\";s:15:\"hello-elementor\";s:7:\"/themes\";s:7:\"sklentr\";s:7:\"/themes\";s:16:\"twentytwentyfive\";s:7:\"/themes\";s:16:\"twentytwentyfour\";s:7:\"/themes\";s:17:\"twentytwentythree\";s:7:\"/themes\";}', 'off'),
(703, 'sklentr_blog_seed_v1', '1', 'auto'),
(578, 'sklentr_seed_content_v1', '1', 'auto'),
(581, 'sklentr_seed_content_v2', '1', 'auto'),
(587, 'sklentr_pf_seed_v1', '1', 'auto'),
(588, 'sklentr_pf_seed_v2', '1', 'auto');

-- --------------------------------------------------------

--
-- Table structure for table `sk_postmeta`
--

DROP TABLE IF EXISTS `sk_postmeta`;
CREATE TABLE IF NOT EXISTS `sk_postmeta` (
  `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM AUTO_INCREMENT=506 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `sk_postmeta`
--

INSERT INTO `sk_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(3, 5, '_elementor_edit_mode', 'builder'),
(4, 5, '_elementor_template_type', 'kit'),
(6, 7, '_elementor_edit_mode', 'builder'),
(7, 7, '_elementor_template_type', 'wp-page'),
(8, 8, '_elementor_edit_mode', 'builder'),
(9, 8, '_elementor_template_type', 'wp-page'),
(10, 9, '_elementor_edit_mode', 'builder'),
(11, 9, '_elementor_template_type', 'wp-post'),
(12, 10, '_elementor_edit_mode', 'builder'),
(13, 10, '_elementor_template_type', 'post'),
(14, 9, '_elementor_version', '4.1.5'),
(15, 9, '_elementor_global_class_usage_indexed', '1'),
(16, 9, '_elementor_global_class_usage_indexed_preview', '1'),
(17, 9, '_elementor_migrations_state_d2a1', '4.1.5:595e50d38ae27a4ec16e0e0a9df00b29'),
(18, 9, '_edit_lock', '1784115855:1'),
(19, 11, '_wp_attached_file', '2026/07/sklentr-logo.png'),
(20, 11, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:418;s:6:\"height\";i:82;s:4:\"file\";s:24:\"2026/07/sklentr-logo.png\";s:8:\"filesize\";i:4536;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:23:\"sklentr-logo-300x59.png\";s:5:\"width\";i:300;s:6:\"height\";i:59;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:5310;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:23:\"sklentr-logo-150x82.png\";s:5:\"width\";i:150;s:6:\"height\";i:82;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:1035;}}s:10:\"image_meta\";a:13:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}s:3:\"alt\";s:0:\"\";}}'),
(21, 5, '_elementor_page_settings', 'a:46:{s:13:\"system_colors\";a:4:{i:0;a:3:{s:3:\"_id\";s:7:\"primary\";s:5:\"title\";s:20:\"Primary (Brand Gold)\";s:5:\"color\";s:7:\"#F3B351\";}i:1;a:3:{s:3:\"_id\";s:9:\"secondary\";s:5:\"title\";s:23:\"Secondary (Brand Green)\";s:5:\"color\";s:7:\"#1EFF85\";}i:2;a:3:{s:3:\"_id\";s:4:\"text\";s:5:\"title\";s:4:\"Text\";s:5:\"color\";s:7:\"#475569\";}i:3;a:3:{s:3:\"_id\";s:6:\"accent\";s:5:\"title\";s:12:\"Accent (Ink)\";s:5:\"color\";s:7:\"#0B1120\";}}s:13:\"custom_colors\";a:9:{i:0;a:3:{s:3:\"_id\";s:9:\"sklgolddp\";s:5:\"title\";s:15:\"Gold Deep (CTA)\";s:5:\"color\";s:7:\"#E0912B\";}i:1;a:3:{s:3:\"_id\";s:10:\"sklgreendp\";s:5:\"title\";s:17:\"Green Deep (a11y)\";s:5:\"color\";s:7:\"#10B981\";}i:2;a:3:{s:3:\"_id\";s:10:\"sklheading\";s:5:\"title\";s:7:\"Heading\";s:5:\"color\";s:7:\"#0F172A\";}i:3;a:3:{s:3:\"_id\";s:9:\"sklink900\";s:5:\"title\";s:7:\"Ink 900\";s:5:\"color\";s:7:\"#0F172A\";}i:4;a:3:{s:3:\"_id\";s:9:\"sklink800\";s:5:\"title\";s:7:\"Ink 800\";s:5:\"color\";s:7:\"#1E293B\";}i:5;a:3:{s:3:\"_id\";s:8:\"sklmuted\";s:5:\"title\";s:5:\"Muted\";s:5:\"color\";s:7:\"#94A3B8\";}i:6;a:3:{s:3:\"_id\";s:8:\"sklbgalt\";s:5:\"title\";s:6:\"BG Alt\";s:5:\"color\";s:7:\"#F8FAFC\";}i:7;a:3:{s:3:\"_id\";s:9:\"sklborder\";s:5:\"title\";s:6:\"Border\";s:5:\"color\";s:7:\"#E2E8F0\";}i:8;a:3:{s:3:\"_id\";s:8:\"sklwhite\";s:5:\"title\";s:5:\"White\";s:5:\"color\";s:7:\"#FFFFFF\";}}s:17:\"system_typography\";a:4:{i:0;a:5:{s:3:\"_id\";s:7:\"primary\";s:5:\"title\";s:18:\"Primary (Headings)\";s:21:\"typography_typography\";s:6:\"custom\";s:22:\"typography_font_family\";s:4:\"Sora\";s:22:\"typography_font_weight\";s:3:\"700\";}i:1;a:5:{s:3:\"_id\";s:9:\"secondary\";s:5:\"title\";s:24:\"Secondary (Sub-headings)\";s:21:\"typography_typography\";s:6:\"custom\";s:22:\"typography_font_family\";s:4:\"Sora\";s:22:\"typography_font_weight\";s:3:\"600\";}i:2;a:5:{s:3:\"_id\";s:4:\"text\";s:5:\"title\";s:11:\"Text (Body)\";s:21:\"typography_typography\";s:6:\"custom\";s:22:\"typography_font_family\";s:5:\"Inter\";s:22:\"typography_font_weight\";s:3:\"400\";}i:3;a:5:{s:3:\"_id\";s:6:\"accent\";s:5:\"title\";s:24:\"Accent (Buttons/Eyebrow)\";s:21:\"typography_typography\";s:6:\"custom\";s:22:\"typography_font_family\";s:5:\"Inter\";s:22:\"typography_font_weight\";s:3:\"600\";}}s:17:\"custom_typography\";a:3:{i:0;a:7:{s:3:\"_id\";s:10:\"skldisplay\";s:5:\"title\";s:7:\"Display\";s:21:\"typography_typography\";s:6:\"custom\";s:22:\"typography_font_family\";s:4:\"Sora\";s:22:\"typography_font_weight\";s:3:\"700\";s:25:\"typography_letter_spacing\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:-1;s:5:\"sizes\";a:0:{}}s:22:\"typography_line_height\";a:3:{s:4:\"unit\";s:2:\"em\";s:4:\"size\";d:1.05;s:5:\"sizes\";a:0:{}}}i:1;a:8:{s:3:\"_id\";s:10:\"skleyebrow\";s:5:\"title\";s:18:\"Eyebrow / Overline\";s:21:\"typography_typography\";s:6:\"custom\";s:22:\"typography_font_family\";s:5:\"Inter\";s:22:\"typography_font_weight\";s:3:\"600\";s:25:\"typography_text_transform\";s:9:\"uppercase\";s:25:\"typography_letter_spacing\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";d:1.5;s:5:\"sizes\";a:0:{}}s:20:\"typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:12;s:5:\"sizes\";a:0:{}}}i:2;a:7:{s:3:\"_id\";s:7:\"sklstat\";s:5:\"title\";s:14:\"Stat / Counter\";s:21:\"typography_typography\";s:6:\"custom\";s:22:\"typography_font_family\";s:4:\"Sora\";s:22:\"typography_font_weight\";s:3:\"700\";s:20:\"typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:56;s:5:\"sizes\";a:0:{}}s:22:\"typography_line_height\";a:3:{s:4:\"unit\";s:2:\"em\";s:4:\"size\";i:1;s:5:\"sizes\";a:0:{}}}}s:21:\"default_generic_fonts\";s:10:\"sans-serif\";s:9:\"site_logo\";a:2:{s:2:\"id\";i:11;s:3:\"url\";s:79:\"http://localhost/sklentr/sklentr-v2/wp-content/uploads/2026/07/sklentr-logo.png\";}s:26:\"body_typography_typography\";s:6:\"custom\";s:27:\"body_typography_font_family\";s:5:\"Inter\";s:27:\"body_typography_font_weight\";s:3:\"400\";s:25:\"body_typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:16;s:5:\"sizes\";a:0:{}}s:27:\"body_typography_line_height\";a:3:{s:4:\"unit\";s:2:\"em\";s:4:\"size\";d:1.65;s:5:\"sizes\";a:0:{}}s:10:\"body_color\";s:7:\"#475569\";s:24:\"h1_typography_typography\";s:6:\"custom\";s:25:\"h1_typography_font_family\";s:4:\"Sora\";s:25:\"h1_typography_font_weight\";s:3:\"700\";s:23:\"h1_typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:56;s:5:\"sizes\";a:0:{}}s:25:\"h1_typography_line_height\";a:3:{s:4:\"unit\";s:2:\"em\";s:4:\"size\";d:1.1;s:5:\"sizes\";a:0:{}}s:28:\"h1_typography_letter_spacing\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:-1;s:5:\"sizes\";a:0:{}}s:24:\"h2_typography_typography\";s:6:\"custom\";s:25:\"h2_typography_font_family\";s:4:\"Sora\";s:25:\"h2_typography_font_weight\";s:3:\"700\";s:23:\"h2_typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:44;s:5:\"sizes\";a:0:{}}s:25:\"h2_typography_line_height\";a:3:{s:4:\"unit\";s:2:\"em\";s:4:\"size\";d:1.15;s:5:\"sizes\";a:0:{}}s:24:\"h3_typography_typography\";s:6:\"custom\";s:25:\"h3_typography_font_family\";s:4:\"Sora\";s:25:\"h3_typography_font_weight\";s:3:\"600\";s:23:\"h3_typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:32;s:5:\"sizes\";a:0:{}}s:24:\"h4_typography_typography\";s:6:\"custom\";s:25:\"h4_typography_font_family\";s:4:\"Sora\";s:25:\"h4_typography_font_weight\";s:3:\"600\";s:23:\"h4_typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:24;s:5:\"sizes\";a:0:{}}s:24:\"h5_typography_typography\";s:6:\"custom\";s:25:\"h5_typography_font_family\";s:4:\"Sora\";s:25:\"h5_typography_font_weight\";s:3:\"600\";s:23:\"h5_typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:20;s:5:\"sizes\";a:0:{}}s:24:\"h6_typography_typography\";s:6:\"custom\";s:25:\"h6_typography_font_family\";s:4:\"Sora\";s:25:\"h6_typography_font_weight\";s:3:\"600\";s:23:\"h6_typography_font_size\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:18;s:5:\"sizes\";a:0:{}}s:13:\"heading_color\";s:7:\"#0F172A\";s:17:\"link_normal_color\";s:7:\"#E0912B\";s:16:\"link_hover_color\";s:7:\"#B4711E\";s:28:\"button_typography_typography\";s:6:\"custom\";s:29:\"button_typography_font_family\";s:5:\"Inter\";s:29:\"button_typography_font_weight\";s:3:\"600\";s:15:\"container_width\";a:3:{s:4:\"unit\";s:2:\"px\";s:4:\"size\";i:1366;s:5:\"sizes\";a:0:{}}}'),
(23, 12, '_wp_attached_file', '2026/07/hero.png'),
(24, 12, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:619;s:6:\"height\";i:672;s:4:\"file\";s:16:\"2026/07/hero.png\";s:8:\"filesize\";i:207740;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:16:\"hero-276x300.png\";s:5:\"width\";i:276;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:62931;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:16:\"hero-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:24518;}}s:10:\"image_meta\";a:13:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}s:3:\"alt\";s:0:\"\";}}'),
(25, 13, '_wp_attached_file', '2026/07/hero-1.png'),
(26, 13, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:98;s:6:\"height\";i:164;s:4:\"file\";s:18:\"2026/07/hero-1.png\";s:8:\"filesize\";i:3925;s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:5:{s:4:\"file\";s:17:\"hero-1-98x150.png\";s:5:\"width\";i:98;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:3865;}}s:10:\"image_meta\";a:13:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}s:3:\"alt\";s:0:\"\";}}'),
(359, 118, '_skl_answer', 'Yes — 100%. You receive full source-code ownership and IP rights on delivery. No lock-in and no licensing games.'),
(360, 119, '_skl_answer', 'Pricing is fixed and published. Each tier lists exactly what’s included, and you approve the scope before we start. No surprise invoices, ever.'),
(361, 120, '_skl_answer', 'Absolutely — it’s our specialty. We build working MVPs that prove business viability to designated organizations, on a timeline that fits your visa process.'),
(362, 121, '_skl_answer', 'Every project includes a post-launch support window (2 weeks to 3 months, depending on tier). We’re a partner, not a vendor — many clients stay on for the next build.'),
(363, 122, '_skl_answer', 'A modern, consistent stack — Next.js, React, Laravel, React Native, Flutter, PostgreSQL, WordPress — with AI (Gemini, OpenAI, Claude) woven into product workflows where it adds real value.'),
(364, 65, '_skl_category', 'Web & Mobile Applications'),
(365, 65, '_skl_price', '$5,000'),
(366, 65, '_skl_currency', 'CAD'),
(367, 65, '_skl_timeline', '2–8 weeks'),
(368, 65, '_skl_features', 'Web applications (Next.js, React)\nMobile apps (React Native, Flutter)\nAPI development & integrations\nDatabase architecture\nUser authentication & security\nAdmin dashboards'),
(369, 65, '_skl_cta_link', '#contact'),
(370, 66, '_skl_category', 'WordPress & Custom Development'),
(371, 66, '_skl_price', '$2,500'),
(372, 66, '_skl_currency', 'CAD'),
(373, 66, '_skl_timeline', '1–4 weeks'),
(374, 66, '_skl_features', 'Custom website design\nWordPress development\nNext.js static sites\nE-commerce solutions\nLanding pages\nWebsite maintenance'),
(375, 66, '_skl_cta_link', '#contact'),
(376, 67, '_skl_category', 'Search & Social Media'),
(377, 67, '_skl_price', '$1,500'),
(378, 67, '_skl_currency', '/month'),
(379, 67, '_skl_timeline', 'Ongoing'),
(380, 67, '_skl_features', 'Technical SEO audits\nOn-page optimization\nContent strategy\nSocial media management\nLink building\nLocal SEO'),
(381, 67, '_skl_cta_link', '#contact'),
(382, 68, '_skl_category', 'Google & Meta Ads'),
(383, 68, '_skl_price', '$1,000'),
(384, 68, '_skl_currency', '/month + ad spend'),
(385, 68, '_skl_timeline', 'Ongoing'),
(386, 68, '_skl_features', 'Google Ads management\nMeta (Facebook/Instagram) Ads\nCampaign strategy\nA/B testing\nConversion tracking\nMonthly reporting'),
(387, 68, '_skl_cta_link', '#contact'),
(388, 69, '_skl_category', 'Promo & Social Content'),
(389, 69, '_skl_price', '$1,500'),
(390, 69, '_skl_currency', 'CAD'),
(391, 69, '_skl_timeline', '1–2 weeks'),
(392, 69, '_skl_features', 'Promotional videos\nProduct demos\nSocial media content\nExplainer videos\nTestimonial videos\nMotion graphics'),
(393, 69, '_skl_cta_link', '#contact'),
(394, 70, '_skl_category', 'Strategy & Growth Planning'),
(395, 70, '_skl_price', '$200'),
(396, 70, '_skl_currency', '/hour'),
(397, 70, '_skl_timeline', 'Flexible'),
(398, 70, '_skl_features', 'Product strategy\nMarket research\nTechnical roadmapping\nGrowth planning\nInvestor pitch prep\nMVP scoping'),
(399, 70, '_skl_cta_link', '#contact'),
(400, 123, '_skl_icon', 'bolt'),
(401, 123, '_skl_desc', 'Launch fast. Iterate faster. We’ve shipped products in as little as 14 days.'),
(402, 124, '_skl_icon', 'grid'),
(403, 124, '_skl_desc', 'Dev, design, SEO, marketing, video — no juggling vendors.'),
(404, 125, '_skl_icon', 'globe'),
(405, 125, '_skl_desc', 'Toronto-managed, globally powered. Premium work without the premium markup.'),
(406, 126, '_skl_icon', 'scale'),
(407, 126, '_skl_desc', 'Real architecture, not duct tape. Your MVP becomes your product.'),
(408, 127, '_skl_icon', 'ai'),
(31, 14, '_wp_page_template', 'default'),
(417, 134, '_skl_tag1', 'Healthcare'),
(418, 134, '_skl_tag2', 'AI'),
(419, 134, '_skl_status', 'Ongoing partnership'),
(414, 14, '_edit_lock', '1784708669:1'),
(415, 65, '_edit_lock', '1784711911:1'),
(416, 134, '_skl_slug', 'horizontrials'),
(35, 14, '_elementor_migrations_state_d2a1', '4.1.5:595e50d38ae27a4ec16e0e0a9df00b29'),
(421, 134, '_skl_challenge', 'Cancer patients struggle to find relevant clinical trials. The process is manual, time-consuming, and often patients miss out on life-saving opportunities.'),
(422, 134, '_skl_solution', 'We built an AI-powered matching engine using Google Gemini that analyzes patient records and trial requirements, delivering personalized matches with confidence scores.'),
(423, 134, '_skl_results', '2-month development timeline\n1-year ongoing partnership\nServing patients across Canada\nIntegration with major CROs'),
(424, 134, '_skl_stack', 'Laravel\nNext.js\nGoogle Gemini\nPostgreSQL'),
(425, 135, '_skl_slug', 'aifarming'),
(426, 135, '_skl_tag1', 'AgriTech'),
(427, 135, '_skl_tag2', 'AI'),
(428, 135, '_skl_status', 'In funding talks'),
(429, 135, '_skl_desc', 'A comprehensive AI-based plant management system for urban farmers in Canada. From seed to harvest, the platform provides real-time recommendations based on location, weather, and plant status.'),
(430, 135, '_skl_challenge', 'Urban farmers lack expertise and real-time guidance. Food waste is rampant, and local produce demand goes unmet.'),
(431, 135, '_skl_solution', 'We created an end-to-end platform with AI-powered growing guides, a neighborhood marketplace for selling produce, and a vast plant database with regional growing data.'),
(432, 135, '_skl_results', '3-month development\nCurrently in funding talks\nLarge plant database built\nCommunity marketplace launched'),
(433, 135, '_skl_stack', 'Laravel\nNext.js\nWordPress\nGoogle Gemini'),
(434, 136, '_skl_slug', 'gettakaful'),
(435, 136, '_skl_tag1', 'FinTech'),
(436, 136, '_skl_tag2', 'Blockchain'),
(437, 136, '_skl_status', 'Launching soon'),
(438, 136, '_skl_desc', 'A Shariah-compliant insurance alternative for Muslims in Canada. Built on blockchain for transparency, users see exactly where their money goes and can vote on claim approvals.'),
(439, 136, '_skl_challenge', 'Muslims in Canada lack access to ethical, Shariah-compliant insurance options. Traditional insurance conflicts with Islamic principles.'),
(440, 136, '_skl_solution', 'We built a transparent, community-driven Takaful platform on blockchain. Investments go only into halal businesses, and the community votes on approvals.'),
(441, 136, '_skl_results', '#1 SEO rankings for Islamic insurance keywords\nWeekly user inquiries\nLaunching soon\nStrong community traction'),
(442, 136, '_skl_stack', 'Laravel\nNext.js\nBlockchain\nWordPress'),
(443, 137, '_skl_slug', 'kindredcare'),
(444, 137, '_skl_tag1', 'Healthcare'),
(445, 137, '_skl_tag2', 'Elderly Care'),
(446, 137, '_skl_status', 'Onboarding caregivers'),
(447, 137, '_skl_desc', 'An interactive marketplace connecting families with pre-vetted caregivers. Features AI-powered granular matching beyond basics — hobbies, interests, cultural similarities, food habits, even movie preferences — ensuring long-term care contracts.'),
(448, 137, '_skl_challenge', 'Families struggle to find reliable, compatible caregivers. Traditional matching is surface-level and leads to short-term relationships and caregiver turnover.'),
(449, 137, '_skl_solution', 'We built an intelligent matching platform with granular AI matching using ChatGPT and Gemini. Includes interview scheduling with guidance and fully customizable service packages.'),
(450, 137, '_skl_results', '2.5-month development\nMVP complete\nCurrently onboarding caregivers\nGranular AI matching live'),
(451, 137, '_skl_stack', 'Laravel\nNext.js\nChatGPT\nGoogle Gemini'),
(452, 138, '_skl_slug', 'agilesourcing'),
(453, 138, '_skl_tag1', 'Fashion'),
(454, 138, '_skl_tag2', 'Sustainable Design'),
(455, 138, '_skl_status', 'Platform launched'),
(456, 138, '_skl_desc', 'Helps sustainable designers validate designs before production via social-media publishing and data analysis. AI-powered design creation and clothing-image generation with Instagram analytics to predict market success.'),
(457, 138, '_skl_challenge', 'Sustainable fashion designers risk producing items that don’t sell. Without market validation, they waste resources on unpopular designs.'),
(458, 138, '_skl_solution', 'We built a platform that generates AI clothing images, publishes to Instagram, and analyzes engagement (views, comments, shares) to predict market viability. Also includes supplier sourcing with sustainability verification.'),
(459, 138, '_skl_results', '3-month development\nPlatform launched\nOnboarding designers\nInstagram validation active'),
(460, 138, '_skl_stack', 'Laravel\nNext.js\nAI\nInstagram API'),
(461, 139, '_skl_slug', 'gaindata'),
(462, 139, '_skl_tag1', 'SaaS'),
(463, 139, '_skl_tag2', 'Data Analytics'),
(464, 139, '_skl_status', 'MVP launched'),
(465, 139, '_skl_desc', 'AI-powered data-intelligence platform solving the small-data problem for startups and SMEs. Features an AI Survey Generator, a Synthetic Data Engine, and a dual-dashboard experience for comprehensive data workflows.'),
(466, 139, '_skl_challenge', 'Startups and SMEs lack quality data to make confident decisions. Small sample sizes, poor data quality, and inability to afford data scientists hold them back.'),
(467, 139, '_skl_solution', 'We built a platform with an AI Survey Generator (creates questionnaires based on goals), a Synthetic Data Engine (expands small datasets), and a dual-dashboard for account and project insights.'),
(468, 139, '_skl_results', '3-month development\nMVP launched\nUsers actively using surveys\nScalable architecture ready'),
(469, 139, '_skl_stack', 'Laravel\nNext.js\nChatGPT\nGemini\nClaude'),
(484, 146, '_skl_cover', 'data'),
(485, 146, '_skl_byline', 'Rishad Wahid'),
(488, 147, '_skl_cover', 'fintech'),
(489, 147, '_skl_byline', 'Sklentr Team'),
(492, 148, '_skl_cover', 'healthcare'),
(493, 148, '_skl_byline', 'Sklentr Team'),
(496, 149, '_skl_cover', 'fashion'),
(497, 149, '_skl_byline', 'Rishad Wahid'),
(500, 150, '_skl_cover', 'agritech'),
(501, 150, '_skl_byline', 'Sklentr Team'),
(504, 151, '_skl_cover', 'care'),
(505, 151, '_skl_byline', 'Rishad Wahid'),
(37, 15, '_elementor_data', '[{\"id\":\"sklhero009\",\"elType\":\"section\",\"elements\":[{\"id\":\"sklhero010\",\"elType\":\"widget\",\"widgetType\":\"image\",\"elements\":[],\"settings\":{\"image\":{\"url\":\"http://localhost/sklentr/sklentr-v2/wp-content/uploads/2026/07/hero-1.png\",\"id\":13},\"image_size\":\"full\",\"_position\":\"absolute\",\"position\":\"absolute\",\"_offset_orientation_h\":\"start\",\"_offset_x\":{\"unit\":\"px\",\"size\":20,\"sizes\":[]},\"_offset_orientation_v\":\"start\",\"_offset_y\":{\"unit\":\"px\",\"size\":30,\"sizes\":[]},\"_element_width\":\"initial\",\"_element_custom_width\":{\"unit\":\"px\",\"size\":120,\"sizes\":[]},\"_z_index\":1,\"opacity\":{\"unit\":\"px\",\"size\":0.9,\"sizes\":[]},\"hide_mobile\":\"hidden_mobile\"}},{\"id\":\"sklhero006\",\"elType\":\"column\",\"elements\":[{\"id\":\"sklhero001\",\"elType\":\"widget\",\"widgetType\":\"heading\",\"elements\":[],\"settings\":{\"title\":\"TORONTO-BASED MVP STUDIO · 100% CANADIAN MANAGEMENT\",\"header_size\":\"div\",\"title_color\":\"#E0912B\",\"typography_typography\":\"custom\",\"typography_font_family\":\"Inter\",\"typography_font_size\":{\"unit\":\"px\",\"size\":13,\"sizes\":[]},\"typography_font_weight\":\"600\",\"typography_text_transform\":\"uppercase\",\"typography_letter_spacing\":{\"unit\":\"px\",\"size\":1.5,\"sizes\":[]},\"_margin\":{\"unit\":\"px\",\"top\":\"0\",\"right\":\"0\",\"bottom\":\"14\",\"left\":\"0\",\"isLinked\":false}}},{\"id\":\"sklhero002\",\"elType\":\"widget\",\"widgetType\":\"heading\",\"elements\":[],\"settings\":{\"title\":\"Launch-Ready MVPs\",\"header_size\":\"h2\",\"title_color\":\"#94A3B8\",\"typography_typography\":\"custom\",\"typography_font_family\":\"Sora\",\"typography_font_size\":{\"unit\":\"px\",\"size\":34,\"sizes\":[]},\"typography_font_size_tablet\":{\"unit\":\"px\",\"size\":28,\"sizes\":[]},\"typography_font_size_mobile\":{\"unit\":\"px\",\"size\":24,\"sizes\":[]},\"typography_font_weight\":\"600\",\"typography_line_height\":{\"unit\":\"em\",\"size\":1.1,\"sizes\":[]},\"_margin\":{\"unit\":\"px\",\"top\":\"0\",\"right\":\"0\",\"bottom\":\"0\",\"left\":\"0\",\"isLinked\":false}}},{\"id\":\"sklhero003\",\"elType\":\"widget\",\"widgetType\":\"heading\",\"elements\":[],\"settings\":{\"title\":\"In Weeks, Not Months.\",\"header_size\":\"h1\",\"title_color\":\"#0B1120\",\"typography_typography\":\"custom\",\"typography_font_family\":\"Sora\",\"typography_font_size\":{\"unit\":\"px\",\"size\":62,\"sizes\":[]},\"typography_font_size_tablet\":{\"unit\":\"px\",\"size\":46,\"sizes\":[]},\"typography_font_size_mobile\":{\"unit\":\"px\",\"size\":36,\"sizes\":[]},\"typography_font_weight\":\"700\",\"typography_line_height\":{\"unit\":\"em\",\"size\":1.04,\"sizes\":[]},\"typography_letter_spacing\":{\"unit\":\"px\",\"size\":-1.2,\"sizes\":[]},\"_margin\":{\"unit\":\"px\",\"top\":\"4\",\"right\":\"0\",\"bottom\":\"20\",\"left\":\"0\",\"isLinked\":false}}},{\"id\":\"sklhero004\",\"elType\":\"widget\",\"widgetType\":\"text-editor\",\"elements\":[],\"settings\":{\"editor\":\"<p>We build MVPs that get you funded, validated, and to market — fast. Canadian expertise. Transparent pricing. No excuses.</p>\",\"text_color\":\"#475569\",\"typography_typography\":\"custom\",\"typography_font_family\":\"Inter\",\"typography_font_size\":{\"unit\":\"px\",\"size\":18,\"sizes\":[]},\"typography_line_height\":{\"unit\":\"em\",\"size\":1.7,\"sizes\":[]},\"_margin\":{\"unit\":\"px\",\"top\":\"0\",\"right\":\"0\",\"bottom\":\"32\",\"left\":\"0\",\"isLinked\":false}}},{\"id\":\"sklhero005\",\"elType\":\"widget\",\"widgetType\":\"button\",\"elements\":[],\"settings\":{\"text\":\"Book a Free Consultation\",\"link\":{\"url\":\"#book\",\"is_external\":\"\",\"nofollow\":\"\"},\"align\":\"left\",\"size\":\"lg\",\"background_color\":\"#F3B351\",\"button_text_color\":\"#0B1120\",\"hover_color\":\"#FFFFFF\",\"button_background_hover_color\":\"#0B1120\",\"typography_typography\":\"custom\",\"typography_font_family\":\"Inter\",\"typography_font_weight\":\"600\",\"typography_font_size\":{\"unit\":\"px\",\"size\":16,\"sizes\":[]},\"border_radius\":{\"unit\":\"px\",\"top\":\"40\",\"right\":\"40\",\"bottom\":\"40\",\"left\":\"40\",\"isLinked\":true},\"text_padding\":{\"unit\":\"px\",\"top\":\"18\",\"right\":\"40\",\"bottom\":\"18\",\"left\":\"40\",\"isLinked\":false},\"button_box_shadow_box_shadow_type\":\"yes\",\"button_box_shadow_box_shadow\":{\"horizontal\":0,\"vertical\":10,\"blur\":26,\"spread\":0,\"color\":\"rgba(243,179,81,0.45)\"}}}],\"settings\":{\"_column_size\":50,\"_inline_size\":52,\"content_position\":\"center\",\"padding\":{\"unit\":\"px\",\"top\":\"0\",\"right\":\"40\",\"bottom\":\"0\",\"left\":\"0\",\"isLinked\":false},\"padding_mobile\":{\"unit\":\"px\",\"top\":\"0\",\"right\":\"0\",\"bottom\":\"40\",\"left\":\"0\",\"isLinked\":false}}},{\"id\":\"sklhero008\",\"elType\":\"column\",\"elements\":[{\"id\":\"sklhero007\",\"elType\":\"widget\",\"widgetType\":\"image\",\"elements\":[],\"settings\":{\"image\":{\"url\":\"http://localhost/sklentr/sklentr-v2/wp-content/uploads/2026/07/hero.png\",\"id\":12},\"image_size\":\"full\",\"align\":\"center\",\"width\":{\"unit\":\"%\",\"size\":100,\"sizes\":[]}}}],\"settings\":{\"_column_size\":50,\"_inline_size\":48,\"content_position\":\"center\"}}],\"settings\":{\"layout\":\"boxed\",\"gap\":\"wide\",\"height\":\"min-height\",\"custom_height\":{\"unit\":\"px\",\"size\":640,\"sizes\":[]},\"custom_height_mobile\":{\"unit\":\"px\",\"size\":0,\"sizes\":[]},\"content_position\":\"middle\",\"background_background\":\"classic\",\"background_color\":\"#FFF9EF\",\"padding\":{\"unit\":\"px\",\"top\":\"80\",\"right\":\"0\",\"bottom\":\"80\",\"left\":\"0\",\"isLinked\":false},\"padding_mobile\":{\"unit\":\"px\",\"top\":\"48\",\"right\":\"0\",\"bottom\":\"48\",\"left\":\"0\",\"isLinked\":false},\"structure\":\"20\"}}]'),
(38, 15, '_elementor_edit_mode', 'builder'),
(39, 15, '_elementor_template_type', 'wp-page'),
(40, 15, '_elementor_version', '4.1.5'),
(41, 15, '_wp_page_template', 'elementor_header_footer'),
(420, 134, '_skl_desc', 'A groundbreaking platform that uses AI to match cancer patients with clinical trials across Canada. Patients upload their medical records, and the system ranks trials by matching score, notifying them of newly listed opportunities.'),
(412, 132, '_edit_lock', '1784708992:1'),
(413, 61, '_edit_lock', '1784707765:1'),
(44, 15, '_elementor_migrations_state_d2a1', '4.1.5:595e50d38ae27a4ec16e0e0a9df00b29'),
(409, 127, '_skl_desc', 'We integrate Claude Code into our workflow. Faster, smarter builds.'),
(410, 128, '_skl_icon', 'shield'),
(411, 128, '_skl_desc', 'Unlike traditional outsourcing, our Canadian team owns your delivery.'),
(350, 112, '_skl_region', 'global'),
(358, 117, '_skl_answer', 'Toronto-based project leads own strategy, communication, and accountability, while an expert global team handles engineering and design. You get premium quality and clear communication — without the premium markup.'),
(357, 116, '_skl_answer', 'Ruthless scope and a proven stack. We build one sharp value loop first — the core feature, done well — and defer everything non-essential. A fixed scope agreed up front plus daily, visible progress keeps it on time.'),
(62, 16, '_skl_tone', 'gold'),
(63, 16, '_skl_icon', 'clock'),
(64, 16, '_skl_problem_text', 'Agencies take 6+ months while your funding window quietly closes.'),
(65, 16, '_skl_solution_text', 'A working MVP in 2–4 weeks — while the opportunity is still open.'),
(66, 17, '_skl_tone', 'green'),
(67, 17, '_skl_icon', 'tag'),
(68, 17, '_skl_problem_text', '$50k+ quotes just for a first version — before you’ve validated a thing.'),
(69, 17, '_skl_solution_text', 'Transparent fixed pricing from $5,000. You know the number up front.'),
(70, 18, '_skl_tone', 'blue'),
(71, 18, '_skl_icon', 'target'),
(72, 18, '_skl_problem_text', 'Months later you get something you didn’t ask for — and can’t even edit.'),
(73, 18, '_skl_solution_text', 'Founder-led discovery keeps us aligned, and you own 100% of the code.'),
(74, 19, '_skl_number', '50'),
(75, 19, '_skl_suffix', '+'),
(76, 20, '_skl_number', '15'),
(77, 20, '_skl_suffix', '+'),
(78, 21, '_skl_number', '98'),
(79, 21, '_skl_suffix', '%'),
(80, 22, '_skl_number', '14'),
(81, 22, '_skl_suffix', '-day'),
(82, 23, '_skl_number', '100'),
(83, 23, '_skl_suffix', '%'),
(84, 30, '_skl_week', 'Wk 1'),
(85, 30, '_skl_state', 'done'),
(86, 31, '_skl_week', 'Wk 2–3'),
(87, 31, '_skl_state', 'done'),
(88, 32, '_skl_week', 'Wk 4–5'),
(89, 32, '_skl_state', 'active'),
(90, 33, '_skl_week', 'Wk 6'),
(91, 33, '_skl_state', ''),
(92, 34, '_skl_count', '6'),
(93, 34, '_skl_suffix', ' wks'),
(94, 34, '_skl_display', ''),
(95, 35, '_skl_count', ''),
(96, 35, '_skl_suffix', ''),
(97, 35, '_skl_display', 'Fixed'),
(98, 36, '_skl_count', '100'),
(99, 36, '_skl_suffix', '%'),
(100, 36, '_skl_display', ''),
(101, 30, '_edit_lock', '1784195653:1'),
(348, 111, '_skl_region', 'asia'),
(349, 112, '_skl_role', 'Design, marketing & delivery'),
(347, 111, '_skl_role', 'Engineering & design'),
(346, 110, '_skl_region', 'canada'),
(344, 109, '_skl_category', 'ai'),
(345, 110, '_skl_role', 'Strategy & client relationships'),
(343, 109, '_skl_key', 'claude'),
(342, 108, '_skl_category', 'ai'),
(341, 108, '_skl_key', 'openai'),
(339, 107, '_skl_key', 'gemini'),
(340, 107, '_skl_category', 'ai'),
(338, 106, '_skl_category', 'cms'),
(337, 106, '_skl_key', 'wordpress'),
(335, 105, '_skl_key', 'postgresql'),
(336, 105, '_skl_category', 'database'),
(334, 104, '_skl_category', 'mobile'),
(333, 104, '_skl_key', 'flutter'),
(331, 103, '_skl_key', 'react'),
(332, 103, '_skl_category', 'mobile'),
(330, 102, '_skl_category', 'backend'),
(329, 102, '_skl_key', 'nodejs'),
(327, 101, '_skl_key', 'laravel'),
(328, 101, '_skl_category', 'backend'),
(326, 100, '_skl_category', 'frontend'),
(324, 99, '_skl_category', 'frontend'),
(325, 100, '_skl_key', 'tailwind'),
(323, 99, '_skl_key', 'typescript'),
(321, 98, '_skl_key', 'react'),
(322, 98, '_skl_category', 'frontend'),
(320, 97, '_skl_category', 'frontend'),
(319, 97, '_skl_key', 'nextjs'),
(318, 96, '_skl_features', 'Full product build\nCustom UI/UX\nMarketing included\n3 months support'),
(317, 96, '_skl_cta_link', '#contact'),
(316, 96, '_skl_cta_text', 'Book a Free Consultation'),
(315, 96, '_skl_badge', ''),
(314, 96, '_skl_popular', ''),
(312, 96, '_skl_currency', 'CAD'),
(313, 96, '_skl_period', '8+ weeks'),
(311, 96, '_skl_price', '$30,000+'),
(310, 96, '_skl_prefix', 'Starting at'),
(309, 95, '_skl_features', '5-7 features\nCustom UI design\nFull SEO included\n1 month support'),
(308, 95, '_skl_cta_link', '#contact'),
(307, 95, '_skl_cta_text', 'Book a Free Consultation'),
(305, 95, '_skl_popular', 'yes'),
(306, 95, '_skl_badge', 'Popular'),
(304, 95, '_skl_period', '4 weeks'),
(303, 95, '_skl_currency', 'CAD'),
(302, 95, '_skl_price', '$15,000'),
(218, 68, '_skl_desc', 'Drive targeted traffic with precision.'),
(217, 68, '_skl_reveal_icon', 'megaphone'),
(216, 68, '_skl_icon', 'target'),
(215, 67, '_skl_tags', 'Search Optimization\nSocial Media\nContent Strategy'),
(213, 67, '_skl_reveal_icon', 'chart'),
(214, 67, '_skl_desc', 'Get found and grow your audience online.'),
(212, 67, '_skl_icon', 'search'),
(211, 66, '_skl_tags', 'WordPress\nNext.js\nCustom Development'),
(210, 66, '_skl_desc', 'Professional websites that convert visitors.'),
(208, 66, '_skl_icon', 'layout'),
(209, 66, '_skl_reveal_icon', 'monitor'),
(207, 65, '_skl_tags', 'Web Apps\nMobile Apps\nAPI Development'),
(206, 65, '_skl_desc', 'Build your product fast with our expert team.'),
(205, 65, '_skl_reveal_icon', 'layers'),
(204, 65, '_skl_icon', 'rocket'),
(203, 64, '_skl_points', '100% source-code handover\nFull IP rights\n1-month post-launch support'),
(202, 63, '_skl_points', 'Toronto-based project leads\nExpert global engineering\nOne accountable team'),
(201, 62, '_skl_points', 'Published fixed pricing\nNo hidden fees, ever\nYou approve every scope'),
(200, 61, '_skl_points', '14-day average delivery\n98% on-time record\nWeekly progress demos'),
(192, 61, '_skl_icon', 'bolt'),
(193, 61, '_skl_desc', '14-day average delivery, 98% on-time. We move fast without cutting corners.'),
(194, 62, '_skl_icon', 'eye'),
(195, 62, '_skl_desc', 'Fixed, published pricing. No hidden costs and no surprise invoices — ever.'),
(196, 63, '_skl_icon', 'globe'),
(197, 63, '_skl_desc', 'Toronto strategy meets expert global delivery: premium quality at a competitive cost.'),
(198, 64, '_skl_icon', 'key'),
(199, 64, '_skl_desc', '100% source-code ownership and a real post-launch partnership. It’s yours.'),
(219, 68, '_skl_tags', 'Google Ads\nMeta Ads\nCampaign Management'),
(220, 69, '_skl_icon', 'video'),
(221, 69, '_skl_reveal_icon', 'film'),
(222, 69, '_skl_desc', 'Engaging video content for your brand.'),
(223, 69, '_skl_tags', 'Promo Videos\nSocial Content\nProduct Demos'),
(224, 70, '_skl_icon', 'users'),
(225, 70, '_skl_reveal_icon', 'bulb'),
(226, 70, '_skl_desc', 'Strategic guidance to help you scale.'),
(227, 70, '_skl_tags', 'Market Research\nProduct Strategy\nGrowth Planning'),
(301, 95, '_skl_prefix', 'Starting at'),
(300, 94, '_skl_features', '1-3 core features\nTemplate-based design\nBasic SEO setup\n2 weeks support'),
(299, 94, '_skl_cta_link', '#contact'),
(298, 94, '_skl_cta_text', 'Book a Free Consultation'),
(297, 94, '_skl_badge', ''),
(296, 94, '_skl_popular', ''),
(295, 94, '_skl_period', '2 weeks'),
(294, 94, '_skl_currency', 'CAD'),
(293, 94, '_skl_price', '$5,000'),
(292, 94, '_skl_prefix', 'Starting at'),
(291, 93, '_skl_duration', 'Week 6'),
(244, 81, '_skl_icon', 'product'),
(245, 81, '_skl_sub', 'Prove business viability'),
(246, 82, '_skl_icon', 'clock'),
(247, 82, '_skl_sub', 'Timeline that fits your visa process'),
(248, 83, '_skl_icon', 'budget'),
(249, 83, '_skl_sub', 'Pricing that respects your runway'),
(250, 84, '_skl_industry', 'Healthcare / AI'),
(251, 84, '_skl_outcome', '2-mo build · 1-yr partnership'),
(252, 84, '_skl_tags', 'Laravel\nNext.js\nGemini'),
(253, 84, '_skl_img', 'healthcare'),
(254, 84, '_skl_link', '/portfolio'),
(255, 85, '_skl_industry', 'AgriTech'),
(256, 85, '_skl_outcome', 'In funding discussions'),
(257, 85, '_skl_tags', 'Platform\nMarketplace'),
(258, 85, '_skl_img', 'agritech'),
(259, 85, '_skl_link', '/portfolio'),
(260, 86, '_skl_industry', 'FinTech / Blockchain'),
(261, 86, '_skl_outcome', '#1 SEO rankings · weekly inquiries'),
(262, 86, '_skl_tags', 'Shariah-compliant\nBlockchain'),
(263, 86, '_skl_img', 'fintech'),
(264, 86, '_skl_link', '/portfolio'),
(265, 87, '_skl_industry', 'Healthcare'),
(266, 87, '_skl_outcome', 'MVP complete · onboarding live'),
(267, 87, '_skl_tags', 'AI Matching\nMobile'),
(268, 87, '_skl_img', 'care'),
(269, 87, '_skl_link', '/portfolio'),
(270, 88, '_skl_industry', 'Fashion'),
(271, 88, '_skl_outcome', 'Launched'),
(272, 88, '_skl_tags', 'Design Validation\nWeb App'),
(273, 88, '_skl_img', 'fashion'),
(274, 88, '_skl_link', '/portfolio'),
(275, 89, '_skl_industry', 'SaaS'),
(276, 89, '_skl_outcome', 'MVP launched'),
(277, 89, '_skl_tags', 'AI\nData Intelligence'),
(278, 89, '_skl_img', 'data'),
(279, 89, '_skl_link', '/portfolio'),
(280, 90, '_skl_icon', 'discovery'),
(281, 90, '_skl_desc', 'A free 30-min consultation to clarify your vision and scope.'),
(282, 90, '_skl_duration', 'Day 1'),
(283, 91, '_skl_icon', 'design'),
(284, 91, '_skl_desc', 'UI/UX design plus the technical architecture.'),
(285, 91, '_skl_duration', 'Week 1'),
(286, 92, '_skl_icon', 'build'),
(287, 92, '_skl_desc', 'Agile sprints with regular progress demos.'),
(288, 92, '_skl_duration', 'Weeks 2–5'),
(289, 93, '_skl_icon', 'launch'),
(290, 93, '_skl_desc', 'QA, deployment, and a month of post-launch support.');

-- --------------------------------------------------------

--
-- Table structure for table `sk_posts`
--

DROP TABLE IF EXISTS `sk_posts`;
CREATE TABLE IF NOT EXISTS `sk_posts` (
  `ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_author` bigint UNSIGNED NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `menu_order` int NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_count` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`),
  KEY `type_status_author` (`post_type`,`post_status`,`post_author`)
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `sk_posts`
--

INSERT INTO `sk_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(149, 1, '2026-01-05 09:00:00', '2026-01-05 09:00:00', '<p>The founders who win aren’t the ones with the most polished first version. They’re the ones who learn fastest — and learning requires shipping.</p>\n<h2>Perfect is a guess</h2>\n<p>Every hour spent perfecting a feature nobody has used yet is an hour spent guessing. Real usage tells you what to improve; polish before launch is just expensive opinion.</p>\n<h2>Speed compounds</h2>\n<p>Ship, learn, adjust, repeat. A team on its third iteration understands its users better than a team still perfecting its first. That gap only widens over time.</p>\n<h2>Quality still matters — where it counts</h2>\n<p>“Not perfect” doesn’t mean sloppy. Make the core experience solid and trustworthy; leave the edges rough until users tell you which ones matter.</p>', 'Why Your MVP Doesn’t Need to Be Perfect', 'Perfectionism kills startups. Here’s why shipping fast matters more than shipping perfect.', 'publish', 'open', 'open', '', 'why-your-mvp-doesnt-need-to-be-perfect', '', '', '2026-01-05 09:00:00', '2026-01-05 09:00:00', '', 0, 'http://localhost/sklentr/sklentr-v2/why-your-mvp-doesnt-need-to-be-perfect/', 0, 'post', '', 0),
(2, 1, '2026-07-15 11:28:59', '2026-07-15 11:28:59', '<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\">\n<!-- wp:paragraph -->\n<p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</p>\n<!-- /wp:paragraph -->\n</blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\">\n<!-- wp:paragraph -->\n<p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p>\n<!-- /wp:paragraph -->\n</blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href=\"http://localhost/sklentr/sklentr-v2/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->', 'Sample Page', '', 'publish', 'closed', 'open', '', 'sample-page', '', '', '2026-07-15 11:28:59', '2026-07-15 11:28:59', '', 0, 'http://localhost/sklentr/sklentr-v2/?page_id=2', 0, 'page', '', 0),
(3, 1, '2026-07-15 11:28:59', '2026-07-15 11:28:59', '<p><em>Last updated: July 27, 2026</em></p>\n\n<p>SKL Entr (\"Sklentr\", \"we\", \"us\", or \"our\") respects your privacy. This Privacy Policy explains what information we collect, how we use it, and the choices you have when you visit sklentr.com or engage our services.</p>\n\n<h2>Information We Collect</h2>\n<ul>\n<li><strong>Information you provide.</strong> Your name, email address, phone number, company details, and any message content you submit through our contact forms, newsletter sign-up, or discovery-call bookings.</li>\n<li><strong>Usage data.</strong> Non-identifying technical data such as browser type, device, pages visited, and referring URLs, collected automatically to help us improve the site.</li>\n<li><strong>Cookies.</strong> Small files stored on your device to remember preferences and measure site performance. You can disable cookies in your browser settings.</li>\n</ul>\n\n<h2>How We Use Your Information</h2>\n<ul>\n<li>To respond to your enquiries and schedule consultations.</li>\n<li>To deliver the services you request and manage our engagement.</li>\n<li>To send newsletters and updates you have opted in to receive (you can unsubscribe at any time).</li>\n<li>To maintain, secure, and improve our website and services.</li>\n</ul>\n\n<h2>How We Share Information</h2>\n<p>We do not sell your personal information. We share it only with trusted service providers who help us operate our business (for example, hosting, analytics, and email delivery), and only to the extent needed to perform those services, or where required by law.</p>\n\n<h2>Data Retention</h2>\n<p>We keep personal information only for as long as necessary to fulfil the purposes described in this policy, or as required by applicable law.</p>\n\n<h2>Your Rights</h2>\n<p>Depending on your location, you may have the right to access, correct, or delete your personal information, or to withdraw consent. To exercise these rights, contact us using the details below.</p>\n\n<h2>Contact Us</h2>\n<p>If you have questions about this Privacy Policy, email us at <a href=\"mailto:info@sklentr.com\">info@sklentr.com</a>. SKL Entr is based in Toronto, Ontario, Canada.</p>', 'Privacy Policy', '', 'publish', 'closed', 'open', '', 'privacy-policy', '', '', '2026-07-27 03:27:06', '2026-07-27 03:27:06', '', 0, 'http://localhost/sklentr/sklentr-v2/?page_id=3', 0, 'page', '', 0),
(152, 0, '2026-07-27 03:27:06', '2026-07-27 03:27:06', '<p><em>Last updated: July 27, 2026</em></p>\n\n<p>SKL Entr (\"Sklentr\", \"we\", \"us\", or \"our\") respects your privacy. This Privacy Policy explains what information we collect, how we use it, and the choices you have when you visit sklentr.com or engage our services.</p>\n\n<h2>Information We Collect</h2>\n<ul>\n<li><strong>Information you provide.</strong> Your name, email address, phone number, company details, and any message content you submit through our contact forms, newsletter sign-up, or discovery-call bookings.</li>\n<li><strong>Usage data.</strong> Non-identifying technical data such as browser type, device, pages visited, and referring URLs, collected automatically to help us improve the site.</li>\n<li><strong>Cookies.</strong> Small files stored on your device to remember preferences and measure site performance. You can disable cookies in your browser settings.</li>\n</ul>\n\n<h2>How We Use Your Information</h2>\n<ul>\n<li>To respond to your enquiries and schedule consultations.</li>\n<li>To deliver the services you request and manage our engagement.</li>\n<li>To send newsletters and updates you have opted in to receive (you can unsubscribe at any time).</li>\n<li>To maintain, secure, and improve our website and services.</li>\n</ul>\n\n<h2>How We Share Information</h2>\n<p>We do not sell your personal information. We share it only with trusted service providers who help us operate our business (for example, hosting, analytics, and email delivery), and only to the extent needed to perform those services, or where required by law.</p>\n\n<h2>Data Retention</h2>\n<p>We keep personal information only for as long as necessary to fulfil the purposes described in this policy, or as required by applicable law.</p>\n\n<h2>Your Rights</h2>\n<p>Depending on your location, you may have the right to access, correct, or delete your personal information, or to withdraw consent. To exercise these rights, contact us using the details below.</p>\n\n<h2>Contact Us</h2>\n<p>If you have questions about this Privacy Policy, email us at <a href=\"mailto:info@sklentr.com\">info@sklentr.com</a>. SKL Entr is based in Toronto, Ontario, Canada.</p>', 'Privacy Policy', '', 'inherit', 'closed', 'closed', '', '3-revision-v1', '', '', '2026-07-27 03:27:06', '2026-07-27 03:27:06', '', 3, 'http://localhost/sklentr/sklentr-v2/?p=152', 0, 'revision', '', 0),
(153, 1, '2026-07-27 03:27:06', '2026-07-27 03:27:06', '<p><em>Last updated: July 27, 2026</em></p>\n\n<p>These Terms of Service (\"Terms\") govern your use of the sklentr.com website and any services provided by SKL Entr (\"Sklentr\", \"we\", \"us\", or \"our\"). By accessing our site or engaging our services, you agree to these Terms.</p>\n\n<h2>Use of Our Website</h2>\n<p>You agree to use this website lawfully and not to attempt to disrupt, damage, or gain unauthorized access to any part of it. All content on this site, including text, graphics, logos, and code, is owned by or licensed to Sklentr and may not be reproduced without permission.</p>\n\n<h2>Services</h2>\n<p>The scope, deliverables, timelines, and fees for any engagement are defined in a separate written proposal or agreement. In the event of a conflict, that agreement takes precedence over these Terms for the specific engagement.</p>\n\n<h2>Payments</h2>\n<p>Fees and payment schedules are set out in your project agreement. Unless otherwise stated, invoices are due on the terms specified in that agreement.</p>\n\n<h2>Intellectual Property</h2>\n<p>Upon full payment, ownership of the final deliverables produced specifically for your project transfers to you, except for any third-party or pre-existing components, which remain subject to their respective licenses.</p>\n\n<h2>Confidentiality</h2>\n<p>We treat information you share with us during an engagement as confidential and will not disclose it except as needed to deliver the services or as required by law.</p>\n\n<h2>Limitation of Liability</h2>\n<p>Our website and content are provided \"as is\" without warranties of any kind. To the fullest extent permitted by law, Sklentr is not liable for any indirect, incidental, or consequential damages arising from your use of the site or services.</p>\n\n<h2>Changes to These Terms</h2>\n<p>We may update these Terms from time to time. Continued use of the site after changes are posted constitutes acceptance of the revised Terms.</p>\n\n<h2>Contact Us</h2>\n<p>Questions about these Terms? Email <a href=\"mailto:info@sklentr.com\">info@sklentr.com</a>. SKL Entr is based in Toronto, Ontario, Canada.</p>', 'Terms of Service', '', 'publish', 'closed', 'closed', '', 'terms', '', '', '2026-07-27 03:27:06', '2026-07-27 03:27:06', '', 0, 'http://localhost/sklentr/sklentr-v2/terms/', 0, 'page', '', 0),
(4, 0, '2026-07-15 11:29:00', '2026-07-15 11:29:00', '<!-- wp:page-list /-->', 'Navigation', '', 'publish', 'closed', 'closed', '', 'navigation', '', '', '2026-07-15 11:29:00', '2026-07-15 11:29:00', '', 0, 'http://localhost/sklentr/sklentr-v2/index.php/2026/07/15/navigation/', 0, 'wp_navigation', '', 0),
(5, 0, '2026-07-15 11:31:35', '2026-07-15 11:31:35', '', 'Default Kit', '', 'publish', 'closed', 'closed', '', 'default-kit', '', '', '2026-07-15 11:31:35', '2026-07-15 11:31:35', '', 0, 'http://localhost/sklentr/sklentr-v2/?p=5', 0, 'elementor_library', '', 0),
(140, 1, '2026-07-22 12:04:12', '2026-07-22 12:04:12', '', 'About', '', 'publish', 'closed', 'closed', '', 'about', '', '', '2026-07-22 12:04:12', '2026-07-22 12:04:12', '', 0, 'http://localhost/sklentr/sklentr-v2/about/', 0, 'page', '', 0),
(7, 1, '2026-07-15 11:36:58', '0000-00-00 00:00:00', '', 'Hello Theme #7', '', 'draft', 'closed', 'closed', '', '', '', '', '2026-07-15 11:36:58', '2026-07-15 11:36:58', '', 0, 'http://localhost/sklentr/sklentr-v2/?page_id=7', 0, 'page', '', 0),
(8, 1, '2026-07-15 11:36:58', '2026-07-15 11:36:58', '', 'Hello Theme #7', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2026-07-15 11:36:58', '2026-07-15 11:36:58', '', 7, 'http://localhost/sklentr/sklentr-v2/?p=8', 0, 'revision', '', 0),
(9, 1, '2026-07-15 11:42:41', '0000-00-00 00:00:00', '', 'Elementor #9', '', 'draft', 'closed', 'closed', '', '', '', '', '2026-07-15 11:42:41', '2026-07-15 11:42:41', '', 0, 'http://localhost/sklentr/sklentr-v2/?page_id=9', 0, 'page', '', 0),
(10, 1, '2026-07-15 11:42:41', '2026-07-15 11:42:41', '', 'Elementor #9', '', 'inherit', 'closed', 'closed', '', '9-revision-v1', '', '', '2026-07-15 11:42:41', '2026-07-15 11:42:41', '', 9, 'http://localhost/sklentr/sklentr-v2/?p=10', 0, 'revision', '', 0),
(11, 0, '2026-07-15 11:55:18', '2026-07-15 11:55:18', '', 'Sklentr Logo', '', 'inherit', 'open', 'closed', '', 'sklentr-logo', '', '', '2026-07-15 11:55:18', '2026-07-15 11:55:18', '', 0, 'http://localhost/sklentr/sklentr-v2/wp-content/uploads/2026/07/sklentr-logo.png', 0, 'attachment', 'image/png', 0),
(12, 0, '2026-07-15 13:51:37', '2026-07-15 13:51:37', '', 'Hero Visual', '', 'inherit', 'open', 'closed', '', 'hero-visual', '', '', '2026-07-15 13:51:37', '2026-07-15 13:51:37', '', 0, 'http://localhost/sklentr/sklentr-v2/wp-content/uploads/2026/07/hero.png', 0, 'attachment', 'image/png', 0),
(13, 0, '2026-07-15 13:51:39', '2026-07-15 13:51:39', '', 'Hero Squiggle', '', 'inherit', 'open', 'closed', '', 'hero-squiggle', '', '', '2026-07-15 13:51:39', '2026-07-15 13:51:39', '', 0, 'http://localhost/sklentr/sklentr-v2/wp-content/uploads/2026/07/hero-1.png', 0, 'attachment', 'image/png', 0),
(14, 0, '2026-07-15 14:31:24', '2026-07-15 14:31:24', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2026-07-15 14:31:24', '2026-07-15 14:31:24', '', 0, 'http://localhost/sklentr/sklentr-v2/index.php/home/', 0, 'page', '', 0),
(15, 0, '2026-07-15 13:55:09', '2026-07-15 13:55:09', '', 'Home', '', 'inherit', 'closed', 'closed', '', '14-revision-v1', '', '', '2026-07-15 13:55:09', '2026-07-15 13:55:09', '', 14, 'http://localhost/sklentr/sklentr-v2/?p=15', 0, 'revision', '', 0),
(16, 0, '2026-07-16 09:40:12', '2026-07-16 09:40:12', '', 'Too slow', '', 'publish', 'closed', 'closed', '', 'too-slow', '', '', '2026-07-16 09:40:12', '2026-07-16 09:40:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_problem=too-slow', 0, 'skl_problem', '', 0),
(17, 0, '2026-07-16 09:40:12', '2026-07-16 09:40:12', '', 'Too expensive', '', 'publish', 'closed', 'closed', '', 'too-expensive', '', '', '2026-07-16 09:40:12', '2026-07-16 09:40:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_problem=too-expensive', 1, 'skl_problem', '', 0),
(18, 0, '2026-07-16 09:40:12', '2026-07-16 09:40:12', '', 'Wrong deliverable', '', 'publish', 'closed', 'closed', '', 'wrong-deliverable', '', '', '2026-07-16 09:40:12', '2026-07-16 09:40:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_problem=wrong-deliverable', 2, 'skl_problem', '', 0),
(19, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Projects shipped', '', 'publish', 'closed', 'closed', '', 'projects-shipped', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_stat=projects-shipped', 0, 'skl_stat', '', 0),
(20, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Startup Visa MVPs', '', 'publish', 'closed', 'closed', '', 'startup-visa-mvps', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_stat=startup-visa-mvps', 1, 'skl_stat', '', 0),
(21, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'On-time delivery', '', 'publish', 'closed', 'closed', '', 'on-time-delivery', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_stat=on-time-delivery', 2, 'skl_stat', '', 0),
(22, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Avg. delivery', '', 'publish', 'closed', 'closed', '', 'avg-delivery', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_stat=avg-delivery', 3, 'skl_stat', '', 0),
(23, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Source-code ownership', '', 'publish', 'closed', 'closed', '', 'source-code-ownership', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_stat=source-code-ownership', 4, 'skl_stat', '', 0),
(24, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Horizon Trials', '', 'publish', 'closed', 'closed', '', 'horizon-trials', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_project=horizon-trials', 0, 'skl_project', '', 0),
(25, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'AI Farming', '', 'publish', 'closed', 'closed', '', 'ai-farming', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_project=ai-farming', 1, 'skl_project', '', 0),
(26, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Get Takaful', '', 'publish', 'closed', 'closed', '', 'get-takaful', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_project=get-takaful', 2, 'skl_project', '', 0),
(27, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'KindredCare', '', 'publish', 'closed', 'closed', '', 'kindredcare', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_project=kindredcare', 3, 'skl_project', '', 0),
(28, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Agile Sourcing', '', 'publish', 'closed', 'closed', '', 'agile-sourcing', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_project=agile-sourcing', 4, 'skl_project', '', 0),
(29, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'GAinData', '', 'publish', 'closed', 'closed', '', 'gaindata', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_project=gaindata', 5, 'skl_project', '', 0),
(30, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Discovery', '', 'publish', 'closed', 'closed', '', 'discovery', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_hero_step=discovery', 0, 'skl_hero_step', '', 0),
(31, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Design', '', 'publish', 'closed', 'closed', '', 'design', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_hero_step=design', 1, 'skl_hero_step', '', 0),
(32, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Build', '', 'publish', 'closed', 'closed', '', 'build', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_hero_step=build', 2, 'skl_hero_step', '', 0),
(33, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Launch', '', 'publish', 'closed', 'closed', '', 'launch', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_hero_step=launch', 3, 'skl_hero_step', '', 0),
(34, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'to launch', '', 'publish', 'closed', 'closed', '', 'to-launch', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_hero_tile=to-launch', 0, 'skl_hero_tile', '', 0),
(35, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'transparent price', '', 'publish', 'closed', 'closed', '', 'transparent-price', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_hero_tile=transparent-price', 1, 'skl_hero_tile', '', 0),
(36, 0, '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 'Canadian mgmt', '', 'publish', 'closed', 'closed', '', 'canadian-mgmt', '', '', '2026-07-16 09:50:00', '2026-07-16 09:50:00', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_hero_tile=canadian-mgmt', 2, 'skl_hero_tile', '', 0),
(65, 1, '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 'MVP Development', '', 'publish', 'closed', 'closed', '', 'mvp-development', '', '', '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_service=mvp-development', 0, 'skl_service', '', 0),
(66, 1, '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 'Website Design', '', 'publish', 'closed', 'closed', '', 'website-design', '', '', '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_service=website-design', 1, 'skl_service', '', 0),
(67, 1, '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 'SEO & Marketing', '', 'publish', 'closed', 'closed', '', 'seo-marketing', '', '', '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_service=seo-marketing', 2, 'skl_service', '', 0),
(68, 1, '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 'Paid Ads', '', 'publish', 'closed', 'closed', '', 'paid-ads', '', '', '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_service=paid-ads', 3, 'skl_service', '', 0),
(69, 1, '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 'Video Production', '', 'publish', 'closed', 'closed', '', 'video-production', '', '', '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_service=video-production', 4, 'skl_service', '', 0),
(70, 1, '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 'Business Consultation', '', 'publish', 'closed', 'closed', '', 'business-consultation', '', '', '2026-07-16 14:21:20', '2026-07-16 14:21:20', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_service=business-consultation', 5, 'skl_service', '', 0),
(61, 1, '2026-07-16 13:42:27', '2026-07-16 13:42:27', '', 'Speed without compromise', '', 'publish', 'closed', 'closed', '', 'speed-without-compromise', '', '', '2026-07-16 13:42:27', '2026-07-16 13:42:27', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_pillar=speed-without-compromise', 0, 'skl_pillar', '', 0),
(62, 1, '2026-07-16 13:42:27', '2026-07-16 13:42:27', '', 'Radical transparency', '', 'publish', 'closed', 'closed', '', 'radical-transparency', '', '', '2026-07-16 13:42:27', '2026-07-16 13:42:27', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_pillar=radical-transparency', 1, 'skl_pillar', '', 0),
(63, 1, '2026-07-16 13:42:27', '2026-07-16 13:42:27', '', 'Canadian management, global talent', '', 'publish', 'closed', 'closed', '', 'canadian-management-global-talent', '', '', '2026-07-16 13:42:27', '2026-07-16 13:42:27', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_pillar=canadian-management-global-talent', 2, 'skl_pillar', '', 0),
(64, 1, '2026-07-16 13:42:27', '2026-07-16 13:42:27', '', 'You own everything', '', 'publish', 'closed', 'closed', '', 'you-own-everything', '', '', '2026-07-16 13:42:27', '2026-07-16 13:42:27', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_pillar=you-own-everything', 3, 'skl_pillar', '', 0),
(89, 0, '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 'GAinData', '', 'publish', 'closed', 'closed', '', 'gaindata', '', '', '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_work=gaindata', 5, 'skl_work', '', 0),
(88, 0, '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 'Agile Sourcing', '', 'publish', 'closed', 'closed', '', 'agile-sourcing', '', '', '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_work=agile-sourcing', 4, 'skl_work', '', 0),
(87, 0, '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 'KindredCare', '', 'publish', 'closed', 'closed', '', 'kindredcare', '', '', '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_work=kindredcare', 3, 'skl_work', '', 0),
(86, 0, '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 'Get Takaful', '', 'publish', 'closed', 'closed', '', 'get-takaful', '', '', '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_work=get-takaful', 2, 'skl_work', '', 0),
(85, 0, '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 'AI Farming', '', 'publish', 'closed', 'closed', '', 'ai-farming', '', '', '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_work=ai-farming', 1, 'skl_work', '', 0),
(84, 0, '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 'Horizon Trials', '', 'publish', 'closed', 'closed', '', 'horizon-trials', '', '', '2026-07-17 05:40:56', '2026-07-17 05:40:56', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_work=horizon-trials', 0, 'skl_work', '', 0),
(83, 0, '2026-07-17 02:52:59', '2026-07-17 02:52:59', '', 'Budget Friendly', '', 'publish', 'closed', 'closed', '', 'budget-friendly', '', '', '2026-07-17 02:52:59', '2026-07-17 02:52:59', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_visa_feature=budget-friendly', 2, 'skl_visa_feature', '', 0),
(82, 0, '2026-07-17 02:52:59', '2026-07-17 02:52:59', '', 'Meet Deadlines', '', 'publish', 'closed', 'closed', '', 'meet-deadlines', '', '', '2026-07-17 02:52:59', '2026-07-17 02:52:59', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_visa_feature=meet-deadlines', 1, 'skl_visa_feature', '', 0),
(81, 0, '2026-07-17 02:52:59', '2026-07-17 02:52:59', '', 'Working Product', '', 'publish', 'closed', 'closed', '', 'working-product', '', '', '2026-07-17 02:52:59', '2026-07-17 02:52:59', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_visa_feature=working-product', 0, 'skl_visa_feature', '', 0),
(90, 0, '2026-07-17 08:27:22', '2026-07-17 08:27:22', '', 'Discovery', '', 'publish', 'closed', 'closed', '', 'discovery', '', '', '2026-07-17 08:27:22', '2026-07-17 08:27:22', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_process=discovery', 0, 'skl_process', '', 0),
(91, 0, '2026-07-17 08:27:22', '2026-07-17 08:27:22', '', 'Design', '', 'publish', 'closed', 'closed', '', 'design', '', '', '2026-07-17 08:27:22', '2026-07-17 08:27:22', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_process=design', 1, 'skl_process', '', 0),
(92, 0, '2026-07-17 08:27:22', '2026-07-17 08:27:22', '', 'Build', '', 'publish', 'closed', 'closed', '', 'build', '', '', '2026-07-17 08:27:22', '2026-07-17 08:27:22', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_process=build', 2, 'skl_process', '', 0),
(93, 0, '2026-07-17 08:27:22', '2026-07-17 08:27:22', '', 'Launch', '', 'publish', 'closed', 'closed', '', 'launch', '', '', '2026-07-17 08:27:22', '2026-07-17 08:27:22', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_process=launch', 3, 'skl_process', '', 0),
(94, 0, '2026-07-20 05:18:16', '2026-07-20 05:18:16', '', 'Starter MVP', '', 'publish', 'closed', 'closed', '', 'starter-mvp', '', '', '2026-07-20 05:18:16', '2026-07-20 05:18:16', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_pricing=starter-mvp', 0, 'skl_pricing', '', 0),
(95, 0, '2026-07-20 05:18:16', '2026-07-20 05:18:16', '', 'Growth MVP', '', 'publish', 'closed', 'closed', '', 'growth-mvp', '', '', '2026-07-20 05:18:16', '2026-07-20 05:18:16', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_pricing=growth-mvp', 1, 'skl_pricing', '', 0),
(96, 0, '2026-07-20 05:18:16', '2026-07-20 05:18:16', '', 'Full-Service', '', 'publish', 'closed', 'closed', '', 'full-service', '', '', '2026-07-20 05:18:16', '2026-07-20 05:18:16', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_pricing=full-service', 2, 'skl_pricing', '', 0),
(97, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'Next.js', '', 'publish', 'closed', 'closed', '', 'next-js', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=next-js', 0, 'skl_tech', '', 0),
(98, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'React', '', 'publish', 'closed', 'closed', '', 'react', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=react', 1, 'skl_tech', '', 0),
(99, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'TypeScript', '', 'publish', 'closed', 'closed', '', 'typescript', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=typescript', 2, 'skl_tech', '', 0),
(100, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'Tailwind CSS', '', 'publish', 'closed', 'closed', '', 'tailwind-css', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=tailwind-css', 3, 'skl_tech', '', 0),
(101, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'Laravel', '', 'publish', 'closed', 'closed', '', 'laravel', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=laravel', 4, 'skl_tech', '', 0),
(102, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'Node.js', '', 'publish', 'closed', 'closed', '', 'node-js', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=node-js', 5, 'skl_tech', '', 0),
(103, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'React Native', '', 'publish', 'closed', 'closed', '', 'react-native', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=react-native', 6, 'skl_tech', '', 0),
(104, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'Flutter', '', 'publish', 'closed', 'closed', '', 'flutter', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=flutter', 7, 'skl_tech', '', 0),
(105, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'PostgreSQL', '', 'publish', 'closed', 'closed', '', 'postgresql', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=postgresql', 8, 'skl_tech', '', 0),
(106, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'WordPress', '', 'publish', 'closed', 'closed', '', 'wordpress', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=wordpress', 9, 'skl_tech', '', 0),
(107, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'Google Gemini', '', 'publish', 'closed', 'closed', '', 'google-gemini', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=google-gemini', 10, 'skl_tech', '', 0),
(108, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'OpenAI', '', 'publish', 'closed', 'closed', '', 'openai', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=openai', 11, 'skl_tech', '', 0),
(109, 0, '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 'Claude', '', 'publish', 'closed', 'closed', '', 'claude', '', '', '2026-07-20 05:45:04', '2026-07-20 05:45:04', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_tech=claude', 12, 'skl_tech', '', 0),
(110, 1, '2026-07-20 06:27:41', '2026-07-20 06:27:41', '', 'Toronto, Canada', '', 'publish', 'closed', 'closed', '', 'toronto-canada', '', '', '2026-07-20 06:27:41', '2026-07-20 06:27:41', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_location=toronto-canada', 0, 'skl_location', '', 0),
(111, 1, '2026-07-20 06:27:41', '2026-07-20 06:27:41', '', 'Dhaka, Bangladesh', '', 'publish', 'closed', 'closed', '', 'dhaka-bangladesh', '', '', '2026-07-20 06:27:41', '2026-07-20 06:27:41', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_location=dhaka-bangladesh', 1, 'skl_location', '', 0),
(112, 1, '2026-07-20 06:27:41', '2026-07-20 06:27:41', '', 'Global talent', '', 'publish', 'closed', 'closed', '', 'global-talent', '', '', '2026-07-20 06:27:41', '2026-07-20 06:27:41', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_location=global-talent', 2, 'skl_location', '', 0),
(151, 1, '2025-12-20 09:00:00', '2025-12-20 09:00:00', '<p>Ten days from kickoff to a live product used by real customers. Here’s how it happened — and what we’d do the same next time.</p>\n<h2>A ruthless scope on day one</h2>\n<p>We agreed on a single outcome the product had to deliver and wrote down everything we would <em>not</em> build. That one document saved us days of drift.</p>\n<h2>One team, no handoffs</h2>\n<p>Design, development, and decisions sat together. No waiting on approvals across vendors meant we moved at the speed of one conversation.</p>\n<h2>Real feedback before polish</h2>\n<p>We put the rough version in front of users on day seven. The last three days went into the things they actually cared about — not the things we assumed they would.</p>', 'How We Built an MVP in 10 Days', 'A behind-the-scenes look at our fastest project ever. What made it possible and what we learned.', 'publish', 'open', 'open', '', 'how-we-built-an-mvp-in-10-days', '', '', '2025-12-20 09:00:00', '2025-12-20 09:00:00', '', 0, 'http://localhost/sklentr/sklentr-v2/how-we-built-an-mvp-in-10-days/', 0, 'post', '', 0),
(150, 1, '2025-12-28 09:00:00', '2025-12-28 09:00:00', '<p>Most startup SEO advice is noise. A few things actually work — and they’re less complicated than the agencies want you to believe.</p>\n<h2>Answer real questions</h2>\n<p>Write the pages your future customers are already searching for. One genuinely useful article that answers a real question beats fifty thin posts chasing keywords.</p>\n<h2>Earn a little authority</h2>\n<p>A handful of relevant, credible links does more than a hundred low-quality ones. Be worth linking to, then ask the people who’d naturally cite you.</p>\n<h2>Fix the technical basics</h2>\n<p>Fast pages, clean URLs, proper titles, and a site Google can crawl. It’s unglamorous, but it’s the foundation everything else sits on.</p>', 'SEO for Startups: A No-BS Guide', 'Forget the fluff. Here’s what actually moves the needle for startup SEO in 2026.', 'publish', 'open', 'open', '', 'seo-for-startups-a-no-bs-guide', '', '', '2025-12-28 09:00:00', '2025-12-28 09:00:00', '', 0, 'http://localhost/sklentr/sklentr-v2/seo-for-startups-a-no-bs-guide/', 0, 'post', '', 0),
(116, 1, '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 'How can you deliver an MVP in 2–4 weeks?', '', 'publish', 'closed', 'closed', '', 'how-can-you-deliver-an-mvp-in-2-4-weeks', '', '', '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_faq=how-can-you-deliver-an-mvp-in-2-4-weeks', 0, 'skl_faq', '', 0),
(117, 1, '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 'What does “Canadian management, global talent” mean for me?', '', 'publish', 'closed', 'closed', '', 'what-does-canadian-management-global-talent-mean-for-me', '', '', '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_faq=what-does-canadian-management-global-talent-mean-for-me', 1, 'skl_faq', '', 0),
(118, 1, '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 'Do I own the source code?', '', 'publish', 'closed', 'closed', '', 'do-i-own-the-source-code', '', '', '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_faq=do-i-own-the-source-code', 2, 'skl_faq', '', 0),
(119, 1, '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 'What’s included in each pricing tier — are there hidden costs?', '', 'publish', 'closed', 'closed', '', 'whats-included-in-each-pricing-tier-are-there-hidden-costs', '', '', '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_faq=whats-included-in-each-pricing-tier-are-there-hidden-costs', 3, 'skl_faq', '', 0),
(120, 1, '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 'Can you help with a Canada Startup Visa application?', '', 'publish', 'closed', 'closed', '', 'can-you-help-with-a-canada-startup-visa-application', '', '', '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_faq=can-you-help-with-a-canada-startup-visa-application', 4, 'skl_faq', '', 0),
(121, 1, '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 'What happens after launch?', '', 'publish', 'closed', 'closed', '', 'what-happens-after-launch', '', '', '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_faq=what-happens-after-launch', 5, 'skl_faq', '', 0),
(122, 1, '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 'Which technologies do you use?', '', 'publish', 'closed', 'closed', '', 'which-technologies-do-you-use', '', '', '2026-07-20 07:20:12', '2026-07-20 07:20:12', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_faq=which-technologies-do-you-use', 6, 'skl_faq', '', 0),
(123, 0, '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', '2-Week MVPs', '', 'publish', 'closed', 'closed', '', '2-week-mvps', '', '', '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_svc_perk=2-week-mvps', 0, 'skl_svc_perk', '', 0),
(124, 0, '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 'One Team, Full Service', '', 'publish', 'closed', 'closed', '', 'one-team-full-service', '', '', '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_svc_perk=one-team-full-service', 1, 'skl_svc_perk', '', 0),
(125, 0, '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 'Canadian Quality, Smart Pricing', '', 'publish', 'closed', 'closed', '', 'canadian-quality-smart-pricing', '', '', '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_svc_perk=canadian-quality-smart-pricing', 2, 'skl_svc_perk', '', 0),
(126, 0, '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 'Built to Scale', '', 'publish', 'closed', 'closed', '', 'built-to-scale', '', '', '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_svc_perk=built-to-scale', 3, 'skl_svc_perk', '', 0),
(127, 0, '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 'AI-Powered Workflow', '', 'publish', 'closed', 'closed', '', 'ai-powered-workflow', '', '', '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_svc_perk=ai-powered-workflow', 4, 'skl_svc_perk', '', 0),
(128, 0, '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 'No Flight Risk', '', 'publish', 'closed', 'closed', '', 'no-flight-risk', '', '', '2026-07-21 04:58:31', '2026-07-21 04:58:31', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_svc_perk=no-flight-risk', 5, 'skl_svc_perk', '', 0),
(129, 0, '2026-07-21 04:58:32', '2026-07-21 04:58:32', '', 'Services', '', 'publish', 'closed', 'closed', '', 'services', '', '', '2026-07-21 04:58:32', '2026-07-21 04:58:32', '', 0, 'http://localhost/sklentr/sklentr-v2/index.php/services/', 0, 'page', '', 0),
(130, 0, '2026-07-21 10:50:33', '2026-07-21 10:50:33', '', 'Startup Visa', '', 'publish', 'closed', 'closed', '', 'startup-visa', '', '', '2026-07-21 10:50:33', '2026-07-21 10:50:33', '', 0, 'http://localhost/sklentr/sklentr-v2/startup-visa/', 0, 'page', '', 0),
(131, 0, '2026-07-22 04:29:14', '2026-07-22 04:29:14', '', 'Portfolio', '', 'publish', 'closed', 'closed', '', 'portfolio', '', '', '2026-07-22 04:29:14', '2026-07-22 04:29:14', '', 0, 'http://localhost/sklentr/sklentr-v2/portfolio/', 0, 'page', '', 0),
(132, 0, '2026-07-22 07:15:08', '2026-07-22 07:15:08', '', 'Pricing', '', 'publish', 'closed', 'closed', '', 'pricing', '', '', '2026-07-22 07:15:08', '2026-07-22 07:15:08', '', 0, 'http://localhost/sklentr/sklentr-v2/pricing/', 0, 'page', '', 0),
(133, 1, '2026-07-22 08:03:31', '2026-07-22 08:03:31', '{\"version\": 3, \"isGlobalStylesUserThemeJSON\": true }', 'Custom Styles', '', 'publish', 'closed', 'closed', '', 'wp-global-styles-sklentr', '', '', '2026-07-22 08:03:31', '2026-07-22 08:03:31', '', 0, 'http://localhost/sklentr/sklentr-v2/wp-global-styles-sklentr/', 0, 'wp_global_styles', '', 0),
(134, 1, '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 'Horizon Trials', '', 'publish', 'closed', 'closed', '', 'horizon-trials', '', '', '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_portfolio=horizon-trials', 0, 'skl_portfolio', '', 0),
(135, 1, '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 'AI Farming', '', 'publish', 'closed', 'closed', '', 'ai-farming', '', '', '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_portfolio=ai-farming', 1, 'skl_portfolio', '', 0),
(136, 1, '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 'Get Takaful', '', 'publish', 'closed', 'closed', '', 'get-takaful', '', '', '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_portfolio=get-takaful', 2, 'skl_portfolio', '', 0),
(137, 1, '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 'KindredCare', '', 'publish', 'closed', 'closed', '', 'kindredcare', '', '', '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_portfolio=kindredcare', 3, 'skl_portfolio', '', 0),
(138, 1, '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 'Agile Sourcing', '', 'publish', 'closed', 'closed', '', 'agile-sourcing', '', '', '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_portfolio=agile-sourcing', 4, 'skl_portfolio', '', 0),
(139, 1, '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 'GAinData', '', 'publish', 'closed', 'closed', '', 'gaindata', '', '', '2026-07-22 10:45:15', '2026-07-22 10:45:15', '', 0, 'http://localhost/sklentr/sklentr-v2/?skl_portfolio=gaindata', 5, 'skl_portfolio', '', 0),
(141, 1, '2026-07-23 07:02:17', '2026-07-23 07:02:17', '', 'Blog', '', 'publish', 'closed', 'closed', '', 'blog', '', '', '2026-07-23 07:02:17', '2026-07-23 07:02:17', '', 0, 'http://localhost/sklentr/sklentr-v2/blog/', 0, 'page', '', 0),
(148, 1, '2026-01-10 09:00:00', '2026-01-10 09:00:00', '<p>The Canada Startup Visa rewards real, working products — not slide decks. Here’s what the technical side of a strong application actually looks like.</p>\n<h2>A working MVP, not a mockup</h2>\n<p>Designated organizations want to see something people can use. A functional MVP that demonstrates your core value is far more convincing than polished screens with no product behind them.</p>\n<h2>Documentation that proves ownership</h2>\n<p>Keep a clear record of your architecture, repositories, and the work your team has done. It shows the venture is genuinely yours and technically sound.</p>\n<h2>Scalability the reviewers can believe</h2>\n<p>You don’t need to be at scale — you need an architecture that clearly could scale. Sensible infrastructure choices signal that this is a real, fundable business.</p>', 'Startup Visa Canada: Technical Requirements Explained', 'A comprehensive guide to the technical documentation and MVP requirements for your visa application.', 'publish', 'open', 'open', '', 'startup-visa-canada-technical-requirements-explained', '', '', '2026-01-10 09:00:00', '2026-01-10 09:00:00', '', 0, 'http://localhost/sklentr/sklentr-v2/startup-visa-canada-technical-requirements-explained/', 0, 'post', '', 0),
(147, 1, '2026-01-15 09:00:00', '2026-01-15 09:00:00', '<p>Two weeks isn’t much time — which is exactly why it forces the right decisions. Here’s how we scope a build that ships fast without falling apart.</p>\n<h2>Cut to one core loop</h2>\n<p>Every product has one loop that delivers its value. Find it, build it end to end, and defer everything that isn’t on that path. Settings, edge cases, and “nice to haves” can wait.</p>\n<h2>Buy, don’t build, the boring parts</h2>\n<p>Auth, payments, email, hosting — use proven services. The two weeks belong to your unique value, not to reinventing infrastructure.</p>\n<h2>Ship to real users on day fourteen</h2>\n<p>A private launch to ten real users beats another week of polish. Their reactions decide what you build next — not your roadmap.</p>', 'The 2-Week MVP: What’s Actually Possible', 'Breaking down what you can realistically build in two weeks and how to prioritize features that matter.', 'publish', 'open', 'open', '', 'the-2-week-mvp-whats-actually-possible', '', '', '2026-01-15 09:00:00', '2026-01-15 09:00:00', '', 0, 'http://localhost/sklentr/sklentr-v2/the-2-week-mvp-whats-actually-possible/', 0, 'post', '', 0),
(146, 1, '2026-01-20 09:00:00', '2026-01-20 09:00:00', '<p>Before you invest weeks of your life and thousands of dollars into building, spend a few days proving people actually want what you’re about to make. Here’s the exact process we run with founders.</p>\n<h2>Start with the problem, not the product</h2>\n<p>A real problem is one people already spend time, money, or effort trying to solve. If your idea only works once you’ve explained why someone should care, that’s a warning sign. Talk to ten potential users and ask what they do today — not whether they’d use your app.</p>\n<h2>Run cheap experiments first</h2>\n<p>You don’t need a finished MVP to validate demand. A landing page, a short survey, or a manual “concierge” version of your service can tell you most of what you need to know in a week.</p>\n<ul><li>A landing page measures whether the promise resonates.</li><li>A waitlist measures intent, not just curiosity.</li><li>A concierge test measures whether people will actually pay.</li></ul>\n<h2>Watch what people do, not what they say</h2>\n<p>People are polite. They’ll tell you an idea is great and never come back. Behaviour is the only honest signal — sign-ups, pre-orders, repeat usage, or money on the table.</p>\n<blockquote>If it’s hard to get someone to spend five minutes on your idea today, it’ll be impossible to get them to spend five dollars tomorrow.</blockquote>\n<h2>Then build the smallest thing that proves the model</h2>\n<p>Once demand is clear, scope ruthlessly. Your first version exists to prove one core assumption — nothing more. Everything else can wait until real users ask for it.</p>', 'How to Validate Your Startup Idea Before Building', 'Before investing time and money into development, here’s how to test if your idea has real market potential.', 'publish', 'open', 'open', '', 'how-to-validate-your-startup-idea-before-building', '', '', '2026-01-20 09:00:00', '2026-01-20 09:00:00', '', 0, 'http://localhost/sklentr/sklentr-v2/how-to-validate-your-startup-idea-before-building/', 0, 'post', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sk_termmeta`
--

DROP TABLE IF EXISTS `sk_termmeta`;
CREATE TABLE IF NOT EXISTS `sk_termmeta` (
  `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `term_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_terms`
--

DROP TABLE IF EXISTS `sk_terms`;
CREATE TABLE IF NOT EXISTS `sk_terms` (
  `term_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `term_group` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `sk_terms`
--

INSERT INTO `sk_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0),
(13, 'Startup Visa', 'startup-visa', 0),
(12, 'Development', 'development', 0),
(5, 'sklentr', 'sklentr', 0),
(11, 'Strategy', 'strategy', 0),
(14, 'Mindset', 'mindset', 0),
(15, 'Marketing', 'marketing', 0),
(16, 'Case Study', 'case-study', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sk_term_relationships`
--

DROP TABLE IF EXISTS `sk_term_relationships`;
CREATE TABLE IF NOT EXISTS `sk_term_relationships` (
  `object_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `term_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `sk_term_relationships`
--

INSERT INTO `sk_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(149, 14, 0),
(151, 16, 0),
(150, 15, 0),
(133, 5, 0),
(148, 13, 0),
(147, 12, 0),
(146, 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sk_term_taxonomy`
--

DROP TABLE IF EXISTS `sk_term_taxonomy`;
CREATE TABLE IF NOT EXISTS `sk_term_taxonomy` (
  `term_taxonomy_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `term_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `count` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `sk_term_taxonomy`
--

INSERT INTO `sk_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 0),
(14, 14, 'category', '', 0, 1),
(13, 13, 'category', '', 0, 1),
(12, 12, 'category', '', 0, 1),
(5, 5, 'wp_theme', '', 0, 1),
(11, 11, 'category', '', 0, 1),
(15, 15, 'category', '', 0, 1),
(16, 16, 'category', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sk_usermeta`
--

DROP TABLE IF EXISTS `sk_usermeta`;
CREATE TABLE IF NOT EXISTS `sk_usermeta` (
  `umeta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `sk_usermeta`
--

INSERT INTO `sk_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'sklentr_admin'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'modern'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'sk_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'sk_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', ''),
(15, 1, 'show_welcome_panel', '1'),
(17, 1, 'sk_dashboard_quick_press_last_post_id', '6'),
(18, 1, 'sk_persisted_preferences', 'a:3:{s:4:\"core\";a:1:{s:26:\"isComplementaryAreaVisible\";b:1;}s:14:\"core/edit-post\";a:1:{s:12:\"welcomeGuide\";b:0;}s:9:\"_modified\";s:24:\"2026-07-22T08:03:36.770Z\";}');

-- --------------------------------------------------------

--
-- Table structure for table `sk_users`
--

DROP TABLE IF EXISTS `sk_users`;
CREATE TABLE IF NOT EXISTS `sk_users` (
  `ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `sk_users`
--

INSERT INTO `sk_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'sklentr_admin', '$wp$2y$10$aSolB.CF/l/GNUvVrRZuzuIOsD381mrC0kH7b9y99Su8..7khLwTG', 'sklentr_admin', 'rishad@sklentr.com', 'http://localhost/sklentr/sklentr-v2', '2026-07-15 11:28:59', '', 0, 'sklentr_admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
