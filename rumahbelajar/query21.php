<?php
$jmat=0;
$jlat=0;
$jsim=0;

for ($i=0;$i<$jmlmenu;$i++)
	{ 
	if($rows[$i]['title']=="Pendahuluan")
	{
		$isiPendahuluan=$rows[$i]['detail'];
		//$isiPendahuluan=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiPendahuluan);
	} else if($rows[$i]['title']=="Kompetensi")
	{
		$isiKompetensi=$rows[$i]['detail'];
		//$isiKompetensi=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiKompetensi);	
	}  else if(substr($rows[$i]['title'],0,11)=="MateriJudul")
	{
		$jmat++;
		$judulMateri[substr($rows[$i]['title'],11,1)]=$rows[$i]['detail'];
		//$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
	}
	else if(substr($rows[$i]['title'],0,6)=="Materi")
	{
		$isiMateri[substr($rows[$i]['title'],6,1)]=$rows[$i]['detail'];
		//$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
	} else if(substr($rows[$i]['title'],0,12)=="LatihanJudul")
	{
		$jlat++;
		$judulLatihan[substr($rows[$i]['title'],12,1)]=$rows[$i]['detail'];
		//$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
	}
	else if(substr($rows[$i]['title'],0,7)=="Latihan")
	{
		$isiLatihan[substr($rows[$i]['title'],7,1)]=$rows[$i]['detail'];
		//$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
	} else if(substr($rows[$i]['title'],0,13)=="SimulasiJudul")
	{
		$jsim++;
		$judulSimulasi[substr($rows[$i]['title'],13,1)]=$rows[$i]['detail'];
		//$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
	}
	else if(substr($rows[$i]['title'],0,8)=="Simulasi")
	{
		$isiSimulasi[substr($rows[$i]['title'],8,1)]=$rows[$i]['detail'];
		//$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
	}
	else if($rows[$i]['title']=="Referensi")
	{
		$isiReferensi=$rows[$i]['detail'];
		//$isiKompetensi=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiKompetensi);	
	} else if($rows[$i]['title']=="Tes")
	{
		$isiTes=$rows[$i]['detail'];
		//$isiKompetensi=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiKompetensi);	
	}
	else if($rows[$i]['title']=="Tim")
	{
		$isiTim=$rows[$i]['detail'];
		//$isiKompetensi=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiKompetensi);	
	}
}
?>