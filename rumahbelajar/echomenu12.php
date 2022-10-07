<?php
$jumlahbaris=0; 
$isizip3="";

if ($jmlmenu>25)
$fullgak="full2";
else if ($jmlmenu>15)
$fullgak="full";
else
$fullgak="";


for ($a=1;$a<=$level1;$a++)
{
	for ($b=0;$b<=$level2[$a];$b++)
	{
		for ($c=0;$c<=$level3[$a][$b];$c++)
		{
			if ($b==0)
			{
				if ($isimateri[$a][$b][$c]<>"")
				{
					$jumlahbaris++;
					$judulmateribaris[$jumlahbaris]=$judulmateri[$a][$b][$c];
					$isimateribaris[$jumlahbaris]=$isimateri[$a][$b][$c];
					$isizip3=$isizip3.'<p class="menuinaktif'.$fullgak.'">';
		$isizip3=$isizip3.'<a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu1x">'.$judulmateri[$a][$b][$c].'</a></p>
';
 }
				else
				{
					$jumlahbaris++;
					$judulmateribaris[$jumlahbaris]=$judulmateri[$a][$b][$c];
					$isizip3=$isizip3.'<p class="menuinaktif'.$fullgak.'">'.$judulmateri[$a][$b][$c].'</p>';
				}
			} 
			else if ($b>0 && $c==0)
			{
				if ($isimateri[$a][$b][$c]<>"")
				{
					$jumlahbaris++;
					$judulmateribaris[$jumlahbaris]=$judulmateri[$a][$b][$c];
					$isimateribaris[$jumlahbaris]=$isimateri[$a][$b][$c];
					$isizip3=$isizip3.'<p class="menuIndentation">
					<a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulmateri[$a][$b][$c].'</a></p>';
 				}
			else
				{
				$jumlahbaris++;
					$judulmateribaris[$jumlahbaris]=$judulmateri[$a][$b][$c];
					$isizip3=$isizip3.'<p class="menuIndentation">'.$judulmateri[$a][$b][$c].'</p>'.
					'<p class="menuIndentation">&nbsp;</p>';
 				}
			}
			else if ($c>0)
			{ 
			if ($isimateri[$a][$b][$c]<>"")
				{
					$jumlahbaris++;
					$judulmateribaris[$jumlahbaris]=$judulmateri[$a][$b][$c];
					$isimateribaris[$jumlahbaris]=$isimateri[$a][$b][$c];
					$isizip3=$isizip3.'<p class="menuIndentation2">
					<a href="'.$isizip3b.'konten'.$jumlahbaris.'.html" class="linkMenu2">'.$judulmateri[$a][$b][$c].'</a></p>'.
					'<p class="menuIndentation2">&nbsp;</p>';

				}
			else
				{
					$jumlahbaris++;
					$judulmateribaris[$jumlahbaris]=$judulmateri[$a][$b][$c];
					$isizip3=$isizip3.'<p class="menuIndentation2">'.$judulmateri[$a][$b][$c].
					'</p>
					 <p class="menuIndentation2">&nbsp;</p>';	
 				}
			}
		}
	}
}