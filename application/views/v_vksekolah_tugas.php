<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$judul = $tugasguru->nama_paket;
$fileguru = $tugasguru->tanyafile;
$uraianguru = $tugasguru->tanyatxt;
$uraianguru = trim(preg_replace('/\s\s+/', ' ', $uraianguru));
$uraianguru = preg_replace('~[\r\n]+~', '', $uraianguru);

$filesiswa = "";
$uraiansiswa = "";

if ($tugassiswa) {
	$filesiswa = $tugassiswa->jawabanfile;
	$uraiansiswa = $tugassiswa->jawabantxt;
	$uraiansiswa = trim(preg_replace('/\s\s+/', ' ', $uraiansiswa));
	$uraiansiswa = preg_replace('~[\r\n]+~', '', $uraiansiswa);
	$nilaisiswa = $tugassiswa->nilai;
	$nilaisiswa = trim(preg_replace('/\s\s+/', ' ', $nilaisiswa));
	$nilaisiswa = preg_replace('~[\r\n]+~', '', $nilaisiswa);
	$keterangan = $tugassiswa->keterangan;
	$keterangan = trim(preg_replace('/\s\s+/', ' ', $keterangan));
	$keterangan = preg_replace('~[\r\n]+~', '', $keterangan);
}

if ($filesiswa == "") {
	$selfile[1] = "selected";
	$selfile[2] = "";
} else {
	$selfile[1] = "";
	$selfile[2] = "selected";
}

if ($nilaisiswa == "") {
	$cekrespon1a = "block";
	$cekrespon1b = "none";
	$cekrespon2 = "none";
} else {
	$cekrespon1a = "none";
	$cekrespon1b = "block";
	$cekrespon2 = "block";
}

?>

<div class="bgimg5" style="width: 100%;margin-top: -10px;">
	<div class="container"
		 style="padding-top:20px;color:black;margin:auto;text-align:center;margin-top: 60px; max-width: 900px">
		<center><span style="font-size:20px;font-weight:Bold;">TUGAS<br><?php echo $judul; ?></span></center>

		<hr style="border: #0c922e 0.5px dashed">

		<div style="margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:10px;
		opacity:90%;padding:20px;color: black;">
			<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

				<?php echo $uraianguru; ?>

			</div>
			<div style="margin-top: 20px;">
				<?php if ($fileguru != "") { ?>
					<button style="width:150px;padding:10px 10px;margin-bottom:5px;" class="btn-primary"
							onclick="window.open('<?php echo base_url(); ?>vksekolah/download/<?php echo $npsn . "/tugas/" . $linklist; ?>','_self')">
						Unduh Lampiran
					</button>
				<?php } ?>
			</div>
		</div>

		<div id="dinputjawab" style="margin-bottom:20px;display: <?php echo $cekrespon1a; ?>">
			<div class="row">
				<div class="form-group" style="margin-top: 10px;">
					<hr style="border: #5955c1 0.5px solid">
					<label for="inputDefault" class="col-md-12 control-label">
						<div id="soalnomor"
							 style="margin-bottom:15px;text-align: center;font-weight: bold;font-size: larger">Silakan Jawab Disini
						</div>
					</label>
					<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;margin:0;padding:0" type="text"
						  class="ckeditor" id="iisisoal" name="iisisoal" maxlength="5000"
						  value="<?php echo $uraiansiswa; ?>"></textarea>
					</div>
				</div>


				<!------------------------------------------------------------------------------->
				<input type="hidden" id="textsoal" name="textsoal" value=""/>

				<div style="float:right;margin-bottom:30px;margin-right: 30px;">
					<button style="display: none;" id="tbupdate" type="submit" class="btn btn-primary"
							onclick="return updatejawaban()">Update
					</button>
				</div>

				<div class="form-group" style="margin-top: 30px;text-align: left">
					<label for="inputDefault" class="col-md-12 control-label">File lampiran</label>
					<div class="col-md-12" style="padding-bottom:10px;width: 100%">
						<select style="width: 200px" class="form-control" name="iadafile" id="iadafile">
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
							<input style="width:200px;display:block;margin-left: 20px;" type="file" name="filedok"
								   id="filedok"
								   accept="application/pdf">
							<button style="display:block;margin-left: 20px;" id="btn_uploaddok" type="submit">Upload
							</button>
							<span style="margin-left: 30px" id="messagedok"></span>
						</div>
					</div>
					<input type="hidden" name="idtgs" id="idtgs" value="<?php echo $id_tugas; ?>">
				</form>
			</div>
			<button onclick="return kosonginfile();" style="display:none;margin-left: 35px;" id="btn_file">Update
			</button>
			<hr>
			<button class="btn btn-danger"
					onclick="return kembali()">Kembali
			</button>
			<button class="btn btn-primary" onclick="return lihatjawaban();">Cek Kiriman Jawaban</button>
		</div>

		<div style="margin-top:20px;display: <?php echo $cekrespon1b; ?>">
			<span style="font-size: 18px;font-weight: bold;">JAWABAN SAYA</span>
		</div>

		<div style="margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:10px;
		opacity:90%;padding:20px;color: black; display: <?php echo $cekrespon1b; ?>">

			<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

				<?php echo $uraiansiswa; ?>

			</div>
			<div style="margin-top: 20px;">
				<?php if ($filesiswa != "") { ?>
					<button style="width:150px;padding:10px 10px;margin-bottom:5px;" class="btn-primary"
							onclick="window.open('<?php echo base_url(); ?>vksekolah/download/<?php echo $npsn . "/jawaban/" . $id_tugas; ?>','_self')">
						Unduh Lampiran
					</button>
				<?php } ?>
			</div>
		</div>

		<div style="display:<?php echo $cekrespon2; ?>">
			<hr style="border: #5faabd 2px dashed;width: 92%;">
			<span style="font-size: 18px;font-weight: bold;">PENILAIAN GURU</span>
		</div>

		<div
			style="display:<?php echo $cekrespon2; ?>;margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:10px;
				opacity:90%;padding:20px;color: black;">
			<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

				<?php
				echo "<center><span style='font-weight:bold;font-size: 16px;'>NILAI</span>
<br><span style='font-weight:bold;font-size: 16px;'>" . $nilaisiswa . "</span></center><br>";
				echo $keterangan . "<br>";

				?>

			</div>

		</div>

		<div style="display:<?php echo $cekrespon2; ?>">
			<button style="margin:20px;" class="btn btn-danger"
					onclick="return kembali()">Kembali
			</button>
		</div>

	</div>
</div>

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url('ckeditor/ckeditor.js'); ?>"></script>


<script>

	CKEDITOR.config.height = '200px';
	//CKEDITOR.config.removePlugins = 'easyimage,cloudservices';
	CKEDITOR.config.removePlugins = '';
	CKEDITOR.addCss(".cke_editable{cursor:text; font-size: 15px; font-family: Arial, sans-serif;}");

	CKEDITOR.replace('iisisoal', {
		on: {
			instanceReady: function (ev) {
				// Output paragraphs as <p>Text</p>.
				this.dataProcessor.writer.setRules('p', {
					indent: false,
					breakBeforeOpen: false,
					breakAfterOpen: false,
					breakBeforeClose: false,
					breakAfterClose: false
				});
			}
		}
	});

	CKEDITOR.instances["iisisoal"].setData("<?php echo $uraiansiswa;?>");

	CKEDITOR.instances.iisisoal.on('change', function () {
		$('#tbupdate').show();
	});

	$("#iadafile").change(function () {
		if ($("#iadafile").val() == 1) {
			document.getElementById('submitdok').style.display = 'block';
			document.getElementById('btn_file').style.display = 'none';
		} else {
			document.getElementById('submitdok').style.display = 'none';
			document.getElementById('btn_file').style.display = 'block';
		}
	});

	function updatejawaban() {
		var isimateri = CKEDITOR.instances['iisisoal'].getData().replace(/"/g, '\\x22').replace(/'/g, '\\x27');
		isimateri = isimateri.replace(/(?:<br \/>)/g, '');
		isimateri = isimateri.replace(/(?:\r\n|\r|\n)/g, '<br>');

		$.ajax({
			url: "<?php echo base_url();?>vksekolah/updatetugasjawab/<?php echo $linklist;?>",
			method: "POST",
			data: {idtgs: "<?php echo $id_tugas;?>", isimateri: isimateri},
			success: function (result) {
				if (result == "sukses")
					$('#tbupdate').hide()
				else
					alert("Gagal update");
			}
		});
	}

	function kembali() {
		window.history.back();
	}

	function lihatjawaban() {
		window.open("<?php echo base_url();?>vksekolah/tugas/<?php echo $npsn;?>/jawabansaya/<?php echo $linklist;?>", "_self");
	}

	function kosonginfile() {
		$.ajax({
			url: "<?php echo base_url();?>channel/kosonginfilejawaban",
			method: "POST",
			data: {idtgs: <?php echo $id_tugas; ?>},
			success: function (result) {
				if (result == "sukses")
					document.getElementById('btn_file').style.display = 'none';
				else
					alert("Gagal hapus");
			}
		});
	}

	$('#submitdok').submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url(); ?>vksekolah/upload_doktugas/<?php echo $linklist;?>',
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


	function cekupdate() {
		var soaloke = false;
		var teksoke1

		teksoke1 = CKEDITOR.instances['iisisoal'].getData().replace(/"/g, '\\x22').replace(/'/g, '\\x27');
		$('#textsoal').val(teksoke1);

		if ($('#textsoal').val().length > 20) {
			soaloke = true;
		}

		var textsoalok = $('#textsoal').val().replace(/(?:<br \/>)/g, '');
		textsoalok = textsoalok.replace(/(?:\r\n|\r|\n)/g, '<br>');
		$('#textsoal').val(textsoalok);

		if (soaloke) {
			$('#myform1').submit();
			return true;
		} else {
			alert('Minimal ada 20 karakter yang harus dituliskan!');
			return false;
		}
	}

</script>


<script>
	function kembali() {
		window.open("<?php echo base_url() . 'vksekolah/get_vksekolah/' . $npsn . '/' . $linklist;?>","_self");
	}

</script>
