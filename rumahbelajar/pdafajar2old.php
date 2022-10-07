<?php
if($jmlmapel==0)
{
?>	
<div id="maincontainer">
<div id="textMenu3"><a class="linkMenu3" href="index.php">Bahan Ajar</a> >> <?php echo $namakelas ?><br /></div>
<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">
</div>
</div>
</div>

<div id="leftcolumn">
<div class="innertube">
</div>
</div>

<div id="rightcolumn">
<div class="innertube">
</div>
</div>
<div id="footerasli">Pustekkom</div>
</div>
<?php	
}

else
{
for ($i=1;$i<=$jmlmapel;$i++)
{

//////////////////////////////////////////////////////////
$query = "
SELECT NMmateripokok as judulmateri,a.IDmatapelajaran as IDmapel,DESCmateripokok as sinopsis FROM tmateripokok a 
LEFT JOIN tmatapelajaran b ON a.IDmatapelajaran=b.IDmatapelajaran 
WHERE IDkelas=".$arg1." AND a.IDmatapelajaran=".$idmapel[$i]."   
UNION 
SELECT topik as judulmateri,xb.IDmatapelajaran as IDmapel,sinopsis FROM daftarmapok2 xa 
LEFT JOIN a_standarkompetensi xb ON xa.idsk=xb.IDsk 
LEFT JOIN tmatapelajaran xc ON xb.IDmatapelajaran=xc.IDmatapelajaran 
WHERE xb.IDkelas=".$arg1." AND xb.IDmatapelajaran=".$idmapel[$i]."
UNION
SELECT NMmodulonline as judulmateri,ya.IDmatapelajaran as IDmapel,DESCmodulonline as sinopsis FROM tmodulonline ya 
LEFT JOIN tmatapelajaran yb ON ya.IDmatapelajaran=yb.IDmatapelajaran 
WHERE ya.IDkelas=".$arg1." AND ya.IDmatapelajaran=".$idmapel[$i]."  
UNION 
SELECT topik as judulmateri,zb.IDmatapelajaran as IDmapel,sinopsis FROM daftarmol2 za 
LEFT JOIN a_standarkompetensi zb ON za.idsk=zb.IDsk 
LEFT JOIN tmatapelajaran zc ON zb.IDmatapelajaran=zc.IDmatapelajaran 
WHERE zb.IDkelas=".$arg1." AND zb.IDmatapelajaran=".$idmapel[$i]."
ORDER BY judulmateri
";

$hasil = mysql_query($query);
$jmlmateri = 0;
while ($data = mysql_fetch_array($hasil))
{ 
	$jmlmateri++;
	$judulmateri[$jmlmateri]=$data['judulmateri'];
	$sinopsis[$jmlmateri]=substr(strip_tags($data['sinopsis']),0,350);
	$cekdata[$jmlmateri]=0;
}
//////////////////////////////////////////////////////////////////////////////

$urut[1]=1;
$urut[2]=2;
$urut[3]=3;

$n=1;

if($jmlmateri>3)
{
	while($n<=3)
	{
		$acak=rand(1,$jmlmateri);
		if($cekdata[$acak]==0)
		{
			$urut[$n]=$acak;
			$n++;
		}
	}
}
?>
<div id="maincontainer">
<?php 
if ($i==1)
{
?>
<div id="textMenu3"><a class="linkMenu3" href="index.php">Bahan Ajar</a> >> <?php echo $namakelas ?><br /></div>
<?php
}
?>

<div id="topsection4"><?php echo $namamapel[$i]?></div>
<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">
<a class="hovertext" href="#" sinopsis="<?php echo $sinopsis[$urut[1]] ?>">
<img src="media/gbrikon.png" width="300" height="203" border="0" alt=""></a>
<p align="center"><?php echo $judulmateri[$urut[1]] ?></p>
</div>
</div>
</div>

<?php
$n++;
{
?>
<div id="leftcolumn">
<div class="innertube">
<a class="hovertext" href="#" sinopsis="<?php echo $sinopsis[$urut[2]] ?>">
<img src="media/gbrikon.png" width="300" height="203" border="0" alt=""></a>
<p align="center"><?php echo $judulmateri[$urut[2]] ?></p>
</div>
</div>
<?php
}

$n++;
{
?>
<div id="rightcolumn">
<div class="innertube">
<a class="hovertext" href="#" sinopsis="<?php echo $sinopsis[$urut[3]] ?>">
<img src="media/gbrikon.png" width="300" height="203" border="0" alt=""></a>
<p align="center"><?php echo $judulmateri[$urut[3]] ?></p>
</div>
</div>
<?php
}
if ($i<$jmlmapel)
{
?>

<div id="footer"></div>
</div>

<?php
}
else
{
?>

<div id="footer"></div>
</div>

<?php	
}
}
}
?>