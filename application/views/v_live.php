<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$namahari = array("MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUM'AT", "SABTU", "MINGGU");

$tglmulai = new DateTime($dafacara[0]->tanggal_mulai);
$stglmulai = $tglmulai->format("d-m-Y H:i");
$tglselesai = new DateTime($dafacara[0]->tanggal_selesai);
$stglselesai = $tglselesai->format("d-m-Y H:i");


$judul = $dafacara[0]->acara;

$ttombol1 = $dafacara[0]->tekslink1;
$ttombol2 = $dafacara[0]->tekslink2;
$ttombol3 = $dafacara[0]->tekslink3;
$turl1 = $dafacara[0]->link1;
$turl2 = $dafacara[0]->link2;
$turl3 = $dafacara[0]->link3;

if ($turl1 != "" && (substr($turl1, 0, 4) != "http"))
	$turl1 = base_url() . "event/spesial/pilihan/" . $turl1;

$tglsekarang = new DateTime();

if ($tglsekarang >= $tglmulai && $tglsekarang <= $tglselesai)
	$cekdisplay1 = "none";
else
	$cekdisplay1 = "block";

if ($cekdisplay1 == "block")
	$cekdisplay2 = "none";
else
	$cekdisplay2 = "block";


?>
<!--<input type="text" id="pitoff" name="pitoff" style="width:0px;font-size: 0px;top: -130px;">-->

<div class="container bgimg3" style="margin-top: 0px;width: 100%">
	<div class="row">
		<div class="col-lg-12" >
			<div id="jamsekarang"
				 style="font-weight: bold;color: black;padding-top:65px;float: right; margin-right: 20px" id="jam">
			</div>
		</div>
		<div style="width: 100%;margin-top: 50px;">
		<center><h3>LIVE EVENT</h3></center>
			<hr style="border: #375986 0.75px solid">
		</div>

		<div style="background-color: #375986; display: <?php echo $cekdisplay1; ?>; text-align: center;
			font-weight: bold;color:#f1ffda; max-width: 600px;width: 100%; margin: auto;padding: 30px;margin-bottom: 40px;">
			<h4>JADWAL LIVE EVENT</h4>
			<span style="font-size:14px;">
					<?php
						echo "<br>" . $dafacara[0]->jam;
						echo "<br>" . $dafacara[0]->acara . "<br><br><br>";
					?>
				</span>
		</div>
	</div>


	<div class="row" style="display: <?php echo $cekdisplay2; ?>; padding-bottom: 20px;">
		<div class="col-lg-8 col-md-8">
			<div class="row content-block">
				<center><h3><?php echo $judul;?></h3></center>
				<br>
				<div class="iframe-container embed-responsive embed-responsive-16by9">
					<div class="embed-responsive-item" style="width: 100%" id="isivideoyoutube"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4"
			 style="display: <?php echo $cekdisplay2; ?>; background-color: #f6f6f6;margin-bottom: 30px;">
			<div class="row content-block">
				<div>
					<center>
						<?php if ($turl1 != "") { ?>
							<button onclick="klik1()"
									style="margin-top: 5px;margin-bottom: 5px;" id="tombol1"
									class="btn-info"><?php echo $ttombol1; ?></button>
						<?php } ?>
						<?php if ($turl2 != "") { ?>
						<button onclick="klik2()"
								style="margin-top: 5px;margin-bottom: 5px;" id="tombol2"
								class="btn-info"><?php echo $ttombol2; ?></button>
						<?php } ?>
						<?php if ($turl3 != "") { ?>
						<button onclick="klik3()"
								style="margin-top: 5px;margin-bottom: 5px;" id="tombol3"
								class="btn-info"><?php echo $ttombol3; ?></button>
						<?php } ?>
					</center>
				</div>
				<div class="col-lg-12">
					<div style="text-align: center;font-weight: bold;font-size:16px;color:#000">
						<?php include "v_chat_simpel.php"; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="https://www.youtube.com/iframe_api"></script>
<script>

	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	alamaturl = youtube_parser("<?php echo $url_live->url; ?>");
	//alamaturl = youtube_parser("https://youtu.be/nCu-ifCXgyw");

	//alert (alamaturl);

	<?php

	$now = new DateTime();
	$now->setTimezone(new DateTimezone('Asia/Jakarta'));
	$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
	echo "var tglnow = new Date('" . $stampdate . "');";
	?>

	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
	var jamnow = tglnow.getTime();

	function initialize() {
		updateTanggal();
		<?php if ($tglsekarang >= $tglmulai && $tglsekarang <= $tglselesai){ ?>
		player.playVideo();
		<?php } ?>
	}

	$(function () {
		setInterval(updateTanggal, 1000);
	});

	function onYouTubeIframeAPIReady() {
		<?php if ($tglsekarang >= $tglmulai && $tglsekarang <= $tglselesai) {?>
		player = new YT.Player('isivideoyoutube', {
			width: 740,
			height: 500,
			videoId: alamaturl,
			showinfo: 0,
			controls: 0,
			autoplay: 1,
			playerVars: {
				color: 'white',
				playlist: alamaturl
			},
			events: {
				onReady: initialize
			}
		});
		<?php } ?>
	}

	function updateTanggal() {
		//alert ("SA");
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

		//if (durasi>0)
		//updatePlaying();
	}

	function klik1() {
		window.open('<?php echo $turl1; ?>','_blank');
	}
	function klik2() {
		window.open('<?php echo $turl2; ?>','_blank');
	}
	function klik3() {
		window.open('<?php echo $turl3; ?>','_blank');
	}

</script>
