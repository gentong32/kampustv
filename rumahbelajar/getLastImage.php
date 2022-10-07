<?php
require_once "global.php";
error_reporting (E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

$arg1 = $_GET['kelas'];
$limit = 9;
$start = 0;
$result = array();
$result2 = array();

$query = "
SELECT IDmateripokok as idbahanajar,IMGmateripokok as ikonbahanajar,NMmateripokok as judulmateri,a.IDmatapelajaran as IDmapel,DESCmateripokok as sinopsis,NMmatapelajaran,versi FROM tmateripokok a 
LEFT JOIN tmatapelajaran b ON a.IDmatapelajaran=b.IDmatapelajaran 
WHERE IMGmateripokok<>'' AND IMGmateripokok>51 AND a.status='Y' AND IDkelas=".$arg1."    
UNION 
SELECT iddaftarmapok as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,xb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi FROM daftarmapok2 xa 
LEFT JOIN a_standarkompetensi xb ON xa.idsk=xb.IDsk 
LEFT JOIN tmatapelajaran xc ON xb.IDmatapelajaran=xc.IDmatapelajaran 
WHERE ikon<>'' AND xa.setatus=3 AND xb.IDkelas=".$arg1." 
UNION
SELECT IDmodulonline as idbahanajar,IMGmodulonline as ikonbahanajar,NMmodulonline as judulmateri,ya.IDmatapelajaran as IDmapel,DESCmodulonline as sinopsis,NMmatapelajaran,versi FROM tmodulonline ya 
LEFT JOIN tmatapelajaran yb ON ya.IDmatapelajaran=yb.IDmatapelajaran 
WHERE IMGmodulonline<>'' AND ya.status='Y' AND ya.IDkelas=".$arg1."  
UNION 
SELECT iddaftarmol as idbahanajar,ikon as ikonbahanajar,topik as judulmateri,zb.IDmatapelajaran as IDmapel,sinopsis,NMmatapelajaran,versi FROM daftarmol2 za 
LEFT JOIN a_standarkompetensi zb ON za.idsk=zb.IDsk 
LEFT JOIN tmatapelajaran zc ON zb.IDmatapelajaran=zc.IDmatapelajaran 
WHERE ikon<>'' AND za.setatus=3 AND zb.IDkelas=".$arg1." 
ORDER BY judulmateri LIMIT ".$start.",".$limit;

$hasil = mysql_query($query);
$jmlmateri = 0;
while ($data = mysql_fetch_array($hasil))
{ 
	$jmlmateri++;
	$judulmateri[$jmlmateri]=$data['judulmateri'];
	$sinopsis[$jmlmateri]=substr(strip_tags($data['sinopsis']),0,350);
	$idmapel[$jmlmateri]=$data['idbahanajar'];
	$ikonmapel[$jmlmateri]=$data['ikonbahanajar'];
	$versi[$jmlmateri]=$data['versi'];
	$idbahanajar[$jmlmateri]=$data['idbahanajar'];
	$namamapel[$jmlmateri]=$data['NMmatapelajaran'];
	if ($data['versi']==11)
	{
		$alamat="http://118.98.221.120/file_storage/materi_pokok/MP_".$data['idbahanajar']."/Image/".$data['ikonbahanajar']; 
	} else if ($data['versi']==12)
	{
		$alamat="http://118.98.221.120/file_storage/modul_online/MO_".$data['idbahanajar']."/Image/".$data['ikonbahanajar'];
	} else if ($data['versi']==21)
	{
		$alamat="http://118.98.221.120/file_storage/materi_pokok/mapok".$data['idbahanajar']."/".$data['ikonbahanajar'];
 	} else if ($data['versi']==22)
	{
		$alamat="http://118.98.221.120/file_storage/modul_online/mol".$data['idbahanajar']."/".$data['ikonbahanajar'];
	}
	array_push($result,array('url'=>$alamat,'judul'=>$data['judulmateri'],'sinopsis'=>substr(strip_tags($data['sinopsis']),0,350)));
	//array_push($result2,array('judul'=>$data['judulmateri']));
}

echo json_encode(array("result"=>$result));


