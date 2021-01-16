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
  <title>Web2Work - Установка</title>
  <link href="/engine/skins/stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="/engine/skins/javascripts/application.js"></script>
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
////////////////// ОПРЕДЕЛЯЮЩИЕ СБОРКИ /////////////////////////////
require_once(ROOT_DIR.'/install/db_firm.php');
////////////////////////////////////////////////////////////////////
}
else
{
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(11, 'Автосервис / Автотовары', 1, 0, 0, 0, 'page_standart', '', '', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(12, 'Автостекло', 1, 0, 0, 0, 'page_standart', '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(13, 'Газовое оборудование для автотранспорта', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(14, 'Ремонт дизельных двигателей', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(15, 'Запчасти к сельхозтехнике', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(16, 'Автоэмали', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(17, 'Пошив авточехлов', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(18, 'Технический осмотр транспорта', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/storehouse.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(19, 'Автомобильные аккумуляторы', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(20, 'Ремонт мототехники', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(21, 'Ремонт бензиновых двигателей', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(22, 'Автосигнализации - продажа / установка', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(23, 'Автозаправочные станции (АЗС)', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/gasStation.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(24, 'Шиномонтаж', 0, 0, 0, 0, NULL, '', '11', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(25, 'Автомойки', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/dryCleaner.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(26, 'Ремонт ходовой части автомобиля', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(27, 'Специализированное автооборудование', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(28, 'Авторазборы', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(29, 'Автошины / Диски', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/tire.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(30, 'Автозапчасти для отечественных автомобилей', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(31, 'Ремонт / заправка автокондиционеров', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(32, 'Развал / Схождение', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(33, 'Ремонт карбюраторов / инжекторов', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(34, 'Ремонт спецавтотехники', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(35, 'Антикоррозийная обработка автомобилей', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(36, 'Установка / ремонт автостёкол', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(37, 'Авторемонт и техобслуживание (СТО)', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(38, 'Автозапчасти для иномарок', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(39, 'Тюнинг', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(40, 'Автозвук - продажа / установка', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(41, 'Автоаксессуары', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(42, 'Автохимия / Масла', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(43, 'Ремонт АКПП', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(44, 'Ремонт грузовых автомобилей', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(45, 'Автозапчасти для грузовых автомобилей', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(46, 'Контрактные автозапчасти', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(47, 'Тонирование автостёкол', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(48, 'Кузовной ремонт', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(49, 'Ремонт электронных систем управления автомобиля', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(51, 'Автостоянки', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(52, 'Запчасти для спецавтотехники', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(53, 'Аппаратная замена масла', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(54, 'Ремонт автоэлектрики', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/workshop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(665, 'Гостиницы', 0, 0, 0, 0, NULL, '', '', 'http://api-maps.yandex.ru/i/0.4/icons/camping.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(973, 'Квартиры посуточно', 2, 0, 0, 0, 'page_developer', '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1167, 'Застройщики', 2, 0, 0, 0, '', '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1168, 'Агентства недвижимости', 2, 0, 0, 0, '', '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(867, 'Продажа легковых автомобилей', 0, 0, 0, 0, NULL, '', '11', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(934, 'Кредитные потребительские кооперативы граждан', 0, 0, 0, 0, NULL, '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(969, 'Банки', 1, 0, 0, 0, 'page_banki', '', '', 'http://api-maps.yandex.ru/i/0.4/icons/bank.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(975, 'Интернет-Магазины', 2, 0, 0, 0, '', '', '', 'http://api-maps.yandex.ru/i/0.4/icons/shop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(976, 'Авто, мото', 2, 0, 0, 0, '', '', '975', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(977, 'Детские', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(978, 'Доставка еды', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(979, 'Здоровье', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(980, 'Зоотовары', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(981, 'Канцелярские товары', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(982, 'Новогодние товары', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(983, 'Одежда, обувь, аксессуары', 2, 0, 0, 0, '', '', '975', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(984, 'Оптовые интернет магазины', 2, 0, 0, 0, '', '', '975', 'http://api-maps.yandex.ru/i/0.4/icons/shop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(985, 'Отдых и развлечение', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(986, 'Парфюмерия и косметика', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(987, 'Подарки', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(988, 'Строительство, ремонт', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(989, 'Сумки', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(990, 'Техника и электроника', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(991, 'Товары для дома', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(992, 'Товары для спорта, отдыха и туризма', 2, 0, 0, 0, '', '', '975', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(993, 'Услуги', 2, 0, 0, 0, '', '', '975', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(994, 'GPS Навигаторы\\\\Антирадары', 2, 0, 0, 0, '', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(995, 'Автовинил', 2, 0, 0, 0, '', '', '976', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(996, 'Автозвук', 2, 0, 0, 0, '', '', '976', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(997, 'Автотюнинг', 2, 0, 0, 0, '', '', '976', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(998, 'Аксессуары', 2, 0, 0, 0, '', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(999, 'Видеорегистраторы ', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1000, ' Детские автокресла', 2, 0, 0, 0, 'page_standart', '', '976', 'http://api-maps.yandex.ru/i/0.4/icons/car.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1001, ' Для мотоциклов и скутеров', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1002, ' Запчасти', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1003, ' Квадроциклы', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1004, ' Рации', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1005, ' Сигнализация', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1006, ' Шины, диски', 2, 0, 0, 0, 'page_standart', '', '976', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1008, 'Гигиена и уход', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1009, ' Детская мебель', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1010, ' Детская обувь', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1011, ' Детская одежда', 2, 0, 0, 0, 'page_standart', '', '977', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1012, ' Детские светильники', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1013, ' Детский транспорт', 2, 0, 0, 0, 'page_standart', '', '977', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1014, ' Детское питание', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1015, ' Игрушки', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1016, ' Коляски', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1017, ' Настольные игры', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1018, ' Одежда для кормящих', 2, 0, 0, 0, 'page_standart', '', '977', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1019, ' Переноски для детей', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1020, ' Подгузники', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1021, ' Развивающие товары', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1022, ' Техника для мам и новорожденных', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1023, ' Товары для мам', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1024, ' Товары для новорожденных', 2, 0, 0, 0, 'page_standart', '', '977', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1025, 'Алкоголь', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1026, ' Американская кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1027, ' Армянская кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1028, ' Бизнес ланчи', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1029, ' Восточная кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1030, ' Доставка воды', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1031, ' Доставка пиццы', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1032, ' Доставка суши', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1033, ' Европейская кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1034, ' Индийская кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1035, ' Итальянская кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1036, ' Кейтеринг', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1037, ' Китайская кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1038, ' Кофе', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1039, ' Немецкая кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1040, ' Продукты и напитки', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1041, ' Русская кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1042, ' Торты на заказ', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1043, ' Универсамы', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1044, ' Чай', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1045, ' Японская кухня', 2, 0, 0, 0, 'page_standart', '', '978', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1046, 'Бады', 2, 0, 0, 0, 'page_standart', '', '979', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1047, ' Интернет-аптеки', 2, 0, 0, 0, 'page_standart', '', '979', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1048, ' Интимные товары', 2, 0, 0, 0, 'page_standart', '', '979', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1049, ' Медицинская техника', 2, 0, 0, 0, 'page_standart', '', '979', 'http://api-maps.yandex.ru/i/0.4/icons/hospital.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1050, ' Обогатители воздуха', 2, 0, 0, 0, 'page_standart', '', '979', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1051, 'Корм для животных', 2, 0, 0, 0, 'page_standart', '', '980', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1052, ' Товары для животных', 2, 0, 0, 0, 'page_standart', '', '980', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1053, 'Аксессуары', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1054, ' Бижутерия', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1055, ' Детская обувь', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1056, ' Детская одежда', 2, 0, 0, 0, 'page_standart', '', '983', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1057, ' Женская одежда', 2, 0, 0, 0, 'page_standart', '', '983', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1058, ' Кожгалантерея', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1059, ' Мужская одежда', 2, 0, 0, 0, 'page_standart', '', '983', 'http://api-maps.yandex.ru/i/0.4/icons/tailorShop.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1060, ' Нижнее белье', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1061, ' Обувь', 2, 0, 0, 0, 'page_standart', '', '983', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1062, 'Детская литература', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1063, ' Игры и приставки', 2, 0, 1, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1064, ' Книги', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1065, ' Пиротехника', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1066, ' Радиоуправляемые модели', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1067, ' Сборные модели', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1068, ' Товары для рукоделия', 2, 0, 0, 0, 'page_standart', '', '985', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1069, 'Благовония', 2, 0, 0, 0, 'page_standart', '', '986', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1070, ' Косметика', 2, 0, 0, 0, 'page_standart', '', '986', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1071, ' Лечебная косметика', 2, 0, 0, 0, 'page_standart', '', '986', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1072, ' Парфюмерия', 2, 0, 0, 0, 'page_standart', '', '986', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1073, 'Букеты из конфет', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1074, ' Воздушные шары', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1075, ' Головоломки', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1076, ' Игрушки', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1077, ' Картины', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1078, ' Кожгалантерея', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1079, ' Музыкальные картины', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1080, ' Наборы посуды', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1081, ' Небесные фонари', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1082, ' Необычные подарки', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1083, ' Парфюмерия', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1084, ' Косметика', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1085, ' Подарочные сертификаты', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1086, ' Сувениры', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1087, ' Текстиль', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1088, ' Цветы', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1089, ' Чай', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1090, ' Часы', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1091, ' Эксклюзивные подарки', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1092, ' Ювелирные изделия', 2, 0, 0, 0, 'page_standart', '', '987', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1093, 'Все для бань и саун', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1094, ' Двери', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1095, ' ворота', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1096, ' ставни', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1097, ' Душевые кабины', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1098, ' Инструмент', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1099, ' Крепеж', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1100, ' Мебельная фурнитура', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1101, ' Напольные покрытия', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1102, ' Освещение', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1103, ' Отделка', 2, 0, 0, 0, 'page_standart', '', '988', 'http://api-maps.yandex.ru/i/0.4/icons/factory.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1104, ' Сантехника', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1105, ' Строительные материалы', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1106, ' Строительные смеси', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1107, ' Теплые полы', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1108, ' Товары для дачи и сада', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1109, ' Услуги', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1110, ' Электро-изделия', 2, 0, 0, 0, 'page_standart', '', '988', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1111, 'CD DVD', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1112, ' mp3 плееры', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1113, ' Аксессуары', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1114, ' Бытовая техника', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1115, ' Встраиваемая техника', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1116, ' Климатическая техника', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1117, ' Компьютерная техника', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1118, ' Кухонная техника', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1119, ' Мультимедиа', 2, 0, 0, 0, 'page_standart', '', '990', 'http://api-maps.yandex.ru/i/0.4/icons/cellular.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1120, ' Портативная электроника ', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1121, ' Программное обеспечение', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1122, ' Сотовые телефоны', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1123, ' Техника для мам и новорожденных', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1124, ' Услуги', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1125, ' Фото', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1126, ' Видео', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1127, ' Цифровое телевидение', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1128, ' Швейные машины', 2, 0, 0, 0, 'page_standart', '', '990', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1129, 'Бескаркасная мебель', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1130, ' Бытовая химия', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1131, ' Ванная и кухня', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1132, ' Душевые кабины и ванные', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1133, ' Ковровые покрытия', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1134, ' Кондиционеры', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1135, ' Мебель', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1136, ' Одеяла подушки матрасы', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1137, ' Постельное белье', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1138, ' Посуда', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1139, ' Предметы интерьера', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1140, ' Сантехника', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1141, ' Свет', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1142, ' Текстиль', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1143, ' Хозяйственные товары', 2, 0, 0, 0, 'page_standart', '', '991', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1144, 'Велосипед', 2, 0, 0, 0, 'page_standart', '', '992', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1145, ' Спорт товары', 2, 0, 0, 0, 'page_standart', '', '992', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1146, ' Спортивная одежда и обувь', 2, 0, 0, 0, 'page_standart', '', '992', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1147, ' Спортивное оборудование', 2, 0, 0, 0, 'page_standart', '', '992', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1148, ' Спортивное питание', 2, 0, 0, 0, 'page_standart', '', '992', 'http://api-maps.yandex.ru/i/0.4/icons/gym.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1149, ' Товары для рыбалки', 2, 0, 0, 0, 'page_standart', '', '992', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1150, ' Тренажеры', 2, 0, 0, 0, 'page_standart', '', '992', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1151, ' Туристическое снаряжение', 2, 0, 0, 0, 'page_standart', '', '992', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1152, 'Бытовые услуги', 2, 0, 0, 0, 'page_standart', '', '993', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1153, 'Заведения', 2, 0, 10, 0, 'page_eda', '', '', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1154, 'бары/пабы', 2, 0, 0, 0, 'page_eda', '', '1153', 'http://api-maps.yandex.ru/i/0.4/icons/bar.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1155, 'доставка на дом', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1156, 'закусочные', 2, 0, 1, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1157, 'кафе', 2, 0, 1, 0, 'page_eda', '', '1153', 'http://api-maps.yandex.ru/i/0.4/icons/cafe.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1158, 'кейтеринг', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1159, 'клубы', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1160, 'кофейни', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1161, 'пироговые', 2, 0, 6, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1162, 'пиццерии', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1163, 'рестораны', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1164, 'спорт-бары', 2, 0, 1, 0, 'page_eda', '', '1153', 'http://api-maps.yandex.ru/i/0.4/icons/bar.png')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1165, 'столовая', 2, 0, 0, 0, 'page_eda', '', '1153', '')";
$tableSchema[] = "INSERT INTO `pmd_category` (`selector`, `category`, `sccounter`, `ssccounter`, `fcounter`, `top`, `ip`, `parentid`, `sub`, `ico`) VALUES(1166, 'фаст-фуды', 2, 0, 1, 0, 'page_eda', '', '1153', '')";
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
////////////////// ОПРЕДЕЛЯЮЩИЕ СБОРКИ /////////////////////////////
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
////////////////// ОПРЕДЕЛЯЮЩИЕ СБОРКИ /////////////////////////////
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
////////////////// ОПРЕДЕЛЯЮЩИЕ СБОРКИ /////////////////////////////
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
////////////////// ОПРЕДЕЛЯЮЩИЕ СБОРКИ /////////////////////////////
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
////////////////// ОПРЕДЕЛЯЮЩИЕ СБОРКИ /////////////////////////////
require_once(ROOT_DIR.'/install/db_datting.php');
////////////////////////////////////////////////////////////////////
}

$url = $config['http_home_url'];
$skin = $config['skin'];

//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (1, 'reg_mail', '{%username%},\r\n\r\nЭто письмо отправлено с сайта $url\r\n\r\nВы получили это письмо, так как этот e-mail адрес был использован при регистрации на сайте. Если Вы не регистрировались на этом сайте, просто проигнорируйте это письмо и удалите его. Вы больше не получите такого письма.\r\n\r\n------------------------------------------------\r\nВаш логин и пароль на сайте:\r\n------------------------------------------------\r\n\r\nЛогин: {%username%}\r\nПароль: {%password%}\r\n\r\n------------------------------------------------\r\nИнструкция по активации\r\n------------------------------------------------\r\n\r\nБлагодарим Вас за регистрацию.\r\nМы требуем от Вас подтверждения Вашей регистрации, для проверки того, что введённый Вами e-mail адрес - реальный. Это требуется для защиты от нежелательных злоупотреблений и спама.\r\n\r\nДля активации Вашего аккаунта, зайдите по следующей ссылке:\r\n\r\n{%validationlink%}\r\n\r\nЕсли и при этих действиях ничего не получилось, возможно Ваш аккаунт удалён. В этом случае, обратитесь к Администратору, для разрешения проблемы.\r\n\r\nС уважением,\r\n\r\nАдминистрация $url.')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (2, 'feed_mail', '{%username_to%},\r\n\r\nДанное письмо вам отправил {%username_from%} с сайта $url\r\n\r\n------------------------------------------------\r\nТекст сообщения\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\nIP адрес отправителя: {%ip%}\r\n\r\n------------------------------------------------\r\nПомните, что администрация сайта не несет ответственности за содержание данного письма\r\n\r\nС уважением,\r\n\r\nАдминистрация $url')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (3, 'lost_mail', 'Уважаемый {%username%},\r\n\r\nВы сделали запрос на получение забытого пароля на сайте $url Однако в целях безопасности все пароли хранятся в зашифрованном виде, поэтому мы не можем сообщить вам ваш старый пароль, поэтому если вы хотите сгенерировать новый пароль, зайдите по следующей ссылке: \r\n\r\n{%lostlink%}\r\n\r\nЕсли вы не делали запроса для получения пароля, то просто удалите данное письмо, ваш пароль храниться в надежном месте, и недоступен посторонним лицам.\r\n\r\nIP адрес отправителя: {%ip%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (4, 'new_news', 'Уважаемый администратор,\r\n\r\nуведомляем вас о том, что на сайт  $url была добавлена новость, которая в данный момент ожидает модерации.\r\n\r\n------------------------------------------------\r\nКраткая информация о новости\r\n------------------------------------------------\r\n\r\nАвтор: {%username%}\r\nЗаголовок новости: {%title%}\r\nКатегория: {%category%}\r\nДата добавления: {%date%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (5, 'comments', 'Уважаемый {%username_to%},\r\n\r\nуведомляем вас о том, что на сайт  $url был добавлен комментарий к новости, на которую вы были подписаны.\r\n\r\n------------------------------------------------\r\nКраткая информация о комментарии\r\n------------------------------------------------\r\n\r\nАвтор: {%username%}\r\nДата добавления: {%date%}\r\nСсылка на новость: {%link%}\r\n\r\n------------------------------------------------\r\nТекст комментария\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\n------------------------------------------------\r\n\r\nЕсли вы не хотите больше получать уведомлений о новых комментариях к данной новости, то проследуйте по данной ссылке: {%unsubscribe%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (6, 'pm', 'Уважаемый {%username%},\r\n\r\nуведомляем вас о том, что на сайте  $url вам было отправлено персональное сообщение.\r\n\r\n------------------------------------------------\r\nКраткая информация о сообщении\r\n------------------------------------------------\r\n\r\nОтправитель: {%fromusername%}\r\nДата  получения: {%date%}\r\nЗаголовок: {%title%}\r\n\r\n------------------------------------------------\r\nТекст сообщения\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url')";

$row = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_email" );
if ($row['count']<6)
{
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (7, 'new_pm', '{%to%},\r\n\r\n{%username%} {%sex%} Вам личное сообщение.\r\nПросмотреть Ваши новые личные сообщения можно на странице:\r\n".$url."index.php?do=pm\r\n\r\nС уважением,\r\nАдминистрация $url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (8, 'new_cammen', 'Уведомляем вас о том,\r\nчто на сайте  ".$url." в клубе новый комментарий.\r\n------------------------------------------------\r\nПрочитать комментарий от {%username%}, можно тут: ".$url."clubizm/{%to%}\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (9, 'new_clubco', 'Уведомляем вас о том,\r\nчто на сайте  ".$url." в клубе \"{%to%}\" новый комментарий.\r\n------------------------------------------------\r\nПрочитать комментарий от {%username%}, можно на странице клуба: ".$url."clubizm/{%tourl%}\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (10, 'new_clubne', 'Уведомляем вас о том,\r\nчто на сайте  ".$url." в клубе {%to%} новая новость.\r\n------------------------------------------------\r\nПрочитать новость, можно на странице клуба: ".$url."clubizm/{%to%}. Или по прямому адресу новости: {%fullnews%}\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (11, 'new_comodn', 'Уведомляем вас о том,\r\nчто на сайте  ".$url." у пользователя {%to%} новый комментарий.\r\n------------------------------------------------\r\nПрочитать комментарий от {%username%}, можно на личной странице: ".$url."user/{%tourl%}. \r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email VALUES (12, 'new_comut', 'Уведомляем вас о том,\r\nчто на сайте  ".$url." был добавлен комментарий на вашу страницу.\r\n------------------------------------------------\r\nПрочитать комментарий от {%username%}, можно на вашей странице: ".$url."user/{%tourl%}.\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` VALUES (13, 'new_inform', 'Здравствуйте, {%username%}\r\n\r\nУведомляем вас о том,\r\nчто ваш запрос на создание информера для вашего сайта \"{%to%}\" был отправлен модератору проекта.\r\n------------------------------------------------\r\nПосле подтверждения модератором, вам будет выслан код для вставки на сайт и исходные коды для стилей в .css файле.\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` VALUES (14, 'app_inform', 'Уведомляем вас о том,\r\nчто ваш запрос на создание информера для вашего сайта {%to%} был принят.\r\n------------------------------------------------\r\nВаш код информера:\r\n{%code_informer%}\r\n\r\nСтили для вставки на сайт:\r\n{%style_informer%}\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(15, 'new_addobj', 'Уведомляем вас о том,\r\nчто на сайте  ".$url." в раздел ".$url."doska/{%to%}/ добавлено новое объявление {%title%}.\r\n------------------------------------------------\r\nПосмотреть объявление от {%username%}, можно на странице: ".$url."{%sub%}doska/obj/{%tourl%}/.\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(16, 'new_addaut', 'Уведомляем вас о том,\r\nчто на сайте  ".$url." в авто справочник на страницу ".$url."autocat/about_model/{%to%}/ добавлен новый комментарий.\r\n------------------------------------------------\r\nКомментарий от {%username%}\r\n\r\nТекст комментария: {%title%}\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n$url')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(37, 'edazayavka', 'Уважаемый {%namer%},\r\n\r\nУведомляем вас о том, что была оставлена заявка на {%type%}.\r\n\r\n------------------------------------------------\r\nКраткая информация о комментарии\r\n------------------------------------------------\r\n\r\nКол-во людей: {%who%}\r\nСредний чек на человека: {%date%}\r\nПожелание по месту расположения (район): {%link%}\r\nПожелание по дате мероприятия: {}\r\nДополнительная информация: {}\r\nДополнительные пожелания: {}\r\n\r\n------------------------------------------------\r\nКонтактная информация\r\n------------------------------------------------\r\n\r\nФИО: {%text%}\r\nEmail: {}\r\nТелефон: {}\r\nICQ: {}\r\n\r\n------------------------------------------------\r\n\r\nС уважением,\r\n{%home_title%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(38, 'sendcart', 'Уважаемый {%namer%},\r\n\r\nУведомляем вас о том, что был оформлен заказ {%type%}.\r\n\r\n------------------------------------------------\r\nКраткая информация о комментарии\r\n------------------------------------------------\r\n\r\nЗаказанные товары: {%who%}\r\nОбщая стоимость: {%price%}\r\nДата заказа: {%date%}\r\n{%doppole%}\r\n\r\n------------------------------------------------\r\nКонтактная информация\r\n------------------------------------------------\r\n\r\nФИО: {%fio%}\r\nEmail: {%email%}\r\nТелефон: {%phone%}\r\nICQ: {%icq%}\r\n\r\n------------------------------------------------\r\n\r\nС уважением,\r\n{%home_title%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(39, 'reg_rating', 'Здравствуйте <b>{%url%}</b>,\r\n\r\nПозвольте поздравить Вас с успешной регистрацией в рейтинге сайтов - {%home_title%}. Информация о Вашем ресурсе:\r\n\r\n<b>Ваш уникальный номер [ID]: {%memberid%}\r\nИмя сайта : {%sitename%}\r\nАдрес сайта : {%url%}\r\nОписание сайта: {%description%}\r\n\r\nМы гордимся возможностью предоставить Вам профессиональный статистический сервис. Мы уверены, что наш сервис поможет Вам в развитии и продвижении Вашего проекта!\r\n\r\nДля дальнейшей работы Вам необходимо разместить на страницах ресурса специальный HTML-код. Код начнет собирать для вас статистику посещаемости вашего ресурса, а также обеспечит возможность участия в рейтинге.\r\n\r\nЧтобы получить код счетчика, воспользуйтесь этой ссылкой:\r\n{%http_home_url%}/rating/get_code/\r\n\r\nЕсли у вас возникли вопросы или предложения, обратитесь в {%http_home_url%}feedback/\r\nтехническую поддержку:\r\n\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(40, 'reg_ratins', 'Здравствуйте,\r\n\r\nВ топ был добавлен новый сайт:\r\nИнформация:\r\nУникальный номер [ID]: {%memberid%}\r\nИмя сайта : {%sitename%}\r\nEmail : {%email%}\r\nАдрес сайта : {%url%}\r\nОписание сайта : {%description%}\r\nПароль : {%pssw2%}\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(41, 'reg_st1', 'Статистика за прошедшие сутки:\r\n\r\nВаш ID: {%id%}\r\nХосты: {%host%}\r\nХиты: {%hits%}\r\nПользователи: {%users%}\r\n\r\nБолее подробную информацию Вы можете посмотреть {%http_home_url%}?do=stats_sites&id={%id%} на странице статистики Вашего сайта\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(42, 'hotelzayav', 'Здравствуйте!\r\n\r\nПоступила заявка на бронирование номера:\r\nГостиница (квартира): {%se%}\r\nКонтактный телефон: {%contact_phone%}\r\nКонтактный email: {%contact_email%}\r\nФИО для контактов: {%contact_type%} {%contact_name%}\r\nГостей: {%dop_pole%}\r\nНомер: {%room_id%}\r\nКол-во номеров: {%room_count%}\r\nФорма оплаты: {%pay_type%}\r\nКол-во людей: {%guests_count%}\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(43, 'hotelzayas', 'Здравствуйте!\r\n\r\nВы направили заявку на бронирование номера:\r\nГостиница (квартира): {%se%}\r\nГостей: {%dop_pole%}\r\nНомер: {%room_id%}\r\nКол-во номеров: {%room_count%}\r\nФорма оплаты: {%pay_type%}\r\nКол-во людей: {%guests_count%}\r\n\r\nВ ближайшее время с вами свяжется менеджер данной гостиницы (квартиры) и уточнит детали бронирования.\r\n\r\n--\r\n{%home_title%} | {%http_home_url%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(44, 'videocom', 'Здравствуйте!\r\n\r\nУведомляем вас о том, что на сайте {%home_title%} в разделе видеозаписи появился новый комментарий.\r\n\r\nПрочитать комментарий можно на странице: {%http_home_url%}archiv_video/{%idvideo%}.html\r\n\r\nС Уважением,\r\nАдминистрация {%home_title%}')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email` (`id`, `name`, `template`) VALUES(45, 'firm_com', 'Уведомляем вас о том,\r\nчто на сайте  {%http_home_url%} для организации \"{%to%}\" добавлен новый комментарий.\r\n------------------------------------------------\r\nПрочитать комментарий от {%username%}, можно на странице клуба: {%http_home_url%}firm/{%tourl%}\r\n------------------------------------------------\r\nС уважением,\r\nАдминистрация\r\n{%http_home_url%}')";
}

$row = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_email_vip" );
if ($row['count']<3)
{
$tableSchema[] = "INSERT INTO `" . PREFIX . "_email_vip` (`id`, `name`, `template`) VALUES
(1, 'demo', 'Уважаемый {%username%},\r\n\r\nЭто письмо отправлено с сайта ".$url."\r\n\r\nВы получили это письмо, так как этот e-mail адрес был использован при получении демо-ключа.\r\n\r\n------------------------------------------------\r\nВаш демо-ключ на сайте:\r\n------------------------------------------------\r\n\r\nКлюч: {%demo%}\r\n\r\n------------------------------------------------\r\nИнструкция по активации\r\n------------------------------------------------\r\n\r\nЗайдите в Ваш профиль на сайте ".$url." и поле для активации ключа введите вышеуказанный ключ и нажмите кнопку \"Активировать\".\r\n\r\nПерейти в профиль: {%linkprofile%}\r\n\r\nС уважением,\r\n\r\nАдминистрация сайта ".$url."'),
(2, 'activ_key', 'Уважаемый администратор,\r\n\r\nуведомляем вас о том, что на сайте ".$url." был активирован ключ:\r\n\r\n------------------------------------------------\r\nКраткая информация\r\n------------------------------------------------\r\n\r\nАктивировал: {%username%}\r\nКлюч: {%key%}\r\nДата активации: {%date%}\r\nВремя активации: {%time%}\r\nРезультат: {%status%}\r\n\r\nС уважением,\r\n\r\nАдминистрация портала ".$url."'),
(3, 'auto', 'Уважаемый {%username%},\r\n\r\nЭто письмо отправлено с сайта ".$url."\r\n\r\nВы получили это письмо, так как этот e-mail адрес был использован при получении ключа.\r\n\r\n------------------------------------------------\r\nВаш ключ на сайте:\r\n------------------------------------------------\r\n\r\nКлюч: {%key%}\r\n\r\n------------------------------------------------\r\nИнструкция по активации\r\n------------------------------------------------\r\n\r\nЗайдите в модул v.i.p.  на сайте ".$url." и поле для активации ключа введите вышеуказанный ключ и нажмите кнопку \"Активировать\".\r\n\r\nПерейти в modul v.i.p: {%linkvip%}\r\n\r\nС уважением,\r\n\r\nАдминистрация сайта ".$url."')";
}

$row = $db->super_query( "SELECT COUNT(id) as count FROM " . PREFIX . "_forum_email" );
if ($row['count']<4)
{
$tableSchema[] = "INSERT INTO `" . PREFIX . "_forum_email` (`id`, `name`, `template`) VALUES
(1, 'subscription_text', 'Здравствуйте, {%username_to%}!\r\n\r\n{%username_from%} ответил в тему \"{%topic_name%}\", на которую вы подписаны.\r\n\r\nТема находится по адресу:\r\n\r\n{%topic_link%}\r\n\r\n------------------------------------------------\r\nВы можете в любое время отписаться от такой рассылки через ссылку:\r\n\r\n{%topic_link_del%}\r\n\r\n------------------------------------------------\r\n\r\nС уважением,\r\n\r\nАдминистрация ".$url."'),
(2, 'frend_text', '{%username_to%},\r\n\r\nДанное письмо вам отправил {%username_from%} с сайта ".$url."\r\n\r\n------------------------------------------------\r\nТекст сообщения\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\n------------------------------------------------\r\nПомните, что администрация сайта не несет ответственности за содержание данного письма\r\n\r\nС уважением,\r\n\r\nАдминистрация ".$url."'),
(3, 'report_text', 'Данную жалобу вам отправил {%username_from%} с сайта ".$url."\r\n\r\n------------------------------------------------\r\nТекст жалобы\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\n------------------------------------------------\r\nКраткая информация о жалобе\r\n------------------------------------------------\r\n\r\nТема: {%topic_link%}\r\n\r\nID сообщения: {%post_id%}\r\n\r\n------------------------------------------------\r\n\r\nС уважением,\r\n\r\nАдминистрация ".$url."'),
(4, 'new_topic', 'Уважаемый администратор,\r\n\r\nуведомляем вас о том, что на форум сайта  ".$url." была добавлена тема.\r\n\r\n------------------------------------------------\r\nКраткая информация о теме\r\n------------------------------------------------\r\n\r\nАвтор: {%username%}\r\nДата добавления: {%date%}\r\nНазвание темы: {%title%}\r\nСсылка на тему: {%link%}\r\n\r\n\r\nС уважением,\r\n\r\nАдминистрация ".$url."')";
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
(1, 'counter', 'Счетчики', '<div align=center><a href=http://web2work.ru/><img width=88 src=/uploads/banners/88x31.png></a><a href=http://web2work.ru/><img width=88 src=/uploads/banners/88x31.png></a> <a href=http://web2work.ru/><img width=88 src=/uploads/banners/88x31.png></a><a href=http://web2work.ru/><img width=88 src=/uploads/banners/88x31.png></a><br></div>', 1, 0, 1, 0, '0', 'all', '1', '', '', 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', 0, '0'),
(2, 'foother', 'Нижний баннер', '<img src=\"/uploads/banners/728x90.png\">', 1, 0, 1, 0, '0', 'all', '1', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(3, 'right', 'Правый баннер', '<img src=\"/uploads/banners/240x400.png\">', 1, 0, 0, 0, '0', 'all', '1', '', '', 1, 0, 500, 90000, 0, 0, 0, 0, '', '', '', 0, '0'),
(6, 'content', 'Баннер в теле страницы', '<img src=\"/uploads/banners/468x60.png\">', 1, 0, 0, 0, '0', 'all', '1', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(28, 'main_right_foother', 'Правый нижний на главной', '<img src=\"/uploads/banners/468x60.png\">', 0, 0, 0, 0, '', 'all', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(29, 'news_2', 'Центральный нижний на главной', '<img src=\"/uploads/banners/468x60.png\">', 0, 0, 0, 0, '', 'all', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(22, 'top', 'Верхний', '<img src=\"/uploads/banners/728x90.png\">', 1, 0, 0, 0, '', 'all', '', '', '', 0, 500, 600, 0, 0, 0, 0, 0, '', '', '', 0, '0'),
(26, 'main_right_top', 'Правый верхний на главной', '<img src=\"/uploads/banners/468x60.png\">', 0, 0, 0, 0, '', 'all', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0'),
(25, 'top_news', 'На главной, над главной новостью', '<div style=\"max-width: 100%; height: 100%; max-height: 45px\"><a href=\"#\" target=\"_blank\"><img src=\"/uploads/banners/news-top-banner.png\" style=\"width: 100%;\"></a></div>', 0, 0, 0, 0, '0', 'all', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 0, '', '', '', 0, '0')";

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
//// добавление баннеров до версии 10.0 было в установщике
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
(1010, 'kino', 'Кино', '', '141', 'yes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1011, 'club', 'Клубы', '', '131', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1012, 'concert', 'Концертный зал', '', '149', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1013, 'concerthall', 'Театр', '', '256', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1014, 'performance', 'Спектакли', '', '256', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1015, 'exhibition', 'Выставки', '', '246', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1016, 'sport', 'Спорт', '', '629', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1017, 'other', 'Другое', '', '117', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');";

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
(12, 'Тортик', '11.jpg', 10, 1, 0, 0, 0),
(13, 'Кофе', '1.jpg', 1, 2, 0, 0, 0),
(14, 'С Днем Рождения!', '10.jpg', 10, 3, 0, 0, 0),
(15, 'Сюрприз', '12.jpg', 5, 1, 0, 0, 0),
(16, 'Незабываемо', '13.jpg', 2, 2, 0, 0, 0),
(17, 'Тусовка', '14.jpg', 3, 0, 0, 0, 0),
(18, 'Ура! Пятница!', '15.jpg', 1, 0, 0, 0, 0),
(19, 'Классно отдохнули!', '16.jpg', 20, 1, 0, 0, 0),
(20, 'Привет!', '2.jpg', 1, 1, 0, 0, 0),
(21, ';)', '21.jpg', 1, 0, 0, 0, 0),
(22, 'Мороженка', '3.jpg', 1, 0, 0, 0, 0),
(23, 'Игра', '4.jpg', 1, 0, 0, 0, 0),
(24, 'Хомяк', '5.jpg', 1, 0, 0, 0, 0),
(25, 'Подарок', '6.jpg', 30, 1, 0, 0, 0),
(26, 'Зайчик', '7.jpg', 1, 0, 0, 0, 0),
(27, 'Подарки', '8.jpg', 1, 1, 0, 0, 0),
(28, 'Спорт', '9.jpg', 1, 0, 0, 0, 0),
(30, 'Осторожно!', '24.jpg', 1, 2, 0, 0, 0),
(31, 'Моя симпатия', '52.jpg', 1, 0, 0, 0, 0),
(32, 'Целую', '46.jpg', 1, 0, 0, 0, 0),
(33, 'Букет роз', '200-27.jpg', 10, 3, 0, 0, 0)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_arcade_category`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_arcade_category` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `alt_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `alt_name` (`alt_name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_arcade_category` (`id`, `name`, `alt_name`) VALUES
(1, 'Аркады', 'arcade'),
(2, 'Логические', 'logic'),
(3, 'Эротические', 'ero'),
(4, 'Леталки', 'fly'),
(5, 'Детские', 'kid'),
(6, 'Интелектуальные', 'brain'),
(7, 'Спортивные', 'sport'),
(8, 'Гонки', 'car'),
(9, 'Стрелялки', 'shot'),
(10, 'Драки', 'fight')";

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
(1, 'adameva', 'Суть игры в том, чтобы сделать с Евой ЭТО, и сделать быстро пока на Вас накинулся Кин Когн.', 27, 'Eva And Adam', 'FFFFF', 500, 450, 'ero', 0, 0, 0),
(2, 'asshunter', 'Вы должны оборонятьса от злостных маньяков каторые прячатса в кустах', 33, 'Ass hunter', 'FFFFFF', 500, 340, 'ero', 0, 0, 0),
(3, 'asteroids', 'Ваше цель очистить космическое пространство от метеоритов', 27, 'Asteroids', '000000', 500, 400, 'fly', 0, 0, 0),
(4, 'blocksibpa', 'Цель игры уничтожить блоки одинакого цвета', 28, 'Blocks', 'FFFFFF', 500, 300, 'logic', 0, 0, 0),
(5, 'breakout', 'Правила схожи с обычной игрой Arcanoid', 28, 'Breakout', '000000', 500, 350, 'arcade', 0, 0, 0),
(6, 'conundrumibpro', 'Нужно поднять 25 блоков в отведенное на это время.', 31, 'Conundrum', 'FFFFFF', 500, 350, 'brain', 0, 0, 0),
(7, 'crazycloset', 'Поймайте шарики в коробку', 27, 'Сrazy Сloset', '000000', 370, 500, 'kid', 0, 0, 0),
(8, 'donkeykong', 'Спасите возлюбленную Марио', 29, 'Donkey Kong', '000000', 400, 500, 'arcade', 0, 0, 0),
(9, 'hexxagon', 'Вам нужно выставить больше фигур чем компьютеру', 28, 'Hexxagon', '000000', 500, 400, 'logic', 5, 1, 0),
(10, 'helicopter', 'Вы должны пролететь весь нелегкий путь на вертолете облитая препядствия', 27, 'Helicopter', '000000', 500, 400, 'fly', 5, 1, 0),
(11, 'invaders', 'еще один вариант звездных воинов', 25, 'Space Invaders', '000000', 500, 400, 'fly', 0, 0, 0),
(12, 'moonlander', 'Управляйте кораблём и посадите его на все площадки. За каждую посадку вам прибавляется 100 очков. Но следите за количеством топлива', 26, 'Moon Lander', '000000', 500, 400, 'fly', 0, 0, 0),
(13, 'pacman', 'Съешьте все точки, чтобы перейти к следующему уровню. ', 29, 'Pac Man', '000', 400, 500, 'arcade', 0, 0, 0),
(14, 'penguinhit', 'Поподите пенгвином в цель', 29, 'Penguin Hit', 'FFFFFF', 500, 310, 'sport', 0, 0, 0),
(15, 'simon', 'Интересная игра на память. Вам нужно повторить нажатия на кнопки, в такой последевательности, в какой на них нажимал компьютер. ', 21, 'Simon', '000000', 500, 400, 'brain', 0, 0, 0),
(16, 'snake', 'Задача проста - съесть как можно больше, при этом не столкнуться с собой. Каждый съеденный кружок добавляет змейке длину.', 26, 'Snake', '000000', 500, 400, 'arcade', 0, 0, 0),
(17, 'tetris', 'Собирайте из фигур линии. Полностью заполненные линии убираются.', 27, 'Tetris', 'ffffff', 400, 500, 'arcade', 0, 0, 0),
(18, 'flowfrenibpro', 'собираем в ряды 3 и больше одинаковых цветка \r\nигра на время!', 23, 'FLOWER FRENZY', 'ffffff', 500, 400, 'kid', 0, 0, 0),
(19, 'SparkYourNeuronsSte', 'Съеш как можн больше точек двигаясь как в шашках(едят перешагивая через одну).\r\nДвигайся как можно быстрее!', 25, 'Spark Your Neurons', 'ffffff', 500, 400, 'logic', 0, 0, 0),
(20, 'zookeepermp', 'очередная хитовая игрушка, собираем в ряд одинаковых животных', 23, 'Zoo Keeper', '000000', 500, 400, 'kid', 0, 0, 0),
(21, 'collapseibpa', 'шарики', 24, 'Collapse', 'ffffff', 500, 350, 'logic', 0, 0, 0),
(22, 'yeti1greece', 'Кто дальше отправит пингвина тот и молодец!\r\nВсего 5 попыток.  ', 24, 'yeti в греции', 'ffffff', 500, 350, 'sport', 0, 0, 0),
(23, 'billibpro', 'Бильярд.\r\nЗабей все шары меньшее колличество ходов.\r\nИгра заканчивается если белый шар в лузе.', 21, 'Billards', '000000', 500, 350, 'sport', 0, 0, 0),
(24, 'ubillibpro', 'Попробуй очистить стол до того как законится время! ', 32, 'Ultimate Billiards', 'ffffff', 500, 400, 'sport', 0, 0, 0),
(25, 'exraceibpro', 'Беспредельные гонки на F1', 21, 'Extreme Racing', 'ffffff', 500, 350, 'car', 0, 0, 0),
(26, 'togyballBH', 'Настольный хоккей. \r\nНе дай попасть сопернику в твои ворота\r\nигра до 21 очка! ', 24, 'togyballBH', 'ffffff', 350, 500, 'sport', 0, 0, 0),
(27, 'socceribpro', 'Просто кликай по мячу, удерживая его в воздухе так долго как сможеш.', 25, 'Soccer Ball', 'ffffff', 500, 400, 'sport', 0, 0, 0),
(28, 'uracingibpro', 'Гонки.\r\nВид сверху. ', 27, 'Ultimate Racing', 'ffffff', 500, 400, 'car', 0, 0, 0),
(29, 'jigsawdogibpro', 'Паззл. ', 24, 'JigSaw Puzzle Dog', 'ffffff', 500, 400, 'logic', 0, 0, 0),
(30, 'jigsawmonkeyibpro', 'Паззл. ', 34, 'JigSaw Puzzle Monkey', 'ffffff', 500, 400, 'logic', 0, 0, 0),
(31, 'monsterhatchibpa', 'необходимо открыть все яйца. ', 90, 'Monster Hatch', 'ffffff', 500, 400, 'brain', 0, 0, 0),
(32, 'slidermaniaibpro', 'Собираем паззл на время. ', 106, 'Slidermania', 'ffffff', 500, 350, 'kid', 5, 1, 0),
(33, 'pislandibpro', 'собираем пазл на время!', 84, 'Paradise Island:Jig Saw Puzzle', 'ffffff', 500, 400, 'logic', 5, 1, 0),
(34, 'spaceace', 'спасаем землю от пришельцев! ', 102, 'spaceace', '000000', 500, 400, 'fly', 0, 0, 0),
(35, 'snakenew', 'Новая версия всем известной игры snake', 110, 'snakenew', 'ffffff', 500, 400, 'arcade', 0, 0, 0),
(36, 'blocks2mp', 'Хитовая игрушка!!! (аналогичная тема установленная почти в каждом кпк pocket pc) ', 101, 'Blocks', 'FFFFFF', 500, 400, 'logic', 0, 0, 0),
(37, 'sonicblox', 'тетрис с бонусами.', 96, 'sonicblox', 'ffff00', 380, 500, 'arcade', 0, 0, 0),
(38, 'moodmatchibpro', 'Найди пары одинаковых лиц.\r\nИгра на память и на время. ', 99, 'Mood Match', 'ffffff', 500, 400, 'kid', 0, 0, 4),
(39, 'ultimatepingibpro', 'Арканоид. ', 106, 'Ultimate Ping', 'ffffff', 500, 360, 'sport', 2, 1, 0),
(40, 'usnakeibpro', 'Змейка ', 106, 'Ultimate Snake', 'ffffff', 370, 500, 'arcade', 0, 0, 0),
(41, 'chicken', 'Строим пирамиду из циплят.\r\nСобираем бонусные фишки. ', 101, 'chicken', 'ffffff', 400, 500, 'arcade', 5, 1, 0),
(42, 'x227sm', 'Отличный шутер', 96, 'x227sm', '000000', 500, 400, 'shot', 0, 0, 0),
(43, 'flayersm', 'Вы управляете самалетом и должны облитать препятсвия', 98, 'Flayer', '000000', 400, 450, 'arcade', 0, 0, 0),
(44, 'skates', 'Катайтесь на каньках, очень прикольно', 94, 'Crazy Scates', 'FFFFFF', 500, 400, 'sport', 0, 0, 0),
(45, 'bombjack', 'Собирайте бомбы и не попадайтесь роботам', 98, 'Bomb Jack', 'FFFFFF', 500, 400, 'arcade', 0, 0, 0),
(46, 'castle_defender', 'Стрельба из лука по разбойникам', 104, 'Castle Defender', 'FFFFFF', 400, 500, 'shot', 0, 0, 0),
(47, 'muaythai', 'Лесные драки, много разных ударов и противников', 95, 'Muay Thai', '000000', 500, 400, 'fight', 0, 0, 0),
(48, 'firebase36', 'Битва в Вьетнаме', 101, 'Mud and Blood (vietnam)', '000000', 500, 400, 'arcade', 0, 0, 0),
(49, 'urbanslug2', 'Проходите миссии, зарабатывайте деньги', 106, 'Urabanslug', '000000', 500, 400, 'arcade', 3, 1, 0),
(50, 'sonic', 'Всем известная с детства игра', 164, 'Sonic', '000000', 500, 400, 'arcade', 4, 1, 2)";

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
(12, 'Тортик', '11.png', 10, 2, 0, 0, 0),
(13, 'Кофе', '1.png', 1, 3, 0, 0, 0),
(14, 'С Днем Рождения!', '10.png', 10, 3, 0, 0, 0),
(15, 'Сюрприз', '12.png', 5, 1, 0, 0, 0),
(16, 'Незабываемо', '13.png', 2, 1, 0, 0, 0),
(20, 'Привет!', '2.png', 1, 2, 0, 0, 0),
(22, 'Мороженка', '3.png', 1, 0, 0, 0, 0),
(23, 'Игра', '4.png', 1, 0, 0, 0, 0),
(24, 'Хомяк', '5.png', 1, 1, 0, 0, 0),
(25, 'Подарок', '6.png', 30, 1, 0, 0, 0),
(26, 'Зайчик', '7.png', 1, 1, 0, 0, 0),
(27, 'Подарки', '8.png', 1, 1, 0, 0, 0),
(28, 'Спорт', '9.png', 1, 0, 0, 0, 0)";

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
(1, 'МДМ Банк', 'http://bcs-bank.com/export/quotes/csv.asp', 0, 0, '".$_REQUEST['reg_name']."', 0)";

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
(1, 'Сочи1', 'http://www.kgs.ru/fin/', 5, 0, '".$_REQUEST['reg_name']."', 0, '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"90%\" align=\"center\">(.*)</table>', '<td class=\"table_cell\"(.*?)>(.*?)</td>'),
(2, 'Екатеринбург', 'http://www.66.ru/bank/currency/', 6, 0, '".$_REQUEST['reg_name']."', 0, '<table class=\"rates_table\">(.*)</table>', '<td(.*?)>(.*?)</td>'),
(3, 'Сочи', 'http://www.kgs.ru/fin/', 5, 1, '".$_REQUEST['reg_name']."', 0, '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"90%\">(.*)</table>', '<td class=\"table_cell\"(.*?)>(.*?)</td>'),
(4, 'Сочи', 'http://www.kgs.ru/fin/', 9, 2, '".$_REQUEST['reg_name']."', 0, '<td width=\"51%\" class=\"table_bank\">(.*)</table>', '<td class=\"table_cell\"(.*?)>(.*?)</td>'),
(5, 'Краснодар', 'http://www.kgs.ru/fin/', 8, 3, '".$_REQUEST['reg_name']."', 0, '<table class=''bank_coins_table'' cellspacing=1>(.*)</table>', '<td(.*?)>(.*?)</td>'),
(9, 'Сочи', 'http://sochi1.ru/exchange/exchange.html', 6, 0, '".$_REQUEST['reg_name']."', 1, '<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"table2\">(.*)</table>', '<td(.*?)>(.*?)</td>')";

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
(11, 'creditauto', 'Кредит - Автокредит', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 'creditpotrebit', 'Кредит - Потребительский', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, 'creditipoteka', 'Кредит - Ипотечный', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, 'creditcard', 'Кредитная карта', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(15, 'straxovanieauto', 'Страхование - Автомобиль', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(16, 'straxovaniekvartira', 'Страхование - Квартира', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(17, 'straxovaniestroenie', 'Страхование - Строение', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";

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
(155, 0, 1, 'Банки', 'banki', '', '', '', 'банки, кредиты, страхование, отзывы о банках', '', '', 0, '', '', 'no', 0, '', '', 0),
(156, 0, 1, 'Юридическим лицам', 'corporate', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(157, 0, 1, 'Физическим лицам', 'consumer', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(158, 0, 1, 'Отзывы о банках', 'forum', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(161, 155, 1, 'Список банков', 'banks', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(162, 155, 1, 'Кредитные брокеры', 'brokers', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(163, 155, 1, 'Офисы банков', 'offices', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(165, 155, 1, 'Рейтинг банков', 'bankrating', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(167, 155, 1, 'Курсы валют банков', 'currency', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(168, 155, 1, 'Банкоматы', 'cash', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(170, 157, 1, 'Кредиты населению', 'crediting', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(171, 157, 1, 'Кредитные карты', 'creditcard', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(172, 157, 1, 'Автокредиты', 'autocrediting', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(173, 157, 1, 'Ипотека', 'hypothec', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(174, 157, 1, 'Вклады банков', 'deposit', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(175, 157, 1, 'Заявка на кредит', 'credit_order', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(179, 156, 1, 'Заявка на кредит', 'biz_order', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(180, 156, 1, 'Кредиты бизнесу', 'creditin', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(181, 156, 1, 'Депозиты', 'deposits', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(182, 156, 1, 'Расчетно-кассовое обслуживание', 'rko', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(183, 156, 1, 'Факторинг', 'factoring', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(184, 156, 1, 'Лизинг', 'leasing', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0),
(210, 155, 1, 'Все отзывы о банках', 'forumblog', '', '', '', '', '', '', 0, '', '', '', 0, '', '', 0)";

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
(1, 'Город', 'citys', 'город', '0'),
(2, 'Деревня', 'derevni', 'деревню', '0'),
(3, 'Посёлок', 'poselok', 'посёлок', '0')";

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
(3, 0, 1, 'Музыка и Кино', 'reviews', 'guitar00.gif', '', '', '', '', '', 0, '', '', ''),
(2, 0, 2, 'Искусство и Культура', 'issk', 'sights00.gif', '', '', '', '', '', 0, '', '', ''),
(4, 0, 3, 'Любовь и отношения', 'content', 'children.gif', '', '', '', '', '', 0, '', 'adv_shab', ''),
(5, 0, 1, 'Семья и Дом', 'interview', 'plc_hm00.gif', '', '', '', '', '', 0, '', '', ''),
(6, 0, 4, 'Красота и Здоровье', 'musobzor', 'medic000.gif', '', '', '', '', '', 20, '', '', ''),
(7, 0, 1, 'Мир и Регионы', 'moda', 'gov00000.gif', '', '', '', '', '', 0, '', '', ''),
(8, 0, 1, 'Бизнес и Финансы', 'love', 'plc_wrk0.gif', '', '', '', '', '', 0, '', '', ''),
(9, 0, 1, 'Политика и Общество', 'video', 'orgs0000.gif', '', '', '', '', '', 0, '', '', ''),
(10, 0, 1, 'Образование и Карьера', 'avtomoto', 'hummer00.gif', '', '', '', '', '', 0, '', '', ''),
(11, 0, 1, 'Наука и Техника', 'kurezi', 'hummer00.gif', '', '', '', '', '', 0, '', '', ''),
(12, 0, 5, 'Компьютеры и Интернет', 'todj', 'openid-i.gif', '', '', '', '', '', 0, '', '', ''),
(13, 0, 1, 'Автомобили и Транспорт', 'djlab', 'auto0000.gif', '', '', '', '', '', 0, '', '', ''),
(19, 0, 1, 'Развлечения и Хобби', 'cafes', 'fitnes00.gif', '', '', '', '', '', 0, '', '', ''),
(15, 0, 1, 'Спорт и Путешествия', 'review', 'ball0000.gif', '', '', '', '', '', 0, '', '', ''),
(16, 0, 6, 'Животные и природа', 'concurs', 'vote_up1.gif', '', '', '', '', '', 0, '', '', ''),
(17, 0, 1, 'Религия и Непознанное', 'clubs', 'plc_int0.gif', '', '', '', '', '', 0, '', '', ''),
(18, 0, 1, 'Свободные темы', 'coolgerl', 'vote_up0.gif', '', '', '', '', '', 0, '', '', '')";

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
(5, 'moto', 'Мотоциклы', 'Самые свежие объявления о продаже подержанных автомобилей. Каждую неделю на доску авто объявлений добавляется около 1000 авто сообщений. Если Вы хотите продать свой подержанный автомобиль в Екатеринбурге или области, вы можете заполнить анкету и подать свое бесплатное объявление в разделе Добавить объявление.', '', '1', 0, '', '1', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1, 'auto', 'Авто', 'Здесь вы найдете большое количество частных объявлений по покупке и продаже авто в Екатеринбурге. Вы можете легко поместить объявление о продаже вашего авто или приобрести автомобиль. Для того чтоб подать объявление необходимо просто нажать на кнопку «Добавить» в верхней панели сайта. Для доступа к своим объявлениям воспользуйтесь разделом «Мои объявления».', '', '0', 0, '', '1', 'about_doska.tpl', '1', '1', '1', '1', '1', '1', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 'car', 'Легковые автомобили', '', '', '1', 418, '', '1', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 'parts', 'Запчасти для автомобилей', '', '', '1', 0, '', '1', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, 'truck', 'Грузовая техника', '', '', '1', 0, '', '1', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, 'nedv', 'Недвижимость', 'Здесь вы найдете большое количество объявлений по покупке и продаже недвижимости в Екатеринбурге: предложения о продаже квартир, аренде офисов гаражей от агентств недвижимости и частных лиц. Вы можете легко разместить объявление о продаже, аренде вашей недвижимости или найти нужную квартиру, офис. Каждое объявление о продаже или аренде недвижимости сопровождается подробной информацией и фотографией помещения.', '', '0', 0, '', '2', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, 'kvar', 'Квартиры', '', '', '3415', 1532, '', '2', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, 'komn', 'Комнаты', '', '', '3415', 0, '', '2', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, 'zemuch', 'Земельные участки', '', '', '3416', 0, '', '10', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 'house', 'Дома и коттеджи', '', '', '3416', 0, '', '10', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, 'garage', 'Гаражи', '', '', '3415', 0, '', '2', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, 'office', 'Офисы', '', '', '3417', 0, '', '11', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(17, 'zoo', 'Животные', '', '', '25', 0, '', '3', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(25, 'gorbar', 'Городская барахолка', '', '', '0', 0, '', '3', '', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(26, 'othersz', 'Прочее', '', '', '25', 0, '', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1003, 'work', 'Работ', '', '', '0', 89, '', '6', 'about_doska_work.tpl', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1005, 'auditbsd', 'Аудит, банковское дело', '', '', '1003', 2, '', '6', 'about_doska_work.tpl', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3334, 'adbuh', 'Бухгалтерия', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3335, 'adfs', 'Финансы, экономика и страхование', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3336, 'adstr', 'Строительство, недвижимость', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3337, 'adprom', 'Промышленность, производство, сервис', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3338, 'adit', 'IT, телеком, связь', '', '', '1003', 0, '', '6', 'about_doska_work.tpl', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3339, 'adsecr', 'Секретариат, АХО', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3340, 'adhr', 'HR, тренинги', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3341, 'admark', 'Маркетинг, реклама, PR', '', '', '1003', 3, '', '6', 'about_doska_work.tpl', '1', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3342, 'adsmi', 'СМИ, Издательство, полиграфия', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3343, 'adregi', 'Региональные, торговые представители', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3344, 'adrozn', 'Розничная торговля ТНП', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3345, 'adprodp', 'Розничная торговля продукты питания', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3346, 'adpromob', 'Продажи (Промышленность, оборудование)', '', '', '1003', 12, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3347, 'adstrnedv', 'Продажи (Строительство, недвижимость)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3348, 'adprodtnt', 'Продажи (ТНП, продукты)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3349, 'aduslrek', 'Продажи (Услуги, реклама)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3350, 'adfinansi', 'Продажи (Финансы, страхование)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3351, 'adavtozap', 'Продажи (Автомобили, запчасти)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3352, 'adprodit', 'Продажи (IT, компьютеры)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3353, 'adpmebel', 'Продажи (Одежда, мебель)', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3354, 'aduris', 'Юриспруденция', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3355, 'adgos', 'Государственная служба', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3356, 'adrestor', 'Рестораторы, повара, официанты', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3357, 'adturism', 'Туризм, гостиницы', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3358, 'adpostavki', 'Поставки, ВЭД', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3359, 'adlogistika', 'Логистика, транспорт, склад', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3360, 'adsx', 'Сельское хозяйство', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3361, 'admedicina', 'Медицина, фармацевтика', '', '', '1003', 1, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3362, 'adsport', 'Спорт, фитнесс, салоны красоты', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3363, 'addesign', 'Дизайнеры, творческие профессии', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3364, 'adkultura', 'Культура, искусство, развлечения', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3365, 'adnauka', 'Наука, образование, консалтинг', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3366, 'adslugba', 'Служба безопасности, охрана', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3367, 'addompers', 'Домашний персонал, обслуживание', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3368, 'adraznorab', 'Разнорабочие', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3369, 'adstudents', 'Работа для молодежи, студентов', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3370, 'adsezon', 'Сезонная, временная работа', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3371, 'adpensioners', 'Работа для пенсионеров', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3415, 'zhil', 'Жилая', '', '', '8', 0, '', '2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3416, 'zagor', 'Загородная', '', '', '8', 0, '', '10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3417, 'comm', 'Коммерческая', '', '', '8', 0, '', '11', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3438, 'upravlenie-personalom-treningi', 'Управление персоналом, тренинги', '', '', '1003', 0, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3440, 'administrativnyy-personal', 'Административный персонал', '', '', '1003', 1, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3441, 'transport-logistika', 'Транспорт, логистика', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3437, 'informacionnye-tehnologii-internet-telekom', 'Информационные технологии, интернет, телеком', '', '', '1003', 3, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3442, 'bezopasnost', 'Безопасность', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3443, 'buhgalteriya-upravlencheskiy-uchet-finansy-predpriyatiya', 'Бухгалтерия, управленческий учет, финансы предприятия', '', '', '1003', 5, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3444, 'vysshiy-menedzhment', 'Высший менеджмент', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3445, 'nachalo-karery-studenty', 'Начало карьеры, студенты', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3446, 'yuristy', 'Юристы', '', '', '1003', 1, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3447, 'rabochiy-personal', 'Рабочий персонал', '', '', '1003', 3, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3448, 'zakupki', 'Закупки', '', '', '1003', 1, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3449, 'banki-investicii-lizing', 'Банки, инвестиции, лизинг', '', '', '1003', 2, '', '6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";

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
(1, 'auto', 'Авто', 'Марка', 'Модель', 'Тип', 'Год', 'Пробег (км)', 'Цвет', 'Объем двигателя (см3)', 'Мощность (л.с)', '', '', '', '', '', '', ''),
(10, 'zagor', 'Недвижимость загородная', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 'nedv', 'Недвижимость', 'Количество комнат', 'Тип', '', 'Район', 'Улица', 'Цена', 'Ипотека', 'Обмен', '', '', '', '', '', '', ''),
(3, 'zoo', 'Общие', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 'rezume', 'Резюме', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 'vacations', 'Вакансии', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, 'beauraut', 'Бюро находок - Найдено', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, 'beauraut_missed', 'Бюро находок - Утеряно', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, 'tenders', 'Тендеры', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, 'comm', 'Недвижимость коммерческая', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 'objectnedv', 'Объекты недвижимости', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, 'predlnovo', 'Предложения новостроек', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, 'predlkot', 'Предложения коттеджей', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(15, 'objectkot', 'Объекты коттеджей', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(16, 'zemuch', 'Недвижимость загородная участки', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";

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
////////////////// ОПРЕДЕЛЯЮЩИЕ СБОРКИ /////////////////////////////
require_once(ROOT_DIR.'/install/db_faq.php');
////////////////////////////////////////////////////////////////////
}

$tableSchema[] = "INSERT INTO `" . PREFIX . "_faqcategories` (`id_cat`, `categories`, `answer_num`, `parentid`, `opisanie`) VALUES
(12, 'Другое', 0, 0, 'Задайте ваш вопрос об автомобилях Suzuki специалистам-представителям официального дилера'),
(9, 'Вопросы по работе с сетью', 1, 0, ''),
(10, 'Общие вопросы', 0, 0, ''),
(11, 'Юридические вопросы', 0, 0, 'Задайте ваш вопрос об автомобилях Suzuki специалистам-представителям официального дилера'),
(17, 'Покупка и продажа', 2, 12, 'Покупка, продажа, кредитование, гарантийное обслуживание и другие важные темы для владельцев автомобилей Toyota'),
(18, 'Автомобили', 0, 9, 'Задайте ваш вопрос об автомобилях Suzuki специалистам-представителям официального дилера'),
(20, 'Недвижимость', 0, 0, ''),
(21, 'Выбор недвижимости', 3, 20, ''),
(22, 'Оформление сделок', 1, 0, ''),
(23, 'Недвижимость, Ипотека', 1, 20, ''),
(24, 'Прочие темы', 0, 20, '')";

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
(22, '22', '".$_REQUEST['reg_name']."', 'тел. 234565646435345', 'Председатель Комитета по защите прав автолюбителей', 'Анастасия Еремкина', '".$_REQUEST['regmail']."', 'Окончила Санкт-Петербургскую государственную инженерно-экономическую академию.\r\nС 2000 года работала в региональных и федеральных банках: администратором, экономистом вексельного отдела, затем специалистом по кредитованию юридических лиц. С 2003 года — начальник отдела факторинга.\r\nВ 2007 — 2009 гг. — заместитель начальника отдела консультирования клиентов в Национальной Факторинговой Компании.\r\nС февраля 2009 — директор представительства НФК в Екатеринбурге.\r\nС 2010 по настоящее время — директор Уральского дивизиона Национальной Факторинговой компании (в Уральский дивизион НФК сегодня входят Свердловская, Челябинская, Пермская, Тюменская области и республика Башкортостан).\r\nЗамужем, воспитывает сына.', 'http://s.66.ru/localStorage/19/c7/6e/d6/19c76ed6_resizedScaled_177to211.jpg'),
(23, '9', '".$_REQUEST['reg_name']."', 'тел. 234565646435345', 'Эксперт по недвижимости', 'Антон Анипкин', '".$_REQUEST['regmail']."', 'afasd asdasfg2v4t4v3t 45v5t45 Описание (история должности Описание (история должности afasd asdasfg2v4t4v3t 45v5t45 Описание (история должности Описание (история должности afasd asdasfg2v4t4v3t 45v5t45 Описание (история должности Описание (история должности', 'http://s.66.ru/localStorage/19/c7/6e/d6/19c76ed6_resizedScaled_177to211.jpg')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_kuhna`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_kuhna` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_firm_kuhna` (`id`, `name`, `alt_name`) VALUES
(1, 'азербайджанская', ''),
(2, 'азиатская', ''),
(3, 'американская', ''),
(4, 'английская', ''),
(5, 'арабская', ''),
(6, 'армянская', ''),
(7, 'бразильская', ''),
(8, 'венгерская', ''),
(9, 'восточная', ''),
(10, 'греческая', ''),
(11, 'грузинская', ''),
(12, 'еврейская', ''),
(13, 'европейская', ''),
(14, 'итальянская', ''),
(15, 'кавказская', ''),
(16, 'канадская', ''),
(17, 'китайская', ''),
(18, 'кубинская', ''),
(19, 'латиноамериканская', ''),
(20, 'мексиканская', ''),
(21, 'немецкая', ''),
(22, 'русская', ''),
(23, 'сербская', ''),
(24, 'средиземноморская', ''),
(25, 'узбекская', ''),
(26, 'украинская', ''),
(27, 'французская', ''),
(28, 'Цыганская', ''),
(29, 'чешская', ''),
(30, 'японская', '')";

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
(1, 'Бытовая техника', 0, 0, 0, 0, NULL, '', '', 6),
(2, 'Холодильники', 0, 0, 0, 1, NULL, '', '1', 0),
(3, 'Кондиционеры', 0, 0, 0, 1, NULL, '', '1', 0),
(4, 'Обогреватели', 0, 0, 0, 0, '', '', '1', 0),
(5, 'СВЧ-печи', 0, 0, 0, 1, NULL, '', '1', 3),
(6, 'Стиральные машины', 0, 0, 0, 0, NULL, '', '1', 0),
(7, 'Электроника', 0, 0, 0, 0, NULL, '', '', 2),
(8, 'Фотоаппараты', 0, 0, 0, 0, NULL, '', '7', 2),
(20, 'Видеокамеры', 0, 0, 0, 0, NULL, '', '7', 0),
(21, 'DVD-плееры,', 0, 0, 0, 0, '', '', '7', 0),
(22, 'Телевизоры', 0, 0, 0, 0, NULL, '', '7', 0),
(23, 'MP3-плееры', 0, 0, 0, 0, NULL, '', '7', 1),
(24, 'GPS-навигаторы', 0, 0, 0, 0, NULL, '', '7', 0),
(25, 'Телефоны', 0, 0, 0, 0, NULL, '', '', 0),
(26, 'Сотовые телефоны', 0, 0, 0, 0, NULL, '', '25', 0),
(27, 'Гарнитуры', 0, 0, 0, 0, NULL, '', '25', 0),
(28, 'Радиотелефоны', 0, 0, 0, 0, NULL, '', '25', 0),
(29, 'Авто', 0, 0, 0, 0, NULL, '', '', 2),
(30, 'Шины', 0, 0, 0, 0, NULL, '', '29', 0),
(31, 'Диски', 0, 0, 0, 0, NULL, '', '29', 0),
(32, 'Магнитолы', 0, 0, 0, 0, NULL, '', '29', 2),
(33, 'Цифровые фотоаппараты', 0, 0, 0, 0, NULL, '', '8', 0),
(34, 'Продукты, напитки, табак', 0, 0, 0, 0, NULL, '', '', 0),
(35, 'Бакалея', 0, 0, 0, 0, NULL, '', '34', 0),
(36, 'Молочные продукты', 0, 0, 0, 0, NULL, '', '34', 0),
(37, 'Безалкогольные напитки', 0, 0, 0, 0, NULL, '', '34', 0),
(38, 'Пиво и сухой солод', 0, 0, 0, 0, NULL, '', '34', 0),
(39, 'Детское питание', 0, 0, 0, 0, NULL, '', '34', 0),
(40, 'Соусы, специи', 0, 0, 0, 0, NULL, '', '34', 0),
(41, 'Диетическое и лечебное питание', 0, 0, 0, 0, NULL, '', '34', 0),
(42, 'Спортивное питание', 0, 0, 0, 0, '', '', '34', 0),
(43, 'Еда быстрого приготовления', 0, 0, 0, 0, NULL, '', '34', 0),
(44, 'Табачные изделия', 0, 0, 0, 0, NULL, '', '34', 0),
(45, 'Кондитерские изделия', 0, 0, 0, 0, NULL, '', '34', 0),
(46, 'Фрукты и овощи ', 0, 0, 0, 0, NULL, '', '34', 0),
(47, 'Консервированные продукты', 0, 0, 0, 0, NULL, '', '34', 1),
(48, 'Чай, кофе, какао', 0, 0, 0, 0, '', '', '34', 0),
(49, 'Масло растительное', 0, 0, 0, 0, NULL, '', '35', 0),
(50, 'Соль, сода', 0, 0, 0, 0, NULL, '', '35', 0),
(51, 'Сахар', 0, 0, 0, 0, NULL, '', '35', 0),
(52, 'Молоко, сливки', 0, 0, 0, 0, NULL, '', '36', 0),
(53, 'Молочнокислая продукция', 0, 0, 0, 0, NULL, '', '36', 0),
(54, 'Минеральная вода ', 0, 0, 0, 0, NULL, '', '37', 0),
(55, 'Соки', 0, 0, 0, 0, NULL, '', '37', 0),
(56, 'Нектары', 0, 0, 0, 0, NULL, '', '37', 0),
(57, 'Сухой солод', 0, 0, 0, 0, NULL, '', '38', 0),
(58, 'Горчица', 0, 0, 0, 0, NULL, '', '40', 0),
(59, 'Специи', 0, 0, 0, 0, NULL, '', '40', 0),
(60, 'Кетчуп, томатный соус', 0, 0, 0, 0, NULL, '', '40', 0),
(61, 'Бакалея', 0, 0, 0, 0, NULL, '', '41', 0),
(62, 'Чай, кофе, напитки ', 0, 0, 0, 0, NULL, '', '41', 0),
(63, 'Соусы, специи, приправы', 0, 0, 0, 0, NULL, '', '41', 0),
(64, 'Японская еда', 0, 0, 0, 0, NULL, '', '43', 0),
(65, 'Аксессуары', 0, 0, 0, 0, NULL, '', '44', 0),
(66, 'Пепельницы ', 0, 0, 0, 0, NULL, '', '65', 0),
(67, 'Хьюмидоры', 0, 0, 0, 0, NULL, '', '65', 0),
(68, 'Портсигары ', 0, 0, 0, 0, NULL, '', '65', 0),
(69, 'Букеты из конфет ', 0, 0, 0, 0, NULL, '', '45', 0),
(70, 'Мед', 0, 0, 0, 0, NULL, '', '45', 0),
(71, 'Конфеты', 0, 0, 0, 0, NULL, '', '45', 0),
(72, 'Пряники, вафли, печенье', 0, 0, 0, 0, NULL, '', '45', 0),
(73, 'Мармелад, варенье ', 0, 0, 0, 0, NULL, '', '45', 0),
(74, 'Шоколад', 0, 0, 0, 0, NULL, '', '45', 0),
(75, 'Мороженые овощи и овощные смеси', 0, 0, 0, 0, NULL, '', '46', 0),
(76, 'Фрукты', 0, 0, 0, 0, NULL, '', '46', 0),
(77, 'Какао, шоколад', 0, 0, 0, 0, NULL, '', '48', 0),
(78, 'Чай', 0, 0, 0, 0, NULL, '', '48', 0),
(79, 'Кофе', 0, 0, 0, 0, NULL, '', '48', 0),
(81, 'Зеленый', 0, 0, 0, 0, NULL, '', '78', 0),
(82, 'Улунский', 0, 0, 0, 0, NULL, '', '78', 0),
(83, 'Матэ ', 0, 0, 0, 0, NULL, '', '78', 0),
(84, 'Фруктовый ', 0, 0, 0, 0, NULL, '', '78', 0),
(85, 'Зеленый', 0, 0, 0, 0, NULL, '', '78', 0),
(86, 'Улунский', 0, 0, 0, 0, NULL, '', '78', 0),
(87, 'Матэ ', 0, 0, 0, 0, NULL, '', '78', 0),
(88, 'Фруктовый ', 0, 0, 0, 0, NULL, '', '78', 0),
(89, 'Зеленый', 0, 0, 0, 0, NULL, '', '78', 0),
(90, 'Улунский', 0, 0, 0, 0, NULL, '', '78', 0),
(91, 'Травяной, цветочный', 0, 0, 0, 0, NULL, '', '78', 0),
(92, 'Черный', 0, 0, 0, 0, NULL, '', '78', 0),
(93, 'В зернах', 0, 0, 0, 0, NULL, '', '79', 0),
(94, 'Растворимый', 0, 0, 0, 0, NULL, '', '79', 0),
(95, 'Молотый', 0, 0, 0, 0, NULL, '', '79', 0),
(96, 'Меню заведений', 0, 0, 0, 0, NULL, '', '', 0),
(97, 'Завтраки', 0, 0, 0, 0, NULL, '', '96', 0),
(98, 'Бизнес-ланч', 0, 0, 0, 0, NULL, '', '96', 0),
(99, 'Холодные закуски', 0, 0, 0, 0, NULL, '', '96', 0),
(100, 'Салаты', 0, 0, 0, 0, NULL, '', '96', 0),
(101, 'Горячие закуски', 0, 0, 0, 0, NULL, '', '96', 0),
(102, 'Супы', 0, 0, 0, 0, NULL, '', '96', 0),
(103, 'Горячие блюда из мяса', 0, 0, 0, 0, NULL, '', '96', 0),
(104, 'Горячие блюда из рыбы и морепродуктов ', 0, 0, 0, 0, NULL, '', '96', 0),
(105, 'Горячие блюда из птицы', 0, 0, 0, 0, NULL, '', '96', 0),
(106, 'Гарниры', 0, 0, 0, 0, NULL, '', '96', 0),
(107, 'Пасты', 0, 0, 0, 0, NULL, '', '96', 0),
(108, 'Пицца', 0, 0, 0, 0, NULL, '', '96', 1),
(109, 'Десерты', 0, 0, 0, 0, NULL, '', '96', 0),
(110, 'Соусы', 0, 0, 0, 0, NULL, '', '96', 0),
(111, 'Японская', 0, 0, 0, 0, NULL, '', '96', 0),
(112, 'Кофе', 0, 0, 0, 0, NULL, '', '96', 0),
(113, 'Коктейли', 0, 0, 0, 0, NULL, '', '96', 0),
(114, 'Лекарства в аптеках', 0, 0, 0, 0, NULL, '', '', 0),
(115, 'Лекарственные средства', 0, 0, 0, 0, NULL, '', '114', 0),
(116, 'Все для мамы', 0, 0, 0, 0, NULL, '', '114', 0),
(117, 'Биологически активные добавки', 0, 0, 0, 0, NULL, '', '114', 0),
(118, 'Детские товары', 0, 0, 0, 0, NULL, '', '114', 0),
(119, 'Товары медицинского назначения', 0, 0, 0, 0, NULL, '', '114', 0),
(120, 'Здоровое питание', 0, 0, 0, 0, NULL, '', '114', 0),
(121, 'Медицинская техника', 0, 0, 0, 0, NULL, '', '114', 0),
(122, 'Товары для животных', 0, 0, 0, 0, NULL, '', '114', 0),
(123, 'Уход за больными', 0, 0, 0, 0, NULL, '', '114', 0),
(124, 'Интимные товары', 0, 0, 0, 0, NULL, '', '114', 0),
(125, 'Аптечная косметика', 0, 0, 0, 0, NULL, '', '114', 0),
(126, 'Уютный дом', 0, 0, 0, 0, NULL, '', '114', 0),
(127, 'Красота и здоровье', 0, 0, 0, 0, NULL, '', '114', 1),
(128, 'Самоконтроль здоровья', 0, 0, 0, 0, NULL, '', '114', 0),
(129, 'Гигиена женщины', 0, 0, 0, 0, NULL, '', '114', 0),
(130, 'Cамоконтроль беременности и овуляции', 0, 0, 0, 0, NULL, '', '128', 0),
(131, 'Cамоконтроль сахарного диабета', 0, 0, 0, 0, NULL, '', '128', 0),
(132, 'Контроль на наркотики и алкоголь', 0, 0, 0, 0, NULL, '', '128', 0),
(133, 'Репелленты', 0, 0, 0, 0, NULL, '', '126', 0),
(134, 'Интимные товары', 0, 0, 0, 0, NULL, '', '124', 0),
(135, 'Презервативы', 0, 0, 0, 0, NULL, '', '124', 0),
(136, 'Лечебные средства', 0, 0, 0, 0, NULL, '', '122', 0),
(137, 'Принадлежности', 0, 0, 0, 0, NULL, '', '122', 0),
(138, 'Алтайское здоровье', 0, 0, 0, 0, NULL, '', '120', 0),
(139, 'Витаминные и специальные напитки', 0, 0, 0, 0, NULL, '', '120', 0),
(140, 'Натуральные и минеральные воды', 0, 0, 0, 0, NULL, '', '120', 0),
(141, 'Спортивное и специальное питание', 0, 0, 0, 0, NULL, '', '120', 0),
(142, 'Все для кормления ребенка', 0, 0, 0, 0, NULL, '', '118', 0),
(143, 'Все для купания малыша', 0, 0, 0, 0, NULL, '', '118', 0),
(144, 'Все для самых маленьких', 0, 0, 0, 0, NULL, '', '118', 0),
(145, 'Детская косметика', 0, 0, 0, 0, NULL, '', '118', 0),
(146, 'Бандажи и белье для матерей', 0, 0, 0, 0, NULL, '', '116', 0),
(147, 'Все для кормящих мам', 0, 0, 0, 0, NULL, '', '116', 0),
(148, 'Косметика для мам', 0, 0, 0, 0, NULL, '', '116', 0),
(149, 'Антицеллюлитные средства', 0, 0, 0, 0, NULL, '', '127', 0),
(150, 'Ароматерапия', 0, 0, 0, 0, NULL, '', '127', 0),
(151, 'Баня, ванна и сауна', 0, 0, 0, 0, NULL, '', '127', 0),
(152, 'Защита от вредных факторов ', 0, 0, 0, 0, NULL, '', '127', 0),
(153, 'Уход за волосами', 0, 0, 0, 0, NULL, '', '127', 0),
(154, 'Уход за кожей лица', 0, 0, 0, 0, NULL, '', '127', 0),
(155, 'Уход за кожей рук и ног', 0, 0, 0, 0, NULL, '', '127', 0),
(156, 'Уход за кожей тела', 0, 0, 0, 0, NULL, '', '127', 0),
(157, 'Уход за полостью рта', 0, 0, 0, 0, NULL, '', '127', 0),
(158, 'Авен (Avene)', 0, 0, 0, 0, NULL, '', '125', 0),
(159, 'Ахава (Ahava)', 0, 0, 0, 0, NULL, '', '125', 0),
(160, 'Виши (Vichy)', 0, 0, 0, 0, NULL, '', '125', 0),
(161, 'Дюкрэ (Ducray)', 0, 0, 0, 0, NULL, '', '125', 0),
(162, 'Лиерак (Lierac)', 0, 0, 0, 0, NULL, '', '125', 0),
(163, 'Люсэро (Lusero)', 0, 0, 0, 0, NULL, '', '125', 0),
(164, 'Мустела (Mustela)', 0, 0, 0, 0, NULL, '', '125', 0),
(165, 'Рок (Roc)', 0, 0, 0, 0, NULL, '', '125', 0),
(166, 'Топикрем (Topicream)', 0, 0, 0, 0, NULL, '', '125', 0),
(167, 'Урьяж (Uriage)', 0, 0, 0, 0, NULL, '', '125', 0),
(168, 'Чудо Лукошко', 0, 0, 0, 0, NULL, '', '125', 0),
(169, 'Грелки и резиновые изделия', 0, 0, 0, 0, NULL, '', '123', 0),
(170, 'Моче- и калоприемники, мочевые катетеры', 0, 0, 0, 0, NULL, '', '123', 0),
(171, 'Подгузники и простыни для больных', 0, 0, 0, 0, NULL, '', '123', 0),
(172, 'Прокладки урологические', 0, 0, 0, 0, NULL, '', '123', 0),
(173, 'Средства для ухода за кожей больных', 0, 0, 0, 0, NULL, '', '123', 0),
(174, 'Диагностика', 0, 0, 0, 0, NULL, '', '121', 0),
(175, 'Микроклимат', 0, 0, 0, 0, NULL, '', '121', 0),
(176, 'Прочая медицинская техника', 0, 0, 0, 0, NULL, '', '121', 0),
(177, 'Товары для лечения', 0, 0, 0, 0, NULL, '', '121', 0),
(178, 'Тонометры', 0, 0, 0, 0, NULL, '', '121', 0),
(179, 'Одноразовый инструментарий и одежда', 0, 0, 0, 0, NULL, '', '119', 0),
(180, 'Оптика', 0, 0, 0, 0, NULL, '', '119', 0),
(181, 'Ортопедические изделия', 0, 0, 0, 0, NULL, '', '119', 0),
(182, 'Перевязочные средства', 0, 0, 0, 0, NULL, '', '119', 0),
(183, 'Витамины, минералы', 0, 0, 0, 0, NULL, '', '117', 0),
(184, 'Для женщин', 0, 0, 0, 0, NULL, '', '117', 0),
(185, 'Для лечения зависимостей', 0, 0, 0, 0, NULL, '', '117', 0),
(186, 'Для мужчин', 0, 0, 0, 0, NULL, '', '117', 0),
(187, 'Для снижения веса', 0, 0, 0, 0, NULL, '', '117', 0),
(188, 'Общетонизирующие', 0, 0, 0, 0, NULL, '', '117', 0),
(189, 'При заболеваниях', 0, 0, 0, 0, NULL, '', '117', 0),
(190, 'Витамины, микроэлементы', 0, 0, 0, 0, NULL, '', '115', 0),
(191, 'Гомеопатия', 0, 0, 0, 0, NULL, '', '115', 0),
(192, 'Диагностические препараты', 0, 0, 0, 0, NULL, '', '115', 0),
(193, 'Инфузионные растворы и питание', 0, 0, 0, 0, NULL, '', '115', 0),
(194, 'Препараты', 0, 0, 0, 0, NULL, '', '115', 0),
(195, 'Прочие препараты', 0, 0, 0, 0, NULL, '', '115', 0),
(196, 'Целебные травы', 0, 0, 0, 0, NULL, '', '115', 0),
(197, 'Гостиницы и квартиры', 0, 0, 0, 0, NULL, '', '', 4),
(198, 'Квартиры посуточно', 0, 0, 0, 0, NULL, '', '197', 1),
(199, 'Номера', 0, 0, 0, 0, NULL, '', '197', 3),
(200, 'Конференц-залы', 0, 0, 0, 0, NULL, '', '197', 0),
(201, 'Строительство. Ремонт. Дизайн', 0, 0, 0, 0, NULL, '', '', 0),
(202, 'АВТОМОБИЛИ. АВТОТЕХНИКА. АВТОПЕРЕВОЗКИ. ВЫВОЗ МУСОРА. ВЫВОЗ ПРОМЫШЛЕННЫХ, СТРОИТЕЛЬНЫХ И БЫТОВЫХ ОТХОДОВ', 0, 0, 0, 0, NULL, '', '201', 0),
(203, 'АРХИТЕКТУРА. ПРОЕКТИРОВАНИЕ. ДИЗАЙН. СМЕТЫ. ЭКСПЕРТИЗА. ', 0, 0, 0, 0, NULL, '', '201', 0),
(204, 'ЛИФТЫ, ПОДЪЕМНИКИ, ЭКСКАЛАТОРЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(205, 'МЕТАЛЛИЧЕСКИЕ СЕТКИ', 0, 0, 0, 0, NULL, '', '201', 0),
(206, 'МЕТАЛЛОПРОКАТ. МЕТАЛЛООБРАБОТКА', 0, 0, 0, 0, NULL, '', '201', 0),
(207, 'МЕТАЛЛОЛОМ. ПРИЕМ. ВЫНОС', 0, 0, 0, 0, NULL, '', '201', 0),
(208, 'МЕТИЗЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(209, 'НАСОСЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(210, 'НЕДВИЖИМОСТЬ. ФИНАНСЫ. УПРАВЛЕНИЕ НЕДВИЖИМОСТЬЮ', 0, 0, 0, 0, NULL, '', '201', 0),
(211, 'ОБОРУДОВАНИЕ ДЛЯ ПРОИЗВОДСТВА', 0, 0, 0, 0, NULL, '', '201', 0),
(212, 'ОБОРУДОВАНИЕ, СТАНКИ ДЛЯ ОБРАБОТКИ МЕТАЛЛА, ДЕРЕВА, НАТУРАЛЬНЫХ И ИСКУССТВЕННЫХ МАТЕРИАЛОВ', 0, 0, 0, 0, NULL, '', '201', 0),
(213, 'ОГНЕУПОРЫ. ОГНЕЗАЩИТНЫЕ МАТЕРИАЛЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(214, 'ОКНА. ОКОННЫЕ КОНСТРУКЦИИ. СВЕТОПРОЗРАЧНЫЕ КОНСТРУКЦИИ', 0, 0, 0, 0, NULL, '', '201', 0),
(215, 'ОТДЕЛОЧНЫЕ МАТЕРИАЛЫ. ПОЛЫ. РАБОТЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(216, 'ОТДЕЛОЧНЫЕ МАТЕРИАЛЫ. ПОТОЛКИ. РАБОТЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(217, 'ОТДЕЛОЧНЫЕ МАТЕРИАЛЫ. СТЕНЫ. РАБОТЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(218, 'ОТОПЛЕНИЕ. ОБОРУДОВАНИЕ. РАБОТЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(219, 'ПЕЧИ. КАМИНЫ. ПЕЧНЫЕ РАБОТЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(220, 'ПИЛОМАТЕРИАЛЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(221, 'ПЛАСТИКИ. ПЛЁНКА. ПОЛИКАРБОНАТ. ИЗДЕЛИЯ', 0, 0, 0, 0, NULL, '', '201', 0),
(222, 'ПЛИТКА КЕРАМИЧЕСКАЯ. КЕРАМОГРАНИТ. МОЗАИКА. РАБОТЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(223, 'ПЛИТКА ТРОТУАРНАЯ. БРУСЧАТКА. РАБОТЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(224, 'РАЗРУШЕНИЕ ЗДАНИЙ И СООРУЖЕНИЙ. СТРОЙМАТЕРИАЛЫ Б/У – ПРОДАЖА.', 0, 0, 0, 0, NULL, '', '201', 0),
(225, 'РЕДУКТОРЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(226, 'САНТЕХНИКА. САНТЕХМОНТАЖ', 0, 0, 0, 0, NULL, '', '201', 0),
(227, 'СВАРКА. ОБОРУДОВАНИЕ И РАСХОДНЫЕ МАТЕРИАЛЫ.', 0, 0, 0, 0, NULL, '', '201', 0),
(228, 'СИСТЕМЫ БЕЗОПАСНОСТИ', 0, 0, 0, 0, NULL, '', '201', 0),
(229, 'СИСТЕМЫ ОГРАНИЧЕНИЯ ДОСТУПА', 0, 0, 0, 0, NULL, '', '201', 0),
(230, 'СИСТЕМЫ ПОЖАРНОЙ БЕЗОПАСНОСТИ И ПОЖАРОТУШЕНИЯ', 0, 0, 0, 0, NULL, '', '201', 0),
(231, 'СКЛАДСКОЕ ОБОРУДОВАНИЕ. СКЛАДСКАЯ ТЕХНИКА. ЛОГИСТИКА', 0, 0, 0, 0, NULL, '', '201', 0),
(232, 'СПЕЦИАЛЬНЫЕ РАБОТЫ. МОСТЫ. ТОННЕЛИ.', 0, 0, 0, 0, NULL, '', '201', 0),
(233, 'СПЕЦОДЕЖДА. СРЕДСТВА ЗАЩИТЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(234, 'СТЕКЛО. СТЕКЛОИЗДЕЛИЯ', 0, 0, 0, 0, NULL, '', '201', 0),
(235, 'СТЕНОВЫЕ МАТЕРИАЛЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(236, 'СТРОИТЕЛЬНОЕ ОБОРУДОВАНИЕ. ПРОДАЖА. АРЕНДА. СЕРВИС', 0, 0, 0, 0, NULL, '', '201', 0),
(237, 'СТРОИТЕЛЬНО-ДОРОЖНАЯ И СПЕЦИАЛЬНАЯ ТЕХНИКА. ПРОДАЖА. АРЕНДА. СЕРВИС', 0, 0, 0, 0, NULL, '', '201', 0),
(238, 'СТРОИТЕЛЬСТВО ГИДРОТЕХНИЧЕСКИХ СООРУЖЕНИЙ', 0, 0, 0, 0, NULL, '', '201', 0),
(239, 'СТРОИТЕЛЬСТВО ДОРОГ. СТРОИТЕЛЬСТВО ПУТЕЙ СООБЩЕНИЯ', 0, 0, 0, 0, NULL, '', '201', 0),
(240, 'СТРОИТЕЛЬСТВО ЗДАНИЙ, СООРУЖЕНИЙ, ЖИЛЬЯ', 0, 0, 0, 0, NULL, '', '201', 0),
(241, 'СТРОИТЕЛЬНО- РЕМОНТНЫЕ И ОТДЕЛОЧНЫЕ РАБОТЫ ЗДАНИЙ, СООРУЖЕНИЙ, ЖИЛЬЯ', 0, 0, 0, 0, NULL, '', '201', 0),
(242, 'СУХИЕ СТРОИТЕЛЬНЫЕ СМЕСИ', 0, 0, 0, 0, NULL, '', '201', 0),
(243, 'СЫРЬЁ ДЛЯ ПРОИЗВОДСТВА СТРОИТЕЛЬНЫХ МАТЕРИАЛОВ', 0, 0, 0, 0, NULL, '', '201', 0),
(244, 'ПОЛИФОНИЯ. ТЕЛЕВИДЕНИЕ. УМНЫЙ ДОМ', 0, 0, 0, 0, NULL, '', '201', 0),
(245, 'УСАДЬБА. ДАЧА. САД. ОГОРОД', 0, 0, 0, 0, NULL, '', '201', 0),
(246, 'ФАСАДЫ', 0, 0, 0, 0, NULL, '', '201', 0),
(247, 'ФУНДАМЕНТЫ. НУЛЕВОЙ ЦИКЛ', 0, 0, 0, 0, NULL, '', '201', 0),
(248, 'ХОЗЯЙСТВЕННЫЕ ТОВАРЫ. ХОЗИНВЕНТАРЬ', 0, 0, 0, 0, NULL, '', '201', 0),
(249, 'ЦЕМЕНТ. ЩЕБЕНЬ. ПЕСОК', 0, 0, 0, 0, NULL, '', '201', 0),
(250, 'ЭЛЕКТРОДВИГАТЕЛИ', 0, 0, 0, 0, NULL, '', '201', 0),
(251, 'ЭЛЕКТРОМОНТАЖ. ЭЛЕКТРОЭНЕРГЕТИКА. МАГИСТРАЛЬНЫЕ СЕТИ', 0, 0, 0, 0, NULL, '', '201', 0),
(252, 'ЭЛЕКТРООСВЕЩЕНИЕ. СВЕТОТЕХНИКА', 0, 0, 0, 0, NULL, '', '201', 0),
(253, 'ЭНЕРГЕТИКА АЛЬТЕРНАТИВНАЯ', 0, 0, 0, 0, NULL, '', '201', 0),
(254, 'Мебель', 0, 0, 0, 0, NULL, '', '', 0),
(255, 'ДВЕРИ. МЕЖКОМНАТНЫЕ ПЕРЕГОРОДКИ', 0, 0, 0, 0, NULL, '', '254', 1),
(256, 'ЖАЛЮЗИ. КАРНИЗЫ. ШТОРЫ. КОВРЫ. ТЕКСТИЛЬ', 0, 0, 0, 0, NULL, '', '254', 0),
(257, 'КАМЕНЬ НАТУРАЛЬНЫЙ И ИСКУССТВЕННЫЙ', 0, 0, 0, 0, NULL, '', '254', 0),
(258, 'КУЗНЕЧНЫЕ, СВАРНЫЕ ИЗДЕЛИЯ. ЛИТЬЁ. КОЗЫРЬКИ . НАВЕСЫ', 0, 0, 0, 0, NULL, '', '254', 0),
(259, 'ЛАКОКРАСОЧНЫЕ МАТЕРИАЛЫ. СТРОИТЕЛЬНАЯ ХИМИЯ. РАБОТЫ', 0, 0, 0, 0, NULL, '', '254', 0),
(260, 'ЛЕСТНИЦЫ. ПЕРИЛА. ОГРАЖДЕНИЯ ДОМОВЫЕ', 0, 0, 0, 0, NULL, '', '254', 0),
(261, 'МЕБЕЛЬ ДЛЯ ДОМА. ИНТЕРЬЕРНО-МЕБЕЛЬНЫЕ АКСЕССУАРЫ. МАТЕРИАЛЫ МЕБЕЛЬНОГО НАЗНАЧЕНИЯ', 0, 0, 0, 0, NULL, '', '254', 0),
(262, 'МЕБЕЛЬ КУХОННАЯ. АКСЕССУАРЫ. ПОСУДА. БЫТОВАЯ ТЕХНИКА', 0, 0, 0, 0, NULL, '', '254', 0),
(263, 'ОТДЕЛОЧНЫЕ МАТЕРИАЛЫ. ПОЛЫ. РАБОТЫ', 0, 0, 0, 0, NULL, '', '254', 0),
(264, 'ОТДЕЛОЧНЫЕ МАТЕРИАЛЫ. ПОТОЛКИ. РАБОТЫ', 0, 0, 0, 0, NULL, '', '254', 0),
(265, 'ОТДЕЛОЧНЫЕ МАТЕРИАЛЫ. СТЕНЫ. РАБОТЫ', 0, 0, 0, 0, NULL, '', '254', 0),
(266, 'ПЕЧИ. КАМИНЫ. ПЕЧНЫЕ РАБОТЫ', 0, 0, 0, 0, NULL, '', '254', 0),
(267, 'ПЛИТКА КЕРАМИЧЕСКАЯ. КЕРАМОГРАНИТ. МОЗАИКА. РАБОТЫ', 0, 0, 0, 0, NULL, '', '254', 0),
(268, 'САНТЕХНИКА. САНТЕХМОНТАЖ', 0, 0, 0, 0, NULL, '', '254', 0),
(269, 'ТЕЛЕФОНИЯ. ТЕЛЕВИДЕНИЕ. УМНЫЙ ДОМ. ТЕХНИКА ДЛЯ ДОМА И ОФИСА', 0, 0, 0, 0, NULL, '', '254', 0),
(270, 'ТОРГОВОЕ И ОФИСНОЕ ОБОРУДОВАНИЕ. МЕБЕЛЬ. СЕЙФЫ', 0, 0, 0, 0, NULL, '', '254', 0),
(271, 'ЭЛЕКТРООСВЕЩЕНИЕ. СВЕТОТЕХНИКА', 0, 0, 0, 0, NULL, '', '254', 0),
(272, 'Банкоматы', 0, 0, 0, 0, NULL, '', '', 0),
(273, 'Недвижимость', 0, 0, 0, 0, NULL, '', '', 16),
(274, 'Новостройки', 0, 0, 0, 0, NULL, '', '273', 0),
(275, 'Коттеджные поселки', 0, 0, 0, 0, NULL, '', '273', 16)";

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
(1, 0, 1, 1, 1, 'Стандарт', 1, 1, 1, 1, 2, 1, 3, 4, 50),
(4, 1, 0, 1, 1, 'Премиум', 1, 1, 0, 1, 2, 1, 3, 4, 122)";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_firm_srcheck`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_firm_srcheck` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_firm_srcheck` (`id`, `name`, `alt_name`) VALUES
(1, 'до 150р.', ''),
(2, '150р.-400р.', ''),
(3, '400р.-800р.', ''),
(4, '800р.-1500р.', '')";

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
(1, 0, 'Новичок', '1')";

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
(1, 'Образование', '', 11),
(2, 'Политика', '', 0),
(3, 'Реклама', '', 0),
(4, 'Финансы', '1', 1),
(5, 'Города', '1', 10),
(6, 'Интернет провайдеры', '', 0),
(7, 'Магазины', '', 0),
(8, 'Религия', '', 0),
(9, 'Чаты', '2', 0),
(10, 'Медицина', '2', 0),
(11, 'Справочники и каталоги', '', 0),
(12, 'Организации', '', 0),
(13, 'Программы', '', 0),
(14, 'Дизайн студии', '', 0),
(15, 'Спорт', '', 0),
(16, 'Путешествия', '', 0),
(17, 'Интернет', '', 0),
(18, 'СМИ', '', 0),
(19, 'Игры', '18', 0),
(20, 'Форумы', '', 0),
(21, 'Гос. учреждения', '', 0),
(22, 'Дом. страницы', '', 0),
(23, 'Культура', '', 0),
(24, 'Музыка', '', 0),
(25, 'Доставка еды', '0', 0)";

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
(2, 'http://feeds.feedburner.com/afisha_msk_cinema', 'Афиша кино', 1, 1, 1, 1, 0, '<table class=\"job_table\">{get}</table>', 2, '', 0, '1372934580')";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_rss_category` (`id`, `osn`, `title`, `kanal`) VALUES
(1, 0, 'Администратор', 1)";

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
(5, 'http://rabota.mail.ru/rss/searchvacancy.xml?orderBy=2&itemsOnPage=100&areaId=3&vacancyNameField=true&professionalAreaId=2&compensationCurrencyCode=RUR&searchPeriod=30', 'Биржа труда - Екатеринбург - Бухгалтерия', 1, 1, 1, 1, 1, '<html>{get}</html>', 127, '', 3334, ''),
(3, 'http://rabota.mail.ru/rss/searchvacancy.xml?orderBy=2&itemsOnPage=100&areaId=3&vacancyNameField=true&professionalAreaId=1&compensationCurrencyCode=RUR&searchPeriod=30', 'Биржа труда - Екатеринбург', 1, 1, 1, 1, 0, '<table class=\"job_table\">{get}</table>', 127, '', 3338, '1322034046'),
(6, 'http://rabota.mail.ru/rss/searchvacancy.xml?orderBy=2&itemsOnPage=100&areaId=3&vacancyNameField=true&professionalAreaId=3&compensationCurrencyCode=RUR&searchPeriod=30', 'Биржа труда - Екатеринбург - Маркетинг', 1, 1, 1, 1, 1, '<html>{get}</html>', 127, '', 3341, ''),
(7, 'http://rabota.mail.ru/rss/searchvacancy.xml?orderBy=2&itemsOnPage=100&areaId=3&vacancyNameField=true&professionalAreaId=5&compensationCurrencyCode=RUR&searchPeriod=30', 'Биржа труда - Екатеринбург - БанкиИнвестиции', 1, 1, 1, 1, 1, '<html>{get}</html>', 127, '', 1005, ''),
(8, 'http://rabota.yandex.ru/rss.xml?rid=52&amp;currency=RUR&amp;text=&amp;job_industry=275', 'Биржа труда - Екатеринбург - Временная работа', 1, 1, 1, 1, 1, '<td class=\"content\">{get}</td>', 127, '', 3354, '1321905600')";

$tableSchema[] = "DROP TABLE IF EXISTS `".PREFIX."_style`";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `valid` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(1, '2-Step/British Garage (Speed Garage)', 'Этот стиль был создан на базе убыстренных элементов сладкозвучного garage techno плюс резкие вокальные партии, постоянные повторы и скретч в сочетании с судорожными ритмами drum''n''bass. British Garage ворвался на клубные сцены Лондона в 1996 г., мгновенно завоевав статус хорошего способа расслабиться в выходные, вытесняя направление jungle/drum''n''bass, как перченый танцевальный стиль конца 90-х. В разные этапы своего развития этот стиль был известен как speed garage, underground garage и 2-step. Стиль попал под влияние американских музыкантов, таких как Todd Edwards, Armand Van Helden и Romanthony. Стиль развивался с помощью таких команд, как Tuff Jam, Dream Team и RIP, - они записывали значительные клубные хиты, некоторые их которых затем перешли поп-чарты. К 1998 стиль, который ранее был известен как speed garage, трансформировался в новое событие на музыкально сцене. Теперь он отличался склонностью к сладкоголосым попсовым звукам R&B и активно использовал breakbeats. Среди множества отличных музыкантов (новички MJ Cole, Zed Bias, Wookie и Sunship, а также зарекомендовавшие себя фигуры, такие как Tuff Jam, Dream Team и Artful Dodger) и крупных звукозаписывающие компании (Locked On, Nice ''N'' Ripe, Quench, Grand Theft Audio, Naughty), - стиль оказался удивительно устойчивы к новым веяниям в профессиональном dance. Даже в то время, такие хиты как \"Destiny\" (Dem 2) и \"Movin'' Too Fast\" (Artful Dodger) занимали верхние строки в хит-парадах, а сборники продавались большими тиражами, десятки пиратских радиостанций продолжали развивать резкую и тяжелую концепцию стиля.'),
(2, 'IDM', 'Сложный термин, предназначенный для обозначения электронной музыки 90-х годов, которая может одинаково удобно использоваться на танцполе и в домашних условиях. Со временем стиль IDM (Intelligent Dance Music) в значительной степени приобрел негативную известность среди танцевальных музыкантов и фанатов, которыми руководил только один вопрос, играют ли они бессмысленную танцевальную музыку или нет. Зародившись в конце 80-х годов, этот звук вырос из сочетания тяжелого dance, раздававшегося в основном с рейверских вечеринок и крупномасштабных клубных событий, плюс downtempo.Такие DJs, как Mixmaster Morris и Dr. Alex Paterson соединяли Chicago house, мягкий синтезированный pop/new wave с ambient, поощряя появление новой волны музыкантов, вдохновляемых большим разнообразием музыкальных источников. (В эти годы многие DJs и музыканта также протестовали против растущей чартовой ориентации британской танцевальной музыки на примере новых хитов \"Pump Up the Jam\" от команды Technotronic и \"Sesame''s Treat\" от Smart E''s.) Звукозаписывающая компания Sheffield''s Warp Records работала с лучшими представителями этого жанра на самом деле продуктивный сборник от студии Warp под названием Artificial Intelligence познакомил слушателей по всему миру с пол дюжиной центровых исполнителей в этом стиле: Aphex Twin, the Orb, Plastikman, Autechre, Black Dog Productions и B12. Другие крупные звукозаписывающие компании Rising High, GPR, R&S, Rephlex, Fat Cat, Astralwerks также делали релизы качественного IDM, хотя к середине 90-х годов большинство музыки в стиле electronica, записываемой для слушателей, подтолкнуло студии к дальнейшим экспериментам и битовой ориентации. При отсутствии центральной, коммерческой сцены, Северная Америка стала самой благодатной и гостеприимной почвой для IDM, и к концу 90-х годов десятки солидных студий открыли свои двери для работы с музыкантами в этом стиле, включая Beat, Isophlux, Suction, Schematic и Cytrax. Несмотря на частые попытки переименовать стиль (студия Warp предлагала термин \"electronic listening music\" , а  Aphex Twin остановился на \"braindance\"), стиль IDM оставался реальным способом для фанатов высказать свои обычно сбивчивые предпочтения.\r\n'),
(3, 'Illbient', 'Центром развития этого стиля является New York City ( в особенности Brooklyn). Стиль illbient это четко выраженная и сознательно создаваемая городская форма электронной музыки, стремящаяся выразить культурное разнообразие и серый упадок всего окружающего. Поэтому переигранные DJ Spooky (музыкант, определяющий этот стиль), электронные попурри в стиле Illbient в большинстве берут начало из музыки ambient, но могут включать ( в основном) dub, hip-hop и drum''n''bass, плюс иногда этническую музыку, которая может смешиваться со всеми музыкальными стилями и направлениями. Соответствуя настроениям, распространенным в среде развития этого стиля, illbient может быть мрачным и немного зловещим или непредсказуемым  и погруженным в шум. Но почти всегда сохраняется его размеренный ритм и минорные вибрации. Залы и клубы для выступлений в стиле illbient часто выбираются с условием, что они должны хорошо передавать атмосферу грязных городских задворок, что говорит об основной концептуальной (и интеллектуальной) природе музыки. Музыкальная арена Brooklyn  также отмечена некоторым ощущением совместного общения и общей жизни, что приводит к частым контактам, как личного, так и коллективного характера. Звукозаписывающие компании The Asphodel и WordSound занимались реализацией большинства проектов illbient, первая из них записала отличный сборник под названием Incursions in Illbient, где собраны композиции DJ Spooky, We, Byzar и Sub Dub. Среди других лидеров illbient можно назвать Tipsy, Spectre, Rob Swift и Badawi.\r\n'),
(4, 'Indie Electronic', 'Мета-стиль\r\n'),
(5, 'Industrial Drum''n''Bass', 'Вответ на растущую зацикленность индустриальной музыки на элементах heavy metal, некоторые музыканты начали совмещать индустриальный shock-terrorism с брейкбитовым программированием таких стилей, как jungle и techno. В соответствии с тенденциями индустриальных лидеров прошлого команд Front 242, Cabaret Voltaire, Skinny Puppy которые продолжали развивать электронную танцевальную музыку, эти групп оставались впереди всего индустриального движения, постоянно экспериментируя со структурой композиций.\r\n'),
(6, 'Jazz-House', 'Смешение ритмов house и jazz в стилевую концепцию, которую трудно определить, скорее всего потому, что так много музыкантов подверглись влиянию jazz, что они несомненно охватывают любой альбом в стиле house, когда-либо выпущенный в свет. Методы работы многих Jazz-House музыкантов значительно отличаются, - от простого перевода джазовой атмосферы в электронное состояние (Swayzak, Herbert, Kevin Yost, Jazzanova) до попыток синтезировать электронику с джазовым соло (Innerzone Orchestra, St. Germain, Spacetime Continuum, As One). Jazz-House - это способ определить исполнителя, попавшего между полярными противоположностями, царящими в мире музыки house/techno и ambient/интеллектуальная электронная музыка. Larry Heard, первый великий house музыкант, был также первым, кто добавил в свои композиции джазовые гармонии звуков и атмосферу. Частично, благодаря его постоянному влиянию, десятки музыкантов в поисках вдохновения стали оглядываться назад на таких джазовых мастеров, как Miles Davis, Herbie Hancock и Lonnie Liston Smith.  Можно сказать, что кратким экскурсом в мировое развитие направления jazz-house явилась британская студия Nuphonic Records, где записывались нью-йоркские (Blaze, Ten City, Joe Claussell), чикагские (Free Chicago Movement, Roy Davis, Jr.) и японские музыканты (Natural Calamity), а также некоторые британцы (Black Jazz Chronicles, Faze Action, Soul Ascendants, Idjut Boys).\r\n'),
(7, 'Jazz-Rap', 'Стиль Jazz-Rap был попыткой соединить вместе афро-американскую музыку прошлых десятилетий с новой доминирующей формой настоящего, что позволило бы отдать дань и вселить новую жизнь в первый элемент этого фьюжн, а также расширить горизонты второго. Тогда как ритмы jazz-rap были полностью заимствованы из hip-hop, то сэмплы и звуковая текстура в основном пришли из таких направлений музыки, как cool jazz, soul-jazz и hard bop. Этот стиль был самым крутым и знаменитым среди других направлений hip-hop, а многие исполнители демонстрировали афро-центристское политическое сознание, добавляя этому стилю историческую достоверность. Принимая во внимание интеллектуальный уклон этого направления, не удивительно, что jazz-rap никогда не стал фаворитом уличных тусовок, но тогда об этом никто и не думал. Сами представитель Jazz-rap называли себя сторонниками более позитивной альтернативы движению hardcore/gangsta, потеснившему лидирующую позицию rap в начале 90-х. Они также стемились распространить hip-hop среди слушателей, которые не могут принять или понять растущую агрессию городской музыкальной культуры. Таким образом, jazz-rap нашел основую часть своих поклонников в студенческих общежитиях, а также поддерживался целым рядом критиков и фанатами white alternative rock. Команда Native Tongues (Afrika Bambaataa) этот незакомплексованный нью-йоркский коллектив, состоящий из афро-американских rap групп стал мощной силой, представляющей стиль jazz-rap, включая такие группы, как A Tribe Called Quest, De La Soul и the Jungle Brothers. Также известными музыкантами, начавшими свое творчество, раньше были Digable Planets и Gang Starr. В середине конце 90-х годов, когда alternative rap стал разбиваться на большое количесвто подстилей, jazz-rap не часто становился элементом нового звучания, однако, команда the Roots часто вставляла его в живые инструментальные hip-hop композиции.\r\n'),
(8, 'Jungle/Drum ''N Bass', 'Распространенный почти полностью по Великобритании, стиль Jungle (также известный под названием drum''n''bass) это переделанный hardcore techno, появившийся в начале 90-х годов. Jungle это самый ритмичный комплекс всех известных форм techno, основанный на базе очень быстрых polyrhythms и breakbeats. Обычно, это полностью инструментальная музыка она считается самой тяжелой среди всего hardcore techno и состоит только из быстрой партии барабанов и глубокого баса. Как подразумевает название стиля, jungle имеет более очевидное влияние со стороны регги (reggae), dub и R&B, чем большинство направлений hardcore. Поэтому некоторые критики заявили, что эта музыка стала звучанием чернокожих techno музыкантов и DJs, которые возвратили себе эту музыку, отняв ее у белых музыкантов и DJs, доминировавших в музыке hardcore. Тем не менее, jungle никогда не сбавляет обороты, чтобы стать ди-джейским материалом он просто проносится мимо. Как большинство techno жанров, jungle - это прежде всего сингловый жанр, предназначенный для небольших аудиторий, хотя большой успех Goldie и его дебютный альбом Timeless в 1995г. предполагали участие большого количества фанатов и огромные музыкальные возможности, по сравнению с другими формами techno. Десятки уважаемых музыкантов последовали этим путем, создавая сочетание breakbeats с элементами jazz, музыкой из кинофильмов, ambient и trip-hop.\r\n'),
(9, 'Latin Rap', 'Стиль Latin Rap относится к hip-hop и rap, переработанным латино-американскими музыкантами. Они могут читать rap по-английски или по-испански, а в музыке часто присутствует влияние знаменитых латинских ритмов.'),
(10, 'Left-field House', 'Создатели музыки Left-field house имеют тенденцию игнорировать по крайней мере одну из главных тем традиционного дип хауса (deep house), отказываясь или от 4/4 ритмичной структуры, или от ручной перкуссии, или акценте на бите. У стиля Left-field house нет определенного саунда, который как-либо четко символизирует его. Это может быть абстрактно и грязно как у Theo Parrish, продукция которого часто поддерживает низкий BPMs и сэмплы от неразборчивой джазовой партии, все время сохраняя явный 4/4 ритм. Этот стиль может происходить из House, из R&B и влияния итальянской дискотеки, подобно дуэту Metro Area, которые регулярно полностью обходят неустанный темп 4/4. Или этот стиль может быть одинаково экспериментально и современно подобно Herbert, концепции и методологии которого иногда затемняют его достижения (он экспериментирует со звуками-источниками, исходящие от кухонной посуды до биологических функций организмов).'),
(11, 'Lounge', 'Lounge музыка, это спокойная фоновая музыка, которая может быть основана на многих стилях, но главный ее критерий, это атмосферность и низкий BPM, придающие расслабленную и спокойную обстановку. Lounge музыка звучит практически во всех модных кафе и DJ-барах.\r\n'),
(12, 'Microhouse', 'Microhouse, упомянутый DJ Philip Sherburne в 2001 году а статье The Wire, был термином, коорый имел обыкновение категоризировать в значительной степени немецких продюсеров, подход у которых к хаус музыке такой же тонкий и обширный, как и у deep house продюсеров, полагающихся на anthemic hooks и решительный вокал. Но даже в этом случае, создание microhouse нашло точку между deep house и minimal techno. Строгая жесткость последнего была отсеяна, в то время как чувственные и неистовые свойства первого (deep house) были охвачены; Если взглянуть на сценарий, microhouse взял девиз от минимального techno, \"меньше - больше доктрины, постоянно оставляя чрезмерное украшение дип хауса. Акцент имеет тенденцию падать на мягкие удары барабана и сопровождающие его слабые удары \"тарелки\", одновременно со синтетическими струнами и мечтательными тонами клавиатуры. В конце 90-ых и в начале 2000-ых, неожиданно возникли несколько маленьких лейблов, процветающих на этом стиле. Справедливый процент самого волнующего microhouse произвели лейблы, подобно Playhouse (Isolйe, Losoul), Kompakt (Sascha Funke, M. Mayer) и Klang Elektronik (Farben). Другие лейблы - Force Tracks (Luomo, MRI), Perlon (Ricardo Villalobos, Pantytec) и  Trapez (Akufen, M.I.A.).\r\n'),
(13, 'Minimal Techno', 'Когда house и techno впервые появились в мировой музыкальной тусовке в середине 80-х годов, запись альбомов была сведена к минимуму. По мере дальнейшего развития искусства сэмплирования и программирования, музыка становилась более многослойной с профессиональным звуком для некоторых это стало движением вперед, для других - ненужным сочетанием стилей. В ответ на растущие объему музыкального производстваp лидеры Minimalist Techno отказались практически ото всего за исключением выделенных барабанных программ и синтезаторных или секвенсорных партий. Такие детройтские музыканты, как Jeff Mills и Plastikman возглавили направление, а позднее прибавились Surgeon, Oliver Ho и Stewart Walker, также привнесшие с собой новые веения.\r\n'),
(14, 'Neo-Electro', 'В1995г. Британские клубы на несколько месяцев буквально взорвались космическими звуками и выступлениями, похожими на сходки роботов и металлистов. Так ознаменовалось возвращение американского движения electro (первая волна прокатилась в начале 80-х). Хотя большое внимание уделили мастерам старой школы, таким как Afrika Bambaataa, the Egyptian Lover, Newcleus, но, тем не менее, большое влияние на новое восхождение стиля electro оказали последние звуковые находки. Музыканты из Детройта, такие как Drexciya, Underground Resistance и Ectomorph начали оглядываться на electro, а объемные композиции команды Drexciya с пластинки 1994г.  пользовались большой популярностью на другой стороне Атлантики. В Британии звукозаписывающая компания Clear Records возглавила чарт возвратившихся лидеров синглами от таких команд, как Jedi Knights, Tusken Raiders, Plaid и Gescom (почти все они выступали под псевдонимами, и являются бывшими участниками популярных танцевальных групп, включая Global Communication и Autechre). Хотя возрождение electro в качестве нового тренда британских клубов долго не продлилось, качественные записи продолжали появляться (особенно на студии Clear), а также на других ведущих студиях, таких как Skam, Musik Aus Strom и Dot. Все они пытались выйти за границы звука и создать новую интеллектуальную музыку с тяжелым налетом старого electro.'),
(15, 'New Jack Swing', 'New Jack Swing появился в конце 80-х годов, когда музыканты в стиле urban contemporary soul стали приобщать к своему творчеству hip-hop ритмы, сэмплы, и методы студийной работы. Некоторые композиции просто включали hip-hop бит, другие рэповые вставки и подпевки, но, в общем, результат был один более жесткий, уличный звук, однородно совмещающий в себе мелодичное качество soul и ритмы rap. Этот этап проложил дорогу к появлению музыки soul в 90-е годы, когда различия между rap и R&B практически стерлись.\r\n'),
(16, 'Newbeat', 'Этот стиль стал феноменально короткой вспышкой (даже принимая во внимание сиюминутность современной музыки). Newbeat появился в конце 80-х годов, как некая производная в среднем темпе от направления acid house. На его развитие оказали влияние, как Detroit techno, так Eurodance. Центром развития newbeat стала Бельгия, где его развитием занимались такие круные звукозаписывающие компании как R&S и Antler-Subway родина гимна, воспевающего newbeat \"I Sit on Acid\" (Я подсел на кислоту), сочиненный Lords of Acid всё это стало неотъемлемыми символами стиля, который был синтезирован из кислотной музыки, но при этом оставался приближенным к танцевальной культуре. Нашумевший успех команды the KLF в 1990-91 гг. удержал этот стиль на плаву еще некоторое время. Но после их ухода из музыкальной индустрии, этот стиль стали быстро забывать. Хотя музыканты из Antler-Subway и Lords of Acid позднее стали заниматься пародированием самих себя и кислоты в том числе, но R&S завоевала признание и уважение поклонников dance, играя в основном trance и ambient techno.'),
(17, 'Night Driving', 'Мета стиль'),
(18, 'Nu Breaks', 'Тяжелый танцевальный стиль получивший развитие в конце 90-х, благодаря смешению techno и drum''n''bass, а также некоторых элементов раннего rave. Nu Breaks возглавили такие музыканты и DJs как британцы Adam Freeland, Dylan Rhymes, Beber, Freq Nasty и Rennie Pilgrem, а также некоторые американцы, как, например, BT. Из стиля drum''n''bass они позаимствовали two-step breakbeats и жуткие эффекты, из techno мягкое течение музыки и механические ударные, а из раннего rave/hardcore 90-х годов - некоторые колокольчики и свист ( в прямом и переносном смысле), которые не были слышны уже долгие годы. Freeland один из самых известных исполнителей nu breaks (особенно после того, как большинство музыкантов сконцентрировались на выпуске синглов), после миксов в стиле rock, таких как Coastal Breaks и Tectonics завоевали успех и танцевальных фанатов во всем мире.\r\n'),
(19, 'Obscuro', 'Obscuro - это неопределенная категория, охватывающая все сверхъестественные, загадочные, непонятные и не поддающиеся классификации формы музыки, о которых вы никогда и не мечтали. Или выражаясь по-другому, это музыка, идиотские записи которой передавались друг другу со слова ты должен это услышать. Записи в стиле Obscuro могут вызвать удивление или улыбку один-два раза; они могут показаться странными, что переварить их очень трудно, и не важно, сколько раз вы будете их слушать. Эту музыку можно отнести к неудачным экспериментам в коммерчески выгодных музыкальных направлениях или к абсолютно некоммерческим проектам. В этом стиле чрезвычайно редко встречаются записи, которые стали легендартными в среде меломанов, частично вследствие того, что очень небольшое число людей слушали эту музыку. Стиль obscuro чаще концентрируется в той среде, где пытаются расширить границы студийных технологий или экспериментировать с offbeat инструментализацией и смешением стилей. Особенно это касается направлений exotica и space-age pop (со стороны легкости для прослушивания), а также таких стилей как psychedelia, progressive rock и experimental (читай: avant-garde) rock. Хотя записи obscuro по определению являются неразбрчивыми и трудными для понимания (особенно для полного), то сборники от Re/Search под названиями Incredibly Strange Music, Vols. 1 and 2 (и сопровождающие их книги) пользовались спросом, как и большинство повторных выпусков пластинок на студии Arf! Arf!.\r\n'),
(20, 'Old School Rap', 'Old School Rap - этот стиль используется очень быстрыми rap музыкантами, которые были выходцами из New York City в конце 70-х начале 80-х годов. Old school (старая школа) легко отличается от остальных направлений своим относительно упрощенным рэпом большинство строк занимают примерно одинаковое время, а речевые ритмы редко изменяют направление по ходу битов композиции. Модуляция (понижение голоса) обычно точно попадает на бит, а когда такого не случается, то это не надолго, - звук возвращается в изначальную палитру для быстрого консонанса (согласования). Основной акцент делался не на лирическую сторону музыки, а просто на старые добрые времена это было вдалеке от социально озабоченой команды Grandmaster Flash, которая значительно расширила горизонты rap музыки. Большинство материала в стиле old school rap имело веселый и шутливый привкус городских вечеринок и дискотек, где он зарождался. Придерживавшийся хорошего медленного темпа, стиль old school rap очевидно имел отличную почву для развития женского рэпа, однако никто не смог достичь большего успеха, чем Grandmaster Flash & Furious Five или Sugarhill Gang. Некоторые композиции old school игрались в треках disco или funk, а другие были разбавлены синтензаторным сопровождением (последний тип музыки, с rap или без него, был известен под названием electro). История записанных альбомов в стиле Old school rap начинается в 1979 г. С появлением двух синглов от Fatback \"King Tim III\" и Sugarhill Gang \"Rapper''s Delight,\" хотя это движение развивалось до этого практически 10 лет. Студия Sugarhill Records быстро стала центром стиля old school rap и доминировала на рынке звукозаписи до того времени, пока в 1983-84 годах Run-D.M.C. не внес свою лепту в развитие техники звучания и не начал развивать направление hardcore urban. Их звук и стиль вскоре полностью захватил rap пространство, превратив клубную ориентацию old school и funk наследие 70-х в нечто старомодное. При сравнении с усложненными ритмами и рифмовками современного modern-day rap или даже с hip-hop (который вышел в свет менее чем через 10 лет после \"Rapper''s Delight\") направление old school rap может казаться устаревшим и немного вялым. Однако лучшие треки old school продолжают жить, как самая лучшая музыка для вечеринок вне зависимости от новой эры, в которой мы живем. Это удивительно, принимая во внимание то ативное развитие музыкальной культуры.\r\n'),
(21, 'Party Rap', 'Party Rap - басовый, шумный hip-hop, единственной задачей которого является поддержание ритма. Сбивчивые, непоследовательные тексты, без политического подтекста, присущего направлению hardcore rap, плюс небольшая доля мастерства из old school rap. Вместо всего этого, вы получаете только музыку, где доминируют басы и барабаны. Это направление тесно связано с музыкой Miami bass, но обычно в композициях можно встретить одну единственную вокальную изюминку как, например, \"Da Dip\" или хор в \"Rump Shaker\" которая делает эту запись запоминающейся.'),
(22, 'Political Rap', 'Пытаясь двигаться вперед, оставляя позади атмосферу вечеринок в стиле old-school rap, а также движимые желанием забыть разочарования, связанные с inner-city blues (городской блюз в версии 80-х годов), - несколько hip-hop команд решили смешать живой ритм с политической доктриной для создания нового rap стиля. Такие команды, как Last Poets и Gil Scott-Heron, Public Enemy, вдохновляемые в 70-е годы политическими деятелями страны, стали лучшими музыкантами среди political rap групп. Лидер этого направления Chuck D делал фьюжн ритмов лучше всех рэперов, продолжая обвинять правительство (в композициях \"Black Steel in the Hour of Chaos,\" \"Fight the Power\"). В своем творчестве он также обращался к таким темам, как культура белой Америки (\"Rebel Without a Pause,\" \"Burn Hollywood Burn\") и разнообразным социально-политическим конфликтам (\"911 Is a Joke,\" \"Night of the Living Baseheads\"). Такие команды, как Bomb Squad, KRS-One и его группа Boogie Down Productions также начали высказывать свое мнение, полязуясь жесткими выпадами и упреками в сторону власти. Примером этому служат композиции \"Illegal Business\" (Незаконный бизнес) и \"Stop the Violence\" (Остановите насилие), которые поддерживали чернокожих и обращались к лидерам капиталистического мира.\r\n\r\nТо, что сначала казалось благодатной почвой для развития музыкальной культуры, на самом деле оказалось очень недолговечным. Public Enemy сошел с дистанции после 1991г., и несмотря на большое количество свежих записей от нового поколения политических рэперов (Poor Righteous Teachers, Paris, X-Clan, Disposable Heroes of Hiphoprisy), коммерческое превосходство и успех нового hip-hop направления gangsta rap или G-funk сделали звукозаписывающие компании менее активными в отношении менее успешной музыки.\r\n'),
(23, 'Pop-Rap', 'Pop-Rap гибрид hip-hop бита и rap с мощным мелодичным наполнением, который обычно является частью хоровой секции (припев) в структуре стандартной pop-композиции. Pop-rap имеет тенденцию к снижению агрессивности и повышению лирической ценности по сравнению с уличным hip-hop, хотя в середине-конце 90-х годов, некоторые музыканты смешивали этот стиль с hardcore элементами, пытаясь предотвратить отрицательную реакцию публики относительно легкости и общедоступности их музыки. Стиль Pop-rap зародился в конце 80-х годов, когда такие исполнители, как Run-D.M.C., L.L. Cool J и Beastie Boys начали выходить на основную музыкальную сцену. Вскоре после этого такие рэперы, как Tone Loc, Young MC, DJ Jazzy Jeff и Fresh Prince записали несколько синглов с акцентом на их возможностях рассказывать со сцены добродушные жизненные истории, что и стало причиной их огромного успеха в чартах. Их примеру последовали многие музыканты, выпустив целый ряд однотипных добрых мелодий для вечеринок. Так как возможность всеобщего принятия других направлений была очень реальной, то другие музыканты в это время начали развивать фьюжн rap с R&B и танцевальной музыкой. Они использовали сэмплы для создания мелодий. С появлением в 1990 г. MC Hammer и Vanilla Ice, направление pop-rap часто подвергалось насмешкам (а иногда даже подвергалось судебным преследованиям) за желание подражать широко известным хитам, не внося в них никаких значительных изменений, или вообще их не изменяя. Такие случаи не смогли окончательно подорвать репутацию этого стиля, так как многие музыканты 90-х продолжали удерживать лидирующие позиции хит-парадов, развивая при этом звое собственное звучание (PM Dawn, Naughty by Nature, House of Pain, Arrested Development, Coolio, Salt-N-Pepa, Sir Mix-a-Lot и т. д.). Тем временем яркий G-funk, принадлежащий Dr. Dre и Puff Daddy''s Hammer продолжали незаконно присваивать себе элементы pop-хитов 80-х годов, что и помогло таким направлениям, как gangsta и hardcore всзлететь на первые строки чартов. К концу 90-х годов в стиле pop-rap доминировали музыканты, на которых оказали влияние gangsta и hardcore, а также исполнители, смешивающие rap и urban soul.'),
(24, 'Progressive Electronic', 'Progressive Electronic процветает на еще незнакомой музыкальной территории. Стили, которые появляются, часто диктует непосредственно технология. Вместо того, чтобы семплировать или синтезировать акустические звуки, чтобы копировать их с помощью электроники, эти композиторы имеют тенденцию видоизменять оригинальные тембры, иногда до неузнаваемого состояния. Истинные артисты в этом жанре также создают свои собственные звуки (в противоположность использованию заданных звуков, которые идут с современными синтезаторами). В прогрессивной электроакустической музыке, электроника играет большую роль в концепции создания. Акустические инструменты в режиме реального времени обрабатываются через ревербератор, гармонизацию или другие эффекты, которые добавляет полностью новое измерение к технике игрока на инструменте. В лучшем случае эта музыка открывает новые миры прослушивания, размышления, взглядов и чувства. В худшем случае, артисты progressive electronic поклоняются технологии для ее собственной пользы, оставляя сердце и душу истинного выражения артистистизма.'),
(25, 'Progressive House', 'Музыка в стиле House стала центровым направлением к концу 80-х (больше всего в Великобритании), и после того как несколько ранних house хитов стали первооткрывателями этого стиля, позднее они были подавлены новыми музыкантами с одиночными хитами, доминирующими в чартах в конце десятилетия. Также как и  ambient, techno и trance, вошли на олимп электронных стилей в начале 90-х двояко как уличная музыка и молодое интеллектуальное направление. Поколение тех house музыкантов вскоре появилось в первой волне house. Они предполагали заставить звучать по-новому наиболее эмоциональные элементы музыки. Создавая отличное сочетание классного techno house с большим влиянием со стороны New York garage, чем Chicago acid house, танцевальные чатры ( а аткже иногда британские чарты альбомов) Leftfield, the Drum Club, Spooky и Faithless. Хотя по замечаниям критиков, полные версии синглов никогда не играли такой важной роли, как клубные треки. Некоторые пластинки в стиле Progressive House выдающимися работами музыкантов, как, например, Leftfield''s Leftism, Spooky''s Gargantuan и the Drum Club''s Everything Is Now. К середине 90-х, новинки progressive house стали основными тенденциями развития мировой музыки house.\r\n')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(26, 'Progressive Trance', 'Хотя направление progressive house перевело все более популярное звучание house из чартов обратно на танцполы, прогрессивное крыло trance продолжало уверенно двигаться к дальнейшей коммерциализации и чартовой направленности создаваемой музыки, так как последователи trance никогда не ставили на первое место лидирование в чартах. Подчеркивая мягкое звучание Eurodance или house (иногда больше напоминающее Jean-Michel Jarre, чем Basement Jaxx), к концу тысячелетия направление Progressive Trance стало лидеров танцевальной культуры во всем мире. Критики высмеивали предопределенную структуру и сравнительное отсутствие профессионального микширования (beat-mix). Но progressive trance поддерживался самым зажигательными DJs (Oakenfold, Tong, Sasha) и пропагандировался в крупнейших лондонских клубах (Gatecrasher, Cream, Ministry of Sound, Home). Хотя музыканты в стиле progressive trance редко пытались пойти дальше, чем крутить синглы на радио Tong или включать их в последний альбом миксов от Sasha, но некоторые (а именно Paul Van Dyk и Hybrid) вскоре начали выпускать полные версии альбомов. John Bush\r\n'),
(27, 'Psychedelic', 'Стиль Psychedelic Rock появился в середине 60-х годов, в товремя, когда British Invasion и folk-rock команды начали расширять звуковые границы их музыки. Вместо того чтобы ограничивать себя краткими и лаконичными шаблонами куплет-припев-куплет взятыми из rock & roll, они решили пойти дальше и использовать более свободную форму и структуру песни. Также было важно то, что группы начали вплетать в свои композиции элементы индийской, восточной музыки и свободного jazz. Они также продолжили проводить студийные эксперименты с альтернативными электронными инструментами и вокалом. Сначала в 1965 1966 гг. такие группы, как Yardbirds и Byrds сломали все границы для развития психоделии (psychedelia), создавая бурлящие слои гитар (fuzz-toned), ситар и монотонного вокала. Вскоре многие группы пошли по их стопам, включая Beatles и Rolling Stones. Обе эти группы записывали стиль psychedelia в 1966 г. В два счета множество групп на обеих сторонах Атлантики стали использовать возможности нового жанра, разница была видна сразу. В Великобритании, стиль psychedelia имел тенденцию быть эксцентричным и сюрреалистичным. Тем не менее, такие группы как Pink Floyd и Traffic играли продолжительные инструментальные композиции, которые брали за основу импровизацию, так же как и их американские современники Grateful Dead, Doors, Love и Jefferson Airplane. В других регионах Америки , garage группы начали играть psychedelic rock не оставляя при этом своей непрофессиональной, любительской манеры работать в стиле 3-аккордного rock они просто наслаивали слои distortion, feedback и эффектов. В конце концов, psychedelic превратился в acid rock, heavy metal и art rock, но возвращения к направлению psychedelia можно было наблюдать многие десятилетия, особенно в американском underground середины 80-х.\r\n'),
(28, 'Psychedelic Pop', 'Стиль Psychedelia стал явлением в жизни underground в середине 60-х годов, и как большинство других музыкальных явлений, он вскоре стал общественно признанным. На это не требовалось много времени после того, как этот стиль использовали Beatles в Revolver (1966 г.), успех стиля был просто вопрос времени. Там, где psychedelic музыка активно стирала границы и стереотипы, направление Psychedelic Pop в основном заимствовало эти новинки и использовало их для создания ярких pop композиций. Галлюциногенные эффекты создавались с помощью специальных инструментов и аксессуаров ситар, fuzz guitars, магнитофонных эффектов, бэк-гитар и даже гармония команды Beach Boys. Всё это смешивалось в каком-то кайфе, но нужно отметить, что эта музыка имела строгую структуру композиций и мелодий, поэтому не была слишком экзотической. Время от времени, композиции psychedelic pop записывались на студии, но существовали инструментальные команды такие, как Sagetterius, чей стиль psychedelia значительно ярче и мелодичнее. При этом чувствовалось сильное влияние Beach Boys, но они не приставали, как жевачка к зубам (слова из композиции Lemon Pipers \"Green Tambourine.\"). Вследствие большого количества pop элементов, стиль psychedelic pop немного дольше задержался на музыкальной арене, чем psychedelia. Он просуществовал до начала 70-х годов, что само по себе странно. Еще более странно то, что некоторые работы в стиле psychedelic pop вызывают больший интерес, чем обычный psychedelia. Алюбом The Moth Confesses от команды the Neon Philharmonic (1969 г.), отличающейся таинственным, иногда неуклюжим смешением элементов psychedelia и pop традиций, является самым лучшим тому примером.\r\n'),
(29, 'Psychedelic/Garage', 'Garage Rock был простой, необработанной формой rock & roll, которую создали несколько американских команд в середине 60-х годов. Вдохновителями служили такие крутые команды British Invasion, как Beatles, Kinks и Rolling Stones. Эти группы Среднего Запада играли вариации на тему British Invasion rock. Так как обычно это были молодые и непрофессиональные музыканты, то результаты более дилетанскими по сравнению с мэтрами, но именно это поддерживало существование звука. Большинство групп делало акцент на любительский стиль, играя всё теже три аккорда, сильно ударяя по струнам гитар и предлагая рычащий вокал. В большей степени команды в стиле garage составили первую волну punk рокеров сделай себя сам. Затем по всей Америке стали появляться сотни garage групп, и значительная их часть, включая Shadows of Knight, Count 5, Seeds, Standells, записывали настоящие хиты, а остальным была уготована безызвестность. На самом деле, практически все эти группы были забыты еще в начале 70-х годов, но сборник композиций Nuggets (Самородки) возродил из жизни. В 80-х годах наблюдалось настоящее возрождение стиля garage rock, которое ознаменовалось целым рядом музыкальных групп, которые пытались точно воспроизводить звук, стиль и внешний вид garage команд 60-х годов.\r\n\r\nПодъём стиля Garage стимулировал также и развитие направления Psychedelic Rock. Стиль Psychedelic Rock появился в середине 60-х годов, в товремя, когда British Invasion и folk-rock команды начали расширять звуковые границы их музыки. Вместо того, чтобы ограничивать себя краткими и лаконичными шаблонами куплет-припев-куплет взятыми из rock & roll, они решили пойти дальше и использовать более свободную форму и структуру песни. Также было важното , что группы начали вплетать в свои композиции элементы индийской, восточной музыки и свободного jazz. Они также продоолжили проводить студийные эксперименты с альбернативными электронными инструментами и вокалом. Сначала в 1965 1966гг. Такие группы, как the Yardbirds и the Byrds сломали все границы для развития психоделии (psychedelia), создавая бурлящие слои гитар (fuzz-toned), ситар и монотонного вокала. Вскоре многие группы пошли по их стопах, включая the Beatles и the Rolling Stones. Обе эти группы записывали стиль psychedelia в 1966г. В два счета множество групп на обеих сторонах Атлантики стали использовать возможности нового жанра, разница была видна сразу. В Великобритании, стиль psychedelia имел тенденцию быть эксцентричным и сюрреалистичным. Тем не менее, такие группы как Pink Floyd и Traffic играли продолжительные инструментальные композиции, которые брали за основу импровизацию, также как и их американские современники the Grateful Dead, the Doors, Love и Jefferson Airplane. В других регионах Америки , garage группы начали играть psychedelic rock не оставляя при этом своей непрофессиональной, любительской манеры работать в стиле 3-аккордный rock они просто наслаивали слои distortion, feedback и эффектов. В конце концов, psychedelic превратился в acid rock, heavy metal и art rock, но возвращения к направлению psychedelia можно было наблюдать многие десятилетия, особенно в американском underground середины 80-х.\r\n'),
(30, 'Quiet Storm', 'В1975г. Smokey Robinson выпустил легкую и чувственную сольную пластинку под название A Quiet Storm, куда вошли романтические adult soul композиции. Со временем этот альбом дал название целому музыкальному стилю и радио форматам, которые стремились создавать похожие настроения. Quiet Storm также попал под влияние со стороны альбома Marvin Gaye Let''s Get It On, инструментального soul Philly и нежных композиций Al Green. В некотором смысле появление quiet storm стало ответом R&B на расцвет таких направлений, как soft rock и adult contemporary. Хотя quiet storm в основном предназначался для чернокожих поклонников, он обладал такой же приглушенной динамикой, расслабленным темпом и романтическими переживаниями. Однако этот стиль также отличался изысканной утонченностью и смягченныи эмоциональным порывом, который безошибочно указывал на происхождение этого стиля от R&B. Некоторые исполнители сконцентрировали свое творчество только на этом стиле, но большинство музыкантов записывали больше быстрых треков в дополнение к лирическим балладам, которые подходили под данный радио формат. Quiet storm оставался популярным с конца 70-х годов до начала 90-х, когда R&B испытал большое hip-hop влияние, - и в результате стиль quiet storm не приобрел никаких новых последователей.\r\n'),
(31, 'Ragga', 'Стиль Ragga относится к reggae , где используется фоновая инстументальная музыка (или другие разнообразные музыкальные инструменты) в цифровом формате. Этот стиль преимущественно ассоциируется с танцполом, а так как не всё направление dancehall reggae является электронным (и поэтому ragga тоже не является), то у этих двух стилей много общего. \"Ragga\" - это сокращение от \"raggamuffin,\" изначально этот термин изпользовался для обозначения подростков из гетто Kingston. В музыке это слово прижилось в отношении музыкального стиля нового поколения середины-конца 80-х годов. Вследствии относительно низкой цены на создание синтезаторных ритмов, стилю ragga стали отдавать предпочтение многие ямайские музыканты и композиторы. Это позволяло им выпускать тысячи синглов в год и придумывать более интересные новые ритмы вместо того, чтобы просто заимствовать звучание их старых rock композиций. Это также повлекло за собой взрывной успех ритмичных альбомов (\"rhythm album\"), где многие музыканты записывали собственный текст и мелодии на один и тот же ритмовый трек. Хотя многие ассоциируют стиль ragga с мастерством ди-джеев, некоторые исполнители часто выражают интерес к романтическим и Rastafarian настроениям, - и два вокальных стиля довольно часто смешиваются друг с другом. Первая запись в стиле ragga принадлежит Wayne Smith с его синглом \"Under Me Sleng Teng\" (1985 г.), автором которого является King Jammy. Этот сингл построен на ритме, который был открыт в пресетах на клавишных Casio. Импульс был мгновенным, как грибы выросли множество подражателей, а сам Jammy превратился на некоторое время в самого влиятельного музыканта и продюсера Ямайки. В 90-е годы, стиль ragga прочно воцарился на многих самых популярных дискотеках Ямайки. Позднее этот стиль начал использовать hip-hop технику сэмплирования, а некоторые исполнители даже записали pop композиции, ставшие хитами в США. Стиль ragga оказал важное влияние на бурное развитие направлений jungle/drum''n''bass в Великобритании.\r\n'),
(32, 'Rap', 'Для неискушенного слушателя вся музыка rap и hip-hop может показаться одинаковой. Но существует целый ряд уровней даже в самой простой rap композиции. В своей основе hip-hop это постмодернистский музыкальный жанр, который сметает знакомые звуки и тексты, показывая в совершенно новом свете непредсказуемые композиции. Ранние rap записи, традиционно называемые \"old school\" (старая школа), были выполнены с помощью записи DJs scratching, зацикленных барабанов плюс начитывание rap поверх получившегося ритма. По мере развития этого жанра, первая hardcore rap команда Run-D.M.C включила в его исполнение hard-rock гитары и сумасшедший бит, а техника scratch была заменена сэмплами. Команда Public Enemy, использовавшая плотную комбинацию сэмплов, бита и белого шума, довела технику сэмплирования до максимума. Эта команда способствовала появлению социального и политического сознания к hip-hop. Хотя это исчезло в 90-е годы, когда направление gangsta rap изначально созданное командой NWA, которая использовала звук Public Enemy в качестве шаблона стало основной доминирующей формой. Стиль gangsta rap, который первоначально находился в прямой оппозиции таким поп-ориентированным рэпперам, как MC Hammer, к 90-м годам стал более мягким и стильным, что в конечном итоге привело к большому скачку его популярности. Свидетельством этому служит звездный взлет музыканта pop-gangsta Puff Daddy.\r\n'),
(33, 'Rave', 'Rave это скорее событие, чем музыкальный жанр. Рейвами назывались вечеринки андеграунда, обычно проходящие под кислоту, hardcore и большие дозы легкого наркотика (в основном экстази). Музыка, предлагаемая на рейвах, в большинстве имела галлюциногенные свойства, еще до того, как наркотики стали основным составляющим этого праздника жизни. DJ, играющие на рейвах, создавали музыку из techno и house синглов. Вскоре именно они (ди-джеи), а не записывающие музыканты, стали самыми узнаваемыми и известными людьми в этой среде. Рейвы оставались, главным образом, английским феноменом с конца 80-х до начала 90-х гг. Такие сборища проводились в помещениях большой площади, часто на заброшенных складах и под открытым небом. В конечном итоге, британское правительство проявило недовольство их проведением, называя рейвы опасным для общества и антисоциальным явлением, которое необходимо прекратить. Но этого не случилось, рейвы продолжили свое существование, их поклонники сообщали друг другу о намечающейся вечеринке и пользовались сделанными вручную флаерсами. В США нашествие рейва началось в начале 90-х, но это никогда не приводило к большому скоплению публики, даже по стандарту андеграунда. В 90-е года, появились команды, на которые непосредственное влияние оказал rave особенно такие, как the Stone Roses, Happy Mondays и Charlatans; а также представители британской популярной музыки Pulp и Oasis; техно-группа the Prodigy все они развивали основную тенденцию рейв культуры, привлекая внимание британской молодежи в конце 90-х.\r\n'),
(34, 'Rhytm''n''Blues', 'Выражение \"ритм-энд-блюз\" появилось в начале 40-х годов, и служило для описания черной американской поп-музыки, представлявшей собой своего рода ритмически акцентированного \"развлекательного, несерьезного\" блюза. В те годы словосочетание \"ритм-энд-блюз\" просто заменило неблагозвучный термин \"расовая музыка\", как с начала ХХ века белые американцы называли вариации черного блюза. Во второй половине 50-х годов ритм-энд-блюз подвергся дальнейшему \"дроблению\" на соул, фанк и позже - диско. Компактные черные коллективы (в отличие от традиционных биг-бэндов) проникли на территорию, традиционно занятую белыми поп-исполнителями, - в манере \"новых черных групп\" превалировал типично джазовый инструментальный свинг, тогда как вокалисты тяготели к классической блюзовой стилистке. Таким образом, как и блюз, ритм-энд-блюз стал важнейшим связующим звеном между биг-бэндами 40-х, группами биг-бита конца 50-х и первыми исполнителями рок-н-ролла. Самые ранние рок-н-роллы часто представляли собой ритмически аранжированные версии классических ритм-энд-блюзов - убедительным примером такого рода аранжировки может служить композиция Роя Брауна \"Good Rockin'' Tonight\", специально адаптированная под манеру и стиль Элвиса Пресли. Как ни странно, в рок-музыке американский ритм-энд-блюз первыми взяли на вооружение английские группы The Rolling Stones, The Animals, The Kinks и чуть позже - The Who, представлявшие собой ветвь, диаметрально противоположную той, на которой разместились поп-мелодисты The Beatles, The Hollies и подавляющее большинство новых английских групп. В дальнейшем ритм-энд-блюз претерпел \"косметические\" изменения и вернулся на родину. В конце 60-х - начале 70-х британские группы вновь подвергли ритм-энд-блюз ревизии, сделав его базой хард-рока, из которого развилось множество стилей, в конце концов так соединивших в себе блюз и ритм-энд-блюз, что сегодня в роке они практически неразличимы.\r\n'),
(35, 'Southern Rap', 'Southern Rap, похожий на третье колесо между East Coast и West Coast hip-hop, появился в 90-х годах на богатой музыкальными направлениями сцене Miami, New Orleans и Atlanta. В конце 80-х годов, Southern rap в соновном ассоциировался с Miami bass music, а также был известен под названием \"booty rap\" за свои зажигательные ритмы и доминирование лирики. Основными исполнителями можно назвать команду Luther Campbell''s 2 Live Crew, которая довела тему секса в его текстах до максимального предела, провоцируя шумные протесты от любителей цензуры по всей стране. Звуки Miami bass распространились по всей территории юга США, главным танцевальным ритмом нации 90-х годов. На этой сцене преобладали такие исполнители, как Tag Team, 95 South, the 69 Boyz, Quad City DJ''s и Freak Nasty. Все они выпускали большое количесвто хитовых синглов (наполненных куда более откровенными текстами, чем у Campbell). Atlanta принадлежал целый ряд исполнителей в стиле тяжелого party rap, здесь также развивался более характерный (и признаваемый критиками) стиль, совмещавший в себе классический Southern soul. Интеллектуальная команда Arrested Development стала первой, имевшей огромный успех на национальной музыкальной сцене 1992 года. Несколько лет спустя их успех повторили Organized Noize, особенно OutKast и Goodie Mob.\r\n\r\nЕсли Atlanta стала творческим центром направления Southern rap, то New Orleans был, естественно, его коммерческой меккой. Master P построил доходную империю с помощью звукозаписывающей компнии No Limit. Большинство альбомов, записанныз на студии No Limit относились к направлению West Coast G-funk, Wu-Tang-style hardcore и ничему другому, как gangsta лирике. Студия No Limi выпускала музыкальную продукцию с производительностью заводской поточной линии и стала постоянным участником национальных альбомных чартов конца 90-х годов. К концу десятилетия студия Cash Money (New Orleans) и её house продюсер Mannie Fresh чей специальный подход позволил переработать звуковой материал Southern bass произвели настоящий национальный прорыв, представив на музыкальном стиле команду Juvenile в качестве законного конкурента существующих фаворитов.\r\n'),
(36, 'Tech-House', 'Tech-House используется для описания широкого спектра музыки. Это название в основном подходит для европейских музыкантов, сочетающих многие ритмы и эффекты acid и progressive house с чистым и простым стилемy, подразумевающимся направлениями Detroit и British techno. К этому стилю принадлежат многие известные имена, включая Herbert, Daniel Ibbotson, Terry Lee Brown Jr., Funk D''Void и Ian O''Brien.\r\n'),
(37, 'Techno', 'Techno берет начало от электронной house музыки, развитой в Детройте в середине 80-х годов. Там, где house до сих пор имеет явную связь с disco, даже тогда, когда этот стиль был полностью механическим, направление techno всегда относилось к строго электронной музыке, предназначенной специально для определенной небольшой аудитории. Первые музыканты и DJs в стиле techno Kevin Saunderson, Juan Atkins и Derrick May делали основной акцент на электронный, синтезированный бит исполнителей electro-funk, таких как Afrika Bambaataa и работающих в направлении synth-rock, как Kraftwerk. В США techno был только андеграудным явлением, но в Великобритании оно вырвалось на основную музыкальную арену страны в конце 80-х. В начале 90-х годов techno начало распадаться на множество субжанров, включая hardcore, ambient и jungle. В стиле hardcore techno, количество ударов в минуту в каждой композиции было увеличено до смешных и невозможных для танца уровней это было сделано для того, чтобы охладить и оттолкнуть широкие массы поклонников. В случае со стилем Ambient все случилось наоборот, - произошло уменьшение ритма и появление пространственных электронных текстур он использовался в качестве расслабляющей музыки, когда рейверам и клубной молодежи была нужна передышка от acid house и hardcore techno. Jungle был почти также агрессивен, как hardcore, сочетал в себе энергичные techno биты с breakbeats и танцевальным регги. Все субжанры techno изначально предназначались для использования в клубах, где их микшируют DJs. Вследствие этого большая часть музыки была доступна на  12-дюймовых синглах или сборниках различных музыкантов, где композиции были довольно долгими, что давало DJ большое количество материала для миксов. В середине 90-х годов, появился новый тип музыкантов в стиле techno в основном это были ambient исполнители, такие как the Orb и Aphex Twin, но также и предпочитающие более тяжелый стиль, как the Prodigy и Goldie они начали создавать альбомы с композициями, которые не содержали сырого материала для ди-джейских миксов. Не удивительно, что эти музыканты особенно the Prodigy стали звездами мирового techno.\r\n'),
(38, 'Techno-Dub', 'Это направление часто ассоциируется с немецкими звукозаписывающими компаниями Force Inc/Mille Plateaux. Techno-Dub - минималистская форма techno с выраженным влиянием techno и sub-sonic bass, которое пришло из классических записей.\r\n'),
(39, 'Techno-Tribal', 'Более определенная разновидность, основанная на этнической теме, музыка Techno-Tribal становится более видной среди прогрессивных электроакустических артистов, которые очарованы идеей комбинировать наиболее первобытные музыкальные выражения человека с его наиболее технологически продвинутыми изобретениями. Племенные ритмы и инструменты от исконных культур Африки, Австралии, Северной и Южной Америки смиксованы со сложной электроникой. Требуется большой навык и чувствительность, чтобы не позволить музыке звучать подобно дешевым пародиям на культуры, у которых эти артисты заимствуют.\r\n'),
(40, 'Trance', 'Этот стиль вырвался на свободу в начале 90-х годов, оставив позади немецкое techno и hardcore. Trance базируется на бесконечных повторениях коротких сэмплов синтезатора на протяжении всего трека, при этом допускаются минимальные изменения ритма и частотных характеристик синтезатора, чтобы иметь возможность различать композиции. Эффект от такой музыки состоит в том, что слушатели погружаются в состояние транса, сходное с религиозным. Несмотря на снижение интереса к музыке в середине 90-х, trance снова вернулся, но уже ближе к концу века, вытеснив с мировой музыкальной арены стиль house, как самый популярный стиль альтернативной танцевальной музыки. \r\n\r\nБлагодаря влиянию acid house и Detroit techno, развитие trance совпало с открытием студий звукозаписи R&S Records (Ghent, Бельгия) и Harthouse/Eye Q Records (Франкфурт, Германия). R&S определила формат с такими синглами как \"Energy Flash\" (Joey Beltram), \"The Ravesignal\" (CJ Bolland) и другими композициями от Robert Leiner, Sun Electric и Aphex Twin. Студия Harthouse была открыта в 1992 Sven Vath совместно с Heinz Roth & Matthias Hoffman. Она оказала значительное влияние на само звучание trance, благодаря композициям от Hardfloor (\"Hardtrance Acperience\") и собственному сочинению Vath (\"L''Esperanza\"), плюс ко всему релизы команд Arpeggiators, Spicelab и Barbarella. Такие музыканты, как Sven Vath, Bolland, Leiner и многие другие начали играть музыку в полном объеме (без сокращений), хотя это не произвело особых поворотов в области мировой музыки. \r\n\r\nНесмотря на долгий период становления и развития, стиль trance полностью исчез с мировой арены, завершив свое влияние на британскую музыкальную культуру в конце 90-х, его заменил breakbeat dance (trip-hop и jungle). Классическое немецкое звучание всё-таки внесло свои изменения, поэтому появился термин \"progressive\" trance, используемый для описания влияния со стороны мягких форм house и Euro dance. К 1998г., большинство известных DJs такие как Paul Oakenfold, Pete Tong, Tony De Vit, Danny Rampling, Sasha, Judge Jules играли trance в самых престижных британских клубах. Даже США обратила внимание (наконец-то) на этот стиль во главе с отличными DJs, включая Christopher Lawrence и Kimball Collins.\r\n'),
(41, 'Turntablism', 'Х\r\nотя такие DJs, как Grandmaster Flash, Afrika Bambaataa и Grand Wizard Theodore были лидерами hip-hop движения 1970-х годов, но к моменту восхождения rap на музыкальную арену в середине 80-х, первые места былди отданы именно рэповым исполнителям (MC). В общем итоге, для того, чтобы иметь шанс попасть в радиоэфир или сделать коммерчески удачное направление, треки обязательно должны были иметь вокальную ориентацию. Неизбежным стало то, что авторы первых уличных hip-hop миксов осказались в тени. Хотя, вероятно, баланс никогда не восстановится, растущий интерес ко всем аспектам rap культуры в середине 90-х годов стал результатом выделения Turntablism в отдельное направление музыки. Бесспорными звездами здесь стали DJs, в своем репертуаре вместо плотных ритмов и мягких движений они предлагали scratching, spinbacks, phasing и фантастическое исполнение микса на двух вертушках (beat juggling). Некоторые наиболее популярные DJs (среди них можно выделить DJ Shadow) создавали свои миксы из нескольких тысяч записей, и чем неразборчивее и загадочнее, тем лучше. Большинство базовых записей относились к барабанным брейкам из jazz (редко), soul или funk (популярностью пользовались также записи воспитательного и образовательного характера, так как в нем можно было найти невообразимые вокальные сэмплы). Авангард составлял Christian Marclay, начавший писать симфонии для вертушек в начале 80-х годов, используя материал из различных музыкальных источников. В 1987 г. Архаизм старой disco эры - Disco Mix Club (позже называемый просто DMC) провел свой первый чемпионат DJ. Вскоре такое соревнование стало для DJs возможностью показать, на что они способны, а также заработать уважение в лице коллег и поклонников. Второе поколение отличных DJs, таких как QBert, Mixmaster Mike, DJ Apollo и Rob Swift стало лидером появляющегося направления Turntablism , - некоторые из них работали самостоятельно, другие входили в новые команды, например такие авторитетные, как  Invisibl Skratch Piklz (I.S.P.), X-Men (позже X-Ecutioners) и Beat Junkies. Хотя их альбомы никогда особо не пользовались успехом у rock аудитории, но новое поколение музыкантов - ярким примером которого является DJ Shadow заработало одобрение в глазах критиков, благодаря уменьшению роли живых выступлений и физического мастерства в пользу создания профессионального студийного материала в полном объеме.\r\n'),
(42, 'Tribal-House', 'Кначалу 90-х годов музыка в стиле house music претерпела несколько фьюжн с другими стилями, так на свет появились направления ambient-house, hip-house и Tribal-House, когда образовалось смешение four-on-the-floor синтезатора и полиритмических ударных, К этому стилю принадлежит группа музыкантов, от основных Frankie Bones и Ultra NatИ до electro-hippie таких, как Banco de Gaia, Loop Guru и Eat Static (все они работали с британской студией Planet Dog Records).\r\n'),
(43, 'Trip-Hop', 'Еще один представитель в длинной веренице направлений, прилепившихся к танцевальной культуре Великобритании на этапе post-acid house и быстро изменяющих постоянно экспериментирующий андеграунд. Trip-Hop был создан британскими музыкальными изданиями с целью охарактеризовать новый стиль, состоящий из downtempo, jazz-, funk- и  experimental breakbeat музыки, которая начала появляться в 1993г. при участии таких звукозаписывающих компаний, как Mo''Wax, Ninja Tune, Cup of Tea и Wall of Sound. Похожий (хотя в большинстве без вокальных партий) на American hip-hop в использовании сэмплированных барабанных брейков, этот стиль был более экспериментальным явлением, вдохновляемым большим количеством элементов ambient и психотропной атмосферой. Таким образом, термин \"trip\" быстро укоренился и использовался для описания всего от Portishead и Tricky до DJ Shadow и U.N.K.L.E., Coldcut, Wagon Christ и Depth Charge к большому сожалению многих из этих музыкантов, которые видели свою музыку, как расширение границ обычного hip-hop, а не его новым ответвлением, используемым для создания шумихи. Одним из первых коммерчески значимых гибридом на базе танцевальной музыки, - полные версии альбомов в стиле trip-hop, стали постоянными лидерами альтернативных чартов в Великобритании, и по мнению музыкантов, таких как Shadow, Tricky, Morcheeba, the Sneaker Pimps и Massive Attack, этот стиль обеспечил проникновение значительной части музыки первой волны \"electronica\" в Америку.\r\n'),
(44, 'Underground Rap', 'Underground Rap распадается на две категории. Это или hardcore hip-hop, который расширяет музыкальные границы и отличается гораздо более интересными текстами, чем gangsta клише, - или hardcore gangsta rap, который собрал в себе все музыкальные и лирические стереотипы этих жанров. Эти два стиля сходятся в том, что уделяют одинаково мало внимания традициям и условностям основной музыкальной культуры, - они прославляют свой статус независимости. Underground rap записывается на крупных студиях меньше, чем hip-hop, но часто звучит одинаково.'),
(45, 'Uptempo', '')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(46, 'Urban', 'Urban (также известный под названием современный urban) таким термином назвали R&B/soul музыку 80-90-х годов. Так же как quiet storm и Philly soul, оказавшие на него большое влияние, стиль urban был очень мягким и утонченным. Но в то время как романтические баллады хорошо вписывались в радио формат направления quiet storm, urban находил возможность играть uptempo, funky dance треки, которые обычно отличались таким же high-tech музпроизводством, готовым к выходу в эфир, и душевным вокалом. Вот почему, несмотря на свое название, стиль urban не всегда имел земной налет, ассоциируемый с термином \"soul music,\" предпочитая приглушать безвкусные эмоции в пользу профессонального совершенства звука. До конца 80-х годов большая часть музыки urban была в значительной степени pop-ориентирована, это часто проявлялось в мелодии, и почти всегда в условиях производства.\r\n\r\nЦелый ряд исполнителей таких как Janet Jackson, Billy Ocean и Whitney Houston перебрались из чартов R&B в pop чарты. Хотя были и другие музыканты, среди них Freddie Jackson, Luther Vandross, Stephanie Mills и Levert, чья R&B популярность не превратилась не во что другое. Позиции направления urban пошатнулись с появлением hip-hop. Музыкант (и Guy member) Teddy Riley создал фьюжн этих двух стилей, добавил редкие rap вставки и назвал все получившееся - new jack swing. Благодаря New jack, Bobby Brown превратился в суперзвезду музыкальной сцены, а для его партнеров по бывшей команде New Edition появление этого направления также оказалось удачным. В дополнение к Riley, появились дуэты (музыкант/продюсер), совмещающие pop и R&B такие как Jimmy Jam & Terry Lewis (Janet Jackson), Denzil Foster & Thomas McElroy (En Vogue) и Antonio \"L.A.\" Reid & Babyface. Именно они доминировали в стиле urban в конце десятилетия, при чем Babyface смог сделать головокружительную сольную карьеру. Направления Urban и hip-hop продолжали пересекаться и в начале 90-х годов, что, в конце концов привело к созданию нового гибрида, получившего название \"hip-hop soul\". Hip-hop soul взял за основу направление new jack swing, хотя преобладающие биты были более джазовые, гибкие и непредсказуемые. Стиль hip-hop soul отличался более мягким, эмоциональным настроем по сравнению с new jack. Здесь были заметны элементы urban, бравшие начало в quiet storm и adult contemporary. Хотя композиции (не зависимо от того, какое направление преобладало), быстро становились отличным материалом для профессионального вокального мастерства. Частично вследствие существенного спада основного направления pop/rock и активному поиску альтернативы, стиль urban становился доминирующим среди синглов, возглавляющих верхние строки pop чартов во второй половине 90-х годов. В авангарде музыкальной сцены можно назвать Mary J. Blige, Toni Braxton, R. Kelly, Boyz II Men, SWV, Blackstreet, Jodeci, Monica и Brandy.'),
(47, 'West Coast Rap', 'West Coast Rap доминировал на hip-hop сцене в середине 90-х годов, создавая популярность появившемуся направлению gangsta rap и продолжая статус Dr. Dre, как одной из самых влиятельных фигур с rap истории. Хотя, даже если запатентованный Dre стиль G-funk во многом определял звук и стилевую направленность на западном побережье (West Coast), то калифорнийская rap сцена была гораздо разнообразнее. В середине-конце 80-х годов, West Coast rap в основном имитировал East Coast party rap, считая своей родиной мастеров старой школы (old-school). Однако, как Los Angeles, так и Bay Area вскоре оказались очень плодородной почвой для развития музыкальной культуры. В Лос-Анджелесе записывались Ice-T в стиле proto-gangsta, влиятельные музыканты с выраженным предпочтением Latino ритмов Cypress Hill и пародийные Pharcyde; а район Bay Area в свою очередь представил сторонников голубых ритмов Too $hort, добродушных Digital Underground воодешвленных P-Funk, а также прорыв на pop сцене музыканта и рэп исполнителя MC Hammer. Короче говоря, West Coast rap стал таким же электронным и трудно определяемым, как East Coast rap. Однако, альбом команды N.W.A. под названием Straight Outta Compton (1989г.) в стиле ganhstra-rap установил более определенный формат стиля West Coast style его звук отличался жесткостью и минимализмом, а тематика чередовалась от грубого гедонизма до справедливо возмущенных комментариев социальной политики. После ухода из команды N.W.A., Ice Cube начал сольную карьеру и записал несколько альбомов, в которых прослеживался тот же лирический тон, но использовался шумный звук в стиле Public Enemy. А его согруппник Dr. Dre открыл команду Snoop Doggy Dogg, подписал контракт со студией Death Row Records, где в конце 1992 г. вышел альбом The Chronic, который определил направление G-funk и тем самым дал начало появлению целого ряда подражателей. В альбоме The Chronic использовался в основном стиль gangsta т.е. жалобные синтезаторы, раскатистые биты P-Funk и глубокий, медленный ритм. Отметим также, что этот альбом сделал студию Death Row самой большой звукозаписывающей компанией в стиле hip-hop начала 90-х годов, работающую с хитами таких исполнителей, как Snoop, Warren G., Tha Dogg Pound и многих других. Противоречивая звезда направления gangsta 2Pac начал работать на этой студии в конце 1995г., превратившись в суперзвезду после исполнения дуэтом с  Dre композиции \"California Love\". А Coolio выбрал более pop-ориентированную версию направления West Coast и пробился на верхние строчки хит-парадов в начале этого же года (1995 г.) с песней \"Gangsta''s Paradise.\" Однако, доминирование звучания West Coast вскоре сошло на нет 2Pac был убит в 1996г., Dre ушел из музыки, а президент компании Death Row Suge Knight получил заключен под стражу за коммерческте махинации. К концу 90-х годов, основное внимание hip-hop исполнителей было устремлено вновь к East Coast, а также к уже развивающемуся южному направлению (South).\r\n'),
(48, 'Atmospheric', 'Это Мета-стиль, основа многих стилей, имеющих атмосферную основу саунда'),
(49, 'Ambient Techno', 'Ambient Techno, редкая и достаточно специфичная переориентация ambient house, обычно используется такими музыкантами, как B12, ранний Aphex Twin, the Black Dog, Higher Intelligence Agency и Biosphere. Этот стиль отличает музыкантов, сочетающих мелодический и ритмический подходы techno и electro они используют барабанные установки 808 и 909, хорошо отлаженную электронику; минорные мелодии и семплы космического звучания парящая, монослойная атмосфера beatless и экспериментального ambient. Этот стиль часто ассоциируется с такими названиями команд как Apollo, GPR, Warp и Beyond. Терминология этого направления переросла в \"intelligent techno\" (интеллектуально техно) после того, как Warp выпустили композицию Artificial Intelligence (хотя в стилистическом отношении музыка осталась без изменений).\r\n'),
(50, 'Ambient House', 'Ранний термин, используемый для разграничения новой волны музыкантов ambient, таких как the Orb, KLF, Irresistible Force, Future Sound of London и Orbital. Ambient House часто использовался без разбора для обозначения танцевальной музыки, вне зависимости от ее предназначения. В самом строгом своем проявлении стиль ambient house - это музыка сочетающая основные элементы acid house midtempo, four-on-the-floor beats; синтезаторы и струнные; высокие вокальные сэмплы все это использовалось в более свободной, парящей манере. Затем этот термин быз заменен (или скорее, усложнен, хотя многие могут быть не согласны) на более специфические термины и редко используется.\r\n'),
(51, 'Acid House', 'Танцевальный стиль, распространивший американскую house музыку по всему миру. Стиль Acid House впервые появился в середине 80-х в творчестве чикагских музыкантов, таких как DJ Pierre, Adonis, Farley Jackmaster Funk и Phuture (последний придумал термин для классического сингла \"Acid Trax\"). Микшируя элементы house, которые уже были популярными в Чикаго (также как и в Нью-Йорке) с тяжелой музыкой и глубокими басами на синтезаторе Roland TB-303. Направление acid house было распространено только в Чикаго, пока пластинки не попали на другую сторону Атлантики в руки к молодым и энергичным британцам. Музыка звучала на вечеринках, проводимых на небольших складах в Лондоне в 1986-87, а затем стиль завоевал общественное признание во время проведения знаменитого фестиваля  Summer of Love летом 1988г., когда тысячи клубных завсегдатаев приезжали на крупномасштабные музыкальные события, позднее называемые рейвами Acid house очень быстро завоевывал первые позиции в британских поп чартах с хитами от команд M/A/R/R/S, S''Express и Technotronic до конца 90-х годов. К этому времени в Великобритании феномен acid house пришел в упадок и был смещен музыкой rave. Ученики американской новой школы, - от Cajmere до Armand Van Helden и Felix Da Housecat продолжали работать до конца 90-х годов.'),
(52, 'Ambient Breakbeat', 'Стиль Ambient Breakbeat относится к узкому субжанру электронной музыки, но отличается меньшей энергичностью, чем trip-hop или funky breaks. Однако ощутимое влияние hip-hop нельзя не отметить. Несколько медленных (downtempo) композиций, записанных на британских студиях (таких как Mo'' Wax и Ninja Tune) открыли дорогу к успеху нью-йоркскому DJ Wally (из команды Liquid Sky Records) и британским исполнителям, например, Req. Каждый из них продемонстрировал хорошее владение стилем\r\n'),
(53, 'Ambient Dub', 'Этот стиль был создан на звукозаписывающей компании Beyond для серии сборников, под одноименным названием. Ambient Dub с момента своего появления характеризовался музыкантами, критиками и публикой, как относящийся к любой форме ритмичного ambient с битовой ориентацией плюс идеи, текстуры и техника стиля Jamaican dub (например, reverb, акцент на бас и ударные, тяжелые эффекты). Хотя этот термин попал в немилость из-за яростного смешения стилей, принадлежащих в этапу post-rave electronica, он остается полезным для разграничения большого количества электронных приложений dub и еще большего количества стилей hip-hop, downtempo и битовой музыки. Среди музыкантов отметим the Orb, Higher Intelligence Agency, Sub Dub, Techno Animal, Automaton и Solar Quest.\r\n'),
(54, 'Ambient', 'Ambient был создан на базе экспериментов с синтезом электронной музыки, таких музыкантов как Brian Eno и Kraftwerk и танцевального trance techno в 80-х годах 20 века. Ambient использует электронную реверберацию и пространственную технологию звука, здесь важную роль играет сама текстура звучания, а не написание текстов и музыки. Музыка меняется медленно, имеет повторяющуюся природу, поэтому для неискушенного слушателя может показаться одинаковой. Хотя содержание и тембр композиций эмбиент-исполнителей имеет большие различия между собой. Стиль ambient стал популярной, культовой музыкой в начале 90-х голов, благодаря ambient-techno музыкантам the Orb и Aphex Twin.\r\n\r\nAmbient буквально значит окружение, обволакивание, погружение. Существует легенда о возникновении этого стиля, согласно которой Ambient был придуман одним из величайших саунд-продюсеров конца XX века Брайаном Ино (Brian Eno). Попав в больницу и пролежав прикованным к постели долгое время, Ино стал прислушиваться к звукам, доносящимся из окна его палаты, искать в них их внутреннюю мелодику. Затем он начал записывать шумы окружающей среды и составлять из них целые треки. Потом он выпустил все это в нескольких дисках под общим названием Ambient. \r\n\r\nРазумеется, сейчас нужно отличать Ambient оригинальный и электронный. Электронный ambient это мягкая, тягучая музыка, в которой нет ярко выраженного бита. Это спокойная музыка, в которой в качестве фона используются шумовые лупы, а главная мелодия играет ненавязчиво и как правило бывает очень длинной. В ambient часто используются обрывки фраз, кусочки звука из старых фильмов, хайтековские звуки и самое главное очень много реверберации и эхо. \r\n\r\nСейчас можно встретить очень мало ambientа в чистом виде. Элементы ambient присутствуют сейчас почти во всех стилях от хауса до хип-хопа, так что этот стиль протек во все остальные и уходить обратно в забвение, из которого его вытащил Ино, не собирается. Наиболее известными Ambient-музыкантами считаются Pete Namlook, Aphex Twin, Seefeel, The Future Sound of London, The Orb, Delerium.\r\n'),
(55, 'Alternative Rap', 'Alternative Rap относится к hip-hop командам, которые отказываются следовать любым традиционным стереотипам rap, таким как gangsta, funk, bass, hardcore и party rap. Вместо этого они смешивают различные жанры, добавляя равные элементы funk и pop/rock, а также jazz, soul, reggae и даже folk. Хотя командам Arrested Development и Fugees удалось добиться успеха и заявить о себе, большинство alternative rap групп остаются в основном музыкантами для alternative rock фэнов, а не для hip-hop или pop аудитории.\r\n'),
(56, 'Acid Rock', 'Стиль Acid Rock был самой тяжелой и громкой формой psychedelic rock. Заимствуя элементы блюзовых импровизаций от Cream и Jimi Hendrix, команды acid rock добавляли искаженные гитары, кайфовый текст и длинные проигрыши с помехами. Acid rock просуществовал недолго он появился и угас в течение подъема и расцвета psychedelia а группы, которые не распались, стали командами в стиле heavy metal.\r\n'),
(57, 'Acid Techno', 'Когда тяжелый acid house стал находить свое место в умах восприимчивой молодежи в середине 80-х, то влияние этой музыки было на лицо. Многие начинающие музыканты в начале 90-х годов использовали этот стиль для утяжеления techno, добавляя его вместо теплого классического Chicago house. Acid Techno (также как и ранний German trance) включает в себя ранние записи Aphex Twin, Plastikman, Dave Clarke и многих других.\r\n'),
(58, 'Acid Jazz', 'Эта музыка исполняется поколением музыкантов, выросшим на джазе, фанке и хип-хопе, и использует элементы всех трех направлений. Такие черты Acid Jazz, как насыщенность перкуссионными, а также преимущественно живое исполнение ставит этот стиль ближе к джазу и афро-кубинской музыке, чем к другим танцевальным направлениям. C другой стороны, подчеркнутый грув сближает Acid Jazz с фанком и хип-хопом. Сам термин впервые появился в 1988, причем одновременно как название американского звукозаписывающего лейбла и английской серии сборников, на которых была перевыпущена jazz и Funk музыка 70-х годов и которую до этого британцы называли rare groove. В конце 80-х - начале 90-х появилось много исполнителей Acid Jazz, которые представляли собой как \"живые\" команды - Stereo MC''s, James Taylor Quartet, the Brand New Heavies, Groove Collective, Galliano, Jamiroquai, так и студийные проекты - PALm Skin Productions, Mondo GroSSO, Outside, и United Future Organization.\r\n'),
(59, 'Bass Music', 'Зародившись в богатых танцевальными ритмами городах Miami (freestyle) и Detroit (electro) в середине 80-х годов, направление Bass Music привнесло с собой funky-breaks 70-х в цифровую эру, где барабанные установки своей мощностью могут превратить в порошок большинство ничего не подозревающих автомобилей или клубных акустических систем. Первые лидеры из Miami, такие как 2 Live Crew и DJ Magic Mike повергли этот стиль в определенного рода зацикленность на достигнутом, а детройтские музыканты, такие как DJ Assault, DJ Godfather и DJ Bone смешали его с techno для создания значительно более быстрой музыки. Bass music даже заявила о себе в чартах начала 90-х годов, показав композиции таких команд как 95 South''s \"Whoot (There It Is)\" и 69 Boyz'' \"Tootsee Roll\", которые стали неоспоримыми лидерами чартов, а позднее стали платиновыми.\r\n'),
(60, 'Big Beat', ''),
(61, 'Breakbeat', 'Брэйкбит \"ломанный\" бит окончательно сформировался как отдельный стиль в 1994 году. Стремительный рост популярности брэйкбита был вызван тем, что к тому времени люди уже несколько устали от порядком приевшегося хаусбита. Также на популярность очень сильно повлияло и то, что в брэйкбите часто применяются фанковые грувы, а весьма заметное влияние хипхопа не заметит только глухой. \r\n\r\nМестом рождения брейкбита принято считать Великобританию, а основными городами, где этот стиль первоначально получил наибольшее распространение, являются Лондон и Бристоль. Основным критерием для определения брэйкбита являются чистые, практически ничем не обработанные барабаны и перкуссия (за исключением разве что компрессии) и стандартный ритм 4/4. Сольники чаще всего ударяют на вторую и четвертую долю. Также в ритме может быть несколько дополнительных сбивок. Если говорить простым языком, то ритмическая основа брэйкбита строится на смещении доли (синкопировании) некоторых ударных или всего куска ритма. Чаще всего синкопирование происходит на третьей доле.\r\n\r\nВпервые исторически этот метод применили барабанщики Джеймса Брауна. Необходимо отметить, что брэйкбит это лишь общая классификация всей той музыки, которая использует описываемую выше ритмструктуру (разве что за исключением хипхопа, который появился раньше).\r\n'),
(62, 'British Psychedelia', 'Хотя они имели одинаковые художественные и студийные принципы работы, но стиль British Psychedelia очень отличался от своего американского партнера. В общем British psychedelia была либо более эксцентричной, либо более художественно-экспериментальной по сравнению с американским направлением. Плюс ко всему, британский стиль склонялся к работе по структуре pop композиций. Однако это не было непреложным правилом. Не важно, сколько коротких pop синглов они выпустили, но команда Pink Floyd прожила долгую сценическую жизнь, с каждым выступлением, покоряя все новые и отдаленные районы земного шара. Однако эти общие правила являлись более или менее употребляемыми, особенно в отношении студийных записей British psychedelic.\r\n'),
(63, 'British Rap', 'Хотя British Rap можно очень редко услышать за пределами Великобритании и Европы, этот стиль имеет свои собственные традиции и стилистику. Хотя в нем нельзя найти большого наследия American hip-hop, но многие британские рэперы выросли на богатых карибских ragga традициях, а затем ввели местные наречия в hip-hop стили. Британский rap зародился в конце 80-х годов, и в качестве трамплина использовал звуковые комбинации от Public Enemy. Вскоре многие британские рэперы стали подмешивать в свою музыку элементы acid-house, - в результате появился музыкальный стиль из более тяжелой категории, чем его американский собрат. Хотя там присутствовали блеклые копии, снятые с американских рэперов, но лучшие английские hip-hop музыканты разделились на три лагеря. Существовали такие группы, как Prodigy, смешивавшие hip-hop и rave. Были команды, как Leftfield, которые работали в клубном стиле hip. А также присутствовали такие исполнители, как Massive Attack, которые замедляли ритм hip-hop, добавляя acid-jazz, что в сумме давало trip-hop. Даже в то время как эти три команды продолжали завоевывать новые территории, на музыкальной сцене было заметно преобладание британских рэперов, которые просто копировали американцев.\r\n'),
(64, 'Comedy Rap', 'Comedy Rap - это hip-hop, который предназначается для развлечения и веселья. Довольно часто, это rap рифмовки смешного содержания, но сама музыка (особенно в случае с Biz Markie, по некоторым источникам самого крутого рэпера в стиле comedy rap на сегодняшний день) может быть интеллектуальной и забавной одновременно. Расцвет Comedy rap приходится на 80-е годы, когда hip-hop был легче по сравнению с 90-ми годами (тогда gangsta rap был самым мрачным музыкальным стилем). В это время существовало несколько rap пародий, таких как Chunky A от Arsenio Hall, но в большинстве comedy rap это сочетание real hip-hop и уличного юмора.\r\n'),
(65, 'Club/Dance', 'ВClub/Dance входит в много различных музыкальных форм, от диско до хип-хопа. Несмотря на то, что, на протяжении всей истории популярной музыки имелись различные повальные увлечения танц-музыкой, стиль Club/Dance стал ее собственным жанром в середине 70-ых, поскольку soul, в результате мутаций превратился в disco и практически все клубы были посвящены танцевальному направлению. В конце 70-ых, танцевальные клубы играли disco, но к концу десятилетия, disco видоизменялась во множество различных поджанров. Все жанры были собраны под термином \"dance\", хотя среди других поджанров имелись отличительные различия между dance-pop, хип-хопом, house, и techno. Все что связывало их, так это акцент на ритме в каждом танцевальном поджанре бит остается существенным.\r\n'),
(66, 'Contemporary R&B', 'Направление Contemporary R&B начало свое развитие несколько лет спустя после появления urban R&B. Как и стиль urban, contemporary R&B - профессионально сделанная музыка, но музыканты Maxwell, D''Angelo, Terence Trent D''Arby были очень увлечены добавлением в contemporary soul и R&B жесткости, духовного начала и претенциозности, своейственных classic soul (Marvin Gaye, Stevie Wonder, Otis Redding).\r\n'),
(67, 'DJ', 'На фоне играющего трека рэперы (называемые toasters) читают рифмовки на актуальные темы. Музыкальная форма DJ начала свое существование с sound system dances (танцевальные композиции на акустических системах), что в конечном итоге привело к записи рифмовок на диск. После появления hip-hop миксов в Нью-Йорке (частично благодаря ямайскому музыканту Kool Herc), то этот термин стал обозначать инструментальщиков, а не вокалистов. Крутые новинки, представленные Grand Wizard Theodore, Grandmaster Flash и Afrika Bambaataa, дошли до поколения 90-х годов (эти музыканты часто называются turntablists), которое перенимало сложившуюся форму художественого мастерства, включая Mixmaster Mike, DJ Q-Bert и Cut Chemist.\r\n'),
(68, 'Dance', 'Музыка Dance имеет большое количество форм, - от disco до hip-hop. Хотя в истории популярной музыки случались самые разные мании и музыкальные пристрастия, Dance сформировался как отдельный жанр в середине 70-х годов. В то время как soul превратился в disco, - целые клубы полностью отдавали предпочтение работе в танцевальном стиле. В конце 70-х годов dance клубы играли disco, но к концу десятилетия disco видоизменился, превратившись в целый ряд различных жанров. Все эти жанры были собраны под общим термином \"dance\", хотя между ними отмечаются явные различия, например, между dance-pop, hip-hop, house и techno, а также многими другими субжанрами. Их вместе объединяет общий акцент на ритм это прослеживается в каждом dance субжанре - от Disco до House и Rave,- везде главенствует бит.\r\n'),
(69, 'Dance-Pop ', 'Dance-Pop - это переросток disco. В сочетании с dance-club beat, вы найдете простые и яркие мелодии. Направление dance-pop имеет более сформированные композиции, чем просто dance музыка. Dance-pop - это прежде всего способ самовыражения композитора/продюсера. Композитор/продюсер пишет песни и создает треки, подбирает подходящего вокалиста для её исполнения. Эти dance певцы становятся звездами, но часто само художественное видение принадлежит продюсеру. Естественно, что есть несколько исключений из правил Madonna и Janet Jackson самостоятельно выбирали звук и направление творчества. Но dance-pop - это музыка для шоу, которое нужно видеть и не искать смысла.\r\n'),
(70, 'Deep House', 'Этот стиль появивился на стыке старого чикагского хауса и Gospel. Переполнен мелодиями, построенными на старых (и всеми любимых) аккордных прогрессиях, сыгранных призрачным звуком электрооргана. Deep-house - это прежде всего хаус, а уж потом - глубокое звучание инструментов.\r\n\r\nDeep House довольно минималистичен, вокала в нем не так уж и много, зато deep - один из самых сложных в плане восприятия стилей, к примеру, если под Club House будут танцевать абсолютно все, то под deep - намного меньше. Deep - музыка не только (и даже не столько) для ног, сколько для души.... Некоторые утверждают, что Deep House похож на классический Detroit и пpедставляет собой пpичудливую смесь House-музыки с вокалом госпел. Как утвеpждают его поклонники - \"Deep House - это пpотивоположенность всему остальному техно, музыка живых людей, а не машин\".\r\n'),
(71, 'Dark Ambient', 'Оригинальная версия ненавязчивой фоновой музыки ambient, принадлежащая Brian Eno, которая позже была скомпилирована с теплыми ритмами house и качественным звуком от the Orb в 90-е годы, стала оппозиционным направление для стиля, известного под названием Dark Ambient. Этот стиль может похвастаться большим количеством творческих личностей начиная от экспериментаторов в стиле industrial и metal (Scorn''s Mick Harris, Current 93''s David Tibet, Nurse with Wound''s Steven Stapleton) до приверженцев электронной музыки (Kim Cascone/PGR, Psychick Warriors Ov Gaia), музыкантов Japanese noise (K.K. Null, Merzbow) и альтернативных рокеров, появившихся в последнее время(Main, Bark Psychosis). Стиль dark ambient отличается смягченными или совсем отсутствующими битами в сочетании с тревожными. партиями синтезатора, мрачными сэмплами и обработанными гитарными эффектами. Как и большинство стилей, имеющих какое-либо отношение к музыке electronic/dance 90-х годов, это направление имеет очень расплывчатые границы, где музыкантов начинают или заканчивают работу с выпуском каждого успешного альбома.\r\n'),
(72, 'Dirty Rap', 'Dirty Rap (Грязный рэп) - это hip-hop, посвященный исключительно теме секса. Отцами основателями этого жанра стали музыканты из команды 2 Live Crew, которая была одним из лидеров в области тяжелого Miami bass. Поэтому именно этот басовый стиль лежит в основе dirty rap. Большинство композиций dirty rap были просто предназначены для вечеринок и завода публики, но они редко содержали что-то интересное в смысле музыки или лиричности.\r\n'),
(73, 'Detroit Techno', 'Раньше стиль Detroit Techno характеризовался,  попеременно то, как мрачный, обособленный набор механических вибраций, то, как создающий мягкое, яркое, эмоциональное ощущение (последнее частично перешло в этот стиль из наследия Motown и оставшейся незаполненной ниши между ранним techno и house в чикагском стиле, которые параллельно развивались в юго-западном направлении по всей стране). Если первоначально стиль развивался, как танцевальная музыка, которая поднимает настроение, то строгие и меланхоличные треки от Cybotron, Model 500, Rhythm Is Rhythm и Reese можно было относить на счет разгоревшегося в Детройте экономического кризиса в конце 70-х, который последовал за расцветом этого гиганта американской автомобильной индустрии.\r\n\r\nНизкое качество многократно копируемого музыкального материала и разбитые надежды эстетов большей частью можно отнести на счет ограниченных технологических возможностей начинающих новаторов (часто кассеты записывались с двухдорожечного оригинала). Растущий профессионализм и навороты современного techno (это касается всех стилей от hardcore до jungle), наоборот, обязаны своим появлением распространением и доступностью оборудования MIDI и цифрового компьютерного звука. Вторая и третья волна стиля Detroit techno, также заняли далеко не последнюю строчку в музыкальном производстве, хотя такие музыканта как Derrick May, Juan Atkins и Kenny Larkin пытались найти сочетание беспрецедентного совершенства цифровых технологий и композиционного минимализма исходного детройтского звучания.\r\n\r\nВыйдя за пределы местного масштаба, Detroit techno стал глобальным событием в музыке (частично в результате широкого признания, многие музыканты, начинавшие свое творчество в Детройте, разъехались по всему миру), подпитываемым тем, что многие из ранних классических треков все еще выпускались (и были доступны через Submerge). Сегодня, третья волна этого стиля вновь начала повторение эстетических ценностей того стиля, принадлежащего к раннему периоду, с сильным ритмом как (Underground Resistance, Jeff Mills), а также душевные мелодии (Kenny Larkin, Stacey Pullen). Снова возрождается интерес к корням стиля techno, пришедшим из breakbeat (Aux 88, Drexciya, \"Mad\" Mike, Dopplereffekt).\r\n'),
(74, 'Dirty South', 'Стиль Dirty South появился во второй половине 90-х годов, после того как gangsta rap стал широко распространенным в hip-hop. Dirty South поровну позаимствовал элементы из альбома The Chronic и вульгарные традиции у команды 2 Live Crew. Это привело к появлению кайфового, вульгарного, помешенного на сексе и (естественно) богохульного брэнда modern hip-hop. Этот стиль получил свое название от одноименной композиции Goodie Mob (1995 г.). Именно этот музыкант совместно с Outkast составлял костях лучших исполнителей этого жанра, их музыка и тексты были более резкими и пронзительными, чем у таких современников, как No Limit.\r\n'),
(75, 'Disco', 'Disco ознаменовало расцвет популярной музыке, взявшей за основу dance. Этот стиль появился из звучания раннего funk и disco 70-х годов, где, прежде всего, подчеркивался ритм, он был важнее исполнителя и песни. Disco получил свое название от слова дискотека. Так назывались клубы, которые не играли ничего кроме танцевальной музыки. В Нью-Йорке большинство дискотек представляли собой гей-клубы, а DJs в этих клубах особенно часто играли soul и funk с тяжелым ритмом. После исполнения в disco формате, записи получали радио эфиры и хорошо продавались. Вскоре звукозаписывающие компании и продюсеры стали нарезать пластинки, созданные специально в стиле disco. Естественно, что эти записи имели очень заметные pop элементы, поэтому им был обеспечен успех. Disco альбомы довольно часто не содержали много треков обычно несколько длинных композиций с повторяющимся ритмом. Эти синглы выпускались на 12-дюймовых пластинках, что оставляло много места для расширенных ремиксов. DJs могли микшировать эти треки, согласовывая бит на каждой композиции. Очень быстро активный disco beat занял доминирующую позицию в pop чартах. Буквально все стали играть disco, от таких рокеров, как Rolling Stones и Rod Stewart до поп исполнителей, как Bee Gees и музыкантов новой волны, как Blondie. Некоторые disco исполнители стали звездами Donna Summer, Chic, Village People и KC & Sunshine Band. но эта музыка была в основном средством самовыражения композиторов/продюсеров, потому что они создавали треки и записывали композиции. Disco пришло в упадок на стыке 70-х и 80-х годов, но этот стиль не умер он просто трансформировался в целый ряд танцевальных жанров, варьируемых от dance-pop и hip-hop до house и techno.\r\n')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(76, 'Disco House', 'Disco House заимствуется от классики '' 70-ых Disco и Funka. Disco House, подвержен боль-шому изменению от текущей атмосеферы в музыке, обычно с сильными петлями, заводящими мелодиями и удобными дружественными отношениями. В Англии этот стиль музыки называется Tesko - это гибрид Disco и Techno.Наглядный пример этого проект X-Press-2, их звук называют помесью Disco и Rave - Rave Music. Признаки: Tesko использует стиль Disco, House ритмы и Techno осуществление. От 120 до 130 BPM. Примеры: X-Press-2,Ming''s Incredible Disco Machine,Cotton Club и большинство выпусков Stress и Whizz лейблов.\r\n'),
(77, 'Downbeat', 'Downbeat - это родовое понятие, используемое иногда для замены названий ambient-house и ambient-techno. Нужно отметить то, что объем и сложность электронной музыки в стиле \"ambient\" практически вытеснили этот термин из употребления к середине 90-х годов. Это название часто подразумевает использование умеренных breakbeats вместо постоянных four-four beats, предпочитаемых большинством исполнителей ambient-house и ambient-techno. Этот стиль также совмещает в себе элементы by trip-hop, ambient-techno и electro-techno. В самом широком определении, downbeat - это любая форма электронной музыки, предназначенной для прослушивания, а не для танцпола.\r\n'),
(78, 'Drill''n''bass', 'Вскоре после того, как британские techno музыканты, такие как Aphex Twin и Squarepusher стали заниматься стилем drum''n''bass в середине 90-х, они, естественно, изменили его под себя. В результате Drill''n''bass, недалекая форма breakbeat jungle, которая базировалась главным образом на мощном компьютерном звуке и кропотливом программировании, - превратила старые midtempo beats and breaks в сумасшедшую экспериментальную нарезку электронной музыки, обращающей на себя мало внимания. Начиная с середины 1995г. , три основных лидера возглавили направление с пластинками : Aphex Twin (Hangable Auto Bulb), Luke Vibert''s Plug project (Plug 1) и Squarepusher (Conumber). В следующем годы стиль drill''n''bass завоевал признание, вышли полные версии вышеуказанных альбомов. Особенно нужно отметить Plug''s Drum''n''bass for Papa и  дебютный альбом Squarepusher Feed Me Weird Things. После этого стиль оказался на волне успеха, появилась группа музыкантов, играющих в этом стиле, включая Animals on Wheels, Amon Tobin, Mung, and Plasmalamp. Drill''n''bass перешел в глубокий андеграунд к 1998г., и это было не удивительно, принимая во внимание экстремальную природу стиля.\r\n'),
(79, 'Downtempo', 'Последователи направления Downtempo обращают большое внимание на битовое наполнение (ритм), чем ambience, но музыка не такая приземленная, как trip-hop.\r\n'),
(80, 'East Coast Rap', 'Всамом начале hip-hop эры, весь rap принадлежал направлению East Coast Rap. Все популярные rap исполнители раннего периода берут начало в районе New York City легенды старой школы, такие как DJ Kool Herc, Grandmaster Flash, Afrika Bambaataa, the Sugarhill Gang, Kurtis Blow и Run-D.M.C. По мере развития и продвижения rap стиля, он становился более разнообразным и многоликим в течение 80-х годов, поэтому музыкальные центры стали появляться по всей стране. Но, тем не менее, направление East Coast rap оставалось доминирующим на протяжении 80-х годов. Хотя звучание East Coast rap не было полностью однородным, но, начиная с середины и до конца 80-х годов, этот стиль тяготел к более агрессивным битам и комбинациям сэмплов, а многие рэперы гордились своим техническим профессионализмом в отношении текстового наполнения. Другими словами, за редким исключением, East Coast rap стал музыкальным стилем, предназначенным больше для напряженного слушателя, чем для танцпола, что помогло превратить этот жанр в уважаемую художественную форму, более продуманную и комплексную. Типичными представителями этой золотой эры East Coast были такие исполнители, как Eric B. & Rakim, Boogie Down Productions и Slick Rick, все из которых отличались лирическим направлением, присущим old-school стилю, а также тяжелым звучанием EPMD и Public Enemy. На основе East Coast начинала свое творчество позитивная команда музыкантов Центральной Африки Native Tongues, собранная Afrika Bambaataa. Такие группы, как De La Soul, A Tribe Called Quest, the Jungle Brothers большинство других нью-йоркских команд оказали основное влияние на hip-hop в конце 80-х годов, так как их можно было без труда отличить скорее по музыкальной эклектике, чем по географическому расположению. В 1989 г. команда N.W.A. выпустила альбом Straight Outta Compton, ставший свидетельством тому, что West Coast (район западного побережья) ужесточил свой звук и продолжал работать с резкими, уличными темами, а в сочетании с возможностью West Coast rap сохранять основную функцию этого звука, как party music, - помогло сделать это направление доминирующей силой в hip-hop в 90-е годы. Дальнейший подъем Southern rap показал, что направление East Coast rap не могло больше оставаться главенствующим, но 90-е годы были ознаменованы успехом в этом регионе. В дополнение к Bad Boy, звукозаписывающей компании, принадлежащей Puff Daddy и приносящей огромные доходы, восточное побережье (East Coast) выпустило на сцену целый ряд непохожих друг на друга, но очень популярных музыкантов, включая виртуозного лирика Nas, электронных Fugees and Roots, а также команду Wu-Tang Clan, на которую большое влияние оказал hardcore.\r\n'),
(81, 'Electro', 'Смешение funk 70-х, зарождающейся hip-hop культуры и электронных технологий (синтезатор) в начале 80-х годов привело к появлению нового альтернативного стиля музыки - Electro. Но то, что публике казалось всего лишь приходящим увлечением, причудой 2-3 хита, не больше, включая композиции Afrikaa Bambaataa (\"Planet Rock\") и Grandmaster Flash (\"The Message\"), не одна из которых не вошла в чарт Top 40 на самом деле стало хорошим трамплином для музыкантов-наваторов, которые позднее стали создателями радикально отличающихся направлений в музыке, включая Dr. Dre (он работал с the World Class Wreckin'' Cru) и крестного отца techno Juan Atkins (при участии Cybotron). Стиль Electro также привнес еще одно интересное направление для одного из первых его поклонников: Herbie Hancock, его альбом 1973 г. Headhunters с fusion хитом вновь возродился в 1983г. с синглом \"Rockit\", выполненном в этом стиле. Несмотря на большой успех (в этом стиле выполнен альбом Rhino Electric Funk на 4 дисках), стиль был быстро вытеснен в середине 80-х годов с появлением hip-hop движения, построенного скорее на сэмплах (часто рок-композиций), чем на линии синтезатора. Тем не менее, многие techno и dance музыканты продолжали возвращаться к такому звуку, а полномасштабное возрождение electro произошло в Детройте и Великобритании в середине 90-х г.\r\n\r\n'),
(82, 'Electro-Industrial', 'Исполнители, работающие в стиле Electro-Industrial стали заметными фигурами в музыке, благодаря отказу от использования thrash гитар, которые доминировали в таких industrial группах, как Nine Inch Nails и Ministry. Команды, включая Cubanate, LeФtherstrip, :wumpscut:, Haujobb, Kill Switch...Klick и Mentallo & the Fixer больше концентрировались на эксперементальной и электронной стороне музыки в стиле industrial, выделяя влияние таких первопроходцев этого направления, как  Throbbing Gristle, Cabaret Voltaire и Front 242, вместо надоевших  Black Sabbath. В США студия Metropolis Records известна работой в стиле electro-industrial.\r\n'),
(83, 'Electro-Jazz', 'Electro-Jazz - один из вариантов fusion, подчеркивающий партии синтезатора и тяжелые фанки ритмы.\r\n'),
(84, 'Electro-Techno', 'Electro-Techno попало под влияние событий в музыкальной культуре 80-х годов, связанных с направлением electro-funk, а также Detroit techno и элементов ambient-house. Этот стиль появился в середине 90-х, когда лондонские клубы были наводнены композициями в возвратившемся стиле electro в сочетании с нашествием роботов и голосов, обработанных различными эффектами речи. Этот стиль черпал вдохновение из классических представителей electro, таких как Afrika Bambaataa''s \"Planet Rock.\" На самом деле это преходящее увлечение возглавляемое студией Clear Records и такими музыкантами, как Jedi Knights, Tusken Raiders и Gescom (псевдонимы Global Communication, Ziq и Autechre соответственно) прошло довольно быстро, дав начало отличным музыкальным направлениям, появившимся во вторую половину конца 90-х годов, включая работу британских студий Skam Records, Sweden''s Dot Records, а также детройткских Drexciya и Aux 88, расположенных ближе всех к первоначальному источнику происхождения этой музыки.\r\n'),
(85, 'Electronica', 'Этот стиль завоевал сердца ди-джеев, игравших disco и funk в далеких 70-х годах, направив их на использование разных примочек для создания электронных композиций. Очень скоро Electronica стала целым отдельным направлением в музыке, давшим начало новым звукам и субжанрам. Огромный потенциал этого стиля проявился в течение прошедших 2 десятилетий. Основатели этого направления были выходцами из культуры пост-диско, развивавшейся в Чикаго/Нью-Йорке и Детройте. Именно в этих городах зарождались house и techno (соответственно) в 80-х годах. Уже в конце 80-х завсегдатаи британских клубов плотно подсели на смешении механического и чувственного начала, возвратившись к стилям, которые были предложены голодными янками, таким как jungle/drum''n''bass и trip-hop. Хотя изначально большинство электронных композиций были танцевальными, к началу 90-х, продюсеры начали делать музыку для слушателей. Так стали появляться десятки стилистических синтезов (так называемых фьюжн), как, например, ambient/house, experimental techno, tech-house, electro-techno, и т.д.. Для всех новых музыкальных стилей, образовавшихся на базе электронной музыки, было типично создание танцевальных композиций и свободная структура (если она вообще присутствовала). В большинстве случаев в основе лежит неослабевающее желание найти новое звучание, вне зависимости от получаемых результатов.\r\n\r\nКак было сказано выше, Electronica, довольно неопределенный термин, который используется для описания электронной танцевальной музыки, скорее обозначал музыку, направленную на слушателя, чем на узкий dance. Слово Electronica впервые использовалось в качестве названия для сборников (на самом деле они назывались New Electronica), которые выделяли первых исполнителей Detroit techno, таких как Juan Atkins и Underground Resistance на ряду с европейскими музыкантами, которые многое позаимствовали от футуристической версии для techno от Motor City. Позднее американская пресса начала использовать этот термин для универсального обозначения любого молодого музыканта, использующего электронное оборудование и/или инструменты, но electronica служит для обозначения музыкальных стилей на базе techno, которые подходят для домашнего прослушивания и выступлений на танц-поле (так как многие исполнители electronica стали клубными DJs).\r\n'),
(86, 'Experimental Dub', 'На расстоянии тысяч миль от солнечной Ямайки, команда берлинских музыкантов изобрела стиль музыки, получивший название Experimental Dub. Hard Wax Records, музыкальный магазин и дистрибьюторская компания, стала местом появления нескольких студий, работающих в этом стиле (Basic Channel, Chain Reaction, Imbalance) и музыкантов (Maurizio, Mark Ernestus, Porter Ricks, Pole, Monolake). Музыканты в этом стиле, такие как Jeff Mills, Rob Hood, and Plastikman во многом обязаны влиянию Chicago acid house  и минималистского Detroit techno. Еxperimental dub характеризовался довольно просто - звук обычно фокусировался на миксе скрипящего и мрачного настроения, который создавал практически подводное звучание, плюс midtempo beat и резкие партии ударных. В лучшем случае сходство с классическим стилем Jamaican dub таких музыкантов, как King Tubby и Lee \"Scratch\" Perry, было косвенным, но данный термин помогал различать оригинальный звук многих лучших экспериментаторов Германии. Кроме команды Basic Channel camp, лучшими в стиле experimental dub были Mike Ink (aka Wolfgang Voigt) и Thomas Brinkmann. Ink берлинский музыкант, выступавший под более чем 6 псевдонимами. В основном он работал с такими звукозаписывающими компаниями, как Profan и Studio 1. Brinkmann, сравнительно недавно начавший работу в этом стиле, снискал славу, благодаря ремиксов на музыку Ink и Plastikman. Стиль Experimental dub, в свою очередь вдохновил нескольких ведущих представителей techno культуры (включая Plastikman и Mills) в конце 90-х годов, его влияние можно даже проследить в направлениях American indie rock и post-rock.\r\n'),
(87, 'Experimental Ambient', 'Сфера Experimental Ambient , распространившаяся на копирование ambient композиторов от Tod Dockstader до Brian Eno, в совершенно неожиданных и разнообразных направлениях, охватывает широкий спектр музыкальных личностей. Этот стиль варьируется от этнических напевов (Robert Rich, Vidna Obmana) и музыки к кинофильмам (Paul SchЭtze, Lustmord) до white noise (K.K. Null, Main) и post-punk experimentation (Rapoon, :zoviet*france:). Experimental Ambient проник во многие музыкальные жанры, включая new age, electronic dance, jazz и саундтреки.'),
(88, 'Experimental Electro', 'Свозрождением классического стиля electro, названного движением neo-electro, пришла волна музыкантов Experimental Electro с более абстрактным представлением о музыке. Это направление все еще испытывало на себе влияние уличного звука, но в более профессиональном виде в отношении студийной работы. Стиль характеризуют такие имена как Freeform и Bisk.\r\n'),
(89, 'Experimental Techno', 'Всфере электронной танцевальной музыки существует бесконечные возможности для эксперимента, поэтому направление Experimental Techno имеет широкий спектр разнообразных стилей от неправильного включения диска и скретча, продемонстрированных европейскими экспериментаторами Oval и Panasonic, до беспорядочных эффектов (но с точной ритмической линией), предложенных Cristian Vogel, Neil Landstrumm и Si Begg. К направлению Experimental Techno можно также причислить музыкальных террористов, таких как Twisted Science, Nonplace Urban Field и Atom Heart, а также цифровых панков как Alec Empire, и бывших поклонников Industrial (которые появились с новым имиджем), как Scorn, Download или Techno Animal. Любой музыкант, стремящийся найти себя в электронной танцевальной музыке, которой он никогда не занимался, может быть назван экспериментатором, в любом случае таких музыкантов достаточно много.'),
(90, 'Experimental Jungle', 'Смешение experimental techno и drum''n''bass breakbeats. Еxperimental jungle - это стиль определенно не предназначенный для танцпола. В основном музыканты в стиле Experimental Jungle склоняются  либо к авангарду (avant-garde) (Twisted Science, T.Power, Richard Thomas), либо к indie rock (Third Eye Foundation, Designer).\r\n'),
(91, 'Freestyle', 'Это направление часто развивалось совместно с такими современными стилями, как electro и house. Freestyle зародился в двух латино-американских столицах New York City и Miami в начале 80-х годов. Такая классика Freestyle, как \"I Wonder If I Take You Home\" от Lisa Lisa & Cult Jam, \"Let the Music Play\" от Shannon и \"Party Your Body\" от Stevie B была выполнена на базе угловатых синтезаторных битов, похожих на electro и ранний house, однако, также использовались романтические темы, отраженные в классическом R&B и disco. Смешение механической музыки и чувственных текстов стало залогом успеха, поэтому хиты в исполнении Shannon и Lisa Lisa занимали верхние строчки Top 40 в 1984-85 гг. Freestyle прекрасно сочетался с dance pop в период его расцвета в середине 80-х годов автор музыки и ранних ремиксов Madonna - John Benitez (aka Jellybean) также играл активную роль в развитии freestyle. К концу десятилетия целый ряд исполнителей Brenda K. Starr, Trinere, Cover Girls, India и Stevie B перешел со своими композициями в pop или R&B чарты. Даже после угасания популярности в конце 80-х годов, freestyle перешел в underground в качестве ведущего направления современной танцевальной музыки наряду с house, techno и bass music. Как и в случае с mainstream house, исполнители freestyle - это обычно (хотя, естественно, не всегда) женские вокальные коллективы или композиторы-мужчины. Новые фигуры, такие как Lil Suzy, George Lamond, Angelique, Johnny O и другие стали крупными звездами в культуре freestyle.\r\n'),
(92, 'Foreign Rap', 'Foreign Rap - это hip-hop с rap вставками на любом языке, кроме английского и испанского. В основном, направление foreign rap имеет европейские корни. Эта музыка напоминает Euro dance, а также American hip-hop. Этот стиль не такой жесткий, как American или British hip-hop, он выбирает путь наименьшего сопротивления, используя знакомую технику, вместо поиска совершенно новых возможностей. Знаменитым исключением из этого правила стал jazz-rap, который, как и European hip-hop подвергся значительному влиянию со стороны английских acid house и acid jazz. Позднее все эти наработки были собраны в европейском hip-hop.\r\n'),
(93, 'Funky Breaks', 'Смесь trance, hip-hop и jungle, стиль Funky Breaks, благодаря своей популярности,  стал одним из самых широко распространенных стилей электронной музыки среди тех, кто хотел поднять шумиху в поп чартах и ТВ клипах в конце 90-х. Пионерами этого стиля стали the Chemical Brothers плюс James Lavelle (студия Mo'' Wax Records), но funky breaks действительно набрал обороты в 1997г. В этом году эксперты музыкальной индустрии предсказывали окончательный прорыв направления new electronica. Среди лидеров, возглавивших эту музыкальную революция, почти все the Prodigy, Death in Vegas, the Crystal Method, Propellerheads создавали элементы этого стиля. Это также стало основной причиной поражения electronica революции, по крайней мере в коммерческом плане, так как все раскрученные музыканты играли одинаковую музыку.\r\n'),
(94, 'Funk', 'Funk родился в 1970-ых годах под влиянием \"черных\" музыкальных традиций (джаза и соула). Первоначально Funk игрался только вживую, позднее - с использованием современных технологий. Темп фанка относительно невысок - 80-110 bpm. Эта музыка имеет довольно много разновидностей, подобных Jazzy-Funk. Их объединяет так называемое \"Funky-настроение\", которое они создают. Определить термин Funky практически невозможно. Для того, чтобы его понять, вам просто необходимо послушать эту музыку. Надо отметить, что характерной чертой фанка являются Funky-инструменты: классическое фортепиано - при живом исполнении допускаются импровизации (наследие джаза), Funky-гитара - характерный подвывающий гитарный звук, так называемая щипковая техника звукоизвлечения, ритм-секция не акцентирована - часто (особенно в современном варианте) ритмический рисунок напоминает хип-хоп, часто встречается \"черный\" вокал, причем предпочтительно мужской и духовые инструменты : флейта, саксофон, тромбон, но применение духовых инструментах не столь часто, как в Acid-Jazz, их функция скорее вспомогательная.\r\n'),
(95, 'G-Funk', 'G-Funk - это спокойная (вдохновленная Parliament/Funkadelic) версия gangsta rap, которая развивалась при помощи Dr. Dre в начале 90-х годов. Это направление отличалось жалобными, дешевыми синтезаторами, медленным ритмом, глубокими басами и редким безликим женским бэк-вокалом. Направление G-funk стало самым популярным жанром hip-hop в начале 90-х годов. После успеха альбома Dr. Dre The Chronic в 1992 г. в этом альбоме музыкант придумал и назвал новый жанр многие новые rap исполнители и продюсеры стали повторять его музыкальную технику, что в результате сделало G-Funk самым узначаемой rap музыкой начала 90-х годов.\r\n'),
(96, 'Gabba', 'Наибольшей популярностью этот стиль пользовался в Голландии и Шотландии. Gabba  - самая тяжелая форма hardcore techno, часто ритм превышает 200 BPM. Популярные DJs и продюсеры, такие как Paul Elstak и Mover утверждают, что gabba появилась из немецкого trance и британского rave. К середине 90-х, эта музыка приобрела несколько неприятный подтекст, связанный с неофашизмом и движением бритоголовых (скинхэдов), хотя при этом большая часть музыкантов не поддалась этому влиянию. Удивительно, но gabba успешно зарекомендовала себя в голландских чартах поп-музыки, представив несколько хитов от Elstak. Многие музыканты и фанаты обозвали его продажным изменником, и вскоре музыкальная арена разделилась на hardcore и настоящий (реальный) hardcore.\r\n'),
(97, 'Garage Rock', 'Garage Rock был простой, необработанной формой rock & roll, которую создали несколько американских команд в середине 60-х годов. Вдохновителями служили такие крутые команды British Invasion, как Beatles, Kinks и Rolling Stones. Эти группы Среднего Запада играли вариации на тему British Invasion rock. Так как обычно это были молодые и непрофессиональные музыканты, то результаты более дилетанскими по сравнению с мэтрами, но именно это поддерживало существование звука. Большинство групп делало акцент на любительский стиль, играя всё те же три аккорда, сильно ударяя по струнам гитар и предлагая рычащий вокал. В большей степени команды в стиле garage составили первую волну punk рокеров сделай себя сам. Затем по всей Америке стали появляться сотни garage групп, и значительная их часть, включая Shadows of Knight, Count 5, Seeds, Standells, записывали настоящие хиты, а остальным была уготована безызвестность. На самом деле, практически все эти группы были забыты еще в начале 70-х годов, но сборник композиций Nuggets (Самородки) возродил их жизни. В 80-х годах наблюдалось настоящее возрождение стиля garage rock, которое ознаменовалось целым рядом музыкальных групп, которые пытались точно воспроизводить звук, стиль и внешний вид garage команд 60-х годов.\r\n'),
(98, 'Gangsta Rap', 'Gangsta Rap начал своё развитие в конце 80-х годов. Это направление берет начало в hardcore rap. Стиль gangsta rap отличался жестким, шумным звуком. В лирическом отношении он был таким же резким, как и грубые небылицы рэперов о городских непорядках. Иногда тескты отличались точным отображением реальности, а иногда это были просто наполненные преувеличениями комиксы. В любом случае это направление стало самым успешным в коммерческом отношении в истории развития hip-hop с конца 80-х до начала 90-х годов. В процессе своего становления gangsta rap стал причиной значительных разногласий, так как некоторые консервативно настроенные организации пытались запретить распространение альбомов этих музыкантов. Даже тогда, когда группы активистов вытеснили несколько команд из лидирующих звукозаписывающих компаний, они продолжали создавать нецензурную музыку.\r\n'),
(99, 'Glitch', 'По мере того, как компьютерная музыка медленно вытесняла традиционный аналоговый подход к созданию музыки в стиле electronica, палитра возможных звуков вскоре приобрела огромные размеры, - а это стало причиной появления стилей clicks + cuts в конце 90-х годов. Ни один музыкант больше не ограничивался последовательной партией барабанов, синтезаторов и сэмплами, а использовал все вообразимые звуки, включая сверхъестественные цифровые навороты. Такая цифровая возможность быстро нашла применение среди молодого поколения и позволила им создавать целый альбомы в домашних условиях, используя только компьютер и нужное программное обеспечение. Когда в начале 90-х годов аналоговые пионеры, такие как Aphex Twin и Autechre предвидели быстрое развитие стиля electronica, а  другая немногочисленная группа пионеров во главе с Robert Hood и Basic Channel параллельно отказывалась от элементов electronica, которые стали бесцветными клише, - началась вторая волна компьютерной музыки, использовавшая программное обеспечение для создания сложных композиций, похожих на творчество этих старых мастеров. Сначала это направление возглавил идеолог немецкого techno Achim Szepanski и его группа звукозаписывающих компаний Force Inc, Mille Plateaux, Force Tracks, Ritornell . Эта взаимосвязанная компания экспериментальных музыкантов, создававших интеллектуальные гибриды из experimental techno, minimalism, digital collage и noise glitches, вскоре превратилась в целое общество. Хотя такие музыканты, как Oval, Pole и Vladislav Delay, изначально выделялись критиками из общего потока людей, но эпический сборник Mille Plateaux Clicks_+_Cuts впервые определил это движение андеграунда, покорившее не только большое число музыкантов, но и имеющее широкий спектр различных подходов. Музыканты, вошедшие в этот сборник, наряду с небольшой группой visionary исполнителей из продвинутого в компьютерном смысле San Francisco/Silicon Valley (Силиконовой Долины) в California (студия Cytrax), вскоре стали лидерами другого движения electronica. Затем направление clicks + cuts стало поддаваться влиянию существующих жанров, что в конце вылилось в бесконечные варианты музыки, такие как  click-driven house от MRI и glitch ремикс N.W.A.''s \"Straight Outta Compton.\" от Kid-606.'),
(100, 'Go-Go', 'Go-Go - это был утяжеленный басами вариант hip-hop, предназначавшийся для house вечеринок. Лирического содержания в направлении go-go было немного, но основным посылом служит бит, а не слова. В середине 80-х годов go-go был очень популярен в среде rap и R&B анденраунда, особенно в районе Округа Колумбия (DC), который считается родиной этого направления. Хотя при этом go-go никогда не имел ничего общего с успехом на pop арене - самое близкое приближение к этому рубежу было отмечено в 1988 г., когда команды в стиле go-go, EU совместно с Trouble Funk, сыграли скромный хит вместе с \"Da Butt,\" (Spike Lee''s School Daze). В конце 80-х годов и начале 90-х go-go был вытеснен со сцены басовой музыкой Miami, которая воспользовалась тяжелыми методами и DJ ориентацией go-go, взвинтила басы и вновь обратилась к музыкальной лирике.\r\n'),
(101, 'Goa/Psychedelic Trance', 'История стиля Гоа весьма замысловата. Несколько десятилетий назад этим термином называли стиль музыки, которую исполняли в местечке Гоа в Индии. Европейские музыканты, вдохновленные индийской философией, культурой и эстетикой, попытались выразить свои чувства в музыке и назвали стиль так же Гоа. Постепенно понятие Гоа-Транса несколько расплылось многие музыканты, берущие в качестве эталона сделанные последователями индийской культуры Гоа-транс треками, начали ваять собственные творения, ни на дюйм не пытаясь углубиться в корни настоящей Гоа-музыки. Гоа-трансом стали называть музыку, произведенную кем попало. Постепенно стили все-таки разделили из всей этой псевдо-Гоа музыки выделили отдельный пласт под названием Psychedelic Trance. Происхождение Psychedelic Trance Британские острова, впоследствии этот стиль распространился в Германию, Голландию, Данию и остальные страны Западной Европы.\r\n\r\nЧто такое Гоа-Транс? Это мягкий стиль. Здесь нет жесткого бита. Основа Гоа мелодика и гармония. Psychedelic включает в себя также замысловатые синтезаторные линии, трансформирующиеся, порой острые и яркие, звуки, ассоциирующиеся с hi-tech/space стилистикой. В обоих стилях нет тяжелого баса, хотя встречаются добавки из пульсирующего сверхнизкого баса. Под эту музыку можно медитировать, можно танцевать, можно размышлять. Goa/Psychedelic Trance это не чистый танцевальный стиль, это сложная компиляция из разных стилей и концепций, из эзотерики.\r\n\r\nТрадиционные индийские инструменты, такие как ситар и садор (или их электронные аналоги) часто использовались при создании музыки в сочетании с сильным, гипнотическим синтезатором, которым всегда славился trance. Это стиль значительно меньше подходит для работы ди-джеев и виниловых пластинок, чем другие электронные танцевальные стили (вместо винила часто использовался DAT). Поэтому стиль Goa до конца 90-х годов располагал сравнительно небольшим количеством DJs, пропагандировавших его по всему миру. Такие звукозаписывающие компании как Dragonfly, Blue Room Released, Flying Rhino, Platipus и Paul Oakenfold''s Perfecto Fluoro стали важным источником появления нового музыкального материала. Самый популярный английский DJ Oakenfold, наконец, обеспечил Goa trance большим числом поклонников, которых так не хватало на протяжении нескольких лет. Он раскрутил эту музыку в радио эфире и в клубах по всей стране. В Британии (Return to the Source) Goa trance также был хорошо принят, студия выпустила три сборника лучшей trance музыки.\r\n\r\nЛейблы: Perfecto Fluoro, Tip Records, Symbiosis Records, Flying Rhino, Blue Room, Transient.\r\n'),
(102, 'Golden Age', 'Золотой век Hip-hop ознаменован коммерческим прорывом Run-D.M.C. в 1986 г. И взрывным успехом направления gangsta rap с альбомом The Chronic от Dr. Dre. (1993 г.) Эти шесть лет были отмечены лучшими записями от самых крупных рэперов в истории этого жанра LL Cool J, Public Enemy, EPMD, Big Daddy Kane, Eric B. & Rakim, N.W.A., Boogie Down Productions, Biz Markie. Подавляющее большинство музыкантов, работающих в этом стиле, находятся в New York City, а сам golden-age rap характеризуется основным набором битов, переписанными сэмплами из hard-rock или soul треков и жесткими dis raps. Такие авторы рифмовок, как PE''s Chuck D., Big Daddy Kane, KRS-One и Rakim заложили основу сложных каламбуров (игры слов) и текстов позднего hip-hop. Звукозаписывающая компания Def Jam стала первой крупной независимой hip-hop студией, в то время как Cold Chillin'', Jive и Tommy Boy также добились больших успехов.\r\n')";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_style` (`id`, `name`, `valid`) VALUES
(103, 'Gospel', 'Считается, что выражение \"музыка госпел\" ввел в обиход популярный в двадцатые годы исполнитель блюза Томас Э. Дорси, одним из первых аранжировавший церковные песнопения \"под популяр\". Поначалу музыка была категорически отвергнута, однако ее приняли в неортодоксальных черных общинах, и с той поры госпелз развивался бок о бок со светской черной музыкой, хотя данное направление всегда отличалось консерватизмом, и функционально имеет другие задачи. Вокальный стиль госпелз своими корнями уходит в спиричуэлз и основан на декламировании баптистских молитв. Вокальные группы госпелз, сложившиеся в сороковые-пятидесятые годы - в таких группах всегда был ярко выраженный лидер он же ведущий вокалист, - по манере исполнения имели очень много общего с а-капелла и стилем ду-уоп, получившем распространение также в пятидесятые годы. Среди исполнителей госпелз, получивших образование в церковных хорах, следует назвать Сэма Кука и Клайда Макфаттера - именно они способствовали проникновению госпелз в поп-музыку. Триумфальный взлет соул в шестидесятые годы стал возможным благодаря лишь таким преуспевшим в госпелз певцам, как Арета Фрэнклин, Уилсон Пикетт и Соломон Берк. Характерный саунд госпелз - резкие выкрики певцов и рокочущий орган, с многочисленными рефренами - сегодня можно услышать в музыке исполнителей, казалось бы, не имеющих ничего общего с этим стилем, от Рэя Чарлза, Стиви Уандера и Кита Джаррета до Рэнди Ньюмена, Вэна Моррисона и Стинга.\r\n'),
(104, 'Happy Hardcore', 'Постепенно выходивший на сцену в конце 80-х начале 90-х, стиль Happy Hardcore, взял за основу английский рейв и имел большинство элементов, характеризовавших сам рейв: очень большое число ударов в минуту (beats), высокий темп партий для синтезатора/пианино и вокальные сэмплы с обработками, создающими самую задушевную музыку, похожую на трель птицы. Движение jungle/drum''n''bass также вышло из стиля rave, но эти два направления разделились и начали развиваться отдельно. Позитивная направленность стиля happy hardcore подверглась критике со стороны многих посетителей клубов, как музыка, предназначенная для обкуренных подростков. Однако также как и появление смешенного стиля hardcore-into-jungle в конце десятилетия нашло одобрение критиков, так и happy hardcore добился признания. Совместная работа DJ/музыкантов, таких как Slipmatt, Hixxy & Sharkey, Force & Styles , DJ Dougal, позволила создать большое количество сборников и, естественно, сольных пластинок.'),
(105, 'Hard Blues', 'Это довольно условный термин, описывающий особенности стилистики того или иного произведения рока. Жесткое, мелодически \"тонированное\" произведение, основанное на солирующей гитаре, как правило называют хард-блюзом. Хотя любой блюз, сыгранный в агрессивной атакующей манере, уже можно назвать хард-блюзом. Как таковой, хард-блюз часто встречается в композициях групп хард-рока, однако назвать группу или музыканта, который играл бы исключительно хард-блюз, затруднительно. Наиболее заметен хард-блюз в произведениях Гэри Мура, а также позднего Бадди Гая.'),
(106, 'Hard House', ''),
(107, 'Hard IDM', 'Основной отличительной чеpтой данного напpавления являются тяжелые пеpегpyженные и pваные yдаpные звyки в pитмах композиций. Ритмы в своей основе так же строятся на бpейках и сбивках. Ритм в такой музыке всегда пpеобладает над мелодией, если конечно мелодия вообще пpисутствует в композиции. А мелодия в пpивычном понимании этого слова, пpисyтствyет очень pедко. Так вот если она пpисyтствyет, то где-то в далеке от pитма, на заднем плане. А так чаще всего мелодическая часть тpека состоит из свистов, пеpегpyженных скpипов, гpемящих железок, гpомких бyльканий и пpочих шyмов. Шyмы обычно пpименяются синтезиpованные, либо сильно обpаботанные живые. Главное - чтобы в композиции как можно больше всего тpещало и свистело, а повеpх этого стyчал не менее тpещащий и бyхающий ломаный pитм. Самые яpые любители IDM считают такyю мyзыкy как pаз самой танцевальной мyзыкой на свете.\r\n'),
(108, 'Hardcore', 'Хардкор родился во время, когда клубная хаус-культура достигла апогея своего развития, как раз перед тем, как стать массовой. Этот стиль был выкован британскими ди-джеями, когда клабберы требовали настоящего непрекращающегося угара. Электронные кудесники создали самый жесткий и быстрый стиль и назвали его Hardcore. Фактически, этот стиль является потомком техно. В хардкоре используется очень тяжелая искаженная прямая бочка, долбящая со скоростью от 150 до 180BPM. Конечно, с тех пор хардкор довольно сильно изменился, появилось множество ответвлений Happy Hardcore, Speedcore, Gabber. Сейчас потихоньку возвращается мода на старый, оригинальный хардкор правда, новый старый хардкор звучит все равно не так, как звучал в начале 90-х. Новые хардкор-композиции относятся к так называемому old school hardcore.\r\n\r\nHappy Hardcore отличает применение простеньких пианинных пассажей и ускоренных в несколько раз сэмплов женского вокала и является попсовым фронтом всего стиля. Существует также специальная UK-версия Happy Hardcore: в ней применяются брейкбитовые ударные и множество музыкальных инструментов, которые нельзя услышать в обычном hardcore.\r\n\r\nСуществует также Нидерландское ответвление: Holland Hardcore гораздо более лиричный в проигрышах и более жесткий в ритме.\r\n'),
(109, 'Hardcore Rap', 'Вто время как этот термин может относиться к нескольким музыкальным направления, Hardcore Rap отличается конфронтацией и агрессией, как в лирическом смысле, - это тяжелый, двайвовый бит, шумные сэмплы и звукозапись, так и в любых других сочетаниях. Hardcore rap - это жесткий, уличный, напряженный и часто угрожающий стиль (хотя последний эпитет не всегда имеет место, здесь также найдется место для юмора и ярких красок). Стиль Gangsta rap наиболее близко взаимосвязан с hardcore rap, но не вся суть hardcore rap заключена в темах, принадлежащих gangsta, хотя при этом нельзя не отметить большое количество совпадений, особенно по части hardcore рэперов 90-х годов. Впервые hardcore rap появился на восточном побережье (the East Coast) в конце 80-х годов, когда музыканты начали отходить от клубных ритмов. Музыка и слова стали больше отражать зачастую жесткую окружающую среду города, в которых она обычно создавалась и исполнялась. До изобретения специфической формулы для направления gangsta rap такие музыканты, как Boogie Down Productions (Нью-Йорк) и Ice-T were (Лос-Анджелес) в своем творчестве создавали подробные описания ежедневной уличной жизни. Плюс к этому, хаотичные звуковые комбинации в исполнении Public Enemy устанавливали новые стандарты в звукозаписывающей индустрии, а команда N.W.A. отметила мрачность образа жизни ghetto и gangsta появлением энергичного мужского начала. В начале 90-х годов hardcore rap стал синонимом направления West Coast gangsta rap. Это продолжалось до появления в 1993г. Wu-Tang Clan, чей свободный, минималистский бит, запоминающиееся трубы и синтезаторные сэмплы, стали широко подражаемыми. Резкие, уличные звуки hardcore rap помогли ему стать самым популярным стилем, сочетающим в себе элементы hip-hop в последней половине 90-х годов. Его основа сегодня это частичное сочетаний клубных мелодий, зацикленности на деньгах/ сексе/ насилии, присущей направлению gangsta и случайные социальные комментарии происходящего. Альбомы таких музыкантов, как знаменитые B.I.G., DMX и Jay-Z стали платиновыми по объемам продаж. А брэнд Master P, лежащий в основе gangsta-ориентированного Southern hardcore, также стал доходной коммерческой силой, даже в том случае, когда он не создавал фьюжн хитов на таком же уровне.\r\n'),
(110, 'Hip-Hop', 'Втерминологии rap музыки, Hip-Hop обычно относят к культуре рисующей на стенах домов, танцующей breakdance и крутящей винил в дополнение к рэповым рифмовкам окружающей музыку. Как музыкальный стиль, однако, hip-hop относится к типу музыки, которая создается, принимая во нимание все эти атрибуты. Так как направление вращалось на музыкальной сцене достаточно давно, чтобы иметь историю своего развития, то hip-hop команды стали оглядываться на творчество таких old-school мастеров, как MCs Kurtis Blow и Whodini, а также DJs Grandmaster Flash и Afrika Bambaataa. На самом деле последний всплеск популярности (Zulu Nation) произошел в конце 80-х годов вокруг двух самых известных hip-hop исполнителей - De La Soul и A Tribe Called Quest. В 90-е годы, когда произошел настоящий прорыв в rap музыке, десятки hip-hop музыкантов стали возвращаться к истокам old school (старой школы), включая таких андерграунд рэперов как Mos Def и Pharoahe Monch.\r\n'),
(111, 'Hardcore Techno', 'Самая быстрая и резкая форма танцевальной культуры - Hardcore Techno к середине 90-х годов покорила огромное число музыкантов, включая поклонников breakbeat, jungle, индустриального trance, цифрового punk и пародирующих рейверов. Впервые этот стиль появился в Великобритании на фестивале Summer of Love (Лето любви) в 1988 г. Хотя изначально саундтреки, игравшиеся на вечеринках в заброшенных складах, испытали значительное влияние со стороны среднего чикагского acid house, но чрезмерное употребление наркотиков позволило многим рейверам создавать убыстренные и сумасшедшие музыкальные формы. Многие DJs подбадривали разгоряченных слушателей, тем, что увеличивали темп house композиций, предназначенных для 33 об/мин. Авторы музыки шли в авангарде и сами делали семплы собственных записей. В 1991-92 музыка в стиле hardcore/rave заполнила радио- и телеэфир хитами таких команд как SL2'' (\"On a Ragga Tip\"), T-99'' (\"Anasthasia\") и RTS (\"Poing\"). В результате основные звукозаписывающие компании начали поставлять на рынок тяжелые версии попсовых новинок, таких как \"Go Speed Go\" (Alpha Team), \"Sesame''s Treat\" ( Smart E) и \"James Brown Is Dead\" ( L.A. Style). К 1993 британские музыканты (Rob Playford, 4 Hero и Omni Trio) начали активно развивать музыку в стиле hardcore techno взамен наскучившему breakbeat, позднее то, что у них получилось даст начало новому направлению музыки - jungle. Хотя нужно отметить, что сам hardcore затем преобразовался в более жесткие формы trance и gabba. \r\nВ середине 90-х большинство рейверов уже переросли танцевальную музыку или просто устали от этого звука. Хотя музыка hardcore/rave распространилась по многим районам Великобритании и континентальной Европы, большая часть лондонцев всё же отдавала предпочтение progressive house или зарождающемуся ambient techno. Отсутствие глобального распространения стилей, но вместе с тем довольно широкое проникновение звуковой формы в северные районы Великобритании, Шотландии, а также в крупные города Германии и Голландии всё это послужило плацдармом для появления различных стилей андеграунда. Здесь можно назвать всё - от цифрового hardcore в Германии (Alec Empire) до happy hardcore в Великобритании. На самом деле, название этого стиля стало своеобразным монстром к концу десятилетия.'),
(112, 'House', 'Этот стиль появился в середине 80-х в Чикаго. В эпоху безраздельного властвования диско, этот стиль был весьма вычурным и, безусловно, ультрамодным в весьма узких прогрессивных кругах. Стиль house был создан исключительно для танцев и создавался исключительно с помощью электронных музыкальных инструментов драм-машин и синтезаторов. \r\n\r\nСуществует несколько версий происхождения названия этого стиля. Одна из них гласит, что House назвали так в честь имени клуба Warehouse, в котором местные ди-джеи впервые начали микшировать музыку Kraftwerk с прямыми битами, сделанными на драм-машине. Хаус-музыка с тех пор сильно изменилась, в 90-х она стала наиболее актуальной и модной, на основе хауса родились десятки новых стилей, а хаус-композиции заняли свои лидирующие места в хит-парадах. Хаус несомненно, главный стиль 90-х. \r\n\r\nВам не нужно объяснять, как звучит хаус. Хаус-музыка не очень быстрая, порядка 130-140BPM, сопровождаемая абсолютно прямым битом (на каждый второй удар бочки наложен хлопок или snare), на каждой шестнадцатой доле звучит хэт. Вот и весь хаус. Современный хаус вернулся к корням и начал использовать множество элементов диско, так что под конец девяностых произошло настоящее возрождение этого стиля. Впрочем, оно стало не слишком торжественным из-за того, что в поп-культуре окончательно укоренился хип-хоп, а хаус ныне относится уже к стилю прошлого века.\r\n'),
(113, 'Hip-Hop/Urban', 'Музыка Hip-Hop и Urban появилась в конце 70-х годов, истории их развития часто переплетались. Направление Urban Soul вышел из мягких моделей Philly Soul и развлекательного disco. Urban также много (если не больше) позаимствовал и популярного стиля pop, как и у классического soul. Таким образом, благодаря пластам синтезатора, профессиональному музпроизводству и балладной ориентации, Urban Soul редко был похож на настоящий soul. Он звучал скорее, как pop, что и послужило одной из причин его доминирования в афро-американском музыкальном жанре 80-х годов. Некоторые музыканты, такие как Michael Jackson и Prince, оживили этот жанр, нарушив традиции, но большинство Urban музыкантов продолжало им следовать, - у кого-то получалось лучше (Luther Vandross), у кого-то хуже.\r\n\r\nК концу десятилетия стиль Urban стал в качестве эксперимента применять Hip-Hop новинки. Hip-Hop это обобщающий термин для обозначения rap и порожденной им культуры. Изначально rap был крайне простым, вокалисты читали его под scratch и барабанный бит, но по мере своего развития это направление усложнялось. Рэпперы в стиле Hardcore, такие как Run-D.M.C. и Boogie Down Productions, предпочитали использовать минимум бита и делать акцент на лиричности композиций, иногда добавляя партии hard-rock гитар. Они подготовили трамплин для появления Public Enemy, чьи резкие, политические ритмы и жесткий бит стали новаторскими в конце 80-х начале 90-х годов. К этому времени Urban вобрал в себя элементы Hip-Hop, выразившиеся в форме New Jack Swing направление музыки Urban soul с рэповыми ритмами. Более того, такие рэпперы как MC Hammer, Young MC и Vanilla Ice позволили себе смягчить острые края Hip-Hop, чтобы иметь возможность выпустить первые успешные синглы в стиле pop-rap. Некоторые rap группы, ответили на это с помощью gangsta (бандитского) rap. Команда N.W.A. использовала звук PE, но сделала главный акцент на карикатурных сценах насилия, секса, беззакония, но после раскола группы музыканты Ice Cube, Eazy-E и Dr. Dre начали сольные карьеры, а gangsta rap стал развиваться в интересном направлении. Под руководством Dre, gangsta приобрел раскатистый бит и тяжелый бас от Funkadelic. В звуковом отношении это было значительно менее конфронтационным, музыка Public Enemy, поэтому вскоре это звучание перешло в стиль Urban в исполнении таких музыкантов Mary J. Blige. Через несколько лет такие рэпперы, как Puff Daddy окончательно стерли границы между Hip-Hop и Urban soul, - эти два направления невозможно различить.\r\n'),
(114, 'Hard Trance', 'Hard Trance - вариант транса, отличающийся более тяжелой бочкой и более быстрым ритмом (145-165 bpm). В целом отличается от транса немного более жестким звучанием. Hаиболее характерный ранний хард-транс выходил в 1994 году на немецком лейбле HartHouse. Получил довольно широкое распространение в Англии и в континентальной Европе.\r\n\r\nСейчас хард-транс развивается по двум направлениям: одно из них приближено к хэппи и представляет собой незамысловатую позитивную, энергичную танцевальную музыку. Второе содержит больше элементов Acid и Techno и отличается более жестким и агрессивным звучанием.\r\n')";

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
(1, '1 канал', '1.jpg', '1', ''),
(2, 'Россия 1', '2.jpg', '2', ''),
(3, 'ТВ Центр', '3.jpg', '3', ''),
(4, 'НТВ', '4.jpg', '4', ''),
(5, 'Россия К', '5.jpg', '5', ''),
(101, 'ТНТ', '101.jpg', '101', ''),
(102, 'Домашний', '102.jpg', '102', ''),
(103, 'РенТВ', '103.jpg', '103', ''),
(104, 'СТС', '104.jpg', '104', ''),
(105, 'ТВ3', '105.jpg', '105', ''),
(109, 'Перец', '109.jpg', '109', ''),
(235, 'Россия 2', '235.jpg', '235', ''),
(255, '5 канал', '255.jpg', '255', ''),
(276, '2x2', '276.jpg', '276', ''),
(330, 'Звезда', '330.jpg', '330', ''),
(676, 'Россия 24', '676.jpg', '676', '')";

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
(1, 0, 1, 'Авто&Мото', 'automoto', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(7, 0, 1, 'Разное&Other', 'other', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(2, 0, 1, 'Смешное', 'funny', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(8, 0, 1, 'Город', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(9, 0, 1, 'Дети', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(10, 0, 1, 'Животные', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(11, 0, 1, 'Известные люди', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(12, 0, 1, 'Искусство', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(13, 0, 1, 'Разное', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(14, 0, 1, 'Пейзажи', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(15, 0, 1, 'Портреты', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(16, 0, 1, 'Портфолио', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(17, 0, 1, 'Спорт', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(18, 0, 1, 'Юмор', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(19, 0, 1, 'Эротика', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(20, 0, 1, 'Фото с телефона ', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(21, 0, 1, 'Макросъемка', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(22, 0, 1, 'Праздники ', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(23, 0, 1, 'Природа', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(24, 0, 1, 'Путешествия', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(25, 0, 1, 'Искусство', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', '')";

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
(1, 'Администратор', 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
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
(1, 'Семья'),
(2, 'Коллеги'),
(3, 'Одноклассники'),
(4, 'Одногруппники')";

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
(1, 0, 1, 'Авто&Мото', 'automoto', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(7, 0, 1, 'Разное&Other', 'other', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(2, 0, 1, 'Смешное', 'funny', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '0', '0', '0', '0', '0', '0'),
(9, 0, 1, 'Фильмы и анимация', 'Film', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(10, 0, 1, 'Транспорт', 'Autos', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(11, 0, 1, 'Музыка', 'Music', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(12, 0, 1, 'Животные', 'Animals', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(13, 0, 1, 'Спорт', 'Sports', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(14, 0, 1, 'Короткометражные фильмы', 'Shortmov', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(15, 0, 1, 'Путешествия', 'Travel', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(16, 0, 1, 'Компьютерные игры', 'Games', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(17, 0, 1, 'Ведение видеоблога', 'Videoblog', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(18, 0, 1, 'Люди и блоги', 'People', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(19, 0, 1, 'Юмор', 'Comedy', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(20, 0, 1, 'Развлечения', 'Entertainment', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(21, 0, 1, 'Новости и политика', 'News', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(22, 0, 1, 'Хобби и стиль', 'Howto', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(23, 0, 1, 'Образование', 'Education', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(24, 0, 1, 'Наука и техника', 'Tech', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(25, 0, 1, 'Общество', 'Nonprofit', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(26, 0, 1, 'Кинозал', 'Movies', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(27, 0, 1, 'Анимация и мультфильмы', 'Movies_anime_animation', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(28, 0, 1, 'Приключения и боевики', 'Movies_action_adventure', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(29, 0, 1, 'Классика', 'Movies_classics', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(30, 0, 1, 'Юмор', 'Movies_comedy', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(31, 0, 1, 'Документальное кино', 'Movies_documentary', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(32, 0, 1, 'Драмы', 'Movies_drama', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(33, 0, 1, 'Для всей семьи', 'Movies_family', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(34, 0, 1, 'Зарубежное кино', 'Movies_foreign', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(35, 0, 1, 'Ужасы', 'Movies_horror', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(36, 0, 1, 'Научная фантастика/фэнтези', 'Movies_sci_fi_fantasy', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(37, 0, 1, 'Триллеры', 'Movies_thriller', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(38, 0, 1, 'Короткометражные', 'Movies_shorts', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(39, 0, 1, 'Шоу', 'Shows', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(40, 0, 1, 'Трейлеры', 'Trailers', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', ''),
(41, 0, 1, 'Gaming', 'Gaming', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', '', '');";

$row = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_static WHERE id='14' or id='15'" );
if ($row['count']==0)
{
$tableSchema[] = "INSERT INTO " . PREFIX . "_static (`id`, `name`, `descr`, `template`, `allow_br`, `allow_template`, `grouplevel`, `tpl`, `views`) VALUES (14, 'agreement', 'Соглашение с пользователем и условия конфиденциальности', '<p>1. Термины</p>\r\n\r\n<p><br />\r\n        Пользователь – посетитель Сайта, прошедший процедуру регистрации на Сайте в установленном порядке.</p>\r\n\r\n<p>Сайт – расположенный по адресу <a href=\"$url\">$url</a>&nbsp; сервис, являющийся собственностью $url&nbsp;(далее – «Компания-владелец»).</p>\r\n\r\n<p>Контент – музыкальные произведения, литературные произведения, программы для ЭВМ, мобильных телефонов, аудиовизуальные произведения, фонограммы, изображения, тексты, товарные знаки, логотипы, гипертекстовые ссылки, их фрагменты, информация, иные объекты добровольно и безвозмездно размещаемые Пользователем на Сайте.</p>\r\n\r\n<p>Личные данные – информация, позволяющая идентифицировать Пользователя, в том числе контактная информация, добровольно и безвозмездно размещаемая Пользователем на Сайте.</p>\r\n\r\n<p>Администрация Сайта – группа сотрудников компании-владельца и ее доверенных лиц, устанавливающая порядок использования Сайта, управляющая его работой, контролирующая выполнением Пользователями настоящего Соглашения. </p>\r\n\r\n<p><br />\r\n        2. Предмет соглашения</p>\r\n\r\n<p><br />\r\n        2.1. Настоящее Соглашение с пользователем (далее «Соглашение») является юридическим соглашением между Пользователем и Компанией-владельцем, устанавливающее правила использования Сайта.<br />\r\n        2.2. Регистрацией на Сайте Пользователь подтверждает свое полное согласие с условиями настоящего Соглашения.<br />\r\n        2.3. В случае несогласия с какими-либо условиями Соглашения Пользователь обязуется незамедлительно прекратить пользование Сайтом.<br />\r\n        2.4. Администрация Сайта оставляет за собой право в любое время изменить условия настоящего Соглашения. При этом Пользователь принимает на себя обязательство своевременно знакомится с изменениями условий Соглашения.<br />\r\n        2.5. Регистрацией на Сайте Пользователь подтверждает, что обладает необходимой правоспособностью и полномочиями для принятия настоящего Соглашения, способен исполнять условия Соглашения и нести ответственность за нарушение Соглашения, в том числе по правоотношениям, возникшим вследствие пользования Сайтом.<br />\r\n        2.6. Пользователь несет персональную ответственность за Контент и все последствия, связанные с его публикацией.<br />\r\n        2.7. Размещая Контент, Пользователь гарантирует что, обладает всеми правами и полномочиями, необходимыми для передачи прав в соответствии с п.5.5. настоящего Соглашения.<br />\r\n        2.8. Размещая Контент, Пользователь предоставляет право любому другому Пользователю Сайта на доступ к Контенту.</p>\r\n\r\n<p><br />\r\n        3. Права и обязанности Пользователя</p>\r\n\r\n<p><br />\r\n        3.1. Пользователь обязуется не размещать Контент провокационного, грубого, оскорбительного и агрессивного характера, противоречащий моральным и этическим нормам, нарушающий действующее российское или международное законодательство, нарушающий права, в том числе интеллектуальные, третьих лиц.<br />\r\n        3.5 Пользователь вправе размещать на Сайте Контент в соответствии с условиями настоящего Соглашения.<br />\r\n        3.3 При регистрации Пользователь обязуется указать достоверные Личные данные.<br />\r\n        3.4 На весь Контент, публикуемый на Сайте в записях или комментариях, распространяется действие авторского права. Все заимствованные материалы должны иметь указание имени автора, если оно указано на сайте-источнике, а при невозможности его установления — значок копирайта (с). Гиперссылки на заимствованные материалы, размещенные ранее в Интернете, приветствуются, а в том случае, если автор заявит об их необходимости, — требуются обязательно. Пользователь обязуется не приписывать себе авторство чужих текстов или изображений.<br />\r\n        3.5 Пользователь несёт ответственность за нарушение данного Соглашения в соответствии с законодательством Российской Федерации.<br />\r\n        3.6 В случае нанесения ущерба третьим лицам, другим Пользователям или Сайту Пользователь обязуется возместить причиненный ущерб в полном объёме и в размере в соответствии с действующим законодательством Российской Федерации.<br />\r\n        3.7 Пользователь несет ответственность и все расходы (включая возмещение убытков, вреда, штрафов, судебных и иных расходов и издержек) в случае предъявления третьими лицами каких-либо претензий, включая, но не ограничиваясь претензиями связанными с защитой интеллектуальных прав третьих лиц, и за какие-либо обязательства, возникшие у Сайта в связи с требованиями третьих сторон, связанные или возникшие вследствие нарушения Пользователем условий настоящего Соглашения. Пользователь обязуется принять все необходимые и возможные меры, направленные на исключение Сайта из числа ответчиков. </p>\r\n\r\n<p><br />\r\n        4. Права и обязанности Администрации Сайта</p>\r\n\r\n<p><br />\r\n        4.1. Администрация Сайта обязуется защищать всю контактную информацию Пользователя. За исключением контактной информации данные Пользователя доступны для просмотра другим пользователям и посетителям Сайта.<br />\r\n        4.2. Администрация Сайта обязуется не разглашать контактную информацию Пользователя третьим лицам, кроме случаев, предусмотренных действующим законодательством и настоящим Соглашением.<br />\r\n        4.3. Администрация Сайта не занимается рассмотрением и разрешением споров и конфликтных ситуаций, возникающих между Пользователями Сайта, однако оставляет за собой право заблокировать страницу Пользователя в случае получения от других Пользователей мотивированных жалоб на некорректное поведение данного Пользователя на Сайте.<br />\r\n        4.4 Администрация Сайта не несёт ответственности за самостоятельное раскрытие Пользователем своей контактной информации другим Пользователям. При этом Пользователь получает оповещение от Сайта о раскрытии этой информации.<br />\r\n        4.5 Администрация Сайта вправе, но не обязана осуществлять модерацию текста, фотографий, комментариев и иных материалов, размещаемых Пользователями на Сайте.<br />\r\n        4.6 Администрация Сайта вправе удалить любой текст, фотографию, комментарий Пользователя без уведомления и объяснения причин.<br />\r\n        4.7 Администрация Сайта не контролирует соблюдение авторских прав на интеллектуальную собственность и не несет ответственности за нарушение их Пользователями Сайта.<br />\r\n        4.8 Администрация Сайта не дает никаких гарантий, выраженных явно или подразумеваемых, что материалы, публикуемые на Сайте, полезны и интересны.<br />\r\n        4.9 В случае нарушения Пользователем условий настоящего Соглашения, либо действующего законодательства РФ, Сайт оставляет за собой право передачи контактных данных, IP адреса, любой другой информации заинтересованным лицам.<br />\r\n        4.10 Администрация Сайта использует информацию о действиях Пользователя в целях улучшения работы Сайта.<br />\r\n        4.11. Администрация Сайта оставляет за собой право приостановить либо прекратить доступ к Сайту при достаточных основаниях предполагать, что Личные данные указаны не полно либо не верно.<br />\r\n        4.12. В случае нарушения Пользователем условий данного Соглашения Администрация Сайта вправе заблокировать страницу Пользователя.<br />\r\n        4.13. Администрация Сайта оставляет за собой право вводить любые ограничения в отношении пользования Сайта.<br />\r\n        4.14. Администрация Сайта либо компания-владелец оставляет за собой право закрыть, приостановить, изменить Сайт либо его часть без предварительного уведомления Пользователя.</p>\r\n\r\n<p><br />\r\n        5. Прочее</p>\r\n\r\n<p><br />\r\n        5.1. Соглашение вступает в силу с момента Регистрации Пользователя на Сайте и действует в течение всего срока использования Сайта.<br />\r\n        5.2. Администрация Сайта и компания-владелец не несут ответственности за Контент, размещенный на Сайте. Так же, Сайт и компания-владелец не несут никакой ответственности:<br />\r\n        - За неточность и не полноту Контента;<br />\r\n        - За ущерб, вред и убытки любого характера причиненные вследствие пользования Сайтом либо нарушения его работы;<br />\r\n        - За разглашение Личных данных произошедших вследствие нарушения работы Сайта.<br />\r\n        5.3. Администрация Сайта оставляет за собой право вносить любые изменения в настоящее Соглашение.<br />\r\n        5.4. Пользователь добровольно добавляет Контент на Сайт, при этом Пользователь сохраняет интеллектуальные и любые иные права, которые принадлежат ему в отношении Контента.<br />\r\n        5.5. Размещая Контент, Пользователь подтверждает, что этим безвозмездно предоставляет компании-владельцу и Сайту право на показ, воспроизведение, изменение, хранение, открытую демонстрацию, адаптирование, публикацию, распространение, архивирование, перевод и любое иное использование Контента или любой его части без ограничения срока и территории действия.<br />\r\n        5.6. Пользователь признает за компанией-владельцем все права на Сайт как единый объект, включая все его составляющие.<br />\r\n        5.7. Принимая настоящее Соглашение, Пользователь выражает свое согласие с тем, что:<br />\r\n        - При размещении Контента Пользователь не становится соавтором Сайта и отказывается от каких либо претензий на такое авторство в будущем;<br />\r\n        - В случае передачи компании-владельцу каких-либо прав на Контент в соответствии с п.5.5. настоящего Соглашения Пользователь лишается права на отзыв произведения, как оно определено ст. 1269 ГК РФ.<br />\r\n        - В случае размещения Контента, специально созданного Пользователем для размещения на Сайте, исключительное право на такой Контент сохраняется за Пользователем.<br />\r\n        5.8. Доступ к материалам Сайта, в том числе к Контенту предоставляется Пользователю исключительно для личного использования и ознакомления. Без предварительного письменного согласия владельцев соответствующих прав Пользователь не имеет права использовать, воспроизводить, распространять любым способом, копировать, публично показывать, передавать в эфир для всеобщего сведения, переводить, переделывать, или использовать любым иным способами в каких либо иных целях материалы Сайта.<br />\r\n        5.9. Администрация Сайта и компания-владелец не несут никакой ответственности за целостность и сохранность Контента, размещенного на Сайте.<br />\r\n        5.10. Условия п.п.5.5., 5.7. настоящего Соглашения остаются в силе после прекращения действия настоящего Соглашения.<br />\r\n        5.11. В случае, если Администрация Сайта или компания-владелец в какой-либо момент не требует от Пользователя выполнения каких-либо условий настоящего Соглашения, это не отменяет права Администрации Сайта или компании-владельца требовать такого выполнения позднее, равно как и принимать меры, направленные на выполнение Пользователем условий настоящего Соглашения.<br />\r\n        5.12. После прекращения действия Соглашения, компания-владелец продолжает владеть всеми переданными правами на Контент, без каких-либо обязательств оплаты Пользователю за его использование.<br />\r\n        5.13. Никакие положения настоящего Соглашения не ограничивают права Администрации Сайта, компании-владельца или Пользователя заключать аналогичные соглашения с любым другим лицом.<br />\r\n        5.14. Признание недействительным одного из условий или положений настоящего Соглашения не является основанием для признания недействительным любых других условий или положений Соглашения.<br />\r\n        5.15. Пользователь соглашается, что в случае возникновения споров они подлежат разрешению в соответствии с действующим законодательством Российской Федерации.</p>\r\n\r\n<p>Администрация Сайта оставляет за собой право вносить любые поправки в настоящее Соглашение</p>', 0, 1, 'all', '', '272'),
(15, 'about', 'О проекте', '<p align=\"right\">\r\n        <span style=\"FONT-STYLE: italic\">Люди разучились общаться.<br />\r\n                Например, любят одну музыку, ходят постоянно&nbsp;в один клуб,<br />\r\n                она за барной стойкой, он — на диване.<br />\r\n                А познакомились только у нас в клубе! Это же урбанизация какая-то!<br />\r\n                «Москва слезам не верит»</span><br />\r\n        <br />\r\n        </p>\r\n\r\n<p>\r\n        <span style=\"FONT-WEIGHT: bold\">Мир как на ладони</span> <br />\r\n        Уже давно люди используют компьютер для общения. Но разве виртуальная жизнь может заменить настоящую? Создатели проекта Odnoklybniki.ru уверены: современный интернет должен помогать людям общаться «вживую». Новый проект смешивает виртуальное и реальное,&nbsp;связывая оба мира.<br />\r\n        Все действо происходит в клубе из интересов. Можно окинуть взглядом свои любимые клубы — и узнать, что происходит вокруг, найти людей которые ходят&nbsp;в один клуб, познакомиться с ведущими, диджеями, которые интересуются тем же, что и ты. А может даже познакомиться с девушкой или парнем твоей мечты.<br />\r\n        <br />\r\n        \r\n        <span style=\"FONT-WEIGHT: bold\">Клуб вашему клубу</span><br />\r\n        Основная идея сервиса проста: у каждого&nbsp;клуба есть свой клуб, свое сообщество! Найди клуб, где ты тусуешься,&nbsp;проходишь рядом&nbsp;или выступаешь, и посмотри, о чем говорят одноклубники. Как провести классно время,&nbsp;есть ли рядом сногсшибательная девушка или парень,&nbsp;когда будет следующее грандиозное событие&nbsp;— массу вопросов можно решить, просто поговорив c одноклубником.&nbsp;Клуб клуба&nbsp;— это то место, где решить все проблемы или просто приятно провести время действительно легко!</p>\r\n\r\n<p><br />\r\n        \r\n        <span style=\"FONT-WEIGHT: bold\">Друзья рядом<br />\r\n                </span>Ты большой поклонник футбола, но не можешь собрать себе команду для игры? Не знаешь, с кем покататься на роликах? Все девушки, которые любят джаз так же сильно, как и ты, живут за тридевять земель и нет возможности встретиться? Теперь все будет по-другому. Просто зайди на Одноклубники.RU, укажи,&nbsp;в какой клуб ты чаще всего ходишь&nbsp;и что ты любишь, — и рано или поздно ты убедишься, что есть еще Одноклубники.</p>', 0, 1, 'all', '', '392')";
//$tableSchema[] = "INSERT INTO " . PREFIX . "_static (`name`, `descr`, `template`, `allow_br`, `allow_template`, `grouplevel`, `tpl`, `metadescr`, `metakeys`, `views`, `template_folder`, `date`) VALUES ('dle-rules-page', 'Общие правила на сайте', '<b>Общие правила поведения на сайте:</b><br /><br />Начнем с того, что на сайте общаются сотни людей, разных религий и взглядов, и все они являются полноправными посетителями нашего сайта, поэтому если мы хотим чтобы это сообщество людей функционировало нам и необходимы правила. Мы настоятельно рекомендуем прочитать настоящие правила, это займет у вас всего минут пять, но сбережет нам и вам время и поможет сделать сайт более интересным и организованным.<br /><br />Начнем с того, что на нашем сайте нужно вести себя уважительно ко всем посетителям сайта. Не надо оскорблений по отношению к участникам, это всегда лишнее. Если есть претензии - обращайтесь к Админам или Модераторам (воспользуйтесь личными сообщениями). Оскорбление других посетителей считается у нас одним из самых тяжких нарушений и строго наказывается администрацией. <b>У нас строго запрещен расизм, религиозные и политические высказывания.</b> Заранее благодарим вас за понимание и за желание сделать наш сайт более вежливым и дружелюбным.<br /><br /><b>На сайте строго запрещено:</b> <br /><br />- сообщения, не относящиеся к содержанию статьи или к контексту обсуждения<br />- оскорбление и угрозы в адрес посетителей сайта<br />- в комментариях запрещаются выражения, содержащие ненормативную лексику, унижающие человеческое достоинство, разжигающие межнациональную рознь<br />- спам, а также реклама любых товаров и услуг, иных ресурсов, СМИ или событий, не относящихся к контексту обсуждения статьи<br /><br />Давайте будем уважать друг друга и сайт, на который Вы и другие читатели приходят пообщаться и высказать свои мысли. Администрация сайта оставляет за собой право удалять комментарии или часть комментариев, если они не соответствуют данным требованиям.<br /><br />При нарушении правил вам может быть дано <b>предупреждение</b>. В некоторых случаях может быть дан бан <b>без предупреждений</b>. По вопросам снятия бана писать администратору.<br /><br /><b>Оскорбление</b> администраторов или модераторов также караются <b>баном</b> - уважайте чужой труд.<br /><br /><div align=\"center\">{ACCEPT-DECLINE}</div>', 1, 1, 'all', '', 'Общие правила', 'Общие правила', 0, '', '{$add_time}')";
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
(1, 'Праздник света', '2013-06-05', '".$_REQUEST['reg_name']."', '3409', 'Бесценные обитатели океанов', '', 'Праздник Тела и Крови Христовых (Corpus Christi) отмечается ежегодно в четверг после Троицы и является торжественным празднованием священной евхаристии (Holy Eucharist) по сравнению с ежедневной святой Мессой. Католическая церковь рассматривает евхаристию (таинство причащения) как священный дар, оставленный Христом своей церкви, установленный во время последней вечери. Жертва, принесенная Иисусом под видом хлеба и вина в Иерусалимской горнице, — это своеобразная «форма», в которую жертва крестная облекается в жизни Церкви. Святое причастие — это участие верующих в жертве Христа, которое помогает нам уподобиться Сыну Божьему. Обычай торжественного почитания евхаристии берет свое начало в 1247 году в Льежской епархии Бельгии. В 1264 году папа Урбан IV придал этому празднику статус общецерковного, даровав индульгенции всем, кто принимал участие в праздничной мессе. Чинопоследование праздника Тела Христова сочинил Фома Аквинский, и текст этой службы считается одним из красивейших в римском Бревиарии. Праздник, истинно религиозный по происхождению, со временем стал во многих странах действительно народным праздником. В нем соединились строгая обрядность церковной службы, церемониальное шествие и игровые элементы, характерные для шумных дохристианских празднеств. Существует красивая традиция — во время процессии разбрасывать лепестки цветов. \r\n\r\nИсточник: http://www.calend.ru/holidays/0/0/404/\r\n© Calend.ru'),
(2, 'Труд', '2013-05-30', '".$_REQUEST['reg_name']."', '', '', '', '19.00 - открытие экспозиции. Автомобили будут выставлены на всеобщее обозрение, гости смогут посмотреть машины и поговорить с их владельцам
и, поделиться опытом, да и просто сфотографироваться с любым понравившимся автомобилем. Почти у каждого автомобиля будет работать свой фотограф, который сможет запечатлеть выдающиеся м
оменты + сделать снимок на память для гостей.\r\n20.00 - начало конкурсной программы. В конкурсе будут принимать участие все гости мероприятия: они будут выбирать тот самый автомобиль(победителя в номинации \"зрительские симпатии
\"). Так же будут определены победители и в других номинациях. Выбирать их будет компетентное жюри.\r\nВо время всего мероприятия будет проводиться зажигательная шоу-программа, которая не заставит ск
учать гостей и участников конкурса. Так же всех гостей и участников мероприятия ждут приятные сюрпризы и подарки.\r\n22.00 - награждение. Объявление победителе, раздача призов и подарков.\r\n22.
30(23.00) - after-party в замечательном месте – Арт – клуб «Подвал», где гости и участники мероприятия смогут отдохнуть и поделиться впечатлениями о прошедшем конкурсе.')";
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
    <div class="title">Четвертый шаг установки - Основные настройки портала</div>
  </div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<style type="text/css">
.error {
    color: red;
}
</style>
  <div class="box-content">
	<div class="row box-section">
		Осталось указать основные настройки для правильной работы портала.<br><br>

			<div style="padding-top:5px;">
				<table>
					<tr><td colspan="3" height="40">&nbsp;&nbsp;<b>Общие настройки</b><td></tr>
					<tr><td style="padding: 5px;">Заголовок портала</td><td style="padding: 5px;"><input type=text name="title_portals" value="{$config['home_title']}"></td></tr>
					<tr><td style="padding: 5px;">Описание портала</td><td style="padding: 5px;"><textarea type=text name="description_portals">{$config['description']}</textarea></td></tr>
					<tr><td style="padding: 5px;">Ключевые слова портала</td><td style="padding: 5px;"><input type=text name="keywords_portals" value="{$config['keywords']}"></td></tr>

<!--
					<tr><td style="padding: 5px;">Город (пример: Екатеринбург)</td><td style="padding: 5px;"><input type=text name="city_ckaburg" id="city_ekaburg" value="{$config['city_osn_name']}"></td></tr>
					<tr><td style="padding: 5px;">Город (пример: Екатеринбурге)</td><td style="padding: 5px;"><input type=text name="city_ckaburge" id="city_ekaburge" value="{$config['city_osn_name']}"></td></tr>
					<tr><td style="padding: 5px;">Город (пример: Екатеринбурга)</td><td style="padding: 5px;"><input type=text name="city_ekaburga" id="city_ekaburga" value="{$config['city_osn_name']}"></td></tr>

<tr><td style="padding: 5px;">Ключ 2GIS<br><span class="small">Его можно получить по следующему адресу: <a onclick="window.open('http://partner.api.2gis.ru', 'Help', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width=600,height=500')" href="#">http://partner.api.2gis.ru</a></span></td><td style="padding: 5px;"><input type=text name="key_2gis" value=""></td></tr>
					<tr><td style="padding: 5px;">Ключ YouTube API<br><span class="small">Его можно получить по следующему адресу: <a onclick="window.open('https://code.google.com/apis/youtube/dashboard', 'Help', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width=600,height=500')" href="#"> https://code.google.com/apis/youtube/dashboard</a></span></td><td style="padding: 5px;"><input type=text name="key_api_youtube" value=""></td></tr>
-->
					<tr><td style="padding: 5px;">Основная валюта <span id='err_v'></span></td><td style="padding: 5px;"><input type=text name="valuta" value="Рубли" id="valuta"></td></tr>
					<tr><td style="padding: 5px;">Сокращение основной валюты <span id='err_vz'></span></td><td style="padding: 5px;"><input type=text name="valutaz" value="руб" id="valutaz"></td></tr>

					<tr><td style="padding: 5px;">Главный E-Mail для уведомлений</td><td style="padding: 5px;"><input type=text name="admin_email" value="{$_REQUEST['regmail']}"></td></tr>

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