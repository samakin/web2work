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

$limit = 5;

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

function create_metatags_ub($story) {
    global $config, $db;

    $keyword_count = 20;
    $newarr = array ();
    $headers = array ();
    $quotes = array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", "\\", ",", ".", "/", "¬", "#", ";", ":", "@", "~", "[", "]", "{", "}", "=", "-", "+", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"');
    $fastquotes = array ("\x22", "\x60", "\t", "\n", "\r", '"', '\r', '\n', "$", "{", "}", "[", "]", "<", ">", "\\");

    $story = preg_replace( "#\[hide\](.+?)\[/hide\]#is", "", $story );
    $story = preg_replace( "'\[attachment=(.*?)\]'si", "", $story );
    $story = preg_replace( "'\[page=(.*?)\](.*?)\[/page\]'si", "", $story );
    $story = str_replace( "{PAGEBREAK}", "", $story );
    $story = str_replace( "&nbsp;", " ", $story );

    $story = str_replace( '<br />', ' ', $story );
    $story = strip_tags( $story );
    $story = preg_replace( "#&(.+?);#", "", $story );
    $story = trim(str_replace( " ,", "", $story ));

    if( trim( $_REQUEST['meta_title'] ) != "" ) {

        $headers['title'] = trim( htmlspecialchars( strip_tags( stripslashes($_REQUEST['meta_title'] ) ), ENT_COMPAT, $config['charset'] ) );
        $headers['title'] = $db->safesql(str_replace( $fastquotes, '', $headers['title'] ));

    } else $headers['title'] = "";

    if( trim( $_REQUEST['descr'] ) != "" ) {

        $headers['description'] = strip_tags( stripslashes( $_REQUEST['descr'] ) );

        if( dle_strlen( $headers['description'], $config['charset'] ) > 200 ) {

            $headers['description'] = dle_substr( $headers['description'], 0, 200, $config['charset'] );

            if( ($temp_dmax = dle_strrpos( $headers['description'], ' ', $config['charset'] )) ) $headers['description'] = dle_substr( $headers['description'], 0, $temp_dmax, $config['charset'] );

        }

        $headers['description'] = $db->safesql( str_replace( $fastquotes, '', $headers['description'] ));

    } elseif($config['create_metatags']) {

        $story = str_replace( $fastquotes, '', $story );

        $headers['description'] = stripslashes($story);

        if( dle_strlen( $headers['description'], $config['charset'] ) > 200 ) {

            $headers['description'] = dle_substr( $headers['description'], 0, 200, $config['charset'] );

            if( ($temp_dmax = dle_strrpos( $headers['description'], ' ', $config['charset'] )) ) $headers['description'] = dle_substr( $headers['description'], 0, $temp_dmax, $config['charset'] );

        }

        $headers['description'] = $db->safesql( $headers['description'] );

    } else {

        $headers['description'] = '';

    }

    if( trim( $_REQUEST['keywords'] ) != "" ) {

        $headers['keywords'] = $db->safesql( str_replace( $fastquotes, " ", strip_tags( stripslashes( $_REQUEST['keywords'] ) ) ) );

    } elseif( $config['create_metatags'] ) {

        $story = str_replace( $quotes, ' ', $story );

        $arr = explode( " ", $story );

        foreach ( $arr as $word ) {
            if( dle_strlen( $word, $config['charset'] ) > 4 ) $newarr[] = $word;
        }

        $arr = array_count_values( $newarr );
        arsort( $arr );

        $arr = array_keys( $arr );

        $total = count( $arr );

        $offset = 0;

        $arr = array_slice( $arr, $offset, $keyword_count );

        $headers['keywords'] = $db->safesql( implode( ", ", $arr ) );
    } else {

        $headers['keywords'] = '';

    }

    return $headers;
}

function get_photo_albums_newflash($id, $path_vdss, $razm)
{
    global $config;

    include_once ENGINE_DIR . '/classes/thumb.class.php';

    $copy_image = file_get_contents($path_vdss);
    $res = file_put_contents(ROOT_DIR . "/uploads/fotoalbum/" . $id . "", $copy_image);
    $res_full = file_put_contents(ROOT_DIR . "/uploads/fotoalbum/full/" . $id . "", $copy_image);

    if ($res) {
        @chmod(ROOT_DIR . "/uploads/fotoalbum/" . $id . "", 0666);
        $thumb1 = new thumbnail(ROOT_DIR . "/uploads/fotoalbum/" . $id . "");

        if ($thumb1->size_auto($razm)) {
            $thumb1->jpeg_quality($config['jpeg_quality']);
            if ($config['allow_watermark'] == "yes") $thumb1->insert_watermark($config['max_watermark']);
            $thumb1->save(ROOT_DIR . "/uploads/fotoalbum/" . $id . "");
        }
    }


    return $out[2];
}

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

$added_time = time() + ($config['date_adjust'] * 60);
$thistime = date("Y-m-d", $added_time);

$sup_vk_list = $db->query( "SELECT * FROM " . PREFIX . "_vk_groups where date!='".$thistime."' ORDER BY id DESC LIMIT 1" );
while ( $row_vk_list = $db->get_row($sup_vk_list) ) {

    $wid = $row_vk_list[id_group];
    $cid = $row_vk_list[cat_id];

    include_once ENGINE_DIR . '/classes/parse.class.php';
    $parse = new ParseFilter(Array(), Array(), 1, 1);

    $db->query("UPDATE " . USERPREFIX . "_vk_groups SET date='" . $thistime . "' WHERE id_group='" . $wid . "'");

    define('FOLDER_PREFIX', date("Y-m") . "/");

    if (!is_dir(ROOT_DIR . "/uploads/posts/" . FOLDER_PREFIX)) {

        @mkdir(ROOT_DIR . "/uploads/posts/" . FOLDER_PREFIX, 0777);
        @chmod(ROOT_DIR . "/uploads/posts/" . FOLDER_PREFIX, 0777);
        @mkdir(ROOT_DIR . "/uploads/posts/" . FOLDER_PREFIX . "thumbs", 0777);
        @chmod(ROOT_DIR . "/uploads/posts/" . FOLDER_PREFIX . "thumbs", 0777);
    }

    if (!is_dir(ROOT_DIR . "/uploads/posts/" . FOLDER_PREFIX)) {

        echo "/uploads/posts/" . FOLDER_PREFIX . " cannot created.";
    }
    $upload_path = ROOT_DIR . "/uploads/posts/" . FOLDER_PREFIX;
    $realaddr = $config[http_home_url] . "uploads/posts/" . FOLDER_PREFIX;
    $realaddr_thumb = $config[http_home_url] . "uploads/posts/" . FOLDER_PREFIX . "thumbs/";
    include_once ENGINE_DIR . '/classes/thumb.class.php';
    $admin = $db->super_query("SELECT * FROM " . PREFIX . "_users where user_group='1' ORDER BY user_id ASC LIMIT 1");
//////////////// ПРОВЕРКА СУЩЕСТВОВАНИЯ ДАННОЙ ЗАПИСИ!!33050863!32182751 ///////12 категория/////drive2 10537686///smotra 11571896///////////////
    $bcount = 0;
    $public->wallGetMsgImp($wid, true);
    $command = $public->wallGetMsgImp($wid, true);
    $arrayz = objectToArray($command);

    $wall_get_ingroup = array();
    $key = 0;
    $iid = array();
    $vid_list = array();
    foreach ($arrayz as $poster) {
        foreach ($poster as $po) {
            $key++;
            if ($key<=$limit) {
                $wall_get_ingroup[] = array();

                $iid[] = 'forum_update="' . $po[id] . '"';
                $wall_get_ingroup[$key][id] = $po[id];
                $wall_get_ingroup[$key][forum_update] = $po[id];
                $entered_text = preg_replace('#\[(.+?)\|(.+?)\]#si', '<a href="http://vk.com/\\1">\\2</a>', $po[text]);
                //echo "<div>".convert_unicode($entered_text)."<br>";
                $wall_get_ingroup[$key][text] = convert_unicode($entered_text);
                if (is_array($po[attachments])) {
                    $kphoto = 0;
                    $kvideo = 0;
                    foreach ($po[attachments] as $atain) {

                        if (is_array($atain[photo])) {
                            if ($atain[photo][src_xxbig] != '') {
                                //echo "<a href='".$atain[photo][src_xxbig]."'><img src='".$atain[photo][src]."'></a>";
                                $img1 = $atain[photo][src_xxbig];
                                $img2 = $atain[photo][src];
                            } elseif ($atain[photo][src_xbig] != '') {
                                //echo "<a href='".$atain[photo][src_xbig]."'><img src='".$atain[photo][src]."'></a>";
                                $img1 = $atain[photo][src_xbig];
                                $img2 = $atain[photo][src];
                            } elseif ($atain[photo][src_big] != '') {
                                //echo "<a href='".$atain[photo][src_big]."'><img src='".$atain[photo][src]."'></a>";
                                $img1 = $atain[photo][src_big];
                                $img2 = $atain[photo][src];
                            } elseif ($atain[photo][src] != '') {
                                //echo "<a href='".$atain[photo][src]."'><img src='".$atain[photo][src]."'></a>";
                                $img1 = $atain[photo][src];
                                $img2 = $atain[photo][src];
                            }
                            $kphoto++;
                            $wall_get_ingroup[$key][photo][$kphoto][photo_big] = $img1;
                            $wall_get_ingroup[$key][photo][$kphoto][photo_min] = $img2;
                        }
                        if (is_array($atain[video])) {
                            $kvideo++;
                            //echo "<br>Заголовок:".convert_unicode($atain[video][title])."<br> Описание: ".convert_unicode($atain[video][description])."<br><img src='".$atain[video][image_big]."'>";
                            $wall_get_ingroup[$key][video][$kvideo][video_title] = convert_unicode($atain[video][title]);
                            $wall_get_ingroup[$key][video][$kvideo][video_text] = convert_unicode($atain[video][description]);
                            $wall_get_ingroup[$key][video][$kvideo][video_img] = $atain[video][image_big];
                            $wall_get_ingroup[$key][video][$kvideo][keyser] = $atain[video][vid];
                            $vid_list[$key] = $atain[video][owner_id] . '_' . $atain[video][vid];
                        }
                    }
                }
                //echo "</div>";
            }
        }
    }

///print_r($vid_list);
    $vid_list = implode(",", $vid_list);

    if ($vid_list != '') {
        $command_video = $public->VideoGet($vid_list, true);
        $command_video = objectToArray($command_video);
    }

    function getvid($get, $vid_list)
    {
        global $public, $command_video;
        if ($vid_list != '') {
            /////////// формируем массив видео /////////////
            if (is_array($command_video)) {
                foreach ($command_video as $poster) {
                    foreach ($poster as $po) {
                        if ($get == $po[vid]) $get = $po[player];
                    }
                }
            }
        }
        return $get;

    }

    $iid = '(' . implode(" or ", $iid) . ')';
    if (!$iid) $iid = "forum_update='sadasdas'";

    $added_time = time() + ($config['date_adjust'] * 60);
    $thistime = date("Y-m-d", $added_time);

    $who = array();
    $vi = 0;
    $sup = $db->query("SELECT * FROM " . PREFIX . "_post where $iid");
    while ($row = $db->get_row($sup)) {
        $vi++;
        $who[$row[forum_update]][id] = 1;
    }

    asort($wall_get_ingroup);
    foreach ($wall_get_ingroup as $zday) {

        $idz = $zday[forum_update];

        if ($who[$zday[forum_update]][id] == '' and $zday[forum_update] != '') {
            echo $who[$zday[forum_update]][id];
            $title = substr($zday[text], 0, 90) . '...';
            $title = $title;

            //// генерирование случайного автора из ВК ///
            $sup = $db->super_query( "SELECT name,user_id FROM " . PREFIX . "_users where vkontakte!='' ORDER BY RAND()" );
            $user = $sup['name'];
            $userlistall_name = get_vars ( "user_list/user_list_".$user."/userlist_".$user."" );
            if (! is_array ( $userlistall_name ))
            {
                $vk=0;
                $trzc = $db->query("SELECT * FROM " . PREFIX . "_users WHERE name='".$user."'");
                while($rowkk = $db->get_row($trzc))
                {
                    $vk++;
                    $userlistall_name = array ();

                    foreach ( $rowkk as $key => $value ) {
                        $userlistall_name[$key] = $value;
                    }
                    if ($rowkk[user_id]!='' and $rowkk[name]==$user) {
                        mkdir(ROOT_DIR."/engine/cache/system/user_list/user_list_".$rowkk[user_id]."", 0777);
                        set_vars ( "user_list/user_list_".$rowkk[user_id]."/userlist_".$rowkk[user_id]."", $userlistall_name );
                    }
                }
                $db->free();
                if ($vk>=1)
                {
                    mkdir(ROOT_DIR."/engine/cache/system/user_list/user_list_".$user."", 0777);
                    set_vars ( "user_list/user_list_".$user."/userlist_".$user."", $userlistall_name );
                    $user_found = TRUE;
                }
                else $user_found = FALSE;
            }

            //////////////////////////////////////////////

            if (is_array($zday[photo])) {

                //////////// генерируем новый альбом //////////
                $_TIME = time()+($config['date_adjust']*60);
                $time = date ("Y-m-d H:i:s", $_TIME);
                $time_s = date ("s", $_TIME);
                $time_i = date ("i", $_TIME);
                $timez = date ("Y-m-d", $_TIME);
                $full_story_compaynd = $zday['text'];
                $short_story_compaynd = substr($zday['text'], 0, 8) . '';
                $full_story_compaynd = $db->safesql($parse->BB_Parse($parse->process('' . $full_story_compaynd . '' . $listz[$idz] . '')));
                $short_story_compaynd = $db->safesql($parse->BB_Parse($parse->process('' . $short_story_compaynd . '' . $listz[$idz] . '')));
                $alname = md5($timez);

                $metatagserss = create_metatags_ub ($full_story_compaynd.$full_story_compaynd.$short_story_compaynd);

                $metatagsdescgg = trim($metatagserss['description']);
                $metatagskwgg = trim($metatagserss['keywords']);

                $dirs = md5($time);
                $cat_album=$row_vk_list['auto'];
                if ($cat_album=='' or $cat_album=='1') $cat_album = 'others';
                $exit_album = $db->super_query( "SELECT id FROM " . PREFIX . "_twsfa_albums where album_title='".$title."'" );
                if ($exit_album[id]=='') {
                    $album_query = $db->query("INSERT INTO " . PREFIX . "_twsfa_albums (id, album_title, album_description, album_alt_name, date, dirrectory, album_user_id, album_categories, tags) values ('', '$title', '$full_story_compaynd', '$alname', '$time', '$dirs', '$sup[user_id]','$cat_album','$metatagskwgg')");
                    $album_id = $db->insert_id($album_query);
                    $db->query("UPDATE " . PREFIX . "_twsfa_category SET setlinks=setlinks+1 WHERE alt_name='" . $cat_album . "'");
                } else $album_id = $exit_album[id];
                ///////////////////////////////////////////////

                foreach ($zday[photo] as $pp) {
                    $add[$idz] = false;
                    $cols_photos=0;
                    if ($pp[photo_big]) {
                        $cols_photos++;
                        $image_name = $pp[photo_big];
                        $img_name_arr = explode(".", $image_name);
                        $type = end($img_name_arr);
                        $iname = md5($image_name . $sup[name] . $_TIME);
                        $get_name = $iname . '.' . $type . '';
                        if ($iname) {
                            $res = @copy($image_name, $upload_path . $get_name);
                            $thumb = new thumbnail($upload_path . $get_name);
                            if ($thumb->size_auto(" 300x500 ")) {
                                $thumb->jpeg_quality($config['jpeg_quality']);
                                $thumb->save($upload_path . "thumbs/" . $get_name);
                                @chmod($upload_path . "thumbs/" . $get_name, 0666);
                                $add[$idz] = true;
                            } else {
                                $add[$idz] = true;
                                $ress = copy($pp[photo_min], $upload_path . "thumbs/" . $get_name);
                            }

                            $thumb2 = new thumbnail($upload_path . $get_name);
                            if ($thumb2->size_auto('1280')) {
                                $thumb2->jpeg_quality($config['jpeg_quality']);
                                if ($config['allow_watermark']) $thumb2->insert_watermark($config['max_watermark']);
                                $thumb2->save($upload_path . "" . $get_name);
                                @chmod($upload_path . "" . $get_name, 0666);
                                $add[$idz] = true;
                            } else {
                                $add[$idz] = true;
                                $res = copy($pp[photo_big], $upload_path . "" . $get_name);
                            }
                            //////// загружаем фото и сохраняем в альбом //////////
                            $getasas = substr(md5($get_name),0,2);
                            $namecolfoto = $time_s+$time_i+$cols_photos+$album_id+$getasas;
                            get_photo_albums_newflash('main/'.$get_name, $image_name, '1280');
                            $db->query("INSERT INTO " . PREFIX . "_twsfa_picturies (foto_id, picture, alt_name, time, foto_date, album_id, approve, pic_user_id, allow_rating,type_upload,title) 
                            VALUES ('','main/".$get_name."','".$namecolfoto.'bez-nazvaniya'."','".$time."','999999','".$album_id."', '1', '".$sup['user_id']."','1','1','".$time."')");
                            ///////////////////////////////////////////////////////
                            $db->query("INSERT INTO " . USERPREFIX . "_images (images, author, news_id, date) values ('$get_name', '$sup[name]', '', '$thistime')");
                        }
                        $realaddr_link_thumb = $realaddr_thumb . $get_name;
                        $realaddr_link = $realaddr . $get_name;
                        $listz[$idz] .= '[thumb]' . $realaddr_link . '[/thumb]';
                    }

                }
            }

            if (is_array($zday[video])) {
                foreach ($zday[video] as $pp) {
                    $get_player = getvid($pp[keyser], $vid_list);
                    $add[$idz] = false;
                    if ($get_player != '') {
                        $pp[video_title] = str_replace('"','',$pp[video_title]);
                        $pp[video_text] = str_replace('"','',$pp[video_text]);
                        $pp[video_text] = stripslashes($pp[video_text]);
                        $pp[video_title] = stripslashes($pp[video_title]);
                        $saos = $db->super_query("SELECT info FROM " . USERPREFIX . "_video_file WHERE name='" . $db->safesql($parse->BB_Parse($parse->process(trim(strip_tags($pp[video_title]))))) . "'");
                        if ($saos[info] == '') {
                            $user_category = "1";
                            $time = date("Y-m-d H:i:s", $_TIME);
                            $pp[video_title] = $db->safesql($parse->BB_Parse($parse->process(trim(strip_tags($pp[video_title])))));
                            $pp[video_text] = $db->safesql($parse->BB_Parse($parse->process(trim(strip_tags($pp[video_text])))));
                            if (strpos($get_player, 'youtube') !== false) {
                                $get_player = preg_replace("#youtube.com/embed/(.+?)#is", "youtube.com/watch?v=\\1", $get_player);
                                $fa = $db->query("INSERT INTO " . PREFIX . "_video_file (vladelec_name, name, user_category, info, reg_date, rutube, youtube, opisanie) values ('" . $sup[name] . "', '" . $db->safesql($parse->BB_Parse($parse->process(trim(strip_tags($pp[video_title]))))) . "', '" . $user_category . "', '" . $get_player . "', '" . $time . "', '', '1', '" . $pp[video_text] . "')");
                                //echo "INSERT INTO " . PREFIX . "_video_file (vladelec_name, name, user_category, info, reg_date, rutube, youtube, opisanie) values ('".$sup[name]."', '".$pp[video_title]."', '".$user_category."', '".$get_player."', '".$time."', '', '1', '".$pp[video_text]."')";
                                $idv = $db->insert_id($fa);
                                $listz[$idz] .= '<br>Видео <a href="' . $config[http_home_url] . 'archiv_video/' . $idv . '.html">' . $pp[video_title] . '</a>';
                                $db->query("UPDATE " . PREFIX . "_video_category SET setlinks=setlinks+1 WHERE id = '" . $user_category . "'");
                                $add[$idz] = true;
                                echo 'Добавлена видео-запись: <a href="' . $config[http_home_url] . 'archiv_video/' . $idv . '.html">' . $pp[video_title] . '</a><br>';
                            }
                            clear_cache("video2_prof_");
                            clear_cache("video1_key_");
                            @unlink(ENGINE_DIR . '/cache/system/sp_all_video.php');
                            @unlink(ENGINE_DIR . '/cache/system/sp_all_video_cat.php');
                        }
                    }
                }
            }

            $full_story = $zday['text'];
            $short_story = substr($zday['text'], 0, 255) . '...';
            $full_story = $db->safesql($parse->BB_Parse($parse->process('' . $full_story . '&shy;&shy;<br><br>' . $listz[$idz] . '')));
            $short_story = $db->safesql($parse->BB_Parse($parse->process('' . $short_story . '&shy;&shy;<br><br>' . $listz[$idz] . '')));
            if ($title != '...' and $add[$idz] != false) {

                $alt_name = md5($full_story.$short_story);

                $parse = new ParseFilter();
                $metatagsers = create_metatags_ub ($short_story.$title.$full_story);

                $metatagsdesc = trim($metatagsers['description']);
                $metatagskw = trim($metatagsers['keywords']);

                if ($idv!='') {
                    $keys_arr = explode(', ',$metatagskw);
                    foreach($keys_arr as $key)
                    {
                        $db->query("INSERT INTO " . PREFIX . "_video_key (id, tag, post, translit) values ('', '".$key."', '".$sup['name']."', '".$idv."')");
                    }
                }

                    $tags = $metatagskw;

                    if( @preg_match( "/[\||\<|\>|\"|\!|\?|\$|\@|\/|\\\|\&\~\*\+]/", $tags ) ) $tags = "";
                    else $tags = @$db->safesql( htmlspecialchars( strip_tags( stripslashes( trim( $tags ) ) ), ENT_COMPAT, $config['charset'] ) );

                    if ( $tags ) {

                        $temp_array = array();
                        $tags_array = array();
                        $temp_array = explode (",", $tags);

                        if (count($temp_array)) {

                            foreach ( $temp_array as $value ) {
                                if( trim($value) ) {
                                    $tags_array[] = trim($value);
                                    $db->query("INSERT INTO " . PREFIX . "_tags (id, tag, news_id) values ('', '".trim($value)."', '$idv')");
                                }
                            }

                        }

                        if ( count($tags_array) ) $tags = implode(", ", $tags_array); else $tags = "";

                    }

                $added_time = time() + ($config['date_adjust'] * 60);
                $thistime = date( "Y-m-d H:i:s", $added_time );

                $fgds = $db->query("INSERT INTO " . PREFIX . "_post (date, autor, short_story, full_story, xfields, title, keywords, category, alt_name, allow_comm, approve, allow_main, fixed, allow_rate, allow_br, flag, forum_update, tags) values ('$thistime', '".$sup['name']."', '$short_story', '$full_story', '$filecontents', '" . $title . "', '', '" . $cid . "', '" . $alt_name . "', '1', '1', '1', '0', '1', '1', '1', '".$zday['forum_update']."', '" . $tags . "')");
                $id = $db->insert_id($fgds);

                $db->query("UPDATE " . PREFIX . "_tags SET news_id='" . $id . "' WHERE news_id=''");

                echo 'Выгружена запись: <a target="_blank" href="/admin.php?mod=editnews&action=editnews&id=' . $id = $db->insert_id($fgds) . '">' . $title . '</a><br>';

                $db->query("UPDATE " . PREFIX . "_images SET news_id='" . $id . "' WHERE news_id='' and author='" . $sup[name] . "'");

                if ($cols_photos>0) {
                    $db->query("UPDATE ".PREFIX."_twsfa_albums SET images=images+".$cols_photos." WHERE id='".$album_id."'");
                }
                @unlink (ROOT_DIR."/engine/cache/system/allalbums.php");
                @unlink (ROOT_DIR."/engine/cache/system/allcatfoto.php");
                @unlink (ROOT_DIR."/engine/cache/system/allfotos.php");

                clear_cache();
            }
        }
    }

    /* web2work*/

    clear_cache(array('array_','eventcustomnews_', 'news_', 'related_', 'tagscloud_', 'archives_', 'calendar_', 'topnews_', 'rss', 'stats'));

    /////////////////////////////////////////////////////////////////////////////////////////
}

?>