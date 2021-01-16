<?php

$distr_charset = "windows-1251";
$db_charset = "cp1251";

header("Content-type: text/html; charset=".$distr_charset);

@ini_set ('memory_limit',"365M");
@set_time_limit (0);
@ini_set ('max_execution_time',0);
@ini_set ('3048M');
@ini_set ('output_buffering','off');
@ob_end_clean ();

function load_kurs($url)
{
    // вход в систему
    // имя хоста, куда будем заходить
    $hostname = $url;
    // инициализация cURL
    $ch = curl_init($hostname);
    // получать заголовки
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    // если ведется проверка HTTP User-agent, то передаем один из возможных допустимых вариантов:
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
    // елси проверятся откуда пришел пользователь, то указываем допустимый заголовок HTTP Referer:
    curl_setopt ($ch, CURLOPT_REFERER, $hostname);
    // использовать метод POST
    curl_setopt ($ch, CURLOPT_POST, 1);
    // сохранять информацию Cookie в файл, чтобы потом можно было ее использовать
    curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    // передаем поля формы
    curl_setopt ($ch, CURLOPT_POSTFIELDS, '');
    // возвращать результат работы
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    // не проверять SSL сертификат
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    // не проверять Host SSL сертификата
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 1);
    // это необходимо, чтобы cURL не высылал заголовок на ожидание
    curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    // выполнить запрос
    curl_exec ($ch);
    // получить результат работы
    $result = curl_multi_getcontent ($ch);
    // вывести результат

    // закрыть сессию работы с cURL
    curl_close ($ch);

    return $result;
}

$action = $_GET['action'];
$onsite = $_GET['onsite'];

if (!$action and $onsite!=true)
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

@error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', false);
@ini_set('html_errors', false);
@ini_set('set_time_limit', '600');
@ini_set('error_reporting', E_ALL ^ E_NOTICE);
include_once ROOT_DIR.'/engine/data/config.php';

if ($config['valuta_type']==0 or $config['valuta_type']=='')
{

    $life_time = time() - @filemtime($loc_file);
    if ((file_exists($loc_file)) && ($life_time<10400)){ // 10400 - это время обновления иформации в секундах (в данном случае - 3 часа)
        $fp = fopen($loc_file, 'r');
        if (filesize($loc_file) >0){
            $text = fread($fp, filesize($loc_file));
        }else{
            $text = '<span class="localfilesizeisnull">Ожидание...</span>';
        }
        fclose($fp);
        if (strlen($text) > 20) return $text;
    }
    // Формируем сегодняшнюю дату
    $date = date("/m/Y");

    $nd = date("d");
    $nd = $nd;
    if ($nd<'10') $nd = ''.$nd.'';

    // Формируем ссылку
    $link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd$date";

    if (strlen($link) < 20) {
        // не сохраняем файл
        @touch($loc_file);
        return $link;
    }


    // Загружаем HTML-страницу
    $fd = load_kurs($link);
    $text="";
    if (!$fd) $tr="Запрашиваемая страница не найдена";
    else
    {
        $text = $fd;
    }

    // Разбираем содержимое, при помощи регулярных выражений
    $pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
    preg_match_all($pattern, $text, $out, PREG_SET_ORDER);
    $dollar = "";
    $euro = "";
    foreach($out as $cur)
    {
        if($cur[2] == 840) $dollar = str_replace(",",".",$cur[4]);
        if($cur[2] == 978) $euro   = str_replace(",",".",$cur[4]);
    }
    //echo 'Евро'.$euro;
    $nd2 = $nd+1;
    if ($nd2<'10') $nd2 = '0'.$nd2.'';
    // Формируем ссылку
    $links = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd2$date";

    if (strlen($links) < 20) {
        // не сохраняем файл
        @touch($loc_file);
        return $link;
    }


    // Загружаем HTML-страницу
    $fd = load_kurs($links);
    $texts="";
    if (!$fd) $tr="Запрашиваемая страница не найдена";
    else
    {
        $texts = $fd;
    }

    // Разбираем содержимое, при помощи регулярных выражений
    $patternx = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
    preg_match_all($patternx, $texts, $outx, PREG_SET_ORDER);
    $dollarnext = "";
    $euronext = "";
    foreach($outx as $curx)
    {
        if($curx[2] == 840) $dollarnext = str_replace(",",".",$curx[4]);
        if($curx[2] == 978) $euronext   = str_replace(",",".",$curx[4]);
    }

    $nd3 = $nd-1;
    if ($nd3<'10') $nd3 = '0'.$nd3.'';
    // Формируем ссылку
    $linkser = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$nd3$date";

    if (strlen($linkser) < 20) {
        // не сохраняем файл
        @touch($loc_file);
        return $linkser;
    }


    // Загружаем HTML-страницу
    $fd = load_kurs($linkser);
    $textser="";
    if (!$fd) $tr="Запрашиваемая страница не найдена";
    else
    {
        $textser = $fd;
    }

    // Разбираем содержимое, при помощи регулярных выражений
    $patternx = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
    preg_match_all($patternx, $textser, $outx, PREG_SET_ORDER);
    $dollarold = "";
    $euroold = "";
    foreach($outx as $curx)
    {
        if($curx[2] == 840) $dollarold = str_replace(",",".",$curx[4]);
        if($curx[2] == 978) $euroold   = str_replace(",",".",$curx[4]);
    }

}
else
{

    // Формируем сегодняшнюю дату
    $date = date("/m/Y");

    $nd = date("d");
    $nd = $nd;
    if ($nd<'10') $nd = ''.$nd.'';

    if ($config['valuta_type']==1)
    {
        // Формируем ссылку
        //$link = "http://abcountries.com/xe/?v=KZT";
        $link = "http://www.stokart.ru/valuta/KZT/";
    }
    elseif ($config['valuta_type']==2)
    {
        // $link = "http://abcountries.com/xe/?v=UAH";
        $link = "http://www.stokart.ru/valuta/UAH/";
    }
    elseif ($config['valuta_type']==3)
    {
        //$link = "http://abcountries.com/xe/?v=BYR";
        $link = "http://www.stokart.ru/valuta/BYR/";
    }
    elseif ($config['valuta_type']==4)
    {
        //$link = "http://abcountries.com/xe/?v=KGS";
        $link = "http://www.stokart.ru/valuta/KGS/";
    }

    if (strlen($link) < 20) {
        // не сохраняем файл
        @touch($loc_file);
        return $link;
    }

    $fdss = fopen(ROOT_DIR . '/engine/cache/system/kurs.php', "r");
    while (!feof ($fdss)) $textss .= fgets($fdss, 4096);
//    print_r(unserialize($textss));

    if (is_array($textss)) {
        foreach ($textss as $nextvalda) {
            $dprev = $nextvalda[1];
            $eprev = $nextvalda[2];
        }
    }

    // Загружаем HTML-страницу
    $fd = load_kurs($link, "r");
    $text="";
    if (!$fd) $tr="Запрашиваемая страница не найдена";
    else
    {
        // Чтение содержимого файла в переменную $text
        $text = $fd;
    }

    /* для старой ссылки
    preg_match('|<td id="value_4">(.*)</td>(.*)<td style="padding-left:5px;">|i', $text, $out);
    $dollar = $out[1];
    preg_match('|<td id="value_5">(.*)</td>(.*)<td style="padding-left:5px;">|i', $text, $out);
    $euro = $out[1];
    */
    preg_match('|<p>1 RUB(.*)</strong>(.*)</strong>(.*)</strong></p>(.*)<div>&nbsp;</div>|is', $text, $out);
    preg_match('|1 USD =  <strong>(.*) (.*)|is', $out[3], $out_usd);
    preg_match('|1 EUR =  <strong>(.*) (.*)|is', $out[2], $out_eur);
    $dollar = $out_usd[1];
    $euro = $out_eur[1];

    $vichisl = $dollar-$dprev;
    $vichisle = $euro-$eprev;

    if ($dollar==$textss[1] or $dprev=='') $vichisl = '0.20';
    if ($euro==$textss[2] or $eprev=='') $vichisle = '0.10';

    $nxt = $vichisl+$dollar;
    $nxte = $vichisle+$euro;

    $dollarnext = '~'.$nxt;
    $euronext = '~'.$nxte;
}

if ((int)($dollar)<=(int)($dollarold)) $get = 'down';
else $get = 'up';

if ((int)($euro)<=(int)($euroold)) $gete = 'down';
else $gete = 'up';

$texter = array();
$texter = array(1 => $dollar, 2 => $euro, 3 => $dollarnext, 4 => $euronext, 5 => $dollarold, 6 => $euroold, 7 => $get, 8 => $gete);


$fp = fopen( ROOT_DIR . '/engine/cache/system/kurs.php', 'wb+' );
fwrite( $fp,  serialize($texter) );
fclose( $fp );
@chmod( ROOT_DIR . '/engine/cache/system/kurs.php', 0666 );

//print_r($texter);
if ($onsite!=true) {
    echo 'Выгружено';
} else {
    clear_cache("kursvalut");
}

?>