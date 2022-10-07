<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_soal = 0;

foreach ($dafpenilaian as $datane) {
	$jml_soal++;
	$nomor[$jml_soal] = $jml_soal;
	$soal[$jml_soal] = $datane->nama_penilaian;
}
?>


<main id="myContainer" class="MainContainer">

</main>


<div id="myModal" class="Modal is-hidden is-visuallyHidden">
	<!-- Modal content -->
	<div class="Modal-content" style="max-width: 500px">
		<span id="closeModal" class="Close">&times;</span>
		<?php if ($this->session->userdata('loggedIn')) { ?>
			<p>Ketik Pertanyaan</p><br>
			<input type="text" class="form-control" id="iteksnilai" name="iteksnilai" maxlength="200"
				   value="" placeholder="Pertanyaan">
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

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/blur.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
	<br>
	<center><span style="text-align:center;font-size:16px;font-weight: bold;"><?php echo $title; ?></span></center>
	<br>
	<?php if ($jml_soal <= 20) { ?>
		<button type="button" onclick="return bukamodal()"
				style="float:right;margin-right:40px;margin-bottom:10px;">Tambah
		</button>
		<button type="button" onclick="kurangisoal()"
				style="float:right;margin-right:5px;margin-bottom:10px;">Kurangi
		</button>
	<?php } ?>
	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table style="color: black" id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style='width:250px;'>Nomor</th>
				<th style=''>Daftar Penilaian</th>
				<th style=''>Edit</th>
			</tr>
			</thead>

			<tbody>
			<?php for ($i = 1; $i <= $jml_soal; $i++) {
				?>
				<tr>
					<td><?php echo $nomor[$i]; ?></td>
					<td><?php echo $soal[$i]; ?></td>
					<td>
						<button onclick="diedit('<?php echo $i; ?>')" type="button">Edit</button>
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
		var soale = $('#iteksnilai').val();

		if (soale.length > 3) {
			$.ajax({
				url: "<?php echo base_url();?>seting/editpenil",
				method: "POST",
				data: {soal: soale, jmlsoal:<?php echo $jml_soal;?>},
				success: function (result) {
					window.open('<?php echo base_url();?>seting/penilaian', '_self');
				}
			})
		}
		else {
			alert("Tulis soalnya dahulu dengan benar!")
		}
	}

	function diedit(idx) {
		indeks = idx;
		var isi = new Array();
		<?php
		for ($a = 1; $a <= $jml_soal; $a++) {
			echo "isi[" . $a . "]='" . $soal[$a] . "';";
		}
		?>

		$('#tbupdate').show();
		$('#tbtambah').hide();

		bukamodal();
		$('#iteksnilai').val(isi[idx]);
	}

	function dieditsoal() {
		//alert (indeks);
		var soale = $('#iteksnilai').val();

		$.ajax({
			url: "<?php echo base_url();?>seting/editpenil",
			method: "POST",
			data: {soal: soale, jmlsoal: (indeks - 1)},
			success: function (result) {
				window.open('<?php echo base_url();?>seting/penilaian', '_self');
			}
		})
	}

	function kurangisoal(){
		var r = confirm("Yakin mau mengurangi 1 pertanyaan?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url();?>seting/editpenil",
				method: "POST",
				data: {soal: "", jmlsoal: <?php echo $jml_soal;?>},
				success: function (result) {
					window.open('<?php echo base_url();?>seting/penilaian', '_self');
				}
			});
		} else {
			return false;
		}
		return false;
	}

</script>
