<style>
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

	.btn-toska {
		box-shadow: inset 0px 1px 0px 0px #bad4ca;
		background: linear-gradient(to bottom, #9ab0a7 5%, #a6beb4 100%);
		background-color: #a6beb4;
		border: 1px solid #889b93;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 13px;
		font-weight: bold;
		padding: 6px 12px;
		text-decoration: none;
	}

	.btn-toska:hover {
		background: linear-gradient(to bottom, #81948c 5%, #889b93 100%);
		background-color: #9bb2a8;
	}

	.btn-toska:active {
		position: relative;
		top: 1px;
	}

	/* The Modal (background) */
	.modalpaket {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		padding-top: 100px; /* Location of the box */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0, 0, 0); /* Fallback color */
		background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modalpaket-content {
		position: relative;
		background-color: #fefefe;
		margin: auto;
		padding: 2px;
		border: 1px solid #888;
		width: 80%;
		max-width: 600px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		-webkit-animation-name: animatetop;
		-webkit-animation-duration: 0.4s;
		animation-name: animatetop;
		animation-duration: 0.4s
	}

	/* Add Animation */
	@-webkit-keyframes animatetop {
		from {
			top: -300px;
			opacity: 0
		}
		to {
			top: 0;
			opacity: 1
		}
	}

	@keyframes animatetop {
		from {
			top: -300px;
			opacity: 0
		}
		to {
			top: 0;
			opacity: 1
		}
	}

	/* The Close Button */
	.modalpaketclose {
		color: #898a84;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.modalpaketclose:hover,
	.modalpaketclose:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}

	.modalpaket-header {
		background-color: #c9dc91;
		color: white;
	}

	.modalpaket-body {
		padding: 2px 10px;
		color: black;
	}

	.modalpaket-footer {
		padding: 2px 10px;
		background-color: #87948d;
		color: white;
	}
</style>

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

$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$lastUriSegment = array_pop($uriSegments);

if (end($uriSegments) == "cari")
	$asal = "cari";

if ($asal == "cari")
	$lastUriSegment = "cari/" . $lastUriSegment;
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
	$namaku = "KELAS VIRTUAL TVSEKOLAH";
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
		$thumbnail[$jmldaf_list] = base_url() . "uploads/thumbs/" . $thumbnail[$jmldaf_list];
	}

	$gembok1[$jmldaf_list] = "";
	if ($datane->link_paket == null) {
		$gembok1[$jmldaf_list] = base_url() . "assets/images/gembok_merah.png";
	}

	$gembok2[$jmldaf_list] = "";
	if ($datane->statussoal == 0 || $datane->uraianmateri == "" || $datane->statustugas == 0) {
		$gembok2[$jmldaf_list] = base_url() . "assets/images/gembok_nila.png";
	}

	$pilihok[$jmldaf_list] = base_url() . "assets/images/pilihok.png";

	$displayopsi0[$jmldaf_list] = "none";
	$displayopsi1[$jmldaf_list] = "none";

	if ($datane->dikeranjang == 1) {
		$displayopsi1[$jmldaf_list] = "block";
	} else {
		$displayopsi0[$jmldaf_list] = "block";
	}

	if ($id_playlist == $datane->link_list) {
		$statuspaket = $datane->status_paket;
		$namapaket = $datane->nama_paket;
		$thumbspaket = $thumbnail[$jmldaf_list];
		$tayangpaket = $tgl_tayang[$jmldaf_list];
	}
}


if ($punyalist) {
	$jml_list = 0;
	foreach ($playlist as $datane) {
		//echo "<br><br><br><br>DATANE".($datane->link_video);
		$jml_list++;
		$id_videolist[$jml_list] = $datane->link_video;
		$durasilist[$jml_list] = $datane->durasi;
		$urutanlist[$jml_list] = $datane->urutan;
	}
}

$jml_jenjang = 0;
foreach ($dafjenjang as $datane) {
	$jml_jenjang++;
	$kd_jenjang[$jml_jenjang] = $datane->id;
	$nama_jenjang[$jml_jenjang] = $datane->nama_jenjang;
	$nama_pendek[$jml_jenjang] = $datane->nama_pendek;
	$keselectj[$jml_jenjang] = "";
	if ($jenjang == $kd_jenjang[$jml_jenjang]) {
//echo "DISINI NIH:".$kd_jenjang[$jml_jenjang].'='.$jenjang;
		$keselectj[$jml_jenjang] = "selected";
	}

}

$daftarkelas = array();
$jmlkelas = 0;
foreach ($dafkelas as $datane) {
	$jmlkelas++;
	$idkelas[$jmlkelas] = $datane->id;
	$idjenjang[$jmlkelas] = $datane->id_jenjang;
	$namakelas[$jmlkelas] = $datane->nama_kelas;
}

//echo "<br><br><br><br><br><br>";
$jml_mapel = 0;
if ($jenjang != "0") {
	foreach ($dafmapel as $datane) {
		$jml_mapel++;
		$kd_mapel[$jml_mapel] = $datane->id;
		$nama_mapel[$jml_mapel] = $datane->nama_mapel;
		$keselectm[$jml_mapel] = "";
		if ($mapel == $kd_mapel[$jml_mapel]) {
			$keselectm[$jml_mapel] = "selected";
		}
//echo "<br>".$kd_mapel[$jml_mapel]."---".$nama_mapel[$jml_mapel];
	}
}

//if ($jenjang!="0")
{
	$jml_kategori = 0;
	foreach ($dafkategori as $datane) {
//echo "ID Jenjang pil:".$datane->id;
		$jml_kategori++;
		$kd_kategori[$jml_kategori] = $datane->id;
		$nama_kategori[$jml_kategori] = $datane->nama_kategori;
		$keselectk[$jml_kategori] = "";
		if ($kategori == $kd_kategori[$jml_kategori]) {
//echo "DISINI NIH:".$kd_jenjang[$jml_jenjang].'='.$jenjang;
			$keselectk[$jml_kategori] = "selected";
		}
	}
}
if ($ambilpaket == "0")
	$ambilpaket = "belum punya paket";
else
	$ambilpaket = "paket " . $ambilpaket . "";

if ($jenis == 1)
	$title = "KELAS VIRTUAL SEKOLAH SAYA";
else
	$title = "KELAS VIRTUAL SEKOLAH LAIN";

if ($ambilpaket != "belum punya paket"
	|| $this->session->userdata('a01')
	|| ($this->session->userdata('a02') && $this->session->userdata('sebagai') == 1)
	|| $this->session->userdata('a03'))
	$bolehchat = true;
else
	$bolehchat = false;

//echo "<br><br><br><br><br><br><br><br>".$ambilpaket;
?>

<div id="myModalPaket" class="modalpaket" style="z-index: 999;">

	<!-- Modal content -->
	<div class="modalpaket-content">
		<div class="modalpaket-header" style="margin-top:-10px;padding-top:-20px;padding-bottom: 0px;">
			<span class="close" style="margin-right:5px;color: black; font-weight: bold;">&times;</span>
			<center><h3><span style="color: black"><?php echo strtoupper($ambilpaket); ?></span></h3></center>
		</div>
		<div class="modalpaket-body" style="font-size: 16px;margin-top0px;padding-top: 10px;">
			Paket aktif sekarang adalah <b><?php echo strtoupper($ambilpaket); ?></b>.<br>
			Untuk paket ini, anda bisa memilih hingga <b><?php
				echo $totalmaksimalpilih; ?></b> paket materi. <br><br>Paket berlaku hingga <?php
			echo substr($tglbatas, 0, 2) . " " . $namabulan[intval(substr($tglbatas, 3, 2))] . " " . substr($tglbatas, 6, 4); ?>
			.
		</div>
		<div>
			<?php if ($ambilpaket == "paket lite" || $ambilpaket == "paket pro") { ?>
				<center>
					<button
						onclick="window.open('<?php echo base_url() . "vksekolah/pilih_paket/" . $npsn; ?>','_self')"
						class="btn-ijo">Upgrade Paket
					</button>
				</center>
			<?php } ?>
		</div>
	</div>

</div>



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

	<section aria-label="section">
		<div class="container">

			<div class="row">
				<div class="col-lg-12">
					<div id="jamsekarang"
						 style="font-weight: bold;color: black;padding-bottom:10px;padding-top:5px;float: right; margin-right: 20px"
						 id="jam">
						&nbsp;
					</div>
				</div>
			</div>



			<center><span style="color:#000000;font-size:18px;font-weight: bold;"><?php echo $title; ?></span>
				<br>

				<?php if ($ambilpaket != "belum punya paket") {
					if ($tunggubayar == true) { ?>
						<button class="btn-toska" style="padding:5px;padding-top:0px;padding-bottom:0px;"
								onclick="return tunggubayar()">
			<span
				style="color:#effff4;font-size: 14px;font-weight: bold;">Menunggu Pembayaran</span>
						</button>
					<?php } else {
						?>
						<button class="btn-toska" style="padding:5px;padding-top:0px;padding-bottom:0px;"
								onclick="return infopaket()">
			<span
				style="color:#effff4;font-size: 14px;font-weight: bold;"><?php echo "" . strtoupper($ambilpaket) . ""; ?></span>
						</button>
					<?php }
				} ?>
				<br>
				<span
					style="color:black;font-size: 13px;font-style:italic;font-weight: bold ;"><?php echo "(" . $totalaktif . " modul aktif)"; ?></span>
				<?php if ($totalkeranjang > 0 && $expired == false) { ?>
					<br>
					<button class="btn-ijo" onclick="return konfirmpilih();">Konfirmasi <?php echo $totalkeranjang; ?>
						modul
						pilihan
					</button>
				<?php } ?>
				<div>
					<?php if ($ambilpaket == "paket lite" || $ambilpaket == "paket pro") { ?>
						<center>
							<button
								onclick="window.open('<?php echo base_url() . "vksekolah/pilih_paket/" . $npsn; ?>','_self')"
								class="btn-ijo">Upgrade Paket
							</button>
						</center>
					<?php } ?>
					<br>
				</div>
			</center>
			<div class="row" style="text-align:center;width:100%">

				<div id="isijenjang" style="text-align:center;width:250px;display:inline-block;padding-bottom: 5px;">
					<select class="form-control" name="ijenjang" id="ijenjang">
						<option value="0">-- Pilih Jenjang --</option>
						<!--					<option value="kategori">[Ganti Pilihan ke Kategori]</option>-->
						<?php
						for ($v1 = 1; $v1 <= $jml_jenjang; $v1++) {
							echo '<option ' . $keselectj[$v1] . ' value="' . $nama_pendek[$v1] . '">' . $nama_jenjang[$v1] . '</option>';
						}
						?>
					</select>
				</div>

				<div id="isikelas" style="text-align:center;width:250px;display:inline-block;padding-bottom: 5px;">
					<select class="form-control" name="ikelas" id="ikelas">
						<option value="0">-- Pilih Kelas --</option>
						<?php

						for ($sa = 1; $sa <= $jmlkelas; $sa++) {
							if ($idjenjang[$sa] == $njenjang) {
								if ($nkelas == $idkelas[$sa]) {
									echo '<option selected value="' . $idkelas[$sa] . '">' . $namakelas[$sa] . '</option>';
								} else {
									echo '<option value="' . $idkelas[$sa] . '">' . $namakelas[$sa] . '</option>';
								}

							}
						}

						?>
					</select>
				</div>

				<div id="isimapel" style="text-align:center;width:250px;display:inline-block;padding-bottom: 5px;">
					<select class="form-control" name="imapel" id="imapel">
						<option value="0">-- Pilih Mapel --</option>
						<?php
						if ($njenjang > 0) {
							for ($sb = 1; $sb <= $jml_mapel; $sb++) {
								if ($kd_mapel[$sb] == $nmapel) {
									echo '<option selected value="' . $kd_mapel[$sb] . '">' . $nama_mapel[$sb] . '</option>';
								} else {
									echo '<option value="' . $kd_mapel[$sb] . '">' . $nama_mapel[$sb] . '</option>';
								}
							}
						}
						?>
					</select>
				</div>

				<div id="pencarian" style="width:230px;display:inline-block">
					<input type="text" name="isearch" class="form-control" id="isearch" placeholder="cari ..."
						   value="<?php echo $kuncine; ?>" style="width:220px;height:35px">
				</div>

				<button style="width: 48px;margin-left:0px;margin-bottom:5px;height: 30px;" class="btn btn-default"
						onclick="return caridonk()">Cari
				</button>
			</div>
			<br>
			<?php if ($bolehchat == true && $jenis == 1) { ?>
				<div style="padding-bottom: 10px; text-align:center; margin: auto;margin-top:-10px;">
					<button class="btn-ijo" onclick="window.open('../../channel/chat/sekolah','_blank')">Forum Diskusi
						Sekolah
					</button>
				</div>
			<?php } ?>
		</div>


		<div class="indukplay" style="margin-top:10px;text-align:center;margin-left:auto;margin-right: auto;">
			<?php
			if ($jmldaf_list > 0) {
			?>
			<div id="layartancap" <?php
			if ($status[1] == 2 && $id_playlist == null)
				//JIKA GAK ADA YANG MAU TAYANG
				echo 'style="display:none";' ?>" class="iframe-container embed-responsive embed-responsive-16by9">
			<div class="embed-responsive-item" style="width: 100%" id="isivideoyoutube">
				<?php
				if ($statuspaket == 1 && $idliveduluan > 0) {
					?>
					<img style="margin-top:-58px;width: 100%" src="<?php
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
			<img style="max-width:250px;width: 100%" src="<?php echo base_url(); ?>assets/images/materibelum.png"/>
		<?php }
		?>

		<div id="divnamapaket" style="text-align:center; color:black">
			<?php
			if ($id_playlist == null && $jmldaf_list > 0 && $idliveduluan != "") {
				echo "<div style='text-align: left' id='seconds'></div>";
				echo "[" . $nama_playlist[$idliveduluan] . "]";
				echo '<hr style="height:1px;border:none;color:#366e8f;background-color:#366e8f;">';
			} else {
				echo "<div style='text-align: left' id='seconds'></div>";
				echo $namapaket;

			}
			?>
		</div>
		<?php

		if ($jmldaf_list > 0) {
			if ($statuspaket == 1 && $idliveduluan != 0) {
				?>
				<div id="keteranganLive" style="text-align:center; color:black">
					SEGERA TAYANG TANGGAL: <?php echo $tgl_tayang[1]; ?>
				</div>
				<hr style="height:1px;border:none;color:#366e8f;background-color:#366e8f;">
			<?php }
		} ?>

	</section>
</div>


<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<div class="row g-4">

	<?php for ($a1 = 1; $a1 <= $jmldaf_list; $a1++) {

		$judulTitle = ucwords(strtolower($nama_playlist[$a1]));
		if (strlen($judulTitle) > 72) {
			$judulTitle = substr(ucwords(strtolower($nama_playlist[$a1])), 0, 72) . ' ...';
		}
		?>


		<div class="col-md-3">
			<div class="video__item">
				<div>
					<a href="<?php echo base_url() . 'vksekolah/get_vksekolah/' . $npsn . "/" . $id_videodaflist[$a1]; ?>">
						<img src="<?php echo $thumbnail[$a1]; ?>" class="lazy video__item_preview" alt="">
					</a>
					<div
						style="font-size:11px;height:20px;padding-top:-20px;color:black;position: absolute;right:20px;bottom:50px">
						[<?php echo $durasidaf[$a1]; ?>]
					</div>
					<div
						style="display:<?php echo $displayopsi0[$a1]; ?>;font-size:11px;color:white;position: absolute;top:10px;left:20px;bottom:10px">
						<img style="width: 20px;" width="20px" height="auto" src="<?php echo $gembok1[$a1]; ?>">
					</div>
					<div style="font-size:11px;color:white;position: absolute;top:10px;left:30px;bottom:10px">
						<img style="width: 20px;" width="20px" height="auto" src="<?php echo $gembok2[$a1]; ?>">
					</div>
					<div
						style="display:<?php echo $displayopsi1[$a1]; ?>;font-size:11px;color:white;position: absolute;top:10px;left:18px;bottom:10px">
						<img style="width: 25px;" width="25px" height="auto" src="<?php echo $pilihok[$a1]; ?>">
					</div>
				</div>

				<div class="spacer-single"></div>

				<div class="video__item_info">
					<a href="<?php echo base_url() . 'vksekolah/get_vksekolah/' . $npsn . "/" . $id_videodaflist[$a1]; ?>">
						<h4><?php echo $judulTitle; ?></h4>
					</a>

					<div class="video__item_action">
						<a href="<?php echo base_url() . 'vksekolah/get_vksekolah/' . $npsn . "/" . $id_videodaflist[$a1]; ?>">Pilih</a>
					</div>
					<div class="video__item_like">
						<i class="fa fa-heart"></i><span>50</span>
					</div>
				</div>
			</div>

		</div>

	<?php } ?>
</div>

<div class="bgimg3" style="text-align: center;width: 100%;">
	<!--	<span style="font-weight: bold;color: black">MICRO LEARNING TERBARU</span>-->

	<div style="text-align: center;margin: auto">

		<nav aria-label="pagination" style="text-align: center;margin: auto">
			<ul class="pagination">
				<?php
				if ($mapel == "")
					$mapel = "0";

				if ($mapel == "0") {
					$alamat = "";
				} else {
					$alamat = "mapel/";
					if ($mapel == "cari")
						$alamat = $alamat . '/cari/' . $kuncine;
					else {
						if ($kuncine == "cari")
							$alamat = $alamat . '/' . $mapel . '/cari/' . $kuncine;
						else
							$alamat = $alamat . '/' . $mapel;
					}
				}

				if ($total_data > 10) {
					$batas = intval($total_data / 10);
					if ($total_data % 10 > 0)
						$batas = $batas + 1;
					//echo "==============".$batas;
					for ($a = 1; $a <= $batas; $a++) {
						if ($a == $lastUriSegment)
							echo '<li><a href="' . base_url() . 'vksekolah/set/' . $npsn . '/' . $alamat . $a . '" style="background-color: #e4c774">' . $a . '</a></li>';
						else
							echo '<li><a href="' . base_url() . 'vksekolah/set/' . $npsn . '/' . $alamat . $a . '" style="background-color: #7f7f7f">' . $a . '</a></li>';
					}
					?>

				<?php } ?>

			</ul>
		</nav>
	</div>


</div>
<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->

<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>
<!--<script src="https://www.youtube.com/iframe_api"></script>-->

<script>
	localStorage.setItem("linkakhirbeli", "induk");
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');


	<?php
	$now = new DateTime();
	$now->setTimezone(new DateTimezone('Asia/Jakarta'));
	$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
	echo "var tglnow = new Date('" . $stampdate . "');";
	?>

	var jamnow = tglnow.getTime();

	setInterval(updateTanggal, 1000);

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

</script>


<script src="<?php echo base_url() ?>js/jquery-ui.js"></script>


<script>

	var namakelas = Array();
	var idjenjang = Array();

	localStorage.setItem("akhir", window.location.href);

	<?php
	if ($njenjang > 0) {
		for ($a = 1; $a <= sizeof($dafkelas); $a++) {
			echo "namakelas[" . $a . "] = '" . $namakelas[$a] . "';\n";
			echo "idjenjang[" . $a . "] = " . $idjenjang[$a] . ";\n";
		}
	}
	?>

	$(document).ready(function () {
		$('#isearch').autocomplete({
			source: '<?php echo(site_url() . "vksekolah/get_autocomplete/" . $npsn);?>',
			minLength: 1,
			select: function (event, ui) {
				$('#isearch').val(ui.item.value);
				//$('#description').val(ui.item.deskripsi);
			}
		});
	});

	$(document).on('change', '#ijenjang', function () {

		if ($('#ijenjang').val() == "kategori") {
			window.open("<?php echo base_url(); ?>vksekolah/kategori/pilih", "_self");
		} else if ($('#ijenjang').val() != "0") {
			window.open("<?php echo base_url() . 'vksekolah/mapel/' . $npsn . '/';?>" + $('#ijenjang').val(), "_self");

		} else {
			window.open("<?php echo base_url() . 'vksekolah/set/' . $npsn . '/';?>", "_self");
		}
	});

	$(document).on('change', '#ikelas', function () {
		window.open("<?php echo base_url() . 'vksekolah/mapel/' . $npsn . '/';?>" + $('#ijenjang').val() + "/" + $('#ikelas').val() + "/" + $('#imapel').val(), "_self");
	});

	$(document).on('change', '#imapel', function () {
		//alert ($('#imapel').val());
		window.open("<?php echo base_url() . 'vksekolah/mapel/' . $npsn . '/';?>" + $('#ijenjang').val() + "/" + $('#ikelas').val() + "/" + $('#imapel').val(), "_self");
	});


	$('#isearch').keypress(function (event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == '13') {
			caridonk();
		}
		event.stopPropagation();
	});

	function caridonk() {
		$('#isearch').val($('#isearch').val().replace(/[^a-zA-Z ]/g, ""));
		window.open('<?php echo base_url() . 'vksekolah/cari/' . $npsn . '/';?>' + $('#isearch').val(), '_self');

	}

	function konfirmpilih() {
		//alert ("<?php echo $npsn . "---" . $jenis;?>");
		var r = confirm("Sudah yakin akan pilihan ini?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url();?>vksekolah/konfirmpilihan",
				method: "POST",
				data: {
					npsn: "<?php echo $npsn;?>",
					jenis: <?php echo $jenis;?>},
				success: function (result) {
					if (result == "sukses") {
						window.location.reload();
					} else if (result == "expired")
						alert("Paket expired, silakan beli paket baru lagi!");
					else if (result == "AAA")
						alert("AAA");
					else if (result == "BBB")
						alert("BBB");
					else
						alert(result);
					// alert("Ada masalah! Hubungi admin!");
				}
			})
		} else {
			return false;
		}
		return false;
	}

	function infopakets() {
		alert("");
		return false;
	}

</script>

<script>

	<?php
	if (!$this->session->userdata('loggedIn') && ($message == "Login Gagal")) { ?>

	var tombolku2 = document.getElementById('tombolku2');
	var modal = document.getElementById("myModal1");

	modal.setAttribute('style', 'display: block');

	<?php } ?>

	var btn = document.getElementById("myBtn");
	var span = document.getElementById("silang");

	span.onclick = function () {
		modal.setAttribute('style', 'display: none');
	}

	updateTanggal();

	var modalpaket = document.getElementById("myModalPaket");
	var spanpaket = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal
	infopaket = function () {
		modalpaket.style.display = "block";
	}

	tunggubayar = function () {
		window.open("<?php echo base_url();?>payment/tunggubayarpaket/1", "_self");
	}

	// When the user clicks on <span> (x), close the modal
	spanpaket.onclick = function () {
		modalpaket.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function (event) {
		if (event.target == modalpaket) {
			modalpaket.style.display = "none";
		}
	}

</script>
