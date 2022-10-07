<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo "<br><br><br><br><br>CEK TUKAN VERIFIKATOR:".$this->session->userdata('tukang_verifikasi');

// echo "jmlgurupilih:".$jmlgurupilih;
// echo "<br>jmlmapelaktif:".$jmlmapelaktif;


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
						<h1>Event Calon Verifikator</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row" style="margin-bottom: 10px;">
				<center>
					<h3><?php echo $judulevent;?></h3>
					<h5><?php echo $tanggalevent;?></h5>
				</center>
			</div>
			<div class="row">
				<div class="col-xl-3 col-md-6">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body">Video dan Playlist</div>
						<a href='<?php echo base_url();?>event/mentor/video/<?php echo $kodeevent;?>'>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Unggah Video: <?php echo $videocalver." dari ".$videotugas;?></b>
								</div>
							</div>
						</a>
						<a href='<?php echo base_url();?>channel/playlistsekolah/calver/<?php echo $kodeevent;?>'>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Membuat Playlist: <?php echo $playlistcalver." dari ".$playlisttugas;?></b>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-color-2 text-white mb-4">
						<div class="card-body">Undang Kontributor</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<button class="btn-secondary"
									onclick="salinteks('<?php echo $id_playlist;?>','<?php echo $this->session->userdata('npsn');?>')">Bagikan Tautan</button>
								</div>
							</div>
						<a href='<?php echo base_url();?>user/usersekolah/dashboard/calver'>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Kontributor terdaftar: <?php echo $kontriallcalver." dari ".$kontrialltugas;?></b>
									<br>
									<b> - Kontributor oke: <?php echo $kontriok;?></b>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-success text-white mb-4">
						<div class="card-body">Video Kontributor</div>
						<a href='<?php echo base_url();?>video/kontributor/dashboard/'>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Video Kontributor: <?php echo "$videokontricalver dari ".$videokontriall*$kontrialltugas;?></b>
									<br>
									<b> - Video Kontributor oke: <?php echo $videokontriok;?></b>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-danger text-white mb-4">
						<div class="card-body">Undang Siswa & Ekskul</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<button class="btn-secondary"
									onclick="salinteks2('<?php echo $id_playlist;?>','<?php echo $this->session->userdata('npsn');?>')">Bagikan Tautan</button>
								</div>
							</div>
						<a href='<?php echo base_url();?>user/usersekolah/dashboard/calver/'>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Siswa terdaftar: <?php echo $jmlsiswacalver . " dari ".$jmlsiswatugas?></b>
								</div>
							</div>
						</a>
						<a href='<?php echo base_url();?>ekskul/'>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Siswa ikut ekskul: <?php echo $jmlsiswaekskulcalver . " dari ".$jmlsiswatugas?></b>
								</div>
							</div>
						</a>
					</div>
				</div>

			</div>
			<hr>
				
			<center>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sd-12">
					<div style='margin:auto;max-width:600px;'>
						<?php 
						$namasekolah="";
						$ambilpaket="event";
						include "v_chat.php";
						?>
					</div>
				</div>
			
				<div class="col-lg-6 col-md-6 col-sd-12" style="display:inline;">
				<center><h3>VIDEO</h3></center>
					<div style="color:#000000;background-color:white;">
						<div class="ratio ratio-16x9" style="text-align:center;margin-left:auto;margin-right: auto;">
							<div  id="isivideoyoutube" style="width:100%;height:100%;text-align:center;display:inline-block">
								<?php
								if ($linkvideo != "") {?>
									<div class="embed-responsive embed-responsive-16by9" style="max-width: 640px; margin:auto">
										<iframe class="embed-responsive-item"
												src="https://www.youtube-nocookie.com/embed/<?php echo youtube_id($linkvideo); ?>?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent"
												frameborder="0" allowfullscreen></iframe>
									</div>
								<?php } ?>
								<br>
							</div>
							<div id="isivideox" style="text-align:center;width:100%;display:inline-block; margin:auto;max-width: 640px;">
								<div style="text-align: left">
								
									
									
								</div>

								<br><br>

							</div>
						</div>
					</div>
				</div>
				</div>

				<div id = "dsertifikat">
					<hr style="margin-top: 5px;margin-bottom: 5px;">
					<div>
						<div style="color:#9d261d;font-size:16px;font-weight: bold;"
								id="keterangansertifikat_1"></div>
						
							<button style="width:180px;height:55px;padding:10px 20px;margin-bottom:5px;"
									class="btn-main"
									onclick="return tampilinputser(1,'<?php echo $id_playlist; ?>')">
								SERTIFIKAT
							</button>
						
					</div>
					<div id="inputsertifikat1" style="display:none;margin:auto;max-width: 600px;">
						<div style="font-size:16px;border: black 1px dotted;padding: 10px;">
							Silakan periksa nama dan email anda, agar tidak terjadi kesalahan nama dan gelar pada serifikat.
							<br><br>
							<label for="inputDefault" class="col-md-12 control-label">Nama Lengkap pada
								Sertifikat
							</label>
							<div>
								<input readonly
										style="font-size: 16px;font-weight: bold;" <?php if ($sertifikatfix) echo 'readonly'; ?>
										type="text" class="form-control" id="inamaser"
										name="inamaser" maxlength="50"
										value="<?php
										echo $nama_sertifikat; ?>" placeholder="">
							</div>
							<label for="inputDefault" class="col-md-12 control-label">Email Pengiriman
								Sertifikat
							</label>
							<div>
								<input readonly
										style="font-size: 16px;font-weight: bold;" <?php if ($sertifikatfix) echo 'readonly'; ?>
										type="text" class="form-control" id="iemailser"
										name="iemailser" maxlength="50"
										value="<?php
										echo $email_sertifikat; ?>" placeholder="">
								<br>
							</div>
							<div id="textajukan"
									style="font-size: 18px;font-weight: bold;color: #5b8a3c">
							</div>
							<div id="tbubah" style="margin: auto">
								<?php if ($sertifikatfix == false) { ?>
									<span id="tanya1_1"
											style="font-weight: bold;color:blue;font-size: 16px;">
							Apakah DATA sudah benar?</span>
									<button id="tanya2_1"
											style="font-size:16px;width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
											class="btn-main" onclick="return updatesertifikat('<?php echo $id_playlist; ?>',1);">
										Benar
									</button>
								<?php } else { ?>
									<span id="tanya1_1"></span><span
										id="tanya2_1"></span>
								<?php } ?>
								<button style="<?php
								if ($download_sertifikat >0) echo "display:none; ";
								?>font-size:16px; width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
										class="btn-main" onclick="return editsertifikat();">
									Ubah
								</button>
								<br>
								<div style="color:#9d261d;font-size:16px;font-weight: bold;"
										id="keterangantombol2_1"></div>


								<?php

								// echo "TES:".$cekfix;

								if ($download_sertifikat >= 1) { ?>
									<span style="font-size: 18px;font-weight: bold;color: #5b8a3c">
								SERTIFIKAT SUDAH DIKIRIM KE EMAIL ANDA</span>
								
										<center>
											<button id="tbajukan"
													style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix; ?>"
													class="btn-main"
													onclick="return ajukansertifikat();">
												KIRIM ULANG SERTIFIKAT
											</button>
										</center>
									<?php }
										else {

									?>
										<center>
											<button id="tbajukan"
													style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix; ?>"
													class="btn-main"
													onclick="return ajukansertifikat();">
												DOWNLOAD SERTIFIKAT
											</button>
										</center>
								<?php }
								?>


							</div>
							<div id="tbupdate" style="display: none;">
								<button
									style="font-size:16px;width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
									class="btn-main" onclick="return updatesertifikat()">
									Update
								</button>
							</div>
						</div>

					</div>
				</div>
			</div>
			</center>
	</section>
</div>

<script>

var lengkap = <?php echo $komplit;?>;

function infotombol(keterangan, indeks) {
		var idtampil = setInterval(klirket, 5000);
		$('#keterangantombol_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampil);
			$('#keterangantombol_' + indeks).html("");
			location.reload();
		}
	}

	function infotombol2(keterangan, indeks) {
		var idtampil2 = setInterval(klirket, 5000);
		$('#keterangantombol2_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampil2);
			$('#keterangan2tombol_' + indeks).html("");
			location.reload();
		}
	}

	function infosertifikatvideo(keterangan, indeks) {
		var idtampilsertifikat = setInterval(klirket, 3000);
		$('#keterangansertifikat_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampilsertifikat);
			$('#keterangansertifikat_' + indeks).html("");
			location.reload();
		}
	}

	function tampilinputser(indeks, codene) {
		if (lengkap) {
			if (document.getElementById("inputsertifikat" + indeks).style.display == 'none')
				document.getElementById("inputsertifikat" + indeks).style.display = 'block';
			else
				document.getElementById("inputsertifikat" + indeks).style.display = 'none';
		} else {
			infosertifikatvideo("Tugas belum OKE semua.", indeks);
		}
	}

	function editsertifikat() {
		document.getElementById('inamaser').readOnly = false;
		document.getElementById('iemailser').readOnly = false;
		document.getElementById('tbubah').style.display = 'none';
		document.getElementById('tbupdate').style.display = 'block';
	}

	function updatesertifikat() {

		var namane = $('#inamaser').val();
		var emaile = $('#iemailser').val();

		document.getElementById('tanya1_1').style.display = 'none';
		document.getElementById('tanya2_1').style.display = 'none';

		$.ajax({
			url: "<?php echo base_url();?>event/updatesertifikatcalver",
			data: {codene: "<?php echo $id_playlist;?>", namane: namane, emaile: emaile},
			type: 'POST',
			success: function (result) {
				// alert (data);
				document.getElementById('inamaser').readOnly = true;
				document.getElementById('iemailser').readOnly = true;
				document.getElementById('tbubah').style.display = 'block';
				document.getElementById('tbupdate').style.display = 'none';
				document.getElementById('tbajukan').style.display = 'block';
			}
		});

	}

	function ajukansertifikat() {
		$.ajax({
			url: "<?php echo base_url();?>event/createsertifikateventcalver/guru",
			data: {codene: "<?php echo $id_playlist;?>"},
			type: 'POST',
			cache: false,
			success: function (result) {
				// alert (result);
				document.getElementById('tbubah').style.display = 'none';
				document.getElementById('tbajukan').style.display = 'none';
				document.getElementById('textajukan').innerHTML = 'SERTIFIKAT TELAH DIKIRIM KE EMAIL ANDA';
			}
		});
	}

	function salinteks(kodeevent,npsn) {
		kopitext = "<?php echo base_url().'login/registrasi/guru/';?>"+kodeevent+"/"+npsn;
		navigator.clipboard
		.writeText(kopitext)
		.then(() => {
			alert("berhasil dikopi");
		})
		.catch(() => {
			alert("ada masalah");
		});
	}

	function salinteks2(kodeevent,npsn) {
		kopitext = "<?php echo base_url().'login/registrasi/siswa/';?>"+kodeevent+"/"+npsn;
		navigator.clipboard
		.writeText(kopitext)
		.then(() => {
			alert("berhasil dikopi");
		})
		.catch(() => {
			alert("ada masalah");
		});
	}

</script>