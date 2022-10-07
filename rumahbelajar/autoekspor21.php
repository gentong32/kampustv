<?php 
if ($updatenow=="Yes"||$diupdate=="Yes")
{

$isizip3b="mapokfiles/";
include("echomenu21.php");

$isizip1 = 
'<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sumber Belajar</title>
<LINK href="mapokfiles/special.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="mapokfiles/ajar.js"></script>
</head>
<body">

<div id="wrap">
<!----------------------------------------------------------------------------------------------------------------->
<div class="floating-konten">
</div>
<div class="floating-konten2">
</div>';

for ($a=1;$a<=$jumlahbaris;$a++)
{
$isizip1x[$a] = 
'<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sumber Belajar</title>
<LINK href="special.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="ajar.js"></script>
</head>
<body>

<div id="wrap">
<!----------------------------------------------------------------------------------------------------------------->
<div class="floating-konten">
</div>
<div class="floating-konten2">
</div>';
}

if($jmlmenu>2) {
$isizip2 = '
<div class="floating-menu3">
</div>
<!--  //////////////////////////////////////////////     INI BAGIAN MENU     \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->

<div class="floating-menu">
';
$isizip3 = $isizip3.'
</div>';
} 

$isizip4 = '
<!--  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\     BAGIAN HEADER LOGO     /////////////////////////////////////// -->

<div class="floating-logo">
<div id="logo">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="79%"><img src="mapokfiles/logo_rumah_belajar.png" width="315" height="70"></td>
    <td width="21%"><img src="mapokfiles/logoOER70.png" width="201" height="70"></td>
  </tr>
</table>
</div>

<div id="leslinewarna" class="';

if ($argkls>=10)
{
$isizip4 = $isizip4.'lessma';
}
else if ($argkls>=7 && $argkls<=9)
{
$isizip4 = $isizip4.'lessmp';
}
else if ($argkls>=1 && $argkls<=6)
{
	$isizip4 = $isizip4.'lessd';
}
else
{ 
$isizip4 = $isizip4.'lesall';
}

$isizip4 = $isizip4.'" style="top:80px">
</div>

<!--  /////////////////////////////////////////        JUDUL MAPOK        /////////////////////////////////////// -->  
';

for ($a=1;$a<=$jumlahbaris;$a++)
{
$isizip4x[$a] = '
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

<div id="leslinewarna" class ="';

if ($argkls>=10)
{
$isizip4x[$a] = $isizip4x[$a].'lessma';
}
else if ($argkls>=7 && $argkls<=9)
{
$isizip4x[$a] = $isizip4x[$a].'lessmp';
}
else if ($argkls>=1 && $argkls<=6)
{
	$isizip4x[$a] = $isizip4x[$a].'lessd';
}
else
{ 
$isizip4x[$a] = $isizip4x[$a].'lesall';
}

$isizip4x[$a] = $isizip4x[$a].'" style="top:80px">
</div>

<!--  /////////////////////////////////////////        JUDUL MAPOK        /////////////////////////////////////// -->  
';

}

if($jmlmenu>2) {
	$isizip5='
<div class="floating-judulmateri">
<p align="center" class="judul">'.$judul.'</p>
</div>';

} else
{
	$isizip5='
<div class="floating-judulmaterijadul">
<p align="center" class="juduljadul"></p>
</div>';
};

$isizip5=$isizip5.'
</div>
<!--  /////////////////////////////////////////        MATERI MAPOK        /////////////////////////////////////// -->  
';

if($jmlmenu>2) {
$isizip6='
<div id="konten"> 
<p align="center" class="judul">&nbsp;</p>
<p class="subjudul">'.$judulmateribaris[1].'</p>
<p class="subjudul">&nbsp;</p>
<div id="isikonten">';
$isimateribaris0=str_replace('"../file_storage/materi_pokok/mapok'.$arg5.'/','"mapokfiles/',$isimateribaris[1]);
//$isimateribaris0=str_replace('anim/','',$isimateribaris0);
$isizip6=$isizip6.$isimateribaris0;
$isizip6=$isizip6.'
</div>';

for ($a=1;$a<=$jumlahbaris;$a++)
{
$isizip6x[$a]='
<div id="konten"> 
<p align="center" class="judul">&nbsp;</p>
<p class="subjudul">'.$judulmateribaris[$a].'</p>
<p class="subjudul">&nbsp;</p>
<div id="isikonten">';
$isimateribaris0=str_replace('"../file_storage/materi_pokok/mapok'.$arg5.'/','"',$isimateribaris[$a]);
$isizip6x[$a]=$isizip6x[$a].$isimateribaris0;
$isizip6x[$a]=$isizip6x[$a].'
</div>';
}

} 
else
{
	$isizip6='
<div id="kontenjadul"> 
<br/>
';
///////////////////////include('echotampil01.php');
$isizip6=$isizip6.'
<br/>
<br/>
<br/>
</div>';

for ($a=1;$a<=$jumlahbaris;$a++)
{
$isizip6x[$a]='
<div id="kontenjadul"> 
<br/>
';
///////////////////////include('echotampil01.php');
$isizip6x[$a]=$isizip6x[$a].'
<br/>
<br/>
<br/>
</div>';
}
}
$isizip8='
<p>&nbsp;</p>
<p align="center"><img src="mapokfiles/line_title.png" width="600" height="2" class="judul"><br>
</p>
</div>
';

for ($a=1;$a<=$jumlahbaris;$a++)
{
$isizip8x[$a]='
<p>&nbsp;</p>
<p align="center"><img src="line_title.png" width="600" height="2" class="judul"><br>
</p>
</div>
';
}

$isizip9='
</div>
</body>
</html>
';

$isizip=$isizip1.$isizip2.$isizip3.$isizip4.$isizip5.$isizip6.$isizip8.$isizip9;

$isizip3b="";
include("echomenu".$arg4.".php");
$isizip3 = $isizip3.'
</div>';

for ($a=1;$a<=$jumlahbaris;$a++)
{
	$isizipx[$a]=$isizip1x[$a].$isizip2.$isizip3.$isizip4x[$a].$isizip5.$isizip6x[$a].$isizip8x[$a].$isizip9;
}


include ('ekspor21.php');
};

?>