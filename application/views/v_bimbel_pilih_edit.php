<style>
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
		$thumbnail[$jmldaf_list] = base_url()."uploads/thumbs/" . $thumbnail[$jmldaf_list];
	}

	$gembok1[$jmldaf_list] = "";
	if ($datane->link_paket == null)
		$gembok1[$jmldaf_list] = base_url() . "assets/images/gembok_merah.png";

	$gembok2[$jmldaf_list] = "";
	if ($datane->statussoal == 0 || $datane->uraianmateri == "") {
		$gembok2[$jmldaf_list] = base_url() . "assets/images/gembok_nila.png";
	}

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

	if ($expired==true) {
		$teksmasukin = "Pilih Paket Dahulu";
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

$skor = $nilaiuser->score;
$hiskor = $nilaiuser->highscore;

$lampiran = "Ada";
if ($filemateri == "") {
	$lampiran = "Tidak ada";
}


if ($skor == "") {
	$skor = "-";
	$hiskor = "-";
}

if ($this->session->userdata('bimbel') == 3
	|| $this->session->userdata('a01'))
	$bolehchat = true;
else
	$bolehchat = false;

$arrayjenis = array("", "sekolah", "", "bimbel");
$njenis = $jenis;
$jenis = $arrayjenis[$jenis];

?>


<div class="container bgimg3" style="margin-top: 0px;width: 100%">

	<div style="background-color:#aabfb8;margin-top: 45px;padding-bottom:10px;">
		<div class="row">
			<div class="col-lg-12">
				<div id="jamsekarang"
					 style="font-weight: bold;color: black;padding-bottom:10px;padding-top:5px;float: right; margin-right: 20px"
					 id="jam">
					&nbsp;
				</div>
			</div>
		</div>
		<center>
			<div style="font-size: 20px;font-weight: bold;color: black;"><?php echo $namapaket; ?></div>
			<div style="font-size: 12px;font-style: italic;color: black;">[oleh: <?php echo $pengunggah; ?>]</div>
		<?php if ($expired==false || $bolehchat==true) { ?>
			<div style="padding:5px; text-align:center; margin: auto;">
				<button class="btn-ijo" onclick="window.open('<?php echo base_url();?>channel/chat/bimbel','_blank')">Forum Diskusi Bimbel</button>
			</div>
		<?php }?>
		</center>
	</div>

	<div class="indukplay" style="margin-top:10px;text-align:center;margin-left:auto;margin-right: auto;">
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
						<img width="20px" height="auto" src="<?php echo $gembok1[1]; ?>"></div>
					<div id="opsi1"
						 style="display:<?php echo $displayopsi1; ?>;font-size:11px;color:white;position: absolute;top:16px;left:18px;bottom:10px">
						<img width="25px" height="auto" src="<?php echo $pilihok[1]; ?>"></div>
					<img style="margin-top:0px;margin-bottom:20px;width: 100%;max-width:400px" ; src="<?php
					if ($id_playlist == null)
						echo $thumbnail[$idliveduluan]; else
						echo $thumbspaket; ?>"/>
				</div>
				<div>
					<?php if($expired==true) {?>
						<button class="btn-blue" id="tbmasukin" style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: -20px;margin-bottom: -20px;"
						 onclick="pilihpaket()"><?php echo $teksmasukin; ?>
					</button>
					<?php } else { ?>
					<button <?php
					if ($totalkeranjang + $totalaktif >= $totalmaksimalpilih && $gembokorpilih == 0) {
						echo 'disabled class="btn-grey"';
					} else {
						echo 'class="btn-blue"';
					} ?> id="tbmasukin" style="margin:auto;max-width:300px; padding: 5px 10px 5px 10px;margin-top: -20px;margin-bottom: -20px;"
						 onclick="masukin()"><?php echo $teksmasukin; ?></button>
				<?php } ?>
				</div>
				<?php
			} else { ?>
				<div style="position:relative;max-width: 500px;margin:auto;">
					<div style="max-width:500px;font-size:13px;background-color:black;color:white;
					position: absolute;right:20px;bottom:35px"><?php echo $durasidaf[1]; ?></div>
					<div style="font-size:11px;color:white;position: absolute;top:10px;left:20px;bottom:10px">
						<img width="20px" height="auto" src="<?php echo $gembok1[1]; ?>"></div>
					<div style="font-size:11px;color:white;position: absolute;top:10px;left:30px;bottom:10px">
						<img width="20px" height="auto" src="<?php echo $gembok2[1]; ?>"></div>
					<img style="margin-top:0px;margin-bottom:20px;width: 100%;max-width:500px" ; src="<?php
					if ($id_playlist == null)
						echo $thumbnail[$idliveduluan]; else
						echo $thumbspaket; ?>"/>
				</div>

				<div class="row"
					 style="width:100%;display:inline-block;vertical-align:middle;color:black;margin-top:15px;padding-top:10px;">
					<div
						style="display:inline-block;width: 45%;margin-right:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">
						<div style="color:black;padding-top: 15px;height:100px;padding-bottom: 20px;">
							Uraian materi belum dibuat!
						</div>
					</div>

					<div
						style="display:inline-block;width: 45%;margin-left:10px;background-color:#bcddbc;border: #0f74a8 0px solid;">
						<div style="color:black;padding-top: 15px;height:100px;padding-bottom: 20px;">
							Soal belum dipublish!
						</div>
					</div>

				</div>

			<?php }
		} else {
		if ($jmldaf_list > 0) {
		?>
		<div id="layartancap" <?php
		if ($status[1] == 2 && $id_playlist == null)
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
	}
	?>

	<?php if ($gembok1[1] == "") { ?>
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
		</div>
	<?php } ?>

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
	var opsi = <?php echo $gembokorpilih;?>;

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
		if (localStorage.getItem("akhir"))
			window.open(localStorage.getItem("akhir"), "_self");
		else
			window.open("<?php echo base_url();?>bimbel/page/1", "_self");
	}

	function kerjakansoal() {
		window.open("<?php echo base_url();?>bimbel/soal/<?php echo $id_playlist . '/' . $asal;?>", "_self");
	}

	function bukamateri() {
		window.open("<?php echo base_url();?>bimbel/materi/tampilkan/<?php echo $id_playlist;?>", "_self");
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
		localStorage.setItem("linkakhirbeli","<?php echo $id_playlist;?>");
		window.open("<?php echo base_url();?>bimbel/pilih_paket", "_self");
	}

</script>
