<style>
	.btn-blue {
		box-shadow: 3px 4px 0px 0px #1564ad;
		background: linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
		background-color: #79bbff;
		border-radius: 5px;
		border: 1px solid #337bc4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 16px;
		font-weight: bold;
		padding: 12px 44px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #528ecc;
	}

	.btn-blue:hover {
		background: linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
		background-color: #378de5;
	}

	.btn-blue:active {
		position: relative;
		top: 1px;
	}

	.btn-grey {
		box-shadow: 3px 4px 0px 0px #839089;
		background: linear-gradient(to bottom, #839089 5%, #87948D 100%);
		background-color: #ADAAAC;
		border-radius: 5px;
		border: 1px solid #CCCED4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 16px;
		font-weight: bold;
		padding: 12px 44px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #000000;
	}

	#wb_LayoutGrid1 {
		clear: both;
		position: relative;
		table-layout: fixed;
		display: table;
		text-align: center;
		width: 100%;
		background-color: transparent;
		background-image: none;
		border: 0px solid #CCCCCC;
		box-sizing: border-box;
		margin: 0;
	}

	#LayoutGrid1 {
		box-sizing: border-box;
		padding: 0;
		margin-right: auto;
		margin-left: auto;
		max-width: 800px;
		padding-bottom: 20px;
	}

	#LayoutGrid1 > .row {
		margin-right: 0;
		margin-left: 0;
	}

	#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3 {
		box-sizing: border-box;
		font-size: 0px;
		min-height: 1px;
		padding-right: 0px;
		padding-left: 0px;
		position: relative;
	}

	#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3 {
		float: left;
	}

	#LayoutGrid1 > .row > .col-1 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 33.33333333%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-2 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 33.33333333%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-3 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 33.33333333%;
		text-align: center;
	}

	#LayoutGrid1:before,
	#LayoutGrid1:after,
	#LayoutGrid1 .row:before,
	#LayoutGrid1 .row:after {
		display: table;
		content: " ";
	}

	#LayoutGrid1:after,
	#LayoutGrid1 .row:after {
		clear: both;
	}

	@media (max-width: 480px) {
		#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3 {
			float: none;
			width: 100% !important;
		}
	}

	.wb_Image1 {
		margin-bottom: 10px;
		vertical-align: top;
	}

	.Image1 {
		border: 0px solid #000000;
		padding: 0;
		display: inline-block;
		width: 220px;
		height: auto;
		vertical-align: top;
	}

	.modalpaket {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		padding-top: 100px; /* Location of the box */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0, 0, 0); /* Fallback color */
		background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modalpaket-content {
		position: relative;
		background-color: #fefefe;
		margin: auto;
		padding: 2px;
		border: 1px solid #888;
		width: 80%;
		max-width: 600px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		-webkit-animation-name: animatetop;
		-webkit-animation-duration: 0.4s;
		animation-name: animatetop;
		animation-duration: 0.4s
	}

	/* Add Animation */
	@-webkit-keyframes animatetop {
		from {
			top: -300px;
			opacity: 0
		}
		to {
			top: 0;
			opacity: 1
		}
	}

	@keyframes animatetop {
		from {
			top: -300px;
			opacity: 0
		}
		to {
			top: 0;
			opacity: 1
		}
	}

	/* The Close Button */
	.modalpaketclose {
		color: #898a84;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.modalpaketclose:hover,
	.modalpaketclose:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}

	.modalpaket-header {
		background-color: #c9dc91;
		color: white;
	}

	.modalpaket-body {
		padding: 2px 10px;
		color: black;
	}

	.modalpaket-footer {
		padding: 2px 10px;
		background-color: #87948d;
		color: white;
	}

</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw

if ($harga['harga_lite'] == 0)
	$hargalite = "Gratis";
else
	$hargalite = "Rp " . number_format($harga['harga_lite'], 0, ",", ".") . "/bln";

$lite = $hargalite;
$reguler = "Rp " . number_format($harga['harga_pro'], 0, ",", ".") . "/bln";
$premium = "Rp " . number_format($harga['harga_premium'], 0, ",", ".") . "/bln";
$nlite = $harga['njudul_lite'] . " paket";
$nreguler = $harga['njudul_pro'] . " paket";
$npremium = $harga['njudul_premium'] . " paket";

?>

<div id="myModalPaket" class="modalpaket" style="z-index: 999;">

	<!-- Modal content -->
	<div class="modalpaket-content">
		<div class="modalpaket-header" style="margin-top:-10px;padding-top:-20px;padding-bottom: 0px;">
			<span class="close" style="margin-right:5px;color: black; font-weight: bold;">&times;</span>
			<center><h3><span style="color: black">PAKET LITE SUDAH AKTIF</span></h3></center>
		</div>
		<div class="modalpaket-body" style="font-size: 16px;margin-top0px;padding-top: 10px;">
			<center>SELAMAT, PAKET LITE ANDA SUDAH AKTIF</b><br></center>
		</div>
		<div class="modalpaket-footer">
		</div>
	</div>

</div>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_paket">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<!-- content begin -->
<div class="no-bottom no-top" id="content" style="margin: auto;">
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

				<div style="background-color:#aabfb8;margin-top: 65px;padding-top:10px;padding-bottom:10px;">
					<center>
						<div style="font-size: 20px;font-weight: bold;color: black;">PILIH PAKET BIMBEL</div>
					</center>
				</div>

				<center>
					<center>
						<div id="wb_LayoutGrid1">
							<div id="LayoutGrid1">
								<div class="row">
									<?php if ($this->session->userdata('loggedIn')) { ?>
										<div class="col-1">
											<div style="font-weight:bold;font-size:16px;color:black;
					position: absolute;left:50%;bottom:22px;">
												<div style="position: relative; left: -50%;"><?php echo $lite; ?></div>
											</div>
											<div class="wb_Image1"
												 style="display:inline-block;width:220px;height:310px;z-index:0;">
												<?php if ($tstrata == "")
												{ ?><a href=""> <?php } ?>
													<img id="lite"
														 src="<?php echo base_url() . 'assets/images/tb_pil_paket1_ok.png'; ?>"
														 class="Image1" alt="">
													<?php if ($tstrata == "") { ?> </a> <?php } ?>
											</div>
											<div style="font-weight:bold;font-size:16px;color:black;
					position: absolute;left:50%;bottom:58px;">
												<div style="position: relative; left: -50%;"><?php echo $nlite; ?></div>
											</div>
										</div>
										<div class="col-2">
											<div style="font-weight:bold;font-size:16px;color:black;
					position: absolute;left:50%;bottom:22px;">
												<div
													style="position: relative; left: -50%;"><?php echo $reguler; ?></div>
											</div>
											<div class="wb_Image1"
												 style="display:inline-block;width:220px;height:310px;z-index:1;">
												<?php if ($tstrata == "" || $tstrata == "lite")
												{ ?><a href=""> <?php } ?>
													<img id="pro"
														 src="<?php echo base_url() . 'assets/images/tb_pil_paket2_ok.png'; ?>"
														 class="Image1" alt="">
													<?php if ($tstrata == "" || $tstrata == "lite")
													{ ?> </a> <?php } ?>
											</div>
											<div style="font-weight:bold;font-size:16px;color:black;
					position: absolute;left:50%;bottom:58px;">
												<div
													style="position: relative; left: -50%;"><?php echo $nreguler; ?></div>
											</div>
										</div>
										<div class="col-3">
											<div style="font-weight:bold;font-size:16px;color:black;
					position: absolute;left:50%;bottom:22px;">
												<div
													style="position: relative; left: -50%;"><?php echo $premium; ?></div>
											</div>
											<div class="wb_Image1"
												 style="display:inline-block;width:220px;height:310px;z-index:2;">
												<a href="">
													<img id="premium"
														 src="<?php echo base_url() . 'assets/images/tb_pil_paket3_ok.png'; ?>"
														 class="Image1" alt="">
												</a>
											</div>
											<div style="font-weight:bold;font-size:16px;color:black;
					position: absolute;left:50%;bottom:58px;">
												<div
													style="position: relative; left: -50%;"><?php echo $npremium; ?></div>
											</div>
										</div>
									<?php } else { ?>
										<div style="margin-bottom: 20px;">
											<span style="font-weight: bold;color:darkmagenta;font-size: 16px;">Untuk dapat mengakses menu ini, silakan LOGIN terlebih dahulu</span>
										</div>

										<div class="col-1">
											<div class="wb_Image1"
												 style="display:inline-block;width:220px;height:350px;z-index:0;">
												<img src="<?php echo base_url() . 'assets/images/tb_pil_paket1.png'; ?>"
													 class="Image1" alt="">
											</div>
										</div>
										<div class="col-2">
											<div class="wb_Image1"
												 style="display:inline-block;width:220px;height:350px;z-index:1;">
												<img src="<?php echo base_url() . 'assets/images/tb_pil_paket2.png'; ?>"
													 class="Image1" alt="">
											</div>
										</div>
										<div class="col-3">
											<div class="wb_Image1"
												 style="display:inline-block;width:220px;height:350px;z-index:2;">
												<img src="<?php echo base_url() . 'assets/images/tb_pil_paket3.png'; ?>"
													 class="Image1" alt="">
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</center>
				</center>
				<center>
					<div style="margin-top: 0px;margin-bottom: 20px">
						<button class="myButtonDonasi" style="padding: 5px 10px 5px 10px;" onclick="kembaliya()">Kembali
						</button>
					</div>
				</center>

			</div>
		</div>
	</section>
</div>


<script>
	var harga = {
		lite: <?php echo $harga['harga_lite'];?>,
		pro: <?php echo $harga['harga_pro'];?>,
		premium: <?php echo $harga['harga_premium'];?>};

	var strata = "<?php echo $tstrata;?>";

	$(document).ready(function () {
		$('img.Image1').click(function (event) {

			event.preventDefault();
			$(this).attr("disabled", "disabled");

			if (harga[this.id] == 0 && strata == "") {
				$.ajax({
					url: '<?php echo base_url();?>payment/finish_paket0/bimbel/' + this.id,
					cache: false,
					success: function (data) {
						if (data == "sukses") {
							infopaket();
							setTimeout(() => {
								if (localStorage.getItem('linkakhirbeli'))
									window.open('<?php echo base_url() . "bimbel/get_bimbel/";?>' + localStorage.getItem('linkakhirbeli'), '_self');
								else
									window.open('<?php echo base_url() . "bimbel/";?>', '_self');
							}, 4000);

						}
					}
				});
			} else {
				if ((this.id == "lite" && strata != "lite") || (this.id == "pro" && strata != "pro") || (this.id == "premium" && strata != "premium")) {

					$.ajax({
						url: '<?php echo base_url();?>payment/token_paket/bimbel/' + this.id,
						cache: false,

						success: function (data) {
							// location = data;
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
						}
					});
				}
			}

		});
	});


	function kembaliya() {
		window.open("<?php echo base_url();?>bimbel/page/1", "_self");
	}

	function startTimer() {

	}

	var modalpaket = document.getElementById("myModalPaket");
	var spanpaket = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal
	infopaket = function () {
		modalpaket.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	spanpaket.onclick = function () {
		modalpaket.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function (event) {
		if (event.target == modalpaket) {
			modalpaket.style.display = "none";
		}
	}

</script>
