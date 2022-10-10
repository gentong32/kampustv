<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>
	<section id="section-hero" class="no-bottom" aria-label="section">
		<div class="d-carousel">
			<div id="item-carousel-big-type-2" class="owl-carousel wow fadeIn">

				<?php foreach ($datapromo as $data) {
					$gambar1 = $data->gambar;
					$gambar2 = $data->gambar2;
					$link = $data->link;
					if (trim($link) != "") { ?>
						<a href="<?php echo base_url() . 'event/pilihan/' . $link;?>">
					<?php } ?>

					<div class="video_pic_wrap">
						<picture>
							<source media="(min-width: 650px)" srcset="uploads/promo/<?php echo $gambar1;?>">
							<img src="uploads/promo/<?php echo $gambar2;?>" class="lazy img-fluid" alt="">
						</picture>
					</div>

					<?php if ($link != "") { ?>
						</a>
					<?php }
				}
				?>

			</div>
			<div class="d-arrow-left"><i class="fa fa-angle-left"></i></div>
			<div class="d-arrow-right"><i class="fa fa-angle-right"></i></div>
		</div>
	</section>


	<section id="section-collections" class="pt30">
		<div class="container">

			<div class="spacer-single"></div>

			<div class="row wow fadeIn">
				<div class="col-lg-12">
					<div class="text-center wow fadeInLeft">
						<h2>Fitur Utama</h2>
						<div class="small-border bg-color-2"></div>
					</div>
				</div>

				<!-- video item begin -->
				<div class="d-item col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="video__item style-2">

						<div class="video__item_wrap">
							<a href="<?php echo base_url();?>informasi/panggung_sekolah">
								<img src="<?php echo base_url();?>images/fitur/panggung-sekolah.jpg" class="lazy video__item_preview" alt="">
							</a>
						</div>
						<div class="video__item_info">
							<a href="<?php echo base_url();?>informasi/panggung_sekolah">
								<h4 align="center">Panggung Sekolah</h4>
							</a>
							<p align="center">Merupakan kanal tv streaming yang dapat dikembangkan sendiri
								program-programnya oleh masing-masing sekolah...</p>
							<p align="center">
								<a class="btn-main" href="<?php echo base_url();?>informasi/panggung_sekolah">Selengkapnya</a>
							</p>
						</div>
					</div>
				</div>
				<!-- video item begin -->
				<div class="d-item col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="video__item style-2">

						<div class="video__item_wrap">
							<a href="<?php echo base_url();?>informasi/perpustakaan_digital">
								<img src="<?php echo base_url();?>images/fitur/perpustakaan-digital.jpg" class="lazy video__item_preview"
									 alt="">
							</a>
						</div>
						<div class="video__item_info">
							<a href="<?php echo base_url();?>informasi/perpustakaan_digital">
								<h4 align="center">Perpustakaan Digital</h4>
							</a>
							<p align="center">Perpustakaan Digital merupakan fitur TV Sekolah yang menyajikan
								tayangan-tayangan video edukatif...</p>
							<p align="center">
								<a class="btn-main" href="<?php echo base_url();?>informasi/perpustakaan_digital">Selengkapnya</a>
							</p>
						</div>
					</div>
				</div>
				<!-- video item begin -->
				<div class="d-item col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="video__item style-2">

						<div class="video__item_wrap">

							<a href="<?php echo base_url();?>informasi/kelas_virtual">
								<img src="<?php echo base_url();?>images/fitur/kelas-virtual.jpg" class="lazy video__item_preview" alt="">
							</a>
						</div>
						<div class="video__item_info">
							<a href="<?php echo base_url();?>informasi/kelas_virtual">
								<h4 align="center">Kelas Virtual</h4>
							</a>
							<p align="center">Kelas Virtual ini adalah kelas yang akan menjadi kelas unggulan TV Sekolah
								yang berisi program ...</p>
							<p align="center">
								<a class="btn-main" href="<?php echo base_url();?>informasi/kelas_virtual">Selengkapnya</a>
							</p>
						</div>
					</div>
				</div>
				<!-- video item begin -->
				<div class="d-item col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="video__item style-2">

						<div class="video__item_wrap">

							<a href="<?php echo base_url();?>informasi/ekstrakurikuler">
								<img src="<?php echo base_url();?>images/fitur/festival-tv-sekolah.jpg" class="lazy video__item_preview" alt="">
							</a>
						</div>
						<div class="video__item_info">
							<a href="<?php echo base_url();?>informasi/ekstrakurikuler">
								<h4 align="center">Ekskul MD</h4>
							</a>
							<p align="center">Fitur ini berisi kegiatan ekstrakurikuler yang dapat diikuti oleh siswa ...</p>
							<p align="center">
								<a class="btn-main" href="<?php echo base_url();?>informasi/ekstrakurikuler">Selengkapnya</a>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="spacer-single"></div>

			<?php if ($videoterbaru == "on") { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="text-center wow fadeInLeft">
							<h2>Video Terbaru</h2>
							<div class="small-border bg-color-2"></div>
						</div>
					</div>
					<div id="collection-carousel-7" class="owl-carousel wow fadeIn">

						<!-- video Kategori Lain 1 -->
						<div>
							<div class="video__item">
								<div>
									<a href="item-details.html">
										<img src="images/video_terbaru/lain-1.jpg" class="lazy video__item_preview"
											 alt="">
									</a>
								</div>

								<div class="spacer-single"></div>

								<div class="video__item_info">
									<a href="item-details.html">
										<h4>Hari Sumpah Pemuda</h4>
									</a>

									<div class="video__item_action">
										<a href="#">Lihat sekarang</a>
									</div>
									<div class="video__item_like">
										<i class="fa fa-heart"></i><span>50</span>
									</div>
								</div>
							</div>
						</div>

						<!-- video Kategori Lain 2  -->
						<div>
							<div class="video__item">
								<div>
									<a href="item-details.html">
										<img src="images/video_terbaru/lain-2.jpg" class="lazy video__item_preview"
											 alt="">
									</a>
								</div>
								<div class="spacer-single"></div>
								<div class="video__item_info">
									<a href="item-details.html">
										<h4>Dolphin</h4>
									</a>
									<div class="video__item_action">
										<a href="#">Lihat sekarang</a>
									</div>
									<div class="video__item_like">
										<i class="fa fa-heart"></i><span>80</span>
									</div>
								</div>
							</div>
						</div>

						<!-- video Kategori Lain 3  -->
						<div>
							<div class="video__item">
								<div>
									<a href="item-details.html">
										<img src="images/video_terbaru/lain-3.jpg" class="lazy video__item_preview"
											 alt="">
									</a>
								</div>
								<div class="spacer-single"></div>
								<div class="video__item_info">
									<a href="item-details.html">
										<h4>Lost In Time Prehistoric</h4>
									</a>
									<div class="video__item_action">
										<a href="#">Lihat sekarang</a>
									</div>
									<div class="video__item_like">
										<i class="fa fa-heart"></i><span>97</span>
									</div>
								</div>
							</div>
						</div>

						<!-- video Kategori Lain 4 -->
						<div>
							<div class="video__item">
								<div>
									<a href="item-details.html">
										<img src="images/video_terbaru/lain-4.jpg" class="lazy video__item_preview"
											 alt="">
									</a>
								</div>
								<div class="spacer-single"></div>
								<div class="video__item_info">
									<a href="item-details.html">
										<h4>Monkey &amp; Snake</h4>
									</a>
									<div class="video__item_action">
										<a href="#">Lihat sekarang</a>
									</div>
									<div class="video__item_like">
										<i class="fa fa-heart"></i><span>73</span>
									</div>
								</div>
							</div>
						</div>

						<!-- video Kategori Lain 5 -->
						<div>
							<div class="video__item">
								<div>
									<a href="item-details.html">
										<img src="images/video_terbaru/lain-5.jpg" class="lazy video__item_preview"
											 alt="">
									</a>
								</div>
								<div class="spacer-single"></div>
								<div class="video__item_info">
									<a href="item-details.html">
										<h4>Robot Attack</h4>
									</a>
									<div class="video__item_action">
										<a href="#">Lihat sekarang</a>
									</div>
									<div class="video__item_like">
										<i class="fa fa-heart"></i><span>73</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="spacer-single"></div>

			<?php } ?>

			<div class="row">
				<div class="col-lg-12">
					<div class="text-center wow fadeInLeft">
						<h2>Berita</h2>
						<div class="small-border bg-color-2"></div>
					</div>
				</div>
				<!-- mulai -->
				<div class="container">
					<div class="row">

						<?php
						foreach ($databerita as $data) {
							$thumbnail = $data->thumbnail;
							$deskripsi = $data->deskripsi;
							$tanggal = $data->modified;
							$kodeberita = $data->kode_berita;
							$tgllengkap = namabulan_panjang($tanggal);
							$judul = $data->judul;
							?>
							<div class="col-lg-4 col-md-6 mb30">
								<div class="bloglist item">
									<div class="post-content">
										<a href="<?php echo base_url().'home/berita/'.$kodeberita;?>">
										<div class="post-image">
											<img alt="" src="<?php echo $thumbnail;?>" class="lazy">
										</div>
										</a>
										<div class="post-text">
											<span class="p-tagline">Info</span>
											<span class="p-date"><?php echo $tgllengkap;?></span>
											<h4><a href="<?php echo base_url().'home/berita/'.$kodeberita;?>"><?php echo $judul;?><span></span></a></h4>
											<p><?php echo $deskripsi;?></p>
											<a class="btn-main" href="<?php echo base_url().'home/berita/'.$kodeberita;?>">Selengkapnya</a>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>

					</div>
				</div>
				<!-- selesai -->
			</div>
		</div>
	</section>

</div>
<!-- content close -->
