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

foreach ($infoguru as $datane) {
	$npsnku = $datane->npsn;
	$idguru = $datane->id;
	$nama_sekolahku = $datane->sekolah;
	$namaku = $datane->first_name . ' ' . $datane->last_name;
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

$lampiran = "Ada";
if ($filemateri == "") {
	$lampiran = "Tidak ada";
}

if ($this->session->userdata("loggedIn")) {
	$skor = $nilaiuser->score;
	$hiskor = $nilaiuser->highscore;
	if ($skor == "") {
		$skor = "-";
		$hiskor = "-";
	}
} else {
	$skor = 0;
	$hiskor = 0;
}

?>


<div class="container bgimg3" style="margin-top: 0px;width: 100%">

	<div style="background-color:#aabfb8;margin-top: 65px;padding-bottom:10px;">
		<div class="row">
			<div class="col-lg-12">
				<div id="jamsekarang"
					 style="font-weight: bold;color: black;padding-bottom:10px;padding-top:5px;float: right; margin-right: 20px"
					 id="jam">
				</div>
			</div>
		</div>
		<center>
			<div style="font-size: 20px;font-weight: bold;color: black;"><?php echo $namapaket; ?></div>
			<div style="font-size: 12px;font-style: italic;color: black;">[<?php echo $pengunggah; ?>]</div>
		</center>
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

	<div class="row"
		 style="width:100%;display:inline-block;vertical-align:middle;color:black;margin-top:15px;padding-top:10px;">
		<div
			style="display:inline-block;width: 45%;margin-right:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">
			<?php if ($uraianmateri != "") { ?>
				<div style="color:black;">
					<button style="font-weight:bold;height:50px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"
							onclick="bukamateri();">URAIAN MATERI
					</button>
				</div>
				<div style="color:black;">
					<table border="0" width="100%" style="text-align: center">
						<tr style="font-weight: bold">
							<td width="50%">Lampiran</td>
						</tr>
						<tr>
							<td width="50%"><?php echo $lampiran; ?></td>
						</tr>
					</table>
				</div>
			<?php } else { ?>
				<div style="color:black;padding-top: 15px;height:100px;padding-bottom: 20px;">
					Uraian materi belum dibuat!
				</div>
			<?php } ?>
		</div>

		<div
			style="display:inline-block;width: 45%;margin-left:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">
			<?php if ($statussoal == 1) { ?>
				<div style="color:black;">
					<button style="font-weight:bold;height:50px;width:100%;margin-top:0px;
			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"
							onclick="kerjakansoal();">SOAL
					</button>
				</div>
				<div style="color:black;">
					<table border="0" width="100%" style="text-align: center">
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
				<div style="color:black;padding-top: 15px;height:100px;padding-bottom: 20px;">
					Soal belum dipublish!
				</div>
			<?php } ?>
		</div>

		<!--		<div-->
		<!--			style="margin-top:20px;display:inline-block;width: 45%;margin-left:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">-->
		<!--			--><?php //if ($statussoal == 1) { ?>
		<!--				<div style="color:black;">-->
		<!--					<button style="font-weight:bold;height:50px;width:100%;margin-top:0px;-->
		<!--			margin-bottom:10px;border: #5faabd 1px solid ;background-color: #c5fbd7"-->
		<!--							onclick="kerjakansoal();">CHAT dengan Teman-->
		<!--					</button>-->
		<!--				</div>-->
		<!--				<div style="color:black;">-->
		<!--					<table border="0" width="100%" style="text-align: center">-->
		<!--						<tr style="font-weight: bold">-->
		<!--							<td width="50%">Jumlah online</td>-->
		<!--						</tr>-->
		<!--						<tr>-->
		<!--							<td width="50%">15</td>-->
		<!--						</tr>-->
		<!--					</table>-->
		<!--				</div>-->
		<!--			--><?php //} else { ?>
		<!--				<div style="color:black;padding-top: 15px;padding-bottom: 20px;">-->
		<!--					Soal belum dipublish!-->
		<!--				</div>-->
		<!--			--><?php //} ?>
		<!--		</div>-->

	</div>

	<div style="margin-top: 20px;margin-bottom: 20px">
		<button class="myButtonDonasi" style="padding: 5px 10px 5px 10px;" onclick="kembaliya()">Kembali
		</button>
	</div>

</div>


<div id="myModal1" class="modal2">
	<!-- Modal content -->
	<div class="modal2-content">

		<p style="text-align:center;font-size: medium">USER NAME dan PASSWORD yang Anda masukkan salah.<br>
			Silakan gunakan username dan password yang valid.<br><br>
			<button id="silang">Tutup</button>
		</p>
	</div>
</div>

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url() ?>js/jquery-ui.js"></script>

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
			for ($x = 2; $x < $jml_list; $x++)
				echo "idvideolain = idvideolain + idvideo[" . $x . "]+','; \r\n";
		}
		if ($jml_list > 1)
			echo "idvideolain = idvideolain + idvideo[" . $jml_list . "]; \r\n";
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
		window.open("<?php echo base_url();?>channel/guru/chusr<?php echo $kd_user;?>", "_self");
	}

	function kerjakansoal() {
		<?php if($masuk==0)
		{?>
		alert("Silakan login terlebih dahulu!");
		<?php } else
		{ ?>
		window.open("<?php echo base_url();?>channel/soal/<?php echo $id_playlist . '/' . $asal;?>", "_self");
		<?php } ?>

	}

	function bukamateri() {
		window.open("<?php echo base_url();?>channel/materi/tampilkan/<?php echo $id_playlist;?>", "_self");
	}

</script>
