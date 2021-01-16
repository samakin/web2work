<?PHP
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
 Файл: engine.php
-----------------------------------------------------
 Назначение: подключение основных компонентов
=====================================================
*/
if (! defined ( 'DATALIFEENGINE' )) {
	die ( "Hacking attempt!" );
}

if ($cstart < 0) $cstart = 0;
$CN_HALT = FALSE;

$allow_add_comment = FALSE;
$allow_active_news = FALSE;
$allow_comments = FALSE;
$allow_userinfo = FALSE;
$active = FALSE;
$newsmodule = FALSE;
$disable_index = FALSE;
$social_tags = array();
$canonical = FALSE;

/////////////// МОДУЛИ WEB2WORK GROUP ////////////////////
/// Параметр $m является определяющим для стандартных модулей DLE
//$keymodinfo_structure = get_vars ( "modules" );
if ($do) {
    foreach ($mod_info as $value_modules) {
        $value_modules[name] = trim(strip_tags(stripslashes(str_replace("\n", " ", $value_modules[name]))));
        $value_modules[url] = trim(strip_tags(stripslashes(str_replace("\n", " ", $value_modules[url]))));

        if ($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] == $value_modules['url'] or $_SERVER['REQUEST_URI'] == $value_modules['url']) {

            if (!$titleoff) {
                if ($value_modules[title] and !$value_modules[msgbox] and !$value_modules[meta]) {
                    $title = $value_modules[title];
                } elseif ($value_modules[title] or $value_modules[msgbox] or $value_modules[meta]) {
                    $title = $value_modules[title];
                    $tebe = $value_modules[title];
                    if ($value_modules[msgbox]) $metatags['description'] = $value_modules[msgbox];
                    if ($value_modules[meta]) $metatags['keywords'] = $value_modules[meta];
                } else {
                    $title = $value_modules[text];
                    $titleoff = 1;
                }
            }

            $aviable_array = explode(',', $value_modules['group']);
            if (!$value_modules['group'] or ($value_modules['group'] and in_array($member_id['user_group'], $aviable_array))) {
                if ($value_modules['action'] == 1 and $value_modules['des']) {
                    if (!$value_modules[module_do]) $tpl->load_template('static.tpl');
                    else $tpl->load_template($value_modules[module_do] . '.tpl');
                    if ($value_modules[title]) $static_descr = $value_modules[title];
                    else $static_descr = $value_modules[text];
                    if ($value_modules[des]) $template = $value_modules[des];
                    else $template = $lang['web2work_page_notfull'];
                    $tpl->set('{description}', $static_descr);
                    $tpl->set('{static}', $template);
                    $tpl->compile('content');
                    if ($value_modules[top_id] != 0) $title_speedbar = get_p_cat($value_modules[top_id], 0, true);
                }
            } else {
                @header( "HTTP/1.0 404 Not Found" );
                if (!$off) {
                    msgbox($lang['web2work_warning'], $lang['web2work_page_access']);
                    $off = 1;
                }
            }

        }

        if ($off!=1) {
        if ($do == $value_modules[name] and $do != '') {
            if ($value_modules['action'] != 1) {
                if ($value_modules['action'] == 3 and !$is_logged) {
                    msgbox($value_modules[msgbox], $value_modules['header']);
                    $m = "1";
                } else if ($value_modules['action'] == 4 and !$is_logged) {
                    header("Location: " . $value_modules['header'] . "", '');
                    $m = "1";
                } else {

                    switch ($do) {
                        case "" . trim(strip_tags(stripslashes(str_replace("\n", " ", $value_modules[name])))) . "":
                            include ENGINE_DIR . '' . trim(strip_tags(stripslashes(str_replace("\n", " ", $value_modules['do'])))) . '';
                            $m = "1";
                            if ($do != 'cat') $title_speedbar = '<a href="' . $value_modules[url] . '">' . $value_modules[text] . '</a>';
                            break;
                        default:
                            "";
                        }
                    }
                }
            }
        }
    }
}
//unset($keymodinfo_structure);
////////////////////////////////////////////////////////

if (!$m) {
    switch ($do) {

        case "search" :

            if ($_REQUEST['mode'] == "advanced") $_REQUEST['full_search'] = 1;
            include ENGINE_DIR . '/modules/search.php';
            break;

        case "changemail" :
            include ENGINE_DIR . '/modules/changemail.php';
            break;

        case "change_city" :
            include ENGINE_DIR . '/modules/change_city.php';
            break;

        case "login" :
            include ENGINE_DIR . '/modules/login.php';
            break;

        case "deletenews" :
            include ENGINE_DIR . '/modules/deletenews.php';
            break;

        case "comments" :
            include ENGINE_DIR . '/modules/comments.php';
            break;

        case "stats" :
            include ENGINE_DIR . '/modules/stats.php';
            break;

        case "addnews" :
            include ENGINE_DIR . '/modules/addnews.php';
            break;

        case "register" :
            include ENGINE_DIR . '/modules/register.php';
            break;

        case "lostpassword" :
            include ENGINE_DIR . '/modules/lostpassword.php';
            break;

        case "rules" :
            $_GET['page'] = "dle-rules-page";
            include ENGINE_DIR . '/modules/static.php';
            break;

        case "static" :
            include ENGINE_DIR . '/modules/static.php';
            break;

        case "alltags" :
            include_once ENGINE_DIR . '/modules/tagscloud.php';
            break;

        case "favorites" :
            if ($is_logged) {

                $config['allow_cache'] = false;

                include ENGINE_DIR . '/modules/favorites.php';

            } else
                msgbox($lang['all_err_1'], $lang['fav_error']);
            break;

        case "feedback" :
            include ENGINE_DIR . '/modules/feedback.php';
            break;

        case "lastcomments" :
            include ENGINE_DIR . '/modules/lastcomments.php';
            break;

        case "get_photo_print" :
            include ENGINE_DIR . '/modules/content/get_photo_print.php';
            break;

        case "sms_groups" :
            include ENGINE_DIR . '/modules/content/sms_groups.php';
            break;


        case "pm" :
            include ENGINE_DIR . '/modules/pm.php';
            break;

        case "unsubscribe" :
            $_GET['post_id'] = intval($_GET['post_id']);
            $_GET['user_id'] = intval($_GET['user_id']);

            if ($_GET['post_id'] AND $_GET['user_id'] AND $_GET['hash']) {

                $row = $db->super_query("SELECT hash FROM " . PREFIX . "_subscribe WHERE news_id='{$_GET['post_id']}' AND user_id='{$_GET['user_id']}'");

                if ($row['hash'] AND $row['hash'] == $_GET['hash']) {

                    $db->query("DELETE FROM " . PREFIX . "_subscribe WHERE news_id='{$_GET['post_id']}' AND user_id='{$_GET['user_id']}'");
                    msgbox($lang['all_info'], $lang['unsubscribe_ok']);

                } else {
                    msgbox($lang['all_info'], $lang['unsubscribe_err']);
                }

            } else {
                msgbox($lang['all_info'], $lang['unsubscribe_err']);
            }

            break;

        default :

            if ($view_template=='rss') include_once(ENGINE_DIR . '/modules/content/news/news.php');

             // ################ Вывод отдельной категории #################
            if ($subaction == 'userinfo') {
                // ################ Вывод профиля пользователя #################
                if ($cstart) {

                    $cstart = $cstart - 1;
                    $cstart = $cstart * $config['news_number'];

                }

                $url_page = $profile_module_url. "" . urlencode($user);
                $user_query = "subaction=userinfo&user=" . urlencode($user);

                if ($member_id['name'] == $user or $user_group[$member_id['user_group']]['allow_all_edit']) {
                    if (isset ($_SESSION['dle_sort_userinfo'])) $news_sort_by = $_SESSION['dle_sort_userinfo'];
                    if (isset ($_SESSION['dle_direction_userinfo'])) $news_direction_by = $_SESSION['dle_direction_userinfo'];

                    $sql_select = "SELECT p.id, p.autor, p.date, p.short_story, CHAR_LENGTH(p.full_story) as full_story, p.xfields, p.title, p.category, p.alt_name, p.comm_num, p.allow_comm, p.fixed, p.tags, e.news_read, e.allow_rate, e.rating, e.vote_num, e.votes, e.view_edit, e.editdate, e.editor, e.reason FROM " . PREFIX . "_post p LEFT JOIN " . PREFIX . "_post_extras e ON (p.id=e.news_id) WHERE autor = '{$user}' AND approve=0 ORDER BY " . $news_sort_by . " " . $news_direction_by . " LIMIT " . $cstart . "," . $config['news_number'];
                    $sql_count = "SELECT COUNT(*) as count FROM " . PREFIX . "_post WHERE autor = '$user' AND approve=0";
                    $allow_active_news = true;
                } else {
                    $allow_active_news = false;
                }

                $config['allow_cache'] = false;
            }

            //####################################################################################################################
            //         Просмотр профиля пользователя
            //####################################################################################################################
            if ($subaction == 'userinfo' or $subaction == 'userinfo_about' or $subaction == 'userinfo_holidays' or $subaction == 'userinfo_foto_log'
                or $subaction == 'userinfo_edit' or $subaction == 'userinfo_guest' or $subaction == 'userinfo_friend'
                or $subaction == 'userinfo_plus' or $subaction == 'userinfo_minus' or $subaction == 'allnews'
                or $subaction == 'userinfo_prigl' or $subaction == 'userinfo_guests' or $subaction == 'userinfo_groups'
                or $subaction == 'userinfo_afisha' or $subaction == '' and $do == '' and $year == '' and $catalog == '' and $day == '' and $month == ''
            ) {
                $allow_active_news = FALSE;

                $allow_userinfo = TRUE;

                if ($subaction == 'userinfo') {
                    include_once(ENGINE_DIR . '/modules/profile.php');
                    $allow_active_news = FALSE;
                }
                if ($subaction == 'allnews' and $user != '') {
                    include_once(ENGINE_DIR . '/modules/profile/profile_blog.php');
                    $allow_active_news = FALSE;
                }
            } else {
                $allow_active_news = true;
            }

    }
}
/*
=====================================================
 Вывод заголовка страницы
=====================================================
*/
$titl_e = '';
$nam_e = '';
$rss_url = '';

if ($tebe) $titl_e = $tebe;

if ($do == "cat" and $category != '' and $subaction == '') {

	$metatags['description'] = ($cat_info[$category_id]['descr'] != '') ? $cat_info[$category_id]['descr'] : $metatags['description'];
	$metatags['keywords'] = ($cat_info[$category_id]['keywords'] != '') ? $cat_info[$category_id]['keywords'] : $metatags['keywords'];

	if ($cat_info[$category_id]['metatitle'] != '') $metatags['header_title'] = $cat_info[$category_id]['metatitle'];
	else $nam_e = stripslashes ( $cat_info[$category_id]['name'] );

	if ($config['allow_alt_url']) {
		$rss_url = $url_page . "/" . "rss.xml";
	} else {
		$rss_url = $config['http_home_url'] . "engine/rss.php?do=cat&category=" . $cat_info[$category_id]['alt_name'];
	}

} elseif ($subaction == 'userinfo') {
	$nam_e = $user;

	if ($config['allow_alt_url']) {
		$rss_url = $url_page . "/" . "rss.xml";
	} else {
		$rss_url = $config['http_home_url'] . "engine/rss.php?subaction=allnews&user=" . urlencode ( $user );
	}

} elseif ($subaction == 'allnews') {
	$nam_e = $lang['show_user_news'] . ' ' . $user;

	if ($config['allow_alt_url']) {
		$rss_url = $profile_module_url . "" . urlencode ( $user ) . "/" . "rss.xml";
	} else {
		$rss_url = $config['http_home_url'] . "engine/rss.php?subaction=allnews&user=" . urlencode ( $user );
	}

} elseif ($subaction == 'newposts') $nam_e = $lang['title_new'];
elseif ($do == 'stats') $nam_e = $lang['title_stats'];
elseif ($do == 'addnews') $nam_e = $lang['title_addnews'];
elseif ($do == 'register') $nam_e = $lang['title_register'];
elseif ($do == 'favorites') $nam_e = $lang['title_fav'];
elseif ($do == 'pm') $nam_e = $lang['title_pm'];
elseif ($do == 'feedback') $nam_e = $lang['title_feed'];
elseif ($do == 'lastcomments') $nam_e = $lang['title_last'];
elseif ($do == 'lostpassword') $nam_e = $lang['title_lost'];
elseif ($do == 'search') $nam_e = $lang['title_search'];
elseif ($do == 'static') $titl_e = $static_descr;
elseif ($do == 'lastnews') $nam_e = $lang['last_news'];
elseif ($do == 'alltags') $nam_e = $lang['tag_cloud'];
elseif ($do == 'tags') $nam_e = stripslashes($tag);
elseif ($do == 'xfsearch') $nam_e = $xf;
elseif ($catalog != "") {
	$nam_e = $lang['title_catalog'] . ' &raquo; ' . $catalog;

	if ($config['allow_alt_url']) {
		$rss_url = $config['http_home_url'] . "catalog/" . urlencode ( $catalog ) . "/" . "rss.xml";
	} else {
		$rss_url = $config['http_home_url'] . "engine/rss.php?catalog=" . urlencode ( $catalog );
	}

}
else{

if ($nam_e=='')
{
    if (($subaction == '' or $newsid == '') and !$news_found) {
        if ($title=='') $title=$titlev;
        $nam_e=$title;
        $metatags['description'] = $name_desc;
        $metatags['keywords'] = $name_dk;
    }
}

if ($nam_e=='')
{
	if ($year != '' and $month == '' and $day == '') $nam_e = $lang['title_date'] . ' ' . $year . ' ' . $lang['title_year'];
	if ($year != '' and $month != '' and $day == '') $nam_e = $lang['title_date'] . ' ' . $r[$month - 1] . ' ' . $year . ' ' . $lang['title_year1'];
	if ($year != '' and $month != '' and $day != '' and $subaction == '') $nam_e = $lang['title_date'] . ' ' . $day . '.' . $month . '.' . $year;
	if (($subaction != '' or $newsid != '') and $news_found) $titl_e = $metatags['title'];
}
}

if (intval($_GET['cstart']) > 1 ){

	$page_extra = ' &raquo; '.$lang['news_site'].' '.intval($_GET['cstart']);

} else $page_extra = '';

if ($nam_e) {

	$metatags['title'] = $nam_e . $page_extra . ' &raquo; ' . $metatags['title'];
	$rss_title = $metatags['title'];

} elseif ($titl_e) {

	$metatags['title'] = $titl_e . $page_extra . ' &raquo; ' . $config['home_title'];

} else $metatags['title'] .= $page_extra;

if ( $metatags['header_title'] ) $metatags['title'] = stripslashes($metatags['header_title'].$page_extra);
if ( $disable_index ) $disable_index = "\n<meta name=\"robots\" content=\"noindex,nofollow\" />"; else $disable_index = "";

if (! $rss_url) {

	if ($config['allow_alt_url']) {
		$rss_url = $config['http_home_url'] . "rss.xml";
	} else {
		$rss_url = $config['http_home_url'] . "engine/rss.php";
	}

	$rss_title = $config['home_title'];
}

$s_meta = "";

if ( count($social_tags) ) {

	foreach ($social_tags as $key => $value) {

		$s_meta .= "\n<meta property=\"og:{$key}\" content=\"{$value}\" />";

	}
}
if (!$metatags['description']) $metatags['description'] = $config['description'];
if (!$metatags['keywords']) $metatags['keywords'] = $config['keywords'];

if ($config['templates_logo']) $othercss[] = '.inline.logo a img {display: none;} .m-menu__logo, .t-top-menu__logo-image {display:none} .m-menu__logo-link, .t-brand-logo {width: 50px;height: 50px;display: block;margin: 0 auto;} .t-brand-logo {background-position-y: 10px;background-repeat: no-repeat;} .t-brand-logo, .top-box .logo a, .fot-logo, .m-menu__logo-link {background-image: url(\'/uploads/'.$config['templates_logo'].'\')!important;background-size: contain!important;}';
if ($config['template_color_header']) $othercss[] = '.bgbrow,.line,.bggreen,.border-block.green{background: #'.$config['template_color_header'].'!important;}.b-ad-btn:hover{border-bottom:#'.$config['template_color_header'].'!important;}a.b-ad-btn{border:#'.$config['template_color_header'].'!important;}a.b-ad-btn ins{color:#'.$config['template_color_header'].'!important;}.b-submenu-item__bank-zajavka__btn,.scrollTop,.scrollTop:hover,.stat p,#bg-kot{background-color: #'.$config['template_color_header'].'!important;}.scater a.selected,.top-box, a.b-ad-btn b, .bugreen,.fon_greens {background: #'.$config['template_color_header'].'!important;}.registry ul li a:link, .registry ul li a:visited,.edit_block a,.cpage.category {color:#'.$config['template_color_header'].'!important;}.stations div.station:hover, .stations div.odd:hover{border:1px solid #'.$config['template_color_header'].'!important;}';
if ($config['template_color_footer']) $othercss[] = '.footer {background: #'.$config['template_color_footer'].'!important;}';
if ($config['template_color_logo']) $othercss[] = '.top-box .logo a, .fot-logo {background-color: #'.$config['template_color_logo'].'!important;}.fot-link{border-bottom:1px solid #'.$config['template_color_logo'].'!important;}';
if ($config['template_color_submenu']) $othercss[] = '.bgyel,.border-block ul li,.submenu_list_inline .submenu_elem:hover,.submenu_list_inline .submenu_elem_inline:hover,.ui-widget-content,li:hover.greys,.bgtextgrow,.bggrins, #bg-nedv,.menu .sub_menu .submenu_list.vnews li:hover{background: #'.$config['template_color_submenu'].'!important;background-color: #'.$config['template_color_submenu'].'!important;}.layout{border-left:1px solid #'.$config['template_color_submenu'].'!important;}.top-box .menu li:hover,.stations div.station:hover, .stations div.odd:hover{background: #'.$config['template_color_submenu'].'!important;}.bugreen{border:1px solid #'.$config['template_color_submenu'].'!important}.search-box .search .inp{box-shadow:0 0 0 0 #'.$config['template_color_submenu'].' inset!important;background-color: #'.$config['template_color_submenu'].'!important;border: #'.$config['template_color_submenu'].'!important;}.sub_menu, .submenu_list, .inside, .footer-center .menu li a:hover {background: #'.$config['template_color_submenu'].'!important;}.footer-center .menu li a{color:#'.$config['template_color_submenu'].'!important;}';
if ($config['template_color_link']) $othercss[] = '.content a {border-bottom:0px!important}.logged:hover .sub_menu li a,.search input[type="text"], .search input[type="url"],.news_chas a, .list_auto.bgyel a,.menu .submenu_list.vnews li a:hover, #red:hover, .submenu_list.vnews li a:hover, a.green, .green, .form_search_doska ul li span, .top-box .menu li:hover a span, .top-box .menu li:last-child:hover a, .submenu_list .submenu_elem_size1, .submenu_list .submenu_elem_size2{color: #'.$config['template_color_link'].'!important;} .layout .submenu_list.vnews li:first-child a{color: #'.$config['template_color_link'].'!important;}.submenu_elem_size2{color: #'.$config['template_color_link'].'!important;}.top-box .menu li:hover{color: #'.$config['template_color_link'].'!important;}.submenu_elem_size1, .top-box .menu li a:hover, .top-box .menu li:last-child:hover a, .footer-center .menu li a:hover {color: #'.$config['template_color_link'].'!important;}';

if (is_array($othercss)) $implode_css = '<style>'.implode('',$othercss).'</style>';

$metatags = <<<HTML
<meta http-equiv="Content-Type" content="text/html; charset={$config['charset']}" />
<title>{$metatags['title']}</title>
<meta name="description" content="{$metatags['description']}" />
<meta name="keywords" content="{$metatags['keywords']}" />{$disable_index}
<meta name="generator" content="Web2Work (https://web2work.ru)" />{$s_meta}
<meta property="og:title" content="{$metatags['title']}">
<meta property="og:description" content="{$metatags['description']}">
<meta property="og:site_name" content="{$config['short_title']}">
<meta property="og:url" content="/">
<meta property="og:image" content="{$config['http_home_url']}uploads/app-image.png">
<meta property="og:image:width" content="">
<meta property="og:image:height" content="">
<meta property="article:author" content="{$config['short_title']}">
<meta property="article:publisher" content="{$config['short_title']}">
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:title" content="{$metatags['title']}">
<meta property="twitter:description" content="{$metatags['description']}">
<meta property="twitter:url" content="/">
<meta property="twitter:image" content="{$config['http_home_url']}uploads/app-image.png">
<meta property="title" content="{$metatags['title']}">
<link href="{$config['http_home_url']}favicon.ico" type="image/x-icon" rel="icon">
<link href="{$config['http_home_url']}favicon.ico" type="image/x-icon" rel="shortcut icon">
<link rel="apple-touch-icon" href="{$config['http_home_url']}uploads/favicon.png">
<link rel="image_src" href="{$config['http_home_url']}uploads/app-image.png">
<link rel="search" type="application/opensearchdescription+xml" href="{$config['http_home_url']}engine/opensearch.php" title="{$config['home_title']}" />
{$implode_css}
HTML;

if ($canonical) {

	$metatags .= <<<HTML

<link rel="canonical" href="{$config['http_home_url']}" />
HTML;

}

if ($config['allow_rss']) $metatags .= <<<HTML

<link rel="alternate" type="application/rss+xml" title="{$rss_title}" href="{$rss_url}" />
HTML;

/*
=====================================================
 Формирование speedbar
=====================================================
*/
if ($config['speedbar'] and ! isset ( $view_template )) {

	  $s_navigation = "<a href=\"{$config['http_home_url']}\">Главная</a>";

        if ($title_speedbar and $nam_e and ($_REQUEST['action'] or $_REQUEST['inaction'] or $_REQUEST['liaction'])) $s_navigation .= " <span>»</span> " . $title_speedbar ." <span>»</span> " . $nam_e."";
        elseif (!$nam_e and $title_speedbar) $s_navigation .= " <span>»</span> " . $title_speedbar ."";
        elseif ($do and (!$_REQUEST['action'] or !$_REQUEST['inaction'] or !$_REQUEST['liaction'])) $s_navigation .= " <span>»</span> " . $title_speedbar ."";

        if ($category_id) $s_navigation .= " <span>»</span> " . get_categories ( $category_id );

        elseif ($do == 'tags') {

                if ($config['allow_alt_url']) $s_navigation .= " <span>»</span> <a href=\"" . $config['http_home_url'] . "tags/\">" . $lang['tag_cloud'] . "</a> <span>»</span> " . $tag;
                else $s_navigation .= " &raquo; <a href=\"?do=tags\">" . $lang['tag_cloud'] . "</a> <span>»</span> " . $tag;

        } elseif ($nam_e and $title_speedbar=='') $s_navigation .= " <span>»</span> " . $nam_e."";

        if ($titl_e) $s_navigation .= " <span>»</span> " . $titl_e;

        $tpl->load_template ( 'speedbar.tpl' );
	$tpl->set ( '{speedbar}', '<span id=\'dle-speedbar\'>' . stripslashes ( $s_navigation ) . '</span>' );
	$tpl->compile ( 'speedbar' );
	$tpl->clear ();

}

?>