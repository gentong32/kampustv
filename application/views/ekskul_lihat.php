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

$namaku = "KELAS VIRTUAL TVSEKOLAH";


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
		$thumbnail[$jmldaf_list] = "<?php echo base_url(); ?>uploads/thumbs/" . $thumbnail[$jmldaf_list];
	}

	$pilihok [$jmldaf_list] = base_url() . "assets/images/pilihok.png";

	$displayopsi0 = "none";
	$displayopsi1 = "none";


	if ($id_playlist == $datane->link_list) {
		$statuspaket = $datane->status_paket;
		$namapaket = $datane->nama_paket;
		$tglvicon = new DateTime($datane->tglvicon);
		$tanggale = $namahari[$tglvicon->format("N")] . ", " . $tglvicon->format("d") .
			" " . $namabulan[$tglvicon->format("n")] . " " . $tglvicon->format("Y");
		$jame = $tglvicon->format("H:i") . " WIB";
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
						<h1>Ekstrakurikuler Majalah Dinding</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="mt0 sm-mt-0">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div id="jamsekarang"
						 style="font-weight: bold;color: black;"
						 id="jam">
						&nbsp;
					</div>
				</div>
				<div style="margin-bottom: 10px;">
					<div>
						<center><h3><?php echo $namapaket; ?></h3>
						</center>
					</div>
				</div>

			</div>

		</div>

		<div style="color: black;">
			<center>
				<div class="row">
					<div
						style="max-width: 600px;margin:auto;margin-top:10px;text-align:center;margin-left:auto;margin-right: auto;">

						<div id="layartancap" class="embed-responsive embed-responsive-16by9">
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


					</div>


				</div>

				<div style="margin:auto;margin-top:20px;margin-bottom:10px;text-align: center">
					<button class="btn-main" onclick="kembaliya()">Kembali
					</button>
				</div>

			</center>

		</div>

	</section>
</div>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="<?php echo base_url();?>/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="<?php echo base_url();?>/js/dataTables.responsive.min.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
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
		//			if ($jml_list > 1)
		//				echo "idvideolain = idvideolain + idvideo[" . $jml_list . "]; \r\n";
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
				playlist: <?php echo "idvideolain";?>,
			},
			events: {
				//onReady: initialize
			}
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

	function kembaliya() {
		window.history.back();
	}


</script>
