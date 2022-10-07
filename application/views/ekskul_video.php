<link href="https://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/4.12/video.js"></script>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$jml_video = 0;
foreach ($dafvideo as $datane) {
	$jml_video++;
}

$txt_contreng = Array('---', 'Masuk');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namasifat = Array('Publik', 'Pribadi', 'Bimbel');
$txtstatusver = Array("-", "-", "Disetujui", "", "Disetujui");

$statustayang = Array();
$kodehapus = "";
$statusvideo = "";


//echo "<br><br><br><br><br>CEK TUKAN VERIFIKATOR:".$this->session->userdata('tukang_verifikasi');

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
						<h1>Ekstrakurikuler Majalah Dinding</h1>
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
				<div style="margin-bottom: 10px;">
					<?php if ($this->session->userdata('sebagai')==2) {
						if ($status < 2 && $dibayaroleh!="sekolah"){?>
						<div style="margin-bottom: 10px;"><center><b>Silakan melakukan pembayaran iuran ekskul untuk bulan ini untuk bisa Upload Data Video</b></center></div>
					<?php }
					} else if($dibayaroleh!="sekolah" && $status=="non") {?>
						<div style="margin-bottom: 10px;"><center><b>Silakan melakukan pembayaran iuran ekskul untuk bulan ini untuk bisa mengubah status Video</b></center></div>
					<?php } ?>

					<?php if($asal=="dashboard") {?>
						<button class="btn-main"
								onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
						</button>
					<?php }
					else
						{ ?>
							<button class="btn-main"
									onclick="window.location.href='<?php echo base_url(); ?>ekskul/'">Kembali
							</button>
						<?php }?>


				</div>

				<hr>
				<?php if ($status_verifikator!="oke" && $this->session->userdata('sebagai')!=2) {?>
						<div style="font-weight:bold; color:red;margin-bottom: 12px;">Maaf, Tombol Verifikasi sementara tidak berfungsi.
						</div>
					<?php } ?>
				<center><h3>VIDEO EKSKUL</h3></center>

				<?php if($this->session->userdata('sebagai')==2 && ($status == 2 || $status == 12 || $dibayaroleh == "sekolah")){ ?>
				<div style="margin-bottom: 10px;">
					<button type="button" onclick="window.location.href='<?php echo base_url(); ?>ekskul/videotambah'"
							class="btn-main"
							style="float:right;margin-right:10px;margin-top:-20px;">Upload Data Video
					</button>
				</div>
				<?php } ?>

				<div style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tabel_data" class="table table-striped table-bordered nowrap" cellspacing="0"
						   width="100%">
						<thead>
						<tr>
							<th style='padding:5px;width:5px;'>No</th>
							<th>Tanggal Upload</th>
							<th>Judul</th>
							<th>Durasi</th>
							<!--				<th>Topik</th>-->
							<?php
							if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 1) {
								?>
								<th>Pengirim</th>
							<?php } ?>


							<th>Video</th>
							<th>Channel</th>
							<th>Status</th>

							<!--							<th>PlayList</th>-->
							<?php
							if ($this->session->userdata('sebagai') == 2) {
								?>
								<th>Edit</th>
							<?php } ?>
						</tr>
						</thead>
					</table>
				</div>
			</div>
	</section>
</div>

<center>
	<div
		style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;margin-bottom:20px;background-color:white;">
		<div id="video-placeholder" style='display:none'></div>
		<div id="videolokal" style='display:none'></div>
	</div>
</center>

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

		<?php
		$iver = "";
		$jml_video = 0;

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$tanggal = $datesekarang->format('d');
		$bulan = $datesekarang->format('m');
		$tahun = $datesekarang->format('Y');

		foreach ($dafvideo as $datane) {
		$jml_video++;
		$nomor = $jml_video;
		$id_video = $datane->id_video;
		$kode_video = $datane->kode_video;
		$idjenis = $datane->id_jenis;

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

		$deskripsi = $datane->deskripsi;
		$durasine = $datane->durasi;
		$keyword = $datane->keyword;

		$thumbnails = $datane->thumbnail;
		$namafile = $datane->file_video;
		$dilist = $datane->dilist;
		$sifat = $datane->sifat;

		$status_verifikasi = $datane->status_verifikasi;
		$status_verifikasi_admin = $datane->status_verifikasi_admin;
		//echo $datane->link_video;


		$catatan1 = $datane->catatan1;
		$catatan2 = $datane->catatan2;

		////////////////////////////////////
		$judule = str_replace('"', "'", $datane->judul);
		//		if ($statusvideo != 'pribadi' && ($statusvideo != 'bimbel')) {
		//			$ipengirim = '"' . $datane->first_name . ' ' . $datane->last_name . '", ';
		//		} else
		$ipengirim = "";

		if (isset($datane->sebagai))
			$isebagai = $datane->sebagai;
		else
			$isebagai = 0;

		$youtube_url = $datane->link_video;
		$id = youtube_id($youtube_url);
		$id = preg_replace("/\r|\n/", "", $id);
		$ivideo = '<button onclick=\"lihatvideo(\'' . $id . '\');\" data-video-id=\'STxbtyZmX_E\' ' .
			'type=\'button\'>Play</button>';


		if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 1) {
			$ipengirim = '"' . $datane->first_name . ' ' . $datane->last_name . '<br>[' . $datane->sekolah . ']", ';
		}



		if (($statusvideo != 'bimbel')) {
			$didisabled = '';
			if ($datane->sifat == 0)
				$warna = '#b4e7df';
			else if ($datane->sifat == 1)
				$warna = '#ffd0b4';
			else if ($datane->sifat == 2)
				$warna = '#96e748';
			if ($statusvideo == "sekolahkontri")
				$didisabled = 'disabled';
			$isifat = '<button ' . $didisabled . ' id=\"bt1_' . $datane->id_video .
				'\" style=\"background-color: ' . $warna . '\" onclick=\"gantisifat(\'' .
				$datane->id_video . '\')\"	type=\"button\">' . $namasifat[$datane->sifat] . '</button>';

			if ($datane->dilist == 0)
				$warna2 = '#cddbe7';
			else
				$warna2 = '#e6e6e6';

			$iplaylist = '<div style=\"background-color: ' . $warna2 . '\">' . $txt_contreng[$datane->dilist] . '</div>';

			//$isifatplaylist = '"' . $isifat . '", "' . $iplaylist . '", ';
			$isifatplaylist = '"' . $iplaylist . '", ';

		} else {
			$isifatplaylist = "";
		}

		$tglupload = namabulan_pendek($datane->tglupload) . " " . substr($datane->tglupload, 11);


		if ($datane->file_video != "") {
			$iver = '-';
		} else {
			$warna3 = '';
			if ($datane->status_verifikasi == 1 || $datane->status_verifikasi_admin == 3)
				$warna3 = 'color:red';
			else if ($datane->status_verifikasi >= 2)
				$warna3 = 'color:green';

			if ($datane->status_verifikasi == 0)
				$lulustidak = 'Belum diverifikasi';
			else if ($datane->status_verifikasi == 1)
				$lulustidak = 'Tidak Lulus';
			else if ($datane->status_verifikasi >= 2) {
				if ($datane->status_verifikasi_admin == 4)
					$lulustidak = 'Lulus';
				else if ($datane->status_verifikasi_admin == 3)
					$lulustidak = 'Batal Lulus';
			} else {
				$ketsekolah = "";

				if ($this->session->userdata('a01')) {
					$bayar = $datane->tgl_order;

					if ($bayar == null)
						$ketsekolah = "<br>[Non Aktif]";

					$tanggalorder = new DateTime($bayar);
					$batasorder = $tanggalorder->add(new DateInterval('P1D'));
					$bulanorder = $tanggalorder->format('m');
					$tahunorder = $tanggalorder->format('Y');

					$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

					if ($selisih >= 2) {
						$ketsekolah = "<br>[Non Aktif]";
					} else if ($selisih == 1) {
						if ($tanggal <= 5) {

						} else {
							$ketsekolah = "<br>[Non Aktif]";
						}

					}
				}

				//$lulustidak = 'Verifikasi' . $ketsekolah;
			}

			if ($this->session->userdata('sebagai') == 1 ) {
				if ($status_verifikator=="oke")
				{
					$lulustidak = '<button style=\"' . $warna3 . '\" onclick=\"window.location.href=\'' . base_url() .
						'ekskul/verifikasi/' . $datane->id_video . '\'\" id=\"btn-show-all-children\" type=\"button\">' .
						$lulustidak . '</button>';
				}
				else
				{
					$lulustidak = '<button style=\"' . $warna3 . '\" id=\"btn-show-all-children\" type=\"button\">' .
						$lulustidak . '</button>';
				}

			} else {
				if ($datane->status_verifikasi >= 2) {
					if ($this->session->userdata('tukang_kontribusi') == 2) {
						if ($datane->status_verifikasi_admin == 3)
							$iver = $datane->catatan2;
						else
							$iver = $datane->catatan1;
					} else if ($isebagai == 3)
						$iver = '';
					else
						$iver = '<span style=\"color:green\">Lulus</span>';
				} else if ($datane->status_verifikasi == 1) {
					$iver = '<button style=\"color:red\" onclick=\"alert(\'' .
						$datane->catatan1 . '\')\">Tidak Lulus</button>';
				}
			}
		}

		if ($datane->status_verifikasi_admin == 3) {
			$statustayang = 0;
			$itayang = "---";
		} else if (($datane->status_verifikasi == 2 || $datane->status_verifikasi == 4) && $datane->id_jenis == 1) {
			$statustayang = 1;
			$itayang = "V";
		} else if ($datane->status_verifikasi == 2 && $datane->id_jenis == 2) {
			$statustayang = 1;
			$itayang = "V";
		} else if ($datane->status_verifikasi == 4 && $datane->file_video != "") {
			$statustayang = 1;
			$itayang = "V";
		} else if ($datane->status_verifikasi == 4 && $datane->link_video != "") {
			$statustayang = 1;
			$itayang = "V";
		} else {
			$statustayang = 0;
			$itayang = "-";
		}

		if ($statusvideo != "verifikasi") {
			if ($statustayang <= 1) {
				$iedit1 = '<button onclick=\"window.location.href=\'' . base_url() . 'ekskul/editvideo/' . $datane->id_video . '\'\"' .
					' id=\"btn-show-all-children\" type=\"button\" ' .
					'class=\"myButtongreen\">Edit</button>';
			} else
				$iedit1 = '';

			if ($datane->status_verifikasi == 0 || $isebagai == 4 || $this->session->userdata('a01')) {

				$iedit2 = '<button onclick=\"return mauhapus(\'' . $kodehapus .
					$datane->id_video . '\')\" id=\"btn-show-all-children\" ' .
					'type=\"button\" class=\"myButtonred\">Hapus</button>';
			} else
				$iedit2 = '';

			$iedit = $iedit1 . $iedit2;
		} else
			$iedit = '';

		///////////////////////////////////////////////////////



		if ($this->session->userdata('sebagai') == 2) {
		?>
		data.push([<?php echo $jml_video;?>, "<?php echo $tglupload;?>", "<?php echo $judule;?>", "<?php echo $durasine;?>", <?php echo $ipengirim;?>"<?php
			echo $ivideo;?>", "<?php echo $datane->channeltitle;?>", "<?php echo $lulustidak;?>", "<?php echo $iedit;?>"]);
		<?php } else { ?>
		data.push([<?php echo $jml_video;?>, "<?php echo $tglupload;?>", "<?php echo $judule;?>", "<?php echo $durasine;?>", <?php echo $ipengirim;?>"<?php
			echo $ivideo;?>", "<?php echo $datane->channeltitle;?>", "<?php echo $lulustidak;?>"]);
		<?php }
		}
		?>

		$('#tabel_data').DataTable({
			data: data,
			deferRender: true,
			scrollCollapse: true,
			scroller: true,
			pagingType: "simple",
			language: {
				paginate: {
					previous: "<",
					next: ">"
				}
			},
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [2]
				},
				{responsivePriority: 1, targets: 0},
				{responsivePriority: 2, targets: 1},
				{responsivePriority: 10001, targets: 2},
				// {responsivePriority: 3, targets: -2},
				{
					width: 25,
					targets: 0
				}
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
			jump('video-placeholder');
		} else {
			if ((oldurl == url) && (document.getElementById("video-placeholder").style.display == 'block')) {
				document.getElementById("video-placeholder").style.display = 'none';
				player.pauseVideo();
			} else {
				document.getElementById("video-placeholder").style.display = 'block';
				player.cueVideoById(url);
				player.playVideo();
				jump('video-placeholder');
			}
		}
		oldurl = url;

	}

	function mauhapus(codex, idx) {

		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url(); ?>ekskul/hapusvideo/' + codex + '/' + idx, '_self');
		} else {
			return false;
		}
		return false;
	}

	function gantisifat(idx) {
		statusnya = 0;
		if ($('#bt1_' + idx).html() == "Publik") {
			statusnya = 1;
		}
		<?php if($this->session->userdata('a01') || $this->session->userdata('bimbel') == 3) {?>
		else if ($('#bt1_' + idx).html() == "Pribadi") {
			statusnya = 2;
		}
		<?php } ?>
		else {
			statusnya = 0;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantisifat",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if (result == "jangan")
					alert("Sudah dipakai di bagian lain");
				else {
					if ($('#bt1_' + idx).html() == "Publik") {
						$('#bt1_' + idx).html("Pribadi");
						$('#bt1_' + idx).css({"background-color": "#ffd0b4"});
					}
					<?php if($this->session->userdata('a01') || $this->session->userdata('bimbel') == 3) {?>
					else if ($('#bt1_' + idx).html() == "Pribadi") {
						$('#bt1_' + idx).html("Bimbel");
						$('#bt1_' + idx).css({"background-color": "#96e748"});
					}
					<?php } ?>
					else {
						$('#bt1_' + idx).html("Publik");
						$('#bt1_' + idx).css({"background-color": "#b4e7df"});
					}
				}
			}
		})

	}

	function gantilist(idx) {
		statusnya = 0;
		if ($('#bt2_' + idx).html() == "---") {
			statusnya = 1;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantilist",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if ($('#bt2_' + idx).html() == "---") {
					$('#bt2_' + idx).html("Masuk");
					$('#bt2_' + idx).css({"background-color": "#e6e6e6"});
				} else {
					$('#bt2_' + idx).html("---");
					$('#bt2_' + idx).css({"background-color": "#cddbe7"});
				}
			}
		})


	}

	function jump(h) {
		var top = document.getElementById(h).offsetTop;
		window.scrollTo(0, top - 100);
	}

</script>
