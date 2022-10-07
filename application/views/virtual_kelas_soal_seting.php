<?php
defined('BASEPATH') OR exit('No direct script access allowed');

foreach ($paket as $datane) {
	$judul = $datane->nama_paket;
	$soalkeluar = $datane->soalkeluar;
	if ($soalkeluar == 0)
		$soalkeluar = $totalsoal;
	$acaksoal = $datane->acaksoal;
	$statussoal = $datane->statussoal;
	if ($acaksoal == 0) {
		$pilacaksoal[1] = "checked";
		$pilacaksoal[2] = "";
	} else {
		$pilacaksoal[1] = "";
		$pilacaksoal[2] = "checked";
	}
	if ($statussoal == 0) {
		$pilpublish[1] = "checked";
		$pilpublish[2] = "";
	} else {
		$pilpublish[1] = "";
		$pilpublish[2] = "checked";
	}
	$acakopsi = $datane->acakopsi;
	$timer = $datane->timer;
}

if ($kodeevent=="evm")
	{
		$alamat = "/evm/".$bulan."/".$tahun;
	}
else if ($kodeevent != null)
	$alamat = "/" . $kodeevent;
else
	$alamat = "";

$attributes = array('id' => 'formseting');
echo form_open('channel/updateseting/' . $linklist . $alamat, $attributes);
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
			<div class="row">
				<div>
					<center><span style="font-size:20px;font-weight:Bold;">Seting Soal Latihan<br><?php echo $judul; ?></span>
					</center>
					<br>
					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">* Banyaknya Soal yang Tampil<br>
							<span style="margin-left: 20px;"><input type="text" name="ntampil" id="ntampil" style="text-align:center;
			width:40px;" maxlength="3" value="<?php echo $soalkeluar; ?>"> dari total <?php echo $totalsoal; ?> soal
				</span>
					</div>
					<div class="form-group">
						<br>
						<label for="inputDefault" class="col-md-12 control-label">* Urutan soal</label>
						<div style="margin-left: 30px;" class="col-md-12">
							<input <?php echo $pilacaksoal[1]; ?> type="radio" name="soalacak" id="surut" value="0">Urut
							&nbsp;&nbsp;&nbsp;
							<input <?php echo $pilacaksoal[2]; ?> type="radio" name="soalacak" id="sacak" value="1">Acak<br><br>
						</div>
					</div>
					<div class="form-group">
						<br>
						<label for="inputDefault" class="col-md-12 control-label">* Status soal</label>
						<div style="margin-left: 30px;" class="col-md-12">
							<input <?php echo $pilpublish[1]; ?> type="radio" name="statussoal" id="sdraft" value="0">Draft
							&nbsp;&nbsp;&nbsp;
							<input <?php echo $pilpublish[2]; ?> type="radio" name="statussoal" id="spublish" value="1">Publish<br><br>
						</div>
					</div>

					<div class="col-md-10 col-md-offset-0" style="margin-left:10px;margin-bottom:30px">
						<button style="display: inline;" id="tbbatal" class="btn btn-danger"
								onclick="return kembali()">Batal
						</button>
						<button style="display: inline;" id="tbupdate" type="submit" class="btn btn-primary"
								onclick="return ceksimpan()">Simpan
						</button>
					</div>
				</div>

				<?php
				echo form_close() . '';
				?>

			</div>
		</div>
	</section>
</div>

<script>

	totalsoal = <?php echo $totalsoal;?>;

	function kembali() {
		window.history.back();
		return false;
	}

	function ceksimpan() {
		if ($('#ntampil').val() > totalsoal) {
			alert("Jumlah soal yang keluar melebihi total soal yang ada!");
			return false;
		} else
			return true;
	}

</script>
