<link href="https://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/4.12/video.js"></script>

<style>
	.text-wrap {
		white-space: normal;
	}

	.width-100 {
		min-width: 100px;
	}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_video = 0;
foreach ($dafvideo as $datane) {
	$jml_video++;
}

if (!isset($tahun))
{
	$tahun = null;
}

$txt_contreng = Array('---', 'Masuk');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namasifat = Array('Publik', 'Modul', 'Bimbel', 'Playlist');
$namabulan = array("", "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
$statustayang = Array();
$kode_event = "";
$kodehapus = "";
if ($linkdari == "event") {
	$kode_event = $kodeevent . "/";
	$kodehapus = $kodeevent . "','";
}

if ($statusvideo == 'modul')
	$akhiran = " Saya";
else if ($statusvideo == 'sekolah')
	$akhiran = " Sekolah";
else if ($statusvideo == 'sekolahsaya')
	$akhiran = " Saya";
else if ($statusvideo == 'sekolahkontri')
	$akhiran = " Kontributor";
else if ($statusvideo == 'ekskul')
	$akhiran = " Ekstrakurikuler";
else if ($statusvideo == 'event')
	$akhiran = " Seminar/Lokakarya";
else if ($statusvideo == 'bimbel')
	$akhiran = " Bimbel Online";
else if ($statusvideo == 'calver')
	$akhiran = " Tugas Calon Verifikator";
else
	$akhiran = "";

//echo "<br><br><br><br><br>CEK TUKAN VERIFIKATOR:".$this->session->userdata('tukang_verifikasi');
if (!isset($opsi)) {
	$opsi = "profil";
}
if (!isset($opsikhusus)) {
	$opsikhusus = "";
}
if (!isset($asal)) {
	$asal = "";
}

if (!isset($kembali)) {
	$kembali = "";
}

if (!isset($kodemodul)) {
	$kodemodul = "";
}

if ($statusvideo == "event" && $this->session->userdata('a01')) {
	$jmlevent = 0;
	foreach ($dafevent as $datane) {
		$jmlevent++;
		$selevent1[$jmlevent] = "";
		if ($idevent == $datane->id_event)
			$selevent1[$jmlevent] = "selected";
		$id_event[$jmlevent] = $datane->id_event;
		$namaevent[$jmlevent] = $datane->nama_event;
	}
}

if (!isset($sudahdicekverifikator))
	$sudahdicekverifikator = "";
if (!isset($sudahdicekagency))
	$sudahdicekagency = "";

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
						<h1>VIDEO</h1>
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
				<div class="col-lg-12">
					<h3 class="text-center">Video <?php echo $akhiran; ?></h3>
					<center><span style="color: red">
					<?php if ($sudahdicekverifikator == "belum") { ?>
						Untuk video yang diunggah harus diverifikasi oleh Verifikator Sekolah terlebih dahulu sebelum bisa digunakan.
						<br>
					<?php }
					if ($sudahdicekagency == "belum") { ?>
						Khusus video Bimbel diverifikasi oleh Agency sebagai Verifikator Bimbel.<br>
					<?php }
					if ($sudahdicekverifikator == "belum" || $sudahdicekagency == "belum") { ?>
						<button style="btn-main" onclick="window.open('<?php
						if ($this->session->userdata('sebagai') == 1) {
							echo base_url() . 'profil/sekolah';
						} else {
							echo base_url() . 'profil/pekerjaan';
						}
						?>','_self');">Info Verifikator / Agency</button><br><br>
					<?php } ?>
							</span>
					</center>
				</div>
				<?php if ($statusvideo == "event" && $this->session->userdata('a01')) { ?>
					<div style="max-width: 300px;margin: auto">
						<select class="form-control" name="ievent" id="ievent">
							<option value="">-- Semua Event --</option>
							<?php
							for ($a = 1; $a <= $jmlevent; $a++) {
								?>
								<option <?php echo $selevent1[$a]; ?> value="<?php
								echo $id_event[$a]; ?>"><?php
									echo $namaevent[$a]; ?></option>
								<?php
							}
							?>
						</select>
					</div>
				<?php } ?>

				<?php if ($kembali == "modul") { 
					if ($tahun != null) { ?>
					<div style="margin-bottom: 5px;">
						<button class="btn-main"
								onclick="window.open('<?php echo base_url() . 'virtualkelas/videomodul/' . $kodemodul.'/'.$bulan.'/'.$tahun; ?>', '_self')">
							Kembali
						</button>
					</div>
					<?php } 
					else
					{ ?>
							<div style="margin-bottom: 5px;">
							<button class="btn-main"
									onclick="window.open('<?php echo base_url() . 'virtualkelas/videomodul/' . $kodemodul; ?>', '_self')">
								Kembali
							</button>
						</div>
					<?php }
				 	} 
					else if ($linkdari == "event") { ?>
					<div style="margin-bottom: 5px;">
						<button class="btn-main"
								onclick="window.open('<?php echo base_url() . 'event/acara/' . $hal; ?>', '_self')">
							Kembali
						</button>
					</div>
				<?php } else if (substr($opsikhusus, 0, 3) == "vk-") { ?>
					<div style="margin-bottom: 5px;">
						<button class="btn-main"
								onclick="window.open('<?php echo base_url() . 'virtualkelas/videomodul/' . substr($opsikhusus, 3); ?>', '_self')">
							Kembali
						</button>
					</div>
				<?php } else if ($opsi == "calver") { 
					if ($statusvideo=="verifikasi") {?>
					<div style="margin-bottom: 5px;">
						<button class="btn-main"
								onclick="window.open('<?php echo base_url() . 'marketing/chat_event/'.$kodeevent; ?>', '_self')">
							Kembali
						</button>
					</div>
					<?php } else { ?>
					<div style="margin-bottom: 5px;">
					<button class="btn-main"
							onclick="window.open('<?php echo base_url() . 'event/calon_verifikator'; ?>', '_self')">
						Kembali
					</button>
					</div>
				<?php }
				 } else if ($opsi == "calvermentor") { 
					 ?>
					<div style="margin-bottom: 5px;">
					<button class="btn-main"
							onclick="window.open('<?php echo base_url() . 'event/calon_verifikator/'.$kodevent; ?>', '_self')">
						Kembali
					</button>
					</div>
				<?php 
				 } else if ($opsi == "profil") { ?>
					<div style="margin-bottom: 5px;">
						<button class="btn-main"
								onclick="window.open('<?php echo base_url() . 'profil/verifikasi'; ?>', '_self')">
							Kembali
						</button>
					</div>
				<?php } else if ($opsi == "dashboard") { 
					if ($this->session->userdata('verifikator')==1)
					{ ?>

					<div style="margin-bottom: 5px;">
						<button class="btn-main"
								onclick="window.open('<?php echo base_url() . 'event/calon_verifikator'; ?>', '_self')">
							Kembali
						</button>
					</div>

					<?php }
					else
					{ ?>

					<div style="margin-bottom: 5px;">
						<button class="btn-main"
								onclick="window.open('<?php echo base_url() . 'profil'; ?>', '_self')">
							Kembali
						</button>
					</div>

					<?php }
					?>
					
				<?php } else if ($opsi == "bimbel") { ?>
					<div style="margin-bottom: 5px;">
						<button class="btn-main"
								onclick="window.history.back();">
							Kembali
						</button>
					</div>
				<?php } ?>
				<span style="font-size:16px;font-weight: bold;">
			<?php if ($this->session->userdata('bimbel') == 3
				&& $this->session->userdata('verifikator') == 0
				&& $this->session->userdata('kontributor') == 0) {
				echo " ";
			}; ?></span>
				<?php if ($linkdari == "event") { ?>
					<br>
					<span style="font-size:20px;font-weight: bold;"><?php echo $dataevent[0]->nama_event; ?></span>
					<span style="color:#9fafbe;font-style:italic;font-size:13px;font-weight: bold;"><?php
						echo $subjudulevent; ?></span><br>
					<span style="color:#c33728;font-size:15px;font-weight: bold;"><?php
						echo "Upload Video sebanyak: " . $jmltugasvideo . " buah"; ?></span>
					<br>
				<?php } else if ($linkdari == "calver" && $this->session->userdata('siam') != 3) { ?>
					<br>
					<span style="font-size:20px;font-weight: bold;"><?php echo $subjudulevent; ?></span>
					<span style="color:#9fafbe;font-style:italic;font-size:13px;font-weight: bold;"><?php
						echo $subjudulevent2; ?></span><br>
					<span style="color:#c33728;font-size:15px;font-weight: bold;"><?php
						echo "Upload Video sebanyak: " . $jmltugasvideo . " buah"; ?></span>
					<br>
				<?php } ?>
				</center>
				<hr style="margin-bottom: 10px;">
				<?php if ($status_verifikator != "oke" && $statusvideo != "bimbel" && $statusvideo != "bimbelsaya") {
					if ((($this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') != 3)
							|| ($this->session->userdata('sebagai') == 2) || ($this->session->userdata('bimbel') == 3
								&& $this->session->userdata('sebagai') == 3)) || $this->session->userdata('a01')) {

					} else {
						if ($linkdari != "event") {
							if ($this->session->userdata('siam')!=3)
							{
							?>
							<div style="font-weight:bold; color:red;margin-bottom: 12px;">Maaf, Tombol Verifikasi
								sementara tidak berfungsi. (Iuran belum diselesaikan).
							</div>
						<?php }
						}
					}
				}
				?>
				<div style="margin-bottom: 12px;">Sifat Video:<br>
					<ul>
						<li>"Publik" : Channel TV Sekolah</li>
						<li>"Modul" : Modul Sekolah</li>
						<li>"Bimbel" : Modul Bimbel (Diverifikasi Verifikator Bimbel)</li>
						<!-- <li>"Playlist" : Playlist</li> -->
					</ul>
				</div>
				<?php
				if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4 || $this->session->userdata('kontributor') >= 0
					|| $this->session->userdata('tukang_kontribusi') == 1 || $this->session->userdata('tukang_verifikasi') == 1) {
					?>
					<?php if ($linkdari == "event" && $this->session->userdata('sebagai') != 4) { ?>
						<div style="margin-bottom: 20px;">
							<button <?php if ($jml_video >= 10) echo 'disabled'; ?> type="button"
																					onclick="window.location.href='<?php echo base_url() . $linkdari .
																						'/spesial/' . $linkevent . '/tambah'; ?>'"
																					class="btn-main"
																					style="float:right;margin-right:10px;margin-top:-20px;"><?php if ($jml_video >= 10) echo "Max 10"; else
									echo "Tambah"; ?>
							</button>
						</div>
					<?php } else if ($linkdari == "calver" && $this->session->userdata('verifikator') == 1) { ?>
						<div style="margin-bottom: 20px;">
							<button <?php if ($jml_video >= 10) echo 'disabled'; ?> type="button"
																					onclick="window.location.href='<?php echo base_url() . 'event/mentor/video/tambah'; ?>'"
																					class="btn-main"
																					style="float:right;margin-right:10px;margin-top:-20px;"><?php if ($jml_video >= 10) echo "Max 10"; else
									echo "Tambah"; ?>
							</button>
						</div>
					<?php } else if (($linkdari != "event" && ($this->session->userdata('kontributor') == 3 || ($statusvideo == 'bimbelsaya') ||
							$this->session->userdata('verifikator') == 3 || ($statusvideo == 'bimbel'
								&& $this->session->userdata('verifikator') == 0
								&& $this->session->userdata('kontributor') == 0 && $this->session->userdata('bimbel') != 4)))) {
						if ($statusvideo == 'bimbelsaya') { ?>
							<div style="margin-bottom: 20px;">
								<button type="button"
										onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/tambah/saya'"
										class="btn-main"
										style="float:right;margin-right:10px;margin-top:-20px;">Tambah
								</button>
							</div>
						<?php } else if ($statusvideo == 'videosaya') { ?>
							<div style="margin-bottom: 20px;">
								<button type="button"
										onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/tambah/saya'"
										class="btn-main"
										style="float:right;margin-right:10px;margin-top:-20px;">Tambah
								</button>
							</div>
						<?php } else { ?>
							<div style="margin-bottom: 20px;">
							<?php if ($tahun==null)
							{ ?>
								<button type="button"
										onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/tambah'"
										class="btn-main"
										style="float:right;margin-right:10px;margin-top:-20px;">Tambah
								</button>
							<?php }
							else
							{ ?>
							<button type="button"
										onclick="window.location.href='<?php echo base_url() . $linkdari.'/tambah/evm/'.$kodemodul.'/'.$bulan.'/'.$tahun; ?>'"
										class="btn-main"
										style="float:right;margin-right:10px;margin-top:-20px;">Tambah
								</button>
							<?php } ?>
							</div>
						<?php }

					} ?>
					<?php if ($linkdari == "event" AND $this->session->userdata('sebagai') == 4) { ?>
						<div>
							<button type="button"
									onclick="window.location.href='<?php echo base_url(); ?>event/spesial/admin'"
									class=""
									style="float:right;margin-right:10px;margin-top:-20px;">Kembali
							</button>
						</div>
					<?php } else if ($linkdari == "event" AND $this->session->userdata('sebagai') != 4) { ?>

					<?php } ?>
				<?php } else if (($this->session->userdata('sebagai') != 4 || $this->session->userdata('a01')) &&
					($this->session->userdata('tukang_kontribusi') == 2 || $this->session->userdata('tukang_verifikasi') == 2)) {
					?>
					<button type="button"
							onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/tambahmp4'" class=""
							style="float:right;margin-right:10px;margin-top:-20px;">Tambah Mp4
					</button>
					<button type="button" onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/tambah'"
							class=""
							style="float:right;margin-right:10px;margin-top:-20px;">Tambah URL Video
					</button>

				<?php } ?>
				<!--	<button style="margin-left:10px" id="btn-show-all-children" type="button">Buka Semua</button>-->
				<!--	<button style="margin-left:10px" id="btn-hide-all-children" type="button">Tutup Semua</button>-->


				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style='padding:5px;width:5px;'>No</th>
							<th>Judul</th>
							<!--				<th>Topik</th>-->
							<?php
							if (($statusvideo != 'modul' && $statusvideo != 'bimbel') || $this->session->userdata('bimbel') == 4) {
								?>
								<th>Pengirim</th>
							<?php } ?>

							<?php
							if ($this->session->userdata('a01') || $statusvideo == 'bimbel' || $statusvideo == 'bimbelsaya') {
								?>
								<th>Video</th>
							<?php } ?>

							<th>Channel</th>

							<th class='none'>Jenis</th>
							<?php if ($linkdari != "sementara" && ($statusvideo != 'bimbel'
//						&& $this->session->userdata('verifikator')!=3
//						&& $this->session->userdata('kontributor')!=3
								)) {
								?>
								<th>Sifat</th>
								<th>PlayList</th>
							<?php } ?>
							<?php if ($linkdari == "event" && $this->session->userdata('sebagai') == 4) { ?>
								<th>Sekolah</th>
							<?php } ?>
							<?php if ($linkdari != "events") { ?>
								<th>Verifikator</th>
								<!--								<th>Siap Tayang</th>-->
							<?php } ?>
							<?php
							if ($statusvideo != "verifikasi") {
								?>
								<th>Edit</th>
							<?php } ?>


						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>

<center>
	<div
		style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;margin-bottom:20px;background-color:white;">
		<div id="video-placeholder" style='display:none'></div>
		<div id="videolokal" style='display:none'></div>
	</div>
</center>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>

<script>

	var oldurl = "";
	var oldurl2 = "";

	$(document).on('change', '#itahun', function () {
		get_analisis_view();
	});

	function get_analisis_view() {
		window.open("/rtf2/home/filter/" + $('#itahun').val() +
			"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
	}

	$(document).ready(function () {
		var data = [];

		<?php
		$iver = "";
		$jml_video = 0;

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$tanggal = $datesekarang->format('d');
		$bulan = $datesekarang->format('m');
		$tahun = $datesekarang->format('Y');

		foreach ($dafvideo as $datane) {
		$jml_video++;
		$nomor = $jml_video;
		$id_video = $datane->id_video;
		$kode_video = $datane->kode_video;
		$idjenis = $datane->id_jenis;

		$id_jenjang = $datane->id_jenjang;
		$id_kelas = $datane->id_kelas;
		$id_mapel = $datane->id_mapel;
		$id_ki1 = $datane->id_ki1;
		$id_ki2 = $datane->id_ki2;
		$id_kd1_1 = $datane->id_kd1_1;
		$id_kd1_2 = $datane->id_kd1_2;
		$id_kd1_3 = $datane->id_kd1_3;
		$id_kd2_1 = $datane->id_kd2_1;
		$id_kd2_2 = $datane->id_kd2_2;
		$id_kd2_3 = $datane->id_kd2_3;
		$id_kategori = $datane->id_kategori;

		$deskripsi = $datane->deskripsi;
		$keyword = $datane->keyword;

		$thumbnails = $datane->thumbnail;
		$namafile = $datane->file_video;
		$dilist = $datane->dilist;
		$sifat = $datane->sifat;

		$status_verifikasi = $datane->status_verifikasi;
		$status_verifikasi_admin = $datane->status_verifikasi_admin;
		//echo $datane->link_video;

		if ($linkdari == "event")
			$namasekolah = $datane->nama_sekolah;

		$catatan1 = $datane->catatan1;
		$catatan2 = $datane->catatan2;

		////////////////////////////////////
		$judule = str_replace('"', "'", $datane->judul);
		if (($statusvideo != 'modul' && ($statusvideo != 'bimbel')) || $this->session->userdata('bimbel') == 4) {
			$ipengirim = '"' . $datane->first_name . ' ' . $datane->last_name . '", ';
		} else
			$ipengirim = "";

		if (isset($datane->sebagai))
			$isebagai = $datane->sebagai;
		else
			$isebagai = 0;

		if ($this->session->userdata('a01') || $statusvideo == 'bimbel' || $statusvideo == 'bimbelsaya') {
			$youtube_url = $datane->link_video;
			$id = youtube_id($youtube_url);
			$id = preg_replace("/\r|\n/", "", $id);
			$ivideo = '"<button onclick=\"lihatvideo(\'' . $id . '\');\" data-video-id=\'STxbtyZmX_E\' ' .
				'type=\'button\'>Play</button>", ';
		} else {
			$ivideo = "";
		}

		if ($this->session->userdata('a01')) {
			$ipengirim = '"' . $datane->first_name . ' ' . $datane->last_name . '<br>[' . $datane->sekolah . ']", ';
		}



		if ($linkdari != "sementara" && ($statusvideo != 'bimbel')) {
			$didisabled = '';
			if ($datane->sifat == 0)
				$warna = '#b4e7df';
			else if ($datane->sifat == 1)
				$warna = '#ffd0b4';
			else if ($datane->sifat == 2)
				$warna = '#96e748';
			else if ($datane->sifat == 3)
				$warna = '#E984B1';
			if ($statusvideo == "sekolahkontri" ||
				($this->session->userdata('bimbel') == 3 && $this->session->userdata('sebagai') == 4) || 
				($this->session->userdata('siam') == 3 && $linkdari=="calver"))
				$didisabled = 'disabled';
			$isifat = '<button ' . $didisabled . ' id=\"bt1_' . $datane->id_video .
				'\" style=\"background-color: ' . $warna . '\" onclick=\"gantisifat(\'' .
				$datane->id_video . '\')\"	type=\"button\">' . $namasifat[$datane->sifat] . '</button>';

			if ($datane->dilist == 0)
				$warna2 = '#cddbe7';
			else
				$warna2 = '#e6e6e6';

			$iplaylist = '<div style=\"background-color: ' . $warna2 . '\">' . $txt_contreng[$datane->dilist] . '</div>';

			$isifatplaylist = '"' . $isifat . '", "' . $iplaylist . '", ';

		} else {
			$isifatplaylist = "";
		}

		if ($linkdari == "event" && $this->session->userdata('sebagai') == 4) {
			$inamasekolah = '"' . $datane->nama_sekolah . '", ';
		} else {
			$inamasekolah = "";
		}


		if ($datane->file_video != "") {
			$iver = '-';
		} else {
			$warna3 = '';
			if ($datane->status_verifikasi == 1 || $datane->status_verifikasi_admin == 3)
				$warna3 = 'color:red';
			else if ($datane->status_verifikasi >= 2)
				$warna3 = 'color:green';

			if ($statusvideo == "bimbel") {
				if ($datane->status_verifikasi_bimbel == 1)
					$lulustidak = 'Tidak Lulus';
				else if ($datane->status_verifikasi_bimbel >= 2) {
					if ($datane->status_verifikasi_admin == 4 || $datane->status_verifikasi_admin == 2)
						$lulustidak = 'Lulus';
					else if ($datane->status_verifikasi_admin == 3)
						$lulustidak = 'Batal Lulus';
				} else {
					$ketsekolah = "";
					$lulustidak = 'Verifikasi' . $ketsekolah;
				}
			} else
			{
				if ($datane->status_verifikasi == 1)
					$lulustidak = 'Tidak Lulus';
				else if ($datane->status_verifikasi >= 2) {
					if ($datane->status_verifikasi_admin == 4)
						$lulustidak = 'Lulus';
					else if ($datane->status_verifikasi_admin == 3)
						$lulustidak = 'Batal Lulus';
				} else {
					$ketsekolah = "";

					$lulustidak = 'Verifikasi' . $ketsekolah;
				}
			}

			if ((($this->session->userdata('tukang_verifikasi') == 1 ||
						$this->session->userdata('tukang_verifikasi') == 2)
					&& $statusvideo != 'modul' && $datane->sifat!=2)
				|| $this->session->userdata('a01') || ($statusvideo == 'bimbel' && $this->session->userdata('bimbel') == 4)) {
				$iver = '<div id=\"bt3_' . $datane->id_video . '\"><button style=\"' . $warna3 . '\" onclick=\"window.location.href=\'' . base_url() .
					$linkdari . '/verifikasi/' . $datane->id_video . '/' . $statusvideo . $opsi . '\'\" id=\"btn-show-all-children\" type=\"button\">' .
					$lulustidak . '</button></div>';
			} else if ($this->session->userdata('siam') == 3 && $linkdari=="calver") {
				$iver = '<div id=\"bt3_' . $datane->id_video . '\"><button style=\"' . $warna3 . '\" onclick=\"window.location.href=\'' . base_url() .
					'video/verifikasi/' . $datane->id_video."/calver".$kodeevent.'\'\" id=\"btn-show-all-children\" type=\"button\">' .
					$lulustidak . '</button></div>';
			} else if ($this->session->userdata('verifikator') == 1) {
				if (isset($kodeevent))
				{
					$iver = '<div id=\"bt3_' . $datane->id_video . '\"><button style=\"' . $warna3 . '\" onclick=\"window.location.href=\'' . base_url() .
					'video/verifikasi/' . $datane->id_video.'/mntr'.$kodevent.'\'\" id=\"btn-show-all-children\" type=\"button\">' .
					$lulustidak . '</button></div>';
				}
				else
				{
					$iver = '<div id=\"bt3_' . $datane->id_video . '\"><button style=\"' . $warna3 . '\" onclick=\"window.location.href=\'' . base_url() .
					'video/verifikasi/' . $datane->id_video.'\'\" id=\"btn-show-all-children\" type=\"button\">' .
					$lulustidak . '</button></div>';
				}
				
			} else {
				if ($datane->sifat == 2) {
					if ($datane->status_verifikasi_bimbel >= 2) {
						$iver = '<div id=\"bt3_' . $datane->id_video . '\"><span style=\"color:green\">Lulus</span></div>';
						if ($this->session->userdata('tukang_kontribusi') == 2) {
							if ($datane->status_verifikasi_admin == 3)
								$iver = '<div id=\"bt3_' . $datane->id_video . '\">Tidak Lulus<br>' . $datane->catatan2 . '</div>';
						} else if ($isebagai == 3) {
							$iver = '<div id=\"bt3_' . $datane->id_video . '\"></div>';
						}
					} else if ($datane->status_verifikasi_bimbel == 1) {
						$iver = '<div id=\"bt3_' . $datane->id_video . '\"><button style=\"color:red\" onclick=\"alert(\'' .
							$datane->catatan3 . '\')\">Tidak Lulus</button></div>';
					} else if ($datane->status_verifikasi_bimbel == 0) {
						$iver = '<div id=\"bt3_' . $datane->id_video . '\"><span style=\"color:black\">Belum Cek</span></div>';
					}
				} else {
					if ($datane->status_verifikasi >= 2) {
						$iver = '<div id=\"bt3_' . $datane->id_video . '\"><span style=\"color:green\">Lulus</span></div>';
						if ($this->session->userdata('tukang_kontribusi') == 2) {
							if ($datane->status_verifikasi_admin == 3)
								$iver = '<div id=\"bt3_' . $datane->id_video . '\">Tidak Lulus<br>' . $datane->catatan2 . '</div>';
						} else if ($isebagai == 3) {
							$iver = '<div id=\"bt3_' . $datane->id_video . '\"></div>';
						}
					} else if ($datane->status_verifikasi == 1) {
						$iver = '<div id=\"bt3_' . $datane->id_video . '\"><button style=\"color:red\" onclick=\"alert(\'' .
							$datane->catatan1 . '\')\">Tidak Lulus</button></div>';
					} else if ($datane->status_verifikasi == 0) {
						$iver = '<div id=\"bt3_' . $datane->id_video . '\"><span style=\"color:black\">Belum Cek</span></div>';
					}
				}


			}
		}


		if ($datane->status_verifikasi_admin == 3) {
			$statustayang = 0;
			$itayang = "---";
		} else if (($datane->status_verifikasi == 2 || $datane->status_verifikasi == 4) && $datane->id_jenis == 1) {
			$statustayang = 1;
			$itayang = "V";
		} else if ($datane->status_verifikasi == 2 && $datane->id_jenis == 2) {
			$statustayang = 1;
			$itayang = "V";
		} else if ($datane->status_verifikasi == 4 && $datane->file_video != "") {
			$statustayang = 1;
			$itayang = "V";
		} else if ($datane->status_verifikasi == 4 && $datane->link_video != "") {
			$statustayang = 1;
			$itayang = "V";
		} else {
			$statustayang = 0;
			$itayang = "-";
		}

		if ($statusvideo != "verifikasi") {
			if ($statustayang <= 1) {
				if (($this->session->userdata('bimbel') >= 3 || $this->session->userdata('a01')) && ($statusvideo == "bimbel")) {
					$iedit1 = '<button onclick=\"window.location.href=\'' . base_url() .
						$linkdari . '/edit/' . $kode_event . $datane->id_video . $asal . '/bimbel' . '\'\"' .
						' id=\"btn-show-all-children\" type=\"button\" ' .
						'class=\"myButtongreen\">Edit</button>';
				} else if ($statusvideo == 'videosaya') {
					$iedit1 = '<button onclick=\"window.location.href=\'' . base_url() .
						$linkdari . '/edit/' . $kode_event . $datane->id_video . $asal . '/saya' . '\'\"' .
						' id=\"btn-show-all-children\" type=\"button\" ' .
						'class=\"myButtongreen\">Edit</button>';
				} else if ($linkdari == "calver" && $this->session->userdata('verifikator') == 2) {
					$iedit1 = '<button onclick=\"window.location.href=\'' . base_url() .'event/mentor/video/edit/' .$datane->id_video. '\'\"' .
						' id=\"btn-show-all-children\" type=\"button\" ' .
						'class=\"myButtongreen\">Edit</button>';
				} else {
					if ($opsi=="calvermentor")
					{
						$iedit1 = '<button onclick=\"window.location.href=\'' . base_url() .
						'event/mentor/video/edit/'. $datane->id_video . '/' . $kodevent . '\'\"' .
						' id=\"btn-show-all-children\" type=\"button\" ' .
						'class=\"myButtongreen\">Edit</button>';
					}
					else
					{
						$iedit1 = '<button onclick=\"window.location.href=\'' . base_url() .
						$linkdari . '/edit/' . $kode_event . $datane->id_video . $asal . '\'\"' .
						' id=\"btn-show-all-children\" type=\"button\" ' .
						'class=\"myButtongreen\">Edit</button>';
					}
					
				}
			} else
				$iedit1 = '';

			if ($datane->dilist == 0 && $datane->dilist2 == 0 && $statusvideo != "bimbel" && $statusvideo != "videosaya" && ($datane->status_verifikasi == 0 || $isebagai == 4 || $this->session->userdata('a01')
					|| ($linkdari == "event" || $linkdari == "calver"))) {
				if ($linkdari == "calver")
				{
					$iedit2 = '<button onclick=\"return mauhapuscal(\'' . $datane->id_video . '\')\" id=\"btn-show-all-children\" ' .
					'type=\"button\" class=\"myButtonred\">Hapus</button>';
				}	
				else
				{
					$iedit2 = '<button onclick=\"return mauhapus(\'' . $kodehapus .
					$datane->id_video . '\')\" id=\"btn-show-all-children\" ' .
					'type=\"button\" class=\"myButtonred\">Hapus</button>';
				}	
				
			} else if ($datane->dilist == 0 && $datane->dilist2 == 0 && $statusvideo == "videosaya") {
				$iedit2 = '<button onclick=\"return mauhapussaya(\'' . $kodehapus .
					$datane->id_video . '\')\" id=\"btn-show-all-children\" ' .
					'type=\"button\" class=\"myButtonred\">Hapus</button>';
			} else if ($datane->dilist == 0 && $datane->dilist2 == 0 && ($this->session->userdata('bimbel') >= 3 || $this->session->userdata('a01')) && ($statusvideo == "bimbel")) {
				$iedit2 = '<button onclick=\"return mauhapusbimbel(\'' . $datane->id_video . '\')\" id=\"btn-show-all-children\" ' .
					'type=\"button\" class=\"myButtonred\">Hapus</button>';
			} else
				$iedit2 = '';

			$iedit = $iedit1 . $iedit2;
		} else
			$iedit = '';

		///////////////////////////////////////////////////////

		if ($linkdari == "events")
		{ ?>
		data.push([<?php echo $jml_video;?>, "<?php echo $judule;?>", <?php echo $ipengirim;?><?php
			echo $ivideo;?>"<?php echo $datane->channeltitle;?>", "<?php
			echo $txt_jenis[$datane->id_jenis];?>", <?php echo $isifatplaylist;?><?php
			echo $inamasekolah;?>"<?php echo $iedit;?>"]);
		<?php }
		else
		{ ?>
		data.push([<?php echo $jml_video;?>, "<?php echo $judule;?>", <?php echo $ipengirim;?><?php
			echo $ivideo;?>"<?php echo $datane->channeltitle;?>", "<?php
			echo $txt_jenis[$datane->id_jenis];?>", <?php echo $isifatplaylist;?><?php
			echo $inamasekolah;?>"<?php echo $iver;?>", "<?php echo $iedit;?>"]);
		<?php }
		}
		?>

		$('#tbl_user').DataTable({
			data: data,
			deferRender: true,
			scrollCollapse: true,
			scroller: true,
			pagingType: "simple",
			language: {
				paginate: {
					previous: "<",
					next: ">"
				}
			},
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-100'>" + data + "</div>";
					},
					targets: [1, 3, 4, 5, 6]
				},
				{responsivePriority: 1, targets: 1},
				{responsivePriority: 2, targets: -3},
				{
					width: 10,
					targets: 1
				}
			]

		});


		// Handle click on "Expand All" button
		// $('#btn-show-all-children').on('click', function () {
		// 	// Expand row details
		// 	table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
		// });

		// Handle click on "Collapse All" button
		// $('#btn-hide-all-children').on('click', function () {
		// 	// Collapse row details
		// 	table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
		// });
	});

	function lihatvideo(url) {
		document.getElementById("videolokal").style.display = 'none';
		$('#videolokal').html('');

		if (oldurl == "") {
			document.getElementById("video-placeholder").style.display = 'block';
			player.cueVideoById(url);
			player.playVideo();
			jump('video-placeholder');
		} else {
			if ((oldurl == url) && (document.getElementById("video-placeholder").style.display == 'block')) {
				document.getElementById("video-placeholder").style.display = 'none';
				player.pauseVideo();
			} else {
				document.getElementById("video-placeholder").style.display = 'block';
				player.cueVideoById(url);
				player.playVideo();
				jump('video-placeholder');
			}
		}
		oldurl = url;
	}

	function lihatvideo2(url2) {
		player.pauseVideo();
		$('#videolokal').html('<video width="600" height="400" autoplay controls>' +
			'<source src="<?php echo base_url();?>uploads/tve/' + url2 + '" type="video/mp4">' +
			'Your browser does not support the video tag.</video>');
		//alert ("VIDEO");
		document.getElementById("video-placeholder").style.display = 'none';
		if (oldurl2 == "") {
			document.getElementById("videolokal").style.display = 'block';
			//document.getElementById("videolokal").value = "NGENGOS";
		} else {
			if ((oldurl2 == url2) && (document.getElementById("videolokal").style.display == 'block')) {
				document.getElementById("videolokal").style.display = 'none';
				$('#videolokal').html('');
				//document.getElementById("videolokal").value = "NGENGOS";
			} else {
				document.getElementById("videolokal").style.display = 'block';
				//document.getElementById("videolokal").value = "NGENGOS";
			}
		}
		oldurl2 = url2;
	}

	function lihatvideo3(url2) {
		player.pauseVideo();
		$('#videolokal').html('<video width="600" height="400" autoplay controls>' +
			'<source src="' + url2 + '" type="video/mp4">' +
			'Your browser does not support the video tag.</video>');
		//alert ("VIDEO");
		document.getElementById("video-placeholder").style.display = 'none';
		if (oldurl2 == "") {
			document.getElementById("videolokal").style.display = 'block';
			//document.getElementById("videolokal").value = "NGENGOS";
		} else {
			if ((oldurl2 == url2) && (document.getElementById("videolokal").style.display == 'block')) {
				document.getElementById("videolokal").style.display = 'none';
				$('#videolokal').html('');
				//document.getElementById("videolokal").value = "NGENGOS";
			} else {
				document.getElementById("videolokal").style.display = 'block';
				//document.getElementById("videolokal").value = "NGENGOS";
			}
		}
		oldurl2 = url2;
	}

	function mauhapus(codex, idx) {

		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			<?php if ($tahun!=null) 
			{ ?>
				window.open('<?php echo base_url() . $linkdari; ?>/hapus/' + codex + '/<?php echo $kodemodul.'/'.$bulan.'/'.$tahun;?>', '_self');
			<?php }
			else
			{ ?>
				window.open('<?php echo base_url() . $linkdari; ?>/hapus/' + codex + '/' + idx, '_self');
			<?php } ?>
		} else {
			return false;
		}
		return false;
	}

	function mauhapuscal(id_video) {

		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url();?>event/hapuscal/' + id_video, '_self');
		} else {
			return false;
		}
		return false;
	}

	function mauhapussaya(codex) {

		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url() . $linkdari; ?>/hapus/' + codex + '/saya', '_self');
		} else {
			return false;
		}
		return false;
	}

	function mauhapusbimbel(codex) {

		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url() . $linkdari; ?>/hapus/' + codex + '/bimbel', '_self');
		} else {
			return false;
		}
		return false;
	}

	function gantisifat(idx) {
		statusnya = 0;
		if ($('#bt1_' + idx).html() == "Publik") {
			statusnya = 1;
		}
		<?php if($this->session->userdata('loggedIn')) {?>
		else if ($('#bt1_' + idx).html() == "Modul") {
			statusnya = 2;
		}
		<?php } ?>
		else if ($('#bt1_' + idx).html() == "Bimbel") {
			statusnya = 0;
		} else if ($('#bt1_' + idx).html() == "Playlist") {
			statusnya = 0;
		} else {
			statusnya = 0;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantisifat",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if (result == "jangan")
					alert("Sudah dipakai di bagian lain");
				else {
					if ($('#bt1_' + idx).html() == "Publik") {
						$('#bt1_' + idx).html("Modul");
						$('#bt1_' + idx).css({"background-color": "#ffd0b4"});
					}
					<?php if($this->session->userdata('loggedIn')) {?>
					else if ($('#bt1_' + idx).html() == "Modul") {
						var keterangan = result.substr(1);
						$('#bt1_' + idx).html("Bimbel");
						$('#bt1_' + idx).css({"background-color": "#96e748"});
						if (result.substr(0,1) == "0") {
							$('#bt3_' + idx).css({"color": "#000000"});
							$('#bt3_' + idx).html("Belum Cek");
						} else if (result.substr(0,1) == "1") {
							$('#bt3_' + idx).css({"color": "red"});
							$('#bt3_' + idx).html('<button style="color:red;" onclick="alert(\''+keterangan+'\');">Tidak lulus</button>');
						} else if (result.substr(0,1) == "2") {
							$('#bt3_' + idx).css({"color": "green"});
							$('#bt3_' + idx).html("Lulus");
						}
					}
					<?php } ?>
					else if ($('#bt1_' + idx).html() == "Bimbel") {
						// $('#bt1_' + idx).html("Playlist");
						// $('#bt1_' + idx).css({"background-color": "#E984B1"});
						$('#bt1_' + idx).html("Publik");
						$('#bt1_' + idx).css({"background-color": "#b4e7df"});
						if (result.substr(0,1) == "0") {
							$('#bt3_' + idx).css({"color": "#000000"});
							$('#bt3_' + idx).html("Belum Cek");
						} else if (result.substr(0,1) == "1") {
							$('#bt3_' + idx).css({"color": "red"});
							$('#bt3_' + idx).html("Tidak lulus");
						} else if (result.substr(0,1) == "2") {
							$('#bt3_' + idx).css({"color": "green"});
							$('#bt3_' + idx).html("Lulus");
						}
					} 
					// else {
					// 	$('#bt1_' + idx).html("Publik");
					// 	$('#bt1_' + idx).css({"background-color": "#b4e7df"});
					// }
				}
			}
		})

	}

	function gantilist(idx) {
		statusnya = 0;
		if ($('#bt2_' + idx).html() == "---") {
			statusnya = 1;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantilist",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if ($('#bt2_' + idx).html() == "---") {
					$('#bt2_' + idx).html("Masuk");
					$('#bt2_' + idx).css({"background-color": "#e6e6e6"});
				} else {
					$('#bt2_' + idx).html("---");
					$('#bt2_' + idx).css({"background-color": "#cddbe7"});
				}
			}
		})
	}

	function jump(h) {
		var top = document.getElementById(h).offsetTop;
		window.scrollTo(0, top - 100);
	}

	$(document).on('change', '#ievent', function () {
		window.open("<?php echo base_url() . 'video/event/dashboard/';?>" + $('#ievent').val(), "_self");
	});

</script>
