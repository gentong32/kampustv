<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nama_status = Array('-', 'Aktif', 'Tak aktif');
$stratasekolah = Array('-', 'Lite', 'Pro', 'Premium','','','','Free Lite','Free Pro','Free Premium');
//$datanya = "-data-";
//$status = '<div id="st'.$datanya.'">'.$nama_status[2].'</div>';
//echo $status;
//die();
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
						<h1>Daftar Prodi</h1>
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
				<center><span style="font-size:18px;font-weight: bold;">DAFTAR STANDAR PRODI KAMPUS</span></center>
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
							onclick="window.location.href='<?php echo base_url();?>channel/tambahprodi'"
							class="btn-main"
							style="float:right;margin-right:0px;margin-top:-20px;">Tambah
					</button>
				</div>

				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:2%;text-align:center">No</th>
							<th style='width:5%;text-align:center'>Kode</th>
							<th style='width:20%;text-align:center'>Nama Prodi</th>
							<th style='width:20%;text-align:center'>Jenjang</th>
						</tr>
						</thead>
					</table>
				</div>

			</div>

			<!-- <div style="margin:20px;font-size: larger;">
				<center>
					<button onclick="return eksporxl();">Ekspor ke Excel</button>
				</center>
			</div> -->

			<div
				style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
				<div id="video-placeholder" style='display:none'></div>
				<div id="videolokal" style='display:none'></div>
			</div>

		</div>
	</section>
</div>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<script src="<?php echo base_url();?>js/jquery.min.js"></script>
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

			echo "data.push([ " . $jml_user . ", \"" . $datane->kd_prodi .
				"\", \"" . $datane->nama_prodi .
				"\", \"" . $datane->jenjang .
				"\"]);\n\r";
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
						return "<div style='text-align: center' class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [1]
				}
			]
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
					{
						$('#tbfree' + id).prop('disabled', true);
						$('#st' + id).html('Tak Aktif');
					}
				else
					{
						$('#tbfree' + id).prop('disabled', false);
						$('#st' + id).html('Aktif');
					}
			}
		})

	}

	function eksporxl() {
		window.open("<?php echo base_url(); ?>channel/export");
		return true;
	}


</script>
