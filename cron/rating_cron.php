<?php
if ($_REQUEST[action]=='' and $onsite!=true)
{
    define('DATALIFEENGINE', true);
    define('ROOT_DIR',dirname(dirname(__FILE__)));
    define('ENGINE_DIR',ROOT_DIR .'/engine');

    include_once ROOT_DIR.'/cron/system_functions_db.php';
}
elseif ($onsite!=true)
{
    include_once ROOT_DIR.'/cron/system_functions_import.php';
}else set_vars( "cron", $_TIME );

include(ROOT_DIR."/engine/modules/content/rating/config.php");
// Дата
$dat=date("Y-m-d H:i:s",intval(mktime(0,0,0,date("m"),date("d")-1,date("Y"))));
// Корректирование дней
$sdays=$sdays+1;
$koo=0;

$last= $db->query("SELECT * FROM ".PREFIX."_rating_new ORDER BY memberid" );
    while ($object = $db->get_row($last)) {

$host=$object['un1'];
$hits=$object['hitsday1'];
$users=$object['users'];
$id=$object['memberid'];
$email=$object['email'];

// Рассылаем статистику
        if($email!=''){

			include_once ROOT_DIR.'/engine/classes/mail.class.php';
			$mail = new dle_mail( $config );

			$row = $db->super_query( "SELECT template FROM " . PREFIX . "_email WHERE name='reg_st1' LIMIT 0,1" );

			$row['template'] = stripslashes( $row['template'] );
			$row['template'] = str_replace( "{%memberid%}", $memberid, $row['template'] );
			$row['template'] = str_replace( "{%host%}", $host, $row['template'] );
			$row['template'] = str_replace( "{%email%}", $email, $row['template'] );
			$row['template'] = str_replace( "{%hits%}", $hits, $row['template'] );
			$row['template'] = str_replace( "{%id%}", $id, $row['template'] );
			$row['template'] = str_replace( "{%users%}", $users, $row['template'] );
			$row['template'] = str_replace( "{%http_home_url%}", $config['http_home_url'], $row['template'] );
			$row['template'] = str_replace( "{%home_title%}", $config[home_title], $row['template'] );

			$body = str_replace( '\n', "", $comments );
			$body = str_replace( '\r', "", $body );

			$body = stripslashes( stripslashes( $body ) );
			$body = str_replace( "<br />", "\n", $body );
			$body = strip_tags( $body );

			$row['template'] = str_replace( "{%text%}", $body, $row['template'] );
			$body = str_replace( "{%ip%}", $_IP, $row['template'] );
			$body = str_replace( "{%username_to%}", $lang['admin'], $body );
			$body = str_replace( "{%unsubscribe%}", "--", $body );
			$text = $body;
			$mail->send( $email, "Ежесуточная статистика Вашего ресурса - ".$config['home_title']."", $body );
           $koo++;
}

        $db->query("ALTER TABLE  `".PREFIX."_rating_un-".$id."` CHANGE  `host`  `host` VARCHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT  '0'");
        $db->query("ALTER TABLE  `".PREFIX."_rating_log-".$id."` CHANGE  `host`  `host` VARCHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT  '0'");
// Собираем статистику за текщий день , обнуляем
        $db->query("INSERT INTO `".PREFIX."_rating_all-$id` (`hits`, `hosts`, `date`, `users`)
VALUES ('".$hits."','".$host."','".$dat."','".$users."')");
        $db->query("UPDATE $table SET un7 = un6, un6 = un5, un5 = un4, un4 = un3, un3 = un2, un2 = un1, un1 = 1, hitsday7=hitsday6, hitsday6=hitsday5, hitsday5=hitsday4, hitsday4=hitsday3, hitsday3=hitsday2, hitsday2=hitsday1, hitsday1=1 where `memberid`='".$id."'");
// Чистим таблицы от старых записей
        $db->query("DELETE FROM `".PREFIX."_rating_log-$id` WHERE date<'".date("Y-m-d H:i:s",mktime(0,0,0,date("m") ,date("d")-$sdays,date("Y")))."'");
        $db->query("DELETE FROM `".PREFIX."_rating_un-$id` WHERE date<'".date("Y-m-d H:i:s",mktime(0,0,0,date("m") ,date("d")-$sdays,date("Y")))."'");
        $db->query("DELETE FROM `".PREFIX."_rating_all-$id` WHERE date<'".date("Y-m-d H:i:s",mktime(0,0,0,date("m") ,date("d")-$sdays,date("Y")))."'");
}
if ($onsite!=true) echo 'Показатели рейтинга за сутки обновлены по '.$koo.' записям';
?>