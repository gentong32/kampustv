<?php
if ($cari=="")
$cekcari="WHERE status='Y'";
else
$cekcari="WHERE status='Y' AND NMpengpop LIKE :fcari";

$database->query("SELECT IDpengpop as idbahanajar,IMGpengpop as ikonbahanajar,NMpengpop as judulmateri,DESCpengpop as sinopsis,NMkatpengpop FROM tpengpop a 
LEFT JOIN tkatpengpop b ON a.IDkatpengpop=b.uniqNo 
".$cekcari);

if ($cari=="")
{
}
else
{
	$fcari = "%".$cari."%";
	$database->bind(':fcari',$fcari);
}

$rows = $database->resultset();
$totalmateri=$database->rowCount();

if($npage=="")
{
	$npage="1";
}
$limit = 9;
$start=($npage-1)*$limit;

$database->query("SELECT IDpengpop as idbahanajar,IMGpengpop as ikonbahanajar,NMpengpop as judulmateri,DESCpengpop as sinopsis,NMkatpengpop FROM tpengpop a 
LEFT JOIN tkatpengpop b ON a.IDkatpengpop=b.uniqNo ".$cekcari."   
ORDER BY judulmateri LIMIT ".$start.",".$limit);
 
if ($cari=="")
{
}
else
{
	$fcari = "%".$cari."%";
	$database->bind(':fcari',$fcari);
}

$rows = $database->resultset();
$jmlmateri=$database->rowCount();

for ($i=0;$i<$jmlmateri;$i++)
{	
	$judulmateri[$i]=$rows[$i]['judulmateri'];
	$sinopsis[$i]=substr(strip_tags($rows[$i]['sinopsis']),0,350);
	$idmapel[$i]=$rows[$i]['idbahanajar'];
	$ikonmapel[$i]=$rows[$i]['ikonbahanajar'];
	$namamapel[$i]=$rows[$i]['NMkatpengpop'];
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
<a class="hovertext" target="_blank" href="tampilajar.php?ver=99&idmateri=<?php echo $idmapel[$i] ?>" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar4"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotakgambar" class="warnaborder4">
<?php
if ($ikonmapel[$i]=="")
{
	?>
	<img src="<?php echo $alamatdata.'PP00.png';?>" width="275" height="150" border="0" alt="">
<?php
}
else
{?>
<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } ?>
</div>
<div id="mapelgambar" class="warnajudulgambar4"><div class="infomapel"><?php echo $namamapel[$i]?></div></div>
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
<a class="hovertext" target="_blank" href="tampilajar.php?ver=99&idmateri=<?php echo $idmapel[$i] ?>" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar4"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotakgambar" class="warnaborder4">
<?php
if ($ikonmapel[$i]=="")
{
	?>
	<img src="<?php echo $alamatdata.'PP00.png';?>" width="275" height="150" border="0" alt="">
<?php
}
else
{?>
<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } ?>
</div>
<div id="mapelgambar" class="warnajudulgambar4"><div class="infomapel"><?php echo $namamapel[$i]?></div></div>
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
<a class="hovertext" target="_blank" href="tampilajar.php?ver=99&idmateri=<?php echo $idmapel[$i] ?>" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar4"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotakgambar" class="warnaborder4">
<?php
if ($ikonmapel[$i]=="")
{
	?>
	<img src="<?php echo $alamatdata.'PP00.png';?>" width="275" height="150" border="0" alt="">
<?php
}
else
{?>
<img src="<?php echo $alamatdata ?>pengetahuan_populer/PP_<?php echo $idmapel[$i] ?>/Image/<?php echo $ikonmapel[$i] ?>" width="275" height="150" border="0" alt="">
<?php } ?>
</div>
<div id="mapelgambar" class="warnajudulgambar4"><div class="infomapel"><?php echo $namamapel[$i]?></div></div>
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