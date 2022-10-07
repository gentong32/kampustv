<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ($addedit == "add") {
	$semail = '';
	$snama = '';
	$stelp = '';
	$salamat = '';
	$sjob = '';
	$sinstansi = '';
	$sid = '';

} else {
	$semail = $userdonatur->email_donatur;
	$snama = $userdonatur->nama_donatur;
	$stelp = $userdonatur->telp_donatur;
	$salamat = $userdonatur->alamat;
	$sjob = $userdonatur->pekerjaan_donatur;
	$sinstansi = $userdonatur->nama_lembaga;
	$sid = $userdonatur->id;

}

?>

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
						<h1>ACCOUNT EXECUTIVE</h1>
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
				echo form_open('eksekusi/update_donatur/' . $opsi, array('autocomplete' => 'off', 'id' => 'myform'));

				?>

				<div class="container" style="max-width:600px;padding-bottom: 20px;	">
					<div>
						<legend><span
								style="font-weight: bold;color: black">Donatur Baru</span>
						</legend>
						<fieldset style="background-color: white;margin-top: 20px">


							<div class="form-group" style="padding-top: 20px;">
								<label for="" class="col-md-12 control-label">Email Donatur<span
										style="color:red">*</span></label>
								<div class="col-md-12">
									<input autocomplete="false" autofill="false" type="text" class="form-control"
										   id="iemail" name="iemail" maxlength="50" value="<?php echo $semail; ?>"
										   placeholder="Alamat Email">
									<label class="text-danger"><span><div id="email_result"></div>
            				</span></label>
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nama Donatur<span
										style="color:red">*</span>
									<span style="color: red" id="firstnameHasil"></span></label>
								<div class="col-md-12">
									<input type="text" class="form-control" id="ifirst_name" name="ifirst_name"
										   maxlength="25"
										   placeholder="Nama Depan" value="<?php echo $snama; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nomor Telp<span
										style="color:red">*</span>
									<span style="color: red"></span></label>
								<div class="col-md-12">
									<input type="text" class="form-control" id="ihape" name="ihape"
										   maxlength="50"
										   placeholder="Nomor Telp" value="<?php echo $stelp; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Lembaga
									<span style="color: red">*</span></label>
								<div class="col-md-12">
									<input type="text" class="form-control" id="iinstansi" name="iinstansi"
										   maxlength="100"
										   placeholder="Nama instansi" value="<?php echo $sinstansi; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Alamat
									<span style="color: red"></span></label>
								<div class="col-md-12">
									<input type="text" class="form-control" id="ialamat" name="ialamat"
										   maxlength="200"
										   placeholder="Alamat" value="<?php echo $salamat; ?>">
								</div>
							</div>


							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Pekerjaan
									<span style="color: red"></span></label>
								<div class="col-md-12">
									<input type="text" class="form-control" id="ijob" name="ijob"
										   maxlength="50"
										   placeholder="Pekerjaan" value="<?php echo $sjob; ?>">
								</div>
							</div>


							<input type="hidden" id="addedit" name="addedit"/>
							<input type="hidden" id="iddonatur" name="iddonatur"/>

							<div class="form-group" style="padding-top: 20px;margin-top:20px;">
								<div class="col-md-10 col-md-offset-0" style="margin-top: 10px;margin-bottom: 10px;">
									<button class="btn btn-default" onclick="return takon()">Batal</button>
									<button type="submit" class="btn btn-primary" onclick="return cekregister()">Simpan
									</button>
								</div>
							</div>

						</fieldset>
					</div>
				</div>


				<?php
				echo form_close() . '';
				?>
			</div>
		</div>
	</section>
</div>


<script>

	var hasilpassword = "";
	var hasilemail = "";
	var emailvalid = true;

	$(document).on('change', '#iemail', function () {
		var email = $('#iemail').val();
		var $result = $("#email_result");
		var domain = email.substring(email.lastIndexOf("@") + 1);
		$result.text("");

		if (validateEmail(email)) {
			//$result.text(email + " is valid :)");
			//$result.css("color", "green");
			// alert ("TRUE");
			emailvalid = true;
		} else {
			$result.text("Alamat email '" + email + "' tidak valid");
			$result.css("color", "red");
			emailvalid = false;
			// alert ("FALSE");
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


	$(document).on('change', '#ifirst_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ifirst_name').val())) {
			$('#firstnameHasil').html("");
		} else {
			$('#firstnameHasil').html("* huruf saja");
		}
	});


	function cekregister() {
		var ijinlewat1 = false;
		var ijinlewat2 = false;

		$('#addedit').val('<?php echo $addedit;?>');
		$('#iddonatur').val('<?php echo $sid;?>');

		if ($('#ifirst_name').val() == "" || $('#iemail').val() == ""
			|| $('#ihape').val() == "" || $('#iinstansi').val() == "") {
			alert("Semua * harus diisi");
			ijinlewat1 = false;
		} else {
			ijinlewat1 = true;
		}


		if (hasilemail != "" || emailvalid == false) {
			ijinlewat2 = false;
		} else {
			ijinlewat2 = true;
		}


		if (ijinlewat1 && ijinlewat2)
			return true;

		return false;
	}

	function takon() {
		window.history.back();
		return false;
	}

	$('#myform').on('keyup keypress', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

</script>
