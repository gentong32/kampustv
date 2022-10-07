<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_contreng = Array('---', 'Masuk');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namasifat = Array('Publik', 'Pribadi');
$statustayang = Array();

if ($opsi=="dashboard")
	$opsidashboard = "/dashboard";
else if ($opsi=="calver")
	$opsidashboard = "/calver";
else
	$opsidashboard = "";

if ($kodeevent!=null)
{
	$kodeevent = "/".$kodeevent;
}
else
{
	$kodeevent = "";
}

// echo $kodeevent;

if ($jml_video == 0) { ?>
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
							<h1>Playlist Sekolah</h1>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</section>
		<!-- section close -->


		<section aria-label="section" class="mt0 sm-mt-0">
			<div class="container">
				<div class="row">
					<br>
					<center>
						<span style="font-size:16px;font-weight: bold;">ANDA BELUM MEMILIKI VIDEO YANG SUDAH DIVERIFIKASI</span>
					</center>
					<br>
					<center>
						<?php if($this->session->userdata('verifikator')==3)
						{ ?>
							<button onclick="window.open('<?php echo base_url() . "video/saya"; ?>','_self');"
								class="btn-main">Video Saya
							</button>
						<?php } else if($this->session->userdata('sebagai')==2)
						{ ?>
							<button onclick="window.open('<?php echo base_url() . "ekskul/daftar_video"; ?>','_self');"
								class="btn-main">Video Saya
							</button>
						<?php }
						else
						{ ?>
							<button onclick="window.open('<?php echo base_url() . 'video/saya/calver'; ?>','_self');"
								class="btn-main">Video Saya
							</button>
						<?php } ?>
						
					</center>
				</div>
			</div>
		</section>
	</div>
	<?php require_once('layout/calljs.php'); ?>
	<?php
	
} else {
	?>
	<div class="no-bottom no-top" id="content">
		<div id="top"></div>
		<!-- section begin -->
		<section id="subheader" class="text-light"
				 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
			<div class="center-y relative text-center">
				<div class="container">
					<div class="row">

						<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
							<h1>Ekstrakurikuler</h1>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</section>
		<!-- section close -->


		<section aria-label="section" class="mt0 sm-mt-0">
			<div class="container">
				<div class="row">

					<center>
						<h3>INPUT PAKET PLAYLIST HARI <?php echo strtoupper(namahari_panjang($harike)); ?></h3></center>
					<br>
					<div style="margin-bottom: 10px;">
						<button onclick="window.location.href='<?php echo base_url(); ?>channel/playlistsekolah<?php echo $opsidashboard.$kodeevent;?>'"
								class="btn btn-main">Kembali
						</button>

						<button
							onclick="window.location.href='<?php echo base_url(); ?>channel/urutanplaylist_sekolah/<?php echo $kodepaket.$opsidashboard.$kodeevent; ?>'"
							class="btn btn-main">Urutan Jam Tayang
						</button>
					</div>

					<!--	<button style="margin-left:10px" id="btn-show-all-children" type="button">Buka Semua</button>-->
					<!--	<button style="margin-left:10px" id="btn-hide-all-children" type="button">Tutup Semua</button>-->
					<hr>

					<div style="margin-left:10px;margin-right:10px;">
						<table id="tabel_data" class="table table-striped table-bordered nowrap" cellspacing="0"
							   width="100%">
							<thead>
							<tr>
								<th style='padding:5px;width:5px;'>No</th>
								<th style='padding:5px;width:20%;'>Judul</th>
								<th>Durasi</th>
								<th>Pengunggah</th>
								<th>Masuk Playlist</th>
								<th class="none">Video</th>
								<th class="none">Topik</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>

	<div
		style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
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

		$(document).on('change', '#itahun', function () {
			get_analisis_view();
		});

		function get_analisis_view() {
			window.open("/rtf2/home/filter/" + $('#itahun').val() +
				"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
		}

		$(document).ready(function () {

			var data = [];

			<?php

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$nomor = 0;
			foreach ($dafvideo as $datane) {
			$nomor++;
			$id_video = $datane->idvideo;
			$kode_video = $datane->kode_video;
			$idjenis = $datane->id_jenis;
			$jenis = $txt_jenis[$datane->id_jenis];
			$id_jenjang = $datane->id_jenjang;
			$id_kelas = $datane->id_kelas;
			$id_mapel = $datane->id_mapel;
			$id_ki1 = $datane->id_ki1;
			$id_ki2 = $datane->id_ki2;
			$id_kd1_1 = $datane->id_kd1_1;
			$id_kd1_2 = $datane->id_kd1_2;
			$id_kd1_3 = $datane->id_kd1_3;
			$id_kd2_1 = $datane->id_kd2_1;
			$id_kd2_2 = $datane->id_kd2_2;
			$id_kd2_3 = $datane->id_kd2_3;
			$id_kategori = $datane->id_kategori;
			$uploader = $datane->first_name . " " . $datane->last_name;
			$topik = $datane->topik;
			$judul = $datane->judul;
			$durasi = $datane->durasi;
			$deskripsi = $datane->deskripsi;
			$keyword = $datane->keyword;
			$link = preg_replace('/\s+/', '', $datane->link_video);
			$namafile = $datane->file_video;
			$dilist = $datane->dilist;
			$sifat = $datane->sifat;
			if ($datane->idchannel != null)
				$idchannel = "Masuk";
			else
				$idchannel = "---";
			//	$namapaket = $datane->nama_paket;

			if ($dilist == 0)
				$warnane = '#b6e7e0';
			else
				$warnane = '#e6aaab';

			if ($idchannel == "Masuk")
				$warnane = '#b2cae6';


			$masukplaylist = "<button id='bt2_" . $id_video . "' style='background-color: " . $warnane .
				"' onclick='masukinlist(".$id_video.")' type='button'>" . $idchannel . "</button>";

			if ($link != "") {
				$youtube_url = $link;
				$id = youtube_id($youtube_url);

				$playit = "<button onclick='lihatvideo(`" . $id . "`)' id='thumbnail' data-video-id='STxbtyZmX_E'" .
					" type='button'>Play</button>";
			} else if ($namafile != "") {
				$nama_video = $namafile;
				$playit = "<button onclick='lihatvideo2(`" . $nama_video . "`)' type='button'>Play</button>";
			}
			?>


			data.push([<?php echo $nomor;?>, "<?php echo $judul;?>", "<?php echo $durasi;?>", "<?php echo $uploader;?>","<?php echo $masukplaylist;?>","<?php echo $playit;?>", "<?php echo $topik;?>"]);

			//data.push('1','Judul','sa','as',"as","as","ds","fd","hg","kj","s");
			<?php }
			?>

			$('#tabel_data').DataTable({
				data: data,
				deferRender: true,
				scrollCollapse: true,
				scroller: true,
				// pagingType: "simple",
				// language: {
				// 	paginate: {
				// 		previous: "<",
				// 		next: ">"
				// 	}
				// },
				'responsive': true,
				'columnDefs': [
					{
						render: function (data, type, full, meta) {
							return "<div class='text-wrap width-50'>" + data + "</div>";
						},
						targets: [1,2]
					},
					{responsivePriority: 1, targets: 0},
					{responsivePriority: 2, targets: 1},
					{responsivePriority: 10001, targets: 2},
					// {responsivePriority: 3, targets: -2},
					{
						width: 25,
						targets: 0
					}
				],
				"order": [[0, "asc"]]
			});
		});

		function lihatvideo(url) {
			// alert ("HI");
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
			// alert ("HI2");
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
				window.open('<?php echo base_url(); ?>video/hapus/' + idx);
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

		function masukinlist(idx) {
			statusnya = 0;
			if ($('#bt2_' + idx).html() == "---") {
				statusnya = 1;
			}

			$.ajax({
				url: "<?php echo base_url().'channel/masukinlist_sekolah/'.$opsi;?>",
				method: "POST",
				data: {id: idx, status: statusnya, kodepaket: "<?php echo $kodepaket;?>"},
				success: function (result) {
					console.log(result);

					if ($('#bt2_' + idx).html() == "---") {
						$('#bt2_' + idx).html("Masuk");
						$('#bt2_' + idx).css({"background-color": "#b2cae6"});
					} else {
						$('#bt2_' + idx).html("---");
						$('#bt2_' + idx).css({"background-color": "#b6e7e0"});
					}
				}
			})


		}

	</script>
	<?php
} ?>
