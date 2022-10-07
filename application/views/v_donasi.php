<?php
defined('BASEPATH') OR exit('No direct script access allowed');

foreach ($dafdonasi as $data) {
	$donasi1 = $data->donasi1;
	$donasi2 = $data->donasi2;
	$donasi3 = $data->donasi3;
	$donasi4 = $data->donasi4;
}
?>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_donasi">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

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
						<h1>Donasi</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row" style="color:black;font-size: 16px; font-weight:bold;text-align:center;width:100%">
				<center>PILIHAN DONASI</center>
				<br>
				<br>
			</div>
			<div style="max-width: 320px;height: 360px;border: 3px solid black;border-radius: 10px;padding:10px;
        font-size: 16px;color:black;text-align:center;margin-left: auto;margin-right: auto">
				<table class="table" border="1" style="border-collapse:collapse">
					<thead>
					<tr>
						<th style="width: 10px">No.</th>
						<th style="text-align: center">Donasi</th>
						<th style="text-align: center">Pilih</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td data-header="No" style="text-align:center">1</td>
						<td data-header="Donasi" style="text-align:right">Rp <?php
							echo number_format($donasi1, 0, ",", ".") ?>,-
						</td>
						<td data-header="Pilih" style="text-align:center"><input type="radio" value="1"
																				 name="myRadios"/>
						</td>
					</tr>
					<tr>
						<td data-header="No" style="text-align:center">2</td>
						<td data-header="Donasi" style="text-align:right">Rp <?php
							echo number_format($donasi2, 0, ",", ".") ?>,-
						</td>
						<td data-header="Pilih" style="text-align:center"><input type="radio" value="2"
																				 name="myRadios"/>
						</td>
					</tr>
					<tr>
						<td data-header="No" style="text-align:center">3</td>
						<td data-header="Donasi" style="text-align:right">Rp <?php
							echo number_format($donasi3, 0, ",", ".") ?>,-
						</td>
						<td data-header="Pilih" style="text-align:center"><input type="radio" value="3"
																				 name="myRadios"/>
						</td>
					</tr>
					<tr>
						<td data-header="No" style="text-align:center">4</td>
						<td data-header="Donasi" style="text-align:right">Rp <?php
							echo number_format($donasi4, 0, ",", ".") ?>,-
						</td>
						<td data-header="Pilih" style="text-align:center"><input type="radio" value="4"
																				 name="myRadios"/>
						</td>
					</tr>
					<tr>
						<td data-header="No" style="text-align:center">5</td>
						<td data-header="Donasi" style="text-align:right">
							<input style="width:160px;text-align: right" type="text" name="currency-field"
								   id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"
								   value="" data-type="currency" placeholder="Ketik jumlah lain...">
						</td>
						<td data-header="Pilih" style="text-align:center"><input id="radiosendiri" type="radio"
																				 value="5" name="myRadios"/>
						</td>
					</tr>
					</tbody>
				</table>

				<button id="pay-button" class="myButtonDonasi"><span style="font-weight: bold">Bayar Donasi</span>
				</button>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">

	$(document).on('change input', '#currency-field', function () {
		radiobtn = document.getElementById("radiosendiri");
		radiobtn.checked = true;
	});

	$('#pay-button').click(function (event) {

		var pil = document.getElementsByName('myRadios');
		var dipilih = 0;

		for (i = 0; i < pil.length; i++) {
			if (pil[i].checked)
				dipilih = (pil[i].value);
		}

		if (dipilih == 5) {
			var thenum = $('#currency-field').val().replace(/\D+/g, "");
			if (thenum < 500000) {
				$('#currency-field').val("Rp 500.000,-");
				alert("Minimal Rp 500.000,-");
				return false;
			} else {
				dipilih = thenum;
			}
		} else if (dipilih == 0) {
			alert("Silakan tentukan pilihan anda");
			return false;
		}

		event.preventDefault();
		$(this).attr("disabled", "disabled");

		$.ajax({
			url: '<?php echo base_url();?>payment/token_donasi/' + dipilih,
			cache: false,

			success: function (data) {
				//location = data;

				console.log('token = ' + data);

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

</script>

<script>
	$("input[data-type='currency']").on({
		keyup: function () {
			formatCurrency($(this));
		},
		blur: function () {
			formatCurrency($(this), "blur");
		}
	});


	function formatNumber(n) {
		// format number 1000000 to 1,234,567
		return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
	}


	function formatCurrency(input, blur) {
		var input_val = input.val();
		if (input_val === "") {
			return;
		}
		var original_len = input_val.length;
		var caret_pos = input.prop("selectionStart");
		if (input_val.indexOf(",") >= 0) {
			var decimal_pos = input_val.indexOf(",");
			var left_side = input_val.substring(0, decimal_pos);
			var right_side = input_val.substring(decimal_pos);

			left_side = formatNumber(left_side);
			right_side = formatNumber(right_side);

			// On blur make sure 2 numbers after decimal
			if (blur === "blur") {
				right_side += "-";
			}

			right_side = right_side.substring(0, 0);

			input_val = "" + left_side;

		} else {
			// no decimal entered
			// add commas to number
			// remove all non-digits
			input_val = formatNumber(input_val);
			input_val = "Rp " + input_val;

			// final formatting
			if (blur === "blur") {
				input_val += ",-";
			}
		}

		// send updated string to input
		input.val(input_val);

		// put caret back in the right position
		var updated_len = input_val.length;
		caret_pos = updated_len - original_len + caret_pos;
		input[0].setSelectionRange(caret_pos, caret_pos);
	}
</script>
