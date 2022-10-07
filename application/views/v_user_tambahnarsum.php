<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ($addedit == "add") {
	$tnama = "";
	$tsekolah = "";
	$temail = "";
	$cekreadonly = "";

} else {
	$tnamaevent = $dataevent[0]->nama_event;
	$tnama = $dataevent[0]->nama_event;
	$tsekolah = "";
	$temail = "";
	$cekreadonly = "readonly";
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
				onclick="window.open('<?php echo base_url(); ?>user/narsum','_self')"><?php
			if ($addedit == "edit") echo 'Kembali'; else echo 'Batal';
			?></button>
	</div>


	<div class="row">
		<?php
		$attributes = array('id' => 'myform1');
		echo form_open('user/updateuser', $attributes);
		?>

		<div class="form-group" style="margin-top: 10px">
			<label for="inputDefault" class="col-md-12 control-label">Nama Lengkap</label>
			<div class="col-md-12" style="padding-bottom:10px">
				<input <?php echo $cekreadonly; ?>
					style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
				echo $tnamalengkap; ?>" class="form-control" placeholder="Nama lengkap" id="inamalengkap" name="inamalengkap" maxlength="50">
			</div>
		</div>

		<div class="form-group" style="margin-top: 10px;display: none">
			<label for="inputDefault" class="col-md-12 control-label">Sekolah/Instansi</label>
			<div class="col-md-12" style="padding-bottom:10px">
				<input <?php echo $cekreadonly; ?>
					style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
				echo $tasal; ?>" class="form-control" placeholder="Sekolah/Instansi" id="iasal" name="iasal" maxlength="50">
			</div>
		</div>

		<div class="form-group" style="margin-top: 10px">
			<label for="inputDefault" class="col-md-12 control-label">Pekerjaan</label>
			<div class="col-md-12" style="padding-bottom:10px">
				<input <?php echo $cekreadonly; ?>
					style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
				echo $tpekerjaan; ?>" class="form-control" placeholder="Pekerjaan" id="ikerja" name="ikerja" maxlength="50">
			</div>
		</div>

		<div class="form-group" id="dpropinsi">
			<label for="select"
				   class="col-md-12 control-label">Propinsi <?php //echo $userData['kd_provinsi'];?></label>
			<div class="col-md-12">
				<select class="form-control" name="ipropinsi" id="ipropinsi">
					<option value="0">-- Pilih --</option>
					<?php
					for ($b2 = 1; $b2 <= $jml_propinsi; $b2++) {
						$terpilihb2 = '';
						if ($id_propinsi[$b2] == $userData['kd_provinsi']) {
							$terpilihb2 = 'selected';
						}
						echo '<option ' . $terpilihb2 . ' value="' . $id_propinsi[$b2] . '">' . $nama_propinsi[$b2] . '</option>';
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
						$terpilihb3 = '';
						if ($id_kota[$b3] == $userData['kd_kota']) {
							$terpilihb3 = 'selected';
						}
						echo '<option ' . $terpilihb3 . ' value="' . $id_kota[$b3] . '">' . $nama_kota[$b3] . '</option>';
					}
					?>
				</select>
			</div>
		</div>

		<input type="hidden" id="addedit" name="addedit" value="<?php echo $addedit; ?>"/>
		<input type="hidden" id="adafile" name="adafile"/>
		<input type="hidden" id="adavideo" name="adavideo"/>
		<input type="hidden" id="adaurl" name="adaurl"/>
		<input type="hidden" id="linkurl" name="linkurl"/>
		<input type="hidden" id="tombolurl" name="tombolurl"/>
		<input type="hidden" id="adaurl2" name="adaurl2"/>
		<input type="hidden" id="linkurl2" name="linkurl2"/>
		<input type="hidden" id="tombolurl2" name="tombolurl2"/>
		<input type="hidden" id="nmgambar" name="nmgambar"/>
		<input type="hidden" id="nmgambar2" name="nmgambar2"/>
		<input type="hidden" id="nmfile" name="nmfile"/>
		<input type="hidden" id="viaver" name="viaver"/>
		<input type="hidden" id="afterreg" name="afterreg"/>
		<input type="hidden" id="afterreg2" name="afterreg2"/>
		<input type="hidden" id="sertifikat" name="sertifikat"/>
		<input type="hidden" id="tgleventaktif" name="tgleventaktif"/>
		<input type="hidden" id="tgleventaktif2" name="tgleventaktif2"/>
		<input type="hidden" id="tglregistermati" name="tglregistermati"/>
		<input type="hidden" id="tglsertifikataktif" name="tglsertifikataktif"/>
		<input type="hidden" id="genderpil" name="genderpil" />
		<input type="hidden" id="tgllahir" name="tgllahir" />



		<?php
		echo form_close() . '';
		?>

		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Gambar Event (Lebar)</label>
			<div style="margin-left:32px;width: 300px;height: auto;">
				<?php
				if ($addedit == "add")
					$foto = base_url() . "assets/images/blankev.jpg";
				else if (substr($foto, 0, 4) != "http") {
					$foto = base_url() . "uploads/event/" . $foto;
				}

				?>
				<table style="margin-left:0px; width:300px;border: 1px solid black;">
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

		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Gambar Event (Pendek)</label>
			<div style="margin-left:32px;width: 150px;height: auto;">
				<?php
				if ($addedit == "add")
					$foto2 = base_url() . "assets/images/blankev.jpg";
				else if (substr($foto2, 0, 4) != "http") {
					$foto2 = base_url() . "uploads/event/" . $foto2;
				}

				?>
				<table style="margin-left:0px; width:150px;border: 1px solid black;">
					<tr>
						<th>
							<img id="previewing2" width="150px" src="<?php echo $foto2; ?>">
						</th>
					</tr>
				</table>
			</div>
			<h4 style="display: none;" id='loading2'>uploading ... </h4>

		</div>

		<form class="form-horizontal" id="submit2" style="display:<?php echo $cekdisplay; ?>;">
			<div class="form-group" style="margin-left: 30px">
				<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
				<input style="display:inline;margin-left: 20px;" type="file" name="file" id="file2" accept="image/*">
				<input type="hidden" id="fotoaddedit2" name="fotoaddedit2" value="<?php echo $addedit; ?>">
				<br>
				<button style="display:inline-block;margin-left: 20px;" id="btn_upload2" type="submit">Terapkan</button>
				<div class="progress2" style="display:none">
					<div id="progressBar2" class="progress-bar progress-bar-striped active" role="progressbar"
						 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span class="sr-only">0%</span>
					</div>
				</div>
				<span style="margin-left: 30px" id="message2"></span>
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

		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">Tombol Upload Video</label>
			<div class="col-md-12" style="padding-bottom:10px;width: 100%">
				<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadavideo" id="iadavideo">
					<option <?php echo $selvid[1]; ?> value="0">Tidak</option>
					<option <?php echo $selvid[2]; ?> value="1">Ya</option>
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
					<input style="width:200px;display:block;margin-left: 20px;" type="file" name="file" id="filedok"
						   accept="application/pdf">
					<input type="hidden" id="dokaddedit" name="dokaddedit" value="<?php echo $addedit; ?>">
					<button style="display:block;margin-left: 20px;" id="btn_uploaddok" type="submit">Upload</button>
					<span style="wimargin-left: 30px" id="messagedok"></span>
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
				<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
					<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Teks Tombol URL</label>
					<input style="max-width:200px;width:100%;height:auto;margin:0;" type="text" value="<?php
					echo $tombolurl; ?>" class="form-control" id="itombolurl" name="itombolurl" maxlength="25">
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
					<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Tombol Aktif Mulai</label>
					<input type="text" value="<?php echo $tglaktif; ?>" name="datetime3" id="datetime3" class="form-control" style="width: 160px" readonly>
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 100%">
					<input <?php echo $afterchecked;?> style="margin-left:20px;" type="checkbox" id="iafterreg" name="iafterreg" value="Ya">
					<label for="afterreg"> Muncul Setelah User Mendaftar</label><br>
				</div>
			</div>
		</form>

		<div class="form-group" style="margin-top: 0px;">
			<label for="inputDefault" class="col-md-12 control-label">Link URL Tambahan</label>
			<div class="col-md-12" style="padding-bottom:5px;width: 100%">
				<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadaurl2" id="iadaurl2">
					<option <?php echo $selurl2[1]; ?> value="0">Tidak Ada</option>
					<option <?php echo $selurl2[2]; ?> value="1">Ada</option>
				</select>
			</div>
		</div>

		<form id="inputurl2" style="display:none;">
			<div class="form-group" style="margin-left: 5px">
				<div class="col-md-12" style="padding-bottom:10px;width: 250px">
					<label for="inputDefault" class="col-md-12 control-label">Alamat Link URL Tambahan</label>
					<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
					echo $linkurl2; ?>" class="form-control" id="ilinkurl2" name="ilinkurl2" maxlength="250">
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
					<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Teks Tombol URL Tambahan</label>
					<input style="max-width:200px;width:100%;height:auto;margin:0;" type="text" value="<?php
					echo $tombolurl2; ?>" class="form-control" id="itombolurl2" name="itombolurl2" maxlength="25">
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
					<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Tombol Aktif Mulai</label>
					<input type="text" value="<?php echo $tglaktif2; ?>" name="datetime4" id="datetime4" class="form-control" style="width: 160px" readonly>
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 100%">
					<input <?php echo $afterchecked2;?> style="margin-left:20px;" type="checkbox" id="iafterreg2" name="iafterreg2" value="Ya">
					<label for="afterreg2"> Muncul Setelah User Mendaftar</label><br>
				</div>
			</div>
		</form>

		<div class="form-group" style="margin-top: 0px;">
			<label for="inputDefault" class="col-md-12 control-label">Registrasi atas Sekolah</label>
			<div class="col-md-12" style="padding-bottom:5px;width: 100%">
				<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iviaver" id="iviaver">
					<option <?php echo $selver[1]; ?> value="0">Tidak</option>
					<option <?php echo $selver[2]; ?> value="1">Ya</option>
				</select>
			</div>
		</div>
		<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
			<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Registrasi Ditutup Tanggal</label>
			<input type="text" value="<?php echo $tglregmati; ?>" name="datetime5" id="datetime5" class="form-control" style="width: 160px" readonly>
		</div>

		<div class="form-group" style="margin-top: 0px;">
			<label for="inputDefault" class="col-md-12 control-label">Mendapat Sertifikat</label>
			<div class="col-md-12" style="padding-bottom:5px;width: 100%">
				<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="isertifikat" id="isertifikat">
					<option <?php echo $selsertifikat[1]; ?> value="0">Tidak</option>
					<option <?php echo $selsertifikat[2]; ?> value="1">Ya</option>
				</select>
			</div>
		</div>
		<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
			<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Sertifikat Diunduh Tanggal</label>
			<input type="text" value="<?php echo $tglseraktif; ?>" name="datetime6" id="datetime6" class="form-control" style="width: 160px" readonly>
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

		$("#file2").change(function () {
			$("#message2").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match = ["image/jpeg", "image/png", "image/jpg"];
			if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
				// $('#previewing').attr('src','noimage.png');
				$("#message2").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			} else {
				var reader = new FileReader();
				reader.onload = imageIsLoaded2;
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

	function imageIsLoaded2(e) {
		$("#file2").css("color", "green");
		$('#image_preview2').css("display", "block");
		$('#previewing2').attr('src', e.target.result);
		$('#previewing2').attr('width', '300px');
		$('#previewing2').attr('height', 'auto');
	};

	$(document).ready(function () {
		<?php if ($addedit == "edit") {?>
		$("#message").html("Foto siap digunakan");
		$("#message2").html("Foto siap digunakan");
		<?php } ?>
		<?php if($selfile[2] == "selected") {?>
		$("#messagedok").html("Dokumen siap");
		<?php } ?>

		$('#submit').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>event/upload_foto_event/<?php echo $code_event;?>',
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
				url: '<?php echo base_url(); ?>event/upload_foto_event2/<?php echo $code_event;?>',
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

		$('#submitdok').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>event/upload_dok/<?php echo $code_event;?>',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loadingdok').hide();
					$("#messagedok").html(data);
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

	$("#iadaurl2").change(function () {
		if ($("#iadaurl2").val() == 1)
			document.getElementById('inputurl2').style.display = 'block';
		else
			document.getElementById('inputurl2').style.display = 'none';
	});

	function diedit() {
		document.getElementById('inamaevent').readOnly = false;
		document.getElementById('isubjudul').readOnly = false;
		document.getElementById('iket').readOnly = false;
		document.getElementById('iiuran').readOnly = false;
		document.getElementById('iadafile').disabled = false;
		document.getElementById('iadavideo').disabled = false;
		document.getElementById('iadaurl').disabled = false;
		document.getElementById('iadaurl2').disabled = false;
		document.getElementById('iviaver').disabled = false;
		document.getElementById('isertifikat').disabled = false;
		document.getElementById('tbedit').style.display = 'none';
		document.getElementById('tbkembali').style.display = 'none';
		document.getElementById('tbbatal').style.display = 'inline';
		document.getElementById('tbupdate').style.display = 'inline';
		document.getElementById('submit').style.display = 'inline';
		document.getElementById('btn_upload').style.display = 'inline';
		document.getElementById('submit2').style.display = 'inline';
		document.getElementById('btn_upload2').style.display = 'inline';
		if ($("#iadafile").val() == 1)
			document.getElementById('submitdok').style.display = 'block';
		if ($("#iadaurl").val() == 1)
			document.getElementById('inputurl').style.display = 'block';
		if ($("#iadaurl2").val() == 1)
			document.getElementById('inputurl2').style.display = 'block';
		CKEDITOR.instances['iisievent'].setReadOnly(false);
		return false;
	}

	function gaksido() {
		document.getElementById('inamaevent').readOnly = true;
		document.getElementById('isubjudul').readOnly = true;
		document.getElementById('iket').readOnly = true;
		document.getElementById('iiuran').readOnly = true;
		document.getElementById('iadafile').disabled = true;
		document.getElementById('iadavideo').disabled = true;
		document.getElementById('iadaurl').disabled = true;
		document.getElementById('iadaurl2').disabled = true;
		document.getElementById('iviaver').disabled = true;
		document.getElementById('isertifikat').disabled = true;
		document.getElementById('tbedit').style.display = 'inline';
		document.getElementById('tbkembali').style.display = 'inline';
		document.getElementById('tbbatal').style.display = 'none';
		document.getElementById('tbupdate').style.display = 'none';
		document.getElementById('submit').style.display = 'none';
		document.getElementById('btn_upload').style.display = 'none';
		document.getElementById('submit2').style.display = 'none';
		document.getElementById('btn_upload2').style.display = 'none';
		document.getElementById('submitdok').style.display = 'none';
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
			$('#nmgambar2').val("");
		else
			$('#nmgambar2').val($('#file2').val().substring($('#file2').val().lastIndexOf(".") + 1));
		if ($('#filedok').val() == "")
			$('#nmfile').val("");
		else
			$('#nmfile').val($('#filedok').val().substring($('#filedok').val().lastIndexOf(".") + 1));
		$('#adafile').val($('#iadafile').val());
		$('#adavideo').val($('#iadavideo').val());
		$('#adaurl').val($('#iadaurl').val());
		$('#linkurl').val($('#ilinkurl').val());
		$('#tombolurl').val($('#itombolurl').val());
		$('#adaurl2').val($('#iadaurl2').val());
		$('#linkurl2').val($('#ilinkurl2').val());
		$('#tombolurl2').val($('#itombolurl2').val());
		$('#viaver').val($('#iviaver').val());
		$('#sertifikat').val($('#isertifikat').val());
		cekafter = document.getElementById("iafterreg").checked;
		$('#afterreg').val(cekafter);
		$('#tgleventaktif').val($('#datetime3').val());
		cekafter2 = document.getElementById("iafterreg2").checked;
		$('#afterreg2').val(cekafter2);
		$('#tgleventaktif2').val($('#datetime4').val());
		$('#tglregistermati').val($('#datetime5').val());
		$('#tglsertifikataktif').val($('#datetime6').val());


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

	$("#datetime3").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime4").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime5").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime6").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});
</script>
