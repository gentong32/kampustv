<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>
	<!-- section begin -->
	<section id="subheader" class="text-light" data-bgimage="url(<?php echo base_url();?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Tutor Bimbel Online</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="blog-read">
						<div class="post-text">
							<p><h4>Deskripsi Pekerjaan:</h4>
							<ul>
								<li>Membuat modul LCMS berbasis video di tvsekolah.id</li>
								<li>Mengawal Bimbel dan melayani tanya jawab baik secara tertulis melalui menu chat maupun menggunakan menu tatap maya terjadwal</li>
								<li>Mendapatkan fee 60% dari tarif yang ditentukan pada tiap modul</li>
							</ul>
							</p>

							<p><h4>Persyaratan:</h4>
							<ul>
								<li>Video diambil dari channel youtubenya sendiri
								<li>Video sesuai dengan materi mata pelajaran yang diampu dan layak tayang di tvsekolah.id</li>
								<li>Ada uraian materi yang sesuai dengan mata pelajaran yang diampu dan memiliki referensi yang benar disertai pranala luar yang terpercaya</li>
								<li>Dilengkapi dengan minimal 5 nomor soal latihan pilihan ganda</li>
								<li>Ada tugas essay</li>
								<li>Durasi tatap maya (<i>virtual synchronous</i>) sesuai dengan kebutuhan siswa, maksimum 2 jam tiap pertemuan dengan jumlah peserta maksimum 10 siswa premium. Sedangkan peserta dengan mode asynchronous dengan menu chat maksimum 50 peserta dan mode belajar mandiri (tanpa interaksi dengan guru) tidak dibatasi. </li>
							</ul>
							</p>

						</div>

					</div>

					<div class="spacer-single"></div>



				</div>

				<div id="sidebar" class="col-md-4">

					<div class="widget widget_tags">
						<?php if($this->session->userdata('bimbel')==1 || $sudahtes=="sudah")
							{ ?>
								<h4>ASSESMENT TUTOR BIMBEL AKAN DIVERIFIKASI TERLEBIH DAHULU</h4><br><br>
							<?php }
							else if($this->session->userdata('bimbel')==2)
							{ ?>
						Silakan menyelesaikan Assesment.
						<div class="spacer-single"></div>
						<p>
							<a href="<?php echo base_url();?>assesment" class="btn-main btn-lg">Assesment
							</a>
						</p>
						<?php }
							else if($this->session->userdata('bimbel')>=3)
							{ ?>
								<h4>ANDA SUDAH TERDAFTAR SEBAGAI TUTOR BIMBEL</h4><br><br>
								<h5>Silakan membuat modul Bimbel dengan mengakses menu <b>Fitur Utama -> Kelas Virtual -> Bimbel</b></h5>
							<?php }
							else
								{ ?>
									Pastikan lowongan yang anda lamar sesuai dengan kriteria yang anda inginkan, dan sesuai dengan minat, bakat dan pengalaman anda.
									<div class="spacer-single"></div>
									<p>
										<a href="<?php echo base_url();?>login/register/umum_tutor" class="btn-main btn-lg">Daftar Sekarang
										</a>
									</p>
								<?php }
							?>

					</div>

				</div>
			</div>
		</div>
	</section>
</div>
<!-- content close -->
