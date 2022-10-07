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
    $tgl_tayang[$jmldaf_list] = $datane->jam_tayang . ' WIB';

//    echo "<br><br>".$tgl_tayang1[1];

    $idvideoawal[$jmldaf_list] = $datane->judul;
    $durasidaf[$jmldaf_list] = $datane->durasi_paket;
    $thumbnail[$jmldaf_list] = $datane->thumbnail;
    if (substr($thumbnail[$jmldaf_list], 0, 4) != "http") {
        $thumbnail[$jmldaf_list] = base_url()."uploads/thumbs/" . $thumbnail[$jmldaf_list];
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
                        <div id="layartancap" <?php
                        if ($status[1] == 2 && $id_playlist == null)
                            //JIKA GAK ADA YANG MAU TAYANG
                            echo 'style="display:none";' ?>
                             class="iframe-container embed-responsive embed-responsive-16by9">
                            <div class="embed-responsive-item" style="width: 100%" id="isivideoyoutube">
                                <?php
                                if ($statuspaket == 1) {
                                	//echo "TVS";
                                    ?>
                                    <img id="imglayar" style="width: 100%" src="<?php
                                    if ($id_playlist == null)
                                        echo $thumbnail[$idliveduluan]; else
                                        echo $thumbspaket; ?>"/>
                                <?php }
                                else
                                	{?>
										<img id="imglayar" style="width: 100%" src="">
									<?php }?>
                            </div>
                        </div>

						<div id="layartancap2" style="display:none">
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
<?php
//                        for ($a = 1; $a <= $jml_list; $a++) {
//                            echo "<br>" . $judulacara[$a];
//                        }
//                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
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
                         style="text-align:center;background-image: url('<?php echo base_url(); ?>uploads/channel/thumb-3.jpg');">
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
?>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->

<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/slick.js" type="text/javascript" charset="utf-8"></script>

<script>
    var player;
    var detikke = new Array();
    var batasdurasi = new Array();
    var idvideo = new Array();
    var durasike = new Array();
    var filler = new Array();
    var judulke = new Array();
    var jatah = 0;
	var terakhirterm = 0;
    var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
    var detiklokal = 0;
    var tgl, bln, thn, jam, menit, detik, jmmndt;
    var cekjatah = 0;
    var durasi = 0;
    var detikselisih;
    var loadsekali = false;
    var readyyoutube = false;
    var pisanae = false;
	var tayanganhabis = false;
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
    jammulai = parseInt(<?php echo substr($tgl_tayang1[1],0,2);?>);
    menitmulai = parseInt(<?php echo substr($tgl_tayang1[1],3,2);?>);
	detikmulai = parseInt(<?php echo substr($tgl_tayang1[1],6,2);?>);
    durasisekarang = jam * 3600 + menit * 60 + detik;
    durasimulai = jammulai * 3600 + menitmulai * 60 + detikmulai;
    durasisekarang = durasisekarang - (durasimulai);
    jamseting = parseInt(durasisekarang / durasipaket) * durasipaket;
	//jamseting = jamseting - (22*3600+15*60);
    jamejadwal = parseInt(jamseting / 3600);
    jame = jamejadwal + jammulai;
    menitejadwal = parseInt((jamseting - (jamejadwal * 3600)) / 60);
    menite = menitejadwal + menitmulai;
    detikejadwal = parseInt(jamseting - (jamejadwal * 3600) - (menitejadwal * 60));
    detike = detikejadwal + detikmulai;

    tgljadwal = new Date(now.getFullYear(), now.getMonth(), now.getDate(), jame, menite, detike);
	tgljadwalmulai = new Date(now.getFullYear(), now.getMonth(), now.getDate(), <?php echo substr($tgl_tayang1[1],0,2);?>,
	<?php echo substr($tgl_tayang1[1],3,2);?>, <?php echo substr($tgl_tayang1[1],6,2);?>);

    var jmljudul = 0;
    var jmlterm = 0;
    var jamjadwal, jamsaiki;
    var masuksiaran = false;
    var dalamsiaran = false;

    filler[1] = 'X7R-q9rsrtU';

    <?php
    if ($id_playlist == null) {
    ?>
    detikke[1] = <?php echo substr($tgl_tayang1[1], 0, 8);?>';
    <?php } else {
    ?>
    detikke[1] = keJam(tgljadwalmulai);
    <?php } ?>

    <?php
    echo "gabung='<table border=\"0\"><col width=\"80\">';";
    for ($q = 1; $q <= $jml_list; $q++) {

    	echo "judulke[" . $q . "] = '".$judulacara[$q]."'; \r\n";

        echo "idvideo[" . $q . "] = youtube_parser('" . $id_videolist[$q] . "'); \r\n";
        echo "durasike[" . $q . "] = '" . $durasilist[$q] . "'; \r\n";
        if ($q > 1) {
            echo "detikke[" . $q . "] = keJam(new Date(jamHitung(" . ($q-1) . ")+hitungDurasi(" . ($q-1) . "))); \r\n";
        }
        echo "durasi=durasi+hitungDurasi(" . $q . "); \r\n";

//
//        echo "console.log('Detikke " . $q . " = '+detikke[$q]); \r\n";
//        echo "console.log('Durasi " . $q . " = '+durasike[$q]); \r\n";
//        echo "console.log('Id ke " . $q . " = '+idvideo[$q]); \r\n";

        echo "gabung=gabung+'<tr><td valign=\"top\">'+detikke[" . $q . "].substring(0,5)+' WIB </td><td valign=\"top\">'+'".$judulacara[$q]."'+'</td></tr>';";
        //echo "gabung=gabung+'<br>'+detikke[" . $q . "].substring(0,5)+' WIB - '+'".$judulacara[$q]."';";
    };
    echo "gabung=gabung+'</table>';";
    ?>

    //console.log("Gabung:"+(gabung));

    $('#tempatJadwal').html(gabung);

    detik2 = 0;

    function ceklive() {
        detik2++;
        tglsaiki = new Date(tglnow.getTime() + (detik2 * 1000));

		detikbatas = detikke[jmlterm*jmljudul+1];
		jamjadwal = new Date("1970-01-01T" + detikbatas + "Z").getTime();
		jamsaiki = new Date("1970-01-01T" + jmmndt + "Z").getTime();

        if (tglsaiki - tgljadwal < 0 || jamsaiki >= jamjadwal) {
			tayanganhabis=true;
			masuksiaran = false;

			$('#layartancap2').show();
			$('#layartancap').hide();

            $('#keteranganLive').html("SEGERA TAYANG PUKUL: <?php if ($id_playlist == null)
                echo $tgl_tayang[$idliveduluan]; else
                echo $tayangpaket; ?>");
           // $('#divnamapaket').show();
            $('#keteranganLive').show();
            $('#infolive<?php echo $idliveduluan;?>').html("Segera Tayang");


        } else {

        	//console.log("masuk_siaran");
			tayanganhabis = false;
            masuksiaran = true;
            if ((tglsaiki - tgljadwal) < durasi) {

                dalamsiaran = true;
                if (loadsekali == false) {
                    loadsekali = true;
                    loadplayer();
                }

				$('#layartancap2').hide();
                $('#layartancap').show();
                $('#keteranganLive').html("");
             //   $('#divnamapaket').show();
                $('#keteranganLive').show();
                $('#infolive<?php echo $idliveduluan;?>').html("");
            } else {
                dalamsiaran = false;

				$('#layartancap2').show();
                $('#layartancap').hide();
                $('#keteranganLive').html("Belum tayang");
              //  $('#divnamapaket').hide();
                $('#keteranganLive').hide();
                $('#infolive<?php echo $idliveduluan;?>').html("");
                if (statuslive == 1) {
                    // gantistatusselesai();
                }
            }
        }
    }


    jmljudul = <?php echo $jml_list;?>;
    // if (durasi>0)
    jmlterm = ((86400-(durasi/1000)-durasimulai) / (durasi/1000)) - 1;

    if (jmlterm > 0) {
        for (var y = 1; y <= jmlterm; y++) {
            for (var z = 1; z <= jmljudul; z++) {
                detikke[y * jmljudul + z] = keJam(new Date("1970-01-01T" + detikke[z]).getTime() + durasi * y);
                durasike[y * jmljudul + z] = durasike[z];
                idvideo[y * jmljudul + z] = idvideo[z];
				judulke[y * jmljudul + z] = judulke[z];
                // console.log("detikke"+(y * jmljudul + z)+":"+detikke[y * jmljudul + z]);
				// console.log("judulke"+(y * jmljudul + z)+":"+judulke[y * jmljudul + z]);
            }
        }
    }

    function youtube_parser(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }

    function onYouTubeIframeAPIReady() {
        initialize();
        //readyyoutube = true;
        <?php

        if (($id_playlist != null && $statuspaket == 2)) {
            echo "// loadplayer(); \r\n";
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

        player = new YT.Player('isivideoyoutube', {
            width: 600,
            height: 400,
            videoId: <?php echo "idvideo[1]";?>,
            showinfo: 0,
            controls: 0,
            autoplay: 1,
            playerVars: {
                color: 'white',
                playlist: <?php echo "idvideolain";?>,
                origin: 'https://www.tvsekolah.id'
            },
            events: {
                'onReady': panggilsaya,
				'onStateChange': panggilsaya
            }
        });
    }

	function panggilsaya(evt) {

		var dafchannel = {"":""};
		readyyoutube = true;

    	<?php for ($a=1;$a<=$jml_list;$a++)
    		{
				preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $id_videolist[$a], $match);
				$youtube_id = $match[1];
    			echo 'dafchannel ["'.$youtube_id.'"] = "'.$namachannel[$a].'";';
    		}
    	?>
			var url = evt.target.getVideoUrl();
			var match = url.match(/[?&]v=([^&]+)/);
			var videoId = match[1];

		if (dafchannel[videoId]=="")
			$('#namachannel').html("Channel: ?");
		else
			$('#namachannel').html("Channel: "+dafchannel[videoId]);

	}

    function initialize() {

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
            //alert("Alert");
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


		{
        	if (readyyoutube)
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
                //location.reload();
                //console.log("HABIS JATAH:" + jatah);
				//terakhirterm = termke;
				//jadwalbaru(termke);
            }

			if (readyyoutube)
			{
				var setet = player.getPlayerState();
				{
					if ((setet==-1 || setet==5) && tayanganhabis==false)
					{
						$('#layartancap2').hide();
						player.playVideo();
					}
				}

			}

            if (cekjatah != jatah) {

                jatah = cekjatah;

                detiklokal = detikselisih;

				//jadwalbaru(jatah);
				termke = parseInt((jatah-1)/<?php echo $jml_list;?>)+1;
                // console.log("ini jatah:" + jatah);
				//console.log("ini term:" + termke);
				jadwalbaru(termke);

                if (detiklokal > durasike[jatah]) {
                    detiklokal = 0;
                    if (readyyoutube)
                    player.loadVideoById(filler[jatah]);
                } else {
					if (jatah==0)
					{
						//$('#layartancap').hide();
					}
					else {
						if (readyyoutube)
							player.loadVideoById(idvideo[jatah], detiklokal);
					}
                }
				if (readyyoutube && tayanganhabis==false)
				{
					$('#layartancap2').hide();
					player.playVideo();
				}


            } else {
                detiklokal = detiklokal + 1;
                if (readyyoutube)
                	videoPos = !player.getCurrentTime ? 0.0 : player.getCurrentTime();
                else
                	videoPos = 0;
                jarak = (videoPos - detiklokal);
				if (readyyoutube && tayanganhabis==false) {
					if (statusPlayer != 2) {
						if (jarak > 5 || jarak < -5)
							player.seekTo(detiklokal);
						$('#layartancap2').hide();
						player.playVideo();
					}
				}
            }
        }

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

		detikbatas = detikke[jmlterm*jmljudul+1];
		jamjadwal = new Date("1970-01-01T" + detikbatas + "Z").getTime();
		jamsaiki = new Date("1970-01-01T" + jmmndt + "Z").getTime();

		if (jamsaiki >= jamjadwal) {
			//location.reload();
			//console.log("HABISSSS");
			tayanganhabis = true;
			$('#layartancap').hide();
			$('#layartancap2').show();


		}

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


        if (cekjatah != jatah && tayanganhabis==false) {

            jatah = cekjatah;

            detiklokal = detikselisih;


            if (detiklokal > durasike[jatah]) {
                detiklokal = 0;
                player.loadVideoById(filler[1]);
            } else {
                player.loadVideoById(idvideo[jatah], detiklokal);
            }
			$('#layartancap2').hide();
            player.playVideo();
        } else {
            detiklokal = detiklokal + 1;
            videoPos = !player.getCurrentTime ? 0.0 : player.getCurrentTime();
            jarak = (videoPos - detiklokal);
            if (player.getPlayerState() != 2 && tayanganhabis==false) {
                if (jarak > 5 || jarak < -5)
                    player.seekTo(detiklokal);
				$('#layartancap2').hide();
                player.playVideo();
            }
        }
    }

    <?php
    if ($idliveduluan) {
    ?>

    function gantistatusselesai() {
        $.ajax({
            url: "<?php echo base_url();?>channel/gantistatuspaket_sekolah",
            method: "POST",
            data: {id: <?php echo $iddaflist[$idliveduluan];?>},
            success: function (result) {
                statuslive = 1;
                //detik2=0;
            }
        })
    }

    <?php } ?>


    $(document).on('ready', function () {
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5
        });
    });


	var count = 0;
	var myInterval;

	function isFunction(functionToCheck) {
		return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
	}

	function timerHandler() {
		if (readyyoutube)
		{
			var setet = player.getPlayerState();
				if (setet == 1) {
					count++;
				}
		}
		document.getElementById("seconds").innerHTML = "Durasi menonton: "+count+" detik.<br>(Refresh)";
		<?php if ($this->session->userdata("loggedIn")) {?>
		if (count>=150 && count%150==0)
			updatenonton();
		<?php } ?>
	}

	function updatenonton()
	{
		$.ajax({
			url: "<?php echo base_url();?>channel/updatenonton",
			method: "POST",
			data: {channel:1, npsn: "<?php echo $npsnku;?>", durasi: count},
			success: function (result) {

			}
		})
	}

	function startTimer() {
		window.clearInterval(myInterval);
		myInterval = window.setInterval(timerHandler, 1000);
	}

	function stopTimer() {
		window.clearInterval(myInterval);
	}

	function onFocus(){ startTimer()}
	function onBlur(){ stopTimer()}

	var inter;
	var iframeFocused;
	window.focus();      // I needed this for events to fire afterwards initially
	addEventListener('focus', function(e){
		//console.log('global window focused');
		if(iframeFocused){
			//console.log('iframe lost focus');
			iframeFocused = false;
			//clearInterval(inter);
		}
		else onFocus();
	});

	addEventListener('blur', function(e){
		//console.log('global window lost focus');
		if(document.hasFocus()){
			//console.log('iframe focused');
			iframeFocused = true;
			inter = setInterval(()=>{
				if(!document.hasFocus()){
					//console.log('iframe lost focus');
					iframeFocused = false;
					onBlur();
					clearInterval(inter);
				}
			},100);
		}
		else onBlur();
	});

	function jadwalbaru(termn) {
		gabung='<table border="0"><col width="80">';
		for (var q = 1+((termn-1)*<?php echo $jml_list;?>);
			 q <= <?php echo $jml_list;?>+((termn-1)*<?php echo $jml_list;?>);
			 q++) {
			gabung=gabung+'<tr><td valign="top">'+detikke[q].substring(0,5)+' WIB </td><td valign="top">'+judulke[q] + '</td></tr>';
		};
		gabung=gabung+'</table>';

		$('#tempatJadwal').html(gabung);

	}


</script>


