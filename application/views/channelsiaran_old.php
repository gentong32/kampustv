<?php
$durasidaf = Array("", "");
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$namaharis = Array('', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU');
$do_not_duplicate = array();
$npsnku = "";
$kodeku = "";
$jml_list = 0;
$idliveduluan = "";
$tgl_tayang = array("", "");
$tgl_tayang1 = array("", "");


foreach ($infosekolah as $datane) {
	$npsnku = $datane->npsn;
	$nama_sekolahku = $datane->nama_sekolah;
}

$jmldaf_list = 0;
$statuspaket = 1;
$namapaket = "";
$namahari = "belum dibuat";

foreach ($dafplaylist as $datane) {
//    echo "<br><br><br><br><br>Paket. ".$jmldaf_list.":".$datane->nama_paket;
//    die();

	$jmldaf_list++;

	$iddaflist[$jmldaf_list] = $datane->id_paket;
	$id_videodaflist[$jmldaf_list] = $datane->link_list;
	$nama_playlist[$jmldaf_list] = $datane->nama_paket;

	$status[$jmldaf_list] = $datane->status_paket;
	$namahari = $namaharis[$datane->hari];

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

$durasisponsor = 0;

if ($punyalist) {
	$jml_list = 0;
	if ($url_sponsor != "") {
		$jml_list++;
		$id_videolist[$jml_list] = $url_sponsor;
		$durasilist[$jml_list] = $durasi_sponsor;
		$durasisponsor = substr($durasi_sponsor, 0, 2) * 3600 + substr($durasi_sponsor, 3, 2) * 60 + substr($durasi_sponsor, 6, 2);
		$urutanlist[$jml_list] = 1;
		$kodechannel[$jml_list] = "";
		$namachannel[$jml_list] = "";
		$judulacara[$jml_list] = "";
	}
	foreach ($playlist as $datane) {
		//echo "<br><br><br><br>".($datane->link_video);
		$jml_list++;
		$id_videolist[$jml_list] = $datane->link_video;
		$durasilist[$jml_list] = $datane->durasi;
		$urutanlist[$jml_list] = $datane->urutan;
		$kodechannel[$jml_list] = $datane->kode_video;
		$namachannel[$jml_list] = $datane->channeltitle;
		$judulacara[$jml_list] = addslashes($datane->judul);
	}
} else {
	$namapaket = "";
}

$jml_channel = 0;


foreach ($dafchannelguru as $datane) {
	$jml_channel++;
	$id_user[$jml_channel] = $datane->id_user;
	$first_name[$jml_channel] = $datane->first_name;
	$last_name[$jml_channel] = $datane->last_name;
	if ($datane->picture == null)
		$foto_guru[$jml_channel] = base_url() . 'assets/images/profil_blank.jpg';
	else if (substr($datane->picture, 0, 4) == 'http')
		$foto_guru[$jml_channel] = $datane->picture;
	else
		$foto_guru[$jml_channel] = base_url() . 'uploads/profil/' . $datane->picture;
}

?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>

	<!-- section begin -->
	<section id="subheader" class="text-light" data-bgimage="url(<?php echo base_url();?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>MCR SIARAN TV KAMPUS</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section" class="pt30">
    <div class="row">
		<div style="margin-left:20px;">
		<button class="btn-main"
				onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
		</button>
		</div>
		<hr>
        <div class="col-md-6 col-lg-6">
			<div style="margin-left:20px;border:1px solid black">
				<div style="text-align: center;font-weight: bold;font-size:16px;color:#000">
				SIARAN TERJADWAL HARI INI [<?php echo $namahari; ?>]
				</div>
				<div id="tempatJadwal" style="margin-left:30px;font-size:15px;font-weight: normal;color:#000;height: 250px;overflow: auto;">

				</div>
			</div>
        </div>

		<div class="col-md-6 col-lg-6">
			<div style="margin-right:20px;border:1px solid black">
				<div style="text-align: center;font-weight: bold;font-size:16px;color:#000">
				SIARAN LIVE HARI INI
				</div>
				<center>
				<div style="padding-top:30px;font-size:15px;font-weight: normal;color:#000;height: 250px;">
					<input type="text" size="50" id="urllive" name="urllive" placeholder="Ketik URL disini" value="<?php echo $urllive;?>"/>
					<br><br>
					<button onclick="return updateurl();" style="display:none" id="tbupdate" name="tbupdate" class="btn-main">Update</button>
				</div>
				<div>
					
				</div>
				</center>
			</div>
        </div>
    </div>

	<div style="margin:25px">
	<center>
		<a href="">
		<img onclick="return gantisiaran();" src="<?php echo $tombolpilihansiaran;?>" width="200px">
		</a>
	</center>
	</div>

	<div class="row">
		<div style="margin: auto;max-width: 600px;">
            <div
				style="background-color: transparent; font-weight: bold;font-size:16px;
					position: relative ; top: 0px; text-align:center; color:black; margin-top:0px;">
			<?php
					if (isset($nama_sekolahku))
						echo "CHANNEL " . $nama_sekolahku;
					if ($url_sponsor != "")
						echo "<br>CHANNEL INI DISPONSORI OLEH " . strtoupper($sponsor);
					else if ($sponsor != "")
						echo "<br>CHANNEL INI TERSELENGGARA ATAS KERJASAMA DENGAN " . strtoupper($sponsor);
					?>
			</div>

			<div>
				<?php
					if ($jmldaf_list > 0) {
						?>
				<div id="layartancap" style="display:none; text-align: center; margin: auto;">
					<div
						style="max-width: 100%; max-height: 100%;margin: auto;"
						id="isivideoyoutube">
						<?php
								if ($statuspaket == 1) {
									?>
						<img
							style="width: 100%"
							src="<?php
									if ($id_playlist == null)
										echo $thumbnail[$idliveduluan]; else
										echo $thumbspaket; ?>"/>
						<?php } ?>
					</div>
				</div>

				<div id="layartancap2" style="display:<?php if($siaranaktif==1) 
				echo 'block'; else 
				echo 'none';?>">
					<img
						style="width: 100%"
						src="<?php echo base_url(); ?>assets/images/pm5644.jpg">
				</div>

				<div id="layartancap3" style="display:display:<?php if($siaranaktif==2) 
				echo 'block'; else 
				echo 'none';?>">
					<div
						style="max-width: 100%; max-height: 100%;margin: auto;"
						id="isivideoyoutube2">
					</div>
				</div>

				<?php } else {
						?>
				<img
					style="width: 100%"
					src="<?php echo base_url(); ?>assets/images/playlistbelum2.png"/>
				<?php }
					?>

            </div>

        	<?php if ($punyalist)
					$hitungdurasi = substr($durasidaf[1], 0, 2) * 3600 + substr($durasidaf[1], 3, 2) * 60 + substr($durasidaf[1], 6, 2);
				else
					$hitungdurasi = 0;

				$hitungdurasi = $hitungdurasi + 15 + $durasisponsor;
			?>

		</div>
	</div>

    </section>
</div>
<!-- content close -->

<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>

<script>
	var player;
	var detikke = new Array();
	var idvideo = new Array();
	var durasike = new Array();
	var totaldurasi = new Array();
	var durasidetik = new Array();
	var judulacara = new Array();
	var tgl, bln, thn, jam, menit, detik, jmmndt;
	var totalseluruhdurasi = 0;
	var siaranaktif = <?php echo $siaranaktif;?>;

	var jammulaitayang =<?php echo substr($tgl_tayang[1], 0, 2);?>;
	var jumlahjudul = <?php echo $jml_list;?>;
	var posisijudul = 1;
	var jambulatawal = 0;
	var sisadetikawal = 0;
	var detiklokal;
	var gabung = "";
	var tglnow;
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

	<?php
	$now = new DateTime();
	$now->setTimezone(new DateTimezone('Asia/Jakarta'));
	$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
	echo "tglnow = new Date('" . $stampdate . "');";
	?>

	var jamnow = tglnow.getTime();
	var now = new Date();
	var durasipaket = <?php echo $hitungdurasi; ?>;
	var jambulat = Math.ceil(durasipaket / 3600);
	var jamawal = <?php echo substr($stampdate, 11, 2);?>;
	var menitawal = <?php echo substr($stampdate, 14, 2);?>;
	var detikawal = <?php echo substr($stampdate, 17, 2);?>;
	var totaldetikawal = jamawal * 3600 + menitawal * 60 + detikawal;
	var yutubredi = false;
	var jambaru;
	var menitbaru;
	var detikbaru;
	var xJam;
	var yJam;

	$(document).on('ready', function () {
		$(".regular").slick({
			dots: true,
			infinite: true,
			arrows: false,
			slidesToShow: 5,
			slidesToScroll: 5
		});
	});

	//var jamnow = tglnow.getTime();

	$.get("<?php echo base_url() . 'channel/realdate';?>", function (Jam) {
		yJam = Jam;
	});

	setInterval(updateJam, 1000);

	function updateJam() {
		$.get("<?php echo base_url() . 'channel/realdate';?>", function (Jam) {
			yJam = Jam;
		});
		jamnow = Date.parse(yJam);
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


		//////////////////////////////////////////////

		jambaru = yJam.substring(11, 13);
		menitbaru = yJam.substring(14, 16);
		detikbaru = yJam.substring(17, 19);
		// console.log("JAM BARU:"+jambaru);
		// console.log("MENIT BARU:"+menitbaru);
		// console.log("DETIK BARU:"+detikbaru);
		jamjadwal = detikke[1].substring(0, 2);
		console.log("Jam jadwal:" + jamjadwal);
		durasijam = parseInt(jambaru) * 3600 + parseInt(menitbaru) * 60 + parseInt(detikbaru);
		durasijadwal = parseInt(jamjadwal) * 3600;
		if (durasijam - durasijadwal >= totalseluruhdurasi) {
			initbaru();
		} else {
			sisatayang = totalseluruhdurasi - (durasijam - durasijadwal);
			if (sisatayang >= 0 && sisatayang <= totalseluruhdurasi) {
				if (sisatayang == totalseluruhdurasi) {
					//console.log("Sedang tayang:" + (sisatayang));
					if (siaranaktif==1){
						$('#layartancap').show();
						$('#layartancap2').hide();
						$('#layartancap3').hide();
						player.loadVideoById(idvideo[posisijudul], detikplayer);
						player.playVideo();
					}
					else
					{
						$('#layartancap').hide();
						$('#layartancap2').hide();
						$('#layartancap3').show();
					}
					// console.log("Playing judul acara:" + judulacara[posisijudul]);
					
				}
			}

			// else
			// 	console.log("kosong:"+(sisatayang));
		}


		//console.log((tgl + ' ' + namabulan[bln] + ' ' + thn + ', ' + jmmndt + ' WIB'));
	}

	function initbaru() {
		jambulatawal = parseInt(detikke[1].substring(0, 2)) + jambulat;
		gabung = '<table border="0"><col width="80">';
		for (var q = 1; q <= <?php echo $jml_list;?>; q++) {
			if (q == 1) {
				jambulatawalcek = jambulatawal;
				if (jambulatawalcek < 10)
					strjambulatawal = "0" + jambulatawalcek;
				else
					strjambulatawal = jambulatawalcek;
				detikke[q] = strjambulatawal + ':00:00';
			} else {

				posisijudul = 1;
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
			console.log('Tayang jam 1 = ' + detikke[1]);
			<?php if ($url_sponsor != ""){?>
			if (q > 1) {
				if (q == 2) {
					gabung = gabung + '<tr><td valign="top">' + detikke[1].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[2] + '</td></tr>';
				} else {
					gabung = gabung + '<tr><td valign="top">' + detikke[q].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[q] + '</td></tr>';
				}

			}
			<?php } else {?>
			gabung = gabung + '<tr><td valign="top">' + detikke[q].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[q] + '</td></tr>';
			<?php } ?>
		}

		gabung = gabung + '</table>';

		$('#tempatJadwal').html(gabung);
	}

</script>

<script>
	if (jamawal >= jammulaitayang) {
		jambulatawal = parseInt(jamawal / jambulat) * jambulat + (jammulaitayang % jambulat);
	} else {
		jambulatawal = jammulaitayang;
	}
	sisadetikawal = totaldetikawal - jambulatawal * 3600;

	if (sisadetikawal > durasipaket) {
		//alert ("IKLAN DULU BELUM MULAI");
		// jambulatawal = parseInt(jamawal / jambulat) * jambulat + (jammulaitayang%jambulat);
	}

	// if (sisadetikawal>0)
	// {
	// 	$('#layartancap').show();
	// 	$('#layartancap2').hide();
	// }

	if (sisadetikawal > 0 && sisadetikawal < durasipaket) {
		if (siaranaktif==1){
			$('#layartancap').show();
			$('#layartancap2').hide();
			$('#layartancap3').hide();
		}
		else
		{
			$('#layartancap').hide();
			$('#layartancap2').hide();
			$('#layartancap3').show();
		}

	}

	// console.log("Tayang tiap : " + jambulat + " jam sekali");
	// console.log("Total durasi (detik) : " + durasipaket);
	// console.log("Jam sekarang (detik) : " + sisadetikawal);

	totaldurasi[0] = 0;

	<?php
	$totaldurasi = 0;

	echo "var idvideo2 = youtube_parser('" . $urllive . "'); \r\n";

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
		<?php if ($url_sponsor != ""){?>
		if (q > 1) {
			if (q == 2) {
				gabung = gabung + '<tr><td valign="top">' + detikke[1].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[2] + '</td></tr>';
			} else {
				gabung = gabung + '<tr><td valign="top">' + detikke[q].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[q] + '</td></tr>';
			}

		}
		<?php } else {?>
		gabung = gabung + '<tr><td valign="top">' + detikke[q].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[q] + '</td></tr>';
		<?php } ?>
	}

	gabung = gabung + '</table>';
	// console.log('Posisi judul akhir = ' + posisijudul);
	// console.log('Durasi detik ' + posisijudul + " = " + durasidetik[posisijudul]);
	// console.log("Playing judul acara:" + judulacara[posisijudul] + ", detik ke " + (sisadetikawal-totaldurasi[posisijudul-1]));

	jamnow = jamnow + 1000;


	$('#tempatJadwal').html(gabung);

	totalseluruhdurasi = <?php echo $totaldurasi;?>;
	//console.log("Total Durasi:"+totalseluruhdurasi);
	jadwaltayangawal = detikke[1];

	//console.log("Jadwal Tayang 1:"+jadwaltayangawal);


	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	function onYouTubeIframeAPIReady() {
		// $('#layartancap').show();
		// $('#layartancap2').hide();
		//document.getElementById('isivideoyoutube').style.display = "block";
		if (siaranaktif==1)
		loadplayer();
		else
		loadplayer2();
	}

	function loadplayer() {

		player = new YT.Player('isivideoyoutube', {
			width: 600,
			height: 400,
			videoId: idvideo[posisijudul],
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

	function loadplayer2() {

		player = new YT.Player('isivideoyoutube2', {
			width: 600,
			height: 400,
			videoId: idvideo2,
			showinfo: 0,
			controls: 0,
			autoplay: 0,
			playerVars: {
				color: 'white',
				origin: 'https://www.tvsekolah.id'
			},
			events: {
				
			}
		});

	}


	function initialize() {
		detiklokal = 2;
		sisadetikawal = totaldetikawal - jambulatawal * 3600;
		detikplayer = sisadetikawal - totaldurasi[posisijudul - 1];
		if (sisadetikawal >= 0 && siaranaktif==1) {
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

	//function hitunglagi()
	//{
	//
	//	$.get("<?php //echo base_url().'channel/realdate';?>//", function(Jam){
	//		xJam = Jam;
	//		detiklokal = 2;
	//	});
	//
	//	// }
	//}
	//
	//hitunglagi();

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

		// console.log("Jam detik sekarang:"+sisadetikawal);
		// console.log("Jam bulat:"+jambulat);

		if (sisadetikawal >= jambulat * 3600) {
			//console.log("BARU LAGI");
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
				//console.log("Playing iklan:1");
				if (siaranaktif==1)
				{
					$('#layartancap3').hide();
					$('#layartancap').hide();
					$('#layartancap2').show();
					player.stopVideo();
				}
				else
				{
					$('#layartancap3').show();
					$('#layartancap2').hide();
					$('#layartancap').hide();
				}
				
				//document.getElementById('isivideoyoutube').style.display = "block";

			} else {
				if (siaranaktif==1)
				{
					$('#layartancap3').hide();
					$('#layartancap').show();
					$('#layartancap2').hide();
					player.loadVideoById(idvideo[posisijudul], detikplayer);
					player.playVideo();
				}
				else
				{
					$('#layartancap3').show();
					$('#layartancap2').hide();
					$('#layartancap').hide();
				}
				//console.log("Playing judul acara:" + judulacara[posisijudul]);
				
			}

		}
		

		if (sisadetikawal < 0) {
			if (siaranaktif==1)
				{
					// console.log("Playing 123");
					$('#layartancap3').hide();
					$('#layartancap').hide();
					$('#layartancap2').show();
					player.stopVideo();
				}
				else
				{
					// console.log("Playing 456");
					$('#layartancap3').show();
					$('#layartancap2').hide();
					$('#layartancap').hide();
				}
		}
		

		if (detikplayer == 0) {
			// console.log("Playing 123");
			if (siaranaktif==1)
			{
				$('#layartancap3').hide();
				$('#layartancap').show();
				$('#layartancap2').hide();
				document.getElementById('isivideoyoutube').style.display = "block";
				//console.log("Playing judul acara:" + judulacara[posisijudul]);
				player.loadVideoById(idvideo[posisijudul], detikplayer);
				player.playVideo();
			}
			else
			{
				// console.log("Playing 456");
				$('#layartancap3').show();
				$('#layartancap2').hide();
				$('#layartancap').hide();
			}
		}
		

		// console.log("Posisi jud:"+idvideo[posisijudul]);
		// console.log("Detik player:"+detikplayer);

	}

	function startTimer() {

	}

	function gantisiaran() {
		var x = document.getElementById("tbupdate");
		if (x.style.display == "block")
		{
			alert ("Silakan Update terlebih dahulu");
			return false;
		} else
		{
			$.ajax({
				url: "<?php echo base_url(); ?>channel/gantisiaran",
				method: "POST",
				data: {siaranaktif:siaranaktif},
				success: function (result) {
					if (result=="sukses")
					location.reload()
				}
			})
		}
		return false;
	}

	function updateurl() {
		var txturl = $("#urllive").val();
		var x = document.getElementById("tbupdate");
		x.style.display = "none";
		$.ajax({
           url: "<?php echo base_url(); ?>channel/updateurl",
           method: "POST",
           data: {url:txturl},
           success: function (result) {
              if (result=="gagal")
			  alert ("Gagal Update!");
           }
       })
	}

	$(document).on('change input', '#urllive', function () {
		var x = document.getElementById("tbupdate");
		x.style.display="block";
	}); 

</script>