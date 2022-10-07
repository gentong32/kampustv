<?php
if($arg6=="")
{?>
	<p class="subjudul">Pendahuluan</p>
<?php } else if(substr($arg6,0,6)=="Tujuan")
{
	echo '<p class="subjudul">Tujuan</p>';
} else if(substr($arg6,0,6)=="Uraian")
{
	echo '<p class="subjudul">Uraian</p>';
} else if(substr($arg6,0,7)=="Latihan")
{
	echo '<p class="subjudul">Latihan</p>';
} else if(substr($arg6,0,14)=="RangkumanAkhir")
{
	echo '<p class="subjudul">Rangkumam Akhir</p>';
} else if(substr($arg6,0,9)=="Rangkuman")
{
	echo '<p class="subjudul">Rangkuman</p>';
}  else if(substr($arg6,0,3)=="TAM")
{
	echo '<p class="subjudul">Tugas Akhir Modul</p>';
}
else 
{
	echo '<p class="subjudul">'.$arg6.'</p>';
}
?>	

<p class="subjudul">&nbsp;</p>
<div id="isikonten">

<?php 
if($arg6=="")
{
	echo $isiPendahuluan;
} 
else if($arg6=="Kuis")
{
	echo $isiKuis;
}
else if($arg6=="Tujuan1")
{
	echo $isiTujuan[1];
}
else if($arg6=="Tujuan2")
{
	echo $isiTujuan[2];
}
else if($arg6=="Tujuan3")
{
	echo $isiTujuan[3];
}
else if($arg6=="Tujuan4")
{
	echo $isiTujuan[4];
}
else if($arg6=="Uraian1")
{
	echo $isiUraian[1];
}
else if($arg6=="Uraian2")
{
	echo $isiUraian[2];
}
else if($arg6=="Uraian3")
{
	echo $isiUraian[3];
}
else if($arg6=="Uraian4")
{
	echo $isiUraian[4];
}
else if($arg6=="Latihan1")
{
	echo $isiLatihan[1];
}
else if($arg6=="Latihan2")
{
	echo $isiLatihan[2];
}
else if($arg6=="Latihan3")
{
	echo $isiLatihan[3];
}
else if($arg6=="Latihan4")
{
	echo $isiLatihan[4];
}
else if($arg6=="Rangkuman1")
{
	echo $isiRangkuman[1];
}
else if($arg6=="Rangkuman2")
{
	echo $isiRangkuman[2];
}
else if($arg6=="Rangkuman3")
{
	echo $isiRangkuman[3];
}
else if($arg6=="Rangkuman4")
{
	echo $isiRangkuman[4];
}
else if($arg6=="TAM")
{
	echo $isiTugasAkhir;
}
else if($arg6=="Referensi")
{
	echo $isiReferensi;
}
else if($arg6=="RangkumanAkhir")
{
	echo $isiRangkumanAkhir;
}
else if($arg6=="Tim")
{
	echo $isiTim;
}
?>