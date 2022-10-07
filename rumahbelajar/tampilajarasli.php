<?php
require_once "global.php";
error_reporting (E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$arg4 = xss_clean($_GET['ver']);
$arg5 = xss_clean($_GET['idmateri']);
$arg6 = xss_clean($_GET['mnu']);
$arg7 = xss_clean($_GET['sbmnu']);
$arglv1 = xss_clean($_GET['lvl1']);
$arglv2 = xss_clean($_GET['lvl2']);
$arglv3 = xss_clean($_GET['lvl3']);
$argkls = xss_clean($_GET['kl']);
$updatenow = xss_clean($_GET['updatenow']);

function xss_clean($data)
{
$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

do
{
    $old_data = $data;
    $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
}
while ($old_data !== $data);
$data = htmlspecialchars($data, ENT_QUOTES);
return $data;
}

if ($arg4=='11')
{
$database->query("SELECT NMmateripokok as judul FROM tmateripokok 
WHERE IDmateripokok=:fid");
}
else if ($arg4=='21')
{
$database->query("SELECT topik as judul FROM daftarmapok2 
WHERE iddaftarmapok=:fid");
}
else if ($arg4=='12')
{
$database->query("SELECT NMmodulonline as judul FROM tmodulonline 
WHERE IDmodulonline=:fid");
}
else if (($arg4=='22') || ($arg4=='32'))
{
$database->query("SELECT topik as judul FROM daftarmol2 
WHERE iddaftarmol=:fid");
}
else if ($arg4=='99')
{
$database->query("SELECT NMpengpop as judul FROM tpengpop 
WHERE IDpengpop=:fid");
}
else if ($arg4=='0')
{
$database->query("SELECT nmvideo as judul, ikon FROM daftarvideo 
WHERE iddaftarvideo=:fid");
}
else if ($arg4=='88')
{
$database->query("SELECT nmvideo as judul, ikon FROM daftarslb 
WHERE iddaftarvideo=:fid");
}
else if ($arg4=='40')
{
$database->query("SELECT topik as judul, ikon FROM daftarlo 
WHERE iddaftarlo=:fid");
}
else if ($arg4=='41')
{
$database->query("SELECT topik as judul, ikon FROM daftarkonweb 
WHERE iddaftarkonweb=:fid");
}

$database->bind(':fid', $arg5);
$rows = $database->resultset();

$judul=$rows[0]['judul'];
$ikon=$rows[0]['ikon'];

if ($arg4=='11')
{
$database->query("SELECT uniqNo,PARENTdetail,LVLdetail,SEQNOdetail,TITLE,DETAIL FROM tdetailmateripokok 
WHERE IDmateripokok=:fid ORDER BY uniqNo");
}
else if ($arg4=='21')
{
$database->query("SELECT title,detail FROM detailmapok2 
WHERE iddaftarmapok=:fid"); 
}
else if ($arg4=='12')
{
$database->query("SELECT uniqNo,PARENTdetail,LVLdetail,SEQNOdetail,TITLE,DETAIL FROM tdetailmodulonline 
WHERE IDmodulonline=:fid ORDER BY uniqNo");
}
else if ($arg4=='22')
{
$database->query("SELECT title,detail2 FROM detailmol2 
WHERE iddaftarmol=:fid");
}
else if ($arg4=='99')
{
$database->query("SELECT TITLE,DETAIL FROM tdetailpengpop 
WHERE IDpengpop=:fid AND TITLE<>'Daftar Pustaka'");
}

if ($arg4<>'40' && $arg4<>'41')
{
$database->bind(':fid', $arg5);
$rows = $database->resultset();
$jmlmenu=$database->rowCount();

if ($arg4<>'0')
{
if ($arg4<>'99')
{
    include('query'.$arg4.'.php');
}
else
{
	for ($i=0;$i<$jmlmenu;$i++)
	{	
		$judulMateri[$i]=$rows[$i]['TITLE'];
		$isiMateri[$i]=$rows[$i]['DETAIL'];
		$isiMateri[$i]=str_replace('src="/edukasinet/file_storage/pengetahuan_populer','src="file_storages',$isiMateri[$i]);
		$isiMateri[$i]=str_replace('src="/file_storage/pengetahuan_populer','src="../file_storage/pengetahuan_populer',$isiMateri[$i]);
	}	
}
}
$jmlmenu=$database->rowCount();

}
?>

<?php 
if ($arg4<>'40' &&  $arg4<>'41')
{
	include ("htmltampil1.php");
}
else
{
	if($arg4=='40')
	include ("htmltampil2.php");
	if($arg4=='41')
	include ("tampil_web2.php");
}
include ("autoekspor".$arg4.".php");
?>

