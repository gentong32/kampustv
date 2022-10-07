  <p></p>
  <div id="MateriJudul1">
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>" class="linkMenu1x"><?php echo $judulMateri[0]?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php
  for ($e=1;$e<$jmlmenu;$e++)
  {
  ?>
  <div id="MateriJudul<?php echo $e?>">
  <p class="menuIndentation"><a href="tampilajar.php?ver=<?php echo $arg4 ?>&idmateri=<?php echo $arg5?>&mnu=Materi<?php echo $e?>" class="linkMenu1x"><?php echo $judulMateri[$e]?></a></p></div>
  <p class="menuIndentation">&nbsp;</p>
  <?php } ?>