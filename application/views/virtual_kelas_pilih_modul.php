<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$kettayang = array('Kosong', 'Belum/Sedang Tayang', 'Sudah Tayang');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

$jml_paket = 0;

$do_not_duplicate = array();

foreach ($dafmapel as $datane) {
	$jml_paket++;
	$nomor[$jml_paket] = $jml_paket;
	$id_paket[$jml_paket] = $datane->id;
	$idmapel[$jml_paket] = $datane->idmapel;
	$namamapel[$jml_paket] = $datane->nama_mapel;
	$idguru[$jml_paket] = $datane->idguru;
	$namaguru[$jml_paket] = $datane->first_name." ".$datane->last_name;
	if ($datane->iduserpilih==null)
		$statuspilih[$jml_paket] = "";
	else
		{
			$statuspilih[$jml_paket] = "Terpilih";
			if (in_array($datane->idmapel, $do_not_duplicate)) {

			}
			else
			{
				$do_not_duplicate[] = $datane->idmapel;
			}
		}
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
					<h3 class="text-center">Pilihan Modul</h3>
				</div>
				<div style="margin-bottom: 10px;">
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/sekolah_saya'">Kembali
					</button>
				</div>
				<hr>
				<span style="font-size: 16px;">Pilihan dosen bisa diubah-ubah pada pertemuan pertama saja.</span>
			</div>


			<div id="tabel1" style="margin-left:10px;margin-right:10px;">
				<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th style='padding:5;width:5px;'>No</th>
						<th>Mata Kuliah</th>
						<th>Nama Dosen</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
					</thead>

					<tbody>
					<?php
					for ($i = 1; $i <= $jml_paket; $i++) {
						?>
						<tr>
							<td><?php echo $nomor[$i]; ?></td>
							<td><?php echo $namamapel[$i]; ?></td>
							<td><?php echo $namaguru[$i]; ?></td>
							<td><?php echo $statuspilih[$i]; ?></td>
							<td>
								<?php if($modulke==1 || !in_array($idmapel[$i], $do_not_duplicate)){?>
								<button
									onclick="window.open('<?php echo base_url(); ?>virtualkelas/updatemodulpilihan/<?php
									echo $idmapel[$i]."/".$idguru[$i]; ?>', '_self')"
									id="thumbnail" type="button">Pilih
								</button>
								<?php } else
									{
										echo "-";
									} ?>
							</td>
						</tr>
						<?php
					}
					?>
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
<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


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
					},
					targets: [1, 2, 4]
				},
				{
					width: 25,
					targets: 0
				}
			]

		});

	});


</script>
