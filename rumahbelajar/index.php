<?php
require_once "global.php";
error_reporting (E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$arg1 = xss_clean($_GET['idkelas']);
$arg2 = xss_clean($_GET['nmmapel']);
$arg3 = xss_clean($_GET['idmapel']);
$argp2 = xss_clean($_GET['nmkat']);
$argp3 = xss_clean($_GET['idkat']);
$npage = xss_clean($_GET['hal']);
$cari = xss_clean($_GET['cari']);
$tipemedia = xss_clean($_GET['tipe']);
$tipeuser = xss_clean($_GET['user']);

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

//$database->query('SELECT * FROM daftarmapok2 WHERE iddaftarmapok <= :fid');
//$database->bind(':fid', 10);
//$row = $database->single();
//$rows = $database->resultset();
//echo "<pre>";
//print_r($rows[2]['topik']);
//echo "</pre>";
//echo $database->rowCount();
?>

<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sumber Belajar</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<LINK href="special.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="ajar.js"></script>
<script type="text/javascript">

function cek1()
{
	var trans = document.forms["transForm"].elements["tipenya"];
	//alert("MM");  
	for (var i=0, len=trans.length; i<len; i++) {           
        trans[i].onchange = function() {
            document.location.href = "index.php?idkelas="+<?php echo $arg1;?>+"&tipe="+this.value+"&user=<?php echo $tipeuser;?>";
        }
    }

	var trans2 = document.forms["transForm2"].elements["usernya"];

	for (var i=0, len=trans2.length; i<len; i++) {           
        trans2[i].onchange = function() {
            document.location.href = "index.php?idkelas="+<?php echo $arg1;?>+"&tipe=<?php echo $tipemedia;?>&user="+this.value;
		}
	}
	
	for (var i=0, len=document.forms.length; i<len; i++) {
        document.forms[i].onsubmit = function() 
		{ 
		  return false;
		};
    }
}

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
	window.open("index.php","_self");
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
	window.open("index.php?cari="+valOptions1+"&idkelas="+valOptions2, "_self");
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
window.open("index.php?cari="+valOptions+"&idkelas=99", "_self");
}

function carivideo()
{
var e = document.getElementById("txtcari");
var valOptions = e.value;
if(valOptions=="")
{
window.open("index.php?idkelas="+<?php echo $arg1 ?>,"_self");
}
else
window.open("index.php?cari="+valOptions+"&idkelas="+<?php echo $arg1 ?>, "_self");
}

function show_kelas(indeks)
{
document.getElementById('mnkelas1').style.display= 'none'
document.getElementById('mnkelas2').style.display= 'none'
document.getElementById('mnkelas3').style.display= 'none'
document.getElementById('mnkelas4').style.display= 'none'
document.getElementById('mnkelas5').style.display= 'none'
document.getElementById('mnkelas6').style.display= 'none'
document.getElementById('mnkelas'+indeks).style.display = "block";
}

function hide_kelas(indeks)
{
document.getElementById('mnkelas1').style.display= 'none'
document.getElementById('mnkelas2').style.display= 'none'
document.getElementById('mnkelas3').style.display= 'none'
document.getElementById('mnkelas4').style.display= 'none'
document.getElementById('mnkelas5').style.display= 'none'
document.getElementById('mnkelas5').style.display= 'none'
<?php if(($arg1>=1) && ($arg1<=6))
echo "document.getElementById('mnkelas2').style.display= 'block'";
?>
<?php if(($arg1>=7) && ($arg1<=9))
echo "document.getElementById('mnkelas3').style.display= 'block'";
?>
<?php if(($arg1>=10) && ($arg1<=12))
echo "document.getElementById('mnkelas4').style.display= 'block'";
?>
<?php if(($arg1>=13) && ($arg1<=15))
echo "document.getElementById('mnkelas5').style.display= 'block'";
?>
}
</script>

</head>
<body onLoad="awal()">

<?php
{
if ($arg1<>"0")
include('pnamakelas.php');
?>

<!----------------------------------------------------------------------------------------------------------------->
<div id="wrap">
  

<!--  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\     BAGIAN AKHIR MENU     /////////////////////////////////////// -->

<!--  /////////////////////////////////////////        JUDUL MAPOK        /////////////////////////////////////// -->   

<div class="floating-logo">
<div id="logo">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="79%"><img src="logo_rumah_belajar.png" width="315" height="70"></td>
    <td width="21%"><img src="logoOER70.png" width="201" height="70"></td>
  </tr>
</table>
</div>

<div id="leslineborder">
</div>

<div id="leslineatas" class="les1">
</div>

<div id="leslinewarna" 
class="
<?php
if ($arg1>=1 && $arg1<=6)
echo 'lessd';
else if ($arg1>=7 && $arg1<=9)
echo 'lessmp';
else if ($arg1>=10 && $arg1<12)
echo 'lessma';
else if ($arg1>=13 && $arg1<99)
echo 'lessmk';
else if ($arg1==99)
echo 'lesumum';
else if ($arg1=='0')
echo 'lessd';
else
echo 'les1';
?>
">
</div>

<div id="cari" style="left: <?php if ($arg1>0 && $arg1<88 || $arg1=='') echo '613px'; else echo '740px';?>">
<form class="tptcari" name="myForm" action="index.php" onsubmit="GetOptions2()" method="get">

<input id="txtcari" align="right" placeholder="topik ..." type="search" value="<?php echo $cari ?>" name="cari" results="5" autosave="saved-searches">


<?php if($arg1>=4 && $arg1<=15 || $arg1=="") 
{ ?>
<select id='pilihankelas' name='idkelas'>
	 <option value=''>-- pilih kelas --</option>
     <?php
	 for($m=4;$m<=12;$m++) 
	 {
		 //if($cari<>"")
		 
			 if($arg1==$m)
			 {
				 echo "<option selected value='".$m."'>Kelas ".$m."</option>";
			 }
			 else
		 
		 echo "<option value='".$m."'>Kelas ".$m."</option>";
	 }
	 for($m=13;$m<=15;$m++) 
	 {
		 //if($cari<>"")
		 
			 if($arg1==$m)
			 {
				 echo "<option selected value='".($m)."'>Kelas ".($m-3)." (SMK)</option>";
			 }
			 else
		 
		 echo "<option value='".($m)."'>Kelas ".($m-3)." (SMK)</option>";
	 }
	 ?>
     
</select>

<?php } ?>

<?php if($arg1=="0" || $arg1=="88" || $arg1=="99") {?>
<input id="txtidkelas" type="hidden" name="idkelas" value="<?php echo $arg1 ?>">
<?php }?>

<?php
if ($arg1=='99') {?>
<input id='gobutton4' type='button' value='cari' onclick='Javascript:caripengpop()'/>
<?php } else if ($arg1=='0' || $arg1=='88') {?>
<input id='gobutton4' type='button' value='cari' onclick='Javascript:carivideo()'/>
<?php } else{
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
<?php } else if($arg1=="0")
{?>
<div class="floatingkelas">Media Belajar PAUD </div>
<?php } else if($arg1=="88")
{?>
<div class="floatingkelas">Media Belajar PK </div>
<?php } else if(($arg1<>"") && ($arg3==""))
{?>
<div class="floatingkelas"><a class="linkMenu3" href="index.php">Bahan Ajar</a> >> <?php echo $namakelas ?></a>
</div>
<?php } else if($arg3<>"")
{?>
<div class="floatingkelas"><a class="linkMenu3" href="index.php">Bahan Ajar</a> >> <a class="linkMenu3" href="index.php?idkelas=<?php echo $arg1 ?>"><?php echo $namakelas ?></a> >> <?php echo $arg2 ?>
</div>
<?php }


if ($arg1=='0')
{
?>
<div class="piltipe" style="left:10px">
<?php include('pilihtipe.php');?>
</div>
<div class="piltipe" style="left:740px">
<?php include('pilihtipe2.php');?>
</div>
<?php
}

if ($arg1=='88')
{
?>
<div class="piltipe" style="left:10px">
<?php include('pilihtipeb.php');?>
</div>
<?php
}

if($arg1!=0)
{
?>
<div class="pilmapel" style="left: <?php 
if ($arg1>0 && $arg1<99) 
echo '687px'; 
else if ($arg1==99)
echo '762px';?>"
>
<!--<button style="padding-top:0px;height:25px" id="button" onclick="showhide()">Pilih Mata Pelajaran</button>-->
<?php


if ($cari=="")
{
if ($arg1=='0')
include('pilihvid.php');
else if ($arg1<>'99' && $arg1<>'')
include('pilihmapel.php');
else if ($arg1<>'')
include('pilihkat.php');
}
?>

</div>

<?php 
}
//if ($arg1<>"0")
include('pjenjang.php');
?>

</div>


<div id="kontenmapel">

<?php
if($cari<>"" && $arg1<>"99" && $arg1<>"0")
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
		if($arg1=='0')
		{
			if ($argp3=="")
			{
				if ($tipemedia==1)
				include('pdafvid.php');
				else
				if ($tipemedia==2)
				include('pdafaud.php');
				
			}
			else
			{
				include('pdafvid2.php');
			}
		}
		else if($arg1=='88')
		{
			if ($argp3=="")
			{
				if ($tipemedia==1)
				include('pdafslbvid.php');
				else
				if ($tipemedia==2)
				include('pdafslbaud.php');
				
			}
			else
			{
				include('pdafslbvid2.php');
			}
		}
		else
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
if ($t==$npage) {
	?> <a class="button-halaktif"><?php echo $t ?></a> <?php
}
else
{
?>

<a href="<?php 
if($argp3<>"")
{
	echo 'index.php?idkelas=99&nmkat='.$argp2.'&idkat='.$argp3.'&hal='.$t;
} else if($arg3=="")
{
	if ($cari=="")
	{
	if($arg1==0)
	echo 'index.php?idkelas=0&tipe='.$tipemedia.'&user='.$tipeuser.'&hal='.$t;
	else
	echo 'index.php?idkelas='.$arg1.'&hal='.$t;
	}
	else
	echo 'index.php?cari='.$cari.'&idkelas='.$arg1.'&hal='.$t;
}
else
{
	echo 'index.php?idkelas='.$arg1.'&nmmapel='.$arg2.'&idmapel='.$arg3.'&hal='.$t;
}
?>" class="button-hal">
<?php echo $t ?></a>
<?php
}
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
