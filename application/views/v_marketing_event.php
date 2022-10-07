<link href="<?php echo base_url(); ?>css/soal.css" rel="stylesheet">
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
if ($kodeevent!=null)
{
	foreach ($dafmarketing as $data)
	{
		$npsn = $data->npsn_sekolah;
		$namasekolah = $data->nama_sekolah;
		$linkvideo = $data->link_video;
		$nama_kota = $data->nama_kota;
		$thumbs = $data->thumbnail;
		$koderef = $data->kode_referal;
		$channel = $data->channel;
		$durjam = substr($data->durasi,0,2);
		$durjam = str_pad($durjam, 2, '0', STR_PAD_LEFT);
		$durmenit = substr($data->durasi,3,2);
		$durmenit = str_pad($durmenit, 2, '0', STR_PAD_LEFT);
		$durdetik = substr($data->durasi,6,2);
		$durdetik = str_pad($durdetik, 2, '0', STR_PAD_LEFT);
		$bulan = $data->bulan;
		$tahun = $data->tahun;
	}
}
else
{
	$npsn = "";
	$namasekolah = "";
	$linkvideo = "";
	$nama_kota = "";
	$thumbs = "";
	$koderef = "";
	$channel = "";
	$durjam = "";
	$durmenit = "";
	$durdetik = "";
}

// echo "<br><br><br><br><br><br>".$linkvideo;

?>

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
						<h1>Area Marketing</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">
				<center>
					<div style="font-size: 18px;font-weight: bold">EVENT MODUL SEKOLAH
					</div>
				</center>
				<div style='margin-top:15px; margin-bottom:15px;'>
				<button class="btn-main"
							onclick="window.open('<?php echo base_url() . 'marketing/daftar_event/' . $bulan.'/'.$tahun; ?>', '_self')">
						Kembali
				</button>
				</div>
				<hr>
				<div id="tempatsoal" class="container"
					 style="opacity:80%;padding-top:10px;padding-bottom:20px;color: black;">
					 <?php
					 $attributes = array('id' => 'myform1');
					 echo form_open('marketing/addevent', $attributes);
					?>
					 <div class="wb_LayoutGrid1">
						<div class="LayoutGrid1" style="border: solid 1px black;padding-bottom: 20px;">
							<div class="row">
								<div class="col-1">
									<center>
									
									<div style="font-size: 16px;padding-top:10px;">
											SEKOLAH
									</div>
										<hr style="margin-top: 10px;margin-bottom: 10px;">
									<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">NPSN
												<span style="color: red" id="npsnHasil"></span></label>
											<div style="max-width: 200px;margin:auto">
												<input type="text" class="form-control" id="inpsn" name="inpsn" maxlength="8"
													value="<?php echo $npsn; ?>" placeholder="">
											</div>
											<div id="dtombolcek" style="display:none; padding: 10px;">
												<button onclick="return ceknpsn();">CEK</button>
											</div>
										</div>
										<div class="form-group" id="ketsekolahbaru" style="display:none;">
											<div id="ketsekolah" style="font-weight:bold;color: #ff2222">Nomor kode salah atau belum
												terdaftar
											</div>
										</div>
										<div class="form-group" style="height: 60px;">
											<label for="inputDefault" class="col-md-12 control-label">Nama Sekolah/Lembaga</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="isekolah" name="isekolah"
													   maxlength="100"
													   value="<?php echo $namasekolah; ?>" placeholder="">
											</div>
										</div>
										<div class="form-group" id="dkotasekolah" style="display: <?php
										if ($nama_kota != "")
											echo "block";
										else
											echo "none"; ?>;">
											<label for="inputDefault" class="col-md-12 control-label">Kota</label>
											<div class="col-md-12" style="margin-bottom: 20px;">
												<input readonly type="text" class="form-control" id="ikotasekolah"
													   name="ikotasekolah"
													   maxlength="100"
													   value="<?php echo $nama_kota; ?>" placeholder="">
											</div>
										</div>
										
									</center>
								</div>
								
							</div>
						</div>
					</div>

					<br>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1" style="border: solid 1px black;padding-bottom: 20px;">
							<div class="row">
								<div class="col-1">
									<center>
										<div style="font-size: 16px;padding-top:10px;">
											EVENT UNTUK
										</div>
										<hr style="margin-top: 10px;margin-bottom: 10px;">
										<div class="form-group">
											<select style="height:32px;" name="ibulan" id="ibulan">
											<?php
												for ($a = 1; $a <= 12; $a++) {
													$selected = "";
													if ($a==$bulan)
														$selected = "selected";
													echo "<option ".$selected." value='" . $a . "'>" . nmbulan_panjang($a) . "</option>";
												}
												?>
											</select>
											<input type="number" name="itahun" id="itahun" min="2021" max="<?php echo (date("Y"))+1;?>" value="<?php echo $tahun; ?>">
										</div>
										

										<?php { ?>
					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Alamat URL Video</label>
						<div class="col-md-12">
							<textarea 
                                    rows="2" cols="40" class="form-control" id="ilink" name="ilink"
									maxlength="300"><?php echo $linkvideo; ?></textarea>
							<button style="margin-top:10px;" disabled="disabled" id="tbgetyutub" class="btn btn-default"
									onclick="return ambilinfoyutub()">OK
							</button>
							<br><br>
						</div>
					</div>

					<div class="form-group">
						<?php if ($kodeevent != null) { ?>
							<label for="inputDefault" class="col-md-12 control-label">Channel</label>
							<div id="get_channel">
								<input readonly style="text-align:center;display:inline;height:50px;margin:0;padding:0" type="text"
									   class="form-control inputan1" id="ichannel" name="ichannel" 
									   value="<?php echo $channel; ?>" placeholder="">
								<br><br>
							</div>
							<!-- <div class="col-md-12">
								<input readonly type="text" class="form-control" id="isekolah" name="isekolah"
										maxlength="100"
										value="<?php echo $namasekolah; ?>" placeholder="">
							</div> -->

							<label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
							<div class="col-md-12">
								<?php if ($thumbs == "") {
									if ($linkvideo == "") {
										?>
										<img id="img_thumb" style="align:middle;width:200px;"
											 src="<?php echo base_url(); ?>assets/images/blank.jpg">
									<?php } else {
										?>
										<img id="img_thumb" style="align:middle;width:200px;"
											 src="https://img.youtube.com/vi/<?php
											 echo substr($linkvideo, 32, 11); ?>/0.jpg">
									<?php } ?>
								<?php } else { ?>
									<img id="img_thumb" style="align:middle;width:200px;"
										 src="<?php echo $thumbs; ?>">
								<?php } ?>

								<!--                                &nbsp;<button class="btn btn-default" onclick="return upload()">Upload Thumbnail-->
								<!--                                </button>-->

								<br><br>
							</div>

							<label for="inputDefault" class="col-md-12 control-label">Durasi (Jam:Menit:Detik)</label>
							<div id="get_durasi" class="col-md-12">
								<input <?php
								if ($kodeevent != null) {
									 {
										echo 'readonly';
									}
								} ?> style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
									 class="form-control inputan1" id="idurjam" name="idurjam" maxlength="2"
									 value="<?php echo $durjam; ?>" placeholder="--">
								:
								<input <?php
								if ($kodeevent != null) {
									 {
										echo 'readonly';
									}
								} ?> style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
									 class="form-control inputan1" id="idurmenit" name="idurmenit" maxlength="2"
									 value="<?php echo $durmenit; ?>" placeholder="--">
								:
								<input <?php
								if ($kodeevent != null) {
									 {
										echo 'readonly';
									}
								} ?> style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
									 class="form-control inputan1" id="idurdetik" name="idurdetik" maxlength="2"
									 value="<?php echo $durdetik; ?>" placeholder="--">
							</div>
						<?php } else { ?>

						<label for="inputDefault" class="col-md-12 control-label">Channel</label>
						<div id="get_channel" class="col-md-12">
							<input readonly style="display:inline;height:50px;margin:0;padding:0" type="text"
								   class="form-control inputan1" id="ichannel" name="ichannel" maxlength=""
								   value="" placeholder="">
							<br><br>
						</div>

							<label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
							<div class="col-md-12">
								<img id="img_thumb" style="align:middle;width:200px;"
									 src="<?php echo base_url(); ?>assets/images/blank.jpg">
								<!--					&nbsp;<button class="btn btn-default" onclick="return upload()">Upload Thumbnail</button>-->

								<br><br>
							</div>

							<label for="inputDefault" class="col-md-12 control-label">Durasi (Jam:Menit:Detik)</label>
							<div id="get_durasi" class="col-md-12">
								<input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
									   class="form-control inputan1" id="idurjam" name="idurjam" maxlength="2"
									   value="--" placeholder="--">
								:
								<input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
									   class="form-control inputan1" id="idurmenit" name="idurmenit" maxlength="2"
									   value="--" placeholder="--">
								:
								<input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
									   class="form-control inputan1" id="idurdetik" name="idurdetik" maxlength="2"
									   value="--" placeholder="--">
								<br><br>
							</div>

						<?php }
						}
						?>

						<!-- <?php //echo "ADDEDIT:".$addedit; ?> -->

						
						

						<input type="hidden" id="kode_referal" name="kode_referal" value="<?php echo $koderef;?>"/>
						<input type="hidden" id="kodeevent" name="kodeevent" value="<?php
						if (isset($kodeevent)) echo $kodeevent; ?>"/>

						<input type="hidden" id="id_user" name="id_user" value=""/>
						<input type="hidden" id="ichannelid" name="ichannelid" value=""/>
						<input type="hidden" id="ytube_duration" name="ytube_duration" value=""/>
						<input type="hidden" id="ytube_thumbnail" name="ytube_thumbnail" value=""/>

						<input type="hidden" id="filevideo" name="filevideo"
							   value="<?php if ($kodeevent != null) echo $linkvideo; else echo ''; ?>"/>
						<input type="hidden" id="idyoutube" name="idyoutube" value=""/>

						<div class="form-group" id="ketevent" style="display:none;">
							<div style="font-weight:bold;color: #ff2222">Event bulan tersebut sudah tersedia!
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-10 col-md-offset-0">
								<br>
								<button type="submit" class="btn btn-info" onclick="return cekaddvideo()"><?php
									if ($kodeevent != null) echo 'Update'; else echo 'Simpan' ?></button>
							</div>
						</div>
					</div>
										
										</div>
									</center>
								</div>
							</div>
						</div>
					</div>
					<?php
					echo form_close() . '';
					?>
				</div>
			</div>
		</div>
	</section>
</div>

<script>

$(document).ready(function () {
		$('#ilink').on('input', (event) => {
			if (document.getElementById("ilink").value != "") {
				document.getElementById("tbgetyutub").disabled = false;
			} else {
				document.getElementById("tbgetyutub").disabled = true;
			}
			document.getElementById("idurjam").value = "--";
			document.getElementById("idurmenit").value = "--";
			document.getElementById("idurdetik").value = "--";
			document.getElementById("img_thumb").src = "<?php echo base_url();?>assets/images/blank.jpg";
		});
	});

	function ambilinfoyutub() {
		idyutub = youtube_parser($("#ilink").val());
		$('#idyutube').val(idyutub);
		var filethumb = "https://img.youtube.com/vi/" + idyutub + "/0.jpg";
		$('#ytube_thumbnail').val(filethumb);

		$.ajax({
			url: '<?php echo base_url();?>video/getVideoInfo/' + idyutub,
			type: 'GET',
			dataType: 'json',
			data: {
			},
			success: function (text) {
				if (text.durasi == "") {
					alert("Periksa alamat link YouTube");
					ambiljam = "--";
					ambilmenit = "--";
					ambildetik = "--"
				} 
				// else if (text.ket=="sudahpernah"){
				// 	alert ("Alamat ini sudah pernah diinput. Silakan masukkan alamat lain.");
				// }
				else {
					$("#img_thumb").attr("src", filethumb);
					ambiljam = text.durasi.substr(0, 2);
					ambilmenit = text.durasi.substr(3, 2);
					ambildetik = text.durasi.substr(6, 2);
					$('#ichannelid').val(text.channelid);


					html01 = '<input readonly="true" style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
						'class="form-control inputan1" id="idurjam" name="idurjam" maxlength="2" value="' + ambiljam + '" placeholder="00"> : ' +
						'<input readonly="true" style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
						'class="form-control inputan1" id="idurmenit" name="idurmenit" maxlength="2" value="' + ambilmenit + '" placeholder="00"> : ' +
						'<input readonly="true" style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
						'class="form-control inputan1" id="idurdetik" name="idurdetik" maxlength="2" value="' + ambildetik + '" placeholder="00">';

					html02 = '<input readonly="true" style="display:inline;width:250px;height:50px;margin:0;padding:0" type="text" '+
								   'class="form-control inputan1" id="ichannel" name="ichannel" maxlength="" '+
								   'value="'+text.channeltitle+'" placeholder=""><br><br>'
					$('#ytube_duration').val(html01);
					$('#get_durasi').html(html01);
					$('#get_channel').html(html02);
				}

			}
		});
		return false;
	}

	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	$(document).on('change', '#inpsn', function () {
		var objRegExp = /^[+0-9\s]+$/;
		if (objRegExp.test($('#inpsn').val()) && $('#inpsn').val().length >= 8) {
			$('#npsnHasil').html("");
		} else {
			$('#npsnHasil').html("* 8 digit angka");
			document.getElementById('ketsekolahbaru').style.display = "none";
		}
	});

	$(document).on('change input', '#inpsn', function () {
		document.getElementById('ketsekolahbaru').style.display = "none";
		$('#dtombolcek').show();
	});

	function ceknpsn() {
		//alert ($('#inpsn').val());
		$('#dtombolcek').hide();
		if ($('#inpsn').val() != "") {
			$.ajax({
				type: 'POST',
				data: {npsn: $('#inpsn').val()},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>marketing/ceksasarandanrev',
				success: function (result) {
					if (result.nama_sekolah != "gaknemu") {
						
						// isihtml2 = "";
						$('#isekolah').prop('readonly', true);
						$('#isekolah').val("");
						$('#isekolah').focus();
						$.each(result, function (i, result) {
							//alert (result.nama_sekolah);
							if (!result.nama_sekolah == "") {
								if (result.nama_kota == "")
									$('#dkotasekolah').hide();
								else
									$('#dkotasekolah').show();
								$('#isekolah').prop('readonly', true);
								$('#isekolah').val(result.nama_sekolah);
								$('#kode_referal').val(result.kode_referal);
								$('#ikotasekolah').val(result.nama_kota);
								$('#dtombolok').html('<button onclick="pilihsekolah()" class="btn-info">OK</button>');
								//alert(result.nama_sekolah);
								document.getElementById('ketsekolahbaru').style.display = "none";

							} else {
								if ($('#npsnHasil').html() == "") {
									$('#dtombolok').html('');
									document.getElementById('ketsekolahbaru').style.display = "block";
								}
							}


							//alert (result.nama_sekolah);
							// 	isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota + "</option>";
						});
						// $('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
						return false;
					}
					else
					{
						alert ("Belum ke Sekolah ini!");
					}
				}
			});
		}
		return false;
	}

	function cekevent() {
		// alert ($('#ibulan').val());
		var bulan0 = <?php echo $bulan;?>;
		var tahun0 = <?php echo $tahun;?>;

		<?php if ($kodeevent!=null) { ?>
			var addedit = "edit";
		<?php }
		else
		{ ?>
			var addedit = "add";
		<?php }
		?>


		if (bulan0 == $('#ibulan').val() && tahun0 == $('#itahun').val() && addedit=="edit")
		{
			siapjalan = "oke";
		}
		else
		{
			siapjalan = "gak";
		}
		
		$('#dtombolcek').hide();
		if ($('#inpsn').val() != "") {
			$.ajax({
				type: 'POST',
				data: {npsn: $('#inpsn').val(), koderef: '<?php echo $koderef;?>', 
					ibulan: $('#ibulan').val(), itahun: $('#itahun').val()},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>marketing/ceksasarandanrevdanbulan',
				success: function (result) {
					// alert("NAH INI:")+result.nama_sekolah;
					if (result.nama_sekolah != "gaknemu" && siapjalan=="gak") {
						document.getElementById('ketevent').style.display = "block";
						var idtampil = setInterval(klirket, 3000);

						function klirket() {
							clearInterval(idtampil);
							document.getElementById('ketevent').style.display = "none";
						}
						return false;
					}
					else
					{
						document.getElementById('myform1').submit();
					}
				}
			});
		}
		return false;
	}

	function cekaddvideo() {
		var oke1 = 1;
		var oke2 = 1;

		if ($('#isekolah').val() == "" || $('#ichannel').val() == "") {
			oke2 = 0;
			//  alert ("s5");
		}

		if ($('#idurjam').val() == "--") {
			oke2 = 0;
			// alert ("wedus");
		}

		
		// if ($('#ytube_duration').val() == "") {
		// 	oke2 = 0;
		// 	// alert ("s6");
		// }


		if (oke1 == 1 && oke2 == 1) {

			var retVal = confirm("Dengan ini Anda menyatakan bahwa isi video ini tidak melanggar hukum!");
			if (retVal == true) {
				// document.write ("User wants to continue!");
				cekevent();
				return false;
			} else {
				//document.write ("User does not want to continue!");
				return false;
			}
		} else {
			if (oke1 == 0 || oke2 == 0)
				alert("Semua Data harus dilengkapi");
			return false;
		}
	}




</script>
