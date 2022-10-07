<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator','','','','','','-');

$tasses = array ("", "ACCOUNT EXECUTIVE", "AREA MARKETING", "TUTOR BIMBEL ONLINE")
?>


<div class="bgimg5" style="margin-top: 30px;">
	<center>
		<div style="font-size: 14px;font-weight:bold; color:black;padding-top: 50px;">
			<center><span style="font-size:20px;font-weight:Bold;">ASSESMENT <?php echo $tasses[substr($untuksi,0,1)]." - 3";?></span></center>
		</div>
		<hr>
	</center>
	<div style="margin-top:0px;opacity:90%;padding-top:0px;padding-bottom:0px;color: black;">
		<div class="wb_LayoutGrid1" style="background-color:white;max-width: 800px;margin: auto;padding:5px;">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1" style="padding: 5px;">
						<?php echo $uraian;?>
					</div>
				</div>
				<div style="margin-top: 20px;">
					<?php if ($file != "") { ?>
						<center><button style="width:180px;padding:10px 20px;margin-bottom:15px;" class="btn-primary"
								onclick="window.open('<?php echo base_url()."seting/download_esay/".$untuksi; ?>','_self')">
							Unduh Lampiran
						</button></center>
					<?php } ?>
				</div>

			</div>
		</div>
	</div>


	<div class="wb_LayoutGrid1">
		<div class="LayoutGrid1">
			<div class="row">
				<div class="col-1" style="text-align:center;color:black;margin-bottom: 15px;">
					<button class="btn-info" onclick="kembali()" id="tbselesai">Kembali</button>
				</div>
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.bootstrap.min.css">

<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}
</style>


<script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery-3.4.1.js"></script>
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


	function kembali() {
		window.open("<?php echo base_url().'seting/esay/buat/'.$untuksi;?>","_self");
	}

</script>
