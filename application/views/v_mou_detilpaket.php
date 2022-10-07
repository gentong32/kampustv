<style>
	.btn-blue {
		box-shadow: 3px 4px 0px 0px #1564ad;
		background: linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
		background-color: #79bbff;
		border-radius: 5px;
		border: 1px solid #337bc4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 16px;
		font-weight: bold;
		padding: 12px 44px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #528ecc;
	}

	.btn-blue:hover {
		background: linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
		background-color: #378de5;
	}

	.btn-blue:active {
		position: relative;
		top: 1px;
	}

	.btn-grey {
		box-shadow: 3px 4px 0px 0px #839089;
		background: linear-gradient(to bottom, #839089 5%, #87948D 100%);
		background-color: #ADAAAC;
		border-radius: 5px;
		border: 1px solid #CCCED4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 16px;
		font-weight: bold;
		padding: 12px 44px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #000000;
	}

	#wb_LayoutGrid1 {
		clear: both;
		position: relative;
		table-layout: fixed;
		display: table;
		text-align: center;
		width: 100%;
		background-color: transparent;
		background-image: none;
		border: 0px solid #CCCCCC;
		box-sizing: border-box;
		margin: 0;
	}

	#LayoutGrid1 {
		box-sizing: border-box;
		padding: 0;
		margin-right: auto;
		margin-left: auto;
		max-width: 800px;
		padding-bottom: 20px;
	}

	#LayoutGrid1 > .row {
		margin-right: 0;
		margin-left: 0;
	}

	#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3, #LayoutGrid1 > .row > .col-4 {
		box-sizing: border-box;
		font-size: 0px;
		min-height: 1px;
		padding-right: 0px;
		padding-left: 0px;
		position: relative;
	}

	#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3,#LayoutGrid1 > .row > .col-4 {
		float: left;
	}



	#LayoutGrid1 > .row > .col-1 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 25%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-2 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 25%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-3 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 25%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-4 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 25%;
		text-align: center;
	}

	#LayoutGrid1:before,
	#LayoutGrid1:after,
	#LayoutGrid1 .row:before,
	#LayoutGrid1 .row:after {
		display: table;
		content: " ";
	}

	#LayoutGrid1:after,
	#LayoutGrid1 .row:after {
		clear: both;
	}

	@media (max-width: 750px) {
		#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3 {
			float: none;
			width: 100% !important;
		}
	}

	.wb_Image1 {
		margin-bottom: 10px;
		vertical-align: top;
	}

	.Image1 {
		border: 0px solid #000000;
		padding: 0;
		display: inline-block;
		width: 220px;
		height: auto;
		vertical-align: top;
	}

</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$fullkelas = "";

switch ($indeks) {
	case 1:
		$namapaket = "A";
		$bayar = "Rp 1.800.000,-";
		$lama = "6 bulan";
		$angsuran = "2x";
    break;
	case 2:
		$namapaket = "B";
		$bayar = "Rp 3.600.000,-";
		$lama = "12 bulan";
		$angsuran = "4x";
    break;
	case 3:
		$namapaket = "C";
		$bayar = "Rp 3.000.000,-";
		$lama = "6 bulan";
		$fullkelas = " Full ";
		$angsuran = "2x";
    break;

	default:
		$namapaket = "D";
		$bayar = "Rp 6.000.000,-";
		$lama = "12 bulan";
		$fullkelas = " Full ";
		$angsuran = "4x";
}

?>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_mou">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<div class="container bgimg3" style="margin-top: 0px;width: 100%">

	<div style="background-color:#aabfb8;margin-top: 65px;padding-top:10px;padding-bottom:10px;">
		<center>
			<div style="font-size: 20px;font-weight: bold;color: black;">DETIL PAKET MOU</div>
		</center>
	</div>

	<center>
		<center>
			<div id="wb_LayoutGrid1">
				<div id="LayoutGrid1">
					<div class="row">
						<?php if ($this->session->userdata('loggedIn')) { ?>
							<h3 style="color: black">Paket MoU-<?php echo $namapaket;?></h3>
							<br>
							<span style="font-size: larger;color: black"><?php echo "Kelas ini adalah paket kelas <b>".$fullkelas."Premium</b> untuk <b>".
							$lama."</b>.<br> Total yang harus dibayarkan adalah <b>".$bayar."</b>
							<br> Iuran dapat diangsur selama <b>".$angsuran."</b> dan maksimal di tanggal terakhir setiap <b>3</b> bulan.";?>
								</span>
						 <?php }?>

					</div>
				</div>
			</div>
		</center>
	</center>
	<center>
		<div style="margin-top: 0px;margin-bottom: 20px">
			<button class="myButtonDonasi" style="padding: 5px 10px 5px 10px;" onclick="kembaliya()">Kembali
			</button>
			<button class="myButtonDonasi" style="padding: 5px 10px 5px 10px;" onclick="setuju()">Setuju
			</button>
		</div>
	</center>

</div>

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<script>

	function setuju() {

		var r = confirm("Yakin memilih paket ini? Jika klik tombol 'OK', tidak dapat diubah lagi!");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url();?>mou/setuju_paket",
				method: "POST",
				data: {indeks: <?php echo $indeks;?>},
				success: function (result) {
					if (result.substring(0,2) == "OK")
						window.open("<?php echo base_url();?>", "_self");
					else
						alert ("Ada masalah pada jaringan");
				}
			});
		} else {
			return false;
		}
		return false;

	}



	function kembaliya() {
		window.open("<?php echo base_url();?>mou/pilih_paket", "_self");
	}


</script>
