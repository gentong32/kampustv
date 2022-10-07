<?php

$iuran = $donasi->iuran;
$rekening = $donasi->rektujuan;
$namabank = $donasi->namabank;

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
						<h1>Informasi</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<section aria-label="section" class="mt0 sm-mt-0">
		<div class="container">
			<div class="row" style="color:black;font-size: 18px; font-weight:bold;text-align:center;width:100%">
				<br><br>
				<center>Informasi Donasi</center>
				<br><br>
			</div>
			<div style="font-size: larger; color: black">
				<center>Kami sampaikan ucapan terimakasih sebelumnya.<br>
					Donasi yang Anda diberikan kepada kami, akan dimanfaatkan untuk
					mengelola dan mengembangkan fitur TV Sekolah. <br><br> Donasi ditransfer melalui <br>
					<b><?php echo strtoupper($namabank); ?></b><br> sebesar Rp <?php
					echo number_format($iuran, 0, ",", ".") .
						',- <br>ke rekening ' . $rekening; ?>. <br><br>
					<button class="btn-main" onclick="bukapetunjuk();">Petunjuk Pembayaran</button>
					<br><br>
					Setelah Anda melakukan transfer donasi, Anda dapat melihat seluruh donasi dan
					mendownload Seritifkat Donasi yang sudah anda berikan.<br>
					Daftar donasi Anda dapat dibuka melalui menu profil (klik nama anda pada menu).
				</center>
				<br>
			</div>
		</div>
	</section>
</div>

<script>
	function bukapetunjuk() {
		window.open("<?php echo $donasi->petunjuk;?>", "_blank");
	}
</script>
