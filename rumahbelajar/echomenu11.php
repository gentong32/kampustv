<?php
$jumlahbaris=0; 
$isizip3="";
if ($isiPendahuluan<>"") 
{
$jumlahbaris++;
$judulmateribaris[$jumlahbaris]=$judulPendahuluan;
$isimateribaris[$jumlahbaris]=$isiPendahuluan;
$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">'.$judulPendahuluan.'</a></p>
';
} 
 
if ($isiKompetensi<>"") 
{
$jumlahbaris++;
$judulmateribaris[$jumlahbaris]=$judulKompetensi;
$isimateribaris[$jumlahbaris]=$isiKompetensi;
$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">'.$judulKompetensi.'</a></p>
';

} 
?>

<!--  ============================== BLOK UNTUK MATERI ============================== --> 

<?php
/* 
if ($isiMateri<>"")
	echo $isiMateri;
	else
	echo $isiSingleMateri[1];
*/

if (($single>1) && ($jmlmenu>1))
{
	$isizip3=$isizip3.'<p class="menuinaktif">Materi</p>
	';
	for ($e=1;$e<=$single;$e++)
  {
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]=$judulSingleMateri[$e];
	  $isimateribaris[$jumlahbaris]=$isiSingleMateri[$e];
	  $isizip3=$isizip3.'<div id="MateriJudul1">  
  <p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2"><'.$judulSingleMateri[$e].'</a></p></div>
  <p class="menuIndentation">&nbsp;</p>';
  }
}
else
{
?>

<?php
$isizip3=$isizip3.'<p class="menuinaktif">'.$judulMateri.'</p>
';
  
  for ($e=1;$e<=$jmlMateri;$e++)
  {
  if ($jmlSub[$e]>0)
  {
	$isizip3=$isizip3.'<div id="MateriJudul1">  
  <p class="menuinaktif2">'.$judulMateris[$e].'</p></div>';
 
  for ($c=1;$c<=$jmlSub[$e];$c++)
  	{
		$jumlahbaris++;
		$judulmateribaris[$jumlahbaris]=$judulSubMateris[$e][$c];
		$isimateribaris[$jumlahbaris]=$isiSubMateris[$e][$c];
     $isizip3=$isizip3.'<div id="MateriJudul1">  
		<p class="menuIndentation2"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulSubMateris[$e][$c].'</a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  ';
  	}
  }
  else
  {
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]=$judulMateris[$e];
	  $isimateribaris[$jumlahbaris]=$isiMateris[$e];
	$isizip3=$isizip3.'<div id="MateriJudul1">  
  <p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulMateris[$e].'</a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  ';
  }
  }
}
  ?>
  <!--  ============================== ----------------------------- ============================== -->
  
  <!--  ============================== BLOK UNTUK LATIHAN ============================== --> 	
<?php 
if ($jmlLatihan==0 && $judulLatihan<>"") 
{
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]=$judulLatihan;
	$isimateribaris[$jumlahbaris]=$isiLatihan;
$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">'.$judulLatihan.'</a></p>
';
} else {
if($jmlLatihan>0)
{
$isizip3=$isizip3.'<p class="menuinaktif">'.$judulLatihan.'</p>
';
  for ($e=1;$e<=$jmlLatihan;$e++)
  {
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]=$judulLatihans[$e];
	  $isimateribaris[$jumlahbaris]=$isiLatihans[$e];
  $isizip3=$isizip3.'
  <div id="MateriJudul1">  
  <p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulLatihans[$e].'</a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  ';
  } 
}
}?>

<!--  ============================== BLOK UNTUK SIMULASI ============================== --> 	
<?php 
if ($jmlSimulasi==0 && $judulSimulasi<>"") 
{
$jumlahbaris++;
$judulmateribaris[$jumlahbaris]=$judulSimulasi;
$isimateribaris[$jumlahbaris]=$isiSimulasi;
$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">'.$judulSimulasi.'</a></p>
';
} else {
if($jmlSimulasi>0)
{
	
$isizip3=$isizip3.'<p class="menuinaktif">'.$judulSimulasi.'</p>
';
  for ($e=1;$e<=$jmlSimulasi;$e++)
  {
	  $jumlahbaris++;
	  $judulmateribaris[$jumlahbaris]=$judulSimulasis[$e];
	  $isimateribaris[$jumlahbaris]=$isiSimulasis[$e];
  $isizip3=$isizip3.'<div id="MateriJudul1">  
  <p class="menuIndentation"><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulSimulasis[$e].'</a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  ';
 }
}
}?>
   
  <!--  ============================== ----------------------------- ============================== -->   
<?php 
if ($isiTes<>"") {
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]=$judulTes;
	$isimateribaris[$jumlahbaris]=$isiTes;
$isizip3=$isizip3.'<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">'.$judulTes.'</a></p>
';
} 
if ($isiTim<>"") {
	$jumlahbaris++;
	$judulmateribaris[$jumlahbaris]=$judulTim;
	$isimateribaris[$jumlahbaris]=$isiTim;
$isizip3=$isizip3.'<hr>
<p><a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">'.$judulTim.'</a></p>
';
}

?>

