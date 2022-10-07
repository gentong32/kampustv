<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($referrer))
$referrer = "";

if ($addedit == "add") {
	$judule = "TAMBAH";
	$namapaket = "";
	date_default_timezone_set('Asia/Jakarta');
	$tglpaket = new DateTime();
	$tglpaket = $tglpaket->format("Y-m-d H:i");
	$linklist = "";
	$jenjangini = 0;
	$kelasini = 0;
	$dekelas = "block";
	$mingguke = 0;
	if (intval(substr($tglpaket,5,2))>=6)
		$semester = 1;
	else
		$semester = 2;
} else {
	$judule = "EDIT";
	$namapaket = $datapaket->nama_paket;
	$tglpaket = substr($datapaket->tanggal_tayang, 0, 16);
	$linklist = $datapaket->link_list;

	$jenjangini = $datapaket->id_jenjang;
	$kelasini = $datapaket->id_kelas;
	$jurusanini = $datapaket->id_jurusan;
	$mapelini = $datapaket->id_mapel;
	$mingguke = $datapaket->modulke;
	$semester = $datapaket->semester;

	if ($jenjangini == 5) {
		$jml_jurusan = 0;
		foreach ($dafjurusan as $datane) {
			$jml_jurusan++;
			$sel_jurusan[$jml_jurusan] = "";
			$id_jurusan[$jml_jurusan] = $datane->id;
			$nama_jurusan[$jml_jurusan] = $datane->nama_jurusan;
		}
		for ($a1 = 1; $a1 <= $jml_jurusan; $a1++)
			$sel_jurusan[$a1] = "";
	} else if ($jenjangini == 6) {
		$jml_jurusan = 0;
		foreach ($dafjurusanpt as $datane) {
			$jml_jurusan++;
			$sel_jurusan[$jml_jurusan] = "";
			$id_jurusan[$jml_jurusan] = $datane->id;
			$nama_jurusan[$jml_jurusan] = $datane->nama_jurusan;
		}
		for ($a1 = 1; $a1 <= $jml_jurusan; $a1++)
			$sel_jurusan[$a1] = "";
	}

	$jml_kelas = 0;
	foreach ($dafkelas as $datane) {
		$jml_kelas++;
		$kd_kelas[$jml_kelas] = $datane->id;
		$nama_kelas[$jml_kelas] = $datane->nama_kelas;
	}

	$jml_mapel = 0;
	foreach ($dafmapel as $datane) {
		$jml_mapel++;
		$kd_mapel[$jml_mapel] = $datane->id;
		$nama_mapel[$jml_mapel] = $datane->nama_mapel;
	}

	if ($jenjangini == 6)
		$dekelas = "none";
	else
		$dekelas = "block";
}

$jml_jenjang = 0;
foreach ($dafjenjang as $datane) {
	$jml_jenjang++;
	$kd_jenjang[$jml_jenjang] = $datane->id;
	$nama_jenjang[$jml_jenjang] = $datane->nama_jenjang;
}

if (!isset($tahun))
{
	$tahun = null;
}

?>

<style>
	.maks360
	{
		margin: auto;
		max-width: 360px;
	}

	.maks500
	{
		margin: auto;
		max-width: 500px;
	}
</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css">

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
				<div class="col-lg-12">
					<h3 class="text-center">Modul Saya</h3>
				</div>

				<div style="margin-bottom: 10px;">
					<button class="btn-main"
							onclick="return kembali();">Kembali
					</button>
				</div>

				<hr>

				<center>
				<div style="text-align: center;">
					<?php
					$attributes = array('id' => 'myform');
					if ($tahun!=null) {
						echo form_open('virtualkelas/addmodul/'.$bulan.'/'.$tahun, $attributes);
					}
					else
					{
						echo form_open('virtualkelas/addmodul', $attributes);
					}
					?>
					<div>
						<div class="well bp-component">
							<fieldset>
								<div class="form-group maks360">
									<label for="inputDefault" class="col-md-12 control-label">Nama Modul</label>
									<div class="col-md-12">
										<input type="text" class="form-control" id="ipaket" name="ipaket"
											   maxlength="100"
											   value="<?php echo $namapaket; ?>" placeholder="">
										<br>
									</div>
								</div>

								<div class="form-group maks360">
									<div class="col-md-12">
										<label for="select" class="col-md-12 control-label">Jenjang</label>
										<select class="form-control" name="ijenjang" id="ijenjang">
											<option value="0">-- Pilih Jenjang --</option>
											<!--					<option value="kategori">[Ganti Pilihan ke Kategori]</option>-->
											<?php
											for ($v1 = 1; $v1 <= $jml_jenjang; $v1++) {
												if ($kd_jenjang[$v1] == $jenjangini)
													$opsi = " selected ";
												else
													$opsi = " ";
												echo '<option' . $opsi . 'value="' . $kd_jenjang[$v1] . '">' . $nama_jenjang[$v1] . '</option>';
											}
											?>
										</select>
									</div>
								</div>

								<div class="form-group maks360" id="djurusan">
									<?php
									if ($addedit == "edit" && ($jenjangini == 5 ||
											$jenjangini == 6)) { ?>
										<br>
										<label for="select" class="col-md-12 control-label">Jurusan</label>
										<div class="col-md-12">
											<select class="form-control" name="ijurusan" id="ijurusan">
												<option value="0">-- Semua Jurusan --</option>
												<?php
												if ($addedit == "edit")
													for ($bc11 = 1; $bc11 <= $jml_jurusan; $bc11++) {
														if ($id_jurusan[$bc11] == $jurusanini)
															$opsi = " selected ";
														else
															$opsi = " ";
														echo '<option' . $opsi . 'value="' . $id_jurusan[$bc11] . '">' . $nama_jurusan[$bc11] . '</option>';
													}
												?>
											</select>
										</div>
									<?php } ?>
								</div>

								<div class="form-group maks360">
									<div class="col-md-12" id="dkelas" style="display:<?php echo $dekelas; ?>;">
										<label for="select" class="col-md-12 control-label">Kelas</label>
										<select class="form-control" name="ikelas" id="ikelas">
											<option value="0">-- Pilih Kelas --</option>
											<?php
											if ($addedit == "edit")
												for ($v1 = 1; $v1 <= $jml_kelas; $v1++) {
													if ($kd_kelas[$v1] == $kelasini)
														$opsi = " selected ";
													else
														$opsi = " ";
													echo '<option' . $opsi . 'value="' . $kd_kelas[$v1] . '">' . $nama_kelas[$v1] . '</option>';
												}
											?>
										</select>
									</div>
								</div>

								<div class="form-group maks360">
									<div class="col-md-12" id="dmapel">
										<label for="select" class="col-md-12 control-label">Mata Pelajaran</label>
										<select class="form-control" name="imapel" id="imapel">
											<option value="0">-- Pilih Mapel --</option>
											<?php
											if ($addedit == "edit")
												for ($v1 = 1; $v1 <= $jml_mapel; $v1++) {
													if ($kd_mapel[$v1] == $mapelini)
														$opsi = " selected ";
													else
														$opsi = " ";
													echo '<option' . $opsi . 'value="' . $kd_mapel[$v1] . '">' . $nama_mapel[$v1] . '</option>';
												}
											?>
										</select>
									</div>
								</div>

								<div class="form-group maks360">
									<div class="col-md-12" id="dsemester">
										<label for="select" class="col-md-12 control-label">Semester</label>
										<select <?php 
											if ($referrer!="")
											echo "disabled";?> class="form-control" name="isemester" id="isemester">
											<option value="0">-- Pilih Semester --</option>
											<?php
											
												for ($v1 = 1; $v1 <= 2; $v1++) {
													if ($v1 == $semester)
														$opsi = " selected ";
													else
														$opsi = " ";
													echo '<option' . $opsi . 'value="' . $v1 . '">' . $v1 . '</option>';
													}
												

											?>
										</select>
									</div>
								</div>

								<div class="form-group maks360">
									<div class="col-md-12" id="dmapel">
										<label for="select" class="col-md-12 control-label">Modul ke: </label>
										<input <?php 
											if ($referrer!="")
											echo "disabled";?> type="text" class="form-control" id="imingguke" name="imingguke"
											   maxlength="100"
											   value="<?php echo $mingguke; ?>" placeholder="">
										<br>
									</div>
								</div>

								<div class="form-group maks360" style="display: none;">
									<label for="inputDefault" class="col-md-12 control-label">Tanggal Tayang</label>
									<div class="col-md-12">
										<input type="text" value="<?php echo $tglpaket; ?>" name="datetime"
											   id="datetime" class="form-control" readonly>
										<br>
									</div>
								</div>

								<input type="hidden" id="addedit" name="addedit"
									   value="<?php
									   if ($addedit == "edit")
										   echo 'edit'; else
										   echo 'add'; ?>"/>

								<input type="hidden" id="linklist" name="linklist" value="<?php echo $linklist;?>" />

								<div class="form-group maks500">
									<div class="col-md-10" style="margin: 20px;">

										<?php if ($addedit == "add") {?>
										<button class="btn btn-default" onclick="return kembali();">Batal</button>
										<?php } ?>
									
										<button id="tbupdate" type="submit" class="btn btn-primary" onclick="return cekaddvideo();">
											<?php
											if ($addedit == "edit")
												echo 'Lanjut'; else
												echo 'Simpan' ?>
										</button>
										<div id="keterangan" style="display:none; color:red;font-style:italic;">Tidak bisa update data, karena modul sudah ada yang menggunakan.</div>
									</div>
								</div>
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


<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
<script>

	$(document).on('change input', '#ipaket', function () {
		<?php if ($sudahdibeli==0) { ?>
			document.getElementById('tbupdate').innerText = "Update";
		<?php } else {?>
			document.getElementById('keterangan').style.display = "block";
			<?php } ?>
	});

	$(document).on('change', '#ijenjang', function () {
		$('#ijurusan').val(0);
		ambilkelas();
		ambilmapel();
		ambiljurusan();
		<?php if ($sudahdibeli==0) { ?>
			document.getElementById('tbupdate').innerText = "Update";
		<?php } else {?>
			document.getElementById('keterangan').style.display = "block";
			<?php } ?>
	});

	$(document).on('change', '#ijurusan', function () {
		ambilmapel();
		<?php if ($sudahdibeli==0) { ?>
			document.getElementById('tbupdate').innerText = "Update";
		<?php } else {?>
			document.getElementById('keterangan').style.display = "block";
			<?php } ?>
	});

	$(document).on('change', '#ikelas', function () {
		<?php if ($sudahdibeli==0) { ?>
			document.getElementById('tbupdate').innerText = "Update";
		<?php } else {?>
			document.getElementById('keterangan').style.display = "block";
			<?php } ?>
	});

	$(document).on('change', '#imapel', function () {
		<?php if ($sudahdibeli==0) { ?>
			document.getElementById('tbupdate').innerText = "Update";
		<?php } else {?>
			document.getElementById('keterangan').style.display = "block";
			<?php } ?>
	});

	$(document).on('change', '#isemester', function () {
		<?php if ($sudahdibeli==0) { ?>
			document.getElementById('tbupdate').innerText = "Update";
		<?php } else {?>
			document.getElementById('keterangan').style.display = "block";
			<?php } ?>
	});

	$(document).on('change input', '#imingguke', function () {
		<?php if ($sudahdibeli==0) { ?>
			document.getElementById('tbupdate').innerText = "Update";
		<?php } else {?>
			document.getElementById('keterangan').style.display = "block";
			<?php } ?>
	});

	function ambilkelas() {

		var jenjang = $('#ijenjang').val();

		if (jenjang == 6) {
			$('#ikelas').val(0);
			$('#dkelas').hide();
		} else {
			$('#dkelas').show();
		}

		if (jenjang == 6) {
			isihtml0 = '<label for="select" class="col-md-12 control-label">Kelas</label>';
			isihtml1 = '<select class="form-control" name="ikelas" id="ikelas">' +
				'<option value="0">-</option>';
			isihtml3 = '</select>';
			$('#dkelas').html(isihtml0 + isihtml1 + isihtml3);
		} else {
			isihtml0 = '<label for="select" class="col-md-12 control-label">Kelas</label>';
			isihtml1 = '<select class="form-control" name="ikelas" id="ikelas">' +
				'<option value="0">-- Pilih --</option>';
			isihtml3 = '</select>';
			$.ajax({
				type: 'GET',
				data: {idjenjang: $('#ijenjang').val()},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>video/daftarkelas',
				success: function (result) {
					//alert ($('#itopik').val());
					isihtml2 = "";
					$.each(result, function (i, result) {
						isihtml2 = isihtml2 + "<option value='" + result.id + "'>" + result.nama_kelas + "</option>";
					});
					$('#dkelas').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
				}
			});
		}
	}

	function ambilmapel() {
		var jenjang = $('#ijenjang').val();

		if (jenjang != 5 && jenjang != 6) {
			$('#ijurusan').val(0);
		}

		if ($('#ijurusan').val() == null)
			$('#dmapel').html("<input type='hidden' id='ijurusan' value=0 />");

		isihtmlb0 = '<label for="select" class="col-md-12 control-label">Mata Pelajaran</label>';
		isihtmlb1 = '<select class="form-control" name="imapel" id="imapel">' +
			'<option value="0">-- Pilih --</option>';
		isihtmlb3 = '</select>';
		$.ajax({
			type: 'GET',
			data: {
				idjenjang: $('#ijenjang').val(), idjurusan: $('#ijurusan').val()
			},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>video/daftarmapel',
			success: function (result) {
				var isihtmlb2 = "";
				$.each(result, function (i, result) {
					isihtmlb2 = isihtmlb2 + "<option value='" + result.id + "'>" + result.nama_mapel + "</option>";
				});
				$('#dmapel').html(isihtmlb0 + isihtmlb1 + isihtmlb2 + isihtmlb3);
			}
		});
	}

	function ambiljurusan() {
		var jenjang = $('#ijenjang').val();

		if (jenjang != 5 && jenjang != 6) {
			var isihtmld = '<input type="hidden" id="ijurusan" name="ijurusan" value=0 />';
			$('#djurusan').html(isihtmld);
		} else {
			var isihtmld0 = '<br><label for="select" class="col-md-12 control-label">Jurusan</label><div class="col-md-12">';
			var isihtmld1 = '<select class="form-control" name="ijurusan" id="ijurusan">' +
				'<option value="0">-- Semua Jurusan --</option>';
			var isihtmld3 = '</select></div>';
			$.ajax({
				type: 'GET',
				data: {idjenjang: jenjang},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>video/daftarjurusan',
				success: function (result) {
					//alert ($('#itopik').val());
					var isihtmld2 = "";
					$.each(result, function (i, result) {
						isihtmld2 = isihtmld2 + "<option value='" + result.id + "'>" + result.nama_jurusan + "</option>";
					});
					$('#djurusan').html(isihtmld0 + isihtmld1 + isihtmld2 + isihtmld3);
				}
			});
		}
	}

	function cekaddvideo() {
		cektb=document.getElementById("tbupdate").innerText;

		if (cektb=="Lanjut")
		{
			<?php if ($tahun!=null) { ?>
				window.open("<?php echo base_url().'virtualkelas/videomodul/'.$linklist.'/'.$bulan.'/'.$tahun;?>","_self");
			<?php }
			else
			{ ?>
				window.open("<?php echo base_url().'virtualkelas/videomodul/'.$linklist;?>","_self");
			<?php } ?>
			
			return false;
		} else {
			if (document.getElementById("ipaket").value == "" ||
				document.getElementById("ijenjang").value == 0 ||
				document.getElementById("imapel").value == 0 ||
				(document.getElementById("ijenjang").value != 6 && document.getElementById("ikelas").value == 0)) {
				alert("LENGKAPI ISIAN");
				return false;
			} else
			{
				document.getElementById("isemester").disabled = false;
				document.getElementById("imingguke").disabled = false;
				return true;
			}
				
		}
	}

	<?php if($referrer=="") { ?>
		function kembali() {
			window.history.back();
			return false;
		}
	<?php } else { ?>
		function kembali() {
			window.open('<?php echo base_url().'virtualkelas/event/'.$bulan.'/'.$tahun;?>','_self');
			return false;
		}
	<?php } ?>

</script>



<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>


<script>
	$("#datetime").datetimepicker({
		format: 'yyyy-mm-dd hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("form").bind("keypress", function (e) {
		if (e.keyCode == 13) {
			$("#btnSearch").attr('value');
			//add more buttons here
			e.preventDefault();
			return false;
		}
	});

</script>
