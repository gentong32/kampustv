<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_jenjang = 0;
foreach ($dafjenjang as $datane) {
	$jml_jenjang++;
	$sel_jenjang[$jml_jenjang] = "";
	$id_jenjang[$jml_jenjang] = $datane->id;
	$nama_jenjang[$jml_jenjang] = $datane->nama_jenjang;
}

$jml_jurusan = 0;
foreach ($dafjurusan as $datane) {
    $jml_jurusan++;
    $sel_jurusan[$jml_jurusan] = "";
    $id_jurusan[$jml_jurusan] = $datane->id;
    $nama_jurusan[$jml_jurusan] = $datane->nama_jurusan;
}

$jml_jurusanpt = 0;
foreach ($dafjurusanpt as $datane) {
	$jml_jurusanpt++;
	$sel_jurusanpt[$jml_jurusanpt] = "";
	$id_jurusanpt[$jml_jurusanpt] = $datane->id;
	$nama_jurusanpt[$jml_jurusanpt] = $datane->nama_jurusan;
}

$jml_kategori = 0;
foreach ($dafkategori as $datane) {
	$jml_kategori++;
	$sel_kategori[$jml_kategori] = "";
	$id_kategori[$jml_kategori] = $datane->id;
	$nama_kategori[$jml_kategori] = $datane->nama_kategori;
}

$sel_jenis[1] = "";
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
		echo form_open('video/addvideox');
		?>
		<div class="col-md-5 col-md-offset-1">
			<div class="well bp-component" style="background-color: #FFFFFF;color: black">
				<fieldset>
					<legend style="color: black">Sasaran</legend>
					<div id="grupins" <?php echo $disp[1]; ?>>
						<div class="form-group" id="djenjang"><br>
							<label for="select" class="col-md-12 control-label">Jenjang</label>
							<div class="col-md-12">
								<select class="form-control" style="color: black" name="ijenjang" id="ijenjang">
									<option value="0">-- Pilih --</option>
									<?php
									for ($b1 = 1; $b1 <= $jml_jenjang; $b1++) {
										echo '<option ' . $sel_jenjang[$b1] . ' value="' . $id_jenjang[$b1] . '">' . $nama_jenjang[$b1] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>

                    <div id="grupins2">
                        <div class="form-group" id="djurusan" <?php echo $disp2[1]; ?>><br>
                            <label for="select" class="col-md-12 control-label">Jurusan</label>
                            <div class="col-md-12">
                                <select class="form-control" name="ijurusan" id="ijurusan">
                                    <option value="0">-- Semua Jurusan --</option>
                                    <?php
                                    for ($b2 = 1; $b2 <= $jml_jurusan; $b2++) {
                                        echo '<option ' . $sel_jurusan[$b2] . ' value="' . $id_jurusan[$b2] . '">' . $nama_jurusan[$b2] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

					<div id="grupins3">
						<div class="form-group" id="djurusanpt" <?php echo $disp2[1]; ?>><br>
							<label for="select" class="col-md-12 control-label">Jurusan</label>
							<div class="col-md-12">
								<select class="form-control" name="ijurusanpt" id="ijurusanpt">
									<option value="0">-- Semua Jurusan --</option>
									<?php
									for ($b2 = 1; $b2 <= $jml_jurusanpt; $b2++) {
										echo '<option ' . $sel_jurusanpt[$b2] . ' value="' . $id_jurusanpt[$b2] . '">' . $nama_jurusanpt[$b2] . '</option>';
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
					<legend style="color: black">Mata Pelajaran</legend>
					<div class="form-group">
						<div class="col-md-12" id="isidaftar2">
							<table style="color: black" id="tbl_user" class="table table-bordered nowrap" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th style='text-align:center;width:85%'>Nama mata pelajaran</th>
									<th style='text-align:center;'>Edit</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="col-md-12">
							<div id="tbtambah" style="display: none">
								<button onclick="tambahmapel()" type="button">Tambah</button>
							</div>
							<div id="gruptambah" style="display: none">
								<textarea class="form-control" id="imapel" cols="100" rows="3"
									   name="imapel" maxlength="300" value="" placeholder="">
                                </textarea>
								<div style="text-align: right">
									<button onclick="bataltambah()" type="button">Batal</button>
									<button onclick="simpanmapel()" type="button">Simpan</button>
								</div>
							</div>
							<div id="grupedit" style="display: none">
								<textarea class="form-control" id="imapel2" cols="100" rows="3"
									   name="imapel2" maxlength="300" value="" placeholder="">
                                </textarea>
								<div style="text-align: right">
									<button onclick="bataledit()" type="button">Batal</button>
									<button onclick="updatemapel()" type="button">Update</button>
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

	$(document).on('change', '#ijenjang', function () {
        cekjurusan();
        cektambah();
		ambilmapel();
	});

    $(document).on('change', '#ijurusan', function () {
        ambilmapel();
    });

	$(document).on('change', '#ijurusanpt', function () {
		ambilmapel();
	});

	function ambilmapel() {
		jenjang = $('#ijenjang').val();
		if (jenjang>= 0) {
			isihtmlc1 = "<table style=\"color: black\" id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
				"<thead>" +
				"<tr>" +
				"<th style='text-align:center;width:85%'>Nama Mata Pelajaran</th>" +
				"<th style='text-align:center;'>Edit</th>" +
				"</tr>" +
				"</thead>" +
				"<tbody>";
			isihtmlc3 = "</tbody></table>";
			$.ajax({
				type: 'GET',
				data: {
					idjenjang: $('#ijenjang').val(),
                    idjurusan: $('#ijurusan').val(),
					idjurusanpt: $('#ijurusanpt').val()
				},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url(); ?>video/ambilmapel',
				success: function (result) {
					isihtmlc2 = "";
					var jmlkd = 0;
					$.each(result, function (i, result) {
						jmlkd++;
						indeks[jmlkd] = result.id;
						teksedit[jmlkd] = result.nama_mapel;
						isihtmlc2 = isihtmlc2 + "<tr><td>" + result.nama_mapel + "</td>" +
							"<td style='text-align:center;'><button onclick=\"diedit('" +
							jmlkd + "')\" type=\"button\">Edit</button></td></tr>";
					});
					$('#isidaftar2').html(isihtmlc1 + isihtmlc2 + isihtmlc3);
				}

			});
		}
	}

	function tambahmapel() {
		$('#tbtambah').hide();
		$('#gruptambah').show();
        $('#imapel').val('');
	}

	function bataltambah() {
		$('#tbtambah').show();
		$('#gruptambah').hide();
	}

	function cektambah() {
		if ($('#ijenjang').val() > 0) {
			$('#tbtambah').show();
		}
		else {
			$('#tbtambah').hide();
		}
	}

    function cekjurusan() {
        if ($('#ijenjang').val() == 5) {
            document.getElementById('djurusan').style.display = "block";
			document.getElementById('djurusanpt').style.display = "none";
        } else if ($('#ijenjang').val() == 6) {
			document.getElementById('djurusanpt').style.display = "block";
			document.getElementById('djurusan').style.display = "none";
		}
        else {
            document.getElementById('djurusan').style.display = "none";
			document.getElementById('djurusanpt').style.display = "none";
        }
    }

	function simpanmapel() {
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
			url: "<?php echo base_url(); ?>video/addmapel",
			method: "POST",
			dataType: 'json',
			data: {
			    teksmapel: $('#imapel').val(),
				idjenjang: $('#ijenjang').val(),
                idjurusan: $('#ijurusan').val(),
				idjurusanpt: $('#ijurusanpt').val()
			},
			success: function (result) {
				isihtmld2 = "";
				var jmlkd = 0;
				$.each(result, function (i, result) {
					jmlkd++;
					indeks[jmlkd] = result.id;
					teksedit[jmlkd] = result.nama_mapel;
					isihtmld2 = isihtmld2 + "<tr><td>" + result.nama_mapel + "</td>" +
						"<td style='text-align:center;'><button onclick=\"diedit('" +
						jmlkd + "')\" type=\"button\">Edit</button></td></tr>";
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
		mapelpilih = teksedit[idx];

		$('#tbtambah').hide();
		$('#grupedit').show();
		$('#imapel2').val(mapelpilih);

	}

	function bataledit() {
		$('#tbtambah').show();
		$('#grupedit').hide();
	}

	function updatemapel() {
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
			url: "<?php echo base_url(); ?>video/editmapel",
			method: "POST",
			dataType: 'json',
			data: {
				idmapel: idpilih,
                idjenjang: $('#ijenjang').val(),
				idjurusan: $('#ijurusan').val(),
				idjurusanpt: $('#ijurusanpt').val(),
				teksmapel: $('#imapel2').val()
			},
			success: function (result) {
				isihtmld2 = "";
				var jmlkd = 0;
				$.each(result, function (i, result) {
					jmlkd++;
					indeks[jmlkd] = result.id;
					teksedit[jmlkd] = result.nama_mapel;
					isihtmld2 = isihtmld2 + "<tr><td>" + result.nama_mapel + "</td>" +
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
