<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$do_not_duplicate = array();

$jml_channelku = 0;
$npsnku = "";
$kodeku = "";
$nama_sekolahku = "";
$hitungdurasi = 0;
$idliveduluan = "";

$tgl_tayang = array("", "");
$tgl_tayang1 = array("", "");

if ($this->session->userdata('loggedIn')) {
	foreach ($channelku as $datane) {
		$jml_channelku++;
		$npsnku = $datane->npsn;
		//$kodeku = $datane->kode_sekolah;
		$nama_sekolahku = $datane->nama_sekolah;
		$logoskolah = $datane->logo;
		if ($logoskolah != "") {
			$logoku = "uploads/profil/" . $logoskolah;
		} else {
			$logoku = "assets/images/tutwuri.png";
		}
	}
}

$jmldaf_list = 0;

$jml_list = 0;
if ($punyalist) {
	foreach ($playlist as $datane) {
		//echo "<br><br><br><br>".($datane->id_youtube);
		$jml_list++;
		$id_videolist[$jml_list] = $datane->link_video;
		$durasilist[$jml_list] = $datane->durasi;
		$urutanlist[$jml_list] = $datane->urutan;
		$kodechannel[$jml_list] = $datane->kode_video;
		$namachannel[$jml_list] = $datane->channeltitle;
		$judulacara[$jml_list] = addslashes($datane->judul);
	}
}

$jml_channel = 0;
foreach ($dafchannel as $datane) {
	$jml_channel++;
	$npsn[$jml_channel] = $datane->npsn;
	//$kode[$jml_channel] = $datane->kode_sekolah;
	$nama_sekolah[$jml_channel] = $datane->nama_sekolah;
	$logo[$jml_channel] = $datane->logo;
	if ($logo[$jml_channel] != "") {
		$logo[$jml_channel] = "uploads/profil/" . $logo[$jml_channel];
	} else {
		$logo[$jml_channel] = "assets/images/tutwuri.png";
	}
}

$jmltotal = $jml_channel - $jml_channelku;
if ($this->session->userdata('a01'))
	$jmltotal = $jml_channel;

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

if ($punyalist) {
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


		$tgl_tayang1[$jmldaf_list] = $datane->jam_tayang;
		$tgl_tayang[$jmldaf_list] = substr($datane->jam_tayang, 0) . ' WIB';
		$idvideoawal[$jmldaf_list] = $datane->judul;
		$durasidaf[$jmldaf_list] = $datane->durasi_paket;
		$thumbnail[$jmldaf_list] = $datane->thumbnail;
		if (substr($thumbnail[$jmldaf_list], 0, 4) != "http") {
			$thumbnail[$jmldaf_list] = "<?php echo base_url(); ?>uploads/thumbs/" . $thumbnail[$jmldaf_list];
		}


		if ($id_playlist == $datane->link_list) {
			$statuspaket = $datane->status_paket;
			$namapaket = $datane->nama_paket;
			$thumbspaket = $thumbnail[$jmldaf_list];
			$tayangpaket = $tgl_tayang[$jmldaf_list];
		}

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
		$judulacara[$jml_list] = $datane->judul;
	}
} else {
	$namapaket = "";
}


?>
<div class="container bgimg3" style="margin-top: 0px;width: 100%;padding-bottom: 50px;">
	<div class="row">
		<div class="col-lg-12">
			<div id="jamsekarang" style="padding-top:65px;
            float: right; margin-right: 20px; font-weight: bold;color: black" id="jam">
			</div>
		</div>
	</div>

	<div class="col-lg-8 col-md-8"
		 style="background-color: transparent; font-weight: bold; font-size: 20px;
         position: relative ; top: 0px; text-align:center; color:black; margin-top:0px;">
		<?php
		echo "CHANNEL TV KAMPUS" . " - ";
		if ($id_playlist == null && $jmldaf_list > 0 && $idliveduluan != "")
			echo $nama_playlist[$idliveduluan]; else
			echo $namapaket; ?>
	</div>


	<div class="row">
		<div class="col-lg-8 col-md-8">
			<div class="row content-block">
				<!--                <div class="indukplay" style="padding-top:0px;text-align:center;margin-left:auto;margin-right: auto;">-->
				<?php
				if ($jmldaf_list > 0) {
					?>
					<div id="layartancap" style="display:none" <?php
					if ($status[1] == 2 && $id_playlist == null)
						//JIKA GAK ADA YANG MAU TAYANG
						echo 'style="display:none";' ?>
						 class="iframe-container embed-responsive embed-responsive-16by9">
						<div class="embed-responsive-item" style="display:none;width: 100%" id="isivideoyoutube">
							<?php
							if ($statuspaket == 1) {
								?>
								<img style="width: 100%" src="<?php
								if ($id_playlist == null)
									echo $thumbnail[$idliveduluan]; else
									echo $thumbspaket; ?>"/>
							<?php } ?>
						</div>
					</div>
					<div id="layartancap2" style="display:block">
						<img style="width: 100%" src="<?php echo base_url(); ?>assets/images/pm5644.jpg">
					</div>
				<?php } else {
					?>
					<img style="width: 100%" src="<?php echo base_url(); ?>assets/images/playlistbelum2.png"/>
				<?php }
				?>
				<!--                </div>-->
			</div>
		</div>
		<div class="col-lg-4 col-md-4" style="background-color: #f6f6f6;padding-bottom: 30px;">
			<div class="row content-block">
				<div class="col-lg-12">
					<div style="text-align: center;font-weight: bold;font-size:16px;color:#000">
						JADWAL ACARA HARI INI
					</div>
					<div id="tempatJadwal" style="font-weight: bold;color:#000;height: 400px;overflow: auto;">

						// for ($a = 1; $a <= $jml_list; $a++) {
						// echo "<br>" . $judulacara[$a];
						// }


					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="keteranganLive" style="text-align:center; color:black">
	<?php

	if ($jmldaf_list > 0) {
		if ($statuspaket == 1) {
			?>
			<!--SEGERA TAYANG TANGGAL: <?php echo $tgl_tayang[1]; ?>-->
		<?php }
	} ?>
</div>


<div style="text-align: center;background-color:#8cbdac;padding-top: 20px;padding-bottom: 20px">
	<span style="font-weight: bold;font-size: 18px;color:black;padding-bottom: 10px;">CHANNEL TV PRODI</span>
	<div class="regular slider" style="margin-top: 20px;">
		<?php if ($jml_channelku && !$this->session->userdata('a01')) { ?>
			<div style="vertical-align: text-top; display: inline-block; padding-left: 0px;padding-right: 0px;">
				<a href="<?php echo base_url(); ?>channel/sekolah/<?php echo 'ch' . $npsnku; ?>"
				   style="display: inline-block">
					<div class="avatar lebarikon"
						 style="text-align:center;background-image: url('<?php echo base_url() . $logoku ?>');">
					</div>
					<div class="lebarikon" style="text-align:center;">
						<span
							style="font-weight: bold;color: black"><?php echo $nama_sekolahku; ?></span>
					</div>

				</a>
			</div>
		<?php }

		for ($i = 1; $i <= $jmltotal; $i++) { ?>
			<div style="vertical-align: text-top; display: inline-block; padding-left: 0px;padding-right: 0px;">
				<a href="<?php echo base_url(); ?>channel/sekolah/<?php echo 'ch' . $npsn[$i]; ?>"
				   style="display: inline-block">
					<div class="avatar lebarikon"
						 style="text-align:center;background-image: url('<?php echo base_url() . $logo[$i] ?>');">
					</div>
					<div class="lebarikon" style="text-align:center;">
						<span style="font-weight: bold;color: black"><?php echo $nama_sekolah[$i]; ?></span>
					</div>

				</a>
			</div>
		<?php } ?>
	</div>


	<div style="margin-top:20px;font-weight: bold;color: #e8df55">
		<button class="myButtongreen" onclick="window.open('<?php
		echo base_url(); ?>channel/sekolah/','_self')">LIHAT SEMUA CHANNEL
		</button>
	</div>

</div>


<div class="bgimg2" style="text-align: center;padding-top: 30px;">
	<span style="font-weight: bold;color: grey;font-size:18px;color:black">KONTEN TERBARU</span>
	<div class="rowvod" style="margin-top: -10px;">
		<?php for ($a1 = 1; $a1 <= $jml_video; $a1++) {
			echo '<div class="columnvod" style="height: 150px;">
		<a href="' . base_url() . 'watch/play/' . $id_video[$a1] . '"> 
			 <div class="grup" style="margin:auto;width:220px;position:relative;text-align:center">
			 <div style="font-size:11px;background-color:black;color:white;position: absolute;right:10px;bottom:10px">'
				. $durasi[$a1] . '</div>
			
			<img style="align:middle;width:220px;height:130px" src="' . $thumbs[$a1] . '"><br>
			</div>
			<div class="grup" style="text-align:center">
			
			<div style="color:black;font-weight:bold;" id="judulvideo">' . $judul[$a1] . '</div>
			</div>
	
			  
			</div></a>';
		}
		?>
	</div>
</div>


</div>

<?php if ($punyalist)
	$hitungdurasi = substr($durasidaf[1], 0, 2) * 3600 + substr($durasidaf[1], 3, 2) * 60 + substr($durasidaf[1], 6, 2);
?>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->

<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>

<script>
	$(document).on('ready', function () {
		$(".regular").slick({
			dots: true,
			infinite: true,
			arrows: false,
			slidesToShow: 5,
			slidesToScroll: 5
		});
	});

	<?php

	$now = new DateTime();
	$now->setTimezone(new DateTimezone('Asia/Jakarta'));
	$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");

	echo "var tglnow = new Date('" . $stampdate . "');";

	?>

	var jamnow = tglnow.getTime();
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');


	setInterval(updateJam, 1000);

	function updateJam() {
		jamnow = jamnow + 1000;
		tgl = new Date(jamnow).getDate();
		bln = new Date(jamnow).getMonth();
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
		//console.log((tgl + ' ' + namabulan[bln] + ' ' + thn + ', ' + jmmndt + ' WIB'));
	}

</script>

<script>

	var player;
	var detikke = new Array();
	var idvideo = new Array();
	var durasike = new Array();
	var totaldurasi = new Array();
	var durasidetik = new Array();
	var judulacara = new Array();
	var tgl, bln, thn, jam, menit, detik, jmmndt;

	var jammulaitayang =<?php echo substr($tgl_tayang[1], 0, 2);?>;
	var jumlahjudul = <?php echo $jml_list;?>;
	var posisijudul = 1;
	var jambulatawal = 0;
	var sisadetikawal = 0;
	var detiklokal;
	var gabung = "";
	var jamnow = tglnow.getTime();
	var now = new Date();
	var durasipaket = <?php echo $hitungdurasi; ?>;
	var jambulat = Math.ceil(durasipaket / 3600);
	var jamawal = <?php echo substr($stampdate, 11, 2);?>;
	var menitawal = <?php echo substr($stampdate, 14, 2);?>;
	var detikawal = <?php echo substr($stampdate, 17, 2);?>;
	var totaldetikawal = jamawal * 3600 + menitawal * 60 + detikawal;
	if (jamawal >= jammulaitayang) {
		jambulatawal = parseInt(jamawal / jambulat) * jambulat + (jammulaitayang % jambulat);
	} else {
		jambulatawal = jammulaitayang;
	}
	sisadetikawal = totaldetikawal - jambulatawal * 3600;

	//alert(sisadetikawal);

	if (sisadetikawal > durasipaket) {
		// console.log("IKLAN DULU BELUM MULAI");
		// jambulatawal = parseInt(jamawal / jambulat) * jambulat + (jammulaitayang%jambulat);
	}

	if (sisadetikawal > 0 && sisadetikawal<durasipaket) {
		$('#layartancap').show();
		$('#layartancap2').hide();
	}

	//console.log("Tayang tiap : " + jambulat + " jam sekali");
	//console.log("Total durasi (detik) : " + durasipaket);
	//console.log("Jam sekarang (detik) : " + sisadetikawal);

	totaldurasi[0] = 0;

	<?php
	$totaldurasi = 0;
	for ($q = 1; $q <= $jml_list; $q++) {
		echo "idvideo[" . $q . "] = youtube_parser('" . $id_videolist[$q] . "'); \r\n";
		echo "durasike[" . $q . "] = '" . $durasilist[$q] . "'; \r\n";
		$durasidetik = ((int)substr($durasilist[$q], 0, 2)) * 3600 +
			((int)substr($durasilist[$q], 3, 2)) * 60 +
			(int)substr($durasilist[$q], 6, 2);
		$totaldurasi = $totaldurasi + $durasidetik;
		echo "durasidetik[" . $q . "] = " . $durasidetik . "; \r\n";
		echo "totaldurasi[" . $q . "] = " . $totaldurasi . "; \r\n";
		echo "judulacara[" . $q . "] = '" . $judulacara[$q] . "'; \r\n";
	};
	?>

	gabung = '<table border="0"><col width="80">';
	for (var q = 1; q <= <?php echo $jml_list;?>; q++) {
		if (q == 1) {
			jambulatawalcek = jambulatawal;
			if (sisadetikawal > durasipaket)
				jambulatawalcek = jambulatawalcek + jambulat;
			if (jambulatawalcek < 10)
				strjambulatawal = "0" + jambulatawalcek;
			else
				strjambulatawal = jambulatawalcek;

			detikke[q] = strjambulatawal + ':00:00';
		} else {

			if (sisadetikawal > totaldurasi[q - 1])
				posisijudul = q;

			totaldetik = jambulatawal * 3600 + totaldurasi[q - 1];
			jamhitung = parseInt(totaldetik / 3600);
			sisamenit = totaldetik - jamhitung * 3600;
			menithitung = parseInt(sisamenit / 60);
			stringmenit = String(menithitung)
			detikhitung = sisamenit - menithitung * 60;

			if (sisadetikawal > durasipaket)
				jamhitung = jamhitung + jambulat;
			stringjam = String(jamhitung)
			if (jamhitung < 10)
				stringjam = "0" + stringjam;
			if (jamhitung >= 24)
				break;
			if (menithitung < 10)
				stringmenit = "0" + stringmenit;
			detikke[q] = stringjam + ':' + stringmenit + ':' + detikhitung;
		}
		// console.log('Id ke ' + q + ' = ' + idvideo[q]);
		// console.log('Durasi ke ' + q + ' = ' + durasike[q]);
		// console.log('Total durasi ke ' + q + ' = ' + totaldurasi[q]);
		// console.log('Tayang jam ' + q + ' = ' + detikke[q]);

		gabung = gabung + '<tr><td valign="top">' + detikke[q].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[q] + '</td></tr>';
	}

	gabung = gabung + '</table>';
	// console.log('Posisi judul akhir = ' + posisijudul);
	// console.log('Durasi detik ' + posisijudul + " = " + durasidetik[posisijudul]);
	// console.log("Playing judul acara:" + judulacara[posisijudul] + ", detik ke " + (sisadetikawal-totaldurasi[posisijudul-1]));

	jamnow = jamnow + 1000;


	$('#tempatJadwal').html(gabung);


	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	function onYouTubeIframeAPIReady() {
		// $('#layartancap').show();
		// $('#layartancap2').hide();
		loadplayer();
	}

	function loadplayer() {

		player = new YT.Player('isivideoyoutube', {
			width: 600,
			height: 400,
			videoId: idvideo[posisijudul],
			host: 'http://www.youtube.com',
			showinfo: 0,
			controls: 0,
			autoplay: 0,
			playerVars: {
				color: 'white',
				origin: 'https://www.tvsekolah.id'
			},
			events: {
				'onReady': initialize,
				'onStateChange': panggilsaya
			}
		});

	}


	function initialize() {

		detiklokal = 2;
		sisadetikawal = totaldetikawal - jambulatawal * 3600;
		detikplayer = sisadetikawal - totaldurasi[posisijudul - 1];
		if (sisadetikawal >= 0) {
			document.getElementById('isivideoyoutube').style.display = "block";
			player.loadVideoById(idvideo[posisijudul], detikplayer);
			player.playVideo();
		}
		//player.seekTo(detikplayer);
		//if (player.getPlayerState()==5)
		//panggilsaya;
		//player.playVideo();
//		alert(player.getPlayerState());
		//player.playVideo();
		$(function () {
			setInterval(ceklive, 1000);
		});
		//ceklive();
	}

	function panggilsaya() {
		if (player.getPlayerState() == 3 || player.getPlayerState() == 2) {
			sisadetikawal = detiklokal + (totaldetikawal - jambulatawal * 3600);
			detikplayer = sisadetikawal - totaldurasi[posisijudul - 1];
			player.seekTo(detikplayer);
			player.playVideo();
		}
		// console.log(player.getPlayerState());
	}

	function ceklive() {
		detiklokal++;
		sisadetikawal = detiklokal + (totaldetikawal - jambulatawal * 3600);
		detikplayer = sisadetikawal - totaldurasi[posisijudul - 1];

		//console.log("Jam detik sekarang:"+sisadetikawal);
		//console.log("Detik lokal:"+detiklokal);
		//console.log(detikke[1]);
		//console.log(jmmndt);

		var timeJadwal = detikke[1];
		var datetimeJadwal = new Date('1970-01-01T' + timeJadwal + 'Z');
		var timeSaiki = jmmndt;
		var datetimeSaiki = new Date('1970-01-01T' + timeSaiki + 'Z');

		if (sisadetikawal >= jambulat * 3600) {
			console.log("BARU LAGI");
			// detiklokal = 0;
			posisijudul = 0;
			jambulatawal = jambulatawal + jambulat;
			// jamawal = jam;
			// menitawal = menit;
			// detikawal = detik;
			sisadetikawal = 0;

		}


		if (sisadetikawal >= totaldurasi[posisijudul]) {
			posisijudul++;
			if (posisijudul > jumlahjudul) {
				console.log("Playing iklan:");
				$('#layartancap').hide();
				$('#layartancap2').show();
				player.stopVideo();

			} else {
				console.log("Playing judul acara:" + judulacara[posisijudul]);
					$('#layartancap').show();
					$('#layartancap2').hide();
					player.loadVideoById(idvideo[posisijudul], detikplayer);
					player.playVideo();
			}

		}


		if (sisadetikawal < 0) {
			console.log("Playing iklan:");
			$('#layartancap').hide();
			$('#layartancap2').show();
		}

		if (detikplayer == 0) {
			$('#layartancap').show();
			$('#layartancap2').hide();
			document.getElementById('isivideoyoutube').style.display = "block";
			//console.log("Play judul acara:" + judulacara[posisijudul]);
			player.loadVideoById(idvideo[posisijudul], detikplayer);
			player.playVideo();

		}

		if (timeSaiki >= timeJadwal) {
			//console.log("MULAI");
			$('#layartancap').show();
			$('#layartancap2').hide();
		}
		else
		{
			//console.log("BELUM");
			$('#layartancap2').show();
			$('#layartancap').hide();
		}
		// console.log("Posisi jud:"+posisijudul);
		// console.log("Detik player:"+detikplayer);

	}

	function startTimer() {

	}

</script>
