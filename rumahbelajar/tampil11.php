<?php
if($arg6=="")
{
	if($isiPendahuluan<>"")
	{ ?>
<p class="subjudul"><?php
echo $judulPendahuluan; 
?></p>
	<?php }
	else if($isiKompetensi<>"")
	{ ?>
<p class="subjudul"><?php
echo $judulKompetensi; 
?></p>
	<?php }
}
else if(substr($arg6,0,10)=="Kompetensi")
{
	echo '<p class="subjudul">'.$judulKompetensi.'</p>';
}
else if(substr($arg6,0,6)=="Materi")
{
	if ($jmlSub[substr($arg6,6,2)]>0)
	{
		echo '<p class="subjudul">'.$judulSubMateris[substr($arg6,6,2)][$arg7].'</p>';
	}
	else
	{
		if($single>1)
		echo '<p class="subjudul">'.$judulSingleMateri[substr($arg6,6,2)].'</p>';
		else
		echo '<p class="subjudul">'.$judulMateris[substr($arg6,6,2)].'</p>';
	}
}
else if(substr($arg6,0,7)=="Latihan")
{
	if ($jmlLatihan>0)
	echo '<p class="subjudul">'.$judulLatihan.' - '.$judulLatihans[substr($arg6,7,1)].'</p>';
	else
	echo '<p class="subjudul">'.$judulLatihan.'</p>';
}
else if(substr($arg6,0,8)=="Simulasi")
{
	if ($jmlSimulasi>0)
	echo '<p class="subjudul">'.$judulSimulasi.' - '.$judulSimulasis[substr($arg6,8,1)].'</p>';
	else
	echo '<p class="subjudul">'.$judulSimulasi.'</p>';
}
else if(substr($arg6,0,8)=="Tes")
{
	echo '<p class="subjudul">'.$judulTes.'</p>';
}
else if(substr($arg6,0,8)=="Tim")
{
	echo '<p class="subjudul">'.$judulTim.'</p>';
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
	if($isiPendahuluan<>"")
	{
		echo $isiPendahuluan;
	} else if($isiKompetensi<>"")
	{
		echo $isiKompetensi;
	}
} else if($arg6=="Pendahuluan")
{
	echo $isiPendahuluan;
}
else if($arg6=="Kompetensi")
{
	echo $isiKompetensi;
}
else if(substr($arg6,0,7)=="Latihan")
{
	if ($jmlLatihan==0)
	echo $isiLatihan;
	else
	echo $isiLatihans[substr($arg6,7,1)];
}
else if(substr($arg6,0,8)=="Simulasi")
{
	if ($jmlSimulasi==0)
	echo $isiSimulasi;
	else
	echo $isiSimulasis[substr($arg6,8,1)];
}
else if($arg6=="Tes")
{
	echo $isiTes;
}
else if($arg6=="Tim")
{
	echo $isiTim;
}
else
{
	if ($jmlSub[substr($arg6,6,2)]>0)
	{
		echo $isiSubMateris[substr($arg6,6,2)][$arg7];
	}
	else
	{
		if($single>1)
		echo $isiSingleMateri[substr($arg6,6,2)];
		else
		{
		echo $isiMateris[substr($arg6,6,2)];
		}
	}
}

?>
