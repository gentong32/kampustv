<?php 
$idmateri = $_GET['idmateri'];
$arg4 = $_GET['versi'];
$counter = 'counter.txt';
if ($arg4=="11")
$download = '../file_storage/materi_pokok/MP_'.$idmateri.'/zip/MP_'.$idmateri.'_files.zip';
else
if ($arg4=="12")
$download = '../file_storage/modul_online/MO_'.$idmateri.'/zip/MO_'.$idmateri.'_files.zip';
else
if ($arg4=="21")
$download = '../file_storage/materi_pokok/mapok'.$idmateri.'/zip/mapok'.$idmateri.'_files.zip';
else
if ($arg4=="22")
$download = '../file_storage/modul_online/mol'.$idmateri.'/zip/mol'.$idmateri.'_files.zip';

$diunduh = file_get_contents($counter);
$diunduh++; 
$fh = fopen($counter, 'w');
fwrite($fh, $diunduh);
fclose($fh);
header("Location: $download");   
?>