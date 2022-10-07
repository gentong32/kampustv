<style>
	#jamsekarang {
		padding-bottom: 0px;
		padding-top: 25px;
		float: right;
		margin-right: 20px
	}

	@media (max-width: 700px) {
		#jamsekarang {
			float: none;
			margin-left: auto;
			margin-right: auto;
			text-align: center;
		}
	}

	.btn-blue {
		box-shadow: 3px 4px 0px 0px #1564ad;
		background: linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
		background-color: #79bbff;
		border-radius: 5px;
		border: 1px solid #337bc4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 16px;
		font-weight: bold;
		padding: 12px 44px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #528ecc;
	}

	.btn-blue:hover {
		background: linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
		background-color: #378de5;
	}

	.btn-blue:active {
		position: relative;
		top: 1px;
	}

	.btn-ijo {
		box-shadow: inset 0px 1px 0px 0px #9acc85;
		background: linear-gradient(to bottom, #74ad5a 5%, #68a54b 100%);
		background-color: #74ad5a;
		border: 1px solid #3b6e22;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 13px;
		font-weight: bold;
		padding: 6px 12px;
		text-decoration: none;
	}

	.btn-ijo:hover {
		background: linear-gradient(to bottom, #68a54b 5%, #74ad5a 100%);
		background-color: #68a54b;
	}

	.btn-ijo:active {
		position: relative;
		top: 1px;
	}

	.btn-grey {
		box-shadow: 3px 4px 0px 0px #839089;
		background: linear-gradient(to bottom, #839089 5%, #87948D 100%);
		background-color: #ADAAAC;
		border-radius: 5px;
		border: 1px solid #CCCED4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 16px;
		font-weight: bold;
		padding: 12px 44px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #000000;
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
$jml_list = 0;
$idliveduluan = 0;

$tgl_tayang = array("", "");
$tgl_tayang1 = array("", "");

if ($iduser != null) {
	foreach ($infoguru as $datane) {
		$npsnku = $datane->npsn;
		$idguru = $datane->id;
		$nama_sekolahku = $datane->sekolah;
		$namaku = $datane->first_name . ' ' . $datane->last_name;
	}
} else {
	$namaku = "BIMBEL TVSEKOLAH";
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
	$kode_beli[$jmldaf_list] = $datane->kode_beli;
	$deskripsimodul[$jmldaf_list] = $datane->deskripsi_paket;
	$tanggalmulaivicon[$jmldaf_list] = $datane->tglvicon;

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
	if (substr($thumbnail[$jmldaf_list], 0, 4) != "http") {
		$thumbnail[$jmldaf_list] = "<?php echo base_url(); ?>uploads/thumbs/" . $thumbnail[$jmldaf_list];
	}

	$gembok1[$jmldaf_list] = "";
	if (($datane->link_paket == null && $datane->kode_beli == null) || ($datane->kode_beli!=null && $datane->tgl_beli==null) )
		$gembok1[$jmldaf_list] = base_url() . "assets/images/gembok_merah.png";

	$gembok2[$jmldaf_list] = "";
	if ($datane->statussoal == 0 || $datane->uraianmateri == "" || $datane->statustugas == 0) {
		$gembok2[$jmldaf_list] = base_url() . "assets/images/gembok_nila.png";
	}

	if(substr($datane->kode_beli,0,3)=="ECR" && $datane->tgl_beli!=null)
		$ambilpaket = "Premium";

	$pilihok [$jmldaf_list] = base_url() . "assets/images/pilihok.png";

	$displayopsi0 = "none";
	$displayopsi1 = "none";


	if ($gembokorpilih == 1) {
		$displayopsi1 = "block";
		$teksmasukin = "Batal masuk Daftar Pilihan";
	} else {
		$displayopsi0 = "block";
		if ($totalkeranjang + $totalaktif >= $totalmaksimalpilih)
			$teksmasukin = "Maksimal " . $totalmaksimalpilih . " pilihan telah tercapai";
		else
			$teksmasukin = "Masukkan ke Daftar Pilihan";
	}

	if ($expired == true) {
		$teksmasukin = "Pilih Paket Dahulu";
	}

	if ($id_playlist == $datane->link_list) {
		$statuspaket = $datane->status_paket;
		$namapaket = $datane->nama_paket;
		$tglvicon = new DateTime($datane->tglvicon);
//		$tanggale = $namahari[$tglvicon->format("N")] . ", " . $tglvicon->format("d") .
//			" " . $namabulan[$tglvicon->format("n")] . " " . $tglvicon->format("Y");
//		$jame = $tglvicon->format("H:i") . " WIB";
		$tanggale = $tglvicon->format("d") . " " . $namabulan[$tglvicon->format("n")] .
			" " . $tglvicon->format("Y") . " [" . $tglvicon->format("H:i") . "]";
		$jame = "";
		$thumbspaket = $thumbnail[$jmldaf_list];
		$tayangpaket = $tgl_tayang[$jmldaf_list];
	}
}

if ($punyalist) {
	$jml_list = 0;
	foreach ($playlist as $datane) {
		$idyt = getYouTubeVideoId($datane->link_video);
		$id = $idyt; //Video id goes here
		if (yt_exists($id)) {
			$jml_list++;
			$id_videolist[$jml_list] = $datane->link_video;
			$durasilist[$jml_list] = $datane->durasi;
			$urutanlist[$jml_list] = $datane->urutan;
		} else {
			
		}
		
		
	}
}

function yt_exists($videoID) {
    $theURL = "https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=".$videoID."&format=json";
    $headers = get_headers($theURL);
    return (substr($headers[0], 9, 3) !== "404");
}

function getYouTubeVideoId($pageVideUrl) {
    $link = $pageVideUrl;
    $video_id = explode("?v=", $link);
    if (!isset($video_id[1])) {
        $video_id = explode("youtu.be/", $link);
    }
    $youtubeID = $video_id[1];
    if (empty($video_id[1])) $video_id = explode("/v/", $link);
    $video_id = explode("&", $video_id[1]);
    $youtubeVideoID = $video_id[0];
    if ($youtubeVideoID) {
        return $youtubeVideoID;
    } else {
        return false;
    }
}


if (isset($nilaiuser))
{
	$skor = $nilaiuser->score;
	$hiskor = $nilaiuser->highscore;
}
else
{
	$skor=0;
	$hiskor=0;
}

$lampiran = "Ada";
if ($filemateri == "") {
	$lampiran = "Tidak ada";
}


if ($skor == "") {
	$skor = "-";
	$hiskor = "-";
}

if ($this->session->userdata('bimbel') == 3)
	$bolehchatsekolah = true;
else
	$bolehchatsekolah = false;

if ($tugasguru) {
	$uraiantugas = $tugasguru->tanyatxt;
} else {
	$uraiantugas = "";
}

if ($tugassiswa && $ambilpaket != "Lite") {
	if ($tugassiswa->jawabantxt == "")
		$keterangan = "Belum dikerjakan";
	else if ($tugassiswa->nilai == "")
		$keterangan = "Belum diperiksa";
	else
		$keterangan = "Sudah diperiksa";
} else {
	$keterangan = "-";
}



if (($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3) ||
	$this->session->userdata('a01') || $this->session->userdata('bimbel') >= 3) {
	$expired = false;
	$bolehchatsekolah = true;
	$gembok1[1] = "";
}

if ($kodebeliakhir != "")
	$kodebeli = $kodebeliakhir;

$eceran = false;


$now = new DateTime();
$now->setTimezone(new DateTimezone('Asia/Jakarta'));
$tanggalsekarang = $now->format("Y-m-d H:i:s");

//echo $ambilpaket;
//echo "<-->" . $gembok1[1];
//echo "<-->" . $gembok2[1];
//

?>


<!-- content begin -->
<div class="no-bottom no-top" id="content" style="margin: auto;">
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
			<div class="row" style="margin-left: -25px; margin-right:-25px">
				<div class="col-lg-12">
					<div id="jamsekarang"
						 style="font-weight: bold;color: black;"
						 id="jam">

					</div>
				</div>
				<div id="judul" style="text-align:center;padding-top: 0px">
					<div style="font-size: 20px;font-weight: bold;color: black;"><?php echo $namapaket; ?></div>
					<div style="margin-top:0px;font-size: 12px;font-style: italic;color: black;">
						[oleh: <?php echo $pengunggah; ?>]
					</div>

					<div style="margin-bottom: 10px;text-align: left;">
						<button class="btn-main"
								onclick="window.location.href='<?php echo base_url(); ?>bimbel'">Kembali
						</button>

					</div>
				</div>

				<hr>

				<div class="container">
					<div class="row" style="margin-left: -25px; margin-right:-25px">
						<?php if ($bolehchat == false) { ?>
							<div class="col-lg-6 col-md-6 col-sd-12 offset-lg-3 offset-md-3">
								<div style="margin-top:10px;text-align:center;margin-left:auto;margin-right: auto;">
									<?php
									if ($gembok1[1] != "")
									{
										if ($gembok2[1] == "") {
											?>
											<div style="position:relative;max-width: 400px;margin:auto;">
												<div style="max-width:500px;font-size:13px;background-color:black;color:white;
					position: absolute;right:10px;bottom:25px"><?php echo $durasidaf[1]; ?></div>
												<div id="opsi0"
													 style="display:<?php echo $displayopsi0; ?>;font-size:11px;color:white;position: absolute;top:10px;left:20px;bottom:10px">
													<img width="20px" height="auto" src="<?php echo $gembok1[1]; ?>">
												</div>
												<div id="opsi1"
													 style="display:<?php echo $displayopsi1; ?>;font-size:11px;color:white;position: absolute;top:16px;left:18px;bottom:10px">
													<img width="25px" height="auto" src="<?php echo $pilihok[1]; ?>">
												</div>
												<img
													style="margin-top:0px;margin-bottom:20px;width: 100%;max-width:400px"
													src="<?php
													if ($id_playlist == null)
														echo $thumbnail[$idliveduluan]; else
														echo $thumbspaket; ?>"/>
											</div>
											<div style="border: solid 1px grey;max-width: 400px;margin-top:0px;margin-bottom:25px;
										margin-left: auto;margin-right:auto;">
												<?php echo $deskripsimodul[1];?>
											</div>
											<div>
												<?php if ($expired == true) { ?>
													<button class="btn-blue" id="tbmasukin"
															style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: -20px;margin-bottom: -20px;"
															onclick="pilihpaket()"><?php echo $teksmasukin; ?>
													</button>

												<?php } else {
													if ($tunggubayar == false) {
														?>
														<button <?php
														if ($totalkeranjang + $totalaktif >= $totalmaksimalpilih && $gembokorpilih == 0) {
															echo 'disabled class="btn-grey"';
														} else {
															echo 'class="btn-blue"';
														} ?> id="tbmasukin"
															 style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: -20px;margin-bottom: -20px;"
															 onclick="masukin()"><?php echo $teksmasukin; ?></button>
													<?php }
												} ?>
											</div>

											<div>
											<?php if ($eceran == false) { ?>
												<button class="btn-blue" id="tbeceran"
														style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: 20px;margin-bottom: 20px;"
														onclick="piliheceran()">Eceran
												</button>

											<?php } else {

											}?>
											</div>

											<?php
										} else { ?>
											<div style="position:relative;max-width: 500px;margin:auto;">
												<div style="max-width:500px;font-size:13px;background-color:black;color:white;
					position: absolute;right:20px;bottom:35px"><?php echo $durasidaf[1]; ?></div>
												<div
													style="font-size:11px;color:white;position: absolute;top:10px;left:20px;bottom:10px">
													<img width="20px" height="auto" src="<?php echo $gembok1[1]; ?>">
												</div>
												<div
													style="font-size:11px;color:white;position: absolute;top:10px;left:30px;bottom:10px">
													<img width="20px" height="auto" src="<?php echo $gembok2[1]; ?>">
												</div>
												<img
													style="margin-top:0px;margin-bottom:20px;width: 100%;max-width:500px"
													src="<?php
													if ($id_playlist == null)
														echo $thumbnail[$idliveduluan]; else
														echo $thumbspaket; ?>"/>
											</div>

											<div class="row"
												 style="width:100%;display:inline-block;vertical-align:middle;color:black;margin-top:15px;padding-top:10px;">

												<div style="background-color: #bcddbc;padding:50px;">
													Uraian Materi, Soal, atau Tugas belum tersedia!
												</div>

											</div>

										<?php }
									} else {
									if ($jmldaf_list > 0) {
									?>
									<div id="layartancap2" <?php
									if ($status[1] == 2 && $id_playlist == null)
										//JIKA GAK ADA YANG MAU TAYANG
										echo 'style="display:none"' ?> class="iframe-container embed-responsive
									embed-responsive-16by9">
									<div class="embed-responsive-item" style="width: 100%;" id="isivideoyoutube">
										<?php
										if ($statuspaket == 1 && $idliveduluan > 0) {
											?>
											<img style="margin-top:-58px;width: 100%; max-width: 600px;" src="<?php
											if ($id_playlist == null)
												echo $thumbnail[$idliveduluan]; else
												echo $thumbspaket; ?>"/>
											<?php
										} ?>
									</div>
								</div>
								<?php }
								} ?>

							</div>
						<?php } else { ?>
						<div class="col-lg-6 col-md-6 col-sd-12">
							<div style="text-align: center;">
								<h3>Video</h3>
							</div>
							<div style="margin-top:10px;text-align:center;margin-left:auto;margin-right: auto;">
								<?php
								if ($gembok1[1] != "")
								{
									if ($gembok2[1] == "") {
										?>
										<div style="position:relative;max-width: 400px;margin:auto;">
											<div style="max-width:500px;font-size:13px;background-color:black;color:white;
					position: absolute;right:20px;bottom:35px"><?php echo $durasidaf[1]; ?></div>
											<div id="opsi0"
												 style="display:<?php echo $displayopsi0; ?>;font-size:11px;color:white;position: absolute;top:10px;left:20px;bottom:10px">
												<img width="20px" height="auto" src="<?php echo $gembok1[1]; ?>">
											</div>
											<div id="opsi1"
												 style="display:<?php echo $displayopsi1; ?>;font-size:11px;color:white;position: absolute;top:16px;left:18px;bottom:10px">
												<img width="25px" height="auto" src="<?php echo $pilihok[1]; ?>">
											</div>
											<img
												style="margin-top:0px;margin-bottom:20px;width: 100%;max-width:400px"
												src="<?php
												if ($id_playlist == null)
													echo $thumbnail[$idliveduluan]; else
													echo $thumbspaket; ?>"/>
										</div>
										<div style="border: solid 1px grey;max-width: 400px;margin-top:0px;margin-bottom:25px;
										margin-left: auto;margin-right:auto;">
											<?php echo $deskripsimodul[1];?>
										</div>
										<div>
											<?php if ($expired == true) { ?>
												<button class="btn-blue" id="tbmasukin"
														style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: -20px;margin-bottom: -20px;"
														onclick="pilihpaket()"><?php echo $teksmasukin; ?>
												</button>

											<?php } else {
												if ($tunggubayar == false) {
													?>
													<button <?php
													if ($totalkeranjang + $totalaktif >= $totalmaksimalpilih && $gembokorpilih == 0) {
														echo 'disabled class="btn-grey"';
													} else {
														echo 'class="btn-blue"';
													} ?> id="tbmasukin"
														 style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: -20px;margin-bottom: -20px;"
														 onclick="masukin()"><?php echo $teksmasukin; ?></button>
												<?php }
											} ?>
										</div>
										<div>
											<?php if (($eceran == false && $ambilpaket!="Premium") || $gembok1[$jmldaf_list]!="") { ?>
												<button class="btn-blue" id="tbeceran"
														style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: 20px;margin-bottom: 20px;"
														onclick="piliheceran()">Eceran Premium/Privat
												</button>

											<?php } else {

											}?>
										</div>

										<?php
									} else { ?>
										<div style="position:relative;max-width: 500px;margin:auto;">
											<div style="max-width:500px;font-size:13px;background-color:black;color:white;
					position: absolute;right:20px;bottom:35px"><?php echo $durasidaf[1]; ?></div>
											<div
												style="font-size:11px;color:white;position: absolute;top:10px;left:20px;bottom:10px">
												<img width="20px" height="auto" src="<?php echo $gembok1[1]; ?>">
											</div>
											<div
												style="font-size:11px;color:white;position: absolute;top:10px;left:30px;bottom:10px">
												<img width="20px" height="auto" src="<?php echo $gembok2[1]; ?>">
											</div>
											<img
												style="margin-top:0px;margin-bottom:20px;width: 100%;max-width:500px"
												src="<?php
												if ($id_playlist == null)
													echo $thumbnail[$idliveduluan]; else
													echo $thumbspaket; ?>"/>
										</div>

										<div class="row"
											 style="width:100%;display:inline-block;vertical-align:middle;color:black;margin-top:15px;padding-top:10px;">

											<div style="background-color: #bcddbc;padding:50px;">
												Uraian Materi, Soal, atau Tugas belum tersedia!
											</div>

										</div>

									<?php }
								} else {
								if ($jmldaf_list > 0) {
								?>
								<div>
									<button onclick="tampilkantpmbolplay();">
									PLAY VIDEO</button>
								</div>
								<img id="gambaryutub" style="margin-top:0px;margin-bottom:0px;width: 100%;max-width:400px"
													src="<?php
													if ($id_playlist == null)
														echo $thumbnail[$idliveduluan]; else
														echo $thumbspaket; ?>"/>
								<!-- <img src onclick="tampilkantpmbolplay();">PLAY</button> -->
								<div id="layartancap" style="display:none" class="iframe-container embed-responsive
								embed-responsive-16by9">
								
								<div class="embed-responsive-item" style="width: 100%;" id="isivideoyoutube">
									<?php
									if ($statuspaket == 1 && $idliveduluan > 0) {
										?>
										<img style="margin-top:-58px;width: 100%; max-width: 600px;" src="<?php
										if ($id_playlist == null)
											echo $thumbnail[$idliveduluan]; else
											echo $thumbspaket; ?>"/>
										<?php
									} ?>
								</div>
							</div>
							<?php
							} else {
								?>
								<img style="max-width:250px;width: 100%"
									 src="<?php echo base_url(); ?>assets/images/materibelum.png"/>
							<?php }
							}
							?>

							<?php if ($gembok1[1] == "") { ?>
								<div class="row"
									 style="width:100%;display:inline-block;vertical-align:middle;color:black;margin-top:15px;padding-top:10px;">
									<div
										style="display:inline-block;width: 45%;margin-right:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">
										<?php if ($uraianmateri != "") { ?>
											<div style="color:black;">
												<button style="font-size:13px;font-weight:bold;height:30px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"
														onclick="bukamateri();">MATERI
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

									<div
										style="display:inline-block;width: 45%;margin-left:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">
										<?php if ($statussoal == 1) { ?>
											<div style="color:black;">
												<button style="font-size:13px;font-weight:bold;height:30px;width:100%;margin-top:0px;
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
								</div>
								<?php if ($bolehchat) { ?>
									<div class="row"
										 style="width:100%;display:inline-block;vertical-align:middle;color:black;margin-top:15px;padding-top:10px;">
										<div
											style="display:inline-block;width: 45%;margin-right:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">
											<?php if ($uraiantugas != "") { ?>
												<div style="color:black;">
													<button style="font-size:13px;font-weight:bold;height:30px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"
														<?php if ($ambilpaket != "Lite") {
															?> onclick="bukatugas();" <?php } ?>>
														TUGAS <?php if ($ambilpaket == "Lite")
															echo " [Pro]"; ?>
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

										<div
											style="display:inline-block;width: 45%;margin-left:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">
											<?php if ($uraiantugas != "") { ?>
												<div style="color:black;">
													<button style="font-size:13px;font-weight:bold;height:30px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7">
														VICON <?php if ($ambilpaket != "Premium"
														&& $ambilpaket != "Privat") echo "[Prem]"; ?>
													</button>
												</div>
												<div style="color:black;">
													<table border="0" width="100%"
														   style="text-align: center;margin-top: -10px;">
														<tr style="font-weight: bold">
															<td width="50%">Jadwal</td>
														</tr>
														<tr>
															<td width="50%"><?php if ($tanggale != "01 Jan 2021 [00:00]") { ?>
																	<?php echo $tanggale; ?>
																<?php } else {
																	echo "-";
																} ?></td>
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
								<?php } ?>
							<?php } ?>
						</div>
						<?php if ($ambilpaket == "premiumss") {
							?>

							<div style="border: #0f74a8 1px solid;margin-top:20px;padding:20px;">
								<center><b>JADWAL VICON<br><br>
										<?php if ($tanggale != "Jum, 01 Jan 2021") { ?>
										<?php echo $tanggale; ?><br>
										<?php echo $jame; ?></b><br>
									<?php } else {
										echo "BELUM ADA JADWAL";
									} ?>

									<?php if ($adavicon == "ada" && $gembok1[1] == "") { ?>
										<div style="margin-top:10px;">
											<button
												onclick="vicon('<?php echo $jenis; ?>','<?php echo $id_videodaflist[1]; ?>')"
												class="btn-blue">VICON
											</button>
										</div>
									<?php } ?>
								</center>
							</div>
						<?php } ?>

						<div>
							<?php if (($ambilpaket!="Premium") && (substr($kode_beli[1],0,5)=="PKT31" ||
									substr($kode_beli[1],0,5)=="PKT32")) { ?>
								<button class="btn-blue" id="tbeceran"
										style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: 20px;margin-bottom: 20px;"
										onclick="piliheceran()">Upgrade Eceran
								</button>

							<?php } else {

							}?>
						</div>

					</div>
					<div class="col-lg-6 col-md-6 col-sd-12 ">
						<?php if ($ambilpaket == "Premium" && $koderoom != "" &&
							strtotime($tanggalsekarang) >= strtotime($tanggalmulaivicon[1])) {

//							echo strtotime($tanggalmulaivicon[1])."---".strtotime($tanggalsekarang);
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
	</section>
</div>

<!--------------------------- SCRIPT DATATABLE  -------------------------------->
<?php //require_once('layout/calljs.php'); ?>
<!--<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>-->
<!--<script type="text/javascript"-->
<!--		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>-->
<!---->
<!--<script src="https://www.youtube.com/iframe_api"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--js/videoscript.js"></script>-->

<!--<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="https://meet.jit.si/external_api.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>

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
	var idvideo = new Array();
	var filler = new Array();
	var jatah = 0;
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
	var detiklokal = 0;
	var tgl, bln, thn, jam, menit, detik, jmmndt;
	var opsi = <?php echo $gembokorpilih;?>;

	<?php
	$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
	echo "var tglnow = new Date('" . $stampdate . "');";
	?>

	var jamnow = tglnow.getTime();

	<?php
	for ($q = 1; $q <= $jml_list; $q++) {		
		echo "idvideo[" . $q . "] = youtube_parser('" . $id_videolist[$q] . "'); \r\n";
	};
	?>

	setInterval(updateTanggal, 1000);

	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	function onYouTubeIframeAPIReady() {
		
	}

	function tampilkantpmbolplay()
	{
		$('#gambaryutub').hide();
		$('#layartancap').show();
		loadplayer();
	}

	function loadplayer() {
		idvideolain = "";
		<?php
		if ($id_playlist != null) {
			for ($x = 1; $x <= $jml_list; $x++)
				echo "idvideolain = idvideolain + idvideo[" . $x . "]+','; \r\n";
		}
		//		if ($jml_list > 1)
		//			echo "idvideolain = idvideolain + idvideo[" . $jml_list . "]; \r\n";
		?>

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
				onReady: initialize,
				onStateChange: onPlayerStateChange
			}
		});
	}

	

	function initialize() {
		player.playVideo();
		$(function () {
			loadjitsi();
		});
	}

	function onPlayerStateChange(event) {
		//alert (event.data);
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

	}

	// <?php
	// if (!$this->session->userdata('loggedIn') && ($message == "Login Gagal")) { ?>
	// var tombolku2 = document.getElementById('tombolku2');
	// var modal = document.getElementById("myModal1");
	// modal.setAttribute('style', 'display: block');
	// <?php 
	//} ?>

	// var btn = document.getElementById("myBtn");
	// var span = document.getElementById("silang");
	// span.onclick = function () {
	// 	modal.setAttribute('style', 'display: none');
	// }

	function kembaliya() {
		window.history.back();
		//if (localStorage.getItem("akhirbimbel"))
		//	window.open(localStorage.getItem("akhirbimbel"), "_self");
		//else
		//	window.open("<?php //echo base_url();?>//bimbel/page/1", "_self");
	}

	function kerjakansoal() {
		<?php if($this->session->userdata("a01"))
		{ ?>
		window.open("<?php echo base_url();?>bimbel/soal/tampilkan/<?php echo $id_playlist;?>", "_self");
		<?php }
		else
		{ ?>
		window.open("<?php echo base_url();?>bimbel/soal/<?php echo $id_playlist . '/' . $asal;?>", "_self");
		<?php    }
		?>
	}

	function bukamateri() {
		window.open("<?php echo base_url();?>bimbel/materi/tampilkan/<?php echo $id_playlist;?>", "_self");
	}

	function bukatugas() {
		<?php if($this->session->userdata("a01"))
		{ ?>
		window.open("<?php echo base_url();?>bimbel/tugas/tampilkan/<?php echo $id_playlist;?>", "_self");
		<?php }
		else
		{ ?>
		window.open("<?php echo base_url();?>bimbel/tugas/kerjakan/<?php echo $id_playlist;?>", "_self");
		<?php    }
		?>
	}

	function masukin() {
		if (opsi == 0) {
			opsi = 1;
			$('#opsi0').hide();
			$('#opsi1').show();
			$('#tbmasukin').text("Batal masuk Daftar Pilihan")
		} else {
			opsi = 0;
			$('#opsi1').hide();
			$('#opsi0').show();
			$('#tbmasukin').text("Masukkan ke Daftar Pilihan")
		}
		$.ajax({
			url: '<?php echo base_url(); ?>bimbel/masuk_keranjang',
			type: "post",
			data: {
				jenis: 3, opsi: opsi, kodebeli: "<?php echo $kodebeli;?>",
				linklist: "<?php echo $id_playlist;?>"
			},
			success: function (data) {

			}
		});
	}

	function pilihpaket() {
		localStorage.setItem("linkakhirbeli", "<?php echo $id_playlist;?>");
		window.open("<?php echo base_url();?>bimbel/pilih_paket", "_self");
	}

	function vicon(jenis, link_list) {
		window.open("<?php echo base_url();?>bimbel/jitsi/" + jenis + "/" + link_list, '_self');
	}

	function cekvicon() {
		$.ajax({
			url: "<?php echo base_url();?>bimbel/cekvicon/<?php echo $id_playlist;?>",
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

	function piliheceran() {
		window.open("<?php echo base_url().'bimbel/pilih_eceran/'.$id_videodaflist[1];?>", "_self");
	}

</script>
