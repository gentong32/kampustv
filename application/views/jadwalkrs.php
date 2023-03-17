<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$tglmulai = new DateTime($datakrs->jadwal_krs_1_start);
$tglmulai = $tglmulai->format("d-m-Y H:i");

$tglselesai = new DateTime($datakrs->jadwal_krs_1_end);
$tglselesai = $tglselesai->format("d-m-Y H:i");

$tglmulai2 = new DateTime($datakrs->jadwal_krs_2_start);
$tglmulai2 = $tglmulai2->format("d-m-Y H:i");

$tglselesai2 = new DateTime($datakrs->jadwal_krs_2_end);
$tglselesai2 = $tglselesai2->format("d-m-Y H:i");

// echo $datakrs->start_tgl1;

for($a=1;$a<=22;$a=$a+7)
{
	$selt1[$a]="";
	if ($a==$datakrs->start_tgl1)
	$selt1[$a]="selected";

	$selt2[$a]="";
	if ($a==$datakrs->start_tgl2)
	$selt2[$a]="selected";
}

// echo $selt1[];

for($a=1;$a<=12;$a++)
{
	$selb1[$a]="";
	if ($a==$datakrs->start_bln1)
	$selb1[$a]="selected";

	$selb2[$a]="";
	if ($a==$datakrs->start_bln2)
	$selb2[$a]="selected";
}
?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>

	<!-- section begin -->
	<section id="subheader" class="text-light" data-bgimage="url(<?php echo base_url();?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Jadwal KRS</h1>
					</div>

					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section">
		<div class="container">
			<center><h3>Tahun Ajaran 2022/2023</h3></center>
			<div class="row">
			<center>
				<div style="max-width:500px;border:1px solid black; padding-top:30px;">
					<h4>Jadwal Pengisian KRS untuk Mahasiswa</h4>
					<div class="form-group" style="margin-top: 10px;margin-left:15px;">
						<label for="inputDefault" class="col-md-6 control-label"><b>Semester 1</b></label>
						<div style="margin: auto;">
							<div style="display: inline-block;margin-bottom: 5px;">
								<input type="text" value="<?php echo substr($tglmulai,0,10); ?>" name="datetime1" id="datetime1"
									class="form-control" style="width: 180px">
							</div> s/d
							<div style="display: inline-block;margin-bottom: 5px;">
								<input type="text" value="<?php echo substr($tglselesai,0,10); ?>" name="datetime2" id="datetime2"
									class="form-control" style="width: 180px">
							</div>
							<div style="margin-bottom: 5px;">
							<button onclick="edit1();" id="edit1e" class="btn-main">
								Edit
							</button>
							<button onclick="update1();" id="edit1u" style="display:none;" class="btn-main">
								Update
							</button>
							</div>
						</div>
						<br>
						<label for="inputDefault" class="col-md-6 control-label"><b>Semester 2</b></label>
						<div style="margin: auto;">
							<div style="display: inline-block;margin-bottom: 5px;">
								<input type="text" value="<?php echo substr($tglmulai2,0,10); ?>" name="datetime3" id="datetime3"
									class="form-control" style="width: 180px">
							</div> s/d
							<div style="display: inline-block;margin-bottom: 5px;">
								<input type="text" value="<?php echo substr($tglselesai2,0,10); ?>" name="datetime4" id="datetime4"
									class="form-control" style="width: 180px">
							</div>
							<div style="margin-bottom: 5px;">
							<button onclick="edit2();" id="edit2e" class="btn-main">
								Edit
							</button>
							<button onclick="update2();" id="edit2u" style="display:none;" class="btn-main">
								Update
							</button>
							</div>
						</div>

					</div>

					</div>
					<br><br>
					<div style="max-width:500px;border:1px solid black; padding-top:30px;">

					<h4>Awal perkuliahan untuk Mahasiswa</h4>
					<div class="form-group" style="margin-top: 10px;margin:auto;">
						<label for="inputDefault" class="col-md-6 control-label"><b>Semester 1</b></label>
						<div style="margin: auto;">
							<div style="display: inline-block;margin-bottom: 5px;">
							<select id="tgl_start_kuliah1" style="height:35px;">
								<option <?=$selt1[1]?> value="1">1 - 7</option>
								<option <?=$selt1[8]?> value="8">8 - 14</option>
								<option <?=$selt1[15]?> value="15">15 - 21</option>
								<option <?=$selt1[22]?> value="21">22 - ...</option>
							</select>
							</div>
							<div style="display: inline-block;margin-bottom: 5px;">
							<select id="bln_start_kuliah1" style="height:35px;">
								<!-- <option <?=$selb1[1]?> value="1">Januari</option> -->
								<!-- <option <?=$selb1[2]?> value="2">Pebruari</option>
								<option <?=$selb1[3]?> value="3">Maret</option> -->
								<!-- <option <?=$selb1[4]?> value="4">April</option>
								<option <?=$selb1[5]?> value="5">Mei</option>
								<option <?=$selb1[6]?> value="6">Juni</option>
								<option <?=$selb1[7]?> value="7">Juli</option> -->
								<option <?=$selb1[8]?> value="8">Agustus</option>
								<option <?=$selb1[9]?> value="9">September</option>
								<!-- <option <?=$selb1[10]?> value="10">Oktober</option>
								<option <?=$selb1[11]?> value="11">Nopember</option>
								<option <?=$selb1[12]?> value="12">Desember</option> -->
							</select>
							</div>
							<div style="margin-bottom: 5px;">
							<button onclick="editstart1();" id="editstart1e" class="btn-main">
								Edit
							</button>
							<button onclick="updatestart1();" id="editstart1u" style="display:none;" class="btn-main">
								Update
							</button>
							</div>
						</div>
						<br>
						<label for="inputDefault" class="col-md-6 control-label"><b>Semester 2</b></label>
						<div style="margin: auto;">
						<div style="display: inline-block;margin-bottom: 5px;">
							<select id="tgl_start_kuliah2" style="height:35px;">
								<option <?=$selt2[1]?> value="1">1 - 7</option>
								<option <?=$selt2[8]?> value="8">8 - 14</option>
								<option <?=$selt2[15]?> value="15">15 - 21</option>
								<option <?=$selt2[22]?> value="21">22 - ...</option>
							</select>
							</div>
							<div style="display: inline-block;margin-bottom: 5px;">
							<select id="bln_start_kuliah2" style="height:35px;">
								<!-- <option <?=$selb2[1]?> value="1">Januari</option> -->
								<option <?=$selb2[2]?> value="2">Pebruari</option>
								<option <?=$selb2[3]?> value="3">Maret</option>
								<!-- <option <?=$selb2[4]?> value="4">April</option>
								<option <?=$selb2[5]?> value="5">Mei</option>
								<option <?=$selb2[6]?> value="6">Juni</option>
								<option <?=$selb2[7]?> value="7">Juli</option> -->
								<!-- <option <?=$selb2[8]?> value="8">Agustus</option>
								<option <?=$selb2[9]?> value="9">September</option> -->
								<!-- <option <?=$selb2[10]?> value="10">Oktober</option>
								<option <?=$selb2[11]?> value="11">Nopember</option>
								<option <?=$selb2[12]?> value="12">Desember</option> -->
							</select>
							</div>
							<div style="margin-bottom: 5px;">
							<button onclick="editstart2();" id="editstart2e" class="btn-main">
								Edit
							</button>
							<button onclick="updatestart2();" id="editstart2u" style="display:none;" class="btn-main">
								Update
							</button>
							</div>
						</div>

					</div>

					<div class="spacer-single"></div>
				
			</center>
			</div>
		</div>
	</section>

</div>
<!-- content close -->

<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>

<script>
	$("#datetime1").prop('disabled', true);
	$("#datetime2").prop('disabled', true);
	$("#datetime3").prop('disabled', true);
	$("#datetime4").prop('disabled', true);
	$("#tgl_start_kuliah1").prop('disabled', true);
	$("#bln_start_kuliah1").prop('disabled', true);
	$("#tgl_start_kuliah2").prop('disabled', true);
	$("#bln_start_kuliah2").prop('disabled', true);
	
	$("#datetime1").datetimepicker({
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

	$("#datetime3").datetimepicker({
		format: 'dd-mm-yyyy',
		minView: 2,
		autoclose: true,
		todayBtn: true
	});

	$("#datetime4").datetimepicker({
		format: 'dd-mm-yyyy',
		minView: 2,
		autoclose: true,
		todayBtn: true
	});

	function edit1()
	{
		$('#edit1e').hide();
		$('#edit1u').show();
		$("#datetime1").prop('disabled', false);
		$("#datetime2").prop('disabled', false);
	}

	function edit2()
	{
		$('#edit2e').hide();
		$('#edit2u').show();
		$("#datetime3").prop('disabled', false);
		$("#datetime4").prop('disabled', false);
	}

	function update1()
	{
		$.ajax({
			url: "<?php echo base_url(); ?>virtualkelas/updatejadwalkrs/1",
			method: "POST",
			data: {tgl1: $("#datetime1").val(), tgl2: $("#datetime2").val()},
			success: function (result) {
				if (result=="sukses")
				{
					$('#edit1e').show();
					$('#edit1u').hide();
					$("#datetime1").prop('disabled', true);
					$("#datetime2").prop('disabled', true);
				}
				else
				{
					alert ("Gagal!");
				}
			}
		})
	}

	function update2()
	{
		$.ajax({
			url: "<?php echo base_url(); ?>virtualkelas/updatejadwalkrs/2",
			method: "POST",
			data: {tgl1: $("#datetime3").val(), tgl2: $("#datetime4").val()},
			success: function (result) {
				if (result=="sukses")
				{
					$('#edit2e').show();
					$('#edit2u').hide();
					$("#datetime3").prop('disabled', true);
					$("#datetime4").prop('disabled', true);
				}
				else
				{
					alert ("Gagal!");
				}
			}
		})
	}

	function editstart1()
	{
		$('#editstart1e').hide();
		$('#editstart1u').show();
		$("#tgl_start_kuliah1").prop('disabled', false);
		$("#bln_start_kuliah1").prop('disabled', false);
	}

	function editstart2()
	{
		$('#editstart2e').hide();
		$('#editstart2u').show();
		$("#tgl_start_kuliah2").prop('disabled', false);
		$("#bln_start_kuliah2").prop('disabled', false);
	}

	function updatestart1()
	{
		$.ajax({
			url: "<?php echo base_url(); ?>virtualkelas/updatemulaikuliah/1",
			method: "POST",
			data: {tglstart: $("#tgl_start_kuliah1").val(), blnstart: $("#bln_start_kuliah1").val()},
			success: function (result) {
				if (result=="sukses")
				{
					$('#editstart1e').show();
					$('#editstart1u').hide();
					$("#tgl_start_kuliah1").prop('disabled', true);
					$("#bln_start_kuliah1").prop('disabled', true);
				}
				else
				{
					alert ("Gagal!");
				}
			}
		})
	}

	function updatestart2()
	{
		$.ajax({
			url: "<?php echo base_url(); ?>virtualkelas/updatemulaikuliah/2",
			method: "POST",
			data: {tglstart: $("#tgl_start_kuliah2").val(), blnstart: $("#bln_start_kuliah2").val()},
			success: function (result) {
				if (result=="sukses")
				{
					$('#editstart2e').show();
					$('#editstart2u').hide();
					$("#tgl_start_kuliah2").prop('disabled', true);
					$("#bln_start_kuliah2").prop('disabled', true);
				}
				else
				{
					alert ("Gagal!");
				}
			}
		})
	}

</script>

