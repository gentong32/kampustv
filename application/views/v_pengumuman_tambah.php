<!--<script src='https://makitweb.com/demo/codeigniter_tinymce/resources/tinymce/tinymce.min.js'></script>-->
<script src='<?= base_url() ?>resources/tinymce/tinymce.min.js'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css">

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$selfile[1] = "";
$selfile[2] = "";

$selurl[1] = "";
$selurl[2] = "";

if ($addedit == "add") {
	$tnamaevent = "";
	$tisievent = "";
	date_default_timezone_set('Asia/Jakarta');
	$cekreadonly = "";
	$cekdisplay = "inline";
	$cekdisabled = "";
	$tglmulai = new DateTime();
	$tglmulai = $tglmulai->format("d-m-Y");
	$tglselesai = new DateTime();
	$tglselesai = $tglselesai->format("d-m-Y");
	$iuran = "50000";
	$linkurl = "";
	$tombolurl = "";


} else {
	$tnamaevent = $datapengumuman[0]->nama_pengumuman;
	$tisievent = $datapengumuman[0]->isi_pengumuman;
	$tglmulai = new DateTime($datapengumuman[0]->tgl_mulai);
	$tglmulai = $tglmulai->format("d-m-Y");
	$tglselesai = new DateTime($datapengumuman[0]->tgl_selesai);
	$tglselesai = $tglselesai->format("d-m-Y");
	$foto = $datapengumuman[0]->gambar;
	$linkurl = $datapengumuman[0]->url;
	$tombolurl = $datapengumuman[0]->tombolurl;
	if ($tombolurl == "") {
		$selurl[1] = "selected";
		$selurl[2] = "";
	} else {
		$selurl[1] = "";
		$selurl[2] = "selected";
	}
	$cekfile = $datapengumuman[0]->file;
	if ($cekfile == "") {
		$selfile[1] = "selected";
		$selfile[2] = "";
	} else {
		$selfile[1] = "";
		$selfile[2] = "selected";
	}
	$cekreadonly = " readonly ";
	$cekdisplay = "none";
	$cekdisabled = "disabled";

}


?>

<div class="container" style="color:black;margin-top: 60px; max-width: 900px">
	<center><span style="font-size:20px;font-weight:Bold;"><?php echo $title; ?></span></center>
	<!---->
	<div style="text-align: center;margin: auto">
		<?php
		if ($addedit == "edit") {
			?>
			<button onclick="return diedit()" id="tbedit" class="btn btn-primary">Edit</button>
		<?php } ?>
		<button id="tbkembali" class="btn btn-primary"
				onclick="window.open('<?php echo base_url(); ?>informasi/daftarpengumuman','_self')"><?php
			if ($addedit == "edit") echo 'Kembali'; else echo 'Batal';
			?></button>
	</div>


	<div class="row">
		<?php
		$attributes = array('id' => 'myform1');
		echo form_open('informasi/updatepengumuman/' . $code_pengumuman, $attributes);
		?>

		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">Judul Pengumuman:</label>
			<div class="col-md-12" style="padding-bottom:10px">
				<input <?php echo $cekreadonly; ?>
					style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
				echo $tnamaevent; ?>" class="form-control" id="inamaevent" name="inamaevent" maxlength="50">
			</div>
		</div>

		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Tanggal Dipasang Mulai</label>
			<div class="col-md-12">
				<input type="text" value="<?php echo $tglmulai; ?>" name="datetime" id="datetime"
					   class="form-control" style="width: 100px" readonly>
				<br>
			</div>
		</div>

		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Tanggal Dipasang Selesai</label>
			<div class="col-md-12">
				<input type="text" value="<?php echo $tglselesai; ?>" name="datetime2" id="datetime2"
					   class="form-control" style="width: 100px" readonly>
				<br>
			</div>
		</div>


		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">Isi Pengumuman:</label>
			<div class="col-md-12" style="padding-bottom:10px">
                <textarea <?php echo $cekreadonly; ?> style="max-width:800px;width:100%;height:300px;margin:0;padding:0"
													  type="text"
													  class="ckeditor" id="iisievent" name="iisievent"
													  maxlength="1000"><?php echo $tisievent; ?></textarea>
			</div>
		</div>

		<input type="hidden" id="addedit" name="addedit" value="<?php echo $addedit; ?>"/>
		<input type="hidden" id="adafile" name="adafile"/>
		<input type="hidden" id="adaurl" name="adaurl"/>
		<input type="hidden" id="linkurl" name="linkurl"/>
		<input type="hidden" id="tombolurl" name="tombolurl"/>
		<input type="hidden" id="nmgambar" name="nmgambar"/>
		<input type="hidden" id="nmfile" name="nmfile"/>


		<?php
		echo form_close() . '';
		?>

		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Gambar Pengumuman</label>
			<div style="margin-left:32px;width: 300px;height: auto;">
				<?php
				if ($addedit == "add")
					$foto = base_url() . "assets/images/blankev.jpg";
				else if (substr($foto, 0, 4) != "http") {
					$foto = base_url() . "uploads/pengumuman/" . $foto;
				}

				?>
				<table style="margin-left:0px; width:220px;border: 1px solid black;">
					<tr>
						<th>
							<img id="previewing" width="300px" src="<?php echo $foto; ?>">
						</th>
					</tr>
				</table>
			</div>
			<h4 style="display: none;" id='loading'>uploading ... </h4>

		</div>

		<form class="form-horizontal" id="submit" style="display:<?php echo $cekdisplay; ?>;">
			<div class="form-group" style="margin-left: 30px">
				<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
				<input style="display:inline;margin-left: 20px;" type="file" name="file" id="file1" accept="image/*">
				<input type="hidden" id="fotoaddedit" name="fotoaddedit" value="<?php echo $addedit; ?>">
				<br>
				<button style="display:inline-block;margin-left: 20px;" id="btn_upload" type="submit">Terapkan</button>
				<div class="progress" style="display:none">
					<div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar"
						 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span class="sr-only">0%</span>
					</div>
				</div>
				<span style="margin-left: 30px" id="message"></span>
			</div>
		</form>

		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">File lampiran</label>
			<div class="col-md-12" style="padding-bottom:10px;width: 100%">
				<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadafile" id="iadafile">
					<option <?php echo $selfile[1]; ?> value="0">Tidak Ada</option>
					<option <?php echo $selfile[2]; ?> value="1">Ada</option>
				</select>

			</div>
		</div>

		<form class="form-horizontal" id="submitdok" style="display: <?php
		if ($selfile[2] == 'selected')
			echo 'none';
		else echo 'none';
		?>">
			<div class="form-group" style="margin-left: 5px">
				<div class="col-md-12" style="padding-bottom:10px;width: 100%">
					<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
					<input style="width:200px;display:block;margin-left: 20px;" type="file" name="file" id="file2"
						   accept="application/pdf">
					<input type="hidden" id="dokaddedit" name="dokaddedit" value="<?php echo $addedit; ?>">
					<button style="display:block;margin-left: 20px;" id="btn_uploaddok" type="submit">Upload</button>
					<span style="wimargin-left: 30px" id="message2"></span>
				</div>
			</div>
		</form>

		<div class="form-group" style="margin-top: 0px;">
			<label for="inputDefault" class="col-md-12 control-label">Link URL</label>
			<div class="col-md-12" style="padding-bottom:5px;width: 100%">
				<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadaurl" id="iadaurl">
					<option <?php echo $selurl[1]; ?> value="0">Tidak Ada</option>
					<option <?php echo $selurl[2]; ?> value="1">Ada</option>
				</select>
			</div>

		</div>

		<form id="inputurl" style="display:none;">
			<div class="form-group" style="margin-left: 5px">
				<div class="col-md-12" style="padding-bottom:10px;width: 200px">
					<label for="inputDefault" class="col-md-12 control-label">Alamat Link URL</label>
					<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
					echo $linkurl; ?>" class="form-control" id="ilinkurl" name="ilinkurl" maxlength="250">
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 200px">
					<label for="inputDefault" class="col-md-12 control-label">Tombol URL</label>
					<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
					echo $tombolurl; ?>" class="form-control" id="itombolurl" name="itombolurl" maxlength="25">
				</div>
			</div>
		</form>


		<div class="form-group">
			<div class="col-md-10 col-md-offset-0" style="margin-bottom:20px"><br>
				<button style="display: none;" id="tbbatal" class="btn btn-default" onclick="return gaksido()">Batal
				</button>
				<button style="display: none;" id="tbupdate" type="submit" class="btn btn-primary"
						onclick="return cekupdate()">Update
				</button>
				<?php if ($addedit == "add") { ?>
					<button style="display: block;" id="tbupdate" type="submit" class="btn btn-primary"
							onclick="return cekupdate()">Submit
					</button>
				<?php } ?>
			</div>
		</div>

	</div>
</div>

<!-- echo form_open('dasboranalisis/update'); -->

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script src="<?php echo base_url('ckeditor/ckeditor.js'); ?>"></script>


<script>


	//alert ("cew");
	$(function () {
		$("#file1").change(function () {
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match = ["image/jpeg", "image/png", "image/jpg"];
			if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
				// $('#previewing').attr('src','noimage.png');
				$("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			} else {
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}
		});
	});


	function imageIsLoaded(e) {
		$("#file1").css("color", "green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '300px');
		$('#previewing').attr('height', 'auto');
	};

	$(document).ready(function () {
		<?php if ($addedit == "edit") {?>
		$("#message").html("Foto siap digunakan");
		<?php } ?>
		<?php if($selfile[2] == "selected") {?>
		$("#message2").html("Dokumen siap");
		<?php } ?>

		$('#submit').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>informasi/upload_foto_pengumuman/<?php echo $code_pengumuman;?>',
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

		$('#submitdok').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>informasi/upload_dok/<?php echo $code_pengumuman;?>',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading').hide();
					$("#message2").html(data);
				}
			});
		});


	});

	$("#iadafile").change(function () {
		if ($("#iadafile").val() == 1)
			document.getElementById('submitdok').style.display = 'block';
		else
			document.getElementById('submitdok').style.display = 'none';
	});

	$("#iadaurl").change(function () {
		if ($("#iadaurl").val() == 1)
			document.getElementById('inputurl').style.display = 'block';
		else
			document.getElementById('inputurl').style.display = 'none';
	});

	function diedit() {
		document.getElementById('inamaevent').readOnly = false;
		document.getElementById('iadafile').disabled = false;
		document.getElementById('iadaurl').disabled = false;
		document.getElementById('tbedit').style.display = 'none';
		document.getElementById('tbkembali').style.display = 'none';
		document.getElementById('tbbatal').style.display = 'inline';
		document.getElementById('tbupdate').style.display = 'inline';
		document.getElementById('submit').style.display = 'inline';
		document.getElementById('btn_upload').style.display = 'inline';
		if ($("#iadafile").val() == 1)
			document.getElementById('submitdok').style.display = 'block';
		if ($("#iadaurl").val() == 1)
		document.getElementById('inputurl').style.display = 'block';
		CKEDITOR.instances['iisievent'].setReadOnly(false);
		return false;
	}

	function gaksido() {
		document.getElementById('inamaevent').readOnly = true;
		document.getElementById('iadafile').disabled = true;
		document.getElementById('iadaurl').disabled = true;
		document.getElementById('tbedit').style.display = 'inline';
		document.getElementById('tbkembali').style.display = 'inline';
		document.getElementById('tbbatal').style.display = 'none';
		document.getElementById('tbupdate').style.display = 'none';
		document.getElementById('submit').style.display = 'none';
		document.getElementById('submitdok').style.display = 'none';
		document.getElementById('btn_upload').style.display = 'none';
		CKEDITOR.instances['iisievent'].setReadOnly(true);
		return false;
	}

	function cekupdate() {
		var oke;
		if ($('#file1').val() == "")
			$('#nmgambar').val("");
		else
			$('#nmgambar').val($('#file1').val().substring($('#file1').val().lastIndexOf(".") + 1));
		if ($('#file2').val() == "")
			$('#nmfile').val("");
		else
			$('#nmfile').val($('#file2').val().substring($('#file2').val().lastIndexOf(".") + 1));
		$('#adafile').val($('#iadafile').val());
		$('#adaurl').val($('#iadaurl').val());
		$('#linkurl').val($('#ilinkurl').val());
		$('#tombolurl').val($('#itombolurl').val());

		if ($('#inamaevent').val() == "" || CKEDITOR.instances['iisievent'].getData() == "" ||
			($("#message").html() != 'Foto siap digunakan' && $("#message").html() != 'Foto berhasil diubah')) {
			oke = false;
		} else {
			oke = true;
		}
		// $('#adafile').val($('#iadafile').val());

		if (oke == true) {
			$('#myform1').submit();
			return true;
		} else {

			alert('Nama Event, Isi Event, dan Foto harus dilengkapi!!!');
			return false;
		}
	}

</script>


<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>


<script>

	// $.fn.datetimepicker.dates['en'] = {
	// 	days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
	// 	daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
	// 	daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
	// 	months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
	// 	monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	// 	today: "Today"
	// };

	$("#datetime").datetimepicker({
		format: 'dd-mm-yyyy',
		minView: 2,
		autoclose: true,
		todayBtn: true
	});

	$("#datetime2").datetimepicker({
		format: 'dd-mm-yyyy',
		minView: 2,
		autoclose: true,
		todayBtn: true
	});
</script>
