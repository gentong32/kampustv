<!--<script>document.getElementsByTagName("html")[0].className += " js";</script>-->
<!--<link rel="stylesheet" href="--><?php //echo base_url(); ?><!--css/tab_style.css">-->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$njenis1 = 'checked="checked"';
$njenis2 = '';
$njenis3 = '';
$nreferrer = '';
$tampil1 = 'style="display: block"';
$tampil2 = 'style="display: none"';

$njudul = '';
$nseri = '';
$ntahun = '';
$level = '';

$hasilemail = "";
$hasilpassword = "";

$xjabatan = $jabatan;
if ($jabatan == "Umum")
	$xjabatan = "Umum";
if ($jabatan == "Guru")
	$xjabatan = "Guru/Dosen";
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>
<style>
	form i {
		position: absolute;
		margin-top: -35px;
		margin-left: 180px;
		cursor: pointer;
	}
</style>

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
						<h1>Pendaftaran</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section" class="pt30">
		<div class="container" style="max-width:600px;padding-bottom: 20px;	">
			<div class="row">
				<?php
				echo form_open('login/tambahuser', array('autocomplete' => 'off', 'id' => 'myform'));
				?>

				<legend><span
						style="font-weight: bold;color: black">Mendaftar Sebagai <?php echo $xjabatan; ?></span>
				</legend>
				<a target="_blank" href="<?php echo base_url().'tentangkami/kebijakan';?>">Lihat Kebijakan Privasi</a>
				<fieldset style="background-color: white;margin-top: 20px">


					<!--                    <input style="color:black;border:0;width: 0px;height: 0px; padding: 0;margin: 0" id="iemails"-->
					<!--                           name="iemails" maxlength="6" value="" placeholder="">-->

					<div class="form-group" style="padding-top: 20px;">
						<label for="" class="col-md-12 control-label">Email<span
								style="color:red">*</span></label>
						<div class="col-md-12">
							<input autocomplete="false" autofill="false" type="text"
								   class="form-control"
								   id="iemail" name="iemail" maxlength="50" value=""
								   placeholder="Alamat Email">
							<label class="text-danger"><span><div id="email_result"></div>
            				</span></label>
						</div>
					</div>
					<div id="tbgoogle" class="col-md-10 col-md-offset-0"
						 style="display:none;margin-left:15px;margin-bottom: 10px;">
						<a href="<?php echo $loginURL; ?>" class="btn btn-danger"><i
								class="fa fa-google"
								style="font-size: medium; background:none; width:20px; padding: 0;"></i>&nbsp;
							Google</a>
					</div>

					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Nama depan<span
								style="color:red">*</span>
							<span style="color: red" id="firstnameHasil"></span></label>
						<div class="col-md-12">
							<input type="text" class="form-control" id="ifirst_name" name="ifirst_name"
								   maxlength="25"
								   placeholder="Nama Depan">
						</div>
					</div>
					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Nama belakang
							<span style="color: red" id="lastnameHasil"></span></label>
						<div class="col-md-12">
							<input type="text" class="form-control" id="ilast_name" name="ilast_name"
								   maxlength="25"
								   placeholder="Nama Belakang">
						</div>
					</div>

					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Password<span
								style="color:red">*</span></label>
						<div class="col-md-12" style="width:200px">
							<input type="password" class="form-control" id="ipassword" name="ipassword"
								   maxlength="16"
								   value="" placeholder="Password">
							<i class="bi bi-eye-slash" id="togglePassword"></i>
						</div>
					</div>

					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Repeat Password<span
								style="color:red">*</span></label>
						<div class="col-md-12" style="width:200px">
							<input type="password" class="form-control" id="ipassword2"
								   name="ipassword2"
								   maxlength="16"
								   value="<?php
								   echo $ntahun; ?>" placeholder="Password">
							<span id="pswHasil"></span><br>
						</div>
					</div>

					<!--						<div class="form-group">-->
					<!--							<label for="inputDefault" class="col-md-12 control-label">Referrer / User Perekomendasi-->
					<!--								(opsional)</label>-->
					<!--							<div class="col-md-12" style="width:200px">-->
					<!--								<input type="text" class="form-control" id="ireferrer" name="ireferrer" maxlength="100"-->
					<!--									   value="--><?php
					//									   echo $nreferrer; ?><!--" placeholder="Referrer">-->
					<!--								<br>-->
					<!--							</div>-->
					<!--						</div>-->


					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label"></label>
						<div class="col-md-12" style="width:200px;padding-bottom: 10px;">
							<?php
							echo $recaptcha_html;
							?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12" style="width:300px;padding-bottom: 20px;">
											<span
												style="font-style:italic;font-size:smaller;color: red">*) wajib diisi</span>
						</div>
					</div>

					<input type="hidden" id="addedit" name="addedit"/>
					<input type="hidden" id="referrer" name="referrer"
						   value="<?php echo $referrer; ?>"/>
					<input type="hidden" id="npsn" name="npsn"
						   value="<?php echo $npsn; ?>"/>
					<input type="hidden" id="jabatan" name="jabatan" value="<?php echo $jabatan; ?>"/>

					<div class="form-group">
						<div class="col-md-10 col-md-offset-0" style="margin-bottom: 10px;">
							<button class="btn btn-default" onclick="return takon()">Batal</button>
							<button type="submit" class="btn btn-primary"
									onclick="return cekregister()">Daftar
							</button>
						</div>
					</div>

				</fieldset>
			</div>
		</div>

		<?php
		echo form_close() . '';
		?>

	</section>
</div>


<script>

	var hasilpassword = "";
	var hasilemail = "";
	var emailvalid = false;

	$(document).on('change', '#iemail', function () {
		var email = $('#iemail').val();
		var $result = $("#email_result");
		var domain = email.substring(email.lastIndexOf("@") + 1);
		$result.text("");

		if (validateEmail(email)) {
			//$result.text(email + " is valid :)");
			//$result.css("color", "green");
			emailvalid = true;
			if (domain == "google.com") {
				$result.text("Silakan daftar lewat tombol Google berikut");
				document.getElementById('tbgoogle').style.display = "block";
				$result.css("color", "red");
				emailvalid = false;
			} else {
				document.getElementById('tbgoogle').style.display = "none";
			}
		} else {
			$result.text("Alamat email '" + email + "' tidak valid");
			$result.css("color", "red");
			emailvalid = false;
		}

		if (email != '' && emailvalid) {
			$.ajax({
				url: "<?php echo base_url(); ?>login/cekemail",
				method: "POST",
				data: {email: email},
				success: function (data) {

					$('#email_result').html(data);
					hasilemail = data;
					//alert (data);
				}
			});
		}

	});

	function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}


	$(document).on('change', '#ipassword', function () {
		var psw1 = $('#ipassword').val();
		var psw2 = $('#ipassword2').val();
		if (psw1 != psw2 && psw2 != "") {
			hasilpassword = "beda";
			$('#pswHasil').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true">' +
				'</i>Password tidak sama</span></label>');
		} else {
			hasilpassword = "";
			$('#pswHasil').html("");
		}
	});

	$(document).on('change', '#ipassword2', function () {
		var psw1 = $('#ipassword').val();
		var psw2 = $('#ipassword2').val();
		if (psw1 != psw2) {
			hasilpassword = "beda";
			$('#pswHasil').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true">' +
				'</i>Password tidak sama</span></label>');
		} else {
			hasilpassword = "";
			$('#pswHasil').html("");
		}
	});

	$(document).on('change', '#ifirst_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ifirst_name').val())) {
			$('#firstnameHasil').html("");
		} else {
			$('#firstnameHasil').html("* huruf saja");
		}
	});

	$(document).on('change', '#ilast_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ilast_name').val()) || $('#ilast_name').val() == "") {
			$('#lastnameHasil').html("");
		} else {
			$('#lastnameHasil').html("* huruf saja");
		}
	});


	function cekregister() {
		var ijinlewat1 = false;
		var ijinlewat2 = false;
		var ijinlewat3 = false;

		$('#jabatan').val("<?php echo $jabatan;?>");
		$('#addedit').val('<?php echo $addedit;?>');

		if ($('#ifirst_name').val() == "" || $('#email').val() == "" || $('#ipassword').val() == "") {
			alert("Semua harus diisi");
			ijinlewat1 = false;
		} else
			ijinlewat1 = true;

		if (hasilemail != "" || hasilpassword != "" || emailvalid == false) {
			ijinlewat2 = false;
		} else
			ijinlewat2 = true;

		if (grecaptcha.getResponse().length != 0) {
			$.ajax({
				type: 'POST',
				data: {},
				dataType: 'text',
				cache: false,
				url: '<?php echo base_url();?>login/getResponseCaptcha/' + grecaptcha.getResponse(),
				success: function (result) {
					if (result == "sukses") {
						ijinlewat3 = true;
					} else {
						alert("Apakah anda Robot?");
						ijinlewat3 = false;
					}

					if (ijinlewat1 && ijinlewat2 && ijinlewat3) {
						document.getElementById('myform').submit();
					} else {
						alert("Periksa kembali data anda!");
						return false;
					}
				}
			});
		} else {
			alert("Periksa data anda!");
			ijinlewat3 = false;
		}

		return false;
	}

	function takon() {
		window.open("<?php echo base_url();?>login/daftar", "_self");
		return false;
	}

	$('#myform').on('keyup keypress', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	const togglePassword = document.querySelector("#togglePassword");
	const password = document.querySelector("#ipassword");
	const password2 = document.querySelector("#ipassword2");

	togglePassword.addEventListener("click", function () {
		// toggle the type attribute
		const type = password.getAttribute("type") === "password" ? "text" : "password";
		password.setAttribute("type", type);

		const type2 = password2.getAttribute("type") === "password" ? "text" : "password";
		password2.setAttribute("type", type2);

		// toggle the icon
		this.classList.toggle("bi-eye");
	});

	// prevent form submit
	const form = document.querySelector("form");
	form.addEventListener('submit', function (e) {
		e.preventDefault();
	});

</script>
