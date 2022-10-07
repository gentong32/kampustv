if($data['TITLE']=="Pendahuluan" || $data['TITLE']=="Pengantar")
	{
		$isiPendahuluan=$data['DETAIL'];
		$isiPendahuluan=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiPendahuluan);
		$isiPendahuluan=str_replace('src="/file_storage/materi_pokok','src="file_storages',$isiPendahuluan);
		$isiPendahuluan=str_replace('src="/file_storage/modul_online','src="file_storages',$isiPendahuluan);
	} else if($data['TITLE']=="Kuis")
	{
		$isiKuis=$data['DETAIL'];
		$isiKuis=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiKuis);
		$isiKuis=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiKuis);
		$isiKuis=str_replace('src="/file_storage/materi_pokok','src="file_storages',$isiKuis);
		//$isiKuis=str_replace('src="/file_storage/modul_online','src="file_storages',$isiKuis);
		$isiKuis=str_replace('<embed height','<embed height="460" tinggi',$isiKuis);
		$isiKuis=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiKuis);
	} else if(trim($data['TITLE'])=="Kompetensi")
	{	
	    $tes123=$data['TITLE'];
		$isiKompetensi=$data['DETAIL'];
		$isiKompetensi=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiKompetensi);
		$isiKompetensi=str_replace('src="/file_storage/materi_pokok','src="file_storages',$isiKompetensi);
	} else if(substr($data['TITLE'],0,13)=="Kunci Jawaban")
	{
		
		//$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
	} else if(substr($data['TITLE'],0,16)=="Kegiatan Belajar")
	{
		$jumlahkb++;
		$kodeKB[substr($data['TITLE'],17,1)]=$data['uniqNo'];
		$judulKB[substr($data['TITLE'],17,1)]=$data['TITLE'];
		//$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
	} else if($data['TITLE']=="Latihan")
	{
		if($data['LVLdetail']==2)
		{
			$jumlahLat++;
			$kodeLat[$jumlahLat]=$data['PARENTdetail'];
			$isiLat[$jumlahLat]=$data['DETAIL'];
		}
		else
		{
		$isiLatihan=$data['DETAIL'];
		$isiLatihan=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiLatihan);
		$isiLatihan=str_replace('src="/file_storage/materi_pokok','src="file_storages',$isiLatihan);
		$isiLatihan=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiLatihan);
		$isiLatihan=str_replace('<embed height','<embed height="460" tinggi',$isiLatihan);
		$isiLatihan=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiLatihan);
		}
	} else if($data['TITLE']=="Simulasi")
	{
		$isiSimulasi=$data['DETAIL'];
		$isiSimulasi=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiSimulasi);
		$isiSimulasi=str_replace('src="/file_storage/materi_pokok','src="file_storages',$isiSimulasi);
		$isiSimulasi=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiSimulasi);
		$isiSimulasi=str_replace('<embed height','<embed height="460" tinggi',$isiSimulasi);
		$isiSimulasi=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiSimulasi);
	} else if(($data['TITLE']=="Tes") || ($data['TITLE']=="Tes Modul") || ($data['TITLE']=="Tes Akhir Modul") || 
	($data['TITLE']=="Tugas Akhir Modul"))
	{
		$isiTes=$data['DETAIL'];
		$isiTes=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiTes);
		$isiTes=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiTes);
		$isiTes=str_replace('<embed height','<embed height="460" tinggi',$isiTes);
		$isiTes=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiTes);
	} 
	  else if($data['TITLE']=="Identifikasi")
	{
	} else if(substr($data['TITLE'],0,8)=="Tujuan /")
	{
		$jumlahTuj++;
		$kodeTujuan[$jumlahTuj]=$data['PARENTdetail'];
		$isiTujuan[$jumlahTuj]=$data['DETAIL'];
		//str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiTim);
	} else if(substr($data['TITLE'],0,6)=="Uraian")
	{
		$jumlahUr++;
		$kodeUraian[$jumlahUr]=$data['PARENTdetail'];
		$isiUraian[$jumlahUr]=$data['DETAIL'];
		//str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiTim);
	} else if($data['TITLE']=="Tim")
	{
		$isiTim=$data['DETAIL'];
		$isiTim=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiTim);
	} else if($data['TITLE']=="Rangkuman")
	{
		if($data['LVLdetail']==2)
		{
			$jumlahRkm++;
			$kodeRkm[$jumlahRkm]=$data['PARENTdetail'];
			$isiRkm[$jumlahRkm]=$data['DETAIL'];
		}
		else
		{
			$isiRangkum=$data['DETAIL'];
			$isiRangkum=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiRangkum);
		}
	} else if($data['TITLE']=="Materi")
	{
		$isiMat=$data['DETAIL'];
		$isiMat=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMat);
	} else if($data['TITLE']=="Penutup")
	{
		$jumlahPenutup++;
		$kodePenutup[$jumlahPenutup]=$data['uniqNo'];
	} else if(($data['TITLE']=="Daftar Pustaka") || ($data['TITLE']=="Referensi"))
	{
		$isiReferensi=$data['DETAIL'];
		//$isiMat=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMat);
	} else
	{
		$w++;
		$judulMateri[$w]=$data['TITLE'];
		$isiMateri[$w]=$data['DETAIL'];
		$isiMateri[$w]=str_replace('src="/edukasinet/file_storage/materi_pokok','src="file_storages',$isiMateri[$w]);
		$isiMateri=str_replace('src="/file_storage/materi_pokok','src="file_storages',$isiMateri);
		$isiMateri=str_replace('src="/edukasinet/file_storage/modul_online','src="file_storages',$isiMateri);
		$isiMateri=str_replace('<embed height','<embed height="460" tinggi',$isiMateri);
		$isiMateri=str_replace('type="application/x-shockwave-flash" width','type="application/x-shockwave-flash" width="720" tinggi',$isiMateri);
	}