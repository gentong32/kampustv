<?php
if($arglv1=="")
{?>
<p class="subjudul"><?php
echo $judulmateri[1][0][0]; 
?></p>
<?php
}
else 
{
	echo '<p class="subjudul">'.$judulmateri[$arglv1][$arglv2][$arglv3].'</p>';
}
?>	

<p class="subjudul">&nbsp;</p>
<div id="isikonten">

<?php
if($arglv1=="")
{?>
<?php
echo $isimateri[1][0][0]; 
?>
<?php
}
else 
{
	echo $isimateri[$arglv1][$arglv2][$arglv3];
}
?>
