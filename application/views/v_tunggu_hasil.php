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


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">
				<div class="row" style="color:black;font-size: 18px; font-weight:bold;text-align:center;width:100%" >
					<br>
					<center>
					Calon <?php if ($this->session->userdata('siae'))
							echo "AE";
						else if ($this->session->userdata('siam'))
							echo "AM";
						else
							echo "Tutor Bimbel"; ?>
					</center>
					<br><br>
				</div>
				<div style="font-size: larger; color: black">
					<center>Anda telah menyelesaikan Assesment. Kami akan memverifikasi data dan menilai assesment
						terlebih dahulu.
						<br>Jika anda disetujui, akan muncul "<?php if ($this->session->userdata('siae'))
							echo "Menu AE";
						else if ($this->session->userdata('siam'))
							echo "Menu AM";
						else echo "Menu Bimbel"; ?>" pada Profil Saya.
						<br><br></br>Terimakasih.<br><br>
						<button class="btn-main" onclick="window.open('<?php echo base_url()."profil/profil_diri/";?>','_self')">Profil Saya</button>
					</center>
				</div>
			</div>
		</div>
	</section>
</div>
