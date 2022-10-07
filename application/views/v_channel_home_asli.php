<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$do_not_duplicate = array();

$jml_channelku = 0;
$npsnku = "";
$kodeku = "";
$nama_sekolahku = "";
$hitungdurasi = 0;
$idliveduluan = "";

$tgl_tayang = array("","");
$tgl_tayang1 = array("","");

if ($this->session->userdata('loggedIn')) {
	foreach ($channelku as $datane) {
		$jml_channelku++;
		$npsnku = $datane->npsn;
		//$kodeku = $datane->kode_sekolah;
		$nama_sekolahku = $datane->nama_sekolah;
	}
}

$jmldaf_list = 0;

$jml_list = 0;
if ($punyalist) {
foreach ($playlist as $datane) {
	//echo "<br><br><br><br>".($datane->id_youtube);
	$jml_list++;
	$id_videolist[$jml_list] = $datane->link_video;
	$durasilist[$jml_list] = $datane->durasi;
	$urutanlist[$jml_list] = $datane->urutan;
}
}

$jml_channel = 0;
foreach ($dafchannel as $datane) {
	$jml_channel++;
	$npsn[$jml_channel] = $datane->npsn;
	//$kode[$jml_channel] = $datane->kode_sekolah;
	$nama_sekolah[$jml_channel] = $datane->nama_sekolah;
}

$jmltotal = $jml_channel - $jml_channelku;
if ($this->session->userdata('a01'))
    $jmltotal = $jml_channel;

////$jml_video = 0;
////foreach ($dafvideo as $datane) {
////
////	if (in_array($datane->kode_video, $do_not_duplicate)) {
////		continue;
////	} else {
////		$do_not_duplicate[] = $datane->kode_video;
////		$jml_video++;
////		$nomor[$jml_video] = $jml_video;
////		$id_video[$jml_video] = $datane->kode_video;
////		$idjenis[$jml_video] = $datane->id_jenis;
////		$jenis[$jml_video] = $txt_jenis[$datane->id_jenis];
////		$id_jenjang[$jml_video] = $datane->id_jenjang;
////		$id_kelas[$jml_video] = $datane->id_kelas;
////		$id_mapel[$jml_video] = $datane->id_mapel;
////		$id_ki1[$jml_video] = $datane->id_ki1;
////		$id_ki2[$jml_video] = $datane->id_ki2;
////		$id_kd1_1[$jml_video] = $datane->id_kd1_1;
////		$id_kd1_2[$jml_video] = $datane->id_kd1_2;
////		$id_kd1_3[$jml_video] = $datane->id_kd1_3;
////		$id_kd2_1[$jml_video] = $datane->id_kd2_1;
////		$id_kd2_2[$jml_video] = $datane->id_kd2_2;
////		$id_kd2_3[$jml_video] = $datane->id_kd2_3;
////		$id_kategori[$jml_video] = $datane->id_kategori;
////		$topik[$jml_video] = $datane->topik;
////		$judul[$jml_video] = $datane->judul;
////		$deskripsi[$jml_video] = $datane->deskripsi;
////		$keyword[$jml_video] = $datane->keyword;
////		$link[$jml_video] = $datane->link_video;
////		$filevideo[$jml_video] = $datane->file_video;
////
////		$durasi[$jml_video] = $datane->durasi;
////		if (substr($datane->durasi, 0, 2) == "00")
////			$durasi[$jml_video] = substr($datane->durasi, 3, 5);
////
////		$thumbs[$jml_video] = $datane->thumbnail;
////		if (substr($thumbs[$jml_video], 0, 4) != "http")
////			$thumbs[$jml_video] = "<?php echo base_url(); ?><!--uploads/thumbs/" . $thumbs[$jml_video];-->
<!--//-->
<!--//		// if ($link[$jml_video]!="")-->
<!--//		// 	$thumbs[$jml_video]=substr($link[$jml_video],-11).'.';-->
<!--//		// else if ($filevideo[$jml_video]!="")-->
<!--//		// 	$thumbs[$jml_video]=substr($filevideo[$jml_video],0,strlen($filevideo[$jml_video])-3);-->
<!--//		$status_verifikasi[$jml_video] = $datane->status_verifikasi;-->
<!--//		$modified[$jml_video] = $datane->modified;-->
<!--//		//echo $datane->link_video;-->
<!--//		$pengirim[$jml_video] = $datane->first_name;-->
<!--//		// $verifikator1[$jml_video] = '';-->
<!--//		// $verifikator2[$jml_video] = '';-->
<!--//		// $siaptayang[$jml_video] = '';-->
<!--//-->
<!--//		$catatan1[$jml_video] = $datane->catatan1;-->
<!--//		$catatan2[$jml_video] = $datane->catatan2;-->
<!--//	}-->
<!--//}-->

<!--//if ($jml_video >= 5)-->
<!--//	$jml_video = 5;-->

<?php
if ($punyalist) {
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


        $tgl_tayang1[$jmldaf_list] = $datane->jam_tayang;
        $tgl_tayang[$jmldaf_list] = substr($datane->jam_tayang, 8, 2) . ' ' . $namabulan[(int)(substr($datane->jam_tayang, 5, 2))] . ' ' . substr($datane->jam_tayang, 0, 4) . ' Pukul ' . substr($datane->jam_tayang, 11, 5) . ' WIB';
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
}


if ($punyalist) {
    $jml_list = 0;
    foreach ($playlist as $datane) {
        //echo "<br><br><br><br>".($datane->link_video);
        $jml_list++;
        $id_videolist[$jml_list] = $datane->link_video;
        $durasilist[$jml_list] = $datane->durasi;
        $urutanlist[$jml_list] = $datane->urutan;
        $judulacara[$jml_list] = $datane->judul;
    }
}
else
{
    $namapaket="";
}

?>

<div class="container" style="margin-top: 0px;width: 100%">
    <div class="row">
        <div class="col-lg-12">
            <div id="jamsekarang" style="padding-top:65px;float: right; margin-right: 20px" id="jam">
            </div>
        </div>
    </div>
</div>

<!--<br><br>-->

<!---->
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
//		<a href="<?php echo base_url(); ?>channel/sekolah/ch'.$npsnku.'/'.$id_videodaflist[$a1].'">
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

<!--<hr>-->
<div style="text-align: center">
	<span style="font-weight: bold;color: grey">TV SEKOLAH</span>
	<div class="regular slider" style="margin-top: 20px;">
		<?php if ($jml_channelku && !$this->session->userdata('a01')) { ?>
			<div style="vertical-align: text-top; display: inline-block; padding-left: 10px;padding-right: 10px;">
				<a href="<?php echo base_url(); ?>channel/sekolah/<?php echo 'ch' . $npsnku; ?>" style="display: inline-block">
					<div class="avatar lebarikon"
						 style="text-align:center;background-image: url('<?php echo base_url(); ?>uploads/channel/thumb-3.jpg');">
					</div>
					<div class="lebarikon" style="text-align:center;">
						<span
							style="font-size:10px;font-weight: bold;color: grey"><?php echo $nama_sekolahku; ?></span>
					</div>

				</a>
			</div>
		<?php }

		for ($i = 1; $i <= $jmltotal; $i++) { ?>
			<div style="vertical-align: text-top; display: inline-block; padding-left: 10px;padding-right: 10px;">
				<a href="<?php echo base_url(); ?>channel/sekolah/<?php echo 'ch' . $npsn[$i]; ?>" style="display: inline-block">
					<div class="avatar lebarikon"
						 style="text-align:center;background-image: url('<?php echo base_url(); ?>uploads/channel/thumb-3.jpg');">
					</div>
					<div class="lebarikon" style="text-align:center;">
						<span
							style="font-size:10px;font-weight: bold;color: grey"><?php echo $nama_sekolah[$i]; ?></span>
					</div>

				</a>
			</div>
		<?php } ?>
	</div>


    <?php if (!$this->session->userdata('loggedIn')) { ?>
    <div style="margin-top:20px;font-weight: bold;color: red">Channel Sekolah tidak terlihat? Silakan login dahulu.</div>
<?php } else if ($jml_channelku==0 && !($this->session->userdata('a01'))) { ?>
        <div style="margin-top:20px;font-weight: bold;color: red">Channel Sekolah anda belum tersedia? Daftarkan sebagai verifikator!</div>
    <?php } ?>

</div>

<!--<div style="text-align: center">-->
<!--	<span style="font-weight: bold;color: grey">Streaming Terbaru</span>-->
<!--	<div class="rowvod">-->
<!--		--><?php //for ($a1 = 1; $a1 <= $jml_video; $a1++) {
//			echo '<div class="columnvod">
//
//		<a href="<?php echo base_url(); ?>watch/play/' . $id_video[$a1] . '">
//			 <div class="grup" style="margin:auto;width:175px;position:relative;text-align:center">
//			 <div style="font-size:11px;background-color:black;color:white;position: absolute;right:10px;bottom:10px">'
//				. $durasi[$a1] . '</div>
//
//			<img style="align:middle;width:175px;height:112px" src="' . $thumbs[$a1] . '"><br>
//			</div>
//			<div class="grup" style="text-align:center">
//
//			<div id="judulvideo">' . $judul[$a1] . '</div><br>
//			<br>
//			</div>
//
//
//			</div></a>';
//		}
//		?>
<!--	</div>-->
<!--</div>-->


</div>

<?php //if($punyalist)
//    $hitungdurasi = substr($durasidaf[1], 0, 2) * 3600 + substr($durasidaf[1], 3, 2) * 60 + substr($durasidaf[1], 6, 2);
//?>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->

<!--<script src="https://www.youtube.com/iframe_api"></script>-->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>

<script>
    var player;
    var detikke = new Array();
    var batasdurasi = new Array();
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
    var readyyoutube = false;
    var pisanae = false;
    <?php
    if ($idliveduluan != "") {
    ?>
    var statuslive = <?php echo $status[$idliveduluan];?>;
    // var tgljadwal=new Date("<?php echo $tgl_tayang1[1];?>");
    //var tgljadwal="11:34:00";
    <?php
    }
    else
    { ?>
    var statuslive = "1";
    //var tgljadwal="11:34:00";
    <?php }

    $url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
    $obj = json_decode(file_get_contents($url), true);
    $stampdate = substr($obj['datetime'], 0, 19);

    echo "var tglnow = new Date('" . $stampdate . "');";

    ?>

    var jamnow = tglnow.getTime();
    var now = new Date();
    var durasipaket = <?php echo $hitungdurasi; ?>;
    var tgljadwal;

    jamnow = jamnow + 1000;
    tgl = new Date(jamnow).getDate();
    bln = new Date(jamnow).getMonth();
    thn = new Date(jamnow).getFullYear();
    jam = new Date(jamnow).getHours();
    menit = new Date(jamnow).getMinutes();
    detik = new Date(jamnow).getSeconds();
    durasisekarang = jam * 3600 + menit * 60 + detik;
    jamseting = parseInt(durasisekarang / durasipaket) * durasipaket;
    jamejadwal = parseInt(jamseting / 3600);
    menitejadwal = parseInt((jamseting - (jamejadwal * 3600)) / 60);
    detikejadwal = parseInt(jamseting - (jamejadwal * 3600) - (menitejadwal * 60));

    tgljadwal = new Date(now.getFullYear(), now.getMonth(), now.getDate(), jamejadwal, menitejadwal, detikejadwal);
    // console.log("JADWAL BAARU:"+tgljadwal);


    // var tgljadwal = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours(), now.getMinutes(), now.getSeconds());


    // durasisekarang = jam*3600+menit*60+detik;
    // jamseting = parseInt(durasisekarang/durasipaket)*durasipaket;
    // jamejadwal = parseInt(jamseting/3600);
    // menitejadwal = parseInt((jamseting-(jamejadwal*3600))/60);
    // detikejadwal = parseInt(jamseting-(jamejadwal*3600)-(menitejadwal*60));
    //
    // tgljadwal = new Date(now.getFullYear(), now.getMonth(), now.getDate(), jamejadwal, menitejadwal, detikejadwal);
    //var jamtayang = tgljadwal.getTime();
    //alert (tgljadwal);

    //var jmljudul = 0;
    //var jmlterm = 0;
    //var jamjadwal, jamsaiki;
    //var masuksiaran = false;
    //var dalamsiaran = false;
    //
    //filler[1] = 'X7R-q9rsrtU';
    //
    <?php
    //if ($id_playlist == null) {
    //?>
    //detikke[1] = '<?php //echo substr($tgl_tayang1[1], 0, 8);?>//';
    <?php //} else {
    //?>
    //detikke[1] = keJam(tgljadwal);
    <?php //} ?>
    //
    ////console.log('JML LIST:'+<?php //echo $jml_list;?>//);
    ////console.log("Detik 1:"+detikke[1]);
    <?php
    //echo "gabung='<table border=\"0\"><col width=\"80\">';";
    //for ($q = 1; $q <= $jml_list; $q++) {
    //    echo "idvideo[" . $q . "] = youtube_parser('" . $id_videolist[$q] . "'); \r\n";
    //    echo "durasike[" . $q . "] = '" . $durasilist[$q] . "'; \r\n";
    //    if ($q > 1) {
    //        echo "detikke[" . $q . "] = keJam(new Date(jamHitung(" . ($q - 1) . ")+hitungDurasi(" . ($q - 1) . "))); \r\n";
    //    }
    //    echo "durasi=durasi+hitungDurasi(" . $q . "); \r\n";
    //
    //
    //    echo "console.log('Detikke " . $q . " = '+detikke[$q]); \r\n";
    //    echo "console.log('Durasi " . $q . " = '+durasike[$q]); \r\n";
    //    echo "console.log('Id ke " . $q . " = '+idvideo[$q]); \r\n";
    //
    //    echo "gabung=gabung+'<tr><td valign=\"top\">'+detikke[" . $q . "].substring(0,5)+' WIB </td><td valign=\"top\">'+'".$judulacara[$q]."'+'</td></tr>';";
    //    //echo "gabung=gabung+'<br>'+detikke[" . $q . "].substring(0,5)+' WIB - '+'".$judulacara[$q]."';";
    //};
    //echo "gabung=gabung+'</table>';";
    //?>
    //
    //
    //
    ///*console.log("Durasi:"+durasi);*/
    //console.log("Gabung:"+(gabung));
    //
    //$('#tempatJadwal').html(gabung);
    //
    //detik2 = 0;
    //
    //function ceklive() {
    //    detik2++;
    //    tglsaiki = new Date(tglnow.getTime() + (detik2 * 1000));
    //
    //    //alert (tglsaiki);
    //    //console.log(tglsaiki);
    //    //alert ("Tgl_saiki:"+tglsaiki+", Tgl_jadwal:"+tgljadwal+", selisih:"+(tglsaiki-tgljadwal));
    //
    //    if (tglsaiki - tgljadwal < 0) {
    //        //alert ("AAAA");
    //        $('#layartancap').show();
    //        $('#keteranganLive').html("SEGERA TAYANG TANGGAL: <?php //if ($punyalist) {if ($id_playlist == null)
    //            echo $tgl_tayang[$idliveduluan]; else
    //            echo $tayangpaket;} ?>//");
    //        // $('#divnamapaket').show();
    //        $('#keteranganLive').show();
    //        $('#infolive<?php //echo $idliveduluan;?>//').html("Segera Tayang");
    //
    //
    //    } else {
    //
    //        masuksiaran = true;
    //        if ((tglsaiki - tgljadwal) < durasi) {
    //            //alert(player.getPlayerState());
    //            //player.playVideo();
    //            //updatePlaying();
    //
    //            dalamsiaran = true;
    //            if (loadsekali == false) {
    //                loadsekali = true;
    //                loadplayer();
    //
    //            }
    //
    //
    //            $('#layartancap').show();
    //            $('#keteranganLive').html("");
    //            //   $('#divnamapaket').show();
    //            $('#keteranganLive').show();
    //            $('#infolive<?php //echo $idliveduluan;?>//').html("");
    //        } else {
    //            dalamsiaran = false;
    //
    //            //alert ("OK1:<?php ////echo $idliveduluan;?>//");
    //
    //            $('#layartancap').show();
    //            $('#keteranganLive').html("");
    //            //  $('#divnamapaket').hide();
    //            $('#keteranganLive').hide();
    //            $('#infolive<?php //echo $idliveduluan;?>//').html("");
    //            if (statuslive == 1) {
    //                // gantistatusselesai();
    //            }
    //        }
    //    }
    //}
    //
    //
    //jmljudul = <?php //echo $jml_list;?>//;
    ///*if (durasi>0)
    //jmlterm = (86400 / (durasi/1000)) - 1;
    //*/
    //jmlterm = 1;
    //
    ///*jamakhir = new Date("1970-01-01T" + detikke[3] + "Z").getTime();
    //jamawal = new Date("1970-01-01T" + detikke[1] + "Z").getTime();*/
    ////	durasi = hitungDurasi(1) + hitungDurasi(2) + hitungDurasi(3);
    //
    //if (jmlterm > 0) {
    //    for (var y = 1; y <= jmlterm; y++) {
    //        for (var z = 1; z <= jmljudul; z++) {
    //            detikke[y * jmljudul + z] = keJam(new Date("1970-01-01T" + detikke[z]).getTime() + durasi * y);
    //            durasike[y * jmljudul + z] = durasike[z];
    //            idvideo[y * jmljudul + z] = idvideo[z];
    //            //console.log("detikke"+(y * jmljudul + z)+":"+detikke[y * jmljudul + z]);
    //        }
    //    }
    //}
    //
    //function youtube_parser(url) {
    //    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    //    var match = url.match(regExp);
    //    return (match && match[7].length == 11) ? match[7] : false;
    //}
    //
    //
    ///*echo 'console.log('.$jml_list.');';*/
    //
    //
    //function onYouTubeIframeAPIReady() {
    //    initialize();
    //    readyyoutube = true;
    //    <?php
    //    /*echo "console.log('".$id_playlist."'); \r\n";
    //    echo "console.log('status:".$status[1]."'); \r\n";*/
    //    if (($id_playlist != null && $statuspaket == 2)) {
    //        echo "loadplayer(); \r\n";
    //    }?>
    //}
    //
    //function loadplayer() {
    //    idvideolain = "";
    //    <?php
    //    if ($id_playlist != null) {
    //        for ($x = 2; $x < $jml_list; $x++)
    //            echo "idvideolain = idvideolain + idvideo[" . $x . "]+','; \r\n";
    //    }
    //    if ($jml_list > 1)
    //        echo "idvideolain = idvideolain + idvideo[" . $jml_list . "]; \r\n";
    //    ?>
    //
    //    //console.log(idvideo[1]);
    //    //console.log(idvideolain);
    //
    //    player = new YT.Player('isivideoyoutube', {
    //        width: 600,
    //        height: 400,
    //        videoId: <?php //echo "idvideo[1]";?>//,
    //        showinfo: 0,
    //        controls: 0,
    //        autoplay: 0,
    //        playerVars: {
    //            color: 'white',
    //            playlist: <?php //echo "idvideolain";?>//,
    //            origin: 'https://tutormedia.net/tve'
    //        },
    //        events: {
    //            //onReady: initialize
    //        }
    //    });
    //}


    function initialize() {

        //alert ("NAH KAN");
        $(function () {
            setInterval(updateTanggal, 1000);
            <?php
            //            if ($status[1]==1)
            {
            ?>
            setInterval(ceklive, 1000);
            <?php } ?>

        });

        if (dalamsiaran) {
            alert("Alert");
            player.playVideo();
        }

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

    function tesupdate() {
        player.playVideo();
    }

    function updateTanggal() {

        //player.playVideo();
        //alert (dalamsiaran);
        //if (durasi > 0 && dalamsiaran)
        //if(readyyoutube)
        {
            var statusPlayer = player.getPlayerState();
            //updatePlaying();
            for (a = 1; a <= (jmljudul * jmlterm); a++) {
                jamjadwal = new Date("1970-01-01T" + detikke[a] + "Z").getTime();
                jamsaiki = new Date("1970-01-01T" + jmmndt + "Z").getTime();
                //  console.log("DETIK:" + detikke[a]+":"+jmmndt);
                terakhir = a;
                batasdurasi[a] = hitungDurasi(a) / 1000;
                if (jamsaiki >= jamjadwal) {
                    cekjatah = a;
                    detikselisih = (jamsaiki - jamjadwal) / 1000;
                    //break;
                }
                if (terakhir != cekjatah)
                    break;
            }

            // adetikjam = parseInt(durasike[jatah].substring(0,2))*3600;
            //adetikmenit = parseInt(durasike[jatah].substring(3,5))*60;
            // adetikdetik = parseInt(durasike[jatah].substring(6,8));
            //  atotaldurasi = (detikjam + detikmenit + detikdetik);

            if (jatah == jmljudul && detikselisih > batasdurasi[jatah])
            {
                location.reload();
                //console.log("Jatah:" + jatah);
            }

            //console.log("Durasi:" + batasdurasi[jatah]);

            // console.log("Detik selisih:" + detikselisih);
            //console.log("CekJatah:" + cekjatah);
            //console.log("player.getPlayerState()";

            if (cekjatah != jatah) {

                // console.log(cekjatah);
                // console.log(idvideo[cekjatah]);

                jatah = cekjatah;

                detiklokal = detikselisih;

                // console.log("Jatah2:" + jatah);
                // console.log("Selisih:" + detikselisih);

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
                if (statusPlayer != 2) {
                    if (jarak > 5 || jarak < -5)
                        player.seekTo(detiklokal);
                    player.playVideo();
                }
            }
        }

        //player.playVideo();

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

        // durasisekarang = jam*3600+menit*60+detik;
        // jamseting = parseInt(durasisekarang/durasipaket)*durasipaket;
        // jamejadwal = parseInt(jamseting/3600);
        // menitejadwal = parseInt((jamseting-(jamejadwal*3600))/60);
        // detikejadwal = parseInt(jamseting-(jamejadwal*3600)-(menitejadwal*60));
        //
        // if(jamejadwal<24 && menitejadwal<60 && detikejadwal<60)
        // {
        //     tgljadwal = new Date(now.getFullYear(), now.getMonth(), now.getDate(), jamejadwal, menitejadwal, detikejadwal);
        //     console.log(tgljadwal);
        // }


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
        //alert ("masuk ki");
        // console.log("MASUK KI");
        // player.playVideo();

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

        // console.log("Jatah:"+jatah);
        // console.log("CekJatah:"+cekjatah);

        if (cekjatah != jatah) {

            //console.log(cekjatah);
            // console.log(idvideo[cekjatah]);
            jatah = cekjatah;

            detiklokal = detikselisih;

            // console.log("Jatah2:"+jatah);
            // console.log("Selisih:"+detikselisih);

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

<!--    --><?php
//    if ($idliveduluan) {
//    ?>
//
//    function gantistatusselesai() {
//        $.ajax({
//            url: "<?php echo base_url(); ?>channel/gantistatuspaket_sekolah",
//            method: "POST",
//            data: {id: <?php //echo $iddaflist[$idliveduluan];?>//},
//            success: function (result) {
//                statuslive = 1;
//                //detik2=0;
//            }
//        })
//    }
//
//    <?php //} ?>


    $(document).on('ready', function () {
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5
        });
    });


</script>


