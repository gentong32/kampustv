<?php
$database->query("SELECT DISTINCT NMmatapelajaran,a.IDmatapelajaran as IDmapel FROM tmateripokok a 
LEFT JOIN tmatapelajaran b ON a.IDmatapelajaran=b.IDmatapelajaran 
WHERE IDkelas= :fkelas AND a.IDmatapelajaran>0  
UNION 
SELECT DISTINCT NMmatapelajaran,xb.IDmatapelajaran as IDmapel FROM daftarmapok2 xa 
LEFT JOIN a_standarkompetensi xb ON xa.idsk=xb.IDsk 
LEFT JOIN tmatapelajaran xc ON xb.IDmatapelajaran=xc.IDmatapelajaran 
WHERE xb.IDkelas= :fkelas AND xb.IDmatapelajaran>0
UNION
SELECT DISTINCT NMmatapelajaran,ya.IDmatapelajaran as IDmapel FROM tmodulonline ya 
LEFT JOIN tmatapelajaran yb ON ya.IDmatapelajaran=yb.IDmatapelajaran 
WHERE ya.IDkelas= :fkelas AND ya.IDmatapelajaran>0  
UNION 
SELECT DISTINCT NMmatapelajaran,zb.IDmatapelajaran as IDmapel FROM daftarmol2 za 
LEFT JOIN a_standarkompetensi zb ON za.idsk=zb.IDsk 
LEFT JOIN tmatapelajaran zc ON zb.IDmatapelajaran=zc.IDmatapelajaran 
WHERE zb.IDkelas= :fkelas AND zb.IDmatapelajaran>0
ORDER BY NMmatapelajaran");

$database->bind(':fkelas', $arg1);
$rows = $database->resultset();
$jmlmapel=$database->rowCount();
for ($i=0;$i<$jmlmapel;$i++)
{
	$namamapel[$i]=$rows[$i]['NMmatapelajaran'];
	$idmapel[$i]=$rows[$i]['IDmapel'];
}

if ($jmlmapel==0)
{
	 //echo '.. belum ada materi di kelas ini ...';
}

else
{
echo "
     <select style='width: 227px' id='pilihanmapel'>
	 <option value=''>-- pilih mata pelajaran --</option>
	 ";
	 
     for ($i=0; $i<$jmlmapel; $i++)
     {
		 if ($namamapel[$i]==$arg2)
		  echo "<option selected value='$idmapel[$i]'>$namamapel[$i]</option>";
		 else
          echo "<option value='$idmapel[$i]'>$namamapel[$i]</option>";
     }
 
echo" </select>
<input id='gobutton' type='submit' value='pilih' onclick='Javascript:GetOptions()'/>";
}
?>