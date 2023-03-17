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
	$kelas[$jmldaf_list] = substr($datane->nama_kelas,6);
	$semester[$jmldaf_list] = $datane->semester;
	$nama_mapel[$jmldaf_list] = $datane->nama_mapel;
	$modulke[$jmldaf_list] = $datane->modulke;
	$keteranganmod[$jmldaf_list] = "";
	if ($datane->modulke!=17 && $datane->modulke!=18 && $datane->modulke!=19 && $datane->modulke!=20)
		$keteranganmod[$jmldaf_list] = "(".$datane->keterangan_mod.")";

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

	if ($datane->tglvicon != "2021-01-01 00:00:00" && in_array(substr($datane->tglvicon, 0, 13), $do_not_duplicate)) {
		$warnamerah = "color: #EE1122;";
	} else {
		$do_not_duplicate[] = substr($datane->tglvicon, 0, 13);
		$warnamerah = "";
	}

	if ($datane->tglvicon == "2021-01-01 00:00:00")
		$tglvicon[$jmldaf_list] = "<span style='font-size: 13px;'>VC: -</span>";
	else
		$tglvicon[$jmldaf_list] = "<span style='font-size: 13px;" . $warnamerah . "'>VC: " . tgljam_pendek($datane->tglvicon) . "</span>";
	// echo "GAMBARE:".$datane->deskripsi;
	// die();
	if (substr($thumbnail[$jmldaf_list], 0, 4) != "http") {
		$thumbnail[$jmldaf_list] = base_url() . "uploads/thumbs/" . $thumbnail[$jmldaf_list];
	}
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

//	$gembok1[$jmldaf_list] = "";
//	if ($datane->link_paket == null) {
//		$gembok1[$jmldaf_list] = base_url() . "assets/images/gembok_merah.png";
//		//echo "gembok_merah<br>";
//	}
//
//	$gembok2[$jmldaf_list] = "";
//	if ($datane->statussoal == 0 || $datane->uraianmateri == "" || $datane->statustugas == 0) {
//		$gembok2[$jmldaf_list] = base_url() . "assets/images/gembok_nila.png";
//		//echo "gembok_nila<br>";
//	}

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

$olehadmin = "";
if ($this->session->userdata('a01'))
{
	$olehadmin = "/0/".$id_playlist;
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
				<center>
					<h3>Modul Kampus Saya</h3>
				</center>
				<div style="margin-bottom: 10px;">
					<?php if ($this->session->userdata('a01')) { ?>
						<button class="btn-main"
								onclick="window.location.href='<?php echo base_url() . 'user/kontributorsekolah/dashboard'; ?>'">Kembali
						</button>
					<?php }
					else if ($this->session->userdata('verifikator')==3) { ?>
						<button class="btn-main"
								onclick="window.location.href='<?php echo base_url() . 'virtualkelas/modul'; ?>'">Kembali
						</button>
					<?php }
					else
					{?>
					<!-- <button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/sekolah_saya'">Dashboard
					</button> -->
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/modul/'">Daftar Modul Kampus
					</button>
					<?php } ?>
				</div>

				<hr>

<!--				virtualkelas/modul_aktif_guru/54jrq0y078n3-->
				<div class="container" style="text-align: center;width: 100%;">
					<div class="row" style="margin-bottom: 40px;">
						<?php
						if ($jmldaf_list > 0) {
							for ($a1 = 1; $a1 <= $jmldaf_list; $a1++) {
								echo '<div class="columnvodbimbel" style="margin-bottom: 10px;">
			<center>
			<div class="grup" style="width:100%;margin:auto;margin-top:30px;position:relative;text-align:center">
				<a href="' . base_url() . 'virtualkelas/lihatmodul/sekolah/' . $id_videodaflist[$a1] .$olehadmin. '">
				<div style="font-size:11px;background-color:black;color:white;position: absolute;right:5px;bottom:5px">'
									. $durasidaf[$a1] . '
				</div>
				<img class="thumbbimbel" style="width: 100%;height: auto;" src="' . $thumbnail[$a1] . '"><br>
				</a>
			</div>
			<div style="font-size: smaller;">Modul ke-' . $modulke[$a1] .' '.$keteranganmod[$a1].'</div>
			<div class="judulvideo">' . $nama_playlist[$a1] .'</div>
			<div style="font-size: smaller;"><i>'.$nama_mapel[$a1].' - Smstr '.$semester[$a1].'</i></div>
			
			<div style="margin-bottom: 5px;">
			<button style="width: 100%;" class="btn-outline-info" onclick="window.open(\'' . base_url() .
									'virtualkelas/modul_aktif_guru/' . $id_videodaflist[$a1] . '/tampil\',\'_self\')">Chat [' .
									$tglvicon[$a1] . ']</button>
			</div>
			<div style="margin-bottom: 5px">
			<button style="padding-left:2px;padding-right:2px;font-size:14px;width: 45%;" class="btn-outline-info" onclick="window.open(\'' . base_url() .
									'virtualkelas/soal/nilaisiswa/' . $id_videodaflist[$a1] . '/tampil\',\'_self\')">Latihan</button>
			<button style="font-size:14px;width: 45%;" class="btn-outline-info" onclick="window.open(\'' . base_url() .
									'virtualkelas/tugas/saya/tampilkan/' . $id_videodaflist[$a1] . '/tampil\',\'_self\')">Tugas</button>
			</div>
			<hr style="margin-top: 3px;margin-bottom: 3px;">

			</center>

			</div>';
							}
						} else {
							echo "<div style='margin-top:30px;'><h3>Belum tersedia modul yang sudah lengkap</h3></div>";
						}
						?>
					</div>
				</div>
</div>


<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="https://www.youtube.com/iframe_api"></script>

<script>
	var player;
	var detikke = new Array();
	var idvideo = new Array();
	var durasike = new Array();
	var filler = new Array();
	var jatah = 0;
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
	var detiklokal = 0;
	var tgl, bln, thn, jam, menit, detik, jmmndt;
	var cekjatah = 0;
	var durasi = 0;
	var detikselisih;
	var loadsekali = false;

	var urlini = "<?php echo $_SERVER['REQUEST_URI'];?>";
	localStorage.setItem("akhirch", urlini);
	localStorage.setItem("akhir", urlini);

	<?php
	if ($idliveduluan != "") {
	?>
	//var statuslive = <?php //echo $iddaflist[$idliveduluan];?>//;
	var statuslive = <?php echo $status[$idliveduluan];?>;
	var tgljadwal = new Date("<?php echo $tgl_tayang1[$idliveduluan];?>");
	<?php
	}

			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$stampdate = $now->format("Y-m-d") ."T".$now->format("H:i:s");

		echo "var tglnow = new Date('" . $stampdate . "');";

	?>

	var jamnow = tglnow.getTime();
	var jmljudul = 0;
	var jmlterm = 0;
	var jamjadwal, jamsaiki;
	var masuksiaran = false;
	var dalamsiaran = false;

	filler[1] = 'X7R-q9rsrtU';

	<?php
	if ($id_playlist == null) {
	?>
	//detikke[1] = '<?php //echo substr($tgl_tayang1[0], 11, 8);?>//';
	detikke[1] = keJam(tglnow);
	<?php } else {
	?>
	detikke[1] = keJam(tglnow);
	<?php } ?>

	//console.log('JML LIST:'+<?php //echo $jml_list;?>//);
	//console.log("Detik 1:"+detikke[1]);
	<?php
	for ($q = 1; $q <= $jml_list; $q++) {
		echo "idvideo[" . $q . "] = youtube_parser('" . $id_videolist[$q] . "'); \r\n";
		echo "durasike[" . $q . "] = '" . $durasilist[$q] . "'; \r\n";
		if ($q > 1) {
			echo "detikke[" . $q . "] = keJam(new Date(jamHitung(" . ($q - 1) . ")+hitungDurasi(" . ($q - 1) . "))); \r\n";
		}
		echo "durasi=durasi+hitungDurasi(" . $q . "); \r\n";

//		echo "console.log('Detikke ".$q." = '+detikke[$q]); \r\n";
//		echo "console.log('Durasi ".$q." = '+durasike[$q]); \r\n";
//		echo "console.log('Id ke ".$q." = '+idvideo[$q]); \r\n";
	};
	?>

	/*console.log("Durasi:"+durasi);
	console.log("Selisih waktu:"+(tglnow-tgljadwal));*/

	detik2 = 0;

	function ceklive() {
		//alert ("HOLA");
		detik2++;
		tglsaiki = new Date(tglnow.getTime() + (detik2 * 1000));

		if (tglsaiki - tgljadwal < 0) {

			$('#layartancap').show();
//			$('#keteranganLive').html("SEGERA TAYANG TANGGAL: <?php //if ($id_playlist == null)
////				echo $tgl_tayang[$idliveduluan]; else
//					echo $tayangpaket; else
//				echo $tayangpaket; ?>//");
			$('#divnamapaket').show();
			$('#keteranganLive').show();
			//$('#infolive<?php //echo $idliveduluan;?>//').html("Segera Tayang");


		} else {
			//alert (tglsaiki-tgljadwal);
			masuksiaran = true;
			if ((tglsaiki - tgljadwal) < durasi) {
				dalamsiaran = true;
				if (loadsekali == false) {
					loadsekali = true;
					loadplayer();
				}

				$('#layartancap').show();
				$('#keteranganLive').html("LIVE");
				$('#divnamapaket').show();
				$('#keteranganLive').show();
				$('#infolive<?php echo $idliveduluan;?>').html("Live");
			} else {
				dalamsiaran = false;
				$('#layartancap').hide();
				$('#keteranganLive').html("");
				$('#divnamapaket').hide();
				$('#keteranganLive').hide();
				$('#infolive<?php echo $idliveduluan;?>').html("");
				if (statuslive == 1) {
					gantistatusselesai();
				}
			}
		}
	}


	jmljudul = <?php echo $jml_list;?>;
	/*if (durasi>0)
	jmlterm = (86400 / (durasi/1000)) - 1;
	*/
	jmlterm = 1;

	/*jamakhir = new Date("1970-01-01T" + detikke[3] + "Z").getTime();
	jamawal = new Date("1970-01-01T" + detikke[1] + "Z").getTime();*/
	//	durasi = hitungDurasi(1) + hitungDurasi(2) + hitungDurasi(3);

	if (jmlterm > 0) {
		for (var y = 1; y <= jmlterm; y++) {
			for (var z = 1; z <= jmljudul; z++) {
				detikke[y * jmljudul + z] = keJam(new Date("1970-01-01T" + detikke[z]).getTime() + durasi * y);
				durasike[y * jmljudul + z] = durasike[z];
				idvideo[y * jmljudul + z] = idvideo[z];
				//console.log("detikke"+(y * jmljudul + z)+":"+detikke[y * jmljudul + z]);
			}
		}
	}

	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}


	/*echo 'console.log('.$jml_list.');';*/


	function onYouTubeIframeAPIReady() {
		<?php
		/*echo "console.log('".$id_playlist."'); \r\n";
		echo "console.log('status:".$status[1]."'); \r\n";*/
		if (($id_playlist != null && $statuspaket == 2)) {
			echo "loadplayer(); \r\n";
		}?>
	}

	function loadplayer() {
		idvideolain = "";
		masuksiaran = true;
		<?php
		if ($id_playlist != null) {
			for ($x = 2; $x < $jml_list; $x++)
				echo "idvideolain = idvideolain + idvideo[" . $x . "]+','; \r\n";
		}
		echo "idvideolain = idvideolain + idvideo[" . $jml_list . "]; \r\n";
		?>

		//console.log(idvideo[1]);
		//console.log(idvideolain);

		player = new YT.Player('isivideoyoutube', {
			width: 600,
			height: 400,
			videoId: <?php echo "idvideo[1]";?>,
			showinfo: 0,
			controls: 0,
			autoplay: 0,
			playerVars: {
				color: 'white',
				playlist: <?php echo "idvideolain";?>
			},
			events: {
				'onReady': initialize,
			}
		});
	}


	function initialize() {
		$(function () {
			setInterval(updateTanggal, 1000);
			<?php
			if ($status[1] == 1) {
			?>
			setInterval(ceklive, 1000);
			<?php } ?>

		});

		if (dalamsiaran)
			player.playVideo();
	}


	function jamHitung(ke) {
		return new Date("1970-01-01T" + detikke[ke]).getTime();
	}

	function hitungDurasi(ke) {
		detikjam = parseInt(durasike[ke].substring(0, 2)) * 3600;
		detikmenit = parseInt(durasike[ke].substring(3, 5)) * 60;
		detikdetik = parseInt(durasike[ke].substring(6, 8));
		totaldurasi = (detikjam + detikmenit + detikdetik) * 1000;
		return totaldurasi;
	}

	function updateTanggal() {
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

		if (durasi > 0 && dalamsiaran)
			updatePlaying();
	}

	function keJam(jaminput) {
		tgl1 = new Date(jaminput).getDate();
		bln1 = new Date(jaminput).getMonth();
		thn1 = new Date(jaminput).getFullYear();
		jam1 = new Date(jaminput).getHours();
		if (jam1 < 10)
			jam1 = '0' + jam1;
		menit1 = new Date(jaminput).getMinutes();
		if (menit1 < 10)
			menit1 = '0' + menit1;
		detik1 = new Date(jaminput).getSeconds();
		if (detik1 < 10)
			detik1 = '0' + detik1;
		jame = jam1 + ':' + menit1 + ':' + detik1;

		return jame;
		//updatePlaying();
	}


	function updatePlaying() {
		for (a = 1; a <= (jmljudul * jmlterm); a++) {
			jamjadwal = new Date("1970-01-01T" + detikke[a] + "Z").getTime();
			jamsaiki = new Date("1970-01-01T" + jmmndt + "Z").getTime();
			//console.log(detikke[a]+":"+jmmndt);
			terakhir = a;
			if (jamsaiki >= jamjadwal) {
				cekjatah = a;
				detikselisih = (jamsaiki - jamjadwal) / 1000;
				//break;
			}
			if (terakhir != cekjatah)
				break;
		}

		/*console.log("Jatah:"+jatah);
		console.log("CekJatah:"+cekjatah);*/

		if (cekjatah != jatah) {

			console.log(cekjatah);
			console.log(idvideo[cekjatah]);
			jatah = cekjatah;

			detiklokal = detikselisih;

			console.log("Jatah2:" + jatah);
			console.log("Selisih:" + detikselisih);

			if (detiklokal > durasike[jatah]) {
				detiklokal = 0;
				player.loadVideoById(filler[1]);
			} else {
				player.loadVideoById(idvideo[jatah], detiklokal);
			}

			player.playVideo();
		} else {
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

	<?php
	if ($idliveduluan) {
	?>

	function gantistatusselesai() {
		$.ajax({
			url: "<?php echo base_url();?>channel/gantistatuspaket",
			method: "POST",
			data: {id: <?php echo $iddaflist[$idliveduluan];?>},
			success: function (result) {
				statuslive = 1;
				//detik2=0;
			}
		})
	}

	<?php } ?>

	var count = 0;
	var myInterval;

	function timerHandler() {
		if (player.getPlayerState() == 1) {
			count++;
		}
		document.getElementById("seconds").innerHTML = "Durasi menonton: " + count + " detik. <br>(Refresh)";
		<?php if ($this->session->userdata("loggedIn")) {?>
		if (count >= 150 && count % 150 == 0)
			updatenonton();
		<?php } ?>
	}

	function updatenonton() {
		$.ajax({
			url: "<?php echo base_url();?>channel/updatenonton",
			method: "POST",
			data: {
				channel: 2, npsn: "<?php echo $npsnku;?>",
				idguru: <?php echo $idguru;?>, linklist: "<?php echo $id_playlist;?>", durasi: count
			},
			success: function (result) {
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				alert("Status: " + textStatus);
				alert("Error: " + errorThrown);
			}
		})
	}

	function startTimer() {
		if(masuksiaran==true) {
			window.clearInterval(myInterval);
			myInterval = window.setInterval(timerHandler, 1000);
		}
	}

	function stopTimer() {
		window.clearInterval(myInterval);
	}

	function onFocus() {
		console.log('browser window activated');
		startTimer()
	}

	function onBlur() {
		console.log('browser window deactivated');
		stopTimer()
	}

	var inter;
	var iframeFocused;
	window.focus();      // I needed this for events to fire afterwards initially
	addEventListener('focus', function (e) {
		console.log('global window focused');
		if (iframeFocused) {
			console.log('iframe lost focus');
			iframeFocused = false;
			//clearInterval(inter);
		} else onFocus();
	});

	addEventListener('blur', function (e) {
		console.log('global window lost focus');
		if (document.hasFocus()) {
			console.log('iframe focused');
			iframeFocused = true;
			inter = setInterval(() => {
				if (!document.hasFocus()) {
					console.log('iframe lost focus');
					iframeFocused = false;
					onBlur();
					clearInterval(inter);
				}
			}, 100);
		} else onBlur();
	});

	function salinteks(linklist) {
		var copyText = "<?php echo base_url();?>virtualkelas/get_bimbel/"+linklist+"/share";
		navigator.clipboard.writeText(copyText);
	}

	function klikbagikan(idx,linklist,judul) {
		if (idx == 1) {
			window.open("https://www.facebook.com/sharer/sharer.php?u=https%3A//tvsekolah.id/bimbel/get_bimbel/" +
				linklist + "/share");
		}
		if (idx == 2) {
			window.open("https://twitter.com/intent/tweet?url=https%3A//tvsekolah.id/bimbel/get_bimbel/" +
				linklist + "/share&text=" + judul + "&via=VODApp");
		}
	}


</script>


