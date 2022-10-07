<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nama_status = Array('-', 'Aktif', 'Tak aktif');
$stratasekolah = Array('-', 'Lite', 'Pro', 'Premium','','','','Free Lite','Free Pro','Free Premium');
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
						<h1>Daftar Kampus</h1>
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
				<br>
				<center><span style="font-size:18px;font-weight: bold;">DAFTAR KAMPUS</span></center>
				<br><br>
				<div>
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">
						Kembali
					</button>
				</div>
				<hr style="margin-top: 10px;">
				<div style="margin-bottom: 10px;">
					<button type="button"
							onclick="window.location.href='<?php echo base_url();?>channel/tambahkampus'"
							class="btn-main"
							style="float:right;margin-right:0px;margin-top:-20px;">Tambah
					</button>
				</div>
				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:3%;text-align:center">No</th>
							<th style='width:5%;text-align:center'>NPSN</th>
							<th style='width:20%;text-align:center'>Nama Kampus</th>
							<th style='width:5%;text-align:center'>Prodi</th>
							<th style='width:20%;text-align:center'>Alamat Kampus</th>
							<th style='width:20%;text-align:center'>Kota</th>
							<th style='width:10%;text-align:center'>Agency</th>
							<!-- <th>Aksi</th> -->
						</tr>
						</thead>
					</table>
				</div>

			</div>

		</div>
	</section>
</div>

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
		foreach ($dafchannel as $datane) {
			$jml_user++;

			$tombol = "";
			
			echo "data.push([ " . $jml_user . ", \"" . $datane->npsn .
				"\", \"" . $datane->nama_sekolah .
				"\", \"" . $datane->jml_prodi .
				"\", \"" . $datane->alamat_sekolah .
				"\", \"" . $datane->nama_kota .
				"\", \"" . $datane->first_name . " " . $datane->last_name .
				"\", \"" . $tombol . "\"]);\n\r";
		}
		?>


		$('#tbl_user').DataTable({
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
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [0, 1, 2]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='ratakanan'>" + data + "</div>";
					},
					targets: [3]
				}
			]
		});
	});

</script>
