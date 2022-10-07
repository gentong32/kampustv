<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml = 0;
foreach ($dafsoal as $datane) {
	$jml++;
	$nomor[$jml] = $jml;
	$id[$jml] = $datane->id_soal;
	$soaltxt[$jml] = $datane->soaltxt;
	$soalgbr[$jml] = $datane->soalgbr;
	$opsiatxt[$jml] = $datane->opsiatxt;
	$opsiagbr[$jml] = $datane->opsiagbr;
	$opsibtxt[$jml] = $datane->opsibtxt;
	$opsibgbr[$jml] = $datane->opsibgbr;
	$opsictxt[$jml] = $datane->opsictxt;
	$opsicgbr[$jml] = $datane->opsicgbr;
	$opsidtxt[$jml] = $datane->opsidtxt;
	$opsidgbr[$jml] = $datane->opsidgbr;
	$opsietxt[$jml] = $datane->opsietxt;
	$opsiegbr[$jml] = $datane->opsiegbr;
	$kunci[$jml] = $datane->kunci;
}

if ($kodeevent!=null)
	$alamat = "/".$kodeevent;
else
	$alamat = "";

?>



<div class="container" style="color:black;margin-top: 60px; max-width: 900px">
	<center><span style="font-size:20px;font-weight:Bold;">SOAL LATIHAN<br><?php echo $judul; ?></span></center>
	<!---->

	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style='width:5px;text-align:center'>No</th>
				<th style='width:95%;text-align:center'>Soal</th>
				<th style='width:95%;text-align:center'>Edit - Hapus</th>
			</tr>
			</thead>

			<tbody>
			<?php for ($i = 1; $i <= $jml; $i++) {
				// if ($idsebagai[$i]!="4") continue;
				?>

				<tr>
					<td style='text-align:right'><?php echo $nomor[$i]; ?></td>
					<td><?php echo $soaltxt[$i]; ?></td>
					<td>
						<button onclick="return diedit(<?php echo $i; ?>);">Edit</button>
						<button onclick="return dihapus(<?php echo $id[$i]; ?>);">Hapus</button>
					</td>
				</tr>

				<?php
			}
			?>
			</tbody>
		</table>
	</div>

	<div id="dtambah" style="margin-left:25px;margin-bottom: 30px;">
		<button onclick="return ditambah();">Tambah</button>
	</div>


	<div id="addeditsoal" style="display: none">
		<div class="row">

			<div class="form-group" style="margin-top: 10px;">
				<hr style="border: #5e4609 2px solid">
				<label for="inputDefault" class="col-md-12 control-label">
					<div id="soalnomor" style="text-align: center;font-weight: bold;font-size: larger">Buat Pertanyaan
						No. <?php echo($jml + 1); ?></div>
					<p></p></label>
				<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;margin:0;padding:0" type="text"
						  class="ckeditor" id="iisisoal" name="iisisoal" maxlength="1000"></textarea>
				</div>
			</div>


			<!------------------------------------------------------------------------------------------------------>

			<div class="form-group">
				<label for="inputDefault" class="col-md-12 control-label">[Gambar]</label>
				<div style="margin-left:32px;width: 250px;height: auto;">
					<table style="margin-left:0px; width:250px;border: 1px solid black;">
						<tr>
							<th>
								<img id="previewinggbsoal" width="250px" src="">
							</th>
						</tr>
					</table>
				</div>
				<h4 style="display: none;" id='loadinggbsoal'>uploading ... </h4>

			</div>

			<form class="form-horizontal" id="submitgbsoal">
				<div class="form-group" style="margin-left: 15px">
					<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
					<input style="display:inline;margin-left: 20px;" type="file" name="fgbsoal" id="fgbsoal"
						   accept="image/*">
					<br>
					<button style="display:inline-block;margin-left: 20px;" id="btn_gbsoal" type="submit">Terapkan
					</button>
					<button onclick="return hapusgbsoal();" style="display:inline-block;margin-left: 20px;"
							id="btn_hapusgbsoal">
						Hapus
					</button>
					<br>
					<span style="margin-left: 20px" id="messagegbsoal"></span>
				</div>
			</form>

			<!-------------------------------------- OPSI A------------------------------------------->

			<div class="form-group" style="margin-top: 10px;margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">
					<hr style="border: #9d261d 2px solid">
					<div style="font-weight: bold;font-size: larger;text-align: center">A</div>
					<p></p></label>
				<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;margin:0;padding:0" type="text"
						  class="ckeditor" id="iisiopsia" name="iisiopsia" maxlength="1000"></textarea>
				</div>
			</div>

			<div class="form-group" style="margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">[Gambar]</label>
				<div style="margin-left:32px;width: 250px;height: auto;">
					<table style="margin-left:0px; width:250px;border: 1px solid black;">
						<tr>
							<th>
								<img id="previewinggbopsia" width="250px" src="">
							</th>
						</tr>
					</table>
				</div>
				<h4 style="display: none;" id='loadinggbopsia'>uploading ... </h4>
			</div>

			<form class="form-horizontal" id="submitgbopsia" style="margin-left: 25px;">
				<div class="form-group" style="margin-left: 30px">
					<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
					<input style="display:inline;margin-left: 20px;" type="file" name="fgbopsia" id="fgbopsia"
						   accept="image/*">
					<br>
					<button style="display:inline-block;margin-left: 20px;" id="btn_gbopsia" type="submit">Terapkan
					</button>
					<button onclick="return hapusgbopsia();" style="display:inline-block;margin-left: 20px;"
							id="btn_hapusopsia">
						Hapus
					</button>
					<br>
					<span style="margin-left: 20px" id="messagegbopsia"></span>
				</div>
			</form>

			<!-------------------------------------- OPSI B------------------------------------------->

			<div class="form-group" style="margin-top: 10px;margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">
					<hr style="border: #9d261d 2px solid">
					<div style="font-weight: bold;font-size: larger;text-align: center">B</div>
					<p></p></label>
				<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;margin:0;padding:0" type="text"
						  class="ckeditor" id="iisiopsib" name="iisiopsib" maxlength="1000"></textarea>
				</div>
			</div>

			<div class="form-group" style="margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">[Gambar]</label>
				<div style="margin-left:32px;width: 250px;height: auto;">
					<table style="margin-left:0px; width:250px;border: 1px solid black;">
						<tr>
							<th>
								<img id="previewinggbopsib" width="250px" src="">
							</th>
						</tr>
					</table>
				</div>
				<h4 style="display: none;" id='loadinggbopsib'>uploading ... </h4>
			</div>

			<form class="form-horizontal" id="submitgbopsib" style="margin-left: 25px;">
				<div class="form-group" style="margin-left: 30px">
					<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
					<input style="display:inline;margin-left: 20px;" type="file" name="fgbopsib" id="fgbopsib"
						   accept="image/*">
					<br>
					<button style="display:inline-block;margin-left: 20px;" id="btn_gbopsib" type="submit">Terapkan
					</button>
					<button onclick="return hapusgbopsib();" style="display:inline-block;margin-left: 20px;"
							id="btn_hapusopsib">
						Hapus
					</button>
					<br>
					<span style="margin-left: 20px" id="messagegbopsib"></span>
				</div>
			</form>

			<!-------------------------------------- OPSI C------------------------------------------->

			<div class="form-group" style="margin-top: 10px;margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">
					<hr style="border: #9d261d 2px solid">
					<div style="font-weight: bold;font-size: larger;text-align: center">C</div>
					<p></p></label>
				<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;margin:0;padding:0" type="text"
						  class="ckeditor" id="iisiopsic" name="iisiopsic" maxlength="1000"></textarea>
				</div>
			</div>

			<div class="form-group" style="margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">[Gambar]</label>
				<div style="margin-left:32px;width: 250px;height: auto;">
					<table style="margin-left:0px; width:250px;border: 1px solid black;">
						<tr>
							<th>
								<img id="previewinggbopsic" width="250px" src="">
							</th>
						</tr>
					</table>
				</div>
				<h4 style="display: none;" id='loadinggbopsic'>uploading ... </h4>
			</div>

			<form class="form-horizontal" id="submitgbopsic" style="margin-left: 25px;">
				<div class="form-group" style="margin-left: 30px">
					<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
					<input style="display:inline;margin-left: 20px;" type="file" name="fgbopsic" id="fgbopsic"
						   accept="image/*">
					<br>
					<button style="display:inline-block;margin-left: 20px;" id="btn_gbopsic" type="submit">Terapkan
					</button>
					<button onclick="return hapusgbopsic();" style="display:inline-block;margin-left: 20px;"
							id="btn_hapusopsic">
						Hapus
					</button>
					<br>
					<span style="margin-left: 20px" id="messagegbopsic"></span>
				</div>
			</form>

			<!-------------------------------------- OPSI D------------------------------------------->

			<div class="form-group" style="margin-top: 10px;margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">
					<hr style="border: #9d261d 2px solid">
					<div style="font-weight: bold;font-size: larger;text-align: center">D</div>
					<p></p></label>
				<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;margin:0;padding:0" type="text"
						  class="ckeditor" id="iisiopsid" name="iisiopsid" maxlength="1000"></textarea>
				</div>
			</div>

			<div class="form-group" style="margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">[Gambar]</label>
				<div style="margin-left:32px;width: 250px;height: auto;">
					<table style="margin-left:0px; width:250px;border: 1px solid black;">
						<tr>
							<th>
								<img id="previewinggbopsid" width="250px" src="">
							</th>
						</tr>
					</table>
				</div>
				<h4 style="display: none;" id='loadinggbopsid'>uploading ... </h4>
			</div>

			<form class="form-horizontal" id="submitgbopsid" style="margin-left: 25px;">
				<div class="form-group" style="margin-left: 30px">
					<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
					<input style="display:inline;margin-left: 20px;" type="file" name="fgbopsid" id="fgbopsid"
						   accept="image/*">
					<br>
					<button style="display:inline-block;margin-left: 20px;" id="btn_gbopsid" type="submit">Terapkan
					</button>
					<button onclick="return hapusgbopsid();" style="display:inline-block;margin-left: 20px;"
							id="btn_hapusopsid">
						Hapus
					</button>
					<br>
					<span style="margin-left: 20px" id="messagegbopsid"></span>
				</div>
			</form>

			<!-------------------------------------- OPSI E------------------------------------------->

			<div class="form-group" style="margin-top: 10px;margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">
					<hr style="border: #9d261d 2px solid">
					<div style="font-weight: bold;font-size: larger;text-align: center">E</div>
					<p></p></label>
				<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;margin:0;padding:0" type="text"
						  class="ckeditor" id="iisiopsie" name="iisiopsie" maxlength="1000"></textarea>
				</div>
			</div>

			<div class="form-group" style="margin-left: 25px;">
				<label for="inputDefault" class="col-md-12 control-label">[Gambar]</label>
				<div style="margin-left:32px;width: 250px;height: auto;">
					<table style="margin-left:0px; width:250px;border: 1px solid black;">
						<tr>
							<th>
								<img id="previewinggbopsie" width="250px" src="">
							</th>
						</tr>
					</table>
				</div>
				<h4 style="display: none;" id='loadinggbopsie'>uploading ... </h4>
			</div>

			<form class="form-horizontal" id="submitgbopsie" style="margin-left: 25px;">
				<div class="form-group" style="margin-left: 30px">
					<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
					<input style="display:inline;margin-left: 20px;" type="file" name="fgbopsie" id="fgbopsie"
						   accept="image/*">
					<br>
					<button style="display:inline-block;margin-left: 20px;" id="btn_gbopsie" type="submit">Terapkan
					</button>
					<button onclick="return hapusgbopsie();" style="display:inline-block;margin-left: 20px;"
							id="btn_hapusopsie">
						Hapus
					</button>
					<br>
					<span style="margin-left: 20px" id="messagegbopsie"></span>
				</div>
			</form>

			<!-------------------------------------- KUNCI ------------------------------------------->

			<div class="form-group" style="margin-top: 10px;">
				<label for="inputDefault" class="col-md-12 control-label">
					<hr style="border: #9d261d 2px solid">
					<div style="font-weight: bold;font-size: larger;">Kunci Jawaban</div>
					<p></p></label>
				<div id="opsi">
					<select id="kuncijawab" style="margin-top: 10px;margin-left: 25px;">
						<option value="0">--Kunci Jawaban--</option>
						<option value="1">A</option>
						<option value="2">B</option>
						<option value="3">C</option>
						<option value="4">D</option>
						<option value="5">E</option>
					</select>
				</div>
			</div>

			<!------------------------------------------------------------------------------->

			<?php
			$attributes = array('id' => 'myform1');
			echo form_open('channel/updatesoal/'.$linklist.$alamat, $attributes);
			?>

			<input type="hidden" id="adagbsoal" name="adagbsoal" value=""/>
			<input type="hidden" id="adagbopsia" name="adagbopsia" value=""/>
			<input type="hidden" id="adagbopsib" name="adagbopsib" value=""/>
			<input type="hidden" id="adagbopsic" name="adagbopsic" value=""/>
			<input type="hidden" id="adagbopsid" name="adagbopsid" value=""/>
			<input type="hidden" id="adagbopsie" name="adagbopsie" value=""/>
			<input type="hidden" id="textsoal" name="textsoal" value=""/>
			<input type="hidden" id="textopsia" name="textopsia" value=""/>
			<input type="hidden" id="textopsib" name="textopsib" value=""/>
			<input type="hidden" id="textopsic" name="textopsic" value=""/>
			<input type="hidden" id="textopsid" name="textopsid" value=""/>
			<input type="hidden" id="textopsie" name="textopsie" value=""/>
			<input type="hidden" id="kuncisoal" name="kuncisoal" value=""/>
			<input type="hidden" id="idsoal" name="idsoal" value=""/>

			<div class="col-md-10 col-md-offset-0" style="margin-left:10px;margin-bottom:30px">
				<button style="display: inline;" id="tbbatal" class="btn btn-danger"
						onclick="return dibatal()">Batal
				</button>
				<button style="display: inline;" id="tbupdate" type="submit" class="btn btn-primary"
						onclick="return cekupdate()">Simpan
				</button>
			</div>

			<?php
			echo form_close() . '';
			?>

		</div>
	</div>
	<hr>
	<div id="dmenubawah" style="margin-left:25px;margin-bottom: 30px;">
		<button class="btn btn-danger" onclick="return kembalichannel();">Kembali ke Daftar Channel</button>
		<button class="btn btn-primary" onclick="return setingsoal();">Seting Soal</button>
		<button class="btn btn-primary" onclick="return lihatsoal();">Lihat Soal</button>
		<?php if($kodeevent==null) { ?>
		<button class="btn btn-primary" onclick="return lihatnilai();">Nilai Siswa</button>
		<?php } ?>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css">

<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}

	.width-80 {
		width: 80px;
	}

	@media screen and (min-width: 800px) {
		.width-80 {
			width: 180px;
		}
	}
</style>

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url('ckeditor/ckeditor.js'); ?>"></script>


<script>

	CKEDITOR.config.height = '100px';
	CKEDITOR.config.removePlugins = 'cloudservices';
	//CKEDITOR.config.entities = false;
	CKEDITOR.addCss(".cke_editable{cursor:text; font-size: 15px; font-family: Arial, sans-serif;}");

	var idtextarea = new Array();
	idtextarea[1] = 'iisisoal';
	idtextarea[2] = 'iisiopsia';
	idtextarea[3] = 'iisiopsib';
	idtextarea[4] = 'iisiopsic';
	idtextarea[5] = 'iisiopsid';
	idtextarea[6] = 'iisiopsie';
	for (a=1;a<=6;a++) {
		CKEDITOR.replace(idtextarea[a], {
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
	}

	var idsoal = new Array();
	var soaltxt = new Array();
	var soalgbr = new Array();
	var opsiatxt = new Array();
	var opsiagbr = new Array();
	var opsibtxt = new Array();
	var opsibgbr = new Array();
	var opsictxt = new Array();
	var opsicgbr = new Array();
	var opsidtxt = new Array();
	var opsidgbr = new Array();
	var opsietxt = new Array();
	var opsiegbr = new Array();
	var kunci = new Array();
	var selek = new Array();
	var pilihan = 0;
	var soalbaru = 0;

	jmlsoal = <?php echo $jml;?>;

	<?php for ($a = 1; $a <= $jml; $a++) {
		echo 'idsoal[' . $a . '] = ' . $id[$a] . "; \r\n";
		echo 'soaltxt[' . $a . '] = "' . $soaltxt[$a] . '"' . "; \r\n";
		echo 'soalgbr[' . $a . '] = "' . $soalgbr[$a] . '"' . "; \r\n";
		echo 'opsiatxt[' . $a . '] = "' . $opsiatxt[$a] . '"' . "; \r\n";
		echo 'opsiagbr[' . $a . '] = "' . $opsiagbr[$a] . '"' . "; \r\n";
		echo 'opsibtxt[' . $a . '] = "' . $opsibtxt[$a] . '"' . "; \r\n";
		echo 'opsibgbr[' . $a . '] = "' . $opsibgbr[$a] . '"' . "; \r\n";
		echo 'opsictxt[' . $a . '] = "' . $opsictxt[$a] . '"' . "; \r\n";
		echo 'opsicgbr[' . $a . '] = "' . $opsicgbr[$a] . '"' . "; \r\n";
		echo 'opsidtxt[' . $a . '] = "' . $opsidtxt[$a] . '"' . "; \r\n";
		echo 'opsidgbr[' . $a . '] = "' . $opsidgbr[$a] . '"' . "; \r\n";
		echo 'opsietxt[' . $a . '] = "' . $opsietxt[$a] . '"' . "; \r\n";
		echo 'opsiegbr[' . $a . '] = "' . $opsiegbr[$a] . '"' . "; \r\n";
		echo 'kunci[' . $a . '] = "' . $kunci[$a] . '"' . "; \r\n";
	}
	?>

	$(document).ready(function () {

		var table = $('#tbl_user').DataTable({
			'language': {
				'paginate': {
					'previous': '<',
					'next': '>'
				}
			},
			"pagingType": "numbers",
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap'>" + data + "</div>";
					},
					targets: [1]
				},
				{
					width: 10,
					targets: 0
				}
			]

		});

		new $.fn.dataTable.FixedHeader(table);

		$('#tbl_user tbody').on('click', 'tr', function () {
			// if ($(this).hasClass('selected')) {
			// 	// $(this).removeClass('selected');
			// } else {
			// 	table.$('tr.selected').removeClass('selected');
			// 	$(this).addClass('selected');
			// }
		});

		$('#submitgbsoal').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadgbr("gbsoal", "soalgbr", data);
		});

		$('#submitgbopsia').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadgbr("gbopsia", "opsiagbr", data);
		});

		$('#submitgbopsib').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadgbr("gbopsib", "opsibgbr", data);
		});

		$('#submitgbopsic').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadgbr("gbopsic", "opsicgbr", data);
		});

		$('#submitgbopsid').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadgbr("gbopsid", "opsidgbr", data);
		});

		$('#submitgbopsie').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadgbr("gbopsie", "opsiegbr", data);
		});

		function uploadgbr(idx, field, data) {
			$('#loading' + idx).show();
			$.ajax({
				url: '<?php echo base_url(); ?>channel/upload_gambarsoal/<?php echo $linklist;?>/' + pilihan + '/' + idx + '/' + field,
				type: "post",
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading' + idx).hide();
					$("#message" + idx).html(data);
				}
			});
		}

	});

	$(function () {
		$("#fgbsoal").change(function () {
			$("#adagbsoal").val("ada");
			var file = this.files[0];
			updategambar(file, "gbsoal");
		});

		$("#fgbopsia").change(function () {
			$("#adagbopsia").val("ada");
			var file = this.files[0];
			updategambar(file, "gbopsia");
		});

		$("#fgbopsib").change(function () {
			$("#adagbopsib").val("ada");
			var file = this.files[0];
			updategambar(file, "gbopsib");
		});

		$("#fgbopsic").change(function () {
			$("#adagbopsic").val("ada");
			var file = this.files[0];
			updategambar(file, "gbopsic");
		});

		$("#fgbopsid").change(function () {
			$("#adagbopsid").val("ada");
			var file = this.files[0];
			updategambar(file, "gbopsid");
		});

		$("#fgbopsie").change(function () {
			$("#adagbopsie").val("ada");
			var file = this.files[0];
			updategambar(file, "gbopsie");
		});

	});

	function updategambar(file, idx) {
		$("#message" + idx).empty(); // To remove the previous error message
		var imagefile = file.type;
		var match = ["image/jpeg", "image/png", "image/jpg"];
		if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
			// $('#previewing').attr('src','noimage.png');
			$("#message" + idx).html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
			return false;
		} else {
			var reader = new FileReader();
			reader.onload = imageIsLoadedn;
			reader.readAsDataURL(file);

			function imageIsLoadedn(e) {
				$("#f" + idx).css("color", "green");
				$('#image_preview' + idx).css("display", "block");
				$('#previewing' + idx).attr('src', e.target.result);
				$('#previewing' + idx).attr('width', '300px');
				$('#previewing' + idx).attr('height', 'auto');
			};
		}
	}

	function gaksido() {

		return false;
	}

	function hapusgbsoal() {
		$("#adagbsoal").val("tidak");
		$('#messagegbsoal').text("");
		$('#previewinggbsoal').attr('src', '');
		return false;
	}

	function hapusgbopsia() {
		$("#adagbopsia").val("tidak");
		$('#messagegbopsia').text("");
		$('#previewinggbopsia').attr('src', '');
		return false;
	}

	function hapusgbopsib() {
		$("#adagbopsib").val("tidak");
		$('#messagegbopsib').text("");
		$('#previewinggbopsib').attr('src', '');
		return false;
	}

	function hapusgbopsic() {
		$("#adagbopsic").val("tidak");
		$('#messagegbopsic').text("");
		$('#previewinggbopsic').attr('src', '');
		return false;
	}

	function hapusgbopsid() {
		$("#adagbopsid").val("tidak");
		$('#messagegbopsid').text("");
		$('#previewinggbopsid').attr('src', '');
		return false;
	}

	function hapusgbopsie() {
		$("#adagbopsie").val("tidak");
		$('#messagegbopsie').text("");
		$('#previewinggbopsie').attr('src', '');
		return false;
	}

	function ditambah() {
		$("#dmenubawah").hide();
		$.ajax({
			type: 'GET',
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>channel/insertsoal/<?php echo $linklist;?>',
			success: function (result) {
				if (result != "gagal") {
					newblank(result);
				} else {
					alert ("Gagal");
				}
			}
		});
	}

	function newblank(id)
	{
		soalbaru = 1;
		terakhir = jmlsoal + 1;
		pilihan = id;
		$('#soalnomor').html('Buat Pertanyaan No. ' + terakhir);
		CKEDITOR.instances["iisisoal"].setData("");
		$("#previewinggbsoal").attr("src", "");
		CKEDITOR.instances["iisiopsia"].setData("");
		$("#previewinggbopsia").attr("src", "");
		CKEDITOR.instances["iisiopsib"].setData("");
		$("#previewinggbopsib").attr("src", "");
		CKEDITOR.instances["iisiopsic"].setData("");
		$("#previewinggbopsic").attr("src", "");
		CKEDITOR.instances["iisiopsid"].setData("");
		$("#previewinggbopsid").attr("src", "");
		CKEDITOR.instances["iisiopsie"].setData("");
		$("#previewinggbopsie").attr("src", "");
		isiopsi = '<select id="kuncijawab" style="margin-top: 10px;margin-left: 25px;">\n' +
			'\t\t\t\t\t<option value="0">--Kunci Jawaban--</option>\n' +
			'\t\t\t\t\t<option value="1">A</option>\n' +
			'\t\t\t\t\t<option value="2">B</option>\n' +
			'\t\t\t\t\t<option value="3">C</option>\n' +
			'\t\t\t\t\t<option value="4">D</option>\n' +
			'\t\t\t\t\t<option value="5">E</option>\n' +
			'\t\t\t\t</select>';
		$("#opsi").html(isiopsi);
		$("#addeditsoal").show();
		$("#addedit").val("add");
		$("#dtambah").hide();
	}

	function dibatal() {
		$("#addeditsoal").hide();
		$("#dtambah").show();
		$("#dmenubawah").show();
		if (soalbaru == 1) {
			$.ajax({
				url: "<?php echo base_url();?>channel/delsoal",
				method: "POST",
				data: {id_soal: pilihan},
				success: function (result) {
					if (result == "berhasil")
						soalbaru = 0;
					else
						alert("Gagal menghapus");
				}
			});
		}
		return false;
	}

	function diedit(nomor) {
		pilihan = idsoal[nomor];
		$("#addeditsoal").show();
		$("#addedit").val("edit");
		$("#dtambah").hide();
		$("#dmenubawah").hide();
		$('#soalnomor').html('Edit Pertanyaan No. ' + nomor);
		CKEDITOR.instances["iisisoal"].setData(soaltxt[nomor]);
		if (soalgbr[nomor] == "") {
			$("#previewinggbsoal").attr("src", "");
			$("#messagegbsoal").text("");
		}
		else {
			$("#previewinggbsoal").attr("src", "<?php echo base_url();?>uploads/soal/" + soalgbr[nomor]);
			$("#messagegbsoal").text("[Gambar OK]");
		}

		if (opsiatxt[nomor] == "")
			CKEDITOR.instances["iisiopsia"].setData("");
		else
			CKEDITOR.instances["iisiopsia"].setData(opsiatxt[nomor]);

		if (opsiagbr[nomor] == "") {
			$("#previewinggbopsia").attr("src", "");
			$("#messagegbopsia").text("");
		}
		else {
			$("#previewinggbopsia").attr("src", "<?php echo base_url();?>uploads/soal/" + opsiagbr[nomor]);
			$("#messagegbopsia").text("[Gambar OK]");
		}

		if (opsibtxt[nomor] == "")
			CKEDITOR.instances["iisiopsib"].setData("");
		else
			CKEDITOR.instances["iisiopsib"].setData(opsibtxt[nomor]);

		if (opsibgbr[nomor] == "") {
			$("#previewinggbopsib").attr("src", "");
			$("#messagegbopsib").text("");
		} else {
			$("#previewinggbopsib").attr("src", "<?php echo base_url();?>uploads/soal/" + opsibgbr[nomor]);
			$("#messagegbopsib").text("[Gambar OK]");
		}

		if (opsictxt[nomor] == "")
			CKEDITOR.instances["iisiopsic"].setData("");
		else
			CKEDITOR.instances["iisiopsic"].setData(opsictxt[nomor]);

		if (opsicgbr[nomor] == "") {
			$("#previewinggbopsic").attr("src", "");
			$("#messagegbopsic").text("");
		}
		else {
			$("#previewinggbopsic").attr("src", "<?php echo base_url();?>uploads/soal/" + opsicgbr[nomor]);
			$("#messagegbopsic").text("[Gambar OK]");
		}

		if (opsidtxt[nomor] == "")
			CKEDITOR.instances["iisiopsid"].setData("");
		else
			CKEDITOR.instances["iisiopsid"].setData(opsidtxt[nomor]);

		if (opsidgbr[nomor] == "") {
			$("#previewinggbopsid").attr("src", "");
			$("#messagegbopsid").text("");
		}
		else {
			$("#previewinggbopsid").attr("src", "<?php echo base_url();?>uploads/soal/" + opsidgbr[nomor]);
			$("#messagegbopsid").text("[Gambar OK]");
		}

		if (opsietxt[nomor] == "")
			CKEDITOR.instances["iisiopsie"].setData("");
		else
			CKEDITOR.instances["iisiopsie"].setData(opsietxt[nomor]);

		if (opsiegbr[nomor] == "") {
			$("#previewinggbopsie").attr("src", "");
			$("#messagegbopsie").text("");
		}
		else {
			$("#previewinggbopsie").attr("src", "<?php echo base_url();?>uploads/soal/" + opsiegbr[nomor]);
			$("#messagegbopsie").text("[Gambar OK]");
		}

		for (a = 1; a <= 5; a++) {
			selek[a] = "";
			if (kunci[nomor] == a)
				selek[a] = " selected ";
		}

		isiopsi = '<select id="kuncijawab" style="margin-top: 10px;margin-left: 25px;">\n' +
			'\t\t\t\t\t<option value="0">--Kunci Jawaban--</option>\n' +
			'\t\t\t\t\t<option ' + selek[1] + ' value="1">A</option>\n' +
			'\t\t\t\t\t<option ' + selek[2] + ' value="2">B</option>\n' +
			'\t\t\t\t\t<option ' + selek[3] + ' value="3">C</option>\n' +
			'\t\t\t\t\t<option ' + selek[4] + ' value="4">D</option>\n' +
			'\t\t\t\t\t<option ' + selek[5] + ' value="5">E</option>\n' +
			'\t\t\t\t</select>';
		$("#opsi").html(isiopsi);
	}

	function cekupdate() {
		var soaloke = false;
		var opsioke = false;
		var kuncioke = false;
		var teksoke1,teksoke2,teksoke3,teksoke4,teksoke5,teksoke6;

		teksoke1 = CKEDITOR.instances['iisisoal'].getData().replace(/"/g, '').replace(/'/g, '');
		$('#textsoal').val(teksoke1);
		teksoke2 = CKEDITOR.instances['iisiopsia'].getData().replace(/"/g, '').replace(/'/g, '');
		$('#textopsia').val(teksoke2);
		teksoke3 = CKEDITOR.instances['iisiopsib'].getData().replace(/"/g, '').replace(/'/g, '');
		$('#textopsib').val(teksoke3);
		teksoke4 = CKEDITOR.instances['iisiopsic'].getData().replace(/"/g, '').replace(/'/g, '');
		$('#textopsic').val(teksoke4);
		teksoke5 = CKEDITOR.instances['iisiopsid'].getData().replace(/"/g, '').replace(/'/g, '');
		$('#textopsid').val(teksoke5);
		teksoke6 = CKEDITOR.instances['iisiopsie'].getData().replace(/"/g, '').replace(/'/g, '');
		$('#textopsie').val(teksoke6);
		$('#idsoal').val(pilihan);
		$('#kuncisoal').val($('#kuncijawab').val());

		if ($('#messagegbsoal').text() == "")
			$('#adagbsoal').val("kosong");
		else
			$('#adagbsoal').val("ada");

		if ($('#messagegbopsia').text() == "")
			$('#adagbopsia').val("kosong");
		else
			$('#adagbopsia').val("ada");

		if ($('#messagegbopsib').text() == "")
			$('#adagbopsib').val("kosong");
		else
			$('#adagbopsib').val("ada");

		if ($('#messagegbopsic').text() == "")
			$('#adagbopsic').val("kosong");
		else
			$('#adagbopsic').val("ada");

		if ($('#messagegbopsid').text() == "")
			$('#adagbopsid').val("kosong");
		else
			$('#adagbopsid').val("ada");

		if ($('#messagegbopsie').text() == "")
			$('#adagbopsie').val("kosong");
		else
			$('#adagbopsie').val("ada");

		if ($('#textsoal').val()!="")
		{
			soaloke=true;
		}
		if (($('#textopsia').val()!="" || $('#adagbopsia').val()=="ada") &&
			($('#textopsib').val()!="" || $('#adagbopsib').val()=="ada"))
		{
			opsioke=true;
		}
		if ($('#kuncisoal').val()>0)
		{
			kuncioke=true;
		}

		var textsoalok = $('#textsoal').val().replace(/(?:<br \/>)/g, '');
		textsoalok = textsoalok.replace(/(?:\r\n|\r|\n)/g, '<br>');
		$('#textsoal').val(textsoalok);

		var textopsiaok = $('#textopsia').val().replace(/(?:<br \/>)/g, '');
		textopsiaok = textopsiaok.replace(/(?:\r\n|\r|\n)/g, '<br>');
		$('#textopsia').val(textopsiaok);

		var textopsibok = $('#textopsib').val().replace(/(?:<br \/>)/g, '');
		textopsibok = textopsibok.replace(/(?:\r\n|\r|\n)/g, '<br>');
		$('#textopsib').val(textopsibok);

		var textopsicok = $('#textopsic').val().replace(/(?:<br \/>)/g, '');
		textopsicok = textopsicok.replace(/(?:\r\n|\r|\n)/g, '<br>');
		$('#textopsic').val(textopsicok);

		var textopsidok = $('#textopsid').val().replace(/(?:<br \/>)/g, '');
		textopsidok = textopsidok.replace(/(?:\r\n|\r|\n)/g, '<br>');
		$('#textopsid').val(textopsidok);

		var textopsieok = $('#textopsie').val().replace(/(?:<br \/>)/g, '');
		textopsieok = textopsieok.replace(/(?:\r\n|\r|\n)/g, '<br>');
		$('#textopsie').val(textopsieok);

		if (soaloke && opsioke && kuncioke) {
			$('#myform1').submit();
			return true;
		} else {
			alert('Minimal harus ada Soal, 2 Opsi Pilihan, dan Kunci Jawaban');
			return false;
		}
	}

	function dihapus(id)
	{
		var r = confirm("Mau menghapus soal ini?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url();?>channel/delsoal",
				method: "POST",
				data: {id_soal: id},
				success: function (result) {
					if (result=="berhasil")
						location.reload();
					else
						alert ("Gagal menghapus");
				}
			});
		} else {
			return false;
		}
		return false;
	}

	function kembalichannel()
	{
		window.open("<?php echo base_url().'channel/playlistguru'.$alamat;?>","_self");
	}

	function setingsoal()
	{
		window.open("<?php echo base_url();?>channel/soal/seting/<?php echo $linklist.$alamat;?>","_self");
	}

	function lihatsoal()
	{
		if (jmlsoal>0)
		window.open("<?php echo base_url();?>channel/soal/<?php echo $linklist.'/'.$asal.$alamat;?>","_self");
		else
			alert ("Silakan membuat soal terlebih dahulu!");
	}

	function lihatnilai()
	{
		window.open("<?php echo base_url();?>channel/soal/nilaisiswa/<?php echo $linklist;?>","_self");
	}


</script>
