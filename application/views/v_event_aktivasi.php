<link href="https://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/4.12/video.js"></script>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Orang Tua', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator', '', '', '', '', '', '-');
$namastatus = Array('', 'NonAktif', 'Aktif');

$jml_user = 0;
foreach ($dafuserevent as $datane) {
	$jml_user++;
	$nomor[$jml_user] = $jml_user;
	$id_user[$jml_user] = $datane->id_user;
	$first_name[$jml_user] = $datane->first_name;
	$last_name[$jml_user] = $datane->last_name;
	$fullname[$jml_user] = $datane->nama_sertifikat;
	$email[$jml_user] = $datane->email_sertifikat;
	$aktifsebagai[$jml_user] = $datane->aktifsebagai;
	if ($datane->aktifsebagai == "Narasumber" || $datane->aktifsebagai == "Sponsorship" ||
		$datane->aktifsebagai == "Keynote Speaker" || $datane->aktifsebagai == "Ketua Panitia")
		$email[$jml_user] = "sriwatini137@gmail.com";
	$download[$jml_user] = $datane->download_sertifikat;
	$npsn[$jml_user] = $datane->npsn;
	$sekolah[$jml_user] = $datane->sekolah;
	if ($datane->sekolah == "" || $datane->sekolah == null)
		$sekolah[$jml_user] = $datane->bidang;
	$namakota[$jml_user] = $datane->nama_kota;
	$propinsi[$jml_user] = $datane->nama_propinsi;
	$code_event[$jml_user] = $datane->code_event;
	$status[$jml_user] = $datane->status_user;
	$videone[$jml_user] = $datane->id_video;

	$adavideo[$jml_user] = false;
	if ($videone[$jml_user] != "") {
		$adavideo[$jml_user] = true;
		$youtube_url = $datane->link_video;
		$id = youtube_id($youtube_url);
		$id = preg_replace("/\r|\n/", "", $id);
		$ivideo[$jml_user] = '<br><button onclick="lihatvideo(\'' . $id . '\');" data-video-id=\'STxbtyZmX_E\'' .
			' type=\'button\'>Video</button>';
	}

}

?>
<style>
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 99; /* Sit on top */
		padding-top: 100px; /* Location of the box */
		left: 0;
		top: 80px;
		margin-left: auto;
		margin-right: auto;
		height: 70%; /* Full width */
		width: auto; /* Full height */
		max-width: 600px;
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0, 0, 0); /* Fallback color */
		background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
	}

	/* Modal Content (image) */
	.modal-content {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 500px;
	}

	/* Caption of Modal Image */
	#caption {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 700px;
		text-align: center;
		color: #ccc;
		padding: 10px 0;
		height: 150px;
	}

	/* Add Animation */
	.modal-content, #caption {
		-webkit-animation-name: zoom;
		-webkit-animation-duration: 0.6s;
		animation-name: zoom;
		animation-duration: 0.6s;
	}

	@-webkit-keyframes zoom {
		from {
			-webkit-transform: scale(0)
		}
		to {
			-webkit-transform: scale(1)
		}
	}

	@keyframes zoom {
		from {
			transform: scale(0)
		}
		to {
			transform: scale(1)
		}
	}

	/* The Close Button */
	.klos {
		position: absolute;
		top: 15px;
		right: 35px;
		color: #f1f1f1;
		font-size: 40px;
		font-weight: bold;
		transition: 0.3s;
	}

	.klos:hover,
	.klos:focus {
		color: #bbb;
		text-decoration: none;
		cursor: pointer;
	}

	/* 100% Image Width on Smaller Screens */
	@media only screen and (max-width: 700px) {
		.modal-content {
			width: 100%;
			max-width: 300px;
		}

		.modal {
			width: 100%;
		}
	}
</style>

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
						<h1>LOKAKARYA / SEMINAR</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container"
		<br>
		<center><span
				style="font-size:16px;font-weight: bold;"><?php if ($golongan == null) echo "DAFTAR PESERTA EVENT"; else echo "DAFTAR NARSUM/MODERATOR EVENT"; ?></span>
			<h3 style="color:black"><?php echo $namaevent; ?></h3>
			<button type="button" onclick="window.location.href='<?php echo base_url(); ?>event/spesial/admin'" class=""
					style="margin-right:auto;margin-left:auto;margin-top:-20px;">Kembali
			</button>

			<button type="button" onclick="window.location.href='<?php echo base_url(); ?>event/aktivasi_event/<?php
			echo $codeevent;
			if ($golongan == null) echo "/1"; ?>'" class=""
					style="margin-right:auto;margin-left:auto;margin-top:-20px;"><?php
				if ($golongan == null) echo "Lihat Narasumber/Moderator"; else echo "Lihat Peserta";
				?>
			</button>

		</center>
		<br>
		<center>
			<?php if ($golongan == 1) { ?>
				<button type="button" onclick="window.location.href='<?php echo base_url(); ?>event/pilih_narsum/<?php
				echo $codeevent; ?>'" class=""
						style="margin-right:auto;margin-left:auto;margin-top:-20px;">Pilih Narasumber/Moderator
				</button>
			<?php } ?>
		</center>
		<!--<button style="margin-left:10px" id="btn-show-all-children" type="button">Expand All</button>-->
		<!--<button style="margin-left:10px" id="btn-hide-all-children" type="button">Collapse All</button>-->

		<hr>

		<!-- The Modal -->
		<div id="myModal" class="modal">
			<span class="klos">X</span>
			<img class="modal-content" id="img01">
		</div>

		<div id="tabel1" style="margin-left:10px;margin-right:10px;">
			<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
				<thead>
				<tr>
					<th style='width:5px;text-align:center'>No</th>
					<th style='text-align:center'>Nama</th>
					<th style='text-align: center'>Sertifikat</th>
					<th style='text-align:center'>Nama Lengkap</th>

					<th style='width:15%;text-align:center'>Email Sertifikat</th>
					<?php if ($golongan != null) { ?>
						<th style='width:15%;text-align:center'>Aktif Sebagai</th>
					<?php } ?>
					<th class="none" style='width:15%;text-align:center'>NPSN</th>
					<th style='text-align:center'>Sekolah/Instansi</th>
					<th class="none" style='width: 15%;text-align: center'>Kota/Kabupaten</th>
					<th class="none" style='width: 15%;text-align: center'>Propinsi</th>
					<?php if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4 &&
							$this->session->userdata('verifikator') == 3)) { ?>
						<th style='width: 15%;text-align: center'>Aksi</th>
					<?php } ?>
				</tr>
				</thead>

				<tbody>
				<?php for ($i = 1; $i <= $jml_user; $i++) {
					// if ($idsebagai[$i]!="4") continue;
					?>

					<tr>
						<td style='text-align:right'><?php echo $nomor[$i]; ?></td>
						<td><?php echo $first_name[$i] . " " . $last_name[$i]; ?><?php if ($adavideo[$i]) {
								echo $ivideo[$i];
							} ?></td>
						<td style='text-align: center'><?php if ($download[$i] == 0) {
								echo "Belum Download";
							} else {
								echo "Sudah Dikirim";
							}
							echo "<br>";

							if ($this->session->userdata('a01') || ($this->session->userdata('verifikator') == 3 && $this->session->userdata('sebagai') == 4)) { ?>
								<button
									onclick="return lihatsertifikat('<?php echo $fullname[$i]; ?>','<?php echo $email[$i]; ?>',
										'<?php echo $codeevent; ?>','<?php echo $id_user[$i]; ?>')">
									Lihat
								</button>
								<button
									onclick="return kirimsertifikat('<?php echo $fullname[$i]; ?>','<?php echo $email[$i]; ?>',
										'<?php echo $codeevent; ?>','<?php echo $id_user[$i]; ?>')">
									Kirim
								</button>
							<?php }

							?>
						</td>
						<td><?php echo $fullname[$i]; ?></td>

						<td><?php echo $email[$i]; ?></td>
						<?php if ($golongan != null) { ?>
							<td><?php echo $aktifsebagai[$i]; ?></td>
						<?php } ?>
						<td><?php echo $npsn[$i]; ?></td>
						<td><?php echo $sekolah[$i]; ?></td>
						<td><?php echo $namakota[$i]; ?></td>
						<td><?php echo $propinsi[$i]; ?></td>
						<?php if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4 &&
								$this->session->userdata('verifikator') == 3)) { ?>
							<td>
								<?php if ($golongan != null) { ?>
									<button
										onclick="window.location.href='<?php echo base_url(); ?>event/pilih_narsum/<?php
										echo $codeevent . "/" . $id_user[$i]; ?>'"
										type="button">Edit
									</button>
								<?php } ?>
								<?php if ($this->session->userdata('a01')) { ?>
									<button
										onclick="hapuspeserta('<?php echo $code_event[$i]; ?>','<?php echo $id_user[$i]; ?>',
											'<?php echo $first_name[$i]; ?>')"
										type="button">Hapus
									</button>
								<?php } ?>
							</td>
						<?php } ?>

						<?php if (isset($inidibuangdulu)) { ?>
							<td>
								<button id="bt1_<?php echo $code_event[$i]; ?>" style="background-color: <?php
								if ($status[$i] == 1)
									echo '#ffd0b4';
								else
									echo '#b4e7df'; ?>"
										onclick="gantistatus('<?php echo $code_event[$i]; ?>','<?php echo $npsn[$i]; ?>')"
										type="button"><?php echo $namastatus[$status[$i]]; ?></button>
							</td>
						<?php } ?>
					</tr>

					<?php
				}
				?>
				</tbody>
			</table>
		</div>
	</section>
</div>

<div style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<div id="video-placeholder" style='display:none'></div>
	<div id="videolokal" style='display:none'></div>
</div>

<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}

	.width-80 {
		width: 80px;
	}

	@media screen and (min-width: 800px) {
		.width-80 {
			width: 180px;
		}
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

	//$('#d3').hide();
	var oldurl = "";

	$(document).ready(function () {
		var divx = document.getElementById('d1');
//divx.style.visibility = "hidden";
//divx.style.display = "none";


		var table = $('#tbl_user').DataTable({
			'language': {
				'paginate': {
					'previous': '<',
					'next': '>'
				}
			},
			"pagingType": "numbers",
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-80'>" + data + "</div>";
					},
					targets: [1, 2, 3]
				},
				{
					width: 10,
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

	function gantistatus(codex, npsn) {
		statusnya = 1;
		if ($('#bt1_' + codex).html() == "NonAktif") {
			statusnya = 2;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>event/gantistatususer",
			method: "POST",
			data: {code: codex, npsn: npsn, status: statusnya},
			success: function (result) {
				if ($('#bt1_' + codex).html() == "Aktif") {
					$('#bt1_' + codex).html("NonAktif");
					$('#bt1_' + codex).css({"background-color": "#ffd0b4"});
				} else {
					$('#bt1_' + codex).html("Aktif");
					$('#bt1_' + codex).css({"background-color": "#b4e7df"});
				}
			}
		})

	}

	function hapuspeserta(codeevent, idpeserta, namapeserta) {
		var r = confirm("Yakin mau hapus " + namapeserta + " ?");
		if (r == true) {
			window.open('<?php echo base_url();?>event/hapususerevent/' + codeevent + "/" + idpeserta);
		} else {
			return false;
		}
		return false;
	}

	// Get the modal
	var modal = document.getElementById("myModal");
	var modalImg = document.getElementById("img01");

	function lihatgbr(imgne) {
		modal.style.display = "block";
		modalImg.src = imgne;
	}

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("klos")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function () {
		modal.style.display = "none";
	}

	function lihatsertifikat(nama, email, kode, id) {
		if (nama == "" || email == "")
			alert("Nama dan alamat email belum diisi!");
		else {
			window.open("<?php echo base_url();?>event/createsertifikatevent/" + kode + "/" + id + "/view", "_blank");
		}
		return false;
	}


	function kirimsertifikat(nama, email, kode, id) {
		if (nama == "" || email == "")
			alert("Nama dan alamat email belum diisi!");
		else {
			var r = confirm("Mau kirim sertifikat atas nama '" + nama + "' ke email '" + email + "' ?");
			if (r == true) {
				//window.open('<?php echo base_url() . "event/createsertifikatevent/";?>'+kode+ "/" + id,'_self');

				$.ajax({
					url: "<?php echo base_url();?>event/createsertifikatevent/" + kode + "/" + id,
					type: 'POST',
					cache: false,
					success: function (data) {
					}
				});

			} else {
				return false;
			}
		}
		return false;
	}

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

</script>
