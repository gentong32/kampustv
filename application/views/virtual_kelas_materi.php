<link href="<?php echo base_url(); ?>css/soal.css" rel="stylesheet">

<?php


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
						<h1>Kelas Virtual</h1>
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
				<div id="tempatsoal"
					 style="opacity:80%;padding-top:20px;padding-bottom:20px;color: black;">
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1">
									<center>
										<div style="font-size: 14px;">
											Uraian Materi<br>
											<span style="font-size: 18px;"><?php echo $judul; ?></span>
										</div>
										<hr>
									</center>
								</div>
							</div>
						</div>
					</div>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1">
									<?php echo $uraian; ?>
								</div>
							</div>
							<div style="margin-top: 20px;">
								<?php if ($file != "") { ?>
									<button style="width:180px;padding:10px 20px;margin-bottom:5px;" class="btn-primary"
											onclick="window.open('<?php echo base_url() . "channel/download/materi/" . $linklist; ?>','_self')">
										Unduh Lampiran
									</button>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1" style="text-align:center;margin-bottom: 15px;">
									<button onclick="kembali()" id="tbselesai">Kembali</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
	function kembali() {
		window.history.back();
	}

</script>
