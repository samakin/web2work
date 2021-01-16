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

include (ENGINE_DIR.'/data/import.flamp.php');
require_once (ENGINE_DIR.'/inc/imports/functions_flamp.php');

require_once ENGINE_DIR .'/init.php';
require_once ENGINE_DIR .'/classes/parse.class.php';

if ($confms[link_city]!='')
{

$link = $confms[link_city];
$start1=gettimeofday();
$conts = 0;
$cat_info_firm = get_vars ( "catfirm_onportal_v1");
foreach ( $cat_info_firm as $row_club ) {

	if ($row_club['sub']!='' and $row_club['sub']!='0') {

		    $gmd = md5($row_club[category]);
			if (!@fopen(ENGINE_DIR.'/cache/flamp_auto_'.$gmd.'.tmp', 'r'))
			{
				$conts++;
				if ((($_REQUEST['limit']!='' and $conts<=$_REQUEST['limit'])) or ($_REQUEST['limit']=='')) {

					$url_p = $link.'search/'.win2utf($row_club[category]).'/';
					$pars_film = load_page($url_p, $refer);
				    //echo $url_p;
					$pars_film = convert_unicode($pars_film);
				    //echo $pars_film;

					preg_match_all('#<a class="pagination__link pagination__link--page"(.*?)href="(.*?)">(.*?)</a>#is', $pars_film, $gorod, PREG_SET_ORDER);
				    $pagecon=0;
				    foreach ($gorod as $g)
				    {

						$url_gzz = 'http:'.$g[2];
						echo $url_gzz;
					    $pagecon++;
					    $get_con = get_firmcontent($url_gzz, $cat, $g[3]);

				    }
			    file_put_contents(ENGINE_DIR.'/cache/flamp_auto_'.$gmd.'.tmp', $url_p);
		    }
	 	}
	}
	$colvo = 0;

        $results = $db->query("SELECT * FROM pmd_users WHERE login='flamp_none' and ip!=''");
        while ($rows = $db->get_row($results)){

        $colvo++;

        $mdcache[$colvo] = md5($rows[ip]);

		if (!$pars_film = @file_get_contents(ENGINE_DIR.'/cache/2gis/'.$mdcache[$colvo].'.tmp')) {
			preg_match('#(.*?)/firm/(.*?)#i', $rows['ip'], $link_new);
			$lnew = 'http:'.$rows['ip'];
			$pars_film_orig = load_page($lnew, $refer); /// подружаем страницу с описанием
		    $pars_film = convert_unicode($pars_film_orig);
		    file_put_contents(ENGINE_DIR.'/cache/2gis/'.$mdcache[$colvo].'.tmp', $pars_film);
		}

		preg_match('#<cat-entities-filial-info-row(.*?)data-key="rubrics"(.*?)<ul class="list list--dotted filial-info-row__list">(.*?)</ul>(.*?)</cat-entities-filial-info-row>#is', $pars_film, $category_ul);
		preg_match_all('#<a class="link js-link" href="(.*?)">(.*?)</a>#is', $category_ul[3], $category, PREG_SET_ORDER);

	    $catarray = array();
	    $origcat = array();
	    foreach ($category as $g)
	    {
		    foreach ( $cat_info_firm as $row_club ) {
				if ($row_club[category]==$g[2])
				{
					$gnamecat = $row_club['selector'];
					$catarray[] = $gnamecat;
					$origcat[] = $row_club['category'];
					$db->query("UPDATE `pmd_category` SET `fcounter` = fcounter + 1 WHERE selector = '".$gnamecat."' ");
				}
			}

	    }
		$categoryimplode[$colvo] = implode("#",$catarray);

		if ($categoryimplode[$colvo]=='')
		{

	    $catarray = array();
	    $origcat = array();

		    foreach ( $cat_info_firm as $row_club ) {
				if ($row_club[category]==$_GET['cat'])
				{
					$gnamecat = $row_club['selector'];
					$catarray[] = $gnamecat;
					$origcat[] = $row_club['category'];
					$db->query("UPDATE `pmd_category` SET `fcounter` = fcounter + 1 WHERE selector = '".$gnamecat."' ");
				}
			}
			$categoryimplode[$colvo] = implode("#",$catarray);
		}


        preg_match('#<meta itemprop="telephone" content="(.*?)"/>#is', $pars_film, $phone);
        $phone[1] = str_replace('?','-',$phone[1]);
        preg_match('#class="link js-link">(.*?)</a>#is', $pars_film, $rww);
        //preg_match('#<div class="clearfix" id="about">(.*?)<div class="content-col-1">(.*?)</div>#is', $pars_film, $business);
        preg_match('#<span class="project__name">(.*?)</span>#is', $pars_film, $city);
        preg_match('#data-lat="(.*?)"(.*?)data-lon="(.*?)">#is', $pars_film, $geos);
		preg_match('#<meta itemprop="streetAddress" content="(.*?)">#is', $pars_film, $adresa);
		$address = $city[1].', '.$adresa[1];


        	$geo[lat]=$geos[1];
        	$geo[lng]=$geos[3];


        if ($rows['city']=='') $city_db = "city='".$city[1]."',";

		preg_match_all('#<div class="filial-timetable__day-name">(.*?)</div>(.*?)<div class="filial-timetable__day-period">(.*?)<br>(.*?)</div>#is', $pars_film, $vrema, PREG_SET_ORDER);

	    $vremaarray = array();
	    foreach ($vrema as $v)
	    {
			$vremaarray[] = $v['1'].' '.$v['3'].'-'.$v['4'].'';
	    }
	    $vremaimplode[$colvo] = implode(";",$vremaarray);

        //$business[2] = $db->safesql( trim($parse->process($business[2])));
        if ($rww[1]!='') $rww[1] = 'http://'.$rww[1];

        $db->query("UPDATE pmd_users set ".$city_db." category='".$categoryimplode[$colvo]."', firmstate='on', address='".$address."', business='".$business[2]."', lat='".$geo[lat]."', lng='".$geo[lng]."', phone='".$phone[1]."', `www`='".$rww[1]."', vrema='".$vremaimplode[$colvo]."', login='flamp' where selector='".$rows['selector']."'");

        $ocat = implode(',',$origcat);

echo <<<HTML
<tr><td><a href="/firm/{$rows['selector']}/">{$rows[firmname]}</a></td><td>{$ocat}</td><td><a href="#">Выгрузить отзывы</a> <a href="{$rows[ip]}">Смотреть на Flamp</a></td><td><input type="checkbox" value="{$rows[ip]}" name="selected_doska_obj[]"></td></tr>
HTML;

sleep(1);

}
}

@unlink( ENGINE_DIR . '/cache/system/firm_onportal_v1.php' );


}
else
{
	$i ='Не выбраны параметры нужного города в настройках импорта.';
	echo $i;
}

?>