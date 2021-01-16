<?php
error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

define('DATALIFEENGINE', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/engine');

$config['charset'] = "windows-1251";

require_once(ENGINE_DIR.'/data/config.php');
require_once(ENGINE_DIR.'/classes/mysql.php');
require_once(ENGINE_DIR.'/data/dbconfig.php');
require_once(ENGINE_DIR.'/inc/include/functions.inc.php');

$distr_charset = "windows-1251";
$db_charset = "cp1251";

header("Content-type: text/html; charset=".$distr_charset);

$skin_header = <<<HTML
<!doctype html>
<html>
<head>
  <meta charset="{$distr_charset}">
  <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <title>Web2Work - Установка</title>
  <link href="engine/skins/stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="engine/skins/javascripts/application.js"></script>
</head>
<body>
<script language="javascript" type="text/javascript">
<!--
var dle_act_lang   = ["Да", "Нет", "Ввод", "Отмена", "Загрузка изображений и файлов на сервер"];
var cal_language   = {en:{months:['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],dayOfWeek:["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]}};
//-->
</script>
<nav style="max-width:1220px;width:100%;margin:0 auto;" class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
  <div class="navbar-header">
        <a class="navbar-brand" href="{$PHP_SELF}"><img src="/engine/skins/images/logo.png"></a>
  </div>
  <div style="float:right;margin-top:15px;" class="navbar-header">
  <b>Подпишись:</b> 
  <a rel="nofollow" href="https://vkontakte.ru/club13001075" target="_blank"><img src="/engine/skins/images/vkontakte.png" alt="Web2Work Group в Vkontakte"></a>  <a rel="nofollow" target="_blank" href="https://twitter.com/#!/web2work/web2work-group"><img src="/engine/skins/images/twitter.png" alt="Web2Work Group в Twitter"></a> <a href="https://google.com/+Web2workRus" rel="publisher" target="_blank"><img src="/engine/skins/images/gplus.png" alt="Web2Work Group в Google+"></a> <a href="https://www.facebook.com/pages/Web2Work-Group/121157691285563" rel="nofollow" target="_blank"><img src="/engine/skins/images/facebook.png" alt="Web2Work Group в Facebook"></a>  <a target="_blank" href="https://www.youtube.com/channel/UCs1yzsO9earP5yOXiMLGclw"><img style="width:32px;height:24px;" alt="youtube web2work" src="/engine/skins/images/yotubeaoui.jpg"></a>
</div>
<div style="clear:both;"></div>
</nav>
<div class="container">
  <div class="col-md-8 col-md-offset-2">
    <div class="padded">
	    <div style="margin-top: 10px;">
<!--MAIN area-->
HTML;


$skin_footer = <<<HTML
	 <!--MAIN area-->
    </div>
  </div>
</div>
</div>

</body>
</html>
HTML;

extract($_REQUEST, EXTR_SKIP);

$pathe= ROOT_DIR . '/engine/';
@chmod($pathe, 0777);

$pathe= ROOT_DIR . '/uploads/';
@chmod($pathe, 0777);

$pathe= ROOT_DIR . '/backup/';
@chmod($pathe, 0777);

$pathe= ROOT_DIR . '/engine/data/';
@chmod($pathe, 0777);


$js_array = array (
	'engine/skins/default.js',
		'engine/classes/js/jquery.js',
			'engine/classes/js/jqueryui.js',
);

$tableSchema = array();

foreach($tableSchema as $table) {
        $db->query ($table);
}

require_once(ENGINE_DIR.'/data/videoconfig.php');

$video_config['preload'] = "1";

unset($video_config['use_html5']);
unset($video_config['youtube_q']);
unset($video_config['startframe']);
unset($video_config['preview']);
unset($video_config['autohide']);
unset($video_config['fullsizeview']);
unset($video_config['buffer']);
unset($video_config['progressBarColor']);
unset($video_config['play']);

$con_file = fopen(ENGINE_DIR.'/data/videoconfig.php', "w+") or die("Извините, но невозможно создать файл <b>.engine/data/videoconfig.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite( $con_file, "<?PHP \n\n//Videoplayers Configurations\n\n\$video_config = array (\n\n" );
foreach ( $video_config as $name => $value ) {

    fwrite( $con_file, "'{$name}' => \"{$value}\",\n\n" );

}
fwrite( $con_file, ");\n\n?>" );
fclose($con_file);

require_once(ENGINE_DIR.'/data/videoconfig.php');

$video_config['theme'] = "default";

$con_file = fopen(ENGINE_DIR.'/data/videoconfig.php', "w+") or die("Извините, но невозможно создать файл <b>.engine/data/videoconfig.php</b>.<br />Проверьте правильность проставленного CHMOD!");
fwrite( $con_file, "<?PHP \n\n//Videoplayers Configurations\n\n\$video_config = array (\n\n" );
foreach ( $video_config as $name => $value ) {

    fwrite( $con_file, "'{$name}' => \"{$value}\",\n\n" );

}
fwrite( $con_file, ");\n\n?>" );
fclose($con_file);

$url  = preg_replace( "'/install.php'", "", $_SERVER['HTTP_REFERER']);
$url  = preg_replace( "'\?(.*)'", "", $url);
if(substr("$url", -1) == "/"){ $url = substr($url, 0, -1); }

// ********************************************************************************
// Приветствие
// ********************************************************************************
echo $skin_header;

echo <<<HTML
<form method=POST action="/install/install_step2.php">
<input type=hidden name="reg_name" value="{$_REQUEST['reg_name']}">
<input type=hidden name="reg_password" value="{$_REQUEST['reg_password']}">
<input type=hidden name="regmail" value="{$_REQUEST['regmail']}">
<input type=hidden name="action" value="doinstall">
<div class="box">
  <div class="box-header">
    <div class="title">Второй шаг установки - Настройка региональной привязки</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
		<table width="100%">
			<tr><td style="padding: 5px;">Страна: (Например: Россия)</td>
			<td style="padding: 5px;"><input class="edit" type=text size="28" name="strana_osn_name" value=""></tr>
			<tr><td style="padding: 5px;">Область: (Например: Свердловская)</td>
			<td style="padding: 5px;"><input class="edit" type=text size="28" name="oblast_osn_name"></tr>
			<tr><td style="padding: 5px;">Город: (Например: Екатеринбург)</td>
			<td style="padding: 5px;"><input class="edit" type=text size="28" name="city_osn_name"></tr>
			<tr><td style="padding: 5px;">Карта городов:</td>
			<td style="padding: 5px;"><select class="uniform" name="option_city_type"><option value="2">Нет фильтра</option><option value="1" selected="">Город по умолчанию</option><option value="0">Область по умолчанию</option></select></tr>
		</table>
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="Продолжить">
	</div>

  </div>
</div>
</form>
HTML;

echo $skin_footer;
?>