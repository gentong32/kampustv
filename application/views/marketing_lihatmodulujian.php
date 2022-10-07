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

// echo "<pre>";
// echo var_dump($datane);
// echo "</pre>";

 {
	$jmldaf_list++;

	$id_videodaflist[$jmldaf_list] = $dafplaylist->link_list;
	$nama_playlist[$jmldaf_list] = $dafplaylist->nama_paket;
	$status[$jmldaf_list] = $dafplaylist->status_paket;
	$kelas[$jmldaf_list] = substr($dafplaylist->nama_kelas,6);
	$semester[$jmldaf_list] = $dafplaylist->semester;
	$nama_mapel[$jmldaf_list] = $dafplaylist->nama_mapel;
	$modulke[$jmldaf_list] = $dafplaylist->modulke;
	if ($dafplaylist->status_paket == 1) {
		$tlive[$jmldaf_list] = "Segera Tayang";
		$idliveduluan = $jmldaf_list;
	} else {
		$tlive[$jmldaf_list] = "";
	}
	$statusmentor[$jmldaf_list] = $dafplaylist->statusmentor;
	$catatan[$jmldaf_list] = $dafplaylist->catatanmentor;

	$tgl_tayang1[$jmldaf_list] = $dafplaylist->tanggal_tayang;
	$tgl_tayang[$jmldaf_list] = substr($dafplaylist->tanggal_tayang, 8, 2) . ' ' . $namabulan[(int)(substr($dafplaylist->tanggal_tayang, 5, 2))] . ' ' . substr($dafplaylist->tanggal_tayang, 0, 4) . ' Pukul ' . substr($dafplaylist->tanggal_tayang, 11, 5) . ' WIB';
	// $idvideoawal[$jmldaf_list] = $dafplaylist->judul;
	$durasidaf[$jmldaf_list] = $dafplaylist->durasi_paket;
	// $thumbnail[$jmldaf_list] = $dafplaylist->thumbnail;

	if ($dafplaylist->tglvicon != "2021-01-01 00:00:00" && in_array(substr($dafplaylist->tglvicon, 0, 13), $do_not_duplicate)) {
		$warnamerah = "color: #EE1122;";
	} else {
		$do_not_duplicate[] = substr($dafplaylist->tglvicon, 0, 13);
		$warnamerah = "";
	}

	if ($dafplaylist->tglvicon == "2021-01-01 00:00:00")
		$tglvicon[$jmldaf_list] = "<span style='font-size: 13px;'>-</span>";
	else
		$tglvicon[$jmldaf_list] = "<span style='font-size: 13px;" . $warnamerah . "'>" . tgljam_pendek($dafplaylist->tglvicon) . "</span>";
	// echo "GAMBARE:".$datane->deskripsi;
	// die();
	// if (substr($thumbnail[$jmldaf_list], 0, 4) != "http") {
	// 	$thumbnail[$jmldaf_list] = base_url() . "uploads/thumbs/" . $thumbnail[$jmldaf_list];
	// }
	// echo "GAMBARE:".$datane->deskripsi;
	// die();
	// if (substr($thumbnail[$jmldaf_list], 0, 4) != "http") {
	// 	$thumbnail[$jmldaf_list] = base_url() . "uploads/thumbs/" . $thumbnail[$jmldaf_list];
	// }


	if ($id_playlist == $dafplaylist->link_list) {
		$statuspaket = $dafplaylist->status_paket;
		$namapaket = $dafplaylist->nama_paket;
		// $thumbspaket = $thumbnail[$jmldaf_list];
		$tayangpaket = $tgl_tayang[$jmldaf_list];
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
					<h3>Modul Sekolah Saya</h3>
				</center>
				<div style="margin-bottom: 10px;">
					
					<button class="btn-main"
							onclick="kembali();">Daftar Modul Sekolah
					</button>
			
				</div>

				<hr style="margin-bottom:0px;">

<!--				virtualkelas/modul_aktif_guru/54jrq0y078n3-->
				<center>
				<div class="container" style="text-align: center;width: 100%;margin:auto">
					<div class="row" style="margin-bottom: 40px;">
						<?php
						
						
								echo '<div style="max-width:480px;margin:auto;margin-bottom: 10px;">
			<center>
			
			<div style="font-size: smaller;">Pertemuan ke-' . $modulke[1] .'</div>
			<div class="judulvideo">' . $nama_playlist[1] .'</div>
			<div style="font-size: smaller;"><i>'.$nama_mapel[1].' - '.$kelas[1].' / '.$semester[1].'</i></div>
			<div>[Tanggal Ujian: ' .
			$tglvicon[1] . ']</div>
			
			<div style="margin-bottom: 5px">
			<button style="padding-left:2px;padding-right:2px;font-size:14px;width: 45%;" class="btn-outline-info" onclick="window.open(\'' . base_url() .
									'virtualkelas/soal/tampilkan/' . $id_videodaflist[1] . '\',\'_self\')">Lihat Ujian</button>
			
			</div>
			<hr style="margin-top: 3px;margin-bottom: 3px;">

		

			'. form_open("marketing/update_periksa/".$id_videodaflist[1]."/".$bulan).'
			<div style="max-width:300px;margin-top:30px;">
			Catatan Mentor (Jika Belum OK) :
			<textarea rows="4" cols="40" class="form-control" id="icatatan" name="icatatan"
                                  maxlength="500">'.$catatan[1].'</textarea>
			<input type="hidden" id="pilihankonfirm" name="pilihankonfirm" value="'.$statusmentor[1].'">
				<div class="row">
				<center>
				<button style="max-width:120px;margin:10px;width: 100%;" class="btn-primary" onclick="pilihkonfirm(1)">Belum OK</button>
				<button style="max-width:120px;margin:10px;width: 100%;" class="btn-primary" onclick="pilihkonfirm(2)">Sudah OK</button>
				</center>
				</div>
			</div>

			</center>

			</div>';
					echo form_close() . '';
						?>
					</div>
				</div>
			</center>
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

	function pilihkonfirm(idx)
	{
		$('#pilihankonfirm').val(idx);
	}

	function kembali()
	{
		history.back();
		return false;
	}

</script>


