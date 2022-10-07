<?php

if ($jmlmenu>25)
$fullgak="full2";
else if ($jmlmenu>15)
$fullgak="full";
else
$fullgak="";


for ($a=0;$a<=$level1;$a++)
{
	for ($b=0;$b<=$level2[$a];$b++)
	{
		for ($c=0;$c<=$level3[$a][$b];$c++)
		{
			if ($b==0)
			{
				if ($isimateri[$a][$b][$c]<>"")
				{
				?>        	
			<p class="menuinaktif<?php echo $fullgak?>"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&lvl1=<?php echo $a ?>&lvl2=<?php echo $b ?>&lvl3=<?php echo $c ?>&kl=<?php echo $argkls;?>" class="linkMenu1x<?php echo $fullgak?>">
			<?php echo $judulmateri[$a][$b][$c] ?>
			</a></p>  
			   	
			<?php }
				else
				{
				?>        	
			<p class="menuinaktif<?php echo $fullgak?>">
			<?php echo $judulmateri[$a][$b][$c] ?>
			</p> 
			    	
			<?php }
			} 
			else if ($b>0 && $c==0)
			{
				if ($isimateri[$a][$b][$c]<>"")
				{
					?> 
               	
			<p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&lvl1=<?php echo $a ?>&lvl2=<?php echo $b ?>&lvl3=<?php echo $c ?>&kl=<?php echo $argkls;?>" class="linkMenu2">
			<?php echo $judulmateri[$a][$b][$c] ?>
			</a></p>
			
		<?php }
			else
			{
					?>                    	
			<p class="menuIndentation">
			<?php echo $judulmateri[$a][$b][$c] ?>
			</p>
			<p class="menuIndentation">&nbsp;</p>
		<?php }
			}else if ($c>0)
			{ 
			if ($isimateri[$a][$b][$c]<>"")
				{?>    
                	
			<p class="menuIndentation2"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&lvl1=<?php echo $a ?>&lvl2=<?php echo $b ?>&lvl3=<?php echo $c ?>&kl=<?php echo $argkls;?>" class="linkMenu2">
			<?php echo $judulmateri[$a][$b][$c] ?>
			</a></p>
			<p class="menuIndentation2">&nbsp;</p>
		<?php }
		else
		{?>    
                	
			<p class="menuIndentation2">
			<?php echo $judulmateri[$a][$b][$c] ?>
			</p>
			<p class="menuIndentation2">&nbsp;</p>
		<?php }
			}
		}
	}
}