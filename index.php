<?php
/*
=====================================================
 DataLife Engine - by SoftNews Media Group
-----------------------------------------------------
 http://dle-news.ru/
-----------------------------------------------------
 Copyright (c) 2004,2015 SoftNews Media Group
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: index.php
-----------------------------------------------------
 Назначение: Главная страница
=====================================================
*/

@ob_start ();
@ob_implicit_flush ( 0 );

if( !defined( 'E_DEPRECATED' ) ) {

	@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

} else {

	@error_reporting ( E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );

}

@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );

define ( 'DATALIFEENGINE', true );

$member_id = FALSE;
$is_logged = FALSE;

define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );

if (!date_default_timezone_get()) {
	date_default_timezone_set('Asia/Yekaterinburg');
}

$distr_charset = "windows-1251";
$db_charset = "cp1251";

header("Content-type: text/html; charset=".$distr_charset);

require_once ROOT_DIR . '/engine/init.php';

/////////////// WEB2WORK GROUP TAG ////////////////////

//require_once ROOT_DIR. '/engine/modules/content/antiddos/antiddos.php';
require_once ROOT_DIR.'/engine/inc/main_conf/glav_block_mod.php';

/////////////// WEB2WORK GROUP TAG ////////////////////

if (clean_url ( $_SERVER['HTTP_HOST'] ) != clean_url ( $config['http_home_url'] )) {

	$replace_url = array ();
	$replace_url[0] = clean_url ( $config['http_home_url'] );
	$replace_url[1] = clean_url ( $_SERVER['HTTP_HOST'] );

} else
	$replace_url = false;

////////////// ПОДГРУЖАЕМАЯ ГЛАВНАЯ СТРАНИЦА ////////
$tpl->load_template ('main.tpl');

$tpl->set ( '{calendar}', $tpl->result['calendar'] );
$tpl->set ( '{archives}', $tpl->result['archive'] );
$tpl->set ( '{tags}', $tpl->result['tags_cloud'] );
$tpl->set ( '{vote}', $tpl->result['vote'] );
$tpl->set ( '{topnews}', $tpl->result['topnews'] );
$tpl->set ( '{login}', $tpl->result['login_panel'] );
$tpl->set ( '{info}',  $tpl->result['info'] );
$tpl->set ( '{speedbar}', $tpl->result['speedbar'] );

if ( $dle_module == "showfull" ) {

	$tpl->set( '[related-news]', "" );
	$tpl->set( '[/related-news]', "" );
	$tpl->set( '{related-news}', $related_buffer );

} else {

	$tpl->set( '{related-news}', "" );
	$tpl->set_block( "'\\[related-news\\](.*?)\\[/related-news\\]'si", "" );

}

///require_once ROOT_DIR.'/engine/modules/total_time_query.php';

/////////////// WEB2WORK GROUP TAG ////////////////////

require_once ROOT_DIR.'/engine/inc/main_conf/glav_tpl_set.php';

/////////////// WEB2WORK GROUP TAG ////////////////////

if ($config['allow_skin_change'] == "yes") $tpl->set ( '{changeskin}', ChangeSkin ( ROOT_DIR . '/templates', $config['skin'] ) );

if (count ( $banners ) and $config['allow_banner']) {

	foreach ( $banners as $name => $value ) {
		$tpl->copy_template = str_replace ( "{banner_" . $name . "}", $value, $tpl->copy_template );
		if ( $value ) {
			$tpl->copy_template = str_replace ( "[banner_" . $name . "]", "", $tpl->copy_template );
			$tpl->copy_template = str_replace ( "[/banner_" . $name . "]", "", $tpl->copy_template );
		}
	}

}

if ($member_id[user_group]==1)
{
$tpl->set_block ( "'{banner_(.*?)}'si", "В данном месте находится {banner_\\1} тег для размещения рекламы." );
$tpl->set_block ( "'\\[banner_(.*?)\\](.*?)\\[/banner_(.*?)\\]'si", "" );
}
else
{
$tpl->set_block ( "'{banner_(.*?)}'si", "" );
$tpl->set_block ( "'\\[banner_(.*?)\\](.*?)\\[/banner_(.*?)\\]'si", "" );
}
/////////////// WEB2WORK GROUP TAG ////////////////////

        if ($config['tip_main']!='2') {
        $tpl->set('[foto_main]',"");
        $tpl->set('[/foto_main]',"");
                }
        else $tpl->set_block("'\\[foto_main\\](.*?)\\[/foto_main\\]'si","");

        if ($config['tip_main']=='2') {
        $tpl->set('[tofoto_main]',"");
        $tpl->set('[/tofoto_main]',"");
                }
        else $tpl->set_block("'\\[tofoto_main\\](.*?)\\[/tofoto_main\\]'si","");

/////////////// WEB2WORK GROUP TAG ////////////////////

if (count ( $informers ) and $config['rss_informer']) {
	foreach ( $informers as $name => $value ) {
		$tpl->copy_template = str_replace ( "{inform_" . $name . "}", $value, $tpl->copy_template );
	}
}

if ($allow_active_news AND $news_found AND $config['allow_change_sort'] AND $do != "userinfo") {

	$tpl->set ( '[sort]', "" );
	$tpl->set ( '{sort}', news_sort ( $do ) );
	$tpl->set ( '[/sort]', "" );

} else {

	$tpl->set_block ( "'\\[sort\\](.*?)\\[/sort\\]'si", "" );

}

include(ENGINE_DIR."/modules/templates_universal.php");

$config['http_home_url'] = explode ( "index.php", strtolower ( $_SERVER['PHP_SELF'] ) );
$config['http_home_url'] = reset ( $config['http_home_url'] );

if (! $user_group[$member_id['user_group']]['allow_admin']) $config['admin_path'] = "";

$ajax .= <<<HTML
{$pm_alert}<script type="text/javascript">
<!--
var dle_root       = '{$config['http_home_url']}';
var dle_admin      = '{$config['admin_path']}';
var dle_login_hash = '{$dle_login_hash}';
var dle_group      = {$member_id['user_group']};
var dle_skin       = '{$config['skin']}';
var dle_wysiwyg    = '{$config['allow_comments_wysiwyg']}';
var quick_wysiwyg  = '{$config['allow_quick_wysiwyg']}';
var dle_act_lang   = ["{$lang['p_yes']}", "{$lang['p_no']}", "{$lang['p_enter']}", "{$lang['p_cancel']}", "{$lang['p_save']}", "{$lang['p_del']}", "{$lang['ajax_info']}"];
var menu_short     = '{$lang['menu_short']}';
var menu_full      = '{$lang['menu_full']}';
var menu_profile   = '{$lang['menu_profile']}';
var menu_send      = '{$lang['menu_send']}';
var menu_uedit     = '{$lang['menu_uedit']}';
var dle_info       = '{$lang['p_info']}';
var dle_confirm    = '{$lang['p_confirm']}';
var dle_prompt     = '{$lang['p_prompt']}';
var dle_req_field  = '{$lang['comm_req_f']}';
var dle_del_agree  = '{$lang['news_delcom']}';
var dle_spam_agree = '{$lang['mark_spam']}';
var dle_complaint  = '{$lang['add_to_complaint']}';
var dle_big_text   = '{$lang['big_text']}';
var dle_orfo_title = '{$lang['orfo_title']}';
var dle_p_send     = '{$lang['p_send']}';
var dle_p_send_ok  = '{$lang['p_send_ok']}';
var dle_save_ok    = '{$lang['n_save_ok']}';
var dle_reply_title= '{$lang['reply_comments']}';
var dle_tree_comm  = '{$dle_tree_comments}';
var dle_del_news   = '{$lang['news_delnews']}';\n
HTML;

if ($user_group[$member_id['user_group']]['allow_all_edit']) {

	$ajax .= <<<HTML
var dle_notice     = '{$lang['btn_notice']}';
var dle_p_text     = '{$lang['p_text']}';
var dle_del_msg    = '{$lang['p_message']}';
var allow_dle_delete_news   = true;\n
HTML;

} else {

	$ajax .= <<<HTML
var allow_dle_delete_news   = false;\n
HTML;

}

if ($config['fast_search'] AND $user_group[$member_id['user_group']]['allow_search']) {

	$ajax .= <<<HTML
var dle_search_delay   = false;
var dle_search_value   = '';
HTML;

	$onload_scripts[] = "FastSearch();";

}

if (strpos ( $tpl->result['content'], "<pre" ) !== false) {

	$js_array[] = "engine/classes/highlight/highlight.code.js";
	$onload_scripts[] = "$('pre code').each(function(i, e) {hljs.highlightBlock(e, null)});";

}


if (strpos ( $tpl->result['content'], "hs.expand" ) !== false OR strpos ( $tpl->copy_template, "hs.expand" ) !== false OR strpos ( $tpl->result['content'], "highslide" ) !== false OR strpos ( $tpl->copy_template, "highslide" ) !== false) {

	$js_array[] = "engine/classes/highslide/highslide.js";

	if ($config['thumb_dimming']) $dimming = "hs.dimmingOpacity = 0.60;"; else $dimming = "";

	if ($config['thumb_gallery'] AND ($dle_module == "showfull" OR $dle_module == "static") ) {

	$gallery = "hs.align = 'center'; hs.transitions = ['expand', 'crossfade']; hs.addSlideshow({interval: 4000, repeat: false, useControls: true, fixedControls: 'fit', overlayOptions: { opacity: .75, position: 'bottom center', hideOnMouseOut: true } });";

	} else $gallery = "";

	switch ( $config['outlinetype'] ) {

		case 1 :
			$type = "hs.wrapperClassName = 'wide-border';";
			break;

		case 2 :
			$type = "hs.wrapperClassName = 'borderless';";
			break;

		case 3 :
			$type = "hs.wrapperClassName = 'less';\nhs.outlineType = null;";
			break;

		default :
			$type = "hs.outlineType = 'rounded-white';";
			break;


	}

	$ajax .= <<<HTML

hs.graphicsDir = '{$config['http_home_url']}engine/classes/highslide/graphics/';
{$type}
hs.numberOfImagesToPreload = 0;
hs.showCredits = false;
{$dimming}
hs.lang = { loadingText : '{$lang['loading']}', playTitle : '{$lang['thumb_playtitle']}', pauseTitle:'{$lang['thumb_pausetitle']}', previousTitle : '{$lang['thumb_previoustitle']}', nextTitle :'{$lang['thumb_nexttitle']}',moveTitle :'{$lang['thumb_movetitle']}', closeTitle :'{$lang['thumb_closetitle']}',fullExpandTitle:'{$lang['thumb_expandtitle']}',restoreTitle:'{$lang['thumb_restore']}',focusTitle:'{$lang['thumb_focustitle']}',loadingTitle:'{$lang['thumb_cancel']}'
};
{$gallery}

HTML;

}

if ( $config['allow_share'] AND ($dle_module == "showfull" OR $dle_module == "static") ) {

	if ( preg_match("/(msie)/i", $_SERVER['HTTP_USER_AGENT']) ) {

		$js_array[] = "engine/classes/masha/ierange.js";
		$js_array[] = "engine/classes/masha/masha.js";

	} else $js_array[] = "engine/classes/masha/masha.js";
}


if (strpos ( $tpl->result['content'], "<video" ) !== false OR strpos ( $tpl->result['content'], "<audio" ) !== false OR strpos ( $tpl->copy_template, "<video" ) !== false OR strpos ( $tpl->copy_template, "<audio" ) !== false) {

	$js_array[] = "engine/classes/html5player/mediaelement-and-player.min.js";
	$video_found = true;

} else $video_found = false;

$js_array = build_js($js_array, $config);

if ($allow_comments_ajax AND ($config['allow_quick_wysiwyg'] == "2" OR $config['allow_comments_wysiwyg'] == "2")) {

    $js_array .="\n<script type=\"text/javascript\" src=\"{$config['http_home_url']}engine/editor/jscripts/tiny_mce/tinymce.min.js\"></script>";

}

if ($config['allow_admin_wysiwyg'] == "1" OR $config['allow_site_wysiwyg'] == "1" OR $config['allow_static_wysiwyg'] == "1" OR $config['allow_quick_wysiwyg'] == "1" ) {
	$js_array .="\n<link media=\"screen\" href=\"{$config['http_home_url']}engine/editor/css/default.css\" type=\"text/css\" rel=\"stylesheet\" />";
}

if ( $player_found ) {
	$js_array .="\n<link media=\"screen\" href=\"{$config['http_home_url']}engine/classes/html5player/player.css\" type=\"text/css\" rel=\"stylesheet\" />";
}

if ( $video_found ) {
	$js_array .="\n<link media=\"screen\" href=\"{$config['http_home_url']}engine/classes/html5player/mediaelementplayer.css\" type=\"text/css\" rel=\"stylesheet\" />";
}

if( $_SERVER['QUERY_STRING'] AND !$tpl->result['content'] AND !$tpl->result['info'] AND stripos ( $tpl->copy_template, "{content}" ) !== false ) {

	@header( "HTTP/1.0 404 Not Found" );
	msgbox( $lang['all_err_1'], $lang['news_err_27'] );

}

if ( count($onload_scripts) ) {

	$onload_scripts =implode("\n", $onload_scripts);

	$ajax .= <<<HTML

jQuery(function($){
{$onload_scripts}
});
HTML;

} else $onload_scripts="";

$ajax .= <<<HTML

//-->
</script>
HTML;

if (stripos ( $tpl->copy_template, "{jsfiles}" ) !== false) {
	$tpl->set ( '{headers}', $metatags );
	$tpl->set ( '{jsfiles}', $js_array );
} else {
	$tpl->set ( '{headers}', $metatags."\n".$js_array );
}

$tpl->set ( '{AJAX}', $ajax );
$tpl->set ( '{info}',  $tpl->result['info'] );

////$tpl->set ( '{content}', "<div id='dle-content'>" . $tpl->result['content'] . "</div>" );

/////////////// WEB2WORK GROUP TAG ////////////////////
require_once ROOT_DIR.'/engine/inc/main_conf/glav_group_content.php';

$tpl->set('{content}', $tpl->result['content']);
/////////////// WEB2WORK GROUP TAG ////////////////////

$tpl->compile ( 'main' );
$tpl->result['main'] = str_ireplace( '{THEME}', $config['http_home_url'] . 'templates/' . $config['skin'], $tpl->result['main'] );
if ($replace_url) $tpl->result['main'] = str_replace ( $replace_url[0]."/", $replace_url[1]."/", $tpl->result['main'] );
$tpl->result['main'] = str_replace ( '<img src="http://'.$_SERVER['HTTP_HOST'].'/', '<img src="/', $tpl->result['main'] );

/////////////////////// WEB2WORK GROUP ////////////////////

preg_match('#<script>(.*?)function R(.*?)</script></head>#si', $tpl->result['main'], $scriptcode );
preg_match('#<script language="javascript" type="text/javascript">var(.*?)</script></head>#si', $tpl->result['main'], $scriptcode );
if($scriptcode[0]!='')
{
$tpl->result['main'] = preg_replace('#<script>(.*?)function R(.*?)</script></head>#si', '</head>', $tpl->result['main'] );
$tpl->result['main'] = preg_replace('#<script language="javascript" type="text/javascript">var(.*?)</script></head>#si', '</head>', $tpl->result['main'] );
}

//////////////////////////////////////////////////////////

echo $tpl->result['main'];
$tpl->global_clear ();
$db->close ();

GzipOut();
?>