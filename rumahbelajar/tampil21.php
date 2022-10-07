<?php
if($arg6=="")
{
	echo '<p class="subjudul">Pendahuluan</p>';
} else if(substr($arg6,0,6)=="Materi")
{
	echo '<p class="subjudul">'.$judulMateri[substr($arg6,6,1)].'</p>';
} else if(substr($arg6,0,7)=="Latihan")
{
	echo '<p class="subjudul">'.$judulLatihan[substr($arg6,7,1)].'</p>';
} else if(substr($arg6,0,8)=="Simulasi")
{
	echo '<p class="subjudul">'.$judulSimulasi[substr($arg6,8,1)].'</p>';
} else
{
	echo '<p class="subjudul">'.$arg6.'</p>';
}
?>	

<div id="isikonten">

<?php 
if($arg6=="")
{
	echo $isiPendahuluan;
} else if($arg6=="Kompetensi")
{
	echo $isiKompetensi;
}
else if($arg6=="Tes")
{
	echo $isiTes;
}
else if($arg6=="Referensi")
{
	echo $isiReferensi;
}
else if($arg6=="Tim")
{
	echo $isiTim;
}
else if(substr($arg6,0,6)=="Materi")
{
	echo $isiMateri[substr($arg6,6,1)];
}
else if(substr($arg6,0,7)=="Latihan")
{
	echo $isiLatihan[substr($arg6,7,1)];
}
else if(substr($arg6,0,8)=="Simulasi")
{
	echo $isiSimulasi[substr($arg6,8,1)];
}
?>