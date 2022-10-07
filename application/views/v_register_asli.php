<div class="container" style="margin-top: 60px">

	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$njenis1 = 'checked="checked"';
	$njenis2 = '';
	$njenis3 = '';
	$tampil1 = 'style="display: block"';
	$tampil2 = 'style="display: none"';

	$njudul = '';
	$nseri = '';
	$ntahun = '';
	$level = '';

	$hasilemail = "";
	$hasilpassword = "";
	$hasilcapcay = "";


	//echo $addedit;

	?>


	<div class="row">
		<?php
		echo form_open('login/tambahuser', array('autocomplete' => 'off','id' => 'myform'));

		?>

		<div class="col-md-10 col-md-offset-1">
			<div class="well bp-component" style="background-color: white;">
				<fieldset style="background-color: white">
					<legend>Daftar Baru Sebagai <?php echo $jabatan; ?></legend>
					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Nama depan</label>
						<div class="col-md-12">
							<input type="text" class="form-control" id="ifirst_name" name="ifirst_name" maxlength="25"
								   placeholder="Nama Depan">
						</div>
					</div>
					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Nama belakang</label>
						<div class="col-md-12">
							<input type="text" class="form-control" id="ilast_name" name="ilast_name" maxlength="25"
								   placeholder="Nama Belakang">
						</div>
					</div>

					<!-- <div class="form-group"><br>
                                      <label for="inputDefault" class="col-md-12 control-label">Sebagai</label>
                                  <div class="col-md-12">
                                      <table>
                                                  <tr>
                                                      <td style='width:auto'>
                                          <select class="form-control" name="ijenis" id="ijenis">
                                          <option selected value="1">Guru</option>;
                                          <option value="2">Siswa</option>;
                                          <option value="3">Umum</option>;
                                          <option value="4">Staf Pustekkom</option>;
                                          </select>
                                                      </td>

                                      </table>
                                  </div>
                              </div> -->


					<input style="color:black;border:0;width: 0px;height: 0px; padding: 0;margin: 0" id="iemails"
						   name="iemails" maxlength="6" value="" placeholder="">


					<div class="form-group">
						<label for="" class="col-md-12 control-label">Email</label>
						<div class="col-md-12">
							<input autocomplete="false" autofill="false" type="text" class="form-control" id="iemail"
								   name="iemail" maxlength="25" value="" placeholder="Alamat Email">
							<label class="text-danger"><span><div id="email_result"></div>
            				</span></label>

						</div>
					</div>


					<input style="color:black;border:0;width: 0px;height: 0px; padding: 0;margin: 0" type="password" class="form-control" id="ipasword" name="ipas" maxlength="0"
						   value="" placeholder="Password">


					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Password</label>
						<div class="col-md-12" style="width:200px">
							<input type="password" class="form-control" id="ipassword" name="ipassword" maxlength="16"
								   value="" placeholder="Password">
						</div>
					</div>

					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Repeat Password</label>
						<div class="col-md-12" style="width:200px">
							<input type="password" class="form-control" id="ipassword2" name="ipassword2" maxlength="16"
								   value="<?php
								   echo $ntahun; ?>" placeholder="Password">
							<span id="pswHasil"></span><br>
						</div>
					</div>

					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Ketik Tulisan</label>
						<div class="col-md-12" style="width:300px">
							<div style="display:inline-block" id="captImg"><?php echo $captchaImg; ?></div>
							<div style="display:inline-block">
								<a href="javascript:void(0);" class="refreshCaptcha"><img
										src="<?php echo base_url() . 'assets/images/refresh.png'; ?>"/></a>
							</div>
							<input type="text" name="captcha" id="captcha" value=""/>
							<p id="captHasil"></p>
						</div>
					</div>

					<input type="hidden" id="addedit" name="addedit"/>
					<input type="hidden" id="jabatan" name="jabatan"/>

					<div class="form-group">
						<div class="col-md-10 col-md-offset-0">
							<button class="btn btn-default" onclick="return takon()">Batal</button>
							<button type="submit" class="btn btn-primary" onclick="return cekregister()">Simpan</button>
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


	<!-- echo form_open('dasboranalisis/update'); -->

	<script>

		var hasilcapcay = "";
		var hasilpassword = "";
		var hasilemail = "";

		$(document).ready(function () {
			var siiemal = $(document).getElementById('iemail');
			siiemal.html("sdsa");
		});


		$(document).on('change', '#iemail', function () {
			var email = $('#iemail').val();
			var $result = $("#email_result");
			var emailvalid = false;
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
			}

			else {
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
			}

			else {
				hasilpassword = "";
				$('#pswHasil').html("");
			}
		});


		// $(document).on('change', '#captcha', function () {
		// 	var isicapca = $('#captcha').val();
		// 	if (isicapca != '') {
		// 		$.ajax({
		// 			type: 'GET',
		// 			data: {captcha: $('#captcha').val()},
		// 			dataType: 'text',
		// 			cache: false,
		// 			url: '<?php echo base_url(); ?>login/cekcapcay',
		// 			success: function (result) {
		// 				$('#captHasil').html(result);
		// 				hasilcapcay = result;
		// 			}
		// 		})
		// 	}
		// });

		$('.refreshCaptcha').on('click', function () {
			$.get('<?php echo base_url() . 'login/refresh'; ?>', function (data) {
				$('#captImg').html(data);
			});
		});


		function cekregister() {
			var ijinlewat1 = false;
			var ijinlewat2 = false;
			var ijinlewat3 = false;

			$('#jabatan').val("<?php echo $jabatan;?>");
			$('#addedit').val('<?php echo $addedit;?>');

			if ($('#ifirst_name').val() == "" || $('#ilast_name').val() == "" || $('#email').val() == "" || $('#captcha').val() == ""
				|| $('#ipassword').val() == "") {
				alert("Semua harus diisi");
				ijinlewat1 = false;
			}
			else
				ijinlewat1 = true;

			if (hasilemail != "" || hasilpassword != "")
				ijinlewat2 = false;
			else
				ijinlewat2 = true;

			$.ajax({
				type: 'GET',
				data: {captcha: $('#captcha').val()},
				dataType: 'text',
				cache: false,
				url: '<?php echo base_url(); ?>login/cekcapcay',
				success: function (result) {
					$('#captHasil').html(result);
					if (result == "ok")
					{
						ijinlewat3 = true;
					}
					else
					{
						ijinlewat3 = false;
					}

					if (ijinlewat1 && ijinlewat2 && ijinlewat3)
					{
						document.getElementById('myform').submit();
					}
					else
					{
						return false;
					}


				}
			});
			return false;
		}

		function takon() {
			window.open("<?php echo base_url(); ?>login/daftar", "_self");
			return false;
		}


	</script>
