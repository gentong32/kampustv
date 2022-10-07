<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$do_not_duplicate = array();
$namabulan = array("", "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");

$jml_video1 = 0;

$links = array("","channel","vod","virtualkelas","festival");

$submenu = array("","Panggung Sekolah","Perpustakaan Digital","Kelas Virtual","Festival TV Sekolah");
$submenu2 = array("","Kanal TV Streaming untuk Unjuk Kreasi Siswa","Video Pembelajaran dari Semua untuk Semua",
	"Platform Pembelajaran Elektronik untuk Sekolah","Gamifikasi untuk Jalur Prestasi Siswa");

foreach ($dafberita as $datane) {

    if (in_array($datane->kode_berita, $do_not_duplicate)) {
        continue;
    } else {
        $do_not_duplicate[] = $datane->kode_berita;
        $jml_video1++;
        $nomor1[$jml_video1] = $jml_video1;
        $id_video1[$jml_video1] = $datane->kode_berita;
        $id_kategori1[$jml_video1] = $datane->id_kategori;
        $thumbnails1[$jml_video1] = $datane->thumbnail;
        $judul1[$jml_video1] = $datane->judul;
        $deskripsi1[$jml_video1] = $datane->deskripsi;
        $keyword1[$jml_video1] = $datane->keyword;
        $link1[$jml_video1] = $datane->link_video;
        $filevideo1[$jml_video1] = $datane->file_video;

        $tglbaru = new DateTime($datane->modified);

//        echo "TES15Juli==>>>JML_Video:".$jml_video1.",Tanggal".$tglbaru->format('d').
//            ",Bulan".$tglbaru->format('m').",Tahun".$tglbaru->format('Y')."<br>";
        $tgl[$jml_video1] = "[" . $tglbaru->format('d') . ' ' . $namabulan[intval($tglbaru->format('m'))] . " " . $tglbaru->format('Y') . "]";

        $durasi1[$jml_video1] = $datane->durasi;
        if (substr($datane->durasi, 0, 2) == "00")
            $durasi1[$jml_video1] = substr($datane->durasi, 3, 5);

        $thumbs1[$jml_video1] = $datane->thumbnail;
        if (substr($thumbs1[$jml_video1], 0, 4) != "http")
            $thumbs1[$jml_video1] = base_url()."uploads/thumbs/" . $thumbs1[$jml_video1];
        if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
            $thumbs1[$jml_video1] = base_url()."assets/images/thumbx.png";

        $modified1[$jml_video1] = $datane->modified;

    }

}

//$tgl = array('',$tanggalberita[1],'[1 Des 2019]','[27 Nov 2019]','[23 Nov 2019]','[13 Okt 2019]');

if ($this->session->userdata('loggedIn'))
{
?>
		<div class="container" style="padding-top:10px;padding-bottom:10px;
margin-top: 0px;text-align;height:75px;center;width: 100%;background-color: #3d546f">
			<?php if($sudahikut==false) {
				if ($kodeeventdefault == "kosong") {
					?>
					<center>
						<a href="#" onclick="return lihatevent()" class="myButtonDaftar">LIHAT EVENT</a>
					</center>
					<?php
				} else {
					?>
					<center>
						<a href="#" onclick="return daftarkansaya('<?php echo $kodeeventdefault; ?>')"
						   class="myButtonDaftar">IKUT EVENT</a>
					</center>
				<?php }
			}
			?>
		</div>
<?php } else { ?>
<div class="container" style="padding-top:10px;padding-bottom:10px;
margin-top: 0px;text-align;height:75px;center;width: 100%;background-color: #3d546f">
	<center><a href="login/daftar" class="myButtonDaftar">DAFTAR GRATIS</a></center>
</div>
<?php } ?>

<div class="container" style="padding-top:10px;padding-bottom:0px;margin-top: 0px;
text-align:center;width: 100%;background-color: #5faabd">
    <span style="font-weight: bold;font-size: 24px;color: white">FITUR UTAMA</span>
    <div style="margin-right: auto;margin-left: auto;max-width: 100%">
        <div class="rowvod">

            <?php for ($a1 = 1; $a1 <= 4; $a1++) {
//                $judulTitle = ucwords(strtolower($judul1[$a1]));
//                if (strlen($judulTitle) > 62) {
//                    $judulTitle = substr(ucwords(strtolower($judul1[$a1])), 0, 62) . ' ...';
//                }
                echo '<div class="columnvod" style="height:280px;">
			
	        <a href="'.base_url().$links[$a1].'"> 
			 <div class="grup" style="margin:auto;width:220px;position:relative;text-align:center">
			 
			
			<img style="margin-bottom:10px;align:middle;width:180px;height:180px" src="assets/images/tbbaru' . $a1 . '.png"><br>
			<span style="color:#ffffff;font-size:14pt;font-weight:bold;">'.$submenu[$a1].'</span><br>
			<span style="color:#ffffff;font-size:13pt;">'.$submenu2[$a1].'</span><br>
			
			</div>
			  
			</div></a>';
            }
            ?>

        </div>
    </div>
</div>

<div class="container bgimg" style="padding-bottom:10px;padding-top:30px;margin-top: 0px;text-align:center;width: 100%">
    <span style="font-weight: bold;font-size: 24px;color: black">Berita</span>

    <div class="rowvod">

        <?php for ($a1 = 1; $a1 <= $jml_video1; $a1++) {
            $judulTitle = ucwords(strtolower($judul1[$a1]));
            if (strlen($judulTitle) > 62) {
                $judulTitle = substr(ucwords(strtolower($judul1[$a1])), 0, 62) . ' ...';
            }
            echo '<div class="columnvod" style="height:180px">
			
	        <a href="'.base_url().'watch/news/' . $id_video1[$a1] . '"> 
			 <div class="grup" style="margin:auto;width:220px;position:relative;text-align:center">
			 <div style="font-size:11px;background-color:black;color:white;position: absolute;right:10px;bottom:10px">'
                . $durasi1[$a1] . '</div>
			
			<img style="align:middle;width:220px;height:130px" src="' . $thumbs1[$a1] . '"><br>
			</div>
			<div class="grup" style="text-align:center">
			
			<div style="color:black;font-weight: bold" id="judulvideo">' . $judulTitle . '</div>
			<div style="color:black; font-weight: normal;font-size: smaller; text-align: center" id="judulvideo">' . $tgl[$a1] . '</div>
	
			</div>			  
			</div></a>';
        }
        ?>
    </div>
</div>

<div class="container" style="padding-top:10px;padding-bottom:10px;
margin-top: 0px;text-align;height:75px;center;width: 100%;background-color: #8cbdac">
	<center><a href="payment/donasi" class="myButtonDonasi">DONASI</a>
	<?php
	if($pernahdonasi) {?>
		<a href="payment/cetakdonasi/<?php echo $lastdonasi;?>" class="myButtonDonasi">Cetak Sertifikat</a>
	<?php }?></center>
</div>

<dialog id="myDialog" style="display:<?php
if ($message == "Login Gagal")
    echo "block"; else echo "none";
?>;top:100px;">
    <div class="text-center" style="margin-top:10px;">
        USERNAME ATAU PASSWORD GAGAL!!!<br>
        <button type="submit" id="tombolku2">Tutup</button>
    </div>
</dialog>

<script>

    $(document).ready(function () {
        //$('#tombolku').click();
        //$('#myDialog').show();
    });

    tombolku2.onclick = function () {
        document.getElementById("myDialog").setAttribute('style', 'display: none');
        document.getElementById("myDialog").hide();
    };

	function daftarkansaya(kodeevent) {
		<?php if($iuran==0) {?>
		$('#daftarkansaya-button').attr("disabled", "disabled");
		$.ajax({
			url: '<?php echo base_url();?>payment/free_event/'+kodeevent,
			cache: false,
			success: function (data) {
				window.open("<?php echo base_url();?>event/terdaftar/"+kodeevent,'_self');
			}
		});
		<?php } else {?>
		$('#daftarkansaya-button').attr("disabled", "disabled");
		window.open('<?php echo base_url();?>event/ikutevent/'+kodeevent,'_self');
		<?php } ?>
	};

	function lihatevent() {
		window.open("<?php echo base_url().'event/spesial/acara';?>");
	}

</script>
