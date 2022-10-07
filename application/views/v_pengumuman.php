<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Orang Tua', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator','','','','','','-');
$namastatus = Array('NonAktif', 'Aktif');

$jml_pengumuman = 0;
foreach ($datapengumuman as $datane) {
	$jml_pengumuman++;
	$nomor[$jml_pengumuman] = $jml_pengumuman;
	$link_pengumuman[$jml_pengumuman] = $datane->link_pengumuman;
	$code_pengumuman[$jml_pengumuman] = $datane->code_pengumuman;
	$acara[$jml_pengumuman] = $datane->nama_pengumuman;
	$status[$jml_pengumuman] = $datane->status;
	$mulai = new DateTime($datane->tgl_mulai);
	$tgl_mulai[$jml_pengumuman] = $mulai->format ("d M Y");
	$selesai = new DateTime($datane->tgl_selesai);
	$tgl_selesai[$jml_pengumuman] = $selesai->format ("d M Y");
}

?>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px">
	<br>
	<center><span style="font-size:16px;font-weight: bold;"><?php echo $title; ?></span></center>
	<br>
	<!--<button style="margin-left:10px" id="btn-show-all-children" type="button">Expand All</button>-->
	<!--<button style="margin-left:10px" id="btn-hide-all-children" type="button">Collapse All</button>-->
	<button type="button" onclick="window.location.href='<?php echo base_url(); ?>informasi/tambahpengumuman'" class=""
			style="float:right;margin-right:10px;margin-top:-20px;">Tambah
	</button>

	<hr>

	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style='width:5px;text-align:center'>No</th>
				<th style='text-align:center'>Acara</th>
				<th style='width:15%;text-align:center'>Tanggal Mulai</th>
				<th style='width: 15%;text-align:center'>Tanggal Selesai</th>
				<th style='width: 15%;text-align:center'>Status</th>
				<th style='width: 15%;text-align: center'>Aksi</th>
			</tr>
			</thead>

			<tbody>
			<?php for ($i = 1; $i <= $jml_pengumuman; $i++) {
				// if ($idsebagai[$i]!="4") continue;
				?>

				<tr>
					<td style='text-align:right'><?php echo $nomor[$i]; ?></td>
					<td><?php echo $acara[$i]; ?></td>
					<td><?php echo $tgl_mulai[$i]; ?></td>
					<td><?php echo $tgl_selesai[$i]; ?></td>
					<td align="center">
						<button id="bt1_<?php echo $code_pengumuman[$i]; ?>" style="background-color: <?php
						if ($status[$i] == 0)
							echo '#ffd0b4';
						else
							echo '#b4e7df'; ?>" onclick="gantistatus('<?php echo $code_pengumuman[$i]; ?>')"
								type="button"><?php echo $namastatus[$status[$i]]; ?></button>
					</td>
					<td>
						<button onclick="window.location.href='<?php echo base_url();?>informasi/editpengumuman/<?php
						echo $code_pengumuman[$i];?>'"  id="btn-show-all-children" type="button">Edit</button>
						<button onclick="return mauhapus('<?php echo $code_pengumuman[$i]; ?>')"
								id="btn-show-all-children" type="button" class="myButtonred">Hapus
						</button>
					</td>
				</tr>

				<?php
			}
			?>
			</tbody>
		</table>
	</div>
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


<!--<script type="text/javascript" src="--><?php //echo base_url(); ?><!--/js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script>

	//$('#d3').hide();

	$(document).ready(function () {
		var divx = document.getElementById('d1');
//divx.style.visibility = "hidden";
//divx.style.display = "none";

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

	function gantistatus(codex) {
		statusnya = 0;
		if ($('#bt1_' + codex).html() == "NonAktif") {
			statusnya = 1;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>informasi/gantistatuspengumuman",
			method: "POST",
			data: {code: codex, status: statusnya},
			success: function (result) {
				if ($('#bt1_' + codex).html() == "Aktif") {
					$('#bt1_' + codex).html("NonAktif");
					$('#bt1_' + codex).css({"background-color": "#ffd0b4"});
				} else {
					$('#bt1_' + codex).html("Aktif");
					$('#bt1_' + codex).css({"background-color": "#b4e7df"});
				}
			}
		})

	}

	function mauhapus(codepengumuman)
	{
		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url();?>informasi/hapuspengumuman/' + codepengumuman);
		} else {
			return false;
		}
		return false;
	}


</script>
