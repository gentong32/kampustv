<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
						<h1>Ekstrakurikuler Majalah Dinding</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="mt0 sm-mt-0">
		<div class="container">
			<div class="row">
				<center>
					<h3>CEK SERTIFIKAT EKSTRAKURIKULER</h3>
					<br>
					Sertifikat<br>
					<span style="font-size: 18px;font-weight: bold"><?php echo $nomor; ?></span>
					<br><br>
					Atas nama:<br>
					<span style="font-size: 18px;font-weight: bold"><?php echo $nama; ?></span>
					<br><br>
					<span style="font-size: 18px;font-weight: bold"><?php echo $kegiatan; ?></span>
					<br><br>
					ditandatangan pada:<br>
					<span style="font-size: 18px;font-weight: bold"><?php echo $tanggal; ?>
					<br><br>
					</span>
				</center>
			</div>
		</div>
	</section>
</div>

