<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Orang Tua', 'Staf Fordorum');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

if (!isset($asal))
	$asal = "";
else
	$cekasal = "/" . $asal;

$jml_donasi = 0;
foreach ($dafdonasi as $datane) {
	$jml_donasi++;
	$order_id[$jml_donasi] = $datane->order_id;
	$tgl_order[$jml_donasi] = $datane->tgl_order;
	$tipe_bayar[$jml_donasi] = $datane->tipebayar;
	$namabank[$jml_donasi] = $datane->namabank;
	$rektujuan[$jml_donasi] = $datane->rektujuan;
	$iuran[$jml_donasi] = $datane->iuran;
	$status[$jml_donasi] = $datane->status;
}

?>

<!-- dashboard inner -->
<div class="midde_cont">
	<div class="container-fluid">
		<div class="row column_title">
			<div class="col-md-12">
				<div class="page_title">
					<h2>Profil Saya</h2>
				</div>
			</div>
		</div>
		<!-- row -->
		<div class="row column2 graph margin_bottom_30">
			<div class="col-md-l2 col-lg-12">
				<div class="white_shd full margin_bottom_30">
					<div class="full graph_head" style="margin-bottom: 25px;">
						<div class="heading1 margin_0">
							<h2>Donasi Saya</h2>
						</div>
					</div>

					<center>
						<div id="tabel1" style="margin:auto;width: 90%;margin-top: 25px;font-size: 18px;">
							<table id="tbl_user" class="table table-striped table-bordered nowrap"
								   cellspacing="0" width="90%">
								<thead>
								<tr>
									<th style='width:10px;text-align:center'>No</th>
									<th style='text-align:center'>Tanggal</th>
									<th style='text-align:center'>Sertifikat</th>
									<th style='text-align:right'>Iuran</th>
								</tr>
								</thead>

								<tbody>
								<?php for ($i = 1; $i <= $jml_donasi; $i++) {
									// if ($idsebagai[$i]!="4") continue;
									?>

									<tr>
										<td style='text-align:right;width: 10px;'><?php echo $i; ?></td>
										<!--								<td>-->
										<?php //echo $order_id[$i]; ?><!--</td>-->
										<td><?php echo namabulan_pendek(substr($tgl_order[$i], 0, 10)); ?></td>
										<td align="center">
											<button style="font-size:16px;padding-left: 10px;padding-right: 10px;"
												onclick="return downloaddonasi('<?php echo $order_id[$i]; ?>');">
												Download
											</button>
										</td>
										<td style='text-align:right'><?php echo number_format($iuran[$i], 0, ",", "."); ?></td>
									</tr>

									<?php
								}
								?>
								</tbody>
							</table>
						</div>
					</center>
				</div>

			</div>
		</div>
	</div>
</div>
<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<

<script>

	$(document).on('change', '#itahun', function () {
		get_analisis_view();
	});

	function get_analisis_view() {
		window.open("/rtf2/home/filter/" + $('#itahun').val() +
			"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
	}

	$(document).ready(function () {
		//$.fn.DataTable.ext.pager.numbers_length = 4;
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($dafuser as $datane) {
			$jml_user++;

			if ($datane->verifikator == 3)
				$statusguru = "Verifikator";
			else if ($datane->kontributor == 3)
				$statusguru = "Kontributor";


			echo "data.push([ " . $jml_user . ", \"" . $datane->first_name . " " . $datane->last_name . "\", \"" .
				$statusguru . "\", \"" . $datane->sekolah . "\", \"" . $datane->email . "\", \"" .
				$datane->hp . "\", \"" . $datane->jml_oke . "\", \"" . $datane->jml_semua . "\"]);";
		}
		?>


		var table = $('#tbl_user').DataTable({
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
					targets: [0, 1, 2, 3, 4]
				}
			]
		});

		// new $.fn.dataTable.FixedHeader(table);


		$('#urutok').on('click', function () {
			table.order([[5, 'desc']]).draw();
		});

		$('#urutjml').on('click', function () {
			table.order([[6, 'desc']]).draw();
		});

	});

	function downloaddonasi(orderid) {
		window.open('<?php echo base_url(); ?>login/donasi_download/' + orderid, '_self');
		return false;
	}


</script>
