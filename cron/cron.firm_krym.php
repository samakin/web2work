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

include (ENGINE_DIR.'/data/import.bizly.php');
require_once (ENGINE_DIR.'/inc/imports/functions_bizly.php');

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
			if (!@fopen(ENGINE_DIR.'/cache/bizly_auto_'.$gmd.'.tmp', 'r'))
			{
				$conts++;
				if ((($_REQUEST['limit']!='' and $conts<=$_REQUEST['limit'])) or ($_REQUEST['limit']=='')) {

					$url_p = $link.'search/'.win2utf($row_club[category]).'/';
					$pars_film = load_page($url_p, $refer);
                    if ($pars_film=='') $pars_film = file_get_contents($url_p);
				    //echo $url_p;
					$pars_film = convert_unicode($pars_film);
				    //echo $pars_film;

                    preg_match('#<div class="text-center-sm">(.*?)</div>#is', $pars_film, $pageinlust);
                    preg_match_all('#<li><a href="(.*?)">(.*?)</a></li>#is', $pageinlust[1], $gorod, PREG_SET_ORDER);
                    $pagecon=0;
                    foreach ($gorod as $g)
                    {

                        $url_gzz = $g[1];
                        $pagecon++;
                        $get_con = get_firmcontent($url_gzz, $cat, $g[2]);

                    }

                    if ($pagecon==0) {
                        $url_gzz = $url_p;
                        $pagecon++;
                        $get_con = get_firmcontent($url_gzz, $cat, '1');
                    }

			    file_put_contents(ENGINE_DIR.'/cache/bizly_auto_'.$gmd.'.tmp', $url_p);
		    }
	 	}
	}
	$colvo = 0;

        $results = $db->query("SELECT * FROM pmd_users WHERE login='bizly_none' and ip!=''");
        while ($rows = $db->get_row($results)){

        $colvo++;

        $mdcache[$colvo] = md5($rows[ip]);

            if (!$pars_film = file_get_contents(ENGINE_DIR . '/cache/2gis/' . $mdcache[$colvo] . '.tmp')) {
                preg_match('#(.*?)/firm/(.*?)#i', $rows['ip'], $link_new);
                $lnew = $rows['ip'];
                $pars_film_orig = load_page($lnew, $refer); /// подружаем страницу с описанием
                if ($pars_film_orig == '') $pars_film_orig = file_get_contents($lnew);
                $pars_film = convert_unicode($pars_film_orig);
                file_put_contents(ENGINE_DIR . '/cache/2gis/' . $mdcache[$colvo] . '.tmp', $pars_film);
            }

            /* отладка
            $lnew = "http://sevastopol.bizly.ru/1451785526-avto-spas-sevastopol/";
            $pars_film_orig = load_page($lnew, $refer); /// подружаем страницу с описанием
            if ($pars_film_orig == '') $pars_film_orig = file_get_contents($lnew);
            $pars_film = convert_unicode($pars_film_orig);
            //echo $pars_film;*/

            preg_match('#Категория:</div>(.*?)<div class="warn-text">#is', $pars_film, $category_ul);
            //echo $category_ul[1];

            preg_match_all('#<a href="(.*?)">(.*?)</a>#is', $category_ul[1], $category, PREG_SET_ORDER);
            ///print_r($category);

            $catarray = array();
            $origcat = array();
            foreach ($category as $g) {

                $cat_info_firm = get_vars ( "catfirm_onportal_v1" );
                if (! is_array ( $cat_info_firm )) {
                    $cat_info_firm = array();
                    $tr = $db->query("SELECT * FROM pmd_category ORDER BY top ASC");
                    $key = 0;
                    while ($row = $db->get_row($tr)) {

                        $key++;
                        $cat_info_firm[$key] = array();
                        $cat_info_firm[$key] = array(
                            'selector' => $row['selector'],
                            'category' => $row['category'],
                            'sccounter' => $row['sccounter'],
                            'ssccounter' => $row['ssccounter'],
                            'fcounter' => $row['fcounter'],
                            'alt_name' => $row['alt_name'],
                            'top' => $row['top'],
                            'ip' => $row['ip'],
                            'parentid' => $row[parentid],
                            'sub' => $row[sub],
                            'alt_name' => $row[alt_name],
                            'ico' => $row[ico]
                        );
                    }

                    $db->free();
                    set_vars("catfirm_onportal_v1", $cat_info_firm);
                }

                //echo 1;
                foreach ($cat_info_firm as $row_club) {
                    $g[2] = str_replace(' Севастополя','',$g[2]);
                    if (mb_strpos($row_club[category], $g[2])!== false) {
                        echo 'Найдено совпадение категории';
                        //   echo $gnamecat = $row_club['selector'];
                        $catarray[] = $gnamecat;
                        $origcat[] = $row_club['category'];
                        $db->query("UPDATE `pmd_category` SET `fcounter` = fcounter + 1 WHERE selector = '" . $gnamecat . "' ");
                    } else {
                        echo 'Не найдено категории';
                    }
                }

            }
            $categoryimplode[$colvo] = implode("#", $catarray);

            if ($categoryimplode[$colvo] == '') {

                $cat_info_firm = get_vars ( "catfirm_onportal_v1" );
                if (! is_array ( $cat_info_firm )) {
                    $cat_info_firm = array();
                    $tr = $db->query("SELECT * FROM pmd_category ORDER BY top ASC");
                    $key = 0;
                    while ($row = $db->get_row($tr)) {

                        $key++;
                        $cat_info_firm[$key] = array();
                        $cat_info_firm[$key] = array(
                            'selector' => $row['selector'],
                            'category' => $row['category'],
                            'sccounter' => $row['sccounter'],
                            'ssccounter' => $row['ssccounter'],
                            'fcounter' => $row['fcounter'],
                            'alt_name' => $row['alt_name'],
                            'top' => $row['top'],
                            'ip' => $row['ip'],
                            'parentid' => $row[parentid],
                            'sub' => $row[sub],
                            'alt_name' => $row[alt_name],
                            'ico' => $row[ico]
                        );
                    }

                    $db->free();
                    set_vars("catfirm_onportal_v1", $cat_info_firm);
                }

                $catarray = array();
                $origcat = array();

                foreach ($cat_info_firm as $row_club) {
                    // echo $_GET['cat'];
                    //echo $row_club[category];
                    $explcat = explode(' ',$rows['firmname']);
                    if (($key = array_search($row_club[category], $explcat)) !== false) {
                        $gnamecat = $row_club['selector'];
                        $catarray[] = $gnamecat;
                        $origcat[] = $row_club['category'];
                        $db->query("UPDATE `pmd_category` SET `fcounter` = fcounter + 1 WHERE selector = '" . $gnamecat . "' ");
                    }
                }
                $categoryimplode[$colvo] = implode("#", $catarray);
            }

            preg_match('#Телефон:</div>(.*?)<div class="col-sm-8">(.*?)</div>#is', $pars_film, $phone);
            $phone[2] = str_replace('?', '-', $phone[2]);
            preg_match('#Сайт:</div>(.*?)<div class="col-sm-8"><a rel="nofollow" target="_blank" href="(.*?)">(.*?)</a></div>#is', $pars_film, $rww);
            preg_match('#<p class="description">(.*?)<ul class="related">#is', $pars_film, $business);
            preg_match('#<span class="header-item header-city">(.*?)<span class="hidden-xs">(.*?)</span>(.*?)<span class="header-item header-add pull-right">#is', $pars_film, $city);
            preg_match('#coordinates: [(.*?),(.*?)],#is', $pars_film, $geos);
            preg_match('#Адрес:</div>(.*?)<div class="col-sm-8">(.*?)</div>#is', $pars_film, $adresa);
            $adresa[2] = str_replace($city[2].', ','',$adresa[2]);
            $address = $adresa[2];

            if ($geos[1] == '') $geo = get_latlng($address);
            else {
                $geo[lat] = $geos[1];
                $geo[lng] = $geos[2];
            }

            if ($rows['city'] == '') $city_db = "city='" . $city[2] . "',";


            preg_match('#График:</div>(.*?)<div class="col-sm-8">(.*?)</div>#is', $pars_film, $geosasca);
            preg_match_all('#(.*?) (.*?)-(.*?),#is', $geosasca[2], $vrema, PREG_SET_ORDER);

            $vremaarray = array();
            foreach ($vrema as $v) {
                $vremaarray[] = $v['1'] . ' ' . $v['3'] . '-' . $v['4'] . '';
            }
            $vremaimplode[$colvo] = implode(";", $vremaarray);

            //$business[1] = $db->safesql(trim($parse->process($business[1])));
            if ($rww[2] != '') $rww[2] = $rww[2];

            $db->query("UPDATE pmd_users set " . $city_db . " category='" . $categoryimplode[$colvo] . "', firmstate='on', address='" . $address . "', business='" . $business[1] . "', lat='" . $geo[lat] . "', lng='" . $geo[lng] . "', phone='" . $phone[2] . "', `www`='" . $rww[1] . "', vrema='" . $vremaimplode[$colvo] . "', login='bizly' where selector='" . $rows['selector'] . "'");

            $ocat = implode(',', $origcat);

echo <<<HTML
<tr><td><a href="/firm/{$rows['selector']}/">{$rows[firmname]}</a></td><td>{$ocat}</td><td><a href="#">Выгрузить отзывы</a> <a href="{$rows[ip]}">Смотреть на bizly</a></td><td><input type="checkbox" value="{$rows[ip]}" name="selected_doska_obj[]"></td></tr>
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