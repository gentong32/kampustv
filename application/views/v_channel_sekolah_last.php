<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw

$durasidaf = Array("","");
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$namaharis = Array('','SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU','MINGGU');
$do_not_duplicate = array();
$npsnku = "";
$kodeku = "";
$jml_list = 0;
$idliveduluan = "";
$tgl_tayang = array("", "");
$tgl_tayang1 = array("", "");


foreach ($infosekolah as $datane) {
    $npsnku = $datane->npsn;
    $nama_sekolahku = $datane->nama_sekolah;
}

$jmldaf_list = 0;
$statuspaket = 1;
$namapaket = "";
$namahari = "belum dibuat";

foreach ($dafplaylist as $datane) {
//    echo "<br><br><br><br><br>Paket. ".$jmldaf_list.":".$datane->nama_paket;
//    die();

    $jmldaf_list++;

    $iddaflist[$jmldaf_list] = $datane->id_paket;
    $id_videodaflist[$jmldaf_list] = $datane->link_list;
    $nama_playlist[$jmldaf_list] = $datane->nama_paket;

    $status[$jmldaf_list] = $datane->status_paket;
    $namahari = $namaharis[$datane->hari];

    if ($datane->status_paket == 1) {
        $tlive[$jmldaf_list] = "Segera Tayang";
        $idliveduluan = $jmldaf_list;
    } else {
        $tlive[$jmldaf_list] = "";
    }


    $tgl_tayang1[$jmldaf_list] = $datane->jam_tayang;
	$tgl_tayang[$jmldaf_list] = substr($datane->jam_tayang, 0) . ' WIB';
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

$durasisponsor = 0;

if ($punyalist) {
    $jml_list = 0;
    if ($url_sponsor!="")
	{
		$jml_list++;
		$id_videolist[$jml_list] = $url_sponsor;
		$durasilist[$jml_list] = $durasi_sponsor;
		$durasisponsor = substr($durasi_sponsor, 0, 2) * 3600 + substr($durasi_sponsor, 3, 2) * 60 + substr($durasi_sponsor, 6, 2);
		$urutanlist[$jml_list] = 1;
		$kodechannel[$jml_list] = "";
		$namachannel[$jml_list] = "";
		$judulacara[$jml_list] = "";
	}
    foreach ($playlist as $datane) {
        //echo "<br><br><br><br>".($datane->link_video);
        $jml_list++;
        $id_videolist[$jml_list] = $datane->link_video;
        $durasilist[$jml_list] = $datane->durasi;
        $urutanlist[$jml_list] = $datane->urutan;
        $kodechannel[$jml_list] = $datane->kode_video;
		$namachannel[$jml_list] = $datane->channeltitle;
        $judulacara[$jml_list] = addslashes($datane->judul);
    }
}
else
{
    $namapaket="";
}

$jml_channel = 0;


foreach ($dafchannelguru as $datane) {
    $jml_channel++;
    $id_user[$jml_channel] = $datane->id_user;
    //$kode[$jml_channel] = $datane->kode_sekolah;
    $first_name[$jml_channel] = $datane->first_name;
    $last_name[$jml_channel] = $datane->last_name;
    if($datane->picture==null)
    	$foto_guru[$jml_channel] = base_url().'assets/images/profil_blank.jpg';
    else if(substr($datane->picture,0,4)=='http')
		$foto_guru[$jml_channel] = $datane->picture;
    else
		$foto_guru[$jml_channel] = base_url().'uploads/profil/'.$datane->picture;
	//echo $datane->first_name."===".$foto_guru[$jml_channel]."<br>";
}

//echo "<br><br><br><br>JMLDAFLIST:".$jmldaf_list;
?>

<div class="container bgimg3" style="margin-top: 0px;width: 100%;padding-bottom: 50px;">
    <div class="row">
        <div class="col-lg-12">
            <div id="jamsekarang" style="font-weight: bold;color: black;padding-top:65px;float: right; margin-right: 20px" id="jam">
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-8"
		 style="background-color: transparent; font-weight: bold;font-size:16px;
		 position: relative ; top: 0px; text-align:center; color:black; margin-top:0px;">
        <?php
		if (isset($nama_sekolahku))
        echo "CHANNEL " . $nama_sekolahku;
		if ($url_sponsor!="")
			echo "<br>CHANNEL INI DISPONSORI OLEH ".strtoupper($sponsor);
		else if ($sponsor!="")
			echo "<br>CHANNEL INI TERSELENGGARA ATAS KERJASAMA DENGAN ".strtoupper($sponsor);

//        if ($id_playlist == null && $jmldaf_list > 0 && $idliveduluan != "")
//            echo $nama_playlist[$idliveduluan]; else
//            echo $namahari;
            ?>
    </div>


    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="row content-block">
<!--                <div class="indukplay" style="padding-top:0px;text-align:center;margin-left:auto;margin-right: auto;">-->
                    <?php
                    if ($jmldaf_list > 0) {
                        ?>
                        <div id="layartancap" style="display:none" <?php
                        if ($status[1] == 2 && $id_playlist == null)
                            //JIKA GAK ADA YANG MAU TAYANG
                            echo 'style="display:none";' ?>
                             class="iframe-container embed-responsive embed-responsive-16by9">
                            <div class="embed-responsive-item" style="width: 100%;display: none" id="isivideoyoutube">
                                <?php
                                if ($statuspaket == 1) {
                                    ?>
                                    <img style="width: 100%" src="<?php
                                    if ($id_playlist == null)
                                        echo $thumbnail[$idliveduluan]; else
                                        echo $thumbspaket; ?>"/>
                                <?php } ?>
                            </div>
                        </div>

						<div id="layartancap2" style="display:block">
							<img style="width: 100%" src="<?php echo base_url(); ?>assets/images/pm5644.jpg">
						</div>

                    <?php } else {
                        ?>
                        <img style="width: 100%" src="<?php echo base_url();?>assets/images/playlistbelum2.png"/>
                    <?php }
                    ?>
<!--                </div>-->
            </div>
			<div id="namachannel" style="display: inline-block;float: right"></div>
			<div id='seconds' style="display: inline-block"></div>
        </div>
        <div class="col-lg-4 col-md-4" style="background-color: #f6f6f6;padding-bottom: 30px;">
            <div class="row content-block">
                <div class="col-lg-12">
                    <div style="text-align: center;font-weight: bold;font-size:16px;color:#000">
                        JADWAL ACARA HARI INI [<?php echo $namahari;?>]
                    </div>
                    <div id="tempatJadwal" style="font-weight: bold;color:#000;height: 400px;overflow: auto;">

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
<div style="background-color: #373635;padding: 10px;">
	<center><button class="myButtongreen" onclick="window.open('<?php
		echo base_url();?>channel/sekolah/','_self')">LIHAT SEMUA CHANNEL SEKOLAH</button></center>
</div>


<?php

if ($jmldaf_list > 0) {
    if ($statuspaket == 1) {
        ?>
        <div id="keteranganLive" style="text-align:center; color:black">
            <!--SEGERA TAYANG TANGGAL: <?php echo $tgl_tayang[1]; ?>-->
        </div>
    <?php }
} ?>

<!--/////////////// CHANEL SEKOLAH //////////////-->
<!--<div style="text-align: center">-->
<!--    <span style="font-weight: bold;color: grey">Channel</span>-->
<!--    <span style="font-weight: bold;color: black">--><?php //echo $nama_sekolahku; ?><!--</span>-->
<!--</div><br>-->
<!--<div style="text-align: center">-->
<!--    <span style="font-weight: bold;color: grey">TERBARU</span>-->
<!--    <div class="rowvod">-->
<!---->
<!--        --><?php
//        for ($a1 = 1; $a1 <= $jmldaf_list; $a1++) {
//            echo '<div class="columnvod">
//
//		<a href="channel/sekolah/ch'.$npsnku.'/'.$id_videodaflist[$a1].'">
//		<div class="grup" style="margin:auto;width:175px;position:relative;text-align:center">
//		<div style="font-size:11px;background-color:black;color:white;position: absolute;right:10px;bottom:10px">'
//                . $durasidaf[$a1] .
//                '</div>
//		<img style="align:middle;width:175px;height:112px" src="' . $thumbnail[$a1] . '" /><br>
//		</div>
//
//		<div class="grup" style="text-align:center">
//		<div id="judulvideo">' . $nama_playlist[$a1] . '</div><div id="infolive'.$a1.'">'.$tlive[$a1].'</div><br>
//		</div>
//
//		</a></div>';
//        }
//        ?>
<!--    </div>-->
<!--</div>-->
<!--<hr>-->


<div style="text-align: center;background-color:#8cbdac;padding-top: 20px;padding-bottom: 20px">
    <span style="font-size:16px;font-weight: bold;color: black;">KELAS VIRTUAL</span>
    <div class="regular slider" style="margin-top: 20px;">
        <?php
        for ($i = 1; $i <= $jml_channel; $i++) { ?>
            <div style="vertical-align: text-top; display: inline-block; padding-left: 10px;padding-right: 10px;font-size:14px;">
                <a href="<?php echo base_url();?>channel/guru/<?php echo 'chusr' . $id_user[$i]; ?>" style="display: inline-block">
                    <div class="avatar lebarikon"
                         style="text-align:center;background-image: url('<?php echo $foto_guru[$i] ?>');">
                    </div>
                    <div class="lebarikon" style="text-align:center;">
						<span
                                style="font-size:12px;font-weight: bold;color: black"><?php echo $first_name[$i]; ?></span>
                    </div>

                </a>
            </div>
        <?php } ?>
    </div>
    <?php if (!$this->session->userdata('loggedIn')) { ?>
        <div style="margin-top:20px;font-weight: bold;color: #bd1a1a">Ingin memiliki Channel Guru sendiri? Silakan
            daftar/login dahulu.
        </div>
    <?php } else if ($jml_channel == 0) { ?>
        <div style="margin-top:20px;font-weight: bold;color: #bd1a1a">Channel Sekolah anda belum tersedia? Daftarkan sebagai
            verifikator!
        </div>
    <?php } ?>

</div>

<?php if($punyalist)
	$hitungdurasi = substr($durasidaf[1], 0, 2) * 3600 + substr($durasidaf[1], 3, 2) * 60 + substr($durasidaf[1], 6, 2);
else
	$hitungdurasi = 0;

$hitungdurasi = $hitungdurasi + 15 + $durasisponsor;
?>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->

<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>

<script>
	$(document).on('ready', function () {
		$(".regular").slick({
			dots: true,
			infinite: true,
			arrows: false,
			slidesToShow: 5,
			slidesToScroll: 5
		});
	});

	<?php

	$now = new DateTime();
	$now->setTimezone(new DateTimezone('Asia/Jakarta'));
	$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
	echo "var tglnow = new Date('" . $stampdate . "');";

	?>

	var jamnow = tglnow.getTime();
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');


	setInterval(updateJam, 1000);

	function updateJam() {
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
		//console.log((tgl + ' ' + namabulan[bln] + ' ' + thn + ', ' + jmmndt + ' WIB'));
	}

</script>

<script>
	var player;
	var detikke = new Array();
	var idvideo = new Array();
	var durasike = new Array();
	var totaldurasi = new Array();
	var durasidetik = new Array();
	var judulacara = new Array();
	var tgl, bln, thn, jam, menit, detik, jmmndt;

	var jammulaitayang=<?php echo substr($tgl_tayang[1],0,2);?>;
	var jumlahjudul = <?php echo $jml_list;?>;
	var posisijudul=1;
	var jambulatawal = 0;
	var sisadetikawal = 0;
	var detiklokal;
	var gabung = "";
	var jamnow = tglnow.getTime();
	var now = new Date();
	var durasipaket = <?php echo $hitungdurasi; ?>;
	var jambulat = Math.ceil(durasipaket / 3600);

	var jamawal;
	var menitawal;
	var detikawal;
	var totaldetikawal;
	var yutubredi;


	function ambiljadwalbaru() {

		<?php

		$now = new DateTime("2021-03-");
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
		echo "var tglnow = new Date('" . $stampdate . "');";
		?>

		jamawal = <?php echo substr($stampdate, 11, 2);?>;
		menitawal = <?php echo substr($stampdate, 14, 2);?>;
		detikawal = <?php echo substr($stampdate, 17, 2);?>;
		totaldetikawal = jamawal * 3600 + menitawal * 60 + detikawal;
		yutubredi = false;
		if (jamawal >= jammulaitayang) {
			jambulatawal = parseInt(jamawal / jambulat) * jambulat + (jammulaitayang % jambulat);
		} else {
			jambulatawal = jammulaitayang;
		}
		sisadetikawal = totaldetikawal - jambulatawal * 3600;

		if (sisadetikawal > durasipaket) {
			//alert ("IKLAN DULU BELUM MULAI");
			// jambulatawal = parseInt(jamawal / jambulat) * jambulat + (jammulaitayang%jambulat);
		}

		console.log("JAMBARU:"+jamawal+":"+menitawal+":"+detikawal);
		// if (sisadetikawal>0)
		// {
		// 	$('#layartancap').show();
		// 	$('#layartancap2').hide();
		// }

		if (sisadetikawal > 0 && sisadetikawal < durasipaket) {
			$('#layartancap').show();
			$('#layartancap2').hide();
		}

		console.log("Tayang tiap : " + jambulat + " jam sekali");
		// console.log("Total durasi (detik) : " + durasipaket);
		// console.log("Jam sekarang (detik) : " + sisadetikawal);

		totaldurasi[0] = 0;

		<?php
		$totaldurasi = 0;

		for ($q = 1; $q <= $jml_list; $q++) {
			echo "idvideo[" . $q . "] = youtube_parser('" . $id_videolist[$q] . "'); \r\n";
			echo "durasike[" . $q . "] = '" . $durasilist[$q] . "'; \r\n";
			$durasidetik = ((int)substr($durasilist[$q], 0, 2)) * 3600 +
				((int)substr($durasilist[$q], 3, 2)) * 60 +
				(int)substr($durasilist[$q], 6, 2);
			$totaldurasi = $totaldurasi + $durasidetik;
			echo "durasidetik[" . $q . "] = " . $durasidetik . "; \r\n";
			echo "totaldurasi[" . $q . "] = " . $totaldurasi . "; \r\n";
			echo "judulacara[" . $q . "] = '" . $judulacara[$q] . "'; \r\n";
		};
		?>

		gabung = '<table border="0"><col width="80">';
		for (var q = 1; q <= <?php echo $jml_list;?>; q++) {
			if (q == 1) {
				jambulatawalcek = jambulatawal;
				if (sisadetikawal > durasipaket)
					jambulatawalcek = jambulatawalcek + jambulat;
				if (jambulatawalcek < 10)
					strjambulatawal = "0" + jambulatawalcek;
				else
					strjambulatawal = jambulatawalcek;

				detikke[q] = strjambulatawal + ':00:00';
			} else {

				if (sisadetikawal > totaldurasi[q - 1])
					posisijudul = q;

				totaldetik = jambulatawal * 3600 + totaldurasi[q - 1];
				jamhitung = parseInt(totaldetik / 3600);
				sisamenit = totaldetik - jamhitung * 3600;
				menithitung = parseInt(sisamenit / 60);
				stringmenit = String(menithitung)
				detikhitung = sisamenit - menithitung * 60;

				if (sisadetikawal > durasipaket)
					jamhitung = jamhitung + jambulat;
				stringjam = String(jamhitung)
				if (jamhitung < 10)
					stringjam = "0" + stringjam;
				if (jamhitung >= 24)
					break;
				if (menithitung < 10)
					stringmenit = "0" + stringmenit;
				detikke[q] = stringjam + ':' + stringmenit + ':' + detikhitung;
			}
			console.log('Id ke ' + q + ' = ' + idvideo[q]);
			// console.log('Durasi ke ' + q + ' = ' + durasike[q]);
			// console.log('Total durasi ke ' + q + ' = ' + totaldurasi[q]);
			// console.log('Tayang jam ' + q + ' = ' + detikke[q]);
			<?php if ($url_sponsor != ""){?>
			if (q > 1) {
				if (q == 2) {
					gabung = gabung + '<tr><td valign="top">' + detikke[1].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[2] + '</td></tr>';
				} else {
					gabung = gabung + '<tr><td valign="top">' + detikke[q].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[q] + '</td></tr>';
				}

			}
			<?php } else {?>
			gabung = gabung + '<tr><td valign="top">' + detikke[q].substr(0, 5) + ' WIB </td><td valign="top">' + judulacara[q] + '</td></tr>';
			<?php } ?>
		}

		gabung = gabung + '</table>';
		// console.log('Posisi judul akhir = ' + posisijudul);
		// console.log('Durasi detik ' + posisijudul + " = " + durasidetik[posisijudul]);
		// console.log("Playing judul acara:" + judulacara[posisijudul] + ", detik ke " + (sisadetikawal-totaldurasi[posisijudul-1]));

		jamnow = jamnow + 1000;


		$('#tempatJadwal').html(gabung);
	}

	ambiljadwalbaru();


	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	function onYouTubeIframeAPIReady() {
		// $('#layartancap').show();
		// $('#layartancap2').hide();
		//document.getElementById('isivideoyoutube').style.display = "block";
		loadplayer();
	}

	function loadplayer() {

		player = new YT.Player('isivideoyoutube', {
			width: 600,
			height: 400,
			videoId: idvideo[posisijudul],
			showinfo: 0,
			controls: 0,
			autoplay: 0,
			playerVars: {
				color: 'white',
				origin: 'https://www.tvsekolah.id'
			},
			events: {
				'onReady': initialize,
				'onStateChange': panggilsaya
			}
		});

	}


	function initialize() {
		detiklokal = 2;
		sisadetikawal = totaldetikawal - jambulatawal * 3600;
		detikplayer = sisadetikawal-totaldurasi[posisijudul-1];
		if (sisadetikawal>=0){
			document.getElementById('isivideoyoutube').style.display = "block";
			player.loadVideoById(idvideo[posisijudul], detikplayer);
			player.playVideo();
		}
		//player.seekTo(detikplayer);
		//if (player.getPlayerState()==5)
		//panggilsaya;
		//player.playVideo();
//		alert(player.getPlayerState());
		//player.playVideo();
		$(function () {
			setInterval(ceklive, 1000);
		});
		//ceklive();
	}

	function panggilsaya() {
		if (player.getPlayerState()==3||player.getPlayerState()==2) {
			sisadetikawal = detiklokal + (totaldetikawal - jambulatawal * 3600);
			detikplayer = sisadetikawal-totaldurasi[posisijudul-1];
			player.seekTo(detikplayer);
			player.playVideo();
		}
		// console.log(player.getPlayerState());
	}

	function ceklive() {
		detiklokal++;
		sisadetikawal = detiklokal + (totaldetikawal - jambulatawal * 3600);
		detikplayer = sisadetikawal-totaldurasi[posisijudul-1];

		// console.log("Jam detik sekarang:"+sisadetikawal);
		// console.log("Jam bulat:"+jambulat);

		if (sisadetikawal>=jambulat * 3600)
		{
			console.log("BARU LAGI");
			// detiklokal = 0;
			posisijudul=0;
			jambulatawal = jambulatawal+jambulat;
			// jamawal = jam;
			// menitawal = menit;
			// detikawal = detik;
			sisadetikawal = 0;
		}

		if (sisadetikawal>=totaldurasi[posisijudul])
		{
			posisijudul++;
			if (posisijudul>jumlahjudul)
			{
				// console.log("Playing iklan:");
				// hjam = new Date(jamnow).getHours();
				// hmenit = new Date(jamnow).getMinutes();
				// hdetik = new Date(jamnow).getSeconds();
				// hjmmndt = hjam + ':' + hmenit + ':' + hdetik;
				// hwaktu1 = hjam*3600 + hmenit*60 + hdetik;
				// hjam2 = detikke[1].substring(0, 2);
				// hmenit2 = detikke[1].substring(3, 5);
				// hdetik2 = detikke[1].substring(6, 8);
				// hwaktu2 = parseInt(hjam2)*3600 + parseInt(hmenit2)*60 + parseInt(hdetik2);
				// hjmmndt2 = hjam2 + ':' + hmenit2 + ':' + hdetik2;
				// if (hwaktu1>hwaktu2)
				// 	window.location.reload();
				//ambiljadwalbaru();
				$('#layartancap').hide();
				$('#layartancap2').show();
				player.stopVideo();
				//document.getElementById('isivideoyoutube').style.display = "block";

			}
			else
			{

				$('#layartancap').show();
				$('#layartancap2').hide();
				console.log("Playing judul acara:" + judulacara[posisijudul]);
				player.loadVideoById(idvideo[posisijudul],detikplayer);
				player.playVideo();
			}

		}

		if (sisadetikawal<0)
		{
			console.log("Playing iklan:");
			$('#layartancap').hide();
			$('#layartancap2').show();
			player.stopVideo();
		}

		if (detikplayer==0)
		{
			$('#layartancap').show();
			$('#layartancap2').hide();
			document.getElementById('isivideoyoutube').style.display = "block";
			console.log("Playing judul acara:" + judulacara[posisijudul]);
			player.loadVideoById(idvideo[posisijudul],detikplayer);
			player.playVideo();
		}

		 // console.log("Posisi jud:"+idvideo[posisijudul]);
		 // console.log("Detik player:"+detikplayer);

	}

	function startTimer()
	{

	}

</script>


