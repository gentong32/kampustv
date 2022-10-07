<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$judul = $konten_promo['judul'];
$subjudul = $konten_promo['subjudul'];
$gambar = $konten_promo['gambar'];
$isiteks = $konten_promo['isipromo'];
$file = $konten_promo['nama_file'];
$kodepromo= $konten_promo['kd_promo'];

?>

<div class="container" style="color:black;margin-top: 60px; max-width: 800px">
      <div class="row" style="text-align:center;width:100%">
          <h2 style="color: black"><?php echo $judul;?></h2>
          <h4 style="color: black"><?php echo $subjudul;?></h4>
        <img style="text-align:center;max-width:800px;width:100%" src="<?php echo base_url(); ?>uploads/promo/<?php echo $gambar;?>">
          <br>

      </div>

      <div class="row" style="text-align:left;width:100%">
          <?php echo $isiteks;?>
      </div>

      <?php if ($file!=null && $file!="") { ?>
      <div class="row" style="text-align:center;width:100%">
          <button onclick="window.open('<?php echo base_url(); ?>promo/di_download/<?php echo $kodepromo;?>','_self')">Download Info</button>
      </div>
        <?php } ?>


  </div>
