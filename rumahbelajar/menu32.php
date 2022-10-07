<?php 
if ($isiPendahuluan<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>" class="linkMenu2x">Pendahuluan</a></p>
<?php } 
if ($isiKuis<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Kuis" class="linkMenu2x">Kuis</a></p>
<?php } ?>
 <!--  ============================== BLOK UNTUK MATERI ============================== --> 	  
  <?php
  for ($e=1;$e<=$jkb;$e++)
  {
  ?>
  <p style="line-height:0px;" class="menuinaktif2">KB <?php echo $e ?> : <?php echo $judulKB[$e] ?></p>
  <div id="MateriJudul<?php echo $e?>">  
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Tujuan<?php echo $e?>" class="linkMenu2">Tujuan / Indikator</a></p>
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Uraian<?php echo $e?>" class="linkMenu2">Uraian</a></p>
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Rangkuman<?php echo $e?>" class="linkMenu2">Rangkuman</a></p>
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Latihan<?php echo $e?>" class="linkMenu2">Latihan</a></p></div>
  <?php } ?>
     
  <!--  ============================== ----------------------------- ============================== -->   
<p style="line-height:0px;"class="menuinaktif2">Penutup</p>
<?php 
if ($isiRangkumanAkhir<>"") {?>
<p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=RangkumanAkhir" class="linkMenu2">Rangkuman Akhir</a></p>
<?php } if ($isiTugasAkhir<>"") {?>
<p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=TAM" class="linkMenu2">TAM</a></p>
<?php }
if ($isiReferensi<>"") {?>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Referensi" class="linkMenu2x">Referensi</a></p>
<?php } if ($isiTim<>"") {?>
<hr>
<p><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5 ?>&mnu=Tim" class="linkMenu2x">Tim</a></p>
<?php }
?>
