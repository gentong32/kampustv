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
						<h1>Kantor Perwakilan</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<!-- section begin -->
	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="items_filter text-center">
						<p style="font-size: 16px;">Pilih provinsi untuk menemukan kantor perwakilan terdekat!</p>
						<div class="row" style="display: inline">
							<select class="form-control col-lg-3 centered" name="ipropinsi" id="ipropinsi">
								<option value="0">= Propinsi =</option>
								<?php
								foreach ($dafpropinsi as $data) { ?>
									<option
										<?php if($idprop==$data->id_propinsi)
											{
												echo "selected ";
											} ?>
										value="<?php echo $data->id_propinsi; ?>"><?php echo $data->nama_propinsi; ?></option>
									<?php
								} ?>
							</select>
							<div style="margin-top: 10px;">
								<a href="#" onclick="pilihpropinsi();" class="btn-main">Pilih
								</a>
							</div>
						</div>
					</div>
				</div>


			</div>
			<div class="row wow fadeIn">

				<?php
				$jmlagency = 0;
				foreach ($dafagency as $data) {
					$jmlagency++;
					?>

					<div class="d-item col-lg-3 mb30">
						<a class="box-url" href="#">
							<h4>Agency <?php echo $data->nama_kota;?></h4>
							<p><?php echo $data->alamat;?>
								<br>
								<i class="fa fa-phone"></i>&nbsp; <?php echo $data->hp;?></p>
						</a>
					</div>
					<?php
				} ?>

				<?php if ($jmlagency>8) { ?>
				<div class="col-md-12 text-center">
					<a href="#" id="loadmore" class="btn-main wow fadeInUp lead">Tampilkan lebih banyak</a>
				</div>
				<?php } ?>

				<?php if($jmlagency==0) { ?>
				<div class="text-center">
					Belum tersedia Wakil TVSekolah di kab/kota anda?
					<br>Ingin menjadi Agency di kab/kota Anda?
					<div class="col-md-12 text-center" style="margin-top: 10px;">
						<a href="<?php echo base_url();?>peluangkarir/agency" class="btn-main">Daftar</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>

</div>
<!-- content close -->
