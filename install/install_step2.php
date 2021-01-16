<?php
@ini_set ('memory_limit',"365M");
@set_time_limit (0);
@ini_set ('max_execution_time',0);
@ini_set ('3048M');
@ini_set ('output_buffering','off');
@ob_end_clean ();
clearstatcache ();
ob_implicit_flush (TRUE);
error_reporting (1);
define('DATALIFEENGINE',true);
extract($_REQUEST,EXTR_SKIP);

@ini_set('display_errors', true);
@ini_set('html_errors', false);

define('DATALIFEENGINE', true);
define('ROOT_DIR', '..');
define('ENGINE_DIR', ROOT_DIR.'/engine');

$config['charset'] = "windows-1251";

require_once(ENGINE_DIR.'/data/config.php');
require_once(ENGINE_DIR.'/classes/mysql.php');
require_once(ENGINE_DIR.'/data/dbconfig.php');
require_once(ENGINE_DIR.'/inc/include/functions.inc.php');

$distr_charset = "windows-1251";
$db_charset = "cp1251";

header("Content-type: text/html; charset=".$distr_charset);

$skin_header = <<<HTML
<!doctype html>
<html>
<head>
  <meta charset="{$distr_charset}">
  <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <title>Web2Work - Установка</title>
  <link href="/engine/skins/stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
  <script type="text/javascript" src="/engine/skins/javascripts/application.js"></script> 
  <script type="text/javascript" src="//vk.com/js/api/openapi.js?151"></script>
</head>
<body>
<script language="javascript" type="text/javascript">
<!--
var dle_act_lang   = ["Да", "Нет", "Ввод", "Отмена", "Загрузка изображений и файлов на сервер"];
var cal_language   = {en:{months:['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],dayOfWeek:["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]}};
//-->
</script>
<nav style="max-width:1220px;width:100%;margin:0 auto;" class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
  <div class="navbar-header">
        <a class="navbar-brand" href="{$PHP_SELF}"><img src="/engine/skins/images/logo.png"></a>
  </div>
  <div style="float:right;margin-top:15px;" class="navbar-header">
  <b>Подпишись:</b> 
  <a rel="nofollow" href="https://vkontakte.ru/club13001075" target="_blank"><img src="/engine/skins/images/vkontakte.png" alt="Web2Work Group в Vkontakte"></a>  <a rel="nofollow" target="_blank" href="https://twitter.com/#!/web2work/web2work-group"><img src="/engine/skins/images/twitter.png" alt="Web2Work Group в Twitter"></a> <a href="https://google.com/+Web2workRus" rel="publisher" target="_blank"><img src="/engine/skins/images/gplus.png" alt="Web2Work Group в Google+"></a> <a href="https://www.facebook.com/pages/Web2Work-Group/121157691285563" rel="nofollow" target="_blank"><img src="/engine/skins/images/facebook.png" alt="Web2Work Group в Facebook"></a>  <a target="_blank" href="https://www.youtube.com/channel/UCs1yzsO9earP5yOXiMLGclw"><img style="width:32px;height:24px;" alt="youtube web2work" src="/engine/skins/images/yotubeaoui.jpg"></a>
</div>
<div style="clear:both;"></div>
</nav>
<div class="container">
  <div class="col-md-8 col-md-offset-2">
    <div class="padded">
	    <div style="margin-top: 10px;">
<!--MAIN area-->
HTML;


$skin_footer = <<<HTML
	 <!--MAIN area-->
    </div>
  </div>
</div>
</div>

</body>
</html>
HTML;

extract($_REQUEST, EXTR_SKIP);

$js_array = array (
    'engine/skins/default.js',
);

$config['auth_metod'] = "0";
$config['comments_ajax'] = "0";
$config['create_catalog'] = "0";
$config['mobile_news'] = "10";
$config['reg_question'] = "0";
$config['search_number'] = "10";
$config['news_navigation'] = "1";
$config['mail_additional'] = "";
$config['smtp_mail'] = "";
$config['seo_control'] = "0";
$config['news_restricted'] = "0";
$config['comments_restricted'] = "0";
$config['smtp_helo'] = "HELO";
$config['news_future'] = "0";
$config['cache_type'] = "0";
$config['memcache_server'] = "localhost:11211";
$config['reg_multi_ip'] = "1";
$config['top_number'] = "10";
$config['tags_number'] = "40";
$config['mail_title'] = "";
$config['o_seite'] = "0";
$config['online_status'] = "1";
$config['avatar_size'] = "100";
$config['allow_comments_cache'] = "1";

$config['strana_osn_name'] = $_REQUEST[strana_osn_name];
$config['oblast_osn_name'] = $_REQUEST[oblast_osn_name];
$config['city_osn_name'] = $_REQUEST[city_osn_name];
$config['option_city_type'] = $_REQUEST[option_city_type];
$config['valutasite'] = $_REQUEST[valutasite];
$config['valutasitez'] = $_REQUEST[valutasitez];
$config['strana_osn_name'] = $_REQUEST[strana_osn_name];
$config['strana_osn_name'] = $_REQUEST[strana_osn_name];

if ($_REQUEST[sitekey]!='') $config['sitekeyr'] = md5($_REQUEST[sitekey]);

if ( $config['allow_admin_wysiwyg'] == "yes" ) $config['allow_admin_wysiwyg'] = "1"; else $config['allow_admin_wysiwyg'] = "0";
if ( $config['allow_static_wysiwyg'] == "yes" ) $config['allow_static_wysiwyg'] = "1"; else $config['allow_static_wysiwyg'] = "0";
if ( $config['allow_site_wysiwyg'] == "yes" ) $config['allow_site_wysiwyg'] = "1"; else $config['allow_site_wysiwyg'] = "0";
if ( $config['allow_comments_wysiwyg'] == "yes" ) $config['allow_comments_wysiwyg'] = "1"; else $config['allow_comments_wysiwyg'] = "0";

$files_type = $config['files_type'];
$max_file_size = $config['max_file_size'];
$files_max_speed = $config['files_max_speed'];

unset($config['files_type']);
unset($config['max_file_size']);
unset($config['files_max_speed']);

$handler = fopen(ENGINE_DIR.'/data/config.php', "w") or die("Извините, но невозможно записать информацию в файл <b>.engine/data/config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($handler, "<?PHP \n\n//System Configurations\n\n\$config = array (\n\n");
foreach($config as $name => $value)
{
    fwrite($handler, "'{$name}' => \"{$value}\",\n\n");
}
fwrite($handler, ");\n\n?>");
fclose($handler);

if (!file_exists( ENGINE_DIR."/cache/system/blocks.php" ))
{
    if ($_REQUEST['z1']=='')
    {
        @copy(ROOT_DIR."/install/not-connected/blocks.php", ROOT_DIR."/engine/cache/system/blocks.php");
        @copy(ROOT_DIR."/install/not-connected/modules.php", ROOT_DIR."/engine/cache/system/modules.php");
        @copy(ROOT_DIR."/install/not-connected/modules_admin.php", ROOT_DIR."/engine/cache/system/modules_admin.php");
        @copy(ROOT_DIR."/install/not-connected/navigationmenu.php", ROOT_DIR."/engine/cache/system/navigationmenu.php");
        @copy(ROOT_DIR."/install/not-connected/navigationmenu_sub.php", ROOT_DIR."/engine/cache/system/navigationmenu_sub.php");
        @copy(ROOT_DIR."/install/not-connected/navigationlist.php", ROOT_DIR."/engine/cache/system/navigationlist.php");
        @chmod(ENGINE_DIR."/cache/system/blocks.php", 0444 );
        @chmod(ENGINE_DIR."/cache/system/modules.php", 0444 );
        @chmod(ENGINE_DIR."/cache/system/modules_admin.php", 0444 );
        @chmod(ENGINE_DIR."/cache/system/navigationmenu.php", 0444 );
        @chmod(ENGINE_DIR."/cache/system/navigationmenu_sub.php", 0444 );
        @chmod(ENGINE_DIR."/cache/system/navigationlist.php", 0444 );
    }
    else
    {
        file_put_contents (ENGINE_DIR."/cache/system/blocks.php", convert_unicode($_REQUEST['z1']));
        @chmod(ENGINE_DIR."/cache/system/blocks.php", 0444 );

        function mb_unserialize($serial_str) {
            $out = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
            return unserialize($out);
        }

        $rr2 = convert_unicode($_REQUEST['z2']);
        $auctionDetails2 = mb_unserialize( $rr2 );
        set_vars ( "modules", $auctionDetails2 );
//file_put_contents (ENGINE_DIR."/cache/system/modules.php", convert_unicode($_REQUEST['z2']), LOCK_EX);
//@chmod(ENGINE_DIR."/cache/system/modules.php", 0444 );

        file_put_contents (ENGINE_DIR."/cache/system/modules_admin.php", convert_unicode($_REQUEST['z3']), LOCK_EX);
        @chmod(ENGINE_DIR."/cache/system/modules_admin.php", 0444 );

        file_put_contents (ENGINE_DIR."/cache/system/navigationmenu.php", convert_unicode($_REQUEST['z4']), LOCK_EX);
        @chmod(ENGINE_DIR."/cache/system/navigationmenu.php", 0444 );
    }
}

$tableSchema = array();

$tableSchema[] = "DROP TABLE IF EXISTS `calendar_event`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `calendar_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `detail` text NOT NULL,
  `event_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `event_recur` tinyint(1) NOT NULL DEFAULT '0',
  `queue_flag` tinyint(4) NOT NULL DEFAULT '0',
  `club` varchar(255) NOT NULL DEFAULT '',
  `dj_name` text NOT NULL,
  `style_music` text NOT NULL,
  `field0` text NOT NULL,
  `user` varchar(255) NOT NULL DEFAULT '',
  `user_club` varchar(255) NOT NULL DEFAULT '',
  `approve` varchar(255) NOT NULL DEFAULT '',
  `gold` varchar(255) NOT NULL DEFAULT '',
  `rate` int(11) DEFAULT '0',
  `price` varchar(255) NOT NULL DEFAULT '',
  `zhanr` varchar(255) NOT NULL,
  `rezh` varchar(255) NOT NULL,
  `vrolax` varchar(255) NOT NULL,
  `zhan` varchar(255) NOT NULL,
  `zhan_c` varchar(255) NOT NULL,
  `birthdate` varchar(254) NOT NULL,
  `city` varchar(254) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `sms`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `sms` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT 'Fed',
  `category` varchar(10) DEFAULT NULL,
  `date` int(15) DEFAULT NULL,
  `sms` text NOT NULL,
  `vote` varchar(4) NOT NULL DEFAULT '',
  `votes` char(1) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `sms` (`id`, `name`, `category`, `date`, `sms`, `vote`, `votes`) VALUES
(2, 'Fed', 'love', 1205170845, 'Sms-ку я такую для начала напишу, А при встрече зацелую и в объятьях задушу!', '1', '0'),
(3, 'Fed', 'funny', 1205170916, 'Дарю тебе собачку Прошу её не бить Она тебя научит Как девочек любить', '4', '1'),
(4, 'Fed', 'poshli', 1205170934, 'Придешь ко мне во сне - я испугаюсь, а днем придешь - я закричу. Да ладно... Я шучу, я издеваюсь- ведь знаешь ты - я так тебя люблю!\r\n', '5', '1'),
(5, 'Fed', 'pidkol', 1205170956, 'Ты не хочешь быть игрушкой ни в каких руках. Чуждой воле быть послушной в планах и делах. Но играть в игрушки любишь… Может, и мною поиграешь?', '4.33', '3'),
(6, 'Fed', '', 1205170972, 'Дорогой, чтобы смягчило бы мою грусть по тебе? Может быть знание, что и ты по мне скучаешь? Надеюсь, тебе не жалко будет 0,07$ и ты мне напишешь СМС!!!!', '4', '1'),
(7, 'Fed', 'funny', 1205170990, 'Я должна тебе в чём-то признаться, я больше не могу это от тебя скрывать, я не хочу тебе причинять боль, но ты должен знать, что я соскучилась по тебе!!!', '5.00', '1'),
(8, 'Fed', 'love', 1205171008, 'Ты веришь в любовь с первого взгляда? Или мне надо еще раз пройти мимо тебя?', '0', '0'),
(9, 'Fed', 'love', 1205171024, 'Я хочу, чтобы ты был моим плюшевым мишкой, которого я могла бы брать с собой в постель каждую ночь.', '0', '0'),
(10, 'Fed', 'love', 1205171037, 'Мне не нужно ни солнца, ни туч.. лишь бы ты была в этом мире..Хочешь, я подарю тебе ключ ...', '0', '0'),
(11, 'Fed', 'love', 1205171055, 'Какого цвета твои глаза? Может голубые как небо, может глубокие как моря? А может они видят меня?', '3', '1'),
(12, 'Fed', 'love', 1205171071, 'Жаль, что ты далеко Мне без тебя так нелегко. Мысли летают во тьме, Но прийди же скорее ко мне!', '2.00', '1'),
(13, 'Fed', 'love', 1205171090, 'Скучают птицы по весне - им холодно зимой, а я скучаю по тебе, когда ты не со мной!!', '3.00', '1'),
(14, 'Fed', 'love', 1205171108, 'Ничего без любви не бывает. Ни в начальной, ни в зрелой поре. Ни свидания краткого в мае, Ни печальных разлук в сентябре. Ни порыва, ни робкого шага, Ни открытий, ни тайн, ничего, Даже ненависть и отвага - это тоже любви торжество..', '5.00', '3'),
(15, 'Fed', 'love', 1205171124, 'Прошлой ночью я отправила Ангела присматривать за тобой,но он вернулся сказав,что Ангел не может присматривать за Ангелом!!!', '2.00', '1'),
(16, 'Fed', 'love', 1205171136, 'Увидишь ли слова любви немой, Услышишь ли глазами голос мой?', '5', '1'),
(17, 'Fed', 'love', 1205171174, 'Сердце девушки секрет, так сказал один поэт, если даже очень любит все равно ответит НЕТ! =)', '4', '1'),
(18, 'Fed', 'love', 1205171217, 'Спи,котенок, сладко,сладко,обниму тебя за лапку! Прошепчу на ушко:\r\n - Спи,я с тобой! Скорей усни!', '5', '1'),
(19, 'Fed', 'love', 1205171235, 'Вот здесь лежит больной студент. Его судьба не умолима. Несите прочь медикамент. Болезнь любви не излечима!', '5', '1'),
(20, 'Fed', 'love', 1205171252, 'Я рада каждой встрече и каждому звонку, и каждой смс-ке и поцелую твоему...', '5.00', '1'),
(21, 'Fed', 'love', 1205171269, 'В окно заглянула луна, звезды вместе собрались, опять сижу я одна и молю-хотя бы приснись...', '5', '2'),
(2, 'Fed', 'love', 1205170845, 'Sms-ку я такую для начала напишу, А при встрече зацелую и в объятьях задушу!', '1', '0'),
(3, 'Fed', 'funny', 1205170916, 'Дарю тебе собачку Прошу её не бить Она тебя научит Как девочек любить', '4', '1'),
(4, 'Fed', 'poshli', 1205170934, 'Придешь ко мне во сне - я испугаюсь, а днем придешь - я закричу. Да ладно... Я шучу, я издеваюсь- ведь знаешь ты - я так тебя люблю!\r\n', '5', '1'),
(5, 'Fed', 'pidkol', 1205170956, 'Ты не хочешь быть игрушкой ни в каких руках. Чуждой воле быть послушной в планах и делах. Но играть в игрушки любишь… Может, и мною поиграешь?', '4.33', '3'),
(6, 'Fed', '', 1205170972, 'Дорогой, чтобы смягчило бы мою грусть по тебе? Может быть знание, что и ты по мне скучаешь? Надеюсь, тебе не жалко будет 0,07$ и ты мне напишешь СМС!!!!', '4', '1'),
(7, 'Fed', 'funny', 1205170990, 'Я должна тебе в чём-то признаться, я больше не могу это от тебя скрывать, я не хочу тебе причинять боль, но ты должен знать, что я соскучилась по тебе!!!', '0', '0'),
(8, 'Fed', 'love', 1205171008, 'Ты веришь в любовь с первого взгляда? Или мне надо еще раз пройти мимо тебя?', '0', '0'),
(9, 'Fed', 'love', 1205171024, 'Я хочу, чтобы ты был моим плюшевым мишкой, которого я могла бы брать с собой в постель каждую ночь.', '0', '0'),
(10, 'Fed', 'love', 1205171037, 'Мне не нужно ни солнца, ни туч.. лишь бы ты была в этом мире..Хочешь, я подарю тебе ключ ...', '0', '0'),
(11, 'Fed', 'love', 1205171055, 'Какого цвета твои глаза? Может голубые как небо, может глубокие как моря? А может они видят меня?', '3', '1'),
(12, 'Fed', 'love', 1205171071, 'Жаль, что ты далеко Мне без тебя так нелегко. Мысли летают во тьме, Но прийди же скорее ко мне!', '2.00', '1'),
(13, 'Fed', 'love', 1205171090, 'Скучают птицы по весне - им холодно зимой, а я скучаю по тебе, когда ты не со мной!!', '3.00', '1'),
(14, 'Fed', 'love', 1205171108, 'Ничего без любви не бывает. Ни в начальной, ни в зрелой поре. Ни свидания краткого в мае, Ни печальных разлук в сентябре. Ни порыва, ни робкого шага, Ни открытий, ни тайн, ничего, Даже ненависть и отвага - это тоже любви торжество..', '5.00', '3'),
(15, 'Fed', 'love', 1205171124, 'Прошлой ночью я отправила Ангела присматривать за тобой,но он вернулся сказав,что Ангел не может присматривать за Ангелом!!!', '2.00', '1'),
(16, 'Fed', 'love', 1205171136, 'Увидишь ли слова любви немой, Услышишь ли глазами голос мой?', '5', '1'),
(17, 'Fed', 'love', 1205171174, 'Сердце девушки секрет, так сказал один поэт, если даже очень любит все равно ответит НЕТ! =)', '4', '1'),
(18, 'Fed', 'love', 1205171217, 'Спи,котенок, сладко,сладко,обниму тебя за лапку! Прошепчу на ушко:\r\n - Спи,я с тобой! Скорей усни!', '5', '1'),
(19, 'Fed', 'love', 1205171235, 'Вот здесь лежит больной студент. Его судьба не умолима. Несите прочь медикамент. Болезнь любви не излечима!', '5', '1'),
(20, 'Fed', 'love', 1205171252, 'Я рада каждой встрече и каждому звонку, и каждой смс-ке и поцелую твоему...', '5.00', '1'),
(21, 'Fed', 'love', 1205171269, 'В окно заглянула луна, звезды вместе собрались, опять сижу я одна и молю-хотя бы приснись...', '5', '2')";

$tableSchema[] = "DROP TABLE IF EXISTS `pmd_users`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `pmd_users` (
  `firmstate` text,
  `flag` text,
  `comment` text,
  `selector` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(250) DEFAULT NULL,
  `login` text,
  `firmname` text NOT NULL,
  `business` text NOT NULL,
  `location` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `city` text,
  `address` text,
  `zip` text,
  `phone` text NOT NULL,
  `fax` text,
  `mobile` text,
  `icq` text,
  `manager` text,
  `mail` text,
  `www` text,
  `pass` text,
  `prices` int(11) DEFAULT NULL,
  `images` int(11) DEFAULT NULL,
  `ip` text,
  `date` text,
  `date_update` date NOT NULL,
  `ip_update` text,
  `date_upgrade` varchar(255) NOT NULL,
  `counter` int(11) DEFAULT NULL,
  `webcounter` int(11) DEFAULT NULL,
  `mailcounter` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  `countrating` int(11) DEFAULT NULL,
  `banner_show` int(11) DEFAULT NULL,
  `banner_click` int(11) DEFAULT NULL,
  `price_show` int(11) DEFAULT NULL,
  `reserved_1` text,
  `reserved_2` text,
  `reserved_3` text,
  `counterip` text,
  `rate` int(4) NOT NULL DEFAULT '0',
  `foto` varchar(255) NOT NULL DEFAULT '',
  `lng` double NOT NULL,
  `lat` double NOT NULL,
  `kuhna` varchar(255) NOT NULL,
  `vrema` varchar(255) NOT NULL,
  `cennik` varchar(255) NOT NULL,
  `vmestimost` varchar(255) NOT NULL,
  `raion` varchar(255) NOT NULL,
  `xfields` text NOT NULL,
  PRIMARY KEY (`selector`),
  FULLTEXT KEY `firmname` (`firmname`,`business`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_afisha_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_afisha_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_afisha_idu`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_afisha_idu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) DEFAULT NULL,
  `post` int(3) DEFAULT '1',
  `translit` varchar(255) CHARACTER SET cp1251 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_afisha_rasp`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_afisha_rasp` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `descop` text,
  `icon` varchar(255) NOT NULL DEFAULT '',
  `sub` varchar(255) NOT NULL DEFAULT '',
  `funct_1` date NOT NULL,
  `funct_2` date NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `skin_name` varchar(255) NOT NULL,
  `objaccess` varchar(255) NOT NULL,
  `access_mod` varchar(255) NOT NULL DEFAULT '',
  `access_upload` varchar(255) NOT NULL DEFAULT '',
  `access_view` varchar(255) NOT NULL DEFAULT '',
  `access_rating` varchar(255) NOT NULL DEFAULT '',
  `access_com` varchar(255) NOT NULL DEFAULT '',
  `access_delall` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_afisha_rate_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_afisha_rate_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_alert_users`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_alert_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `touser` varchar(255) NOT NULL DEFAULT '',
  `toname` varchar(255) NOT NULL DEFAULT '',
  `otuser` varchar(255) NOT NULL DEFAULT '',
  `otname` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(255) NOT NULL DEFAULT '',
  `text` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_arcade_cat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_arcade_cat` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`cid`),
  KEY `idx` (`date`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_arcade_comments`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_arcade_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` mediumint(10) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `is_register` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_arcade_counts`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_arcade_counts` (
  `id` mediumint(5) NOT NULL DEFAULT '0',
  `rating` smallint(5) NOT NULL DEFAULT '0',
  `vote_num` smallint(5) NOT NULL DEFAULT '0',
  `comm_num` smallint(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_arcade_logs`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_arcade_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(10) NOT NULL DEFAULT '0',
  `member` varchar(40) NOT NULL DEFAULT '',
  `ip` varchar(16) NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_arcade_scores`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_arcade_scores` (
  `uid` mediumint(10) NOT NULL DEFAULT '0',
  `gid` int(10) unsigned NOT NULL DEFAULT '0',
  `uname` varchar(40) NOT NULL DEFAULT '0',
  `score` int(10) unsigned NOT NULL DEFAULT '0',
  `score_date` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `inx_uid` (`uid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_auto_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_auto_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  `model` varchar(255) NOT NULL DEFAULT '',
  `marka` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_auto_rate_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_auto_rate_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_avtoportret`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_avtoportret` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(40) NOT NULL DEFAULT '',
  `user_id` varchar(40) NOT NULL DEFAULT '',
  `about_me` text NOT NULL,
  `obrazovanie` text NOT NULL,
  `schasteeto` text NOT NULL,
  `lubpesnya` text NOT NULL,
  `otkrutie` text NOT NULL,
  `romantika` text NOT NULL,
  `kachestva` text NOT NULL,
  `chtoprosit` text NOT NULL,
  `kinogeroi` text NOT NULL,
  `gorditsav` text NOT NULL,
  `cel` text NOT NULL,
  `religia` text NOT NULL,
  `zanimatsa` text NOT NULL,
  `mechtazhit` text NOT NULL,
  `pervayalubov` varchar(255) NOT NULL DEFAULT '',
  `samoeuzhasnoe` varchar(255) NOT NULL DEFAULT '',
  `ludinetaruent` varchar(255) NOT NULL DEFAULT '',
  `lubimoebludo` varchar(255) NOT NULL DEFAULT '',
  `mestovgorode` varchar(255) NOT NULL DEFAULT '',
  `zhivotnie` varchar(255) NOT NULL DEFAULT '',
  `gorodastrani` varchar(255) NOT NULL DEFAULT '',
  `odinochestvo` varchar(255) NOT NULL DEFAULT '',
  `imetdetay` varchar(255) NOT NULL DEFAULT '',
  `lubfilm` varchar(255) NOT NULL DEFAULT '',
  `poezdka` varchar(255) NOT NULL DEFAULT '',
  `zanatie` varchar(255) NOT NULL DEFAULT '',
  `bit` varchar(255) NOT NULL DEFAULT '',
  `nenravitsa` varchar(255) NOT NULL DEFAULT '',
  `dostoinstvo` varchar(255) NOT NULL DEFAULT '',
  `druzya` varchar(255) NOT NULL DEFAULT '',
  `nedostatok` varchar(255) NOT NULL DEFAULT '',
  `glavnoevrabote` varchar(255) NOT NULL DEFAULT '',
  `zaleyu` varchar(255) NOT NULL DEFAULT '',
  `kmatu` varchar(255) NOT NULL DEFAULT '',
  `deviz` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_awards`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `mid` int(11) NOT NULL DEFAULT '0',
  `alt` varchar(100) NOT NULL DEFAULT '',
  `add_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_badge`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `mid` int(11) NOT NULL DEFAULT '0',
  `alt` varchar(100) NOT NULL DEFAULT '',
  `add_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_bankomats`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_bankomats` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `opisanie` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `cena` int(15) NOT NULL,
  `id_cat` varchar(255) NOT NULL,
  `firm` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `date_add` varchar(255) NOT NULL,
  `date_edit` varchar(255) NOT NULL,
  `rate` int(15) DEFAULT '0',
  `gold_to` date NOT NULL,
  `pay` int(100) NOT NULL DEFAULT '1',
  `views` int(10) DEFAULT NULL,
  `address` text NOT NULL,
  `klovokomn` varchar(255) NOT NULL,
  `materioal` varchar(255) NOT NULL,
  `sroksdac` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `completed` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `districtId` varchar(255) NOT NULL,
  `skid` varchar(255) NOT NULL,
  `skidka` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_crediting`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_crediting` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `valuta` varchar(255) NOT NULL,
  `srok` varchar(255) NOT NULL,
  `summa` varchar(255) NOT NULL,
  `stavka` varchar(255) NOT NULL,
  `zaemshik` varchar(255) NOT NULL,
  `komissia` varchar(255) NOT NULL,
  `platesh` varchar(255) NOT NULL,
  `srok_transha` varchar(255) NOT NULL,
  `obespech` varchar(255) NOT NULL,
  `vidi_obespech` varchar(255) NOT NULL,
  `osobie_usl_ob` varchar(255) NOT NULL,
  `poruchitel` varchar(255) NOT NULL,
  `poradok` varchar(255) NOT NULL,
  `osobie_uslovia` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `stavki` varchar(255) NOT NULL,
  `snatie_procentov` varchar(255) NOT NULL,
  `vozvrat` varchar(255) NOT NULL,
  `rastorsh` varchar(255) NOT NULL,
  `popolnenie` varchar(255) NOT NULL,
  `vozrast_ot` varchar(255) NOT NULL,
  `vozrast_do` varchar(255) NOT NULL,
  `zalog` varchar(255) NOT NULL,
  `podtverzdenie_doxoda` varchar(255) NOT NULL,
  `registracia` varchar(255) NOT NULL,
  `komissia_month` varchar(254) NOT NULL,
  `rassmotrenie` varchar(255) NOT NULL,
  `pogashenie` varchar(255) NOT NULL,
  `stagraboti6` varchar(255) NOT NULL,
  `tekst_snatia` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_crediting_fl`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_crediting_fl` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `valuta` varchar(255) NOT NULL,
  `srok` int(5) NOT NULL,
  `summa` varchar(255) NOT NULL,
  `stavka` varchar(255) NOT NULL,
  `zaemshik_ot` varchar(255) DEFAULT NULL,
  `komissia` varchar(255) NOT NULL,
  `platesh` varchar(255) NOT NULL,
  `srok_transha` varchar(255) NOT NULL,
  `obespech` varchar(255) NOT NULL,
  `vidi_obespech` varchar(255) NOT NULL,
  `osobie_usl_ob` varchar(255) NOT NULL,
  `poruchitel` varchar(255) NOT NULL,
  `poradok` varchar(255) NOT NULL,
  `osobie_uslovia` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `stavki` varchar(255) NOT NULL,
  `snatie_procentov` varchar(255) NOT NULL,
  `vozvrat` varchar(255) NOT NULL,
  `rastorsh` varchar(255) NOT NULL,
  `popolnenie` varchar(255) NOT NULL,
  `zaemshik_do` varchar(255) NOT NULL,
  `kakoy_avto` varchar(255) NOT NULL,
  `novizna` varchar(255) NOT NULL,
  `stage` varchar(255) NOT NULL,
  `lgot_period` varchar(255) NOT NULL,
  `pogashenie` varchar(255) NOT NULL,
  `rassmotrenie` varchar(255) NOT NULL,
  `podtverzdenie_doxoda` varchar(255) NOT NULL,
  `zalog` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_dopuslugi`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_dopuslugi` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `otrkitie` varchar(255) NOT NULL,
  `zakritie` varchar(255) NOT NULL,
  `vedenie` varchar(255) NOT NULL,
  `plateshi` varchar(255) NOT NULL,
  `vneshnie_plateshi_bumaga` varchar(255) NOT NULL,
  `vneshnie_plateshi_el` varchar(255) NOT NULL,
  `vnutr_plateshi_bumaga` varchar(255) NOT NULL,
  `vnutr_plateshi_el` varchar(255) NOT NULL,
  `ibank_podkl` varchar(255) NOT NULL,
  `ibank_vedenie` varchar(255) NOT NULL,
  `cbank_podkl` varchar(255) NOT NULL,
  `cbank_vedenie` varchar(255) NOT NULL,
  `poradok` varchar(255) NOT NULL,
  `osobie_uslovia` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `stavki` varchar(255) NOT NULL,
  `snatie_procentov` varchar(255) NOT NULL,
  `vozvrat` varchar(255) NOT NULL,
  `rastorsh` varchar(255) NOT NULL,
  `popolnenie` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_import_date`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_import_date` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `euro` varchar(255) NOT NULL,
  `dollar` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_import_dated`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_import_dated` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `euro` varchar(255) NOT NULL,
  `dollar` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL,
  `r` varchar(255) NOT NULL,
  `r1` varchar(255) NOT NULL,
  `r2` varchar(255) NOT NULL,
  `r3` varchar(255) NOT NULL,
  `r4` varchar(255) NOT NULL,
  `r5` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_import_datek`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_import_datek` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `euro` varchar(255) NOT NULL,
  `dollar` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_import_datem`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_import_datem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `euro` varchar(255) NOT NULL,
  `dollar` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL,
  `r` varchar(255) NOT NULL,
  `r1` varchar(255) NOT NULL,
  `r2` varchar(255) NOT NULL,
  `r3` varchar(255) NOT NULL,
  `r4` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_zayavki`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_zayavki` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `summa` varchar(255) NOT NULL,
  `valuta` varchar(255) NOT NULL,
  `doxod` varchar(255) NOT NULL,
  `info_celi` varchar(255) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `pass_seria` varchar(255) NOT NULL,
  `pass_nomer` varchar(255) NOT NULL,
  `pass_vidan` varchar(255) NOT NULL,
  `pass_data` varchar(255) NOT NULL,
  `telefon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `skolko_let` varchar(255) NOT NULL,
  `sem_pol` varchar(255) NOT NULL,
  `col_det` varchar(255) NOT NULL,
  `srokraboti` varchar(255) NOT NULL,
  `stashrab` varchar(255) NOT NULL,
  `dd` varchar(255) NOT NULL,
  `rasx` varchar(255) NOT NULL,
  `kredsum` varchar(255) NOT NULL,
  `propiska` varchar(255) NOT NULL,
  `srok_kred` varchar(255) NOT NULL,
  `obespech` varchar(255) NOT NULL,
  `trebovaniya` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_zayavki_str`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_zayavki_str` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `summa` varchar(255) NOT NULL,
  `valuta` varchar(255) NOT NULL,
  `doxod` varchar(255) NOT NULL,
  `info_celi` varchar(255) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `pass_seria` varchar(255) NOT NULL,
  `pass_nomer` varchar(255) NOT NULL,
  `pass_vidan` varchar(255) NOT NULL,
  `pass_data` varchar(255) NOT NULL,
  `telefon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `skolko_let` varchar(255) NOT NULL,
  `sem_pol` varchar(255) NOT NULL,
  `col_det` varchar(255) NOT NULL,
  `srokraboti` varchar(255) NOT NULL,
  `stashrab` varchar(255) NOT NULL,
  `dd` varchar(255) NOT NULL,
  `rasx` varchar(255) NOT NULL,
  `kredsum` varchar(255) NOT NULL,
  `propiska` varchar(255) NOT NULL,
  `srok_kred` varchar(255) NOT NULL,
  `obespech` varchar(255) NOT NULL,
  `trebovaniya` varchar(255) NOT NULL,
  `stype` varchar(255) NOT NULL,
  `mark` varchar(255) NOT NULL,
  `fe_1_2` varchar(255) NOT NULL,
  `fe_1_3` varchar(255) NOT NULL,
  `fe_1_4` varchar(255) NOT NULL,
  `fe_1_5` varchar(255) NOT NULL,
  `fe_1_6` varchar(255) NOT NULL,
  `fe_1_7` varchar(255) NOT NULL,
  `fe_1_8` varchar(255) NOT NULL,
  `fe_1_9` varchar(255) NOT NULL,
  `fe_1_61` varchar(255) NOT NULL,
  `creditcar` varchar(255) NOT NULL,
  `fe_1_60` varchar(255) NOT NULL,
  `credit_bank` varchar(255) NOT NULL,
  `fe_1_10` varchar(255) NOT NULL,
  `pu0` varchar(255) NOT NULL,
  `pu1` varchar(255) NOT NULL,
  `pu2` varchar(255) NOT NULL,
  `pu3` varchar(255) NOT NULL,
  `pu4` varchar(255) NOT NULL,
  `nodrivers` varchar(255) NOT NULL,
  `drivers1age` varchar(255) NOT NULL,
  `drivers1stage` varchar(255) NOT NULL,
  `drivers2age` varchar(255) NOT NULL,
  `drivers2stage` varchar(255) NOT NULL,
  `drivers3age` varchar(255) NOT NULL,
  `drivers3stage` varchar(255) NOT NULL,
  `drivers4age` varchar(255) NOT NULL,
  `drivers4stage` varchar(255) NOT NULL,
  `drivers5age` varchar(255) NOT NULL,
  `drivers5stage` varchar(255) NOT NULL,
  `drivers6age` varchar(255) NOT NULL,
  `drivers6stage` varchar(255) NOT NULL,
  `drivers7age` varchar(255) NOT NULL,
  `drivers7stage` varchar(255) NOT NULL,
  `drivers8age` varchar(255) NOT NULL,
  `drivers8stage` varchar(255) NOT NULL,
  `drivers9age` varchar(255) NOT NULL,
  `drivers9stage` varchar(255) NOT NULL,
  `drivers10age` varchar(255) NOT NULL,
  `drivers10stage` varchar(255) NOT NULL,
  `drivers11age` varchar(255) NOT NULL,
  `drivers11stage` varchar(255) NOT NULL,
  `drivers12age` varchar(255) NOT NULL,
  `drivers12stage` varchar(255) NOT NULL,
  `drivers13age` varchar(255) NOT NULL,
  `drivers13stage` varchar(255) NOT NULL,
  `drivers14age` varchar(255) NOT NULL,
  `drivers14stage` varchar(255) NOT NULL,
  `drivers15age` varchar(255) NOT NULL,
  `drivers15stage` varchar(255) NOT NULL,
  `drivers16age` varchar(255) NOT NULL,
  `drivers16stage` varchar(255) NOT NULL,
  `drivers17age` varchar(255) NOT NULL,
  `drivers17stage` varchar(255) NOT NULL,
  `drivers18age` varchar(255) NOT NULL,
  `drivers18stage` varchar(255) NOT NULL,
  `drivers19age` varchar(255) NOT NULL,
  `drivers19stage` varchar(255) NOT NULL,
  `drivers20age` varchar(255) NOT NULL,
  `drivers20stage` varchar(255) NOT NULL,
  `drivers21age` varchar(255) NOT NULL,
  `drivers21stage` varchar(255) NOT NULL,
  `drivers22age` varchar(255) NOT NULL,
  `drivers22stage` varchar(255) NOT NULL,
  `drivers23age` varchar(255) NOT NULL,
  `drivers23stage` varchar(255) NOT NULL,
  `drivers24age` varchar(255) NOT NULL,
  `drivers24stage` varchar(255) NOT NULL,
  `drivers25age` varchar(255) NOT NULL,
  `drivers25stage` varchar(255) NOT NULL,
  `drivers26age` varchar(255) NOT NULL,
  `drivers26stage` varchar(255) NOT NULL,
  `drivers27age` varchar(255) NOT NULL,
  `drivers27stage` varchar(255) NOT NULL,
  `drivers28age` varchar(255) NOT NULL,
  `drivers28stage` varchar(255) NOT NULL,
  `drivers29age` varchar(255) NOT NULL,
  `drivers29stage` varchar(255) NOT NULL,
  `drivers30age` varchar(255) NOT NULL,
  `drivers30stage` varchar(255) NOT NULL,
  `night` varchar(255) NOT NULL,
  `add` varchar(255) NOT NULL,
  `osago` varchar(255) NOT NULL,
  `fio3` varchar(255) NOT NULL,
  `phone3` varchar(255) NOT NULL,
  `email3` varchar(255) NOT NULL,
  `pass_series3` varchar(255) NOT NULL,
  `pass_by3` varchar(255) NOT NULL,
  `sel_day_pass_date3` varchar(255) NOT NULL,
  `sel_month_pass_date3` varchar(255) NOT NULL,
  `sel_year_pass_date3` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `othercity` varchar(255) NOT NULL,
  `object3` varchar(255) NOT NULL,
  `sdi` varchar(255) NOT NULL,
  `pokr3` varchar(255) NOT NULL,
  `3s1` varchar(255) NOT NULL,
  `3s2` varchar(255) NOT NULL,
  `3s3` varchar(255) NOT NULL,
  `3s4` varchar(255) NOT NULL,
  `3flat1` varchar(255) NOT NULL,
  `3flat2` varchar(255) NOT NULL,
  `3flat3` varchar(255) NOT NULL,
  `3flat4` varchar(255) NOT NULL,
  `3g10` varchar(255) NOT NULL,
  `3g11` varchar(255) NOT NULL,
  `3g12` varchar(255) NOT NULL,
  `3g20` varchar(255) NOT NULL,
  `3g21` varchar(255) NOT NULL,
  `3g30` varchar(255) NOT NULL,
  `3g31` varchar(255) NOT NULL,
  `3g32` varchar(255) NOT NULL,
  `3g33` varchar(255) NOT NULL,
  `3g34` varchar(255) NOT NULL,
  `3g35` varchar(255) NOT NULL,
  `3g36` varchar(255) NOT NULL,
  `3g40` varchar(255) NOT NULL,
  `3g41` varchar(255) NOT NULL,
  `3g42` varchar(255) NOT NULL,
  `3g43` varchar(255) NOT NULL,
  `3g44` varchar(255) NOT NULL,
  `speriod3` varchar(255) NOT NULL,
  `add3` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `flat` varchar(255) NOT NULL,
  `pokr` varchar(255) NOT NULL,
  `s1` varchar(255) NOT NULL,
  `s2` varchar(255) NOT NULL,
  `s3` varchar(255) NOT NULL,
  `s4` varchar(255) NOT NULL,
  `g10` varchar(255) NOT NULL,
  `g11` varchar(255) NOT NULL,
  `g12` varchar(255) NOT NULL,
  `g20` varchar(255) NOT NULL,
  `g21` varchar(255) NOT NULL,
  `g30` varchar(255) NOT NULL,
  `g31` varchar(255) NOT NULL,
  `g32` varchar(255) NOT NULL,
  `g33` varchar(255) NOT NULL,
  `g34` varchar(255) NOT NULL,
  `g35` varchar(255) NOT NULL,
  `g36` varchar(255) NOT NULL,
  `g40` varchar(255) NOT NULL,
  `g41` varchar(255) NOT NULL,
  `g42` varchar(255) NOT NULL,
  `g43` varchar(255) NOT NULL,
  `g44` varchar(255) NOT NULL,
  `speriod` varchar(255) NOT NULL,
  `add2` varchar(255) NOT NULL,
  `elsemodel` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `case_type` varchar(255) NOT NULL,
  `distance` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `hp` varchar(255) NOT NULL,
  `adds` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$row = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_usergroups" );
if ($row['count']==0)
{
    $tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (1, 'Администраторы', 'all', 1, 'all', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1550, 350, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, '{THEME}/images/icon_1.gif', 0, 1, 1, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,1,'<b><span style=\"color:red\">','</span></b>',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 0, 2)";
    $tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (2, 'Главные редакторы', 'all', 1, 'all', 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1550, 350, 1, 1, 1, 0, 2, 1, 1, 1, 1, 1, 0, '{THEME}/images/icon_2.gif', 0, 1, 0, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 1, 2)";
    $tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (3, 'Журналисты', 'all', 1, 'all', 1, 1, 1, 1, 0, 0, 1, 0, 1, 1, 1550, 350, 1, 1, 1, 0, 3, 0, 1, 1, 1, 1, 0, '{THEME}/images/icon_3.gif', 0, 1, 0, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 1, 2)";
    $tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (4, 'Посетители', 'all', 1, 'all', 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 1550, 350, 1, 1, 1, 0, 4, 0, 1, 1, 1, 1, 0, '{THEME}/images/icon_4.gif', 0, 1, 0, 1, 0, 1, 1, 1, 0,500,1000,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,0,'all', 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 1, 2)";
    $tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (5, 'Гости', 'all', 0, 'all', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 5, 0, 1, 1, 1, 0, 1, '{THEME}/images/icon_5.gif', 0, 1, 0, 0, 0, 0, 1, 1, 0,1,1,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0,'','',0,0,'all', 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '', 0, 0, 0, 2)";
}

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banners_uploads`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banners_uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_alt_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_calendar_event`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_calendar_event` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `event_id` varchar(255) NOT NULL DEFAULT '0',
  `user_id` varchar(30) NOT NULL DEFAULT '',
  `date` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_cat_downloads`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_cat_downloads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `posi` int(10) NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL DEFAULT '',
  `dir` varchar(40) NOT NULL DEFAULT '',
  `descr` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `status_down` varchar(255) NOT NULL DEFAULT '',
  `parentid` varchar(255) NOT NULL DEFAULT '',
  `news_number` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `posi` (`posi`),
  KEY `member` (`name`),
  KEY `ip` (`dir`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_category1`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_category1` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) NOT NULL DEFAULT '0',
  `posi` smallint(5) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL DEFAULT '',
  `alt_name` varchar(50) NOT NULL DEFAULT '',
  `icon` varchar(200) NOT NULL DEFAULT '',
  `skin` varchar(50) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `news_sort` varchar(10) NOT NULL DEFAULT '',
  `news_msort` varchar(4) NOT NULL DEFAULT '',
  `news_number` smallint(5) NOT NULL DEFAULT '0',
  `short_tpl` varchar(40) NOT NULL DEFAULT '',
  `full_tpl` varchar(40) NOT NULL DEFAULT '',
  `setlinks` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_category2`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_category2` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) NOT NULL DEFAULT '0',
  `posi` smallint(5) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL DEFAULT '',
  `alt_name` varchar(50) NOT NULL DEFAULT '',
  `icon` varchar(200) NOT NULL DEFAULT '',
  `skin` varchar(50) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `news_sort` varchar(10) NOT NULL DEFAULT '',
  `news_msort` varchar(4) NOT NULL DEFAULT '',
  `news_number` smallint(5) NOT NULL DEFAULT '0',
  `short_tpl` varchar(40) NOT NULL DEFAULT '',
  `full_tpl` varchar(40) NOT NULL DEFAULT '',
  `setlinks` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_category3`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_category3` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) NOT NULL DEFAULT '0',
  `posi` smallint(5) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL DEFAULT '',
  `alt_name` varchar(50) NOT NULL DEFAULT '',
  `icon` varchar(200) NOT NULL DEFAULT '',
  `skin` varchar(50) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `news_sort` varchar(10) NOT NULL DEFAULT '',
  `news_msort` varchar(4) NOT NULL DEFAULT '',
  `news_number` smallint(5) NOT NULL DEFAULT '0',
  `short_tpl` varchar(40) NOT NULL DEFAULT '',
  `full_tpl` varchar(40) NOT NULL DEFAULT '',
  `setlinks` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_comments`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(20) NOT NULL DEFAULT '',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `is_register` tinyint(1) NOT NULL DEFAULT '0',
  `approve` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_images`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `images` text NOT NULL,
  `news_id` int(10) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_photo`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `user` tinytext NOT NULL,
  `user_id` tinytext NOT NULL,
  `rate` tinytext NOT NULL,
  `allow_rate` int(11) DEFAULT '0',
  `sum_comm` tinytext NOT NULL,
  `approve` tinytext NOT NULL,
  `com_admin` tinytext NOT NULL,
  `vote_sum` tinytext NOT NULL,
  `intim` int(11) DEFAULT '0',
  `image` tinytext NOT NULL,
  `reg_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_photo_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_photo_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_post`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor` varchar(40) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `short_story` text NOT NULL,
  `full_story` text NOT NULL,
  `xfields` text NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `alt_name` varchar(200) NOT NULL DEFAULT '',
  `comm_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `allow_comm` tinyint(1) NOT NULL DEFAULT '1',
  `allow_main` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `allow_rate` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `fixed` tinyint(1) NOT NULL DEFAULT '0',
  `rating` smallint(5) NOT NULL DEFAULT '0',
  `allow_br` tinyint(1) NOT NULL DEFAULT '1',
  `vote_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `news_read` smallint(6) unsigned NOT NULL DEFAULT '0',
  `votes` tinyint(1) NOT NULL DEFAULT '0',
  `access` varchar(150) NOT NULL DEFAULT '',
  `expires` date NOT NULL DEFAULT '0000-00-00',
  `flag` varchar(255) NOT NULL DEFAULT '',
  `fulltext` varchar(255) NOT NULL DEFAULT '',
  `tags` varchar(255) NOT NULL DEFAULT '',
  `symbol` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`),
  KEY `alt_name` (`alt_name`),
  KEY `category` (`category`),
  KEY `approve` (`approve`),
  KEY `allow_main` (`allow_main`),
  KEY `date` (`date`),
  FULLTEXT KEY `short_story` (`short_story`,`full_story`),
  FULLTEXT KEY `xfields` (`xfields`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_sostav`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_sostav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `club_users` mediumint(9) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `porder` mediumint(2) NOT NULL DEFAULT '0',
  `user_id` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  KEY `approve` (`approve`),
  KEY `user_id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_users`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_users` (
  `vladelec_name` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `news_num` smallint(6) NOT NULL DEFAULT '0',
  `comm_num` mediumint(8) NOT NULL DEFAULT '0',
  `user_category` smallint(5) NOT NULL DEFAULT '4',
  `lastdate` varchar(20) DEFAULT NULL,
  `reg_date` varchar(20) DEFAULT NULL,
  `banned` varchar(5) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  `foto` varchar(110) NOT NULL DEFAULT '',
  `pravila` text NOT NULL,
  `land` varchar(100) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `favorites` text NOT NULL,
  `twsfa_albumvisit` varchar(20) NOT NULL DEFAULT '',
  `twsfa_active` tinyint(1) NOT NULL DEFAULT '1',
  `twsfa_albums` smallint(5) NOT NULL DEFAULT '0',
  `twsfa_picturies` mediumint(8) NOT NULL DEFAULT '0',
  `com_all` varchar(255) NOT NULL DEFAULT '',
  `com_unread` varchar(255) NOT NULL DEFAULT '',
  `rate` smallint(5) NOT NULL DEFAULT '0',
  `rate_num` varchar(255) NOT NULL DEFAULT '1',
  `dostup` varchar(255) NOT NULL DEFAULT '',
  `user_otr1` varchar(255) NOT NULL,
  `user_otr2` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `fotof` varchar(255) NOT NULL,
  `col_fotof` varchar(255) NOT NULL,
  `sostav` varchar(255) NOT NULL,
  `col_sostav` varchar(255) NOT NULL,
  `commen` varchar(255) NOT NULL,
  `col_commen` varchar(255) NOT NULL,
  `blo` varchar(255) NOT NULL,
  `col_blo` varchar(255) NOT NULL,
  `zag_blo` varchar(255) NOT NULL,
  `col_zag_blo` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `col_video` varchar(255) NOT NULL,
  `nav_font` varchar(255) NOT NULL,
  `nav_font_color` varchar(255) NOT NULL,
  `profile_header_font_name` varchar(255) NOT NULL,
  `profile_header_font_color` varchar(255) NOT NULL,
  `profile_header_font_size` varchar(255) NOT NULL,
  `profile_header_font_bold` varchar(255) NOT NULL,
  `profile_header_font_italic` varchar(255) NOT NULL,
  `profile_header_font_alignment` varchar(255) NOT NULL,
  `bg` varchar(255) NOT NULL,
  `bg_color` varchar(255) NOT NULL,
  `bg_url` varchar(255) NOT NULL,
  `bg_repeat` varchar(255) NOT NULL,
  `bg_position` varchar(255) NOT NULL,
  `bg_fixed` varchar(255) NOT NULL,
  `block_header` varchar(255) NOT NULL,
  `block_header_color` varchar(255) NOT NULL,
  `block_header_font_name` varchar(255) NOT NULL,
  `block_header_font_color` varchar(255) NOT NULL,
  `block_header_font_size` varchar(255) NOT NULL,
  `block_header_font_bold` varchar(255) NOT NULL,
  `block_header_font_italic` varchar(255) NOT NULL,
  `block` varchar(255) NOT NULL,
  `block_color` varchar(255) NOT NULL,
  `block_block_style` varchar(255) NOT NULL,
  `block_block_border_width` varchar(255) NOT NULL,
  `block_border_color` varchar(255) NOT NULL,
  `block_font_name` varchar(255) NOT NULL,
  `block_font_color` varchar(255) NOT NULL,
  `block_font_size` varchar(255) NOT NULL,
  `block_font_bold` varchar(255) NOT NULL,
  `block_font_italic` varchar(255) NOT NULL,
  `link_color` varchar(255) NOT NULL,
  `link_active_color` varchar(255) NOT NULL,
  `adm` varchar(255) NOT NULL,
  `infor` varchar(255) NOT NULL,
  `stra` varchar(255) NOT NULL,
  `nav` varchar(244) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_users_friends`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_users_friends` (
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `friend_id` mediumint(9) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `porder` mediumint(2) NOT NULL DEFAULT '0',
  `users_id` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  KEY `approve` (`approve`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";



$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_demokey`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_demokey` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `ip_user` varchar(16) NOT NULL DEFAULT '',
  `quant_demo` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_deyatelnost`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_deyatelnost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT '1',
  `translit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_doska_exclusive`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_doska_exclusive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `obj_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cat` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_doska_favorite`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_doska_favorite` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `obj_id` int(4) NOT NULL,
  `user_id` int(4) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_doska_obj`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_doska_obj` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `cat_id` int(7) NOT NULL DEFAULT '0',
  `type` int(7) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `price` int(8) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `names` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `funct_1` varchar(255) NOT NULL DEFAULT '',
  `funct_2` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `t1` varchar(255) NOT NULL DEFAULT '',
  `t2` varchar(255) NOT NULL DEFAULT '',
  `t3` varchar(255) NOT NULL DEFAULT '',
  `t4` varchar(255) NOT NULL DEFAULT '',
  `t5` varchar(255) DEFAULT NULL,
  `t6` varchar(255) NOT NULL DEFAULT '',
  `t7` varchar(255) NOT NULL DEFAULT '',
  `t8` varchar(255) NOT NULL DEFAULT '',
  `t9` varchar(255) NOT NULL DEFAULT '',
  `t10` varchar(255) NOT NULL DEFAULT '',
  `t11` varchar(255) NOT NULL DEFAULT '',
  `t12` varchar(255) NOT NULL DEFAULT '',
  `t13` varchar(255) NOT NULL DEFAULT '',
  `t14` varchar(255) NOT NULL DEFAULT '',
  `t15` varchar(255) NOT NULL DEFAULT '',
  `buy` varchar(255) NOT NULL,
  `zpra` varchar(255) NOT NULL,
  `uczav` varchar(255) NOT NULL,
  `stah` varchar(255) NOT NULL,
  `predrab` varchar(255) NOT NULL,
  `znaniyaz` varchar(255) NOT NULL,
  `znankompi` varchar(255) NOT NULL,
  `biziob` varchar(255) NOT NULL,
  `dopsved` varchar(255) NOT NULL,
  `vazhnost` varchar(255) NOT NULL,
  `poil` varchar(255) NOT NULL,
  `vozrast` varchar(255) NOT NULL,
  `tiprazb` varchar(255) NOT NULL,
  `pol` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `formoplati` varchar(255) NOT NULL,
  `tiprab` varchar(255) NOT NULL,
  `graphrab` varchar(255) NOT NULL,
  `usl` varchar(255) NOT NULL,
  `treb` varchar(255) NOT NULL,
  `obaz` varchar(255) NOT NULL,
  `aboutcomp` varchar(255) NOT NULL,
  `obrazie` varchar(255) NOT NULL,
  `stag` varchar(255) NOT NULL,
  `znanyaz` varchar(255) NOT NULL,
  `znankomp` varchar(255) NOT NULL,
  `bizob` varchar(255) NOT NULL,
  `cen` varchar(255) NOT NULL,
  `cenz` varchar(255) NOT NULL,
  `cena` varchar(255) NOT NULL,
  `naz` varchar(255) NOT NULL,
  `nazc` varchar(255) NOT NULL,
  `nazv` varchar(255) NOT NULL,
  `teks` varchar(255) NOT NULL,
  `tes` varchar(255) NOT NULL,
  `ter` varchar(255) NOT NULL,
  `valuta` varchar(255) NOT NULL,
  `vata` varchar(255) NOT NULL,
  `vaa` varchar(255) NOT NULL,
  `valutas` varchar(255) NOT NULL,
  `vlta` varchar(255) NOT NULL,
  `vtsa` varchar(255) NOT NULL,
  `moder` int(5) NOT NULL,
  `full_area` varchar(255) NOT NULL,
  `klovokomn` varchar(255) NOT NULL,
  `materioal` varchar(255) NOT NULL,
  `sroksdac` varchar(255) NOT NULL,
  `kratkopis` varchar(255) NOT NULL,
  `srconec` varchar(255) NOT NULL,
  `sotr` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `otlichiya` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_doska_photo`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_doska_photo` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `id_obj` int(7) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '',
  `item` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_downloads`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor` varchar(40) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(255) NOT NULL DEFAULT '',
  `url1` varchar(255) NOT NULL DEFAULT '',
  `desc_url1` text NOT NULL,
  `url2` varchar(255) NOT NULL DEFAULT '',
  `desc_url2` text NOT NULL,
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `version` varchar(10) NOT NULL DEFAULT '',
  `platform` varchar(30) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `screenshot` varchar(250) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT '0',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `category` varchar(200) NOT NULL DEFAULT '0',
  `comm_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `allow_comm` tinyint(1) NOT NULL DEFAULT '1',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `rating` smallint(5) NOT NULL DEFAULT '0',
  `vote_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `news_read` smallint(5) unsigned NOT NULL DEFAULT '0',
  `allow_rate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`),
  KEY `category` (`category`),
  KEY `approve` (`approve`),
  KEY `date` (`date`),
  KEY `news_read` (`news_read`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_downloads_broken`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_downloads_broken` (
  `reportid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `fileid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sender` varchar(100) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`reportid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_downloads_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_downloads_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(20) NOT NULL DEFAULT '',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `is_register` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_downloads_logs`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_downloads_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `files_id` int(10) NOT NULL DEFAULT '0',
  `member` varchar(40) NOT NULL DEFAULT '',
  `ip` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`files_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_email_vip`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_email_vip` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `template` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_faqanswer`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_faqanswer` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_cat` int(4) NOT NULL DEFAULT '0',
  `question` text,
  `answer` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `askname` varchar(60) DEFAULT NULL,
  `askemail` varchar(60) DEFAULT NULL,
  `views` int(15) NOT NULL,
  `colpost` int(15) NOT NULL,
  `questname` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_cat` (`id_cat`),
  FULLTEXT KEY `question` (`question`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_files`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_files` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `news_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL DEFAULT '',
  `onserver` varchar(250) NOT NULL DEFAULT '',
  `author` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `dcount` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  `rating` int(10) NOT NULL,
  `nd` varchar(255) NOT NULL,
  `dost` varchar(255) NOT NULL,
  `rekomend` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_com_audio`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_com_audio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `images` text NOT NULL,
  `news_id` int(10) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `title` text NOT NULL,
  `t` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_com_images`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_com_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `images` text NOT NULL,
  `news_id` int(10) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `title` text NOT NULL,
  `t` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_com_video`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_com_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `images` text NOT NULL,
  `news_id` int(10) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `title` text NOT NULL,
  `t` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_fav_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_fav_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_foto`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_foto` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `tet` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `firm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_market`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_market` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `opisanie` text NOT NULL,
  `foto` text NOT NULL,
  `cena` int(15) NOT NULL,
  `id_cat` varchar(255) NOT NULL,
  `firm` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `date_add` varchar(255) NOT NULL,
  `date_edit` varchar(255) NOT NULL,
  `rate` int(15) DEFAULT '0',
  `gold_to` date NOT NULL,
  `pay` int(100) NOT NULL DEFAULT '1',
  `views` int(10) DEFAULT NULL,
  `address` text NOT NULL,
  `klovokomn` varchar(255) NOT NULL,
  `materioal` varchar(255) NOT NULL,
  `sroksdac` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `completed` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `districtId` varchar(255) NOT NULL,
  `skid` varchar(255) NOT NULL,
  `skidka` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_market_buy`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_market_buy` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_market` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `key` varchar(24) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_market_cart`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_market_cart` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_market` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_market_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_market_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  `model` varchar(255) NOT NULL,
  `marka` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_market_predl`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_market_predl` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `cat_id` int(7) NOT NULL DEFAULT '0',
  `type` int(7) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `price` int(8) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `names` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `funct_1` varchar(255) NOT NULL DEFAULT '',
  `funct_2` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `t1` varchar(255) NOT NULL DEFAULT '',
  `t2` varchar(255) NOT NULL DEFAULT '',
  `t3` varchar(255) NOT NULL DEFAULT '',
  `t4` varchar(255) NOT NULL DEFAULT '',
  `t5` varchar(255) NOT NULL DEFAULT '',
  `t6` varchar(255) NOT NULL DEFAULT '',
  `t7` varchar(255) NOT NULL DEFAULT '',
  `t8` varchar(255) NOT NULL DEFAULT '',
  `t9` varchar(255) NOT NULL DEFAULT '',
  `t10` varchar(255) NOT NULL DEFAULT '',
  `t11` varchar(255) NOT NULL DEFAULT '',
  `t12` varchar(255) NOT NULL DEFAULT '',
  `t13` varchar(255) NOT NULL DEFAULT '',
  `t14` varchar(255) NOT NULL DEFAULT '',
  `t15` varchar(255) NOT NULL DEFAULT '',
  `buy` varchar(255) NOT NULL,
  `zpra` varchar(255) NOT NULL,
  `uczav` varchar(255) NOT NULL,
  `stah` varchar(255) NOT NULL,
  `predrab` varchar(255) NOT NULL,
  `znaniyaz` varchar(255) NOT NULL,
  `znankompi` varchar(255) NOT NULL,
  `biziob` varchar(255) NOT NULL,
  `dopsved` varchar(255) NOT NULL,
  `vazhnost` varchar(255) NOT NULL,
  `poil` varchar(255) NOT NULL,
  `vozrast` varchar(255) NOT NULL,
  `tiprazb` varchar(255) NOT NULL,
  `pol` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `formoplati` varchar(255) NOT NULL,
  `tiprab` varchar(255) NOT NULL,
  `graphrab` varchar(255) NOT NULL,
  `usl` varchar(255) NOT NULL,
  `treb` varchar(255) NOT NULL,
  `obaz` varchar(255) NOT NULL,
  `aboutcomp` varchar(255) NOT NULL,
  `obrazie` varchar(255) NOT NULL,
  `stag` varchar(255) NOT NULL,
  `znanyaz` varchar(255) NOT NULL,
  `znankomp` varchar(255) NOT NULL,
  `bizob` varchar(255) NOT NULL,
  `cen` varchar(255) NOT NULL,
  `cenz` varchar(255) NOT NULL,
  `cena` varchar(255) NOT NULL,
  `naz` varchar(255) NOT NULL,
  `nazc` varchar(255) NOT NULL,
  `nazv` varchar(255) NOT NULL,
  `teks` varchar(255) NOT NULL,
  `tes` varchar(255) NOT NULL,
  `ter` varchar(255) NOT NULL,
  `valuta` varchar(255) NOT NULL,
  `vata` varchar(255) NOT NULL,
  `vaa` varchar(255) NOT NULL,
  `valutas` varchar(255) NOT NULL,
  `vlta` varchar(255) NOT NULL,
  `vtsa` varchar(255) NOT NULL,
  `moder` int(5) NOT NULL,
  `full_area` varchar(255) NOT NULL,
  `klovokomn` varchar(255) NOT NULL,
  `materioal` varchar(255) NOT NULL,
  `sroksdac` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_market_rate_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_market_rate_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_rate_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_rate_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_skid`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_skid` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `date_off` date DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `faktprice` varchar(255) NOT NULL,
  `skidka` varchar(255) NOT NULL,
  `colsale` varchar(255) NOT NULL,
  `rate` int(5) NOT NULL,
  `firm` int(5) NOT NULL,
  `rup` int(5) NOT NULL,
  `rdo` int(5) NOT NULL,
  `opisanie` text NOT NULL,
  `id_cat` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `foto` text NOT NULL,
  `type` int(5) NOT NULL,
  `view` int(5) NOT NULL,
  `garant` int(2) NOT NULL,
  `podd` int(2) NOT NULL,
  `vozvr` int(2) NOT NULL,
  `about` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_skid_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_skid_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  `model` varchar(255) NOT NULL,
  `marka` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_stavki`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_stavki` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `sum` int(100) NOT NULL,
  `auction_id` int(111) NOT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_categories`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_categories` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(100) DEFAULT NULL,
  `cat_order` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `cat_order` (`cat_order`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_config`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_email`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_email` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL DEFAULT '',
  `template` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_files`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_type` varchar(10) NOT NULL DEFAULT '',
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `topic_id` int(11) NOT NULL DEFAULT '0',
  `post_id` int(11) NOT NULL DEFAULT '0',
  `file_attach` tinyint(1) NOT NULL DEFAULT '0',
  `file_name` varchar(250) NOT NULL DEFAULT '',
  `onserver` varchar(250) NOT NULL DEFAULT '',
  `file_author` varchar(40) NOT NULL DEFAULT '',
  `file_date` int(10) NOT NULL DEFAULT '0',
  `file_size` int(11) NOT NULL DEFAULT '0',
  `dcount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_forums`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL,
  `topics` mediumint(6) NOT NULL DEFAULT '0',
  `posts` mediumint(6) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `position` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `access_read` varchar(150) NOT NULL DEFAULT '',
  `access_write` varchar(150) NOT NULL DEFAULT '',
  `access_mod` varchar(150) NOT NULL DEFAULT '',
  `access_topic` varchar(150) NOT NULL DEFAULT '',
  `access_upload` varchar(150) NOT NULL DEFAULT '',
  `access_download` varchar(150) NOT NULL DEFAULT '',
  `f_last_tid` smallint(5) NOT NULL DEFAULT '0',
  `f_last_title` varchar(70) DEFAULT NULL,
  `f_last_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `f_last_poster_name` varchar(40) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `rules_title` varchar(128) NOT NULL DEFAULT '',
  `rules` text NOT NULL,
  `icon` varchar(40) NOT NULL DEFAULT '',
  `moderators` varchar(255) NOT NULL DEFAULT '',
  `is_category` tinyint(1) NOT NULL,
  `postcount` tinyint(1) NOT NULL DEFAULT '1',
  `fixpost` tinyint(1) NOT NULL DEFAULT '0',
  `last_post_id` int(11) NOT NULL DEFAULT '0',
  `banner` text NOT NULL,
  `q_reply` tinyint(1) NOT NULL DEFAULT '1',
  `i_edit` tinyint(1) NOT NULL DEFAULT '0',
  `redirect` varchar(250) NOT NULL,
  `alt_name` varchar(50) NOT NULL,
  `main_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_moderators`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_moderators` (
  `mid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `member_name` varchar(32) NOT NULL DEFAULT '',
  `member_id` mediumint(8) NOT NULL DEFAULT '0',
  `edit_post` tinyint(1) DEFAULT NULL,
  `edit_topic` tinyint(1) DEFAULT NULL,
  `delete_post` tinyint(1) DEFAULT NULL,
  `delete_topic` tinyint(1) DEFAULT NULL,
  `open_topic` tinyint(1) NOT NULL DEFAULT '0',
  `close_topic` tinyint(1) DEFAULT NULL,
  `mass_prune` tinyint(1) DEFAULT NULL,
  `move_topic` tinyint(1) DEFAULT NULL,
  `pin_topic` tinyint(1) DEFAULT NULL,
  `unpin_topic` tinyint(1) DEFAULT NULL,
  `allow_warn` tinyint(1) DEFAULT NULL,
  `is_group` tinyint(1) DEFAULT '0',
  `group_id` smallint(3) DEFAULT NULL,
  `combining_post` tinyint(1) NOT NULL DEFAULT '0',
  `move_post` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) DEFAULT NULL,
  `read_mode` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`mid`),
  KEY `forum_id` (`forum_id`),
  KEY `group_id` (`group_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_poll_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_poll_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`topic_id`,`member`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_posts`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_posts` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_author` varchar(40) NOT NULL DEFAULT '',
  `post_text` text NOT NULL,
  `post_ip` varchar(16) NOT NULL DEFAULT '',
  `is_register` tinyint(1) NOT NULL DEFAULT '0',
  `e_mail` varchar(40) NOT NULL DEFAULT '',
  `edit_user` varchar(40) NOT NULL DEFAULT '0',
  `edit_time` int(10) NOT NULL DEFAULT '0',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `wysiwyg` tinyint(1) DEFAULT '0',
  `is_count` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_reputation_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_reputation_log` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `mid` varchar(8) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL,
  `action` char(1) NOT NULL,
  `cause` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_sessions`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_sessions` (
  `id` varchar(60) NOT NULL DEFAULT '0',
  `member_name` varchar(64) NOT NULL DEFAULT '',
  `member_id` mediumint(8) NOT NULL DEFAULT '0',
  `ip` varchar(16) NOT NULL DEFAULT '',
  `browser` varchar(200) NOT NULL DEFAULT '',
  `running_time` int(10) NOT NULL DEFAULT '0',
  `location` varchar(40) NOT NULL DEFAULT '',
  `act_index` int(10) NOT NULL DEFAULT '0',
  `act_forum` int(10) NOT NULL DEFAULT '0',
  `act_topic` int(10) NOT NULL DEFAULT '0',
  `user_group` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`),
  KEY `act_topic` (`act_topic`),
  KEY `act_forum` (`act_forum`),
  KEY `act_index` (`act_index`),
  KEY `running_time` (`running_time`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_subscription`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_subscription` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `topic_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_topics`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_topics` (
  `tid` int(10) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(70) NOT NULL DEFAULT '',
  `topic_descr` varchar(70) NOT NULL DEFAULT '',
  `post` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `author_topic` varchar(40) NOT NULL DEFAULT '',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_poster_name` varchar(40) NOT NULL DEFAULT '',
  `topic_status` int(1) NOT NULL DEFAULT '0',
  `hidden` int(1) NOT NULL DEFAULT '0',
  `fixed` int(1) NOT NULL DEFAULT '1',
  `poll_title` varchar(200) NOT NULL DEFAULT '',
  `frage` varchar(200) NOT NULL DEFAULT '',
  `poll_body` text NOT NULL,
  `poll_count` mediumint(8) NOT NULL DEFAULT '0',
  `answer` varchar(150) NOT NULL DEFAULT '',
  `multiple` tinyint(1) NOT NULL DEFAULT '0',
  `icon` varchar(20) DEFAULT '0',
  `meta_descr` varchar(200) DEFAULT '0',
  `first_post` int(11) NOT NULL DEFAULT '0',
  `last_post_id` int(11) NOT NULL DEFAULT '0',
  `alt_name` varchar(200) NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_views`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_views` (
  `topic_id` int(11) NOT NULL DEFAULT '0',
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `time` int(11) DEFAULT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_warn_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_warn_log` (
  `wid` int(11) NOT NULL AUTO_INCREMENT,
  `mid` varchar(8) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL,
  `action` char(1) NOT NULL,
  `cause` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_fotoc_foto`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_fotoc_foto` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `author` varchar(40) NOT NULL DEFAULT '',
  `conkurs_id` mediumint(8) NOT NULL DEFAULT '0',
  `img_url` text NOT NULL,
  `img_url_big` text NOT NULL,
  `img_url_min` text NOT NULL,
  `views` mediumint(10) NOT NULL DEFAULT '0',
  `comm_num` mediumint(6) NOT NULL DEFAULT '0',
  `comm` text NOT NULL,
  `rating` smallint(5) NOT NULL DEFAULT '0',
  `vote_num` smallint(5) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_fotoc_votes`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_fotoc_votes` (
  `id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `fc_id` mediumint(8) NOT NULL DEFAULT '0',
  `answer` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_gal_cat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_gal_cat` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat_title` varchar(255) NOT NULL DEFAULT '',
  `cat_desc` text,
  `cat_order` mediumint(8) NOT NULL DEFAULT '0',
  `cat_alt_name` varchar(50) NOT NULL DEFAULT '',
  `us_cat` varchar(40) NOT NULL DEFAULT '',
  `cat_status` smallint(5) NOT NULL DEFAULT '0',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `img_number` smallint(5) NOT NULL DEFAULT '0',
  `cat_view_level` varchar(200) NOT NULL DEFAULT '0',
  `cat_upload_level` varchar(200) NOT NULL DEFAULT '0',
  `cat_comment_level` varchar(200) NOT NULL DEFAULT '0',
  `cat_edit_level` varchar(200) NOT NULL DEFAULT '0',
  `cat_mod_level` varchar(200) NOT NULL DEFAULT '0',
  `news_sort` varchar(15) NOT NULL DEFAULT '',
  `news_msort` varchar(10) NOT NULL DEFAULT '',
  `allow_rating` tinyint(1) NOT NULL DEFAULT '1',
  `allow_comm` tinyint(1) NOT NULL DEFAULT '1',
  `allow_wat` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`),
  KEY `cat_order` (`cat_order`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_gal_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_gal_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `cat_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `is_register` smallint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_gal_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_gal_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pic_id` int(10) NOT NULL DEFAULT '0',
  `member` varchar(40) NOT NULL DEFAULT '',
  `ip` varchar(16) NOT NULL DEFAULT '',
  `cat_id` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_gal_pic`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_gal_pic` (
  `pic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pic_title` varchar(255) NOT NULL DEFAULT '',
  `pic_filname` varchar(50) NOT NULL DEFAULT '',
  `pic_desc` text NOT NULL,
  `pic_user_id` varchar(40) NOT NULL DEFAULT '0',
  `pic_time` int(11) unsigned NOT NULL DEFAULT '0',
  `pic_cat_id` mediumint(8) NOT NULL DEFAULT '0',
  `pic_view_count` int(11) unsigned NOT NULL DEFAULT '0',
  `comm_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rating` smallint(5) NOT NULL DEFAULT '0',
  `vote_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `approve` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pic_id`),
  KEY `pic_cat_id` (`pic_cat_id`),
  KEY `pic_user_id` (`pic_user_id`),
  KEY `pic_time` (`pic_time`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_gismeteo`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_gismeteo` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `refresh` varchar(14) DEFAULT NULL,
  `text` text,
  `step` int(11) NOT NULL DEFAULT '0',
  `caption` text NOT NULL,
  KEY `code` (`code`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_guest_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_guest_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_hochu_obs`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_hochu_obs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`,`member`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_hotels_br`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_hotels_br` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `guests` varchar(255) NOT NULL,
  `room_id` varchar(255) NOT NULL,
  `room_count` varchar(255) NOT NULL,
  `guests_count` varchar(255) NOT NULL,
  `contact_type` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `firm` varchar(255) NOT NULL,
  `market` varchar(255) NOT NULL,
  `pay_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_images`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `images` text NOT NULL,
  `news_id` int(10) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `title` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_inform`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_inform` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `user_to` varchar(255) NOT NULL DEFAULT '',
  `user_from` varchar(255) NOT NULL DEFAULT '',
  `userid_to` varchar(255) NOT NULL DEFAULT '',
  `userid_from` varchar(255) NOT NULL DEFAULT '',
  `ints` varchar(255) NOT NULL DEFAULT '',
  `text` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_informer`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_informer` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `url_name` varchar(255) NOT NULL DEFAULT '',
  `category` varchar(255) NOT NULL DEFAULT '',
  `approve` varchar(255) NOT NULL DEFAULT '',
  `inform_id` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `user_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_interests`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_interests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT '1',
  `translit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_internet_search`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_internet_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_internet_sitecache`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_internet_sitecache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `fraza` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_items`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `content` varchar(255) NOT NULL DEFAULT '',
  `price` text NOT NULL,
  `unit` enum('WMZ','WMR','WME','SMS','QIWI') NOT NULL DEFAULT 'WMR',
  `state` enum('Y','N') NOT NULL DEFAULT 'N',
  `reserved` datetime DEFAULT NULL,
  `user_id` varchar(5) NOT NULL DEFAULT '',
  `user_name` varchar(20) NOT NULL DEFAULT '',
  `status` varchar(20) NOT NULL DEFAULT '',
  `admin_view` varchar(20) NOT NULL DEFAULT '',
  `buis_script` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_lclub_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_lclub_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_logs`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) NOT NULL DEFAULT '0',
  `member` varchar(40) NOT NULL DEFAULT '',
  `ip` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_market_photo`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_market_photo` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `id_obj` int(7) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '',
  `item` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_mchat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_mchat` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `mail` varchar(100) NOT NULL DEFAULT '',
  `message` varchar(254) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(16) NOT NULL DEFAULT '',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `mgroup` tinyint(2) NOT NULL DEFAULT '0',
  `is_reg` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_menu`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(100) NOT NULL DEFAULT '',
  `link_ajax` varchar(100) NOT NULL DEFAULT '',
  `menu_link` varchar(100) NOT NULL DEFAULT '',
  `top` int(11) NOT NULL DEFAULT '0',
  `pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_menu_top`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_menu_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `pos` int(11) NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL DEFAULT '',
  `link_ajax` varchar(250) NOT NULL DEFAULT '',
  `top_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_menu_type`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_menu_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL DEFAULT '',
  `tag` varchar(250) NOT NULL DEFAULT '',
  `top_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_moto_sdp_details`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_moto_sdp_details` (
  `details` int(11) NOT NULL AUTO_INCREMENT,
  `cat` int(11) DEFAULT NULL,
  `name` text,
  `description` text,
  `action` int(11) NOT NULL DEFAULT '0',
  `fio` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL,
  `cpo` varchar(30) DEFAULT NULL,
  `view` int(11) DEFAULT '0',
  `photo` varchar(60) DEFAULT NULL,
  `ip` varchar(20) NOT NULL DEFAULT '0',
  `price_files` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `work_time` varchar(100) DEFAULT NULL,
  `phone2` varchar(100) DEFAULT NULL,
  `phone3` varchar(100) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(100) DEFAULT NULL,
  `contact_e_mail` varchar(100) DEFAULT NULL,
  `descr` text,
  `dateup` varchar(30) DEFAULT NULL,
  `content_price` text,
  `foto` varchar(255) NOT NULL DEFAULT '',
  `obz` varchar(255) NOT NULL DEFAULT '',
  `id_foto` varchar(255) NOT NULL DEFAULT '',
  `id_obzor` varchar(255) NOT NULL DEFAULT '',
  `buyf` text NOT NULL,
  PRIMARY KEY (`details`),
  UNIQUE KEY `ID` (`details`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_music_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_music_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_music_file`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_music_file` (
  `vladelec_name` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_category` smallint(5) NOT NULL DEFAULT '4',
  `lastdate` varchar(20) DEFAULT NULL,
  `reg_date` varchar(20) DEFAULT NULL,
  `banned` varchar(5) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  `favorites` text NOT NULL,
  `com_all` varchar(255) NOT NULL DEFAULT '',
  `com_unread` varchar(255) NOT NULL DEFAULT '',
  `rate` smallint(5) NOT NULL DEFAULT '0',
  `rate_num` varchar(255) NOT NULL DEFAULT '0',
  `sumvie` varchar(255) NOT NULL DEFAULT '',
  `ispolnitel` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `album_yera` varchar(255) NOT NULL,
  `track` varchar(255) NOT NULL,
  `style` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_music_rate_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_music_rate_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_music_style_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_music_style_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_navigation`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_navigation` (
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
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_online`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_online` (
  `uid` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `about` text NOT NULL,
  `ip` varchar(255) NOT NULL DEFAULT '',
  `proxy` varchar(255) NOT NULL DEFAULT '',
  `time` varchar(255) NOT NULL DEFAULT '',
  KEY `idx` (`uid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_partner`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_partner` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `site_url` varchar(255) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_image` varchar(255) NOT NULL,
  `site_description` varchar(255) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `approve` tinyint(4) NOT NULL DEFAULT '0',
  `ip` varchar(40) NOT NULL,
  `cat` varchar(244) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_payment`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) NOT NULL DEFAULT '0',
  `sessionid` varchar(32) NOT NULL DEFAULT '',
  `newsid` mediumint(8) NOT NULL DEFAULT '0',
  `catid` mediumint(8) NOT NULL DEFAULT '0',
  `state` enum('CAT','NEWS') NOT NULL DEFAULT 'NEWS',
  `wmid` varchar(50) NOT NULL DEFAULT '',
  `purse` varchar(13) DEFAULT '',
  `ip` varchar(150) NOT NULL DEFAULT '',
  `amount` varchar(255) DEFAULT '0',
  `date_payment` varchar(20) NOT NULL DEFAULT '0',
  `date_completion` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_payment_tmp`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_payment_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purse` varchar(13) DEFAULT '',
  `amount` varchar(255) DEFAULT '0',
  `newsid` mediumint(8) NOT NULL DEFAULT '0',
  `catid` mediumint(8) NOT NULL DEFAULT '0',
  `state` enum('CAT','NEWS') NOT NULL DEFAULT 'CAT',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `code` varchar(32) DEFAULT '',
  `userid` mediumint(8) NOT NULL DEFAULT '0',
  `ip` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_photo_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_photo_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_photo_profile`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_photo_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `user` tinytext NOT NULL,
  `user_id` tinytext NOT NULL,
  `rate` tinytext NOT NULL,
  `allow_rate` int(11) DEFAULT '0',
  `sum_comm` tinytext NOT NULL,
  `approve` tinytext NOT NULL,
  `com_admin` tinytext NOT NULL,
  `vote_sum` int(10) NOT NULL,
  `intim` int(11) DEFAULT '0',
  `image` tinytext NOT NULL,
  `reg_date` date NOT NULL DEFAULT '0000-00-00',
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_pm`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_pm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` double NOT NULL,
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `pm_read` varchar(15) NOT NULL DEFAULT '0',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '0',
  `sendid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`),
  KEY `pm_read` (`pm_read`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_poll`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_poll` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `frage` varchar(200) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `votes` mediumint(8) NOT NULL DEFAULT '0',
  `multiple` tinyint(1) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_poll_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_poll_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`,`member`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_post_chernoviki`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_post_chernoviki` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor` varchar(40) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `short_story` text NOT NULL,
  `full_story` text NOT NULL,
  `xfields` text NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `alt_name` varchar(200) NOT NULL DEFAULT '',
  `comm_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `allow_comm` tinyint(1) NOT NULL DEFAULT '1',
  `allow_main` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `fixed` tinyint(1) NOT NULL DEFAULT '0',
  `allow_br` tinyint(1) NOT NULL DEFAULT '1',
  `tags` varchar(255) NOT NULL DEFAULT '',
  `symbol` varchar(255) NOT NULL DEFAULT '',
  `subscription` text NOT NULL,
  `forum_post` smallint(5) NOT NULL DEFAULT '0',
  `forum_warn` smallint(5) NOT NULL DEFAULT '0',
  `forum_update` varchar(20) NOT NULL DEFAULT '',
  `forum_rank` varchar(40) NOT NULL DEFAULT '',
  `com_email` varchar(255) NOT NULL DEFAULT '',
  `com_club_email` varchar(255) NOT NULL DEFAULT '',
  `view_my_page` varchar(255) NOT NULL DEFAULT '',
  `com_my_page` varchar(255) NOT NULL DEFAULT '',
  `view_my_friend` varchar(255) NOT NULL DEFAULT '',
  `view_my_album` varchar(255) NOT NULL DEFAULT '',
  `in_var` varchar(255) NOT NULL DEFAULT '',
  `to_var` varchar(255) NOT NULL DEFAULT '',
  `my_var` varchar(255) NOT NULL DEFAULT '',
  `club_var` varchar(255) NOT NULL DEFAULT '',
  `news_tid` smallint(5) NOT NULL DEFAULT '0',
  `metatitle` varchar(254) NOT NULL,
  `allow_rate` int(5) NOT NULL,
  `vote_num` int(5) NOT NULL,
  `votes` int(5) NOT NULL,
  `flag` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`),
  KEY `alt_name` (`alt_name`),
  KEY `category` (`category`),
  KEY `approve` (`approve`),
  KEY `allow_main` (`allow_main`),
  KEY `date` (`date`),
  KEY `comm_num` (`comm_num`),
  KEY `tags` (`tags`),
  KEY `comm_num_2` (`comm_num`),
  KEY `tags_2` (`tags`),
  KEY `comm_num_3` (`comm_num`),
  KEY `tags_3` (`tags`),
  KEY `fixed` (`fixed`),
  FULLTEXT KEY `short_story` (`short_story`,`full_story`,`xfields`,`title`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_post_chernoviki_extras`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_post_chernoviki_extras` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `news_read` mediumint(8) NOT NULL DEFAULT '0',
  `allow_rate` tinyint(1) NOT NULL DEFAULT '1',
  `rating` mediumint(8) NOT NULL DEFAULT '0',
  `vote_num` mediumint(8) NOT NULL DEFAULT '0',
  `votes` tinyint(1) NOT NULL DEFAULT '0',
  `view_edit` tinyint(1) NOT NULL DEFAULT '0',
  `disable_index` tinyint(1) NOT NULL DEFAULT '0',
  `related_ids` varchar(255) NOT NULL DEFAULT '',
  `access` varchar(150) NOT NULL DEFAULT '',
  `editdate` int(11) NOT NULL DEFAULT '0',
  `editor` varchar(40) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_post_extras`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_post_extras` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `news_read` mediumint(8) NOT NULL DEFAULT '0',
  `allow_rate` tinyint(1) NOT NULL DEFAULT '1',
  `rating` mediumint(8) NOT NULL DEFAULT '0',
  `vote_num` mediumint(8) NOT NULL DEFAULT '0',
  `votes` tinyint(1) NOT NULL DEFAULT '0',
  `view_edit` tinyint(1) NOT NULL DEFAULT '0',
  `disable_index` tinyint(1) NOT NULL DEFAULT '0',
  `related_ids` varchar(255) NOT NULL DEFAULT '',
  `access` varchar(150) NOT NULL DEFAULT '',
  `editdate` int(11) NOT NULL DEFAULT '0',
  `editor` varchar(40) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rate_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rate_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rating_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rating_com` (
  `kom` text NOT NULL,
  `bal` varchar(10) NOT NULL,
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `nick` varchar(80) NOT NULL,
  `id_com` int(13) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_com`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rating_config`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rating_config` (
  `sb` varchar(10) NOT NULL,
  `dn` varchar(10) NOT NULL,
  `hits_today` int(13) NOT NULL,
  `hosts_today` int(13) NOT NULL,
  `hits_7` int(13) NOT NULL,
  `hosts_7` int(13) NOT NULL,
  `explor` int(13) NOT NULL,
  `opera` int(13) NOT NULL,
  `netsc` int(13) NOT NULL,
  `konq` int(13) NOT NULL,
  `oth_br` int(13) NOT NULL,
  `wind` int(13) NOT NULL,
  `linux` int(13) NOT NULL,
  `mac` int(13) NOT NULL,
  `oth_os` int(13) NOT NULL,
  `explor_pr` int(13) NOT NULL,
  `opera_pr` int(13) NOT NULL,
  `netsc_pr` int(13) NOT NULL,
  `konq_pr` int(13) NOT NULL,
  `oth_br_pr` int(13) NOT NULL,
  `wind_pr` int(13) NOT NULL,
  `linux_pr` int(13) NOT NULL,
  `mac_pr` int(13) NOT NULL,
  `oth_os_pr` int(13) NOT NULL,
  `gecko`  int(13) NOT NULL,
  `gecko_pr`  int(13) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rating_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rating_log` (
  `data` varchar(13) NOT NULL,
  `host` varchar(80) NOT NULL,
  `tip` text NOT NULL,
  `id` int(13) NOT NULL,
  `razresh` varchar(80) NOT NULL,
  `cvet` int(13) NOT NULL,
  `refer` text NOT NULL,
  `page` varchar(80) NOT NULL,
  `java` text NOT NULL,
  `cook` text NOT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rating_new`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rating_new` (
  `memberid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(60) DEFAULT NULL,
  `url` varchar(75) DEFAULT NULL,
  `buttonurl` varchar(75) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `description` blob,
  `password` varchar(32) DEFAULT NULL,
  `clicksin` int(11) unsigned NOT NULL,
  `clicksout` int(11) unsigned NOT NULL,
  `hitsday1` int(11) unsigned NOT NULL,
  `hitsday2` int(11) unsigned NOT NULL,
  `hitsday3` int(11) unsigned NOT NULL,
  `hitsday4` int(11) unsigned NOT NULL,
  `hitsday5` int(11) unsigned NOT NULL,
  `hitsday6` int(11) unsigned NOT NULL,
  `hitsday7` int(11) unsigned NOT NULL,
  `date` varchar(15) NOT NULL,
  `passreset` varchar(12) DEFAULT NULL,
  `passreset2` varchar(12) DEFAULT NULL,
  `rank` int(11) unsigned NOT NULL,
  `id_kat` int(11) NOT NULL,
  `un1` int(13) NOT NULL,
  `un2` int(13) NOT NULL,
  `un3` int(13) NOT NULL,
  `un4` int(13) NOT NULL,
  `un5` int(13) NOT NULL,
  `un6` int(13) NOT NULL,
  `un7` int(13) NOT NULL,
  `knopka` char(3) NOT NULL,
  `sb` int(5) NOT NULL,
  `dn` int(11) NOT NULL,
  `mail` int(5) NOT NULL,
  `open` int(11) NOT NULL,
  `all` varchar(50) NOT NULL,
  `approve` varchar(15) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  PRIMARY KEY (`memberid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rating_news`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rating_news` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `DATA` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rating_un`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rating_un` (
  `host` varchar(80) NOT NULL,
  `id` int(13) NOT NULL,
  `id_nom` int(13) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_nom`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_referer`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_referer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referer` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(20) DEFAULT NULL,
  `host` varchar(125) NOT NULL DEFAULT '',
  `hits` smallint(6) DEFAULT '0',
  `request` text NOT NULL,
  `uri` varchar(255) NOT NULL DEFAULT '',
  `position` text NOT NULL,
  `user_ip` varchar(16) NOT NULL DEFAULT '',
  `type` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rssboss_channel`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rssboss_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL DEFAULT '',
  `count` int(11) DEFAULT '0',
  `refresh` int(10) NOT NULL DEFAULT '86400' COMMENT 'sec',
  `updated` datetime DEFAULT NULL,
  `builddate` varchar(64) NOT NULL DEFAULT '',
  `owner` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `node` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(32) NOT NULL DEFAULT '',
  `value` varchar(64) NOT NULL DEFAULT '',
  `number` int(11) DEFAULT '1',
  `code` varchar(32) NOT NULL DEFAULT 'NONE',
  `category` varchar(256) DEFAULT '',
  `description` varchar(256) DEFAULT '',
  `backlink` varchar(256) DEFAULT '',
  `item_category` varchar(200) NOT NULL DEFAULT '0',
  `imgprefix` varchar(64) DEFAULT '',
  `cut` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rssboss_item`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rssboss_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(323) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT '',
  `pubDate` varchar(32) NOT NULL DEFAULT '',
  `topic_date_add` datetime DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`,`channel_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_serials`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_serials` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `serial` varchar(30) NOT NULL DEFAULT '',
  `activate` tinyint(1) NOT NULL DEFAULT '0',
  `date_creat` varchar(20) NOT NULL DEFAULT '',
  `quant_day` varchar(20) NOT NULL DEFAULT '',
  `date_activate` varchar(20) NOT NULL DEFAULT '',
  `date_up_to` varchar(20) NOT NULL DEFAULT '',
  `date_best_by` varchar(20) NOT NULL DEFAULT '',
  `activ_up_to` varchar(20) NOT NULL DEFAULT '',
  `demo` tinyint(1) NOT NULL DEFAULT '0',
  `show_demo` tinyint(1) NOT NULL DEFAULT '0',
  `user_group` int(8) NOT NULL DEFAULT '0',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_sonnik`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_sonnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `valid` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_spisok_uslug`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_spisok_uslug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usluga` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `period` varchar(255) NOT NULL DEFAULT '',
  `user_id` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `key` varchar(255) NOT NULL DEFAULT '',
  `file_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_stat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_stat` (
  `ip` varchar(16) NOT NULL DEFAULT '',
  `last` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL DEFAULT '',
  `time` varchar(20) DEFAULT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_static_alt`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_static_alt` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `descr` varchar(255) NOT NULL DEFAULT '',
  `template` text NOT NULL,
  `allow_br` tinyint(1) NOT NULL DEFAULT '0',
  `allow_template` tinyint(1) NOT NULL DEFAULT '0',
  `grouplevel` varchar(100) NOT NULL DEFAULT 'all',
  `tpl` varchar(40) NOT NULL DEFAULT '',
  `metadescr` varchar(200) NOT NULL DEFAULT '',
  `metakeys` text NOT NULL,
  `views` mediumint(8) NOT NULL DEFAULT '0',
  `template_folder` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `metatitle` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `template` (`template`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_static_alt_files`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_static_alt_files` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `static_alt_id` mediumint(8) DEFAULT '0',
  `author` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `onserver` varchar(255) NOT NULL DEFAULT '',
  `dcount` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `static_id` (`static_alt_id`),
  KEY `author` (`author`),
  KEY `onserver` (`onserver`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";



$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_subscribe_garages`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_subscribe_garages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `garage_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_subscribe_users`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_subscribe_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `userid_to` varchar(255) NOT NULL,
  `username_to` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_synonims`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_synonims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `string` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `string` (`string`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_tags_replace`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_tags_replace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` varchar(255) NOT NULL DEFAULT '',
  `repl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_tendery_zayavki`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_tendery_zayavki` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `srok` varchar(255) NOT NULL,
  `srok_per` varchar(255) NOT NULL,
  `opit` varchar(255) NOT NULL,
  `dopinfo` text NOT NULL,
  `other` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_tops`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_tops` (
  `memberid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(60) DEFAULT '0',
  `url` varchar(75) DEFAULT '0',
  `buttonurl` varchar(75) DEFAULT '0',
  `email` varchar(75) DEFAULT '0',
  `cat` int(11) NOT NULL DEFAULT '0',
  `description` blob,
  `stat` longblob NOT NULL,
  `password` varchar(32) DEFAULT '0',
  `hitstotal` int(11) unsigned NOT NULL DEFAULT '0',
  `date` varchar(15) NOT NULL DEFAULT '0',
  `rank` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`memberid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_tops_cat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_tops_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_tops_stat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_tops_stat` (
  `memberid` int(11) NOT NULL DEFAULT '0',
  `day_id` smallint(6) NOT NULL DEFAULT '1',
  `stat` blob NOT NULL,
  `hits` int(10) NOT NULL DEFAULT '0',
  `hosts` int(10) NOT NULL DEFAULT '0',
  `refer` blob NOT NULL,
  `request` blob NOT NULL,
  `time` blob NOT NULL,
  `screen` blob NOT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_tv_event`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_tv_event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  `time_start` varchar(255) NOT NULL,
  `time_end` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_tv_type`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_tv_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_albums`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_albums` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `album_title` varchar(150) NOT NULL DEFAULT '',
  `album_description` varchar(250) NOT NULL DEFAULT '',
  `album_alt_name` varchar(40) NOT NULL DEFAULT '',
  `album_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `dirrectory` varchar(100) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` mediumint(8) NOT NULL DEFAULT '0',
  `cover` int(10) NOT NULL DEFAULT '0',
  `fixed_cover` tinyint(1) NOT NULL DEFAULT '0',
  `album_permission` tinyint(1) NOT NULL DEFAULT '0',
  `album_password` varchar(32) NOT NULL DEFAULT '',
  `tags` text NOT NULL,
  `album_categories` varchar(200) NOT NULL,
  `asd` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album_alt_name` (`album_alt_name`),
  KEY `album_user_id` (`album_user_id`),
  KEY `album_permission` (`album_permission`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_comments`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(40) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `is_register` tinyint(1) NOT NULL DEFAULT '0',
  `approve` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_comments_watch`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_comments_watch` (
  `item_id` mediumint(8) NOT NULL DEFAULT '0',
  `item_id_2` mediumint(8) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  KEY `item_id_2` (`item_id_2`),
  KEY `flag` (`flag`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_flood`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_flood` (
  `f_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `id` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`f_id`),
  KEY `ip` (`ip`),
  KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_picturies`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_picturies` (
  `foto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `picture` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT '',
  `order_by` mediumint(8) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `foto_date` int(6) NOT NULL DEFAULT '999999',
  `album_id` mediumint(8) NOT NULL DEFAULT '0',
  `pic_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `approve` tinyint(1) NOT NULL DEFAULT '1',
  `allow_comms` tinyint(1) NOT NULL DEFAULT '1',
  `allow_rating` tinyint(1) NOT NULL DEFAULT '1',
  `type_upload` tinyint(1) NOT NULL DEFAULT '0',
  `permission` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL DEFAULT '',
  `comms` smallint(4) NOT NULL DEFAULT '0',
  `intim` tinyint(1) NOT NULL DEFAULT '0',
  `disallow_thumb` tinyint(1) NOT NULL DEFAULT '0',
  `fotoinfo` varchar(25) NOT NULL DEFAULT '',
  `views` smallint(6) NOT NULL DEFAULT '0',
  `rating` smallint(5) NOT NULL DEFAULT '0',
  `vote_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploaded` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`foto_id`),
  KEY `album_id` (`album_id`),
  KEY `permission` (`permission`),
  KEY `alt_name` (`alt_name`),
  KEY `pic_user_id` (`pic_user_id`),
  FULLTEXT KEY `title` (`title`,`description`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_ratelogs`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_ratelogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foto_id` int(10) NOT NULL DEFAULT '0',
  `member` varchar(40) NOT NULL DEFAULT '',
  `ip` varchar(16) NOT NULL DEFAULT '',
  `rank` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `foto_id` (`foto_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_system_logs`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_system_logs` (
  `log_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `session` int(12) NOT NULL DEFAULT '0',
  `album_id` mediumint(9) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `log_time` int(10) NOT NULL DEFAULT '0',
  `result_time` int(11) NOT NULL DEFAULT '0',
  `result` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `album_id` (`album_id`,`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_tags`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_views_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_views_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foto_id` int(10) NOT NULL DEFAULT '0',
  `album_id` mediumint(9) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL DEFAULT '',
  `ip` varchar(16) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`log_id`),
  KEY `foto_id` (`foto_id`),
  KEY `user_id` (`user_id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_ulogin`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_ulogin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ident` char(255) NOT NULL,
  `email` char(255) DEFAULT NULL,
  `seed` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_favorite`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_favorite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `http` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `new_window` int(15) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_friends`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_friends` (
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `friend_id` mediumint(9) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `fg` varchar(255) NOT NULL DEFAULT '',
  `porder` mediumint(2) NOT NULL DEFAULT '0',
  `users_id` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(15) NOT NULL DEFAULT '0',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `date_add` varchar(20) NOT NULL DEFAULT '',
  `moto_model` varchar(255) NOT NULL DEFAULT '',
  `moto_marka` varchar(255) NOT NULL DEFAULT '',
  `moto_probeg` varchar(8) NOT NULL DEFAULT '',
  `moto_year` varchar(20) NOT NULL DEFAULT '0000-00-00',
  `moto_color` varchar(15) NOT NULL DEFAULT '',
  `moto_date_pokup` varchar(20) NOT NULL DEFAULT '0000-00-00',
  `moto_data_to_sled` varchar(20) NOT NULL DEFAULT '0000-00-00',
  `moto_data_str_sled` varchar(20) NOT NULL DEFAULT '0000-00-00',
  `foto_1` varchar(255) NOT NULL DEFAULT '',
  `foto_2` varchar(255) NOT NULL DEFAULT '',
  `foto_3` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(15) DEFAULT '0',
  `power` varchar(255) NOT NULL,
  `displacement` varchar(255) NOT NULL,
  `licensePlateNumber` varchar(255) NOT NULL,
  `VIN` varchar(255) NOT NULL,
  `moderatorCommentResponse` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `drive` int(15) NOT NULL DEFAULT '0',
  `journal` int(55) NOT NULL DEFAULT '0',
  `view` int(55) NOT NULL DEFAULT '0',
  `date_edit` varchar(255) NOT NULL,
  `belongState` int(3) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  `model` varchar(255) NOT NULL DEFAULT '',
  `marka` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_comments`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(20) NOT NULL DEFAULT '',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `is_register` tinyint(1) NOT NULL DEFAULT '0',
  `approve` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_main`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_main` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `garage_id` int(15) NOT NULL,
  `sum` int(15) NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_post`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor` varchar(40) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `short_story` text NOT NULL,
  `full_story` text NOT NULL,
  `xfields` text NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `category` varchar(200) NOT NULL DEFAULT '0',
  `alt_name` varchar(200) NOT NULL DEFAULT '',
  `comm_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `allow_comm` tinyint(1) NOT NULL DEFAULT '1',
  `allow_main` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `allow_rate` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `fixed` tinyint(1) NOT NULL DEFAULT '0',
  `rating` smallint(5) NOT NULL DEFAULT '0',
  `allow_br` tinyint(1) NOT NULL DEFAULT '1',
  `vote_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `news_read` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `votes` tinyint(1) NOT NULL DEFAULT '0',
  `access` varchar(150) NOT NULL DEFAULT '',
  `symbol` varchar(3) NOT NULL DEFAULT '',
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `editdate` varchar(15) NOT NULL DEFAULT '',
  `editor` varchar(40) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `view_edit` tinyint(1) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL DEFAULT '',
  `metatitle` varchar(255) NOT NULL DEFAULT '',
  `model` varchar(255) NOT NULL,
  `marka` varchar(255) NOT NULL,
  `cena` int(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`),
  KEY `alt_name` (`alt_name`),
  KEY `category` (`category`),
  KEY `approve` (`approve`),
  KEY `allow_main` (`allow_main`),
  KEY `date` (`date`),
  KEY `symbol` (`symbol`),
  KEY `comm_num` (`comm_num`),
  KEY `tags` (`tags`),
  FULLTEXT KEY `short_story` (`tags`,`short_story`,`full_story`,`title`),
  FULLTEXT KEY `FULLTEXT` (`full_story`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_post_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_post_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) CHARACTER SET koi8r NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_rate_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_rate_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_to`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_to` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(15) NOT NULL DEFAULT '0',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `moto_model` varchar(255) NOT NULL DEFAULT '',
  `moto_marka` varchar(255) NOT NULL DEFAULT '',
  `moto_probeg` varchar(8) NOT NULL DEFAULT '',
  `moto_to_name` varchar(255) NOT NULL DEFAULT '',
  `moto_data_sled` varchar(20) NOT NULL,
  `moto_data_to` varchar(20) NOT NULL,
  `gde_to` varchar(20) NOT NULL,
  `price_to` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_voting`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_voting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sum_vote` int(15) NOT NULL,
  `garage_id` int(15) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_garage_voting_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_garage_voting_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `user_id` int(25) NOT NULL,
  `garage_id` int(25) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_nafoto`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_nafoto` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `picture_id` int(10) NOT NULL,
  `picture_name` varchar(20) NOT NULL DEFAULT '',
  `user_name` varchar(30) NOT NULL DEFAULT '',
  `user_id` tinyint(6) unsigned NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_note`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `text` text NOT NULL,
  `date` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_obrazovanie`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_obrazovanie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `gorod_id` varchar(255) NOT NULL DEFAULT '',
  `strana_id` varchar(255) NOT NULL DEFAULT '',
  `fakultet` varchar(255) NOT NULL DEFAULT '',
  `forma` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(255) NOT NULL DEFAULT '',
  `god_nach` varchar(255) NOT NULL DEFAULT '',
  `god_okon` varchar(255) NOT NULL DEFAULT '',
  `god_vipusk` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `user_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_organaizer`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_organaizer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `text` text NOT NULL,
  `important` varchar(15) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_videosessions`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_videosessions` (
  `sessionid` varchar(32) NOT NULL DEFAULT '',
  `member` varchar(32) NOT NULL DEFAULT '',
  `model` varchar(32) NOT NULL DEFAULT '',
  `sop` varchar(32) NOT NULL DEFAULT '',
  `cpm` mediumint(9) NOT NULL DEFAULT '0',
  `epercentage` smallint(6) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `duration` mediumint(9) NOT NULL DEFAULT '0',
  `paid` char(1) NOT NULL DEFAULT '',
  `soppaid` char(1) NOT NULL DEFAULT '0',
  `type` varchar(12) NOT NULL DEFAULT '',
  KEY `sessionid` (`sessionid`,`member`,`model`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_video_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_video_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_video_file`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_video_file` (
  `vladelec_name` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_category` smallint(5) NOT NULL DEFAULT '4',
  `lastdate` varchar(20) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `banned` varchar(5) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  `favorites` text NOT NULL,
  `com_all` smallint(5) NOT NULL DEFAULT '0',
  `com_unread` smallint(5) NOT NULL DEFAULT '0',
  `rate` smallint(5) NOT NULL DEFAULT '0',
  `rate_num` varchar(255) NOT NULL DEFAULT '0',
  `sumvie` varchar(255) NOT NULL DEFAULT '',
  `rutube` varchar(255) NOT NULL DEFAULT '',
  `youtube` varchar(255) NOT NULL DEFAULT '',
  `opisanie` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_video_key`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_video_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT '1',
  `translit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_video_nowdate`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_video_nowdate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(15) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_video_rate_log`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_video_rate_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(255) NOT NULL DEFAULT '0',
  `member` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `dj` varchar(255) NOT NULL DEFAULT '',
  `usid` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_video_style_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_video_style_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subj` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `user` mediumint(8) NOT NULL DEFAULT '0',
  `user_from` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(15) NOT NULL DEFAULT '',
  `pm_read` char(3) NOT NULL DEFAULT '',
  `folder` varchar(10) NOT NULL DEFAULT '',
  `reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_vippay`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_vippay` (
  `inv_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) NOT NULL,
  `method` enum('robox','webmoney') NOT NULL,
  `out_summ` float(4,2) NOT NULL,
  `day` smallint(4) NOT NULL,
  `serial` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`inv_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_vk_groups`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_vk_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `name_group` varchar(255) NOT NULL,
  `auto` int(11) NOT NULL,
  `date` date NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_vk_land_users`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_vk_land_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_city` int(11) NOT NULL,
  `name_city` varchar(255) NOT NULL,
  `groups_id` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `age_from` int(11) NOT NULL,
  `age_to` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `limit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_wmpayment`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_wmpayment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` int(11) NOT NULL DEFAULT '0',
  `state` enum('I','R','S','G','F') NOT NULL DEFAULT 'I',
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email` varchar(255) DEFAULT NULL,
  `RND` varchar(8) DEFAULT NULL,
  `LMI_SYS_INVS_NO` int(11) DEFAULT NULL,
  `LMI_SYS_TRANS_NO` int(11) DEFAULT NULL,
  `LMI_SYS_TRANS_DATE` varchar(17) DEFAULT NULL,
  `LMI_PAYER_PURSE` varchar(13) DEFAULT NULL,
  `LMI_PAYER_WM` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_zansportom`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_zansportom` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_zavedem_lastseen`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_zavedem_lastseen` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `time` datetime DEFAULT NULL,
  `about` text NOT NULL,
  KEY `idx` (`uid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

// - sql
$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_billing_history";
$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_billing_invoice";
$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_billing_refund";

$tableSchema[] = "CREATE TABLE `" . PREFIX . "_billing_history` (
								  `history_id` int(11) NOT NULL AUTO_INCREMENT,
								  `history_plugin` varchar(100) NOT NULL,
								  `history_plugin_id` int(11) NOT NULL,
								  `history_user_name` varchar(100) NOT NULL,
								  `history_plus` text NOT NULL,
								  `history_minus` text NOT NULL,
								  `history_balance` text NOT NULL,
								  `history_currency` varchar(100) NOT NULL,
								  `history_text` text NOT NULL,
								  `history_date` int(11) NOT NULL,
								  PRIMARY KEY (`history_id`)
								) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "CREATE TABLE `" . PREFIX . "_billing_invoice` (
								  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
								  `invoice_paysys` varchar(100) NOT NULL,
								  `invoice_user_name` varchar(100) NOT NULL,
								  `invoice_get` text NOT NULL,
								  `invoice_pay` text NOT NULL,
								  `invoice_date_creat` int(11) NOT NULL,
								  `invoice_date_pay` int(11) NOT NULL,
								  PRIMARY KEY (`invoice_id`)
								) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "CREATE TABLE `" . PREFIX . "_billing_refund` (
								  `refund_id` int(11) NOT NULL AUTO_INCREMENT,
								  `refund_date` int(11) NOT NULL,
								  `refund_user` varchar(100) NOT NULL,
								  `refund_summa` text NOT NULL,
								  `refund_commission` text NOT NULL,
								  `refund_requisites` text NOT NULL,
								  `refund_date_return` int(11) NOT NULL,
								  PRIMARY KEY (`refund_id`)
								) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_club_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_club_com` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `subj` varchar(255) NOT NULL DEFAULT '',
			  `text` text NOT NULL,
			  `user` mediumint(8) NOT NULL DEFAULT '0',
			  `user_from` varchar(50) NOT NULL DEFAULT '',
			  `date` varchar(15) NOT NULL DEFAULT '',
			  `pm_read` char(3) NOT NULL DEFAULT '',
			  `folder` varchar(10) NOT NULL DEFAULT '',
			  `reply` varchar(255) NOT NULL DEFAULT '',
			  PRIMARY KEY (`id`),
			  KEY `folder` (`folder`),
			  KEY `user` (`user`),
			  KEY `user_from` (`user_from`)
			) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_club_comments`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_club_comments` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `post_id` varchar(20) NOT NULL DEFAULT '',
			  `user_id` mediumint(8) NOT NULL DEFAULT '0',
			  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `autor` varchar(100) NOT NULL DEFAULT '',
			  `email` varchar(100) NOT NULL DEFAULT '',
			  `text` text NOT NULL,
			  `ip` varchar(16) NOT NULL DEFAULT '',
			  `is_register` tinyint(1) NOT NULL DEFAULT '0',
			  `approve` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `post_id` (`post_id`),
			  KEY `user_id` (`user_id`),
			  FULLTEXT KEY `text` (`text`)
			) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_club_event`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_club_event` (
			  `event_id` int(11) NOT NULL AUTO_INCREMENT,
			  `subject` text NOT NULL,
			  `detail` text NOT NULL,
			  `event_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `event_recur` tinyint(1) NOT NULL DEFAULT '0',
			  `queue_flag` tinyint(4) NOT NULL DEFAULT '0',
			  `club` varchar(255) NOT NULL DEFAULT '',
			  `dj_name` text NOT NULL,
			  `style_music` text NOT NULL,
			  `field0` text NOT NULL,
			  `user` varchar(255) NOT NULL DEFAULT '',
			  `user_club` varchar(255) NOT NULL DEFAULT '',
			  `approve` varchar(255) NOT NULL DEFAULT '',
			  `gold` varchar(255) NOT NULL DEFAULT '',
			  `rate` int(11) DEFAULT '0',
			  `price` varchar(255) NOT NULL DEFAULT '',
			  `zhanr` varchar(255) NOT NULL,
			  `rezh` varchar(255) NOT NULL,
			  `vrolax` varchar(255) NOT NULL,
			  `zhan` varchar(255) NOT NULL,
			  `zhan_c` varchar(255) NOT NULL,
			  `birthdate` varchar(254) NOT NULL,
			  `city` varchar(255) NOT NULL,
			  PRIMARY KEY (`event_id`)
			) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_club_event_com`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_club_event_com` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `subj` varchar(255) NOT NULL DEFAULT '',
			  `text` text NOT NULL,
			  `user` mediumint(8) NOT NULL DEFAULT '0',
			  `user_from` varchar(50) NOT NULL DEFAULT '',
			  `date` varchar(15) NOT NULL DEFAULT '',
			  `pm_read` char(3) NOT NULL DEFAULT '',
			  `folder` varchar(10) NOT NULL DEFAULT '',
			  `reply` varchar(255) NOT NULL DEFAULT '',
			  PRIMARY KEY (`id`),
			  KEY `folder` (`folder`),
			  KEY `user` (`user`),
			  KEY `user_from` (`user_from`)
			) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_banners_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_banners_category` (
`id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `parentid` mediumint(8) NOT NULL DEFAULT '0',
  `posi` mediumint(8) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL DEFAULT '',
  `alt_name` varchar(50) NOT NULL DEFAULT '',
  `icon` varchar(200) NOT NULL DEFAULT '',
  `skin` varchar(50) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `pagetext` text NOT NULL,
  `news_sort` varchar(10) NOT NULL DEFAULT '',
  `news_msort` varchar(4) NOT NULL DEFAULT '',
  `news_number` smallint(5) NOT NULL DEFAULT '0',
  `short_tpl` varchar(40) NOT NULL DEFAULT '',
  `full_tpl` varchar(40) NOT NULL DEFAULT '',
  `metatitle` varchar(255) NOT NULL DEFAULT '',
  `show_sub` tinyint(1) NOT NULL DEFAULT '0',
  `allow_rss` tinyint(1) NOT NULL DEFAULT '1',
  `setlinks` varchar(255) NOT NULL DEFAULT '',
  `forum_id` smallint(5) NOT NULL DEFAULT '0',
  `catmain` varchar(255) NOT NULL DEFAULT '',
  `rate` float unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_banners_category` (`id`, `parentid`, `posi`, `name`, `alt_name`, `icon`, `skin`, `descr`, `keywords`, `pagetext`, `news_sort`, `news_msort`, `news_number`, `short_tpl`, `full_tpl`, `metatitle`, `show_sub`, `allow_rss`, `setlinks`, `forum_id`, `catmain`, `rate`) VALUES
(1, 10, 1, 'Авто', 'auto', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(2, 10, 1, 'Банки', 'banki', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(3, 10, 1, 'Новости', 'news', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(4, 10, 1, 'Объявления', 'doska', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(5, 10, 1, 'Недвижимость', 'nedvigimost', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(6, 10, 1, 'Рейтинг сайтов', 'rating', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(7, 10, 1, 'Афиша', 'afisha', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(8, 10, 1, 'Главная страница', 'main', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(9, 10, 1, 'Сквозное размещение', 'all', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(10, 0, 1, 'Баннерная реклама', 'banners', '', '', '', '', '', '', '', 0, '', '', '', 0, 1, '', 0, '', 0),
(11, 0, 1, 'Публикации', 'public', '', '', '', '', '', '', '', 0, '', '', '', 0, 0, '', 0, '', 0),
(12, 11, 1, 'Редакционные публикации', 'redact', '', '', '', '', 'Новость в ленте главных новостей (до 1500 знаков, 3 фото): 8000 рублей\r\nСтатья в ленте главных новостей (до 3500 знаков, 5 фото): 12000 рублей\r\nСтатья в рубрике Новости компаний (до 3500 знаков, 5 фото): 4000 рублей\r\nВыезд журналиста: 4000 рублей\r\nНаписание статьи: 3000 рублей\r\nКорректировка новости: 2000 рублей', '', '', 0, '', '', '', 0, 0, '', 0, '', 0),
(13, 11, 1, 'Пресс-пакеты', 'press', '', '', '', '', 'Пакет новостей Эксперт+ / до 30 новостей в ленте Новости компаний: 40000 рублей', '', '', 0, '', '', '', 0, 0, '', 0, '', 0),
(14, 0, 1, 'Нестандартная реклама', 'nestandart', '', '', '', '', '', '', '', 0, '', '', '', 0, 0, '', 0, '', 0),
(15, 14, 1, 'Брендирование', 'brendirovanie', '', '', '', '', 'Брендирование - это один из самых привлекательных форматов рекламы, страницы сайта на котором находится брендирование изменяются в соответствии с фирменным стилем рекламодателя. На портале Om1.ru забрендировать можно шапку сайта и главное меню, подложку под основной контент и боковые поля, а также логотип.\r\n\r\nНаиболее эффектно брендирование выглядит совместно с Топ-растяжкой, это сочетание рекламных форматов позволяет придать страницам абсолютно естественный вид в фирменном стиле рекламодателя.', '', '', 0, '', '', '', 0, 0, '', 0, '', 0),
(16, 14, 1, 'Новостройки', 'novostroyki', '', '', '', '', 'В пакет входят все функции, которые помогут целевому покупателю остановить свой выбор именно на ваших объектах:\r\n\r\nПолная информация о застройщике: описание, контактная информация;\r\nВсе предложения застройщика;\r\nПодробное описание 3-х объектов: указание на карте, схемы планировок, цены;\r\nУчастие в подборе объектов;\r\nФото-хронология хода строительства;\r\nПубликации новостей об объектах: новых предложений, начале или окончании этапов строительства.\r\nПотенциальные покупатели получают информации о вашей компании и об объектах в одном окне – видят все предложения, расположение объектов на карте, описание объектов и цены. Такая открытость вызывает доверие и желание обратиться именно в вашу компанию за приобретением квартиры.\r\n\r\nВаши предложения участвуют в подборе объектов по запросу потенциального покупателя, что позволяет потенциальным покупателям найти ваши предложения, подробно их изучить и остановить свой выбор именно на вашем объекте.\r\n\r\nДетальная презентация объекта на портале увеличивает интерес к нему потенциальных покупателей в несколько раз.', '', '', 0, '', '', '', 0, 0, '', 0, '', 0),
(17, 18, 1, 'Наши клиенты', 'clients', '', '', '', '', 'Эффективность сотрудничества ценят крупнейшие компании регионального и федерального уровня.\r\n\r\n\r\n \r\n \r\n \r\n \r\n \r\n \r\n			', '', '', 0, '', '', '', 0, 0, '', 0, '', 0),
(18, 0, 1, 'О нас', 'aboutus', '', '', '', '', '', '', '', 0, '', '', '', 0, 0, '', 0, '', 0)";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_banners_items`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_banners_items` (
`id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `descr` varchar(255) NOT NULL DEFAULT '',
  `template` text NOT NULL,
  `allow_br` tinyint(1) NOT NULL DEFAULT '0',
  `allow_template` tinyint(1) NOT NULL DEFAULT '0',
  `grouplevel` varchar(100) NOT NULL DEFAULT 'all',
  `tpl` varchar(40) NOT NULL DEFAULT '',
  `metadescr` varchar(200) NOT NULL DEFAULT '',
  `metakeys` text NOT NULL,
  `views` mediumint(8) NOT NULL DEFAULT '0',
  `template_folder` varchar(50) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `metatitle` varchar(255) NOT NULL DEFAULT '',
  `sitemap` tinyint(1) NOT NULL DEFAULT '1',
  `allow_count` tinyint(1) NOT NULL DEFAULT '1',
  `disable_index` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `template` (`template`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_banners_items` (`id`, `name`, `descr`, `template`, `allow_br`, `allow_template`, `grouplevel`, `tpl`, `metadescr`, `metakeys`, `views`, `template_folder`, `date`, `metatitle`, `sitemap`, `allow_count`, `disable_index`) VALUES
(4, 'Топ-растяжка', '10000', '30000', 0, 0, 'all', '', '1', '100%', 0, '468x90', 1519121774, '', 0, 0, 6),
(3, 'Мид-растяжка VIP', '10000', '25000', 0, 0, 'all', '', '8', '100%', 0, '1000(1280)х150', 1519121680, '', 0, 0, 17),
(5, 'Топ-растяжка банка', '10000', '30000', 0, 0, 'all', '', '2', '100%', 0, '468x90', 1519121788, '', 0, 0, 6),
(6, 'Правый баннер', '10000', '30000', 0, 0, 'all', '', '1', '100%', 0, '240x400', 1519121807, '', 0, 0, 3),
(7, 'Правый баннер для Банка', '10000', '30000', 0, 0, 'all', '', '2', '100%', 0, '240x400', 1519121822, '', 0, 0, 3),
(8, 'Right медиа', '10000', '30000', 0, 0, 'all', '', '8', '100%', 0, '240x400', 1519121843, '', 0, 0, 3)";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_banners_items_files`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_banners_items_files` (
    `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `static_id` mediumint(8) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `onserver` varchar(255) NOT NULL DEFAULT '',
  `dcount` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `static_id` (`static_id`),
  KEY `author` (`author`),
  KEY `onserver` (`onserver`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_banners_uploads`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_banners_uploads` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_alt_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_objects_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_objects_category` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(255) CHARACTER SET utf8 NOT NULL,
  `options` text CHARACTER SET utf8 NOT NULL,
  `sort` smallint(8) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_objects_category` (`id`, `type`, `options`, `sort`) VALUES
(1, 'category', 'name=Новостройки|||alt_name=novostroyki|||template=|||icon=|||description=Все  в Твери. Телефоны, режим работы, рейтинги, отзывы пользователей. Актуальная, проверенная информация.|||opisanie=|||keywords=|||cat=0|||count_post=0', 1),
(2, 'category', 'name=Коттеджные поселки|||alt_name=kottedge|||template=|||icon=|||description=Все  в Твери. Телефоны, режим работы, рейтинги, отзывы пользователей. Актуальная, проверенная информация.|||opisanie=|||keywords=|||cat=0|||count_post=0', 1),
(3, 'currency', 'name=Руб|||symbol=руб', 1)";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_objects_comments`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_objects_comments` (
`id` mediumint(8) NOT NULL,
  `author` char(40) NOT NULL,
  `author_id` mediumint(8) NOT NULL,
  `email` char(255) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `board_id` mediumint(8) NOT NULL,
  `del` tinyint(1) NOT NULL DEFAULT '0',
  `ip` char(255) NOT NULL,
  `answer` mediumint(10) NOT NULL DEFAULT '0',
  `approve` tinyint(4) NOT NULL,
  `otz` text NOT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_objects_list`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_objects_list` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL,
  `alt_name` char(255) NOT NULL,
  `text` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `author_id` mediumint(8) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comm_num` smallint(10) NOT NULL DEFAULT '0',
  `price` int(10) NOT NULL DEFAULT '0',
  `currency` int(10) NOT NULL,
  `board_type` int(10) NOT NULL,
  `country` int(10) NOT NULL,
  `city` int(10) NOT NULL,
  `category` int(10) NOT NULL,
  `allow_comm` tinyint(1) NOT NULL DEFAULT '0',
  `xfields` text NOT NULL,
  `fio` char(255) NOT NULL,
  `phone` char(255) NOT NULL,
  `email` char(255) NOT NULL,
  `http` char(255) NOT NULL,
  `photos` text NOT NULL,
  `views` mediumint(8) NOT NULL DEFAULT '0',
  `vip_date` int(11) NOT NULL,
  `super_vip_date` int(11) NOT NULL,
  `color` char(255) NOT NULL,
  `color_date` int(11) NOT NULL,
  `no_del` tinyint(1) NOT NULL DEFAULT '1',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `rp` varchar(255) NOT NULL DEFAULT '0',
  `rm` varchar(255) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_objects_list` (`id`, `title`, `alt_name`, `text`, `author`, `author_id`, `date`, `end_date`, `comm_num`, `price`, `currency`, `board_type`, `country`, `city`, `category`, `allow_comm`, `xfields`, `fio`, `phone`, `email`, `http`, `photos`, `views`, `vip_date`, `super_vip_date`, `color`, `color_date`, `no_del`, `approve`, `rp`, `rm`) VALUES
(2672, 'ЖК «На мостовой»', 'zhk-na-mostovoy', 'Новый жилой комплекс «На Мостовой», состоящий из трех 25-этажных жилых секций и подземного паркинга расположится в Ленинском районе города Екатеринбурга. Инфраструктура комплекса будет реализована максимально удобно для своих жителей.<br /><br />В микрораоне УНЦ появится свой фитнес центр и оздоровительный комплекс. Первый этаж каждого жилого дома предназначен для помещений общественного назначения. Для удобства жильцов там разместятся продуктовый магазины, аптека, офисы, коммерческий мини садик.<br /><br />Собственный закрытый двор разделен на детские и спортивные площадки, зеленные благоустроенные зоны, цветочные клумбы, а также прогулочные зоны отдыха и велодорожки.<br /><br />Подземная парковка на 135 м/мест запроектирована на двух этажах: въезд и выезд в паркинг предусмотрен на «минус» 1 уровень, а также в уровне 1 этажа. Таким образом, двор будет полностью изолирован от автомобилей, для полной безопасности взрослых и маленьких жителей комплекса.<br /><br />Планировка квартир:<br /><br />Студии от 26,8 кв.м<br />Однокомнатные квартиры от 43,7 кв.м<br />Двухкомнатные квартиры от 52,9 кв.м<br />С 2–20 этаж — Отделка «Чистовая»:<br /><br />Стены — обои под покраску, пол — ламинат, потолки — окраска водно-дисперсионной краской в белый цвет, межкомнатные двери, металлическая сейф-дверь.<br />В сан.узле: пол — керамическая плитка, стены — покраска водоэмульсионной краской, также будут установлены унитаз, ванная и умывальник.<br /><br />С 20–25 этаж — Отделка «Под чистовую»:<br /><br />Потолок и стены подготовка под покраску и оклейку обоями, на полу цементно-песчаная стяжка, металлическая сейф-дверь.<br />Будущие жильцы смогут создавать индивидуальный дизайн квартиры в соответствии со своими предпочтениями!<br /><br />Кроме того, во всех квартирах будут установлены выключатели и розетки, а также приборы учета на воду, отопление и электричество!<br />Окна и балконные двери — двухкамерные стеклопакеты ПВХ, на лоджии — алюминиевые.<br /><br />Следует отметить, что цена за квадратный метр лоджии считается по сниженному коэффициенту — 0,5!<br /><br />Заказчик/застройщик ООО «Новая строительная компания».<br /><br />Способ оплаты Ипотека (ВТБ-24, СБЕРБАНК) , Материнский капитал, Жилищные сертификаты.<br /><br />Регистрация договор долевого участия по 214 ФЗ.<br /><br />Контактные данные отдела продаж ЖК «На мостовой»<br /><br />г. Екатеринбург, ул. Юлиуса Фучика, д. 1<br />Телефоны: (343) 213–52–22, 302–01–07<br /><br />Разрешительные документы можно посмотреть на сайте www.nsk-ural.ru или в офисе отдела продаж.', '', 0, '2016-11-23 09:09:36', '0000-00-00 00:00:00', 0, 5445, 3, 0, 0, 0, 1, 0, 'adres=Машинная 1|||zastroyschik=ООО «Новая строительная компания»|||koordinaty-lat=56.367144|||koordinaty-lng=43.814443|||kolichestvo-komnat=2|||ploschad=52|||etazh=3/12|||sayt=', '', '', '', 'http://123.ru', '1518687388_6740b2eaa3a5c5b7399e89fd9b3f153d.jpeg###2018-02', 49, 0, 0, '', 0, 1, 1, '0', '0'),
(2673, 'Район «Академический»', 'rayon-akademicheskiy', 'c12ec12ec24 gervrgtergv', '', 0, '2017-02-25 16:48:20', '0000-00-00 00:00:00', 0, 123123, 3, 0, 0, 0, 1, 1, 'adres=Екатеринбург, Восточная 51|||zastroyschik=ООО «Новая строительная компания»|||koordinaty-lat=56.818533|||koordinaty-lng=60.641600|||kolichestvo-komnat=1|||ploschad=45|||etazh=1/12|||sayt=', '', '', '', '', '1518670730_60fa18b3402741c24ee7ab9f7e36f76d.jpg###2018-02', 1, 0, 0, 'e9fbc0', 1519851134, 1, 1, '0', '0')";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_objects_ratings`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_objects_ratings` (
`id` mediumint(9) NOT NULL,
  `user` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `act` varchar(111) NOT NULL,
  `board_id` varchar(255) NOT NULL
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `web-site` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `deti` varchar(255) NOT NULL default ''";

$tableSchema[] = "INSERT INTO `".PREFIX."_users` (`email`, `password`, `name`, `user_id`, `news_num`, `comm_num`, `user_group`, `lastdate`, `reg_date`, `banned`, `allow_mail`, `info`, `signature`, `foto`, `fullname`, `land`, `country`, `city`, `icq`, `favorites`, `pm_all`, `pm_unread`, `pm_notify`, `time_limit`, `xfields`, `allowed_ip`, `hash`, `useragent`, `logged_ip`, `logged_proxy`, `forumposts`, `location`, `top_comm`, `cj`, `dj`, `style`, `yearstart`, `twsfa_albumvisit`, `twsfa_active`, `twsfa_albums`, `twsfa_picturies`, `reply`, `com_all`, `com_unread`, `rate`, `sex`, `birthdate`, `bdate_view`, `poster`, `invites_num`, `club`, `club_2`, `album`, `ishu`, `mob_phone`, `dom_phone`, `web-site`, `vkontakte`, `odnoklassniki`, `lj`, `webs`, `subscription`,  `forum_post`, `forum_warn`, `forum_update`, `forum_rank`, `com_email`, `com_club_email`, `view_my_page`, `com_my_page`, `view_my_friend`, `view_my_album`, `in_var`, `to_var`, `my_var`, `club_var`, `krediti`, `lat`, `lng`, `restricted`, `restricted_days`, `restricted_date`, `datting`, `geteroopit`, `kakseks`, `vozbuzdaet`, `orientacia`, `narkotik`, `alkogol`, `kurenie`, `zansportom`,`mater_podderzhka`, `svobodniyden`, `brak`, `deti`, `znakomlus_s`, `znakomlus_voz_s`, `znakomlus_voz_po`, `rost`, `ves`, `kogoishu`, `cel_druzba`, `cartasponsor`, `fiosponsor`, `familiya`, `otchestvo`, `fiolat`, `addressst`, `typepasp`, `seripasp`, `nomerpasp`, `datavid`, `kemviden`, `ogrn`, `vipcard`, `vipcard2`, `kodpodr`, `kodslovo`, `vipcard3`, `vipcard4`, `vipcard5`, `vipcard6`, `fiolat2`, `valuta`, `typepasprnn`, `nomcard`, `polsex`, `vzgladi`, `modkino`)
VALUES ('".$_REQUEST['regmail']."', '".$_REQUEST['reg_password']."', '".$_REQUEST['reg_name']."', 1, 2, 2, 1, '1295886619', '1295635106', '', 1, 'о мне', 'подпись', 'foto_1.png', 'Администрация', '', '', '2020', '', '', 0, 0, 1, '', '', '', '', '', '127.0.0.1', '', 0, '', 0, '', '', '', '', '', 1, 1, 5, '', '1', '1', 1, '1', '1987-04-02', '0', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '1295637778', '', '0', '0', '0', '0', '0', '0', '', '', '', '', 0, '', '', 0, 0, '', 1, '/Да, только секс', '/Несколько раз в неделю/Несколько раз в месяц', '', '', '', '', '', '', '', '', '/Да, женат, живем порознь', '', '/Девушкой', '18', '45', '175', '60', '/Секс на один-два раза', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";

$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `indexadr` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `adrray` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `ulicaadr` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `domadr` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `koradr` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `kvadr` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `regankd` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `regd` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `balans` float unsigned DEFAULT '0'";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `pred_mest` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `34n526` varchar(255) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `gold_to` date NOT NULL default '0000-00-00'";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `silver_to` date NOT NULL default '0000-00-00'";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `forum_reputation` smallint(5) NOT NULL DEFAULT '0'";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `forum_last` varchar(20) NOT NULL DEFAULT '0'";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `forum_time` varchar(20) NOT NULL DEFAULT '0'";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `forum_read` varchar(20) NOT NULL default ''";
$tableSchema[] = "ALTER TABLE  `" . PREFIX . "_users` ADD  `premium_to` VARCHAR( 15 ) NOT NULL DEFAULT '0'";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `audio_summ` int(5) NOT NULL";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `video_summ` int(5) NOT NULL";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `award_summ` int(5) NOT NULL";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `auto_summ` int(5) NOT NULL";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_users` ADD  `event_summ` int(5) NOT NULL";

$tableSchema[] = "ALTER TABLE `" . PREFIX . "_users` CHANGE `foto` `foto` VARCHAR(255) NOT NULL DEFAULT ''";

$tableSchema[] = "ALTER TABLE `" . PREFIX . "_users`
  DROP `typepasp`,
  DROP `seripasp`,
  DROP `nomerpasp`,
  DROP `datavid`,
  DROP `kemviden`,
  DROP `ogrn`,
  DROP `vipcard`,
  DROP `vipcard2`,
  DROP `kodpodr`,
  DROP `kodslovo`,
  DROP `vipcard3`,
  DROP `vipcard4`,
  DROP `vipcard5`,
  DROP `vipcard6`,
  DROP `fiolat2`,
  DROP `modkino`,
  DROP `indexadr`,
  DROP `adrray`,
  DROP `ulicaadr`,
  DROP `domadr`,
  DROP `koradr`,
  DROP `kvadr`,
  DROP `regankd`,
  DROP `regd`,
DROP `in_var`,
  DROP `to_var`,
  DROP `my_var`,
  DROP `club_var`,
  DROP `geteroopit`,
  DROP `kakseks`,
  DROP `vozbuzdaet`,
  DROP `orientacia`,
  DROP `narkotik`,
  DROP `alkogol`,
  DROP `zansportom`,
  DROP `mater_podderzhka`,
  DROP `svobodniyden`,
  DROP `brak`,
  DROP `kogoishu`,
  DROP `cel_druzba`,
  DROP `cartasponsor`,
  DROP `fiosponsor`,
  DROP `familiya`,
  DROP `deti`,
	DROP `cj`,
  DROP `dj`,DROP `club`,
  DROP `club_2`  ";

$tableSchema[] = "ALTER TABLE  `" . PREFIX . "_users` CHANGE  `land`  `land` INT( 15 ) NOT NULL ,
CHANGE  `country`  `country` INT( 15 ) NOT NULL ,
CHANGE  `city`  `city` INT( 15 ) NOT NULL ,
CHANGE  `znakomlus_s`  `znakomlus_s` CHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL ,
CHANGE  `yearstart`  `yearstart` INT( 15 ) NOT NULL ,
CHANGE  `com_all`  `com_all` INT( 15 ) NOT NULL ,
CHANGE  `com_unread`  `com_unread` INT( 15 ) NOT NULL ,
CHANGE  `sex`  `sex` INT( 3 ) NOT NULL ,
CHANGE  `mob_phone`  `mob_phone` INT( 15 ) NOT NULL ,
CHANGE  `dom_phone`  `dom_phone` INT( 15 ) NOT NULL ,
CHANGE  `forum_rank`  `forum_rank` INT( 40 ) NOT NULL ,
CHANGE  `znakomlus_voz_s`  `znakomlus_voz_s` INT( 5 ) NOT NULL ,
CHANGE  `znakomlus_voz_po`  `znakomlus_voz_po` INT( 5 ) NOT NULL ,
CHANGE  `rost`  `rost` INT( 5 ) NOT NULL ,
CHANGE  `ves`  `ves` INT( 5 ) NOT NULL ,
CHANGE  `polsex`  `polsex` INT( 5 ) NOT NULL ,
CHANGE  `website`  `website` CHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NULL DEFAULT NULL ,
CHANGE  `vkontakte`  `vkontakte` CHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT  '',
CHANGE  `odnoklassniki`  `odnoklassniki` CHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT  '',
CHANGE  `lj`  `lj` CHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT  '',
CHANGE  `webs`  `webs` CHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT  ''";

$tableSchema[] = "ALTER TABLE  `" . PREFIX . "_users` CHANGE  `dom_phone`  `dom_phone` VARCHAR( 255 ) NOT NULL";
$tableSchema[] = "ALTER TABLE  `" . PREFIX . "_users` CHANGE  `mob_phone`  `mob_phone` VARCHAR( 255 ) NOT NULL";

foreach($tableSchema as $table) {
    $db->query ($table);
}

echo $skin_header;

echo <<<HTML
<form method=POST action="/install/install_step3.php">
<input type=hidden name="reg_name" value="{$_REQUEST['reg_name']}">
<input type=hidden name="reg_password" value="{$_REQUEST['reg_password']}">
<input type=hidden name="regmail" value="{$_REQUEST['regmail']}">
<input type=hidden name="city_now" value="{$_REQUEST['city_osn_name']}">
<div class="box">
  <div class="box-header">
    <div class="title">Третий шаг установки - Установка первоначального контента</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
		Выполнен второй шаг установки. Осталось определиться с данными, которые будут установлены для первой работы портала.<br><br>

			<div style="padding-top:5px;">
            <table>
                <tr><td style="padding-right:20px;margin-right:20px;vertical-align:top;">
				<table>
					<tr><td colspan="3" height="40">&nbsp;&nbsp;<b>Наименование базы данных для установки</b><td></tr>
					<tr><td style="padding: 5px;">Установить базу справочника организаций</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_firm" value="1"></tr>
					<tr><td style="padding: 5px;">Установить базу стран, областей, городов (все страны) *только для серверов
					с большим объемом выделенной памяти, если Ваша страна не входит в рекомендуемую БД то Вы можете после
					установки воспользоваться редактированием стран через Панель Управления.</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_city" value="1"></tr>
					<tr><td style="padding: 5px;">Установить базу стран, областей, городов (Россия, Украина) *рекомендуемая</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_city_mini" value="1"></tr>
					<tr><td style="padding: 5px;">Установить базу рецептов еды</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_eda" value="1"></tr>
					<tr><td style="padding: 5px;">Установить базу марок и моделей автомобилей</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_autocat" value="1"></tr>
					<tr><td style="padding: 5px;">Установить базу школ и вузов</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_obrazovanie" value="1"></tr>
					<tr><td style="padding: 5px;">Установить стандартные поля для анкет знакомств</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_datting" value="1"></tr>
					<tr><td style="padding: 5px;">Установить стандартные категории форумов</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_forum" value="1"></tr>
					<tr><td style="padding: 5px;">Установить стандартные рекламные места и баннеры</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_banners" value="1"></tr>
					<tr><td style="padding: 5px;">Установить несколько записей для модуля праздников</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_holidays" value="1"></tr>
					<tr><td style="padding: 5px;">Установить базу категорий вопросов и ответов</td><td style="padding: 5px;"><input type=checkbox size="28" name="db_faq" value="1"></tr>

				</table>
				</td>
				<td style="vertical-align:top;">
        <div id="vk_groups"></div>
        <script type="text/javascript">
        VK.Widgets.Group("vk_groups", {mode: 4, no_cover: 1, wide: 1, height: "600", width: "600"}, 13001075);
	</script>
 </td>
				</tr>
				</table>
			</div>
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="Продолжить">
		<input type=hidden name="action" value="doinstall">
	</div>

  </div>
</div>
</form>
HTML;

echo $skin_footer;

?>