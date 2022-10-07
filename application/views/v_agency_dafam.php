<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
						<h1>Agency</h1>
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
				<center><span style="font-size:18px;font-weight: bold;">DAFTAR NAMA AREA MARKETING / MENTOR<br><br>
		</span></center>
				<br>
				<div style="margin-bottom: 10px;">
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
					</button>
				</div>
				<hr>

				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:25px;text-align:center">No</th>
							<th style='width:20%;text-align:center'>Nama</th>
							<?php if ($level==1)
							{ ?>
								<th style='width:10%;text-align:center'>Kota</th>
								<th style='width:10%;text-align:center'>Alamat</th>
							<?php } else {?>
								<th style='width:20%;text-align:center'>Alamat</th>
							<?php } ?>
							<th style='width:20%;text-align:center'>HP</th>
							<th style='width:20%;text-align:center'>Email</th>
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

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
<script src="<?php echo base_url('ckeditor/ckeditor.js'); ?>"></script>

<script>

	//$('#d3').hide();

	$(document).ready(function () {
		//$.fn.DataTable.ext.pager.numbers_length = 4;
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($dafuser as $datane) {
			$jml_user++;
			$kota = "";
			$nama = $datane->first_name . " " . $datane->last_name;
			$alamatnya = trim(preg_replace('/\s\s+/', ' ', $datane->alamat));
			if ($level==1)
			{
				$kota = "\", \"" . $datane->nama_kota;
			}
			echo "data.push([ " . $jml_user . ", \"" . $nama . 
				$kota .
				"\", \"" . $alamatnya .
				"\", \"" . $datane->hp .
				"\", \"" . $datane->email . "\"]);";
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
					targets: [1, 2]
				},
				{
					render: function (data, type, full, meta) {
						return "<div style='text-align: center' class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [3]
				}
			]
		});


		// new $.fn.dataTable.FixedHeader(table);

	});

	function kembali() {
		window.history.back();
	}

</script>
