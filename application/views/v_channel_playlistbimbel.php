<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$kettayang = array('Kosong', 'Belum/Sedang Tayang', 'Sudah Tayang');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

$jml_paket = 0;
foreach ($dafpaket as $datane) {
	$jml_paket++;
	$nomor[$jml_paket] = $jml_paket;
	$id_paket[$jml_paket] = $datane->id;
	$link_paket[$jml_paket] = $datane->link_list;
	$nama_paket[$jml_paket] = $datane->nama_paket;
	$durasi_paket[$jml_paket] = $datane->durasi_paket;
	$status_paket[$jml_paket] = $datane->status_paket;
	$tayang_paket1[$jml_paket] = $datane->tanggal_tayang;
	$tglvicon = $datane->tglvicon;
	$tglsekarang = new DateTime();
	$tglsekarang->setTimezone(new DateTimeZone('Asia/Jakarta'));
	if ($tglsekarang > new DateTime($tglvicon))
		$tayang_paket[$jml_paket] = "<button onclick=\"setjadwalvicon('" . $datane->link_list . "')\">Set Jadwal Baru</button>";
	else
		$tayang_paket[$jml_paket] = "<button onclick=\"setjadwalvicon('" . $datane->link_list . "')\">" . substr($datane->tglvicon, 8, 2) . ' ' . $namabulan[(int)(substr($datane->tglvicon, 5, 2))] . ' ' . substr($datane->tglvicon, 0, 4) . ' - ' . substr($datane->tglvicon, 11, 5) . ' WIB' . "</button>";
}

if ($linklist == null)
	$tambahalamat = "";
else
	$tambahalamat = "/" . $linklist;
?>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
	<br>
	<center>
		<span style="font-size:16px;font-weight: bold;"><?php echo $title; ?>
			<?php if ($linklist <> null) echo "Event Spesial"; ?>
		</span>
		<br>
		<?php if ($linklist <> null) {
			echo "<span style=\"font-size:20px;font-weight: bold;\">" . $judulevent . "</span><br>";
			echo "<span style=\"color:darkgrey;font-style:italic;font-size:14px;font-weight: bold;\">" . $subjudulevent . "</span><br><br>";
		} ?>
	</center>
	<br>
	<button type="button" onclick="window.location.href='<?php echo base_url(); ?>/bimbel/'" class=""
			style="float:left;margin-right:10px;margin-top:-20px;">Channel Bimbel
	</button>

	<button type="button"
			onclick="window.location.href='<?php echo base_url(); ?>channel/tambahplaylist_bimbel<?php echo $tambahalamat; ?>'"
			class=""
			style="float:right;margin-right:10px;margin-top:-20px;">Tambah
	</button>

	<hr>

	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style='padding:5;width:5px;'>No</th>
				<th>Nama Modul</th>
				<th>Durasi</th>
				<th>Tanggal Vicon</th>
				<th>Status</th>
				<th>Detail</th>
			</tr>
			</thead>

			<tbody>
			<?php
			for ($i = 1; $i <= $jml_paket; $i++) {
				?>
				<tr>
					<td><?php echo $nomor[$i]; ?></td>
					<td><?php echo $nama_paket[$i]; ?></td>
					<td><?php echo $durasi_paket[$i]; ?></td>
					<td><?php echo $tayang_paket[$i]; ?></td>
					<td><?php echo $kettayang[$status_paket[$i]]; ?></td>
					<td>
						<button
							onclick="window.open('<?php echo base_url(); ?>channel/inputplaylist_bimbel/<?php echo $link_paket[$i] . $tambahalamat; ?>', '_self')"
							id="thumbnail" type="button">Video
						</button>
						<button
							onclick="window.open('<?php echo base_url(); ?>channel/editplaylist_bimbel/<?php echo $link_paket[$i] . $tambahalamat; ?>', '_self')"
							id="thumbnail2" type="button">Edit
						</button>
						<?php if ($status_paket[$i] == 0) {
							$disabled = "disabled";
						} else {
							$disabled = "";
						}
						?>
						<button <?php echo $disabled;?>
							onclick="window.open('<?php echo base_url(); ?>channel/modul/bimbel/<?php echo $link_paket[$i] . $tambahalamat; ?>', '_self')"
							id="thumbnail" type="button">Lihat Modul
						</button>
						<button
							onclick="window.open('<?php echo base_url(); ?>bimbel/materi/buat/<?php echo $link_paket[$i] . $tambahalamat; ?>', '_self')"
							id="thumbnail3" type="button">Materi
						</button>
						<button
							onclick="window.open('<?php echo base_url(); ?>bimbel/soal/buat/<?php echo $link_paket[$i] . $tambahalamat; ?>', '_self')"
							id="thumbnail4" type="button">Soal
						</button>
						<button
							onclick="window.open('<?php echo base_url(); ?>bimbel/tugas/tampilkan/<?php echo $link_paket[$i] . $tambahalamat; ?>', '_self')"
							id="thumbnail5" type="button">Tugas
						</button>
						<button onclick="return mauhapus('<?php echo $link_paket[$i]; ?>')" id="thumbnail4"
								type="button">Hapus
						</button>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	</div>
</div>

<div style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<div id="video-placeholder" style='display:none'></div>
	<div id="videolokal" style='display:none'></div>
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

<!--<script src="https://www.youtube.com/iframe_api"></script>-->
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
<script>

	var oldurl = "";
	var oldurl2 = "";

	$(document).on('change', '#itahun', function () {
		get_analisis_view();
	});

	function get_analisis_view() {
		window.open("/rtf2/home/filter/" + $('#itahun').val() +
			"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
	}

	$(document).ready(function () {
		var table = $('#tbl_user').DataTable({
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [1, 2, 5]
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

	function lihatvideo(url) {
		document.getElementById("videolokal").style.display = 'none';
		$('#videolokal').html('');

		if (oldurl == "") {
			document.getElementById("video-placeholder").style.display = 'block';
			player.cueVideoById(url);
			player.playVideo();
		} else {
			if ((oldurl == url) && (document.getElementById("video-placeholder").style.display == 'block')) {
				document.getElementById("video-placeholder").style.display = 'none';
				player.pauseVideo();
			} else {
				document.getElementById("video-placeholder").style.display = 'block';
				player.cueVideoById(url);
				player.playVideo();
			}
		}
		oldurl = url;
	}

	function lihatvideo2(url2) {
		player.pauseVideo();
		$('#videolokal').html('<video width="600" height="400" autoplay controls>' +
			'<source src="<?php echo base_url();?>uploads/tve/' + url2 + '" type="video/mp4">' +
			'Your browser does not support the video tag.</video>');
		//alert ("VIDEO");
		document.getElementById("video-placeholder").style.display = 'none';
		if (oldurl2 == "") {
			document.getElementById("videolokal").style.display = 'block';
			//document.getElementById("videolokal").value = "NGENGOS";
		} else {
			if ((oldurl2 == url2) && (document.getElementById("videolokal").style.display == 'block')) {
				document.getElementById("videolokal").style.display = 'none';
				$('#videolokal').html('');
				//document.getElementById("videolokal").value = "NGENGOS";
			} else {
				document.getElementById("videolokal").style.display = 'block';
				//document.getElementById("videolokal").value = "NGENGOS";
			}
		}
		oldurl2 = url2;
	}

	function mauhapus(idx) {

		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url(); ?>channel/hapusplaylist_bimbel/' + idx + '<?php echo $tambahalamat;?>', '_self');
		} else {
			return false;
		}
		return false;
	}

	function gantisifat(idx) {
		statusnya = 0;
		if ($('#bt1_' + idx).html() == "Publik") {
			statusnya = 1;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantisifat",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if ($('#bt1_' + idx).html() == "Publik") {
					$('#bt1_' + idx).html("Pribadi");
					$('#bt1_' + idx).css({"background-color": "#ffd0b4"});
				} else {
					$('#bt1_' + idx).html("Publik");
					$('#bt1_' + idx).css({"background-color": "#b4e7df"});
				}
			}
		})

	}

	function gantilist(idx) {
		statusnya = 0;
		if ($('#bt2_' + idx).html() == "---") {
			statusnya = 1;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantilist",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if ($('#bt2_' + idx).html() == "---") {
					$('#bt2_' + idx).html("Masuk");
					$('#bt2_' + idx).css({"background-color": "#e6e6e6"});
				} else {
					$('#bt2_' + idx).html("---");
					$('#bt2_' + idx).css({"background-color": "#cddbe7"});
				}
			}
		})
	}

	function setjadwalvicon(kodelink) {
		window.open('<?php echo base_url(); ?>channel/setjadwalvicon_bimbel/' + kodelink, '_self');
	}

</script>
