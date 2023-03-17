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
					<h4>LAPORAN KEUANGAN TV KAMPUS</h4>
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
							onclick="window.location.href='<?php echo base_url(); ?>finance/transaksi_detil'">Detil Transaksi
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
								<th style="width:20%;text-align:center">Uraian</th>
								<th style='width:10%;text-align:center'>Subtotal (Rp)</th>
								<th style='width:10%;text-align:center'>Total (Rp)</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td><b>Pemasukan Bruto</b></td>
								<td></td>
								<td style='text-align:right;'><?php 
								echo number_format($daftransaksi->total_bruto,0,',','.');?></td>
							</tr>
							<tr>
								<td>3</td>
								<td> - Jumlah PPN</td>
								<td style='text-align:right;'><?php 
								echo number_format($daftransaksi->total_ppn,0,',','.');?></td>
								<td></td>
							</tr>
							<tr>
								<td>2</td>
								<td> - Potongan Midtrans</td>
								<td style='text-align:right;'><?php 
								echo number_format($daftransaksi->total_potmid,0,',','.');?></td>
								<td></td>
							</tr>
							<tr>
								<td>5</td>
								<td> - Jumlah Fee Keluar</td>
								<td style='text-align:right;'><?php 
								echo number_format($daftransaksi->total_fee,0,',','.');?></td>
								<td></td>
							</tr>
							<tr>
								<td>4</td>
								<td> - Jumlah PPH</td>
								<td style='text-align:right;'><?php 
								echo number_format($daftransaksi->total_pph,0,',','.');?></td>
								<td></td>
							</tr>
							<tr>
								<td>6</td>
								<td><b>Total Pengeluaran</b></td>
								<td></td>
								<td style='text-align:right;'><?php 
								echo number_format($daftransaksi->total_potmid+$daftransaksi->total_ppn+
								$daftransaksi->total_pph+$daftransaksi->total_fee,0,',','.');?></td>
								
							</tr>
							<tr>
								<td>7</td>
								<td style='text-align:right;'><b>PENDAPATAN TV KAMPUS</b></td>
								<td></td>
								<td style='text-align:right;'><b><?php 
								echo number_format($daftransaksi->total_bruto-($daftransaksi->total_potmid+$daftransaksi->total_ppn+
								$daftransaksi->total_pph+$daftransaksi->total_fee),0,',','.');?></b></td>
								
							</tr>
						</tbody>
					</table>
				</div>
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
		var table = $('#tbl_user').DataTable({
			'ordering': false,
			'searching' : false,
			'bInfo' : false,
			'bPaginate': false,
			'responsive': true
		});

	});

	function ambildata() {
		var bulan = $('#ibulan').val();
		var tahun = $('#itahun').val();
		window.open("<?php echo base_url() . 'finance/transaksi_ikhtisar/';?>" + bulan + "/" + tahun, "_self");
	}

</script>
