<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

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
						<h1>Area Marketing</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">

				<div style="color:#000000;margin:auto;background-color:white;">
					<br>
					<center><span style="font-size:16px;font-weight: bold;">DAFTAR CALON VERIFIKATOR<br>
						</span>
				</center>
						<div style="float:left;margin-bottom: 10px;">
					<button type="button" class="btn-main" onclick="kembali();">Kembali</button>
				</div>
				<hr>
					<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
						<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
							<thead>
							<tr>
								<th style="width:2%;text-align:center">No</th>
								<th style='text-align:center'>Nama</th>
								<th style='width:20%;text-align:center'>Sekolah</th>
								<th style='text-align:center'>NPSN</th>
								<th style='text-align:center'>Email</th>
								<th style='text-align:center'>HP</th>
								<th style='text-align:center'>Status</th>
							</tr>
							</thead>
						</table>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>

<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}

	.tbdaf {
		margin-right:5px;
		margin-bottom:5px;

	}
</style>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>

	//$('#d3').hide();

	$(document).ready(function () {
		//$.fn.DataTable.ext.pager.numbers_length = 4;
		var data = [];

		<?php
		$jml_user = 0;
		$txtinfo = array ("Belum Lulus", "Lulus");
		foreach ($dafcalver as $datane) {
			$jml_user++;

			$nama = $datane->first_name." ".$datane->last_name;
			$info = $txtinfo[$datane->statuscalver];
						
			$edit = "<center><button class='tbdaf' onclick='window.open(`" . base_url()."marketing/calver/detil/".$koderef . "/".$datane->id_calver."`);' type='button'>Detil</button>".
			"</center>";
			$edit = $datane->alamat;
			

			echo "data.push([ " . $jml_user . ", \"" . $nama .
				"\", \"" . $datane->nama_sekolah .
				"\", \"" . $datane->npsn .
				"\", \"" . $datane->email .
				"\", \"" . $datane->hp .
				"\", \"" . $info."\"]);";
		}
		?>


		$('#tbl_user').DataTable({
			data:           data,
			deferRender:    true,
			scrollCollapse: true,
			scroller:       true,
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
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [0, 1, 2, 3, 4, 5]
				},
				{responsivePriority: 1, targets: 3}
				// {
				// 	render: function (data, type, full, meta) {
				// 		return "<div style='text-align: center' class='text-wrap width-50'>" + data + "</div>";
				// 	},
				// 	targets: [3]
				// }
			]
		});


		// new $.fn.dataTable.FixedHeader(table);

	});

	function kembali() {
		window.history.back();
	}

</script>
