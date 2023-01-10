<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$durasidaf = Array("", "");
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$namaharis = Array('', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU');
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


	if ($id_playlist0 == $datane->link_list) {
		$statuspaket = $datane->status_paket;
		$namapaket = $datane->nama_paket;
		$thumbspaket = $thumbnail[$jmldaf_list];
		$tayangpaket = $tgl_tayang[$jmldaf_list];
	}

}

$durasisponsor = 0;

if ($punyalist) {
	$jml_list = 0;
	if ($url_sponsor != "") {
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
} else {
	$namapaket = "";
}

$jml_channel = 0;


foreach ($dafchannelguru as $datane) {
	$jml_channel++;
	$id_user[$jml_channel] = $datane->id_user;
	$first_name[$jml_channel] = $datane->first_name;
	$last_name[$jml_channel] = $datane->last_name;
	if ($datane->picture == null)
		$foto_guru[$jml_channel] = base_url() . 'assets/images/profil_blank.jpg';
	else if (substr($datane->picture, 0, 4) == 'http')
		$foto_guru[$jml_channel] = $datane->picture;
	else
		$foto_guru[$jml_channel] = base_url() . 'uploads/profil/' . $datane->picture;
}

$txt_contreng = Array('---', 'Masuk');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namasifat = Array('Publik', 'Modul', 'Bimbel', 'Playlist');
$statustayang = Array();

if ($opsi=="dashboard")
	$opsidashboard = "/dashboard";
else if ($opsi=="calver")
	$opsidashboard = "/calver";
else
	$opsidashboard = "";

if ($kodeevent!=null)
{
	$kodeevent = "/".$kodeevent;
}
else
{
	$kodeevent = "";
}

if ($jmldaf_list > 0) {
	if ($statuspaket == 1) {
		?>
		<div id="keteranganLive" style="text-align:center; color:black">
			<!--SEGERA TAYANG TANGGAL: <?php echo $tgl_tayang[1]; ?>-->
		</div>
	<?php }
} ?>

<?php if ($punyalist)
	$hitungdurasi = substr($durasidaf[1], 0, 2) * 3600 + substr($durasidaf[1], 3, 2) * 60 + substr($durasidaf[1], 6, 2);
else
	$hitungdurasi = 0;

$hitungdurasi = $hitungdurasi + 15 + $durasisponsor;

$jml_vid = 0;
$jamtayang[1] = $mulaijam;
foreach ($dafvideo as $datane) {
	$jml_vid++;
	$nomor[$jml_vid] = $jml_vid;
	$id_playlist[$jml_vid] = $datane->idchannel;
	$durasi = $datane->durasi;
	$durdetik = intval(substr($durasi,6,2));
	$durmenit = intval(substr($durasi,3,2));
	$durjam = intval(substr($durasi,0,2));
	$mulaidetik = intval(substr($jamtayang[$jml_vid],6,2));
	$mulaimenit = intval(substr($jamtayang[$jml_vid],3,2));
	$mulaijam = intval(substr($jamtayang[$jml_vid],0,2));
	$hasildetik = $mulaidetik + $durdetik;
	$simpanmenit = 0;
	if ($hasildetik>=60)
		{
			$hasildetik = $hasildetik - 60;
			$simpanmenit = 1;
		}
	$hasilmenit = $mulaimenit + $durmenit;
	$simpanjam = 0;
	if ($hasilmenit>=60)
	{
		$hasilmenit = $hasilmenit - 60;
		$simpanjam = 1;
	}
	$hasiljam = $mulaijam + $durjam;

	if ($hasiljam>=24)
	{
		$hasiljam = $hasiljam - 24;
	}

	if ($hasiljam+$simpanjam>=10)
		$sjam = $hasiljam+$simpanjam;
	else
		$sjam = "0".($hasiljam+$simpanjam);

	if ($hasilmenit+$simpanmenit>=10)
		$smenit = $hasilmenit+$simpanmenit;
	else
		$smenit = "0".($hasilmenit+$simpanmenit);

	if ($hasildetik>=10)
		$sdetik = $hasildetik;
	else
		$sdetik = "0".$hasildetik;


	$jamtayang[$jml_vid+1] = $sjam.":".$smenit.":".$sdetik;

	?>
	<input type="hidden" name="isiankotak<?php echo $jml_vid;?>" 
	id="isiankotak<?php echo $jml_vid;?>" value="<?php echo $datane->urutan;?>"></div>
	<?php
}

if ($jml_video == 0) { ?>
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
							<h1>Ekstrakurikuler</h1>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</section>
		<!-- section close -->


		<section aria-label="section" class="mt0 sm-mt-0">
			<div class="container">
				<div class="row">
					<br>
					<center>
						<span style="font-size:16px;font-weight: bold;">ANDA BELUM MEMILIKI VIDEO DI DALAM PAKET PLAYLIST</span>
					</center>
					<br>
					<center>
						<button onclick="window.open('<?php echo base_url() . "channel/inputplaylist_kampus/". $kodepaket;?>','_self');"
								class="btn-main">Input Paket Video Playlist
						</button>
					</center>
				</div>
			</div>
		</section>
	</div>
	<?php
} else {
	?>
	<div class="no-bottom no-top" id="content">
		<div id="top"></div>
		<!-- section begin -->
		<section id="subheader" class="text-light"
				 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
			<div class="center-y relative text-center">
				<div class="container">
					<div class="row">

						<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
							<h1>Ekstrakurikuler</h1>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</section>
		<!-- section close -->


		<section aria-label="section" class="pt0">
			<div class="container">
				<div class="row">

					<center>
						<h3>URUTAN JAM TAYANG PLAYLIST HARI <?php echo strtoupper(namahari_panjang($harike)); ?></h3></center>
					<br>
					<div style="margin-bottom: 10px;">
						<button onclick="window.location.href='<?php echo base_url().'channel/playlistkampus'.$opsidashboard.$kodeevent;?>'"
								class="btn btn-main">Kembali
						</button>

						<button
							onclick="window.location.href='<?php echo base_url(); ?>channel/inputplaylist_kampus/<?php echo $kodepaket.$opsidashboard.$kodeevent; ?>'"
							class="btn btn-main">Input Paket Playlist
						</button>
					</div>

					<!--	<button style="margin-left:10px" id="btn-show-all-children" type="button">Buka Semua</button>-->
					<!--	<button style="margin-left:10px" id="btn-hide-all-children" type="button">Tutup Semua</button>-->
					<hr>
					<div class="col-lg-8 col-md-8">
						<div style="margin-bottom: 15px;">
							<button type="button" onclick="updatedata()" class=""
									style="float:right;margin-right:10px;margin-top:-20px;">Update
							</button>
						</div>

						<div style="font-size:12px;margin-left:10px;margin-right:10px;">
							<table id="tabel_data" class="table table-striped table-bordered nowrap" cellspacing="0"
								width="100%">
								<thead>
								<tr>

									<th style='padding:5px;width:15px;'>No</th>
									<th>Judul</th>
									<th>Jam Tayang</th>
									<th>Durasi</th>
									<th style='padding:5px;width:15%;'>Urutan</th>
									<th class="none">Video</th>
									<th class="none">Topik</th>
								</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="col-md-4 col-lg-4">
						<div id="jamsekarang"
										style="font-weight: bold;color: black;float: right; margin-right: 20px"
										id="jam">
						</div>
						<br><br>
						<div style="font-size:12px;margin-left:20px;border:1px solid black">
							<div style="font-size:12px;text-align: center;font-weight: bold;font-size:16px;color:#000">
							SIARAN PLAYLIST TERJADWAL 
							</div>
							
							<div id="tempatJadwal" style="margin-left:10px;margin-right:10pxfont-size:12px;font-weight: normal;color:#000;height: 500px;overflow: auto;">

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<?php
}
?>

<div style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<div id="video-placeholder" style='display:none'></div>
	<div id="videolokal" style='display:none'></div>
</div>

<style type="text/css" class="init">
.text-wrap {
	white-space: normal;
}
</style>


<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
<script>

	var oldurl = "";
	var oldurl2 = "";

	$(document).on('change', '#itahun', function () {
		get_analisis_view();
	});

	function get_analisis_view() {
		window.open("/rtf2/home/filter/" + $('#itahun').val() +
			"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
	}

	$(document).ready(function () {
		var data = [];

		////////////////////////////////////////////////////////
		<?php
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$tanggal = $datesekarang->format('d');
		$bulan = $datesekarang->format('m');
		$tahun = $datesekarang->format('Y');

		$nomor = 0;
		foreach ($dafvideo as $datane) {
		$nomor++;
		$id_video = $datane->idvideo;
		$kode_video = $datane->kode_video;
		$idjenis = $datane->id_jenis;
		$jenis = $txt_jenis[$datane->id_jenis];
		$id_jenjang = $datane->id_jenjang;
		$id_kelas = $datane->id_kelas;
		$id_mapel = $datane->id_mapel;
		$id_ki1 = $datane->id_ki1;
		$id_ki2 = $datane->id_ki2;
		$id_kd1_1 = $datane->id_kd1_1;
		$id_kd1_2 = $datane->id_kd1_2;
		$id_kd1_3 = $datane->id_kd1_3;
		$id_kd2_1 = $datane->id_kd2_1;
		$id_kd2_2 = $datane->id_kd2_2;
		$id_kd2_3 = $datane->id_kd2_3;
		$id_kategori = $datane->id_kategori;
		$uploader = $datane->first_name . " " . $datane->last_name;
		$topik = $datane->topik;
		$judul = $datane->judul;
		$durasi = $datane->durasi;
		$deskripsi = $datane->deskripsi;
		$keyword = $datane->keyword;
		$link = preg_replace('/\s+/', '', $datane->link_video);
		$namafile = $datane->file_video;
		$dilist = $datane->dilist;
		$sifat = $datane->sifat;
		$urutan = $datane->urutan;
		$iurutan = "<input onchange='checkInput(this)' style='text-align:center;' size='5px' maxlength='3' type='text'" .
			"name='iurut" . $nomor . "' id='iurut" . $nomor . "' value='" . $urutan . "'>";
		if ($link != "") {
			$youtube_url = $link;
			$id = youtube_id($youtube_url);

			$playit = "<button onclick='lihatvideo(\'" . $id . "\')' id='thumbnail' data-video-id='STxbtyZmX_E'" .
				" type='button'>Play</button>";
		} else if ($namafile != "") {
			$nama_video = $namafile;
			$playit = "<button onclick='lihatvideo2(\'" . $nama_video . "\')' type='button'>Play</button>";
		}
		?>


		data.push([<?php echo $nomor;?>,"<?php echo $judul;?>", "<?php echo $jamtayang[$nomor];?>","<?php echo $durasi;?>", "<?php echo $iurutan;?>", "<?php echo $playit;?>", "<?php echo $topik;?>"]);

		// data.push(['1', 'Judul', 'sa', 'as', "as", "as"]);
		<?php }
		?>

		////////////////////////////////////////////////////////
		var tglnow;
		var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
		<?php
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
			echo "tglnow = new Date('" . $stampdate . "');";
		?>
		var jamnow = tglnow.getTime();
		var jambaru;
		var menitbaru;
		var detikbaru;
		var xJam;
		var yJam;
		var detikke = new Array();
		var durasike = new Array();
		var idvideo = new Array();
		var totaldurasi = new Array();
		var durasidetik = new Array();
		var judulacara = new Array();
		var tgl, bln, thn, jam, menit, detik, jmmndt;
		var totalseluruhdurasi = 0;
		var jammulaitayang =<?php echo substr($tgl_tayang[1], 0, 2);?>;
		var jumlahjudul = <?php echo $jml_list;?>;
		var posisijudul = 1;
		var jambulatawal = 0;
		var sisadetikawal = 0;
		var detiklokal;
		var gabung = "";
		var durasipaket = <?php echo $hitungdurasi; ?>;
		var jambulat = Math.ceil(durasipaket / 3600);
		var jamawal = <?php echo substr($stampdate, 11, 2);?>;
		var menitawal = <?php echo substr($stampdate, 14, 2);?>;
		var detikawal = <?php echo substr($stampdate, 17, 2);?>;
		var totaldetikawal = jamawal * 3600 + menitawal * 60 + detikawal;
		var yutubredi = false;

		jamsekarangini = new Date(jamnow).getHours();
		jambulatawal = jammulaitayang + ((jamsekarangini-jammulaitayang)/jambulat);

		detikke[1]="0"+jammulaitayang+":00:00";
		

		$.get("<?php echo base_url() . 'channel/realdate';?>", function (Jam) {
			yJam = Jam;
		});

		setInterval(updateJam, 1000);

		function updateJam() {
			$.get("<?php echo base_url() . 'channel/realdate';?>", function (Jam) {
				yJam = Jam;
			});
			jamnow = Date.parse(yJam);
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


			//////////////////////////////////////////////

			jambaru = yJam.substring(11, 13);
			menitbaru = yJam.substring(14, 16);
			detikbaru = yJam.substring(17, 19);
			// console.log("JAM BARU:"+jambaru);
			// console.log("MENIT BARU:"+menitbaru);
			// console.log("DETIK BARU:"+detikbaru);
			jamjadwal = detikke[1].substring(0, 2);
			durasijam = parseInt(jambaru) * 3600 + parseInt(menitbaru) * 60 + parseInt(detikbaru);
			durasijadwal = parseInt(jamjadwal) * 3600;
			if (durasijam - durasijadwal >= totalseluruhdurasi) {
				initbaru();
			} else {
				sisatayang = totalseluruhdurasi - (durasijam - durasijadwal);
				// else
				// 	console.log("kosong:"+(sisatayang));
			}

		}

		function initbaru() {
			jambulatawal = parseInt(detikke[1].substring(0, 2)) + jambulat;
			gabung = '<table border="0"><col width="80">';
			for (var q = 1; q <= <?php echo $jml_list;?>; q++) {
				if (q == 1) {
					jambulatawalcek = jambulatawal;
					if (jambulatawalcek < 10)
						strjambulatawal = "0" + jambulatawalcek;
					else
						strjambulatawal = jambulatawalcek;
					detikke[q] = strjambulatawal + ':00:00';
				} else {

					posisijudul = 1;
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
				// console.log('Id ke ' + q + ' = ' + idvideo[q]);
				// console.log('Durasi ke ' + q + ' = ' + durasike[q]);
				// console.log('Total durasi ke ' + q + ' = ' + totaldurasi[q]);
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

			$('#tempatJadwal').html(gabung);
		}

		<?php
		$totaldurasi = 0;

		for ($q = 1; $q <= $jml_list; $q++) {
			echo "idvideo[" . $q . "] = youtube_parser('" . trim($id_videolist[$q]) . "'); \r\n";
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
			// console.log('Id ke ' + q + ' = ' + idvideo[q]);
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

		totalseluruhdurasi = <?php echo $totaldurasi;?>;
		//console.log("Total Durasi:"+totalseluruhdurasi);
		jadwaltayangawal = detikke[1];

		//console.log("Jadwal Tayang 1:"+jadwaltayangawal);


		function youtube_parser(url) {
			var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
			var match = url.match(regExp);
			return (match && match[7].length == 11) ? match[7] : false;
		}
		////////////////////////////////////////////////////////

		

		$('#tabel_data').DataTable({
			data: data,
			deferRender: true,
			scrollCollapse: true,
			scroller: true,
			// pagingType: "simple",
			// language: {
			// 	paginate: {
			// 		previous: "<",
			// 		next: ">"
			// 	}
			// },
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap'>" + data + "</div>";
					},
					targets: [1,2,3,4]
				},
				{responsivePriority: 1, targets: 0},
				{responsivePriority: 10001, targets: 3},
				{responsivePriority: 2, targets: 1},
				{responsivePriority: 3, targets: 4},
				{width: 25, targets: 0},
				{width: 200, targets: 1},
			],
			"order": [[0, "asc"]]
		});
	});

	function lihatvideo(url) {
		document.getElementById("videolokal").style.display = 'none';
		$('#videolokal').html('');

		if (oldurl == "") {
			document.getElementById("video-placeholder").style.display = 'block';
			player.cueVideoById(url);
			player.playVideo();
		} else {
			if ((oldurl == url) && (document.getElementById("video-placeholder").style.display == 'block')) {
				document.getElementById("video-placeholder").style.display = 'none';
				player.pauseVideo();
			} else {
				document.getElementById("video-placeholder").style.display = 'block';
				player.cueVideoById(url);
				player.playVideo();
			}
		}
		oldurl = url;
	}

	function lihatvideo2(url2) {
		player.pauseVideo();
		$('#videolokal').html('<video width="600" height="400" autoplay controls>' +
			'<source src="<?php echo base_url();?>uploads/tve/' + url2 + '" type="video/mp4">' +
			'Your browser does not support the video tag.</video>');
		//alert ("VIDEO");
		document.getElementById("video-placeholder").style.display = 'none';
		if (oldurl2 == "") {
			document.getElementById("videolokal").style.display = 'block';
			//document.getElementById("videolokal").value = "NGENGOS";
		} else {
			if ((oldurl2 == url2) && (document.getElementById("videolokal").style.display == 'block')) {
				document.getElementById("videolokal").style.display = 'none';
				$('#videolokal').html('');
				//document.getElementById("videolokal").value = "NGENGOS";
			} else {
				document.getElementById("videolokal").style.display = 'block';
				//document.getElementById("videolokal").value = "NGENGOS";
			}
		}
		oldurl2 = url2;
	}

	function updatedata() {

		var urutbaru = new Array();
		var idvid = new Array();


		<?php
		for ($i = 0; $i < $jml_vid; $i++) {
			echo "urutbaru[" . $i . "]=$('#isiankotak" . ($i + 1) . "').val();";
			echo "idvid[" . $i . "]=" . $id_playlist[($i + 1)] . ";";
		}
		?>
		
		// alert (urutbaru);
		// alert (idvid);


		$.ajax({
			url: "<?php echo base_url();?>channel/updateurutan_sekolah",
			method: "POST",
			data: {id: idvid, urutan: urutbaru},
			success: function (result) {
				location.reload();
			}
		})


	}

	function checkInput(data) {
		var id=data.id.substr(5);
		$('#isiankotak'+id).val(data.value);
	}

</script>
