<?php

$distr_charset = "windows-1251";
$db_charset = "cp1251";

header("Content-type: text/html; charset=".$distr_charset);

if ($_REQUEST[action]=='')
{
define('DATALIFEENGINE', true);
define('ROOT_DIR',dirname(dirname(__FILE__)));
define('ENGINE_DIR',ROOT_DIR .'/engine');

include ENGINE_DIR.'/data/config.php';
require_once ENGINE_DIR.'/classes/mysql.php';
require_once ENGINE_DIR.'/data/dbconfig.php';
}

@error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('set_time_limit', '0');
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

if (!date_default_timezone_get()) {
    date_default_timezone_set('Asia/Yekaterinburg');
}

@ini_set ('memory_limit',"328M");
@set_time_limit (0);
@ini_set ('max_execution_time',0);
@ini_set ('3048M');
@ini_set ('output_buffering','off');
@ob_end_clean ();
clearstatcache ();
ob_implicit_flush (TRUE);

include (ENGINE_DIR.'/data/import.kinoafisha.php');
require_once (ENGINE_DIR.'/data/block_afisha_config.php');
require_once ENGINE_DIR .'/init.php';
require_once ENGINE_DIR .'/classes/parse.class.php';
$parse = new ParseFilter (array (),array (),1,1);

$nd = array();
$nd[]='rss';
$nd[]='cron';

$tab_id=2>count(array_slice($nd, 2))?false:true;
$tab_id=true;

require_once ENGINE_DIR .'/inc/plugins/rss.classes.php';
require_once ENGINE_DIR .'/inc/plugins/rss.functions.php';
require_once ENGINE_DIR .'/inc/plugins/rss.parser.php';
require_once (ENGINE_DIR.'/inc/imports/functions_afisha.php');
$cron_file=1;

if ($confms[city]!='')
{

$rss_cron_array = get_vars('cron.afisha');
if (!$rss_cron_array)$rss_cron_array = array();
$rss_cron_data = get_vars('cron.afisha.data');
if (!$rss_cron_data) $rss_cron_data = array();

if ($_GET[onlyfoto]=='') $_GET[onlyfoto] = $confms['imp_foto'];
if ($_GET[city]=='') $_GET[city] = $confms['city'];
if ($_GET[doska_cat]=='') $_GET[doska_cat] = $confms['doska_cat'];

   if ($confms[city]!='') $confms[city] = $confms['city'];
   else $confms[city] = 'http://www.afisha.ru/ekaterinburg/';

  // Вычисляем число дней в текущем месяце
  $dayofmonth = date('t');
  // Счётчик для дней месяца
  $day_count = date('d');
  // 1. Первая неделя
  $num =0;
  for($i = 0; $i < 7; $i++)
  {
    // Вычисляем номер дня недели для числа
    $dayofweek = date('w',
                      mktime(0, 0, 0, date('m'), $day_count, date('Y')));
    // Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
    $dayofweek = $dayofweek - 1;

      // Если дни недели совпадают,
      // заполняем массив $week
      // числами месяца
      $week[$num][$i] = $day_count;
      $day_count++;

  }

  // 3. Выводим содержимое массива $week
  // в виде календаря
  // Выводим таблицу
  //echo $dayofmonth;
$start1=gettimeofday();
$i=0;

for ($x=0;$x<2;$x++){
$i=0;
  foreach($week as $wk)
  {
  	foreach ($wk as $w)
  	{
    //echo 1;
      if($w!='')
      {
        if ($w<=9 and $w!=date('d')) $w='0'.$w;

		$grabber = false;
		if (count($week) == 0) break;
		if ( count($rss_cron_array) >= count($week) ) $rss_cron_array = array();
		$channel_id = $w;
		$found = in_array($channel_id,$rss_cron_array);
		if (!$found) {
		++$i;
		//var_export ($rss_cron_array);
		$rss_cron_array[] = $channel_id;
		$data_cron = time() - $rss_cron_data[$channel_id];
		$dnast = explode ('=','1=1=1=1=1=0=0=0=1=1=1=1=1=1=1=60=');
		if (intval($dnast[16]) != 0)$cron_data = $dnast[16]*60;
			else $cron_data = 0;
		if ($data_cron >= $cron_data)
			{
		$rss_cron_data[$channel_id] = time();

		set_vars('cron.afisha.data',$rss_cron_data);
		set_vars('cron.afisha',$rss_cron_array);

		if ( count($rss_cron_array) >= count($week) ) $rss_cron_array = array();

		if($config_rss['get_prox'] = $tab_id) {
			$grabber = add_raspisanie($confms[city], "".date('Y-m-')."".$w);
			$i='<div>Записи расписаний кино выгружены от '."".date('Y-m-')."".$w."</div>";
			print_r($i);
		}else{
		$cron_dop_time = $cron_data - $data_cron;
		echo "<B><font color=#993300>№".$channel_id." ".date('Y-m-')."".$w."</font></B> оставшееся время для следующего запуска".date( "i:s",$cron_dop_time)."<br />";
		set_vars('cron.afisha',$rss_cron_array);
		}

		}
	}
	if($grabber == true) break;
   }
   }
   }
}
}
else
{
	$i ='Не выбраны параметры в настройках импорта. Киносеансы не могут быть добавлены.';
	print_r($i);
}
//clear_cache();
?>