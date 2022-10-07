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
		height: 266px;
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
			<div style="font-size: 23px;font-weight: bold;color: black;">PELUANG KARIR</div>
		</center>
	</div>
	<center>
		<div id="wb_LayoutGrid1">
			<div id="LayoutGrid1">
				<div class="row" style="margin-bottom: 10px;">
					<span style="font-weight: bold; color: black; font-size: 20px;">
						TUTOR BIMBEL ONLINE
					</span><br><br>
					<span style="font-weight: bold; color: black; font-size: 18px;">
					Apakah Anda ingin menggunakan akun TVSekolah yang sudah terdaftar?
					</span>
				</div>
				<div id="tinputemail" style="display: none;margin:auto;max-width: 300px;">
					<?php
					$attributes = array('id' => 'myform1');
					echo form_open('login/login/', $attributes);
					?>
					<div class="form-group">
						<div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user text-secondary"
															   style="border-radius: 0; margin: auto; background: #ced4da"></i></span>
							<input type="text" class="form-control" name="username" placeholder="Username">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock text-muted"
															   style="border-radius: 0; margin: auto; background: #ced4da"></i></span>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
					</div>
					<input type="hidden" name="deal" class="form-control" value="deal1">
					<div class="row">
						<button type="submit" class="btn btn-primary login-btn btn-block">Sign in</button>
						<button onclick="return batalinputemail();" class="btn btn-primary login-btn btn-block">Batal</button>
					</div>
					<?php
					echo form_close() . '';
					?>
				</div>
				<div id="dtombol">
				<button onclick="return tampilkaninputemail();" class="btn-blue">YA</button>
					<button onclick="return daftarjaditutor();" class="btn-blue">TIDAK</button>
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

<script>
	function tampilkaninputemail() {
		<?php if(!$this->session->userdata("loggedIn")) {?>
			$('#dtombol').hide();
			$('#tinputemail').show();
		<?php }
		else
			{?>
			window.open("<?php echo base_url().'login/ikutinbimbel';?>","_self");
				<?php } ?>
		return false;
	}
	function batalinputemail() {
		$('#dtombol').show();
		$('#tinputemail').hide();
		return false;
	}
	function daftarjaditutor() {
		window.open("<?php echo base_url().'login/register/umum_tutor';?>","_self");
	}
</script>
