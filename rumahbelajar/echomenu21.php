<?php
$jumlahbaris=0; 
$isizip3="";

if ($isiPendahuluan<>"") {
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Pendahuluan';
	$isimateribaris[$jumlahbaris]=$isiPendahuluan;
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">Pendahuluan</a></p>';
}

if ($isiKompetensi<>"") {
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Kompetensi';
	$isimateribaris[$jumlahbaris]=$isiKompetensi;
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">Kompetensi</a></p>';
}

$isizip3=$isizip3.'<p class="menuinaktif">Materi</p>';

for ($e=1;$e<=$jmat;$e++)
{
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]=$judulMateri[$e];
	  $isimateribaris[$jumlahbaris]=$isiMateri[$e];
	  $isizip3=$isizip3.' <div id="MateriJudul'.$e.'">  
 		<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulMateri[$e].
		'</a></p></div>
		<p class="menuIndentation">&nbsp;</p>';
}

if ($jlat==1)
{
if ($isiLatihan[1]<>"")
	{	
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Latihan';
	$isimateribaris[$jumlahbaris]=$isiLatihan[1];
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">Latihan</a></p>';
	}
}
else if ($jlat>1)
{
	$isizip3=$isizip3.'<p class="menuinaktif">Latihan</p>';
	
	for ($e=1;$e<=$jlat;$e++)
    {
		$jumlahbaris++;
		$judulmateribaris[$jumlahbaris]=$judulLatihan[$e];
		$isimateribaris[$jumlahbaris]=$isiLatihan[$e];
		$isizip3=$isizip3.'<div id="LatihanJudul'.$e.'">'.
		'<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulLatihan[$e].
		'</a></p></div>
  		<p class="menuIndentation">&nbsp;</p>';
  	}
}

if ($jsim==1)
{
if ($isiSimulasi<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Latihan';
	$isimateribaris[$jumlahbaris]=$isiLatihan[1];
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">Simulasi</a></p>';
}
}
else if ($jsim>1)
{
	
$isizip3=$isizip3.'<p class="menuinaktif">Simulasi</p>';
	
	for ($e=1;$e<=$jsim;$e++)
    {
		$jumlahbaris++;
		$judulmateribaris[$jumlahbaris]=$judulSimulasi[$e];
		$isimateribaris[$jumlahbaris]=$isiSimulasi[$e];
		$isizip3=$isizip3.'<div id="LatihanJudul'.$e.'">'.
		'<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulSimulasi[$e].
		'</a></p></div>
  		<p class="menuIndentation">&nbsp;</p>';
  	}	
}

if ($isiTes<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Tes';
	$isimateribaris[$jumlahbaris]=$isiTes;
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">Tes</a></p>';
}

if ($isiReferensi<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Referensi';
	$isimateribaris[$jumlahbaris]=$isiReferensi;
	$isizip3=$isizip3.'<hr>';
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">Referensi</a></p>';
}

if ($isiTim<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]='Tim';
	$isimateribaris[$jumlahbaris]=$isiTim;
	$isizip3=$isizip3.'<hr>';
	$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">Tim</a></p>';
}

?>    