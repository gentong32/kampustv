<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nama_status = Array('-', 'Aktif', 'Tak aktif');

$jml_channel = 0;
foreach ($dafchannel as $datane) {
	$jml_channel++;
	$nomor[$jml_channel] = $jml_channel;
	$id[$jml_channel] = $datane->id;
	$npsn[$jml_channel] = $datane->npsn;
	$nama_sekolah[$jml_channel] = $datane->nama_sekolah;
//	if (isset($datane->nama_kota))
//		$kota[$jml_channel] = "";
//	else
	$kota[$jml_channel] = $datane->nama_kota;
	$status[$jml_channel] = $datane->status;
}
?>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
	<br>
	<center><span style="font-size:16px;font-weight: bold;"><?php echo $title; ?></span></center>
	<br>
	<hr>

	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style='padding:5px;width:5px;'>No</th>
				<th>NPSN</th>
				<th>Nama Sekolah</th>
				<th>Kota</th>
				<th>Status</th>
				<th>Edit</th>
			</tr>
			</thead>

			<tbody>
			<?php for ($i = 1; $i <= $jml_channel; $i++) {
				?>
				<tr>
					<td><?php echo $nomor[$i]; ?></td>
					<td><?php echo $npsn[$i]; ?></td>
					<td><?php echo $nama_sekolah[$i]; ?></td>
					<td><?php echo $kota[$i]; ?></td>
					<td>
						<div id="st<?php echo $id[$i]; ?>"><?php echo $nama_status[$status[$i]]; ?></div>
					</td>
					<td>
						<button onclick="gantistatus(<?php echo $id[$i]; ?>)" id="thumbnail"
								type="button">Aktif/Non Aktif
						</button>
						<button onclick="window.open('<?php echo base_url()."channel/sekolah/ch".$npsn[$i]; ?>','_blank')" type="button">Buka
						</button>
						<br>
					</td>
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

<script src="https://www.youtube.com/iframe_api"></script>
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
		var statusnya=1;
		if ($('#st' + id).html() == "Aktif")
			statusnya=2;

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantistatus",
			method: "POST",
			data: {id: id, status:statusnya},
			success: function (result) {
				if ($('#st' + id).html() == "Aktif")
					$('#st' + id).html('Tak Aktif');
				else
					$('#st' + id).html('Aktif');
			}
		})

	}


</script>
