<!-- dashboard inner -->
<div class="midde_cont">
	<div class="container-fluid">
		<div class="row column_title">
			<div class="col-md-12">
				<div class="page_title">
					<h2>Profil Saya</h2>
				</div>
			</div>
		</div>
		<!-- row -->
		<div class="row column2 graph margin_bottom_30">
			<div class="col-md-l2 col-lg-12">
				<div class="white_shd full margin_bottom_30">
					<div class="full graph_head">
						<div class="heading1 margin_0">
							<h2>Informasi</h2>
						</div>
					</div>
					<div class="full price_table padding_infor_info">
						<div class="row">
							<!-- user profile section -->
							<!-- profile image -->
							<div class="col-lg-12" style="font-size: 18px;">
							<?php if($verifikator_aktif==2 && $this->session->userdata('kontributor')==2)
										{ ?>
								Status Anda masih sebagai Calon Guru, sehingga belum dapat mengunggah Video!<br>
								Hubungi Verifikator berikut:<br>
								<i class="fa fa-user"></i> <?php echo $namaverifikator;?><br>
								<i class="fa fa-envelope"></i> <?php echo $emailverifikator;?><br>
								<i class="fa fa-phone"></i> <?php echo $telpverifikator;?><br>
										<?php } else if($verifikator_aktif==3)
										{ ?>
								Status Anda masih sebagai Calon Guru, sehingga belum dapat mengunggah Video!<br>
								Verifikator akan memverifikasi segera.<br>
										<?php } ?>

								<!-- end user profile section -->
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>
			<!-- end row -->
		</div>
		<!-- footer -->
		<div class="container-fluid">
			<div class="footer">
				<p>© Copyright 2021 - TV Kampus. All rights reserved.</p>
			</div>
		</div>
	</div>
	<!-- end dashboard inner -->
</div>

<script>
	function jadiver()
	{
		$.ajax({
			url: "<?php echo base_url();?>profil/upgradever",
			method: "GET",
			data: {},
			success: function (result) {
				if (result == "ada")
					alert("VERIFIKATOR SUDAH ADA");
				else {
					window.location.reload();
				}

			}
		});
	}
</script>
