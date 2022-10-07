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

$jml_list = 0;
$jmldaf_list = 0;

foreach ($dafplaylist as $datane) {
	$jmldaf_list++;

	$iddaflist[$jmldaf_list] = $datane->id_paket;
	$id_videodaflist[$jmldaf_list] = $datane->link_list;
	$nama_playlist[$jmldaf_list] = $datane->nama_paket;

	$idvideoawal[$jmldaf_list] = $datane->judul;
	$durasidaf[$jmldaf_list] = $datane->durasi_paket;
	$thumbnail[$jmldaf_list] = $datane->thumbnail;
	if (substr($thumbnail[$jmldaf_list], 0, 4) != "http") {
		$thumbnail[$jmldaf_list] = "<?php echo base_url(); ?>uploads/thumbs/" . $thumbnail[$jmldaf_list];
	}

	$pilihok [$jmldaf_list] = base_url() . "assets/images/pilihok.png";

	$namapaket = $datane->nama_paket;

	if ($id_playlist == $datane->link_list) {
		$statuspaket = $datane->status_paket;
		$namapaket = $datane->nama_paket;
		$tglvicon = new DateTime($datane->tglvicon);
		$thumbspaket = $thumbnail[$jmldaf_list];
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
						<h1>Kelas Virtual</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt20">
		<div class="container">
			<div style="padding-bottom:0px;margin-bottom: 0px;">
				<?php if ($this->session->userdata('a01')) { ?>
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>bimbel/modul_saya/<?php
							if ($this->session->userdata("a01"))
								echo $iduserolehadmin;?>'">Daftar Modul Bimbel
					</button>
				<?php }
				else
					{ ?>
						<button class="btn-main"
								onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/bimbel'">Daftar Modul Bimbel
						</button>
				<?php } ?>

			</div>
			<hr>
				<div class="col-lg-6 col-md-6 col-sd-6 offset-lg-3 offset-md-3 offset-sd-3">
					<div style="text-align: center;">
						<h3><?php echo $namapaket; ?></h3>
					</div>
					<div id="layartancap" class="ratio ratio-16x9">
						<div class="videomodul" style="max-width: 100%; max-height: 100%;" id="isivideoyoutube">

						</div>
					</div>
				</div>
		</div>
	</section>
</div>

<script src="https://www.youtube.com/iframe_api"></script>

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
	<?php } else { ?>
	function kembaliya() {
		window.open("<?php echo base_url();?>channel/playlistbimbel/<?php echo $linklistevent;?>", "_self");
	}
	<?php } ?>

	function vicon(jenis, link_list) {
		window.open("<?php echo base_url();?>bimbel/jitsi/" + jenis + "/" + link_list, '_self');
	}


</script>
