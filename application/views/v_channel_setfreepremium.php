<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

if ($strata<7)
{
	$ambiltgl = new DateTime();
	$ambiltgl->setTimezone(new DateTimezone('Asia/Jakarta'));
	$lahir_tgl = intval($ambiltgl->format('t'));
	$lahir_bln = intval($ambiltgl->format('m'));
	$lahir_thn = $ambiltgl->format('Y');
}
else
{ 
	$tglakhir = new DateTime($tgl_berakhir);
	$lahir_tgl = intval($tglakhir->format('d'));
	$lahir_bln = intval($tglakhir->format('m'));
	$lahir_thn = intval($tglakhir->format('Y'));
}

$pilbul = array();
	for ($a = 1; $a <= 12; $a++) {
		$pilbul[$a] = "";
	}
	$pilbul[$lahir_bln] = " selected ";

$selpkt = array();
for ($a = 1; $a <= 9; $a++) {
	$selpkt[$a] = "";
}
$selpkt[$strata] = " selected ";

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
						<h1>Paket Gratis Sekolah</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<section aria-label="section" class="pt30">
		<div class="container" style="max-width: 600px;margin: auto;">

			<?php
			echo form_open('channel/updatefreepremium');
			?>

			<center><h3>PAKET GRATIS UNTUK SEKOLAH</h3></center>
			<div class="form-group">

				<div style="margin-left:auto;margin-right:auto;border: black solid 1px;padding:10px">
				<center><h4><?php echo $datasekolah->nama_sekolah;?></h4></center>
				</div>

			</div>


			<div class="form-group" id="dlamabulan">
				Berikan gratis selama (dari awal bulan ini)
				<div style="width: 130px">
					<select class="form-control" name="ilamabulan" id="ilamabulan">
						<option value="0">- pilih -</option>
						<option value="1" <?php if ($strata==0) echo ' selected';?>>1 bulan</option>
						<option value="3">3 bulan</option>
						<option value="6">6 bulan</option>
						<option value="12">12 bulan</option>
					</select>
				</div>
			</div>

			<div class="form-group" style="margin-bottom: 0px;">
				Atau gratis hingga:
				<div class="col-md-12">
					Tanggal: <input type="number" name="itanggal" id="itanggal" min="1" max="31" value="<?php
					echo $lahir_tgl;?>">
					Bulan: <select name="ibulan" id="ibulan">
						<?php
						for ($a = 1; $a <= 12; $a++) {
							echo "<option " . $pilbul[$a] . " value='" . $a . "'>" . $nmbulan[$a] . "</option>";
						}
						?>
					</select>
					Tahun: <input type="number" name="itahun" id="itahun" min="2000" value="<?php echo $lahir_thn; ?>"><br><br>
				</div>

			</div>

			

			<div class="form-group" id="dlamabulan">
				Tipe Paket
				<div style="width: 160px">
					<select class="form-control" name="istrata" id="istrata">
						<option value="0">- pilih -</option>
						<option <?php echo $selpkt[7];?> value="freelite">Free Lite</option>
						<option <?php echo $selpkt[8];?> value="freepro">Free Pro</option>
						<option <?php echo $selpkt[9];?> value="freepremium">Free Premium</option>
					</select>
				</div>
			</div>

			<input type="hidden" name="npsnuser" id="npsnuser" value="<?php echo $datasekolah->npsn;?>">
			<input type="hidden" name="iduser" id="iduser" value="<?php echo $idver;?>">
			<input type="hidden" name="strataawal" id="strataawal" value="<?php echo $strata;?>">
			<input type="hidden" name="orderid" id="orderid" value="<?php echo $order_id;?>">
			<input type="hidden" name="pilihan" id="pilihan" value="">

			<div class="form-group" style="padding-bottom: 30px;">
				<div class="col-md-10 col-md-offset-0">
					<button id="tbbatal" class="btn btn-default" onclick="return gaksido()">
						Batal
					</button>

					<button id="tbupdate" type="submit"
							class="btn btn-primary"
							onclick="return cekupdate()">Berikan
					</button>

					<?php if ($strata>=7)
					{ ?>
					<button id="tbupdate" type="submit"
							class="btn btn-primary"
							onclick="return gaksesuai()">Hapus
					</button>
					<?php } ?>
				</div>
			</div>
		</div> <!-- cd-tabs -->


		<?php
		echo form_close() . '';
		?>
	</section>
</div>


<script>

	$(document).on('change', '#ilamabulan', function () {
		var date = new Date();
		var lamabulan = $('#ilamabulan').val();
		var tahunbatas = date.getFullYear();
		var bulanbatas = date.getMonth() + 1;
		if (parseInt(lamabulan)>0)
		{
			bulanbatas = date.getMonth() + parseInt(lamabulan);
			// if (bulanbatas>11)
			// 	tahunbatas++;
		}
		var batasnya = new Date(tahunbatas, bulanbatas, 0);	
		$('#itanggal').val(batasnya.getDate());
		$('#ibulan').val(batasnya.getMonth()+1);
		$('#itahun').val(batasnya.getFullYear());
	
	});

	function cekupdate() {
		
		$('#pilihan').val(1);
		if ($('#istrata').val()==0)
			{
				alert ("Pilih paket dulu!");
				return false;
			}
		else
			return true;
		
	}

	function hapus() {
		if (confirm("Akhiri paket gratis?"))
		{
			$('#pilihan').val(2);
			return true;
		}
		else
		{
			return false;
		}
	}

	function gaksido() {
		window.history.back();
		return false;
	}

</script>
