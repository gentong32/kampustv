<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ($file == "") {
	$selfile[1] = "selected";
	$selfile[2] = "";
} else {
	$selfile[1] = "";
	$selfile[2] = "selected";
}

$uraian = trim(preg_replace('/\s\s+/', ' ', $uraian));
$uraian = preg_replace('~[\r\n]+~', '', $uraian);

?>


<div class="container" style="color:black;margin-top: 60px; max-width: 900px">
	<center><span style="font-size:20px;font-weight:Bold;">URAIAN MATERI<br><?php echo $judul; ?></span></center>
	<!---->

	<div style="margin-bottom:20px;">
		<div class="row">
			<div class="form-group" style="margin-top: 10px;">
				<hr style="border: #5e4609 2px solid">
				<label for="inputDefault" class="col-md-12 control-label">
					<div id="soalnomor" style="margin-bottom:15px;text-align: center;font-weight: bold;font-size: larger">Pengantar Singkat</div>
				</label>
				<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;margin:0;padding:0" type="text"
						  class="ckeditor" id="iisisoal" name="iisisoal" maxlength="1000" value="<?php echo $uraian;?>"></textarea>
				</div>
			</div>


			<!------------------------------------------------------------------------------->
			<input type="hidden" id="textsoal" name="textsoal" value=""/>

			<div style="float:right;margin-bottom:30px;margin-right: 30px;">
				<button style="display: none;" id="tbupdate" type="submit" class="btn btn-primary"
						onclick="return updatemateri()">Update
				</button>
			</div>

			<div class="form-group" style="margin-top: 30px;">
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
						<input style="width:200px;display:block;margin-left: 20px;" type="file" name="filedok" id="filedok"
							   accept="application/pdf">
						<button style="display:block;margin-left: 20px;" id="btn_uploaddok" type="submit">Upload</button>
						<span style="wimargin-left: 30px" id="messagedok"></span>
					</div>
				</div>
			</form>
		</div>
		<button onclick="return kosonginfile();" style="display:none;margin-left: 35px;" id="btn_file">Update</button>
		<hr>
		<button style="margin-left:20px;" id="tbbatal" class="btn btn-danger"
				onclick="return kembali()">Kembali
		</button>
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

	CKEDITOR.instances["iisisoal"].setData("<?php echo $uraian;?>");

	CKEDITOR.instances.iisisoal.on('change', function() {
		$('#tbupdate').show();
	});

	$("#iadafile").change(function () {
		if ($("#iadafile").val() == 1) {
			document.getElementById('submitdok').style.display = 'block';
			document.getElementById('btn_file').style.display = 'none';
		}
		else {
			document.getElementById('submitdok').style.display = 'none';
			document.getElementById('btn_file').style.display = 'block';
		}
	});

	function updatemateri() {
		var isimateri = CKEDITOR.instances['iisisoal'].getData();
		$.ajax({
			url: "<?php echo base_url();?>vksekolah/updatemateri/<?php echo $linklist;?>",
			method: "POST",
			data: {isimateri: isimateri},
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

	function kosonginfile() {
		$.ajax({
			url: "<?php echo base_url();?>vksekolah/kosonginfilemateri",
			method: "POST",
			data: {linklist: "<?php echo $linklist;?>"},
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
			url: '<?php echo base_url(); ?>vksekolah/upload_dok/<?php echo $linklist;?>',
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

</script>
