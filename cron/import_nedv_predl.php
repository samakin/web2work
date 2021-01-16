<?php
if ($_REQUEST[action]=='')
{
define('DATALIFEENGINE', true);
define('ROOT_DIR',dirname(dirname(__FILE__)));
define('ENGINE_DIR',ROOT_DIR .'/engine');

class db
{
	var $db_id = false;
	var $query_num = 0;
	var $query_list = array();
	var $mysql_error = '';
	var $mysql_version = '';
	var $mysql_error_num = 0;
	var $mysql_extend = "MySQLi";
	var $MySQL_time_taken = 0;
	var $query_id = false;


	function connect($db_user, $db_pass, $db_name, $db_location = 'localhost', $show_error=1)
	{
		$db_location = explode(":", $db_location);

		if (isset($db_location[1])) {

			$this->db_id = @mysqli_connect($db_location[0], $db_user, $db_pass, $db_name, $db_location[1]);

		} else {

			$this->db_id = @mysqli_connect($db_location[0], $db_user, $db_pass, $db_name);

		}

		if(!$this->db_id) {
			if($show_error == 1) {
				$this->display_error(mysqli_connect_error(), '1');
			} else {
				return false;
			}
		}

		$this->mysql_version = mysqli_get_server_info($this->db_id);

		if(!defined('COLLATE'))
		{
			define ("COLLATE", "cp1251");
		}

		mysqli_query($this->db_id, "SET NAMES '" . COLLATE . "'");

		return true;
	}

	function query($query, $show_error=true)
	{
		$time_before = $this->get_real_time();

		if(!$this->db_id) $this->connect(DBUSER, DBPASS, DBNAME, DBHOST);

		if(!($this->query_id = mysqli_query($this->db_id, $query) )) {

			$this->mysql_error = mysqli_error($this->db_id);
			$this->mysql_error_num = mysqli_errno($this->db_id);

			if($show_error) {
				$this->display_error($this->mysql_error, $this->mysql_error_num, $query);
			}
		}

		$this->MySQL_time_taken += $this->get_real_time() - $time_before;

//			$this->query_list[] = array( 'time'  => ($this->get_real_time() - $time_before),
//										 'query' => $query,
//										 'num'   => (count($this->query_list) + 1));

		$this->query_num ++;

		return $this->query_id;
	}

	function get_row($query_id = '')
	{
		if ($query_id == '') $query_id = $this->query_id;

		return mysqli_fetch_assoc($query_id);
	}

	function get_array($query_id = '')
	{
		if ($query_id == '') $query_id = $this->query_id;

		return mysqli_fetch_array($query_id);
	}

	function super_query($query, $multi = false)
	{

		if(!$multi) {

			$this->query($query);
			$data = $this->get_row();
			$this->free();
			return $data;

		} else {
			$this->query($query);

			$rows = array();
			while($row = $this->get_row()) {
				$rows[] = $row;
			}

			$this->free();

			return $rows;
		}
	}

	function num_rows($query_id = '')
	{
		if ($query_id == '') $query_id = $this->query_id;

		return mysqli_num_rows($query_id);
	}

	function insert_id()
	{
		return mysqli_insert_id($this->db_id);
	}

	function get_result_fields($query_id = '') {

		if ($query_id == '') $query_id = $this->query_id;

		while ($field = mysqli_fetch_field($query_id))
		{
            $fields[] = $field;
		}

		return $fields;
   	}

	function safesql( $source )
	{
		if ($this->db_id) return mysqli_real_escape_string ($this->db_id, $source);
		else return mysql_escape_string($source);
	}

	function free( $query_id = '' )
	{

		if ($query_id == '') $query_id = $this->query_id;

		@mysqli_free_result($query_id);
	}

	function close()
	{
		@mysqli_close($this->db_id);
	}

	function get_real_time()
	{
		list($seconds, $microSeconds) = explode(' ', microtime());
		return ((float)$seconds + (float)$microSeconds);
	}

	function display_error($error, $error_num, $query = '')
	{
	global $db, $tpl, $config;

		if($query) {
			// Safify query
			$query = preg_replace("/([0-9a-f]){32}/", "********************************", $query); // Hides all hashes
			$query_str = "$query";
		}

	$ip = getRealIpAddr();
	$datee = time()+($config['date_adjust']*60);
	$d = $_REQUEST['do'];
	$s = $_REQUEST[subaction];
    $md = $_REQUEST['mod'];
	if ($d!='') $analizator_d = "?do=".$d."";
    if ($s!='') $analizator_s = "?subaction=".$s."";

    $config['offline_reason'] = "Страница ".$config['http_home_url']."".$analizator_d."".$analizator_s." находится на реконструкции, через 10-15 минут она будет доступна.
    <br>Приносим вам свои извинения за доставленные неудобства.
    <br><br> Вы можете перейти на главную страницу <a href='".$config['http_home_url']."' style='color:#000;'>".$config['home_title']."</a>";

		$text_osh_msq = '
		Возникла ошибка: '.$error.'
		Номер ошибки: '.$error_num.'
		Текст ошибки: '.$query_str.'
		Обращение с IP: '.$ip.'
		Подробнее: '.variables().'
		';

	$datees=date('Y-m-d-H-m-s',$datee);

	$loc_file = ENGINE_DIR.'/cache/logs/'.$md.''.$s.''.$d.''.$datees.'.txt';
	if (!file_exists($loc_file))
	{
	 $handler = fopen(ENGINE_DIR.'/cache/logs/'.$md.''.$s.''.$d.''.$datees.'.txt', "w");
        fwrite($handler, $text_osh_msq);
        fclose($handler);
	}

	require_once ENGINE_DIR.'/classes/parse.class.php';
	//require_once ENGINE_DIR.'/modules/sitelogin.php';
    ///include_once ENGINE_DIR . '/modules/offline.php';

	}

}
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

@error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', false);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

@ini_set ('memory_limit',"360M");
@set_time_limit (0);
@ini_set ('max_execution_time',0);
@ini_set ('3648M');
@ini_set ('output_buffering','off');
@ob_end_clean ();
clearstatcache ();
ob_implicit_flush (TRUE);

require_once (ENGINE_DIR.'/inc/imports/functions_nedvobj.php');

require_once (ENGINE_DIR.'/data/import.nedv.php');
require_once (ENGINE_DIR.'/data/config.php');

echo $confms['imp_catin'];
echo $confms['city'];
echo $confms['imp_catout'];

if (($_GET[cat]!='' or $confms['imp_catin']!='') and ($_GET[city]!='' or $confms['city']!='') and ($_GET[doska_cat]!='' or $confms['imp_catout']!=''))
{
if ($_GET[cat]=='') $_GET[cat] = $confms['imp_catin'];
if ($_GET[city]=='') $_GET[city] = $confms['city'];
if ($_GET[doska_cat]=='') $_GET[doska_cat] = $confms['imp_catout'];

load_goroda('', $confms['city'], $confms['imp_catout']);

print_r('Выгружено: '.$yes.'<br>Не выгружены т.к есть в базе: '.$no.'');
}
else
{
	$i .='Не выбраны параметры в настройках импорта. Объявления не могут быть добавлены.';
	print_r($i);
}

@unlink( ENGINE_DIR . '/cache/system/doskaphoto_onportal_v1.php' );
@unlink( ENGINE_DIR . '/cache/system/catdoska_onportal_v1.php' );
@unlink( ENGINE_DIR . '/cache/system/doska_obj.php' );


clear_cache();
?>