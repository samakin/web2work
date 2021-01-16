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
  	if ((file_exists($loc_file)) && ($life_time<10400)){ // 10400 - ��� ����� ���������� ��������� � �������� (� ������ ������ - 3 ����)
    $fp = fopen($loc_file, 'r');
    if (filesize($loc_file) >0){
        $text = fread($fp, filesize($loc_file));
    }else{
        $text = '<span class="localfilesizeisnull">��������...</span>';
    }
    fclose($fp);
    if (strlen($text) > 20) return $text;
  }
    // ��������� ����������� ����
    $date = date("/m/Y");

    $nd = date("d");
    $nd = $nd;
    if ($nd<'10') $nd = ''.$nd.'';

   // ��������� ������
    $link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd$date";

     if (strlen($link) < 20) {
        // �� ��������� ����
        @touch($loc_file);
        return $link;
    }


    // ��������� HTML-��������
    $fd = fopen($link, "r");
    $text="";
    if (!$fd) $tr="������������� �������� �� �������";
    else
    {
      // ������ ����������� ����� � ���������� $text
      while (!feof ($fd)) $text .= fgets($fd, 4096);
    }
    // ������� �������� �������� ����������
    fclose ($fd);

       // ��������� ����������, ��� ������ ���������� ���������
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
   // ��������� ������
    $links = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd2$date";

     if (strlen($links) < 20) {
        // �� ��������� ����
        @touch($loc_file);
        return $link;
    }


    // ��������� HTML-��������
    $fd = fopen($links, "r");
    $texts="";
    if (!$fd) $tr="������������� �������� �� �������";
    else
    {
      // ������ ����������� ����� � ���������� $text
      while (!feof ($fd)) $texts .= fgets($fd, 4096);
    }
    // ������� �������� �������� ����������
    fclose ($fd);

 // ��������� ����������, ��� ������ ���������� ���������
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
   // ��������� ������
    $linkser = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd3$date";

     if (strlen($linkser) < 20) {
        // �� ��������� ����
        @touch($loc_file);
        return $linkser;
    }


    // ��������� HTML-��������
    $fd = fopen($linkser, "r");
    $textser="";
    if (!$fd) $tr="������������� �������� �� �������";
    else
    {
      // ������ ����������� ����� � ���������� $text
      while (!feof ($fd)) $textser .= fgets($fd, 4096);
    }
    // ������� �������� �������� ����������
    fclose ($fd);

 // ��������� ����������, ��� ������ ���������� ���������
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

$handler = fopen(ENGINE_DIR.'/data/config.php', "w") or die("��������, �� ���������� �������� ���������� � ���� <b>.engine/data/config.php</b>.<br />��������� ������������ �������������� CHMOD!");
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

$con_file = fopen(ENGINE_DIR."/data/yandex_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/yandex_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
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

$con_file = fopen(ENGINE_DIR."/data/yandex_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/yandex_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
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

$con_file = fopen(ENGINE_DIR."/data/weather.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/weather.txt</b>.<br />��������� ������������ �������������� CHMOD!");
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

$con_file = fopen(ENGINE_DIR."/data/googlemaps_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/googlemaps_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
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
\$config['obj_firm_text'] = '� ����������� ��������� � ������� ����������� �� ������ �������� ����������� �� ������ ������ ������ � ������, �������� ����������� ��������, � ����� ������ �� ���������� �����-����� �����������.';
\$config['obj_shop_text'] = '<h3>�������� ��������.</h3>
����������� ����� ������ ������ �������� ���������, ����� 30 ������. ������� �������, ��������� ��������, ����, �����, ������, �������, ���������� � �� ��� ������� ����� ���������� � � ������� ��������-���������.��� ���������� ������� � ��������-�������� ��� ������� �������� ������� ������ � ������� � ����� ��������. ��� ������ ��� ��������� ������ ����� ��������, ��� ��� �� ����� ������� �������� ����� ����.������ � ����, ��� �� ��� �������� ������������� ���������� �������� � �������� �������.  ��� ��������-�������� ����� ����� ������ �� ����� ������, ��� ����� ����������� ��������� ����� ������������ ������. ��������� �������� �������� ������������� ����������� �� �������������� ������� �� ����� � ����������� ������� � ������ ���������.				��� ���� ����: �������������� ��������-�������� � ��� ������������ �������� �� ��������� � ����� ������� ����� �������� ����������� ������. ������ ��� ������ ������������ � ���� ����������� ������, ��� ��� ���  ��� ��������� �� �������. ��� �� �������� ���������, �� �� ������ ��� ������ �������� ����, ���  �������� �� ������ ������� ��� �����.				<br>
����� ����, �� ��������� ������ ����� �� ������� ����� ����� ������ � ���������� ���������� ��� ���� ���������� ������ � �������, ������� ���������� �������������� �������� ��������. �, ������� ��, �� ������ ������ �������� �������������� ������ �� 2 �� 10% ��� ������� ������� �� ����� ����� � �������������� ����� �����.';
\$config['obj_addfirm_text'] = '� ������� ������� ����� �������� ����� ������ �������� � ���� �� ���������� ��������, ������� ���������� � ���������� �� �� �����.����� ����������� ����������� �� �������: <BR>
1. �������� �������������� ����������� �� �����<BR>
2. ��������� �����-���� �����������<BR>
3. �������� ������ �� �����-����� ����� �� ����� � ������ �������';
\$config['obj_tarif_text'] = '��������� ������������! ����� ������ ���������, �� ��������� ���������� ������� ������ ������ �� 3 ��� (� ������ �������� - 1 ����). �� ��������� �������� �������, ���������� � �������� ����� �������� � ����������� �������: �������� ��������, ��� ������������, �����, �������.';

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
\$config['obj_banki_text'] = '<h1>�����</h1>
<strong>�����</strong> � ������ ���� ������ � <a href="/banki/deposit/">�������</a>, ���������, <a href="/banki/crediting/">��������</a> � ������. ������������ ������������ ���������� ���������� � ������ �� <a href="/banki/hypothec/">�������</a>, ���������� � �������� ������ ���������� �����. ������� ������, ���������� � ������ � ������ �������. ���������� � ������ �������������� ������ (���) � ����������� ���������.<br>�� ����� ������� ����������� ������ � ������ � ������ �������� �������� � �������� ������. ����� ����� ��������� ������ ����� �������������� ����� <a href="/banki/cash/">������ ����������</a> ���� ������� ���������� ��� <a href="/banki/offices/">���� ����� �� �����</a>.<br>
��� ������ ������ ������� ��������� � ��� ��������� �� <a href="/banki/exchanges/">����� �������� �������</a> ��� ����������� <a href="/banki/exchanges/">� ������ ������ ����� � ������</a>';

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
\$config['work_n_width'] = "����� 5000 �������� ������� ������������� ������! ������ ���� ������ ���������, ���������� � � ������������ �����. ��������� �� ����� ����� ���� � ������� ������ ����� 500 �������.";
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
\$config['nedv_n_width'] = "<b>����������� � {$_REQUEST['city_ckaburge']}</b><br>����� 11000 ���������� � ������������ ������! ������ ���� ������ ���������, ���������� � � ������������ �����. ��������� �� ����� ����� ���� � ������� ������ ����� 5000 �������.";
\$config['nedv_n_height'] = "{$_REQUEST['city_ckaburge']}";
\$config['nedv_n_height2'] = "<a href=web2work.ru><img src=http://web2work.ru/templates/{$config['skin']}/img/logo.png></a>";
\$config['fiemwo_news_category'] = '155,2,0';
\$config['afishawo_news_category'] = '1012';
\$config['forumwo_news_category'] = '44';
\$config['questionwo_news_category'] = '23,21,20';
\$config['nedv_system_news'] = "1,10,0,1,news_index_top|2,10,1,5,news_index_other|3,10,0,5,news_index_other|4,10,6,5,news_index_other|5,10,0,5,news_index_other";

?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/block_nedv_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_nedv_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_nedv_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_nedv_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_work_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_work_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_work_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_work_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.banki.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config.banki.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_banki);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.banki.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_video.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config_video.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_video);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_video.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_vk.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config_vk.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_vk);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_vk.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/firm_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/firm_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $firm_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/firm_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/pay.config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/pay.config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $pay_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/pay.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/smscoin_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/smscoin_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $smscoin_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/smscoin_config.php", 0666);

$edit_obj = <<<HTML
t14|��� ����������|������;�����;�������|select|1|0|auto
t2|��� ����������|������;�����;����;�����|select|1|0|nedv
formoplati|����� ������|�����;�����;�����+%;%;������;���������;��������;������|select|0|0|vacations
tiprab|��� ������|�����;����������;�� ����������������;���������|select|1|0|vacations
graphrab|������ ������|�����;������ ������� ����;�� ������ ������� ����;���������;��������|select|1|0|vacations
usl|�������||textarea|1|0|vacations
treb|����������||textarea|0|0|vacations
obaz|�����������||textarea|1|0|vacations
aboutcomp|� ��������||textarea|1|0|vacations
obrazie|�����������|������;������������ ������;�������;������������ �������;������� �����������;������|select|1|0|vacations
stag|���� �� (���)||text|1|0|vacations
znanyaz|������ ������||textarea|0|0|vacations
znankomp|������ ����������||textarea|1|0|vacations
bizob|������-�����������||textarea|1|0|vacations
pol|���|�������;�������;�����|select|1|0|vacations
uczav|������� ���������||text|1|0|rezume
stah|���� �� (���)||text|1|0|rezume
tiprazb|��� ������|�����;����������;�� ����������������;���������|select|1|0|rezume
predrab|����� ���������� ������||textarea|1|0|rezume
graphrzab|������ ������|�����;������ ������� ����;�� ������ ������� ����;���������;��������|select|1|0|rezume
obrazie|�����������|������;������������ ������;�������;������������ �������;������� �����������;������|select|1|0|rezume
znaniyaz|������ ������||textarea|1|0|rezume
znankompi|������ ����������||textarea|1|0|rezume
biziob|������-�����������||textarea|1|0|rezume
dopsved|�������������� ��������||textarea|1|0|rezume
vazhnost|��������|���;������;�� ���� ������;������ �������, �� ���������� ������� ����� �����������|select|1|0|rezume
poil|���|�������;�������|select|1|0|rezume
vozrast|�������||text|1|0|rezume
t12|������� �������|������������;�������;��������;���������;����������������|select|1|0|auto
t11|��� ���������|������ ��������;������ ����������;������ �����;������ �����������;������ ����������;������;������ �����������;���������|select|1|0|auto
t9|���������|��������;�������;�����;�������|select|1|0|auto
t15|������|��������;������;������|select|1|0|auto
t4|���||text|1|0|auto
t5|������ (��)||text|1|0|auto
t6|����||text|1|0|auto
t7|����� ��������� (��3)||text|1|0|auto
t8|�������� (�.�)||text|1|0|auto
t10|�����|�����;�������;���������;�����������;����;�������;������������;�����;���������|select|1|0|auto
t13|����|�����;������|select|1|0|auto
t11|���������� ������|1;2;3;4;5;6|select|1|0|nedv
t10|����� �������|0.0|text|1|0|nedv
full_area|����� �������||text|1|0|nedv
t1|����||text|1|0|nedv
t12|����� ������||text|1|0|nedv
t13|����� ����||text|0|0|nedv
t5|�����||text|0|0|nedv
t11|��������|�����;������;����;������|select|1|0|zagor
full_area|������� ���� (�.��)|0.0|text|1|0|zagor
t10|������� ������� (���)||text|1|0|zagor
t1|����||text|1|0|zagor
t12|���-�� ������||text|1|0|zagor
t5|���������� �����||text|1|0|zagor
t13|���������� �� ����������� ������ (��)||text|1|0|zagor
t11|������������|� ������-������;� ����, ������;� �������� ���������;�� ������������ ����������;��������� ������|select|1|0|comm
full_area|������� (�.��)|0.0|text|1|0|comm
t9|��������� ����|��, � �����;��, �� �����;���|select|1|0|comm
t1|����||text|1|0|comm
t5|�����||text|0|0|comm
t13|����� ����||text|1|0|comm
klovokomn|���������� ������||text|1|0|objectnedv
materioal|��������|�������������;�����������;�����;������;����;������|select|1|0|objectnedv
sroksdac|���� �����||text|1|0|objectnedv
t11|���������� ������|1;2;3;4;5;6|select|1|0|predlnovo
t1|����||text|1|0|predlnovo
t12|���-�� ������||text|1|0|predlnovo
t10|����� �������|0.0|text|1|0|predlnovo
full_area|����� �������||text|1|0|predlnovo
t2|�������||text|1|0|predlnovo
t3|�������||text|1|0|predlnovo
t10|����� �������|0.0|text|1|0|predlkot
full_area|����� �������||text|1|0|predlkot
t2|���������||text|1|0|predlkot
t3|�������||text|1|0|predlkot
t10|������� ������� (���)||text|1|0|zemuch
t13|���������� �� ����������� ������ (��)||text|1|0|zemuch
t5|���������� �����||text|1|0|zemuch
kratkopis|������� ��������*||textarea|0|0|tenders
srconec|���� ��������� ������ ������ (� ������� ��.��.����)*||text|0|0|tenders
sotr|������������� ��������������� ��������������|��;���|select|0|0|tenders
valuta|������|{$_REQUEST['valuta']}; �������; ����|select|1|valuta|auto
HTML;

$con_file = fopen(ENGINE_DIR."/data/edit_obj.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/edit_obj.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $edit_obj);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_obj.txt", 0666);

$edit_profile = <<<HTML
fullname|������� ��� ��������||text|1|1|basic|1|0
sex|���|�������;�������|select|1|0|basic|0|1
polsex|�������� ���������|�����;�������;�� �����;�� �������;���� �������;���� ����;� �������� ������;���������;����������;��� ������|select|1|0|basic|0|1
vzgladi|������������ �������|�������������;��������������;����������������;���������;�����������|select|1|0|basic
city|������ �����||dbcity|1|0|basic|1|0
mob_phone|��������� �������||text|1|0|contakti|1|0
dom_phone|�������� �������||text|1|0|contakti
icq|ICQ||text|1|0|contakti
birthdate|���� ��������||dbbirthdate|1|0|basic|0|1
webs|������ ����||text|1|0|contakti|0|1
email|���������� Email||text|1|0|contakti|1|0
info|� ����||textarea|1|0|lichn
deyatelnost|������������||dbconnect|1|0|lichn
interests|��������||dbconnect|1|0|lichn
style|������� ����������� �����||text|1|0|lichn
ishu|���������||dbconnect|1|0|basic|0|1
HTML;

$profile_pages = <<<HTML
userinfo_afisha|user_event||�������|
userinfo_friend_online|user_friend_online||������ �� �����|
userinfo_friend|user_friend||������|
fotoalbum|fotoalbum|1|����|
my_video|archiv_video/users|1|�����|
userinfo_blog|user_blog|1|����|
userinfo_groups|user_groups||����������|
HTML;

$con_file = fopen(ENGINE_DIR."/data/edit_profile.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/edit_profile.txt</b>.<br />��������� ������������ �������������� CHMOD!");
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
\$namecitys = "������ � {$_REQUEST[city_ckaburge]}";

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
\$config['buro_n_width'] = "��������! ���������� ����������!
������� �� ������������ ������ ����� �������� (����� SMS, ������� �� ����.�����, ���������� ���������, �������� �� �������, ������������ �������� � �.�.) ��������, ��������� ���� ���� �� ���� �������, ���� �� ����� �� ���������, ��� ��� ���� ���� � ����������� ������ ���. ���� ������� �������� ���� �� �������, ��������� �����������, �����������, ��, ������ �����, ��� ��������. ��������� � �������������� ������� � ����������� ������� ������.";
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
\$config['eda_main_text'] = "<h2>����, ���� � ���������</h2>������ �<strong>���������, ����, ����</strong>�, ��� ��� ��� �� ���� ���������������� ���������� ������. �� ������ ������� ����� ���������� ��� ����� � ������� ��������� ����. ��� �������� ������������� ������������ � ����������� ������ �������������� ��� ����, ���� ��� ��������� � ���������� ���. � �������� ���� ���� � ���������� ����������� ������������, ��� ���� ���������, ��� � ��� ����������� ����, ��� �� ������ ������������ � ���������� ����� ��������. ������ ����� �� ������ ��������� ������ � ����� ����, ����, ��������� ��� �������� ���. ��� ����������� ����������� ��������� ������������.<br>";
\$config['eda_system_news'] = "1,10,0,1,news_index_top|2,143,0,5,news_index_other_block|3,143,0,5,news_index_other_block|4,143,0,5,news_index_other_block";

?>
HTML;

$block_exclusive_config = <<<HTML
<?PHP

\$config['exclusive_category'] = "212";
\$config['exclusive_names'] = "����������� �� �������";
\$config['exclusive_colvoglav'] = "6";
\$config['exclusive_colvoblog'] = "6";
\$config['exclusive_category_allowrating'] = "1";
\$config['exclusive_category_allowcomm'] = "1";
\$config['exclusive_system_news'] = "1,214,,,|2,213,,,|3,5,,,|4,215,,,|5,219,,,|6,216,,,";

?>
HTML;

$block_galeryusers_config = <<<HTML
<?PHP

\$config['galeryusers_names'] = "������� �������������";
\$config['galeryusers_limit'] = "19";
\$config['galeryusers_width'] = "66";
\$config['galeryusers_height'] = "";
\$config['galeryusers_group'] = "3";
\$config['galeryusers_activcity'] = "0";

?>
HTML;

$block_gpblock_config = <<<HTML
<?PHP

\$config['gpblock_name'] = "������� �����������";
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
\$config['interview_names'] = "��������";
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
\$config['obj_auto_text'] = '<h2>������� ���������� �� ������� �����������</h2>
<div class="padding_doska_main">
������ ���� ���� �������� � ������� ����, � ��� ����� � �� ��������. ������ ����������� ��������� � ����������� ���������� � ������� ���������. ����������� ������� ������������ ������ ����� ������� � ����������� ����, ������ ����� ������� ��������.
</div>
<div class="space"></div>
<div class="padding_doska_main">
�������, ������� ������� ����������� ������� ������ �� ������� � �� ����������, ��� � ����� ��������� �����, ������ �������� � ���������� ������. ������������� �� ������� � ���:
</div>
<div class="padding_doska_main">
	<ul class="spisok">
		<li>�������, �� ������� ��������� ������� ��������������;</li>
		<li>���������� ���������� ���������� �� ������� �/� �����������, ����������� � ����� ���� � ����������� �� ���������� �� �������� ����������;</li>
		<li>�������� ������� ����� ���������� � �������� � �� ������� ����������� ����� ��������� �� �������� ��� �����;</li>
		<li>������ ����������� � �������� �� ����������.</li>
	</ul>
</div>
<div class="space"></div>
<div class="padding_doska_main">
��� ���� ����� ����� �� ������� ����� �������, �������������� ��������. � ��� �� ������ ������� ���� ������� ������������, ��� ������ � ����� ����, ��������� �� ��������� � ������ ������, ��� ������� � ��. ���������. ��� ���������� ����� ������������� �� ���� ��� ������� ���������� ���������� � ������� �� ����.
</div>
<div class="space"></div>
<div class="padding_doska_main">
� ������� ����� ���������� �� ������� ����������� ���� �� ����������� ���������� ���� ����� � ��������� � ��������� ������ ������ ��� �����������, ���������������� � ������ �������.
</div>
<div class="space"></div>
<div class="padding_doska_main">
����� �� ������ ����� ���������� �� ���������������� ����� � ������� � ������� ����, �� � ���������� ����������. ���������� ��������� ��� ���� ����� � ��������� ����������. ���������� ���������� ���������.
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
\$config['mesta_colnamecat'] = "<b>����� �����:</b>";
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
\$config['tenders_n_width'] = "�����";
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
\$config['block_auto_spravka_text'] = "��������� ���������! 1000 ���ss! ��� ���� ����� ��������������! �� ��������� ����������� ��������������� ����� �������, �������� ������ � ���� ������ (�������� � ����������� ����, �������� ����������).";
\$config['block_auto_spravka_title'] = "��������� � ���������";
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
'tema' => "�������",
'pm_text' => "��������� {name}! <br/>��� ��� ������ ������� {medal_image} &quot;{medal_name}&quot; ({medal_alt}) ����� {medal_point} �����!",
'awards_pm_del' => "0",
'tema_del' => "������� �������",
'pm_text_del' => "��������� {name}! <br/>� ��� ������� ������� {medal_image} &quot;{medal_name}&quot; ({medal_alt}) ����� {medal_point}!",
'awards_pm_edit' => "0",
'tema_edit' => "���������",
'pm_text_edit' => "��������� {name}! <br/>��� ������� {medal_old_image} &quot;{medal_old_name}&quot; ({medal_old_alt}) ����� {medal_old_point} ����� ��� ������� �� {medal_image} &quot;{medal_name}&quot; ({medal_alt}) ����� {medal_point} �����!!",
'awards_toppoints' => "1",
'awards_topawards' => "1",
'awards_auto' => "1",
'systemname' => "������� �� �������������",
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
\$config['obj_hotels_text'] = '<h2>���������</h2>
<p><b>������������ ����� ��������, ���� � ����� �������</b> � ������. ������ � ����������, �������� ���������� � ��������� ���������.</p>
<p>����� ������������ ������, �� ������ ������, � ������ ��������� �������. �� ��� �� ������� ������ ��������� �������, ������� ������� ��� ��������� �����, �������� ��������������� ����� ��������, ����� �� ��������� ����� ���������. </p>
<p>����, ������ �� ������. ����������, ��� <strong>��������� � ������� ������</strong> ����������� ��������� ��������, ������������� ���������� ��������, �, ��������������, �������� ������.  5-���������� ����� ������ ������������� ������ ������������ �������, ���������� ���������������������� ��� ������ � ������ ����� � ��������� ��������. �������� ������������, ����������� ������������, ����� � ������ ������������ ������� ����� �������� �� ����� ������. ��������� � 4 ������ �������� ���� � �������, �� ��� ������ �� ������������ ��� � ������� �����������. �����, ������ �������� �������, ������ ������������ ���������-����, ���������, ���������� ���������, ��� ��������� �������� ��� ��� ������, ��� � ��� ������� ������. 3 ������ �������� ����������� ��������. ����������� ���� � �������� �����, �������, ����� ������������. ��� ��������� ������� ��� ���������������� ������. 2-���������� ��������� ����� �������. � ������ ������ ����� ������������� ������� ����������� ������. ������ ����� ��������� �������� ��������� ������, �������� �����������. ��� �������, ���������� ��� ������������ � ��������� ��������� �������������� �������. </p>
<p>������������� � ������� ���������, �������� � ������� ���������� ��� ��� ������. ���������� �������� ����� ��������, ���������������� � ��������������� ��� ������. ���������� ������ ������ ������, ����������� � ����. ��������� �����  ����� ���������� ������ �������� �������, �� ��� �� �������������� �����������.  ��� ���������� ����� ���� ����������� � ������� �����, ������� ����������� ��� �� ����� ���������� � ���������. </p>
<p>��������� �������� ������� ������, ����� ��������� �������� ���������� �������. ������� ����� ������� ������ �� �������������� ����, ����������������� � ������. ����� ��������� ��� �� �������������� �� ��������. ������ �� ����� ����������, ������ ������ ��� ��������� � ���������� � ��������� ��� ������������ ����� ��������. ����� �� ������� ������������ � ��������� ����������� � ���������, ������� ��������������� �����, ����� � �.�. ��� ������������� ����� ������������� ����� ������. ��� ����� ������� ��������� ��������� �����, ������ ���������� ��������, � �������� ���� ��������. ��������� ������! </p>';
\$config['obj_hotels_right_text'] = '<h2>���������</h2>
<p>� ������ � ������� ������ ���� ����������� ���������� ������ ����� ����������� ������ � ���������, ����� ��� � ��������, ��������� ���������. �� ��������� ������� � �������� �������� ����� ����������� �� ������ �� ����� �� ��������� ��� �/� �������, �������� ���� ��������� ������� � ���� �� ���������� � ���������.</p>
<p><strong>� ������� ������������ ������� ����� � ���������</strong> �� ������� � �������������� ������� � ������, � ����� �������������� �������� � ������ �����. �� ������ ��������� �������� ���������, ����� ��� ��������� � ��� ������, ��� ����� ��������� ���� �����������. � ������� ���������-����� �� ������ ������� ������������, � ����� ������� �������������� ������.</p>';

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
'symbol' => "�",
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
'email_head' => "����� ��������� �� �����",
'charset' => "windows-1251",
'content_type' => "plain",
'send_demo' => "yes",
'sendpm' => "no",
'pm_head' => "����� ��������� �� �����",
'user_from' => "Adobe",
'status_read' => "no",
'admin_id' => "1",
'head_up_form' => "����� �������� ������� V.I.P ������� ��� ������������ ����:",
'color_up_form' => "008000",
'size_activ_form' => "40",
'color_background' => "e0f7bd",
'caption_button' => "������������",
'caption_demo_button' => "�������� ����",
'oldfile' => "vip.dat",
);

?>
HTML;

$datting_config = <<<HTML
<?PHP

\$config['datting_descr'] = "�������� ����������, ����������� ����� �����, ����������� ������ ���������� � ��� 100";
\$config['datting_keyw'] = "����������, ������, ������������, �����, ������, ������������, ����� ������, ����������� �����";
\$config['datting_descr_ak'] = "������ ������������, �������� ������� �������� ��� ����������� ���������� ��� ����������,  ���������� ������������, ������� ������������. �� ������ ������� �������, ��������� ���������.";
\$config['datting_keyw_ak'] = "������ ������������, ��������, ����������, ����������, ����������, �������, ������� �������, �����������, �������";
\$config['datting_descr_av'] = "����������� ������������, �������� ������� �������� ��� ����������� ���������� ��� ����������,  ���������� ������������, ������� ������������. �� ������ ������� �������, ��������� ���������.";
\$config['datting_keyw_av'] = "������ ������������, ��������, ����������, ����������, ����������, �������, ������� �������, �����������, �������";
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
\$filesConfig['title_mirror1']  = "������� 1";
\$filesConfig['title_mirror2']  = "������� 2";
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
'forum_title' => "�����",
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
'forum_pr_imp' => "�����:",
'forum_pr_vote' => "�����:",
'forum_pr_modr' => "���������:",
'forum_pr_sub' => "���������:",
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
'discuss_title_tpl' => "������: {post_title}",
'tools_disc_post' => "1",
'discuss_post_tpl' => "����� ����������� ������: [url={post_link}]{post_title}[/url]",
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
'mail_subject' => "��� ���� ({%sender-name%}) ���������� ��� ������������������ �� ����� {%home-title%}",
'mail_text' => "��������� {%friend-name%}, ��� ���� {%name%} ��������� ��� ����������� � ��� �� �����.
\   ��� ����������� ��������� �� ������ {%reg-link%}!
\
\   �� {%name%} :
\   {%invite_text%}
\
\   � ���������, {$config['http_home_url']}
\   �� ������� �� ����, �������!",
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
"yandex.ru" 		=> array("yandex.ru", "Y", "text=", "�ndex.ru", "http://yandex.ru/", "yandex.png"),
"rambler.ru" 		=> array("rambler.ru", "R", "words=", "�������", "http://rambler.ru/", "rambler.png"),
"mail.ru" 		=> array("mail.ru", "L", "q=", "Mail.ru", "http://go.mail.ru/", "mail.png"),
"gogo.ru" 		=> array("gogo.ru", "O", "q=", "gogo.ru", "http://gogo.ru/", "gogo.png"),
"aport.ru" 		=> array("aport.ru", "A", "r=", "�����", "http://aport.ru/", "aport.png"),
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
'link' => "<a style=\"{colorsize}\" title=\"�������: {tagname} ({count})\" href=\"{taglink}\" class=\"cloud-tags\">{tagname}</a>",
'separator' => " ",
'max_size' => "12",
'min_size' => "10",
'type_font' => "px",
'arb_color' => "yes",
'max_color' => "#757575",
'min_color' => "#4a92ad",
'no_tags' => "� ��������� ������ ��� ������ ���� �� ������ ����",
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

////////////// ����� �� ������ 7.0 ////////////////////////

$citys_curs = <<<HTML
moskva;chelyabinsk;ekaterinburg;sankt-peterburg;chelyabinsk;nizhniy_novgorod
HTML;

$citys_raspisanie = <<<HTML
|183;����
|213;������
|2;�����-���������
|225;������
|10002;�������� �������
|10003;����� �������
|138;��������� � �������
|241;������
|245;������� � ����������
|213;������
|214;������������
|215;�����
|216;����������
|217;������
|349;������ ������ �������
|350;�������������
|219;������������
|10740;������
|10738;�������
|10743;��������
|10747;��������
|20571;���������
|10752;������� �����
|10716;��������
|10742;�������
|10748;�������
|10750;���������
|10758;�����
|10765;�������
|10754;��������
|10734;�������
|10745;�������-�����
|10733;����
|10761;�����
|10756;�������
|10735;�����������
|20523;������������
|20728;������
|21621;������
|10719;������
|21622;���������������
|10725;����������
|10755;�������������
|10723;�������
|10746;���������� �����
|20674;������
|413;������ ������ �������
|414;�������������
|11119;���������
|542;�������������
|11158;���������� �������
|11162;������������ �������
|11176;��������� �������
|11193;�����-���������� ��
|11225;����������� �������
|11232;�����-�������� ��
|573;������ ������ �������
|574;�������������
|11235;��������� ����
|11266;��������� �������
|11282;����������� �������
|11309;������������ ����
|11316;������������� �������
|11318;������ �������
|10231;���������� �����
|11330;���������� �������
|10233;���������� ����
|11340;���������� �������
|11353;������� �������
|21949;������������� ����
|605;������ ������ �������
|606;�������������
|11403;����������� �������
|11398;���������� ����
|10243;��������� ���������� �������
|10251;��������� ���������� �����
|11457;����������� ����
|11409;���������� ����
|11375;�������� �������
|11443;���������� ���� (������)
|11450;����������� �������
|86;�������
|87;���������
|89;�������
|90;���-���������
|91;�����
|200;���-��������
|202;���-����
|223;������
|637;������
|638;�������������
|1048;������
|1049;�������������
|97;�����������
|98;�����
|99;������
|100;���������-��-�����
|101;��������
|177;������
|178;�������
|701;������
|702;�������������
|118;����������
|119;��������
|120;������
|121;��������
|122;��������
|123;���������
|124;�������
|125;�����
|126;���������
|127;������
|180;������
|203;�����
|204;�������
|205;������
|733;������
|734;�������������
|96;��������
|102;��������������
|113;�������
|114;�������
|115;��������
|116;�������
|246;������
|980;������ ������
|20574;����
|10069;������
|10083;��������
|21610;����������
|983;������
|139;����� ��������
|211;���������
|829;������
|830;�������������
|893;������
|894;�������������
|29630;������� �������
|29631;���������� �������
|29633;��������� �������
|29632;��������� �������
|29634;����������� �������
|29629;����������� �������
|157;�����
|925;������
|926;�������������
|29406;����������� �������
|29411;�������������� �������
|29403;����������� �������
|29408;��������-������������� �������
|29415;������������ �������
|29412;������������ �������
|29410;�������-������������� �������
|29416;������-������������� �������
|29417;����-������������� �������
|29404;����������� �������
|29407;���������� �������
|29414;������������� �������
|29409;���������� �������
|29413;�������������� �������
|170;���������
|171;����������
|187;�������
|207;��������
|208;�������
|209;�����������
|958;�������������
|957;������
|149;��������
|159;���������
|167;�����������
|168;�������
|29386;�������
|29387;����� ������
|129;����-����
|130;���������
|131;����-����
|132;�����
|765;������
|766;�������������
|994;�����
|995;�������
|1004;������� ������
|134;�����
|135;�����
|137;������
|797;������
|798;�������������
|169;������
|861;������
|862;�������������
|20544;�������� �������
|20549;���������� �������
|20546;���������� �������
|20545;��������� �������
|20548;�������������� �������
|20547;����������� �������
|20538;����������� �������
|20536;�������� �������
|20537;���������������� �������
|20540;��������� �������
|20539;����������� �������
|20541;�������� �������
|20543;������������ �������
|20542;���������� �������
|20529;��������� �������
|20535;����������� �������
|20531;������������� �������
|20534;��������� �������
|20533;����������� �������
|20550;��������� �������
|20530;������������ �������
|20532;�����-����������� �������
|20552;������� �������
|20551;������������ �������
|10313;�������
|10317;���������
|10314;������
|10315;�������
|33883;������
|115675;�������������
|115674;������
|17;������-�����
|26;��
|40;��������
|52;����
|59;������
|73;������� ������
|381;������
|382;��������������
|3;�����
|102444;�������� ������
|115092;�������� ����������� �����
|978;������ ������ �������
|979;�������������
|146;�����������
|959;�����������
|11470;����
|11464;�����
|11469;��������
|11463;���������
|11471;������
|981;������
|982;�������������
|206;������
|117;�����
|179;�������
|1054;������
|1055;�������������
|181;�������
|210;������������ �������� �������
|1056;������
|79;�������
|21782;������
|21781;�������������
|78;�������������-����������
|21793;�������������
|21794;������
|11393;����������
|21783;�������������
|21784;������
|11458;�������
|21785;�������������
|21786;������
|76;���������
|11453;�����������-��-�����
|21789;�������������
|21790;������
|75;�����������
|974;�������
|11426;���������
|21780;������
|21779;�������������
|77;������������
|21791;�������������
|21792;������
|11374;���������
|11391;�����
|74;������
|21787;�������������
|21788;������
|80;����-���������
|21777;�������������
|21778;������
|197;�������
|975;�����
|11251;��������
|21796;�������������
|21797;������
|11256;�������
|976;������
|63;�������
|11273;����-������
|21798;�������������
|21799;������
|64;��������
|11287;������������
|237;�����������
|11291;�����������
|21800;�������������
|21801;������
|11302;������
|62;����������
|11311;��������
|20086;������������
|21802;�������������
|21803;������
|11306;��������
|11314;������
|65;�����������
|21804;�������������
|21805;������
|66;����
|21807;������
|21806;�������������
|11319;�����-�������
|21808;�������������
|21809;������
|198;����-���
|21810;�������������
|21811;������
|11333;�����
|21812;�������������
|21813;������
|1095;������
|11341;����������
|21814;�������������
|21815;������
|67;�����
|21816;�������������
|21817;������
|11351;�������
|53;������
|21825;�������������
|21826;������
|54;������������
|11164;�������-���������
|11168;������ �����
|11170;�����������
|11171;������������
|21828;������
|21827;�������������
|55;������
|11175;��������
|21829;�������������
|21830;������
|11173;����
|57;�����-��������
|973;������
|1091;�������������
|21831;�������������
|21832;������
|56;���������
|235;������������
|11212;�����
|11202;��������
|11217;�����
|11214;������
|11218;��������
|21833;�������������
|21834;������
|58;��������
|21835;�������������
|21836;������
|46;�����
|21837;�������������
|21838;������
|11071;������-������
|41;������-���
|21839;�������������
|21840;������
|11080;�������
|47;������ ��������
|11083;�����
|21841;�������������
|21842;������
|972;���������
|20258;�����
|20044;������
|20040;�����
|48;��������
|11091;����
|21843;�������������
|21844;������
|49;�����
|21845;�������������
|21846;������
|50;�����
|11110;���������
|21847;�������������
|21848;������
|172;���
|11114;����������
|11115;�������
|11116;�����������
|21849;�������������
|21850;������
|42;�������
|21852;�������������
|21853;������
|43;������
|236;���������� �����
|11127;����������
|21854;�������������
|21855;������
|11123;�������
|11121;�����������
|11122;��������
|11125;������������
|11129;���������
|51;������
|240;��������
|11139;�������
|21856;�������������
|21857;������
|11132;���������
|194;�������
|11143;��������
|21858;�������������
|21859;������
|11147;�������
|44;������
|11150;������
|21860;�������������
|21861;������
|11152;�������
|195;���������
|11155;������������
|21862;�������������
|21863;������
|45;���������
|21864;�������������
|21865;������
|37;���������
|21866;�������������
|21867;������
|38;���������
|10951;��������
|21868;�������������
|21869;������
|1107;�����
|35;���������
|970;������������
|239;����
|1058;������
|10990;���������
|10987;�������
|10993;����
|21870;�������������
|21871;������
|1093;������
|21872;�������������
|21873;������
|28;���������
|21874;�������������
|21875;������
|1092;�������
|21876;�������������
|21877;������
|30;�������
|21878;�������������
|21879;������
|1094;������
|21880;�������������
|21881;������
|1104;��������
|21882;�������������
|21883;������
|33;�����������
|21884;�������������
|21885;������
|39;������-��-����
|11053;�����
|971;��������
|238;������������
|11036;����������
|21886;�������������
|21887;������
|11043;�������-����������
|36;����������
|11067;���������
|11063;����������� ����
|11057;���������
|11062;����������
|21888;�������������
|21889;������
|11064;������������
|1106;�������
|21890;�������������
|21891;������
|2;�����-���������
|969;������
|10867;�������
|21892;�������������
|21893;������
|20;�����������
|10849;������������
|21894;�������������
|21895;������
|21;�������
|21896;�������������
|21897;������
|968;���������
|22;�����������
|21898;�������������
|21899;������
|10894;�������
|23;��������
|21900;�������������
|21901;������
|24;������� ��������
|21902;�������������
|21903;������
|25;�����
|10928;������� ����
|21904;�������������
|21905;������
|18;������������
|21906;�������������
|21907;������
|10937;���������
|19;���������
|10945;����
|21908;�������������
|21909;������
|4;��������
|10649;������ �����
|21910;�������������
|21911;������
|191;������
|21912;�������������
|21913;������
|192;��������
|10656;�����������
|10661;����-�����������
|10668;�����
|21914;�������������
|21915;������
|10664;������
|10671;�������
|193;�������
|21916;�������������
|21917;������
|5;�������
|21918;�������������
|21919;������
|6;������
|967;�������
|21920;�������������
|21921;������
|7;��������
|21922;�������������
|21923;������
|8;�����
|21924;�������������
|21925;������
|9;������
|21926;�������������
|21927;������
|10;����
|21928;�������������
|21929;������
|11;������
|21930;�������������
|21931;������
|12;��������
|21932;�������������
|21933;������
|13;������
|21934;�������������
|21935;������
|14;�����
|21936;�������������
|21937;������
|10820;����
|15;����
|21938;�������������
|21939;������
|10830;������������
|16;���������
|10839;�������
|10837;����������
|21940;�������������
|21941;������
|10838;������
|10840;�����
|95;������
|84;���
|20271;�������
|21942;�������������
|21943;������
|93;���������
|94;��������
|669;������
|670;�������������
|68;����
|21818;�������������
|21819;������
|157;�����
|26034;������
|101852;�������������
|101853;������
|155;������
|101854;�������������
|101855;������
|154;�������
|101856;�������������
|101857;������
|153;�����
|101858;�������������
|101859;������
|10274;������
|101860;�������������
|101861;������
|158;�������
|101862;�������������
|101863;������
|162;������
|10303;�����������
|102499;������
|102513;�������������
|164;���������
|102500;������
|102514;�������������
|163;������
|20809;��������
|102501;������
|102515;�������������
|165;�����
|10306;����-�����������
|102502;������
|102516;�������������
|190;��������
|102503;������
|102517;�������������
|102504;������
|102518;�������������
|102505;������
|102519;�������������
|102506;������
|102520;�������������
|221;�������
|102507;������
|102521;�������������
|20273;������
|102508;������
|102522;�������������
|102509;������
|102523;�������������
|102510;������
|102524;�������������
|102511;������
|102525;�������������
|102512;������
|102526;�������������
|143;����
|10369;����� �������
|101864;������
|101865;�������������
|21609;���������
|964;�������
|102450;������
|102475;�������������
|10363;��������
|102451;������
|102476;�������������
|963;�������
|102452;������
|102477;�������������
|20221;����������
|102453;������
|102478;�������������
|10343;�������
|102454;������
|102479;�������������
|147;�������
|102455;������
|102480;�������������
|142;������
|20554;����������
|10366;���������
|24876;��������
|102456;������
|102481;�������������
|141;��������������
|10347;������ ���
|102457;������
|102482;�������������
|222;�������
|102458;������
|102483;�������������
|960;���������
|10367;����������
|102459;������
|102484;�������������
|145;������
|102460;������
|102485;�������������
|148;��������
|102461;������
|102486;�������������
|962;������
|102462;������
|102487;�������������
|144;�����
|102464;������
|102489;�������������
|961;�����������
|102465;������
|102490;�������������
|10357;���������
|102466;������
|102491;�������������
|10355;�����
|102467;������
|102492;�������������
|10365;��������
|102468;������
|102493;�������������
|20222;����
|102469;������
|102494;�������������
|10358;�������
|102470;������
|102495;�������������
|10345;�����-���������
|102471;������
|102496;�������������
|965;����
|102472;������
|102497;�������������
|966;��������
|102473;������
|102498;�������������
|11010;���������� ��������
|11012;���������� ���������
|11013;���������� ���������-��������
|11021;���������� �������� ������-������
|11069;�������������� ����
|11020;���������-���������� ����������
|11024;��������� ����������
|102446;�������������
|102445;������ ������ �������
|977;����
HTML;

$datting_groups = <<<HTML
moya-anketa|||��� ������|
interesy|||��������|
ozhidaniya-ot-partnera|||�������� �� ��������|
HTML;

$datting_meetings_cat = <<<HTML
������� � ����;� ���� / ��������;������;���������� �� ������;��������;����� �� ��������;�� ���������� / ������;�������� �������;�������� �����������;��������� �� �������;������ �������;� �������� � ��������� ���������� ������
HTML;

$datting_pages = <<<HTML
profile_avtoportret|profile_avtoportret||�����������|
profile_anketa|profile_anketa||�����|
profile_photos|profile_photos||����|
profile_awards|profile_awards||�������|
profile_blogs|profile_blogs||��������|
profile_meetings|profile_meetings||�������|
profile_friends|profile_friends||������|
HTML;

$datting_profile = <<<HTML
0|celi_znakomstva|��� ���� ����������|������ � �������;���������;������� �� ���������;������, ���������;�������� �����;����;��������;����� �� ������|moya-anketa|checkbox
1|moe-semeynoe-polozhenie|��� �������� ���������|������ � �����;������ � �����, �� ����� ��������;������ � ����� ��� ����;�� ������ � �����;��� ������|moya-anketa|checkbox
2|moe-otnoshenie-k-materialnoy-podderzhke|��� ��������� � ������������ ���������|��� ��������;����� ���� ���������;�� ����� ���� ��������� � � �������� �� ��������|moya-anketa|checkbox
3|moe-materialnoe-polozhenie|��� ������������ ���������|������������ �����;���������� ��������� �����;���������� ������� �����;�������� �����������|moya-anketa|checkbox
4|est-li-u-menya-deti|���� �� � ���� ����|�� ����, ����� ������;�� ����, ����� ��������;���, �� �������� ��;��� � ���� �� ��������|moya-anketa|checkbox
5|moe-obrazovanie|��� �����������|�������;������ ������������;������;������ �������|moya-anketa|checkbox
6|kvartirnyy-vopros|���������� ������|���� � ��������������;������ ��������;����������� �����|moya-anketa|checkbox
7|moe-teloslozhenie|��� ������������|���������;�������;����������;�����������;�������;������;��� ������|moya-anketa|checkbox
8|moy-cvet-volos|��� ���� �����|�������;������;�����;������������;�����;�����;������ ������|moya-anketa|checkbox
9|moy-rezhim-dnya|��� ����� ���|� ����������;� �����|moya-anketa|checkbox
10|moya-professiya|��� ���������||moya-anketa|input
11|moya-gotovnost-k-treningam-na-proekte|��� ���������� � ��������� �� �������|�������� ��������;������� ������;���� �� ��������;�� �������� � �� ���������;�������� �������� � ������ ������|moya-anketa|checkbox
12|ya-gotov-okazat-pomosch-v-obuchenii|� ����� ������� ������ � ��������|����� ��������;��������� �� ��������;�� ����� ���� �����������|moya-anketa|checkbox
13|moy-rost|��� ����||moya-anketa|input
14|moy-ves|��� ���||moya-anketa|input
15|svobodniyden|��� ���� ������ � ��������� ����|����� ������;���� ������ ����;������ � �����������;�������� ������;����� �� �������;����� � ����;����� � �����;����� � �����;����� � ��������;����� � ������ ����;������� �������;������� �� ����������;������ � ���������|interesy|checkbox
16|zansportom|������� �������|���;��������;������;��������;���������;���������;������;����, ��������;��������� ��������;�������;��������� ������������;���������, ����|interesy|checkbox
17|intez|���� ��������||interesy|input
18|kurenie|��������� � �������|�� ���� ������;����;�����;������|interesy|checkbox
19|alkogol|��������� � ��������|�� ��� ������;��� � ��������� �������;����� ������|interesy|checkbox
20|narkotik|��������� � ����������|������� �� ��������;������������� �� �������;��������� �������;�������� ������;�������� �������;������;������������� �� NA;������|interesy|checkbox
21|vozbuzdaet|���� ����������|������ �����;������;������ ���� ����;���������� ��� �������;������;��������;������;�����;�����;����;������, ������;������;�����������;������������ � �������|interesy|checkbox
22|razmergrudi|������ �����||interesy|input
23|orientacia|����������|������;��;|interesy|checkbox
24|ishu|������������ �|������;��������;����� �+�;����� �+�;����� �+�|ozhidaniya-ot-partnera|checkbox|��������! ���� �� �� �������� ���� �� ����������, �� ���� ������ ����� �� ������ ����� � ������.
25|vozrast_ot|������� ��||ozhidaniya-ot-partnera|input
26|vozrast_do|������� ��||ozhidaniya-ot-partnera|input
27|ti_celi_znakomstva1|���� ����������|������ � �������;���������;������� �� ���������;������, ���������;�������� �����;����;��������;����� �� ������|ozhidaniya-ot-partnera|checkbox
28|ti_brak|�������� ���������|������ � �����;������ � �����, �� ����� ��������;������ � ����� ��� ����;�� ������ � �����;��� ������|ozhidaniya-ot-partnera|checkbox
29|ti_deti|����|�� ����, ����� ������;�� ����, ����� ��������;���, �� �������� ��;��� � ���� �� ��������|ozhidaniya-ot-partnera|checkbox
30|ti_ozhidaniya|������ �������� �� ��������||ozhidaniya-ot-partnera|input
31|ti_sponsor|�����������, ��� ���� ��������� � ����������|��� ��������;����� ���� ���������;�� ����� ���� ��������� � � �������� �� ��������|ozhidaniya-ot-partnera|checkbox
32|ti_telo|��� �� ��������, ����� � ����� ������ ���� ������� ������������|���������;�������;����������;�����������;�������;������;��� ������|ozhidaniya-ot-partnera|checkbox
33|ti_training|���������, ����� ��|�������� ��������;������� ������;���� �� ��������;�� �������� � �� ���������;�������� �������� � ������ ������|ozhidaniya-ot-partnera|checkbox
34|ti_pomosh|�������, �� ������ �������� ��� � �������� ��������� �������|����� ��������;��������� �� ��������;�� ����� ���� �����������|ozhidaniya-ot-partnera|checkbox
35|ti_svobodnoevrema|���� ���, ���� �� ��������� ����� ���������|����� ������;���� ������ ����;������ � �����������;�������� ������;����� �� �������;����� � ����;����� � �����;����� � �����;����� � ��������;����� � ������ ����;������� �������;������� �� ����������;������ � ���������|ozhidaniya-ot-partnera|checkbox
36|simvcen|������ ������� ������������� ��������|�������;����;���������������;������;����������;����|testcennost|checkbox
37|ssimvcen|������ ������� ������������� ��������|�������;����;���������������;������;����������;����|testcennost|checkbox
HTML;

$edit_banki = <<<HTML
summa|����� ����� ������ �����?||text|0|0|creditcard
summa|����� ����� ������ �����?||text|0|0|creditipoteka
summa|����� ����� ������ �����?||text|0|0|creditpotrebit
summa|����� ����� ������ �����?||text|0|0|creditauto
valuta|������|RUB;USD;EUR|select|0|0|creditcard
doxod|��� �� ������ ����������� �����?|���������� ����-2;�� ������� �����;�����|select|0|0|creditcard
info_celi|���������� � ������� � ����� �������||textarea|0|0|creditcard
valuta|������|RUB;USD;EUR|select|0|0|creditipoteka
doxod|��� �� ������ ����������� �����?|���������� ����-2;�� ������� �����;�����|select|0|0|creditipoteka
info_celi|���������� � ������� � ����� �������||textarea|0|0|creditipoteka
valuta|������|RUB;USD;EUR|select|0|0|creditpotrebit
doxod|��� �� ������ ����������� �����?|���������� ����-2;�� ������� �����;�����|select|0|0|creditpotrebit
info_celi|���������� � ������� � ����� �������||textarea|0|0|creditpotrebit
valuta|������|RUB;USD;EUR|select|0|0|creditauto
doxod|��� �� ������ ����������� �����?|���������� ����-2;�� ������� �����;�����|select|0|0|creditauto
info_celi|���������� � ������� � ����� �������||textarea|0|0|creditauto
fio|���||text|0|name|creditcard
pass_seria|������� �����||text|0|name|creditcard
pass_nomer|������� �����||text|0|name|creditcard
pass_vidan|������� �����||text|0|name|creditcard
pass_data|���� ������ ��������||text|0|name|creditcard
telefon|�������||text|0|name|creditcard
email|Email||text|0|name|creditcard
skolko_let|������� ��� ���?||text|0|name|creditcard
sem_pol|�������� ���������|������/�� �������;�����/�������;������/�����;��������/���������|select|0|name|creditcard
col_det|���������� ������������������ �����*|���;����;���;���;����� ����|select|0|name|creditcard
srokraboti|������� �� ��������� �� ��������� �����?*|�� 3 �������;�� 6 �������; �� 2 ���;����� 2 ���|select|0|name|creditcard
stashrab|��� ����� �������� ����?*|�� 2 ���;����� 2 ���|select|0|name|creditcard
dd|��� �������������� �����, ���.*||text|0|name|creditcard
rasx|������������ ����������� �������, ���*||text|0|name|creditcard
kredsum|����� ����������� �������� �� ������ ��������, ���||text|0|name|creditcard
propiska|��� �� ���������?|������������;� �������� 100 �� �� ������;������������ �������;������;���������|select|0|name|creditcard
fio|���||text|0|name|creditipoteka
pass_seria|������� �����||text|0|name|creditipoteka
pass_nomer|������� �����||text|0|name|creditipoteka
pass_vidan|������� �����||text|0|name|creditipoteka
pass_data|���� ������ ��������||text|0|name|creditipoteka
telefon|�������||text|0|name|creditipoteka
email|Email||text|0|name|creditipoteka
skolko_let|������� ��� ���?||text|0|name|creditipoteka
sem_pol|�������� ���������|������/�� �������;�����/�������;������/�����;��������/���������|select|0|name|creditipoteka
col_det|���������� ������������������ �����*|���;����;���;���;����� ����|select|0|name|creditipoteka
srokraboti|������� �� ��������� �� ��������� �����?*|�� 3 �������;�� 6 �������; �� 2 ���;����� 2 ���|select|0|name|creditipoteka
stashrab|��� ����� �������� ����?*|�� 2 ���;����� 2 ���|select|0|name|creditipoteka
dd|��� �������������� �����, ���.*||text|0|name|creditipoteka
rasx|������������ ����������� �������, ���*||text|0|name|creditipoteka
kredsum|����� ����������� �������� �� ������ ��������, ���||text|0|name|creditipoteka
propiska|��� �� ���������?|������������;� �������� 100 �� �� ������;������������ �������;������;���������|select|0|name|creditipoteka
fio|���||text|0|name|creditpotrebit
pass_seria|������� �����||text|0|name|creditpotrebit
pass_nomer|������� �����||text|0|name|creditpotrebit
pass_vidan|������� �����||text|0|name|creditpotrebit
pass_data|���� ������ ��������||text|0|name|creditpotrebit
telefon|�������||text|0|name|creditpotrebit
email|Email||text|0|name|creditpotrebit
skolko_let|������� ��� ���?||text|0|name|creditpotrebit
sem_pol|�������� ���������|������/�� �������;�����/�������;������/�����;��������/���������|select|0|name|creditpotrebit
col_det|���������� ������������������ �����*|���;����;���;���;����� ����|select|0|name|creditpotrebit
srokraboti|������� �� ��������� �� ��������� �����?*|�� 3 �������;�� 6 �������; �� 2 ���;����� 2 ���|select|0|name|creditpotrebit
stashrab|��� ����� �������� ����?*|�� 2 ���;����� 2 ���|select|0|name|creditpotrebit
dd|��� �������������� �����, ���.*||text|0|name|creditpotrebit
rasx|������������ ����������� �������, ���*||text|0|name|creditpotrebit
kredsum|����� ����������� �������� �� ������ ��������, ���||text|0|name|creditpotrebit
propiska|��� �� ���������?|������������;� �������� 100 �� �� ������;������������ �������;������;���������|select|0|name|creditpotrebit
fio|���||text|0|name|creditauto
pass_seria|������� �����||text|0|name|creditauto
pass_nomer|������� �����||text|0|name|creditauto
pass_vidan|������� �����||text|0|name|creditauto
pass_data|���� ������ ��������||text|0|name|creditauto
telefon|�������||text|0|name|creditauto
email|Email||text|0|name|creditauto
skolko_let|������� ��� ���?||text|0|name|creditauto
sem_pol|�������� ���������|������/�� �������;�����/�������;������/�����;��������/���������|select|0|name|creditauto
col_det|���������� ������������������ �����*|���;����;���;���;����� ����|select|0|name|creditauto
srokraboti|������� �� ��������� �� ��������� �����?*|�� 3 �������;�� 6 �������; �� 2 ���;����� 2 ���|select|0|name|creditauto
stashrab|��� ����� �������� ����?*|�� 2 ���;����� 2 ���|select|0|name|creditauto
dd|��� �������������� �����, ���.*||text|0|name|creditauto
rasx|������������ ����������� �������, ���*||text|0|name|creditauto
kredsum|����� ����������� �������� �� ������ ��������, ���||text|0|name|creditauto
propiska|��� �� ���������?|������������;� �������� 100 �� �� ������;������������ �������;������;���������|select|0|name|creditauto
srok_kred|�� ����� ����?*|1-5 ���;5-10 ���;10-20 ���;20-30 ���;|select|0|0|creditipoteka
srok_kred|�� ����� ����?*|3-6 �������;6-12 �������;1-2 ����;2-5 ���;|select|0|0|creditauto
srok_kred|�� ����� ����?*|3-6 �������;6-12 �������;1-2 ����;2-5 ���;|select|0|0|creditpotrebit
obespech|��� �� ������ ���������� ������?*|�����;����������;����� �� �����|select|0|0|creditipoteka
obespech|��� �� ������ ���������� ������?*|�����;����������;����� �� �����|select|0|0|creditauto
obespech|��� �� ������ ���������� ������?*|�����;����������;����� �� �����|select|0|0|creditpotrebit
trebovaniya|���� ���������� � �������|����������� ���������� ���������;���������� ����������� ��������|select|0|0|creditipoteka
trebovaniya|���� ���������� � �������|����������� ���������� ���������;���������� ����������� ��������|select|0|0|creditauto
trebovaniya|���� ���������� � �������|����������� ���������� ���������;���������� ����������� ��������|select|0|0|creditpotrebit
HTML;

$edit_event = <<<HTML
birthdate|�����|00:00;00:05;00:10;00:15;14:50;15:35;16:35;17:15;18:00;19:00;19:40;20:25;21:25;22:05;22:50|dbbirthdate|0||kino
zhanr|����||text|0|0|kino
rezh|��������||text|0|0|kino
vrolax|� �����||text|0|0|kino
zhan|����||text|0|0|theatre
zhan_c|����||text|0|0|clubs
HTML;

$edit_obj = <<<HTML
t14|��� ����������|������;�����;�������|select|1|0|auto
t2|��� ����������|������;�����;����;�����|select|1|0|nedv
formoplati|����� ������|�����;�����;�����+%;%;������;���������;��������;������|select|0|0|vacations
tiprab|��� ������|�����;����������;�� ����������������;���������|select|1|0|vacations
graphrab|������ ������|�����;������ ������� ����;�� ������ ������� ����;���������;��������|select|1|0|vacations
usl|�������||textarea|1|0|vacations
treb|����������||textarea|0|0|vacations
obaz|�����������||textarea|1|0|vacations
aboutcomp|� ��������||textarea|1|0|vacations
obrazie|�����������|������;������������ ������;�������;������������ �������;������� �����������;������|select|1|0|vacations
stag|���� �� (���)||text|1|0|vacations
znanyaz|������ ������||textarea|0|0|vacations
znankomp|������ ����������||textarea|1|0|vacations
bizob|������-�����������||textarea|1|0|vacations
pol|���|�������;�������;�����|select|1|0|vacations
uczav|������� ���������||text|1|0|rezume
stah|���� �� (���)||text|1|0|rezume
tiprazb|��� ������|�����;����������;�� ����������������;���������|select|1|0|rezume
predrab|����� ���������� ������||textarea|1|0|rezume
graphrzab|������ ������|�����;������ ������� ����;�� ������ ������� ����;���������;��������|select|1|0|rezume
obrazie|�����������|������;������������ ������;�������;������������ �������;������� �����������;������|select|1|0|rezume
znaniyaz|������ ������||textarea|1|0|rezume
znankompi|������ ����������||textarea|1|0|rezume
biziob|������-�����������||textarea|1|0|rezume
dopsved|�������������� ��������||textarea|1|0|rezume
vazhnost|��������|���;������;�� ���� ������;������ �������, �� ���������� ������� ����� �����������|select|1|0|rezume
poil|���|�������;�������|select|1|0|rezume
vozrast|�������||text|1|0|rezume
t12|������� �������|������������;�������;��������;���������;����������������|select|1|0|auto
t11|��� ���������|������ ��������;������ ����������;������ �����;������ �����������;������ ����������;������;������ �����������;���������|select|1|0|auto
t9|���������|��������;�������;�����;�������|select|1|0|auto
t15|������|��������;������;������|select|1|0|auto
t4|���||text|1|0|auto
t5|������ (��)||text|1|0|auto
t6|����||text|1|0|auto
t7|����� ��������� (��3)||text|1|0|auto
t8|�������� (�.�)||text|1|0|auto
t10|�����|�����;�������;���������;�����������;����;�������;������������;�����;���������|select|1|0|auto
t13|����|�����;������|select|1|0|auto
t11|���������� ������|1;2;3;4;5;6|select|1|0|nedv
t10|����� �������|0.0|text|1|0|nedv
full_area|����� �������||text|1|0|nedv
t1|����||text|1|0|nedv
t12|����� ������||text|1|0|nedv
t13|����� ����||text|0|0|nedv
t5|�����||text|0|0|nedv
t11|��������|�����;������;����;������|select|1|0|zagor
full_area|������� ���� (�.��)|0.0|text|1|0|zagor
t10|������� ������� (���)||text|1|0|zagor
t1|����||text|1|0|zagor
t12|���-�� ������||text|1|0|zagor
t5|���������� �����||text|1|0|zagor
t13|���������� �� ����������� ������ (��)||text|1|0|zagor
t11|������������|� ������-������;� ����, ������;� �������� ���������;�� ������������ ����������;��������� ������|select|1|0|comm
full_area|������� (�.��)|0.0|text|1|0|comm
t9|��������� ����|��, � �����;��, �� �����;���|select|1|0|comm
t1|����||text|1|0|comm
t5|�����||text|0|0|comm
t13|����� ����||text|1|0|comm
klovokomn|���������� ������||text|1|0|objectnedv
materioal|��������|�������������;�����������;�����;������;����;������|select|1|0|objectnedv
sroksdac|���� �����||text|1|0|objectnedv
t11|���������� ������|1;2;3;4;5;6|select|1|0|predlnovo
t1|����||text|1|0|predlnovo
t12|���-�� ������||text|1|0|predlnovo
t10|����� �������|0.0|text|1|0|predlnovo
full_area|����� �������||text|1|0|predlnovo
t2|�������||text|1|0|predlnovo
t3|�������||text|1|0|predlnovo
t10|����� �������|0.0|text|1|0|predlkot
full_area|����� �������||text|1|0|predlkot
t2|���������||text|1|0|predlkot
t3|�������||text|1|0|predlkot
t10|������� ������� (���)||text|1|0|zemuch
t13|���������� �� ����������� ������ (��)||text|1|0|zemuch
t5|���������� �����||text|1|0|zemuch
kratkopis|������� ��������*||textarea|0|0|tenders
srconec|���� ��������� ������ ������ (� ������� ��.��.����)*||text|0|0|tenders
sotr|������������� ��������������� ��������������|��;���|select|0|0|tenders
uczav|������� ���������||text|1|0|beauraut
stah|���� �� (���)||text|1|0|beauraut
tiprazb|��� ������|�����;����������;�� ����������������;���������|select|1|0|beauraut
predrab|����� ���������� ������||textarea|1|0|beauraut
graphrzab|������ ������|�����;������ ������� ����;�� ������ ������� ����;���������;��������|select|1|0|beauraut
obrazie|�����������|������;������������ ������;�������;������������ �������;������� �����������;������|select|1|0|beauraut
znaniyaz|������ ������||textarea|1|0|beauraut
znankompi|������ ����������||textarea|1|0|beauraut
biziob|������-�����������||textarea|1|0|beauraut
dopsved|�������������� ��������||textarea|1|0|beauraut
vazhnost|��������|���;������;�� ����� ������;������ �������, �� ���������� ������� ����� �����������|select|1|0|beauraut
poil|���|�������;�������|select|1|0|beauraut
vozrast|�������||text|1|0|beauraut
HTML;

$edit_profile = <<<HTML
fullname|������� ��� ��������||text|1|1|basic|1|0
sex|���|�������;�������|select|1|0|basic|0|1
datting|���������� � ������|��;���|select|1|1|basic|1|0
polsex|�������� ���������|�����;�������;�� �����;�� �������;���� �������;���� ����;� �������� ������;���������;����������;��� ������|select|1|0|basic|0|1
vzgladi|������������ �������|�������������;��������������;����������������;���������;�����������|select|1|0|basic
city|������ �����||dbcity|1|0|basic|1|0
mob_phone|��������� �������||text|1|0|contakti|1|0
dom_phone|�������� �������||text|1|0|contakti
icq|ICQ||text|1|0|contakti
birthdate|���� ��������||dbbirthdate|1|0|basic|0|1
webs|������ ����||text|1|0|contakti|0|1
email|���������� Email||text|1|0|contakti|1|0
info|� ����||textarea|1|0|lichn
deyatelnost|������������||dbconnect|1|0|lichn
interests|��������||dbconnect|1|0|lichn
style|������� ����������� �����||text|1|0|lichn
ishu|���������||dbconnect|1|0|basic|0|1
HTML;

$raspisanie = <<<HTML
tiraspol|35|0|text|0|0|basic
ribnitsa|2|0|text|0|0|basic
dubosari|39|0|text|0|0|basic
yekaterinburg|54|1|text|0|0|basic
|213|1|text|0|0|basic
HTML;

$user_edit_pages = <<<HTML
basic|basic||��������|
lichn|lichn||������|
contakti|contakti||��������|
photo|photo||����|
HTML;

$xfirm = <<<HTML
coocie|�����|1153|select|1|1|���������__NEWL__��������__NEWL__������������
vmestimost|�����������|1153|text|1|1|
HTML;

$xprofile = <<<HTML
t2|���� �����������|0|text|1|0
t3|������� - ���...|0|text|1|0
t4|����� ������������� �������� � ����� �����|0|text|1|0
t6|��� ��� ��� ������ ��������� � ����� �� ���|0|text|1|0
t7|����� �������� �� ������ � �����|0|text|1|0
t8|��� �� ����� �� ��������, � ��� ���|0|text|1|0
t9|���� �� � ��� ������� ������������/���� �����|0|text|1|0
t10|���� �� ���, ��� ��������� � �����|0|text|1|0
t11|����� ���� �� ������� ������ ����� �����|0|text|1|0
t12|��� �� �� ������ ����������|0|text|1|0
t13|��� �� �������� ����|0|text|1|0
t14|���� ������� ����� � ������ ������|0|text|1|0
t15|���� �� � ��� �������� ��������|0|text|1|0
t16|����� ������/������ ��� ����������|0|text|1|0
t17|��� ��� ��� �����������|0|text|1|0
t18|������ �� �� ����� �����?|0|text|1|0
t19|��� ������� �����|0|text|1|0
t20|���� ������� �������|0|text|1|0
t21|��� ��� �� �������� � �����|0|text|1|0
t22|��� ������� ����������|0|text|1|0
HTML;

$xprofile = <<<HTML
t2|���� �����������|0|text|1|0
t3|������� - ���...|0|text|1|0
t4|����� ������������� �������� � ����� �����|0|text|1|0
t6|��� ��� ��� ������ ��������� � ����� �� ���|0|text|1|0
t7|����� �������� �� ������ � �����|0|text|1|0
t8|��� �� ����� �� ��������, � ��� ���|0|text|1|0
t9|���� �� � ��� ������� ������������/���� �����|0|text|1|0
t10|���� �� ���, ��� ��������� � �����|0|text|1|0
t11|����� ���� �� ������� ������ ����� �����|0|text|1|0
t12|��� �� �� ������ ����������|0|text|1|0
t13|��� �� �������� ����|0|text|1|0
t14|���� ������� ����� � ������ ������|0|text|1|0
t15|���� �� � ��� �������� ��������|0|text|1|0
t16|����� ������/������ ��� ����������|0|text|1|0
t17|��� ��� ��� �����������|0|text|1|0
t18|������ �� �� ����� �����?|0|text|1|0
t19|��� ������� �����|0|text|1|0
t20|���� ������� �������|0|text|1|0
t21|��� ��� �� �������� � �����|0|text|1|0
t22|��� ������� ����������|0|text|1|0
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
name|��������� �������|
edit_about|����������� �������������� ����� ������|
edit_maps|���������� �� ����� ������|
edit_skidnews|���������� ����� � �������� ����� ��������|
col_rubrik|���������� ������ ���������� � �����������|
edit_photo|���������� ���������� (��������, ���������)|
edit_vak|���������� ���������� � ��������|
col_tov|���������� �������|
edit_price|���������� �����-������, ������������|
edit_prior|������������ ������������ � �����������|
edit_www|���������� ����� � ���������|
edit_banner|������ � ������� �� ������ ����� ����������|
edit_bronir|������������� �������� �����������|
price|��������� ������ �� ���|
HTML;

$sms_pages = <<<HTML
sms_anketa|sms_anketa||�������� ������|
sms_datting_poisk|sms_datting_poisk||������� ������|
sms_livestatus|sms_livestatus||Live ������|
sms_hochuobsh|sms_hochuobsh||����� �������|
addpodarok|addpodarok||��������� �������|
sms_buyobj|sms_buyobj/3/||�������� ����������|
sms_delfoto|sms_delfoto||������� ���� ���������� � �������������|
my_orders|my_orders||������������ �����|
HTML;

$block_banners_config = <<<HTML
<?php
\$config['advert_zaglushka'] = '<div style="background-color:#fff;border:1px solid #9e9e9e;text-align:center;width:100%;height:100px;vertical-align:middle;text-transform:lowercase;position:relative;"><div style="margin-top: 30px;    text-align: center!important;"><b>��������� �����</b><br><a href="/advert/">������</a></div><div style="position:absolute;width:50px;height:100px;background-color:#cccccc12;right:0px;top:0px;background-image: url(/templates/66-new/img/logo.png);background-repeat: no-repeat;background-position: center;"></div></div>';
\$config['advert_title'] = "���������� �������";
\$config['advert_descrip'] = "���������� ������� �� ������� ";
\$config['advert_ke'] = "���������� �������, ������� �� �������, ���������� �� ������� , ���������� �� ������� ����� ������� ��������� ������";
\$config['online_pay'] = "1";
\$config['advert_about'] = "������� ��������� ������ �������� � ���� 2015 ����. � ��� ��� ���������� ����������� ��������� � ������� �� ����� ������ .
<p>
�� ������������� ����� �������� � �������������� �������������� �������: ��������, �������, �������, ������, �������������� ������ ������� ����������, ��������, �����, �������, �����������, ������, �����, �����, ������ �������� � ������ ������.</p>";
\$config['advert_politics'] = "��� ������ � ����������� �������� ����������� ������ ������� ����� ��������. ����� ����� ������������� ����������� ������� ���� ������� ���������
<p>
�� ��������� ������ ����� ����������� ������� ������� � ������ ������ ����������� �������� �������������� ���������� ��� ������� ����������. � ���� ������ �������� �� ��������� ����������� � ������������� � �������� �������� �������.</p>";
\$config['advert_aferta'] = "<ul>
<li><i class=\"list-marker\"></i>���� ������� � ������ ���� �������. ��� �� ������������.</li>
<li><i class=\"list-marker\"></i>� ������ ������ ���������� �� ���������� ����������:<br>
1. ����� ��� �� 5 (����) ������� ���� �� ���� ���������� ���������� - ��������� ��������� � ������� 30% �� ��������� ����������.<br>
2. � �������� �������� ����� - ��������� ��������� � ������� 100% �� ��������� ������������� �������.</li>
<li><i class=\"list-marker\"></i>���� �������������� ������� - �� ����� ��� �� ��� ������� ��� �� ��������� ��� � ����� �������.</li><p></p>
<li><i class=\"list-marker\"></i>�� ��������� �� ����� ����� ������ �� ������ ����� ��� ���������� ������.</li>
</ul>";
\$config['advert_warn'] = "���������� ����������� ���������� � ��������, �������� �������� ��������� ������ ��� ������ �������.";
\$config['advert_call'] = "<b>��������� ���,</b>� �� � ������������� ������� �� ��� ���� ������� � ��������� �������";
\$config['advert_count'] = "147036";
\$config['advert_pay'] = "<div id=\"systems\">
<div class=\"paysystem\"><a href=\"#\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_cardvmc.gif\" title=\"Visa, Mastercard\" alt=\"\" border=\"0\"></a> <a href=\"http://www.webmoney.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_webmoney.gif\" title=\"WebMoney\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"https://liqpay.com/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_liqpay.gif\" title=\"LiqPay\" alt=\"\" border=\"0\"></a> <a href=\"http://www.w1.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_w1.gif\" title=\"������ �������\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"http://www.privat24.ua/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_privat24.gif\" title=\"Privat24\" alt=\"\" border=\"0\"></a> <a href=\"http://smartpay.com.ua/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_nsmep.gif\" title=\"�����\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"https://www.moneymail.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_moneymail.gif\" title=\"MoneyMail\" alt=\"\" border=\"0\"></a> <a href=\"https://rbkmoney.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_rbkmoney.gif\" title=\"RBK Money\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"http://www.webcreds.com/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_webcreds.gif\" title=\"WebCreds\" alt=\"\" border=\"0\"></a> <a href=\"http://www.ukash.com/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_ukash.gif\" title=\"Ukash\" alt=\"\" border=\"0\"></a><br></div>
<div class=\"paysystem\"><a href=\"http://www.sbrf.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_sberbankrf.gif\" title=\"�������� ��\" alt=\"\" border=\"0\"></a> <a href=\"http://www.russianpost.ru/\" target=\"_blank\"><img src=\"/templates/66-new/img/koshelek/logo_ruspost.gif\" title=\"����� ������\" alt=\"\" border=\"0\"></a><br></div>
			</div>";
?>
HTML;

$con_file = fopen(ENGINE_DIR."/data/firm_tarifs.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/firm_tarifs.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $firm_tarifs);
fclose($con_file);
@chmod(ENGINE_DIR."/data/firm_tarifs.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/sms_pages.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/sms_pages.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $sms_pages);
fclose($con_file);
@chmod(ENGINE_DIR."/data/sms_pages.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/citys_curs.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/citys_curs.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $citys_curs);
fclose($con_file);
@chmod(ENGINE_DIR."/data/citys_curs.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/citys_raspisanie.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/citys_raspisanie.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $citys_raspisanie);
fclose($con_file);
@chmod(ENGINE_DIR."/data/citys_raspisanie.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_groups.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/datting_groups.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $datting_groups);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_groups.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_meetings_cat.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/datting_meetings_cat.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $datting_meetings_cat);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_meetings_cat.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_pages.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/datting_pages.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $datting_pages);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_pages.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_profile.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/datting_profile.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $datting_profile);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_profile.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_banki.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/edit_banki.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $edit_banki);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_banki.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_cart.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/edit_cart.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, "");
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_cart.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_event.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/edit_event.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $edit_event);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_event.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_obj.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/edit_obj.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $edit_obj);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_obj.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/edit_profile.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/edit_profile.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $edit_profile);
fclose($con_file);
@chmod(ENGINE_DIR."/data/edit_profile.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/raspisanie.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/raspisanie.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $raspisanie);
fclose($con_file);
@chmod(ENGINE_DIR."/data/raspisanie.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/user_edit_pages.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/user_edit_pages.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $user_edit_pages);
fclose($con_file);
@chmod(ENGINE_DIR."/data/user_edit_pages.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/xfields.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/xfields.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, "");
fclose($con_file);
@chmod(ENGINE_DIR."/data/xfields.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/xfirm.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/xfirm.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $xfirm);
fclose($con_file);
@chmod(ENGINE_DIR."/data/xfirm.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/xprofile.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/xprofile.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $xprofile);
fclose($con_file);
@chmod(ENGINE_DIR."/data/xprofile.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_curs.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config_curs.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_curs);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_curs.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.rambler.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/import.rambler.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $importrambler);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.rambler.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.yt.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/import.yt.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $importyt);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.yt.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/rss_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/rss_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $rssfull);
fclose($con_file);
@chmod(ENGINE_DIR."/data/rss_config.php", 0666);

//////////////////////////////////////////////////////////

$con_file = fopen(ENGINE_DIR."/data/profile_pages.txt", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/profile_pages.txt</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $profile_pages);
fclose($con_file);
@chmod(ENGINE_DIR."/data/profile_pages.txt", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_weather.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config_weather.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $dbconfig3);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_weather.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/arcade_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/arcade_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $arcade_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/arcade_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/arcconfig.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/arcconfig.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $arcconfig);
fclose($con_file);
@chmod(ENGINE_DIR."/data/arcconfig.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_adv_content_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_adv_content_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_adv_content_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_adv_content_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_allnews_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_allnews_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_allnews_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_allnews_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_advm_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_advm_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_advm_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_advm_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_afisha_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_afisha_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_afisha_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_afisha_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_auth.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_auth.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_auth);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_auth.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_banners_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_banners_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_banners_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_banners_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_blogs_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_blogs_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_blogs_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_blogs_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_bobrazovanie_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_bobrazovanie_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_bobrazovanie_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_bobrazovanie_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_buro_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_buro_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_buro_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_buro_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_dblock_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_dblock_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_dblock_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_dblock_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_doblock_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_doblock_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_doblock_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_doblock_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_eda_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_eda_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_eda_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_eda_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_exclusive_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_exclusive_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_exclusive_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_exclusive_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_galeryusers_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_galeryusers_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_galeryusers_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_galeryusers_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_gpblock_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_gpblock_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_gpblock_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_gpblock_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_inter_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_inter_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_inter_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_inter_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_internet_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_internet_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_internet_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_internet_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_interview_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_interview_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_interview_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_interview_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_lastobj_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_lastobj_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_lastobj_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_lastobj_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_lastuser_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_lastuser_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_lastuser_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_lastuser_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_mesta_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_mesta_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_mesta_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_mesta_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_nedvblock_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_nedvblock_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_nedvblock_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_nedvblock_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_otdix_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_otdix_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_otdix_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_otdix_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_resizef_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_resizef_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_resizef_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_resizef_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_spravka_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_spravka_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_spravka_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_spravka_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_statistics_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_statistics_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_statistics_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_statistics_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/block_tender_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/block_tender_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $block_tender_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/block_tender_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.autocat.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config.autocat.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_autocat);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.autocat.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.awards.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config.awards.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_awards);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.awards.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.hotels.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config.hotels.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_hotels);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.hotels.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.mebel.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config.mebel.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_mebel);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.mebel.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.mustcomm.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config.mustcomm.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_mustcomm);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.mustcomm.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.pharmacy.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config.pharmacy.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_pharmacy);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.pharmacy.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config.srd.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config.srd.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_srd);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config.srd.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_music.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config_music.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_music);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_music.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_photo_pay.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config_photo_pay.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_photo_pay);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_photo_pay.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_pkinopoisk.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config_pkinopoisk.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_pkinopoisk);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_pkinopoisk.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/config_vip.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/config_vip.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $config_vip);
fclose($con_file);
@chmod(ENGINE_DIR."/data/config_vip.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/datting_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/datting_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $datting_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/datting_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/files_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/files_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $files_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/files_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/forum_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/forum_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $forum_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/forum_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/fotoalbum.config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/fotoalbum.config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $fotoalbum_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fotoalbum.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/garage_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/garage_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $garage_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/garage_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.auto.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/import.auto.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $import_auto);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.auto.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.kinoafisha.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/import.kinoafisha.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $import_kinoafisha);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.kinoafisha.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.market.nedv.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/import.market.nedv.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $import_market_nedv);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.market.nedv.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.nedv.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/import.nedv.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $import_nedv);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.nedv.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/import.work.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/import.work.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $import_work);
fclose($con_file);
@chmod(ENGINE_DIR."/data/import.work.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/invite.conf.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/invite.conf.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $invite_conf);
fclose($con_file);
@chmod(ENGINE_DIR."/data/invite.conf.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/lclubs_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/lclubs_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $lclubs_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/lclubs_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/market_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/market_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $market_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/market_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/referer.conf.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/referer.conf.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $referer_conf);
fclose($con_file);
@chmod(ENGINE_DIR."/data/referer.conf.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/referer.perf.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/referer.perf.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $referer_perf);
fclose($con_file);
@chmod(ENGINE_DIR."/data/referer.perf.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/tagconfig.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/tagconfig.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $tagconfig);
fclose($con_file);
@chmod(ENGINE_DIR."/data/tagconfig.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/user_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/user_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $user_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/user_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/video_config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/video_config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $video_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/video_config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/wap.config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/wap.config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $wap_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/wap.config.php", 0666);

/// �� ������ 9.0 ///

$market_config = <<<HTML
<?PHP

\$MarketConfig = array (
	"key" => "829e496af0169846e1b3a9466da0351a7ae1f4b3878588291a99c2d12518dfdb0",
	"on" => "yes",
	"field_on" => "on",
	"cache" => "yes",
	"main_title" => "������� �������",
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
	"main_title" => "������",
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
	"main_title" => "����� �������� � ������� � �������",
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
//������������ ������ ��������
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

$con_file = fopen(ENGINE_DIR."/data/market.config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/market.config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $market_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/market.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/pharmacy.config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/pharmacy.config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $pharmacy_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/pharmacy.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/skidki.config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/skidki.config.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $skidki_config);
fclose($con_file);
@chmod(ENGINE_DIR."/data/skidki.config.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/objects.config.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/objects.config.php</b>.<br />��������� ������������ �������������� CHMOD!");
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

$con_file = fopen(ENGINE_DIR."/data/tpl.market.email.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/tpl.market.email.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $tpl_memail);
fclose($con_file);
@chmod(ENGINE_DIR."/data/tpl.market.email.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/tpl.skidki.email.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/tpl.skidki.email.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $tpl_semail);
fclose($con_file);
@chmod(ENGINE_DIR."/data/tpl.skidki.email.php", 0666);

$con_file = fopen(ENGINE_DIR."/data/tpl.pharmacy.email.php", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/tpl.pharmacy.email.php</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $tpl_pemail);
fclose($con_file);
@chmod(ENGINE_DIR."/data/tpl.pharmacy.email.php", 0666);

$tpl_xfm = <<<HTML
1|||ulica|||��������|||0|||0|||0|||all|||all|||1|||1|||0|||1|||mini_text||||||329|||value@#!!!#@##-@-##width@#!!!#@497
2|||dom|||��������|||0|||0|||0|||all|||all|||1|||1|||0|||2|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
6|||chasy-raboty|||������ �� �����|||0|||0|||1|||all|||all|||1|||1|||0|||6|||text||||||all|||value@#!!!#@##-@-##width@#!!!#@497##-@-##height@#!!!#@70
7|||fyvfyv|||���|||0|||0|||0|||all|||all|||0|||1|||0|||7|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
8|||121221|||������|||1|||0|||0|||all|||all|||0|||1|||0|||8|||checkbox||||||326|||value@#!!!#@�����&278&������&278&��� ����##-@-##show@#!!!#@
HTML;

$tpl_xfs = <<<HTML
1|||skidka|||������|||0|||0|||0|||all|||all|||1|||1|||0|||1|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@497
2|||srok_do|||��������� ��|||0|||0|||0|||all|||all|||1|||1|||0|||2|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
HTML;

$tpl_zast = <<<HTML
11|||adres|||�����|||0|||0|||0|||all|||all|||0|||1|||0|||11|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
12|||zastroyschik|||����������|||0|||0|||0|||all|||all|||0|||1|||0|||12|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
13|||koordinaty-lat|||���������� lat|||0|||0|||0|||all|||all|||0|||1|||0|||13|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
14|||koordinaty-lng|||���������� lng|||0|||0|||0|||all|||all|||0|||1|||0|||14|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
15|||kolichestvo-komnat|||���������� ������|||0|||0|||0|||all|||all|||0|||1|||0|||15|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
16|||ploschad|||�������|||0|||0|||0|||all|||all|||0|||1|||0|||16|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
17|||etazh|||����|||0|||0|||0|||all|||all|||0|||1|||0|||17|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
18|||sayt|||����|||0|||0|||0|||all|||all|||0|||1|||0|||18|||mini_text||||||all|||value@#!!!#@##-@-##width@#!!!#@100
HTML;

$tpl_xfp = <<<HTML
HTML;

$con_file = fopen(ENGINE_DIR."/data/fields.market.db", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/fields.market.db</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $tpl_xfm);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fields.market.db", 0666);

$con_file = fopen(ENGINE_DIR."/data/fields.skidki.db", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/fields.skidki.db</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $tpl_xfs);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fields.skidki.db", 0666);

$con_file = fopen(ENGINE_DIR."/data/fields.pharmacy.db", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/fields.pharmacy.db</b>.<br />��������� ������������ �������������� CHMOD!");
fwrite($con_file, $tpl_xfp);
fclose($con_file);
@chmod(ENGINE_DIR."/data/fields.pharmacy.db", 0666);

$con_file = fopen(ENGINE_DIR."/data/fields.objects.db", "w+") or die("��������, �� ���������� ������� ���� <b>.engine/data/fields.objects.db</b>.<br />��������� ������������ �������������� CHMOD!");
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
    <div class="title">��������� ���������</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
		����������� ���, ������� Web2Work � DataLife Engine ������� ����������� �� ����� �������. 
		�� ������ ����������� ������ ������� �������� ������ ������� � ���������� ����������� �������.
		 
		 <button class="btn btn-green" type="button" onclick="location.href='/'">������� ��������</button>
		 <br><br>
		���� �� ������ ����� � ������ ���������� ������� � �������� ������ ��������� �������.
		
		<button class="btn btn-gray" type="button" onclick="location.href='/admin.php'">������ ����������</button>
		<br><br>
		<h2>���������� � ������ ��������� �������</h2>
		<br>
			<iframe width="560" height="315" src="//www.youtube.com/embed/AOhTpf4kago" frameborder="0" allowfullscreen></iframe>
		<br><br><font color="red">��������: ��� ��������� ������� ��������� ��������� ���� ������, ��������� ������� ��������������, 
		� ����� ������������� �������� ��������� �������, ������� ����� �������� ��������� ������� ���� <b>install.php</b> 
		�� ��������� ��������� ��������� �������!</font><br><br>
		�������� ��� ������<br><br>
		Web2Work Group<br><br>
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="����������">
	</div>

  </div>
</div>
</form>
HTML;

echo $skin_footer;

?>