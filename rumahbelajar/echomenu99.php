<?php
$jumlahbaris=0; 
$isizip3='
<p></p>
  <div id="MateriJudul1">
  <p class="menuIndentation"><a href="'.$isizip3b.'konten1'.'.html" class="linkMenu1x">'.$judulMateri[0].
'</a></p></div>
<p class="menuIndentation">&nbsp;</p>';

$isizip3a="";
for ($e=1;$e<=$jmlmenu;$e++)
{
	$e1=$e+1;
	$isizip3a=$isizip3a.'<div id="MateriJudul'.$e.'">
		<p class="menuIndentation"><a href="'.$isizip3b.'konten'.$e1.'.html" class="linkMenu1x">'.$judulMateri[$e].'</a></p></div>
	<p class="menuIndentation">&nbsp;</p>';
}

$jumlahbaris=$jmlmenu;
$isizip3=$isizip3.$isizip3a;

?>

