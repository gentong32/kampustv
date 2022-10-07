<?php

$dicekb1="";
$dicekb2="";

if ($tipeuser==2)
$dicekb2="checked";
else
$dicekb1="checked";
?>

<div class="radio2">
<form action="#" method="post" class="demoForm2" id="transForm2" onclick="cek1()">
    <input id="siswa" type="radio" name="usernya" value="1" <?php echo $dicekb1;?>>
    <label for="siswa">Siswa</label>
    <input id="guru" type="radio" name="usernya" value="2" <?php echo $dicekb2;?>>
    <label for="guru">Guru</label>
</form>
</div>
