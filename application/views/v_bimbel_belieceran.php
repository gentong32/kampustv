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

$hargapremium = "Rp " . number_format($harga['harga_ecerpremium'], 0, ",", ".") . "";
$hargaprivat = "<span style='color:#F3D86D;'>Rp " . number_format($harga['harga_ecerprivat'], 0, ",", ".") . "</span>";

if ($this->session->userdata("loggedIn")) {
?>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_eceran">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<?php } ?>

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


				<div style="background-color:#aabfb8;padding-top:10px;padding-bottom:10px;">
					<center>
						<div style="font-size: 20px;font-weight: bold;color: black;">PILIH MODUL ECERAN</div>
					</center>
				</div>


			<center>


				<div style="display: inline-block; margin-top: 5px;margin-bottom: 15px;">
						<div style="width:220px;height:310px;">
							<a href="<?php
							if (!$this->session->userdata('loggedIn')) {
								echo base_url().'login/shared/ecr/'.$linklist;
							} ?>">
								<img id="premium"
									 src="<?php echo base_url() . 'assets/images/tb_pil_ecer3.png'; ?>"
									 class="Image1" alt="">
							</a>
						</div>
						<div style="margin-top:-75px;">per modul</div>
						<div><?php echo $hargapremium; ?></div>

				</div>

				<div style="display: inline-block; margin-top: 5px;margin-bottom: 15px;">
					<div style="width:220px;height:310px;">
						<a href="">
							<img id="privat"
								 src="<?php echo base_url() . 'assets/images/tb_pil_ecer4.png'; ?>"
								 class="Image1" alt="">
						</a>
					</div>
					<div
						style="color: #F3D86D;margin-top:-75px;">per modul
					</div>
					<div style="color: #F3D86D;">Segera Hadir</div>
				</div>


			</center>


			<center>
				<div style="margin-top: 25px;margin-bottom: 20px">
					<?php if($this->session->userdata("loggedIn"))
					{ ?>
						<span style="color: blue;"><?php if (substr($dibeli,0,5)=="Paket" ||
								substr($dibeli,0,6)=="Eceran") {?>
							Anda sudah membeli modul ini dalam <b><?php echo $dibeli;?></b>. <br><?php
							if($dibeli!="Paket Premium") { ?>Silakan klik pilihan di atas jika ingin membeli eceran.<br><?php } ?><br>
								<button onclick="window.open('<?php echo base_url();?>bimbel/get_bimbel/<?php
								echo $linklist;?>','_self');" class="btn-main">Buka Modul</button>
							<?php } else {?>
								Silakan pilih salah satu harga eceran di atas.
							<?php } ?>
						</span><br>
					<?php } else {?>
						<span style="color: blue;">Anda akan diarahkan untuk daftar / login ke TVSekolah terlebih dahulu.</span><br>
						<button class="btn-main" style="padding: 5px 10px 5px 10px;" onclick="kembaliya()">OK
						</button>
					<?php } ?>
				</div>
			</center>

		</div>
</div>
</section>
</div>


<script>
	<?php if($this->session->userdata("loggedIn"))
	{ ?>
	var harga = {
		ecerpremium: <?php echo $harga['harga_ecerpremium'];?>,
		ecerprivat: <?php echo $harga['harga_ecerprivat'];?>};

	$(document).ready(function () {
		$('img.Image1').click(function (event) {

			event.preventDefault();
			$(this).attr("disabled", "disabled");

			setTimeout(() => {
				$(this).attr("disabled", false)
			}, 3000);

			if (this.id == "premium") {
				<?php if($dibeli!="Paket Premium") {;?>
				$.ajax({
					url: '<?php echo base_url();?>payment/token_eceran/bimbel/' + this.id + '/<?php echo $linklist;?>',
					cache: false,

					success: function (data) {
						//location = data;
						//console.log('token = ' + data);

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
				<?php } ?>
			}

		});
	});

	function kembaliya() {
		window.open("<?php echo base_url();?>bimbel/page/1", "_self");
	}
	<?php } else { ?>

	function kembaliya() {
		window.open("<?php echo base_url().'login/shared/ecr/'.$linklist;?>", "_self");
	}

	<?php } ?>


</script>
