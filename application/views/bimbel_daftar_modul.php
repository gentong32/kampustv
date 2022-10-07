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
	$kelas[$jml_paket] = substr($datane->nama_kelas,6);
	$nama_mapel[$jml_paket] = $datane->nama_mapel;
	$semester[$jml_paket] = $datane->semester;
	$nama_paket[$jml_paket] = $datane->nama_paket;
	$durasi_paket[$jml_paket] = $datane->durasi_paket;
	$status_paket[$jml_paket] = $datane->status_paket;
	$status_soal[$jml_paket] = $datane->statussoal;
	$status_tugas[$jml_paket] = $datane->statustugas;
	$materi[$jml_paket] = $datane->uraianmateri;
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
<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<center>
		<h3>Daftar Modul Bimbel <?php if ($linklist <> null) echo "Event Spesial"; ?>
		</h3>
		<?php if ($linklist <> null) {
			echo "<span style=\"font-size:20px;font-weight: bold;\">" . $judulevent . "</span><br>";
			echo "<span style=\"color:darkgrey;font-style:italic;font-size:14px;font-weight: bold;\">" . $subjudulevent . "</span><br><br>";
		} ?>
	</center>
	<br>
	<div style="margin-bottom: 10px;">
		<button type="button" onclick="window.location.href='<?php echo base_url(); ?>bimbel/modul_saya/tampilkan'" class="btn-main">Tampilkan Modul Saya
		</button>
	</div>
	<hr style="margin-top: 0px;margin-bottom: 10px;">

	<div style="margin-bottom: 10px;">
	<button type="button"
			onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/tambahmodul_bimbel<?php echo $tambahalamat; ?>'"
			class="btn-main"
			style="float:right;margin-right:10px;margin-bottom: 10px;">Tambah
	</button>
	</div>


	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style='padding:5;width:5px;'>No</th>
				<th>Kelas</th>
				<th>Mapel</th>
				<th>Nama Modul</th>
				<th>Durasi</th>
				<th>Tanggal Vicon</th>
				<th>Materi/Soal</th>
				<th>Aksi</th>
			</tr>
			</thead>

			<tbody>
			<?php
			for ($i = 1; $i <= $jml_paket; $i++) {
				if ($status_paket[$i] == 0 || $status_soal[$i] == 0 || $materi[$i] == "" ||
					$status_tugas[$i] == 0)
					$keterangan = "Belum";
				else
					$keterangan = "Lengkap";
				?>
				<tr>
					<td><?php echo $nomor[$i]; ?></td>
					<td><?php echo $kelas[$i]." / ".$semester[$i]; ?></td>
					<td><?php echo $nama_mapel[$i]; ?></td>
					<td><?php echo $nama_paket[$i]; ?></td>
					<td><?php echo $durasi_paket[$i]; ?></td>
					<td><?php echo $tayang_paket[$i]; ?></td>
					<td><?php echo $keterangan; ?></td>
					<td>
						<button onclick="window.open('<?php echo base_url(); ?>bimbel/editplaylist_bimbel/<?php echo $link_paket[$i]; ?>', '_self')"
								id="thumbnail" type="button">Detail
						</button>
						<button onclick="window.open('<?php echo base_url(); ?>bimbel/lihatmodul/<?php echo $link_paket[$i]; ?>', '_self')"
								id="thumbnail" type="button">Play
						</button>
						<button onclick="return mauhapus('<?php echo $link_paket[$i]; ?>')" id="thumbnail4"
								type="button">Hapus
						</button>
					</td>
					<?php if (isset($cipek)){?>
					<td>
						<button
							onclick="window.open('<?php echo base_url(); ?>bimbel/inputplaylist_bimbel/<?php echo $link_paket[$i] . $tambahalamat; ?>', '_self')"
							id="thumbnail" type="button">Video
						</button>
						<button
							onclick="window.open('<?php echo base_url(); ?>bimbel/editplaylist_bimbel/<?php echo $link_paket[$i] . $tambahalamat; ?>', '_self')"
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


					</td>
					<?php } ?>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	</div>
</div>
			</div>
		</div>
	</section>
</div>

<div style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<div id="video-placeholder" style='display:none'></div>
	<div id="videolokal" style='display:none'></div>
</div>


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


	$(document).on('change', '#itahun', function () {
		get_analisis_view();
	});

	function get_analisis_view() {
		window.open("/rtf2/home/filter/" + $('#itahun').val() +
			"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
	}


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
			window.open('<?php echo base_url(); ?>bimbel/hapusplaylist_bimbel/' + idx + '<?php echo $tambahalamat;?>', '_self');
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
		window.open('<?php echo base_url(); ?>bimbel/setjadwalvicon_bimbel/' + kodelink, '_self');
	}

</script>
