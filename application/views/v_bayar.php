<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<div class="bgimg4">
	<div class="container" style="margin-top: 40px;padding:20px;">
		<div class="row" style="color:black;font-size: 16px; font-weight:bold;text-align:center;width:100%">
			IURAN PENGELOLA (VERIFIKATOR)
			<br>
			<br>
		</div>
		<?php if ($this->session->userdata('statusbayar')==2 && $this->session->userdata('a02')==false)
		{?>
			<div style="max-width:600px; width: 90%;height: auto;border: 3px solid black;border-radius: 10px;padding:10px;
        font-size: larger;color:black;text-align:center;margin-left: auto;margin-right: auto">
				Silakan melakukan transfer iuran sebesar <span
					style="font-weight: bold">Rp <?php echo number_format($reaktivasi, 0, ',', '.'); ?>,-</span> untuk
				<b>reaktivasi Verifikator</b>, karena pembayaran <b>terlambat</b> 2 bulan keatas.
				<br><br>
				<span style="font-size: 14px;">
		Pembayaran paling lama tanggal 5 setiap bulannya, jika lebih dari tanggal 5, maka fungsi Verifikator dan Streaming Channel Sekolah sementara tidak aktif.
		Jika sampai akhir bulan belum membayar iuran, maka Kelas Virtual otomatis akan non-aktif. <br>
					Untuk aktivasi kembali setelah 2 bulan lebih, akan dikenakan biaya <span
						style="color: darkred;font-weight: bold">Rp <?php echo number_format($reaktivasi, 0, ',', '.'); ?>,-</span>
       </span>
				<br><br>
				<button class="btn-info" id="pay-button"><span style="font-weight: bold">Bayar</span></button>
				<button class="btn-info" onclick="window.open('<?php echo base_url();?>payment/premium','_self')"><span style="font-weight: bold">Promo Premium</span></button>
				<button style="margin-top: 5px;" class="btn-info" onclick="window.open('<?php echo base_url();?>mou','_self')"><span style="font-weight: bold">Premium - MoU</span></button>
			</div>

		<?php } else
		{?>
			<div style="max-width:600px; width: 90%;height: auto;border: 3px solid black;border-radius: 10px;padding:10px;
        font-size: larger;color:black;text-align:center;margin-left: auto;margin-right: auto">
				Silakan melakukan transfer iuran sebesar <span
					style="font-weight: bold">Rp <?php echo number_format($iuran, 0, ',', '.'); ?>,-</span> untuk tetap
				aktif menjadi Verifikator.
				<br><br>
				<span style="font-size: 14px;">
		Pembayaran paling lama tanggal 5 setiap bulannya, jika lebih dari tanggal 5, maka fungsi Verifikator dan Streaming Channel Sekolah sementara tidak aktif.
		Jika sampai akhir bulan belum membayar iuran, maka Kelas Virtual otomatis akan non-aktif. <br>
					Untuk aktivasi kembali setelah 2 bulan lebih, akan dikenakan biaya <span
						style="color: darkred;font-weight: bold">Rp <?php echo number_format($reaktivasi, 0, ',', '.'); ?>,-</span>
       </span>
				<br><br>
				<button class="btn-info" id="pay-button"><span style="font-weight: bold">Bayar</span></button>
				<button class="btn-info" onclick="window.open('<?php echo base_url();?>payment/premium','_self')"><span style="font-weight: bold">Promo Premium</span></button>
				<button style="margin-top: 5px;" class="btn-info" onclick="window.open('<?php echo base_url();?>mou','_self')"><span style="font-weight: bold">Premium - MoU</span></button>
			</div>
		<?php } ?>

		<div></div>

	</div>

</div>


<script type="text/javascript">

	$('#pay-button').click(function (event) {
		event.preventDefault();
		$(this).attr("disabled", "disabled");

		$.ajax({
			url: '<?php echo base_url();?>payment/token',
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

