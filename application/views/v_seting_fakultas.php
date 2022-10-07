<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_fakultas = 0;

foreach ($daffakultas as $datane) {
	$jml_fakultas++;
	$id[$jml_fakultas] = $datane->id;
	$fakultas[$jml_fakultas] = $datane->nama_fakultas;
}
?>


<main id="myContainer" class="MainContainer">

</main>


<div id="myModal" class="Modal is-hidden is-visuallyHidden">
	<!-- Modal content -->
	<div class="Modal-content" style="max-width: 500px">
		<span id="closeModal" class="Close">&times;</span>
		<?php if ($this->session->userdata('loggedIn')) { ?>
			<p>Ketik Fakultas</p><br>
			<input type="text" class="form-control" id="iteksnilai" name="iteksnilai" maxlength="200"
				   value="" placeholder="Fakultas">
			<button type="button" onclick="tutupmodal()" class="btn btn-success"
					style="float:right;margin-right:10px;margin-top:10px;">Batal
			</button>
			<button id="tbtambah" type="button" onclick="ditambahsoal()" class="btn btn-success"
					style="float:right;margin-right:10px;margin-top:10px;">Tambahkan
			</button>
			<button id="tbupdate" type="button" onclick="dieditsoal()" class="btn btn-success"
					style="display:none;float:right;margin-right:10px;margin-top:10px;">Update
			</button>
		<?php } else { ?>
			<p>Silakan login terlebih dahulu</p><br>
		<?php } ?>
	</div>
</div>

<input type="hidden" class="form-control" id="iteksid" name="iteksid">

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/blur.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
	<br>
	<center><span style="text-align:center;font-size:16px;font-weight: bold;"><?php echo $title; ?></span></center>
	<br>
	<?php if ($jml_fakultas <= 100) { ?>
		<button type="button" onclick="return bukamodal()"
				style="float:right;margin-right:40px;margin-bottom:10px;">Tambah
		</button>
	<?php } ?>
	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table style="color: black" id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style=''>No</th>
				<th style=''>Fakultas</th>
				<th style=''>Edit</th>
			</tr>
			</thead>

			<tbody>
			<?php for ($i = 1; $i <= $jml_fakultas; $i++) {
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $fakultas[$i]; ?></td>
					<td>
						<button onclick="diedit('<?php echo $i; ?>')" type="button">Edit</button> /
						<button onclick="dihapus('<?php echo $i; ?>')" type="button">Hapus</button>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>

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

<script>
	var indeks;
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

	function ditambahsoal() {
		var fakultas = $('#iteksnilai').val();

		if (fakultas.length > 3) {
			$.ajax({
				url: "<?php echo base_url();?>seting/tambahfakultas",
				method: "POST",
				data: {fakultas: fakultas},
				success: function (result) {
					window.open('<?php echo base_url();?>seting/fakultas', '_self');
				}
			})
		}
		else {
			alert("Tulis soalnya dahulu dengan benar!")
		}
	}

	function diedit(idx) {
		//alert ("OK");
		indeks = idx;
		var isi = new Array();
		var id = new Array();
		<?php
		for ($a = 1; $a <= $jml_fakultas; $a++) {
			echo "id[" . $a . "]='" . $id[$a] . "';";
			echo "isi[" . $a . "]='" . $fakultas[$a] . "';";
		}
		?>

		$('#tbupdate').show();
		$('#tbtambah').hide();

		bukamodal();
		$('#iteksid').val(id[idx]);
		$('#iteksnilai').val(isi[idx]);
	}

	function dieditsoal() {
		//alert (indeks);
		var ide = $('#iteksid').val();
		var fakultase = $('#iteksnilai').val();

		// alert (ide);
		// alert (fakultase);

		$.ajax({
			url: "<?php echo base_url();?>seting/editfakultas",
			method: "POST",
			data: {id: ide, fakultas: fakultase},
			success: function (result) {
				window.open('<?php echo base_url();?>seting/fakultas', '_self');
			}
		})
	}

	function dihapus(idx) {
		var isi = new Array();
		var id = new Array();

		<?php
		for ($a = 1; $a <= $jml_fakultas; $a++) {
			echo "id[" . $a . "]='" . $id[$a] . "';";
			echo "isi[" . $a . "]='" . $fakultas[$a] . "';";
		}
		?>

		var r = confirm("Yakin mau hapus fakultas ini?");

		if (r == true) {

			$.ajax({
				url: "<?php echo base_url();?>seting/delfakultas",
				method: "POST",
				data: {id: id[idx]},
				success: function (result) {
					window.open('<?php echo base_url();?>seting/fakultas', '_self');
				}
			});
		} else {
			return false;
		}
		return false;
	}

</script>
