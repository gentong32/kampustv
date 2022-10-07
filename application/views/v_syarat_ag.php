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

	#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3 {
		box-sizing: border-box;
		font-size: 0px;
		min-height: 1px;
		padding-right: 0px;
		padding-left: 0px;
		position: relative;
	}

	#LayoutGrid1 > .row > .col-1, #LayoutGrid1 > .row > .col-2, #LayoutGrid1 > .row > .col-3 {
		float: left;
	}

	#LayoutGrid1 > .row > .col-1 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 33.33333333%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-2 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 33.33333333%;
		text-align: center;
	}

	#LayoutGrid1 > .row > .col-3 {
		background-color: transparent;
		background-image: none;
		border: 0px solid #FFFFFF;
		width: 33.33333333%;
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

	@media (max-width: 480px) {
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
		width: 200px;
		height: 266px;
		vertical-align: top;
	}
</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$lite = $harga->harga_lite;
//$reguler = $harga->harga_reguler;
//$premium = $harga->harga_premium;
?>

<div class="container bgimg3" style="padding-bottom: 20px;width: 100%">

	<div style="background-color:#aabfb8;margin-top: 65px;margin-bottom:20px;padding:10px;">
		<center>
			<div style="font-size: 23px;font-weight: bold;color: black;">PERSYARATAN MENJADI AGENCY</div>
		</center>
	</div>
	<div style="font-size: 18px; font-weight: bold; color: black;">
		<div style="padding:20px;border: grey 1px dotted; max-width: 500px;text-align: left; margin:auto;">
			Hal yang dipersiapkan oleh agency adalah:<br>
			<ul>
				<li>
					Ketersediaan ruang kantor (minimal ...x...)
				</li>
				<li>
					Perabot kantor:
				</li>
				<ul>
					<li>
						meja kerja petugas + PC
					</li>
					<li>
						meja kursi tamu
					</li>
				</ul>
				<li>
					Studio:
				</li>
				<ul>
					<li>
						backdrop greenscreen
					</li>
					<li>
						lampu ring 3 buah dengan penyangga tripod
					</li>
				</ul>
				<li>
					Perlengkapan lain:
				</li>
				<ul>
					<li>
						marketing kit
					</li>
					<li>
						internet
					</li>
				</ul>
				<li>
					Menandatangani MoU dengan TVSekolah
				</li>
			</ul>

		</div>
	</div>

	<div style="margin-top: 10px;">
		<center>
		<button onclick="window.open('<?php echo base_url() . "login/register/umum_ag";?>','_self');" class="btn-blue">DAFTAR</button>
		</center>
	</div>

</div>
