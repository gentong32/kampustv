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
						<h1>REGISTRASI</h1>
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
				<div class="jumbotronbg text-center"
					 style="margin-top: 50px; background-image: url(<?php echo base_url(); ?>assets/images/pattern01.svg)">
					<?php
					$attributes = array('id' => 'myform');
					echo form_open('/login/profile', $attributes);
					?>
					<div>
						<span style="font-weight: bold;font-size: 40px">Pilihan Pendaftaran</span>
						<p>Pilih pekerjaan anda untuk melanjutkan pendaftaran</p>
						<?php
						{
//				echo "CODE:" . $this->session->userdata('linkakhir');
						}
						?>
						<br>
						<div class="row">
							<br>
							<div class="col-lg-4 col-md-4 col-sd-4" style="margin: auto;">
								<a href="#" id="aguru">
								<img style="margin:auto;max-width:200px;height: auto"
									 src="<?php echo base_url(); ?>assets/images/ikon-guru.png"
									 alt=""><br>
								<span style="font-weight: bold;font-size: 24px">Guru / Dosen</span>
								</a>
							</div>
							<div class="col-lg-4 col-md-4 col-sd-4" style="margin: auto;">
								<a href="#" id="asiswa">
								<img style="margin:auto;max-width:200px;height: auto"
																		 src="<?php echo base_url(); ?>assets/images/ikon-siswa.png"
																		 alt=""><br>
								<span style="font-weight: bold;font-size: 24px">Siswa</span>
								</a>
							</div>
							<div class="col-lg-4 col-md-4 col-sd-4" style="margin: auto;">
								<a href="#" id="aumum">
								<img style="margin:auto;max-width:200px;height: auto"
																		 src="<?php echo base_url(); ?>assets/images/ikon-staf.png"
																		 alt=""><br>
								<span style="font-weight: bold;font-size: 24px">Umum</span>
								</a>
							</div>

						</div>
					</div>
					<br><br><br><br><br>

					<input type="hidden" id="pilsebagai" name="pilsebagai"/>

					<?php
					echo form_close();
					?>

				</div>

			</div>
		</div>
	</section>
</div>

<script>
	$("#aguru").click(function () {
		$("#pilsebagai").val(1);
		$("#myform").submit();
		return false;
	});
	$("#asiswa").click(function () {
		$("#pilsebagai").val(2);
		$("#myform").submit();
		return false;
	});
	$("#aumum").click(function () {
		$("#pilsebagai").val(3);
		$("#myform").submit();
		return false;
	});
	$(".astaf").click(function () {
		$("#pilsebagai").val(4);
		$("#myform").submit();
		return false;
	});
</script>
