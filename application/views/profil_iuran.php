<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<style>

.bgtoken {
  background-image: url("../assets/images/thumbx.png");
  background-repeat: no-repeat;
  background-size: 100%;
  padding: 10px;
  margin: auto;
}
</style>

<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish/pay1">
	<input type="hidden" name="result_type" id="result-type" value="">
	<input type="hidden" name="result_data" id="result-data" value="">
</form>

<!-- dashboard inner -->
<div class="midde_cont">
	<div class="container-fluid">
		<div class="row column_title">
			<div class="col-md-12">
				<div class="page_title">
					<h2>Pembayaran</h2>
				</div>
			</div>
		</div>
		<!-- row -->
		<div class="row column2 graph">
			<div class="col-md-l2 col-lg-12">
				<div class="white_shd full">
					<div class="full graph_head">
						<div class="heading1 margin_0"
						">
						<h2><?php echo $keteranganbayar; ?></h2>
						<?php if ($keteranganbayartunggu != "") { ?>
							<br>
							<hr><h2><?php echo $keteranganbayartunggu; ?></h2>
						<?php }
						?>
					</div>
				</div>

				<div class="full price_table padding_infor_info">
					<div class="row">
						<!-- user profile section -->
						<!-- profile image -->
						<div class="row column4">
							<?php if ($status_tunggu == "tunggu") { ?>
								<div class="col-lg-12 col-md-12 margin_bottom_30">
									<div class="dash_blog" style="margin: auto;">
										<div class="dash_blog_inner">
											<div class="dash_head">
												<center><h3><span
															style="font-size: 17px;">ORDER ID:<br><?php echo $orderid; ?></span>
													</h3></center>
											</div>
											<div class="list_cont" style="font-size: 16px;">
												Segera lakukan pembayaran sebesar <b>Rp <?php
													echo number_format($totaltagihan, 0, ',', '.'); ?>,-</b>
												sebelum:<br>
												tanggal <?php echo $batasbayar; ?>
												<br>
												<center><?php echo $keteranganbayar2 . "<br>" . $keteranganbayar3 .
														"<br><a href='#' class='myButton1' onclick='return petunjukpembayaran()'>Petunjuk Pembayaran</a><br>".
														"<br><a href='#' class='myButton2' onclick='return gantibayar()'>Batalkan Pembayaran</a>"; ?>
												</center>
											</div>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<?php if ($status_verifikator != "oke") { ?>
									<div class="col-md-6 margin_bottom_30">
										<div class="dash_blog">
											<div class="dash_blog_inner">
												<div class="dash_head">
													<h3><span><i class="fa fa-dollar"></i> Pembayaran Ekskul Majalah Dinding TV Kampus (Lite)</span>
													</h3>
													Lite dapat 3 siswa ekskul gratis
												</div>
												<div class="list_cont">
													Untuk keterlambatan pembayaran hingga 2 bulan atau lebih akan
													terkena biaya tambahan
													reaktivasi sebesar Rp <?php
													echo number_format($biayareaktivasi, 0, ',', '.'); ?>,-<br>
												</div>
												<div class="task_list_main">
													<ul class="task_list">
														<a href="#" onclick="return klikbayar(1);">
															<li>Bayar 1 Bulan<br><strong>Rp <?php
																	echo number_format($iuranstandar1, 0, ',', '.');
																	?>,-</strong>
															</li>
														</a>
														<a href="#" onclick="return klikbayar(2);">
															<li>Bayar 3 Bulan<br><strong>Rp
																	<?php
																	echo number_format($iuranstandar2, 0, ',', '.');
																	?>,-</strong></li>
														</a>
														<a href="#" onclick="return klikbayar(3);">
															<li>Bayar 6 Bulan<br><strong>Rp
																	<?php
																	echo number_format($iuranstandar3, 0, ',', '.');
																	?>,-</strong></li>
														</a>
														<a href="#" onclick="return klikbayar(4);">
															<li>Bayar 12 Bulan<br><strong>Rp <?php
																	echo number_format($iuranstandar4, 0, ',', '.');
																	?>,-</strong>
															</li>
														</a>
													</ul>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>

								<?php if ($lunas == false || $keteranganpro != "") { ?>
									<div class="col-md-6 margin_bottom_30">
										<div class="dash_blog">
											<div class="dash_blog_inner">
												<div class="dash_head" style="word-break: keep-all">
													<h3><span><i class="fa fa-dollar"></i> Pembayaran Ekskul Majalah Dinding  (Pro)</span>
													</h3>
													Pro dapat 10 siswa ekskul gratis
												</div>
												<?php if ($keteranganpro == "") { ?>
													<div class="list_cont" style="display: none;">
														<ol>
															<li>Sekolah Pro berarti sekolah ini mendapatkan kuota
																Kelas Virtual Paket Pro sebanyak 100 siswa (Rp
																3.000,-/siswa).
															</li>
														</ol>
													</div>
													<div class="task_list_main">
														<ul class="task_list">
															<a href="#" onclick="return klikbayarpro(1);">
																<li>Bayar 1 Bulan<br><strong>Rp <?php
																		echo number_format($iuranpro1, 0, ',', '.');
																		?>,-</strong>
																</li>
															</a>
															<a href="#" onclick="return klikbayarpro(2);">
																<li>Bayar 3 Bulan<br><strong>Rp
																		<?php
																		echo number_format($iuranpro2, 0, ',', '.');
																		?>,-</strong></li>
															</a>
															<a href="#" onclick="return klikbayarpro(3);">
																<li>Bayar 6 Bulan<br><strong>Rp
																		<?php
																		echo number_format($iuranpro3, 0, ',', '.');
																		?>,-</strong></li>
															</a>
															<a href="#" onclick="return klikbayarpro(4);">
																<li>Bayar 12 Bulan<br><strong>Rp <?php
																		echo number_format($iuranpro4, 0, ',', '.');
																		?>,-</strong>
																</li>
															</a>
														</ul>
													</div>
												<?php } else { ?>
													<div class="list_cont" style="font-size: 18px;color: black;">
														<b><?php echo $keteranganpro; ?></b>
													</div>
												<?php }
												?>
											</div>
										</div>
									</div>

								<?php } ?>

								<?php if ($lunas == false || $keteranganpremium != "") { ?>
									<div class="col-md-6 margin_bottom_30">
										<div class="dash_blog">
											<div class="dash_blog_inner">
												<div class="dash_head">
													<h3><span><i
																class="fa fa-dollar"></i> Pembayaran Ekskul Majalah Dinding  (Premium)</span>
													</h3>
													<ul>
														<li>
															Premium semua siswa ekskul gratis
														</li>
													</ul>
												</div>
												<?php if ($keteranganpremium == "") { ?>
													<div class="list_cont" style="display: none;">
														<ol>
															<li>Sekolah Pro berarti sekolah ini mendapatkan gratis 
																Kelas Virtual Paket Pro.
															</li>
															<li>Sekolah Premium berarti sekolah mendapatkan gratis 
																Kelas Virtual Paket Premium.
															</li>
														</ol>
													</div>
													<div class="task_list_main">
														<ul class="task_list">
															<a href="#" onclick="return klikbayarpremium(1);">
																<li>Bayar 1 Bulan<br><strong>Rp <?php
																		echo number_format($iuranpremium1, 0, ',', '.');
																		?>,-</strong>
																</li>
															</a>
															<a href="#" onclick="return klikbayarpremium(2);">
																<li>Bayar 3 Bulan<br><strong>Rp
																		<?php
																		echo number_format($iuranpremium2, 0, ',', '.');
																		?>,-</strong></li>
															</a>
															<a href="#" onclick="return klikbayarpremium(3);">
																<li>Bayar 6 Bulan<br><strong>Rp
																		<?php
																		echo number_format($iuranpremium3, 0, ',', '.');
																		?>,-</strong></li>
															</a>
															<a href="#" onclick="return klikbayarpremium(4);">
																<li>Bayar 12 Bulan<br><strong>Rp <?php
																		echo number_format($iuranpremium4, 0, ',', '.');
																		?>,-</strong>
																</li>
															</a>
														</ul>
													</div>
												<?php } else { ?>
													<div class="list_cont" style="font-size: 18px;color: black;">
														<b><?php echo $keteranganpremium; ?></b>
													</div>
												<?php }
												?>
											</div>
										</div>
									</div>

								<?php } ?>

								<?php if ($keterangansiplah == "") { ?>
									<div class="col-md-6 margin_bottom_30">
										<div class="dash_blog">
											<div class="dash_blog_inner">
												<div class="dash_head">
													<h3><span><i class="fa fa-dollar"></i> Pembayaran Ekskul Majalah Dinding TV Kampus melalui SIPLah</span>
													</h3>
													<ul>
														<li>
															Lite dapat 3 siswa ekskul gratis
														</li>
														<li>
															Pro dapat 10 siswa ekskul gratis
														</li>
														<li>
															Premium semua siswa ekskul gratis
														</li>
													</ul>
												</div>
												<!-- <div class="list_cont">
													Untuk pembayaran melalui Siplah, sekolah akan mendapatkan cashback
													sebesar 40%
												</div> -->
												<div class="task_list_main">
													<ul class="task_list">
														<li>
															<div style='margin-bottom:10px;'>Pastikan pembelian ini telah diajukan di sistem ARKAS.</div>
															<button onclick="siplah1();" style="margin-bottom:3px;background-color: #deffde;padding-left: 10px;padding-right: 10px;">Lite 3 bulan</button>
															<button onclick="siplah2();" style="margin-bottom:3px;background-color: #d0eeff;padding-left: 10px;padding-right: 10px;">Pro 3 bulan</button>
															<button onclick="siplah3();" style="margin-bottom:3px;background-color: #d2ddff;padding-left: 10px;padding-right: 10px;">Premium 3 bulan</button>
														</li>
														<li>
															<?php if ($siplahkonfirm == 0)
																echo "Unggah foto Surat Pemesanan dari SIPLah";
															else if ($siplahkonfirm == 1)
																echo "Menunggu konfirmasi Surat Pemesanan SIPLah";
															else if ($siplahkonfirm == 2)
																echo "Surat Pemesanan Siplah sudah OK";
															else if ($siplahkonfirm == 3)
																echo "<span style='color:red;font-size:18px;'><b>Bukti Surat Pemesanan SIPLah TIDAK VALID. Silakan unggah bukti lain.</b></span>"; ?>
															<div class="form-group">
																<div
																	style="margin-left:0px;margin-top:10px;max-width: 200px;height: auto;">
																	<?php
																	if ($buktisiplah == "")
																		$buktisiplah = base_url() . "assets/images/siplah_blank.png";
																	else {
																		$buktisiplah = base_url() . "uploads/siplah/" . $buktisiplah;
																	}

																	?>
																	<table
																		style="max-width:200px;margin-left:5px;margin-bottom:0px;border: 1px solid black;">
																		<tr>
																			<th>
																				<img id="previewing" width="100%"
																					 src="<?php echo $buktisiplah . '?' . time(); ?>">
																			</th>
																		</tr>

																	</table>


																	<form method="POST" enctype="multipart/form-data"
																		  id="fileUploadForm">
																	</form>

																	<?php if ($siplahkonfirm != 2) { ?>
																		<form class="form-horizontal" id="submit">
																			<div class="form-group"
																				 style="margin-left: 5px;margin-top:10px;">
																				<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
																				<input type="file" name="file" id="file"
																					   accept="image/*">

																				<button id="btn_upload" type="submit"
																						style="margin-top: 5px;padding-left: 10px;padding-right: 10px;">
																					Unggah
																				</button>
																				<div class="progress"
																					 style="display:none">
																					<div id="progressBar"
																						 class="progress-bar progress-bar-striped active"
																						 role="progressbar"
																						 aria-valuenow="0"
																						 aria-valuemin="0"
																						 aria-valuemax="100"
																						 style="width: 0%">
																						<span class="sr-only">0%</span>
																					</div>
																				</div>
																			</div>
																		</form>
																	<?php } ?>

																</div>
																<span style="margin-left: 5px" id="message"></span>
																<h4 style="display: none;" id='loading'>uploading... </h4>

															</div>
														</li>
														<?php if ($siplahkonfirm==2) { ?>
															<li>
															Berikut ini bisa dijadikan sebagai bukti barang telah diterima untuk diunggah ke SIPLah.<br>
															<div id="tokensiplah" class="bgtoken">
																<center>
																	<b><?php echo $namasekolah;?></b>
																	<hr style="margin-top:5px;margin-bottom:5px;">
																</center>
															Token : <span style='font-weight:bold';><?php echo $token;?></span><br>

															Jenis Paket : <?php echo $namapaket;?><br>
															Jangka Waktu : <?php echo $lamabulan;?> bulan<br>
															Berlaku hingga : <?php echo namabulan_panjang($tglberakhir);?><br>
															<br><br>
															</div>
															<button onclick="DownloadImage();" style="margin-bottom:3px;background-color: #FFE536;
															padding-left: 10px;padding-right: 10px;">Download & Aktifkan</button>
															</li>
															<?php } ?>
													</ul>
												</div>
											</div>
										</div>
									</div>
								<?php } else { ?>

									<div class="col-md-6 margin_bottom_30">
										<div class="dash_blog">
											<div class="dash_blog_inner">
												<div class="dash_head">
													<h3><span><i class="fa fa-dollar"></i> Pembayaran Ekskul Majalah Dinding TV Kampus melalui Siplah</span>
													</h3>
													<ul>
														<li>
															Lite dapat 3 siswa ekskul gratis
														</li>
														<li>
															Pro dapat 10 siswa ekskul gratis
														</li>
														<li>
															Premium semua siswa ekskul gratis
														</li>
													</ul>
												</div>
												<!-- <div class="list_cont">
													Untuk pembayaran melalui Siplah, sekolah akan mendapatkan cashback
													sebesar 40%
												</div> -->
												<div class="task_list_main">
													<ul class="task_list">
														<li>
															<span style="color:black;font-size: 18px;"><b><?php
																	echo $keterangansiplah;?></b></span>
																	<br><i> <?php echo $keterangansiplah2;?></i>
														</li>
														<?php if ($siplahkonfirm==4) { ?>
													<li>
												<div style="margin-top:20px;" id="tokensiplah" class="bgtoken">
													<center>
														<b><?php echo $namasekolah;?></b>
														<hr style="margin-top:5px;margin-bottom:5px;">
													</center>
												Token : <span style='font-weight:bold';><?php echo $token;?></span><br>

												Jenis Paket : <?php echo $namapaket;?><br>
												Jangka Waktu : <?php echo $lamabulan;?> bulan<br>
												Berlaku hingga : <?php echo namabulan_panjang($tglberakhir);?><br>
												<br><br>
												</div>
												<button onclick="DownloadImage();" style="margin-bottom:3px;background-color: #FFE536;
												padding-left: 10px;padding-right: 10px;">Download</button>
												</li>
												<?php } ?>
													</ul>
												</div>
												
											</div>
										</div>
									</div>
								<?php } ?>

								<!--									<div class="col-md-6 margin_bottom_30">-->
								<!--										<div class="dash_blog">-->
								<!--											<div class="dash_blog_inner">-->
								<!--												<div class="dash_head">-->
								<!--													<h3><span><i class="fa fa-dollar"></i> Iuran Ekstrakurikuler oleh Sekolah</span>-->
								<!--													</h3>-->
								<!--												</div>-->
								<!--												--><?php //if ($tagihekskul == "true") { ?>
								<!--													<div class="list_cont">-->
								<!--														Pembayaran iuran kegiatan ekstrakurikuler oleh sekolah-->
								<!--														sehingga peserta didik tidak perlu membayar.<br>-->
								<!--														Pembayaran ini termasuk mengaktifkan verifikator.-->
								<!--													</div>-->
								<!--													<div class="task_list_main">-->
								<!--														<ul class="task_list">-->
								<!--															<a href="#" onclick="return klikbayareks(1);">-->
								<!--																<li>Bayar 1 Bulan<br><strong>Rp --><?php
//																		echo number_format($iuranekskulver, 0, ',', '.');
//																		?><!--,-</strong>-->
								<!--																</li>-->
								<!--															</a>-->
								<!--															<a href="#" onclick="return klikbayareks(2);">-->
								<!--																<li>Bayar 3 Bulan<br><strong>Rp-->
								<!--																		--><?php
//																		echo number_format($iuranekskulver * 3, 0, ',', '.');
//																		?><!--,-</strong></li>-->
								<!--															</a>-->
								<!--															<a href="#" onclick="return klikbayareks(3);">-->
								<!--																<li>Bayar 6 Bulan<br><strong>Rp --><?php
//																		echo number_format($iuranekskulver * 6, 0, ',', '.');
//																		?><!--,-</strong>-->
								<!--																</li>-->
								<!--															</a>-->
								<!--															<a href="#" onclick="return klikbayareks(4);">-->
								<!--																<li>Bayar 12 Bulan<br><strong>Rp --><?php
//																		echo number_format($iuranekskulver * 12, 0, ',', '.');
//																		?><!--,-</strong>-->
								<!--																</li>-->
								<!--															</a>-->
								<!--														</ul>-->
								<!--													</div>-->
								<!--												--><?php //} else { ?>
								<!--													<div class="list_cont" style="font-size: 18px;color: black;">-->
								<!--														<b>--><?php //echo $keteranganekskul; ?><!--</b>-->
								<!--													</div>-->
								<!--												--><?php //} ?>
								<!--											</div>-->
								<!--										</div>-->
								<!--									</div>-->


								<?php if ($status_verifikator != "oke") { ?>
									<div class="col-md-6">
										<div class="dash_blog">
											<div class="dash_blog_inner">
												<div class="dash_head">
													<h3><span><i
																class="fa fa-dollar"></i> Bebas Pembayaran Ekskul Majalah Dinding TV Kampus (Lite)</span>
													</h3>
												</div>
												<?php if ($jmlpro==0 || $jmlpremium==0 || $jmlekskul==0)
													{ ?>
														<div class="list_cont">
															<h4>Sekolah aktif sebagai Sekolah Lite</h4>
														</div>
													<?php }
													else
													{ ?>
														<div class="list_cont">
															Sekolah akan mendapatkan bebas pembayaran (lite) dengan ketentuan sebagai
															berikut:
														</div>
														<div class="task_list_main">
															<ul class="task_list">
																<li><a href="#">Jika ada 10 siswa ikut Kelas Virtual
																		Pro, gratis pembayaran bulan
																		ini</a><br><strong>Kurang <?php echo $jmlpro; ?>
																		anak</strong></li>
																<li><a href="#">Jika ada 1 siswa ikut Kelas Virtual
																		Premium, gratis pembayaran bulan
																		ini</a><br><strong>Kurang <?php echo $jmlpremium; ?>
																		anak</strong></li>
																<li>
																	<a href="<?php echo base_url() . 'ekskul/daftar_bayar_verifikator/profil'; ?>">Jika
																		ada 3 siswa ikut Ekstrakurikuler, gratis pembayaran bulan
																		ini</a><br><strong>Kurang <?php echo $jmlekskul; ?>
																		anak</strong></li>
															</ul>
														</div>
													<?php } ?>
											</div>
										</div>
									</div>

								<?php }
							} ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
		<!-- end row -->
	</div>
	<!-- footer -->
	<div class="container-fluid">
		<div class="footer">
			<p>© Copyright 2021 - TV Kampus. All rights reserved.</p>
		</div>
	</div>
</div>
<!-- end dashboard inner -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-alpha1/html2canvas.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
<script type="text/javascript">

	$("#file").change(function () {
		$("#message").empty(); // To remove the previous error message
		var file = this.files[0];
		var imagefile = file.type;
		var match = ["image/jpeg", "image/png", "image/jpg"];
		if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
			// $('#previewing').attr('src','noimage.png');
			$("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
			return false;
		} else {
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
		}
		return false;
	});

	function imageIsLoaded(e) {
		idx = "";
		$("#file" + idx).css("color", "green");
		// $('#image_preview' + idx).css("display", "block");
		$('#previewing' + idx).attr('src', e.target.result);
		$('#previewing' + idx).attr('width', '100%');
		$('#previewing' + idx).attr('height', 'auto');
		return false;
	};

	$('#submit').submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>profil/upload_buktisiplah',
			type: "post",
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			success: function (data) {
				$('#loading').hide();
				$("#message").html(data);
				var idtampil2 = setInterval(klirket, 3000);
				
				function klirket(){
					clearInterval(idtampil2);
					location.reload();
				}
			}
		});
		return false;
	});





	<?php if ($status_verifikator != "oke" || $lunas == false) { ?>
	var bayardiklik = false;

	function klikbayar(kode) {
		// event.preventDefault();
		if (bayardiklik == false) {
			bayardiklik = true;

			setTimeout(() => {
				bayardiklik = false;
			}, 5000);

			$.ajax({
				url: '<?php echo base_url();?>payment/token/' + kode,
				cache: false,

				success: function (data) {
					//location = data;

					// console.log('token = ' + data);

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
					return false;
				},
				error: function (data) {
					return false;
				}
			});
		}


		return false;
	};

	function klikbayareks(kode) {
		// event.preventDefault();
		if (bayardiklik == false) {
			bayardiklik = true;

			setTimeout(() => {
				bayardiklik = false;
			}, 5000);

			$.ajax({
				url: '<?php echo base_url();?>payment/token_ekskul_ver/' + kode,
				cache: false,

				success: function (data) {
					//location = data;

					// console.log('token = ' + data);

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
					return false;
				},
				error: function (data) {
					return false;
				}
			});
		}


		return false;
	};

	function klikbayarpro(kode) {
		// event.preventDefault();
		if (bayardiklik == false) {
			bayardiklik = true;

			setTimeout(() => {
				bayardiklik = false;
			}, 5000);

			$.ajax({
				url: '<?php echo base_url();?>payment/token_pro/' + kode,
				cache: false,

				success: function (data) {

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
					return false;
				},
				error: function (data) {
					return false;
				}
			});
		}
		return false;
	};

	function klikbayarpremium(kode) {
		// event.preventDefault();
		if (bayardiklik == false) {
			bayardiklik = true;

			setTimeout(() => {
				bayardiklik = false;
			}, 5000);

			$.ajax({
				url: '<?php echo base_url();?>payment/token_premium/' + kode,
				cache: false,

				success: function (data) {

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
					return false;
				},
				error: function (data) {
					return false;
				}
			});
		}
		return false;
	};

	<?php } ?>

	<?php if ($status_tunggu == "tunggu") { ?>
	function gantibayar() {
		if (confirm("Yakin membatalkan pembayaran?")) {
			window.open("<?php echo base_url() . 'payment/ganticarabayar/' . $orderid.'/profil';?>", "_self");
			return false;
		}
	}
	<?php } ?>

	function siplah1() {
		window.open("https://siplah.innolaku.id/produk/STSE-0001-00008/ekskul-majalah-dinding-elektronik-tvsekolah-lite-3-bulan", "_blank");
		return false;
	}

	function siplah2() {
		window.open("https://siplah.innolaku.id/produk/STSE-0001-00009/ekskul-majalah-dinding-elektronik-tvsekolah-pro-3-bulan", "_blank");
		return false;
	}

	function siplah3() {
		window.open("https://siplah.innolaku.id/produk/STSE-0001-00010/ekskul-majalah-dinding-elektronik-tvsekolah-premium-3-bulan", "_blank");
		return false;
	}

	//DownloadImage();

	// function downloadURI(uri, name) {
	// 	var link = document.createElement("a");

	// 	link.download = name;
	// 	link.href = uri;
	// 	document.body.appendChild(link);
	// 	link.click();
	// 	clearDynamicLink(link); 
	// }

	// function DownloadAsImage() {
	// 	var element = $("#tokensiplah")[0];
	// 	html2canvas(element).then(function (canvas) {
	// 		var myImage = canvas.toDataURL();
	// 		downloadURI(myImage, "downloadtoken.png");
	// 	});
	// 	return false;
	// }

	<?php if ($siplahkonfirm==2 || $siplahkonfirm==4) { ?>
	function DownloadImage(){
		html2canvas($("#tokensiplah"), {
			scale: 5,
			onrendered: function(canvas) {
			canvas.toBlob(function(blob) {
					saveAs(blob, "Dashboard.png"); 
				});
			}
		});

		<?php if ($siplahkonfirm==2) { ?>
		$.ajax({
            url: "<?php echo base_url();?>profil/aktifkantoken",
            method: "POST",
            data: {},
            success: function (result) {
                window.location.reload();
                //detik2=0;
            }
        });
		<?php } ?>
		return false;
	};

	<?php } ?>

	function petunjukpembayaran() {
		window.open("<?php echo $petunjuk; ?>", "_blank");
		return false;
	}

</script>
