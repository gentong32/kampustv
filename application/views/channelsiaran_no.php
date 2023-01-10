<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>

	<!-- section begin -->
	<section id="subheader" class="text-light" data-bgimage="url(<?php echo base_url();?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>MCR SIARAN TV SEKOLAH</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section" class="pt30">
    <div class="row">
		<div style="margin-left:20px;">
		<button class="btn-main"
				onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
		</button>
		</div>
		<hr style="margin-bottom:5px;">
		<div style="background-color: transparent; font-weight: bold;font-size:16px;
				position: relative ; top: 0px; text-align:center; color:black; margin-top:0px;">
				<h3><?php
				if (isset($nama_sekolahku))
					echo "CHANNEL " . $nama_sekolahku;
				if ($url_sponsor != "")
					echo "<br>CHANNEL INI DISPONSORI OLEH " . strtoupper($sponsor);
				else if ($sponsor != "")
					echo "<br>CHANNEL INI TERSELENGGARA ATAS KERJASAMA DENGAN " . strtoupper($sponsor);
				?></h3>
		</div>

        <div class="col-md-12 col-lg-12">
			<center>
			BELUM TERSEDIA PLAYLIST UNTUK HARI INI<br>
	
			</center>
		</div>
		
    </div>

    </section>
</div>
<!-- content close -->