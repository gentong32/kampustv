<link href="<?php echo base_url(); ?>css/soal.css" rel="stylesheet">
<style>
	.tbeks1 {
		box-shadow: 3px 4px 0px 0px #1564ad;
		background: linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
		background-color: #79bbff;
		border-radius: 5px;
		border: 1px solid #337bc4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 20px;
		font-weight: bold;
		padding: 10px;
		margin: 5px;
		text-decoration: none;
		text-shadow: 2px 3px 1px #528ecc;
	}

	.tbeks1:hover {
		background: linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
		background-color: #378de5;
	}

	.tbeks1:active {
		position: relative;
		top: 1px;
	}

	.tbeks0 {
		box-shadow: inset 0px 1px 0px 0px #ffffff;
		background: linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%);
		background-color: #f9f9f9;
		border-radius: 6px;
		border: 1px solid #dcdcdc;
		display: inline-block;
		cursor: pointer;
		color: #666666;
		font-family: Arial;
		font-size: 20px;
		font-weight: bold;
		padding: 10px;
		margin: 5px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #ffffff;
	}

	.tbeks0:hover {
		background: linear-gradient(to bottom, #e9e9e9 5%, #f9f9f9 100%);
		background-color: #e9e9e9;
	}

	.tbeks0:active {
		position: relative;
		top: 1px;
	}

	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
	}

	th, td {
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even) {
		background-color: #f2f2f2
	}

</style>

<?php
$jmlrow = 0;
//echo "<br><br><br><br><br><br><br><br><br><br><br>";

$classjenis[1] = "tbeks0";
$classjenis[2] = "tbeks0";

//echo "<br><br><br><br><br><br><br>";
$jmlagency = 0;
foreach ($daftaragensi as $row) {
	$jmlagency++;
	$id_agency[$jmlagency] = $row->id;
	$nama_agency[$jmlagency] = $row->first_name;
	$alamat_agency[$jmlagency] = $row->alamat;
	$hp_agency[$jmlagency] = $row->hp;
	$email_agency[$jmlagency] = $row->email;
}

$jml_propinsi = 0;
foreach ($dafpropinsi as $datane) {
	$jml_propinsi++;
	$id_propinsi[$jml_propinsi] = $datane->id_propinsi;
	$nama_propinsi[$jml_propinsi] = $datane->nama_propinsi;
}

$jml_kota = 0;
foreach ($dafkota as $datane) {
	$jml_kota++;
	$id_kota[$jml_kota] = $datane->id_kota;
	$nama_kota[$jml_kota] = $datane->nama_kota;
}

$prefix = 'http://';
$prefix2 = 'https://';
$http = base_url();
if (substr($http, 0, strlen($prefix)) == $prefix) {
	$http = substr($http, strlen($prefix));
} else if (substr($http, 0, strlen($prefix2)) == $prefix2) {
	$http = substr($http, strlen($prefix2));
}

//echo "<br><br><br><br><br><br>".$dafmarketing->status;

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
						<h1>Area Marketing</h1>
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
					<div style="font-size: 18px;font-weight: bold">SEKOLAH SASARAN MoU
					</div>
				</center>
				<div style="float:left;margin-bottom: 10px;">
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">
						Kembali
					</button>
				</div>
				<hr>
				<div id="tempatsoal" class="container"
					 style="opacity:80%;padding-top:10px;padding-bottom:20px;color: black;">
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1" style="border: solid 1px black;padding-bottom: 20px;">
							<div class="row">
								<div class="col-1">
									<center>
										<div style="font-size: 16px;padding-top:10px;">
											AGENCY
										</div>
										<hr style="margin-top: 10px;margin-bottom: 10px;">
										<div class="row" style="margin-bottom:0px;padding-bottom: 0px;">
											<select <?php if ($dafmarketing->status == 1) echo 'disabled'; ?>
												style="margin:auto;max-width: 200px;" class="form-control" name="isiag" id="isiag">
												<option value="8983">Agency Pusat</option>
												<?php for ($a = 1; $a <= $jmlagency; $a++) {
													if ($a == 1)
														$selectag = "selected";
													else
														$selectag = "";
													echo '<option ' . $selectag . ' value="' . $id_agency[$a] . '">' . $nama_agency[$a] . '</option>';
												} ?>
												<option value="0">- Tanpa Agency -</option>
											</select>
											<br><br>
										</div>
									</center>
								</div>
							</div>
						</div>
					</div>

					<br>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1" style="border: solid 1px black;padding-bottom: 20px;">
							<div class="row">
								<div class="col-1">
									<center>
										<div style="font-size: 16px;padding-top:10px;">
											SEKOLAH SASARAN
										</div>
										<hr style="margin-top: 10px;margin-bottom: 10px;">
										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">NPSN / KODE PRODI / NOMOR
												YAYASAN
												<span style="color: red" id="npsnHasil"></span></label>
											<div style="max-width: 200px;margin:auto">
												<input <?php if ($dafmarketing->status == 1) echo 'disabled'; ?>
													type="text" class="form-control" id="inpsn" name="inpsn" maxlength="8"
													value="<?php echo $dafmarketing->npsn_sekolah; ?>" placeholder="">
											</div>
											<div id="dtombolcek" style="display:none; padding: 10px;">
												<button onclick="ceknpsn();">CEK</button>
											</div>
										</div>
										<div class="form-group" id="ketsekolahbaru" style="display:none;">
											<div id="ketsekolah" style="font-weight:bold;color: #ff2222">Nomor kode salah atau belum
												terdaftar
											</div>
											<button class="myButtonblue" onclick="return tambahsekolah();">Ajukan Data Baru
											</button>
										</div>

										<div class="form-group" style="height: 60px;">
											<label for="inputDefault" class="col-md-12 control-label">Nama Sekolah/Lembaga</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="isekolah" name="isekolah"
													   maxlength="100"
													   value="<?php echo $dafmarketing->nama_sekolah; ?>" placeholder="">
											</div>
										</div>


										<div class="form-group" id="dkotasekolah" style="display: <?php
										if ($dafmarketing->nama_kota != "")
											echo "block";
										else
											echo "none"; ?>;">
											<label for="inputDefault" class="col-md-12 control-label">Kota</label>
											<div class="col-md-12" style="margin-bottom: 20px;">
												<input readonly type="text" class="form-control" id="ikotasekolah"
													   name="ikotasekolah"
													   maxlength="100"
													   value="<?php echo $dafmarketing->nama_kota; ?>" placeholder="">
											</div>
										</div>

										<div id="dtombolok" style="margin-bottom: 20px;">

										</div>

										<div id="dsekolahbaru" style="display: none;">
											<div class="form-group" id="dpropinsi">
												<label for="select"
													   class="col-md-12 control-label">Propinsi <?php //echo $userData['kd_provinsi'];?></label>
												<div class="col-md-12">
													<select disabled class="form-control" name="ipropinsi" id="ipropinsi">
														<option value="0">-- Pilih --</option>
														<?php
														for ($b2 = 1; $b2 <= $jml_propinsi; $b2++) {
															$terpilihb2 = '';
															if ($id_propinsi[$b2] == $propinsisaya)
																$terpilihb2 = 'selected';
															echo '<option ' . $terpilihb2 . ' value="' . $id_propinsi[$b2] . '">' . $nama_propinsi[$b2] . '</option>';
														}
														?>
													</select>
												</div>
											</div>

											<div class="form-group" id="dkota">
												<label for="select" class="col-md-12 control-label">Kota/Kabupaten</label>
												<div class="col-md-12">
													<select disabled class="form-control" name="ikota" id="ikota">
														<option value="0">-- Pilih --</option>
														<?php
														for ($b3 = 1; $b3 <= $jml_kota; $b3++) {
															$terpilihb3 = '';
															if ($id_kota[$b3] == $kotasaya)
																$terpilihb3 = 'selected';
															echo '<option ' . $terpilihb3 . ' value="' . $id_kota[$b3] . '">' . $nama_kota[$b3] . '</option>';
														}
														?>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label for="inputDefault" class="col-md-12 control-label">Kecamatan</label>
												<div class="col-md-12">
													<input type="text" class="form-control" id="ikecamatansekolah"
														   name="ikecamatansekolah"
														   maxlength="100" value="">
												</div>
											</div>

											<div class="form-group">
												<label for="inputDefault" class="col-md-12 control-label">Desa</label>
												<div class="col-md-12">
													<input type="text" class="form-control" id="idesasekolah" name="idesasekolah"
														   maxlength="100" value="">
												</div>
											</div>

											<div class="form-group">
												<label for="inputDefault" class="col-md-12 control-label">Alamat
													Sekolah/Lembaga</label>
												<div class="col-md-12">
													<input type="text" class="form-control" id="ialamatsekolah"
														   name="ialamatsekolah"
														   maxlength="100" value="">
												</div>
											</div>

											<div class="form-group" id="djanjang">
												<label for="select" class="col-md-12 control-label">Jenjang</label>
												<div class="col-md-12" style="margin-bottom: 20px;">
													<select class="form-control" name="ijenjangsekolah" id="ijenjangsekolah">
														<option value="0">-- Pilih --</option>
														<option value="1">PAUD</option>
														<option value="2">SD/MI</option>
														<option value="3">SMP/MTs</option>
														<option value="4">SMA/MA</option>
														<option value="5">SMK/MAK</option>
														<option value="6">PT</option>
														<option value="7">PKBM/Kursus</option>
													</select>
												</div>
											</div>
											<div style="padding: 20px;margin-top: 20px;">
												<button onclick="bataltambah()" class="btn-danger">BATAL</button>
												<button onclick="simmpansekolah()" class="btn-info">TAMBAHKAN</button>
											</div>
										</div>
									</center>
								</div>
							</div>
						</div>
					</div>

					<br>
					<?php if ($dafmarketing->status == 1) { ?>
						<div class="wb_LayoutGrid1">
							<div class="LayoutGrid1" style="border: solid 1px black;padding-bottom: 20px;">
								<div class="row">
									<div class="col-1">
										<center>
											<div style="font-size: 16px;padding-top:10px;">
												KODE REFERAL PENDAFTARAN
											</div>
											<hr style="margin-top: 10px;margin-bottom: 10px;">
											<span style="font-size: 13px;">Guru/Dosen: </span><br>
											<div id="kode1" style="font-size: 14px;"><?php echo $http; ?>login/registrasi/guru/<?php
												echo $dafmarketing->kode_referal; ?></div>
											<br>
											<hr style="color:black; border: #375986 1px dashed;
				margin-top:5px;margin-bottom:3px;max-width: 280px;">
											<span style="font-size: 13px;">Siswa/Mahasiswa: </span><br>
											<div id="kode2" style="font-size: 14px;"><?php echo $http; ?>login/registrasi/siswa/<?php
												echo $dafmarketing->kode_referal; ?></div>
											<br>
											<hr style="color:black; border: #375986 1px dashed;
				margin-top:5px;margin-bottom:3px;max-width: 280px;">
											<span style="font-size: 13px;">Umum: </span><br>
											<div id="kode3" style="margin-bottom:20px;font-size: 14px;"><?php echo $http; ?>login/registrasi/umum/<?php
												echo $dafmarketing->kode_referal; ?></div>

											<div style="margin-bottom: 20px;">
												<button class="btn-info" onclick="terlaksana();">Terlaksana</button>
											</div>
										</center>
									</div>
								</div>
							</div>
						</div>

					<?php } ?>
				</div>
			</div>
		</div>
	</section>
</div>

<script>

	$(document).on('change', '#inpsn', function () {
		var objRegExp = /^[+0-9\s]+$/;
		if (objRegExp.test($('#inpsn').val()) && $('#inpsn').val().length >= 8) {
			$('#npsnHasil').html("");
		} else {
			$('#npsnHasil').html("* 8 digit angka");
			document.getElementById('ketsekolahbaru').style.display = "none";
		}
	});

	$(document).on('change input', '#inpsn', function () {
		document.getElementById('ketsekolahbaru').style.display = "none";
		$('#dtombolcek').show();
	});

	function ceknpsn() {
		//alert ($('#inpsn').val());
		$('#dtombolcek').hide();
		if ($('#inpsn').val() != "") {
			$.ajax({
				type: 'POST',
				data: {npsn: $('#inpsn').val()},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>marketing/ceksasaran',
				success: function (result) {
					if (result.nama_sekolah == "nemu") {
						$('#npsnHasil').html("Sudah pernah!");
						document.getElementById('ketsekolahbaru').style.display = "true";
					}

					// alert ("SUDAH PERNAH INI");
					else {
						//alert ("BELUM");
						// isihtml2 = "";
						$('#isekolah').prop('readonly', true);
						$('#isekolah').val("");
						$('#isekolah').focus();
						$.each(result, function (i, result) {
							//alert (result.nama_sekolah);
							if (!result.nama_sekolah == "") {
								if (result.nama_kota == "")
									$('#dkotasekolah').hide();
								else
									$('#dkotasekolah').show();
								$('#isekolah').prop('readonly', true);
								$('#isekolah').val(result.nama_sekolah);
								$('#ikotasekolah').val(result.nama_kota);
								$('#dtombolok').html('<button onclick="pilihsekolah()" class="btn-info">OK</button>');
								//alert(result.nama_sekolah);
								document.getElementById('ketsekolahbaru').style.display = "none";

							} else {
								if ($('#npsnHasil').html() == "") {
									$('#dtombolok').html('');
									document.getElementById('ketsekolahbaru').style.display = "block";
								}
							}


							//alert (result.nama_sekolah);
							// 	isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota + "</option>";
						});
						// $('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
					}
				}
			});
		}
	}

	function tambahsekolah() {
		if (document.getElementById('dsekolahbaru').style.display == "none") {
			document.getElementById('dsekolahbaru').style.display = "block";
			document.getElementById('dkotasekolah').style.display = "none";
			$('#isekolah').prop('readonly', false);
			$('#inpsn').prop('readonly', true);
		} else {
			document.getElementById('dsekolahbaru').style.display = "none";
			document.getElementById('dkotasekolah').style.display = "block";
			$('#isekolah').prop('readonly', true);
			$('#inpsn').prop('readonly', false);
		}

		return false;
	}

	function bataltambah() {
		document.getElementById('dsekolahbaru').style.display = "none";
		document.getElementById('dkotasekolah').style.display = "block";
		document.getElementById('ketsekolahbaru').style.display = "none";
		$('#isekolah').prop('readonly', true);
		$('#inpsn').prop('readonly', false);
		$('#inpsn').setFocus();
		$('#npsnHasil').html("");

	}

	function pilihsekolah() {
		$.ajax({
			url: "<?php echo base_url();?>marketing/pilih_sekolah",
			method: "POST",
			data: {
				siag: $('#isiag').val(),
				npsn: $('#inpsn').val()
			},
			success: function (result) {
				if (result != "gagal") {
					window.location.reload();
				} else {
					alert("GAGAL PROSES!");
				}
			}
		});
	}

	function simmpansekolah() {
		$.ajax({
			url: "<?php echo base_url();?>marketing/update_sekolahbaru",
			method: "POST",
			data: {
				siag: $('#isiag').val(),
				npsn: $('#inpsn').val(),
				ikota: $('#ikota').val(),
				isekolah: $('#isekolah').val(),
				ialamatsekolah: $('#ialamatsekolah').val(),
				ikecamatansekolah: $('#ikecamatansekolah').val(),
				idesasekolah: $('#idesasekolah').val(),
				ijenjangsekolah: $('#ijenjangsekolah').val()
			},
			success: function (result) {
				if (result != "gagal") {
					window.open("<?php echo base_url();?>marketing","_self");
				} else {
					alert("GAGAL PROSES!");
				}
			}
		});
	}

	function terlaksana() {
		if (confirm("Apakah sudah terlaksana?")) {
			$.ajax({
				url: "<?php echo base_url();?>marketing/terlaksana",
				method: "POST",
				data: {
					siag: $('#isiag').val(),
					npsn: $('#inpsn').val()
				},
				success: function (result) {
					// alert (result);
					if (result != "gagal") {
						window.open('<?php echo base_url() . "marketing";?>', '_self');
					} else {
						alert("PROSES GAGAL!");
					}
				}
			});
		}
	}


</script>
