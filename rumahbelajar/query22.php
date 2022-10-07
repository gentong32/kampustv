<?php
$jkb=0;
$jur=0;
$jtuj=0;
$jlat=0;
$jrkm=0;
$isiPendahuluan="";
$isiKuis="";
$judulKB[1]="";
$isiTujuan[1]="";
$isiUraian[1]="";
$isiRangkuman[1]="";
$isiLatihan[1]="";
$isiRangkumanAkhir="";
$isiTugasAkhir="";
$isiReferensi="";
$isiTim="";

for ($i=0;$i<$jmlmenu;$i++)
	{ 
	if($rows[$i]['title']=="Pendahuluan")
	{
		$isiPendahuluan=$rows[$i]['detail2'];
		$isiPendahuluan=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiPendahuluan);
		$isiPendahuluan=str_replace('"file_storages/','"../file_storage/modul_online/',$isiPendahuluan);
	} else if($rows[$i]['title']=="Kuis")
	{
		$isiKuis=$rows[$i]['detail2'];
		$isiKuis=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiKuis);
		$isiKuis=str_replace('"file_storages/','"../file_storage/modul_online/',$isiKuis);

	}  else if(substr($rows[$i]['title'],0,2)=="KB")
	{
		$jkb++;
		$judulKB[substr($rows[$i]['title'],2,1)]=strip_tags($rows[$i]['detail2']);
		$judulKB[substr($rows[$i]['title'],2,1)]=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$judulKB[substr($rows[$i]['title'],2,1)]);
		$judulKB[substr($rows[$i]['title'],2,1)]=str_replace('"file_storages/','"../file_storage/modul_online/',$judulKB[substr($rows[$i]['title'],2,1)]);
	}
	else if(substr($rows[$i]['title'],0,6)=="Tujuan")
	{
		$jtuj++;
		$isiTujuan[substr($rows[$i]['title'],6,1)]=$rows[$i]['detail2'];
		$isiTujuan[substr($rows[$i]['title'],6,1)]=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiTujuan[substr($rows[$i]['title'],6,1)]);
		$isiTujuan[substr($rows[$i]['title'],6,1)]=str_replace('"file_storages/','"../file_storage/modul_online/',$isiTujuan[substr($rows[$i]['title'],6,1)]);
	} 
	else if(substr($rows[$i]['title'],0,6)=="Uraian")
	{
		$jur++;
		$isiUraian[substr($rows[$i]['title'],6,1)]=$rows[$i]['detail2'];
		$isiUraian[substr($rows[$i]['title'],6,1)]=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiUraian[substr($rows[$i]['title'],6,1)]);
		$isiUraian[substr($rows[$i]['title'],6,1)]=str_replace('"file_storages/','"../file_storage/modul_online/',$isiUraian[substr($rows[$i]['title'],6,1)]);
	} else if(substr($rows[$i]['title'],0,7)=="Latihan")
	{
		$jlat++;
		$isiLatihan[substr($rows[$i]['title'],7,1)]=$rows[$i]['detail2'];
		$isiLatihan[substr($rows[$i]['title'],7,1)]=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiLatihan[substr($rows[$i]['title'],7,1)]);
		$isiLatihan[substr($rows[$i]['title'],7,1)]=str_replace('"file_storages/','"../file_storage/modul_online/',$isiLatihan[substr($rows[$i]['title'],7,1)]);

	} else if($rows[$i]['title']=="RangkumanAkhir")
	{
		$isiRangkumanAkhir=$rows[$i]['detail2'];
		$isiRangkumanAkhir=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiRangkumanAkhir);
		$isiRangkumanAkhir=str_replace('"file_storages/','"../file_storage/modul_online/',$isiRangkumanAkhir);
	} else if(substr($rows[$i]['title'],0,9)=="Rangkuman")
	{
		$jrkm++;
		$isiRangkuman[substr($rows[$i]['title'],9,1)]=$rows[$i]['detail2'];
		$isiRangkuman[substr($rows[$i]['title'],9,1)]=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiRangkuman[substr($rows[$i]['title'],9,1)]);
		$isiRangkuman[substr($rows[$i]['title'],9,1)]=str_replace('"file_storages/','"../file_storage/modul_online/',$isiRangkuman[substr($rows[$i]['title'],9,1)]);
	} 
	else if($rows[$i]['title']=="Referensi")
	{
		$isiReferensi=$rows[$i]['detail2'];
		$isiReferensi=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiReferensi);
	} 
	else if($rows[$i]['title']=="TAM")
	{
		$isiTugasAkhir=$rows[$i]['detail2'];
		$isiTugasAkhir=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiTugasAkhir);
		$isiTugasAkhir=str_replace('"file_storages/','"../file_storage/modul_online/',$isiTugasAkhir);
	}
	else if($rows[$i]['title']=="Tim")
	{
		$isiTim=$rows[$i]['detail2'];
		$isiTim=str_replace('src="/naskahproduksi/file_storages/','src="../file_storage/modul_online/',$isiTim);
	}
}
?>