<?php
if ($_REQUEST[action]=='')
{
define('DATALIFEENGINE', true);
define('ROOT_DIR',dirname(dirname(__FILE__)));
define('ENGINE_DIR',ROOT_DIR .'/engine');

include ENGINE_DIR.'/data/config.php';
require_once ENGINE_DIR.'/classes/mysql.php';
require_once ENGINE_DIR.'/data/dbconfig.php';
}

function clear_cache($cache_areas = false) {
	global $mcache;

	if ( $mcache ) {

		memcache_flush($mcache);

	} else {

		if ( $cache_areas ) {
			if(!is_array($cache_areas)) {
				$cache_areas = array($cache_areas);
			}
		}

		$fdir = opendir( ENGINE_DIR . '/cache' );

		while ( $file = readdir( $fdir ) ) {
			if( $file != '.' and $file != '..' and $file != '.htaccess' and $file != 'system' ) {

				if( $cache_areas ) {

					foreach($cache_areas as $cache_area) if( strpos( $file, $cache_area ) !== false ) @unlink( ENGINE_DIR . '/cache/' . $file );

				} else {

					@unlink( ENGINE_DIR . '/cache/' . $file );

				}
			}
		}
	}

}

@error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

@ini_set ('memory_limit',"128M");
@set_time_limit (0);
@ini_set ('max_execution_time',0);
@ini_set ('2048M');
@ini_set ('output_buffering','off');
@ob_end_clean ();
clearstatcache ();

$start_from = $_REQUEST[start_from];
$sea_per_page = $_REQUEST[sea_per_page];

$dateeno = time()+($config['date_adjust']*60);
$date_nowing = date('Y-m-d', $dateeno);
include_once ENGINE_DIR . '/classes/xmlmail.class.php';
require_once ENGINE_DIR .'/classes/parse.class.php';
$parse = new ParseFilter( Array (), Array (), 1, 1 );
$parse->leech_mode = true;

require_once (ENGINE_DIR.'/data/import.work.php');
require_once (ENGINE_DIR.'/data/config.php');
require_once (ENGINE_DIR.'/inc/plugins/block_blogs.core.php');
require_once (ENGINE_DIR.'/inc/imports/functions_rabota.php');
//require_once (ENGINE_DIR.'/inc/imports/functions_work.php');

function convert_unicode($t, $to = 'windows-1251') {

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

function totranslit($var, $lower = true, $punkt = true) {
	global $langtranslit;

	if ( is_array($var) ) return "";

	$var = str_replace(chr(0), '', $var);

	if (!is_array ( $langtranslit ) OR !count( $langtranslit ) ) {
		$var = trim( strip_tags( $var ) );

		if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
		else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

		$var = preg_replace( '#[.]+#i', '.', $var );
		$var = str_ireplace( ".php", ".ppp", $var );

		if ( $lower ) $var = strtolower( $var );

		return $var;
	}

	$var = trim( strip_tags( $var ) );
	$var = preg_replace( "/\s+/ms", "-", $var );
	$var = str_replace( "/", "-", $var );

	$var = strtr($var, $langtranslit);

	if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
	else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

	$var = preg_replace( '#[\-]+#i', '-', $var );
	$var = preg_replace( '#[.]+#i', '.', $var );

	if ( $lower ) $var = strtolower( $var );

	$var = str_ireplace( ".php", "", $var );
	$var = str_ireplace( ".php", ".ppp", $var );

	if( strlen( $var ) > 200 ) {

		$var = substr( $var, 0, 200 );

		if( ($temp_max = strrpos( $var, '-' )) ) $var = substr( $var, 0, $temp_max );

	}

	return $var;
}

if ($confms['link_city']!='')
{

   if ($confms['link_city']!='') $lcity = $confms['link_city'];
   else $lcity = 'http://hh.ru/';

	$tr = $db->query("SELECT * FROM " . USERPREFIX . "_cron_work ORDER by id DESC ");
	$i=0;
	while($row = $db->get_row($tr))
	{

		$results_type = $db->super_query("SELECT type FROM " . PREFIX . "_doska_cat WHERE id='".$row[cat_out_id]."'");

		$gogod = get_autoobjes($lcity, $row[cat_in_id], $row[cat_out_id], $results_type[type], $row[col]);
		$i='Записи вакансий выгружены';
		print_r($i);

	}

}
else
{
	$i ='Не выбраны параметры в настройках импорта. Вакансии не могут быть добавлены.';
	print_r($i);
}

@unlink( ENGINE_DIR . '/cache/system/doskaphoto_onportal_v1.php' );
@unlink( ENGINE_DIR . '/cache/system/catdoska_onportal_v1.php' );
@unlink( ENGINE_DIR . '/cache/system/doska_obj.php' );


clear_cache();
?>