<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tpromo = "";
if ($promoke==1)
	$tpromo = "PROMO EARLYBIRD";
else if ($promoke==2)
	$tpromo = "PROMO EARLYBIRD II";
?>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_premium">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<div class="bgimg4">
	<div class="container" style="margin-top: 40px;padding:20px;">
		<div class="row" style="color:black;font-size: 16px; font-weight:bold;text-align:center;width:100%">
			PEMBAYARAN PREMIUM PENGELOLA (<?php echo $tpromo;?>)
			<br>
			<br>
		</div>

		<div style="max-width:600px; width: 90%;height: auto;border: 3px solid black;border-radius: 10px;padding:10px;
        font-size: larger;color:black;text-align:center;margin-left: auto;margin-right: auto">
			Silakan melakukan transfer pembayaran sebesar: <br>
			<span
				style="font-weight: bold">Rp <?php echo number_format($iuran1, 0, ',', '.'); ?>,-</span> untuk menjadi
			Sekolah Pro.
			<br>
			<span
				style="font-weight: bold">Rp <?php echo number_format($iuran2, 0, ',', '.'); ?>,-</span> untuk menjadi
			Sekolah Premium.
			<br><br>
			<span style="font-size: 14px;">
		Sekolah Pro berarti sekolah ini gratis untuk siswa mengambil <b>Paket Pro</b> sebanyak 100 siswa <b>(Rp 3.000,-/siswa)</b>.
       </span><br>
			<span style="font-size: 14px;">
		Sekolah Premium berarti sekolah ini gratis untuk siswa mengambil <b>Paket Premium</b> sebanyak 100 siswa <b>(Rp 5.000,-/siswa)</b>.
       </span>
			<br><br>
			<button class="btn-info" onclick="window.open('<?php echo base_url();?>payment/pembayaran','_self')"><span style="font-weight: bold">Batal</span></button>
			<button class="btn-info" id="pay-button"><span style="font-weight: bold">Bayar Pro</span></button>
			<button class="btn-info" id="pay-button2"><span style="font-weight: bold">Bayar Premium</span></button>
		</div>

		<div></div>

	</div>

</div>


<script type="text/javascript">

	$('#pay-button').click(function (event) {
		event.preventDefault();
		$(this).attr("disabled", "disabled");

		$.ajax({
			url: '<?php echo base_url();?>payment/tokenpremium',
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

	$('#pay-button2').click(function (event) {
		event.preventDefault();
		$(this).attr("disabled", "disabled");

		$.ajax({
			url: '<?php echo base_url();?>payment/tokenfullpremium',
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

