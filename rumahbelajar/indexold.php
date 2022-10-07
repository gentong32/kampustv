<?php
require_once "global.php";
error_reporting (E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$arg1 = $_GET['idkelas'];
$arg2 = $_GET['nmmapel'];
$arg3 = $_GET['idmapel'];
$argp2 = $_GET['nmkat'];
$argp3 = $_GET['idkat'];
$npage = $_GET['hal'];
$cari = $_GET['cari'];
?>

<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sumber Belajar</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<LINK href="special.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="ajar.js"></script>
<script type="text/javascript">
function GetOptions()
{
var e = document.getElementById("pilihanmapel");
var valOptions = e.options[e.selectedIndex].value;
var txtOptions = e.options[e.selectedIndex].text;
if(valOptions=="")
{
}
else
window.open("index.php?idkelas=<?php echo $arg1?>&nmmapel="+txtOptions+"&idmapel="+valOptions, "_self");
}

function GetOptions2()
{
	window.open("index.php?idkelas=12","_self");
}

function GetOptionsPop()
{
var e = document.getElementById("pilihanmapel");
var valOptions = e.options[e.selectedIndex].value;
var txtOptions = e.options[e.selectedIndex].text;
if(valOptions=="")
{
}
else
window.open("index.php?idkelas=<?php echo $arg1?>&nmkat="+txtOptions+"&idkat="+valOptions, "_self");
}

function cariall()
{
var e1 = document.getElementById("txtcari");
var valOptions1 = e1.value;
var e2 = document.getElementById("pilihankelas");
var valOptions2 = e2.options[e2.selectedIndex].value;
var txtOptions2 = e2.options[e2.selectedIndex].text;

if(valOptions1=="")
{
	window.open("index.php","_self");
}
else if(valOptions2=="")
{
	window.open("index.php?cari="+valOptions1, "_self");
}
else
{
	window.open("index.php?idkelas="+valOptions2+"&cari="+valOptions1, "_self");
}
}

function caripengpop()
{
var e = document.getElementById("txtcari");
var valOptions = e.value;
if(valOptions=="")
{
window.open("index.php?idkelas=99","_self");
}
else
window.open("index.php?idkelas=99&cari="+valOptions, "_self");
}

</script>
</head>
<body onLoad="showhide()">

<?php
{
include('pnamakelas.php');
?>

<!----------------------------------------------------------------------------------------------------------------->
<div id="wrap">
  

<!--  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\     BAGIAN AKHIR MENU     /////////////////////////////////////// -->

<!--  /////////////////////////////////////////        JUDUL MAPOK        /////////////////////////////////////// -->   
<div class="floating-logo">
<div id="logo">
<img src="logo_rumah_belajar.png" width="315" height="70">
</div>
<?php
if ($arg1>=1 && $arg1<=6)
{?>
	<div id="leslinesd">
	</div>
<?php
} else if ($arg1>=7 && $arg1<=9)
{?>
	<div id="leslinesmp">
	</div>
<?php
} else if ($arg1>=10)
{?>
	<div id="leslinesma">
	</div>
<?php
} else
{?>
	<div id="leslineall">
	</div>
<?php
}?>

<div id="cari">
<form class="tptcari" name="myForm" action="index.php" onsubmit="GetOptions2()" method="get">

<?php if ($arg1==99) {?>
<input id="txtidkelas" type="hidden" name="idkelas" value="99">
<?php } ?>

<input id="txtcari" align="right" placeholder="topik ..." type="search" value="<?php echo $cari ?>" name="cari" results="5" autosave="saved-searches">


<?php if($arg1<>"99") { ?>
<select id='pilihankelas' name='idkelas'>
	 <option value=''>-- pilih kelas --</option>
     <?php
	 for($m=4;$m<=12;$m++) 
	 {
		 //if($cari<>"")
		 {
			 if($arg1==$m)
			 {
				 echo "<option selected value='".$m."'>Kelas ".$m."</option>";
			 }
		 }
		 echo "<option value='".$m."'>Kelas ".$m."</option>";
	 }
	 ?>

</select>

<?php } ?>
<?php
if ($arg1=='99') {?>
<input id='gobutton4' type='button' value='cari' onclick='Javascript:caripengpop()'/>
<?php } else {
?>
<input id='gobutton4' type='button' value='cari' onclick='Javascript:cariall()'/>
<?php } ?>
</form>
</div>

<div class="tbmenu">
SUMBER BELAJAR
</div>
<?php
if(($arg1=="99") && ($argp3==""))
{?>
<div class="floatingkelas">Pengetahuan Populer</div>
<?php } else if(($arg1=="99") && ($argp3<>""))
{?>
<div class="floatingkelas"><a class="linkMenu3" href="index.php?idkelas=99">Pengetahuan Populer</a> >> <?php echo $argp2 ?></div>
<?php } else if(($arg1<>"") && ($arg3==""))
{?>
<div class="floatingkelas"><a class="linkMenu3" href="index.php">Bahan Ajar</a> >> <?php echo $namakelas ?></a>
</div>
<?php } else if($arg3<>"")
{?>
<div class="floatingkelas"><a class="linkMenu3" href="index.php">Bahan Ajar</a> >> <a class="linkMenu3" href="index.php?idkelas=<?php echo $arg1 ?>"><?php echo $namakelas ?></a> >> <?php echo $arg2 ?>
</div>
<?php }?>

<div class="pilmapel">
<!--<button style="padding-top:0px;height:25px" id="button" onclick="showhide()">Pilih Mata Pelajaran</button>-->
<?php 
if ($cari=="")
{
if ($arg1<>'99')
include('pilihmapel.php');
else
include('pilihkat.php');
}
?>

</div>

<?php include('pjenjang.php') ?>

</div>

<div id="kontenmapel">

<?php
if($cari<>"" && $arg1<>99)
{
	include('pdafcari.php');
}
else
{
if($arg1=="")
{
	include('pdafajar1.php');
}
else
{
	if($arg2=="")
	{
		if($arg1<>99)
		{
			include('pdafajar2.php');
		}
		else
		{
			if ($argp3=="")
			include('pdafpop.php');
			else
			include('pdafpop2.php');
		}
	}
	else
	{
		include('pdafajar3.php');
	}
} 
}

if ($arg1=="" && $cari=="")
{
}
else
{
?>
<p>&nbsp;</p>
<p align="center"><img src="line_title.png" width="600" height="2" class="judul"><br>

<p align="center">
<?php

$totalhal=intval(($totalmateri-1)/9)+1;
//$jmlgruphal=intval($totalhal-1/10)+1;
//$grupke=intval($npage-1/10)+1;
//$awalpage=($grupke-1)*10+1;
if($npage<=6)
$awalpage=1;
else
$awalpage=$npage-5;

if($npage+4>=$totalhal || $awalpage+9>$totalhal)
$akhirpage=$totalhal;
else
$akhirpage=$awalpage+9;

for($t=$awalpage;$t<=$akhirpage;$t++)
{
?>
<a href="<?php 
if($argp3<>"")
{
	echo 'index.php?idkelas=99&nmkat='.$argp2.'&idkat='.$argp3.'&hal='.$t;
} else if($arg3=="")
{
	if ($cari=="")
	echo 'index.php?idkelas='.$arg1.'&hal='.$t;
	else
	echo 'index.php?cari='.$cari.'&idkelas='.$arg1.'&hal='.$t;
}
else
{
	echo 'index.php?idkelas='.$arg1.'&nmmapel='.$arg2.'&idmapel='.$arg3.'&hal='.$t;
}
?>" class="button-hal"><?php echo $t ?></a>
<?php
}
} 
?>
</p>
</div>
</div>
</div>
<?php }?>
</body>
</html>

