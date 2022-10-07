<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Orang Tua', 'Staf Fordorum');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');


$jml_user = 0;
$totalmasuk = 0;
$totallunas = 0;
$total2masuk = 0;
$total2lunas = 0;

foreach ($alltransaksi as $datane) {
	$totalmasuk = $totalmasuk + $datane->iuran;
	if ($datane->status == null || $datane->status == 1) {
		$status[$jml_user] = "-";
	} else {
		$status[$jml_user] = "Lunas";
		$totallunas = $totallunas + $datane->iuran;
	}
}

foreach ($transaksi as $datane) {
	$jml_user++;
	$nomor[$jml_user] = $jml_user;
	$orderid[$jml_user] = $datane->order_id;
	$nama_donatur[$jml_user] = $datane->first_name." ".$datane->last_name;
	$sekolah[$jml_user] = $datane->sekolah;
	if (substr($datane->order_id, 0, 3) == "TVS") {
		$jenistransaksi[$jml_user] = "Iuran Verifikator";
	} else if (substr($datane->order_id, 0, 3) == "EVT") {
		$jenistransaksi[$jml_user] = "Registrasi Event";
	} else if (substr($datane->order_id, 0, 3) == "DNS") {
		$jenistransaksi[$jml_user] = "Donasi";
	} else if (substr($datane->order_id, 0, 3) == "DN1") {
		$jenistransaksi[$jml_user] = "Pure Donasi";
		$nama_donatur[$jml_user] = $datane->nama_donatur;
		$sekolah[$jml_user] = $datane->nama_lembaga;
	} else if (substr($datane->order_id, 0, 3) == "DN2") {
		$jenistransaksi[$jml_user] = "Sponsor";
		$nama_donatur[$jml_user] = $datane->nama_donatur;
		$sekolah[$jml_user] = $datane->nama_lembaga;
	} else if (substr($datane->order_id, 0, 4) == "PKT1" ||
		substr($datane->order_id, 0, 4) == "PKT2") {
		$jenistransaksi[$jml_user] = "Sekolah";
	} else if (substr($datane->order_id, 0, 4) == "PKT3") {
		$jenistransaksi[$jml_user] = "Bimbel";
	}

	$iduser[$jml_user] = $datane->id_user;
	$iuran[$jml_user] = $datane->iuran;
	$firstname[$jml_user] = $datane->first_name;
	$lastname[$jml_user] = $datane->last_name;
	$npsn[$jml_user] = $datane->npsn;
	$email[$jml_user] = $datane->email;
	$total2masuk = $total2masuk + $datane->iuran;
	if ($datane->status == null || $datane->status == 1) {
		$status[$jml_user] = "-";
	} else {
		$status[$jml_user] = "Lunas";
		$total2lunas = $total2lunas + $datane->iuran;
	}

//    $npsn[$jml_user]=$datane->nomor_nasional;
//
//    $nama_bank[$jml_user]=$datane->email;
//    $no_rek[$jml_user]=$datane->sekolah;
//	$status[$jml_user]=$txt_sebagai[$datane->sebagai];
//
	$pengajuan = new DateTime($datane->tgl_bayar);
	$tglpengajuan = $pengajuan->format('d-m-Y H:i:s');
	$tgl_bayar[$jml_user] = substr($tglpengajuan, 0, 2) . " " .
		$nmbulan[intval(substr($tglpengajuan, 3, 2))] . " " . substr($tglpengajuan, 6);

}

//echo "<br><br><br><br><br>".$allincome->totalbruto;
$totalbruto = $allincome->totalbruto;
$totalnet = $allincome->totalnet;
?>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
	<br>
	<center><span style="font-size:18px;font-weight: bold;"><?php echo $title; ?></span></center>
	<br>
	<!--<button style="margin-left:10px" id="btn-show-all-children" type="button">Expand All</button>-->
	<!--<button style="margin-left:10px" id="btn-hide-all-children" type="button">Collapse All</button>-->
	<center><i>Total jendral transaksi lunas = <b><?php echo number_format($totallunas, 0, ',', '.'); ?></b> dari
			<?php echo number_format($totalmasuk, 0, ',', '.'); ?></i></center>
	<center><i>Total jendral netto masuk kas = <b><?php echo number_format($totalnet, 0, ',', '.'); ?></b></i></center>
	<center><span style="font-size: 18px;">Total transaksi berjalan lunas = <b><?php echo number_format($totallunas-$totalbruto, 0, ',', '.'); ?></b> dari
			<?php echo number_format($totalmasuk-$totalbruto, 0, ',', '.'); ?></span></center>
	<hr>
	<center>Total jendral transaksi <?php echo strtoupper($opsi); ?> yang lunas
			= <?php echo number_format($total2lunas, 0, ',', '.'); ?>
<!--			dari --><?php //echo number_format($total2masuk, 0, ',', '.'); ?>
		</center>
	<br>
	<center>
		<button onclick="window.open('<?php echo base_url(); ?>payment/transaksi/pembayaran','_self')" class="btn-info">
			Iuran
		</button>
		<button onclick="window.open('<?php echo base_url(); ?>payment/transaksi/event','_self')" class="btn-info">
			Event
		</button>
		<button onclick="window.open('<?php echo base_url(); ?>payment/transaksi/donasi','_self')" class="btn-info">
			Donasi
		</button>
		<button onclick="window.open('<?php echo base_url(); ?>payment/transaksi/vkelas','_self')" class="btn-info">
			Sekolah
		</button>
		<button onclick="window.open('<?php echo base_url(); ?>payment/transaksi/bimbel','_self')" class="btn-info">
			Bimbel
		</button>
	</center>
	<hr>

	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>No</th>
				<th>Jenis Transaksi</th>
				<th>Nama</th>
				<?php if ($opsi=="donasi") { ?>
					<th>Lembaga/Sekolah</th>
				<?php } else { ?>
					<th>Sekolah</th>
				<?php }?>
				<th>Tanggal Transaksi</th>
				<th>Iuran</th>
				<th>Status</th>
				<th class="none">Email</th>
				<th class="none">Order ID</th>
				<th class="none">NPSN</th>

			</tr>
			</thead>

			<tbody>
			<?php for ($i = 1; $i <= $jml_user; $i++) {
				?>
				<tr>
					<td><?php echo $nomor[$i]; ?></td>
					<td><?php echo $jenistransaksi[$i]; ?></td>
					<td><?php echo $nama_donatur[$i]; ?></td>
					<td><?php echo $sekolah[$i]; ?></td>
					<td><?php echo $tgl_bayar[$i]; ?></td>
					<td><?php echo number_format($iuran[$i], 0, ',', '.'); ?></td>
					<td><?php echo $status[$i]; ?></td>
					<td><?php echo $email[$i]; ?></td>
					<td><?php echo $orderid[$i]; ?></td>
					<td><?php echo $npsn[$i]; ?></td>
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

<script>

	$(document).on('change', '#itahun', function () {
		get_analisis_view();
	});

	function get_analisis_view() {
		window.open("/rtf2/home/filter/" + $('#itahun').val() +
			"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
	}

	$(document).ready(function () {
		var table = $('#tbl_user').DataTable({
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [1, 2, 3, 4]
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


</script>
