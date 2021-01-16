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

include ENGINE_DIR.'/modules/content/rating/config.php';

$stm=mktime(0,0,0,date("m"),date("d"),date("Y"));
$ftm=mktime(23,59,59,date("m"),date("d"),date("Y"));
$startdate=date("Y-m-d H:i:s",intval($stm));
$enddate=date("Y-m-d H:i:s",intval($ftm));

$last= $db->query("SELECT * FROM ".PREFIX."_rating_new ORDER BY memberid" );
$hitsnow=$hotnow=$hitsall=$hostall=$ms=$oper=$net=$konq=$other=$ms_os=0;
$lin_os=$mac_os=$other_os=$ms_pr=$oper_pr=$net_pr=$konq_pr=$other_pr=0;
$ms_os_pr=$lin_os_pr=$mac_os_pr=$other_os_pr=$geck=0;
$koo=0;

while ($object1 = $db->get_row($last)) {
    $hostnow+=$object1['un1'];
    $id_member=$object1['memberid'];
    $result = $db->query("SELECT `tip` FROM `".PREFIX."_rating_log-".$id_member."` WHERE date>'".$startdate."' AND date<'".$enddate."' ");
    $num = $db->num_rows($result);
    $hitsnow+=$num;
    while ($object = $db->get_row($result)) {
        $hitsall++;
        $brow=$object['tip'];
        if (stristr ($brow,'msie'))
        {
            $ms++ ; }
        elseif (($brow!='') and (stristr ($brow,'opera')))
        {
            $oper++ ; }
        elseif (($brow!='') and (stristr ($brow,'netscap')))
        {
            $net++ ; }

        elseif (($brow!='') and (stristr ($brow,'Konqueror')))
        {
            $Konq++ ; }
        else {
            $other++ ; }

        $brow=$object['tip'];
        if (stristr ($brow,'windows'))
        {
            $ms_os++ ; }
        elseif (($brow!='') and (stristr ($brow,'linux')))
        {
            $lin_os++ ; }
        elseif (($brow!='') and (stristr ($brow,'Mac')))
        {
            $mac_os++ ; }
        else {
            $other_os++ ; }
        ;};}
$ms_pr=@number_format($ms*100/$hitsnow);
$oper_pr=@number_format($oper*100/$hitsnow);
$net_pr=@number_format($netsc*100/$hitsnow);
$konq_pr=@number_format($konq*100/$hitsnow);
$other_pr=@number_format($other*100/$hitsnow);
$ms_os_pr=@number_format($ms_os*100/$hitsnow);
$lin_os_pr=@number_format($lin_os*100/$hitsnow);
$mac_os_pr=@number_format($mac_os*100/$hitsnow);
$geck_pr=@number_format($geck*100/$hitsnow);
$other_os_pr=@number_format($other_os*100/$hitsnow);
$date=date(H);
$date .=":";
$date .=date(i);

$resultnow= $db->query("SELECT * FROM `".PREFIX."_rating_config` WHERE date='".$date."'" );
$objectnow = $db->get_row($resultnow);

if ($objectnow['date']=='')
{
    $db->query("INSERT INTO `".PREFIX."_rating_config` (`hits_today`, `hosts_today`, `hits_7`, `hosts_7`, `explor`, `opera`, `netsc`, `konq`, `oth_br`, `wind`, `linux`, `mac`, `oth_os`,
`explor_pr`, `opera_pr`, `netsc_pr`, `konq_pr`, `oth_br_pr`, `wind_pr`, `linux_pr`, `mac_pr`, `oth_os_pr`, `date`) VALUES ('".$hitsnow."','".$hostnow."','".$hitsall."','".$hostall."',
'".$ms."','".$oper."','".$net."','".$konq."','".$other."','".$ms_os."','".$lin_os."','".$mac_os."', '".$other_os."', '".$ms_pr."', '".$oper_pr."', '".$net_pr."', '".$konq_pr."', '".$other_pr."',
'".$ms_os_pr."', '".$lin_os_pr."', '".$mac_os_pr."', '".$other_os_pr."', '".$date."')");
}
$sql="UPDATE `".PREFIX."_rating_config` SET `hits_today` = '".$hitsnow."',
`hosts_today` = '".$hostnow."',
`hits_7` = '".$hitsall."',
`hosts_7` = '".$hostall."',
`explor` = '".$ms."',
`opera` = '".$oper."',
`netsc` = '".$net."',
`konq` = '".$konq."',
`oth_br` = '".$other."',
`wind` = '".$ms_os."',
`linux` = '".$lin_os."',
`mac` = '".$mac_os."',
`gecko`='".$geck."',
`oth_os` = '".$other_os."',
`explor_pr` = '".$ms_pr."',
`opera_pr` = '".$oper_pr."',
`netsc_pr` = '".$net_pr."',
`konq_pr` = '".$konq_pr."',
`oth_br_pr` = '".$other_pr."',
`wind_pr` = '".$ms_os_pr."',
`linux_pr` = '".$lin_os_pr."',
`mac_pr` = '".$mac_os_pr."',
`gecko_pr`='".$geck_pr."',
`oth_os_pr` = '".$other_os_pr."',
`date` = '".$date."' WHERE `date` = '".$date."' ";
$db->query($sql);
$koo++;

$result= $db->query("SELECT * FROM `".PREFIX."_rating_new` order by un1 desc" );
$rank=1;
while ($object = $db->get_row($result)) {
    $db->query("UPDATE `" . PREFIX . "_rating_new` SET `rank` = '" . $rank . "' where `memberid`='" . $object['memberid'] . "' ");
    $rank++;
}
// end

$last= $db->query("SELECT * FROM `".PREFIX."_rating_kat`");
$lastn = $db->num_rows($last);
$cd=0;
while ($objectrow = $db->get_row($last)) {

    $id = $objectrow['nom'];

    $last1 = $db->query("SELECT * FROM `" . PREFIX . "_rating_new` where  `id_kat`='" . $id . "' ");
    $lastn1 = $db->num_rows($last1);

    $db->query("UPDATE `" . PREFIX . "_rating_kat` set `kolvo`='" . $lastn1 . "' where `nom`='" . $id . "' ");
    $cd++;
}

if ($onsite!=true) echo 'ѕоказатели рейтинга за час обновлены по '.$koo.' запис€м';
?>
