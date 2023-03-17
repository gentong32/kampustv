<style>
	.sidenav {
		height: 80%;
		width: 0;
		position: fixed;
		z-index: 1;
		top: 70px;
		left: 0;
		background-color: #FFFFFF;
		border: 1px black solid;
		overflow-x: hidden;
		transition: 0.5s;
		padding-top: 60px;
	}

	.sidenav a {
		padding: 8px 8px 8px 32px;
		text-decoration: none;
		font-size: 20px;
		color: #818181;
		display: block;
		transition: 0.3s;
	}

	.sidenav a:hover {
		color: #f1f1f1;
	}

	.sidenav .closebtn {
		position: absolute;
		top: 0;
		right: 25px;
		font-size: 36px;
		margin-left: 50px;
	}

	@media screen and (max-height: 450px) {
		.sidenav {
			padding-top: 15px;
		}

		.sidenav a {
			font-size: 18px;
		}
	}
</style>


<?php
$warna = array();
$linkevent = array();
$logo = "Tvs_logo.png";

$this->load->model("M_induk");
$jmlm =$this->M_induk->getAllUmumAktif();

echo "<pre>";
echo var_dump ($jmlm);
echo "</pre>";

if ($jmlm)
	$jmlumum = sizeof($jmlm);
else
	$jmlumum = 0;

for ($a = 1; $a <= 41; $a++) {
	if ($a == $menuaktif) {
		$warna[$a] = "color:#0093df;font-weight:bold;";
	} else {
		$warna[$a] = "color:#000000;font-weight:normal;";
	}
}

if (($menuaktif >= 2 && $menuaktif <= 5) || $menuaktif == 32) {
	$warna[0] = "color:#0093df;font-weight:bold;";
} else {
	$warna[0] = "color:#0093df;font-weight:normal;";
}

if ($menuaktif >= 23 && $menuaktif <= 26) {
	$warna[6] = "color:#0093df;font-weight:bold;";
} else {
	$warna[6] = "color:#0093df;font-weight:normal;";
}

if ($menuaktif == 8) {
	$warna[8] = "color:#0093df;font-weight:bold;";
} else {
	$warna[8] = "color:#0093df;font-weight:normal;";
}

if ($menuaktif >= 10 && $menuaktif <= 20) {
	$warna[6] = "color:#0093df;font-weight:bold;";
	$warna[8] = "color:#0093df;font-weight:bold;";
	$warna[9] = "color:#0093df;font-weight:bold;";
} else {
	$warna[6] = "color:#0093df;font-weight:normal;";
	$warna[8] = "color:#0093df;font-weight:normal;";
	$warna[9] = "color:#0093df;font-weight:normal;";
}

if ($menuaktif == 22) {
	$warna[22] = "color:#0093df;font-weight:bold;";
} else {
	$warna[22] = "color:#000000;font-weight:normal;";
}

if ($menuaktif == 24 || $menuaktif == 26) {
	$warna[6] = "color:#0093df;font-weight:bold;";
} else {
	$warna[6] = "color:#0093df;font-weight:normal;";
}

if ($menuaktif == 23 || $menuaktif == 25) {
	$warna[8] = "color:#0093df;font-weight:bold;";
	$warna[9] = "color:#0093df;font-weight:bold;";
} else {
	$warna[8] = "color:#0093df;font-weight:normal;";
	$warna[9] = "color:#0093df;font-weight:normal;";
}

if (($menuaktif >= 28 && $menuaktif <= 30) || $menuaktif == 33 || $menuaktif == 34) {
	$warna[27] = "color:#0093df;font-weight:bold;";
} else {
	$warna[27] = "color:#0093df;font-weight:normal;";
}


$statussebagai = "";
if ($this->session->userdata('sebagai') == "4")
	$statussebagai = " Fordorum";

?>

<div class="navbar navbar-light navbar-fixed-top" style="background-color: #ffffff;border-bottom: 1px solid black;">
	<div class="container" style="width: 100%;">
		<div class="navbar-header">
			<div style="float: left">
				<a href="<?php echo base_url(); ?>" class="navbar-brand navbar-title">
					<img style="margin-top: -10px;" height="42"
						 src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>"/>
				</a>
			</div>
			<div class="navbar-toggle">
				<?php if ($this->session->userdata('loggedIn')) {
					if (substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], "profile")) == "profile") {
						echo '<a href="javascript:history.back()"><span style="font-weight:bold;color: #9d261d;">' .
							$this->session->userdata("first_name") . '</span></a>';
					} else {
						?>

						<a href="<?php echo base_url(); ?>login/profile"><span style="font-weight:bold;color: #9d261d;"><?php
								echo $this->session->userdata('first_name'); ?></span></a>
					<?php }
				} ?>
				<button type="button" data-toggle="collapse" data-target="#navbar-main">
					<img style="" width="10" height="10" src="<?php echo base_url(); ?>assets/images/dl_iko.png"/>
					<!--				<span class="icon-bar"></span>-->
				</button>
			</div>

		</div>
		<div class="navbar-collapse collapse" id="navbar-main">
			<ul class="nav navbar-nav">
				<li style="font-size: 15px; font-weight: bold">
					<a href="<?php echo base_url(); ?>"><span style="color:<?php echo $warna[1]; ?>">Beranda</span></a>
				</li>
				<?php if($this->session->userdata('bimbel')==2) {?>
				<li style="font-size: 15px; font-weight: bold">
					<a href="<?php echo base_url().'assesment'; ?>"><span style="color:red">Assesment</span></a>
				</li>
				<?php } ?>
				<?php if ($this->session->userdata('a01') ||
					($this->session->userdata('a02') && $this->session->userdata('activate') == 1 &&
						((($this->session->userdata('statusbayar') == 3 || $this->session->userdata('statusbayar') == 2) && $this->session->userdata('sebagai') == 1) ||
							$this->session->userdata('sebagai') == 4)) || ($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3)) { ?>
					<li class="dropdown" style="font-size: 15px; font-weight: bold">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
								style="color:<?php echo $warna[9]; ?>"><?php if ($this->session->userdata('a01'))
									echo "Admin"; else echo "Verifikator" . $statussebagai; ?></span><span
								class="caret" style="color: #5f5f5f"></span></a>
						<ul class="dropdown-menu" aria-labelledby="themes">
							<?php if ($this->session->userdata('a01') || $this->session->userdata('a02')) { ?>
								<?php if ($this->session->userdata('a01')) { ?>
									<li><a href="<?php echo base_url(); ?>statistik"><span class="menuku"
																						   style="<?php echo $warna[10]; ?>">Statistik</span></a>
									</li>
								<?php } ?>

								<?php if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4) { ?>
									<li><a href="<?php echo base_url(); ?>user/staf"><span class="menuku"
																						   style="<?php echo $warna[12]; ?>">Daftar Staf</span></a>
									</li>
								<?php } ?>

								<?php if ($this->session->userdata('a01') || $this->session->userdata('a02')) { ?>
									<li><a href="<?php echo base_url(); ?>user"><span class="menuku"
																					  style="<?php echo $warna[11]; ?>">Daftar User</span></a>
									</li>
								<?php } ?>

<!--								--><?php //if ($this->session->userdata('a01')) { ?>
<!--									<li><a href="--><?php //echo base_url(); ?><!--user/ae"><span class="menuku"-->
<!--																						 style="--><?php //echo $warna[11]; ?><!--">Daftar User AE</span></a>-->
<!--									</li>-->
<!--									<li><a href="--><?php //echo base_url(); ?><!--user/am"><span class="menuku"-->
<!--																						 style="--><?php //echo $warna[11]; ?><!--">Daftar User AM</span></a>-->
<!--									</li>-->
<!--								--><?php //} ?>

<!--								--><?php //if ($this->session->userdata('a01') ||
//									($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3)) { ?>
<!--									<li><a href="--><?php //echo base_url(); ?><!--user/bimbel"><span class="menuku"-->
<!--																							 style="--><?php //echo $warna[12]; ?><!--">Daftar User Tutor Bimbel</span></a>-->
<!--									</li>-->
<!--									<li><a href="--><?php //echo base_url(); ?><!--user/narsum"><span class="menuku"-->
<!--																							 style="--><?php //echo $warna[12]; ?><!--">Daftar Narasumber</span></a>-->
<!--									</li>-->
<!--								--><?php //} ?>

<!--								--><?php //if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4)) { ?>
<!--									<li><a href="--><?php //echo base_url(); ?><!--user/verifikator"><span class="menuku"-->
<!--																								  style="--><?php //echo $warna[12]; ?><!--">Calon Verifikator Sekolah</span></a>-->
<!--									</li>-->
<!--								--><?php //} ?>
								<?php
								if ($this->session->userdata('a01') || ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 4)) {
									?>
									<li><a href="<?php echo base_url(); ?>user/kontributor"><span class="menuku"
																								  style="<?php echo $warna[13]; ?>">Calon Kontributor Sekolah</span></a>
									</li>
									<li class="divider"></li>
								<?php }
								echo "<div style='margin-top:-20px;margin-bottom:-20px'><hr></div>";
							} ?>
							<?php if ($this->session->userdata('verifikator') == 3) { ?>
								<li><a href="<?php echo base_url(); ?>seting/kompetensi"><span class="menuku"
																							   style="<?php echo $warna[14]; ?>">Daftar KD</span></a>
								</li>
								<li class="divider"></li>
							<?php } ?>
							<?php if ($this->session->userdata('a01') ||
								$this->session->userdata('sebagai') == 4) { ?>
								<li><a href="<?php echo base_url(); ?>video"><span class="menuku"
																				   style="<?php echo $warna[14]; ?>">Daftar Video</span></a>
								</li>
								<li class="divider"></li>
							<?php } ?>
							<?php if ($this->session->userdata('a02') && !$this->session->userdata('a01')) { ?>
								<li><a href="<?php echo base_url(); ?>video/saya"><span class="menuku"
																				   style="<?php echo $warna[14]; ?>">Daftar Video Saya</span></a>
								</li>
								<li><a href="<?php echo base_url(); ?>video/kontributor"><span class="menuku"
																				   style="<?php echo $warna[14]; ?>">Daftar Video Kontributor</span></a>
								</li>
								<li class="divider"></li>
							<?php } ?>
							<?php
							if ($this->session->userdata('a02') && !$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
								?>

								<li>
									<a href="<?php echo base_url(); ?>channel/playlistsekolah">
                                        <span class="menuku"
											  style="<?php echo $warna[18]; ?>">Playlist Sekolah</span></a></li>
								<li>
									<a href="<?php echo base_url(); ?>channel/sekolah/ch<?php echo $this->session->userdata('npsn'); ?>">
                                        <span class="menuku"
											  style="<?php echo $warna[16]; ?>">Channel Sekolah</span></a>
								</li>
								<li class="divider"></li>
							<?php }
							if ($this->session->userdata('a01')) {
								?>
								<li>
									<a href="<?php echo base_url(); ?>channel/playlisttve">
										<span class="menuku" style="<?php echo $warna[20]; ?>">Playlist TVSekolah</span></a>
								</li>
							<?php } ?>
							<?php if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4) { ?>
								<li><a href="<?php echo base_url(); ?>channel/daftarchannel"><span class="menuku"
																								   style="<?php echo $warna[15]; ?>">Daftar Channel</span></a>
								</li>

								<li><a href="<?php echo base_url(); ?>statistik/datasekolah"><span class="menuku"
																								   style="<?php echo $warna[15]; ?>">Statistik Channel</span></a>
								</li>

								<li><a href="<?php echo base_url(); ?>statistik/statistik_ae"><span class="menuku"
																									style="<?php echo $warna[15]; ?>">Statistik AE</span></a>
								</li>

								<li><a href="<?php echo base_url(); ?>statistik/dataguru"><span class="menuku"
																								style="<?php echo $warna[15]; ?>">Statistik Guru</span></a>
								</li>

							<?php } ?>

							<?php if ($this->session->userdata('a01')) { ?>
								<hr style="margin-top: 5px;margin-bottom: 5px">
								<li><a href="<?php echo base_url(); ?>payment/transaksi">
										<span class="menuku" style="<?php echo $warna[23]; ?>">Transaksi</span></a>
								</li>
							<?php } ?>


							<?php
							if ($this->session->userdata('a02') && !$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
								?>
								<li>
									<a href="<?php echo base_url(); ?>channel/playlistguru">
										<span class="menuku" style="<?php echo $warna[19]; ?>">Kelas Saya</span></a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>channel/guru/chusr<?php echo $this->session->userdata('id_user'); ?>">
										<span class="menuku" style="<?php echo $warna[17]; ?>">Channel Saya</span></a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="<?php echo base_url(); ?>tutor/transaksi_verifikator">
										<span class="menuku" style="<?php echo $warna[17]; ?>">Poin Saya</span></a>
								</li>
								<?php if ($this->session->userdata('mou') >= 2) { ?>
						<li style="font-size: 15px;">
							<a href="<?php echo base_url(); ?>payment/pembayaran"><span
									style="">Iuran</span></a>
						</li>
					<?php }?>
<!--								--><?php //echo "<div style='margin-top:20px;margin-bottom:-20px'><hr></div>";
//								if ($this->session->userdata('bimbel') == 3) { ?>
<!--									<li class="divider"></li>-->
<!--									<li>-->
<!--										<a href="--><?php //echo base_url(); ?><!--channel/playlistbimbel">-->
<!--											<span class="menuku"-->
<!--												  style="--><?php //echo $warna[31]; ?><!--">Modul Bimbel</span></a></li>-->
<!--								--><?php //}
							} ?>

							<?php if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4) { ?>
								<hr style="margin-top: 5px;margin-bottom: 5px">
								<li><a href="<?php echo base_url(); ?>seting/url_live">
										<span class="menuku" style="<?php echo $warna[24]; ?>">Event Live</span></a>
								</li>
								<li><a href="<?php echo base_url(); ?>event/spesial/admin">
										<span class="menuku"
											  style="<?php echo $warna[25]; ?>">Event Acara Spesial</span></a>
								</li>
								<hr style="margin-top: 5px;margin-bottom: 5px">
								<li><a href="<?php echo base_url(); ?>informasi/daftarpengumuman">
										<span class="menuku" style="<?php echo $warna[25]; ?>">Daftar Pengumuman</span></a>
								</li>
							<?php } ?>

							<?php if ($this->session->userdata('email') == 'CEO@tvsekolah.id') { ?>
								<hr style="margin-top: 5px;margin-bottom: 5px">
								<li><a href="<?php echo base_url(); ?>payment/transaksi">
										<span class="menuku" style="<?php echo $warna[23]; ?>">Transaksi</span></a>
								</li>
							<?php } ?>

						</ul>
					</li>
				<?php } ?>

				<?php if (isset($this->session->userdata['verifikator'])) {
					if ($this->session->userdata('mou') != 2 && $this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') > 0 &&
						$this->session->userdata('statusbayar') != 3) { ?>
						<li style="font-size: 15px;">
							<a href="<?php echo base_url(); ?>payment/pembayaran"><span
									style="color:#be3f3f;font-weight: bold">Iuran</span></a>
						</li>
					<?php }
				} ?>

				<?php if ($this->session->userdata('a03') && !$this->session->userdata('a02') && !$this->session->userdata('a01')) { ?>

					<li class="dropdown" style="font-size: 15px; font-weight: bold">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
								style="color:<?php echo $warna[8]; ?>">Kontributor</span><span
								class="caret" style="color: #5f5f5f"></span></a>
						<ul class="dropdown-menu" aria-labelledby="themes">


							<li><a href="<?php echo base_url(); ?>video"><span class="menuku"
																			   style="<?php echo $warna[14]; ?>">Daftar Video Saya</span></a>
							</li>
							<?php if ($this->session->userdata('sebagai') != 4) { ?>
								<li class="divider"></li>
								<li>
									<a href="<?php echo base_url(); ?>channel/playlistguru">
										<span class="menuku" style="<?php echo $warna[19]; ?>">Kelas Saya</span></a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>channel/guru/chusr<?php echo $this->session->userdata('id_user'); ?>">
										<span class="menuku" style="<?php echo $warna[17]; ?>">Channel Saya</span></a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="<?php echo base_url(); ?>tutor/transaksi">
										<span class="menuku" style="<?php echo $warna[17]; ?>">Poin Saya</span></a>
								</li>
							<?php } ?>
<!--							--><?php //if ($this->session->userdata('bimbel') == 3) { ?>
<!--								<li class="divider"></li>-->
<!--								<li>-->
<!--									<a href="--><?php //echo base_url(); ?><!--channel/playlistbimbel">-->
<!--										<span class="menuku" style="--><?php //echo $warna[31]; ?><!--">Modul Bimbel</span></a>-->
<!--								</li>-->
<!--								<li>-->
<!--									<a href="--><?php //echo base_url(); ?><!--bimbel">-->
<!--										<span class="menuku" style="--><?php //echo $warna[22]; ?><!--">Channel Bimbel</span></a>-->
<!--								</li>-->
<!--							--><?php //} ?>

						</ul>
					</li>
				<?php } ?>

				<?php if ($this->session->userdata('siae') == 3) { ?>

					<li class="dropdown" style="font-size: 15px; font-weight: bold">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
								style="color:<?php echo $warna[8]; ?>">Menu AE</span><span
								class="caret" style="color: #5f5f5f"></span></a>
						<ul class="dropdown-menu" aria-labelledby="themes">


							<li><a href="<?php echo base_url(); ?>eksekusi">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Transaksi Baru</span></a>
							</li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>eksekusi/donatur">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Daftar Donatur Saya</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>eksekusi/transaksi">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Daftar Transaksi</span></a>
							</li>
<!--							<li>-->
<!--								<a href="--><?php //echo base_url(); ?><!--eksekusi/sponsor">-->
<!--									<span class="menuku"-->
<!--										  style="--><?php //echo $warna[31]; ?><!--">Daftar Sponsor Saya</span></a></li>-->

						</ul>
					</li>
				<?php } ?>

				<?php if ($this->session->userdata('siam') == 3) { ?>

					<li class="dropdown" style="font-size: 15px; font-weight: bold">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
								style="color:<?php echo $warna[8]; ?>">Menu AM</span><span
								class="caret" style="color: #5f5f5f"></span></a>
						<ul class="dropdown-menu" aria-labelledby="themes">
							<li><a href="<?php echo base_url(); ?>marketing">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Aktivitas Baru</span></a>
							</li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>marketing/daftar_ref">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Daftar Kode Referal</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>marketing/transaksi">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Daftar Transaksi</span></a>
							</li>

						</ul>
					</li>
				<?php } ?>

				<?php if ($this->session->userdata('bimbel') == 3 && !$this->session->userdata('a01')) { ?>

					<li class="dropdown" style="font-size: 15px; font-weight: bold">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
								style="color:<?php echo $warna[8]; ?>">Menu Bimbel</span><span
								class="caret" style="color: #5f5f5f"></span></a>
						<ul class="dropdown-menu" aria-labelledby="themes">
							<?php if (!$this->session->userdata('verifikator')==3
							&& !$this->session->userdata('kontributor')==3) {?>
							<li><a href="<?php echo base_url(); ?>video">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Video Bimbel</span></a>
							</li>
								<li class="divider"></li>
							<?php } ?>

							<li><a href="<?php echo base_url(); ?>channel/playlistbimbel">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Modul Bimbel</span></a>
							</li>
						</ul>
					</li>
				<?php } ?>

				<?php if ($this->session->userdata('siag') == 3) { ?>

					<li class="dropdown" style="font-size: 15px; font-weight: bold">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
								style="color:<?php echo $warna[8]; ?>">Menu Agency</span><span
								class="caret" style="color: #5f5f5f"></span></a>
						<ul class="dropdown-menu" aria-labelledby="themes">
							<li><a href="<?php echo base_url(); ?>agency">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Daftar Aktivitas</span></a>
							</li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>agency/daftar_am">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Daftar AM</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>agency/transaksi">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Daftar Transaksi</span></a>
							</li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>agency/mou_baru">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">MoU Baru</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>agency/mou_daftar">
									<span class="menuku"
										  style="<?php echo $warna[14]; ?>">Daftar MoU</span></a>
							</li>

						</ul>
					</li>
				<?php } ?>

				<?php if ($this->session->userdata('a01') ||
					($this->session->userdata('sebagai') == 4) && $this->session->userdata('a02')) { ?>
					<li class="dropdown" style="font-size: 15px; font-weight: bold">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
								style="color:<?php echo $warna[21]; ?>">Pengaturan</span><span
								class="caret" style="color: #5f5f5f"></span></a>
						<ul class="dropdown-menu" aria-labelledby="themes">
							<li><a href="<?php echo base_url(); ?>seting/fakultas"><span class="menuku"
																						 style="color:black">Daftar Fakultas</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>seting/jurusanpt"><span class="menuku"
																						  style="color:black">Daftar Jurusan PT</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>seting/jurusansmk"><span class="menuku"
																						   style="color:black">Daftar Jurusan SMK</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>seting/daftarsekolah"><span class="menuku"
																							  style="color:black">Daftar Sekolah</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>seting/mapel"><span class="menuku"
																					  style="color:black">Daftar Mapel</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>seting/kompetensi"><span class="menuku"
																						   style="color:black">Daftar KD</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>seting/penilaian"><span class="menuku"
																						  style="color:black">Daftar Pertanyaan</span></a>
							</li>
							<hr>
							<li><a href="<?php echo base_url(); ?>seting/url_live"><span class="menuku"
																						 style="color:black">TVSekolah Live</span></a>
							</li>
							<hr>

							<li><a href="<?php echo base_url(); ?>seting/soal"><span class="menuku" style="color:black">Pertanyaan Assesment</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>promo"><span class="menuku" style="color:black">Daftar Promo</span></a>
							</li>
							<li><a href="<?php echo base_url(); ?>news"><span class="menuku" style="color:black">Daftar Berita</span></a>
							</li>

						</ul>
					</li>
				<?php } ?>


				<li class="dropdown" style="font-size: 15px; font-weight: normal">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
							style="<?php echo $warna[0]; ?>">Menu Utama</span><span
							class="caret" style="color: #7f8ce8"></span></a>
					<ul class="dropdown-menu" aria-labelledby="themes">
						<li><a href="<?php echo base_url(); ?>channel">
								<span class="menuku" style="<?php echo $warna[2]; ?>">Channel TV Prodi</span></a>
						</li>
						<li><a href="<?php echo base_url(); ?>vod">
								<span class="menuku" style="<?php echo $warna[3]; ?>">Ensiklomedia</span></a>
						</li>
						<?php if ($this->session->userdata('bimbel') >= 0) { ?>
							<li><a href="<?php echo base_url(); ?>virtualkelas">
									<span class="menuku" style="<?php echo $warna[32]; ?>">Kelas Virtual</span></a>
							</li>
						<?php } else { ?>
							<li>
								<span style="color: grey;margin-left: 20px;">Kelas Virtual</span>
							</li>
						<?php } ?>
						<?php if ($this->session->userdata('sebagai') == 2) { ?>
							<li><a href="<?php echo base_url(); ?>ekskul">
									<span class="menuku" style="<?php echo $warna[41]; ?>">Ekstra Kurikuler</span></a>
							</li>
						<?php } else { ?>
							<li>
								<span style="color: grey;margin-left: 20px;">Ekstra Kurikuler</span>
							</li>
						<?php } ?>

						<li>
							<span style="color: grey;margin-left: 20px;">Festival TV Kampus</span>
						</li>
					</ul>
				</li>

				<li class="dropdown" style="font-size: 15px; font-weight: normal">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
							style="<?php echo $warna[6]; ?>">Event</span><span
							class="caret" style="color: #7f8ce8"></span></a>
					<ul class="dropdown-menu" aria-labelledby="themes">
						<li><a href="<?php echo base_url(); ?>event">
								<span class="menuku" style="<?php echo $warna[24]; ?>">Live</span></a>
						</li>

						<li><a href="<?php echo base_url() . 'event/spesial/acara'; ?>">
								<span class="menuku" style="<?php echo $warna[26]; ?>">Acara Spesial</span></a>
						</li>

					</ul>
				</li>

				<li class="dropdown" style="font-size: 15px; font-weight: normal">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span
							style="<?php echo $warna[27]; ?>">Informasi</span><span
							class="caret" style="color: #7f8ce8"></span></a>
					<ul class="dropdown-menu" aria-labelledby="themes">
						<li><a href="<?php echo base_url() . 'informasi/pengumuman'; ?>">
								<?php if ($jmlumum > 0) { ?>
								<span class="menuku" style="<?php echo $warna[30]; ?>">Pengumuman</span></a>
							<?php } ?>
							<hr style="margin-top: 5px;margin-bottom: 5px;">
						</li>
						<li><a href="<?php echo base_url() . 'informasi/lowongan'; ?>">
								<span class="menuku" style="<?php echo $warna[33]; ?>">Peluang Karir</span></a>
						</li>
						<li><a href="<?php echo base_url() . 'informasi/agency'; ?>">
								<span class="menuku" style="<?php echo $warna[34]; ?>">Kantor Perwakilan TV Kampus</span></a>
							<hr style="margin-top: 5px;margin-bottom: 5px;">
						</li>

						<li><a href="<?php echo base_url() . 'informasi/faq'; ?>">
								<span class="menuku" style="<?php echo $warna[29]; ?>">FAQ</span></a>
						</li>
						<li><a href="<?php echo base_url(); ?>informasi">
								<span class="menuku" style="<?php echo $warna[28]; ?>">Tentang Kami</span></a>
						</li>


					</ul>
				</li>

			</ul>


			<?php if ($this->session->userdata('loggedIn')) { ?>


				<ul class="nav navbar-nav navbar-right">
					<li>
						<div class="adadantiada2" style="padding-top: 6px;">
							<a href="<?php echo base_url(); ?>login/profile"><span
									style="font-weight: bold;color: #9d261d"><?php
									echo $this->session->userdata('first_name'); ?></span></a>
						</div>
					</li>
					<li>
						<?php
						echo anchor('login/logout', 'Logout');
						?>
					</li>
				</ul>


			<?php } else { ?>

				<ul class="nav navbar-nav navbar-right">
				<li>

				<span id="keterangan" class="text-danger" style="margin-left: 10px"><?php echo "";//$message ?></span>

				<?php if (isset($message))
					if ($message == "Login Gagal")

						?>

						<button style="margin-left: 15px;margin-right: 5px;" class="btn myButton navbar-btn"
								data-toggle="modal" data-target="#myModal">LOGIN
						</button>

						</li>
						</ul>


					<?php } ?>

		</div>
	</div>
</div>


<?php
if (!$this->session->userdata('loggedIn')) {

$this->session->set_userdata('kontributor', 0);
$this->session->set_userdata('verifikator', 0);
$this->session->set_userdata('siae', false);

?>


<div class="modal fade" id="myModal">
	<?php
	echo form_open(site_url('login/login'));
	?>
	<div class="modal-dialog modal-dialog-centered" style="max-width: 350px">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h4 style="color: black" class="modal-title w-100">Login</h4>
				<button id="tombolku" type="button" class="close" data-dismiss="modal">x</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body" style="padding-top: 0">
				<div class="login-form" style="margin-top: 6px">

					<img class="profile-img" src="<?php echo base_url(); ?>assets/images/user.png"
						 style="max-width: 200px;max-height:200px" alt="">
					<div class="form-group">
						<div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user text-secondary"
															   style="border-radius: 0; margin: auto; background: #ced4da"></i></span>
							<input type="text" class="form-control" name="username" placeholder="Username"
								   required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock text-muted"
															   style="border-radius: 0; margin: auto; background: #ced4da"></i></span>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary login-btn btn-block">Sign in</button>
					</div>

					<span class="clearfix"></span>

					<!--					<div class="or-seperator"><i>atau</i></div>-->
					<p class="text-center">Login dengan akun media sosial</p>
					<div class="text-center social-btn">
						<a href="<?php echo $authURL; ?>" class="btn btn-primary"><i class="fa fa-facebook"
																					 style="font-size: medium; background:none; width:20px; padding: 0; "></i>&nbsp;
							Facebook</a>
						<!---<a href="#" class="btn btn-info"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>--->
						<a href="<?php echo $loginURL; ?>" class="btn btn-danger"><i class="fa fa-google"
																					 style="font-size: medium; background:none; width:20px; padding: 0;"></i>&nbsp;
							Google</a>
					</div>

				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<p style="color:black;font-size: large" class="text-center text-muted small">Belum memiliki akun? <span
						style="font-weight: bold"><a
							href="<?php echo base_url(); ?>login/daftar">Daftar di sini!</a></span></p>
			</div>

		</div>
	</div>

	<?php echo form_close(); ?>
	<?php } ?>
</div>

<!--<script src="--><?php //echo base_url(); ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script>

	function openNav() {
		document.getElementById("mySidenav").style.width = "250px";
	}

	function closeNav() {
		document.getElementById("mySidenav").style.width = "0";
	}
</script>
