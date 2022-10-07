<link href="https://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/4.12/video.js"></script>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_contreng = Array('---', 'Masuk');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namasifat = Array('Publik', 'Pribadi', 'Bimbel');
$namabulan = array("", "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
$statustayang = Array();
$kode_event = "";
$kodehapus = "";
if ($linkdari == "event") {
	$kode_event = $kodeevent . "/";
	$kodehapus = $kodeevent . "','";
}

$jml_video = 0;
foreach ($dafvideo as $datane) {
	$jml_video++;
	$nomor[$jml_video] = $jml_video;
	$id_video[$jml_video] = $datane->id_video;
	$kode_video[$jml_video] = $datane->kode_video;
	$idjenis[$jml_video] = $datane->id_jenis;
	$jenis[$jml_video] = $txt_jenis[$datane->id_jenis];
	$id_jenjang[$jml_video] = $datane->id_jenjang;
	$id_kelas[$jml_video] = $datane->id_kelas;
	$id_mapel[$jml_video] = $datane->id_mapel;
	$id_ki1[$jml_video] = $datane->id_ki1;
	$id_ki2[$jml_video] = $datane->id_ki2;
	$id_kd1_1[$jml_video] = $datane->id_kd1_1;
	$id_kd1_2[$jml_video] = $datane->id_kd1_2;
	$id_kd1_3[$jml_video] = $datane->id_kd1_3;
	$id_kd2_1[$jml_video] = $datane->id_kd2_1;
	$id_kd2_2[$jml_video] = $datane->id_kd2_2;
	$id_kd2_3[$jml_video] = $datane->id_kd2_3;
	$id_kategori[$jml_video] = $datane->id_kategori;
	$topik[$jml_video] = $datane->topik;
	$judul[$jml_video] = $datane->judul;
	$channel[$jml_video] = $datane->channeltitle;
	$deskripsi[$jml_video] = $datane->deskripsi;
	$keyword[$jml_video] = $datane->keyword;
	$link[$jml_video] = $datane->link_video;
	$thumbnails[$jml_video] = $datane->thumbnail;
	$namafile[$jml_video] = $datane->file_video;
	$dilist[$jml_video] = $datane->dilist;
	$sifat[$jml_video] = $datane->sifat;
	if (isset($datane->sebagai))
		$sebagai[$jml_video] = $datane->sebagai;
	else
		$sebagai[$jml_video] = 0;
	$status_verifikasi[$jml_video] = $datane->status_verifikasi;
	$status_verifikasi_admin[$jml_video] = $datane->status_verifikasi_admin;
	//echo $datane->link_video;
	if ($statusvideo != 'pribadi' && $statusvideo != 'bimbel')
		$pengirim[$jml_video] = $datane->first_name . ' ' . $datane->last_name; else
		$pengirim[$jml_video] = '-';
	// $verifikator1[$jml_video] = '';
	// $verifikator2[$jml_video] = '';
	// $siaptayang[$jml_video] = '';

	if($linkdari=="event")
		$namasekolah[$jml_video] = $datane->nama_sekolah;

	$catatan1[$jml_video] = $datane->catatan1;
	$catatan2[$jml_video] = $datane->catatan2;
}

if ($statusvideo == 'pribadi')
	$akhiran = " Saya";
else if ($statusvideo == 'sekolah')
	$akhiran = " Sekolah";
else
	$akhiran = "";
//echo "<br><br><br><br><br>CEK TUKAN VERIFIKATOR:".$this->session->userdata('tukang_verifikasi');

?>

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
	<br>
	<center>
		<span style="font-size:16px;font-weight: bold;"><?php echo $title;
			if ($this->session->userdata('bimbel')==3
				&& $this->session->userdata('verifikator')==0
				&& $this->session->userdata('kontributor')==0)
			{
				echo " Bimbel";
			}; ?></span>
		<?php if ($linkdari == "event") { ?>
			<br>
			<span style="font-size:20px;font-weight: bold;"><?php echo $dataevent[0]->nama_event; ?></span>
			<br>
			<span style="color:#9fafbe;font-style:italic;font-size:13px;font-weight: bold;"><?php
				echo intval(substr($dataevent[0]->tgl_mulai, 8, 2)) . " " .
					$namabulan[intval(substr($dataevent[0]->tgl_mulai, 5, 2))] . " " .
					substr($dataevent[0]->tgl_mulai, 0, 4) . " - " .
					intval(substr($dataevent[0]->tgl_selesai, 8, 2)) . " " .
					$namabulan[intval(substr($dataevent[0]->tgl_selesai, 5, 2))] . " " .
					substr($dataevent[0]->tgl_selesai, 0, 4);; ?></span>
		<?php } ?>
	</center>
	<br>
	<?php
	if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4 || $this->session->userdata('kontributor') >= 0
		|| $this->session->userdata('tukang_kontribusi') == 1 || $this->session->userdata('tukang_verifikasi') == 1) {
		?>
		<?php if ($linkdari == "event" && $this->session->userdata('sebagai') != 4) { ?>
			<button <?php if($jml_video>=10) echo 'disabled';?> type="button" onclick="window.location.href='<?php echo base_url().$linkdari.
				'/spesial/'.$linkevent.'/tambah';?>'" class=""
					style="float:right;margin-right:10px;margin-top:-20px;"><?php if($jml_video>=10) echo "Max 10"; else
						echo "Tambah";?>
			</button>
		<?php } else if ($linkdari != "event" && ($this->session->userdata('kontributor') == 3 ||
				$this->session->userdata('verifikator') == 3 || ($statusvideo == 'bimbel'
					&& $this->session->userdata('verifikator')==0
					&& $this->session->userdata('kontributor')==0))){ ?>
			<button type="button" onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/tambah'" class=""
					style="float:right;margin-right:10px;margin-top:-20px;">Tambah
			</button>
		<?php } ?>
		<?php if ($linkdari == "event" AND $this->session->userdata('sebagai') == 4) { ?>
			<button type="button" onclick="window.location.href='<?php echo base_url(); ?>event/spesial/admin'" class=""
					style="float:right;margin-right:10px;margin-top:-20px;">Kembali
			</button>
		<?php } else if ($linkdari == "event" AND $this->session->userdata('sebagai') != 4) { ?>
			<button type="button" onclick="window.location.href='<?php echo base_url(); ?>event/spesial/acara'" class=""
					style="float:right;margin-right:10px;margin-top:-20px;">Kembali
			</button>
		<?php } ?>
	<?php } else if (($this->session->userdata('sebagai') != 4 || $this->session->userdata('a01')) &&
		($this->session->userdata('tukang_kontribusi') == 2 || $this->session->userdata('tukang_verifikasi') == 2)) {
		?>
		<button type="button" onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/tambahmp4'" class=""
				style="float:right;margin-right:10px;margin-top:-20px;">Tambah Mp4
		</button>
		<button type="button" onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/tambah'" class=""
				style="float:right;margin-right:10px;margin-top:-20px;">Tambah URL Video
		</button>

	<?php } ?>
	<!--	<button style="margin-left:10px" id="btn-show-all-children" type="button">Buka Semua</button>-->
	<!--	<button style="margin-left:10px" id="btn-hide-all-children" type="button">Tutup Semua</button>-->
	<hr>

	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style='padding:5px;width:5px;'>No</th>
				<th>Judul</th>
<!--				<th>Topik</th>-->
				<?php
				if ($statusvideo != 'pribadi' && $statusvideo != 'bimbel') {
					?>
					<th>Pengirim</th>
				<?php } ?>

				<?php
				if ($statusvideo == 'admin') {
					?>
					<th>Video</th>
				<?php } ?>

				<th>Channel</th>

				<th>Jenis</th>
				<?php if($linkdari!="sementara" && ($statusvideo != 'bimbel'
//						&& $this->session->userdata('verifikator')!=3
//						&& $this->session->userdata('kontributor')!=3
					))
				{?>
				<th>Sifat</th>
				<th>PlayList</th>
				<?php } ?>
				<?php if($linkdari=="event" && $this->session->userdata('sebagai')==4){?>
					<th>Sekolah</th>
				<?php } ?>
				<th>Verifikator</th>
				<!--                <th>Verifikator II</th>-->
				<th>Siap Tayang</th>
				<?php
				if ($statusvideo != "verifikasi") {
					?>
					<th>Edit</th>
				<?php } ?>


			</tr>
			</thead>

			<tbody>
			<?php
			for ($i = 1; $i <= $jml_video; $i++) {
				?>
				<tr>
					<td><?php echo $nomor[$i]; ?></td>
					<td><?php echo $judul[$i]; ?></td>
<!--					<td>--><?php //echo $topik[$i]; ?><!--</td>-->
					<?php
					if ($statusvideo != 'pribadi' && ($statusvideo != 'bimbel')) {
						echo '<td>' . $pengirim[$i] . '</td>';
					}

					?>

					<?php
					if ($statusvideo == 'admin') {
						if ($link[$i] != "") {
							if ($thumbnails[$i] == "https://img.youtube.com/vi/false/0.jpg") {
								$mp4_url = $link[$i];
								?>
								<td>
									<button onclick="lihatvideo3('<?php echo $mp4_url; ?>')" id="thumbnail"
											data-video-id="STxbtyZmX_E" type="button">Play
									</button>
									<br>
								</td>

							<?php } else {
								$youtube_url = $link[$i];
								$id = youtube_id($youtube_url);
								?>
								<td>
									<button onclick="lihatvideo('<?php echo $id; ?>')" id="thumbnail"
											data-video-id="STxbtyZmX_E" type="button">Play
									</button>
									<br>
								</td>
								<?php
							}
						} else if ($namafile[$i] != "") {
							//http://localhost<?php echo base_url();video/addvideomp4
//                                $nama_video = $namafile[$i];
							//$id = youtube_id($youtube_url);
							?>
							<td>
								<button onclick="lihatvideo2('<?php echo $namafile[$i]; ?>')" type="button">Play</button>
								<br>

							</td>

							<?php

						} else {
							?>
							<td>
								<button
									onclick="window.open('<?php echo base_url() . $linkdari; ?>/upload_mp4/<?php echo $id_video[$i]; ?>')"
									type="button">Upload
								</button>
								<br>

							</td>

							<?php
						}
					} ?>


					<td><?php echo $channel[$i]; ?></td>
					<td><?php echo $jenis[$i]; ?></td>

					<?php if($linkdari!="sementara" && ($statusvideo != 'bimbel'
//							&& $this->session->userdata('verifikator')!=3
//							&& $this->session->userdata('kontributor')!=3
						)){?>
					<td align="center">
						<button id="bt1_<?php echo $id_video[$i]; ?>" style="background-color: <?php
						if ($sifat[$i] == 0)
							echo '#b4e7df';
						else if ($sifat[$i] == 1)
							echo '#ffd0b4';
						else if ($sifat[$i] == 2)
							echo '#96e748';
						?>" onclick="gantisifat('<?php echo $id_video[$i]; ?>')"
								type="button"><?php echo $namasifat[$sifat[$i]]; ?></button>
					</td>

					<td align="center">
						<div style="background-color: <?php
						if ($dilist[$i] == 0)
							echo '#cddbe7';
						else
							echo '#e6e6e6'; ?>"><?php echo $txt_contreng[$dilist[$i]]; ?></div>

					</td>
					<?php } ?>

					<?php if($linkdari=="event" && $this->session->userdata('sebagai')==4){?>
					<td align="center">
						<?php echo $namasekolah[$i]; ?>
					</td>
					<?php } ?>

					<td align="center">
						<?php
						if ($namafile[$i] != "") {
							echo "-";
						} else {

							if ((($this->session->userdata('tukang_verifikasi') == 1 ||
								$this->session->userdata('tukang_verifikasi')==2)
									&& $statusvideo != 'pribadi')
							|| $this->session->userdata('a01')) {
								?>
								<button style="<?php
								if ($status_verifikasi[$i] == 1 || $status_verifikasi_admin[$i]==3)
									echo 'color:red;'; else if ($status_verifikasi[$i] >= 2)
									echo 'color:green;';
								?>"
										onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/verifikasi/<?php echo $id_video[$i]; ?>'"
										id="btn-show-all-children" type="button"><?php
									if ($status_verifikasi[$i] == 1)
										echo 'Tidak Lulus';
									else if ($status_verifikasi[$i] >= 2)
										{
											if ($status_verifikasi_admin[$i]==4)
												echo 'Lulus';
											else if ($status_verifikasi_admin[$i]==3)
												echo 'Batal Lulus';
										}

									else
										echo 'Verifikasi'; ?></button>
								<?php
							} else {
								if ($status_verifikasi[$i] >= 2) {
									if ($this->session->userdata('tukang_kontribusi') == 2)
									{if ($status_verifikasi_admin[$i]==3)
										echo $catatan2[$i];
									else
										echo $catatan1[$i];
									}
									else if ($sebagai[$i] == 3)
										echo '';
									else
										echo '<span style="color:green">Lulus</span>';
								} else if ($status_verifikasi[$i] == 1) {
									?>
									<button style="color:red" onclick="alert('<?php echo $catatan1[$i]; ?>')">Tidak
										Lulus
									</button>
								<?php }
							}
						} ?>
					</td>

					<!--                    <td align="center">-->
					<!--                        --><?php
					//                        if ($namafile[$i] != "") {
					//                            echo "-";
					//                        } else {
					//                            if ($this->session->userdata('tukang_verifikasi') == 2 &&
					//                                ($status_verifikasi[$i] >= 2 && $idjenis[$i] == 1) || ($sebagai[$i]==3) && $status_verifikasi[$i] == 0) {
					//                                ?>
					<!--                                <button style="--><?php
					//                                if ($status_verifikasi[$i] == 3)
					//                                    echo 'color:red;'; else if ($status_verifikasi[$i] >= 4)
					//                                    echo 'color:green;';
					//                                ?><!--" onclick="window.location.href='--><?php //echo base_url(); ?>
					<!--                    //video/verifikasi/--><?php ////echo $id_video[$i]; ?><!--//'"-->
					<!--//                                        id="btn-show-all-children" type="button">--><?php
					//                                    if ($status_verifikasi[$i] == 3)
					//                                        echo 'Tidak Lulus'; else if ($status_verifikasi[$i] >= 4)
					//                                        echo 'Lulus'; else
					//                                        echo 'Verifikasi'; ?><!--</button>-->
					<!--                                --><?php
					//                            } else {
					//                                if ($status_verifikasi[$i] >= 4) {
					//                                    if ($this->session->userdata('tukang_kontribusi') == 2)
					//                                        echo '-'; else
					//                                        echo '<span style="color:green">Lulus</span>';
					//                                } else if ($status_verifikasi[$i] == 3) {
					//                                    ?>
					<!--                                    <button style="color:red" onclick="alert('--><?php //echo $catatan2[$i]; ?>
					<!--                    //')">Tidak-->
					<!--//                                        Lulus-->
					<!--//                                    </button>-->
					<!--//                                --><?php ////} else if ($status_verifikasi[$i] == 2 && $idjenis[$i] == 1)
					//                                    echo 'menunggu verifikasi';
					//                            }
					//                        } ?>
					<!--                    </td>-->

					<td align="center">
						<?php
						if ($status_verifikasi_admin[$i] == 3)
						{
							$statustayang[$i] = 0;
							echo "---";
						}
						else if (($status_verifikasi[$i] == 2 || $status_verifikasi[$i] == 4) && $idjenis[$i] == 1) {
							$statustayang[$i] = 1;
							echo "V";
						} else if ($status_verifikasi[$i] == 2 && $idjenis[$i] == 2) {
							$statustayang[$i] = 1;
							echo "V";
						} else if ($status_verifikasi[$i] == 4 && $namafile[$i] != "") {
							$statustayang[$i] = 1;
							echo "V";
						} else if ($status_verifikasi[$i] == 4 && $link[$i] != "") {
							$statustayang[$i] = 1;
							echo "V";
						} else {
							$statustayang[$i] = 0;
							echo "-";
						}
						?>
					</td>
					<?php
					if ($statusvideo != "verifikasi") {
						?>
						<td align="left">
							<?php
							if ($statustayang[$i] <= 1) {
								?>
								<button onclick="window.location.href='<?php echo base_url() . $linkdari; ?>/edit/<?php
								echo $kode_event . $id_video[$i]; ?>'"
										id="btn-show-all-children" type="button" class="myButtongreen">Edit
								</button>
							<?php } else
								echo '-';
							if ($status_verifikasi[$i] == 0 || $sebagai[$i] == 4 || $this->session->userdata('a01')
							|| ($linkdari=="event")) {
								?>
								<button onclick="return mauhapus('<?php echo $kodehapus . $id_video[$i]; ?>')"
										id="btn-show-all-children" type="button" class="myButtonred">Hapus
								</button>
							<?php } ?>
						</td>
					<?php } ?>

				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	</div>
</div>

<div style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<div id="video-placeholder" style='display:none'></div>
	<div id="videolokal" style='display:none'></div>
</div>

<!-- <div id="controls">
<h2>Play</h2>
<i id="play" class="material-icons">play_arrow</i>

<h2>Pause</h2>
<i id="pause" class="material-icons">pause</i>



<h2>Dynamically Queue Video</h2>
<img class="thumbnail" src="images/cat_video_1.jpg" data-video-id="Aas9SPY_k2M">
<img class="thumbnail" src="images/cat_video_2.jpg" data-video-id="KkFnm-7jzOA">
<img class="thumbnail" src="images/cat_video_3.jpg" data-video-id="Ph77yOQFihc">
</div> -->


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.bootstrap.min.css">


<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}
</style>

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
					targets: [1, 2]
				},
				{
					width: 25,
					targets: 0
				}
			]

		});


		new $.fn.dataTable.FixedHeader(table);

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

	function lihatvideo3(url2) {
		player.pauseVideo();
		$('#videolokal').html('<video width="600" height="400" autoplay controls>' +
			'<source src="' + url2 + '" type="video/mp4">' +
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

	function mauhapus(codex, idx) {

		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url() . $linkdari; ?>/hapus/' + codex + '/' + idx, '_self');
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
		<?php if($this->session->userdata('a01') || $this->session->userdata('bimbel')==3 || $linkdari=="event") {?>
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
				if (result=="jangan")
					alert ("Sudah dipakai di bagian lain");
				else {
					if ($('#bt1_' + idx).html() == "Publik") {
						$('#bt1_' + idx).html("Pribadi");
						$('#bt1_' + idx).css({"background-color": "#ffd0b4"});
					}
					<?php if($this->session->userdata('a01') || $this->session->userdata('bimbel') == 3 || $linkdari == "event") {?>
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

</script>
