<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tjenis = array("","Sekolah","","Bimbel");
$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');


//echo "CP".$cekpindah;
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
					<h4>PEMBAYARAN FEE TV SEKOLAH</h4>
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
							onclick="window.location.href='<?php echo base_url(); ?>finance/transaksi_detil'">Detil Transaksi
					</button>
				</div>
				<hr style="margin-bottom: 10px;">

			
				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width:2%;text-align:center">No</th>
								<th style='text-align:center'>Sebagai</th>
								<th style='text-align:center'>Nama</th>
								<th style='text-align:center'>Transaksi</th>
								<th style="text-align:center">Tanggal</th>
								<th style='text-align:center'>Asal</th>
								<th style='text-align:center'>Fee</th>
								<th style='text-align:center'>PPH</th>
								<th style='text-align:center'>Bukti</th>
								<th style='text-align:center'>NPWP</th>
								<th style='text-align:center'>Fee Bersih</th>
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
		$totalsejumlah = 0;
		$totalpphrp = 0;
		$totalpotonganrp = 0;
		$totalbersih = 0;

		$do_not_duplicate = array();

		foreach ($daftransaksi as $datane) {
			$datafound = false;
			$tipebayar = $datane->tipebayar;
			$siplah = "";
			$transaksi = "";
			$kode = substr($datane->order_id,0,4);
			// echo $datane->order_id."<br>\n\r";
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

			if ($datane->id_agency>0)
			{
				if (in_array($datane->id_agency.$datane->order_id, $do_not_duplicate)) {
					$datake = array_search ($datane->id_agency.$datane->order_id, $do_not_duplicate);
					$datake++;
					$sejumlah[$datake] = $sejumlah[$datake] + ($datane->fee_agencybruto);
					$pphrp[$datake] = $pphrp[$datake] + ($datane->pph_agencyrp);
					$bersih[$datake] = $sejumlah[$datake]-$pphrp[$datake];
					
				} else {
					$do_not_duplicate[] = $datane->id_agency.$datane->order_id;
					$jml_user++;
					$sebagai[$jml_user] = "Agency";
					$dtransaksi[$jml_user] = $transaksi;
					if ($transaksi == "Bimbel")
						$sebagai[$jml_user] = "Verifikator Bimbel";
					$nama[$jml_user] = $datane->first_name_agency." ".$datane->last_name_agency;
					$npwp[$jml_user] = $datane->npwp_agency;
					if ($npwp[$jml_user]==null)
					$npwp[$jml_user] = "-";
					$tanggalbayar[$jml_user] = $datane->tgl_bayar;
					$sekolah[$jml_user] = $datane->nama_sekolah;

					$sejumlah[$jml_user] = ($datane->fee_agencybruto);
					$pphrp[$jml_user] = ($datane->pph_agencyrp);
					$buktipotong[$jml_user] = $jml_user;
					$bersih[$jml_user] = ($sejumlah[$jml_user]-$pphrp[$jml_user]);
					
				}
			}

			if ($datane->id_siam>0)
			{
				if (in_array($datane->id_siam.$datane->order_id, $do_not_duplicate)) {
					$datake = array_search ($datane->id_siam.$datane->order_id, $do_not_duplicate);
					$datake++;
					$sejumlah[$datake] = $sejumlah[$datake] + $datane->fee_siambruto;
					$pphrp[$datake] = $pphrp[$datake] + $datane->pph_siamrp;
					$bersih[$datake] = $sejumlah[$datake]-$pphrp[$datake];
					
				} else {
					$do_not_duplicate[] = $datane->id_siam.$datane->order_id;
					$jml_user++;
					$sebagai[$jml_user] = "Mentor";
					$dtransaksi[$jml_user] = $transaksi;
				
					$nama[$jml_user] = $datane->first_name_siam." ".$datane->last_name_siam;
					$npwp[$jml_user] = $datane->npwp_siam;
					if ($npwp[$jml_user]==null)
					$npwp[$jml_user] = "-";
					$tanggalbayar[$jml_user] = $datane->tgl_bayar;
					$sekolah[$jml_user] = $datane->nama_sekolah;

					$sejumlah[$jml_user] = ($datane->fee_siambruto);
					$pphrp[$jml_user] = ($datane->pph_siamrp);
					$buktipotong[$jml_user] = $jml_user;
					$bersih[$jml_user] = ($sejumlah[$jml_user]-$pphrp[$jml_user]);

				}
			}
			
			if ($datane->id_ver>0)
			{
				if (in_array($datane->id_ver.$datane->order_id, $do_not_duplicate)) {
					$datake = array_search ($datane->id_ver.$datane->order_id, $do_not_duplicate);
					$datake++;
					$sejumlah[$datake] = $sejumlah[$datake] + $datane->fee_verbruto;
					$pphrp[$datake] = $pphrp[$datake] + $datane->pph_verrp;
					$bersih[$datake] = $sejumlah[$datake]-$pphrp[$datake];

					
				} else {
					$do_not_duplicate[] = $datane->id_ver.$datane->order_id;
					$jml_user++;
					$sebagai[$jml_user] = "Verifikator";
					$dtransaksi[$jml_user] = $transaksi;
				
					$nama[$jml_user] = $datane->first_name_ver." ".$datane->last_name_ver;
					$npwp[$jml_user] = $datane->npwp_ver;
					if ($npwp[$jml_user]==null)
					$npwp[$jml_user] = "-";
					$tanggalbayar[$jml_user] = $datane->tgl_bayar;
					$sekolah[$jml_user] = $datane->nama_sekolah;

					$sejumlah[$jml_user] = ($datane->fee_verbruto);
					$pphrp[$jml_user] = floor($datane->pph_verrp);
					$buktipotong[$jml_user] = $jml_user;
					$bersih[$jml_user] = ($sejumlah[$jml_user]-$pphrp[$jml_user]);

				}
			}

			if ($datane->id_kontri>0)
			{
				if (in_array($datane->id_kontri.$datane->order_id, $do_not_duplicate)) {
					$datake = array_search ($datane->id_kontri.$datane->order_id, $do_not_duplicate);
					$datake++;
					$sejumlah[$datake] = $sejumlah[$datake] + $datane->fee_kontribruto;
					$pphrp[$datake] = $pphrp[$datake] + $datane->pph_kontrirp;
					$bersih[$datake] = $sejumlah[$datake]-$pphrp[$datake];
					
				} else {
					$do_not_duplicate[] = $datane->id_kontri.$datane->order_id;
					$jml_user++;
					$sebagai[$jml_user] = "Guru";
					$dtransaksi[$jml_user] = $transaksi;
				
					$nama[$jml_user] = $datane->first_name_kontri." ".$datane->last_name_kontri;
					$npwp[$jml_user] = $datane->npwp_kontri;
					if ($npwp[$jml_user]==null)
					$npwp[$jml_user] = "-";
					$tanggalbayar[$jml_user] = $datane->tgl_bayar;
					$sekolah[$jml_user] = $datane->nama_sekolah;

					$sejumlah[$jml_user] = ($datane->fee_kontribruto);
					$pphrp[$jml_user] = ($datane->pph_kontrirp);
					$buktipotong[$jml_user] = $jml_user;
					$bersih[$jml_user] = ($sejumlah[$jml_user]-$pphrp[$jml_user]);

				}
			}
		
		}

		for ($a=1;$a<=$jml_user;$a++)
		{
			$totalsejumlah = $totalsejumlah + $sejumlah[$a];
			$totalpphrp = $totalpphrp + $pphrp[$a];
			$totalbersih = $totalbersih + $bersih[$a];

			echo "data.push([ " . $a . ", \"" . $sebagai[$a] . "\", \"" . $nama[$a] .
					"\", \"" . $dtransaksi[$a] .
					"\", \"" . namabulantahun_pendek($tanggalbayar[$a]) .
					"\", \"" . $sekolah[$a] .
					"\", \"" . number_format($sejumlah[$a], 0, ',', '.') .
					"\", \"" . number_format($pphrp[$a], 0, ',', '.') .
					"\", \"" . number_format($buktipotong[$a], 0, ',', '.') .
					"\", \"" . $npwp[$a] .
					"\", \"" . number_format($bersih[$a], 0, ',', '.') .
					"\"]);\n\r";
		}

		if ($jml_user>0) 
			{
				echo "data.push([" . ($jml_user+1) . ", ' ', ' ', ' ', ' ', '<div style=\"text-align:right\">TOTAL</div>',
						\"" . number_format($totalsejumlah, 0, ',', '.') .
						"\", \"" . number_format($totalpphrp, 0, ',', '.') .
						"\", ' ', ' ',\"" . number_format($totalbersih, 0, ',', '.') .
						"\"]);\n\r";
			}
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
                if( data[5] == "<div style=\"text-align:right\">TOTAL</div>"){
                    $(row).addClass('red');
                }
            },
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='ratakanan'>" + data + "</div>";
					},
					targets: [6,7,8, 10]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap'>" + data + "</div>";
					},
					targets: [3,5]
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
		window.open("<?php echo base_url() . 'finance/transaksi_fee/';?>" + bulan + "/" + tahun, "_self");
	}

</script>
