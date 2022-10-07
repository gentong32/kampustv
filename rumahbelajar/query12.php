<?php
$level1=0;

for ($i=0;$i<$jmlmenu;$i++)
	{ 
	if ($rows[$i]['LVLdetail']==1)
	{
		$level1++;
		$level2[$level1]=0;
		$lv2=$level2[$level1];
		$level3[$level1][$lv2]=0;
		$kodemateri1[$level1]=$rows[$i]['uniqNo'];
		$judulmateri[$level1][0][0]=$rows[$i]['TITLE'];
		$isimateri[$level1][0][0]=$rows[$i]['DETAIL'];
		$isimateri[$level1][0][0]=str_replace('src="/edukasinet/','src="../',$isimateri[$level1][0][0]);
		$isimateri[$level1][0][0]=str_replace('src="/file_storage/','src="../file_storage/',$isimateri[$level1][0][0]);
		
		//$isimateri[$level1][0][0]=str_replace('src="/file_storage/modul_online','src="file_storages',$isimateri[$level1][0][0]);
		//$isimateri[$level1][0][0]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isimateri[$level1][0][0]);
	}
	else
	if ($rows[$i]['LVLdetail']==2)
	{
		for ($a=1;$a<=$level1;$a++)
		{
			if ($rows[$i]['PARENTdetail']==$kodemateri1[$a])
			{
				$level2[$a]++;
				$b=$level2[$a];
				$kodemateri2[$a][$b]=$rows[$i]['uniqNo'];
				$judulmateri[$a][$b][0]=$rows[$i]['TITLE'];
				$isimateri[$a][$b][0]=$rows[$i]['DETAIL'];
				$isimateri[$a][$b][0]=str_replace('src="/edukasinet/','src="../',$isimateri[$a][$b][0]);
				$isimateri[$a][$b][0]=str_replace('src="/file_storage/','src="../file_storage/',$isimateri[$a][$b][0]);
				
		//$isimateri[$a][$b][0]=str_replace('src="/file_storage/modul_online','src="file_storages',$isimateri[$a][$b][0]);
		//$isimateri[$a][$b][0]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isimateri[$a][$b][0]);
			}
		}
	}
	else
	if ($rows[$i]['LVLdetail']==3)
	{
		for ($a=1;$a<=$level1;$a++)
		{
			for ($b=1;$b<=$level2[$a];$b++)
			{	
				if ($rows[$i]['PARENTdetail']==$kodemateri2[$a][$b])
				{
					$c=$level3[$a][$b];
					$judulmateri[$a][$b][$c]=$rows[$i]['TITLE'];
					$isimateri[$a][$b][$c]=$rows[$i]['DETAIL'];
					$isimateri[$a][$b][$c]=str_replace('src="/edukasinet/','src="../',$isimateri[$a][$b][$c]);
					$isimateri[$a][$b][$c]=str_replace('src="/file_storage/','src="../file_storage/',$isimateri[$a][$b][$c]);
					$level3[$a][$b]++;
		//$isimateri[$a][$b][$c]=str_replace('src="/file_storage/modul_online','src="file_storages',$isimateri[$a][$b][$c]);
		//$isimateri[$a][$b][$c]=str_replace('src="/edukasinet/media/Flash','src="file_storages/MO_'.$arg5.'/Flash',$isimateri[$a][$b][$c]);
				}
			}
		}
	}
}

//echo 'Level 1 : '.$level1.'<br>';
//echo 'Level 2-3 : '.$level2[3].'<br>';
//echo 'Level 3-3-2 : '.$level3[3][2].'<br>';



?>
