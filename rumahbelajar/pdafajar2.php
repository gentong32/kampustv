<?php
$database->query("SELECT IDmateripokok as idbahanajar,IMGmateripokok as ikonbahanajar,NMmateripokok as judulmateri,a.IDmatapelajaran as IDmapel,DESCmateripokok as sinopsis,NMmatapelajaran,versi FROM tmateripokok a 
LEFT JOIN tmatapelajaran b ON a.IDmatapelajaran=b.IDmatapelajaran 
WHERE a.status='Y' AND IDkelas=:fkelas    
UNION 
SELECT iddaftarmapok as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,xb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi FROM daftarmapok2 xa 
LEFT JOIN a_standarkompetensi xb ON xa.idsk=xb.IDsk 
LEFT JOIN tmatapelajaran xc ON xb.IDmatapelajaran=xc.IDmatapelajaran 
WHERE xa.setatus=3 AND xb.IDkelas=:fkelas  
UNION
SELECT IDmodulonline as idbahanajar,IMGmodulonline as ikonbahanajar,NMmodulonline as judulmateri,ya.IDmatapelajaran as IDmapel,DESCmodulonline as sinopsis,NMmatapelajaran,versi FROM tmodulonline ya 
LEFT JOIN tmatapelajaran yb ON ya.IDmatapelajaran=yb.IDmatapelajaran 
WHERE ya.status='Y' AND ya.IDkelas=:fkelas   
UNION 
SELECT iddaftarmol as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi FROM daftarmol2 za 
LEFT JOIN a_standarkompetensi zb ON za.idsk=zb.IDsk 
LEFT JOIN tmatapelajaran zc ON zb.IDmatapelajaran=zc.IDmatapelajaran 
WHERE za.setatus=3 AND zb.IDkelas=:fkelas
UNION 
SELECT iddaftarlo as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb2.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,40 as versi FROM daftarlo za2 
LEFT JOIN a_standarkompetensi zb2 ON za2.idsk=zb2.IDsk 
LEFT JOIN tmatapelajaran zc2 ON za2.IDmatapelajaran=zc2.IDmatapelajaran 
WHERE za2.setatus=3 AND za2.IDkelas=:fkelas 
UNION 
SELECT iddaftarkonweb as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb3.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,41 as versi FROM daftarkonweb za3 
LEFT JOIN a_standarkompetensi zb3 ON za3.idsk=zb3.IDsk 
LEFT JOIN tmatapelajaran zc3 ON za3.IDmatapelajaran=zc3.IDmatapelajaran 
WHERE za3.setatus=3 AND za3.IDkelas=:fkelas");

$database->bind(':fkelas',$arg1);

$rows = $database->resultset();
$totalmateri=$database->rowCount();

if($npage=="")
{
	$npage="1";
}
$limit = 9;
$start=($npage-1)*$limit;

$database->query("SELECT IDmateripokok as idbahanajar,IMGmateripokok as ikonbahanajar,NMmateripokok as judulmateri,a.IDmatapelajaran as IDmapel,DESCmateripokok as sinopsis,NMmatapelajaran,versi FROM tmateripokok a 
LEFT JOIN tmatapelajaran b ON a.IDmatapelajaran=b.IDmatapelajaran 
WHERE a.status='Y' AND IDkelas=:fkelas     
UNION 
SELECT iddaftarmapok as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,xb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi FROM daftarmapok2 xa 
LEFT JOIN a_standarkompetensi xb ON xa.idsk=xb.IDsk 
LEFT JOIN tmatapelajaran xc ON xb.IDmatapelajaran=xc.IDmatapelajaran 
WHERE xa.setatus=3 AND xb.IDkelas=:fkelas  
UNION
SELECT IDmodulonline as idbahanajar,IMGmodulonline as ikonbahanajar,NMmodulonline as judulmateri,ya.IDmatapelajaran as IDmapel,DESCmodulonline as sinopsis,NMmatapelajaran,versi FROM tmodulonline ya 
LEFT JOIN tmatapelajaran yb ON ya.IDmatapelajaran=yb.IDmatapelajaran 
WHERE ya.status='Y' AND ya.IDkelas=:fkelas   
UNION 
SELECT iddaftarmol as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi FROM daftarmol2 za 
LEFT JOIN a_standarkompetensi zb ON za.idsk=zb.IDsk 
LEFT JOIN tmatapelajaran zc ON zb.IDmatapelajaran=zc.IDmatapelajaran 
WHERE za.setatus=3 AND zb.IDkelas=:fkelas 
UNION
SELECT iddaftarlo as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb2.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,40 as versi FROM daftarlo za2 
LEFT JOIN a_standarkompetensi zb2 ON za2.idsk=zb2.IDsk 
LEFT JOIN tmatapelajaran zc2 ON za2.IDmatapelajaran=zc2.IDmatapelajaran 
WHERE za2.setatus=3 AND za2.IDkelas=:fkelas 
UNION
SELECT iddaftarkonweb as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb3.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,41 as versi FROM daftarkonweb za3 
LEFT JOIN a_standarkompetensi zb3 ON za3.idsk=zb3.IDsk 
LEFT JOIN tmatapelajaran zc3 ON za3.IDmatapelajaran=zc3.IDmatapelajaran 
WHERE za3.setatus=3 AND za3.IDkelas=:fkelas 
ORDER BY judulmateri LIMIT ".$start.",".$limit);

$database->bind(':fkelas',$arg1);

$rows = $database->resultset();
$jmlmateri=$database->rowCount();
for ($i=0;$i<$jmlmateri;$i++)
{
	$judulmateri[$i]=$rows[$i]['judulmateri'];
	$sinopsis[$i]=substr(strip_tags($rows[$i]['sinopsis']),0,350);
	$idmapel[$i]=$rows[$i]['idbahanajar'];
	$ikonmapel[$i]=$rows[$i]['ikonbahanajar'];
	$versi[$i]=$rows[$i]['versi'];
	$idbahanajar[$i]=$rows[$i]['idbahanajar'];
	$namamapel[$i]=$rows[$i]['NMmatapelajaran'];
}

for ($i=0;$i<$jmlmateri;$i++)
{
$nkolom=1;
?>
<br />
<br />
<div id="maincontainer">
<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$i] ?>&idmateri=<?php echo $idbahanajar[$i] ?>&kl=<?php echo $arg1;?>" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotakgambar" class="warnaborder<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>">
<?php
if ($ikonmapel[$i]=="")
{
	?>
	<img src="
    <?php if ($arg1>=1 && $arg1<=6) 
	echo $alamatdata.'SD00.png';
	else if ($arg1>=7 && $arg1<=9) 
	echo $alamatdata.'SMP00.png';
	else if ($arg1>=10) 
	echo $alamatdata.'SMA00.png';
	?>
    " width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$i]==11)
{?>
	<img src="../file_storage/materi_pokok/MP_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==12)
{
	?>
	 <img src="../file_storage/modul_online/MO_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==21)
{?>
	<img src="../file_storage/materi_pokok/mapok<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==22)
{?>
	<img src="../file_storage/modul_online/mol<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==40)
{?>
	<img src="../file_storage/learning_object/lo<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==41)
{?>
	<img src="../file_storage/kontenweb/konweb<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="../file_storage/pengetahuan_populer/PP_<?php echo $idmapel[$i] ?>/Images/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>"><div class="infomapel"><?php echo $namamapel[$i]?></div><div class="infokelas">Kelas 
	<?php 
	if ($arg1>12) 
	{
		echo ($arg1-3)." (SMK)";
	}
	else
	{
		echo $arg1;
	}
	?></div></div>
</a>
</div>
</div>
</div>

<?php
$i++;
if($i<$jmlmateri)
{
$nkolom++;
?>
<div id="leftcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$i] ?>&idmateri=<?php echo $idbahanajar[$i] ?>&kl=<?php echo $arg1;?>" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotakgambar" class="warnaborder<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>">
<?php
if ($ikonmapel[$i]=="")
{
	?>
	<img src="
    <?php if ($arg1>=1 && $arg1<=6) 
	echo $alamatdata.'SD00.png';
	else if ($arg1>=7 && $arg1<=9) 
	echo $alamatdata.'SMP00.png';
	else if ($arg1>=10) 
	echo $alamatdata.'SMA00.png';
	?>
    " width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$i]==11)
{?>
	<img src="../file_storage/materi_pokok/MP_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==12)
{
	?>
	 <img src="../file_storage/modul_online/MO_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==21)
{?>
	<img src="../file_storage/materi_pokok/mapok<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==22)
{?>
	<img src="../file_storage/modul_online/mol<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==40)
{?>
	<img src="../file_storage/learning_object/lo<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php }  else if ($versi[$i]==41)
{?>
	<img src="../file_storage/kontenweb/konweb<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="../file_storage/pengetahuan_populer/PP_<?php echo $idmapel[$i] ?>/Images/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>"><div class="infomapel"><?php echo $namamapel[$i]?></div><div class="infokelas">Kelas 
	<?php 
	if ($arg1>12) 
	{
		echo ($arg1-3)." (SMK)";
	}
	else
	{
		echo $arg1;
	}
	?></div></div>
</a>
</div>
</div>
<?php
}

$i++;
if($i<$jmlmateri)
{
$nkolom++;
?>
<div id="rightcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$i] ?>&idmateri=<?php echo $idbahanajar[$i] ?>&kl=<?php echo $arg1;?>" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotakgambar" class="warnaborder<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>">
<?php
if ($ikonmapel[$i]=="")
{
	?>
	<img src="
    <?php if ($arg1>=1 && $arg1<=6) 
	echo $alamatdata.'SD00.png';
	else if ($arg1>=7 && $arg1<=9) 
	echo $alamatdata.'SMP00.png';
	else if ($arg1>=10) 
	echo $alamatdata.'SMA00.png';
	?>
    " width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$i]==11)
{?>
	<img src="../file_storage/materi_pokok/MP_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==12)
{
	?>
	 <img src="../file_storage/modul_online/MO_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==21)
{?>
	<img src="../file_storage/materi_pokok/mapok<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==22)
{?>
	<img src="../file_storage/modul_online/mol<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==40)
{?>
	<img src="../file_storage/learning_object/lo<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$i]==41)
{?>
	<img src="../file_storage/kontenweb/konweb<?php echo $idmapel[$i] ?>/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="../file_storage/pengetahuan_populer/PP_<?php echo $idmapel[$i] ?>/Images/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar<?php if ($arg1>=1 && $arg1<=6) 
	echo '3';
	else if ($arg1>=7 && $arg1<=9) 
	echo '2';
	else if ($arg1>=10) 
	echo '1';
	else
	echo '4';
	?>"><div class="infomapel"><?php echo $namamapel[$i]?></div><div class="infokelas">Kelas 
	<?php 
	if ($arg1>12) 
	{
		echo ($arg1-3)." (SMK)";
	}
	else
	{
		echo $arg1;
	}
	?></div></div>
</a>

</div>
<?php
}
if ($nkolom==1) ?>
<div style="height:220px">&nbsp;</div>
<?php 
if ($nkolom>2 && $i<$jmlmateri)
{
?>
<div id="footer">&nbsp;</div>
</div>

<?php
}
else
{
?>

<div id="footern<?php echo $nkolom ?>"></div>
</div>

<?php	
}
?>
<div id="footerx">&nbsp;</div>
<?php }
?>