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
						<h1>User</h1>
					</div>
					<div class="clearfix"></div>

				</div>
			</div>
		</div>
	</section>

	<!-- section close -->
	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row" style="color:black;font-size: 18px; font-weight:bold;text-align:center;width:100%">
				<br>
				INFORMASI VERIFIKATOR
				<br><br>
			</div>
			<div style="font-size: larger; color: black">
				<center>Selamat. Anda telah menjadi <b>Verifikator</b> dan mendapatkan gratis iuran hingga akhir
					<b><?php echo $sampai; ?></b>.
					<br> Untuk selanjutnya setiap bulan dikenakan iuran sebesar <b>Rp <?php
						echo number_format($iuran, 0, ",", "."); ?>,-</b></center>
				<br>
			</div>
		</div>
	</section>
</div>
