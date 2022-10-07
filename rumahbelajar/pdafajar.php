<?php
$database->query("SELECT IDmateripokok as idbahanajar,IMGmateripokok as ikonbahanajar,NMmateripokok as judulmateri,a.IDmatapelajaran as IDmapel,DESCmateripokok as sinopsis,NMmatapelajaran,versi,IDkelas FROM tmateripokok a 
LEFT JOIN tmatapelajaran b ON a.IDmatapelajaran=b.IDmatapelajaran 
WHERE a.status='Y' AND IDkelas>=10 AND IDkelas<=15    
UNION 
SELECT iddaftarmapok as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,xb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi,xb.IDkelas as IDkelas FROM daftarmapok2 xa 
LEFT JOIN a_standarkompetensi xb ON xa.idsk=xb.IDsk 
LEFT JOIN tmatapelajaran xc ON xb.IDmatapelajaran=xc.IDmatapelajaran 
WHERE xa.setatus=3 AND xb.IDkelas>=10 AND xb.IDkelas<=15 
UNION
SELECT IDmodulonline as idbahanajar,IMGmodulonline as ikonbahanajar,NMmodulonline as judulmateri,ya.IDmatapelajaran as IDmapel,DESCmodulonline as sinopsis,NMmatapelajaran,versi,ya.IDkelas as IDKelas FROM tmodulonline ya 
LEFT JOIN tmatapelajaran yb ON ya.IDmatapelajaran=yb.IDmatapelajaran 
WHERE ya.status='Y' AND ya.IDkelas>=10 AND ya.IDkelas<=15   
UNION 
SELECT iddaftarmol as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi,zb.IDkelas as IDkelas FROM daftarmol2 za 
LEFT JOIN a_standarkompetensi zb ON za.idsk=zb.IDsk 
LEFT JOIN tmatapelajaran zc ON zb.IDmatapelajaran=zc.IDmatapelajaran 
WHERE za.setatus=3 AND zb.IDkelas>=10 AND zb.IDkelas<=15 
UNION 
SELECT iddaftarlo as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,za2.IDmatapelajaran as 
IDmapel,sinopsis,NMmatapelajaran,40 as versi,za2.IDkelas as IDkelas FROM daftarlo za2 
LEFT JOIN tmatapelajaran zc2 ON za2.IDmatapelajaran=zc2.IDmatapelajaran 
WHERE za2.setatus=3 AND za2.IDkelas>=10 AND za2.IDkelas<=15 
UNION 
SELECT iddaftarkonweb as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,za3.IDmatapelajaran as 
IDmapel,sinopsis,NMmatapelajaran,41 as versi,za3.IDkelas as IDkelas FROM daftarkonweb za3 
LEFT JOIN tmatapelajaran zc3 ON za3.IDmatapelajaran=zc3.IDmatapelajaran 
WHERE za3.setatus=3 AND za3.IDkelas>=10 AND za3.IDkelas<=15 
ORDER BY judulmateri");



$rows = $database->resultset();
$jmlmateri=$database->rowCount();
for ($i=0;$i<$jmlmateri;$i++)
{
	$judulmateri[$i]=$rows[$i]['judulmateri'];
	$sinopsis[$i]=substr(strip_tags($rows[$i]['sinopsis']),0,300);
	$idmapel[$i]=$rows[$i]['idbahanajar'];
	$ikonmapel[$i]=$rows[$i]['ikonbahanajar'];
	$versi[$i]=$rows[$i]['versi'];
	$idbahanajar[$i]=$rows[$i]['idbahanajar'];
	$namamapel[$i]=$rows[$i]['NMmatapelajaran'];
	$idkelas[$i]=$rows[$i]['IDkelas'];
}

//////////////////////////////////////////////////////////////////////////////

$urut[0]=1;
$urut[1]=2;
$urut[2]=3;

for ($i=0;$i<$jmlmateri;$i++)
{
	$cekdata[$i]=0;
}

$i=0;

if($jmlmateri>3)
{
	while($i<3)
	{
		$acak=rand(1,$jmlmateri);
		if($cekdata[$acak]==0)
		{
			$urut[$i]=$acak;
			$cekdata[$acak]=1;
			$i++;
		}
	}
}

$i=0;

?>
<div id="maincontainer">
<div id="topsection3">Topik Terbaru SMA/SMK</div>
<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar1"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder1">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SMA00.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar1"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas 
<?php 
if($idkelas[$urut[$i]]>10)
{
	echo $idkelas[$urut[$i]]-3;
}
else
{
	echo $idkelas[$urut[$i]];
}?></div></div>
</a>
</div>
</div>
</div>

<?php
$i++;
if($i<$jmlmateri)
{
?>
<div id="leftcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar1"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder1">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SMA00.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar1"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas <?php 
if($idkelas[$urut[$i]]>10)
{
	echo $idkelas[$urut[$i]]-3;
}
else
{
	echo $idkelas[$urut[$i]];
}?></div></div>
</a>
</div>
</div>

<?php } ?>

<?php
$i++;
if($i<$jmlmateri)
{
?>
<div id="rightcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar1"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder1">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SMA00.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar1"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas <?php 
if($idkelas[$urut[$i]]>10)
{
	echo $idkelas[$urut[$i]]-3;
}
else
{
	echo $idkelas[$urut[$i]];
}?></div></div>
</a>
</div>
</div>
<div id="footer">&nbsp;</div>
</div>
<?php } 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php

$database->query("SELECT IDmateripokok as idbahanajar,IMGmateripokok as ikonbahanajar,NMmateripokok as judulmateri,a.IDmatapelajaran as IDmapel,DESCmateripokok as sinopsis,NMmatapelajaran,versi,IDkelas FROM tmateripokok a 
LEFT JOIN tmatapelajaran b ON a.IDmatapelajaran=b.IDmatapelajaran 
WHERE a.status='Y' AND IDkelas>=7 AND IDkelas<=9    
UNION 
SELECT iddaftarmapok as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,xb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi,xb.IDkelas as IDkelas FROM daftarmapok2 xa 
LEFT JOIN a_standarkompetensi xb ON xa.idsk=xb.IDsk 
LEFT JOIN tmatapelajaran xc ON xb.IDmatapelajaran=xc.IDmatapelajaran 
WHERE xa.setatus=3 AND xb.IDkelas>=7 AND xb.IDkelas<=9 
UNION
SELECT IDmodulonline as idbahanajar,IMGmodulonline as ikonbahanajar,NMmodulonline as judulmateri,ya.IDmatapelajaran as IDmapel,DESCmodulonline as sinopsis,NMmatapelajaran,versi,ya.IDkelas as IDKelas FROM tmodulonline ya 
LEFT JOIN tmatapelajaran yb ON ya.IDmatapelajaran=yb.IDmatapelajaran 
WHERE ya.status='Y' AND ya.IDkelas>=7 AND ya.IDkelas<=9   
UNION 
SELECT iddaftarmol as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi,zb.IDkelas as IDkelas FROM daftarmol2 za 
LEFT JOIN a_standarkompetensi zb ON za.idsk=zb.IDsk 
LEFT JOIN tmatapelajaran zc ON zb.IDmatapelajaran=zc.IDmatapelajaran 
WHERE za.setatus=3 AND zb.IDkelas>=7 AND zb.IDkelas<=9 
ORDER BY judulmateri");

$rows = $database->resultset();
$jmlmateri=$database->rowCount();
for ($i=0;$i<$jmlmateri;$i++)
{
	$judulmateri[$i]=$rows[$i]['judulmateri'];
	$sinopsis[$i]=substr(strip_tags($rows[$i]['sinopsis']),0,300);
	$idmapel[$i]=$rows[$i]['idbahanajar'];
	$ikonmapel[$i]=$rows[$i]['ikonbahanajar'];
	$versi[$i]=$rows[$i]['versi'];
	$idbahanajar[$i]=$rows[$i]['idbahanajar'];
	$namamapel[$i]=$rows[$i]['NMmatapelajaran'];
	$idkelas[$i]=$rows[$i]['IDkelas'];
}

//////////////////////////////////////////////////////////////////////////////

$urut[0]=1;
$urut[1]=2;
$urut[2]=3;

for ($i=0;$i<$jmlmateri;$i++)
{
	$cekdata[$i]=0;
}

$i=0;

if($jmlmateri>3)
{
	while($i<3)
	{
		$acak=rand(1,$jmlmateri);
		if($cekdata[$acak]==0)
		{
			$urut[$i]=$acak;
			$cekdata[$acak]=1;
			$i++;
		}
	}
}

$i=0;

?>
<div id="maincontainer">
<div id="topsection2">Topik Terbaru SMP</div>
<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar2"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder2">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SMP00.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar2"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas <?php echo $idkelas[$urut[$i]]?></div></div>
</a>
</div>
</div>
</div>

<?php
$i++;
if($i<$jmlmateri)
{
?>
<div id="leftcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar2"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder2">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SMP00.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar2"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas <?php echo $idkelas[$urut[$i]]?></div></div>
</a>
</div>
</div>

<?php } ?>

<?php
$i++;
if($i<$jmlmateri)
{
?>
<div id="rightcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar2"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder2">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SMP00.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar2"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas <?php echo $idkelas[$urut[$i]]?></div></div>
</a>
</div>
</div>
<div id="footer">&nbsp;</div>
</div>
<?php } 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php

$database->query("SELECT IDmateripokok as idbahanajar,IMGmateripokok as ikonbahanajar,NMmateripokok as judulmateri,a.IDmatapelajaran as IDmapel,DESCmateripokok as sinopsis,NMmatapelajaran,versi,IDkelas FROM tmateripokok a 
LEFT JOIN tmatapelajaran b ON a.IDmatapelajaran=b.IDmatapelajaran 
WHERE a.status='Y' AND IDkelas>=1 AND IDkelas<=6    
UNION 
SELECT iddaftarmapok as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,xb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi,xb.IDkelas as IDkelas FROM daftarmapok2 xa 
LEFT JOIN a_standarkompetensi xb ON xa.idsk=xb.IDsk 
LEFT JOIN tmatapelajaran xc ON xb.IDmatapelajaran=xc.IDmatapelajaran 
WHERE xa.setatus=3 AND xb.IDkelas>=1 AND xb.IDkelas<=6 
UNION
SELECT IDmodulonline as idbahanajar,IMGmodulonline as ikonbahanajar,NMmodulonline as judulmateri,ya.IDmatapelajaran as IDmapel,DESCmodulonline as sinopsis,NMmatapelajaran,versi,ya.IDkelas as IDKelas FROM tmodulonline ya 
LEFT JOIN tmatapelajaran yb ON ya.IDmatapelajaran=yb.IDmatapelajaran 
WHERE ya.status='Y' AND ya.IDkelas>=1 AND ya.IDkelas<=6   
UNION 
SELECT iddaftarmol as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi,zb.IDkelas as IDkelas FROM daftarmol2 za 
LEFT JOIN a_standarkompetensi zb ON za.idsk=zb.IDsk 
LEFT JOIN tmatapelajaran zc ON zb.IDmatapelajaran=zc.IDmatapelajaran 
WHERE za.setatus=3 AND zb.IDkelas>=1 AND zb.IDkelas<=6 
ORDER BY judulmateri");

$rows = $database->resultset();
$jmlmateri=$database->rowCount();
for ($i=0;$i<$jmlmateri;$i++)
{
	$judulmateri[$i]=$rows[$i]['judulmateri'];
	$sinopsis[$i]=substr(strip_tags($rows[$i]['sinopsis']),0,300);
	$idmapel[$i]=$rows[$i]['idbahanajar'];
	$ikonmapel[$i]=$rows[$i]['ikonbahanajar'];
	$versi[$i]=$rows[$i]['versi'];
	$idbahanajar[$i]=$rows[$i]['idbahanajar'];
	$namamapel[$i]=$rows[$i]['NMmatapelajaran'];
	$idkelas[$i]=$rows[$i]['IDkelas'];
}

//////////////////////////////////////////////////////////////////////////////

$urut[0]=1;
$urut[1]=2;
$urut[2]=3;

for ($i=0;$i<$jmlmateri;$i++)
{
	$cekdata[$i]=0;
}

$i=1;

if($jmlmateri>3)
{
	while($i<3)
	{
		$acak=rand(1,$jmlmateri);
		if($cekdata[$acak]==0)
		{
			$urut[$i]=$acak;
			$cekdata[$acak]=1;
			$i++;
		}
	}
}

$i=0;

?>
<div id="maincontainer">
<div id="topsection1">Topik Terbaru SD</div>
<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar3"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder3">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SD00.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar3"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas <?php echo $idkelas[$urut[$i]]?></div></div>
</a>
</div>
</div>
</div>

<?php
$i++;
if($i<$jmlmateri)
{
?>
<div id="leftcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar3"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder3">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SD.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar3"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas <?php echo $idkelas[$urut[$i]]?></div></div>
</a>
</div>
</div>

<?php } ?>

<?php
$i++;
if($i<$jmlmateri)
{
?>
<div id="rightcolumn">
<div class="innertube">
<a class="hovertext" target="_blank" href="tampilajar.php?ver=<?php echo $versi[$urut[$i]] ?>&idmateri=<?php echo $idbahanajar[$urut[$i]] ?>&kl=<?php echo $idkelas[$urut[$i]];?>" sinopsis="<?php echo $sinopsis[$urut[$i]] ?>">
<div id="judulgambar" class="warnajudulgambar3"><div class="tengahvert"><?php echo $judulmateri[$urut[$i]] ?></div></div>
<div id="kotakgambar" class="warnaborder3">
<?php
if ($ikonmapel[$urut[$i]]=="")
{
	?>
	<img src="<?php echo $alamatdata ?>SD00.png" width="275" height="150" border="0" alt="">
<?php
}
else
{
if ($versi[$urut[$i]]==11)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/MP_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==12)
{
	?>
	 <img src="<?php echo $alamatdata ?>modul_online/MO_<?php echo $idmapel[$urut[$i]] ?>/Image/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==21)
{?>
	<img src="<?php echo $alamatdata ?>materi_pokok/mapok<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==22)
{?>
	<img src="<?php echo $alamatdata ?>modul_online/mol<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==40)
{?>
	<img src="<?php echo $alamatdata ?>learning_object/lo<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php } else if ($versi[$urut[$i]]==41)
{?>
	<img src="<?php echo $alamatdata ?>kontenweb/konweb<?php echo $idmapel[$urut[$i]] ?>/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
else
{?>
	<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$urut[$i]] ?>/Images/<?php echo $ikonmapel[$urut[$i]] ?>" width="275" height="150" border="0" alt="">
<?php }
}
?>
</div>
<div id="mapelgambar" class="warnajudulgambar3"><div class="infomapel"><?php echo $namamapel[$urut[$i]]?></div><div class="infokelas">Kelas <?php echo $idkelas[$urut[$i]]?></div></div>
</a>
</div>
</div>
<div id="footer">&nbsp;</div>
</div>

<?php } 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>