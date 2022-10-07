<?php
$isiPendahuluan="";
$kodeKB="";
$kodePenutup="";
$isiLatihan="";
$kodeLatihan="";
$isiRangkuman="";
$isiTAM="";
$jmlKB=0;
$jmlTAM2=0;
$jmlLat2=0;
$jmlSub[1]=0;
$jmlSub[2]=0;
$jmlSub[3]=0;
$jmlSub[4]=0;
$jmlKuis=0;
$jmlLatihan=0;
$single=0;
$jmlmenu=0;


while($data = mysql_fetch_array($hasil))
{   
	$jmlmenu++;
	if(strtolower(trim(substr($data['TITLE'],0,11)))=="pendahuluan")
	{
		$judulPendahuluan=$data['TITLE'];
		$isiPendahuluan=$data['DETAIL'];
		$isiPendahuluan=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiPendahuluan);
		$isiPendahuluan=str_replace('src="/file_storage/modul_online','src="file_storages',$isiPendahuluan);
	}
	else if(strtolower(trim(substr($data['TITLE'],0,4)))=="kuis")
	{	
		$jmlKuis++;
		$judulKuis[$jmlKuis]=$data['TITLE'];
		$isiKuis[$jmlKuis]=$data['DETAIL'];
		$isiKuis[$jmlKuis]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiKuis[$jmlKuis]);
		$isiKuis[$jmlKuis]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiKuis[$jmlKuis]);
	}
	else if((strtolower(substr(trim($data['TITLE']),0,16))=="kegiatan belajar"))
	{
		$jmlKB++;
		$judulKB[$jmlKB]=$data['TITLE'];
		$kodeKB[$jmlKB]=$data['uniqNo'];
		$isiKB[$jmlKB]=$data['DETAIL'];
		$isiKB[$jmlKB]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiKB[$jmlKB]);
		$isiKB[$jmlKB]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiKB[$jmlKB]);
	}
	else if((strtolower(substr(trim($data['TITLE']),0,6))=="materi") && trim($data['DETAIL']<>""))
	{
		$jmlKB++;
		$judulKB[$jmlKB]='Kegiatan Belajar '.substr($data['TITLE'],7,1);
		$kodeKB[$jmlKB]=$data['uniqNo'];
		$single--;
		$jmlSub[$jmlKB]++;
		$t=$jmlSub[$jmlKB];
		$judulSub[$jmlKB][$t]=$data['TITLE'];
		$isiSub[$jmlKB][$t]=$data['DETAIL'];
	}
	else if((strtolower(substr(trim($data['TITLE']),0,6))=="materi") && trim($data['DETAIL']==""))
	{
		
	}
	else if((strtolower(substr(trim($data['TITLE']),0,13))=="kunci jawaban"))
	{
		
	}
	else if((strtolower(substr(trim($data['TITLE']),0,6))=="tujuan"))
	{
		for($c=1;$c<=$jmlKB;$c++)
		{
		if($data['PARENTdetail']==$kodeKB[$c])
		{
			$judulTujuan[$c]=$data['TITLE'];
			$isiTujuan[$c]=$data['DETAIL'];
			$isiTujuan[$c]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiTujuan[$c]);
			$isiTujuan[$c]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiTujuan[$c]);
			$isiTujuan[$c]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiTujuan[$c]);
			//$isiTujuan[$c]=str_replace('<embed height','<embed height="460" tinggi',$isiTujuan[$c]);
			//$isiTujuan[$c]=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiTujuan[$c]);	
		}
		}
	}
	else if((strtolower(substr(trim($data['TITLE']),0,6))=="uraian"))
	{
		for($c=1;$c<=$jmlKB;$c++)
		{
		if($data['PARENTdetail']==$kodeKB[$c])
		{
			$judulUraian[$c]=$data['TITLE'];
			$isiUraian[$c]=$data['DETAIL'];
			$isiUraian[$c]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiUraian[$c]);
			$isiUraian[$c]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiUraian[$c]);
			$isiUraian[$c]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiUraian[$c]);
			//$isiUraian[$c]=str_replace('<embed height','<embed height="460" tinggi',$isiUraian[$c]);
			//$isiUraian[$c]=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiUraian[$c]);	
		}
		}
	}
	else if((strtolower(substr(trim($data['TITLE']),0,9))=="rangkuman"))
	{
		for($c=1;$c<=$jmlKB;$c++)
		{
		if($data['PARENTdetail']==$kodeKB[$c])
		{
			$judulRkm[$c]=$data['TITLE'];
			$isiRkm[$c]=$data['DETAIL'];
			$isiRkm[$c]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiRkm[$c]);
			$isiRkm[$c]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiRkm[$c]);
			$isiRkm[$c]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiRkm[$c]);
			//$isiRkm[$c]=str_replace('<embed height','<embed height="460" tinggi',$isiRkm[$c]);
			//$isiRkm[$c]=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiRkm[$c]);	
		}
		}
		if($data['PARENTdetail']==$kodePenutup || $data['PARENTdetail']==0)
		{
			$judulRkmAkhir=$data['TITLE'];
			$isiRkmAkhir=$data['DETAIL'];
		}
	}
	else if((strtolower(substr(trim($data['TITLE']),0,7))=="latihan" || (strtolower(substr(trim($data['TITLE']),0,8))=="exercise")) 
	)
	{
		//echo 'CEK A :'.$cek.'<br>';
		
		if ($jmlKB==0)
		{
			$c=0;
			$judulLatihan[$c]=$data['TITLE'];
			$isiLatihan[$c]=$data['DETAIL'];
			$isiLatihan[$c]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiLatihan[$c]);
			$isiLatihan[$c]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiLatihan[$c]);
			$isiLatihan[$c]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiLatihan[$c]);
			//$isiLatihan[$c]=str_replace('<embed height','<embed height="460" tinggi',$isiLatihan[$c]);
			//$isiLatihan[$c]=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiLatihan[$c]);	
		}
		for($c=1;$c<=$jmlKB;$c++)
		{
		if($data['PARENTdetail']==$kodeKB[$c])
		{
			$judulLatihan[$c]=$data['TITLE'];
			$isiLatihan[$c]=$data['DETAIL'];
			$isiLatihan[$c]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiLatihan[$c]);
			$isiLatihan[$c]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiLatihan[$c]);
			$isiLatihan[$c]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiLatihan[$c]);
			//$isiLatihan[$c]=str_replace('<embed height','<embed height="460" tinggi',$isiLatihan[$c]);
			//$isiLatihan[$c]=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiLatihan[$c]);	
		}
		}
		{
			$jmlLat2++;
			$judulLatihans[$jmlLat2]=$data['TITLE'];
			$isiLatihans[$jmlLat2]=$data['DETAIL'];
			$isiLatihans[$jmlLat2]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiLatihans[$jmlLat2]);
			$isiLatihans[$jmlLat2]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiLatihans[$jmlLat2]);
			$isiLatihans[$jmlLat2]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',
			$isiLatihans[$jmlLat2]);
		}
		
		
		
	}
	else if((strtolower(substr(trim($data['TITLE']),0,7))=="penutup"))
	{
		$judulPenutup=$data['TITLE'];
		$kodePenutup=$data['uniqNo'];
	}
	else if((strtolower(substr(trim($data['TITLE']),0,13))=="tugas mandiri" && substr(trim($data['TITLE']),14,1)>0) 
	&& $data['PARENTdetail']=="0" )
	{
		$cek=substr(trim($data['TITLE']),14,1);
		echo 'CEK Tugas :'.$cek.'<br>';		
		$judulTugas[$cek]=$data['TITLE'];
		$isiTugas[$cek]=$data['DETAIL'];
		$isiTugas[$cek]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiTugas[$cek]);
		$isiTugas[$cek]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiTugas[$cek]);
		$isiTugas[$cek]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiTugas[$cek]);
	}
	else if((strtolower(substr(trim($data['TITLE']),0,5))=="tugas" && substr(trim($data['TITLE']),6,1)>0) 
	&& $data['PARENTdetail']=="0" )
	{
		$cek=substr(trim($data['TITLE']),6,1);
		//echo 'CEK Tugas :'.$cek.'<br>';		
		$judulTugas[$cek]=$data['TITLE'];
		$isiTugas[$cek]=$data['DETAIL'];
		$isiTugas[$cek]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiTugas[$cek]);
		$isiTugas[$cek]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiTugas[$cek]);
		$isiTugas[$cek]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiTugas[$cek]);
	}
	else if(strtolower(substr(trim($data['TITLE']),0,5))=="tugas" && $data['PARENTdetail']<>"0")
	{
		$jmlTAM2++;
		$judulTAM2[$jmlTAM2]=$data['TITLE'];
		$isiTAM2[$jmlTAM2]=$data['DETAIL'];
		$isiTAM2[$jmlTAM2]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiTAM2[$jmlTAM2]);
		$isiTAM2[$jmlTAM2]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiTAM2[$jmlTAM2]);
	}
	else if(strtolower(trim($data['TITLE']))=="tes akhir modul" || strtolower(trim($data['TITLE']))=="tam" || strtolower(trim($data['TITLE']))=="tugas akhir" ||strtolower(trim($data['TITLE']))=="tugas akhir modul")
	{
		$judulTAM=$data['TITLE'];
		$isiTAM=$data['DETAIL'];
		$isiTAM=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiTAM);
		$isiTAM=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiTAM);
		$isiTAM=str_replace('src="/file_storage/modul_online','src="file_storages',$isiTAM);
		//$isiTAM=str_replace('<embed width','<embed width="600" tinggi',$isiTAM);
		//$isiTAM=str_replace('" height','" height="400" tinggi',$isiTAM);
	}
	else if(strtolower(trim($data['TITLE']))=="tim" || strtolower(trim($data['TITLE']))=="team")
	{
		$judulTim=$data['TITLE'];
		$isiTim=$data['DETAIL'];
	}
	else if(strtolower(trim($data['TITLE']))=="referensi" || strtolower(trim($data['TITLE']))=="reference" || strtolower(trim($data['TITLE']))=="daftar pustaka")
	{
		$judulRef=$data['TITLE'];
		$isiRef=$data['DETAIL'];
	}
	else
	{
		$single++;
		for($c=1;$c<=$jmlKB;$c++)
		{
		if($data['PARENTdetail']==$kodeKB[$c])
		{
			$single--;
			$jmlSub[$c]++;
			$t=$jmlSub[$c];
			$judulSub[$c][$t]=$data['TITLE'];
			$isiSub[$c][$t]=$data['DETAIL'];
			$isiSub[$c][$t]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiSub[$c][$t]);
			$isiSub[$c][$t]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiSub[$c][$t]);
			$isiSub[$c][$t]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiSub[$c][$t]);
			//$isiSub[$c][$t]=str_replace('<embed height','<embed height="460" tinggi',$isiSub[$c][$t]);
			//$isiSub[$c][$t]=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiSub[$c][$t]);	
		}
		}		
		$judulSingleMateri[$single]=$data['TITLE'];
		$isiSingleMateri[$single]=$data['DETAIL'];
		$isiSingleMateri[$single]=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiSingleMateri[$single]);
		$isiSingleMateri[$single]=str_replace('src="/file_storage/modul_online','src="file_storages',$isiSingleMateri[$single]);
		$isiSingleMateri[$single]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isiSingleMateri[$single]);
		//$isiSingleMateri[$single]=str_replace('<embed height="475" width="625"','<embed height="475" width="627"',$isiSingleMateri[$single]);
	}
}
echo 'Sub='.$jmlSub[1];
echo '<br>Menu='.$jmlmenu;
echo '<br>Jmlh KB='.$jmlKB;
echo '<br>kode KB='.$kodeKB[1];
echo '<br>Jmlh TAM2='.$jmlTAM2;
echo '<br>Single='.$single;
echo '<br>JmlLat2='.$jmlLat2;

?>
