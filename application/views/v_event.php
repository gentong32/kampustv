<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Orang Tua', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator', '', '', '', '', '', '-');
$namastatus = Array('NonAktif', 'Aktif');
$namadefault = Array('-', 'Default');
$defaultakhir = "";
$jml_event = 0;
foreach ($dataevent as $datane) {
	$jml_event++;
	$nomor[$jml_event] = $jml_event;
	$link_event[$jml_event] = $datane->link_event;
	$code_event[$jml_event] = $datane->code_event;
	$acara[$jml_event] = $datane->nama_event;
	$status[$jml_event] = $datane->status;
	$default[$jml_event] = $datane->default;
	if ($datane->default == 1)
		$defaultakhir = $datane->code_event;
	$iuran[$jml_event] = $datane->iuran;
	if ($datane->iuran == 0)
		$iuran[$jml_event] = "-";
	$mulai = new DateTime($datane->tgl_mulai);
	$tgl_mulai[$jml_event] = $mulai->format("d M Y");
	$selesai = new DateTime($datane->tgl_selesai);
	$tgl_selesai[$jml_event] = $selesai->format("d M Y");
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
						<h1>LOKAKARYA / SEMINAR</h1>
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
				<center><span style="font-size:18px;font-weight: bold;">DAFTAR EVENT</span></center>
				<br>
				<!--<button style="margin-left:10px" id="btn-show-all-children" type="button">Expand All</button>-->
				<!--<button style="margin-left:10px" id="btn-hide-all-children" type="button">Collapse All</button>-->
				<hr style="margin-top: 5px;margin-bottom: 5px;">
				<div style="margin-bottom: 10px;">
				<button type="button" onclick="window.location.href='<?php echo base_url(); ?>event/tambahevent'"
						class="btn-main"
						style="float:right;margin-right:10px;">Tambah
				</button>
				</div>


				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style='width:15px;text-align:center'>No</th>
							<th style='width:20%;text-align:center'>Acara</th>
							<th style='width:15%;text-align:center'>Tanggal Mulai</th>
							<th style='width: 15%;text-align:center'>Tanggal Selesai</th>
							<th style='width: 10%;text-align:center'>Iuran</th>
							<th style='width: 15%;text-align:center'>Status / Default</th>
							<th style='text-align: center'>Aksi</th>
						</tr>
						</thead>

						<tbody>
						<?php for ($i = 1; $i <= $jml_event; $i++) {
							// if ($idsebagai[$i]!="4") continue;
							?>

							<tr>
								<td style='text-align:right'><?php echo $nomor[$i]; ?></td>
								<td><?php echo $acara[$i]; ?></td>
								<td><?php echo $tgl_mulai[$i]; ?></td>
								<td><?php echo $tgl_selesai[$i]; ?></td>
								<td align="right"><?php if ($iuran[$i]>0) 
										echo number_format($iuran[$i], 0, ',', '.');
									else
										echo "<div>-</div>"; ?></td>
								<td align="center">
									<button id="bt1_<?php echo $code_event[$i]; ?>" style="background-color: <?php
									if ($status[$i] == 0)
										echo '#ffd0b4';
									else
										echo '#b4e7df'; ?>" onclick="gantistatus('<?php echo $code_event[$i]; ?>')"
											type="button"><?php echo $namastatus[$status[$i]]; ?></button>
									<button id="btd_<?php echo $code_event[$i]; ?>" style="background-color: <?php
									if ($default[$i] == 0)
										echo '#F0F0F0';
									else
										echo '#99C17D'; ?>" onclick="gantidefault('<?php echo $code_event[$i]; ?>')"
											type="button"><?php echo $namadefault[$default[$i]]; ?></button>
								</td>
								<td>
									<button class='ctbevent' onclick="window.open('<?php echo base_url(); ?>event/pilihan/<?php
									echo $link_event[$i]; ?>','_blank')" id="btn-show-all-children" type="button">Lihat
									</button>
									<button class='ctbevent' 
										onclick="window.location.href='<?php echo base_url(); ?>event/editevent/<?php
										echo $code_event[$i]; ?>'" id="btn-show-all-children" type="button">Edit
									</button>
									<button class='ctbevent' 
										onclick="window.location.href='<?php echo base_url(); ?>event/aktivasi_event/<?php
										echo $code_event[$i]; ?>'" id="btn-show-all-children" type="button">Peserta
									</button>
									<button class='ctbevent' onclick="return mauhapus('<?php echo $code_event[$i]; ?>')"
											id="btn-show-all-children" type="button">Hapus
									</button>
								</td>
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

<style>
	.text-wrap {
		white-space: initial;
		word-break: break-word;
	}

	.ctbevent {
		margin-top: 2px;
		margin-bottom: 2px;
	}

</style>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>

<script>

	var defaultakhir;

	defaultakhir = '<?php echo $defaultakhir;?>';

	//$('#d3').hide();

	$(document).ready(function () {
		var divx = document.getElementById('d1');
//divx.style.visibility = "hidden";
//divx.style.display = "none";

		var table = $('#tbl_user').DataTable({
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='lebar10'>" + data + "</div>";
					},
					targets: [0]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap lebar30'>" + data + "</div>";
					},
					targets: [1]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap lebar50'>" + data + "</div>";
					},
					targets: [6]
				}
			]

		});

		// new $.fn.dataTable.FixedHeader(table);

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

	function gantistatus(codex) {
		statusnya = 0;
		if ($('#bt1_' + codex).html() == "NonAktif") {
			statusnya = 1;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>event/gantistatus",
			method: "POST",
			data: {code: codex, status: statusnya},
			success: function (result) {
				if ($('#bt1_' + codex).html() == "Aktif") {
					$('#bt1_' + codex).html("NonAktif");
					$('#bt1_' + codex).css({"background-color": "#ffd0b4"});
				} else {
					$('#bt1_' + codex).html("Aktif");
					$('#bt1_' + codex).css({"background-color": "#b4e7df"});
				}
			}
		})

	}

	function gantidefault(codex) {
		defaultnya = 0;
		if ($('#btd_' + codex).html() == "-") {
			defaultnya = 1;
		}

		if (codex == defaultakhir) {

		} else {
			if ($('#btd_' + defaultakhir).html() == "Default") {
				$('#btd_' + defaultakhir).html("-");
				$('#btd_' + defaultakhir).css({"background-color": "#F0F0F0"});
			}
		}

		$.ajax({
			url: "<?php echo base_url(); ?>event/gantidefault",
			method: "POST",
			data: {code: codex, status: defaultnya},
			success: function (result) {
				if ($('#btd_' + codex).html() == "Default") {
					$('#btd_' + codex).html("-");
					$('#btd_' + codex).css({"background-color": "#F0F0F0"});
				} else {
					defaultakhir = codex;
					$('#btd_' + codex).html("Default");
					$('#btd_' + codex).css({"background-color": "#99c17d"});
				}
			}
		})

	}

	function mauhapus(codeevent) {
		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url();?>event/hapusevent/' + codeevent);
		} else {
			return false;
		}
		return false;
	}

</script>
