<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator', '', '', '', '', '', '-');

$jml_user = 0;
foreach ($dafuser as $datane) {
	$jml_user++;
	$nomor[$jml_user] = $jml_user;
	$nama[$jml_user] = $datane->first_name . " " . $datane->last_name;
	$jawaban[$jml_user] = $datane->jawabantxt;
	$idsiswa[$jml_user] = $datane->id;
	$nilai[$jml_user] = $datane->nilai;

	if ($datane->nilai == "")
		$lihatsudah[$jml_user] = "Beri Nilai";
	else
		$lihatsudah[$jml_user] = "Sudah Dinilai";

}

if ($kodeevent == null)
	$tambahalamat = "";
else
	$tambahalamat = "/".$kodeevent;

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
						<h1>Kelas Virtual</h1>
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
					<div style="font-size: 16px; color:black;">
						Uraian Tugas<br>
						<span style="font-size: 18px;font-weight: bold"><?php echo $judul; ?></span>
					</div>
					<hr>
				</center>
	<div style="margin-top:0px;opacity:90%;padding-top:0px;padding-bottom:0px;color: black;">
		<div class="wb_LayoutGrid1" style="background-color:white;max-width: 800px;margin: auto;padding:5px;">
			<div>
				<div class="row">
					<div style="padding: 5px;">
						<?php echo $uraian; ?>
					</div>
				</div>
				<div style="margin-top: 20px;">
					<?php if ($file != "") { ?>
						<center>
							<button style="width:180px;padding:10px 20px;margin-bottom:15px;" class="btn-primary"
									onclick="window.open('<?php echo base_url() . "bimbel/download/tugas/" . $linklist; ?>','_self')">
								Unduh Lampiran
							</button>
						</center>
					<?php } ?>
				</div>
				<div>
					<div style="text-align:right;color:black;margin-bottom: 0px;padding:10px;">
						<button class="btn-primary" onclick="edittugas();" id="tbselesai">Edit</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if ($kodeevent!=null && get_cookie('basis')!="event") { ?>
	<div style="background-color:white;margin:auto;margin-top:10px;opacity:90%;max-width: 800px;
	padding-top:5px;padding-bottom:20px;color: black;">
		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div>
						<center>
							<div style="font-size: 16px;font-weight: bold;">
								Daftar Jawaban Siswa<br>
							</div>
							<hr>
						</center>
					</div>
				</div>
			</div>
		</div>
		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">

				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap"
						   cellspacing="0" width="100%">
						<thead>
						<tr style="color: black;">
							<th style='width:5px;text-align:center'>No</th>
							<th style='width:60%;text-align:center'>Nama</th>
							<th>Penilaian</th>

						</tr>
						</thead>

						<tbody style="color: black;">
						<?php for ($i = 1; $i <= $jml_user; $i++) {
							// if ($idsebagai[$i]!="4") continue;
							?>

							<tr>
								<td style='text-align:right'><?php echo $nomor[$i]; ?></td>
								<td style='text-align:left'><?php echo $nama[$i]; ?></td>
								<td style='text-align:left'><?php
									if ($jawaban[$i] == "")
										echo "-";
									else
										echo "<button onclick='penilaian(" . $idsiswa[$i] . ");'>" . $lihatsudah[$i] . "</button>";
									?></td>
							</tr>

							<?php
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
	<?php } ?>

	<div class="wb_LayoutGrid1">
		<div class="LayoutGrid1">
			<div class="row">
				<div class="col-1" style="text-align:center;margin-bottom: 15px;">
					<button class="btn-info" onclick="kembali()" id="tbselesai">Kembali</button>
				</div>
			</div>
		</div>
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


	$(document).ready(function () {

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

	function penilaian(idsiswa) {
		window.open("<?php echo base_url().'bimbel/tugas/penilaian/'.$linklist;?>/"+idsiswa,"_self");
	}

	function edittugas() {
		window.open("<?php echo base_url().'bimbel/tugas/buat/'.$linklist.$tambahalamat;?>","_self");
	}

	function kembali() {
		<?php if($this->session->userdata("a01"))
		{ ?>
		window.open("<?php echo base_url().'bimbel/get_bimbel/'.$linklist;?>","_self");
		<?php }
		else if($this->session->userdata("bimbel")==3)
		{
		if ($kodeevent=="saya") { ?>
			window.open("<?php echo base_url().'bimbel/modul_saya/';?>","_self");
		<?php }
		else
		{ ?>
			window.open("<?php echo base_url().'bimbel/inputplaylist_bimbel/'.$linklist;?>","_self");
		<?php }
		 }
		 else if (get_cookie('basis')=="event")
		 { ?>
			window.open("<?php echo base_url().'event/videomodul/'.$linklist.$tambahalamat;?>","_self");
		 <?php }
		else if($this->session->userdata("a03"))
		{ ?>
		window.open("<?php echo base_url().'virtualkelas/bimbel'.$tambahalamat;?>","_self");
		<?php }
		else
		{ ?>
		window.open("<?php echo base_url().'virtualkelas/bimbel'.$tambahalamat;?>","_self");
		<?php	}
		?>
	}

</script>
