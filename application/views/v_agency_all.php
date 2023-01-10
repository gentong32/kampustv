<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nama_status = Array('-', 'Aktif', 'Tak aktif');
$stratasekolah = Array('-', 'Lite', 'Pro', 'Premium','','','','Free Lite','Free Pro','Free Premium');
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
						<h1>Daftar Agency</h1>
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
				<center><span style="font-size:18px;font-weight: bold;">DAFTAR AGENCY PER LLDIKTI WILAYAH</span></center>
				<br><br>
				<div>
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">
						Kembali
					</button>
				</div>
				<hr style="margin-top: 10px;">
				
				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:3%;text-align:center">No</th>
							<th style='width:20%;'>LLDIKTI Wilayah</th>
							<th style='width:5%;'>Lokasi Kantor</th>
							<th style='width:20%;text-align:center'>Kampus Aktif</th>
							<th>Agency</th>
							<th>Aksi</th>
						</tr>
						</thead>
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

<script>

	$(document).ready(function () {
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($dafagency as $datane) {
			$jml_user++;

			if(trim($datane->first_name)=="")
			{
				if(trim($datane->email)=="")
					{
						$namaagency = "-";
						$tombol = "<button onclick='bukalink(`".base_url()."channel/inputagency/".
						$datane->id_wilayah."`, `_self`)' type='button' class='tb_hijau'>Input Agency</button>";
					}
				else
					{
						$namaagency = $datane->email;
						$tombol = "<button onclick='bukalink(`".base_url()."channel/inputagency/".
						$datane->id_wilayah."`, `_self`)' type='button' class='tb_oren'>Ubah Agency</button>";
					}
			}
			else
			{
				$namaagency = $datane->first_name . " " . $datane->last_name;
				$tombol = "<button onclick='bukalink(`".base_url()."channel/inputagency/".
				$datane->npsn."/".$datane->kd_prodi."`, `_self`)' type='button' class='tb_oren'>Ubah Agency</button>";
			}
			

			$namasekolah = str_replace(['"',"'"], "'", $datane->nama_sekolah);
			
			echo "data.push([ " . $jml_user . 
				", \"" . $datane->nama_lembaga .
				"\", \"" . $datane->lokasi_wilayah .
				"\", \"" . $datane->jml_kampus .
				"\", \"" . $namaagency .
				"\", \"" . $tombol . "\"]);\n\r";
		}
		?>


		$('#tbl_user').DataTable({
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
					targets: [0, 1, 4]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='ratakanan'>" + data + "</div>";
					},
					targets: [3]
				}
			]
		});
	});

	function bukalink(url)
	{	
		window.open(url, '_self');
	}

</script>
