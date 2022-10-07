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
//echo "<br>" . $ambilpaket;
//echo "KODEROOM:".$koderoom;
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

				<div id="judul" style="text-align:center;padding-top: 0px" >
					<span style="font-weight: bold;color: black">PERTEMUAN MINGGU KE-<?php echo $mingguke; ?> <br>MODUL KE-<?php echo $modulke; ?>
					<br><h3><?php echo $nama_paket; ?></h3></span>
				</div>

				<div style="margin-bottom: 0px;">
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/sekolah_saya/'">Kembali
					</button>

				</div>
			</div>

			<hr>
			<div class="container">
				<div class="row">
					<?php if ($ambilpaket == "lite"){ ?>
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
													onclick="bukatugas();">TUGAS
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
													<td width="50%"><?php echo namabulan_pendek($tanggalvicon) .
															" [" . substr($tanggalvicon, 11, 5) . "]"; ?></td>
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
						<?php if ($ambilpaket != "lite") { ?>
						<div class="col-lg-6 col-md-6 col-sd-12 ">
							<h3>Vicon</h3>
						</div>
						<div
							style="max-width: 500px;width: 100%;margin:auto;margin-top: 0px;font-size: 18px;font-weight: bold">
							<center>
								<div style="margin-top: 20px;" id="jitsi">
								</div>
							</center>
						</div>
						<?php if ($ambilpaket == "premium" && $koderoom != "") {
							?>
							<div
								style="max-width: 500px;width: 100%;margin:auto;margin-top: 50px;font-size: 18px;font-weight: bold">
								<center>
									<div style="margin-top: 20px;" id="">
										VICON
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

<!---->
<script>

	var domain = "meet.jit.si";
	var options = {
		roomName: "abcdef",
		width: "100%",
		height: 500,
		parentNode: document.querySelector('#jitsi'),
		configOverwrite: {
			disableRemoteMute: true,
			disableInviteFunctions: true,
			doNotStoreRoom: true,
			disableProfile: true,
			remoteVideoMenu: {
				disableKick: true,
			}
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

	var yourRoomPass = "pass";


	setTimeout(() => {
// why timeout: I got some trouble calling event listeners without setting a timeout :)

		api.addEventListener('videoConferenceJoined', (response) => {
			api.executeCommand('password', yourRoomPass);
		});


		// when local user is trying to enter in a locked room
		api.addEventListener('passwordRequired', () => {
			api.executeCommand('password', yourRoomPass);
		});

		//when local user has joined the video conference


	}, 10);

</script>

<script>
	function akhirivicon(linklist) {
		window.open("<?php echo base_url() . 'virtualkelas/akhirivicon/';?>" + linklist + "/1", "_self");
	}
</script>



