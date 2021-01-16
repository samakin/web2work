<?php
error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', false);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

define('DATALIFEENGINE', true);
define('ROOT_DIR', '..');
define('ENGINE_DIR', ROOT_DIR.'/engine');

$config['charset'] = "windows-1251";

require_once(ROOT_DIR.'/language/Russian/adminpanel.lng');
require_once(ENGINE_DIR.'/inc/include/functions.inc.php');
require_once(ENGINE_DIR.'/data/config.php');
require_once(ENGINE_DIR.'/classes/mysql.php');
require_once(ENGINE_DIR.'/data/dbconfig.php');

function update_kurs(){
	$life_time = time() - @filemtime($loc_file);
  	if ((file_exists($loc_file)) && ($life_time<10400)){ // 10400 - это время обновления иформации в секундах (в данном случае - 3 часа)
    $fp = fopen($loc_file, 'r');
    if (filesize($loc_file) >0){
        $text = fread($fp, filesize($loc_file));
    }else{
        $text = '<span class="localfilesizeisnull">Ожидание...</span>';
    }
    fclose($fp);
    if (strlen($text) > 20) return $text;
  }
    // Формируем сегодняшнюю дату
    $date = date("/m/Y");

    $nd = date("d");
    $nd = $nd;
    if ($nd<'10') $nd = ''.$nd.'';

   // Формируем ссылку
    $link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd$date";

     if (strlen($link) < 20) {
        // не сохраняем файл
        @touch($loc_file);
        return $link;
    }


    // Загружаем HTML-страницу
    $fd = fopen($link, "r");
    $text="";
    if (!$fd) $tr="Запрашиваемая страница не найдена";
    else
    {
      // Чтение содержимого файла в переменную $text
      while (!feof ($fd)) $text .= fgets($fd, 4096);
    }
    // Закрыть открытый файловый дескриптор
    fclose ($fd);

       // Разбираем содержимое, при помощи регулярных выражений
  $pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
  preg_match_all($pattern, $text, $out, PREG_SET_ORDER);
  $dollar = "";
  $euro = "";
  foreach($out as $cur)
  {
    if($cur[2] == 840) $dollar = str_replace(",",".",$cur[4]);
    if($cur[2] == 978) $euro   = str_replace(",",".",$cur[4]);
  }
           $nd2 = $nd+1;
           if ($nd2<'10') $nd2 = '0'.$nd2.'';
   // Формируем ссылку
    $links = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd2$date";

     if (strlen($links) < 20) {
        // не сохраняем файл
        @touch($loc_file);
        return $link;
    }


    // Загружаем HTML-страницу
    $fd = fopen($links, "r");
    $texts="";
    if (!$fd) $tr="Запрашиваемая страница не найдена";
    else
    {
      // Чтение содержимого файла в переменную $text
      while (!feof ($fd)) $texts .= fgets($fd, 4096);
    }
    // Закрыть открытый файловый дескриптор
    fclose ($fd);

 // Разбираем содержимое, при помощи регулярных выражений
  $patternx = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
  preg_match_all($patternx, $texts, $outx, PREG_SET_ORDER);
  $dollarnext = "";
  $euronext = "";
  foreach($outx as $curx)
  {
    if($curx[2] == 840) $dollarnext = str_replace(",",".",$curx[4]);
    if($curx[2] == 978) $euronext   = str_replace(",",".",$curx[4]);
  }

  $nd3 = $nd-1;
           if ($nd3<'10') $nd3 = '0'.$nd3.'';
   // Формируем ссылку
    $linkser = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd3$date";

     if (strlen($linkser) < 20) {
        // не сохраняем файл
        @touch($loc_file);
        return $linkser;
    }


    // Загружаем HTML-страницу
    $fd = fopen($linkser, "r");
    $textser="";
    if (!$fd) $tr="Запрашиваемая страница не найдена";
    else
    {
      // Чтение содержимого файла в переменную $text
      while (!feof ($fd)) $textser .= fgets($fd, 4096);
    }
    // Закрыть открытый файловый дескриптор
    fclose ($fd);

 // Разбираем содержимое, при помощи регулярных выражений
  $patternx = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
  preg_match_all($patternx, $textser, $outx, PREG_SET_ORDER);
  $dollarold = "";
  $euroold = "";
  foreach($outx as $curx)
  {
    if($curx[2] == 840) $dollarold = str_replace(",",".",$curx[4]);
    if($curx[2] == 978) $euroold   = str_replace(",",".",$curx[4]);
  }

  if ((int)($dollar)<=(int)($dollarold)) $get = 'down';
  else $get = 'up';

  if ((int)($euro)<=(int)($euroold)) $gete = 'down';
  else $gete = 'up';

  $texter = array();
  $texter = array(1 => $dollar, 2 => $euro, 3 => $dollarnext, 4 => $euronext, 5 => $dollarold, 6 => $euroold, 7 => $get, 8 => $gete);


					$fp = fopen( ROOT_DIR . '/engine/cache/system/kurs.php', 'wb+' );
					fwrite( $fp,  serialize($texter) );
					fclose( $fp );
					@chmod( ROOT_DIR . '/engine/cache/system/kurs.php', 0666 );
}

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

$config['home_title'] = $_REQUEST['title_portals'];
$config['description'] = $_REQUEST['description_portals'];
$config['keywords'] = $_REQUEST['keywords_portals'];
$config['valutasite'] = $_REQUEST['valuta'];
$config['valutasitez'] = $_REQUEST['valutaz'];
$config['mapsonsite'] = '0';
$config['allow_comments_wysiwyg'] = '2';
$config['allow_site_wysiwyg'] = '1';
$config['allow_quick_wysiwyg'] = '1';
$config['allow_admin_wysiwyg'] = '1';
$config['allow_static_wysiwyg'] = '1';

$handler = fopen(ENGINE_DIR.'/data/config.php', "w") or die("Извините, но невозможно записать информацию в файл <b>.engine/data/config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($handler, "<?PHP \n\n//System Configurations\n\n\$config = array (\n\n");
foreach($config as $name => $value)
{
	fwrite($handler, "'{$name}' => \"{$value}\",\n\n");
}
fwrite($handler, ");\n\n?>");
fclose($handler);

$yandex_config = <<<HTML
<?PHP

\$config[yandex_city] = "{$config[city_osn_name]}";
\$config[yandex_keyapi] = "{$_REQUEST[key_yandexmaps]}";
\$config[yandex_narod] = "1";
\$config[yandex_zoom] = "16";
\$config[yandex_width] = "600px";
\$config[yandex_height] = "500px";
\$config[yandex_city_lat] = "{$check_city[lat]}";
\$config[yandex_city_lng] = "{$check_city[lng]}";

?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/yandex_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/yandex_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $yandex_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/yandex_config.php", 0666);


$check_city = get_latlng($config[city_osn_name]);

$yandex_config = <<<HTML
<?PHP

\$config[yandex_city] = "{$config[city_osn_name]}";
\$config[yandex_keyapi] = "{$_REQUEST[key_yandexmaps]}";
\$config[yandex_narod] = "1";
\$config[yandex_zoom] = "16";
\$config[yandex_width] = "600px";
\$config[yandex_height] = "500px";
\$config[yandex_city_lat] = "{$check_city[lat]}";
\$config[yandex_city_lng] = "{$check_city[lng]}";

?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/yandex_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/yandex_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $yandex_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/yandex_config.php", 0666);

$translit_weather = totranslit($_REQUEST[city_ckaburg]);

$row_weathers = $db->super_query( "SELECT id FROM weather_city WHERE name LIKE '%".$_REQUEST[city_ckaburg]."%' or name LIKE '%".$translit_weather."%'  ORDER BY last_updated DESC" );
$row_weathers2 = $db->super_query( "SELECT name_id FROM ".PREFIX."_weather_gismeteo_city WHERE name LIKE '%".$_REQUEST[city_ckaburg]."%' ORDER BY id DESC" );
if ($row_weathers2[name_id]) {
    $db->query("delete FROM " . USERPREFIX . "_weather_gismeteo_city WHERE name_id!='" . $row_weathers2[name_id] . "'");
} else {
    $db->query("delete FROM " . USERPREFIX . "_weather_gismeteo_city WHERE name NOT LIKE '" . $_REQUEST[city_ckaburg] . "'");
}

$list_weather = <<<HTML
{$row_weathers[id]}|{$_REQUEST[city_ckaburg]}|||0||
HTML;

$con_file = fopen(ENGINE_DIR."/data/weather.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/weather.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $list_weather);
fclose($con_file);
@chmod(ENGINE_DIR."/data/weather.txt", 0666);

	$xfieldsz = array ();
    $nav_lands = array ();

	$db->query ( "SELECT * FROM " . PREFIX . "_change_city ORDER BY name DESC" );
	while ( $row = $db->get_row () ) {

		$xfieldsz[$row['id']] = array ();
        $kk=0;
		foreach ( $row as $key => $value ) {
			if ($key=='weather_id' or $key=='weather_gm_id' or $key=='name')
			{
				$kk++;
				$xfieldsz[$row['id']][$kk] = stripslashes ( $value );
			}
		}

		$nav_lands[$row['id']] = array ();

		foreach ( $row as $key => $value ) {
			$nav_lands[$row['id']][$key] = stripslashes ( $value );
		}


	}
	set_vars ( "weather_pagefull_v1", $xfieldsz );
	set_vars ( "navigation_lands", $nav_lands );

$googlemaps_config = <<<HTML
<?PHP

\$config['googlemaps_keyapi'] = "{$_REQUEST['key_yandexmaps']}";
\$config['googlemaps_zoom'] = "16";
\$config['googlemaps_width'] = "600px";
\$config['googlemaps_height'] = "500px";
\$config['googlemaps_city_lat'] = "{$check_city['lat']}";
\$config['googlemaps_city_lng'] = "{$check_city['lng']}";

?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/googlemaps_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/googlemaps_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $googlemaps_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/googlemaps_config.php", 0666);

$smscoin_config = <<<HTML
<?PHP

?>
HTML;

$pay_config = <<<HTML
<?PHP

?>
HTML;

$firm_config = <<<HTML
<?PHP

\$config['alph_approve'] = '1';
\$config['skin_n'] = 'page_standart';
\$config['firm_newscat'] = '00';
\$config['state_search'] = '1';
\$config['firm_otzivs'] = '1';
\$config['mini_maps'] = '1';
\$config['alldop_cat'] = '4';
\$config['dop_cat'] = '6';
\$config['price_approve'] = '1';
\$config['firm_type_rating'] = '2';
\$config['firm_type_search'] = '2';
\$config['price_format'] = 'xls, doc, txt';
\$config['key_2gis'] = '{$_REQUEST['key_2gis']}';
\$config['logo_format'] = 'png, gif';
\$config['advmzx_rating'] = '25';
\$config['fiem_news_category'] = '10,0';
\$config['afisha_news_category'] = '1012';
\$config['forum_news_category'] = '41';
\$config['question_news_category'] = '12';
\$config['obj_firm_text'] = 'В справочнике телефонов и адресов организаций на каждой карточке предприятия вы можете видеть товары и услуги, которыми располагает компания, а также ссылки на актуальные прайс-листы организаций.';
\$config['obj_shop_text'] = '<h3>Интернет магазины.</h3>
Представлен самый полный список интернет магазинов, более 30 сайтов. Бытовая техника, мобильные телефоны, шины, диски, мебель, подарки, сантехника — всё это сегодня можно приобрести в в местных интернет-магазинах.При оформлении покупки в интернет-магазине или области уточните способы оплаты и условия и время доставки. При заказе еды уточняйте точное время доставки, так как от этого зависит качество самих блюд.Имейте в виду, что не все магазины предоставляют бесплатную доставку в пределах области.  Все интернет-магазины имеют форму поиска на своих сайтах, что может значительно облегчить поиск необходимого товара. Некоторые интернет магазины предоставляют возможность по резервированию товаров на сайте с последующим выкупом в офлайн магазинах.				Еще один плюс: представленные интернет-магазины – это значительная экономия на стоимости и более быстрые сроки доставки заказанного товара. Обычно все заказы доставляются в день поступления заявки, так как они  уже находятся на складах. Что же касается стоимости, то по городу она всегда заведомо ниже, чем  доставка из других городов или стран.				<br>
Кроме того, на страницах нашего сайта вы сможете найти самую полную и актуальную информацию обо всех проводимых акциях и скидках, которые предлагают представленные интернет магазины. И, конечно же, вы всегда можете получить дополнительные скидки от 2 до 10% при покупке товаров на нашем сайте с использованием карты «Клуб».';
\$config['obj_addfirm_text'] = 'В течение рабочих суток оператор нашей службы свяжется с Вами по указанному телефону, уточнит информацию и опубликует ее на сайте.После регистрации организации Вы сможете: <BR>
1. Добавить местоположение организации на карту<BR>
2. Загрузить прайс-лист организации<BR>
3. Добавить товары из прайс-листа прямо на сайте в маркет товаров';
\$config['obj_tarif_text'] = 'Уважаемый пользователь! Нажав кнопку «Выбрать», Вы получаете бесплатный пробный период сроком на 3 дня (в пакете «Премиум» - 1 день). По истечении пробного периода, информация о компании будет доступна в минимальном формате: название компании, вид деятельности, адрес, телефон.';

?>
HTML;

$config_vk = <<<HTML
<?PHP

\$config['apivk_news'] = "0";
\$config['apivk_video'] = "0";
\$config['apivk_concurs'] = "0";
\$config['apivk_afisha'] = "0";
\$config['apivk_doska'] = "0";
\$config['apivk_id'] = "";
\$config['apivk_userid'] = "";
\$config['apivk_code'] = "";
\$config['apivk_auth'] = "";
\$config['apivk_key'] = "";
\$config['apivk_moder'] = "1";

?>
HTML;

$config_video = <<<HTML
<?PHP

\$config['video_serverupl'] = "1";
\$config['video_serveryou'] = "1";
\$config['video_serverru'] = "0";
\$config['video_dataadd'] = "1";
\$config['video_avtoradd'] = "1";
\$config['video_lgg'] = "";
\$config['video_pss'] = "";
\$config['video_apk'] = "";
\$config['video_apn'] = "";
\$config['video_col'] = "15";
\$config['video_blocksearch'] = "1";
\$config['video_top'] = "1";
\$config['video_icon'] = "1";

?>
HTML;

$config_banki = <<<HTML
<?PHP

\$config['vib_categorys_banks'] = "155";
\$config['vib_categorys'] = "185";
\$config['video_multicat'] = "1";
\$config['vib_categorys_firm'] = "969";
\$config['vib_categorys_firm_brok'] = "934";
\$config['banki_sum_page'] = "5";
\$config['vib_name_banks_city2'] = "{$_REQUEST['city_ckaburge']}";
\$config['vib_name_banks_city'] = "{$_REQUEST['city_ckaburga']}";
\$config['banki_system_news'] = "1,143,0,1,news_index_top|2,143,1,5,news_index_other_block|3,143,5,5,news_index_other_block";
\$config['obj_banki_text'] = '<h1>Банки</h1>
<strong>Банки</strong> — полная база данных о <a href="/banki/deposit/">вкладах</a>, депозитах, <a href="/banki/crediting/">кредитах</a> и банках. Консультации специалистов финансовых учреждений и банков по <a href="/banki/hypothec/">ипотеке</a>, факторингу и кредитам банков физическим лицам. Рейтинг банков, информация и помощь в выборе кредита. Информация о паевых инвестиционных фондах (ПИФ) и управляющих компаниях.<br>На нашем портале размещаются отзывы о банках и полные описания программ и новостей банков. Чтобы найти банкоматы любого банка воспользуйтесь нашей <a href="/banki/cash/">картой банкоматов</a> либо найдите подходящий вам <a href="/banki/offices/">офис банка на карте</a>.<br>
Для обмена валюты найдите ближайшее к вам отделение на <a href="/banki/exchanges/">карте обменных пунктов</a> или ознакомтесь <a href="/banki/exchanges/">с курсом обмена валют в банках</a>';

?>
HTML;

$block_work_config = <<<HTML
<?PHP

\$config['work_n_id_za'] = "1003";
\$config['work_n_id_an'] = "1006";
\$config['work_n_id_region'] = "161";
\$config['work_n_ktodobavil'] = "80";
\$config['work_n_pay'] = "20";
\$config['work_n_newscol'] = "20";
\$config['work_n_width'] = "Более 5000 вакансий ведущих работодателей города! Всегда есть работа водителем, менеджером и в строительной сфере. Ежедневно на нашем сайте ищут и находят работу более 500 человек.";
\$config['work_n_height'] = "{$_REQUEST['city_ckaburge']}";
\$config['work_n_height2'] = "/uploads/example.doc";
\$config['fiemwo_news_category'] = '132,0';
\$config['afishawo_news_category'] = '1012';
\$config['forumwo_news_category'] = '44';
\$config['questionwo_news_category'] = '18';

?>
HTML;

$block_nedv_config = <<<HTML
<?PHP

\$config['nedv_id_za'] = "974";
\$config['nedv_id_an'] = "973";
\$config['nedv_objnetosn'] = "12";
\$config['nedv_objnet'] = "13";
\$config['nedv_objkot'] = "14";
\$config['nedv_id_net'] = "274";
\$config['nedv_id_kot'] = "275";
\$config['nedv_id_news'] = "187";
\$config['nedv_n_ktodobavil'] = "5";
\$config['nedv_n_pay'] = "5";
\$config['nedv_n_newscol'] = "5";
\$config['nedv_n_width'] = "<b>Новостройки в {$_REQUEST['city_ckaburge']}</b><br>Более 11000 объявлений о новостройках города! Всегда есть работа водителем, менеджером и в строительной сфере. Ежедневно на нашем сайте ищут и находят работу более 5000 человек.";
\$config['nedv_n_height'] = "{$_REQUEST['city_ckaburge']}";
\$config['nedv_n_height2'] = "<a href=web2work.ru><img src=http://web2work.ru/templates/{$config['skin']}/img/logo.png></a>";
\$config['fiemwo_news_category'] = '155,2,0';
\$config['afishawo_news_category'] = '1012';
\$config['forumwo_news_category'] = '44';
\$config['questionwo_news_category'] = '23,21,20';
\$config['nedv_system_news'] = "1,10,0,1,news_index_top|2,10,1,5,news_index_other|3,10,0,5,news_index_other|4,10,6,5,news_index_other|5,10,0,5,news_index_other";

?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/block_nedv_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_nedv_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_nedv_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_nedv_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_work_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_work_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_work_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_work_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.banki.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.banki.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_banki);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.banki.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_video.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config_video.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_video);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_video.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_vk.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config_vk.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_vk);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_vk.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/firm_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/firm_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $firm_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/firm_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/pay.config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/pay.config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $pay_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/pay.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/smscoin_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/smscoin_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $smscoin_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/smscoin_config.php", 0666);

$edit_obj = <<<HTML
t14|Тип объявления|Продам;Куплю;Обменяю|select|1|0|auto
t2|Тип объявления|Продам;Куплю;Сдам;Сниму|select|1|0|nedv
formoplati|Форма оплаты|Любая;Оклад;Оклад+%;%;Подряд;Почасовая;Сдельная;Другая|select|0|0|vacations
tiprab|Тип работы|Любая;Постоянная;По совместительству;Временная|select|1|0|vacations
graphrab|График работы|Любой;Полный рабочий день;Не полный рабочий день;Свободный;Вахтовый|select|1|0|vacations
usl|Условия||textarea|1|0|vacations
treb|Требования||textarea|0|0|vacations
obaz|Обязанности||textarea|1|0|vacations
aboutcomp|О компании||textarea|1|0|vacations
obrazie|Образование|Высшее;Неоконченное высшее;Среднее;Неоконченное среднее;Среднее специальное;Другое|select|1|0|vacations
stag|Стаж от (лет)||text|1|0|vacations
znanyaz|Знание языков||textarea|0|0|vacations
znankomp|Знание компьютера||textarea|1|0|vacations
bizob|Бизнес-образование||textarea|1|0|vacations
pol|Пол|Мужской;Женский;Любой|select|1|0|vacations
uczav|Учебное заведение||text|1|0|rezume
stah|Стаж от (лет)||text|1|0|rezume
tiprazb|Тип работы|Любая;Постоянная;По совместительству;Временная|select|1|0|rezume
predrab|Места предыдущей работы||textarea|1|0|rezume
graphrzab|График работы|Любой;Полный рабочий день;Не полный рабочий день;Свободный;Вахтовый|select|1|0|rezume
obrazie|Образование|Высшее;Неоконченное высшее;Среднее;Неоконченное среднее;Среднее специальное;Другое|select|1|0|rezume
znaniyaz|Знание языков||textarea|1|0|rezume
znankompi|Знание компьютера||textarea|1|0|rezume
biziob|Бизнес-образование||textarea|1|0|rezume
dopsved|Дополнительные сведения||textarea|1|0|rezume
vazhnost|Важность|Нет;Срочно;Не очен срочно;Сейчас работаю, но интересный вариант готов рассмотреть|select|1|0|rezume
poil|Пол|Мужской;Женский|select|1|0|rezume
vozrast|Возраст||text|1|0|rezume
t12|Коробка передач|механическая;автомат;вариатор;типтроник;роботизированная|select|1|0|auto
t11|Тип двигателя|бензин инжектор;бензин карбюратор;бензин ротор;бензин турбонаддув;бензин компрессор;дизель;дизель турбонаддув;гибридный|select|1|0|auto
t9|Состояние|отличное;хорошее;битое;среднее|select|1|0|auto
t15|Привод|передний;полный;задний|select|1|0|auto
t4|Год||text|1|0|auto
t5|Пробег (км)||text|1|0|auto
t6|Цвет||text|1|0|auto
t7|Объем двигателя (см3)||text|1|0|auto
t8|Мощность (л.с)||text|1|0|auto
t10|Кузов|седан;хэтчбек;универсал;внедорожник;купе;минивен;микроавтобус;пикап;кабриолет|select|1|0|auto
t13|Руль|левый;правый|select|1|0|auto
t11|Количество комнат|1;2;3;4;5;6|select|1|0|nedv
t10|Жилая площадь|0.0|text|1|0|nedv
full_area|Общая площадь||text|1|0|nedv
t1|Этаж||text|1|0|nedv
t12|Всего этажей||text|1|0|nedv
t13|Номер дома||text|0|0|nedv
t5|Улица||text|0|0|nedv
t11|Материал|блоки;кирпич;брус;бревно|select|1|0|zagor
full_area|Площадь дома (м.кв)|0.0|text|1|0|zagor
t10|Площадь участка (сот)||text|1|0|zagor
t1|Этаж||text|1|0|zagor
t12|Кол-во этажей||text|1|0|zagor
t5|Населенный пункт||text|1|0|zagor
t13|Расстояние от населенного пункта (км)||text|1|0|zagor
t11|Расположение|В бизнес-центре;В доме, здании;В торговом комплексе;На промышленной территории;Отдельное здание|select|1|0|comm
full_area|Площадь (м.кв)|0.0|text|1|0|comm
t9|Отдельный вход|Да, с улицы;Да, со двора;Нет|select|1|0|comm
t1|Этаж||text|1|0|comm
t5|Улица||text|0|0|comm
t13|Номер дома||text|1|0|comm
klovokomn|Количество этажей||text|1|0|objectnedv
materioal|Материал|газозолоблоки;железобетон;блоки;кирпич;брус;бревно|select|1|0|objectnedv
sroksdac|Срок сдачи||text|1|0|objectnedv
t11|Количество комнат|1;2;3;4;5;6|select|1|0|predlnovo
t1|Этаж||text|1|0|predlnovo
t12|Кол-во этажей||text|1|0|predlnovo
t10|Жилая площадь|0.0|text|1|0|predlnovo
full_area|Общая площадь||text|1|0|predlnovo
t2|Санузлы||text|1|0|predlnovo
t3|Балконы||text|1|0|predlnovo
t10|Жилая площадь|0.0|text|1|0|predlkot
full_area|Общая площадь||text|1|0|predlkot
t2|Этажность||text|1|0|predlkot
t3|Участок||text|1|0|predlkot
t10|Площадь участка (сот)||text|1|0|zemuch
t13|Расстояние от населенного пункта (км)||text|1|0|zemuch
t5|Населенный пункт||text|1|0|zemuch
kratkopis|Краткое описание*||textarea|0|0|tenders
srconec|Срок окончания приема заявок (в формате дд.мм.гггг)*||text|0|0|tenders
sotr|Предусмотрено продолжительное сотрудничество|Да;Нет|select|0|0|tenders
valuta|Валюта|{$_REQUEST['valuta']}; Доллары; Евро|select|1|valuta|auto
HTML;

$con_file = fopen(ENGINE_DIR."/data/edit_obj.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/edit_obj.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $edit_obj);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_obj.txt", 0666);

$edit_profile = <<<HTML
fullname|Фамилия Имя Отчество||text|1|1|basic|1|0
sex|Пол|Мужской;Женский|select|1|0|basic|0|1
polsex|Семейное положение|Женат;Замужем;Не женат;Не замужем;Есть подруга;Есть друг;В активном поиске;Помолвлен;Помолвлена;Все сложно|select|1|0|basic|0|1
vzgladi|Политические взгляды|Монархические;Индифферентные;Коммунистические;Умеренные;Либеральные|select|1|0|basic
city|Родной город||dbcity|1|0|basic|1|0
mob_phone|Мобильный телефон||text|1|0|contakti|1|0
dom_phone|Домашний телефон||text|1|0|contakti
icq|ICQ||text|1|0|contakti
birthdate|Дата рождения||dbbirthdate|1|0|basic|0|1
webs|Личный сайт||text|1|0|contakti|0|1
email|Контактный Email||text|1|0|contakti|1|0
info|О себе||textarea|1|0|lichn
deyatelnost|Деятельность||dbconnect|1|0|lichn
interests|Интересы||dbconnect|1|0|lichn
style|Любимый музыкальный стиль||text|1|0|lichn
ishu|Профессия||dbconnect|1|0|basic|0|1
HTML;

$profile_pages = <<<HTML
userinfo_afisha|user_event||События|
userinfo_friend_online|user_friend_online||Друзья на сайте|
userinfo_friend|user_friend||Друзья|
fotoalbum|fotoalbum|1|Фото|
my_video|archiv_video/users|1|Видео|
userinfo_blog|user_blog|1|Блог|
userinfo_groups|user_groups||Сообщества|
HTML;

$con_file = fopen(ENGINE_DIR."/data/edit_profile.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/edit_profile.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $edit_profile);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_profile.txt", 0666);

$dbconfig3 = <<<HTML
<?PHP

\$weather_type_p = "2";
\$idweatyah = "RSXX1219";
\$idcity = "{$row_weathers[id]}";
\$idcity_gm = "{$row_weathers2[name_id]}";
\$altnamecity = "{$translit_weather}";
\$namecity = "{$_REQUEST[city_ckaburg]}";
\$namecitys = "Погода в {$_REQUEST[city_ckaburge]}";

?>
HTML;

$arcade_config = <<<HTML
<?PHP

\$arcade_config = array (
'to_list' => "10",
'rpc_server' => "http://xmlrpc.arcadox.net/",
'title' => "Arcade",
'key' => "",
);

?>
HTML;

$arcconfig = <<<HTML
<?PHP

\$arcconfig = array (
'to_page' => 20,
'allow_comments' => 1,
'comm_nummers' => 30,
'allow_comments_wysiwyg' => 0,
'captcha_comm' => 0,
'comm_msort' => "ASC",
);

?>
HTML;

$block_adv_content_config = <<<HTML
<?PHP

\$config['adv_activ_sa'] = "0";
\$config['adv_sape_num'] = "1a6f837fa4313423b72fdee5a872ed4c";
\$config['adv_razd_sa'] = "";
\$config['adv_numsl_sa'] = "";
\$config['adv_tpl_sa'] = "1";
\$config['adv_activ_sl'] = "0";
\$config['adv_sl_num'] = "4f7e1";
\$config['adv_razd_sl'] = "";
\$config['adv_numsl_sl'] = "";
\$config['adv_tpl_sl'] = "1";
\$config['adv_activ_ml'] = "0";
\$config['adv_ml_num'] = "1";
\$config['adv_razd_ml'] = "";
\$config['adv_numsl_ml'] = "";
\$config['adv_tpl_ml'] = "1";

?>
HTML;

$block_adv_content_config = <<<HTML
<?PHP

\$config['adv_activ_sa'] = "0";
\$config['adv_sape_num'] = "";
\$config['adv_razd_sa'] = "";
\$config['adv_numsl_sa'] = "";
\$config['adv_tpl_sa'] = "0";
\$config['adv_activ_sl'] = "0";
\$config['adv_sl_num'] = "";
\$config['adv_razd_sl'] = "";
\$config['adv_numsl_sl'] = "";
\$config['adv_tpl_sl'] = "0";
\$config['adv_activ_ml'] = "0";
\$config['adv_ml_num'] = "0";
\$config['adv_razd_ml'] = "";
\$config['adv_numsl_ml'] = "";
\$config['adv_tpl_ml'] = "0";

?>
HTML;

$block_advm_config = <<<HTML
<?PHP

\$config['advm_aptek'] = "131";
\$config['advm_rating'] = "25";
\$config['fiemphar_advmn_category'] = '143,132,0';
\$config['afishaphar_advmn_category'] = '0';
\$config['forumphar_advmn_category'] = '37,39';
\$config['question_advmn_category'] = '23,21';

?>
HTML;

$block_afisha_config = <<<HTML
<?PHP

\$config['afisha_vivodim'] = "1";
\$config['afisha_vivodfirm'] = "1";
\$config['afisha_otmetitsa'] = "1";
\$config['afisha_ktodobavil'] = "2";
\$config['afisha_pay'] = "1";
\$config['afisha_data'] = "1";
\$config['osnfotoafisha'] = "200x290";
\$config['min1'] = "175x100";
\$config['min2'] = "175x100";
\$config['min3'] = "175x100";
\$config['afisha_width'] = "200";
\$config['afisha_height'] = "120";
\$config['afisha_tit_cut'] = "40";
\$config['afisha_desc_cut'] = "100";
\$config['fiemphar_afisha_category'] = '0';
\$config['afishaphar_afisha_category'] = '0';
\$config['forumphar_afisha_category'] = '0';
\$config['questionphar_afisha_category'] = '0';

?>
HTML;

$block_allnews_config = <<<HTML
<?PHP

\$config['all_news_vivodim'] = "1";
\$config['all_news_img'] = "{THEME}/img/noscreen120.gif";
\$config['all_news_ktodobavil'] = "15";
\$config['all_news_kolotshta'] = "1";
\$config['all_news_pay'] = "12";
\$config['all_news_data'] = "1";
\$config['all_news_width'] = "180";
\$config['all_news_height'] = "";
\$config['all_news_wfull'] = "98";

?>
HTML;

$block_auth = <<<HTML
<?PHP

\$config['block_auth_vk'] = "";
\$config['block_client_secret_vk'] = "";
\$config['block_application_key_vk'] = "";
\$config['block_auth_tw'] = "";
\$config['block_client_secret_tw'] = "";
\$config['block_application_key_tw'] = "";
\$config['block_auth_od'] = "";
\$config['block_client_secret_od'] = "";
\$config['block_application_key_od'] = "";
\$config['block_auth_fb'] = "";
\$config['block_client_secret_fb'] = "";
\$config['fiemwo_buron_category'] = '0';
\$config['afishawo_buron_category'] = '0';
\$config['forumwo_buron_category'] = '0';
\$config['questionwo_buron_category'] = '0';

?>
HTML;

$block_blogs_config = <<<HTML
<?PHP

\$config['blogs_category'] = "120";
\$config['blogs_colvoglav'] = "1";
\$config['blogs_colvoblog'] = "30";
\$config['blogs_newblogi'] = "1";
\$config['blogs_category_allowrating'] = "1";
\$config['blogs_category_allowcomm'] = "1";
\$config['blogs_activopblok'] = "1";
\$config['blogs_activopglav'] = "2";
\$config['blogs_actktoavt'] = "2";

?>
HTML;

$block_bobrazovanie_config = <<<HTML
<?PHP

\$config['fiemphar_bobrazovanien_category'] = '132,10,0';
\$config['afishaphar_bobrazovanien_category'] = '1012,1011';
\$config['forum_bobrazovanien_category'] = '37,38';
\$config['question_bobrazovanien_category'] = '24,23';

?>
HTML;

$block_buro_config = <<<HTML
<?PHP

\$config['buro_n_id_za'] = "3372";
\$config['buro_n_id_an'] = "3373";
\$config['buro_n_id_region'] = "161";
\$config['buro_n_ktodobavil'] = "5";
\$config['buro_n_pay'] = "5";
\$config['buro_n_width'] = "Внимание! Опасайтесь мошенников!
Никогда не перечисляйте деньги любым способом (через SMS, звонком на спец.номер, банковским переводом, платежом за сотовый, электронными деньгами и т.п.) человеку, нашедшему вашу вещь ДО того момента, пока вы ЛИЧНО не убедитесь, что это вещь ваша и принадлежит именно вам. Если человек неохотно идет на контакт, назначает посредников, сомневается, то, скорее всего, это мошенник. Подробнее о мошенничествах читайте в специальном разделе помощи.";
\$config['buro_n_height'] = "{$_REQUEST['city_osn_name']}";
\$config['fiemwo_buron_category'] = '10,145,0';
\$config['afishawo_buron_category'] = '1012';
\$config['forumwo_buron_category'] = '44';
\$config['questionwo_buron_category'] = '24';

?>
HTML;

$block_dblock_config = <<<HTML
<?PHP

\$config['workdoska_colvoglav'] = "3";
\$config['workdoska_category_allowrating'] = "1";

?>
HTML;

$block_doblock_config = <<<HTML
<?PHP

\$config['otherdoska_colvoglav'] = "3";
\$config['otherdoska_category_allowrating'] = "1";

?>
HTML;

$block_eda_config = <<<HTML
<?PHP

\$config['eda_shablons'] = "page_eda";
\$config['eda_osn1'] = "96";
\$config['eda_osn22'] = "975";
\$config['eda_osn23'] = "100";
\$config['eda_osn3'] = "1153";
\$config['eda_osn4'] = "188";
\$config['eda_osn5'] = "news";
\$config['eda_main_text'] = "<h2>Кафе, бары и рестораны</h2>Раздел «<strong>Рестораны, кафе, бары</strong>», это ваш гид по всем гастрономическим заведениям города. Вы можете выбрать любую подходящую вам кухню и среднюю стоимость чека. Для удобства пользователей присутствует и возможность выбора понравившегося вам кафе, бара или ресторана в подходящем вам. В описании всех кафе и ресторанов обязательно присутствует, как меню ресторана, так и его официальный сайт, где вы можете ознакомиться с заведением более подробно. Помимо этого вы можете прочитать отзывы о любом кафе, баре, ресторане или доставке еды. Все комментарии оставляются реальными посетителями.<br>";
\$config['eda_system_news'] = "1,10,0,1,news_index_top|2,143,0,5,news_index_other_block|3,143,0,5,news_index_other_block|4,143,0,5,news_index_other_block";

?>
HTML;

$block_exclusive_config = <<<HTML
<?PHP

\$config['exclusive_category'] = "212";
\$config['exclusive_names'] = "Эксклюзивно на портале";
\$config['exclusive_colvoglav'] = "6";
\$config['exclusive_colvoblog'] = "6";
\$config['exclusive_category_allowrating'] = "1";
\$config['exclusive_category_allowcomm'] = "1";
\$config['exclusive_system_news'] = "1,214,,,|2,213,,,|3,5,,,|4,215,,,|5,219,,,|6,216,,,";

?>
HTML;

$block_galeryusers_config = <<<HTML
<?PHP

\$config['galeryusers_names'] = "Галерея пользователей";
\$config['galeryusers_limit'] = "19";
\$config['galeryusers_width'] = "66";
\$config['galeryusers_height'] = "";
\$config['galeryusers_group'] = "3";
\$config['galeryusers_activcity'] = "0";

?>
HTML;

$block_gpblock_config = <<<HTML
<?PHP

\$config['gpblock_name'] = "Горячее предложение";
\$config['gpblock_colvoglav'] = "3";
\$config['gpblock_category_allowrating'] = "1";
\$config['gpblock_sort'] = "1";

?>
HTML;

$block_inter_config = <<<HTML
<?PHP

\$config['interblg_colvoglav'] = "14";
\$config['interblg_category_allowrating'] = "1";

?>
HTML;

$block_internet_config = <<<HTML
<?PHP

\$config['fiemphar_internetn_category'] = '229,143';
\$config['afishaphar_internetn_category'] = '0';
\$config['forumphar_internetn_category'] = '37,38';
\$config['questionsp_internetn_category'] = '11,10';

?>
HTML;

$block_interview_config = <<<HTML
<?PHP

\$config['interview_category'] = "5";
\$config['interview_names'] = "Интервью";
\$config['interview_colvoglav'] = "2";
\$config['interview_category_allowrating'] = "1";

?>
HTML;

$block_lastobj_config = <<<HTML
<?PHP

\$config['obj_moder'] = "1";
\$config['obj_srok_sort'] = "320";
\$config['obj_srok_sort_cat'] = "20";
\$config['obj_sort'] = "DESC";
\$config['obj_controls'] = "0";
\$config['obj_city'] = "1";
\$config['obj_oprcitys'] = "00";
\$config['obj_otcena'] = "0";
\$config['obj_docena'] = "10000000";
\$config['user_nikfio'] = "0";
\$config['obj_width'] = "4";
\$config['obj_height'] = "1";
\$config['obj_photo'] = "1";
\$config['obj_cat'] = "00";
\$config['obj_phone'] = '+7XXX XXX XX XX';
\$config['obj_auto_text'] = '<h2>Частные объявления по продаже автомобилей</h2>
<div class="padding_doska_main">
Каждый день люди покупают и продают авто, в том числе и на запчасти. Весьма популярными считаются и подержанные автомобили в хорошем состоянии. Большинство горожан предпочитают именно такой вариант — подержанные авто, нежели новые дорогие варианты.
</div>
<div class="space"></div>
<div class="padding_doska_main">
Конечно, сайтами продажи автомобилей сегодня никого не удивить — их количество, как и число городских машин, трудно выразить в конкретных цифрах. Автобарахолка на портале — это:
</div>
<div class="padding_doska_main">
	<ul class="spisok">
		<li>простой, но удобный интерфейс подбора автообъявлений;</li>
		<li>постоянный мониторинг объявлений по продаже б/у автомобилей, находящейся в нашей базе — подпишитесь на объявления по заданным параметрам;</li>
		<li>гарантия быстрой связи покупателя и продавца — по каждому предложению можно связаться по телефону или почте;</li>
		<li>обилие предложений и удобство их размещения.</li>
	</ul>
</div>
<div class="space"></div>
<div class="padding_doska_main">
Для того чтобы поиск не отнимал много времени, воспользуйтесь фильтром. В нем вы можете указать свои ценовые предпочтения, тип кузова и марку авто, имеющуюся на авторынке в данный момент, год выпуска и др. параметры. Все объявления можно отсортировать по цене или времени добавления объявления о продаже на сайт.
</div>
<div class="space"></div>
<div class="padding_doska_main">
С помощью доски объявлений по продаже подержанных авто вы существенно сэкономите свое время и буквально в несколько кликов найдёте все предложения, рассортированные в нужном порядке.
</div>
<div class="space"></div>
<div class="padding_doska_main">
Прост не только поиск объявлений на екатеринбургском сайте о продаже и покупке авто, но и размещение объявления. Достаточно заполнить все поля формы и загрузить фотографии. Размещение объявлений бесплатно.
</div>';
?>
HTML;

$block_lastuser_config = <<<HTML
<?PHP

\$config['user_sort'] = "DESC";
\$config['user_city_activ'] = "0";
\$config['user_oprcitys'] = "00";
\$config['user_age'] = "";
\$config['user_nikfio'] = "0";
\$config['user_width'] = "4";
\$config['user_height'] = "1";
\$config['user_photo'] = "0";
\$config['user_podpis'] = "1";

?>
HTML;

$block_mesta_config = <<<HTML
<?PHP

\$config['mesta_sort'] = "DESC";
\$config['mesta_vivodfirm'] = "1";
\$config['mesta_colnamecat'] = "<b>Новое место:</b>";
\$config['mesta_icon'] = "2";
\$config['mesta_vivrate'] = "2";
\$config['type_main_firm'] = "2";
\$config['mesta_colcat'] = "5";
\$config['mesta_colfirm'] = "1";
\$config['mesta_presons'] = "<br><br>";
\$config['mesta_cut'] = "250";

?>
HTML;

$block_nedvblock_config = <<<HTML
<?PHP

\$config['nedvdoska_colvoglav'] = "3";
\$config['nedvdoska_category_allowrating'] = "1";

?>
HTML;

$block_otdix_config = <<<HTML
<?PHP

\$config['otdix_aptek'] = "227";
\$config['fiemphar_otdixn_category'] = '132,10,144,0';
\$config['afishaphar_otdixn_category'] = '0';
\$config['forum_otdixn_category'] = '44';
\$config['questionsp_otdixn_category'] = '24,21';

?>
HTML;

$block_resizef_config = <<<HTML
<?PHP

\$config['res_1'] = "410x510";
\$config['res_2'] = "270x420";
\$config['res_3'] = "120x190";
\$config['res_4'] = "410x510";

?>
HTML;

$block_spravka_config = <<<HTML
<?PHP

\$config['spravka_work'] = "1006";
\$config['spravka_im'] = "975";
\$config['spravka_consult'] = "37";
\$config['spravka_dk'] = "spravka";
\$config['spravka_aptek'] = "342";
\$config['spravka_sadigorod'] = "house";
\$config['spravka_do'] = "gorbar";

?>
HTML;

$block_statistics_config = <<<HTML
<?PHP

\$config['statistics_dost'] = "3";
\$config['statistics_ushour'] = "1";
\$config['statistics_usall'] = "2";
\$config['statistics_nwday'] = "1";
\$config['statistics_blday'] = "1";
\$config['statistics_cday'] = "1";
\$config['statistics_dauto'] = "1";
\$config['statistics_ndvall'] = "2";
\$config['statistics_vac'] = "2";
\$config['statistics_rez'] = "2";
\$config['statistics_uson'] = "1";

?>
HTML;

$block_tender_config = <<<HTML
<?PHP

\$config['tenders_n_id_za'] = "3374";
\$config['tenders_n_id_region'] = "161";
\$config['tenders_n_ktodobavil'] = "80";
\$config['tenders_n_width'] = "Текст";
\$config['tenders_n_height'] = "{$_REQUEST['city_osn_name']}";
\$config['fiemwo_tendern_category'] = '147,159,0';
\$config['afishawo_tendern_category'] = '1012';
\$config['forumwo_tendern_category'] = '44';
\$config['questionwo_tendern_category'] = '24';

?>
HTML;

$config_autocat = <<<HTML
<?PHP

\$config['block_auto_banki'] = "1";
\$config['block_auto_banki_type'] = "1";
\$config['block_auto_banki_limit'] = "10";
\$config['autorazdel_block_fo'] = "1";
\$config['block_auto_forum_type'] = "1";
\$config['block_auto_forum_limit'] = "10";
\$config['block_auto_spravka'] = "1";
\$config['block_auto_spravka_text'] = "Оформляем техосмотр! 1000 рубss! для всех видов автотранспорта! Вы получаете официальную диагностическую карту осмотра, внесение данных в базу ЕАИСТО (отправим в электронном виде, возможна распечатка).";
\$config['block_auto_spravka_title'] = "Страховка и техосмотр";
\$config['block_auto_autocat'] = "1";
\$config['autorazdel_spravka_colzs'] = "50";
\$config['block_auto_firm'] = "1";
\$config['block_auto_firm_type'] = "1";
\$config['block_auto_firm_category'] = "1";
\$config['block_auto_firm_limit'] = "15";
\$config['block_auto_doska'] = "1";
\$config['autorazdel_doska'] = "1";
\$config['autorazdel_foto_cols'] = "15";
\$config['block_auto_fotoalbum'] = "1";
\$config['autorazdel_foto'] = "avtomoto";
\$config['autorazdel_foto_col'] = "10";
\$config['autorazdel_block_payedam'] = "1";
\$config['autorazdel_block_foto'] = "1";
\$config['autorazdel_spravka'] = "11";
\$config['autorazdel_autosalon'] = "867";
\$config['autorazdel_system_news'] = "1,10,0,1,news_index_top|2,10,1,5,news_index_other|3,10,2,1,news_index_tema|5,10,0,1,news_index_topdrive|6,10,0,1,news_index_top";

?>
HTML;

$config_awards = <<<HTML
<?PHP

\$config_awards = array(
'version' => "3.2",
'awards_pm' => "1",
'tema' => "Подарки",
'pm_text' => "Уважаемый {name}! <br/>Вам был сделан подарок {medal_image} &quot;{medal_name}&quot; ({medal_alt}) Весом {medal_point} очков!",
'awards_pm_del' => "0",
'tema_del' => "Забрали подарок",
'pm_text_del' => "Уважаемый {name}! <br/>У Вас забрали подарок {medal_image} &quot;{medal_name}&quot; ({medal_alt}) весом {medal_point}!",
'awards_pm_edit' => "0",
'tema_edit' => "Изменение",
'pm_text_edit' => "Уважаемый {name}! <br/>Ваш подарок {medal_old_image} &quot;{medal_old_name}&quot; ({medal_old_alt}) весом {medal_old_point} очков был изменен на {medal_image} &quot;{medal_name}&quot; ({medal_alt}) весом {medal_point} очков!!",
'awards_toppoints' => "1",
'awards_topawards' => "1",
'awards_auto' => "1",
'systemname' => "Подарки от Администрации",
);

?>
HTML;

$config_hotels = <<<HTML
<?PHP

\$config['vib_categorys_hotels'] = "204";
\$config['vib_categorys_ho'] = "205";
\$config['vib_hot_kv'] = "198";
\$config['vib_hot_h'] = "199";
\$config['multicat_ho'] = "1";
\$config['mcat_ho'] = "665";
\$config['brok_ho'] = "973";
\$config['hotels_shablons'] = "page_hotels";
\$config['sum_page_ho'] = "10";
\$config['city_page_ho'] = "8";
\$config['res_ho'] = "20";
\$config['hotels_system_news'] = "1,10,0,1,news_index_top|2,10,0,7,news_index_other_block";
\$config['obj_hotels_text'] = '<h2>Гостиницы</h2>
<p><b>Бронирование через интернет, цены и заказ номеров</b> в отелях. Отзывы о гостиницах, домашних гостиницах и квартирах посуточно.</p>
<p>Выбор гостиничного номера, на первый взгляд, – весьма несложное занятие. Но все же следует учесть несколько нюансов, которые помогут вам подобрать номер, идеально соответствующий вашим запросам, когда вы выбираете номер гостиницы. </p>
<p>Итак, начнем со «звезд». Разумеется, что <strong>гостиницы с высоким рангом</strong> располагают шикарными номерами, обслуживанием наивысшего качества, и, соответственно, высокими ценами.  5-звездочные отели обычно располагаются вблизи исторических памяток, культурных достопримечательностей или просто в уютном месте с роскошной природой. Качество обслуживания, техническая оснащенность, кухня и прочие предлагаемые сервисы таких гостиниц не знают равных. Гостиница в 4 звезды уступает лишь в роскоши, но это совсем не ограничивает уют и комфорт посетителей. Здесь, помимо основных удобств, обычно присутствуют конференц-залы, рестораны, спортивные комплексы, что прекрасно подходит как для отдыха, так и для деловых встреч. 3 звезды выбирают большинство клиентов. Соотношение цены и качества здесь, пожалуй, самое справедливое. Это идеальный вариант для продолжительного отдыха. 2-звездочные гостиницы самые дешевые. В номере такого отеля располагается минимум необходимой мебели. Обычно такие гостиницы занимают небольшие здания, возможно придорожные. Это вариант, подходящий для минималистов и любителей скромного ненадоедливого сервиса. </p>
<p>Определившись с выбором гостиницы, перейдем к подбору идеального для вас номера. Аналогично градации среди гостиниц, классифицируются и предоставляемые ими номера. Существуют номера эконом класса, стандартные и люкс. Некоторые отели  могут предлагать особые варианты номеров, но это не распространено повсеместно.  Вам достаточно всего лишь определится с набором услуг, которые понадобятся вам во время пребывания в гостинице. </p>
<p>Благодаря удобному сервису поиска, можно подобрать наиболее подходящий вариант. Запросы можно вводить исходя из предпочитаемой цены, месторасположения и «звезд». Поиск гостиницы так же осуществляется по названию. Исходя из ваших требований, сервис выдаст вам гостиницы с контактами и описанием для бронирования через интернет. Здесь вы сможете ознакомиться с подробной информацией о гостинице, перечне предоставляемых услуг, ценах и т.п. При необходимости можно забронировать номер онлайн. Для этого следует заполнить несложную форму, выбрав подходящие варианты, и оставить свои контакты. Приятного отдыха! </p>';
\$config['obj_hotels_right_text'] = '<h2>Гостиницы</h2>
<p>У гостей и жителей всегда есть возможность свободного выбора места комфортного отдыха в гостинице, отеле или в квартире, сдаваемой посуточно. На страницах квартир и гостиниц указанно время необходимое на дорогу из отеля до аэропорта или ж/д вокзала, описание всех возможных номеров и цены на проживание в гостинице.</p>
<p><strong>В разделе «Информация» каждого отеля и гостиницы</strong> вы узнаете о дополнительных скидках и акциях, а также дополнительных сервисах в данном отеле. Вы можете подобрать квартиру посуточно, отель или гостиницу в том районе, где будет проходить ваше мероприятие. В разделе конференц-залов вы можете сделать бронирование, а также выбрать дополнительные услуги.</p>';

?>
HTML;

$config_mebel = <<<HTML
<?PHP

\$config['vib_categorys_mebel'] = "130";
\$config['vib_mebel_ho'] = "254";
\$config['sum_page_mebel'] = "10";
\$config['city_page_mebel'] = "30";
\$config['fiemphar_mebel_category'] = '132,10';
\$config['afishaphar_mebel_category'] = '0';
\$config['forumphar_mebel_category'] = '0';
\$config['questionphar_mebel_category'] = '0';

?>
HTML;

$config_mustcomm = <<<HTML
<?PHP

\$config_mustcomm = array(
'version' => "v.1.2",
'kolichestvo' => "10",
'text' => "",
'url' => "20",
'symbol' => "»",
);

?>
HTML;

$config_pharmacy = <<<HTML
<?PHP

\$config['vib_categorys_pharamcy'] = "342";
\$config['vib_pharamcy_ho'] = "114";
\$config['sum_page_pharamcy'] = "10";
\$config['city_page_pharamcy'] = "10";
\$config['fiemphar_news_category'] = '132';
\$config['afishaphar_news_category'] = '0';
\$config['forumphar_news_category'] = '44';
\$config['questionphar_news_category'] = '18';

?>
HTML;

$config_srd = <<<HTML
<?PHP

\$config['vib_categorys_srd'] = "838";
\$config['vib_srd_ho'] = "201";
\$config['sum_page_srd'] = "10";
\$config['city_page_srd'] = "20";
\$config['fiemphar_srd_category'] = '144,0';
\$config['afishaphar_srd_category'] = '0';
\$config['forumphar_srd_category'] = '44';
\$config['questionphar_srd_category'] = '24';

?>
HTML;

$config_music = <<<HTML
<?PHP

\$config['music_muzstyle'] = "1";
\$config['music_sortstyle'] = "ASC";
\$config['music_colstyle'] = "35";
\$config['music_bsearch'] = "1";
\$config['music_bnews'] = "1";
\$config['music_bmalb'] = "1";
\$config['music_colalb'] = "10";
\$config['music_balph'] = "1";
\$config['music_btopus'] = "1";
\$config['music_coltopus'] = "10";
\$config['music_newscat'] = "00";
\$config['music_colnews'] = "20";
\$config['music_about_image'] = "0";
\$config['music_about_dwnl'] = "1";
\$config['autorazdel_system_news'] = "1,10,0,1,news_index_top|2,10,1,5,news_index_other";

?>
HTML;

$config_photo_pay = <<<HTML
<?PHP

\$config['10x15']="3";
\$config['10x135']="4";
\$config['15x21']="5";
\$config['20x30']="6";
\$config['30x45']="7";
\$config['40x60']="8";
\$config['50x75']="9";
\$config['60x90']="25";
\$config['pay_kadr']="10";
\$config['pay_krgl']="10";
\$config['pay_pol']="4";
\$config['st_bumgla']="10";
\$config['pay_dostavka']="150";
\$config['st_bummat']="20";

?>
HTML;

$config_pkinopoisk = <<<HTML
<?PHP

\$conf_pk = array (
'user' => "afisherw",
'pass' => "",
't_year' => "off",
't_country' => "off",
't_genre' => "off",
't_actors' => "off",
't_director' => "off",
't_screenwriter' => "off",
'aud_type' => "off",
'rate_pg_type' => "off",
'pars_poster_film' => "off",
'kol_kadr' => "0",
'kol_scrin' => "0",
'tumb_kadr' => "",
'jpeg_quality' => "100",
'max_up_side' => "0",
'tumb_kadr_type' => "0",
'imag_cut' => "off",
'watermark_on' => "off",
'pars_poster_film_big' => "off",
'tumb_poster' => "",
'tumb_poster_type' => "0",
'poster_film_alter' => "",
'del_tir' => "off",
'pars_trivia' => "off",
'pars_com' => "0",
'sort_com' => "off",
'proxy_type' => "0",
'proxy' => "",
'group_ap' => array("0","1"),
'sleep' => "0",
'imag_separ' => "off",
);
\$templ_title = "";
\$templ_show = "";
\$templ_full = "";
\$catSoot = array(
);

?>
HTML;

$config_vip = <<<HTML
<?PHP

\$config_vip = array(
'version_id' => "2.6",
'writefile' => "no",
'namefile' => "vip.dat",
'separator' => "|",
'quantityhour' => "0",
'demo_key' => "no",
'demo_quant' => "1",
'hide_all_delete_key' => "no",
'your_browser' => "mozilla",
'sendemail' => "yes",
'address' => "support@dle-tools.ru",
'email_head' => "Новая активация на сайте",
'charset' => "windows-1251",
'content_type' => "plain",
'send_demo' => "yes",
'sendpm' => "no",
'pm_head' => "Новая активация на сайте",
'user_from' => "Adobe",
'status_read' => "no",
'admin_id' => "1",
'head_up_form' => "Чтобы получить клиента V.I.P введите Ваш персональный ключ:",
'color_up_form' => "008000",
'size_activ_form' => "40",
'color_background' => "e0f7bd",
'caption_button' => "Активировать",
'caption_demo_button' => "Получить демо",
'oldfile' => "vip.dat",
);

?>
HTML;

$datting_config = <<<HTML
<?PHP

\$config['datting_descr'] = "Реальные знакомства, расширенный поиск анкет, возможность оценки фотографий в ТОП 100";
\$config['datting_keyw'] = "знакомства, анкеты, автопортреты, найди, записи, пользователи, новые анкеты, расширенный поиск";
\$config['datting_descr_ak'] = "Анкета пользователя, страница которая содержит всю необходимую информацию для знакомства,  Фотографии пользователя, Дневник пользователя. Вы можете сделать подарок, отправить сообщение.";
\$config['datting_keyw_ak'] = "анкета пользователя, страница, информация, знакомства, фотографии, подарок, сделать подарок, автопортрет, дневник";
\$config['datting_descr_av'] = "Автопортрет пользователя, страница которая содержит всю необходимую информацию для знакомства,  Фотографии пользователя, Дневник пользователя. Вы можете сделать подарок, отправить сообщение.";
\$config['datting_keyw_av'] = "анкета пользователя, страница, информация, знакомства, фотографии, подарок, сделать подарок, автопортрет, дневник";
\$config['datting_newcity'] = "00";
\$config['datting_new_ageot'] = "";
\$config['datting_new_agedo'] = "";
\$config['datting_twcity'] = "00";
\$config['datting_tw_ageot'] = "";
\$config['datting_tw_agedo'] = "";
\$config['datting_tpcity'] = "00";
\$config['datting_tp_ageot'] = "";
\$config['datting_tp_agedo'] = "";
\$config['datting_width'] = "7";
\$config['datting_height'] = "10";

?>
HTML;

$files_config = <<<HTML
<?PHP

\$filesConfig['nfmain']                = 15;
\$filesConfig['fcat']                = 15;
\$filesConfig['maxsize']            = 1536000000;
\$filesConfig['accepted_files']  = "zip,rar,gz,avi,mp3";
\$filesConfig['title_mirror1']  = "Зеркало 1";
\$filesConfig['title_mirror2']  = "Зеркало 2";
\$filesConfig['numfiles']                = 1;
\$filesConfig['allowed_guest_com']       = 1;
\$filesConfig['show_sub_files']       = 1;
\$filesConfig['allow_comments']       = 1;
\$filesConfig['hide_url']       = 1;
\$filesConfig['auto_category']       = 1;
\$filesConfig['down_guest']       = 0;
\$filesConfig['fcount']       = 1;
\$filesConfig['widththumb']       = 200;
\$filesConfig['maxsize_thumb']            = 307200;
\$filesConfig['allow_watermark']       = 1;
\$filesConfig['max_watermark']       = 150;
\$filesConfig['allow_screenshot']       = 1;
\$filesConfig['default_screenshot']       = 1;
\$filesConfig['numbernewfiles']       = 30;

?>
HTML;

$forum_config = <<<HTML
<?PHP

\$forum_config = array (
'forum_title' => "Форум",
'forum_url' => "",
'meta_descr' => "",
'meta_keywords' => "",
'meta_topic' => "1",
'sep_subforum' => ",&amp;nbsp;",
'sep_moderators' => ",&amp;nbsp;",
'last_abc' => "20",
'mod_rewrite' => "1",
'wysiwyg' => "0",
'offline' => "0",
'timestamp' => "j F Y H:i",
'sessions_log' => "1",
'session_time' => "15",
'stats' => "1",
'online' => "1",
'forum_bar' => "1",
'topic_inpage' => "25",
'topic_hot' => "30",
'post_inpage' => "20",
'post_hide' => "10",
'topic_abc' => "0",
'post_maxlen' => "10000",
'auto_wrap' => "80",
'post_update' => "1",
'last_plink' => "1",
'hide_forum' => "0",
'topic_sort' => "1",
'topic_email' => "1",
'forum_pr_imp' => "Важно:",
'forum_pr_vote' => "Опрос:",
'forum_pr_modr' => "Модерация:",
'forum_pr_sub' => "Подфорумы:",
'mod_report' => "0",
'flood_time' => "15",
'warn' => "1",
'warn_max' => "5",
'warn_day' => "3",
'warn_show' => "1",
'warn_show_all' => "0",
'warn_sh_pg' => "0",
'subscription' => "1",
'mod_icq' => "1",
'mod_rank' => "1",
'reputation' => "1",
'ses_forum' => "1",
'ses_topic' => "1",
'bot_agent' => "1",
'discuss' => "1",
'discuss_title' => "1",
'discuss_title_tpl' => "Статья: {post_title}",
'tools_disc_post' => "1",
'discuss_post_tpl' => "Здесь обсуждается статья: [url={post_link}]{post_title}[/url]",
'set_topic_post' => "1",
'set_post_num_up' => "0",
'set_post_num_day' => "1",
'topic_new_day' => "5",
'set_sub_last_up' => "1",
'upload_type' => "zip,rar,exe,doc,pdf",
'img_upload' => "1",
'img_size' => "1024",
'thumb_size' => "150",
'jpeg_quality' => "85",
'tag_img_width' => "0",
'warn_group' => "1",
'search_captcha' => "5",
'topic_captcha' => "5",
'post_captcha' => "5",
'tools_upload' => "1",
'tools_poll' => "1:2",
'warn_show_group' => "1:2:3",
'rep_edit_group' => "1",
'version_id' => "2.6",
);

?>
HTML;

$fotoalbum_config = <<<HTML
<?PHP

\$FAConfig = array (
'off' => "0",
'allow_alt_url' => "yes",
'allow_cache' => "1",
'work_prefix' => "fotoalbum/",
'cover_size' => "48",
'thumb_size' => "90",
'fullsize' => "450",
'quality' => "85",
'main_hor' => "3",
'main_vert' => "10",
'alb_hor' => "5",
'alb_vert' => "10",
'min_foto_for_show' => "0",
'max_title_alb' => "40",
'max_desc_alb' => "150",
'cpanel_allow' => "1",
'limit_album' => "100",
'limit_images' => "1000",
'max_title_foto' => "50",
'max_desc_foto' => "200",
'allowed_extensions' => "gif,jpg,png,jpe,jpeg",
'max_image_size' => "1025",
'max_file_size' => "4000",
'max_zipsize' => "120",
'limit_onceupload' => "200",
'resize_foto' => "1025",
'insert_watermark' => "1",
'view_level' => "1,2,3,4,5",
'upload_level' => "1,2,3,4",
'comment_level' => "1,2,3,4",
'edit_level' => "1",
'ts_by_day' => "H:i:s",
'ts_fullimage' => "j F Y H:i",
'thumbs_in_fullimage' => "5",
'rate_levels' => "10",
'short_rating' => "1",
'rate_level' => "1,2,3,4",
'comms_suscribe' => "1",
'activ_platn_del' => "0",
'partner_smsidonline' => "741",
'version' => "1.0",
'skin_name' => "",
'resize' => "100",
);

?>
HTML;

$garage_config = <<<HTML
<?PHP

\$config['garage_col_com'] = "50";
\$config['garage_jurnal'] = "1";
\$config['garage_foto_1'] = "480x360";
\$config['garage_foto_2'] = "240x180";
\$config['garage_foto_3'] = "120x90";
\$config['garage_kolgolosov'] = "5";
\$config['garage_vote_period'] = "day";
\$config['garage_vote_ip'] = "1";

?>
HTML;

$import_auto = <<<HTML
<?PHP

\$confms = array (
'imp_catin' => "3",
'imp_name' => "yes",
'imp_latlng' => "yes",
'imp_foto' => "0",
'city' => "50",
);

?>
HTML;

$import_kinoafisha = <<<HTML
<?PHP

\$confms = array (
'city' => "{$_REQUEST[city_osn_name]}",
);

?>
HTML;

$import_market_nedv = <<<HTML
<?PHP

\$confms = array (
'imp_catin' => "sale#prodazha-kvartir#sverdlovskoy-oblasti",
'imp_catout' => "9",
'imp_name' => "yes",
'imp_latlng' => "yes",
'city' => "svr",
);

?>
HTML;

$import_nedv = <<<HTML
<?PHP

\$confms = array (
'imp_catin' => "sale#prodazha-kvartir#sverdlovskoy-oblasti",
'imp_catout' => "9",
'imp_name' => "yes",
'imp_latlng' => "yes",
'city' => "svr",
);

?>
HTML;

$import_work = <<<HTML
<?PHP

\$confms = array (
'imp_name' => "yes",
'imp_latlng' => "yes",
'city' => "145",
);

?>
HTML;

$invite_conf = <<<HTML
<?PHP

\$invite_config = array (
'max_limit' => "100",
'max_fromme' => "300",
'capcha_code' => "no",
'mail_subject' => "Ваш друг ({%sender-name%}) приглашает вас зарегистрироваться на сайте {%home-title%}",
'mail_text' => "Уважаемый {%friend-name%}, ваш друг {%name%} предложил вам регистрацию у нас на сайте.
\   Для регистрации перейдите по ссылке {%reg-link%}!
\
\   От {%name%} :
\   {%invite_text%}
\
\   С Уважением, {$config['http_home_url']}
\   Не сочтите за спам, спасибо!",
);

?>
HTML;

$lclubs_config = <<<HTML
<?PHP

\$config['lclubs_forum'] = "1";
\$config['lclubs_yagomaps'] = "1";
\$config['lclubs_activforum'] = "1";
\$config['lclubs_news'] = "1";
\$config['lclubs_kartochka'] = "1";
\$config['lclubs_url'] = "1";

?>
HTML;

$market_config = <<<HTML
<?PHP

\$config['pay_market'] = "1";
\$config['market_search'] = "1";
\$config['market_alpha'] = "1";
\$config['market_comments'] = "1";
\$config['market_imayan'] = "2";
\$config['market_zakaz'] = "2";
\$config['pay_click'] = "1.5";
\$config['pay_publick'] = "150";

?>
HTML;

$referer_conf = <<<HTML
<?PHP

\$confms = array (
'max_ref' => "1000",
'sea_addi' => "no",
'sea_iconv' => "yes",
'sea_flate' => "yes",
'site_ignor' => "",
'sea_sort' => "date",
'sea_msort' => "DESC",
'func_block' => "no",
'typ_block' => "0",
'block_sea' => "15",
'block_link' => "55",
);

?>
HTML;

$referer_perf = <<<HTML
<?PHP

\$engines = array ("yandex.ru", "rambler.ru", "mail.ru", "gogo.ru", "aport.ru", "search.live.com", "google.all", "webalta.ru", "search.ru.redtram.com", "yahoo.com", "nigma.ru", "altavista.com", "msn.com");

\$engine = array (
"yandex.ru" 		=> array("yandex.ru", "Y", "text=", "Яndex.ru", "http://yandex.ru/", "yandex.png"),
"rambler.ru" 		=> array("rambler.ru", "R", "words=", "Рамблер", "http://rambler.ru/", "rambler.png"),
"mail.ru" 		=> array("mail.ru", "L", "q=", "Mail.ru", "http://go.mail.ru/", "mail.png"),
"gogo.ru" 		=> array("gogo.ru", "O", "q=", "gogo.ru", "http://gogo.ru/", "gogo.png"),
"aport.ru" 		=> array("aport.ru", "A", "r=", "Апорт", "http://aport.ru/", "aport.png"),
"google.all" 		=> array("google.all", "G", "q=", "Google All", "http://google.ru/", "google.png"),
"search.live.com" 	=> array("search.live.com", "S", "q=", "Live Search", "http://search.live.com/", "live.png"),
"webalta.ru"  		=> array("webalta.ru", "W", "q=", "WebAlta.ru", "http://webalta.ru/", "webalta.png"),
"search.ru.redtram.com" => array("search.ru.redtram.com", "", "q=", "RedTram", "http://search.ru.redtram.com/", "redtram.png"),
"yahoo.com"  		=> array("yahoo.com", "H", "p=", "Yahoo!", "http://yahoo.com/", "yahoo.png"),
"nigma.ru"  		=> array("nigma.ru", "N", "q=", "Nigma.Ru", "http://nigma.ru/", "nigma.png"),
"altavista.com"  	=> array("altavista.com", "", "q=", "AltaVista", "http://altavista.com/", "altavista.png"),
"msn.com" 		=> array("msn.com", "M", "q=", "MSN", "http://msn.com/", "ico" => "msn.png"),
);

?>
HTML;

$tagconfig = <<<HTML
<?PHP

\$confmt = array (
'disp' => "50",
'name' => "interes",
'urlcode' => "default",
'displaymin' => "2",
'sort' => "random",
'link' => "<a style=\"{colorsize}\" title=\"Интерес: {tagname} ({count})\" href=\"{taglink}\" class=\"cloud-tags\">{tagname}</a>",
'separator' => " ",
'max_size' => "12",
'min_size' => "10",
'type_font' => "px",
'arb_color' => "yes",
'max_color' => "#757575",
'min_color' => "#4a92ad",
'no_tags' => "В настоящий момент для вывода нету не одного тега",
'key' => "",
);

?>
HTML;

$user_config = <<<HTML
<?PHP

\$config['user_city_vib'] = "0";

?>
HTML;

$video_config = <<<HTML
<?PHP

\$config['video_cat'] = "9";
\$config['video_cat_other'] = "9";
\$config['video_multicat'] = "1";
\$config['video_catname'] = "onlinevideo";
\$config['video_nomplayer'] = "7";
\$config['video_ppage'] = "12";
\$config['video_cols'] = "4";
\$config['video_width'] = "140";
\$config['video_height'] = "180";
\$config['video_hs'] = "1";
\$config['video_cut'] = "20";

?>
HTML;

$wap_config = <<<HTML
<?PHP

\$wapconfig = array (
'shab_dir' => "/wap/",
'links_dir' => "/wap",
'template_dir' => "/wap/templates",
'newpost' => "5",
'titleword' => "25",
'newpostcat' => "40",
'online' => "yes",
'register' => "yes",
'chpu_url_news' => "2",
'newspage' => "10",
'postsort' => "date",
'image' => "yes",
'postdate' => "yes",
'postautor' => "yes",
'postread' => "yes",
'poststory' => "no",
'postfullstory' => "yes",
'postreadupdate' => "yes",
'statsic_read_update' => "yes",
'static_image' => "no",
'group' => "yes",
'comm_num' => "yes",
'info' => "yes",
'icq' => "yes",
'news_num' => "yes",
'email' => "yes",
'stats_on' => "yes",
'stats_post' => "yes",
'stats_post_public' => "yes",
'stats_post_public_main' => "yes",
'stats_post_moder' => "yes",
'stats_comments' => "yes",
'stats_user' => "yes",
'stats_user_ban' => "yes",
'stats_top_list' => "yes",
'stats_top_list_sort' => "comm_num",
'stats_top_list_user' => "5",
);

?>
HTML;

////////////// НОВЫЕ ОТ ВЕРСИИ 7.0 ////////////////////////

$citys_curs = <<<HTML
moskva;chelyabinsk;ekaterinburg;sankt-peterburg;chelyabinsk;nizhniy_novgorod
HTML;

$citys_raspisanie = <<<HTML
|183;Азия
|213;Москва
|2;Санкт-Петербург
|225;Россия
|10002;Северная Америка
|10003;Южная Америка
|138;Австралия и Океания
|241;Африка
|245;Арктика и Антарктика
|213;Москва
|214;Долгопрудный
|215;Дубна
|216;Зеленоград
|217;Пущино
|349;Другие города региона
|350;Универсальное
|219;Черноголовка
|10740;Мытищи
|10738;Люберцы
|10743;Одинцово
|10747;Подольск
|20571;Жуковский
|10752;Сергиев Посад
|10716;Балашиха
|10742;Ногинск
|10748;Пушкино
|10750;Раменское
|10758;Химки
|10765;Щелково
|10754;Серпухов
|10734;Коломна
|10745;Орехово-Зуево
|10733;Клин
|10761;Чехов
|10756;Ступино
|10735;Красногорск
|20523;Электросталь
|20728;Королёв
|21621;Реутов
|10719;Видное
|21622;Железнодорожный
|10725;Домодедово
|10755;Солнечногорск
|10723;Дмитров
|10746;Павловский Посад
|20674;Троицк
|413;Другие города региона
|414;Универсальное
|11119;Татарстан
|542;Универсальное
|11158;Курганская область
|11162;Свердловская область
|11176;Тюменская область
|11193;Ханты-Мансийский АО
|11225;Челябинская область
|11232;Ямало-Ненецкий АО
|573;Другие города региона
|574;Универсальное
|11235;Алтайский край
|11266;Иркутская область
|11282;Кемеровская область
|11309;Красноярский край
|11316;Новосибирская область
|11318;Омская область
|10231;Республика Алтай
|11330;Республика Бурятия
|10233;Республика Тыва
|11340;Республика Хакасия
|11353;Томская область
|21949;Забайкальский край
|605;Другие города региона
|606;Универсальное
|11403;Магаданская область
|11398;Камчатский край
|10243;Еврейская автономная область
|10251;Чукотский автономный округ
|11457;Хабаровский край
|11409;Приморский край
|11375;Амурская область
|11443;Республика Саха (Якутия)
|11450;Сахалинская область
|86;Атланта
|87;Вашингтон
|89;Детройт
|90;Сан-Франциско
|91;Сиэтл
|200;Лос-Анджелес
|202;Нью-Йорк
|223;Бостон
|637;Прочее
|638;Универсальное
|1048;Прочее
|1049;Универсальное
|97;Гейдельберг
|98;Кельн
|99;Мюнхен
|100;Франкфурт-на-Майне
|101;Штутгарт
|177;Берлин
|178;Гамбург
|701;Прочее
|702;Универсальное
|118;Нидерланды
|119;Норвегия
|120;Польша
|121;Словакия
|122;Словения
|123;Финляндия
|124;Франция
|125;Чехия
|126;Швейцария
|127;Швеция
|180;Сербия
|203;Дания
|204;Испания
|205;Италия
|733;Прочее
|734;Универсальное
|96;Германия
|102;Великобритания
|113;Австрия
|114;Бельгия
|115;Болгария
|116;Венгрия
|246;Греция
|980;Страны Балтии
|20574;Кипр
|10069;Мальта
|10083;Хорватия
|21610;Черногория
|983;Турция
|139;Новая Зеландия
|211;Австралия
|829;Прочее
|830;Универсальное
|893;Прочее
|894;Универсальное
|29630;Минская область
|29631;Гомельская область
|29633;Витебская область
|29632;Брестская область
|29634;Гродненская область
|29629;Могилевская область
|157;Минск
|925;Прочее
|926;Универсальное
|29406;Алматинская область
|29411;Карагандинская область
|29403;Акмолинская область
|29408;Восточно-Казахстанская область
|29415;Павлодарская область
|29412;Костанайская область
|29410;Западно-Казахстанская область
|29416;Северо-Казахстанская область
|29417;Южно-Казахстанская область
|29404;Актюбинская область
|29407;Атырауская область
|29414;Мангистауская область
|29409;Жамбылская область
|29413;Кызылординская область
|170;Туркмения
|171;Узбекистан
|187;Украина
|207;Киргизия
|208;Молдова
|209;Таджикистан
|958;Универсальное
|957;Прочее
|149;Беларусь
|159;Казахстан
|167;Азербайджан
|168;Армения
|29386;Абхазия
|29387;Южная Осетия
|129;Беер-Шева
|130;Иерусалим
|131;Тель-Авив
|132;Хайфа
|765;Прочее
|766;Универсальное
|994;Индия
|995;Таиланд
|1004;Ближний Восток
|134;Китай
|135;Корея
|137;Япония
|797;Прочее
|798;Универсальное
|169;Грузия
|861;Прочее
|862;Универсальное
|20544;Киевская область
|20549;Полтавская область
|20546;Черкасская область
|20545;Винницкая область
|20548;Кировоградская область
|20547;Житомирская область
|20538;Харьковская область
|20536;Донецкая область
|20537;Днепропетровская область
|20540;Луганская область
|20539;Запорожская область
|20541;Одесская область
|20543;Николаевская область
|20542;Херсонская область
|20529;Львовская область
|20535;Хмельницкая область
|20531;Тернопольская область
|20534;Ровенская область
|20533;Черновицкая область
|20550;Волынская область
|20530;Закарпатская область
|20532;Ивано-Франковская область
|20552;Сумская область
|20551;Черниговская область
|10313;Кишинев
|10317;Тирасполь
|10314;Бельцы
|10315;Бендеры
|33883;Комрат
|115675;Универсальное
|115674;Прочее
|17;Северо-Запад
|26;Юг
|40;Поволжье
|52;Урал
|59;Сибирь
|73;Дальний Восток
|381;Прочее
|382;Общероссийские
|3;Центр
|102444;Северный Кавказ
|115092;Крымский федеральный округ
|978;Другие города региона
|979;Универсальное
|146;Симферополь
|959;Севастополь
|11470;Ялта
|11464;Керчь
|11469;Феодосия
|11463;Евпатория
|11471;Алушта
|981;Прочее
|982;Универсальное
|206;Латвия
|117;Литва
|179;Эстония
|1054;Прочее
|1055;Универсальное
|181;Израиль
|210;Объединенные Арабские Эмираты
|1056;Египет
|79;Магадан
|21782;Прочее
|21781;Универсальное
|78;Петропавловск-Камчатский
|21793;Универсальное
|21794;Прочее
|11393;Биробиджан
|21783;Универсальное
|21784;Прочее
|11458;Анадырь
|21785;Универсальное
|21786;Прочее
|76;Хабаровск
|11453;Комсомольск-на-Амуре
|21789;Универсальное
|21790;Прочее
|75;Владивосток
|974;Находка
|11426;Уссурийск
|21780;Прочее
|21779;Универсальное
|77;Благовещенск
|21791;Универсальное
|21792;Прочее
|11374;Белогорск
|11391;Тында
|74;Якутск
|21787;Универсальное
|21788;Прочее
|80;Южно-Сахалинск
|21777;Универсальное
|21778;Прочее
|197;Барнаул
|975;Бийск
|11251;Рубцовск
|21796;Универсальное
|21797;Прочее
|11256;Ангарск
|976;Братск
|63;Иркутск
|11273;Усть-Илимск
|21798;Универсальное
|21799;Прочее
|64;Кемерово
|11287;Междуреченск
|237;Новокузнецк
|11291;Прокопьевск
|21800;Универсальное
|21801;Прочее
|11302;Ачинск
|62;Красноярск
|11311;Норильск
|20086;Железногорск
|21802;Универсальное
|21803;Прочее
|11306;Кайеркан
|11314;Бердск
|65;Новосибирск
|21804;Универсальное
|21805;Прочее
|66;Омск
|21807;Прочее
|21806;Универсальное
|11319;Горно-Алтайск
|21808;Универсальное
|21809;Прочее
|198;Улан-Удэ
|21810;Универсальное
|21811;Прочее
|11333;Кызыл
|21812;Универсальное
|21813;Прочее
|1095;Абакан
|11341;Саяногорск
|21814;Универсальное
|21815;Прочее
|67;Томск
|21816;Универсальное
|21817;Прочее
|11351;Северск
|53;Курган
|21825;Универсальное
|21826;Прочее
|54;Екатеринбург
|11164;Каменск-Уральский
|11168;Нижний Тагил
|11170;Новоуральск
|11171;Первоуральск
|21828;Прочее
|21827;Универсальное
|55;Тюмень
|11175;Тобольск
|21829;Универсальное
|21830;Прочее
|11173;Ишим
|57;Ханты-Мансийск
|973;Сургут
|1091;Нижневартовск
|21831;Универсальное
|21832;Прочее
|56;Челябинск
|235;Магнитогорск
|11212;Миасс
|11202;Златоуст
|11217;Сатка
|11214;Озерск
|11218;Снежинск
|21833;Универсальное
|21834;Прочее
|58;Салехард
|21835;Универсальное
|21836;Прочее
|46;Киров
|21837;Универсальное
|21838;Прочее
|11071;Кирово-Чепецк
|41;Йошкар-Ола
|21839;Универсальное
|21840;Прочее
|11080;Арзамас
|47;Нижний Новгород
|11083;Саров
|21841;Универсальное
|21842;Прочее
|972;Дзержинск
|20258;Сатис
|20044;Кстово
|20040;Выкса
|48;Оренбург
|11091;Орск
|21843;Универсальное
|21844;Прочее
|49;Пенза
|21845;Универсальное
|21846;Прочее
|50;Пермь
|11110;Соликамск
|21847;Универсальное
|21848;Прочее
|172;Уфа
|11114;Нефтекамск
|11115;Салават
|11116;Стерлитамак
|21849;Универсальное
|21850;Прочее
|42;Саранск
|21852;Универсальное
|21853;Прочее
|43;Казань
|236;Набережные Челны
|11127;Нижнекамск
|21854;Универсальное
|21855;Прочее
|11123;Елабуга
|11121;Альметьевск
|11122;Бугульма
|11125;Зеленодольск
|11129;Чистополь
|51;Самара
|240;Тольятти
|11139;Сызрань
|21856;Универсальное
|21857;Прочее
|11132;Жигулевск
|194;Саратов
|11143;Балаково
|21858;Универсальное
|21859;Прочее
|11147;Энгельс
|44;Ижевск
|11150;Глазов
|21860;Универсальное
|21861;Прочее
|11152;Сарапул
|195;Ульяновск
|11155;Димитровград
|21862;Универсальное
|21863;Прочее
|45;Чебоксары
|21864;Универсальное
|21865;Прочее
|37;Астрахань
|21866;Универсальное
|21867;Прочее
|38;Волгоград
|10951;Волжский
|21868;Универсальное
|21869;Прочее
|1107;Анапа
|35;Краснодар
|970;Новороссийск
|239;Сочи
|1058;Туапсе
|10990;Геленджик
|10987;Армавир
|10993;Ейск
|21870;Универсальное
|21871;Прочее
|1093;Майкоп
|21872;Универсальное
|21873;Прочее
|28;Махачкала
|21874;Универсальное
|21875;Прочее
|1092;Назрань
|21876;Универсальное
|21877;Прочее
|30;Нальчик
|21878;Универсальное
|21879;Прочее
|1094;Элиста
|21880;Универсальное
|21881;Прочее
|1104;Черкесск
|21882;Универсальное
|21883;Прочее
|33;Владикавказ
|21884;Универсальное
|21885;Прочее
|39;Ростов-на-Дону
|11053;Шахты
|971;Таганрог
|238;Новочеркасск
|11036;Волгодонск
|21886;Универсальное
|21887;Прочее
|11043;Каменск-Шахтинский
|36;Ставрополь
|11067;Пятигорск
|11063;Минеральные Воды
|11057;Ессентуки
|11062;Кисловодск
|21888;Универсальное
|21889;Прочее
|11064;Невинномысск
|1106;Грозный
|21890;Универсальное
|21891;Прочее
|2;Санкт-Петербург
|969;Выборг
|10867;Гатчина
|21892;Универсальное
|21893;Прочее
|20;Архангельск
|10849;Северодвинск
|21894;Универсальное
|21895;Прочее
|21;Вологда
|21896;Универсальное
|21897;Прочее
|968;Череповец
|22;Калининград
|21898;Универсальное
|21899;Прочее
|10894;Апатиты
|23;Мурманск
|21900;Универсальное
|21901;Прочее
|24;Великий Новгород
|21902;Универсальное
|21903;Прочее
|25;Псков
|10928;Великие Луки
|21904;Универсальное
|21905;Прочее
|18;Петрозаводск
|21906;Универсальное
|21907;Прочее
|10937;Сортавала
|19;Сыктывкар
|10945;Ухта
|21908;Универсальное
|21909;Прочее
|4;Белгород
|10649;Старый Оскол
|21910;Универсальное
|21911;Прочее
|191;Брянск
|21912;Универсальное
|21913;Прочее
|192;Владимир
|10656;Александров
|10661;Гусь-Хрустальный
|10668;Муром
|21914;Универсальное
|21915;Прочее
|10664;Ковров
|10671;Суздаль
|193;Воронеж
|21916;Универсальное
|21917;Прочее
|5;Иваново
|21918;Универсальное
|21919;Прочее
|6;Калуга
|967;Обнинск
|21920;Универсальное
|21921;Прочее
|7;Кострома
|21922;Универсальное
|21923;Прочее
|8;Курск
|21924;Универсальное
|21925;Прочее
|9;Липецк
|21926;Универсальное
|21927;Прочее
|10;Орел
|21928;Универсальное
|21929;Прочее
|11;Рязань
|21930;Универсальное
|21931;Прочее
|12;Смоленск
|21932;Универсальное
|21933;Прочее
|13;Тамбов
|21934;Универсальное
|21935;Прочее
|14;Тверь
|21936;Универсальное
|21937;Прочее
|10820;Ржев
|15;Тула
|21938;Универсальное
|21939;Прочее
|10830;Новомосковск
|16;Ярославль
|10839;Рыбинск
|10837;Переславль
|21940;Универсальное
|21941;Прочее
|10838;Ростов
|10840;Углич
|95;Канада
|84;США
|20271;Мексика
|21942;Универсальное
|21943;Прочее
|93;Аргентина
|94;Бразилия
|669;Прочее
|670;Универсальное
|68;Чита
|21818;Универсальное
|21819;Прочее
|157;Минск
|26034;Жодино
|101852;Универсальное
|101853;Прочее
|155;Гомель
|101854;Универсальное
|101855;Прочее
|154;Витебск
|101856;Универсальное
|101857;Прочее
|153;Брест
|101858;Универсальное
|101859;Прочее
|10274;Гродно
|101860;Универсальное
|101861;Прочее
|158;Могилев
|101862;Универсальное
|101863;Прочее
|162;Алматы
|10303;Талдыкорган
|102499;Прочее
|102513;Универсальное
|164;Караганда
|102500;Прочее
|102514;Универсальное
|163;Астана
|20809;Кокшетау
|102501;Прочее
|102515;Универсальное
|165;Семей
|10306;Усть-Каменогорск
|102502;Прочее
|102516;Универсальное
|190;Павлодар
|102503;Прочее
|102517;Универсальное
|102504;Прочее
|102518;Универсальное
|102505;Прочее
|102519;Универсальное
|102506;Прочее
|102520;Универсальное
|221;Чимкент
|102507;Прочее
|102521;Универсальное
|20273;Актобе
|102508;Прочее
|102522;Универсальное
|102509;Прочее
|102523;Универсальное
|102510;Прочее
|102524;Универсальное
|102511;Прочее
|102525;Универсальное
|102512;Прочее
|102526;Универсальное
|143;Киев
|10369;Белая Церковь
|101864;Прочее
|101865;Универсальное
|21609;Кременчуг
|964;Полтава
|102450;Прочее
|102475;Универсальное
|10363;Черкассы
|102451;Прочее
|102476;Универсальное
|963;Винница
|102452;Прочее
|102477;Универсальное
|20221;Кировоград
|102453;Прочее
|102478;Универсальное
|10343;Житомир
|102454;Прочее
|102479;Универсальное
|147;Харьков
|102455;Прочее
|102480;Универсальное
|142;Донецк
|20554;Краматорск
|10366;Мариуполь
|24876;Макеевка
|102456;Прочее
|102481;Универсальное
|141;Днепропетровск
|10347;Кривой Рог
|102457;Прочее
|102482;Универсальное
|222;Луганск
|102458;Прочее
|102483;Универсальное
|960;Запорожье
|10367;Мелитополь
|102459;Прочее
|102484;Универсальное
|145;Одесса
|102460;Прочее
|102485;Универсальное
|148;Николаев
|102461;Прочее
|102486;Универсальное
|962;Херсон
|102462;Прочее
|102487;Универсальное
|144;Львов
|102464;Прочее
|102489;Универсальное
|961;Хмельницкий
|102465;Прочее
|102490;Универсальное
|10357;Тернополь
|102466;Прочее
|102491;Универсальное
|10355;Ровно
|102467;Прочее
|102492;Универсальное
|10365;Черновцы
|102468;Прочее
|102493;Универсальное
|20222;Луцк
|102469;Прочее
|102494;Универсальное
|10358;Ужгород
|102470;Прочее
|102495;Универсальное
|10345;Ивано-Франковск
|102471;Прочее
|102496;Универсальное
|965;Сумы
|102472;Прочее
|102497;Универсальное
|966;Чернигов
|102473;Прочее
|102498;Универсальное
|11010;Республика Дагестан
|11012;Республика Ингушетия
|11013;Республика Кабардино-Балкария
|11021;Республика Северная Осетия-Алания
|11069;Ставропольский край
|11020;Карачаево-Черкесская Республика
|11024;Чеченская Республика
|102446;Универсальное
|102445;Другие города региона
|977;Крым
HTML;

$datting_groups = <<<HTML
moya-anketa|||Моя анкета|
interesy|||Интересы|
ozhidaniya-ot-partnera|||Ожидания от партнера|
HTML;

$datting_meetings_cat = <<<HTML
Сходить в кино;В кафе / ресторан;Выпить;Покататься по городу;Погулять;Пойти на свидание;На велосипеды / ролики;Заняться спортом;Посетить мероприятие;Отдохнуть на природе;Другой вариант;Я согласен с правилами размещения встреч
HTML;

$datting_pages = <<<HTML
profile_avtoportret|profile_avtoportret||Автопортрет|
profile_anketa|profile_anketa||Общее|
profile_photos|profile_photos||Фото|
profile_awards|profile_awards||Подарки|
profile_blogs|profile_blogs||Дневники|
profile_meetings|profile_meetings||Встречи|
profile_friends|profile_friends||Друзья|
HTML;

$datting_profile = <<<HTML
0|celi_znakomstva|Мои цели знакомства|Дружба и общение;Переписка;Общение по интересам;Любовь, отношения;Создание семьи;Секс;Обучение;Интим за деньги|moya-anketa|checkbox
1|moe-semeynoe-polozhenie|Мое семейное положение|Состою в браке;Состою в браке, но живем отдельно;Состою в браке для вида;Не состою в браке;Нет ответа|moya-anketa|checkbox
2|moe-otnoshenie-k-materialnoy-podderzhke|Мое отношение к материальной поддержке|Ищу спонсора;Готов быть спонсором;Не готов быть спонсором и в спонсоре не нуждаюсь|moya-anketa|checkbox
3|moe-materialnoe-polozhenie|Мое материальное положение|Непостоянный доход;Постоянный небольшой доход;Стабильный средний доход;Прилично зарабатываю|moya-anketa|checkbox
4|est-li-u-menya-deti|Есть ли у меня дети|Да есть, живем вместе;Да есть, живем отдельно;Нет, но хотелось бы;Нет и пока не планирую|moya-anketa|checkbox
5|moe-obrazovanie|Мое образование|Среднее;Высшее неоконченное;Высшее;Ученая степень|moya-anketa|checkbox
6|kvartirnyy-vopros|Квартирный вопрос|Живу с родственниками;Снимаю квартиру;Собственное жилье|moya-anketa|checkbox
7|moe-teloslozhenie|Мое телосложение|Худощавое;Обычное;Спортивное;Мускулистое;Плотное;Полное;Нет ответа|moya-anketa|checkbox
8|moy-cvet-volos|Мой цвет волос|Светлые;Темные;Рыжие;Мелированные;Яркие;Седые;Бритые наголо|moya-anketa|checkbox
9|moy-rezhim-dnya|Мой режим дня|Я «Жаворонок»;Я «Сова»|moya-anketa|checkbox
10|moya-professiya|Моя профессия||moya-anketa|input
11|moya-gotovnost-k-treningam-na-proekte|Моя готовность к тренингам на проекте|Проходил тренинги;Прохожу сейчас;Пока не проходил;Не проходил и не собираюсь;Проходил тренинги в других местах|moya-anketa|checkbox
12|ya-gotov-okazat-pomosch-v-obuchenii|Я готов оказать помощь в обучении|Готов помогать;Посмотрим по ситуации;Не готов быть «подопытным»|moya-anketa|checkbox
13|moy-rost|Мой Рост||moya-anketa|input
14|moy-ves|Мой Вес||moya-anketa|input
15|svobodniyden|Что буду делать в свободный день|Пойду гулять;Буду читать дома;Побуду в одиночестве;Приглашу гостей;Поеду на природу;Пойду в кино;Пойду в театр;Пойду в музей;Пойду в ресторан;Пойду в ночной клуб;Займусь спортом;Поиграю на компьютере;Посижу в интернете|interesy|checkbox
16|zansportom|Занятия спортом|Бег;Прогулки;Фитнес;Плавание;Велосипед;Скейтборд;Ролики;Лыжи, сноуборд;Подводное плавание;Серфинг;Восточные единоборства;Медитация, йога|interesy|checkbox
17|intez|Ваши интересы||interesy|input
18|kurenie|Отношение к курению|Не курю вообще;Курю;Редко;Бросаю|interesy|checkbox
19|alkogol|Отношение к алкоголю|Не пью вообще;Пью в компаниях изредка;Люблю выпить|interesy|checkbox
20|narkotik|Отношение к наркотикам|Никогда не принимал;Категорически не приемлю;Покуриваю «травку»;Принимаю легкие;Принимаю тяжелые;Бросаю;Выздоравливаю по NA;Бросил|interesy|checkbox
21|vozbuzdaet|Меня возбуждает|Нижнее белье;Запахи;Темный цвет кожи;Татуировки или пирсинг;Джинсы;Униформа;Одежда;Чулки;Обувь;Кожа;Резина, латекс;Металл;Волосатость;Переодевание в женскую|interesy|checkbox
22|razmergrudi|Размер груди||interesy|input
23|orientacia|Ориентация|Гетеро;Би;|interesy|checkbox
24|ishu|Познакомлюсь с|Парнем;Девушкой;Парой М+Ж;Парой М+М;Парой Ж+Ж|ozhidaniya-ot-partnera|checkbox|Внимание! Если Вы не выберете один из параметров, то вашу анкету никто не сможет найти в поиске.
25|vozrast_ot|Возраст от||ozhidaniya-ot-partnera|input
26|vozrast_do|Возраст до||ozhidaniya-ot-partnera|input
27|ti_celi_znakomstva1|Цели знакомства|Дружба и общение;Переписка;Общение по интересам;Любовь, отношения;Создание семьи;Секс;Обучение;Интим за деньги|ozhidaniya-ot-partnera|checkbox
28|ti_brak|Семейное положение|Состою в браке;Состою в браке, но живем отдельно;Состою в браке для вида;Не состою в браке;Нет ответа|ozhidaniya-ot-partnera|checkbox
29|ti_deti|Дети|Да есть, живем вместе;Да есть, живем отдельно;Нет, но хотелось бы;Нет и пока не планирую|ozhidaniya-ot-partnera|checkbox
30|ti_ozhidaniya|Другие ожидания от партнера||ozhidaniya-ot-partnera|input
31|ti_sponsor|Предполагаю, что Ваше отношение к спонсорств|Ищу спонсора;Готов быть спонсором;Не готов быть спонсором и в спонсоре не нуждаюсь|ozhidaniya-ot-partnera|checkbox
32|ti_telo|Мне бы хотелось, чтобы В вашей анкете было указано телосложение|Худощавое;Обычное;Спортивное;Мускулистое;Плотное;Полное;Нет ответа|ozhidaniya-ot-partnera|checkbox
33|ti_training|Предпочту, чтобы Вы|Проходил тренинги;Прохожу сейчас;Пока не проходил;Не проходил и не собираюсь;Проходил тренинги в других местах|ozhidaniya-ot-partnera|checkbox
34|ti_pomosh|Надеюсь, Вы готовы помогать мне в обучении следующим образом|Готов помогать;Посмотрим по ситуации;Не готов быть «подопытным»|ozhidaniya-ot-partnera|checkbox
35|ti_svobodnoevrema|Буду рад, если Вы свободное время проведете|Пойду гулять;Буду читать дома;Побуду в одиночестве;Приглашу гостей;Поеду на природу;Пойду в кино;Пойду в театр;Пойду в музей;Пойду в ресторан;Пойду в ночной клуб;Займусь спортом;Поиграю на компьютере;Посижу в интернете|ozhidaniya-ot-partnera|checkbox
36|simvcen|Первая ведущая симводическая ценность|Доброта;Воля;Ответственность;Истина;Творчество;Игра|testcennost|checkbox
37|ssimvcen|Вторая ведущая симводическая ценность|Доброта;Воля;Ответственность;Истина;Творчество;Игра|testcennost|checkbox
HTML;

$edit_banki = <<<HTML
summa|Какую сумму хотите взять?||text|0|0|creditcard
summa|Какую сумму хотите взять?||text|0|0|creditipoteka
summa|Какую сумму хотите взять?||text|0|0|creditpotrebit
summa|Какую сумму хотите взять?||text|0|0|creditauto
valuta|Валюта|RUB;USD;EUR|select|0|0|creditcard
doxod|Как Вы можете подтвердить доход?|Официально НДФЛ-2;По справке банка;Никак|select|0|0|creditcard
info_celi|Информация о задачах и целях кредита||textarea|0|0|creditcard
valuta|Валюта|RUB;USD;EUR|select|0|0|creditipoteka
doxod|Как Вы можете подтвердить доход?|Официально НДФЛ-2;По справке банка;Никак|select|0|0|creditipoteka
info_celi|Информация о задачах и целях кредита||textarea|0|0|creditipoteka
valuta|Валюта|RUB;USD;EUR|select|0|0|creditpotrebit
doxod|Как Вы можете подтвердить доход?|Официально НДФЛ-2;По справке банка;Никак|select|0|0|creditpotrebit
info_celi|Информация о задачах и целях кредита||textarea|0|0|creditpotrebit
valuta|Валюта|RUB;USD;EUR|select|0|0|creditauto
doxod|Как Вы можете подтвердить доход?|Официально НДФЛ-2;По справке банка;Никак|select|0|0|creditauto
info_celi|Информация о задачах и целях кредита||textarea|0|0|creditauto
fio|ФИО||text|0|name|creditcard
pass_seria|Паспорт серия||text|0|name|creditcard
pass_nomer|Паспорт номер||text|0|name|creditcard
pass_vidan|Паспорт выдан||text|0|name|creditcard
pass_data|Дата выдачи паспорта||text|0|name|creditcard
telefon|Телефон||text|0|name|creditcard
email|Email||text|0|name|creditcard
skolko_let|Сколько вам лет?||text|0|name|creditcard
sem_pol|Семейное положение|холост/не замужем;женат/замужем;вдовец/вдова;разведен/разведена|select|0|name|creditcard
col_det|Количество несовершеннолетних детей*|нет;один;два;три;более трех|select|0|name|creditcard
srokraboti|Сколько Вы работаете на последнем месте?*|до 3 месяцев;до 6 месяцев; до 2 лет;более 2 лет|select|0|name|creditcard
stashrab|Ваш общий трудовой стаж?*|до 2 лет;более 2 лет|select|0|name|creditcard
dd|Ваш среднемесячный доход, руб.*||text|0|name|creditcard
rasx|Обязательные ежемесячные расходы, руб*||text|0|name|creditcard
kredsum|Сумма ежемесячных платежей по другим кредитам, руб||text|0|name|creditcard
propiska|Где Вы прописаны?|Екатеринбург;В пределах 100 км от города;Свердловская область;Россия;зарубежье|select|0|name|creditcard
fio|ФИО||text|0|name|creditipoteka
pass_seria|Паспорт серия||text|0|name|creditipoteka
pass_nomer|Паспорт номер||text|0|name|creditipoteka
pass_vidan|Паспорт выдан||text|0|name|creditipoteka
pass_data|Дата выдачи паспорта||text|0|name|creditipoteka
telefon|Телефон||text|0|name|creditipoteka
email|Email||text|0|name|creditipoteka
skolko_let|Сколько вам лет?||text|0|name|creditipoteka
sem_pol|Семейное положение|холост/не замужем;женат/замужем;вдовец/вдова;разведен/разведена|select|0|name|creditipoteka
col_det|Количество несовершеннолетних детей*|нет;один;два;три;более трех|select|0|name|creditipoteka
srokraboti|Сколько Вы работаете на последнем месте?*|до 3 месяцев;до 6 месяцев; до 2 лет;более 2 лет|select|0|name|creditipoteka
stashrab|Ваш общий трудовой стаж?*|до 2 лет;более 2 лет|select|0|name|creditipoteka
dd|Ваш среднемесячный доход, руб.*||text|0|name|creditipoteka
rasx|Обязательные ежемесячные расходы, руб*||text|0|name|creditipoteka
kredsum|Сумма ежемесячных платежей по другим кредитам, руб||text|0|name|creditipoteka
propiska|Где Вы прописаны?|Екатеринбург;В пределах 100 км от города;Свердловская область;Россия;зарубежье|select|0|name|creditipoteka
fio|ФИО||text|0|name|creditpotrebit
pass_seria|Паспорт серия||text|0|name|creditpotrebit
pass_nomer|Паспорт номер||text|0|name|creditpotrebit
pass_vidan|Паспорт выдан||text|0|name|creditpotrebit
pass_data|Дата выдачи паспорта||text|0|name|creditpotrebit
telefon|Телефон||text|0|name|creditpotrebit
email|Email||text|0|name|creditpotrebit
skolko_let|Сколько вам лет?||text|0|name|creditpotrebit
sem_pol|Семейное положение|холост/не замужем;женат/замужем;вдовец/вдова;разведен/разведена|select|0|name|creditpotrebit
col_det|Количество несовершеннолетних детей*|нет;один;два;три;более трех|select|0|name|creditpotrebit
srokraboti|Сколько Вы работаете на последнем месте?*|до 3 месяцев;до 6 месяцев; до 2 лет;более 2 лет|select|0|name|creditpotrebit
stashrab|Ваш общий трудовой стаж?*|до 2 лет;более 2 лет|select|0|name|creditpotrebit
dd|Ваш среднемесячный доход, руб.*||text|0|name|creditpotrebit
rasx|Обязательные ежемесячные расходы, руб*||text|0|name|creditpotrebit
kredsum|Сумма ежемесячных платежей по другим кредитам, руб||text|0|name|creditpotrebit
propiska|Где Вы прописаны?|Екатеринбург;В пределах 100 км от города;Свердловская область;Россия;зарубежье|select|0|name|creditpotrebit
fio|ФИО||text|0|name|creditauto
pass_seria|Паспорт серия||text|0|name|creditauto
pass_nomer|Паспорт номер||text|0|name|creditauto
pass_vidan|Паспорт выдан||text|0|name|creditauto
pass_data|Дата выдачи паспорта||text|0|name|creditauto
telefon|Телефон||text|0|name|creditauto
email|Email||text|0|name|creditauto
skolko_let|Сколько вам лет?||text|0|name|creditauto
sem_pol|Семейное положение|холост/не замужем;женат/замужем;вдовец/вдова;разведен/разведена|select|0|name|creditauto
col_det|Количество несовершеннолетних детей*|нет;один;два;три;более трех|select|0|name|creditauto
srokraboti|Сколько Вы работаете на последнем месте?*|до 3 месяцев;до 6 месяцев; до 2 лет;более 2 лет|select|0|name|creditauto
stashrab|Ваш общий трудовой стаж?*|до 2 лет;более 2 лет|select|0|name|creditauto
dd|Ваш среднемесячный доход, руб.*||text|0|name|creditauto
rasx|Обязательные ежемесячные расходы, руб*||text|0|name|creditauto
kredsum|Сумма ежемесячных платежей по другим кредитам, руб||text|0|name|creditauto
propiska|Где Вы прописаны?|Екатеринбург;В пределах 100 км от города;Свердловская область;Россия;зарубежье|select|0|name|creditauto
srok_kred|На какой срок?*|1-5 лет;5-10 лет;10-20 лет;20-30 лет;|select|0|0|creditipoteka
srok_kred|На какой срок?*|3-6 месяцев;6-12 месяцев;1-2 года;2-5 лет;|select|0|0|creditauto
srok_kred|На какой срок?*|3-6 месяцев;6-12 месяцев;1-2 года;2-5 лет;|select|0|0|creditpotrebit
obespech|Как Вы можете обеспечить кредит?*|Залог;Поручитель;Никак не готов|select|0|0|creditipoteka
obespech|Как Вы можете обеспечить кредит?*|Залог;Поручитель;Никак не готов|select|0|0|creditauto
obespech|Как Вы можете обеспечить кредит?*|Залог;Поручитель;Никак не готов|select|0|0|creditpotrebit
trebovaniya|Ваши требования к кредиту|Возможность досрочного погашения;Отсутствие ежемесячных комиссий|select|0|0|creditipoteka
trebovaniya|Ваши требования к кредиту|Возможность досрочного погашения;Отсутствие ежемесячных комиссий|select|0|0|creditauto
trebovaniya|Ваши требования к кредиту|Возможность досрочного погашения;Отсутствие ежемесячных комиссий|select|0|0|creditpotrebit
HTML;

$edit_event = <<<HTML
birthdate|Места|00:00;00:05;00:10;00:15;14:50;15:35;16:35;17:15;18:00;19:00;19:40;20:25;21:25;22:05;22:50|dbbirthdate|0||kino
zhanr|Жанр||text|0|0|kino
rezh|Режиссер||text|0|0|kino
vrolax|В ролях||text|0|0|kino
zhan|Жанр||text|0|0|theatre
zhan_c|Жанр||text|0|0|clubs
HTML;

$edit_obj = <<<HTML
t14|Тип объявления|Продам;Куплю;Обменяю|select|1|0|auto
t2|Тип объявления|Продам;Куплю;Сдам;Сниму|select|1|0|nedv
formoplati|Форма оплаты|Любая;Оклад;Оклад+%;%;Подряд;Почасовая;Сдельная;Другая|select|0|0|vacations
tiprab|Тип работы|Любая;Постоянная;По совместительству;Временная|select|1|0|vacations
graphrab|График работы|Любой;Полный рабочий день;Не полный рабочий день;Свободный;Вахтовый|select|1|0|vacations
usl|Условия||textarea|1|0|vacations
treb|Требования||textarea|0|0|vacations
obaz|Обязанности||textarea|1|0|vacations
aboutcomp|О компании||textarea|1|0|vacations
obrazie|Образование|Высшее;Неоконченное высшее;Среднее;Неоконченное среднее;Среднее специальное;Другое|select|1|0|vacations
stag|Стаж от (лет)||text|1|0|vacations
znanyaz|Знание языков||textarea|0|0|vacations
znankomp|Знание компьютера||textarea|1|0|vacations
bizob|Бизнес-образование||textarea|1|0|vacations
pol|Пол|Мужской;Женский;Любой|select|1|0|vacations
uczav|Учебное заведение||text|1|0|rezume
stah|Стаж от (лет)||text|1|0|rezume
tiprazb|Тип работы|Любая;Постоянная;По совместительству;Временная|select|1|0|rezume
predrab|Места предыдущей работы||textarea|1|0|rezume
graphrzab|График работы|Любой;Полный рабочий день;Не полный рабочий день;Свободный;Вахтовый|select|1|0|rezume
obrazie|Образование|Высшее;Неоконченное высшее;Среднее;Неоконченное среднее;Среднее специальное;Другое|select|1|0|rezume
znaniyaz|Знание языков||textarea|1|0|rezume
znankompi|Знание компьютера||textarea|1|0|rezume
biziob|Бизнес-образование||textarea|1|0|rezume
dopsved|Дополнительные сведения||textarea|1|0|rezume
vazhnost|Важность|Нет;Срочно;Не очен срочно;Сейчас работаю, но интересный вариант готов рассмотреть|select|1|0|rezume
poil|Пол|Мужской;Женский|select|1|0|rezume
vozrast|Возраст||text|1|0|rezume
t12|Коробка передач|механическая;автомат;вариатор;типтроник;роботизированная|select|1|0|auto
t11|Тип двигателя|бензин инжектор;бензин карбюратор;бензин ротор;бензин турбонаддув;бензин компрессор;дизель;дизель турбонаддув;гибридный|select|1|0|auto
t9|Состояние|отличное;хорошее;битое;среднее|select|1|0|auto
t15|Привод|передний;полный;задний|select|1|0|auto
t4|Год||text|1|0|auto
t5|Пробег (км)||text|1|0|auto
t6|Цвет||text|1|0|auto
t7|Объем двигателя (см3)||text|1|0|auto
t8|Мощность (л.с)||text|1|0|auto
t10|Кузов|седан;хэтчбек;универсал;внедорожник;купе;минивен;микроавтобус;пикап;кабриолет|select|1|0|auto
t13|Руль|левый;правый|select|1|0|auto
t11|Количество комнат|1;2;3;4;5;6|select|1|0|nedv
t10|Жилая площадь|0.0|text|1|0|nedv
full_area|Общая площадь||text|1|0|nedv
t1|Этаж||text|1|0|nedv
t12|Всего этажей||text|1|0|nedv
t13|Номер дома||text|0|0|nedv
t5|Улица||text|0|0|nedv
t11|Материал|блоки;кирпич;брус;бревно|select|1|0|zagor
full_area|Площадь дома (м.кв)|0.0|text|1|0|zagor
t10|Площадь участка (сот)||text|1|0|zagor
t1|Этаж||text|1|0|zagor
t12|Кол-во этажей||text|1|0|zagor
t5|Населенный пункт||text|1|0|zagor
t13|Расстояние от населенного пункта (км)||text|1|0|zagor
t11|Расположение|В бизнес-центре;В доме, здании;В торговом комплексе;На промышленной территории;Отдельное здание|select|1|0|comm
full_area|Площадь (м.кв)|0.0|text|1|0|comm
t9|Отдельный вход|Да, с улицы;Да, со двора;Нет|select|1|0|comm
t1|Этаж||text|1|0|comm
t5|Улица||text|0|0|comm
t13|Номер дома||text|1|0|comm
klovokomn|Количество этажей||text|1|0|objectnedv
materioal|Материал|газозолоблоки;железобетон;блоки;кирпич;брус;бревно|select|1|0|objectnedv
sroksdac|Срок сдачи||text|1|0|objectnedv
t11|Количество комнат|1;2;3;4;5;6|select|1|0|predlnovo
t1|Этаж||text|1|0|predlnovo
t12|Кол-во этажей||text|1|0|predlnovo
t10|Жилая площадь|0.0|text|1|0|predlnovo
full_area|Общая площадь||text|1|0|predlnovo
t2|Санузлы||text|1|0|predlnovo
t3|Балконы||text|1|0|predlnovo
t10|Жилая площадь|0.0|text|1|0|predlkot
full_area|Общая площадь||text|1|0|predlkot
t2|Этажность||text|1|0|predlkot
t3|Участок||text|1|0|predlkot
t10|Площадь участка (сот)||text|1|0|zemuch
t13|Расстояние от населенного пункта (км)||text|1|0|zemuch
t5|Населенный пункт||text|1|0|zemuch
kratkopis|Краткое описание*||textarea|0|0|tenders
srconec|Срок окончания приема заявок (в формате дд.мм.гггг)*||text|0|0|tenders
sotr|Предусмотрено продолжительное сотрудничество|Да;Нет|select|0|0|tenders
uczav|Учебное заведение||text|1|0|beauraut
stah|Стаж от (лет)||text|1|0|beauraut
tiprazb|Тип работы|Любая;Постоянная;По совместительству;Временная|select|1|0|beauraut
predrab|Места предыдущей работы||textarea|1|0|beauraut
graphrzab|График работы|Любой;Полный рабочий день;Не полный рабочий день;Свободный;Вахтовый|select|1|0|beauraut
obrazie|Образование|Высшее;Неоконченное высшее;Среднее;Неоконченное среднее;Среднее специальное;Другое|select|1|0|beauraut
znaniyaz|Знание языков||textarea|1|0|beauraut
znankompi|Знание компьютера||textarea|1|0|beauraut
biziob|Бизнес-образование||textarea|1|0|beauraut
dopsved|Дополнительные сведения||textarea|1|0|beauraut
vazhnost|Важность|Нет;Срочно;Не очень срочно;Сейчас работаю, но интересный вариант готов рассмотреть|select|1|0|beauraut
poil|Пол|Мужской;Женский|select|1|0|beauraut
vozrast|Возраст||text|1|0|beauraut
HTML;

$edit_profile = <<<HTML
fullname|Фамилия Имя Отчество||text|1|1|basic|1|0
sex|Пол|Мужской;Женский|select|1|0|basic|0|1
datting|Участовать в поиске|Да;Нет|select|1|1|basic|1|0
polsex|Семейное положение|Женат;Замужем;Не женат;Не замужем;Есть подруга;Есть друг;В активном поиске;Помолвлен;Помолвлена;Все сложно|select|1|0|basic|0|1
vzgladi|Политические взгляды|Монархические;Индифферентные;Коммунистические;Умеренные;Либеральные|select|1|0|basic
city|Родной город||dbcity|1|0|basic|1|0
mob_phone|Мобильный телефон||text|1|0|contakti|1|0
dom_phone|Домашний телефон||text|1|0|contakti
icq|ICQ||text|1|0|contakti
birthdate|Дата рождения||dbbirthdate|1|0|basic|0|1
webs|Личный сайт||text|1|0|contakti|0|1
email|Контактный Email||text|1|0|contakti|1|0
info|О себе||textarea|1|0|lichn
deyatelnost|Деятельность||dbconnect|1|0|lichn
interests|Интересы||dbconnect|1|0|lichn
style|Любимый музыкальный стиль||text|1|0|lichn
ishu|Профессия||dbconnect|1|0|basic|0|1
HTML;

$raspisanie = <<<HTML
tiraspol|35|0|text|0|0|basic
ribnitsa|2|0|text|0|0|basic
dubosari|39|0|text|0|0|basic
yekaterinburg|54|1|text|0|0|basic
|213|1|text|0|0|basic
HTML;

$user_edit_pages = <<<HTML
basic|basic||Основное|
lichn|lichn||Личное|
contakti|contakti||Контакты|
photo|photo||Фото|
HTML;

$xfirm = <<<HTML
coocie|Кухня|1153|select|1|1|Корейская__NEWL__Японская__NEWL__Американская
vmestimost|Вместимость|1153|text|1|1|
HTML;

$xprofile = <<<HTML
t2|Ваше образование|0|text|1|0
t3|Счастье - это...|0|text|1|0
t4|Самое поразительное открытие в Вашей жизни|0|text|1|0
t6|Что для вас значит романтика и важна ли она|0|text|1|0
t7|Какие качества Вы цените в людях|0|text|1|0
t8|Что Вы могли бы простить, а что нет|0|text|1|0
t9|Есть ли у Вас любимые литературные/кино герои|0|text|1|0
t10|Есть ли Вам, чем гордиться в жизни|0|text|1|0
t11|Какую цель Вы ставите сейчас перед собой|0|text|1|0
t12|Чем бы Вы хотели заниматься|0|text|1|0
t13|Где Вы мечтаете жить|0|text|1|0
t14|Ваше любимое место в родном городе|0|text|1|0
t15|Есть ли у вас домашние животные|0|text|1|0
t16|Какие города/страны Вам полюбились|0|text|1|0
t17|Что для Вас одиночество|0|text|1|0
t18|Хотите ли вы иметь детей?|0|text|1|0
t19|Ваш любимый фильм|0|text|1|0
t20|Ваше любимое занятие|0|text|1|0
t21|Что Вам не нравится в людях|0|text|1|0
t22|Ваш главный недостаток|0|text|1|0
HTML;

$xprofile = <<<HTML
t2|Ваше образование|0|text|1|0
t3|Счастье - это...|0|text|1|0
t4|Самое поразительное открытие в Вашей жизни|0|text|1|0
t6|Что для вас значит романтика и важна ли она|0|text|1|0
t7|Какие качества Вы цените в людях|0|text|1|0
t8|Что Вы могли бы простить, а что нет|0|text|1|0
t9|Есть ли у Вас любимые литературные/кино герои|0|text|1|0
t10|Есть ли Вам, чем гордиться в жизни|0|text|1|0
t11|Какую цель Вы ставите сейчас перед собой|0|text|1|0
t12|Чем бы Вы хотели заниматься|0|text|1|0
t13|Где Вы мечтаете жить|0|text|1|0
t14|Ваше любимое место в родном городе|0|text|1|0
t15|Есть ли у вас домашние животные|0|text|1|0
t16|Какие города/страны Вам полюбились|0|text|1|0
t17|Что для Вас одиночество|0|text|1|0
t18|Хотите ли вы иметь детей?|0|text|1|0
t19|Ваш любимый фильм|0|text|1|0
t20|Ваше любимое занятие|0|text|1|0
t21|Что Вам не нравится в людях|0|text|1|0
t22|Ваш главный недостаток|0|text|1|0
HTML;

$config_curs = <<<HTML
<?PHP

\$name_city_curs = "ekaterinburg";

?>
HTML;

$importrambler = <<<HTML
<?PHP

\$config = array (
'city' => "",
'rambler_key' => "",
);

?>
HTML;

$importyt = <<<HTML
<?PHP

\$confms = array (
'category' => "",
'region' => "",
'keywords' => "",
'author' => "UCs1yzsO9earP5yOXiMLGclw",
'city' => "",
);

?>
HTML;

$rssfull = <<<HTML
<?php
/*======================================
Configuration RSS grabber's
======================================*/
\$config_rss = array (
  'name' => 'RSS Grabber',
  'version' => '3.6.8',
  'build' => '2701',
  'img_host' => 'serv',
  'water_radikal' => 'yes',
  'post_radikal' => '',
  'url_radikal' => '1',
  'water_ambrybox' => 'no',
  'post_ambrybox' => 'RSS GRABBER',
  'ambrybox' => '1',
  'url_zikuka' => '1',
  'url_10pix' => '1',
  'immage' => '1',
  'imageshack' => '1',
  'tinypic' => '1',
  'url_epikz' => '1',
  'allow-water' => 'yes',
  'x' => 'right',
  'y' => 'bottom',
  'margin' => '7',
  'dop-watermark' => 'yes',
  'watermark_image_light' => '/templates/{$config[skin]}/dleimages/watermark_light.png',
  'watermark_image_dark' => '/templates/{$config[skin]}/dleimages/watermark_dark.png',
  'image_align' => '1',
  'image_align_full' => '1',
  'create_images' => '3',
  'maxWidth' => '',
  'upload_t_size' => '0',
  'http_url' => '',
  'DOCUMENT_ROOT' => '',
  'cat' => 'yes',
  'rewrite-news' => 'no',
  'allow-mod' => 'no',
  'allow-main' => 'yes',
  'allow-comm' => 'no',
  'allow-rate' => 'no',
  'rate_start' => '',
  'rate_finish' => '',
  'allow-auto' => 'yes',
  'clear-short' => 'no',
  'short-images' => 'no',
  'short-full' => 'no',
  'null' => 'no',
  'hide' => 'no',
  'leech' => 'no',
  'date' => '0',
  'interval_start' => '10',
  'interval_finish' => '40',
  'show_autor' => 'yes',
  'show_date' => 'yes',
  'show_tegs' => 'yes',
  'show_code' => 'yes',
  'show_down' => 'yes',
  'show_f' => 'yes',
  'show_symbol' => 'yes',
  'show_url' => 'yes',
  'show_date_expires' => 'yes',
  'show_show_metatitle' => 'yes',
  'show_metadescr' => 'yes',
  'show_keywords' => 'yes',
  'news_kol' => '10',
  'news_limit' => '2',
  'allow_post' => 'yes',
  'ping_lognum' => '15',
  'sitemap' => 'yes',
  'sinonim' => 'yes',
  'page_sinonims' => '10',
  'proxy' => '',
  'proxy_file' => 'no',
  'get_proxy' => 'no',
  'reg_group' => '1',
  'code_bb' => '',
  'sin_dop' => '',
);
?>
HTML;

$firm_tarifs = <<<HTML
name|Доступные сервисы|
edit_about|Возможность редактирования своих данных|
edit_maps|Размещение на карте города|
edit_skidnews|Размещение акций и новостей вашей компании|
col_rubrik|Количество рубрик размещения в справочнике|
edit_photo|Размещение фотографий (магазина, продукции)|
edit_vak|Размещение объявлений и вакансий|
col_tov|Размещение товаров|
edit_price|Размещение прайс-листов, сертификатов|
edit_prior|Приоритетное расположение в справочнике|
edit_www|Уникальный адрес в интернете|
edit_banner|Баннер в рубрике на первый месяц размещения|
edit_bronir|Брендирование страницы предприятия|
price|Стоимость пакета на год|
HTML;

$sms_pages = <<<HTML
sms_anketa|sms_anketa||Выделить анкету|
sms_datting_poisk|sms_datting_poisk||Поднять анкету|
sms_livestatus|sms_livestatus||Live статус|
sms_hochuobsh|sms_hochuobsh||Стать лидером|
addpodarok|addpodarok||Отправить подарок|
sms_buyobj|sms_buyobj/3/||Выделять объявления|
sms_delfoto|sms_delfoto||Удалять свои фотографии у пользователей|
my_orders|my_orders||Выставленные счета|
HTML;

$block_banners_config = <<<HTML
<?php
\$config['advert_zaglushka'] = '<div style="background-color:#fff;border:1px solid #9e9e9e;text-align:center;width:100%;height:100px;vertical-align:middle;text-transform:lowercase;position:relative;"><div style="margin-top: 30px;    text-align: center!important;"><b>Рекламное место</b><br><a href="/advert/">Купить</a></div><div style="position:absolute;width:50px;height:100px;background-color:#cccccc12;right:0px;top:0px;background-image: url(/templates/66-new/img/logo.png);background-repeat: no-repeat;background-position: center;"></div></div>';
\$config['advert_title'] = "Размещение рекламы";
\$config['advert_descrip'] = "Размещение рекламы на портале ";
\$config['advert_ke'] = "Размещение рекламы, реклама на портале, размещение на портале , размещение на портале Самый крупный новостной портал";
\$config['online_pay'] = "1";
\$config['advert_about'] = "Крупный новостной портал появился в июле 2015 года. С тех пор ежемесячно увеличивает аудиторию и влияние на жизнь города .
<p>
Мы предоставляем самые полезные и востребованные информационные разделы: «Новости», «Бизнес», «Работа», «Банки», «Недвижимость» «Доска частных объявлений», «Общение», «Авто», «Погода», «Рестораны», «Афиша», «Фото, Видео», «Поиск лекарств» и многие другие.</p>";
\$config['advert_politics'] = "Наш портал — эффективное средство продвижения своего бизнеса через интернет. Среди наших пользователей обязательно найдётся ваша целевая аудитория
<p>
Мы размещаем только самые эффективные рекламы форматы и всегда готовы рассмотреть варианты нестандартного размещения для крупных заказчиков. В ходе каждой кампании мы ежедневно отслеживаем её эффективность и повышаем качество показов.</p>";
\$config['advert_aferta'] = "<ul>
<li><i class=\"list-marker\"></i>Цены указаны с учетом всех налогов. НДС не предусмотрен.</li>
<li><i class=\"list-marker\"></i>В случае отказа Заказчиком от размещения Материалов:<br>
1. менее чем за 5 (пять) рабочих дней до даты размещения Материалов - взимается неустойка в размере 30% от стоимости размещения.<br>
2. в процессе оказания услуг - взимается неустойка в размере 100% от стоимости неразмещенной рекламы.</li>
<li><i class=\"list-marker\"></i>Срок предоставления баннера - не менее чем за три рабочих дня до установки его в сетку показов.</li><p></p>
<li><i class=\"list-marker\"></i>Мы оставляем за собой право отказа от приема брони без объяснения причин.</li>
</ul>";
\$config['advert_warn'] = "Изменились технические требования к баннерам, добавлен алгоритм установки ссылки для нашего портала.";
\$config['advert_call'] = "<b>Позвоните нам,</b>и мы с удовольствием ответим на все ваши вопросы и предложим решения";
\$config['advert_count'] = "147036";
\$config['advert_pay'] = "<div id=\"systems\">
<div class=\"paysystem\"><a href=\"#\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_cardvmc.gif\" title=\"Visa, Mastercard\" alt=\"\" border=\"0\"></a> <a href=\"http://www.webmoney.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_webmoney.gif\" title=\"WebMoney\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"https://liqpay.com/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_liqpay.gif\" title=\"LiqPay\" alt=\"\" border=\"0\"></a> <a href=\"http://www.w1.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_w1.gif\" title=\"Единый кошелек\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"http://www.privat24.ua/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_privat24.gif\" title=\"Privat24\" alt=\"\" border=\"0\"></a> <a href=\"http://smartpay.com.ua/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_nsmep.gif\" title=\"НСМЕП\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"https://www.moneymail.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_moneymail.gif\" title=\"MoneyMail\" alt=\"\" border=\"0\"></a> <a href=\"https://rbkmoney.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_rbkmoney.gif\" title=\"RBK Money\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"http://www.webcreds.com/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_webcreds.gif\" title=\"WebCreds\" alt=\"\" border=\"0\"></a> <a href=\"http://www.ukash.com/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_ukash.gif\" title=\"Ukash\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"http://www.sbrf.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_sberbankrf.gif\" title=\"Сбербанк РФ\" alt=\"\" border=\"0\"></a> <a href=\"http://www.russianpost.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_ruspost.gif\" title=\"Почта России\" alt=\"\" border=\"0\"></a><br></div>
			</div>";
?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/firm_tarifs.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/firm_tarifs.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $firm_tarifs);
fclose($con_file);
@chmod(ENGINE_DIR."/data/firm_tarifs.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/sms_pages.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/sms_pages.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $sms_pages);
fclose($con_file);
@chmod(ENGINE_DIR."/data/sms_pages.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/citys_curs.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/citys_curs.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $citys_curs);
fclose($con_file);
@chmod(ENGINE_DIR."/data/citys_curs.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/citys_raspisanie.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/citys_raspisanie.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $citys_raspisanie);
fclose($con_file);
@chmod(ENGINE_DIR."/data/citys_raspisanie.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_groups.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/datting_groups.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $datting_groups);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_groups.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_meetings_cat.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/datting_meetings_cat.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $datting_meetings_cat);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_meetings_cat.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_pages.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/datting_pages.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $datting_pages);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_pages.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_profile.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/datting_profile.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $datting_profile);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_profile.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_banki.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/edit_banki.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $edit_banki);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_banki.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_cart.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/edit_cart.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, "");
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_cart.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_event.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/edit_event.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $edit_event);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_event.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_obj.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/edit_obj.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $edit_obj);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_obj.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_profile.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/edit_profile.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $edit_profile);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_profile.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/raspisanie.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/raspisanie.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $raspisanie);
fclose($con_file);
@chmod(ENGINE_DIR."/data/raspisanie.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/user_edit_pages.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/user_edit_pages.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $user_edit_pages);
fclose($con_file);
@chmod(ENGINE_DIR."/data/user_edit_pages.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/xfields.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/xfields.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, "");
fclose($con_file);
@chmod(ENGINE_DIR."/data/xfields.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/xfirm.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/xfirm.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $xfirm);
fclose($con_file);
@chmod(ENGINE_DIR."/data/xfirm.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/xprofile.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/xprofile.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $xprofile);
fclose($con_file);
@chmod(ENGINE_DIR."/data/xprofile.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_curs.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config_curs.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_curs);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_curs.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.rambler.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/import.rambler.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $importrambler);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.rambler.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.yt.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/import.yt.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $importyt);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.yt.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/rss_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/rss_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $rssfull);
fclose($con_file);
@chmod(ENGINE_DIR."/data/rss_config.php", 0666);

//////////////////////////////////////////////////////////

$con_file = fopen(ENGINE_DIR."/data/profile_pages.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/profile_pages.txt</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $profile_pages);
fclose($con_file);
@chmod(ENGINE_DIR."/data/profile_pages.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_weather.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config_weather.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $dbconfig3);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_weather.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/arcade_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/arcade_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $arcade_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/arcade_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/arcconfig.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/arcconfig.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $arcconfig);
fclose($con_file);
@chmod(ENGINE_DIR."/data/arcconfig.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_adv_content_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_adv_content_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_adv_content_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_adv_content_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_allnews_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_allnews_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_allnews_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_allnews_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_advm_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_advm_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_advm_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_advm_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_afisha_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_afisha_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_afisha_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_afisha_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_auth.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_auth.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_auth);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_auth.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_banners_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_banners_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_banners_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_banners_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_blogs_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_blogs_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_blogs_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_blogs_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_bobrazovanie_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_bobrazovanie_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_bobrazovanie_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_bobrazovanie_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_buro_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_buro_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_buro_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_buro_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_dblock_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_dblock_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_dblock_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_dblock_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_doblock_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_doblock_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_doblock_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_doblock_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_eda_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_eda_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_eda_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_eda_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_exclusive_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_exclusive_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_exclusive_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_exclusive_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_galeryusers_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_galeryusers_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_galeryusers_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_galeryusers_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_gpblock_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_gpblock_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_gpblock_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_gpblock_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_inter_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_inter_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_inter_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_inter_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_internet_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_internet_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_internet_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_internet_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_interview_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_interview_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_interview_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_interview_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_lastobj_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_lastobj_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_lastobj_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_lastobj_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_lastuser_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_lastuser_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_lastuser_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_lastuser_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_mesta_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_mesta_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_mesta_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_mesta_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_nedvblock_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_nedvblock_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_nedvblock_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_nedvblock_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_otdix_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_otdix_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_otdix_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_otdix_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_resizef_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_resizef_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_resizef_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_resizef_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_spravka_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_spravka_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_spravka_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_spravka_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_statistics_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_statistics_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_statistics_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_statistics_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_tender_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/block_tender_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $block_tender_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_tender_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.autocat.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.autocat.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_autocat);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.autocat.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.awards.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.awards.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_awards);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.awards.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.hotels.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.hotels.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_hotels);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.hotels.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.mebel.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.mebel.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_mebel);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.mebel.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.mustcomm.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.mustcomm.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_mustcomm);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.mustcomm.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.pharmacy.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.pharmacy.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_pharmacy);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.pharmacy.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.srd.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.srd.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_srd);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.srd.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_music.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config_music.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_music);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_music.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_photo_pay.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config_photo_pay.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_photo_pay);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_photo_pay.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_pkinopoisk.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config_pkinopoisk.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_pkinopoisk);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_pkinopoisk.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_vip.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config_vip.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config_vip);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_vip.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/datting_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $datting_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/files_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/files_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $files_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/files_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/forum_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/forum_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $forum_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/forum_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/fotoalbum.config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/fotoalbum.config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $fotoalbum_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fotoalbum.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/garage_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/garage_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $garage_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/garage_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.auto.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/import.auto.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $import_auto);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.auto.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.kinoafisha.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/import.kinoafisha.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $import_kinoafisha);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.kinoafisha.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.market.nedv.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/import.market.nedv.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $import_market_nedv);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.market.nedv.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.nedv.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/import.nedv.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $import_nedv);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.nedv.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.work.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/import.work.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $import_work);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.work.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/invite.conf.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/invite.conf.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $invite_conf);
fclose($con_file);
@chmod(ENGINE_DIR."/data/invite.conf.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/lclubs_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/lclubs_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $lclubs_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/lclubs_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/market_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/market_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $market_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/market_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/referer.conf.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/referer.conf.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $referer_conf);
fclose($con_file);
@chmod(ENGINE_DIR."/data/referer.conf.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/referer.perf.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/referer.perf.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $referer_perf);
fclose($con_file);
@chmod(ENGINE_DIR."/data/referer.perf.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/tagconfig.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/tagconfig.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $tagconfig);
fclose($con_file);
@chmod(ENGINE_DIR."/data/tagconfig.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/user_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/user_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $user_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/user_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/video_config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/video_config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $video_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/video_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/wap.config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/wap.config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $wap_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/wap.config.php", 0666);

/// от версии 9.0 ///

$market_config = <<<HTML
<?PHP

\$MarketConfig = array (
	"key" => "829e496af0169846e1b3a9466da0351a7ae1f4b3878588291a99c2d12518dfdb0",
	"on" => "yes",
	"field_on" => "on",
	"cache" => "yes",
	"main_title" => "Каталог товаров",
	"cache_views" => "yes",
	"cache_time" => "120",
	"main_page_cats" => "yes",
	"main_page_max_columns" => "0",
	"main_page_max_echo_thread_cats" => "0",
	"main_page_on_last" => "on",
	"main_page_max_last" => "10",
	"view_cat_on_page" => "20",
	"short_echo_category" => "all_cat",
	"view_cat_max_columns" => "0",
	"short_echo_max_strlen" => "260",
	"short_echo_allowhtml" => "no",
	"fastsearch_on" => "on",
	"add_post_moder" => "yes",
	"add_post_end_date" => "0",
	"add_post_no_end_date" => "yes",
	"add_post_max_photo" => "10",
	"add_post_size_photo" => "5400",
	"add_post_thumb_photo" => "205",
	"add_post_photo_type" => "gif,png,jpg,jpeg",
	"add_post_photo_del" => "0",
	"add_post_main_cat" => "no",
	"add_post_admin_email" => "only_moder",
	"add_post_bbcode" => "no",
	"post_groups_add" => "1,4",
	"post_groups_edit" => "1",
	"post_groups_edit_all" => "1",
	"post_groups_no_moder" => "1,2",
	"post_groups_no_del" => "1,2,3,4",
	"post_groups_captcha" => "3",
	"echo_post_views" => "yes",
	"echo_post_vip" => "hand",
	"echo_post_supervip" => "hand",
	"echo_post_color" => "hand",
	"echo_post_color_hex" => "#eeeeee",
	"echo_post_author_email" => "on_create,on_del_pay",
	"com_on" => "yes",
	"com_anonim" => "no",
	"com_navigation_on" => "yes",
	"com_ajax_navigation" => "yes",
	"com_max_on_page" => "20",
	"com_sort" => "asc",
	"com_allocation" => "yes",
	"com_alternation" => "no",
	"com_antispam" => "30",
	"com_del" => "full",
	"com_groups_add" => "1,2,3,4",
	"com_groups_moder" => "1",
	"com_groups_captcha" => "5",
	"fullsearch_on" => "off",
	"region_on" => "off",
	"rss_on" => "no",
	"max_rss" => "150",
	"short_echo_city" => "no",
	"add_post_phone" => "no",
	"add_post_fio" => "no",
	"add_post_email" => "no",
	"add_post_price" => "no",
	"add_post_http" => "no",
	"echo_post_emailform" => "yes",
	"echo_post_friendform" => "no",
	"echo_post_vipprice" => "30",
	"echo_post_supervipprice" => "50",
	"echo_post_colorprice" => "20",
	"echo_post_blocksearch" => "yes",
	"id_version" => "1.1",
	"id_version_beta" => "0",
	"patches" => "",
);

?>
HTML;

$skidki_config = <<<HTML
<?PHP

\$skidkiConfig = array (
	"key" => "829e496af0169846e1b3a9466da0351a7ae1f4b3878588291a99c2d12518dfdb0",
	"on" => "yes",
	"field_on" => "on",
	"cache" => "yes",
	"cache_views" => "yes",
	"cache_time" => "120",
	"main_title" => "Скидки",
	"main_page_cats" => "yes",
	"main_page_max_columns" => "0",
	"main_page_max_echo_thread_cats" => "0",
	"main_page_on_last" => "on",
	"main_page_max_last" => "10",
	"view_cat_on_page" => "20",
	"short_echo_category" => "all_cat",
	"view_cat_max_columns" => "0",
	"short_echo_max_strlen" => "260",
	"short_echo_allowhtml" => "no",
	"fastsearch_on" => "on",
	"add_post_moder" => "yes",
	"add_post_end_date" => "0",
	"add_post_no_end_date" => "yes",
	"add_post_max_photo" => "10",
	"add_post_size_photo" => "5400",
	"add_post_thumb_photo" => "205",
	"add_post_photo_type" => "gif,png,jpg,jpeg",
	"add_post_photo_del" => "0",
	"add_post_main_cat" => "no",
	"add_post_admin_email" => "only_moder",
	"add_post_bbcode" => "no",
	"post_groups_add" => "1,4",
	"post_groups_edit" => "1",
	"post_groups_edit_all" => "1",
	"post_groups_no_moder" => "1,2",
	"post_groups_no_del" => "1,2,3,4",
	"post_groups_captcha" => "3",
	"echo_post_views" => "yes",
	"echo_post_vip" => "hand",
	"echo_post_supervip" => "hand",
	"echo_post_color" => "hand",
	"echo_post_color_hex" => "#eeeeee",
	"echo_post_author_email" => "on_create,on_del_pay",
	"com_on" => "yes",
	"com_anonim" => "no",
	"com_navigation_on" => "yes",
	"com_ajax_navigation" => "yes",
	"com_max_on_page" => "20",
	"com_sort" => "asc",
	"com_allocation" => "yes",
	"com_alternation" => "no",
	"com_antispam" => "30",
	"com_del" => "full",
	"com_groups_add" => "1,2,3,4",
	"com_groups_moder" => "1",
	"com_groups_captcha" => "5",
	"fullsearch_on" => "off",
	"region_on" => "off",
	"rss_on" => "no",
	"max_rss" => "150",
	"short_echo_city" => "no",
	"add_post_phone" => "no",
	"add_post_fio" => "no",
	"add_post_email" => "no",
	"add_post_price" => "no",
	"add_post_http" => "no",
	"echo_post_emailform" => "yes",
	"echo_post_friendform" => "no",
	"echo_post_vipprice" => "30",
	"echo_post_supervipprice" => "50",
	"echo_post_colorprice" => "20",
	"echo_post_blocksearch" => "yes",
	"id_version" => "1.1",
	"id_version_beta" => "0",
	"patches" => "",
);

?>
HTML;

$pharmacy_config = <<<HTML
<?PHP

\$pharmacyConfig = array (
	"key" => "829e496af0169846e1b3a9466da0351a7ae1f4b3878588291a99c2d12518dfdb0",
	"on" => "yes",
	"main_title" => "Поиск лекарств и товаров в аптеках",
	"field_on" => "on",
	"cache" => "yes",
	"cache_views" => "yes",
	"cache_time" => "120",
	"main_page_cats" => "yes",
	"main_page_max_columns" => "0",
	"main_page_max_echo_thread_cats" => "0",
	"main_page_on_last" => "on",
	"main_page_max_last" => "10",
	"view_cat_on_page" => "20",
	"short_echo_category" => "all_cat",
	"view_cat_max_columns" => "0",
	"short_echo_max_strlen" => "260",
	"short_echo_allowhtml" => "no",
	"fastsearch_on" => "on",
	"add_post_moder" => "yes",
	"add_post_end_date" => "0",
	"add_post_no_end_date" => "yes",
	"add_post_max_photo" => "10",
	"add_post_size_photo" => "5400",
	"add_post_thumb_photo" => "205",
	"add_post_photo_type" => "gif,png,jpg,jpeg",
	"add_post_photo_del" => "0",
	"add_post_main_cat" => "no",
	"add_post_admin_email" => "only_moder",
	"add_post_bbcode" => "no",
	"post_groups_add" => "1,4",
	"post_groups_edit" => "1",
	"post_groups_edit_all" => "1",
	"post_groups_no_moder" => "1,2",
	"post_groups_no_del" => "1,2,3,4",
	"post_groups_captcha" => "3",
	"echo_post_views" => "yes",
	"echo_post_vip" => "hand",
	"echo_post_supervip" => "hand",
	"echo_post_color" => "hand",
	"echo_post_color_hex" => "#eeeeee",
	"echo_post_author_email" => "on_create,on_del_pay",
	"com_on" => "yes",
	"com_anonim" => "no",
	"com_navigation_on" => "yes",
	"com_ajax_navigation" => "yes",
	"com_max_on_page" => "20",
	"com_sort" => "asc",
	"com_allocation" => "yes",
	"com_alternation" => "no",
	"com_antispam" => "30",
	"com_del" => "full",
	"com_groups_add" => "1,2,3,4",
	"com_groups_moder" => "1",
	"com_groups_captcha" => "5",
	"fullsearch_on" => "off",
	"region_on" => "off",
	"rss_on" => "no",
	"max_rss" => "150",
	"short_echo_city" => "no",
	"add_post_phone" => "no",
	"add_post_fio" => "no",
	"add_post_email" => "no",
	"add_post_price" => "no",
	"add_post_http" => "no",
	"echo_post_emailform" => "yes",
	"echo_post_friendform" => "no",
	"echo_post_vipprice" => "30",
	"echo_post_supervipprice" => "50",
	"echo_post_colorprice" => "20",
	"echo_post_blocksearch" => "yes",
	"id_version" => "1.1",
	"id_version_beta" => "0",
	"patches" => "",
);


?>
HTML;

$objects_config = <<<HTML
<?php
//Конфигурация модуля каталога
\$objectsConfig = array (
	"key" => "829e496af0169846e1b3a9466da0351a7ae1f4b3878588291a99c2d12518dfdb0",
	"on" => "yes",
	"field_on" => "on",
	"cache" => "yes",
	"cache_views" => "yes",
	"cache_time" => "120",
	"main_page_cats" => "yes",
	"main_page_max_columns" => "0",
	"main_page_max_echo_thread_cats" => "0",
	"main_page_on_last" => "on",
	"main_page_max_last" => "10",
	"view_cat_on_page" => "20",
	"short_echo_category" => "all_cat",
	"view_cat_max_columns" => "0",
	"short_echo_max_strlen" => "260",
	"short_echo_allowhtml" => "no",
	"fastsearch_on" => "on",
	"add_post_moder" => "yes",
	"add_post_end_date" => "0",
	"add_post_no_end_date" => "yes",
	"add_post_max_photo" => "10",
	"add_post_size_photo" => "5400",
	"add_post_thumb_photo" => "205",
	"add_post_photo_type" => "gif,png,jpg,jpeg",
	"add_post_photo_del" => "0",
	"add_post_main_cat" => "no",
	"add_post_admin_email" => "only_moder",
	"add_post_bbcode" => "no",
	"post_groups_add" => "1,4",
	"post_groups_edit" => "1",
	"post_groups_edit_all" => "1",
	"post_groups_no_moder" => "1,2",
	"post_groups_no_del" => "1,2,3,4",
	"post_groups_captcha" => "3",
	"echo_post_views" => "yes",
	"echo_post_vip" => "hand",
	"echo_post_supervip" => "hand",
	"echo_post_color" => "hand",
	"echo_post_color_hex" => "#eeeeee",
	"echo_post_author_email" => "on_create,on_del_pay",
	"com_on" => "yes",
	"com_anonim" => "no",
	"com_navigation_on" => "yes",
	"com_ajax_navigation" => "yes",
	"com_max_on_page" => "20",
	"com_sort" => "asc",
	"com_allocation" => "yes",
	"com_alternation" => "no",
	"com_antispam" => "30",
	"com_del" => "full",
	"com_groups_add" => "1,2,3,4",
	"com_groups_moder" => "1",
	"com_groups_captcha" => "5",
	"fullsearch_on" => "off",
	"region_on" => "off",
	"rss_on" => "no",
	"max_rss" => "150",
	"short_echo_city" => "no",
	"add_post_phone" => "no",
	"add_post_fio" => "no",
	"add_post_email" => "no",
	"add_post_price" => "no",
	"add_post_http" => "no",
	"echo_post_emailform" => "yes",
	"echo_post_friendform" => "no",
	"echo_post_vipprice" => "30",
	"echo_post_supervipprice" => "50",
	"echo_post_colorprice" => "20",
	"echo_post_blocksearch" => "yes",
	"id_version" => "1.1",
	"id_version_beta" => "0",
	"patches" => "",
);
?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/market.config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/market.config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $market_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/market.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/pharmacy.config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/pharmacy.config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $pharmacy_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/pharmacy.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/skidki.config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/skidki.config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $skidki_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/skidki.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/objects.config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/objects.config.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $objects_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/objects.config.php", 0666);

$tpl_memail = <<<HTML
<?PHP

\$MarketEmail = array (

	"send_create" => "v463vty3",
	"send_on_comment" => "4vt3v3t434vtg34regtve",
	"send_on_del_pay" => "vrt3vt34",
);

?>
HTML;

$tpl_semail = <<<HTML
<?PHP

\$skidkiEmail = array (

	"send_create" => "v463vty3",
	"send_on_comment" => "4vt3v3t434vtg34regtve",
	"send_on_del_pay" => "vrt3vt34",
);

?>
HTML;

$tpl_pemail = <<<HTML
<?PHP

\$pharmacyEmail = array (

	"send_create" => "v463vty3",
	"send_on_comment" => "4vt3v3t434vtg34regtve",
	"send_on_del_pay" => "vrt3vt34",
);

?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/tpl.market.email.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/tpl.market.email.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $tpl_memail);
fclose($con_file);
@chmod(ENGINE_DIR."/data/tpl.market.email.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/tpl.skidki.email.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/tpl.skidki.email.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $tpl_semail);
fclose($con_file);
@chmod(ENGINE_DIR."/data/tpl.skidki.email.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/tpl.pharmacy.email.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/tpl.pharmacy.email.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $tpl_pemail);
fclose($con_file);
@chmod(ENGINE_DIR."/data/tpl.pharmacy.email.php", 0666);

$tpl_xfm = <<<HTML
1|||ulica|||Доставка|||0|||0|||0|||all|||all|||1|||1|||0|||1|||mini_text||||||329|||value@#!!!#@##-@-##width@#!!!#@497
2|||dom|||Продавец|||0|||0|||0|||all|||all|||1|||1|||0|||2|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
6|||chasy-raboty|||Ссылка на товар|||0|||0|||1|||all|||all|||1|||1|||0|||6|||text||||||all|||value@#!!!#@##-@-##width@#!!!#@497##-@-##height@#!!!#@70
7|||fyvfyv|||Вес|||0|||0|||0|||all|||all|||0|||1|||0|||7|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
8|||121221|||Оценка|||1|||0|||0|||all|||all|||0|||1|||0|||8|||checkbox||||||326|||value@#!!!#@Супер&278&Средне&278&Так себе##-@-##show@#!!!#@
HTML;

$tpl_xfs = <<<HTML
1|||skidka|||Скидка|||0|||0|||0|||all|||all|||1|||1|||0|||1|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@497
2|||srok_do|||Действует до|||0|||0|||0|||all|||all|||1|||1|||0|||2|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
HTML;

$tpl_zast = <<<HTML
11|||adres|||Адрес|||0|||0|||0|||all|||all|||0|||1|||0|||11|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
12|||zastroyschik|||Застройщик|||0|||0|||0|||all|||all|||0|||1|||0|||12|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
13|||koordinaty-lat|||Координаты lat|||0|||0|||0|||all|||all|||0|||1|||0|||13|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
14|||koordinaty-lng|||Координаты lng|||0|||0|||0|||all|||all|||0|||1|||0|||14|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
15|||kolichestvo-komnat|||Количество комнат|||0|||0|||0|||all|||all|||0|||1|||0|||15|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
16|||ploschad|||Площадь|||0|||0|||0|||all|||all|||0|||1|||0|||16|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
17|||etazh|||Этаж|||0|||0|||0|||all|||all|||0|||1|||0|||17|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
18|||sayt|||Сайт|||0|||0|||0|||all|||all|||0|||1|||0|||18|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
HTML;

$tpl_xfp = <<<HTML
HTML;

$con_file = fopen(ENGINE_DIR."/data/fields.market.db", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/fields.market.db</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $tpl_xfm);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fields.market.db", 0666);

$con_file = fopen(ENGINE_DIR."/data/fields.skidki.db", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/fields.skidki.db</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $tpl_xfs);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fields.skidki.db", 0666);

$con_file = fopen(ENGINE_DIR."/data/fields.pharmacy.db", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/fields.pharmacy.db</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $tpl_xfp);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fields.pharmacy.db", 0666);

$con_file = fopen(ENGINE_DIR."/data/fields.objects.db", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/fields.objects.db</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $tpl_zast);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fields.objects.db", 0666);

update_kurs();

@unlink( ROOT_DIR . '/install.php' );
@unlink( ROOT_DIR . '/install_step1.php' );
@unlink( ROOT_DIR . '/install/install_step2.php' );
@unlink( ROOT_DIR . '/install/install_step3.php' );
@unlink( ROOT_DIR . '/install/install_step4.php' );
@unlink( ROOT_DIR . '/install/db_autocat.php' );
@unlink( ROOT_DIR . '/install/db_city.php' );
@unlink( ROOT_DIR . '/install/db_datting.php' );
@unlink( ROOT_DIR . '/install/db_firm.php' );
@unlink( ROOT_DIR . '/install/db_forum.php' );
@unlink( ROOT_DIR . '/install/db_obrazovanie.php' );
@unlink( ROOT_DIR . '/install/db_weather.php' );
@unlink( ROOT_DIR . '/install/db_faq.php' );
@unlink( ROOT_DIR . '/install/db_mini_city.php' );
@unlink( ROOT_DIR . '/install/db_post.php' );
$pathe= ROOT_DIR . '/engine/';
@chmod($pathe, 0755);
@unlink( ROOT_DIR . '/install/sborka_key_e1.php' );
@unlink( ROOT_DIR . '/install/sborka_key_e2.php' );
$path= ROOT_DIR . '/install/';
@chmod($path, 0777);
@unlink( ROOT_DIR . '/not-connected/blocks.php' );
@unlink( ROOT_DIR . '/not-connected/modules.php' );
@unlink( ROOT_DIR . '/not-connected/modules_admin.php' );
@unlink( ROOT_DIR . '/not-connected/navigationmenu.php' );
@rmdir(ROOT_DIR . '/install/not-connected/');
@rmdir(ROOT_DIR . '/install/');

@chmod(realpath(dirname(__FILE__)) . "/.htaccess", 0777);
@chmod(realpath(dirname(__FILE__)) . "/engine/ajax/.htaccess", 0777);
// - htaccess
$htaccess_set = "# billing
RewriteRule ^([^/]+).html/([^/]*)(/?)+$ index.php?do=static&page=$1&seourl=$1&c=$2 [L]
RewriteRule ^([^/]+).html/([^/]*)/([^/]*)(/?)+$ index.php?do=static&page=$1&seourl=$1&c=$2&m=$3 [L]
RewriteRule ^([^/]+).html/([^/]*)/([^/]*)/([^/]*)(/?)+$ index.php?do=static&page=$1&seourl=$1&c=$2&m=$3&p=$4 [L]
RewriteRule ^([^/]+).html/([^/]*)/([^/]*)/([^/]*)/([^/]*)(/?)+$ index.php?do=static&page=$1&seourl=$1&c=$2&m=$3&p=$4&key=$5 [L]";
// - /ajax/htaccess
$ajax_htaccess_set = "
<Files check_video.php>
order allow,deny
allow from all
</Files>
";

			if( is_writable( ".htaccess" ) ) {

				if ( !strpos( file_get_contents(".htaccess"), "# billing" ) ) {
					$new_htaccess = fopen(".htaccess", "a");
					fwrite($new_htaccess, "\n".$htaccess_set);
					fclose($new_htaccess);
				}

$patterns = <<<HTML
index.php?do=koshelek [QSA,L]
HTML;

$replacements = <<<HTML
/billing.html [QSA,L]
HTML;

                    $open_file = '.htaccess';
					$file_edit = file_get_contents($open_file);

					if (!@preg_match('billing.html', $file_edit))
					{
						$new_file = str_replace($patterns, $replacements, $file_edit);

						$fd = @fopen($open_file, "w+");
						fwrite($fd, $new_file);
						fclose($fd);
						chmod($open_file, 0644);
					}

			}

			if( is_writable( "/engine/ajax/.htaccess" ) ) {

				if ( !strpos( file_get_contents("/engine/ajax/.htaccess"), "check_video" ) ) {
					$new_ajax_htaccess = fopen("/engine/ajax/.htaccess", "a");
					fwrite($new_ajax_htaccess, "\n".$ajax_htaccess_set);
					fclose($new_ajax_htaccess);
				}

			}

@chmod(realpath(dirname(__FILE__))."/.htaccess", 0444);
@chmod(realpath(dirname(__FILE__))."/engine/ajax/.htaccess", 0444);

echo $skin_header;

echo <<<HTML
<form action="/index.php" method="get">
<div class="box">
  <div class="box-header">
    <div class="title">Установка завершена</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
		Поздравляем Вас, система Web2Work и DataLife Engine успешно установлены на Вашем сервере. 
		Вы можете просмотреть теперь главную страницу вашего портала и посмотреть возможности скрипта.
		 
		 <button class="btn btn-green" type="button" onclick="location.href='/'">Главная страница</button>
		 <br><br>
		Либо Вы можете зайти в панель управления портала и изменить другие настройки системы.
		
		<button class="btn btn-gray" type="button" onclick="location.href='/admin.php'">Панель управления</button>
		<br><br>
		<h2>Знакомство и первая настройка системы</h2>
		<br>
			<iframe width="560" height="315" src="//www.youtube.com/embed/AOhTpf4kago" frameborder="0" allowfullscreen></iframe>
		<br><br><font color="red">Внимание: при установки скрипта создается структура базы данных, создается аккаунт администратора, 
		а также прописываются основные настройки системы, поэтому после успешной установки удалите файл <b>install.php</b> 
		во избежание повторной установки скрипта!</font><br><br>
		Приятной Вам работы<br><br>
		Web2Work Group<br><br>
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="Продолжить">
	</div>

  </div>
</div>
</form>
HTML;

echo $skin_footer;

?>