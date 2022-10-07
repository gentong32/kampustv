<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tjenis = array("","Sekolah","","Bimbel");
$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');


//echo "CP".$cekpindah;
?>

<!-- <style>
	.table-striped>thead>tr:nth-child(odd)>td, 
	.table-striped>thead>tr:nth-child(odd)>th {
    border: solid 1px black;
	background-color: gray;
	color: black;
}
</style> -->

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
						<h1>Laporan Keuangan</h1>
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
					<h4>TRANSAKSI TV SEKOLAH</h4>
				</center>
				<br>
				<div class="col-md-12" style="margin-bottom: 15px;">
					<center>
						<div style="display: inline-block">
							<select class="form-control" style="width: 130px;" name="ibulan" id="ibulan">
							echo "<option value=0>-Bulan-</option>";
								<?php for ($a = 1; $a <= 12; $a++) {
									if ($a == $bulan)
										echo "<option selected value=$a>$namabulan[$a]</option>";
									else
										echo "<option value=$a>$namabulan[$a]</option>";
								} ?>
							</select>
						</div>
						<div style="display: inline-block">
							<select class="form-control" style="width: 110px;" name="itahun" id="itahun">
							echo "<option value=0>-Tahun-</option>";
								<?php for ($a = $tahunsekarang; $a >= 2021; $a--) {
									if ($a == $tahun)
										echo "<option selected value=$a>$a</option>";
									else
										echo "<option value=$a>$a</option>";
								} ?>
							</select>
						</div>
						<div style="display: inline-block">
							<button onclick="ambildata();" class="btn-main" style="padding: 5px">OK</button>
						</div>
					</center>
				</div>

				<div style="margin-bottom: 10px;">
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
					</button>
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>finance/transaksi_ikhtisar'">Ikhtisar
					</button>
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>finance/transaksi_fee'">Transaksi Fee
					</button>
				</div>
				<hr style="margin-bottom: 10px;">

			
				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width:2%;text-align:center">No</th>
								<th style="text-align:center">Tanggal</th>
								<th style='text-align:center'>Nama</th>
								<th style='text-align:center'>Sekolah</th>
								<th style='text-align:center'>Transaksi</th>
								<th style='text-align:center'>Sejumlah</th>
								<th style='text-align:center'>PPN</th>
								<th style='text-align:center'>Midtrans</th>
								<th style='text-align:center'>Bersih</th>
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
	.width-10{
		min-width: 10px;
	}

	table.dataTable td {
  		font-size: 14px;
	}

	table.dataTable tr.dtrg-level-0 td {
  		font-size: 14px;
	}

	.red {
		font-weight: bold;
		color: black;
	}
	.ratakanan {
		text-align: right;
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
		$totalsejumlah = 0;
		$totalppnrp = 0;
		$totalpotonganrp = 0;
		$totalbersih = 0;

		foreach ($daftransaksi as $datane) {
			$jml_user++;

			$nama = $datane->first_name." ".$datane->last_name;
			$sekolah = $datane->sekolah;
			$kode = substr($datane->order_id,0,4);

			$tipebayar = $datane->tipebayar;
			$siplah = "";
			$transaksi = "";
			if($tipebayar == "SIPLAH")
				$siplah = "SIPLAH ";
			if ($kode == "TVS-")
				$transaksi = $siplah."Sekolah Lite";
			else if (substr($kode,0,2) == "TP")
				$transaksi = $siplah."Sekolah Pro";
			else if (substr($kode,0,2) == "TF")
				$transaksi = $siplah."Sekolah Premium";
			else if (substr($kode,0,2) == "EK")
				$transaksi = "Ekskul Siswa";
			else if ($kode == "PKT1")
				$transaksi = "Kelas Virtual";
			else if ($kode == "PKT2")
				$transaksi = "Kelas Virtual Sekolah Lain";
			else if ($kode == "PKT3")
				$transaksi = "Bimbel";
			else if ($kode == "ECR3")
				$transaksi = "Bimbel Eceran";
			else if ($kode == "EVT-")
				$transaksi = "Event";
			$sejumlah = $datane->iuran;
			$ppnrp = $datane->ppnrp;
			$potonganrp = $datane->potmidrp;

			if ($potonganrp==0)
			{
				

				$ppn = $standar->ppn;
				$ppnrp = $ppn / 100 * $sejumlah;

				if ($tipebayar == "alfa") {
					$potongan = $standar->pot_alfa;
					$potonganrp = $potongan;
				} else if ($tipebayar == "akulaku") {
					$potongan = $standar->pot_akulaku / 100;
					$potonganrp = $potongan * $sejumlah;
				} else if ($tipebayar == "gopay") {
					$potongan = $standar->pot_gopay / 100;
					$potonganrp = $potongan * $sejumlah;
				} else if ($tipebayar == "shopee") {
					$potongan = $standar->pot_shopee / 100;
					$potonganrp = $potongan * $sejumlah;
				} else if ($tipebayar == "qris") {
					$potongan = $standar->pot_qris / 100;
					$potonganrp = $potongan * $sejumlah;
				} else if ($tipebayar == "SIPLAH") {
					$ppn = 0;
					$ppnrp = 0;
					$potongan = 0;
					$potonganrp = 0;
				} else {
					$potongan = $standar->pot_midtrans;
					$potonganrp = $potongan;
				}

				if ($sejumlah==0)
					$potonganrp = 0;
			}



			$bersih = $sejumlah - $ppnrp - $potonganrp ;

			$totalsejumlah = $totalsejumlah + $sejumlah;
			$totalppnrp = $totalppnrp + $ppnrp;
			$totalpotonganrp = $totalpotonganrp + $potonganrp;
			$totalbersih = $totalbersih + $bersih;
			
			
			echo "data.push([ " . $jml_user . ", \"" . namabulantahun_pendek($datane->tgl_bayar) .
				"\", \"" . $nama . "\", \"" . $sekolah .
				"\", \"" . $transaksi .
				"\", \"" . number_format($sejumlah, 0, ',', '.') .
				"\", \"" . number_format($ppnrp, 0, ',', '.') .
				"\", \"" . number_format($potonganrp, 0, ',', '.') .
				"\", \"" . number_format($bersih, 0, ',', '.') .
				"\"]);\n\r";
		}

		echo "data.push([" . ($jml_user+1) . ", ' ', ' ', ' ', '<div style=\"text-align:right\">TOTAL</div>',
				\"" . number_format($totalsejumlah, 0, ',', '.') .
				"\", \"" . number_format($totalppnrp, 0, ',', '.') .
				"\", \"" . number_format($totalpotonganrp, 0, ',', '.') .
				"\", \"" . number_format($totalbersih, 0, ',', '.') .
				"\"]);\n\r";
		?>

		var table = $('#tbl_user').DataTable({
			data: data,
			deferRender: true,
			scrollCollapse: true,
			scroller: true,
			// info: false,
			pagingType: "simple",
			language: {
				paginate: {
					previous: "<",
					next: ">"
				}
			},
			'responsive': true,
			"createdRow": function( row, data, dataIndex){
                if( data[4] == "<div style=\"text-align:right\">TOTAL</div>"){
                    $(row).addClass('red');
                }
            },
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='ratakanan'>" + data + "</div>";
					},
					targets: [5,6,7,8]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap'>" + data + "</div>";
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

	function ambildata() {
		var bulan = $('#ibulan').val();
		var tahun = $('#itahun').val();
		window.open("<?php echo base_url() . 'finance/transaksi_detil/';?>" + bulan + "/" + tahun, "_self");
	}

</script>
