<?php
$jumlahbaris=0; 
$isizip3="";

if ($isiPendahuluan<>"") {
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Pendahuluan';
	$isimateribaris[$jumlahbaris]=$isiPendahuluan;
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2x">Pendahuluan</a></p>';
}

if ($isiKuis<>"") {
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Kuis';
	$isimateribaris[$jumlahbaris]=$isiKuis;
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2x">Kuis</a></p>';

}

for ($e=1;$e<=$jkb;$e++)
  {
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]=$judulKB[$e];
	  $isizip3=$isizip3.'<p class="menuinaktiffull">KB '.$e.' : '.$judulKB[$e].'</p>'.
	  '<div id="MateriJudul'.$e.'">';
	  
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]='Tujuan / Indikator';
	  $isimateribaris[$jumlahbaris]=$isiTujuan[$e];
	  $isizip3=$isizip3.'<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">Tujuan / Indikator</a></p>';
	  
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]='Uraian';
	  $isimateribaris[$jumlahbaris]=$isiUraian[$e];
	  $isizip3=$isizip3.'<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">Uraian</a></p>';
	  
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]='Rangkuman';
	  $isimateribaris[$jumlahbaris]=$isiRangkuman[$e];
	  $isizip3=$isizip3.'<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">Rangkuman</a></p>';
	  
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]='Latihan';
	  $isimateribaris[$jumlahbaris]=$isiLatihan[$e];
	  $isizip3=$isizip3.'<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">Latihan</a></p></div>';
}

$jumlahbaris++;
$judulmateribaris[$jumlahbaris]='Penutup';
$isizip3=$isizip3.'<p class="menuinaktiffull">Penutup</p>';
	  
if ($isiRangkumanAkhir<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Rangkuman Akhir';
	$isimateribaris[$jumlahbaris]=$isiRangkumanAkhir;
	$isizip3=$isizip3.'<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">Rangkuman Akhir</a></p>';
}

if ($isiTugasAkhir<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Tugas Akhir Modul';
	$isimateribaris[$jumlahbaris]=$isiTugasAkhir;
	$isizip3=$isizip3.'<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">Tugas Akhir Modul</a></p>';
}

if ($isiReferensi<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Referensi';
	$isimateribaris[$jumlahbaris]=$isiReferensi;
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2x">Referensi</a></p>';
}

if ($isiTim<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Tim';
	$isimateribaris[$jumlahbaris]=$isiTim;
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2x">Tim</a></p>';
}

?>    