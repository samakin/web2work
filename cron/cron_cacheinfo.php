<?php
/*
=====================================================
 DataLife Engine - by SoftNews Media Group
-----------------------------------------------------
 http://dle-news.ru/
-----------------------------------------------------
 Copyright (c) 2004,2013 SoftNews Media Group
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: cron.php
-----------------------------------------------------
 Назначение: Запуск операций по крону
=====================================================
*/

if( !defined( 'E_DEPRECATED' ) ) {

	@error_reporting ( E_ALL ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_NOTICE );

} else {

	@error_reporting ( E_ALL ^ E_DEPRECATED ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_DEPRECATED ^ E_NOTICE );

}

@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Внимание: В целях безопасности мы рекомендуем переименовать файл
cron.php в любое другое название с расширением PHP

Для работы запуска операций по расписанию необходима поддержка вашим
хостингом запуска приложений с использованием Cron более подробную
информацию о том как использовать данную функцию вы можете
получить у вашего хостинг провайдера.

Файл крона может выполнять следующие операции:

1. Созданание резервной копии базы данный. Для запуска данного режима
просто запустите файл cron.php без указания ему параметров

2. Создание карты сайты сайта. Для запуска данного режима
запустите файл с параметром cron.php?cronmode=sitemap
если используется консольный запуск скрипта, то используйте php -f cron.php sitemap

3. Оптимизация базы данных. Для запуска данного режима
запустите файл с параметром cron.php?cronmode=optimize
если используется консольный запуск скрипта, то используйте php -f cron.php optimize

4. Запуск антивируса. Для запуска данного режима
запустите файл с параметром cron.php?cronmode=antivirus
если используется консольный запуск скрипта, то используйте php -f cron.php antivirus
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Для включения поддержки запуска операций по крону вы должны
поставить значение 1 для переменной $allow_cron
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

$allow_cron = 1;

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Укажите какое количество файлов с резервной копией БД
хранить на сервере
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

$max_count_files = 5;
$cron = 1;

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Не редактируйте код который следует ниже.
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */


        if ($_REQUEST[action]=='')
        {
		define('DATALIFEENGINE', true);
		define('AUTOMODE', true);
		define('LOGGED_IN', true);

		define('ROOT_DIR', '../..');
		define('ENGINE_DIR', '../engine/');
		require_once ENGINE_DIR.'/classes/mysql.php';
		require_once ENGINE_DIR.'/data/dbconfig.php';
		require_once ENGINE_DIR.'/data/config.php';
		}
		require_once ENGINE_DIR.'/inc/include/functions.inc.php';
		require_once ENGINE_DIR.'/inc/intsystem.php';

$cat_info = get_vars ( "category" );

if (! is_array ( $cat_info )) {
	$cat_info = array ();

	$db->query ( "SELECT * FROM " . PREFIX . "_category ORDER BY posi ASC" );
	while ( $row = $db->get_row () ) {

		$cat_info[$row['id']] = array ();

		foreach ( $row as $key => $value ) {
			$cat_info[$row['id']][$key] = stripslashes ( $value );
		}

	}
	set_vars ( "category", $cat_info );
	$db->free ();
}

		set_vars( "cron", $_TIME );

if( $cron == 1 ) {
	$db->query( "DELETE FROM " . PREFIX . "_spam_log WHERE is_spammer = '0'" );
}

/*
foreach ( $cat_info as $row_clubs ) {
$sql_cron = $db->super_query( "SELECT COUNT(*) as couynt FROM " . PREFIX . "_post WHERE category = '" . $row_clubs[id] . "'" );
if ($sql_cron[couynt]=='') $sql_cron[couynt]=0;
$db->query( "UPDATE " . PREFIX . "_category SET news_number='".$sql_cron[couynt]."' WHERE id='".$row_clubs[id]."'" );
}
*/

if( $config['cache_count'] ) {
	$result = $db->query( "SELECT COUNT(*) as count, news_id FROM " . PREFIX . "_views GROUP BY news_id" );

	while ( $row = $db->get_array( $result ) ) {

		$db->query( "UPDATE " . PREFIX . "_post_extras SET news_read=news_read+{$row['count']} WHERE news_id='{$row['news_id']}'" );

	}

	$db->free( $result );
	$db->query( "TRUNCATE TABLE " . PREFIX . "_views" );

	clear_cache( array('news_', 'full_', 'rss') );

}

if( $cron == 2 ) {

	$db->query( "TRUNCATE TABLE " . PREFIX . "_login_log" );
	$db->query( "TRUNCATE TABLE " . PREFIX . "_flood" );
	$db->query( "TRUNCATE TABLE " . PREFIX . "_mail_log" );
	$db->query( "TRUNCATE TABLE " . PREFIX . "_read_log" );
	$db->query( "TRUNCATE TABLE " . PREFIX . "_spam_log" );

	$db->query( "DELETE FROM " . USERPREFIX . "_banned WHERE days != '0' AND date < '$_TIME' AND users_id = '0'" );
	@unlink( ENGINE_DIR . '/cache/system/banned.php' );

	$sql_cron = $db->query( "SELECT news_id, action FROM " . PREFIX . "_post_log WHERE expires <= '" . $_TIME . "'" );

	while ( $row = $db->get_row( $sql_cron ) ) {

		if ( $row['action'] == 1 ) {

			$db->query( "UPDATE " . PREFIX . "_post SET approve='0' WHERE id='{$row['news_id']}'" );

		} elseif ( $row['action'] == 2 ) {

			$db->query( "UPDATE " . PREFIX . "_post SET allow_main='0' WHERE id='{$row['news_id']}'" );

		} elseif ( $row['action'] == 3 ) {

			$db->query( "UPDATE " . PREFIX . "_post SET fixed='0' WHERE id='{$row['news_id']}'" );

		} else {

			$db->query( "DELETE FROM " . PREFIX . "_comments WHERE post_id='{$row['news_id']}'" );
			$db->query( "DELETE FROM " . PREFIX . "_poll WHERE news_id='{$row['news_id']}'" );
			$db->query( "DELETE FROM " . PREFIX . "_poll_log WHERE news_id='{$row['news_id']}'" );
			$db->query( "DELETE FROM " . PREFIX . "_tags WHERE news_id = '{$row['news_id']}'" );
			$db->query( "DELETE FROM " . PREFIX . "_post WHERE id='{$row['news_id']}'" );
			$db->query( "DELETE FROM " . PREFIX . "_post_extras WHERE news_id='{$row['news_id']}'" );

			$row_1 = $db->super_query( "SELECT images  FROM " . PREFIX . "_images where news_id = '{$row['news_id']}'" );

			$listimages = explode( "|||", $row_1['images'] );

			if( $row_1['images'] != "" ) foreach ( $listimages as $dataimages ) {
				$url_image = explode( "/", $dataimages );

				if( count( $url_image ) == 2 ) {

					$folder_prefix = $url_image[0] . "/";
					$dataimages = $url_image[1];

				} else {

					$folder_prefix = "";
					$dataimages = $url_image[0];

				}

				@unlink( ROOT_DIR . "/uploads/posts/" . $folder_prefix . $dataimages );
				@unlink( ROOT_DIR . "/uploads/posts/" . $folder_prefix . "thumbs/" . $dataimages );
			}

			$db->query( "DELETE FROM " . PREFIX . "_images WHERE news_id = '{$row['news_id']}'" );

			$getfiles = $db->query( "SELECT id, onserver FROM " . PREFIX . "_files WHERE news_id = '{$row['news_id']}'" );

			while ( $row_1 = $db->get_row( $getfiles ) ) {

				$url = explode( "/", $row_1['onserver'] );

				if( count( $url ) == 2 ) {

					$folder_prefix = $url[0] . "/";
					$file = $url[1];

				} else {

					$folder_prefix = "";
					$file = $url[0];

				}
				$file = totranslit( $file, false );

				if( trim($file) == ".htaccess") continue;

				@unlink( ROOT_DIR . "/uploads/files/" . $folder_prefix . $file );

			}

			$db->free( $getfiles );

			$db->query( "DELETE FROM " . PREFIX . "_files WHERE news_id = '{$row['news_id']}'" );

		}

	}

	$db->query( "DELETE FROM " . PREFIX . "_post_log WHERE expires <= '" . $_TIME . "'" );

	$db->free( $sql_cron );

	if( intval( $config['max_users_day'] ) ) {
		$thisdate = $_TIME - ($config['max_users_day'] * 3600 * 24);

		$sql_result = $db->query( "SELECT name, user_id, foto FROM " . USERPREFIX . "_users WHERE lastdate < '$thisdate' and user_group = '4'" );

		while ( $row = $db->get_row( $sql_result ) ) {

			$db->query( "DELETE FROM " . USERPREFIX . "_pm WHERE user_from = '{$row['name']}' AND folder = 'outbox'" );
			$db->query( "DELETE FROM " . USERPREFIX . "_pm WHERE user='{$row['user_id']}'" );
			$db->query( "DELETE FROM " . USERPREFIX . "_banned WHERE users_id='{$row['user_id']}'" );
			$db->query( "DELETE FROM " . USERPREFIX . "_users WHERE user_id = '{$row['user_id']}'" );
			@unlink( ROOT_DIR . "/uploads/fotos/" . $row['foto'] );
		}

		$db->free( $sql_result );

	}

	if( intval( $config['max_image_days'] ) ) {
		$thisdate = $_TIME - ($config['max_image_days'] * 3600 * 24);

		$db->query( "SELECT images  FROM " . PREFIX . "_images where date < '$thisdate' AND news_id = '0'" );

		while ( $row = $db->get_row() ) {

			$listimages = explode( "|||", $row['images'] );

			if( $row['images'] != "" ) foreach ( $listimages as $dataimages ) {
				$url_image = explode( "/", $dataimages );

				if( count( $url_image ) == 2 ) {

					$folder_prefix = $url_image[0] . "/";
					$dataimages = $url_image[1];

				} else {

					$folder_prefix = "";
					$dataimages = $url_image[0];

				}

				@unlink( ROOT_DIR . "/uploads/posts/" . $folder_prefix . $dataimages );
				@unlink( ROOT_DIR . "/uploads/posts/" . $folder_prefix . "thumbs/" . $dataimages );
			}

		}

		$db->free();

		$db->query( "DELETE FROM " . PREFIX . "_images where date < '$thisdate' AND news_id = '0'" );

		$db->query( "SELECT id, onserver FROM " . PREFIX . "_files WHERE date < '$thisdate' AND news_id = '0'" );

		while ( $row = $db->get_row() ) {

			$url = explode( "/", $row['onserver'] );

			if( count( $url ) == 2 ) {

				$folder_prefix = $url[0] . "/";
				$file = $url[1];

			} else {

				$folder_prefix = "";
				$file = $url[0];

			}
			$file = totranslit( $file, false );

			if( trim($file) == ".htaccess") continue;

			@unlink( ROOT_DIR . "/uploads/files/" . $folder_prefix . $file );

		}

		$db->query( "DELETE FROM " . PREFIX . "_files WHERE date < '$thisdate' AND news_id = '0'" );

	}

	clear_cache();

}

if( function_exists('memory_get_peak_usage') ) {
$mem_usage = memory_get_peak_usage(true);
if ($mem_usage < 1024)
echo $mem_usage." bytes";
elseif ($mem_usage < 1048576)
$memory_usage = round($mem_usage/1024,2)." кб";
else
$memory_usage = round($mem_usage/1048576,2)." мб";
}

$end1=gettimeofday();
$totaltime1 = (float)($end1['sec'] - $start1['sec']) + ((float)($end1['usec'] - $start1['usec'])/1000000);

echo "<br /><br /> Использовано памяти - ".$memory_usage."<br />Время выполнения - ".$totaltime1;
	$fdir = opendir( ENGINE_DIR . '/cache/system/' );
	while ( $file = readdir( $fdir ) ) {
				if( $file != '.' and $file != '..' and $file != '.htaccess' and $file != 'cron.php' and $file != 'allalbums.php' and $file != 'allfotos.php'
		and $file != 'categoryparid.php' and $file != 'allusermusic.php' and $file != 'firm_onportal_v1.php' and $file != 'weather_pagefull_v1.php' and $file != 'weather_portal_v1.php'
		and $file != 'catfirm_onportal_v1.php' and $file != 'banners.php' and $file != 'catdoska_onportal_v1.php' and $file != 'usergroup.php' and $file != 'all_news_post_inter	.php'
		and $file != 'category_rating.php' and $file != 'firmcomimages.php' and $file != 'firmcomvideo.php' and $file != 'garagesubscribe.php' and $file != 'obrazovanie_fakulteti_v1.php'
		and $file != 'obrazovanie_user_onportal_v1.php' and $file != 'usergarage_onportal_v1.php' and $file != 'usergarage_onportal_v1.php'  and $file != 'doskaphoto_onportal_v1.php' and $file != 'doskatype_onportal_v1.php' and $file != 'faq_cat_onportal.php'
		and $file != 'citys_onportal_v1.php' and $file != 'obrazovanie_status_v1.php' and $file != 'obrazovanie_onportal_v1.php' and $file != 'obrazovanie_form_v1.php' and $file != 'obrazovanie_user_onportal_v1.php'
		and $file != 'cityscat_onportal_v1.php' and $file != 'doska_obj.php' and $file != 'pricefirmpay_onportal_v1.php' and $file != 'count_obj.php' and $file != 'firmcomaudio.php' and $file != 'category_banki.php' and $file != 'afishacat.php'
		and $file != 'likes_all.php' and $file != 'categoryparid.php' and $file != 'holidays_onportal_v1.php' and $file != 'navigationmenu_sub.php'
		and $file != 'raions_onportal_v1.php' and $file != 'kurs.php' and $file != 'club_category.php' and $file != 'user_friendgroup.php' and $file != 'navigationlist.php' and $file != 'srcheck_onportal_v1.php'
		and $file != 'region_onportal_v1.php' and $file != 'kuhna_onportal_v1.php' and $file != 'teleprogramm_channel.php' and $file != 'teleprogramm_type.php' and $file != 'column_doska_obj.php'
		and $file != 'strani_onportal_v1.php' and $file != 'column_users.php' and $file != 'firm_onportal_v1.php' and $file != 'firm_onportal_mini.php' and $file != 'column_market_obj.php' and $file != 'faq_expert_onportal.php'
		and $file != 'allalbums.php' and $file != 'allfotos.php' and $file != 'allusermusic.php' and $file != 'automarka_onportal_v1.php' and $file != 'automodel_onportal_v1.php'
		and $file != 'categoryparid.php' and $file != 'blocks.php' and $file != 'navigationmenu.php' and $file != 'modules.php' and $file != 'modules_admin.php' and $file != 'faq_cat_onportal.php'
		and $file != 'user_ishu.php' and $file != 'doskaphoto_onportal_v1.php' and $file != 'photoprofile.php' and $file != 'count_vak.php' and $file != 'count_res.php' and $file != 'userlist_allmini.php'
		and $file != 'userlist_allmini2.php' and $file != 'sp_all_video.php' and $file != 'sp_all_video_cat.php' and $file != 'fotoconcurs_onportal_v1.php' and $file != 'imagespost_onportal_v1.php'
		and $file != 'allcatfoto.php' and $file != 'catforum_onportal_v1.php' and $file != 'marketcat_v1.php' and $file != 'navigation_lands.php' and $file != 'weather_pagefull_v1.php' and $file != 'navigationmenu.php' and $file != 'modules.php'
		and $file != 'usersubscribe.php' ) {
		if (preg_match('/weather_p/i', $file)=='' and preg_match('/com_user_onportal_/i', $file)=='' and preg_match('/all_news_post_/i', $file)=='' and preg_match('/userlist_/i', $file)=='' and preg_match('/friend_/i', $file)=='' and preg_match('/user_/i', $file)=='')
		{
			@unlink( ENGINE_DIR . '/cache/system/' . $file );
		}
		}
	}

	clear_cache();
clear_cache();
?>