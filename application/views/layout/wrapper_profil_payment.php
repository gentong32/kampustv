<?php if($this->session->userdata('pernahdonasi'))
	$jmldonasi=1;
else
	$jmldonasi=0;
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('head_profil_payment.php'); ?>
<body class="inner_page media_gallery">
<div class="full_container">
	<div class="inner_container">
		<!-- Sidebar  -->
		<nav id="sidebar">
			<div class="sidebar_blog_1">
				<div class="sidebar-header">
					<div class="logo_section">
						<a href="<?php echo base_url(); ?>"><img class="logo_icon img-responsive"
																 src="<?php echo base_url(); ?>images/logo/logo_icon.png"
																 alt="#"/></a>
					</div>
				</div>
				<div class="sidebar_user_info">
					<div class="icon_setting"></div>
					<div class="user_profle_side">
						<div class="user_img"><img style="max-height: 90px;" class="img-responsive"
												   src="<?php echo $profilku->fotouser; ?>" alt="#"/></div>
						<div class="user_info">
							<h6><?php echo $profilku->username; ?></h6>
							<p><span class="online_animation"></span> Online</p>
						</div>
					</div>
				</div>
			</div>
			<div class="sidebar_blog_2">
				<h4><?php echo $profilku->tstatususer; ?></h4>
				<ul class="list-unstyled components">
					<!--Menu Samping-->
					<?php if ($profilku->statususer == 3 || $profilku->statususer == 4 || $profilku->statususer == 5
					|| $profilku->statususer == 8) { ?>
						<li><a href="<?php echo base_url();?>" onclick="balikkedepan();"><i class="fa fa-home purple_color2"></i>
								<span>Beranda</span></a></li>
						<li><a href="<?php echo base_url() . 'profil/profil_diri'; ?>"><i
									class="fa fa-user green_color"></i> <span>Profil Saya</span></a></li>
						<li><a href="<?php echo base_url() . 'profil/sekolah'; ?>"><i
									class="fa fa-university blue1_color"></i> <span>Kampus Saya</span></a></li>
						<?php if ($this->session->userdata('verifikator') == 1){ ?>
						<li><a href="<?php echo base_url() . 'event/calon_verifikator'; ?>"><i
									class="fa fa-star green_color"></i> <span>Event Calon Verifikator</span></a></li>
						<?php } ?>
						<?php if ($jmldonasi>0){ ?>
						<li><a href="<?php echo base_url() . 'profil/donasi'; ?>"><i
									class="fa fa-money green_color"></i> <span>Donasi Saya</span></a></li>
									<?php } ?>
						<?php if ($profilku->statususer == 3){?>
						<li>
							<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-youtube-play red_color"></i> <span>Channel Video</span></a>
							<ul class="collapse list-unstyled" id="element" style="padding-top: 5px;padding-left:20px;">
								<li><a href="<?php echo base_url()."video/saya/dashboard";?>">> <span>Video Saya</span></a></li>
								<!-- <li><a href="<?php //echo //base_url()."channel/playlistkampus/dashboard";?>">> <span>Playlist Siaran</span></a></li> -->
								<li><a href="<?php echo base_url()."video/event/dashboard";?>">> <span>Video Event</span></a></li>
							</ul>
						</li>

							<?php if($this->session->userdata('bimbel')==3)
							{ ?>
								<li>
									<a href="#element3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
											class="fa fa-folder blue2_color"></i> <span>Kelas Virtual</span></a>
									<ul class="collapse list-unstyled" id="element3">
										<li><a href="<?php echo base_url().'bimbel/modul_saya'; ?>">> <span>Modul Bimbel</span></a></li>
										<li><a href="<?php echo base_url()."virtualkelas/sekolah_saya/";?>">> <span>Dashboard Modul Sekolah</span></a></li>
										<?php if ($profilku->referrer!="") { ?>
											<li><a href="<?php echo base_url()."virtualkelas/event";?>">> <span>Tambah Modul Sekolah</span></a></li>
										<?php } ?>
										<li><a href="<?php echo base_url()."virtualkelas/modul";?>">> <span>Daftar Modul Sekolah</span></a></li>
									</ul>
								</li>
							
							<?php } else {?>
								<li>
									<a href="#elementev" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
											class="fa fa-folder blue2_color"></i> <span>Kelas Virtual</span></a>
									<ul class="collapse list-unstyled" id="elementev">
										<li><a href="<?php echo base_url()."virtualkelas/sekolah_saya/";?>">> <span>Dashboard Modul Sekolah</span></a></li>
										<?php if ($profilku->referrer!="") { ?>
											<li><a href="<?php echo base_url()."virtualkelas/event";?>">> <span>Tambah Modul Sekolah</span></a></li>
										<?php } ?>
										<li><a href="<?php echo base_url()."virtualkelas/modul";?>">> <span>Daftar Modul Sekolah</span></a></li>
									</ul>
								</li>
							<?php }
						} ?>
						<?php if($this->session->userdata('bimbel')==3 && $profilku->statususer != 3)
						{ ?>
							<li><a href="<?php echo base_url() . 'bimbel/modul_saya'; ?>"><i
										class="fa fa-folder green_color"></i> <span>Modul Bimbel</span></a></li>
						<?php } ?>
						<li><a href="<?php echo base_url() . 'login/logout'; ?>"><i class="fa fa-close red_color"></i>
								<span>Logout</span></a></li>
					<?php } else if ($profilku->statususer == 6 || $profilku->statususer == 7) { ?>
						<li><a href="<?php echo base_url();?>" onclick="balikkedepan();"><i class="fa fa-home purple_color2"></i>
								<span>Beranda</span></a></li>
						<?php if($this->session->userdata("siag")==3)
							{ ?>
								<li><a href="<?php echo base_url() . 'profil/'; ?>"><i
											class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a></li>
							<?php }?>
						<li><a href="<?php echo base_url() . 'profil/profil_diri'; ?>"><i
									class="fa fa-user green_color"></i> <span>Profil Saya</span></a></li>
						<!-- <li><a href="<?php //echo base_url() . 'profil/pekerjaan'; ?>"><i
									class="fa fa-university blue1_color"></i> <span>Pekerjaan Saya</span></a></li> -->
						<?php if ($this->session->userdata('kontributor') == 3){?>
							<li>
								<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
										class="fa fa-youtube-play red_color"></i> <span>Video</span></a>
								<ul class="collapse list-unstyled" id="element">
									<li><a href="<?php echo base_url()."video/saya/dashboard";?>">> <span>Video Saya</span></a></li>
									<!-- <li><a href="<?php //echo base_url()."video/event/dashboard";?>">> <span>Video Event</span></a></li> -->
								</ul>
							</li>
						<?php } ?>
						<?php if($this->session->userdata('siag')==3)
						{ ?>
							<li><a href="<?php echo base_url() . 'profil/sekolah'; ?>"><i
							class="fa fa-university blue1_color"></i> <span>Kampus Saya</span></a></li>
							<li><a href="<?php echo base_url()."channel/daftarprodi";?>">
							<i class="fa fa-book green_color"></i><span>Daftar Prodi</span></a></li>
							<li>
								<a href="#element2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
										class="fa fa-suitcase yellow_color"></i> <span>Agency</span></a>
								<ul class="collapse list-unstyled" id="element2">
									<li><a href="<?php echo base_url()."agency/";?>">> <span>Daftar Aktivitas</span></a></li>
									<li><a href="<?php echo base_url()."agency/daftar_am";?>">> <span>Daftar Nama Mentor</span></a></li>
									<li><a href="<?php echo base_url()."agency/transaksi_virtualkelas";?>">> <span>Daftar Transaksi</span></a></li>
									<li><hr style="margin:auto;margin-top:5px;margin-bottom:5px;width: 80%;border-color: lightgrey"></li>
									<li><a href="<?php echo base_url()."agency/mou_baru";?>">> <span>MoU Baru</span></a></li>
									<li><a href="<?php echo base_url()."agency/mou_daftar";?>">> <span>Daftar MoU</span></a></li>
								</ul>
							</li>
						<?php } ?>
						<?php if($this->session->userdata('bimbel')==4 && $this->session->userdata('siag')!=3)
						{ ?>
							<li>
								<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
										class="fa fa-book yellow_color"></i> <span>Bimbel</span></a>
								<ul class="collapse list-unstyled" id="element">
									<li><a href="<?php echo base_url()."user/bimbel/dashboard";?>">> <span>Verifikasi Tutor Bimbel</span></a></li>
									<li><a href="<?php echo base_url()."video/bimbel/dashboard";?>">> <span>Verifikasi Video Bimbel</span></a></li>
								</ul>
							</li>
						<?php } ?>
						<?php if($this->session->userdata('bimbel')==3)
						{ ?>
							<li><a href="<?php echo base_url() . 'bimbel/modul_saya'; ?>"><i
										class="fa fa-folder green_color"></i> <span>Modul Bimbel</span></a></li>
						<?php } ?>
						<?php if($this->session->userdata('siae')==3)
						{ ?>
							<li>
								<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
										class="fa fa-youtube-play red_color"></i> <span>Menu AE</span></a>
								<ul class="collapse list-unstyled" id="element">
									<li><a href="<?php echo base_url()."eksekusi/";?>">> <span>Transaksi Baru</span></a></li>
									<li><a href="<?php echo base_url()."eksekusi/donatur";?>">> <span>Daftar Donatur</span></a></li>
									<li><a href="<?php echo base_url()."eksekusi/transaksi";?>">> <span>Daftar Transaksi</span></a></li>
								</ul>
							</li>
						<?php } ?>

						<?php if($this->session->userdata('email')=="cfo@tvsekolah.id")
						{ ?>
							<li>
								<a href="#elementf2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
										class="fa fa-money green_color"></i> <span>Keuangan</span></a>
								<ul class="collapse list-unstyled" id="elementf2">
									<li><a href="<?php echo base_url()."finance/transaksi_siplah";?>">> <span>Transaksi SIPLAH</span></a></li>
									<li><a href="<?php echo base_url()."finance";?>">> <span>Laporan Keuangan</span></a></li>
								</ul>
							</li>
						<?php } ?>

						<?php if($this->session->userdata('siam')==3)
						{ ?>
							<li>
								<a href="#elementm" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
										class="fa fa-youtube-play red_color"></i> <span>Menu Mentor</span></a>
								<ul class="collapse list-unstyled" id="elementm">
									<li><a href="<?php echo base_url()."marketing/";?>">> <span>Aktivitas Baru</span></a></li>
									<li><a href="<?php echo base_url()."marketing/daftar_ref";?>">> <span>Daftar Kode Referal</span></a></li>
									<li><a href="<?php echo base_url()."marketing/daftar_event";?>">> <span>Event Modul Sekolah</span></a></li>
									<li><a href="<?php echo base_url()."marketing/daftar_modul";?>">> <span>Daftar Modul Guru Sekolah</span></a></li>
									<li><a href="<?php echo base_url()."marketing/daftar_event_ver";?>">> <span>Event Calon Verifikator</span></a></li>
								</ul>
							</li>
							<li>
							<a href="<?php echo base_url() . 'marketing/transaksi_kelasvirtual'; ?>"><i
									class="fa fa-money yellow_color"></i> <span>Daftar Transaksi</span></a>
							</li>
						<?php } ?>
						<li><a href="<?php echo base_url() . 'login/logout'; ?>"><i class="fa fa-close red_color"></i>
								<span>Logout</span></a></li>
					<?php } else if ($profilku->statususer == 2) { ?>
						<li><a href="<?php echo base_url();?>" onclick="balikkedepan();"><i class="fa fa-home purple_color2"></i>
								<span>Beranda</span></a></li>
						<li><a href="<?php echo base_url() . 'profil/'; ?>"><i
									class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a></li>
						<li><a href="<?php echo base_url() . 'profil/profil_diri'; ?>"><i
									class="fa fa-user green_color"></i> <span>Profil Saya</span></a></li>
						<li><a href="<?php echo base_url() . 'profil/sekolah'; ?>"><i
									class="fa fa-university blue1_color"></i> <span>Kampus Saya</span></a></li>
						<?php if ($jmldonasi>0){ ?>
							<li><a href="<?php echo base_url() . 'profil/donasi'; ?>"><i
										class="fa fa-university blue1_color"></i> <span>Donasi Saya</span></a></li>
						<?php } ?>
					<?php if($this->session->userdata('bimbel')!=3)
					{ 
						if($this->session->userdata('verifikator')==3){ ?>
							<li>
						<a href="#elementpla" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-television blue1_color"></i> <span>Playlist Kampus</span></a>
							<ul class="collapse list-unstyled" id="elementpla">
								<li><a href="<?php echo base_url()."channel/playlistkampus/dashboard";?>">> <span>Daftar Playlist Kampus</span></a></li>
								<li><a href="<?php echo base_url()."channel/pilihsiaran";?>">> <span>MCR Siaran TV Kampus</span></a></li>
							</ul>
						</li>
										<?php } ?>
						
					
						<li><a href="<?php echo base_url() . 'profil/pembayaran'; ?>"><i
									class="fa fa-money yellow_color"></i> <span>Iuran</span></a>
						</li>
						<li><a href="<?php echo base_url() . 'eksekusi'; ?>"><i
									class="fa fa-info yellow_color"></i> <span>Promosi Sekolah</span></a>
						</li>
						<?php }
						else
					{ ?>
					<?php if($this->session->userdata('verifikator')==3){ ?>
						<li>
						<a href="#elementpla" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-television blue1_color"></i> <span>Playlist Kampus</span></a>
							<ul class="collapse list-unstyled" id="elementpla">
								<li><a href="<?php echo base_url()."channel/playlistsekolah/dashboard";?>">> <span>Daftar Playlist Kampus</span></a></li>
								<li><a href="<?php echo base_url()."channel/pilihsiaran";?>">> <span>MCR Siaran TV Kampus</span></a></li>
							</ul>
						</li>

									<?php } ?>
						<li><a href="#elementtrans" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-money yellow_color"></i> <span>Transaksi</span></a>
							<ul class="collapse list-unstyled" id="elementtrans">
								<li><a href="<?php echo base_url() . 'profil/pembayaran'; ?>">> <span>Iuran Kampus</span></a></li>
								<?php if($this->session->userdata('verifikator')!=3){ ?>
									<li><a href="<?php echo base_url() . 'tutor/transaksi'; ?>">> <span>Transaksi Bimbel</span></a></li>
								<?php } else { ?>
									<li><a href="<?php echo base_url() . 'tutor/transaksi'; ?>">> <span>Transaksi Kelas Virtual</span></a></li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>
						<li>
							<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-youtube-play orange_color"></i> <span>Video</span></a>
							<ul class="collapse list-unstyled" id="element">
								<li><a href="<?php echo base_url()."video/saya/dashboard";?>">> <span>Video Saya</span></a></li>
								<li><a href="<?php echo base_url()."video/kontributor/dashboard";?>">> <span>Video Kontributor</span></a></li>
								<li><a href="<?php echo base_url()."video/ekskul/dashboard";?>">> <span>Video Ekskul</span></a></li>
								<li><a href="<?php echo base_url()."video/event/dashboard";?>">> <span>Video Event</span></a></li>
								<?php if($this->session->userdata('bimbel')==4)
									{ ?>
										<li><a href="<?php echo base_url()."video/bimbel/dashboard";?>">> <span>Video Bimbel</span></a></li>
									<?php } ?>
							</ul>
						</li>
					<?php if($this->session->userdata('sebagai')==1)
					{
						 if($this->session->userdata('bimbel')==3)
					{ ?>
						<li>
							<a href="#element3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-folder blue2_color"></i> <span>Kelas Virtual</span></a>
							<ul class="collapse list-unstyled" id="element3">
								<li><a href="<?php echo base_url().'bimbel/modul_saya'; ?>">> <span>Modul Bimbel</span></a></li>
								<?php if ($this->session->userdata("verifikator")==3) { ?>
									<li><a href="<?php echo base_url()."virtualkelas/event/";?>">> <span>Modul Kampus Saya</span></a></li>
									<li><a href="<?php echo base_url()."virtualkelas/modul/";?>">> <span>Modul Kampus Dosen</span></a></li>
								<?php }
								else
								{ ?>
									<li><a href="<?php echo base_url()."virtualkelas/sekolah_saya/";?>">> <span>Dashboard Modul Kampus</span></a></li>
									<?php if ($profilku->referrer!="") { ?>
											<li><a href="<?php echo base_url()."virtualkelas/event";?>">> <span>Tambah Modul Kampus</span></a></li>
										<?php } ?>
									<li><a href="<?php echo base_url()."virtualkelas/modul/";?>">> <span>Daftar Modul Kampus</span></a></li>
								<?php } ?>
							</ul>
						</li>

					<?php } else {?>
						<li>
							<a href="#elementkv" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-folder blue2_color"></i> <span>Kelas Virtual</span></a>
							<ul class="collapse list-unstyled" id="elementkv">
								<li><a href="<?php echo base_url()."virtualkelas/sekolah_saya/";?>">> <span>Dashboard Modul Kampus</span></a></li>
								<?php if ($profilku->referrer!="") { ?>
											<li><a href="<?php echo base_url()."virtualkelas/event";?>">> <span>Tambah Modul Kampus</span></a></li>
										<?php } ?>
								<li><a href="<?php echo base_url()."virtualkelas/modul";?>">> <span>Daftar Modul Kampus</span></a></li>
								<li><a href="<?php echo base_url()."virtualkelas/krs";?>">> <span>Jadwal KRS</span></a></li>
							</ul>
						</li>
					<?php }
					 } ?>
						<li><a href="<?php echo base_url() . 'login/logout'; ?>"><i class="fa fa-close red_color"></i>
								<span>Logout</span></a></li>
					<?php } else if ($profilku->statususer == 1) { ?>
						<li><a href="<?php echo base_url();?>" onclick="balikkedepan();"><i class="fa fa-home purple_color2"></i>
								<span>Beranda</span></a></li>
						<!-- <li><a href="<?php //echo base_url() . 'login/profile/'; ?>"><i
									class="fa fa-user yellow_color"></i> <span>Profil Saya</span></a></li> -->
						<li><a href="<?php echo base_url() . 'profil/'; ?>"><i
									class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
						</li>
						<li>
							<a href="#elementkmp" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-university orange_color"></i> <span>Agency - Kampus</span></a>
							<ul class="collapse list-unstyled" id="elementkmp">
								<li><a href="<?php echo base_url()."channel/daftaragency";?>">> <span>Daftar Agency</span></a></li>
								<li><a href="<?php echo base_url()."channel/daftarkampus";?>">> <span>Daftar Kampus</span></a></li>
								<li><a href="<?php echo base_url()."channel/daftarprodi";?>">> <span>Daftar Prodi</span></a></li>
							</ul>
						</li>
						<li><a href="<?php echo base_url() . 'channel/daftarchannel'; ?>">
							<i class="fa fa-tv red_color"></i><span>Channel Prodi</span></a>
						</li>		
						<li><a href="<?php echo base_url() . 'user/'; ?>">
							<i class="fa fa-user green_color"></i><span>Daftar User</span></a>
						</li>
						<li>
							<a href="#elementf" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-money green_color"></i> <span>Keuangan</span></a>
							<ul class="collapse list-unstyled" id="elementf">
								<li><a href="<?php echo base_url()."finance";?>">> <span>Laporan Keuangan</span></a></li>
								<li><a href="<?php echo base_url()."finance/transaksi_siplah";?>">> <span>Transaksi SIPLAH</span></a></li>
							</ul>
						</li>

									
						<li><a href="<?php echo base_url() . 'event/spesial/admin/'; ?>"><i
									class="fa fa-safari blue1_color"></i> <span>Lokakarya / Seminar</span></a></li>
<!--						<li>-->
<!--							<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i-->
<!--									class="fa fa-line-chart green_color"></i> <span>Laporan Aktifitas</span></a>-->
<!--							<ul class="collapse list-unstyled" id="element">-->
<!--								<li><a href="progres.html">> <span>Progres</span></a></li>-->
<!--								<li><a href="jadwal.html">> <span>Jadwal</span></a></li>-->
<!--								<li><a href="pembayaran.html">> <span>Pembayaran</span></a></li>-->
<!--								<li><a href="sertifikat.html">> <span>Sertifikat</span></a></li>-->
<!--							</ul>-->
<!--						</li>-->
						<li>
							<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-youtube-play red_color"></i> <span>Video</span></a>
							<ul class="collapse list-unstyled" id="element">
								<li><a href="<?php echo base_url()."video/kontributor/dashboard";?>">> <span>Video Kontributor</span></a></li>
								<li><a href="<?php echo base_url()."video/ekskul/dashboard";?>">> <span>Video Ekskul</span></a></li>
								<li><a href="<?php echo base_url()."video/event/dashboard";?>">> <span>Video Event</span></a></li>
								<?php if($this->session->userdata('bimbel')==4 || $this->session->userdata('a01'))
								{ ?>
									<li><a href="<?php echo base_url()."video/bimbel/dashboard";?>">> <span>Video Bimbel</span></a></li>
								<?php } ?>
							</ul>
						</li>
						<?php if($this->session->userdata('bimbel')==3 &&
							($this->session->userdata('sebagai')==1))
						{ ?>
							<li><a href="<?php echo base_url() . 'bimbel/modul_saya'; ?>"><i
										class="fa fa-folder green_color"></i> <span>Modul Bimbel</span></a></li>
						<?php } ?>
						<li><a href="<?php echo base_url() . 'login/logout'; ?>"><i class="fa fa-close red_color"></i>
								<span>Logout</span></a></li>
					<?php } else if ($profilku->statususer == 6) { ?>
						<li><a href="<?php echo base_url();?>" onclick="balikkedepan();"><i class="fa fa-home purple_color2"></i>
								<span>Beranda</span></a></li>
						<li><a href="<?php echo base_url() . 'profil/profil_diri'; ?>"><i
									class="fa fa-user green_color"></i> <span>Profil Saya</span></a></li>

						<li>
							<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-youtube-play red_color"></i> <span>Video</span></a>
							<ul class="collapse list-unstyled" id="element">
								<li><a href="<?php echo base_url()."video/saya/dashboard";?>">> <span>Video Saya</span></a></li>
								<?php if($this->session->userdata('bimbel')==4)
								{ ?>
									<li><a href="<?php echo base_url()."video/bimbel/dashboard";?>">> <span>Video Bimbel</span></a></li>
								<?php } ?>
							</ul>
						</li>
						<li><a href="<?php echo base_url() . 'login/logout'; ?>"><i class="fa fa-close red_color"></i>
								<span>Logout</span></a></li>
					<?php } else { ?>
						<li><a href="profil.html"><i class="fa fa-user green_color"></i> <span>Profil Saya</span></a>
						</li>
						<li><a href="kelas_virtual.html"><i class="fa fa-desktop yellow_color"></i>
								<span>Kelas Virtual</span></a></li>
						<li><a href="ekstra_kurikuler.html"><i class="fa fa-plus-circle orange_color"></i> <span>Ekstra Kurikuler</span></a>
						</li>
						<li>
							<a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
									class="fa fa-pencil green_color"></i> <span>Laporan Aktifitas</span></a>
							<ul class="collapse list-unstyled" id="element">
								<li><a href="progres.html">> <span>Progres</span></a></li>
								<li><a href="jadwal.html">> <span>Jadwal</span></a></li>
								<li><a href="pembayaran.html">> <span>Pembayaran</span></a></li>
								<li><a href="sertifikat.html">> <span>Sertifikat</span></a></li>
							</ul>
						</li>
						<li><a href="pesan.html"><i class="fa fa-envelope blue2_color"></i> <span>Pesan</span></a></li>
						<li><a href="pengaturan.html"><i class="fa fa-cog yellow_color"></i> <span>Pengaturan</span></a>
						</li>
						<li><a href="#"><i class="fa fa-home purple_color2"></i> <span>Beranda</span></a></li>
					<?php } ?>
					<!--Akhir Menu Samping-->
				</ul>
			</div>
		</nav>
		<!-- end sidebar -->
		<!-- right content -->
		<div id="content">
			<!-- topbar -->
			<div class="topbar">
				<nav class="navbar navbar-expand-lg navbar-light">
					<div class="full">
						<button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i>
						</button>
						<div class="logo_section">
							<a href="<?php echo base_url(); ?>"><img class="img-responsive"
																	 src="<?php echo base_url(); ?>images/logo-2.png"
																	 alt="#"/></a>
						</div>
						<div class="right_topbar">
							<div class="icon_info" style="margin-right: 5px;">
								<ul>
									<!--									<li><a href="#"><i class="fa fa-home"></i></a></li>-->
									<li><a href="#"><i class="fa fa-bell-o"></i><span style="display: none"
																					  class="badge">0</span></a></li>
									<!--									<li><a href="#"><i class="fa fa-question-circle"></i></a></li>-->
									<li><a href="#"><i class="fa fa-envelope-o"></i><span style="display: none"
																						  class="badge">0</span></a>
									</li>
								</ul>
								<!--								<ul class="user_profile_dd">-->
								<!--									<li>-->
								<!--										<a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="images/layout_img/user_img.jpg" alt="#" /><span class="name_user">-->
								<?php //echo $username;?><!--</span></a>-->
								<!--										<div class="dropdown-menu">-->
								<!--											<a class="dropdown-item" href="profil.html">Profil Saya</a>-->
								<!--											<a class="dropdown-item" href="pengaturan.html">Pengaturan</a>-->
								<!--											<a class="dropdown-item" href="bantuan.html">Bantuan</a>-->
								<!--											<a class="dropdown-item" href="#"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>-->
								<!--										</div>-->
								<!--									</li>-->
								<!--								</ul>-->
							</div>
						</div>
					</div>
				</nav>
			</div>
			<!-- end topbar -->
			<?php
			require_once('konten.php');
			?>
			<!-- model popup -->
			<!-- The Modal -->
			<div class="modal fade" id="myModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<!-- Modal Header -->
						<div class="modal-header">
							<h4 class="modal-title">Modal Heading</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<!-- Modal body -->
						<div class="modal-body">
							Modal body..
						</div>
						<!-- Modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end model popup -->
		</div>
	</div>
	<!-- jQuery -->
	<?php require_once('calljsprofil.php'); ?>
</body>
</html>

<script>
	function balikkedepan() {
		// let cookies = document.cookie;
		// hasil = getCookie('lastalamat');
		// window.open(hasil, "_self");
	}

	function getCookie(name) {
		var cookieArr = document.cookie.split(";");
		for (var i = 0; i < cookieArr.length; i++) {
			var cookiePair = cookieArr[i].split("=");
			if (name == cookiePair[0].trim()) {
				return decodeURIComponent(cookiePair[1]);
			}
		}

		return null;
	}

	<?php if(isset($status_tunggu))
		if($status_tunggu == "tunggu") {?>
	var idcekbayar = setInterval(cekbayar, 5000);

	function cekbayar() {
		$.ajax({
			type: 'GET',
			dataType: 'TEXT',
			cache: false,
			url: '<?php echo base_url();?>profil/cekstatusbayarsekolah',
			success: function (result) {
				if (result == "tidak") {
					clearInterval(idcekbayar);
					window.location.reload();
				}
			}
		});
	}
	<?php } ?>
</script>
