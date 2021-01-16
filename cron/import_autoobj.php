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
@ini_set('set_time_limit', '0');
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

@ini_set ('memory_limit',"328M");
@set_time_limit (0);
@ini_set ('max_execution_time',0);
@ini_set ('3048M');
@ini_set ('output_buffering','off');
@ob_end_clean ();
clearstatcache ();
ob_implicit_flush (TRUE);

require_once (ENGINE_DIR.'/data/import.auto.php');
require_once (ENGINE_DIR.'/data/config.php');
require_once (ENGINE_DIR.'/inc/imports/functions_auto.php');

if ($confms[link_city]!='' and $confms[cat]!='')
{
if ($_GET[onlyfoto]=='') $_GET[onlyfoto] = $confms['imp_foto'];
if ($_GET[city]=='') $_GET[city] = $confms['city'];
if ($_GET[doska_cat]=='') $_GET[doska_cat] = $confms['doska_cat'];

   if ($confms['link_city']!='') $confms[link_city] = $confms['link_city'];
   else $confms[link_city] = 'http://auto.drom.ru/region66/all/';

$gogod = get_autoobjes($confms[link_city]);
$i='Записи автообъявлений выгружены';
print_r($i);

}
else
{
	$i ='Не выбраны параметры в настройках импорта. Объявления не могут быть добавлены.';
	print_r($i);
}

@unlink( ENGINE_DIR . '/cache/system/doskaphoto_onportal_v1.php' );
@unlink( ENGINE_DIR . '/cache/system/catdoska_onportal_v1.php' );
@unlink( ENGINE_DIR . '/cache/system/doska_obj.php' );


clear_cache();
?>