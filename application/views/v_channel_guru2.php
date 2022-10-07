<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw

$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$do_not_duplicate = array();

$jml_channelku = 0;
$npsnku = "";
$kodeku = "";
$nama_sekolahku = "";

foreach ($infoguru as $datane) {
	$sekolah = $datane->sekolah;
	$npsn = $datane->npsn;
	$nama = $datane->first_name.' '.$datane->last_name;
}

$jml_video = 0;
foreach ($dafvideo as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video++;
		$nomor[$jml_video] = $jml_video;
		$id_video[$jml_video] = $datane->kode_video;
		$idjenis[$jml_video] = $datane->id_jenis;
		$jenis[$jml_video] = $txt_jenis[$datane->id_jenis];
		$id_jenjang[$jml_video] = $datane->id_jenjang;
		$id_kelas[$jml_video] = $datane->id_kelas;
		$id_mapel[$jml_video] = $datane->id_mapel;
		$id_ki1[$jml_video] = $datane->id_ki1;
		$id_ki2[$jml_video] = $datane->id_ki2;
		$id_kd1_1[$jml_video] = $datane->id_kd1_1;
		$id_kd1_2[$jml_video] = $datane->id_kd1_2;
		$id_kd1_3[$jml_video] = $datane->id_kd1_3;
		$id_kd2_1[$jml_video] = $datane->id_kd2_1;
		$id_kd2_2[$jml_video] = $datane->id_kd2_2;
		$id_kd2_3[$jml_video] = $datane->id_kd2_3;
		$id_kategori[$jml_video] = $datane->id_kategori;
		$topik[$jml_video] = $datane->topik;
		$judul[$jml_video] = $datane->judul;
		$deskripsi[$jml_video] = $datane->deskripsi;
		$keyword[$jml_video] = $datane->keyword;
		$link[$jml_video] = $datane->link_video;
		$filevideo[$jml_video] = $datane->file_video;

		$durasi[$jml_video] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi[$jml_video] = substr($datane->durasi, 3, 5);

		$thumbs[$jml_video] = $datane->thumbnail;
		if (substr($thumbs[$jml_video], 0, 4) != "http")
			$thumbs[$jml_video] = "<?php echo base_url(); ?>uploads/thumbs/" . $thumbs[$jml_video];

		// if ($link[$jml_video]!="")
		// 	$thumbs[$jml_video]=substr($link[$jml_video],-11).'.';
		// else if ($filevideo[$jml_video]!="")
		// 	$thumbs[$jml_video]=substr($filevideo[$jml_video],0,strlen($filevideo[$jml_video])-3);
		$status_verifikasi[$jml_video] = $datane->status_verifikasi;
		$modified[$jml_video] = $datane->modified;
		//echo $datane->link_video;
		$pengirim[$jml_video] = $datane->first_name;
		// $verifikator1[$jml_video] = '';
		// $verifikator2[$jml_video] = '';
		// $siaptayang[$jml_video] = '';

		$catatan1[$jml_video] = $datane->catatan1;
		$catatan2[$jml_video] = $datane->catatan2;
	}
}

?>



<hr>
<div style="text-align: center; margin-top: 60px;">
	<span style="font-weight: bold;color: grey">Daftar Video</span>
	<div><?php echo $nama. ' '.'<a href="<?php echo base_url(); ?>channel/sekolah/ch'.$npsn.'">'.$sekolah.'</a>';?></div>
	<div class="rowvod">
		<?php for ($a1 = 1; $a1 <= $jml_video; $a1++) {
			echo '<div class="columnvod">
			
		<a href="<?php echo base_url(); ?>watch/play/' . $id_video[$a1] . '"> 
			 <div class="grup" style="margin:auto;width:175px;position:relative;text-align:center">
			 <div style="font-size:11px;background-color:black;color:white;position: absolute;right:10px;bottom:10px">'
				. $durasi[$a1] . '</div>
			
			<img style="align:middle;width:175px;height:112px" src="' . $thumbs[$a1] . '"><br>
			</div>
			<div class="grup" style="text-align:center">
			
			<span style="font-weight:bold;color:black;">' . $judul[$a1] . '</span><br>
			<br>
			</div>
	
			  
			</div></a>';
		}
		?>
	</div>
</div>


</div>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->

<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>

<script>
	var player;

	function onYouTubeIframeAPIReady() {
		player = new YT.Player('isivideoyoutube', {
			width: 600,
			height: 400,
			videoId: 'aTMQ9sxPeLc',
			showinfo: 0,
			controls: 0,
			autoplay: 1,
			playerVars: {
				color: 'white',
				playlist: ''
			},
			events: {
				onReady: initialize
			}
		});
	}

	function initialize() {
		player.playVideo();
	}

	$(function () {
		setInterval(updatePlaying, 1000);
	});

	var detikke = 0;

	function updatePlaying() {
		detikke = detikke + 1;
		jarak = (player.getCurrentTime() - detikke);
		if (jarak > 5 || jarak < -5)
			player.seekTo(detikke);
		player.playVideo();
	}


	$(document).on('ready', function () {
		$(".regular").slick({
			dots: true,
			infinite: true,
			slidesToShow: 5,
			slidesToScroll: 5
		});
	});
</script>
