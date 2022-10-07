<?php
$isiPendahuluan="";
$isiKompetensi="";
$kodeMateri="";
$isiLatihan="";
$kodeLatihan="";
$isiSimulasi="";
$kodeSimulasi="";
$jmlMateri=0;
$jmlSub[1]=0;
$jmlSub[2]=0;
$jmlSub[3]=0;
$jmlLatihan=0;
$jmlSimulasi=0;
$single=0;

for ($i=0;$i<$jmlmenu;$i++)
	{ 
	if(strtolower(trim(substr($rows[$i]['TITLE'],0,10)))=="kompetensi" || strtolower(trim($rows[$i]['TITLE']))=="learning objectives" || strtolower(trim($rows[$i]['TITLE']))=="competencies")
	{
		$judulKompetensi=$rows[$i]['TITLE'];
		$isiKompetensi=$rows[$i]['DETAIL'];
		$isiKompetensi=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiKompetensi);
		$isiKompetensi=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiKompetensi);
	}
	else if(strtolower(trim($rows[$i]['TITLE']))=="pendahuluan")
	{
		$judulPendahuluan=$rows[$i]['TITLE'];
		$isiPendahuluan=$rows[$i]['DETAIL'];
		$isiPendahuluan=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiPendahuluan);
		$isiPendahuluan=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiPendahuluan);
	}
	else if((strtolower(trim($rows[$i]['TITLE']))=="materi") || strtolower(trim($rows[$i]['TITLE']))=="contents" || strtolower(trim($rows[$i]['TITLE']))=="materials")
	{
		$judulMateri=$rows[$i]['TITLE'];
		$kodeMateri=$rows[$i]['uniqNo'];
		$isiMateri=$rows[$i]['DETAIL'];
		$isiMateri=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiMateri);
		$isiMateri=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiMateri);
	}
	else if(strtolower(trim($rows[$i]['TITLE']))=="latihan" || strtolower(trim($rows[$i]['TITLE']))=="exercises" || strtolower(trim($rows[$i]['TITLE']))=="exercise")
	{
		$judulLatihan=$rows[$i]['TITLE'];
		$isiLatihan=$rows[$i]['DETAIL'];
		$isiLatihan=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiLatihan);
		$isiLatihan=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiLatihan);
		$isiLatihan=str_replace('src="/edukasinet/media/Flash','src="file_storages/MP_'.$arg5.'/Flash',$isiLatihan);
		$isiLatihan=str_replace('<embed height','<embed height="460" tinggi',$isiLatihan);
		$isiLatihan=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiLatihan);
		if ($isiLatihan=="")
		{
			$kodeLatihan=$rows[$i]['uniqNo'];
		}
		else
		{
			
		}		
	}
	else if((strtolower(trim($rows[$i]['TITLE']))=="simulasi") || (strtolower(trim($rows[$i]['TITLE']))=="simulation"))
	{
		//echo ($rows[$i]['uniqNo']);
		$judulSimulasi=$rows[$i]['TITLE'];
		$isiSimulasi=$rows[$i]['DETAIL'];
		$isiSimulasi=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiSimulasi);
		$isiSimulasi=str_replace('src="/edukasinet/media/Flash','src="file_storages/MP_'.$arg5.'/Flash',$isiSimulasi);
		$isiSimulasi=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiSimulasi);
		$isiSimulasi=str_replace('<embed height','<embed height="460" tinggi',$isiSimulasi);
		$isiSimulasi=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiSimulasi);
		if ($isiSimulasi=="" || $rows[$i]['PARENTdetail']==0)
		{
			$kodeSimulasi=$rows[$i]['uniqNo'];
		}
		else
		{
			
		}		
	}
	else if(strtolower(trim($rows[$i]['TITLE']))=="tes" || strtolower(trim($rows[$i]['TITLE']))=="test")
	{
		$judulTes=$rows[$i]['TITLE'];
		$isiTes=$rows[$i]['DETAIL'];
		$isiTes=str_replace('src="/edukasinet/media/Flash','src="file_storages/MP_'.$arg5.'/Flash',$isiTes);
		$isiTes=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiTes);
		$isiTes=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiTes);
	}
	else if(strtolower(trim($rows[$i]['TITLE']))=="tim" || strtolower(trim($rows[$i]['TITLE']))=="team")
	{
		$judulTim=$rows[$i]['TITLE'];
		$isiTim=$rows[$i]['DETAIL'];
		$isiTim=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiTim);
		$isiTim=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiTim);
	}
	else
	{
		if($rows[$i]['PARENTdetail']==$kodeMateri)
		{
			$jmlMateri++;
			$judulMateris[$jmlMateri]=$rows[$i]['TITLE'];
			$kodeSubMateris[$jmlMateri]=$rows[$i]['uniqNo'];
			$isiMateris[$jmlMateri]=$rows[$i]['DETAIL'];
			$isiMateris[$jmlMateri]=str_replace('src="/edukasinet/file_storage/materi_pokok',
'src="../file_storage/materi_pokok',$isiMateris[$jmlMateri]);
			$isiMateris[$jmlMateri]=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiMateris[$jmlMateri]);
			$isiMateris[$jmlMateri]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MP_'.$arg5.'/Flash',$isiMateris[$jmlMateri]);
			//$pos1 = strpos($isiMateris[$jmlMateri],'swf');
			//$pos2 = strpos($isiMateris[$jmlMateri],'Flash');//"file_storages/MP_58/Flash/hal3.swf";
   			//$info = getimagesize($file);
    		//$width = $info[0];
    		//$height = $info[1];
			//echo $width;
			//echo $height;
			////$isiMateris[$jmlMateri]=str_replace('<embed height','<embed height="460" tinggi',$isiMateris[$jmlMateri]);
			//$isiMateris[$jmlMateri]=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiMateris[$jmlMateri]);
			//$isiMateris[$jmlMateri]=str_replace('" width=','" width="720" lebar=',$isiMateris[$jmlMateri]);
			
		} else if($rows[$i]['PARENTdetail']==$kodeLatihan || substr(strtolower(trim($rows[$i]['TITLE'])),0,7)=="latihan")
		{
			$jmlLatihan++;
			$judulLatihans[$jmlLatihan]=$rows[$i]['TITLE'];
			$isiLatihans[$jmlLatihan]=$rows[$i]['DETAIL'];
			$isiLatihans[$jmlLatihan]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiLatihans[$jmlLatihan]);
			$isiLatihans[$jmlLatihan]=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiLatihans[$jmlLatihan]);
			$isiLatihans[$jmlLatihan]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MP_'.$arg5.'/Flash',$isiLatihans[$jmlLatihan]);
			//$isiLatihans[$jmlLatihan]=str_replace('<embed height','<embed height="460" tinggi',$isiLatihans[$jmlLatihan]);
			//$isiLatihans[$jmlLatihan]=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiLatihans[$jmlLatihan]);
			//$isiLatihans[$jmlLatihan]=str_replace('" width=','" width="720" lebar=',$isiLatihans[$jmlLatihan]);
		} else if($rows[$i]['PARENTdetail']==$kodeSimulasi || substr(strtolower(trim($rows[$i]['TITLE'])),0,8)=="simulasi")
		{
			$jmlSimulasi++;
			$judulSimulasis[$jmlSimulasi]=$rows[$i]['TITLE'];
			$isiSimulasis[$jmlSimulasi]=$rows[$i]['DETAIL'];
			$isiSimulasis[$jmlSimulasi]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiSimulasis[$jmlSimulasi]);
			$isiSimulasis[$jmlSimulasi]=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiSimulasis[$jmlSimulasi]);
			$isiSimulasis[$jmlSimulasi]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MP_'.$arg5.'/Flash',$isiSimulasis[$jmlSimulasi]);
		} else
		{
			$single++;
			if(strtolower(substr($rows[$i]['TITLE'],0,8))=="simulasi" || strtolower(substr($rows[$i]['TITLE'],0,7))=="latihan")
			{
				$single--;
			}
			for($c=0;$c<$jmlMateri;$c++)
			{
				if($rows[$i]['PARENTdetail']==$kodeSubMateris[$c])
				{
					$single--;
					$jmlSub[$c]++;
					$t=$jmlSub[$c];
					$judulSubMateris[$c][$t]=$rows[$i]['TITLE'];
					$isiSubMateris[$c][$t]=$rows[$i]['DETAIL'];
					$isiSubMateris[$c][$t]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiSubMateris[$c][$t]);
					$isiSubMateris[$c][$t]=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiSubMateris[$c][$t]);
					$isiSubMateris[$c][$t]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MP_'.$arg5.'/Flash',$isiSubMateris[$c][$t]);
				}
			}
			$judulSingleMateri[$single]=$rows[$i]['TITLE'];
			$isiSingleMateri[$single]=$rows[$i]['DETAIL'];
			$isiSingleMateri[$single]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiSingleMateri[$single]);
			$isiSingleMateri[$single]=str_replace('src="/file_storage/materi_pokok','src="../file_storage/materi_pokok',$isiSingleMateri[$single]);
			$isiSingleMateri[$single]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MP_'.$arg5.'/Flash',$isiSingleMateri[$single]);
			$isiSingleMateri[$single]=str_replace('<embed height="475" width="625"','<embed height="475" width="627"',$isiSingleMateri[$single]);
		}
	}
}
//echo 'Sub='.$jmlSub[1];
//echo '<br>Menu='.$jmlmenu;
//echo '<br>Single='.$single;
//echo $jmlLatihan;
?>
