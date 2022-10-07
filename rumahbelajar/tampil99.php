<?php

if($arg6=="")
{
	echo '<p class="subjudul">'.$judulMateri[0].'</p>';
}
else if(substr($arg6,0,6)=="Materi")
{
	echo '<p class="subjudul">'.$judulMateri[substr($arg6,6,1)].'</p>';
}
?>	

<p class="subjudul">&nbsp;</p>
<div id="isikonten">

<?php 
if($arg6=="")
{
	echo $isiMateri[0];
} else 
{
	echo $isiMateri[substr($arg6,6,1)];
}
?>