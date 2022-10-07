<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw

$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$do_not_duplicate = array();
$npsnku = "";
$kodeku = "";
$nama_sekolahku = "";
$jml_list = 0;
$idliveduluan = 0;

foreach ($infoguru as $datane) {
	$npsnku = $datane->npsn;
	$idguru = $datane->id;
	$nama_sekolahku = $datane->sekolah;
	$namaku = $datane->first_name . ' ' . $datane->last_name;
}

$jmldaf_list = 0;
$statuspaket = 1;
$namapaket = "";

foreach ($dafplaylist as $datane) {
	$jmldaf_list++;

	$iddaflist[$jmldaf_list] = $datane->id_paket;
	$id_videodaflist[$jmldaf_list] = $datane->link_list;
	$nama_playlist[$jmldaf_list] = $datane->nama_paket;
	$status[$jmldaf_list] = $datane->status_paket;

	if ($datane->status_paket == 1) {
		$tlive[$jmldaf_list] = "Segera Tayang";
		$idliveduluan = $jmldaf_list;
	} else {
		$tlive[$jmldaf_list] = "";
	}

	$tgl_tayang1[$jmldaf_list] = $datane->tanggal_tayang;
	$tgl_tayang[$jmldaf_list] = substr($datane->tanggal_tayang, 8, 2) . ' ' . $namabulan[(int)(substr($datane->tanggal_tayang, 5, 2))] . ' ' . substr($datane->tanggal_tayang, 0, 4) . ' Pukul ' . substr($datane->tanggal_tayang, 11, 5) . ' WIB';
	$idvideoawal[$jmldaf_list] = $datane->judul;
	$durasidaf[$jmldaf_list] = $datane->durasi_paket;
	$thumbnail[$jmldaf_list] = $datane->thumbnail;
	// echo "GAMBARE:".$datane->deskripsi;
	// die();
	if (substr($thumbnail[$jmldaf_list], 0, 4) != "http") {
		$thumbnail[$jmldaf_list] = base_url() . "uploads/thumbs/" . $thumbnail[$jmldaf_list];
	}


	if ($id_playlist == $datane->link_list) {
		$statuspaket = $datane->status_paket;
		$namapaket = $datane->nama_paket;
		$thumbspaket = $thumbnail[$jmldaf_list];
		$tayangpaket = $tgl_tayang[$jmldaf_list];
	}


}


if ($punyalist) {
	$jml_list = 0;
	foreach ($playlist as $datane) {
		//echo "<br><br><br><br>".($datane->link_video);
		$jml_list++;
		$id_videolist[$jml_list] = $datane->link_video;
		$durasilist[$jml_list] = $datane->durasi;
		$urutanlist[$jml_list] = $datane->urutan;
	}
}

//echo "<br><br><br><br>".$statuspaket;
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
						<h1>Ekstrakurikuler Majalah Dinding</h1>
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
				<div style="margin-bottom: 10px;">
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>ekskul/daftar_video'" class=""
							style="">Daftar Video Saya
					</button>
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>ekskul/daftar_playlist'" class=""
							style="">Tambah Playlist
					</button>
				</div>

				<hr>

				<div class="bgimg3" style="text-align: center;width: 100%;">
					<h3>PLAYLIST SAYA</h3>
					<div class="rowvod" style="margin-bottom: 40px;">
						<?php
						for ($a1 = 1; $a1 <= $jmldaf_list; $a1++) {
							 {
								echo '<div class="columnvodbimbel">
			<a href="' . base_url() . 'ekskul/lihatplaylist/' . $id_videodaflist[$a1] . '">
			<div class="grup" style="width:100%;margin:auto;margin-top:30px;position:relative;text-align:center">
			 <div style="font-size:11px;background-color:black;color:white;position: absolute;right:28px;bottom:10px">'
									. $durasidaf[$a1] . '</div>
			<img class="thumbbimbel" src="' . $thumbnail[$a1] . '"><br>
			</div>
			<div style="text-align:center">
			<div class="judulvideo">' . $nama_playlist[$a1] . '</div>
			</div>
			</a>
			</div>';
							}
						}
						?>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>
