<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$namahari = Array('', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');

if ($addedit == "add") {
	$judule = "TAMBAH";
	$namapaket = "";
	$tglpaket = "";
	$linklist = "";
} else {
	$judule = "EDIT";
	$namapaket = $datapaket->nama_paket;
	$tglpaket = substr($datapaket->jam_tayang, 0, 8);
	$linklist = $datapaket->link_list;
	$hari = $datapaket->hari;
}

?>

<script src='<?= base_url() ?>resources/tinymce/tinymce.min.js'></script>
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
						<h1>Playlist Sekolah</h1>
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
				<center>
					<div style="text-align: center; width: 300px;">
						<?php
						echo form_open('event/addplaylist/'.$kodelink.'/'.$hal);
						?>
						<div>
							<div class="well bp-component">
								<fieldset>
									<div class="form-group">
									<h3>Hari <?php echo $namahari[$hari]; ?></h3>
									</div>

									<div class="form-group">
										<h4>Jam Tayang (0-12)</h4>
										<center>
										<div class="col-md-12">
											<input maxlength="2" type="text" value="<?php
											if ($addedit == "add")
												echo "7";
											else
												echo substr($tglpaket, 0, 2); ?>" name="time" id="time"
												   class="form-control" style="width: 160px">
											<br>
										</div>
										</center>
									</div>

									<input type="hidden" id="addedit" name="addedit"
										   value="<?php
										   if ($addedit == "edit")
											   echo 'edit'; else
											   echo 'add'; ?>"/>

									<input type="hidden" id="linklist" name="linklist"
										   value="<?php echo $linklist; ?>"/>
									<input type="hidden" id="hari" name="hari" value="<?php echo $hari; ?>"/>

									<center>
									<div class="form-group">
										<div class="col-md-10 col-md-offset-0">
											<button class="btn btn-info" onclick="return takon()">Batal</button>
											<button type="submit" class="btn btn-primary"
													onclick="return cekaddvideo()">
												<?php
												if ($addedit == "edit")
													echo 'Update'; else
													echo 'Simpan' ?>
											</button>
										</div>
									</div>
									</center>
								</fieldset>
							</div>
						</div>

						<?php
						echo form_close() . '';
						?>
					</div>
				</center>
			</div>
		</div>
	</section>
</div>


<script>

	function takon() {
		window.open("<?php echo base_url().'event/playlist/'.$kodelink.'/'.$hal;?>", "_self");
		return false;
	}

</script>

<!-- jQuery library -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>

<!-- Bootstrap library -->
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
