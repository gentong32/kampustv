<?php 

if ($isiPendahuluan<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&kl=<?php echo $argkls;?>" class="linkMenu1x">Pendahuluan</a></p>
<?php } 
if ($isiKompetensi<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Kompetensi&kl=<?php echo $argkls;?>" class="linkMenu1x">Kompetensi</a></p>
<?php } ?>
 <!--  ============================== BLOK UNTUK MATERI ============================== --> 	
  <p class="menuinaktif">Materi</p>
  
  <?php
  for ($e=1;$e<=$jmat;$e++)
  {
  ?>
  <div id="MateriJudul<?php echo $e?>">  
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Materi<?php echo $e?>&kl=<?php echo $argkls;?>" class="linkMenu2"><?php echo $judulMateri[$e]?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php } ?>
  <!--  ============================== ----------------------------- ============================== -->
  
  <!--  ============================== BLOK UNTUK LATIHAN ============================== --> 	
<?php 
if ($jlat==1)
{
if ($isiLatihan<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Latihan1&kl=<?php echo $argkls;?>" class="linkMenu1x">Latihan</a></p>
<?php }
}
else if ($jlat>1)
{?>
<p class="menuinaktif">Latihan</p>
  
  <?php
  for ($e=1;$e<=$jlat;$e++)
  {
  ?>
  <div id="LatihanJudul<?php echo $e?>">  
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Latihan<?php echo $e?>&kl=<?php echo $argkls;?>" class="linkMenu2"><?php echo $judulLatihan[$e]?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php }
}?>
   
  <!--  ============================== ----------------------------- ============================== -->  
    
  <!--  ============================== BLOK UNTUK SIMULASI ============================== --> 	
<?php 
if ($jsim==1)
{
if ($isiSimulasi<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Simulasi1&kl=<?php echo $argkls;?>" class="linkMenu1x">Simulasi</a></p>
<?php }
}
else if ($jsim>1)
{?>
<p class="menuinaktif">Simulasi</p>
  
  <?php
  for ($e=1;$e<=$jsim;$e++)
  {
  ?>
  <div id="SimulasiJudul<?php echo $e?>">  
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Simulasi<?php echo $e?>&kl=<?php echo $argkls;?>" class="linkMenu2"><?php echo $judulSimulasi[$e]?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php }
}?>
   
  <!--  ============================== ----------------------------- ============================== -->   
<?php 
if ($isiTes<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Tes&kl=<?php echo $argkls;?>" class="linkMenu1x">Tes</a></p>
<?php }
if ($isiReferensi<>"") {?>
<hr>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Referensi&kl=<?php echo $argkls;?>" class="linkMenu1x">Referensi</a></p>
<?php }
if ($isiTim<>"") {?>
<hr>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Tim&kl=<?php echo $argkls;?>" class="linkMenu1x">Tim</a></p>
<?php }?>
