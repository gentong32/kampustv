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

$tgl_tayang = array("", "");
$tgl_tayang1 = array("", "");

$do_not_duplicate = array();

if ($this->session->userdata('loggedIn') && !$this->session->userdata('a01')) {
	foreach ($channelku as $datane) {
		$jml_channelku = 1;
		$npsnku = $datane->npsn;
		//$kodeku = $datane->kode_sekolah;
		$nama_sekolahku = $datane->nama_sekolah;
		$logoskolah = $datane->logo;
		if ($logoskolah != "") {
			$logoku = "uploads/profil/" . $logoskolah;
		} else {
			$logoku = "assets/images/tutwuri.png";
		}
	}
}

$jml_channel = 0;
foreach ($dafchannel as $datane) {

	if (in_array($datane->npsn, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->npsn;
		$jml_channel++;
		$npsn[$jml_channel] = $datane->npsn;
		//$kode[$jml_channel] = $datane->kode_sekolah;
		$nama_sekolah[$jml_channel] = $datane->nama_sekolah;
		$logo[$jml_channel] = $datane->logo;
		if ($logo[$jml_channel] != "") {
			$logo[$jml_channel] = "uploads/profil/" . $logo[$jml_channel];
		} else {
			$logo[$jml_channel] = "assets/images/tutwuri.png";
		}
	}
}

$jmltotal = $jml_channel - $jml_channelku;
if ($this->session->userdata('a01'))
	$jmltotal = $jml_channel;

?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>

	<!-- section begin -->
	<section id="subheader" class="text-light" data-bgimage="url(<?php echo base_url();?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Channel TV Prodi</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section">
		<div class="container">
			<div class="row">

				<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari sekolah..">
				<center>
				<div class="" style="margin-top: 20px;">
					<?php if ($jml_channelku && !$this->session->userdata('a01')) { ?>
						<div class="induksek"
							 style="vertical-align: text-top; display: inline-block; padding-left: 10px;padding-right: 10px;">
							<a href="<?php echo base_url(); ?>channel/sekolah/<?php echo 'ch' . $npsnku; ?>"
							   style="display: inline-block">
								<div class="avatar lebarikon logosek"
									 style="text-align:center;background-image: url('<?php echo base_url() . $logoku ?>');">
								</div>
								<div class="lebarikon namasek" style="text-align:center;">
						<div style="font-size:12px;line-height:1;font-weight: bold;color: black"><?php echo $nama_sekolahku; ?></div>
								</div>

							</a>
						</div>
					<?php }

					for ($i = 1; $i <= $jmltotal; $i++) { ?>
						<div class="induksek"
							 style="vertical-align: text-top; display: inline-block; padding-left: 10px;padding-right: 10px;">
							<a href="<?php echo base_url(); ?>channel/sekolah/<?php echo 'ch' . $npsn[$i]; ?>"
							   style="display: inline-block">
								<div class="avatar lebarikon logosek"
									 style="text-align:center;background-image: url('<?php echo base_url() . $logo[$i] ?>');">
								</div>
								<div class="lebarikon namasek" style="text-align:center;">
									<div style="font-size:12px;line-height:1;font-weight: bold;color: black"><?php echo $nama_sekolah[$i]; ?></div>
								</div>

							</a>
						</div>
					<?php } ?>
				</div>
				<div style="margin:20px;">
					<?php if ($jml_channelku == 0 && !($this->session->userdata('a01'))) { ?>
						<div style="margin-top:20px;font-weight: bold;color: #49a6e8">Channel Sekolah anda belum
							tersedia?<br>
							Login sebagai Verifikator untuk bisa membuat channel!
						</div>
					<?php } ?>
				</div>
				</center>
			</div>
		</div>
	</section>
</div>

	<script>
		function myFunction() {
			// Declare variables
			var input, filter, ul, ulinduk, li, a, b, i, txtValue;
			input = document.getElementById('myInput');
			filter = input.value.toUpperCase();
			ul = document.getElementsByClassName("namasek");
			ulinduk = document.getElementsByClassName("induksek");
			// li = ul.getElementsByTagName('li');

			// Loop through all list items, and hide those who don't match the search query
			for (i = 0; i < ul.length; i++) {
				a = ul[i];
				b = ulinduk[i];
				txtValue = a.textContent || a.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					//a.style.display = "";
					b.style.display = "inline-block";
				} else {
					//a.style.display = "none";
					b.style.display = "none";
				}
			}
		}
	</script>
