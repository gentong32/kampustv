<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nilaiasses1 = $hasilasses->nilaitugas1;
if ($nilaiasses1 == 1)
	$nilaiasses1 = 0;
$nilaiasses2 = $hasilasses->nilaitugas2;
$essayfile = $hasilasses->essayfile;
$uraian = $hasilasses->essaytxt;
$uraian = trim(preg_replace('/\s\s+/', ' ', $uraian));
$uraian = preg_replace('~[\r\n]+~', '', $uraian);


?>

<div class="bgimg5" style="width: 100%;margin-top: -10px;">
	<div class="container"
		 style="padding-top:20px;color:black;margin:auto;text-align:center;margin-top: 60px; max-width: 900px">
		<center><span style="font-size:17px;font-weight:Bold;">NILAI ASSESMENT 1</span></center>
		<span style="font-weight: bold; color: black;font-size: 24px;"><?php
			echo $nilaiasses1; ?></span>
		<hr style="border: #0c922e 0.5px dashed">

		<center><span style="font-size:17px;font-weight:Bold;">NILAI ASSESMENT 2</span></center>
		<span style="font-weight: bold; color: black;font-size: 24px;"><?php
			echo $nilaiasses2; ?></span>
		<hr style="border: #0c922e 0.5px dashed">

		<center><span style="font-size:17px;font-weight:Bold;">URAIAN ASSESMENT 3</span></center>
		<div style="margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:10px;
		opacity:90%;padding:20px;color: black;">
			<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

				<?php echo $uraian; ?>

			</div>
			<div style="margin-top: 20px;">
				<?php if ($essayfile == 1) { ?>
					<button style="width:150px;padding:10px 10px;margin-bottom:5px;" class="btn-primary"
							onclick="window.open('<?php echo base_url(); ?>user/download_assesment/<?php echo $hasilasses->id_user;?>','_self')">
						Unduh Lampiran
					</button>
				<?php } ?>
			</div>

		</div>

		<br>
		<div style="margin-bottom: 20px;">
			<button class="btn btn-default" onclick="return takon()">Kembali</button>
		</div>

	</div>
</div>

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script>
	function takon() {
		window.history.back();
		//window.open("/tve/user/verifikator","_self");
		return false;
	}
</script>
