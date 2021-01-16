<?PHP
$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_installed_update`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_installed_update` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date_exit` date NOT NULL,
  `date_install` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_blocks`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `do` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `msgbox` varchar(255) NOT NULL,
  `header` varchar(255) NOT NULL,
  `title` varchar(244) NOT NULL,
  `des` text NOT NULL,
  `meta` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_blocks` (`id`, `name`, `text`, `do`, `url`, `action`, `msgbox`, `header`, `title`, `des`, `meta`) VALUES
(1, 'menu_top', '', '/installed/menu_top.php', '', 'install', '', '', '', '', ''),
(2, 'menu_bottom', '', '/installed/menu_bottom.php', '', 'install', '', '', '', '', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_modules`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_modules` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `top_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `link` varchar(255) NOT NULL,
  `link_ajax` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `do` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `url_other` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `module_do` varchar(255) NOT NULL,
  `module_url` varchar(255) NOT NULL,
  `msgbox` varchar(255) NOT NULL,
  `header` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `title` varchar(244) NOT NULL,
  `des` text NOT NULL,
  `meta` text NOT NULL,
  `portal_top` int(5) NOT NULL,
  `portal_bottom` int(5) NOT NULL,
  `admin_left` int(5) NOT NULL,
  `pos` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_modules_admin`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_modules_admin` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` int(5) NOT NULL,
  `do` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `msgbox` varchar(255) NOT NULL,
  `header` varchar(255) NOT NULL,
  `title` varchar(244) NOT NULL,
  `des` text NOT NULL,
  `meta` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_navigationp`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_navigationp` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `pos` int(11) NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL DEFAULT '',
  `link_ajax` varchar(250) NOT NULL DEFAULT '',
  `top_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL DEFAULT '0',
  `group` text NOT NULL,
  `cat` text NOT NULL,
  `aviable` text NOT NULL,
  `not-cat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

?>