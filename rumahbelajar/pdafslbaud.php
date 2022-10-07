<?php
if ($cari=="")
$cekcari="WHERE setatus='3' AND a.idkat=:ftipe AND a.iduser=:fuser";
else
$cekcari="WHERE setatus='3' AND a.idkat=:ftipe AND a.iduser=:fuser AND nmvideo LIKE :fcari";

$database->query("SELECT iddaftarvideo as idbahanajar,ikon as ikonbahanajar,nmvideo as judulmateri,sinopsis,nmkatvideo FROM daftarslb a 
LEFT JOIN katvideo b ON a.idkat=b.idkatvideo  
".$cekcari);

$database->bind(':ftipe',$tipemedia);
$database->bind(':fuser',$tipeuser);
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
$limit = 15;
$start=($npage-1)*$limit;

$database->query("SELECT iddaftarvideo as idbahanajar,ikon as ikonbahanajar,nmvideo as judulmateri,sinopsis,nmkatvideo FROM daftarslb a 
LEFT JOIN katvideo b ON a.idkat=b.idkatvideo ".$cekcari."   
ORDER BY judulmateri LIMIT ".$start.",".$limit);

$database->bind(':ftipe',$tipemedia);
$database->bind(':fuser',$tipeuser);
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
	$namamapel[$i]=$rows[$i]['nmkatvideo'];
}

/*
$jmlmateri=3;
for ($i=1;$i<15;$i++)
{
	$judulmateri[$i]=$judulmateri[0];
	$ikonmapel[$i]=$ikonmapel[0];
	$namamapel[$i]=$namamapel[0];
}
*/

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

<a class="hovertext2" target="_blank" href="" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar4"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotaksuara" class="warnaborder4">
<audio controls width="100px" height="50px">
  <source src="..\file_storage\video_belajar\slb\<?php echo $ikonmapel[$i];?>.mp3" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
</div>
<div id="mapelsuara" class="warnajudulgambar4"><div class="infomapel"><?php echo $namamapel[$i]?></div></div>
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
<div id="leftcolumn" style="height:60px">
<div class="innertube">
<a class="hovertext2" target="_blank" href="" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar4"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotaksuara" class="warnaborder4">
<audio controls width="100px" height="50px">
  <source src="..\file_storage\video_belajar\slb\<?php echo $ikonmapel[$i];?>.mp3" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
</div>
<div id="mapelsuara" class="warnajudulgambar4"><div class="infomapel"><?php echo $namamapel[$i]?></div></div>
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
<div id="rightcolumn" style="height:60px;">
<div class="innertube">
<a class="hovertext2" target="_blank" href="" sinopsis="<?php echo $sinopsis[$i] ?>">
<div id="judulgambar" class="warnajudulgambar4"><div class="tengahvert"><?php echo $judulmateri[$i] ?></div></div>
<div id="kotaksuara" class="warnaborder4">
<audio controls width="100px" height="50px">
  <source src="..\file_storage\video_belajar\slb\<?php echo $ikonmapel[$i];?>.mp3" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
</div>
</div>
<div id="mapelsuara" style="top:67px; left:10px" class="warnajudulgambar4"><div class="infomapel"><?php echo $namamapel[$i]?></div></div>
</a>

</div>
<?php
}
if ($nkolom==1) ?>
<div style="height:80px">&nbsp;</div>
<?php 
if ($nkolom>2 && $i<$jmlmateri)
{
?>
<div style="height:0px">&nbsp;</div>
<?php
}
else
{
?>
<div style="height:0px">&nbsp;</div>
<?php	
}
?>
<div id="footerx">&nbsp;</div>
<?php }

?>