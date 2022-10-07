<?php
if($arg6=="" || $arg6=="Pendahuluan")
{
	if($isiPendahuluan<>"")
	{ ?>
<p class="subjudul"><?php
echo $judulPendahuluan; 
?></p>
	<?php }
}
else if(substr($arg6,0,4)=="Kuis")
{
	echo '<p class="subjudul">'.$judulKuis[substr($arg6,4,1)].'</p>';
}
else if(substr($arg6,0,6)=="Tujuan")
{
	echo '<p class="subjudul">'.$judulTujuan[substr($arg6,6,1)].'</p>';
}
else if(substr($arg6,0,6)=="Uraian")
{
	if($arg7=="")
	{
		echo '<p class="subjudul">'.$judulUraian[substr($arg6,6,1)].'</p>';
	}
	else
	{
		if ($judulSub[substr($arg6,6,1)][$arg7]=="")
		echo '<p class="subjudul">Uraian '.substr($arg6,6,1).'</p>';
		else
		echo '<p class="subjudul">'.$judulSub[substr($arg6,6,1)][$arg7].'</p>';
	}
}
else if($arg6=="RangkumanAkhir")
{
	echo '<p class="subjudul">'.$judulRkmAkhir.'</p>';
}
else if(substr($arg6,0,9)=="Rangkuman")
{
	echo '<p class="subjudul">'.$judulRkm[substr($arg6,9,1)].'</p>';
}
else if($arg6=="Lat0")
{
	echo '<p class="subjudul">'.$judulLatihan[0].'</p>';
}
else if(substr($arg6,0,7)=="Latihan")
{
	echo '<p class="subjudul">'.$judulLatihan[substr($arg6,7,1)].'</p>';
}
else if(substr($arg6,0,2)=="KB")
{
	if ($jmlSub[1]==0 || $judulSingleMateri[substr($arg6,2,1)]<>"")
	echo '<p class="subjudul">'.$judulSingleMateri[substr($arg6,2,1)].'</p>';
	else
	echo '<p class="subjudul">'.$judulSub[1][$arg7].'</p>';
}
else if(substr($arg6,0,3)=="TAM")
{
	if ($jmlTAM2==0)
	echo '<p class="subjudul">'.$judulTAM.'</p>';
	else
	{
		echo '<p class="subjudul">'.$judulTAM2[substr($arg6,3,1)].'</p>';
	}
}
else if($arg6=="Tim")
{
	echo '<p class="subjudul">'.$judulTim.'</p>';
}
else if(substr($arg6,0,5)=="Tugas")
{
	echo '<p class="subjudul">'.$judulTugas[substr($arg6,5,1)].'</p>';
}
?>	

<p class="subjudul">&nbsp;</p>
<div id="isikonten">

<?php
if($arg6=="" || $arg6=="Pendahuluan")
{
	if($isiPendahuluan<>"")
	{ ?>
<?php
echo $isiPendahuluan; 
?>
	<?php }
}
else if(substr($arg6,0,4)=="Kuis")
{
	echo $isiKuis[substr($arg6,4,1)];
}
else if(substr($arg6,0,6)=="Tujuan")
{
	echo $isiTujuan[substr($arg6,6,1)];
}
else if(substr($arg6,0,6)=="Uraian")
{
	if($arg7=="")
	{
		echo $isiUraian[substr($arg6,6,1)];
	}
	else
	{
		if ($isiSub[substr($arg6,6,1)][$arg7]=="")
		echo $isiKB[substr($arg6,6,1)];
		else
		echo '<p class="subjudul">'.$isiSub[substr($arg6,6,1)][$arg7].'</p>';
	}
}
else if($arg6=="RangkumanAkhir")
{
	echo $isiRkmAkhir;
}
else if(substr($arg6,0,9)=="Rangkuman")
{
	echo $isiRkm[substr($arg6,9,1)];
}
else if($arg6=="Lat0")
{
	echo $isiLatihan[0];
}
else if(substr($arg6,0,7)=="Latihan")
{
	echo $isiLatihan[substr($arg6,7,1)];
}
else if(substr($arg6,0,2)=="KB")
{
	if ($jmlSub[1]==0 || $judulSingleMateri[substr($arg6,2,1)]<>"")
	echo $isiSingleMateri[substr($arg6,2,1)];
	else
	echo $isiSub[1][$arg7];
}
else if(substr($arg6,0,5)=="Tugas")
{
	echo '<p class="subjudul">'.$isiTugas[substr($arg6,5,1)].'</p>';
}
else if(substr($arg6,0,3)=="TAM")
{
	if ($jmlTAM2==0)
	echo $isiTAM;
	else
	{
		echo $isiTAM2[substr($arg6,3,1)];
	}
}
else if($arg6=="Tim")
{
	echo $isiTim;
}
else if($arg6=="Ref")
{
	echo $isiRef;
}
?>
