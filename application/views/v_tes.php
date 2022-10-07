<div class="bgimg2" style="margin-top: 0px;padding-top: 30px;padding-bottom: 30px;">
	<div class="row" style="color:black;font-size: 18px; font-weight:bold;text-align:center;width:100%">
		<br>
		Tentang Kami
		<br><br>
	</div>
	<div style="font-size: larger; color: black">
		<center>Fordorum adalah forum untuk dosen, guru, dan masyarakat.</center>
		<br>
	</div>
</div>

<script>
	$.ajax({
		method: 'POST',
		// make sure you respect the same origin policy with this url:
		// http://en.wikipedia.org/wiki/Same_origin_policy
		url: '<?php echo base_url();?>payment/notifikasi',
		//dataType: 'json',
		data: {
			"transaction_time": "2020-09-05 07:33:04",
			"transaction_status": "settlement",
			"transaction_id": "28249334-31df-439c-a024-bab70875b67c",
			"status_message": "midtrans payment notification",
			"status_code": "200",
			"signature_key": "383c89c6320841a76f87326400764dc391bea35726c7f3f61b3a081e625064c5b42fba2855e08bf409ac2a9841879d88edd38480fd8399cc4d1cc118a55e0625",
			"settlement_time": "2020-09-05 07:33:41",
			"payment_type": "echannel",
			"order_id": "DNS-1604187493",
			"merchant_id": "G961922282",
			"gross_amount": "500000.00",
			"fraud_status": "accept",
			"currency": "IDR",
			"biller_code": "70012",
			"bill_key": "614217746189"
		},
		success: function(msg){
			alert('wow' + msg);
		}
	});
</script>
