<style>
	.infomodul {
		display: inline-block;
		width: 45%;
		margin: 10px;
		background-color: #bcddbc;
		border: #0f74a8 0px solid;
	}

	.videomodul {
		padding-right: 15px;
	}

	@media (max-width: 980px) {
		.infomodul {
			width: 95%;
		}

		.videomodul {
			padding-right: 0px;
		}
	}
</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw

$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$namahari = Array('', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Ming');
$do_not_duplicate = array();
$npsnku = "";
$kodeku = "";
$nama_sekolahku = "";
$jmldaf_list = 0;
$idliveduluan = 0;
$namapaket = "";

foreach ($dafplaylist as $datane) {
	$jmldaf_list++;

	$iddaflist[$jmldaf_list] = $datane->id_paket;
	$id_videodaflist[$jmldaf_list] = $datane->link_list;
	$namapaket = $datane->nama_paket;
	$status[$jmldaf_list] = $datane->status_paket;

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
	$uraianmateri = $datane->uraianmateri;
	if ($datane->filemateri == "")
		$lampiran = "-";
	else
		$lampiran = "Ada";

	$statussoal = $datane->statussoal;

	$statuspaket = $datane->status_paket;

	$tglvicon = new DateTime($datane->tglvicon);
	$tanggalvicon = $tglvicon->format("Y-m-d H:i:s");
	$tanggale = $namahari[$tglvicon->format("N")] . ", " . $tglvicon->format("d") .
		" " . $namabulan[$tglvicon->format("n")] . " " . $tglvicon->format("Y");
	$tanggalevikon=namabulan_pendek($tanggalvicon) . " [" . substr($tanggalvicon, 11, 5) . "]";
	if($tanggalvicon=="2021-01-01 00:00:00")
		$tanggalevikon="-";
	$jame = $tglvicon->format("H:i") . " WIB";
	$thumbspaket = $thumbnail[$jmldaf_list];
	$tayangpaket = $tgl_tayang[$jmldaf_list];

	$npsnku = $datane->npsn;
	$idguru = $datane->id;
	$nama_sekolahku = $datane->sekolah;
	$namaku = $datane->first_name . ' ' . $datane->last_name;

}

$skor = 0;
$nskor = 0;
if ($nilaiuser) {
	$skor = $nilaiuser->score;
	$hiskor = $nilaiuser->highscore;
}

if ($tugasguru) {
	$uraiantugas = $tugasguru->tanyatxt;
} else {
	$uraiantugas = "";
}

if ($tugassiswa) {
	if ($tugassiswa->jawabantxt == "")
		$keterangan = "Belum dikerjakan";
	else if ($tugassiswa->nilai == "")
		$keterangan = "Belum diperiksa";
	else
		$keterangan = "Sudah diperiksa";
} else {
	$keterangan = "-";
}

//echo $bukamateri;
//echo "<br><br><br><br><br><br><br>" . $ambilpaket;
//echo "KODEROOM:".$koderoom;
//die();
//$ambilpaket = "lite";

if ($ambilpaket == "pro" || $ambilpaket == "premium")
	$bolehchat = true;
else
	$bolehchat = false;

$jml_list = 0;
foreach ($playlist as $datane) {
	//echo "<br><br><br><br>DATANE".($datane->link_video);
	$jml_list++;
	$id_videolist[$jml_list] = $datane->link_video;
	$durasilist[$jml_list] = $datane->durasi;
	$urutanlist[$jml_list] = $datane->urutan;

}

//echo "JMLLIST".$jml_list;
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

				<div id="judul" style="text-align:center;padding-top: 0px">
					<?php if ($opsi=="ds")
					{ ?>
					<span style="font-weight: bold;color: black">MODUL KE-<?php echo $modullaluke; ?>
					<br><h3><?php echo $nama_paket; ?></h3></span>
					<?php }
					else
					{ ?>
					<span style="font-weight: bold;color: black">PERTEMUAN MINGGU KE-<?php echo $mingguke; ?> <br>MODUL KE-<?php echo $modulke; ?>
					<br><h3><?php echo $nama_paket; ?></h3></span>
					<?php } ?>


				</div>

				<div style="margin-bottom: 0px;">
					<?php if ($opsi=="ds") {?>
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/modul_semua/'">Kembali
					</button>
					<?php }
					else
					 { ?>
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/sekolah_saya/'">Kembali
					</button>
					<?php } ?>
				</div>
			</div>

			<hr>
			<div class="container">
				<div class="row">
					<?php if ($ambilpaket == "Litel"){ ?>
					<div class="col-lg-6 col-md-6 col-sd-6 offset-lg-3 offset-md-3 offset-sd-3">
						<?php }
						else
						{ ?>
						<div class="col-lg-6 col-md-6 col-sd-12">
							<?php } ?>
							<div style="text-align: center;">
								<h3>Modul Video</h3>
							</div>
							<div id="layartancap" class="ratio ratio-16x9">
								<div class="videomodul" style="max-width: 100%; max-height: 100%;" id="isivideoyoutube">

								</div>
							</div>
							<div style="width: 100%;margin-top: 10px;">
								<div class="infomodul">
									<?php if ($uraianmateri != "") { ?>
										<div style="color:black;">
											<button style="font-weight:bold;height:30px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"
													onclick="bukamateri();">URAIAN MATERI
											</button>
										</div>
										<div style="color:black;">
											<table border="0" width="100%"
												   style="text-align: center;margin-top: -10px;">
												<tr style="font-weight: bold">
													<td width="50%">Lampiran</td>
												</tr>
												<tr>
													<td width="50%"><?php echo $lampiran; ?></td>
												</tr>
											</table>
										</div>
									<?php } else { ?>
										<div
											style="color:black;padding-top: 15px;height:100px;padding-bottom: 20px;">
											Uraian materi belum dibuat!
										</div>
									<?php } ?>
								</div>

								<div class="infomodul">
									<?php if ($statussoal == 1) { ?>
										<div style="color:black;">
											<button style="font-weight:bold;height:30px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"
													onclick="kerjakansoal();">SOAL
											</button>
										</div>
										<div style="color:black;">
											<table border="0" width="100%"
												   style="text-align: center;margin-top: -10px;">
												<tr style="font-weight: bold">
													<td width="50%">Tertinggi</td>
													<td width="50%">Nilai</td>
												</tr>
												<tr>
													<td width="50%"><?php echo $hiskor; ?></td>
													<td width="50%"><?php echo $skor; ?></td>
												</tr>
											</table>
										</div>
									<?php } else { ?>
										<div
											style="color:black;padding-top: 15px;height:100px;padding-bottom: 20px;">
											Soal belum dipublish!
										</div>
									<?php } ?>
								</div>

								<div class="infomodul">
									<?php if ($uraiantugas != "") { ?>
										<div style="color:black;">
											<button style="font-weight:bold;height:30px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"
													<?php if($ambilpaket!="Lite")
													{ ?> onclick="bukatugas();" <?php } ?>>TUGAS <?php
													if ($ambilpaket=="Lite") {?>[Pro keatas]<?php } ?>
											</button>
										</div>
										<div style="color:black;">
											<table border="0" width="100%"
												   style="text-align: center;margin-top: -10px;">
												<tr style="font-weight: bold">
													<td width="50%">Status</td>
												</tr>
												<tr>
													<td width="50%"><?php echo $keterangan; ?></td>
												</tr>
											</table>
										</div>
									<?php } else { ?>
										<div
											style="color:black;padding-top: 15px;height:100px;padding-bottom: 20px;">
											Tugas belum dibuat!
										</div>
									<?php } ?>
								</div>

								<div class="infomodul">
									<?php if ($uraiantugas != "") { ?>
										<div style="color:black;">
											<div style="text-align: center; font-weight:bold;height:30px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"
												 onclick="">
												VICON <?php if ($ambilpaket != "premium") echo "[Khusus Premium]"; ?>
											</div>
										</div>
										<div style="color:black;">
											<table border="0" width="100%"
												   style="text-align: center;margin-top: -10px;">
												<tr style="font-weight: bold">
													<td width="50%">Jadwal</td>
												</tr>
												<tr>
													<td width="50%"><?php echo $tanggalevikon; ?></td>
												</tr>
											</table>
										</div>
									<?php } else { ?>
										<div
											style="color:black;padding-top: 15px;height:100px;padding-bottom: 20px;">
											Tugas belum dibuat!
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<?php if ($ambilpaket != "Litel") {?>
						<div class="col-lg-6 col-md-6 col-sd-12 ">
							<?php if ($ambilpaket == "premium" && $koderoom != "") {
								?>
								<div
									style="max-width: 500px;width: 100%;margin:auto;margin-top: 50px;font-size: 18px;font-weight: bold">
									<center>
										<div style="margin-top: 20px;" id="jitsi">
											<?php if ($koderoom == "") { ?>
												VICON BELUM DIMULAI
											<?php } else if ($koderoom == "outside") { ?>
												AREA TERBATAS<br><br><br>
											<?php } ?>
										</div>
									</center>
									<center>
										<div style="margin: 20px;">
											<?php if ($koderoom != "outside") { ?>
												<button onclick="window.location.reload();">Refresh / Gabung Lagi
												</button>
											<?php } ?>
										</div>
									</center>
								</div>
							<?php } else {
								include "v_chat.php";
							}
							?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sd-12 offset-lg-3 offset-md-3">

					</div>
				</div>
			</div>
	</section>
</div>

<!--<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="https://meet.jit.si/external_api.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>

<!---->
<script>

	var icekvicon;

	function loadjitsi() {

		<?php if ($koderoom != "" && $koderoom != "outside") {?>
		icekvicon = setInterval(cekvicon, 10000);
		var domain = "meet.jit.si";
		var options = {
			roomName: "<?php echo $koderoom;?>",
			width: "100%",
			height: 500,
			userInfo: {
				displayName: '<?php echo $this->session->userdata("first_name") . " " . $this->session->userdata("last_name");?>'
			},
			parentNode: document.querySelector('#jitsi'),
			configOverwrite: {
				<?php if($statusvicon != "moderator") {?>
				disableRemoteMute: true,
				disableInviteFunctions: true,
				doNotStoreRoom: true,
				disableProfile: true,
				remoteVideoMenu: {
					disableKick: true,
				}
				<?php }?>
			},
			interfaceConfigOverwrite: {
				SHOW_JITSI_WATERMARK: true, SHOW_WATERMARK_FOR_GUESTS: true, DEFAULT_BACKGROUND: "#212529",
				DEFAULT_LOCAL_DISPLAY_NAME: 'saya', TOOLBAR_BUTTONS: [
					'microphone', 'camera', 'desktop', 'fullscreen',
					'fodeviceselection', 'profile', 'chat',
					'raisehand', 'info', 'hangup',
					'videoquality', 'filmstrip', 'tileview',
					//'stats','settings'
				]
			}
		}
		var api = new JitsiMeetExternalAPI(domain, options);
		api.executeCommand('subject', ' ');
		// api.executeCommand('password', 'apem');
		<?php if($statusvicon == "moderator" || $statusvicon == "siswa") {?>
		$.ajax({
			url: "<?php echo base_url();?>bimbel/setpassword/<?php echo $jenis . "/" . $kodelink;?>",
			method: "GET",
			data: {},
			success: function (result) {
				{
					setTimeout(() => {

						api.addEventListener('videoConferenceJoined', (response) => {
							api.executeCommand('password', result);
						});

						<?php if($statusvicon == "moderator" || $statusvicon == "siswa") {?>
						// when local user is trying to enter in a locked room
						api.addEventListener('passwordRequired', () => {
							api.executeCommand('password', result);
						});
						<?php } ?>

					}, 10);
				}
			}
		});

		<?php } ?>

		var yourRoomPass = "pass";


		setTimeout(() => {
// why timeout: I got some trouble calling event listeners without setting a timeout :)

			api.addEventListener('videoConferenceJoined', (response) => {
				api.executeCommand('password', yourRoomPass);
			});

			<?php if($statusvicon == "moderator" || $statusvicon == "siswa") {?>
			// when local user is trying to enter in a locked room
			api.addEventListener('passwordRequired', () => {
				api.executeCommand('password', yourRoomPass);
			});
			<?php } ?>

			//when local user has joined the video conference


		}, 10);

		<?php } ?>
	}

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
	$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");

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
		//alert ("HOLA0");
		detik2++;
		tglsaiki = new Date(tglnow.getTime() + (detik2 * 1000));
		if (tglsaiki - tgljadwal < 0) {
			//alert ("HOLA1");
			$('#layartancap').show();
//			$('#keteranganLive').html("SEGERA TAYANG TANGGAL: <?php //if ($id_playlist == null)
			////				echo $tgl_tayang[$idliveduluan]; else
			//					echo $tayangpaket; else
			//				echo $tayangpaket; ?>//");
			$('#divnamapaket').show();
			$('#keteranganLive').show();
			//$('#infolive<?php //echo $idliveduluan;?>//').html("Segera Tayang");


		} else {
			//alert ("HOLA2");
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
		$('#layartancap').show();
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

	function kerjakansoal() {
		<?php if($this->session->userdata("a01"))
		{ ?>
		window.open("<?php echo base_url();?>virtualkelas/soal/tampilkan/<?php echo $id_playlist;?>", "_self");
		<?php }
		else
		{ ?>
		window.open("<?php echo base_url();?>virtualkelas/soal/<?php echo $id_playlist;?>", "_self");
		<?php } ?>
	}

	function bukamateri() {
		window.open("<?php echo base_url();?>virtualkelas/materi/<?php echo '/tampilkan/' . $id_playlist;?>", "_self");
	}

	function bukatugas() {
		<?php if($this->session->userdata("a01"))
		{ ?>
		window.open("<?php echo base_url();?>virtualkelas/tugas/saya/tampilkan/<?php echo $id_playlist;?>", "_self");
		<?php }
		else
		{ ?>
		window.open("<?php echo base_url();?>virtualkelas/tugas/<?php echo $npsn . '/tampilkan/' . $id_playlist;?>", "_self");
		<?php } ?>

	}

	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}


	/*echo 'console.log('.$jml_list.');';*/


	function onYouTubeIframeAPIReady() {
		//loadjitsi();
		<?php
		/*echo "console.log('".$id_playlist."'); \r\n";
		echo "console.log('status:".$status[1]."'); \r\n";*/
		if (($id_playlist != null && $statuspaket >= 1)) {
			echo "loadplayer(); \r\n";
		}?>
	}

	function loadplayer() {
		idvideolain = "";
		masuksiaran = true;
		<?php
		if ($id_playlist != null) {
			for ($x = 1; $x < $jml_list; $x++)
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
			loadjitsi();
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
		if (masuksiaran == true) {
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

	function cekvicon() {
		$.ajax({
			url: "<?php echo base_url();?>virtualkelas/cekvicon/<?php echo $id_playlist;?>",
			type: 'GET',
			dataType: 'json',
			cache: false,
			success: function (result) {
				if (result == "off") {
					clearInterval(icekvicon);
					location.reload();
				}
			}
		})
	}


</script>


