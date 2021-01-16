<?php

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
	curl_setopt ($ch, CURLOPT_HEADER, 1);
	// если ведется проверка HTTP User-agent, то передаем один из возможных допустимых вариантов:
	curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
	// елси проверятся откуда пришел пользователь, то указываем допустимый заголовок HTTP Referer:
	curl_setopt ($ch, CURLOPT_REFERER, $hostname);
	// использовать метод POST
	curl_setopt ($ch, CURLOPT_POST, 1);
	// сохранять информацию Cookie в файл, чтобы потом можно было ее использовать
	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	// передаем поля формы
	curl_setopt ($ch, CURLOPT_POSTFIELDS, 'user=your_robot&pass=Your_R0b0t!PassWd1&mod=Login');
	// возвращать результат работы
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	// не проверять SSL сертификат
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
	// не проверять Host SSL сертификата
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	// это необходимо, чтобы cURL не высылал заголовок на ожидание
	curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));
	// выполнить запрос
	curl_exec ($ch);
	// получить результат работы
	$result = curl_multi_getcontent ($ch);
	// вывести результат

	// закрыть сессию работы с cURL
	curl_close ($ch);

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

	function getCloudImage($precip) {
		if($precip == 'Ясно') {
			$image = 0;
		}
		elseif($precip == 'Малооблачно') {
			$image = 10;
		}
		elseif($precip == 'Облачно') {
			$image = 20;
		}
		elseif($precip == 'Пасмурно') {
			$image = 30;
		}
		elseif($precip == 'Пасмурно, небольшой дождь') {
			$image = 40;
		}
		elseif($precip == 'Дождь') {
			$image = 50;
		}
		elseif($precip == 'Малооблачно, небольшой дождь') {
			$image = 60;
		}
		elseif($precip == 'Гроза') {
			$image = 70;
		}
		elseif($precip == 'Снег с дождем') {
			$image = 80;
		}
		elseif($precip == 'Снег') {
			$image = 90;
		}
		elseif($precip == 'Пасмурно, небольшой снег') {
			$image = 100;
		}
		else {
			$image = '0';
		}
		return $image;
	}



    function get_weathers($idcity_gm)
    {
    global $db, $config;

	$get_datering = load_page('https://www.gismeteo.ru/city/daily/'.$idcity_gm.'/');
    $key=0;

    	preg_match_all("#<div class=\"section higher\">(.*?)<div class=\"wrap f_link\">#is", $get_datering, $all_date, PREG_SET_ORDER);
    	$wall_get[] = array();
    	foreach ($all_date as $get_all_date)
    	{
        //echo $get_all_date[1];
    	preg_match("#<dl class=\"cloudness\">(.*?)<dt(.*?)title=\"(.*?)\"(.*?)>(.*?)</dt>(.*?)</dl>#is", $get_all_date[1], $cloud);
    	$cloud_img = getCloudImage(convert_unicode($cloud[3]));
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
							WEATHER_CURRENT_TABLE_NAME,
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

					if (!mysql_ping()) {
						mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS) OR DIE("Can't connect to a database server");
					}

	     			@unlink( ROOT_DIR . '/engine/cache/system/weather_portal_'.$idcity_gm.'.php');
                    clear_cache('weather_');

					if (mysql_query($sql)) $added_count++;
					else die(mysql_error());

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

//					echo 'Погода обновлена';
}
/*
elseif ($weather_type_p==0)
{
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

# include common lib and config file
include_once ROOT_DIR.'/engine/modules/content/weather/common.inc.php';

					$xfieldsz = unserialize( @file_get_contents( ROOT_DIR . '/engine/cache/system/weather_pagefull_v1.php' ) );
					$sa=0;
					$datee = time()+($config['date_adjust']*60);
					$_TI = date("Y-m-d h:m:s",$datee);
					foreach ($xfieldsz as $typecityz) {
     				$sa++;

	     				@unlink( ROOT_DIR . '/engine/cache/system/weather_portal_'.$typecityz[0].'.php');
                    	clear_cache('weather_');


     $url = WEATHER_XML_DOMAIN.'1.2/forecast/'.$typecityz[0].'?dayf=5&lang=ru&userid='.WEATHER_PARTNER_ID;

	if (($fp = fopen($url, "r")) !== false) {
	$file_content = fread($fp, 16384);

	# checking forecast version
	if (preg_match('/forecast version="1.2"/', $file_content)) {

		while (!feof($fp)) {
			$file_content .= fread($fp, 16384);

			# get all city forecast
			if (preg_match_all('@<current(.*?)>(.*?)</current>@is', $file_content, $current_found)) {

				foreach ($current_found[2] as $link_city_id => $inner_current_element) {

					$current = readXmlElements($inner_current_element, true);

					$sql = sprintf("INSERT INTO `%s` (`city_id`, `date`, `cloud`, `t`, `t_flik`, `p`, `w`, `w_rumb`, `h`)
									VALUES (%d, '%s', %d, '%s', '%s', %d, %d, '%s', %d)
									ON DUPLICATE KEY UPDATE `date` = '%3\$s', `cloud` = '%4\$s', `t` = '%5\$s',
										`t_flik` = '%6\$s', `p` = '%7\$s', `w` = '%8\$s', `w_rumb` = '%9\$s',
										`h` = '%10\$d'",
							WEATHER_CURRENT_TABLE_NAME,
							$typecityz[0],
							$_TI,
							$current['cloud'],
							$current['t'],
							$current['t_flik'],
							$current['p'],
							$current['w'],
							$current['w_rumb'],
							$current['h']
						);

					if (!mysql_ping()) {
						mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS) OR DIE("Can't connect to a database server");
					}


					if (mysql_query($sql)) $added_count++;
					else die(mysql_error());

					$file_content = str_replace($current_found[0][$link_city_id], '', $file_content);

				}
			}
		}

		$tra=true;
	}

}

           			include_once ROOT_DIR.'/engine/modules/content/weather/weather-client.class.inc.php';
					include_once ROOT_DIR.'/engine/modules/content/weather/common.inc.php';
                    # create weather class instance
					$w_client = new weatherClient();

				 	$w_client->setCityID($typecityz[0]);
					$w_current = $w_client->getCurrentWeather();

					$fp = fopen( ROOT_DIR . '/engine/cache/system/weather_portal_'.$typecityz[0].'.php', 'wb+' );
					fwrite( $fp, serialize( $w_current ) );
					fclose( $fp );
					@chmod( ROOT_DIR . '/engine/cache/system/weather_portal_'.$typecityz[0].'.php', 0666 );

					}

if ($onsite!=true)
{
if ($tra==true) echo 'Выгружено';
else echo 'Не выгружено, проверьте настройки';
}

					/*
if (($fp = fopen(WEATHER_CURRENT_URL, "r")) !== false) {
	$file_content = fread($fp, 16384);

	# checking forecast version
	if (preg_match('/fullcurrent version="1.2"/', $file_content)) {

		while (!feof($fp)) {
			$file_content .= fread($fp, 16384);

			# get all city forecast
			if (preg_match_all('@<current city="(\d+)">(.*?)</current>@is', $file_content, $current_found)) {

				foreach ($current_found[2] as $link_city_id => $inner_current_element) {
					$current = readXmlElements($inner_current_element, true);
					$current['city_id'] = $current_found[1][$link_city_id];

					$sql = sprintf("INSERT INTO `%s` (`city_id`, `date`, `cloud`, `t`, `t_flik`, `p`, `w`, `w_rumb`, `h`)
									VALUES (%d, '%s', %d, '%s', '%s', %d, %d, '%s', %d)
									ON DUPLICATE KEY UPDATE `date` = '%3\$s', `cloud` = '%4\$s', `t` = '%5\$s',
										`t_flik` = '%6\$s', `p` = '%7\$s', `w` = '%8\$s', `w_rumb` = '%9\$s',
										`h` = '%10\$d'",
							WEATHER_CURRENT_TABLE_NAME,
							$current['city_id'],
							$current['date'],
							$current['cloud'],
							$current['t'],
							$current['t_flik'],
							$current['p'],
							$current['w'],
							$current['w_rumb'],
							$current['h']
						);

					if (!mysql_ping()) {
						mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS) OR DIE("Can't connect to a database server");
					}


					if (mysql_query($sql)) $added_count++;
					else die(mysql_error());

					$file_content = str_replace($current_found[0][$link_city_id], '', $file_content);

					}

					}
     				if ($current['city_id']==$idcity)
                    {
					if (mysql_query($sql)) $added_count++;
					else die(mysql_error());

					$file_content = str_replace($current_found[0][$link_city_id], '', $file_content);
					}
				}
			}
		}
		@unlink( ROOT_DIR . '/engine/cache/system/weather_portal_v1.php');
		showMsg('Обновлена информация по '.$added_count.' городу');
	}
	else showMsg('This is not 1.2 version of XML FullCurrent data');
}
else showMsg("Can't get XML FullCurrent data from '".WEATHER_FULL_FORECAST_URL."'");

}
*/
//clear_cache();
?>