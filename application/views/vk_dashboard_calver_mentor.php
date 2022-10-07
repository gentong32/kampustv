<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo "<br><br><br><br><br>CEK TUKAN VERIFIKATOR:".$this->session->userdata('tukang_verifikasi');

// echo "jmlgurupilih:".$jmlgurupilih;
// echo "<br>jmlmapelaktif:".$jmlmapelaktif;

// $videooke = 0;
$playlistoke = 0;
$kontrialljml = 0;
$kontrioke = 0;
$videokontrioke = 0;
$jmlsiswa = 0;
$jmlsiswaekskul = 0;
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
						<div class="card-body">Tugas</div>
						
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Unggah Video: <?php echo $videotugas;?></b><br>
									<b> - Membuat Playlist: <?php echo $playlisttugas;?></b><br>
									<b> - Undang Kontributor: <?php echo $kontrialltugas;?></b><br>
									<b> - Video Kontributor: <?php echo $videokontriall;?></b><br>
									<b> - Undang Siswa Ekskul: <?php echo $jmlsiswatugas;?></b>
								</div>
							</div>
						
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-color-2 text-white mb-4">
						<div class="card-body">Calon Verifikator</div>
						<a href='<?php echo base_url()."marketing/calver/daftar/".$id_playlist;?>'>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Calon terdaftar: <?php echo $jmlcalver;?></b><br>
									<b> - Lulus sebagai Verifikator: <?php echo $jmllulus;?></b>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-success text-white mb-4">
						<div class="card-body">Progress Calon Verifikator</div>
						<a href='<?php echo base_url()."marketing/calver/detil/".$id_playlist;?>'>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> > LIHAT DETIL</b>
								</div>
							</div>
						</a>
						
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b> - Video verifikator: <?php echo $jmlvideocalver;?></b>
									<br>
									<b> - Playlist verifikator: <?php echo $jmlplaylist;?></b>
									<br>
									<b> - Kontributor OK: <?php echo "$jmlkontriok dari $jmlkontri";?></b>
									<br>
									<b> - Video Kontributor OK: <?php echo "$jmlvideokontriok dari $jmlvideokontri";?></b>
									<br>
									<b> - Undang ekskul: <?php echo "$jml_siswaekskul";?></b>
								</div>
							</div>
						
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-danger text-white mb-4">
						<div class="card-body">Kode Event</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<div class="small text-white">
									<b><?php echo $id_playlist;?></b>
								</div>
							</div>
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
			</center>
		</div>
	</section>
</div>
