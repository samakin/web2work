<?php
@ini_set ('memory_limit',"365M");
@set_time_limit (0);
@ini_set ('max_execution_time',0);
@ini_set ('3048M');
@ini_set ('output_buffering','off');
@ob_end_clean ();

/* принудительная привязка к городу и региону */
//date_default_timezone_set('Europe/Minsk');


if ($_REQUEST[action]=='' and $onsite!=true)
{
clearstatcache ();
ob_implicit_flush (TRUE);
error_reporting (1);
define('DATALIFEENGINE',true);
extract($_REQUEST,EXTR_SKIP);
define('ROOT_DIR',dirname(dirname(__FILE__)));
define('ENGINE_DIR',ROOT_DIR .'/engine');

require_once ENGINE_DIR.'/classes/mysql.php';
require_once ENGINE_DIR.'/data/dbconfig.php';
require_once ENGINE_DIR.'/data/config.php';
require_once ENGINE_DIR.'/modules/functions.php';
}
else
{
if ($onsite!=true)
{
function dle_cache($prefix, $cache_id = false, $member_prefix = false) {
	global $config, $is_logged, $member_id, $mcache;

	if( $config['allow_cache'] != "yes" ) return false;

	$config['clear_cache'] = (intval($config['clear_cache']) > 1) ? intval($config['clear_cache']) : 0;

	if( $is_logged ) $end_file = $member_id['user_group'];
	else $end_file = "0";

	if( ! $cache_id ) {

		$key = $prefix;

	} else {

		$cache_id = md5( $cache_id );

		if( $member_prefix ) $key = $prefix . "_" . $cache_id . "_" . $end_file;
		else $key = $prefix . "_" . $cache_id;

	}

	if ( $mcache ) {

		return memcache_get( $mcache, md5( DBNAME . PREFIX . md5(DBUSER) .$key ) );

	} else {

		$buffer = @file_get_contents( ENGINE_DIR . "/cache/" . $key . ".tmp" );

		if ( $buffer !== false AND $config['clear_cache'] ) {

			$file_date = @filemtime( ENGINE_DIR . "/cache/" . $key . ".tmp" );
			$file_date = time()-$file_date;

			if ( $file_date > ( $config['clear_cache'] * 60 ) ) {
				$buffer = false;
				@unlink( ENGINE_DIR . "/cache/" . $key . ".tmp" );
			}

			return $buffer;

		} else return $buffer;

	}
}
function create_cache($prefix, $cache_text, $cache_id = false, $member_prefix = false) {
	global $config, $is_logged, $member_id, $mcache;

	if( $config['allow_cache'] != "yes" ) return false;
    if ($cache_text=='') $cache_text="<span style=\"display:none;\">нет данных</span>";
	if( $is_logged ) $end_file = $member_id['user_group'];
	else $end_file = "0";

	if( ! $cache_id ) {
		$key = $prefix;
	} else {
		$cache_id = md5( $cache_id );

		if( $member_prefix ) $key = $prefix . "_" . $cache_id . "_" . $end_file;
		else $key = $prefix . "_" . $cache_id;

	}


	if ( $mcache ) {

		$config['clear_cache'] = (intval($config['clear_cache']) > 1) ? intval($config['clear_cache']) : 0;

		if ( $config['clear_cache'] ) $set_time = $config['clear_cache'] * 60; else $set_time = 86400;

		memcache_set( $mcache, md5( DBNAME . PREFIX . md5(DBUSER) .$key ), $cache_text, MEMCACHE_COMPRESSED, $set_time );

	} else {

		file_put_contents (ENGINE_DIR . "/cache/" . $key . ".tmp", $cache_text, LOCK_EX);

		@chmod( ENGINE_DIR . "/cache/" . $key . ".tmp", 0666 );
	}
}
function clear_cache($cache_areas = false) {
	global $mcache;

	if ( $mcache ) {

		memcache_flush($mcache);

	}

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
}
}


include (ENGINE_DIR.'/data/import.tv.php');

function bds_get_code($file) {
          $data = false;

                $data = @file_get_contents($file);


        if ($data) return $data; else return false;
}


function load_tv($url)
{
	// вход в систему
	// имя хоста, куда будем заходить
	$hostname = $url;
	// инициализация cURL
	$ch = curl_init($hostname);
	// получать заголовки
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	// если ведется проверка HTTP User-agent, то передаем один из возможных допустимых вариантов:
	curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
	// елси проверятся откуда пришел пользователь, то указываем допустимый заголовок HTTP Referer:
	curl_setopt ($ch, CURLOPT_REFERER, $hostname);
	// использовать метод POST
	curl_setopt ($ch, CURLOPT_POST, 1);
	// сохранять информацию Cookie в файл, чтобы потом можно было ее использовать
	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	// передаем поля формы
	curl_setopt ($ch, CURLOPT_POSTFIELDS, '');
	// возвращать результат работы
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	// не проверять SSL сертификат
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
	// не проверять Host SSL сертификата
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 1);
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

if ($_GET['date']!='')
{
$now_da = $_GET['date'];
}else $now_da = date('Y-m-d');

/// получаем город из списка и сохраняем его в конфиг ///

if ($confms['region_id']!='') $reg_id = $confms['region_id'];

if ($reg_id=='')
{

$db->query( "DELETE FROM ".PREFIX."_tv_channel WHERE id!=''" );

$get_tv_array_city = load_tv('https://portal.mail.ru/RegionSuggest?callback=rId=0&M=0&N=11150');
$converted_array_city = convert_unicode($get_tv_array_city, $config['charset']);
echo 'Открыта панель выгрузки городов';
$converted_array_city = str_replace('{"id":"','<li><div>',$converted_array_city);
$converted_array_city = str_replace('"},','</div></li>',$converted_array_city);
$converted_array_city = str_replace('"cityName":"','<b>',$converted_array_city);
$converted_array_city = str_replace('","regionName"','</b>,"regionName"',$converted_array_city);
$converted_array_city = str_replace('","parentId":"','</div><span>',$converted_array_city);
$converted_array_city = str_replace('",<b>','</span><b>',$converted_array_city);
$converted_array_city = str_replace(',"regionName":"','<i>',$converted_array_city);
$converted_array_city = str_replace('","timezone":"','</i>',$converted_array_city);
$converted_array_city = preg_replace('#"(.+?)":#i','<ul id="\\1">',$converted_array_city);
$converted_array_city = str_replace('</div></li>','</div></li></ul>',$converted_array_city);
//echo $converted_array_city;

preg_match_all ('#<ul id="(.+?)">(.+?)<li>(.+?)<div>(.+?)</div>(.+?)<span>(.+?)</span>(.+?)<b>(.+?)</b>(.+?)<i>(.+?)</i>(.+?)</div>(.+?)</li>(.+?)</ul>#si',$converted_array_city, $event_list_reglist, PREG_SET_ORDER);
foreach ($event_list_reglist as $reg_name)
{

	if ($reg_name[6]!='')
	{
	if (preg_match('/'.$config['city_osn_name'].'/i', $reg_name[6]))
	{
		$reg_id = $reg_name[1];
	}
	}
	if ($reg_id=='') {
	if ($reg_name[8]!='')
	{
	if (preg_match('/'.$config['oblast_osn_name'].'/i', $reg_name[8]))
	{
		$reg_id = $reg_name[1];
	}
	}
	}


}

    $find[]     = "'\r'";
        $replace[]      = "";
    $find[]     = "'\n'";
        $replace[]      = "";

		if ($reg_id=='') $reg_id=0;
        $save_config[region_id]=$reg_id;

        $handler = fopen(ENGINE_DIR.'/data/import.tv.php', "w");
        fwrite($handler, "<?PHP \r\n\$confms = array (\r\n");
        foreach($save_config as $name => $value)
        {
                $value=trim(stripslashes ($value));
                $value=htmlspecialchars ($value, ENT_QUOTES, $config['charset'] );
                $value = preg_replace($find,$replace,$value);
                fwrite($handler, "'{$name}' => \"{$value}\",\r\n");
        }

        fwrite($handler, ");\r\n?>");
        fclose($handler);
}
///////
//echo $reg_id;
    if ($onsite!=true)
    {
		echo $lang['region_oblasts'].': '.$reg_id;
	}
$md4as = substr(md5($now_da),0,4);

$converted_array = @file_get_contents(ROOT_DIR.'/engine/cache/tv-program-'.$md4as.'.php');
if (!$converted_array) {

$get_tv_array = load_tv('https://tv.mail.ru/ajax/index/?region_id='.$reg_id.'&channel_type=all&date='.$now_da.'&period=all');
$converted_array = convert_unicode($get_tv_array, $config['charset']);

@file_put_contents(ROOT_DIR.'/engine/cache/tv-program-'.$md4as.'.php',$converted_array);
}

    if ($onsite!=true)
    {
		//echo '<div>https://tv.mail.ru/ajax/index/?region_id='.$reg_id.'&channel_type=all&date='.$now_da.'&period=all</div>';
		//echo trim(htmlspecialchars($converted_array));
    }

$converted_array = str_replace('""','"0"',$converted_array);
$converted_array = str_replace('/\",','',$converted_array);
$converted_array = str_replace('/\"','',$converted_array);
$converted_array = str_replace('\",','',$converted_array);
$converted_array = str_replace('\"','',$converted_array);
$converted_array = str_replace(',"passed":1','',$converted_array);
$converted_array = str_replace(',"passed":0','',$converted_array);
$converted_array = str_replace(',"onair":1','',$converted_array);
$converted_array = str_replace(',"onair":0','',$converted_array);
$converted_array = str_replace(',"has_live":1','',$converted_array);
$converted_array = str_replace(',"has_live":0','',$converted_array);

//echo $converted_array;
//preg_match('#date":{"value":"(.+?)","values":\[{"wdayname_short#is',$converted_array,$timed);
preg_match_all ('#{"channel":{"pic_url":"(.+?),"url":"(.+?)","name":"(.+?)","id":"(.+?)"},"event":\[(.+?)\]}#si',$converted_array, $event_list, PREG_SET_ORDER);
if (count($event_list)==0) preg_match_all ('#{"channel":{"pic_url":"(.+?),"url":"(.+?)","name":"(.+?)","id":"(.+?)",(.+?)},"event":\[(.+?)\]}#si',$converted_array, $event_list, PREG_SET_ORDER);
$g=0;

foreach ($event_list as $listev)
{
$g++;

if ($listev[6]) {
    $name_channel = stripslashes($listev[3]);
    $id_channel = $listev[4];
    $url_channel = $listev[2];
    $desc_chan = $listev[6];
} else {
    $name_channel = stripslashes($listev[3]);
    $id_channel = $listev[4];
    $url_channel = $listev[2];
    $desc_chan = $listev[5];
}
	//echo 1;

	$grow = $db->super_query("SELECT name FROM ".PREFIX."_tv_channel WHERE id='".$id_channel."'");
	if ($grow['name']=='' and $name_channel!='')
	{
		preg_match('#(.+?)","genre_id"#si',$name_channel,$nc);
		if ($nc[1]!='') $name_channel = $nc[1];
		$db->query("INSERT INTO ".PREFIX."_tv_channel (id, name, icon, type, description) values ('".$id_channel."', '".$name_channel."', '".$listev[1]."', '', '".$url_channel."')");
	}
    if ($onsite!=true)
    {
	echo '<table><tr><td><h2>'.$name_channel.'</h2></td><td>'.$id_channel.'</td><td>'.$url_channel.'</td></tr></table>
	<table><tr><td>ИД канала:</td><td>Название передачи:</td><td>Возрастное ограничение:</td><td>Серия название:</td><td>УРЛ передачи:</td>
	<td>ИД передачи:</td>
	<td>Время начала:</td>
	<td>Номер эпизода:</td></tr>';
    }
	echo '<h2>'.$listev[3].' (id: '.$listev[4].', url: '.$listev[2].')</h2>
	<div>'.$desc_chan.'</div>';
	preg_match_all ('#{"channel_id":"(.+?)","name":"(.+?)","genre_id":"(.+?)","episode_title":"(.+?)","url":"(.+?)","id":"(.+?)","start":"(.+?)","episode_num":"(.+?)"},#si',$desc_chan, $channel_list_info, PREG_SET_ORDER);
	if (count($channel_list_info)==0) preg_match_all ('#{"channel_id":"(.+?)","name":"(.+?)","genre_id":(.+?),"episode_title":"(.+?)","url":"(.+?)","id":"(.+?)","start":"(.+?)","episode_num":(.+?)},#si',$desc_chan, $channel_list_info, PREG_SET_ORDER);
	foreach ($channel_list_info as $channel_listev)
	{
        preg_match('#(.+?)","video":{"currency":"(.+?)","price_min":"(.+?)","price_txt":"(.+?)"},#is',$channel_listev[1],$altidname);

		if (!$altidname[1]) $channel_list_id = intval($channel_listev[1]);
		else $channel_list_id = $altidname[1];

		//echo '<b>'.$channel_list_id.'</b><br>';

		$list_name = stripslashes($channel_listev[2]);
		//$genre_name = $channel_listev[3];
		$episode_title = '';
		$url_title = $channel_listev[5];
		$id_list =  $channel_listev[6];
        preg_match('#(.+?)","our_event_id":"(.+?)#is', $channel_listev[7], $errno);
        if ($errno[2]) $channel_listev[7] = $errno[1];
		$start_list = $channel_listev[7];
		$episode_num_list = $channel_listev[8];

		///* если надо уменьшить время */
		/*$time = strtotime($now_da.' '.$start_list.':00');
		$get_minus_time = strtotime('-1 hours', $time);
		$start_list = date('H:i', $get_minus_time );*/
		///**//

		/*
		$get_tv_arrayasg = load_tv('https://tv.mail.ru/ajax/event/?id='.$id_list.'');
		$converted_arrayasf = convert_unicode($get_tv_arrayasg);
		preg_match('|mrc_title":"(.+?) — расписание на ТВ"|is', $converted_arrayasf, $i_title);
		preg_match('#"descr":"(.+?)","participants"#is', $converted_arrayasf, $i_de);
		preg_match('#"src":"(.+?)","height"#is', $converted_arrayasf, $i_img);
		*/
		//echo $list_name = $i_title[1];
		//echo $opisanie = $db->safesql(strip_tags( stripslashes($i_de[1])));
		//echo $list_img = $i_img[1];

		$grow_list_channel = $db->super_query("SELECT title FROM ".PREFIX."_tv_event WHERE date='".$now_da."' and event_id='".$id_list."'");
		if ($grow_list_channel['title']=='' and $list_name!='')
		{
			if ($timed[1]=='') $timed[1]=$now_da;
			$list_name = str_replace('\'','',$list_name);
            preg_match('#"src":"(.+?)","height"#is', $converted_arrayasf, $i_img);
			$db->query("INSERT INTO ".PREFIX."_tv_event (id, title, channel_id, `desc`, image, event_id, time_start, date) values ('', '".$list_name."', '".$channel_list_id."', '".$opisanie."', '".$list_img."', '".$id_list."', '".$start_list."', '".$timed[1]."')");
		}
    if ($onsite!=true)
    {
		echo '
		<tr><td>
		 '.$channel_list_id.'
		</td>
		<td>
		 '.$list_name.'
		</td>
		<td>
		 '.$genre_name.'
		</td>
		<td>
		 '.$episode_title.'
		</td>
		<td>
		 '.$url_title.'
		</td>
		<td>
		 <a href="https://tv.mail.ru/ajax/event/?id='.$id_list.'" target="_blank">'.$id_list.'</a>
		</td>
		<td>
		 '.$start_list.'
		</td>
		<td>
		 '.$episode_num_list.'
		</td>
		</tr>
		';
    }
//        sleep(2);
	$fdir = opendir( ENGINE_DIR . '/cache/system/' );
	while ( $file = readdir( $fdir ) ) {
		if (preg_match('/suplist_datenow/i', $file)) {
			@unlink( ENGINE_DIR . '/cache/system/' . $file );
		}
	}

	clear_cache(array('tvcustom','tvchannel'));
	}
	    if ($onsite!=true)
    {
    	echo '</table>';
    	}

}
//if ($g==0) echo $converted_array;
if ($onsite==true)
{
$now_da = date('Y-m-d');
$db->query( "DELETE FROM ".PREFIX."_tv_event WHERE date<'".$now_da."'" );
}
if ($_REQUEST['del']!='') $db->query( "DELETE FROM ".PREFIX."_tv_event WHERE id!=''" );


    @unlink( ROOT_DIR . '/engine/cache/system/teleprogramm_channel.php');

	$fdir = opendir( ENGINE_DIR . '/cache/system/' );
	while ( $file = readdir( $fdir ) ) {
		if (preg_match('/suplist_datenow/i', $file)) {
			@unlink( ENGINE_DIR . '/cache/system/' . $file );
		}
	}

	clear_cache(array('tvcustom','tvchannel'));

?>