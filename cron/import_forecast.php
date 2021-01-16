<?php
@ini_set('set_time_limit', '0');
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

	// ���� � �������
	// ��� �����, ���� ����� ��������
	$hostname = $url;
	// ������������� cURL
	$ch = curl_init($hostname);
	// �������� ���������
	curl_setopt($ch, CURLOPT_URL, $hostname);
	curl_setopt($ch, CURLOPT_HEADER, 1);    // �������� ���������
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
	curl_setopt($ch, CURLOPT_REFERER, 'http://www.avito.ru');
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_COOKIE, "old=1");
	curl_setopt($ch, CURLOPT_COOKIEJAR,ENGINE_DIR.'/cache/cookie.txt');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $auth);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);     // ������� �������, ����� �� �������� �� ����������� ������� ���������� �� ����� �����������
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
	curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:')); // ��� ����������, ����� cURL �� ������� ��������� �� ��������
	// ��������� ������
	curl_exec ($ch);
	// �������� ��������� ������
	$result = curl_multi_getcontent ($ch);
	// ������� ���������

	// ������� ������ ������ � cURL
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

function getCloudImage($precip='') {
		if($precip == '����') {
			$image = 0;
		}
		elseif($precip == '�����������') {
			$image = 10;
		}
		elseif($precip == '�������') {
			$image = 20;
		}
		elseif($precip == '��������') {
			$image = 30;
		}
		elseif($precip == '��������, ��������� �����') {
			$image = 40;
		}
		elseif($precip == '�����') {
			$image = 50;
		}
		elseif($precip == '�����������, ��������� �����') {
			$image = 60;
		}
		elseif($precip == '�����') {
			$image = 70;
		}
		elseif($precip == '���� � ������') {
			$image = 80;
		}
		elseif($precip == '����') {
			$image = 90;
		}
		elseif($precip == '��������, ��������� ����') {
			$image = 100;
		}
		else {
			$image = '0';
		}
		return $image;
	}

	function exitnumrumb($wind='') {
		switch($wind) {
			case '�':	$wind_direction = '0'; break;
			case '�,��':	$wind_direction = '20'; break;
			case '��':	$wind_direction = '35'; break;
			case '�,��':	$wind_direction = '55'; break;
			case '�':	$wind_direction = '70'; break;
			case '�,��':	$wind_direction = '110'; break;
			case '��':	$wind_direction = '125'; break;
			case '�,��':	$wind_direction = '145'; break;
			case '�':	$wind_direction = '160'; break;
			case '�,��':	$wind_direction = '200'; break;
			case '��':	$wind_direction = '215'; break;
			case '�,��':	$wind_direction = '235'; break;
			case '�':	$wind_direction = '250'; break;
			case '�,��':	$wind_direction = '290'; break;
			case '��':	$wind_direction = '305'; break;
			case '�,��':	$wind_direction = '325'; break;
			}

		return $wind_direction;
	}

    function convert_unicodes($t, $to = 'windows-1251') {

        $to = strtolower( $to );

        if( $to == 'utf-8' ) {

            return $t;

        } else {

            if( function_exists( 'mb_convert_encoding' ) ) {

                $t = mb_convert_encoding( $t, $to, "UTF-8" );

            } elseif( function_exists( 'iconv' ) ) {

                $t = iconv( "UTF-8", $to . "//IGNORE", $t );

            } else $t = "The library iconv AND mbstring is not supported by your server";

        }

        return $t;
    }

    function get_weathers($idcity_gm='', $page='')
    {
    global $db, $config;
    if ($page=='')
    {
	$get_datering = load_page('https://www.gismeteo.ru/city/daily/'.$idcity_gm.'/');
    }
    else $get_datering = load_page('https://www.gismeteo.ru'.$page.'');
    $key=0;

    	preg_match_all("#<tbody id=\"tbwdaily(.*?)\"(.*?)>(.*?)</tbody>#is", $get_datering, $all_date, PREG_SET_ORDER);
    	foreach ($all_date as $gweat)
    	{
    	$si=0;
    	//echo '�������:'.$gweat[1].'<br>';

    	preg_match_all("#<tr class=\"wrow(.*?)\" id=\"wrow-(.*?)\">(.*?)</tr>#is", $gweat[3], $weather_date, PREG_SET_ORDER);
    	foreach ($weather_date as $get_all_date)
    	{
    	$si++;
        //echo $get_all_date[1];
    	preg_match("#<td class=\"cltext\">(.*?)</td>#is", $get_all_date[3], $cloud);
    	$cloud_img = getCloudImage(convert_unicodes($cloud[1]));
    	preg_match("#<span class='value m_temp c'>(.*?)</span>(.*?)<span class='value m_temp c'>(.*?)</span>#is", $get_all_date[3], $t);
    	preg_match("#<span class='value m_press torr'>(.*?)</span>#is", $get_all_date[3], $p);
    	preg_match("#<span class='value m_wind ms'>(.*?)</span>#is", $get_all_date[3], $w);
    	preg_match("#<dt class=\"wicon(.*?)\" title=\"(.*?)\">(.*?)</dt>#is", $get_all_date[3], $rumb);
    	preg_match("#<td class=\"temp\">(.*?)</td>(.*?)<td>(.*?)</td>(.*?)<td>(.*?)</td>(.*?)<td>(.*?)</td>#is", $get_all_date[3], $h);
        $hourdata = explode('-',$get_all_date[2]);

        $ru = exitnumrumb(convert_unicodes($rumb[3]));

        if ($si==1) $tis = 3;
        if ($si==2) $tis = 9;
        if ($si==3) $tis = 15;
        if ($si==4) $tis = 21;

					$datee = time()+($config['date_adjust']*60);
					$_TI = date("Y-m-d h:m:s",$datee);
					$t[1] = str_replace('+','',$t[1]);
										$t[1] = str_replace('&minus;','-',$t[1]);

							$sql = sprintf("INSERT INTO `%s` (`city_id`, `date`, `hour`, `cloud`, `precip`, `t_min`,
											`t_max`, `p_min`, `p_max`, `w_min`, `w_max`, `w_rumb`, `h_min`, `h_max`, `wpi`)
										VALUES (%d, '%s', %d, %d, %d, '%s', '%s', %d, %d, %d, %d, '%d', %d, %d, %d)
										ON DUPLICATE KEY UPDATE `cloud` = %5\$d, `precip` = %6\$d, `t_min` = '%7\$s',
											`t_max` = '%8\$s', `p_min` = %9\$d, `p_max` = %10\$d, `w_min` = %11\$d,
											`w_max` = %12\$d, `w_rumb` = '%13\$d', `h_min` = %14\$d, `h_max` = %15\$d,
											`wpi` = %16\$d",
								WEATHER_FORECAST_TABLE_NAME,
								$idcity_gm,
								$hourdata[0].'-'.$hourdata[1].'-'.$hourdata[2],
								$tis,
								$cloud_img,
								$cloud_img,
								$t[1],
								$t[3],
								$p[1],
								$p[1],
								$w[1],
								$w[1],
								$ru,
								$h[7],
								$h[7],
								$h[7]
							);

            @unlink( ROOT_DIR . '/engine/cache/system/weather_portal_'.$idcity_gm.'.php');
            //clear_cache(array('weather_','weather','pogoda'));

            if ($db->query ($sql)) $added_count++;

					$file_content = str_replace($current_found[0][$link_city_id], '', $file_content);

    	}
    	}
 	}

	$db->query ( "SELECT * FROM " . PREFIX . "_change_city ORDER BY name DESC" );
	while ( $row = $db->get_row () ) {

	 	$get = get_weathers($row['weather_gm_id'],'');
        $get = get_weathers($row['weather_gm_id'],'/city/daily/'.$row['weather_gm_id'].'/2/');
        $get = get_weathers($row['weather_gm_id'],'/city/daily/'.$row['weather_gm_id'].'/4/');
        $get = get_weathers($row['weather_gm_id'],'/city/daily/'.$row['weather_gm_id'].'/6/');

 	}

 	$get = get_weathers($idcity_gm,'');
    $get = get_weathers($idcity_gm,'/city/daily/'.$idcity_gm.'/2/');
    $get = get_weathers($idcity_gm,'/city/daily/'.$idcity_gm.'/4/');
    $get = get_weathers($idcity_gm,'/city/daily/'.$idcity_gm.'/6/');

 					$xfieldsz = unserialize( @file_get_contents( ROOT_DIR . '/engine/cache/system/weather_pagefull_v1.php' ) );
					$sa=0;
					$datee = time()+($config['date_adjust']*60);
					$_TI = date("Y-m-d h:m:s",$datee);
					if ($idcity_gm=='')
					{
					foreach ($xfieldsz as $typecityz) {
	                        $get = get_weathers($typecityz[3],'');
	                        $get = get_weathers($typecityz[3],'/city/daily/'.$typecityz[3].'/2/');
	                        $get = get_weathers($typecityz[3],'/city/daily/'.$typecityz[3].'/4/');
	                        $get = get_weathers($typecityz[3],'/city/daily/'.$typecityz[3].'/6/');
					}
					}

	echo '������ ���������';
}

//clear_cache(array('weather_','weather','pogoda'));
?>