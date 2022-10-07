<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw

$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$do_not_duplicate = array();

$jml_channelku = 0;
$npsnku = "";
$kodeku = "";
$nama_sekolahku = "";

if ($this->session->userdata('loggedIn')) {
	foreach ($channelku as $datane) {
		$jml_channelku++;
		$npsnku = $datane->npsn;
		$kodeku = $datane->kode_sekolah;
		$nama_sekolahku = $datane->nama_sekolah;
	}
}

$jml_channel = 0;
foreach ($dafchannel as $datane) {
	$jml_channel++;
	$npsn[$jml_channel] = $datane->npsn;
	$kode[$jml_channel] = $datane->kode_sekolah;
	$nama_sekolah[$jml_channel] = $datane->nama_sekolah;
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

if ($jml_video >= 5)
	$jml_video = 5;


?>
<div style="float: right; margin-right: 20px" id="jam">
	<!--	--><?php
	//	$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
	//	$obj = json_decode(file_get_contents($url), true);
	//	$stampdate = $obj['datetime'];
	//	echo $stampdate.'<br>';
	//	$jamsaiki = substr($obj['datetime'], 11, 8);
	//	echo $jamsaiki." WIB";
	//	?>
</div>

<div id="jamsekarang" style="padding-top:65px;float: right; margin-right: 20px" id="jam">
</div>

<div style="color:#ffffff;margin-left:10px;margin-right:10px;background-color:white;">
	<div class="indukplay" style="padding-top:90px;text-align:center;margin-left:auto;margin-right: auto;">
		<div class="iframe-container embed-responsive embed-responsive-16by9">
			<div class="embed-responsive-item" style="width: 100%" id="isivideoyoutube"></div>
		</div>
		<br>
	</div>
</div>
<hr>
<div style="text-align: center">
	<span style="font-weight: bold;color: grey">Channel</span>
	<div class="regular slider" style="margin-top: 0px;">
		<?php if ($jml_channelku > 0) { ?>
			<div style="vertical-align: text-top; display: inline-block; padding-left: 10px;padding-right: 10px;">
				<a href="<?php echo base_url(); ?>channel/sekolah/<?php echo 'ch' . $npsnku; ?>" style="display: inline-block">
					<div class="avatar lebarikon"
						 style="text-align:center;background-image: url('<?php echo base_url(); ?>uploads/channel/thumb-3.jpg');">
					</div>
					<div class="lebarikon" style="text-align:center;">
						<span
							style="font-size:10px;font-weight: bold;color: grey"><?php echo $nama_sekolahku; ?></span>
					</div>

				</a>
			</div>
		<?php }

		for ($i = 1; $i <= $jml_channel - $jml_channelku; $i++) { ?>
			<div style="vertical-align: text-top; display: inline-block; padding-left: 10px;padding-right: 10px;">
				<a href="<?php echo base_url(); ?>channel/sekolah/<?php echo 'ch' . $npsn[$i]; ?>" style="display: inline-block">
					<div class="avatar lebarikon"
						 style="text-align:center;background-image: url('<?php echo base_url(); ?>uploads/channel/thumb-3.jpg');">
					</div>
					<div class="lebarikon" style="text-align:center;">
						<span
							style="font-size:10px;font-weight: bold;color: grey"><?php echo $nama_sekolah[$i]; ?></span>
					</div>

				</a>
			</div>
		<?php } ?>
	</div>

</div>

<hr>
<div style="text-align: center">
	<span style="font-weight: bold;color: grey">Terbaru</span>
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
			
			<div id="judulvideo">' . $judul[$a1] . '</div><br>
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
	var detikke = new Array();
	var idvideo = new Array();
	var durasike = new Array();
	var filler = new Array();
	var jatah = 0;
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Nop', 'Des');
	var detiklokal = 0;
	var tgl, bln, thn, jam, menit, detik, jmmndt;
	var cekjatah = 0;
	var detikselisih;

	<?php
	$stampdate = new DateTime();
	$stampdate->setTimezone(new DateTimezone('Asia/Jakarta'));
	$stampdate = $stampdate->format;
	echo "var tglnow = new Date('" . $stampdate . "');";
	?>

	var jamnow = tglnow.getTime();

	detikke[1] = "14:50:00";
	detikke[2] = "15:05:00";
	detikke[3] = "14:55:00";

	durasike[1] = "120";
	durasike[2] = "240";
	durasike[3] = "100";

	jamakhir = new Date("1970-01-01T" + detikke[3] + "Z").getTime();
	jamawal = new Date("1970-01-01T" + detikke[1] + "Z").getTime();
	durasi = jamakhir + parseInt(durasike[3])*1000 - jamawal;

	detikke[4] = new Date("1970-01-01T" + detikke[1] + "Z").getTime() + durasi;
	detikke[5] = new Date("1970-01-01T" + detikke[2] + "Z").getTime() + durasi;
	detikke[6] = new Date("1970-01-01T" + detikke[3] + "Z").getTime() + durasi;




	idvideo[1] = 'aTMQ9sxPeLc';
	idvideo[2] = 'ryQ1bGT_-6E';
	idvideo[3] = 'uaWodw-qCog';

	filler[1] = 'X7R-q9rsrtU';

	function onYouTubeIframeAPIReady() {
		player = new YT.Player('isivideoyoutube', {
			width: 600,
			height: 400,
			videoId: 'lEc1oydQDHo',
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
		updateTanggal();
		player.playVideo();
	}

	$(function () {
		setInterval(updateTanggal, 1000);
	});

	function updateTanggal() {
		jamnow = jamnow + 1000;
		tgl = new Date(jamnow).getDate();
		bln = new Date(jamnow).getMonth() + 1;
		thn = new Date(jamnow).getFullYear();
		jam = new Date(jamnow).getHours();
		if (jam < 10)
			jam = '0' + jam;
		menit = new Date(jamnow).getMinutes();
		if (menit < 10)
			menit = '0' + menit;
		detik = new Date(jamnow).getSeconds();
		if (detik < 10)
			detik = '0' + detik;
		jmmndt = jam + ':' + menit + ':' + detik;

		$('#jamsekarang').html(tgl + ' ' + namabulan[bln] + ' ' + thn + ', ' + jmmndt + ' WIB');

		updatePlaying();
	}


	function updatePlaying() {

		for (a = 1; a <= 3; a++) {
			jamjadwal = new Date("1970-01-01T" + detikke[a] + "Z").getTime();
			jamsaiki = new Date("1970-01-01T" + jmmndt + "Z").getTime();
			if (jamsaiki >= jamjadwal) {
				cekjatah = a;
				detikselisih = (jamsaiki - jamjadwal) / 1000;
			}
		}

		if (cekjatah != jatah) {
			jatah = cekjatah;

			//alert (detiklokal);
			detiklokal = detikselisih;

			if (detiklokal>durasike[jatah])
			{
				detiklokal = 0;
				player.loadVideoById(filler[1]);
			}
			else
			{
				player.loadVideoById(idvideo[jatah], detiklokal);
			}

			player.playVideo();
		}
		else {
			detiklokal = detiklokal + 1;
			videoPos = !player.getCurrentTime ? 0.0 : player.getCurrentTime();
			jarak = (videoPos - detiklokal);
			if (player.getPlayerState() != 2) {
				if (jarak > 5 || jarak < -5)
					player.seekTo(detiklokal);
				player.playVideo();
			}
		}
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


