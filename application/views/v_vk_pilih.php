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
		width: 200px;
		height: 153px;
		vertical-align: top;
	}
</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$lite = $harga->harga_lite;
//$reguler = $harga->harga_reguler;
//$premium = $harga->harga_premium;
?>

<div class="container bgimg3" style="padding-bottom: 20px;width: 100%">

	<div style="background-color:#aabfb8;margin-top: 65px;margin-bottom:20px;padding:10px;">
		<center>
			<div style="font-size: 23px;font-weight: bold;color: black;">KELAS VIRTUAL</div>
		</center>
	</div>
	<center>
		<div id="wb_LayoutGrid1">
			<div id="LayoutGrid1">
				<div class="row">
					<?php if ($this->session->userdata('loggedIn')) { ?>
						<div class="col-1">
							<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:0;">
								<a href="<?php echo base_url() . 'vksekolah/'; ?>"><img
										src="<?php echo base_url() . 'assets/images/tb_vk1.png'; ?>" class="Image1"
										alt=""></a>
							</div>
						</div>
						<div class="col-3">
							<div class="wb_Image1"
								 style="font-size:15px;font-weight:bold;display:inline-block;width:200px;height:160px;z-index:1;">
								<a href="<?php echo base_url() . 'vksekolah/set/lain'; ?>"><img
										src="<?php echo base_url() . 'assets/images/tb_vk2.png'; ?>" class="Image1"
										alt=""></a>
							</div>
						</div>
						<div class="col-2">
							<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:2;">
								<a href="<?php echo base_url() . 'bimbel/'; ?>"><img
										src="<?php echo base_url() . 'assets/images/tb_vk3.png'; ?>" class="Image1"
										alt=""></a>
							</div>
						</div>
					<?php } else { ?>
						<div style="margin-bottom: 20px;">
							<span style="font-weight: bold;color:darkmagenta;font-size: 16px;">Untuk dapat mengakses menu ini, silakan LOGIN terlebih dahulu</span>
						</div>

						<div class="col-1">
							<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:0;">
								<img src="<?php echo base_url() . 'assets/images/tb_vk1.png'; ?>" class="Image1" alt="">
							</div>
						</div>
						<div class="col-3">
							<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:1;">
								<img src="<?php echo base_url() . 'assets/images/tb_vk2.png'; ?>" class="Image1" alt="">
							</div>
						</div>
						<div class="col-2">
							<div class="wb_Image1" style="display:inline-block;width:200px;height:160px;z-index:2;">
								<img src="<?php echo base_url() . 'assets/images/tb_vk3.png'; ?>" class="Image1" alt="">
							</div>
						</div>

					<?php } ?>
				</div>
			</div>
		</div>
	</center>


</div>


<div id="myModal1" class="modal2">
	<!-- Modal content -->
	<div class="modal2-content">

		<p style="text-align:center;font-size: medium">USER NAME dan PASSWORD yang Anda masukkan salah.<br>
			Silakan gunakan username dan password yang valid.<br><br>
			<button id="silang">Tutup</button>
		</p>
	</div>
</div>

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<?php if (!$this->session->userdata("loggedIn")) { ?>
	<script>
		localStorage.setItem("linkpralogin", window.location.href);
	</script>
<?php } ?>
