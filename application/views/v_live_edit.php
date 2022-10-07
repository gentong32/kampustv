<!--<script src='https://makitweb.com/demo/codeigniter_tinymce/resources/tinymce/tinymce.min.js'></script>-->
<script src='<?= base_url() ?>resources/tinymce/tinymce.min.js'></script>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$sellink1[1] = "";
$sellink1[2] = "";
$sellink1[3] = "";
$sellink2[1] = "";
$sellink2[2] = "";
$sellink3[1] = "";
$sellink3[2] = "";

$ceklink1 = "none";
$ceklink2 = "none";
$ceklink3 = "none";

$tglmulai = new DateTime($dafacara->tanggal_mulai);
$tglmulai = $tglmulai->format("d-m-Y H:i");
$tglselesai = new DateTime($dafacara->tanggal_selesai);
$tglselesai = $tglselesai->format("d-m-Y H:i");

$link1 = $dafacara->link1;
$link2 = $dafacara->link2;
$link3 = $dafacara->link3;

$tekslink1 = $dafacara->tekslink1;
$tekslink2 = $dafacara->tekslink2;
$tekslink3 = $dafacara->tekslink3;
//echo "<br><br><br><br>".$link1;
//die();

if ($link1 == "")
	$sellink1[1] = 'selected';
else if (substr($link1, 0, 4) == "http" || substr($link1, 0, 3) == "www") {
	$sellink1[3] = 'selected';
	$ceklink1 = "block";
} else
{
	$sellink1[2] = 'selected';
	$ceklink1 = "block";
}

if ($link2 == "") {
	$sellink2[1] = 'selected';
} else
{
	$sellink2[2] = 'selected';
	$ceklink2 = "block";
}

if ($link3 == "") {
	$sellink3[1] = 'selected';
	$ceklink3 = "none";
} else {
	$sellink3[2] = 'selected';
	$ceklink3 = "block";
}


$jmlevent = 0;
foreach ($dafevent as $datane) {
	$jmlevent++;
	$kodeevent[$jmlevent] = $datane->code_event;
	$linkevent[$jmlevent] = $datane->link_event;
	$selevent1[$jmlevent] = "";
	$selevent2[$jmlevent] = "";
	$selevent3[$jmlevent] = "";
	if ($link1 == $datane->link_event) {
		$selevent1[$jmlevent] = "selected";
		$link1 = "";
	}

	$namaevent[$jmlevent] = $datane->nama_event;
}

?>

<div class="container" style="color:black;margin-top: 60px; max-width: 900px">
	<center><span style="font-size:20px;font-weight:Bold;">SETING LIVE</span></center>
	<!---->
	<div style="text-align: center;margin: auto">
		<button id="tbkembali" class="btn btn-primary"
				onclick="window.open('<?php echo base_url(); ?>seting/url_live','_self')">Kembali
		</button>
	</div>


	<div class="form-group" style="margin-top: 10px">
		<label for="inputDefault" class="col-md-12 control-label">Tanggal Awal Event Tampil</label>
		<div class="col-md-12">
			<input type="text" value="<?php echo $tglmulai; ?>" name="datetime" id="datetime"
				   class="form-control" style="width: 160px" readonly>
		</div>
	</div>

	<div class="form-group" style="margin-top: 10px; margin-bottom: 20px;">
		<label for="inputDefault" class="col-md-12 control-label">Tanggal Selesai Event Tampil</label>
		<div class="col-md-12">
			<input type="text" value="<?php echo $tglselesai; ?>" name="datetime2" id="datetime2"
				   class="form-control" style="width: 160px" readonly>
		</div>
	</div>


	<div class="row" style="padding-top: 20px;">
		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Tombol 1 </label>
			<div class="col-md-12" style="padding-bottom:10px;width: 200px">
				<select class="form-control" name="iadalink1" id="iadalink1">
					<option <?php echo $sellink1[1]; ?> value="0">Tidak Ada</option>
					<option <?php echo $sellink1[2]; ?> value="1">Link ke Event</option>
					<option <?php echo $sellink1[3]; ?> value="2">Link ke URL</option>
				</select>

				<div id="inputlink1" class="form-group"
					 style="display:<?php echo $ceklink1; ?>;margin-left: 5px;margin-top: 5px;">
					<div class="col-md-12" style="padding-bottom:0px;width: 290px">
						Judul Tombol: <input style="width: 250px;" type="text" name="tevt" id="tevt" maxlength="100"
											 value="<?php echo $tekslink1; ?>">
						<select class="form-control" name="ievent" id="ievent">
							<option value="">-- Pilih Event --</option>
							<?php
							for ($a = 1; $a <= $jmlevent; $a++) {
								?>
								<option <?php echo $selevent1[$a]; ?> value="<?php
								echo $linkevent[$a]; ?>"><?php
									echo $namaevent[$a]; ?></option>
								<?php
							}
							?>
						</select>
					</div>
				</div>

				<div id="inputlink1b" class="form-group" style="display:none;margin-left: 5px;margin-top: 5px;">
					Judul Tombol: <input style="width: 250px;" type="text" name="turl1" id="turl1" maxlength="100"
						   value="<?php echo $tekslink1; ?>">
					Alamat URL: <input style="width: 250px;" type="text" name="url1" id="url1" maxlength="100"
						   value="<?php echo $link1; ?>">
				</div>

			</div>

		</div>

	</div>

	<div class="row">
		<div class="form-group" style="margin-top: 10px;">
			<label for="inputDefault" class="col-md-12 control-label">Tombol 2 </label>
			<div class="col-md-12" style="padding-bottom:10px;width: 200px">
				<select class="form-control" name="iadalink2" id="iadalink2">
					<option <?php echo $sellink2[1]; ?> value="0">Tidak Ada</option>
					<option <?php echo $sellink2[2]; ?> value="1">Link ke URL</option>
				</select>

				<div id="inputlink2" class="form-group"
					 style="display:<?php echo $ceklink2; ?>;margin-left: 5px;margin-top: 5px;">
					Judul Tombol: <input style="width: 250px;" type="text" name="turl2" id="turl2" maxlength="100"
										 value="<?php echo $tekslink2; ?>">
					Alamat URL: <input style="width: 250px;" type="text" name="url2" id="url2" maxlength="100"
						   value="<?php echo $link2; ?>">
				</div>

			</div>

		</div>

	</div>

	<div class="row">
		<div class="form-group" style="margin-top: 10px;">
			<label for="inputDefault" class="col-md-12 control-label">Tombol 3 </label>
			<div class="col-md-12" style="padding-bottom:10px;width: 200px">
				<select class="form-control" name="iadalink3" id="iadalink3">
					<option <?php echo $sellink3[1]; ?> value="0">Tidak Ada</option>
					<option <?php echo $sellink3[2]; ?> value="1">Link ke URL</option>
				</select>

				<div id="inputlink3" class="form-group"
					 style="display:<?php echo $ceklink3; ?>;margin-left: 5px;margin-top: 5px;">
					Judul Tombol: <input style="width: 250px;" type="text" name="turl3" id="turl3" maxlength="100"
										 value="<?php echo $tekslink3; ?>">
					Alamat URL: <input style="width: 250px;" type="text" name="url3" id="url3" maxlength="100"
						   value="<?php echo $link3; ?>">
				</div>

			</div>

		</div>
	</div>

	<div>
		<div id="tbupdate" style="display:none;margin-bottom: 20px;">
			<button onclick="diupdate();">Update</button>
		</div>
	</div>

</div>

<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url('ckeditor/ckeditor.js'); ?>"></script>
<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>

<script>

	$("#iadalink1").change(function () {
		if ($("#iadalink1").val() == 1) {
			document.getElementById('inputlink1').style.display = 'block';
			document.getElementById('inputlink1b').style.display = 'none';
		} else if ($("#iadalink1").val() == 2) {
			document.getElementById('inputlink1').style.display = 'none';
			document.getElementById('inputlink1b').style.display = 'block';
		} else {
			document.getElementById('inputlink1').style.display = 'none';
			document.getElementById('inputlink1b').style.display = 'none';
		}
		document.getElementById('tbupdate').style.display = 'block';

	});

	$("#iadalink2").change(function () {
		if ($("#iadalink2").val() == 1) {
			document.getElementById('inputlink2').style.display = 'block';
		} else {
			document.getElementById('inputlink2').style.display = 'none';
		}
		document.getElementById('tbupdate').style.display = 'block';

	});

	$("#iadalink3").change(function () {
		if ($("#iadalink3").val() == 1) {
			document.getElementById('inputlink3').style.display = 'block';
		} else {
			document.getElementById('inputlink3').style.display = 'none';
		}
		document.getElementById('tbupdate').style.display = 'block';

	});

	$("#datetime").change(function () {
		document.getElementById('tbupdate').style.display = 'block';
	});

	$("#datetime2").change(function () {
		document.getElementById('tbupdate').style.display = 'block';
	});

	$("#datetime").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		// minView: 2,
		autoclose: true,
		todayBtn: true
	});

	$("#datetime2").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		// minView: 2,
		autoclose: true,
		todayBtn: true
	});

	$('#turl1').on('change input', function () {
		document.getElementById('tbupdate').style.display = 'block';
	});
	$('#turl2').on('change input', function () {
		document.getElementById('tbupdate').style.display = 'block';
	});
	$('#turl3').on('change input', function () {
		document.getElementById('tbupdate').style.display = 'block';
	});

	$('#ievent').on('change input', function () {
		document.getElementById('tbupdate').style.display = 'block';
	});

	$('#url1').on('change input', function () {
		document.getElementById('tbupdate').style.display = 'block';
	});
	$('#url2').on('change input', function () {
		document.getElementById('tbupdate').style.display = 'block';
	});
	$('#url3').on('change input', function () {
		document.getElementById('tbupdate').style.display = 'block';
	});

	$('#tevt').on('change input', function () {
		document.getElementById('tbupdate').style.display = 'block';
	});

	function diupdate() {

		turl1 = $("#turl1").val();
		turl2 = $("#turl2").val();
		turl3 = $("#turl3").val();

		// alert ($("#datetime").val());

		if ($("#iadalink1").val() == 1) {
			isiurl1 = $("#ievent").val();
			turl1 = $("#tevt").val();
		} else if ($("#iadalink1").val() == 2) {
			isiurl1 = $("#url1").val();
		} else {
			isiurl1 = "";
		}

		if ($("#iadalink2").val() == 1) {
			isiurl2 = $("#url2").val();
		} else {
			isiurl2 = "";
		}

		if ($("#iadalink3").val() == 1) {
			isiurl3 = $("#url3").val();
		} else {
			isiurl3 = "";
		}

		$.ajax({
			url: '<?php echo base_url(); ?>seting/updateliveseting',
			type: "post",
			data: {isiurl1: isiurl1, isiurl2: isiurl2, isiurl3: isiurl3,
				turl1: turl1, turl2: turl2, turl3: turl3,
				tglmulai: $("#datetime").val(), tglselesai: $("#datetime2").val()},
			cache: false,
			success: function (data) {
				document.getElementById('tbupdate').style.display = 'none';
			}
		});
	}

</script>
