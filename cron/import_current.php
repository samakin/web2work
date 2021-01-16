<?php

$distr_charset = "windows-1251";
$db_charset = "cp1251";

header("Content-type: text/html; charset=".$distr_charset);

if (!isset($_REQUEST['action']) and !isset($_REQUEST['onsite']))
{

//define('DATALIFEENGINE', true);
define('ROOT_DIR',dirname(dirname(__FILE__)));
define('ENGINE_DIR',ROOT_DIR .'/engine');

include_once ROOT_DIR.'/cron/system_functions_db.php';

//@error_reporting(E_ALL ^ E_NOTICE);
//@ini_set('display_errors', false);
//@ini_set('html_errors', false);
//@ini_set('set_time_limit', '600');
//@ini_set('error_reporting', E_ALL ^ E_NOTICE);

include ROOT_DIR.'/engine/data/dbconfig.php';
}

if (!isset($_REQUEST['onsite']))
{
include_once ROOT_DIR.'/cron/system_functions_import.php';
}else set_vars( "cron", $_TIME );

$tra=false;
require_once (ENGINE_DIR.'/data/config_weather.php');
if ($weather_type_p==2)
{

    function load_page($url)
    {
        // вход в систему
        // имя хоста, куда будем заходить
        $hostname = $url;
        // инициализация cURL
        $ch = curl_init($hostname);
        // получать заголовки
        curl_setopt($ch, CURLOPT_URL, $hostname);
        curl_setopt($ch, CURLOPT_HEADER, 1);    // получать заголовки
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.avito.ru');
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_COOKIE, "old=1");
        curl_setopt($ch, CURLOPT_COOKIEJAR,ENGINE_DIR.'/cache/cookie.txt');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $auth);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);     // Говорим скрипту, чтобы он следовал за редиректами которые происходят во время авторизации
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:')); // это необходимо, чтобы cURL не высылал заголовок на ожидание
        // выполнить запрос
        curl_exec ($ch);
        // получить результат работы
        $result = curl_multi_getcontent ($ch);
        // вывести результат

        // закрыть сессию работы с cURL
        curl_close ($ch);
        if (!$result) $result = file_get_contents($hostname);

        return $result;
    }

    define('WEATHER_PARTNER_ID', 			'test1_dle9.ru');
    define('WEATHER_XML_DOMAIN', 			'http://xml.weather.ua/');
    define('WEATHER_COUNTRY_URL',			WEATHER_XML_DOMAIN.'1.2/country/?partner_id='.WEATHER_PARTNER_ID);
    define('WEATHER_CITY_URL',			WEATHER_XML_DOMAIN.'1.2/city/?partner_id='.WEATHER_PARTNER_ID);
    define('WEATHER_FULL_FORECAST_URL',		WEATHER_XML_DOMAIN.'1.2/forecast/'.$idcity.'?dayf=5&lang=ru&userid='.WEATHER_PARTNER_ID);
    define('WEATHER_CURRENT_URL',			WEATHER_XML_DOMAIN.'1.2/forecast/'.$idcity.'?dayf=5&lang=ru&userid='.WEATHER_PARTNER_ID);

    define('WEATHER_COUNTRY_TABLE_NAME',		'weather_country');
    define('WEATHER_CITY_TABLE_NAME',		'weather_city');
    define('WEATHER_CURRENT_TABLE_NAME',		'weather_current');
    define('WEATHER_FORECAST_TABLE_NAME',		'weather_forecast');

    define('MYSQL_HOST',				DBHOST);
    define('MYSQL_USER',				DBUSER);
    define('MYSQL_PASS',				DBPASS);
    define('MYSQL_BASE',				DBNAME);

include_once ROOT_DIR.'/engine/modules/content/weather/common.inc.php';
include (ENGINE_DIR.'/data/config_weather.php');


    function get_weathers($idcity_gm='')
    {
    global $db, $config;

	$get_datering = load_page('https://www.gismeteo.ru/city/daily/'.$idcity_gm.'/');
    $key=0;

        preg_match_all("#<div class=\"section higher\">(.*?)<div class=\"wrap f_link\">#is", $get_datering, $all_date, PREG_SET_ORDER);
    	$wall_get[] = array();

    	foreach ($all_date as $get_all_date)
    	{


    	preg_match("#<dl class=\"cloudness\">(.*?)<dt(.*?)title=\"(.*?)\"(.*?)>(.*?)</dt>(.*?)</dl>#is", $get_all_date[1], $cloud);
    	//$cloud_img = getCloudImage(convert_unicode($cloud[3]));
    	preg_match("#<dd class='value m_temp c'(.*?)>(.*?)<span class=\"meas\">(.*?)</span></dd>#is", $get_all_date[1], $t);
    	preg_match("#<dd class='value m_press torr'(.*?)>(.*?)<span class=\"unit\">(.*?)</span></dd>#is", $get_all_date[1], $p);
    	preg_match("#<dd class='value m_wind ms'(.*?)>(.*?)<span class=\"unit\">(.*?)</span></dd>#is", $get_all_date[1], $w);
    	preg_match("#<div class=\"wicon hum\" title=\"(.*?)\">(.*?)<span class=\"unit\">(.*?)<span class=\"meas_hum_txt hidden\">(.*?)</span>(.*?)</span>(.*?)</div>#is", $get_all_date[1], $h);

					$datee = time()+($config['date_adjust']*60);
					$_TI = date("Y-m-d h:m:s",$datee);
					$t[2] = str_replace('+','',$t[2]);
					$t[2] = str_replace('&minus;','-',$t[2]);

					$sql = sprintf("INSERT INTO `%s` (`city_id`, `date`, `cloud`, `t`, `t_flik`, `p`, `w`, `w_rumb`, `h`)
									VALUES (%d, '%s', %d, '%s', '%s', %d, %d, '%s', %d)
									ON DUPLICATE KEY UPDATE `date` = '%3\$s', `cloud` = '%4\$s', `t` = '%5\$s',
										`t_flik` = '%6\$s', `p` = '%7\$s', `w` = '%8\$s', `w_rumb` = '%9\$s',
										`h` = '%10\$d'",
                        'weather_current',
							$idcity_gm,
							$_TI,
							$cloud_img,
							$t[2],
							$t[2],
							$p[2],
							$w[2],
							'0',
							$h[2]
						);

	     			@unlink( ROOT_DIR . '/engine/cache/system/weather_portal_'.$idcity_gm.'.php');
                    clear_cache(array('weather_','weather','pogoda'));

                    if ($db->query ($sql)) $added_count++;

					$file_content = str_replace($current_found[0][$link_city_id], '', $file_content);

    	}
 	}
	$db->query ( "SELECT * FROM " . PREFIX . "_change_city ORDER BY name DESC" );
	while ( $row = $db->get_row () ) {

	 	$get = get_weathers($row['weather_gm_id']);

 	}
    $get = get_weathers($idcity_gm);

 					$xfieldsz = unserialize( @file_get_contents( ROOT_DIR . '/engine/cache/system/weather_pagefull_v1.php' ) );
					$sa=0;
					$datee = time()+($config['date_adjust']*60);
					$_TI = date("Y-m-d h:m:s",$datee);
					if ($idcity_gm=='')
					{
					foreach ($xfieldsz as $typecityz) {
						//echo $typecityz[3];
						 $get = get_weathers($typecityz[3]);
					}
					}

					echo 'Погода обновлена';
}

clear_cache(array('weather_','weather','pogoda'));
?>