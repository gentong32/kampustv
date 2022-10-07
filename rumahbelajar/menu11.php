<?php 

if ($isiPendahuluan<>"") 
{?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Pendahuluan&kl=<?php echo $argkls;?>" class="linkMenu1x">
<?php
echo $judulPendahuluan; 
?>
</a></p>

<?php 
} 
 
if ($isiKompetensi<>"") 
{?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Kompetensi&kl=<?php echo $argkls;?>" class="linkMenu1x">
<?php
echo $judulKompetensi; 
?>
</a></p>

<?php 
} 
?>

<!--  ============================== BLOK UNTUK MATERI ============================== --> 

<?php

if (($single>1) && ($jmlmenu>1))
{
	echo '<p class="menuinaktif">Materi</p>';
	for ($e=1;$e<=$single;$e++)
  {?>	
	 <div id="MateriJudul1">  
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Materi<?php echo $e?>&kl=<?php echo $argkls;?>" class="linkMenu2"><?php echo $judulSingleMateri[$e] ?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php
}
}
else
{
?>
<p class="menuinaktif"><?php
echo $judulMateri; 
?></p>
  <?php
  for ($e=1;$e<=$jmlMateri;$e++)
  {
  if ($jmlSub[$e]>0)
  {
	  ?>
	  <div id="MateriJudul1">  
  <p class="menuinaktif2"><?php echo $judulMateris[$e] ?></p></div>
 <?php
  for ($c=1;$c<=$jmlSub[$e];$c++)
  	{?>
     <div id="MateriJudul1">  
		<p class="menuIndentation2"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Materi<?php echo $e?>&sbmnu=<?php echo $c?>&kl=<?php echo $argkls;?>" class="linkMenu2"><?php echo $judulSubMateris[$e][$c]?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  	<?php }
  }
  else
  {
	  ?>
	  <div id="MateriJudul1">  
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Materi<?php echo $e?>&kl=<?php echo $argkls;?>" class="linkMenu2"><?php echo $judulMateris[$e] ?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php
  }
  }
}
  ?>
  <!--  ============================== ----------------------------- ============================== -->
  
  <!--  ============================== BLOK UNTUK LATIHAN ============================== --> 	
<?php 
if ($jmlLatihan==0) 
{
?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Latihan&kl=<?php echo $argkls;?>" class="linkMenu1x"><?php
echo $judulLatihan; 
?></a></p>
<?php 
} else {
if($jmlLatihan>0)
{
?>
<p class="menuinaktif"><?php
echo $judulLatihan; 
?></p>
 <?php
  for ($e=1;$e<=$jmlLatihan;$e++)
  {
  ?>
  <div id="MateriJudul1">  
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Latihan<?php echo $e?>&kl=<?php echo $argkls;?>" class="linkMenu2"><?php echo $judulLatihans[$e]?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php } 
}
}?>

<!--  ============================== BLOK UNTUK SIMULASI ============================== --> 	
<?php 
if ($jmlSimulasi==0) 
{
?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Simulasi&kl=<?php echo $argkls;?>" class="linkMenu1x"><?php
echo $judulSimulasi; 
?></a></p>
<?php 
} else {
if($jmlSimulasi>0)
{
?>
<p class="menuinaktif"><?php
echo $judulSimulasi; 
?></p>
 <?php
  for ($e=1;$e<=$jmlSimulasi;$e++)
  {
  ?>
  <div id="MateriJudul1">  
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Simulasi<?php echo $e?>&kl=<?php echo $argkls;?>" class="linkMenu2"><?php echo $judulSimulasis[$e]?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php }
}
}?>
   
  <!--  ============================== ----------------------------- ============================== -->   
<?php 
if ($isiTes<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Tes&kl=<?php echo $argkls;?>" class="linkMenu1x"><?php
echo $judulTes; 
?></a></p>
<?php }?>
<?php 
if ($isiTim<>"") {?>
<hr>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Tim&kl=<?php echo $argkls;?>" class="linkMenu1x"><?php
echo $judulTim; 
?></a></p>
<?php }?>
