<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('Belum aktif', '', '', 'Aktif');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator', '', '', '', '', '', '-');
$jumlahminimalpeserta = 10;
?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>
	<!-- section begin -->
	<section id="subheader" class="text-light"
			 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Ekstrakurikuler Majalah Dinding</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->
	<section aria-label="section" class="mt0 sm-mt-0">
		<div class="container">
			<div class="row">
				<div style="margin-bottom: 10px;">
					<button class="btn-main"
							<?php if ($opsi=="dashboard") {?>
								onclick="window.location.href='<?php echo base_url(); ?>profil/'"
							<?php } else { ?>
								onclick="window.location.href='<?php echo base_url(); ?>ekskul/'"
							<?php } ?>
							class="btn-main">Kembali
					</button>
				</div>
				<hr>
				<center><h3>DAFTAR PESERTA EKSKUL BULAN INI</h3></center>

				<div style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tabel_data" class="table table-striped nowrap"
						   style="border-top: black solid 1px;" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style='width:5px;text-align:center'>No</th>
							<th style='width:20%;text-align:center'>Nama</th>
<!--							<th style='text-align:center'>NISN</th>-->
							<th>HP</th>
							<th>Email</th>
							<th>Status</th>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>

<style>
	.text-wrap{
		white-space: initial;
		word-break: break-word;
	}
	.width-20{
		min-width: 10px;
	}

	.width-200{
		max-width: 200px;
	}

	.minwidth-200{
		min-width: 200px;
	}

</style>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>

	$(document).ready(function () {
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($dataekskul as $datane) {
			$jml_user++;

			$tstatus = "Belum Aktif";
			if ($datane->status == null)
				$tstatus = "Belum Aktif";
			else
			{
				if ($datane->status==3 && substr($datane->kode_bayar,0,3)=="EKF")
					$tstatus = "Aktif (Gratis)";
				else
					$tstatus = $txt_sebagai[$datane->status];
			}


			if($dibayaroleh=="sekolah")
				$tstatus = "Aktif";

			//$datane->nomor_nasional . "\", \"" .

			echo "data.push([ " . $jml_user . ", \"" . strtoupper($datane->first_name) . " " .
				strtoupper($datane->last_name) . "\", \"" .
				$datane->hp . "\", \"" .
				$datane->email . "\", \"" . $tstatus . "\"]);";
		}
		?>

		$('#tabel_data').DataTable({
			data: data,
			deferRender: true,
			scrollCollapse: true,
			scroller: true,
			pagingType: "simple",
			language: {
				paginate: {
					previous: "<",
					next: ">"
				}
			},
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='width-20'>" + data + "</div>";
					},
					targets: [0]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap minwidth-200'>" + data + "</div>";
					},
					targets: [1]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap'>" + data + "</div>";
					},
					targets: [2,3]
				},
				{responsivePriority: 1, targets: 0},
				{responsivePriority: 10001, targets: 2},
				{responsivePriority: 2, targets: -3},
				{
					width: 25,
					targets: 0
				}
			],
			"order": [[0, "asc"]]
		});

	});

	function ikutekskul() {
		if (confirm("Apakah ingin mengikuti kegiatan Ekstrakurikuler?"))
			window.open('<?php echo base_url() . "ekskul/ikuti"; ?>', '_self');
		else
			return false;
	}

</script>
<!---------------------------------------------------------------------------------------->
