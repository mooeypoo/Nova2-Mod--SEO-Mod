--
-- Table structure for table `nova_modseo_custom_links`
--

DROP TABLE IF EXISTS `nova_modseo_custom_links`;
CREATE TABLE IF NOT EXISTS `nova_modseo_custom_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `link` text NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `nova_modseo_custom_links`
--

INSERT INTO `nova_modseo_custom_links` (`id`, `section_id`, `link`, `title`) VALUES
(1, 8, 'personnel/index', 'Personnel Roster');

-- --------------------------------------------------------

--
-- Table structure for table `nova_modseo_sections`
--

DROP TABLE IF EXISTS `nova_modseo_sections`;
CREATE TABLE IF NOT EXISTS `nova_modseo_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_title` text NOT NULL,
  `section_type` text NOT NULL,
  `section_locked` enum('y','n') NOT NULL,
  `section_model` text NOT NULL,
  `section_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `nova_modseo_sections`
--

INSERT INTO `nova_modseo_sections` (`id`, `section_title`, `section_type`, `section_locked`, `section_model`, `section_description`) VALUES
(1, 'Users', 'model', 'y', 'users', ''),
(2, 'Characters', 'model', 'y', 'characters', ''),
(3, 'Mission Posts', 'model', 'y', 'posts', ''),
(4, 'Personal Logs', 'model', 'y', 'logs', ''),
(5, 'News', 'model', 'y', 'news', ''),
(7, 'Menus', 'menu_categories', 'y', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `nova_modseo_sitemaps`
--

DROP TABLE IF EXISTS `nova_modseo_sitemaps`;
CREATE TABLE IF NOT EXISTS `nova_modseo_sitemaps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` enum('index','sitemap') NOT NULL,
  `map_parent` int(11) DEFAULT NULL,
  `user_created` enum('y','n') NOT NULL,
  `active` enum('y','n') NOT NULL,
  `sections` text,
  `created_date` int(11) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `nova_modseo_sitemaps`
--

INSERT INTO `nova_modseo_sitemaps` (`id`, `name`, `type`, `map_parent`, `user_created`, `active`, `sections`, `created_date`, `created_user`) VALUES
(2, 'Main Map', 'index', 0, 'y', 'y', NULL, NULL, NULL),
(3, 'Authors', 'sitemap', 2, 'y', 'y', '1,2', NULL, NULL),
(4, 'Static Pages', 'sitemap', 2, 'y', 'y', '9', NULL, NULL);

--
-- Dumping data for table `nova_settings`
--

INSERT INTO `nova_settings` (`setting_key`, `setting_value`, `setting_label`, `setting_user_created`) VALUES ("seo_meta_desc", NULL, "Anodyne Productions' premier online RPG management software", "y"), ("seo_meta_tags", NULL, "nova, rpg management, anodyne, rpg, sms", "y");

