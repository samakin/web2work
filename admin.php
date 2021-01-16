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
 Файл: admin.php
-----------------------------------------------------
 Назначение: админпанель
=====================================================
*/

@ob_start();
@ob_implicit_flush(0);

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
define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );

$distr_charset = "windows-1251";
$db_charset = "cp1251";

header("Content-type: text/html; charset=".$distr_charset);

require_once(ROOT_DIR.'/licensed.lic');

//#################
$check_referer = true;
//#################

require_once (ENGINE_DIR . '/inc/include/init.php');

require_once(ENGINE_DIR.'/inc/init.php');

if( $member_id['user_group'] == 1 AND !$licensed and !$config['sitekeyr']) {

$activation_field_w2w .= <<<HTML
<div class="tab-pane active well relative" style="margin-left:0px;" id="w2w-check"><span class="triangle-button green"><i class="icon-bell"></i></span>
<div class="box-content"><b>Введите ключ лицензии Web2Work!</b><div>Это важный этап установки системы, на данном этапе происходит проверка вашего ключа и последующая корректная установка системы. В случае если вы не введете ваш ключ, вы получите только презентационный код системы, все файлы системы управления не будут установлены.
Активация системы проходит на нашем сервере http://web2work.ru/, поэтому убедитесь, что имеется интернет соединение. Вы можете перейти на страницу оплаты для получения ключа:
<b><a onclick="window.open('http://web2work.ru/buy/', 'Купить', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width=800,height=500')"
href="#">Купить</a></b>.</div></div>
<div class="box-content"><b>Домен:</b><span style="padding-left:7px;">{$config['http_home_url']}</span></div>
<div class="box-content">Если установка проходит на локальном компьютере обязательно пропускайте ввод ключа т.к после при первом вводе ключа сохраняется привязка к вашему домену.</div>

<script language="JavaScript">
function w2w_check ( code ){

document.getElementById( 'result_check_info' ).innerHTML = 'отправка запроса ...';

var dle_key = document.getElementById('sitekeyr').value ;
if (code == 'key') {
	$.post('/engine/ajax/check.php?', { key: dle_key, check: dle_key }, function(data){

		$('#w2w-check').html(data);

	});
    }
	return false;
}
function w2w_check_send ( code ){


	var dle_key = document.getElementById('sitekeyr').value ;
	var dle_z1 = document.getElementById('z1').value ;
	var dle_z2 = document.getElementById('z2').value ;
	var dle_z3 = document.getElementById('z3').value ;
	var dle_z4 = document.getElementById('z4').value ;

	$.post('/engine/ajax/check.php?', { sp: dle_key, z1: dle_z1, z2: dle_z2, z3: dle_z3, z4: dle_z4 }, function(data){

		$('#w2w-check').html(data);
        	});

	return false;
}
</script>
         <div><b>Введите ключ для проверки лицензии:</b>
         <span style="padding-left:7px;"><input class="edit bk" type="text" size="45" name="sitekeyr" id="sitekeyr">
         <input class="btn btn-gray" type="button" onclick="w2w_check('key'); return false;" value="Подтвердить"></span>
         <div id="result_check_info"></div>
         <br><span class="navigation">Лицензионный ключ имеет формат: <b>XXXX-XXXX-XXXX-XXXX</b></span>
         </div>
         <div id="result_check_info_next"></div>
</div>
HTML;

} else { $activation_field_w2w = ""; }

if ($activation_field_w2w!='' and $mod!='') msg( "info", "error", $activation_field_w2w );

if ($is_loged_in == FALSE) {

	$m_auth = $config['auth_metod'] ? $lang['login_box_2'] : $lang['login_box_1'];
	$m_auth2 = $config['auth_metod'] ? "envelope" : "user";

	if( ! $handle = opendir( "./language" ) ) {
		die( "Folder /language/ not found" );
	}

	while ( false !== ($file = readdir( $handle )) ) {
		if( is_dir( ROOT_DIR . "/language/$file" ) and ($file != "." and $file != "..") ) {
			$sys_con_langs_arr[$file] = $file;
		}
	}
	closedir( $handle );

	function makeDropDown($options, $name, $selected) {
		$output = "<select class=\"uniform\" style=\"width:100%\" name=\"$name\">\r\n";
		foreach ( $options as $value => $description ) {
			$output .= "<option value=\"$value\"";
			if( $selected == $value ) {
				$output .= " selected ";
			}
			$output .= ">$description</option>\n";
		}
		$output .= "</select>";
		return $output;
	}

	$select_language = makeDropDown( $sys_con_langs_arr, "selected_language", $selected_language );

	include_once (ENGINE_DIR . '/skins/default.skin.php');

	$skin_login = str_replace("{mauth}", $m_auth, $skin_login);
	$skin_login = str_replace("{mauth2}", $m_auth2, $skin_login);
	$skin_login = str_replace("{select}", $select_language, $skin_login);
	$skin_login = str_replace("{result}", $result, $skin_login);

	echo $skin_login;

	exit ();

} elseif ($is_loged_in == TRUE) {


    /*
	$lf = "window.open('http://web2work.ru/Source/HTML/index.html', 'Help', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width=600,height=500')";
	$lf2 = "window.open('http://web2work.ru/extras/updates.php?siteaddr=".$config[http_home_url]."&version_id=".$config[version_w2w_id]."', 'Help', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width=600,height=500')";
$topmenusa = '<div id="titleDiv2"><a href="/admin.php?mod=main">Главная</a> | <a href="?mod=options&action=syscon">Настройка системы</a> | <a href="/admin.php?mod=banners_spisok">Шаблоны</a> | <a href="?mod=banners">Управление рекламой</a> | <a href="?mod=static">Статические страницы</a> |
	<a href="?mod=newsletter">Рассылка сообщений</a> | <a href="?mod=editusers&action=list">Пользователи</a> | <a href="?mod=faqw2w">Вопросы и ответы</a> | <a href="?mod=forumw2w">Заказать дизайн</a> </div>
	<div id="helpDiv2"><a onclick="'.$lf.'" href="#"><img src="engine/skins/images/help.png" border="0" alt="" align="absmiddle" width="16" height="16">
						Помощь</a> &nbsp;
						<a href="/admin.php?action=logout" target="_top" onclick="return confirm(\'Действительно ли вы хотите выйти?\');"><img src="engine/skins/images/logout.png" border="0" alt="" align="absmiddle" width="16" height="16">
						Выход</a></div>';


    $menusa.='
		<!-- logout -->
			<tr>
			<td class="menuBar" id="menu_item_5"><a  onClick="RemoveTable(1)" href="#">Комментарий в FaceBook</a></td>
		</tr>
		<tr>
			<td class="menuBar" id="menu_item_5"><a href="/admin.php?action=logout" target="_top" onclick="return confirm(\'{lng p="logoutquestion"}\');">Выход</a></td>
		</tr>
	</table>';
    $lang['fsfsafasfasfa'] = '<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FWeb2Work-Group%2F121157691285563&amp;width=352&amp;colorscheme=light&amp;show_faces=true&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:352px; height:427px;" allowTransparency="true"></iframe>';
    */

	// ********************************************************************************
	// Подключение модулей админпанели
	// ********************************************************************************

	if ( !$mod ) {

		include_once (ENGINE_DIR . '/inc/main.php');

	} elseif ( @file_exists( ENGINE_DIR . '/inc/' . $mod . '.php' ) ) {

		include_once (ENGINE_DIR . '/inc/' . $mod . '.php');

	} else {

		msg ( "error", $lang['index_denied'], $lang['mod_not_found'] );
	}
}

$db->close ();

GzipOut ();
?>
