<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_fakultas = 0;
foreach ($daffakultas as $datane) {
	$jml_fakultas++;
	$sel_fakultas[$jml_fakultas] = "";
	$id_fakultas[$jml_fakultas] = $datane->id;
	$nama_fakultas[$jml_fakultas] = $datane->nama_fakultas;
}

$sel_fakultas[1] = "";
$disp[1] = "";
$disp2[1] = "style='display:none';";
$disp[2] = "";
$sel_ki1[3] = "";
$sel_ki1[4] = "";

$judul = "";
$topik = "";
$deskripsi = "";
$keyword = "";
$link_video = "";

?>

<div style="margin-top: 60px;"; >
	<center><span style="color: black;font-size:20px;font-weight:Bold;"><?php echo $title; ?></span></center>

	<div class="row">
		<?php
		echo form_open('');
		?>
		<div class="col-md-5 col-md-offset-1">
			<div class="well bp-component" style="background-color: #FFFFFF;color: black">
				<fieldset>
					<legend style="color: black">Fakultas</legend>
					<div id="grupins" <?php echo $disp[1]; ?>>
						<div class="form-group" id="djenjang"><br>
							<label for="select" class="col-md-12 control-label">Fakultas</label>
							<div class="col-md-12">
								<select class="form-control" style="color: black" name="ifakultas" id="ifakultas">
									<option value="0">--Pilih Fakultas--</option>
									<?php
									for ($b1 = 1; $b1 <= $jml_fakultas; $b1++) {
										echo '<option ' . $sel_fakultas[$b1] . ' value="' . $id_fakultas[$b1] . '">' . $nama_fakultas[$b1] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>

				</fieldset>
			</div>
		</div>


		<div class="col-md-5">
			<div class="well bp-component" style="background-color: #FFFFFF;color: black" id="dkade">
				<fieldset>
					<legend style="color: black">Jurusan</legend>
					<div class="form-group">
						<div class="col-md-12" id="isidaftar2">
							<table style="color: black" id="tbl_user" class="table table-bordered nowrap" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th style='text-align:center;width:85%'>Nama Jurusan</th>
									<th style='text-align:center;'>Edit</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="col-md-12">
							<div id="tbtambah" style="display: none">
								<button onclick="tambahjurusan()" type="button">Tambah</button>
							</div>
							<div id="gruptambah" style="display: none">
								<textarea class="form-control" id="isijurusan" cols="100" rows="3"
										  name="imapel" maxlength="300" value="" placeholder="">
                                </textarea>
								<div style="text-align: right">
									<button onclick="bataltambah()" type="button">Batal</button>
									<button onclick="simpanjurusan()" type="button">Simpan</button>
								</div>
							</div>
							<div id="grupedit" style="display: none">
								<textarea class="form-control" id="isijurusan2" cols="100" rows="3"
										  name="isijurusan2" maxlength="300" value="" placeholder="">
                                </textarea>
								<div style="text-align: right">
									<button onclick="bataledit()" type="button">Batal</button>
									<button onclick="updatejurusan()" type="button">Update</button>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>


		<?php
		echo form_close() . '';
		?>
	</div>
</div>


<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<script>

	var indeks = new Array();
	var teksedit = new Array();
	var idpilih = 0;
	var kadepilih = "";

	$(document).on('change', '#ifakultas', function () {
		ambilmapel();
		cektambah();
	});

	function ambilmapel() {
		if ($('#ifakultas').val() >= 0) {
			isihtmlc1 = "<table style=\"color: black\" id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
				"<thead>" +
				"<tr>" +
				"<th style='text-align:center;width:85%'>Nama Jurusan</th>" +
				"<th style='text-align:center;'>Edit</th>" +
				"</tr>" +
				"</thead>" +
				"<tbody>";
			isihtmlc3 = "</tbody></table>";

			$.ajax({
				type: 'GET',
				data: {
					idfakultas: $('#ifakultas').val(),
					idjenjang: 6,
					idjurusan: 1
				},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url(); ?>video/ambil_jurusanpt',
				success: function (result) {
					isihtmlc2 = "";
					var jmljurusan = 0;
					$.each(result, function (i, result) {
						jmljurusan++;
						indeks[jmljurusan] = result.id;
						teksedit[jmljurusan] = result.nama_jurusan;
						isihtmlc2 = isihtmlc2 + "<tr><td>" + result.nama_jurusan + "</td>" +
							"<td style='text-align:center;'><button onclick=\"diedit('" +
							jmljurusan + "')\" type=\"button\">Edit</button></td></tr>";
					});
					$('#isidaftar2').html(isihtmlc1 + isihtmlc2 + isihtmlc3);
				}

			});
		}
	}

	function tambahjurusan() {
		$('#tbtambah').hide();
		$('#gruptambah').show();
		$('#isijurusan').val('');
	}

	function bataltambah() {
		$('#tbtambah').show();
		$('#gruptambah').hide();
	}

	function cektambah() {
		if ($('#ifakultas').val() > 0) {
			$('#tbtambah').show();
		}
		else {
			$('#tbtambah').hide();
		}
	}

	function cekjurusan() {
		if ($('#ijenjang').val() == 5) {
			document.getElementById('djurusan').style.display = "block";
		}
		else {
			document.getElementById('djurusan').style.display = "none";
		}
	}

	function simpanjurusan() {

		isihtmld1 = "<table style=\"color: black\" id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Nama Jurusan</th>" +
			"<th style='text-align:center;'>Edit</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmld3 = "</div></tbody></table>";
		$.ajax({
			url: "<?php echo base_url(); ?>video/addjurusan",
			method: "POST",
			dataType: 'json',
			data: {
				namajurusan: $('#isijurusan').val(),
				idfakultas: $('#ifakultas').val()
			},
			success: function (result) {
				isihtmld2 = "";
				var jmljurusan = 0;
				$.each(result, function (i, result) {
					jmljurusan++;
					indeks[jmljurusan] = result.id;
					teksedit[jmljurusan] = result.nama_jurusan;
					isihtmld2 = isihtmld2 + "<tr><td>" + result.nama_jurusan + "</td>" +
						"<td style='text-align:center;'><button onclick=\"diedit('" +
						jmljurusan + "')\" type=\"button\">Edit</button></td></tr>";
				});
				$('#isidaftar2').html(isihtmld1 + isihtmld2 + isihtmld3);
				bataltambah();
			},
			error: function () {
				alert('error!');
			}
		})
	}


	function diedit(idx) {
		//alert (indeks[idx]);
		idpilih = indeks[idx];
		jurusanpilih = teksedit[idx];

		$('#tbtambah').hide();
		$('#grupedit').show();
		$('#isijurusan2').val(jurusanpilih);

	}

	function bataledit() {
		$('#tbtambah').show();
		$('#grupedit').hide();
	}

	function updatejurusan() {
		isihtmld1 = "<table style=\"color: black\" id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Nama Mata Pelajaran</th>" +
			"<th style='text-align:center;'>Edit</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmld3 = "</div></tbody></table>";

		$.ajax({
			url: "<?php echo base_url(); ?>video/editjurusan",
			method: "POST",
			dataType: 'json',
			data: {
				idjurusan: idpilih,
				idfakultas: $('#ifakultas').val(),
				namajurusan: $('#isijurusan2').val()
			},
			success: function (result) {
				isihtmld2 = "";
				var jmlkd = 0;
				$.each(result, function (i, result) {
					jmlkd++;
					indeks[jmlkd] = result.id;
					teksedit[jmlkd] = result.nama_jurusan;
					isihtmld2 = isihtmld2 + "<tr><td>" + result.nama_jurusan + "</td>" +
						"<td style='text-align:center;'><button onclick=\"diedit('" +
						jmlkd + "')\" type=\"button\">Edit</button></td></tr>";
				});
				$('#isidaftar2').html(isihtmld1 + isihtmld2 + isihtmld3);
				bataledit();
			},
			error: function () {
				alert('error!');
			}
		})
	}


</script>
