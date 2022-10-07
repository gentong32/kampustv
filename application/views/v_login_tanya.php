<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<form id="login-form" method="post" action="<?php echo base_url(); ?>login/login">
	<input type="hidden" name="username" id="username" value=""></div>
	<input type="hidden" name="password" id="password" value=""></div>
	<input type="hidden" name="remember" id="remember" value="1"></div>
</form>

<div class="container" style="color:black;margin-top: 0px;margin-bottom:-10px;width: 100%;left: 0px;right: 0px">

	<div class="jumbotronbg text-center"
		 style="left:0px;right:0px;margin-left:-20px;margin-right:-20px;margin-top:35px; margin-bottom:0px;background-image: url(<?php echo base_url(); ?>assets/images/pattern01.png)">

		<p style="padding-top:10px;font-weight:bold;font-size: 18px;">Sebelum mengikuti EVENT silakan <br>masuk ke
			TVSekolah dahulu</p>

		<div class="container" style="max-width:400px;margin-top:10px;padding:10px;border: #0f74a8 dotted 1px">
			<!--					<div class="or-seperator"><i>atau</i></div>-->
			<p style="font-weight: bold;font-size: 18px;">Login melalui:</p>

			<div class="text-center social-btn">
				<a href="#" onclick="bukaemail();" class="btn btn-info">
					<i class="fa fa-envelope"
					   style="font-size: medium; background:none; width:20px; padding: 0;"></i>&nbsp;
					Email</a>
				<a href="<?php echo $authURL; ?>" class="btn btn-primary"><i class="fa fa-facebook"
																			 style="font-size: medium; background:none; width:20px; padding: 0; "></i>&nbsp;
					Facebook</a>
				<!---<a href="#" class="btn btn-info"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>--->
				<a href="<?php echo $loginURL; ?>" class="btn btn-danger"><i class="fa fa-google"
																			 style="font-size: medium; background:none; width:20px; padding: 0;"></i>&nbsp;
					GMail</a>
			</div>
		</div>

		<div id="dlogemail" class="container"
			 style="display:none;max-width:400px;margin-top:10px;padding:10px;border: #0f74a8 dotted 1px">
			<!--			--><?php //echo "Code:".$this->session->userdata('linkakhir');?>
			<p style="font-weight: bold;font-size: 18px;">Login melalui Email</p>

			<div class="login-form" style="margin: auto;">
				<div class="form-group">
					<div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user text-secondary"
															   style="border-radius: 0; margin: auto; background: #ced4da"></i></span>
						<input type="text" class="form-control" id="iusername" name="iusername" placeholder="Username"
							   required="required">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock text-muted"
															   style="border-radius: 0; margin: auto; background: #ced4da"></i></span>
						<input type="password" id="ipassword" name="ipassword" class="form-control"
							   placeholder="Password" required>
					</div>
				</div>
				<div id="dresult" style="display: none">
				</div>
				<div class="form-group">
					<button style="margin:auto;width: 100px;font-weight: bold;color: black"
							onclick="return ceklogin()" class="btn btn-info login-btn btn-block">OK
					</button>
				</div>

				<span class="clearfix"></span>
			</div>
		</div>

		<div class="container" style="max-width:400px;margin-top:10px;padding:10px;border: #0f74a8 dotted 1px">
			<p style="font-weight: bold;font-size: 20px">Belum punya Akun TVSekolah?</p>
			<button style="margin:auto;width: 140px;font-weight: bold;color: black"
			class="btn btn-info login-btn btn-block"
			onclick="window.open('<?php echo base_url(); ?>login/daftar','_self')">DAFTAR DI SINI
			</button>
		</div>

	</div>

</div>

<script>
	$(document).on('change', '#iusername', function () {
		var email = $('#iusername').val();
		var domain = email.substring(email.lastIndexOf("@") + 1);
		if (domain == "google.com") {
			document.getElementById('dresult').style.display = "block";
			$('#dresult').html("Silakan menggunakan tombol login Google");
			return false;
		} else {
			$('#dresult').html("");
			document.getElementById('dresult').style.display = "none";
		}

	});

	function ceklogin() {
		if ($('#dresult').html() != "") {
			return false;
		} else {
			$('#username').val($('#iusername').val());
			$('#password').val($('#ipassword').val());
			$("#login-form").submit();
		}
	}

	function bukaemail() {
		if (document.getElementById('dlogemail').style.display == "none")
			document.getElementById('dlogemail').style.display = "block";
		else
			document.getElementById('dlogemail').style.display = "none";

	}
</script>
