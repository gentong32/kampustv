<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nama_status = Array('-', 'Aktif', 'Tak aktif');
$cekduplikat = array();
$rowduplikat = array();
$terdaftarevent = array();
$daftarnpsnpeserta = array();

$jml_channel = 0;
foreach ($dafpesertalomba as $datane)
{
	$daftarnpsnpeserta[] = $datane->npsn;
}

foreach ($dafchannel as $datane) {
	if (in_array($datane->id_user, $cekduplikat)) {
		$jmlvideo[$rowduplikat[$datane->id_user]] = ($jmlvideo[$rowduplikat[$datane->id_user]] + $datane->jmlvideo);
		$jmlnontonguru[$rowduplikat[$datane->id_user]] = $jmlnontonguru[$rowduplikat[$datane->id_user]] + ($datane->jmlnontonguru/60);
		$jmlviewer[$rowduplikat[$datane->id_user]] = $jmlviewer[$rowduplikat[$datane->id_user]] + ($datane->jmlviewer);
		continue;
	} else {
		$jml_channel++;
		if (in_array($datane->npsn, $daftarnpsnpeserta))
		{
			$terdaftarevent[$jml_channel] = "Ya";
		} else {
			$terdaftarevent[$jml_channel] = "Tidak";
		}
		$cekduplikat[] = $datane->id_user;
		$rowduplikat[$datane->id_user] = $jml_channel;
		$nomor[$jml_channel] = $jml_channel;
		$id[$jml_channel] = $datane->id;
		$npsn[$jml_channel] = $datane->npsn;
		$jmlpaket[$jml_channel] = $datane->jmlpaket;
		$namaguru[$jml_channel] = $datane->first_name." ".$datane->last_name;
		$jmlvideo[$jml_channel] = 0;
		$jmlnontonguru[$jml_channel] = 0;
		$jmlviewer[$jml_channel] = 0;
		$nama_sekolah[$jml_channel] = $datane->nama_sekolah;
		$status[$jml_channel] = $datane->status_paket;
	}
}

for ($b=1;$b<=$jml_channel;$b++)
{
	if ($jmlpaket[$b]>0)
	$jmlvideo[$b] = $jmlvideo[$b] / $jmlpaket[$b];
}

?>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
	<br>
	<center><span style="font-size:16px;font-weight: bold;"><?php echo $title; ?></span>
	<br><br>

	<div style="margin: auto;">
		<label for="inputDefault" class="col-md-12 control-label">Mulai Nonton</label>
		<div class="col-md-12">
			<input type="text" style="text-align:center;width: 150px" value="<?php echo $mulai;?>" name="datetime" id="datetime1" class="form-control" readonly>
		</div>

		<label for="inputDefault" class="col-md-12 control-label">Nonton Sampai</label>
		<div class="col-md-12">
			<input type="text" style="text-align:center;width: 150px;margin-bottom: 20px;" value="<?php echo $sampai;?>" name="datetime" id="datetime2" class="form-control" readonly>
		</div>

		<button type="button" onclick="window.location.href='<?php echo base_url();?>statistik/dataguru/'" class="">Bulan ini
		</button>
		<button type="button" onclick="return sesuaitgl();" class="">Sesuai batas
		</button>

		<hr style="width: 100%;">
	</div>

	</center>

	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style='padding:5px;width:5px;'>No</th>
				<th>Nama Guru</th>
				<th>Nama Sekolah</th>
				<th>Peserta Lomba</th>
				<th>Jml Paket</th>
				<th>Jml Video</th>
				<th>Ditonton Siswa (Menit)</th>
				<th>Jml Viewer Siswa</th>

			</tr>
			</thead>

			<tbody>
			<?php for ($i = 1; $i <= $jml_channel; $i++) {
				?>
				<tr>
					<td><?php echo $nomor[$i]; ?></td>
					<td><?php echo $namaguru[$i]; ?></td>
					<td><?php echo $nama_sekolah[$i]; ?></td>
					<td><?php echo $terdaftarevent[$i]; ?></td>
					<td><?php echo $jmlpaket[$i]; ?></td>
					<td><?php echo $jmlvideo[$i]; ?></td>
					<td><?php echo $jmlnontonguru[$i]; ?></td>
					<td><?php echo $jmlviewer[$i]; ?></td>

				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<div style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<div id="video-placeholder" style='display:none'></div>
	<div id="videolokal" style='display:none'></div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.bootstrap.min.css">


<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}
</style>

<script src="<?php echo base_url(); ?>js/iframe_api.js"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
<script>

	$(document).ready(function () {
		var table = $('#tbl_user').DataTable({
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [1, 2]
				},
				{
					width: 25,
					targets: 0
				}
			]

		});


		new $.fn.dataTable.FixedHeader(table);

		// Handle click on "Expand All" button
		$('#btn-show-all-children').on('click', function () {
			// Expand row details
			table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
		});

		// Handle click on "Collapse All" button
		$('#btn-hide-all-children').on('click', function () {
			// Collapse row details
			table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
		});
	});

	function gantistatus(id) {
		var statusnya = 1;
		if ($('#st' + id).html() == "Aktif")
			statusnya = 2;

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantistatus",
			method: "POST",
			data: {id: id, status: statusnya},
			success: function (result) {
				if ($('#st' + id).html() == "Aktif")
					$('#st' + id).html('Tak Aktif');
				else
					$('#st' + id).html('Aktif');
			}
		})
	}

	function sesuaitgl() {
		if ($('#datetime1').val()=="")
		{
			alert ("Mulai kapan?");
			return false;
		}
		else
		if ($('#datetime2').val()=="")
		{
			alert ("Sampai kapan?");
			return false;
		}

		window.location.href='<?php echo base_url();?>statistik/dataguru/'+$('#datetime1').val()
			+'/'+$('#datetime2').val();
	}

</script>

<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css" rel="stylesheet">
<!--<link href="--><?php //echo base_url(); ?><!--css/timepicker.min.css" rel="stylesheet"/>-->
<!--<script src="--><?php //echo base_url(); ?><!--js/timepicker.min.js"></script>-->
<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>

<script>
	$("#datetime1").datetimepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		minView: 2,
		todayBtn: true
	});

	$("#datetime2").datetimepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		minView: 2,
		todayBtn: true
	});

	// var timepicker = new TimePicker('time', {
	// 	lang: 'en',
	// 	theme: 'dark'
	// });
	// timepicker.on('change', function(evt) {
	//
	// 	var value = (evt.hour || '00') + ':' + (evt.minute || '00');
	// 	evt.element.value = value;
	//
	// });

</script>
