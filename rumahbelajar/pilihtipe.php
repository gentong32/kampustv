<?php
$database->query("
SELECT nmkatvideo,idkatvideo,nmvideo FROM katvideo a  
INNER JOIN daftarvideo b ON iddaftarvideo=idkatvideo 
ORDER BY nmkatvideo");

$rows = $database->resultset();
$jmlmapel=$database->rowCount();
for ($i=0;$i<$jmlmapel;$i++)
{
	$namamapel[$i]=$rows[$i]['nmkatvideo'];
	$idmapel[$i]=$rows[$i]['idkatvideo'];
}

if ($jmlmapel==0)
{
	 //echo '.. belum ada materi di kelas ini ...';
}

else
{
$dicek1="";
$dicek2="";
$dicek3="";

if ($tipemedia=='1')
{
	$dicek1="checked";
}
if ($tipemedia=='2')
{
	$dicek2="checked";
}
if ($tipemedia=='3')
{
	$dicek3="checked";
}
}
?>

<div class="radio">
<form action="#" method="post" class="demoForm" id="transForm" onclick="cek1()">
    <input id="video" type="radio" name="tipenya" value="1" <?php echo $dicek1;?>>
    <label for="video">Video</label>
    <input id="audio" type="radio" name="tipenya" value="2" <?php echo $dicek2;?>>
    <label for="audio">Audio</label>
	<input id="multi" type="radio" name="tipenya" value="3" <?php echo $dicek3;?>>
    <label for="multi">Multimedia</label>
</form>
</div>

