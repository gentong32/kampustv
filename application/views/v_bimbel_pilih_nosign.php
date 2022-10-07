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

$namaku = "BIMBEL TVSEKOLAH";

$jmldaf_list = 0;
$statuspaket = 1;
$namapaket = "";

foreach ($dafplaylist as $datane) {
	$jmldaf_list++;

	$iddaflist[$jmldaf_list] = $datane->id_paket;
	$id_videodaflist[$jmldaf_list] = $datane->link_list;
	$nama_playlist[$jmldaf_list] = $datane->nama_paket;
	$status[$jmldaf_list] = $datane->status_paket;

	$deskripsi[$jmldaf_list] = $datane->deskripsi_paket;

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

	$gembok1[$jmldaf_list] = base_url() . "assets/images/gembok_merah.png";

	$gembok2[$jmldaf_list] = "";
	if ($datane->statussoal == 0 || $datane->uraianmateri == "" || $datane->statustugas == 0) {
		$gembok2[$jmldaf_list] = base_url() . "assets/images/gembok_nila.png";
	}

	$pilihok [$jmldaf_list] = base_url() . "assets/images/pilihok.png";

	$displayopsi0 = "block";
	$displayopsi1 = "none";

	if ($expired == true) {
		$teksmasukin = "Pilih Paket Dahulu";
	}

	$namapaket = $datane->nama_paket;
	$thumbspaket = $thumbnail[$jmldaf_list];

}

$eceran = false;

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

				</div>

				<hr>

				<div class="container">
					<div class="row" style="margin-left: -25px; margin-right:-25px">
						<div class="col-lg-6 col-md-6 col-sd-12 offset-lg-3 offset-md-3">
							<div style="margin-top:10px;text-align:center;margin-left:auto;margin-right: auto;">
								<?php
								if ($gembok1[1] != "")
								{
									if ($gembok2[1] == "") {
										?>
										<div style="position:relative;max-width: 400px;margin:auto;">
											<div style="max-width:500px;font-size:13px;background-color:black;color:white;
					position: absolute;right:15px;bottom:25px"><?php echo $durasidaf[1]; ?></div>
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
<!--										<div>-->
<!--											--><?php //if ($expired == true) { ?>
<!--												<button class="btn-blue" id="tbmasukin"-->
<!--														style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: -20px;margin-bottom: -20px;"-->
<!--														onclick="pilihpaket()">--><?php //echo $teksmasukin; ?>
<!--												</button>-->
<!---->
<!--											--><?php //}  ?>
<!--										</div>-->

										<div style="border: solid 1px grey;max-width: 400px;margin-top:0px;margin-bottom:5px;
										margin-left: auto;margin-right:auto;">
											<?php echo $deskripsi[1];?>
										</div>

										<div>
											<?php if ($eceran == false) { ?>
												<button class="btn-blue" id="tbeceran"
														style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: 20px;margin-bottom: 20px;"
														onclick="piliheceran()">Eceran
												</button>

											<?php } else {

											} ?>
										</div>

										<?php
									} else { ?>
										<div style="position:relative;max-width: 500px;margin:auto;">
											<div style="max-width:500px;font-size:13px;background-color:black;color:white;
					position: absolute;right:20px;bottom:25px"><?php echo $durasidaf[1]; ?></div>
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
								<div id="layartancap" <?php
								if ($status[1] == 2 && $id_playlist == null)
									//JIKA GAK ADA YANG MAU TAYANG
									echo 'style="display:none";' ?>" class="iframe-container embed-responsive
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

					</div>
				</div>
			</div>
	</section>
</div>


<script>

	var player;
	var idvideo = new Array();
	var filler = new Array();
	var jatah = 0;
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
	var detiklokal = 0;
	var tgl, bln, thn, jam, menit, detik, jmmndt;

	<?php
	$now = new DateTime();
	$now->setTimezone(new DateTimezone('Asia/Jakarta'));
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
				onReady: initialize
			}
		});
	}

	function initialize() {
		$(function () {
			loadjitsi();
		});

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


	function pilihpaket() {
		window.open("<?php echo base_url().'bimbel/pilih_paket/'.$id_videodaflist[1];?>", "_self");
	}

	function piliheceran() {
		window.open("<?php echo base_url().'bimbel/pilih_eceran/'.$id_videodaflist[1];?>", "_self");
	}

</script>
