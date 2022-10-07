<?php
require_once "session.php";
require_once "global.php";

$argumen1 = $_GET['idmapok'];
$argumen2 = $_GET['idmenu'];

$query = "SELECT * FROM daftarmapok2 WHERE iddaftarmapok=".$argumen1;
$hasil = mysql_query($query);
$data = mysql_fetch_array($hasil);
$judul=$data['topik'];

$query = "SELECT * FROM detailmapok2 WHERE iddaftarmapok=".$argumen1;
$hasil = mysql_query($query);
$kb = Array(5);
$nkb=0;
$kc = Array(5);
$nkc=0;
$kd = Array(5);
$nkd=0;

$query2 = "SELECT IDjenjang,IDkelas,IDmatapelajaran FROM a_standarkompetensi 
LEFT JOIN daftarmapok2 a on a.IDsk=a_standarkompetensi.IDsk 
WHERE a.iddaftarmapok=".$argumen1;
$hasil2 = mysql_query($query2);
$data2 = mysql_fetch_array($hasil2);
$idjenjang = $data2["IDjenjang"];
$idkelas = $data2["IDkelas"];
$idmapel = $data2["IDmatapelajaran"];


$kb[0]="loading...";
echo $kb[0];


while($data = mysql_fetch_array($hasil)){
	if ($data['title']==$argumen2)
	{
	$subjudul=$argumen2;
    $isiteks=$data['detail'];
	$isiteks = preg_replace ( "#font-size:\s*[0-9]*px#","",$isiteks);
	$isiteks = preg_replace ( "#size=\"[0-9]*\"#","",$isiteks);
	}
	if ($data['title']=="MateriJudul1")
	{
	$nkb=1;
	$kb[1]=$data['detail'];
	$kb[1] = preg_replace( "#<p>|</p>#", "", $kb[1]);
	$kb[1] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kb[1]);
	}
	if ($data['title']=="MateriJudul2")
	{
	$nkb=2;
	$kb[2]=$data['detail'];
	$kb[2] = preg_replace( "#<p>|</p>#", "", $kb[2]);
	$kb[2] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kb[2]);
	}
	if ($data['title']=="MateriJudul3")
	{
	$nkb=3;
	$kb[3]=$data['detail'];
	$kb[3] = preg_replace( "#<p>|</p>#", "", $kb[3]);
	$kb[3] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kb[3]);
	}
	if ($data['title']=="MateriJudul4")
	{
	$nkb=4;
	$kb[4]=$data['detail'];
	$kb[4] = preg_replace( "#<p>|</p>#", "", $kb[4]);
	$kb[4] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kb[4]);
	}
	if ($data['title']=="LatihanJudul1")
	{
	$nkc=1;
	$kc[1]=$data['detail'];
	$kc[1] = preg_replace( "#<p>|</p>#", "", $kc[1]);
	$kc[1] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kc[1]);
	}
	if ($data['title']=="LatihanJudul2")
	{
	$nkc=2;
	$kc[2]=$data['detail'];
	$kc[2] = preg_replace( "#<p>|</p>#", "", $kc[2]);
	$kc[2] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kc[2]);
	}
	if ($data['title']=="LatihanJudul3")
	{
	$nkc=3;
	$kc[3]=$data['detail'];
	$kc[3] = preg_replace( "#<p>|</p>#", "", $kc[3]);
	$kc[3] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kc[3]);
	}
	if ($data['title']=="LatihanJudul4")
	{
	$nkc=4;
	$kc[4]=$data['detail'];
	$kc[4] = preg_replace( "#<p>|</p>#", "", $kc[4]);
	$kc[4] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kc[4]);
	}
	if ($data['title']=="SimulasiJudul1")
	{
	$nkd=1;
	$kd[1]=$data['detail'];
	$kd[1] = preg_replace( "#<p>|</p>#", "", $kd[1]);
	$kd[1] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kd[1]);
	}
	if ($data['title']=="SimulasiJudul2")
	{
	$nkd=2;
	$kd[2]=$data['detail'];
	$kd[2] = preg_replace( "#<p>|</p>#", "", $kd[2]);
	$kd[2] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kd[2]);
	}
	if ($data['title']=="SimulasiJudul3")
	{
	$nkd=3;
	$kd[3]=$data['detail'];
	$kd[3] = preg_replace( "#<p>|</p>#", "", $kd[3]);
	$kd[3] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kd[3]);
	}
	if ($data['title']=="SimulasiJudul4")
	{
	$nkd=4;
	$kd[4]=$data['detail'];
	$kd[4] = preg_replace( "#<p>|</p>#", "", $kd[4]);
	$kd[4] = preg_replace( "#(<[a-zA-Z0-9]+)[^\>]+>#", "", $kd[4]);
	}
}
	
?>
<html>
<head>
<link href="edukasiStyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #CCC;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>



<div class="floating-menu">
<p><a href="tampil2.php?idmapok=<?php echo $argumen1?>&idmenu=Pendahuluan<?php echo $a?>" 
    class="linkMenu1">Pendahuluan</a></p>
<p><a href="tampil2.php?idmapok=<?php echo $argumen1?>&idmenu=Kompetensi<?php echo $a?>" 
    class="linkMenu1">Kompetensi</a></p>

 <!--  ============================== BLOK UNTUK MATERI ============================== --> 	
  <p class="menuinaktif">Materi</p>
  
  <?php
  for ($a=1;$a<=$nkb;$a++)
  {
  ?>
  	<p class="menuIndentation"><a href="tampil2.php?idmapok=<?php echo $argumen1?>&idmenu=Materi<?php echo $a?>" 
    class="linkMenu2"><?php echo $kb[$a]?></a></p>
  	<p class="menuIndentation">&nbsp;</p>
  <?php
  }
  ?>
  
    
  <!--  ============================== ----------------------------- ============================== -->
  
  <!--  ============================== BLOK UNTUK LATIHAN ============================== --> 	
  <p class="menuinaktif">Latihan</p>
  
  <?php
  for ($a=1;$a<=$nkc;$a++)
  {
  ?>
  	<p class="menuIndentation"><a href="tampil2.php?idmapok=<?php echo $argumen1?>&idmenu=Latihan<?php echo $a?>" 
    class="linkMenu2"><?php echo $kc[$a]?></a></p>
  	<p class="menuIndentation">&nbsp;</p>
  <?php
  }
  ?>
     
  <!--  ============================== ----------------------------- ============================== -->  
    
  <!--  ============================== BLOK UNTUK SIMULASI ============================== --> 	
  
  <?php
  if ($nkc>1)
  echo '<p class="menuinaktif">Simulasi1</p>';
  else
  echo '<p><a href="tampil2.php?idmapok=<?php echo $argumen1?>&idmenu=Simulasi<?php echo $a?>" 
    class="linkMenu1">Simulasi2</a></p>';
  ?>
  
  
  <?php
  for ($a=1;$a<=$nkc;$a++)
  {
  ?>
    <p class="menuIndentation"><a href="tampil2.php?idmapok=<?php echo $argumen1?>&idmenu=Simulasi<?php echo $a?>" 
    class="linkMenu2"><?php echo $kd[$a]?></a></p>
  	<p class="menuIndentation">&nbsp;</p>
  <?php
  }
  ?>
   
  <!--  ============================== ----------------------------- ============================== -->   
  <p><a href="tampil2.php?idmapok=<?php echo $argumen1?>&idmenu=Tes" 
    class="linkMenu1">Tes</a></p>
  <hr>
  <p><a href="tampil2.php?idmapok=<?php echo $argumen1?>&idmenu=Tim" 
    class="linkMenu1">Tim</a></p>
</div>


<div class="floating-menu3">
<p>&nbsp;</p>
</div>
<!--  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\     BAGIAN AKHIR MENU     /////////////////////////////////////// -->

<!--  /////////////////////////////////////////        JUDUL MAPOK        /////////////////////////////////////// -->   
<div class="floating-menu2">
<p align="center" class="judul"><?php echo $judul?></p>
</div>

<div id="konten"> 
<p align="center" class="judul">&nbsp;</p>
<p class="subjudul">
<?php

if (substr($subjudul,0,6)=='Materi')
{	
	$indeks=substr($subjudul,6,1);
	echo $kb[$indeks];
}
else
if (substr($subjudul,0,7)=='Latihan')
{	
	$indeks=substr($subjudul,7,1);
	echo $kc[$indeks];
}
else if (substr($subjudul,0,8)=='Simulasi')
{	
	$indeks=substr($subjudul,8,1);
	echo $kd[$indeks];
}
else
echo $subjudul;

?>
</p>
<p class="subjudul">&nbsp;</p>
<div id="isikonten">
<?php echo $isiteks ?>
</div>
<p align="center"><img src="line_title.png" width="600" height="2" class="judul"><br>
</p>
</div>

</body>
</html>