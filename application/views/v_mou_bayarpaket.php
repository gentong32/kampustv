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

	#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3, #LayoutGrid1 > .row > .col-4 {
		box-sizing: border-box;
		font-size: 0px;
		min-height: 1px;
		padding-right: 0px;
		padding-left: 0px;
		position: relative;
	}

	#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3,#LayoutGrid1 > .row > .col-4 {
		float: left;
	}



	#LayoutGrid1 > .row > .col-1 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 25%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-2 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 25%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-3 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 25%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-4 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 25%;
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

	@media (max-width: 750px) {
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

</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');


?>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_mou">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<div class="container bgimg3" style="margin-top: 0px;width: 100%">

	<div style="background-color:#aabfb8;margin-top: 65px;padding-top:10px;padding-bottom:10px;">
		<center>
			<div style="font-size: 20px;font-weight: bold;color: black;">PILIH PAKET MOU</div>
		</center>
	</div>

	<center>
		<center>
			<div id="wb_LayoutGrid1">
				<div id="LayoutGrid1">
					<div class="row">
						<?php if ($this->session->userdata('loggedIn')) { ?>
							<div class="col-1">
								<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:0;">

									<a href="">
										<img style="width: 180px;" id="mou1"
													src="<?php echo base_url() . 'assets/images/tb_pil_mou1.png'; ?>"
													class="Image1" alt="">
									</a>
								</div>
							</div>
							<div class="col-2">
								<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:1;">
									<a href="">
										<img style="width: 180px;" id="mou2"
													src="<?php echo base_url() . 'assets/images/tb_pil_mou2.png'; ?>"
													class="Image1" alt="">
										 </a>
								</div>
							</div>
							<div class="col-3">
								<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:2;">
									<a href="">
										<img style="width: 180px;" id="mou3"
													src="<?php echo base_url() . 'assets/images/tb_pil_mou3.png'; ?>"
													class="Image1" alt="">
									</a>
								</div>
							</div>

							<div class="col-3">

								<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:2;">
									<a href="">
										<img style="width: 180px;" id="mou4"
											 src="<?php echo base_url() . 'assets/images/tb_pil_mou4.png'; ?>"
											 class="Image1" alt="">
									</a>
								</div>

							</div>

						<?php }  ?>

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

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<script>
	var harga = {
		mou1: 1800000,
		mou2: 3600000,
		mou3: 3000000,
		mou4: 6000000,
	}

	$(document).ready(function () {
		$('img.Image1').click(function (event) {

			event.preventDefault();
			$(this).attr("disabled", "disabled");

			var namaid = this.id.substring(3, 4);

			$.ajax({
				url: '<?php echo base_url();?>payment/token_mou/' + namaid,
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
