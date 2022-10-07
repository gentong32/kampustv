<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

$getbulanlalu = new DateTime("$tahun/$bulan/1");
$getbulanlalu->modify("-1 month");
$tbulanlalu =  $getbulanlalu->format("Y-m-d");
$bulanlalu = substr(namabulan_panjang($tbulanlalu),2);

$jmldana_agency = 0;
$jmldana_siam = 0;
$cekpindah = 0;

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
						<h1>Keuangan</h1>
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
				<center>
					<h4>DAFTAR PEMBAYARAN IURAN MELALUI SIPLAH </h4>
				</center>
				<br>

				<div style="margin-bottom: 10px;">
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
					</button>
				</div>
				<hr style="margin-bottom: 10px;">

				<center><span style="font-size:18px;font-weight: bold;">TABEL TRANSAKSI IURAN SEKOLAH<br></span>
					<button onclick="window.open('<?php
					if ($bulan!=null)
						$tambahan = "/".$bulan."/".$tahun;
					else
						$tambahan="";
					echo base_url()."finance/transaksi_virtualkelas".$tambahan;?>','_self');">
						Transaksi Kelas Virtual
					</button>
				</center>


				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:2%;text-align:center">No</th>
							<th style='width:20%;text-align:center'>Verifikator</th>
							<th style='width:20%;text-align:center'>Nama Sekolah</th>
							<th style='width:20%;text-align:center'>Tgl Upload</th>
							<th style='width:20%;text-align:center'>Status</th>
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

	//$('#d3').hide();

	$(document).ready(function () {
		//$.fn.DataTable.ext.pager.numbers_length = 4;
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($daftransaksi as $datane) {
			$jml_user++;

			echo "data.push([ " . $jml_user . ", \"" . $datane->first_name." ".$datane->last_name .
				"\", \"" . $datane->nama_sekolah .
				"\", \"" .  $datane->tgl_upload .
				"\", \"" . $datane->konfirmasi . "\"]);\n\r";
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
					targets: [0, 1, 2, 3]
				},
				{
					render: function (data, type, full, meta) {
						return "<div style='text-align: center' class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [4]
				}
			]
		});


		// new $.fn.dataTable.FixedHeader(table);

	});

	function pindahkan(status) {
		$.ajax({
			url: "<?php echo base_url();?>finance/pindahkan/<?php echo $bulan.'/'.$tahun.'/';?>" + status,
			method: "GET",
			data: {},
			success: function (result) {
				if (result == "oke")
					window.location.reload();
				else {
					alert ("Ada masalah");
				}

			}
		});
	}

	function ambildata() {
		var bulan = $('#ibulan').val();
		var tahun = $('#itahun').val();
		window.open("<?php echo base_url() . 'finance/transaksi_sekolah/';?>" + bulan + "/" + tahun, "_self");
	}


</script>
