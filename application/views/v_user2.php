<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator', '', '', '', '', '', '-');

$jml_user = 0;
foreach ($dafuser as $datane) {
	$jml_user++;
	$nomor[$jml_user] = $jml_user;
	$id_user[$jml_user] = $datane->id;
	$first_name[$jml_user] = $datane->first_name;
	$nomor_nasional[$jml_user] = $datane->nomor_nasional;
	$sekolah[$jml_user] = $datane->sekolah;
	$last_name[$jml_user] = $datane->last_name;
	$email[$jml_user] = $datane->email;
	if ($datane->activate == 0)
		$activate[$jml_user] = "<span style='font-weight:bold;color:red'> [belum aktif]</span>";
	else
		$activate[$jml_user] = "";
	$iscalon = "";
	if ($datane->alamat == "")
		$iscalon = "Calon ";
	$sebagai[$jml_user] = $iscalon . $txt_sebagai[$datane->sebagai];
	$idsebagai[$jml_user] = $datane->sebagai;

	$ket = '';
	if ($datane->verifikator > 1) {
		$ket = ' Staf';
		if ($datane->sebagai == 1) {
			$ket = ' Sekolah';
		}
	}

	$cekver[$jml_user] = '';
	if ($datane->verifikator == 3)
		$cekver[$jml_user] = 'checked';
	$cekkon[$jml_user] = '';
	if ($datane->kontributor == 3)
		$cekkon[$jml_user] = 'checked';

	$txt_verifikator[$jml_user] = $nama_verifikator[$datane->verifikator] . $ket;

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
				<center><span style="font-size:18px;font-weight: bold;">Daftar Narasumber
						<?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') == 1) {
							echo "<br>" . $sekolahku;
						}
						?>
        </span>
				</center>
				<br><br>
				<?php if ($this->session->userdata("a01") || ($this->session->userdata("sebagai") == 4
						&& $this->session->userdata("verifikator") == 3)) { ?>
					<center>
	<span style="font-size: 14px; font-weight: bold">
				<button onclick="window.open('<?php echo base_url() . "user/"; ?>','_self');"
						style="padding:5px;margin-bottom: 5px;" class="">Daftar User</button>
				<button onclick="window.open('<?php echo base_url() . "user/narsum"; ?>','_self');"
						style="padding:5px;margin-bottom: 5px;" class="">Daftar Narsum</button>
				<button onclick="window.open('<?php echo base_url() . "user/ae"; ?>','_self');"
						style="padding:5px;margin-bottom: 5px;" class="">Daftar AE</button>
				<button onclick="window.open('<?php echo base_url() . "user/am"; ?>','_self');"
						style="padding:5px;margin-bottom: 5px;" class="">Daftar AM</button>
				<button onclick="window.open('<?php echo base_url() . "user/agency"; ?>','_self');"
						style="padding:5px;margin-bottom: 5px;" class="">Daftar Agency</button>
				<button onclick="window.open('<?php echo base_url() . "user/bimbel"; ?>','_self');"
						style="padding:5px;margin-bottom: 5px;" class="">Daftar Tutor</button>
			</span>
					</center>
				<?php } ?>
				<!--<button style="margin-left:10px" id="btn-show-all-children" type="button">Expand All</button>-->
				<!--<button style="margin-left:10px" id="btn-hide-all-children" type="button">Collapse All</button>-->
				<hr>

				<div>
				<button type="button" onclick="window.location.href='<?php echo base_url(); ?>user/tambahnarsum'"
						class="btn-main" style="float: right; margin-bottom: 10px;">Tambah User
				</button>
				</div>

				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style='width:5px;text-align:center'>No</th>
							<th style='width:20%;text-align:center'>Nama</th>

							<?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 1) { ?>
								<th style='text-align:center'>Nama Sekolah</th>
							<?php } ?>
							<!-- <th>Verifikator</th> -->
							<!-- <th class="none">Email</th> -->
							<th>Email</th>
							<th style='text-align:center'>Detail</th>


						</tr>
						</thead>

						<tbody>
						<?php for ($i = 1; $i <= $jml_user; $i++) {
							// if ($idsebagai[$i]!="4") continue;
							?>

							<tr>
								<td style='text-align:right'><?php echo $nomor[$i]; ?></td>
								<td><?php echo $first_name[$i] . ' ' . $last_name[$i]; ?></td>

								<?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 1) { ?>
									<td><?php echo $sekolah[$i]; ?></td>
								<?php } ?>
								<!-- <td><?php echo $txt_verifikator[$i]; ?></td> -->
								<td><?php echo $email[$i]; ?></td>
								<td style='text-align:center'>
									<button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
									echo $id_user[$i] . '/' . $asal; ?>'">Detail
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
<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>

<script>

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
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [1, 2]
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
