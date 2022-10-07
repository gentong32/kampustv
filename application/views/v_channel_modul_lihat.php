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

if (!isset($opsi))
	$opsi="";

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
		$jame = $tglvicon->format("H:i")." WIB";
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

if ($linklistevent == null) {
	$bolehchatsekolah = true;
	$bolehchat = true;
} else {
	$bolehchatsekolah = false;
	$bolehchat = false;
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
	<div style="background-color:#aabfb8;">
		<div class="row">
			<div class="col-lg-12">
				<div id="jamsekarang"
					 style="font-weight: bold;color: black;"
					 id="jam">
					&nbsp;
				</div>
			</div>
		</div>
		<center>
			<div style="font-size: 20px;font-weight: bold;color: black;"><?php echo $namapaket; ?></div>
			<div style="font-size: 12px;font-style: italic;color: black;">[oleh: <?php echo $namaku; ?>]</div>
			<?php if ($bolehchatsekolah == true) { ?>
				<div style="padding:5px; text-align:center; margin: auto;">
					<?php if ($jenis == "sekolah") { ?>
						<button class="btn-ijo"
								onclick="window.open('<?php echo base_url(); ?>channel/chat/sekolah','_blank')">Forum
							Diskusi Sekolah
						</button>
					<?php } else { ?>
						<button class="btn-ijo"
								onclick="window.open('<?php echo base_url(); ?>channel/chat/bimbel','_blank')">Forum
							Diskusi Bimbel
						</button>
					<?php } ?>
				</div>
			<?php } ?>
		</center>
	</div>

	<div style="color: black;">
		<div id="LayoutGridPilih">
			<div class="row">
				<div class="col-1">
					<div
						style="max-width: 600px;margin:auto;margin-top:10px;text-align:center;margin-left:auto;margin-right: auto;">


						<div id="layartancap" class="iframe-container embed-responsive
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

						<div style="border: #0f74a8 1px solid;margin-top:20px;padding:20px;">
							<b>JADWAL VICON<br><br>
								<?php echo $tanggale; ?><br>
								<?php echo $jame; ?></b><br>

							<?php if ($adavicon == "ada") { ?>
								<div style="margin-top:10px;">
									<button
										onclick="vicon('<?php echo $jenis; ?>','<?php echo $id_videodaflist[1]; ?>')"
										class="btn-blue">VICON
									</button>
								</div>
							<?php } ?>
						</div>

					</div>

				</div>
				<div class="col-2">
					<?php if ($bolehchat == true) {
						echo "<hr style='margin-top:9px;border: 1px solid black;'>";
						include "v_chat.php";
					}
					?>
				</div>
			</div>

			<div style="margin:auto;margin-top:20px;margin-bottom:10px;text-align: center">
				<button class="myButtonDonasi" style="padding: 5px 10px 5px 10px;" onclick="kembaliya()">Kembali
				</button>
			</div>

		</div>

	</div>

			</div>
		</div>
	</section>
</div>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

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

	<?php if ($jenis == "sekolah") { ?>
	function kembaliya() {
		window.history.back();
		//window.open("<?php echo base_url();?>channel/playlistguru/<?php echo $linklistevent;?>", "_self");
	}
	<?php } else if ($opsi == "bimbel"){ ?>
	function kembaliya() {
		window.open("<?php echo base_url();?>virtualkelas/bimbel", "_self");
	}
	<?php } else { ?>
	function kembaliya() {
		window.open("<?php echo base_url();?>channel/playlistbimbel/<?php echo $linklistevent;?>", "_self");
	}
	<?php } ?>

	function vicon(jenis, link_list) {
		window.open("<?php echo base_url();?>bimbel/jitsi/" + jenis + "/" + link_list, '_self');
	}


</script>
