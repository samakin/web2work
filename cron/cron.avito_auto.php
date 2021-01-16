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

@ini_set ('memory_limit',"328M");
@set_time_limit (0);
@ini_set ('max_execution_time',0);
@ini_set ('3048M');
@ini_set ('output_buffering','off');
@ob_end_clean ();
clearstatcache ();
ob_implicit_flush (TRUE);

include (ENGINE_DIR.'/data/import.avitonew.php');
require_once (ENGINE_DIR.'/inc/imports/functions_avito.php');

require_once ENGINE_DIR.'/modules/functions.php';
require_once ENGINE_DIR .'/classes/parse.class.php';
echo 'Подготовка к выгрузке';
if ($confms[link_city]!='')
{
$link = $confms[link_city];
$pli = '188.243.79.125:8081';
//$pli = '87.224.251.121:8080';
$refer = 'http://e1.ru';
$start1=date('Y-m-d');
$conts = 0;
echo 'Начало выгрузки';
		$mdcache = md5($confms[link_city].$start1);
		if (!$afile = @file_get_contents(ENGINE_DIR.'/cache/avitoimport_'.$mdcache.'.tmp')) {
			$afile = load_page($confms[link_city], $refer, '', '', '', '', $pli);
		    file_put_contents(ENGINE_DIR.'/cache/avitoimport_'.$mdcache.'.tmp', $afile);
		}

	$strps = @preg_match_all('#<div class="category-map">(.*?)<div class="l-footer(.*?)">#is', $afile, $pages_li, PREG_SET_ORDER);
    $b=0;
    foreach ($pages_li as $paging)
    {
        echo 'Открытие разделов';
    $b++;
	$strps = @preg_match_all('#<a href="/(.*?)/(.*?)" title="(.*?)">(.*?)</a>#is', $paging[1], $pages_lis, PREG_SET_ORDER);
    $b=0;
        shuffle($pages_lis);
    foreach ($pages_lis as $pagings)
    {
    sleep(1);
    $b++;
    $mdcaches = md5($start1.$pagings[4]);

    if ($b==3) {

        if (!$gogod = @file_get_contents(ENGINE_DIR . '/cache/avitoimportobj' . $mdcaches . '.tmp')) {

            $results_type = $db->super_query("SELECT id, type FROM " . PREFIX . "_doska_cat WHERE name LIKE '%" . $pagings[4] . "%'");

            $gogod = get_autoobjes($confms[link_city], $pagings[2], $results_type['id'], $results_type[type], $pli);

            file_put_contents(ENGINE_DIR . '/cache/avitoimportobj' . $mdcaches . '.tmp', $gogod);

            sleep(2);
        }
    }
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