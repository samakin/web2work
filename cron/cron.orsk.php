<?php
/*
==============================================================================
 Веб-Система "Web2Work" разработка Кривоногова Евгения Эдуардовича
------------------------------------------------------------------------------
 http://web2work.ru - официальная страница продажи веб-системы
 http://vkontakte.ru/club13001075 - официальная страница поддержки проекта
 http://www.youtube.com/channel/UCs1yzsO9earP5yOXiMLGclw - Видео презентации
-----------------------------------------------------------------------------
 Copyright (c) 2008-2015, Разработка Кривоногова Евгения Эдуардовича
=============================================================================
 Данный код защищен авторскими правами
=============================================================================
*/

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
@ini_set('display_errors', false);
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

include (ENGINE_DIR.'/data/import.orsk.php');
require_once (ENGINE_DIR.'/inc/imports/functions_orsk.php');

require_once ENGINE_DIR .'/init.php';
require_once ENGINE_DIR .'/classes/parse.class.php';

if ($confms[link_city]!='')
{

$link = $confms[link_city];
$start1=date('Y-m-d');
$conts = 0;

		$mdcache = md5($confms[link_city].$start1);

		if (!$afile = file_get_contents(ENGINE_DIR.'/cache/2gis/orskimport_'.$mdcache.'.tmp')) {
			$afile = load_page($confms[link_city]); /// подружаем страницу с описанием
		    file_put_contents(ENGINE_DIR.'/cache/2gis/orskimport_'.$mdcache.'.tmp', $afile);
		}

    $b++;
    $get_content = preg_match('#<div class="main_categories_list">(.*?)</div>#is', $afile, $pages_lis);
	$strps = @preg_match_all('#<li><a href="(.*?)category_id=(.*?)">(.*?)</a></li>#i', $pages_lis[1], $pages_lise, PREG_SET_ORDER);
    $b=0;
    foreach ($pages_lise as $pagings)
    {
    $b++;
    echo '<br>Выгрузка страницы '.convert_unicode($pagings[3]);
    $mdcaches = md5($pagings[3]);
    if (!$gogod = file_get_contents(ENGINE_DIR.'/cache/2gis/orskimportobj'.$mdcaches.'.tmp')) {
    $results_type = $db->super_query("SELECT id, type FROM " . PREFIX . "_doska_cat WHERE name LIKE '%".convert_unicode($pagings[3])."%'");
    //echo '<br>'.convert_unicode($pagings[2]);
    $gogod = get_autoobjes($confms[link_city], convert_unicode($pagings[2]), $results_type['id'], $results_type[type]);
	file_put_contents(ENGINE_DIR.'/cache/2gis/orskimportobj'.$mdcaches.'.tmp', $gogod);
	echo '<br><h2>Попыка выгрузки</h2>';
	echo $gogod;
	}

    }


}
else
{
	$i ='Не выбраны параметры нужного города в настройках импорта.';
	echo $i;
}

?>