<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$kettayang = array('Kosong', 'Belum/Sedang Tayang', 'Sudah Tayang');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$ketstatusmentor = Array('<center><i>Belum Dicek</i></center>', '<center>Belum OK</center>', '<center>OK</center>');

$jml_paket = 0;
foreach ($dafpaket as $datane) {
	$jml_paket++;
	$nomor[$jml_paket] = $jml_paket;
	$id_paket[$jml_paket] = $datane->id;
	$nama_kelas[$jml_paket] = substr($datane->nama_kelas,6);
	$semester[$jml_paket] = $datane->semester;
	$nama_mapel[$jml_paket] = $datane->nama_mapel;
	$link_paket[$jml_paket] = $datane->link_list;
	$nama_paket[$jml_paket] = $datane->nama_paket;
	$status_video_ver[$jml_paket] = $datane->status_max;
	$keteranganmod[$jml_paket] = "";

	if($datane->modulke>0 && $datane->modulke<100)
		{
			$mingguke[$jml_paket] =  $datane->modulke;
			// if ($datane->modulke!=17 && $datane->modulke!=18 && $datane->modulke!=19 && $datane->modulke!=20)
			if ($datane->semester==1)
			$gettglmodul = hitungtanggalmodul($datane->modulke,$datane->semester,$krs->start_tgl1,$krs->start_bln1);
			else
			$gettglmodul = hitungtanggalmodul($datane->modulke,$datane->semester,$krs->start_tgl2,$krs->start_bln2);
			$keteranganmod[$jml_paket] = "(".$gettglmodul['fulltgl'].")";
			
		}
	else
		$mingguke[$jml_paket] = "-";
	$durasi_paket[$jml_paket] = $datane->durasi_paket;
	$status_paket[$jml_paket] = $datane->status_paket;
	$status_soal[$jml_paket] = $datane->statussoal;
	$status_tugas[$jml_paket] = $datane->statustugas;
	$status_mentor[$jml_paket] = $ketstatusmentor[$datane->statusmentor];
	if ($datane->statusmentor==1)
		$status_mentor[$jml_paket]  = $datane->catatanmentor;
	$materi[$jml_paket] = $datane->uraianmateri;
	$tayang_paket1[$jml_paket] = $datane->tanggal_tayang;
	$tglvicon = $datane->tglvicon;
	$tglsekarang = new DateTime();
	$tglsekarang->setTimezone(new DateTimeZone('Asia/Jakarta'));
	if ($datane->nama_paket == "UTS"||$datane->nama_paket == "UAS"||$datane->nama_paket == "REMEDIAL UTS"||$datane->nama_paket == "REMEDIAL UAS")
	{
		if ($tglvicon == "2021-01-01 00:00:00")
			$tayang_paket[$jml_paket] = "-";
		else
			$tayang_paket[$jml_paket] = '<div style="font-size:14px;">'.substr($datane->tanggal_tayang,8,2).' '.$namabulan[(int)(substr($datane->tanggal_tayang,5,2))].' '.substr($datane->tanggal_tayang,0,4).', '.substr($datane->tanggal_tayang,11,5).' WIB</div>';
	}
	else {
		if ($tglvicon == "2021-01-01 00:00:00")
			$tayang_paket[$jml_paket] = "<div style='font-size:14px;'><button onclick=\"setjadwalvicon('" . $datane->link_list . "')\">Set Jadwal Baru</button></div>";
		else
			$tayang_paket[$jml_paket] = "<div style='font-size:14px;'><button onclick=\"setjadwalvicon('" . $datane->link_list . "')\">" . substr($datane->tglvicon, 8, 2) . ' ' . $namabulan[(int)(substr($datane->tglvicon, 5, 2))] . ' ' . substr($datane->tglvicon, 0, 4) . ', ' . substr($datane->tglvicon, 11, 5) . ' WIB' . "</button></div>";
	}
}

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
						<h1>Kelas Virtual</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="text-center">Daftar Modul Prodi Kampus</h3>
				</div>
				<div style="margin-bottom: 10px;">
					<!-- <button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/sekolah_saya'">Dashboard
					</button> -->
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/modul_guru/saya/tampilkan'">Tampilkan Modul Lengkap
					</button>
				</div>
				<hr>
				<span style="color: red; font-style: italic;">*Jadwal Ujian akan ditentukan oleh Verifikator Prodi</span>
				<?php if ($referrer!="") { ?>
				<span style="color: red; font-style: italic;">*Modul akan diverifikasi oleh Mentor terlebih dahulu</span>
				<?php } ?>

				<?php if($referrer=="") { ?>
					<div style="margin-bottom: 10px;">
					<button type="button" onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/tambahujian'"
							class="btn-main"
							style="float:right;margin-right:10px;margin-top:10px;">Tambah UTS-UAS-Remedial
					</button>
					<button type="button" onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/tambahmodul'"
							class="btn-main"
							style="float:right;margin-right:10px;margin-top:10px;">Tambah Modul Baru
					</button>
					</div>
				<?php }
				else
				{ ?>
					<!-- <div style="margin-bottom: 10px;">
						<button type="button" onclick="window.location.href='<?php echo base_url(); ?>virtualkelas/event/3/2022'"
								class="btn-main"
								style="float:right;margin-right:10px;margin-top:-20px;">Tambah Modul
						</button>
					</div> -->

				<?php } ?>
				

			</div>


			<div id="tabel1" style="margin-left:10px;margin-right:10px;">
				<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th style='padding:5;width:5px;'>No</th>
						<th>Smst</th>
						<th>Mata Kuliah</th>
						<th>Nama Modul</th>
						<th>Modul Ke-</th>
						<th>Durasi</th>
						<th>Tgl VC/Ujian</th>
						<th>Materi/Soal</th>
						<?php if ($referrer!="") { ?>
						<th>Catatan Mentor</th>
						<?php } ?>
						<th>Aksi</th>
					</tr>
					</thead>

					<tbody>
					<?php
					for ($i = 1; $i <= $jml_paket; $i++) {
//						echo "STATUSPAKET:".$status_paket[$i].", STATUSSOAL:".$status_soal[$i].", MATERI:".
//							$materi[$i].", STATUSTUGAS:".$status_tugas[$i]."<br>";
						if ($status_soal[$i] == 1 && ($nama_paket[$i]=="UTS"||$nama_paket[$i]=="UAS"||
								$nama_paket[$i]=="REMEDIAL UTS"||$nama_paket[$i]=="REMEDIAL UAS"))
							$keterangan = "Lengkap";
						else if ($status_paket[$i] == 0 || $status_soal[$i] == 0 || $materi[$i] == "" ||
							$status_tugas[$i] == 0)
							$keterangan = "Belum";
						else if ($status_video_ver[$i] == 9)
							$keterangan = "Periksa Video";
						else
							$keterangan = "Lengkap";
						if (intval($mingguke[$i])>=17)
							$mingguke[$i] = "-";
						?>
						<tr>
							<td><?php echo $nomor[$i]; ?></td>
							<td><?php echo $semester[$i]; ?></td>
							<td><?php echo $nama_mapel[$i]; ?></td>
							<td><?php echo $nama_paket[$i]; ?></td>
							<td style="text-align:center"><?php echo $mingguke[$i]."<br><i> <span style='font-size:12px'>".$keteranganmod[$i]."</span></i>"; ?></td>
							<td><?php echo $durasi_paket[$i]; ?></td>
							<td><?php echo $tayang_paket[$i]; ?></td>
							<td><?php echo $keterangan; ?></td>
							<?php if ($referrer!="") { ?>
							<td><?php echo $status_mentor[$i]; ?></td>
							<?php } ?>
							<td>
								<button
									<?php if ($nama_paket[$i]=="UTS"||$nama_paket[$i]=="UAS"||$nama_paket[$i]=="REMEDIAL UTS"||$nama_paket[$i]=="REMEDIAL UAS")
										{?>
									onclick="window.open('<?php echo base_url(); ?>virtualkelas/editujian/<?php echo $link_paket[$i]; ?>', '_self')"
									id="thumbnail" type="button">Detail
										<?php }
										else
											{?>
									onclick="window.open('<?php echo base_url(); ?>virtualkelas/editmodul/<?php echo $link_paket[$i]; ?>', '_self')"
									id="thumbnail" type="button">Detail
											<?php } ?>

								</button>
								<button onclick="return mauhapus('<?php echo $link_paket[$i]; ?>')" id="thumbnail"
										type="button">Hapus
								</button>
							</td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<style>
	.text-wrap {
		white-space: initial;
		word-break: break-word;
	}
	.width-50 {
		min-width: 100px;
	}

</style>

<center>
	<div
		style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;margin-bottom:20px;background-color:white;">
		<div id="video-placeholder" style='display:none'></div>
		<div id="videolokal" style='display:none'></div>
	</div>
</center>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<script src="<?php echo base_url();?>js/jquery.min.js"></script>
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
		var table = $('#tbl_user').DataTable({
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [2, 3, 5, 8]
				},
				{
					width: 25,
					targets: 0
				}
			]

		});


		// new $.fn.dataTable.FixedHeader(table);

		// Handle click on "Expand All" button
		$('#btn-show-all-children').on('click', function () {
			// Expand row details
			table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
		});

		// Handle click on "Collapse All" button
		$('#btn-hide-all-children').on('click', function () {
			// Collapse row details
			table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
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

	function mauhapus(idx) {
		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url(); ?>channel/hapusplaylist/' + idx, '_self');
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

		$.ajax({
			url: "<?php echo base_url(); ?>channel/gantisifat",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if ($('#bt1_' + idx).html() == "Publik") {
					$('#bt1_' + idx).html("Pribadi");
					$('#bt1_' + idx).css({"background-color": "#ffd0b4"});
				} else {
					$('#bt1_' + idx).html("Publik");
					$('#bt1_' + idx).css({"background-color": "#b4e7df"});
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

	function setjadwalvicon(kodelink) {
		window.open('<?php echo base_url(); ?>virtualkelas/setjadwalvicon_modul/' + kodelink, '_self');
	}

</script>