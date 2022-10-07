<style>
	.tbeks1 {
		box-shadow: 3px 4px 0px 0px #1564ad;
		background: linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
		background-color: #79bbff;
		border-radius: 5px;
		border: 1px solid #337bc4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 20px;
		font-weight: bold;
		padding: 10px;
		margin: 5px;
		text-decoration: none;
		text-shadow: 2px 3px 1px #528ecc;
	}

	.tbeks1:hover {
		background: linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
		background-color: #378de5;
	}

	.tbeks1:active {
		position: relative;
		top: 1px;
	}

	.tbeks0 {
		box-shadow: inset 0px 1px 0px 0px #ffffff;
		background: linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%);
		background-color: #f9f9f9;
		border-radius: 6px;
		border: 1px solid #dcdcdc;
		display: inline-block;
		cursor: pointer;
		color: #666666;
		font-family: Arial;
		font-size: 20px;
		font-weight: bold;
		padding: 10px;
		margin: 5px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #ffffff;
	}

	.tbeks0:hover {
		background: linear-gradient(to bottom, #e9e9e9 5%, #f9f9f9 100%);
		background-color: #e9e9e9;
	}

	.tbeks0:active {
		position: relative;
		top: 1px;
	}

	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
	}

	th, td {
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even) {
		background-color: #f2f2f2
	}

</style>

<?php

//echo "<br><br><br><br><br><br>".$dafmarketing->status;

?>

<div class="bgimg3" style="margin-top: 30px;">
	<div id="tempatsoal" class="container" style="opacity:80%;padding-top:50px;padding-bottom:20px;color: black;">

		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1">
						<center>
							<div style="font-size: 16px;padding-top:10px;">
								Kode Referal
							</div>
							<hr>
							<div style="max-width: 200px;margin:auto">
								<input type="text" class="form-control" id="ikodemou" name="ikodemou" placeholder="">
								<span style="color: red" id="kodemouhasil"></span>
							</div>
							<br>
							<button onclick="cekkoderef();">CEK</button>
							<br><br>
							<span style="font-size: smaller"><i>Tidak mengetahui kode MoU? Silakan hubungi Agency di Kota/Kabupaten Anda.</i></span>
						</center>
					</div>
				</div>
			</div>
		</div>
		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">

				<div class="form-group">

				</div>

			</div>
		</div>

	</div>
</div>

<script>

	function cekkoderef() {
		//alert ($('#inpsn').val());
		if($('#ikodemou').val()!="") {
			$.ajax({
				type: 'POST',
				data: {koderef: $('#ikodemou').val()},
				dataType: 'text',
				cache: false,
				url: '<?php echo base_url();?>mou/cekkoderef',
				success: function (result) {
					if (result=="kosong")
					{
						$('#kodemouhasil').html("Kode tidak terdaftar. Hubungi Agency/Mentor di kota Anda!");
					}
					else {
						window.open("<?php echo base_url();?>mou/pilih_paket","_self");
					}
				}
			});
		}
	}

	function tambahsekolah() {
		if (document.getElementById('dsekolahbaru').style.display == "none")
		{
			document.getElementById('dsekolahbaru').style.display = "block";
			document.getElementById('dkotasekolah').style.display = "none";
			$('#isekolah').prop('readonly', false);
			$('#inpsn').prop('readonly', true);
		}
		else
		{
			document.getElementById('dsekolahbaru').style.display = "none";
			document.getElementById('dkotasekolah').style.display = "block";
			$('#isekolah').prop('readonly', true);
			$('#inpsn').prop('readonly', false);
		}

		return false;
	}

	function bataltambah() {
		document.getElementById('dsekolahbaru').style.display = "none";
		document.getElementById('dkotasekolah').style.display = "block";
		document.getElementById('ketsekolahbaru').style.display = "none";
		$('#isekolah').prop('readonly', true);
		$('#inpsn').prop('readonly', false);
		$('#inpsn').setFocus();
		$('#npsnHasil').html("");

	}

	function pilihsekolah() {
		$.ajax({
			url: "<?php echo base_url();?>marketing/pilih_sekolah",
			method: "POST",
			data: {
				siag: $('#isiag').val(),
				npsn: $('#inpsn').val()
			},
			success: function (result) {
				if (result != "gagal") {
					window.location.reload();
				}
				else
				{
					alert ("GAGAL PROSES!");
				}
			}
		});
	}

	function terlaksana() {
		if (confirm("Apakah sudah terlaksana?"))
		{
			$.ajax({
				url: "<?php echo base_url();?>marketing/terlaksana",
				method: "POST",
				data: {
					siag: $('#isiag').val(),
					npsn: $('#inpsn').val()
				},
				success: function (result) {
					// alert (result);
					if (result != "gagal") {
						window.open('<?php echo base_url()."marketing";?>','_self');
					}
					else
					{
						alert ("PROSES GAGAL!");
					}
				}
			});
		}
	}


</script>
