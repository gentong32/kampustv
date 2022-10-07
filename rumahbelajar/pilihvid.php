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
echo "
     <select id='pilihanmapel'>
	 <option value=''>-- pilih kategori --</option>
	 ";
	 
     for ($i=0; $i<$jmlmapel; $i++)
     {
		 if ($namamapel[$i]==$argp2)
		  echo "<option selected value='$idmapel[$i]'>$namamapel[$i]</option>";
		 else
          echo "<option value='$idmapel[$i]'>$namamapel[$i]</option>";
     }
 
echo" </select>
<input id='gobutton' type='submit' value='pilih' onclick='Javascript:GetOptionsPop()'/>";
}
?>