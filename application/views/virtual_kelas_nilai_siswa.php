<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$kettayang = array('Kosong', 'Belum/Sedang Tayang', 'Sudah Tayang');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

$jml_mapel = 0;
foreach ($dafmapel as $datane) {
	$jml_mapel++;
	$namamapel[$jml_mapel] = $datane;
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
				<div class="col-lg-12">
					<h3 class="text-center">Nilai Latihan Saya</h3>
				</div>
				<div style="margin-bottom: 10px;">
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/sekolah_saya'">Kembali
					</button>
				</div>
				<hr>

			</div>


			<div id="tabel1" style="margin-left:10px;margin-right:10px;">
				<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th style='padding:5;width:5px;text-wrap: initial;'>No</th>
						<?php for ($a=1;$a<=$jml_mapel;$a++) {?>
							<th><?php echo $namamapel[$a];?></th>
						<?php } ?>
						<th>Rata-rata</th>
					</tr>
					</thead>

					<tbody>
					<?php for ($i = 1; $i <= $modulakhir; $i++) {?>
						<tr>
							<td><?php echo $i;?></td>
						<?php for ($i2 = 1; $i2 <= $jml_mapel+1; $i2++) { ?>
							<td><?php
							if ($i2 == $jml_mapel + 1) {
								if (isset($totalnilaimodulke[$i]))
									echo round($totalnilaimodulke[$i]/$jml_mapel,2);
								else
									echo "0";
							} else {
								if (!isset($datanilai[$namamapel[$i2]][$i]))
									echo "0";
								else
									echo $datanilai[$namamapel[$i2]][$i]; ?></td>
							<?php }
						}?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<center>
	<div
		style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;margin-bottom:20px;background-color:white;">
		<div id="video-placeholder" style='display:none'></div>
		<div id="videolokal" style='display:none'></div>
	</div>
</center>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>

<script>
	var oldurl = "";
	var oldurl2 = "";

	$(document).ready(function () {
		var table = $('#tbl_user').DataTable({
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					}
				},
				{
					width: 5,
					targets: [0]
				}

			]

		});

	});


</script>
