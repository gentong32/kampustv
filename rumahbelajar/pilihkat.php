<?php
$database->query("SELECT NMkatpengpop,uniqNo,NMpengpop FROM tkatpengpop a  
INNER JOIN tpengpop b ON IDpengpop=uniqNo 
WHERE IDparent<>0 
ORDER BY NMkatpengpop");

$rows = $database->resultset();
$jmlmapel=$database->rowCount();
for ($i=0;$i<$jmlmapel;$i++)
{
	$namamapel[$i]=$rows[$i]['NMkatpengpop'];
	$idmapel[$i]=$rows[$i]['uniqNo'];
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