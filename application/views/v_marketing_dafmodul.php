<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

$blnlalu = $blnskr - 1;
if ($blnlalu==0)
	$blnlalu = 12;
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
						<h1>Area Marketing</h1>
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

				<div style="color:#000000;margin:auto;background-color:white;">
					<br>
					<center><span style="font-size:16px;font-weight: bold;">DAFTAR MODUL GURU SEKOLAH<br>
						</span>
						<div style="display: inline-block">
							<select class="form-control" style="width: 130px;" name="ibulan" id="ibulan">
							echo "<option value=0>-Bulan-</option>";
								<?php for ($a = $blnlalu; $a <= $blnskr; $a++) {
									if ($a == $bulan)
										echo "<option selected value=$a>$namabulan[$a]</option>";
									else
										echo "<option value=$a>$namabulan[$a]</option>";
								} ?>
							</select>
						</div>
				</center>
						<!-- <div style="float:left;margin-bottom: 10px;">
					<button type="button" class="btn-main" onclick="kembali();">Kembali</button>
				</div> -->
				<hr>

					<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
						<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
							<thead>
							<tr>
								<th style="width:2%;text-align:center">No</th>
								<th style='width:10%;text-align:center'>Sekolah</th>
								<th style='width:10%;text-align:center'>Nama</th>
								<th style='width:10%;text-align:center'>Kelas</th>
								<th style='width:10%;text-align:center'>Mapel</th>
								<th style='width:10%;text-align:center'>Nama Modul</th>
								<th style='width:10%;text-align:center'>Ke-</th>
								<th style='width:10%;text-align:center'>Status</th>
							</tr>
							</thead>
						</table>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>

<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}
</style>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<script>

	//$('#d3').hide();

	$(document).ready(function () {
		//$.fn.DataTable.ext.pager.numbers_length = 4;
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($dafmodul as $datane) {
			$jml_user++;

			if($datane[0]->statusmentor==0) {
				$ket = "Siap Diperiksa";
			}
			else if($datane[0]->statusmentor==1) {
				$ket = "Belum OK";
			}
			else
			{
				$ket = "OK";
			}

			
			if ($datane[0]->statussoal==1 && $datane[0]->uraianmateri!="" && $datane[0]->statustugas==1)
				$status = "<center><button onclick='periksa(`".$datane[0]->link_list."`,`materi`)'>".$ket."</button></center>";
			else
			if (($datane[0]->nama_paket=="UTS" || $datane[0]->nama_paket=="UAS" || 
			$datane[0]->nama_paket=="REMEDIAL UTS" || $datane[0]->nama_paket=="REMEDIAL UAS") && 
			$datane[0]->statussoal==1)
				$status = "<center><button onclick='periksaujian(`".$datane[0]->link_list."`,`ujian`)'>".$ket."</button></center>";
				else
				$status = "Belum Lengkap";
			

			$nama = $datane[0]->first_name." ".$datane[0]->last_name;
			$nama_kelas = substr($datane[0]->nama_kelas,6);
			$semester = $datane[0]->semester;
			$nama_mapel = $datane[0]->nama_mapel;
			$modulke = $datane[0]->modulke;
			if ($modulke>16)
			$modulke = "-";

			echo "data.push([ " . $jml_user . ", \"" . $datane[0]->nama_sekolah.
				"\", \"" . $nama .
				"\", \"" . $datane[0]->nama_kelas . " / " . $datane[0]->semester .
				"\", \"" . $datane[0]->nama_mapel .
				"\", \"" . $datane[0]->nama_paket .
				"\", \"" . $modulke .
				"\", \"" . $status."\"]);";
		}
		?>


		$('#tbl_user').DataTable({
			data:           data,
			deferRender:    true,
			scrollCollapse: true,
			scroller:       true,
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
					targets: [0, 1, 2, 5]
				}
				// {
				// 	render: function (data, type, full, meta) {
				// 		return "<div style='text-align: center' class='text-wrap width-50'>" + data + "</div>";
				// 	},
				// 	targets: [3]
				// }
			]
		});


		// new $.fn.dataTable.FixedHeader(table);

	});

	function kembali() {
		window.history.back();
	}

	function periksa(linklist)
	{
		var bulan = $('#ibulan').val();
		window.open('<?php echo base_url()."marketing/lihatmodul/";?>'+linklist + '/' + bulan,'_self')
	}

	function periksaujian(linklist)
	{
		var bulan = $('#ibulan').val();
		window.open('<?php echo base_url()."marketing/lihatmodulujian/";?>'+linklist + '/' + bulan,'_self')
	}

	$(document).on('change input', '#ibulan', function () {
		var bulan = $('#ibulan').val();
		window.open("<?php echo base_url() . 'marketing/daftar_modul/';?>" + bulan, "_self");
	});

</script>
