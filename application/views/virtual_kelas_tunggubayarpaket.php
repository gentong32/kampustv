<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$namabulan = array("", "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>
	<!-- section begin -->
	<section id="subheader" class="text-light"
			 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Kelas Virtual</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row" style="margin-bottom: 30px;">
				<center>
					<h3>MENUNGGU PEMBAYARAN <?php
						if(substr($order_id,0,5)=="ECR33")
							echo "ECERAN PREMIUM";
						else if(substr($order_id,0,5)=="ECR34")
							echo "ECERAN PRIVAT";
						?> KELAS VIRTUAL</h3>
				</center>
			</div>
			<div style="width: 90%;max-width:500px; height: auto;border: 3px solid black;border-radius: 10px;padding:10px;
        font-size: larger;color:black;text-align:center;margin-left: auto;margin-right: auto">

				Order ID : <?php echo $order_id; ?>
				<hr style="margin-top:5px;margin-bottom:5px;border-color: green">
				<?php if ($namabank == "gopay") { ?>
					Jika anda berhasil melakukan pembayaran menggunakan GOPAY sebesar <span
						style="font-weight: bold">Rp <?php echo number_format($iuran, 0, ",", "."); ?>,-</span>
					silakan klik "Saya sudah bayar", jika tidak silakan ulangi atau ganti cara pembayaran!
					<br><br>
					<button class="myButtonred" onclick="return gantibayar()"><span
							style="font-weight: bold">Ganti Cara Pembayaran</span></button>
					<button class="myButtonblue" onclick="window.location.reload()"><span style="font-weight: bold">Saya sudah bayar</span>
					</button>
				<?php } else { ?>
				Segera lakukan pembayaran sebesar <span
					style="font-weight: bold">Rp <?php echo number_format($iuran, 0, ",", "."); ?>,-</span> sebelum:<br>
				Tanggal <?php echo $tgl_order->format('d') . " " . $namabulan[intval($tgl_order->format('m'))] . " " .
					$tgl_order->format('Y'); ?> pukul <?php echo $tgl_order->format('H:i:s'); ?>
				<br>
				<br>
				<span style="color:red;font-size: smaller;">Sisa waktu pembayaran:</span><br>
				<div class="de_countdown" style="border-color:red;border-radius:10px;right: auto;position: relative;width: auto;max-width: 130px;margin: auto"
					 data-year="<?php echo substr($stgl_order, 0, 4); ?>"
					 data-month="<?php echo substr($stgl_order, 5, 2); ?>"
					 data-day="<?php echo substr($stgl_order, 8, 2); ?>"
					 data-hour="<?php echo substr($stgl_order, 11, 2); ?>"
					 data-minute="<?php echo substr($stgl_order, 14, 2); ?>"
					 data-second="<?php echo substr($stgl_order, 17, 2); ?>"></div>

				<br>Pembayaran melalui:<br>
				<span style="font-weight: bold"><?php echo strtoupper($namabank); ?></span>
				<br>
				No. Rek<br>
				<span style="font-weight: bold"><?php echo $rektujuan; ?></span>
				<br>
				<button class="myButtongreen" onclick="window.open('<?php echo $petunjuk; ?>','_blank')"><span
						style="font-weight: bold">Petunjuk Bayar</span>
				</button>
				<br><br>
				<?php if (strtoupper($namabank) == "GOPAY") { ?>
				<button class="myButtonred" onclick="return gantibayar()"><span style="font-weight: bold">Ganti Cara Pembayaran</span>
					<?php } ?>
					<br>
					<button class="myButtonred" onclick="return gantibayar()"><span
							style="font-weight: bold">Ganti Cara Pembayaran</span></button>
					<button class="myButtonblue" onclick="window.location.reload()"><span style="font-weight: bold">Saya sudah bayar</span>
					</button>
					<?php } ?>
			</div>
		</div>
	</section>
</div>

<script>

	function gantibayar() {
		if (confirm("Yakin mengubah cara bayar?")) {
			window.open("<?php echo base_url() . 'payment/ganticarabayar/' . $order_id;?>", "_self");
			return false;
		}
	}

</script>
