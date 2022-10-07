<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- dashboard inner -->
<div class="midde_cont">
	<div class="container-fluid">
		<div class="row column_title">
			<div class="col-md-12">
				<div class="page_title">
					<h2>Verifikasi Video</h2>
				</div>
			</div>
		</div>
		<!-- row -->
		<div class="row column2 graph">
			<div class="col-md-l2 col-lg-12">
				<div class="white_shd full">

					<div class="full price_table padding_infor_info">
						<div class="row">
							<!-- user profile section -->
							<!-- profile image -->
							<div class="row column4 graph">
								<?php if ($jmlverkontributor>=0) { ?>
								<div class="col-md-6 margin_bottom_30" style="min-width: 320px;">
									<div class="dash_blog">
										<div class="dash_blog_inner">
											<div class="dash_head">
												<h3><span style="font-size: 18px;"><i class="fa fa-pencil"></i> Video Kontributor</span>
												</h3>
											</div>
											<div class="list_cont">
												<div class="txtProfil1">Ada <b><?php echo $jmlverkontributor;?></b> dari <?php
													echo $jmlvidkontributor;?> video perlu diverifikasi</div>
												<button class="myButton1" onclick="window.open('<?php echo base_url()."video/kontributor/profil";?>','_self')">Tampilkan</button>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

								<?php if ($jmlverekskul>=0) { ?>
								<div class="col-md-6 margin_bottom_30" style="min-width: 320px;">
									<div class="dash_blog">
										<div class="dash_blog_inner">
											<div class="dash_head">
												<h3><span style="font-size: 18px;"><i class="fa fa-pencil"></i> Video Ekskul</span>
												</h3>
											</div>
											<div class="list_cont">
												<div class="txtProfil1">Ada <b><?php echo $jmlverekskul;?></b> dari <?php
													echo $jmlvidekskul;?> video perlu diverifikasi</div>
												<button class="myButton1" onclick="window.open('<?php echo base_url()."video/ekskul/profil";?>','_self')">Tampilkan</button>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

								<?php if ($jmlverevent>=0) { ?>
								<div class="col-md-6 margin_bottom_30" style="min-width: 320px;">
									<div class="dash_blog">
										<div class="dash_blog_inner">
											<div class="dash_head">
												<h3><span style="font-size: 18px;"><i class="fa fa-pencil"></i> Video Event</span>
												</h3>
											</div>
											<div class="list_cont">
												<div class="txtProfil1">Ada <b><?php echo $jmlverevent;?></b> dari <?php
													echo $jmlvidevent;?> video perlu diverifikasi</div>
												<button class="myButton1" onclick="window.open('<?php echo base_url()."video/event/profil";?>','_self')">Tampilkan</button>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

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
				<p>© Copyright 2021 - TV Sekolah. All rights reserved.</p>
			</div>
		</div>
	</div>
	<!-- end dashboard inner -->
</div>

<script type="text/javascript">
	<?php if ($keteranganbayar=="Tagihan Bulan Ini" || $keteranganbayar=="Masuk Masa Tenggang") { ?>
	var bayardiklik = false;
	function klikbayar(kode) {
		// event.preventDefault();
		if (bayardiklik==false)
		{
			bayardiklik = true;

			setTimeout(() => {
				bayardiklik = false;
			}, 5000);

			$.ajax({
				url: '<?php echo base_url();?>profil/token/'+kode,
				cache: false,

				success: function (data) {
					//location = data;

					// console.log('token = ' + data);

					var resultType = document.getElementById('result-type');
					var resultData = document.getElementById('result-data');

					function changeResult(type, data) {
						$("#result-type").val(type);
						$("#result-data").val(JSON.stringify(data));
						//resultType.innerHTML = type;
						//resultData.innerHTML = JSON.stringify(data);
					}

					snap.pay(data, {

						onSuccess: function (result) {
							changeResult('success', result);
							console.log(result.status_message);
							console.log(result);
							$("#payment-form").submit();
						},
						onPending: function (result) {
							changeResult('pending', result);
							console.log(result.status_message);
							$("#payment-form").submit();
						},
						onError: function (result) {
							changeResult('error', result);
							console.log(result.status_message);
							$("#payment-form").submit();
						}
					});
					return false;
				},
				error: function (data) {
					return false;
				}
			});
		}


		return false;
	};
	<?php } ?>

	<?php if ($keteranganbayar=="Menunggu Pembayaran") { ?>
	function gantibayar() {
		if (confirm("Yakin mengubah cara bayar?")) {
			window.open("<?php echo base_url() . 'profil/ganticarabayar/' . $orderid;?>", "_self");
			return false;
		}
	}
	<?php } ?>

</script>
