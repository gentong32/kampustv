<!--<script src='https://makitweb.com/demo/codeigniter_tinymce/resources/tinymce/tinymce.min.js'></script>-->
<script src='<?= base_url() ?>resources/tinymce/tinymce.min.js'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css">

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$selfile[1] = "";
$selfile[2] = "";

$tnamaevent = $dataevent[0]->nama_event;
$tisievent = $dataevent[0]->isi_event;
$tglmulai = new DateTime($dataevent[0]->tgl_mulai);
$tglmulai = $tglmulai->format("d-m-Y");
$tglselesai = new DateTime($dataevent[0]->tgl_selesai);
$tglselesai = $tglselesai->format("d-m-Y");
$foto = $dataevent[0]->gambar;
$cekfile = $dataevent[0]->file;
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


?>

<div class="container" style="color:black;margin-top: 60px; max-width: 900px">
	<center><span style="font-size:20px;font-weight:Bold;"><?php echo $title; ?></span>
	<br>
	<h3><?php
		echo $tnamaevent; ?></h3>
	</center>
	<!---->
	<div style="text-align: center;margin: auto">
		<button id="tbkembali" class="btn btn-primary"
				onclick="window.open('<?php echo base_url(); ?>event/spesial/acara','_self')">Kembali</button>
	</div>


	<div class="row">
		<?php
		$attributes = array('id' => 'myform1');
		echo form_open('event/addbuktibayar/'.$code_event, $attributes);
		?>

		<hr>

		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">Dikirim dari bank</label>
			<div class="col-md-12" style="padding-bottom:10px">
				<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="" class="form-control" id="inamabank" name="inamabank" maxlength="50">
			</div>
		</div>

		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">Nomor rekening</label>
			<div class="col-md-12" style="padding-bottom:10px">
				<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="" class="form-control" id="inorek" name="inorek" maxlength="50">
			</div>
		</div>

		<div class="form-group" style="margin-top: 30px;">
			<label for="inputDefault" class="col-md-12 control-label">Atas nama</label>
			<div class="col-md-12" style="padding-bottom:10px">
				<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="" class="form-control" id="inamarek" name="inamarek" maxlength="50">
			</div>
		</div>

		<input type="hidden" id="nmgambar" name="nmgambar"/>


		<?php
		echo form_close() . '';
		?>

		<div class="form-group">
			<label for="inputDefault" class="col-md-12 control-label">Upload bukti pembayaran</label>
			<div style="margin-left:32px;width: 200px;height: auto;">
				<?php
				$foto = base_url() . "assets/images/blankbukti.jpg";
				?>
				<table style="margin-left:0px; width:200px;border: 1px solid black;">
					<tr>
						<th>
							<img id="previewing" width="200px" src="<?php echo $foto; ?>">
						</th>
					</tr>
				</table>
			</div>
			<h4 style="display: none;" id='loading'>uploading ... </h4>

		</div>

		<form class="form-horizontal" id="submit">
			<div class="form-group" style="margin-left: 30px">
				<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
				<input style="display:inline;margin-left: 20px;" type="file" name="file" id="file1" accept="image/*">

				<br>
				<button style="display:inline-block;margin-left: 20px;" id="btn_upload" type="submit">Upload</button>
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
			<div class="col-md-10 col-md-offset-0" style="margin-bottom:20px"><br>
				<button style="display: none;" id="tbbatal" class="btn btn-default" onclick="return gaksido()">Batal
				</button>
				<button style="display: none;" id="tbupdate" type="submit" class="btn btn-primary"
						onclick="return cekupdate()">Update
				</button>
					<button style="margin-left:15px;display: block;" id="tbupdate" type="submit" class="btn btn-primary"
							onclick="return cekupdate()">Submit
					</button>
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

		$('#submit').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>event/upload_bukti/<?php echo $code_event;?>',
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

	});

	function cekupdate() {
		var oke;
		if ($('#file1').val() == "")
			$('#nmgambar').val("");
		else
			$('#nmgambar').val($('#file1').val().substring($('#file1').val().lastIndexOf(".") + 1));

		if ($('#inamabank').val() == "" || $("#message").html() != 'Bukti Transfer tersimpan' ||
			$('#inamarek').val() == "" || $('#inorek').val() == "") {
			oke = false;
		} else {
			oke = true;
		}

		if (oke == true) {
			$('#myform1').submit();
			return true;
		} else {

			alert('Semua harus diisi');
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
