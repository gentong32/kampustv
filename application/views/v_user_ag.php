<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator', '', '', '', '', '', '-');

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
		<div class="container"
		<br>
		<center><span style="font-size:16px;font-weight: bold;">Daftar User Agency
        </span></center>
		<br>
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

		<div id="tabel1" style="margin-left:10px;margin-right:10px;">
			<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
				<thead>
				<tr>
					<th style='width:5px;text-align:center'>No</th>
					<th style='width:20%;text-align:center'>Nama</th>
					<th style='width:15%;text-align:center'>Area Kerja</th>
					<th style='text-align:center'>Status</th>
					<th style='text-align:center'>Profil</th>
					<th style='text-align:center'>Portofolio</th>
					<th style='text-align:center'>Penetapan</th>
				</tr>
				</thead>
			</table>
		</div>
	</section>
</div>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>

<script>

	//$('#d3').hide();

	$(document).ready(function () {

		var data = [];

		<?php
		$jml_user = 0;
		foreach ($dafuser as $datane) {
			$txtsebagai = array("", "Guru", "Siswa", "Umum", "Staf");
			$jml_user++;

			$statusnya = $datane->siag;
			if ($statusnya < 3)
				$tstatus = "Calon Agency";
			else
				$tstatus = "Agency";

			if ($datane->ktp == "" || $datane->ktp == null)
				$merahin1 = " disabled='disabled' class='btn-danger'; ";
			else
				$merahin1 = "";

			if ($datane->gender == null)
				$disabled = 'disabled';
			else
				$disabled = '';

			$namakotane = $datane->nama_kota;
			if ($datane->kd_negara == 2)
				$namakotane = "Malaysia";

//			if($jml_user>58)
//				continue;

			echo "data.push([ " . $jml_user . ", \"" . $datane->first_name . " " .
				$datane->last_name . "\", \"" . $namakotane . "\", \"" .
				$tstatus . "\",\"<button onclick='detil(" . $datane->id . ");'>Profil</button>\"" .
				",\"<button " . $merahin1 . " onclick='porto(" . $datane->id . ");'>Portofolio</button>\"" .
				",\"<button " . $disabled . " onclick='aksi(" . $datane->id . ");'>Aksi</button>\"]);";
		}
		?>


		$('#tbl_user').DataTable({
			data: data,
			deferRender: true,
			scrollCollapse: true,
			scroller: true,
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div style='text-align: center' class='text-wrap'>" + data + "</div>";
					},
					targets: [3, 4, 5, 6]
				},
				{
					render: function (data, type, full, meta) {
						return "<div style='text-align: left' class='text-wrap'>" + data + "</div>";
					},
					targets: [2]
				},
				{
					width: 25,
					targets: 0
				}
			]
		});


		//new $.fn.dataTable.FixedHeader(table);

	});

	function detil(idnya) {
		window.open("<?php echo base_url() . 'user/detil/';?>" + idnya + "/", "_self");
	}

	function porto(idnya) {
		window.open("<?php echo base_url() . 'user/porto/';?>" + idnya + "/", "_self");
	}

	function asses(idnya) {
		window.open("<?php echo base_url() . 'user/assesment/';?>" + idnya + "/", "_self");
	}

	function aksi(idnya) {
		window.open("<?php echo base_url() . 'user/aksi/ag/';?>" + idnya + "/", "_self");
	}

</script>
