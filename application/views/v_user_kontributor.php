<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Orang Tua', 'Staf Fordorum');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

if (!isset($asal))
	$asal="";
else
	$cekasal = "/".$asal;

$jml_user = 0;
foreach ($dafuser as $datane) {
	$jml_user++;
	$nomor[$jml_user] = $jml_user;
	$id_user[$jml_user] = $datane->kd_user;
	$first_name[$jml_user] = $datane->first_name;
	$nomor_nasional[$jml_user] = $datane->nomor_nasional;
	$last_name[$jml_user] = $datane->last_name;
	$email[$jml_user] = $datane->email;
	$sekolah[$jml_user] = $datane->sekolah;
	$sebagai[$jml_user] = $txt_sebagai[$datane->sebagai];
	$kontributor[$jml_user] = $datane->kontributor;
	$pengajuan = new DateTime($datane->tgl_pengajuan);
	$tglpengajuan = $pengajuan->format('d-m-Y H:i:s');
	$tgl_pengajuan[$jml_user] = substr($tglpengajuan, 0, 2) . " " .
		$nmbulan[intval(substr($tglpengajuan, 3, 2))] . " " . substr($tglpengajuan, 6);
}

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
						<h1>User</h1>
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
				<center><span style="font-size:18px;font-weight: bold;">Daftar Calon Dosen</span>
				<br><?php echo $sekolahku; ?>
				</center>
				<!--<button style="margin-left:10px" id="btn-show-all-children" type="button">Expand All</button>-->
				<!--<button style="margin-left:10px" id="btn-hide-all-children" type="button">Collapse All</button>-->
				<?php if($asal=="dashboard") { ?>
					<div style="margin-bottom: 10px;">
				<button class="btn-main"
						onclick="window.location.href='<?php echo base_url().'profil';?>'">Kembali
				</button>
					</div>
				<?php } ?>
				<hr>

				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Sekolah</th>
							<th>Email</th>
							<th>Tanggal Pengajuan</th>
							<th>Status Dosen</th>
							<th class="none">NUPTK/NISN/NIP</th>
							<th class="none">Nama Belakang</th>


						</tr>
						</thead>

						<tbody>
						<?php for ($i = 1; $i <= $jml_user; $i++) {
							?>
							<tr>
								<td><?php echo $nomor[$i]; ?></td>
								<td><?php echo $first_name[$i] . ' ' . $last_name[$i]; ?></td>
								<td><?php echo $sekolah[$i]; ?></td>
								<td><?php echo $email[$i]; ?></td>
								<td><?php echo $tgl_pengajuan[$i]; ?></td>
								<?php if ($kontributor[$i] == 1) { ?>
									<td>Calon Kontributor</td>
								<?php } else if ($kontributor[$i] == 2) { ?>
									<td>
										<button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
										echo $id_user[$i].$cekasal; ?>'" id="btn-show-all-children" type="button">Menunggu
											diverifikasi
										</button>
									</td>
								<?php } else { ?>
									<td>
										<button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
										echo $id_user[$i].$cekasal; ?>'" id="btn-show-all-children" type="button"
												style="color:green">Kontributor
										</button>
									</td>
								<?php } ?>
								<td><?php echo $nomor_nasional[$i]; ?></td>
								<td><?php echo $last_name[$i]; ?></td>


							</tr>
							<?php
						}
						?>
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


<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>

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
