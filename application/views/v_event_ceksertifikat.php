<?php
defined('BASEPATH') OR exit('No direct script access allowed');

foreach ($sertifikat as $datane) {
	$nama = $datane->nama_sertifikat;
	$namaevent = $datane->nama_event;
	$sebagai = $datane->aktifsebagai;
}

?>
<div class="bgimg4" style="margin-top:0px;font-size: 16px;font-weight: normal">
<div class="container" style="color:black;padding-top: 70px;
padding-bottom:50px;max-width: 1000px;text-align: center">
		Sertifikat atas nama:<br>
	<span style="font-size: 18px;font-weight: bold"><?php echo $nama;?></span>
	<br><span style="font-size: 16px;font-weight: normal">
		telah berperan aktif sebagai:</span><br>
	<span style="font-size: 18px;font-weight: bold"><?php echo $sebagai;?>
		<br>
		<span style="font-size: 16px;font-weight: normal">dalam event:</span><br>
	<span style="font-size: 18px;font-weight: bold"><?php echo $namaevent;?>
		<br><br>
	<object style="margin: auto;max-width: 100%;" data="<?php
	echo base_url().'uploads/sertifikat/sert_evt_'.$kode.'.pdf';?>"
			type="application/pdf" height="300px">
	</object>
</div>
</div>
