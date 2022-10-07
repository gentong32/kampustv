<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sumber Belajar</title>
<LINK href="special.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="ajar.js"></script>
</head>
<body onLoad="showhide()">

<div id="wrap">
<!----------------------------------------------------------------------------------------------------------------->
<div class="floating-konten">
</div>
<?php if($arg4<>"0" && $jmlmenu>2) { ?>
<div class="floating-konten2">
</div>
<?php } else { ?>
<div class="floating-konten2b">
</div>
<?php } ?>

<?php if($jmlmenu>2) {?>
<div class="floating-menu3">
</div>
<!--  //////////////////////////////////////////////     BAGIAN MENU     \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->

<div class="floating-menu">
<?php include('menu'.$arg4.'.php');
?>

</div>
<?php } 

?>

<!--  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\     BAGIAN HEADER LOGO     /////////////////////////////////////// -->

<div class="floating-logo">
<div id="logo">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="79%"><img src="logo_rumah_belajar.png" width="315" height="70"></td>
    <td width="21%"><img src="logoOER70.png" width="201" height="70"></td>
  </tr>
</table>
</div>

<div id="leslinewarna" class ="
<?php 
if ($argkls>=10)
echo 'lessma';
else if ($argkls>=7 && $argkls<=9)
echo 'lessmp';
else if ($argkls>=1 && $argkls<=6)
echo 'lessd';
else 
echo 'lesall';

?>
" style="top:80px">

</div>

<!--  /////////////////////////////////////////        JUDUL MAPOK        /////////////////////////////////////// -->  

<?php if($jmlmenu>2) {?>
<div class="floating-judulmateri">
<p align="center" class="judul"><?php echo $judul ?></p>
</div>
<?php 
} else
 {?>
<div class="floating-judulmaterijadul">
<p align="center" class="juduljadul"></p>
</div>
<?php } ?>

<?php
if ($arg4=="11" || $arg4=="12" || $arg4=="21" || $arg4=="22" || $arg4=="99")
{
if ($arg4=="11")
$download = '../file_storage/materi_pokok/MP_'.$arg5.'/zip/MP_'.$arg5.'_files.zip';
else
if ($arg4=="12")
$download = '../file_storage/modul_online/MO_'.$arg5.'/zip/MO_'.$arg5.'_files.zip';
else
if ($arg4=="21")
$download = '../file_storage/materi_pokok/mapok'.$arg5.'/zip/mapok'.$arg5.'_files.zip';
else
if ($arg4=="22")
$download = '../file_storage/modul_online/mol'.$arg5.'/zip/mol'.$arg5.'_files.zip';
else
	if ($arg4=="99")
		$download = '../file_storage/pengetahuan_populer/PP_'.$arg5.'/zip/PP_'.$arg5.'_files.zip';
if (file_exists($download))
{
	$date1=filemtime($download);
	$diff = round((strtotime("2016-04-18 00:00") - $date1)/86400);
	//$diff=$date2-$date1;
	
	if ($diff<0)
	{
		$diupdate="No";
	}
	else
	{
		$diupdate="Yes";
	}
	
}
else
{

	$diupdate="Yes";

}

}
?>

<div class="floating-judulmaterijadul">
<p align="right" style="padding-right:15px">
<?php if($arg4=="11" || $arg4=="12" || $arg4=="21" || $arg4=="22"  || $arg4=="99") {?>
<a href="download.php?idmateri=<?php echo $arg5?>&versi=<?php echo $arg4?>"><img src="logo_dl.png" width="25" height="25" border="0"></a></p>
<?php }?>
</div>

</div>


<!--  /////////////////////////////////////////        MATERI MAPOK        /////////////////////////////////////// -->  
<?php 

if($jmlmenu>2) {?>
<div id="konten"> 
<p align="center" class="judul">&nbsp;</p>
	<?php include('tampil'.$arg4.'.php');?>
</div>
<?php } 
else
{ ?>
<div id="kontenjadul"> 
<br/>
	<?php 
	if ($arg4=='0')
		include('tampil00.php');
	else if ($arg4=='88')
		include('tampilslb00.php');
	else
	{
		include('tampil01.php');
	}
	?>
<br/>
<br/>
<br/>

</div>
<?php }?>
<p>&nbsp;</p>
<p align="center"><img src="line_title.png" width="600" height="2" class="judul"><br>
</p>
</div>


</div>
</div>
</body>
</html>