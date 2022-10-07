<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>

	<!-- section begin -->
	<section id="subheader" class="text-light" data-bgimage="url(<?php echo base_url();?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Hubungi Kami</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section">
		<div class="container">
			<div class="row">

				<div class="col-lg-8 mb-sm-30">
					<h3>Hubungi kami melalui pesan dengan mengisi kolom di bawah ini!</h3>

					<form name="contactForm" id="contact_form" class="form-border" method="post" action="">
						<div class="field-set">
							<input type="text" name="name" id="name" class="form-control" placeholder="Nama" />
						</div>

						<div class="field-set">
							<input type="text" name="email" id="email" class="form-control" placeholder="Alamat email" />
						</div>

						<div class="field-set">
							<input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor telepon" />
						</div>

						<div class="field-set">
							<textarea name="message" id="message" class="form-control" placeholder="Hal yang ingin ditanyakan"></textarea>
						</div>

						<div class="spacer-half"></div>

						<div id="submit">
							<input type="submit" id="send_message" value="Kirim" class="btn btn-main" />
						</div>
						<div id="mail_success" class="success">Pesan anda berhasil terkirim.</div>
						<div id="mail_fail" class="error">Maaf, terjadi kesalahan. Pesan anda belum terkirim.</div>
					</form>
				</div>

				<div class="col-lg-4">

					<div class="padding40 bg-color text-light box-rounded">
						<h3>Kantor Pusat</h3>
						<address class="s1">
							<span><i class="id-color fa fa-map-marker fa-lg"></i>Menara 165 Lt. 4 Jl. TB Simatupang Kav. 1 RT 009/RW 003, Cilandak Timur, Pasar Minggu, Jakarta Selatan 12560</span>
							<span><i class="id-color fa fa-phone fa-lg"></i>(+62) 021 123 456</span>
							<span><i class="id-color fa fa-envelope-o fa-lg"></i><a href="mailto:info@tvsekolah.id">info@tvsekolah.id</a></span>
						</address>
					</div>

					<div class="spacer-10"></div>

					<div class="padding40 box-rounded mb30" data-bgcolor="#F2F6FE">
						<h3>Kantor Perwakilan</h3>
						<address class="s1">
							<span>Cari lokasi kantor perwakilan terdekat</span>
						</address>
						<a href="<?php echo base_url();?>perwakilan" class="btn-main">Cari
						</a>
					</div>

				</div>

			</div>
		</div>

	</section>

</div>
<!-- content close -->
