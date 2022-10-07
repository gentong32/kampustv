<!--<script src='https://makitweb.com/demo/codeigniter_tinymce/resources/tinymce/tinymce.min.js'></script>-->
<script src='<?= base_url() ?>resources/tinymce/tinymce.min.js'></script>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$selfile[1] = "";
$selfile[2] = "";
$sellink[1] = "";
$sellink[2] = "";

if ($addedit == "add") {
	$tjudul = "";
	$tsubjudul = "";
	$gambar = "";
	$gambarb = "";
	$tisipromo = "";
	$kdpromo = "";
	$idpromo = 0;
	$cekreadonly = "";
	$cekdisplay = "inline";
	$cekdisabled = "";
} else {
	$tjudul = $dafpromo['judul'];
	$tsubjudul = $dafpromo['subjudul'];
	$gambar = $dafpromo['gambar'];
	$gambarb = $dafpromo['gambar2'];
	$tisipromo = $dafpromo['isipromo'];
	$kdpromo = $dafpromo['kd_promo'];
	$idpromo = $dafpromo["id"];
	if ($dafpromo['nama_file'] == null || $dafpromo['nama_file'] == "")
		$selfile[1] = 'selected';
	else
		$selfile[2] = 'selected';
	if ($dafpromo['link'] == null || $dafpromo['link'] == "")
		$sellink[1] = 'selected';
	else
		$sellink[2] = 'selected';
	$cekreadonly = " readonly ";
	$cekdisplay = "none";
	$cekdisabled = "disabled";
}

$jmlevent=0;
foreach ($dafevent as $datane)
{
	$jmlevent++;
	$kodeevent[$jmlevent] = $datane->code_event;
	$linkevent[$jmlevent] = $datane->link_event;
	$selevent[$jmlevent] = "";
	if ($addedit=="edit") {
		if ($dafpromo['link'] == $datane->link_event) {
			$selevent[$jmlevent] = "selected";
		}
	}
	$namaevent[$jmlevent] = $datane->nama_event;
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
				onclick="window.open('<?php echo base_url(); ?>promo','_self')"><?php
			if ($addedit == "edit") echo 'Kembali'; else echo 'Batal';
			?></button>
	</div>


	<div class="row">
		<?php
		$attributes = array('id' => 'myform1');
		echo form_open('promo/updatepromo/' . $idpromo, $attributes);
		?>

		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">Judul Promo:</label>
			<div class="col-md-12" style="padding-bottom:10px">
                <textarea <?php echo $cekreadonly; ?> style="max-width:400px;width:100%;height:auto;margin:0;padding:0"
													  type="text"
													  class="form-control" id="ijudul" name="ijudul"
													  maxlength="100"><?php echo $tjudul; ?></textarea>
			</div>
		</div>

		<!--		<div class="form-group" style="margin-top: 30px;">-->
		<!--			<label for="inputDefault" class="col-md-12 control-label">Sub Judul Promo:</label>-->
		<!--			<div class="col-md-12" style="padding-bottom:10px">-->
		<!--                <textarea -->
		<?php //echo $cekreadonly; ?><!-- style="max-width:800px;width:100%;height:auto;margin:0;padding:0"-->
		<!--													  type="text"-->
		<!--													  class="form-control" id="isubjudul" name="isubjudul"-->
		<!--													  maxlength="100">-->
		<?php //echo $tsubjudul; ?><!--</textarea>-->
		<!--			</div>-->
		<!--		</div>-->


		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">Isi Promo:</label>
			<div class="col-md-12" style="padding-bottom:10px">
                <textarea <?php echo $cekreadonly; ?> style="max-width:800px;width:100%;height:300px;margin:0;padding:0"
													  type="text"
													  class="ckeditor" id="iisipromo" name="iisipromo"
													  maxlength="1000"><?php echo $tisipromo; ?></textarea>
			</div>
		</div>

		<input type="hidden" id="addedit" name="addedit" value="<?php echo $addedit; ?>"/>
		<input type="hidden" id="adafile" name="adafile"/>
		<input type="hidden" id="adalink" name="adalink"/>
		<input type="hidden" id="linkevent" name="linkevent"/>
		<input type="hidden" id="filedok" name="filedok"/>

		<?php
		echo form_close() . '';
		?>

		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Foto Promo Desktop</label>
			<div style="margin-left:25px;width: 300px;height: auto;">
				<?php
				$foto = $gambar;
				if ($foto == "")
					$foto = base_url() . "assets/images/profil_blank.jpg";
				else {
					$foto = base_url() . "uploads/promo/" . $foto;
				}

				?>
				<table style="margin-left:0px; min-width:150px;border: 1px solid black;">
					<tr>
						<th>
							<img id="previewing" height="110px" width="275px" src="<?php echo $foto; ?>">
						</th>
					</tr>
				</table>
			</div>
			<h4 style="display: none;" id='loading'>uploading ... </h4>

		</div>

		<form class="form-horizontal" id="submit" style="display:<?php echo $cekdisplay; ?>;">
			<div class="form-group" style="margin-left: 5px">
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

		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Foto Promo Mobile</label>
			<div style="margin-left:25px;width: 300px;height: auto;">
				<?php
				$fotob = $gambarb;
				if ($fotob == "")
					$fotob = base_url() . "assets/images/profil_blank.jpg";
				else {
					$fotob = base_url() . "uploads/promo/" . $fotob;
				}

				?>
				<table style="margin-left:0px; min-width:100px;border: 1px solid black;">
					<tr>
						<th>
							<img id="previewingb" height="100px" width="100px" src="<?php echo $fotob; ?>">
						</th>
					</tr>
				</table>
			</div>
			<h4 style="display: none;" id='loadingb'>uploading ... </h4>

		</div>

		<form class="form-horizontal" id="submitb" style="display:<?php echo $cekdisplay; ?>;">
			<div class="form-group" style="margin-left: 5px">
				<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
				<input style="display:inline;margin-left: 20px;" type="file" name="file" id="file1b" accept="image/*">
				<input type="hidden" id="fotoaddeditb" name="fotoaddeditb" value="<?php echo $addedit; ?>">
				<br>
				<button style="display:inline-block;margin-left: 20px;" id="btn_uploadb" type="submit">Terapkan</button>
				<div class="progress" style="display:none">
					<div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar"
						 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span class="sr-only">0%</span>
					</div>
				</div>
				<span style="margin-left: 30px" id="messageb"></span>
			</div>
		</form>

		<div class="form-group" style="margin-top: 10px;width: 100%">
			<label for="inputDefault" class="col-md-12 control-label">File lampiran</label>
			<div class="col-md-12" style="padding-bottom:0px;width: 200px">
				<select <?php echo $cekdisabled; ?> class="form-control" name="iadafile" id="iadafile">
					<option <?php echo $selfile[1]; ?> value="0">Tidak Ada</option>
					<option <?php echo $selfile[2]; ?> value="1">Ada</option>
				</select>

				<form class="form-horizontal" id="submitdok" style="margin-top: 5px;display: <?php
				if ($selfile[2] == 'selected')
					echo 'none';
				else echo 'none';
				?>">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:0px;width: 200px">
							<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
							<input style="display:block;margin-left: 0px;" type="file" name="file" id="file"
								   accept="application/pdf">
							<button style="display:block;margin-left: 0px;" id="btn_uploaddok" type="submit">Upload
							</button>
							<span style="margin-left: 5px" id="message2"></span>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="form-group" style="margin-top: 10px;">
			<label for="inputDefault" class="col-md-12 control-label">Link ke menu Event?</label>
			<div class="col-md-12" style="padding-bottom:10px;width: 200px">
				<select <?php echo $cekdisabled; ?> class="form-control" name="iadalink" id="iadalink">
					<option <?php echo $sellink[1]; ?> value="0">Tidak</option>
					<option <?php echo $sellink[2]; ?> value="1">Ya</option>
				</select>

				<div id="inputlink" class="form-group" style="display:none;margin-left: 5px;margin-top: 5px;">
					<div class="col-md-12" style="padding-bottom:0px;width: 290px">
						<select class="form-control" name="ievent" id="ievent">
							<option value="">-- Pilih Event --</option>
							<?php
							for ($a=1;$a<=$jmlevent;$a++)
							{
								?>
								<option <?php echo $selevent[$a]; ?> value="<?php
								echo $linkevent[$a];?>"><?php
									echo $namaevent[$a];?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>

			</div>
		</div>


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

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>
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
				$("#message").html("<p id='error'>Pilih file gambar.</p>" + "<h4>Note</h4>" + "<span id='error_message'>Khusus file tipe jpeg, jpg, and png yang diperbolehkan</span>");
				return false;
			} else {
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}
		});
	});

	$(function () {
		$("#file1b").change(function () {
			$("#messageb").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match = ["image/jpeg", "image/png", "image/jpg"];
			if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
				// $('#previewing').attr('src','noimage.png');
				$("#messageb").html("<p id='error'>Pilih file gambar.</p>" + "<h4>Note</h4>" + "<span id='error_message'>Khusus file tipe jpeg, jpg, and png yang diperbolehkan</span>");
				return false;
			} else {
				var reader = new FileReader();
				reader.onload = imageIsLoadedb;
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

	function imageIsLoadedb(e) {
		$("#file1b").css("color", "green");
		$('#image_previewb').css("display", "block");
		$('#previewingb').attr('src', e.target.result);
		$('#previewingb').attr('width', '100px');
		$('#previewingb').attr('height', '100px');
	};

	$(document).ready(function () {

		$('#submit').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>promo/upload_foto_promo/<?php echo $idpromo;?>',
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

		$('#submitb').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>promo/upload_foto_promob/<?php echo $idpromo;?>',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loadingb').hide();
					$("#messageb").html(data);
				}
			});
		});

		$('#submitdok').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>promo/upload_dok/<?php echo $idpromo;?>',
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

	function diedit() {
		document.getElementById('ijudul').readOnly = false;
		// document.getElementById('isubjudul').readOnly = false;
		document.getElementById('iadafile').disabled = false;
		document.getElementById('iadalink').disabled = false;
		document.getElementById('tbedit').style.display = 'none';
		document.getElementById('tbkembali').style.display = 'none';
		document.getElementById('tbbatal').style.display = 'inline';
		document.getElementById('tbupdate').style.display = 'inline';
		document.getElementById('submit').style.display = 'inline';
		document.getElementById('submitb').style.display = 'inline';
		//document.getElementById('btn_upload').style.display = 'inline';
		CKEDITOR.instances['iisipromo'].setReadOnly(false);
		if ($('#iadafile').val() == 1)
			document.getElementById('submitdok').style.display = 'block';
		if ($('#iadalink').val() == 1)
			document.getElementById('inputlink').style.display = 'block';
		return false;
	}

	$("#iadalink").change(function () {
		if ($("#iadalink").val() == 1)
			document.getElementById('inputlink').style.display = 'block';
		else
			document.getElementById('inputlink').style.display = 'none';
	});

	function gaksido() {
		document.getElementById('ijudul').readOnly = true;
		// document.getElementById('isubjudul').readOnly = true;
		document.getElementById('iadafile').disabled = true;
		document.getElementById('iadalink').disabled = true;
		document.getElementById('tbedit').style.display = 'inline';
		document.getElementById('tbkembali').style.display = 'inline';
		document.getElementById('tbbatal').style.display = 'none';
		document.getElementById('tbupdate').style.display = 'none';
		document.getElementById('submit').style.display = 'none';
		document.getElementById('submitb').style.display = 'none';
		document.getElementById('submitdok').style.display = 'none';
		//document.getElementById('btn_upload').style.display = 'none';
		CKEDITOR.instances['iisipromo'].setReadOnly(true);
		return false;
	}

	function cekupdate() {
		var oke;

		if ($('#ijudul').val() == "" || CKEDITOR.instances['iisipromo'].getData() == "") {
			oke = false;
		} else {
			oke = true;
		}
		<?php if ($foto == "" || $fotob == "") {
		echo "oke = false;<br> ";
	}?>

		if (($('#file1').val() != "" && $('#message').html() == "") ||
			($('#file1b').val() != "" && $('#messageb').html() == "")) {
			alert("Perubahan gambar belum di 'Terapkan'");
			return false;
		}


		$('#adafile').val($('#iadafile').val());
		$('#adalink').val($('#iadalink').val());
		$('#linkevent').val($('#ievent').val());


		if (oke == true) {
			$('#myform1').submit();
			return true;
		} else {

			alert('Judul, Isi, dan Foto harus diisi!!!');
			return false;
		}
	}


</script>
