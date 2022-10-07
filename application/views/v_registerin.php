<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nmsebagai = Array('', 'Guru/Dosen', 'Siswa', 'Umum', 'Staf Fordorum');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

$njenis1 = 'checked="checked"';
$njenis2 = '';
$njenis3 = '';
$nreferrer = '';
$tampil1 = 'style="display: block"';
$tampil2 = 'style="display: none"';

$njudul = '';
$nseri = '';
$ntahun = '';
$level = '';

$hasilemail = "";
$hasilpassword = "";
$hasilcapcay = "";

$xjabatan = $jabatan;
if ($jabatan == "Guru")
	$xjabatan = "Guru/Dosen";

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

?>
<div class="no-bottom no-top" id="content">
	<div id="top"></div>
	<!-- section begin -->
	<section id="subheader" class="text-light"
			 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>User</h1>
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
				<div class="row">
					<?php
					echo form_open('login/tambahinuser', array('autocomplete' => 'off', 'id' => 'myform'));

					?>

					<div class="container" style="max-width:600px;padding-bottom: 20px;	">
						<div>
							<legend><span
									style="font-weight: bold;color: black">Menambahkan User sebagai <?php echo $xjabatan; ?></span>
							</legend>
							<fieldset style="background-color: white;margin-top: 20px">


								<!--                    <input style="color:black;border:0;width: 0px;height: 0px; padding: 0;margin: 0" id="iemails"-->
								<!--                           name="iemails" maxlength="6" value="" placeholder="">-->

								<div class="form-group" style="padding-top: 20px;">
									<label for="" class="col-md-12 control-label">Email</label>
									<div class="col-md-12">
										<input autocomplete="false" autofill="false" type="text" class="form-control"
											   id="iemail"
											   name="iemail" maxlength="50" value="" placeholder="Alamat Email">
										<label class="text-danger"><span><div id="email_result"></div>
            				</span></label>
									</div>
								</div>
								<div id="tbgoogle" class="col-md-10 col-md-offset-0"
									 style="display:none;margin-left:15px;margin-bottom: 10px;">
									<a href="<?php echo $loginURL; ?>" class="btn btn-danger"><i class="fa fa-google"
																								 style="font-size: medium; background:none; width:20px; padding: 0;"></i>&nbsp;
										Google</a>
								</div>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Nama depan
										<span style="color: red" id="firstnameHasil"></span></label>
									<div class="col-md-12">
										<input type="text" class="form-control" id="ifirst_name" name="ifirst_name"
											   maxlength="25"
											   placeholder="Nama Depan">
									</div>
								</div>
								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Nama belakang
										<span style="color: red" id="lastnameHasil"></span></label>
									<div class="col-md-12">
										<input type="text" class="form-control" id="ilast_name" name="ilast_name"
											   maxlength="25"
											   placeholder="Nama Belakang">
									</div>
								</div>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Nama Lengkap (dan gelar)
									</label>
									<div class="col-md-12">
										<input type="text" class="form-control" id="ifull_name"
											   name="ifull_name"
											   maxlength="50"
											   value="" placeholder="Nama Lengkap">
									</div>

								</div>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Alamat</label>
									<div class="col-md-12">
								<textarea rows="4" cols="60" class="form-control" id="ialamat" name="ialamat"
										  maxlength="200"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">HP
									</label>
									<div class="col-md-12">
										<input type="text" class="form-control" id="ihp" name="ihp" maxlength="25"
											   value=""
											   placeholder="No. HP"><br>
									</div>
								</div>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Jenis Kelamin<span
											style="color: #ff2222"> *</span></label>
									<div class="col-md-12">
										<input type="radio" name="gender"
											   id="glaki" value="1">Laki-laki
										&nbsp;&nbsp;
										<input type="radio" name="gender"
											   id="gperempuan" value="2">Perempuan<br><br>
									</div>
								</div>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Tanggal Lahir<span
											style="color: #ff2222"> *</span>
										<span style="color: red" id="tgl_lahirHasil"></span></label>
									<div class="col-md-12">
										Tanggal: <input type="number" name="itgl_lahir" id="itgl_lahir"
														id="itgl_lahir" min="1"
														max="31" value="">
										Bulan: <select name="ibln_lahir" id="ibln_lahir">
											<?php
											for ($a = 1; $a <= 12; $a++) {
												echo "<option value='" . $a . "'>" . $nmbulan[$a] . "</option>";
											}
											?>
										</select>
										Tahun: <input type="number" name="ithn_lahir" id="ithn_lahir"
													  min="1900" max="<?php
										$time = strtotime("-5 year", time());
										echo(date("Y") - 5);
										?>" value=""><br><br>
									</div>

								</div>


								<?php if ($jabatan == "Guru" || $jabatan == "Siswa") { ?>

									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">NPSN
											<span style="color: red" id="npsnHasil"></span></label>
										<div class="col-md-12">
											<input type="text" class="form-control" id="inpsn" name="inpsn"
												   maxlength="8"
												   value="" placeholder="NPSN">
										</div>
									</div>
									<div class="form-group" id="ketsekolahbaru" style="display:none;">
										<div id="ketsekolah" style="margin-left:30px;font-weight:bold;color: #ff2222">
											NPSN salah
											atau belum terdaftar
										</div>
										<button style="margin-left: 30px;" class="myButtonblue"
												onclick="return tambahsekolah();">Ajukan Data
											Sekolah
										</button>
									</div>

									<div id="dsekolahbaru" style="display: none;">
										<div class="form-group" id="dpropinsi">
											<label for="select"
												   class="col-md-12 control-label">Propinsi <?php //echo $userData['kd_provinsi'];?></label>
											<div class="col-md-12">
												<select class="form-control" name="ipropinsi" id="ipropinsi">
													<option value="0">-- Pilih --</option>
													<?php
													for ($b2 = 1; $b2 <= $jml_propinsi; $b2++) {
														$terpilihb2 = '';

														echo '<option value="' . $id_propinsi[$b2] . '">' . $nama_propinsi[$b2] . '</option>';
													}
													?>
												</select>
											</div>
										</div>

										<div class="form-group" id="dkota">
											<label for="select" class="col-md-12 control-label">Kota/Kabupaten</label>
											<div class="col-md-12">
												<select class="form-control" name="ikota" id="ikota">
													<option value="0">-- Pilih --</option>
													<?php
													for ($b3 = 1; $b3 <= $jml_kota; $b3++) {

														echo '<option value="' . $id_kota[$b3] . '">' . $nama_kota[$b3] . '</option>';
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
												<input type="text" class="form-control" id="idesasekolah"
													   name="idesasekolah"
													   maxlength="100" value="">
											</div>
										</div>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">Alamat
												Sekolah</label>
											<div class="col-md-12">
												<input type="text" class="form-control" id="ialamatsekolah"
													   name="ialamatsekolah"
													   maxlength="100" value="">
											</div>
										</div>

										<div class="form-group" id="dkota">
											<label for="select" class="col-md-12 control-label">Jenjang</label>
											<div class="col-md-12">
												<select class="form-control" name="ijenjangsekolah"
														id="ijenjangsekolah">
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

									</div>

									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">Nama Sekolah</label>
										<div class="col-md-12">
											<input readonly type="text" class="form-control" id="isekolah"
												   name="isekolah"
												   maxlength="100"
												   value="" placeholder="Nama Sekolah">
										</div>
									</div>

									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">NUPTK/NISN/NIP (*Diisi
											salah
											satu)</label>
										<div class="col-md-12" style="padding-bottom: 20px">
											<input type="text" class="form-control" id="inomor"
												   name="inomor" maxlength="100"
												   value=""
												   placeholder="Nomor">
										</div>
									</div>

								<?php } else { ?>
									<input type="hidden" id="inpsn" name="inpsn" value="10000011" placeholder="">
									<input type="hidden" id="isekolah" name="isekolah" value="Fordorum" placeholder="">
									<div class="form-group">
										<label for="inputDefault"
											   class="col-md-12 control-label">Instansi/Lembaga</label>
										<div class="col-md-12">
											<input style="width: 300px" type="text" class="form-control"
												   id="ibidang"
												   name="ibidang" maxlength="100" value="" placeholder="Instansi">
										</div>
									</div>

									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">Pekerjaan</label>
										<div class="col-md-12">
											<input style="width: 300px" type="text" class="form-control"
												   id="ikerja"
												   name="ikerja" maxlength="100" value="" placeholder="Pekerjaan">
										</div>
									</div>

									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">NIP/KTP</label>
										<div class="col-md-12">
											<input style="width: 180px" type="text" class="form-control"
												   id="inomor2"
												   name="inomor2" maxlength="18" value="" placeholder="Nomor">
										</div>
									</div>
								<?php } ?>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Password</label>
									<div class="col-md-12" style="width:200px;padding-bottom: 20px;">
										<input readonly type="text" class="form-control" id="ipassword" name="ipassword"
											   maxlength="16" value="12345">
									</div>
								</div>


								<input type="hidden" id="addedit" name="addedit"/>
								<input type="hidden" id="jabatan" name="jabatan" value="<?php echo $jabatan; ?>"/>

								<div class="form-group">
									<div class="col-md-10 col-md-offset-0" style="margin-bottom: 10px;">
										<button class="btn btn-default" onclick="return takon()">Batal</button>
										<button type="submit" class="btn btn-primary" onclick="return cekregister()">
											Daftar
										</button>
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
		</div>
	</section>
</div>


<script>

	var hasilemail = "";
	var emailvalid = false;

	$(document).ready(function () {
		var siiemal = $(document).getElementById('iemail');
		siiemal.html("sdsa");
	});


	$(document).on('change', '#iemail', function () {
		var email = $('#iemail').val();
		var $result = $("#email_result");
		var domain = email.substring(email.lastIndexOf("@") + 1);
		$result.text("");

		if (validateEmail(email)) {
			//$result.text(email + " is valid :)");
			//$result.css("color", "green");
			emailvalid = true;

		} else {
			$result.text("Alamat email '" + email + "' tidak valid");
			$result.css("color", "red");
			emailvalid = false;
		}

		if (email != '' && emailvalid) {
			$.ajax({
				url: "<?php echo base_url(); ?>login/cekemail",
				method: "POST",
				data: {email: email},
				success: function (data) {

					$('#email_result').html(data);
					hasilemail = data;
					//alert (data);
				}
			});
		}

	});

	function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	$(document).on('change', '#ifirst_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ifirst_name').val())) {
			$('#firstnameHasil').html("");
		} else {
			$('#firstnameHasil').html("* huruf saja");
		}
	});

	$(document).on('change', '#ilast_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ilast_name').val()) || $('#ilast_name').val() == "") {
			$('#lastnameHasil').html("");
		} else {
			$('#lastnameHasil').html("* huruf saja");
		}
	});

	function cekregister() {
		var ijinlewat1 = false;
		var ijinlewat2 = false;
		var ijinlewat3 = false;

		$('#jabatan').val("<?php echo $jabatan;?>");
		$('#addedit').val('<?php echo $addedit;?>');

		if ($('#ifirst_name').val() == "" || $('#email').val() == "") {
			alert("Semua harus diisi");
			ijinlewat1 = false;
		} else
			ijinlewat1 = true;

		if (hasilemail != "" || emailvalid == false)
			ijinlewat2 = false;
		else
			ijinlewat2 = true;

		if (ijinlewat1 && ijinlewat2) {
			document.getElementById('myform').submit();
		} else {
			alert("Periksa kembali data anda!");
			return false;
		}

		return false;
	}

	function takon() {
		window.open("<?php echo base_url();?>user/tambahnarsum", "_self");
		return false;
	}

	$('#myform').on('keyup keypress', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	$(document).on('change', '#ipropinsi', function () {
		getdaftarkota();
	});

	$(document).ready(function () {

		$('#submit').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url();?>login/upload_foto_profil',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading').hide();
					$("#message").html(data);
				}
			});
		});

		$('#submit2').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url();?>login/upload_foto_sekolah',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading2').hide();
					$("#message2").html(data);
				}
			});
		});


	});

	function getdaftarkota() {

		isihtml0 = '<label for="select" class="col-md-12 control-label">Kota/Kabupaten</label><div class="col-md-12">';
		isihtml1 = '<select class="form-control" name="ikota" id="ikota">' +
			'<option value="0">-- Pilih --</option>';
		isihtml3 = '</select></div>';
		$.ajax({
			type: 'GET',
			data: {idpropinsi: $('#ipropinsi').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>login/daftarkota',
			success: function (result) {
				//alert ($('#itopik').val());
				isihtml2 = "";
				$.each(result, function (i, result) {
					isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota + "</option>";
				});
				$('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
			}
		});
	}

	<?php //if ($userData['sebagai'] >= 1)
	{?>

	$(document).on('change', '#inpsn', function () {
		// alert ($('#inpsn').val());
		getdaftarsekolah();
	});
	<?php } ?>

	function getdaftarsekolah() {
		//alert ($('#inpsn').val());
		//$('#isekolah').prop('readOnly', true);
		// isihtml0 = '<label for="select" class="col-md-12 control-label">Kota/Kabupaten</label><div class="col-md-12">';
		// isihtml1 = '<select class="form-control" name="ikota" id="ikota">' +
		// 	'<option value="0">-- Pilih --</option>';
		// isihtml3 = '</select></div>';
		$.ajax({
			type: 'GET',
			data: {npsn: $('#inpsn').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>login/getsekolah',
			success: function (result) {

				// isihtml2 = "";
				$('#isekolah').prop('readonly', true);
				$('#isekolah').val("");
				$('#isekolah').focus();
				$.each(result, function (i, result) {
					//alert (result.nama_sekolah);
					if (!result.nama_sekolah == "") {

						$('#inomor').focus();
						$('#isekolah').prop('readonly', true);
						$('#isekolah').val(result.nama_sekolah);
						//alert(result.nama_sekolah);
						if (!result.logo == "") {
							// alert (result.logo);
							document.getElementById('dlogosekolah').style.display = "block";
							$('#previewing2').attr('src', '<?php echo base_url() . "uploads/profil/";?>' + result.logo);
						} else {

							document.getElementById('dlogosekolah').style.display = "none";
						}
						document.getElementById('ketsekolahbaru').style.display = "none";

					} else {
						if ($('#npsnHasil').html() == "")
							document.getElementById('ketsekolahbaru').style.display = "block";
					}


					//alert (result.nama_sekolah);
					// 	isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota + "</option>";
				});
				// $('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
			}
		});
	}


	$(document).on('change', '#ijenjang', function () {
		getdaftarmapel();
	});

	$(document).on('change', '#ifirst_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ifirst_name').val())) {
			$('#firstnameHasil').html("");
		} else {
			$('#firstnameHasil').html("* huruf dan titik saja");
		}
	});

	$(document).on('change', '#ilast_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ilast_name').val())) {
			$('#lastnameHasil').html("");
		} else {
			$('#lastnameHasil').html("* huruf dan titik saja");
		}
	});

	$(document).on('change', '#ifull_name', function () {
		var objRegExp = /^[a-zA-Z,.\s]+$/;
		if (objRegExp.test($('#ifull_name').val())) {
			$('#fullnameHasil').html("");
		} else {
			$('#fullnameHasil').html("* ilegal");
		}
	});

	$(document).on('change', '#ihp', function () {
		var objRegExp = /^[+0-9\s]+$/;
		if (objRegExp.test($('#ihp').val())) {
			$('#hpHasil').html("");
		} else {
			$('#hpHasil').html("* angka saja");
		}
	});

	$(document).on('change', '#inpsn', function () {
		var objRegExp = /^[+0-9\s]+$/;
		if (objRegExp.test($('#inpsn').val()) && $('#inpsn').val().length == 8) {
			$('#npsnHasil').html("");
		} else {
			$('#npsnHasil').html("* 8 digit angka");
			document.getElementById('ketsekolahbaru').style.display = "none";
		}
	});

	$(document).on('change', '#itgl_lahir', function () {
		if (($('#ithn_lahir').val()) > 1900) {
			cektanggal();
		}
	});

	$(document).on('change', '#ithn_lahir', function () {
		if (($('#itgl_lahir').val()) >= 1) {
			cektanggal();
		}

	});

	$(document).on('change', '#ibln_lahir', function () {
		if ((($('#itgl_lahir').val()) >= 1) && ($('#ithn_lahir').val() > 1900)) {
			cektanggal();
		}
	});

	function cektanggal() {
		if (isValidDate($('#itgl_lahir').val(), $('#ibln_lahir').val(), $('#ithn_lahir').val())) {
			$('#tgl_lahirHasil').html("");
		} else {
			$('#tgl_lahirHasil').html("Tanggal lahir tidak valid");
		}

		var d = Date.parse($('#ithn_lahir').val() + "-" + $('#ibln_lahir').val() + "-" + $('#itgl_lahir').val());
		var nowDate = new Date();
		var date = nowDate.getFullYear() + '-' + (nowDate.getMonth() + 1) + '-' + nowDate.getDate();
		var d2 = Date.parse(date);
		selisih = ((d2 - d) / (60 * 60 * 24 * 1000)); //this is in milliseconds
		if (selisih < 1826)
			$('#tgl_lahirHasil').html("Usia minimal 5 tahun");

	}

	function isValidDate(dd, mm, yy) {
		var date = new Date();
		date.setFullYear(yy, mm - 1, dd);

		if ((date.getFullYear() == yy) && (date.getMonth() == (mm - 1)) && (date.getDate() == dd))
			return true;
		return false;
	}


	function cekupdate() {

		var ijinlewat1 = true;
		var ijinlewat2 = true;
		var kelamin = true;
		var tgllahir = true;
		//var jenise = document.getElementsByName('ijenis');
		$('#addedit').val('<?php
			echo $addedit;
			?>');

		if ($('#iverikontri').val() == 3) {
			$.ajax({
				type: 'GET',
				data: {npsn: $('#inpsn').val()},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>login/cekjmlver',
				success: function (result) {
					if (result.jumlahver == 2) {
						ijinlewat = false;
						$('#ketver').html("Sudah ada 2 verifikator di sekolah, silakan ganti.");
					} else {
						ijinlewat = true;
						$('#ketver').html("");
					}

				}
			});

		}


		<?php  if ($this->session->userdata('oauth_provider') == 'system'){?>
		if (($('#ipassbaru1').val().length > 0 && $('#ipassbaru1').val().length < 5) ||
			($('#ipassbaru2').val().length > 0 && $('#ipassbaru2').val().length < 5)) {

			$('#keteranganpass').html("*Password minimal 5 karakter");
			ijinlewat = false;
		}
		<?php }?>

		if ($('#ipassbaru1').val() != $('#ipassbaru2').val()) {

			$('#keteranganpass').html("*Password Baru dan Ulangi Password Baru belum sama");
			ijinlewat = false;
		}

		if ($('#tgl_lahirHasil').html() != "" || $('#itgl_lahir').val() == "" || $('#ithn_lahir').val() == "") {
			tgllahir = false;
		}

		if ($('#firstnameHasil').html() != "" || $('#lastnameHasil').html() != "") {
			ijinlewat = false;
		}

		if (document.getElementById('glaki').checked == false && document.getElementById('gperempuan').checked == false) {
			kelamin = false;
		}

		if ($('#ifirst_name').val() == "" || $.trim($('#ialamat').val()) == "" ||
			$('#ihp').val() == "" || kelamin == false || tgllahir == false || $('#ithn_lahir').val() <= 1900) {
			ijinlewat1 = false;
		}

		<?php if ($jabatan == "Guru") { ?>
		if ($('#ijenis').val() != 4 && ($('#inomor').val() == "" || $('#isekolah').val() == "" ||
			$('#inpsn').val() == "")) {
			ijinlewat2 = false;
		}
		<?php } ?>

		<?php if ($jabatan != "Guru") { ?>
		if ($('#ibidang').val() == 0 || $('#ikerja').val() == 0 || $('#inomor2').val() == "") {
			ijinlewat2 = false;
		}
		<?php } ?>

		if (document.getElementById('dsekolahbaru').style.display == "block") {
			if ($('#ipropinsi').val() == 0 || $('#ikota').val() == 0 || $('#ialamatsekolah').val() == ""
				|| $('#ikecamatansekolah').val() == "" || $('#idesasekolah').val() == "" || $('#ijenjangsekolah').val() == 0) {
				ijinlewat2 = false;
			}
		}

		<?php if($jabatan != "Guru"){?>
		$('#inomor').val($('#inomor2').val());<?php } ?>

		if (ijinlewat1 && ijinlewat2) {
			return true;
		} else {
			if (ijinlewat1 == false && ijinlewat2 == false)
				$('#ketawal').html("Data Personal dan Data Sekolah/Instansi harus dilengkapi");
			else if (ijinlewat1 == false)
				$('#ketawal').html("Data Personal belum lengkap");
			else if (ijinlewat2 == false)
				$('#ketawal').html("Data Sekolah/Instansi belum dilengkapi");

			var idtampil = setInterval(klirket, 3000);

			function klirket() {
				clearInterval(idtampil);
				$('#ketawal').html("");
			}

			return false;
		}
		return false
	}

	function tambahsekolah() {
		if (document.getElementById('dsekolahbaru').style.display == "none") {
			document.getElementById('dsekolahbaru').style.display = "block";
			$('#isekolah').prop('readonly', false);
			$('#inpsn').prop('readonly', true);
		} else {
			document.getElementById('dsekolahbaru').style.display = "none";
			$('#isekolah').prop('readonly', true);
			$('#inpsn').prop('readonly', false);
		}

		return false;
	}

</script>
