<?php
defined('BASEPATH') OR exit('No direct script access allowed');


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
					<h4>DAFTAR TRANSAKSI MELALUI SIPLAH </h4>
				</center>
				<br>

				<div style="margin-bottom: 10px;">
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
					</button>
				</div>
				<hr style="margin-bottom: 10px;">

				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:2%;text-align:center">No</th>
							<th style='width:20%;text-align:center'>Verifikator</th>
							<th style='width:20%;text-align:center'>Nama Sekolah</th>
							<th style='width:20%;text-align:center'>Tanggal Upload</th>
							<th style='width:20%;text-align:center'>Tanggal Token</th>
							<th style='width:20%;text-align:center'>Info</th>
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
		$namapaket = array ("","Lite", "Pro", "Premium");
		$jml_user = 0;
		foreach ($daftransaksi as $datane) {
			$jml_user++;

			$datakode = "`".$datane->kode."`";

			if ($datane->konfirmasi==1)
				$statuskonfirmasi = "<button onclick='konfirmasisiplah(".$datakode.");'>Belum dikonfirmasi</button>";
			else if ($datane->konfirmasi==2)
				$statuskonfirmasi = "<button onclick='konfirmasisiplah(".$datakode.");'>Surat OK</button>";
			else if ($datane->konfirmasi==3)
				$statuskonfirmasi = "<button style='color:red;' onclick='konfirmasisiplah(".$datakode.");'>Tidak valid</button>";
			else if ($datane->konfirmasi==4)
				$statuskonfirmasi = "<button style='color:blue;' onclick='konfirmasisiplah(".$datakode.");'>Token Aktif</button>";
			else if ($datane->konfirmasi==5)
				$statuskonfirmasi = "<button style='color:green;' onclick='konfirmasisiplah(".$datakode.");'>OKE</button>";

			$info = "";
			if($datane->strata>0 && $datane->iuran>0 && $datane->lamabulan>0)
				$info = $namapaket[$datane->strata] . " ". $datane->lamabulan." bulan (" .
					number_format($datane->iuran,0,",", ".").")";
			
			$tgltokenaktif = "-";
			if ($datane->tgl_upload!=$datane->tgl_aktifkan)
			{
				$tgltokenaktif = namabulan_pendek($datane->tgl_aktifkan) . " ".substr($datane->tgl_aktifkan,10);
			}


			echo "data.push([ " . $jml_user . ", \"" . $datane->first_name." ".$datane->last_name .
				"\", \"" . $datane->nama_sekolah .
				"\", \"" .  namabulan_pendek($datane->tgl_upload) . " ".substr($datane->tgl_upload,10) .
				"\", \"" .  $tgltokenaktif .
				"\", \"" . $info .
				"\", \"" . $statuskonfirmasi . "\"]);\n\r";
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

	});

	function konfirmasisiplah(kode)
	{
		window.open('<?php echo base_url()."finance/konfirmasi_siplah/";?>' + kode,'_self');
	}


</script>
