<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

$ambiltgl = new DateTime();
$ambiltgl->setTimezone(new DateTimezone('Asia/Jakarta'));
$lahir_tgl = intval($ambiltgl->format('d'));
$lahir_bln = intval($ambiltgl->format('m'));
$lahir_thn = $ambiltgl->format('Y');

$pilbul = array();
for ($a = 1; $a <= 12; $a++) {
	$pilbul[$a] = "";
}
$pilbul[$lahir_bln] = " selected ";

foreach ($transaksi as $datane) {
	$kode = $datane->kode;
	$iduser = $datane->id_user;
	$npsnuser = $datane->npsn;
	$foto = $datane->filebukti;
	$konfirmasi = $datane->konfirmasi;
	$filefoto = base_url() . "uploads/siplah/" . $foto;
	$lamabulan = $datane->lamabulan;
	$strata = $datane->strata;
	$iuran = $datane->iuran;
}

$selbul = array();
for ($a = 1; $a <= 12; $a++) {
	$selbul[$a] = "";
}
$selbul[$lamabulan] = " selected ";

$selpkt = array();
for ($a = 1; $a <= 3; $a++) {
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
						<h1>Konfirmasi Siplah</h1>
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
			echo form_open('finance/updatekonfirmasi');
			?>

			<center><h3>BUKTI SURAT PEMESANAN SIPLAH</h3></center>
			<div class="form-group">

				<div style="margin-left:auto;margin-right:auto;border: black solid 1px;padding:10px">

					<img id="previewing" width="100%" height="auto" src="<?php echo $filefoto.'?'.time(); ?>">

				</div>

			</div>


			<div class="form-group" style="margin-bottom: 0px;">
				Pemesanan:
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
					Tahun: <input type="number" name="itahun" id="itahun" min="2000" max="<?php
					echo(date("Y"));
					?>" value="<?php echo $lahir_thn; ?>"><br><br>
				</div>

			</div>

			<div class="form-group" id="dlamabulan">
				Untuk jangka waktu:
				<div style="width: 130px">
					<select class="form-control" name="ilamabulan" id="ilamabulan">
						<option <?php echo $selbul[1];?> value="1">1 bulan</option>
						<option <?php echo $selbul[3];?> value="3">3 bulan</option>
						<option <?php echo $selbul[6];?> value="6">6 bulan</option>
						<option <?php echo $selbul[12];?> value="12">12 bulan</option>
					</select>
				</div>
			</div>

			<div class="form-group" id="dlamabulan">
				Tipe Paket
				<div style="width: 130px">
					<select class="form-control" name="istrata" id="istrata">
						<option <?php echo $selpkt[1];?> value="1">Lite</option>
						<option <?php echo $selpkt[2];?> value="2">Pro</option>
						<option <?php echo $selpkt[3];?> value="3">Premium</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				Seharga
				<span style="color: red" id="firstnameHasil"></span></label>
				<div>
					<input type="text" name="isejumlah" id="isejumlah"
						   pattern="^\$\d{1,3}(.\d{3})*(\,\d+)?$" data-type="currency"
						   placeholder="Rp 0,-" value="Rp <?php echo number_format($iuran,0,',','.');?>,-">
				</div>
			</div>

			<input type="hidden" name="iduser" id="iduser" value="<?php echo $iduser;?>">
			<input type="hidden" name="npsnuser" id="npsnuser" value="<?php echo $npsnuser;?>">
			<input type="hidden" name="kodesiplah" id="kodesiplah" value="<?php echo $kode;?>">
			<input type="hidden" name="konfirmasi" id="konfirmasi" value="<?php echo $konfirmasi;?>">
			<input type="hidden" name="pilihankonfirm" id="pilihankonfirm" value="">


			<div class="form-group" style="padding-bottom: 30px;">
				<div class="col-md-10 col-md-offset-0">
					<button id="tbbatal" class="btn btn-default" onclick="return gaksido()">
						Batal
					</button>

					<?php if($konfirmasi>=1 && $konfirmasi<=3)
					{?>

					<button id="tbupdate" type="submit"
							class="btn btn-primary"
							onclick="return cekupdate()">Bukti Valid
					</button>

					<button id="tbupdate" type="submit"
							class="btn btn-primary"
							onclick="return gaksesuai()">Bukti Tidak Valid
					</button>

					<?php } else if($konfirmasi==4) { ?>

					<button id="tbupdate" type="submit"
							class="btn btn-primary"
							onclick="return cekupdate2()">Pembayaran Sudah Masuk
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
	$("input[data-type='currency']").on({
		keyup: function() {
			formatCurrency($(this));
		},
		blur: function() {
			formatCurrency($(this), "blur");
		}
	});


	function formatNumber(n) {
		// format number 1000000 to 1,234,567
		return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
	}


	function formatCurrency(input, blur) {
		// appends $ to value, validates decimal side
		// and puts cursor back in right position.

		// get input value
		var input_val = input.val();

		// don't validate empty input
		if (input_val === "") { return; }

		// original length
		var original_len = input_val.length;

		// initial caret position
		var caret_pos = input.prop("selectionStart");

		// check for decimal
		if (input_val.indexOf(",") >= 0) {

			// get position of first decimal
			// this prevents multiple decimals from
			// being entered
			var decimal_pos = input_val.indexOf(",");

			// split number by decimal point
			var left_side = input_val.substring(0, decimal_pos);
			var right_side = input_val.substring(decimal_pos);

			// add commas to left side of number
			left_side = formatNumber(left_side);

			// validate right side
			right_side = formatNumber(right_side);

			// On blur make sure 2 numbers after decimal
			if (blur === "blur") {
				right_side += ",-";
			}

			// Limit decimal to only 2 digits
			right_side = right_side.substring(0, 2);

			// join number by .
			input_val = "Rp " + left_side + right_side;

		} else {
			// no decimal entered
			// add commas to number
			// remove all non-digits
			input_val = formatNumber(input_val);
			input_val = "Rp " + input_val;

			// final formatting
			if (blur === "blur") {
				input_val += ",-";
			}
		}

		// send updated string to input
		input.val(input_val);

		// put caret back in the right position
		var updated_len = input_val.length;
		caret_pos = updated_len - original_len + caret_pos;
		input[0].setSelectionRange(caret_pos, caret_pos);
	}

	function cekupdate() {
		if (confirm("Apakah yakin sudah sesuai dengan bukti?"))
		{
			if ($('#isejumlah').val()!="")
				{
					$('#pilihankonfirm').val("1");
					return true;
				}
			else
				{
					alert ("Jumlah pembayaran belum diisi");
					return false;
				}
		}
		else
		{
			return false;
		}
	}

	function cekupdate2() {
		if (confirm("Apakah yakin pembayaran sudah masuk?"))
		{
			$('#pilihankonfirm').val("1");
			return true;
		}
		else
		{
			return false;
		}
	}

	function gaksesuai() {
		if (confirm("Bukti tidak valid?"))
		{
			$('#pilihankonfirm').val("2");
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
