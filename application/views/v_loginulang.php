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
						<h1>Pendaftaran</h1>
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

				<div style="color:black;margin-bottom:30px;font-weight:bold; font-size:22px;text-align: center">SELAMAT.
					ANDA
					BERHASIL MENDAFTAR DI TV-KAMPUS SEBAGAI
				</div>
				<br>

				<?php 
				$calvermentor=0;
				$cekkikimentor = get_cookie('mentor');
				if (substr($cekkikimentor,0,2) == "1-")
				$calvermentor=1;

				if ($sebagai == 1 && $this->session->userdata("verifikator")==2) {
					?>
					<div style="font-weight:bold; font-size:22px;text-align: center">
						<img class="profile-img"
							 style="max-width: 200px;max-height: 200px"
							 src="<?php echo base_url(); ?>assets/images/ikon-guru.png"
							 alt=""><br>
						<span style="font-weight: bold;font-size: 24px">CALON VERIFIKATOR</span>
						<br>
						
					</div>
					<?php
				} else if ($sebagai == 1 && $this->session->userdata("verifikator")==3) {
					?>
					<div style="font-weight:bold; font-size:22px;text-align: center">
						<img class="profile-img"
							 style="max-width: 200px;max-height: 200px"
							 src="<?php echo base_url(); ?>assets/images/ikon-guru.png"
							 alt=""><br>
						<span style="font-weight: bold;font-size: 24px">VERIFIKATOR</span>
						<br>
						
					</div>
					<?php
				} else if ($sebagai == 1 && $this->session->userdata("kontributor")==3) {
					?>
					<div style="font-weight:bold; font-size:22px;text-align: center">
						<img class="profile-img"
							 style="max-width: 200px;max-height: 200px"
							 src="<?php echo base_url(); ?>assets/images/ikon-guru.png"
							 alt=""><br>
						<span style="font-weight: bold;font-size: 24px">DOSEN</span>
						<br>
						
					</div>
					<?php
				} else if ($sebagai == 1 && $this->session->userdata("verifikator")!=3) {
					?>
					<div style="font-weight:bold; font-size:22px;text-align: center">
						<img class="profile-img"
							 style="max-width: 200px;max-height: 200px"
							 src="<?php echo base_url(); ?>assets/images/ikon-guru.png"
							 alt=""><br>
						<span style="font-weight: bold;font-size: 24px">CALON DOSEN</span>
						<br>
						<?php if($calvermentor==1)
						{
							//setcookie('mentor', '--', time() + (86400), '/');
							?>
							<span style="font-size: 16px; color: red;">(Anda tidak dapat menjadi Verifikator karena di sekolah sudah ada Verifikator. 
							Klik tombol Saya untuk melihat nama Verifikator pada bagian Sekolah Saya)</span>
							<?php
						}
						else
						{ 	
							
							?>
							<span style="font-size: 16px; color: red;">(Mintalah Verifikator Prodi Kampus segera memverifikasi
							anda. Klik tombol Saya untuk melihat nama Verifikator pada bagian Kampus Saya)</span>
							<?php 
							
						}
						?>
						<br>
					</div>
					<?php
				} else if ($sebagai == 2) {
					?>
					<div style="font-weight:bold; font-size:22px;text-align: center">

						<img class="profile-img"
							 style="max-width: 200px;max-height: 200px"
							 src="<?php echo base_url(); ?>assets/images/ikon-siswa.png"
							 alt=""><br>
						<span style="font-weight: bold;font-size: 24px">MAHASISWA</span>

						<?php if ($datashared!=""){?>
							<br><br>
							<?php if(substr($datashared,0,3)=="ecr")
							{ ?>
								<button class="btn-main" onclick="window.open('<?php
								echo base_url().'bimbel/pilih_eceran/'.substr($datashared,3);?>','_self');">OK</button>
							<?php } else if(substr($datashared,0,3)=="pkt")
							{ ?>
								<button class="btn-main" onclick="window.open('<?php
								echo base_url().'bimbel/pilih_paket/'.substr($datashared,3);?>','_self');">OK</button>
							<?php }
						} ?>

					</div>
					<?php
				} else if ($sebagai == 3) {
					?>
					<div style="font-weight:bold; font-size:22px;text-align: center">

						<img class="profile-img"
							 style="max-width: 200px;max-height: 200px"
							 src="<?php echo base_url(); ?>assets/images/ikon-umum.png"
							 alt=""><br>
						<span style="font-weight: bold;font-size: 24px">USER TVSEKOLAH</span>
					</div>
					<?php
				} else if ($sebagai == 4) {
					if ($this->session->userdata('siae') == 2) {
						?>
						<div style="font-weight:bold; font-size:22px;text-align: center">

							<img class="profile-img"
								 style="max-width: 200px;max-height: 200px"
								 src="<?php echo base_url(); ?>assets/images/ikon-staf.png"
								 alt=""><br>
							<span style="font-weight: bold;font-size: 24px">ACCOUNT EXECUTIVE</span>
						</div>
						<?php
					} else if ($this->session->userdata('siam') == 2) {
						?>
						<div style="font-weight:bold; font-size:22px;text-align: center">

							<img class="profile-img"
								 style="max-width: 200px;max-height: 200px"
								 src="<?php echo base_url(); ?>assets/images/ikon-staf.png"
								 alt=""><br>
							<span style="font-weight: bold;font-size: 24px">ACCOUNT MANAGER</span>
						</div>
						<?php
					} else if ($this->session->userdata('bimbel') == 2) {
						?>
						<div style="font-weight:bold; font-size:22px;text-align: center">

							<img class="profile-img"
								 style="max-width: 200px;max-height: 200px"
								 src="<?php echo base_url(); ?>assets/images/ikon-staf.png"
								 alt=""><br>
							<span style="font-weight: bold;font-size: 24px">TUTOR BIMBEL</span>
						</div>
						<?php
					} else if ($this->session->userdata('siag') == 2) {
						?>
						<div style="font-weight:bold; font-size:22px;text-align: center">

							<img class="profile-img"
								 style="max-width: 200px;max-height: 200px"
								 src="<?php echo base_url(); ?>assets/images/ikon-staf.png"
								 alt=""><br>
							<span style="font-weight: bold;font-size: 24px">AGENCY TVSEKOLAH</span>
						</div>
						<?php
					} else {
						?>
						<div style="font-weight:bold; font-size:22px;text-align: center">

							<img class="profile-img"
								 style="max-width: 200px;max-height: 200px"
								 src="<?php echo base_url(); ?>assets/images/ikon-staf.png"
								 alt=""><br>
							<span style="font-weight: bold;font-size: 24px">STAF FORDORUM</span>
						</div>
						<?php
					}
				}
				if (get_cookie('acara')>0)
					{ ?>
						<center>
						<div style="max-width:200px;padding-top:10px;">
						<button class="myButtonDaftar"
									onclick="window.open('<?php echo base_url()."event/acara/".get_cookie('acara');?>','_self')">
								LANJUT
							</button>
						</div>
						</center>
					<?php }
				else if ($kodeeventdefault == "kosong" && $datashared == "") {
					?>
					<br>
					<div style="margin-bottom:30px;color:#8e2f23;font-weight:bold;font-size:22px;text-align: center">
						<br><br>
						<button class="myButtonDaftar" onclick="return keberanda()">
							BERANDA
						</button>
					</div>
				<?php } else {
					if ($sebagai == 1 && $this->session->userdata("verifikator")==2)
					{?>
						<center>
						<div style="max-width:200px;padding-top:10px;">
						<button class="myButtonDaftar"
									onclick="window.open('<?php echo base_url()."event/calon_verifikator";?>','_self')">
								LANJUT
							</button>
						</div>
						</center>
					<?php }
					else if ($this->session->userdata('siam') == 0 && $this->session->userdata('siae') == 0
						&& $this->session->userdata('tutor') == 0 && $this->session->userdata('siag') == 0
						&& $this->session->userdata('sebagai') != 2) {
						?>
						<br>
						<div
							style="margin-bottom:30px;color:#8e2f23;font-weight:bold;font-size:22px;text-align: center">
							Silakan pilih salah satu fitur pada menu Fitur Utama, atau anda bisa klik tombol "IKUT EVENT" untuk
							melihat event berupa Lokakarya, Seminar, atau Workshop yang diadakan TVSekolah.

							<br><br>
							<button class="myButtonDaftar"
									onclick="window.open('<?php echo base_url()."event/acara";?>','_self')">
								IKUT EVENT
							</button>
						</div>
						<?php
					}
				} ?>
			</div>
		</div>
	</section>
</div>

<!---->
<script>

	function daftarkansaya(kodeevent) {
		<?php if($iuran == 0) {?>
		$('#daftarkansaya-button').attr("disabled", "disabled");
		$.ajax({
			url: '<?php echo base_url();?>payment/free_event/' + kodeevent,
			cache: false,
			success: function (data) {
				if (data == "tutup")
					window.open("<?php echo base_url();?>event/spesial/acara", '_self');
				else
					window.open("<?php echo base_url();?>event/terdaftar/" + kodeevent, '_self');
			}
		});
		<?php } else {?>
		$('#daftarkansaya-button').attr("disabled", "disabled");
		window.open('<?php echo base_url();?>event/ikutevent/' + kodeevent, '_self');
		<?php } ?>
	};

	function keberanda() {
		window.open("<?php echo base_url();?>", "_self");
	}

</script>
