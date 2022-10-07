<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
				<?php if (strpos($lunas, 'belumbayar') == false) { ?>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-primary text-white mb-4">
							<div class="card-body">Kegiatan Mingguan</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link"
								   href="<?php echo base_url(); ?>ekskul/daftar_video/"><b><?php echo $rentang_tgl." ". nmbulan_pendek($bln_skr) .
							   " " . $thn_skr;?></b><br>
									Unggah Video [<?php echo $tgl_upload;?>]</a>
								<div class="small text-white"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-color-2 text-white mb-4">
							<div class="card-body">Kegiatan Bulanan</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link"
								   href="<?php echo base_url(); ?>channel/playlistsekolah/"><b><?php echo nmbulan_pendek($bln_skr) .
										" " . $thn_skr;?></b><br>
									Menyusun Playlist [<?php echo $tgl_playlist;?>]</a>
								<div class="small text-white"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-success text-white mb-4">
							<div class="card-body">Sertifikat</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<a class="small text-white stretched-link"
								   href="<?php echo $linksertifikat;?>"><?php echo $keterangansertifikat;?></a>
								<div class="small text-white"></div>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-grey text-grey mb-4">
							<div class="card-body">Kegiatan Mingguan</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<?php echo $rentang_tgl . " ". nmbulan_pendek($bln_skr) .
									" " . $thn_skr;?><br>
								Unggah Video [<?php echo $tgl_upload;?>]
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-grey text-grey mb-4">
							<div class="card-body">Kegiatan Bulanan</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								<?php echo nmbulan_pendek($bln_skr) .
									" " . $thn_skr;?><br>
								Menyusun Playlist [<?php echo $tgl_playlist;?>]
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card bg-grey text-grey mb-4">
							<div class="card-body">Sertifikat</div>
							<div class="card-footer d-flex align-items-center justify-content-between">
								Unduh Sertifikat [belum tersedia]
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-danger text-white mb-4">
						<div class="card-body">Pembayaran</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link"
							   href="<?php echo base_url(); ?>ekskul/daftar_bayar/"><?php echo $lunas;?></a>
							<div class="small text-white"></div>
						</div>
					</div>
				</div>

			</div>
	</section>
</div>
