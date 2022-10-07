<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

$namastatus = Array ('','Menunggu Pembayaran','','Lunas');

?>
<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_ekskul">
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
						<h1>Ekstrakurikuler Majalah Dinding</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->
	<section aria-label="section" class="mt0 sm-mt-0">
		<div class="container">
			<div class="row">
					<?php if ($pembayar=="sekolah"){?>
					<div style="margin-bottom: 10px;">
						<button class="btn-main"
								onclick="window.location.href='<?php echo base_url(); ?>ekskul/'"
								class="btn-main">Kembali
						</button>
					</div>
					<hr>
					<center><h3>PEMBAYARAN BULAN INI AKAN DILAKUKAN OLEH SEKOLAH</h3>
						<?php } else {?>
							<div style="margin-bottom: 10px;">
								<button class="btn-main"
										onclick="window.location.href='<?php echo base_url(); ?>ekskul/'"
										class="btn-main">Kembali
								</button>
								<?php if ($bulaninisudah == false) { ?>
									<button id="pay-button" class="btn-main">Bayar Bulan Ini</></button>
									<button id="pay-button2" class="btn-main">Bayar 1 Semester</></button>
								<?php } ?>
							</div>
						<?php } ?>
				<hr>
				<center><h3>IURAN SAYA</h3></center>

				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tabel_data" class="table table-striped table-bordered nowrap" cellspacing="0"
						   width="100%">
						<thead>
						<tr>
							<th style='width:5px;text-align:center'>No</th>
							<th style='width:40%;text-align:center'>Nama</th>
							<th style='text-align:center'>Pembayaran Bulan</th>
							<th style='text-align:center'>Tanggal Bayar</th>
							<th style='text-align:center'>Status</th>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>

	$(document).ready(function () {
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($databayar as $datane) {
			if($datane->id!=$this->session->userdata('id_user') && $datane->sebagai==2)
				continue;
			$jml_user++;

			$bayarbulan1 = $namabulan[intval(substr($datane->tgl_bayar, 5, 2))];
			$bayarbulan2 = " - ".$namabulan[intval(substr($datane->tgl_berakhir, 5, 2))];
			$bayartahun1 = " ".intval(substr($datane->tgl_bayar, 0, 4));
			$bayartahun2 = " ".intval(substr($datane->tgl_berakhir, 0, 4));

			if (intval(substr($datane->tgl_bayar, 5, 2)) == intval(substr($datane->tgl_berakhir, 5, 2)))
				$bayarbulan2 = "";
			if ($bayartahun2=="2001")
				{
					$bayarbulan2 = "";
					$bayartahun2 = "";
				}
			if (intval(substr($datane->tgl_bayar, 0, 4)) == intval(substr($datane->tgl_berakhir, 0, 4)))
				{
					$bayartahun1 = "";
				}


			$bayarbulan = $bayarbulan1.$bayartahun1.$bayarbulan2.$bayartahun2;

			$tanggalbayar0 = new DateTime($datane->tgl_bayar);
			$tanggalbayar1 = $tanggalbayar0->format("d/m/Y H:i:s");
			if($datane->status==1)
			{
				$sstatus = "<a href='".base_url()."payment/tunggubayar_ekskul'>Menunggu Pembayaran</a>";
			}

			else if($datane->status==3)
			{
				if (substr($datane->order_id,0,3)=="EKF")
					$sstatus = "Gratis";
				else
					$sstatus = "Lunas";
			}


			if($datane->sebagai==1)
				$namapembayar = "SEKOLAH";
			else
				$namapembayar = $datane->first_name . " " .$datane->last_name;


			echo "data.push([ " . $jml_user . ", \"" . $namapembayar . "\", \"" . $bayarbulan . "\", \"" . $tanggalbayar1 . "\", \"".$sstatus."\"]);";
		}
		?>

		$('#tabel_data').DataTable({
			data: data,
			deferRender: true,
			scrollCollapse: true,
			scroller: true,
			pagingType: "simple",
			language: {
				paginate: {
					previous: "<",
					next: ">"
				}
			},
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [1, 2]
				},
				{responsivePriority: 1, targets: 0},
				{responsivePriority: 10001, targets: 2},
				{responsivePriority: 2, targets: -2},
				{
					width: 25,
					targets: 0
				}
			],
			"order": [[0, "asc"]]
		});

	});

</script>
<!---------------------------------------------------------------------------------------->

<!----------------------------- SCRIPT PAYMENT  -------------------------------->
<script>
	$('#pay-button').click(function (event) {

		event.preventDefault();
		$(this).attr("disabled", "disabled");
		setTimeout(() => {
			$(this).attr("disabled", false)
		}, 3000);

		$.ajax({
			url: '<?php echo base_url();?>payment/token_ekskul/bulanan',
			cache: false,

			success: function (data) {
				//location = data;

				console.log('token = ' + data);

				var resultType = document.getElementById('result-type');
				var resultData = document.getElementById('result-data');

				function changeResult(type, data) {
					$("#result-type").val(type);
					$("#result-data").val(JSON.stringify(data));
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
		setTimeout(() => {
			$(this).attr("disabled", false)
		}, 3000);

		$.ajax({
			url: '<?php echo base_url();?>payment/token_ekskul/semester',
			cache: false,

			success: function (data) {
				//location = data;

				console.log('token = ' + data);

				var resultType = document.getElementById('result-type');
				var resultData = document.getElementById('result-data');

				function changeResult(type, data) {
					$("#result-type").val(type);
					$("#result-data").val(JSON.stringify(data));
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
