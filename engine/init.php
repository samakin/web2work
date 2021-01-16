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
 Файл: init.php
-----------------------------------------------------
 Назначение: подключение дополнительных модулей
=====================================================
*/
if (! defined ( 'DATALIFEENGINE' )) {
    die ( "Hacking attempt!" );
}

@include (ENGINE_DIR . '/data/config.php');

if ($config['regional_portal']==1) {
////////////// фильтр других городов /////////////////
    $servhost = 'http://'.$_SERVER['HTTP_HOST'].'/';
    $servhost = str_replace('www.','',$servhost);
    if ($servhost==$config['http_home_url'])
    {
        setcookie( 'dle_vibr_city_main', '', '392', "/", $config['http_home_url'], NULL, TRUE );
        $_COOKIE['dle_vibr_city_main'] = '';
    }
    elseif ($_COOKIE['dle_vibr_city_main']!='' or ($servhost!=$config['http_home_url']))
    {

        $get_data_other_config = @file_get_contents( ENGINE_DIR . '/cache/system/navigation_lands.php' );

        if($servhost!=$config['http_home_url'])
        {
            $get_data_other_config = unserialize( $get_data_other_config );
            foreach ($get_data_other_config as $gd)
            {
                if ($servhost==$gd[url_eng])
                {
                    setcookie( 'dle_vibr_city_main', $gd[id], '392', "/", $config['http_home_url'], NULL, TRUE );
                    //@session_register( 'dle_vibr_city_doskaz' );
                    $_SESSION['dle_vibr_city_doskaz'] = $gd[name];
                    $_COOKIE['dle_vibr_city_main'] = $gd[id];
                }
            }

        }


        if ( $get_data_other_config !== false ) {
            if ( is_array($get_data_other_config) OR is_int($get_data_other_config) ) $xiter_navlands = $get_data_other_config;
        }
        $return_name = array();
        foreach ( $xiter_navlands as $cats ) {
            if ($cats[id]==$_COOKIE['dle_vibr_city_main']) {
                $return_name[name] = $cats[name];
                $return_name[title] = $cats[title];
                $return_name[keyword] = $cats[keyword];
                $return_name[descript] = $cats[descript];
                $return_name[descript_site] = $cats[descript_site];
                $return_name[portal_id] = $cats[portal_id];
                $return_name[wetr] = $cats[weather_id];
                $return_name[wetr_gm] = $cats[weather_gm_id];
                $return_name[http_eng] = $cats[url_eng];
                $return_name[http_kyil] = $cats[url_kyil];
                $return_name[lat] = $cats[lat];
                $return_name[lng] = $cats[lng];
            }
        }
        //// РЕГИОНАЛЬНЫЙ ВЫБОР

        if (is_array($return_name))
        {

            $config['home_title'] = $return_name[name] ;
            $config['description'] = $return_name[descript_site] ;
            $config['keywords'] = $return_name[keyword] ;
            $config['http_home_url'] = $return_name[http_eng] ;
            $config['city_osn_name'] = $return_name[name] ;
        }
    }
////////////// фильтр других городов /////////////////
}

if ($config['http_home_url'] == "") {

    $config['http_home_url'] = explode ( "index.php", $_SERVER['PHP_SELF'] );
    $config['http_home_url'] = reset ( $config['http_home_url'] );
    $config['http_home_url'] = "http://" . $_SERVER['HTTP_HOST'] . $config['http_home_url'];

}

if ( !$config['version_id'] ) {

    if ( file_exists(ROOT_DIR . '/install.php') AND !file_exists(ENGINE_DIR . '/data/config.php') ) {

        header( "Location: ".str_replace("index.php","install.php",$_SERVER['PHP_SELF']) );
        die ( "Datalife Engine not installed. Please run install.php" );

    } else {

        die ( "Datalife Engine not installed. Please run install.php" );
    }

}

require_once ENGINE_DIR . '/classes/mysql.php';
require_once ENGINE_DIR . '/data/dbconfig.php';
require_once ENGINE_DIR . '/modules/functions.php';
require_once ENGINE_DIR . '/modules/gzip.php';

dle_session();

$Timer = new microTimer();

check_xss ();

if( $config['start_site'] == 3 AND $_SERVER['QUERY_STRING'] == "" ) {

    $_GET['do'] = "static";
    $_REQUEST['do'] = "static";
    $_GET['page'] = "main";
    $_REQUEST['page'] = "main";

}

$cron = false;
$_TIME = time () + ($config['date_adjust'] * 60);
$config['charset'] = strtolower($config['charset']);
/////////////// МОДУЛИ WEB2WORK GROUP ////////////////////
$cron_time = get_vars ( "cron" );

if (date ( "Y-m-d", $cron_time ) != date ( "Y-m-d", $_TIME )) $cron = 2;
elseif ($config['cache_count'] and (($cron_time + (3600 * 2)) < $_TIME)) $cron = 1;

if ($cron) include_once ENGINE_DIR . '/modules/cron.php';
if ($cron and $config[onsite_import]) {
    $onsite=true;
    require_once ROOT_DIR.'/cron/import_kurs.php';
    require_once ROOT_DIR.'/cron/import_current.php';
    require_once ROOT_DIR.'/cron/import_forecast.php';
}
if ($_REQUEST['do']=='rating_sites' and $cron and $config[onsite_rating])
{
    $_REQUEST['action'] = 'cron';
    include_once ROOT_DIR . '/cron/rating_cron.php';
    if (($cron_time_rate + (1500 * 2)) < $_TIME) include_once ENGINE_DIR . '/rating/cron_site/h_cron.php';
}
/////////////// МОДУЛИ WEB2WORK GROUP ////////////////////
if (isset ( $_GET['year'] )) $year = intval ( $_GET['year'] ); else $year = '';
if (isset ( $_GET['month'] )) $month = @$db->safesql ( sprintf("%02d", intval ( $_GET['month'] ) ) ); else $month = '';
if (isset ( $_GET['day'] )) $day = @$db->safesql ( sprintf("%02d", intval ( $_GET['day'] ) ) ); else $day = '';
if (isset ( $_GET['news_name'] )) $news_name = @$db->safesql ( strip_tags ( str_replace ( '/', '', $_GET['news_name'] ) ) ); else $news_name = '';
if (isset ( $_GET['newsid'] )) $newsid = intval ( $_GET['newsid'] ); else $newsid = 0;
if (isset ( $_GET['cstart'] )) $cstart = intval ( $_GET['cstart'] ); else $cstart = 0;
if (isset ( $_GET['news_page'] )) $news_page = intval ( $_GET['news_page'] ); else $news_page = 0;

if ($cstart > 9000000) {

    header( "Location: ".str_replace("index.php","",$_SERVER['PHP_SELF']) );
    die();
}

if (isset ( $_GET['catalog'] )) {

    $catalog = @strip_tags ( str_replace ( '/', '', urldecode ( $_GET['catalog'] ) ) );

    if ( $config['charset'] == "windows-1251" AND $config['charset'] != detect_encoding($catalog) ) {
        $catalog = iconv( "UTF-8", "windows-1251//IGNORE", $catalog );
    }

    $catalog = $db->safesql ( dle_substr ( $catalog, 0, 3, $config['charset'] ) );

} else $catalog = '';

if (isset ( $_GET['user'] )) {

    $user = @strip_tags ( str_replace ( '/', '', urldecode ( $_GET['user'] ) ) );

    if ( $config['charset'] == "windows-1251" AND $config['charset'] != detect_encoding($user) ) {
        $user = iconv( "UTF-8", "windows-1251//IGNORE", $user );
    }

    $user = $db->safesql ( $user );

    if( preg_match( "/[\||\'|\<|\>|\"|\!|\?|\$|\@|\/|\\\|\&\~\*\+]/", $user ) ) $user="";

} else $user = '';

if (isset ( $_GET['category'] )) {
    if (substr ( $_GET['category'], - 1, 1 ) == '/') $_GET['category'] = substr ( $_GET['category'], 0, - 1 );
    $category = explode ( '/', $_GET['category'] );
    $category = end ( $category );
    $category = $db->safesql ( strip_tags ( $category ) );
} else $category = '';

$PHP_SELF = $config['http_home_url'] . "index.php";
$pm_alert = "";
$ajax = "";
$allow_comments_ajax = false;
$_DOCUMENT_DATE = false;
$user_query = "";
$static_result = array ();
$is_logged = false;
$member_id = array ();
$related_buffer = false;

$js_array = array ();

$metatags = array (
    'title' => $config['home_title'],
    'description' => $config['description'],
    'keywords' => $config['keywords'],
    'header_title' => "" );

//################# Определение групп пользователей
$user_group = get_vars ( "usergroup" );

if (! $user_group) {
    $user_group = array ();

    $db->query ( "SELECT * FROM " . USERPREFIX . "_usergroups ORDER BY id ASC" );

    while ( $row = $db->get_row () ) {

        $user_group[$row['id']] = array ();

        foreach ( $row as $key => $value ) {
            $user_group[$row['id']][$key] = stripslashes($value);
        }

    }
    set_vars ( "usergroup", $user_group );
    $db->free ();
}
//####################################################################################################################
//                    Определение категорий и их параметры
//####################################################################################################################
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

//####################################################################################################################
//                    Определение забаненных пользователей и IP
//####################################################################################################################
$banned_info = get_vars ( "banned" );

if (! is_array ( $banned_info )) {
    $banned_info = array ();

    $db->query ( "SELECT * FROM " . USERPREFIX . "_banned" );
    while ( $row = $db->get_row () ) {

        if ($row['users_id']) {

            $banned_info['users_id'][$row['users_id']] = array (
                'users_id' => $row['users_id'],
                'descr' => stripslashes ( $row['descr'] ),
                'date' => $row['date'] );

        } else {

            if (count ( explode ( ".", $row['ip'] ) ) == 4)
                $banned_info['ip'][$row['ip']] = array (
                    'ip' => $row['ip'],
                    'descr' => stripslashes ( $row['descr'] ),
                    'date' => $row['date']
                );
            elseif (strpos ( $row['ip'], "@" ) !== false)
                $banned_info['email'][$row['ip']] = array (
                    'email' => $row['ip'],
                    'descr' => stripslashes ( $row['descr'] ),
                    'date' => $row['date'] );
            else $banned_info['name'][$row['ip']] = array (
                'name' => $row['ip'],
                'descr' => stripslashes ( $row['descr'] ),
                'date' => $row['date'] );

        }

    }
    set_vars ( "banned", $banned_info );
    $db->free ();
}

/////////////// МОДУЛИ WEB2WORK GROUP ////////////////////
require_once ENGINE_DIR . '/inc/intsystem.php';
/////////////// МОДУЛИ WEB2WORK GROUP ////////////////////

$category_skin = "";

if ($category != '') $category_id = get_ID ( $cat_info, $category );
else $category_id = false;

if ($category_id) $category_skin = $cat_info[$category_id]['skin'];

// #################################
if ($news_name != '' OR $newsid) {

    $allow_sql_skin = false;

    foreach ( $cat_info as $cats ) {
        if ($cats['skin'] != '') $allow_sql_skin = true;
    }

    if ($allow_sql_skin) {

        if (!$newsid) $sql_skin = $db->super_query ( "SELECT category FROM " . PREFIX . "_post where month(date) = '$month' AND year(date) = '$year' AND dayofmonth(date) = '$day' AND alt_name ='$news_name'" );
        else $sql_skin = $db->super_query ( "SELECT category FROM " . PREFIX . "_post where  id = '$newsid' AND approve" );

        $base_skin = explode ( ',', $sql_skin['category'] );

        $category_skin = $cat_info[$base_skin[0]]['skin'];

        unset ( $sql_skin );
        unset ( $base_skin );

    }

}

////////////////// WEB2WORK GROUP TAG ////////////////////////

if (isset ($_REQUEST['do']) && $_REQUEST['do'] == "fotoalbum"){
    $allalbums = get_vars ( "allalbums" );
    if (! is_array ( $allalbums )) {
        $allalbums = array ();
        $sql_lastphoto2 = $db->query("SELECT * FROM " . PREFIX . "_twsfa_albums ORDER BY id DESC");
        while($rowkk = $db->get_row($sql_lastphoto2)) {
            $allalbums[$rowkk[id]] = array ();

            foreach ( $rowkk as $key => $value ) {
                $allalbums[$rowkk[id]][$key] = $value;
            }
        }
        $db->free();
        set_vars ( "allalbums", $allalbums );
    }
    $allcatfoto = get_vars ( "allcatfoto".$format_editlang_key );
    if (! is_array ( $allcatfoto )) {
        $allcatfoto = array ();
        $sql_result245rt2a = $db->query("SELECT * FROM " . PREFIX . "_twsfa_category ORDER by name ASC");
        while($rowkkz = $db->get_row($sql_result245rt2a)) {

            $allcatfoto[$rowkkz[id]] = array ();
            foreach ( $rowkkz as $key => $value ) {
                //if ($editlang==1 and $key=='name') $value = changelangapiyandex($value, $format_editlang);
                $allcatfoto[$rowkkz[id]][$key] = $value;
            }
        }
        $db->free();
        set_vars ( "allcatfoto".$format_editlang_key, $allcatfoto );
    }

    include_once ENGINE_DIR . '/data/fotoalbum.config.php';
    include ENGINE_DIR.'/modules/content/fotoalbum/init.php';
    include_once TWSFA_DIR.'/functions.web.php';
}

//////////////////////////////////////////////////////////////

if (isset($_GET['do']) AND $_GET['do'] == "static") {

    $name = @$db->safesql( trim( totranslit( $_GET['page'], true, false ) ) );
    $static_result = $db->super_query ( "SELECT * FROM " . PREFIX . "_static WHERE name='{$name}'" );
    $category_skin = $static_result['template_folder'];

}

if ($category_skin != "") {

    $category_skin = trim( totranslit($category_skin, false, false) );

    if ($category_skin != '' AND @is_dir ( ROOT_DIR . '/templates/' . $category_skin )) {
        $config['skin'] = $category_skin;
    }

} elseif (isset ( $_REQUEST['action_skin_change'] )) {

    $_REQUEST['skin_name'] = trim( totranslit($_REQUEST['skin_name'], false, false) );

    if ($_REQUEST['skin_name'] != '' AND @is_dir ( ROOT_DIR . '/templates/' . $_REQUEST['skin_name'] ) ) {
        $config['skin'] = $_REQUEST['skin_name'];
        set_cookie ( "dle_skin", $_REQUEST['skin_name'], 365 );
    }

} elseif (isset ( $_COOKIE['dle_skin'] ) ) {

    $_COOKIE['dle_skin'] = trim( totranslit($_COOKIE['dle_skin'], false, false) );

    if ($_COOKIE['dle_skin'] != '' AND @is_dir ( ROOT_DIR . '/templates/' . $_COOKIE['dle_skin'] )) {
        $config['skin'] = $_COOKIE['dle_skin'];
    }
}

if (isset ( $config["lang_" . $config['skin']] ) and $config["lang_" . $config['skin']] != '') {
    if ( file_exists( ROOT_DIR . '/language/' . $config["lang_" . $config['skin']] . '/website.lng' ) ) {
        include_once ROOT_DIR . '/language/' . $config["lang_" . $config['skin']] . '/website.lng';
    } else die("Language file not found");
} else {

    include_once ROOT_DIR . '/language/' . $config['langs'] . '/website.lng';

}

$config['charset'] = ($lang['charset'] != '') ? $lang['charset'] : $config['charset'];

$smartphone_detected = false;

if( isset( $_REQUEST['action'] ) and $_REQUEST['action'] == "mobiledisable" ) $_SESSION['mobile_disable'] = 1;
if( isset( $_REQUEST['action'] ) and $_REQUEST['action'] == "mobile" ) { $_SESSION['mobile_enable'] = 1; $_SESSION['mobile_disable'] = 0;}
if( !isset( $_SESSION['mobile_disable'] ) ) $_SESSION['mobile_disable'] = 0;
if( !isset( $_SESSION['mobile_enable'] ) ) $_SESSION['mobile_enable'] = 0;

if ( $config['allow_smartphone'] AND !$_SESSION['mobile_disable'] ) {

    if ( check_smartphone() ) {

        if ( @is_dir ( ROOT_DIR . '/templates/smartphone' ) ) {

            $config['skin'] = "smartphone";
            $smartphone_detected = true;
            $config['allow_comments_wysiwyg'] = 0;

        }

    }

}

if (!isset ( $do ) AND isset ($_REQUEST['do']) ) $do = totranslit ( $_REQUEST['do'] ); elseif(isset ( $do )) $do = totranslit ( $do ); else $do = "";
if (!isset ( $subaction ) AND isset ($_REQUEST['subaction']) ) $subaction = totranslit ($_REQUEST['subaction']); else $subaction = totranslit ($subaction);
if ( isset ($_REQUEST['doaction']) ) $doaction = totranslit ($_REQUEST['doaction']); else $doaction = "";
if ($do == "tags" AND !$_GET['tag']) $do = "alltags";

$dle_module = $do;
if ($do == "" and ! $subaction and $year) $dle_module = "date";
elseif ($do == "" and $catalog) $dle_module = "catalog";
elseif ($do == "") $dle_module = $subaction;
if ($subaction == '' AND $newsid) $dle_module = "showfull";
$dle_module = $dle_module ? $dle_module : "main";

require_once ENGINE_DIR . '/classes/templates.class.php';

$tpl = new dle_template();
$tpl->dir = ROOT_DIR . '/templates/' . totranslit($config['skin'], false, false);
define ( 'TEMPLATE_DIR', $tpl->dir );

if (isset ( $_POST['set_new_sort'] ) AND $config['allow_change_sort']) {

    $allowed_sort = array (
        'date',
        'rating',
        'news_read',
        'comm_num',
        'title' );

    $find_sort = str_replace ( ".", "", totranslit ( $_POST['set_new_sort'] ) );
    $direction_sort = str_replace ( ".", "", totranslit ( $_POST['set_direction_sort'] ) );

    if (in_array($_POST['dlenewssortby'], $allowed_sort) AND stripos($find_sort, "dle_sort_") === 0) {

        if ($_POST['dledirection'] == "desc" or $_POST['dledirection'] == "asc") {

            $_SESSION[$find_sort] = $_POST['dlenewssortby'];
            $_SESSION[$direction_sort] = $_POST['dledirection'];
            $_SESSION['dle_no_cache'] = "1";

        }

    }

}

if ($config['allow_registration']) {

    include_once ENGINE_DIR . '/modules/sitelogin.php';

    if ( isset( $banned_info['ip'] ) ) $blockip = check_ip ( $banned_info['ip'] );  else $blockip = false;

    if (($is_logged AND $member_id['banned']) OR $blockip) include_once ENGINE_DIR . '/modules/banned.php';

    if ($is_logged) {

        set_cookie ( "dle_newpm", $member_id['pm_unread'], 365 );

        if ($member_id['pm_unread'] > intval ( $_COOKIE['dle_newpm'] ) AND !$smartphone_detected) {

            include_once ENGINE_DIR . '/modules/pm_alert.php';

        }

    }

    if ($is_logged and $user_group[$member_id['user_group']]['time_limit']) {

        if ($member_id['time_limit'] != "" and (intval ( $member_id['time_limit'] ) < $_TIME)) {

            $db->query ( "UPDATE " . USERPREFIX . "_users set user_group='{$user_group[$member_id['user_group']]['rid']}', time_limit='' WHERE user_id='$member_id[user_id]'" );
            $member_id['user_group'] = $user_group[$member_id['user_group']]['rid'];

        }
    }

} else {

    $dle_login_hash = "";
    $_IP = get_ip();
}

if (!$is_logged) $member_id['user_group'] = 5;

$tpl->load_template( 'login.tpl' );
$tpl->set( '{login-method}', $config['auth_metod'] ? "E-Mail:" : $lang['login_metod'] );
$tpl->set( '{registration-link}', $PHP_SELF . "?do=register" );
$tpl->set( '{lostpassword-link}', $PHP_SELF . "?do=lostpassword" );
$tpl->set( '{logout-link}', $PHP_SELF . "?action=logout" );
$tpl->set( '{admin-link}', $config['http_home_url'] . $config['admin_path'] . "?mod=main" );
$tpl->set( '{login}', $member_id['name'] );

/// web2work ////
$tpl->set( '{fullname}', $member_id['fullname'] );
if ($member_id['signature']=='') $member_id['signature']=$lang['profile_signature'];
$tpl->set('{signature}', stripslashes($member_id['signature']));

$birthdate = $member_id['birthdate'];
$bdate_view = $member_id['bdate_view'];
$birthdate_see = format_date_html($birthdate,$bdate_view);
$birthdate_array = explode('-',$birthdate);
$birth_y = $birthdate_array[0];
$birth_m = $birthdate_array[1];
$birth_d = $birthdate_array[2];

$thisdate   = date ("Y-m-d");
$this_month = date('m', $_TIME);
$this_year  = date('Y', $_TIME);
$this_date  = date('d', $_TIME);

$birth_age = $thisdate-$birthdate;
$tpl->set('{birth_age}', $birth_age);

$row_club2f = $cat_info_firm_citys[$member_id['city']];
$row_club2ff = $cat_info_firm_strani[$row_club2f['strana_id']];

if ($member_id['city']!=''){
    if ($datting==1) $tpl->set('{city}', "<a href='/datting/?action=search&research=1&city=".$row_club2f['id']."'>".$row_club2f['name']."</a>");
    else $tpl->set('{city}', "<a href='/".$row_club2fff['alt_name']."/".$row_club2f['id'].".html'>".$row_club2f['name']."</a>");
    $tpl->set('{strana}', "<b>".$lang['ver25_47'].":</b> ".$row_club2ff['name']."");
}
else
{
    $tpl->set('{city}', "");
    $tpl->set('{strana}', "");
}

////////////////

$tpl->set( '{pm-link}', "/pm/" );
$tpl->set( '{new-pm}', $member_id['pm_unread'] );
$tpl->set( '{all-pm}', $member_id['pm_all'] );
$tpl->set( '{recaptcha_theme}', $config['recaptcha_theme'] );
$tpl->set( '{wysiwyg_language}', $lang['wysiwyg_language'] );

//////////// web2work /////////////

if($member_id['pm_unread']>0) {
    $tpl->set('[new-pm]',"");
    $tpl->set('[/new-pm]',"");
} else $tpl->set_block("'\\[new-pm\\].*?\\[/new-pm\\]'si","");

if($do!='pm' and (($do=='members') or ($do=='' and $subaction=='userinfo'))) {
    $tpl->set('[page]',"");
    $tpl->set('[/page]',"");
} else $tpl->set_block("'\\[page\\].*?\\[/page\\]'si","");

if($config['open-link']=='1') {
    $tpl->set('[open-link]', "");
    $tpl->set('[/open-link]', "");
} else $tpl->set_block("'\\[open-link\\].*?\\[/open-link\\]'si","");

$_SESSION['state'] = md5(uniqid(rand(), TRUE));
$tpl->set( '{state}', $_SESSION['state']);


if (stripos ( $tpl->copy_template, "{methodauth" ) !== false) {
    $tpl->copy_template = preg_replace_callback ( "#\\{methodauth(.+?)\\}#i", "method_auth", $tpl->copy_template ); ///// метод авторизации вместо вставки в шаблон логина
}


if( $config['allow_sec_code'] ) {

    if ( $config['allow_recaptcha'] ) {

        $tpl->set( '[recaptcha]', "" );
        $tpl->set( '[/recaptcha]', "" );

        $tpl->set( '{recaptcha}', '
<script language="javascript" type="text/javascript">
<!--
	var RecaptchaOptions = {
theme : \'custom\',
    custom_theme_widget: \'recaptcha_widget\',
        lang: \''.$lang['wysiwyg_language'].'\'
	};

//-->
</script>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k='.$config['recaptcha_public_key'].'"></script>' );

        $tpl->set_block( "'\\[sec_code\\](.*?)\\[/sec_code\\]'si", "" );
        $tpl->set( '{reg_code}', "" );

    } else {

        $tpl->set( '[sec_code]', "" );
        $tpl->set( '[/sec_code]', "" );
        $tpl->set( '{reg_code}', "<span id=\"dle-captcha\"><img src=\"" . $path['path'] . "engine/modules/antibot/antibot.php\" alt=\"{$lang['sec_image']}\" border=\"0\" /><br /><a onclick=\"reload(); return false;\" href=\"#\">{$lang['reload_code']}</a></span>" );
        $tpl->set_block( "'\\[recaptcha\\](.*?)\\[/recaptcha\\]'si", "" );
        $tpl->set( '{recaptcha}', "" );
    }

} else {

    $tpl->set( '{reg_code}', "" );
    $tpl->set( '{recaptcha}', "" );
    $tpl->set_block( "'\\[sec_code\\](.*?)\\[/sec_code\\]'si", "" );
    $tpl->set_block( "'\\[recaptcha\\](.*?)\\[/recaptcha\\]'si", "" );
}
///////////////////////////////////

if( $user_group[$member_id['user_group']]['icon'] ) $tpl->set( '{group-icon}', "<img src=\"" . $user_group[$member_id['user_group']]['icon'] . "\" alt=\"\" />" );
else $tpl->set( '{group-icon}', "" );

if ($member_id['favorites']) {
    $tpl->set( '{favorite-count}', count(explode("," ,$member_id['favorites'])) );
}
else $tpl->set( '{favorite-count}', '0' );

if ( count(explode("@", $member_id['foto'])) == 2 ) {
    $tpl->set( '{foto}', 'http://www.gravatar.com/avatar/' . md5(trim($member_id['foto'])) . '?s=' . intval($user_group[$member_id['user_group']]['max_foto']) );
} else {
    if( $member_id['foto'] and (file_exists( ROOT_DIR . "/uploads/fotos/" . $member_id['foto'] )) ) $tpl->set( '{foto}', $config['http_home_url'] . "uploads/fotos/" . $member_id['foto'] );
    else $tpl->set( '{foto}', "{THEME}/dleimages/noavatar.png" );
}

if ( $user_group[$member_id['user_group']]['allow_admin'] ) {
    $tpl->set( '[admin-link]', "" );
    $tpl->set( '[/admin-link]', "" );
} else {
    $tpl->set_block( "'\\[admin-link\\](.*?)\\[/admin-link\\]'si", "" );
}

if ($config['allow_alt_url']) {
    $tpl->set( '{profile-link}', $profile_module_url . "" . urlencode ( $member_id['name'] ) . "/" );
    $tpl->set( '{stats-link}', $config['http_home_url'] . "statistics.html" );
    $tpl->set( '{addnews-link}', $config['http_home_url'] . "addnews.html" );
    $tpl->set( '{favorites-link}', $config['http_home_url'] . "favorites/" );
    $tpl->set( '{newposts-link}', $config['http_home_url'] . "newposts/" );

} else {
    $tpl->set( '{profile-link}', $PHP_SELF . "?subaction=userinfo&user=" . urlencode ( $member_id['name'] ) );
    $tpl->set( '{stats-link}', $PHP_SELF . "?do=stats" );
    $tpl->set( '{addnews-link}', $PHP_SELF . "?do=addnews" );
    $tpl->set( '{favorites-link}', $PHP_SELF . "?do=favorites" );
    $tpl->set( '{newposts-link}', $PHP_SELF . "?subaction=newposts" );

}

///// определяем выводить или нет почтовую ссылку ////////
if ($config['http_home_url_b1g']!='') {
    $tpl->set('[b1gmail]',"");
    $tpl->set('[/b1gmail]',"");
} else $tpl->set_block("'\\[b1gmail\\](.*?)\\[/b1gmail\\]'si","");

$tpl->set('{b1gmail_domain}',$config['http_home_url_b1g']);
$tpl->set('{b1gmail}',$config['http_home_url_b1g']);

$bt=$config['http_home_url'];
$bt = str_replace('http://','',$bt);
$bt = str_replace('https://','',$bt);
$bt = str_replace('/','',$bt);
$subdom = explode('.',$bt);
$cosubdo = count($subdom)-2;
$bt = $subdom[$cosubdo];

$tpl->set('{domain}',$bt); //// домен - адрес почты установленной

//////////////////////////////////////////////////////////////

$tpl->compile( 'login_panel' );
$tpl->clear();

if ($config['site_offline']) include_once ENGINE_DIR . '/modules/offline.php';

//////////////////////////////// WEB2WORK GROUP ///////////////////////////////////////
if ($do!='' or $subaction!='')
{
    require_once ENGINE_DIR . '/modules/calendar.php';
//if ($config['allow_topnews']) include_once ENGINE_DIR . '/modules/topnews.php';
    if ($config['rss_informer']) include_once ENGINE_DIR . '/modules/rssinform.php';
//if ($config['allow_tags']) include_once ENGINE_DIR . '/modules/tagscloud.php';
}
///////////////////////////////////////////////////////////////////////////////////////

require_once ROOT_DIR . '/engine/engine.php';

if ($config['allow_votes']) include_once ENGINE_DIR . '/modules/vote.php';
if ($config['allow_banner']) include_once ENGINE_DIR . '/modules/banners.php';

$onlineusers = online_users_now();

?>