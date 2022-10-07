<?php
$database->query("
SELECT nmkatvideo,idkatvideo,nmvideo FROM katvideo a  
INNER JOIN daftarslb b ON iddaftarvideo=idkatvideo 
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

if ($tipemedia=='1')
{
	$dicek1="checked";
}
if ($tipemedia=='2')
{
	$dicek2="checked";
}
}
?>

<div class="radio">
<form action="#" method="post" class="demoForm" id="transForm" onclick="cek1()">
    <input id="video" type="radio" name="tipenya" value="2" <?php echo $dicek2;?>>
    <label for="video">SLB A</label>
    <input id="audio" type="radio" name="tipenya" value="1" <?php echo $dicek1;?>>
    <label for="audio">SLB B</label>
</form>
</div>

