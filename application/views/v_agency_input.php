<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
    <div id="top"></div>
    <!-- section begin -->
    <section
        id="subheader"
        class="text-light"
        data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
                        <h1>Input User Agency</h1>
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
                <?php
				echo form_open('channel/masukkanagency', array('autocomplete' => 'off', 'id' => 'myform'));
				?>
			    <br>
				<center><span style="font-size:18px;font-weight: bold;">AKUN AGENCY</span></center>
				<br><br>
				<div>
					<button type="button" class="btn-main"
							onclick="balikyo();">
						Kembali
					</button>
				</div>
				<hr style="margin-top: 10px;">
				
                <div style="max-width:900px;margin:auto">
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
                                Lembaga
							</div>
							<div class="col-lg-8 col-md-8">
								<input readonly type="text" class="form-control"
								value="<?php echo $namalembaga;?>">
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Lokasi Lembaga
							</div>
							<div class="col-lg-8 col-md-8">
								<input readonly type="text" class="form-control"
								value="<?php echo $lokasi;?>">
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
                                Email calon Agency
							</div>
							<div class="col-lg-8 col-md-8">
								<input type="text" class="form-control"
								id="iemail" name="iemail" maxlength="50" value="<?php echo $email;?>">
                                <label class="text-danger"><span><div id="email_result"></div>
            				</span></label>
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Password
							</div>
							<div class="col-lg-8 col-md-8">
								<input  type="text" class="form-control"
								id="ipassword" name="ipassword" maxlength="64" value="">
							</div>
						</div>
                    </div>
                    
                    <center>
                    <div>
                        <button onclick="return cekregister()" class="btn-main" id="btn_upload1">SUBMIT</button>
                    </div>
                    </center>

                    <input type="hidden" name="iwilayah" id="iwilayah" value="<?php echo $idwilayah; ?>">
                    <input type="hidden" name="namalembaga" id="namalembaga" value="<?php echo $namalembaga; ?>">

                    <?php
					?>
                </div>
                <?php
                echo form_close() . '';
                ?>
            </div>
        </div>
    </section>
</div>

<script>

    var hasilemail = "";
	var emailvalid = false;
	var emaillama = "<?php echo $email;?>";

	$(document).ready(function () {
		if ($('#iemail').val()!="")
		$('#iemail').focus();
	});

	$(document).on('blur', '#iemail', function () {
		var email = $('#iemail').val();
		var $result = $("#email_result");
		var domain = email.substring(email.lastIndexOf("@") + 1);
		var hasilemail = "";
		$result.text("");

		if (validateEmail(email)) {
			//$result.text(email + " is valid :)");
			//$result.css("color", "green");
			emailvalid = true;
		} else {
			$result.text("Alamat email '" + email + "' tidak valid");
			$result.css("color", "red");
			emailvalid = false;
		}

        if (email != '' && emailvalid && emaillama!=email) {
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

    function cekregister() {
		var ijinlewat = false;
        if (emailvalid && $('#ipassword').val()!="" && hasilemail == "")
        {
            document.getElementById('myform').submit();
        } else {
            alert("Periksa kembali data anda!");
            return false;
        }
    }

    $('#myform').on('keyup keypress', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

    // prevent form submit
	const form = document.querySelector("form");
	form.addEventListener('submit', function (e) {
		e.preventDefault();
	});

	function balikyo()
	{
		window.location.href='<?php echo base_url(); ?>channel/daftaragency/';
	}

</script>