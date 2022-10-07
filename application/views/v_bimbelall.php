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
	$namamapel[$jmldaf_list] = $datane->nama_mapel;
	$kelas[$jmldaf_list] = substr($datane->nama_kelas,6)." / ".$datane->semester;


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

	$tandaeceran[$jmldaf_list] = "";
	if ($datane->kode_beli != null) {
		if (substr($datane->kode_beli,4,1)=="3")
			$tandaeceran[$jmldaf_list] = base_url() . "assets/images/starpremium.png";
		else if (substr($datane->kode_beli,4,1)=="4")
			$tandaeceran[$jmldaf_list] = base_url() . "assets/images/starprivat.png";
	}

//	echo "No. ".$jmldaf_list." : ".$tandaeceran[$jmldaf_list]."<br>";

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
	$displayopsieceran[$jmldaf_list] = "none";

	if ($datane->dikeranjang == 1) {
		$displayopsi1[$jmldaf_list] = "block";
	} else if (substr($datane->kode_beli,0,3) == "ECR") {
		$displayopsieceran[$jmldaf_list] = "block";
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

if ($this->session->userdata('bimbel') == 2
	|| $this->session->userdata('a01'))
	$bolehchat = true;
else
	$bolehchat = false;

//$halaman = 1;
//if (isset($page)) {
//	$halaman = $page / 8 + 1;
//}

//echo "TOTAL DATA:".$total_data;

if (!isset($halaman))
	$halaman=1;
$page = $halaman;
$seimbang = 2;
$pembagi = intval(($halaman - 1) / 8);
$kloter = $pembagi + 1;
$kloterakhir = intval(($total_data - 1) / 8) + 1;
$batasawal = ($pembagi * 8) + 1;

if(!isset($njenjang))
{
	$njenjang = $jenjang;
}

if(!isset($nkelas))
{
	$nkelas = "";
}

if(!isset($nmapel))
{
	$nmapel = $mapel;
}

if ($kloter == $kloterakhir) {
	$batasakhir = $kloterakhir;
} else
	if ($kloter<5)
		if ($kloterakhir>=5)
			$batasakhir = 5;
		else
			$batasakhir = $kloterakhir;
	else
		$batasakhir = $kloter * 5;

//echo "BATASAKHIR:".$batasakhir;

$halprev = $halaman - 1;
$halnext = $halaman + 1;


if ($halaman > 3) {
	if (($halaman + $seimbang) <= $kloterakhir) {
		$batasawal = $halaman - $seimbang;
		$batasakhir = $halaman + $seimbang;
	} else {
		$batasawal = $kloterakhir - 4;
		$batasakhir = $kloterakhir;
	}
}

$alamat = "";

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
			<div class="row">

				<div class="row">
					<div class="col-lg-12">
						<div id="jamsekarang"
							 style="font-weight: bold;color: black;padding-bottom:10px;padding-top:5px;float: right; margin-right: 20px"
							 id="jam">
							&nbsp;
						</div>
					</div>
				</div>

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
						<div class="modalpaket-footer">

							<?php if ($ambilpaket == "paket Lite" || $ambilpaket == "paket Pro") { ?>
								<center>
									<button onclick="window.open('<?php echo base_url() . "bimbel/pilih_paket/"; ?>','_self')"
											class="btn-ijo">Upgrade Paket
									</button>
								</center>
							<?php } ?>
						</div>
					</div>

				</div>

				<center><span
						style="color:#000000;font-size:18px;font-weight: bold;">BIMBEL ONLINE</span>
					<br>
					[<?php echo $total_data; ?> modul]<br>
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
					} else { ?>
					<button class="btn-toska" style="padding:10px;padding-top:0px;padding-bottom:0px;"
							onclick="window.open('<?php echo base_url().'bimbel/pilih_paket';?>','_self');"><span
							style="font-size: 16px;">Beli Paket Dulu</span></button>
					<?php }?>
					<br>
					<span
						style="color:black;font-size: 13px;font-style:italic;font-weight: bold ;"><?php echo "(" . $totalaktif . " modul aktif)"; ?></span>
					<?php if ($totalkeranjang > 0 && $expired == false) { ?>
						<br>
						<div style="margin-bottom: 10px;">
						<button class="btn-ijo" onclick="return konfirmpilih();">
							Konfirmasi <?php echo $totalkeranjang; ?> modul pilihan
						</button>
						</div>
					<?php } ?>
				</center>
				<div class="row" style="text-align:center;width:100%">

					<div id="isijenjang"
						 style="text-align:center;width:250px;display:inline-block;padding-bottom: 5px;">
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

			</div>


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
		</div>
	</section>

	<div class="bgimg3" style="text-align: center;width: 100%;">
		<!--	<span style="font-weight: bold;color: black">MICRO LEARNING TERBARU</span>-->

		<div class="row">

			<?php for ($a1 = 1; $a1 <= $jmldaf_list; $a1++) {
				$judulTitle = ucwords(strtolower($nama_playlist[$a1]));
				if (strlen($judulTitle) > 72) {
					$judulTitle = substr(ucwords(strtolower($nama_playlist[$a1])), 0, 72) . ' ...';
				} ?>

				<div id="vidiocol" class="col-lg-3 col-md-3 col-sm-6 col-xs-2">

					<div class="video__item">
						<div>
							<?php
//							if ($gembok1[$a1]=="" || $ambilpaket != "belum punya paket"
//							|| $tandaeceran[$a1] !="")
							{?>
							<a href="<?php echo base_url() . 'bimbel/get_bimbel/' . $id_videodaflist[$a1]; ?>">
								<?php } ?>
								<img src="<?php echo $thumbnail[$a1]; ?>" class="lazy video__item_preview" alt="">
								<?php if ($ambilpaket != "belum punya paket") {?>
							</a>
						<?php } ?>
						</div>
						<?php if ($tandaeceran[$a1]!="") { ?>
							<div style="max-width:40px;display:<?php echo $displayopsieceran[$a1];?>;font-size:11px;color:white;position: absolute;top:10px;left:20px;bottom:10px"><img width="10px" height="auto" src="<?php echo $tandaeceran[$a1];?>"></div>
						<?php } ?>
						<?php if ($gembok1[$a1]!="") { ?>
						<div style="max-width:25px;display:<?php echo $displayopsi0[$a1];?>;font-size:11px;color:white;position: absolute;top:10px;left:20px;bottom:10px"><img width="10px" height="auto" src="<?php echo $gembok1[$a1];?>"></div>
						<?php } ?>
						<?php if ($gembok2[$a1]!="") { ?>
						<div style="max-width:25px;font-size:11px;color:white;position: absolute;top:10px;left:30px;bottom:10px"><img width="20px" height="auto" src="<?php echo $gembok2[$a1];?>"></div>
						<?php } ?>
						<?php if ($pilihok[$a1]!="") { ?>
						<div style="max-width:25px;display:<?php echo $displayopsi1[$a1];?>;font-size:11px;color:white;position: absolute;top:10px;left:18px;bottom:10px"><img width="15px" height="auto" src="<?php echo $pilihok[$a1];?>"></div>
						<?php } ?>

						<div class="spacer-single"></div>

						<div class="video__item_info">
							<a href="<?php echo base_url() . 'bimbel/get_bimbel/' . $id_videodaflist[$a1]; ?>">
								<h4><?php echo $judulTitle; ?></h4>
								<span style="color:grey;font-weight: normal;font-size: smaller;font-style: italic"><?php
									echo $namamapel[$a1]." - ".$kelas[$a1];?></span>
							</a>

<!--							<div class="video__item_action">-->
<!--								<a href="--><?php //echo base_url() . 'bimbel/get_bimbel/' . $id_videodaflist[$a1]; ?><!--">Lihat-->
<!--									sekarang</a>-->
<!--							</div>-->
<!--							<div class="video__item_like">-->
<!--								<i class="fa fa-heart"></i><span>50</span>-->
<!--							</div>-->
						</div>
					</div>

				</div>

			<?php }
			?>
			<div>
				<center>
					<div style="text-align: center;margin-left: auto; margin-right: auto; margin-bottom: 60px;">

						<nav aria-label="pagination">
							<ul class="pagination" style="justify-content: center;text-align: center">
								<?php if ($halaman == 1 || $halaman == 0) { ?>

								<?php } else {
									if ($asal == "page") { ?>
										<li><a href="<?php echo base_url() . "bimbel/page/" . $halprev; ?>">Prev</a>
										</li>
									<?php }
									else if($asal == "kelas")
									{ ?>
										<li><a href="<?php echo base_url() . "bimbel/mapel/" . $jenjangpendek . "/".$nkelas."/hal/" . $halprev; ?>">Prev</a>
										</li>
									<?php }
									else if($asal == "jenjang")
									{ ?>
										<li><a href="<?php echo base_url() . "bimbel/mapel/" . $jenjangpendek ."/hal/".$halprev; ?>">Prev</a>
										</li>
									<?php }
									else if($asal == "mapelnya")
									{ ?>
										<li><a href="<?php echo base_url() . "bimbel/mapel/" . $jenjangpendek ."/".$nkelas."/".$mapel."/hal/".$halprev; ?>">Prev</a>
										</li>
									<?php }
								}
								?>
								<?php for ($i = $batasawal; $i <= $batasakhir; $i++) { ?>
									<li <?php
									if ($i == $halaman)
										echo "class='active' "; ?>><a href="<?php
										if ($i == $halaman)
											echo "#";
										else if ($i == 1) {
											if($asal == "page")
												echo base_url() . "bimbel/page/1";
											else if($asal == "jenjang")
												echo base_url() . "bimbel/mapel/".$jenjangpendek;
											else if($asal == "kelas")
												echo base_url() . "bimbel/mapel/".$jenjangpendek . "/".$nkelas;
											else if($asal == "mapelnya")
												echo base_url() . "bimbel/mapel/".$jenjangpendek . "/".$nkelas. "/".$mapel;
											else if($asal == "cari")
												echo base_url() . "bimbel/cari/" . $kuncine;
										}
										else {
											if($asal == "page")
												echo base_url() . "bimbel/page/".$i;
											else if($asal == "jenjang")
												echo base_url() . "bimbel/mapel/".$jenjangpendek."/hal/".$i;
											else if($asal == "kelas")
												echo base_url() . "bimbel/mapel/".$jenjangpendek . "/".$nkelas."/hal/" . $i;
											else if($asal == "mapelnya")
												echo base_url() . "bimbel/mapel/".$jenjangpendek . "/".$nkelas."/".$mapel."/hal/" . $i;
											else if($asal == "cari")
												echo base_url() . "bimbel/cari/" . $kuncine . "/" . $i;
										} ?>"><?php echo $i;?>
										</a></li>
								<?php }
								?>
								<?php if ($halnext <= $kloterakhir) { ?>
									<li><a href="<?php
										if($asal == "page")
											echo base_url() . "bimbel/page/".$halnext;
										else if($asal == "mapelnya")
											echo base_url() . "bimbel/mapel/" . $jenjangpendek . "/".$nkelas. "/".$mapel."/hal/" . $halnext;
										else if($asal == "kelas")
											echo base_url() . "bimbel/mapel/" . $jenjangpendek . "/".$nkelas."/hal/" . $halnext;
										else if($asal == "jenjang")
											echo base_url() . "bimbel/mapel/" . $jenjangpendek ."/hal/".$halnext;
										else if($asal == "cari")
											echo base_url() . "vod/" . $alamat . "/" . $halnext;
										?>">Next</a></li>
								<?php } else { ?>

								<?php }
								?>

							</ul>

						</nav>
					</div>
				</center>
			</div>
		</div>

	</div>

</div>


<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->

<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
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
	localStorage.setItem("akhirbimbel", urlini);

	<?php
	if ($idliveduluan != "") {
	?>
	//var statuslive = <?php //echo $iddaflist[$idliveduluan];?>//;
	var statuslive = <?php echo $status[$idliveduluan];?>;
	var tgljadwal = new Date("<?php echo $tgl_tayang1[$idliveduluan];?>");
	<?php
	}

	//	if ($nyambung) {
	//		$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
	//		$fgc = @file_get_contents($url);
	//		if($fgc===FALSE)
	//		{
	//			$now = new DateTime();
	//			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
	//			$stampdate = $now->format("Y-m-d") ."T".$now->format("H:i:s");
	//		}
	//		else
	//		{
	//			$obj = json_decode($fgc, true);
	//			$stampdate = substr($obj['datetime'], 0, 19);
	//		}
	//		echo "var tglnow = new Date('" . $stampdate . "');";
	//	}
	//	else
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
		echo "var tglnow = new Date('" . $stampdate . "');";
	}

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
	detikke[1] = '<?php echo substr($tgl_tayang1[$idliveduluan], 11, 8);?>';
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
			$('#keteranganLive').html("SEGERA TAYANG TANGGAL: <?php if ($id_playlist == null)
				echo $tgl_tayang[$idliveduluan]; else
				echo $tayangpaket; ?>");
			$('#divnamapaket').show();
			$('#keteranganLive').show();
			$('#infolive<?php echo $idliveduluan;?>').html("Segera Tayang");


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
		initialize();
		<?php
		/*echo "console.log('".$id_playlist."'); \r\n";
		echo "console.log('status:".$status[1]."'); \r\n";*/
		if (($id_playlist != null && $statuspaket == 2)) {
			echo "loadplayer(); \r\n";
		}?>
	}

	function loadplayer() {
		idvideolain = "";
		<?php
		if ($id_playlist != null) {
			for ($x = 2; $x < $jml_list; $x++)
				echo "idvideolain = idvideolain + idvideo[" . $x . "]+','; \r\n";
		}
		if ($jml_list > 1)
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
				//onReady: initialize
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
			url: "<?php echo base_url();?>channel/gantistatuspaketbimbel",
			method: "POST",
			data: {id: <?php echo $iddaflist[$idliveduluan];?>},
			success: function (result) {
				statuslive = 1;
				//detik2=0;
			}
		})
	}

	<?php } ?>


</script>


<script src="<?php echo base_url() ?>js/jquery-ui.js"></script>


<script>

	var namakelas = Array();
	var idjenjang = Array();

	var modalpaket = document.getElementById("myModalPaket");
	var spanpaket = document.getElementsByClassName("close")[0];
	// var btn = document.getElementById("myBtn");
	// var span = document.getElementById("silang");


	<?php
	if ($njenjang > 0) {
		for ($a = 1; $a <= sizeof($dafkelas); $a++) {
			echo "namakelas[" . $a . "] = '" . $namakelas[$a] . "';\n";
			echo "idjenjang[" . $a . "] = " . $idjenjang[$a] . ";\n";
		}
	}
	?>

	$(document).on('change input', '#isearch', function () {
		$.ajax({
			type: 'GET',
			data: {jenjang: "<?php echo $njenjang;?>", kelas: "<?php echo $nkelas;?>",mapel: "<?php echo $nmapel;?>", kunci: $('#isearch').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>bimbel/get_autocomplete2',
			success: function (result) {
				autocomplete_example2 = new Array();
				var jdata=0;
				$.each(result, function (i, result) {
					jdata++;
					autocomplete_example2[jdata] = result.value;
				});

				set_autocomplete('isearch', 'form2_complete', autocomplete_example2, start_at_letters=2);
			}
		});
	});

	$(document).ready(function () {
		$('#isearch').autocomplete({
			source: '<?php echo(site_url() . "bimbel/get_autocomplete");?>',
			minLength: 1,
			select: function (event, ui) {
				$('#isearch').val(ui.item.value);
				//$('#description').val(ui.item.deskripsi);
			}
		});
	});

	$(document).on('change', '#ijenjang', function () {

		if ($('#ijenjang').val() == "kategori") {
			window.open("<?php echo base_url(); ?>bimbel/kategori/pilih", "_self");
		} else if ($('#ijenjang').val() != "0") {
			window.open("<?php echo base_url(); ?>bimbel/mapel/" + $('#ijenjang').val(), "_self");

		} else {
			window.open("<?php echo base_url(); ?>bimbel/", "_self");
		}
	});

	$(document).on('change', '#ikelas', function () {
		window.open("<?php echo base_url(); ?>bimbel/mapel/" + $('#ijenjang').val() + "/" + $('#ikelas').val() + "/" + $('#imapel').val(), "_self");
	});

	$(document).on('change', '#imapel', function () {
		//alert ($('#imapel').val());
		window.open("<?php echo base_url(); ?>bimbel/mapel/" + $('#ijenjang').val() + "/" + $('#ikelas').val() + "/" + $('#imapel').val(), "_self");
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
		window.open('<?php echo base_url(); ?>bimbel/cari/' + $('#isearch').val(), '_self');

	}

	function konfirmpilih() {
		var r = confirm("Sudah yakin akan pilihan ini?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url();?>bimbel/konfirmpilihan",
				method: "POST",
				data: {},
				success: function (result) {
					if (result == "sukses") {
						window.location.reload();
					} else if (result == "expired")
						alert("Paket expired, silakan beli paket baru lagi!");
					else
						alert("Ada masalah! Hubungi admin!");
				}
			})
		} else {
			return false;
		}
		return false;
	}

	function infopaket() {
		modalpaket.style.display = "block";
		//alert("Untuk <?php //echo $ambilpaket;?>// bisa memilih hingga <?php //echo $totalmaksimalpilih;?>// paket materi. Berlaku hingga <?php //echo $tglbatas;?>//.");
		return false;
	}

	function tunggubayar() {
		window.open("<?php echo base_url();?>payment/tunggubayarpaket/3", "_self");
	}

	spanpaket.onclick = function () {
		modalpaket.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function (event) {
		if (event.target == modalpaket) {
			modalpaket.style.display = "none";
		}
	}

	// span.onclick = function () {
	// 	modal.setAttribute('style', 'display: none');
	// }

</script>

