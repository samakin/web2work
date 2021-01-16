<?php

define( 'DATALIFEENGINE', true );
error_reporting(7);

define('ROOT_DIR', '..' );
define('ENGINE_DIR' , ROOT_DIR . '/engine');
ini_set( 'display_errors', true );
ini_set( 'html_errors', false );

require_once ( ENGINE_DIR . '/data/config.php');
include ENGINE_DIR . '/data/block_adv_content_config.php';
require_once ENGINE_DIR . '/classes/mysql.php';
include_once ENGINE_DIR . '/data/dbconfig.php';
include_once ENGINE_DIR . '/modules/functions.php';
require_once ENGINE_DIR . '/classes/templates.class.php';

if (!date_default_timezone_get()) {
    date_default_timezone_set('Asia/Yekaterinburg');
}

$distr_charset = $config['charset'];
$db_charset = "cp1251";

header("Content-type: text/html; charset=".$distr_charset);

if ( !count($config)  || !$config)
{
    die ("Ошибка в файле <b>engine/data/config.php</b>");
}
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Настройки
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Проверка на валидность URL ?

define('URL_CHECK' , 1); // по умолчанию 1 ( 0 - нет )
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Дальше не мацать код
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//$url  = (isset($_GET['url']) && (!empty($_GET['url']))) ? trim(str_replace('&','',$_GET['url'])) : @header('Location: /index.php');
$url = trim(str_replace('&','',str_replace('=','',$_GET['url'])));

@preg_match('#firm/(.*?)/#is', $_SERVER['REQUEST_URI'], $fd);

if ($fd[1]!='') $link = str_replace('/engine/redirect.php?link=','',$_SERVER['REQUEST_URI']);
else $link = $_GET['link'];

$link = str_replace('/engine/redirect.php?url=','',$link);

if  ( URL_CHECK )
{
    if ( !preg_match( '/http:\/\//' , $url ) and !preg_match( '/https:\/\//' , $url ))
    {
        if ( !preg_match( '/http:\/\//' , $link ) and !preg_match( '/https:\/\//' , $link )) {
            die ("Неправильно построенный адрес");
        } elseif ($link) $url=$link;
    }
}
$linka = "<a href=\"".$url."\">".$url."</a>";
$name = "".$config['home_title']."";
$url_a = ".$url.";

$db->query( "SELECT * FROM " . USERPREFIX . "_banners WHERE banner_tag='counter'" );
$row = $db->get_row();

$fileeprov = url_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/'._SAPE_USER.'/sape.php');
if ($fileeprov!=0)
{
    define('_SAPE_USER', ''.$config['adv_sape_num'].'');
    require_once($_SERVER['DOCUMENT_ROOT'].'/uploads/'._SAPE_USER.'/sape.php');
    $sape = new SAPE_client();
    $link_sape = $sape->return_links($config['adv_numsl_sa']);
}


$banners = stripslashes($row['code']);

include_once ( ENGINE_DIR . '/' . (($config['version_id'] > 1.0) ? 'classes' : 'inc') . '/templates.class.php');

$skin = new dle_template;
$skin -> dir = ( ROOT_DIR.'/templates/');

$skin -> load_template('redirect.tpl');
$skin -> set('{link}', $linka );
$skin -> set('{name}', $name);
$skin -> set('{url}', $url_a);
$skin -> set('{counter}', $banners);

$skin -> set('{link_sape}', $link_sape);
$skin -> set('{link_set}', $link_set);
$skin -> set('{link_main}', $link_main);

$skin -> compile('redirect');
$skin -> clear();

//вывод
print ( $skin -> result ['redirect'] );
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

?>