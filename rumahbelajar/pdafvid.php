<?php
require_once "global2.php";
$alamatdata="../file_storage/";
if ($cari=="")
$cekcari="WHERE setatus='3' AND a.idkat=:ftipe AND a.iduser=:fuser";
else
$cekcari="WHERE setatus='3' AND a.idkat=:ftipe AND a.iduser=:fuser AND nmvideo LIKE :fcari";

$database2->query("SELECT iddaftarvideo as idbahanajar,ikon as ikonbahanajar,nmvideo as judulmateri,sinopsis,nmkatvideo FROM daftarvideo a 
LEFT JOIN katvideo b ON a.idkat=b.idkatvideo  
".$cekcari);

$database2->bind(':ftipe',$tipemedia);
$database2->bind(':fuser',$tipeuser);
if ($cari=="")
{
}
else
{
$fcari = "%".$cari."%";
$database2->bind(':fcari',$fcari);
}

$rows = $database2->resultset();
$totalmateri=$database2->rowCount();

if($npage=="")
{
	$npage="1";
}
$limit = 9;
$start=($npage-1)*$limit;

$database2->query("SELECT iddaftarvideo as idbahanajar,ikon as ikonbahanajar,nmvideo as judulmateri,sinopsis,nmkatvideo FROM daftarvideo a 
LEFT JOIN katvideo b ON a.idkat=b.idkatvideo ".$cekcari."   
ORDER BY judulmateri LIMIT ".$start.",".$limit);

$database2->bind(':ftipe',$tipemedia);
$database2->bind(':fuser',$tipeuser);

if ($cari=="")
{
}
else
{
$fcari = "%".$cari."%";
$database2->bind(':fcari',$fcari);
}

$rows = $database2->resultset();
$jmlmateri=$database2->rowCount();

for ($i=0;$i<$jmlmateri;$i++)
{
	$judulmateri[$i]=$rows[$i]['judulmateri'];
	$sinopsis[$i]=substr(strip_tags($rows[$i]['sinopsis']),0,350);
	$idmapel[$i]=$rows[$i]['idbahanajar'];
	$ikonmapel[$i]=$rows[$i]['ikonbahanajar'];
	$namamapel[$i]=$rows[$i]['nmkatvideo'];
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
<a class="hovertext" target="_blank" href="tampilajar.php?ver=0&idmateri=<?php echo $idmapel[$i] ?>" sinopsis="<?php echo $sinopsis[$i] ?>">
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
<img src="<?php echo $alamatdata ?>video_belajar/paud/<?php echo $ikonmapel[$i].'.jpg' ?>" width="275" height="150" border="0" alt="">
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
<a class="hovertext" target="_blank" href="tampilajar.php?ver=0&idmateri=<?php echo $idmapel[$i] ?>" sinopsis="<?php echo $sinopsis[$i] ?>">
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
<img src="<?php echo $alamatdata ?>video_belajar/paud/<?php echo $ikonmapel[$i].'.jpg' ?>" width="275" height="150" border="0" alt="">
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
<a class="hovertext" target="_blank" href="tampilajar.php?ver=0&idmateri=<?php echo $idmapel[$i] ?>" sinopsis="<?php echo $sinopsis[$i] ?>">
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
<img src="<?php echo $alamatdata ?>video_belajar/paud/<?php echo $ikonmapel[$i].'.jpg' ?>" width="275" height="150" border="0" alt="">
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