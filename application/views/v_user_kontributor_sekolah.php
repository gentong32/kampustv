<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Orang Tua', 'Staf Fordorum');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

if (!isset($asal))
	$asal="";
else
	$cekasal = "/".$asal;

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
				<center><span style="font-size:20px;font-weight: bold;">Daftar Guru Modul Sekolah</span><br>
					<div style="margin-bottom: 20px;"><button class="btn-info"
							onclick="window.location.href='<?php echo base_url().'user/kontributorbimbel/dashboard';?>'">Guru Modul Bimbel
					</button>
					</div>
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

				<div style="margin-bottom: 25px;">
				<button style="padding-left:10px;padding-right:10px;margin-bottom: 5px;" class="btn-primary" id="urutok">Urut per Jumlah OK / Lengkap</button>
				<button style="padding-left:10px;padding-right:10px;margin-bottom: 5px;" class="btn-primary" id="urutjml">Urut per Jumlah Semua</button>
				</div>

				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:2%;text-align:center">No</th>
							<th style='width:10%;text-align:center'>Nama Guru</th>
							<th style='width:10%;text-align:center'>Status</th>
							<th style='width:10%;text-align:center'>Sekolah</th>
							<th class="none">Email</th>
							<th class="none">HP</th>
							<th style='width:20%;text-align:center'>Modul Lengkap</th>
							<th style='width:20%;text-align:center'>Modul Semua</th>

						</tr>
						</thead>
					</table>
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

			if($datane->verifikator==3)
				$statusguru = "Verifikator";
			else if ($datane->kontributor==3)
				$statusguru = "Kontributor";

			$moduloke = "<center><button style='width:70px;' onclick='bukamodul(".$datane->id.");'>".$datane->jml_oke."</button></center>";


			echo "data.push([ " . $jml_user . ", \"" . $datane->first_name . " " . $datane->last_name . "\", \"" .
				$statusguru . "\", \"" . $datane->sekolah . "\", \"" . $datane->email . "\", \"" .
				$datane->hp . "\", \"" . $moduloke . "\", \"" ."<center>".$datane->jml_semua."</center>". "\"]);";
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
			table.order([[6, 'desc']]).draw();
		});

		$('#urutjml').on('click', function () {
			table.order([[7, 'desc']]).draw();
		});

	});

	function bukamodul(id) {
		window.open('<?php echo base_url()."virtualkelas/modul_guru/chusr";?>'+id,'_self');
	}


</script>
