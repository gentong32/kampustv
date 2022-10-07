<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
	form i {
		position: absolute;
		margin-top: -55px;
		margin-left: 66%;
		cursor: pointer;
	}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>
<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>

	<section class="full-height relative no-top no-bottom vertical-center"
			 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top"
			 data-stellar-background-ratio=".5">
		<div class="overlay-gradient t50">
			<div class="center-y relative">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-5 text-light wow fadeInRight" data-wow-delay=".5s">
							<div class="spacer-10"></div>
							<h1>Hadirkan Kelas dalam Channel Sekolah</h1>
							<p class="lead">Siaran TV Streaming Channel Sekolah dapat dikelola oleh setiap sekolah tanpa
								menggunakan perangkat fisik tambahan apapun.</p>
						</div>

						<div class="col-lg-4 offset-lg-2 wow fadeIn" data-wow-delay=".5s">
							<div class="box-rounded padding40" data-bgcolor="#ffffff">
								<h3 class="mb10">Sign In</h3>
								<p>Login jika sudah memiliki akun atau buat akun <a
										href="<?php echo base_url() . 'login/daftar'; ?>">di sini<span></span></a>.</p>
								<form class="form-border" method="post" action="<?php echo base_url(); ?>login/login">

									<div class="field-set" style="width: 85%;">
										<input type="text" name="username" id="username" class="form-control"
											   placeholder="username">
									</div>

									<div class="field-set" style="width: 85%;">
										<input type="password" name="password" id="password" class="form-control"
													placeholder="password">
										<i class="bi bi-eye-slash" id="togglePassword"></i>
									</div>

									<div class="field-set">
										<input type="submit" value="Submit" class="btn btn-main btn-fullwidth color-2">
									</div>

									<div class="clearfix"></div>

									<div id="keteranganlogin" class="spacer-single"><span
											style="color: red; font-style: italic"><?php echo $message; ?></span></div>

									<!-- social icons -->
									<ul class="list s3">
										<li>Login melalui:</li>
										<br>
										<li style="margin: 10px 0px;"><a href="<?php echo $authURL; ?>"
																		 class="btn btn-primary"><i
													class="fa fa-facebook"
													style="font-size: medium; background:none; width:20px; padding: 0; "></i>&nbsp;
												Facebook</a></li>
										<li style="margin: 10px 0px;"><a href="<?php echo $loginURL; ?>"
																		 class="btn btn-danger"><i class="fa fa-google"
																								   style="font-size: medium; background:none; width:20px; padding: 0;"></i>&nbsp;
												Google</a></li>
									</ul>
									<!-- social icons close -->
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- content close -->

<script>
	var klirpesan = setInterval(hapuspesan, 5000);

	function hapuspesan() {
		$('#keteranganlogin').html("");
		clearInterval(klirpesan);
	}

	const togglePassword = document.querySelector("#togglePassword");
	const password = document.querySelector("#password");

	togglePassword.addEventListener("click", function () {
		// toggle the type attribute
		const type = password.getAttribute("type") === "password" ? "text" : "password";
		password.setAttribute("type", type);

		// toggle the icon
		this.classList.toggle("bi-eye");
	});

	// prevent form submit
	// const form = document.querySelector("form");
	// form.addEventListener('submit', function (e) {
	// 	e.preventDefault();
	// });

</script>
