<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$filesoal = $soalessay->tanyafile;
$uraiansoal = $soalessay->tanyatxt;
$uraiansoal = trim(preg_replace('/\s\s+/', ' ', $uraiansoal));
$uraiansoal = preg_replace('~[\r\n]+~', '', $uraiansoal);

//$filesiswa = "";
//$uraiansiswa = "";
//
//if ($jawabanessay) {
//	$filejawaban = $jawabanessay->essayfile;
//	$uraianjawaban = $jawabanessay->essaytxt;
//	$uraianjawaban = trim(preg_replace('/\s\s+/', ' ', $uraianjawaban));
//	$uraianjawaban = preg_replace('~[\r\n]+~', '', $uraianjawaban);
//}
//
//if ($filesiswa == "") {
//	$selfile[1] = "selected";
//	$selfile[2] = "";
//} else {
//	$selfile[1] = "";
//	$selfile[2] = "selected";
//}
//
//if ($nilaisiswa == "") {
//	$cekrespon1a = "block";
//	$cekrespon1b = "none";
//	$cekrespon2 = "none";
//} else {
//	$cekrespon1a = "none";
//	$cekrespon1b = "block";
//	$cekrespon2 = "block";
//}
if ($this->session->userdata('siae') == 2)
{
	$jenisnya = "(ACCOUNT EXECUTIVE)";
}
else if ($this->session->userdata('siam') == 2)
{
	$jenisnya = "(AREA MARKETING)";
}
else if ($this->session->userdata('bimbel') == 2)
{
	$jenisnya = "(TUTOR BIMBEL ONLINE)";
}
?>

<div class="bgimg5" style="width: 100%;margin-top: -10px;">
	<div class="container"
		 style="padding-top:20px;color:black;margin:auto;text-align:center;margin-top: 60px; max-width: 900px">
		<center><span style="font-size:20px;font-weight:Bold;">ASSESMENT <?php echo $jenisnya;?> 3</span></center>

		<hr style="border: #0c922e 0.5px dashed">

		<div style="margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:10px;
		opacity:90%;padding:20px;color: black;">
			<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

				<?php echo $uraiansoal; ?>

			</div>
			<div style="margin-top: 20px;">
				<?php if ($filesoal != "") { ?>
					<button style="width:150px;padding:10px 10px;margin-bottom:5px;" class="btn-primary"
							onclick="window.open('<?php echo base_url(); ?>assesment/download/siae','_self')">
						Unduh Lampiran
					</button>
				<?php } ?>
			</div>
		</div>

		<div id="dinputjawab" style="margin-bottom:20px;">
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
						  value=""></textarea>
					</div>
				</div>


				<!------------------------------------------------------------------------------->
				<input type="hidden" id="textsoal" name="textsoal" value=""/>


				<div class="form-group" style="margin-top: 30px;text-align: left">
					<label for="inputDefault" class="col-md-12 control-label">File lampiran</label>
					<div class="col-md-12" style="padding-bottom:10px;width: 100%">
						<select style="width: 200px" class="form-control" name="iadafile" id="iadafile">
							<option value="0">Tidak Ada</option>
							<option value="1">Ada</option>
						</select>

					</div>
				</div>

				<form class="form-horizontal" id="submitdok" style="display: none">
					<div class="form-group" style="margin-left: 5px;text-align: left;">
						<div class="col-md-12" style="padding-bottom:10px;width: 100%">
							<input style="width:200px;display:block;margin-left: 20px;" type="file" name="filedok"
								   id="filedok"
								   accept="application/pdf">
							<button style="display:block;margin-left: 20px;" id="btn_uploaddok" type="submit">Upload
							</button>
						</div>
						<span style="margin-left: 30px" id="messagedok"></span>
					</div>
				</form>
			</div>

			<hr>
			<div style="margin-bottom:30px;">
				<button id="tbupdate" type="submit" class="btn btn-primary"
						onclick="return updatejawaban()">Kirim Jawaban
				</button>
			</div>
		</div>


	</div>
</div>

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url('ckeditor/ckeditor.js'); ?>"></script>


<script>

	CKEDITOR.config.height = '200px';
	//CKEDITOR.config.removePlugins = 'easyimage,cloudservices,cloudServices_tokenUrl';
	//CKEDITOR.config.removePlugins = '';
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

		var adafile = $("#iadafile").val();

		$.ajax({
			url: "<?php echo base_url();?>assesment/updatetugasjawab",
			method: "POST",
			data: {isimateri: isimateri, adafile: adafile},
			success: function (result) {
				if (result == "sukses")
				{
					$('#tbupdate').hide();
					window.open("<?php echo base_url();?>informasi/tungguhasil")
				}
				else if (result == "kurang")
				{
					$('#tbupdate').hide();
					<?php if ($this->session->userdata('bimbel') == 2) { ?>
						window.open("<?php echo base_url();?>peluangkarir/tutor");
					<?php } else if ($this->session->userdata('siae') == 2) { ?>
					window.open("<?php echo base_url();?>peluangkarir/account_executive");
						<?php } else if ($this->session->userdata('siam') == 2) { ?>
					window.open("<?php echo base_url();?>peluangkarir/area_marketing");
					<?php } ?>

				} else
					alert("Gagal update");
			}
		});
	}


	$('#submitdok').submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url(); ?>assesment/upload_file',
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
