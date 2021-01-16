<?php
error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

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
  <title>Web2Work - ���������</title>
  <link href="/engine/skins/stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="/engine/skins/javascripts/application.js"></script>
</head>
<body>
<script language="javascript" type="text/javascript">
<!--
var dle_act_lang   = ["��", "���", "����", "������", "�������� ����������� � ������ �� ������"];
var cal_language   = {en:{months:['������','�������','����','������','���','����','����','������','��������','�������','������','�������'],dayOfWeek:["��", "��", "��", "��", "��", "��", "��"]}};
//-->
</script>
<nav style="max-width:1220px;width:100%;margin:0 auto;" class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
 <div class="navbar-header">
        <a class="navbar-brand" href="{$PHP_SELF}"><img src="/engine/skins/images/logo.png"></a>
  </div>
  <div style="float:right;margin-top:15px;" class="navbar-header">
  <b>���������:</b> 
  <a rel="nofollow" href="https://vkontakte.ru/club13001075" target="_blank"><img src="/engine/skins/images/vkontakte.png" alt="Web2Work Group � Vkontakte"></a>  <a rel="nofollow" target="_blank" href="https://twitter.com/#!/web2work/web2work-group"><img src="/engine/skins/images/twitter.png" alt="Web2Work Group � Twitter"></a> <a href="https://google.com/+Web2workRus" rel="publisher" target="_blank"><img src="/engine/skins/images/gplus.png" alt="Web2Work Group � Google+"></a> <a href="https://www.facebook.com/pages/Web2Work-Group/121157691285563" rel="nofollow" target="_blank"><img src="/engine/skins/images/facebook.png" alt="Web2Work Group � Facebook"></a>  <a target="_blank" href="https://www.youtube.com/channel/UCs1yzsO9earP5yOXiMLGclw"><img style="width:32px;height:24px;" alt="youtube web2work" src="/engine/skins/images/yotubeaoui.jpg"></a>
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


$tableSchema = array();

$tableSchema[] = "DROP TABLE IF EXISTS `pmd_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `pmd_category` (
  `selector` int(4) NOT NULL AUTO_INCREMENT,
  `category` text,
  `sccounter` int(11) NOT NULL DEFAULT '0',
  `ssccounter` int(11) NOT NULL DEFAULT '0',
  `fcounter` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `ip` text,
  `parentid` varchar(255) NOT NULL DEFAULT '',
  `sub` varchar(255) NOT NULL,
  `ico` varchar(255) NOT NULL,
  PRIMARY KEY (`selector`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if ($_REQUEST['db_firm']==1)
{
////////////////// ������������ ������ /////////////////////////////
require_once(ROOT_DIR.'/install/db_firm.php');
////////////////////////////////////////////////////////////////////
}
else
{
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(11, '���������� / ����������', 1, 0, 0, 0, 'page_standart', '', '', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(12, '����������', 1, 0, 0, 0, 'page_standart', '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(13, '������� ������������ ��� ��������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(14, '������ ��������� ����������', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(15, '�������� � ��������������', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(16, '���������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(17, '����� ����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(18, '����������� ������ ����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/storehouse.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(19, '������������� ������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(20, '������ �����������', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(21, '������ ���������� ����������', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(22, '���������������� - ������� / ���������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(23, '��������������� ������� (���)', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/gasStation.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(24, '����������', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(25, '���������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/dryCleaner.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(26, '������ ������� ����� ����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(27, '������������������ ����������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(28, '�����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(29, '�������� / �����', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/tire.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(30, '������������ ��� ������������� �����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(31, '������ / �������� �����������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(32, '������ / ���������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(33, '������ ������������ / ����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(34, '������ ���������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(35, '��������������� ��������� �����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(36, '��������� / ������ ���������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(37, '���������� � ��������������� (���)', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(38, '������������ ��� ��������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(39, '������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(40, '�������� - ������� / ���������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(41, '��������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(42, '��������� / �����', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(43, '������ ����', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(44, '������ �������� �����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(45, '������������ ��� �������� �����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(46, '����������� ������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(47, '����������� ���������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(48, '�������� ������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(49, '������ ����������� ������ ���������� ����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(51, '�����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(52, '�������� ��� ���������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(53, '���������� ������ �����', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(54, '������ �������������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(665, '���������', 0, 0, 0, 0, NULL, '', '', 'http://api-maps.yandex.ru/i/0.4/icons/camping.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(973, '�������� ���������', 2, 0, 0, 0, 'page_developer', '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1167, '�����������', 2, 0, 0, 0, '', '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1168, '��������� ������������', 2, 0, 0, 0, '', '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(867, '������� �������� �����������', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(934, '��������� ��������������� ����������� �������', 0, 0, 0, 0, NULL, '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(969, '�����', 1, 0, 0, 0, 'page_banki', '', '', 'http://api-maps.yandex.ru/i/0.4/icons/bank.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(975, '��������-��������', 2, 0, 0, 0, '', '', '', 'http://api-maps.yandex.ru/i/0.4/icons/shop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(976, '����, ����', 2, 0, 0, 0, '', '', '975', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(977, '�������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(978, '�������� ���', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(979, '��������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(980, '���������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(981, '������������ ������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(982, '���������� ������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(983, '������, �����, ����������', 2, 0, 0, 0, '', '', '975', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(984, '������� �������� ��������', 2, 0, 0, 0, '', '', '975', 'http://api-maps.yandex.ru/i/0.4/icons/shop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(985, '����� � �����������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(986, '���������� � ���������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(987, '�������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(988, '�������������, ������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(989, '�����', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(990, '������� � �����������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(991, '������ ��� ����', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(992, '������ ��� ������, ������ � �������', 2, 0, 0, 0, '', '', '975', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(993, '������', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(994, 'GPS ����������\\\\����������', 2, 0, 0, 0, '', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(995, '���������', 2, 0, 0, 0, '', '', '976', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(996, '��������', 2, 0, 0, 0, '', '', '976', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(997, '����������', 2, 0, 0, 0, '', '', '976', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(998, '����������', 2, 0, 0, 0, '', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(999, '����������������� ', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1000, ' ������� ����������', 2, 0, 0, 0, 'page_standart', '', '976', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1001, ' ��� ���������� � ��������', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1002, ' ��������', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1003, ' �����������', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1004, ' �����', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1005, ' ������������', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1006, ' ����, �����', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1008, '������� � ����', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1009, ' ������� ������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1010, ' ������� �����', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1011, ' ������� ������', 2, 0, 0, 0, 'page_standart', '', '977', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1012, ' ������� �����������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1013, ' ������� ���������', 2, 0, 0, 0, 'page_standart', '', '977', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1014, ' ������� �������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1015, ' �������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1016, ' �������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1017, ' ���������� ����', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1018, ' ������ ��� ��������', 2, 0, 0, 0, 'page_standart', '', '977', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1019, ' ��������� ��� �����', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1020, ' ����������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1021, ' ����������� ������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1022, ' ������� ��� ��� � �������������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1023, ' ������ ��� ���', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1024, ' ������ ��� �������������', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1025, '��������', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1026, ' ������������ �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1027, ' ��������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1028, ' ������ �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1029, ' ��������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1030, ' �������� ����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1031, ' �������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1032, ' �������� ����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1033, ' ����������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1034, ' ��������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1035, ' ����������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1036, ' ���������', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1037, ' ��������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1038, ' ����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1039, ' �������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1040, ' �������� � �������', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1041, ' ������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1042, ' ����� �� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1043, ' ����������', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1044, ' ���', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1045, ' �������� �����', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1046, '����', 2, 0, 0, 0, 'page_standart', '', '979', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1047, ' ��������-������', 2, 0, 0, 0, 'page_standart', '', '979', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1048, ' �������� ������', 2, 0, 0, 0, 'page_standart', '', '979', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1049, ' ����������� �������', 2, 0, 0, 0, 'page_standart', '', '979', 'http://api-maps.yandex.ru/i/0.4/icons/hospital.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1050, ' ����������� �������', 2, 0, 0, 0, 'page_standart', '', '979', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1051, '���� ��� ��������', 2, 0, 0, 0, 'page_standart', '', '980', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1052, ' ������ ��� ��������', 2, 0, 0, 0, 'page_standart', '', '980', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1053, '����������', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1054, ' ���������', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1055, ' ������� �����', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1056, ' ������� ������', 2, 0, 0, 0, 'page_standart', '', '983', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1057, ' ������� ������', 2, 0, 0, 0, 'page_standart', '', '983', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1058, ' �������������', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1059, ' ������� ������', 2, 0, 0, 0, 'page_standart', '', '983', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1060, ' ������ �����', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1061, ' �����', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1062, '������� ����������', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1063, ' ���� � ���������', 2, 0, 1, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1064, ' �����', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1065, ' �����������', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1066, ' ���������������� ������', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1067, ' ������� ������', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1068, ' ������ ��� ���������', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1069, '����������', 2, 0, 0, 0, 'page_standart', '', '986', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1070, ' ���������', 2, 0, 0, 0, 'page_standart', '', '986', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1071, ' �������� ���������', 2, 0, 0, 0, 'page_standart', '', '986', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1072, ' ����������', 2, 0, 0, 0, 'page_standart', '', '986', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1073, '������ �� ������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1074, ' ��������� ����', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1075, ' �����������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1076, ' �������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1077, ' �������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1078, ' �������������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1079, ' ����������� �������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1080, ' ������ ������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1081, ' �������� ������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1082, ' ��������� �������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1083, ' ����������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1084, ' ���������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1085, ' ���������� �����������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1086, ' ��������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1087, ' ��������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1088, ' �����', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1089, ' ���', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1090, ' ����', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1091, ' ������������ �������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1092, ' ��������� �������', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1093, '��� ��� ���� � ����', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1094, ' �����', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1095, ' ������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1096, ' ������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1097, ' ������� ������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1098, ' ����������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1099, ' ������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1100, ' ��������� ���������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1101, ' ��������� ��������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1102, ' ���������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1103, ' �������', 2, 0, 0, 0, 'page_standart', '', '988', 'http://api-maps.yandex.ru/i/0.4/icons/factory.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1104, ' ����������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1105, ' ������������ ���������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1106, ' ������������ �����', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1107, ' ������ ����', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1108, ' ������ ��� ���� � ����', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1109, ' ������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1110, ' �������-�������', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1111, 'CD DVD', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1112, ' mp3 ������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1113, ' ����������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1114, ' ������� �������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1115, ' ������������ �������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1116, ' ������������� �������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1117, ' ������������ �������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1118, ' �������� �������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1119, ' �����������', 2, 0, 0, 0, 'page_standart', '', '990', 'http://api-maps.yandex.ru/i/0.4/icons/cellular.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1120, ' ����������� ����������� ', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1121, ' ����������� �����������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1122, ' ������� ��������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1123, ' ������� ��� ��� � �������������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1124, ' ������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1125, ' ����', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1126, ' �����', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1127, ' �������� �����������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1128, ' ������� ������', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1129, '������������ ������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1130, ' ������� �����', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1131, ' ������ � �����', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1132, ' ������� ������ � ������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1133, ' �������� ��������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1134, ' ������������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1135, ' ������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1136, ' ������ ������� �������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1137, ' ���������� �����', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1138, ' ������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1139, ' �������� ���������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1140, ' ����������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1141, ' ����', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1142, ' ��������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1143, ' ������������� ������', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1144, '���������', 2, 0, 0, 0, 'page_standart', '', '992', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1145, ' ����� ������', 2, 0, 0, 0, 'page_standart', '', '992', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1146, ' ���������� ������ � �����', 2, 0, 0, 0, 'page_standart', '', '992', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1147, ' ���������� ������������', 2, 0, 0, 0, 'page_standart', '', '992', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1148, ' ���������� �������', 2, 0, 0, 0, 'page_standart', '', '992', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1149, ' ������ ��� �������', 2, 0, 0, 0, 'page_standart', '', '992', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1150, ' ���������', 2, 0, 0, 0, 'page_standart', '', '992', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1151, ' ������������� ����������', 2, 0, 0, 0, 'page_standart', '', '992', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1152, '������� ������', 2, 0, 0, 0, 'page_standart', '', '993', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1153, '���������', 2, 0, 10, 0, 'page_eda', '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1154, '����/����', 2, 0, 0, 0, 'page_eda', '', '1153', 'http://api-maps.yandex.ru/i/0.4/icons/bar.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1155, '�������� �� ���', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1156, '����������', 2, 0, 1, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1157, '����', 2, 0, 1, 0, 'page_eda', '', '1153', 'http://api-maps.yandex.ru/i/0.4/icons/cafe.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1158, '���������', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1159, '�����', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1160, '�������', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1161, '���������', 2, 0, 6, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1162, '��������', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1163, '���������', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1164, '�����-����', 2, 0, 1, 0, 'page_eda', '', '1153', 'http://api-maps.yandex.ru/i/0.4/icons/bar.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1165, '��������', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1166, '����-����', 2, 0, 1, 0, 'page_eda', '', '1153', '')";
}

$tableSchema[] = "DROP TABLE IF EXISTS `weather_city`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `weather_city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `country_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `city_name` (`name`(8)),
  KEY `country_name` (`country`),
  KEY `counry_id` (`country_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `weather_country`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `weather_country` (
  `id` int(10) unsigned NOT NULL,
  `iso2` char(2) NOT NULL,
  `iso3` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `iso2` (`iso2`),
  UNIQUE KEY `iso3` (`iso3`),
  KEY `country_name` (`name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `weather_current`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `weather_current` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `cloud` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `t` tinyint(4) NOT NULL DEFAULT '0',
  `t_flik` tinyint(4) NOT NULL DEFAULT '0',
  `p` smallint(6) NOT NULL DEFAULT '0',
  `w` smallint(5) unsigned NOT NULL DEFAULT '0',
  `w_rumb` smallint(5) unsigned NOT NULL,
  `h` tinyint(3) unsigned NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city_id` (`city_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `weather_forecast`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `weather_forecast` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `hour` tinyint(3) unsigned NOT NULL,
  `cloud` tinyint(3) unsigned NOT NULL,
  `precip` tinyint(3) unsigned NOT NULL,
  `t_min` tinyint(4) NOT NULL,
  `t_max` tinyint(4) NOT NULL,
  `p_min` smallint(6) NOT NULL,
  `p_max` smallint(6) NOT NULL,
  `w_min` smallint(5) unsigned NOT NULL,
  `w_max` smallint(5) unsigned NOT NULL,
  `w_rumb` smallint(5) unsigned NOT NULL,
  `h_min` tinyint(3) unsigned NOT NULL,
  `h_max` tinyint(3) unsigned NOT NULL,
  `wpi` tinyint(3) unsigned NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forecast_unique` (`city_id`,`date`,`hour`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_weather_gismeteo_region`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_weather_gismeteo_region` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `region_id` int(11) NOT NULL,
  `region_name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `name_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_change_city`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_change_city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `weather_id` int(11) NOT NULL,
  `portal_id` int(11) NOT NULL,
  `url_kyil` varchar(255) NOT NULL,
  `url_eng` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keyword` text NOT NULL,
  `descript` text NOT NULL,
  `descript_site` text NOT NULL,
  `weather_gm_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_weather_gismeteo_city`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_weather_gismeteo_city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `region_id` int(11) NOT NULL,
  `region_name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `name_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

require_once(ROOT_DIR.'/install/db_weather.php');
require_once(ROOT_DIR.'/install/db_gismeteo.php');

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_citys`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_citys` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_id` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `col` varchar(255) NOT NULL DEFAULT '',
  `strana_id` varchar(255) NOT NULL DEFAULT '',
  `id2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_citys_raions`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_citys_raions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `id_citys` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_citys_region`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_citys_region` (
  `region_id` int(5) NOT NULL AUTO_INCREMENT,
  `parent_id` varchar(255) NOT NULL,
  `region_name` varchar(255) NOT NULL,
  `region_type` varchar(255) NOT NULL,
  `agency_id` varchar(255) NOT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_citys_strana`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_citys_strana` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `col` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if ($_REQUEST['db_city']==1)
{
////////////////// ������������ ������ /////////////////////////////
require_once(ROOT_DIR.'/install/db_city.php');
////////////////////////////////////////////////////////////////////
}elseif ($_REQUEST['db_city_mini']==1)
{
require_once(ROOT_DIR.'/install/db_mini_city.php');
}else {
require_once(ROOT_DIR.'/install/db_mini_city.php');
}

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_cook_all`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_cook_all` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_catid` int(11) NOT NULL DEFAULT '0',
  `r_name` varchar(255) NOT NULL DEFAULT '',
  `r_goods` text NOT NULL,
  `r_cook` text NOT NULL,
  PRIMARY KEY (`r_id`),
  FULLTEXT KEY `r_name` (`r_name`),
  FULLTEXT KEY `r_cook` (`r_cook`),
  FULLTEXT KEY `r_cook_2` (`r_cook`,`r_name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_cook_cats`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_cook_cats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_cook_pcats`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_cook_pcats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `pcat_id` int(11) NOT NULL DEFAULT '0',
  `cat_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if ($_REQUEST['db_eda']==1)
{
////////////////// ������������ ������ /////////////////////////////
require_once(ROOT_DIR.'/install/db_eda.php');
////////////////////////////////////////////////////////////////////
}

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_auto_marka`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_auto_marka` (
`id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `view` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_descr` text NOT NULL,
  `meta_keys` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_auto_marka_osn`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_auto_marka_osn` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `view` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_auto_model`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_auto_model` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `marka_id` varchar(255) NOT NULL DEFAULT '',
  `name` longtext NOT NULL,
  `desc` text NOT NULL,
  `view` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) DEFAULT '0',
  `icon` text NOT NULL,
  `alt_name` varchar(255) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_descr` text NOT NULL,
  `meta_keys` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_auto_model_osn`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_auto_model_osn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marka_id` varchar(255) NOT NULL DEFAULT '',
  `name` longtext NOT NULL,
  `desc` text NOT NULL,
  `view` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_auto_complektacii_list`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_auto_complektacii_list` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `marka_id` varchar(255) NOT NULL DEFAULT '',
  `name` longtext NOT NULL,
  `desc` text NOT NULL,
  `view` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) DEFAULT '0',
  `icon` text NOT NULL,
  `strana` text NOT NULL,
  `rul` text NOT NULL,
  `url_alt` text NOT NULL,
  `period_vipuska` text NOT NULL,
  `price` text NOT NULL,
  `marka_engine` text NOT NULL,
  `marka_kuzova` text NOT NULL,
  `type_transmission` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_auto_model_complektacii`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_auto_model_complektacii` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `marka_id` varchar(255) NOT NULL DEFAULT '',
  `name` text NOT NULL,
  `desc` text NOT NULL,
  `view` varchar(255) NOT NULL DEFAULT '',
  `rate` varchar(255) DEFAULT '0',
  `icon` text NOT NULL,
  `strana` text NOT NULL,
  `rul` text NOT NULL,
  `url_alt` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if ($_REQUEST['db_autocat']==1)
{
////////////////// ������������ ������ /////////////////////////////
require_once(ROOT_DIR.'/install/db_autocat.php');
////////////////////////////////////////////////////////////////////
}

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_obrazovanie`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_obrazovanie` (
  `id` bigint(3) NOT NULL AUTO_INCREMENT,
  `cat_id` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `col` varchar(255) NOT NULL DEFAULT '',
  `strana_id` varchar(255) NOT NULL DEFAULT '',
  `gorod_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_obrazovanie_fakulteti`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_obrazovanie_fakulteti` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_id` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_obrazovanie_form`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_obrazovanie_form` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_obrazovanie_status`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_obrazovanie_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if ($_REQUEST['db_obrazovanie']==1)
{
////////////////// ������������ ������ /////////////////////////////
require_once(ROOT_DIR.'/install/db_obrazovanie.php');
////////////////////////////////////////////////////////////////////
}

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_brak`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_brak` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_bududelat_svobodniy`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_bududelat_svobodniy` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_celi_znakomstva`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_celi_znakomstva` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_deti`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_deti` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_geteroopit`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_geteroopit` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_ishu`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_ishu` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `descr` text NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  `col` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_kakseks`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_kakseks` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_kurenie`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_kurenie` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_mater_podderzhka`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_mater_podderzhka` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_narkotik`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_narkotik` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_obmen`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_obmen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `icq` varchar(255) NOT NULL DEFAULT '',
  `mail` varchar(255) NOT NULL DEFAULT '',
  `posit` smallint(5) NOT NULL DEFAULT '1',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_orientacia`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_orientacia` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_vozbuzdaet`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_vozbuzdaet` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_znakomlus_s`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_znakomlus_s` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_alkogol`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_alkogol` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_testpartnerov`";
$tableSchema[] = "CREATE TABLE `".PREFIX."_testpartnerov` (
  `id` int(5) NOT NULL auto_increment,
  `vote_1` varchar(255) NOT NULL default '',
  `vote_2` varchar(255) NOT NULL default '',
  `field0` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_testsnimki`";
$tableSchema[] = "CREATE TABLE `".PREFIX."_testsnimki` (
  `id` int(11) NOT NULL auto_increment,
  `snimok_url` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `desc` text NOT NULL,
  `field0` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if ($_REQUEST['db_datting']==1)
{
////////////////// ������������ ������ /////////////////////////////
require_once(ROOT_DIR.'/install/db_datting.php');
////////////////////////////////////////////////////////////////////
}

$url = $config['http_home_url'];
$skin = $config['skin'];

//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (1, 'reg_mail', '{%username%},\r\n\r\n��� ������ ���������� � ����� $url\r\n\r\n�� �������� ��� ������, ��� ��� ���� e-mail ����� ��� ����������� ��� ����������� �� �����. ���� �� �� ���������������� �� ���� �����, ������ �������������� ��� ������ � ������� ���. �� ������ �� �������� ������ ������.\r\n\r\n------------------------------------------------\r\n��� ����� � ������ �� �����:\r\n------------------------------------------------\r\n\r\n�����: {%username%}\r\n������: {%password%}\r\n\r\n------------------------------------------------\r\n���������� �� ���������\r\n------------------------------------------------\r\n\r\n���������� ��� �� �����������.\r\n�� ������� �� ��� ������������� ����� �����������, ��� �������� ����, ��� �������� ���� e-mail ����� - ��������. ��� ��������� ��� ������ �� ������������� ��������������� � �����.\r\n\r\n��� ��������� ������ ��������, ������� �� ��������� ������:\r\n\r\n{%validationlink%}\r\n\r\n���� � ��� ���� ��������� ������ �� ����������, �������� ��� ������� �����. � ���� ������, ���������� � ��������������, ��� ���������� ��������.\r\n\r\n� ���������,\r\n\r\n������������� $url.')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (2, 'feed_mail', '{%username_to%},\r\n\r\n������ ������ ��� �������� {%username_from%} � ����� $url\r\n\r\n------------------------------------------------\r\n����� ���������\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\nIP ����� �����������: {%ip%}\r\n\r\n------------------------------------------------\r\n�������, ��� ������������� ����� �� ����� ��������������� �� ���������� ������� ������\r\n\r\n� ���������,\r\n\r\n������������� $url')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (3, 'lost_mail', '��������� {%username%},\r\n\r\n�� ������� ������ �� ��������� �������� ������ �� ����� $url ������ � ����� ������������ ��� ������ �������� � ������������� ����, ������� �� �� ����� �������� ��� ��� ������ ������, ������� ���� �� ������ ������������� ����� ������, ������� �� ��������� ������: \r\n\r\n{%lostlink%}\r\n\r\n���� �� �� ������ ������� ��� ��������� ������, �� ������ ������� ������ ������, ��� ������ ��������� � �������� �����, � ���������� ����������� �����.\r\n\r\nIP ����� �����������: {%ip%}\r\n\r\n� ���������,\r\n\r\n������������� $url')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (4, 'new_news', '��������� �������������,\r\n\r\n���������� ��� � ���, ��� �� ����  $url ���� ��������� �������, ������� � ������ ������ ������� ���������.\r\n\r\n------------------------------------------------\r\n������� ���������� � �������\r\n------------------------------------------------\r\n\r\n�����: {%username%}\r\n��������� �������: {%title%}\r\n���������: {%category%}\r\n���� ����������: {%date%}\r\n\r\n� ���������,\r\n\r\n������������� $url')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (5, 'comments', '��������� {%username_to%},\r\n\r\n���������� ��� � ���, ��� �� ����  $url ��� �������� ����������� � �������, �� ������� �� ���� ���������.\r\n\r\n------------------------------------------------\r\n������� ���������� � �����������\r\n------------------------------------------------\r\n\r\n�����: {%username%}\r\n���� ����������: {%date%}\r\n������ �� �������: {%link%}\r\n\r\n------------------------------------------------\r\n����� �����������\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\n------------------------------------------------\r\n\r\n���� �� �� ������ ������ �������� ����������� � ����� ������������ � ������ �������, �� ����������� �� ������ ������: {%unsubscribe%}\r\n\r\n� ���������,\r\n\r\n������������� $url')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (6, 'pm', '��������� {%username%},\r\n\r\n���������� ��� � ���, ��� �� �����  $url ��� ���� ���������� ������������ ���������.\r\n\r\n------------------------------------------------\r\n������� ���������� � ���������\r\n------------------------------------------------\r\n\r\n�����������: {%fromusername%}\r\n����  ���������: {%date%}\r\n���������: {%title%}\r\n\r\n------------------------------------------------\r\n����� ���������\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\n� ���������,\r\n\r\n������������� $url')";

$row = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_email" );
if ($row['count']<6)
{
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (7, 'new_pm', '{%to%},\r\n\r\n{%username%} {%sex%} ��� ������ ���������.\r\n����������� ���� ����� ������ ��������� ����� �� ��������:\r\n".$url."index.php?do=pm\r\n\r\n� ���������,\r\n������������� $url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (8, 'new_cammen', '���������� ��� � ���,\r\n��� �� �����  ".$url." � ����� ����� �����������.\r\n------------------------------------------------\r\n��������� ����������� �� {%username%}, ����� ���: ".$url."clubizm/{%to%}\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (9, 'new_clubco', '���������� ��� � ���,\r\n��� �� �����  ".$url." � ����� \"{%to%}\" ����� �����������.\r\n------------------------------------------------\r\n��������� ����������� �� {%username%}, ����� �� �������� �����: ".$url."clubizm/{%tourl%}\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (10, 'new_clubne', '���������� ��� � ���,\r\n��� �� �����  ".$url." � ����� {%to%} ����� �������.\r\n------------------------------------------------\r\n��������� �������, ����� �� �������� �����: ".$url."clubizm/{%to%}. ��� �� ������� ������ �������: {%fullnews%}\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (11, 'new_comodn', '���������� ��� � ���,\r\n��� �� �����  ".$url." � ������������ {%to%} ����� �����������.\r\n------------------------------------------------\r\n��������� ����������� �� {%username%}, ����� �� ������ ��������: ".$url."user/{%tourl%}. \r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (12, 'new_comut', '���������� ��� � ���,\r\n��� �� �����  ".$url." ��� �������� ����������� �� ���� ��������.\r\n------------------------------------------------\r\n��������� ����������� �� {%username%}, ����� �� ����� ��������: ".$url."user/{%tourl%}.\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` VALUES (13, 'new_inform', '������������, {%username%}\r\n\r\n���������� ��� � ���,\r\n��� ��� ������ �� �������� ��������� ��� ������ ����� \"{%to%}\" ��� ��������� ���������� �������.\r\n------------------------------------------------\r\n����� ������������� �����������, ��� ����� ������ ��� ��� ������� �� ���� � �������� ���� ��� ������ � .css �����.\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` VALUES (14, 'app_inform', '���������� ��� � ���,\r\n��� ��� ������ �� �������� ��������� ��� ������ ����� {%to%} ��� ������.\r\n------------------------------------------------\r\n��� ��� ���������:\r\n{%code_informer%}\r\n\r\n����� ��� ������� �� ����:\r\n{%style_informer%}\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(15, 'new_addobj', '���������� ��� � ���,\r\n��� �� �����  ".$url." � ������ ".$url."doska/{%to%}/ ��������� ����� ���������� {%title%}.\r\n------------------------------------------------\r\n���������� ���������� �� {%username%}, ����� �� ��������: ".$url."{%sub%}doska/obj/{%tourl%}/.\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(16, 'new_addaut', '���������� ��� � ���,\r\n��� �� �����  ".$url." � ���� ���������� �� �������� ".$url."autocat/about_model/{%to%}/ �������� ����� �����������.\r\n------------------------------------------------\r\n����������� �� {%username%}\r\n\r\n����� �����������: {%title%}\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(37, 'edazayavka', '��������� {%namer%},\r\n\r\n���������� ��� � ���, ��� ���� ��������� ������ �� {%type%}.\r\n\r\n------------------------------------------------\r\n������� ���������� � �����������\r\n------------------------------------------------\r\n\r\n���-�� �����: {%who%}\r\n������� ��� �� ��������: {%date%}\r\n��������� �� ����� ������������ (�����): {%link%}\r\n��������� �� ���� �����������: {}\r\n�������������� ����������: {}\r\n�������������� ���������: {}\r\n\r\n------------------------------------------------\r\n���������� ����������\r\n------------------------------------------------\r\n\r\n���: {%text%}\r\nEmail: {}\r\n�������: {}\r\nICQ: {}\r\n\r\n------------------------------------------------\r\n\r\n� ���������,\r\n{%home_title%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(38, 'sendcart', '��������� {%namer%},\r\n\r\n���������� ��� � ���, ��� ��� �������� ����� {%type%}.\r\n\r\n------------------------------------------------\r\n������� ���������� � �����������\r\n------------------------------------------------\r\n\r\n���������� ������: {%who%}\r\n����� ���������: {%price%}\r\n���� ������: {%date%}\r\n{%doppole%}\r\n\r\n------------------------------------------------\r\n���������� ����������\r\n------------------------------------------------\r\n\r\n���: {%fio%}\r\nEmail: {%email%}\r\n�������: {%phone%}\r\nICQ: {%icq%}\r\n\r\n------------------------------------------------\r\n\r\n� ���������,\r\n{%home_title%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(39, 'reg_rating', '������������ <b>{%url%}</b>,\r\n\r\n��������� ���������� ��� � �������� ������������ � �������� ������ - {%home_title%}. ���������� � ����� �������:\r\n\r\n<b>��� ���������� ����� [ID]: {%memberid%}\r\n��� ����� : {%sitename%}\r\n����� ����� : {%url%}\r\n�������� �����: {%description%}\r\n\r\n�� �������� ������������ ������������ ��� ���������������� �������������� ������. �� �������, ��� ��� ������ ������� ��� � �������� � ����������� ������ �������!\r\n\r\n��� ���������� ������ ��� ���������� ���������� �� ��������� ������� ����������� HTML-���. ��� ������ �������� ��� ��� ���������� ������������ ������ �������, � ����� ��������� ����������� ������� � ��������.\r\n\r\n����� �������� ��� ��������, �������������� ���� �������:\r\n{%http_home_url%}/rating/get_code/\r\n\r\n���� � ��� �������� ������� ��� �����������, ���������� � {%http_home_url%}feedback/\r\n����������� ���������:\r\n\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(40, 'reg_ratins', '������������,\r\n\r\n� ��� ��� �������� ����� ����:\r\n����������:\r\n���������� ����� [ID]: {%memberid%}\r\n��� ����� : {%sitename%}\r\nEmail : {%email%}\r\n����� ����� : {%url%}\r\n�������� ����� : {%description%}\r\n������ : {%pssw2%}\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(41, 'reg_st1', '���������� �� ��������� �����:\r\n\r\n��� ID: {%id%}\r\n�����: {%host%}\r\n����: {%hits%}\r\n������������: {%users%}\r\n\r\n����� ��������� ���������� �� ������ ���������� {%http_home_url%}?do=stats_sites&id={%id%} �� �������� ���������� ������ �����\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(42, 'hotelzayav', '������������!\r\n\r\n��������� ������ �� ������������ ������:\r\n��������� (��������): {%se%}\r\n���������� �������: {%contact_phone%}\r\n���������� email: {%contact_email%}\r\n��� ��� ���������: {%contact_type%} {%contact_name%}\r\n������: {%dop_pole%}\r\n�����: {%room_id%}\r\n���-�� �������: {%room_count%}\r\n����� ������: {%pay_type%}\r\n���-�� �����: {%guests_count%}\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(43, 'hotelzayas', '������������!\r\n\r\n�� ��������� ������ �� ������������ ������:\r\n��������� (��������): {%se%}\r\n������: {%dop_pole%}\r\n�����: {%room_id%}\r\n���-�� �������: {%room_count%}\r\n����� ������: {%pay_type%}\r\n���-�� �����: {%guests_count%}\r\n\r\n� ��������� ����� � ���� �������� �������� ������ ��������� (��������) � ������� ������ ������������.\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(44, 'videocom', '������������!\r\n\r\n���������� ��� � ���, ��� �� ����� {%home_title%} � ������� ����������� �������� ����� �����������.\r\n\r\n��������� ����������� ����� �� ��������: {%http_home_url%}archiv_video/{%idvideo%}.html\r\n\r\n� ���������,\r\n������������� {%home_title%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(45, 'firm_com', '���������� ��� � ���,\r\n��� �� �����  {%http_home_url%} ��� ����������� \"{%to%}\" �������� ����� �����������.\r\n------------------------------------------------\r\n��������� ����������� �� {%username%}, ����� �� �������� �����: {%http_home_url%}firm/{%tourl%}\r\n------------------------------------------------\r\n� ���������,\r\n�������������\r\n{%http_home_url%}')";
}

$row = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_email_vip" );
if ($row['count']<3)
{
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email_vip` (`id`, `name`, `template`) VALUES
(1, 'demo', '��������� {%username%},\r\n\r\n��� ������ ���������� � ����� ".$url."\r\n\r\n�� �������� ��� ������, ��� ��� ���� e-mail ����� ��� ����������� ��� ��������� ����-�����.\r\n\r\n------------------------------------------------\r\n��� ����-���� �� �����:\r\n------------------------------------------------\r\n\r\n����: {%demo%}\r\n\r\n------------------------------------------------\r\n���������� �� ���������\r\n------------------------------------------------\r\n\r\n������� � ��� ������� �� ����� ".$url." � ���� ��� ��������� ����� ������� ������������� ���� � ������� ������ \"������������\".\r\n\r\n������� � �������: {%linkprofile%}\r\n\r\n� ���������,\r\n\r\n������������� ����� ".$url."'),
(2, 'activ_key', '��������� �������������,\r\n\r\n���������� ��� � ���, ��� �� ����� ".$url." ��� ����������� ����:\r\n\r\n------------------------------------------------\r\n������� ����������\r\n------------------------------------------------\r\n\r\n�����������: {%username%}\r\n����: {%key%}\r\n���� ���������: {%date%}\r\n����� ���������: {%time%}\r\n���������: {%status%}\r\n\r\n� ���������,\r\n\r\n������������� ������� ".$url."'),
(3, 'auto', '��������� {%username%},\r\n\r\n��� ������ ���������� � ����� ".$url."\r\n\r\n�� �������� ��� ������, ��� ��� ���� e-mail ����� ��� ����������� ��� ��������� �����.\r\n\r\n------------------------------------------------\r\n��� ���� �� �����:\r\n------------------------------------------------\r\n\r\n����: {%key%}\r\n\r\n------------------------------------------------\r\n���������� �� ���������\r\n------------------------------------------------\r\n\r\n������� � ����� v.i.p.  �� ����� ".$url." � ���� ��� ��������� ����� ������� ������������� ���� � ������� ������ \"������������\".\r\n\r\n������� � modul v.i.p: {%linkvip%}\r\n\r\n� ���������,\r\n\r\n������������� ����� ".$url."')";
}

$row = $db->super_query( "SELECT COUNT(id) as count FROM " . PREFIX . "_forum_email" );
if ($row['count']<4)
{
$tableSchema[] = "INSERT INTO `" . PREFIX . "_forum_email` (`id`, `name`, `template`) VALUES
(1, 'subscription_text', '������������, {%username_to%}!\r\n\r\n{%username_from%} ������� � ���� \"{%topic_name%}\", �� ������� �� ���������.\r\n\r\n���� ��������� �� ������:\r\n\r\n{%topic_link%}\r\n\r\n------------------------------------------------\r\n�� ������ � ����� ����� ���������� �� ����� �������� ����� ������:\r\n\r\n{%topic_link_del%}\r\n\r\n------------------------------------------------\r\n\r\n� ���������,\r\n\r\n������������� ".$url."'),
(2, 'frend_text', '{%username_to%},\r\n\r\n������ ������ ��� �������� {%username_from%} � ����� ".$url."\r\n\r\n------------------------------------------------\r\n����� ���������\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\n------------------------------------------------\r\n�������, ��� ������������� ����� �� ����� ��������������� �� ���������� ������� ������\r\n\r\n� ���������,\r\n\r\n������������� ".$url."'),
(3, 'report_text', '������ ������ ��� �������� {%username_from%} � ����� ".$url."\r\n\r\n------------------------------------------------\r\n����� ������\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\n------------------------------------------------\r\n������� ���������� � ������\r\n------------------------------------------------\r\n\r\n����: {%topic_link%}\r\n\r\nID ���������: {%post_id%}\r\n\r\n------------------------------------------------\r\n\r\n� ���������,\r\n\r\n������������� ".$url."'),
(4, 'new_topic', '��������� �������������,\r\n\r\n���������� ��� � ���, ��� �� ����� �����  ".$url." ���� ��������� ����.\r\n\r\n------------------------------------------------\r\n������� ���������� � ����\r\n------------------------------------------------\r\n\r\n�����: {%username%}\r\n���� ����������: {%date%}\r\n�������� ����: {%title%}\r\n������ �� ����: {%link%}\r\n\r\n\r\n� ���������,\r\n\r\n������������� ".$url."')";
}

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banners";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banners (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `banner_tag` varchar(40) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `code` text NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `short_place` tinyint(1) NOT NULL DEFAULT '0',
  `bstick` tinyint(1) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `category` varchar(200) NOT NULL DEFAULT '',
  `grouplevel` varchar(100) NOT NULL DEFAULT 'all',
  `sd_pokaz` varchar(80) NOT NULL,
  `start` varchar(15) NOT NULL DEFAULT '',
  `end` varchar(15) NOT NULL DEFAULT '',
  `catbanners` int(5) NOT NULL,
  `banner_priceone` int(150) NOT NULL,
  `banner_priceweek` int(150) NOT NULL,
  `banner_viewsstat` int(150) NOT NULL,
  `banner_views` int(50) NOT NULL DEFAULT '0',
  `views` smallint(50) NOT NULL DEFAULT '0',
  `banner_click` int(50) unsigned DEFAULT NULL,
  `clicked` int(50) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `banner_urls` varchar(255) NOT NULL,
  `fpage` tinyint(1) NOT NULL DEFAULT '0',
  `innews` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_banners` (`id`, `banner_tag`, `descr`, `code`, `approve`, `short_place`, `bstick`, `main`, `category`, `grouplevel`, `sd_pokaz`, `start`, `end`, `catbanners`, `banner_priceone`, `banner_priceweek`, `banner_viewsstat`, `banner_views`, `views`, `banner_click`, `clicked`, `image`, `image2`, `banner_urls`, `fpage`, `innews`) VALUES
(1, 'counter', '��������', '<div align=center><a href=http://web2work.ru/><img width=88 src=/uploads/banners/88x31.png></a><a href=http://web2work.ru/><img width=88 src=/uploads/banners/88x31.png></a> <a href=http://web2work.ru/><img width=88 src=/uploads/banners/88x31.png></a><a href=http://web2work.ru/><img width=88 src=/uploads/banners/88x31.png></a><br></div>', 1, 0, 1, 0, '0', 'all', '1', '', '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', 0, '0'),
(2, 'foother', '������ ������', '<img src=\"/uploads/banners/728x90.png\">', 1, 0, 1, 0, '0', 'all', '1', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(3, 'right', '������ ������', '<img src=\"/uploads/banners/240x400.png\">', 1, 0, 0, 0, '0', 'all', '1', '', '', 1, 0, 500, 90000, 0, 0, 0, 0, '', '', '', 0, '0'),
(6, 'content', '������ � ���� ��������', '<img src=\"/uploads/banners/468x60.png\">', 1, 0, 0, 0, '0', 'all', '1', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(28, 'main_right_foother', '������ ������ �� �������', '<img src=\"/uploads/banners/468x60.png\">', 0, 0, 0, 0, '', 'all', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(29, 'news_2', '����������� ������ �� �������', '<img src=\"/uploads/banners/468x60.png\">', 0, 0, 0, 0, '', 'all', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(22, 'top', '�������', '<img src=\"/uploads/banners/728x90.png\">', 1, 0, 0, 0, '', 'all', '', '', '', 0, 500, 600, 0, 0, 0, 0, 0, '', '', '', 0, '0'),
(26, 'main_right_top', '������ ������� �� �������', '<img src=\"/uploads/banners/468x60.png\">', 0, 0, 0, 0, '', 'all', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(25, 'top_news', '�� �������, ��� ������� ��������', '<div style=\"max-width: 100%; height: 100%; max-height: 45px\"><a href=\"#\" target=\"_blank\"><img src=\"/uploads/banners/news-top-banner.png\" style=\"width: 100%;\"></a></div>', 0, 0, 0, 0, '0', 'all', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banners_spisok`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banners_spisok` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `banner_tag` varchar(40) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `code` text NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `short_place` tinyint(1) NOT NULL DEFAULT '0',
  `bstick` tinyint(1) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `category` varchar(200) NOT NULL DEFAULT '',
  `grouplevel` varchar(100) NOT NULL DEFAULT 'all',
  `sd_pokaz` varchar(80) NOT NULL,
  `start` varchar(15) NOT NULL DEFAULT '',
  `end` varchar(15) NOT NULL DEFAULT '',
  `catbanners` int(5) NOT NULL,
  `banner_priceone` int(150) NOT NULL,
  `banner_priceweek` int(150) NOT NULL,
  `banner_viewsstat` int(150) NOT NULL,
  `banner_views` int(50) NOT NULL DEFAULT '0',
  `views` smallint(50) NOT NULL DEFAULT '0',
  `banner_click` int(50) unsigned DEFAULT NULL,
  `clicked` int(50) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `banner_urls` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `deyatelnost` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if ($_REQUEST['db_banners']==1)
{
//// ���������� �������� �� ������ 10.0 ���� � �����������
}

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_afisha_cat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_afisha_cat` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT '',
  `sub` varchar(255) NOT NULL DEFAULT '',
  `funct_1` varchar(255) NOT NULL DEFAULT '',
  `funct_2` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '',
  `skin_name` varchar(255) NOT NULL,
  `objaccess` varchar(255) NOT NULL,
  `access_mod` varchar(255) NOT NULL DEFAULT '',
  `access_upload` varchar(255) NOT NULL DEFAULT '',
  `access_view` varchar(255) NOT NULL DEFAULT '',
  `access_rating` varchar(255) NOT NULL DEFAULT '',
  `access_com` varchar(255) NOT NULL DEFAULT '',
  `access_delall` varchar(255) NOT NULL DEFAULT '',
  `zhanr` varchar(255) NOT NULL,
  `rezh` varchar(255) NOT NULL,
  `vrolax` varchar(255) NOT NULL,
  `zhan` varchar(255) NOT NULL,
  `zhan_c` varchar(255) NOT NULL,
  `birthdate` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `".PREFIX."_afisha_cat` (`id`, `alt_name`, `name`, `desc`, `icon`, `sub`, `funct_1`, `funct_2`, `type`, `skin_name`, `objaccess`, `access_mod`, `access_upload`, `access_view`, `access_rating`, `access_com`, `access_delall`, `zhanr`, `rezh`, `vrolax`, `zhan`, `zhan_c`, `birthdate`) VALUES
(1010, 'kino', '����', '', '141', 'yes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1011, 'club', '�����', '', '131', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1012, 'concert', '���������� ���', '', '149', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1013, 'concerthall', '�����', '', '256', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1014, 'performance', '���������', '', '256', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1015, 'exhibition', '��������', '', '246', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1016, 'sport', '�����', '', '629', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1017, 'other', '������', '', '117', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_awards_list`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_awards_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `img` varchar(30) NOT NULL DEFAULT '',
  `point` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `auto` tinyint(1) NOT NULL DEFAULT '0',
  `comments` int(11) NOT NULL DEFAULT '0',
  `news` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_awards_list` (`id`, `name`, `img`, `point`, `count`, `auto`, `comments`, `news`) VALUES
(12, '������', '11.jpg', 10, 1, 0, 0, 0),
(13, '����', '1.jpg', 1, 2, 0, 0, 0),
(14, '� ���� ��������!', '10.jpg', 10, 3, 0, 0, 0),
(15, '�������', '12.jpg', 5, 1, 0, 0, 0),
(16, '�����������', '13.jpg', 2, 2, 0, 0, 0),
(17, '�������', '14.jpg', 3, 0, 0, 0, 0),
(18, '���! �������!', '15.jpg', 1, 0, 0, 0, 0),
(19, '������� ���������!', '16.jpg', 20, 1, 0, 0, 0),
(20, '������!', '2.jpg', 1, 1, 0, 0, 0),
(21, ';)', '21.jpg', 1, 0, 0, 0, 0),
(22, '���������', '3.jpg', 1, 0, 0, 0, 0),
(23, '����', '4.jpg', 1, 0, 0, 0, 0),
(24, '�����', '5.jpg', 1, 0, 0, 0, 0),
(25, '�������', '6.jpg', 30, 1, 0, 0, 0),
(26, '������', '7.jpg', 1, 0, 0, 0, 0),
(27, '�������', '8.jpg', 1, 1, 0, 0, 0),
(28, '�����', '9.jpg', 1, 0, 0, 0, 0),
(30, '���������!', '24.jpg', 1, 2, 0, 0, 0),
(31, '��� ��������', '52.jpg', 1, 0, 0, 0, 0),
(32, '�����', '46.jpg', 1, 0, 0, 0, 0),
(33, '����� ���', '200-27.jpg', 10, 3, 0, 0, 0)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_arcade_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_arcade_category` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `alt_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `alt_name` (`alt_name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_arcade_category` (`id`, `name`, `alt_name`) VALUES
(1, '������', 'arcade'),
(2, '����������', 'logic'),
(3, '�����������', 'ero'),
(4, '�������', 'fly'),
(5, '�������', 'kid'),
(6, '���������������', 'brain'),
(7, '����������', 'sport'),
(8, '�����', 'car'),
(9, '���������', 'shot'),
(10, '�����', 'fight')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_arcade_games`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_arcade_games` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `gfiles` varchar(60) NOT NULL DEFAULT '',
  `gdesc` text NOT NULL,
  `gcount` int(11) NOT NULL DEFAULT '0',
  `gtitle` varchar(40) NOT NULL DEFAULT '',
  `bgcolor` varchar(6) NOT NULL DEFAULT 'FFFFFF',
  `gwidth` int(11) NOT NULL DEFAULT '500',
  `gheight` int(11) NOT NULL DEFAULT '400',
  `alt_name` varchar(50) NOT NULL DEFAULT '',
  `rating` smallint(5) NOT NULL DEFAULT '0',
  `vote_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `comm_num` mediumint(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `gid` (`gid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_arcade_games` (`gid`, `gfiles`, `gdesc`, `gcount`, `gtitle`, `bgcolor`, `gwidth`, `gheight`, `alt_name`, `rating`, `vote_num`, `comm_num`) VALUES
(1, 'adameva', '���� ���� � ���, ����� ������� � ���� ���, � ������� ������ ���� �� ��� ��������� ��� ����.', 27, 'Eva And Adam', 'FFFFF', 500, 450, 'ero', 0, 0, 0),
(2, 'asshunter', '�� ������ ����������� �� �������� �������� ������� �������� � ������', 33, 'Ass hunter', 'FFFFFF', 500, 340, 'ero', 0, 0, 0),
(3, 'asteroids', '���� ���� �������� ����������� ������������ �� ����������', 27, 'Asteroids', '000000', 500, 400, 'fly', 0, 0, 0),
(4, 'blocksibpa', '���� ���� ���������� ����� ��������� �����', 28, 'Blocks', 'FFFFFF', 500, 300, 'logic', 0, 0, 0),
(5, 'breakout', '������� ����� � ������� ����� Arcanoid', 28, 'Breakout', '000000', 500, 350, 'arcade', 0, 0, 0),
(6, 'conundrumibpro', '����� ������� 25 ������ � ���������� �� ��� �����.', 31, 'Conundrum', 'FFFFFF', 500, 350, 'brain', 0, 0, 0),
(7, 'crazycloset', '�������� ������ � �������', 27, '�razy �loset', '000000', 370, 500, 'kid', 0, 0, 0),
(8, 'donkeykong', '������� ������������ �����', 29, 'Donkey Kong', '000000', 400, 500, 'arcade', 0, 0, 0),
(9, 'hexxagon', '��� ����� ��������� ������ ����� ��� ����������', 28, 'Hexxagon', '000000', 500, 400, 'logic', 5, 1, 0),
(10, 'helicopter', '�� ������ ��������� ���� �������� ���� �� ��������� ������� �����������', 27, 'Helicopter', '000000', 500, 400, 'fly', 5, 1, 0),
(11, 'invaders', '��� ���� ������� �������� ������', 25, 'Space Invaders', '000000', 500, 400, 'fly', 0, 0, 0),
(12, 'moonlander', '���������� ������� � �������� ��� �� ��� ��������. �� ������ ������� ��� ������������ 100 �����. �� ������� �� ����������� �������', 26, 'Moon Lander', '000000', 500, 400, 'fly', 0, 0, 0),
(13, 'pacman', '������� ��� �����, ����� ������� � ���������� ������. ', 29, 'Pac Man', '000', 400, 500, 'arcade', 0, 0, 0),
(14, 'penguinhit', '�������� ��������� � ����', 29, 'Penguin Hit', 'FFFFFF', 500, 310, 'sport', 0, 0, 0),
(15, 'simon', '���������� ���� �� ������. ��� ����� ��������� ������� �� ������, � ����� ������������������, � ����� �� ��� ������� ���������. ', 21, 'Simon', '000000', 500, 400, 'brain', 0, 0, 0),
(16, 'snake', '������ ������ - ������ ��� ����� ������, ��� ���� �� ����������� � �����. ������ ��������� ������ ��������� ������ �����.', 26, 'Snake', '000000', 500, 400, 'arcade', 0, 0, 0),
(17, 'tetris', '��������� �� ����� �����. ��������� ����������� ����� ���������.', 27, 'Tetris', 'ffffff', 400, 500, 'arcade', 0, 0, 0),
(18, 'flowfrenibpro', '�������� � ���� 3 � ������ ���������� ������ \r\n���� �� �����!', 23, 'FLOWER FRENZY', 'ffffff', 500, 400, 'kid', 0, 0, 0),
(19, 'SparkYourNeuronsSte', '���� ��� ���� ������ ����� �������� ��� � ������(���� ����������� ����� ����).\r\n�������� ��� ����� �������!', 25, 'Spark Your Neurons', 'ffffff', 500, 400, 'logic', 0, 0, 0),
(20, 'zookeepermp', '��������� ������� �������, �������� � ��� ���������� ��������', 23, 'Zoo Keeper', '000000', 500, 400, 'kid', 0, 0, 0),
(21, 'collapseibpa', '������', 24, 'Collapse', 'ffffff', 500, 350, 'logic', 0, 0, 0),
(22, 'yeti1greece', '��� ������ �������� �������� ��� � �������!\r\n����� 5 �������.  ', 24, 'yeti � ������', 'ffffff', 500, 350, 'sport', 0, 0, 0),
(23, 'billibpro', '�������.\r\n����� ��� ���� ������� ����������� �����.\r\n���� ������������� ���� ����� ��� � ����.', 21, 'Billards', '000000', 500, 350, 'sport', 0, 0, 0),
(24, 'ubillibpro', '�������� �������� ���� �� ���� ��� ��������� �����! ', 32, 'Ultimate Billiards', 'ffffff', 500, 400, 'sport', 0, 0, 0),
(25, 'exraceibpro', '������������� ����� �� F1', 21, 'Extreme Racing', 'ffffff', 500, 350, 'car', 0, 0, 0),
(26, 'togyballBH', '���������� ������. \r\n�� ��� ������� ��������� � ���� ������\r\n���� �� 21 ����! ', 24, 'togyballBH', 'ffffff', 350, 500, 'sport', 0, 0, 0),
(27, 'socceribpro', '������ ������ �� ����, ��������� ��� � ������� ��� ����� ��� ������.', 25, 'Soccer Ball', 'ffffff', 500, 400, 'sport', 0, 0, 0),
(28, 'uracingibpro', '�����.\r\n��� ������. ', 27, 'Ultimate Racing', 'ffffff', 500, 400, 'car', 0, 0, 0),
(29, 'jigsawdogibpro', '�����. ', 24, 'JigSaw Puzzle Dog', 'ffffff', 500, 400, 'logic', 0, 0, 0),
(30, 'jigsawmonkeyibpro', '�����. ', 34, 'JigSaw Puzzle Monkey', 'ffffff', 500, 400, 'logic', 0, 0, 0),
(31, 'monsterhatchibpa', '���������� ������� ��� ����. ', 90, 'Monster Hatch', 'ffffff', 500, 400, 'brain', 0, 0, 0),
(32, 'slidermaniaibpro', '�������� ����� �� �����. ', 106, 'Slidermania', 'ffffff', 500, 350, 'kid', 5, 1, 0),
(33, 'pislandibpro', '�������� ���� �� �����!', 84, 'Paradise Island:Jig Saw Puzzle', 'ffffff', 500, 400, 'logic', 5, 1, 0),
(34, 'spaceace', '������� ����� �� ����������! ', 102, 'spaceace', '000000', 500, 400, 'fly', 0, 0, 0),
(35, 'snakenew', '����� ������ ���� ��������� ���� snake', 110, 'snakenew', 'ffffff', 500, 400, 'arcade', 0, 0, 0),
(36, 'blocks2mp', '������� �������!!! (����������� ���� ������������� ����� � ������ ��� pocket pc) ', 101, 'Blocks', 'FFFFFF', 500, 400, 'logic', 0, 0, 0),
(37, 'sonicblox', '������ � ��������.', 96, 'sonicblox', 'ffff00', 380, 500, 'arcade', 0, 0, 0),
(38, 'moodmatchibpro', '����� ���� ���������� ���.\r\n���� �� ������ � �� �����. ', 99, 'Mood Match', 'ffffff', 500, 400, 'kid', 0, 0, 4),
(39, 'ultimatepingibpro', '��������. ', 106, 'Ultimate Ping', 'ffffff', 500, 360, 'sport', 2, 1, 0),
(40, 'usnakeibpro', '������ ', 106, 'Ultimate Snake', 'ffffff', 370, 500, 'arcade', 0, 0, 0),
(41, 'chicken', '������ �������� �� ������.\r\n�������� �������� �����. ', 101, 'chicken', 'ffffff', 400, 500, 'arcade', 5, 1, 0),
(42, 'x227sm', '�������� �����', 96, 'x227sm', '000000', 500, 400, 'shot', 0, 0, 0),
(43, 'flayersm', '�� ���������� ��������� � ������ �������� ����������', 98, 'Flayer', '000000', 400, 450, 'arcade', 0, 0, 0),
(44, 'skates', '��������� �� �������, ����� ���������', 94, 'Crazy Scates', 'FFFFFF', 500, 400, 'sport', 0, 0, 0),
(45, 'bombjack', '��������� ����� � �� ����������� �������', 98, 'Bomb Jack', 'FFFFFF', 500, 400, 'arcade', 0, 0, 0),
(46, 'castle_defender', '�������� �� ���� �� �����������', 104, 'Castle Defender', 'FFFFFF', 400, 500, 'shot', 0, 0, 0),
(47, 'muaythai', '������ �����, ����� ������ ������ � �����������', 95, 'Muay Thai', '000000', 500, 400, 'fight', 0, 0, 0),
(48, 'firebase36', '����� � ��������', 101, 'Mud and Blood (vietnam)', '000000', 500, 400, 'arcade', 0, 0, 0),
(49, 'urbanslug2', '��������� ������, ������������� ������', 106, 'Urabanslug', '000000', 500, 400, 'arcade', 3, 1, 0),
(50, 'sonic', '���� ��������� � ������� ����', 164, 'Sonic', '000000', 500, 400, 'arcade', 4, 1, 2)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_badge_list`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_badge_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `img` varchar(30) NOT NULL DEFAULT '',
  `point` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `auto` tinyint(1) NOT NULL DEFAULT '0',
  `comments` int(11) NOT NULL DEFAULT '0',
  `news` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_badge_list` (`id`, `name`, `img`, `point`, `count`, `auto`, `comments`, `news`) VALUES
(12, '������', '11.png', 10, 2, 0, 0, 0),
(13, '����', '1.png', 1, 3, 0, 0, 0),
(14, '� ���� ��������!', '10.png', 10, 3, 0, 0, 0),
(15, '�������', '12.png', 5, 1, 0, 0, 0),
(16, '�����������', '13.png', 2, 1, 0, 0, 0),
(20, '������!', '2.png', 1, 2, 0, 0, 0),
(22, '���������', '3.png', 1, 0, 0, 0, 0),
(23, '����', '4.png', 1, 0, 0, 0, 0),
(24, '�����', '5.png', 1, 1, 0, 0, 0),
(25, '�������', '6.png', 30, 1, 0, 0, 0),
(26, '������', '7.png', 1, 1, 0, 0, 0),
(27, '�������', '8.png', 1, 1, 0, 0, 0),
(28, '�����', '9.png', 1, 0, 0, 0, 0)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_import`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_import` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bankname` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `extra` int(20) NOT NULL,
  `bankid` int(20) NOT NULL,
  `supervisor` varchar(255) NOT NULL,
  `supervisor_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_banki_import` (`id`, `bankname`, `file`, `extra`, `bankid`, `supervisor`, `supervisor_id`) VALUES
(1, '��� ����', 'http://bcs-bank.com/export/quotes/csv.asp', 0, 0, '".$_REQUEST['reg_name']."', 0)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_import_city`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_import_city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bankname` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `extra` int(20) NOT NULL,
  `bankid` int(20) NOT NULL,
  `supervisor` varchar(255) NOT NULL,
  `supervisor_id` int(20) NOT NULL,
  `table` text NOT NULL,
  `td` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_banki_import_city` (`id`, `bankname`, `file`, `extra`, `bankid`, `supervisor`, `supervisor_id`, `table`, `td`) VALUES
(1, '����1', 'http://www.kgs.ru/fin/', 5, 0, '".$_REQUEST['reg_name']."', 0, '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"90%\" align=\"center\">(.*)</table>', '<td class=\"table_cell\"(.*?)>(.*?)</td>'),
(2, '������������', 'http://www.66.ru/bank/currency/', 6, 0, '".$_REQUEST['reg_name']."', 0, '<table class=\"rates_table\">(.*)</table>', '<td(.*?)>(.*?)</td>'),
(3, '����', 'http://www.kgs.ru/fin/', 5, 1, '".$_REQUEST['reg_name']."', 0, '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"90%\">(.*)</table>', '<td class=\"table_cell\"(.*?)>(.*?)</td>'),
(4, '����', 'http://www.kgs.ru/fin/', 9, 2, '".$_REQUEST['reg_name']."', 0, '<td width=\"51%\" class=\"table_bank\">(.*)</table>', '<td class=\"table_cell\"(.*?)>(.*?)</td>'),
(5, '���������', 'http://www.kgs.ru/fin/', 8, 3, '".$_REQUEST['reg_name']."', 0, '<table class=''bank_coins_table'' cellspacing=1>(.*)</table>', '<td(.*?)>(.*?)</td>'),
(9, '����', 'http://sochi1.ru/exchange/exchange.html', 6, 0, '".$_REQUEST['reg_name']."', 1, '<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"table2\">(.*)</table>', '<td(.*?)>(.*?)</td>')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_banki_zayavki_type`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_banki_zayavki_type` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_banki_zayavki_type` (`id`, `alt_name`, `name`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `t11`, `t12`, `t13`, `t14`, `t15`) VALUES
(11, 'creditauto', '������ - ����������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 'creditpotrebit', '������ - ���������������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, 'creditipoteka', '������ - ���������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, 'creditcard', '��������� �����', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(15, 'straxovanieauto', '����������� - ����������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(16, 'straxovaniekvartira', '����������� - ��������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(17, 'straxovaniestroenie', '����������� - ��������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_category_banki`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_category_banki` (
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
  `forum_id` smallint(5) NOT NULL DEFAULT '0',
  `metatitle` varchar(255) NOT NULL,
  `catmain` varchar(255) NOT NULL,
  `rate` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_category_banki` (`id`, `parentid`, `posi`, `name`, `alt_name`, `icon`, `skin`, `descr`, `keywords`, `news_sort`, `news_msort`, `news_number`, `short_tpl`, `full_tpl`, `setlinks`, `forum_id`, `metatitle`, `catmain`, `rate`) VALUES
(155, 0, 1, '�����', 'banki', '', '', '', '�����, �������, �����������, ������ � ������', '', '', 0, '', '', 'no', 0, '', '', 0),
(156, 0, 1, '����������� �����', 'corporate', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(157, 0, 1, '���������� �����', 'consumer', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(158, 0, 1, '������ � ������', 'forum', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(161, 155, 1, '������ ������', 'banks', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(162, 155, 1, '��������� �������', 'brokers', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(163, 155, 1, '����� ������', 'offices', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(165, 155, 1, '������� ������', 'bankrating', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(167, 155, 1, '����� ����� ������', 'currency', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(168, 155, 1, '���������', 'cash', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(170, 157, 1, '������� ���������', 'crediting', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(171, 157, 1, '��������� �����', 'creditcard', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(172, 157, 1, '�����������', 'autocrediting', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(173, 157, 1, '�������', 'hypothec', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(174, 157, 1, '������ ������', 'deposit', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(175, 157, 1, '������ �� ������', 'credit_order', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(179, 156, 1, '������ �� ������', 'biz_order', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(180, 156, 1, '������� �������', 'creditin', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(181, 156, 1, '��������', 'deposits', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(182, 156, 1, '��������-�������� ������������', 'rko', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(183, 156, 1, '���������', 'factoring', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(184, 156, 1, '������', 'leasing', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(210, 155, 1, '��� ������ � ������', 'forumblog', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_citys_cat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_citys_cat` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `col` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_citys_cat` (`id`, `name`, `alt_name`, `desc`, `col`) VALUES
(1, '�����', 'citys', '�����', '0'),
(2, '�������', 'derevni', '�������', '0'),
(3, '������', 'poselok', '������', '0')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_club_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_club_category` (
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

$tableSchema[] = "INSERT INTO `" . PREFIX . "_club_category` (`id`, `parentid`, `posi`, `name`, `alt_name`, `icon`, `skin`, `descr`, `keywords`, `news_sort`, `news_msort`, `news_number`, `short_tpl`, `full_tpl`, `setlinks`) VALUES
(3, 0, 1, '������ � ����', 'reviews', 'guitar00.gif', '', '', '', '', '', 0, '', '', ''),
(2, 0, 2, '��������� � ��������', 'issk', 'sights00.gif', '', '', '', '', '', 0, '', '', ''),
(4, 0, 3, '������ � ���������', 'content', 'children.gif', '', '', '', '', '', 0, '', 'adv_shab', ''),
(5, 0, 1, '����� � ���', 'interview', 'plc_hm00.gif', '', '', '', '', '', 0, '', '', ''),
(6, 0, 4, '������� � ��������', 'musobzor', 'medic000.gif', '', '', '', '', '', 20, '', '', ''),
(7, 0, 1, '��� � �������', 'moda', 'gov00000.gif', '', '', '', '', '', 0, '', '', ''),
(8, 0, 1, '������ � �������', 'love', 'plc_wrk0.gif', '', '', '', '', '', 0, '', '', ''),
(9, 0, 1, '�������� � ��������', 'video', 'orgs0000.gif', '', '', '', '', '', 0, '', '', ''),
(10, 0, 1, '����������� � �������', 'avtomoto', 'hummer00.gif', '', '', '', '', '', 0, '', '', ''),
(11, 0, 1, '����� � �������', 'kurezi', 'hummer00.gif', '', '', '', '', '', 0, '', '', ''),
(12, 0, 5, '���������� � ��������', 'todj', 'openid-i.gif', '', '', '', '', '', 0, '', '', ''),
(13, 0, 1, '���������� � ���������', 'djlab', 'auto0000.gif', '', '', '', '', '', 0, '', '', ''),
(19, 0, 1, '����������� � �����', 'cafes', 'fitnes00.gif', '', '', '', '', '', 0, '', '', ''),
(15, 0, 1, '����� � �����������', 'review', 'ball0000.gif', '', '', '', '', '', 0, '', '', ''),
(16, 0, 6, '�������� � �������', 'concurs', 'vote_up1.gif', '', '', '', '', '', 0, '', '', ''),
(17, 0, 1, '������� � �����������', 'clubs', 'plc_int0.gif', '', '', '', '', '', 0, '', '', ''),
(18, 0, 1, '��������� ����', 'coolgerl', 'vote_up0.gif', '', '', '', '', '', 0, '', '', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_doska_cat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_doska_cat` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT '',
  `sub` varchar(255) NOT NULL DEFAULT '',
  `funct_1` int(15) NOT NULL,
  `funct_2` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '',
  `skin_name` varchar(255) NOT NULL,
  `objaccess` varchar(255) NOT NULL,
  `access_mod` varchar(255) NOT NULL DEFAULT '',
  `access_upload` varchar(255) NOT NULL DEFAULT '',
  `access_view` varchar(255) NOT NULL DEFAULT '',
  `access_rating` varchar(255) NOT NULL DEFAULT '',
  `access_com` varchar(255) NOT NULL DEFAULT '',
  `access_delall` varchar(255) NOT NULL DEFAULT '',
  `pred_mest` varchar(255) NOT NULL,
  `dolshnost` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
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
  `pol` varchar(255) NOT NULL,
  `dolshnost2` varchar(255) NOT NULL,
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
  `full_area` varchar(255) NOT NULL,
  `klovokomn` varchar(255) NOT NULL,
  `materioal` varchar(255) NOT NULL,
  `sroksdac` varchar(255) NOT NULL,
  `kratkopis` varchar(255) NOT NULL,
  `srconec` varchar(255) NOT NULL,
  `sotr` varchar(255) NOT NULL,
  `otlichiya` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_doska_cat` (`id`, `alt_name`, `name`, `desc`, `icon`, `sub`, `funct_1`, `funct_2`, `type`, `skin_name`, `objaccess`, `access_mod`, `access_upload`, `access_view`, `access_rating`, `access_com`, `access_delall`, `pred_mest`, `dolshnost`, `price`, `formoplati`, `tiprab`, `graphrab`, `usl`, `treb`, `obaz`, `aboutcomp`, `obrazie`, `stag`, `znanyaz`, `znankomp`, `bizob`, `pol`, `dolshnost2`, `zpra`, `uczav`, `stah`, `predrab`, `znaniyaz`, `znankompi`, `biziob`, `dopsved`, `vazhnost`, `poil`, `vozrast`, `cen`, `cenz`, `cena`, `naz`, `nazc`, `nazv`, `teks`, `tes`, `ter`, `valuta`, `vata`, `vaa`, `valutas`, `vlta`, `vtsa`, `full_area`, `klovokomn`, `materioal`, `sroksdac`, `kratkopis`, `srconec`, `sotr`, `otlichiya`) VALUES
(5, 'moto', '���������', '����� ������ ���������� � ������� ����������� �����������. ������ ������ �� ����� ���� ���������� ����������� ����� 1000 ���� ���������. ���� �� ������ ������� ���� ����������� ���������� � ������������� ��� �������, �� ������ ��������� ������ � ������ ���� ���������� ���������� � ������� �������� ����������.', '', '1', 0, '', '1', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1, 'auto', '����', '����� �� ������� ������� ���������� ������� ���������� �� ������� � ������� ���� � �������������. �� ������ ����� ��������� ���������� � ������� ������ ���� ��� ���������� ����������. ��� ���� ���� ������ ���������� ���������� ������ ������ �� ������ ���������� � ������� ������ �����. ��� ������� � ����� ����������� �������������� �������� ���� �����������.', '', '0', 0, '', '1', 'about_doska.tpl', '1', '1', '1', '1', '1', '1', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 'car', '�������� ����������', '', '', '1', 418, '', '1', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 'parts', '�������� ��� �����������', '', '', '1', 0, '', '1', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, 'truck', '�������� �������', '', '', '1', 0, '', '1', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, 'nedv', '������������', '����� �� ������� ������� ���������� ���������� �� ������� � ������� ������������ � �������������: ����������� � ������� �������, ������ ������ ������� �� �������� ������������ � ������� ���. �� ������ ����� ���������� ���������� � �������, ������ ����� ������������ ��� ����� ������ ��������, ����. ������ ���������� � ������� ��� ������ ������������ �������������� ��������� ����������� � ����������� ���������.', '', '0', 0, '', '2', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, 'kvar', '��������', '', '', '3415', 1532, '', '2', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, 'komn', '�������', '', '', '3415', 0, '', '2', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, 'zemuch', '��������� �������', '', '', '3416', 0, '', '10', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 'house', '���� � ��������', '', '', '3416', 0, '', '10', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, 'garage', '������', '', '', '3415', 0, '', '2', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, 'office', '�����', '', '', '3417', 0, '', '11', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(17, 'zoo', '��������', '', '', '25', 0, '', '3', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(25, 'gorbar', '��������� ���������', '', '', '0', 0, '', '3', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(26, 'othersz', '������', '', '', '25', 0, '', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1003, 'work', '�����', '', '', '0', 89, '', '6', 'about_doska_work.tpl', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1005, 'auditbsd', '�����, ���������� ����', '', '', '1003', 2, '', '6', 'about_doska_work.tpl', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3334, 'adbuh', '�����������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3335, 'adfs', '�������, ��������� � �����������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3336, 'adstr', '�������������, ������������', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3337, 'adprom', '��������������, ������������, ������', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3338, 'adit', 'IT, �������, �����', '', '', '1003', 0, '', '6', 'about_doska_work.tpl', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3339, 'adsecr', '�����������, ���', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3340, 'adhr', 'HR, ��������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3341, 'admark', '���������, �������, PR', '', '', '1003', 3, '', '6', 'about_doska_work.tpl', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3342, 'adsmi', '���, ������������, ����������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3343, 'adregi', '������������, �������� �������������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3344, 'adrozn', '��������� �������� ���', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3345, 'adprodp', '��������� �������� �������� �������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3346, 'adpromob', '������� (��������������, ������������)', '', '', '1003', 12, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3347, 'adstrnedv', '������� (�������������, ������������)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3348, 'adprodtnt', '������� (���, ��������)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3349, 'aduslrek', '������� (������, �������)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3350, 'adfinansi', '������� (�������, �����������)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3351, 'adavtozap', '������� (����������, ��������)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3352, 'adprodit', '������� (IT, ����������)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3353, 'adpmebel', '������� (������, ������)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3354, 'aduris', '�������������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3355, 'adgos', '��������������� ������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3356, 'adrestor', '�����������, ������, ���������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3357, 'adturism', '������, ���������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3358, 'adpostavki', '��������, ���', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3359, 'adlogistika', '���������, ���������, �����', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3360, 'adsx', '�������� ���������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3361, 'admedicina', '��������, ������������', '', '', '1003', 1, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3362, 'adsport', '�����, �������, ������ �������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3363, 'addesign', '���������, ���������� ���������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3364, 'adkultura', '��������, ���������, �����������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3365, 'adnauka', '�����, �����������, ����������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3366, 'adslugba', '������ ������������, ������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3367, 'addompers', '�������� ��������, ������������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3368, 'adraznorab', '������������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3369, 'adstudents', '������ ��� ��������, ���������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3370, 'adsezon', '��������, ��������� ������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3371, 'adpensioners', '������ ��� �����������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3415, 'zhil', '�����', '', '', '8', 0, '', '2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3416, 'zagor', '����������', '', '', '8', 0, '', '10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3417, 'comm', '������������', '', '', '8', 0, '', '11', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3438, 'upravlenie-personalom-treningi', '���������� ����������, ��������', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3440, 'administrativnyy-personal', '���������������� ��������', '', '', '1003', 1, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3441, 'transport-logistika', '���������, ���������', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3437, 'informacionnye-tehnologii-internet-telekom', '�������������� ����������, ��������, �������', '', '', '1003', 3, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3442, 'bezopasnost', '������������', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3443, 'buhgalteriya-upravlencheskiy-uchet-finansy-predpriyatiya', '�����������, �������������� ����, ������� �����������', '', '', '1003', 5, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3444, 'vysshiy-menedzhment', '������ ����������', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3445, 'nachalo-karery-studenty', '������ �������, ��������', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3446, 'yuristy', '������', '', '', '1003', 1, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3447, 'rabochiy-personal', '������� ��������', '', '', '1003', 3, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3448, 'zakupki', '�������', '', '', '1003', 1, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3449, 'banki-investicii-lizing', '�����, ����������, ������', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_doska_type`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_doska_type` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_doska_type` (`id`, `alt_name`, `name`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `t11`, `t12`, `t13`, `t14`, `t15`) VALUES
(1, 'auto', '����', '�����', '������', '���', '���', '������ (��)', '����', '����� ��������� (��3)', '�������� (�.�)', '', '', '', '', '', '', ''),
(10, 'zagor', '������������ ����������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 'nedv', '������������', '���������� ������', '���', '', '�����', '�����', '����', '�������', '�����', '', '', '', '', '', '', ''),
(3, 'zoo', '�����', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 'rezume', '������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 'vacations', '��������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, 'beauraut', '���� ������� - �������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, 'beauraut_missed', '���� ������� - �������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, 'tenders', '�������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, 'comm', '������������ ������������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 'objectnedv', '������� ������������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, 'predlnovo', '����������� ����������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, 'predlkot', '����������� ���������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(15, 'objectkot', '������� ���������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(16, 'zemuch', '������������ ���������� �������', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_faqcategories`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_faqcategories` (
  `id_cat` tinyint(3) NOT NULL AUTO_INCREMENT,
  `categories` varchar(255) DEFAULT NULL,
  `answer_num` tinyint(4) NOT NULL,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `opisanie` text NOT NULL,
  PRIMARY KEY (`id_cat`),
  KEY `id_cat` (`id_cat`),
  KEY `flanguage` (`answer_num`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_faqcategories` CHANGE  `id_cat`  `id_cat` TINYINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT";

if ($_REQUEST['db_faq']==1)
{
////////////////// ������������ ������ /////////////////////////////
require_once(ROOT_DIR.'/install/db_faq.php');
////////////////////////////////////////////////////////////////////
}

$tableSchema[] = "INSERT INTO `" . PREFIX . "_faqcategories` (`id_cat`, `categories`, `answer_num`, `parentid`, `opisanie`) VALUES
(12, '������', 0, 0, '������� ��� ������ �� ����������� Suzuki ������������-�������������� ������������ ������'),
(9, '������� �� ������ � �����', 1, 0, ''),
(10, '����� �������', 0, 0, ''),
(11, '����������� �������', 0, 0, '������� ��� ������ �� ����������� Suzuki ������������-�������������� ������������ ������'),
(17, '������� � �������', 2, 12, '�������, �������, ������������, ����������� ������������ � ������ ������ ���� ��� ���������� ����������� Toyota'),
(18, '����������', 0, 9, '������� ��� ������ �� ����������� Suzuki ������������-�������������� ������������ ������'),
(20, '������������', 0, 0, ''),
(21, '����� ������������', 3, 20, ''),
(22, '���������� ������', 1, 0, ''),
(23, '������������, �������', 1, 20, ''),
(24, '������ ����', 0, 20, '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_faqkonsultant`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_faqkonsultant` (
  `id_cat` tinyint(3) NOT NULL AUTO_INCREMENT,
  `categories` varchar(255) NOT NULL,
  `konsultant` varchar(255) DEFAULT NULL,
  `kontakt` varchar(255) NOT NULL,
  `dolshnost` varchar(255) NOT NULL,
  `fullname` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_cat`),
  KEY `id_cat` (`id_cat`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_faqkonsultant` (`id_cat`, `categories`, `konsultant`, `kontakt`, `dolshnost`, `fullname`, `email`, `about`, `foto`) VALUES
(22, '22', '".$_REQUEST['reg_name']."', '���. 234565646435345', '������������ �������� �� ������ ���� �������������', '��������� ��������', '".$_REQUEST['regmail']."', '�������� �����-������������� ��������������� ���������-������������� ��������.\r\n� 2000 ���� �������� � ������������ � ����������� ������: ���������������, ����������� ����������� ������, ����� ������������ �� ������������ ����������� ���. � 2003 ���� � ��������� ������ ����������.\r\n� 2007 � 2009 ��. � ����������� ���������� ������ ���������������� �������� � ������������ ������������� ��������.\r\n� ������� 2009 � �������� ����������������� ��� � �������������.\r\n� 2010 �� ��������� ����� � �������� ���������� ��������� ������������ ������������� �������� (� ��������� �������� ��� ������� ������ ������������, �����������, ��������, ��������� ������� � ���������� ������������).\r\n�������, ����������� ����.', 'http://s.66.ru/localStorage/19/c7/6e/d6/19c76ed6_resizedScaled_177to211.jpg'),
(23, '9', '".$_REQUEST['reg_name']."', '���. 234565646435345', '������� �� ������������', '����� �������', '".$_REQUEST['regmail']."', 'afasd asdasfg2v4t4v3t 45v5t45 �������� (������� ��������� �������� (������� ��������� afasd asdasfg2v4t4v3t 45v5t45 �������� (������� ��������� �������� (������� ��������� afasd asdasfg2v4t4v3t 45v5t45 �������� (������� ��������� �������� (������� ���������', 'http://s.66.ru/localStorage/19/c7/6e/d6/19c76ed6_resizedScaled_177to211.jpg')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_kuhna`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_kuhna` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_firm_kuhna` (`id`, `name`, `alt_name`) VALUES
(1, '���������������', ''),
(2, '���������', ''),
(3, '������������', ''),
(4, '����������', ''),
(5, '��������', ''),
(6, '���������', ''),
(7, '�����������', ''),
(8, '����������', ''),
(9, '���������', ''),
(10, '���������', ''),
(11, '����������', ''),
(12, '���������', ''),
(13, '�����������', ''),
(14, '�����������', ''),
(15, '����������', ''),
(16, '���������', ''),
(17, '���������', ''),
(18, '���������', ''),
(19, '������������������', ''),
(20, '������������', ''),
(21, '��������', ''),
(22, '�������', ''),
(23, '��������', ''),
(24, '�����������������', ''),
(25, '���������', ''),
(26, '����������', ''),
(27, '�����������', ''),
(28, '���������', ''),
(29, '�������', ''),
(30, '��������', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_market_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_market_category` (
  `selector` int(4) NOT NULL AUTO_INCREMENT,
  `category` text,
  `sccounter` int(11) NOT NULL DEFAULT '0',
  `ssccounter` int(11) NOT NULL DEFAULT '0',
  `fcounter` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `ip` text,
  `parentid` varchar(255) NOT NULL DEFAULT '',
  `sub` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  PRIMARY KEY (`selector`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_firm_market_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `count`) VALUES
(1, '������� �������', 0, 0, 0, 0, NULL, '', '', 6),
(2, '������������', 0, 0, 0, 1, NULL, '', '1', 0),
(3, '������������', 0, 0, 0, 1, NULL, '', '1', 0),
(4, '������������', 0, 0, 0, 0, '', '', '1', 0),
(5, '���-����', 0, 0, 0, 1, NULL, '', '1', 3),
(6, '���������� ������', 0, 0, 0, 0, NULL, '', '1', 0),
(7, '�����������', 0, 0, 0, 0, NULL, '', '', 2),
(8, '������������', 0, 0, 0, 0, NULL, '', '7', 2),
(20, '�����������', 0, 0, 0, 0, NULL, '', '7', 0),
(21, 'DVD-������,', 0, 0, 0, 0, '', '', '7', 0),
(22, '����������', 0, 0, 0, 0, NULL, '', '7', 0),
(23, 'MP3-������', 0, 0, 0, 0, NULL, '', '7', 1),
(24, 'GPS-����������', 0, 0, 0, 0, NULL, '', '7', 0),
(25, '��������', 0, 0, 0, 0, NULL, '', '', 0),
(26, '������� ��������', 0, 0, 0, 0, NULL, '', '25', 0),
(27, '���������', 0, 0, 0, 0, NULL, '', '25', 0),
(28, '�������������', 0, 0, 0, 0, NULL, '', '25', 0),
(29, '����', 0, 0, 0, 0, NULL, '', '', 2),
(30, '����', 0, 0, 0, 0, NULL, '', '29', 0),
(31, '�����', 0, 0, 0, 0, NULL, '', '29', 0),
(32, '���������', 0, 0, 0, 0, NULL, '', '29', 2),
(33, '�������� ������������', 0, 0, 0, 0, NULL, '', '8', 0),
(34, '��������, �������, �����', 0, 0, 0, 0, NULL, '', '', 0),
(35, '�������', 0, 0, 0, 0, NULL, '', '34', 0),
(36, '�������� ��������', 0, 0, 0, 0, NULL, '', '34', 0),
(37, '�������������� �������', 0, 0, 0, 0, NULL, '', '34', 0),
(38, '���� � ����� �����', 0, 0, 0, 0, NULL, '', '34', 0),
(39, '������� �������', 0, 0, 0, 0, NULL, '', '34', 0),
(40, '�����, ������', 0, 0, 0, 0, NULL, '', '34', 0),
(41, '����������� � �������� �������', 0, 0, 0, 0, NULL, '', '34', 0),
(42, '���������� �������', 0, 0, 0, 0, '', '', '34', 0),
(43, '��� �������� �������������', 0, 0, 0, 0, NULL, '', '34', 0),
(44, '�������� �������', 0, 0, 0, 0, NULL, '', '34', 0),
(45, '������������ �������', 0, 0, 0, 0, NULL, '', '34', 0),
(46, '������ � ����� ', 0, 0, 0, 0, NULL, '', '34', 0),
(47, '���������������� ��������', 0, 0, 0, 0, NULL, '', '34', 1),
(48, '���, ����, �����', 0, 0, 0, 0, '', '', '34', 0),
(49, '����� ������������', 0, 0, 0, 0, NULL, '', '35', 0),
(50, '����, ����', 0, 0, 0, 0, NULL, '', '35', 0),
(51, '�����', 0, 0, 0, 0, NULL, '', '35', 0),
(52, '������, ������', 0, 0, 0, 0, NULL, '', '36', 0),
(53, '������������� ���������', 0, 0, 0, 0, NULL, '', '36', 0),
(54, '����������� ���� ', 0, 0, 0, 0, NULL, '', '37', 0),
(55, '����', 0, 0, 0, 0, NULL, '', '37', 0),
(56, '�������', 0, 0, 0, 0, NULL, '', '37', 0),
(57, '����� �����', 0, 0, 0, 0, NULL, '', '38', 0),
(58, '�������', 0, 0, 0, 0, NULL, '', '40', 0),
(59, '������', 0, 0, 0, 0, NULL, '', '40', 0),
(60, '������, �������� ����', 0, 0, 0, 0, NULL, '', '40', 0),
(61, '�������', 0, 0, 0, 0, NULL, '', '41', 0),
(62, '���, ����, ������� ', 0, 0, 0, 0, NULL, '', '41', 0),
(63, '�����, ������, ��������', 0, 0, 0, 0, NULL, '', '41', 0),
(64, '�������� ���', 0, 0, 0, 0, NULL, '', '43', 0),
(65, '����������', 0, 0, 0, 0, NULL, '', '44', 0),
(66, '���������� ', 0, 0, 0, 0, NULL, '', '65', 0),
(67, '���������', 0, 0, 0, 0, NULL, '', '65', 0),
(68, '���������� ', 0, 0, 0, 0, NULL, '', '65', 0),
(69, '������ �� ������ ', 0, 0, 0, 0, NULL, '', '45', 0),
(70, '���', 0, 0, 0, 0, NULL, '', '45', 0),
(71, '�������', 0, 0, 0, 0, NULL, '', '45', 0),
(72, '�������, �����, �������', 0, 0, 0, 0, NULL, '', '45', 0),
(73, '��������, ������� ', 0, 0, 0, 0, NULL, '', '45', 0),
(74, '�������', 0, 0, 0, 0, NULL, '', '45', 0),
(75, '��������� ����� � ������� �����', 0, 0, 0, 0, NULL, '', '46', 0),
(76, '������', 0, 0, 0, 0, NULL, '', '46', 0),
(77, '�����, �������', 0, 0, 0, 0, NULL, '', '48', 0),
(78, '���', 0, 0, 0, 0, NULL, '', '48', 0),
(79, '����', 0, 0, 0, 0, NULL, '', '48', 0),
(81, '�������', 0, 0, 0, 0, NULL, '', '78', 0),
(82, '��������', 0, 0, 0, 0, NULL, '', '78', 0),
(83, '���� ', 0, 0, 0, 0, NULL, '', '78', 0),
(84, '��������� ', 0, 0, 0, 0, NULL, '', '78', 0),
(85, '�������', 0, 0, 0, 0, NULL, '', '78', 0),
(86, '��������', 0, 0, 0, 0, NULL, '', '78', 0),
(87, '���� ', 0, 0, 0, 0, NULL, '', '78', 0),
(88, '��������� ', 0, 0, 0, 0, NULL, '', '78', 0),
(89, '�������', 0, 0, 0, 0, NULL, '', '78', 0),
(90, '��������', 0, 0, 0, 0, NULL, '', '78', 0),
(91, '��������, ���������', 0, 0, 0, 0, NULL, '', '78', 0),
(92, '������', 0, 0, 0, 0, NULL, '', '78', 0),
(93, '� ������', 0, 0, 0, 0, NULL, '', '79', 0),
(94, '�����������', 0, 0, 0, 0, NULL, '', '79', 0),
(95, '�������', 0, 0, 0, 0, NULL, '', '79', 0),
(96, '���� ���������', 0, 0, 0, 0, NULL, '', '', 0),
(97, '��������', 0, 0, 0, 0, NULL, '', '96', 0),
(98, '������-����', 0, 0, 0, 0, NULL, '', '96', 0),
(99, '�������� �������', 0, 0, 0, 0, NULL, '', '96', 0),
(100, '������', 0, 0, 0, 0, NULL, '', '96', 0),
(101, '������� �������', 0, 0, 0, 0, NULL, '', '96', 0),
(102, '����', 0, 0, 0, 0, NULL, '', '96', 0),
(103, '������� ����� �� ����', 0, 0, 0, 0, NULL, '', '96', 0),
(104, '������� ����� �� ���� � ������������� ', 0, 0, 0, 0, NULL, '', '96', 0),
(105, '������� ����� �� �����', 0, 0, 0, 0, NULL, '', '96', 0),
(106, '�������', 0, 0, 0, 0, NULL, '', '96', 0),
(107, '�����', 0, 0, 0, 0, NULL, '', '96', 0),
(108, '�����', 0, 0, 0, 0, NULL, '', '96', 1),
(109, '�������', 0, 0, 0, 0, NULL, '', '96', 0),
(110, '�����', 0, 0, 0, 0, NULL, '', '96', 0),
(111, '��������', 0, 0, 0, 0, NULL, '', '96', 0),
(112, '����', 0, 0, 0, 0, NULL, '', '96', 0),
(113, '��������', 0, 0, 0, 0, NULL, '', '96', 0),
(114, '��������� � �������', 0, 0, 0, 0, NULL, '', '', 0),
(115, '������������� ��������', 0, 0, 0, 0, NULL, '', '114', 0),
(116, '��� ��� ����', 0, 0, 0, 0, NULL, '', '114', 0),
(117, '������������ �������� �������', 0, 0, 0, 0, NULL, '', '114', 0),
(118, '������� ������', 0, 0, 0, 0, NULL, '', '114', 0),
(119, '������ ������������ ����������', 0, 0, 0, 0, NULL, '', '114', 0),
(120, '�������� �������', 0, 0, 0, 0, NULL, '', '114', 0),
(121, '����������� �������', 0, 0, 0, 0, NULL, '', '114', 0),
(122, '������ ��� ��������', 0, 0, 0, 0, NULL, '', '114', 0),
(123, '���� �� ��������', 0, 0, 0, 0, NULL, '', '114', 0),
(124, '�������� ������', 0, 0, 0, 0, NULL, '', '114', 0),
(125, '�������� ���������', 0, 0, 0, 0, NULL, '', '114', 0),
(126, '������ ���', 0, 0, 0, 0, NULL, '', '114', 0),
(127, '������� � ��������', 0, 0, 0, 0, NULL, '', '114', 1),
(128, '������������ ��������', 0, 0, 0, 0, NULL, '', '114', 0),
(129, '������� �������', 0, 0, 0, 0, NULL, '', '114', 0),
(130, 'C����������� ������������ � ��������', 0, 0, 0, 0, NULL, '', '128', 0),
(131, 'C����������� ��������� �������', 0, 0, 0, 0, NULL, '', '128', 0),
(132, '�������� �� ��������� � ��������', 0, 0, 0, 0, NULL, '', '128', 0),
(133, '����������', 0, 0, 0, 0, NULL, '', '126', 0),
(134, '�������� ������', 0, 0, 0, 0, NULL, '', '124', 0),
(135, '������������', 0, 0, 0, 0, NULL, '', '124', 0),
(136, '�������� ��������', 0, 0, 0, 0, NULL, '', '122', 0),
(137, '��������������', 0, 0, 0, 0, NULL, '', '122', 0),
(138, '��������� ��������', 0, 0, 0, 0, NULL, '', '120', 0),
(139, '���������� � ����������� �������', 0, 0, 0, 0, NULL, '', '120', 0),
(140, '����������� � ����������� ����', 0, 0, 0, 0, NULL, '', '120', 0),
(141, '���������� � ����������� �������', 0, 0, 0, 0, NULL, '', '120', 0),
(142, '��� ��� ��������� �������', 0, 0, 0, 0, NULL, '', '118', 0),
(143, '��� ��� ������� ������', 0, 0, 0, 0, NULL, '', '118', 0),
(144, '��� ��� ����� ���������', 0, 0, 0, 0, NULL, '', '118', 0),
(145, '������� ���������', 0, 0, 0, 0, NULL, '', '118', 0),
(146, '������� � ����� ��� �������', 0, 0, 0, 0, NULL, '', '116', 0),
(147, '��� ��� �������� ���', 0, 0, 0, 0, NULL, '', '116', 0),
(148, '��������� ��� ���', 0, 0, 0, 0, NULL, '', '116', 0),
(149, '��������������� ��������', 0, 0, 0, 0, NULL, '', '127', 0),
(150, '������������', 0, 0, 0, 0, NULL, '', '127', 0),
(151, '����, ����� � �����', 0, 0, 0, 0, NULL, '', '127', 0),
(152, '������ �� ������� �������� ', 0, 0, 0, 0, NULL, '', '127', 0),
(153, '���� �� ��������', 0, 0, 0, 0, NULL, '', '127', 0),
(154, '���� �� ����� ����', 0, 0, 0, 0, NULL, '', '127', 0),
(155, '���� �� ����� ��� � ���', 0, 0, 0, 0, NULL, '', '127', 0),
(156, '���� �� ����� ����', 0, 0, 0, 0, NULL, '', '127', 0),
(157, '���� �� �������� ���', 0, 0, 0, 0, NULL, '', '127', 0),
(158, '���� (Avene)', 0, 0, 0, 0, NULL, '', '125', 0),
(159, '����� (Ahava)', 0, 0, 0, 0, NULL, '', '125', 0),
(160, '���� (Vichy)', 0, 0, 0, 0, NULL, '', '125', 0),
(161, '����� (Ducray)', 0, 0, 0, 0, NULL, '', '125', 0),
(162, '������ (Lierac)', 0, 0, 0, 0, NULL, '', '125', 0),
(163, '������ (Lusero)', 0, 0, 0, 0, NULL, '', '125', 0),
(164, '������� (Mustela)', 0, 0, 0, 0, NULL, '', '125', 0),
(165, '��� (Roc)', 0, 0, 0, 0, NULL, '', '125', 0),
(166, '�������� (Topicream)', 0, 0, 0, 0, NULL, '', '125', 0),
(167, '����� (Uriage)', 0, 0, 0, 0, NULL, '', '125', 0),
(168, '���� �������', 0, 0, 0, 0, NULL, '', '125', 0),
(169, '������ � ��������� �������', 0, 0, 0, 0, NULL, '', '123', 0),
(170, '����- � �������������, ������� ��������', 0, 0, 0, 0, NULL, '', '123', 0),
(171, '���������� � �������� ��� �������', 0, 0, 0, 0, NULL, '', '123', 0),
(172, '��������� �������������', 0, 0, 0, 0, NULL, '', '123', 0),
(173, '�������� ��� ����� �� ����� �������', 0, 0, 0, 0, NULL, '', '123', 0),
(174, '�����������', 0, 0, 0, 0, NULL, '', '121', 0),
(175, '�����������', 0, 0, 0, 0, NULL, '', '121', 0),
(176, '������ ����������� �������', 0, 0, 0, 0, NULL, '', '121', 0),
(177, '������ ��� �������', 0, 0, 0, 0, NULL, '', '121', 0),
(178, '���������', 0, 0, 0, 0, NULL, '', '121', 0),
(179, '����������� �������������� � ������', 0, 0, 0, 0, NULL, '', '119', 0),
(180, '������', 0, 0, 0, 0, NULL, '', '119', 0),
(181, '�������������� �������', 0, 0, 0, 0, NULL, '', '119', 0),
(182, '������������ ��������', 0, 0, 0, 0, NULL, '', '119', 0),
(183, '��������, ��������', 0, 0, 0, 0, NULL, '', '117', 0),
(184, '��� ������', 0, 0, 0, 0, NULL, '', '117', 0),
(185, '��� ������� ������������', 0, 0, 0, 0, NULL, '', '117', 0),
(186, '��� ������', 0, 0, 0, 0, NULL, '', '117', 0),
(187, '��� �������� ����', 0, 0, 0, 0, NULL, '', '117', 0),
(188, '����������������', 0, 0, 0, 0, NULL, '', '117', 0),
(189, '��� ������������', 0, 0, 0, 0, NULL, '', '117', 0),
(190, '��������, �������������', 0, 0, 0, 0, NULL, '', '115', 0),
(191, '����������', 0, 0, 0, 0, NULL, '', '115', 0),
(192, '��������������� ���������', 0, 0, 0, 0, NULL, '', '115', 0),
(193, '����������� �������� � �������', 0, 0, 0, 0, NULL, '', '115', 0),
(194, '���������', 0, 0, 0, 0, NULL, '', '115', 0),
(195, '������ ���������', 0, 0, 0, 0, NULL, '', '115', 0),
(196, '�������� �����', 0, 0, 0, 0, NULL, '', '115', 0),
(197, '��������� � ��������', 0, 0, 0, 0, NULL, '', '', 4),
(198, '�������� ���������', 0, 0, 0, 0, NULL, '', '197', 1),
(199, '������', 0, 0, 0, 0, NULL, '', '197', 3),
(200, '���������-����', 0, 0, 0, 0, NULL, '', '197', 0),
(201, '�������������. ������. ������', 0, 0, 0, 0, NULL, '', '', 0),
(202, '����������. �����������. �������������. ����� ������. ����� ������������, ������������ � ������� �������', 0, 0, 0, 0, NULL, '', '201', 0),
(203, '�����������. ��������������. ������. �����. ����������. ', 0, 0, 0, 0, NULL, '', '201', 0),
(204, '�����, ����������, �����������', 0, 0, 0, 0, NULL, '', '201', 0),
(205, '������������� �����', 0, 0, 0, 0, NULL, '', '201', 0),
(206, '�������������. ����������������', 0, 0, 0, 0, NULL, '', '201', 0),
(207, '����������. �����. �����', 0, 0, 0, 0, NULL, '', '201', 0),
(208, '������', 0, 0, 0, 0, NULL, '', '201', 0),
(209, '������', 0, 0, 0, 0, NULL, '', '201', 0),
(210, '������������. �������. ���������� �������������', 0, 0, 0, 0, NULL, '', '201', 0),
(211, '������������ ��� ������������', 0, 0, 0, 0, NULL, '', '201', 0),
(212, '������������, ������ ��� ��������� �������, ������, ����������� � ������������� ����������', 0, 0, 0, 0, NULL, '', '201', 0),
(213, '���������. ������������ ���������', 0, 0, 0, 0, NULL, '', '201', 0),
(214, '����. ������� �����������. ��������������� �����������', 0, 0, 0, 0, NULL, '', '201', 0),
(215, '���������� ���������. ����. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(216, '���������� ���������. �������. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(217, '���������� ���������. �����. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(218, '���������. ������������. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(219, '����. ������. ������ ������', 0, 0, 0, 0, NULL, '', '201', 0),
(220, '�������������', 0, 0, 0, 0, NULL, '', '201', 0),
(221, '��������. �˨���. ������������. �������', 0, 0, 0, 0, NULL, '', '201', 0),
(222, '������ ������������. ������������. �������. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(223, '������ ����������. ���������. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(224, '���������� ������ � ����������. �������������� �/� � �������.', 0, 0, 0, 0, NULL, '', '201', 0),
(225, '���������', 0, 0, 0, 0, NULL, '', '201', 0),
(226, '����������. ������������', 0, 0, 0, 0, NULL, '', '201', 0),
(227, '������. ������������ � ��������� ���������.', 0, 0, 0, 0, NULL, '', '201', 0),
(228, '������� ������������', 0, 0, 0, 0, NULL, '', '201', 0),
(229, '������� ����������� �������', 0, 0, 0, 0, NULL, '', '201', 0),
(230, '������� �������� ������������ � �������������', 0, 0, 0, 0, NULL, '', '201', 0),
(231, '��������� ������������. ��������� �������. ���������', 0, 0, 0, 0, NULL, '', '201', 0),
(232, '����������� ������. �����. �������.', 0, 0, 0, 0, NULL, '', '201', 0),
(233, '����������. �������� ������', 0, 0, 0, 0, NULL, '', '201', 0),
(234, '������. �������������', 0, 0, 0, 0, NULL, '', '201', 0),
(235, '�������� ���������', 0, 0, 0, 0, NULL, '', '201', 0),
(236, '������������ ������������. �������. ������. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(237, '�����������-�������� � ����������� �������. �������. ������. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(238, '������������� ���������������� ����������', 0, 0, 0, 0, NULL, '', '201', 0),
(239, '������������� �����. ������������� ����� ���������', 0, 0, 0, 0, NULL, '', '201', 0),
(240, '������������� ������, ����������, �����', 0, 0, 0, 0, NULL, '', '201', 0),
(241, '�����������- ��������� � ���������� ������ ������, ����������, �����', 0, 0, 0, 0, NULL, '', '201', 0),
(242, '����� ������������ �����', 0, 0, 0, 0, NULL, '', '201', 0),
(243, '���ܨ ��� ������������ ������������ ����������', 0, 0, 0, 0, NULL, '', '201', 0),
(244, '���������. �����������. ����� ���', 0, 0, 0, 0, NULL, '', '201', 0),
(245, '�������. ����. ���. ������', 0, 0, 0, 0, NULL, '', '201', 0),
(246, '������', 0, 0, 0, 0, NULL, '', '201', 0),
(247, '����������. ������� ����', 0, 0, 0, 0, NULL, '', '201', 0),
(248, '������������� ������. ������������', 0, 0, 0, 0, NULL, '', '201', 0),
(249, '������. ������. �����', 0, 0, 0, 0, NULL, '', '201', 0),
(250, '����������������', 0, 0, 0, 0, NULL, '', '201', 0),
(251, '�������������. �����������������. ������������� ����', 0, 0, 0, 0, NULL, '', '201', 0),
(252, '����������������. ������������', 0, 0, 0, 0, NULL, '', '201', 0),
(253, '���������� ��������������', 0, 0, 0, 0, NULL, '', '201', 0),
(254, '������', 0, 0, 0, 0, NULL, '', '', 0),
(255, '�����. ������������ �����������', 0, 0, 0, 0, NULL, '', '254', 1),
(256, '������. �������. �����. �����. ��������', 0, 0, 0, 0, NULL, '', '254', 0),
(257, '������ ����������� � �������������', 0, 0, 0, 0, NULL, '', '254', 0),
(258, '���������, ������� �������. ���ܨ. �������� . ������', 0, 0, 0, 0, NULL, '', '254', 0),
(259, '������������� ���������. ������������ �����. ������', 0, 0, 0, 0, NULL, '', '254', 0),
(260, '��������. ������. ���������� �������', 0, 0, 0, 0, NULL, '', '254', 0),
(261, '������ ��� ����. ����������-��������� ����������. ��������� ���������� ����������', 0, 0, 0, 0, NULL, '', '254', 0),
(262, '������ ��������. ����������. ������. ������� �������', 0, 0, 0, 0, NULL, '', '254', 0),
(263, '���������� ���������. ����. ������', 0, 0, 0, 0, NULL, '', '254', 0),
(264, '���������� ���������. �������. ������', 0, 0, 0, 0, NULL, '', '254', 0),
(265, '���������� ���������. �����. ������', 0, 0, 0, 0, NULL, '', '254', 0),
(266, '����. ������. ������ ������', 0, 0, 0, 0, NULL, '', '254', 0),
(267, '������ ������������. ������������. �������. ������', 0, 0, 0, 0, NULL, '', '254', 0),
(268, '����������. ������������', 0, 0, 0, 0, NULL, '', '254', 0),
(269, '���������. �����������. ����� ���. ������� ��� ���� � �����', 0, 0, 0, 0, NULL, '', '254', 0),
(270, '�������� � ������� ������������. ������. �����', 0, 0, 0, 0, NULL, '', '254', 0),
(271, '����������������. ������������', 0, 0, 0, 0, NULL, '', '254', 0),
(272, '���������', 0, 0, 0, 0, NULL, '', '', 0),
(273, '������������', 0, 0, 0, 0, NULL, '', '', 16),
(274, '�����������', 0, 0, 0, 0, NULL, '', '273', 0),
(275, '���������� �������', 0, 0, 0, 0, NULL, '', '273', 16)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_pricepay`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_pricepay` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `edit_about` int(11) NOT NULL,
  `edit_maps` int(11) NOT NULL,
  `edit_skidnews` int(11) NOT NULL,
  `edit_price` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `edit_prior` int(11) NOT NULL,
  `edit_www` int(11) NOT NULL,
  `edit_banner` int(11) NOT NULL,
  `edit_bronir` int(11) NOT NULL,
  `col_photo` int(11) NOT NULL,
  `col_rubrik` int(11) NOT NULL,
  `col_vak` int(11) NOT NULL,
  `col_tov` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_firm_pricepay` (`id`, `edit_about`, `edit_maps`, `edit_skidnews`, `edit_price`, `name`, `edit_prior`, `edit_www`, `edit_banner`, `edit_bronir`, `col_photo`, `col_rubrik`, `col_vak`, `col_tov`, `price`) VALUES
(1, 0, 1, 1, 1, '��������', 1, 1, 1, 1, 2, 1, 3, 4, 50),
(4, 1, 0, 1, 1, '�������', 1, 1, 0, 1, 2, 1, 3, 4, 122)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_srcheck`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_srcheck` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_firm_srcheck` (`id`, `name`, `alt_name`) VALUES
(1, '�� 150�.', ''),
(2, '150�.-400�.', ''),
(3, '400�.-800�.', ''),
(4, '800�.-1500�.', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_groups`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_groups` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `group_colour` varchar(40) NOT NULL DEFAULT '',
  `offline` tinyint(1) NOT NULL DEFAULT '0',
  `post_edit` tinyint(1) NOT NULL DEFAULT '0',
  `post_del` tinyint(1) NOT NULL DEFAULT '0',
  `topic_set` tinyint(1) NOT NULL DEFAULT '0',
  `topic_edit` tinyint(1) NOT NULL DEFAULT '0',
  `topic_del` tinyint(1) NOT NULL DEFAULT '0',
  `vote` tinyint(1) NOT NULL DEFAULT '0',
  `flood` char(1) NOT NULL DEFAULT '0',
  `html` tinyint(1) NOT NULL DEFAULT '0',
  `filter` tinyint(1) NOT NULL DEFAULT '0',
  `youtube` tinyint(1) NOT NULL DEFAULT '0',
  `flash` tinyint(1) NOT NULL DEFAULT '0',
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_forum_groups` (`group_id`, `group_colour`, `offline`, `post_edit`, `post_del`, `topic_set`, `topic_edit`, `topic_del`, `vote`, `flood`, `html`, `filter`, `youtube`, `flash`) VALUES
(1, 'red', 1, 1, 1, 1, 1, 1, 1, '1', 1, 1, 1, 1),
(2, 'blue', 0, 1, 1, 1, 1, 1, 1, '0', 0, 0, 0, 0),
(3, 'green', 0, 1, 1, 1, 0, 0, 1, '1', 0, 1, 0, 0),
(4, 'black', 0, 1, 1, 0, 0, 0, 1, '1', 0, 1, 0, 0),
(5, '', 0, 0, 0, 0, 0, 0, 0, '0', 0, 0, 0, 0)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_forum_titles`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_forum_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posts` int(11) NOT NULL DEFAULT '0',
  `title` varchar(128) NOT NULL DEFAULT '',
  `pips` varchar(128) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_forum_titles` (`id`, `posts`, `title`, `pips`) VALUES
(1, 0, '�������', '1')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_foto_conkurs`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_foto_conkurs` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `date_start` varchar(25) NOT NULL DEFAULT '',
  `date_end` varchar(25) NOT NULL DEFAULT '',
  `foto_limit` smallint(4) NOT NULL DEFAULT '0',
  `us_max` smallint(4) NOT NULL DEFAULT '0',
  `voting` tinyint(1) NOT NULL DEFAULT '0',
  `guest` tinyint(1) NOT NULL DEFAULT '0',
  `mod_off` tinyint(1) NOT NULL DEFAULT '0',
  `send` tinyint(1) NOT NULL DEFAULT '0',
  `wm` tinyint(1) NOT NULL DEFAULT '0',
  `comm_off` tinyint(1) NOT NULL DEFAULT '0',
  `d_size` varchar(8) NOT NULL DEFAULT '0',
  `d_t_site` tinyint(1) NOT NULL DEFAULT '0',
  `p_size` varchar(7) NOT NULL DEFAULT '0',
  `p_t_site` tinyint(1) NOT NULL DEFAULT '0',
  `alt` tinyint(1) NOT NULL DEFAULT '0',
  `cols` smallint(3) NOT NULL DEFAULT '0',
  `rows` smallint(3) NOT NULL DEFAULT '0',
  `us_comm_off` tinyint(1) NOT NULL DEFAULT '0',
  `gallary` tinyint(1) NOT NULL DEFAULT '0',
  `off` tinyint(1) NOT NULL DEFAULT '0',
  `temp_head` text NOT NULL,
  `temp_head_win` text NOT NULL,
  `temp_main` text NOT NULL,
  `temp_user` text NOT NULL,
  `temp_other` text NOT NULL,
  `desc` varchar(255) NOT NULL DEFAULT '',
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_music_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_music_category` (
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

$tableSchema[] = "INSERT INTO `" . PREFIX . "_music_category` (`id`, `parentid`, `posi`, `name`, `alt_name`, `icon`, `skin`, `descr`, `keywords`, `news_sort`, `news_msort`, `news_number`, `short_tpl`, `full_tpl`, `setlinks`) VALUES
(1, 0, 1, 'Blues', 'blues', '', '', '', '', '', '', 0, '', '', ''),
(2, 0, 1, 'Classic Rock', 'classic-rock', '', '', '', '', '', '', 0, '', '', ''),
(3, 0, 1, 'Country', 'country', '', '', '', '', '', '', 0, '', '', ''),
(4, 0, 1, 'Dance', 'dance', '', '', '', '', '', '', 0, '', '', ''),
(5, 0, 1, 'Disco', 'disco', '', '', '', '', '', '', 0, '', '', ''),
(6, 0, 1, 'Funk', 'funk', '', '', '', '', '', '', 0, '', '', ''),
(7, 0, 1, 'Grunge', 'grunge', '', '', '', '', '', '', 0, '', '', ''),
(8, 0, 1, 'Hip- Hop', 'hip-hop', '', '', '', '', '', '', 0, '', '', ''),
(9, 0, 1, 'Jazz', 'jazz', '', '', '', '', '', '', 0, '', '', ''),
(10, 0, 1, 'Metal', 'metal', '', '', '', '', '', '', 0, '', '', ''),
(11, 0, 1, 'NewAge', 'newage', '', '', '', '', '', '', 0, '', '', ''),
(12, 0, 1, 'Oldies', 'oldies', '', '', '', '', '', '', 0, '', '', ''),
(13, 0, 1, 'Other', 'other', '', '', '', '', '', '', 0, '', '', ''),
(14, 0, 1, 'Pop', 'pop', '', '', '', '', '', '', 0, '', '', ''),
(15, 0, 1, 'R&B', 'rb', '', '', '', '', '', '', 0, '', '', ''),
(16, 0, 1, 'Rap', 'rap', '', '', '', '', '', '', 0, '', '', ''),
(17, 0, 1, 'Reggae', 'reggae', '', '', '', '', '', '', 0, '', '', ''),
(18, 0, 1, 'Rock', 'rock', '', '', '', '', '', '', 0, '', '', ''),
(19, 0, 1, 'Techno', 'techno', '', '', '', '', '', '', 0, '', '', ''),
(20, 0, 1, 'Industrial', 'industrial', '', '', '', '', '', '', 0, '', '', ''),
(21, 0, 1, 'Alternative', 'alternative', '', '', '', '', '', '', 0, '', '', ''),
(22, 0, 1, 'Ska', 'ska', '', '', '', '', '', '', 0, '', '', ''),
(23, 0, 1, 'Death Metal', 'death-metal', '', '', '', '', '', '', 0, '', '', ''),
(24, 0, 1, 'Pranks', 'pranks', '', '', '', '', '', '', 0, '', '', ''),
(25, 0, 1, 'Soundtrack', 'soundtrack', '', '', '', '', '', '', 0, '', '', ''),
(26, 0, 1, 'Euro-Techno', 'euro-techno', '', '', '', '', '', '', 0, '', '', ''),
(27, 0, 1, 'Ambient', 'ambient', '', '', '', '', '', '', 0, '', '', ''),
(28, 0, 1, 'Trip-Hop', 'trip-hop', '', '', '', '', '', '', 0, '', '', ''),
(29, 0, 1, 'Vocal', 'vocal', '', '', '', '', '', '', 0, '', '', ''),
(30, 0, 1, 'Jazz+Funk', 'jazzfunk', '', '', '', '', '', '', 0, '', '', ''),
(31, 0, 1, 'Fusion', 'fusion', '', '', '', '', '', '', 0, '', '', ''),
(32, 0, 1, 'Trance', 'trance', '', '', '', '', '', '', 0, '', '', ''),
(33, 0, 1, 'Classical', 'classical', '', '', '', '', '', '', 0, '', '', ''),
(34, 0, 1, 'Instrumental', 'instrumental', '', '', '', '', '', '', 0, '', '', ''),
(35, 0, 1, 'Acid', 'acid', '', '', '', '', '', '', 0, '', '', ''),
(36, 0, 1, 'House', 'house', '', '', '', '', '', '', 0, '', '', ''),
(37, 0, 1, 'Game', 'game', '', '', '', '', '', '', 0, '', '', ''),
(38, 0, 1, 'Sound Clip', 'sound-clip', '', '', '', '', '', '', 0, '', '', ''),
(39, 0, 1, 'Gospel', 'gospel', '', '', '', '', '', '', 0, '', '', ''),
(40, 0, 1, 'Noise', 'noise', '', '', '', '', '', '', 0, '', '', ''),
(41, 0, 1, 'Alternative Rock', 'alternative-rock', '', '', '', '', '', '', 0, '', '', ''),
(42, 0, 1, 'Bass', 'bass', '', '', '', '', '', '', 0, '', '', ''),
(43, 0, 1, 'Punk', 'punk', '', '', '', '', '', '', 0, '', '', ''),
(44, 0, 1, 'Space', 'space', '', '', '', '', '', '', 0, '', '', ''),
(45, 0, 1, 'Meditative', 'meditative', '', '', '', '', '', '', 0, '', '', ''),
(46, 0, 1, 'Instrumental Pop', 'instrumental-pop', '', '', '', '', '', '', 0, '', '', ''),
(47, 0, 1, 'Instrumental Rock', 'instrumental-rock', '', '', '', '', '', '', 0, '', '', ''),
(48, 0, 1, 'Ethnic', 'ethnic', '', '', '', '', '', '', 0, '', '', ''),
(49, 0, 1, 'Gothic', 'gothic', '', '', '', '', '', '', 0, '', '', ''),
(50, 0, 1, 'Darkwave', 'darkwave', '', '', '', '', '', '', 0, '', '', ''),
(51, 0, 1, 'Techno-Industrial', 'techno-industrial', '', '', '', '', '', '', 0, '', '', ''),
(52, 0, 1, 'Electronic', 'electronic', '', '', '', '', '', '', 0, '', '', ''),
(53, 0, 1, 'Pop-Folk', 'pop-folk', '', '', '', '', '', '', 0, '', '', ''),
(54, 0, 1, 'Eurodance', 'eurodance', '', '', '', '', '', '', 0, '', '', ''),
(55, 0, 1, 'Dream', 'dream', '', '', '', '', '', '', 0, '', '', ''),
(56, 0, 1, 'Southern Rock', 'southern-rock', '', '', '', '', '', '', 0, '', '', ''),
(57, 0, 1, 'Comedy', 'comedy', '', '', '', '', '', '', 0, '', '', ''),
(58, 0, 1, 'Cult', 'cult', '', '', '', '', '', '', 0, '', '', ''),
(59, 0, 1, 'Gangsta', 'gangsta', '', '', '', '', '', '', 0, '', '', ''),
(60, 0, 1, 'Top 40', 'top-40', '', '', '', '', '', '', 0, '', '', ''),
(61, 0, 1, 'Christian Rap', 'christian-rap', '', '', '', '', '', '', 0, '', '', ''),
(62, 0, 1, 'Pop/Funk', 'popfunk', '', '', '', '', '', '', 0, '', '', ''),
(63, 0, 1, 'Jungle', 'jungle', '', '', '', '', '', '', 0, '', '', ''),
(64, 0, 1, 'Native US', 'native-us', '', '', '', '', '', '', 0, '', '', ''),
(65, 0, 1, 'Cabaret', 'cabaret', '', '', '', '', '', '', 0, '', '', ''),
(66, 0, 1, 'NewWave', 'newwave', '', '', '', '', '', '', 0, '', '', ''),
(67, 0, 1, 'Psychadelic', 'psychadelic', '', '', '', '', '', '', 0, '', '', ''),
(68, 0, 1, 'Rave', 'rave', '', '', '', '', '', '', 0, '', '', ''),
(69, 0, 1, 'Showtunes', 'showtunes', '', '', '', '', '', '', 0, '', '', ''),
(70, 0, 1, 'Trailer', 'trailer', '', '', '', '', '', '', 0, '', '', ''),
(71, 0, 1, 'Lo-Fi', 'lo-fi', '', '', '', '', '', '', 0, '', '', ''),
(72, 0, 1, 'Tribal', 'tribal', '', '', '', '', '', '', 0, '', '', ''),
(73, 0, 1, 'Acid Punk', 'acid-punk', '', '', '', '', '', '', 0, '', '', ''),
(74, 0, 1, 'Acid Jazz', 'acid-jazz', '', '', '', '', '', '', 0, '', '', ''),
(75, 0, 1, 'Polka', 'polka', '', '', '', '', '', '', 0, '', '', ''),
(76, 0, 1, 'Retro', 'retro', '', '', '', '', '', '', 0, '', '', ''),
(77, 0, 1, 'Musical', 'musical', '', '', '', '', '', '', 0, '', '', ''),
(78, 0, 1, 'Rock & Roll', 'rock-roll', '', '', '', '', '', '', 0, '', '', ''),
(79, 0, 1, 'Hard Rock', 'hard-rock', '', '', '', '', '', '', 0, '', '', ''),
(80, 0, 1, 'Folk', 'folk', '', '', '', '', '', '', 0, '', '', ''),
(81, 0, 1, 'Folk-Rock', 'folk-rock', '', '', '', '', '', '', 0, '', '', ''),
(82, 0, 1, 'National Folk', 'national-folk', '', '', '', '', '', '', 0, '', '', ''),
(83, 0, 1, 'Swing', 'swing', '', '', '', '', '', '', 0, '', '', ''),
(84, 0, 1, 'Fast Fusion', 'fast-fusion', '', '', '', '', '', '', 0, '', '', ''),
(85, 0, 1, 'Bebob', 'bebob', '', '', '', '', '', '', 0, '', '', ''),
(86, 0, 1, 'Latin', 'latin', '', '', '', '', '', '', 0, '', '', ''),
(87, 0, 1, 'Revival', 'revival', '', '', '', '', '', '', 0, '', '', ''),
(88, 0, 1, 'Celtic', 'celtic', '', '', '', '', '', '', 0, '', '', ''),
(89, 0, 1, 'Bluegrass', 'bluegrass', '', '', '', '', '', '', 0, '', '', ''),
(90, 0, 1, 'Avantgarde', 'avantgarde', '', '', '', '', '', '', 0, '', '', ''),
(91, 0, 1, 'Gothic Rock', 'gothic-rock', '', '', '', '', '', '', 0, '', '', ''),
(92, 0, 1, 'Progressive Rock', 'progressive-rock', '', '', '', '', '', '', 0, '', '', ''),
(93, 0, 1, 'Psychedelic Rock', 'psychedelic-rock', '', '', '', '', '', '', 0, '', '', ''),
(94, 0, 1, 'Symphonic Rock', 'symphonic-rock', '', '', '', '', '', '', 0, '', '', ''),
(95, 0, 1, 'Slow Rock', 'slow-rock', '', '', '', '', '', '', 0, '', '', ''),
(96, 0, 1, 'Big Band', 'big-band', '', '', '', '', '', '', 0, '', '', ''),
(97, 0, 1, 'Chorus', 'chorus', '', '', '', '', '', '', 0, '', '', ''),
(98, 0, 1, 'Easy Listening', 'easy-listening', '', '', '', '', '', '', 0, '', '', ''),
(99, 0, 1, 'Acoustic', 'acoustic', '', '', '', '', '', '', 0, '', '', ''),
(100, 0, 1, 'Humour', 'humour', '', '', '', '', '', '', 0, '', '', ''),
(101, 0, 1, 'Speech', 'speech', '', '', '', '', '', '', 0, '', '', ''),
(102, 0, 1, 'Chanson', 'chanson', '', '', '', '', '', '', 0, '', '', ''),
(103, 0, 1, 'Opera', 'opera', '', '', '', '', '', '', 0, '', '', ''),
(104, 0, 1, 'Chamber Music', 'chamber-music', '', '', '', '', '', '', 0, '', '', ''),
(105, 0, 1, 'Sonata', 'sonata', '', '', '', '', '', '', 0, '', '', ''),
(106, 0, 1, 'Symphony', 'symphony', '', '', '', '', '', '', 0, '', '', ''),
(107, 0, 1, 'Booty Bass', 'booty-bass', '', '', '', '', '', '', 0, '', '', ''),
(108, 0, 1, 'Primus', 'primus', '', '', '', '', '', '', 0, '', '', ''),
(109, 0, 1, 'Porn Groove', 'porn-groove', '', '', '', '', '', '', 0, '', '', ''),
(110, 0, 1, 'Satire', 'satire', '', '', '', '', '', '', 0, '', '', ''),
(111, 0, 1, 'Slow Jam', 'slow-jam', '', '', '', '', '', '', 0, '', '', ''),
(112, 0, 1, 'Club', 'club', '', '', '', '', '', '', 0, '', '', ''),
(113, 0, 1, 'Tango', 'tango', '', '', '', '', '', '', 0, '', '', ''),
(114, 0, 1, 'Samba', 'samba', '', '', '', '', '', '', 0, '', '', ''),
(115, 0, 1, 'Folklore', 'folklore', '', '', '', '', '', '', 0, '', '', ''),
(116, 0, 1, 'Ballad', 'ballad', '', '', '', '', '', '', 0, '', '', ''),
(117, 0, 1, 'Power Ballad', 'power-ballad', '', '', '', '', '', '', 0, '', '', ''),
(118, 0, 1, 'Rhytmic Soul', 'rhytmic-soul', '', '', '', '', '', '', 0, '', '', ''),
(119, 0, 1, 'Freestyle', 'freestyle', '', '', '', '', '', '', 0, '', '', ''),
(120, 0, 1, 'Duet', 'duet', '', '', '', '', '', '', 0, '', '', ''),
(121, 0, 1, 'Punk Rock', 'punk-rock', '', '', '', '', '', '', 0, '', '', ''),
(122, 0, 1, 'Drum Solo', 'drum-solo', '', '', '', '', '', '', 0, '', '', ''),
(123, 0, 1, 'Acapella', 'acapella', '', '', '', '', '', '', 0, '', '', ''),
(124, 0, 1, 'Euro-House', 'euro-house', '', '', '', '', '', '', 0, '', '', ''),
(125, 0, 1, 'Dance Hall', 'dance-hall', '', '', '', '', '', '', 0, '', '', ''),
(126, 0, 1, 'Goa', 'goa', '', '', '', '', '', '', 0, '', '', ''),
(127, 0, 1, 'Drum & Bass', 'drum-bass', '', '', '', '', '', '', 0, '', '', ''),
(128, 0, 1, 'Club-House', 'club-house', '', '', '', '', '', '', 0, '', '', ''),
(129, 0, 1, 'Hardcore', 'hardcore', '', '', '', '', '', '', 0, '', '', ''),
(130, 0, 1, 'Terror', 'terror', '', '', '', '', '', '', 0, '', '', ''),
(131, 0, 1, 'Indie', 'indie', '', '', '', '', '', '', 0, '', '', ''),
(132, 0, 1, 'BritPop', 'britpop', '', '', '', '', '', '', 0, '', '', ''),
(133, 0, 1, 'Negerpunk', 'negerpunk', '', '', '', '', '', '', 0, '', '', ''),
(134, 0, 1, 'Polsk Punk', 'polsk-punk', '', '', '', '', '', '', 0, '', '', ''),
(135, 0, 1, 'Beat', 'beat', '', '', '', '', '', '', 0, '', '', ''),
(136, 0, 1, 'Christian Gangsta', 'christian-gangsta', '', '', '', '', '', '', 0, '', '', ''),
(137, 0, 1, 'Heavy Metal', 'heavy-metal', '', '', '', '', '', '', 0, '', '', ''),
(138, 0, 1, 'Black Metal', 'black-metal', '', '', '', '', '', '', 0, '', '', ''),
(139, 0, 1, 'Crossover', 'crossover', '', '', '', '', '', '', 0, '', '', ''),
(140, 0, 1, 'Contemporary C', 'contemporary-c', '', '', '', '', '', '', 0, '', '', ''),
(141, 0, 1, 'Christian Rock', 'christian-rock', '', '', '', '', '', '', 0, '', '', ''),
(142, 0, 1, 'Merengue', 'merengue', '', '', '', '', '', '', 0, '', '', ''),
(143, 0, 1, 'Salsa', 'salsa', '', '', '', '', '', '', 0, '', '', ''),
(144, 0, 1, 'Thrash Metal', 'thrash-metal', '', '', '', '', '', '', 0, '', '', ''),
(145, 0, 1, 'Anime', 'anime', '', '', '', '', '', '', 0, '', '', ''),
(146, 0, 1, 'JPop', 'jpop', '', '', '', '', '', '', 0, '', '', ''),
(147, 0, 1, 'SynthPop', 'synthpop', '', '', '', '', '', '', 0, '', '', '')";

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

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rating_kat`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rating_kat` (
  `nom` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kat` varchar(80) NOT NULL,
  `main_id` varchar(5) NOT NULL,
  `all` int(3) NOT NULL,
  PRIMARY KEY (`nom`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_rating_kat` (`nom`, `kat`, `main_id`, `all`) VALUES
(1, '�����������', '', 11),
(2, '��������', '', 0),
(3, '�������', '', 0),
(4, '�������', '1', 1),
(5, '������', '1', 10),
(6, '�������� ����������', '', 0),
(7, '��������', '', 0),
(8, '�������', '', 0),
(9, '����', '2', 0),
(10, '��������', '2', 0),
(11, '����������� � ��������', '', 0),
(12, '�����������', '', 0),
(13, '���������', '', 0),
(14, '������ ������', '', 0),
(15, '�����', '', 0),
(16, '�����������', '', 0),
(17, '��������', '', 0),
(18, '���', '', 0),
(19, '����', '18', 0),
(20, '������', '', 0),
(21, '���. ����������', '', 0),
(22, '���. ��������', '', 0),
(23, '��������', '', 0),
(24, '������', '', 0),
(25, '�������� ���', '0', 0)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rss_afisha`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rss_afisha` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `allow_main` tinyint(1) NOT NULL DEFAULT '0',
  `allow_rating` tinyint(1) NOT NULL DEFAULT '0',
  `allow_comm` tinyint(1) NOT NULL DEFAULT '0',
  `text_type` tinyint(1) NOT NULL DEFAULT '0',
  `date` tinyint(1) NOT NULL DEFAULT '0',
  `search` text NOT NULL,
  `max_news` tinyint(3) NOT NULL DEFAULT '0',
  `cookie` text NOT NULL,
  `category` smallint(5) NOT NULL DEFAULT '0',
  `lastdate` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rss_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rss_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `osn` int(10) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `kanal` tinyint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_rss_afisha` (`id`, `url`, `description`, `allow_main`, `allow_rating`, `allow_comm`, `text_type`, `date`, `search`, `max_news`, `cookie`, `category`, `lastdate`) VALUES
(2, 'http://feeds.feedburner.com/afisha_msk_cinema', '����� ����', 1, 1, 1, 1, 0, '<table class=\"job_table\">{get}</table>', 2, '', 0, '1372934580')";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_rss_category` (`id`, `osn`, `title`, `kanal`) VALUES
(1, 0, '�������������', 1)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_rss_obj`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_rss_obj` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `allow_main` tinyint(1) NOT NULL DEFAULT '0',
  `allow_rating` tinyint(1) NOT NULL DEFAULT '0',
  `allow_comm` tinyint(1) NOT NULL DEFAULT '0',
  `text_type` tinyint(1) NOT NULL DEFAULT '0',
  `date` tinyint(1) NOT NULL DEFAULT '0',
  `search` text NOT NULL,
  `max_news` tinyint(3) NOT NULL DEFAULT '0',
  `cookie` text NOT NULL,
  `category` smallint(5) NOT NULL DEFAULT '0',
  `lastdate` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_rss_obj` (`id`, `url`, `description`, `allow_main`, `allow_rating`, `allow_comm`, `text_type`, `date`, `search`, `max_news`, `cookie`, `category`, `lastdate`) VALUES
(5, 'http://rabota.mail.ru/rss/searchvacancy.xml?orderBy=2&itemsOnPage=100&areaId=3&vacancyNameField=true&professionalAreaId=2&compensationCurrencyCode=RUR&searchPeriod=30', '����� ����� - ������������ - �����������', 1, 1, 1, 1, 1, '<html>{get}</html>', 127, '', 3334, ''),
(3, 'http://rabota.mail.ru/rss/searchvacancy.xml?orderBy=2&itemsOnPage=100&areaId=3&vacancyNameField=true&professionalAreaId=1&compensationCurrencyCode=RUR&searchPeriod=30', '����� ����� - ������������', 1, 1, 1, 1, 0, '<table class=\"job_table\">{get}</table>', 127, '', 3338, '1322034046'),
(6, 'http://rabota.mail.ru/rss/searchvacancy.xml?orderBy=2&itemsOnPage=100&areaId=3&vacancyNameField=true&professionalAreaId=3&compensationCurrencyCode=RUR&searchPeriod=30', '����� ����� - ������������ - ���������', 1, 1, 1, 1, 1, '<html>{get}</html>', 127, '', 3341, ''),
(7, 'http://rabota.mail.ru/rss/searchvacancy.xml?orderBy=2&itemsOnPage=100&areaId=3&vacancyNameField=true&professionalAreaId=5&compensationCurrencyCode=RUR&searchPeriod=30', '����� ����� - ������������ - ���������������', 1, 1, 1, 1, 1, '<html>{get}</html>', 127, '', 1005, ''),
(8, 'http://rabota.yandex.ru/rss.xml?rid=52&amp;currency=RUR&amp;text=&amp;job_industry=275', '����� ����� - ������������ - ��������� ������', 1, 1, 1, 1, 1, '<td class=\"content\">{get}</td>', 127, '', 3354, '1321905600')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_style`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `valid` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(1, '2-Step/British Garage (Speed Garage)', '���� ����� ��� ������ �� ���� ����������� ��������� �������������� garage techno ���� ������ ��������� ������, ���������� ������� � ������ � ��������� � ����������� ������� drum''n''bass. British Garage �������� �� ������� ����� ������� � 1996 �., ��������� �������� ������ �������� ������� ������������ � ��������, �������� ����������� jungle/drum''n''bass, ��� �������� ������������ ����� ����� 90-�. � ������ ����� ������ �������� ���� ����� ��� �������� ��� speed garage, underground garage � 2-step. ����� ����� ��� ������� ������������ ����������, ����� ��� Todd Edwards, Armand Van Helden � Romanthony. ����� ���������� � ������� ����� ������, ��� Tuff Jam, Dream Team � RIP, - ��� ���������� ������������ ������� ����, ��������� �� ������� ����� ������� ���-�����. � 1998 �����, ������� ����� ��� �������� ��� speed garage, ����������������� � ����� ������� �� ���������� �����. ������ �� ��������� ����������� � ������������� �������� ������ R&B � ������� ����������� breakbeats. ����� ��������� �������� ���������� (������� MJ Cole, Zed Bias, Wookie � Sunship, � ����� ����������������� ���� ������, ����� ��� Tuff Jam, Dream Team � Artful Dodger) � ������� ����������������� �������� (Locked On, Nice ''N'' Ripe, Quench, Grand Theft Audio, Naughty), - ����� �������� ����������� ��������� � ����� ������� � ���������������� dance. ���� � �� �����, ����� ���� ��� \"Destiny\" (Dem 2) � \"Movin'' Too Fast\" (Artful Dodger) �������� ������� ������ � ���-�������, � �������� ����������� �������� ��������, ������� ��������� ������������ ���������� ��������� ������ � ������� ��������� �����.'),
(2, 'IDM', '������� ������, ��������������� ��� ����������� ����������� ������ 90-� �����, ������� ����� ��������� ������ �������������� �� �������� � � �������� ��������. �� �������� ����� IDM (Intelligent Dance Music) � ������������ ������� �������� ���������� ����������� ����� ������������ ���������� � �������, �������� ��������� ������ ���� ������, ������ �� ��� ������������� ������������ ������ ��� ���. ����������� � ����� 80-� �����, ���� ���� ����� �� ��������� �������� dance, �������������� � �������� � ���������� ��������� � ���������������� ������� �������, ���� downtempo.����� DJs, ��� Mixmaster Morris � Dr. Alex Paterson ��������� Chicago house, ������ ��������������� pop/new wave � ambient, ������� ��������� ����� ����� ����������, ������������� ������� ������������� ����������� ����������. (� ��� ���� ������ DJs � ��������� ����� ������������ ������ �������� �������� ���������� ���������� ������������ ������ �� ������� ����� ����� \"Pump Up the Jam\" �� ������� Technotronic � \"Sesame''s Treat\" �� Smart E''s.) ����������������� �������� Sheffield''s Warp Records �������� � ������� ��������������� ����� ����� �� ����� ���� ������������ ������� �� ������ Warp ��� ��������� Artificial Intelligence ���������� ���������� �� ����� ���� � ��� ������� ��������� ������������ � ���� �����: Aphex Twin, the Orb, Plastikman, Autechre, Black Dog Productions � B12. ������ ������� ����������������� �������� Rising High, GPR, R&S, Rephlex, Fat Cat, Astralwerks ����� ������ ������ ������������� IDM, ���� � �������� 90-� ����� ����������� ������ � ����� electronica, ������������ ��� ����������, ����������� ������ � ���������� ������������� � ������� ����������. ��� ���������� �����������, ������������ �����, �������� ������� ����� ����� ����������� � ������������� ������ ��� IDM, � � ����� 90-� ����� ������� �������� ������ ������� ���� ����� ��� ������ � ����������� � ���� �����, ������� Beat, Isophlux, Suction, Schematic � Cytrax. �������� �� ������ ������� ������������� ����� (������ Warp ���������� ������ \"electronic listening music\" , �  Aphex Twin ����������� �� \"braindance\"), ����� IDM ��������� �������� �������� ��� ������� ��������� ���� ������ ��������� ������������.\r\n'),
(3, 'Illbient', '������� �������� ����� ����� �������� New York City ( � ����������� Brooklyn). ����� illbient ��� ����� ���������� � ����������� ����������� ��������� ����� ����������� ������, ����������� �������� ���������� ������������ � ����� ������ ����� �����������. ������� ������������ DJ Spooky (��������, ������������ ���� �����), ����������� ������� � ����� Illbient � ����������� ����� ������ �� ������ ambient, �� ����� �������� ( � ��������) dub, hip-hop � drum''n''bass, ���� ������ ���������� ������, ������� ����� ����������� �� ����� ������������ ������� � �������������. ������������ �����������, ���������������� � ����� �������� ����� �����, illbient ����� ���� ������� � ������� �������� ��� ���������������  � ����������� � ���. �� ����� ������ ����������� ��� ����������� ���� � �������� ��������. ���� � ����� ��� ����������� � ����� illbient ����� ���������� � ��������, ��� ��� ������ ������ ���������� ��������� ������� ��������� ��������, ��� ������� �� �������� �������������� (� ����������������) ������� ������. ����������� ����� Brooklyn  ����� �������� ��������� ��������� ����������� ������� � ����� �����, ��� �������� � ������ ���������, ��� �������, ��� � ������������� ���������. ����������������� �������� The Asphodel � WordSound ���������� ����������� ����������� �������� illbient, ������ �� ��� �������� �������� ������� ��� ��������� Incursions in Illbient, ��� ������� ���������� DJ Spooky, We, Byzar � Sub Dub. ����� ������ ������� illbient ����� ������� Tipsy, Spectre, Rob Swift � Badawi.\r\n'),
(4, 'Indie Electronic', '����-�����\r\n'),
(5, 'Industrial Drum''n''Bass', '������ �� �������� ������������� �������������� ������ �� ��������� heavy metal, ��������� ��������� ������ ��������� �������������� shock-terrorism � ������������ ����������������� ����� ������, ��� jungle � techno. � ������������ � ����������� �������������� ������� �������� ������ Front 242, Cabaret Voltaire, Skinny Puppy ������� ���������� ��������� ����������� ������������ ������, ��� ����� ���������� ������� ����� ��������������� ��������, ��������� ��������������� �� ���������� ����������.\r\n'),
(6, 'Jazz-House', '�������� ������ house � jazz � �������� ���������, ������� ������ ����������, ������ ����� ������, ��� ��� ����� ���������� ����������� ������� jazz, ��� ��� ���������� ���������� ����� ������ � ����� house, �����-���� ���������� � ����. ������ ������ ������ Jazz-House ���������� ����������� ����������, - �� �������� �������� �������� ��������� � ����������� ��������� (Swayzak, Herbert, Kevin Yost, Jazzanova) �� ������� ������������� ����������� � �������� ���� (Innerzone Orchestra, St. Germain, Spacetime Continuum, As One). Jazz-House - ��� ������ ���������� �����������, ��������� ����� ��������� �������������������, �������� � ���� ������ house/techno � ambient/���������������� ����������� ������. Larry Heard, ������ ������� house ��������, ��� ����� ������, ��� ������� � ���� ���������� �������� �������� ������ � ���������. ��������, ��������� ��� ����������� �������, ������� ���������� � ������� ����������� ����� ������������ ����� �� ����� �������� ��������, ��� Miles Davis, Herbie Hancock � Lonnie Liston Smith.  ����� �������, ��� ������� ��������� � ������� �������� ����������� jazz-house ������� ���������� ������ Nuphonic Records, ��� ������������ ���-�������� (Blaze, Ten City, Joe Claussell), ��������� (Free Chicago Movement, Roy Davis, Jr.) � �������� ��������� (Natural Calamity), � ����� ��������� �������� (Black Jazz Chronicles, Faze Action, Soul Ascendants, Idjut Boys).\r\n'),
(7, 'Jazz-Rap', '����� Jazz-Rap ��� �������� ��������� ������ ����-������������ ������ ������� ����������� � ����� ������������ ������ ����������, ��� ��������� �� ������ ���� � ������� ����� ����� � ������ ������� ����� �����, � ����� ��������� ��������� �������. ����� ��� ����� jazz-rap ���� ��������� ������������ �� hip-hop, �� ������ � �������� �������� � �������� ������ �� ����� ����������� ������, ��� cool jazz, soul-jazz � hard bop. ���� ����� ��� ����� ������ � ���������� ����� ������ ����������� hip-hop, � ������ ����������� ��������������� ����-������������ ������������ ��������, �������� ����� ����� ������������ �������������. �������� �� �������� ���������������� ����� ����� �����������, �� �����������, ��� jazz-rap ������� �� ���� ��������� ������� �������, �� ����� �� ���� ����� � �� �����. ���� ������������� Jazz-rap �������� ���� ������������ ����� ���������� ������������ �������� hardcore/gangsta, ������������ ���������� ������� rap � ������ 90-�. ��� ����� ��������� �������������� hip-hop ����� ����������, ������� �� ����� ������� ��� ������ �������� �������� ��������� ����������� ��������. ����� �������, jazz-rap ����� ������� ����� ����� ����������� � ������������ ����������, � ����� ������������� ����� ����� �������� � �������� white alternative rock. ������� Native Tongues (Afrika Bambaataa) ���� ������������������� ���-�������� ���������, ��������� �� ����-������������ rap ����� ���� ������ �����, �������������� ����� jazz-rap, ������� ����� ������, ��� A Tribe Called Quest, De La Soul � the Jungle Brothers. ����� ���������� �����������, ��������� ���� ����������, ������ ���� Digable Planets � Gang Starr. � �������� ����� 90-� �����, ����� alternative rap ���� ����������� �� ������� ���������� ���������, jazz-rap �� ����� ���������� ��������� ������ ��������, ������, ������� the Roots ����� ��������� ��� � ����� ���������������� hip-hop ����������.\r\n'),
(8, 'Jungle/Drum ''N Bass', '���������������� ����� ��������� �� ��������������, ����� Jungle (����� ��������� ��� ��������� drum''n''bass) ��� ������������ hardcore techno, ����������� � ������ 90-� �����. Jungle ��� ����� ��������� �������� ���� ��������� ���� techno, ���������� �� ���� ����� ������� polyrhythms � breakbeats. ������, ��� ��������� ���������������� ������ ��� ��������� ����� ������� ����� ����� hardcore techno � ������� ������ �� ������� ������ ��������� � ��������� ����. ��� ������������� �������� �����, jungle ����� ����� ��������� ������� �� ������� ����� (reggae), dub � R&B, ��� ����������� ����������� hardcore. ������� ��������� ������� �������, ��� ��� ������ ����� ��������� ���������� techno ���������� � DJs, ������� ���������� ���� ��� ������, ����� �� � ����� ���������� � DJs, �������������� � ������ hardcore. ��� �� �����, jungle ������� �� �������� �������, ����� ����� ��-�������� ���������� �� ������ ���������� ����. ��� ����������� techno ������, jungle - ��� ������ ����� ��������� ����, ��������������� ��� ��������� ���������, ���� ������� ����� Goldie � ��� �������� ������ Timeless � 1995�. ������������ ������� �������� ���������� ������� � �������� ����������� �����������, �� ��������� � ������� ������� techno. ������� ��������� ���������� ����������� ���� �����, �������� ��������� breakbeats � ���������� jazz, ������� �� �����������, ambient � trip-hop.\r\n'),
(9, 'Latin Rap', '����� Latin Rap ��������� � hip-hop � rap, �������������� ������-������������� �����������. ��� ����� ������ rap ��-��������� ��� ��-��������, � � ������ ����� ������������ ������� ���������� ��������� ������.'),
(10, 'Left-field House', '��������� ������ Left-field house ����� ��������� ������������ �� ������� ���� ���� �� ������� ��� ������������� ��� ����� (deep house), ����������� ��� �� 4/4 ��������� ���������, ��� �� ������ ���������, ��� ������� �� ����. � ����� Left-field house ��� ������������� ������, ������� ���-���� ����� ������������� ���. ��� ����� ���� ���������� � ������ ��� � Theo Parrish, ��������� �������� ����� ������������ ������ BPMs � ������ �� ������������� �������� ������, ��� ����� �������� ����� 4/4 ����. ���� ����� ����� ����������� �� House, �� R&B � ������� ����������� ���������, ������� ����� Metro Area, ������� ��������� ��������� ������� ���������� ���� 4/4. ��� ���� ����� ����� ���� ��������� ���������������� � ���������� ������� Herbert, ��������� � ����������� �������� ������ ��������� ��� ���������� (�� ���������������� �� �������-�����������, ��������� �� �������� ������ �� ������������� ������� ����������).'),
(11, 'Lounge', 'Lounge ������, ��� ��������� ������� ������, ������� ����� ���� �������� �� ������ ������, �� ������� �� ��������, ��� ������������� � ������ BPM, ��������� ������������� � ��������� ����������. Lounge ������ ������ ����������� �� ���� ������ ���� � DJ-�����.\r\n'),
(12, 'Microhouse', 'Microhouse, ���������� DJ Philip Sherburne � 2001 ���� � ������ The Wire, ��� ��������, ������ ���� ����������� ���������������� � ������������ ������� �������� ����������, ������ � ������� � ���� ������ ����� �� ������ � ��������, ��� � � deep house ����������, ������������ �� anthemic hooks � ����������� �����. �� ���� � ���� ������, �������� microhouse ����� ����� ����� deep house � minimal techno. ������� ��������� ���������� ���� �������, � �� ����� ��� ����������� � ��������� �������� ������� (deep house) ���� ��������; ���� ��������� �� ��������, microhouse ���� ����� �� ������������ techno, \"������ - ������ ��������, ��������� �������� ���������� ��������� ��� �����. ������ ����� ��������� ������ �� ������ ����� �������� � �������������� ��� ������ ����� \"�������\", ������������ �� �������������� �������� � ������������� ������ ����������. � ����� 90-�� � � ������ 2000-��, ���������� �������� ��������� ��������� �������, ������������ �� ���� �����. ������������ ������� ������ ���������� microhouse ��������� ������, ������� Playhouse (Isol�e, Losoul), Kompakt (Sascha Funke, M. Mayer) � Klang Elektronik (Farben). ������ ������ - Force Tracks (Luomo, MRI), Perlon (Ricardo Villalobos, Pantytec) �  Trapez (Akufen, M.I.A.).\r\n'),
(13, 'Minimal Techno', '����� house � techno ������� ��������� � ������� ����������� ������� � �������� 80-� �����, ������ �������� ���� ������� � ��������. �� ���� ����������� �������� ��������� ������������� � ����������������, ������ ����������� ����� ������������ � ���������������� ������ ��� ��������� ��� ����� ��������� ������, ��� ������ - �������� ���������� ������. � ����� �� �������� ������ ������������ ������������p ������ Minimalist Techno ���������� ����������� ��� ����� �� ����������� ���������� ���������� �������� � ������������� ��� ������������ ������. ����� ����������� ���������, ��� Jeff Mills � Plastikman ���������� �����������, � ������� ����������� Surgeon, Oliver Ho � Stewart Walker, ����� ���������� � ����� ����� ������.\r\n'),
(14, 'Neo-Electro', '�1995�. ���������� ����� �� ��������� ������� ��������� ���������� ������������ ������� � �������������, �������� �� ������ ������� � �����������. ��� �������������� ����������� ������������� �������� electro (������ ����� ����������� � ������ 80-�). ���� ������� �������� ������� �������� ������ �����, ����� ��� Afrika Bambaataa, the Egyptian Lover, Newcleus, ��, ��� �� �����, ������� ������� �� ����� ����������� ����� electro ������� ��������� �������� �������. ��������� �� ��������, ����� ��� Drexciya, Underground Resistance � Ectomorph ������ ������������ �� electro, � �������� ���������� ������� Drexciya � ��������� 1994�.  ������������ ������� ������������� �� ������ ������� ���������. � �������� ����������������� �������� Clear Records ���������� ���� �������������� ������� �������� �� ����� ������, ��� Jedi Knights, Tusken Raiders, Plaid � Gescom (����� ��� ��� ��������� ��� ������������, � �������� ������� ����������� ���������� ������������ �����, ������� Global Communication � Autechre). ���� ����������� electro � �������� ������ ������ ���������� ������ ����� �� ����������, ������������ ������ ���������� ���������� (�������� �� ������ Clear), � ����� �� ������ ������� �������, ����� ��� Skam, Musik Aus Strom � Dot. ��� ��� �������� ����� �� ������� ����� � ������� ����� ���������������� ������ � ������� ������� ������� electro.'),
(15, 'New Jack Swing', 'New Jack Swing �������� � ����� 80-� �����, ����� ��������� � ����� urban contemporary soul ����� ��������� � ������ ���������� hip-hop �����, ������, � ������ ��������� ������. ��������� ���������� ������ �������� hip-hop ���, ������ ������� ������� � ��������, ��, � �����, ��������� ��� ���� ����� �������, ������� ����, ��������� ����������� � ���� ���������� �������� soul � ����� rap. ���� ���� �������� ������ � ��������� ������ soul � 90-� ����, ����� �������� ����� rap � R&B ����������� ��������.\r\n'),
(16, 'Newbeat', '���� ����� ���� ������������ �������� �������� (���� �������� �� �������� ������������� ����������� ������). Newbeat �������� � ����� 80-� �����, ��� ����� ����������� � ������� ����� �� ����������� acid house. �� ��� �������� ������� �������, ��� Detroit techno, ��� Eurodance. ������� �������� newbeat ����� �������, ��� ��� ��������� ���������� ����� ������ ����������������� �������� ��� R&S � Antler-Subway ������ �����, ������������ newbeat \"I Sit on Acid\" (� ������ �� �������), ���������� Lords of Acid �� ��� ����� ������������� ��������� �����, ������� ��� ������������ �� ��������� ������, �� ��� ���� ��������� ������������ � ������������ ��������. ���������� ����� ������� the KLF � 1990-91 ��. ������� ���� ����� �� ����� ��� ��������� �����. �� ����� �� ����� �� ����������� ���������, ���� ����� ����� ������ ��������. ���� ��������� �� Antler-Subway � Lords of Acid ������� ����� ���������� �������������� ����� ���� � ������� � ��� �����, �� R&S ��������� ��������� � �������� ����������� dance, ����� � �������� trance � ambient techno.'),
(17, 'Night Driving', '���� �����'),
(18, 'Nu Breaks', '������� ������������ ����� ���������� �������� � ����� 90-�, ��������� �������� techno � drum''n''bass, � ����� ��������� ��������� ������� rave. Nu Breaks ���������� ����� ��������� � DJs ��� �������� Adam Freeland, Dylan Rhymes, Beber, Freq Nasty � Rennie Pilgrem, � ����� ��������� ����������, ���, ��������, BT. �� ����� drum''n''bass ��� �������������� two-step breakbeats � ������ �������, �� techno ������ ������� ������ � ������������ �������, � �� ������� rave/hardcore 90-� ����� - ��������� ������������ � ����� ( � ������ � ���������� ������), ������� �� ���� ������ ��� ������ ����. Freeland ���� �� ����� ��������� ������������ nu breaks (�������� ����� ����, ��� ����������� ���������� ������������������ �� ������� �������), ����� ������ � ����� rock, ����� ��� Coastal Breaks � Tectonics ��������� ����� � ������������ ������� �� ���� ����.\r\n'),
(19, 'Obscuro', 'Obscuro - ��� �������������� ���������, ������������ ��� ������������������, ����������, ���������� � �� ����������� ������������� ����� ������, � ������� �� ������� � �� �������. ��� ��������� ��-�������, ��� ������, ��������� ������ ������� ������������ ���� ����� �� ����� �� ������ ��� ��������. ������ � ����� Obscuro ����� ������� ��������� ��� ������ ����-��� ����; ��� ����� ���������� ���������, ��� ���������� �� ����� ������, � �� �����, ������� ��� �� ������ �� �������. ��� ������ ����� ������� � ��������� ������������� � ����������� �������� ����������� ������������ ��� � ��������� �������������� ��������. � ���� ����� ����������� ����� ����������� ������, ������� ����� ������������� � ����� ���������, �������� ���������� ����, ��� ����� ��������� ����� ����� ������� ��� ������. ����� obscuro ���� ��������������� � ��� �����, ��� �������� ��������� ������� ��������� ���������� ��� ������������������ � offbeat ������������������� � ��������� ������. �������� ��� �������� ����������� exotica � space-age pop (�� ������� �������� ��� �������������), � ����� ����� ������ ��� psychedelia, progressive rock � experimental (�����: avant-garde) rock. ���� ������ obscuro �� ����������� �������� ������������� � �������� ��� ��������� (�������� ��� �������), �� �������� �� Re/Search ��� ���������� Incredibly Strange Music, Vols. 1 and 2 (� �������������� �� �����) ������������ �������, ��� � ����������� ��������� �������� ��������� �� ������ Arf! Arf!.\r\n'),
(20, 'Old School Rap', 'Old School Rap - ���� ����� ������������ ����� �������� rap �����������, ������� ���� ��������� �� New York City � ����� 70-� ������ 80-� �����. Old school (������ �����) ����� ���������� �� ��������� ����������� ����� ������������ ���������� ����� ����������� ����� �������� �������� ���������� �����, � ������� ����� ����� �������� ����������� �� ���� ����� ����������. ��������� (��������� ������) ������ ����� �������� �� ���, � ����� ������ �� ���������, �� ��� �� �������, - ���� ������������ � ����������� ������� ��� �������� ���������� (������������). �������� ������ ������� �� �� ���������� ������� ������, � ������ �� ������ ������ ������� ��� ���� ������� �� ��������� ���������� ������� Grandmaster Flash, ������� ����������� ��������� ��������� rap ������. ����������� ��������� � ����� old school rap ����� ������� � �������� ������� ��������� ��������� � ��������, ��� �� ����������. ���������������� �������� ���������� �����, ����� old school rap �������� ���� �������� ����� ��� �������� �������� ����, ������ ����� �� ���� ������� �������� ������, ��� Grandmaster Flash & Furious Five ��� Sugarhill Gang. ��������� ���������� old school �������� � ������ disco ��� funk, � ������ ���� ���������� �������������� �������������� (��������� ��� ������, � rap ��� ��� ����, ��� �������� ��� ��������� electro). ������� ���������� �������� � ����� Old school rap ���������� � 1979 �. � ���������� ���� ������� �� Fatback \"King Tim III\" � Sugarhill Gang \"Rapper''s Delight,\" ���� ��� �������� ����������� �� ����� ����������� 10 ���. ������ Sugarhill Records ������ ����� ������� ����� old school rap � ������������ �� ����� ����������� �� ���� �������, ���� � 1983-84 ����� Run-D.M.C. �� ���� ���� ����� � �������� ������� �������� � �� ����� ��������� ����������� hardcore urban. �� ���� � ����� ������ ��������� �������� rap ������������, ��������� ������� ���������� old school � funk �������� 70-� � ����� �����������. ��� ��������� � ������������ ������� � ���������� ������������ modern-day rap ��� ���� � hip-hop (������� ����� � ���� ����� ��� ����� 10 ��� ����� \"Rapper''s Delight\") ����������� old school rap ����� �������� ���������� � ������� �����. ������ ������ ����� old school ���������� ����, ��� ����� ������ ������ ��� ��������� ��� ����������� �� ����� ���, � ������� �� �����. ��� �����������, �������� �� �������� �� ������� �������� ����������� ��������.\r\n'),
(21, 'Party Rap', 'Party Rap - �������, ������ hip-hop, ������������ ������� �������� �������� ����������� �����. ���������, ������������������ ������, ��� ������������� ���������, ��������� ����������� hardcore rap, ���� ��������� ���� ���������� �� old school rap. ������ ����� �����, �� ��������� ������ ������, ��� ���������� ���� � ��������. ��� ����������� ����� ������� � ������� Miami bass, �� ������ � ����������� ����� ��������� ���� ������������ ��������� �������� ���, ��������, \"Da Dip\" ��� ��� � \"Rump Shaker\" ������� ������ ��� ������ ��������������.'),
(22, 'Political Rap', '������� ��������� ������, �������� ������ ��������� ��������� � ����� old-school rap, � ����� �������� �������� ������ �������������, ��������� � inner-city blues (��������� ���� � ������ 80-� �����), - ��������� hip-hop ������ ������ ������� ����� ���� � ������������ ��������� ��� �������� ������ rap �����. ����� �������, ��� Last Poets � Gil Scott-Heron, Public Enemy, ������������� � 70-� ���� ������������� ��������� ������, ����� ������� ����������� ����� political rap �����. ����� ����� ����������� Chuck D ����� ����� ������ ����� ���� �������, ��������� �������� ������������� (� ����������� \"Black Steel in the Hour of Chaos,\" \"Fight the Power\"). � ����� ���������� �� ����� ��������� � ����� �����, ��� �������� ����� ������� (\"Rebel Without a Pause,\" \"Burn Hollywood Burn\") � ������������� ���������-������������ ���������� (\"911 Is a Joke,\" \"Night of the Living Baseheads\"). ����� �������, ��� Bomb Squad, KRS-One � ��� ������ Boogie Down Productions ����� ������ ����������� ���� ������, ��������� �������� �������� � �������� � ������� ������. �������� ����� ������ ���������� \"Illegal Business\" (���������� ������) � \"Stop the Violence\" (���������� �������), ������� ������������ ���������� � ���������� � ������� ������������������ ����.\r\n\r\n��, ��� ������� �������� ����������� ������ ��� �������� ����������� ��������, �� ����� ���� ��������� ����� �������������. Public Enemy ����� � ��������� ����� 1991�., � �������� �� ������� ���������� ������ ������� �� ������ ��������� ������������ ������� (Poor Righteous Teachers, Paris, X-Clan, Disposable Heroes of Hiphoprisy), ������������ ������������� � ����� ������ hip-hop ����������� gangsta rap ��� G-funk ������� ����������������� �������� ����� ��������� � ��������� ����� �������� ������.\r\n'),
(23, 'Pop-Rap', 'Pop-Rap ������ hip-hop ���� � rap � ������ ���������� �����������, ������� ������ �������� ������ ������� ������ (������) � ��������� ����������� pop-����������. Pop-rap ����� ��������� � �������� ������������� � ��������� ���������� �������� �� ��������� � ������� hip-hop, ���� � ��������-����� 90-� �����, ��������� ��������� ��������� ���� ����� � hardcore ����������, ������� ������������� ������������� ������� ������� ������������ �������� � ��������������� �� ������. ����� Pop-rap ��������� � ����� 80-� �����, ����� ����� �����������, ��� Run-D.M.C., L.L. Cool J � Beastie Boys ������ �������� �� �������� ����������� �����. ������ ����� ����� ����� ������, ��� Tone Loc, Young MC, DJ Jazzy Jeff � Fresh Prince �������� ��������� ������� � �������� �� �� ������������ ������������ �� ����� ����������� ��������� �������, ��� � ����� �������� �� ��������� ������ � ������. �� ������� ����������� ������ ���������, �������� ����� ��� ���������� ������ ������� ��� ���������. ��� ��� ����������� ��������� �������� ������ ����������� ���� ����� ��������, �� ������ ��������� � ��� ����� ������ ��������� ����� rap � R&B � ������������ �������. ��� ������������ ������ ��� �������� �������. � ���������� � 1990 �. MC Hammer � Vanilla Ice, ����������� pop-rap ����� ������������ ��������� (� ������ ���� ������������ �������� ��������������) �� ������� ��������� ������ ��������� �����, �� ����� � ��� ������� ������������ ���������, ��� ������ �� �� �������. ����� ������ �� ������ ������������ ��������� ��������� ����� �����, ��� ��� ������ ��������� 90-� ���������� ���������� ���������� ������� ���-�������, �������� ��� ���� ���� ����������� �������� (PM Dawn, Naughty by Nature, House of Pain, Arrested Development, Coolio, Salt-N-Pepa, Sir Mix-a-Lot � �. �.). ��� �������� ����� G-funk, ������������� Dr. Dre � Puff Daddy''s Hammer ���������� ��������� ����������� ���� �������� pop-����� 80-� �����, ��� � ������� ����� ������������, ��� gangsta � hardcore ��������� �� ������ ������ ������. � ����� 90-� ����� � ����� pop-rap ������������ ���������, �� ������� ������� ������� gangsta � hardcore, � ����� �����������, ����������� rap � urban soul.'),
(24, 'Progressive Electronic', 'Progressive Electronic ���������� �� ��� ���������� ����������� ����������. �����, ������� ����������, ����� ������� ��������������� ����������. ������ ����, ����� ������������ ��� ������������� ������������ �����, ����� ���������� �� � ������� �����������, ��� ����������� ����� ��������� ������������ ������������ ������, ������ �� ������������� ���������. �������� ������� � ���� ����� ����� ������� ���� ����������� ����� (� ����������������� ������������� �������� ������, ������� ���� � ������������ �������������). � ������������� ������������������� ������, ����������� ������ ������� ���� � ��������� ��������. ������������ ����������� � ������ ��������� ������� �������������� ����� ������������, ������������ ��� ������ �������, ������� ��������� ��������� ����� ��������� � ������� ������ �� �����������. � ������ ������ ��� ������ ��������� ����� ���� �������������, �����������, �������� � �������. � ������ ������, ������� progressive electronic ����������� ���������� ��� �� ����������� ������, �������� ������ � ���� ��������� ��������� �������������.'),
(25, 'Progressive House', '������ � ����� House ����� ��������� ������������ � ����� 80-� (������ ����� � ��������������), � ����� ���� ��� ��������� ������ house ����� ����� ������������������ ����� �����, ������� ��� ���� ��������� ������ ����������� � ���������� ������, ������������� � ������ � ����� �����������. ����� ��� �  ambient, techno � trance, ����� �� ����� ����������� ������ � ������ 90-� ������ ��� ������� ������ � ������� ���������������� �����������. ��������� ��� house ���������� ������ ��������� � ������ ����� house. ��� ������������ ��������� ������� ��-������ �������� ������������� �������� ������. �������� �������� ��������� ��������� techno house � ������� �������� �� ������� New York garage, ��� Chicago acid house, ������������ ����� ( � ����� ������ ���������� ����� ��������) Leftfield, the Drum Club, Spooky � Faithless. ���� �� ���������� ��������, ������ ������ ������� ������� �� ������ ����� ������ ����, ��� ������� �����. ��������� ��������� � ����� Progressive House ����������� �������� ����������, ���, ��������, Leftfield''s Leftism, Spooky''s Gargantuan � the Drum Club''s Everything Is Now. � �������� 90-�, ������� progressive house ����� ��������� ����������� �������� ������� ������ house.\r\n')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(26, 'Progressive Trance', '���� ����������� progressive house �������� ��� ����� ���������� �������� house �� ������ ������� �� ��������, ������������� ����� trance ���������� �������� ��������� � ���������� ���������������� � �������� �������������� ����������� ������, ��� ��� ������������� trance ������� �� ������� �� ������ ����� ����������� � ������. ����������� ������ �������� Eurodance ��� house (������ ������ ������������ Jean-Michel Jarre, ��� Basement Jaxx), � ����� ����������� ����������� Progressive Trance ����� ������� ������������ �������� �� ���� ����. ������� ���������� ���������������� ��������� � ������������� ���������� ����������������� ������������ (beat-mix). �� progressive trance ������������� ����� �������������� DJs (Oakenfold, Tong, Sasha) � ����������������� � ���������� ���������� ������ (Gatecrasher, Cream, Ministry of Sound, Home). ���� ��������� � ����� progressive trance ����� �������� ����� ������, ��� ������� ������ �� ����� Tong ��� �������� �� � ��������� ������ ������ �� Sasha, �� ��������� (� ������ Paul Van Dyk � Hybrid) ������ ������ ��������� ������ ������ ��������. John Bush\r\n'),
(27, 'Psychedelic', '����� Psychedelic Rock �������� � �������� 60-� �����, � �������, ����� British Invasion � folk-rock ������� ������ ��������� �������� ������� �� ������. ������ ���� ����� ������������ ���� �������� � ����������� ��������� ������-������-������ ������� �� rock & roll, ��� ������ ����� ������ � ������������ ����� ��������� ����� � ��������� �����. ����� ���� ����� ��, ��� ������ ������ �������� � ���� ���������� �������� ���������, ��������� ������ � ���������� jazz. ��� ����� ���������� ��������� ��������� ������������ � ��������������� ������������ ������������� � �������. ������� � 1965 1966 ��. ����� ������, ��� Yardbirds � Byrds ������� ��� ������� ��� �������� ���������� (psychedelia), �������� �������� ���� ����� (fuzz-toned), ����� � ����������� ������. ������ ������ ������ ����� �� �� ������, ������� Beatles � Rolling Stones. ��� ��� ������ ���������� ����� psychedelia � 1966 �. � ��� ����� ��������� ����� �� ����� �������� ��������� ����� ������������ ����������� ������ �����, ������� ���� ����� �����. � ��������������, ����� psychedelia ���� ��������� ���� ������������� � ���������������. ��� �� �����, ����� ������ ��� Pink Floyd � Traffic ������ ��������������� ���������������� ����������, ������� ����� �� ������ ������������, ��� �� ��� � �� ������������ ������������ Grateful Dead, Doors, Love � Jefferson Airplane. � ������ �������� ������� , garage ������ ������ ������ psychedelic rock �� �������� ��� ���� ����� ������������������, ������������ ������ �������� � ����� 3-���������� rock ��� ������ ���������� ���� distortion, feedback � ��������. � ����� ������, psychedelic ����������� � acid rock, heavy metal � art rock, �� ����������� � ����������� psychedelia ����� ���� ��������� ������ �����������, �������� � ������������ underground �������� 80-�.\r\n'),
(28, 'Psychedelic Pop', '����� Psychedelia ���� �������� � ����� underground � �������� 60-� �����, � ��� ����������� ������ ����������� �������, �� ������ ���� ����������� ����������. �� ��� �� ����������� ����� ������� ����� ����, ��� ���� ����� ������������ Beatles � Revolver (1966 �.), ����� ����� ��� ������ ������ �������. ���, ��� psychedelic ������ ������� ������� ������� � ����������, ����������� Psychedelic Pop � �������� ������������ ��� ������� � ������������ �� ��� �������� ����� pop ����������. ��������������� ������� ����������� � ������� ����������� ������������ � ����������� �����, fuzz guitars, ������������� ��������, ���-����� � ���� �������� ������� Beach Boys. �� ��� ����������� � �����-�� �����, �� ����� ��������, ��� ��� ������ ����� ������� ��������� ���������� � �������, ������� �� ���� ������� ������������. ����� �� �������, ���������� psychedelic pop ������������ �� ������, �� ������������ ���������������� ������� �����, ��� Sagetterius, ��� ����� psychedelia ����������� ���� � ����������. ��� ���� ������������� ������� ������� Beach Boys, �� ��� �� ����������, ��� ������� � ����� (����� �� ���������� Lemon Pipers \"Green Tambourine.\"). ���������� �������� ���������� pop ���������, ����� psychedelic pop ������� ������ ���������� �� ����������� �����, ��� psychedelia. �� �������������� �� ������ 70-� �����, ��� ���� �� ���� �������. ��� ����� ������� ��, ��� ��������� ������ � ����� psychedelic pop �������� ������� �������, ��� ������� psychedelia. ������ The Moth Confesses �� ������� the Neon Philharmonic (1969 �.), ������������ ������������, ������ ��������� ��������� ��������� psychedelia � pop ��������, �������� ����� ������ ���� ��������.\r\n'),
(29, 'Psychedelic/Garage', 'Garage Rock ��� �������, �������������� ������ rock & roll, ������� ������� ��������� ������������ ������ � �������� 60-� �����. �������������� ������� ����� ������ ������� British Invasion, ��� Beatles, Kinks � Rolling Stones. ��� ������ �������� ������ ������ �������� �� ���� British Invasion rock. ��� ��� ������ ��� ���� ������� � ������������������ ���������, �� ���������� ����� ������������ �� ��������� � �������, �� ������ ��� ������������ ������������� �����. ����������� ����� ������ ������ �� ������������ �����, ����� �� ���� ��� �������, ������ ������ �� ������� ����� � ��������� ������� �����. � ������� ������� ������� � ����� garage ��������� ������ ����� punk ������� ������ ���� ���. ����� �� ���� ������� ����� ���������� ����� garage �����, � ������������ �� �����, ������� Shadows of Knight, Count 5, Seeds, Standells, ���������� ��������� ����, � ��������� ���� ��������� ��������������. �� ����� ����, ����������� ��� ��� ������ ���� ������ ��� � ������ 70-� �����, �� ������� ���������� Nuggets (���������) �������� �� �����. � 80-� ����� ����������� ��������� ����������� ����� garage rock, ������� �������������� ����� ����� ����������� �����, ������� �������� ����� �������������� ����, ����� � ������� ��� garage ������ 60-� �����.\r\n\r\n������ ����� Garage ������������ ����� � �������� ����������� Psychedelic Rock. ����� Psychedelic Rock �������� � �������� 60-� �����, � �������, ����� British Invasion � folk-rock ������� ������ ��������� �������� ������� �� ������. ������ ����, ����� ������������ ���� �������� � ����������� ��������� ������-������-������ ������� �� rock & roll, ��� ������ ����� ������ � ������������ ����� ��������� ����� � ��������� �����. ����� ���� ������� , ��� ������ ������ �������� � ���� ���������� �������� ���������, ��������� ������ � ���������� jazz. ��� ����� ����������� ��������� ��������� ������������ � ��������������� ������������ ������������� � �������. ������� � 1965 1966��. ����� ������, ��� the Yardbirds � the Byrds ������� ��� ������� ��� �������� ���������� (psychedelia), �������� �������� ���� ����� (fuzz-toned), ����� � ����������� ������. ������ ������ ������ ����� �� �� ������, ������� the Beatles � the Rolling Stones. ��� ��� ������ ���������� ����� psychedelia � 1966�. � ��� ����� ��������� ����� �� ����� �������� ��������� ����� ������������ ����������� ������ �����, ������� ���� ����� �����. � ��������������, ����� psychedelia ���� ��������� ���� ������������� � ���������������. ��� �� �����, ����� ������ ��� Pink Floyd � Traffic ������ ��������������� ���������������� ����������, ������� ����� �� ������ ������������, ����� ��� � �� ������������ ������������ the Grateful Dead, the Doors, Love � Jefferson Airplane. � ������ �������� ������� , garage ������ ������ ������ psychedelic rock �� �������� ��� ���� ����� ������������������, ������������ ������ �������� � ����� 3-��������� rock ��� ������ ���������� ���� distortion, feedback � ��������. � ����� ������, psychedelic ����������� � acid rock, heavy metal � art rock, �� ����������� � ����������� psychedelia ����� ���� ��������� ������ �����������, �������� � ������������ underground �������� 80-�.\r\n'),
(30, 'Quiet Storm', '�1975�. Smokey Robinson �������� ������ � ����������� ������� ��������� ��� �������� A Quiet Storm, ���� ����� ������������� adult soul ����������. �� �������� ���� ������ ��� �������� ������ ������������ ����� � ����� ��������, ������� ���������� ��������� ������� ����������. Quiet Storm ����� ����� ��� ������� �� ������� ������� Marvin Gaye Let''s Get It On, ����������������� soul Philly � ������ ���������� Al Green. � ��������� ������ ��������� quiet storm ����� ������� R&B �� ������� ����� �����������, ��� soft rock � adult contemporary. ���� quiet storm � �������� �������������� ��� ���������� �����������, �� ������� ����� �� ������������ ���������, ������������� ������ � �������������� �������������. ������ ���� ����� ����� ��������� ���������� ������������� � ���������� ������������� �������, ������� ����������� �������� �� ������������� ����� ����� �� R&B. ��������� ����������� ���������������� ���� ���������� ������ �� ���� �����, �� ����������� ���������� ���������� ������ ������� ������ � ���������� � ���������� ��������, ������� ��������� ��� ������ ����� ������. Quiet storm ��������� ���������� � ����� 70-� ����� �� ������ 90-�, ����� R&B ������� ������� hip-hop �������, - � � ���������� ����� quiet storm �� �������� ������� ����� ��������������.\r\n'),
(31, 'Ragga', '����� Ragga ��������� � reggae , ��� ������������ ������� ��������������� ������ (��� ������ ������������� ����������� �����������) � �������� �������. ���� ����� ��������������� ������������� � ���������, � ��� ��� �� �� ����������� dancehall reggae �������� ����������� (� ������� ragga ���� �� ��������), �� � ���� ���� ������ ����� ������. \"Ragga\" - ��� ���������� �� \"raggamuffin,\" ���������� ���� ������ ������������� ��� ����������� ���������� �� ����� Kingston. � ������ ��� ����� ��������� � ��������� ������������ ����� ������ ��������� ��������-����� 80-� �����. ���������� ������������ ������ ���� �� �������� ������������� ������, ����� ragga ����� �������� ������������ ������ �������� ��������� � �����������. ��� ��������� �� ��������� ������ ������� � ��� � ����������� ����� ���������� ����� ����� ������ ����, ����� ������ ������������ �������� �� ������ rock ����������. ��� ����� �������� �� ����� �������� ����� ��������� �������� (\"rhythm album\"), ��� ������ ��������� ���������� ����������� ����� � ������� �� ���� � ��� �� �������� ����. ���� ������ ����������� ����� ragga � ����������� ��-�����, ��������� ����������� ����� �������� ������� � ������������� � Rastafarian �����������, - � ��� ��������� ����� �������� ����� ����������� ���� � ������. ������ ������ � ����� ragga ����������� Wayne Smith � ��� ������� \"Under Me Sleng Teng\" (1985 �.), ������� �������� �������� King Jammy. ���� ����� �������� �� �����, ������� ��� ������ � �������� �� ��������� Casio. ������� ��� ����������, ��� ����� ������� ��������� ������������, � ��� Jammy ����������� �� ��������� ����� � ������ ������������ ��������� � ��������� ������. � 90-� ����, ����� ragga ������ ��������� �� ������ ����� ���������� ���������� ������. ������� ���� ����� ����� ������������ hip-hop ������� �������������, � ��������� ����������� ���� �������� pop ����������, ������� ������ � ���. ����� ragga ������ ������ ������� �� ������ �������� ����������� jungle/drum''n''bass � ��������������.\r\n'),
(32, 'Rap', '��� ������������� ��������� ��� ������ rap � hip-hop ����� ���������� ����������. �� ���������� ����� ��� ������� ���� � ����� ������� rap ����������. � ����� ������ hip-hop ��� ����������������� ����������� ����, ������� ������� �������� ����� � ������, ��������� � ���������� ����� ����� ��������������� ����������. ������ rap ������, ����������� ���������� \"old school\" (������ �����), ���� ��������� � ������� ������ DJs scratching, ����������� ��������� ���� ����������� rap ������ ������������� �����. �� ���� �������� ����� �����, ������ hardcore rap ������� Run-D.M.C �������� � ��� ���������� hard-rock ������ � ����������� ���, � ������� scratch ���� �������� ��������. ������� Public Enemy, �������������� ������� ���������� �������, ���� � ������ ����, ������ ������� ������������� �� ���������. ��� ������� �������������� ��������� ����������� � ������������� �������� � hip-hop. ���� ��� ������� � 90-� ����, ����� ����������� gangsta rap ���������� ��������� �������� NWA, ������� ������������ ���� Public Enemy � �������� ������� ����� �������� ������������ ������. ����� gangsta rap, ������� ������������� ��������� � ������ ��������� ����� ���-��������������� ��������, ��� MC Hammer, � 90-� ����� ���� ����� ������ � ��������, ��� � �������� ����� ������� � �������� ������ ��� ������������. �������������� ����� ������ �������� ����� ��������� pop-gangsta Puff Daddy.\r\n'),
(33, 'Rave', 'Rave ��� ������ �������, ��� ����������� ����. ������� ���������� ��������� �����������, ������ ���������� ��� �������, hardcore � ������� ���� ������� ��������� (� �������� �������). ������, ������������ �� ������, � ����������� ����� ��������������� ��������, ��� �� ����, ��� ��������� ����� �������� ������������ ����� ��������� �����. DJ, �������� �� ������, ��������� ������ �� techno � house �������. ������ ������ ��� (��-����), � �� ������������ ���������, ����� ������ ����������� � ���������� ������ � ���� �����. ����� ����������, ������� �������, ���������� ��������� � ����� 80-� �� ������ 90-� ��. ����� ������� ����������� � ���������� ������� �������, ����� �� ����������� ������� � ��� �������� �����. � �������� �����, ���������� ������������� �������� ������������ �� �����������, ������� ����� ������� ��� �������� � �������������� ��������, ������� ���������� ����������. �� ����� �� ���������, ����� ���������� ���� �������������, �� ���������� �������� ���� ����� � ������������ ��������� � ������������ ���������� ������� ���������. � ��� ��������� ����� �������� � ������ 90-�, �� ��� ������� �� ��������� � �������� ��������� �������, ���� �� ��������� �����������. � 90-� ����, ��������� �������, �� ������� ���������������� ������� ������ rave �������� �����, ��� the Stone Roses, Happy Mondays � Charlatans; � ����� ������������� ���������� ���������� ������ Pulp � Oasis; �����-������ the Prodigy ��� ��� ��������� �������� ��������� ���� ��������, ��������� �������� ���������� �������� � ����� 90-�.\r\n'),
(34, 'Rhytm''n''Blues', '��������� \"����-���-����\" ��������� � ������ 40-� �����, � ������� ��� �������� ������ ������������ ���-������, �������������� ����� ������ ���� ���������� ���������������� \"����������������, ������������\" �����. � �� ���� �������������� \"����-���-����\" ������ �������� �������������� ������ \"������� ������\", ��� � ������ �� ���� ����� ���������� �������� �������� ������� �����. �� ������ �������� 50-� ����� ����-���-���� ��������� ����������� \"���������\" �� ����, ���� � ����� - �����. ���������� ������ ���������� (� ������� �� ������������ ���-������) �������� �� ����������, ����������� ������� ������ ���-�������������, - � ������ \"����� ������ �����\" ������������ ������� �������� ���������������� �����, ����� ��� ��������� �������� � ������������ �������� ���������. ����� �������, ��� � ����, ����-���-���� ���� ��������� ��������� ������ ����� ���-������� 40-�, �������� ���-���� ����� 50-� � ������� ������������� ���-�-�����. ����� ������ ���-�-����� ����� ������������ ����� ���������� �������������� ������ ������������ ����-���-������ - ������������ �������� ������ ���� ����������� ����� ������� ���������� ��� ������ \"Good Rockin'' Tonight\", ���������� �������������� ��� ������ � ����� ������ ������. ��� �� �������, � ���-������ ������������ ����-���-���� ������� ����� �� ���������� ���������� ������ The Rolling Stones, The Animals, The Kinks � ���� ����� - The Who, �������������� ����� �����, ������������ ��������������� ���, �� ������� ������������ ���-��������� The Beatles, The Hollies � ����������� ����������� ����� ���������� �����. � ���������� ����-���-���� ��������� \"�������������\" ��������� � �������� �� ������. � ����� 60-� - ������ 70-� ���������� ������ ����� ��������� ����-���-���� �������, ������ ��� ����� ����-����, �� �������� ��������� ��������� ������, � ����� ������ ��� ����������� � ���� ���� � ����-���-����, ��� ������� � ���� ��� ����������� �����������.\r\n'),
(35, 'Southern Rap', 'Southern Rap, ������� �� ������ ������ ����� East Coast � West Coast hip-hop, �������� � 90-� ����� �� ������� ������������ ������������� ����� Miami, New Orleans � Atlanta. � ����� 80-� �����, Southern rap � �������� �������������� � Miami bass music, � ����� ��� �������� ��� ��������� \"booty rap\" �� ���� ������������� ����� � ������������� ������. ��������� ������������� ����� ������� ������� Luther Campbell''s 2 Live Crew, ������� ������ ���� ����� � ��� ������� �� ������������� �������, ���������� ������ �������� �� ��������� ������� �� ���� ������. ����� Miami bass ���������������� �� ���� ���������� ��� ���, ������� ������������ ������ ����� 90-� �����. �� ���� ����� ����������� ����� �����������, ��� Tag Team, 95 South, the 69 Boyz, Quad City DJ''s � Freak Nasty. ��� ��� ��������� ������� ���������� ������� ������� (����������� ���� ����� ������������ ��������, ��� � Campbell). Atlanta ����������� ����� ��� ������������ � ����� �������� party rap, ����� ����� ���������� ����� ����������� (� ������������ ���������) �����, ����������� � ���� ������������ Southern soul. ���������������� ������� Arrested Development ����� ������, ������� �������� ����� �� ������������ ����������� ����� 1992 ����. ��������� ��� ������ �� ����� ��������� Organized Noize, �������� OutKast � Goodie Mob.\r\n\r\n���� Atlanta ����� ���������� ������� ����������� Southern rap, �� New Orleans ���, �����������, ��� ������������ ������. Master P �������� �������� ������� � ������� ����������������� ������� No Limit. ����������� ��������, ���������� �� ������ No Limit ���������� � ����������� West Coast G-funk, Wu-Tang-style hardcore � ������ �������, ��� gangsta ������. ������ No Limi ��������� ����������� ��������� � ������������������� ��������� �������� ����� � ����� ���������� ���������� ������������ ��������� ������ ����� 90-� �����. � ����� ����������� ������ Cash Money (New Orleans) � � house �������� Mannie Fresh ��� ����������� ������ �������� ������������ �������� �������� Southern bass ��������� ��������� ������������ ������, ���������� �� ����������� ����� ������� Juvenile � �������� ��������� ���������� ������������ ���������.\r\n'),
(36, 'Tech-House', 'Tech-House ������������ ��� �������� �������� ������� ������. ��� �������� � �������� �������� ��� ����������� ����������, ���������� ������ ����� � ������� acid � progressive house � ������ � ������� ������y, ����������������� ������������� Detroit � British techno. � ����� ����� ����������� ������ ��������� �����, ������� Herbert, Daniel Ibbotson, Terry Lee Brown Jr., Funk D''Void � Ian O''Brien.\r\n'),
(37, 'Techno', 'Techno ����� ������ �� ����������� house ������, �������� � �������� � �������� 80-� �����. ���, ��� house �� ��� ��� ����� ����� ����� � disco, ���� �����, ����� ���� ����� ��� ��������� ������������, ����������� techno ������ ���������� � ������ ����������� ������, ��������������� ���������� ��� ������������ ��������� ���������. ������ ��������� � DJs � ����� techno Kevin Saunderson, Juan Atkins � Derrick May ������ �������� ������ �� �����������, ��������������� ��� ������������ electro-funk, ����� ��� Afrika Bambaataa � ���������� � ����������� synth-rock, ��� Kraftwerk. � ��� techno ��� ������ ������������ ��������, �� � �������������� ��� ��������� �� �������� ����������� ����� ������ � ����� 80-�. � ������ 90-� ����� techno ������ ����������� �� ��������� ���������, ������� hardcore, ambient � jungle. � ����� hardcore techno, ���������� ������ � ������ � ������ ���������� ���� ��������� �� ������� � ����������� ��� ����� ������� ��� ���� ������� ��� ����, ����� �������� � ���������� ������� ����� �����������. � ������ �� ������ Ambient ��� ��������� ��������, - ��������� ���������� ����� � ��������� ���������������� ����������� ������� �� ������������� � �������� ������������� ������, ����� �������� � ������� �������� ���� ����� ��������� �� acid house � hardcore techno. Jungle ��� ����� ����� ����������, ��� hardcore, ������� � ���� ���������� techno ���� � breakbeats � ������������ �����. ��� �������� techno ���������� ��������������� ��� ������������� � ������, ��� �� ��������� DJs. ���������� ����� ������� ����� ������ ���� �������� ��  12-�������� ������� ��� ��������� ��������� ����������, ��� ���������� ���� �������� �������, ��� ������ DJ ������� ���������� ��������� ��� ������. � �������� 90-� �����, �������� ����� ��� ���������� � ����� techno � �������� ��� ���� ambient �����������, ����� ��� the Orb � Aphex Twin, �� ����� � �������������� ����� ������� �����, ��� the Prodigy � Goldie ��� ������ ��������� ������� � ������������, ������� �� ��������� ������ ��������� ��� ��-�������� ������. �� �����������, ��� ��� ��������� �������� the Prodigy ����� �������� �������� techno.\r\n'),
(38, 'Techno-Dub', '��� ����������� ����� ������������� � ��������� ������������������ ���������� Force Inc/Mille Plateaux. Techno-Dub - �������������� ����� techno � ���������� �������� techno � sub-sonic bass, ������� ������ �� ������������ �������.\r\n'),
(39, 'Techno-Tribal', '����� ������������ �������������, ���������� �� ���������� ����, ������ Techno-Tribal ���������� ����� ������ ����� ������������� ������������������� ��������, ������� ��������� ����� ������������� �������� ����������� ����������� ��������� �������� � ��� �������� �������������� ������������ �������������. ��������� ����� � ����������� �� �������� ������� ������, ���������, �������� � ����� ������� ���������� �� ������� ������������. ��������� ������� ����� � ����������������, ����� �� ��������� ������ ������� ������� ������� �������� �� ��������, � ������� ��� ������� ����������.\r\n'),
(40, 'Trance', '���� ����� �������� �� ������� � ������ 90-� �����, ������� ������ �������� techno � hardcore. Trance ���������� �� ����������� ����������� �������� ������� ����������� �� ���������� ����� �����, ��� ���� ����������� ����������� ��������� ����� � ��������� ������������� �����������, ����� ����� ����������� ��������� ����������. ������ �� ����� ������ ������� � ���, ��� ��������� ����������� � ��������� ������, ������� � �����������. �������� �� �������� �������� � ������ � �������� 90-�, trance ����� ��������, �� ��� ����� � ����� ����, �������� � ������� ����������� ����� ����� house, ��� ����� ���������� ����� �������������� ������������ ������. \r\n\r\n��������� ������� acid house � Detroit techno, �������� trance ������� � ��������� ������ ����������� R&S Records (Ghent, �������) � Harthouse/Eye Q Records (���������, ��������). R&S ���������� ������ � ������ �������� ��� \"Energy Flash\" (Joey Beltram), \"The Ravesignal\" (CJ Bolland) � ������� ������������ �� Robert Leiner, Sun Electric � Aphex Twin. ������ Harthouse ���� ������� � 1992 Sven Vath ��������� � Heinz Roth & Matthias Hoffman. ��� ������� ������������ ������� �� ���� �������� trance, ��������� ����������� �� Hardfloor (\"Hardtrance Acperience\") � ������������ ��������� Vath (\"L''Esperanza\"), ���� �� ����� ������ ������ Arpeggiators, Spicelab � Barbarella. ����� ���������, ��� Sven Vath, Bolland, Leiner � ������ ������ ������ ������ ������ � ������ ������ (��� ����������), ���� ��� �� ��������� ������ ��������� � ������� ������� ������. \r\n\r\n�������� �� ������ ������ ����������� � ��������, ����� trance ��������� ����� � ������� �����, �������� ���� ������� �� ���������� ����������� �������� � ����� 90-�, ��� ������� breakbeat dance (trip-hop � jungle). ������������ �������� �������� ��-���� ������ ���� ���������, ������� �������� ������ \"progressive\" trance, ������������ ��� �������� ������� �� ������� ������ ���� house � Euro dance. � 1998�., ����������� ��������� DJs ����� ��� Paul Oakenfold, Pete Tong, Tony De Vit, Danny Rampling, Sasha, Judge Jules ������ trance � ����� ���������� ���������� ������. ���� ��� �������� �������� (�������-��) �� ���� ����� �� ����� � ��������� DJs, ������� Christopher Lawrence � Kimball Collins.\r\n'),
(41, 'Turntablism', '�\r\n��� ����� DJs, ��� Grandmaster Flash, Afrika Bambaataa � Grand Wizard Theodore ���� �������� hip-hop �������� 1970-� �����, �� � ������� ����������� rap �� ����������� ����� � �������� 80-�, ������ ����� ����� ������ ������ ������� ������������ (MC). � ����� �����, ��� ����, ����� ����� ���� ������� � ��������� ��� ������� ����������� ������� �����������, ����� ����������� ������ ���� ����� ��������� ����������. ���������� ����� ��, ��� ������ ������ ������� hip-hop ������ ���������� � ����. ����, ��������, ������ ������� �� �������������, �������� ������� �� ���� �������� rap �������� � �������� 90-� ����� ���� ����������� ��������� Turntablism � ��������� ����������� ������. ����������� �������� ����� ����� DJs, � ����� ���������� ������ ������� ������ � ������ �������� ��� ���������� scratching, spinbacks, phasing � �������������� ���������� ����� �� ���� ��������� (beat juggling). ��������� �������� ���������� DJs (����� ��� ����� �������� DJ Shadow) ��������� ���� ����� �� ���������� ����� �������, � ��� ������������� � ����������, ��� �����. ����������� ������� ������� ���������� � ���������� ������� �� jazz (�����), soul ��� funk (������������� ������������ ����� ������ ��������������� � ���������������� ���������, ��� ��� � ��� ����� ���� ����� ������������� ��������� ������). �������� ��������� Christian Marclay, �������� ������ �������� ��� �������� � ������ 80-� �����, ��������� �������� �� ��������� ����������� ����������. � 1987 �. ������� ������ disco ��� - Disco Mix Club (����� ���������� ������ DMC) ������ ���� ������ ��������� DJ. ������ ����� ������������ ����� ��� DJs ������������ ��������, �� ��� ��� ��������, � ����� ���������� �������� � ���� ������ � �����������. ������ ��������� �������� DJs, ����� ��� QBert, Mixmaster Mike, DJ Apollo � Rob Swift ����� ������� ������������� ����������� Turntablism , - ��������� �� ��� �������� ��������������, ������ ������� � ����� �������, �������� ����� ������������, ���  Invisibl Skratch Piklz (I.S.P.), X-Men (����� X-Ecutioners) � Beat Junkies. ���� �� ������� ������� ����� �� ������������ ������� � rock ���������, �� ����� ��������� ���������� - ����� �������� �������� �������� DJ Shadow ���������� ��������� � ������ ��������, ��������� ���������� ���� ����� ����������� � ����������� ���������� � ������ �������� ����������������� ���������� ��������� � ������ ������.\r\n'),
(42, 'Tribal-House', '������� 90-� ����� ������ � ����� house music ���������� ��������� ����� � ������� �������, ��� �� ���� ��������� ����������� ambient-house, hip-house � Tribal-House, ����� ������������ �������� four-on-the-floor ����������� � ��������������� �������, � ����� ����� ����������� ������ ����������, �� �������� Frankie Bones � Ultra Nat� �� electro-hippie �����, ��� Banco de Gaia, Loop Guru � Eat Static (��� ��� �������� � ���������� ������� Planet Dog Records).\r\n'),
(43, 'Trip-Hop', '��� ���� ������������� � ������� �������� �����������, ������������� � ������������ �������� �������������� �� ����� post-acid house � ������ ���������� ��������� ������������������ ����������. Trip-Hop ��� ������ ����������� ������������ ��������� � ����� ���������������� ����� �����, ��������� �� downtempo, jazz-, funk- �  experimental breakbeat ������, ������� ������ ���������� � 1993�. ��� ������� ����� ����������������� ��������, ��� Mo''Wax, Ninja Tune, Cup of Tea � Wall of Sound. ������� (���� � ����������� ��� ��������� ������) �� American hip-hop � ������������� �������������� ���������� �������, ���� ����� ��� ����� ����������������� ��������, ������������� ������� ����������� ��������� ambient � ������������ ����������. ����� �������, ������ \"trip\" ������ ���������� � ������������� ��� �������� ����� �� Portishead � Tricky �� DJ Shadow � U.N.K.L.E., Coldcut, Wagon Christ � Depth Charge � �������� ��������� ������ �� ���� ����������, ������� ������ ���� ������, ��� ���������� ������ �������� hip-hop, � �� ��� ����� ������������, ������������ ��� �������� ������. ����� �� ������ ����������� �������� �������� �� ���� ������������ ������, - ������ ������ �������� � ����� trip-hop, ����� ����������� �������� �������������� ������ � ��������������, � �� ������ ����������, ����� ��� Shadow, Tricky, Morcheeba, the Sneaker Pimps � Massive Attack, ���� ����� ��������� ������������� ������������ ����� ������ ������ ����� \"electronica\" � �������.\r\n'),
(44, 'Underground Rap', 'Underground Rap ����������� �� ��� ���������. ��� ��� hardcore hip-hop, ������� ��������� ����������� ������� � ���������� ������� ����� ����������� ��������, ��� gangsta �����, - ��� hardcore gangsta rap, ������� ������ � ���� ��� ����������� � ���������� ���������� ���� ������. ��� ��� ����� �������� � ���, ��� ������� ��������� ���� �������� ��������� � ����������� �������� ����������� ��������, - ��� ����������� ���� ������ �������������. Underground rap ������������ �� ������� ������� ������, ��� hip-hop, �� ����� ������ ���������.'),
(45, 'Uptempo', '')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(46, 'Urban', 'Urban (����� ��������� ��� ��������� ����������� urban) ����� �������� ������� R&B/soul ������ 80-90-� �����. ��� �� ��� quiet storm � Philly soul, ��������� �� ���� ������� �������, ����� urban ��� ����� ������ � ����������. �� � �� ����� ��� ������������� ������� ������ ����������� � ����� ������ ����������� quiet storm, urban ������� ����������� ������ uptempo, funky dance �����, ������� ������ ���������� ����� �� high-tech ����������������, ������� � ������ � ����, � �������� �������. ��� ������, �������� �� ���� ��������, ����� urban �� ������ ���� ������ �����, ������������� � �������� \"soul music,\" ����������� ���������� ���������� ������ � ������ ���������������� ������������ �����. �� ����� 80-� ����� ������� ����� ������ urban ���� � ������������ ������� pop-�������������, ��� ����� ����������� � �������, � ����� ������ � �������� ������������.\r\n\r\n����� ��� ������������ ����� ��� Janet Jackson, Billy Ocean � Whitney Houston ����������� �� ������ R&B � pop �����. ���� ���� � ������ ���������, ����� ��� Freddie Jackson, Luther Vandross, Stephanie Mills � Levert, ��� R&B ������������ �� ������������ �� �� ��� ������. ������� ����������� urban ����������� � ���������� hip-hop. �������� (� Guy member) Teddy Riley ������ ����� ���� ���� ������, ������� ������ rap ������� � ������ ��� ������������ - new jack swing. ��������� New jack, Bobby Brown ����������� � ����������� ����������� �����, � ��� ��� ��������� �� ������ ������� New Edition ��������� ����� ����������� ����� ��������� �������. � ���������� � Riley, ��������� ����� (��������/��������), ����������� pop � R&B ����� ��� Jimmy Jam & Terry Lewis (Janet Jackson), Denzil Foster & Thomas McElroy (En Vogue) � Antonio \"L.A.\" Reid & Babyface. ������ ��� ������������ � ����� urban � ����� �����������, ��� ��� Babyface ���� ������� ������������������ ������� �������. ����������� Urban � hip-hop ���������� ������������ � � ������ 90-� �����, ���, � ����� ������ ������� � �������� ������ �������, ����������� �������� \"hip-hop soul\". Hip-hop soul ���� �� ������ ����������� new jack swing, ���� ������������� ���� ���� ����� ��������, ������ � ���������������. ����� hip-hop soul ��������� ����� ������, ������������� �������� �� ��������� � new jack. ����� ���� ������� �������� urban, ������� ������ � quiet storm � adult contemporary. ���� ���������� (�� �������� �� ����, ����� ����������� �����������), ������ ����������� �������� ���������� ��� ����������������� ���������� ����������. �������� ���������� ������������� ����� ��������� ����������� pop/rock � ��������� ������ ������������, ����� urban ���������� ������������ ����� �������, ������������� ������� ������ pop ������ �� ������ �������� 90-� �����. � ��������� ����������� ����� ����� ������� Mary J. Blige, Toni Braxton, R. Kelly, Boyz II Men, SWV, Blackstreet, Jodeci, Monica � Brandy.'),
(47, 'West Coast Rap', 'West Coast Rap ����������� �� hip-hop ����� � �������� 90-� �����, �������� ������������ ������������ ����������� gangsta rap � ��������� ������ Dr. Dre, ��� ����� �� ����� ����������� ����� � rap �������. ����, ���� ���� ��������������� Dre ����� G-funk �� ������ ��������� ���� � �������� �������������� �� �������� ��������� (West Coast), �� �������������� rap ����� ���� ������� �������������. � ��������-����� 80-� �����, West Coast rap � �������� ���������� East Coast party rap, ������ ����� ������� �������� ������ ����� (old-school). ������, ��� Los Angeles, ��� � Bay Area ������ ��������� ����� ����������� ������ ��� �������� ����������� ��������. � ���-��������� ������������ Ice-T � ����� proto-gangsta, ����������� ��������� � ���������� ������������� Latino ������ Cypress Hill � ���������� Pharcyde; � ����� Bay Area � ���� ������� ���������� ����������� ������� ������ Too $hort, ����������� Digital Underground ������������� P-Funk, � ����� ������ �� pop ����� ��������� � ��� ����������� MC Hammer. ������ ������, West Coast rap ���� ����� �� ����������� � ������ ������������, ��� East Coast rap. ������, ������ ������� N.W.A. ��� ��������� Straight Outta Compton (1989�.) � ����� ganhstra-rap ��������� ����� ������������ ������ ����� West Coast style ��� ���� ��������� ���������� � ������������, � �������� ������������ �� ������� ��������� �� ����������� ����������� ������������ ���������� ��������. ����� ����� �� ������� N.W.A., Ice Cube ����� ������� ������� � ������� ��������� ��������, � ������� ������������� ��� �� ���������� ���, �� ������������� ������ ���� � ����� Public Enemy. � ��� ���������� Dr. Dre ������ ������� Snoop Doggy Dogg, �������� �������� �� ������� Death Row Records, ��� � ����� 1992 �. ����� ������ The Chronic, ������� ��������� ����������� G-funk � ��� ����� ��� ������ ��������� ������ ���� ������������. � ������� The Chronic ������������� � �������� ����� gangsta �.�. �������� �����������, ����������� ���� P-Funk � ��������, ��������� ����. ������� �����, ��� ���� ������ ������ ������ Death Row ����� ������� ����������������� ��������� � ����� hip-hop ������ 90-� �����, ���������� � ������ ����� ������������, ��� Snoop, Warren G., Tha Dogg Pound � ������ ������. �������������� ������ ����������� gangsta 2Pac ����� �������� �� ���� ������ � ����� 1995�., ������������� � ����������� ����� ���������� ������ �  Dre ���������� \"California Love\". � Coolio ������ ����� pop-��������������� ������ ����������� West Coast � �������� �� ������� ������� ���-������� � ������ ����� �� ���� (1995 �.) � ������ \"Gangsta''s Paradise.\" ������, ������������� �������� West Coast ������ ����� �� ��� 2Pac ��� ���� � 1996�., Dre ���� �� ������, � ��������� �������� Death Row Suge Knight ������� �������� ��� ������ �� ������������ ���������. � ����� 90-� �����, �������� �������� hip-hop ������������ ���� ���������� ����� � East Coast, � ����� � ��� �������������� ������ ����������� (South).\r\n'),
(48, 'Atmospheric', '��� ����-�����, ������ ������ ������, ������� ����������� ������ ������'),
(49, 'Ambient Techno', 'Ambient Techno, ������ � ���������� ����������� �������������� ambient house, ������ ������������ ������ �����������, ��� B12, ������ Aphex Twin, the Black Dog, Higher Intelligence Agency � Biosphere. ���� ����� �������� ����������, ���������� ������������ � ����������� ������� techno � electro ��� ���������� ���������� ��������� 808 � 909, ������ ���������� �����������; �������� ������� � ������ ������������ �������� �������, ����������� ��������� beatless � ������������������ ambient. ���� ����� ����� ������������� � ������ ���������� ������ ��� Apollo, GPR, Warp � Beyond. ������������ ����� ����������� ��������� � \"intelligent techno\" (��������������� �����) ����� ����, ��� Warp ��������� ���������� Artificial Intelligence (���� � �������������� ��������� ������ �������� ��� ���������).\r\n'),
(50, 'Ambient House', '������ ������, ������������ ��� ������������� ����� ����� ���������� ambient, ����� ��� the Orb, KLF, Irresistible Force, Future Sound of London � Orbital. Ambient House ����� ������������� ��� ������� ��� ����������� ������������ ������, ��� ����������� �� �� ��������������. � ����� ������� ����� ���������� ����� ambient house - ��� ������ ���������� �������� �������� acid house midtempo, four-on-the-floor beats; ����������� � ��������; ������� ��������� ������ ��� ��� �������������� � ����� ���������, ������� ������. ����� ���� ������ ��� ������� (��� ������, ��������, ���� ������ ����� ���� �� ��������) �� ����� ������������� ������� � ����� ������������.\r\n'),
(51, 'Acid House', '������������ �����, ���������������� ������������ house ������ �� ����� ����. ����� Acid House ������� �������� � �������� 80-� � ���������� ��������� ����������, ����� ��� DJ Pierre, Adonis, Farley Jackmaster Funk � Phuture (��������� �������� ������ ��� ������������� ������ \"Acid Trax\"). �������� �������� house, ������� ��� ���� ����������� � ������ (����� ��� � � ���-�����) � ������� ������� � ��������� ������ �� ����������� Roland TB-303. ����������� acid house ���� �������������� ������ � ������, ���� ��������� �� ������ �� ������ ������� ��������� � ���� � ������� � ���������� ���������. ������ ������� �� ����������, ���������� �� ��������� ������� � ������� � 1986-87, � ����� ����� �������� ������������ ��������� �� ����� ���������� ����������� ���������  Summer of Love ����� 1988�., ����� ������ ������� ������������ ��������� �� ���������������� ����������� �������, ������� ���������� ������� Acid house ����� ������ ���������� ������ ������� � ���������� ��� ������ � ������ �� ������ M/A/R/R/S, S''Express � Technotronic �� ����� 90-� �����. � ����� ������� � �������������� ������� acid house ������ � ������ � ��� ������ ������� rave. ������� ������������ ����� �����, - �� Cajmere �� Armand Van Helden � Felix Da Housecat ���������� �������� �� ����� 90-� �����.'),
(52, 'Ambient Breakbeat', '����� Ambient Breakbeat ��������� � ������ �������� ����������� ������, �� ���������� ������� �������������, ��� trip-hop ��� funky breaks. ������ �������� ������� hip-hop ������ �� ��������. ��������� ��������� (downtempo) ����������, ���������� �� ���������� ������� (����� ��� Mo'' Wax � Ninja Tune) ������� ������ � ������ ���-��������� DJ Wally (�� ������� Liquid Sky Records) � ���������� ������������, ��������, Req. ������ �� ��� ����������������� ������� �������� ������\r\n'),
(53, 'Ambient Dub', '���� ����� ��� ������ �� ����������������� �������� Beyond ��� ����� ���������, ��� ����������� ���������. Ambient Dub � ������� ������ ��������� ���������������� �����������, ��������� � ��������, ��� ����������� � ����� ����� ���������� ambient � ������� ����������� ���� ����, �������� � ������� ����� Jamaican dub (��������, reverb, ������ �� ��� � �������, ������� �������). ���� ���� ������ ����� � ��������� ��-�� ��������� �������� ������, ������������� � ����� post-rave electronica, �� �������� �������� ��� ������������� �������� ���������� ����������� ���������� dub � ��� �������� ���������� ������ hip-hop, downtempo � ������� ������. ����� ���������� ������� the Orb, Higher Intelligence Agency, Sub Dub, Techno Animal, Automaton � Solar Quest.\r\n'),
(54, 'Ambient', 'Ambient ��� ������ �� ���� ������������� � �������� ����������� ������, ����� ���������� ��� Brian Eno � Kraftwerk � ������������� trance techno � 80-� ����� 20 ����. Ambient ���������� ����������� ������������ � ���������������� ���������� �����, ����� ������ ���� ������ ���� �������� ��������, � �� ��������� ������� � ������. ������ �������� ��������, ����� ������������� �������, ������� ��� ������������� ��������� ����� ���������� ����������. ���� ���������� � ����� ���������� �������-������������ ����� ������� �������� ����� �����. ����� ambient ���� ����������, ��������� ������� � ������ 90-� �����, ��������� ambient-techno ���������� the Orb � Aphex Twin.\r\n\r\nAmbient ��������� ������ ���������, �������������, ����������. ���������� ������� � ������������� ����� �����, �������� ������� Ambient ��� �������� ����� �� ���������� �����-���������� ����� XX ���� �������� ��� (Brian Eno). ����� � �������� � �������� ����������� � ������� ������ �����, ��� ���� �������������� � ������, ����������� �� ���� ��� ������, ������ � ��� �� ���������� ��������. ����� �� ����� ���������� ���� ���������� ����� � ���������� �� ��� ����� �����. ����� �� �������� ��� ��� � ���������� ������ ��� ����� ��������� Ambient. \r\n\r\n����������, ������ ����� �������� Ambient ������������ � �����������. ����������� ambient ��� ������, ������� ������, � ������� ��� ���� ����������� ����. ��� ��������� ������, � ������� � �������� ���� ������������ ������� ����, � ������� ������� ������ ����������� � ��� ������� ������ ����� �������. � ambient ����� ������������ ������� ����, ������� ����� �� ������ �������, ������������ ����� � ����� ������� ����� ����� ������������ � ���. \r\n\r\n������ ����� ��������� ����� ���� ambient� � ������ ����. �������� ambient ������������ ������ ����� �� ���� ������ �� ����� �� ���-����, ��� ��� ���� ����� ������ �� ��� ��������� � ������� ������� � ��������, �� �������� ��� ������� ���, �� ����������. �������� ���������� Ambient-����������� ��������� Pete Namlook, Aphex Twin, Seefeel, The Future Sound of London, The Orb, Delerium.\r\n'),
(55, 'Alternative Rap', 'Alternative Rap ��������� � hip-hop ��������, ������� ������������ ��������� ����� ������������ ����������� rap, ����� ��� gangsta, funk, bass, hardcore � party rap. ������ ����� ��� ��������� ��������� �����, �������� ������ �������� funk � pop/rock, � ����� jazz, soul, reggae � ���� folk. ���� �������� Arrested Development � Fugees ������� �������� ������ � ������� � ����, ����������� alternative rap ����� �������� � �������� ����������� ��� alternative rock �����, � �� ��� hip-hop ��� pop ���������.\r\n'),
(56, 'Acid Rock', '����� Acid Rock ��� ����� ������� � ������� ������ psychedelic rock. ��������� �������� �������� ������������ �� Cream � Jimi Hendrix, ������� acid rock ��������� ���������� ������, �������� ����� � ������� ��������� � ��������. Acid rock �������������� ������� �� �������� � ���� � ������� ������� � �������� psychedelia � ������, ������� �� ���������, ����� ��������� � ����� heavy metal.\r\n'),
(57, 'Acid Techno', '����� ������� acid house ���� �������� ���� ����� � ���� ������������� �������� � �������� 80-�, �� ������� ���� ������ ���� �� ����. ������ ���������� ��������� � ������ 90-� ����� ������������ ���� ����� ��� ���������� techno, �������� ��� ������ ������� ������������� Chicago house. Acid Techno (����� ��� � ������ German trance) �������� � ���� ������ ������ Aphex Twin, Plastikman, Dave Clarke � ������ ������.\r\n'),
(58, 'Acid Jazz', '��� ������ ����������� ���������� ����������, �������� �� �����, ����� � ���-����, � ���������� �������� ���� ���� �����������. ����� ����� Acid Jazz, ��� ������������ ��������������, � ����� ��������������� ����� ���������� ������ ���� ����� ����� � ����� � ����-��������� ������, ��� � ������ ������������ ������������. C ������ �������, ������������ ���� �������� Acid Jazz � ������ � ���-�����. ��� ������ ������� �������� � 1988, ������ ������������ ��� �������� ������������� ������������������ ������ � ���������� ����� ���������, �� ������� ���� ������������ jazz � Funk ������ 70-� ����� � ������� �� ����� �������� �������� rare groove. � ����� 80-� - ������ 90-� ��������� ����� ������������ Acid Jazz, ������� ������������ ����� ��� \"�����\" ������� - Stereo MC''s, James Taylor Quartet, the Brand New Heavies, Groove Collective, Galliano, Jamiroquai, ��� � ��������� ������� - PALm Skin Productions, Mondo GroSSO, Outside, � United Future Organization.\r\n'),
(59, 'Bass Music', '����������� � ������� ������������� ������� ������� Miami (freestyle) � Detroit (electro) � �������� 80-� �����, ����������� Bass Music ��������� � ����� funky-breaks 70-� � �������� ���, ��� ���������� ��������� ����� ��������� ����� ���������� � ������� ����������� ������ �� ������������� ����������� ��� ������� ������������ ������. ������ ������ �� Miami, ����� ��� 2 Live Crew � DJ Magic Mike �������� ���� ����� � ������������� ���� ������������� �� �����������, � ����������� ���������, ����� ��� DJ Assault, DJ Godfather � DJ Bone ������� ��� � techno ��� �������� ����������� ����� ������� ������. Bass music ���� ������� � ���� � ������ ������ 90-� �����, ������� ���������� ����� ������ ��� 95 South''s \"Whoot (There It Is)\" � 69 Boyz'' \"Tootsee Roll\", ������� ����� ������������ �������� ������, � ������� ����� �����������.\r\n'),
(60, 'Big Beat', ''),
(61, 'Breakbeat', '�������� \"��������\" ��� ������������ ������������� ��� ��������� ����� � 1994 ����. ������������� ���� ������������ ��������� ��� ������ ���, ��� � ���� ������� ���� ��� ��������� ������ �� �������� ����������� ��������. ����� �� ������������ ����� ������ �������� � ��, ��� � ��������� ����� ����������� �������� �����, � ������ �������� ������� ������� �� ������� ������ ������. \r\n\r\n������ �������� ��������� ������� ������� ��������������, � ��������� ��������, ��� ���� ����� ������������� ������� ���������� ���������������, �������� ������ � ��������. �������� ��������� ��� ����������� ��������� �������� ������, ����������� ����� �� ������������ �������� � ��������� (�� ����������� ����� ��� ����������) � ����������� ���� 4/4. �������� ���� ����� ������� �� ������ � ��������� ����. ����� � ����� ����� ���� ��������� �������������� ������. ���� �������� ������� ������, �� ����������� ������ ��������� �������� �� �������� ���� (��������������) ��������� ������� ��� ����� ����� �����. ���� ����� �������������� ���������� �� ������� ����.\r\n\r\n������� ����������� ���� ����� ��������� ����������� ������� ������. ���������� ��������, ��� �������� ��� ���� ����� ������������� ���� ��� ������, ������� ���������� ����������� ���� ������������� (����� ��� �� ����������� �������, ������� �������� ������).\r\n'),
(62, 'British Psychedelia', '���� ��� ����� ���������� �������������� � ��������� �������� ������, �� ����� British Psychedelia ����� ��������� �� ������ ������������� ��������. � ����� British psychedelia ���� ���� ����� �������������, ���� ����� �������������-����������������� �� ��������� � ������������ ������������. ���� �� �����, ���������� ����� ��������� � ������ �� ��������� pop ����������. ������ ��� �� ���� ����������� ��������. �� �����, ������� �������� pop ������� ��� ���������, �� ������� Pink Floyd ������� ������ ����������� �����, � ������ ������������, ������� ��� ����� � ���������� ������ ������� ����. ������ ��� ����� ������� �������� ����� ��� ����� ��������������, �������� � ��������� ��������� ������� British psychedelic.\r\n'),
(63, 'British Rap', '���� British Rap ����� ����� ����� �������� �� ��������� �������������� � ������, ���� ����� ����� ���� ����������� �������� � ����������. ���� � ��� ������ ����� �������� �������� American hip-hop, �� ������ ���������� ������ ������� �� ������� ��������� ragga ���������, � ����� ����� ������� ������� � hip-hop �����. ���������� rap ��������� � ����� 80-� �����, � � �������� ��������� ����������� �������� ���������� �� Public Enemy. ������ ������ ���������� ������ ����� ����������� � ���� ������ �������� acid-house, - � ���������� �������� ����������� ����� �� ����� ������� ���������, ��� ��� ������������ ������. ���� ��� �������������� ������� �����, ������ � ������������ �������, �� ������ ���������� hip-hop ��������� ����������� �� ��� ������. ������������ ����� ������, ��� Prodigy, ����������� hip-hop � rave. ���� �������, ��� Leftfield, ������� �������� � ������� ����� hip. � ����� �������������� ����� �����������, ��� Massive Attack, ������� ��������� ���� hip-hop, �������� acid-jazz, ��� � ����� ������ trip-hop. ���� � �� ����� ��� ��� ��� ������� ���������� ����������� ����� ����������, �� ����������� ����� ���� ������� ������������ ���������� �������, ������� ������ ���������� �����������.\r\n'),
(64, 'Comedy Rap', 'Comedy Rap - ��� hip-hop, ������� ��������������� ��� ����������� � �������. �������� �����, ��� rap �������� �������� ����������, �� ���� ������ (�������� � ������ � Biz Markie, �� ��������� ���������� ������ ������� ������ � ����� comedy rap �� ����������� ����) ����� ���� ���������������� � �������� ������������. ������� Comedy rap ���������� �� 80-� ����, ����� hip-hop ��� ����� �� ��������� � 90-�� ������ (����� gangsta rap ��� ����� ������� ����������� ������). � ��� ����� ������������ ��������� rap �������, ����� ��� Chunky A �� Arsenio Hall, �� � ����������� comedy rap ��� ��������� real hip-hop � �������� �����.\r\n'),
(65, 'Club/Dance', '�Club/Dance ������ � ����� ��������� ����������� ����, �� ����� �� ���-����. �������� �� ��, ���, �� ���������� ���� ������� ���������� ������ ������� ��������� ��������� ��������� ����-�������, ����� Club/Dance ���� �� ����������� ������ � �������� 70-��, ��������� soul, � ���������� ������� ����������� � disco � ����������� ��� ����� ���� ��������� ������������� �����������. � ����� 70-��, ������������ ����� ������ disco, �� � ����� �����������, disco �������������� �� ��������� ��������� ���������. ��� ����� ���� ������� ��� �������� \"dance\", ���� ����� ������ ��������� ������� ������������� �������� ����� dance-pop, ���-�����, house, � techno. ��� ��� ��������� ��, ��� ��� ������ �� ����� � ������ ������������ �������� ��� �������� ������������.\r\n'),
(66, 'Contemporary R&B', '����������� Contemporary R&B ������ ���� �������� ��������� ��� ������ ����� ��������� urban R&B. ��� � ����� urban, contemporary R&B - ��������������� ��������� ������, �� ��������� Maxwell, D''Angelo, Terence Trent D''Arby ���� ����� �������� ����������� � contemporary soul � R&B ���������, ��������� ������ � ���������������, ������������� classic soul (Marvin Gaye, Stevie Wonder, Otis Redding).\r\n'),
(67, 'DJ', '�� ���� ��������� ����� ������ (���������� toasters) ������ �������� �� ���������� ����. ����������� ����� DJ ������ ���� ������������� � sound system dances (������������ ���������� �� ������������ ��������), ��� � �������� ����� ������� � ������ �������� �� ����. ����� ��������� hip-hop ������ � ���-����� (�������� ��������� ��������� ��������� Kool Herc), �� ���� ������ ���� ���������� ������������������, � �� ����������. ������ �������, �������������� Grand Wizard Theodore, Grandmaster Flash � Afrika Bambaataa, ����� �� ��������� 90-� ����� (��� ��������� ����� ���������� turntablists), ������� ���������� ����������� ����� �������������� ����������, ������� Mixmaster Mike, DJ Q-Bert � Cut Chemist.\r\n'),
(68, 'Dance', '������ Dance ����� ������� ���������� ����, - �� disco �� hip-hop. ���� � ������� ���������� ������ ��������� ����� ������ ����� � ����������� �����������, Dance ������������� ��� ��������� ���� � �������� 70-� �����. � �� ����� ��� soul ����������� � disco, - ����� ����� ��������� �������� ������������ ������ � ������������ �����. � ����� 70-� ����� dance ����� ������ disco, �� � ����� ����������� disco �������������, ������������� � ����� ��� ��������� ������. ��� ��� ����� ���� ������� ��� ����� �������� \"dance\", ���� ����� ���� ���������� ����� ��������, ��������, ����� dance-pop, hip-hop, house � techno, � ����� ������� ������� ����������. �� ������ ���������� ����� ������ �� ���� ��� �������������� � ������ dance �������� - �� Disco �� House � Rave,- ����� ������������ ���.\r\n'),
(69, 'Dance-Pop ', 'Dance-Pop - ��� ���������� disco. � ��������� � dance-club beat, �� ������� ������� � ����� �������. ����������� dance-pop ����� ����� �������������� ����������, ��� ������ dance ������. Dance-pop - ��� ������ ����� ������ ������������� �����������/���������. ����������/�������� ����� ����� � ������� �����, ��������� ����������� ��������� ��� � ����������. ��� dance ����� ���������� ��������, �� ����� ���� �������������� ������� ����������� ���������. �����������, ��� ���� ��������� ���������� �� ������ Madonna � Janet Jackson �������������� �������� ���� � ����������� ����������. �� dance-pop - ��� ������ ��� ���, ������� ����� ������ � �� ������ ������.\r\n'),
(70, 'Deep House', '���� ����� ���������� �� ����� ������� ���������� ����� � Gospel. ���������� ���������, ������������ �� ������ (� ����� �������) ��������� �����������, ��������� ���������� ������ �������������. Deep-house - ��� ������ ����� ����, � �� ����� - �������� �������� ������������.\r\n\r\nDeep House �������� ��������������, ������ � ��� �� ��� �� � �����, ���� deep - ���� �� ����� ������� � ����� ���������� ������, � �������, ���� ��� Club House ����� ��������� ��������� ���, �� ��� deep - ������� ������. Deep - ������ �� ������ (� ���� �� �������) ��� ���, ������� ��� ����.... ��������� ����������, ��� Deep House ����� �� ������������ Detroit � �p���������� ����� �p��������� ����� House-������ � ������� ������. ��� ����p����� ��� ���������� - \"Deep House - ��� �p����������������� ����� ���������� �����, ������ ����� �����, � �� �����\".\r\n'),
(71, 'Dark Ambient', '������������ ������ ������������ ������� ������ ambient, ������������� Brian Eno, ������� ����� ���� �������������� � ������� ������� house � ������������ ������ �� the Orb � 90-� ����, ����� ������������� ����������� ��� �����, ���������� ��� ��������� Dark Ambient. ���� ����� ����� ������������ ������� ����������� ���������� ��������� ������� �� ����������������� � ����� industrial � metal (Scorn''s Mick Harris, Current 93''s David Tibet, Nurse with Wound''s Steven Stapleton) �� ������������ ����������� ������ (Kim Cascone/PGR, Psychick Warriors Ov Gaia), ���������� Japanese noise (K.K. Null, Merzbow) � �������������� �������, ����������� � ��������� �����(Main, Bark Psychosis). ����� dark ambient ���������� ����������� ��� ������ �������������� ������ � ��������� � ����������. �������� �����������, �������� �������� � ������������� ��������� ���������. ��� � ����������� ������, ������� �����-���� ��������� � ������ electronic/dance 90-� �����, ��� ����������� ����� ����� ������������ �������, ��� ���������� �������� ��� ����������� ������ � �������� ������� ��������� �������.\r\n'),
(72, 'Dirty Rap', 'Dirty Rap (������� ���) - ��� hip-hop, ����������� ������������� ���� �����. ������ ������������ ����� ����� ����� ��������� �� ������� 2 Live Crew, ������� ���� ����� �� ������� � ������� �������� Miami bass. ������� ������ ���� ������� ����� ����� � ������ dirty rap. ����������� ���������� dirty rap ���� ������ ������������� ��� ��������� � ������ �������, �� ��� ����� ��������� ���-�� ���������� � ������ ������ ��� ����������.\r\n'),
(73, 'Detroit Techno', '������ ����� Detroit Techno ����������������,  ����������� ��, ��� �������, ������������ ����� ������������ ��������, ��, ��� ��������� ������, �����, ������������� �������� (��������� �������� ������� � ���� ����� �� �������� Motown � ���������� ������������� ���� ����� ������ techno � house � ��������� �����, ������� ����������� ����������� � ���-�������� ����������� �� ���� ������). ���� ������������� ����� ����������, ��� ������������ ������, ������� ��������� ����������, �� ������� � ������������� ����� �� Cybotron, Model 500, Rhythm Is Rhythm � Reese ����� ���� �������� �� ���� �������������� � �������� �������������� ������� � ����� 70-�, ������� ���������� �� ��������� ����� ������� ������������ ������������� ���������.\r\n\r\n������ �������� ����������� ����������� ������������ ��������� � �������� ������� ������� ������� ������ ����� ������� �� ���� ������������ ��������������� ������������ ���������� ��������� (����� ������� ������������ � ��������������� ���������). �������� ��������������� � �������� ������������ techno (��� �������� ���� ������ �� hardcore �� jungle), ��������, ������� ����� ���������� ���������������� � ������������ ������������ MIDI � ��������� ������������� �����. ������ � ������ ����� ����� Detroit techno, ����� ������ ������ �� ��������� ������� � ����������� ������������, ���� ����� ��������� ��� Derrick May, Juan Atkins � Kenny Larkin �������� ����� ��������� ���������������� ������������ �������� ���������� � ��������������� ����������� ��������� ������������ ��������.\r\n\r\n����� �� ������� �������� ��������, Detroit techno ���� ���������� �������� � ������ (�������� � ���������� �������� ���������, ������ ���������, ���������� ���� ���������� � ��������, ����������� �� ����� ����), ������������� ���, ��� ������ �� ������ ������������ ������ ��� ��� ����������� (� ���� �������� ����� Submerge). �������, ������ ����� ����� ����� ����� ������ ���������� ������������ ��������� ���� �����, �������������� � ������� �������, � ������� ������ ��� (Underground Resistance, Jeff Mills), � ����� �������� ������� (Kenny Larkin, Stacey Pullen). ����� ������������ ������� � ������ ����� techno, ��������� �� breakbeat (Aux 88, Drexciya, \"Mad\" Mike, Dopplereffekt).\r\n'),
(74, 'Dirty South', '����� Dirty South �������� �� ������ �������� 90-� �����, ����� ���� ��� gangsta rap ���� ������ ���������������� � hip-hop. Dirty South ������� ������������� �������� �� ������� The Chronic � ���������� �������� � ������� 2 Live Crew. ��� ������� � ��������� ���������, �����������, ����������� �� ����� � (�����������) ������������ ������ modern hip-hop. ���� ����� ������� ���� �������� �� ����������� ���������� Goodie Mob (1995 �.). ������ ���� �������� ��������� � Outkast ��������� ������ ������ ������������ ����� �����, �� ������ � ������ ���� ����� ������� � ��������������, ��� � ����� �������������, ��� No Limit.\r\n'),
(75, 'Disco', 'Disco ������������ ������� ���������� ������, ������� �� ������ dance. ���� ����� �������� �� �������� ������� funk � disco 70-� �����, ���, ������ �����, ������������� ����, �� ��� ������ ����������� � �����. Disco ������� ���� �������� �� ����� ���������. ��� ���������� �����, ������� �� ������ ������ ����� ������������ ������. � ���-����� ����������� �������� ������������ ����� ���-�����, � DJs � ���� ������ �������� ����� ������ soul � funk � ������� ������. ����� ���������� � disco �������, ������ �������� ����� ����� � ������ �����������. ������ ����������������� �������� � ��������� ����� �������� ���������, ��������� ���������� � ����� disco. �����������, ��� ��� ������ ����� ����� �������� pop ��������, ������� �� ��� ��������� �����. Disco ������� �������� ����� �� ��������� ����� ������ ������ ��������� ������� ���������� � ������������� ������. ��� ������ ����������� �� 12-�������� ����������, ��� ��������� ����� ����� ��� ����������� ��������. DJs ����� ����������� ��� �����, ������������ ��� �� ������ ����������. ����� ������ �������� disco beat ����� ������������ ������� � pop ������. ��������� ��� ����� ������ disco, �� ����� �������, ��� Rolling Stones � Rod Stewart �� ��� ������������, ��� Bee Gees � ���������� ����� �����, ��� Blondie. ��������� disco ����������� ����� �������� Donna Summer, Chic, Village People � KC & Sunshine Band. �� ��� ������ ���� � �������� ��������� ������������� ������������/����������, ������ ��� ��� ��������� ����� � ���������� ����������. Disco ������ � ������ �� ����� 70-� � 80-� �����, �� ���� ����� �� ���� �� ������ ����������������� � ����� ��� ������������ ������, ����������� �� dance-pop � hip-hop �� house � techno.\r\n')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(76, 'Disco House', 'Disco House ������������ �� �������� '' 70-�� Disco � Funka. Disco House, ��������� ����-���� ��������� �� ������� ���������� � ������, ������ � �������� �������, ���������� ��������� � �������� �������������� �����������. � ������ ���� ����� ������ ���������� Tesko - ��� ������ Disco � Techno.��������� ������ ����� ������ X-Press-2, �� ���� �������� ������� Disco � Rave - Rave Music. ��������: Tesko ���������� ����� Disco, House ����� � Techno �������������. �� 120 �� 130 BPM. �������: X-Press-2,Ming''s Incredible Disco Machine,Cotton Club � ����������� �������� Stress � Whizz �������.\r\n'),
(77, 'Downbeat', 'Downbeat - ��� ������� �������, ������������ ������ ��� ������ �������� ambient-house � ambient-techno. ����� �������� ��, ��� ����� � ��������� ����������� ������ � ����� \"ambient\" ����������� ��������� ���� ������ �� ������������ � �������� 90-� �����. ��� �������� ����� ������������� ������������� ��������� breakbeats ������ ���������� four-four beats, �������������� ������������ ������������ ambient-house � ambient-techno. ���� ����� ����� ��������� � ���� �������� by trip-hop, ambient-techno � electro-techno. � ����� ������� �����������, downbeat - ��� ����� ����� ����������� ������, ��������������� ��� �������������, � �� ��� ��������.\r\n'),
(78, 'Drill''n''bass', '������ ����� ����, ��� ���������� techno ���������, ����� ��� Aphex Twin � Squarepusher ����� ���������� ������ drum''n''bass � �������� 90-�, ���, �����������, �������� ��� ��� ����. � ���������� Drill''n''bass, ��������� ����� breakbeat jungle, ������� ������������ ������� ������� �� ������ ������������ ����� � ����������� ����������������, - ���������� ������ midtempo beats and breaks � ����������� ����������������� ������� ����������� ������, ���������� �� ���� ���� ��������. ������� � �������� 1995�. , ��� �������� ������ ���������� ����������� � ����������� : Aphex Twin (Hangable Auto Bulb), Luke Vibert''s Plug project (Plug 1) � Squarepusher (Conumber). � ��������� ���� ����� drill''n''bass �������� ���������, ����� ������ ������ ������������� ��������. �������� ����� �������� Plug''s Drum''n''bass for Papa �  �������� ������ Squarepusher Feed Me Weird Things. ����� ����� ����� �������� �� ����� ������, ��������� ������ ����������, �������� � ���� �����, ������� Animals on Wheels, Amon Tobin, Mung, and Plasmalamp. Drill''n''bass ������� � �������� ���������� � 1998�., � ��� ���� �� �����������, �������� �� �������� ������������� ������� �����.\r\n'),
(79, 'Downtempo', '������������� ����������� Downtempo �������� ������� �������� �� ������� ���������� (����), ��� ambience, �� ������ �� ����� ������������, ��� trip-hop.\r\n'),
(80, 'East Coast Rap', '������ ������ hip-hop ���, ���� rap ����������� ����������� East Coast Rap. ��� ���������� rap ����������� ������� ������� ����� ������ � ������ New York City ������� ������ �����, ����� ��� DJ Kool Herc, Grandmaster Flash, Afrika Bambaataa, the Sugarhill Gang, Kurtis Blow � Run-D.M.C. �� ���� �������� � ����������� rap �����, �� ���������� ����� ������������� � ���������� � ������� 80-� �����, ������� ����������� ������ ����� ���������� �� ���� ������. ��, ��� �� �����, ����������� East Coast rap ���������� ������������ �� ���������� 80-� �����. ���� �������� East Coast rap �� ���� ��������� ����������, ��, ������� � �������� � �� ����� 80-� �����, ���� ����� ������� � ����� ����������� ����� � ����������� �������, � ������ ������ ��������� ����� ����������� ����������������� � ��������� ���������� ����������. ������� �������, �� ������ �����������, East Coast rap ���� ����������� ������, ��������������� ������ ��� ������������ ���������, ��� ��� ��������, ��� ������� ���������� ���� ���� � ��������� �������������� �����, ����� ����������� � �����������. ��������� ��������������� ���� ������� ��� East Coast ���� ����� �����������, ��� Eric B. & Rakim, Boogie Down Productions � Slick Rick, ��� �� ������� ���������� ���������� ������������, �������� old-school �����, � ����� ������� ��������� EPMD � Public Enemy. �� ������ East Coast �������� ���� ���������� ���������� ������� ���������� ����������� ������ Native Tongues, ��������� Afrika Bambaataa. ����� ������, ��� De La Soul, A Tribe Called Quest, the Jungle Brothers ����������� ������ ���-�������� ������ ������� �������� ������� �� hip-hop � ����� 80-� �����, ��� ��� �� ����� ���� ��� ����� �������� ������ �� ����������� ���������, ��� �� ��������������� ������������. � 1989 �. ������� N.W.A. ��������� ������ Straight Outta Compton, ������� �������������� ����, ��� West Coast (����� ��������� ���������) ��������� ���� ���� � ��������� �������� � �������, �������� ������, � � ��������� � ������������ West Coast rap ��������� �������� ������� ����� �����, ��� party music, - ������� ������� ��� ����������� ������������ ����� � hip-hop � 90-� ����. ���������� ������ Southern rap �������, ��� ����������� East Coast rap �� ����� ������ ���������� ��������������, �� 90-� ���� ���� ������������ ������� � ���� �������. � ���������� � Bad Boy, ����������������� ��������, ������������� Puff Daddy � ���������� �������� ������, ��������� ��������� (East Coast) ��������� �� ����� ����� ��� ��������� ���� �� �����, �� ����� ���������� ����������, ������� ����������� ������ Nas, ����������� Fugees and Roots, � ����� ������� Wu-Tang Clan, �� ������� ������� ������� ������ hardcore.\r\n'),
(81, 'Electro', '�������� funk 70-�, ������������� hip-hop �������� � ����������� ���������� (����������) � ������ 80-� ����� ������� � ��������� ������ ��������������� ����� ������ - Electro. �� ��, ��� ������� �������� ����� ���� ���������� ����������, �������� 2-3 ����, �� ������, ������� ���������� Afrikaa Bambaataa (\"Planet Rock\") � Grandmaster Flash (\"The Message\"), �� ���� �� ������� �� ����� � ���� Top 40 �� ����� ���� ����� ������� ���������� ��� ����������-���������, ������� ������� ����� ����������� ���������� ������������ ����������� � ������, ������� Dr. Dre (�� ������� � the World Class Wreckin'' Cru) � ��������� ���� techno Juan Atkins (��� ������� Cybotron). ����� Electro ����� ������� ��� ���� ���������� ����������� ��� ������ �� ������ ��� �����������: Herbie Hancock, ��� ������ 1973 �. Headhunters � fusion ����� ����� ���������� � 1983�. � ������� \"Rockit\", ����������� � ���� �����. �������� �� ������� ����� (� ���� ����� �������� ������ Rhino Electric Funk �� 4 ������), ����� ��� ������ �������� � �������� 80-� ����� � ���������� hip-hop ��������, ������������ ������ �� ������� (����� ���-����������), ��� �� ����� �����������. ��� �� �����, ������ techno � dance ��������� ���������� ������������ � ������ �����, � ��������������� ����������� electro ��������� � �������� � �������������� � �������� 90-� �.\r\n\r\n'),
(82, 'Electro-Industrial', '�����������, ���������� � ����� Electro-Industrial ����� ��������� �������� � ������, ��������� ������ �� ������������� thrash �����, ������� ������������ � ����� industrial �������, ��� Nine Inch Nails � Ministry. �������, ������� Cubanate, Le�therstrip, :wumpscut:, Haujobb, Kill Switch...Klick � Mentallo & the Fixer ������ ����������������� �� ����������������� � ����������� ������� ������ � ����� industrial, ������� ������� ����� �������������� ����� �����������, ���  Throbbing Gristle, Cabaret Voltaire � Front 242, ������ ���������  Black Sabbath. � ��� ������ Metropolis Records �������� ������� � ����� electro-industrial.\r\n'),
(83, 'Electro-Jazz', 'Electro-Jazz - ���� �� ��������� fusion, �������������� ������ ����������� � ������� ����� �����.\r\n'),
(84, 'Electro-Techno', 'Electro-Techno ������ ��� ������� ������� � ����������� �������� 80-� �����, ��������� � ������������ electro-funk, � ����� Detroit techno � ��������� ambient-house. ���� ����� �������� � �������� 90-�, ����� ���������� ����� ���� ��������� ������������ � �������������� ����� electro � ��������� � ���������� ������� � �������, ������������ ���������� ��������� ����. ���� ����� ������ ����������� �� ������������ �������������� electro, ����� ��� Afrika Bambaataa''s \"Planet Rock.\" �� ����� ���� ��� ���������� ��������� ������������� ������� Clear Records � ������ �����������, ��� Jedi Knights, Tusken Raiders � Gescom (���������� Global Communication, Ziq � Autechre ��������������) ������ �������� ������, ��� ������ �������� ����������� ������������, ����������� �� ������ �������� ����� 90-� �����, ������� ������ ���������� ������ Skam Records, Sweden''s Dot Records, � ����� ������������ Drexciya � Aux 88, ������������� ����� ���� � ��������������� ��������� ������������� ���� ������.\r\n'),
(85, 'Electronica', '���� ����� �������� ������ ��-�����, �������� disco � funk � ������� 70-� �����, �������� �� �� ������������� ������ �������� ��� �������� ����������� ����������. ����� ����� Electronica ����� ����� ��������� ������������ � ������, ������ ������ ����� ������ � ���������. �������� ��������� ����� ����� ��������� � ������� ��������� 2 �����������. ���������� ����� ����������� ���� ��������� �� �������� ����-�����, ������������� � ������/���-����� � ��������. ������ � ���� ������� ����������� house � techno (��������������) � 80-� �����. ��� � ����� 80-� ����������� ���������� ������ ������ ������� �� �������� ������������� � ������������ ������, ������������� � ������, ������� ���� ���������� ��������� ������, ����� ��� jungle/drum''n''bass � trip-hop. ���� ���������� ����������� ����������� ���������� ���� �������������, � ������ 90-�, ��������� ������ ������ ������ ��� ����������. ��� ����� ���������� ������� �������������� �������� (��� ���������� �����), ���, ��������, ambient/house, experimental techno, tech-house, electro-techno, � �.�.. ��� ���� ����� ����������� ������, �������������� �� ���� ����������� ������, ���� ������� �������� ������������ ���������� � ��������� ��������� (���� ��� ������ ��������������). � ����������� ������� � ������ ����� �������������� ������� ����� ����� ��������, ��� ����������� �� ���������� �����������.\r\n\r\n��� ���� ������� ����, Electronica, �������� �������������� ������, ������� ������������ ��� �������� ����������� ������������ ������, ������ ��������� ������, ������������ �� ���������, ��� �� ����� dance. ����� Electronica ������� �������������� � �������� �������� ��� ��������� (�� ����� ���� ��� ���������� New Electronica), ������� �������� ������ ������������ Detroit techno, ����� ��� Juan Atkins � Underground Resistance �� ���� � ������������ �����������, ������� ������ �������������� �� ��������������� ������ ��� techno �� Motor City. ������� ������������ ������ ������ ������������ ���� ������ ��� �������������� ����������� ������ �������� ���������, ������������� ����������� ������������ �/��� �����������, �� electronica ������ ��� ����������� ����������� ������ �� ���� techno, ������� �������� ��� ��������� ������������� � ����������� �� ����-���� (��� ��� ������ ����������� electronica ����� �������� DJs).\r\n'),
(86, 'Experimental Dub', '�� ���������� ����� ���� �� ��������� ������, ������� ���������� ���������� �������� ����� ������, ���������� �������� Experimental Dub. Hard Wax Records, ����������� ������� � ���������������� ��������, ����� ������ ��������� ���������� ������, ���������� � ���� ����� (Basic Channel, Chain Reaction, Imbalance) � ���������� (Maurizio, Mark Ernestus, Porter Ricks, Pole, Monolake). ��������� � ���� �����, ����� ��� Jeff Mills, Rob Hood, and Plastikman �� ������ ������� ������� Chicago acid house  � ��������������� Detroit techno. �xperimental dub ���������������� �������� ������ - ���� ������ ������������� �� ����� ���������� � �������� ����������, ������� �������� ����������� ��������� ��������, ���� midtempo beat � ������ ������ �������. � ������ ������ �������� � ������������ ������ Jamaican dub ����� ����������, ��� King Tubby � Lee \"Scratch\" Perry, ���� ���������, �� ������ ������ ������� ��������� ������������ ���� ������ ������ ����������������� ��������. ����� ������� Basic Channel camp, ������� � ����� experimental dub ���� Mike Ink (aka Wolfgang Voigt) � Thomas Brinkmann. Ink ���������� ��������, ����������� ��� ����� ��� 6 ������������. � �������� �� ������� � ������ ������������������ ����������, ��� Profan � Studio 1. Brinkmann, ������������ ������� �������� ������ � ���� �����, ������� �����, ��������� �������� �� ������ Ink � Plastikman. ����� Experimental dub, � ���� ������� ��������� ���������� ������� �������������� techno �������� (������� Plastikman � Mills) � ����� 90-� �����, ��� ������� ����� ���� ���������� � ������������ American indie rock � post-rock.\r\n'),
(87, 'Experimental Ambient', '����� Experimental Ambient , ������������������ �� ����������� ambient ������������ �� Tod Dockstader �� Brian Eno, � ���������� ����������� � ������������� ������������, ���������� ������� ������ ����������� ���������. ���� ����� ����������� �� ���������� ������� (Robert Rich, Vidna Obmana) � ������ � ����������� (Paul Sch�tze, Lustmord) �� white noise (K.K. Null, Main) � post-punk experimentation (Rapoon, :zoviet*france:). Experimental Ambient ������ �� ������ ����������� �����, ������� new age, electronic dance, jazz � ����������.'),
(88, 'Experimental Electro', '������������� ������������� ����� electro, ���������� ��������� neo-electro, ������ ����� ���������� Experimental Electro � ����� ����������� �������������� � ������. ��� ����������� ��� ��� ���������� �� ���� ������� �������� �����, �� � ����� ���������������� ���� � ��������� ��������� ������. ����� ������������� ����� ����� ��� Freeform � Bisk.\r\n'),
(89, 'Experimental Techno', '������ ����������� ������������ ������ ���������� ����������� ����������� ��� ������������, ������� ����������� Experimental Techno ����� ������� ������ ������������� ������ �� ������������� ��������� ����� � �������, �������������������� ������������ ������������������ Oval � Panasonic, �� ������������� �������� (�� � ������ ����������� ������), ������������ Cristian Vogel, Neil Landstrumm � Si Begg. � ����������� Experimental Techno ����� ����� ���������� ����������� �����������, ����� ��� Twisted Science, Nonplace Urban Field � Atom Heart, � ����� �������� ������ ��� Alec Empire, � ������ ����������� Industrial (������� ��������� � ����� �������), ��� Scorn, Download ��� Techno Animal. ����� ��������, ����������� ����� ���� � ����������� ������������ ������, ������� �� ������� �� ���������, ����� ���� ������ �����������������, � ����� ������ ����� ���������� ���������� �����.'),
(90, 'Experimental Jungle', '�������� experimental techno � drum''n''bass breakbeats. �xperimental jungle - ��� ����� ����������� �� ��������������� ��� ��������. � �������� ��������� � ����� Experimental Jungle ����������  ���� � ��������� (avant-garde) (Twisted Science, T.Power, Richard Thomas), ���� � indie rock (Third Eye Foundation, Designer).\r\n'),
(91, 'Freestyle', '��� ����������� ����� ����������� ��������� � ������ ������������ �������, ��� electro � house. Freestyle ��������� � ���� ������-������������ �������� New York City � Miami � ������ 80-� �����. ����� �������� Freestyle, ��� \"I Wonder If I Take You Home\" �� Lisa Lisa & Cult Jam, \"Let the Music Play\" �� Shannon � \"Party Your Body\" �� Stevie B ���� ��������� �� ���� ��������� ������������� �����, ������� �� electro � ������ house, ������, ����� �������������� ������������� ����, ���������� � ������������ R&B � disco. �������� ������������ ������ � ����������� ������� ����� ������� ������, ������� ���� � ���������� Shannon � Lisa Lisa �������� ������� ������� Top 40 � 1984-85 ��. Freestyle ��������� ��������� � dance pop � ������ ��� �������� � �������� 80-� ����� ����� ������ � ������ �������� Madonna - John Benitez (aka Jellybean) ����� ����� �������� ���� � �������� freestyle. � ����� ����������� ����� ��� ������������ Brenda K. Starr, Trinere, Cover Girls, India � Stevie B ������� �� ������ ������������ � pop ��� R&B �����. ���� ����� �������� ������������ � ����� 80-� �����, freestyle ������� � underground � �������� �������� ����������� ����������� ������������ ������ ������ � house, techno � bass music. ��� � � ������ � mainstream house, ����������� freestyle - ��� ������ (����, �����������, �� ������) ������� ��������� ���������� ��� �����������-�������. ����� ������, ����� ��� Lil Suzy, George Lamond, Angelique, Johnny O � ������ ����� �������� �������� � �������� freestyle.\r\n'),
(92, 'Foreign Rap', 'Foreign Rap - ��� hip-hop � rap ��������� �� ����� �����, ����� ����������� � ����������. � ��������, ����������� foreign rap ����� ����������� �����. ��� ������ ���������� Euro dance, � ����� American hip-hop. ���� ����� �� ����� �������, ��� American ��� British hip-hop, �� �������� ���� ����������� �������������, ��������� �������� �������, ������ ������ ���������� ����� ������������. ���������� ����������� �� ����� ������� ���� jazz-rap, �������, ��� � European hip-hop ��������� ������������� ������� �� ������� ���������� acid house � acid jazz. ������� ��� ��� ��������� ���� ������� � ����������� hip-hop.\r\n'),
(93, 'Funky Breaks', '����� trance, hip-hop � jungle, ����� Funky Breaks, ��������� ����� ������������,  ���� ����� �� ����� ������ ���������������� ������ ����������� ������ ����� ���, ��� ����� ������� ������ � ��� ������ � �� ������ � ����� 90-�. ��������� ����� ����� ����� the Chemical Brothers ���� James Lavelle (������ Mo'' Wax Records), �� funky breaks ������������� ������ ������� � 1997�. � ���� ���� �������� ����������� ��������� ������������� ������������� ������ ����������� new electronica. ����� �������, ������������ ��� ����������� ���������, ����� ��� the Prodigy, Death in Vegas, the Crystal Method, Propellerheads ��������� �������� ����� �����. ��� ����� ����� �������� �������� ��������� electronica ���������, �� ������� ���� � ������������ �����, ��� ��� ��� ������������ ��������� ������ ���������� ������.\r\n'),
(94, 'Funk', 'Funk ������� � 1970-�� ����� ��� �������� \"������\" ����������� �������� (����� � �����). ������������� Funk ������� ������ ������, ������� - � �������������� ����������� ����������. ���� ����� ������������ ������� - 80-110 bpm. ��� ������ ����� �������� ����� ��������������, �������� Jazzy-Funk. �� ���������� ��� ���������� \"Funky-����������\", ������� ��� �������. ���������� ������ Funky ����������� ����������. ��� ����, ����� ��� ������, ��� ������ ���������� ��������� ��� ������. ���� ��������, ��� ����������� ������ ����� �������� Funky-�����������: ������������ ���������� - ��� ����� ���������� ����������� ������������ (�������� �����), Funky-������ - ����������� ����������� �������� ����, ��� ���������� �������� ������� ���������������, ����-������ �� ������������� - ����� (�������� � ����������� ��������) ����������� ������� ���������� ���-���, ����� ����������� \"������\" �����, ������ ��������������� ������� � ������� ����������� : ������, ��������, �������, �� ���������� ������� ������������ �� ����� �����, ��� � Acid-Jazz, �� ������� ������ ���������������.\r\n'),
(95, 'G-Funk', 'G-Funk - ��� ��������� (������������� Parliament/Funkadelic) ������ gangsta rap, ������� ����������� ��� ������ Dr. Dre � ������ 90-� �����. ��� ����������� ���������� ���������, �������� �������������, ��������� ������, ��������� ������ � ������ �������� ������� ���-�������. ����������� G-funk ����� ����� ���������� ������ hip-hop � ������ 90-� �����. ����� ������ ������� Dr. Dre The Chronic � 1992 �. � ���� ������� �������� �������� � ������ ����� ���� ������ ����� rap ����������� � ��������� ����� ��������� ��� ����������� �������, ��� � ���������� ������� G-Funk ����� ���������� rap ������� ������ 90-� �����.\r\n'),
(96, 'Gabba', '���������� ������������� ���� ����� ����������� � ��������� � ���������. Gabba  - ����� ������� ����� hardcore techno, ����� ���� ��������� 200 BPM. ���������� DJs � ���������, ����� ��� Paul Elstak � Mover ����������, ��� gabba ��������� �� ��������� trance � ����������� rave. � �������� 90-�, ��� ������ ��������� ��������� ���������� ��������, ��������� � ����������� � ��������� ������������ (���������), ���� ��� ���� ������� ����� ���������� �� ��������� ����� �������. �����������, �� gabba ������� ��������������� ���� � ����������� ������ ���-������, ���������� ��������� ����� �� Elstak. ������ ��������� � ������ �������� ��� ��������� ����������, � ������ ����������� ����� ����������� �� hardcore � ��������� (��������) hardcore.\r\n'),
(97, 'Garage Rock', 'Garage Rock ��� �������, �������������� ������ rock & roll, ������� ������� ��������� ������������ ������ � �������� 60-� �����. �������������� ������� ����� ������ ������� British Invasion, ��� Beatles, Kinks � Rolling Stones. ��� ������ �������� ������ ������ �������� �� ���� British Invasion rock. ��� ��� ������ ��� ���� ������� � ������������������ ���������, �� ���������� ����� ������������ �� ��������� � �������, �� ������ ��� ������������ ������������� �����. ����������� ����� ������ ������ �� ������������ �����, ����� �� �� �� ��� �������, ������ ������ �� ������� ����� � ��������� ������� �����. � ������� ������� ������� � ����� garage ��������� ������ ����� punk ������� ������ ���� ���. ����� �� ���� ������� ����� ���������� ����� garage �����, � ������������ �� �����, ������� Shadows of Knight, Count 5, Seeds, Standells, ���������� ��������� ����, � ��������� ���� ��������� ��������������. �� ����� ����, ����������� ��� ��� ������ ���� ������ ��� � ������ 70-� �����, �� ������� ���������� Nuggets (���������) �������� �� �����. � 80-� ����� ����������� ��������� ����������� ����� garage rock, ������� �������������� ����� ����� ����������� �����, ������� �������� ����� �������������� ����, ����� � ������� ��� garage ������ 60-� �����.\r\n'),
(98, 'Gangsta Rap', 'Gangsta Rap ����� ��� �������� � ����� 80-� �����. ��� ����������� ����� ������ � hardcore rap. ����� gangsta rap ��������� �������, ������ ������. � ���������� ��������� �� ��� ����� �� ������, ��� � ������ �������� ������� � ��������� ����������. ������ ������ ���������� ������ ������������ ����������, � ������ ��� ���� ������ ����������� ��������������� �������. � ����� ������ ��� ����������� ����� ����� �������� � ������������ ��������� � ������� �������� hip-hop � ����� 80-� �� ������ 90-� �����. � �������� ������ ����������� gangsta rap ���� �������� ������������ �����������, ��� ��� ��������� ������������� ����������� ����������� �������� ��������� ��������������� �������� ���� ����������. ���� �����, ����� ������ ���������� ��������� ��������� ������ �� ���������� ����������������� ��������, ��� ���������� ��������� ����������� ������.\r\n'),
(99, 'Glitch', '�� ���� ����, ��� ������������ ������ �������� ��������� ������������ ���������� ������ � �������� ������ � ����� electronica, ������� ��������� ������ ������ ��������� �������� �������, - � ��� ����� �������� ��������� ������ clicks + cuts � ����� 90-� �����. �� ���� �������� ������ �� ������������� ���������������� ������� ���������, ������������ � ��������, � ����������� ��� ����������� �����, ������� ������������������ �������� ��������. ����� �������� ����������� ������ ����� ���������� ����� �������� ��������� � ��������� �� ��������� ����� ������� � �������� ��������, ��������� ������ ��������� � ������ ����������� �����������. ����� � ������ 90-� ����� ���������� �������, ����� ��� Aphex Twin � Autechre ���������� ������� �������� ����� electronica, �  ������ ���������������� ������ �������� �� ����� � Robert Hood � Basic Channel ����������� ������������ �� ��������� electronica, ������� ����� ����������� �����, - �������� ������ ����� ������������ ������, �������������� ����������� ����������� ��� �������� ������� ����������, ������� �� ���������� ���� ������ ��������. ������� ��� ����������� ��������� ������� ��������� techno Achim Szepanski � ��� ������ ����������������� �������� Force Inc, Mille Plateaux, Force Tracks, Ritornell . ��� ��������������� �������� ����������������� ����������, ����������� ���������������� ������� �� experimental techno, minimalism, digital collage � noise glitches, ������ ������������ � ����� ��������. ���� ����� ���������, ��� Oval, Pole � Vladislav Delay, ���������� ���������� ��������� �� ������ ������ �����, �� ��������� ������� Mille Plateaux Clicks_+_Cuts ������� ��������� ��� �������� �����������, ���������� �� ������ ������� ����� ����������, �� � ������� ������� ������ ��������� ��������. ���������, �������� � ���� �������, ������ � ��������� ������� visionary ������������ �� ������������ � ������������ ������ San Francisco/Silicon Valley (����������� ������) � California (������ Cytrax), ������ ����� �������� ������� �������� electronica. ����� ����������� clicks + cuts ����� ����������� ������� ������������ ������, ��� � ����� �������� � ����������� �������� ������, ����� ���  click-driven house �� MRI � glitch ������ N.W.A.''s \"Straight Outta Compton.\" �� Kid-606.'),
(100, 'Go-Go', 'Go-Go - ��� ��� ����������� ������ ������� hip-hop, ����������������� ��� house ���������. ����������� ���������� � ����������� go-go ���� �������, �� �������� ������� ������ ���, � �� �����. � �������� 80-� ����� go-go ��� ����� ��������� � ����� rap � R&B �����������, �������� � ������ ������ �������� (DC), ������� ��������� ������� ����� �����������. ���� ��� ���� go-go ������� �� ���� ������ ������ � ������� �� pop ����� - ����� ������� ����������� � ����� ������ ���� �������� � 1988 �., ����� ������� � ����� go-go, EU ��������� � Trouble Funk, ������� �������� ��� ������ � \"Da Butt,\" (Spike Lee''s School Daze). � ����� 80-� ����� � ������ 90-� go-go ��� �������� �� ����� ������� ������� Miami, ������� ��������������� �������� �������� � DJ ����������� go-go, ��������� ���� � ����� ���������� � ����������� ������.\r\n'),
(101, 'Goa/Psychedelic Trance', '������� ����� ��� ������ �����������. ��������� ����������� ����� ���� �������� �������� ����� ������, ������� ��������� � �������� ��� � �����. ����������� ���������, ������������� ��������� ����������, ��������� � ���������, ���������� �������� ���� ������� � ������ � ������� ����� ��� �� ���. ���������� ������� ���-������ ��������� ���������� ������ ���������, ������� � �������� ������� ��������� ��������������� ��������� �������� ���-����� �������, ������ ����� ����������� ��������, �� �� ���� �� ������� ���������� � ����� ��������� ���-������. ���-������� ����� �������� ������, ������������� ��� ������. ���������� ����� ���-���� ��������� �� ���� ���� ������-��� ������ �������� ��������� ����� ��� ��������� Psychedelic Trance. ������������� Psychedelic Trance ���������� �������, ������������ ���� ����� ��������������� � ��������, ���������, ����� � ��������� ������ �������� ������.\r\n\r\n��� ����� ���-�����? ��� ������ �����. ����� ��� �������� ����. ������ ��� �������� � ��������. Psychedelic �������� � ���� ����� ������������ ������������� �����, ������������������, ����� ������ � �����, �����, ��������������� � hi-tech/space �����������. � ����� ������ ��� �������� ����, ���� ����������� ������� �� ������������� ������������ ����. ��� ��� ������ ����� ������������, ����� ���������, ����� ����������. Goa/Psychedelic Trance ��� �� ������ ������������ �����, ��� ������� ���������� �� ������ ������ � ���������, �� ���������.\r\n\r\n������������ ��������� �����������, ����� ��� ����� � ����� (��� �� ����������� �������) ����� �������������� ��� �������� ������ � ��������� � �������, ������������� ������������, ������� ������ �������� trance. ��� ����� ����������� ������ �������� ��� ������ ��-����� � ��������� ���������, ��� ������ ����������� ������������ ����� (������ ������ ����� ������������� DAT). ������� ����� Goa �� ����� 90-� ����� ���������� ������������ ��������� ����������� DJs, ������������������ ��� �� ����� ����. ����� ����������������� �������� ��� Dragonfly, Blue Room Released, Flying Rhino, Platipus � Paul Oakenfold''s Perfecto Fluoro ����� ������ ���������� ��������� ������ ������������ ���������. ����� ���������� ���������� DJ Oakenfold, �������, ��������� Goa trance ������� ������ �����������, ������� ��� �� ������� �� ���������� ���������� ���. �� ��������� ��� ������ � ����� ����� � � ������ �� ���� ������. � �������� (Return to the Source) Goa trance ����� ��� ������ ������, ������ ��������� ��� �������� ������ trance ������.\r\n\r\n������: Perfecto Fluoro, Tip Records, Symbiosis Records, Flying Rhino, Blue Room, Transient.\r\n'),
(102, 'Golden Age', '������� ��� Hip-hop ����������� ������������ �������� Run-D.M.C. � 1986 �. � �������� ������� ����������� gangsta rap � �������� The Chronic �� Dr. Dre. (1993 �.) ��� ����� ��� ���� �������� ������� �������� �� ����� ������� ������� � ������� ����� ����� LL Cool J, Public Enemy, EPMD, Big Daddy Kane, Eric B. & Rakim, N.W.A., Boogie Down Productions, Biz Markie. ����������� ����������� ����������, ���������� � ���� �����, ��������� � New York City, � ��� golden-age rap ��������������� �������� ������� �����, ������������� �������� �� hard-rock ��� soul ������ � �������� dis raps. ����� ������ ��������, ��� PE''s Chuck D., Big Daddy Kane, KRS-One � Rakim �������� ������ ������� ���������� (���� ����) � ������� �������� hip-hop. ����������������� �������� Def Jam ����� ������ ������� ����������� hip-hop �������, � �� ����� ��� Cold Chillin'', Jive � Tommy Boy ����� �������� ������� �������.\r\n')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(103, 'Gospel', '���������, ��� ��������� \"������ ������\" ���� � ������ ���������� � ��������� ���� ����������� ����� ����� �. �����, ����� �� ������ �������������� ��������� ���������� \"��� �������\". �������� ������ ���� ������������� ����������, ������ �� ������� � ���������������� ������ �������, � � ��� ���� ������� ���������� ��� � ��� �� �������� ������ �������, ���� ������ ����������� ������ ���������� ��������������, � ������������� ����� ������ ������. ��������� ����� ������� ������ ������� ������ � ���������� � ������� �� �������������� ����������� ������. ��������� ������ �������, ����������� � ���������-����������� ���� - � ����� ������� ������ ��� ���� ���������� ����� �� �� ������� ��������, - �� ������ ���������� ����� ����� ����� ������ � �-������� � ������ ��-���, ���������� ��������������� ����� � ����������� ����. ����� ������������ �������, ���������� ����������� � ��������� �����, ������� ������� ���� ���� � ������ ���������� - ������ ��� �������������� ������������� ������� � ���-������. ������������ ����� ���� � ������������ ���� ���� ��������� ��������� ���� ����� ����������� � ������� ������, ��� ����� ��������, ������ ������ � ������� ����. ����������� ����� ������� - ������ ������� ������ � ��������� �����, � ��������������� ��������� - ������� ����� �������� � ������ ������������, �������� ��, �� ������� ������ ������ � ���� ������, �� ��� ������, ����� ������� � ���� �������� �� ����� �������, ���� ��������� � ������.\r\n'),
(104, 'Happy Hardcore', '���������� ���������� �� ����� � ����� 80-� ������ 90-�, ����� Happy Hardcore, ���� �� ������ ���������� ���� � ���� ����������� ���������, ����������������� ��� ����: ����� ������� ����� ������ � ������ (beats), ������� ���� ������ ��� �����������/������� � ��������� ������ � �����������, ���������� ����� ���������� ������, ������� �� ����� �����. �������� jungle/drum''n''bass ����� ����� �� ����� rave, �� ��� ��� ����������� ����������� � ������ ����������� ��������. ���������� �������������� ����� happy hardcore ����������� ������� �� ������� ������ ����������� ������, ��� ������, ��������������� ��� ���������� ����������. ������ ����� ��� � ��������� ���������� ����� hardcore-into-jungle � ����� ����������� ����� ��������� ��������, ��� � happy hardcore ������� ���������. ���������� ������ DJ/����������, ����� ��� Slipmatt, Hixxy & Sharkey, Force & Styles , DJ Dougal, ��������� ������� ������� ���������� ��������� �, �����������, ������� ���������.'),
(105, 'Hard Blues', '��� �������� �������� ������, ����������� ����������� ���������� ���� ��� ����� ������������ ����. �������, ����������� \"������������\" ������������, ���������� �� ���������� ������, ��� ������� �������� ����-������. ���� ����� ����, ��������� � ����������� ��������� ������, ��� ����� ������� ����-������. ��� �������, ����-���� ����� ����������� � ����������� ����� ����-����, ������ ������� ������ ��� ���������, ������� ����� �� ������������� ����-����, ��������������. �������� ������� ����-���� � ������������� ���� ����, � ����� �������� ����� ���.'),
(106, 'Hard House', ''),
(107, 'Hard IDM', '�������� ������������� ��p��� ������� ���p������� �������� ������� ��p��py������ � p����� y��p��� ��y�� � p����� ����������. ����� � ����� ������ ��� �� �������� �� �p����� � �������. ���� � ����� ������ ������ �p��������� ��� ��������, ���� ������� ������� ������ �p���������� � ����������. � ������� � �p������� ��������� ����� �����, �p��y����y�� ����� p����. ��� ��� ���� ��� �p��y����y��, �� ���-�� � ������ �� p����, �� ������ �����. � ��� ���� ����� ������������ ����� �p��� ������� �� �������, ��p��py������ ��p����, �p������ �������, �p����� �y������� � �p���� �y���. �y�� ������ �p��������� �������p�������, ���� ������ ��p��������� �����. ������� - ����� � ���������� ��� ����� ������ ����� �p����� � ��������, � ����p� ����� ��y��� �� ����� �p������ � �y������ ������� p���. ����� �p�� �������� IDM ������� ���y� �y���y ��� p�� ����� ������������ �y����� �� �����.\r\n'),
(108, 'Hardcore', '������� ������� �� �����, ����� ������� ����-�������� �������� ������ ������ ��������, ��� ��� ����� ���, ��� ����� ��������. ���� ����� ��� ������� ����������� ��-������, ����� �������� ��������� ���������� ����������������� �����. ����������� ��������� ������� ����� ������� � ������� ����� � ������� ��� Hardcore. ����������, ���� ����� �������� �������� �����. � �������� ������������ ����� ������� ���������� ������ �����, �������� �� ��������� �� 150 �� 180BPM. �������, � ��� ��� ������� �������� ������ ���������, ��������� ��������� ����������� Happy Hardcore, Speedcore, Gabber. ������ ���������� ������������ ���� �� ������, ������������ ������� ������, ����� ������ ������� ������ ��� ����� �� ���, ��� ������ � ������ 90-�. ����� �������-���������� ��������� � ��� ����������� old school hardcore.\r\n\r\nHappy Hardcore �������� ���������� ����������� ��������� �������� � ���������� � ��������� ��� ������� �������� ������ � �������� �������� ������� ����� �����. ���������� ����� ����������� UK-������ Happy Hardcore: � ��� ����������� ������������ ������� � ��������� ����������� ������������, ������� ������ �������� � ������� hardcore.\r\n\r\n���������� ����� ������������� �����������: Holland Hardcore ������� ����� �������� � ���������� � ����� ������� � �����.\r\n'),
(109, 'Hardcore Rap', '��� ����� ��� ���� ������ ����� ���������� � ���������� ����������� �����������, Hardcore Rap ���������� ������������� � ���������, ��� � ���������� ������, - ��� �������, ��������� ���, ������ ������ � �����������, ��� � � ����� ������ ����������. Hardcore rap - ��� �������, �������, ����������� � ����� ���������� ����� (���� ��������� ������ �� ������ ����� �����, ����� ����� �������� ����� ��� ����� � ����� ������). ����� Gangsta rap �������� ������ ������������ � hardcore rap, �� �� ��� ���� hardcore rap ��������� � �����, ������������� gangsta, ���� ��� ���� ������ �� �������� ������� ���������� ����������, �������� �� ����� hardcore ������� 90-� �����. ������� hardcore rap �������� �� ��������� ��������� (the East Coast) � ����� 80-� �����, ����� ��������� ������ �������� �� ������� ������. ������ � ����� ����� ������ �������� �������� ������� ���������� ����� ������, � ������� ��� ������ ����������� � �����������. �� ����������� ������������� ������� ��� ����������� gangsta rap ����� ���������, ��� Boogie Down Productions (���-����) � Ice-T were (���-��������) � ����� ���������� ��������� ��������� �������� ���������� ������� �����. ���� � �����, ��������� �������� ���������� � ���������� Public Enemy ������������� ����� ��������� � ����������������� ���������, � ������� N.W.A. �������� ��������� ������ ����� ghetto � gangsta ���������� ����������� �������� ������. � ������ 90-� ����� hardcore rap ���� ��������� ����������� West Coast gangsta rap. ��� ������������ �� ��������� � 1993�. Wu-Tang Clan, ��� ���������, �������������� ���, ��������������� ����� � ������������� ������, ����� ������ ������������. ������, ������� ����� hardcore rap ������� ��� ����� ����� ���������� ������, ���������� � ���� �������� hip-hop � ��������� �������� 90-� �����. ��� ������ ������� ��� ��������� ��������� ������� �������, ������������� �� �������/ �����/ �������, �������� ����������� gangsta � ��������� ���������� ����������� �������������. ������� ����� ����������, ��� ���������� B.I.G., DMX � Jay-Z ����� ����������� �� ������� ������. � ����� Master P, ������� � ������ gangsta-���������������� Southern hardcore, ����� ���� �������� ������������ �����, ���� � ��� ������, ����� �� �� �������� ����� ����� �� ����� �� ������.\r\n'),
(110, 'Hip-Hop', '������������� rap ������, Hip-Hop ������ ������� � �������� �������� �� ������ �����, ��������� breakdance � �������� ����� � ���������� � ������� ��������� ���������� ������. ��� ����������� �����, ������, hip-hop ��������� � ���� ������, ������� ���������, �������� �� ������� ��� ��� ��������. ��� ��� ����������� ��������� �� ����������� ����� ���������� �����, ����� ����� ������� ������ ��������, �� hip-hop ������� ����� ������������ �� ���������� ����� old-school ��������, ��� MCs Kurtis Blow � Whodini, � ����� DJs Grandmaster Flash � Afrika Bambaataa. �� ����� ���� ��������� ������� ������������ (Zulu Nation) ��������� � ����� 80-� ����� ������ ���� ����� ��������� hip-hop ������������ - De La Soul � A Tribe Called Quest. � 90-� ����, ����� ��������� ��������� ������ � rap ������, ������� hip-hop ���������� ����� ������������ � ������� old school (������ �����), ������� ����� ����������� ������� ��� Mos Def � Pharoahe Monch.\r\n'),
(111, 'Hardcore Techno', '����� ������� � ������ ����� ������������ �������� - Hardcore Techno � �������� 90-� ����� �������� �������� ����� ����������, ������� ����������� breakbeat, jungle, ��������������� trance, ��������� punk � ������������ ��������. ������� ���� ����� �������� � �������������� �� ��������� Summer of Love (���� �����) � 1988 �. ���� ���������� ����������, ���������� �� ���������� � ����������� �������, �������� ������������ ������� �� ������� �������� ���������� acid house, �� ���������� ������������ ���������� ��������� ������ �������� ��������� ����������� � ����������� ����������� �����. ������ DJs ������������ ������������� ����������, ���, ��� ����������� ���� house ����������, ��������������� ��� 33 ��/���. ������ ������ ��� � ��������� � ���� ������ ������ ����������� �������. � 1991-92 ������ � ����� hardcore/rave ��������� �����- � �������� ������ ����� ������ ��� SL2'' (\"On a Ragga Tip\"), T-99'' (\"Anasthasia\") � RTS (\"Poing\"). � ���������� �������� ����������������� �������� ������ ���������� �� ����� ������� ������ �������� �������, ����� ��� \"Go Speed Go\" (Alpha Team), \"Sesame''s Treat\" ( Smart E) � \"James Brown Is Dead\" ( L.A. Style). � 1993 ���������� ��������� (Rob Playford, 4 Hero � Omni Trio) ������ ������� ��������� ������ � ����� hardcore techno ������ ������������ breakbeat, ������� ��, ��� � ��� ���������� ���� ������ ������ ����������� ������ - jungle. ���� ����� ��������, ��� ��� hardcore ����� �������������� � ����� ������� ����� trance � gabba. \r\n� �������� 90-� ����������� �������� ��� ��������� ������������ ������ ��� ������ ������ �� ����� �����. ���� ������ hardcore/rave ���������������� �� ������ ������� �������������� � ��������������� ������, ������� ����� ��������� �� �� �������� ������������ progressive house ��� �������������� ambient techno. ���������� ����������� ��������������� ������, �� ������ � ��� �������� ������� ������������� �������� ����� � �������� ������ ��������������, ���������, � ����� � ������� ������ �������� � ��������� �� ��� ��������� ���������� ��� ��������� ��������� ������ �����������. ����� ����� ������� �� - �� ��������� hardcore � �������� (Alec Empire) �� happy hardcore � ��������������. �� ����� ����, �������� ����� ����� ����� ������������ �������� � ����� �����������.'),
(112, 'House', '���� ����� �������� � �������� 80-� � ������. � ����� �������������� ������������ �����, ���� ����� ��� ������ �������� �, ����������, ������������ � ������ ����� ������������� ������. ����� house ��� ������ ������������� ��� ������ � ���������� ������������� � ������� ����������� ����������� ������������ ����-����� � ������������. \r\n\r\n���������� ��������� ������ ������������� �������� ����� �����. ���� �� ��� ������, ��� House ������� ��� � ����� ����� ����� Warehouse, � ������� ������� ��-���� ������� ������ ����������� ������ Kraftwerk � ������� ������, ���������� �� ����-������. ����-������ � ��� ��� ������ ����������, � 90-� ��� ����� �������� ���������� � ������, �� ������ ����� �������� ������� ����� ������, � ����-���������� ������ ���� ���������� ����� � ���-�������. ���� ����������, ������� ����� 90-�. \r\n\r\n��� �� ����� ���������, ��� ������ ����. ����-������ �� ����� �������, ������� 130-140BPM, �������������� ��������� ������ ����� (�� ������ ������ ���� ����� ������� ������ ��� snare), �� ������ ������������ ���� ������ ���. ��� � ���� ����. ����������� ���� �������� � ������ � ����� ������������ ��������� ��������� �����, ��� ��� ��� ����� ���������� ��������� ��������� ����������� ����� �����. �������, ��� ����� �� ������� ������������� ��-�� ����, ��� � ���-�������� ������������ ���������� ���-���, � ���� ���� ��������� ��� � ����� �������� ����.\r\n'),
(113, 'Hip-Hop/Urban', '������ Hip-Hop � Urban ��������� � ����� 70-� �����, ������� �� �������� ����� �������������. ����������� Urban Soul ����� �� ������ ������� Philly Soul � ���������������� disco. Urban ����� ����� (���� �� ������) ������������� � ����������� ����� pop, ��� � � ������������� soul. ����� �������, ��������� ������� �����������, ����������������� ��������������� � ��������� ����������, Urban Soul ����� ��� ����� �� ��������� soul. �� ������ ������, ��� pop, ��� � ��������� ����� �� ������ ��� ������������� � ����-������������ ����������� ����� 80-� �����. ��������� ���������, ����� ��� Michael Jackson � Prince, ������� ���� ����, ������� ��������, �� ����������� Urban ���������� ���������� �� ���������, - � ����-�� ���������� ����� (Luther Vandross), � ����-�� ����.\r\n\r\n� ����� ����������� ����� Urban ���� � �������� ������������ ��������� Hip-Hop �������. Hip-Hop ��� ���������� ������ ��� ����������� rap � ����������� �� ��������. ���������� rap ��� ������ �������, ��������� ������ ��� ��� scratch � ���������� ���, �� �� ���� ������ �������� ��� ����������� �����������. ������� � ����� Hardcore, ����� ��� Run-D.M.C. � Boogie Down Productions, ������������ ������������ ������� ���� � ������ ������ �� ���������� ����������, ������ �������� ������ hard-rock �����. ��� ����������� �������� ��� ��������� Public Enemy, ��� ������, ������������ ����� � ������� ��� ����� ������������ � ����� 80-� ������ 90-� �����. � ����� ������� Urban ������ � ���� �������� Hip-Hop, ������������ � ����� New Jack Swing ����������� ������ Urban soul � �������� �������. ����� ����, ����� ������� ��� MC Hammer, Young MC � Vanilla Ice ��������� ���� �������� ������ ���� Hip-Hop, ����� ����� ����������� ��������� ������ �������� ������ � ����� pop-rap. ��������� rap ������, �������� �� ��� � ������� gangsta (�����������) rap. ������� N.W.A. ������������ ���� PE, �� ������� ������� ������ �� ������������ ������ �������, �����, ����������, �� ����� ������� ������ ��������� Ice Cube, Eazy-E � Dr. Dre ������ ������� �������, � gangsta rap ���� ����������� � ���������� �����������. ��� ������������ Dre, gangsta �������� ����������� ��� � ������� ��� �� Funkadelic. � �������� ��������� ��� ���� ����������� ����� ����������������, ������ Public Enemy, ������� ������ ��� �������� ������� � ����� Urban � ���������� ����� ���������� Mary J. Blige. ����� ��������� ��� ����� �������, ��� Puff Daddy ������������ ������ ������� ����� Hip-Hop � Urban soul, - ��� ��� ����������� ���������� ���������.\r\n'),
(114, 'Hard Trance', 'Hard Trance - ������� ������, ������������ ����� ������� ������ � ����� ������� ������ (145-165 bpm). � ����� ���������� �� ������ ������� ����� ������� ���������. H������� ����������� ������ ����-����� ������� � 1994 ���� �� �������� ������ HartHouse. ������� �������� ������� ��������������� � ������ � � ��������������� ������.\r\n\r\n������ ����-����� ����������� �� ���� ������������: ���� �� ��� ���������� � ����� � ������������ ����� �������������� ����������, ���������� ������������ ������. ������ �������� ������ ��������� Acid � Techno � ���������� ����� ������� � ����������� ���������.\r\n')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_tv_channel`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_tv_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_tv_channel` (`id`, `name`, `icon`, `type`, `description`) VALUES
(1, '1 �����', '1.jpg', '1', ''),
(2, '������ 1', '2.jpg', '2', ''),
(3, '�� �����', '3.jpg', '3', ''),
(4, '���', '4.jpg', '4', ''),
(5, '������ �', '5.jpg', '5', ''),
(101, '���', '101.jpg', '101', ''),
(102, '��������', '102.jpg', '102', ''),
(103, '�����', '103.jpg', '103', ''),
(104, '���', '104.jpg', '104', ''),
(105, '��3', '105.jpg', '105', ''),
(109, '�����', '109.jpg', '109', ''),
(235, '������ 2', '235.jpg', '235', ''),
(255, '5 �����', '255.jpg', '255', ''),
(276, '2x2', '276.jpg', '276', ''),
(330, '������', '330.jpg', '330', ''),
(676, '������ 24', '676.jpg', '676', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_twsfa_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_twsfa_category` (
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
  `setlinks` smallint(5) unsigned NOT NULL DEFAULT '0',
  `access_mod` varchar(255) NOT NULL DEFAULT '',
  `access_upload` varchar(255) NOT NULL DEFAULT '',
  `access_view` varchar(255) NOT NULL DEFAULT '',
  `access_rating` varchar(255) NOT NULL DEFAULT '',
  `access_com` varchar(255) NOT NULL DEFAULT '',
  `access_delall` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_twsfa_category` (`id`, `parentid`, `posi`, `name`, `alt_name`, `icon`, `skin`, `descr`, `keywords`, `news_sort`, `news_msort`, `news_number`, `short_tpl`, `full_tpl`, `setlinks`, `access_mod`, `access_upload`, `access_view`, `access_rating`, `access_com`, `access_delall`) VALUES
(1, 0, 1, '����&����', 'automoto', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(7, 0, 1, '������&Other', 'other', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(2, 0, 1, '�������', 'funny', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(8, 0, 1, '�����', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(9, 0, 1, '����', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(10, 0, 1, '��������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(11, 0, 1, '��������� ����', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(12, 0, 1, '���������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(13, 0, 1, '������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(14, 0, 1, '�������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(15, 0, 1, '��������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(16, 0, 1, '���������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(17, 0, 1, '�����', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(18, 0, 1, '����', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(19, 0, 1, '�������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(20, 0, 1, '���� � �������� ', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(21, 0, 1, '�����������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(22, 0, 1, '��������� ', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(23, 0, 1, '�������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(24, 0, 1, '�����������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(25, 0, 1, '���������', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', '')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_usergroups_web2work`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_usergroups_web2work` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `group_name` text,
  `system` tinyint(1) DEFAULT '0',
  `blocks` tinyint(1) DEFAULT '0',
  `archiv` tinyint(1) DEFAULT '0',
  `clubi` tinyint(1) DEFAULT '0',
  `afisha` tinyint(1) DEFAULT NULL,
  `datting` tinyint(1) DEFAULT NULL,
  `sms` tinyint(1) DEFAULT '0',
  `firm` tinyint(1) DEFAULT '0',
  `vuz` tinyint(1) DEFAULT NULL,
  `photo` smallint(6) DEFAULT '0',
  `doska` smallint(6) DEFAULT '0',
  `banki` tinyint(1) DEFAULT '0',
  `spisok_rating` smallint(6) DEFAULT '0',
  `cat_rating` tinyint(1) DEFAULT '0',
  `am` smallint(6) DEFAULT '0',
  `dop_am` smallint(6) DEFAULT '0',
  `rid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_usergroups_web2work` (`id`, `group_name`, `system`, `blocks`, `archiv`, `clubi`, `afisha`, `datting`, `sms`, `firm`, `vuz`, `photo`, `doska`, `banki`, `spisok_rating`, `cat_rating`, `am`, `dop_am`, `rid`) VALUES
(1, '�������������', 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, '0', 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 1, 1, 2),
(3, '0', 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 3),
(4, '0', 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 4),
(5, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 5)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_users_friendgroup`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_users_friendgroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_users_friendgroup` (`id`, `name`) VALUES
(1, '�����'),
(2, '�������'),
(3, '�������������'),
(4, '�������������')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_video_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_video_category` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) NOT NULL DEFAULT '0',
  `posi` smallint(5) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL DEFAULT '',
  `alt_name` varchar(50) NOT NULL DEFAULT '',
  `meta_title` varchar(255) NOT NULL,
  `meta_descr` varchar(255) NOT NULL,
  `meta_keyw` varchar(255) NOT NULL,
  `icon` varchar(200) NOT NULL DEFAULT '',
  `skin` varchar(50) NOT NULL DEFAULT '',
  `descr` varchar(200) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `news_sort` varchar(10) NOT NULL DEFAULT '',
  `news_msort` varchar(4) NOT NULL DEFAULT '',
  `news_number` smallint(5) NOT NULL DEFAULT '0',
  `short_tpl` varchar(40) NOT NULL DEFAULT '',
  `full_tpl` varchar(40) NOT NULL DEFAULT '',
  `setlinks` smallint(5) unsigned NOT NULL DEFAULT '0',
  `access_mod` varchar(255) NOT NULL DEFAULT '',
  `access_upload` varchar(255) NOT NULL DEFAULT '',
  `access_view` varchar(255) NOT NULL DEFAULT '',
  `access_rating` varchar(255) NOT NULL DEFAULT '',
  `access_com` varchar(255) NOT NULL DEFAULT '',
  `access_delall` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_video_category` (`id`, `parentid`, `posi`, `name`, `alt_name`, `meta_title`, `meta_descr`, `meta_keyw`, `icon`, `skin`, `descr`, `keywords`, `news_sort`, `news_msort`, `news_number`, `short_tpl`, `full_tpl`, `setlinks`, `access_mod`, `access_upload`, `access_view`, `access_rating`, `access_com`, `access_delall`) VALUES
(1, 0, 1, '����&����', 'automoto', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(7, 0, 1, '������&Other', 'other', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(2, 0, 1, '�������', 'funny', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(9, 0, 1, '������ � ��������', 'Film', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(10, 0, 1, '���������', 'Autos', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(11, 0, 1, '������', 'Music', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(12, 0, 1, '��������', 'Animals', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(13, 0, 1, '�����', 'Sports', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(14, 0, 1, '���������������� ������', 'Shortmov', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(15, 0, 1, '�����������', 'Travel', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(16, 0, 1, '������������ ����', 'Games', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(17, 0, 1, '������� ����������', 'Videoblog', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(18, 0, 1, '���� � �����', 'People', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(19, 0, 1, '����', 'Comedy', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(20, 0, 1, '�����������', 'Entertainment', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(21, 0, 1, '������� � ��������', 'News', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(22, 0, 1, '����� � �����', 'Howto', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(23, 0, 1, '�����������', 'Education', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(24, 0, 1, '����� � �������', 'Tech', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(25, 0, 1, '��������', 'Nonprofit', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(26, 0, 1, '�������', 'Movies', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(27, 0, 1, '�������� � �����������', 'Movies_anime_animation', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(28, 0, 1, '����������� � �������', 'Movies_action_adventure', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(29, 0, 1, '��������', 'Movies_classics', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(30, 0, 1, '����', 'Movies_comedy', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(31, 0, 1, '�������������� ����', 'Movies_documentary', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(32, 0, 1, '�����', 'Movies_drama', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(33, 0, 1, '��� ���� �����', 'Movies_family', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(34, 0, 1, '���������� ����', 'Movies_foreign', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(35, 0, 1, '�����', 'Movies_horror', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(36, 0, 1, '������� ����������/�������', 'Movies_sci_fi_fantasy', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(37, 0, 1, '��������', 'Movies_thriller', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(38, 0, 1, '����������������', 'Movies_shorts', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(39, 0, 1, '���', 'Shows', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(40, 0, 1, '��������', 'Trailers', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(41, 0, 1, 'Gaming', 'Gaming', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', '');";

$row = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_static WHERE id='14' or id='15'" );
if ($row['count']==0)
{
$tableSchema[] = "INSERT INTO " . PREFIX . "_static (`id`, `name`, `descr`, `template`, `allow_br`, `allow_template`, `grouplevel`, `tpl`, `views`) VALUES (14, 'agreement', '���������� � ������������� � ������� ������������������', '<p>1. �������</p>\r\n\r\n<p><br />\r\n        ������������ � ���������� �����, ��������� ��������� ����������� �� ����� � ������������� �������.</p>\r\n\r\n<p>���� � ������������� �� ������ <a href=\"$url\">$url</a>&nbsp; ������, ���������� �������������� $url&nbsp;(����� � ���������-���������).</p>\r\n\r\n<p>������� � ����������� ������������, ������������ ������������, ��������� ��� ���, ��������� ���������, ��������������� ������������, ����������, �����������, ������, �������� �����, ��������, �������������� ������, �� ���������, ����������, ���� ������� ����������� � ������������ ����������� ������������� �� �����.</p>\r\n\r\n<p>������ ������ � ����������, ����������� ���������������� ������������, � ��� ����� ���������� ����������, ����������� � ������������ ����������� ������������� �� �����.</p>\r\n\r\n<p>������������� ����� � ������ ����������� ��������-��������� � �� ���������� ���, ��������������� ������� ������������� �����, ����������� ��� �������, �������������� ����������� �������������� ���������� ����������. </p>\r\n\r\n<p><br />\r\n        2. ������� ����������</p>\r\n\r\n<p><br />\r\n        2.1. ��������� ���������� � ������������� (����� �����������) �������� ����������� ����������� ����� ������������� � ���������-����������, ��������������� ������� ������������� �����.<br />\r\n        2.2. ������������ �� ����� ������������ ������������ ���� ������ �������� � ��������� ���������� ����������.<br />\r\n        2.3. � ������ ���������� � ������-���� ��������� ���������� ������������ ��������� ��������������� ���������� ����������� ������.<br />\r\n        2.4. ������������� ����� ��������� �� ����� ����� � ����� ����� �������� ������� ���������� ����������. ��� ���� ������������ ��������� �� ���� ������������� ������������ ���������� � ����������� ������� ����������.<br />\r\n        2.5. ������������ �� ����� ������������ ������������, ��� �������� ����������� ����������������� � ������������ ��� �������� ���������� ����������, �������� ��������� ������� ���������� � ����� ��������������� �� ��������� ����������, � ��� ����� �� ���������������, ��������� ���������� ����������� ������.<br />\r\n        2.6. ������������ ����� ������������ ��������������� �� ������� � ��� �����������, ��������� � ��� �����������.<br />\r\n        2.7. �������� �������, ������������ ����������� ���, �������� ����� ������� � ������������, ������������ ��� �������� ���� � ������������ � �.5.5. ���������� ����������.<br />\r\n        2.8. �������� �������, ������������ ������������� ����� ������ ������� ������������ ����� �� ������ � ��������.</p>\r\n\r\n<p><br />\r\n        3. ����� � ����������� ������������</p>\r\n\r\n<p><br />\r\n        3.1. ������������ ��������� �� ��������� ������� ���������������, �������, ��������������� � ������������ ���������, �������������� ��������� � ��������� ������, ���������� ����������� ���������� ��� ������������� ����������������, ���������� �����, � ��� ����� ����������������, ������� ���.<br />\r\n        3.5 ������������ ������ ��������� �� ����� ������� � ������������ � ��������� ���������� ����������.<br />\r\n        3.3 ��� ����������� ������������ ��������� ������� ����������� ������ ������.<br />\r\n        3.4 �� ���� �������, ����������� �� ����� � ������� ��� ������������, ���������������� �������� ���������� �����. ��� �������������� ��������� ������ ����� �������� ����� ������, ���� ��� ������� �� �����-���������, � ��� ������������� ��� ������������ � ������ ��������� (�). ����������� �� �������������� ���������, ����������� ����� � ���������, ��������������, � � ��� ������, ���� ����� ������ �� �� �������������, � ��������� �����������. ������������ ��������� �� ����������� ���� ��������� ����� ������� ��� �����������.<br />\r\n        3.5 ������������ ���� ��������������� �� ��������� ������� ���������� � ������������ � ����������������� ���������� ���������.<br />\r\n        3.6 � ������ ��������� ������ ������� �����, ������ ������������� ��� ����� ������������ ��������� ���������� ����������� ����� � ������ ������ � � ������� � ������������ � ����������� ����������������� ���������� ���������.<br />\r\n        3.7 ������������ ����� ��������������� � ��� ������� (������� ���������� �������, �����, �������, �������� � ���� �������� � ��������) � ������ ������������ �������� ������ �����-���� ���������, �������, �� �� ������������� ����������� ���������� � ������� ���������������� ���� ������� ���, � �� �����-���� �������������, ��������� � ����� � ����� � ������������ ������� ������, ��������� ��� ��������� ���������� ��������� ������������� ������� ���������� ����������. ������������ ��������� ������� ��� ����������� � ��������� ����, ������������ �� ���������� ����� �� ����� ����������. </p>\r\n\r\n<p><br />\r\n        4. ����� � ����������� ������������� �����</p>\r\n\r\n<p><br />\r\n        4.1. ������������� ����� ��������� �������� ��� ���������� ���������� ������������. �� ����������� ���������� ���������� ������ ������������ �������� ��� ��������� ������ ������������� � ����������� �����.<br />\r\n        4.2. ������������� ����� ��������� �� ���������� ���������� ���������� ������������ ������� �����, ����� �������, ��������������� ����������� ����������������� � ��������� �����������.<br />\r\n        4.3. ������������� ����� �� ���������� ������������� � ����������� ������ � ����������� ��������, ����������� ����� �������������� �����, ������ ��������� �� ����� ����� ������������� �������� ������������ � ������ ��������� �� ������ ������������� �������������� ����� �� ������������ ��������� ������� ������������ �� �����.<br />\r\n        4.4 ������������� ����� �� ���� ��������������� �� ��������������� ��������� ������������� ����� ���������� ���������� ������ �������������. ��� ���� ������������ �������� ���������� �� ����� � ��������� ���� ����������.<br />\r\n        4.5 ������������� ����� ������, �� �� ������� ������������ ��������� ������, ����������, ������������ � ���� ����������, ����������� �������������� �� �����.<br />\r\n        4.6 ������������� ����� ������ ������� ����� �����, ����������, ����������� ������������ ��� ����������� � ���������� ������.<br />\r\n        4.7 ������������� ����� �� ������������ ���������� ��������� ���� �� ���������������� ������������� � �� ����� ��������������� �� ��������� �� �������������� �����.<br />\r\n        4.8 ������������� ����� �� ���� ������� ��������, ���������� ���� ��� ���������������, ��� ���������, ����������� �� �����, ������� � ���������.<br />\r\n        4.9 � ������ ��������� ������������� ������� ���������� ����������, ���� ������������ ���������������� ��, ���� ��������� �� ����� ����� �������� ���������� ������, IP ������, ����� ������ ���������� ���������������� �����.<br />\r\n        4.10 ������������� ����� ���������� ���������� � ��������� ������������ � ����� ��������� ������ �����.<br />\r\n        4.11. ������������� ����� ��������� �� ����� ����� ������������� ���� ���������� ������ � ����� ��� ����������� ���������� ������������, ��� ������ ������ ������� �� ����� ���� �� �����.<br />\r\n        4.12. � ������ ��������� ������������� ������� ������� ���������� ������������� ����� ������ ������������� �������� ������������.<br />\r\n        4.13. ������������� ����� ��������� �� ����� ����� ������� ����� ����������� � ��������� ����������� �����.<br />\r\n        4.14. ������������� ����� ���� ��������-�������� ��������� �� ����� ����� �������, �������������, �������� ���� ���� ��� ����� ��� ���������������� ����������� ������������.</p>\r\n\r\n<p><br />\r\n        5. ������</p>\r\n\r\n<p><br />\r\n        5.1. ���������� �������� � ���� � ������� ����������� ������������ �� ����� � ��������� � ������� ����� ����� ������������� �����.<br />\r\n        5.2. ������������� ����� � ��������-�������� �� ����� ��������������� �� �������, ����������� �� �����. ��� ��, ���� � ��������-�������� �� ����� ������� ���������������:<br />\r\n        - �� ���������� � �� ������� ��������;<br />\r\n        - �� �����, ���� � ������ ������ ��������� ����������� ���������� ����������� ������ ���� ��������� ��� ������;<br />\r\n        - �� ����������� ������ ������ ������������ ���������� ��������� ������ �����.<br />\r\n        5.3. ������������� ����� ��������� �� ����� ����� ������� ����� ��������� � ��������� ����������.<br />\r\n        5.4. ������������ ����������� ��������� ������� �� ����, ��� ���� ������������ ��������� ���������������� � ����� ���� �����, ������� ����������� ��� � ��������� ��������.<br />\r\n        5.5. �������� �������, ������������ ������������, ��� ���� ������������ ������������� ��������-��������� � ����� ����� �� �����, ���������������, ���������, ��������, �������� ������������, �������������, ����������, ���������������, �������������, ������� � ����� ���� ������������� �������� ��� ����� ��� ����� ��� ����������� ����� � ���������� ��������.<br />\r\n        5.6. ������������ �������� �� ���������-���������� ��� ����� �� ���� ��� ������ ������, ������� ��� ��� ������������.<br />\r\n        5.7. �������� ��������� ����������, ������������ �������� ���� �������� � ���, ���:<br />\r\n        - ��� ���������� �������� ������������ �� ���������� ��������� ����� � ������������ �� ����� ���� ��������� �� ����� ��������� � �������;<br />\r\n        - � ������ �������� ��������-��������� �����-���� ���� �� ������� � ������������ � �.5.5. ���������� ���������� ������������ �������� ����� �� ����� ������������, ��� ��� ���������� ��. 1269 �� ��.<br />\r\n        - � ������ ���������� ��������, ���������� ���������� ������������� ��� ���������� �� �����, �������������� ����� �� ����� ������� ����������� �� �������������.<br />\r\n        5.8. ������ � ���������� �����, � ��� ����� � �������� ��������������� ������������ ������������� ��� ������� ������������� � ������������. ��� ���������������� ����������� �������� ���������� ��������������� ���� ������������ �� ����� ����� ������������, ��������������, �������������� ����� ��������, ����������, �������� ����������, ���������� � ���� ��� ��������� ��������, ����������, ������������, ��� ������������ ����� ���� ��������� � ����� ���� ���� ����� ��������� �����.<br />\r\n        5.9. ������������� ����� � ��������-�������� �� ����� ������� ��������������� �� ����������� � ����������� ��������, ������������ �� �����.<br />\r\n        5.10. ������� �.�.5.5., 5.7. ���������� ���������� �������� � ���� ����� ����������� �������� ���������� ����������.<br />\r\n        5.11. � ������, ���� ������������� ����� ��� ��������-�������� � �����-���� ������ �� ������� �� ������������ ���������� �����-���� ������� ���������� ����������, ��� �� �������� ����� ������������� ����� ��� ��������-��������� ��������� ������ ���������� �������, ����� ��� � ��������� ����, ������������ �� ���������� ������������� ������� ���������� ����������.<br />\r\n        5.12. ����� ����������� �������� ����������, ��������-�������� ���������� ������� ����� ����������� ������� �� �������, ��� �����-���� ������������ ������ ������������ �� ��� �������������.<br />\r\n        5.13. ������� ��������� ���������� ���������� �� ������������ ����� ������������� �����, ��������-��������� ��� ������������ ��������� ����������� ���������� � ����� ������ �����.<br />\r\n        5.14. ��������� ���������������� ������ �� ������� ��� ��������� ���������� ���������� �� �������� ���������� ��� ��������� ���������������� ����� ������ ������� ��� ��������� ����������.<br />\r\n        5.15. ������������ �����������, ��� � ������ ������������� ������ ��� �������� ���������� � ������������ � ����������� ����������������� ���������� ���������.</p>\r\n\r\n<p>������������� ����� ��������� �� ����� ����� ������� ����� �������� � ��������� ����������</p>', 0, 1, 'all', '', '272'),
(15, 'about', '� �������', '<p align=\"right\">\r\n        <span style=\"FONT-STYLE: italic\">���� ���������� ��������.<br />\r\n                ��������, ����� ���� ������, ����� ���������&nbsp;� ���� ����,<br />\r\n                ��� �� ������ �������, �� � �� ������.<br />\r\n                � ������������� ������ � ��� � �����! ��� �� ����������� �����-��!<br />\r\n                ������� ������ �� �����</span><br />\r\n        <br />\r\n        </p>\r\n\r\n<p>\r\n        <span style=\"FONT-WEIGHT: bold\">��� ��� �� ������</span> <br />\r\n        ��� ����� ���� ���������� ��������� ��� �������. �� ����� ����������� ����� ����� �������� ���������? ��������� ������� Odnoklybniki.ru �������: ����������� �������� ������ �������� ����� �������� ��������. ����� ������ ��������� ����������� � ��������,&nbsp;�������� ��� ����.<br />\r\n        ��� ������� ���������� � ����� �� ���������. ����� ������� �������� ���� ������� ����� � � ������, ��� ���������� ������, ����� ����� ������� �����&nbsp;� ���� ����, ������������� � ��������, ��������, ������� ������������ ��� ��, ��� � ��. � ����� ���� ������������� � �������� ��� ������ ����� �����.<br />\r\n        <br />\r\n        \r\n        <span style=\"FONT-WEIGHT: bold\">���� ������ �����</span><br />\r\n        �������� ���� ������� ������: � �������&nbsp;����� ���� ���� ����, ���� ����������! ����� ����, ��� �� ���������,&nbsp;��������� �����&nbsp;��� ����������, � ��������, � ��� ������� ������������. ��� �������� ������� �����,&nbsp;���� �� ����� ���������������� ������� ��� ������,&nbsp;����� ����� ��������� ����������� �������&nbsp;� ����� �������� ����� ������, ������ ��������� c �������������.&nbsp;���� �����&nbsp;� ��� �� �����, ��� ������ ��� �������� ��� ������ ������� �������� ����� ������������� �����!</p>\r\n\r\n<p><br />\r\n        \r\n        <span style=\"FONT-WEIGHT: bold\">������ �����<br />\r\n                </span>�� ������� ��������� �������, �� �� ������ ������� ���� ������� ��� ����? �� ������, � ��� ���������� �� �������? ��� �������, ������� ����� ���� ��� �� ������, ��� � ��, ����� �� ��������� ������ � ��� ����������� �����������? ������ ��� ����� ��-�������. ������ ����� �� ������������.RU, �����,&nbsp;� ����� ���� �� ���� ����� ������&nbsp;� ��� �� ������, � � ���� ��� ������ �� ���������, ��� ���� ��� ������������.</p>', 0, 1, 'all', '', '392')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_static (`name`, `descr`, `template`, `allow_br`, `allow_template`, `grouplevel`, `tpl`, `metadescr`, `metakeys`, `views`, `template_folder`, `date`) VALUES ('dle-rules-page', '����� ������� �� �����', '<b>����� ������� ��������� �� �����:</b><br /><br />������ � ����, ��� �� ����� �������� ����� �����, ������ ������� � ��������, � ��� ��� �������� ������������� ������������ ������ �����, ������� ���� �� ����� ����� ��� ���������� ����� ��������������� ��� � ���������� �������. �� ������������ ����������� ��������� ��������� �������, ��� ������ � ��� ����� ����� ����, �� �������� ��� � ��� ����� � ������� ������� ���� ����� ���������� � ��������������.<br /><br />������ � ����, ��� �� ����� ����� ����� ����� ���� ����������� �� ���� ����������� �����. �� ���� ����������� �� ��������� � ����������, ��� ������ ������. ���� ���� ��������� - ����������� � ������� ��� ����������� (�������������� ������� �����������). ����������� ������ ����������� ��������� � ��� ����� �� ����� ������ ��������� � ������ ������������ ��������������. <b>� ��� ������ �������� ������, ����������� � ������������ ������������.</b> ������� ���������� ��� �� ��������� � �� ������� ������� ��� ���� ����� �������� � �����������.<br /><br /><b>�� ����� ������ ���������:</b> <br /><br />- ���������, �� ����������� � ���������� ������ ��� � ��������� ����������<br />- ����������� � ������ � ����� ����������� �����<br />- � ������������ ����������� ���������, ���������� ������������� �������, ��������� ������������ �����������, ����������� ��������������� �����<br />- ����, � ����� ������� ����� ������� � �����, ���� ��������, ��� ��� �������, �� ����������� � ��������� ���������� ������<br /><br />������� ����� ������� ���� ����� � ����, �� ������� �� � ������ �������� �������� ���������� � ��������� ���� �����. ������������� ����� ��������� �� ����� ����� ������� ����������� ��� ����� ������������, ���� ��� �� ������������� ������ �����������.<br /><br />��� ��������� ������ ��� ����� ���� ���� <b>��������������</b>. � ��������� ������� ����� ���� ��� ��� <b>��� ��������������</b>. �� �������� ������ ���� ������ ��������������.<br /><br /><b>�����������</b> ��������������� ��� ����������� ����� �������� <b>�����</b> - �������� ����� ����.<br /><br /><div align=\"center\">{ACCEPT-DECLINE}</div>', 1, 1, 'all', '', '����� �������', '����� �������', 0, '', '{$add_time}')";
}

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_holydays`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_holydays` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `firm` varchar(244) NOT NULL,
  `type` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if ($_REQUEST['db_holidays']==1)
{
$tableSchema[] = "INSERT INTO `".PREFIX."_holydays` (`id`, `name`, `date`, `user_name`, `firm`, `type`, `foto`, `text`) VALUES
(1, '�������� �����', '2013-06-05', '".$_REQUEST['reg_name']."', '3409', '��������� ��������� �������', '', '�������� ���� � ����� ��������� (Corpus Christi) ���������� �������� � ������� ����� ������ � �������� ������������� ������������� ��������� ���������� (Holy Eucharist) �� ��������� � ���������� ������ ������. ������������ ������� ������������� ���������� (�������� ����������) ��� ��������� ���, ����������� ������� ����� ������, ������������� �� ����� ��������� ������. ������, ����������� ������� ��� ����� ����� � ���� � ������������� �������, � ��� ������������ ������, � ������� ������ �������� ���������� � ����� ������. ������ ��������� � ��� ������� �������� � ������ ������, ������� �������� ��� ����������� ���� �������. ������ �������������� ��������� ���������� ����� ���� ������ � 1247 ���� � �������� ������� �������. � 1264 ���� ���� ����� IV ������ ����� ��������� ������ ��������������, ������� ������������ ����, ��� �������� ������� � ����������� �����. ���������������� ��������� ���� �������� ������� ���� ���������, � ����� ���� ������ ��������� ����� �� ����������� � ������� ���������. ��������, ������� ����������� �� �������������, �� �������� ���� �� ������ ������� ������������� �������� ����������. � ��� ����������� ������� ���������� ��������� ������, �������������� ������� � ������� ��������, ����������� ��� ������ �������������� ����������. ���������� �������� �������� � �� ����� ��������� ������������ �������� ������. \r\n\r\n��������: http://www.calend.ru/holidays/0/0/404/\r\n� Calend.ru'),
(2, '����', '2013-05-30', '".$_REQUEST['reg_name']."', '', '', '', '19.00 - �������� ����������. ���������� ����� ���������� �� �������� ���������, ����� ������ ���������� ������ � ���������� � �� ����������
�, ���������� ������, �� � ������ ������������������ � ����� ������������� �����������. ����� � ������� ���������� ����� �������� ���� ��������, ������� ������ ����������� ���������� �
������ + ������� ������ �� ������ ��� ������.\r\n20.00 - ������ ���������� ���������. � �������� ����� ��������� ������� ��� ����� �����������: ��� ����� �������� ��� ����� ����������(���������� � ��������� \"����������� ��������
\"). ��� �� ����� ���������� ���������� � � ������ ����������. �������� �� ����� ������������ ����.\r\n�� ����� ����� ����������� ����� ����������� ������������� ���-���������, ������� �� �������� ��
����� ������ � ���������� ��������. ��� �� ���� ������ � ���������� ����������� ���� �������� �������� � �������.\r\n22.00 - �����������. ���������� ����������, ������� ������ � ��������.\r\n22.
30(23.00) - after-party � ������������� ����� � ��� � ���� �������, ��� ����� � ��������� ����������� ������ ��������� � ���������� ������������� � ��������� ��������.')";
}

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comments_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_comments_files (
	  `id` int(10) NOT NULL AUTO_INCREMENT,
	  `c_id` int(10) NOT NULL default '0',
	  `author` varchar(40) NOT NULL default '',
	  `date` varchar(50) NOT NULL default '',
	  `name` varchar(255) NOT NULL default '',
	  PRIMARY KEY (`id`),
	  KEY `c_id` (`c_id`),
	  KEY `author` (`author`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_xfsearch";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_xfsearch (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `tagname` varchar(50) NOT NULL default '',
  `tagvalue` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `tagname` (`tagname`),
  KEY `tagvalue` (`tagvalue`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "ALTER TABLE  `pmd_users` CHANGE  `state`  `state` TEXT NOT NULL ,
	CHANGE  `banner_show`  `banner_show` TEXT NOT NULL ,
	CHANGE  `banner_click`  `banner_click` TEXT NOT NULL ,
	CHANGE  `price_show`  `price_show` TEXT NOT NULL";

$tableSchema[] = "ALTER TABLE `pmd_users` ADD `tarif_id` INT(5) NOT NULL DEFAULT '0'";

$tableSchema[] = "ALTER TABLE  `calendar_event` ADD  `event_end` VARCHAR( 255 ) CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci NOT NULL";
$tableSchema[] = "ALTER TABLE  `calendar_event` ADD  `approve_main` VARCHAR( 255 ) CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci NOT NULL";
$tableSchema[] = "ALTER TABLE  `calendar_event` ADD  `approve_afisha` VARCHAR( 255 ) CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci NOT NULL";
$tableSchema[] = "ALTER TABLE  `calendar_event` ADD  `title` VARCHAR( 255 ) CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci NOT NULL";
$tableSchema[] = "ALTER TABLE  `calendar_event` ADD  `descr` VARCHAR( 255 ) CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci NOT NULL";
$tableSchema[] = "ALTER TABLE  `calendar_event` ADD  `keywords` VARCHAR( 255 ) CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci NOT NULL";

$tableSchema[] = "UPDATE " . PREFIX . "_usergroups SET `allow_up_image` = '1', `allow_up_watermark` = '1', `allow_up_thumb` = '1', `up_count_image` = '3', `up_image_side` = '800x600', `up_image_size`='200', `up_thumb_size`='200x150' WHERE id = '1'";
$tableSchema[] = "UPDATE " . PREFIX . "_usergroups SET `allow_up_image` = '0', `allow_up_watermark` = '1', `allow_up_thumb` = '1', `up_count_image` = '3', `up_image_side` = '800x600', `up_image_size`='200', `up_thumb_size`='200x150' WHERE id > '1'";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_firm_brands";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS  `" . PREFIX . "_firm_brands` (
	`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
	 `name` VARCHAR( 255 ) NOT NULL ,
	 `short_story` TEXT NOT NULL ,
	 `firm` INT( 5 ) NOT NULL ,
	PRIMARY KEY (  `id` ) ,
	UNIQUE KEY  `id` (  `id` )
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "ALTER TABLE  `calendar_event` ADD  `alt_name` VARCHAR( 255 ) NOT NULL AFTER  `city` , ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `pmd_users` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `pmd_category` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_doska_obj` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_doska_cat` ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_afisha_cat` ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_club_event` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_club_post` ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_twsfa_category` ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_club_users` ADD  `alt_name` VARCHAR( 255 ) NOT NULL AFTER name, ADD `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_video_file` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_faqcategories` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_firm_brands` ADD `files` TEXT NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_rating_kat` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_rating_new` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";
$tableSchema[] = "ALTER TABLE  `".PREFIX."_foto_conkurs` ADD  `alt_name` VARCHAR( 255 ) NOT NULL, ADD  `meta_title` VARCHAR( 255 ) NOT NULL AFTER  `alt_name` , ADD  `meta_descr` VARCHAR( 255 ) NOT NULL AFTER  `meta_title` , ADD  `meta_keyw` VARCHAR( 255 ) NOT NULL AFTER  `meta_descr`";

$tableSchema[] = "DROP TABLE IF EXISTS `" . PREFIX . "_firm_static`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_firm_static` (
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
  `firm` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `template` (`template`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";


$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_firm_photoalbum";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_firm_photoalbum` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) NOT NULL,
	  `short_story` text NOT NULL,
	  `firm` int(5) NOT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_firm_photoalbum_images";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_firm_photoalbum_images` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `album_id` int(5) NOT NULL,
	  `name` varchar(255) NOT NULL,
	  `firm` int(5) NOT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_firm_files";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_firm_files` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) NOT NULL,
	  `short_story` text NOT NULL,
	  `firm` int(5) NOT NULL,
	  `files` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";



foreach($tableSchema as $table) {
        $db->query ($table);
}

$db->query ("ALTER TABLE `" . PREFIX . "_users` CHANGE `password` `password` VARCHAR(255) NOT NULL DEFAULT '', ADD `news_subscribe` TINYINT(1) NOT NULL DEFAULT '0', ADD `comments_reply_subscribe` TINYINT(1) NOT NULL DEFAULT '0'");

$db->query ("ALTER TABLE `" . PREFIX . "_post` CHANGE `short_story` `short_story` MEDIUMTEXT NOT NULL, CHANGE `full_story` `full_story` MEDIUMTEXT NOT NULL, CHANGE `xfields` `xfields` MEDIUMTEXT NOT NULL, CHANGE `category` `category` VARCHAR(190) NOT NULL DEFAULT '0', CHANGE `alt_name` `alt_name` VARCHAR(190) NOT NULL DEFAULT ''");
$db->query ("ALTER TABLE `" . PREFIX . "_post` DROP INDEX `tags`");

$db->query("UPDATE `pmd_category` SET `fcounter` = '0'");

$getcategories2ca_gm = $db->query("SELECT * FROM ".PREFIX."_weather_gismeteo_city WHERE name LIKE '".$config['city_osn_name']."' ORDER BY name ASC");
while($row2ca_gm = $db->get_row($getcategories2ca_gm))
{
	$exit_id_city = $row2ca_gm['id'];
}

$tableSchema[] = "INSERT INTO `".PREFIX."_change_city` (`id`, `lat`, `lng`, `name`, `weather_id`, `portal_id`, `url_kyil`, `url_eng`, `title`, `keyword`, `descript`, `descript_site`, `weather_gm_id`)
VALUES ('', '', '', '".$config['city_osn_name']."', '', '', '', '', '".$config['city_osn_name']."', '".$config['city_osn_name']."', '".$config['city_osn_name']."', '".$config['city_osn_name']."', '".$exit_id_city."')";


echo $skin_header;

echo <<<HTML
<form method=POST action="/install/install_step4.php" onsubmit="return sender();">
<input type=hidden name="reg_name" value="{$_REQUEST['reg_name']}">
<input type=hidden name="reg_password" value="{$_REQUEST['reg_password']}">
<input type=hidden name="regmail" value="{$_REQUEST['regmail']}">
<input type=hidden name="city_now" value="{$_REQUEST['city_now']}">
<div class="box">
  <div class="box-header">
    <div class="title">��������� ��� ��������� - �������� ��������� �������</div>
  </div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<style type="text/css">
.error {
    color: red;
}
</style>
  <div class="box-content">
	<div class="row box-section">
		�������� ������� �������� ��������� ��� ���������� ������ �������.<br><br>

			<div style="padding-top:5px;">
				<table>
					<tr><td colspan="3" height="40">&nbsp;&nbsp;<b>����� ���������</b><td></tr>
					<tr><td style="padding: 5px;">��������� �������</td><td style="padding: 5px;"><input type=text name="title_portals" value="{$config['home_title']}"></td></tr>
					<tr><td style="padding: 5px;">�������� �������</td><td style="padding: 5px;"><textarea type=text name="description_portals">{$config['description']}</textarea></td></tr>
					<tr><td style="padding: 5px;">�������� ����� �������</td><td style="padding: 5px;"><input type=text name="keywords_portals" value="{$config['keywords']}"></td></tr>

<!--
					<tr><td style="padding: 5px;">����� (������: ������������)</td><td style="padding: 5px;"><input type=text name="city_ckaburg" id="city_ekaburg" value="{$config['city_osn_name']}"></td></tr>
					<tr><td style="padding: 5px;">����� (������: �������������)</td><td style="padding: 5px;"><input type=text name="city_ckaburge" id="city_ekaburge" value="{$config['city_osn_name']}"></td></tr>
					<tr><td style="padding: 5px;">����� (������: �������������)</td><td style="padding: 5px;"><input type=text name="city_ekaburga" id="city_ekaburga" value="{$config['city_osn_name']}"></td></tr>

<tr><td style="padding: 5px;">���� 2GIS<br><span class="small">��� ����� �������� �� ���������� ������: <a onclick="window.open('http://partner.api.2gis.ru', 'Help', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width=600,height=500')" href="#">http://partner.api.2gis.ru</a></span></td><td style="padding: 5px;"><input type=text name="key_2gis" value=""></td></tr>
					<tr><td style="padding: 5px;">���� YouTube API<br><span class="small">��� ����� �������� �� ���������� ������: <a onclick="window.open('https://code.google.com/apis/youtube/dashboard', 'Help', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width=600,height=500')" href="#"> https://code.google.com/apis/youtube/dashboard</a></span></td><td style="padding: 5px;"><input type=text name="key_api_youtube" value=""></td></tr>
-->
					<tr><td style="padding: 5px;">�������� ������ <span id='err_v'></span></td><td style="padding: 5px;"><input type=text name="valuta" value="�����" id="valuta"></td></tr>
					<tr><td style="padding: 5px;">���������� �������� ������ <span id='err_vz'></span></td><td style="padding: 5px;"><input type=text name="valutaz" value="���" id="valutaz"></td></tr>

					<tr><td style="padding: 5px;">������� E-Mail ��� �����������</td><td style="padding: 5px;"><input type=text name="admin_email" value="{$_REQUEST['regmail']}"></td></tr>

				</table>
			</div>
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="����������">
		<input type=hidden name="action" value="doinstall">
	</div>

  </div>
</div>
</form>
HTML;

echo $skin_footer;
?>