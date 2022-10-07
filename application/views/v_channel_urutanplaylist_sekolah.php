<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_contreng = Array('---', 'Masuk');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namasifat = Array('Publik', 'Modul', 'Bimbel', 'Playlist');
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

$jml_vid = 0;
$jamtayang[1] = $mulaijam;
foreach ($dafvideo as $datane) {
	$jml_vid++;
	$nomor[$jml_vid] = $jml_vid;
	$id_playlist[$jml_vid] = $datane->idchannel;
	$durasi = $datane->durasi;
	$durdetik = intval(substr($durasi,6,2));
	$durmenit = intval(substr($durasi,3,2));
	$durjam = intval(substr($durasi,0,2));
	$mulaidetik = intval(substr($jamtayang[$jml_vid],6,2));
	$mulaimenit = intval(substr($jamtayang[$jml_vid],3,2));
	$mulaijam = intval(substr($jamtayang[$jml_vid],0,2));
	$hasildetik = $mulaidetik + $durdetik;
	$simpanmenit = 0;
	if ($hasildetik>=60)
		{
			$hasildetik = $hasildetik - 60;
			$simpanmenit = 1;
		}
	$hasilmenit = $mulaimenit + $durmenit;
	$simpanjam = 0;
	if ($hasilmenit>=60)
	{
		$hasilmenit = $hasilmenit - 60;
		$simpanjam = 1;
	}
	$hasiljam = $mulaijam + $durjam;

	if ($hasiljam>=24)
	{
		$hasiljam = $hasiljam - 24;
	}

	if ($hasiljam+$simpanjam>=10)
		$sjam = $hasiljam+$simpanjam;
	else
		$sjam = "0".($hasiljam+$simpanjam);

	if ($hasilmenit+$simpanmenit>=10)
		$smenit = $hasilmenit+$simpanmenit;
	else
		$smenit = "0".($hasilmenit+$simpanmenit);

	if ($hasildetik>=10)
		$sdetik = $hasildetik;
	else
		$sdetik = "0".$hasildetik;


	$jamtayang[$jml_vid+1] = $sjam.":".$smenit.":".$sdetik;
//
//	echo "JAM:".$hasiljam." - SIMPANJAM:".$simpanjam."<br>";
//	echo "SJAM:".$sjam;

//	echo $jamtayang[$jml_vid+1];
//	die();
//	$id_video[$jml_video] = $datane->idvideo;
//	$kode_video[$jml_video] = $datane->kode_video;
//	$idjenis[$jml_video] = $datane->id_jenis;
//	$jenis[$jml_video] = $txt_jenis[$datane->id_jenis];
//	$id_jenjang[$jml_video] = $datane->id_jenjang;
//	$id_kelas[$jml_video] = $datane->id_kelas;
//	$id_mapel[$jml_video] = $datane->id_mapel;
//	$id_ki1[$jml_video] = $datane->id_ki1;
//	$id_ki2[$jml_video] = $datane->id_ki2;
//	$id_kd1_1[$jml_video] = $datane->id_kd1_1;
//	$id_kd1_2[$jml_video] = $datane->id_kd1_2;
//	$id_kd1_3[$jml_video] = $datane->id_kd1_3;
//	$id_kd2_1[$jml_video] = $datane->id_kd2_1;
//	$id_kd2_2[$jml_video] = $datane->id_kd2_2;
//	$id_kd2_3[$jml_video] = $datane->id_kd2_3;
//	$id_kategori[$jml_video] = $datane->id_kategori;
//	$topik[$jml_video] = $datane->topik;
//	$judul[$jml_video] = $datane->judul;
//	$durasi[$jml_video] = $datane->durasi;
//	$deskripsi[$jml_video] = $datane->deskripsi;
//	$keyword[$jml_video] = $datane->keyword;
//	$link[$jml_video] = $datane->link_video;
//	$namafile[$jml_video] = $datane->file_video;
//	$dilist[$jml_video] = $datane->dilist;
//	$sifat[$jml_video] = $datane->sifat;
//	$urutan[$jml_video] = $datane->urutan;

}

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
					<br>
					<center>
						<span style="font-size:16px;font-weight: bold;">ANDA BELUM MEMILIKI VIDEO DI DALAM PAKET PLAYLIST</span>
					</center>
					<br>
					<center>
						<button onclick="window.open('<?php echo base_url() . "channel/inputplaylist_sekolah/". $kodepaket;?>','_self');"
								class="btn-main">Input Paket Video Playlist
						</button>
					</center>
				</div>
			</div>
		</section>
	</div>
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
						<h3>URUTAN JAM TAYANG PLAYLIST HARI <?php echo strtoupper(namahari_panjang($harike)); ?></h3></center>
					<br>
					<div style="margin-bottom: 10px;">
						<button onclick="window.location.href='<?php echo base_url().'channel/playlistsekolah'.$opsidashboard.$kodeevent;?>'"
								class="btn btn-main">Kembali
						</button>

						<button
							onclick="window.location.href='<?php echo base_url(); ?>channel/inputplaylist_sekolah/<?php echo $kodepaket.$opsidashboard.$kodeevent; ?>'"
							class="btn btn-main">Input Paket Playlist
						</button>
					</div>

					<!--	<button style="margin-left:10px" id="btn-show-all-children" type="button">Buka Semua</button>-->
					<!--	<button style="margin-left:10px" id="btn-hide-all-children" type="button">Tutup Semua</button>-->
					<hr>

					<div style="margin-bottom: 10px;">
						<button type="button" onclick="updatedata()" class=""
								style="float:right;margin-right:10px;margin-top:-20px;">Update
						</button>
					</div>

					<div style="margin-left:10px;margin-right:10px;">
						<table id="tabel_data" class="table table-striped table-bordered nowrap" cellspacing="0"
							   width="100%">
							<thead>
							<tr>

								<th style='padding:5px;width:15px;'>No</th>
								<th>Judul</th>
								<th>Jam Tayang</th>
								<th>Durasi</th>
								<th style='padding:5px;width:15%;'>Urutan</th>
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

	<?php
}
?>

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
		$urutan = $datane->urutan;
		$iurutan = "<input style='text-align:center;' size='5px' maxlength='3' type='text'" .
			"name='iurut" . $nomor . "' id='iurut" . $nomor . "' value='" . $urutan . "'>";
		if ($link != "") {
			$youtube_url = $link;
			$id = youtube_id($youtube_url);

			$playit = "<button onclick='lihatvideo(\'" . $id . "\')' id='thumbnail' data-video-id='STxbtyZmX_E'" .
				" type='button'>Play</button>";
		} else if ($namafile != "") {
			$nama_video = $namafile;
			$playit = "<button onclick='lihatvideo2(\'" . $nama_video . "\')' type='button'>Play</button>";
		}
		?>


		data.push([<?php echo $nomor;?>,"<?php echo $judul;?>", "<?php echo $jamtayang[$nomor];?>","<?php echo $durasi;?>", "<?php echo $iurutan;?>", "<?php echo $playit;?>", "<?php echo $topik;?>"]);

		// data.push(['1', 'Judul', 'sa', 'as', "as", "as"]);
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
					targets: [2]
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

	function updatedata() {
		var urutbaru = new Array();
		var idvid = new Array();

		<?php
		for ($i = 0; $i < $jml_vid; $i++) {
			echo "urutbaru[" . $i . "]=$('#iurut" . ($i + 1) . "').val();";
			echo "idvid[" . $i . "]=" . $id_playlist[($i + 1)] . ";";
		}
		?>

		alert (urutbaru);
		alert (idvid);

		$.ajax({
			url: "<?php echo base_url();?>channel/updateurutan_sekolah",
			method: "POST",
			data: {id: idvid, urutan: urutbaru},
			success: function (result) {
				// location.reload();
			}
		})


	}

</script>
