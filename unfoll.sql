SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



CREATE TABLE IF NOT EXISTS `unfoll` (
  `id` int(11) NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `name` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `screen_name` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_url` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `protected` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `followers_count` int(20) DEFAULT NULL,
  `friends_count` int(12) DEFAULT NULL,
  `listed_count` int(6) DEFAULT NULL,
  `created_at` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favourites_count` int(10) DEFAULT NULL,
  `time_zone` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statuses_count` int(11) DEFAULT NULL,
  `lang` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_status` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_translator` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_background_color` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image_url` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_background_image_url` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_use_background_image` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_profile` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_profile_image` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Follonwer` float DEFAULT NULL COMMENT 'followers/friends',
  `status_created_at` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` int(10) DEFAULT NULL,
  `links` int(10) DEFAULT NULL,
  `rts` int(10) DEFAULT NULL,
  `mentions` int(10) DEFAULT NULL,
  `jtweets` int(10) DEFAULT NULL,
  `followed` int(11) DEFAULT NULL,
  `wlist` int(11) DEFAULT '0',
  `updated` int(11) DEFAULT NULL,
  `followme` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `unfoll`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);
 


ALTER TABLE `unfoll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
