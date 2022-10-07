<div class="de-flex-col header-col-mid">
	<!-- mainmenu begin -->
	<ul id="mainmenu">
		<li>
			<a href="<?php echo base_url(); ?>">Beranda<span></span></a>
		</li>
		<li>
			<a href="#">Fitur Utama<span></span></a>
			<ul>
				<li><a href="<?php echo base_url(); ?>channel/">Panggung Sekolah</a></li>
				<li><a href="<?php echo base_url(); ?>vod/">Perpustakaan Digital</a></li>
				<?php if ($this->session->userdata('sebagai') == 1 || $this->session->userdata('sebagai') == 2) {?>
					<li><a href="<?php echo base_url(); ?>virtualkelas/">Kelas Virtual</a></li>
				<?php } else {?>
					<li><a href="<?php echo base_url(); ?>virtualkelas/">Kelas Virtual</a></li>
				<?php } ?>
				<?php if ($this->session->userdata('sebagai') == 1 || $this->session->userdata('sebagai') == 2) {
					?>
					<li><a href="<?php echo base_url(); ?>ekskul">Ekskul MD</a></li>
				<?php } else {
					?>
					<li><a href="<?php echo base_url(); ?>informasi/ekstrakurikuler">Ekskul MD</a></li>
				<?php
				}
				?>

			</ul>
		</li>
		<li>
			<a href="#">Informasi<span></span></a>
			<ul>
				<li><a href="<?php echo base_url(); ?>event/acara">Lokakarya/Seminar</a></li>
				<li><a href="<?php echo base_url(); ?>informasi/faq">FAQ</a></li>
				<li><a href="<?php echo base_url(); ?>peluangkarir">Peluang Karir</a></li>
			</ul>
		</li>
		<li>
			<a href="#">Tentang Kami<span></span></a>
			<ul>
				<li><a href="<?php echo base_url(); ?>tentangkami">Tentang Kami</a></li>
				<li><a href="<?php echo base_url(); ?>perwakilan">Kantor Perwakilan</a></li>
				<li><a href="<?php echo base_url(); ?>tentangkami/hubungi_kami">Hubungi Kami</a></li>
				<li><a href="<?php echo base_url(); ?>tentangkami/kebijakan">Kebijakan</a></li>
			</ul>
		</li>
	</ul>
	<div class="menu_side_area">
		<?php if ($this->session->userdata('loggedIn')) { ?>
			<a href="#" onclick="return masukprofil();" class="btn-main"><span>Saya</span></a>
		<?php } else {
			?>
			<a href="<?php echo base_url(); ?>login" class="btn-main"><span>Login</span></a>
		<?php } ?>
		<span id="menu-btn"></span>
	</div>
</div>

<script>
	// Set a Cookie
	function setCookie(cName, cValue, expDays) {
		let date = new Date();
		date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
		const expires = "expires=" + date.toUTCString();
		document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
	}
	// Apply setCookie


	function masukprofil()
	{
		let alamat = window.location.href;
		setCookie('lastalamat', alamat, 1);
		window.open('<?php echo base_url(); ?>profil','_self');
		//window.open("https://www.w3schools.com");
	}
</script>
