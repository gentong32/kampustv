<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$tglawal = new DateTime($tagihan->tgl_mou_awal);
$tgl1 = new DateTime($tagihan->tgl_penagihan1);
$tgl2 = new DateTime($tagihan->tgl_penagihan2);
$tgl3 = new DateTime($tagihan->tgl_penagihan3);
$tgl4 = new DateTime($tagihan->tgl_penagihan4);
$tagih1 = $tagihan->tagihan1;
$tagih2 = $tagihan->tagihan2;
$tagih3 = $tagihan->tagihan3;
$tagih4 = $tagihan->tagihan4;
$statustagih1 = $tagihan->status_tagih1;
$statustagih2 = $tagihan->status_tagih2;
$statustagih3 = $tagihan->status_tagih3;
$statustagih4 = $tagihan->status_tagih4;


?>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_mou">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<style>
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
		color: black;
	}

	th, td {
		padding: 5px;
	}
</style>

<div class="bgimg4">
	<div class="container" style="margin-top: 40px;padding:20px;">
		<div class="row" style="color:black;font-size: 18px; font-weight:bold;text-align:center;width:100%" >
			Iuran MoU TVSekolah
			<br>
			<span style="font-size: 14px;font-style: italic;">
			[pertanggal <?php echo $tglawal->format("d-m-Y"); ?>]
				</span>
			<br><br>
		</div>
		<center>
			<table>
				<tr>
					<th style="text-align: center">No</th>
					<th style="text-align: center">Jumlah</th>
					<th style="text-align: center">Batas Bayar</th>
					<th style="text-align: center">Status</th>
				</tr>

				<tr>
					<td>1</td>
					<td><?php echo number_format($tagih1, 0, ",", "."); ?></td>
					<td style="text-align: center"><?php echo $tgl1->format("d-m-Y"); ?></td>
					<td style="text-align: center">
						<?php
						if ($statustagih1==0)
							echo "-";
						else
							echo "Lunas";
						?>
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td><?php echo number_format($tagih2, 0, ",", "."); ?></td>
					<td style="text-align: center"><?php echo $tgl2->format("d-m-Y"); ?></td>
					<td style="text-align: center">
						<?php
						if ($statustagih2==0)
							echo "-";
						else
							echo "Lunas";
						?>
					</td>
				</tr>
				<?php if ($tagih3 > 0) { ?>
					<tr>
						<td>3</td>
						<td><?php echo number_format($tagih3, 0, ",", "."); ?></td>
						<td style="text-align: center"><?php echo $tgl3->format("d-m-Y"); ?></td>
						<td style="text-align: center">
							<?php
							if ($statustagih3==0)
								echo "-";
							else
								echo "Lunas";
							?>
						</td>
					</tr>
				<?php } ?>
				<?php if ($tagih4 > 0) { ?>
					<tr>
						<td>4</td>
						<td><?php echo number_format($tagih4, 0, ",", "."); ?></td>
						<td style="text-align: center"><?php echo $tgl4->format("d-m-Y"); ?></td>
						<td style="text-align: center">
							<?php
							if ($statustagih4==0)
								echo "-";
							else
								echo "Lunas";
							?>
						</td>
					</tr>
				<?php } ?>
			</table>
			<br>
			<button style="color: black" class="pay-button" id="tbbayar1">Bayar</button>
		</center>

	</div>

</div>


<script type="text/javascript">

	$('.pay-button').click(function (event) {
		event.preventDefault();
		$(this).attr("disabled", "disabled");

		$.ajax({
			url: '<?php echo base_url();?>payment/token_mou',
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

